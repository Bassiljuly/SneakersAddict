<?php
if ( ! defined( 'ABSPATH' ) || !class_exists('WooCommerce') ) {
	exit;
}

if ( ! class_exists( 'Kera_Cart' ) ) :


	class Kera_Cart  {

		static $instance;

		/**
		 * @return osf_WooCommerce
		 */
		public static function getInstance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Kera_Cart ) ) {
				self::$instance = new Kera_Cart();
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

			/*Cart modal*/
			add_action( 'wp_ajax_kera_add_to_cart_product', array( $this, 'woocommerce_cart_modal'), 10 );
			add_action( 'wp_ajax_nopriv_kera_add_to_cart_product', array( $this, 'woocommerce_cart_modal'), 10 );
			add_action( 'wp_footer', array( $this, 'add_to_cart_modal_html'), 20 );


			/*cart fragments*/
			add_filter('woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments'), 10, 1 );
			add_filter('woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments_mobile'), 20, 1 );

			add_filter( 'kera_cart_position', array( $this, 'woocommerce_cart_position'), 10 ,1 );  

			add_filter( 'body_class', array( $this, 'body_classes_cart_postion' ), 40, 1 );

			/*Mobile add to cart message html*/
			add_filter( 'wc_add_to_cart_message_html', array( $this, 'add_to_cart_message_html_mobile'), 10, 1 );

			/*Show Add to Cart on mobile*/
			add_filter( 'kera_show_cart_mobile', array( $this, 'show_cart_mobile'), 10, 1 );
			add_filter( 'body_class', array( $this, 'body_classes_show_cart_mobile'), 10, 1 );


			add_action( 'wp_ajax_product_remove', array( $this, 'ajax_product_remove'), 10 );
			add_action( 'wp_ajax_nopriv_product_remove', array( $this, 'ajax_product_remove'), 10 );
		}

		public function add_to_cart_modal_html() {
			if( is_account_page() || is_checkout() || ( function_exists('is_vendor_dashboard') && is_vendor_dashboard() ) ) return;        
		    ?>
		    <div id="tbay-cart-modal" tabindex="-1" role="dialog" aria-hidden="true">
		        <div class="modal-dialog modal-lg">
		            <div class="modal-content">
		                <div class="modal-body">
		                    <div class="modal-body-content"></div>
		                </div>
		            </div>
				</div>
				<div id="tbay-cart-modal-close"></div>
		    </div>
		    <?php    
		}


		public function woocommerce_cart_modal() {
			wc_get_template( 'content-product-cart-modal.php' , array( 'product_id' => (int)$_GET['product_id'], 'product_qty' => (int)$_GET['product_qty'] ) ); 
			die;
		}

		public function woocommerce_cart_position() {
			if( wp_is_mobile() ) { 
	            return 'right'; 
	        }

	        $position_array = array("popup", "left", "right", "no-popup");

	        $position = kera_tbay_get_config('woo_mini_cart_position', 'popup');

	        $position = ( isset($_GET['ajax_cart']) ) ? $_GET['ajax_cart'] : $position;

	        $position =  (!in_array($position, $position_array)) ? kera_tbay_get_config('woo_mini_cart_position', 'popup') : $position;

	        return $position;
		}


		public function body_classes_cart_postion( $classes ) {
			$position = apply_filters( 'kera_cart_position', 10,2 ); 

	        $class = ( isset($_GET['ajax_cart']) ) ? 'ajax_cart_'.$_GET['ajax_cart'] : 'ajax_cart_'.$position;

	        $classes[] = trim($class);

	        return $classes;
		}

		public function add_to_cart_fragments_mobile($fragments) {

			ob_start();
		    ?>

		    <span class="mini-cart-items cart-mobile">
		        <?php echo sprintf( '%d', WC()->cart->cart_contents_count );?>
		    </span>

		    <?php $fragments['span.cart-mobile'] = ob_get_clean();

		    return $fragments;
		}

		public function add_to_cart_fragments( $fragments ) {
	        $fragments['.mini-cart .mini-cart-items'] =  sprintf(_n(' <span class="mini-cart-items"> %d  </span> ', ' <span class="mini-cart-items"> %d </span> ', WC()->cart->get_cart_contents_count(), 'kera'), WC()->cart->get_cart_contents_count() );
	        $fragments['.mini-cart .mini-cart-total'] = trim( WC()->cart->get_cart_subtotal() );
	        return $fragments;

		}

		public function add_to_cart_message_html_mobile( $message ) {
			if ( isset( $_REQUEST['kera_buy_now'] ) && $_REQUEST['kera_buy_now'] == true ) {
	            return __return_empty_string();
	        }

	        if ( wp_is_mobile() && ! intval( kera_tbay_get_config('enable_buy_now', false) ) ) {
	            return __return_empty_string();     
	        } else {
	            return $message;
	        }
		}

		public function show_cart_mobile() {
			$active = kera_tbay_get_config('enable_add_cart_mobile', false);

	        $active = (isset($_GET['add_cart_mobile'])) ? $_GET['add_cart_mobile'] : $active;

	        return $active;
		}

		public function body_classes_show_cart_mobile( $classes ) {
	 		$class = '';
	        $active = apply_filters( 'kera_show_cart_mobile', 10,2 );
	        if( isset($active) && $active ) {  
	            $class = 'tbay-show-cart-mobile';
	        }

	        $classes[] = trim($class);

	        return $classes;
		}

		public function ajax_product_remove() {

			// Get mini cart
	        ob_start();

	        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
	        {
	            if($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] )
	            {
	                WC()->cart->remove_cart_item($cart_item_key);
	            }
	        }

	        WC()->cart->calculate_totals();
	        WC()->cart->maybe_set_cart_cookies();

	        woocommerce_mini_cart();

	        $mini_cart = ob_get_clean();

	        // Fragments and mini cart are returned
	        $data = array(
	            'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
	                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
	                )
	            ),
	            'cart_hash' => apply_filters( 'woocommerce_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
	        );

	        wp_send_json( $data );

	        die();

		}

	}
endif;


if ( !function_exists('kera_cart') ) {
	function kera_cart() { 
		return Kera_Cart::getInstance();
	}
	kera_cart();
}