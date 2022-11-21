@extends('admin.layout.app')
@section('content')

@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
<div class="col-md-6">
<div class="card shadow mb-3">
<div class="card-header">{{ $page_title }} lista</div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    <div class="col-lg-12">@include('layout/messages')</div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Típus azonostó</th>
                    <th>Név</th>
                    <th class="text-right">Műveletek</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($page_types))
                @foreach ($page_types as $pt)
                    <tr>
                        <td>{{ $pt->id }}</td>
                        <td>{{ $pt->type }}</td>
                        <td>{{ $pt->name }}</td>
                        <td>
                            <div class="btn-group" style="float:right">
                                <a class="btn btn-success btn-xs" href="{{ url('admin/pages/page-types/false/'.$pt->id);}}"><i class="bi bi-tools"></i></a>
                                <form action="{{ url('admin/pages/page-types/delete/'.$pt->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <a href="" class="btn btn-danger btn-xs" id="delete" onclick="event.preventDefault(); if(confirm('Biztos hogy törlöd ezt a tartalom típust?')){this.closest('form').submit();}"><i class="bi bi-trash"></i></a>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="5">Nincs adat</td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card shadow mb-3 {{ $edit === false ? '' : 'border-success' }}">
<div class="card-header">
    Oldal típus {{ !empty($page_type->name) ? $page_type->name : "" }} {{ $edit === false ? 'létrehozása' : 'szerkesztése' }}
</div>
<div class="card-body">
<div class="row no-gutters align-items-center">
    @if($edit === true)
        <form method="post" action="{{ url('/admin/pages/page-types/update/'.$page_type->id) }}" class="form-horizontal" role="form" id="page_type_form">
        @method('PUT')
    @else
         <form method="post" action="{{ url('/admin/pages/page-types/add/0') }}" class="form-horizontal" role="form" id="page_type_form">
    @endif
    @csrf
    <div class="mb-3 row">
        <label class="col-lg-3 col-form-label">Oldal típus azonosító*</label>
        <div class="col-lg-9">
            <input name="type" type="text" value="{{ @$page_type->type}}" class="form-control" placeholder="Oldal típus azonosító" required>
            <small class="form-text">A resources/lang/routes.php fájlban beállított url-re mutatnak a beállított oldal típusok</small>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-lg-3 col-form-label">Oldal típus neve*</label>
        <div class="col-lg-9">
            <input name="name" type="text" value="{{ @$page_type->name}}" class="form-control" placeholder="Oldal típus neve" required>
        </div>
    </div>

    <hr />
    <div class="mb-3 row">
        <label class="col-lg-3 col-form-label"></label>
        <div class="col-lg-9">
            <button type="submit" class="btn btn-primary">{{ $edit === false ? 'Feltölt' : 'Módosít' }}</button>
            @if($edit === true)
                <a href="{{ url('/admin/pages/page-types/view/0') }}" class="btn btn-danger">Mégsem</a>
            @endif
        </div>
    </div>
    </form>
</div>
</div>
</div>
</div>
</div>
@endsection
