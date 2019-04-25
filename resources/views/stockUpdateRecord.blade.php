@extends('template')
@include('navtop')
@section('content')
@if(Auth::check())
  <input type="hidden" value="{{Auth::User()->shop_id}}" class="stock_shopID">
  <div class="record">
    {{-- <input type="text" v-model="search"> --}}
    <ul class="collection" v-for="record in records" >

      <li class="collection-item row">
          <h5 class="indigo-text col s12">@{{record.reference}}</h5>
          <h5 class="teal-text col s12"> @{{record.name}}</h5>

          <span class="col s12">Created:<span class="orange-text">@{{record.created_at}}</span></span>
          <span class="col s12">Updated:<span class="red-text">@{{record.updated_at}}</span></span>

         <h3 class="col s3 indigo-text">@{{record.updated_qty}}</h3>


           <input type="number" class="col s4 center" required v-model="record.edited_qty" v-bind:style="{'transform':'translate(-20px,20px)'}">

          <button type="button" class="col s5 btn"
          v-bind:style="{'transform':'translate(-20px,25px)'}"
          v-on:click.prevent="editStockRecord(record.id,record.edited_qty,record.stock_id,record.id_product,$event)"
          >submit</button>

      </li>
    </ul>
  </div>
@push('countStock')
  <script type="text/javascript" src="{{URL::asset('js/updateRecord.vue.js')}}"></script>
@endpush

  @endif
  @stop
