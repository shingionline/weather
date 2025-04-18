@extends('layouts.app')

@section('title_description')
<title>Reset Password - {{ config('app.name') }}</title>
<meta name="description" content="Reset password for {{ config('app.name') }}">
@endsection

@section('content')
<reset-password-token token="{{ $token }}" email="{{ $email }}"></reset-password-token>
@endsection
