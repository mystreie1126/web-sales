<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\UpdateStockHistory as updateHistory;
use DB;

class stockController extends Controller
{   


    private function branchStockInfo($shop_id)
    {   

        $updateHistory = new updateHistory;
        $updateHistory->refresh();
        $updatedIDs = $updateHistory->where('shop_id',$shop_id)->pluck('pos_product_id');
        

        $query = DB::connection('mysql2')->table('ps_product_lang as detail')
        ->select('detail.name as name','ps_product.reference','detail.id_product as branch_product_id')
        ->join('ps_product','detail.id_product','ps_product.id_product')
        ->whereNotIn('name',['','test-product','test','CheeseBurger','RiceNoodle','Big Mac'])
        ->whereNotIn('detail.id_product',$updatedIDs)
        ->groupBy('detail.name')
        ->orderBy('ps_product.id_product','desc')
        ->get();

        return $query;

    }

    private function updateStockAndSaveRecord($id_product,$ref,$qty,$shop_id)
    {
        $query = DB::connection('mysql2')->table('ps_stock_available as stock')
        ->where('id_product',$id_product)
        ->where('id_shop',$shop_id)
        ->update(['quantity'=>$qty]);

        if($query){

            $updateHistory = new updateHistory;
            $updateHistory->pos_product_id = $id_product;
            $updateHistory->reference      = $ref;
            $updateHistory->quantity       = $qty;
            $updateHistory->shop_id        = $shop_id;
            $updateHistory->updated_at      = date('Y-m-d H:i:s');

            if($updateHistory->save()) return $updateHistory->id;

        }
    }

    public function deleteSavedRecord(Request $request)
    {
        $updateHistory = new updateHistory;
        $updateHistory::findOrFail($request->record_id)->delete();

        return redirect('updatedHistory');

    }


    public function branchStockList()
    {   
        if(Auth::check()){
            return SELF::branchStockInfo(Auth::User()->shop_id);    
        }         
    }



    public function updateStock(Request $request)
    {
        if(Auth::check()){
            $record_id = SELF::updateStockAndSaveRecord(
                $request->pos_productID,
                $request->reference,
                $request->updateQty,
                Auth::User()->shop_id
            );

            if($record_id)
            return response()->json(['record_id'=>$record_id,'ref'=>$request->reference,'name'=>$request->name]);
        } 
    }


    public function updatedRecord()
    {   
        if(Auth::check()){
           $data = updateHistory::where('shop_id', Auth::User()->shop_id)->get();
            return view('updatedHistory',compact('data'));

        };
    }


    public function preownStock()
    {
        if(Auth::check()){
         $stocks =    DB::table('ps_feature_product as a')->select('b.name')
            ->join('ps_product_lang as b','a.id_product','b.id_product')
            ->join('ps_product_shop as c','c.id_product','a.id_product')
            ->join('ps_category_product as d','d.id_product','a.id_product')
            ->join('ps_stock_available as e','e.id_product','a.id_product')
            ->where('c.id_shop',1)
            ->where('c.active',1)
            ->where('a.id_feature',2540)
            ->where('a.id_feature_value',Auth::User()->feature_value)
            ->whereBetween('d.id_category',[1459,1475])
            ->where([
                ['e.id_shop',0],
                ['e.id_shop_group',3],
                ['e.id_product_attribute',0],
                ['e.quantity','>=',1]
            ])
            ->groupBy('b.name')

            ->get();

            //Auth::User()->feature_value

            return view('preownStock',compact('stocks'));
        }
    }


}
