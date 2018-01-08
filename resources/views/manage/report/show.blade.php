@extends('layouts.manage')

@section('content')
<section class="section">
	<div class="container">

		<template>
	        <section>
	            <b-message 
	            	title="{{ $report->title }}"
	            	size="is-large"
	            	type="{{ $report->class_type }}"
	            	>
	            	<span>{{ $report->date->toDayDateTimeString() }}</span>
	                <span class='is-pulled-right'>{{ $report->date->diffForHumans() }}</span>
	                <p>
		                {{ $report->body }}	
	                </p>
	            </b-message>
	        </section>
	    </template>
		
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
