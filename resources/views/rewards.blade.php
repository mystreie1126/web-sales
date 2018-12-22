@extends('template')

@include('navtop')
@section('content')



@if($voucher_orders[0]->current_state == 2 && $voucher_orders[0]->payment == 'Free order')

<form action="{{route('pickup')}}" method="POST">
	<p class="flow-text">{{$firstname}} {{$lastname}}</p>
	<ul class="collection">
		<li class="collection-header flow-text">Reward items:</li>
			@foreach($voucher_orders as $v)
				<li class="collection-item">
					<p>
						Product Name:<span class="indigo-text">{{$v->product_name}}</span>
						Reference: <span class="indigo-text">{{$v->product_reference}}</span>
						<input type="show" name="ref[]" value="{{$v->product_reference}}">
						Quantity: <span class="indigo-text">{{$v->product_quantity}}</span>
						<input type="show" name="qty[]" value="{{$v->product_quantity}}">			
					</p>
				</li>
			@endforeach
	</ul>
	<button class="btn indigo">Pick up in Store</button>
	{{csrf_field()}}
</form>
@elseif(count($vouchers) == 0)


<p>{{$firstname}} {{$lastname}} hasn't place any order with reward voucher</p>


@endif


	
























@endsection