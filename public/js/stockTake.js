console.log('R/place');

// const api = 'http://localhost/project/laravel/reward-test/public/api/';


var parent = new Vue({
  el:'#stockTake_HQ',
  data:{
    stockTakeList:[],
    search:'',
    styleObj:{
      'border':'1px solid red',
      'height':'30vh',
      'overflow':'auto'
    },
	shop_id:$('.stock_shopID').val(),
    username:$('.stock_username').val(),
    loading:true,
  },
  created(){
  	axios({
  		method:'post',
  		url:api+'branchStockTakeList',
  		data:{
  			shop_id:this.shop_id
  		}
  	}).then((res)=>{
  		console.log(res.data);
  		res.data.list.forEach((e)=>{
  			e.search = e.name.toLowerCase().concat(e.reference.toString().toLowerCase());
  		});

  		parent.stockTakeList = res.data.list;
  		this.loading = false;

        $('.show_branch_name').text(res.data.shopname[0].name);
  	})


  },
  methods:{

    tt:function(index,name,ref,stock_id,qty,$e){
      if(qty !== undefined && qty > 0 && qty !== ''){
        console.log(name,ref,stock_id,qty)

      let btn =  document.querySelector(`.a${stock_id}`);
          btn.disabled = true;
          btn.innerText = 'Updating...';

          console.log(qty)
          axios({
            method:'post',
            url:api+'saveToBranchStockTakeHistory',
            data:{
               pos_stock_id:stock_id,
               reference:ref,
               name:name,
               qty:qty,
               shop_id:parent.shop_id,
               username:parent.username,

            }
          }).then((response)=>{
            Materialize.toast(`<h6><span class="green-text">${ref}</span> has been updated!</h6>`, 1000);
            console.log(response.data)
              parent.stockTakeList.forEach((e)=>{
                e.updateQty = '';
              })

              $('.input_qty').val("");

              btn.disabled = false;
              btn.innerText = 'Update';

          }).catch(function(error){
            console.log(error)
          });
      }else{
        Materialize.toast(`<h6 class='red-text'>Can Not Sumbit Empty Value!</h6>`, 1000);
      }
    }
  },
  computed:{
    searchLower:function(){
      return this.search.toLowerCase();
    },
    filterStocks:function(){
      return this.stockTakeList.filter((stock)=>{
        return stock.search.match(this.searchLower);
      })
    }
  }

});


var add_missing = new Vue({
    el:'#adding_modal',
    data:{
        name:'',
        ref:'',
        qty:'',
        isdisabled:false,
        shop_id:$('.stock_shopID').val(),
        username:$('.stock_username').val()
    },
    methods:{
        reset:function(){
            this.name="";
            this.ref="";
            this.qty="";
        },
        addMissing:function(name,ref,qty){
            if(name !== '' && ref !== '' && qty > 0){
                this.isdisabled = true;
                axios({
                    method:'post',
                    url:api+'addMissing',
                    data:{
                        pos_stock_id:0,
                        name:name,
                        reference:ref,
                        qty:qty,
                        shop_id:this.shop_id,
                        username:this.username,
                        added:1
                    }
                }).then((res)=>{
                    console.log(res);
                    Materialize.toast(`<h6 class='green-text'>Data Submited!</h6>`, 1000);
                    this.isdisabled = false;
                    this.reset();



                });

            }else{
                alert('Please input valid value');
            }
        }
    }
});
