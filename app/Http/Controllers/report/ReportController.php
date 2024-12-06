<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Customer;
use App\Models\ProductCategory;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\Admin;

class ReportController extends Controller
{
    public function index(Request $request){
        $companies = Company::orderBy('company_name','asc')->get(['company_name','id']);
        $product_categories = ProductCategory::orderBy('product_category_name','asc')->get();
        $users = Admin::orderBy('name','desc')->get();

        $client_business_reports = PurchaseOrder::join('quotations','purchase_orders.quotation_id','quotations.id')
                                    ->join('leads','purchase_orders.lead_id','leads.id')
                                    ->join('companies','leads.company_id','companies.id')
                                    ->join('customers','leads.customer_id','customers.id')
                                    ->where('customers.status','1')
                                    ->orderBy('purchase_orders.id','desc')
                                    ->get(['customers.customer_name','customers.designation','companies.company_name','quotations.quot_amount','purchase_orders.po_net_amount']);

        $value_based_reports = Quotation::join('leads','quotations.lead_id','leads.id')
                                ->join('companies','leads.company_id','companies.id')
                                ->join('admins','quotations.admin_id','admins.id')
                                ->get(['companies.company_name','admins.name','quotations.quot_amount']);

        return view("admin.report.index",compact(['companies','product_categories','users','client_business_reports','value_based_reports']));
    }

    public function clientBusinessReport(Request $request){
        $reports = PurchaseOrder::join('quotations','purchase_orders.quotation_id','quotations.id')
                                    ->join('leads','purchase_orders.lead_id','leads.id')
                                    ->join('companies','leads.company_id','companies.id')
                                    ->join('customers','leads.customer_id','customers.id');
        if($request->company_id){
            $reports = $reports->where('companies.id',$request->company_id);
        }
        if($request->customer_id){
            $reports = $reports->where('customers.id',$request->customer_id);
        }
        if($request->from_date && $request->to_date){
            $reports = $reports->whereBetween('purchase_orders.created_at', [$request->from_date, $request->to_date]);
        }

        $reports = $reports->where('customers.status','1')->orderBy('purchase_orders.id','desc')
        ->get(['customers.customer_name','customers.designation','companies.company_name','quotations.quot_amount','purchase_orders.po_net_amount']);

        if($reports){
            return response()->json(['success' => true, 'reports' =>$reports, 'message' => 'Record found.']);
        }else{
            return response()->json(['success' => true, 'reports' =>[], 'message' => 'Record not found.']);
        }
    }
}
