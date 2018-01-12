@extends('layouts.manage')

@section('content')

<section class="section">
  <div class="container">
    <h1 class="title">Manage P.T.O. for {{ $user->getNameOrUsername() }}</h1>
    {{-- <h2 class="subtitle"> --}}
      <form role="form" method="POST" action="{{ route('pto.update', $user->id) }}">
        {{method_field('PUT')}}
        {{ csrf_field() }}
        <div class="columns">
          <div class="column">

            <div class="field">
              <label for="pto" class="label">Curent P.T.O.:</label>
              <p class="control">
                <input type="text" class="input" name="pto" id="pto" value="{{$user->pto}}">
              </p>
            </div>

            <div class="field">
              <label for="pto_amount" class="label">P.T.O. to Add:</label>
              <p class="control">
                <input type="text" class="input" name="pto_amount" id="pto_amount" value="{{$user->pto_amount}}">
                <input type="hidden" class="input" name="id" id="id" value="{{$user->id}}">
              </p>
            </div>

          </div>
        </div>           
        <input class="button is-primary" type="submit" value="Update">
      </form>
    {{-- </h2> --}}
  </div>
</section>

@endsection