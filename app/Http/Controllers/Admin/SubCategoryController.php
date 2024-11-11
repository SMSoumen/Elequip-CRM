<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Feature;
use App\Models\ProductType;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use Illuminate\Support\Str;

class SubCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:SubCategory access|SubCategory create|SubCategory edit|SubCategory delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:SubCategory create', only: ['create', 'store']),
            new Middleware('role_or_permission:SubCategory edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:SubCategory delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(SubCategory::query())->addColumn('status_action', function ($data) {
                    $table = 'SubCategories';
                    return view('admin.layouts.partials.listing_status_switch', compact(['data', 'table']));
                })->addColumn('subcategory_image', function ($data) {
                    $collection = 'subcategory_image';
                    $conversion = 'webp-format';

                    return view('admin.layouts.partials.table_image', compact(['data', 'collection', 'conversion']));
                })->addColumn('status', function ($data) {
                    return $data->status == 1 ? 'Active' :  "Inactive";
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.subcategories.edit', $data->id);
                    $deleteRoute = route('admin.subcategories.destroy', $data->id);
                    $permission = 'SubCategory';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission']))->render();
                })->addIndexColumn()->rawColumns(['action', 'status_action', 'status', 'subcategory_image'])->make(true);
            }
            return view('admin.subcategory.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $features = Feature::get();
        $categories = Category::get();
        $types = ProductType::get();
        return view('admin.subcategory.add', compact(['features', 'categories', 'types']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated =  $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required|string|unique:sub_categories,subcategory_name',
            'subcategory_image' => 'required|file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            // 'category_icon' => 'required|file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:200',
            'subcategory_banner' => 'required|file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:1024',
            'subcategory_ex_title' => 'min:1|max:250',
            'subcategory_ex_link' => 'min:1|max:250',
            'subcategory_ex_banner' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            // 'category_sideimg' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:200',

            'subcategory_desc' => 'required|max:10000',
            'bg_color' => 'required|max:50',

            'features.*' => 'required',
            'types.*' => 'required',

            'meta_title' => 'max:500',
            'meta_description' => 'max:5000',
            'meta_keywords' => 'max:1000',
            'canonical_url' => 'max:500',
            'schema_markup' => 'max:30000',
            'focus_keyword' => 'max:1000',
            'og_title' => 'max:500',
        ]);

        $validated['subcategory_slug'] = Str::slug($validated['subcategory_name']);

        $category = SubCategory::create($validated);

        // $category->icons()->attach($validated['icons']);
        $category->features()->attach($validated['features']);
        $category->types()->attach($validated['types']);

        if ($request->hasFile('subcategory_image')) {
            if ($request->file('subcategory_image')->isValid()) {
                $category->addMedia($request->file('subcategory_image'))->usingName($request->subcategory_name)->withCustomProperties(['alt' => $request->subcategory_name])->toMediaCollection('subcategory_image');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        // if ($request->hasFile('category_icon')) {
        //     if ($request->file('category_icon')->isValid()) {
        //         $category->addMedia($request->file('category_icon'))->usingName($request->subcategory_name)->withCustomProperties(['alt' => $request->subcategory_name])->toMediaCollection('category_icon');
        //     } else {
        //         return redirect()->back()->withErrors('Invalid image !!!');
        //     }
        // }
        if ($request->hasFile('subcategory_banner')) {
            if ($request->file('subcategory_banner')->isValid()) {
                $category->addMedia($request->file('subcategory_banner'))->usingName($request->subcategory_name)->withCustomProperties(['alt' => $request->subcategory_name])->toMediaCollection('subcategory_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }
        if ($request->hasFile('subcategory_ex_banner')) {
            if ($request->file('subcategory_ex_banner')->isValid()) {
                $category->addMedia($request->file('subcategory_ex_banner'))->usingName($request->subcategory_name)->withCustomProperties(['alt' => $request->subcategory_name])->toMediaCollection('subcategory_ex_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }
        // if ($request->hasFile('category_sideimg')) {
        //     if ($request->file('category_sideimg')->isValid()) {
        //         $category->addMedia($request->file('category_sideimg'))->usingName($request->subcategory_name)->withCustomProperties(['alt' => $request->subcategory_name])->toMediaCollection('category_sideimg');
        //     } else {
        //         return redirect()->back()->withErrors('Invalid image !!!');
        //     }
        // }


        return redirect()->back()->withSuccess('Sub Category added !!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {
        $features = Feature::get();
        $categories = Category::get();
        $types = ProductType::get();
        return view('admin.subcategory.edit', compact(['features', 'categories', 'types', 'subcategory']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $validated =  $request->validate([
            'category_id' => 'required',
            'subcategory_name' => "required|string|unique:sub_categories,subcategory_name,$subcategory->id",
            'subcategory_image' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            // 'category_icon' => 'required|file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:200',
            'subcategory_banner' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:1024',
            'subcategory_ex_title' => 'min:1|max:250',
            'subcategory_ex_link' => 'min:1|max:250',
            'subcategory_ex_banner' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            // 'category_sideimg' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:200',

            'subcategory_desc' => 'required|max:10000',
            'bg_color' => 'required|max:50',

            'features.*' => 'required',
            'types.*' => 'required',

            'meta_title' => 'max:500',
            'meta_description' => 'max:5000',
            'meta_keywords' => 'max:1000',
            'canonical_url' => 'max:500',
            'schema_markup' => 'max:30000',
            'focus_keyword' => 'max:1000',
            'og_title' => 'max:500',
        ]);

        $validated['subcategory_slug'] = Str::slug($validated['subcategory_name']);

        $subcategory->update($validated);

        $subcategory->features()->sync($validated['features']);
        $subcategory->types()->sync($validated['types']);

        if ($request->hasFile('subcategory_image')) {
            if ($request->file('subcategory_image')->isValid()) {
                $subcategory->clearMediaCollection('subcategory_image');
                $subcategory->addMedia($request->file('subcategory_image'))->usingName($request->subcategory_name)->withCustomProperties(['alt' => $request->subcategory_name])->toMediaCollection('subcategory_image');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        if ($request->hasFile('subcategory_banner')) {
            if ($request->file('subcategory_banner')->isValid()) {
                $subcategory->clearMediaCollection('subcategory_banner');
                $subcategory->addMedia($request->file('subcategory_banner'))->usingName($request->subcategory_name)->withCustomProperties(['alt' => $request->subcategory_name])->toMediaCollection('subcategory_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }
        if ($request->hasFile('subcategory_ex_banner')) {
            if ($request->file('subcategory_ex_banner')->isValid()) {
                $subcategory->clearMediaCollection('subcategory_ex_banner');
                $subcategory->addMedia($request->file('subcategory_ex_banner'))->usingName($request->subcategory_name)->withCustomProperties(['alt' => $request->subcategory_name])->toMediaCollection('subcategory_ex_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        return redirect()->back()->withSuccess('Sub Category added !!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subcategory)
    {
        $subcategory->clearMediaCollection('subcategory_image');
        $subcategory->clearMediaCollection('subcategory_banner');
        $subcategory->clearMediaCollection('subcategory_ex_banner');
        $subcategory->delete();

        return redirect()->back()->withSuccess('Category deleted !!!');
    }
}
