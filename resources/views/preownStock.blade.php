@extends('template')
@include('navtop')
@section('content')
@if(Auth::check())
	<input type="hidden" value="{{Auth::User()->feature_value}}">
@endif
<div class="container">
	@if(count($preown_stocks) > 0)	
		<p class="flow-text">Available Pre Own Devices in RockPos</p>
		<button class="btn indigo right" id="preown_export">Export</button>
		
		<table class="striped" id="preownStock_table">	
			<thead>
				<tr>
					<th>Device Name</th>
					<th>IMEI</th>
				</tr>
			</thead>
			<p class="flow-text">Total <span class="orange-text">{{count($preown_stocks)}}</span> devices</p>

			<tbody>
				@foreach($preown_stocks as $stock)
				<tr>
					<th>{{$stock->name}}</th>
					<th>{{$stock->imei}}</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<p class="flow-text">No Available Pre Own Devices in RockPos</p>
	@endif

	@if(count($brandnew_stocks) > 0)	
		<p class="flow-text">Available Brand New Devices in RockPos</p>
		<button class="btn amber right" id="brandnew_export">Export</button>
		
		<table class="striped" id="preownStock_table">	
			<thead>
				<tr>
					<th>Device Name</th>
					<th>IMEI</th>
				</tr>
			</thead>
			<p class="flow-text">Total <span class="orange-text">{{count($brandnew_stocks)}}</span> devices</p>

			<tbody>
				@foreach($brandnew_stocks as $stock)
				<tr>
					<th>{{$stock->name}}</th>
					<th>{{$stock->imei}}</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<p class="flow-text">No Available Brand New Devices in RockPos</p>
	@endif


	{{-- <p class="flow-text">New Phone Stock</p>
	<button class="btn indigo right" id="brandnew_export">Export</button>
	<table class="striped" id="brandNewStock_table">	
		<thead>
			<tr>
				<th>Device Name</th>
				<th>IMEI</th>
			</tr>
		</thead>
		<p class="flow-text">Total <span class="orange-text">{{count($stocks)}}</span> devices</p>

		<tbody>
			@foreach($stocks as $stock)
			<tr>
				<th>{{$stock->name}}</th>
			</tr>
			@endforeach
		</tbody>
	</table> --}}
</div>
@stop

@push('preown')
<script type="text/javascript">
	$('#preown_export').click((e)=>{
		e.preventDefault();
		$('#preownStock_table').csvExport({
             title:"Pre Own Stock"
         });
	})

	$('#brandnew_export').click((e)=>{
		e.preventDefault();
		$('#brandNewStock_table').csvExport({
             title:"Pre Own Stock"
         });
	})



</script>
@endpush