/**
 * WordPress admin enhancements, specific to theme's up-sell admin notice.
 *
 * @package     mypreview-conj
 */

( function( wp, $ ) {
	'use strict';

	if ( ! wp ) {
		return;
	}

	$( function() {
		// Dismiss CONJ PRO up-sell notice on user click!
		$( document ).on( 'click', '#conj-upsell-notice .notice-dismiss', function() {
			$.ajax({
				type:     'POST',
				url:      MyPreviewConjUpsellNotice.ajaxurl,
				data:     { nonce: MyPreviewConjUpsellNotice.notice_nonce, action: 'mypreview_conj_lite_dismiss_upsell_notice' },
				dataType: 'json'
			} );
		} );
	} );

} )( window.wp, jQuery );