@extends('layouts.manage')

@section('content')
<table class="table table-responsive table-bordered">
	@foreach($teams as $team)
		<tr>
			<th colspan='10'>{{$team->display_name}}</th>
		</tr>
		<tr>
			<th scope="col">Name</th>
			@foreach($team->users->first()->payroll->period->period as $week)
			<th scope="col" colspan='2'>
				{{$week->start->format('m/d/Y')}} to {{ $week->end->format('m/d/Y') }}</th>
				@if ($loop->first)
			        <th scope="col">Rollover</th>
			    @endif
			@endforeach
				<th scope="col">Hours</th>
				<th scope="col">Overtime</th>
		</tr>
		@foreach($team->users as $user)
			<tr>
				<td><a href="{{ url('/usertimesheet',$user->id) }}">{{ $user->getNameOrUsername() }}</a></td>
				@foreach($user->payroll->period->period as $week)
				<td>Hours {{ floor($week->hours/60/60) }}:{{ gmdate("i", $week->hours) }}</td>
				<td>OT {{ floor($week->overtime/60/60) }}:{{ gmdate("i", $week->overtime) }}</td>
				@if ($loop->first)
					<td>{{ floor($week->rollover/60/60) }}:{{ gmdate("i", $week->rollover) }}</td>
				@endif
				@endforeach
				<td>{{ floor($user->payroll->period->hours/60/60) }}:{{ gmdate("i", $user->total_hours) }}</td>
				<td>{{ floor($user->payroll->period->overtime/60/60) }}:{{ gmdate("i", $user->total_overtime) }}</td>
			</tr>
		@endforeach
	@endforeach
</table>
@endsection