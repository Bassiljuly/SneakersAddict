<?php

/**
 * Class kera_setup_theme'
 */
class kera_setup_theme {
    function __construct() {
        add_action( 'after_setup_theme', array( $this, 'setup' ), 10 );

        add_action('wp', 'kera_get_display_header_builder');

        add_action( 'wp_enqueue_scripts', array( $this, 'load_fonts_url' ), 10 );
        add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 100 );
        add_action('wp_footer', array( $this, 'footer_scripts' ), 20 );
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );
        add_filter( 'frontpage_template', array( $this, 'front_page_template' ) );

        /**Remove fonts scripts**/
        add_action('wp_enqueue_scripts', array( $this, 'remove_fonts_redux_url' ), 1000 );

        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_styles' ), 1000 );
        add_action( 'login_enqueue_scripts', array( $this, 'load_admin_login_styles' ), 1000 );


        add_action( 'after_switch_theme', array( $this, 'add_cpt_support'), 10 );
    }

    /**
     * Enqueue scripts and styles.
     */
    public function add_scripts() {
       
        $suffix = (kera_tbay_get_config('minified_js', false)) ? '.min' : KERA_MIN_JS;


        // load bootstrap style 
        if( is_rtl() ){
            wp_enqueue_style( 'bootstrap', KERA_STYLES . '/bootstrap.rtl.css', array(), '4.3.1' );
        }else{
            wp_enqueue_style( 'bootstrap', KERA_STYLES . '/bootstrap.css', array(), '4.3.1' );
        }
        
        // Load our main stylesheet.
        if( is_rtl() ){
            $css_path =  KERA_STYLES . '/template.rtl.css';
        }
        else{
            $css_path =  KERA_STYLES . '/template.css';
        }

		$css_array = array();

        if( kera_is_elementor_activated() ) {
            array_push($css_array, 'elementor-frontend'); 
        } 
        wp_enqueue_style( 'kera-template', $css_path, $css_array, KERA_THEME_VERSION );
        
        wp_enqueue_style( 'kera-style', KERA_THEME_DIR . '/style.css', array(), KERA_THEME_VERSION );

        //load font awesome
        
        wp_enqueue_style( 'fontawesome', KERA_STYLES . '/fontawesome.css', array(), '5.10.2' );

        //load font custom icon tbay
        wp_enqueue_style( 'font-tbay', KERA_STYLES . '/font-tbay-custom.css', array(), '1.0.0' );

        //load simple-line-icons
        wp_enqueue_style( 'simple-line-icons', KERA_STYLES . '/simple-line-icons.css', array(), '2.4.0' );

        //load material font icons
        wp_enqueue_style( 'material-design-iconic-font', KERA_STYLES . '/material-design-iconic-font.css', array(), '2.2.0' );

        // load animate version 3.5.0
        wp_enqueue_style( 'animate-css', KERA_STYLES . '/animate.css', array(), '3.5.0' );

        
        wp_enqueue_script( 'kera-skip-link-fix', KERA_SCRIPTS . '/skip-link-fix' . $suffix . '.js', array(), KERA_THEME_VERSION, true );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }


        /*mmenu menu*/ 
        wp_register_script( 'jquery-mmenu', KERA_SCRIPTS . '/jquery.mmenu' . $suffix . '.js', array( 'underscore' ),'7.0.5', true );
     
        /*Treeview menu*/
        wp_enqueue_style( 'jquery-treeview',  KERA_STYLES . '/jquery.treeview.css', array(), '1.0.0' );
        
        wp_register_script( 'popper', KERA_SCRIPTS . '/popper' . $suffix . '.js', array( ), '1.12.9', true );        
         
        wp_enqueue_script( 'bootstrap', KERA_SCRIPTS . '/bootstrap' . $suffix . '.js', array( 'popper' ), '4.3.1', true );
 
        wp_enqueue_script('waypoints', KERA_SCRIPTS . '/jquery.waypoints' . $suffix . '.js', array(), '4.0.0', true);
        /*slick jquery*/
        wp_register_script( 'slick', KERA_SCRIPTS . '/slick' . $suffix . '.js', array( ), '1.0.0', true );
        wp_register_script( 'kera-custom-slick', KERA_SCRIPTS . '/custom-slick' . $suffix . '.js', array( ), KERA_THEME_VERSION, true );

        // Add js Sumoselect version 3.0.2
        wp_register_style('sumoselect', KERA_STYLES . '/sumoselect.css', array(), '1.0.0', 'all');
        wp_register_script('jquery-sumoselect', KERA_SCRIPTS . '/jquery.sumoselect' . $suffix . '.js', array( ), '3.0.2', TRUE);   

        wp_register_script( 'jquery-shuffle', KERA_SCRIPTS . '/jquery.shuffle' . $suffix . '.js', array( ), '3.0.0', true );  

        wp_register_script( 'jquery-autocomplete', KERA_SCRIPTS . '/jquery.autocomplete' . $suffix . '.js', array( 'kera-script' ), '1.0.0', true );     
        wp_enqueue_script('jquery-autocomplete');

        wp_register_style( 'magnific-popup', KERA_STYLES . '/magnific-popup.css', array(), '1.0.0' );
        wp_enqueue_style('magnific-popup');

        wp_register_script( 'jquery-countdowntimer', KERA_SCRIPTS . '/jquery.countdownTimer' . $suffix . '.js', array( 'jquery' ), '20150315', true );

        wp_register_style( 'jquery-fancybox', KERA_STYLES . '/jquery.fancybox.css', array(), '3.2.0' );
        wp_register_script( 'jquery-fancybox', KERA_SCRIPTS . '/jquery.fancybox' . $suffix . '.js', array( ), '2.1.7', true );

        wp_register_script( 'kera-script',  KERA_SCRIPTS . '/functions' . $suffix . '.js', array('jquery-core', 'bootstrap'),  KERA_THEME_VERSION,  true );

        wp_enqueue_script( 'detectmobilebrowser', KERA_SCRIPTS . '/detectmobilebrowser' . $suffix . '.js', array(), '1.0.6', true );

        wp_enqueue_script( 'fastclick', KERA_SCRIPTS . '/fastclick' . $suffix . '.js', array( 'jquery' ), '1.0.6', true );

        if ( kera_tbay_get_config('header_js') != "" ) {
            wp_add_inline_script( 'kera-script', kera_tbay_get_config('header_js') );
        }

        global $wp_query; 

        $kera_hash_transient = get_transient( 'kera-hash-time' );
		if ( false === $kera_hash_transient ) {
			$kera_hash_transient = time();
			set_transient( 'kera-hash-time', $kera_hash_transient );
		}

        $config = array(
            'storage_key'  		=> apply_filters( 'kera_storage_key', 'kera_' . md5( get_current_blog_id() . '_' . get_site_url( get_current_blog_id(), '/' ) . get_template() . $kera_hash_transient ) ),
            'quantity_minus'    => apply_filters( 'tbay_quantity_minus', '<i class="zmdi zmdi-minus"></i>'),
            'quantity_plus'     => apply_filters( 'tbay_quantity_plus', '<i class="zmdi zmdi-plus"></i>'),
            'cancel'            => esc_html__('cancel', 'kera'),
            'show_all_text'     => esc_html__('View all', 'kera'),
            'search'            => esc_html__('Search', 'kera'),
            'posts'             => json_encode( $wp_query->query_vars ),    
            'max_page'          => $wp_query->max_num_pages,
            'mobile'            => wp_is_mobile(),
             /*Element ready default callback*/
            'elements_ready'  => array(
                'slick'               => $this->elements_ready_slick(), 
                'ajax_tabs'           => $this->kera_elements_ajax_tabs(),
                'countdowntimer'      => $this->elements_ready_countdown_timer(), 
            ),
            'mobile_title'  => array(
                'mini_cart' => esc_html__('Shopping cart', 'kera')
            )
        );


        if( defined('KERA_WOOCOMMERCE_ACTIVED') && KERA_WOOCOMMERCE_ACTIVED ) {  

            $position                       = ( wp_is_mobile() ) ? 'right' : apply_filters( 'kera_cart_position', 10,2 );
            $woo_mode                       = kera_tbay_woocommerce_get_display_mode();
            // loader gif
            $loader                         = apply_filters( 'tbay_quick_view_loader_gif', KERA_IMAGES . '/ajax-loader.gif' );
     
            $config['current_page']         = get_query_var( 'paged' ) ? get_query_var('paged') : 1;

            $config['popup_cart_icon']      = apply_filters( 'kera_popup_cart_icon', '<i class="zmdi zmdi-close"></i>',2 );
            $config['popup_cart_icon_checked']      = apply_filters( 'kera_popup_cart_icon_checked', '<i class="zmdi zmdi-check"></i>',2 );
            $config['icon_view_cart_popup']      = apply_filters( 'kera_icon_view_cart_popup_checked', '<i class="zmdi zmdi-arrow-right"></i>',2 );
            $config['popup_cart_noti']      = esc_html__('has been added to your cart.', 'kera');

            $config['cart_position']        = $position;
            $config['ajax_update_quantity'] = (bool) kera_tbay_get_config('ajax_update_quantity', false);

            $config['display_mode']         = $woo_mode;

            $config['ajaxurl']              = admin_url( 'admin-ajax.php' );
            $config['loader']               = $loader;

            $config['is_checkout']          =  is_checkout(); 
            $config['checkout_url']         =  wc_get_checkout_url();
            $config['i18n_checkout']        =  esc_html__('Checkout', 'kera');

            $config['ajax_popup_quick']     =  apply_filters( 'kera_ajax_popup_quick', kera_is_ajax_popup_quick() );

            $config['enable_ajax_add_to_cart'] 	= ( get_option('woocommerce_enable_ajax_add_to_cart') === 'yes' ) ? true : false;

            $config['img_class_container']                  =  '.'.kera_get_gallery_item_class();
            $config['thumbnail_gallery_class_element']      =  '.'.kera_get_thumbnail_gallery_item();

            $config['images_mode']        =  apply_filters('kera_woo_display_image_mode', 10, 2);
			$config['single_product']     = apply_filters('kera_active_single_product', is_product(), 10, 2);   
        }

        wp_localize_script( 'kera-script', 'kera_settings', apply_filters('kera_localize_translate', $config) );
    }

    private function elements_ready_slick() {
        $array = [
            'brands', 
            'products', 
            'posts-grid',
            'our-team', 
            'product-category', 
            'product-tabs', 
            'testimonials',
            'product-categories-tabs',
            'list-categories-product',
            'custom-image-list-categories',
            'custom-image-list-tags',
            'product-recently-viewed',
            'product-flash-sales',
            'product-list-tags',
            'product-count-down'
        ];

        return $array; 
    }

    private function kera_elements_ajax_tabs()
    { 
        $array = [ 
            'product-categories-tabs',  
            'product-tabs',
        ];

        return $array;
    }

    private function elements_ready_countdown_timer() {
        $array = [
            'product-flash-sales', 
            'product-count-down'
        ];

        return $array;
    }

    public function footer_scripts() {
        if ( kera_tbay_get_config('footer_js') != "" ) {
            $footer_js = kera_tbay_get_config('footer_js');
            echo trim($footer_js);
        }
    }

    public function remove_fonts_redux_url() {
        $show_typography  = kera_tbay_get_config('show_typography', false);
        if( !$show_typography ) {
            wp_dequeue_style( 'redux-google-fonts-kera_tbay_theme_options' );
        } 
    }

    public function load_admin_login_styles() {
        wp_enqueue_style( 'kera-login-admin', KERA_STYLES . '/admin/login-admin.css', false, '1.0.0' );
    }
    
    public function load_admin_styles() {
        wp_enqueue_style( 'material-design-iconic-font', KERA_STYLES . '/material-design-iconic-font.css', false, '2.2.0' ); 
        wp_enqueue_style( 'kera-custom-admin', KERA_STYLES . '/admin/custom-admin.css', false, '1.0.0' );

        $suffix = (kera_tbay_get_config('minified_js', false)) ? '.min' : KERA_MIN_JS;
        wp_enqueue_script( 'kera-admin-js', KERA_SCRIPTS . '/admin/admin' . $suffix . '.js', array( 'jquery' ), KERA_THEME_VERSION, true );
    }

    /**
     * Register widget area.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function widgets_init() {
        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar Default', 'kera' ),
            'id'            => 'sidebar-default',
            'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'kera' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
        

        /* Check WPML */
        if ( function_exists('icl_object_id') ) {
            register_sidebar( array(
                'name'          => esc_html__( 'WPML Sidebar', 'kera' ),
                'id'            => 'wpml-sidebar',
                'description'   => esc_html__( 'Add widgets here to appear.', 'kera' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ) );
        }
        /* End check WPML */

        register_sidebar( array(
            'name'          => esc_html__( 'Footer', 'kera' ),
            'id'            => 'footer',
            'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'kera' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) ); 

    }

    public function add_cpt_support() {
        $cpt_support = ['tbay_megamenu', 'tbay_footer', 'tbay_header', 'post', 'page', 'product']; 
        update_option( 'elementor_cpt_support', $cpt_support);

        update_option( 'elementor_disable_color_schemes', 'yes'); 
        update_option( 'elementor_disable_typography_schemes', 'yes');
        update_option( 'elementor_container_width', '1200');
        update_option( 'elementor_viewport_lg', '1200'); 
        update_option( 'elementor_space_between_widgets', '0');
    }

    public function edit_post_show_excerpt( $user_login, $user ) {
        update_user_meta( $user->ID, 'metaboxhidden_post', true );
    }
    

    /**
     * Use front-page.php when Front page displays is set to a static page.
     *
     * @param string $template front-page.php.
     *
     * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
     */
    public function front_page_template( $template ) {
        return is_home() ? '' : $template;
    }

    public function setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on kera, use a find and replace
         * to change 'kera' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'kera', KERA_THEMEROOT . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        add_theme_support( "post-thumbnails" );

        add_image_size('kera_avatar_post_carousel', 100, 100, true);

        // This theme styles the visual editor with editor-style.css to match the theme style.
        $font_source = kera_tbay_get_config('show_typography', false);
        if( !$font_source ) {
            add_editor_style( array( 'css/editor-style.css', $this->fonts_url() ) );
        }

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );


        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        
        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'gallery', 'audio' 
        ) );

        $color_scheme  = kera_tbay_get_color_scheme();
        $default_color = trim( $color_scheme[0], '#' );

        // Setup the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'kera_custom_background_args', array(
            'default-color'      => $default_color,
            'default-attachment' => 'fixed',
        ) ) );

        add_action( 'wp_login', array( $this, 'edit_post_show_excerpt'), 10, 2 );

        if( apply_filters('kera_remove_widgets_block_editor', true) ) {
            remove_theme_support( 'block-templates' );
            remove_theme_support( 'widgets-block-editor' );
        }

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary'           => esc_html__( 'Primary Menu', 'kera' ),
            'mobile-menu'       => esc_html__( 'Mobile Menu','kera' ),
            'nav-category-menu'  => esc_html__( 'Nav Category Menu', 'kera' ),
            'track-order'  => esc_html__( 'Tracking Order Menu', 'kera' ),
        ) );

        update_option( 'page_template', 'elementor_header_footer'); 
    }

    public function load_fonts_url() {
        $protocol         = is_ssl() ? 'https:' : 'http:';
        $show_typography  = kera_tbay_get_config('show_typography', false);
        $font_source      = kera_tbay_get_config('font_source', "1");
        $font_google_code = kera_tbay_get_config('font_google_code');
        if( !$show_typography ) {
            wp_enqueue_style( 'kera-theme-fonts', $this->fonts_url(), array(), null );
        } else if ( $font_source == "2" && !empty($font_google_code) ) {
            wp_enqueue_style( 'kera-theme-fonts', $font_google_code, array(), null );
        }
    }

    public function fonts_url() {
        /**
         * Load Google Front
         */

        $fonts_url = '';

        /* Translators: If there are characters in your language that are not
        * supported by Montserrat, translate this to 'off'. Do not translate
        * into your own language.
        */
        $Work_Sans = _x( 'on', 'Work Sans font: on or off', 'kera' );
     
        if ( 'off' !== $Work_Sans ) {
            $font_families = array(); 
     
            if ( 'off' !== $Work_Sans ) {
                $font_families[] = 'Work Sans:400,500,600,700,800&display=swap';
            }           
     
            $query_args = array(
                'family' => ( implode( '%7C', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );
            
            $protocol = is_ssl() ? 'https:' : 'http:';
            $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
        }
     
        return esc_url_raw( $fonts_url );
    }

}

return new kera_setup_theme();