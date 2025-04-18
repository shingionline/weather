@extends('layouts.app')

@section('title_description')
<title>Reset Password - {{ config('app.name') }}</title>
<meta name="description" content="Reset password for {{ config('app.name') }}">
<link rel="canonical" href="{{ config('app.url') }}/forgot-password }}"/>
@endsection

@section('content')
<reset-password></reset-password>
@endsection
