@extends('layouts.manage')

@section('content')

<form action="{{route('timesheets.update', $timepunch->id)}}" method="POST">
	{{method_field('PUT')}}
	{{csrf_field()}}
	<div class="columns">
		<div class="column is-narrow">
			<div class="m-t-85">	
				<strong>Clock In</strong> {{ $timepunch->clock_in->format('m/d/Y') }}
			</div>	            
		</div>
		<div class="column m-t-39">
			<template>
			    <b-field label="Select a date">
			        <b-datepicker 
		            	name="clockin_date"
			            placeholder="Edit clock in date"
			            icon="calendar-today">
			        </b-datepicker>
			    </b-field>
			</template>	
		</div>
		<div class="column is-narrow">
			<div class="m-t-85">
				{{ $timepunch->clock_in->format('h:i A') }}
			</div>
		</div>
		<div class="column">
			<template>
			    <section>
			        <b-field>
			            <b-switch v-model="formatAmPm">AM/PM</b-switch>
			        </b-field>
			        <b-field label="Select time">
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
		<div class="column is-narrow">
			<div class="m-t-45">	
				<strong>Clock Out</strong> {{ $timepunch->clock_out->format('m/d/Y') }}
			</div>	            
		</div>
		<div class="column">
			<template>
			    <b-field label="Select a date">
			        <b-datepicker
		            	name="clockout_date"
			            placeholder="Edit clock out date"
			            icon="calendar-today">
			        </b-datepicker>
			    </b-field>
			</template>	
		</div>
		<div class="column is-narrow">
			<div class="m-t-45">
				{{ $timepunch->clock_out->format('h:i A') }}
			</div>
		</div>
		<div class="column">
			<template>
			    <section>
			        <b-field label="Select time">
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
			    <input class="input is-primary" type="text" placeholder="Reason" name="reason">
			  </div>
			</div>
		</div>
	</div><div class="columns">
		<div class="column">
			<hr />
			<button class="button is-primary is-pulled-right" style="width: 250px;">Edit Time</button>
		</div>
	</div>
</form>



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
