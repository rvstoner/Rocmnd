@extends('layouts.manage')

@section('content')

<section class="section">
{{-- @permission('create-users') --}}
	<a href="{{route('reports.create')}}" class="button is-primary is-pulled-right"><i class="fa fa-user-plus m-r-10"></i> Create a New Report</a>
{{-- @endpermission --}}
</section>
<section class="section">

	<div class="container">


		<template>
	        <section>
	        	@foreach($reports as $report)
	            <b-message 
	            	title="{{ $report->title }}"
	            	type="{{ $report->class_type }}"
	            	>
	            	<span>{{ $report->date->toDayDateTimeString() }}</span>
	                <span class='is-pulled-right'>{{ $report->date->diffForHumans() }}</span>
	                <p>
		                {{ $report->body }}	
	                </p>
	                <div class="is-pulled-right">
	                	<a class="button is-primary is-outlined m-r-5" href="{{route('reports.show', $report->slug)}}">View</a>
	                	{{-- @permission(strtolower('update-' . $user->roles->first()->name)) --}}
	                	<a class="button is-danger is-outlined m-r-5 " href="{{route('reports.edit', $report->slug)}}">Edit</a>
	                	{{-- @endpermission --}}
	                </div>
	                
	            </b-message>
	            @endforeach
	        </section>
	    </template>
		<section class="section">
		    {{$reports->links('_includes.nav.pagination')}}
		</section>
		
	</div>
</section>


@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
        });
    </script>
@endsection
