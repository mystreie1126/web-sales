 const rockpos_check = 'pos_confirm';
 const online_check = 'normal-confirm';

 $(document).ready(function() {
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
      /* ===========For Rockpos Users====================*/

      //1.Check new orders
        $('#check_order').click(function(e){
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
            dataType:'json',
            success:function(data){
              let htmlresult = '';
              console.log(data);
              data['order'].forEach((e)=>{
                 htmlresult+= "<tr class='new-order-info'><td class='indigo-text'>"+e.reference+"</td>"

                              // +"<td>"+e.firstname +" "+e.lastname+"</td>"
                              +"<td>"+e.email +"</td><td class='center'><button id='confirm-payment' class='btn-small green bold white-text left'>Confirm</button></td>"
                              +"<input type='hidden' class='cus_email' value="+e.email+">"
                              +"<input type='hidden' class='cus_firstname'value="+e.firstname+">"
                              +"<input type='hidden' class='cus_lastname'value="+e.lastname+">"

                              +"<input type='hidden' class='cus_credits'value="+e.credits+">"
                              +"<input type='hidden' class='cus_customer_id'value="+e.id_customer+">"
                              +"<input type='hidden' class='cus_product_name'value="+e.product_name+">"
                              +"<input type='hidden' class='cus_reference'value="+e.reference+">"

                              +"<input type='hidden' class='cus_order_id'value="+e.id_order+">"
                              +"<input type='hidden' class='cus_product_id'value="+e.product_id+">"
                              +"<input type='hidden' class='is_device'value="+1+">"
                              +"<input type='hidden' class='total_paid'value="+e.total_paid_tax_incl+">"


                              +"<input type='hidden' class='shopname'value="+data['staff'][0].name+">"
                              +"<input type='hidden' class='shop_id'value="+data['staff'][0].shop_id+">"
                              +"<input type='hidden' class='current_date' value="+new Date().toISOString().slice(0, 19).replace('T', ' ')+">"
                              ;
                              // +"</tr>";
              });

              $('#new-order').html(htmlresult);

              $('#new-order').on('click','#confirm-payment',function(e){
                //another ajax call
                 e.preventDefault();
                 $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                 $.ajax({
                   url:window.location.href+'createvoucher',
                   type:'post',
                   data:{
                     email:$(this).closest('tr').find('.cus_email').val(),
                     firstname:$(this).closest('tr').find('.cus_firstname').val(),
                     lastname:$(this).closest('tr').find('.cus_lastname').val(),
                     credits:$(this).closest('tr').find('.cus_credits').val(),
                     id_customer:$(this).closest('tr').find('.cus_customer_id').val(),
                     product_name:$(this).closest('tr').find('.cus_product_name').val(),
                     reference:$(this).closest('tr').find('.cus_reference').val(),
                     order_id:$(this).closest('tr').find('.cus_order_id').val(),
                     product_id:$(this).closest('tr').find('.cus_product_id').val(),
                     device:$(this).closest('tr').find('.is_device').val(),
                     total_paid:$(this).closest('tr').find('.total_paid').val(),
                     shopname:$(this).closest('tr').find('.shopname').val(),
                     shop_id:$(this).closest('tr').find('.shop_id').val(),
                     current_date:$(this).closest('tr').find('.current_date').val(),

                   },
                   dataType:'json',
                   success:function(customer_info){

                     //console.log($('#confirm-payment').closest('tr').find('.cus_customer_id').val(),$('#confirm-payment').closest('tr').find('.cus_reference').val());
                     $('#confirm-payment').replaceWith("<span class='left green-text'>Payment Confirmed</span>");
                     $('#confirm-payment').prop('disabled', true);

                     // $('#confirm-payment').css('border','none');
                     //$('#new-order').append(msg);
                     console.log(customer_info);
                     if(customer_info.rockpos == 1)
                     {
                         let rest = "<td class='left'>"+customer_info.credits+"euro</td><td><button id='voucherToRockpos' class='left white-text btn-small orange'>Send to Rockpos</td>";
                         $('.new-order-info').append(rest);

                         $('#new-order').on('click','#voucherToRockpos',function(e){


                           e.preventDefault();
                           $.ajaxSetup({
                              headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                          });

                          $.ajax({
                            url:window.location.href+'vouchertopos',
                            type:'post',
                            data:{
                              id_customer:customer_info.id_customer,
                              reference:customer_info.reference
                            },
                            dataType:'json',
                            success:function(response){
                              console.log(response);

                              $('#new-order').remove();
                              //$('#voucherToRockpos').closest('tr').remove();
                              // if(response.valid_voucher == 1){
                              //   $('#voucherToRockpos').replaceWith("<span class='orange-text'>Voucher in RockPos</span>");
                              // }else if(response.valid_voucher == 0){
                              //   $('#voucherToRockpos').replaceWith("<span class='left red-text'>No Voucher Available</span>");
                              // }
                            },
                            error:function(error){

                            }
                          });//end of third ajax call





                         });//send to rockpos action

                     }//end of rockposuser

                     else if(response.rockpos == 0){

                     }//end of nonposuser

                   },

                   error:function(x,h,c){

                   }
                 });//end of second ajax call
              });
            },
            error:function(x,h,r){
              console.log(x);
              $('#new-order').html('<p class="red-text">Login Expired!</p>')
            }
          });//end of ajax

        });

      //2.pull the voucher from online account

      $('#pull-with-email').click(function(e){
        e.preventDefault();
        let email = $.trim($("input[name='mail']").val());
        let url = window.location.href+'pullvoucher';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          url:url,
          type:'post',
          dataType:'json',
          data:{email:email},
          success:function(response){
            console.log(response);
          },
          error:function(response){

          }
        });

      });

});



//create the voucher
$(document).on('click', '#new-order', function(e)
{

   //let data = $('#voucher').find('tr');
   e.preventDefault();
   // this.closest('tr').remove();
   //console.log(data);
    // let url = window.location.href+'createvoucher';
    //   $.ajaxSetup({
    //       headers: {
    //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //       }
    //   });

    //   $.ajax({
    //     url:url,
    //     type:'post',
    //     dataType:'json',
    //     success:function(data){
    //       console.log(data);
    //     }
    //   });
});
