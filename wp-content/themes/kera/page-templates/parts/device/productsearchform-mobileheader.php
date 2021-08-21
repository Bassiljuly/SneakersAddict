<?php 
	$_id = kera_tbay_random_key();

	$autocomplete_search 			=  kera_tbay_get_config('mobile_autocomplete_search', true);
	$enable_mobile_search_category 	=  kera_tbay_get_config('mobile_enable_mobile_search_category');
	$enable_image 					=  kera_tbay_get_config('mobile_show_search_product_image', true);
	$enable_price 					=  kera_tbay_get_config('mobile_show_search_product_price', true);
	$search_type 					=  kera_tbay_get_config('mobile_search_type');
	$number 						=  kera_tbay_get_config('mobile_search_max_number_results', 5);
	$minchars 						=  kera_tbay_get_config('mobile_search_min_chars', 2);

	$search_text_categories 	= esc_html__('All categories','kera');
	$search_placeholder 		=  kera_tbay_get_config('mobile_search_placeholder', esc_html__('I’m searching for...', 'kera'));
	$button_search 				=  kera_tbay_get_config('button_search', 'all');
	$button_search_text 		=  kera_tbay_get_config('button_search_text', 'Search');
	$button_search_icon 		=  kera_tbay_get_config('button_search_icon', 'icon-magnifier');


	$class_active_ajax = ( $autocomplete_search ) ? 'kera-ajax-search' : '';
?>
<?php $_id = kera_tbay_random_key(); ?>
<div id="search-device-content" class="modal fade device-modal-dialog" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			 <div class="modal-body">
				<div class="tbay-search-form tbay-search-mobile">
					    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" data-parents=".topbar-device-mobile" class="searchform <?php echo esc_attr($class_active_ajax); ?>" data-appendto=".search-results-<?php echo esc_attr( $_id ); ?>" data-thumbnail="<?php echo esc_attr( $enable_image ); ?>" data-price="<?php echo esc_attr( $enable_price ); ?>" data-minChars="<?php echo esc_attr( $minchars ) ?>" data-post-type="<?php echo esc_attr( $search_type ) ?>" data-count="<?php echo esc_attr( $number ); ?>">
						<div class="form-group">

							<div class="input-group">
								<input data-style="right" type="text" placeholder="<?php echo esc_attr($search_placeholder); ?>" name="s" required oninvalid="this.setCustomValidity('<?php esc_attr_e('Enter at least 2 characters', 'kera'); ?>')" oninput="setCustomValidity('')" class="tbay-search form-control input-sm"/>

								<div class="search-results-wrapper"> 	 
									<div class="kera-search-results search-results-<?php echo esc_attr( $_id ); ?>" data-ajaxsearch="<?php echo esc_attr( $autocomplete_search ) ?>" data-price="<?php echo esc_attr( $enable_price ); ?>"></div>
								</div>
								<div class="button-group input-group-addon">
				                    <button type="submit" class="button-search btn btn-sm>">
				                        <i class="icon-magnifier"></i>
				                    </button> 
				                    <div class="tbay-preloader"></div>
				                </div>
				            </div>

				            <?php if ( (bool) $enable_mobile_search_category ): ?>
								<div class="select-category input-group-addon">
									<span class="category-title"><?php esc_html_e( 'Search in:', 'kera' ) ?></span>
									
									<?php if ( class_exists( 'WooCommerce' ) && $search_type === 'product' ) :
										$args = array(
											'show_option_none'   => $search_text_categories,
											'show_count' => 1,
											'hierarchical' => true,
											'id' => 'product-cat-'.$_id,
											'show_uncategorized' => 0
										);
									?> 
									<?php wc_product_dropdown_categories( $args ); ?>
									
									<?php elseif ( $search_type === 'post' ):
										$args = array(
											'show_option_all' => $search_text_categories,
											'hierarchical' => true,
											'show_uncategorized' => 0,
											'name' => 'category', 
											'id' => 'blog-cat-'.$_id,
											'class' => 'postform dropdown_product_cat',
										);
									?>
										<?php wp_dropdown_categories( $args ); ?>
									<?php endif; ?>

								</div>
							<?php endif; ?>

							<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type ); ?>" class="post_type" />
							
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>