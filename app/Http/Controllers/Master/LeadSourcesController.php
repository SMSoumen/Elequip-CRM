<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\LeadSources;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;

class LeadSourcesController extends Controller implements HasMiddleware
{
    
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Lead Sources access|Lead Sources create|Lead Sources edit|Lead Sources delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Lead Sources create', only: ['create', 'store']),
            new Middleware('role_or_permission:Lead Sources edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Lead Sources delete', only: ['destroy']),
        ];
    }

    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(LeadSources::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.lead-sources.edit', $data->id);
                    $deleteRoute = route('admin.lead-sources.destroy', $data->id);
                    $permission = 'Lead Sources';
                    $edit_type = "modal";

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.lead_sources.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $validated =  $request->validate([
            'source_name' => 'required|string|unique:lead_sources,source_name',
        ]);

        $validated['source_slug'] = Str::slug($validated['source_name']);
        $source = LeadSources::create($validated);
        if($source){
            return redirect()->back()->withSuccess('Lead source added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding lead source!!!');
        }
    }

    public function destroy(LeadSources $LeadSources)
    {
        $LeadSources->delete();
        return redirect()->back()->withSuccess('Lead source deleted successfully. !!!');
    }

    public function show(LeadSources $LeadSources){
        return LeadSources::where('id',$LeadSources->id)->get();
        //return $LeadSources;
    }

    public function update(Request $request,LeadSources $LeadSources){
        $validated =  $request->validate([
            'source_name' => "required|string|unique:lead_sources,source_name,$LeadSources->id",
        ]);
        $validated['source_slug'] = Str::slug($validated['source_name']);
        if($LeadSources->update($validated)){
            return redirect()->back()->withSuccess('Lead Source updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating lead source!!!');
        }
    }

}
