/**
 * Feature Name: MarketPress Gallery Scripts
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/** Menu **/
( function( $ ) {
	var helsinki_gallery = {
			
		// Pseudo-Constructor of this class
		init: function () {

			
			// click
			$( '.gallery-item a' ).magnificPopup( {
				type: 'image',
				gallery: {
					enabled: true
				}
			} );
		}
	};
	
	$( document ).ready( helsinki_gallery.init );
} )( jQuery );
