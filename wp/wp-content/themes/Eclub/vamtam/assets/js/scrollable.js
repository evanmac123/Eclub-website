(function($, undefined) {
	"use strict";

	$.rawContentHandler(function(context) {

		var conatiner = $('.portfolios.scroll-x, .loop-wrapper.scroll-x, .woocommerce-scrollable.scroll-x', context || document);

		conatiner.find("img.lazy").not(".jail-started, .loaded").addClass("jail-started").jail({
			speed : 1000,
			event : false
		});

		conatiner.vamtamScrollable({ arrowButtons : "buttons-only" });
	});
})(jQuery);