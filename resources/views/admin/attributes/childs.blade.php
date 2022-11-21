@foreach($childs as $child)
<tr id="item-{{$child['id']}}">
    <td><a class="handle1 btn btn-primary btn-xs"><i class="bi bi-arrow-down-up"></i></a></td>
    <td>- {{$child['name']}}</td>
    <td></td>

    <td>
        <div class="btn-group" style="float:right">
            <a class="btn btn-primary btn-xs" href="{{ route('attributes.edit',$child['id']) }}"><i class="bi bi-tools"></i></a>
            <form action="{{ route('attributes.destroy', $child->id) }}" method="post">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger btn-xs" id="delete" onclick="return confirm('{{ __('admin.msg_are_you_sure') }}')">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach
