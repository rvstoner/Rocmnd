@extends('layouts.manage')

@section('content')
<section class="section">
	<div class="container">
		<form action="{{route('reports.store')}}" method="POST">
			{{csrf_field()}}
			<div class="columns">
			
				<div class="column">
					@permission('create-facilities')
					<div class="field is-horizontal">
						<div class="field-label is-clearfix">
							<label for="team" class="label is-narrow">Facility</label>
						</div>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<div class="select is-rounded is-fullwidth">
										<select name="team_id">
											@foreach($teams as $team)
											<option value="{{$team->id}}" @if($team->id == Auth::user()->id) selected="selected"@endif >{{$team->display_name}}</option>
											@endforeach
										</select>
									</div>            
								</div>
							</div>
						</div>
					</div>
					@endpermission
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
						<b-field label="Date">
							<b-datepicker 
							name="date"							
							v-model="reportdate"
							placeholder="Set date"
							icon="calendar-today">
						</b-datepicker>
					</b-field>
				</template>	
			</div>
			<div class="column">
				<template>
					<section>
						<b-field label="Time">
							<b-timepicker
							name="time"
							v-model="reporttime"
							placeholder="Set time"
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
		<b-field>
			<b-input type="text" placeholder="Title" size="is-large" name="title" value="{{ $report->title }}">
			</b-input>
		</b-field>

		<b-field class="m-t-40">
			<b-input type="textarea"
			placeholder="Compose the report..." rows="20" name="body" value="{{ $report->body }}">
		</b-input>
	</b-field>

	</div>
</div>
<div class="columns">
	<div class="column">
		<div class="field">
			<p> Choose a color for the background</p>
		</div>
	</div>
</div>

<div class="columns">
	<div class="column">
		<div class="field">
			<div class="control">
				<label class="radio">
					<input type="radio" name='color' value="is-black" @if($report->class_type == "is-black") checked @endif>
					<span class="tag is-black"></span>
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-dark" @if($report->class_type == "is-dark") checked @endif>
					<span class="tag is-dark"></span>
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-light" @if($report->class_type == "is-light") checked @endif>
					<span class="tag is-light"></span>
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-white" @if($report->class_type == "is-white") checked @endif>
					<span class="tag is-white"></span>					
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-primary" @if($report->class_type == "is-primary") checked @endif>					
					<span class="tag is-primary"></span>
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-link" @if($report->class_type == "is-link") checked @endif>
					<span class="tag is-link"></span>
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-info" @if($report->class_type == "is-info") checked @endif>
					<span class="tag is-info"></span>
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-success" @if($report->class_type == "is-success") checked @endif>					
					<span class="tag is-success"></span>
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-warning" @if($report->class_type == "is-warning") checked @endif>
					<span class="tag is-warning"></span>										
				</label>
				<label class="radio">
					<input type="radio" name='color' value="is-danger" @if($report->class_type == "is-danger") checked @endif>
					<span class="tag is-danger"></span>
				</label>
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
			formatAmPm: false,
			reportdate: new Date("{!! $report->date->toDateTimeString() !!}"),
			reporttime: new Date("{!! $report->date->toDateTimeString() !!}"),
		},
		computed: {
	        format() {
	            return this.formatAmPm ? '12' : '24'
	        }
	    }
	});
</script>
@endsection
