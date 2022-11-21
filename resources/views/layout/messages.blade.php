@php $system_messages = get_system_messages(); @endphp
@if (!empty($system_messages))
    @foreach ($system_messages as $key => $messages)
        @if (!empty($messages))
            @foreach ($messages as $message)
                <div class="alert alert-{{$key}}">{{$message}}</div>
            @endforeach
        @endif
    @endforeach
@endif
@php clear_system_messages(); @endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif