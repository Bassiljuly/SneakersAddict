<?php

// Remove default breadcrumb
add_filter( 'woocommerce_breadcrumb_defaults', 'kera_tbay_woocommerce_breadcrumb_defaults' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'kera_woo_template_main_before', 'woocommerce_breadcrumb', 20 ); 


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


/*Page check out*/
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment', 20 );

// Remove Default Sidebars
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 ); 



/**
 * Product Add to cart.
 *
 * @see woocommerce_template_single_add_to_cart()
 * @see woocommerce_simple_add_to_cart()
 * @see woocommerce_grouped_add_to_cart()
 * @see woocommerce_variable_add_to_cart()
 * @see woocommerce_external_add_to_cart()
 * @see woocommerce_single_variation()
 * @see woocommerce_single_variation_add_to_cart_button()
 */
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );


remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);



/**
 * Product Vertical
 *
 * @see woocommerce_after_shop_loop_item_vertical_title()
 */

add_action( 'woocommerce_after_title_item_vertical', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_price_item_vertical', 'woocommerce_template_loop_add_to_cart', 10 );



