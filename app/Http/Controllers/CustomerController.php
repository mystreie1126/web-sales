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

    		$customer = $the_customer->where('email','like','%'.$request->email.'%')->first();

    		if($request->email == '' || $customer == null){
    			return response()->json(['a'=>$request->email,'valid_customer' => 0]);
    			
    		}else if($customer){
    			$reward = $customer->reward->where('id_reward_state',2)->where('plugin','loyalty');
    			$reward_total = $reward->sum('credits');
    			
    			if($reward->count() > 0){
    				return response()->json(['reward'=>$reward,'customer'=>$customer,'reward_total'=>$reward_total,'valid_customer'=>1]);
    			}else if($reward->count() == 0){
    				return response()->json(['customer'=>$customer,'valid_customer'=>1,'reward_total'=> 0]);
    			}
    			
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





}
