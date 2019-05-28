
var mystockTake = new Vue({
    el:'#mystockTake',
    data:{
        username:$('.stockTake_user').val(),
        shop_id:$('.stockTake_shopID').val()
    },
    methods:{
        myStockTake_records:function(){
            axios({
                method:'post',
                url:api+'myStockTake_records',
                data:{
                    shop_id:this.shop_id,
                    username:this.username
                }
            }).then((res)=>{

                console.log(res.data);

                var table = new Tabulator('.mystocktake_table',{
                  data:res.data.list,
                  layout:"fitColumns",
                  // height:"100vh",
                  placeholder:"No Data Available",
                  columns:[
                    {title:'Barcode',field:'ref',width:100},
                    {title:'Name',field:'product_name',width:200,cssClass:"indigo-text"},
                    {title:'Updated Quantity',field:'added_quantity',width:200,cssClass:"teal-text",align:"center"},
                    {title:'User',field:'username',width:100,cssClass:"purple-text"},
                    {title:'Branch',field:'shop_name',width:100},
                    {title:'Date_updated',field:'created_at',width:200,cssClass:"cyan-text"},
                    {title:'Added',field:'added',width:80,cssClass:"red-text"}
                  ]
              });

              this.addFilter(table);
              this.tableMessage(res.data[0].username);

            })
        },
        allStockTake_records:function(){
            axios({method:'post',data:{shop_id:this.shop_id},url:api+'allStockTake_records'}).then((res)=>{
                console.log(res.data);
                var table = new Tabulator('.mystocktake_table',{
                  data:res.data,
                  layout:"fitColumns",
                  // height:"100vh",
                  placeholder:"No Data Available",
                  columns:[
                    {title:'Barcode',field:'ref',width:100},
                    {title:'Name',field:'product_name',width:200,cssClass:"indigo-text"},
                    {title:'Updated Quantity',field:'added_quantity',width:200,cssClass:"teal-text",align:"center"},
                    {title:'User',field:'username',width:100,cssClass:"purple-text"},
                    {title:'Branch',field:'shop_name',width:100},
                    {title:'Date_updated',field:'created_at',width:200,cssClass:"cyan-text"},
                    {title:'Added',field:'added',width:80,cssClass:"red-text"}
                  ]
              });
              this.addFilter(table);
              this.tableMessage('All Users');

          });//end

        },
        stockTake_final_results:function(){
            axios({method:'post',data:{shop_id:this.shop_id},url:api+'stockTake_final_results'}).then((res)=>{
                console.log(res.data);
                var table = new Tabulator('.mystocktake_table',{
                  data:res.data,
                  layout:"fitColumns",
                  // height:"100vh",
                  placeholder:"No Data Available",
                  columns:[
                    {title:'Barcode',field:'ref',width:300},
                    {title:'Name',field:'product_name',width:300,cssClass:"indigo-text"},
                    {title:'Total Quantity',field:'total_updated',width:300,cssClass:"teal-text",align:"center"},
                  ]
              });
              this.addFilter(table);
              this.tableMessage('all quantities accumulated');

            });
        },
        addFilter:function(table){
          $('.mystocktake_filter_name').keyup(function(){
            table.setFilter('product_name','like',$('.mystocktake_filter_name').val())
          });

          $('.mystocktake_filter_ref').keyup(function(){
            table.setFilter('ref','like',$('.mystocktake_filter_ref').val())
          });

        },
        tableMessage:function(user){
            $('.table_message').text(`Stock take from ${user}`);
        }
    }
});
