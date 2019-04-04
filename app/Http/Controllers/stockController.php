<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class stockController extends Controller
{   

    private function branchStockInfo()
    {
        $query = DB::connection('mysql2')->table('ps_product_lang as detail')
            ->select('detail.name as name','ps_product.reference','detail.id_product as branch_product_id')
            ->join('ps_product','detail.id_product','ps_product.id_product')
            ->whereNotIn('name',['','test-product','test','CheeseBurger','RiceNoodle','Big Mac'])
            ->groupBy('detail.name')
            ->orderBy('ps_product.id_product','desc')
            ->get();

        return $query;

    }

    private function updateStock($id_product,$qty,$shop_id)
    {
        $query = DB::connection('mysql2')->table('ps_stock_available as stock')
        ->where('id_product',$d)
        ->where('id_shop',$shop_id)
        ->update(['quantity'=>$qty]);

        return $query;
    }

    // private function findInStock($id_product,$shop_id)
    // {
    //     $query = 
    // }

    // public function __construct()
    // {
    //    $this->middleware('auth');
    // }

    public function branchStockList()
    {   
        
        return SELF::branchStockInfo();
         
    }






}
