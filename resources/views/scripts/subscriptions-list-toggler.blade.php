<script>
	$('#subscriptionsListToggler').click(function(e)
	{
		e.stopPropagation();
		$('#tagsNav').toggleClass('open');
	});

	$('.tag-nav-item').click(function()
	{
		window.location.href = $(this).find('a').attr('href');
	});

	$('#hideHero').click(function()
	{
		$('.hero').addClass('closed');
		$('#showHero').removeClass('hide');

		$.cookie('hideUserHeader', true);
	});

	$('#showHero').click(function()
	{
		$(this).addClass('hide');
		$('.hero').removeClass('closed');
		$.removeCookie('hideUserHeader');
	});

	if ($.cookie('hideUserHeader') != undefined)
	{
		$('.hero').addClass('closed');
		$('#showHero').removeClass('hide');
	}
</script>