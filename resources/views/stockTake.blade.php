@extends('template')
@include('navtop')
@section('content')
@if(Auth::check())

<div class="stockTake_page">

<div class="fixed-action-btn">
    <a class="btn-floating btn-large red waves-effect modal-trigger" href="#adding_modal">
      <i class="large material-icons">add</i>
    </a>
</div>

<div id="adding_modal" class="modal">
        <div class="row container center">
            <p class="col s12">If you can not find from the list, please add at here about what your have found.</p>

            <div class="input-field col s12">
              <input placeholder="Add Name" type="text" v-model="name">
            </div>

            <div class="input-field col s12">
              <input placeholder="Add Reference" type="text" v-model="ref">
            </div>

            <div class="input-field col s12">
              <input placeholder="Add Quantity" type="number" v-model="qty">
            </div>

            <button class="btn blue col s5 right" @click.prevent="addMissing(name,ref,qty)" :disabled='isdisabled'>Add</button>
        </div>

 </div>



  <div id="stockTake_HQ" class="container">

      <span class="right" style="font-size:1.2rem;">
          Branch:
          <span class="teal-text show_branch_name"></span><br>
          Stock-Take By:
          <span class="red-text">{{Auth::User()->name}}</span><br>
          <button class="btn amber" v-on:click.prevent="reset_input()">Clear Search</button>

      </span>

      <input type="hidden" value="{{Auth::User()->shop_id}}" class="stock_shopID">
      <input type="hidden" value="{{Auth::User()->name}}" class="stock_username">

      <input type="hidden" name="" value="">
      <input type="text" v-model="search" placeholder="Search by refernce or name" class="searchable">



      <div class="preloader-wrapper big active pre-loader" v-if="loading">
        <div class="spinner-layer spinner-blue-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div><div class="gap-patch">
            <div class="circle"></div>
          </div><div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>



      <div v-if="stockTakeList.length > 0" v-for="(stock,index) in filterStocks" v-bind:style="{'border':'1px dotted teal'}">
        <div class="test_1">
            <div @style="styleObj" class="row">
              <h5 class="col s8 m8 l8 indigo-text text-darken-4">@{{stock.name}}</h5>
              <input type="number" class="col s4 m4 l4 input_qty" v-model="stock.updateQty" placeholder="Found Quantity">

              <h5 class="col s6 m6 l6 orange-text" >@{{stock.reference}}</h5>

              <button type="button" v-bind:class="['btn-large','a'+stock.pos_stock_id,'teal lighten-2 col s6 m6 l6 right']"
              v-on:click.prevent="tt(index,stock.name,stock.reference,stock.pos_stock_id,stock.updateQty,$event)"
              v-bind:style="{'marginBottom':'10px'}">
                Submit
              </button>
              </div>
        </div>

    </div>

    </div>

</div>
@stop
@push('stockTake')
  <script type="text/javascript" src="{{URL::asset('js/stockTake.js')}}"></script>
@endpush
@else
    <h3>Please Loggin</h3>
@endif
