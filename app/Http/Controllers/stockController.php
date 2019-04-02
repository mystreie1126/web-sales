<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\stockinfo;
use App\stockUpdate;
use Illuminate\Support\Facades\Auth;
class stockController extends Controller
{

    public function __construct(){
       $this->middleware('auth');
    }

    private function stockInfo($arr){
        $query = DB::table('sm_stockNeedToCount as a')
        ->select('a.ie_product_id','a.pos_product_id','b.reference','c.name','a.id')
        ->join('ps_product as b','a.ie_product_id','b.id_product')
        ->join('ps_product_lang as c','c.id_product','a.ie_product_id')
        ->groupBy('c.name')
        ->where('a.checked',0)
        ->whereIn('a.id',$arr)
        ->orderBy('c.name')
        ->get();

        return $query;

    }

    private function sum_pos_stock($id){
      $sum = DB::connection('mysql2')->table('ps_stock_available')
      ->whereNotIn('id_shop',[1,35,41,42])
      ->where('id_product',$id)
      ->sum('quantity');

      return $sum;

    }

    public function index(){
      if(Auth::check()){

         $stock_id = [];
         $query = stockinfo::with('stockShop')->get();

         for($i = 0; $i < count($query); $i++){
            if(!in_array(Auth::user()->shop_id,(array)$query[$i]->stockShop->pluck('update_shop_id')->toArray())){
              array_push($stock_id,$query[$i]->id);
            }
         }

         return response()->json(['stock'=>self::stockInfo($stock_id),'shop_id'=>Auth::User()->shop_id]);
       }
    }

    public function update(Request $request){
      if(Auth::check()){

        $query = DB::connection('mysql2')->table('ps_stock_available')
        ->where('id_product',$request->pos_product_id)
        ->where('id_shop',Auth::User()->shop_id)
        ->update(['quantity'=>$request->qty]);

        if($query){
          $stockUpdate = new stockUpdate;
          $stockUpdate->needToCount_id = $request->stock_id;
          $stockUpdate->update_shop_id =Auth::User()->shop_id;
          $stockUpdate->save();
        }
        return response()->json('success updated the quantity');
      }
    }

    public function sync(){
        if(Auth::check()){
          $stockinfo = stockinfo::where('checked',0)->get();

          for($i = 0; $i < count($stockinfo); $i++){
            DB::table('ps_stock_available')->where('id_product',$stockinfo[$i]->ie_product_id)
            ->where('id_shop_group',3)->where('id_shop',0)
            ->update(['quantity'=>self::sum_pos_stock($stockinfo[$i]->pos_product_id)]);
          }
          return  response()->json('success sync the stock');
      }

    }






}
