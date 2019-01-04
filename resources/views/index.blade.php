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
					<th>Reference</th>
			        <th>Customer Name</th>
			        <th>Customer Email</th>  
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

<div id="voucher">
	<table class="bordered highlight">
		<thead>
			<tr>
				<th>Reference</th>
			    <th>Customer Name</th>
			</tr>
		</thead>

		<tbody id="new-voucher">
			
		</tbody>
	</table>
	
</div>

@endsection