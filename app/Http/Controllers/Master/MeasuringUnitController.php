<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\MeasuringUnit;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;

class MeasuringUnitController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Measuring Unit access|Measuring Unit create|Measuring Unit edit|Measuring Unit delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Measuring Unit create', only: ['create', 'store']),
            new Middleware('role_or_permission:Measuring Unit edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Measuring Unit delete', only: ['destroy']),
        ];
    }


    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(MeasuringUnit::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.measuring-unit.edit', $data->id);
                    $deleteRoute = route('admin.measuring-unit.destroy', $data->id);
                    $permission = 'Measuring Unit';
                    $edit_type = "modal";

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.measuring_unit.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $validated =  $request->validate([
            'unit_type' => 'required|string|unique:measuring_units,unit_type',
        ]);
        $source = MeasuringUnit::create($validated);
        if($source){
            return redirect()->back()->withSuccess('Measuring Units added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding measuring units!!!');
        }
    }

    public function destroy(MeasuringUnit $MeasuringUnit)
    {
        $MeasuringUnit->delete();
        return redirect()->back()->withSuccess('Measuring Unit deleted !!!');
    }

    public function show(MeasuringUnit $MeasuringUnit){
        return $MeasuringUnit;
    }

    public function update(Request $request,MeasuringUnit $MeasuringUnit){
        $validated =  $request->validate([
            'unit_type' => "required|string|unique:measuring_units,unit_type,$MeasuringUnit->id",
        ]);
        if($MeasuringUnit->update($validated)){
            return redirect()->back()->withSuccess('Measuring Unit updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating measuring unit!!!');
        }
    }
}
