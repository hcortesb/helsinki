<?php
/**
 * Feature Name: General template stuff for Helsinki-Theme
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
 */

/**
 * Gets the logo
 *
 * @return  string
 */
function helsinki_get_logo() {

	// register the pre filter to bypass this function
	$pre = apply_filters( 'pre_helsinki_get_logo', FALSE );
	if ( $pre !== FALSE )
		return $pre;

	// set the default logo
	$default = '<h1 class="logo"><a href="' . get_bloginfo( 'url' ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';

	// return string, by adding the default markup to the filter
	return apply_filters( 'helsinki_get_logo', $default );
}

/**
 * Loads the URL of the logo
 * 
 * @return	mixed	the url of the logo
 */
function helsinki_get_logo_url() {

	return esc_url( get_theme_mod( 'helsinki_logo' ) );
}

/**
 * Adds the current blogname to the title
 *
 * @wp-hook	wp_title
 *
 * @param	string $title
 * @param	string $sep
 * @param	string $seplocation
 * @return	string
 */
function helsinki_filter_wp_title( $title, $sep, $seplocation ) {

	// return just the blogname if there is
	// no title to display
	if ( empty( $title ) )
		return get_bloginfo( 'name' );

	// check the seperator location to build
	// the new title
	if ( $seplocation == 'right' )
		return $title . get_bloginfo( 'name' );
	else
		return get_bloginfo( 'name' ) . $title;
}

/**
 * Adds a standard bodyclass to the css-class
 * declaration in the tag <body>
 *
 * @wp-hook	body_class
 *
 * @param	array $classes
 * @param	string $class
 * @return	array
 */
function helsinki_filter_body_class( $classes, $class ) {

	// load the theme data
	$theme_data = wp_get_theme( get_template() );

	// determinate which body class we need
	$body_class_prefix = sanitize_title_with_dashes( $theme_data->get( 'Name' ) );

	if ( ! in_array( $body_class_prefix . '-body', $classes ) )
		$classes[] = $body_class_prefix . '-body';

	if ( ! is_front_page() )
		$classes[] = $body_class_prefix . '-page';

	return $classes;
}

/**
 * Displays the favicon
 *
 * @wp-hook	wp_head
 *
 * @return	void
 */
function helsinki_the_favicon() {
	echo helsinki_get_favicon();
}

/**
 * gets the favicon markup
 *
 * @return	string
 */
function helsinki_get_favicon() {

	// the favicon name
	$favicon_name = 'favicon.ico';

	// setting the possible directories
	$asset_dir          = '/assets/img/';
	$child_theme_dir    = get_stylesheet_directory() . $asset_dir;
	$parent_theme_dir   = get_template_directory() . $asset_dir;

	// getting the favicon_uri
	$favicon_uri = '';
	if ( file_exists( $child_theme_dir . $favicon_name ) ){
		$favicon_uri = get_stylesheet_directory_uri();
	} else if ( file_exists( ( $parent_theme_dir . $asset_dir ) ) ) {
		$favicon_uri = get_template_directory_uri();
	}

	$markup = '';
	if ( $favicon_uri !== '' )
		$markup = '<link rel="shortcut icon" href="' . $favicon_uri . $asset_dir . $favicon_name . '">';

	return apply_filters( 'helsinki_get_favicon', $markup, $favicon_uri, $asset_dir, $favicon_name );
}


/**
 * Theme info.
 *
 * @return	string
 */
function helsinki_get_footer_theme_info() {

	$theme_data = wp_get_theme( get_template() );

	$author_uri = $theme_data->get( 'AuthorURI' );
	$author     = $theme_data->get( 'Author' );

	$link =  sprintf(
		_x( 'A %1$s Theme', 'Theme author link', 'helsinki' ),
		'<a href="' . $author_uri . '" rel="designer">' . $author . '</a>'
	);

	$markup = sprintf(
		'<p class="mp-site-info">&#169; %1$s %2$s',
		date( 'Y' ),
		$link
	);

	return apply_filters( 'helsinki_get_footer_theme_info', $markup, $author_uri, $author );
}

/**
 * Building the Share Links for our Posts
 *
 * @param	array $args
 *
 * @return	string
 */
function helsinki_get_social_share_links( Array $args = array() ){

	$default_args = array(
		'before'      => '<aside class="social-share">',
		'after'       => '</aside>',
		'before_link' => '',
		'after_link'  => '',
		'link'        => '<a href="%1$s" title="%2$s"><i class="fa %3$s"></i></a>',
		'networks'    => array(
			array(
				'name'	=> 'google+',
				'link'	=> '//plusone.google.com/_/+1/confirm?hl=de&url=%s',
				'class'	=> 'fa-google-plus'
			),
			array(
				'name'	=> 'facebook',
				'link'	=> '//www.facebook.com/sharer.php?u=%s',
				'class'	=> 'fa-facebook'
			),
			array(
				'name'	=> 'twitter',
				'link'	=> '//twitter.com/share?url=%s',
				'class'	=> 'fa-twitter'
			),
		)
	);

	$rtn = apply_filters( 'pre_helsinki_get_social_share_links', FALSE, $args, $default_args );
	if ( $rtn !== FALSE )
		return $rtn;

	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'helsinki_get_social_share_links_args', $args );

	$the_permalink = get_permalink();

	$markup = $args[ 'before' ];
	foreach ( $args[ 'networks' ] as $network ) {

		$link   = sprintf( $network[ 'link' ], $the_permalink );
		$title  = sprintf(
			_x( 'Share on %s', 'The Share-Link in helsinki_get_social_share_links', 'helsinki' ),
			ucfirst( $network[ 'name' ] )
		);
		$class = $network[ 'class' ];

		$markup .= $args[ 'before_link' ];
		$markup .= sprintf(
			$args[ 'link' ],
			$link,
			$title,
			$class
		);
		$markup .= $args[ 'after_link' ];
	}

	$markup .= $args[ 'after' ];

	return apply_filters( 'helsinki_get_social_share_links', $markup, $args );
}


/**
 * Building the Breadcrumbs
 *
 * @param	array $args
 *
 * @return	string
 */
function helsinki_get_breadcrumbs( Array $args = array() ){
	global $paged, $wp_query;

	$default_args = array(
		'before'         => '<nav id="site-breadcrumbs" class="clearfix" xmlns:v="http://rdf.data-vocabulary.org/#">',
		'after'          => '</nav>',
		'standard'       => '<span typeof="v:Breadcrumb">%s</span>',
		'current'        => '<span typeof="v:Breadcrumb" class="current-breadcrumb">%s</span>',
		'link'           => '<a href="%s" rel="v:url"><span property="v:title">%s</span></a>&nbsp;/&nbsp;',
		'show_home_link' => true,
		'home_text'      => _x( 'Home', 'Breadcrumb Home Text', 'helsinki' )
	);

	// pre-filter
	$rtn = apply_filters( 'pre_helsinki_get_breadcrumbs', FALSE, $args, $default_args );
	if ( $rtn !== FALSE )
		return $rtn;

	// merging the args and arg-filter
	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'helsinki_get_breadcrumbs_args', $args );

	// init the breadcrumb-array
	$breadcrumbs = array();

	// filling up the breadcrumbs
	if ( ! is_home() && ! is_front_page() || is_paged() ) {

		$home_link = home_url( '/' );

		if ( is_category() ) {
			$cat_obj = $wp_query->get_queried_object();
			$cat_id  = $cat_obj->term_id;
			$cat     = get_category( $cat_id );

			if ( $cat->parent != 0 ) {
				// fetching the parents

				$parent_id = $cat->parent;
				while ( $parent_id !== 0 ){

					$parent_cat = get_category( $parent_id );

					if ( is_wp_error( $parent_cat ) )
						break;

					// insert on first position
					array_unshift(
						$breadcrumbs,
						array(
							'title' => $parent_cat->cat_name,
							'link'  => get_category_link( $parent_cat->term_id )
						)
					);
					$parent_id = $parent_cat->parent;
				}
			}
			$breadcrumbs[] = array(
				'title' => $cat->cat_name,
			    'link'  => get_category_link( $cat->term_id )
			);
		} else if ( is_day() ) {
			$year  = get_the_time( 'Y' );
			$month = get_the_time( 'm' );
			$day   = get_the_time( 'd' );

			$breadcrumbs[] = array(
				'link'  => get_year_link( $year ),
				'title' => get_the_time( 'Y' )
			);
			$breadcrumbs[] = array(
				'link'  => get_month_link( $year, $month ),
				'title' => get_the_time( 'F' )
			);

			$breadcrumbs[] = array(
				'title' => $day,
			    'link'  => get_day_link( $day, $month, $year )
			);
		} else if ( is_month() ) {
			$year  = get_the_time( 'Y' );
			$month = get_the_time( 'm' );

			$breadcrumbs[] = array(
				'link'  => get_year_link( $year ),
				'title' => $year
			);

			$breadcrumbs[] = array(
				'title' => get_the_time( 'F' ), // month-name
				'link'  => get_month_link( $year, $month ),
			);
		} else if ( is_year() ) {
			$year = get_the_time( 'Y' );
			$breadcrumbs[] = array(
				'title' => $year,
				'link'  => get_year_link( $year )
			);
		} else if ( is_attachment() ) {
			$breadcrumbs[] = array(
				'title'     => get_the_title(),
			    'link'      => get_permalink()
			);
		} else if ( is_singular()  ) {

			if ( get_post_type() === 'product' && function_exists( 'wc_get_product_terms' ) ) {

				// checking for woo single
				$terms = wc_get_product_terms(
					get_the_ID(),
					'product_cat',
					array(
						'orderby' => 'parent',
						'order'   => 'DESC'
					)
				);

				if ( count( $terms ) > 0 ) {
					$main_term = $terms[0];
					$ancestors = get_ancestors( $main_term->term_id, 'product_cat' );

					$breadcrumbs[] = array(
						'title' => $main_term->name,
						'link'  => get_term_link( $main_term->slug, 'product_cat' )
					);

					foreach ( $ancestors as $ancestor ) {
						$ancestor = get_term( $ancestor, 'product_cat' );

						if ( ! is_wp_error( $ancestor ) && $ancestor )
							$breadcrumbs[] = array(
								'title' => $ancestor->name,
								'link'  => get_term_link( $ancestor->slug, 'product_cat' )
							);
					}
				}
			} else {
				// seems to be a post, page or custom-post-type

				$filter = array(
					'hierarchical'      => TRUE,
					'show_in_nav_menus' => TRUE
				);
				$taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
				$taxonomies = wp_list_filter( $taxonomies, $filter );
				$taxonomies = array_values( $taxonomies );

				// checking for taxonomies in this post_type
				if ( ! empty( $taxonomies ) ) {

					$taxonomy = $taxonomies[ 0 ]->name; // Get the first taxonomy
					$terms = get_the_terms( get_the_ID(), $taxonomy );
					if ( ! empty( $terms ) ) {

						$terms  = array_values( $terms );
						$term   = $terms[0]; // Get the first term

						$breadcrumbs[] = array(
							'title' => $term->name,
							'link'  => get_term_link( $term->term_id, $taxonomy )
						);

						$parent_id = (int)$term->parent;
						if ( $parent_id !== 0 ) {

							while ( $parent_id !== 0 ){

								$parent_term = get_term( $parent_id, $taxonomy );
								if ( is_wp_error( $parent_term ) )
									break;

								// insert on first position
								array_unshift(
									$breadcrumbs,
									array(
										'title' => $parent_term->name,
										'link'  => get_term_link( $parent_term, $taxonomy )
									)
								);
								$parent_id = (int)$parent_term->parent;
							}
						}
					}
				}
			}
			$breadcrumbs[] = array(
				'title' => get_the_title(),
			    'link'  => get_permalink()
			);
		} else if ( is_search() ) {

			$search_text  = __( 'Search for: %s', 'helsinki' );
			$search_query = get_search_query();
			$title        = sprintf( $search_text, $search_query );

			$breadcrumbs[] = array(
				'title' => $title,
			    'link'  => get_search_link()
			);
		} else if ( is_tag() ) {
			$breadcrumbs[] = array(
				'title'     => single_tag_title( '', false ),
			    'link'      => get_tag_link()
			);
		} else if ( is_author() ) {
			global $author;
			$user_data = get_userdata( $author );
			$breadcrumbs[] = array(
				'title' => $user_data->display_name,
			    'link'  => get_author_posts_url( $user_data->ID, $user_data->user_nicename )
			);
		} else if ( is_404() ) {
			$breadcrumbs[] = array(
				'title'     => _x( 'Error: Page does not exist.', 'breadcrumb nav prefix', 'helsinki' )
			);
		} else if ( is_tax() ) {
			global $wp_query;
			$value = get_query_var( $wp_query->query_vars[ 'taxonomy' ] );
			$type  = get_term_by( 'slug', $value, $wp_query->query_vars[ 'taxonomy' ] );

			$breadcrumbs[] = array(
				'title' => single_tag_title( '', false ),
			    'link'  => get_term_link( $type )
			);
		}
	}

	$show_on_front  = get_option( 'show_on_front' );
	$page_on_front  = get_option( 'page_on_front' );

	if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product() ) && $page_on_front !== wc_get_page_id( 'shop' ) ) {
		// first check if woo exists and we are on a product-page or on shop-archive/root-page
		$page_id = wc_get_page_id( 'shop' );

		// adding the "blog"-slug to breadcrumb
		$breadcrumb = array(
			'title' => get_the_title( $page_id ),
			'link'  => get_permalink( $page_id ),
		);

		array_unshift(
			$breadcrumbs,
			$breadcrumb
		);
	} else if ( $show_on_front === 'page' && !is_page() && get_post_type() === 'post' ) {
		// otherwise, check if we have set a "page" as front page, than we have to add "Blog" to our Breadcrumb
		$page_id = get_option( 'page_for_posts' );

		// adding the "blog"-slug to breadcrumb
		$breadcrumb = array(
			'title' => get_the_title( $page_id ),
			'link'  => get_permalink( $page_id ),
		);

		array_unshift(
			$breadcrumbs,
			$breadcrumb
		);
	}

	// adding the home_link if we activated it
	if ( (bool) $args[ 'show_home_link' ] ) {
		$breadcrumb  = array(
			'title' => $args[ 'home_text' ],
			'link'  => home_url()
		);

		array_unshift(
			$breadcrumbs,
			$breadcrumb
		);
	}

	// last but no least...adding the Page-Number to Breadcrumb
	if ( is_paged() ) {

		$title = sprintf(
			__( 'Page %s', 'helsinki' ),
			$paged
		);

		$breadcrumbs[] = array(
			'title' => $title,
			'link'  => get_pagenum_link( $paged )
		);
	}

	// building the markup
	$markup = $args[ 'before' ];

	$breadcrumb_count = count( $breadcrumbs ) - 1;
	foreach ( $breadcrumbs as $k => $breadcrumb ) {

		// the last one is the current one!
		if ( $k === $breadcrumb_count ) {
			$markup .= sprintf(
				$args[ 'current' ],
				$breadcrumb[ 'title' ]
			);
		} else if( isset( $breadcrumb[ 'link' ] ) ){
			$link = sprintf(
				$args[ 'link' ],
				$breadcrumb[ 'link' ],
				$breadcrumb[ 'title' ]
			);

			$markup .= sprintf(
				$args[ 'standard' ],
				$link
			);
		}
	}
	
	$markup .= $args[ 'after' ];
	return apply_filters( 'helsinki_get_breadcrumbs', $markup, $args, $breadcrumbs );
}
