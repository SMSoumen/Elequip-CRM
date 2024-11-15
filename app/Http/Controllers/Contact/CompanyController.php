<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Imports\CompanyImport;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\City;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Company access|Company create|Company edit|Company delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Company create', only: ['create', 'store']),
            new Middleware('role_or_permission:Company edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Company delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(Company::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.companies.edit', $data->id);
                    $deleteRoute = route('admin.companies.destroy', $data->id);
                    $edit_type = "modal";
                    $permission = 'Company';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            $cities = City::orderBy('city_name','asc')->get();
            return view('admin.contacts.company.index',compact(['cities']));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validated =  $request->validate([
            'company_name' => 'required|string|unique:companies,company_name',
            'city_id'         => 'required|integer',
            'address'      => 'required|string',
            'phone'        => 'string',
            'website'      => 'string',
            'email'        => 'string|email',
            'gst'         => 'string',
        ]);
        $source = Company::create($validated);
        if($source){
            return redirect()->back()->withSuccess('Company added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding company!!!');
        }
    }

    public function show(Company $Company)
    {
        return $Company;
    }

    public function update(Request $request, Company $Company)
    {
        $validated =  $request->validate([
            'company_name' => "required|string|unique:companies,company_name,$Company->id",
            'city'         => 'required|integer',
            'address'      => 'required|string',
            'phone'        => 'string',
            'website'      => 'string',
            'email'        => 'string|email',
            'gst'         => 'string',
        ]);

        if($Company->update($validated)){
            return redirect()->back()->withSuccess('Company updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating company!!!');
        }
    }

    public function destroy(Company $Company)
    {
        $Company->delete();
        return redirect()->back()->withSuccess('Company deleted successfully !!!');
    }

    public function uploadcontact(Request $request)
    {
        return view('admin.contacts.company.upload');
    }

    public function uploadcontactsubmit(Request $request)
    {
        $validated =  $request->validate([                        
            'contact_import_file' => 'file|mimes:xlsx,csv|max:102400',
        ]);

        if ($request->hasFile('contact_import_file')) {
            if ($request->file('contact_import_file')->isValid()) {
                Excel::import(new CompanyImport, $request->file('contact_import_file')->store('temp'));
                return redirect()->back()->withSuccess('Contact import file uploaded successfully !!!');
            }
        }else{
            
            return redirect()->back()->withErrors('Invalid contact import file !!!');
        }


    }


    public function create()
    {
        
    }

    
    public function edit(string $id)
    {
        
    }



}
