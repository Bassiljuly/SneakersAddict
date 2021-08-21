<?php 		
if( !kera_is_elementor_activated() ) return;

$show_categories 		= kera_tbay_get_config('mobile_show_categories', false);
if( !$show_categories ) return;
$template_id 		    = kera_tbay_get_config('mobile_select_categories');

if( empty($template_id) ) return;
?>
<div id="categories-device-content" class="modal fade device-modal-dialog" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			 <div class="modal-body">
				<div class="content-template">
				    <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id, kera_get_elementor_css_print_method() ); ?>
				</div>
			</div>
		</div>
	</div>
</div>