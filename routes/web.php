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

Route::get('/test',function(){
	$email = 'a';
	$vouchers =  DB::table('ps_cart_rule as a')
									->select('a.id_customer',
									 DB::raw('sum(a.reduction_amount) as credits'),'b.email')
									->join('ps_customer as b','a.id_customer','=','b.id_customer')
									->where('a.quantity',1)->where('a.description','10% Online Credit Back')
									->groupBy('a.id_customer')
									//->join('ps_customer as b','a.id_customer','=','b.id_customer')
									->where('b.email','LIKE','%'.$email.'%')
									->limit(5)
									->get();
									return $vouchers;

});

Route::get('/',function(){
	return view('index');
});

Route::get('/neworder','OrderController@newOrder');
Route::post('/createvoucher','voucherController@createPosVoucher');
Route::post('/vouchertopos','voucherController@send_voucher_to_rockpos');
Route::post('/pullvoucher','voucherController@pull_online_voucher_rockpos');
