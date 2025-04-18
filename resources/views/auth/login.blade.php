@extends('layouts.app')

@section('title_description')
<title>Login - {{ config('app.name') }}</title>
<meta name="description" content="Login to {{ config('app.name') }}">
@endsection

@section('content')
<ajax-login></ajax-login>
@endsection