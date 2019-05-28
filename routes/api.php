<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/branchStockTakeList','StockTakeController@get_stockTake_list');
Route::post('/saveToBranchStockTakeHistory','StockTakeController@saveTo_stockTakeHistory');
Route::post('/addMissing','StockTakeController@addMissing_toStockTakeHistory');

Route::post('/myStockTake_records','StockTakeController@myStockTake_records');
Route::post('/allStockTake_records','StockTakeController@allStockTake_records');
Route::post('/stockTake_final_results','StockTakeController@stockTake_final_results');
