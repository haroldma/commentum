<div class="tags-nav" id="tagsNav">
	<div class="row">
		<div class="medium-3 columns">
			<ul class="no-bullet">
				<li class="tag-nav-item animated fadeInUp"><a class="active" href="{{ url('/') }}">Front</a></li>
				@foreach(Auth::user()->subscriptions() as $s)
				<li class="tag-nav-item animated fadeInUp"><a href="{{ $s->tag()->permalink() }}">#{{ $s->tag()->display_title }}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>