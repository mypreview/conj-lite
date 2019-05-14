/**
 * WordPress admin enhancements, specific to theme's up-sell admin notice.
 *
 * @requires 	wp-block-editor
 * @package     conj-lite
 * @author     	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

( function( wp, $ ) {
	'use strict';

	if ( ! wp ) {
		return;
	} // End If Statement

	$( function() {
		// Dismiss up-sell banner notice on user click!
		$( document ).on( 'click', '#conj-lite-upsell-notice .notice-dismiss', function() {
			$.ajax( {
				type: 'POST',
				url: ajaxurl,
				data: { 
					nonce: conj_lite_vars.dismiss_upsell_notice_nonce, 
					action: 'conj_lite_dismiss_upsell_notice' 
				},
				dataType: 'json'
			} );
		} );
	} );

} )( window.wp, jQuery );