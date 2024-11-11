<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\MeasuringUnit;
use DataTables;
use Illuminate\View\View;

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
                return DataTables::eloquent(MeasuringUnit::query())->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.measuring-unit.edit', $data->id);
                    $deleteRoute = route('admin.measuring-unit.destroy', $data->id);
                    $permission = 'Measuring Unit';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.measuring_unit.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

}
