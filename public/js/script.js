



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


var flag = 0;
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

	$('.modal').modal();
	$('.modal2').modal();
});



$(document).ready(function(){

let styles = {
	height:"50vh",
	overflow:'auto'
}

$('.tabs-content').css(styles);
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



/* =========================================all ajax calls =================================*/

//1 . confriam payment ajax call
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
	        // product_name:default_postVar().product_name,
	           reference:default_postVar().reference,
	            order_id:default_postVar().order_id,
	           id_reward:default_postVar().id_reward,
	          product_id:default_postVar().product_id,
	              device:default_postVar().device,
	          total_paid:default_postVar().total_paid,
	            shopname:default_postVar().shopname,
	             shop_id:default_postVar().shop_id,
	        current_time:new Date().toISOString().slice(0, 19).replace('T', ' '),
	         pay_by_card:0,
	         pay_by_cash:0
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


	//2  .start check reward ajax call
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



	//3 .start proceed without using reward call

	var not_use_reward = function(online_rewardid,pos_rewardid){
		let ajax_obj = {
			url:window.location.href+'not_use_reward',
			type:'post',
	        dataType:'json',
	        data:{
	        	  online_rewardid:online_rewardid,
                     pos_rewardid:pos_rewardid
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


	//4. search order detail by input ref

	var search_order_by_ref = function(ref){
		let ajax_obj = {
			url:window.location.href+'search_order_by_ref',
			type:'post',
			dataType:'json',
			data:{
				ref:ref
			}
		}

		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

	    $.ajax(ajax_obj).done(function(response){
	    	console.log(response);
	    	let htmlresult = '';

	    	if(response.has_order == 0){
	    		$("<p class='flow-text red-text'> Order not found!</p>").appendTo('.lol').fadeOut(4000);
	    	}else if(response.has_order == 1){
	    		$('.collect-order_ref').text(response.order.reference);
	    		$('.collect-order_date').text(response.order.date_add);
	    		$('.collect-order_amount').text(parseFloat(response.order.total_paid_tax_incl));
	    		$('.collect-order_customer_name').text(response.customer.firstname + ' ' +response.customer.lastname);
	    		$('.collect-order_email').text(response.customer.email);
	    		$('.hide-id_order').val(response.order.id_order);
	    		$('.hide-id_customer').val(response.order.id_customer);
	    		response.items.forEach((e)=>{
	    			htmlresult += 

	    			"<div class='collect-order_items_detail'>"+
		    			"<span>"+e.product_name+"</span>"+
		    			"<span class='orange-text'>"+e.product_reference+"</span>"+
		    			"<span>&#215; <span class='indigo-text'>"+e.product_quantity+"</span></span>"+
		    		"</div>"

	    		});

	    		$('.collect-order_items').html(htmlresult);

	    		if(response.order.current_state !== 2 && response.order.current_state !==5 ){
	    			$('.collect-payment_status').html('<span class="red-text">Not Paid</span>');
	    			$('.collect-order_pay').removeClass('hide');
	    			//$('.collect-order_customer_info').append("<button href='#modal2' class='modal-trigger btn collect-order_pay'>Pay and Collect</button>");
	    			
	    		}else if(response.order.current_state == 5){
	    			$('.collect-payment_status').html('<span class="green-text">Paid and Collected</span>')
	    		}else if(response.order.current_state == 2){
	    			$('.collect-payment_status').html('<span class="green-text">Paid</span>');
	    			$('.collect-order_no_pay').removeClass('hide');
	    		}

	    		$('.collect-order').removeClass('hide');
	    	}
	    });


	}


	//5.collect in store ajax call

	var collect_payment = function(card,cash){
		let ajax_obj = {
			url:window.location.href+'collect_in_store',
			type:'post',
			dataType:'json',
			data:{
				shop_id:$('.hide-shop_id').val(),
				device_order:$('.hide-device_order').val(),
				online_order_id:$('.hide-id_order').val(),
				online_customer_id:$('.hide-id_customer').val(),
				date:new Date().toISOString().slice(0, 19).replace('T', ' '),



				paid_amount:Number($('.collect-order_amount').text()),
				
				shop_name:$('.hide-shop_name').val(),
				card:card,
				cash:cash

			}
		}

		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

	      $.ajax(ajax_obj).done(function(response){
	      	console.log(response.collected);

	      	if(response.collected == 1){
	      		$('.collect-order_items_detail').remove();
	      		$('.collect-order').addClass('hide');
	      		$("<p class='flow-text green-text'> Collected and Paid!</p>").appendTo('.lol').fadeOut(4000);
	      		$('.collect-order_no_pay').addClass('hide');
	      	}
	      });
	}

	//6.search reward by email ajax call


	var search_reward_by_email = function(email){

		let ajax_obj = {
			url:window.location.href + 'search_reward_by_email',
			type:'post',
			dataType:'json',
			data:{
				email:email
			}		
		}

		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

		$.ajax(ajax_obj).done(function(response){
			console.log(response);

			$('.rm_customer_id').val(response.customer.id_customer);
			$('.rm_firstname').val(response.customer.firstname);
			$('.rm_lastname').val(response.customer.lastname);
			$('.rm_email').val(response.customer.email);
			$('.rm_total_reward').val(response.reward_total);

			$('.rm-fullname').text(response.customer.firstname + ' '+response.customer.lastname);
			$('.rm_customer_email').text(response.customer.email);
			$('.rm-customer_rewards').text(response.reward_total);
			$('.reward-results').removeClass('hide');	
			if(response.valid_customer == 0 ){
				let alert_msg = $("<p class='flow-text red-text'>Customer Not Found!</p>").fadeOut(4000);
				$('.reward-results').html(alert_msg);
				//$("<p class='flow-text red-text'>Customer Not Found!</p>").appendTo('.reward-results').fadeOut(4000);
			}else if(response.valid_customer == 1 && response.reward_total > 0){
				
				
				$('.rm_reward_active').removeClass('hide');
				$('.rm_check_reward').addClass('hide');
			}
		});
	}

	//7. transfer customer online ajax call 

	var transfer_customer_check = function(email){
		let ajax_obj = {
			url:window.location.href+'transfer_customer_check',
			type:'post',
			dataType:'json',
			data:{
				email:email,
			}
		}

		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

	    $.ajax(ajax_obj).done(function(response){
	    	console.log(response);
	    	if(response.valid_customer == 0 ){
				let alert_msg = $("<p class='flow-text red-text'>Customer Not Found!</p>").fadeOut(4000);
				$('.yolo').append(alert_msg);
			}else if(response.valid_customer == 1){
				$('.online-customer_email').text(response.customer.email);
				$('.online-customer_fullname').text(response.customer.firstname + ' ' + response.customer.lastname);
			

				$('.online-customer_id-hide').val(response.customer.id_customer);
				$('.online-customer_firstname-hide').val(response.customer.firstname);
				$('.online-customer_lastname-hide').val(response.customer.lastname);
				$('.online-customer_email-hide').val(response.customer.email);

				
				$('.online-customer-transfer').removeClass('hide');

				if(response.share_customer == 0){
					$('.has_online_price').text("In Store Price Only");
					$('.transfer_customer_to_pos').removeClass('hide');
				}else if(response.share_customer == 1){
					$('.has_online_price').html("<p class='cyan-text'>Online Price Available</p>");
				}
			}
	    });


	}

	//8. transfer customer to pos for online price 

	var get_member = function(id,firstname,lastname,email){
		let ajax_obj = {
			url:window.location.href+'get_member',
			type:'post',
			dataType:'json',
			data:{
		        online_customer_id:id,
				firstname:firstname,
				lastname:lastname,
				email:$('.online-customer_email').text(),
				date:new Date().toISOString().slice(0, 19).replace('T', ' ')
			}	
		}

		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

		 $.ajax(ajax_obj).done(function(response){
		 	console.log(response);
		 	$('.has_online_price').text("Has Online Price");
		 	$('.transfer_customer_to_pos').addClass('hide');
		 });



	}

	//9.pull reward ajax call 

	
	var pull_reward = function(){
		let ajax_obj = {
			url:window.location.href+'pull_reward',
			type:'post',
			dataType:'json',
			data:{
				online_customer_id:$('.rm_customer_id').val(),
				firstname:$('.rm_firstname').val(),
				lastname:$('.rm_lastname').val(),
				emai:$('.rm_email').val(),
				total_reward:$('.rm_total_reward').val(),
				date:new Date().toISOString().slice(0, 19).replace('T', ' ')
			}

		}

		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });


		 $.ajax(ajax_obj).done(function(response){
		 	console.log(response);
		 	if(response.transfered == 1){
		 		$('.response_stored_id_reward').val(response.stored_reward.id_reward);
		 		$('.response_pos_id_reward').val(response.pos_reward.id_reward);
		 		$('.response_pos_id_customer').val(response.pos_reward.id_customer);
		 		$('.response_pos_reward_credits').val(response.reward_total);
		 		$('.response_customer_id').val(response.stored_reward.id_customer);
		 		$('.rm_reward_active').addClass('hide');
		 		$('.rm_check_reward').removeClass('hide');

		 	}
		 
		 });
	}

	//10.check remain reward ajax call 

	var check_remain_reward_use = function(){
		let ajax_obj = {
			url:window.location.href+'check_remain_reward_use',
			type:'post',
			dataType:'json',
			data:{
				stored_id_reward:$('.response_stored_id_reward').val(),
				pos_id_reward:$('.response_pos_id_reward').val(),
				pos_id_customer:$('.response_pos_id_customer').val(),
				reward_total:$('.response_pos_reward_credits').val(),
				customer_id:$('.response_customer_id').val()
			}
		}

		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

		 $.ajax(ajax_obj).done(function(response){
		 	console.log(response);


	    	if(response.reward_used == 1){
              $('.reward-results').addClass('hide');
              $('.rm_check_reward').removeAttr('disabled');
              $('#search-reward-by-email').removeAttr('disabled');
              $('.rm_reward_active').removeAttr('disabled')
            }else if(response.reward_used ==0){
            	
                $('.toast').show();
            }

		 });
	}

	//

	var get_total_today = function(){
		let ajax_obj = {
			url:window.location.href+'get_total_today',
			type:'post',
			dataType:'json',
			data:{
				shop_id:$('.get_total_shop').val()
			}
		}


		$.ajaxSetup({
	       headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	     }
	    });

	    $.ajax(ajax_obj).done(function(response){
	    	console.log(response);

	    	$('.total_cash_card').html(response.total);
	    	$('.total_cash').html(response.cash);
	    	$('.total_card').html(response.card);
	    });
	}


/* =========================================end of all ajax calls =================================*/





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
	                +"<input type='hidden' value="+0+" class='card'>"
	                +"<input type='hidden' value="+0+" class='cash'>"

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
		//$('#payment-accept').attr('disabled','disabled');
		$('#get-new-order').attr('disabled','disabled');
		$('#payment-accept').attr('disabled','disabled');
		confirm_payment_call();
	});	



	// $('.pay_by_card').click((e)=>{
	// 	e.preventDefault();
	// 	$('.card').val(1);
		
	// 	confirm_payment_call();	
	// });

	// $('.pay_by_cash').click((e)=>{
	// 	e.preventDefault();
	// 	$('.cash').val(1)
	// 	$('#payment-accept').attr('disabled','disabled');
	// 	confirm_payment_call();	
	// });

	

	$('#order-info').on('click','#check-remain-voucher',function(e){
		$('#check-remain-voucher').attr('disabled','disabled');
		check_reward();
	});



	$('.warning-proceed').click(function(e){
		$(this).attr('disabled','disabled');
		if(flag == 1){
			console.log(flag);
			let online_rewardid = $('.response_stored_id_reward').val(),
				   pos_rewardid = $('.response_pos_id_reward').val();
			not_use_reward(online_rewardid,pos_rewardid);
			toast_init();

			$('.reward-results').addClass('hide');
			$('#search-reward-by-email').removeAttr('disabled');
			$('.rm_reward_active').removeAttr('disabled');
			$('.rm_check_reward').removeAttr('disabled');

			$('.rm_reward_active').addClass('hide');
			$('.rm_check_reward').addClass('hide');

		}else{
			$('#check-remain-voucher').attr('disabled','disabled');
			let online_rewardid = default_postVar().id_reward,
                   pos_rewardid = $('.pos_reward_id').val();
			not_use_reward(online_rewardid,pos_rewardid);
			toast_init();

		}
		
	});

	$('.warning-reverse').click(function(e){
		$(this).attr('disabled','disabled');
		$('#check-remain-voucher').removeAttr('disabled');
		$('.rm_check_reward').removeAttr('disabled');
		console.log(22);
		toast_init();
	});


	
	$('.collect-order_no_pay').click(function(e){
		e.preventDefault();
		pay_flag = 1;
		let cash = 0, card = 0; 
		$('.collect-order_amount').text('0');
		collect_payment(cash,card);

	});

	$('#search-order-by-reference').click((e)=>{
		e.preventDefault();	
		let input_ref =  $('#input-id-ref').val();
		search_order_by_ref(input_ref);
		//console.log(input_ref);
	});


	$('.collect_pay_by_cash').click((e)=>{
		console.log('hahaha');
		 $('.hide-pay_by_card').val(0);
		 $('.hide-pay_by_cash').val(1);

		let card = $('.hide-pay_by_card').val();
		let cash = $('.hide-pay_by_cash').val()
		collect_payment(card,cash);
		$('.collect-order_pay').addClass('hide');

	});

	$('.collect_pay_by_card').click((e)=>{
		console.log('lool');
		$('.hide-pay_by_cash').val(0);
		$('.hide-pay_by_card').val(1);

		let card = $('.hide-pay_by_card').val();
		let cash = $('.hide-pay_by_cash').val()
		collect_payment(card,cash);

		$('.collect-order_pay').addClass('hide');
	});


	$('#search-reward-by-email').click((e)=>{
		e.preventDefault();	
		let email =  $('#email-for-voucher').val();
		search_reward_by_email(email);
		//console.log(input_ref);
	});


	$('#search-online_price-by-email').click((e)=>{
		e.preventDefault();
		let email = $('#input-online_email').val();
		transfer_customer_check(email);
	});



	$('.transfer_customer_to_pos').click((e)=>{
		e.preventDefault();
		$('.transfer_customer_to_pos').attr('disabled','disabled');
		let id = $('.online-customer_id-hide').val();
		let firstname = $('.online-customer_firstname-hide').val();
		let  lastname = $('.online-customer_lastname-hide').val();
		let  email = $('online-customer_email-hide').val();

		 get_member(id,firstname,lastname,email);


	});

	$('.rm_reward_active').click((e)=>{
		e.preventDefault();
		$('.rm_reward_active').attr('disabled','disabled');
		pull_reward();

		$('#search-reward-by-email').attr('disabled','disabled');
	});


	$('.rm_check_reward').click((e)=>{
		e.preventDefault();
		$('.rm_check_reward').attr('disabled','disabled');
		flag = 1;
		check_remain_reward_use();
	});

	$('#get_total_today').click((e)=>{
		get_total_today();
	});

});





