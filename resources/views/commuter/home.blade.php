@extends('layouts.app')

@section('title') Commuter Home @endsection

@section('content')
<div class="container-fluid">
	<h3>Commuter Home Page</h3>
	<p>Welcome, <span class="capitalize">{{ Auth::user()->first_name }}!</span></p>
	<a href="{{ route('logout') }}">Logout</a>
</div>
@endsection