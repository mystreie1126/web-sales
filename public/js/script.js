
function init_input(){
	$('.update_stock_input').css({
		"height":"auto",
		"width":"auto",
		"margin":"0"
	})
}
var refresh_flag = 0;

window.onbeforeunload = function(e){
	if(refresh_flag == 1){
		return 'error';
	}

}


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
	    closeOnSelect:true,
	    format: "mmm.dd,yyyy"
	   });

	$(".timepicker").pickatime({
	    default: "now",
	    twelvehour: false, // change to 12 hour AM/PM clock from 24 hour
	    donetext: "Select",
	    autoclose: false,
	    vibrate: true,
	    darktheme:false
	  });
	  // For adding seconds (00)
	  $(".timepicker").on("change", function() {
	    var receivedVal = $(this).val();
	    var iam = $(this).attr('id');
	    // var check_time = $(this).val(receivedVal + ":00");
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

/* check stock */

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
$.ajax({
	url:window.location.href+'stockindex',
	type:'get',
	dataType:'json',
	success:function(res){
		console.log(res);

		let html = '';

		res.stock.forEach((e,i)=>{
			html+= '<ul class="collection">'+
			         '<li class="collection-item stock_detail">'+
			           '<span class="indigo-text">'+e.name+'</span>'+
			           '<span class="stock_ref">'+e.reference+'</span>'+
			          '<input type="number" value="" required class="update_stock_input " placeholder="input quantity">'+
			          '<span class="update_btn ">Update</span>'+
								'<input type="hidden" value='+e.ie_product_id+'>'+
								'<input type="hidden" value='+e.pos_product_id+'>'+
								'<input type="hidden" value='+e.id+'>'+
								'<input type="hidden" class="notification">'+
			         '</li>'+
			      '</ul>'

			$('#test4').html(html);
			init_input();
			if(res.shop_id == 27){
					$('#test4').append('<button class="btn green waves-effect waves-light" id="sync_the_stock" style="margin-bottom:5px">Sync the Stock</btn>')
			}
		});
	}
});

$('#test4').on('click','.update_btn',function(){
	let input_qty = $(this).parent().find('.update_stock_input').val(),
			ie_product_id = $(this).parent().find('input')[1].value,
		  pos_product_id = $(this).parent().find('input')[2].value,
			stock_id = $(this).parent().find('input')[3].value,
			ref = $(this).parent().find('.stock_ref').text();
			if(input_qty != "" && input_qty > 0){
				$(this).parent().parent().remove();
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				$.ajax({
					url:window.location.href+'stock_update',
					type:'post',
					dataType:'json',
					data:{
						pos_product_id:pos_product_id,
						qty:input_qty,
						stock_id:stock_id
					},
					success:function(res){
						console.log(res);
						$.notify(ref+" quantity has been Updated!","success");
					}
				});

			}else{
				$.notify("Please input a valid number",{position:"right middle"});

			}

			//$(this).parent().parent().remove();
});

$('#test4').on('click','#sync_the_stock',function(e){
		e.preventDefault(e);
		$(this).attr('disabled','disabled');
		$(this).text('syncing....')
		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
		$.ajax({
			url:window.location.href+'stock_sync',
			type:'get',
			dataType:'json',
			success:function(res){
				console.log(res)
				$('#sync_the_stock').removeAttr('disabled');
				$('#sync_the_stock').text('sync the stock');
			}
		})
});



/* =========================================all ajax calls =================================*/

//1 . confriam payment ajax call



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



	    });


	}


	//4. search order detail by input ref

	function helperContact(e){
		return  e !=='' ? e : "Empty";
	}



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
	    	console.log('lalalal');
	    	console.log(response);
	    	let htmlresult = '';

	    	if(response.has_order == 0){
	    		$("<p class='flow-text red-text'> Order not found!</p>").appendTo('.lol').fadeOut(4000);
	    	}else if(response.has_order == 1){

	    		//response.contact.phone = null;

	    		$('.collect-order_ref').text(response.order.reference);
	    		$('.collect-order_date').text(response.order.date_add);
	    		$('.collect-order_amount').text(parseFloat(response.order.total_paid_tax_incl));
	    		$('.collect-order_customer_name').text(response.customer.firstname + ' ' +response.customer.lastname);
	    		$('.collect-order_email').text(response.customer.email);

	    		if(response.contact !== null){
		    		$('.collect-order_contact_mobile').text(helperContact(response.contact.phone_mobile));
		    		$('.collect-order_contact_phone').text(helperContact(response.contact.phone));
		    		$('.collect-order_contact_city').text(helperContact(response.contact.city));
	    		}




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
	    			 if(response.payment_method.length == 0){
	    			 	$('.collect-payment_status').html('<span class="green-text">Collected and Paid</span>')
	    			 }

	    			 else if(response.payment_method.length == 1){
	    			 	if(response.payment_method[0].cash == 1 && response.payment_method[0].card == 0){
	    			 	  $('.collect-payment_status').html('<span class="green-text">Collected and Paid by</span><span class="orange-text"> Cash</span>')
	    			 	}else if(response.payment_method[0].cash == 0 && response.payment_method[0].card == 1){
	    			 		$('.collect-payment_status').html('<span class="green-text">Collected and Paid by</span><span class="blue-text"> Card</span>')
	    			 	}else{
	    			 		$('.collect-payment_status').html('<span class="green-text">Collected and Paid</span>')
	    			 	}
	    			 }


	    		}else if(response.order.current_state == 2){

	    			if(response.payment_method.length == 0){
	    			 	$('.collect-payment_status').html('<span class="green-text">Paid </span>')
	    			 	$('.collect-order_no_pay').removeClass('hide');
	    			 }

	    			 else if(response.payment_method.length == 1){

	    			 	if(response.payment_method[0].cash == 1 && response.payment_method[0].card == 0){
	    			 	  $('.collect-payment_status').html('<span class="green-text">Paid by</span><span class="orange-text"> Cash</span>')
	    			 	  $('.collect-order_no_pay').removeClass('hide');
	    			 	}else if(response.payment_method[0].cash == 0 && response.payment_method[0].card == 1){
	    			 		$('.collect-payment_status').html('<span class="green-text">Paid by</span><span class="blue-text"> Card</span>')
	    			 		$('.collect-order_no_pay').removeClass('hide');
	    			 	}else{
	    			 		$('.collect-payment_status').html('<span class="green-text">Paid</span>')
	    			 		$('.collect-order_no_pay').removeClass('hide');
	    			 	}
	    			 }


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
	      	console.log(response);

	      	if(response.collected == 1){
	      		$('.collect-order_items_detail').remove();
	      		$('.collect-order').addClass('hide');
	      		$("<p class='flow-text green-text'> Collected and Paid!</p>").appendTo('.lol').fadeOut(4000);
	      		$('.collect-order_no_pay').addClass('hide');
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






$('.get_online_sales').click(function(e){
	let url = window.location.href+'get_total_today';
	$('.get_online_sales').attr('disabled','disabled');
	//$('.get_online_sales').text('loading..');


    let start_date = $('.start-date').val(),

    	  end_date = $('.end-date').val();

	$.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:{
			   shop_id:$('.get_total_shop').val(),
				start_date:start_date,

				end_date:end_date,

		},
		success:function(e){
			$('.get_online_sales').removeAttr('disabled');
			console.log(e);
			let htmlresult = '';

			let record_message = "<p class='flow-text'>Web Sales Record from "+
			e.date_from+" to "+e.date_end+" with total "+
			"<span class='green-text'>"+e.total_cash+" &euro;</span>"+" in Cash and "+
			"<span class='blue-text'>"+e.total_card+" &euro;</span>"+" in Card"+
			"</p>";

			$('.websales-record-message').html(record_message)

			if(e.record.length > 0){
				e.record.forEach(function(el){
				htmlresult +=
				"<tr>"+
					"<td>"+el.reference+"</td>"+
					"<td>"+el.paid_amount+"</td>"+
					"<td>"+!!el.card+"</td>"+
					"<td>"+!!el.cash+"</td>"+
					"<td>"+el.created_at+"</td>"+
				"</tr>"

				});
				$('.each-websales-record').html(htmlresult);
			}



		}
	});
});


$('.total-sale').fancyTable({
  sortColumn:0,
  sortable: true,
  pagination: false,
  searchable: true,
  globalSearch: true,
  inputPlaceholder: "Search by reference",

});





/* =========================================end of all ajax calls =================================*/

var btn_flag = 0;

function check_new_order_reset(){
	$('#get-new-order').removeAttr('disabled');
	$('#get-new-order').text('Check New Order');
}

function check_new_order_processing(){
	$('#get-new-order').attr('disabled','disabled');
	$('#get-new-order').text('Processing...');
}

function check_new_order_loading(){
	$('#get-new-order').attr('disabled','disabled');
	$('#get-new-order').text('Loading...');
}


function search_reward_loading(){
	$('#search-reward-by-email').attr('disabled','disabled');
	$('#search-reward-by-email').text('Loading...');
}

function search_reward_reset(){
	$('#search-reward-by-email').removeAttr('disabled');
	$('#search-reward-by-email').text('Search Reward');
}





	// get-new order button click
	$('#get-new-order').click(function(e){

		//check new order
		check_new_order_loading();
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
	        success:function(data){
	        	console.log(data);

	        	// data.order.forEach(function(e){
	        	// 	console.log(e.reward);
	        	// });

	        	if(data['order'].length == 0){
	        		check_new_order_reset();
	        		let msg = $("<p class='flow-text'>No reward order coming yet!</p>").fadeOut(3000);
	        		$('.new-order').html(msg);
	        	}



	        	let htmlresult = '';
	         	data['order'].forEach(function(e){
	         		console.log(e);
	            htmlresult +=
	              "<li class='each-order-details'>"+
	                "<div class='collapsible-header order-basic-info'>"
	                  +"<i class='material-icons indigo-text'>payment</i>"
	                  +"<span class='order-ref indigo-text'>"+e.reference+"</span>"
	                  +"<span class='hide-on-med-and-down'>"+e.date_add+"</span>"
	                  +"<span class='total-amount indigo-text'>"+parseInt(e.total_paid_tax_incl)+" &euro;</span>"
	                +"</div>"
	                +"<div class='collapsible-body row'>"
	                  +"<div class='col s7'>"
	    								+"<span>"+e.product_name+"</span></br>"
	    								+"<span class='indigo-text'>"+e.email+"</span></br>"
	    								+"<span>"+e.credits+"&euro; <span class='voucher-status'>reward amount</span></span>"
	    							+"</div>"
	    			+"<div class='order-dialog col s5'>"
	  							+"<button class=' btn green' id='payment-accept'>Accept Payment</button>"
	               				+"<button class='btn hide orange white-text' id='check-remain-voucher'>Complete Transaction</button>"


	                +"</div>"
	                +"<div id='check_btn_lol' class='hide'>"
       					+"<h6 class='red-text' style='font-weight:bold;'>Are you sure proceed without using Reward?</h6>"

	            		+"<button id='proceed' class='btn teal accent-3'>Proceed</button>"
	            		+"<button id='no-proceed' class='btn  blue-grey'>No</button>"

	               	+"</div>"
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
	         let child_length = $('#order-info').children().length;
				if(child_length > 0){
					check_new_order_processing();
				}

	         $('.each-order-details').each(function(index,e){

	         	$(e).find('#payment-accept').click(function(){
	         		refresh_flag = 1;
	         		$('#payment-accept').attr('disabled','disabled');
	         		check_new_order_processing();
		          	$.ajaxSetup({
				       headers: {
				       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				     	}
	   				 });


	         		$.ajax({
	         			url:window.location.href+'createvoucher',
				        type:'post',
				        dataType:'json',
				        data:{
				        	email : $(e).find('.order-email').val(),
		         		 	firstname : $(e).find('.order-firstname').val(),
		         		 	lastname : $(e).find('.order-lastname').val(),
		         		 	id_customer : $(e).find('.order-customer_id').val(),
		         		 	reference : $(e).find('.order-reference').val(),
		         		 	order_id : $(e).find('.order-order_id').val(),
		         		 	id_reward : $(e).find('.order-reward_id').val(),
		         		 	product_id : $(e).find('.order-product_id').val(),
		         		 	device : 1,
		         		 	total_paid : $(e).find('.order-total_paid').val(),
		         		 	shopname : $(e).find('.shopname').val(),
		         		 	shop_id : $(e).find('.shop_id').val(),
		         		 	current_time:new Date().toISOString().slice(0, 19).replace('T', ' '),
					        pay_by_card:0,
					        pay_by_cash:0
				        },
				        success:function(re){



				        	console.log(re);

				        	console.log('payment confirmed');
				        	$(e).find('#payment-accept').remove();

				        	$(e).find('#check-remain-voucher').removeClass('hide');
				        	$(e).find('.pos_credits').val(re.pos_credits);
							$(e).find('.pos_reward_id').val(re.pos_rewardid);

							$(e).on('click','#check-remain-voucher',function(){

								$(e).find('#check-remain-voucher').attr('disabled','disabled');
								console.log($(e).find('#check-remain-voucher').text());


								$.ajax({
									url:window.location.href+'checkreward',
									type:'post',
							        dataType:'json',
							        data:{
						        	       pos_credits:$(e).find('.pos_credits').val(),
					                      pos_rewardid:$(e).find('.pos_reward_id').val(),
					                    online_orderid:$(e).find('.order-order_id').val(),
					                 online_customerid:$(e).find('.order-customer_id').val(),
					                   online_rewardid:$(e).find('.order-reward_id').val()
							        },
							        success:function(data){
							        	//$(e).find('#check-remain-voucher').remove();
								    	if(data.reward_used == 1){
								    		refresh_flag = 0;
							              $(e).remove();
							              check_new_order_reset();
							            }else if(data.reward_used ==0){
							            	console.log(2);

							            	$(e).find('#check_btn_lol').removeClass('hide');

							            	$(e).find('#proceed').click((function(){
							            		$(this).attr('disabled','disabled');
							            		refresh_flag = 0;

							            		$.ajax({
							            			url:window.location.href+'not_use_reward',
							            			type:'post',
							            			dataType:'json',
							            			data:{
							            				 online_rewardid:data.online_rewardid,
                     									 pos_rewardid:data.pos_rewardid
							            			},
							            			success:function(res){
							            				console.log(res);

							            				$(e).remove();

							            				if($('#order-info').children().length == 0){
							            					check_new_order_reset();
							            				}
							            			}
							            		});



							            	}));


							            	$(e).find('#no-proceed').click((function(e){
							            		$(this).parent().prev().children().removeAttr('disabled');
							            		$(this).parent().addClass('hide');
							            	}));



							            }
							        }
								});


							});//end of function

							// a.on('click','a',function(){

							// })


				        }

	         		});


	         	});//end of each li tag
	         });
	        },
	        error:function(){
	        	check_new_order_reset()
	        	console.log('payment error');
	        }


	      });//end of ajax call
	});//end of click this



	/* =====================search reward by email ===============================================================*/
	$('#search-reward-by-email').click(function(e){
		 search_reward_loading();
		 e.preventDefault();
		 let input_email = $('#email-for-voucher').val();

		 //console.log(input);
		  $.ajaxSetup({
	          headers: {
	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	          }
	      });

		  $.ajax({
		  	url:window.location.href+'search_reward_by_email',
			type:'post',
			dataType:'json',
			data:{
				email:input_email
			},
			success:function(cus){
				console.log(cus);
				search_reward_reset();

				let html =

				 "<ul class='collection with-header collect-order'>"
					+"<li class='collection-header flow-text'>"
						+cus.customer.firstname+ " "+cus.customer.lastname
					+"</li>"

					+"<li class='collection-item row reward-condition-container'>"
						+"<p class='col s12'>"+cus.customer.email+"</p>"

						+"<div class='cus-reward-msg col s12'>"
							+"<p class='reward-none-msg hide'>This customer has no reward points left</p>"
						+"</div>"

						+"<div class='reward-info-container col s6'>"

						+"</div>"
						+"<input type='hidden' class='cus_customer_id' value="+cus.customer.id_customer+">"
						+"<input type='hidden' class='cus_firstname' value="+cus.customer.firstname+">"
						+"<input type='hidden' class='cus_lastname' value="+cus.customer.lastname+">"
						+"<input type='hidden' class='cus_email' value="+cus.customer.email+">"



					+"</li>"
				+"</ul>"

				$('.customer-has-results').html(html);


				if(cus.reward_total.length == 0){
					$('.reward-none-msg').removeClass('hide');
				}
				else{
					let total_reward = cus.reward_total.map(x=>Number(x)).reduce((a,b)=>a+b),
						html = "<p>This customer has <span class='cyan-text'>"+total_reward+"</span> &euro; reward in total</p>"
								+"<button class='active_reward_on_pos btn'>Activate Rewards on RockPos</button>";

					console.log('total_reward is '+total_reward+' can used on pos');

					$('.reward-info-container').html(html);

					$('.active_reward_on_pos').click(function(){
						$(this).attr('disabled','disabled');
						$(this).text('loading...');

						refresh_flag = 1;

						$.ajax({
							url:window.location.href+'pull_reward',
							type:'post',
							dataType:'json',
							data:{
								online_customer_id:cus.customer.id_customer,
								firstname:cus.customer.firstname,
								lastname:cus.customer.lastname,
								email:cus.customer.email,
								data:new Date().toISOString().slice(0, 19).replace('T', ' '),
								total_reward:total_reward

							},
							success:function(remain){
								console.log(remain);
								let html_remain = "<p>This customer has <span class='cyan-text'>"+remain.pos_reward.credits+"</span> &euro; reward available on rockpos</p>"
								+"<button class='check_reward_on_pos btn amber'>Finish Transaction</button>";

								$('.reward-info-container').html(html_remain);

								$('.check_reward_on_pos').click(function(){
									$(this).attr('disabled','disabled');
									$(this).text('loading...');
									$.ajax({
										url:window.location.href+'check_remain_reward_use',
										dataType:'json',
										type:'post',
										data:{
											pos_id_reward:remain.pos_reward.id_reward,
											reward_total:remain.pos_reward.credits,
											customer_id:remain.stored_reward.id_customer,
											stored_id_reward:remain.stored_reward.id_reward

										},
										success:function(check_remain){
											console.log(check_remain);
											if(check_remain.reward_used == 1){
												$('.customer-has-results').children().remove();
												refresh_flag = 0;
											}else if(check_remain.reward_used == 0){
												let condition_html =
												"<div class='col s6 row'>"
													+"<p class='col s12'>Proceed without using reward?</p>"
													+"<button class='btn indigo col s4 not-gonna-use'>Proceed </button>"
													+"<button class='btn red col s4 forgot-to-use'>No</button>"
												+"</div>"
												$('.reward-condition-container').append(condition_html);



												// forgot to use reward ....
												$('.forgot-to-use').click(function(){
													$(this).parent().remove();
													$('.check_reward_on_pos').removeAttr('disabled');
													$('.check_reward_on_pos').text('Finish Transaction');
												});



												// not gonna use reward anyway
												$('.not-gonna-use').click(function(){
													$(this).attr('disabled','disabled');
													$(this).text('loading....');

													refresh_flag = 0;

													$.ajax({
														url:window.location.href+'not_use_reward',
														type:'post',
														dataType:'json',
														data:{
															pos_rewardid:check_remain.pos_rewardid,
															online_rewardid:check_remain.online_rewardid
														},
														success:function(){
															$('.customer-has-results').children().remove();
														}
													});
												});

											}
										}
									});
								});
							},
							error:function(){
								$('.reward-info-container').html("<p class='red-text'>oppps something went wrong Zzzzz...</p>");
							}
						});
					});
				}



				// console.log(res.reward.length);
			},
			error:function(e){
				search_reward_reset();
				$('.customer-has-results').html("<p>Customer not found</p>")
			}

		  }); // all call ends



	});



/*=========================collect in store=====================================================================*/









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



	$('#refund-info').hide();

	$('#refund-btn').click(function(){
		$('#refund-info').toggle('slow');

		let a = $('.refund-order-details').children().remove();

		console.log(a);
	});




	$(".click_flag").bind('click', function(e) {
		if($(e.target).is('#get-order-history') && ($('#lele').hasClass('hide') || $('#refund').hasClass('hide'))) {
			  $('#lele').removeClass('hide');
			  $('#refund').removeClass('hide');
		}else if($('#lele').not( ".hide" )||$('#refund').not(".hide")){
			$('#lele').addClass('hide');
			$('#refund').addClass('hide');
		}
	});


	$('#search-refund-by-ref').click(function(e){
		let input = $('#ref-for-refund').val();
		if(input == ''){
			let msg = $("<p class='red-text'>Refund reference can not be empty!</p>").fadeOut(5000);
			$('#refund').prepend(msg);
		}else{
			$.ajaxSetup({
		       headers: {
		       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		     }
		    });

		    $.ajax({
		    	url:window.location.href+'refund-order',
		    	type:'post',
		    	dataType:'json',
		    	data:{
		    		ref:input
		    	},
		    	success:function(e){
		    		console.log(e);
		    		if(Object.keys(e).length == 0){
		    			let msg = $("<p class='red-text'>Order not found or this order has been refunded already!</p>").fadeOut(5000);
		    			$('#refund').prepend(msg);
		    		}else{
		    			let html = "<div>"+"<span class='red-text col s12'>"+e.reference+ " "+"</span>"
		    					  +"<span class='col s3'>"+e.firstname + ' '+ e.lastname+"</span><br>"
		    					  +"<span class='col s4'>"+e.email+"</span>"
		    					  +"<button class='col s1 red white-text center' id='go-refund'>Refund</button>"
		    					  +"<input type='hidden' class='refund-order_id' value="+e.id_order+">"
		    					  +"</div>"
		    			$('.refund-order-details').html(html);

		    			$('#go-refund').click((e)=>{
		    				 $.ajax({
		    				 	url:window.location+'go-refund',
		    				 	type:'post',
		    				 	dataType:'json',
		    				 	data:{
		    				 		id:$('.refund-order_id').val()
		    				 	},
		    				 	success:function(res){
		    				 		if(res.updated == 1){
		    				 			let msg = '<span>Order Refunded!</span>';
		    				 			$('.refund-order-details').append(msg);
		    				 			$('.refund-order-details').children().remove()
		    				 		}
		    				 	}
		    				 })
		    			});
		    		}

		    	}
		    });

		}



	});

});
