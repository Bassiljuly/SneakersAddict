<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Kera_Elementor_Currency') ) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;

class Kera_Elementor_Currency extends Kera_Elementor_Widget_Base {

    public function get_name() {
        return 'tbay-currency';
    }

    public function get_title() {
        return esc_html__('Kera Currency', 'kera');
    }

    public function get_icon() {
        return 'eicon-database';
    }

    protected function get_html_wrapper_class() {
		return 'w-auto elementor-widget-' . $this->get_name();
	}

    protected function register_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Currency Settings', 'kera'),
            ]
        );

        $this->add_control(
            'txt_type',
            [
                'label'              => esc_html__('Choose Type Text', 'kera'),
                'type'               => Controls_Manager::SELECT,
                'options' => [
                    'desc' => esc_html__('Desc','kera'),
                    'code' => esc_html__('Code','kera')
                ],
                'default' => 'desc'
            ]
        );
        $this->add_control(
            'position_currency',
            [
                'label'     => esc_html__('Position Dropdown', 'kera'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'top',
                'options'   => [
                    'top' => esc_html__('Top','kera'),
                    'bottom' => esc_html__('Bottom','kera'),
                ],
                'prefix_class' => 'currency-position-dropdown-',
            ]
        );
        $this->add_control(
            'show_flags',
            [
                'label'              => esc_html__('Show Flags', 'kera'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'position_flags',
            [
                'label'              => esc_html__('Position Flags', 'kera'),
                'type'               => Controls_Manager::SELECT,
                'options' => [
                    'left'  => esc_html__('Left','kera'),
                    'right'  => esc_html__('Right','kera')
                ],
                'default' => 'left',
                'condition' => [
                    'show_flags' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'text_currency_size',
            [
                'label' => esc_html__('Font Size', 'kera'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span,
                    {{WRAPPER}}.SumoSelect > .optWrapper > .options li.opt label,
                    {{WRAPPER}} .SumoSelect>.CaptionCont' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_language_line_height',
            [
                'label' => esc_html__('Line Height', 'kera'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
                    '.tbay-currency' => 'line-height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        
        $this->add_control(
            'color_text_currency',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_color_text_currency',
            [
                'label'     => esc_html__('Hover Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    
                    '{{WRAPPER}} .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover,
                    {{WRAPPER}} .woocommerce-currency-switcher-form .SumoSelect:hover > .CaptionCont,
                    {{WRAPPER}} .SumoSelect > .optWrapper > .options li.opt.selected,
                    {{WRAPPER}} .SumoSelect > .optWrapper > .options li.opt:hover,
                    {{WRAPPER}} .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after,
                    {{WRAPPER}} .woocommerce-currency-switcher-form .SumoSelect:hover label i:after,
                    {{WRAPPER}} .SumoSelect > .optWrapper > .options li.opt:focus'    => 'color: {{VALUE}}',
                ],
            ]
        );
    
        $this->end_controls_section();
    }
    public function get_script_depends() {
        return ['jquery-sumoselect'];
    }
    protected function kera_currency() {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if($show_flags === 'yes') {
            $check_flags = 1;
        }else {
            $check_flags = 0;
        }
        $this->add_render_attribute(
            'woocs',
            [
                'show_flags'    => $check_flags,
                'txt_type'      => $txt_type ,
                'flag_position' => $position_flags
            ]
        );

        $woocs = $this->get_render_attribute_string( 'woocs' );

        if( class_exists('WooCommerce') && class_exists( 'WOOCS' ) ) {
            wp_enqueue_style('sumoselect');
            ?>
            <div class="tbay-currency">
            <?php
                echo do_shortcode( "[woocs $woocs ]" );
            ?>
            </div>
            <?php
        }
    }
}
$widgets_manager->register_widget_type(new Kera_Elementor_Currency());

