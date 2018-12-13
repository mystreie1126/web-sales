<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\Customer_ie;
use Illuminate\Support\Facades\Auth;

class orderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->user_type == 3){
            $data = DB::table('ps_orders as a')
                ->select('a.id_order','a.reference','a.id_customer','a.date_add','b.product_name','b.product_reference','b.total_price_tax_incl','b.product_id')
                ->join('ps_order_detail as b','a.id_order','=','b.id_order')
                ->where('a.current_state',10)->where('date_add','>',date('Y-m-d'))
                ->get();

        
            return view('index',compact('data'));

        }else if(Auth::user()->user_type == 2){
             $data = DB::table('ps_orders as a')
                ->select('a.id_order','a.reference','a.id_customer','a.date_add','b.product_name','b.product_reference','b.total_price_tax_incl','b.product_id')
                ->join('ps_order_detail as b','a.id_order','=','b.id_order')
                ->join('ps_feature_product as c','c.id_product','=','b.product_id')
                ->where('c.id_feature',Auth::user()->feature_id)
                ->where('c.id_feature_value',Auth::user()->feature_value)
                ->where('a.current_state',10)->where('date_add','>',date('Y-m-d'))
                ->get();

        
            return view('index',compact('data'));
        }
        

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'id_order' => "required|integer",
            'id_customer'=>"required|integer",
            'product_id'=>"required|integer",
            'order_reference'=>"required",
            'product_name'=>"required"
        ]);

        //pull off the phone from website
        DB::table('ps_product_shop')->where('id_product',$request->product_id)->where('id_shop',1)
            ->update(['active'=>0]);

        $credits = DB::table('ps_rewards')->where('ps_rewards.id_order',$request->id_order)->sum('credits');
        $customer_details = DB::table('ps_customer')->select('firstname','lastname','email')
                            ->where('id_customer',$request->id_customer)->get();


        return view('rewards',compact('customer_details'))
               ->with('credits',$credits)
               ->with('reference',$request->order_reference)
               ->with('product_name',$request->product_name)
               ->with('id_order',$request->id_order)
               ->with('id_customer',$request->id_customer);
    }
}
