<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class preOwnController extends Controller
{
     public function preownStock(){
        if(Auth::check()){
	         $stocks =  DB::table('ps_feature_product as a')->select('b.name','a.id_product')
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
	           ->groupBy('a.id_product')
	           ->get();

	            return view('preownStock',compact('stocks'));

        }
    }
}
