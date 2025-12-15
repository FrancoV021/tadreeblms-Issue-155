<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourseRequest;
use CustomHelper;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserCourseRequestController extends Controller
{
    public function requestCourse()
    {
        $courses = Course::latest()->select('id', 'title', 'slug')->published()->get();
        return view('frontend.user-course-request.index', compact('courses'));
    }

    public function requestCourseSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:20',
            'city' => 'required|max:100',
            'email' => 'required|email',
            'course_id' => 'required|exists:courses,id',
        ], [
            'course_id.required' => 'Please select course',
            'course_id.exists' => 'Invalid course',
            'name.required' => 'Please enter name',
            'phone.max' => 'The mobile number may not be greater than 20 characters.',
            'phone.required' => 'Please enter mobile number',
            'city.required' => 'Please enter city',
            'email.required' => 'Please enter email',
        ]);

        UserCourseRequest::create($validated);

        session()->flash('message', __('Thank you! Course requested successfully. Our team will contact you soon'));
        return response()->json(['redirect_route' => url('request-course'),'event'=>'course_access_requested']);
    }

    public function courseRequests(Request $request)
    {
        if ($request->ajax()) {

            $timezone = $request->timezone;

            $records = UserCourseRequest::with('course');
            // Check for the column order from the request
            if ($request->has('order')) {
                $orderColumn = $request->input('columns.' . $request->input('order.0.column') . '.data');
                $orderDir = $request->input('order.0.dir'); // 'asc' or 'desc'

                // If the column exists, apply the ordering
                if (in_array($orderColumn, ['name', 'email', 'phone', 'city', 'created_at'])) {
                    $records = $records->orderBy($orderColumn, $orderDir);
                }
                // If sorting by related 'course' title
                elseif ($orderColumn == 'course') {
                    $records = $records->join('courses', 'user_course_requests.course_id', '=', 'courses.id')
                        ->orderBy('courses.title', $orderDir);
                }
            } else {
                // Default order by `id` if no specific order is provided
                $records = $records->orderBy('id', 'desc');
            }

            $records = $records->select('user_course_requests.*');

            return DataTables::of($records)
                ->addColumn('course', function ($row) {
                    return @$row->course->title;
                })
                ->editColumn('created_at', function ($row) use ($timezone) {
                    return CustomHelper::convertTimeZone($row->created_at, $timezone);
                })
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && !empty($request->input('search.value'))) {
                        $search = $request->input('search.value');
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', $search)
                            ->orWhere('email', $search)
                            ->orWhere('city', $search)
                            ->orWhereHas('course', function ($query) use ($search) {
                                $query->where('title', 'like', "%{$search}%");
                            });
                    }
                })
                ->make(true);
        }

        return view('backend.user-course-request.index');
    }
}
