(function($, undefined) {
	"use strict";

	var TPL_BTN_LEFT   = '<div class="scrollbar-btn-left"><div /></div>';
	var TPL_BTN_RIGHT  = '<div class="scrollbar-btn-right"><div /></div>';
	// var TPL_BTN_TOP    = '<div class="scrollbar-btn-top"><div /></div>';
	// var TPL_BTN_BOTTOM = '<div class="scrollbar-btn-bottom"><div /></div>';
	var TPL_CENTER     = '<div class="scrollbar-scrollarea">' +
							'<div class="scrollbar-btn-main">' +
							'<div />' +
							'</div>' +
							'</div>';

	function getColCount(wrapper) {
		if (wrapper.attr('data-columns'))
			return $.WPV.reduce_column_count(parseInt(wrapper.attr('data-columns'), 10)) + (Modernizr.touch ? 0.1 : 0);

		return 1;
	}

	function getColumnWidth(wrapper) {
		return 1/getColCount(wrapper);
	}

	function initLayout($ul) {
		var lis    = $ul.find(" > li").removeClass("fit"),
			cCount = getColCount($ul);

		var lisLength  = lis.length,
			zoom       = lisLength / cCount,
			colWidth   = getColumnWidth($ul) * 100 / zoom,
			totalWidth = 100 * zoom;

		$ul.css("width", totalWidth + "%");

		lis.each(function(i, o) {
			$(o).css({
				width: colWidth + "%"
			});
		});
	}

	/**
	 * Creates horizontal scroll bar and returs it as jQuery object (It is NOT
	 * yet inserted at the DOM).
	 * @return {jQuery}
	 */
	function createScrollBarX(options) {
		var html = ['<div class="scrollbar-horizontal">'];
		switch (options.arrowButtons) {
			case "buttons-only":
				html.push( TPL_BTN_LEFT, TPL_BTN_RIGHT );
			break;
			case "left":
				html.push( TPL_BTN_LEFT, TPL_BTN_RIGHT, TPL_CENTER );
			break;
			case "right":
				html.push( TPL_CENTER, TPL_BTN_LEFT, TPL_BTN_RIGHT );
			break;
			case "none":
				html.push( TPL_CENTER );
			break;
			default:
				html.push( TPL_BTN_LEFT, TPL_CENTER, TPL_BTN_RIGHT );
			break;
		}
		html.push('</div>');

		return $( html.join("") );
	}

	/**
	 * This callback function gets called when the scrollable element is resized
	 * or scrolled to update the width and position of the scrollbars.
	 */
	function sync(elem) {
		var scrollBars = $(elem).data("scrollBars");
		if (scrollBars) {
			if (scrollBars.horizontal) {
				var scrollWidth     = elem.scrollWidth,
					scrollbarWidth  = 100 * (elem.clientWidth / scrollWidth),
					scrollbarLeft   = 100 * (elem.scrollLeft  / scrollWidth);

				scrollBars.horizontal.find(".scrollbar-btn-main > div").css({
					width   : scrollbarWidth + "%",
					left    : scrollbarLeft  + "%"
				}).end().toggleClass("disabled", scrollbarWidth >= 100);
			}

			if (scrollBars.vertical) {
				var scrollHeight    = elem.scrollHeight,
					scrollbarHeight = 100 * (elem.clientHeight / scrollHeight),
					scrollbarTop    = 100 * (elem.scrollTop    / scrollHeight);

				scrollBars.vertical.find(".scrollbar-btn-main > div").css({
					height  : scrollbarHeight + "%",
					left    : scrollbarTop    + "%"
				}).end().toggleClass("disabled", scrollbarHeight >= 100);
			}
		}
	}

	/**
	 * This is called once after the given scrollbar (horizontal or vertical)
	 * has been created to attach the event listeners
	 */
	function attachListeners( elem, scrollbarX ) {
		if (scrollbarX) {
			var msie = /MSIE (\d+)/.exec(navigator.userAgent);
			var EVENT_ROOT = (msie && msie[1] === 8) ? document : window;

			scrollbarX.find(".scrollbar-scrollarea").bind("mousedown", function(e) {
				var $btnWrap = $(this).find(".scrollbar-btn-main"),
					$btn     = $btnWrap.find(" > div").addClass("active"),
					btnWidth = $btn.width(),
					width    = $btnWrap.width(),
					delta    = $btn.offset().left - e.pageX;

				function set(x) {
					var deltaX = x - $btnWrap.offset().left;
					var left = width * (deltaX / width);
					left += delta;
					left  = Math.max(left, 0);
					left  = Math.min(left, width - btnWidth);
					elem.scrollLeft = Math.ceil(left * (elem.scrollWidth / width));
					$(elem).trigger("scroll");
				}

				// If the mousedown happens on the button - just start moving it
				if (e.target === $btn[0]) {
					set( e.pageX );
				}

				// If the mousedown happens on the button parent - scroll to that point first
				else {
					var l = elem.scrollWidth - elem.clientWidth;
					l *=  (e.pageX - $btnWrap.offset().left) / $btnWrap.width();
					$(elem)
					.originalStop(1, 0)
					.originalAnimate(
						{ scrollLeft : l },
						{
							duration : 300,
							easing   : "easeInOutCirc",
							step     : function() {
								$(elem).trigger("scroll");
							},
							complete : function() {
								delta = $btn.offset().left - e.pageX;
							}
						}
					);
				}

				$(EVENT_ROOT).bind("mousemove.sliderdrag", function(e) {
					set( e.pageX );
					return false;
				});

				$(EVENT_ROOT).bind("mouseup.sliderdrag", function() {
					$(this).unbind(".sliderdrag");
					$btn.removeClass("active");
				});

				return false;
			});

			// Left/Right buttons
			scrollbarX.find(".scrollbar-btn-left, .scrollbar-btn-right")
			.bind("mouseenter", function() {

				var left = $(this).hasClass("scrollbar-btn-left"),
					maxScrollLeft = elem.scrollWidth - elem.clientWidth;

				$(elem).stop(1, 0).animate({
					scrollLeft: left ? 0 : maxScrollLeft
				}, {
					duration: Math.abs(left ? elem.scrollLeft : maxScrollLeft-elem.scrollLeft)*3,
					step : function() {
						$(elem).trigger("scroll");
					},
					easing: 'easeInOutQuint'
				});
			})
			.bind("mouseleave", function() {
				$(elem).stop(1, 0);
			});
		}
	}

	function getScrollBarX(elem, options) {
		var o = $(elem).data("scrollBars");
		if ( !o ) {
			o = {};
			$(elem).data("scrollBars", o);
		}
		if ( !o.horizontal ) {
			o.horizontal = $(elem).next(":first");
			if (!o.horizontal.length || !o.horizontal.is(".scrollbar-horizontal")) {
				o.horizontal = createScrollBarX(options);
				o.horizontal.insertAfter(elem);
			}
			attachListeners( elem, o.horizontal );
		}
	}

	$.fn.vamtamScrollable = function(options) {
		var hasNativeTouchScroll = !!$.getCssPropertyName("-webkit-overflow-scrolling");
		return this.each(function(i, o) {
			if (!hasNativeTouchScroll)
				getScrollBarX(o, options);

			$(window).bind("resize scroll switchlayout", function(e) {
				if (e.type === "switchlayout" || e.type === "resize") {
					initLayout($("> ul", o));
				}
				if(!hasNativeTouchScroll)
					sync(o);
			});

			initLayout($("> ul", o));
			if(!hasNativeTouchScroll)
				sync(o);
			$(o).addClass("loaded");

			if('RetinaImage' in window && window.devicePixelRatio > 1) {
				$(o).find('img').each(function() {
					new RetinaImage(this);
				});
			}
		});
	};
})(jQuery);