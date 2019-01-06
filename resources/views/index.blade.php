@extends('template')
@include('navtop')


@section('content')

	<div class="row" id="order">
		 <div class="col s12">
			 <ul class="tabs">
				 <li class="tab col s4"><a class="active" href="#test1">Phone Orders</a></li>
				 <li class="tab col s4"><a href="#test2" id="get-pickup-order">Pick up In Store</a></li>
				 <li class="tab col s4"><a href="#test3" id="get-order-history">Order History</a></li>
			 </ul>
		 </div>
		 <div id="test1" class="col s12">
			 <div class="row">
			 		 <p class="col s10"><a class="btn" id="get-new-order">check new order</a></p>
			 </div>

			 <div class="new-order">

				 <ul class="collapsible" data-collapsible="accordion">
					<li>
						<div class="collapsible-header order-basic-info">
							<i class="material-icons">payment</i>
							<span class="order-ref">ASDQ2211ds</span>
							<span class="hide-on-med-and-down">{{date('Y-m-d')}}</span>
							<span class="total-amount">23123123 euro</span>

						</div>
						<div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
					</li>
				</ul>


			 </div>
		 </div>


		 <div id="test2" class="col s12">

			 test2
			 </div>

		 <div id="test3" class="col s12">Test 3</div>
	 </div>










<div id="check-order">
	<p class="bold">Have incoming orders? please press the button below to check.</p>
	<button id="check_order" class="white-text orange waves-effect waves-light btn-small">Check New Orders</button>

		<table class="bordered highlight" id="order-info">
		    <thead>
		        <tr>
							<th >Reference</th>
			        {{-- <th >Customer Name</th> --}}
			        <th >Email</th>
			        <th >Order Action</th>
							<th >Online Voucher</th>
							<th >Voucher Action</th>
		        </tr>
		    </thead>

		    <tbody id="new-order">
		      {{-- <tr>
		      	<form action="">
		      		<td>Alvin</td>
			        <td>Eclair</td>
			        <td>$0.87</td>
			        <td class="center"><button id="confirm-payment" class="btn green bold white-text waves-effect waves-light">Confirm Payment</button></td>
		      	</form>
		      </tr> --}}
		    </tbody>
		</table>
</div>

<div class="row" id="voucher">
	 <div class="col s12">
		 <ul class="tabs">
			 <li class="tab col s4"><a class="active" href="#test1">Remaining Voucher</a></li>
			 <li class="tab col s4"><a href="#test2">Pull the Voucher</a></li>
			 <li class="tab col s4"><a href="#test3">RockPos Customer</a></li>
		 </ul>
	 </div>
	 <div id="test1" class="col s12">
		 <ul class="collection">
		    <li class="collection-item voucher-management">
					<button class="btn-small white-text green" id="check-remaining-voucher">Check Remaining Voucher</button>


		    </li>
		</ul>

	 </div>

@if(Auth::user()->rockpos == 1)
	 <div id="test2" class="col s12 voucher-management">
		 <div class="input-field">
			 <input id="customer_email" type="email" class="pullvoucher_email" name="mail" required>
			 <label for="customer_email">Search the voucher by Customer's Email</label>
			 <button class="btn" id="pull-with-email">Search</button>
		 </div>
		 <ul class="collection">
      <li class="collection-item voucher-result">
				<span>email adresssssss</span>
				<span>nammmmmmme</span>

				<button class='btn'>aa</button>
			</li>

    </ul>



	 </div>





	 <div id="test3" class="col s12">Test 4</div>
 </div>
@endif
@endsection
