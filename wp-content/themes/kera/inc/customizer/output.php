<?php if ( ! defined('KERA_THEME_DIR')) exit('No direct script access allowed');

$theme_primary = require_once( get_parent_theme_file_path( KERA_INC . '/class-primary-color.php') );

$main_color 			= $theme_primary['color']; 
$main_bg 				= $theme_primary['background'];
$main_border 			= $theme_primary['border'];
$main_top_border 		= $theme_primary['border-top-color'];
$main_right_border 		= $theme_primary['border-right-color'];
$main_bottom_border 	= $theme_primary['border-bottom-color'];
$main_left_border 		= $theme_primary['border-left-color'];

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();

/*CustomMain color*/
$output['main_color'] = array( 
	'color' => kera_texttrim($main_color),
	'background-color' => kera_texttrim($main_bg),
	'border-color' => kera_texttrim($main_border),
);
if( !empty($main_top_border) ) {

	$bordertop = array(
		'border-top-color' => kera_texttrim($main_top_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$bordertop);
}
if( !empty($main_right_border) ) {
	
	$borderright = array(
		'border-right-color' => kera_texttrim($main_right_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderright);
}
if( !empty($main_bottom_border) ) {
	
	$borderbottom = array(
		'border-bottom-color' => kera_texttrim($main_bottom_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderbottom);
}
if( !empty($main_left_border) ) {
	
	$borderleft = array(
		'border-left-color' => kera_texttrim($main_left_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderleft);
}
/*Theme color second*/
$output['main_color_second'] = array( 
	'color'			=> kera_texttrim('.woocommerce .woocommerce-info a.button:hover,.woocommerce .woocommerce-message a.button:hover,.woocommerce .woocommerce-error a.button:hover,a:hover,a:focus,.has-after:hover,.post .entry-category.type-2 a:hover,.entry-meta-list .entry-author a:hover,.woocommerce form.login .lost_password a:hover,.woocommerce form.register .lost_password a:hover , .tbay-search-form .SumoSelect > .optWrapper > .options li.opt:hover label,#tbay-search-form-canvas .sidebar-canvas-search .sidebar-content .button-group .button-search i:hover,#tbay-search-form-canvas .sidebar-canvas-search .sidebar-content .select-category .optWrapper .options li:hover,#tbay-search-form-canvas .sidebar-content button:hover,.canvas-menu-sidebar .close-canvas-menu:hover,.canvas-menu-sidebar ul.menu > li > a:hover,.tbay-footer .menu li > a:hover,.tbay-footer ul.menu li.active a,.navbar-offcanvas .dropdown-menu > li.active > a,.navbar-offcanvas .dropdown-menu > li > a:hover,.navbar-offcanvas .dropdown-menu > li > a:focus,.woof_list_label li .woof_label_term.checked,.woof_list_label li .woof_label_term:hover,.widget_kera_popup_newsletter .popup-content > span:hover,.tbay-breadscrumb .breadcrumb li a:hover,.tbay-breadscrumb .breadcrumb li a:hover i,.tbay-breadscrumb.breadcrumbs-image .breadscrumb-inner .breadcrumb li a:hover,.tbay-breadscrumb.breadcrumbs-image .breadscrumb-inner .breadcrumb li.active , .tbay-body-default .post-navigation .post-title,.tbay-body-default .widget_pages > ul li a:hover,.tbay-body-default .widget_pages > ul li a[aria-current="page"],.tbay-body-default .widget_meta > ul li a:hover,.tbay-body-default .widget_meta > ul li a[aria-current="page"],.tbay-body-default .widget_archive > ul li a:hover,.tbay-body-default .widget_archive > ul li a[aria-current="page"],.tbay-body-default .widget ul li.current-cat > a,.product-block.v1 .group-buttons > div a.added,.product-block.v1 .add-cart a.added + a.added_to_cart:hover,.our-team-content .social-link a:hover,.product-block .group-buttons > div a:hover,.product-block .group-buttons > div a:focus,.product-block .group-buttons .yith-wcwl-wishlistexistsbrowse a,.product-block .group-buttons .yith-wcwl-wishlistaddedbrowse a,.product-block .add-cart a.added + a.added_to_cart,.product-block .name a:hover,.tbay-product-slider-gallery .slick-arrow:hover,.tbay-element-product-categories-tabs .tabs-list > li > a.active,.tbay-element-product-categories-tabs .tabs-list > li > a:hover,.tbay-element-product-categories-tabs .tabs-list > li > a:focus,.tbay-element-product-tabs .tabs-list > li > a.active,.tbay-element-product-tabs .tabs-list > li > a:hover,.tbay-element-product-tabs .tabs-list > li > a:focus,.post .entry-date a:hover,.post .comments-link a:hover,.post.sticky .readmore,.post.sticky .readmore:hover,.entry-meta-list a:hover,.entry-title a:hover,.entry-single .entry-category a:hover,.post-navigation .nav-links .meta-nav:hover,.post-navigation .post-title:hover,.tbay-addon-blog.relate-blog .owl-carousel > .slick-arrow:hover,.tbay-addon-blog.relate-blog .slider > .slick-arrow:hover,.owl-carousel > .slick-arrow:hover,.owl-carousel > .slick-arrow:focus,.slider > .slick-arrow:hover,.slider > .slick-arrow:focus,#cboxClose:hover:before,#cboxClose:focus:before,#cboxClose:hover:before,.products-list .product-block .group-buttons > div .yith-wcwl-wishlistaddedbrowse a,.products-list .product-block .group-buttons > div a:hover,.products-list .product-block .group-buttons > div a.added,.tbay-dropdown-cart .offcanvas-close:hover,.cart-dropdown .offcanvas-close:hover,.tbay-dropdown-cart .cart_list a.remove:hover i,.cart-dropdown .cart_list a.remove:hover i,.tbay-dropdown-cart .cart_list .product-name:hover,.cart-dropdown .cart_list .product-name:hover,#product-size-guide .close:hover i,#product-size-guide .close:focus i , .singular-shop .tbay-wishlist .yith-wcwl-wishlistexistsbrowse a,.singular-shop .tbay-wishlist .yith-wcwl-wishlistaddedbrowse a,.woocommerce div.product p.stock.out-of-stock span,body div.product p.stock.out-of-stock span,.woocs_price_code ins,.woocommerce-grouped-product-list-item__price ins,.shop_table.cart a.remove:hover i,#custom-login-wrapper .btn-close:hover'),
	'background-color' => kera_texttrim('.tbay-search-form .button-group , .top-wishlist .count_wishlist,.woocommerce span.onsale .saled , .post.sticky , .progress-bar'),
	'border' => kera_texttrim('#tbay-search-form-canvas .sidebar-content .btn-search-close:hover,.woof_list_label li .woof_label_term.checked,.woof_list_label li .woof_label_term:hover,.singular-shop .tbay-wishlist a:hover')
);

/*Custom Fonts*/
$output['primary-font'] = array('body, p, .btn, .button, .rev-btn, .rev-btn:visited');
$output['secondary-font'] = array('h1, h2, h3, h4, h5, h6, .widget-title');

/*Background hover*/
$output['background_hover']  	= $theme_primary['background_hover'];
/*Tablet*/
$output['tablet_color'] 	 	= $theme_primary['tablet_color'];
$output['tablet_background'] 	= $theme_primary['tablet_background'];
$output['tablet_border'] 		= $theme_primary['tablet_border'];
/*Mobile*/
$output['mobile_color'] 		= $theme_primary['mobile_color'];
$output['mobile_background'] 	= $theme_primary['mobile_background'];
$output['mobile_border'] 		= $theme_primary['mobile_border'];

/* Color Second Tablet */
$output['tablet_color_second'] 	 	= '.footer-device-mobile > *.active a';
$output['tablet_background_second'] 	= '.topbar-device-mobile .cart-dropdown .cart-icon .mini-cart-items';

/* Color Second Mobile*/
$output['mobile_color_second'] 		= '.footer-device-mobile > *.active a';
$output['mobile_background_second'] 	= '.topbar-device-mobile .cart-dropdown .cart-icon .mini-cart-items';

/*Header Mobile*/
$output['header_mobile_bg'] = array( 
	'background-color' => kera_texttrim('.topbar-device-mobile')
);
$output['header_mobile_color'] = array( 
	'color' => kera_texttrim('.topbar-device-mobile i, .topbar-device-mobile.active-home-icon .topbar-title')
);

return apply_filters( 'kera_get_output', $output);
