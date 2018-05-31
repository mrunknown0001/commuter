@extends('layouts.app')

@section('title') Drive Home @endsection

@section('content')
<div class="container-fluid">
	<h3>Driver Home Page</h3>
	<p>Welcome, <span class="capitalize">{{ Auth::user()->first_name }}!</span></p>
	<a href="{{ route('logout') }}">Logout</a>
</div>
@endsection