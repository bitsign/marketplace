<?php

namespace App\Http\Controllers;

use App\Mail\EndOrder;
use App\Models\EmailText;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\User;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function cartList()
    {
        $data['cartItems'] = \Cart::getContent();
        // dd($cartItems);

        $selected_shipping = \Cart::getConditionsByType('shipping');

        $data['selected_shipping'] = "";
        if(!empty($selected_shipping))
        {
            foreach($selected_shipping as $ss)
            {
                $data['selected_shipping'] = $ss->getName();
            }
        }

        $selected_payment = \Cart::getConditionsByType('payment');
        $data['selected_payment'] = "";
        if(!empty($selected_payment))
        {
            foreach($selected_payment as $sp)
            {
                $data['selected_payment'] = $sp->getName();
            }
        }
        
        $data['transportOptions'] = ShippingMethod::where('active',1)->get();
        $data['paymentModes']     = PaymentMethod::where('active',1)->get();
        $data['breadcrumbs'][]    = ['title'=>__('cart')];
        return view('cart.cart', $data);
    }


    public function addToCart(Request $request)
    {
        $shipping_id = !empty( $request->shipping_id) ?  $request->shipping_id : 0;

        \Cart::add([
            'id'         => mt_rand(),
            'name'       => $request->name,
            'price'      => $request->price,
            'quantity'   => $request->quantity,
            'attributes' => array(
                'product_id'     => $request->id,
                'product_number' => $request->product_number,
                'unit'           => $request->unit,
                'options'        => $request->option,
                'shipping_id'    => $shipping_id,
                'image'          => $request->image,
            ),
        ]);
        session()->flash('success', __('added_to_cart'));

        return redirect()->route('cart.list');
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', __('qty_updated'));

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', __('cart_item_deleted'));

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();
        \Cart::clearCartConditions();
        session()->flash('success', __('cart_deleted'));

        return redirect()->route('cart.list');
    }

    public function checkout(Request $request)
    {
        $shipping_code = !empty( $request->shipping) ?  $request->shipping : 0;
        if(!empty( $request->shipping))
            \Cart::clearCartConditions();
        if($shipping_code != 0)
        {
            $shipping = ShippingMethod::where('code',$shipping_code)->first();
            $shipping_translation   = json_decode($shipping['translations'],true);

            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name'  => $shipping_translation['name'][app()->getLocale()],
                'type'  => 'shipping',
                'target'=> 'total',
                'value' => $shipping['value']!= 0 ? '+'.$shipping['value'] : 0,
                'order' => 1,
                'attributes' => array(
                    'id' => $shipping['id']
                )
            ));
            \Cart::condition($condition);
        }
        $payment_code = !empty( $request->payment) ?  $request->payment : 0;
        if($payment_code != 0)
        {
            $payment = PaymentMethod::where('code',$payment_code)->first();
            $payment_translation   = json_decode($payment['translations'],true);

            $payment_condition = new \Darryldecode\Cart\CartCondition(array(
                'name'   => $payment_translation['name'][app()->getLocale()],
                'type'   => 'payment',
                'target' => 'total',
                'value'  => $payment['value']!= 0 ? '+'.$payment['value'] : 0,
                'order'  => 2,
                'attributes' => array(
                    'id' => $payment['id']
                )
            ));
            \Cart::condition($payment_condition);
        }

        $data['breadcrumbs'][] = ['title'=>__('cart'),'url'=>app()->getLocale().'/cart'];
        $data['breadcrumbs'][] = ['title'=>__('checkout')];
        $data['cartItems'] = \Cart::getContent();
        $data['countries'] = User::getCountries();

        return view('cart.checkout', $data);
    }

    public function saveOrder(Request $request)
    {
        $data['cartItems'] = \Cart::getContent();
        
        $selected_shipping = \Cart::getConditionsByType('shipping');
        if(!empty($selected_shipping))
        {
            foreach($selected_shipping as $ss)
            {
                $shipping_method_id = $ss->getAttributes();
                $shipping_cost = $ss->getValue();
            }
        }

        $selected_payment = \Cart::getConditionsByType('payment');
        if(!empty($selected_payment))
        {
            foreach($selected_payment as $sp)
            {
                $payment_method_id = $sp->getAttributes();
            }
        }

        $this->updateUserDatas($request);

        //Insert into orders table
        $order = Order::create([
            'user_id'               => Auth::user()->id,
            'hash'                  => md5(uniqid(rand(), true)),
            'payment_method_id'     => $payment_method_id['id'],
            'shipping_method_id'    => $shipping_method_id['id'],
            'shipping_cost'         => str_replace('+','',$shipping_cost),
            'coupon_id'             => "0",
            'coupon_value'          => "0",
            'total'                 => \Cart::getTotal(),
            'status_id'             => 1,
            'closed'                => 1,
            'user_note'             => $request->user_note ?? '',
            'ip_address'            => $request->ip(),
            'lang'                  => app()->getLocale(),
            'currency'              => currency()->getUserCurrency()
        ]);

        Order::where('id', $order->id)->update(['advanced_id' => $order->id.'/'.date('Y')]);

        // Insert into order_product table
        foreach (\Cart::getContent() as $item) {
            OrderProduct::create([
                'order_id'      => $order->id,
                'product_id'    => $item->id,
                'version_name'  => $item->name,
                'product_number'=> "",
                'qty'           => $item->quantity,
                'price'         => $item->price,
                'options'       => json_encode($item->attributes->options),
            ]);
        }

        // decrease the quantities of all the products in the cart
        //$this->decreaseQuantities();

        $order = Order::with('products')->with('user')->with('shipping_method')->with('payment_method')->find($order->id);
        $email_text = EmailText::whereEmail_id('order_confirm')->whereLang($order->user->lang)->first();

        if($payment_method_id['id'] == 4)
            $payment_info = parseTemplate($email_text->bank_transfer,array('ORDER_ID'=>$order->advanced_id));
        else
            $payment_info = "";
        
        $subject_datas['ORDER_ID'] = '#'.$order->advanced_id;
        $subject_datas['SHOP_NAME'] = SHOP_NAME;

        $body_datas['ORDER_ID']      = '#'.$order->id;
        $body_datas['NAME']          = $order->user->name;
        $body_datas['ORDER_DATA']    = view('emails.orders.components.order-details',['order'=>$order])->render();
        $body_datas['BILLING_INFO']  = view('emails.orders.components.billing-details',['order'=>$order])->render();
        $body_datas['PAYMENT_INFO']  = $payment_info;
        $body_datas['SHIPPING_INFO'] = view('emails.orders.components.shipping-details',['order'=>$order])->render();
        $body_datas['SHOP_NAME']     = SHOP_NAME;
        $body_datas['SHOP_MAIL']     = SHOP_MAIL;
        $body_datas['SHOP_PHONE']    = SHOP_PHONE;
        $body_datas['SHOP_WEB']      = SHOP_WEB;

        $template['subject'] = parseTemplate($email_text->subject,$subject_datas);
        $template['body']    = parseTemplate($email_text->body,$body_datas);

        Mail::to($order->user->email)->locale($order->user->lang)->send(new EndOrder($order,$template));

        \Cart::clear();
        \Cart::clearCartConditions();
        //\Cart::session(Auth::user()->id)->clear();
        session()->forget('coupon');

        $data['breadcrumbs'][] = ['title'=>__('checkout')];

        //alert('success',__('order_success'));

        return redirect()->route('cart.endorder');
    }

    function endOrder()
    {
        $data['breadcrumbs'][] = ['title'=>__('thanks_for_order')];
        return view('cart.endorder', $data);
    }

    protected function decreaseQuantities()
    {
        foreach (Cart::getContent() as $item) {
            $product = Product::find($item->attributes->product_id);
            $product->update(['stock' => $product->stock - $item->qty]);
        }
    }

    private function updateUserDatas($request)
    {
        $user = Auth::user();
        $user->name     = $request->get('name');
        $user->country  = $request->get('country');
        $user->state    = $request->get('state');
        $user->city     = $request->get('city');
        $user->address  = $request->get('address');
        $user->zip      = $request->get('zip');
        $user->state2   = $request->get('state2');
        $user->city2    = $request->get('city2');
        $user->address2 = $request->get('address2');
        $user->zip2     = $request->get('zip2');
        $user->save();
    }
}
