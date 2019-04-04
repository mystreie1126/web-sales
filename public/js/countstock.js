
const progressbar = '<div class="progress">'+
				    '<div class="indeterminate"></div>'+
				 '</div>'

$(document).ready(function(){

	$("#myInput").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#branchStockList tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	 });



	$('.top-message').html(progressbar);
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	$.ajax({
		url:window.location.href+'branchStockInfo',
		type:'get',
		dataType:'json',
		success:function(response){
			$('.top-message').html('<span class="flow-text ">Please update following products:</span>');
			console.log(response);

			let html = '';

			response.forEach((e)=>{
				html += '<tr class="stockinfo_row">'+
							'<th class="indigo-text">'+e.name+'</th>'+
							'<th class="teal-text">'+e.reference+'</th>'+
							'<th>'+
								'<input type="number" class="update_stock_input center" required>'+
							'</th>'+
							'<th class="center">'+
								'<button class="updateToStock">Update</button>'+
							'</th>'+
							'<input type="hidden" value="'+e.branch_product_id+'" class="branch_product_id">'+
						'</tr>'
			});

			$('.stockinfo_branch').html(html);
			$('#myInput').removeClass('hide');
			
		}
	});
});