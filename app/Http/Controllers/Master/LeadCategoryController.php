<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\LeadCategory;
use DataTables;
use Illuminate\View\View;

class LeadCategoryController extends Controller implements HasMiddleware
{
    
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Lead Category access|Lead create|Lead edit|Lead delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Lead Category create', only: ['create', 'store']),
            new Middleware('role_or_permission:Lead Category edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Lead Category delete', only: ['destroy']),
        ];
    }


    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(LeadCategory::query())->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-success">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.lead-category.edit', $data->id);
                    $deleteRoute = route('admin.lead-category.destroy', $data->id);
                    $permission = 'Lead Category';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.lead_category.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function create(Request $request){


    }

    public function edit(LeadCategory $LeadCategory): View
    {

    }

    public function destroy(LeadCategory $LeadCategory)
    {
    }
}
