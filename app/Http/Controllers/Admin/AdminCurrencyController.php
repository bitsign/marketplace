<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminCurrencyController extends AdminBaseController
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->data['tabs'][]=Array(
                'admin/currencies'          =>__('admin.list_pages', ['name' => __('admin.currencies')]),
                'admin/currencies/create'   =>__('admin.create_page', ['name' => __('admin.currency')])
                );
        //$this->data['scripts'][]    = "custom_currency.js";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.currencies');

        $this->data['currencies'] = Currency::all();

        return view('admin.currencies.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.currency')]);

        return view('admin.currencies.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posted = $request->all();
        unset($posted['_method']);
        unset($posted['_token']);

        $posted['active'] = !empty($request->active) ? 1 : 0;

        $currency = Currency::create($posted);

        if($currency->wasRecentlyCreated)
        {
            alert('success',__('admin.msg_created', ['name' => __('admin.currency')]));
        }
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.currency')]));

        return redirect()->route('currencies.edit',$currency);
    }

   /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->data['currency'] = Currency::whereId($id)->first();

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.currency')]);

        return view('admin.currencies.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\currencies  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        
        $posted = $request->all();
        unset($posted['_method']);
        unset($posted['_token']);
        
        $posted['active'] = !empty($request->active) ? 1 : 0;

        $currency->fill($posted)->save();

        if($currency->wasChanged() > 0)
            alert('success',__('admin.msg_updated', ['name' => __('admin.currency')]));
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('currencies.edit',$currency);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\currencies  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        alert('success',__('admin.msg_deleted', ['name' => __('admin.currency')]));

        return redirect()->route('currencies.index');
    }

    /**
     * Sort currencies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortCurrencies(Request $request)
    {
        $sort = Currency::sortCurrencies($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.currencies')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }

    function updateExchangeRates()
    {
        Artisan::call("currency:update", [
            "-r" => true
        ]);
        alert('success',__('admin.msg_updated', ['name' => __('admin.currencies')]));
        return redirect()->route('currencies.index');
    }
}
