@extends('template')
@include('navtop')
@section('content')

<button class="btn indigo right" id="preown_export">Export</button>

<table class="striped" id="preownStock_table">
	
<thead>
	<tr>
		
	</tr>
</thead>
<p class="flow-text">Total <span class="orange-text">{{count($stocks)}}</span> devices in stock</p>

<tbody>
	@foreach($stocks as $stock)
	<tr>
		<th>{{$stock->name}}</th>
	</tr>
	@endforeach
</tbody>
</table>

@stop

@push('preown')
<script type="text/javascript">
	$('#preown_export').click((e)=>{
		e.preventDefault();
		$('#preownStock_table').csvExport({
             title:"Phone Stock"
         });
	})


</script>
@endpush