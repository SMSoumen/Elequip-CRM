<div class="">
<!-- <div class="d-flex"> -->
    @can("$permission edit")
        @if($edit_type == 'modal')
            <button type="button" class="btn btn-sm btn-warning mr-2 edit_data" data-modelid="{{$data->id}}">Edit</button>                              
        @else
        <a href="{{ $editRoute }}" class="btn btn-sm btn-warning mr-2 d-inline-block">Edit</a>
        @endif
    @endcan

    @if(isset($type) && $type == 'subcategory_list')
        <a href="{{$subcategoryRoute}}" class="btn btn-sm btn-primary mr-2 d-inline-block">Subcategories</a>
    @endif

    @can("$permission delete")
        <form action="{{ $deleteRoute }}" method="POST" class="inline deleteConfirm d-inline-block">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
    @endcan
</div>
