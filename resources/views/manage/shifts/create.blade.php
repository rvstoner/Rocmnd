@extends('layouts.manage')

@section('content')
  <div class="flex-container">
    <div class="columns m-t-10">
      <div class="column">
        <h1 class="title">Create New Shift</h1>
      </div>
    </div>
    <hr class="m-t-0">
    <div class="field">
      <div class="field">
        <label for="email" class="label">
          <div class="columns">
            <div class="column">
              Shifts
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
    <form action="{{route('shifts.store')}}" method="POST">
      {{csrf_field()}}
      
      <div class="select">
        <select name="shift">
          <option>Select shift</option>
          <option value="1">1st</option>
          <option value="2">2nd</option>
          <option value="3">3rd</option>
        </select>
      </div>
      <div class="m-t-15"></div>
      <template>
        <section>
          <b-field>
            <b-switch v-model="formatAmPm">AM/PM</b-switch>
          </b-field>
          <b-field label="Select start time">
            <b-timepicker
              name="shift_start"
              placeholder="Click to select..."
              icon="clock"
              :hour-format="format">
            </b-timepicker>
          </b-field>
        </section>
      </template>
      <div class="m-t-15"></div>
      <template>
        <section>
          <b-field label="Select end time">
            <b-timepicker
              name="shift_end"
              placeholder="Click to select..."
              icon="clock"
              :hour-format="format">
            </b-timepicker>
          </b-field>
        </section>
      </template>

      <input type="hidden" name="facility_id" value="{{$facility->id}}" />
      <div class="columns">
        <div class="column">
          <hr />
          <button class="button is-primary is-pulled-right" style="width: 250px;">Create New Shift</button>
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
        formatAmPm: false
      },
     computed: {
        format() {
            return this.formatAmPm ? '12' : '24'
        }
    }
    });
  </script>
@endsection
