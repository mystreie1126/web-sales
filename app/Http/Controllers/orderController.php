<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\Customer_ie;
use App\voucher_ie;
use App\rd_pickup_order;
use Illuminate\Support\Facades\Auth;
use App\Models\Confirm_payment;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //show the coming order
    public function newOrder(){

    	if(Auth::check()){





    		$data = DB::table('ps_orders as a')
            ->select('a.id_order','a.reference','a.id_customer','a.date_add','b.product_name','b.product_reference','b.total_price_tax_incl','b.product_id','ps_rewards.id_reward_state','ps_rewards.credits',
                'cus.firstname','cus.lastname',
                'cus.email','a.current_state',
                'e.active','a.total_paid_tax_incl','ps_rewards.id_reward')
            ->join('ps_customer as cus','a.id_customer','cus.id_customer')
            ->join('ps_order_detail as b','a.id_order','=','b.id_order')
            ->join('ps_feature_product as c','c.id_product','=','b.product_id')
            ->join('ps_rewards','a.id_order','=','ps_rewards.id_order')
            ->join('ps_product_shop as e','b.product_id','=','e.id_product')
            ->where('e.id_shop',1)
            ->where('c.id_feature',Auth::user()->feature_id)
            ->where('c.id_feature_value',Auth::user()->feature_value)
            ->where('a.current_state',10)
            ->where('a.date_add','>',date('Y-m-d'))
            ->orderBy('a.date_add','desc')
            ->get();

            $staff = DB::table('users')->select('name','shop_id')->where('shop_id',Auth::User()->shop_id)->get();
            $rockpos = Auth::User()->rockpos;
            return response()->json([ 'order' => $data,'staff'=>$staff,'rockpos'=>$rockpos]);
    	}


    }



    public function search_order_by_ref(Request $request){

        if(Auth::check()){

            $the_order = new Order;
            $the_order->refresh();

            $order = $the_order->where('reference','like','%'.$request->ref.'%')->first();

            if($request->ref == '' || $order==null){
                return response()->json(['has_order'=>0]);
            }else{
                $the_customer = new Customer_ie;
                $the_customer->refresh();

                $customer = $the_customer->where('id_customer',$order->id_customer)->first();
                //$order_items = Order::find(9027)->order_detail;
                 return response()->json([
                     'order'=>$order,
                     'items'=>$order->order_detail,
                     'customer'=>$customer,
                      'has_order'=>1
                    ]);
            }
        } 
    }





    public function collect_in_store(Request $request){

        if(Auth::check()){
            $pick_up = new rd_pickup_order;
            $pick_up->ie_customer_id = $request->online_customer_id;
            $pick_up->ie_order_id = $request->online_order_id;
            $pick_up->pos_shop_id = $request->shop_id;
            $pick_up->created_at = $request->date;

            if($pick_up->save()){
                $collect = new Confirm_payment;
                $collect->paid_amount = $request->paid_amount;
                $collect->order_id = $request->online_order_id;
                $collect->product_id = 0;
                $collect->shop_name = $request->shop_name;
                $collect->rockpos_shop_id = $request->shop_id;
                $collect->device_order = $request->device_order;
                $collect->cash = $request->cash;
                $collect->card = $request->card;
                $collect->created_at = $request->date;
                if($collect->save()){

                    $order = new Order;
                    $order->refresh();

                    $order->where('id_order',$request->online_order_id)->update(['current_state'=>5]);
                  
                    return response()->json(['collected'=>1,'order'=>$order]);
                }


                

            }



        }



        
    }




}
