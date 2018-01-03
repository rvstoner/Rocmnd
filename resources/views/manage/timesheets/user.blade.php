@extends('layouts.manage')

@section('content')


<table class="table is-bordered is-striped is-narrow is-fullwidth">
	<tr>
		<th colspan='2'>{{ $user->getNameOrUsername() }}</th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	@forelse($user->payroll->period->weeks as $week)
		<tr>
			<th scope="col" colspan='2'>{{$week->start->format('m/d/Y')}} to {{ $week->end->format('m/d/Y') }}</th>
			<th>Hours {{ floor($week->hours/60/60) }}:{{ gmdate("i", $week->hours) }}</th>
			<th>Roll over {{ floor($week->rollover/60/60) }}:{{ gmdate("i", $week->rollover) }}</th>
			<th>OT {{ floor($week->overtime/60/60) }}:{{ gmdate("i", $week->overtime) }}</th>
			<td></td>
			<td></td>
		</tr>
		@if(array_has($week, 'timepunches'))
		    @forelse($week->timepunches as $timepunch)
		        <tr>
					<th scope="col" colspan='2'>Reason: 
						@if($timepunch->reason)
							{{ $timepunch->reason }}
						@endif
					</th>
					<td scope="col">{{ $timepunch->clock_in->toDayDateTimeString() }}</td>
					<td scope="col">{{ $timepunch->clock_out->toDayDateTimeString() }}</td>
					<td>Hours</td>
					<td>{{ floor(($timepunch->clock_out->timestamp - $timepunch->clock_in->timestamp)/60/60) }}:{{ gmdate("i", ($timepunch->clock_out->timestamp - $timepunch->clock_in->timestamp)) }}</td>
					<td>
						@permission(strtolower('update-' . $timepunch->user->roles->first()->name))
							<a class="button is-danger is-outlined" href="{{route('timesheets.edit', $timepunch->id)}}">Edit</a>
						@endpermission
					</td>
				</tr>
				
				@if($timepunch->edited)
					<tr>
						<th scope="col" colspan='5'>Edited by {{ $timepunchedit->user->getNameOrUsername() }}</th>
					</tr>
					<tr>
						<th scope="col" colspan='2'>Reason: @if($timepunchedit->reason){{ $timepunchedit->reason }}@endif</th>
						<th scope="col">Original</th>
						<td scope="col">{{ $timepunchedit->clock_in }}</td>
						<td scope="col">{{ $timepunchedit->clock_out }}</td>
						<td></td>
					</tr>					
				@endif
			@empty
		    @endforelse
		@endif
	@empty
	@endforelse
</table>
@endsection
