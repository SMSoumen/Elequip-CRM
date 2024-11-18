<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Company;
use App\Models\Customer;
use App\Models\LeadSource;
use App\Models\LeadCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
                return DataTables::eloquent(Lead::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.leads.edit', $data->id);
                    $deleteRoute = route('admin.leads.destroy', $data->id);
                    $edit_type = "page";
                    $permission = 'Lead';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.lead.index');
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
        $validated =  $request->validate([
            'company_id' => 'required|string|unique:companies,company_name',
            'lead_source_id'         => 'required|integer',
            'customer_id'      => 'required|string',
            'lead_category_id'        => 'string',
            'lead_estimate_closure_date'      => 'string',
            'product_id'        => 'string|email',
            'qty'         => 'string',
            'amount'      => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }

    public function productDetails(Request $request){
        $product = Product::whereIn('id',$request->product_id)->get();
        return $product;
    }
}
