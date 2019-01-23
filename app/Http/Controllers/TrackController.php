<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class TrackController extends Controller
{
    public function rollback(){
    	if(Auth::check()){


    		return view('rollback');
    	}

    	
    }


    public function search_track_ref(Request $request){
    	if(Auth::check()){
    		$rollback = DB::connection('mysql3')->table('issues as a')
    				->select('a.barcode','a.id','a.user_id',
    					'a.price','a.updated_at','a.status_id',
    					'b.username','c.status')
    				->join('users as b','a.user_id','=','b.id')
    				->join('issue_statuses as c','c.id','=','a.status_id')
    		        ->where('a.barcode','like','%'.$request->ref.'%')->first();

    		// $part = DB::connection('mysql3')->table('parts_usage_record')
    		// 		->select()

    		return response()->json($result);
    	}
    }
}
