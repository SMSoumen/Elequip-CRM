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
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Exception;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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
    public function show(Lead $lead)
    {

        $fllowup_date = LeadFollowup::where('lead_id',$lead->id)->latest()->first();
        $companies = Company::where('status','1')->orderBy('company_name','asc')->get();
        $customers = Customer::where('status','1')->orderBy('customer_name','asc')->get();
        $categories = LeadCategory::where('status','1')->orderBy('category_name','asc')->get();
        $sources = LeadSource::where('status','1')->orderBy('source_name','asc')->get();
        $products = Product::where('status','1')->orderBy('product_name','asc')->get();
        $stages = LeadStage::where('status','1')->orderBy('id','asc')->get();
        $lead_details = LeadDetail::where('lead_id',$lead->id)->get();
        return view('admin.lead.view',compact(['companies','customers','categories','sources','products','stages','lead','fllowup_date','lead_details']));
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
        $product = Product::whereIn('id',$request->product_id)->get();
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

    // public function leadStageUpdate(Request $request){
    //     $request->validate([
    //         'lead_stage_id' => 'required|integer',
    //         'lead_id'       => 'required|integer',
    //     ]);
    //     if(Lead::where('id',$request->lead_id)->update(['lead_stage_id' => $request->lead_stage_id, 'lead_remarks' => $request->remarks])){
    //         return redirect()->back()->withSuccess('Lead stage updated successfully.');
    //     }else{
    //         return redirect()->back()->withErrors('Error!! while updating lead stage!!!');
    //     }
    // }
}
