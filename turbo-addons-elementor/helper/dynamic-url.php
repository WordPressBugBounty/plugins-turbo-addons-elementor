<?php
/**
 * Turbo Addons Elementor — Dynamic URL Engine
 *
 * Provides a hook-based dynamic URL/token system so any widget with a link
 * control can resolve placeholders such as `{home_url}`, `{post_url}` etc.
 * alongside the regular custom URL — without depending on Elementor Pro.
 *
 * Usage in any widget render():
 *   $url = trad_get_link_url( $settings['link'] );        // Elementor URL array or string
 *   $url = trad_resolve_dynamic_url( $settings['link']['url'] ); // raw string
 *
 * @package Turbo_Addons_Elementor
 * @since   1.9.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'trad_is_woocommerce_active' ) ) {
	/**
	 * Whether WooCommerce is installed and active.
	 *
	 * @since 1.9.2
	 *
	 * @return bool
	 */
	function trad_is_woocommerce_active() {
		return class_exists( 'WooCommerce' ) || function_exists( 'WC' );
	}
}

if ( ! function_exists( 'trad_get_author_id' ) ) {
	/**
	 * Resolve the author ID for the current post or author archive.
	 *
	 * @since 1.9.2
	 *
	 * @param \WP_Post|null $post Optional post object.
	 * @return int Author user ID, 0 when unknown.
	 */
	function trad_get_author_id( $post = null ) {
		if ( $post && isset( $post->post_author ) ) {
			return (int) $post->post_author;
		}

		$queried = get_queried_object();
		if ( $queried instanceof \WP_User ) {
			return (int) $queried->ID;
		}

		if ( is_singular() && get_queried_object_id() ) {
			$post = get_post( get_queried_object_id() );
			return $post ? (int) $post->post_author : 0;
		}

		return 0;
	}
}

if ( ! function_exists( 'trad_get_dynamic_url_tokens' ) ) {
	/**
	 * Registered dynamic URL tokens.
	 *
	 * Extend the list via the `trad_dynamic_url_tokens` filter. Keys are the
	 * tokens used inside `{...}` placeholders, values are human-readable labels.
	 *
	 * @since 1.9.2
	 *
	 * @return array<string,string> Token => Label pairs.
	 */
	function trad_get_dynamic_url_tokens() {
		$tokens = [
			'home_url'         => __( 'Home URL', 'turbo-addons-elementor' ),
			'site_url'         => __( 'Site URL', 'turbo-addons-elementor' ),
			'site_name'        => __( 'Site Name', 'turbo-addons-elementor' ),
			'admin_email'      => __( 'Admin Email', 'turbo-addons-elementor' ),
			'current_page_url' => __( 'Current Page URL', 'turbo-addons-elementor' ),
			'post_url'         => __( 'Current Post URL', 'turbo-addons-elementor' ),
			'post_title'       => __( 'Current Post Title', 'turbo-addons-elementor' ),
			'post_id'          => __( 'Current Post ID', 'turbo-addons-elementor' ),
			'author_url'       => __( 'Author Archive URL', 'turbo-addons-elementor' ),
			'login_url'        => __( 'Login URL', 'turbo-addons-elementor' ),
			'logout_url'       => __( 'Logout URL', 'turbo-addons-elementor' ),
			'register_url'     => __( 'Registration URL', 'turbo-addons-elementor' ),
			'admin_url'        => __( 'WP Admin URL', 'turbo-addons-elementor' ),
			'current_year'     => __( 'Current Year', 'turbo-addons-elementor' ),
		];

		if ( trad_is_woocommerce_active() ) {
			$tokens = array_merge( $tokens, [
				'product_url'       => __( 'Product URL', 'turbo-addons-elementor' ),
				'shop_url'          => __( 'Shop URL', 'turbo-addons-elementor' ),
				'cart_url'          => __( 'Cart URL', 'turbo-addons-elementor' ),
				'checkout_url'      => __( 'Checkout URL', 'turbo-addons-elementor' ),
				'my_account_url'    => __( 'My Account URL', 'turbo-addons-elementor' ),
				'terms_url'         => __( 'Terms & Conditions URL', 'turbo-addons-elementor' ),
				'orders_url'        => __( 'Orders URL', 'turbo-addons-elementor' ),
				'downloads_url'     => __( 'Downloads URL', 'turbo-addons-elementor' ),
				'edit_account_url'  => __( 'Edit Account URL', 'turbo-addons-elementor' ),
				'edit_address_url'  => __( 'Edit Address URL', 'turbo-addons-elementor' ),
				'lost_password_url' => __( 'Lost Password URL', 'turbo-addons-elementor' ),
				'add_to_cart_url'   => __( 'Add to Cart URL', 'turbo-addons-elementor' ),
			] );
		}

		/**
		 * Filter the registered dynamic URL tokens.
		 *
		 * @since 1.9.2
		 *
		 * @param array<string,string> $tokens Token => Label pairs.
		 */
		return apply_filters( 'trad_dynamic_url_tokens', $tokens );
	}
}

if ( ! function_exists( 'trad_get_current_page_url' ) ) {
	/**
	 * Build the full URL of the currently requested page.
	 *
	 * @since 1.9.2
	 *
	 * @return string Current page URL (trailing slash preserved when available).
	 */
	function trad_get_current_page_url() {
		if ( is_singular() && get_queried_object_id() ) {
			return get_permalink( get_queried_object_id() );
		}

		global $wp;
		return home_url( add_query_arg( [], $wp->request ) );
	}
}

if ( ! function_exists( 'trad_get_dynamic_url_token_value' ) ) {
	/**
	 * Resolve a single dynamic token to its value.
	 *
	 * @since 1.9.2
	 *
	 * @param string $token   Token key (without braces).
	 * @param int    $post_id Optional post ID used for post context.
	 *
	 * @return string Resolved value. Empty string when the token has no value.
	 */
	function trad_get_dynamic_url_token_value( $token, $post_id = 0 ) {
		$post_id = $post_id ? absint( $post_id ) : ( is_singular() ? get_queried_object_id() : 0 );
		$post    = $post_id ? get_post( $post_id ) : null;

		$value = '';

		switch ( $token ) {
			case 'home_url':
				$value = home_url( '/' );
				break;

			case 'site_url':
				$value = site_url( '/' );
				break;

			case 'site_name':
				$value = get_bloginfo( 'name' );
				break;

			case 'admin_email':
				$value = get_option( 'admin_email' );
				break;

			case 'current_page_url':
				$value = trad_get_current_page_url();
				break;

			case 'post_url':
				$value = $post ? get_permalink( $post ) : '';
				break;

			case 'post_title':
				$value = $post ? get_the_title( $post ) : '';
				break;

			case 'post_id':
				$value = $post ? (string) $post->ID : '';
				break;

			case 'author_url':
				$value = $post ? get_author_posts_url( (int) $post->post_author ) : '';
				break;

			case 'login_url':
				$value = wp_login_url();
				break;

			case 'logout_url':
				$value = wp_logout_url();
				break;

			case 'register_url':
				$value = wp_registration_url();
				break;

			case 'admin_url':
				$value = admin_url();
				break;

			case 'current_year':
				$value = gmdate( 'Y' );
				break;

			// Text tokens (used by Turbo Addons text dynamic tags).
			case 'site_tagline':
				$value = get_bloginfo( 'description' );
				break;

			case 'current_date':
				$value = wp_date( get_option( 'date_format' ) );
				break;

			case 'current_time':
				$value = wp_date( get_option( 'time_format' ) );
				break;

			case 'post_excerpt':
				$value = $post ? get_the_excerpt( $post ) : '';
				break;

			case 'post_date':
				$value = $post ? get_the_date( '', $post ) : '';
				break;

			case 'post_time':
				$value = $post ? get_the_time( '', $post ) : '';
				break;

			case 'post_modified_date':
				$value = $post ? get_the_modified_date( '', $post ) : '';
				break;

			case 'post_comment_count':
				$value = $post ? (string) get_comments_number( $post ) : '';
				break;

			case 'author_name':
				$author_id = trad_get_author_id( $post );
				$value     = $author_id ? get_the_author_meta( 'display_name', $author_id ) : '';
				break;

			case 'author_bio':
				$author_id = trad_get_author_id( $post );
				$value     = $author_id ? get_the_author_meta( 'description', $author_id ) : '';
				break;

			case 'archive_title':
				$value = is_archive() ? get_the_archive_title() : '';
				break;

			case 'archive_description':
				$value = is_archive() ? wp_strip_all_tags( get_the_archive_description() ) : '';
				break;

			case 'post_categories':
				if ( $post ) {
					$terms = get_the_category( $post );
					$value = is_wp_error( $terms ) ? '' : implode( ', ', wp_list_pluck( $terms, 'name' ) );
				}
				break;

			case 'post_tags':
				if ( $post ) {
					$terms = get_the_tags( $post );
					$value = ( is_wp_error( $terms ) || ! $terms ) ? '' : implode( ', ', wp_list_pluck( $terms, 'name' ) );
				}
				break;

			case 'current_user_name':
				$current_user = wp_get_current_user();
				$value        = $current_user && $current_user->exists() ? $current_user->display_name : '';
				break;

			case 'current_user_email':
				$current_user = wp_get_current_user();
				$value        = $current_user && $current_user->exists() ? $current_user->user_email : '';
				break;

			// WooCommerce URLs (only resolved when WooCommerce is active).
			case 'product_url':
				if ( trad_is_woocommerce_active() ) {
					$queried = get_queried_object();
					if ( $queried instanceof \WP_Post && 'product' === $queried->post_type ) {
						$value = get_permalink( $queried );
					}
				}
				break;

			case 'shop_url':
				if ( function_exists( 'wc_get_page_permalink' ) ) {
					$value = wc_get_page_permalink( 'shop' );
				}
				break;

			case 'cart_url':
				if ( function_exists( 'wc_get_cart_url' ) ) {
					$value = wc_get_cart_url();
				}
				break;

			case 'checkout_url':
				if ( function_exists( 'wc_get_checkout_url' ) ) {
					$value = wc_get_checkout_url();
				}
				break;

			case 'my_account_url':
				if ( function_exists( 'wc_get_page_permalink' ) ) {
					$value = wc_get_page_permalink( 'myaccount' );
				}
				break;

			case 'terms_url':
				if ( function_exists( 'wc_get_page_permalink' ) ) {
					$value = wc_get_page_permalink( 'terms' );
				}
				break;

			case 'orders_url':
				if ( function_exists( 'wc_get_account_endpoint_url' ) ) {
					$value = wc_get_account_endpoint_url( 'orders' );
				}
				break;

			case 'downloads_url':
				if ( function_exists( 'wc_get_account_endpoint_url' ) ) {
					$value = wc_get_account_endpoint_url( 'downloads' );
				}
				break;

			case 'edit_account_url':
				if ( function_exists( 'wc_get_account_endpoint_url' ) ) {
					$value = wc_get_account_endpoint_url( 'edit-account' );
				}
				break;

			case 'edit_address_url':
				if ( function_exists( 'wc_get_account_endpoint_url' ) ) {
					$value = wc_get_account_endpoint_url( 'edit-address' );
				}
				break;

			case 'lost_password_url':
				if ( function_exists( 'wc_get_account_endpoint_url' ) ) {
					$value = wc_get_account_endpoint_url( 'lost-password' );
				}
				break;

			case 'add_to_cart_url':
				if ( trad_is_woocommerce_active() && function_exists( 'wc_get_cart_url' ) ) {
					$queried = get_queried_object();
					if ( $queried instanceof \WP_Post && 'product' === $queried->post_type ) {
						$value = add_query_arg( 'add-to-cart', $queried->ID, wc_get_cart_url() );
					}
				}
				break;

			default:
				$value = '';
				break;
		}

		/**
		 * Filter a resolved dynamic token value.
		 *
		 * Use this to support custom tokens registered through
		 * `trad_dynamic_url_tokens`.
		 *
		 * @since 1.9.2
		 *
		 * @param string $value   Resolved value.
		 * @param string $token   Token key.
		 * @param int    $post_id Post ID used for context.
		 */
		return apply_filters( 'trad_dynamic_url_token_value', $value, $token, $post_id );
	}
}

if ( ! function_exists( 'trad_resolve_dynamic_url' ) ) {
	/**
	 * Replace `{token}` placeholders inside a URL with their dynamic values.
	 *
	 * @since 1.9.2
	 *
	 * @param string $url     Raw URL, possibly containing `{token}` placeholders.
	 * @param int    $post_id Optional post ID used for post context.
	 *
	 * @return string URL with all registered tokens resolved.
	 */
	function trad_resolve_dynamic_url( $url, $post_id = 0 ) {
		if ( empty( $url ) || ! is_string( $url ) ) {
			return (string) $url;
		}

		$resolved = $url;

		foreach ( trad_get_dynamic_url_tokens() as $token => $label ) {
			$value    = trad_get_dynamic_url_token_value( $token, $post_id );
			$resolved = str_replace( '{' . $token . '}', (string) $value, $resolved );
		}

		/**
		 * Filter the fully resolved dynamic URL.
		 *
		 * @since 1.9.2
		 *
		 * @param string $resolved Resolved URL.
		 * @param string $url      Original URL input.
		 * @param int    $post_id  Post ID used for context.
		 */
		return apply_filters( 'trad_dynamic_url', $resolved, $url, $post_id );
	}
}

if ( ! function_exists( 'trad_get_link_url' ) ) {
	/**
	 * Resolve a widget link value into a plain URL string.
	 *
	 * Accepts either an Elementor URL array (`['url' => '...']`) or a plain
	 * string and resolves any dynamic `{token}` placeholders.
	 *
	 * @since 1.9.2
	 *
	 * @param array|string $link    Elementor URL control value or a URL string.
	 * @param int          $post_id Optional post ID used for post context.
	 *
	 * @return string Resolved URL.
	 */
	function trad_get_link_url( $link, $post_id = 0 ) {
		if ( is_array( $link ) ) {
			$url = isset( $link['url'] ) ? $link['url'] : '';
		} else {
			$url = (string) $link;
		}

		return trad_resolve_dynamic_url( $url, $post_id );
	}
}

if ( ! function_exists( 'trad_get_dynamic_link_options' ) ) {
	/**
	 * Options for a widget "Dynamic Link" select control.
	 *
	 * @since 1.9.2
	 *
	 * @return array<string,string> Control options keyed by token.
	 */
	function trad_get_dynamic_link_options() {
		$options = [
			'none' => __( 'None (use custom link)', 'turbo-addons-elementor' ),
		];

		foreach ( trad_get_dynamic_url_tokens() as $token => $label ) {
			$options[ '{' . $token . '}' ] = $label;
		}

		/**
		 * Filter the "Dynamic Link" select control options.
		 *
		 * @since 1.9.2
		 *
		 * @param array<string,string> $options Token => Label pairs.
		 */
		return apply_filters( 'trad_dynamic_link_options', $options );
	}
}

if ( ! function_exists( 'trad_add_dynamic_link_control' ) ) {
	/**
	 * Register a "Dynamic Link" select control on an Elementor widget.
	 *
	 * Call this inside the widget's `_register_controls()` right after the link
	 * control you want to make dynamic-aware.
	 *
	 * @since 1.9.2
	 *
	 * @param \Elementor\Widget_Base $widget  Widget instance.
	 * @param string                 $name    Control key. Defaults to `dynamic_link`.
	 * @param string                 $label   Control label.
	 * @param array                  $extra   Extra control arguments merged last.
	 *
	 * @return string Registered control key.
	 */
	function trad_add_dynamic_link_control( $widget, $name = 'dynamic_link', $label = '', $extra = [] ) {
		if ( ! $widget instanceof \Elementor\Widget_Base ) {
			return '';
		}

		$defaults = [
			'label'       => $label ? $label : __( 'Dynamic Link', 'turbo-addons-elementor' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'default'     => 'none',
			'options'     => trad_get_dynamic_link_options(),
			'description' => sprintf(
				/* translators: %s: example token */
				esc_html__( 'Choose a dynamic link, or use a token like %s directly inside the custom link field.', 'turbo-addons-elementor' ),
				'<code>{home_url}</code>'
			),
		];

		$args  = wp_parse_args( $extra, $defaults );
		$key   = sanitize_key( $name );

		$widget->add_control( $key, $args );

		return $key;
	}
}
