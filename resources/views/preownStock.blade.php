@extends('template')
@include('navtop')
@section('content')

<button class="btn indigo right" id="preown_export">Export to CSV</button>

<table class="striped" id="preownStock_table">
	
<thead>
	<tr>
		
	</tr>
</thead>

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