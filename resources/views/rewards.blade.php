@extends('template')


@section('content')

<form action="/rewardOnline" method="post">
	@foreach($customer_details as $detail)
		<ul class="collection">
			<li class="collection-item">
				<p class="flow-text"><span class="cyan-text">Customer firstname: </span>{{$detail->firstname}}</p>
				<p class="flow-text"><span class="cyan-text">Customer lastname: </span>{{$detail->lastname}}</p>
				<p class="flow-text"><span class="cyan-text">Customer Email: </span>{{$detail->email}}</p>
				<p class="flow-text"><span class="cyan-text">Order Reference: </span>{{$reference}}</p>
				<p class="flow-text"><span class="cyan-text">Product: </span>{{$product_name}}</p>
				<p class="flow-text"><span class="cyan-text">Has Rewards: </span>{{$credits}} euro</p>
				<input type="hidden" value="{{$id_order}}" name="id_order">
			</li>
		</ul>
		<div class="button-rewards">
			<input type="submit" value="Generate rewards on Website" class="btn waves-effect waves-light">
			<input type="submit" value="Generate rewards on Rockpos" class="btn waves-effect red" formaction="/rewardPos">
		</div>

		{{csrf_field()}}
	@endforeach


</form>

@endsection