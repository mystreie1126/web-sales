<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Confirm_payment;
use App\Models\Shared_customer;
use App\Models\Online_voucher;
use App\Models\POS_voucher;
use App\Models\POS_voucher_name;
use App\Models\POS_customer;
// use App\pos_reward;
// use App\pos_cart_voucher;
//
// use App\pos_voucher_name;
use DB;
class voucherController extends Controller
{

	public function __construct()
	    {
	        $this->middleware('auth');
	    }


	public function createPosVoucher(Request $request)
	{

	    if(Auth::check()){
	        $paid_order = new Confirm_payment;

	        $paid_order->paid_amount     = $request->total_paid;
	        $paid_order->order_id        = $request->order_id;
	        $paid_order->product_id      = $request->product_id;
	        $paid_order->shop_name       = $request->shopname;
	        $paid_order->rockpos_shop_id = $request->shop_id;
	        $paid_order->device_order    = $request->device;
	        $paid_order->created_at      = $request->current_date;

	        $paid_order->save();

					//check if customer exisit in rockpos
						if( Shared_customer::where('ie_customerid','=',$request->id_customer)->count()==0)
						{
							$customer = POS_customer::find(2799);
	            $customer_template = $customer->replicate();


	            if($customer_template->save())
							{
	                $new_customer = POS_customer::findOrFail($customer_template->id_customer);

	                $new_customer->firstname = $request->firstname;
	                $new_customer->lastname = $request->lastname;
	                $new_customer->email = $request->email;
	                if($new_customer->save())
									{
	                    $share_customer = new Shared_customer;
	                    $share_customer->ie_customerid = $request->id_customer;
	                    $share_customer->pos_customerid = $new_customer->id_customer;
	                    $share_customer->created_at = date("Y-m-d H:i:s");
	                    $share_customer->save();
	                }
	             }
						}

						$voucher = Online_voucher::find(3011);
						$voucher_template = $voucher->replicate();

						if($voucher_template->save()){
								$voucher_new = $voucher_template::findOrFail($voucher_template->id_cart_rule);
								$voucher_new->id_customer = $request->id_customer;
								$voucher_new->code = $request->shop_id.'-'.$request->reference;
								$voucher_new->reduction_amount = $request->credits;
								$voucher_new->date_add = $request->current_date;
								$voucher_new->date_upd = $request->current_date;
								$voucher_new->quantity = 1;

								if($voucher_new->save()){
										DB::table('ps_cart_rule_lang')->insert([
												'id_cart_rule' => $voucher_new->id_cart_rule,
												'id_lang'      => 1,
												'name'         => '10% Online Credit Back'
										]);

										// DB::table('ps_orders')->where('id_order',$request->order_id)
										// 				->update(['current_state'=>2]);
										// DB::table('ps_product_shop')->where('id_product',$request->product_id)
										// 				->where('id_shop',1)	->update(['active'=>0]);


										return response()->json(
											['credits' => $request->credits,
											 'rockpos' => Auth::user()->rockpos,
										 	 'product' => $request->product_name,
											 'id_customer' => $request->id_customer,
											 'reference'=>$request->reference
										 ]

										);
								}
						}

	    }


	}

	public function send_voucher_to_rockpos(Request $request)
	{
		if(Auth::check()){
			$pos_customer_id = Shared_customer::where('ie_customerid',$request->id_customer)->value('pos_customerid');

			$sum_credits_online = Online_voucher::where('id_customer',$request->id_customer)
                      ->where('quantity',1)
                      ->where('description','10% Online Credit Back')
                      ->sum('reduction_amount');


			if($sum_credits_online > 0 ){
         $destory_voucher = Online_voucher::where('id_customer',$request->id_customer)
         ->where('quantity',1)->where('description','10% Online Credit Back')->delete();
				 $posVoucher_template = POS_voucher::findOrFail(656);

         $posVoucher = $posVoucher_template->replicate();

         if($posVoucher->save()){
             $pos_new_voucher = $posVoucher::findOrFail($posVoucher->id_cart_rule);
             $pos_new_voucher->id_customer      = $pos_customer_id;
             $pos_new_voucher->quantity         = 1;
             $pos_new_voucher->code             = $request->reference.'*';
             $pos_new_voucher->reduction_amount = $sum_credits_online;

             if($pos_new_voucher->save()){

                 $pos_new_voucher_name = new POS_voucher_name;
                 $pos_new_voucher_name->id_cart_rule = $pos_new_voucher->id_cart_rule;
                 $pos_new_voucher_name->id_lang      = 1;
                 $pos_new_voucher_name->name         = 'Created_Online';
                 $pos_new_voucher_name->save();
             };


             return response()->json(['id'=>$pos_customer_id,'credits'=>$sum_credits_online,'valid_voucher'=>1]);
         }
       }else {
				 	return response()->json(['valid_voucher'=> 0]);
			 }




		}
	}


	public function pull_online_voucher_rockpos(Request $request)
	{
		if(stripos($request->email,"douglascourt@funtech.ie") !== false){
          return response()->json(['allowed_to_pull'=> 0]);
    }else{
			$vouchers =  DB::table('ps_cart_rule as a')
	                    ->select('a.id_customer',
	                     DB::raw('sum(a.reduction_amount) as credits'),'b.firstname','b.lastname','b.email')
	                    //->join('ps_customer as b','a.id_customer','=','b.id_customer')
	                    ->where('a.quantity',1)->where('a.description','10% Online Credit Back')
	                    ->groupBy('a.id_customer')
	                    ->join('ps_customer as b','a.id_customer','=','b.id_customer')
	                    ->where('b.email','LIKE','%'.$request->email.'%')
											->limit(5)
	                    ->get();

			return response()->json(['allowed_to_pull'=> 1,'voucher' => $vouchers]);
		}

	}








}
