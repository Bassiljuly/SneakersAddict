<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Kera_Elementor_Mini_Cart') ) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
class Kera_Elementor_Mini_Cart extends Kera_Elementor_Widget_Base {

    protected $nav_menu_index = 1;

    public function get_name() {
        return 'tbay-mini-cart';
    }

    public function get_title() {
        return esc_html__('Kera Mini Cart', 'kera');
    }

    public function get_icon() {
        return 'eicon-cart-medium';
    }
    
    protected function get_html_wrapper_class() {
		return 'w-auto elementor-widget-' . $this->get_name();
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Mini Cart', 'kera'),
            ]
        );

        $this->add_control(
            'heading_mini_cart',
            [
                'label' => esc_html__('Mini Cart', 'kera'),
                'type' => Controls_Manager::HEADING,
            ]
        );   

        $this->add_control(
            'icon_mini_cart',
            [
                'label'              => esc_html__('Icon', 'kera'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon- icon-handbag',
					'library' => 'Material-Design-Iconic-Font',
                ],                
            ]
        );
        
        $this->add_control(
            'show_title_mini_cart',
            [
                'label'              => esc_html__('Display Title "Mini-Cart"', 'kera'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => ''        
            ]
        );
        $this->add_control(
            'title_mini_cart',
            [
                'label'              => esc_html__('"Mini-Cart" Title', 'kera'),
                'type'               => Controls_Manager::TEXT,
                'default'            => esc_html__('Shopping cart', 'kera'),
                'condition'          => [
                    'show_title_mini_cart' => 'yes'
                ]
            ]
        );

        
        $this->add_control(
            'price_mini_cart',
            [
                'label'              => esc_html__('Show "Mini-Cart" Price', 'kera'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => '',
                'separator'    => 'after',
            ]
        );


        $this->end_controls_section();
        $this->register_section_style_icon();
        $this->register_section_style_text();
        $this->register_section_style_total();
        $this->register_section_style_popup_cart();

    }


    protected function register_section_style_icon() {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Icon', 'kera'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs('tabs_style_icon');
        $this->add_control(
            'icon_mini_cart_size',
            [
                'label' => esc_html__('Font Size Icon', 'kera'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .cart-dropdown .cart-icon i,
                    {{WRAPPER}} .cart-dropdown .cart-icon svg' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__('Normal', 'kera'),
            ]
        );
        $this->add_control(
            'color_icon',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-dropdown .cart-icon'     => 'color: {{VALUE}}',
                    '{{WRAPPER}} .cart-dropdown svg'            => 'fill: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-dropdown .cart-icon,
                    {{WRAPPER}} .cart-dropdown svg'    => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__('Hover', 'kera'),
            ]
        );
        $this->add_control(
            'hover_color_icon',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-dropdown .cart-icon:hover'       => 'color: {{VALUE}}',
                    '{{WRAPPER}} .cart-dropdown svg:hover'              => 'fill: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-dropdown .cart-icon:hover,
                    {{WRAPPER}} .cart-dropdown svg:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_section_style_text() {

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Style Text', 'kera'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title_mini_cart' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'margin_text_cart',
            [
                'label'     => esc_html__('Margin Text Cart', 'kera'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .cart-dropdown .text-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );  
        $this->start_controls_tabs('tabs_style_text');

        $this->start_controls_tab(
            'tab_text_normal',
            [
                'label' => esc_html__('Normal', 'kera'),
            ]
        );
        $this->add_control(
            'color_text',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-dropdown .text-cart'    => 'color: {{VALUE}}',
                ],
            ]
        );   

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            [
                'label' => esc_html__('Hover', 'kera'),
            ]
        );
        $this->add_control(
            'hover_color_text',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-dropdown .text-cart:hover' => 'color: {{VALUE}}',
                ],
            ]
        );   
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_section_style_popup_cart() {

        $this->start_controls_section(
            'section_style_popup_cart',
            [
                'label' => esc_html__('Style Popup', 'kera'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'position_popup',
            [
                'label'     => esc_html__('Position Popup', 'kera'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
                ],
                'default' => [
                    'unit' => 'px',
					'size' => 78
                ],
                'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .cart-dropdown .dropdown-menu' => 'top: {{SIZE}}{{UNIT}} !important;',
                ],
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_popup',
				'selector' => '{{WRAPPER}} .woocommerce .cart-popup.show .dropdown-menu, .cart-popup.show .dropdown-menu',
			]
		);
        $this->add_control(
            'color_close_popup',
			[
                'label'     => esc_html__('Color Close Popup', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-topcart .offcanvas-close' => 'color: {{VALUE}}',
                ],
            ]
		);
        
       
        $this->end_controls_section();
    }
    private function register_section_style_total() {
        $this->start_controls_section(
            'section_style_total',
            [
                'label' => esc_html__('Style Total', 'kera'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'number_size',
            [
                'label' => esc_html__('Font Size', 'kera'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 20,
					],
                ],
                'default' => [
                    'unit' => 'px',
					'size' => 14
                ],
                'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .cart-icon span.mini-cart-items' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'number_font-weight',
            [
                'label' => esc_html__('Font Weight', 'kera'),
                'type' => Controls_Manager::SELECT,
				'options' => [
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                ],
                'default' => '700',
				'selectors' => [
					'{{WRAPPER}} .cart-icon span.mini-cart-items' => 'font-weight: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'color_number',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-icon span.mini-cart-items'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .cart-icon span.mini-cart-items'    => 'color: {{VALUE}}',
                ],
            ]
        );   
        
        $this->add_control(
            'bg_total',
            [
                'label'     => esc_html__('Background', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-icon span.mini-cart-items'    => 'background: {{VALUE}}',
                    '{{WRAPPER}} .cart-icon span.mini-cart-items'    => 'background: {{VALUE}}',
                ],
            ]
        );   
        $this->end_controls_section();
    }

    protected function render_woocommerce_mini_cart() {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $icon_array = [];
        if( 'svg' === $icon_mini_cart['library'] ) {
            $icon_array['has_svg'] = true;
            $icon_array['svg'] = $this->get_item_icon_svg($icon_mini_cart);
        } else {
            $icon_array['iconClass'] = $icon_mini_cart['value'];
            $icon_array['has_svg'] = false;
        }

        $args = [
            'show_title_mini_cart'           => $show_title_mini_cart,
            'title_mini_cart'                => $title_mini_cart,
            'price_mini_cart'                => $price_mini_cart,
            'icon_array'                     => $icon_array,
        ];
        
        kera_tbay_get_woocommerce_mini_cart($args);
    }
}
$widgets_manager->register_widget_type(new Kera_Elementor_Mini_Cart());

