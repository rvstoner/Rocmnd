@extends('layouts.app')

@section('content')

<section class="section">
    <div class="container">
        <h1 class="title">Home</h1>
    </div>
</section>
<section class="section">
    <article class="message is-info">
        <div class="message-header">
            <p>CPR Trainning {{ Carbon\Carbon::now()->addDays(2)->diffForHumans() }}</p>
            <button class="delete" aria-label="delete"></button>
        </div>
        <div class="message-body">
            <strong>{{ Carbon\Carbon::now()->addDays(2)->toDayDateTimeString() }}</strong><br>
            Some message about the meeting.
        </div>
    </article>
    <article class="message is-info">
        <div class="message-header">
            <p>ALL STAFF MEETING {{ Carbon\Carbon::now()->addHours(2)->diffForHumans() }}</p>
            <button class="delete" aria-label="delete"></button>
        </div>
        <div class="message-body">
            <strong>{{ Carbon\Carbon::now()->addHours(2)->toDayDateTimeString() }}</strong><br>
            Some message about the meeting.
        </div>
    </article>
</section>
@endsection
