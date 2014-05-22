/**
 * Feature Name:    Frontend Scripts
 * Version:         0.9
 * Author:          Inpsyde GmbH for MarketPress.com
 * Author URI:      http://marketpress.com
 */

/** Menu **/
( function( $ ) {
	var parallactic = {
			
		// Pseudo-Constructor of this class
		init: function () {
			
			// Mobile Navigation
			$( '.toggle-mobile-menu' ).click( function() {
				$( '.primary-navigation.mobile > ul' ).slideToggle( 'fast' );
				event.preventDefault();
			} );
			
			// Menu Fixing
			if ( $( 'body > header' ).length ) {
				var current_offset_to_top = $( '#headline' ).offset();
				current_offset_to_top = current_offset_to_top.top;
				
				$( window ).scroll( function() {
					var fixing_to_top = current_offset_to_top - $( window ).scrollTop();
					
					if ( fixing_to_top > $( 'body > header' ).height() )
						$( '#headline' ).css( 'top', $( 'body > header' ).height() + 'px' );
					else if ( fixing_to_top >= 0 )
						$( '#headline' ).css( 'top', fixing_to_top + 'px' );
					else
						$( '#headline' ).css( { 'top': '0px' } );
				} );
			}
		}
	};
	
	$( document ).ready( parallactic.init );
} )( jQuery );