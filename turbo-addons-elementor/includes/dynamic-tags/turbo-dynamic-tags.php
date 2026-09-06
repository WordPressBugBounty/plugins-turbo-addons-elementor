<?php
/**
 * Turbo Addons Elementor — Native Dynamic Tags
 *
 * Registers Turbo Addons' own dynamic tags so any control that enables
 * `'dynamic' => [ 'active' => true ]` shows these tags in Elementor's native
 * dynamic-tags dropdown — exactly like Elementor Pro, but without Pro.
 *
 * @package Turbo_Addons_Elementor
 * @since   1.9.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Make sure Elementor's dynamic tags API is available before defining classes.
if ( ! class_exists( '\Elementor\Core\DynamicTags\Tag' ) ) {
	return;
}

use Elementor\Core\DynamicTags\Tag as TRAD_Elementor_Tag;
use Elementor\Core\DynamicTags\Data_Tag as TRAD_Elementor_Data_Tag;

/* -------------------------------------------------------------------------
 * Base classes
 * ---------------------------------------------------------------------- */

if ( ! class_exists( 'TRAD_Url_Tag' ) ) {
	/**
	 * Base dynamic tag for URL controls.
	 */
	abstract class TRAD_Url_Tag extends TRAD_Elementor_Tag {

		/**
		 * Tag group shown in the editor dropdown.
		 */
		public function get_group() {
			return 'turbo-addons';
		}

		/**
		 * Make the tag available for URL controls.
		 */
		public function get_categories() {
			return [ 'url' ];
		}

		/**
		 * Resolve the raw URL (widgets apply esc_url() at output).
		 *
		 * @return string
		 */
		abstract protected function get_url();

		/**
		 * Output the tag value.
		 */
		public function render() {
			echo $this->get_url(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by the widget/control.
		}
	}
}

if ( ! class_exists( 'TRAD_Text_Tag' ) ) {
	/**
	 * Base dynamic tag for text controls.
	 */
	abstract class TRAD_Text_Tag extends TRAD_Elementor_Tag {

		/**
		 * Tag group shown in the editor dropdown.
		 */
		public function get_group() {
			return 'turbo-addons';
		}

		/**
		 * Make the tag available for text controls.
		 */
		public function get_categories() {
			return [ 'text' ];
		}

		/**
		 * Resolve the raw value.
		 *
		 * @return string
		 */
		abstract protected function get_value();

		/**
		 * Output the tag value.
		 */
		public function render() {
			echo $this->get_value(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by the widget/control.
		}
	}
}

if ( ! function_exists( 'trad_get_attachment_image_data' ) ) {
	/**
	 * Build an Elementor-compatible image data array from an attachment ID.
	 *
	 * @since 1.9.2
	 *
	 * @param int    $attachment_id Attachment ID.
	 * @param string $size          Registered image size.
	 * @return array{id:string,url:string}
	 */
	function trad_get_attachment_image_data( $attachment_id, $size = 'full' ) {
		$attachment_id = absint( $attachment_id );

		if ( ! $attachment_id ) {
			return [ 'id' => '', 'url' => '' ];
		}

		$src = wp_get_attachment_image_src( $attachment_id, $size );

		return [
			'id'  => $attachment_id,
			'url' => is_array( $src ) && ! empty( $src[0] ) ? $src[0] : '',
		];
	}
}

if ( ! class_exists( 'TRAD_Image_Tag' ) ) {
	/**
	 * Base dynamic tag for image/media controls.
	 */
	abstract class TRAD_Image_Tag extends TRAD_Elementor_Data_Tag {

		/**
		 * Tag group shown in the editor dropdown.
		 */
		public function get_group() {
			return 'turbo-addons';
		}

		/**
		 * Make the tag available for image controls.
		 */
		public function get_categories() {
			return [ 'image' ];
		}

		/**
		 * Resolve the image data (attachment ID + URL).
		 *
		 * @return array{id:string,url:string}
		 */
		abstract protected function get_image_data();

		/**
		 * Return the image data to Elementor.
		 *
		 * @param array $options Render options.
		 * @return array{id:string,url:string}
		 */
		protected function get_value( array $options = [] ) {
			return $this->get_image_data();
		}
	}
}

/* -------------------------------------------------------------------------
 * URL tags (category: url)
 * ---------------------------------------------------------------------- */

class TRAD_Url_Home_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-home-url'; }
	public function get_title() { return __( 'Home URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'home_url' ); }
}

class TRAD_Url_Site_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-site-url'; }
	public function get_title() { return __( 'Site URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'site_url' ); }
}

class TRAD_Url_Current_Page_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-current-page-url'; }
	public function get_title() { return __( 'Current Page URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'current_page_url' ); }
}

class TRAD_Url_Post_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-post-url'; }
	public function get_title() { return __( 'Current Post URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'post_url' ); }
}

class TRAD_Url_Author_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-author-url'; }
	public function get_title() { return __( 'Author Archive URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'author_url' ); }
}

class TRAD_Url_Login_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-login-url'; }
	public function get_title() { return __( 'Login URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'login_url' ); }
}

class TRAD_Url_Logout_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-logout-url'; }
	public function get_title() { return __( 'Logout URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'logout_url' ); }
}

class TRAD_Url_Register_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-register-url'; }
	public function get_title() { return __( 'Registration URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'register_url' ); }
}

class TRAD_Url_Admin_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-admin-url'; }
	public function get_title() { return __( 'WP Admin URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'admin_url' ); }
}

/* -------------------------------------------------------------------------
 * Text tags (category: text)
 * ---------------------------------------------------------------------- */

class TRAD_Text_Site_Name_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-site-name'; }
	public function get_title() { return __( 'Site Name', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'site_name' ); }
}

class TRAD_Text_Admin_Email_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-admin-email'; }
	public function get_title() { return __( 'Admin Email', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'admin_email' ); }
}

class TRAD_Text_Post_Title_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-title'; }
	public function get_title() { return __( 'Post Title', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_title' ); }
}

class TRAD_Text_Post_Id_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-id'; }
	public function get_title() { return __( 'Post ID', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_id' ); }
}

class TRAD_Text_Current_Year_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-current-year'; }
	public function get_title() { return __( 'Current Year', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'current_year' ); }
}

class TRAD_Text_Site_Tagline_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-site-tagline'; }
	public function get_title() { return __( 'Site Tagline', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'site_tagline' ); }
}

class TRAD_Text_Current_Date_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-current-date'; }
	public function get_title() { return __( 'Current Date', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'current_date' ); }
}

class TRAD_Text_Current_Time_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-current-time'; }
	public function get_title() { return __( 'Current Time', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'current_time' ); }
}

class TRAD_Text_Post_Excerpt_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-excerpt'; }
	public function get_title() { return __( 'Post Excerpt', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_excerpt' ); }
}

class TRAD_Text_Post_Date_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-date'; }
	public function get_title() { return __( 'Post Date', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_date' ); }
}

class TRAD_Text_Post_Time_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-time'; }
	public function get_title() { return __( 'Post Time', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_time' ); }
}

class TRAD_Text_Post_Modified_Date_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-modified-date'; }
	public function get_title() { return __( 'Post Modified Date', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_modified_date' ); }
}

class TRAD_Text_Post_Comment_Count_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-comment-count'; }
	public function get_title() { return __( 'Post Comment Count', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_comment_count' ); }
}

class TRAD_Text_Author_Name_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-author-name'; }
	public function get_title() { return __( 'Author Name', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'author_name' ); }
}

class TRAD_Text_Author_Bio_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-author-bio'; }
	public function get_title() { return __( 'Author Bio', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'author_bio' ); }
}

class TRAD_Text_Archive_Title_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-archive-title'; }
	public function get_title() { return __( 'Archive Title', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'archive_title' ); }
}

class TRAD_Text_Archive_Description_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-archive-description'; }
	public function get_title() { return __( 'Archive Description', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'archive_description' ); }
}

class TRAD_Text_Post_Categories_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-categories'; }
	public function get_title() { return __( 'Post Categories', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_categories' ); }
}

class TRAD_Text_Post_Tags_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-post-tags'; }
	public function get_title() { return __( 'Post Tags', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'post_tags' ); }
}

class TRAD_Text_Current_User_Name_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-current-user-name'; }
	public function get_title() { return __( 'Current User Name', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'current_user_name' ); }
}

class TRAD_Text_Current_User_Email_Tag extends TRAD_Text_Tag {
	public function get_name() { return 'trad-current-user-email'; }
	public function get_title() { return __( 'Current User Email', 'turbo-addons-elementor' ); }
	protected function get_value() { return trad_get_dynamic_url_token_value( 'current_user_email' ); }
}

/* -------------------------------------------------------------------------
 * WooCommerce URL tags (category: url) — registered only when Woo is active
 * ---------------------------------------------------------------------- */

class TRAD_Url_Product_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-product-url'; }
	public function get_title() { return __( 'Product URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'product_url' ); }
}

class TRAD_Url_Shop_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-shop-url'; }
	public function get_title() { return __( 'Shop URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'shop_url' ); }
}

class TRAD_Url_Cart_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-cart-url'; }
	public function get_title() { return __( 'Cart URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'cart_url' ); }
}

class TRAD_Url_Checkout_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-checkout-url'; }
	public function get_title() { return __( 'Checkout URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'checkout_url' ); }
}

class TRAD_Url_My_Account_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-my-account-url'; }
	public function get_title() { return __( 'My Account URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'my_account_url' ); }
}

class TRAD_Url_Terms_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-terms-url'; }
	public function get_title() { return __( 'Terms & Conditions URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'terms_url' ); }
}

class TRAD_Url_Orders_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-orders-url'; }
	public function get_title() { return __( 'Orders URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'orders_url' ); }
}

class TRAD_Url_Downloads_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-downloads-url'; }
	public function get_title() { return __( 'Downloads URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'downloads_url' ); }
}

class TRAD_Url_Edit_Account_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-edit-account-url'; }
	public function get_title() { return __( 'Edit Account URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'edit_account_url' ); }
}

class TRAD_Url_Edit_Address_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-edit-address-url'; }
	public function get_title() { return __( 'Edit Address URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'edit_address_url' ); }
}

class TRAD_Url_Lost_Password_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-lost-password-url'; }
	public function get_title() { return __( 'Lost Password URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'lost_password_url' ); }
}

class TRAD_Url_Add_To_Cart_Tag extends TRAD_Url_Tag {
	public function get_name() { return 'trad-add-to-cart-url'; }
	public function get_title() { return __( 'Add to Cart URL', 'turbo-addons-elementor' ); }
	protected function get_url() { return trad_get_dynamic_url_token_value( 'add_to_cart_url' ); }
}

/* -------------------------------------------------------------------------
 * Image tags (category: image)
 * ---------------------------------------------------------------------- */

class TRAD_Image_Site_Logo_Tag extends TRAD_Image_Tag {
	public function get_name() { return 'trad-site-logo'; }
	public function get_title() { return __( 'Site Logo', 'turbo-addons-elementor' ); }
	protected function get_image_data() {
		return trad_get_attachment_image_data( get_theme_mod( 'custom_logo' ) );
	}
}

class TRAD_Image_Featured_Image_Tag extends TRAD_Image_Tag {
	public function get_name() { return 'trad-featured-image'; }
	public function get_title() { return __( 'Featured Image', 'turbo-addons-elementor' ); }
	protected function get_image_data() {
		$post_id  = is_singular() ? get_queried_object_id() : 0;
		$thumb_id = $post_id ? get_post_thumbnail_id( $post_id ) : 0;

		return trad_get_attachment_image_data( $thumb_id );
	}
}

class TRAD_Image_Author_Avatar_Tag extends TRAD_Image_Tag {
	public function get_name() { return 'trad-author-avatar'; }
	public function get_title() { return __( 'Author Avatar', 'turbo-addons-elementor' ); }
	protected function get_image_data() {
		$author_id = trad_get_author_id();

		return [
			'id'  => '',
			'url' => $author_id ? get_avatar_url( $author_id, [ 'size' => 512 ] ) : '',
		];
	}
}

class TRAD_Image_Current_User_Avatar_Tag extends TRAD_Image_Tag {
	public function get_name() { return 'trad-current-user-avatar'; }
	public function get_title() { return __( 'Current User Avatar', 'turbo-addons-elementor' ); }
	protected function get_image_data() {
		$user    = wp_get_current_user();
		$user_id = ( $user && $user->exists() ) ? $user->ID : 0;

		return [
			'id'  => '',
			'url' => $user_id ? get_avatar_url( $user_id, [ 'size' => 512 ] ) : '',
		];
	}
}

class TRAD_Image_Product_Image_Tag extends TRAD_Image_Tag {
	public function get_name() { return 'trad-product-image'; }
	public function get_title() { return __( 'Product Image', 'turbo-addons-elementor' ); }
	protected function get_image_data() {
		if ( ! trad_is_woocommerce_active() ) {
			return [ 'id' => '', 'url' => '' ];
		}

		$queried = get_queried_object();

		if ( $queried instanceof \WP_Post && 'product' === $queried->post_type ) {
			return trad_get_attachment_image_data( get_post_thumbnail_id( $queried ), 'woocommerce_single' );
		}

		return [ 'id' => '', 'url' => '' ];
	}
}

/* -------------------------------------------------------------------------
 * Registration
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'trad_register_dynamic_tags' ) ) {
	/**
	 * Register Turbo Addons dynamic tags and group with Elementor.
	 *
	 * @since 1.9.2
	 *
	 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags_manager Dynamic tags manager.
	 */
	function trad_register_dynamic_tags( $dynamic_tags_manager ) {
		if ( ! $dynamic_tags_manager instanceof \Elementor\Core\DynamicTags\Manager ) {
			return;
		}

		$dynamic_tags_manager->register_group( 'turbo-addons', [
			'title' => __( 'Turbo Addons', 'turbo-addons-elementor' ),
		] );

		$tags = [
			'TRAD_Url_Home_Tag',
			'TRAD_Url_Site_Tag',
			'TRAD_Url_Current_Page_Tag',
			'TRAD_Url_Post_Tag',
			'TRAD_Url_Author_Tag',
			'TRAD_Url_Login_Tag',
			'TRAD_Url_Logout_Tag',
			'TRAD_Url_Register_Tag',
			'TRAD_Url_Admin_Tag',
			'TRAD_Text_Site_Name_Tag',
			'TRAD_Text_Admin_Email_Tag',
			'TRAD_Text_Post_Title_Tag',
			'TRAD_Text_Post_Id_Tag',
			'TRAD_Text_Current_Year_Tag',
			'TRAD_Text_Site_Tagline_Tag',
			'TRAD_Text_Current_Date_Tag',
			'TRAD_Text_Current_Time_Tag',
			'TRAD_Text_Post_Excerpt_Tag',
			'TRAD_Text_Post_Date_Tag',
			'TRAD_Text_Post_Time_Tag',
			'TRAD_Text_Post_Modified_Date_Tag',
			'TRAD_Text_Post_Comment_Count_Tag',
			'TRAD_Text_Author_Name_Tag',
			'TRAD_Text_Author_Bio_Tag',
			'TRAD_Text_Archive_Title_Tag',
			'TRAD_Text_Archive_Description_Tag',
			'TRAD_Text_Post_Categories_Tag',
			'TRAD_Text_Post_Tags_Tag',
			'TRAD_Text_Current_User_Name_Tag',
			'TRAD_Text_Current_User_Email_Tag',
			'TRAD_Image_Site_Logo_Tag',
			'TRAD_Image_Featured_Image_Tag',
			'TRAD_Image_Author_Avatar_Tag',
			'TRAD_Image_Current_User_Avatar_Tag',
		];

		if ( trad_is_woocommerce_active() ) {
			$tags = array_merge( $tags, [
				'TRAD_Url_Product_Tag',
				'TRAD_Url_Shop_Tag',
				'TRAD_Url_Cart_Tag',
				'TRAD_Url_Checkout_Tag',
				'TRAD_Url_My_Account_Tag',
				'TRAD_Url_Terms_Tag',
				'TRAD_Url_Orders_Tag',
				'TRAD_Url_Downloads_Tag',
				'TRAD_Url_Edit_Account_Tag',
				'TRAD_Url_Edit_Address_Tag',
				'TRAD_Url_Lost_Password_Tag',
				'TRAD_Url_Add_To_Cart_Tag',
				'TRAD_Image_Product_Image_Tag',
			] );
		}

		/**
		 * Filter the list of Turbo Addons dynamic tag class names.
		 *
		 * @since 1.9.2
		 *
		 * @param array $tags Tag class names.
		 */
		$tags = apply_filters( 'trad_dynamic_tag_classes', $tags );

		foreach ( $tags as $tag_class ) {
			if ( class_exists( $tag_class ) ) {
				$dynamic_tags_manager->register( new $tag_class() );
			}
		}
	}
}

add_action( 'elementor/dynamic_tags/register', 'trad_register_dynamic_tags' );
