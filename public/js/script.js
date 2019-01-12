
const  default_postVar = function()

{
	return {
		   email:$('.order-email').val(),
	       firstname:$('.order-firstname').val(),
	       lastname:$('.order-lastname').val(),
	       credits:$('.order-credits').val(),
	       id_customer:$('.order-customer_id').val(),
	       product_name:$('.order-product_name').val(),
	       reference:$('.order-reference').val(),
	       order_id:$('.order-order_id').val(),
	       id_reward:$('.order-reward_id').val(),
	       product_id:$('.order-product_id').val(),
	       device:$('.is_device').val(),
	       total_paid:$('.order-total_paid').val(),
	       shopname:$('.shopname').val(),
	       shop_id:$('.shop_id').val(),
		}
}



$(document).ready(function(){
	//css initialize 

	$("select").material_select();
	$(".button-collapse").sideNav();
	$('.datepicker').pickadate({
	    selectMonths:true,
	    selectYear:15,
	    closeOnSelect:true
	   });

	$('ul.tabs').tabs({
	     swipeable : true,
	     responsiveThreshold : 1920
	});
});



$(document).ready(function(){


function toast_init(){
	$('.toast').hide();
	$('.warning-proceed').removeAttr('disabled');
	$('.warning-reverse').removeAttr('disabled');
}

//toast message

const toastContent = $("<p>Do you wanna proceed without using the reward?</p>")
                  .add($('<button id="click-toast" class="btn-flat red-text toast-action warning-proceed">Proceed</button>'))
                  .add($('<button id="click-toast" class="btn-flat toast-action warning-reverse">NO!</button>'));
                  Materialize.toast(toastContent);

$('.toast').hide();

//confriam payment ajax call
	var confirm_payment_call  = function(){
		let ajax_obj = {
			url:window.location.href+'createvoucher',
	        type:'post',
	        dataType:'json',
			data:{

	        	   email:default_postVar().email,
	           firstname:default_postVar().firstname,
	        	lastname:default_postVar().lastname,
	             credits:default_postVar().credits,
	         id_customer:default_postVar().id_customer,
	        product_name:default_postVar().product_name,
	           reference:default_postVar().reference,
	            order_id:default_postVar().order_id,
	           id_reward:default_postVar().id_reward,
	          product_id:default_postVar().product_id,
	              device:default_postVar().device,
	          total_paid:default_postVar().total_paid,
	            shopname:default_postVar().shopname,
	             shop_id:default_postVar().shop_id,
	        current_time:new Date().toISOString().slice(0, 19).replace('T', ' ')
			}

		}
		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

		$.ajax(ajax_obj).done(function(data){
			console.log(data);

			console.log('payment confirmed');
			$('#payment-accept').remove();
			$('#check-remain-voucher').removeClass('hide');


			$('.pos_credits').val(data.pos_credits);
			$('.pos_reward_id').val(data.pos_rewardid);
		});	

	}//end of confirm ajax call


	//start check reward ajax call
	var check_reward = function(){
		let ajax_obj = {
			url:window.location.href+'checkreward',
			type:'post',
	        dataType:'json',
	        data:{
	        	       pos_credits:$('.pos_credits').val(),
                      pos_rewardid:$('.pos_reward_id').val(),
                    online_orderid:default_postVar().order_id,
                 online_customerid:default_postVar().id_customer,
                   online_rewardid:default_postVar().id_reward
	        }

		}

		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

	    $.ajax(ajax_obj).done(function(data){
	    	console.log(data);

	    	if(data.reward_used == 1){
              $('#each-order-details').remove();
              $('#get-new-order').removeAttr('disabled');
            }else if(data.reward_used ==0){
            	
                $('.toast').show();
            }
	    });

	}//end of ajax call



	//start proceed without using reward call

	var not_use_reward = function(){
		let ajax_obj = {
			url:window.location.href+'not_use_reward',
			type:'post',
	        dataType:'json',
	        data:{
	        	  online_rewardid:default_postVar().id_reward,
                     pos_rewardid:$('.pos_reward_id').val()
	        }
		}


		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

	    $.ajax(ajax_obj).done(function(data){
	    	console.log(data);
	    	$('#each-order-details').remove();
            $('#get-new-order').removeAttr('disabled');
            console.log(data.msg);
	    });


	}




	//1.toast_inital post var 
	$('#get-new-order').click(function(e){

		 e.preventDefault();
	     let url = window.location.href+'neworder';

	      $.ajaxSetup({
	          headers: {
	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	          }
	      });

	      $.ajax({
	      	url:url,
	        type:'get',
	        dateType:'json',
	        asycn:false,
	        success:function(data){
	        	let htmlresult = '';
	         	data['order'].forEach(function(e){
	            htmlresult += 
	              "<li id='each-order-details'>"+
	                "<div class='collapsible-header order-basic-info'>"
	                  +"<i class='material-icons indigo-text'>payment</i>"
	                  +"<span class='order-ref indigo-text'>"+e.reference+"</span>"
	                  +"<span class='hide-on-med-and-down'>"+e.date_add+"</span>"
	                  +"<span class='total-amount indigo-text'>"+parseInt(e.total_paid_tax_incl)+" &euro;</span>"
	                +"</div>"
	                +"<div class='collapsible-body row'>"
	                  +"<div class='col s9'>"
	    								+"<span>"+e.product_name+"</span></br>"
	    								+"<span class='indigo-text'>"+e.email+"</span></br>"
	    								+"<span>"+e.credits+"&euro; <span class='voucher-status'>reward amount</span></span>"
	    							+"</div>"

	  							+"<button class='col s3 btn green' id='payment-accept'>Payment Accept</button>"
	                +"<button class='col s3 btn hide orange white-text' id='check-remain-voucher'>Transition Completed</button>"

	                +"<input type='hidden' value="+e.id_reward+" class='order-reward_id'>"
	                +"<input type='hidden' value="+e.email+" class='order-email'>"
	                +"<input type='hidden' value="+e.firstname+" class='order-firstname'>"
	                +"<input type='hidden' value="+e.lastname+" class='order-lastname'>"
	                +"<input type='hidden' value="+e.credits+" class='order-credits'>"
	                +"<input type='hidden' value="+e.id_customer+" class='order-customer_id'>"
	                +"<input type='hidden' value="+e.product_name+" class='order-product_name'>"
	                +"<input type='hidden' value="+e.reference+" class='order-reference'>"
	                +"<input type='hidden' value="+e.id_order+" class='order-order_id'>"
	                +"<input type='hidden' value="+e.product_id+" class='order-product_id'>"
	                +"<input type='hidden' value="+1+" class='is_device'>"
	                +"<input type='hidden' value="+e.product_id+" class='order-product_id'>"
	                +"<input type='hidden' value="+e.total_paid_tax_incl+" class='order-total_paid'>"
	                +"<input type='hidden' value="+data['staff'][0].name+" class='shopname'>"
	                +"<input type='hidden' value="+data['staff'][0].shop_id+" class='shop_id'>"
	                +"<input type='hidden' value="+new Date().toISOString().slice(0, 19).replace('T', ' ')+" class='current_date'>"

	                +"<input type='hidden' value="+0+" class='pos_credits'>"
	                +"<input type='hidden' value="+0+" class='pos_reward_id'>"

	                +"</div>"

	              +"</li>"

	              
	          });

	         $('#order-info').html(htmlresult);
	        },
	        error:function(){
	        	console.log('payment error');
	        }


	      });//end of ajax call
	});//end of click this 


	$('#order-info').on('click','#payment-accept',function(e){
		$('#payment-accept').attr('disabled','disabled');
		$('#get-new-order').attr('disabled','disabled');
		confirm_payment_call();	
	});	//end of confirm the payment


	$('#order-info').on('click','#check-remain-voucher',function(e){
		$('#check-remain-voucher').attr('disabled','disabled');
		check_reward();
	});



	$('.warning-proceed').click(function(e){
		$(this).attr('disabled','disabled');
		$('#check-remain-voucher').attr('disabled','disabled');
		not_use_reward();
		toast_init();
	});

	$('.warning-reverse').click(function(e){
		$(this).attr('disabled','disabled');
		$('#check-remain-voucher').removeAttr('disabled');
		toast_init();
	});



























});