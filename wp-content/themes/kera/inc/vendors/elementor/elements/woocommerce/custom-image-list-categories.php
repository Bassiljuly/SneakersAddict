<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Kera_Elementor_Custom_Image_List_Categories') ) {
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
class Kera_Elementor_Custom_Image_List_Categories extends  Kera_Elementor_Carousel_Base{
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
        return 'tbay-custom-image-list-categories';
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
        return esc_html__( 'Kera Custom Image List Categories', 'kera' );
    }

    public function get_categories() {
        return [ 'kera-elements', 'woocommerce-elements'];
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
        return 'eicon-product-categories';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    public function get_script_depends()
    {
        return ['slick', 'kera-custom-slick'];
    }

    public function get_keywords() {
        return [ 'woocommerce-elements', 'custom-image-list-categories' ];
    }

    protected function register_controls() {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'Custom Image List Categories', 'kera' ),
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'kera'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $repeater = $this->register_list_category_repeater();

        $this->add_control(
            'list_category',
            [
                'label' => esc_html__( 'List Categories Items', 'kera' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'kera'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'kera'), 
                    'carousel'  => esc_html__('Carousel', 'kera'), 
                ],
            ]
        );  
        $this->add_control(
            'type_style',
            [
                'label'     => esc_html__('Style', 'kera'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'style-1',
                'options'   => [
                    'style-1'      => esc_html__('Style 1', 'kera'), 
                    'style-2'       => esc_html__('Style 2', 'kera'), 
                    'vertical'       => esc_html__('Vertical', 'kera'), 
                ],
                'prefix_class' => ''
            ]
        );  

        $this->add_responsive_control(
            'spacing_content',
            [
                'label' => esc_html__('Spacing Content','kera'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [
                    'top' => '40',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'condition' => [
                    'type_style!' => 'vertical'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .custom-image-list-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cat_list_align_1',
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
                'condition' => [
                    'type_style' => 'style-1'
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .item-cat' => 'text-align: {{VALUE}} !important',
                    '{{WRAPPER}} .content' => 'text-align: {{VALUE}} !important',
                ]
            ]
        );
        $this->add_control(
            'cat_list_align_2',
            [
                'label' => esc_html__('Align','kera'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left','kera'),
                        'icon' => 'fas fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center','kera'),
                        'icon' => 'fas fa-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right','kera'),
                        'icon' => 'fas fa-align-right'
                    ],   
                ],
                'condition' => [
                    'type_style' => 'style-2'
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-cat' => 'justify-content: {{VALUE}} !important',
                ]
            ]
        );
        $this->add_control(
            'show_all',
            [
                'label'     => esc_html__('Display Show All', 'kera'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
            ]
        );  
        $this->add_control(
            'text_show_all',
            [
                'label'     => esc_html__('Text Show All', 'kera'),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'See all categories',
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );  
        $this->add_control(
            'icon_show_all',
            [
                'label'     => esc_html__('Icon Show All', 'kera'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'library' => 'material-design-iconic',
                    'value'   => 'zmdi zmdi-format-align-right  '
                ],

                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );  

        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    protected function register_list_category_repeater() {
        $categories = $this->get_product_categories();

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'category',
            [
                'label' => esc_html__( 'Choose category', 'kera' ),
                'type' => Controls_Manager::SELECT,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
            ]
        );

        $repeater->add_control(
            'type',
            [
                'label' => esc_html__('Type Custom','kera'),
                'type' => Controls_Manager::CHOOSE,
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
                'default'  =>'image'
            ]
        );

        $repeater->add_control(
            'type_icon',
            [
                'label' => esc_html__( 'Choose Icon', 'kera' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-question', 
                    'library' => 'simple-line-icons',
                ],
                'condition' => [
                    'type' => 'icon' 
                ]
            ]
        );

        $repeater->add_control(
            'type_image',
            [
                'label' => esc_html__( 'Choose Image', 'kera' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'type' => 'image'
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'display_custom',
            [
                'label' => esc_html__( 'Show Custom Link', 'kera' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );

        
        $repeater->add_control(
            'custom_link',
            [
                'label' => esc_html__('Custom Link','kera'),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'display_custom' => 'yes'
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'kera' ),
            ]
        );

                
        $repeater->add_control(
            'display_count_category',
            [
                'label' => esc_html__( 'Show Count Category', 'kera' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        return $repeater;
    }

    public function render_item_content($item,$attribute) {
        extract( $item);
        $obj_cat = get_term_by('slug', $category, 'product_cat');

        if( !is_object ( $obj_cat ) ) return;

        $name   = $obj_cat->name;
        $count  = $obj_cat->count;
        if(!empty($custom_link['url']) && isset($custom_link) && $display_custom ==='yes' ) {
            $url_category       = $custom_link['url'];
            $is_external        = $custom_link['is_external'];
            $nofollow           = $custom_link['nofollow'];
            if( $is_external === 'on' ) {
                $attribute .= ' target="_blank"';
            }                

            if( $nofollow === 'on' ) {
                $attribute .= ' rel="nofollow"';
            }
        }
        else {
            $url_category =  get_term_link($category, 'product_cat');
        }
        
        ?>  
            <?php $this->render_item_type($type,$url_category,$type_icon,$type_image); ?>
            <div class="content">
                <a href="<?php echo esc_url($url_category)?>" class="cat-name" <?php echo trim($attribute); ?>><?php echo trim($name) ?></a>
                <?php if($display_count_category === 'yes') {
                    ?><span class="count-item"><?php echo trim($count).' '.' '. apply_filters( 'kera_tbay_categories_count_item', esc_html__('items','kera') ); ?></span><?php
                } ?>
                
            </div>
        <?php
    }

    public function render_item_image($type_image) {
        $image_id  = $type_image['id']; 

        echo wp_get_attachment_image($image_id, 'full');
    }
    public function render_item_type($type,$url_category,$type_icon,$type_image) {
        if($type === 'icon') {
            ?>
                <a href="<?php echo esc_url($url_category)?>" class='cat-icon'>
                    <?php $this->render_item_icon($type_icon); ?>
                </a>
            <?php
        }elseif($type ==='image') {
            ?>
                <a href="<?php echo esc_url($url_category)?>" class='cat-image'>
                    <?php $this->render_item_image($type_image); ?>
                </a>
            <?php
        }
    }

    

}
$widgets_manager->register_widget_type(new Kera_Elementor_Custom_Image_List_Categories());
