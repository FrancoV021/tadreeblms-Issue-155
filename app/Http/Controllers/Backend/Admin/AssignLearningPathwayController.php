<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LearningPathway;
use App\Models\LearningPathwayCourse;
use App\Models\UserLearningPathway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class AssignLearningPathwayController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LearningPathway::query();

            $data = $data->select('id', 'title', 'description')->latest();
            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $request->search['value'] != '') {
                        $searchValue = $request->search['value'];

                        // Apply search query to the database
                        $query->where('title', 'LIKE', '%' . $searchValue . '%');
                    }
                })
                ->make();
        }
        return view('backend.assign-learning-pathway.index');
    }

    public function create()
    {
        $courses = Course::select('id', 'title')->get();
        return view('backend.assign-learning-pathway.create', compact('courses'));
    }

    public function store(Request $request)
    {
        try {
            // Start the transaction
            DB::beginTransaction();

            // Validate request data
            $validated = $request->validate([
                'title' => [
                    'required',
                    'max:255',
                    'unique:learning_pathways,title', // Add the table name to 'unique'
                ],
                'course_id' => 'required|exists:courses,id',
                'description' => 'nullable|max:2000',
            ], [
                'course_id.required' => 'Please select atleast one course for the pathway'
            ]);

            // Create Learning Pathway
            $lp = LearningPathway::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
            ]);

            $course_with_order = json_decode($request->course_with_order);

            // Create Learning Pathway Course
            foreach ($course_with_order as $key => $value) {
                LearningPathwayCourse::create([
                    'pathway_id' => $lp->id,
                    'course_id' => $value,
                    'position' => $key + 1,
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => "$lp->title learning pathway created successfully",
                'redirect_route' => '/user/learning-pathways'
            ]);
        } catch (ValidationException $e) {
            // Rollback the transaction in case of validation error
            DB::rollBack();

            // Return validation errors
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(), // Returns detailed validation errors
            ], 422);
        } catch (\Exception $e) {
            // Rollback the transaction for any other exceptions
            DB::rollBack();

            // Return generic error response
            return response()->json([
                'message' => 'Failed to create learning pathway',
            ], 500);
        }
    }

    public function edit($id)
    {
        $lp = LearningPathway::find($id);
        $courses = Course::select('id', 'title')->get();
        return view('backend.assign-learning-pathway.edit', compact('lp', 'courses'));
    }

    public function update(Request $request, LearningPathway $learningPathway)
    {
        try {
            // Start the transaction
            DB::beginTransaction();

            // Validate request data
            $validated = $request->validate([
                'title' => [
                    'required',
                    'max:255',
                    Rule::unique('learning_pathways')->ignore($learningPathway->id)
                ],
                'course_id' => 'required|exists:courses,id',
                'description' => 'nullable|max:2000',
            ], [
                'course_id.required' => 'Please select atleast one course for the pathway'
            ]);

            // Create Learning Pathway
            $learningPathway->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
            ]);

            $course_with_order = json_decode($request->course_with_order);

            // Create Learning Pathway Course
            foreach ($course_with_order as $key => $value) {
                LearningPathwayCourse::updateOrCreate([
                    'pathway_id' => $learningPathway->id,
                    'course_id' => $value,
                ], [
                    'position' => $key + 1,
                ]);
            }

            LearningPathwayCourse::where('pathway_id', $learningPathway->id)->whereNotIn('course_id', $course_with_order)->delete();

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'message' => "$learningPathway->title learning pathway updated successfully",
                'redirect_route' => '/user/learning-pathways'
            ]);
        } catch (ValidationException $e) {
            // Rollback the transaction in case of validation error
            DB::rollBack();

            // Return validation errors
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(), // Returns detailed validation errors
            ], 422);
        } catch (\Exception $e) {
            // Rollback the transaction for any other exceptions
            DB::rollBack();

            // Return generic error response
            return response()->json([
                'message' => 'Failed to create learning pathway',
            ], 500);
        }
    }



    public function destroy($id)
    {
        $ulp = UserLearningPathway::find($id);
        $title = $ulp->title;
        $ulp->delete();

        return response()->json(['message' => "$title learning pathway deleted successfully", 'event' => "assign_pathway_deleted"]);
    }
}
