@extends('template')
@include('navtop')
@section('content')
@if(Auth::check())
	<input type="hidden" value="{{Auth::User()->feature_value}}">
@endif
<div class="container device_list">
	<p class="flow-text">All Available Devices in RockPos</p>
	{{-- <button class="btn indigo right" id="preown_export">Export</button> --}}
	<input type="text" v-model="search" placeholder="SEARCH BY IMEI OR MODEL OR SHOP NAME" class="searchable">

	<table>
		<thead>
          <tr>
              <th>Model</th>
              <th>IMEI</th>
              <th>Price</th>
			  <th>Shop</th>
          </tr>
        </thead>
		<tbody v-if="devices.length > 0" v-for="(device,index) in filterdevices">
			<tr>
				<td>@{{device.NAME}}</td>
				<td>@{{device.imei}}</td>
				<td>@{{device.price}}&euro;</td>
				<td>@{{device.shopname}}</td>
			</tr>
		</tbody>
	</table>
	{{-- <div v-if="devices.length > 0" v-for="(device,index) in filterdevices">
	  <div class="test_1">
		  <div  class="row">
			<h5 class="col s8 m8 l8 indigo-text text-darken-4">@{{device.name}}</h5>

			<h5 class="col s6 m6 l6 orange-text" >@{{device.imei}}</h5>


			</div>
	  </div> --}}
</div>
@stop

@push('preown')
<script type="text/javascript">
	// $('#preown_export').click((e)=>{
	// 	e.preventDefault();
	// 	$('#preownStock_table').csvExport({
    //          title:"Pre Own Stock"
    //      });
	// })
	//
	// $('#brandnew_export').click((e)=>{
	// 	e.preventDefault();
	// 	$('#brandnewStock_table').csvExport({
    //          title:"Brand New Stock"
    //      });
	// })

	var cors = 'https://calm-anchorage-96610.herokuapp.com/';
	var device_list = new Vue({
		el:'.device_list',
		data:{
			devices:[],
			search:''
		},
		created:function(){
			axios({
				method:'get',
				url:cors+'https://stockmananger-api.herokuapp.com/devices/allshop-devices',
				dataType:'json'
			}).then((res)=>{
				res.data.forEach((e)=>{
					e.searchstr = e.NAME.toString().toLowerCase().concat(e.imei.toString().toLowerCase())
													  .concat(e.shopname.toString().toLowerCase());
				    e.price = e.retail.toFixed(2);
				})
				device_list.devices = res.data
			})
		},
		computed:{
			searchLower:function(){
		      return this.search.toLowerCase();
		    },
			filterdevices:function(){
		          return this.devices.filter((e)=>{
		            return e.searchstr.match(this.searchLower);
				});
		    }
		}
	})


</script>
@endpush
