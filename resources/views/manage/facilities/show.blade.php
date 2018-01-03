@extends('layouts.manage')

@section('content')
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column">
        <h1 class="title">View Facility Details</h1>
      </div> <!-- end of column -->

      <div class="column">
        <a href="{{route('facilities.edit', $facility->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-pencil-square-o m-r-10"></i> Edit Facility</a>
      </div>
    </div>
    <hr class="m-t-0">
    <h2 class="subtitle">
      Name: <pre>{{$facility->display_name}}</pre>
    </h2>
    <h2 class="subtitle">
      Discription: <pre>{{$facility->description}}</pre>
    </h2>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column">
        <h1 class="title">Shifts</h1>
      </div> <!-- end of column -->

      <div class="column">
        <a href="{{route('shifts.create', $facility->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-plus-square m-r-10"></i>Add a shift.</a>
      </div>
    </div>
    <hr class="m-t-0">
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
            <a href="{{route('shifts.edit', $shift->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-pencil-square-o m-r-10"></i> Edit shift</a>
          </div>
        </div>
      </li>
      @empty
      <p>This Facility has not been assigned any shifts yet</p>
      @endforelse
    </ul>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column">
        <h1 class="title">Ip addresses</h1>
      </div> <!-- end of column -->

      <div class="column">
        <a href="{{route('address.create', $facility->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-plus-square m-r-10"></i>Add an ip address.</a>
      </div>
    </div>
    <hr class="m-t-0">
    <ul>
      @forelse ($facility->addresses as $ip)
      <li>
        <div class="columns">
          <div class="column">
            <strong>Ip address:</strong> {{$ip->address}} 
          </div>
          <div class="column">
            <a href="{{route('address.edit', $ip->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-pencil-square-o m-r-10"></i> Edit Ip address</a>
          </div>
        </div>
      </li>
      @empty
      <p>This Facility has not been assigned any ip addresses yet</p>
      @endforelse
    </ul>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column">
        <h1 class="title">Staff</h1>
      </div> <!-- end of column -->
    </div>
    <hr class="m-t-0">
    <ul>
      @forelse ($facility->users as $user)
        @forelse ($user->roles as $role)
          <li><strong>{{$role->display_name}}</strong></li>
        @empty
          <p>This user has not been assigned any roles yet</p>
        @endforelse
          <li><a href="{{route('users.show', $user->id)}}">{{$user->getNameOrUsername()}}</a></li>
      @empty
        <p>This Facility has not been assigned any staff yet</p>
      @endforelse
    </ul>
  </div>
</section>
@endsection

