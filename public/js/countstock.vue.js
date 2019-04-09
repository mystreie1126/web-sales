var countStock = new Vue({
	el:'.countStock',
	data:{
		products:[],
		searchInput:''
		
	},
	methods:{
		calling:function (userInput){
			axios({
				method:'post',
				input:userInput,
				url:window.location.href+'branchStockInfo'
			}).then(function(re){
				console.log(re.data);
				countStock.products = re.data
			});
		},
		test:function(i){
			console.log('test it'+i)
		}
	},
	mounted:function(){
		// this.calling();
	},
	watch:{
		searchInput:function(){
			if(this.searchInput.length > 2){
				this.calling(this.searchInput)
				this.products=[	]
			}
		}
	}
});

console.log(countStock._data.name);