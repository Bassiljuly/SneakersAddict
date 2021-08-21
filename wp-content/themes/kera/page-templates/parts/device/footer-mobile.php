<?php   global $woocommerce; 

    if( defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') || !defined('KERA_WOOCOMMERCE_ACTIVED') || is_product() || is_cart() || is_checkout() ) return;

?>

<?php
    /**
     * kera_before_topbar_mobile hook
     */
    do_action( 'kera_before_footer_mobile' );
?>
<div class="footer-device-mobile d-xl-none clearfix">

    <?php
        /**
        * kera_before_footer_mobile hook
        */
        do_action( 'kera_before_footer_mobile' );

        /**
        * Hook: kera_footer_mobile_content.
        *
        * @hooked kera_the_icon_home_footer_mobile - 5
        * @hooked kera_the_icon_wishlist_footer_mobile - 10
        * @hooked kera_the_icon_account_footer_mobile - 15
        * @hooked kera_the_icon_categories_footer_mobile - 25
        * @hooked kera_the_search_mobile - 30
        */

        do_action( 'kera_footer_mobile_content' );

        /**
        * kera_after_footer_mobile hook
        */
        do_action( 'kera_after_footer_mobile' );
    ?>

</div>