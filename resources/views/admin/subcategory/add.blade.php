@extends('admin.layouts.master')
@section('main_content')
    <x-breadcrumb />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <x-alert />
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add Sub Category Form</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <!-- <h5>Custom Color Variants</h5> -->
                    <div class="row">
                        <div class="col-lg-12 col-12">

                            <form action="{{ route('admin.subcategories.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcategory_name">Sub Category Name</label>
                                            <input type="text" required class="form-control" id="subcategory_name"
                                                name="subcategory_name" placeholder="Enter category name"
                                                value="{{ old('subcategory_name') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id">Select Category</label>
                                            <div class="select2-purple">
                                                <select class="form-control form-control select2" id="parent_id" name="category_id">
                                                    @forelse($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                    @empty
                                                    <option value="">No Category found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Select Product Type</label>
                                            <div class="select2-purple">
                                                <select class="select2" multiple="multiple"
                                                    data-placeholder="Select Product Type"
                                                    data-dropdown-css-class="select2-purple" style="width: 100%;"
                                                    id="types" name="types[]">
                                                    @forelse($types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->product_type }}
                                                        </option>
                                                    @empty
                                                        <option value="">No Feature found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subcategory_image">Sub Category Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="subcategory_image"
                                                        name="subcategory_image">
                                                    <label class="custom-file-label" for="subcategory_image">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category_icon">Sub Category Icon</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="category_icon"
                                                        name="category_icon">
                                                    <label class="custom-file-label" for="category_icon">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subcategory_banner">Sub Category Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="subcategory_banner"
                                                        name="subcategory_banner">
                                                    <label class="custom-file-label" for="subcategory_banner">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bg_color">Background Color</label>
                                            <input type="color" required class="form-control" id="bg_color"
                                                name="bg_color" placeholder="Enter Background Color"
                                                value="{{ old('bg_color') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subcategory_ex_title">Sub Category External Title</label>
                                            <input type="text" required class="form-control" id="subcategory_ex_title"
                                                name="subcategory_ex_title" placeholder="Enter category video link"
                                                value="{{ old('subcategory_ex_title') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subcategory_ex_link">Sub Category External Link</label>
                                            <input type="text" required class="form-control" id="subcategory_ex_link"
                                                name="subcategory_ex_link" placeholder="Enter category video link"
                                                value="{{ old('subcategory_ex_link') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subcategory_ex_banner">Sub Category Ex Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                        id="subcategory_ex_banner" name="subcategory_ex_banner">
                                                    <label class="custom-file-label" for="subcategory_ex_banner">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subcategory_desc">Sub Category Description</label>
                                            <textarea class="form-control" name="subcategory_desc" id="subcategory_desc" cols="30" rows="3"
                                                placeholder="Enter...">{{ old('subcategory_desc') }}</textarea>
                                        </div>
                                    </div>
                            
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sub Category Feature Banner</label>
                                            <div class="select2-purple">
                                                <select class="select2" multiple="multiple"
                                                    data-placeholder="Select a features"
                                                    data-dropdown-css-class="select2-purple" style="width: 100%;"
                                                    id="features" name="features[]">
                                                    @forelse($features as $feature)
                                                        <option value="{{ $feature->id }}">{{ $feature->feature_title }} ({{ $feature->feature_tag }})
                                                        </option>
                                                    @empty
                                                        <option value="">No Feature found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    

                                </div>

                                <br>
                                <hr>
                                <h4>SEO INFO <small>(All fields are optional)</small></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="meta_title"> Meta Title</label>
                                            <input type="text" class="form-control form-control-sm" id="meta_title"
                                                name="meta_title" placeholder="Enter meta title"
                                                value="{{ old('meta_title') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control form-control-sm" name="meta_description" id="meta_description" cols="30"
                                                rows="3" placeholder="Enter...">{{ old('meta_description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keyword</label>
                                            <textarea class="form-control form-control-sm" name="meta_keywords" id="meta_keywords" cols="30"
                                                rows="3" placeholder="Enter...">{{ old('meta_keywords') }}</textarea>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="canonical_url"> Canonical Url</label>
                                            <input type="text" class="form-control form-control-sm" id="canonical_url"
                                                name="canonical_url" placeholder="Enter  canonical url"
                                                value="{{ old('canonical_url') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="schema_markup">Schema Markup</label>
                                            <textarea class="form-control form-control-sm" name="schema_markup" id="schema_markup" cols="30"
                                                rows="3" placeholder="Enter...">{{ old('schema_markup') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="focus_keyword">Focus Keyword</label>
                                            <textarea class="form-control form-control-sm" name="focus_keyword" id="focus_keyword" cols="30"
                                                rows="3" placeholder="Enter...">{{ old('focus_keyword') }}</textarea>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="og_title"> Og Url</label>
                                            <input type="text" class="form-control form-control-sm" id="og_title"
                                                name="og_title" placeholder="Enter og title"
                                                value="{{ old('og_title') }}">
                                        </div>
                                    </div>

                                </div>


                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            <!-- /.form-group -->
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
