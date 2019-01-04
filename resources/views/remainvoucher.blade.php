@extends('template')


@section('content')
	
@if($data->count() > 0)

@foreach($data as $d)
<ul class="collection">
    <li class="collection-item">
      <span class="title flow-text indigo-text">{{$d->email}}</span>
      <div class="remaining-voucher">
      	      
	      <p class="flow-text">Customer <span class="cyan-text"> {{$d->firstname}} {{$d->lastname}}</span> has total <span class="red-text"> {{$d->credits}} </span>in the <span class="red-text">RockPOS account</span></p>
	      <form action="{{route('sync_voucher')}}" method="POST">
	      	<input type="hidden" value="{{$d->id_customer}}" name="id_customer">
	      	<input type="hidden" value="{{$d->credits}}" name="credits">
	      	<button class="btn" onclick="return confirm('Please make sure you have refreshed the page after spending voucher on RockPos!')">Sync the remaining voucher</button>
	      	{{csrf_field()}}
	      </form>

      </div>
    </li>
</ul>

@endforeach


@else

<p class="flow-text cyan-text">No voucher available for this Customer in RockPos </p>


@endif








@endsection