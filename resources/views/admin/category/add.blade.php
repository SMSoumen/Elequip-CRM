@extends('admin.layouts.master')
@section('main_content')
    <x-breadcrumb />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <x-alert />
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add Category Form</h3>

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

                            <form action="{{ route('admin.categories.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="category_name">Category Name</label>
                                            <input type="text" required class="form-control" id="category_name"
                                                name="category_name" placeholder="Enter category name"
                                                value="{{ old('category_name') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category_image">Category Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="category_image"
                                                        name="category_image">
                                                    <label class="custom-file-label" for="category_image">Choose
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
                                            <label for="category_icon">Category Icon</label>
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
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category_banner">Category Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="category_banner"
                                                        name="category_banner">
                                                    <label class="custom-file-label" for="category_banner">Choose
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
                                            <label for="category_list_banner">Category List Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                        id="category_list_banner" name="category_list_banner">
                                                    <label class="custom-file-label" for="category_list_banner">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8"></div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category_ex_title">Category External Title</label>
                                            <input type="text" required class="form-control" id="category_ex_title"
                                                name="category_ex_title" placeholder="Enter category video link"
                                                value="{{ old('category_ex_title') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category_ex_link">Category External Link</label>
                                            <input type="text" required class="form-control" id="category_ex_link"
                                                name="category_ex_link" placeholder="Enter category video link"
                                                value="{{ old('category_ex_link') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category_ex_banner">Category Ex Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                        id="category_ex_banner" name="category_ex_banner">
                                                    <label class="custom-file-label" for="category_ex_banner">Choose
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
                                            <label for="category_videolink">Category Video Link</label>
                                            <input type="text" required class="form-control" id="category_videolink"
                                                name="category_videolink" placeholder="Enter category video link"
                                                value="{{ old('category_videolink') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category_videothumb">Category Video Thumbnail</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="category_videothumb"
                                                        name="category_videothumb">
                                                    <label class="custom-file-label" for="category_videothumb">Choose
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
                                            <label for="category_sideimg">Category video Side Img</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="category_sideimg"
                                                        name="category_sideimg">
                                                    <label class="custom-file-label" for="category_sideimg">Choose
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

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="category_desc">Category Description</label>
                                            <textarea class="form-control" name="category_desc" id="category_desc" cols="30" rows="3"
                                                placeholder="Enter...">{{ old('category_desc') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="category_list_desc">Category Listing Description</label>
                                            <textarea class="form-control" name="category_list_desc" id="category_list_desc" cols="30" rows="3"
                                                placeholder="Enter...">{{ old('category_list_desc') }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Category Feature Banner</label>
                                            <div class="select2-purple">
                                                <select class="select2" multiple="multiple"
                                                    data-placeholder="Select a features"
                                                    data-dropdown-css-class="select2-purple" style="width: 100%;"
                                                    id="features" name="features[]">
                                                    @forelse($features as $feature)
                                                        <option value="{{ $feature->id }}">{{ $feature->feature_title }} ({{ $feature->feature_tag }})</option>
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
