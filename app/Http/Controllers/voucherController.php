<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Phone_order_payment;
class voucherController extends Controller
{

	public function __construct()
	    {
	        $this->middleware('auth');
	    }



    public function index(Request $request){
    	
  	

    	//return $data;

    	if(Auth::check()){



    	$voucher_orders = DB::table('ps_cart_rule as a')
				        ->select('a.id_cart_rule','a.id_customer','a.date_add','b.id_order','b.value','a.quantity','c.product_name','c.product_quantity','c.product_reference','d.current_state','d.payment')
				        ->join('ps_order_cart_rule as b','a.id_cart_rule','=','b.id_cart_rule')
				        ->join('ps_order_detail as c','b.id_order','=','c.id_order')
				        ->join('ps_orders as d','d.id_order','=','b.id_order')
				        ->where('a.id_customer',$request->id_customer)
				        ->where('a.date_add','>',$request->phone_order_date)
				        ->get();


    	$vouchers = DB::table('ps_cart_rule as a')
    		        ->select('a.reduction_amount','a.code','a.quantity','a.date_add')
    		        ->where('a.id_customer',$request->id_customer)
    		        ->where('a.date_add','>',$request->phone_order_date)
    		        ->get();

    	//return $voucher_orders;
    	return view('rewards',compact('voucher_orders','vouchers'))

    				->with('firstname',$request->firstname)
    				->with('lastname',$request->lastname)
    				->with('email',$request->email);
    			   
    	}

    
    }


    public function get_voucher(Request $request){

        $paid_order = new Phone_order_payment;

        $paid_order->paid_amount = $request->total_paid_tax_incl;
        $paid_order->order_id = 


        DB::table('ps_rewards')->where('id_order',$request->id_order)
            ->update(['id_reward_state'=>4]);
        return redirect()->route('homepage');

    }















}
