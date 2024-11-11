<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
// use Image;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\File;
use DataTables;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:Category access|Category create|Category edit|Category delete', only: ['index', 'treeView']),
            new Middleware('role_or_permission:Category create', only: ['create', 'store']),
            new Middleware('role_or_permission:Category edit', only: ['edit', 'update']),
            new Middleware('role_or_permission:Category delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(Category::query())->addColumn('status_action', function ($data) {
                    $table = 'categories';
                    return view('admin.layouts.partials.listing_status_switch', compact(['data', 'table']));
                })->addColumn('category_image', function ($data) {
                    $collection = 'category_image';
                    $conversion = 'webp-format';

                    return view('admin.layouts.partials.table_image', compact(['data', 'collection', 'conversion']));
                })->addColumn('status', function ($data) {
                    return $data->status == 1 ? 'Active' :  "Inactive";
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.categories.edit', $data->id);
                    $deleteRoute = route('admin.categories.destroy', $data->id);
                    $permission = 'Category';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission']))->render();
                })->addIndexColumn()->rawColumns(['action', 'status_action', 'status', 'category_image'])->make(true);
            }
            return view('admin.category.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // $icons = Icon::get();
        $features = Feature::get();
        return view('admin.category.add', compact(['features']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $validated =  $request->validate([
            // 'parent_id' => 'required|numeric',
            'category_name' => 'required|string|unique:categories,category_name',
            'category_image' => 'required|file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            'category_icon' => 'required|file|image|mimes:svg|min:1|max:200',
            'category_banner' => 'required|file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:1024',
            'category_videolink' => 'min:1|max:500',
            'category_videothumb' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            'category_sideimg' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:200',

            'category_list_banner' => 'required|file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:1024',
            'category_ex_title' => 'min:1|max:250',
            'category_ex_link' => 'min:1|max:250',
            'category_ex_banner' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',

            'category_desc' => 'required|max:10000',
            'category_list_desc' => 'required|max:10000',
            'bg_color' => 'required|max:50',

            'features.*' => 'required',

            'meta_title' => 'max:500',
            'meta_description' => 'max:5000',
            'meta_keywords' => 'max:1000',
            'canonical_url' => 'max:500',
            'schema_markup' => 'max:30000',
            'focus_keyword' => 'max:1000',
            'og_title' => 'max:500',
        ]);

        $validated['category_slug'] = Str::slug($validated['category_name']);

        if ($request->hasFile('category_icon')) {
            if ($request->file('category_icon')->isValid()) {

                $fileName = time() . '-' . str_replace(' ', '-', $request->category_icon->getClientOriginalName());
                $filePath = $request->category_icon->storeAs(Config::get('app_url.asset_category_url'), $fileName);
                // $imagePath = upload_file($request->category_icon, "",  Config::get('app_url.asset_category_url'), 650);
                $validated['category_icon'] =  $fileName;
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        $category = Category::create($validated);

        $category->features()->attach($validated['features']);

        if ($request->hasFile('category_image')) {
            if ($request->file('category_image')->isValid()) {
                $category->addMedia($request->file('category_image'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_image');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        // if ($request->hasFile('category_icon')) {
        //     if ($request->file('category_icon')->isValid()) {
        //         $category->addMedia($request->file('category_icon'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_icon');
        //     } else {
        //         return redirect()->back()->withErrors('Invalid image !!!');
        //     }
        // }



        if ($request->hasFile('category_banner')) {
            if ($request->file('category_banner')->isValid()) {
                $category->addMedia($request->file('category_banner'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        if ($request->hasFile('category_list_banner')) {
            if ($request->file('category_list_banner')->isValid()) {
                $category->addMedia($request->file('category_list_banner'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_list_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }
        if ($request->hasFile('category_ex_banner')) {
            if ($request->file('category_ex_banner')->isValid()) {
                $category->addMedia($request->file('category_ex_banner'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_ex_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }


        if ($request->hasFile('category_videothumb')) {
            if ($request->file('category_videothumb')->isValid()) {
                $category->addMedia($request->file('category_videothumb'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_videothumb');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }
        if ($request->hasFile('category_sideimg')) {
            if ($request->file('category_sideimg')->isValid()) {
                $category->addMedia($request->file('category_sideimg'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_sideimg');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }


        return redirect()->back()->withSuccess('Category added !!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        $features = Feature::get();
        // $categories = Category::where('id', "!=", $category->id)->get();
        // dd($categories);
        return view('admin.category.edit', compact(['category', 'features']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        // abort(404);
        $validated =  $request->validate([
            // 'parent_id' => 'required|numeric',
            'category_name' => "required|string|unique:categories,category_name,$category->id",
            'category_image' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            'category_icon' => 'file|image|mimes:svg|min:1|max:200',
            'category_banner' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:1024',
            'category_videolink' => 'min:1|max:500',
            'category_videothumb' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            'category_sideimg' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:200',

            'category_list_banner' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:1024',
            'category_ex_title' => 'min:1|max:250',
            'category_ex_link' => 'min:1|max:250',
            'category_ex_banner' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',

            'category_desc' => 'required|max:10000',
            'category_list_desc' => 'required|max:10000',
            'bg_color' => 'required|max:50',

            'features.*' => 'required',

            'meta_title' => 'max:500',
            'meta_description' => 'max:5000',
            'meta_keywords' => 'max:1000',
            'canonical_url' => 'max:500',
            'schema_markup' => 'max:30000',
            'focus_keyword' => 'max:1000',
            'og_title' => 'max:500',
        ]);

        $validated['category_slug'] = Str::slug($validated['category_name']);

        if ($request->hasFile('category_icon')) {
            if ($request->file('category_icon')->isValid()) {

                $fileName = time() . '-' . str_replace(' ', '-', $request->category_icon->getClientOriginalName());
                $filePath = $request->category_icon->storeAs(Config::get('app_url.asset_category_url'), $fileName);
                // $imagePath = upload_file($request->category_icon, "",  Config::get('app_url.asset_category_url'), 650);
                $validated['category_icon'] =  $fileName;
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        $category->update($validated);

        $category->features()->sync($validated['features']);

        if ($request->hasFile('category_image')) {
            if ($request->file('category_image')->isValid()) {
                $category->clearMediaCollection('category_image');
                $category->addMedia($request->file('category_image'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_image');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        // if ($request->hasFile('category_icon')) {
        //     if ($request->file('category_icon')->isValid()) {
        //         $category->addMedia($request->file('category_icon'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_icon');
        //     } else {
        //         return redirect()->back()->withErrors('Invalid image !!!');
        //     }
        // }



        if ($request->hasFile('category_banner')) {
            if ($request->file('category_banner')->isValid()) {
                $category->clearMediaCollection('category_banner');
                $category->addMedia($request->file('category_banner'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }

        if ($request->hasFile('category_list_banner')) {
            if ($request->file('category_list_banner')->isValid()) {
                $category->clearMediaCollection('category_list_banner');
                $category->addMedia($request->file('category_list_banner'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_list_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }
        if ($request->hasFile('category_ex_banner')) {
            if ($request->file('category_ex_banner')->isValid()) {
                $category->clearMediaCollection('category_ex_banner');
                $category->addMedia($request->file('category_ex_banner'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_ex_banner');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }


        if ($request->hasFile('category_videothumb')) {
            if ($request->file('category_videothumb')->isValid()) {
                $category->clearMediaCollection('category_videothumb');
                $category->addMedia($request->file('category_videothumb'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_videothumb');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }
        if ($request->hasFile('category_sideimg')) {
            if ($request->file('category_sideimg')->isValid()) {
                $category->clearMediaCollection('category_sideimg');
                $category->addMedia($request->file('category_sideimg'))->usingName($request->category_name)->withCustomProperties(['alt' => $request->category_name])->toMediaCollection('category_sideimg');
            } else {
                return redirect()->back()->withErrors('Invalid image !!!');
            }
        }
        return redirect()->back()->withSuccess('Category updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->clearMediaCollection('category_image');
        $category->clearMediaCollection('category_banner');
        $category->clearMediaCollection('category_list_banner');
        $category->clearMediaCollection('category_ex_banner');
        $category->clearMediaCollection('category_videothumb');
        $category->clearMediaCollection('category_sideimg');
        $category->delete();

        return redirect()->back()->withSuccess('Category deleted !!!');
    }
    
}
