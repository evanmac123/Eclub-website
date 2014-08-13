(function($, undefined) {
	'use strict';

	$(function() {
		var dropdown = $('.fixed-header-box .cart-dropdown'),
			link = $('.cart-dropdown-link', dropdown),
			count = $('.products', link),
			widget = $('.widget', dropdown),
			isVisible = false;

		$('body').bind('added_to_cart wc_fragments_refreshed wc_fragments_loaded', function() {
			if ( parseInt( $.cookie( 'woocommerce_items_in_cart' ), 10 ) > 0 ) {
				dropdown.removeClass('hidden');
				$(this).addClass('header-cart-visible');

				count.text( $.cookie( 'woocommerce_items_in_cart' ) );
			} else {
				dropdown.addClass('hidden');
				$(this).removeClass('header-cart-visible');
			}
		});

		var open = 0;

		var showCart = function() {
			open = +new Date();
			dropdown.addClass('state-hover');
			widget.stop(true, true).fadeIn(300, function() {
				isVisible = true;
			});
		};

		var hideCart = function() {
			var elapsed = new Date() - open;

			if(elapsed > 1000) {
				dropdown.removeClass('state-hover');
				widget.stop(true, true).fadeOut(300, function() {
					isVisible = false;
				});
			} else {
				setTimeout(function() {
					if(!dropdown.is(':hover')) {
						hideCart();
					}
				}, 1000 - elapsed);
			}
		};

		dropdown.bind('mouseenter', function() {
			showCart();
		}).bind('mouseleave', function() {
			hideCart();
		});

		link.bind('click', function(e) {
			if(isVisible) {
				hideCart();
			} else {
				showCart();
			}

			e.preventDefault();
		});
	});
})(jQuery);