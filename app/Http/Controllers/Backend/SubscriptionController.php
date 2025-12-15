<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Stripe\StripePlan;
use App\Models\Stripe\SubscribeCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Auth;

class SubscriptionController extends Controller
{

    public function show_list()
    {
        $user_id = Auth::user()->id;
       $pages = SubscribeCourse::where('user_id',$user_id)->get();
        //dd($pages);
        // Show the page
        return view('backend.subscription', compact('pages'));

    }

    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $pages = "";
        $user_id = Auth::user()->id;

        if (request('show_deleted') == 1) {

            $pages = SubscribeCourse::whereHas('course')->where('user_id',$user_id)->orderBy('created_at', 'desc');

            // if (!Gate::allows('page_delete')) {
            //     return abort(401);
            // }
            // $pages = SubscribeCourse::where('user_id',$user_id)->onlyTrashed()->orderBy('created_at', 'desc')->get();

        } else {
            $pages = SubscribeCourse::whereHas('course')->where('user_id',$user_id)->orderBy('created_at', 'desc');

        }


        if (auth()->user()->can('page_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('page_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('page_delete')) {
            $has_delete = true;
        }

        return DataTables::of($pages)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.subscription', 'label' => 'id', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.subscription.show', ['page' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.subscription.edit', ['page' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.subscription.destroy', ['page' => $q->id])])
                        ->render();
                    $view .= $delete;
                }

                return $view;

            })

            ->editColumn('image', function ($q) {
                return ($q->image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->image) . '">' : 'N/A';
            })
            ->editColumn('course_id', function ($q) {
                return isset($q->course->title) ? $q->course->title : '-';
            })
            ->editColumn('user_name', function ($q) {
                return $q->user->first_name;
            })
            ->editColumn('email', function ($q) {
                return $q->user->email;
            })
            /*
            ->addColumn('status', function ($q) {
                $html = html()->label(html()->checkbox('')->id($q->id)
                ->checked(($q->status == 1) ? true : false)->class('switch-input')->attribute('data-id', $q->id)->value(($q->status == 1) ? 1 : 0).'<span class="switch-label"></span><span class="switch-handle"></span>')->class('switch switch-lg switch-3d switch-primary');
                return $html;
            })
            */
            ->addColumn('status', function ($q) {
               return $q->status ? 'Active' : 'NotActive';
            })
            ->addColumn('created', function ($q) {
                return $q->created_at->diffforhumans();
            })
            ->rawColumns(['image','course_id','user_name','email', 'actions','status'])
            ->make();
    }

    public function __invoke(Request $request)
    {
        $user     = $request->user();
        $invoices = $user->subscribed('default') ? $user->StripeInvoices() : optional();
        $activePlan = $user->subscribed('default') ? StripePlan::where('plan_id', $user->subscription()->stripe_plan)->first()??optional() : optional();
        return view('backend.subscription', compact('user', 'invoices', 'activePlan'));
    }

    /**
     * Download an invoice
     */
    public function downloadInvoice($invoiceId)
    {
        return auth()->user()->downloadInvoice($invoiceId, [
            'vendor'  => config('app.name'),
            'product' => 'Monthly Subscription'
        ]);
    }

    /**
     * Delete subscription
     */
    public function deleteSubscription(Request $request)
    {
        $user = $request->user();

        // cancel the subscription
        $user->subscription('default')->cancel();

        return redirect()->back()->withFlashSuccess(__('labels.subscription.cancel'));
    }

    /**
     * Update the credit card
     */
    public function updateCard(Request $request)
    {
        // get the user
        $user = $request->user();

        // get the cc token
        $ccToken = $request->input('cc_token');

        // update the card
        $user->updateCard($ccToken);

        // return a redirect back to account
        return redirect('account')->with(['success' => 'Credit card updated.']);
    }

}
