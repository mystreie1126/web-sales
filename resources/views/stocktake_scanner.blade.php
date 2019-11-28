@extends('template')
@include('navtop')
@section('content')
@if(Auth::check())


<div class="scanner-input container">
	<span class="shop_id hide">{{Auth::User()->shop_id}}</span>
    <div class="row">
        <div  class="col s12 center green-text">
            <h5>Scan the Barcode You found on Product</h5>
        </div>
        
        <!-- barcode input !-->
        <input type="text" id="barcode_scanned" v-on:keypress="pressMe($event,flag)" class="center col s12" v-model="scanned_input" placeholder="Hightlight barcode scanner">
        
        <div class="col s12 m12 l12 row" >
            <!-- if barcode cannot be scanned !-->
           	
        	
        	<div class="input-field col s6 center">
                <input placeholder="In put your Barcode here" id="canotscanned" type="text" class="validate  indigo-text col s7" v-model="cannot_scanned.barcode">
                <label for="canotscanned">Can not scanned or Barcode not found ?</label>        
                <button class="btn" @click.prevent="add_ifnotscanned" :disabled="disabled" style="transform:translate(20%,30%)"><i class="material-icons left">note_add</i>submit</button>             
          	</div>
    	</div>
			
		<button class="right red btn" @click.prevent="whatIHaveScanned">what I have just scanned ?</button>
		
		<table v-if="whatIhaveScanned.length > 0">
			<thead>
	          	<tr>
	              	<th>Name</th>
	              	<th>Barcode</th>
	              	<th>Total Scanned</th>
	          	</tr>
        	</thead>
        	<tbody>
        		<tr v-for="(item,index) in whatIhaveScanned">
		            <td>@{{item.name}}</td>
		            <td>@{{item.barcode}}</td>
		            <td>@{{item.total}}</td>
          		</tr>
        	</tbody>
		</table>
	</div>

</div>

@endif
@stop
@push('stocktake_scanner')
<script>
	var chars = []; 
	var shop_id = Number(document.querySelector('.shop_id').textContent);


	var scan_check = new Vue({
    el:'.scanner-input',
    data:{
        scanned_input:'',
        flag:true,
        cannot_scanned:{
            barcode:'',
            qty:''
        },
        disabled:false,
        whatIhaveScanned:[]
    },
    methods:{
        pressMe:function(e,flag){ 
            if (e.which >= 48 && e.which <= 200) {
                chars.push(String.fromCharCode(e.which));
            }
            setTimeout(function(){
                if (chars.length >= 3) {
                    var _barcode = chars.join("");
                    addtheScannerInput(_barcode)
                }
                chars = [];               
            },500);
        },
        
        add_ifnotscanned:function(){
            if(this.cannot_scanned.barcode !== ''){
                this.disabled = true
               	 $.ajax({
			        type:'post',
			        dataType:'json',
			        data:{
			            barcode:this.cannot_scanned.barcode,
			            shop_id:Number(document.querySelector('.shop_id').textContent)
			        },
			        url:stockMan_api+'websales-stocktake-scan',
			        success:function(res){
			        	if(res.status == 'success'){
			        		new Audio('http://www.funtech.ie/audiofiles/notification.mp3').play()
			        		console.log(res.status)	
			        		 scan_check.disabled = false
			        		 scan_check.cannot_scanned.barcode = ''
			        	}else{
			        		alert('something wrong please concat IT')
			        	}
			            $('#barcode_scanned').val('')

			        }
			    })
            }
        },
        whatIHaveScanned:function(){
        	$.ajax({
        		type:'get',
        		dataType:'json',
        		url:stockMan_api+'whatIhaveScanned/'+shop_id,
        		success:function(res){
        			console.log(res)
        			scan_check.whatIhaveScanned = res
        		}
        	})
        }
     }
})

function addtheScannerInput(barcode){
    $.ajax({
        type:'post',
        dataType:'json',
        data:{
            barcode:barcode,
            shop_id:shop_id
        },
        url:stockMan_api+'websales-stocktake-scan',
        success:function(res){
        	if(res.status == 'success'){
        		new Audio('http://www.funtech.ie/audiofiles/notification.mp3').play()
        		console.log(res.status)	
        	}else{
        		alert('something wrong please concat IT')
        	}
            $('#barcode_scanned').val('')

        }
    })
}



</script>
@endpush