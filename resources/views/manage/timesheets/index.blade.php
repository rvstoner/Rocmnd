@extends('layouts.manage')

@section('content')

	<section class="section">
	    <div class="container">
			<team-list
				:teams="{{$teams}}"
			></team-list>
	    </div>
	  </section>

@endsection

@section('scripts')
<script>
	var app = new Vue({
		el: '#app'
	});
</script>
@endsection