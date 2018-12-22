@extends('template')
@include('navtop')
{{-- @include('layouts.searchnav') --}}

@section('content')



@foreach($data as $d)

<ul class="collapsible" data-collapsible="accordion">
    <li>

      <div class="collapsible-header order-detail-container">
			<div class="indigo-text order-intro">			
				<i class="material-icons">payment</i>
				<div class="order_and_name">
					<span class="flow-text">{{$d->reference}}</span> 
					<span>{{$d->firstname}} {{$d->lastname}}</span>
				</div>						
			</div>
		
			<p>{{$d->date_add}}</p>
			<div>
				@if($d->id_reward_state == 1)
					<span class="indigo-text flow-text">Awaiting Confirmation</span>
				@elseif($d->id_reward_state == 2)
					<span class="orange-text flow-text">Reward Activated</span>
				@endif
			</div>
  	  </div>
      <div class="collapsible-body ">
		
      	<p>{{$d->product_name}}</p>
      	<p>{{$d->firstname}} {{$d->lastname}}</p>
      	<p>{{$d->email}}</p>
		
		{{-- check if the reward is ready to use --}}
		
			<blockquote>{{$d->firstname}} {{$d->lastname}} has
    		<span class="indigo-text">{{$d->credits}} euro</span> 
				@if($d->id_reward_state == 1)
    				rewards in the account ready to use
    			@endif
	    	</blockquote> 
		

    	{{-- 1.Generated the voucher
    		 2.pull off from website
    		 3.post the amount paid
    		 4.track the voucher order

         --}}

    	@if($d->id_reward_state == 1)
	    	<form action="{{route('get_voucher')}}" method="POST">
	    		<input type="hidden" value="{{Auth::User()->name}}" name="shop_name">
				<input type="hidden" value="{{$d->total_paid_tax_incl}}" name="paid">
	    		<input type="hidden" value="{{$d->date_add}}" name="phone_order_date">
	    		<input type="hidden" value="{{$d->id_customer}}" name="id_customer">
	    		<input type="hidden" value="{{$d->product_id}}" name="product_id">
	    		{{-- <input type="hidden" value="{{$d->firstname}}" name="firstname">
	    		<input type="hidden" value="{{$d->lastname}}" name="lastname">
	    		<input type="hidden" value="{{$d->email}}" name="email"> --}}
	    		@if($d->id_reward_state == 1)
	    			<input type="submit" class="btn orange flow-text" value="Confirm Payment">
	    		@endif
	    		{{csrf_field()}}
	    	</form>
		@endif


	  
    {{-- 	@elseif($d->id_reward_state == 1 && Auth::User()->user_type == 2)
    		<div class="make_reward">
    			<blockquote>{{$d->firstname}} {{$d->lastname}} has <span class="indigo-text">{{$d->credits}} euro</span> 		avaiable in the account
    			</blockquote>

    			<form action="{{route('online_reward')}}" method="POST">
    				<input type="hidden" value="{{$d->id_order}}" name="id_order">
    				<button class="btn indigo white-text">
    					Active the Reward
    				</button>
    				{{csrf_field()}}
    			</form>
    		</div>
    		
    	@endif --}}
	</div>	
	
    </li>
  </ul>
        
		

	@endforeach

	

@endsection