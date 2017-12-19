<form id="clock-form" action="{{ route('clockout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>