<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\SmsFormat;
use DataTables;
use Illuminate\View\View;

class SMSFormatController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:SMS Format access|SMS Format create|SMS Format edit|SMS Format delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:SMS Format create', only: ['create', 'store']),
            new Middleware('role_or_permission:SMS Format edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:SMS Format delete', only: ['destroy']),
        ];
    }


    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(SmsFormat::query())->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.sms-format.edit', $data->id);
                    $deleteRoute = route('admin.sms-format.destroy', $data->id);
                    $permission = 'SMS Format';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.sms_format.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }
}
