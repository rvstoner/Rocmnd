@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">View User Details</h1>
      </div> <!-- end of column -->

      <div class="column">
        @permission(strtolower('update-' . $user->roles->first()->name))
          <a href="{{route('users.edit', $user->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-user m-r-10"></i> Edit User</a>
        @endpermission
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
                @forelse($user->timepunches as $timepunch)
                <div class="columns">
                  <div class="column">
                    <strong>Date:</strong> {{ $timepunch->shift_date->format('m/d/Y') }}
                  </div> 
                  <div class="column">
                    <strong>Clock in:</strong> {{ $timepunch->clock_in->format('h:i A') }}
                  </div>
                  <div class="column">
                    @if(!empty($timepunch->clock_out))
                    <strong>Clock out:</strong> {{ $timepunch->clock_out->format('h:i A') }}
                    @else
                    <strong>Clock out:</strong> {{ Carbon\Carbon::now()->format('h:i A') }}
                    @endif
                  </div>
                  <div class="column">
                    @permission(strtolower('update-' . $user->roles->first()->name))
                    <a class="button is-danger is-outlined is-pulled-right" href="{{route('timesheets.edit', $timepunch->id)}}">Edit</a>
                    @endpermission
                  </div>
                </div>
                @empty
                  <p>This this user has not worked any shifts yet!</p>
                @endforelse
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
          <label for="role" class="label">Position</label>
          <ul>
            @forelse ($user->roles as $role)
              <pre><li>{{$role->display_name}}</li></pre>
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
          <label for="home_phone" class="label">Primary Phone</label>
          <pre>({{$user->home_phone_area}}){{$user->home_phone_prefix}}-{{$user->home_phone_number}}</pre>
        </div>
        
        <div class="field">
          <label for="secondary_phone" class="label">Secondary Phone</label>
          <pre>({{$user->secondary_phone_area}}){{$user->secondary_phone_prefix}}-{{$user->secondary_phone_number}}</pre>
        </div>
        
        <div class="field">
          <label for="emergency_phone" class="label">Emergency contact</label>
          <pre>({{$user->emergency_phone_area}}){{$user->emergency_phone_prefix}}-{{$user->emergency_phone_number}}</pre>
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