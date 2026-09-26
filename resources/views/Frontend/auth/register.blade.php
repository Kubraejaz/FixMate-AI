@extends('Frontend.layouts.public')

@section('title', 'Register — FixMate AI')

@section('content')
<script>
    window.location.href = "{{ url('/register/role') }}";
</script>
<div class="site-wrapper" style="text-align: center; padding: 100px 0;">
    <p>Redirecting to role selection...</p>
    <a href="{{ url('/register/role') }}" class="btn-yellow">Click here if not redirected</a>
</div>
@endsection
