<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Kera_Elementor_Addons {
	public function __construct() {
        $this->include_control_customize_widgets();
        $this->include_render_customize_widgets();

		add_action( 'elementor/elements/categories_registered', array( $this, 'add_category' ) );

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'include_widgets' ) );

		add_action( 'wp', [ $this, 'regeister_scripts_frontend' ] );

        // editor
        add_action('elementor/editor/after_register_scripts', [ $this, 'editor_after_register_scripts' ]);

        // frontend
        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [ $this, 'frontend_after_register_scripts' ]);
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_after_enqueue_scripts' ] );
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_icons'], 99);

    
        add_action( 'widgets_init', array( $this, 'register_wp_widgets' ) );
    }  
   


    public function editor_after_register_scripts() {
    
    }    

    public function frontend_after_enqueue_scripts() {
        /*Treeview menu*/
        wp_enqueue_script( 'jquery-treeview' );
        wp_enqueue_script( 'kera-script' );
        wp_enqueue_script( 'jquery-countdowntimer' );  

        wp_enqueue_style( 'sumoselect' );
        wp_enqueue_script( 'jquery-sumoselect' );
    }   

    public function enqueue_editor_icons() {
        wp_enqueue_style( 'simple-line-icons', KERA_STYLES . '/simple-line-icons.css', array(), '2.4.0' );
        wp_enqueue_style( 'material-design-iconic-font', KERA_STYLES . '/material-design-iconic-font.css', false, '2.2.0' ); 

    }


    /**
     * @internal Used as a callback
     */
    public function frontend_after_register_scripts() {
        $this->editor_after_register_scripts();
    }


	public function register_wp_widgets() {

	}

	function regeister_scripts_frontend() {
		
    }


    public function add_category() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'kera-elements',
            array(
                'title' => esc_html__('Kera Elements', 'kera'),
                'icon'  => 'fa fa-plug',
            ),
            1);
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function include_widgets($widgets_manager) {
        $this->include_abstract_widgets($widgets_manager);
        $this->include_general_widgets($widgets_manager);
        $this->include_header_widgets($widgets_manager);
        $this->include_woocommerce_widgets($widgets_manager);
	} 


    /**
     * Widgets General Theme
     */
    public function include_general_widgets($widgets_manager) {

        $elements = array(
            'template',  
            'heading',  
            'features', 
            'brands',
            'posts-grid',
            'our-team',
            'banner',
            'testimonials',
            'button',
            'list-menu',
        );

        if( class_exists('MC4WP_MailChimp') ) {
            array_push($elements, 'newsletter');
        }


        $elements = apply_filters( 'kera_general_elements_array', $elements );

        foreach ( $elements as $file ) {
            $path   = KERA_ELEMENTOR .'/elements/general/' . $file . '.php';
            if( file_exists( $path ) ) {
                require_once $path;
            }
        }

    }    

    /**
     * Widgets WooComerce Theme
     */
    public function include_woocommerce_widgets($widgets_manager) {
        if( !kera_is_Woocommerce_activated() ) return;

        $woo_elements = array(
            'products',
            'product-category',
            'product-tabs',
            'woocommerce-tags',
            'custom-image-list-tags',
            'product-categories-tabs',
            'list-categories-product',
            'product-recently-viewed',
            'custom-image-list-categories',
            'product-flash-sales',
            'product-count-down',
            'product-list-tags'
        );

        $woo_elements = apply_filters( 'kera_woocommerce_elements_array', $woo_elements );

        foreach ( $woo_elements as $file ) {
            $path   = KERA_ELEMENTOR .'/elements/woocommerce/' . $file . '.php';
            if( file_exists( $path ) ) {
                require_once $path;
            }
        }

    }    

    /**
     * Widgets Header Theme
     */
    public function include_header_widgets($widgets_manager) {
        if( !kera_is_Woocommerce_activated() ) return;

        $elements = array(
            'site-logo',
            'nav-menu',
            'account',
            'search-form',
            'mini-cart',
            'banner-close',
            'search-canvas',
            'canvas-menu-template',
        );

        if( class_exists('WOOCS_STARTER') ) {
            array_push($elements, 'currency');
        }

        if( class_exists( 'YITH_WCWL' ) ) {
            array_push($elements, 'wishlist');
        }

        if( class_exists( 'YITH_Woocompare' ) ) {
            array_push($elements, 'compare');
        } 

        if( defined('TBAY_ELEMENTOR_DEMO') || class_exists('SitePress') ) {
            array_push($elements, 'custom-language');
        }

        $elements = apply_filters( 'kera_header_elements_array', $elements );

        foreach ( $elements as $file ) {
            $path   = KERA_ELEMENTOR .'/elements/header/' . $file . '.php';
            if( file_exists( $path ) ) {
                require_once $path;
            }
        }

    }


    /**
     * Widgets Abstract Theme
     */
    public function include_abstract_widgets($widgets_manager) {
        $abstracts = array(
            'image',
            'base',
            'responsive',
            'carousel',
        );

        $abstracts = apply_filters( 'kera_abstract_elements_array', $abstracts );

        foreach ( $abstracts as $file ) {
            $path   = KERA_ELEMENTOR .'/abstract/' . $file . '.php';
            if( file_exists( $path ) ) {
                require_once $path;
            }
        } 
    }

    public function include_control_customize_widgets() {
        $widgets = array(
            'sticky-header',
            'column',
            'column-border', 
            'section-stretch-row',
            'settings-layout',
        );

        $widgets = apply_filters( 'kera_customize_elements_array', $widgets );
 
        foreach ( $widgets as $file ) {
            $control   = KERA_ELEMENTOR .'/elements/customize/controls/' . $file . '.php';
            if( file_exists( $control ) ) {
                require_once $control;
            }            
        } 
    }    

    public function include_render_customize_widgets() {
        $widgets = array(
            'sticky-header',
            'column-border',
        );

        $widgets = apply_filters( 'kera_customize_elements_array', $widgets );
 
        foreach ( $widgets as $file ) {
            $render    = KERA_ELEMENTOR .'/elements/customize/render/' . $file . '.php';         
            if( file_exists( $render ) ) {
                require_once $render;
            }
        } 
    }
}

new Kera_Elementor_Addons();

