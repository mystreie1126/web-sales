@extends('template')
@include('navtop')


@section('content')
{{-- 	
<a href='#modal1' class="btn collect-order_pay">Pay and Collect</a> --}} 

	{{--   <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Modal</a> --}}

  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Please Select a Payment method</h4>
    </div>
    <div class="modal-footer">
      <a class="modal-action modal-close waves-effect waves-green btn-flat green white-text payment-proceed pay_by_cash">Cash</a>
      <a class="modal-action modal-close waves-effect waves-green btn-flat indigo white-text payment-proceed pay_by_card">Card</a>
    </div>
  </div>



  <div id="modal2" class="modal">
    <div class="modal-content">
      <h4>Please Select a Payment method</h4>
    </div>
    <div class="modal-footer">
      <a class="modal-action modal-close waves-effect waves-green btn-flat green white-text payment-proceed collect_pay_by_cash">Cash</a>
      <a class="modal-action modal-close waves-effect waves-green btn-flat indigo white-text payment-proceed collect_pay_by_card">Card</a>
    </div>
  </div>



	<div class="row" id="order">
		 <div class="col s12">
			 <ul class="tabs">
				 <li class="tab col s3"><a class="active" href="#test1">Orders</a></li>
				 <li class="tab col s3"><a href="#test2" id="get-pickup-order">Reward</a></li>
				 <li class="tab col s3"><a href="#test3" id="get-order-history">Collect in Store</a></li>
				 <li class="tab col s3"><a href="#test4" id="memmmer">Register Members</a></li>
			 </ul>
		 </div>
		 <div id="test1" class="col s12">
			 <div class="row">
			 	<p class="col s10"><a class="btn" id="get-new-order">check new order</a></p>
			 </div>

			 <div class="new-order blue lighten-4">

				 <ul class="collapsible" data-collapsible="expandable" id="order-info">
					 
				</ul>


			 </div>
		 </div>


		 <div id="test2" class="col s12">
			 <div class="row valign-wrapper center">
				 <div class="col s8 input-field">
					 <input id="email-for-voucher" type="text" class="validate">
           			 <label for="email-for-voucher">Customer's Email</label>
				 </div>
				 <div class="col s4">
				 	<button class="btn  orange" id="search-reward-by-email">Search Voucher</button>
				 </div>

			 </div>

			 <div class="reward-results hide">
				<ul class="collection with-header collect-order">
					<li class="collection-header cyan-text rm-fullname flow-text">
						customer name
					</li>

					<li class="collection-item">
						<p class="customer-email flow-text cyan-text rm_customer_email">email</p>
						<p class="flow-text"><span class="rm-customer_rewards cyan-text">remain</span> &euro; total rewards Available</p>
						<button class="btn cyan hide rm_reward_active hide">Active</button>
						<button class="btn orange rm_check_reward hide">Finish Transaction</button>

						<input type="hidden" class='rm_customer_id' value='0'>
						<input type="hidden" class='rm_firstname' value='0'>
						<input type="hidden" class='rm_lastname' value='0'>
						<input type="hidden" class='rm_email' value='0'>
						<input type="hidden" class='rm_total_reward' value='0'>

						<input type="hidden" class='response_stored_id_reward' value='0'>
						<input type="hidden" class='response_pos_id_reward' value='0'>
						<input type="hidden" class='response_pos_id_customer' value='0'>
						<input type="hidden" class='response_pos_reward_credits' value='0'>
						<input type="hidden" class='response_customer_id' value='0'>

					</li>
				</ul>
			 </div>
			</div>




		 <div id="test3" class="col s12">
		 	<div class="row valign-wrapper center">
				 <div class="col s8 input-field">
					 <input id="input-id-ref" type="text" class="validate">
           			 <label for="input-id-ref">Order Reference</label>
				 </div>
				 <div class="col s4">
				 	<button class="btn  light-blue darken-2" id="search-order-by-reference">Search</button>
				 </div>
			 </div>
			
			 <div class="lol">
			 	<div class="row collect-order hide">
			        <div class="col s12">
			          <div class="card">
			            <div class="card-content">
			              <div class="card-title collect-order_basic_info">

			              	<span class="collect-order_ref indigo-text"></span>
			              	<span class="collect-order_date hide-on-med-and-down"></span>
			              	<span class="cyan-text"><span class="collect-order_amount"></span> &euro;</span>
			              	<span class="collect-order_state"></span>
			              	<span class="collect-payment_status"></span>

			              </div>
			              <div class="collect-order_customer_info">
							<div>
				        		<span class="collect-order_customer_name">customer name</span><br>
				        		<span class="collect-order_email">email</span>
				        	</div>	              
							<div class="collect-order_items">
								<div class="collect-order_items_detail">
								</div>
							</div>
			              </div>
			            </div>
			            <div class="card-action">
			              <button href='#modal2' class='modal-trigger btn collect-order_pay hide'>Pay and Collect</button>
			            </div>

			            <div>
			            	<input type="hidden" class="hide-id_order" value="0">
				       		<input type="hidden" class="hide-id_customer" value="0">
							@if(Auth::check())
								<input type="hidden" class="hide-shop_name" value="{{Auth::User()->name}}">
								<input type="hidden" class="hide-shop_id" value="{{Auth::User()->shop_id}}">
						 	@endif
						 	<input type="hidden" class="hide-device_order" value="0">
						 	<input type="hidden" class="hide-pay_by_card" value="0">
						 	<input type="hidden" class="hide-pay_by_cash" value="0">
			            </div>
			          </div>
			        </div>
			    </div>
			

		 </div>

		 <div id="test4" class="col s12">
		 	<div class="row valign-wrapper center">
				 <div class="col s8 input-field">
					 <input id="input-online_email" type="text" class="validate">
           			 <label for="input-online_email">Customer's Email</label>
				 </div>
				 <div class="col s4">
				 	<button class="btn purple white-text" id="search-online_price-by-email">Search</button>
				 </div>
			 </div>


			 <div class="yolo">
			 	
				 	<ul class="collection online-customer-transfer  with-header hide">
						<li class="collection-items">
							<p class="online-customer_email flow-text"></p>
							<p class="online-customer_fullname flow-text"></p>
							
							<p class="has_online_price flow-text"></p>
							
								<button class="btn transfer_customer_to_pos hide">Online Price</button>
							
							
							<br>
							<input type="hidden" value="0" class="online-customer_id-hide">
							<input type="hidden" value="0" class="online-customer_firstname-hide">
							<input type="hidden" value="0" class="online-customer_lastname-hide">
							<input type="hidden" value="0" class="online-customer_email-hide">			
							
						</li>
			
				    </ul>
				
			 </div>
		 </div>

	 </div>

	</div>

	<div>
		<button class="btn green center">Get Sales Today</button>
	

	<table class="striped total-sale">
        <thead>
          <tr>
              <th>Card</th>
              <th>Cash</th>
              <th>Total</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>Alvin</td>
            <td>Eclair</td>
            <td>$0.87</td>
          </tr>
		</tbody>
	</table>

	</div>
@endsection
