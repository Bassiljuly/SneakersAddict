<?php if ( ! defined('KERA_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_tbay_get_button_mobile_menu' ) ) {
	function kera_tbay_get_button_mobile_menu() {

		$output 	= '';
		$output 	.= '<a href="#tbay-mobile-menu-navbar" id="mmenu-btn-open" data-title="'. esc_attr__('Main Menu', 'kera') .'" class="btn btn-sm">';
		$output  .= '<i class="icon- icon-menu"></i>';
		$output  .= '</a>';			

		$output  .= '<a id="mmenu-btn-close" href="#page" class="btn btn-sm">';
		$output  .= '<i class="zmdi zmdi-close"></i>';
		$output  .= '</a>';

		
		return apply_filters( 'kera_tbay_get_button_mobile_menu', '<div class="active-mobile">'. $output . '</div>', 10 );

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'kera_the_button_mobile_menu' ) ) {
	function kera_the_button_mobile_menu() {
		wp_enqueue_script( 'jquery-mmenu' );
		$ouput = kera_tbay_get_button_mobile_menu();
		
		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Logo Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_tbay_get_logo_mobile' ) ) {
	function kera_tbay_get_logo_mobile() {
		$mobilelogo 			= kera_tbay_get_config('mobile-logo');

		$output 	= '<div class="mobile-logo">';
			if( isset($mobilelogo['url']) && !empty($mobilelogo['url']) ) { 
				$url    	= $mobilelogo['url'];
				$output 	.= '<a href="'. esc_url( home_url( '/' ) ) .'">'; 

				if( isset($mobilelogo['width']) && !empty($mobilelogo['width']) ) {
					$output 		.= '<img class="logo-mobile-img" src="'. esc_url( $url ) .'" width="'. esc_attr($mobilelogo['width']) .'" height="'. esc_attr($mobilelogo['height']) .'" alt="'. get_bloginfo( 'name' ) .'">';
				} else {
					$output 		.= '<img class="logo-mobile-img" src="'. esc_url( $url ) .'" alt="'. get_bloginfo( 'name' ) .'">';
				}

				
				$output 		.= '</a>';

			} else {
				$output 		.= '<div class="logo-theme">';
					$output 	.= '<a href="'. esc_url( home_url( '/' ) ) .'">';
					$output 	.= '<img class="logo-mobile-img" src="'. esc_url_raw( KERA_IMAGES.'/logo.svg') .'" alt="'. get_bloginfo( 'name' ) .'">';
					$output 	.= '</a>';
				$output 		.= '</div>';
			}
		$output 	.= '</div>';
		
		return apply_filters( 'kera_tbay_get_logo_mobile', $output, 10 );

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Logo Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'kera_the_logo_mobile' ) ) {
	function kera_the_logo_mobile() {
		$ouput = kera_tbay_get_logo_mobile();
		
		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Mini cart mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_the_mini_cart_header_mobile' ) ) {
	function kera_the_mini_cart_header_mobile() {
		global $woocommerce; 
		$_id 	= kera_tbay_random_key();
		if( !defined('KERA_WOOCOMMERCE_ACTIVED') || defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') ) return;
		?>

        <div class="top-cart tbay-element-mini-cart">
        	<?php kera_tbay_get_page_templates_parts('offcanvas-cart','right'); ?>
            <div class="tbay-topcart">
				<div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown dropdown">
					<a class="dropdown-toggle mini-cart v2" data-offcanvas="offcanvas-right" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#">
						<span class="cart-icon">
							<i class="icon- icon-handbag"></i>
							<span class="mini-cart-items">
							   <?php echo sprintf( '%d', $woocommerce->cart->cart_contents_count );?>
							</span>
						</span>
					</a> 
					<a href="javascript:void(0)" class="cart-close"><i class="zmdi zmdi-close"></i></a>  
					<div class="dropdown-menu"></div>    
				</div>
			</div> 
		</div>

		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The search header mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_the_search_mobile' ) ) {
	function kera_the_search_mobile() { 
		?>
			<div class="search-device">
				<a class="btn-click search-icon"  data-toggle="modal" data-target="#search-device-content" data-close="#btn-search-close" data-status="open" data-title="<?php esc_attr_e('Search', 'kera'); ?>" data-event="search" href="javascript:;">
					<span class="open">
						<i class="icon-magnifier"></i>
						<span><?php esc_html_e('Search', 'kera'); ?></span>
					</span>
					<span class="close">
						<i class="zmdi zmdi-close"></i>
						<span><?php esc_html_e('Close', 'kera'); ?></span>
					</span>
				</a>
			</div>

		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Mini cart mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_the_mini_cart_header_mobile' ) ) {
	function kera_the_mini_cart_header_mobile() {  
		kera_tbay_get_page_templates_parts('offcanvas-cart','right'); 
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Top right header mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_top_header_mobile' ) ) {
	function kera_top_header_mobile() { ?>
		<div class="top-right-mobile top-cart-mobile">
			<?php 
				/**
				* Hook: kera_top_header_mobile.
				*
				* @hooked kera_the_mini_cart_header_mobile - 5
				*/
				add_action('kera_top_header_mobile', 'kera_the_mini_cart_header_mobile', 5);
				do_action( 'kera_top_header_mobile' );
			?>
		</div>
	<?php }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Title Page Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_tbay_get_title_page_mobile' ) ) {
	function kera_tbay_get_title_page_mobile() {
		$output = '';

		if( class_exists('WooCommerce') && !is_product_category() ) {
			$output 	.= '<div class="topbar-title">';
			$output  	.= apply_filters( 'kera_get_filter_title_mobile', 10,2 );
			$output  	.= '</div>';
		} else {
			$output  	.= apply_filters( 'kera_get_filter_title_mobile', 10,2 );
		}

		
		return apply_filters( 'kera_tbay_get_title_page_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The icon Back On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'kera_the_title_page_mobile' ) ) {
	function kera_the_title_page_mobile() {
		$ouput = kera_tbay_get_title_page_mobile();
		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Home Page On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_tbay_get_icon_home_page_mobile' ) ) {
	function kera_tbay_get_icon_home_page_mobile() {
		$output 	= '<div class="topbar-icon-home">';
		$output 	.= '<a href="'. esc_url( home_url( '/' ) ) .'">';
		$output  	.= apply_filters( 'kera_get_mobile_home_icon', '<i class="icon-home"></i>', 2 );
		$output  	.= '</a>';
		$output  	.= '</div>';
		
		return apply_filters( 'kera_tbay_get_icon_home_page_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Home Page On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'kera_the_icon_product_more_mobile' ) ) {
	function kera_the_icon_product_more_mobile() {
		?>

		<div class="topbar-icon-more">
			<a href="javascript:void(0);" class="mobile-icon-more">
				<i class="zmdi zmdi-more"></i>
			</a>
			<div class="content">
				<?php do_action('kera_the_icon_product_more_content'); ?>
			</div>
		</div>

		<?php
	}
}

if ( ! function_exists( 'kera_the_icon_product_more_mobile_home_page' ) ) {
	function kera_the_icon_product_more_mobile_home_page() {
		?>
		<div class="back-home">
			<a class="more-home-page" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<i class="icon-home"></i>
				<span><?php esc_html_e('Home', 'kera'); ?></span>
			</a>
		</div>
		<?php
	}
	add_action('kera_the_icon_product_more_content', 'kera_the_icon_product_more_mobile_home_page', 10);
}

if ( ! function_exists( 'kera_the_icon_product_more_mobile_categories' ) ) {
	function kera_the_icon_product_more_mobile_categories() {
		kera_the_icon_categories_footer_mobile();
	}
	add_action('kera_the_icon_product_more_content', 'kera_the_icon_product_more_mobile_categories', 20);
}

if ( ! function_exists( 'kera_the_icon_product_more_mobile_account' ) ) {
	function kera_the_icon_product_more_mobile_account() {
		$ouput = kera_tbay_get_icon_account_footer_mobile();
		
		echo trim($ouput);
	}
	add_action('kera_the_icon_product_more_content', 'kera_the_icon_product_more_mobile_account', 30);
}
 
if ( ! function_exists( 'kera_the_icon_product_more_mobile_share' ) ) {
	function kera_the_icon_product_more_mobile_share() { 
		if( !kera_tbay_get_config('enable_code_share',false)  || !kera_tbay_get_config('enable_product_social_share', false) || !is_product() ) return;
		?>
		<div class="device-share">
			<a class="btn-click more-share" data-close="#btn-share-close"  href="javascript:void(0);" data-status="open" data-title="<?php esc_attr_e('Share', 'kera'); ?>" data-event="share">
				<i class="zmdi zmdi-share"></i>
				<span><?php esc_html_e('Share', 'kera'); ?></span>
			</a>
			<div id="btn-share-close-wrapper">
			</div>
			<div class="content-share">
              <div class="tbay-woo-share">
				  <span class="share-title"><?php esc_html_e('Share this to product:', 'kera'); ?></span>
				  <?php 
						if( kera_tbay_get_config('select_share_type') == 'custom' ) {
							$image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
							kera_custom_share_code( get_the_title(), get_permalink(), $image );
						} else {
							?>
							<div class="addthis_inline_share_toolbox"></div>
							<?php
						}
				  ?>
              </div>
			</div>
		</div>
		<?php
	}
	add_action('kera_the_icon_product_more_content', 'kera_the_icon_product_more_mobile_share', 40);
}


/**
 * ------------------------------------------------------------------------------------------------
 * The Hook Config Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_the_hook_header_mobile_all_page' ) ) {
	function kera_the_hook_header_mobile_all_page() {
		 
		if( !defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && defined('KERA_WOOCOMMERCE_ACTIVED') && (is_product() || is_cart() || is_checkout()) ) {
			add_action( 'kera_top_header_mobile', 'kera_the_icon_product_more_mobile', 15 );
		}

		$always_display_logo 			= kera_tbay_get_config('always_display_logo', false);
		
		if( $always_display_logo || kera_tbay_is_home_page() ) return;

		remove_action( 'kera_header_mobile_content', 'kera_the_logo_mobile', 10 );
		add_action( 'kera_header_mobile_content', 'kera_the_title_page_mobile', 10 );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * The Hook Config Title Main Menu
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_the_hook_header_title_main_menu' ) ) {
	function kera_the_hook_header_title_main_menu() {
		?>
		<?php if( !defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && defined('KERA_WOOCOMMERCE_ACTIVED') && (is_product() || is_cart() || is_checkout()) ) : ?>
			<div class="hdmobile-close-wrapper">
				<a id="btn-categories-close" class="hdmobile-close" href="javascript:void(0)"><i class="icon-arrow-left"></i></a>
				<a id="btn-account-close" class="hdmobile-close" href="javascript:void(0)"><i class="zmdi zmdi-close"></i></a>
				<a id="btn-share-close" class="hdmobile-close" href="javascript:void(0)"><i class="icon-arrow-left"></i></a>
			</div>
		<?php endif; ?>		

		<?php if( !defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED')  && defined('KERA_WOOCOMMERCE_ACTIVED') && (is_shop() || is_product_category() || is_product_tag()) ) : ?>  
			<div class="hdmobile-close-wrapper">
				<a id="btn-filter-close" class="hdmobile-close" href="javascript:void(0)"><i class="icon-arrow-left"></i></a>
			</div>
		<?php endif; ?>
		<div class="hdmobile-title"></div>
		<?php
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Home Page On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_tbay_get_icon_home_footer_mobile' ) ) {
	function kera_tbay_get_icon_home_footer_mobile() {

		$active = (is_front_page()) ? 'active' : '';

		$output	 = '<div class="device-home '. $active .' ">';
		$output  .= '<a href="'. esc_url( home_url( '/' ) ) .'" >';
		$output  .= apply_filters( 'kera_get_mobile_home_icon', '<i class="icon-home"></i>', 2 );
		$output  .= '<span>'. esc_html__('Home','kera'). '</span>';
		$output  .='</a>';
		$output  .='</div>';
		
		return apply_filters( 'kera_tbay_get_icon_home_footer_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Home Page On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'kera_the_icon_home_footer_mobile' ) ) {
	function kera_the_icon_home_footer_mobile() {
		$ouput = kera_tbay_get_icon_home_footer_mobile();
		
		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Wishlist On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_tbay_get_icon_wishlist_footer_mobile' ) ) {
	function kera_tbay_get_icon_wishlist_footer_mobile() {
		$output = '';
		
		if( !class_exists( 'YITH_WCWL' ) ) return $output;

		$wishlist_url 	= YITH_WCWL()->get_wishlist_url();
		$wishlist_count = YITH_WCWL()->count_products();

		$output	 .= '<div class="device-wishlist">';
		$output  .= '<a class="text-skin wishlist-icon" href="'. esc_url($wishlist_url) .'" >';
		$output  .= apply_filters( 'kera_get_mobile_wishlist_icon', '<i class="icon-heart"></i>', 2 );
		$output  .= '<span class="count count_wishlist">'. esc_html($wishlist_count) .'</span>';
		$output  .= '<span>'. esc_html__('Wishlist','kera'). '</span>';
		$output  .='</a>';
		$output  .='</div>';
		
		return apply_filters( 'kera_tbay_get_icon_wishlist_footer_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Wishlist On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'kera_the_icon_wishlist_footer_mobile' ) ) {
	function kera_the_icon_wishlist_footer_mobile() {
		$ouput = kera_tbay_get_icon_wishlist_footer_mobile();
		
		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Account On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_tbay_get_icon_account_footer_mobile' ) ) {
	function kera_tbay_get_icon_account_footer_mobile() {
		$output 			= '';
		$show_login 		= kera_tbay_get_config('mobile_show_login', false);
		$show_login_popup 	= kera_tbay_get_config('mobile_show_login_popup', true);

		if ( defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') || !defined('KERA_WOOCOMMERCE_ACTIVED') || !$show_login ) return $output;

		$icon_text 	= apply_filters( 'kera_get_mobile_user_icon', '<i class="icon-user"></i>', 2 );
		$icon_text .= '<span>'.esc_html__('Account','kera').'</span>';

		$active 	= ( is_account_page() ) ? 'active' : '';

		$output	 .= '<div class="device-account '. esc_attr( $active ) .'">';
		if (is_user_logged_in() || !$show_login_popup ) {
			$output .= '<a class="logged-in" href="'. esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) .'"  title="'. esc_attr__('Login','kera') .'">';
			$output .= $icon_text;
		} 
		else {  
			$output .= '<a class="btn-click mobile-popup-login" data-toggle="modal" data-target="#custom-login-wrapper" data-close="#btn-account-close"  data-status="open" data-title="'. esc_attr__('Account', 'kera') .'" data-event="login" href="javascript:;">';
			$output .= '<span class="open">';
				$output .= '<i class="icon-user"></i>';
				$output .= '<span>'. esc_html__('Account', 'kera') .'</span>';
			$output .= '</span>';

			$output .= '<span class="close">';
				$output .= '<i class="zmdi zmdi-close"></i>';
				$output .= '<span>'. esc_html__('Close', 'kera') .'</span>';
			$output .= '</span>';
		}
		$output .= '</a>';

		$output  .='</div>';
		
		return apply_filters( 'kera_tbay_get_icon_account_footer_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Account On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'kera_the_icon_account_footer_mobile' ) ) {
	function kera_the_icon_account_footer_mobile() {
		$ouput = kera_tbay_get_icon_account_footer_mobile();
		
		echo trim($ouput);
	}
}
/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Categories On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'kera_the_icon_categories_footer_mobile' ) ) {
	function kera_the_icon_categories_footer_mobile() {

		if( !kera_is_elementor_activated() ) return;

		$show_categories 		= kera_tbay_get_config('mobile_show_categories', false);
		if( !$show_categories ) return;

		$template_id 		    = kera_tbay_get_config('mobile_select_categories');

		if( empty($template_id) ) return;
		?> 
		<div class="categories-device">
			<a class="btn-click categories-icon" data-toggle="modal" data-target="#categories-device-content" data-close="#btn-categories-close" data-status="open" data-title="<?php esc_attr_e('categories', 'kera'); ?>" data-event="categories" href="javascript:;">
				<span class="open"> 
					<i class="icon-menu"></i>
					<span><?php esc_html_e('categories', 'kera') ?></span>
				</span>
				<span class="close">
					<i class="zmdi zmdi-close"></i>
					<span><?php esc_html_e('Close', 'kera') ?></span>
				</span>
			</a>
		</div>
		<?php
	}
}