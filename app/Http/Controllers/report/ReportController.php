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
use App\Models\City;
use App\Models\Lead;
use App\Models\Product;
use App\Models\QuotationDetail;

class ReportController extends Controller
{
    public function index(Request $request){
        $companies = Company::orderBy('company_name','asc')->get(['company_name','id']);
        $product_categories = ProductCategory::orderBy('product_category_name','asc')->get();
        $users = Admin::orderBy('name','asc')->get();
        $cities = City::orderBy('city_name','asc')->get(['id','city_name']);

        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d',strtotime(' + 30 day'));

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

        $area_wise_reports = $this->areaWiseReport(null,$from_date,$to_date);
        $category_wise_reports = $this->categoryWiseReport(null,$from_date,$to_date);

        // echo "<pre>";
        // print_r($category_wise_reports);
        // exit();

        return view("admin.report.index",compact(['from_date','to_date','companies','product_categories','users','cities','client_business_reports','value_based_reports','category_wise_reports','area_wise_reports']));
    }

    public function areaWiseReport($city_id,$from_date,$to_date){
        
        $result = [];
        if($city_id){
            $cities = City::where('id',$city_id)->get(['id','city_name']);
        }else{
            $cities = City::get(['id','city_name']);
        }
        foreach($cities as $city){
            $companies = Company::where('city_id',$city->id)->pluck('id');
            $leads = Lead::whereIn('company_id',$companies)->pluck('id');
            $quotations_amount = Quotation::whereIn('lead_id',$leads)->where('qout_is_latest',1)->sum('quot_amount');
            $quotations = Quotation::whereIn('lead_id',$leads)->where('qout_is_latest',1)->pluck('id');
            $po_amount = PurchaseOrder::whereIn('quotation_id',$quotations)->sum('po_net_amount');
            $item = array(
                'area' => $city->city_name,
                'quotations_amount' => $quotations_amount,
                'po_amount' => $po_amount,
            );
            $result[] = $item;
        }
            unset($cities,$companies,$leads,$quotations_amount,$quotations,$po_amount,$item);
            return $result;  
    }

    public function categoryWiseReport($category_id,$from_date,$to_date){
        $result = [];
        $categories = ProductCategory::where('status',1);
        if($category_id){
            $categories = $categories->where('id',$category_id);
        }
        $categories = $categories->get(['id','product_category_name']);
        
        foreach($categories as $category){
            $products = Product::where('product_category_id',$category->id)->pluck('id');
            $quotations = QuotationDetail::join('quotations','quotation_details.quotation_id','quotations.id')
                        ->whereIn('product_id',$products)->where('quotations.qout_is_latest',1)->pluck('quotations.id');

            $po_amount = PurchaseOrder::whereIn('quotation_id',$quotations)->whereBetween('created_at', [$from_date, $to_date])->sum('po_net_amount');
            $quotation_amount = QuotationDetail::join('quotations','quotation_details.quotation_id','quotations.id')
                        ->whereIn('product_id',$products)->where('quotations.qout_is_latest',1)
                        ->whereBetween('quotation_details.created_at', [$from_date, $to_date])->sum('quot_product_total_price');

            $item = array(
                'category_name' => $category->product_category_name,
                'quotations_amount' => $quotation_amount,
                'po_amount' => $po_amount,
            );
            $result[] = $item;
        }
        unset($categories,$category,$products,$quotations,$po_amount,$quotation_amount,$item);
        return $result;
    }


    public function clientBusinessReportAjax(Request $request){
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

    public function categoryWiseReportAjax(Request $request){
        $result = $this->categoryWiseReport($request->category_id,$request->from_date,$request->to_date);
        if($result){
            return response()->json(['success' => true, 'reports' =>$result, 'message' => 'Record found.']);
        }else{
            return response()->json(['success' => true, 'reports' =>[], 'message' => 'Record not found.']);
        }
    }

    public function valueBasedReportAjax(Request $request){
        $reports = Quotation::join('leads','quotations.lead_id','leads.id')
                    ->join('companies','leads.company_id','companies.id')
                    ->join('admins','quotations.admin_id','admins.id');
        if($request->company_id){
            $reports = $reports->where('companies.id',$request->company_id);
        }
        if($request->user_id){
            $reports = $reports->where('admins.id',$request->user_id);
        }
        if($request->quotation_amount){
            $reports = $reports->whereBetween('quotations.quot_amount',$request->quotation_amount);
        }
        if($request->from_date && $request->to_date){
            $reports = $reports->whereBetween('quotations.created_at', [$request->from_date, $request->to_date]);
        }
        $reports = $reports->get(['companies.company_name','admins.name','quotations.quot_amount']);

        if($reports){
            return response()->json(['success' => true, 'reports' =>$reports, 'message' => 'Record found.']);
        }else{
            return response()->json(['success' => true, 'reports' =>[], 'message' => 'Record not found.']);
        }
    }

    public function areaWiseReportAjax(Request $request){
        $result = $this->areaWiseReport($request->city_id,$request->from_date,$request->to_date);
        if($result){
            return response()->json(['success' => true, 'reports' =>$result, 'message' => 'Record found.']);
        }else{
            return response()->json(['success' => true, 'reports' =>[], 'message' => 'Record not found.']);
        }
    }


}
