<?php
use Illuminate\Http\Request;

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

Auth::routes();

// Route::resource('order','orderController',[
// 		'except' => ['show','edit','update','destroy','create']
// ]);


// Route::get('/','orderController@showOrder')->name('homepage');
// Route::post('/order','orderController@store')->name('postOrder');
// Route::post('/voucher','voucherController@get_voucher')->name('get_voucher');

// Route::POST('/rewardOnline','rewardController@rewardOnline')->name('online_reward');
// Route::POST('/rewardPos','rewardController@rewardPos')->name('pos_reward');
// Route::post('/ref','searchRef@search')->name('search');
// Route::POST('/voucher','voucherController@index')->name('view_voucherOrder');
// Route::POST('/pickup','voucherController@pickup')->name('pickup');

//Route::get('/order', 'HomeController@index')->name('home');

Route::get('/testa',function(){

	

});

Route::get('/',function(){
	return view('index');
});
Route::get('/test','voucherController@test');
Route::get('/neworder','OrderController@newOrder');
Route::post('/createvoucher','voucherController@createPosVoucher');
Route::post('/vouchertopos','voucherController@send_voucher_to_rockpos');
Route::post('/pullvoucher','voucherController@pull_online_voucher_rockpos');
Route::post('/voucher_results','voucherController@voucher_results');
Route::post('/checkreward','voucherController@check_reward');
Route::post('/not_use_reward','voucherController@not_use_reward');
Route::post('/forgot_use_reward','voucherController@forgot_use_reward');
Route::post('/search_order_by_ref','orderController@search_order_by_ref');
Route::post('/collect_in_store','orderController@collect_in_store');
Route::post('/search_reward_by_email','CustomerController@search_reward_by_email');
Route::post('/transfer_customer_check','CustomerController@transfer_customer_check');
Route::post('/get_member','CustomerController@get_member');
Route::post('/pull_reward','voucherController@pull_reward');

Route::post('/check_remain_reward_use','voucherController@check_remain_reward_use');
Route::post('/get_total_today','CustomerController@get_total_today');
Route::post('/refund-order','RefundController@check_order_refund');
Route::post('/go-refund','RefundController@go_refund');


