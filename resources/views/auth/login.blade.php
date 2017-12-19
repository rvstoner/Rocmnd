@extends('layouts.app')

@section('content')

<div class="columns">
  <div class="column is-one-third is-offset-one-third m-t-100">
    <div class="card">
      <div class="card-content">
        <h1 class="title">Log In</h1>

        <form action="{{route('login')}}" method="POST" role="form">
          {{csrf_field()}}
          <div class="field">
            <label for="credentials" class="label">Email or Username</label>
            <p class="control">
              <input class="input {{$errors->has('credentials') ? 'is-danger' : ''}}" type="text" name="credentials" id="credentials" placeholder="name@example.com" value="{{old('credentials')}}">
            </p>
            @if ($errors->has('credentials'))
              <p class="help is-danger">{{$errors->first('credentials')}}</p>
            @endif
          </div>
          <div class="field">
            <label for="password" class="label">Password</label>
            <p class="control">
              <input class="input {{$errors->has('password') ? 'is-danger' : ''}}" type="password" name="password" id="password">
            </p>
            @if ($errors->has('password'))
              <p class="help is-danger">{{$errors->first('password')}}</p>
            @endif

          </div>

          <b-checkbox name="remember" class="m-t-20">Remember Me</b-checkbox>

          <button class="button is-success is-outlined is-fullwidth m-t-30">Log In</button>
        </form>
      </div> <!-- end of .card-content -->
    </div> <!-- end of .card -->
    <h5 class="has-text-centered m-t-20"><a href="{{route('password.request')}}" class="is-muted">Forgot Your Password?</a></h5>
  </div>
</div>

@endsection

@section('scripts')
  <script>
    var app = new Vue({
      el: '#app'
    });
  </script>
@endsection