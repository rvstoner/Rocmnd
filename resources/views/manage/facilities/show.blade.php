@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">View Facility Details</h1>
      </div> <!-- end of column -->

      <div class="column">
        <a href="{{route('facilities.edit', $facility->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-user m-r-10"></i> Edit Facility</a>
      </div>
    </div>
    <hr class="m-t-0">

    <div class="columns">
      <div class="column">
        <div class="field">
          <label for="name" class="label">Name</label>
          <pre>{{$facility->display_name}}</pre>
        </div>

        <div class="field">
          <div class="field">
            <label for="email" class="label">Discription</label>
            <pre>{{$facility->description}}</pre>
          </div>
        </div>

        <div class="field">
          <div class="field">
            <label for="email" class="label">
              <div class="columns">
                <div class="column">
                  Shifts
                </div>
                <div class="column">
                  <a href="{{route('shifts.create', $facility->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-user m-r-10"></i>Add a shift.</a>
                </div>
              </div>
            </label>
            <ul>
              @forelse ($facility->shifts as $shift)
                <li>
                  <div class="columns">
                    <div class="column">
                      <strong>Shift:</strong> {{$shift->shift}} 
                    </div>
                    <div class="column">
                      <strong>Clock in:</strong> {{Carbon\Carbon::now()->hour($shift->shift_start)->minute('00')->format('h:i A')}} 
                    </div>
                    <div class="column">
                      <strong>Clock out:</strong> {{Carbon\Carbon::now()->hour($shift->shift_end)->minute('00')->format('h:i A')}}
                    </div>
                    <div class="column">
                    <a href="{{route('shifts.edit', $facility->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-user m-r-10"></i> Edit shift</a>
                    </div>
                  </div>
                </li>
              @empty
                <p>This Facility has not been assigned any shifts yet</p>
              @endforelse
            </ul>
          </div>
        </div>

        <div class="field">
          <div class="field">
            <label for="email" class="label">Staff</label>
            <ul>
              @forelse ($facility->users as $user)
      					@forelse ($user->roles as $role)
      						<li><strong>{{$role->display_name}}</strong></li>
      					@empty
      						<p>This user has not been assigned any roles yet</p>
      					@endforelse
                <li>{{$user->getNameOrUsername()}}</li>
              @empty
                <p>This Facility has not been assigned any staff yet</p>
              @endforelse
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

