@extends('admin.layouts.master')
@section('main_content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Edit Product</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        <form action="{{route('admin.products.update',$product)}}" method="post">@csrf
                        @method('PUT')
                            <div class="row">
                                    <div class="col-6">
                                        <label for="product_name">Product Title <span class="text-danger"> *</span></label>
                                        <input type="text" name="product_name" id="product_name" class="form-control" required value="{{$product->product_name}}">
                                    </div>

                                    <div class="col-6">
                                        <label for="product_code">Product Code <span class="text-danger"> *</span></label>
                                        <input type="text" name="product_code" id="product_code" class="form-control" required value="{{$product->product_code}}">
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="product_category_id">Product Category <span class="text-danger"> *</span></label>
                                        <select name="product_category_id" id="product_category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" @if($category->id == $product->product_category_id) {{'selected'}} @endif>{{$category->product_category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6 mt-2 load_subcat">
                                        <label for="product_sub_category_id">Product Sub-Category <span class="text-danger"> *</span></label>
                                        <select name="product_sub_category_id" id="product_sub_category_id" class="form-control" required>
                                            <option value="">Select Sub-Category</option>
                                            @foreach($subcategories as $subcategory)
                                             <option value="{{$subcategory->id}}" @if($subcategory->id == $product->product_sub_category_id) {{'selected'}} @endif>{{$subcategory->product_subcat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <label for="brand_id">Product Brand <span class="text-danger"> *</span></label>
                                        <select name="brand_id" id="brand_id" class="form-control" required>
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}" @if($brand->id == $product->brand_id) {{'selected'}} @endif>{{$brand->brand_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
              
                                    <div class="col-6 mt-2">
                                        <label>Product Price/Unit<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control decimal" name="product_price" maxlength="12" value="{{$product->product_price}}">
                                            <div class="input-group-append">
                                                <select class="form-control" name="measuring_unit_id">
                                                            <option value="" hidden>/Unit</option>
                                                            @foreach($units as $unit)
                                                            <option value="{{$unit->id}}" @if($unit->id == $product->measuring_unit_id) {{'selected'}} @endif>{{$unit->unit_type}}</option>   
                                                            @endforeach                        
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="product_tech_spec">Technical Specification <span class="text-danger">*</span></label>
                                        <textarea name="product_tech_spec" id="product_tech_spec" class="form-control" required>{{$product->product_tech_spec}}</textarea>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="product_marketing_spec">Marketing Specification</label>
                                        <textarea name="product_marketing_spec" id="product_marketing_spec" class="form-control">{{$product->product_marketing_spec}}</textarea>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-success float-right">Submit</button>
                                    </div>
                            </div>
                            </form>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')

<script>

    $('#product_tech_spec').summernote({
        tabsize: 2,
        height: 200
    });
    $('#product_marketing_spec').summernote({
        tabsize: 2,
        height: 200
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    $("#product_category_id").change(function(){
        let cat_id = $(this).val();
        $.ajax({
            type:'post',
            url:"{{route('admin.subcategory.list')}}",
            data:{'cat_id':cat_id},
            success:function(res){
                let i;
                let html = `<label for="product_sub_category_id">Product Sub-Category <span class="text-danger"> *</span></label>
                                <select name="product_sub_category_id" id="product_sub_category_id" class="form-control" required>
                                    <option value="">Select Sub-Category</option>`;
                for(i=0; i < res.length; i++){                   
                    html =  html + `<option value="`+res[i].id+`">`+res[i].product_subcat_name+`</option>`;
                }
                html = html + `</select>`;
                $(".load_subcat").html(html); 
            }
        })
    })
</script>

@endpush




