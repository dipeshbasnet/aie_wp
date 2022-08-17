(function($) {
  "use strict";

  jQuery(document).ready(function() {
	/**
	 * Eael Tabs
	 */
	$(".eb-tabs li a").on("click", function(e) {
	  e.preventDefault();
	  $(".eb-tabs li a").removeClass("active");
	  $(this).addClass("active");
	  var tab = $(this).attr("href");
	  $(".eb-settings-tab").removeClass("active");
	  $(".eb-settings-tabs")
		.find(tab)
		.addClass("active");
	});


	// admin save
	$(document).on("click", "#eb-save-admin-options > button", function(e) {
		e.preventDefault();
		$.ajax({
			url: EssentialBlocksAdmin.ajax_url,
			type: "post",
			data: {
				action: "save_eb_admin_options",
				_wpnonce: EssentialBlocksAdmin.nonce,
				all_blocks: EssentialBlocksAdmin.all_blocks
			},
			success: function(resp) {
				swal({
					title     : "Settings Saved!",
					text      : "Click OK to continue",
					icon      : "success",
					buttons   : [false, "Ok"],
					timer: 1500
				});
			},
			error: function(resp) {
				swal({
					title     : "Settings Not Saved!",
					text      : "Click OK to continue",
					icon      : "error",
					buttons   : [false, "Ok"],
					timer: 1500
				});
			}
		});

		return false;
	});

	// admin save
	$(document).on("click", ".eb-admin-checkbox", function(e) {
	//   e.preventDefault();
	  if( $(this).attr('disabled') ) {
		var premium_content = document.createElement("p");
		var premium_anchor = document.createElement("a");

		premium_anchor.setAttribute( 'href', 'https://wpdeveloper.com/essential-blocks-pro' );
		premium_anchor.innerText = 'Premium';
		premium_anchor.style.color = 'red';
		premium_content.innerHTML = 'You need to upgrade to the <strong>'+ premium_anchor.outerHTML +' </strong> Version to use this feature';

		swal({
			title     : "Opps...",
			content   :  premium_content,
			icon      : "warning",
			buttons   : [false, "Close"],
			dangerMode: true,
		});
	  }
	});

  });
})(jQuery);
