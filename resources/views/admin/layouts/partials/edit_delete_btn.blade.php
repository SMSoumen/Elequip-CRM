<div class="d-flex">
    @can("$permission edit")
        <a href="{{ $editRoute }}" class="btn btn-sm btn-warning mr-2 d-inline-block">Edit</a>
    @endcan

    @can("$permission delete")
        <form action="{{ $deleteRoute }}" method="POST" class="inline deleteConfirm d-inline-block">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
    @endcan
</div>
