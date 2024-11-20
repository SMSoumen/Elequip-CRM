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
                            <div class="tab active" data-target="tab1">Time Line</div>
                            <div class="tab" data-target="lead_details">Lead Details</div>
                            <div class="tab" data-target="tab3">Quotation Stage</div>
                            <div class="tab" data-target="tab4">P.O. Stage</div>
                            <div class="tab" data-target="tab5">Proforma</div>

                         </div>

                        <div id="tab1" class="tab-content active">
                            {{-- <h4>Timeline</h4> --}}
                            @include('admin.lead.timeline')
                        </div>

                        <div id="lead_details" class="tab-content">
                            <form action="{{route('admin.lead.stage_update')}}" method="POST">@csrf
                                 @include('admin.lead.lead_details')
                            </form>
                        </div>

                        <div id="tab3" class="tab-content">                            
                            @include('admin.lead.quotation')
                        </div>
                        <div id="tab4" class="tab-content">
                            <h2>Content for Tab 4</h2>
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
      });
    });

</script>


@endpush



