<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!-- Timelime example  -->
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Text</label>
                                <input type="text" class="form-control" placeholder="Enter ...">
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="product_id">Select Products <span class="text-danger"> *</span></label>
                            <select name="product_id[]" id="product_id1" class="form-control product_select_quot" multiple>
                                <!-- <option value="">Select Product</option> -->
                                @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Text Disabled</label>
                                <input type="text" class="form-control" placeholder="Enter ..." disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.timeline -->

</section>
<!-- /.content -->
