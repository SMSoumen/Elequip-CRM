<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Company;
use App\Models\Customer;
use App\Models\LeadSource;
use App\Models\LeadCategory;
use App\Models\LeadStage;
use App\Models\Product;
use App\Models\LeadDetail;
use App\Models\LeadFollowup;
use App\Models\Admin;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\QuotationTerm;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Exception;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LeadController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Lead access|Lead create|Lead edit|Lead delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Lead create', only: ['create', 'store']),
            new Middleware('role_or_permission:Lead edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Lead delete', only: ['destroy']),
        ];
    }
    
    public function index(Request $request)
    {
        if(session()->has('quotation_data')){
            $request->session()->forget('quotation_data');
        }

        try {
            if ($request->ajax()) {
                return DataTables::eloquent(Lead::query()->join('customers','leads.customer_id','customers.id')
                ->join('companies','leads.company_id','companies.id')->join('lead_stages','leads.lead_stage_id','lead_stages.id')
                ->select('leads.*','customers.customer_name','customers.mobile','customers.designation','companies.company_name','lead_stages.stage_name')
                ->orderBy('leads.id','desc'))
                ->addColumn('customer', function ($data) {
                    return $data->customer = $data->customer_name.'('.$data->designation.')<br>'.$data->company_name;
                })
                ->addColumn('next_fllowup_date', function ($data) {
                    $next_fllowup_date = LeadFollowup::where('lead_id',$data->id)->latest()->first();
                    return $data->next_fllowup_date = date('d-m-Y',strtotime($next_fllowup_date->followup_next_date));
                })
                ->addColumn('assign_to', function ($data) {
                    return $data->assign_to = ($data->lead_assigned_to) ? Admin::where('id',$data->lead_assigned_to)->first()->name : 'Admin';
                })
                ->addColumn('stage', function ($data) {
                    return $data->stage = '<span class="badge bg-secondary">'.$data->stage_name.'</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $viewRoute = route('admin.leads.show', $data->id);
                    $deleteRoute = route('admin.leads.destroy', $data->id);
                    $edit_type = "lead";
                    $permission = 'Lead';
                    $type="lead";

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'viewRoute', 'deleteRoute', 'permission','edit_type','type']))->render();
                })->addIndexColumn()->rawColumns(['customer','next_fllowup_date','assign_to','action','stage','created_date'])->make(true);
            }
            $lead_stages = LeadStage::where('status','1')->orderBy('stage_name','asc')->get();
            $users = Admin::whereNot('id',1)->orderBy('name','asc')->get();
            return view('admin.lead.index',compact('users','lead_stages'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        $companies = Company::where('status','1')->orderBy('company_name','asc')->get();
        $customers = Customer::where('status','1')->orderBy('customer_name','asc')->get();
        $categories = LeadCategory::where('status','1')->orderBy('category_name','asc')->get();
        $sources = LeadSource::where('status','1')->orderBy('source_name','asc')->get();
        $products = Product::where('status','1')->orderBy('product_name','asc')->get();
        return view('admin.lead.add',compact(['companies','customers','categories','sources','products']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id'                 => 'required|integer',
            'lead_source_id'             => 'required|integer',
            'customer_id'                => 'required|integer',
            'lead_category_id'           => 'required|integer',
            'lead_estimate_closure_date' => 'required|date',
            'Next_follow_up_date' => 'required|date',
            'product_id'        => 'required|array',
            'qty'               => 'required|array',
            'amount'            => 'required|array',
        ]);

        DB::beginTransaction();
        try{
            $product_ids = $request->product_id;
            $quatities = $request->qty;
            $amounts = $request->amount;

            $lead = Lead::create([
                'company_id' => $request->company_id,
                'lead_source_id' => $request->lead_source_id,
                'customer_id' => $request->customer_id,
                'lead_category_id' => $request->lead_category_id,
                'lead_estimate_closure_date' => $request->lead_estimate_closure_date,
                'lead_remarks' => $request->lead_remarks,
                'admin_id'     => auth("admin")->user()->id,
                'lead_total_amount' => array_sum($amounts),
            ]);

            $lead_id = $lead->id;
            LeadFollowup::create([
                'lead_id'            => $lead_id,
                'followup_next_date' => $request->Next_follow_up_date,
                'admin_id'           => auth("admin")->user()->id,
            ]);

            foreach($product_ids as $key=>$product_id){
                $this->addProductDetails($product_id,$quatities[$key],$lead_id);
            }
            DB::commit();
            return redirect()->route('admin.leads.index')->withSuccess('Lead added successfully.');
        } catch(Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error!! while adding lead!!!');
        }

    }

    private function addProductDetails($product_id,$qty,$lead_id){
        $product = Product::join('measuring_units','products.measuring_unit_id','measuring_units.id')->where('products.id', $product_id)->first();
        LeadDetail::create([
            'lead_id' => $lead_id,
            'product_id'         => $product_id,
            'lead_product_name'  => $product->product_name,
            'lead_product_code'  => $product->product_code,
            'lead_product_qty'   => $qty,
            'lead_product_price' => $product->product_price,
            'lead_product_tech_spec' => $product->product_tech_spec,
            'lead_product_m_spec'    => $product->product_marketing_spec,
            'lead_product_unit'      => $product->unit_type,
        ]);
        unset($product);
        return true;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,Lead $lead)
    {
        $fllowup_date = LeadFollowup::where('lead_id',$lead->id)->latest()->first();
        $companies = Company::where('status','1')->orderBy('company_name','asc')->get();
        $customers = Customer::where('status','1')->orderBy('customer_name','asc')->get();
        $categories = LeadCategory::where('status','1')->orderBy('category_name','asc')->get();
        $sources = LeadSource::where('status','1')->orderBy('source_name','asc')->get();
        $products = Product::where('status','1')->orderBy('product_name','asc')->get();
        $stages = LeadStage::where('status','1')->orderBy('id','asc')->get();
        $lead_details = LeadDetail::where('lead_id',$lead->id)->get();

        $quotations = Quotation::where('lead_id',$lead->id)->orderBy('quot_version','desc')->get();
        return view('admin.lead.view',compact(['companies','customers','categories','sources','products','stages','lead','fllowup_date','lead_details','quotations']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'lead_stage_id' => 'integer',
            'lead_id'       => 'required|integer',
            'lead_category_id'           => 'required|integer',
            'lead_estimate_closure_date' => 'required|date',
            'followup_next_date' => 'required|date',
        ]);
        $data = array(
            'lead_remarks' => $request->remarks,
            'lead_estimate_closure_date' => $request->lead_estimate_closure_date, 
            'lead_category_id' => $request->lead_category_id,
        );
        if($request->lead_stage_id){
            $data['lead_stage_id'] = $request->lead_stage_id;
        }
        if($lead->update($data)){
            LeadFollowup::create([
                'lead_id'   => $request->lead_id,
                'admin_id'  => auth("admin")->user()->id,
                'followup_next_date' => $request->followup_next_date, 
                'followup_remarks' => ($request->lead_stage_id) ? 'Lead Stage Upgraded' : 'Lead Updated',
            ]);
            return redirect()->back()->withSuccess('Lead stage updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating lead stage!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->back()->withSuccess('Lead deleted successfully.');
    }

    public function productDetails(Request $request){
        $product = Product::join('measuring_units','products.measuring_unit_id','measuring_units.id')->whereIn('products.id',$request->product_id)->get('products.*','measuring_units.unit_type');
        return $product;
    }

    public function leadAssignUser(Request $request){
        $request->validate([
            'lead_assigned_to' => 'required|integer',
            'lead_id'          => 'required|integer',
        ]);
        if(Lead::where('id',$request->lead_id)->update(['lead_assigned_to' => $request->lead_assigned_to])){
            return redirect()->back()->withSuccess('Lead assign successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while lead assign to user!!!');
        }
    }

    public function companyCustomers(Request $request){
        $customers = Customer::where('company_id',$request->company_id)->where('status','1')->get();
        return $customers;
    }

    public function leadProductDetails(Request $request){
        $products = Product::leftJoin('lead_details','products.id','lead_details.product_id')->whereIn('products.id',$request->product_id)
        ->where('lead_details.lead_id',$request->lead_id)->get('products.id','products.product_name','products.product_code','products.product_price','products.product_tech_spec','lead_details.lead_product_qty');
        return $products;
    }

    public function quotationGenerate(Request $request){
        if(session()->has('quotation_data')){
            $request->session()->forget('quotation_data');
        }

        $data = array(
                'lead_id' => $request->lead_id,
                'quotation_remarks' => $request->quotation_remarks,
                'enquiry_ref'=> $request->enquiry_ref,
                'product_id' => $request->product_id,
                'product_name' => $request->product_name,
                'product_code' => $request->product_code,
                'product_unit' => $request->product_unit,
                'product_tech_spec' => $request->product_tech_spec,
                'product_m_spec' => $request->product_m_spec,
                'qty'        => $request->qty,
                'rate'       => $request->rate,
                'amount'     => $request->amount,
                'discount'   => $request->discount,
                'tax'        => $request->tax,
                'basis'      => $request->basis,
                'payment'    => $request->payment,
                'freight_forwarding' => $request->freight_forwarding,
                'validity' => $request->validity,
                'delivery' => $request->delivery,
                'warranty' => $request->warranty,
                'note_1'   => $request->note_1,
                'note_2'   => $request->note_2,
        );
        $request->session()->put('quotation_data', $data);
        return redirect()->back()->withSuccess('Quotation generated successfully.');
    }

    public function addQuotation(Request $request){
        $data = session('quotation_data');
        if($data){
            Lead::where('id',$data['lead_id'])->update(['lead_stage_id' => '3']);
            $quotation = Quotation::create([
                'lead_id'      => $data['lead_id'],
                'quot_ref_no'  => $data['enquiry_ref'],
                'quot_remarks' => $data['quotation_remarks'],
                'quot_amount'  => array_sum($data['amount']),
                'admin_id'     => auth("admin")->user()->id,
            ]);
    
            QuotationTerm::create([
                'lead_id'         => $data['lead_id'],
                'quotation_id'    => $quotation->id,
                'term_discount'   => $data['discount'],
                'term_tax'        => $data['tax'],
                'term_forwarding' => $data['freight_forwarding'],
                'term_validity'   => $data['validity'],
                'term_warranty'   => $data['warranty'],
                'term_payment'    => $data['payment'],
                'term_note_1'     => $data['note_1'],
                'term_note_2'     => $data['note_2'],
                'term_dispatch'   => $data['delivery'],
                'term_price'      => $data['basis'],
            ]);

            LeadFollowup::create([
                'lead_id'          => $data['lead_id'],
                'followup_remarks' => 'Lead Stage Upgraded to Quotation Stage.',
                'admin_id'         => auth("admin")->user()->id,
                'followup_type'    => 'remarks',
            ]);
    
            foreach($data['product_id'] as $key=>$product_id){
                QuotationDetail::create([
                    'quotation_id'            => $quotation->id,
                    'product_id'              => $product_id,
                    'quot_product_qty'        => $data['qty'][$key],
                    'quot_product_unit_price' => $data['rate'][$key],
                    'quot_product_total_price'=> $data['amount'][$key],
                    'quot_product_unit'       => $data['product_unit'][$key],
                    'quot_product_name'       => $data['product_name'][$key],
                    'quot_product_code'       => $data['product_code'][$key],
                    'quot_product_tech_spec'  => $data['product_tech_spec'][$key],
                    'quot_product_m_spec'     => $data['product_m_spec'][$key],
                ]);
            }
    
            $request->session()->forget('quotation_data');
            return $this->quotaionPdf($quotation->id);
        }
        return redirect()->back()->withSuccess('Quotation generated successfully.');
    }

    public function editQuotation(Request $request,$lead_id){
        $quotation = Quotation::where('lead_id',$lead_id)->latest()->first();
        $quotation_details = QuotationDetail::where('quotation_id',$quotation->id)->get();
        $quotation_terms = QuotationTerm::where('quotation_id',$quotation->id)->first();
        $products = Product::where('status','1')->orderBy('product_name','asc')->get();
        return view('admin.lead.edit_quotation',compact(['quotation','quotation_details','quotation_terms','products','lead_id']));
    }

    public function updateQuotation(Request $request){
        $request->validate([
            'quotation_id'      => 'required|integer',
            'lead_id'           => 'required|integer',
            'quot_version'      => 'required|decimal:1',
            'quotation_remarks' => 'required|string',
            'enquiry_ref'       => 'required|string',
            'product_id'        => 'required|array',
            'qty'               => 'required|array',
            'rate'              => 'required|array',
            'amount'            => 'required|array',
        ]);

        Quotation::where('id',$request->quotation_id)->update(['qout_is_latest'=>'0']);
        QuotationTerm::where('quotation_id',$request->quotation_id)->update(['term_is_latest' => '0']);

        $quotation = Quotation::create([
            'lead_id'      => $request->lead_id,
            'quot_ref_no'  => $request->enquiry_ref,
            'quot_remarks' => $request->quotation_remarks,
            'quot_amount'  => array_sum($request->amount),
            'admin_id'     => auth("admin")->user()->id,
            'quot_version' => $request->quot_version + 0.1,
        ]);

        QuotationTerm::create([
            'lead_id'         =>  $request->lead_id,
            'quotation_id'    =>  $quotation->id,
            'term_discount'   =>  $request->discount,
            'term_tax'        =>  $request->tax,
            'term_forwarding' =>  $request->freight_forwarding,
            'term_validity'   =>  $request->validity,
            'term_warranty'   =>  $request->warranty,
            'term_payment'    =>  $request->payment,
            'term_note_1'     =>  $request->note_1,
            'term_note_2'     =>  $request->note_2,
            'term_dispatch'   =>  $request->delivery,
            'term_price'      =>  $request->basis,
        ]);

        foreach($request->product_id as $key=>$product_id){
            QuotationDetail::create([
                'quotation_id'            => $quotation->id,
                'product_id'              => $product_id,
                'quot_product_qty'        => $request->qty[$key],
                'quot_product_unit_price' => $request->rate[$key],
                'quot_product_total_price'=> $request->amount[$key],
                'quot_product_unit'       => $request->product_unit[$key],
                'quot_product_name'       => $request->product_name[$key],
                'quot_product_code'       => $request->product_code[$key],
                'quot_product_tech_spec'  => $request->product_tech_spec[$key],
                'quot_product_m_spec'     => $request->product_m_spec[$key],
            ]);
        }
        $lead = Lead::where('id',$request->lead_id)->first();
        return redirect()->route('admin.leads.show',$lead)->withSuccess('Quotation generated successfully.');

    }


    public function quotaionPdf($quotaion_id)
    {
        $data['quotation'] = Quotation::where('id',$quotaion_id)->first();
        $data['quotaion_details'] = QuotationDetail::where('quotation_id',$quotaion_id)->get();
        $data['quotation_terms'] = QuotationTerm::where('quotation_id',$quotaion_id)->first();
        $pdf = Pdf::loadView('admin.pdf.quotation', $data);
        return $pdf->download('invoice.pdf');
        
    }

}
