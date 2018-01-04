
@if (count($errors)) 
<div class="columns is-mobile is-centered">
  <div class="column is-half is-narrow">
    <div class="notification is-danger">
    	@foreach($errors->all() as $error)

			<p>{{ $error }}</p>

		@endforeach
	</div> 
  </div>
</div>
	

	

@endif 