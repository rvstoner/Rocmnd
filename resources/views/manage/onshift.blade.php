@extends('layouts.manage')

@section('content')

<div class="card">
	<div class="card-content">
		<table class="table is-narrow is-fullwidth">
			<thead>
				<tr>				
				<th>Name</th>
				</tr>
			</thead>

			<tbody>
			@foreach ($users as $user)
			<tr>
				<td>{{$user->getNameOrUsername()}}</td>
			</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div> <!-- end of .card -->
  
@endsection