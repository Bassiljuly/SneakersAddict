<?php 
global $product;


do_action( 'kera_woocommerce_before_product_block_grid' );

$flash_sales 	= isset($flash_sales) ? $flash_sales : false;
$end_date 		= isset($end_date) ? $end_date : '';

$countdown_title 		= isset($countdown_title) ? $countdown_title : '';

$countdown 		= isset($countdown) ? $countdown : false;
$class = array();
$class_flash_sale = kera_tbay_class_flash_sale($flash_sales);
array_push($class, $class_flash_sale);

?>
<div <?php kera_tbay_product_class($class); ?> data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<div class="product-content">
		<div class="block-inner">
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
					*/
					do_action( 'kera_tbay_after_shop_loop_item_title' );
				?>
				<?php kera_tbay_item_deal_ended_flash_sale($flash_sales, $end_date); ?>
			</figure>
			<div class="group-buttons">	
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

				<?php 
					kera_the_yith_wishlist();
					kera_the_quick_view($product->get_id());
					kera_the_yith_compare($product->get_id());
				?>
	    	</div>
		</div>
		<div class="caption">
			<?php 
				do_action('kera_woo_before_shop_loop_item_caption');
			?>

			<?php kera_the_product_name(); ?>

			<?php
				/**
				* woocommerce_after_shop_loop_item_title hook
				*
				* @hooked woocommerce_template_loop_rating - 5
				* @hooked woocommerce_template_loop_price - 10
				* @hooked kera_tbay_woocommerce_variable - 15
				*/

				do_action( 'woocommerce_after_shop_loop_item_title');
			?>
		</div>
    </div>
    <?php kera_tbay_stock_flash_sale($flash_sales); ?>
    <?php kera_woo_product_time_countdown($countdown, $countdown_title); ?>
</div>
<?php
do_action( 'kera_woocommerce_after_product_block_grid' );
