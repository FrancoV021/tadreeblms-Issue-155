<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use App\Models\Assignment;
use App\Models\EmployeeProfile;
use App\Models\courseAssignment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\CustomHelper;
use App\Models\ManualAssessment;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.wishlist.index');
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $wishlists = WishList::query()->with(['course'])->where('user_id', auth()->user()->id);


        return DataTables::of($wishlists)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) {
                $view = '';
                $view .= view('backend.datatable.action-delete')
                    ->with(['route' => route('admin.wishlist.destroy', ['wishlist' => $q->id])])
                    ->render();
                $view .= view('backend.datatable.action-view')
                    ->with(['route' => route('courses.show', [$q->course->slug])])->render();

                return $view;
            })
            ->rawColumns(['actions'])
            ->make();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!WishList::where('course_id', $request->course)->where('user_id', auth()->user()->id)->first()) {
            WishList::create([
                'user_id' => auth()->user()->id,
                'course_id' => $request->course,
                'price' => $request->price
            ]);
            return response()->json(['status' => true, 'message' => trans('alerts.frontend.wishlist.added')]);
        } else {
            return response()->json(['status' => false, 'message' => trans('alerts.frontend.wishlist.exist')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WishList  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(WishList $wishlist)
    {
        $wishlist->delete();
        return redirect()->route('admin.wishlist.index')->withFlashSuccess(__('alerts.backend.general.deleted'));
    }


    public function myassignment(Request $request)
    {
        return view('backend.myassignment.index');
    }

    public function getMyAssignmentData_(Request $request)
    {
        //dd(auth()->user()->id);
        $logged_in_user_id = auth()->user()->id;

        $employee_profile = EmployeeProfile::where('user_id', $logged_in_user_id)->first();
        $logged_in_department_id = $employee_profile ? $employee_profile->department : null;

        // Course Assigment

        //dd($logged_in_department_id);

        $assignments = Assignment::join('tests', 'tests.id', '=', 'assignments.test_id')
            ->select('assignments.*', 'tests.title as test_title')
            ->whereRaw('FIND_IN_SET(?, `assignments`.`user_id`) > 0', [$logged_in_user_id])
            ->where('assignments.deleted_at', NULL)
            ->orderBy('id', 'DESC');
        //dd($assignments->toSql());

        return DataTables::of($assignments)
            ->addIndexColumn()

            ->addColumn('assesment_url', function ($q) {
                $test_link = route('online_assessment', ['assignment' => $q->url_code, 'verify_code' => $q->verify_code]);
                return '<a target="_blank" href="' . $test_link . '">Start Assesment</a>';
            })
            ->addColumn('actions', function ($q) {
                $view = '';
                $view .= view('backend.datatable.action-delete')
                    ->with(['route' => route('admin.wishlist.destroy', ['wishlist' => $q->id])])
                    ->render();


                return $view;
            })
            ->rawColumns(['actions', 'assesment_url'])
            ->make();
    }

    public function getMyAssignmentData(Request $request)
    {
        $data = ManualAssessment::mine()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('assessment_name', function ($row) {
                return @$row->assignment->test->title;
            })
            ->editColumn('created_at', function ($row) {
                return @$row->created_at->format('d M Y');
            })
            ->addColumn('due_date', function ($row) {
                return date('d M Y', strtotime($row->due_date));
            })
            ->addColumn('score', function ($q) {
                return $q->assignment_score_percentage . '%';
            })
            ->addColumn('status', function ($q) {
                if ($q->assessment_id) {
                    $test_taken = CustomHelper::is_test_taken($q->assessment_id, $q->user_id);
                    if (!$test_taken) {
                        return 'Test Not Taken';
                    } else {
                        return $q->qualify_status;
                    }
                }
            })
            ->addColumn('assesment_url', function ($q) {
                if ($q->assessment_id) {
                    $test_taken = CustomHelper::is_test_taken($q->assessment_id, auth()->id());
                    if (!$test_taken) {

                        $date = Carbon::parse($q->due_date); // Replace with your date
                        if ($date->isPast()) {
                            return "Due date is passed. Please contact admin.";
                        }
                        $test_link = route('manual_online_assessment', ['assignment' => $q->assignment->url_code, 'verify_code' => $q->assignment->verify_code, 'assessment_id' => $q->assessment_id, 'manual_assessment_id' => $q->id]);
                        return '<a target="_blank" href="' . $test_link . '">Start Assesment</a>';
                    } else {
                        return 'Test Taken';
                    }
                } else {
                    return '-';
                }
            })
            ->rawColumns(['assesment_url'])
            ->make();
    }

    // public function getMyAssignmentData(Request $request)
    // {
    //     //dd("hi");
    //     //dd(auth()->user()->id);
    //     $logged_in_user_id = auth()->user()->id;



    //     $employee_profile = EmployeeProfile::where('user_id',$logged_in_user_id)->first();
    //     // dd($employee_profile);
    //     $logged_in_department_id = $employee_profile ? $employee_profile->department : null;
    //     // dd($logged_in_department_id);
    //     // Course Assigment
    //     if(!empty($employee_profile) && !empty($logged_in_department_id)){
    //         $assignments = courseAssignment::with(['assessment','assessment.course'])
    //         ->whereRaw('FIND_IN_SET(?, `assign_to`) > 0', $logged_in_user_id)
    //         ->orWhere('department_id', $logged_in_department_id)
    //         //->whereRaw('FIND_IN_SET(?, `assign_to`) > 0', $logged_in_user_id)
    //         ->whereNotNull('course_id')
    //         //->orWhereNotNull('category_id')
    //         ->get();
    //     }
    //     else{
    //         $assignments = courseAssignment::with(['assessment','assessment.course'])
    //         // ->whereRaw('FIND_IN_SET(?, `assign_to`) > 0', $logged_in_user_id)
    //         ->where('assign_to',$logged_in_user_id)
    //         // ->orWhere('department_id', $logged_in_department_id)
    //         //->whereRaw('FIND_IN_SET(?, `assign_to`) > 0', $logged_in_user_id)
    //         // ->whereNotNull('course_id')
    //         //->orWhereNotNull('category_id')
    //         ->get();
    //     }        


    //     //dd($logged_in_user_id, $assignments);

    //     // $assignments = Assignment::join('tests', 'tests.id', '=', 'assignments.test_id')
    //     //             ->select('assignments.*','tests.title as test_title')
    //     //             //->whereRaw('FIND_IN_SET(?, `assignments`.`user_id`) > 0', [$logged_in_user_id])
    //     //             ->whereIn('assignments.course_id', $course_assisment_data)
    //     //             ->where('assignments.deleted_at', NULL)
    //     //             ->orderBy('id', 'DESC');
    //     //dd($assignments->toSql());

    //     return DataTables::of($assignments)
    //         ->addIndexColumn()
    //         ->addColumn('course_name',function ($q){
    //             return $q->assessment ? $q->assessment->course ? $q->assessment->course->title : '-' : '-';
    //          })
    //          ->addColumn('test_status',function ($q) use ($logged_in_user_id) {
    //             if($q->assessment) {
    //                 CustomHelper::is_test_taken($q->assessment->id,$logged_in_user_id) ? 'TAKEN' : 'NOT-TAKEN';
    //             } else {
    //                 return '-';
    //             }

    //          })
    //         ->addColumn('assesment_url',function ($q) use ($logged_in_user_id){
    //             if($q->assessment) {
    //                 $test_taken = CustomHelper::is_test_taken($q->assessment->id,$logged_in_user_id);
    //                 if(!$test_taken) {
    //                     $test_link = route('online_assessment', ['assignment' => $q->assessment->url_code , 'verify_code' => $q->assessment->verify_code,'id' => $q->id, 'assessment_id' => $q->assessment->id  ]);
    //                     return '<a target="_blank" href="'. $test_link .'">Start Assesment</a>';
    //                 } else {
    //                     return 'Test Taken';
    //                 }

    //             } else {
    //                 return '-';
    //             }


    //          })
    //         ->addColumn('actions', function ($q){
    //             $view = '';
    //             if($q->assessment) {
    //                 $view .= view('backend.datatable.action-delete')
    //                         ->with(['route' => route('admin.wishlist.destroy', ['wishlist' => $q->assessment->id])])
    //                         ->render();
    //             }


    //             return $view;
    //         })
    //         ->rawColumns(['course_name','test_status', 'actions', 'assesment_url'])
    //         ->make();
    // }
}
