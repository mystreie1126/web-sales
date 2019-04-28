const api = 'https://calm-anchorage-96610.herokuapp.com/http://stockupdateapi.funtech.ie/api/';


var record = new Vue({
    el:'.record',
    data:{
      records:[],
      shop_id:$('.stock_shopID').val()
    },
    methods:{
      editStockRecord:function(record_id,edited_qty,stock_id,id_product,e){
        var btn = e.target;
        btn.disabled = true;
        btn.innerText = 'loading..';
        console.log(e);
        axios({
          method:'post',
          url:api+'updateBranchRecord',
          data:{
            record_id:record_id,
            edited_qty:edited_qty,
            stock_id:stock_id,
            id_product:id_product
          }
        }).then((e)=>{
          console.log(e);
          btn.disabled = false;
          btn.innerText = 'submit';
          record.getHQrecordList();
        })
      },
      getHQrecordList:function(){
        axios({
          method:'post',
          url:api+'branchRecordList',
          data:{
            shop_id:this.shop_id
          }
        }).then((list)=>{
          console.log(list.data);
          list.data.forEach((e)=>{e.inputVal=""});
          this.records = list.data;
        })
      }
    },
    computed:{
      // searchLower:function(){
      //   return this.search.toLowerCase();
      // },
      // filterStocks:function(){
      //   return this.stocks.filter((stock)=>{
      //     return stock.search.match(this.searchLower);
      //   })
      // }
    },
    created(){
      this.getHQrecordList();
    }
});
