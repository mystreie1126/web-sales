@extends('template')
@include('navtop')
@section('content')

<div class="top-message">
	
</div>


<table class="striped" id="branchStockList">
  <thead>
    <tr>
        <th>Name</th>
        <th>reference</th>
        <th class="center">Quantity</th>
        <th class="center">Action</th>
    </tr>
    <input type="text" id="myInput" class="hide" placeholder="Type anything you wanna search">
  </thead>

    <tbody class="stockinfo_branch">
	{{-- 	<tr class="stockinfo_row">
			<th class="indigo-text">iOhone asdadqwedad a adadqweqdad</th>
			<th class="teal-text">2000007891</th>
			<th>
				<input type="number" class="update_stock_input center" required>
			</th>
			<th class="center">
				<button>Update</button>
			</th>
			<input type="hidden" value="" class="branch_product_id">
		</tr> --}}

   </tbody>
</table>

@push('countStock')
  <script type="text/javascript" src="{{URL::asset('js/countstock.js')}}"></script>
 {{--  <script src="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></script --}}>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
@endpush
@stop