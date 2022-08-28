"use strict";
jQuery(document).ready(function($) {
	/*hiding display_meta_box_heading() function*/
	$('.showhide').hide();
	if ($('.hideall-trigger').is(':checked')) {
		$('.hideall').hide();
	}
	if ($('.showhide-trigger').is(':checked')) {
		$('.showhide').show();
		$('.hideshow').hide();
	}

	$('.showhide-trigger').click(function() {
		if ($('.showhide-trigger').is(':checked')) {
			$('.showhide').show();
			$('.hideshow').hide();
		}
		else {
			$('.showhide').hide();
			$('.hideshow').show();
		}
	})
	$('.hideall-trigger').click(function() {
		if ($('.showhide-trigger').is(':checked')) {
			$('.showhide-trigger').prop('checked', false);
		}
		if ($('.hideall-trigger').is(':checked')) {
			$('.hideall').hide();
		}  else {
			$('.hideall').show();
			$('.showhide').hide();
		}
	});
});
