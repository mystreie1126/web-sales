@extends('template')

{{-- @include('layouts.searchnav') --}}

@section('content')


@foreach($orders as $order)
	
	<ul class="collection">
		
		<li class="collection-item">
	
			<p class="flow-text">
				<span class="cyan-text">Reference:</span>
				{{$order->reference}}
			</p>
			
			<p class="flow-text">
				<span class="cyan-text">Date Create:</span>
				{{$order->date_add}}
			</p>
			
			<p class="flow-text">
				<span class="cyan-text">Customer Name:</span>
				{{$order->firstname}} {{$order->lastname}}
			</p>

			<p class="flow-text">
				<span class="cyan-text">Email:</span>
				{{$order->email}}
			</p>

			<p class="flow-text">
				<span class="cyan-text">Date Create:</span>
				{{$order->date_add}}
			</p>

			<p class="flow-text">
				<span class="cyan-text">Order Amount:</span>
				{{$order->total_paid_tax_incl}}
			</p>

			<p class="flow-text">
				<span class="cyan-text">Pick up location:</span>
				{{$order->storename}}
			</p>

			@if($order->current_state !== 4 && Auth::user()->rockpos == 0)
				<form action="{{route('pickupInstore')}}">
					<input type="hidden" value="{{$order->id_customer}} name="id_customer_ie">
					<input type="hidden" value="{{$order->id_order}} name="id_order">
					<input type="submit" value="Pick Up In my Store" class="btn">
					{{csrf_field()}}
				</form>
			@endif
		</li>
	
	</ul>
@endforeach

	

@endsection