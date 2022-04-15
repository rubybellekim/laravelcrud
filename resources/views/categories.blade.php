<h1>Categories page</h1>

{{-- Link to the item page --}}
<div>
<a href="{{route('items')}}">Got to Items</a>
<br /><br />
</div>

{{-- Link to the create category page --}}
<div>
<a href="{{route('categoryCreateForm')}}">Create new category</a>
<br /><br />
</div>

{{-- Category table & update --}}
<table border="1">
@foreach ($categories as $categoryEntry)
<tr>
<td>{{$categoryEntry->id}}</td>
<td>{{$categoryEntry->name}}</td>

{{-- edit & delete button --}}
<td><a href="{{route('categoryEditForm', ['id' => $categoryEntry->id])}}">EDIT</a></td>
<td><a href="{{route('categoryDelete', ['id' => $categoryEntry->id])}}">DELETE</a></td>
</tr>
@endforeach
</table>
