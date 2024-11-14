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
            new Middleware('role_or_permission:SmsFormat access|SmsFormat create|SmsFormat edit|SmsFormat delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:SmsFormat create', only: ['create', 'store']),
            new Middleware('role_or_permission:SmsFormat edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:SmsFormat delete', only: ['destroy']),
        ];
    }


    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(SmsFormat::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.sms-format.edit', $data->id);
                    $deleteRoute = route('admin.sms-format.destroy', $data->id);
                    $permission = 'SmsFormat';
                    $edit_type = "modal";

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date'])->make(true);
            }
            return view('admin.master.sms_format.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        $validated =  $request->validate([
            'template_name' => 'required|string|unique:sms_formats,template_name',
            'template_id' => 'required|string|unique:sms_formats,template_id',
            'template_format' => 'required|string',

        ]);
        $sms = SmsFormat::create($validated);
        if($sms){
            return redirect()->back()->withSuccess('SMS Format added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding sms format!!!');
        }
    }

    public function destroy(SmsFormat $SmsFormat)
    {
        $SmsFormat->delete();
        return redirect()->back()->withSuccess('SMS Format deleted successfully. !!!');
    }

    public function show(SmsFormat $SmsFormat){
        return $SmsFormat;
    }

    public function update(Request $request,SmsFormat $SmsFormat){
        $validated =  $request->validate([
            'template_name' => "required|string|unique:sms_formats,template_name,$SmsFormat->id",
            'template_id' => "required|string|unique:sms_formats,template_id,$SmsFormat->id",
            'template_format' => 'required|string',
        ]);

        if($SmsFormat->update($validated)){
            return redirect()->back()->withSuccess('SMS Format updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating sms format!!!');
        }
    }
}
