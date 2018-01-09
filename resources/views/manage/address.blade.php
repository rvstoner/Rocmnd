@extends('layouts.manage')

@section('content')
  {{ip2long(request()->getClientIp())}}
<ul>
  @foreach($ips as $ip)
	<li>{{ $ip->address }} {{ $userIp }}
  @endforeach
 </ul>
@endsection