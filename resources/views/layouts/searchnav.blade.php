<div class="search-container">
	<form action="{{route('search')}}" method="POST" class="search-form">
		<select>
		      <option value="" disabled selected>Search by:</option>
		      <option value="1">Order Reference</option>
		      <option value="2">Device IMEI</option>
		
   		 </select>

		<div class="input-field">
			<input type="text" placeholder="Search the order invoice" id="reference" class="validated" name="reference">
		</div>

		<input type="submit" value="search" class="btn">
		{{csrf_field()}}
	</form>
</div>