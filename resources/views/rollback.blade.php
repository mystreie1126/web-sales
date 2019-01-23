@extends('template')
@include('navtop')

<div id="rollback" class="container">
	
    <label for="track-ref">Entry Barcode</label>
    <input id="track-ref" type="text" class="validate">
    <button class="btn  light-blue darken-2" id="search-track-ref">Search</button>

    <div class="rollback-details">
    	
    </div>
    <div>
    	<button id='roll-back-entry'class='hide btn'>Re-open the Entry</button>
    	<button id='remove-part-usage' class='hide btn indigo'>Remove Parts</button>
    </div>
</div>

@section('content')