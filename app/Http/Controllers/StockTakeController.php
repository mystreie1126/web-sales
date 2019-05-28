<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Branch_stockTake_history;
use Illuminate\Support\Facades\Auth;


class StockTakeController extends Controller
{

    // public function index(){
    //     if(Auth::check()){
    //         $query = DB::table('users')
    //              ->select('users.name','users.shop_id')
    //              ->where('users.id',Auth::User()->id)
    //              ->get();
    //         return view('stockTake',compact('query'));
    //
    //     }
    // }


    public function get_stockTake_list(Request $request){
    	$query = DB::connection('mysql2')
    	       ->table('ps_stock_available as a')
    	       ->select('a.id_stock_available as pos_stock_id','b.reference','c.name')

    	       ->join('ps_product as b','a.id_product','b.id_product')
    	       ->where('a.id_shop',$request->shop_id)
    	       ->join('ps_product_lang as c','c.id_product','a.id_product')
    	       ->where('c.id_shop',$request->shop_id)
    	       ->where('c.name','not like','%'.'test'.'%')
    	       ->get();

        $branch_name = DB::connection('mysql2')
               ->table('ps_shop')->select('name')
               ->where('id_shop',$request->shop_id)
               ->get();

        return response()->json(['list'=>$query,'shopname'=>$branch_name]);

    }

    public function saveTo_stockTakeHistory(Request $request){

        $branch_stockTake = new Branch_stockTake_history;

        $branch_stockTake->pos_stock_id     = $request->pos_stock_id;
        $branch_stockTake->name             = $request->name;
        $branch_stockTake->reference        = $request->reference;
        $branch_stockTake->username         = $request->username;
        $branch_stockTake->shop_id          = $request->shop_id;
        $branch_stockTake->updated_quantity = $request->qty;

        $branch_stockTake->save();

    	return response()->json('saved');

    }

    public function addMissing_toStockTakeHistory(Request $request){
        $branch_stockTake = new Branch_stockTake_history;

        $branch_stockTake->pos_stock_id     = $request->pos_stock_id;
        $branch_stockTake->name             = $request->name;
        $branch_stockTake->reference        = $request->reference;
        $branch_stockTake->username         = $request->username;
        $branch_stockTake->shop_id          = $request->shop_id;
        $branch_stockTake->updated_quantity = $request->qty;
        $branch_stockTake->added            = $request->added;

        $branch_stockTake->save();

    	return response()->json('saved to added');
    }

    public function myStockTake_records(Request $request){
        $query = DB::connection('mysql3')->table('sm_branchStockTake_history as a')
                 ->select('a.created_at','a.added','a.name as product_name','a.reference as ref','a.updated_quantity as added_quantity','a.username','b.name as shop_name')
                 ->where('a.shop_id',$request->shop_id)
                 ->join('c1ft_pos_prestashop.ps_shop as b','a.shop_id','b.id_shop')
                 ->where('a.username',$request->username)
                 ->get();

        return $query;

    }


    public function allStockTake_records(Request $request){
        $query = DB::connection('mysql3')->table('sm_branchStockTake_history as a')
                 ->select('a.created_at','a.added','a.name as product_name','a.reference as ref','a.updated_quantity as added_quantity','a.username','b.name as shop_name')
                 ->where('a.shop_id',$request->shop_id)
                 ->join('c1ft_pos_prestashop.ps_shop as b','a.shop_id','b.id_shop')
                 ->get();

        return $query;
    }


    public function stockTake_final_results(Request $request){
        $query = DB::connection('mysql3')->table('sm_branchStockTake_history as a')
               ->select('a.name as product_name','a.reference as ref',DB::raw('sum(a.updated_quantity) as total_updated'))
               ->where('a.shop_id',$request->shop_id)
               ->join('c1ft_pos_prestashop.ps_shop as b','a.shop_id','b.id_shop')
               ->groupBy('a.reference')
               ->get();
        return $query;
    }




}
