@extends('layouts.manage')

@section('content')
<table class="table table-responsive table-bordered">
	<tr>
		<th scope="col">{{ $timepunch->user->getNameOrUsername() }}</th>
		<th scope="col">Clock in</th>
		<th scope="col">Clock out</th>
		<th></th>
	</tr>
	<tr>
		<td scope="col"></td>
		<td scope="col">{{ $timepunch->clock_in }}</td>
		<td scope="col">{{ $timepunch->clock_out }}</td>
		<td>
			@permission(strtolower('update-' . $timepunch->user->roles->first()->name))
				<a class="button is-danger is-outlined" href="{{route('timesheets.edit', $timepunch->id)}}">Edit</a>
			@endpermission
		</td>
	</tr>
	@if($timepunch->reason)
		<tr>
			<th scope="col" colspan='4'>Reason: {{ $timepunch->reason }}</th>
		</tr>
	@endif
	@if($timepunch->edited)
		<tr>
			<th scope="col" colspan='4'>Edited by {{ $timepunchedit->user->getNameOrUsername() }}</th>
		</tr>
		<tr>
			<th scope="col">Original</th>
			<td scope="col">{{ $timepunchedit->clock_in }}</td>
			<td scope="col">{{ $timepunchedit->clock_out }}</td>
			<td></td>
		</tr>
		@if($timepunchedit->reason)
			<tr>
				<th scope="col" colspan='4'>Reason: {{ $timepunchedit->reason }}</th>
			</tr>
		@endif
	@endif

</table>
@endsection
