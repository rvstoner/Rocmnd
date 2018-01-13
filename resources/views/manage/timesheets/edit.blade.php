@extends('layouts.manage')

@section('content')
<section class="section">
	<div class="container">
<form action="{{route('timesheets.update', $timepunch->id)}}" method="POST">
	{{method_field('PUT')}}
	{{csrf_field()}}
	<div class="columns">
		<div class="column is-narrow">
			<div class="m-t-85">	
				<strong>Clock In</strong>
			</div>	            
		</div>
		<div class="column m-t-39">
			<template>
			    <b-field label="Select a date">
			        <b-datepicker 
		            	v-model="clockinDate"
		            	name="clockin_date"
			            placeholder="Edit clock in date"
			            icon="calendar-today">
			        </b-datepicker>
			    </b-field>
			</template>	
		</div>
		<div class="column is-narrow">
			<div class="m-t-85">
				
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
    				        v-model="clockinTime"
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
				<strong>Clock Out</strong>
			</div>	            
		</div>
		<div class="column">
			<template>
			    <b-field label="Select a date">
			        <b-datepicker
				        v-model="clockoutDate"
		            	name="clockout_date"
			            placeholder="Edit clock out date"
			            icon="calendar-today">
			        </b-datepicker>
			    </b-field>
			</template>	
		</div>
		<div class="column is-narrow">
			<div class="m-t-45">
				
			</div>
		</div>
		<div class="column">
			<template>
			    <section>
			        <b-field label="Select time">
			            <b-timepicker
			            	name="clockout_time"
					        v-model="clockoutTime"
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
</div>
</section>

@endsection

@section('scripts')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        formatAmPm: false,
        clockinDate: new Date("{!! $timepunch->clock_in->toDateTimeString() !!}"),
        clockoutDate: new Date("{!! empty($timepunch->clock_out)? Carbon\Carbon::now()->toDateTimeString(): $timepunch->clock_out->toDateTimeString() !!}"),
        clockinTime: new Date("{!! $timepunch->clock_in->toDateTimeString() !!}"),
        clockoutTime: new Date("{!! empty($timepunch->clock_out)? Carbon\Carbon::now()->toDateTimeString(): $timepunch->clock_out->toDateTimeString() !!}")
      },
     computed: {
        format() {
            return this.formatAmPm ? '12' : '24'
        }
    }
    });
  </script>
@endsection
