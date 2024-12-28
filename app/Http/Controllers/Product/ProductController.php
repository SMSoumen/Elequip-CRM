<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use App\Models\Brand;
use App\Models\MeasuringUnit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Product access|Product create|Product edit|Product delete', only: ['index', 'subCategoryList']),
            new Middleware('role_or_permission:Product create', only: ['create', 'store', 'uploadProduct']),
            new Middleware('role_or_permission:Product edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Product delete', only: ['destroy']),
        ];
    }  

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {

                $query = Product::query()->with('category','sub_category','brand','unit');

                // Product::query()->join('product_categories','products.product_category_id','product_categories.id')
                // ->join('product_sub_categories','products.product_sub_category_id','product_sub_categories.id')
                // ->select('products.*','product_categories.product_category_name','product_sub_categories.product_subcat_name')->orderBy('products.id','desc')


                return DataTables::eloquent($query)->addColumn('product_category_name', function ($data) {
                    return $data->category->product_category_name;
                })->addColumn('product_subcat_name', function ($data) {
                    return $data->sub_category?->product_subcat_name;
                })->addColumn('status', function ($data) {
                    //return $data->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';

                    $table = 'products';
                    return view('admin.layouts.partials.listing_status_switch', compact(['data','table']))->render();

                })->addColumn('created_date', function ($data) {
                    return $data->created_date = date('d-m-Y',strtotime($data->created_at));
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.products.edit', $data->id);
                    // $deleteRoute = route('admin.products.destroy', $data->id);
                    $deleteRoute = null;
                    $edit_type = "page";
                    $permission = 'Product';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute','permission','edit_type']))->render();
                })->addIndexColumn()->rawColumns(['action','status','created_date','no_of_subcategory', 'product_category_name', 'product_subcat_name'])->make(true);
            }
            return view('admin.products.product.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        $categories = ProductCategory::where('status','1')->orderBy('product_category_name','asc')->get();
        $brands = Brand::where('status','1')->orderBy('brand_name','asc')->get();
        $units = MeasuringUnit::where('status','1')->orderBy('unit_type','asc')->get();
        return view('admin.products.product.add',compact(['categories','brands','units']));

    }

    public function subCategoryList(Request $request){
        $subcategories = ProductSubCategory::where('product_category_id',$request->cat_id)->where('status','1')->orderBy('product_subcat_name','asc')->get();
        return $subcategories;
    }

    public function store(Request $request)
    {
        $validated =  $request->validate([
            'product_name'  => 'required|string',
            'product_code'  => 'required|string|unique:products,product_code',
            'product_price' => 'required|integer',
            'product_category_id'     => 'required|integer',
            'product_sub_category_id' => 'integer|nullable',
            'brand_id'          => 'integer|nullable',
            'measuring_unit_id' => 'required|integer',
            'product_tech_spec' => 'required|string',
            'product_marketing_spec' => 'string|nullable',
        ]);

        $validated['product_code'] = strtoupper($validated['product_code']);

        $product = Product::create($validated);
        if($product){
            return redirect()->route('admin.products.index')->withSuccess('Product added successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while adding product!!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('status','1')->orderBy('product_category_name','asc')->get();
        $brands = Brand::where('status','1')->orderBy('brand_name','asc')->get();
        $units = MeasuringUnit::where('status','1')->orderBy('unit_type','asc')->get();
        $subcategories = ProductSubCategory::where('status','1')->orderBy('product_subcat_name','asc')->get();
        return view('admin.products.product.edit',compact(['categories','brands','units','product','subcategories']));
    }


    public function update(Request $request, Product $product)
    {
        $validated =  $request->validate([
            'product_name'  => 'required|string',
            'product_code'  => "required|string|unique:products,product_code,$product->id",
            'product_price' => 'required|decimal:2',
            'product_category_id'     => 'required|integer',
            'product_sub_category_id' => 'integer|nullable',
            'brand_id'          => 'integer|nullable',
            'measuring_unit_id' => 'required|integer',
            'product_tech_spec' => 'required|string',
            'product_marketing_spec' => 'string|nullable',
        ]);
        $validated['product_code'] = strtoupper($validated['product_code']);
        $product = $product->update($validated);
        if($product){
            return redirect()->route('admin.products.index')->withSuccess('Product updated successfully.');
        }else{
            return redirect()->back()->withErrors('Error!! while updating product!!!');
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->withSuccess('Product deleted successfully.');
    }

    public function uploadProduct(Request $request)
    {
        $request->validate([
            'excel'  => 'required|file|extensions:csv,xlsx',
        ]); 

        Excel::import(new ProductImport, $request->excel);
        return redirect()->route('admin.products.index')->withSuccess('Product Uploaded successfully.');
    }
}
