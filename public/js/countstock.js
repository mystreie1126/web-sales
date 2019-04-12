
const progressbar = '<div class="progress">'+
				    '<div class="indeterminate"></div>'+
				 '</div>'
var searchArr,filterArr;
var resultArr;


$(document).ready(function(){

	$('.top-message').html(progressbar);
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	$.ajax({
		url:window.location.href+'branchStockInfo',
		type:'get',
		dataType:'json',
		success:function(response){
			$('.top-message').html('<span class="flow-text ">Please update following products:</span>');
			
			searchArr = response;
			console.log(searchArr);
			let html = '';

			response.forEach((e)=>{
				html += '<li class="stockinfo_row collection-item  hide">'+
							'<span class="indigo-text flow-text">'+e.name+'</span>'+
							'<br>'+
							'<span class="teal-text flow-text">'+e.reference+'</span>'+
							'<span>'+
								'<input type="number" class="update_stock_input center" placeholder="input quantity here" required>'+
							'</span>'+
							'<span class="center">'+
								'<button class="updateToStock">Update</button>'+
							'</span>'+
							'<input type="hidden" value="'+e.branch_product_id+'" class="branch_product_id">'+
						'</li>'


			});

			$('.stockinfo_branch').html(html);
			searchArr = Array.from($('.stockinfo_row'));

			
		}
	});


	$('#myInput').on('keyup',function(e){

		if($(this).val().length > 1 && searchArr.length > 0 && $(this).val().length != ''){
			console.log($(searchArr[1]).text().toLowerCase());
			searchArr.forEach((e,i)=>{
				if(!$(e).hasClass('hide')) $(e).addClass('hide');
				if ($(e).text().toLowerCase().indexOf($(this).val().toLowerCase()) > -1)
				$(e).removeClass('hide');
			});

		}
				
	});

	$('.stockinfo_branch').on('click','.updateToStock',function(e){
		
		    let updateQty = $(this).parent().parent().find('.update_stock_input').val(),
		    	reference = $(this).parent().parent().find('.teal-text').text(),
		    	name      = $(this).parent().parent().find('.indigo-text').text(),
			pos_productID = $(this).parent().parent().find('.branch_product_id').val(),
				wholeRow  = $(this).parent().parent();

			if(updateQty != '' && updateQty > 0)

			{
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
			  	$.ajax({
				  	url:window.location.href+'UpdateBranchStock',
				  	type:'post',
				  	dataType:'json',
				  	data:{
				  		updateQty    :updateQty,
				  		pos_productID:pos_productID,
				  		reference    :reference
				  	},
				  	success:function(res){
				  		Materialize.toast('<span class="green-text bold">'+reference+' has been updated</span>', 1000);
				  		wholeRow.remove();
				  	}
			 	});
			}else{
			 	Materialize.toast('<span class="red-text bold">Valid Quantity Please</span>', 1000);
			 	// $(this).text('check');
			}
 	})

	

});