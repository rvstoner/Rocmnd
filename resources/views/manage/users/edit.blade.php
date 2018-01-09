@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Edit User</h1>
      </div>
    </div>
    <hr class="m-t-0">

    <form action="{{route('users.update', $user->id)}}" method="POST">
      {{method_field('PUT')}}
      {{csrf_field()}}
      <div class="columns">
        <div class="column">
          <div class="field">
            <label for="first_name" class="label">First Name:</label>
            <p class="control">
              <input type="text" class="input" name="first_name" id="first_name" value="{{$user->first_name}}">
            </p>
          </div>

          <div class="field">
            <label for="last_name" class="label">Last Name:</label>
            <p class="control">
              <input type="text" class="input" name="last_name" id="last_name" value="{{$user->last_name}}">
            </p>
          </div>

          <div class="field">
            <label class="label">Phone Number:</label>
            <div class="field-body">
              <div class="field has-addons">
                <p class="control">
                  <a class="button is-static">
                    1
                  </a>
                </p>
                <p class="control">
                  <input class="input" type="tel" name="home_phone_area" id="home_phone_area" placeholder="999" value="{{$user->home_phone_area}}">
                </p>
              </div>
              <div class="field">
                <p class="control is-expanded">
                  <input class="input" type="tel" name="home_phone_prefix" id="home_phone_prefix" placeholder="999" value="{{$user->home_phone_prefix}}">
                </p>
              </div>
              <div class="field">
                <p class="control is-expanded">
                  <input class="input" type="tel" name="home_phone_number" id="home_phone_number" placeholder="9999" value="{{$user->home_phone_number}}">
                </p>
              </div>
            </div>
          </div>

          <div class="field">
            <label class="label">Secondary Number:</label>
            <div class="field-body">
              <div class="field has-addons">
                <p class="control">
                  <a class="button is-static">
                    1
                  </a>
                </p>
                <p class="control">
                  <input class="input" type="tel" name="secondary_phone_area" id="secondary_phone_area" placeholder="999" value="{{$user->secondary_phone_area}}">
                </p>
              </div>
              <div class="field">
                <p class="control is-expanded">
                  <input class="input" type="tel" name="secondary_phone_prefix" id="secondary_phone_prefix" placeholder="999" value="{{$user->secondary_phone_prefix}}">
                </p>
              </div>
              <div class="field">
                <p class="control is-expanded">
                  <input class="input" type="tel" name="secondary_phone_number" id="secondary_phone_number" placeholder="9999" value="{{$user->secondary_phone_number}}">
                </p>
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
            <label for="password" class="label">Password</label>
            {{-- <b-radio-group> --}}
              <div class="field">
                <b-radio name="password_options" v-model="password_options" native-value="keep">Do Not Change Password</b-radio>
              </div>
              <div class="field">
                <b-radio name="password_options" v-model="password_options" native-value="auto">Auto-Generate New Password</b-radio>
              </div>
              <div class="field">
                <b-radio name="password_options" v-model="password_options" native-value="manual">Manually Set New Password</b-radio>
                <p class="control">
                  <input type="text" class="input" name="password" id="password" v-if="password_options == 'manual'" placeholder="Manually give a password to this user">
                </p>
              </div>
            {{-- </b-radio-group> --}}
          </div>
        </div> <!-- end of .column -->

        <div class="column">
          <label for="roles" class="label">Roles:</label>
          <input type="hidden" name="roles" :value="rolesSelected" />

            @foreach ($roles as $role)
              <div class="field">
                <b-checkbox v-model="rolesSelected" :native-value="{{$role->id}}">{{$role->display_name}}</b-checkbox>
              </div>
            @endforeach
        </div>
      </div>
      <div class="columns">
        <div class="column">
          <hr />
          <button class="button is-primary is-pulled-right" style="width: 250px;">Edit User</button>
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
        password_options: 'keep',
        rolesSelected: {!! $user->roles->pluck('id') !!}
      }
    });
  </script>
@endsection