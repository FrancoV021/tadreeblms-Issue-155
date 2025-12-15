<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreReasonsRequest;
use App\Http\Requests\Admin\UpdateReasonsRequest;
use App\Models\{Reason,Events,StuFeedback};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use DB;

class StudentFeedbackController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Reason.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.events.index');
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $reasons = "";

        $reasons = StuFeedback::orderBy('created_at', 'desc')->get();

        $has_view = true;
        $has_edit = true;
        $has_delete = true;
        

        return DataTables::of($reasons)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.events', 'label' => 'news', 'value' => $q->id]);
                }
             
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.events.edit', ['page' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.events.destroy', ['page' => $q->id])])
                        ->render();
                    $view .= $delete;
                }


                return $view;

            })
            ->editColumn('icon', function ($q) {
                if ($q->icon != "") {
                    return '<img width="100" height="100" src="'. asset('storage/uploads/'.$q->icon).'" class="w-100">';
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('status', function ($q) {
                $html = html()->label(html()->checkbox('')->id($q->id)
                ->checked(($q->status == 1) ? true : false)->class('switch-input')->attribute('data-id', $q->id)->value(($q->status == 1) ? 1 : 0).'<span class="switch-label"></span><span class="switch-handle"></span>')->class('switch switch-lg switch-3d switch-primary');
                return $html;
            })
            ->rawColumns(['actions', 'icon', 'status'])
            ->make();
    }

    /**
     * Show the form for creating new Reason.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('backend.events.create');
    }

    /**
     * Store a newly created Reason in storage.
     *
     * @param  \App\Http\Requests\StoreReasonsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $reason = new  StuFeedback();
        $reason->title = $request->title;
        $reason->event_date = date('Y-m-d H:i:s',strtotime($request->event_date));
        $reason->content = $request->get('content');
        if($request->news_image != ""){
            $request = $this->saveFiles($request);
            $reason->icon = $request->news_image;
        }
        $reason->save();

        return redirect()->route('admin.events.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Reason.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $reason = StuFeedback::findOrFail($id);

        return view('backend.events.edit', compact('reason'));
    }

    /**
     * Update Reason in storage.
     *
     * @param  \App\Http\Requests\UpdateReasonsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $reason = StuFeedback::findOrFail($id);
        $reason->title = $request->title;
        $reason->event_date = date('Y-m-d H:i:s',strtotime($request->event_date));
        $reason->content = $request->get('content');
        if($request->news_image != ""){
            $request = $this->saveFiles($request);
            $reason->icon = $request->news_image;
        }
        $reason->save();

        return redirect()->route('admin.events.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display Reason.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $reason = StuFeedback::findOrFail($id);

        return view('backend.events.show', compact('reason'));
    }


    /**
     * Remove Reason from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $reason = StuFeedback::findOrFail($id);
        $reason->delete();

        return redirect()->route('admin.events.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Reason at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        
        if ($request->input('ids')) {
            $entries = StuFeedback::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
        return redirect()->route('admin.events.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }


    public function status($id)
    {
        $reason = StuFeedback::findOrFail($id);
        if ($reason->status == 1) {
            $reason->status = 0;
        } else {
            $reason->status = 1;
        }
        $reason->save();

        return back()->withFlashSuccess(trans('alerts.backend.general.updated'));
    }

    /**
     * Update reason status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     **/
    public function updateStatus()
    {
        $reason = StuFeedback::findOrFail(request('id'));
        $reason->status = $reason->status == 1? 0 : 1;
        $reason->save();
    }
}
