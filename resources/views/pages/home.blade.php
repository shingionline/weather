@extends('layouts.app')

@section('title_description')
<title>{{ config('app.name') }}</title>
@endsection

@section('content')     
    <home :user="{{ $user }}"></home>
@endsection