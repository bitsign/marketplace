<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class AdminShippingMethodController extends AdminBaseController
{
    function __construct()
    {
        parent::__construct();
        $this->data['scripts'][]     = "custom_payments.js?v=".time();
        $this->data['tabs'][]=Array(
                'admin/shipping-methods'         =>'<i class="bi bi-list"></i> '.__('admin.list_pages', ['name' => __('admin.shipping_methods')]),
                'admin/shipping-methods/create'  =>'<i class="bi bi-plus"></i> '.__('admin.create_page', ['name' => __('admin.shipping_method')]),
                );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.shipping_methods');
        $this->data['shippings'] = ShippingMethod::orderBy('sort','asc')->get();
        return view('admin.shippings.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['countries'] = ShippingMethod::getCountries();

        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.shipping_method')]);

        return view('admin.shippings.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posted = array();
        $posted['name']               = $request->translations['name'][app()->getLocale()];
        $posted['code']               = $request->code;
        $posted['sort']               = $request->sort;
        $posted['active']             = !empty($request->active) ? 1 : 0;
        $posted['possible_payments']  = !empty($request->possible_payments) ? json_encode($request->possible_payments) : NULL;
        $posted['possible_countries'] = !empty($request->possible_countries) ? json_encode($request->possible_countries) : NULL;
        $posted['price_interval']     = $request->shipping_charge_method == 'price_interval' ? json_encode($request->price_interval) : NULL;
        $posted['weight_interval']    = $request->shipping_charge_method == 'weight_interval' ? json_encode($request->weight_interval) : NULL;
        $posted['free']               = $request->shipping_charge_method == 'free_shipping' ? 1 : 0;
        $posted['value']              = $request->shipping_charge_method == 'fixed_fee' ? $request->value : 0;
        $posted['translations']       = json_encode($request->translations);

        $shippingMethod = ShippingMethod::create($posted);

        if($shippingMethod->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.shipping_method')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.shipping_method')]));

        return redirect()->route('shipping-methods.edit',$shippingMethod);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingMethod $shippingMethod)
    {
        $this->data['shippingMethod'] = $shippingMethod;

        $this->data['translations'] = json_decode($shippingMethod->translations,true);

        $this->data['countries'] = ShippingMethod::getCountries();

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.shipping_method')]);

        return view('admin.shippings.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingMethod $shippingMethod)
    {

        $posted = array();

        $posted['name']               = $request->translations['name'][app()->getLocale()];
        $posted['code']               = $request->code;
        $posted['sort']               = $request->sort;
        $posted['active']             = $request->active ?? 0;
        $posted['possible_payments']  = $request->possible_payments ?? json_encode($request->possible_payments);
        $posted['possible_countries'] = $request->possible_countries ?? json_encode($request->possible_countries);
        $posted['price_interval']     = $request->shipping_charge_method == 'price_interval' ? json_encode($request->price_interval) : NULL;
        $posted['weight_interval']    = $request->shipping_charge_method == 'weight_interval' ? json_encode($request->weight_interval) : NULL;
        $posted['free']               = $request->shipping_charge_method == 'free_shipping' ? 1 : 0;
        $posted['value']              = $request->shipping_charge_method == 'fixed_fee' ? $request->value : 0;
        $posted['translations']       = json_encode($request->translations);

        $shippingMethod->fill($posted)->save();

        if($shippingMethod->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.shipping_method')]));
        else
            alert('danger',__('admin.msg_not_updated', ['name' => __('admin.shipping_method')]));

        return redirect()->route('shipping-methods.edit',$shippingMethod);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.shipping_method')]));
        return redirect()->route('shipping-methods.index');
    }

    /**
     * Sort shipping methods.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortShippings(Request $request)
    {
        $sort = ShippingMethod::sortShippings($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.shipping_method')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}
