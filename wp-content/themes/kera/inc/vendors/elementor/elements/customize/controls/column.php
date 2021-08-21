<?php

if ( !function_exists('kera_column_section_advanced')) {
    function kera_column_section_advanced( $widget ) {

        $widget->update_responsive_control(
            'padding',
            [  
                'label' => esc_html__( 'Padding', 'kera' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} > div.elementor-element-populated' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

    }

    add_action( 'elementor/element/column/section_advanced/before_section_end', 'kera_column_section_advanced', 10, 2 );
}

