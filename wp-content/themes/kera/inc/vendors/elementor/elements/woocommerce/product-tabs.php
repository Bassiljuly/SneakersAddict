<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Kera_Elementor_Product_Tabs') ) {
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
class Kera_Elementor_Product_Tabs extends  Kera_Elementor_Carousel_Base{
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
        return 'tbay-product-tabs';
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
        return esc_html__( 'Kera Product Tabs', 'kera' );
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
        return 'eicon-tabs';
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
        return [ 'woocommerce-elements', 'product', 'products', 'tabs' ];
    }

    protected function register_controls() {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'Product Tabs', 'kera' ),
            ]
        );
        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products ( -1 = all )', 'kera'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min'  => -1
            ]
        );
        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout', 'kera'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'kera'), 
                    'carousel'  => esc_html__('Carousel', 'kera'), 
                ],
            ]
        ); 
        $this->register_woocommerce_categories_operator();
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

        $this->add_control(
            'ajax_tabs',
            [
                'label' => esc_html__( 'Ajax Product Tabs', 'kera' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'Show/hidden Ajax Product Tabs', 'kera' ), 
            ]
        );
        $this->register_controls_product_tabs();
        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'kera'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'kera'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => $this->get_woo_order_by(),
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'kera'),
                'type' => Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => $this->get_woo_order(),
            ]
        );
        
        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    public function register_controls_product_tabs() {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'product_tabs_title',
            [
                'label' => esc_html__( 'Title', 'kera' ),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'product_tabs',
            [
                'label' => esc_html__('Show Tabs', 'kera'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_product_type(),
                'default' => 'newest',
            ]
        );  
        $this->add_control(
            'list_product_tabs',
            [
                'label' => esc_html__('Tab Item','kera'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ product_tabs_title }}}',
            ]
        );
    }

    public function get_template_product() {
        return apply_filters( 'kera_get_template_product', 'v1' );
    }

    public function render_product_tabs($product_tabs, $key_id, $_id, $title, $active)
    {
        ?>
            <li>
                <a href="#<?php echo esc_attr($product_tabs.'-'.$_id .'-'.$key_id); ?>" data-value="<?php echo esc_attr($product_tabs); ?>" class="<?php echo esc_attr($active); ?>" data-toggle="tab" data-title="<?php echo esc_attr($title); ?>" ><?php echo trim($title)?></a>
            </li> 
       <?php 
    }

    public function render_product_tabs_content($list_product_tabs, $_id)
    {   
        $settings = $this->get_settings_for_display();
        ?>
        <div class="tbay-addon-content tab-content woocommerce">
            <?php $_count = 0;?>
            <?php foreach ($list_product_tabs as $key) {
                    $tab_active = ($_count==0)? 'active show active-content current':'';
                    ?>
                    <div class="tab-pane fade <?php echo esc_attr($tab_active); ?>" id="<?php echo esc_attr($key['product_tabs']).'-'.$_id .'-'.$key['_id']; ?>">
                    <?php
                    if( $_count === 0 || $settings['ajax_tabs'] !== 'yes' ) {
                        $this->render_content_tab($key['product_tabs']);
                    }

                    $_count++;
                    ?>
                    </div>
                    <?php
                }
            ?> 
        </div>
        <?php 
    }


    public function  render_content_tab($product_tabs) {
        $cat_operator = 'IN';

        $settings = $this->get_settings_for_display();
        extract( $settings );
        
        $this->add_render_attribute('row', 'class', $this->get_name_template());

        if( isset($rows) && !empty($rows) ) {
            $this->add_render_attribute( 'row', 'class', 'row-'. $rows);
        }

        $product_type = $product_tabs;

        /** Get Query Products */
        $loop = kera_get_query_products($categories,  $cat_operator, $product_type, $limit, $orderby, $order);

        if( $layout_type === 'carousel' ) $this->add_render_attribute('row', 'class', ['rows-'.$rows]);
        $this->add_render_attribute('row', 'class', ['products']);

        $attr_row = $this->get_render_attribute_string('row');

        wc_get_template( 'layout-products/layout-products.php' , array( 'loop' => $loop, 'product_style' => $product_style, 'attr_row' => $attr_row) );
    }
}
$widgets_manager->register_widget_type(new Kera_Elementor_Product_Tabs());
