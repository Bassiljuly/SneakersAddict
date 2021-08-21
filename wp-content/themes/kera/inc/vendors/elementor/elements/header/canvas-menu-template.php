<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Kera_Elementor_Canvas_Menu_Template') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Kera_Elementor_Canvas_Menu_Template extends  Kera_Elementor_Widget_Base{
    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'tbay-canvas-menu-template';
    }
    protected function get_html_wrapper_class() {
		return 'w-auto elementor-widget-' . $this->get_name();
	}

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Kera Canvas Menu Template', 'kera' );
    }

 
    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-nav-menu';
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'General', 'kera' ),
            ]
        );
        $this->add_control(
            'icon_menu_canvas',
            [
                'label' => esc_html__( 'Choose Icon', 'kera' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'zmdi zmdi-sort-amount-desc',
					'library' => 'material-design-iconic',
                ],  
            ]
        );
        
        $templates = Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();

        if ( empty( $templates ) ) {

            $this->add_control(
                'no_templates',
                [
                    'label' => false,
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div id="elementor-widget-template-empty-templates">
				<div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd"></i></div>
				<div class="elementor-widget-template-empty-templates-title">' . esc_html__( 'You Haven’t Saved Templates Yet.', 'kera' ) . '</div>
				<div class="elementor-widget-template-empty-templates-footer">' . esc_html__( 'Want to learn more about Elementor library?', 'kera' ) . ' <a class="elementor-widget-template-empty-templates-footer-url" href="//go.elementor.com/docs-library/" target="_blank">' . esc_html__( 'Click Here', 'kera' ) . '</a>
				</div>
				</div>',
                ]
            );

            return;
        }

        $options = [
            '0' => '— ' . esc_html__( 'Select', 'kera' ) . ' —',
        ];

        $types = [];

        foreach ( $templates as $template ) {
            $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }
        
        $this->add_control(
            'ajax_menu_template',
            [
                'label' => esc_html__( 'Ajax Canvas Menu Template', 'kera' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'Show/hidden Canvas Menu Template', 'kera' ), 
            ]
        );

        $this->add_control(
            'template_id',
            [
                'label' => esc_html__( 'Choose Template', 'kera' ),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $options,
                'types' => $types,
                'label_block'  => 'true',
            ]
        );
        
        $this->add_responsive_control(
            'canvas_menu_align',
            [
                'label' => esc_html__('Align','kera'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left','kera'),
                        'icon' => 'fas fa-align-left'
                    ],
                    'right' => [
                        'title' => esc_html__('Right','kera'),
                        'icon' => 'fas fa-align-right'
                    ],   
                ],
                'default' => '',
                'prefix_class' => 'menu-canvas-',
            ]
        );

        $this->end_controls_section();
        $this->register_style_canvas_menu();
    }
    public function register_style_canvas_menu() {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('General', 'kera'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_menu_size',
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
                    '{{WRAPPER}} .btn-canvas-menu > i,
                    {{WRAPPER}} .btn-canvas-menu > svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'color_icon_menu',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-canvas-menu > i'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-canvas-menu > svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'hover_color_icon_menu',
            [
                'label'     => esc_html__('Color Hover', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-canvas-menu > i:hover'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-canvas-menu > svg:hover'    => 'fill: {{VALUE}}',
                ],
            ]
        );   

        $this->add_control(
            'bg_icon_menu',
            [
                'label'     => esc_html__('Background Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-canvas-menu > i,
                    {{WRAPPER}} .btn-canvas-menu > svg'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
       
        $this->add_control(
            'hover_bg_icon_menu',
            [
                'label'     => esc_html__('Background Hover', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-canvas-menu > i:hover,
                    {{WRAPPER}} .btn-canvas-menu > svg:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    public function render_content_template($ajax_menu_template) {
        $template_id = $this->get_settings( 'template_id' );
        ?>
        <div class="canvas-menu-content" >
            <a href="javascript:void(0);" class="close-canvas-menu"><i class="zmdi zmdi-close"></i></a>
            <div class="content-canvas-menu">
            <?php
            if ( $ajax_menu_template !== 'yes' ) {
                ?>
                    <?php
                        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id, kera_get_elementor_css_print_method() );
                    ?>
                <?php
                
            }
        echo "</div></div>";
            
    }
    public function render_canvas_menu() {
        $settings = $this->get_settings_for_display();
        extract($settings);
        ?>
        <div class="canvas-menu-sidebar">
            <a href="javascript:void(0);" data-id="<?php echo trim($template_id); ?>" class="btn-canvas-menu menu-click"> 
                <?php $this->render_item_icon($icon_menu_canvas); ?>
            </a>
            <?php $this->render_content_template($ajax_menu_template); ?>
        </div>

    <?php }
}
$widgets_manager->register_widget_type(new Kera_Elementor_Canvas_Menu_Template());
