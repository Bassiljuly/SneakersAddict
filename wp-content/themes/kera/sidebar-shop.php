<?php
$class_shop = '';
$sidebar_configs = kera_tbay_get_woocommerce_layout_configs();
$sidebar_id = $sidebar_configs['sidebar']['id'];

if( empty($sidebar_id) )  return;

if( kera_woo_is_vendor_page() ) {
	$class_shop .= ' vendor_sidebar';
}



if( kera_woo_is_wcmp_vendor_store() ) {
	$sidebar_id = 'wc-marketplace-store';
}

if( is_product_category() || is_product_tag() || is_product_taxonomy() || is_shop() ) {
	$class_shop .= ' sidebar-page-shop';
}

?> 
<?php  if (  isset($sidebar_configs['sidebar']) && is_active_sidebar($sidebar_id) ) : ?>

	<aside id="sidebar-shop" class="sidebar d-none d-xl-block <?php echo esc_attr($sidebar_configs['sidebar']['class']); ?> <?php echo esc_attr($class_shop); ?>">
		<?php dynamic_sidebar($sidebar_id); ?>
	</aside>

<?php endif; ?>