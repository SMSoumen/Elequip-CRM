<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;
class ProductSubCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:ProductSubCategory access|ProductSubCategory create|ProductSubCategory edit|ProductSubCategory delete', only: ['index', 'allSubCategory']),
            new Middleware('role_or_permission:ProductSubCategory create', only: ['create', 'store']),
            new Middleware('role_or_permission:ProductSubCategory edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:ProductSubCategory delete', only: ['destroy']),

        ];
    }  

    public function allSubCategory(Request $request,$cat_id){
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(ProductSubCategory::query()->where('product_category_id',$cat_id)->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('no_of_subcategory', function ($data) {
                    return $data->no_of_subcategory = ProductSubCategory::where('product_category_id',$data->id)->count();
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.product-subcategories.edit', $data->id);
                    // $deleteRoute = route('admin.product-subcategories.destroy', $data->id);
                    $deleteRoute = null;
                    $edit_type = "modal";
                    $permission = 'ProductSubCategory';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute','permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date','no_of_subcategory'])->make(true);
            }
            $category = ProductCategory::where('id',$cat_id)->first(['product_category_name']);
            return view('admin.products.subcategory.index',compact(['cat_id','category']));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }

    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated =  $request->validate([
            'product_subcat_name' => 'required|string',
            'product_category_id' => 'required|integer',
        ]);

        $validated['product_subcat_slug'] = Str::slug($validated['product_subcat_name']);
        $category = ProductSubCategory::create($validated);
        if($category){
            return redirect()->back()->withSuccess('Sub Category added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding sub category!!!');
        }
    }

    public function show($id)
    {
        $sub_cat = ProductSubCategory::where('id',$id)->first();
        return $sub_cat;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSubCategory $productSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validated =  $request->validate([
            'product_subcat_name' => "required|string",
            'product_category_id' => 'required|integer',
        ]);

        $validated['product_subcat_slug'] = Str::slug($validated['product_subcat_name']);
        $subcategory = ProductSubCategory::where('id',$id)->update($validated);
        if($subcategory){
            return redirect()->back()->withSuccess('Sub Category updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating sub category!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        ProductSubCategory::where('id',$id)->delete();
        return redirect()->back()->withSuccess('Sub Category deleted successfully !!!');
    }
}
