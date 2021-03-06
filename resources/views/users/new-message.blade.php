@extends('layouts.default')
@section('title', 'preferences for '.Auth::user()->username)

@section('page')
<div class="hero">
	@include('layouts.user-header')
	@include('layouts.subscriptions-list')
</div>
<div class="padding">
	<div class="row small-collapse">
		<div class="medium-8 large-9 xlarge-10 columns inbox">
			{!! Form::open(['url' => '', 'id' => 'form', 'class' => 'panel']) !!}
			<h6 class="super-header">New message</h6>
			{!! Form::label('To:') !!}
			{!! Form::text('to', (Input::has('to') ? Input::get('to') : '')) !!}
			{!! Form::label('Message') !!}
			{!! Form::textarea('markdown', '', ['id' => 'input']) !!}
			<p class="text-alert" id="error"></p>
			{!! Form::submit('Send message', ['class' => 'btn blue', 'id' => 'button']) !!}
			&nbsp;
			<img src="{{ url('/img/three-dots-blue.svg') }}" width="35px" class="loader" id="loader">
			<br>
			<br>
			<div class="preview">
				<h6 class="super-header">Live Preview</h6>
				<div class="markdown" id="preview">
					Enter a message to view a preview here.
				</div>
			</div>
			{!! Form::close() !!}
		</div>
		<div class="medium-3 large-3 xlarge-2 columns">
			@include('layouts.user-sidebar', ['user' => Auth::user()])
		</div>
	</div>
</div>
@stop

@section('scripts')
{!! HTML::script('/bower_components/marked/marked.min.js') !!}
{!! HTML::script('/bower_components/livestamp/moment.min.js') !!}
{!! HTML::script('/bower_components/livestamp/livestamp.min.js') !!}
@include('scripts.markdown-parser')
@include('scripts.commenter', ['threadUserId' => null])
@include('scripts.pm')
@stop