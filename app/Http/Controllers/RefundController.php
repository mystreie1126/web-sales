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

class RefundController extends Controller
{
    public function check_order_refund(Request $request){
    	$result = DB::table('ps_orders as a')
    	        ->select('a.id_order','a.reference','b.firstname','b.lastname','b.email')
    	        ->join('ps_customer as b','a.id_customer','b.id_customer')
    	        ->where('a.reference','like','%'.$request->ref.'%')
    	        ->where('a.current_state','!=',7)
    	        ->first();
    	return response()->json($result);
    }

    public function go_refund(Request $request){
    	DB::table('ps_orders')->where('id_order',$request->id)->update(['current_state'=>7]);
    	return response()->json(['updated'=>1]);
    }

}
