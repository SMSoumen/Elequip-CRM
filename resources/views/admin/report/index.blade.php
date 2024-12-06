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
                                <h3 class="card-title">Reports</h3>
                            </div>
                        </div>
                        <div class="card-body">
                           <div class="row">
                                <div class="col-4">
                                    <label for="from_date">From Date</label>
                                    <input type="date" id="from_date" class="form-control" name="from_date" value="{{$from_date}}">
                                </div>
                                <div class="col-4">
                                    <label for="to_date">To Date</label>
                                    <input type="date" id="to_date" class="form-control" name="to_date" value="{{$to_date}}">
                                </div>

                                <div class="col-4">
                                    <button type="button" name="search" class="btn btn-warning mt-4">Search</button>
                                </div>
                           </div>
                        </div>
                        
                    </div>
                </div>

                <!--========================================================>Client Business Report<================================================================-->
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Client Business Report</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="client_business_report_form">
                                <div class="row mb-4">
                                    <div class="col-4">
                                        <select class="form-control" name="company_id" id="company_id">
                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" name="customer_id" id="customer_id">
                                            <option value="">Select Customer</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" id="client_business_report" class="btn btn-warning">Search</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Customer(Designation)</th>
                                        <th>Company</th>
                                        <th>Quotation</th>
                                        <th>P.O. Stage</th>
                                        <th>A/c Closed</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="business_report">
                                    @foreach($client_business_reports as $key=>$report)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$report->customer_name}} ({{$report->designation}})</td>
                                        <td>{{$report->company_name}} </td>
                                        <td>{{$report->quot_amount}} </td>
                                        <td>{{$report->po_net_amount}} </td>
                                        <td>0.00</td>
                                        <td>{{$report->po_net_amount}} </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <!--========================================================>Category-wise Report<================================================================-->
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Category-wise Report</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="category_wise_report_form">
                                <div class="row mb-4">
                                    <div class="col-4">
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">Select Category</option>
                                            @foreach($product_categories as $category)
                                                <option value="{{$category->id}}">{{$category->product_category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" id="category_wise_report" class="btn btn-warning">Search</button>
                                    </div>
                                </div>
                            </form>
                            <div style="max-height:400px; overflow-y:scroll;">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Category Name</th>
                                            <th>Quotation</th>
                                            <th>P.O. Stage</th>
                                            <th>A/c Closed</th>
                                        </tr>
                                    </thead>
                                    <tbody  id="category_report">
                                        @foreach($category_wise_reports as $key=>$report)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$report['category_name']}}</td>
                                                <td>{{$report['quotations_amount']}}</td>
                                                <td>{{$report['po_amount']}}</td>
                                                <td>0.00</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <!--========================================================>Value Based Report<================================================================-->
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Value Based Report Report</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="value_based_report_form">
                                <div class="row mb-4">
                                    <div class="col-3">
                                        <select class="form-control" name="company_id" id="company_id">
                                            <option value="">Select a Quotation</option>
                                            <option value="">1 Lacks to 3 Lacks</option>
                                            <option value="">3 Lacks to 6 Lacks</option>
                                            <option value="">6 Lacks to above</option>

                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="form-control" name="company_id" id="company_id">
                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="form-control" name="company_id">
                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-1">
                                        <button type="button" id="value_based_report" class="btn btn-warning">Search</button>
                                    </div>
                                </div>
                            </form>

                            <div style="height:400px; overflow-y:scroll;">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Company</th>
                                            <th>Quotation</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($value_based_reports as $key=>$report)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$report->company_name}}</td>
                                                <td>{{$report->quot_amount}}</td>
                                                <td>{{$report->name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <!--========================================================> Area-wise Report<================================================================-->
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Area-wise Report</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="category_wise_report_form">
                                <div class="row mb-4">
                                    <div class="col-4">
                                        <select class="form-control" name="company_id">
                                            <option value="">Select Area</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->city_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-1">
                                        <button type="button" name="search" class="btn btn-warning">Search</button>
                                    </div>
                                </div>
                            </form>

                            <div style="max-height:400px; overflow-y:scroll;">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>City Name</th>
                                            <th>Quotation</th>
                                            <th>P.O. Stage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($area_wise_reports as $key=>$report)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$report['area']}}</td>
                                                <td>{{$report['quotations_amount']}}</td>
                                                <td>{{$report['po_amount']}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <!--========================================================> Userwise Business Report <================================================================-->
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Userwise Business Report</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="category_wise_report_form">
                                <div class="row mb-4">
                                    <div class="col-3">
                                        <select class="form-control" name="company_id" id="company_id">
                                            <option value="">Select a Quotation</option>
                                            <option value="">1 Lacks to 3 Lacks</option>
                                            <option value="">3 Lacks to 6 Lacks</option>
                                            <option value="">6 Lacks to above</option>

                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="form-control" name="company_id" id="company_id">
                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="form-control" name="company_id">
                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-1">
                                        <button type="button" name="search" class="btn btn-warning">Search</button>
                                    </div>
                                </div>
                            </form>

                            <div style="height:400px; overflow-y:scroll;">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>User Name</th>
                                            <th>Quotation</th>
                                            <th>Active Quotation</th>
                                            <th>P.O.</th>
                                            <th>A/c Closed</th>
                                            <th>Due Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($value_based_reports as $key=>$report)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$report->company_name}}</td>
                                                <td>{{$report->quot_amount}}</td>
                                                <td>{{$report->name}}</td>
                                                <td>{{$report->name}}</td>
                                                <td>{{$report->name}}</td>
                                                <td>{{$report->name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <!--========================================================> Userwise Conversion Report <================================================================-->
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Userwise Conversion Report</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="category_wise_report_form">
                                <div class="row mb-4">
                                    <div class="col-3">
                                        <select class="form-control" name="company_id" id="company_id">
                                            <option value="">Select a Quotation</option>
                                            <option value="">1 Lacks to 3 Lacks</option>
                                            <option value="">3 Lacks to 6 Lacks</option>
                                            <option value="">6 Lacks to above</option>

                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="form-control" name="company_id" id="company_id">
                                            <option value="">Select Company</option>
                                            @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="form-control" name="company_id">
                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-1">
                                        <button type="button" name="search" class="btn btn-warning">Search</button>
                                    </div>
                                </div>
                            </form>

                            <div style="height:400px; overflow-y:scroll;">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>User Name</th>
                                            <th>Lead</th>
                                            <th>Lead->Quotation</th>
                                            <th>Quotation -> P.O.</th>
                                            <th>P.O -> A/c Closed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($value_based_reports as $key=>$report)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$report->company_name}}</td>
                                                <td>{{$report->quot_amount}}</td>
                                                <td>{{$report->name}}</td>
                                                <td>{{$report->name}}</td>
                                                <td>{{$report->name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
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
           $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#company_id").change(function(){
        var company_id = $(this).val();
        $.ajax({
            type:'post',
            url:"{{route('admin.lead.company_customer')}}",
            data:{"company_id":company_id},
            success:function(res){
                var i=0;
                var html =`<option value="">Select Customer</option>`;
                for(i=0; i < res.length; i++){
                    html = html + `<option value="`+res[i].id+`">`+res[i].customer_name+`</option>`;
                }
                $("#customer_id").html(html);                    
            }
        })
    });


        //===================================================> Client Business Report Ajax<=============================================================//

                            $('#client_business_report').on('click', function (e) {
                                var company_id = $("#company_id").val();
                                var customer_id = $("#customer_id").val();
                                var from_date = $("#from_date").val();
                                var to_date = $("#to_date").val();
                                $.ajax({
                                    url: "{{route('admin.client_business_report.list')}}",
                                    method: 'POST',
                                    data: {"company_id":company_id, "customer_id":customer_id, "from_date":from_date, "to_date":to_date},
                                    success: function (response) {
                                        // console.log(response.reports);
                                        var i;
                                        var html ='';
                                        if (response.success) {
                                            if(response.reports.length == 0){
                                                var html = html + `<tr><td colspan="7">`+response.message+`</td></tr>`;
                                            }
                                            else{
                                                for(i=0;i<response.reports.length;i++){
                                                    var html = html +`<tr>`;
                                                    var html = html + `<td>`+(i+1)+`</td>`;
                                                    var html = html + `<td>`+response.reports[i].customer_name+` (`+response.reports[i].designation+`)</td>`;
                                                    var html = html + `<td>`+response.reports[i].company_name+`</td>`;
                                                    var html = html + `<td>`+response.reports[i].quot_amount+`</td>`;
                                                    var html = html + `<td>`+response.reports[i].po_net_amount+`</td>`;
                                                    var html = html + `<td>0.00</td>`;
                                                    var html = html + `<td>`+response.reports[i].po_net_amount+`</td>`;
                                                    var html = html + `</tr>`;
                                                }
                                                $("#business_report").html(html);
                                            } 
                                        }
                                    },
                                });
                            })

        //===================================================> Category-wise Report Ajax<=============================================================//
        
                            $('#category_wise_report').on('click', function (e) {
                                var category_id = $("#category_id").val();
                                var from_date = $("#from_date").val();
                                var to_date = $("#to_date").val();
                                $.ajax({
                                    url: "{{route('admin.category_wise_report.list')}}",
                                    method: 'POST',
                                    data: {"category_id":category_id,"from_date":from_date, "to_date":to_date},
                                    success: function (response) {
                                        //  console.log(response.reports);
                                        var i;
                                        var html ='';
                                        if (response.success) {
                                            if(response.reports.length == 0){
                                                var html = html + `<tr><td colspan="7">`+response.message+`</td></tr>`;
                                            }
                                            else{
                                                for(i=0;i<response.reports.length;i++){
                                                    var html = html +`<tr>`;
                                                    var html = html + `<td>`+(i+1)+`</td>`;
                                                    var html = html + `<td>`+response.reports[i].category_name+` </td>`;
                                                    var html = html + `<td>`+response.reports[i].quotations_amount+`</td>`;
                                                    var html = html + `<td>`+response.reports[i].po_amount+`</td>`;
                                                    var html = html + `<td>0.00</td>`;
                                                    var html = html + `</tr>`;
                                                }
                                                $("#category_report").html(html);
                                            } 
                                        }
                                    },
                                });
                            })

        //===================================================> Value Based Report Ajax<=============================================================//
        
                            $('#value_based_report').on('click', function (e) {
                                var category_id = $("#category_id").val();
                                var from_date = $("#from_date").val();
                                var to_date = $("#to_date").val();
                                $.ajax({
                                    url: "{{route('admin.category_wise_report.list')}}",
                                    method: 'POST',
                                    data: {"category_id":category_id,"from_date":from_date, "to_date":to_date},
                                    success: function (response) {
                                        //  console.log(response.reports);
                                        var i;
                                        var html ='';
                                        if (response.success) {
                                            if(response.reports.length == 0){
                                                var html = html + `<tr><td colspan="7">`+response.message+`</td></tr>`;
                                            }
                                            else{
                                                for(i=0;i<response.reports.length;i++){
                                                    var html = html +`<tr>`;
                                                    var html = html + `<td>`+(i+1)+`</td>`;
                                                    var html = html + `<td>`+response.reports[i].category_name+` </td>`;
                                                    var html = html + `<td>`+response.reports[i].quotations_amount+`</td>`;
                                                    var html = html + `<td>`+response.reports[i].po_amount+`</td>`;
                                                    var html = html + `<td>0.00</td>`;
                                                    var html = html + `</tr>`;
                                                }
                                                $("#category_report").html(html);
                                            } 
                                        }
                                    },
                                });
                            })

    </script>
@endpush
