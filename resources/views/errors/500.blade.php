@extends('layouts.app')

@section('title') Error 500 | Page Not Found @endsection

@section('content')
<div class="container-fluid">
	<h1 class="text-center">Internal Server Error!</h1>
	<p class="text-center">Click here to go to <a href="{{ route('welcome') }}"><i class="fa fa-home"></i> home</a></p>
</div>
@endsection