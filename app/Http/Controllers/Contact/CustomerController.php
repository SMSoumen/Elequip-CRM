<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Company;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CustomerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Customer access|Customer create|Customer edit|Customer delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Customer create', only: ['create', 'store']),
            new Middleware('role_or_permission:Customer edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Customer delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(Customer::query()->join('companies','customers.company_name','companies.id')->select('customers.*','companies.company_name as company')->orderBy('customers.id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('name_designation', function ($data) {
                    return $data->name_designation = $data->contact_person.'<br>('.$data->designation.')';
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.customers.edit', $data->id);
                    $deleteRoute = route('admin.customers.destroy', $data->id);
                    $edit_type = "page";
                    $permission = 'Customer';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date','name_designation'])->make(true);
            }
            return view('admin.contacts.customer.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $companies = Company::where('status','1')->orderBy('company_name','asc')->get();
        return view('admin.contacts.customer.add',compact(['companies']));
    }

    public function store(Request $request)
    {
        $validated =  $request->validate([
            'contact_person' => 'required|string|unique:customers,contact_person',
            'designation'    => 'required|string',
            'mobile'         => 'required|string',
            'phone'          => 'string',
            'email'          => 'string|email',
            'email2'         => 'required|string|email',
            'company_name'   => 'required|string',
            'address'        => 'string',
        ]);
        $customer = Customer::create($validated);
        if($customer){
            return redirect()->route('admin.customers.index')->withSuccess('Customer added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding customer!!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $companies = Company::where('status','1')->orderBy('company_name','asc')->get();
        $customer = Customer::where('id',$id)->get();
        return view('admin.contacts.customer.edit',compact(['companies','customer']));
    }


    public function update(Request $request, string $id)
    {
        $validated =  $request->validate([
            'contact_person' => "required|string|unique:customers,contact_person,$id",
            'designation'    => 'required|string',
            'mobile'         => 'required|string',
            'phone'          => 'string',
            'email'          => 'string|email',
            'email2'         => 'required|string|email',
            'company_name'   => 'required|string',
            'address'        => 'string',
        ]);
        $customer = Customer::where('id',$id)->update($validated);
        if($customer){
            return redirect()->route('admin.customers.index')->withSuccess('Customer updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating customer!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $Customer)
    {
        $Customer->delete();
        return redirect()->route('admin.customers.index')->withSuccess('Customer deleted successfully !!!');
    }
}
