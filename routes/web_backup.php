<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$locale = request()->segment(1);

if( is_null($locale) === FALSE && in_array($locale, config('app.available_locales')))
    app()->setLocale($locale);

Route::group(['middleware'=>'web','prefix'=>$locale,'where' => ['locale' => '[a-zA-Z]{2}']],function(){

    Route::get('/', [PageController::class,'index']);
    Route::get('/'.__('routes.page').'/{url}', [PageController::class,'show']);

    Route::get('/'.__('routes.services'), [ServiceController::class,'index'])->name(__('routes.services'));
    Route::get('/'.__('routes.service').'/{url}', [ServiceController::class,'show']);

    Route::get('/'.__('routes.portfolio'), [PortfolioController::class,'index']);
    Route::get('/'.__('routes.portfolio').'/{url}', [PortfolioController::class,'show']);

    Route::get('/'.__('routes.faq'), [FaqController::class,'index']);

    Route::get('/'.__('routes.categories').'/{url}', [CategoryController::class,'index']);

    Route::get('/'.__('routes.products').'/{url}', [CategoryController::class,'products']);
    Route::get('/'.__('routes.product').'/{url}', [ProductController::class,'index']);
    Route::get('/'.__('routes.blog'), [PostController::class,'index'])->name(__('routes.blog'));
    Route::get('/'.__('routes.post').'/{url}', [PostController::class,'post'])->name(__('routes.post'));

    Route::get('/'.__('routes.contact'), [ContactController::class,'index'])->name(__('routes.contact'));
    Route::post('/contact-form', [ContactController::class, 'storeContactForm'])->name('contact-form');

    Route::get('/'.__('routes.manufacturers'), [ManufacturerController::class,'index']);
    Route::get('/'.__('routes.manufacturer').'/{url}', [ManufacturerController::class,'show']);

    Route::get('/'.__('routes.login'), [UserController::class, 'index'])->name(__('routes.login'));
    Route::post('/login/login', [UserController::class, 'login'])->name('login.login');
    Route::get('/'.__('routes.register'),[UserController::class, 'register'])->name(__('routes.register'));
    Route::post('/register/save',[UserController::class, 'save'])->name('register.save');
    Route::get('/'.__('routes.logout'),[UserController::class, 'logout'])->name(__('routes.logout'));
    Route::post('/forgot-password/send',[UserController::class, 'ForgotPassword_send'])->name('forgot-password');
    Route::get('/reset-password/{token}', function ($token) {
        return view('users.reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');
    Route::match(['get', 'post'],'/'.__('routes.profile'),[UserController::class,'profile'])->name(__('routes.profile'));

    Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
    Route::match(['get', 'post'],'checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('save-order', [CartController::class, 'saveOrder'])->middleware('auth');
    Route::get('endorder', [CartController::class, 'endOrder'])->name('cart.endorder');

    Route::get('/admin/login', [AdminLoginController::class, 'index']);
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin_login');

});

//rendelés visszaigazoló előnézete
Route::get('preview-order/{id}', function (int $id) {
    
    $order = App\Models\Order::with('products')->with('user')->with('shipping_method')->with('payment_method')->find($id);

    $email_text = App\Models\EmailText::whereEmail_id('order_confirm')->whereLang($order->user->lang)->first();

    app()->setLocale($order->user->lang);
    
    $subject_datas['ORDER_ID'] = '#'.$order->id;
    $subject_datas['SHOP_NAME'] = SHOP_NAME;

    $body_datas['ORDER_ID']      = '#'.$order->id;
    $body_datas['NAME']          = $order->user->name;
    $body_datas['ORDER_DATA']    = view('emails.orders.components.order-details',['order'=>$order])->render();
    $body_datas['BILLING_INFO']  = view('emails.orders.components.billing-details',['order'=>$order])->render();
    //$body_datas['PAYMENT_INFO']  = view('emails.orders.components.payment-details',['order'=>$order])->render();
    $body_datas['SHIPPING_INFO'] = view('emails.orders.components.shipping-details',['order'=>$order])->render();
    $body_datas['SHOP_NAME']     = SHOP_NAME;
    $body_datas['SHOP_MAIL']     = SHOP_MAIL;
    $body_datas['SHOP_PHONE']    = SHOP_PHONE;
    $body_datas['SHOP_WEB']      = SHOP_WEB;

    $template['subject'] = parseTemplate($email_text->subject,$subject_datas);
    $template['body'] = parseTemplate($email_text->body,$body_datas);

    /*try {
        Mail::to('torok.balint200@gmail.com')->locale($order->user->lang)->send(new App\Mail\EndOrder($order,$template));
    } catch (Exception $e) {
        dd($e);
    }*/

    
    return new App\Mail\EndOrder($order,$template);

});