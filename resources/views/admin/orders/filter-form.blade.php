<div class="card shadow mb-2">
    <div class="card-header">
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#filters" role="button" aria-expanded="{{ !empty(session('filter_order')) ? 'true' : 'false' }}" aria-controls="filters">{{ __('admin.filter') }}</a>
    </div>
    <div class="collapse {{ !empty(session('filter_order')) ? 'show' : '' }}" id="filters">
        <div class="card card-body">
        <form action="{{ route('orders.index') }}" method='POST'>
            @csrf

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label">{{ __('status') }}</label>
                <div class="col-lg-8">
                    {!! custom_select('statuses','status','id','name',false,false,session('filter_order_status'),[''=>__('all')]) !!}
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label">{{ __('admin.name') }}</label>
                <div class="col-lg-8">
                    <input name="name" type="text" value="{{ session('filter_order_user') }}" class="form-control">
                </div>
            </div>

             <div class="row mb-2">
                <label class="col-lg-2 col-form-label">{{ __('admin.order_id') }}</label>
                <div class="col-lg-8">
                    <input name="id" value="{{ session('filter_order_id') }}" type="text" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label">{{ __('admin.order_min_date') }}</label>
                <div class="col-lg-8">
                    <input name="mindate" value="{{ session('filter_order_mindate') }}" class="form-control input-sm" type="text" id="datepicker_from"/>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label">{{ __('admin.order_max_date') }}</label>
                <div class="col-lg-8">
                    <input name="maxdate" value="{{ session('filter_order_maxdate') }}" class="form-control input-sm" type="text" id="datepicker_to"/>
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 col-form-label"></label>
                <div class="col-lg-8">
                    <select name="limit" class="form-select float-start" style="width: auto; margin:0 10px 0 0;">
                        <option value="10" @selected(session('order_limit') == 10)>10</option>
                        <option value="50" @selected(session('order_limit') == 50)>50</option>
                        <option value="100" @selected(session('order_limit') == 100)>100</option>
                        <option value="200" @selected(session('order_limit') == 200)>200</option>
                        <option value="999999" @selected(session('order_limit') == 999999)>{{ __('all') }}</option>
                    </select>
                     {{ __('admin.founds_per_page') }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="offset-lg-2 col-lg-2">
                    <button type="submit" class="btn btn-primary" value="1" name="order_filter">{{ __('search') }}</button>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-warning" name="clear_filters" value="1">{{ __('admin.filter_reset') }}</button>
                </div>
            </div>

        </form>
        </div>
    </div>
</div>
