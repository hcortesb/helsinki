<?php
/**
 * Feature Name:    MarketPress Setup-File
 * Version:		    0.1
 * Author:		    Inpsyde GmbH for MarketPress.com
 * Author URI:	    http://inpsyde.com/
 */

/**
 * Setup-Function to init our MarketPress-Functions and Hooks
 * @return  Void
 */
function parallactic_marketpress_setup() {

	if ( is_admin() ) {
		// Autoupdater
		add_action( 'wp_loaded', 'parallactic_marketpress_autoupdate' );
	}
}

/**
 * Registering the Autoupdater for our Theme
 *
 * @wp-hook wp_loaded
 *
 * @return  Void
 */
function parallactic_marketpress_autoupdate() {

	if ( ! class_exists( 'MarketPress_Autoupdate' ) ) {
		include_once( 'backend/Autoupdate.php' );
	}

	$theme_data = (object) get_file_data(
		get_template_directory() . '/style.css',
		array (
			'product' => 'Theme Name',
			'version' => 'Version'
		)
	);

	$messages = array (
		'license_deleted' => array (
			'text'  => __( 'The license has been deleted.', 'PARALLACTIC_TEXTDOMAIN' ),
			'class' => 'updated'
		),
		'marketpress_product_activated' => array (
			'text'  => __( 'Product successfully activated.', 'PARALLACTIC_TEXTDOMAIN' ),
			'class' => 'updated'
		),
		'marketpress_wrong_key' => array (
			'text'  => __( 'The entered license key is not valid.', 'PARALLACTIC_TEXTDOMAIN' ),
			'class' => 'error'
		),
		'marketpress_wrong_url' => array (
			'text'  => __( 'You have reached the limit of URLs. Please update your license at <a href="http://marketpress.com">MarketPress.com</a>.', 'PARALLACTIC_TEXTDOMAIN' ),
			'class' => 'error'
		),
		'marketpress_wrong_anything' => array (
			'text'  => __( 'Something went wrong. Please try again later or contact the <a href="http://marketpress.com/support/">MarketPress team</a>.', 'PARALLACTIC_TEXTDOMAIN' ),
			'class' => 'updated'
		),
		'marketpress_wrong_license' => array (
			'text'  => __( 'Due to an invalid license you are not allowed to activate this theme. Please update your license at <a href="http://marketpress.com">MarketPress.com</a>.', 'PARALLACTIC_TEXTDOMAIN' ),
			'class' => 'updated'
		),
		'activate' => array (
			'text' => __( 'Activate', 'PARALLACTIC_TEXTDOMAIN' )
		),
		'license_invalid' => array (
			'text'  => sprintf(
				__( 'Your license for  %s is not valid.', 'PARALLACTIC_TEXTDOMAIN' ),
				$theme_data->product
			)
		),
		'license_valid' => array (
			'text'  => sprintf(
				__( 'Your license for %s is valid.', 'PARALLACTIC_TEXTDOMAIN' ),
				$theme_data->product
			)
		),
		'auto_update_disabled' => array (
			'text'  => __( 'The auto-update has been deactivated.', 'PARALLACTIC_TEXTDOMAIN' ),
		),
		'enter_valid_key' => array (
			'text'  => __( 'Please enter a valid license key.', 'PARALLACTIC_TEXTDOMAIN' ),
		),
		'renew_key' => array (
			'text'  => __( 'You can renew the key in your MarketPress Dashboard.', 'PARALLACTIC_TEXTDOMAIN' ),
		),
		'enter_new_key' => array (
			'text'  => __( 'You can enter a new key in the form below.', 'PARALLACTIC_TEXTDOMAIN' ),
		),
		'delete_key' => array (
			'text'  => __( 'Delete key.', 'PARALLACTIC_TEXTDOMAIN' ),
		),
		'license_key' => array (
			'text'  => __( 'License key:', 'PARALLACTIC_TEXTDOMAIN' ),
		)
	);

	new MarketPress_Autoupdate( $theme_data, $messages );
}