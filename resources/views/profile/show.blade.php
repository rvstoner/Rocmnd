@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Details for {{ $user->getNameOrUsername() }}</h1>
      </div> <!-- end of column -->

      <div class="column">
        <a href="{{route('profile.edit', $user->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-user m-r-10"></i> Edit Profile</a>
      </div>
    </div>
    <hr class="m-t-0">

  <div class="columns">
    <div class="column">
      <template>
        <section>

          <b-collapse :open="false">
            <button class="button is-primary" slot="trigger">Time punches</button>
            <div class="notification">
              <div class="content">

              	<table class="table is-bordered is-striped is-narrow is-fullwidth">
              		@forelse($user->payroll->period->weeks as $week)
              		<tr>
              			<th scope="col" colspan='2'>{{$week->start->format('m/d/Y')}} to {{ $week->end->format('m/d/Y') }}</th>
              			<th>Hours {{ floor($week->hours/60/60) }}:{{ gmdate("i", $week->hours) }}</th>
              			<th>Roll over {{ floor($week->rollover/60/60) }}:{{ gmdate("i", $week->rollover) }}</th>
              			<th>OT {{ floor($week->overtime/60/60) }}:{{ gmdate("i", $week->overtime) }}</th>
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
              			
              		</tr>					
              		@endif
              		@empty
              		@endforelse
              		@endif
              		@empty
              		@endforelse
              	</table>

              </div>
            </div>
          </b-collapse>

        </section>
      </template>
    </div>
  </div>

    <div class="columns">
      <div class="column">

      	<div class="field">
      		<div class="columns">
				<div class="column">
					<label for="pto" class="label">PTO</label>
					<pre>{{$user->pto}}</pre>
		        </div>
				<div class="column">
					<label for="holiday" class="label">Holiday</label>
					<pre>{{$user->holiday}}</pre>
		        </div>
	        </div>
        </div>
        
        <div class="field">
          <label for="role" class="label">Role</label>
          <ul>
            @forelse ($user->roles as $role)
              <pre><li>{{$role->display_name}} ({{$role->description}})</li></pre>
            @empty
              <p>This user has not been assigned a role yet</p>
            @endforelse
          </ul>
        </div>

        <div class="field">
          <label for="name" class="label">Name</label>
          <pre>{{$user->getNameOrUsername()}}</pre>
        </div>
        
        <div class="field">
        	<div class="columns">
				<div class="column">
					<label for="home_phone" class="label">Primary Phone</label>
					<pre>({{$user->home_phone_area}}){{$user->home_phone_prefix}}-{{$user->home_phone_number}}</pre>
				</div>
        
		        <div class="column">
		          <label for="secondary_phone" class="label">Secondary Phone</label>
		          <pre>({{$user->secondary_phone_area}}){{$user->secondary_phone_prefix}}-{{$user->secondary_phone_number}}</pre>
		        </div>
	        
		        <div class="column">
		          <label for="emergency_phone" class="label">Emergency contact</label>
		          <pre>({{$user->emergency_phone_area}}){{$user->emergency_phone_prefix}}-{{$user->emergency_phone_number}}</pre>
		        </div>
	        </div>
        </div>
       
          <div class="field">
            <label for="address" class="label">Address</label>
            <pre>{{$user->address}}</pre>
          </div> 
          <div class="columns">
            <div class="column">
              <div class="field">
                <label for="address_city" class="label">City</label>
                <pre>{{$user->address_city}}</pre>
              </div>
            </div>
            <div class="column">
              <div class="field">
                <label for="address_state" class="label">State</label>
                <pre>{{$user->address_state}}</pre>
              </div>
            </div>
            <div class="column">
              <div class="field">
                <label for="address_zip" class="label">Zip</label>
                <pre>{{$user->address_zip}}</pre>
              </div>
            </div>
          </div>
        
        <div class="field">
          <label for="email" class="label">Email</label>
          <pre>{{$user->email}}</pre>
        </div>
        
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        isOpen: true
      }
    });
  </script>
@endsection