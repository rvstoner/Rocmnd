@extends('layouts.manage')

@section('content')

<section class="section">
  <div class="container">
    <h1 class="title">Manage P.T.O. for Users</h1>
    {{-- <h2 class="subtitle"> --}}
      <form role="form" method="POST" action="{{ route('pto.store') }}">
        {{ csrf_field() }}           
        <input class="button is-primary is-large" type="submit" value="Add P.T.O.">
      </form>
    {{-- </h2> --}}
    <div class="card">
      <div class="card-content">
        {{$users->links('_includes.nav.pagination')}}
        <table class="table is-narrow is-fullwidth">
          <thead>
            <tr>
              <th>Facility</th>
              <th>Name</th>
              <th>Role</th>
              <th>Current PTO</th>
              <th>Monthly Amount</th>
              <th>Holiday</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @foreach ($users as $user)
            <tr>
              <th>{{$user->team->display_name}}</th>
              <td><a href="{{route('users.show', $user->id)}}">{{$user->getNameOrUsername()}}</a></td>
              <td>
                @foreach($user->roles as $role)
                {{ $role->display_name }}
                @endforeach
              </td>
              <td>{{ $user->pto }}</td>
              <td>{{ $user->pto_amount }}</td>
              <td>{{ $user->holiday }}</td>
              <td class="has-text-right">
                @permission(strtolower('update-pto'))
                  <a class="button is-light" href="{{route('pto.edit', $user->id)}}">Edit</a>
                @endpermission
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div> <!-- end of .card -->
  </div>
</section>

@endsection