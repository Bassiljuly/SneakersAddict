<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Kera_Elementor_Testimonials') ) {
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
class Kera_Elementor_Testimonials extends  Kera_Elementor_Carousel_Base{
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
        return 'tbay-testimonials';
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
        return esc_html__( 'Kera Testimonials', 'kera' );
    }

    public function get_script_depends() {
        return [ 'kera-custom-slick', 'slick' ];
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
        return 'eicon-testimonial';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'General', 'kera' ),
            ]
        );
 
        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'kera'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'kera'), 
                    'carousel'  => esc_html__('Carousel', 'kera'), 
                ],
            ]
        );   
        $this->add_control(
            'testimonials_align',
            [
                'label' => esc_html__('Align','kera'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left','kera'),
                        'icon' => 'fas fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center','kera'),
                        'icon' => 'fas fa-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right','kera'),
                        'icon' => 'fas fa-align-right'
                    ],   
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item .testimonials-body'  => 'text-align: {{VALUE}} !important',
                ]
            ]
        );  
        $this->add_responsive_control(
			'testimonial_padding',
			[
				'label' => esc_html__( 'Padding "Name"', 'kera' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        $this->add_responsive_control(
			'testimonial_margin_item',
			[
				'label' => esc_html__( 'Item Spacing', 'kera' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $repeater = $this->register_testimonials_repeater();

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__( 'Testimonials Items', 'kera' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_testimonial_default(),
                'testimonials_field' => '{{{ testimonials_image }}}',
            ]
        );    

        $this->end_controls_section();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
        $this->remove_control('rows');

    }

    private function register_testimonials_repeater() {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control (
            'testimonial_image', 
            [
                'label' => esc_html__( 'Choose Image', 'kera' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control (
            'testimonial_name', 
            [
                'label' => esc_html__( 'Name', 'kera' ),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control (
            'testimonial_job', 
            [
                'label' => esc_html__( 'Job', 'kera' ),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control (
            'testimonial_excerpt', 
            [
                'label' => esc_html__( 'Excerpt', 'kera' ),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        return $repeater;
    }

    private function register_set_testimonial_default() {
        $defaults = [
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__( 'Name 1', 'kera' ),
                'testimonial_job' => esc_html__( 'Job 1', 'kera' ),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'kera'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__( 'Name 2', 'kera' ),
                'testimonial_job' => esc_html__( 'Job 2', 'kera' ),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'kera'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__( 'Name 3', 'kera' ),
                'testimonial_job' => esc_html__( 'Job 3', 'kera' ),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'kera'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__( 'Name 4', 'kera' ),
                'testimonial_job' => esc_html__( 'Job 4', 'kera' ),
                'testimonial_excerpt' => 'Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque',
            ],
        ];

        return $defaults;
    }

    protected function render_item( $item ) {
        ?> 
        <div class="testimonials-body"> 
            <div class="img-testimonial">
                <?php echo trim($this->get_widget_field_img($item['testimonial_image'])); ?>
            </div>
            <div class="testimonial-meta">
                <?php 
                    $this->render_item_name( $item );
                    $this->render_item_job( $item );
                ?>
                <?php $this->render_item_excerpt( $item ); ?>
            </div>
        </div>
        <?php
    }    
    

    private function render_item_name( $item ) {
        $testimonial_name  = $item['testimonial_name'];
        if(isset($testimonial_name) && !empty($testimonial_name)) {
            ?>
                <span class="name"><?php echo trim($testimonial_name) ?></span>
            <?php
        }
    }
    private function render_item_job( $item ) {
        $testimonial_job  = $item['testimonial_job'];

        if(isset($testimonial_job) && !empty($testimonial_job)) {
            ?>
                <span class="job"><?php echo trim('/'.$testimonial_job) ?></span>
            <?php
        }
    }
    private function render_item_excerpt( $item ) {
        $testimonial_excerpt  = $item['testimonial_excerpt'];

        if(isset($testimonial_excerpt) && !empty($testimonial_excerpt)) {
            ?>
                <div class="excerpt"><?php echo trim($testimonial_excerpt) ?></div>
            <?php
        }
    }

}
$widgets_manager->register_widget_type(new Kera_Elementor_Testimonials());
