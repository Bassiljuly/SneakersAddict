<?php if ( has_nav_menu( 'nav-category-menu' ) ):

$open =   apply_filters( 'kera_category_inside_class', '');

?>
<div class="category-inside vertical-menu <?php echo esc_attr($open); ?>">
    <a href="javascript:void(0);" class="category-inside-title"><i class="icon-menu"></i><?php echo apply_filters( 'kera_category_inside_title', esc_html__( 'All Departments', 'kera' ) ); ?></a>
    <div class="category-inside-content">
        <nav role="navigation">
            <?php
                $args = array(
                    'theme_location' => 'nav-category-menu',
                    'menu_class'      => 'tbay-menu-category tbay-vertical',
                    'fallback_cb'     => '',
                    'menu_id' => 'nav-category-menu',
                );
                if( class_exists("Kera_Tbay_Custom_Nav_Menu") ){

                    $args['walker'] = new Kera_Tbay_Custom_Nav_Menu();
                }
                wp_nav_menu($args);
            ?>
        </nav>
    </div>
</div>
<?php endif;?>