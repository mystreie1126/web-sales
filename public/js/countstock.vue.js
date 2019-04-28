//const api = 'http://localhost/project/laravel/countapi/public/api';

    // Your code to run since DOM is loaded and ready

const api = 'https://calm-anchorage-96610.herokuapp.com/http://stockupdateapi.funtech.ie/api/';
//console.log(api+'/hq-stockList');

var parent = new Vue({
  el:'.parent',
  data:{
    stocks:[],
    search:'',
    styleObj:{
      'border':'1px solid red',
      'height':'30vh',
      'overflow':'auto'
    },
		shop_id:$('.stock_shopID').val()
  },
  created(){
		//console.log(this.shop_id)
    axios({method:'post',url:api+'pos-stockList',data:{shop_id:this.shop_id}}).then(function(res){
      res.data.forEach((e)=>{
        e.search = e.name.toLowerCase().concat(e.ref.toString().toLowerCase());
      });
      parent.stocks = res.data;
      console.log(res.data);

    }).catch(function(error){
      console.log(error)
    });
  },
  methods:{

    tt:function(index,ref,id_product,stock_id,qty,$e){
      if(qty !== undefined && qty >= 0){
        console.log(ref,id_product,stock_id,qty)

      let btn =  document.querySelector(`.a${stock_id}`);
          btn.disabled = true;
          btn.innerText = 'Updating...';

        //this.stocks = this.stocks.filter((e,i)=>{return e.stock_id !== stock_id});

          axios({
            method:'post',
            url:api+'updateBranchStock',
            data:{
              id_product:id_product,
              stock_id:stock_id,
              qty:qty,
              ref:ref,
							shop_id:this.shop_id
            }
          }).then((response)=>{
            console.log(response.data)
            btn.parentNode.remove();
          }).catch(function(error){
            console.log(error)
          });
      }
    }
  },
  computed:{
    searchLower:function(){
      return this.search.toLowerCase();
    },
    filterStocks:function(){
      return this.stocks.filter((stock)=>{
        return stock.search.match(this.searchLower);
      })
    }
  }

});
