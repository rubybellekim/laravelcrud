@isset($id)
    <h1>Edit category</h1>
@else
    <h1>Create category</h1>
@endisset

{{-- Link to go back to the category table page --}}
<a href="{{route('categories')}}">Return back</a>

{{-- edit form with patch method --}}
@isset($id)
    <form action="{{route('editCategory', ['id' => $id])}}" method="post">
        {!! method_field('patch') !!}
@else
    <form action="{{route('createCategory')}}" method="post">
@endisset
    @csrf
    <table>
        <tr><td></td><td><input name="id" type="hidden" value="{{$id ?? ''}}" /><br /></td><td></td></tr>
        <tr>
            <td>Category name</td><td><input name="name" type="text" value="{{$name ?? ''}}" /></td>
            <td>
            {{-- check empty or duplicate category name --}}
                @isset($nameError)
                    <span style="color: red;">{{$nameError}}</span>
                @endisset
            </td>
        </tr>
        <tr><td colspan="2">
            {{-- submit button --}}
            @isset($id)
                <input type="submit" value="Update" />
            @else
                <input type="submit" value="Create" />
            @endisset
        </td></tr>
    </table>
</form>

