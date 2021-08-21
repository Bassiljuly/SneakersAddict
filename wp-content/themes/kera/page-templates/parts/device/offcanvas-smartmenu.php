<?php 
    $location = 'mobile-menu';
    $tbay_location  = '';
    if ( has_nav_menu( $location ) ) { 
        $tbay_location = $location;
    }

$mmenu_langue           = kera_tbay_get_config('enable_mmenu_langue', false); 
$mmenu_currency         = kera_tbay_get_config('enable_mmenu_currency', false); 
$order_tracking         = kera_tbay_get_config('enable_mmenu_order_tracking', false); 
$tracking_pages         = kera_tbay_get_config('mmenu_order_tracking_pages'); 

?>
  
<div id="tbay-mobile-smartmenu" data-title="<?php esc_attr_e('Menu', 'kera'); ?>" class="tbay-mmenu d-xl-none"> 

    <div class="tbay-offcanvas-body">

        <nav id="tbay-mobile-menu-navbar" class="menu navbar navbar-offcanvas navbar-static">
            <?php


                $args = array(
                    'fallback_cb' => '',
                );


                $menu_name = $menu_id = '';

                if( empty($menu_one_id) ) {
                    $locations  = get_nav_menu_locations();

                    if ( !empty( $locations[ $tbay_location ] )) {
                        $menu_id    = $locations[ $tbay_location ] ;
                        $menu_obj   = wp_get_nav_menu_object( $menu_id );
                    }
                    $args['theme_location']     = $tbay_location;
                } else {
                    $menu_obj = wp_get_nav_menu_object($menu_one_id);
                    $args['menu']               = $menu_one_id;
                }

                if ( !empty($menu_obj) ) {
                    $menu_name = $menu_obj->slug;
                }

                $args['container_id']       =   'main-mobile-menu-mmenu';
                $args['items_wrap']         =   '<ul id="%1$s" class="%2$s" data-id="'. $menu_name .'">%3$s</ul>';
                $args['menu_id']            =   'main-mobile-menu-mmenu-wrapper';
                $args['walker']             =   new Kera_Tbay_mmenu_menu();

                wp_nav_menu($args);

 
                if( isset($menu_second) && $menu_second ) {

                    $args_second = array(
                        'menu'    => $menu_second_id,
                        'fallback_cb' => '',
                    );

                    $menu_second_name = $menu_second_id;
                    if( !empty($menu_second_id) ) {
                        $menu_second_obj = wp_get_nav_menu_object($menu_second_id);
                        $menu_second_name = $menu_second_obj->slug;
                    }

                    $args_second['container_id']       =   'mobile-menu-second-mmenu';
                    $args_second['menu_id']            =   'main-mobile-second-mmenu-wrapper';
                    $args_second['items_wrap']         =   '<ul id="%1$s" class="%2$s" data-id="'. $menu_second_name .'">%3$s</ul>';
                    $args_second['walker']             =   new Kera_Tbay_mmenu_menu();
               
 
                    wp_nav_menu($args_second);

                }


            ?>
        </nav>

    </div>

    <?php if( $order_tracking || $mmenu_langue || $mmenu_currency ) : ?>
    <div id="mm-tbay-bottom">  

        <div class="mm-bottom-track-wrapper">

            <?php if( $order_tracking ): ?>
                <?php 
                    $url = get_permalink($tracking_pages);
                ?>
                <?php if( !empty($url) ) : ?>
                    <div class="mm-bottom-track">
                        <a href="<?php echo esc_url($url); ?>">
                            <?php echo get_the_title( $tracking_pages ); ?>
                        </a>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

            <?php 
                if( !empty($url) ) {
                    $class_langue = 'full';
                } else {
                    $class_langue = '';
                }
            ?>
            <?php 
                if($mmenu_langue || $mmenu_currency ) {
                    ?>
                    <div class="mm-bottom-langue-currency <?php echo esc_attr($class_langue); ?>">
                        <?php if( $mmenu_langue ): ?>
                            <div class="mm-bottom-langue">
                                <?php do_action('kera_tbay_header_custom_language'); ?>
                            </div>
                        <?php endif; ?>
                
                        <?php if( $mmenu_currency && class_exists('WooCommerce') && class_exists( 'WOOCS' ) ): ?>
                            <div class="mm-bottom-currency">
                                <div class="tbay-currency">
                                <?php echo do_shortcode( '[woocs txt_type = "desc"]' ); ?> 
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    <?php
                }
            ?>
        </div>


    </div>
    <?php endif; ?>

</div>