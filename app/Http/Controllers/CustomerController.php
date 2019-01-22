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
use App\Models\Online_customer;
use App\Models\Online_reward;
use App\Models\POS_reward;
use DB;

class CustomerController extends Controller
{
    public function search_reward_by_email(Request $request){

    	if(Auth::check()){
    		$the_customer = new Online_customer;
    		$the_customer->refresh();
            
            $reward_amount = [];
            $voucher_amount = [];
            $cus = $the_customer->with(['reward','voucher'])->where('email','like','%'.$request->email.'%')->first();

            $reward = $cus->reward; 
            $voucher = $cus->voucher;

            if($reward->count() > 0){
                foreach($reward as $r){
                    if($r->id_reward_state == 2 && $r->credits > 0){
                        array_push($reward_amount,$r->credits);
                    }
                }
            }

            if($voucher->count() > 0){
                 foreach($voucher as $v){
                    if($v->quantity == 1 && $v->reduction_amount > 0){
                        array_push($voucher_amount,$v->credits);
                    }
                }
            }



            if($cus){
                return response()->json([

                        'customer'=>$cus,
                        'reward_total'=>$reward_amount,
                        'voucher_total'=>$voucher_amount,
                        
                    ]);
            }

            
    	
    	
    }

}

   

    public function transfer_customer_check(Request $request){
    	if(Auth::check()){
    		$the_customer = new Online_customer;
    		$the_customer->refresh();

    		

    		$online_customer = $the_customer->where('email','like','%'.$request->email.'%')->first();

    		if($request->email == '' || $online_customer == null){
     			return response()->json(['valid_customer' => 0]);
     		}else if($online_customer){
     			$customer_in_pos = Shared_customer::where('ie_customerid',$online_customer->id_customer)->count();
     			return response()->json(['customer'=>$online_customer,
     				                     'valid_customer' => 1,
     				                     'share_customer' => $customer_in_pos
     				                    ]);
     		}
     		
    	}

    }



    public function get_member(Request $request){
    	if(Auth::check()){
    		$the_pos_customer = POS_customer::find(2885);
	        $customer_template = $the_pos_customer->replicate();

	        if($customer_template->save()){
	        	 $pos_customer = POS_customer::findOrFail($customer_template->id_customer);

	        	 $pos_customer->firstname = $request->firstname;
		         $pos_customer->lastname = $request->lastname;
		         $pos_customer->email = $request->email;
		         if($pos_customer->save()){
		         	 $share_customer = new Shared_customer;
	                 $share_customer->ie_customerid = $request->online_customer_id;
	                 $share_customer->pos_customerid = $pos_customer->id_customer;
	                 $share_customer->created_at = $request->date;
	                 $share_customer->save();

	                 return response()->json($pos_customer);
		         }
	        }


    	}
    }

    public function get_total_today(Request $request){
    	if(Auth::check()){
    		$money = new Confirm_payment;
    		$money->refresh();

            if($request->today == 1 && $request->alltime == 0){
               $total = $money->where('rockpos_shop_id',$request->shop_id)->where('created_at','>',date('Y-m-d'))->where('device_order',0)->sum('paid_amount');
                $cash = $money->where('rockpos_shop_id',$request->shop_id)->where('created_at','>',date('Y-m-d'))->where('device_order',0)->where('cash',1)->sum('paid_amount');
                $card = $money->where('rockpos_shop_id',$request->shop_id)->where('created_at','>',date('Y-m-d'))->where('device_order',0)->where('card',1)->sum('paid_amount');
                
               
            }else if($request->today == 0 && $request->alltime == 1){
                $total = $money->where('rockpos_shop_id',$request->shop_id)->where('device_order',0)->sum('paid_amount');
                $cash = $money->where('rockpos_shop_id',$request->shop_id)->where('device_order',0)->where('cash',1)->sum('paid_amount');
                $card = $money->where('rockpos_shop_id',$request->shop_id)->where('device_order',0)->where('card',1)->sum('paid_amount');
                
                

            }

            
             return response()->json(['total'=>$total,'cash'=>$cash,'card'=>$card]);
    		

    	}
    }





}