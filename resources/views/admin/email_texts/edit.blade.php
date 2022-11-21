@extends('admin.layout.app')
@section('content')

@include ('admin/layout/page-header',['page_title'=>$page_title])
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header"><b>{{ $page_title }}</b></div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col-lg-12">@include('layout/messages')</div>
                    <form method="post" action="{{ route('email-texts.update',$emailText->id) }}" class="form-horizontal" role="form" id="page_form">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.language') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <select name="lang" class="form-select" required>
                                    @foreach (config('app.available_locales') as $key => $lang)
                                    <option value="{{ $lang }}" @selected($emailText['lang'] == $lang)>
                                        {{ $key }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.id') }}</label>
                            <div class="col-lg-8">
                                <input name="email_id" type="text" value="{{ $emailText['email_id'] }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.title') }} <code>*</code></label>
                            <div class="col-lg-8">
                                <input name="name" type="text" value="{{ $emailText['name'] }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.subject') }}</label>
                            <div class="col-lg-8">
                                <input name="subject" type="text" value="{{ $emailText['subject'] }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.email_body') }}</label>
                            <div class="col-lg-8">
                                <textarea id="editor1" class="editor" name="body" rows="10" cols="80">{{ $emailText['body'] }}</textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.bank_transfer') }}</label>
                            <div class="col-lg-8">
                                <textarea id="editor2" class="editor" name="bank_transfer" rows="10" cols="80">{{ $emailText['bank_transfer'] }}</textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end">{{ __('admin.courier') }}</label>
                            <div class="col-lg-8">
                                <textarea id="editor3" class="editor" name="courier" rows="10" cols="80">{{ $emailText['courier'] }}</textarea>
                            </div>
                        </div>

                        <hr />
                        <div class="mb-3 row">
                            <label class="col-lg-2 text-lg-end"></label>
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ __('admin.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
