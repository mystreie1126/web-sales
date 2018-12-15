@extends('template')

@include('navtop')
@section('content')
	
	@if(count($orders) > 0)



	@foreach($orders as $order)
		<ul class="collection">
			<li class="collection-item">
				<p class="flow-text"><span class="Red-text">Reference: </span>{{$order->reference}}</p>
				<p class="flow-text"><span class="Red-text">Created at: </span>{{$order->date_add}}</p>
				<p class="flow-text"><span class="Red-text">Firstname: </span>{{$order->firstname}}</p>
				<p class="flow-text"><span class="Red-text">Lastname: </span>{{$order->lastname}}</p>
				<p class="flow-text"><span class="Red-text">Email:</span>{{$order->email}}</p>
				<p class="flow-text"><span class="Red-text">Order Status:</span>
					@if($order->current_state == 10)

					Not Paid
					
					@else 

					Paid

					@endif
			
			   </p>

			</li>
		</ul>
	
	@endforeach
	

	@else
		<p class="flow-text cyan-text center">No order and customer found!</p>
	@endif

	<a href="{{route('homepage')}}" class="btn waves-effect waves-light">Back to Order Page</a>
@endsection 