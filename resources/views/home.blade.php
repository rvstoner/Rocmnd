@extends('layouts.app')

@section('content')

<section class="section">
    <div class="container">
        <h1 class="title">Home</h1>
    </div>
</section>
<section class="section">
    <template>
        <section>
            @foreach($reportTypes as $report)
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
            <span class='is-pulled-right'>From: {{ $report->user->getNameOrUsername() }}</span>
        </b-message>
        @endforeach
    </section>
</template>
</section>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
        });
    </script>
@endsection
