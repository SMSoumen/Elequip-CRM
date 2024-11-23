@extends('admin.layouts.master')
@section('main_content')
    <style>
        .tabs {
            display: flex;
            justify-content: space-around;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #555;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .tab:hover {
            color: #333;
            border-bottom: 3px solid #007bff;
        }

        .tab.active {
            font-weight: bold;
            color: #007bff;
            border-bottom: 3px solid #007bff;
        }

        .tab-content {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .tab-content.active {
            display: block;
        }
    </style>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"></h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="tabs">
                                <div class="tab @if($lead->lead_stage_id != 3) active @endif" data-target="tab1">Time Line</div>
                                <div class="tab" data-target="lead_details">Lead Details</div>
                                <div class="tab @if($lead->lead_stage_id == 3) active @endif" data-target="tab3">Quotation Stage</div>
                                <div class="tab" data-target="tab4">P.O. Stage</div>
                                <div class="tab" data-target="tab5">Proforma</div>

                            </div>

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div id="tab1" class="tab-content @if($lead->lead_stage_id != 3) active @endif">
                                {{-- <h4>Timeline</h4> --}}
                                @include('admin.lead.timeline')
                            </div>

                            <div id="lead_details" class="tab-content">
                                <form action="{{route('admin.leads.update',$lead)}}" method="post">@csrf
                                @method('PUT')
                                    @include('admin.lead.lead_details')
                                </form>
                            </div>

                            <div id="tab3" class="tab-content @if($lead->lead_stage_id == 3) active @endif">
                                @if(session('quotation_data') && $lead->lead_stage_id == 2)
                                    @include('admin.lead.quotation_session_pdf')
                                @elseif($lead->lead_stage_id == 2)
                                    @include('admin.lead.quotation')
                                @elseif($lead->lead_stage_id == 3)
                                  @include('admin.lead.quotation_pdf')
                                @endif
                            </div>

                            <div id="tab4" class="tab-content">
                                <h2>Content for Tab 5</h2>
                                <p>This is the content for the third tab. Add as many tabs as you like!</p>
                            </div>

                            <div id="tab5" class="tab-content">
                                <h2>Content for Tab 5</h2>
                                <p>This is the content for the third tab. Add as many tabs as you like!</p>
                            </div>

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove 'active' class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add 'active' class to the clicked tab and corresponding content
                tab.classList.add('active');
                const target = document.getElementById(tab.dataset.target);
                target.classList.add('active');

                if (tab.dataset.target === "lead_details") {
                    $('.product_select_details').select2({
                        placeholder: "Select an option",
                        allowClear: true
                    });
                    $('#lead_stage_id').select2({
                        placeholder: "Select Lead Stage",
                        allowClear: true
                    });
                } else if(tab.dataset.target === "tab3") {
                    $('.product_select_quot').select2({
                        placeholder: "Select an option",
                        allowClear: true
                    });

                    $("#product_id2").change(function(){
                        var product_id = $(this).val();
                        $.ajax({
                            type:'post',
                            url:"{{route('admin.product-details')}}",
                            data:{"product_id":product_id},
                            success:function(res){
                                 console.log(res);
                                var i=0;
                                var tr='';                                       
                                for(i=0;i<res.length;i++){
                                var tr = tr + `<tr>
                                            <td>
                                                `+res[i].product_name+`(`+res[i].product_code+`)
                                                <input type="hidden" name="product_name[]" value="`+res[i].product_name+`">
                                                <input type="hidden" name="product_code[]" value="`+res[i].product_code+`">
                                                <input type="hidden" name="product_unit[]" value="`+res[i].unit_type+`">
                                                <input type="hidden" name="product_tech_spec[]" value="`+res[i].product_tech_spec+`">
                                                <input type="hidden" name="product_m_spec[]" value="`+res[i].product_marketing_spec+`">
                                            </td>
                                            <td><input type="text" name="qty[]" class="qty" value="1"></td>
                                            <td><input type="text" name="rate[]" class="rate" value="`+res[i].product_price+`"></td>

                                            <td>
                                                <input type="hidden" class="single_amount" value="`+res[i].product_price+`">
                                                <input type="text" name="amount[]" class="amount" value="`+res[i].product_price+`" readonly>
                                            </td>
                                        </tr>`;
                                }
                                $("tbody").html(tr);
                                 changeAmount();
                            }
                        })  
                    });

                    function changeAmount(){
                        $(".qty").keyup(function(){
                            var quantity = $(this).val();
                            var amount = $(this).closest('tr').find('.single_amount').val();
                            var total_amount = quantity * amount; 
                            if (isNaN(total_amount)) {
                                $(this).closest('tr').find('.amount').val(0);
                            }
                            else{
                                $(this).closest('tr').find('.amount').val(total_amount);
                            }
                        });
                    }
    
                }
            });
        });




    </script>
@endpush
