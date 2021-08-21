<?php 
/**
 * Templates Name: Elementor
 * Widget: Product Categories Tabs
 */

extract( $settings );

if( empty($categories) ) return;

$this->settings_layout();

 
$_id = kera_tbay_random_key();

if( $ajax_tabs === 'yes' ) {
    $this->add_render_attribute('wrapper', 'class', 'ajax-active'); 
}
?> 

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php 
        $this->render_tabs_title($categories,$_id,$settings);
        $this->render_product_tabs_content($categories, $_id);
    ?>
</div>