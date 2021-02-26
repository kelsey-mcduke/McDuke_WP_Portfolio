(function($) {

	var post_format_dropdown = '.editor-post-format select';

	$(window).load( function() {
		// First run.
		var post_format_selected = $('#post-formats-select input.post-format:checked').val();

		if ( $('body').hasClass('block-editor-page') ) {
			var post_format_selected = $( post_format_dropdown ).find(':selected').val();
		}

		$('div[id^="ci_format_box_"]:visible').hide();
		$('div#ci_format_box_'+post_format_selected).show();

		// Show only the custom fields we need in the post screen.
		$('#post-formats-select input.post-format').click(function(){
			var format = $(this).attr('value');
			$('div[id^="ci_format_box_"]:visible').hide();
			$('div#ci_format_box_'+format).show();
		});

		$( post_format_dropdown ).on( "change", function() {
			var format = $(this).find(':selected').val();
			$('div[id^="ci_format_box_"]:visible').hide();
			$('div#ci_format_box_'+format).show();
		});

	});
})(jQuery);
