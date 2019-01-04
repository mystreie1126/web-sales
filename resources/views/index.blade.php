@extends('template')
@include('navtop')
{{-- @include('layouts.searchnav') --}}

@section('content')

<div id="check-order">
	<p class="bold">Have incoming orders? please press the button below to check.</p>
	<button id="check_order" class="white-text orange waves-effect waves-light btn-small">Check New Orders</button>

		<table class="bordered highlight" id="order-info">
		    <thead>
		        <tr>
					<th class="center">Reference</th>
			        <th class="center">Customer Name</th>
			        <th class="center">Customer Email</th>
			        <th class="center">Order Action</th>


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
			 <li class="tab col s4"><a class="active" href="#test1">Test 1</a></li>
			 <li class="tab col s4"><a href="#test2">Test 2</a></li>
			 <li class="tab col s4"><a href="#test4">Test 4</a></li>
		 </ul>
	 </div>
	 <div id="test1" class="col s12">Test 1</div>
	 <div id="test2" class="col s12">Test 2</div>
	 <div id="test4" class="col s12">Test 4</div>
 </div>

@endsection
