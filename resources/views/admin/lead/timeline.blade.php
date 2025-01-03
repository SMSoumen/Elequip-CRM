<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>Timeline</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Timeline</li> -->

                    <button type="button" class="btn btn-warning m-2 send_sms" title="Send SMS"><i class="fas fa-envelope"></i> Send SMS</button>                              
                    <button type="button" class="btn btn-warning m-2 add_remark"  title="Add Remark"><i class="fas fa-plus"></i> Add Remark</button> 
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /.container-fluid -->
<!-- Main content -->

<style>
    /* Timeline */
    .timeline {
        list-style: none;
        padding: 0;
        position: relative;
    }

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #6c7293;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline .timeline-wrapper {
        display: block;
        margin-bottom: 20px;
        position: relative;
        width: 100%;
        padding-right: 90px;
    }

    .timeline .timeline-wrapper:before {
        content: " ";
        display: table;
    }

    .timeline .timeline-wrapper:after {
        content: " ";
        display: table;
        clear: both;
    }

    .timeline .timeline-wrapper .timeline-panel {
        border-radius: 2px;
        padding: 20px;
        position: relative;
        background: #ffffff;
        border-radius: 6px;
        box-shadow: 1px 2px 35px 0 rgba(1, 1, 1, 0.1);
        width: 40%;
        margin-left: 10%;
    }

    .timeline .timeline-wrapper .timeline-panel:before {
        position: absolute;
        top: 0;
        width: 100%;
        height: 2px;
        content: "";
        left: 0;
        right: 0;
    }

    .timeline .timeline-wrapper .timeline-panel:after {
        position: absolute;
        top: 10px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #ffffff;
        border-right: 0 solid #ffffff;
        border-bottom: 14px solid transparent;
        content: " ";
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-title {
        margin-top: 0;
        color: #001737;
        text-transform: uppercase;
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-body p+p {
        margin-top: 5px;
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-body ul {
        margin-bottom: 0;
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-footer span {
        font-size: .6875rem;
    }

    .timeline .timeline-wrapper .timeline-panel .timeline-footer i {
        font-size: 1.5rem;
    }

    .timeline .timeline-wrapper .timeline-badge {
        width: 14px;
        height: 14px;
        position: absolute;
        top: 16px;
        left: calc(50% - 7px);
        z-index: 10;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
        border: 2px solid #ffffff;
    }

    .timeline .timeline-wrapper .timeline-badge i {
        color: #ffffff;
    }

    .timeline .timeline-wrapper.timeline-inverted {
        padding-right: 0;
        padding-left: 90px;
    }

    .timeline .timeline-wrapper.timeline-inverted .timeline-panel {
        margin-left: auto;
        margin-right: 10%;
    }

    .timeline .timeline-wrapper.timeline-inverted .timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }

    @media (max-width: 767px) {
        .timeline .timeline-wrapper {
            padding-right: 150px;
        }

        .timeline .timeline-wrapper.timeline-inverted {
            padding-left: 150px;
        }

        .timeline .timeline-wrapper .timeline-panel {
            width: 60%;
            margin-left: 0;
            margin-right: 0;
        }
    }

    @media (max-width: 576px) {
        .timeline .timeline-wrapper .timeline-panel {
            width: 68%;
        }
    }

    .timeline-wrapper-primary .timeline-panel:before {
        background: #464dee;
    }

    .timeline-wrapper-primary .timeline-badge {
        background: #464dee;
    }

    .timeline-wrapper-secondary .timeline-panel:before {
        background: #6c7293;
    }

    .timeline-wrapper-secondary .timeline-badge {
        background: #6c7293;
    }

    .timeline-wrapper-success .timeline-panel:before {
        background: #0ddbb9;
    }

    .timeline-wrapper-success .timeline-badge {
        background: #0ddbb9;
    }

    .timeline-wrapper-info .timeline-panel:before {
        background: #0ad7f7;
    }

    .timeline-wrapper-info .timeline-badge {
        background: #0ad7f7;
    }

    .timeline-wrapper-warning .timeline-panel:before {
        background: #fcd539;
    }

    .timeline-wrapper-warning .timeline-badge {
        background: #fcd539;
    }

    .timeline-wrapper-danger .timeline-panel:before {
        background: #ef5958;
    }

    .timeline-wrapper-danger .timeline-badge {
        background: #ef5958;
    }

    .timeline-wrapper-light .timeline-panel:before {
        background: #eaeaea;
    }

    .timeline-wrapper-light .timeline-badge {
        background: #eaeaea;
    }

    .timeline-wrapper-dark .timeline-panel:before {
        background: #001737;
    }

    .timeline-wrapper-dark .timeline-badge {
        background: #001737;
    }


    /* Cards */
    .card {
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -ms-box-shadow: none;
    }

    .card .card-body {
        padding: 1.75rem 1.75rem;
    }

    .card .card-body+.card-body {
        padding-top: 1rem;
    }

    .card .card-title {
        color: #001737;
        margin-bottom: .5rem;
        text-transform: capitalize;
        font-size: 0.875rem;
    }

    .card .card-subtitle {
        font-weight: 400;
        margin-top: 0.625rem;
        margin-bottom: 0.625rem;
    }

    .card .card-description {
        margin-bottom: .875rem;
        font-weight: 400;
        color: #76838f;
    }

    .card.card-outline-success {
        border: 1px solid #0ddbb9;
    }

    .card.card-outline-primary {
        border: 1px solid #464dee;
    }

    .card.card-outline-warning {
        border: 1px solid #fcd539;
    }

    .card.card-outline-danger {
        border: 1px solid #ef5958;
    }

    .card.card-rounded {
        border-radius: 5px;
    }

    .card.card-faded {
        background: #b5b0b2;
        border-color: #b5b0b2;
    }

    .card.card-circle-progress {
        color: #ffffff;
        text-align: center;
    }

    .card.card-img-holder {
        position: relative;
    }

    .card.card-img-holder .card-img-absolute {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
    }

    .card.card-weather .weather-daily .weather-day {
        opacity: .5;
        font-weight: 900;
    }

    .card.card-weather .weather-daily i {
        font-size: 20px;
    }

    .card.card-weather .weather-daily .weather-temp {
        margin-top: .5rem;
        margin-bottom: 0;
        opacity: .5;
        font-size: .75rem;
    }

    .card-inverse-primary {
        background: rgba(70, 77, 238, 0.2);
        border: 1px solid #4047db;
        color: #353bb5;
    }

    .card-inverse-secondary {
        background: rgba(108, 114, 147, 0.2);
        border: 1px solid #636987;
        color: #525770;
    }

    .card-inverse-success {
        background: rgba(13, 219, 185, 0.2);
        border: 1px solid #0cc9aa;
        color: #0aa68d;
    }

    .card-inverse-info {
        background: rgba(10, 215, 247, 0.2);
        border: 1px solid #09c6e3;
        color: #08a3bc;
    }

    .card-inverse-warning {
        background: rgba(252, 213, 57, 0.2);
        border: 1px solid #e8c434;
        color: #c0a22b;
    }

    .card-inverse-danger {
        background: rgba(239, 89, 88, 0.2);
        border: 1px solid #dc5251;
        color: #b64443;
    }

    .card-inverse-light {
        background: rgba(234, 234, 234, 0.2);
        border: 1px solid #d7d7d7;
        color: #b2b2b2;
    }

    .card-inverse-dark {
        background: rgba(0, 23, 55, 0.2);
        border: 1px solid #001533;
        color: #00112a;
    }

    .fs-14 {
        font-size: 14px !important;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mt-5">
                <div class="timeline">
                    @if ($followups)
                        @php
                            $counter = $followups->count();
                        @endphp

                        @forelse ($followups as $i => $followup)
                            @php
                                $wrapper_class =
                                    fmod($i, 2) == 0 ? 'timeline-wrapper-danger' : 'timeline-wrapper-warning';
                                $inverse_class = fmod($i, 2) == 0 ? ' timeline-inverted' : '';
                                if ($counter - 1 == $i) {
                                    continue;
                                }
                            @endphp
                            <div class="timeline-wrapper {{ $wrapper_class . $inverse_class }}">
                                <div class="timeline-badge"></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">{{ $followup->admin->name }}</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <p class="fs-14">
                                            @if ($followup->followup_type == 'followup')
                                                {{ 'Follow-up Date Added as: ' . \Carbon\Carbon::parse($followup->followup_next_date)->format('d M Y') }}
                                            @else
                                                {!! $followup->followup_remarks !!}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="mdi mdi-heart-outline text-muted mr-1"></i>
                                        <span>{{ \Carbon\Carbon::parse($followup->created_at)->diffForHumans() }}</span>
                                        <span
                                            class="ml-md-auto font-weight-bold">{{ \Carbon\Carbon::parse($followup->created_at)->format('M d, Y, H:i a') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse

                        @php
                            $wrapper_class =
                                fmod($counter + 1, 2) == 0 ? 'timeline-wrapper-danger' : 'timeline-wrapper-warning';
                            $inverse_class = fmod($counter + 1, 2) == 0 ? ' timeline-inverted' : '';
                        @endphp
                        <div class="timeline-wrapper {{ $wrapper_class . $inverse_class }}">
                            <div class="timeline-badge"></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">{{ $lead->admin->name }}</h6>
                                </div>
                                <div class="timeline-body">
                                    <p class="fs-14">Lead Created

                                        @if ($lead->lead_remarks)
                                            {!! '<br><b>Remarks</b>: ' !!} {{ $lead->lead_remarks }}
                                        @endif
                                    </p>
                                </div>
                                <div class="timeline-footer d-flex align-items-center flex-wrap">
                                    <i class="mdi mdi-heart-outline text-muted mr-1"></i>
                                    <span>{{ \Carbon\Carbon::parse($lead->created_at)->diffForHumans() }}</span>
                                    <span
                                        class="ml-md-auto font-weight-bold">{{ \Carbon\Carbon::parse($lead->created_at)->format('M d, Y, H:i a') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->

<!--==================> Send SMS Modal ============================-->

    <div class="modal fade" id="send_sms" tabindex="-1" aria-labelledby="exampleModalLabelSMS" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSMS">Send SMS</h5>
                </div>
                <form method="POST" action="{{ route('admin.order.send_sms') }}">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="mobile_no" value="{{$lead_customer->mobile}}">
                        <input type="hidden" name="lead_id" value="{{$lead->id}}">
                        <div class="col-12">
                            <label for="sms_title">SMS Title<span class="text-danger">*</span></label>
                            <select name="sms_title" id="sms_title" class="form-control" required>
                                <option value="" class="d-none">Select SMS Template</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->template_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">SEND</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--==================> Add Remark Modal ============================-->

    <div class="modal fade" id="add_remark" tabindex="-1" aria-labelledby="exampleModalLabelRemark" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelRemark">Add Remark</h5>
                </div>
                <form method="POST" action="{{ route('admin.lead.add_remark') }}">@csrf
                    <div class="modal-body">
                        <input type="hidden" name="lead_id" value="{{$lead->id}}">
                        <div class="col-12">
                            <label for="remark">Remarks<span class="text-danger">*</span></label>
                            <textarea name="remark" id="remark" class="form-control" rows="3" required></textarea>
                                
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
