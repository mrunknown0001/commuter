@extends('layouts.app')

@section('title') Error 406 | Unauthorized Access @endsection

@section('content')
<div class="container-fluid">
	<h1 class="text-center">Not Acceptable! Go Home You Fool!</h1>
	<p class="text-center">Click here to go to <a href="{{ route('welcome') }}"><i class="fa fa-home"></i> home</a></p>
</div>
@endsection