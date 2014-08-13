/**
 * @see http://stackoverflow.com/a/21015636/635882
 */
(function($) {
	'use strict';

	if(Modernizr.touch) {
		var startTime = null,
			startTouch = null,
			isActive = false,
			scrolled = false;

		/* Constructor */
		window.WPVQuickTap = function(context) {
			var self = this;

			context.on("touchstart", function(evt) {
				startTime = evt.timeStamp;
				startTouch = evt.originalEvent.touches.item(0);
				isActive = true;
				scrolled = false;
			});

			context.on("touchend", function(evt) {
				// Get the distance between the initial touch and the point where the touch stopped.
				var duration = evt.timeStamp - startTime,
					movement = self.getMovement(startTouch, evt.originalEvent['changedTouches'].item(0)),
					isTap = !scrolled && movement < 5 && duration < 200;

				if (isTap) {
					$(evt.target).trigger('wpvQuickTap', evt);

					evt.preventDefault();
				}
			});

			context.on('scroll mousemove touchmove', function(evt) {
				if ((evt.type === "scroll" || evt.type === 'mousemove' || evt.type === 'touchmove') && isActive && !scrolled) {
					scrolled = true;
				}
			});
		};

		/* Calculate the movement during the touch event(s)*/
		WPVQuickTap.prototype.getMovement = function(s, e) {
			if (!s || !e) return 0;
			var dx = e.screenX - s.screenX,
				dy = e.screenY - s.screenY;
			return Math.sqrt((dx * dx) + (dy * dy));
		};
	}

})(jQuery);
/**
 * mlpushmenu.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
( function( window, $, undefined ) {
	'use strict';

	if(!Modernizr.csstransforms3d && !Modernizr.csstransforms) return;

	// taken from https://github.com/inuyaksa/jquery.nicescroll/blob/master/jquery.nicescroll.js
	function hasParent( e, id ) {
		if (!e) return false;
		var el = e.target||e.srcElement||e||false;
		while (el && el.id !== id) {
			el = el.parentNode||false;
		}
		return (el!==false);
	}

	// returns the depth of the element "e" relative to element with id=id
	// for this calculation only parents with classname = waypoint are considered
	function getLevelDepth( e, id, waypoint, cnt ) {
		cnt = cnt || 0;
		if ( e.id.indexOf( id ) >= 0 ) return cnt;
		if( $(e).hasClass(waypoint) ) {
			++cnt;
		}
		return e.parentNode && getLevelDepth( e.parentNode, id, waypoint, cnt );
	}

	function mlPushMenu( el, trigger, options ) {
		/*jshint validthis:true */
		var self = this;
		this.el = el;
		this.trigger = trigger;
		this.options = $.extend( this.defaults, options );
		if( Modernizr.csstransforms3d || Modernizr.csstransforms ) {
			this._init();

			$(window).bind('resize', function() {
				if($(window).width() > 767)
					self._resetMenu(true);
			});
		}
	}

	function translate(X) {
		return Modernizr.csstransforms3d ? 'translate3d(' + X + ',0,0)' : 'translateX('+X+')';
	}

	mlPushMenu.prototype = {
		defaults : {
			// overlap: there will be a gap between open levels
			// cover: the open levels will be on top of any previous open level
			type : 'overlap', // overlap || cover
			// space between each overlaped level
			levelSpacing : 40,
			// classname for the element (if any) that when clicked closes the current level
			backClass : 'mp-back'
		},
		_init : function() {
			// if menu is open or not
			this.open = false;
			// level depth
			this.level = 0;
			// the moving wrapper
			this.wrapper = document.getElementById( 'mp-pusher' );
			// the mp-level elements
			this.levels = Array.prototype.slice.call( this.el.querySelectorAll( 'div.mp-level' ) );
			// save the depth of each of these mp-level elements
			var self = this;
			this.levels.forEach( function( el ) { el.setAttribute( 'data-level', getLevelDepth( el, self.el.id, 'mp-level' ) ); } );
			// the menu items
			this.menuItems = Array.prototype.slice.call( this.el.querySelectorAll( 'li' ) );
			// if type == "cover" these will serve as hooks to move back to the previous level
			this.levelBack = Array.prototype.slice.call( this.el.querySelectorAll( '.' + this.options.backClass ) );
			// event type (if mobile use touch events)
			this.eventtype = Modernizr.touch ? 'wpvQuickTap' : 'click';
			// add the class mp-overlap or mp-cover to the main element depending on options.type
			$(this.el).addClass('mp-' + this.options.type );
			// initialize / bind the necessary events
			this._initEvents();
		},
		_initEvents : function() {
			var self = this;

			// the menu should close if clicking somewhere on the body
			var bodyClickFn = function( el ) {
				self._resetMenu();
				$(el).unbind( self.eventtype, bodyClickFn );
			};

			// open (or close) the menu
			this.trigger.bind( this.eventtype, function( ev ) {
				ev.stopPropagation();
				ev.preventDefault();
				if( self.open ) {
					self._resetMenu();
				}
				else {
					self._openMenu();
					// the menu should close if clicking somewhere on the body (excluding clicks on the menu)
					$(document).bind( self.eventtype, function( ev ) {
						if( self.open && !hasParent( ev.target, self.el.id ) ) {
							bodyClickFn( this );
						}
					} );
				}
			} );

			// opening a sub level menu
			this.menuItems.forEach( function( el ) {
				// check if it has a sub level
				var subLevel = el.querySelector( 'div.mp-level' );
				if( subLevel ) {
					$('a', el).bind( self.eventtype, function( ev ) {
						var level = $(el).closest('.mp-level').data('level');
						if( self.level <= level ) {
							ev.preventDefault();
							ev.stopPropagation();
							$(el).closest('.mp-level').addClass('mp-level-overlay');
							self._openMenu( subLevel );
						}
					} );
				}
			} );

			// closing the sub levels :
			// by clicking on the visible part of the level element
			this.levels.forEach( function( el ) {
				$(el).bind( self.eventtype, function( ev ) {
					ev.stopPropagation();
					var level = el.getAttribute( 'data-level' );
					if( self.level > level ) {
						self.level = level;
						self._closeMenu();
					}
				} );
			} );

			// by clicking on a specific element
			this.levelBack.forEach( function( el ) {
				$(el).bind( self.eventtype, function( ev ) {
					ev.preventDefault();
					var level = $(el).closest('.mp-level').data('level');
					if( self.level <= level ) {
						ev.stopPropagation();
						self.level = $(el).closest('.mp-level').data('level') - 1;
						if(self.level === 0) {
							self._resetMenu();
						} else {
							self._closeMenu();
						}
					}
				} );
			} );
		},
		_openMenu : function( subLevel ) {
			// increment level depth
			++this.level;

			// move the main wrapper
			var levelFactor = ( this.level - 1 ) * this.options.levelSpacing,
				translateVal = this.options.type === 'overlap' ? this.el.offsetWidth + levelFactor : this.el.offsetWidth;

			$(this.wrapper).css('transform', translate(translateVal + 'px'));

			if( subLevel ) {
				// reset transform for sublevel
				$(subLevel).css('transform', '');
				// need to reset the translate value for the level menus that have the same level depth and are not open
				if(this.levels && this.levels.length) {
					for( var i = 0, len = this.levels.length; i < len; ++i ) {
						var levelEl = this.levels[i];
						if( levelEl !== subLevel && !$(levelEl).hasClass('mp-level-open') ) {
							levelEl.style.WebkitTransform = levelEl.style.transform = translate('-100%') + ' ' + translate(-1*levelFactor + 'px');
						}
					}
				}
			}
			// add class mp-pushed to main wrapper if opening the first time
			if( this.level === 1 ) {
				$(this.wrapper).addClass('mp-pushed');
				this.open = true;
			}
			// add class mp-level-open to the opening level element
			$(subLevel || this.levels[0]).addClass('mp-level-open');
		},
		// close the menu
		_resetMenu : function(avoidresize) {
			$(this.wrapper).css('transform', 'none');
			this.level = 0;
			// remove class mp-pushed from main wrapper
			$(this.wrapper).removeClass('mp-pushed');
			this._toggleLevels();
			this.open = false;

			if(!avoidresize) {
				$(window).resize();

				setTimeout(function() {
					$(window).resize();
				}, 500);
			}
		},
		// close sub menus
		_closeMenu : function() {
			var translateVal = this.options.type === 'overlap' ? this.el.offsetWidth + ( this.level - 1 ) * this.options.levelSpacing : this.el.offsetWidth;
			$(this.wrapper).css('transform', translate(translateVal + 'px') );
			this._toggleLevels();
		},
		// removes classes mp-level-open from closing levels
		_toggleLevels : function() {
			var self = this;

			_.each(this.levels, function(level) {
				level = $(level);
				if( level.data('level') >= self.level + 1 ) {
					level.removeClass('mp-level-open mp-level-overlay');
				} else if( Number( level.data('level') ) === self.level ) {
					level.removeClass('mp-level-overlay');
				}
			});
		}
	};

	// add to global namespace
	window.MlPushMenu = mlPushMenu;

} )( window, jQuery );
(function($, undefined) {
	"use strict";

	if(!Modernizr.csstransforms3d && !Modernizr.csstransforms) return;

	var PM = {
		Models: {},
		Collections: {},
		Views: {}
	};

PM.Models.Root = Backbone.Model.extend({
	defaults: {
		title: '',
		description: '',
		type: 'root',
		children: []
	},
	initialize: function() {
		this.children = new PM.Collections.Item();
	}
});

PM.Models.Item = Backbone.Model.extend({
	defaults: {
		url: '',
		title: '',
		attr_title: '',
		description: '',
		classes: [],
		type: 'root',
		children: []
	}
});
PM.Collections.Item =  Backbone.Collection.extend({
	model: PM.Models.Item
});

PM.Collections.Root =  Backbone.Collection.extend({
	model: PM.Models.Root
});
PM.Views.Root = Backbone.View.extend({
	el: $('#container'),
	initialize: function() {
		this.template = $('#wpvpm-menu-root').html();
		_.bindAll(this, 'render');
		this.listenTo( this.model, 'change', this.render );
		this.render();
	},
	render: function() {
		var content = new PM.Views.Item({
			model: new PM.Models.Item(this.model.toJSON())
		}).render();

		var scroller = $('<div></div>').addClass('scroller').attr('id', 'mp-scroller'),
			pusher = $('<div></div>').addClass('mp-pusher').attr('id', 'mp-pusher');

		$(this.el)
		.wrap(pusher)
		.before( _.template(this.template)({
			content: content
		}) );

		$(this.el).wrap(scroller);
	}
});

PM.Views.Item = Backbone.View.extend({
	initialize: function() {
		this.template = $('#wpvpm-menu-item').html();
		_.bindAll(this, 'render');
	},
	render: function() {
		var content = '';

		_(this.model.get('children')).each(function(child) {
			var child_view = new PM.Views.Item({
				model: new PM.Models.Item(child)
			});

			content += child_view.render();
		});

		return _.template(this.template)(
			_.extend(this.model.toJSON(), {
				content: content
			})
		);
	}
});

$(function() {
	if('WpvPushMenu' in window && WpvPushMenu.items) {
		new PM.Views.Root({
			model: new PM.Models.Root(WpvPushMenu.items)
		});

		var trigger = $( '#mp-menu-trigger' );

		if(trigger) {
			new MlPushMenu( document.getElementById( 'mp-menu' ), trigger, {
				type : 'cover'
			} );

			if('WPVQuickTap' in window) {
				new WPVQuickTap( $('#mp-menu .mp-back, #mp-menu .has-children, #mp-menu-trigger') );
			}
		}
	}
});

})(jQuery);