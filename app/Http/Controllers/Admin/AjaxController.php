<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    public function statusChange(Request $request)
    {
        // dd($request->post('modelName'));

        $validator = Validator::make($request->all(), [
            'modelName' => 'required|string',
            'modelId' => 'required|numeric',
            'status' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'msg' => 'Status could not be changed']);
        }

        $validated = $validator->validated();
        $status = ($validated['status'] == 'true') ? 1 : 0;
        // dd($validated);
        $tableToModelString = Str::studly(Str::singular($validated['modelName']));

        $model = "\App\Models\\" . $tableToModelString;

        // if ($validated['modelName'] == 'sections') {
        $updateState = $model::find($validated['modelId']);
        $updateState->status = $status;
        $updateState->save();
        // } else {
        //     $updateState = DB::table($validated['modelName'])->where('id', $validated['modelId'])->update(['status' => $status]);
        // }


        if ($updateState) {
            return response()->json(['error' => false, 'msg' => $tableToModelString . ' status updated']);
        } else {
            return response()->json(['error' => true, 'msg' => $tableToModelString . ' not updated']);
        }
    }
}
