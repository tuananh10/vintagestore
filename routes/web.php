<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;

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
//Home
Route::get('/',[HomeController::class, 'index']);
Route::get('/trang-chu',[HomeController::class, 'index']);
Route::post('/tim-kiem',[HomeController::class, 'search']);

//Danh mục, thương hiệu, sản phẩm
Route::get('/danh-muc-san-pham/{category_id}',[CategoryProduct::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_id}',[BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}',[ProductController::class, 'details_product']);

//Contact 
Route::get('/lien-he',[ContactController::class, 'lien_he']);
Route::get('/information',[ContactController::class, 'information']);

Route::post('/save-info',[ContactController::class, 'save_info']);
Route::post('/update-info/{info_id}',[ContactController::class, 'update_info']);

//Backend
Route::get('/admin',[AdminController::class, 'index']);
Route::get('/dashboard',[AdminController::class, 'show_dashboard']);
Route::get('/logout',[AdminController::class, 'logout']);
Route::post('/admin-dashboard',[AdminController::class, 'dashboard']);

//CategoryProduct 
Route::get('/add-category-product',[CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}',[CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}',[CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product',[CategoryProduct::class, 'all_category_product']);

Route::get('/unactive-category-product/{category_product_id}',[CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}',[CategoryProduct::class, 'active_category_product']);

Route::post('/save-category-product',[CategoryProduct::class, 'save_category_product']);
Route::post('/export-csv',[CategoryProduct::class, 'export_csv']);
Route::post('/import-csv',[CategoryProduct::class, 'import_csv']);

//BrandProduct
Route::get('/add-brand-product',[BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}',[BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}',[BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product',[BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}',[BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}',[BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product',[BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}',[BrandProduct::class, 'update_brand_product']);

//Product
Route::get('/add-product',[ProductController::class, 'add_product']);
Route::get('/edit-product/{product_id}',[ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}',[ProductController::class, 'delete_product']);
Route::get('/all-product',[ProductController::class, 'all_product']);

Route::get('/unactive-product/{product_id}',[ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}',[ProductController::class, 'active_product']);

Route::post('/save-product',[ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}',[ProductController::class, 'update_product']);

//Quickview
Route::post('/quickview',[ProductController::class, 'quickview']);

//Cart 
Route::post('/save-cart',[CartController::class, 'save_cart']);
Route::post('/update-cart-quantity',[CartController::class, 'update_cart_quantity']);
Route::post('/add-cart-ajax',[CartController::class, 'add_cart_ajax']);
Route::post('/update-cart-ajax',[CartController::class, 'update_cart_ajax']);

Route::get('/show-cart',[CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}',[CartController::class, 'delete_to_cart']);
Route::get('/gio-hang',[CartController::class, 'gio_hang']);
Route::get('/delete-pro-ajax/{session_id}',[CartController::class, 'delete_pro_ajax']);
Route::get('/delete-all-product',[CartController::class, 'delete_all_product']);
Route::get('/show-cart-update',[CartController::class, 'show_cart_update']);

//Checkout & payment  
Route::get('/login-checkout',[CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout',[CheckoutController::class, 'logout_checkout']);
Route::get('/checkout',[CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/payment',[CheckoutController::class, 'payment']);
Route::get('/delete-fee',[CheckoutController::class, 'delete_fee']);

Route::post('/add-customer',[CheckoutController::class, 'add_customer']);
Route::post('/select-delivery-home',[CheckoutController::class, 'select_delivery_home']);
Route::post('/save-checkout-customer',[CheckoutController::class, 'save_checkout_customer']);
Route::post('/login-customer',[CheckoutController::class, 'login_customer']);
Route::post('/calculate-fee',[CheckoutController::class, 'calculate_fee']);

//Order 
Route::get('/manage-order',[OrderController::class, 'manage_order']);
Route::get('/view-history-order/{order_code}',[OrderController::class, 'view_history_order']);
Route::get('/history',[OrderController::class, 'history']);
Route::get('/print-order/{checkout_code}',[OrderController::class, 'print_order']);
Route::get('/view-order/{order_code}',[OrderController::class, 'view_order']);

Route::post('/confirm-order',[CheckoutController::class, 'confirm_order']);
Route::post('/update-order-qty',[OrderController::class, 'update_order_qty']);
Route::post('/update-qty',[OrderController::class, 'update_qty']);
Route::post('/cancel-order',[OrderController::class, 'cancel_order']);

//Login facebook
Route::get('/login-facebook',[AdminController::class, 'login_facebook']);
Route::get('/admin/callback',[AdminController::class, 'callback_facebook']);

//Login google
Route::get('/login-google',[LoginController::class, 'login_google']);
Route::get('/google/callback',[LoginController::class, 'callback_google']);

//Coupon
Route::get('/insert-coupon',[CouponController::class, 'insert_coupon']);
Route::get('/list-coupon',[CouponController::class, 'list_coupon']);
Route::get('/delete-coupon/{coupon_id}',[CouponController::class, 'delete_coupon']);
Route::get('/unset-coupon',[CouponController::class, 'unset_coupon']);

Route::post('/insert-coupon-code',[CouponController::class, 'insert_coupon_code']);
Route::post('/check-coupon',[CouponController::class, 'check_coupon']);

//Delivery
Route::get('/delivery',[DeliveryController::class, 'delivery']);

Route::post('/select-delivery',[DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery',[DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship',[DeliveryController::class, 'select_feeship']);
Route::post('/update-delivery',[DeliveryController::class, 'update_delivery']);


//Slider
Route::get('/manage-slider',[SliderController::class, 'manage_slider']);
Route::get('/add-slider',[SliderController::class, 'add_slider']);
Route::get('/unactive-slide/{slider_id}',[SliderController::class, 'unactive_slide']);
Route::get('/active-slide/{slider_id}',[SliderController::class, 'active_slide']);

Route::post('/insert-slider',[SliderController::class, 'insert_slider']);


//Gallery 
Route::get('/add-gallery/{product_id}',[GalleryController::class, 'add_gallery']);

Route::post('/select-gallery',[GalleryController::class, 'select_gallery']);
Route::post('/insert-gallery/{prod_id}',[GalleryController::class, 'insert_gallery']);
Route::post('/update-gallery-name',[GalleryController::class, 'update_gallery_name']);
Route::post('/delete-gallery',[GalleryController::class, 'delete_gallery']);
Route::post('/update-gallery',[GalleryController::class, 'update_gallery']);


//Filter Controller 
Route::post('/filter-by-date',[FilterController::class, 'filter_by_date']);
Route::post('/dashboard-filter',[FilterController::class, 'dashboard_filter']);
Route::post('/days-order',[FilterController::class, 'days_order']);

//Paypal
Route::get('create-transaction', [PaypalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [PaypalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PaypalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PaypalController::class, 'cancelTransaction'])->name('cancelTransaction');







