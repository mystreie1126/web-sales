<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;

class searchRef extends Controller
{
    public function search(Request $request){
    	$this->validate($request,[
    		'reference'=>'required'
    	]);


    	$orders = DB::table('ps_orders as a')
    	->select('a.reference','a.id_customer','a.current_state','a.date_add','a.valid','a.id_customer',
    			'a.payment','b.firstname','b.lastname','b.email')
    	->join('ps_customer as b','a.id_customer','=','b.id_customer')
    	->where('a.reference','LIKE','%'.$request->reference.'%')
    	->get();

    	
    	//$orders = Order::where('reference','LIKE','%'.$request->reference.'%')->get();
    	//return $orders;
    	return view('layouts.ref',compact('orders'));

    }
}
