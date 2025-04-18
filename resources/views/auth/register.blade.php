@extends('layouts.app')

@section('title_description')
<title>Create New Account - {{ config('app.name') }}</title>
<meta name="description" content="Create new account on {{ config('app.name') }}">
<link rel="canonical" href="{{ config('app.url') }}/register }}"/>
@endsection

@section('content')
<ajax-register></ajax-register>
@endsection
