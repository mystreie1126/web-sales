<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class preOwnController extends Controller
{	

	private function rockposDeviceStock($category_id){
		 $stocks = DB::table('c1ft_pos_prestashop.ps_product_shop as a')
	           			 ->join('c1ft_pos_prestashop.ps_category_product as b','a.id_product','b.id_product')
	           			 ->join('c1ft_pos_prestashop.ps_product_lang as c','c.id_product','a.id_product')
	           			 ->join('c1ft_pos_prestashop.ps_product as d','d.id_product','a.id_product')
	           			 ->join('c1ft_pos_prestashop.ps_stock_available as e','e.id_product','a.id_product')
	           			 ->join('c1ft_pos_prestashop.ps_shop as f','f.id_shop','a.id_shop')
	           			 ->select('c.name','d.reference as imei','f.name as shopname','a.id_product')
	           			
	           			 ->where('b.id_category',$category_id)
	           			 ->where('e.quantity',1)
	           			 ->where('a.active',1)
	           			 ->groupBy('d.reference')
	           			 ->orderBy('a.id_shop')
	           			 ->get();
	    return $stocks;
	}
     public function preownStock(){
        if(Auth::check()){
	         // $stocks =  DB::table('ps_feature_product as a')->select('b.name','a.id_product')
	         //    ->join('ps_product_lang as b','a.id_product','b.id_product')
	         //    ->join('ps_product_shop as c','c.id_product','a.id_product')
	         //    ->join('ps_category_product as d','d.id_product','a.id_product')
	         //    ->join('ps_stock_available as e','e.id_product','a.id_product')
	         //    ->where('c.id_shop',1)
	         //    ->where('c.active',1)
	         //    ->where('a.id_feature',2540)
	         //    ->where('a.id_feature_value',Auth::User()->feature_value)
	         //    ->whereBetween('d.id_category',[1459,1475])
	         //    ->where([
	         //        ['e.id_shop',0],
	         //        ['e.id_shop_group',3],
	         //        ['e.id_product_attribute',0],
	         //        ['e.quantity','>=',1]
	         //    ])
	         //   ->groupBy('a.id_product')
	         //   ->get();


	           // $preown_stocks = DB::table('c1ft_pos_prestashop.ps_product_shop as a')
	           // 			 ->join('c1ft_pos_prestashop.ps_category_product as b','a.id_product','b.id_product')
	           // 			 ->join('c1ft_pos_prestashop.ps_product_lang as c','c.id_product','a.id_product')
	           // 			 ->join('c1ft_pos_prestashop.ps_product as d','d.id_product','a.id_product')
	           // 			 ->join('c1ft_pos_prestashop.ps_stock_available as e','e.id_product','a.id_product')
	           // 			 ->select('c.name','d.reference as imei')
	           // 			 ->where('a.id_shop',Auth::User()->shop_id)
	           // 			 ->where('c.id_shop',Auth::User()->shop_id)
	           // 			 ->where('b.id_category',16)
	           // 			 ->where('e.quantity',1)
	           // 			 ->where('a.active',1)
	           // 			 ->get();

	           // return $preown;

        	$preown_stocks = self::rockposDeviceStock(16);
        	$brandnew_stocks = self::rockposDeviceStock(17);

	            return view('preownStock',compact('preown_stocks','brandnew_stocks'));

        }
    }
}
