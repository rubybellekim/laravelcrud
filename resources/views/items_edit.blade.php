@isset($sku)
    <h1>Edit items</h1>
@else
    <h1>Create items</h1>
@endisset

{{-- Link to go back to the item table page --}}
<a href="/items">Return back</a>

{{-- edit form with patch method --}}
@isset($sku)
    <form action="{{route('editItem', ['id' => $sku])}}" method="post" enctype="multipart/form-data">
        {!! method_field('patch') !!}
@else
    <form action="{{route('createItem')}}" method="post" enctype="multipart/form-data">
@endisset
    @csrf
    <table>
    {{-- change info & check empty fields for items --}}
    <tr><td> <label for="title">Title</label>
    <input name="title" type="text" value="{{$title ?? ''}}" />
        @isset($errorTitle)
            <span style="color: red;">{{$errorTitle}}</span>
        @endisset
    </td></tr>

    <tr><td> <label for="category">Category</label>
    <select name="category" id="category">
        @foreach ($categories as $categoryEntry)
            @if (isset($category) and $category == $categoryEntry->id)
                <option value="{{$categoryEntry->id}}" selected>{{$categoryEntry->name}}</option>    
            @else
                <option value="{{$categoryEntry->id}}" >{{$categoryEntry->name}}</option>
            @endisset
            
        @endforeach
    </select>
        @isset($itemError)
            <span style="color: red;">{{$itemError}}</span>
        @endisset
    </td></tr>

    <tr><td> <label for="description">Description</label>
    <input name="description" type="text" value="{{$description ?? ''}}" />
        @isset($errorDescription)
            <span style="color: red;">{{$errorDescription}}</span>
        @endisset
    </td></tr>

    <tr><td> <label for="price">Price($)</label>
    <input name="price" type="text" value="{{$price ?? ''}}" />
        @isset($errorPrice)
            <span style="color: red;">{{$errorPrice}}</span>
        @endisset
    </td></tr>

    <tr><td> <label for="quantity">Quantity</label>
    <input name="quantity" type="text" value="{{$quantity ?? ''}}" />
        @isset($errorQuantity)
            <span style="color: red;">{{$errorQuantity}}</span>
        @endisset
    </td></tr>

    <tr><td> <label for="sku">SKU</label>
    <input name="sku" type="text" value="{{$sku ?? ''}}" />
        @isset($errorSku)
            <span style="color: red;">{{$errorSku}}</span>
        @endisset
    </td></tr>
{{-- image upload --}}
    @isset($picture)
        <tr><td><img height="50px" src="{{asset('uploads/' . $picture)}}" /></td></tr>
    @endisset
    
    <tr><td>
     <label for="picture">Picture</label>
    <input name="picture" type="file" accept="image/png, image/jpeg" value="{{$picture ?? ''}}" />
        @isset($itemError)
        <span style="color: red;">{{$itemError}}</span>
        @endisset
    </td></tr>
                
 {{-- submit button --}}
    <tr><td>
        @isset($sku)
            <input type="submit" value="Update" />
        @else
            <input type="submit" value="Create" />
        @endisset
    </td></tr>
        
    </table>
</form>
