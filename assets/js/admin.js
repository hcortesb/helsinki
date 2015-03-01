/**
 * Feature Name: MarketPress Admin Scripts
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

( function( $ ) {
	var helsinki_admin = {
			
		// Pseudo-Constructor of this class
		init: function () {

			$( window ).scroll( function() {
				var base_margin = 15;
				var scroll_top = $( window ).scrollTop();
				var position = $( '.mp-documentation-nav' ).position();
				var position_top = position.top;
				if ( scroll_top > position_top ) {
					var new_margin = scroll_top - position_top;
					$( '.mp-documentation-nav' ).css( {
						marginTop: new_margin + 'px'
					} );
				} else {
					$( '.mp-documentation-nav' ).css( {
						marginTop: '15px'
					} );
				}
			} );
		}
	};
	
	$( document ).ready( helsinki_admin.init );
} )( jQuery );
