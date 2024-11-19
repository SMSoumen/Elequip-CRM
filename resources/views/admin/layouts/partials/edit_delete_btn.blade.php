<div class="">
<!-- <div class="d-flex"> -->
    @can("$permission edit")
        @if($edit_type == 'modal')
            <button type="button" class="btn btn-sm btn-warning mr-2 edit_data" data-modelid="{{$data->id}}"><i class="fas fa-edit"></i></button>                              
        @else
        <a href="{{ $editRoute }}" class="btn btn-sm btn-warning mr-2 d-inline-block"><i class="fas fa-edit"></i></a>
        @endif
    @endcan

    @if(isset($type) && $type == 'subcategory_list')
        <a href="{{$subcategoryRoute}}" class="btn btn-sm btn-primary mr-2 d-inline-block"><i class="fas fa-list"></i></a>
    @elseif(isset($type) && $type == 'lead')
        <button type="button" class="btn btn-sm btn-primary mr-2 assign_user" data-modelid="{{$data->id}}" title="Assign User"><i class="fas fa-user-plus"></i></button>                              
    @endif

    @can("$permission delete")
        <form action="{{ $deleteRoute }}" method="POST" class="inline deleteConfirm d-inline-block">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
        </form>
    @endcan
</div>
