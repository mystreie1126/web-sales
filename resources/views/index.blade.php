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

	
@if(Auth::check())
	<div class="row" id="order">
		 <div class="col s12">
			 <ul class="tabs click_flag">
				 <li class="tab col s3"><a class="active" href="#test1">Pre-Owned Orders</a></li>
				 <li class="tab col s3"><a href="#test2" id="get-pickup-order">Remaining Reward</a></li>
				 <li class="tab col s3"><a href="#test3" id="get-order-history" data-clicked="no">Collect in Store</a></li>
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
					 <input id="email-for-voucher" type="email" class="validate">
           			 <label for="email-for-voucher">Type Customer Email</label>
				 </div>
				 <div class="col s4">
				 	<button class="btn  orange" id="search-reward-by-email">Search Reward</button>
				 </div>

			 </div>

			 <div class="customer-has-results">
				
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
				        		<hr>
				        	</div>	              
							<div class="collect-order_items">
								<div class="collect-order_items_detail">
								</div>
							</div>
			              </div>
			            </div>
			            <div class="card-action">
			              <button href='#modal2' class='modal-trigger btn collect-order_pay hide'>Pay and Collect</button>
			              <button href='#modal2' class='btn collect-order_no_pay hide'>Collect Only</button>
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
@endif

@if(Auth::check())

	<div id="refund" class="hide">
		<button id="refund-btn" class="btn red white-text">Refund an Order</button>
		<div class="row valign-wrapper center" id="refund-info">
			 <div class="col s8 input-field">
				 <input id="ref-for-refund" type="text" class="validate">
       			 <label for="ref-for-refund">Refund by Order reference</label>
			 </div>
			 <div class="col s4">
			 	<button class="btn  orange" id="search-refund-by-ref">Refund the Order</button>
			 </div>
			
		 </div>
		 <div class="refund-order-details row">
		 	
		 </div>
	</div>
	<div class="hide" id='lele'>
		 <input type="hidden" value="{{Auth::User()->shop_id}}" class="get_total_shop">
		<div class="sales-time-picker">
			 <div class="row">	 
			   	<div class="col s12">
			      	<div class="input-field input-date col s4">
			      		<input type="text" class="datepicker start-date" id="date" name="dateStart">
			      		<label for="date" class="green-text">Select the start date:</label>
			      	</div>

			      	<div class="input-field input-date col s4">
						<input type="text" class="timepicker start-time" id="time" name="timeStart">
						<label for="time" class="green-text">Select the start time:</label>
					</div>

				</div>

				<div class="col s12">
			      	<div class="input-field input-date col s4">
			      		<input type="text" class="datepicker end-date" id="date" name="dateEnd">
			      		<label for="date" class="indigo-text">Select the end date:</label>
			      	</div>

			      	<div class="input-field input-date col s4">
						<input type="text" class="timepicker end-time" id="time" name="timeStart">
						<label for="time" class="indigo-text">Select the end time:</label>
					</div>
					
					<div class="col s4">
						<button class="btn-large right cyan get_online_sales">Web Sales Record<i class="material-icons right">send</i></button>
					</div>
					
				</div>	      
			    
	  		</div>
        </div>
		
		<div class="websales-record-message flow-text"></div>
		<table class="striped total-sale ">

      	  <thead>
          <tr>
          	  <th>Order Ref</th>
          	  <th>Amount</th>
              <th>Card</th>
              <th>Cash</th>
              <th>Date</th>
          </tr>
        </thead>
		
        <tbody class='each-websales-record'>
          <tr>
          	<td>0</td>
          	<td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>           
         </tr>   
		</tbody>
		</table>
	   

	    

		
		
	</div>
	@endif
@endsection
