@extends('layouts.manage')

@section('content')
  {{request()->getClientIp()}}
@endsection