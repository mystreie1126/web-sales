<div class="search-container">
	<form action="{{route('search')}}" method="POST" class="search-form">
		<div class="input-field">
			<input type="text" placeholder="Search the order invoice" id="reference" class="validated" name="reference">
			<label for="reference">Reference Number</label>
		</div>

		<input type="submit" value="search">
		{{csrf_field()}}
	</form>
</div>