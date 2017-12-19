<form id="clock-form" action="{{ route('clockin') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>