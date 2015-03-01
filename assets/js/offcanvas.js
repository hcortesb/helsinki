/**
 * Feature Name: MarketPress Off-Canvas Scripts
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/** Menu **/
( function( $ ) {
	var helsinki_offcanvas = {
			
		// Pseudo-Constructor of this class
		init: function () {

			// insert element for the content
			$( 'body' ).wrapInner( '<section id="mp-content"></section>' );

			// Load the off canvas code and insert it into the page
			$.get( helsinki_offcanvas_args.ajaxurl, { action: 'helsinki_get_offcanvas_code' }, function( response ) {
				$( 'body' ).prepend( response );
			} );

			// register the trigger
			$( document ).on( 'click', '#offcanvas .menu .trigger', function trigger_off_canvas() {
				$( '#offcanvas .area' ).toggleClass( 'open' );
				$( 'body #mp-content' ).toggleClass( 'open' );
				return false;
			} );
		}
	};
	$( document ).ready( helsinki_offcanvas.init );
} )( jQuery );
