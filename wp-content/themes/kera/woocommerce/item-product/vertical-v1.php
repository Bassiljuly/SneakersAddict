<?php 
global $product;


do_action( 'kera_woocommerce_before_product_vertical' );

?>
<div class="product-block vertical" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	
	<div class="product-content">
		
		<div class="block-inner">
			<figure class="image">
				<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo trim($product->get_image()); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</figure>
		</div>

		<div class="caption">
						
			<?php kera_the_product_name(); ?>
			<div class="meta-vertical">
				<?php
					/**
					* @hooked woocommerce_template_loop_price - 10
					*/
					do_action( 'woocommerce_after_title_item_vertical');
				?>
				<?php do_action( 'woocommerce_after_price_item_vertical' ); ?>
			</div>
		</div>
		
    </div>
    
</div>
