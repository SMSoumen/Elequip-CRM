<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:ProductCategory access|ProductCategory create|ProductCategory edit|ProductCategory delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:ProductCategory create', only: ['create', 'store']),
            new Middleware('role_or_permission:ProductCategory edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:ProductCategory delete', only: ['destroy']),

        ];
    }  
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(ProductCategory::query()->orderBy('id','desc'))->addColumn('status', function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('no_of_subcategory', function ($data) {
                    return $data->no_of_subcategory = ProductSubCategory::where('product_category_id',$data->id)->count();
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.product-categories.edit', $data->id);
                    // $deleteRoute = route('admin.product-categories.destroy', $data->id);
                    $subcategoryRoute = route('admin.product-subcategories.all', $data->id);
                    $deleteRoute = null;
                    $edit_type = "modal";
                    $type="subcategory_list";
                    $permission = 'ProductCategory';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute','subcategoryRoute','permission','edit_type','type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date','no_of_subcategory'])->make(true);
            }
            return view('admin.products.category.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }



    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validated =  $request->validate([
            'product_category_name' => 'required|string|unique:product_categories,product_category_name',
        ]);

        $validated['product_category_slug'] = Str::slug($validated['product_category_name']);
        $category = ProductCategory::create($validated);
        if($category){
            return redirect()->back()->withSuccess('Category added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding category!!!');
        }
    }

    public function show(ProductCategory $productCategory)
    {
        return $productCategory;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated =  $request->validate([
            'product_category_name' => "required|string|unique:product_categories,product_category_name,$productCategory->id",
        ]);

        $validated['product_category_slug'] = Str::slug($validated['product_category_name']);
        $category = $productCategory->update($validated);
        if($category){
            return redirect()->back()->withSuccess('Category updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating category!!!');
        }
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return redirect()->back()->withSuccess('Category deleted successfully !!!');
    }
}
