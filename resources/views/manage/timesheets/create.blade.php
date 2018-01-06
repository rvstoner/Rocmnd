@extends('layouts.manage')

@section('content')
<section class="section">
	<div class="container">
		<form action="{{route('timesheets.store')}}" method="POST">
			{{csrf_field()}}
			<div class="columns">
				<div class="column">
					<div class="columns">
						<div class="column">
							<div class="field is-horizontal">
								<div class="field-label is-normal">
									<label class="label">Name</label>
								</div>
								<div class="field-body">
									<div class="field is-narrow">
										<div class="control">
											<div class="select">
												<select name="user">
													@foreach($users as $user)
													<option>Choose a user</option>
													<option value={{$user->id}}>{{$user->getNameOrUsername()}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="column">
							<div class="field is-horizontal">
								<div class="field-label is-normal">
									<label class="label">Reason</label>
								</div>
								<div class="field-body">
									<div class="field is-narrow">
										<div class="control">
											<div class="select">
												<select name="reason">
													<option>Choose a reason for clock in</option>
													<option value="Scheduled">Scheduled</option>
													<option value="Called in">Called in</option>
													<option value="On call">On call</option>
													<option value="Meeting">Meeting</option>
													<option value="DR. Appointment">Dr. App</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<div class="column">
					<template>
						<b-field>
							<b-switch v-model="formatAmPm">AM/PM</b-switch>
						</b-field>
					</template>
				</div>	
			</div>

			<div class="columns">
				<div class="column">
					<template>
						<b-field label="Clock In date">
							<b-datepicker 
							name="clockin_date"
							placeholder="Edit clock in date"
							icon="calendar-today">
						</b-datepicker>
					</b-field>
				</template>	
			</div>
			<div class="column">
				<template>
					<section>
						<b-field label="Clock In time">
							<b-timepicker
							name="clockin_time"
							placeholder="Edit clock in time"
							icon="clock"
							:hour-format="format"
							:readonly="false">
						</b-timepicker>
					</b-field>
				</section>
			</template>
		</div>
	</div>
	<div class="columns">
		<div class="column">
			<template>
				<b-field label="Clock Out date">
					<b-datepicker
					name="clockout_date"
					placeholder="Edit clock out date"
					icon="calendar-today">
				</b-datepicker>
			</b-field>
		</template>	
	</div>
	<div class="column">
		<template>
			<section>
				<b-field label="Clock Out time">
					<b-timepicker
					name="clockout_time"
					placeholder="Edit clock out date"
					icon="clock"
					:hour-format="format"
					:readonly="false">
				</b-timepicker>
			</b-field>
		</section>
	</template>
</div>
</div>

<div class="columns">
	<div class="column">
		<div class="field">
			<div class="control">
				<input class="input is-primary" type="text" placeholder="Reason" name="edit_reason">
			</div>
		</div>
	</div>
</div>

<div class="columns">
	<div class="column">
		<hr />
		<button class="button is-primary is-pulled-right" style="width: 250px;">Save</button>
	</div>
</div>
</form>
</div>
</section>


@endsection

@section('scripts')
<script>
	var app = new Vue({
		el: '#app',
		data: {
			formatAmPm: false
		},
		computed: {
			format() {
				return this.formatAmPm ? '12' : '24'
			}
		}
	});
</script>
@endsection
