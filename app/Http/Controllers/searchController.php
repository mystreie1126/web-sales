<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Order;
class searchController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }



    public function searchbyref(Request $request){

    	$orders = DB::table('ps_orders as a')
    	->select('a.reference','a.id_customer','a.current_state','a.date_add','a.id_customer',
    			 'a.total_paid_tax_incl','a.date_add','a.id_order','b.firstname','b.lastname','b.email','p.id_store','s.name as storename'
    			 )
    	->join('ps_customer as b','a.id_customer','=','b.id_customer')
    	->join('ps_fspickupatstorecarrier as p','p.id_order','=','a.id_order')
    	->join('ps_store as s','s.id_store','=','p.id_store')
    	->where('a.reference','LIKE','%'.$request->input_reference.'%')
    	->get();


    	//$orders = Order::where('reference','LIKE','%'.$request->reference.'%')->get();
    	//return $orders;
    	return view('search_by_ref',compact('orders'));
    }
}
