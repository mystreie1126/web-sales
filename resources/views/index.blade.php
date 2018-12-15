@extends('template')
@include('navtop')
@include('layouts.searchnav')
@section('content')

	@foreach($data as $d)
		<form action="{{route('postOrder')}}" method="POST">
			<p class="flow-text"><span class="cyan-text">Reference:</span>{{$d->reference}}</p>
			<p class="flow-text"><span class="cyan-text">Date:</span>{{$d->date_add}}</p>
			<p class="flow-text"><span class="cyan-text">Product:</span>{{$d->product_name}}</p>
			<p class="flow-text"><span class="cyan-text">Shop:</span>{{$d->product_reference}}</p>
			<input type="hidden" value="{{$d->product_name}}" name="product_name">
			<input type="hidden" value="{{$d->reference}}" name="order_reference">
			<input type="hidden" value="{{$d->id_order}}" name="id_order">
			<input type="hidden" value="{{$d->id_customer}}" name="id_customer">
			<input type="hidden" value="{{$d->product_id}}" name="product_id">
			<input type="submit" class="btn waves-effect waves-light" value="Accept the Payment">
			{{csrf_field()}}
		</form>
	@endforeach



@endsection