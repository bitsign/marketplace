<?php

use App\Http\Controllers\Admin\AdminAdministratorController;
use App\Http\Controllers\Admin\AdminAttributeController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminBlockController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCurrencyController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEmailTextController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminManufacturerController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminOrderStatusController;
use App\Http\Controllers\Admin\AdminPackageController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPaymentMethodController;
use App\Http\Controllers\Admin\AdminPortfolioController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductImageController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminShippingMethodController;
use App\Http\Controllers\Admin\AdminTeamController;
use App\Http\Controllers\Admin\AdminTermController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVendorController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['IsAdmin']], function(){

    Route::get('/admin/login/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('/admin', [AdminDashboardController::class, 'index']);
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('/admin/pages',AdminPageController::class);
    Route::match(['get', 'post','delete','put'],'/admin/pages/page-types/{event}/{id}',[AdminPageController::class, 'pageTypes']);
    Route::post('/admin/pages/sort-pages',[AdminPageController::class, 'sortPages']);

    Route::resource('/admin/services',AdminServiceController::class);
    Route::post('/admin/services/sort-services',[AdminServiceController::class, 'sortServices']);

    Route::resource('/admin/blocks',AdminBlockController::class);

    Route::resource('/admin/manufacturers',AdminManufacturerController::class);

    Route::resource('/admin/faqs',AdminFaqController::class);
    Route::post('/admin/faqs/sort-faqs',[AdminFaqController::class,'sortFaqs']);

    Route::resource('/admin/team',AdminTeamController::class);
    Route::post('/admin/team/sort-team',[AdminTeamController::class, 'sortTeam']);

    //products
    Route::post('/admin/product/save-attributes',[AdminProductController::class,'saveAttributes'])->name('products.save-attributes');
    Route::get('/admin/product/delete/{id}',[AdminProductController::class,'delete'])->name('products.delete');
    Route::get('/admin/products/get-attributes-values/{id}',[AdminProductController::class,'ajaxGetOptionValues']);
    Route::match(['get', 'post'],'/admin/products',[AdminProductController::class, 'index'])->name('products.index');
    Route::post('/admin/products/get-products-by-category/{id}',[AdminProductController::class,'ajaxGetProductsByCategory']);
    Route::post('/admin/products/update-attached-products',[AdminProductController::class,'updateAttachedProducts']);
    Route::post('/admin/products-export',[AdminProductController::class,'export'])->name('products.export');
    Route::post('/admin/products-export-tr',[AdminProductController::class,'exportTranslations'])->name('products.export-tr');
    Route::post('/admin/products-import',[AdminProductController::class,'import'])->name('products.import');
    Route::post('/admin/products-import-tr',[AdminProductController::class,'importTranslations'])->name('products.import-tr');
    Route::get('/admin/products-import-view',[AdminProductController::class,'importView'])->name('import');
    Route::resource('/admin/products',AdminProductController::class)->except(['destroy','index']);

    //product images
    Route::resource('/admin/product-images',AdminProductImageController::class);

    //attributes
    Route::resource('/admin/attributes',AdminAttributeController::class);
    Route::post('/admin/attributes/sort-attributes',[AdminAttributeController::class, 'sortAttributes']);
    Route::post('/admin/attributes/sort-values',[AdminAttributeController::class, 'sortValues']);
    Route::post('/admin/attributes/values/{id}',[AdminAttributeController::class, 'updateValues'])->name('attributes.values');
    Route::post('/admin/attributes/delete-value/{id}',[AdminAttributeController::class, 'deleteValue']);
    Route::get('/admin/get-attributes-values',[AdminAttributeController::class, 'getAttributeValues']);

    //attached products
    Route::post('/admin/get-products-by-category/{category_id}',[AdminProductController::class, 'getProductsByCategory']);

    Route::resource('/admin/banners',AdminBannerController::class);
    Route::post('/admin/banners/sort-banners',[AdminBannerController::class, 'sortBanners']);

    Route::resource('/admin/categories',AdminCategoryController::class);

    //orders
    Route::get('/admin/orders/deleted-orders',[AdminOrderController::class, 'deletedOrders'])->name('orders.deleted-orders');
    Route::resource('/admin/orders',AdminOrderController::class);
    Route::match(['get', 'post'],'/admin/orders',[AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/admin/orders/soft-delete/{id}',[AdminOrderController::class, 'softDeleteOrder'])->name('orders.soft-delete');
    Route::get('/admin/orders/invoice/{id}',[AdminOrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('/admin/orders/update-status',[AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    

    //order stautuses
    Route::resource('/admin/statuses',AdminOrderStatusController::class);

    //portfolio
    Route::resource('/admin/portfolios',AdminPortfolioController::class);
    Route::post('/admin/portfolio/sort-portfolio',[AdminPortfolioController::class, 'sortPortfolio']);
    Route::post('/admin/portfolio/upload-images/{id}',[AdminPortfolioController::class, 'uploadImages']);
    Route::post('/admin/portfolio/set-image',[AdminPortfolioController::class, 'setImage']);
    Route::post('/admin/portfolio/delete-image',[AdminPortfolioController::class, 'deleteImage']);

    //tags/terms
    Route::resource('/admin/terms',AdminTermController::class);

    //e-mail texts
    Route::resource('/admin/email-texts',AdminEmailTextController::class);

    //payment methods
    Route::resource('/admin/payment-methods',AdminPaymentMethodController::class);
    Route::post('/admin/payment-methods/sort-payments',[AdminPaymentMethodController::class, 'sortPayments']);

    //shipping methods
    Route::resource('/admin/shipping-methods',AdminShippingMethodController::class);
    Route::post('/admin/shipping-methods/sort-shippings',[AdminShippingMethodController::class, 'sortShippings']);

    //users
    Route::resource('/admin/users',AdminUserController::class);
    Route::match(['get', 'post'],'/admin/users-list',[AdminUserController::class, 'usersList'])->name('users.list');
    Route::post('/admin/users/check-user-email',[AdminUserController::class, 'checkUserEmail']);
    Route::get('/admin/users/delete/{id}',[AdminUserController::class,'delete'])->name('users.delete');
    Route::get('/admin/users-export/', [AdminUserController::class, 'export'])->name('users.export');

    //vendors
    Route::resource('/admin/vendors',AdminVendorController::class);
    Route::match(['get', 'post'],'/admin/vendors-list',[AdminVendorController::class, 'vendorsList'])->name('vendors.list');
    Route::post('/admin/vendors/check-user-email',[AdminVendorController::class, 'checkVendorEmail']);
    Route::get('/admin/vendors/delete/{id}',[AdminVendorController::class,'delete'])->name('vendors.delete');
    Route::get('/admin/vendors-export/', [AdminVendorController::class, 'export'])->name('vendors.export');

    //blog
    Route::resource('/admin/posts',AdminPostController::class);

    //settings
    Route::resource('/admin/settings',AdminSettingController::class);

    //administrators
    Route::resource('/admin/administrators',AdminAdministratorController::class);

    //currencies
    Route::get('/admin/currencies/update-exchage-rates',[AdminCurrencyController::class,'updateExchangeRates'])->name('update-exchage-rates');
    Route::resource('/admin/currencies',AdminCurrencyController::class);

    //packages
    Route::resource('/admin/packages',AdminPackageController::class);
    Route::post('/admin/packages/sort-packages',[AdminPackageController::class, 'sortPackages']);
    

});