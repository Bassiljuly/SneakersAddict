<?php 
global $product;

?>
<div class="product-block list" data-product-id="<?php echo esc_attr($product->get_id()); ?>">

	<div class="product-content row">
		<div class="block-inner col-5 col-lg-4">
			<?php 
				do_action('kera_tbay_before_image_item');
			?>
			<figure class="image <?php kera_product_block_image_class(); ?>">
				
				<a title="<?php the_title_attribute(); ?>" href="<?php echo the_permalink(); ?>" class="product-image">
					<?php
						/**
						* woocommerce_before_shop_loop_item_title hook
						*
						* @hooked woocommerce_show_product_loop_sale_flash - 10
						* @hooked woocommerce_template_loop_product_thumbnail - 10
						*/
						do_action( 'woocommerce_before_shop_loop_item_title' );
					?>
				</a>

				<?php 
					/**
					* kera_tbay_after_shop_loop_item_title hook
					*
					* @hooked kera_tbay_add_slider_image - 10
					* @hooked kera_tbay_woocommerce_variable - 15
					*/
					do_action( 'kera_tbay_after_shop_loop_item_title' );
				?>
			</figure>  
			
		</div>
		<div class="caption col-7 col-lg-8">
			<?php kera_the_product_name(); ?>
			<?php
				/**
				* woocommerce_after_shop_loop_item_title hook
				*
				* @hooked woocommerce_template_loop_rating - 5
				* @hooked woocommerce_template_loop_price - 10
				* @hooked kera_tbay_woocommerce_variable - 15
				*/
				remove_action('woocommerce_after_shop_loop_item_title', 'kera_tbay_woocommerce_variable', 15);
				do_action( 'woocommerce_after_shop_loop_item_title');
				add_action('woocommerce_after_shop_loop_item_title', 'kera_tbay_woocommerce_variable', 15);
			?>
				<div class="group-buttons clearfix">	
					<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
					<?php
						if(class_exists( 'YITH_Woocompare' ) || kera_tbay_get_config('enable_quickview', false) || class_exists('YITH_WCWL_Shortcode')) {
							?>
								<div class="group-btn-child">
									<?php 
										kera_the_yith_compare($product->get_id());
										kera_the_quick_view($product->get_id());
										kera_the_yith_wishlist();
									?>
								</div>
							<?php
						}
					?>
					
				</div>
			
			<div class="woocommerce-product-details__short-description">
				<?php echo get_the_excerpt(); ?>
			</div>
			<?php
				do_action( 'kera_woo_list_after_caption');
			?>
		</div>
	</div>
	<?php 
		do_action( 'kera_woocommerce_after_shop_list_item' );
	?>
</div>


