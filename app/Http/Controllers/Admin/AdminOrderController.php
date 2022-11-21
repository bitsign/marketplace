<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Mail\EndOrder;
use App\Models\EmailText;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends AdminBaseController
{
    public $data;

    function __construct()
    {
        parent::__construct();
        $this->data['css'][]        = "../plugins/datepicker/datepicker3.css";
        $this->data['scripts'][]    = "../plugins/datepicker/bootstrap-datepicker.js";
        $this->data['scripts'][]    = "../plugins/datepicker/locales/bootstrap-datepicker.hu.js";

        $this->data['scripts'][]    = "custom_orders.js?v=".time();
        $this->data['tabs'][]=Array(
                'admin/orders'                   =>'<i class="bi bi-list"></i> '.__('admin.orders'),
                'admin/orders/deleted-orders'           =>'<i class="bi bi-list"></i> '.__('admin.deleted_orders'),
                );
        $this->data['page_title'] = __('admin.orders');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request))
            $this->setFilters($request);

        //DB::enableQueryLog();
        $this->data['orders'] = Order::where('status_id','!=','3')->filter($request)->paginate(session('order_limit'));
        //dd(DB::getQueryLog());

        return view('admin.orders.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['order'] = Order::whereId($id)->first();
        $this->data['status'] = Status::whereId($this->data['order']['status_id'])->first();
        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.order').' #'.$this->data['order']['id']]);
        return view('admin.orders.edit', $this->data);
    }

    public function invoice($id)
    {
        $this->data['order'] = Order::whereId($id)->first();
        app()->setLocale($this->data['order']->user->lang);
        $this->data['status'] = Status::whereId($this->data['order']['status_id'])->first();
        $this->data['page_title'] = __('admin.edit_page', ['name' => __('admin.order').' #'.$this->data['order']['id']]);
        return view('admin.orders.invoice', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $defaults = $this->setDefautFields($request->all());
        
        $order->fill($defaults)->save();

        alert('success',__('admin.msg_updated', ['name' => __('admin.order')]));

        return redirect()->route('orders.edit',$order->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        OrderProduct::where('order_id', $order->id)->delete();

        $order->delete();

        alert('success',__('admin.msg_deleted', ['name' => __('admin.order')]));

        return redirect()->route('orders.deleted-orders');
    }

    public function softDeleteOrder(int $id)
    {
        $order = Order::whereId($id)->first();

        $order->fill(['status_id'=>3])->save();

        alert('success',__('admin.msg_deleted', ['name' => __('admin.order')]));

        return redirect()->route('orders.index');
    }

    /**
     * Show deleted orders.
     * @return \Illuminate\Http\Response
     */
    public function deletedOrders()
    {
        $this->data['page_title'] = __('admin.deleted_orders');

        $this->data['orders'] = Order::with('user')->whereStatus_id(3)->get();

        return view('admin.orders.deleted', $this->data);
    }

    /**
     * Show deleted orders.
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $order = Order::with('products')->with('user')->with('shipping_method')->with('payment_method')->find($request->order_id);

        $order->fill(['status_id'=>$request->status])->save();

        if($order->wasChanged())
        {
            if($request->send_status_alert !== NULL)
            {
                $email_text = EmailText::whereEmail_id('order_status')->whereLang($order->user->lang)->first();

                $status = Status::whereId($order->status_id)->first();
                $status_translation = json_decode($status->translations,true);
                
                $subject_datas['ORDER_ID'] = '#'.$order->id;
                $subject_datas['SHOP_NAME'] = SHOP_NAME;

                $body_datas['ORDER_ID']      = '#'.$order->id;
                $body_datas['NAME']          = $order->user->name;
                $body_datas['STATUS']        = $status_translation[$order->user->lang];
                $body_datas['ADMIN_MESSAGE'] = $request->admin_message;
                $body_datas['SHOP_NAME']     = SHOP_NAME;
                $body_datas['SHOP_MAIL']     = SHOP_MAIL;
                $body_datas['SHOP_PHONE']    = SHOP_PHONE;
                $body_datas['SHOP_WEB']      = SHOP_WEB;

                $template['subject'] = parseTemplate($email_text->subject,$subject_datas);
                $template['body'] = parseTemplate($email_text->body,$body_datas);

                Mail::to($order->user->email)->send(new EndOrder($order,$template));
            }

            alert('success',__('admin.msg_updated', ['name' => __('admin.order')]));
        }
        else
            alert('info',__('admin.msg_no_change'));

        return redirect()->route('orders.edit',$order->id);
    }

    function setFilters($request)
    {
        if(!empty($request['order_filter']))
            session(['filter_order'=>1]);

        if(!empty($request['status']))
            session(['filter_order_status'=>$request['status']]);
        else
            session()->forget('filter_order_status');

        if(!empty($request['name']))
            session(['filter_order_user'=>$request['name']]);
        else
            session()->forget('filter_order_user');

        if(!empty($request['id']))
            session(['filter_order_id'=>$request['id']]);
        else
            session()->forget('filter_order_id');

        if(!empty($request['mindate']))
            session(['filter_order_mindate'=>$request['mindate']]);
        else
            session()->forget('filter_order_mindate');

        if(!empty($request['maxdate']))
            session(['filter_order_maxdate'=>$request['maxdate']]);
        else
            session()->forget('filter_order_maxdate');

        if(!empty($request['limit']))
            session(['order_limit'=>$request['limit']]);

        if(!empty($request['clear_filters']))
        {
            $request->session()->forget([
                'filter_order', 
                'filter_order_status',
                'filter_order_user',
                'filter_order_id',
                'filter_order_mindate',
                'filter_order_maxdate',
            ]);
            session(['order_limit'=>50]);
        }

    }
}
