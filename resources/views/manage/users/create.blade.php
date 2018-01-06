@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Create New User</h1>
      </div>
    </div>
    <hr class="m-t-0">
    <form action="{{route('users.store')}}" method="POST">
      {{csrf_field()}}
      <div class="columns">
        <div class="column">

          @permission('create-facilities')
          <div class="field">
            <label for="team" class="label">Facility</label>
            <p class="control">
              <div class="select is-rounded is-fullwidth">
                <select name="team">
                  @foreach($teams as $team)
                    <option value="{{$team->id}}" @if($team->id == Auth::user()->id) selected="selected"@endif>{{$team->display_name}}</option>
                  @endforeach
                </select>
              </div>            
            </p>
          </div>
          @endpermission

          <div class="field">
            <label for="name" class="label">Username</label>
            <p class="control">
              <input type="text" class="input" name="username" id="name">
            </p>
          </div>

          <div class="field">
            <label for="email" class="label">Email:</label>
            <p class="control">
              <input type="text" class="input" name="email" id="email">
            </p>
          </div>

          <div class="field">
            <label for="first_name" class="label">First Name</label>
            <p class="control">
              <input type="text" class="input" name="first_name" id="first_name">
            </p>
          </div>

          <div class="field">
            <label for="last_name" class="label">Last Name</label>
            <p class="control">
              <input type="text" class="input" name="last_name" id="last_name">
            </p>
          </div>

          <div class="field">
            <label for="password" class="label">Password</label>
            <p class="control">
              <input type="password" class="input" name="password" id="password" v-if="!auto_password" placeholder="Manually give a password to this user">
            </p>
          </div>

          <div class="field">
            <label for="password_confirmation" class="label" v-if="!auto_password">Confirm Password</label>
            <p class="control">
              <input type="password" class="input" name="password_confirmation" id="password" v-if="!auto_password" placeholder="Manually give a password to this user">
              <b-checkbox name="auto_generate" class="m-t-15" v-model="auto_password">Auto Generate Password</b-checkbox>
            </p>
          </div>
        </div> <!-- end of .column -->

        <div class="column">
          <label for="roles" class="label">Roles:</label>
          <input type="hidden" name="roles" :value="rolesSelected" />

            @foreach ($roles as $role)
              <div class="field">
                @permission(strtolower('create-' . $role->name))
                  <b-checkbox v-model="rolesSelected" :native-value="{{$role->id}}">{{$role->display_name}}</b-checkbox>
                @endpermission
              </div>
            @endforeach
        </div>
      </div> <!-- end of .columns for forms -->
      <div class="columns">
        <div class="column">
          <hr />
          <button class="button is-primary is-pulled-right" style="width: 250px;">Create New User</button>
        </div>
      </div>
    </form>
  </div> <!-- end of .flex-container -->
@endsection

@section('scripts')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        auto_password: true,
        rolesSelected: [{!! old('roles') ? old('roles') : '' !!}]
      }
    });
  </script>
@endsection