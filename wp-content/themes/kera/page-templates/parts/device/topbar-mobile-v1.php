<?php   
	$class_top_bar 	=  '';

	$always_display_logo 			= kera_tbay_get_config('always_display_logo', false);
	if( !$always_display_logo && !defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && defined('KERA_WOOCOMMERCE_ACTIVED') && (is_product() || is_cart() || is_checkout()) ) {
		$class_top_bar .= ' active-home-icon';
	}
?>
<div class="topbar-device-mobile d-xl-none clearfix <?php echo esc_attr( $class_top_bar ); ?>">

	<?php
		/**
		* kera_before_header_mobile hook
		*/
		do_action( 'kera_before_header_mobile' );

		/**
		* Hook: kera_header_mobile_content.
		*
		* @hooked kera_the_button_mobile_menu - 5
		* @hooked kera_the_logo_mobile - 10
		* @hooked kera_the_title_page_mobile - 10
		* @hooked kera_top_header_mobile - 15
		*/

		do_action( 'kera_header_mobile_content' );

		/**
		* kera_after_header_mobile hook
		*/
		do_action( 'kera_after_header_mobile' );
	?>
</div>