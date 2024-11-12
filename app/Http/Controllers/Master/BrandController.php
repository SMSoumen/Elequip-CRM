<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Brand;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BrandController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Brand access|Brand create|Brand edit|Brand delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Brand create', only: ['create', 'store']),
            new Middleware('role_or_permission:Brand edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Brand delete', only: ['destroy']),
        ];
    }

    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(Brand::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.brand.edit', $data->id);
                    $deleteRoute = route('admin.brand.destroy', $data->id);
                    $permission = 'Brand';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.brand.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $validated =  $request->validate([
            'brand_name' => 'required|string|unique:brands,brand_name',
        ]);
        $source = Brand::create($validated);
        if($source){
            return redirect()->back()->withSuccess('Brand added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding brand!!!');
        }
    }

    public function destroy(Brand $Brand)
    {
        $Brand->delete();
        return redirect()->back()->withSuccess('Brand deleted successfully !!!');
    }
}
