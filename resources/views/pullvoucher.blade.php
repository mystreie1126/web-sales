@extends('template')


@section('content')

<div class="input-field">
   <form action="{{route('pull_voucher')}}" class="search-by-email" method="POST" id="ajax_post">
   		<div>
   			<input id="customer_email" type="email" class="validate" name="email" required>
 			<label for="customer_email">Search the voucher info by typing the Customer's Email Address</label>
   		</div>
		<button class="cyan btn" id="ajaxSubmit">Search</button>
		{{csrf_field()}}
   </form>


</div>
{{-- <button id="ajaxSubmit" class="btn orange">submit</button>> --}}

@endsection

