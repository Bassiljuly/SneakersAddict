<?php
if ( ! defined( 'ABSPATH' ) || !class_exists('WooCommerce') ) {
	exit;
}

if ( ! class_exists( 'Kera_Single_WooCommerce' ) ) :


	class Kera_Single_WooCommerce  {

		static $instance;
		protected $counter;

		/**
		 * @return osf_WooCommerce
		 */
		public static function getInstance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Kera_Single_WooCommerce ) ) {
				self::$instance = new Kera_Single_WooCommerce();
			}

			return self::$instance;
		}

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 *
		 */
		public function __construct() {
			$this->counter = 0;

			add_action( 'after_setup_theme', array( $this, 'setup_support' ), 10 );

			/*Single Product Wishlist*/
			add_action('woocommerce_before_single_product_summary', array( $this, 'single_product_wishlist'), 5);

			/*Body Class*/
			add_filter( 'body_class', array( $this, 'body_class_single_one_page'), 10, 1 );
			add_filter( 'body_class', array( $this, 'body_class_gallery_lightbox'), 10, 1 );


			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'buy_now_html'), 10 ); 

			/*Add To Cart Redirect*/ 
			add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'buy_now_redirect'), 99, 1 );


    		/*The list images review*/
    		add_action( 'woocommerce_before_single_product_summary', array( $this, 'the_list_images_review'), 100 );

    		add_action( 'woocommerce_single_product_summary', array( $this, 'share_box_html'), 50 );

    		add_filter( 'woo_class_single_product', array( $this, 'class_single_product'), 10, 1 );

    		add_filter( 'woo_tabs_style_single_product', array( $this, 'get_tabs_style_product'), 10, 1 );

    		add_action( 'woocommerce_single_product_summary', array( $this, 'the_product_single_time_countdown'), 20 );


    		if(!wp_is_mobile() ) {
			    add_action( 'woocommerce_before_single_product', array( $this, 'the_sticky_menu_bar'), 30 );

			    add_action( 'kera_sticky_menu_bar_product_summary', 'woocommerce_template_single_title', 5 );
			    add_action( 'kera_sticky_menu_bar_product_summary', 'woocommerce_template_single_rating', 10 );
			    add_action( 'kera_sticky_menu_bar_product_summary', array( $this, 'the_product_single_one_page'), 15 );


			    add_action( 'kera_sticky_menu_bar_product_price_cart', 'woocommerce_template_single_price', 5 );
			    add_action( 'kera_sticky_menu_bar_product_price_cart', array( $this, 'the_sticky_menu_bar_custom_add_to_cart'), 10 );
			}


			add_action('woocommerce_before_add_to_cart_button', array( $this, 'before_add_to_cart_form'), 99);
			add_action('woocommerce_after_add_to_cart_button', array( $this, 'close_after_add_to_cart_form'), 99);


			add_filter( 'woocommerce_output_related_products_args', array( $this, 'get_related_products_args'), 10, 1 );

			/** Video **/
			add_action( 'woocommerce_product_thumbnails', array( $this, 'get_video_audio_content_last' ), 99 );
			add_filter( 'woocommerce_single_product_image_thumbnail_html', array($this,'get_video_audio_content_first'), 10, 2 );

  			add_action( 'woocommerce_before_single_product' , array( $this, 'product_size_guide_hook') , 100 );


  			add_action('woocommerce_before_single_product', array( $this, 'remove_support_zoom_image'), 60);



  			/*Add custom html before, after button add to cart*/
  			add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'html_before_add_to_cart_button'), 10, 0 ); 
  			add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'html_after_add_to_cart_button'), 999, 0 ); 


  			add_action( 'kera_woo_after_single_rating', array( $this, 'the_total_sales_count'), 10 ); 

  			add_filter( 'woocommerce_photo_reviews_thumbnail_photo', array( $this, 'get_photo_reviews_thumbnail_size'), 10, 2 );
  			add_filter( 'woocommerce_photo_reviews_large_photo', array( $this, 'get_photo_reviews_large_size'), 10, 2 );

			/** Change size image photo reivew */
			add_filter('woocommerce_photo_reviews_reduce_array', array( $this, 'photo_reviews_reduce_array' ), 10 ,1);

			/** Remove Review Tab */
			add_filter( 'woocommerce_product_tabs', array( $this, 'remove_review_tab'), 100 );
 
			add_action( 'woocommerce_single_product_summary', array( $this, 'the_product_nav_image'), 70 );
		}

		public function setup_support() {
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

			if( class_exists( 'YITH_Woocompare' ) ) {
	            update_option( 'yith_woocompare_compare_button_in_products_list', 'no' ); 
	            update_option( 'yith_woocompare_compare_button_in_product_page', 'no' ); 
	        }        

	        if( class_exists( 'YITH_WCWL' ) ) {
	            update_option( 'yith_wcwl_button_position', 'shortcode' ); 
	        }
	        if( class_exists( 'YITH_WCBR' ) ) {
	            update_option( 'yith_wcbr_single_product_brands_content', 'name' );
	        }

	        add_filter( 'woocommerce_get_image_size_gallery_thumbnail', array( $this, 'get_image_size_gallery_thumbnail'), 10, 1 );

	        $ptreviews = $this->photo_reviews_thumbnail_image();

	        add_image_size( 'tbay_photo_reviews_thumbnail_image', $ptreviews['width'], $ptreviews['height'], $ptreviews['crop'] );
		}

		public function get_image_size_gallery_thumbnail() {
			$tbay_thumbnail_width       = get_option( 'tbay_woocommerce_thumbnail_image_width', 100);
            $tbay_thumbnail_height      = get_option( 'tbay_woocommerce_thumbnail_image_height', 100);
            $tbay_thumbnail_cropping    = get_option( 'tbay_woocommerce_thumbnail_cropping', 'yes');
            $tbay_thumbnail_cropping    = ($tbay_thumbnail_cropping == 'yes') ? true : false;

            return array( 
                'width'  => $tbay_thumbnail_width,
                'height' => $tbay_thumbnail_height,
                'crop'   => $tbay_thumbnail_cropping,
            );
		}

		private function photo_reviews_thumbnail_image() {
            $thumbnail_cropping    	= get_option( 'tbay_photo_reviews_thumbnail_image_cropping', 'yes');
            $cropping    			= ($thumbnail_cropping == 'yes') ? true : false;

            return array(
                'width'  => get_option( 'tbay_photo_reviews_thumbnail_image_width', 100),
                'height' => get_option( 'tbay_photo_reviews_thumbnail_image_height', 100),
                'crop'   => $cropping,
            );		
		}

		public function single_product_wishlist() {
	        ?>
	        <?php if(class_exists('YITH_WCWL') || class_exists('YITH_Woocompare')){ ?>
				<?php if(class_exists('YITH_WCWL')) { ?> 
					<div class="tbay-wishlist">
					<?php kera_the_yith_wishlist(); ?>
					</div>  
				<?php } ?>
	        <?php } ?>
	        <?php
		}

		public function buy_now_html() {
			global $product;
	        if ( ! intval( kera_tbay_get_config('enable_buy_now', false) ) ) {
	            return; 
	        }

	        if ( $product->get_type() == 'external' ) { 
	            return;
	        }

	        $class = 'tbay-buy-now button';

	        if( !empty($product) && $product->is_type( 'variable' ) ){
	            $default_attributes = kera_get_default_attributes( $product );
	            $variation_id = kera_find_matching_product_variation( $product, $default_attributes );
	            
	            if( empty($variation_id) ) {
	                $class .= ' disabled';
	            } 
	        }
	        echo sprintf( __( '<button class="%1$s">Buy Now</button>', 'kera' ), $class );
	        echo '<input type="hidden" value="0" name="kera_buy_now" />';
		}

		public function buy_now_redirect( $url ) {

	 		if ( ! isset( $_REQUEST['kera_buy_now'] ) || $_REQUEST['kera_buy_now'] == false ) {
	            return $url; 
	        }

	        if ( empty( $_REQUEST['quantity'] ) ) {
	            return $url;
	        }

	        if ( is_array( $_REQUEST['quantity'] ) ) {
	            $quantity_set = false;
	            foreach ( $_REQUEST['quantity'] as $item => $quantity ) {
	                if ( $quantity <= 0 ) {
	                    continue;
	                }
	                $quantity_set = true;
	            }

	            if ( ! $quantity_set ) {
	                return $url;
	            } 
	        } 

	        $redirect = kera_tbay_get_config('redirect_buy_now', 'cart') ;

	        switch ($redirect) {
	            case 'cart':
	                return wc_get_cart_url();   

	            case 'checkout':
	                return wc_get_checkout_url();  
	    
	            default:
	                return wc_get_cart_url(); 
	        }
		}

		public function the_list_images_review() {
			global $product;

	        if ( ! is_product() || ( ! class_exists( 'VI_Woo_Photo_Reviews' ) && ! class_exists( 'VI_WooCommerce_Photo_Reviews' ) ) ) {
	            return;
	        }

	        $product_title = $product->get_title();
	        $product_single_layout  =   ( isset($_GET['product_single_layout']) )   ?   $_GET['product_single_layout'] :  kera_get_single_select_layout();
	        $args     = array(
	            'post_type'    => 'product',
	            'type'         => 'review',
	            'status'       => 'approve',
	            'post_id'      => $product->get_id(),
	            'meta_key'     => 'reviews-images'
	        ); 

	        $comments = get_comments( $args );

	        if (is_array($comments) || is_object($comments)) {
	            $outputs = '<div id="list-review-images">';
	            $outputs .= '<h4>'. esc_html__('Images from customers:', 'kera') .'</h4>';
	            $outputs .= '<ul>';

	            $i = 0;
	            foreach ( $comments as $comment ) {

	                $image_post_ids = get_comment_meta( $comment->comment_ID, 'reviews-images', true );

	                if (is_array($image_post_ids) || is_object($image_post_ids)) {
	                    foreach ( $image_post_ids as $image_post_id ) {
	                        if ( ! wc_is_valid_url( $image_post_id ) ) {
	                            $image_data = wp_get_attachment_metadata( $image_post_id );
	                            $alt        = get_post_meta( $image_post_id, '_wp_attachment_image_alt', true );
	                            $image_alt  = $alt ? $alt : $product_title;

	                            $img_src = apply_filters( 'woocommerce_photo_reviews_thumbnail_photo', wp_get_attachment_thumb_url( $image_post_id ), $image_post_id, $comment );

	                            $img_src_open = apply_filters( 'woocommerce_photo_reviews_large_photo', wp_get_attachment_thumb_url( $image_post_id ), $image_post_id, $comment );

	                            $outputs .= '<li><a class="lightbox-gallery" href="'. $img_src_open .'"><img class="review-images"
	                                     src="' . $img_src .'" alt="'. apply_filters( 'woocommerce_photo_reviews_image_alt', $image_alt, $image_post_id, $comment ) .'"/></a></li>';
	                            $i++;
	                        }
	                    }
	                }
	            } 

	            $more = '';

	            if ($i > 6) {
	            	if ( ($product_single_layout === 'left-main') || ($product_single_layout === 'main-right') ) {
	            		$i      = $i - 6;
		            	$more   = '<li class="more d-none d-xl-flex">';
		                $more  .= '<span>'. $i .'+</span>';
		                $more  .= '</li>';
		            } elseif ($i > 8) {
		            	$i      = $i - 8;
		                $more   = '<li class="more d-none d-xl-flex">';
		                $more  .= '<span>'. $i .'+</span>';
		                $more  .= '</li>';
			        }
	            }

	            $outputs .= $more;

	            $outputs .= '</ul></div>';
	        }

	        if( $i === 0 ) {
	            return;
	        }

	        echo trim($outputs);
		}

		public function share_box_html() {
			if( !kera_tbay_get_config('enable_code_share',false) || !kera_tbay_get_config('enable_product_social_share', false) ) return;

	        
	  		if( kera_tbay_get_config('select_share_type') == 'custom' ) {
				$image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				kera_custom_share_code( get_the_title(), get_permalink(), $image );
	  		} else {
	  			?>
	  			 <div class="tbay-woo-share">
	              	<div class="addthis_inline_share_toolbox"></div>
	            </div>
	  			<?php
	  		}

		}

		public function class_single_product( $styles ) {

			global $product;
	        $attachment_ids = $product->get_gallery_image_ids();
	        $count = count( $attachment_ids);

	        $sidebar_configs    = kera_tbay_get_woocommerce_layout_configs();
	        $images_layout      = $sidebar_configs['thumbnail'];

	        $styles = 'style-'.$images_layout;

	        $active_stick       = '';

	        if( isset($images_layout) ) {

	          if( isset($count) && $images_layout == 'stick' && ($count > 0) ) {
	            $active_stick = ' active-stick';
	          }
	       
	        }

	        $styles .= $active_stick;

	        $active = kera_tbay_get_config('enable_size_guide', false);

		    global $post;
		    $attachment_id = get_post_meta( $post->ID, '_product_size_guide_image', true );

		    if ( $active && metadata_exists( 'post', $post->ID, '_product_size_guide_image' ) && !empty($attachment_id) ) {

		    	$styles .= ' has-size-guide';
			}

	        return $styles;

		}

		public function get_tabs_style_product( $tabs_layout ) {
			if ( is_singular( 'product' ) ) {
	          $sidebar_configs  = kera_tbay_get_woocommerce_layout_configs();
	          $tabs_style       = kera_tbay_get_config('style_single_tabs_style', 'tabs');

	          if ( isset($_GET['tabs_product']) ) {
	              $tabs_layout = $_GET['tabs_product'];
	          } else { 
	              $tabs_layout = $tabs_style;
	          }  

	          return $tabs_layout;
	        }
		}

		public function the_product_single_time_countdown() {
	   		global $product;

	        $style_countdown   = kera_tbay_get_config('enable_product_countdown',false);

	        if ( isset($_GET['countdown']) ) {
	            $countdown = $_GET['countdown'];
	        }else {
	            $countdown = $style_countdown;
	        }  

	        if(!$countdown || !$product->is_on_sale() ) {
	          return '';
	        }


	        wp_enqueue_script( 'jquery-countdowntimer' );
	        $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
	        $_id = kera_tbay_random_key();
			$day        = apply_filters( 'urna_single_time_countdown_day', esc_html__('d', 'kera') );
			$hours      = apply_filters( 'urna_single_time_countdown_hour', esc_html__('h', 'kera') );
			$mins       = apply_filters( 'urna_single_time_countdown_mins', esc_html__('m', 'kera') );
			$secs       = apply_filters( 'urna_single_time_countdown_secs', esc_html__('s', 'kera') );

	        ?>
	        <?php if ( $time_sale ): ?>
	            <div class="tbay-time-wrapper">
	              <div class="time tbay-time">
	                  <div class="title"><?php esc_html_e('Ends in: ','kera'); ?></div>
	                  <div class="tbay-countdown" data-id="<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" id="countdown-<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" data-countdown="countdown" data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>" data-days="<?php echo esc_attr($day); ?>" data-hours="<?php echo esc_attr( $hours ); ?>" data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr( $secs ); ?>">
	                  </div>
	              </div> 


	              <?php if($product->get_manage_stock()) {?>
	                <div class="stock">
	                  <?php
	                    $total_sales    = $product->get_total_sales();
	                    $stock_quantity   = $product->get_stock_quantity();

	                    if($stock_quantity > 0) {
	                      $total_quantity   = (int)$total_sales + (int)$stock_quantity;
	                      $sold         = (int)$total_sales / (int)$total_quantity;
	                      $percentsold    = $sold*100;
	                    }
	                  ?>
	                  <?php if($stock_quantity > 0) { ?>
	                    <span class="tb-sold"><?php esc_html_e('Sold', 'kera'); ?> : <span class="sold"><?php echo esc_html($total_sales) ?>/<?php echo esc_html($total_quantity) ?></span></span>
	                  <?php } else { ?>
	                    <span class="tb-sold"><?php esc_html_e('Sold out', 'kera'); ?></span>
	                  <?php } ?>

	                  <?php if( isset($percentsold) ) { ?>
	                    <div class="progress">
	                      <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
	                      </div>
	                    </div>
	                  <?php } ?>
	                </div>
	              <?php } ?>

	            </div> 
	        <?php endif; ?> 
	        <?php
		}

		public function render_product_nav( $post, $position ) {
			if($post){
	          $product = wc_get_product($post->ID);
	          $img = '';
	          if(has_post_thumbnail($post)){
	              $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
	          }
	          $link = get_permalink($post);

	          $left_content = ($position == 'left') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';
	          $right_content = ($position == 'right') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';
	          echo "<div class='". esc_attr( $position ) ." psnav'>";

	          echo trim($left_content); 
	          echo "<div class='product_single_nav_inner single_nav'>
	                    <a href=". esc_url($link) .">
	                        <span class='name-pr'>". esc_html($post->post_title) ."</span>
	                    </a>
	                </div>";    
	            echo trim($right_content);   
	          echo "</div>";
	      	}
		}

		public function the_product_nav_image() {

			if( !kera_tbay_get_config('show_product_nav', false) ) return;


	          $prev = get_previous_post();
	          $next = get_next_post();

	          echo '<div class="product-nav pull-right">';   
	          echo '<div class="link-images visible-lg">';
	          $this->render_product_nav($prev, 'left');
	          $this->render_product_nav($next, 'right');
	          echo '</div>';

	          echo '</div>';
		}

		public function render_product_nav_icon($post, $position) {
			if($post){
	          $product = wc_get_product($post->ID);
	          $output = '';
	          $img = '';
	          if(has_post_thumbnail($post)){
	              $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
	          }
	          $link = get_permalink($post);

	          $output .= "<div class='". esc_attr( $position ) ."-icon icon-wrapper'>";
	            $output .= "<div class='text'>";

	                $output .= ($position == 'left') ? "<a class='img-link left' href=". esc_url($link) ."><span class='product-btn-icon'></span>". esc_html__('Prev', 'kera') . "</a>" :'';                  

	                $output .= ($position == 'right') ? "<a class='img-link right' href=". esc_url($link) .">". esc_html__('Next', 'kera') . "<span class='product-btn-icon'></span></a>" :'';  


	            $output .= "</div>";
	            $output .= "<div class='image psnav'>";
	            $output .= ($position == 'left') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';  
	            $output .= "<div class='product_single_nav_inner single_nav product'>
	                        <a href=". esc_url($link) .">
	                            <span class='name-pr'>". esc_html($post->post_title) ."</span>
	                            <span class='price'>" . $product->get_price_html() . "</span>
	                        </a>
	                    </div>";
	            $output .= ($position == 'right') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';   
	            $output .= "</div>";
	          $output .= "</div>";

	          return $output;
	      }
		}

		public function the_sticky_menu_bar() {
			global $post, $product;

		      $menu_bar   =  kera_get_product_menu_bar();

		      if(  !$menu_bar ) return;



		      $img = '';
		      if(has_post_thumbnail($post)){
		          $img = get_the_post_thumbnail($post, array(50, 50));
		      }

		      ?>

		      <div id="sticky-menu-bar">
		        <div class="container">
		          <div class="row">
		            <div class="menu-bar-left col-lg-7">
		                <div class="media">
		                  <div class="media-left media-top pull-left">
		                    <?php echo trim($img); ?>
		                  </div>
		                  <div class="media-body">
		                    <?php 
		                      do_action( 'kera_sticky_menu_bar_product_summary' );
		                    ?>
		                  </div>
		                </div>
		            </div>
		            <div class="menu-bar-right product col-lg-5">
		                <?php 
		                  do_action( 'kera_sticky_menu_bar_product_price_cart');
		                ?>
		            </div>
		          </div>
		        </div>
		      </div>

		      <?php
		}

		public function the_product_single_one_page() {
			$menu_bar   =  apply_filters( 'woo_product_menu_bar', 10, 2 );

	        if( isset($menu_bar) && $menu_bar ) {
	          global $product;
	          $id = $product->get_id();
	          wp_enqueue_script( 'jquery-nav' );
	          ?>
	          <?php
	          
	        }
		}

		public function the_sticky_menu_bar_custom_add_to_cart() {
			global $product; 

		    if( !$product->is_in_stock() ) {
		      echo wc_get_stock_html( $product );
		    } else {
		      ?> 
		        <a id="sticky-custom-add-to-cart" href="javascript:void(0);"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></a>
		    <?php 
		  }
		}

		public function body_class_single_one_page( $classes ) {
			$menu_bar   =  apply_filters( 'woo_product_menu_bar', 10, 2 );

		    if( isset($menu_bar) && $menu_bar && is_product() ) {
		      $classes[] = 'tbay-body-menu-bar';
		    }
		    return $classes;
		}		

		public function body_class_gallery_lightbox( $classes ) {

		    if( current_theme_supports( 'wc-product-gallery-lightbox' ) && is_product() ) {
		      $classes[] = 'tbay-wc-gallery-lightbox';
		    }

		    return $classes;
		}

		public function before_add_to_cart_form() {

			global $product;
	      	$id = $product->get_id();

	      	$class = 'shop-now';

	      	if( intval( kera_tbay_get_config('enable_buy_now', false) ) && $product->get_type() !== 'external' ) {
	      		$class .= ' has-buy-now';
	      	}

	      	if( class_exists('YITH_WCWL') ) {
	      		$class .= ' has-wishlist';
	      	}
	      ?> 

	      <div id="shop-now" class="<?php echo esc_attr($class); ?>">

	      <?php

		}

		public function close_after_add_to_cart_form() {
			echo '</div>';
		}

		public function get_related_products_args( $args ) {
		    $args['posts_per_page'] = kera_tbay_get_config('number_product_releated', 4); // 4 related products

		    return $args;
		}

		public function get_featured_image_id( $product, $video_id, $host ) {

			$thumbnail_id = $product->get_meta( '_kera_video_image_url' );
			return $thumbnail_id;
		}

		/**
		 * @param WC_Product $product
		 */
		public function get_featured_video_args( $product ) {

			$video_url  = $product->get_meta( '_kera_video_url' );
			$video_args = array();

			if ( ! empty( $video_url ) ) {

				list( $host, $video_id ) = explode( ':', kera_video_type_by_url( $video_url ) );

				$video_args = array(
					'video_id'      => $video_id,
					'host'          => $host,
					'thumbnail_id' => $this->get_featured_image_id( $product, $video_id, $host )
				);
			}

			return $video_args;
		}

		public function get_video_audio_content_last( ) {
			if( kera_tbay_get_config('video_position', 'last') === 'first' ) return;

			$html = $this->get_video_audio_content();

			echo trim($html);
		}

		public function get_video_audio_content_first( $html, $post_thumbnail_id ) {
			global $product;

			if ( 0 == $this->counter && $post_thumbnail_id == $product->get_image_id() && kera_tbay_get_config('video_position', 'last') === 'first' ) {
				$html .= $this->get_video_audio_content();
			}
			
			return $html;
		}

		public function get_video_audio_content() {
			global $product;

			$video_args = $this->get_featured_video_args( $product );

			if (empty(array_filter($video_args))) return '';

			$html = '';
			if ( ! empty( $video_args ) ) {
				ob_start();
				wc_get_template( 'single-product/template_video.php', $video_args);
				$html = ob_get_contents();
				ob_end_clean();
				$this->counter ++;
			}

			return $html;
		}

		public function product_size_guide_hook() {
			$active = kera_tbay_get_config('enable_size_guide', false);

		    global $post;

		    if ( !$active || !metadata_exists( 'post', $post->ID, '_product_size_guide_image' ) )  return;

		    $attachment_id = get_post_meta( $post->ID, '_product_size_guide_image', true );
		    if( empty($attachment_id) )  return;

		    add_filter( 'woocommerce_reset_variations_link', array( $this, 'the_product_size_guide'), 25 );
		    add_filter( 'woocommerce_before_single_variation', array( $this, 'the_product_size_guide_content'), 25 );
		}

		public function the_product_size_guide() {
			$active = kera_tbay_get_config('enable_size_guide', false);
		    $icon = kera_tbay_get_config('size_guide_icon', '');

		    global $post;

		    if ( !$active || !metadata_exists( 'post', $post->ID, '_product_size_guide_image' ) )  return;

		      $attachment_id = get_post_meta( $post->ID, '_product_size_guide_image', true );

		      $title = kera_tbay_get_config('size_guide_title', false);

		      $image = wp_get_attachment_image( $attachment_id, 'full' );
		    ?> 

		    <button type="button" class="btn-size-guide" data-toggle="modal" data-target="#product-size-guide">
		        <?php 
		          if( !empty($icon) ) {
		            echo '<i class="'. esc_attr($icon) .'"></i>';
		          }
				?>
				<?php echo trim($title); ?>
		      
		    </button>
		    <div class="reset-button">
		    	<a class="reset_variations" href="#"><?php esc_html_e( 'Clear all', 'kera' ) ?></a>
			</div>
		    <?php
		}

		public function the_product_size_guide_content() {
			$active = kera_tbay_get_config('enable_size_guide', false);
		    $icon = kera_tbay_get_config('size_guide_icon', '');

		    global $post;

		    if ( !$active || !metadata_exists( 'post', $post->ID, '_product_size_guide_image' ) )  return;

		      $attachment_id = get_post_meta( $post->ID, '_product_size_guide_image', true );

		      if( empty($attachment_id) ) return;

		      $title = kera_tbay_get_config('size_guide_title', false);

		      $image = wp_get_attachment_image( $attachment_id, 'full' );
		    ?> 



		    <!-- Modal -->
		    <div id="product-size-guide" class="modal fade" role="dialog">
		      <div class="modal-dialog">

		        <!-- Modal content-->
		        <div class="modal-content">
		          <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
		            <h4 class="modal-title"><?php echo trim($title); ?></h4>
		          </div>
		          <div class="modal-body">
		            <?php echo trim($image); ?>
		          </div>
		        </div>

		      </div>
		    </div>
		    <?php
		}

		public function remove_review_tab( $tabs ) {
	 		if ( !kera_tbay_get_config('enable_product_review_tab', true) && isset($tabs['reviews']) ) {
	            unset( $tabs['reviews'] ); 
	        }
	        return $tabs;
		}


		public function enable_zoom_image() {
	     	$active = kera_tbay_get_config('enable_zoom_image', true);

	        if ( isset($_GET['enable_zoom_image']) ) {
	          $active = $_GET['enable_zoom_image'];
	        }

	        return $active;
		}

		public function remove_support_zoom_image() {
			$active = $this->enable_zoom_image();

		    if( !$active ) {
		      wp_dequeue_script( 'zoom' );
		    }
		}


		public function html_before_add_to_cart_button() {
			$content = kera_tbay_get_config('html_before_add_to_cart_btn');
     		echo trim($content);
		}

		public function html_after_add_to_cart_button() {
			$content = kera_tbay_get_config('html_after_add_to_cart_btn');
	      	echo trim($content); 
		}

		public function the_total_sales_count() {
		 	global $product;

		    if( !intval( kera_tbay_get_config('enable_total_sales', true) ) || $product->get_type() == 'external' ) return;

		    $count = (float) get_post_meta($product->get_id(),'total_sales', true); 

		    $text = sprintf( '<div class="rate-sold"><span class="sold-text">%s</span><span class="count">%s</span></div>',
		    	esc_html__('Sold: ', 'kera'),
		        number_format_i18n($count)
		    );

		    echo trim($text);
		}

		public function get_photo_reviews_thumbnail_size($image_src, $image_post_id) {
			$img_src     = wp_get_attachment_image_src($image_post_id, 'tbay_photo_reviews_thumbnail_image');

			return $img_src[0];
		}

		public function get_photo_reviews_large_size($image_src, $image_post_id) {
			$img_src     = wp_get_attachment_image_src($image_post_id, 'full');

			return $img_src[0];
		}

		public function photo_reviews_reduce_array( $reduce ) {
			array_push($reduce,'tbay_photo_reviews_thumbnail_image');
			return $reduce;
		}

	}
endif;

if ( !function_exists('kera_single_wooCommerce') ) {
	function kera_single_wooCommerce() { 
		return Kera_Single_WooCommerce::getInstance();
	}
	kera_single_wooCommerce();
}