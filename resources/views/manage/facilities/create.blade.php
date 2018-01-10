@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Create New Facility</h1>
      </div>
    </div>
    <hr class="m-t-0">
    <form action="{{route('facilities.store')}}" method="POST">
      {{csrf_field()}}
      <div class="columns">
        <div class="column">
          <div class="field">
            <label for="name" class="label">Name</label>
            <p class="control">
              <input type="text" class="input" name="name" id="name">
            </p>
          </div>

          <div class="field">
            <label for="display_name" class="label">Display Name:</label>
            <p class="control">
              <input type="text" class="input" name="display_name" id="display_name">
            </p>
          </div>

          <div class="field">
            <label for="description" class="label">Description:</label>
            <p class="control">
              <input type="text" class="input" name="description" id="description">
            </p>
          </div>
        </div> <!-- end of .column -->
      </div> <!-- end of .columns for forms -->
      <div class="columns">
        <div class="column">
          <hr />
          <button class="button is-primary is-pulled-right" style="width: 250px;">Create New Facility</button>
        </div>
      </div>
    </form>
  </div> <!-- end of .flex-container -->
@endsection
