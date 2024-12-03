<div class="">
        <button type="button" class="btn btn-sm btn-success m-1 send_sms" data-leadid="{{$data->lead_id}}" data-mobileno="{{$data->mobile}}"><i class="fas fa-envelope"></i></button>                              
        <button type="button" class="btn btn-sm btn-danger m-1 edit_data" data-modelid="{{$data->id}}"><i class="fas fa-eye"></i></button>   

        @if($data->po_remaining != 0.00)
            @if($data->po_net_amount > $data->po_remaining)
            <button type="button" class="btn btn-sm btn-primary m-1 add_remaining_amount" data-modelid="{{$data->id}}" title="Add Remaining Amount"><i class="fas fa-plus"></i></button> 
            @else
            <button type="button" class="btn btn-sm btn-primary m-1 add_advance_amount" data-modelid="{{$data->id}}" title="Add Advance Payment"><i class="fas fa-plus"></i></button> 
            @endif
        @endif

        @if($data->lead_stage_id > 5)
        <button type="button" class="btn btn-sm btn-warning m-1 update_stage" data-modelid="{{$data->lead_id}}" data-stageid="{{$data->lead_stage_id}}"><i class="fas fa-edit"></i></button>                              
        @endif
</div>
