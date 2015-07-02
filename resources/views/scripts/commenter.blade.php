<script>
	@if (Auth::check())
	var submitComment = function(e, el)
	{
		e.preventDefault();

		var form = $(el),
			formData = form.serialize();

		var input     = $.trim(form.find('textarea').first().val()),
			threadId  = form.find('input[name="thread_id"]').first().val(),
			parentId  = form.find('input[name="parent_id"]').first().val(),
			token     = form.find('input[name="_token"]').first().val(),
			usernameRegex = /(?:^|)(\/u\/\w+)(?!\w)/g,
			tagRegex      = /(?:^|)#(\w+)(?!\w)/g;

		// Create links of /u/usernames and #tags
		var markdown = input.replace(usernameRegex, "[$1]($1)").replace(tagRegex, "[#$1](/t/$1)");

		$.post('{{ url("/comment") }}', {_token:token, markdown:markdown, thread_id:threadId, parent_id:parentId})
		.done(function(res)
		{
			var md = markdown,
				pr = new showdown.Converter(),
				ht = pr.makeHtml(md)
				hier = (form.data('hierarchy') == 'parent') ? 'child' : 'parent';

			var commentCount = $('#threadCommentCount'),
				count = parseInt(commentCount.text()) + 1;

			if (count == 1)
				$('#threadCommentPlural').text('');
			else
				$('#threadCommentPlural').text('s');

			commentCount.text(count);

			if (form.parent().hasClass('r-b'))
				form.parent().hide();

			if (res['parentMomentum'] != 'whoopie')
			{
				if (res['parentMomentum'] == 1)
					var parentMomentum = '1 point';
				else
					var parentMomentum = res['parentMomentum'] + ' points';

				form.parent().parent().find('.comment-momentum').first().text(parentMomentum);
				console.log(parentMomentum);
			}

			var html = '<article class="comment ' + form.data('hierarchy') + '">';
				html += '<header>';
				html += '<span class="collapser"><i class="ion-chevron-up"></i></span>';
				html += '<span><a href="{{ Auth::user()->permalink() }}">';
				@if ($threadUserId != null && Auth::id() == $threadUserId)
				html += '<span class="username-tag op">OP</span> ';
				@endif
				html += '{{ Auth::user()->username }}</a></span>';
				html += '&middot;';
				html += '<span>0 points</span>';
				html += '&middot;';
				html += '<span class="livestamp"></span>';
				html += '</header>';
				html += '<div class="body">';
				html += '<section class="markdown">';
				html += ht;
				html += '</section>';
				html += '<footer>';
				html += '<a onclick="toggleReplyBox(this)">reply</a>';
				html += '<a href="'+res['permalink']+'">permalink</a>';
				html += '<a href="'+res['context']+'">context</a>';
				html += '</footer>';
				html += '<div class="reply-box r-b">';
				html +=	'<form method="POST" action="{{ url("/comment") }}" accept-charset="UTF-8" class="row comment-box" data-hierarchy="'+hier+'" onsubmit="submitComment(event, this)">';
				html += '<input name="_token" type="hidden" value="{{ csrf_token() }}">';
				html += '<input name="thread_id" type="hidden" value="' + res['threadId'] + '">';
				html += '<input name="parent_id" type="hidden" value="' + res['commentId'] + '">';
				html += '<div class="medium-5 columns">';
				html += '<p class="no-margin">';
				html += 'You can use <a href="{{ url("/") }}"</a>.';
				html += '</p>';
				html += '<textarea rows="4" name="markdown" cols="50" class="comment-textarea"></textarea>';
				html += '<div class="preview hide">';
				html += '<h6 class="super-header">Live Preview</h6>';
				html += '<div class="markdown"></div>';
				html += '</div>';
				html += '<p class="text-alert"></p>';
				html += '<input class="btn" type="submit" value="Reply">';
				html += '</div>';
				html += '</form>'
				html += '</div>';
				html += '<div class="children"></div>';
				html += '</div>';
				html += '</article>';

			form.parent().parent().find('.children').first().prepend(html);
			form.trigger('reset');

			form.find('.preview').addClass('hide');
			form.find('.markdown').html('');

			var livestamp = $('.livestamp').first();
			livestamp.livestamp(new Date());
			livestamp.removeClass('livestamp');

			if (!form.hasClass('parent-commenter'))
				form.parent().hide();
		})
		.fail(function(res)
		{
			form.parent().find('.text-alert').first().text(res.responseText);
		});
	}

	$(document).on('keyup', '.comment-textarea', function()
	{
		var input = $.trim($(this).val());

		if (input == "")
		{
			$(this).parent().find('.preview').addClass('hide');
		}
		else
		{
			// Create links of /u/usernames and #tags
			var usernameRegex = /(?:^|)(\/u\/\w+)(?!\w)/g,
				tagRegex      = /(?:^|)#(\w+)(?!\w)/g;

			var markdown = input.replace(usernameRegex, "[$1]($1)").replace(tagRegex, "[#$1](/t/$1)"),
				pr    	 = new showdown.Converter(),
				ht    	 = pr.makeHtml(markdown);

			$(this).parent().find('.markdown').html(ht);

			if ($(this).parent().find('.preview').first().hasClass('hide'))
				$(this).parent().find('.preview').removeClass('hide');
		}
	});

	var toggleReplyBox = function(el)
	{
		$(el).parent().parent().find('.reply-box').first().toggle();
	};
	@endif

	$('.collapser').click(function()
	{
		var comment = $(this).parent().parent();

		if (comment.hasClass('collapsed'))
		{
			$(this).find('i').removeClass('ion-chevron-down').addClass('ion-chevron-up');
			comment.removeClass('collapsed');
		}
		else
		{
			$(this).find('i').removeClass('ion-chevron-up').addClass('ion-chevron-down');
			comment.addClass('collapsed');
		}
	});
</script>