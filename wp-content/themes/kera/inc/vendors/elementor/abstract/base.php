<?php
if (!defined('ABSPATH') || function_exists('Kera_Elementor_Widget_Base') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Core\Schemes;

abstract class Kera_Elementor_Widget_Base extends Elementor\Widget_Base {
	public function get_name_template() {
        return str_replace('tbay-', '', $this->get_name());
    }

    public function get_categories() {
        return [ 'kera-elements' ];
    }

    public function get_name() {
        return 'kera-base';
    }

    /**
	 * Get view template
	 *
	 * @param string $tpl_name
	 */
	protected function get_view_template( $tpl_slug, $tpl_name, $settings = [] ) {
		$located   = '';
		$templates = [];
		

		if ( ! $settings ) {
			$settings = $this->get_settings_for_display();
		} 

		if ( !empty($tpl_name) ) {
			$tpl_name  = trim( str_replace( '.php', '', $tpl_name ), DIRECTORY_SEPARATOR );
			$templates[] = 'elementor_templates/' . $tpl_slug . '-' . $tpl_name . '.php';
			$templates[] = 'elementor_templates/' . $tpl_slug . '/' . $tpl_name . '.php';
		}

		$templates[] = 'elementor_templates/' . $tpl_slug . '.php';
 
		foreach ( $templates as $template ) {
			if ( file_exists( KERA_THEMEROOT . '/' . $template ) ) {
				$located = KERA_THEMEROOT . '/' . $template;
				break;
			} else {
				$located = false;
			}
		}

		if ( $located ) {
			include $located;
		} else {
			echo sprintf( __( 'Failed to load template with slug "%s" and name "%s".', 'kera' ), $tpl_slug, $tpl_name );
		}
	}

	protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'tbay-element tbay-element-'. $this->get_name_template() );

        $this->get_view_template($this->get_name_template(), '', $settings);
	}
	
	protected function register_controls_heading($condition = array()) {

        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__( 'Heading', 'kera' ),
                'condition' => $condition,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'kera'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'kera'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'kera'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'kera'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title', 'kera'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'heading_title_tag',
            [
                'label' => esc_html__( 'Title HTML Tag', 'kera' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'heading_subtitle',
            [
                'label' => esc_html__('Sub Title', 'kera'),
                'type' => Controls_Manager::TEXT,
                'separator'    => 'before',
                'label_block' => true,
            ]
		);
		

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_heading',
            [
                'label' => esc_html__( 'Heading', 'kera' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );
        $this->register_title_controls();
        $this->register_sub_title_controls();
        $this->end_controls_section();
    }

    private function register_title_controls() {
        $this->add_control(
            'heading_stylecontent',
            [
                'label' => esc_html__( 'Content', 'kera' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'heading_style_margin',
            [
                'label' => esc_html__( 'Margin', 'kera' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );        

        $this->add_responsive_control(
            'heading_style_padding',
            [
                'label' => esc_html__( 'Padding', 'kera' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'active_divider_heading',
            [
                'label' => esc_html__( 'Active Divider Heading', 'kera' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'divider-',
            ]
        );
       
        $this->add_responsive_control(
			'width_divider_heading',
			[
				'label' => esc_html__( 'Width', 'kera' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'max' => 1000,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}}.divider-yes .heading-tbay-title:before' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'active_divider_heading' => 'yes'
                ]
			]
        );
        $this->add_control(
            'color_divider_heading',
            [
                'label' => esc_html__( 'Color Divider Heading', 'kera' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}}.divider-yes .heading-tbay-title:before' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'active_divider_heading' => 'yes'
                ]
            ]
        );
        
       
        $this->add_control(
            'heading_styletitle',
            [
                'label' => esc_html__( 'Title', 'kera' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_title_color',
            [
                'label' => esc_html__( 'Color', 'kera' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'kera' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_title_typography',
                'selector' => '{{WRAPPER}} .heading-tbay-title .title',
            ]
        );

        $this->add_responsive_control(
            'heading_title_bottom_space',
            [
                'label' => esc_html__( 'Spacing', 'kera' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


    }     

    private function register_sub_title_controls() {

        $this->add_control(
            'heading_stylesubtitle',
            [
                'label' => esc_html__( 'Sub title', 'kera' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_subtitle_color',
            [
                'label' => esc_html__( 'Color', 'kera' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_subtitle_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'kera' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_subtitle_typography',
                'selector' => '{{WRAPPER}} .heading-tbay-title .subtitle',
            ]
        );

        $this->add_responsive_control(
            'heading_subtitle_bottom_space',
            [
                'label' => esc_html__( 'Spacing', 'kera' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }     

    protected function get_available_pages() {
        $pages = get_pages();

        $options = [];

        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }

        return $options;
    }

    protected function get_available_on_sale_products() {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1
        );

        $product_ids_on_sale    = wc_get_product_ids_on_sale();
        $product_ids_on_sale[]  = 0;
        $args['post__in'] = $product_ids_on_sale;
        $loop = new WP_Query( $args );

        $options = []; 
        if ( $loop->have_posts() ): while ( $loop->have_posts() ): $loop->the_post();

            $options[get_the_ID()] = get_the_title();


        endwhile; endif; wp_reset_postdata();

        return $options;
    }
    protected function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }

        return $options;
    }
	
	public function render_element_heading() {
        $heading_title = $heading_title_tag = $heading_subtitle = '';
        $settings = $this->get_settings_for_display();
        extract( $settings );

		if( !empty($heading_subtitle) || !empty($heading_title) ) : ?>
			<<?php echo trim($heading_title_tag); ?> class="heading-tbay-title elementor-heading-title">
				<?php if( !empty($heading_title) ) : ?>
					<span class="title"><?php echo trim($heading_title); ?></span>
				<?php endif; ?>	    	
				<?php if( !empty($heading_subtitle) ) : ?>
					<span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
				<?php endif; ?>
			</<?php echo trim($heading_title_tag); ?>>
		<?php endif;
    }
    
    protected function get_template_product_grid() {
        return apply_filters( 'kera_get_template_product_grid', 'v1' );
    }      

    protected function get_template_product_vertical() {
        return apply_filters( 'kera_get_template_product_vertical', 'vertical-v1' );
    }    

    protected function get_template_product() {
        return apply_filters( 'kera_get_template_product', 'v1' );
    }

    protected function get_product_type() {
        $type = [
            'newest' => esc_html__('Newest Products', 'kera'),
            'on_sale' => esc_html__('On Sale Products', 'kera'),
            'best_selling' => esc_html__('Best Selling', 'kera'),
            'top_rated' => esc_html__('Top Rated', 'kera'),
            'featured' => esc_html__('Featured Product', 'kera'),
            'random_product' => esc_html__('Random Product', 'kera'),
        ];

        return apply_filters( 'kera_woocommerce_product_type', $type);
    }

    protected function get_title_product_type($key) {
        $array = $this->get_product_type();

        return $array[$key];
    }

    protected function get_attribute_query_product_type($args, $product_type) {
        global $woocommerce;

        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['order']          = 'desc';
                $args['orderby']    = 'meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;

            case 'featured':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['meta_query'][]           = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][]           = $woocommerce->query->visibility_meta_query();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                break;

            case 'top_rated':
                $args['meta_key']       = '_wc_average_rating';
                $args['orderby']        = 'meta_value_num';
                $args['order']          = 'desc';
                break;

            case 'newest':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;

            case 'random_product':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;

            case 'deals':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['meta_query'][] =  array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array(
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    ),            
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                );
                break;  

            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );

        return $args;
    }


    protected function get_product_categories($number = '') {
        $args = array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        );
        if ($number === 0) {
            return;
        }
        if( !empty($number) && $number !== -1 ) {
            $args['number'] = $number;
        }
       

        $category = get_terms($args);
        $results = array();
        if (!is_wp_error($category)) {
            foreach ($category as $category) {
                $results[$this->transliterate($category->slug)] = $category->name.' ('.$category->count.') ';
            }
        }
        return $results;
    }

    protected function transliterate( $title ) {
        $prev_locale = setlocale( LC_CTYPE, 0 );
        setlocale( LC_ALL, 'C.UTF-8' );
    
        $title = urldecode( $title );
    
        if ( function_exists( 'iconv' ) && defined( 'ICONV_IMPL' ) && @strcasecmp( ICONV_IMPL, 'unknown' ) !== 0 ) {
            $title = iconv( 'UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title );
        }
    
        setlocale( LC_ALL, $prev_locale );
    
        return $title;
	}

    protected function get_cat_operator() {
        $operator = [
            'AND' => esc_html__('AND', 'kera'),
            'IN' => esc_html__('IN', 'kera'),
            'NOT IN' => esc_html__('NOT IN', 'kera'),
        ];

        return apply_filters( 'kera_woocommerce_cat_operator', $operator);
    }

    protected function get_woo_order_by() { 
        $oder_by = [
            'date' => esc_html__('Date', 'kera'),
            'title' => esc_html__('Title', 'kera'),
            'id' => esc_html__('ID', 'kera'),
            'price' => esc_html__('Price', 'kera'),
            'popularity' => esc_html__('Popularity', 'kera'),
            'rating' => esc_html__('Rating', 'kera'),
            'rand' => esc_html__('Random', 'kera'),
            'menu_order' => esc_html__('Menu Order', 'kera'),
        ];

        return apply_filters( 'kera_woocommerce_oder_by', $oder_by);
    }

    protected function get_woo_order() {
        $order = [
            'asc' => esc_html__('ASC', 'kera'), 
            'desc' => esc_html__('DESC', 'kera'),
        ];

        return apply_filters( 'kera_woocommerce_order', $order);
    }

    protected function register_woocommerce_order() {
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'kera'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => $this->get_woo_order_by(),
                'conditions' => [
					'relation' => 'AND',
					'terms' => [
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'top_rated',
						],
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'random_product',
						],
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'best_selling',
						],
					],
				],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'kera'),
                'type' => Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => $this->get_woo_order(),
                'conditions' => [
					'relation' => 'AND',
					'terms' => [
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'top_rated',
						],
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'random_product',
						],
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'best_selling',
						],
					],
				],
            ]
        );
    }

    protected function render_item_icon($selected_icon) {
        $settings = $this->get_settings_for_display();

        if ( ! isset( $selected_icon['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$selected_icon['icon'] = 'fa fa-star';
        }
        $has_icon = ! empty( $selected_icon['icon'] );

        if ( $has_icon ) {
			$this->add_render_attribute( 'i', 'class', $selected_icon['icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }
        
        if ( ! $has_icon && ! empty( $selected_icon['value'] ) ) {
			$has_icon = true;
        }
        
        if( ! empty( $selected_icon['value'] ) ) {
            $this->add_render_attribute( 'i', 'class', $selected_icon['value'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' ); 
        }

        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        Icons_Manager::enqueue_shim();

        if( !$has_icon ) return;  

        if ( $is_new || $migrated ) :
            Icons_Manager::render_icon( $selected_icon, [ 'aria-hidden' => 'true' ] );
        else : ?>
            <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
        <?php endif;
    }
    
    public function on_import( $element ) {
		return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
	}

    protected function register_woocommerce_categories_operator() {
        $categories = $this->get_product_categories();

        $this->add_control(
            'categories', 
            [
                'label' => esc_html__('Categories', 'kera'),
                'type' => Controls_Manager::SELECT2, 
                'default'   => array_keys($categories)[0],
                'options'   => $categories,   
                'multiple' => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label' => esc_html__('Category Operator', 'kera'),
                'type' => Controls_Manager::SELECT,
                'default' => 'IN',
                'options' => $this->get_cat_operator(),
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );
    }

    protected function get_woocommerce_tags() {
        $tags = array();
        
        $args = array(
            'order' => 'ASC',
        );

        $product_tags = get_terms( 'product_tag', $args );

        foreach ( $product_tags as $key => $tag ) {

            $tags[$tag->slug] = $tag->name . ' (' .$tag->count .')';

        }

        return $tags;
    }

    protected function settings_carousel($settings) {
        $this->add_render_attribute('row', 'class', ['owl-carousel', 'scroll-init']);  
        $this->add_render_attribute('row', 'data-carousel', 'owl');

        $this->add_render_attribute('row', 'data-items', $settings['column']);
        $this->add_render_attribute('row', 'data-desktopslick', $settings['col_desktop']);
        $this->add_render_attribute('row', 'data-desktopsmallslick', $settings['col_desktopsmall']);
        $this->add_render_attribute('row', 'data-tabletslick', $settings['column_tablet']);
        $this->add_render_attribute('row', 'data-landscapeslick', $settings['col_landscape']);
        $this->add_render_attribute('row', 'data-mobileslick', $settings['column_mobile']);
        
        if( !empty($settings['rows']) ) {
            $this->add_render_attribute('row', 'data-rows', $settings['rows']);      
        }

        $this->add_render_attribute('row', 'data-nav', $settings['navigation'] === 'yes' ? true : false);  
        $this->add_render_attribute('row', 'data-pagination', $settings['pagination'] === 'yes' ? true : false);  
        $this->add_render_attribute('row', 'data-loop', $settings['loop'] === 'yes' ? true : false);  

        if( !empty($settings['autospeed']) ) {
            $this->add_render_attribute('row', 'data-autospeed', $settings['autospeed']  );  
        }
  
        $this->add_render_attribute('row', 'data-auto', $settings['auto'] === 'yes' ? true : false);  
        $this->add_render_attribute('row', 'data-unslick', $settings['disable_mobile'] === 'yes' ? true : false);  
    } 

    protected function settings_responsive($settings) { 
        /*Add class reponsive grid*/
        $this->add_render_attribute(
            'row',
            [
                'class' => [ 'row', 'grid' ],
                'data-xlgdesktop' =>  $settings['column'],
                'data-desktop' =>  $settings['col_desktop'],
                'data-desktopsmall' =>  $settings['col_desktopsmall'],
            ]
        );

        if (!empty($settings['column_tablet'])) {
            $this->add_render_attribute('row', 'data-tablet', $settings['column_tablet']);
        }
        
        $this->add_render_attribute('row', 'data-landscape', $settings['col_landscape']);
        if (!empty($settings['column_mobile'])) {
            $this->add_render_attribute('row', 'data-mobile', $settings['column_mobile']);
        }
    } 

    public function settings_layout() {
        $settings = $this->get_settings_for_display();
        extract( $settings );

        if( !isset($layout_type) ) return;      
        
        $this->add_render_attribute('row', 'class', $this->get_name_template());

        if( isset($rows) && !empty($rows) ) {
            $this->add_render_attribute( 'row', 'class', 'row-'. $rows);
        }

        if($layout_type === 'carousel') { 
            $this->settings_carousel($settings);    
        }else{
            $this->settings_responsive($settings);
        }
    }
    
    protected function get_widget_field_img( $image ) {
        $image_id   = $image['id'];
        $img  = '';

        if( !empty($image_id) ) {
            $img = wp_get_attachment_image($image_id, 'full');    
        } else if( !empty($image['url']) ) {
            $img = '<img src="'. $image['url'] .'">';
        }

        return $img;
    }
    
    protected function get_item_icon_svg($selected_icon) {
        if ( ! isset( $selected_icon['value']['id'] ) ) {
            return '';
        }

        return Svg_Handler::get_inline_svg( $selected_icon['value']['id'] );
    }

}

