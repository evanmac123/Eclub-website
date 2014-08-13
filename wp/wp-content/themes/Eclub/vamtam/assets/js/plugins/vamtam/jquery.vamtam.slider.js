////////////////////////////////////////////////////////////////////////////////
/* global window */

;(function($) {
	"use strict";

	var toString = Object.prototype.toString;
	var bgSizePropName = $.getCssPropertyName("background-size");

	function is(x, type) {
		return toString.call(x) === "[object " + type + "]";
	}

	function log() {
		if (window.console && console.log) {
			$.each(arguments, function(i, arg) {
				console.log(arg);
			});
		}
	}

	function intVal(x, defaultValue) {
		x = parseInt(x, 10);
		if (isNaN(x)) {
			x = defaultValue === undefined ? 0 : defaultValue;
		}
		return x;
	}

	function getDirection(oldPos, newPos, length, arg) {
		if (arg === "next") return 1;
		if (arg === "prev") return -1;
		if (oldPos === length - 1 && newPos === 0) return 1;
		if (oldPos === 0 && newPos === length - 1) return -1;
		return oldPos < newPos ? 1 : -1;
	}

	var uid = (function() {
		var n = 1;
		return function() {
			return "uid_" + n++;
		};
	})();

	var isMobile = {
		Android: function() {
			return (/Android/i).test(navigator.userAgent);
		},
		BlackBerry: function() {
			return (/BlackBerry/i).test(navigator.userAgent);
		},
		iPhone: function() {
			return (/iPhone/i).test(navigator.userAgent);
		},
		iPad: function() {
			return (/iPad/i).test(navigator.userAgent);
		},
		iPod: function() {
			return (/iPod/i).test(navigator.userAgent);
		},
		iOS: function() {
			return this.iPhone() || this.iPad() || this.iPod();
		},
		Opera: function() {
			return (/Opera Mini/i).test(navigator.userAgent);
		},
		Windows: function() {
			return (/IEMobile/i).test(navigator.userAgent);
		},
		Fennec: function() {
			return (/Fennec/i).test(navigator.userAgent);
		},
		any: function() {
			return (
			this.Android() || this.BlackBerry() || this.iOS() || this.Opera() || this.Windows() || this.Fennec());
		}
	};

	function isSmallScreen() {
		return screen.width < 600 || screen.height < 800;
	}

	/**
	 * @class VamtamSlider
	 * ====================================================================== */
	var _VamtamSlider_Instances = 1;

	function VamtamSlider(options, element) {
		this.__INST_ID = "Slider_" + _VamtamSlider_Instances++;
		this._path = [0];
		this._fxId = null;
		this._fxUID = null;
		this._timer = null;
		this.options = {};
		this._listeners = {};
		this._resizeHandlers = {};
		this.element = $(element).addClass("vamtam-slider loading").css("visibility", "hidden")[0];
		this.slides = [];
		this._slideshowController = {
			start: 0,
			end: 0,
			pos: 0
		};

		this.option($.extend({}, VamtamSlider.defaults, options));

		var self = this;

		if (this.options.pauseOnHover) {
			$(this.element)
				.mouseover(function() {
				self.pause();
			})
				.mouseleave(function() {
				self.resume();
			});
		}

		var h1 = intVal(this.options.initialHeight);

		var h2 = this.options.height;
		if ($.isFunction(h2)) h2 = h2();
		h2 = intVal(h2);

		if (!h1 || h1 === h2) {
			$(this.element).css("height", this._getDisplayHeight());
		} else {
			$(this.element).css("height", Math.abs(intVal(h1, intVal(h2, 100))));
		}

		function _callSizeGetters(force) {
			if (force || _self._loaded) {
				var hasListeners = false;
				for (var f in _self._resizeHandlers) {
					hasListeners = true;
					_self._resizeHandlers[f](_self);
				}

				if (hasListeners && _self._loaded) {
					$(_self.element).height(_self._getDisplayHeight());
					_self.resizing(_self.options.resizing);
				}
			}
		}

		var _self = this,
			_lastWidth;
		$(window).bind(
			"resize." + this.__INST_ID,

		function() {
			var w = $(_self.element).width();
			if (w && w !== _lastWidth) {
				_lastWidth = w;
				_callSizeGetters();
			}
		});

		//$(this.element).bind("beforeExpand", function() { _callSizeGetters(true); });

		var _unFilteredSlides;
		this.filter = function(fn, goToIndex) {

			if (!self._fxId) throw "No effect has been set yet, so I can't filter the slides now";

			if (!$.isFunction(VamtamSlider.Effects[self._fxId].uninit)) throw "The current effect must have 'uninit' method to be compatible with the filter functionality";

			if (!_unFilteredSlides) {
				_unFilteredSlides = self.slides;
			}

			this.showLoadingMask(function() {
				var filtered = [];

				self.foreachSlide(function(i, slide, parentSlide) {
					slide.element = null;
					if (!parentSlide && fn(slide) !== false) {
						filtered.push(slide);
					}
				}, _unFilteredSlides);


				$.VamtamSlider.Effects[self._fxId].uninit(self);
				$(".slide-wrapper", self.element).remove();
				self.slides = filtered;
				self._path = [0];
				self._loaded = false;

				self._initAllSlides(function() {
					$.VamtamSlider.Effects[self._fxId].init(self);
					setTimeout(function() {
						self.pos(goToIndex || 0);
						self._loaded = true;
						self.hideLoadingMask();
					}, 0);
				});
			});
		};

		//_callSizeGetters(true);
		this._load();
	}

	// This can be accessed and modified through "$.VamtamSlider.defaults"
	VamtamSlider.defaults = {
		pauseTime: 8000,
		animationTime: 2000,
		pauseOnHover: true,
		autostart: true,
		easing: "swing",
		effect: "fade",
		useKeyboard: true,
		autoFocus: false,
		pager: "auto",
		resizing: "cover",
		initialHeight: null,
		minHeight: 100,
		height: 300,
		maintainAspectRatio: false,
		maxWidth: null,
		loadingMask: true,
		captionContainer: null, // Can be custom container or selector for it
		captionQueue: true,
		//captionFxTime    : 400,
		captionFxEasing: "swing",
		captionFxDelay: 0,
		initialIndex: 0,
		complexSlidesDuration: 3000,
		forceNestedAnimationTimes: false,
		disableOnMobiles: false
	};

	VamtamSlider.create = function(name, Constructor, defaults) {
		var dataName = "vamtamSlider";
		$.fn[name] = function(arg) {
			var isMethodCall = typeof arg === "string",
				args = Array.prototype.slice.call(arguments, 1),
				returnValue = this;

			// prevent calls to internal methods
			if (isMethodCall && (/\b_/).test(arg)) {
				return returnValue;
			}

			if (isMethodCall) {
				this.each(function() {

					// get the instance
					var instance = $(this).data(dataName);
					if (!instance) {
						throw "cannot call methods on " + name +
							" prior to initialization; " +
							"attempted to call method '" + arg + "'";
					}

					// get the method
					var method = $.jsPath(instance, arg);
					if (!$.isFunction(method)) {
						throw "no such method '" + arg + "' for " + name +
							" widget instance";
					}

					// call the method
					var methodValue = method.apply(instance, args);
					if (methodValue !== instance && methodValue !== undefined) {
						returnValue = methodValue;
						return false; // break each
					}
				});
			} else {
				var opts = $.extend(true, {}, defaults || VamtamSlider.defaults, arg);
				this.each(function() {
					var instance = $(this).data(dataName);
					if (instance) {
						instance.option(opts);
					} else {
						$(this).data(dataName, new Constructor(opts, this));
					}
				});
			}

			return returnValue;
		};
	};

	VamtamSlider.prototype = {

		on: function(evt, handler) {
			evt = String(evt).toLowerCase();
			if (!_listeners[evt]) _listeners[evt] = [];
			_listeners[evt].push(handler);
		},

		_notify: function(evt, args) {
			evt = String(evt).toLowerCase();
			var self = this;
			$.each(_listeners[evt] || [], function(i, fn) {
				return fn.apply(self, $.makeArray(args));
			});
		},

		option: function(a, b) {
			// No arguments - return all the options
			if (a === null) {
				return this.options;
			}

			// Called with an object - extend the options
			if ($.isPlainObject(a)) {
				for (var k in a) {
					this.option(k, a[k]);
				}
				//$.extend(true, this.options, a);
				return this;
			}

			// named option
			if (a && typeof a === "string") {
				var method;

				// get
				if (b === undefined) {
					method = "_getOption_" + a;
					if ($.isFunction(this[method])) {
						return this[method]();
					}
					return $.jsPath(this.options, a);
				}

				// set
				method = "_setOption_" + a;
				if ($.isFunction(this[method])) {
					this[method](b);
				} else {
					$.jsPath(this.options, a, b);
				}
				return this;
			}
		},

		_setOption_loadingMask: function(val) {
			if (val && typeof val === "string") { // selector
				this._loadingMask = $(val).addClass("vamtam-slider-loading-mask");
			} else if (val) {
				if (!this._loadingMask) {
					this._loadingMask = $('<div class="vamtam-slider-loading-mask" />')
						.appendTo(this.element);
				}
			} else {
				this._loadingMask = null;
			}
		},

		_setWindowSizeDependentOption: function(name, value) {
			if ($.isFunction(value)) {
				var self = this;
				this._resizeHandlers[name] = function() {
					self.options[name] = value(self);
				};
				self.options[name] = value(self);
			} else {
				this.options[name] = value;
				if (name in this._resizeHandlers) {
					delete this._resizeHandlers[name];
				}
			}
		},

		_setOption_maintainAspectRatio: function(val) {
			this._setWindowSizeDependentOption("maintainAspectRatio", val);
		},

		_setOption_height: function(val) {
			this._setWindowSizeDependentOption("height", val);
		},

		_setOption_captionContainer: function(val) {
			if (val && typeof val === "string") { // selector
				this._captionContainer = $(val);
			} else if (val) {
				if (!this._captionContainer) {
					this._captionContainer = $('<div class="vamtam-slider-caption-container" />')
						.appendTo(this.element);
				}
			} else {
				this._captionContainer = null;
			}
		},

		_getIsHtmlOnly: function() {
			var out = true;
			$.each(this.slides, function(i, slide) {
				if (slide.type !== "html") {
					out = false;
					return false;
				}
			});
			return out;
		},

		_getCaptionContainer: function() {
			if (!this._captionContainer) {
				this._setOption_captionContainer(true);
			}
			return this._captionContainer;
		},

		_initAllSlides: function(callback) {
			var len = this.countSlides(),
				ready = 0,
				self = this;

			function onSlideLoaded() {
				if (++ready >= len) {
					callback();
				}
			}

			this.foreachSlide(function(i, slide) {
				self._initSlide(slide, onSlideLoaded);
			});
		},

		_initSlide: function(slide, callback, parentContainer) {

			var self = this;

			function onComplete() {
				if ($.isArray(slide.captions) && slide.captions.length) {
					var container = $('<div class="captions-wrapper"/>')
						.appendTo(self._getCaptionContainer());
					$(slide.wrapper).data("captionsWrapper", container[0]);
					$.each(slide.captions, function(i, o) {
						var c = $('<div class="caption n' + (i + 1) + '"/>');
						c.html(o.html);
						if (o.style) {
							c.css(o.style);
						}
						c.appendTo(container);
						//$(slide.element).data("caption" + (i + 1), c);
					});
				}
				callback();
			}

			switch (slide.type) {
				case "img":
				case "image":
					this._initImageSlide(slide, onComplete, parentContainer);
					break;
				case "html":
					this._initHtmlSlide(slide, onComplete, parentContainer);
					break;
				case "gallery":
					this._initGallerySlide(slide, onComplete, parentContainer);
					break;
				default:
					// Consider unknown types to be loaded
					onComplete();
					break;
			}
		},

		_initImageSlide: function(slide, callback, container) {
			if (slide.element) {
				callback();
				return;
			}

			var self = this;

			slide.wrapper = $('<div class="slide-wrapper" />').appendTo(container || self.element);

			if (bgSizePropName) {
				slide.element = $('<div class="slide type-bg-image"/>')
					.appendTo(slide.wrapper)[0];
				var img = new Image();
				img.onload = function() {
					slide.element.style.backgroundImage = "url('" + this.src + "')";
					$(slide.element).setBgSize(self.options.resizing);
					setTimeout(function() {
						img = null;
					}, 10);
					callback();
				};

				if('RetinaImagePath' in window && window.devicePixelRatio > 1) {
					var path = new RetinaImagePath(slide.url);
					path.check_2x_variant(function(hasVariant) {
						img.src = hasVariant ? path.at_2x_path : slide.url;
					});
				} else {
					img.src = slide.url;
				}
			} else {
				slide.element = $('<img class="slide type-image" />').appendTo(slide.wrapper)[0];
				$(slide.element).bind("load", function() {
					$(this).objectFit(self.options.resizing, $(container || self.element));
					callback();
				})
					.attr("src", slide.url);
			}

			if (slide.style) {
				$(slide.element).css(slide.style);
			}

			// Attach the on-click behavior if needed 
			if (slide.href) {
				$(slide.wrapper).css({
					cursor: "pointer"
				}).click(function(e) {

					// Respect those
					if (e.isDefaultPrevented()) {
						return false;
					}

					if (!$(this).is(".active")) {
						return false;
					}

					var target = String(slide.hrefTarget || "self").replace(/^_/, "");
					if (target === "blank" || target === "new") {
						window.open(slide.href);
					} else {
						try {
							// top, parent, self, frame name...
							window[target].location = slide.href;
						} catch (ex) {
							// perhaps cross-domain restriction
							log(ex);
						}
					}
				});
			}
		},

		_initHtmlSlide: function(slide, callback, container) {
			if (!slide.element) {
				slide.wrapper = $('<div class="slide-wrapper" />').appendTo(container || this.element);
				slide.element = $('<div class="slide type-html"/>')
					.appendTo(slide.wrapper)
					.html(slide.html)[0];

				if (slide.style) {
					$(slide.element).css(slide.style);
				}
			}
			callback();
		},

		_initGallerySlide: function(slide, callback) {
			if (slide.element) {
				callback();
			}

			var len = slide.children.length,
				done = 0,
				cb = function() {
					if (++done >= len) callback();
				};

			slide.wrapper = $('<div class="slide-wrapper" />').appendTo(this.element);

			for (var i = 0; i < len; i++) {
				this._initSlide(slide.children[i], cb, slide.wrapper);
			}
		},

		_getDisplayHeight: function() {
			var h = this.options.height,
				arg = String(h).toLowerCase(),
				total = 0,
				isDynamic = (/^(min|max|avg|auto|0)$/).test(String(h).toLowerCase()),
				isFn = $.isFunction(h);

			if (isFn) {
				h = h(this);
			}

			if (isDynamic) {
				h = arg === "max" || arg === "auto" || arg === "0" ? 0 : Infinity;

				var wrapper = $(this.element).parent();
					//, origHeight = wrapper.css("minHeight");

				wrapper.css("minHeight", this.element.scrollHeight);

				this.element.style.height = "auto";

				$(".slide", this.element).each(function(i, o) {
					var currentHeight = o.scrollHeight;
					if($(o).is('.type-bg-image'))
						currentHeight = 2/3*o.scrollWidth;

					if ((arg === "auto" || arg === "0") && $(o).is(".active .slide")) {
						h = currentHeight;
						return false;
					} else if (arg === "max" || arg === "auto" || arg === "0") {
						h = Math.max(h, currentHeight);
					} else if (arg === "min") {
						h = Math.min(h, currentHeight);
					} else if (arg === "avg") {
						total += currentHeight;
					}
				});

				//wrapper.css("minHeight", origHeight);
			}

			if (arg === "avg") h = total / this.slides.length;

			if (!this._initialWidth) {
				this._initialWidth = $(this.element).width();
				this._isHtmlOnly = this._getIsHtmlOnly();
			}

			if (this.options.maintainAspectRatio /*&& !this._isHtmlOnly*/ && !isFn) h *= $(this.element).width() / (this.options.maxWidth || this._initialWidth);

			if (this.options.minHeight) h = Math.max(this.options.minHeight, h);

			if (this.options.maxHeight) h = Math.min(this.options.maxHeight, h);

			if (arg === "auto") h = Math.max(this.element.scrollHeight, h);

			return h;
		},

		showLoadingMask: function(cb) {
			if (this._loadingMask && $(this._loadingMask).length) {
				$(this._loadingMask).show().setTransition({
					opacity: 1
				}, 200, "swing", 0, cb);
			} else {
				(cb || $.noop)();
			}
		},

		hideLoadingMask: function(cb, delay) {
			if (this._loadingMask && $(this._loadingMask).length) {
				$(this._loadingMask).setTransition({
					opacity: 0
				},
				$(this.element).is(".slider-shortcode-wrapper .vamtam-slider") ? 2 : 1000,
					"swing",
				delay || 0,

				function() {
					$(this).hide();
					(cb || $.noop)();
				});
			} else {
				(cb || $.noop)();
			}
		},

		/**
		 * Use the "slider-disabled" class to display something different
		 * with CSS...
		 */
		_disable: function() {
			$(this.element).parent().addClass("slider-disabled");
		},

		_load: function() {

			if (this.options.disableOnMobiles) {
				if (isSmallScreen()) {
					return this._disable();
				}

				if (isMobile.any() && !isMobile.iPad()) {
					return this._disable();
				}
			}

			var self = this,
				resizing = self.options.resizing,
				// duration = self.options.animationTime,
				showTime = (this.element.id === "header-slider") ? 1500 : 200,
				$element = $(this.element);

			// Start with no image resizing (the expand animation runs better)
			self.resizing("none");

			// Make it visible but transparent so that JS measurements can work
			$element.css({
				opacity: 0,
				visibility: "visible"
			});

			// Load images, create DOM etc.
			this._initAllSlides(function() {

				// Hide all slides to exclude them from repainting on each animation frame 
				$element.find(".slide-wrapper").css("display", "none");

				// The resizeWatcher can be heavy. Pause it if something has 
				// started it already.
				$element.pauseResizeWatcher();

				// Each theme may be interested to do some stuff before the 
				// initial expanding begins.
				$element.trigger("beforeExpand", [self]);

				// Resize the container
				$element.setTransition({
					height: Math.round(self._getDisplayHeight())
				}, showTime, "swing", 0, function() {

					// Set the effect and let it initialize itself
					self.fx(self.options.effect);

					// Initialize the plugins
					for (var x in self) {
						if (x.indexOf("_init_") === 0 && $.isFunction(self[x])) {
							self[x]();
						}
					}

					// Now show the slides
					// $element.find(".slide-wrapper").css("display", "block");

					// Re-initialize the choosen effect in case it needs to hide
					// some of the slides
					// $.VamtamSlider.Effects[self.fx()].init(self);

					// This needs to be started befor going to the initial position
					$element.bind("slideComplete", function() {
						if (self.options.height === "auto") $element.height(self._getDisplayHeight());
					});

					// Go to the initial slide
					self.pos(self.options.initialIndex || 0, function() {

						$element.trigger("sliderStarted", [self]);

						self.pause();

						// Switch to the real image resizing if needed
						if (resizing !== "none") {
							self.resizing(resizing);
						}

						$element.watchResize(function() {
							if (self.options.maintainAspectRatio) $element.height(self._getDisplayHeight());
							self.resizing(self.options.resizing);
						});

						$element.resumeResizeWatcher();

						$element.trigger("elementResize", {
							width: $element.width(),
							height: $element.height()
						});

						// Finally show the slider
						$element.setTransition({
							opacity: 1
						}, 800, "easeInQuad", 200, function() {

							// Notify about the end of the expand animation
							$element.trigger("afterExpand", [self]);

							// Hide the loading mask
							self.hideLoadingMask($.noop, 200);

							self._loaded = true;
							$element.removeClass("loading animated").addClass("loaded");

							// Initial focus to catch the keyboard events
							$element.attr("tabindex", "-1");
							if (self.options.autoFocus && "ontouchstart" in document.documentElement) {
								setTimeout(function() {
									$element.trigger("focus");
								}, 500);
							}

							self.resume();

							// Auto-run
							var dir = self.options.autostart === "right" ? 1 : self.options.autostart === "left" ? -1 : 0;
							if (dir !== 0) {
								self.start(dir);
							}

							$element.trigger("sliderReady", [self]);
						});
					});
				});
			});
		},

		_setOption_slides: function(slides) {
			var s = $.extend([], slides),
				l = s.length;
			if (!l) {
				log("Slider: Action canceled - the slider has no slides.");
				return;
			}

			this.slides = s;
		},

		resizing: function(arg) {
			if (!arg) return this.options.resizing;

			var self = this;

			this.foreachSlide(function(i, slide) {

				if (slide.element) {
					switch (slide.type) {
						case "img":
						case "image":
							if (bgSizePropName) $(slide.element).setBgSize(arg);
							else $(slide.element).objectFit(arg, $(self.element));
							break;
						case "html":
							//$(slide.element).objectFit("fill", $(self.element));
							break;
						case "video":
							//$(slide.element).objectFit("contain", $(self.element));
							break;
					}
				}
			});
			this.options.resizing = arg;
			return this;
		},

		fx: function(arg) {
			if (!arg) {
				return this._fxId;
			}
			if (!is(arg, "String") || !VamtamSlider.Effects[arg]) {
				log("Invalid effect '" + arg + "' specified. Using 'fade' instead.");
				arg = "fade";
			}

			if (arg === this._fxId) return this;

			// Unload the old one
			if (this._fxId) {
				$(this.element).removeClass("effect-" + this._fxId);
				if ($.isFunction(VamtamSlider.Effects[this._fxId].uninit)) {
					VamtamSlider.Effects[this._fxId].uninit(this);
				}
			}

			// Load the new one
			$(this.element).addClass("effect-" + arg);
			if ($.isFunction(VamtamSlider.Effects[arg].init)) {
				VamtamSlider.Effects[arg].init(this);
			}

			this._fxId = arg;
			return this;
		},

		// Support for nested slide collections
		// =====================================================================
		countSlides: function() {
			var n = 0;
			this.foreachSlide(function() {
				n++;
			});
			return n;
		},

		foreachSlide: function(cb, slides) {
			function loop(set, parent) {
				$.each(set, function(i, o) {
					cb.call(o, i, o, parent);
					if (o.children) loop(o.children, o);
				});
			}
			loop(slides || this.slides);
		},

		_getCurrentSlide: function() {
			var i = 0,
				slide = this.slides[this._path[i]];
			while (++i < this._path.length) {
				slide = slide.children[i];
			}
			return slide;
		},

		_getCurrentSlideSet: function() {
			var set = this.slides,
				i = 0;
			while (i < this._path.length && set[this._path[i]].children) {
				set = set[this._path[i]].children;
				i++;
			}
			return set;
		},

		_canGoIn: function() {
			return !!(this._getCurrentSlide().children || "").length;
		},

		_canGoOut: function() {
			return this._path.length > 1;
		},

		_goIn: function() {
			this._path.push(0);
		},

		_goOut: function() {
			this._path.pop();
		},

		_position: function() {
			return this._path[this._path.length - 1];
		},

		pos: function(arg, callback) {
			//debugger;
			var curPos = this._position();

			// If called with no arguments
			if (!arg && arg !== 0) {
				return curPos;
			}

			// Ignore fast navigation requests
			//if (this._slideshowController.remainingTime > this.options.pauseTime + duration - 300) {
			//	return;
			//}

			var len = this.slides.length;

			// Calculate the new slide index
			var newPos;
			switch (arg) {
				case "first":
					newPos = 0;
					break;
				case "last":
					newPos = len - 1;
					break;
				case "prev":
					newPos = this._position() - 1;
					if (newPos < 0) newPos = len - 1;
					break;
				case "next":
					newPos = this._position() + 1;
					if (newPos >= len) newPos = 0;
					break;
				default:
					newPos = parseInt(arg, 10);
					if (isNaN(newPos) || newPos < 0 || newPos >= len) {
						throw "Invalid goto argument";
					}
			}

			// We cannot move to slide that is current. There is one exception -
			// for the first slide and the first time only (when the slider is 
			// created and the _loaded flag has not yet been set to true).
			if (curPos === newPos && this._loaded) {
				return;
			}

			if ($(this.element).is(".animated")) {
				return;
			}

			// Get the current FX object
			var fx = VamtamSlider.Effects[this.fx()];

			// Use different animation durations for the simple slides and the 
			// complex slides (having nested animations)
			var duration = this.options.animationTime;
			//if ( fx.supportsNesting ) {
			//	if ($(this.slides[newPos].wrapper).find(".transition").length || 
			//		$(this.slides[curPos].wrapper).find(".transition").length) {
			//		duration = this.options.complexSlidesDuration || 4000;
			//	}
			//}

			// Re-configure the _slideshowController to wait for the new slide
			//this._slideshowController.isWaiting = 1;
			//this._slideshowController.remainingTime = this.options.pauseTime + duration;
			//this._slideshowController.pos = 0;

			// Create the onComplete callback
			var done = 0,
				inst = this,
				cb = (function() {
					return function() {
						if (++done === 2 || !inst._loaded) {
							setTimeout(function() {
								$(inst.element).removeClass("animated").trigger("slideComplete");
							}, 100);

							(callback || $.noop)();
						}
					};
				})(newPos);

			this._fxUID = uid();

			// This will be passed as argument to the "run" and "changeCaptions"
			// methods of the current FX object.
			var fxOptions = {
				fxUID: this._fxUID,
				slider: this,
				newIndex: newPos,
				oldIndex: curPos,
				callback: cb,
				toShow: $(this.slides[newPos].wrapper).addClass("active"),
				toHide: $(),
				direction: getDirection(curPos, newPos, this.slides.length, arg),
				duration: this._loaded ? duration : 1,
				easing: this.options.easing
			};

			// fxOptions.toHide is an empty jQuery set, but only the first time 
			// (when there is nothing to hide). Otherwise it is the current 
			// slide wrapper that is about to be hidden.
			if (this._loaded) {
				fxOptions.toHide = $(this.slides[curPos].wrapper).removeClass("active");
			}

			inst._path[inst._path.length - 1] = newPos;

			// Dispatch the slidePositionChange event
			$(this.element).trigger("slidePositionChange", [newPos, curPos, fxOptions.direction]);

			// Mark the slider element with "animated" className before starting
			// the animations.
			$(this.element).addClass("animated");

			// Dispatch the beforeRun event
			$(this.element).trigger("beforeRun");



			// RUN THE FX!!!
			fx.run(fxOptions);

			this.resizing(this.resizing());

			// Dispatch the afterRun event
			$(this.element).trigger("afterRun");


			if ($.isFunction(fx.changeCaptions)) fx.changeCaptions(fxOptions);
			else this._changeCaptions(fxOptions);


		},

		_changeCaptions: function(cfg) {
			var oldWrapper = cfg.toHide.data("captionsWrapper"),
				newWrapper = cfg.toShow.data("captionsWrapper"),
				duration = this.options.captionFxTime,
				delay = this.options.captionFxDelay || 0,
				easing = this.options.captionFxEasing,
				queue = !! this.options.captionQueue,
				// callback = $.noop,
				sliderRoot = $(this.element);

			// Reset the caption queue (if any)
			sliderRoot.queue("captions", []);

			// Hide new captions if needed
			//$(newWrapper).find(".caption").wpvRemoveClass("visible", 0).css({opacity: 0});

			// Hide old captions
			$(oldWrapper).find(".caption").each(function(i, c) {
				sliderRoot.queue("captions", function() {

					var done = 0;

					function cb() {
						if (++done > 1 && queue) {
							sliderRoot.dequeue("captions");
						}
					}

					$(c).stop(1, 0).delay(delay || 0).animate({
						opacity: 0
					}, {
						duration: duration,
						easing: easing,
						queue: false,
						complete: cb
					});

					$(c).wpvRemoveClass("visible", duration, easing, delay, cb);

					if (!queue) sliderRoot.dequeue("captions");
				});
			});

			// Switch caption containers
			sliderRoot.queue("captions", function() {

				// Hide old captions container
				$(oldWrapper).stop(1, 0).wpvRemoveClass("visible", Math.ceil(duration / 4), "linear", 0);

				// Show new captions container
				$(newWrapper).stop(1, 0).wpvAddClass("visible", Math.ceil(duration / 4), "linear", 0);

				//if (!$.support.opacity) {
				$(oldWrapper).animate({
					opacity: 0
				}, {
					duration: Math.ceil(duration / 4),
					easing: "linear",
					queue: false
				});
				$(newWrapper).animate({
					opacity: 1
				}, {
					duration: Math.ceil(duration / 4),
					easing: "linear",
					queue: false
				});
				//}

				sliderRoot.dequeue("captions");
			});

			// Show new captions
			$(newWrapper).find(".caption").each(function(i, c) {
				sliderRoot.queue("captions", function() {
					//if (!$.support.opacity) {
					$(c).stop(1, 0).delay(delay || 0).animate({
						opacity: 1
					}, {
						duration: duration,
						easing: easing,
						queue: false
					});
					//}

					$(c).wpvAddClass("visible", duration, easing, delay, function() {
						if (queue) sliderRoot.dequeue("captions");
					});

					if (!queue) sliderRoot.dequeue("captions");
				});
			});

			// Append the callback to the queue
			sliderRoot.queue("captions", cfg.callback || $.noop);

			// Start it!
			sliderRoot.dequeue("captions");
		},

		start: function(direction) {

			var tick = 200,
				last = +new Date();

			function checkState(instance) {
				var now = +new Date(),
					diff = now - last,
					ctl = instance._slideshowController;

				last = now;

				if (!ctl.isPaused) {
					if (!ctl.isWaiting) {

						if (!ctl.remainingTime) {
							ctl.remainingTime = instance.options.pauseTime;
							ctl.pos = 0;
							return checkState(instance);
						}

						ctl.remainingTime -= diff;
						ctl.pos = instance.options.pauseTime - ctl.remainingTime;

						if (ctl.remainingTime <= 0) {
							ctl.isWaiting = 1;
							setTimeout(function() {
								instance.pos(direction === -1 ? "prev" : "next", function() {
									ctl.remainingTime = instance.options.pauseTime;
									ctl.isWaiting = 0;
									//inst.start(true);
								});
							}, tick);
						}
					}
				}

				if (ctl.lastPos !== ctl.pos) {
					ctl.lastPos = ctl.pos;
					$(instance.element).trigger("progress", Math.floor(
					(ctl.pos / instance.options.pauseTime) * 100));
				}

				instance._timer = setTimeout(function() {
					checkState(instance);
				}, tick);
			}

			if (this._timer === null) {
				checkState(this);
				$(this.element).trigger("start", direction);
			}
		},

		stop: function() {
			if (this._timer) {
				clearTimeout(this._timer);
				this._timer = null;
				this._slideshowController.isWaiting = 0;
				this._slideshowController.isPaused = 0;
				this._slideshowController.remainingTime = 0;
				this._slideshowController.pos = 0;
				$(this.element).trigger("progress", 0).trigger("stop");
			}
		},

		pause: function() {
			if (this._timer) {
				this._slideshowController.isPaused = 1;
				$(this.element).trigger("pause");
			}
		},

		resume: function() {
			if (this._timer) {
				this._slideshowController.isPaused = 0;
				$(this.element).trigger("resume");
			}
		}
	};


	// Slider Modules - thse can be safely removed
	// =========================================================================

	/* Keyboard navigation -------------------------------------------------- */
	VamtamSlider.prototype._init_keyboardNavigation = function() {
		if (this.options.useKeyboard) {
			var self = this;
			$(this.element).bind("keydown.vslider", function(e) {
				switch (e.keyCode) {
					case 39:
						// right
						self.pos("next");
						e.preventDefault();
						break;
					case 37:
						// left
						self.pos("prev");
						e.preventDefault();
						break;
				}
			});
		}
	};

	/* SliderPager ---------------------------------------------------------- */
	VamtamSlider.prototype._init_pager = function() {
		if (this.options.pager) {
			var pager = $('<ul class="slider-pager"/>'),
				len = this.slides.length,
				self = this;

			var pagerCallback = function() {
				var i = pager.find("> li").index(this);
				if (i !== self.pos()) {
					self.pos(pager.find("> li").index(this));
				}
				return false;
			};
			for (var i = 0; i < len; i++) {
				$('<li/>').appendTo(pager).mousedown(pagerCallback);
			}
			$(this.element).bind("slidePositionChange.vslider", function(e, index) {
				pager.find("li.active").removeClass("active").end()
					.find("li:eq(" + index + ")").addClass("active");
			});
			pager.appendTo($(this.options.pager === "auto" ? this.element : this.options.pager));
		}
	};

	/* Prev/Next Buttons ---------------------------------------------------- */
	VamtamSlider.prototype._init_prevNextButtons = function() {
		var self = this;

		var nextBtn = this.options.nextButton ? $(this.options.nextButton) : $('<div class="slider-btn-next"/>').appendTo(this.element);
		nextBtn.mousedown(function() {
			self.onNextButtonAction();
			return false;
		});

		var prevBtn = this.options.prevButton ? $(this.options.prevButton) : $('<div class="slider-btn-prev"/>').appendTo(this.element);
		prevBtn.mousedown(function() {
			self.onPrevButtonAction();
			return false;
		});
	};

	VamtamSlider.prototype.onNextButtonAction = function() {
		this.pos("next");
	};

	VamtamSlider.prototype.onPrevButtonAction = function() {
		this.pos("prev");
	};


	VamtamSlider.Effects = {};
	VamtamSlider.CaptionEffects = {};

	// =========================================================================
	VamtamSlider.CaptionEffects.fadeCaptions = function(cfg) {

		var oldWrapper = cfg.toHide.data("captionsWrapper"),
			newWrapper = cfg.toShow.data("captionsWrapper"),
			toHide = $(oldWrapper).find(".caption"),
			toShow = $(newWrapper).find(".caption"),
			toHideLength = toHide.length,
			toShowLength = toShow.length,
			duration = cfg.slider.options.captionFxTime || cfg.duration,
			delay = cfg.slider.options.captionFxDelay || 0,
			easing = cfg.slider.options.captionFxEasing,
			queue = !! cfg.slider.options.captionQueue,
			sliderRoot = $(cfg.slider.element),
			subDuration = Math.ceil(duration / 4);



		// Reset the caption queue (if any)
		sliderRoot.queue("captions", []);

		// Hide old captions ---------------------------------------------------
		sliderRoot.queue("captions", function(next) {
			if (toHideLength) {
				if (queue) {
					toHide.each(function(i, c) {
						setTimeout(function() {
							$(c).stop(1, 0).animate({
								opacity: 0,
								avoidCSSTransitions: true
							}, subDuration, easing, function() {
								$(this).css("display", "none");
								if (i >= toHideLength - 1) {
									next();
								}
							});
						}, (delay || subDuration / toHideLength) * i);
					});
				} else {
					var done1 = 0;
					toHide.delay(delay || 0).stop(1, 0).animate({
						opacity: 0,
						avoidCSSTransitions: true
					}, subDuration, easing, function() {
						$(this).css("display", "none");
						if (++done1 >= toHideLength) {
							next();
						}
					});
				}
			} else {
				setTimeout(next, subDuration);
			}
		});

		// Switch caption containers -------------------------------------------
		sliderRoot.queue("captions", function(next) {
			var cb = $.createCountingCallback(2, next);

			// Hide old captions container
			if (oldWrapper) {
				$(oldWrapper)
					.stop(1, 0)
					.animate({
					opacity: 0,
					avoidCSSTransitions: true
				}, newWrapper ? subDuration * 2 : subDuration, "linear", function() {
					$(this).css("display", "none");
					cb();
				});
			} else {
				setTimeout(cb, subDuration);
			}

			// Show new captions container
			if (newWrapper) {
				$(newWrapper)
					.stop(1, 0)
					.css("display", "block")
					.delay(oldWrapper ? 0 : subDuration)
					.animate({
					opacity: 1,
					avoidCSSTransitions: true
				}, oldWrapper ? subDuration * 2 : subDuration, "linear", cb);
			} else {
				setTimeout(cb, subDuration);
			}
		});

		// Show new captions ---------------------------------------------------
		sliderRoot.queue("captions", function(next) {
			if (toShowLength) {
				if (queue) {
					toShow.each(function(i, c) {
						setTimeout(function() {
							$(c).stop(1, 0).css("display", "block").animate({
								opacity: 1,
								avoidCSSTransitions: true
							}, subDuration, easing, function() {
								if (i >= toShowLength - 1) {
									next();
								}
							});
						}, (delay || subDuration / toShowLength) * i);
					});
				} else {
					var done2 = 0;
					toShow.css({
						opacity: 0,
						display: "block"
					}).animate({
						opacity: 1,
						avoidCSSTransitions: true
					}, duration, easing, function() {
						if (++done2 === toShowLength) {
							next();
						}
					});
				}
			} else {
				setTimeout(next, subDuration);
			}
		});

		// Append the callback to the queue
		sliderRoot.queue("captions", cfg.callback || $.noop);

		// Start it!
		sliderRoot.dequeue("captions");
	};

	VamtamSlider.Effects.fade = {
		init: function(slider) {
			var pos = Math.max(slider.pos(), 0);
			$("> .slide-wrapper", slider.element).each(function(i) {
				$(this).css({
					zIndex: i === pos ? 2 : 1,
					opacity: i === pos ? 1 : 0,
					display: i === pos ? "block" : "none"
				});
			});

		},

		run: function(options) {
			options.toHide.stop(1, 1).animate({
				opacity: 0
			},
			options.duration,
			options.easing);

			options.toShow.stop(1, 1).css({
				opacity: 0,
				zIndex: 2,
				display: "block"
			}).animate({
				opacity: 1
			},
			options.duration,
			options.easing,

			function() {
				options.toHide.stop(1, 1).css({
					zIndex: 1,
					display: "none"
				});
				options.callback();
			});
		},

		changeCaptions: VamtamSlider.CaptionEffects.fadeCaptions
	};

	// =========================================================================
	VamtamSlider.Effects.slide = {

		init: function(slider) {
			var pos = Math.max(slider.pos(), 0);
			$("> .slide-wrapper", slider.element).each(function(i) {
				$(this).css({
					zIndex: i === pos ? 2 : 1,
					opacity: i === pos ? 1 : 0,
					display: i === pos ? "block" : "none"
				});
			});
		},

		run: function(cfg) {

			cfg.toShow.stop(1, 0).css({
				opacity: 0.9,
				display: "block"
			});

			var shiftX = cfg.toShow.width() * cfg.direction;
			var cb = $.createCountingCallback(2, cfg.callback);

			cfg.toShow.css({
				left: shiftX,
				zIndex: 2
			}).animate({
				left: 0,
				opacity: 1,
				avoidTransforms: !Modernizr.csstransforms3d
			},
			cfg.duration,
			cfg.easing,
			cb);

			if (cfg.toHide.length && cfg.toHide[0] !== cfg.toShow[0]) {
				cfg.toHide.stop(1, 0).css({
					left: 0,
					opacity: 1,
					zIndex: 1
				}).animate({
					opacity: 0,
					left: -shiftX,
					avoidTransforms: !Modernizr.csstransforms3d
				},
				cfg.duration,
				cfg.easing,

				function() {
					$(this).css({
						display: "none",
						opacity: 1
					});
					cb();
				});
			} else {
				cb();
			}
		},

		changeCaptions: VamtamSlider.CaptionEffects.fadeCaptions
	};

	VamtamSlider.create("vamtamSlider", VamtamSlider, VamtamSlider.defaults);

	$.VamtamSlider = VamtamSlider;

})(jQuery);