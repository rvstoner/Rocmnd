@extends('layouts.app')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Edit Profile</h1>
      </div>
    </div>
    <hr class="m-t-0">

    <form action="{{route('profile.update', $user->id)}}" method="POST">
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
                <p class="control is-expanded">
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
                <p class="control is-expanded">
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
            <label class="label">Emergency Number:</label>
            <div class="field-body">
              <div class="field has-addons">
                <p class="control">
                  <a class="button is-static">
                    1
                  </a>
                </p>
                <p class="control is-expanded">
                  <input class="input" type="tel" name="emergency_phone_area" id="emergency_phone_area" placeholder="999" value="{{$user->emergency_phone_area}}">
                </p>
              </div>
              <div class="field">
                <p class="control is-expanded">
                  <input class="input" type="tel" name="emergency_phone_prefix" id="emergency_phone_prefix" placeholder="999" value="{{$user->emergency_phone_prefix}}">
                </p>
              </div>
              <div class="field">
                <p class="control is-expanded">
                  <input class="input" type="tel" name="emergency_phone_number" id="emergency_phone_number" placeholder="9999" value="{{$user->emergency_phone_number}}">
                </p>
              </div>
            </div>
          </div>

          <div class="field">
            <label for="password" class="label">Password:</label>
            <p class="control">
              <input type="password" class="input" name="password" id="password">
            </p>
          </div>

          <div class="field">
            <label for="password_confirm" class="label">Confirm Password:</label>
            <p class="control">
              <input type="password" class="input" name="password_confirm" id="password_confirm">
            </p>
          </div>
      
        <div class="field">
          <hr />
          <button class="button is-primary is-pulled-right" style="width: 250px;">Update Profile</button>
        </div>
      </div> <!-- end of .column -->
    </form>

  </div> <!-- end of .flex-container -->
@endsection


