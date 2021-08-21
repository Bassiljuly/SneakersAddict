<?php

if ( class_exists( 'CMB2', false ) ) {
    return;
}

define( 'KERA_CMB2_ACTIVED', true );

if ( !function_exists( 'kera_tbay_page_metaboxes' ) ) {
	function kera_tbay_page_metaboxes(array $metaboxes) {
		global $wp_registered_sidebars;
        $sidebars = array();

        if ( !empty($wp_registered_sidebars) ) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }

        $footers = array_merge( array('global' => esc_html__( 'Global Setting', 'kera' )), kera_tbay_get_footer_layouts() );
        $headers = array_merge( array('global' => esc_html__( 'Global Setting', 'kera' )), kera_tbay_get_header_layouts() );


		$prefix = 'tbay_page_';
	    $fields = array(
			array(
				'name' => esc_html__( 'Select Layout', 'kera' ),
				'id'   => $prefix.'layout',
				'type' => 'select',
				'options' => array(
					'main' => esc_html__('Main Content Only', 'kera'),
					'left-main' => esc_html__('Left Sidebar - Main Content', 'kera'),
					'main-right' => esc_html__('Main Content - Right Sidebar', 'kera'),
				)
			),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'kera'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'kera'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'kera'),
                'options' => array(
                    'no' => esc_html__('No', 'kera'),
                    'yes' => esc_html__('Yes', 'kera')
                ),
                'default' => 'yes',
            ),
            array(
                'name' => esc_html__( 'Select Breadcrumbs Layout', 'kera' ),
                'id'   => $prefix.'breadcrumbs_layout',
                'type' => 'select',
                'options' => array(
                    'image' => esc_html__('Background Image', 'kera'),
                    'color' => esc_html__('Background color', 'kera'),
                    'text' => esc_html__('Just text', 'kera')
                ),
                'default' => 'text',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'kera')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'kera')
            ),
    	);

        $after_array = array(
            array(
                'id' => $prefix.'header_type',
                'type' => 'select', 
                'name' => esc_html__('Header Layout Type', 'kera'),
                'description' => esc_html__('Choose a header for your website.', 'kera'),
                'options' => $headers,
                'default' => 'global'
            ),            
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'kera'),
                'description' => esc_html__('Choose a footer for your website.', 'kera'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'kera'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kera')
            )
        );
        $fields = array_merge($fields, $after_array); 
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'kera' ),
			'object_types'              => array( 'page' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'kera_tbay_page_metaboxes' ); 

if ( !function_exists( 'kera_tbay_cmb2_style' ) ) {
	function kera_tbay_cmb2_style() {
		wp_enqueue_style( 'kera-cmb2-style', KERA_THEME_DIR . '/inc/vendors/cmb2/assets/style.css', array(), '1.0' );
	}
}
add_action( 'admin_enqueue_scripts', 'kera_tbay_cmb2_style' );


