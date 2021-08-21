<?php 

	$show_login = kera_tbay_get_config('show_login', false);

	if( !$show_login ) return;

	$show_login_popup 	= kera_tbay_get_config('show_login_popup', true);
	

?>

<?php if( !(defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) ) : ?>

	<div class="tbay-login">

		<?php if (is_user_logged_in() ) { ?>
			<?php 
				$current_user 			= wp_get_current_user(); 

				$menu_after_login       =  kera_tbay_get_config('menu_after_login');
			?>
			<a class="account-button" href="javascript:void(0);"><i class="icon-user"></i><span class="hidden-xs"><?php esc_html_e('Hi, ','kera'); ?><?php echo esc_html( $current_user->display_name); ?>!</span></a>

			<?php if( isset($menu_after_login) && $menu_after_login ) : ?>
				<div class="account-menu sub-menu">
					<?php
					$args = array(
						'menu'    => $menu_after_login,
						'container_class' => '',
						'menu_class'      => 'menu-topbar'
					);
					wp_nav_menu($args);
					?>
				</div>
			<?php endif; ?>

		<?php } elseif( !(defined('KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && KERA_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('KERA_WOOCOMMERCE_ACTIVED') && KERA_WOOCOMMERCE_ACTIVED && !empty(get_option('woocommerce_myaccount_page_id')) ) { ?>  

				<?php 

					if( $show_login_popup ) {
						$url    = '#custom-login-wrapper';
						$target = " data-toggle=modal data-target=#custom-login-wrapper";
					} else {
						$url 	= get_permalink( get_option('woocommerce_myaccount_page_id') );
						$target = '';
					}
					

				?>

				<a <?php echo esc_attr( $target ); ?> href="<?php echo esc_url($url); ?>" title="<?php esc_attr_e('Login or Register','kera'); ?>"><i class="icon-user"></i><span><?php esc_html_e('Login or Register', 'kera'); ?></span></a>          	
		<?php } ?> 

	</div>
	
<?php endif; ?> 