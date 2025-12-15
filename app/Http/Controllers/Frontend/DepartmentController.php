<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreDepartmentRequest;
use App\Http\Requests\Admin\UpdatePagesRequest;
use App\Models\Page;
use App\Models\Department;
use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;



class DepartmentController extends Controller
{
    private $path;

    public function __construct()
    {

        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    public function index()
    {
        
        // Grab all the pages
        $departments = Department::all();
        //dd($pages);
        // Show the page
        return view( $this->path.'.department.index', compact('departments'));

    }

    public function show($department_id = null)
    {
        if (request('type') == 'popular') {
            $courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('department_id',$department_id)->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else if (request('type') == 'trending') {
            $courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('department_id',$department_id)->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else if (request('type') == 'featured') {
            $courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('department_id',$department_id)->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);

        } else {
            $courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('department_id',$department_id)->where('published', 1)->orderBy('id', 'desc')->paginate(9);
        }
        $purchased_courses = NULL;
        $purchased_bundles = NULL;
        $categories = Category::where('status', '=', 1)->get();

        if (\Auth::check()) {
            $purchased_courses = Course::withoutGlobalScope('filter')->canDisableCourse()->whereHas('students', function ($query) {
                $query->where('id', \Auth::id());
            })
                ->with('lessons')
                ->orderBy('id', 'desc')
                ->get();
        }
        $featured_courses = Course::withoutGlobalScope('filter')->canDisableCourse()->where('published', '=', 1)
            ->where('featured', '=', 1)->take(8)->get();

        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        return view($this->path . '.department.department-course-list', compact('courses', 'purchased_courses', 'recent_news', 'featured_courses', 'categories'));
    }

    // comment
    

}
