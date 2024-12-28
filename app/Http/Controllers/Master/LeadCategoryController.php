<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\LeadCategory;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;

class LeadCategoryController extends Controller implements HasMiddleware
{
    
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Lead Category access|Lead Category create|Lead Category edit|Lead Category delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Lead Category create', only: ['create', 'store']),
            new Middleware('role_or_permission:Lead Category edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Lead Category delete', only: ['destroy']),
        ];
    }


    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(LeadCategory::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.lead-category.edit', $data->id);
                    // $deleteRoute = route('admin.lead-category.destroy', $data->id);
                    $deleteRoute = null;
                    $permission = 'Lead Category';
                    $edit_type = "modal";

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.lead_category.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $validated =  $request->validate([
            'category_name' => 'required|string|unique:lead_categories,category_name',
        ]);

        $validated['category_slug'] = Str::slug($validated['category_name']);
        $category = LeadCategory::create($validated);
        if($category){
            return redirect()->back()->withSuccess('Category added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding category!!!');
        }
    }

    public function create(Request $request){
    }

    public function destroy(LeadCategory $LeadCategory)
    {
        $LeadCategory->delete();
        return redirect()->back()->withSuccess('Category deleted !!!');
    }

    public function show(LeadCategory $LeadCategory){
        return $LeadCategory;
    }

    public function update(Request $request,LeadCategory $LeadCategory){
        $validated =  $request->validate([
            'category_name' => "required|string|unique:lead_categories,category_name,$LeadCategory->id",
        ]);
        $validated['category_slug'] = Str::slug($validated['category_name']);
        if($LeadCategory->update($validated)){
            return redirect()->back()->withSuccess('Lead Category updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating lead category!!!');
        }
    }


}
