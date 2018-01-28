@extends('layouts.app')

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

    @include('_includes.timesheets.usertimesheet')

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

