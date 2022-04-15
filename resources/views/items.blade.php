<h1>Items page</h1>

{{-- Link to the category page --}}
<div>
<a href="{{route('categories')}}">Got to Categories</a>
<br /><br />
</div>

{{-- Link to the item page --}}
<div>
<a href="{{route('itemCreateForm')}}">Create new items</a>
<br /><br />
</div>

{{-- table of the items --}}
<table border="1">
<tr style="font-weight: bold; text-align: center; background: lightgray; ">
    <td>title</td>
    <td>category</td>
    <td>description</td>
    <td>price</td>
    <td>quantity</td>
    <td>SKU</td>
    <td>picture</td>
    <td colspan="2">actions</td>
</tr>

{{-- update table of items --}}
@foreach ($items as $itemsEntry)
<tr>
<td>{{$itemsEntry->title}}</td>
<td>{{$itemsEntry->category}}</td>
<td>{{$itemsEntry->description}}</td>
<td>${{$itemsEntry->price}}</td>
<td>{{$itemsEntry->quantity}}</td>
<td>{{$itemsEntry->SKU}}</td>

{{-- image upload & size adjustment --}}
<td><img height="50px" src="{{asset('uploads/' . $itemsEntry->picture)}}" /></td>

{{-- edit and delete button --}}
<td><a href="{{route('itemEditForm', ['id' => $itemsEntry->SKU])}}">EDIT</a></td>
<td><a href="{{route('itemDelete', ['id' => $itemsEntry->SKU])}}">DELETE</a></td>
</tr>
@endforeach
</table>
