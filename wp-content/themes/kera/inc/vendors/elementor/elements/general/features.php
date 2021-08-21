<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Kera_Elementor_Features') ) {
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
class Kera_Elementor_Features extends  Kera_Elementor_Carousel_Base{
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
        return 'tbay-features';
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
        return esc_html__( 'Kera Features', 'kera' );
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
        return 'eicon-star-o';
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
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'General', 'kera' ),
            ]
        );
 
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'feature_title',
            [
                'label' => esc_html__( 'Title', 'kera' ),
                'type' => Controls_Manager::TEXT,
            ]
        );
        
        $repeater->add_control(
            'feature_desc',
            [
                'label' => esc_html__( 'Description', 'kera' ),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        
        $repeater->add_control(
            'feature_type',
            [
                'label' => esc_html__( 'Display Type', 'kera' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'icon',
                'options' => [
                    'image' => [
                        'title' => esc_html__('Image', 'kera'),
                        'icon' => 'fa fa-image',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'kera'),
                        'icon' => 'fa fa-info',
                    ],
                ],
                'default' => 'images',
            ]
        );
        
        $repeater->add_control(
            'type_icon',
            [
                'label' => esc_html__('Choose Icon','kera'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'zmdi zmdi-card-giftcard',
					'library' => 'material-design-iconic',
                ],
                'condition' => [
                    'feature_type' => 'icon'
                ]
            ]
        );
        $repeater->add_control(
            'type_image',
            [
                'label' => esc_html__('Choose Image','kera'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'feature_type' => 'image'
                ]
            ]
        );
    
        
        $this->add_control(
            'features',
            [
                'label' => esc_html__('Feature Item','kera'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ feature_title }}}',
            ]
        );
        
        $this->add_responsive_control(
            'feature_align',
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
                    '{{WRAPPER}} .item > .inner > .fbox-image' => 'text-align: {{VALUE}} ',
                    '{{WRAPPER}} .item .ourservice-heading' => 'text-align: {{VALUE}} ',
                    '{{WRAPPER}} .item .description' => 'text-align: {{VALUE}} ',
                    '{{WRAPPER}} .item .fbox-icon' => 'text-align: {{VALUE}} ',
                ]
            ]
        );
        $this->end_controls_section();
        $this->add_control_responsive();
        $this->style_item(); 
    }
    protected function style_item() {
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'kera' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'spacing_items',
            [
                'label' => esc_html__('Spacing Item','kera'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'], 
                'default' => [
                    'top' => '10',
                    'right' => '15',
                    'bottom' => '10',
                    'left' => '15',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'feature_title_font',
            [
                'label' => esc_html__( 'Font Title', 'kera' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .features .ourservice-heading' => 'font-size: {{SIZE}}{{UNIT}};',
				],

            ]
        );
        $this->add_responsive_control(
            'feature_title_line_height',
            [
                'label' => esc_html__( 'Line Height', 'kera' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .features .ourservice-heading' => 'line-height: {{SIZE}}{{UNIT}};',
				],

            ]
        );
        $this->add_control(
            'feature_title_color',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .features .ourservice-heading'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'spacing_title',
            [
                'label' => esc_html__('Spacing title','kera'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-features .ourservice-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'feature_desc_font',
            [
                'label' => esc_html__( 'Font Description', 'kera' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .features .description' => 'font-size: {{SIZE}}{{UNIT}};',
				],

            ]
        );
        $this->add_responsive_control(
            'feature_desc_line-height',
            [
                'label' => esc_html__( 'Line Height', 'kera' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .features .description' => 'line-height: {{SIZE}}{{UNIT}};',
				],

            ]
        );
        $this->add_control(
            'feature_desc_color',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .features .description'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'spacing_desc',
            [
                'label' => esc_html__('Spacing Description','kera'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-features .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'feature_icon_font',
            [
                'label' => esc_html__( 'Font Icon', 'kera' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .features .fbox-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'feature_type' => 'icon',
                ],
            ]
        );

        $this->add_responsive_control(
			'feature_spacing_icon',
			[
				'label' => esc_html__( 'Spacing "Icon"', 'kera' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .features .fbox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'feature_type' => 'icon',
                ],
			]
		);

        $this->end_controls_section();
    }

    protected function render_item($item) {
        extract($item);
        ?> 
        <div class="inner"> 
            <?php
                $this->render_item_fbox($feature_type,$type_image,$type_icon);
                $this->render_item_content($feature_title,$feature_desc);     
            ?>
        </div>
        <?php
    }      
    public function render_item_content($feature_title,$feature_desc) {
        if(empty($feature_title) && empty($feature_desc) ) {
            return;
        }
        ?>
            <div class="fbox-content">
                <?php
                if(isset($feature_title) && !empty($feature_title)) :?>
                    <h3 class="ourservice-heading">
                        <?php echo trim($feature_title) ?>
                    </h3>
                <?php endif;

                if(isset($feature_desc) && !empty($feature_desc)): ?>
                    <p class="description">
                        <?php echo trim($feature_desc) ?>
                    </p>
                <?php endif;
                ?>
            </div>
        <?php
    }
    
    public function render_item_fbox($feature_type,$type_image,$type_icon){
        $image_id = $type_image['id'];

        $fbox_class = '';
        $fbox_class .= 'fbox-'.$feature_type;
        if($feature_type === 'image') {
            $type_icon = '';
        } 

        ?>
        <div class="<?php echo esc_attr($fbox_class); ?>">
            <?php if(isset($type_icon) && !empty($type_icon)): ?>
                <?php $this->render_item_icon($type_icon) ?>
            <?php elseif(isset($image_id) && !empty($image_id)): ?>
                <?php echo  wp_get_attachment_image($image_id, 'full'); ?>
            <?php endif;?>
        </div>

        <?php

    }

}
$widgets_manager->register_widget_type(new Kera_Elementor_Features());
