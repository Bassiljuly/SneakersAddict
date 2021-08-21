<?php 

$header 	= apply_filters( 'kera_tbay_get_header_layout', 'header_default' );

$class_header = kera_header_located_on_slider();

?>

<header id="tbay-header" class="tbay_header-template site-header <?php echo esc_attr($class_header) ?>">

	<?php if ( $header != 'header_default' ) : ?>	

		<?php kera_tbay_display_header_builder(); ?> 

	<?php else : ?>
	
	<?php get_template_part( 'page-templates/header-default' ); ?>

	<?php endif; ?>
	<div id="nav-cover"></div>
	<div class="bg-close-canvas-menu"></div>
</header>