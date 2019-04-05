@extends('template')
@include('navtop')
@section('content')

<p class="flow-text">Updated History:</p>
<table>
  <thead>
    <tr>
        <th>reference</th>
        <th>Updated Qty</th>
        <th>Restore</th>
    </tr>
  </thead>

    <tbody>
    	@foreach($data as $d)
			<tr>
				<th>{{$d->reference}}</th>
				<th>{{$d->quantity}}</th>
				<th>
					<form action='{{route('deleterecord')}}' method="POST">
						<input type="hidden" name="record_id" value="{{$d->id}}">
						<button class="btn">Restore</button>
						{{csrf_field()}}
					</form>
				</th>
			</tr> 
    	@endforeach
   </tbody>
</table>


@stop