@if($page != 'product')
<option value="0" selected>Main Category</option>
@endif
@forelse($categories as $category)
<option value="{{$category->id}}">{{$category->category_name}}</option>
@empty
<option value="">No Category found</option>
@endforelse