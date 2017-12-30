@extends('layouts.manage')

@section('content')
  {{ip2long(request()->getClientIp())}}
@endsection