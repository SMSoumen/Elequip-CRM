<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
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
        $tableToModelString = Str::ucfirst(Str::singular($validated['modelName']));
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

    public function getProductAttrValue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attr_id' => 'required|numeric',
            // 'product_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'msg' => $validator->errors()]);
        }

        // $product = Product::firstWhere('id', $request->post('product_id'));

        // if ($product->id) {
        //     Attribute::create(['product_id' => $product->id, 'product_attribute_id' => $request->post('attr_id')]);
        // } else {
        //     return response()->json(['error' => true, 'msg' => 'Product not found']);
        // }


        $attribute = Attribute::with('attribute_values')->where('id', $request->attr_id)->first();

        // dd($attribute->toArray());

        $viewdata = view('admin.layouts.partials.append_product_attribute', compact('attribute'))->render();

        if ($viewdata) {
            return response()->json(['error' => false, 'msg' => 'Attribute found', 'data' => ['viewdata' => $viewdata, 'rawdata' => ['attribute_slug' => $attribute->attribute_slug]]]);
        }

        return response()->json(['error' => true, 'msg' => 'Attribute not found']);
    }

    public function getProductVariantTemplate(Request $request)
    {
        // return $request->all();
        $attr_names =  $request->post('attr_names');
        $attr_values = $request->post('attr_values');
        $variation_counter = $request->post('variation_counter');
        // return value($attr_values[0][0][0]);

        $viewdata = view('admin.layouts.partials.product_dynamic_variant_template', compact(['attr_names', 'attr_values', 'variation_counter']))->render();

        return response()->json(['error' => false, 'msg' => 'Attribute found', 'data' => ['viewdata' => $viewdata,]]);
    }
}
