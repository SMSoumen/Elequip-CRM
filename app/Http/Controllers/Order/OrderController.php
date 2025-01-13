<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Exception;
use App\Models\PurchaseOrder;
use App\Models\OrderAndDelivery;
use App\Models\Lead;
use App\Models\LeadFollowup;
use App\Models\LeadStage;
use App\Models\SmsFormat;
use App\Models\Quotation;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Order access|Order create|Order edit|Order delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Order create', only: ['create', 'store']),
            new Middleware('role_or_permission:Order edit', only: ['edit', 'update', 'addAdvanceAmount', 'addRemainingAmount', 'updateLeadStageModal', 'updateLeadStage', 'orderSendSms']),
            new Middleware('role_or_permission:Order delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = PurchaseOrder::query()->join('leads', 'purchase_orders.lead_id', 'leads.id')
                ->join('lead_stages', 'leads.lead_stage_id', 'lead_stages.id')
                ->join('customers', 'leads.company_id', 'customers.id')->leftJoin('companies', 'leads.customer_id', 'companies.id')
                ->select('purchase_orders.id', 'purchase_orders.po_net_amount', 'purchase_orders.po_refer_no', 'purchase_orders.po_advance', 'purchase_orders.po_remaining', 'purchase_orders.created_at', 'purchase_orders.lead_id', 'customers.customer_name', 'customers.mobile', 'customers.designation', 'customers.email', 'companies.company_name', 'lead_stages.stage_name', 'leads.lead_stage_id')
                ->orderBy('purchase_orders.id', 'desc');

                if (!auth('admin')->user()->hasRole('Super-Admin')) {
                    if (auth('admin')->user()->hasRole('Sales')) {
                        $query->where('leads.admin_id', auth('admin')->user()->id)->orWhere('leads.lead_assigned_to', auth('admin')->user()->id);
                    } 
                    // else {
                    //     $query->where('leads.lead_stage_id', '>=', 5);
                    // }
                }

                if ($request->lead_stage) {
                    // Log::info($request->lead_stage);
                    $query->where('leads.lead_stage_id', '=', $request->lead_stage);
                }
                if ($request->from_date) {
                    // Log::info($request->from_date);
                    $query->where('purchase_orders.created_at', '>', $request->from_date);
                }
                if ($request->to_date) {
                    // Log::info($request->to_date);
                    $query->where('purchase_orders.created_at', '<', $request->to_date);
                }

                return DataTables::eloquent($query)
                    ->addColumn('orderby', function ($data) {
                        return $data->orderby = $data->customer_name . '(' . $data->designation . ')<br>' . $data->company_name . '<br><b>Email :</b> ' . $data->email . '<br><b> Phone : </b>' . $data->mobile;
                    })
                    ->addColumn('po_net_amount', function ($data) {
                        return number_format($data->po_net_amount, 2);
                    })->addColumn('balance_amount', function ($data) {
                        return $data->balance_amount = number_format($data->po_remaining, 2);
                    })
                    ->addColumn('stage', function ($data) {
                        return $data->stage = '<span class="badge bg-secondary">' . $data->stage_name . '</span>';
                    })->addColumn('created_date', function ($data) {
                        return $data->created_date = date('d-m-Y', strtotime($data->created_at));
                    })
                    ->addColumn('action', function ($data) {
                        $viewRoute = route('admin.leads.show', $data->lead_id);
                        return view('admin.layouts.partials.order_action_btn', compact(['data', 'viewRoute']))->render();
                    })
                    ->addIndexColumn()->rawColumns(['orderby', 'balance_amount', 'action', 'stage', 'created_date'])->make(true);
            }

            $lead_stages = LeadStage::where('id', '>=', 5)->get();
            $templates = SmsFormat::whereNotNull('template_id')->where('status', 1)->orderBy('id', 'desc')->get(['id', 'template_name']);
            return view('admin.order.index', compact(['lead_stages', 'templates']));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addAdvanceAmount(Request $request)
    {
        $request->validate([
            'order_id'        => 'required|integer',
            'advance_amount'  => 'required|numeric',
        ]);

        $order_details = PurchaseOrder::where('id', $request->order_id)->first();
        if ($request->advance_amount > $order_details->po_net_amount) {
            return response()->json(['status' => 'check_amount', 'message' => 'The Advance Amount field must contain a number less than or equal to ' . $order_details->po_net_amount]);
        } else {
            Lead::where('id', $order_details->lead_id)->update(['lead_stage_id' => 6]);
            LeadFollowup::create(['lead_id' => $order_details->lead_id, 'followup_remarks' => 'Advance Payment of Rs. ' . $request->advance_amount . ' Added', 'followup_type' => 'remarks', 'admin_id' => auth("admin")->user()->id]);
            $remaining_amount = $order_details->po_net_amount - $request->advance_amount;
            if (PurchaseOrder::where('id', $request->order_id)->update(['po_advance' => $request->advance_amount, 'po_remaining' =>  $remaining_amount])) {
                return response()->json(['success' => true, 'message' => 'Amount added successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Error!! while adding amount!',]);
            }
        }
    }

    public function addRemainingAmount(Request $request)
    {
        $request->validate([
            'order_id'        => 'required|integer',
            'remaining_amount' => 'required|numeric',
        ]);

        $order_details = PurchaseOrder::where('id', $request->order_id)->first();
        if ($request->remaining_amount != $order_details->po_remaining) {
            return response()->json(['status' => 'check_amount', 'message' => 'The Remaining Amount field must contain a number equal to ' . $order_details->po_remaining]);
        } else {
            LeadFollowup::create(['lead_id' => $order_details->lead_id, 'followup_remarks' => 'Remaining Payment of Rs. ' . $request->remaining_amount . ' Added', 'followup_type' => 'remarks', 'admin_id' => auth("admin")->user()->id]);
            $remaining_amount = $order_details->po_remaining - $request->remaining_amount;
            if (PurchaseOrder::where('id', $request->order_id)->update(['po_remaining' =>  $remaining_amount])) {
                return response()->json(['success' => true, 'message' => 'Amount added successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Error!! while adding amount!',]);
            }
        }
    }

    public function updateLeadStageModal(Request $request)
    {
        $request->validate([
            'lead_id'  => 'required|integer',
            'stage_id' => 'required|integer',
        ]);

        $lead_id = $request->lead_id;
        $stage_id = $request->stage_id;

        $lead = Lead::where('id', $request->lead_id)->first();
        $stages = LeadStage::where('id', '>=', $lead->lead_stage_id)->where(['status' => 1])->get(['id', 'stage_name']);

        $order = PurchaseOrder::with(['deliveries' => function ($query) {
            $query->where('status', '!=', 2);
        }])->where('lead_id', $request->lead_id)->latest()->first();
        $to_be_delivered = $order->deliveries->count();
        $remaining_amt = $order->po_remaining;

        return view('admin.modal.lead_stage_update_modal', compact(['stages', 'stage_id', 'lead_id', 'to_be_delivered', 'remaining_amt']));
    }

    public function updateLeadStage(Request $request)
    {
        $request->validate([
            'lead_id'  => 'required|integer',
            'stage_id' => 'required|integer',
        ]);

        $lead = Lead::where('id', $request->lead_id)->first();

        if ($lead->lead_stage_id == $request->stage_id) {
            return response()->json(['success' => false, 'message' => 'Nothing Changed!',]);
        } else {
            $order = PurchaseOrder::with(['deliveries' => function ($query) {
                $query->where('status', '!=', 2);
            }])->where('lead_id', $request->lead_id)->latest()->first();

            $to_be_delivered = $order->deliveries->count();
            if ($request->stage_id == 9) {
                if (($to_be_delivered > 0) || ($order->po_remaining > 0)) {
                    $msg = ($to_be_delivered) ? $to_be_delivered . ' Product need to be delivered first' : 'Remaining amount need to be added first';
                    return response()->json(['success' => false, 'message' => $msg,]);
                }
            }


            if (Lead::where('id', $request->lead_id)->update(['lead_stage_id' => $request->stage_id])) {
                LeadFollowup::create(['lead_id' => $request->lead_id, 'followup_remarks' => 'Lead Stage Updated', 'followup_type' => 'remarks', 'admin_id' => auth("admin")->user()->id]);
                $lead_status = $request->stage_id;
                if (in_array($lead_status, [7, 8])) {
                    if ($order->deliveries) {
                        foreach ($order->deliveries as $detail) {
                            if ($detail->status != 2) {
                                $stat = $lead_status == 7 ? 1 : 2;
                                OrderAndDelivery::where('id', $detail->id)->update(['status' => $stat]);
                            }
                        }
                    }
                }
                return response()->json(['success' => true, 'message' => 'Lead stage updated successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Error!! while updating lead stage!',]);
            }
        }
    }

    public function orderSendSms(Request $request)
    {
        $request->validate([
            'mobile_no' => 'required|integer|size:10',
            'lead_id'   => 'required|integer',
            'sms_title' => 'required|integer',
        ]);

        $sms_template = SmsFormat::where('id', $request->sms_title)->first(['id', 'template_format', 'template_id']);
        $mobile_no = "918777269326";
        if ($sms_template->id == 14) {
            $quotation = Quotation::where('lead_id', $request->lead_id)->latest()->first(['quot_ref_no']);
            $ref_no = $quotation ? $quotation->quot_ref_no : NULL;
            $msg = str_replace('{ORDER_ID}', $ref_no, $sms_template->template_format);
        } else {
            $po = PurchaseOrder::where('lead_id', $request->lead_id)->first(['po_refer_no']);
            $ref_no = $po ? $po->po_refer_no : NULL;
            $msg = str_replace('{ORDER_ID}', $po->po_refer_no, $sms_template->template_format);
        }

        //$mobile_no = '91'.$request->mobile_no;

        if ($this->sendSms($mobile_no, $msg, $sms_template->template_id)) {

            $lf_remarks = 'SMS Sent to ' . $mobile_no;
            $lf_remarks .= $msg ? '<br><b>Message: </b>' . $msg : NULL;

            LeadFollowup::create(['lead_id' => $request->lead_id, 'followup_remarks' => $lf_remarks, 'followup_type' => 'remarks', 'admin_id' => auth("admin")->user()->id]);
            return redirect()->back()->withSuccess('SMS send successfully.');
        } else {
            return redirect()->back()->withErrors('Error!! while sending sms!!!');
        }
    }

    private function sendSms($to_mobile, $msg, $template_id)
    {
        $userID = "elequipsms";
        $userPassword = "etplsms763";
        $url = "http://server.sitanigroup.com/smsserver";

        $msg = urlencode($msg);
        $url = $url . '/?UserID=' . $userID . '&UserPassWord=' . $userPassword . '&PhoneNumber=' . $to_mobile . '&Text=' . $msg . "&DltTID=" . $template_id;
        Log::info($url);
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            curl_close($ch);
            Log::info($result);
            return $result;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
            //throw $th;
        }
    }
}
