<div class="card shadow mb-2">
    <div class="card-header">
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#filters" role="button" aria-expanded="{{ !empty(session('filter_product')) ? 'true' : 'false' }}" aria-controls="filters">{{ __('admin.filter') }}</a>
    </div>
    <div class="collapse {{ !empty(session('filter_user')) ? 'show' : '' }}" id="filters">
        <div class="card card-body">
        <form action="{{ route('users.list') }}" method='POST'>
            @csrf

            <div class="row mb-2">
                <label class="col-lg-2 text-end">{{ __('admin.name') }}</label>
                <div class="col-lg-8">
                    <input name="name" type="text" value="{{ session('filter_user_name'); }}" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end">{{ __('email') }}</label>
                <div class="col-lg-8">
                    <input name="email" type="text" value="{{ session('filter_user_email'); }}" class="form-control">
                </div>
            </div>

            <div class="row mb-2">
                <label class="col-lg-2 text-end">{{ __('phone') }}</label>
                <div class="col-lg-8">
                    <input name="phone" type="text" value="{{ session('filter_user_phone'); }}" class="form-control">
                </div>
            </div>

             <div class="row mb-2">
                <label class="col-lg-2 text-end">
                    {{ __('admin.order_by') }}
                </label>
                <div class="col-lg-4">
                <select name="order_by" id="order_by" class="form-select float-end">
                    <option value="">
                        {{ __('default') }} ({{ __('admin.order_by_desc',['name'=>__('ID')]) }})
                    </option>
                    <option value="name_asc" {{  session('filter_user_order_by') == 'name_asc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_asc',['name'=>__('admin.name')]) }}
                    </option>
                    <option value="name_desc" {{  session('filter_user_order_by') == 'name_desc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_desc',['name'=>__('admin.name')]) }}
                    </option>
                    <option value="date_asc" {{  session('filter_user_order_by') == 'date_asc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_asc',['name'=>__('Date')]) }}
                    </option>
                    <option value="date_desc" {{  session('filter_user_order_by') == 'date_desc' ? 'selected' : '' }}>
                        {{ __('admin.order_by_desc',['name'=>__('Date')]) }}
                    </option>
                </select>
                </div>
                <div class="col-lg-2">
                    <select name="limit" class="form-select float-end">
                        <option value="50" {{  session('filter_user_limit') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{  session('filter_user_limit') == 100 ? 'selected' : '' }}>100</option>
                        <option value="200" {{  session('filter_user_limit') == 200 ? 'selected' : '' }}>200</option>
                        <option value="999999" {{  session('filter_user_limit') == 999999 ? 'selected' : '' }}>{{ __('all') }}</option>
                    </select>
                </div>
                <label class="col-lg-2">
                    {{ __('admin.founds_per_page') }}
                </label>
            </div>
            <div class="row mb-2">
                <div class="offset-lg-2 col-lg-2">
                    <button type="submit" name="filter" value="1" class="btn btn-primary">{{ __('search') }}</button>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-warning" name="clear_filters" value="1">{{ __('admin.filter_reset') }}</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
