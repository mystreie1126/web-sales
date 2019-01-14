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
}
