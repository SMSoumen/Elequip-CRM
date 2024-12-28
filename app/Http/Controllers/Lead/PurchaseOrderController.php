<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Admin;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\OrderAndDelivery;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{

    public function createPurchaseOrder(Request $request)
    {
        $request->validate([
            'lead_id'              => 'required|integer',
            'quotation_id'         => 'required|integer',
            'tax_percent'          => 'required|integer',
            'gross_total'          => 'required|integer',
            'order_no'             => 'required|string',
            'total_tax_amount'     => 'required|string',
            'order_date'           => 'required|date',
            'net_total'            => 'required|string',
            'et_bill_no'           => 'required|string',
            'order_remark'         => 'required|string',
            'po_document'          => 'file|extensions:jpg,png,pdf,doc,docx,jpeg|nullable'
        ]);

        $data = array(
            'lead_id' => $request->lead_id,
            'quotation_id' => $request->quotation_id,
            // 'po_amount' => $request->
            'po_remaining'    => $request->net_total,
            'po_gross_amount' => $request->gross_total,
            'po_net_amount' => $request->net_total,
            'po_taxable' => $request->total_tax_amount,
            'po_tax_percent' => $request->tax_percent,
            'po_order_no' => $request->order_no,
            'po_order_date' => $request->order_date,
            'po_et_bill_no' => $request->et_bill_no,
            'admin_id' => auth("admin")->user()->id,
            'po_remarks' => $request->order_remark,
        );

        if ($request->hasFile('po_document')) {
            $file = $request->file('po_document');
            $str_image = uniqid() . '.' . $file->getClientOriginalExtension();
            $location = public_path('/upload/po/');
            $request->file('po_document')->move($location, $str_image);
            $data['po_document'] = $str_image;
        }
        Lead::where('id', $request->lead_id)->update(['lead_stage_id' => 5]);
        $po = PurchaseOrder::create($data);
        $oa_id = auth("admin")->user()->code.'/'.sprintf('%04d', $po->id);
        PurchaseOrder::where('id', $po->id)->update(['po_refer_no' => $oa_id]);

        $quotation_details = QuotationDetail::where('quotation_id', $request->quotation_id)->get();
        $add_order_details = [];
        foreach ($quotation_details as $quotation) {
            array_push($add_order_details, [
                'purchase_order_id' => $po->id,
                'lead_id' => $request->lead_id,
                'quotation_id' => $request->quotation_id,
                'product_id' => $quotation->product_id,
                'order_product_name' => $quotation->quot_product_name,
                'order_product_code' => $quotation->quot_product_code,
                'order_product_qty' => $quotation->quot_product_qty,
                'order_product_spec' => $quotation->quot_product_tech_spec,
                'order_product_unit_price' => $quotation->quot_product_unit_price,
                'order_product_total_price' => $quotation->quot_product_total_price,
                'measuring_unit' => $quotation->quot_product_unit,
                'order_product_delivery_date' => $request->lead_closure_date,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]);
        }
        DB::table('order_and_deliveries')->insert($add_order_details);
        if ($po) {
            return redirect()->route('admin.leads.show', $request->lead_id)->withSuccess('P.O created successfully.');
        } else {
            return redirect()->back()->withErrors('Error!! while creating P.O!!!');
        }
    }

    public function poDetailsView(Request $request, $po_id)
    {
        $po_details = PurchaseOrder::where('id', $po_id)->first();
        $orders = OrderAndDelivery::where('purchase_order_id', $po_id)->get(['id', 'order_product_name', 'order_product_code']);
        return view('admin.lead.po_stage_update', compact(['po_details', 'orders']));
    }

    public function updatePurchaseOrder(Request $request)
    {
        $request->validate([
            'lead_id'              => 'required|integer',
            'quotation_id'         => 'required|integer',
            'po_id'                => 'required|integer',
            'tax_percent'          => 'required|integer',
            'gross_total'          => 'required|decimal:2',
            'order_no'             => 'required|string',
            'total_tax_amount'     => 'required|decimal:2',
            'order_date'           => 'required|date',
            'net_total'            => 'required|decimal:2',
            'et_bill_no'           => 'required|string',
            'order_remark'         => 'required|string',
            'estimate_delivery_date.*' => 'required|date',
            'estimate_delivery_date'   => 'required|array',
            'po_document'          => 'file|extensions:jpg,png,pdf,doc,docx,jpeg|nullable'
        ]);

        $data = array(
            'lead_id' => $request->lead_id,
            'quotation_id' => $request->quotation_id,
            'po_gross_amount' => $request->gross_total,
            'po_net_amount' => $request->net_total,
            'po_remaining'    => $request->net_total,
            'po_taxable' => $request->total_tax_amount,
            'po_tax_percent' => $request->tax_percent,
            'po_order_no' => $request->order_no,
            'po_order_date' => $request->order_date,
            'po_et_bill_no' => $request->et_bill_no,
            'admin_id' => auth("admin")->user()->id,
            'po_remarks' => $request->order_remark,
        );

        if ($request->hasFile('po_document')) {
            $file = $request->file('po_document');
            $str_image = uniqid() . '.' . $file->getClientOriginalExtension();
            $location = public_path('/upload/po/');
            $request->file('po_document')->move($location, $str_image);
            $data['po_document'] = $str_image;
        }

        $dates = $request->estimate_delivery_date;
        foreach ($dates as $key => $date) {
            OrderAndDelivery::where('id', $request->order_id[$key])->update(['order_product_delivery_date' => $date]);
        }

        if (PurchaseOrder::where('id', $request->po_id)->update($data)) {
            return redirect()->route('admin.leads.show', $request->lead_id)->withSuccess('P.O updated successfully.');
        } else {
            return redirect()->back()->withErrors('Error!! while updating P.O!!!');
        }
    }
}
