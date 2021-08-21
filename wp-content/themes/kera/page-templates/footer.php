<?php

$footer 	= apply_filters( 'kera_tbay_get_footer_layout', 'footer_default' );

?>

	</div><!-- .site-content -->
	<?php if ( kera_tbay_active_newsletter_sidebar() ) : ?>
		<div id="newsletter-popup" class="newsletter-popup">
			<?php dynamic_sidebar( 'newsletter-popup' ); ?>
		</div>
	<?php endif; ?>
	
	<footer id="tbay-footer" class="tbay-footer <?php echo (!empty($footer)) ? esc_attr($footer) : ''; ?>">
		<?php if ( $footer != 'footer_default' ): ?>
			
			<?php kera_tbay_display_footer_builder($footer); ?>

		<?php else: ?> 
			
			<?php get_template_part( 'page-templates/footer-default' ); ?>
			
		<?php endif; ?>			
	</footer><!-- .site-footer -->
	
	<?php 

	$_id = kera_tbay_random_key();

	?>

	<?php
	if ( kera_tbay_get_config('back_to_top') ) { ?>
		<div class="tbay-to-top">
			<a href="javascript:void(0);" id="back-to-top">
				<i class="icon-arrow-up"></i>
			</a>
		</div>
	<?php
	}
	?>

	<?php
	if ( kera_tbay_get_config('mobile_back_to_top') ) { ?>
		<div class="tbay-to-top-mobile tbay-to-top">

			<div class="more-to-top">
			
				<a href="javascript:void(0);" id="back-to-top-mobile">
					<i class="icon-arrow-up"></i>
				</a>
				
			</div>
		</div>
		
		
	<?php
	}
	?>
	
	

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>