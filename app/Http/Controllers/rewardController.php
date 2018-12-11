<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class rewardController extends Controller
{
    public function rewardOnline(Request $request){

    	DB::table('ps_rewards')->where('id_order',$request->id_order)
    	->update(['id_reward_state'=>2]);

    	DB::table('ps_orders')->where('id_order',$request->id_order)
    	->update(['current_state'=>2]);

    	return redirect()->route('order.index');

    }

    public function rewardPos(Request $request){
    	return 22;
    }
}
