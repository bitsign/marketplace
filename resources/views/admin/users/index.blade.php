@extends('admin.layout.app')
@section('content')
    @include ('admin/layout/page-header', ['page_title' => $page_title])
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">

            @include('admin.users.filter-form')

            <div class="card shadow">
                <div class="card-header">
                    {{ $page_title }}
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-12">
                            @include('layout/messages')
                        </div>
                        <div class="table-responsive">
                            <form action="{{-- route('users.export') --}}" method="post">
                                @csrf
                                <table class="table table-striped table-hover" id="user_list">
                                    <thead>
                                        <tr>
                                            <!--th>
                                            <input type="checkbox" name="select_all" id="user_list_select_all" class="" onclick="$(this).closest('table').find('input[type=checkbox]').prop('checked',$(this).prop('checked'));">
                                        </th -->
                                            <th>Id</th>
                                            <th>{{ __('admin.name') }}</th>
                                            <th>{{ __('email') }}</th>
                                            <th>{{ __('phone') }}</th>
                                            <th>{{ __('admin.active') }}?</th>
                                            <th>{{ __('admin.language') }}?</th>
                                            <th>{{ __('admin.created') }}</th>
                                            <th>{{ __('admin.updated') }}</th>
                                            <th class="text-end">{{ __('admin.operations') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($users[0]))
                                            @foreach ($users as $user)
                                                <tr id="item-{{ $user['id'] }}">
                                                    <!--td><input type="checkbox" name="user_ids[]" value="{{ $user['id'] }}"></td-->
                                                    <td>{{ $user['id'] }}</td>
                                                    <td>
                                                        <a href="{{ route('users.edit', $user['id']) }}">
                                                            {{ Str::words($user['name'], 3, '...') }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $user['email'] }}</td>
                                                    <td>{{ $user['phone'] }}</td>
                                                    <td>
                                                        {!! $user['active'] == 1
                                                            ? "<span class='badge bg-success'>" . __('yes') . '</span>'
                                                            : "<span class='badge bg-success'>" . __('no') . '</span>' !!}
                                                    </td>
                                                    <td><img src="{{ url('assets/img/'.$user['lang'].'.png') }}"></td>
                                                    <td>{{ $user['created_at'] }}</td>
                                                    <td>{{ $user['updated_at'] }}</td>
                                                    <td>
                                                        <div class="btn-group" style="float:right">
                                                            <a class="btn btn-primary btn-xs"
                                                                href="{{ route('users.edit', $user['id']) }}">
                                                                <i class="bi bi-tools"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-xs"
                                                                href="{{ route('users.delete', $user['id']) }}"
                                                                onclick="return confirm('{{ __('admin.msg_are_you_sure') }}')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9">{{ __('admin.no_data') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>

                                </table>
                                <div class="pagination my-4">
                                    {{ $users->links() }}
                                </div>
                                <a class="btn btn-primary btn-xs" href="{{ route('users.export') }}">{{ __('admin.export') }}</a>
                                <hr>
                                <!--a herf="" class="btn btn-primary btn-xs">{{ __('admin.export_selected') }}</a -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
