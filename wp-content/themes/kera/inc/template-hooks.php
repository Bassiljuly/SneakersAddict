<?php if ( ! defined('KERA_THEME_DIR')) exit('No direct script access allowed');
/**
 * Kera woocommerce Template Hooks
 *
 * Action/filter hooks used for Kera woocommerce functions/templates.
 *
 */


/**
 * Kera Header Mobile Content.
 *
 * @see kera_the_button_mobile_menu()
 * @see kera_the_logo_mobile()
 * @see kera_top_header_mobile()
 */
add_action( 'kera_header_mobile_content', 'kera_the_button_mobile_menu', 5 );
add_action( 'kera_header_mobile_content', 'kera_the_logo_mobile', 10 );
add_action( 'kera_header_mobile_content', 'kera_top_header_mobile', 15 );
add_action( 'kera_header_mobile_content', 'kera_the_hook_header_title_main_menu', 10 );


/**
 * Kera Header Mobile before content
 *
 * @see kera_the_hook_header_mobile_all_page
 */
add_action( 'kera_before_header_mobile', 'kera_the_hook_header_mobile_all_page', 5 );

/**
 * Kera Footer Mobile Content.
 *
 * @see kera_the_icon_home_footer_mobile()
 * @see kera_the_icon_wishlist_footer_mobile()
 * @see kera_the_icon_categories_footer_mobile()
 * @see kera_the_icon_account_footer_mobile()
 */
add_action( 'kera_footer_mobile_content', 'kera_the_icon_home_footer_mobile', 5 );
add_action( 'kera_footer_mobile_content', 'kera_the_icon_wishlist_footer_mobile', 10 );
add_action( 'kera_footer_mobile_content', 'kera_the_icon_account_footer_mobile', 15 );
add_action( 'kera_footer_mobile_content', 'kera_the_icon_categories_footer_mobile', 25 );
add_action( 'kera_footer_mobile_content', 'kera_the_search_mobile', 30 );