@extends('layouts.manage')

@section('content')
    <div class="flex-container">
      <div class="columns m-t-10">
        <div class="column">
          <h1 class="title">Manage Users</h1>
        </div>
        <div class="column">
          @permission('create-users')
            <a href="{{route('users.create')}}" class="button is-primary is-pulled-right"><i class="fa fa-user-plus m-r-10"></i> Create New User</a>
          @endpermission
        </div>
      </div>
      <hr class="m-t-0">

      <div class="card">
        <div class="card-content">
          {{$users->links('_includes.nav.pagination')}}
          <table class="table is-narrow is-fullwidth">
            <thead>
              <tr>
                <th>Facility</th>
                <th>Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Active</th>
                <th>Hire Date</th>
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
                  <td></td>
                  <td>{{ $user->isActive() }}</td>
                  <td>{{ empty($user->hire_date) ? $user->created_at->toFormattedDateString() : $user->hire_date->toFormattedDateString()}}</td>
                  <td class="has-text-right">
                    <a class="button is-outlined m-r-5" href="{{route('users.show', $user->id)}}">View</a>
                    @permission(strtolower('update-' . $user->roles->first()->name))
                      <a class="button is-light" href="{{route('users.edit', $user->id)}}">Edit</a>
                    @endpermission
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div> <!-- end of .card -->

      
    </div>
@endsection