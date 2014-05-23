<?php
/**
 * Feature Name:	Market Press Auto Updater
 * Version:			0.1
 * Author:			Inpsyde GmbH
 * Author URI:		http://inpsyde.com
 * Licence:			GPLv3
 */

require_once( ABSPATH . 'wp-includes/pluggable.php' );

/**
 * Controller for update checks to marketpress.com
 */
class MarketPress_Autoupdate {

	/**
	 * The parent product name
	 *
	 * @since 0.1
	 * @type array
	 */
	protected $product = '';

	/**
	 * Setting up some data, all vars and start the hooks
	 *
	 * @param stdClass  $theme_data Object with two properties: 'product' (name) and 'version'.
	 * @param array    $messages   all needed strings
	 *
	 * @return \MarketPress_Autoupdate
	 */
	public function __construct( $theme_data, Array $messages ) {

		// Setting up Plugin identifier and textdomain
		$this->product = sanitize_title_with_dashes( $theme_data->product );

		$data = new MarketPress_Autoupdate_Data( $this->product, $theme_data->version );
		$view = new MarketPress_Autoupdate_View( $data, $messages );

		// Add Admin Notice for the MarketPress Dashboard
		add_filter( 'admin_notices', array( $view, 'show_license_notice' ) );

		// Add Set License Filter
		add_filter( 'admin_post_update_license_key_' . $this->product, array( $data, 'update_license' ) );

		// Remove Key Filter
		add_filter( 'admin_post_remove_license_key_' . $this->product, array( $data, 'remove_license_key' ) );

		// add scheduled event for the key checkup
		add_filter( $this->product . '_license_key_checkup', array( $data, 'license_key_checkup' ) );

		if ( ! wp_next_scheduled( $this->product . '_license_key_checkup' ) )
			wp_schedule_event( time(), 'daily', $this->product . '_license_key_checkup' );

		// Add Filter for the license check ( the cached state of the checkup )
		add_filter( $this->product . '_license_check', array( $data, 'license_check' ) );

		// Version Checkup
		if ( $data->is_marketpress ) {
			$user_data = get_site_option( 'marketpress_user_data', array() );
			if ( isset( $user_data[ $this->product ] ) && $user_data[ $this->product ] == 'false' ) {
				add_filter( 'pre_set_site_transient_update_themes', array( $data, 'check_product_version' ) );
			}
		} else {
			$license_check = apply_filters( $this->product . '_license_check', FALSE );
			if ( $license_check ){
				add_filter( 'pre_set_site_transient_update_themes', array( $data, 'check_product_version' ) );
			}
		}

		add_filter( 'validate_current_theme', array ( $view, 'show_license_box' ) );
	}
}

/**
 * Change license key and do update look-ups.
 */
class MarketPress_Autoupdate_Data {

	public $product;
	protected $licenses;
	protected $current_version;

	/**
	 * Check if the plugin comes from marketpress
	 * dashboard
	 *
	 * @since 0.1
	 * @type boolean
	 */
	public $is_marketpress = FALSE;

	/**
	 * The license key
	 *
	 * @since 0.1
	 * @type array
	 */
	public $key = '';

	/**
	 * The URL for the update check
	 *
	 * @since 0.1
	 * @type string
	 */
	private $url_update_check = '';

	/**
	 * The URL for the update package
	 *
	 * @since 0.1
	 * @type  string
	 */
	private $url_update_package = '';

	/**
	 * The URL for the key check
	 *
	 * @since 0.1
	 * @type  string
	 */
	private $url_key_check = '';

	/**
	 * Constructor.
	 *
	 * @param string $product Name
	 * @param string $current_version
	 */
	public function __construct( $product, $current_version ) {

		$this->product         = $product;
		$this->current_version = $current_version;

		$this->set_key();
		$this->set_urls();
	}

	/**
	 * Create the check URLs.
	 *
	 * @return void
	 */
	protected function set_urls() {

		$site     = sanitize_title_with_dashes( network_site_url() );
		$appendix = "$this->key/$this->product/$site";
		$this->url_key_check      = "http://marketpress.com/mp-key/$appendix";
		$this->url_update_check   = "http://marketpress.com/mp-version/$appendix";
		$this->url_update_package = "http://marketpress.com/mp-download/$appendix";
	}

	/**
	 * Checks over the transient-update-check for products if new version of
	 * this product os available and is it, shows a update-message into
	 * the backend and register the update package in the transient object
	 *
	 * @since  0.1
	 * @param  object $transient
	 * @return object $transient
	 */
	public function check_product_version( $transient ) {

		if ( empty( $transient->checked ) )
			return $transient;

		$response = $this->license_key_checkup();

		if ( $response != 'true' ) {
			return $this->remove_product_from_transient( $transient );
		}

		// Connect to our remote host
		$remote = wp_remote_get( $this->url_update_check );

		// If the remote is not reachable or any other errors occurred,
		// we have to break up
		if ( is_wp_error( $remote ) ) {
			return $this->remove_product_from_transient( $transient );
		}

		$response = json_decode( wp_remote_retrieve_body( $remote ) );

		if ( $response->status != 'true' ) {
			return $this->remove_product_from_transient( $transient );
		}

		// Yup, insert the version
		if ( version_compare( $response->version, $this->current_version ) ) {
			$hashlist   = get_site_transient( 'update_hashlist' );
			$hash       = crc32( filemtime( __FILE__ ) . $response->version );
			$hashlist[] = $hash;
			set_site_transient( 'update_hashlist' , $hashlist );

			$transient->response[ $this->product ] = array(
				'url'         => "http://marketpress.com/product/$this->product/",
				'package'     => $this->url_update_package,
				'new_version' => $response->version
			);

			return $transient;
		}

		return $this->remove_product_from_transient( $transient );
	}

	/**
	 * Turn upper case letters in a product name to lower case.
	 *
	 * @param  string $product
	 * @return string
	 */
	protected function uc_first_product( $product ) {

		if ( FALSE === strpos( $product, '-' ) ) {
			return ucfirst( $product );
		}

		$parts = explode( '-', $product );
		$parts = array_map( 'ucfirst', $parts );

		return join( '-', $product );
	}

	/**
	 * Turn lower case letters in a product name to upper case.
	 *
	 * @param  string $product
	 * @return string
	 */
	protected function lc_product( $product ) {

		if ( function_exists( 'mb_strtolower' ) ){
			return mb_strtolower( $product );
		}

		return strtolower( $product );
	}

	/**
	 * Removes our product from update transient.
	 *
	 * @param  object $transient
	 * @return object
	 */
	protected function remove_product_from_transient( $transient ) {

		static $uc_product = FALSE;
		static $lc_product = FALSE;

		if ( ! $uc_product ) {
			$uc_product = $this->uc_first_product( $this->product );
		}

		if ( ! $lc_product ) {
			$lc_product = $this->lc_product( $this->product );
		}

		unset( $transient->response[ $lc_product ] );
		unset( $transient->response[ $uc_product ] );

		return $transient;
	}

	/**
	 * Checks the cached state of the license checkup
	 *
	 * @since  0.1
	 * @return boolean
	 */
	public function license_check() {
		return get_site_option( 'MarketPress_license_status_' . $this->product );
	}

	/**
	 * Setting up the key
	 *
	 * @since 0.1
	 * @return void
	 */
	public function set_key() {

		// Check if theres a key in the config
		if ( defined( 'MARKETPRESS_KEY' ) && MARKETPRESS_KEY != '' )
			$this->key = MARKETPRESS_KEY;

		// MarketPress Key
		if ( $this->key == '' && get_site_option( 'marketpress_license' ) != '' )
			$this->key = get_site_option( 'marketpress_license' );

		// Check if the plugin is valid
		$user_data = get_site_option( 'marketpress_user_data' );

		if ( isset( $user_data[ $this->product ] ) ) {
			if ( $user_data[ $this->product ]->valid == 'false' ) {
				$this->key = '';
			}
			else if ( $user_data[ $this->product ]->valid == 'true' ) {
				$this->key            = '';
				$this->is_marketpress = TRUE;
			}
		}

		// Get all our licenses
		$this->licenses = get_site_option( 'MarketPress_licenses' );

		if ( isset( $this->licenses[ $this->product . '_license' ] ) ) {
			$this->key            = $this->licenses[ $this->product . '_license' ];
			$this->is_marketpress = FALSE;
		}
	}

	/**
	 * Updates and inserts the license
	 *
	 * @wp-hook 'admin_post_update_license_key_' . $this->product
	 * @since  0.1
	 * @return boolean
	 */
	public function update_license() {

		$return_url = admin_url( "themes.php?message=" );

		if ( empty ( $_POST[ "license_key_$this->product" ] ) ) {
			wp_safe_redirect( $return_url . 'marketpress_wrong_key' );
			exit;
		}

		$response = $this->license_key_checkup( $_POST[ "license_key_$this->product" ] );

		if ( $response == 'true' ) {
			$msg = 'marketpress_product_activated';
		} else if ( $response == 'wrongkey' ) {
			$msg = 'marketpress_wrong_key';
		} else if ( $response == 'wronglicense' ) {
			$msg = 'marketpress_wrong_license';
		} else if ( $response == 'wrongurl' ) {
			$msg = 'marketpress_wrong_url';
		} else {
			$msg = 'marketpress_wrong_anything';
		}

		wp_safe_redirect( $return_url . $msg );
		exit;
	}

	/**
	 * Removes the plugins key from the licenses
	 *
	 * @since  0.1
	 * @return void
	 */
	public function remove_license_key() {

		unset( $this->licenses[ $this->product . '_license' ] );

		update_site_option( 'MarketPress_licenses' , $this->licenses );

		$this->key = '';

		// Renew License Check
		$this->license_key_checkup();

		// Redirect
		wp_safe_redirect( admin_url( 'themes.php?message=license_deleted' ) );
		exit;
	}

	/**
	 * Check the license-key and caches the returned value
	 * in an option
	 *
	 * @since  0.1
	 * @param  string $key
	 * @return boolean
	 */
	public function license_key_checkup( $key = '' ) {

		// Request Key
		if ( $key != '' ) {
			$this->key = $key;
		}

		// Check if there's a key
		if ( $this->key == '' ) {
			// Deactivate Plugin first
			update_site_option( 'MarketPress_license_status_' . $this->product, 'false' );
			return 'wrongkey';
		}

		// Update URL Key Checker
		$this->url_key_check = "http://marketpress.com/mp-key/$this->key/$this->product/"
			. sanitize_title_with_dashes( network_site_url() );

		// Connect to our remote host
		$remote = wp_remote_get( $this->url_key_check );

		// If the remote is not reachable or any other errors occured,
		// we believe in the goodwill of the user and return true
		if ( is_wp_error( $remote ) ) {
			$this->licenses[ $this->product . '_license' ] = $this->key;
			update_site_option( 'MarketPress_licenses' , $this->licenses );
			update_site_option( 'MarketPress_license_status_' . $this->product, 'true' );
			return 'true';
		}

		// Okay, get the response
		$response = json_decode( wp_remote_retrieve_body( $remote ) );

		if ( ! isset( $response ) || $response == '' ) {
			// Deactivate Plugin first
			delete_site_option( 'MarketPress_license_status_' . $this->product );

			if ( isset( $this->licenses[ $this->product . '_license' ] ) ) {
				unset( $this->licenses[ $this->product . '_license' ] );
				update_site_option( 'MarketPress_licenses' , $this->licenses );
			}

			return 'wronglicense';
		}

		// Okay, get the response
		$response = json_decode( wp_remote_retrieve_body( $remote ) );

		if ( $response->status == 'noproducts' ) {
			// Deactivate Plugin first
			delete_site_option( 'MarketPress_license_status_' . $this->product );

			if ( isset( $this->licenses[ $this->product . '_license' ] ) ) {
				unset( $this->licenses[ $this->product . '_license' ] );
				update_site_option( 'MarketPress_licenses' , $this->licenses );
			}

			return 'wronglicense';
		}

		if ( $response->status == 'wronglicense' ) {
			// Deactivate Plugin first
			delete_site_option( 'MarketPress_license_status_' . $this->product );

			if ( isset( $this->licenses[ $this->product . '_license' ] ) ) {
				unset( $this->licenses[ $this->product . '_license' ] );
				update_site_option( 'MarketPress_licenses' , $this->licenses );
			}

			return 'wronglicense';
		}

		if ( $response->status == 'urllimit' ) {
			// Deactivate Plugin first
			delete_site_option( 'MarketPress_license_status_' . $this->product );

			if ( isset( $this->licenses[ $this->product . '_license' ] ) ) {
				unset( $this->licenses[ $this->product . '_license' ] );
				update_site_option( 'MarketPress_licenses' , $this->licenses );
			}

			return 'wrongurl';
		}

		if ( $response->status == 'true' ) {

			// Activate Plugin first
			$this->licenses[ $this->product . '_license' ] = $this->key;
			update_site_option( 'MarketPress_licenses' , $this->licenses );
			update_site_option( 'MarketPress_license_status_' . $this->product, 'true' );

			return 'true';
		}
		return 'marketpress_wrong_anything';
	}
}

/**
 * Create license form and admin notice.
 */
class MarketPress_Autoupdate_View {

	protected $data, $messages;

	/**
	 * Constructor
	 *
	 * @param MarketPress_Autoupdate_Data $data
	 * @param array $messages
	 */
	public function __construct( MarketPress_Autoupdate_Data $data, Array $messages ) {

		$this->data     = $data;
		$this->messages = $messages;
	}

	/**
	 * Admin notice for missing or correct license.
	 *
	 * @param string $key
	 * @return void
	 */
	public function show_license_notice( $key ) {

		if ( ! isset ( $this->messages[ $key ] ) ) {
			return;
		}

		printf(
			'<div class="%1$s"><p>%2$s</p></div>',
			esc_attr( $this->messages[ $key ][ 'class' ] ),
			$this->messages[ $key ][ 'text' ]
		);
	}

	/**
	 * Create the form in wp-admin/themes.php.
	 *
	 * This is a hack: there are no proper hooks in this place, so we use the
	 * filter 'validate_current_theme' to create the output.
	 *
	 * @wp-hook validate_current_theme
	 * @param   bool $var The current theme, passed through
	 * @return  bool
	 */
	public function show_license_box( $var = NULL ) {

		// Security Check
		// FIXME doesn't work on network pages now
		if ( function_exists( 'is_network_admin' ) && is_network_admin() && ! current_user_can( 'manage_network_themes' ) ) {
			return $var;
		}

		if ( ! current_user_can( 'switch_themes' ) ) {
			return $var;
		}

		$product = $this->data->product;
		$class   = 'updated';

		if ( $this->data->is_marketpress && current_user_can( 'manage_options' ) ) {

			$user_data = get_site_option( 'marketpress_user_data' );

			if ( isset( $user_data[ $product ] ) && $user_data[ $product ] == 'false' ) {
				$class = 'error';

				$msg = $this->messages[ 'license_invalid' ][ 'text' ];
				$msg .= ' ';
				$msg .= $this->messages[ 'auto_update_disabled' ][ 'text' ];
				$msg .= ' ';
				$msg .= $this->messages[ 'enter_valid_key' ][ 'text' ];
			}
			else {
				$msg = $this->messages[ 'license_valid' ][ 'text' ];
				$msg .= ' ';
				$msg .= $this->messages[ 'renew_key' ][ 'text' ];
				$msg .= ' ';
				$msg .= $this->messages[ 'enter_new_key' ][ 'text' ];
			}
		} else {

			$license_check = apply_filters( $product . '_license_check', FALSE );

			if ( $license_check == 'false' || $license_check == FALSE ) {
				$class = 'error';

				$msg = $this->messages[ 'license_invalid' ][ 'text' ];
				$msg .= ' ';
				$msg .= $this->messages[ 'auto_update_disabled' ][ 'text' ];
			}
			else {
				$url = admin_url( 'admin-post.php?action=remove_license_key_' . $product );

				$msg = $this->messages[ 'license_valid' ][ 'text' ];
				$msg .= ' ';
				$msg .= $this->messages[ 'renew_key' ][ 'text' ];
				$msg .= ' ';
				$msg .= sprintf(
					'<a href="%1$s">%2$s<a>',
					$url,
					$this->messages[ 'delete_key' ][ 'text' ]
				);
			}
		}

		//FIXME nonce, and just one source for the name attribute
		$input_id = esc_attr( "license_key_$product" );
		$key      = $this->data->is_marketpress ? '' : esc_attr( $this->data->key );
		$action   = esc_url( admin_url( 'admin-post.php' ) );

		$hidden_action = esc_attr( "update_license_key_$product" );
		$submit_text = esc_attr( $this->messages[ 'activate' ][ 'text' ] );

		?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<p><?php echo $msg; ?></p>
			<form method="post" action="<?php echo $action; ?>">
				<p>
					<label for="<?php echo $input_id; ?>"><?php echo $this->messages[ 'license_key' ][ 'text' ]; ?></label>
					<input type="text" name="<?php echo $input_id; ?>" id="<?php echo $input_id; ?>" value="<?php echo $key; ?>" class="regular-text code" />
					<input type="hidden" name="action" value='<?php echo $hidden_action; ?>' />
					<input type="submit" value="<?php echo $submit_text; ?>" class="button-primary action" />
				</p>
			</form>
		</div>
		<?php
		// the validation result, not our business
		return $var;
	}
}