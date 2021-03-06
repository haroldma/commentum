@extends('layouts.default')
@section('title', 'saved by '.Auth::user()->username)

@section('page')
<div class="hero">
	@include('layouts.user-header')
	@include('layouts.subscriptions-list')
</div>
<div class="padding">
	<div class="row small-collapse">
		<div class="medium-8 large-9 xlarge-10 columns user-saved">
			<ul class="tabs" data-tab>
				<li class="tab-title active"><a href="#threads">Saved Threads</a></li>
				<li class="tab-title"><a href="#comments">Saved Comments</a></li>
			</ul>
			<div class="tabs-content">
				<div class="content active" id="threads">
					@if (count(Auth::user()->saves()["threads"]) > 0)
					@include('layouts.threads', ['threads' => Auth::user()->saves()['threads']])
					@else
					<h6 class="no-data-warning">You haven't saved any threads yet.</h6>
					@endif
				</div>
				<div class="content" id="comments">
					@if (count(Auth::user()->saves()["comments"]) > 0)
					@include('layouts.saved-comments', ['comments' => Auth::user()->saves()['comments']])
					@else
					<h6 class="no-data-warning">You haven't saved any comments yet.</h6>
					@endif
				</div>
			</div>
		</div>
		<div class="medium-4 large-3 xlarge-2 columns" style="margin-top:35px;">
			@include('layouts.user-sidebar', ['user' => Auth::user()])
		</div>
	</div>
</div>
@stop

@section('scripts')
{!! HTML::script('/bower_components/foundation/js/foundation.min.js') !!}
{!! HTML::script('/bower_components/marked/marked.min.js') !!}
{!! HTML::script('/bower_components/livestamp/moment.min.js') !!}
{!! HTML::script('/bower_components/livestamp/livestamp.min.js') !!}
@include('scripts.markdown-parser')
@include('scripts.thread-actions')
<script>
	$(document).foundation();
</script>
@stop