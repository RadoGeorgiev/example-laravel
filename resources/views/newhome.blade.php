@extends('master')

@section('title', 'Homepage')

@section('content')

	<h1>News feed</h1>
	<a href="/table">
        <div><img src="/svg/icon.svg" style="height: 25px;"></div>
	</a>
	<a href="/oldhome">old homepage link</a>
	<hr>

	Post a message:

	<form action="/create" method="POST">

		<input type="text" name="title" placeholder="Title">

		<input type="text" name="content" placeholder="Content">

		<button type="submit">Submit</button>

	</form>

	<br>

	Recent Messages:

	<ul>
		@foreach($messages as $message)
			<li>
				<strong>{{ $message->title }}</strong>
				<br>
				{{ $message->content }}
				<br>
				{{ $message->created_at->diffForHumans() }} <!-- try => diffForHumans() => 1 min ago, 2 weeks ago, etc. -->
				<br>
				<a href="/message/{{ $message->id }}">Read</a>
			</li>
		@endforeach
	</ul>

@endsection