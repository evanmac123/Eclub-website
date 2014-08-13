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