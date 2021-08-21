<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Kera_Elementor_Product_Categories_Tabs') ) {
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
class Kera_Elementor_Product_Categories_Tabs extends  Kera_Elementor_Carousel_Base{
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
        return 'tbay-product-categories-tabs';
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
        return esc_html__( 'Kera Product Categories Tabs', 'kera' );
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
        return 'eicon-product-tabs';
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
        return [ 'woocommerce-elements', 'product-categories' ];
    }
    protected function _register_controls_heading() {
        $this->start_controls_section(
            'section_general_heading',
            [
                'label' => esc_html__( 'Heading', 'kera' ),
            ]
        );
        $this->add_control(
            'title_cat_tab',
            [
                'label' => esc_html__('Title', 'kera'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_responsive_control(
            'title_cat_tab_size',
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
					'{{WRAPPER}} .tbay-element-product-categories-tabs .title' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_responsive_control(
            'title_cat_tab_size_line_height',
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
					'{{WRAPPER}} .tbay-element-product-categories-tabs .title' => 'line-height: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_control(
            'sub_title_cat_tab',
            [
                'label' => esc_html__('Sub Title', 'kera'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_responsive_control(
            'sub_title_cat_tab_size',
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
					'{{WRAPPER}} .tbay-element-product-categories-tabs .subtitle' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_responsive_control(
            'sub_title_cat_tab_size_line_height',
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
					'{{WRAPPER}} .tbay-element-product-categories-tabs .subtitle' => 'line-height: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->end_controls_section();
    }

    
    protected function register_controls() {
        $this->_register_controls_heading();
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'Product Categories', 'kera' ),
            ]
        );        

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products', 'kera'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__( 'Number of products to show ( -1 = all )', 'kera' ),
                'default' => 6,
                'min'  => -1,
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'kera'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->register_woocommerce_order();
        $this->add_control(
            'product_type',
            [   
                'label'   => esc_html__('Product Type','kera'),
                'type'     => Controls_Manager::SELECT,
                'options' => $this->get_product_type(),
                'default' => 'newest'
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
            'ajax_tabs',
            [
                'label' => esc_html__( 'Ajax Categories Tabs', 'kera' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'Show/hidden Ajax Categories Tabs', 'kera' ), 
            ]
        );

        $categories = $this->get_product_categories();
        $this->add_control(
            'categories',
            [
                'label'     => esc_html__('Categories', 'kera'),
                'type'      => Controls_Manager::SELECT2,
                'default'   => [array_keys($categories)[0]],
                'options'   => $categories,   
                'multiple' => true,
                'label_block' => true,
            ]
        );  
        $this->add_control(
            'product_style',
            [
                'label' => esc_html__('Product Style', 'kera'),
                'type' => Controls_Manager::SELECT,
                'default' => 'v1',
                'options' => $this->get_template_product(),
                'prefix_class' => 'elementor-product-'
            ]
        );

        $this->register_button();
        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
        $this->register_style_heading();
    }
    protected function register_style_heading() {
        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Style Heading', 'kera'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'bg_heading',
            [
                'label'     => esc_html__('Color', 'kera'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_padding',
            [
                'label'      => esc_html__( 'Padding', 'kera' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .heading-tbay-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

    }
    protected function register_button() {
        $this->add_control(
            'show_more',
            [
                'label'     => esc_html__('Display Show More', 'kera'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );  
        $this->add_control(
            'text_button',
            [
                'label'     => esc_html__('Text Button', 'kera'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'show_more' => 'yes'
                ]
            ]
        );  
        $this->add_control(
            'icon_button',
            [
                'label'     => esc_html__('Icon Button', 'kera'),
                'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'zmdi zmdi-long-arrow-right',
					'library' => 'material-design-iconic',
                ],
                'condition' => [
                    'show_more' => 'yes'
                ]
            ]
        );  
    }
   

    public function get_template_product() {
        return apply_filters( 'kera_get_template_product', 'v1' );
    }
    public function render_tabs_title($categories,$_id,$settings) {
        $settings = $this->get_settings_for_display();
        $product_type = $limit = $orderby = $order = '';
        $cat_operator = 'IN';
        extract($settings);
        if ($ajax_tabs === 'yes') {
            $this->add_render_attribute('row', 'class', ['products']);
            $attr_row = $this->get_render_attribute_string('row'); 

            $json = array( 
                'product_type'                  => $product_type,
                'cat_operator'                  => $cat_operator,
                'limit'                         => $limit,
                'orderby'                       => $orderby,
                'order'                         => $order,
                'product_style'                 => $product_style,
                'attr_row'                      => $attr_row, 
            ); 

            $encoded_settings  = wp_json_encode( $json );

            $tabs_data = 'data-atts="'. esc_attr( $encoded_settings ) .'"';
        } else {
            $tabs_data = '';
        }
        ?>
        
        <div class="heading-product-category-tabs">
            <?php
                if(!empty($title_cat_tab) || !empty($sub_title_cat_tab) ) {
                    ?>
                    <h3 class="heading-tbay-title elementor-heading-title">
                        <?php if( !empty($title_cat_tab) ) : ?>
                            <span class="title"><?php echo trim($title_cat_tab); ?></span>
                        <?php endif; ?>	    	
                        <?php if( !empty($sub_title_cat_tab) ) : ?>
                            <span class="subtitle"><?php echo trim($sub_title_cat_tab); ?></span>
                        <?php endif; ?>
                    </h3>
                    <?php
                }
                
            ?>
            
        </div>
        <?php $this->render_item_button() ?>
        <ul class="product-categories-tabs-title tabs-list nav nav-tabs" <?php echo trim($tabs_data); ?>>
            <?php 
                $__count=0;
            ?>

            <?php foreach ($categories as $item) { ?>
                <?php $this->render_product_tab($item, $__count, $_id); ?>
                <?php $__count++; ?>
            <?php } ?>
        </ul>
       <?php
    }

    public function render_product_tab($item, $__count, $_id) {
        $active = ($__count == 0) ? 'active' : '';
        $category = get_term_by( 'slug', $item, 'product_cat' ); 
 
        if( !empty($category->name) ) {
            $title = $category->name;
        } else {
            $title = '';
        }
        ?>  
        <li >
            <a class="<?php echo esc_attr( $active ); ?>" data-value="<?php echo esc_attr($item); ?>" href="#<?php echo esc_attr($item.'-'. $_id); ?>" data-toggle="tab" aria-controls="<?php echo esc_attr($item.'-'. $_id); ?>"><?php echo trim($title);?></a>
        </li>

        
       <?php
    }
   
    public function render_product_tabs_content($categories, $_id) {
        $settings = $this->get_settings_for_display();
        ?>
            <div class="content-product-category-tab">
                <div class="tbay-addon-content tab-content woocommerce">
                 <?php 
                    $__count=0;
                    foreach ($categories as $key ) {
                        $tab_active = ($__count == 0) ? ' active show active-content current' : ''; 
                        ?> 
                        <div class="tab-pane fade <?php echo esc_attr($tab_active); ?>" id="<?php echo esc_attr($key.'-'. $_id); ?>"> 
                        <?php 
                        if( $__count === 0 || $settings['ajax_tabs'] !== 'yes' ) {
                            $this->render_content_tab($key); 
                        } 
                        $__count++;
                        ?> 
                            </div>
                        <?php
                    }
                 ?>
                </div>
            </div>
        <?php
 
    }
    private function  render_content_tab($key) {
        $settings = $this->get_settings_for_display();
        $product_type = $limit = $orderby = $order = '';
        $cat_operator = 'IN';
        extract( $settings );
        
        /** Get Query Products */
        $loop = kera_get_query_products($key,  $cat_operator, $product_type, $limit, $orderby, $order);

        if( $layout_type === 'carousel' ) $this->add_render_attribute('row', 'class', ['rows-'.$rows]);
        $this->add_render_attribute('row', 'class', ['products']);

        $attr_row = $this->get_render_attribute_string('row');
        wc_get_template( 'layout-products/layout-products.php' , array( 'loop' => $loop, 'product_style' => $product_style, 'attr_row' => $attr_row) );
        
    }
    
    public function render_item_button() {
        $settings = $this->get_settings_for_display();
        extract( $settings );
        $url_category =  get_permalink(wc_get_page_id('shop'));
        if(isset($text_button) && !empty($text_button)) {?>
            <a href="<?php echo esc_url($url_category)?>" class="btn"><?php echo trim($text_button) ?>
                <?php 
                    $this->render_item_icon($icon_button);
                ?>
            </a>
            <?php
        }
        
    }
}
$widgets_manager->register_widget_type(new Kera_Elementor_Product_Categories_Tabs());
