( function( $, elementor ) {

	"use strict";

	var TradTurbo = {

		init: function() {

			var widgets = {
				'trad-navigation-menu.default' : TradTurbo.widgetNavMenu,
			};
			// console.log('Turbo', widgets);
			$.each( widgets, function( widget, callback ) {
				window.elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});
		},

		widgetNavMenu: function( $scope ) {

			var $navMenu = $scope.find( '.trad-nav-menu-container' ),
				$mobileNavMenu = $scope.find( '.trad-mobile-nav-menu-container' );

			// Menu
			var subMenuFirst = $navMenu.find( '.trad-nav-menu > li.menu-item-has-children' ),
				subMenuDeep = $navMenu.find( '.trad-sub-menu li.menu-item-has-children' );

			if ( $scope.find('.trad-mobile-toggle').length ) {
				$scope.find('a').on('click', function() {
					if (this.pathname == window.location.pathname && !($(this).parent('li').children().length > 1)) {
						$scope.find('.trad-mobile-toggle').trigger('click');
					}
				});
			}

			if ( $navMenu.attr('data-trigger') === 'click' ) {
				// First Sub
				subMenuFirst.children('a').on( 'click', function(e) {
					var currentItem = $(this).parent(),
						childrenSub = currentItem.children('.trad-sub-menu');

					// Reset
					subMenuFirst.not(currentItem).removeClass('trad-sub-open');
					if ( $navMenu.hasClass('trad-nav-menu-horizontal') || ( $navMenu.hasClass('trad-nav-menu-vertical') && $scope.hasClass('trad-sub-menu-position-absolute') ) ) {
						subMenuAnimation( subMenuFirst.children('.trad-sub-menu'), false );
					}

					if ( ! currentItem.hasClass( 'trad-sub-open' ) ) {
						e.preventDefault();
						currentItem.addClass('trad-sub-open');
						subMenuAnimation( childrenSub, true );
					} else {
						currentItem.removeClass('trad-sub-open');
						subMenuAnimation( childrenSub, false );
					}
				});

				// Deep Subs
				subMenuDeep.on( 'click', function(e) {
					var currentItem = $(this),
						childrenSub = currentItem.children('.trad-sub-menu');

					// Reset
					if ( $navMenu.hasClass('trad-nav-menu-horizontal') ) {
						subMenuAnimation( subMenuDeep.find('.trad-sub-menu'), false );
					}

					if ( ! currentItem.hasClass( 'trad-sub-open' ) ) {
						e.preventDefault();
						currentItem.addClass('trad-sub-open');
						subMenuAnimation( childrenSub, true );

					} else {
						currentItem.removeClass('trad-sub-open');
						subMenuAnimation( childrenSub, false );
					}
				});

				// Reset Subs on Document click
				$( document ).mouseup(function (e) {
					if ( ! subMenuFirst.is(e.target) && subMenuFirst.has(e.target).length === 0 ) {
						subMenuFirst.not().removeClass('trad-sub-open');
						subMenuAnimation( subMenuFirst.children('.trad-sub-menu'), false );
					}
					if ( ! subMenuDeep.is(e.target) && subMenuDeep.has(e.target).length === 0 ) {
						subMenuDeep.removeClass('trad-sub-open');
						subMenuAnimation( subMenuDeep.children('.trad-sub-menu'), false );
					}
				});
			} else {
				// Mouse Over
				subMenuFirst.on( 'mouseenter', function() {
					if ( $navMenu.hasClass('trad-nav-menu-vertical') && $scope.hasClass('trad-sub-menu-position-absolute') ) {
						$navMenu.find('li').not(this).children('.trad-sub-menu').hide();
						// BUGFIX: when menu is vertical and absolute positioned, lvl2 depth sub menus wont show properly on hover
					}

					subMenuAnimation( $(this).children('.trad-sub-menu'), true );
				});

				// Deep Subs
				subMenuDeep.on( 'mouseenter', function() {
					subMenuAnimation( $(this).children('.trad-sub-menu'), true );
				});


				// Mouse Leave
				if ( $navMenu.hasClass('trad-nav-menu-horizontal') ) {
					subMenuFirst.on( 'mouseleave', function() {
						subMenuAnimation( $(this).children('.trad-sub-menu'), false );
					});

					subMenuDeep.on( 'mouseleave', function() {
						subMenuAnimation( $(this).children('.trad-sub-menu'), false );
					});	
				} else {

					$navMenu.on( 'mouseleave', function() {
						subMenuAnimation( $(this).find('.trad-sub-menu'), false );
					});
				}
			}


			// Mobile Menu
			var mobileMenu = $mobileNavMenu.find( '.trad-mobile-nav-menu' );

			// Toggle Button
			$mobileNavMenu.find( '.trad-mobile-toggle' ).on( 'click', function() {
				$(this).toggleClass('trad-mobile-toggle-fx');

				if ( ! $(this).hasClass('trad-mobile-toggle-open') ) {
					$(this).addClass('trad-mobile-toggle-open');

					if ( $(this).find('.trad-mobile-toggle-text').length ) {
						$(this).children().eq(0).hide();
						$(this).children().eq(1).show();
					}
				} else {
					$(this).removeClass('trad-mobile-toggle-open');
					$(this).trigger('focusout');

					if ( $(this).find('.trad-mobile-toggle-text').length ) {
						$(this).children().eq(1).hide();
						$(this).children().eq(0).show();
					}
				}

				// Show Menu
				$(this).parent().next().stop().slideToggle();

				// Fix Width
				fullWidthMobileDropdown();
			});

			// Sub Menu Class
			mobileMenu.find('.sub-menu').removeClass('trad-sub-menu').addClass('trad-mobile-sub-menu');

			// Sub Menu Dropdown
			mobileMenu.find('.menu-item-has-children').children('a').on( 'click', function(e) {
				var parentItem = $(this).closest('li');

				// Toggle
				if ( ! parentItem.hasClass('trad-mobile-sub-open') ) {
					e.preventDefault();
					parentItem.addClass('trad-mobile-sub-open');
					parentItem.children('.trad-mobile-sub-menu').first().stop().slideDown();
				} else {
					parentItem.removeClass('trad-mobile-sub-open');
					parentItem.children('.trad-mobile-sub-menu').first().stop().slideUp();
				}
			});

			// Run Functions
			fullWidthMobileDropdown();

			// Run Functions on Resize
			$(window).smartresize(function() {
				fullWidthMobileDropdown();
			});

			// Full Width Dropdown
			function fullWidthMobileDropdown() {
				if ( ! $scope.hasClass( 'trad-mobile-menu-full-width' ) || (! $scope.closest('.elementor-column').length && ! $scope.closest('.e-con').length) ) {
					return;
				}

                // GOGA: maybe in some cases elementor-element instead of e-con
                var topSection = $scope.closest('.elementor-top-section');

				var eColumn   = $scope.closest('.elementor-column').length ? $scope.closest('.elementor-column') : $scope.closest('.elementor-element'),
					mWidth 	  = topSection.length ? (topSection.outerWidth() - 2 * mobileMenu.offset().left) : ($(window).outerWidth() - 2 * mobileMenu.offset().left),
					mPosition = eColumn.offset().left + parseInt(eColumn.css('padding-left'), 10);

                // GOGA: don't need to calculate mWidth since it has tu be full
				mobileMenu.css({
					'width' : mWidth +'px',
					'left' : - mPosition +'px'
				});
			}

			// Sub Menu Animation
			function subMenuAnimation( selector, show ) {
				if ( show === true ) {
					if ( $scope.hasClass('trad-sub-menu-fx-slide') ) {
						selector.stop().slideDown();
					} else {
						selector.stop().fadeIn();
					}
				} else {
					if ( $scope.hasClass('trad-sub-menu-fx-slide') ) {
						selector.stop().slideUp();
					} else {
						selector.stop().fadeOut();
					}
				}
			}

		}, // End widgetNavMenu
	
	} // End TradTurbo







	$( window ).on( 'elementor/frontend/init', TradTurbo.init );



}( jQuery, window.elementorFrontend ) );

// Resize Function - Debounce
(function($,sr){

  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  }
  // smartresize 
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');