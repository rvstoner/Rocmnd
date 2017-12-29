@extends('layouts.manage')

@section('content')
<div class="flex-container">
  <div class="columns m-t-10">
    <div class="column">
      <h1 class="title">Manage Facilities</h1>
    </div>
    <div class="column">
      @permission('create-facilities')
        <a href="{{route('facilities.create')}}" class="button is-primary is-pulled-right"><i class="fa fa-user-plus m-r-10"></i> Create New Facility</a>
      @endpermission
    </div>
  </div>
  <hr class="m-t-0">

  <div class="card">
    <div class="card-content">
      <table class="table is-narrow is-fullwidth">
        <thead>
          <tr>
           <th>Name</th>
           <th>Display Name</th>
           <th>Description</th>
           <th></th>
         </tr>
       </thead>

       <tbody>
        @if(!$facilities->count())
        @else
        @foreach ($facilities as $facility)
        <tr>
         <td>{{ $facility->name }}</td>
         <td>{{ $facility->display_name }}</td>
         <td>{{ $facility->description }}</td>
         <td class="has-text-right">
          <a class="button is-outlined m-r-5" href="{{route('facilities.show', $facility->id)}}">View</a>
          @permission('update-facilities')
            <a class="button is-light" href="{{route('facilities.edit', $facility->id)}}">Edit</a>
          @endpermission
        </td>
      </tr>
      @endforeach
      @endif
    </tbody>
  </table>
</div>
</div> <!-- end of .card -->
</div>
@endsection