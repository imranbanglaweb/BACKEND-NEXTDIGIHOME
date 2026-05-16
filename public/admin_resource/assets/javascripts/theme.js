
window.theme = {};

// Navigation
(function( $ ) {

	'use strict';

	var $items = $( '.nav-main li.nav-parent' );

	function expand( li ) {
		li.children( 'ul.nav-children' ).slideDown( 'fast', function() {
			li.addClass( 'nav-expanded' );
			$(this).css( 'display', '' );
			ensureVisible( li );
		});
	}

	function collapse( li ) {
		li.children('ul.nav-children' ).slideUp( 'fast', function() {
			$(this).css( 'display', '' );
			li.removeClass( 'nav-expanded' );
		});
	}

	function ensureVisible( li ) {
		var scroller = li.offsetParent();
		if ( !scroller.get(0) ) {
			return false;
		}

		var top = li.position().top;
		if ( top < 0 ) {
			scroller.animate({
				scrollTop: scroller.scrollTop() + top
			}, 'fast' );
		}
	}

	$items.find('> a').on('click', function() {
		var prev = $( this ).closest('ul.nav').find('> li.nav-expanded' ),
			next = $( this ).closest('li');

		if ( prev.get( 0 ) !== next.get( 0 ) ) {
			collapse( prev );
			expand( next );
		} else {
			collapse( prev );
		}
	});

}).apply( this, [ jQuery ]);

// Skeleton
(function(theme, $) {

	'use strict';

	theme = theme || {};

	var $body		= $( 'body' ),
		$html		= $( 'html' ),
		$window		= $( window ),
		isAndroid	= navigator.userAgent.toLowerCase().indexOf('android') > -1;

	// mobile devices with fixed has a lot of issues when focus inputs and others...
	if ( typeof $.browser !== 'undefined' && $.browser.mobile && $html.hasClass('fixed') ) {
		$html.removeClass( 'fixed' ).addClass( 'scroll' );
	}

	var Skeleton = {

		options: {
			sidebars: {
				menu: '#content-menu',
				left: '#sidebar-left',
				right: '#sidebar-right'
			}
		},

		initialize: function() {
			this
				.setVars()
				.build()
				.events();
		},

		setVars: function() {
			this.sidebars = {};

			this.sidebars.left = {
				$el: $( this.options.sidebars.left )
			};

			this.sidebars.right = {
				$el: $( this.options.sidebars.right ),
				isOpened: $html.hasClass( 'sidebar-right-opened' )
			};

			this.sidebars.menu = {
				$el: $( this.options.sidebars.menu ),
				isOpened: $html.hasClass( 'inner-menu-opened' )
			};

			return this;
		},

		build: function() {

			if ( typeof $.browser !== 'undefined' && $.browser.mobile ) {
				$html.addClass( 'mobile-device' );
			} else {
				$html.addClass( 'no-mobile-device' );
			}

			$html.addClass( 'custom-scroll' );

			this.buildSidebarRight();

			return this;
		},

		events: function() {
			this.eventsSidebarRight();
			this.eventsContentMenu();

			if ( typeof $.browser !== 'undefined' && isAndroid ) {
				this.fixScroll();
			}

			return this;
		},

		fixScroll: function() {
			var _self = this;

			$window
				.on( 'sidebar-left-opened sidebar-right-toggle', function( e, data ) {
					_self.preventBodyScrollToggle( data.added );
				});
		},

		buildSidebarLeft: function() {
			return this;
		},

		eventsSidebarLeft: function() {
			return this;
		},

		buildSidebarRight: function() {
			this.sidebars.right.isOpened = $html.hasClass( 'sidebar-right-opened' );

			return this;
		},

		eventsSidebarRight: function() {
			var _self = this;

			var open = function() {
				if ( _self.sidebars.right.isOpened ) {
					return close();
				}

				_self.sidebars.right.isOpened = true;

				$html.addClass( 'sidebar-right-opened' );

				$window.trigger( 'sidebar-right-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-right-sidebar', function(e) {
					e.stopPropagation();
					close(e);
				});
			};

			var close = function(e) {
				if ( !!e && !!e.target && ($(e.target).closest( '.sidebar-right' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
					e.preventDefault();
					return false;
				}

				$html.removeClass( 'sidebar-right-opened' );
				$html.off( 'click.close-right-sidebar' );

				$window.trigger( 'sidebar-right-toggle', {
					added: false,
					removed: true
				});

				_self.sidebars.right.isOpened = false;
			};

			var bind = function() {
				$('[data-open="sidebar-right"]').on('click', function(e) {
					var $el = $(this);
					e.stopPropagation();

					if ( $el.is('a') )
						e.preventDefault();

					open();
				});
			};

			this.sidebars.right.$el.find( '.mobile-close' )
				.on( 'click', function( e ) {
					e.preventDefault();
					$html.trigger( 'click.close-right-sidebar' );
				});

			bind();

			return this;
		},

		buildContentMenu: function() {
			return this;
		},

		eventsContentMenu: function() {
			var _self = this;

			var open = function() {
				if ( _self.sidebars.menu.isOpened ) {
					return close();
				}

				_self.sidebars.menu.isOpened = true;

				$html.addClass( 'inner-menu-opened' );

				$window.trigger( 'inner-menu-toggle', {
					added: true,
					removed: false
				});

				$html.on( 'click.close-inner-menu', function(e) {

					close(e);
				});

			};

			var close = function(e) {
				if ( !!e && !!e.target && !$(e.target).closest( '.inner-menu-collapse' ).get(0) && ($(e.target).closest( '.inner-menu' ).get(0) || !$(e.target).closest( 'html' ).get(0)) ) {
					return false;
				}

				e.stopPropagation();

				$html.removeClass( 'inner-menu-opened' );
				$html.off( 'click.close-inner-menu' );

				$window.trigger( 'inner-menu-toggle', {
					added: false,
					removed: true
				});

				_self.sidebars.menu.isOpened = false;
			};

			var bind = function() {
				$('[data-open="inner-menu"]').on('click', function(e) {
					var $el = $(this);
					e.stopPropagation();

					if ( $el.is('a') )
						e.preventDefault();

					open();
				});
			};

			bind();

			return this;
		},

		preventBodyScrollToggle: function( shouldPrevent, $el ) {
			setTimeout(function() {
				if ( shouldPrevent ) {
					$body
						.data( 'scrollTop', $body.get(0).scrollTop )
						.css({
							position: 'fixed',
							top: $body.get(0).scrollTop * -1
						})
				} else {
					$body
						.css({
							position: '',
							top: ''
						})
						.scrollTop( $body.data( 'scrollTop' ) );
				}
			}, 150);
		}

	};

	// expose to scope
	$.extend(theme, {
		Skeleton: Skeleton
	});

}).apply(this, [ window.theme, jQuery ]);

// Base
(function(theme, $) {

	'use strict';

	theme = theme || {};

	theme.Skeleton.initialize();

}).apply(this, [ window.theme, jQuery ]);

/*
Name: 			Theme Admin Extension
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

window.theme = {};

// Mailbox
(function(theme, $) {

	theme = theme || {};

	var instanceName = '__mailbox';

	var capitalizeString = function( str ) {
    	return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	var Mailbox = function($wrapper) {
		return this.initialize($wrapper);
	};

	Mailbox.prototype = {
		initialize: function($wrapper) {
			if ( $wrapper.data( instanceName ) ) {
				return this;
			}

			this.$wrapper = $wrapper;

			this
				.setVars()
				.setData()
				.build()
				.events();

			return this;
		},

		setVars: function() {
			this.view = capitalizeString( this.$wrapper.data( 'mailbox-view' ) || "" );

			return this;
		},

		setData: function() {
			this.$wrapper.data(instanceName, this);

			return this;
		},

		build: function() {

			if ( typeof this[ 'build' + this.view ] === 'function' ) {
				this[ 'build' + this.view ].call( this );
			}


			return this;
		},

		events: function() {
			if ( typeof this[ 'events' + this.view ] === 'function' ) {
				this[ 'events' + this.view ].call( this );
			}

			return this;
		},

		buildFolder: function() {
		},

		buildEmail: function() {
			this.buildComposer();
		},

		buildCompose: function() {
			this.buildComposer();
		},

		buildComposer: function() {
			// build composer
		},

		eventsFolder: function() {
			// events folder
		},

		eventsEmail: function() {
			// events email
		},

		eventsCompose: function() {
			// events compose
		}
	};

	$.extend( true, theme, {
		Mailbox: Mailbox
	});

}).apply(this, [ window.theme, jQuery ]);
