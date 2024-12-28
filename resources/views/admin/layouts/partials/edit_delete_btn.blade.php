<div class="">
    <!-- <div class="d-flex"> -->
    @can("$permission edit")
        @if ($edit_type == 'modal')
            <button type="button" class="btn btn-sm btn-warning mr-1 edit_data" data-modelid="{{ $data->id }}"><i
                    class="fas fa-edit"></i></button>
        @elseif($edit_type !== 'lead')
            <a href="{{ $editRoute }}" class="btn btn-sm btn-warning mr-1 d-inline-block"><i class="fas fa-edit"></i></a>
        @endif
    @endcan

    @if (isset($type) && $type == 'subcategory_list')
        <a href="{{ $subcategoryRoute }}" class="btn btn-sm btn-primary mr-1 d-inline-block"><i
                class="fas fa-list"></i></a>
    @elseif(isset($type) && $type == 'lead')
        <a href="{{ $viewRoute }}" class="btn btn-sm btn-success mr-1 d-inline-block" title="View"><i
                class="fas fa-eye"></i></a>
        @if (isset($assignbtn) && $assignbtn)
            <button type="button" class="btn btn-sm btn-primary mr-1 assign_user" data-modelid="{{ $data->id }}"
                title="Assign User"><i class="fas fa-user-plus"></i></button>
        @endif


    @endif

    @if (isset($deactbtn) && $deactbtn)
        <button type="button" class="btn btn-primary btn-sm btn-secondary" data-toggle="modal"
            data-target="#deactivate_lead">
            <i class="fas fa-times-circle"></i>
        </button>
    @endif

    @can("$permission delete")
        @if ($deleteRoute)
            <form action="{{ $deleteRoute }}" method="POST" class="inline deleteConfirm d-inline-block">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i
                        class="fas fa-trash-alt"></i></button>
            </form>
        @endif
    @endcan
</div>
