<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AdminPaymentMethodController extends AdminBaseController
{
    function __construct()
    {
        parent::__construct();
        $this->data['scripts'][]     = "custom_payments.js?v=".time();
        $this->data['tabs'][]=Array(
                'admin/payment-methods'         =>'<i class="bi bi-list"></i> '.__('admin.list_pages', ['name' => __('admin.payment_methods')]),
                'admin/payment-methods/create'  =>'<i class="bi bi-plus"></i> '.__('admin.create_page', ['name' => __('admin.payment_method')]),
                );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['page_title'] = __('admin.payment_methods');
        $this->data['payments'] = PaymentMethod::orderBy('sort','asc')->get();
        return view('admin.payments.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['page_title'] = __('admin.create_page', ['name' => __('admin.payment_method')]);

        return view('admin.payments.create', $this->data);
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
        $posted['name']         = $request->translations['name'][app()->getLocale()];
        $posted['active']       = !empty($request->active) ? 1 : 0;
        $posted['code']         = $request->code;
        $posted['value']        = $request->value;
        $posted['sort']         = $request->sort;
        $posted['translations'] = json_encode($request->translations);

        $paymentMethod = PaymentMethod::create($posted);

        if($paymentMethod->wasRecentlyCreated)
            alert('success',__('admin.msg_created', ['name' => __('admin.payment_method')]));
        else
            alert('danger',__('admin.msg_not_created', ['name' => __('admin.payment_method')]));

        return redirect()->route('payment-methods.edit',$paymentMethod);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $PaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        $this->data['paymentMethod'] = $paymentMethod;

        $this->data['translations'] = json_decode($paymentMethod->translations,true);

        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.payment_method')]);

        return view('admin.payments.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $PaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $posted = array();
        $posted['name']         = $request->translations['name'][app()->getLocale()];
        $posted['active']       = !empty($request->active) ? 1 : 0;
        $posted['code']         = $request->code;
        $posted['value']        = $request->value;
        $posted['sort']         = $request->sort;
        $posted['translations'] = json_encode($request->translations);
        $paymentMethod->fill($posted)->save();

        if($paymentMethod->wasChanged())
            alert('success',__('admin.msg_updated', ['name' => __('admin.payment_method')]));
        else
            alert('danger',__('admin.msg_not_updated', ['name' => __('admin.payment_method')]));

        return redirect()->route('payment-methods.edit',$paymentMethod);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $PaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        alert('success',__('admin.msg_deleted', ['name' => __('admin.payment_method')]));
        return redirect()->route('payment-methods.index');
    }

    /**
     * Sort payment methods.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    function sortPayments(Request $request)
    {
        $sort = PaymentMethod::sortPayments($request->item);
        if($sort > 0)
        {
            alert('success',__('admin.msg_sorted', ['name' => __('admin.payment_method')]));
            echo "1";
        }
        else
        {
            alert('info',__('admin.msg_no_change'));
            echo "0";
        }
    }
}
