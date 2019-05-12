/**
 * Conj Lite scripts & custom methods
 *
 * @since       1.1.0
 * @package     conj-lite
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */
(function( window, $, undefined ) {
    'use strict';

    /* --------------------------------------------------------------------------------- /*
     * If adminbar exist (should check for visible?) then add margin to offcanvas panel
    /* --------------------------------------------------------------------------------- */
    $( window ).on( 'load resize scroll', function() {

        var handheld = $( '.handheld-offcanvas' ),
            width = Math.max( $( window ).width(), window.innerWidth ),
            topScroll = $( window ).scrollTop(),
            wpAdminBar = $( '#wpadminbar' );

        if ( wpAdminBar.length > 0 ) {
            if ( width > 600 ) {
                handheld.css( 'top', wpAdminBar.height() + 'px' );
            } else if ( width <= 600 && topScroll >= 5 ) {
                handheld.css('top', '0');
            } else if ( width <= 600 && topScroll <= 5 ) {
                handheld.css( 'top', wpAdminBar.height() + 'px' );
            } // End If Statement
        } // End If Statement

    } );

    /* -------------------------------------------------------- /*
     * Initializing accesible offcanvas panel and slinky nav
    /* -------------------------------------------------------- */
    $( window ).on( 'load', function() {

    	if ( $( '.handheld-offcanvas' ).length > 0) {

	    	$( document ).trigger( 'enhance' );

	        var handheld = $( '#left.handheld-offcanvas' ),
	        	slinky = $( '#left.handheld-offcanvas #handheld-slinky-menu > div' ),
	        	modifiers = 'left,overlay,push';

	        // If current language direction is right to left
	        if ( true === $( 'body' ).hasClass( 'rtl' ) ) {
	        	modifiers =	'right,overlay,push';
	        } // End If Statement

	        handheld.offcanvas( {
		        modifiers : modifiers,
		        closeButtonClass : 'close-btn',
		        triggerButton : '.js-handheld-offcanvas-toggler',
		        onInit: function() {
		            $( this ).removeClass( 'is-hidden' );
		        }
		    } );

		    setTimeout( function() {
		    	slinky.slinky( {
	            	resize : true,
	            	title : true
	            } );
		    }, 400 );
		}
    } );

    /* ---------------------------------------------- /*
     * Fluid width video embeds.
    /* ---------------------------------------------- */
    var youtube = $( 'iframe[src*="youtube"]' ),
    	vimeo = $( 'iframe[src*="vimeo"]' ),
    	dailymotion = $( 'iframe[src*="dailymotion"]' ),
    	soundcloud = $( 'iframe[src*="soundcloud"]' ),
    	mixcloud = $( 'iframe[src*="mixcloud"]' ),
    	gmaps = $( 'iframe[src*="google.com/maps"]' );

    if ( youtube.length > 0 && ! youtube.parents( '.wp-has-aspect-ratio' ).length > 0 ) {
    	youtube.parent().fitVids();
    } // End If Statement
    if ( vimeo.length > 0 && ! vimeo.parents( '.wp-has-aspect-ratio' ).length > 0 ) {
    	vimeo.parent().fitVids();
    } // End If Statement
    if ( dailymotion.length > 0 && ! dailymotion.parents( '.wp-has-aspect-ratio' ).length > 0 ) {
    	dailymotion.parent().fitVids();
    } // End If Statement
    if ( soundcloud.length > 0 && ! soundcloud.parents( '.wp-has-aspect-ratio' ).length > 0 ) {
    	soundcloud.parent().fitVids();
    } // End If Statement
    if ( mixcloud.length > 0 && ! mixcloud.parents( '.wp-has-aspect-ratio' ).length > 0 ) {
    	mixcloud.parent().fitVids();
    } // End If Statement
    if ( gmaps.length > 0 ) {
    	gmaps.parent().fitVids();
    } // End If Statement

} )( this, jQuery );