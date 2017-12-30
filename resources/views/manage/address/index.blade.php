@extends('layouts.manage')

@section('content')
<div class="flex-container">
  <div class="columns m-t-10">
    <div class="column">
      <h1 class="title">Manage Facilities</h1>
    </div>
    <div class="column">
    </div>
  </div>
  <hr class="m-t-0">

  <div class="card">
    <div class="card-content">
      <table class="table is-narrow is-fullwidth">
        <thead>
          <tr>
            <th>Facility</th>
            <th>Ip Address</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @if(!$facilities->count())
          @else
            @foreach ($facilities as $facility)
              <tr>
                <td>{{ $facility->display_name }}</td>
                <td></td>
                <td>
                  {{-- @permission('create-facilities') --}}
                    <a href="{{route('address.create', $facility->id)}}" class="button is-primary is-pulled-right"><i class="fa fa-user-plus m-r-10"></i> Add an Ip address</a>
                  {{-- @endpermission --}}
                </td>
              </tr>
              @if($facility->addresses->count())
                @foreach($facility->addresses as $ip)
                  <tr>
                    <td></td>
                    <td>{{$ip->address}}</td>
                    <td class="has-text-right">
                      <a class="button is-outlined m-r-5" href="{{route('address.show', $ip->id)}}">View</a>
                      @permission('update-facilities')
                        <a class="button is-light" href="{{route('address.edit', $ip->id)}}">Edit</a>
                      @endpermission
                    </td>
                  </tr>
                @endforeach
              @endif
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div> <!-- end of .card -->
</div>
@endsection