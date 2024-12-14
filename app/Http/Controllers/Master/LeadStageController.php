<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\LeadStage;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;

class LeadStageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Lead Stage access|Lead Stage create|Lead Stage edit|Lead Stage delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Lead Stage create', only: ['create', 'store']),
            new Middleware('role_or_permission:Lead Stage edit', only: ['edit', 'update']),
            // new Middleware('role_or_permission:Lead Stage delete', only: ['destroy']),
        ];
    }

    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(LeadStage::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.lead-stage.edit', $data->id);
                    // $deleteRoute = route('admin.lead-stage.destroy', $data->id);
                    $deleteRoute = '';
                    $permission = 'Lead Stage';
                    $edit_type = "modal";

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.lead_stage.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $validated =  $request->validate([
            'stage_name' => 'required|string|unique:lead_stages,stage_name',
        ]);

        $validated['stage_slug'] = Str::slug($validated['stage_name']);
        $source = LeadStage::create($validated);
        if($source){
            return redirect()->back()->withSuccess('Lead stage added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding lead stage!!!');
        }
    }

    public function destroy(LeadStage $LeadStage)
    {
        $LeadStage->delete();
        return redirect()->back()->withSuccess('Lead stage deleted !!!');
    }

    public function show(LeadStage $LeadStage){
        return $LeadStage;
    }

    public function update(Request $request,LeadStage $LeadStage){
        $validated =  $request->validate([
            'stage_name' => "required|string|unique:lead_stages,stage_name,$LeadStage->id",
        ]);
        $validated['stage_slug'] = Str::slug($validated['stage_name']);
        if($LeadStage->update($validated)){
            return redirect()->back()->withSuccess('Lead Stage updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating lead stage!!!');
        }
    }

}
