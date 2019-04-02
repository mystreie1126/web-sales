<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\Models\Online_customer;
use App\voucher_ie;
use App\rd_pickup_order;
use Illuminate\Support\Facades\Auth;
use App\Models\Confirm_payment;
use App\customer_contact;
use App\Category_product;
use App\stockinfo;


class OrderController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    private function IN_SHOP_NO_HQ($product_id){
      $check = in_array($product_id,Category_product::where('id_category',1507)->pluck('id_product')->toArray());
      return $check ? 1 : 0;
    }

    private function NO_MORE_STOCK($product_id){
      $check = in_array($product_id,stockinfo::pluck('ie_product_id')->toArray());

      return $check ? 1:0;
    }

    private function NO_MORE_STOCK_ID($product_id){
      return stockinfo::where('ie_product_id',$product_id)->value('pos_product_id');
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
            // ->where('a.date_add','>',date('Y-m-d'))
            ->orderBy('a.date_add','desc')

            ->get();

            $staff = DB::table('users')->select('name','shop_id')->where('shop_id',Auth::User()->shop_id)->get();
            $rockpos = Auth::User()->rockpos;
            return response()->json([ 'order' => $data,'staff'=>$staff,'rockpos'=>$rockpos]);
    	}


    }



    public function search_order_by_ref(Request $request){

        if(Auth::check()){

            $has_payment_method = 0;

            $the_order = new Order;
            $the_order->refresh();

            $order = $the_order->where('reference','like','%'.$request->ref.'%')->first();
            $product = $order->order_detail[0]->product_name;
            $d = $order->id_order;

            $payment = new Confirm_payment;
            $payment->refresh();

            $payment_method = $payment->where('order_id',$d)->where('device_order',0)->get();




            if($request->ref == '' || $order==null ||  ((count($order->order_detail) == 1) && (stripos($product, 'imei') !== false))){
                return response()->json(['has_order'=>0]);
            }else{
                $the_customer = new Online_customer;
                $the_customer->refresh();


                $contact = customer_contact::where('id_customer',$order->id_customer)
                           ->where('alias','My address')->first();
                $customer = $the_customer->findOrFail($order->id_customer);
                //$order_items = Order::find(9027)->order_detail;
                 return response()->json([
                     'order'=>$order,
                     'items'=>$order->order_detail,
                     'customer'=>$customer,
                      'has_order'=>1,
                      'payment_method'=>$payment_method,
                      'contact' => $contact

                    ]);
            }
        }
    }





    public function collect_in_store(Request $request){
      if(Auth::check()){

        $order_details = Order::find($request->online_order_id)->order_detail;

        for($i = 0; $i<count( $order_details); $i++){
          if(SELF::IN_SHOP_NO_HQ($order_details[$i]->product_id) == 0){


              if($order_details[$i]->product_attribute_id == 0){
                  DB::table('ps_stock_available')
                  ->where('id_product',$order_details[$i]->product_id)
                  ->where('id_product_attribute',0)
                  ->where('id_shop_group',3)
                  ->increment('quantity',$order_details[$i]->product_quantity);
              }else{
                   DB::table('ps_stock_available')
                  ->where('id_product',$order_details[$i]->product_id)
                  ->where('id_product_attribute',$order_details[$i]->product_attribute_id)
                  ->where('id_shop_group',3)
                  ->increment('quantity',$order_details[$i]->product_quantity);

                   DB::table('ps_stock_available')
                  ->where('id_product',$order_details[$i]->product_id)
                  ->where('id_product_attribute',0)
                  ->where('id_shop_group',3)
                  ->increment('quantity',$order_details[$i]->product_quantity);
              }
          }

          if(SELF::NO_MORE_STOCK($order_details[$i]->product_id) == 1){
            DB::connection('mysql2')->table('ps_stock_available')
            ->where('id_product',SELF::NO_MORE_STOCK_ID($order_details[$i]->product_id))
            ->where('id_shop',Auth::User()->shop_id)
            ->decrement('quantity',$order_details[$i]->product_quantity);
          }

        }



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
