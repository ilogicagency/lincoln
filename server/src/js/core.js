(function($, window) {
	$(document).ready(function() {
		$('a').on('click', function(e) {
			e.preventDefault();

			$('a').hide();

			if ($('body.register').length != -1)
				window.location = $(this).attr('href');
		});

		$('body.book #choice button').on('click', function() {
			$(this).closest('.row').hide();

			if ($(this).attr('id') == 'yes') {
				$('#form').fadeIn();
			} else {
				window.location = 'index.php';
			}
		});

		$('.book input[type="checkbox"], .book label').on('click', function() {
			$(this).blur();
		});

		$('.book .feature').on('click', function() {
			var selected = $(this).is(':checked');

			$('.book input[type="checkbox"]').removeAttr('checked').removeProp('checked');

			if (selected)
				$(this).attr('checked', true).prop('checked', true);
		});
	});
})(jQuery, window);