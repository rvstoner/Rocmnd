@extends('layouts.manage')

@section('content')
<div class="flex-container">
  <div class="columns m-t-10">
    <div class="column">
      <h1 class="title">Add an Ip address</h1>
    </div>
  </div>
  <hr class="m-t-0">
  <div class="field">
    <div class="field">
      <label class="label">
        <div class="columns">
          <div class="column">
            Ip addressses
          </div>
        </div>
      </label>
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
        <p>This Facility has not been assigned any Ip addresses yet</p>
        @endforelse
      </ul>
    </div>
  </div>
  <form action="{{route('address.store')}}" method="POST">
    {{csrf_field()}}

    <div class="columns">
      <div class="column">
        <div class="field">
          <label for="addresss" class="label">Ip address:</label>
          <p class="control">
            <input type="text" class="input" name="address">
          </p>
        </div>
      </div>
    </div>

    <input type="hidden" name="facility_id" value="{{$facility->id}}" />
    <div class="columns">
      <div class="column">
        <hr />
        <button class="button is-primary is-pulled-right" style="width: 250px;">Add New Ip address</button>
      </div>
    </div>
  </form>
</div> <!-- end of .flex-container -->
@endsection

