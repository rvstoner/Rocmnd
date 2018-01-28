@extends('layouts.manage')

@section('content')

<section class="section">
  <div class="container">
    <h1 class="title">{{ $user->getNameOrUsername() }}</h1>
  </div>
</section>

@include('_includes.timesheets.usertimesheet')

@endsection
