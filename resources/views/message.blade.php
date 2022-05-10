@extends('master')

@section('title', $message->title)

@section('content')

	<h3>{{ $message->title }}</h3>
	<p>{{ $message->content }}</p>
	<br>
	<a href="/">Back</a>
@endsection