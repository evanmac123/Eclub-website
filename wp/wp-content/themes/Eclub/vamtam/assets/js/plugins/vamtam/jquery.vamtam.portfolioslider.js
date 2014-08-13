(function($) {
	"use strict";

	var SLIDER;
	var SLIDES        = [];
	var SLIDER_OPTIONS;
	var SLIDER_ID     = "#ajax-portfolio-slider-big";
	var VIEWER_ID     = "#portfolio-viewer";
	var TOGGLE_TIME   = 1000;
	//var INITIAL_TITLE = $(".page-header h1 > span").html();
	var SORTED_BY;
	var IGNORE_HASH_CHANGE = false;
	var XHR = null;
	var NAV_TIMEOUT;

	function filterFn(slide) {
		if ( !SORTED_BY || SORTED_BY === "all" )
			return true;

		var type = $("li[data-id=" + slide.id + "]").attr("data-type");

		if ( type === SORTED_BY )
			return true;

		return $.inArray(SORTED_BY, type.split(/\s*,\s*/)) > -1;
	}

	function filter(slides) {
		return $.grep(slides, filterFn);
	}

	/** Given the slide ID returns its index in SLIDES collection */
	function idToIndex(id) {
		var slides = filter(SLIDES);
		for (var i = 0; i < slides.length; i++) {
			if (slides[i].id === id) {
				return i;
			}
		}
		return 0;
	}

	/**
	 * Creates (if needed) and returns the slider instance
	 */
	function getSlider(initialId) {
		if (!SLIDER) {
			$(SLIDER_ID).one("beforeExpand", function(e, slider) {
				SLIDER = slider;
				SLIDER.options.initialIndex = initialId ? idToIndex(initialId) : 0;

				if (SORTED_BY) {
					$(SLIDER_ID).one("slideComplete", function() {
						SLIDER.filter(filterFn, initialId ? idToIndex(initialId) : 0);
					});
				}
			});
			SLIDER = $(SLIDER_ID).vamtamSlider(SLIDER_OPTIONS).data("vamtamSlider");


			window.SLIDER = SLIDER; // DEBUG only
		}
		return SLIDER;
	}

	/** Scroll the page to X/Y - animated and cross-browser */
	function scrollTo(x, y, duration, easing, callback) {
		if ("ontouchstart" in document.documentElement) {
			window.scrollTo(x, y);
			return (callback || $.noop)();
		}
		var $elem = $(/webkit/i.test(navigator.userAgent) || document.compatMode === 'BackCompat' ? "body" : "html");
		y -= parseFloat($(document.documentElement).css("marginTop"));
		x -= parseFloat($(document.documentElement).css("marginLeft"));

		if ($elem[0] && ($elem[0].scrollTop !== y || $elem[0].scrollLeft !== x)) {
			$elem.animate(
				{
					scrollTop  : y,
					scrollLeft : x
				},
				duration || "normal",
				easing   || "swing",
				callback || $.noop
			);
		}
		else {
			(callback || $.noop)();
		}
	}

	/** Scrolls the slider to the slide with the given ID */
	function goToId(id) {
		if (!SLIDER) {
			getSlider(id);
		}
		else {
			SLIDER.pos(idToIndex(id));
		}
	}

	/** Simple object to expose three publick methids */
	jQuery.WPV.PortfolioSlider = {

		/** Used to set the SLIDES collection */
		init : function(slides, sliderOptions) {
			SLIDES = $.extend(true, [], slides);
			SLIDER_OPTIONS = $.extend(true, {
				initialHeight : 0,
				minHeight     : 200,
				effect        : "portfolioViewer2",
				autostart     : false,
				loadingMask   : VIEWER_ID + " .vamtam-slider-loading-mask",
				height        : 490,
				slides        : SLIDES,
				resizing      : "cover",
				easing        : "easeInOutQuart",
				animationTime : 1000,
				maintainAspectRatio: true
			}, sliderOptions);
		},

		/** Closes the slider area and restores the page header */
		close : function() {
			$(SLIDER_ID).pauseResizeWatcher().find(".video-wrapper iframe");
			$('#sub-header').delay(TOGGLE_TIME/2).slideDown(TOGGLE_TIME);
			$(VIEWER_ID).css("height", 0).transit({ minHeight : 0 }, TOGGLE_TIME, "easeOutCubic", function() {
				$("body").removeClass("ajax-portfolio-expanded");
				$(SLIDER_ID).find(".video-wrapper iframe").each(function(i, o) {
					var src = o.src;
					o.src = "about:blank";
					setTimeout(function() { o.src = src; }, 0);
				});

				$(".content.row", VIEWER_ID).html('');
			});
		},

		/** 
		 * 1. Opens the slider area, if closed 
		 * 2. Closes the page header (if any)
		 * 3. Goes to slide by "id"
		 */
		open: function(id) {
			scrollTo(0, $("#portfolio-viewer").offset().top, 500, "swing", function() {
				if (!$("body").is(".ajax-portfolio-expanded")) {
					$(SLIDER_ID).pauseResizeWatcher();

					$(VIEWER_ID).css("minHeight", 0).transition(
						{ minHeight: SLIDER_OPTIONS.height },
						TOGGLE_TIME,
						"easeOutCubic",
						function() {
							$(VIEWER_ID).css("height", "auto");
							$("body").addClass("ajax-portfolio-expanded");
							$('#sub-header').slideUp();
							if (!SLIDER) {
								getSlider(id);
							}
							else {
								goToId(id);
							}
							$(SLIDER_ID).resumeResizeWatcher();
						}
					);
				}
				else {
					goToId(id);
				}
			});
		}
	};


	// This section defines custom effect for the portfolio-viewer slider that 
	// supports nested slides (galleries) and many other custom features...
	// =========================================================================

	function showSlideMetaData(slider, slide) {
		var row = $(".content.row", VIEWER_ID);

		hideNavButtons();
		row.removeClass("loaded");
		if (slide.pageUrl) {
			$.ajax({
				type: "GET",
				url : slide.pageUrl,
				cache: false,
				//data: { "ajax-portfolio" : 1 }
				headers  : { "X-Vamtam" : "ajax-portfolio" },
				beforeSend : function(xhr) {
					if (XHR && XHR.readyState !== 4 && XHR.abort) {
						XHR.abort();
					}
					XHR = xhr;
				}
			}).done(function ( data ) {
				var helper = $('<div/>').html(data);

				row.html(helper.html()).addClass("loaded");

				helper.empty();
				showNavButtons();
			});
		}
		else {
			$(".content.row").empty();
		}
	}

	function goToGalleryItem(slider, arg) {
		var curSlide = slider._getCurrentSlide();
		if (curSlide.type === "gallery" && curSlide.children.length > 1) {
			var set     = curSlide.children;
			var pos     = curSlide._pos || 0;

			var nextPos = arg === "prev" ?
					pos - 1 :(arg === "next" ?
						pos + 1 : Math.max(parseInt(arg, 10), 0));

			if (nextPos > set.length - 1)
				nextPos = 0;

			if (nextPos < 0)
				nextPos = set.length - 1;

			var cur  = set[pos];
			var next = set[nextPos];

			if (pos !== nextPos) {
				cur.wrapper.stop(1, 0).hide();
				next.wrapper.stop(1, 0).show();
				curSlide._pos = nextPos;

				$("#portfolio-pager .btn").removeClass("active").eq(nextPos).addClass("active");
			}
		}
	}

	$.VamtamSlider.Effects.portfolioViewer2 = {

		init : function(slider) {
			$("> .slide-wrapper", slider.element).css({
				display: "none"
			});

			// Init sub-slides (galleries)
			$(this).find("> .slide-wrapper > .slide-wrapper").each(function(j) {
				$(this).css({
					opacity : j === 0 ? 1 : 0,
					zIndex  : j === 0 ? 3 : 2
				});
			});

			$(VIEWER_ID).on("click", "#portfolio-pager .btn", function() {
				var index = $(this).parent().find(".btn").index(this);
				goToGalleryItem(slider, index);
			});

			$(VIEWER_ID).on("click", "#portfolio-btn-prev", function() {
				goToGalleryItem(slider, 'prev');
			});

			$(VIEWER_ID).on("click", "#portfolio-btn-next", function() {
				goToGalleryItem(slider, 'next');
			});

			getPager().css("opacity", 0);
			getGalleryNav().css("opacity", 0);

			$(slider.element).bind({
				"slidePositionChange.thumbNav" : function(e, newPos) {
					var wrapper = this;
					if ($("body").is(".ajax-portfolio-expanded")) {
						var slide = slider.slides[newPos];
						var isGallery = slide.type === "gallery";


						$("> iframe", slide.element)
						.removeAttr("width")
						.removeAttr("height")
						.wrap('<div class="video-wrapper"/>');

						setTimeout( function() {
							showSlideMetaData(
								slider,
								isGallery ? slide.children[0] : slide,
								newPos
							);

							if (isGallery) {
								getPager(wrapper, slide.children).css("opacity", 1);
								getGalleryNav(wrapper).css("opacity", 1);
							}
							else {
								getPager().css("opacity", 0);
								getGalleryNav().css("opacity", 0);
							}
						}, 0);

						IGNORE_HASH_CHANGE = true;
						window.location.hash = "#" + slide.id;
						//IGNORE_HASH_CHANGE = false;
					}
				}
			});

			$(window).on("portfolioSortStart.portfolioSlider", function() {
				$(slider.element).vamtamSlider("showLoadingMask");
				getPager().css("opacity", 0);
				getGalleryNav().css("opacity", 0);
			});
		},

		uninit : function(slider) {
			$(window).off("portfolioSortStart.portfolioSlider");

			$(slider.element).unbind("slidePositionChange.thumbNav");

			$(VIEWER_ID).off("click", "#portfolio-pager .btn");

			getPager().remove();
			getGalleryNav().remove();
		},

		run : function(cfg) {
			if (cfg.toShow[0] === cfg.toHide[0])
				return cfg.callback();

			cfg.slider.foreachSlide(function(i, slide) {
				$(slide.element).stop(1, 1);
			});

			cfg.toShow.css({
				x: cfg.toShow.width() * cfg.direction,
				display: "block"
			}).transition({
					x: 0
				},
				cfg.duration,
				cfg.easing,
				cfg.callback
			).find("> .slide-wrapper").each(function(j) {
					$(this).css({
						zIndex  : j === 0 ? 3 : 2,
						display : "block"
					});
				});

			cfg.toHide.css({
				x: 0
			}).transition({
					x: cfg.toShow.width() * -cfg.direction
				},
				cfg.duration,
				cfg.easing,
				function () {
					cfg.toHide.css({ display: "none" });
				}
			);
		},

		changeCaptions : function(cfg) {
			cfg.callback();
		}
	};

	function getPager(wrapper, slides) {
		var pager = $("#portfolio-pager");
		if (!pager.length && wrapper) {
			pager = $('<div id="portfolio-pager"/>').appendTo(wrapper);
		}
		if (slides) {
			pager.empty();
			var btnWrap = $('<div class="btn-wrap"/>').appendTo(pager);
			$.each(slides, function(i) {
				var btn = $('<div class="btn"/>').appendTo(btnWrap);
				if (i === 0) {
					btn.addClass("active");
				}
			});
		}
		return pager;
	}

	function getGalleryNav(wrapper) {
		var nav = $("#portfolio-btn-prev, #portfolio-btn-next");
		if (!nav.length && wrapper)
			nav = $('<div id="portfolio-btn-prev"><span></span></div><div id="portfolio-btn-next"><span></span></div>').appendTo(wrapper);

		return nav;
	}

	function getNavButtons() {
		$('.portfolio-content .page-header .post-siblings').remove();

		var buttonsContainer = $('<span class="post-siblings"/>').appendTo(".portfolio-content .page-header .page-header-content");

		var navButtons = {
				btnPrev  : $('<div class="portfolio-slider-prev"><span class="icon"/></div>' ).appendTo(buttonsContainer),
				btnClose : $('<div class="portfolio-slider-close"><span class="icon"/></div>').appendTo(buttonsContainer),
				btnNext  : $('<div class="portfolio-slider-next"><span class="icon"/></div>' ).appendTo(buttonsContainer)
			};

		navButtons.btnClose.click(function() {
			jQuery.WPV.PortfolioSlider.close();
			document.location.hash = "";
		});

		navButtons.btnPrev.click(function() {
			if (NAV_TIMEOUT) {
				clearTimeout(NAV_TIMEOUT);
			}
			NAV_TIMEOUT = setTimeout(function() {
				$(SLIDER_ID).vamtamSlider("pos","prev");
			}, 300);
		});

		navButtons.btnNext.click(function() {
			if (NAV_TIMEOUT) {
				clearTimeout(NAV_TIMEOUT);
			}
			NAV_TIMEOUT = setTimeout(function() {
				$(SLIDER_ID).vamtamSlider("pos","next");
			}, 300);
		});

		$(SLIDER_ID).touchwipe({
			preventDefaultEvents : false,
			canUseEvent : function(e) {
				return $(e.target).is(".slide, .slide *");
			},
			wipeLeft: function(e) {
				e.preventDefault();
				navButtons.btnNext.triggerHandler("click");
			},
			wipeRight: function(e) {
				e.preventDefault();
				navButtons.btnPrev.triggerHandler("click");
			}
		});
		return navButtons;
	}

	function showNavButtons() {
		$.each(getNavButtons(), function(name, elem) { $(elem).show(); });
	}

	function hideNavButtons() {
		$.each(getNavButtons(), function(name, elem) { $(elem).remove(); });
	}

	// Attach the portfolio-slider behavior on click
	$(function() {
		$(".portfolios li").find("a").unbind("click").bind("click", function(e){
			e.preventDefault();
		})
		.end().click(function() {
			var id = this.getAttribute("data-id");
			if (id) {
				jQuery.WPV.PortfolioSlider.open(id);
			}
		});

		$(window).on("portfolioSortComplete.portfolioSlider", function(e, cat) {
			SORTED_BY = cat;
			if (SLIDER) {
				SLIDER.filter(filterFn, 0);
			}
		});

		function onHashChange() {
			if ( !IGNORE_HASH_CHANGE ) {
				var id = window.location.hash.replace(/^#/, "");
				if (id && $('.portfolios li[data-id="' + id + '"]').length) {
					jQuery.WPV.PortfolioSlider.open(id);
				}
			} else {
				IGNORE_HASH_CHANGE = false;
			}
		}

		$(window).bind("hashchange", onHashChange);

		onHashChange();
	});

})(jQuery);
