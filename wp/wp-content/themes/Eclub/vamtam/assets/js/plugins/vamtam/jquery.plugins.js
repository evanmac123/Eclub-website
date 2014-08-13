(function() {

	"use strict";

	// Namespace
	jQuery.WPV = jQuery.WPV || {};

	// Constants
	jQuery.WPV.Constants = jQuery.WPV.Constants || {};

	jQuery.WPV.MEDIA = jQuery.WPV.MEDIA || {
		layout : {}
	};

	jQuery.fn.originalAnimate = jQuery.fn.originalAnimate || jQuery.fn.animate;
	jQuery.fn.originalStop = jQuery.fn.originalStop || jQuery.fn.stop;

	// jquery plugins
	(function($) {

		$.WPV.reduce_column_count = function(columns) {
			if(!$('body').hasClass('responsive-layout'))
				return columns;

			var win_width = $(window).width();

			if(win_width < 770)
				return 1;

			if(win_width >= 768 && win_width <= 1024 )
				return Math.min(columns, 2);

			if (win_width > 1024 && win_width < 1280)
				return Math.min(columns, 3);

			return columns;
		};

		/**
		 * Returns the CSS property name supported by the current browser.
		 * If none is supported, returns an empty string.
		 * Uses it's own cache for the results.
		 *
		 * @return {String} The CSS property name, as supported by the current browser.
		 */
		$.getCssPropertyName = function getCssPropertyName(w3cName) {
			// init cache
			if (!getCssPropertyName.cache) {
				getCssPropertyName.cache = {};
			}

			// camelize w3cName
			var name = String(w3cName).replace(/\-(\w)/g, function(all, letter) {
				return letter.toUpperCase();
			});

			if (!(name in getCssPropertyName.cache)) {
				var s = $("<i/>")[0].style,
				i, tmp, result = "",
				v = ["Moz", "Webkit", "O", "Khtml", "Ms", "ms"];

				if (s[w3cName] !== undefined) {
					result = w3cName;
				} else {
					if (s[name] !== undefined) {
						result = name;
					} else {
						for (i = 0; i < v.length; i++) {
							tmp = v[i] + name.charAt(0).toUpperCase() + name.substr(1);
							if (s[tmp] !== undefined) {
								result = tmp;
								break;
							}
						}
					}
				}
				getCssPropertyName.cache[name] = result;
			}

			return getCssPropertyName.cache[name];
		};

		var transEndEventNames = {
			'WebkitTransition' : 'webkitTransitionEnd',
			'MozTransition'    : 'transitionend',
			'OTransition'      : 'oTransitionEnd',
			'msTransition'     : 'MSTransitionEnd',
			'transition'       : 'transitionend'
		};

		$.WPV.Constants.vendor = {
			transition: $.getCssPropertyName("transition"),
			transitionProperty: $.getCssPropertyName("transition-property"),
			transform: $.getCssPropertyName("transform"),
			transformOrigin: $.getCssPropertyName("transform-origin"),
			transitionDuration: $.getCssPropertyName("transitionDuration"),
			transitionDelay: $.getCssPropertyName("transitionDelay"),
			transitionTimingFunction: $.getCssPropertyName("transitionTimingFunction"),
			transitionEndEvent: transEndEventNames[ Modernizr.prefixed('transition') ]
		};

		$.WPV.Constants.Esing = {
			bounce: 'cubic-bezier(0.0, 0.35, .5, 1.3)',
			linear: 'linear',
			swing: 'ease-in-out',

			// Penner equation approximations from Matthew Lein's Ceaser: http://matthewlein.com/ceaser/
			easeInQuad: 'cubic-bezier(0.550,  0.085, 0.680, 0.530)',
			easeInCubic: 'cubic-bezier(0.550,  0.055, 0.675, 0.190)',
			easeInQuart: 'cubic-bezier(0.895,  0.030, 0.685, 0.220)',
			easeInQuint: 'cubic-bezier(0.755,  0.050, 0.855, 0.060)',
			easeInSine: 'cubic-bezier(0.470,  0.000, 0.745, 0.715)',
			easeInExpo: 'cubic-bezier(0.950,  0.050, 0.795, 0.035)',
			easeInCirc: 'cubic-bezier(0.600,  0.040, 0.980, 0.335)',
			easeInBack: 'cubic-bezier(0.600, -0.280, 0.735, 0.045)',
			easeOutQuad: 'cubic-bezier(0.250,  0.460, 0.450, 0.940)',
			easeOutCubic: 'cubic-bezier(0.215,  0.610, 0.355, 1.000)',
			easeOutQuart: 'cubic-bezier(0.165,  0.840, 0.440, 1.000)',
			easeOutQuint: 'cubic-bezier(0.230,  1.000, 0.320, 1.000)',
			easeOutSine: 'cubic-bezier(0.390,  0.575, 0.565, 1.000)',
			easeOutExpo: 'cubic-bezier(0.190,  1.000, 0.220, 1.000)',
			easeOutCirc: 'cubic-bezier(0.075,  0.820, 0.165, 1.000)',
			easeOutBack: 'cubic-bezier(0.175,  0.885, 0.320, 1.275)',
			easeInOutQuad: 'cubic-bezier(0.455,  0.030, 0.515, 0.955)',
			easeInOutCubic: 'cubic-bezier(0.645,  0.045, 0.355, 1.000)',
			easeInOutQuart: 'cubic-bezier(0.770,  0.000, 0.175, 1.000)',
			easeInOutQuint: 'cubic-bezier(0.860,  0.000, 0.070, 1.000)',
			easeInOutSine: 'cubic-bezier(0.445,  0.050, 0.550, 0.950)',
			easeInOutExpo: 'cubic-bezier(1.000,  0.000, 0.000, 1.000)',
			easeInOutCirc: 'cubic-bezier(0.785,  0.135, 0.150, 0.860)',
			easeInOutBack: 'cubic-bezier(0.680, -0.550, 0.265, 1.550)'
		};

		$.WPV.Constants.Events = {
			touchstart: "ontouchstart" in document.documentElement ? "touchstart" : "mousedown",
			mousemove: "ontouchmove" in document.documentElement ? "touchmove" : "mousemove",
			mouseup: "ontouchend" in document.documentElement ? "touchend" : "mouseup"
		};

		$.camelCase2dashes = function(str) {
			return str.replace(/[A-Z]/g, function(letter) {
				return "-" + letter.toLowerCase();
			});
		};

		function createCountingCallback(count, callback, scope, strict) {
			return function() {
				count--;
				if ((count === 0 && strict) || (count < 1 && !strict)) {
					callback.call(scope || {});
				}
			};
		}

		// $.createCountingCallback
		$.createCountingCallback = createCountingCallback;

		// $.fn.setTransition
		$.fn.setTransition = function(props, duration, easing, delay, callback) {

			return this.unsetTransition().each(function(i, o) {
				var $o = $(o);

				var meta = {
					cssOld: {},
					cssNew: {},
					cssFrom: {},
					props: props,
					timer: 0,
					callback: callback,
					easing: easing && easing in $.WPV.Constants.Esing ? easing : "swing",
					duration: !duration && duration !== 0 ? 600 : duration,
					delay: delay
				};

				$o.data("transitionMetadata", meta);

				var transitionProperty = [],
				hasCompletedProps,
				cur, val,
				testEl = $('<div/>');
				for (var x in props) {

					cur = $o.css(x);
					val = props[x];

					testEl.css(x, val);
					if (testEl.css(x) === cur) {
						hasCompletedProps = true;
						continue;
					}

					meta.cssFrom[x] = cur;
					transitionProperty.push($.camelCase2dashes(x));
				}
				testEl = null;

				transitionProperty = transitionProperty.join(", ");

				if (!transitionProperty) {
					if (hasCompletedProps && $.isFunction(callback)) {
						$o.delay(delay || 0).queue(function() {
							callback.call(o);
							$o.dequeue();
						});
					}
					return;
				}

				if ($.WPV.Constants.vendor.transition) {
					meta.cssOld[$.WPV.Constants.vendor.transition] = o.style[$.WPV.Constants.vendor.transition];
					meta.cssOld[$.WPV.Constants.vendor.transitionProperty] = o.style[$.WPV.Constants.vendor.transitionProperty];
					meta.cssOld[$.WPV.Constants.vendor.transitionDelay] = o.style[$.WPV.Constants.vendor.transitionDelay];
					meta.cssOld[$.WPV.Constants.vendor.transitionDuration] = o.style[$.WPV.Constants.vendor.transitionDuration];
					meta.cssOld[$.WPV.Constants.vendor.transitionTimingFunction] = o.style[$.WPV.Constants.vendor.transitionTimingFunction];

					meta.cssNew[$.WPV.Constants.vendor.transition] = "";
					meta.cssNew[$.WPV.Constants.vendor.transitionProperty] = transitionProperty;
					meta.cssNew[$.WPV.Constants.vendor.transitionDelay] = (delay || 0) + "ms";
					meta.cssNew[$.WPV.Constants.vendor.transitionDuration] = meta.duration + "ms";
					meta.cssNew[$.WPV.Constants.vendor.transitionTimingFunction] = $.WPV.Constants.Esing[meta.easing];

					meta.onTransitionEnd = function(e) {
						if (e.target === o) {
							if (e.propertyName && (props.hasOwnProperty(e.propertyName) || props.hasOwnProperty($.camelCase(e.propertyName)))) {
								//console.log("DONE", transitionProperty)
								$o.unsetTransition(1, 1);
							}
						}
					};

					this.addEventListener($.WPV.Constants.vendor.transitionEndEvent, meta.onTransitionEnd, false);
					//console.dir(meta);
					$o.css(meta.cssFrom).css(meta.cssNew);

					//setTimeout(function() {
						meta.timer = setTimeout(function() {
							$o.unsetTransition(1, 1);
						}, meta.duration + (delay || 0));

						$o.css(props);
					//}, 18);
} else {
	$o.delay(delay || 0).originalAnimate(props, {
		duration: meta.duration,
		easing: meta.easing,
		complete: callback,
		queue: true
	});
}
});
};

$.fn.unsetTransition = function(goToEnd, callCallback) {
	return this.each(function(i, o) {

		var $o = $(o),
		meta = $o.data("transitionMetadata");

		if (!$.WPV.Constants.vendor.transition) {
			$o.originalStop(1, goToEnd && callCallback);
		}

		if (meta) {
			if ($.WPV.Constants.vendor.transition) {
				if (meta.timer) {
					clearTimeout(meta.timer);
				}
				o.removeEventListener($.WPV.Constants.vendor.transitionEndEvent, meta.onTransitionEnd, false);

				if (goToEnd) {
					$o.css(meta.cssOld).css(meta.props);
					if (callCallback && $.isFunction(meta.callback)) {
						meta.callback.call(o);
					}
				} else {
					var now = {};
					for (var x in meta.props) {
						now[x] = $o.css(x);
					}
					$o.css($.WPV.Constants.vendor.transition, "none").css(now).css(meta.cssOld);
				}
			}
			meta = null;
			$o.removeData("transitionMetadata");
		}
	});
};

$.fn.undoTransition = function(animated) {
	return this.each(function(i, o) {
		var $o = $(o),
		meta = $o.data("transitionMetadata");

		if (meta) {
			$o.unsetTransition();
			if (animated) {
				$o.setTransition(meta.cssFrom, meta.duration, meta.easing, meta.delay);
			} else {
				$o.css(meta.cssFrom);
			}

			meta = null;
		}
	});
};

		// $.fn.wpvAddClass
		$.fn.wpvAddClass = function(className, duration, easing, delay, callback) {
			var cb = createCountingCallback(this.length, callback || $.noop, this);
			this.delay(delay || 0).queue(function() {
				if (jQuery.WPV.Constants.vendor.transition) {
					//$(this).setTransition("all", duration, easing, 0, cb).addClass(className);
					var css = {};
					css[$.WPV.Constants.vendor.transition] = "";
					css[$.WPV.Constants.vendor.transitionProperty] = "all";
					css[$.WPV.Constants.vendor.transitionDelay] = (delay || 0) + "ms";
					css[$.WPV.Constants.vendor.transitionDuration] = (duration || 0) + "ms";
					css[$.WPV.Constants.vendor.transitionTimingFunction] = $.WPV.Constants.Esing[easing];
					$(this).css(css).addClass(className);
				} else {
					$(this).addClass(className, duration, easing, cb);
				}
			});
			return this.dequeue();
		};

		// $.fn.wpvRemoveClass
		$.fn.wpvRemoveClass = function(className, duration, easing, delay, callback) {
			var cb = createCountingCallback(this.length, callback || $.noop, this);
			this.delay(delay || 0).queue(function() {
				if (jQuery.WPV.Constants.vendor.transition) {
					//$(this).setTransition("all", duration, easing, 0, cb).removeClass(className);
					var css = {};
					css[$.WPV.Constants.vendor.transition] = "";
					css[$.WPV.Constants.vendor.transitionProperty] = "all";
					css[$.WPV.Constants.vendor.transitionDelay] = (delay || 0) + "ms";
					css[$.WPV.Constants.vendor.transitionDuration] = (duration || 0) + "ms";
					css[$.WPV.Constants.vendor.transitionTimingFunction] = $.WPV.Constants.Esing[easing];
					$(this).css(css).removeClass(className);
				} else {
					$(this).removeClass(className, duration, easing, cb);
				}
			});
			return this.dequeue();
		};

		// $.AdaptivePool
		(function() {

			var _pools = {};

			function AdaptivePool(callback) {

				if (!(this instanceof AdaptivePool)) {
					return new AdaptivePool(callback);
				}

				var n = 0,
				inst = this,
				curDelay = this.minDelay,
				id,
				isPaused;
				do {
					id = "pool-" + n++;
				} while (id in _pools);

				function handler() {
					if (isPaused) {
						_pools[id] = setTimeout(handler, 500);
					} else {
						curDelay = callback() ? inst.minDelay : Math.min(curDelay + inst.step, inst.maxDelay);
						_pools[id] = setTimeout(handler, curDelay);
					}
				}

				this.start = function() {
					_pools[id] = setTimeout(handler, 0);
				};

				this.stop = function() {
					clearTimeout(_pools[id]);
				};

				this.pause = function() {
					isPaused = true;
				};

				this.resume = function() {
					isPaused = false;
				};
			}

			AdaptivePool.prototype = {
				minDelay: 0,
				maxDelay: 500,
				step: 5
			};

			$.AdaptivePool = AdaptivePool;
		})();

		// $.fn.watchResize
		// $.fn.unwatchResize
		// $.fn.pauseResizeWatcher
		// $.fn.resumeResizeWatcher
		(function() {
			var _idx = 0,
			_observed = {};

			$.fn.watchResize = function(handler, poolSettings) {
				return this.each(function() {
					var key = $(this).data("resizewatch");
					if (!key || !_observed.hasOwnProperty(key)) {

						key = "elem_" + _idx++;

						var recursive = 0;
						var listener = function() {
							var changed = false;
							if (!recursive) {
								recursive = 1;
								changed = checkSize(key);
								recursive = 0;
							}
							return changed;
						};

						var pool = $.AdaptivePool(listener);
						$.extend(pool, poolSettings);

						_observed[key] = {
							elem: this,
							lastWidth: this.offsetWidth,
							lastHeight: this.offsetHeight,
							handlers: 1,
							pool: pool
						};

						$(this).data("resizewatch", key);

						_observed[key].pool.start();
					} else {
						_observed[key].handlers++;
					}
				}).bind("elementResize", handler);
			};

			$.fn.unwatchResize = function(handler) {
				return this.each(function() {
					var key = $(this).data("resizewatch");
					if (key) {
						if (_observed.hasOwnProperty("key")) {
							_observed[key].pool.stop();
							if (--_observed[key].handlers <= 0) {
								delete _observed[key];
								$(this).removeData("resizewatch");
							}
						}
						$(this).unbind("elementResize", handler);
					}
				});
			};

			$.fn.pauseResizeWatcher = function() {
				return this.each(function() {
					var key = $(this).data("resizewatch");
					if (key) {
						if (_observed.hasOwnProperty("key")) {
							_observed[key].pool.pause();
						}
					}
				});
			};

			$.fn.resumeResizeWatcher = function() {
				return this.each(function() {
					var key = $(this).data("resizewatch");
					if (key) {
						if (_observed.hasOwnProperty("key")) {
							_observed[key].pool.resume();
						}
					}
				});
			};

			function checkSize(key) {
				var o = _observed[key].elem,
				w = o.offsetWidth,
				h = o.offsetHeight,
				c = 0;
				if (w !== _observed[key].lastWidth) {
					_observed[key].lastWidth = w;
					c = 1;
				}
				if (h !== _observed[key].lastHeight) {
					_observed[key].lastHeight = h;
					c = 1;
				}
				if (c) {
					$(o).trigger("elementResize", {
						width: w,
						height: h
					});
					return true;
				}
				return false;
			}

		})(jQuery);

		$.fn.nativeSize = function(reset) {
			var elem = this[0],
			out = {
				width: 0,
				height: 0
			};
			if (elem) {
				var oldW, oldH;
				if (reset) {
					oldW = elem.style.width;
					oldH = elem.style.height;
					$(elem).css({
						width: "auto",
						height: "auto"
					});
				}

				out.width = elem.naturalWidth || elem.width || /*elem.scrollWidth  ||*/
				$(elem).width();
				out.height = elem.naturalHeight || elem.height || /*elem.scrollHeight ||*/
				$(elem).height();

				if (reset) {
					$(elem).css({
						width: oldW,
						height: oldH
					});
				}
			}

			return out;
		};

		$.fn.toFixedWidth = function() {
			return this.each(function() {
				$(this).css("width", $(this).width());
			});
		};

		/**
		 * @param {Object} obj  The object to loop
		 * @param {String} path The path to set or get
		 * @param {any} value   The value to set
		 * @returns {any} In GET mode returns the value contained at the desired
		 *                path or undefined if that path was not found.
		 *                In SET mode returns boolean which is TRUE ONLY is the path
		 *                was set to a value different then it's previous one or if
		 *                it was deleted because the value existed and the new value
		 *                was equal to undefined.
		 */
		$.jsPath = function(obj, path, value) {

			var cur = obj,
				segments = path.replace(/\[['"]?([^\]]+)['"]?\]/g, ".$1").split("."),
				l = segments.length,
				name,
				curPath = [];

			for (var i = 0; i < l; i++) {
				curPath[i] = name = segments[i];
				if (i === l - 1) { // last

					// GET
					if (arguments.length < 3) {
						return cur[name]; // can return undefined here
					}

					// DELETE
					if (value === undefined) {
						if (cur.hasOwnProperty(name)) {
							delete cur[name];
							return true;
						}
						return false;
					}

					// SET
					if (cur[name] !== value) {
						cur[name] = value;
						return true;
					}
					return false;
				} else {
					if (!cur.hasOwnProperty(name)) {
						if (arguments.length === 2) {
							return undefined;
						}
						cur[name] = isNaN(parseFloat(name)) ||
						"" + parseFloat(name) !== "" + name ? {} : [];
					}
					cur = cur[name];
				}
			}
		};

		// $.fn.thumbnail
		(function() {

			$.fn.thumbnail = function(options) {

				var bgSizePropName = $.getCssPropertyName("background-size");

				var cfg = $.extend({
					classNames: "bg-thumbnail",
					resizing: "cover",
					url: "about:blank",
					callback: $.noop,
					autoConfig: false
				}, options);

				return this.each(function(i, container) {

					var element = $('<div/>').addClass(cfg.classNames).appendTo(container);
					var img;

					if (!cfg.url || cfg.url === "about:blank") {
						cfg.callback();
						return;
					}

					if (cfg.autoConfig) {
						element.css({
							width: "100%",
							height: "100%",
							display: "inline-block",
							top: 0,
							left: 0,
							position: "relative",
							margin: 0,
							padding: 0,
							zIndex: 1,
							overflow: "hidden"
						});
					}

					if (bgSizePropName) {
						img = new Image();
						img.onload = function() {
							element.css("backgroundImage", "url('" + this.src + "')").setBgSize(cfg.resizing);
							cfg.callback();
						};
						img.src = cfg.url;
					} else {
						img = $('<img />').appendTo(element);

						if (cfg.autoConfig) {
							img.css({
								display: "block",
								position: "absolute",
								width: "auto",
								height: "auto",
								zIndex: 2
							});
						}

						img.bind("load", function() {
							img = this;
							setTimeout(function() {
								$(img).show().objectFit(cfg.resizing, element);
							}, 0);
							cfg.callback();
						}).attr("src", cfg.url);
					}
				});
};
})();

		/**
		 * @see http://dev.w3.org/csswg/css3-images/#object-fit
		 * @param {String} method One of:
		 *    auto
		 *    none
		 *    crop
		 *    crop-top
		 *    fill
		 *    stretch
		 *    contain
		 *    fit
		 *    cover
		 *    cover-top
		 *    cover-bottom
		 */
		$.fn.objectFit = function(method, container) {

			this.each(function(i, o) {

				var obj = $(o);

				/*
				 * The replaced content is not resized to fit inside the element's
				 * content box: determine the object's concrete object size using
				 * the default sizing algorithm with no specified size, and a
				 * default object size equal to the replaced element's used width
				 * and height.
				 */
				if (method === "auto" || method === "none" || method === "crop") { // crop
					obj.css({
						top: "50%",
						left: "50%",
						width: "auto",
						height: "auto",
						maxWidth: "none",
						maxHeight: "none"
					}).css({
						marginLeft: -obj.width() / 2,
						marginTop: -obj.height() / 2
					});

					return false;
				}

				if (method === "crop-top") {
					obj.css({
						top: 0,
						left: "50%",
						width: "auto",
						height: "auto",
						maxWidth: "none",
						maxHeight: "none"
					}).css({
						marginLeft: -obj.width() / 2,
						marginTop: 0
					});

					return false;
				}

				/*
				 * The replaced content is sized to fill the element's content
				 * box: the object's concrete object size is the element's used
				 * width and height.
				 */
				if (method === "fill" || method === "stretch") {
					obj.css({
						width: "100%",
						height: "100%",
						top: 0,
						left: 0,
						marginLeft: 0,
						marginTop: 0
					});

					return false;
				}

				var contentBox = {
					width: container.width(),
					height: container.height()
				};

				if (!contentBox.width || !contentBox.height) {
					setTimeout(function() {
						$(o).objectFit(method, container);
					}, 1000);
					return;
				}

				if (!o.parentNode.parentNode.resizeWatchAttached) {
					o.parentNode.parentNode.resizeWatchAttached = 1;
					$(o.parentNode.parentNode).watchResize(function() {
						$(o).objectFit(method, container);
					}, {
						minDelay: 20,
						maxDelay: 500,
						step: 25
					});
				}

				//console.dir(contentBox)
				var naturalSize = obj.nativeSize(true);
				var width, height;

				/*
				 * The replaced content is sized to maintain its aspect ratio while
				 * fitting within the element's content box: its concrete object
				 * size is resolved as a contain constraint against the element's
				 * used width and height.
				 */
				if (method === "contain" || method === "fit") {
					height = naturalSize.height * (contentBox.width / naturalSize.width);
					width = contentBox.width;
					if (height > contentBox.height) {
						width = naturalSize.width * (contentBox.height / naturalSize.height);
						height = contentBox.height;
					}
					obj.css({
						top: "50%",
						left: "50%",
						width: width,
						height: height,
						marginLeft: -width / 2,
						marginTop: -height / 2
					});

					return false;
				}

				/*
				 * The replaced content is sized to maintain its aspect ratio while
				 * filling the element's entire content box: its concrete object
				 * size is resolved as a cover constraint against the element's
				 * used width and height.
				 */
				if (method === "cover") {
					width = contentBox.width;
					height = naturalSize.height * (contentBox.width / naturalSize.width);

					if (height < contentBox.height) {
						width = naturalSize.width * (contentBox.height / naturalSize.height);
						height = contentBox.height;
					}

					obj.css({
						maxWidth: "none",
						maxHeight: "none",
						top: "50%",
						left: "50%",
						width: width,
						height: height,
						marginLeft: -width / 2,
						marginTop: -(height / 2)
					});

					return false;
				}

				if (method === "cover-top" || method === "cover-bottom") {
					height = naturalSize.height * (contentBox.width / naturalSize.width);
					width = contentBox.width;
					if (height < contentBox.height) {
						width = naturalSize.width * (contentBox.height / naturalSize.height);
						height = contentBox.height;
					}
					obj.css({
						maxWidth: "none",
						maxHeight: "none",
						top: method === "cover-top" ? 0 : "auto",
						bottom: method === "cover-top" ? "auto" : 0,
						left: "50%",
						width: width,
						height: height,
						marginLeft: -width / 2,
						marginTop: 0,
						marginBottom: 0
					});

					return false;
				}

				});

return this;
};

$.fn.setBgSize = function(val) {

	var bgSizePropName = $.getCssPropertyName("background-size");

	if (bgSizePropName) {
		switch (val) {
			case "contain":
			case "cover":
			this.css(bgSizePropName, val).css("backgroundPosition", "50% 50%");
			break;
			case "fit":
			this.css(bgSizePropName, "contain").css("backgroundPosition", "50% 50%");
			break;
			case "cover-top":
			this.css(bgSizePropName, "cover").css("backgroundPosition", "50% 0%");
			break;
			case "cover-bottom":
			this.css(bgSizePropName, "cover").css("backgroundPosition", "50% 100%");
			break;
			case "fill":
			this.css(bgSizePropName, "100% 100%").css("backgroundPosition", "0% 0%");
			break;
			case "crop-top":
			this.css(bgSizePropName, "auto").css("backgroundPosition", "50% 0%");
			break;
			case "none":
			case "auto":
			case "crop":
			/* falls through */
			default:
			this.css(bgSizePropName, "auto").css("backgroundPosition", "50% 50%");
			break;
		}
	}

	return this;
};

		/**
		 * Modified version if the touchwipe plugin by  Andreas Waltl,
		 * netCU Internetagentur (http://www.netcu.de)
		 * We have added support for the desktop browsers, so it works the same with
		 * mouse events too.
		 */
		$.fn.touchwipe = function(settings) {
			var config = {
				min_move_x: 20,
				min_move_y: 20,
				wipeLeft: function() {},
				wipeRight: function() {},
				wipeUp: function() {},
				wipeDown: function() {},
				preventDefaultEvents: true,
				canUseEvent: function() {
					return true;
				}
			};

			if (settings) {
				$.extend(config, settings);
			}

			this.each(function(i, o) {
				var startX;
				var startY;
				var isMoving = false;

				function cancelTouch() {
					$(o).unbind("touchmove", onTouchMove);
					startX = null;
					isMoving = false;
				}

				function onTouchMove(e) {
					if (config.preventDefaultEvents) {
						e.preventDefault();
					}
					if (isMoving) {
						var x = e.originalEvent.touches ? e.originalEvent.touches[0].pageX : e.pageX;
						var y = e.originalEvent.touches ? e.originalEvent.touches[0].pageY : e.pageY;
						var dx = startX - x;
						var dy = startY - y;
						if (Math.abs(dx) >= config.min_move_x) {
							cancelTouch();
							if (dx > 0) {
								config.wipeLeft.call(o, e);
							} else {
								config.wipeRight.call(o, e);
							}
						} else if (Math.abs(dy) >= config.min_move_y) {
							cancelTouch();
							if (dy > 0) {
								config.wipeDown.call(o, e);
							} else {
								config.wipeUp.call(o, e);
							}
						}
					}
				}

				function onTouchStart(e) {
					if (!config.canUseEvent(e)) {
						return true;
					}
					if (e.originalEvent.touches) {
						if (e.originalEvent.touches.length > 1) {
							return true;
						}
						startX = e.originalEvent.touches[0].pageX;
						startY = e.originalEvent.touches[0].pageY;
					} else {
						startX = e.pageX;
						startY = e.pageY;
					}
					isMoving = true;
					$(o).bind("touchmove", onTouchMove);
					if (config.preventDefaultEvents) {
						e.preventDefault();
					}
					e.stopPropagation();
				}

				$(o).bind("touchstart", onTouchStart);
			});
return this;
};

})(jQuery);
})();