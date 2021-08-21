<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if( defined('TBAY_ELEMENTOR_ACTIVED') && !TBAY_ELEMENTOR_ACTIVED) return;

if (!class_exists('Kera_Redux_Framework_Config')) {

    class Kera_Redux_Framework_Config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;
        public $output;
        public $default_color; 
        public $default_fonts; 

        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return; 
            }  

            add_action('init', array($this, 'initSettings'), 10);
        }

        public function redux_default_color() 
        {
            $this->default_color = kera_tbay_default_theme_primary_color();
        }
        public function redux_default_theme_fonts()
        {
            $this->default_fonts = kera_tbay_default_theme_primary_fonts();
        }

        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            //Create default color all skins
            $this->redux_default_color();

            $this->redux_default_theme_fonts();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections()
        {
            global $wp_registered_sidebars;
            $sidebars = array();

            $default_color = $this->default_color;
            $default_fonts = $this->default_fonts;

            if ( !empty($wp_registered_sidebars) ) {
                foreach ($wp_registered_sidebars as $sidebar) {
                    $sidebars[$sidebar['id']] = $sidebar['name'];
                }
            }
            $columns = array( 
                '1' => esc_html__('1 Column', 'kera'),
                '2' => esc_html__('2 Columns', 'kera'),
                '3' => esc_html__('3 Columns', 'kera'),
                '4' => esc_html__('4 Columns', 'kera'),
                '5' => esc_html__('5 Columns', 'kera'),
                '6' => esc_html__('6 Columns', 'kera')
            );     

            $aspect_ratio = array( 
                '16_9' => '16:9',
                '4_3' => '4:3',
            );        

            $blog_image_size = array( 
                'thumbnail'         => esc_html__('Thumbnail', 'kera'),
                'medium'            => esc_html__('Medium', 'kera'),
                'large'             => esc_html__('Large', 'kera'),
                'full'              => esc_html__('Full', 'kera'),
            );      
          
            
            // General Settings Tab
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-settings',
                'title' => esc_html__('General', 'kera'),
                'fields' => array(
                    array(
                        'id'        => 'preload',
                        'type'      => 'switch',
                        'title'     => esc_html__('Preload Website', 'kera'),
                        'default'   => false
                    ),
                    array(
                        'id' => 'select_preloader',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Select Preloader', 'kera'),
                        'subtitle' => esc_html__('Choose a Preloader for your website.', 'kera'),
                        'required'  => array('preload','=',true),
                        'options' => array(
                            'loader1' => array(
                                'title' => esc_html__( 'Loader 1', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/preloader/loader1.png'
                            ),         
                            'loader2' => array(
                                'title' => esc_html__( 'Loader 2', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/preloader/loader2.png'
                            ),              
                            'loader3' => array(
                                'title' => esc_html__( 'Loader 3', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/preloader/loader3.png'
                            ),         
                            'loader4' => array(
                                'title' => esc_html__( 'Loader 4', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/preloader/loader4.png'
                            ),          
                            'loader5' => array(
                                'title' => esc_html__( 'Loader 5', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/preloader/loader5.png'
                            ),         
                            'loader6' => array(
                                'title' => esc_html__( 'Loader 6', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/preloader/loader6.png'
                            ),                        
                            'custom_image' => array(
                                'title' => esc_html__( 'Custom image', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/preloader/custom_image.png'
                            ),         
                        ),
                        'default' => 'loader1'
                    ),
                    array(
                        'id' => 'media-preloader',
                        'type' => 'media',
                        'required' => array('select_preloader','=', 'custom_image'),
                        'title' => esc_html__('Upload preloader image', 'kera'),
                        'subtitle' => esc_html__('Image File (.gif)', 'kera'),
                        'desc' =>   sprintf( wp_kses( __('You can download some the Gif images <a target="_blank" href="%1$s">here</a>.', 'kera' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://loading.io/' ), 
                    ),
                    array(
                        'id'            => 'config_media',
                        'type'          => 'switch',
                        'title'         => esc_html__('Enable Config Image Size', 'kera'),
                        'subtitle'      => esc_html__('Config image size in WooCommerce and Media Setting', 'kera'),
                        'default'       => false
                    ),
                    array(
                        'id' => 'ajax_dropdown_megamenu',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Ajax Dropdown" Mega Menu', 'kera'),
                        'default' => false,
                    ),
                )
            ); 
            // Header
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-view-web',
                'title' => esc_html__('Header', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'header_type',
                        'type' => 'select',
                        'title' => esc_html__('Select Header Layout', 'kera'),
                        'options' => kera_tbay_get_header_layouts(),
                        'default' => 'header_default'
                    ),
                    array(
                        'id' => 'media-logo',
                        'type' => 'media',
                        'title' => esc_html__('Upload Logo', 'kera'),
                        'subtitle' => esc_html__('Image File (.png or .gif)', 'kera'),
                    ),
                    array(
                    'id' => 'header_located_on_slider',
                        'type' => 'switch',
                        'title' => esc_html__('Header Located On Slider', 'kera'),
                        'subtitle' => esc_html__('Only home-page','kera'),
                        'default' => true,
                    ),
                )
            );
            
            // Footer
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-border-bottom',
                'title' => esc_html__('Footer', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'footer_type',
                        'type' => 'select',
                        'title' => esc_html__('Select Footer Layout', 'kera'),
                        'options' => kera_tbay_get_footer_layouts(),
 						'default' => 'footer_default'
                    ),
                    array(
                        'id' => 'copyright_text',
                        'type' => 'editor',
                        'title' => esc_html__('Copyright Text', 'kera'),
                        'default' => esc_html__('<p>Copyright  &#64; 2019 Kera Designed by ThemBay. All Rights Reserved.</p>', 'kera'),
                        'required' => array('footer_type','=','footer_default')
                    ),
                    array(
                        'id' => 'back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Back to Top" Button', 'kera'),
                        'default' => true,
                    ),
                )
            );



            // Mobile
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-smartphone-iphone',
                'title' => esc_html__('Mobile', 'kera'),
                'fields' => array(   
                    array(
                        'id' => 'mobile_show_categories',
                        'type' => 'switch',
                        'title' => esc_html__('Enable categories', 'kera'),
                        'default' => true
                    ),   
                    array(
                        'id'       => 'mobile_select_categories',
                        'type'     => 'select',
                        'required' => array('mobile_show_categories','=', true),
                        'options'  => kera_load_list_select_template(),
                        'title'    => esc_html__( 'Choose Template categories', 'kera' ),
                        'subtitle' => esc_html__( 'Choose Template categories of template library elementor', 'kera' ),
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),  
                    array(
                        'id' => 'mobile_show_login',
                        'type' => 'switch',
                        'required' => array('mobile_footer_icon','=', true),
                        'title' => esc_html__('Enable Mobile login', 'kera'),
                        'default' => true
                    ),
                    array(
                        'id' => 'mobile_show_login_popup',
                        'type' => 'switch',
                        'required' => array('mobile_show_login','=', true),
                        'title' => esc_html__('Enable Mobile login popup', 'kera'),
                        'default' => true
                    ),
                )
            );

            // Mobile Header settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Header', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'mobile-logo',
                        'type' => 'media',
                        'title' => esc_html__('Upload Logo', 'kera'),
                        'subtitle' => esc_html__('Image File (.png or .gif)', 'kera'),
                    ),
                    array(
                        'id'        => 'logo_img_width_mobile',
                        'type'      => 'slider',
                        'title'     => esc_html__('Logo maximum width (px)', 'kera'),
                        "default"   => 100,
                        "min"       => 50,
                        "step"      => 1,
                        "max"       => 600,
                    ),
                    array(
                        'id'             => 'logo_mobile_padding',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Logo Padding', 'kera'),
                        'desc'           => esc_html__('Add more spacing around logo.', 'kera'),
                        'default'            => array(
                            'padding-top'     => '',
                            'padding-right'   => '',
                            'padding-bottom'  => '',
                            'padding-left'    => '',
                            'units'          => 'px',
                        ),
                    ),
                    array(
                        'id'        => 'always_display_logo',
                        'type'      => 'switch',
                        'title'     => esc_html__('Always Display Logo', 'kera'),
                        'subtitle'      => esc_html__('Logo displays on all pages (page title is disabled)', 'kera'),
                        'default'   => false
                    ),  
                    array(
                        'id'        => 'hidden_header_el_pro_mobile',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hide Header Elementor Pro', 'kera'),
                        'subtitle'  => esc_html__('Hide Header Elementor Pro on mobile', 'kera'),
                        'default'   => true
                    ),
                )
            );

            // Menu mobile settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Menu Mobile', 'kera'),
                'fields' => array(              
                    array(
                        'id' => 'enable_mmenu_order_tracking', 
                        'type' => 'switch',
                        'title' => esc_html__('Enable Order Tracking', 'kera'),
                        'default' => true
                    ),      
                    array(
                        'id'       => 'mmenu_order_tracking_pages',
                        'type'     => 'select',
                        'data'     => 'pages',
                        'title'    => esc_html__( 'Select Tracking Page', 'kera' ),
                        'required' => array('enable_mmenu_order_tracking','equals', true),
                    ),                
                    array(
                        'id' => 'enable_mmenu_langue', 
                        'type' => 'switch',
                        'title' => esc_html__('Enable Custom Language', 'kera'),
                        'desc'  => esc_html__( 'If you use WPML will appear here', 'kera' ),
                        'default' => true
                    ),                      
                    array(
                        'id' => 'enable_mmenu_currency', 
                        'type' => 'switch',
                        'title' => esc_html__('Enable Currency', 'kera'),
                        'default' => true
                    ),  
                )
            );

             // Mobile Footer settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Footer', 'kera'),
                'fields' => array(                
                    array(
                        'id' => 'mobile_footer',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Desktop Footer', 'kera'),
                        'default' => false
                    ),   
                    array(
                        'id' => 'mobile_back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Back to Top" Button', 'kera'),
                        'default' => false
                    ),                 
                    array(
                        'id' => 'mobile_footer_icon',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Mobile Footer', 'kera'),
                        'default' => true
                    ),
                )
            );     

            // Mobile Search settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Search', 'kera'),
                'fields' => array( 
                    array(
                        'id'=>'mobile_search_type',
                        'type' => 'button_set',
                        'title' => esc_html__('Search Result', 'kera'),
                        'options' => array(
                            'post' => esc_html__('Post', 'kera'), 
                            'product' => esc_html__('Product', 'kera')
                        ),
                        'default' => 'product'
                    ),
                    array(
                        'id' => 'mobile_autocomplete_search',
                        'type' => 'switch',
                        'title' => esc_html__('Auto-complete Search?', 'kera'),
                        'default' => 1
                    ),
                    array(
                        'id'       => 'mobile_search_placeholder',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Placeholder', 'kera' ),
                        'default'  => esc_html__( 'I’m searching for...', 'kera' ),
                    ),   
                    array(
                        'id' => 'mobile_enable_mobile_search_category',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Search in Categories', 'kera'),
                        'default' => true
                    ), 
                    array(
                        'id' => 'mobile_show_search_product_image',
                        'type' => 'switch',
                        'title' => esc_html__('Show Image of Search Result', 'kera'),
                        'required' => array('mobile_autocomplete_search', '=', '1'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'mobile_show_search_product_price',
                        'type' => 'switch',
                        'title' => esc_html__('Show Price of Search Result', 'kera'),
                        'required' => array(array('mobile_autocomplete_search', '=', '1'), array('mobile_search_type', '=', 'product')),
                        'default' => true
                    ),  
                    array(
                        'id' => 'mobile_search_min_chars',
                        'type'  => 'slider',
                        'title' => esc_html__('Search Min Characters', 'kera'),
                        'default' => 2,
                        'min'   => 1,
                        'step'  => 1,
                        'max'   => 6,
                    ), 
                    array(
                        'id' => 'mobile_search_max_number_results',
                        'type'  => 'slider',
                        'title' => esc_html__('Number of Search Results', 'kera'),
                        'desc'  => esc_html__( 'Max number of results show in Mobile', 'kera' ),
                        'default' => 5,
                        'min'   => 2,
                        'step'  => 1,
                        'max'   => 20,
                    ), 
                )
            ); 
        

            // Mobile Woocommerce settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Mobile WooCommerce', 'kera'),
                'fields' => array(                
                    array(
                        'id' => 'mobile_product_number',
                        'type' => 'image_select',
                        'title' => esc_html__('Product Column in Shop page', 'kera'),
                        'options' => array(
                            'one' => array(
                                'title' => esc_html__( 'One Column', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/mobile/one_column.jpg'
                            ),                            
                            'two' => array(
                                'title' => esc_html__( 'Two Columns', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/mobile/two_columns.jpg'
                            ),
                        ),
                        'default' => 'two'
                    ),  
					array(
                        'id' => 'enable_add_cart_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show "Add to Cart" Button', 'kera'),
                        'subtitle' => esc_html__('On Home and page Shop', 'kera'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_wishlist_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show "Wishlist" Button', 'kera'),
                        'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'kera'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_one_name_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Full Product Name', 'kera'),
                        'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'kera'),
                        'default' => false
                    ),
					array(
                        'id' => 'enable_quantity_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Quantity', 'kera'),
                        'subtitle' => esc_html__('On Page Single Product', 'kera'),
                        'default' => true
                    ),                  
                    array(
                        'id' => 'enable_tabs_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Display Tab as Popup', 'kera'),
                        'subtitle' => esc_html__('On Page Single Product', 'kera'),
                        'default' => true
                    ),
                )
            );

            // Style
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-format-color-text',
                'title' => esc_html__('Style', 'kera'),
            ); 

            // Style
            $this->sections[] = array(
                'title' => esc_html__('Main', 'kera'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'boby_bg',
                        'type'     => 'background',
                        'output'   => array( 'body' ),
                        'title'    => esc_html__( 'Body Background', 'kera' ),
                        'subtitle' => esc_html__( 'Body background with image, color, etc.', 'kera' ),
                    ),
                    array (
                        'title' => esc_html__('Theme Main Color', 'kera'),
                        'id' => 'main_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => $default_color['main_color'],
                    ),                    
                    array (
                        'title' => esc_html__('Theme Main Color Second', 'kera'),
                        'subtitle' => '<em>'.esc_html__('The main color second of the site.', 'kera').'</em>',
                        'id' => 'main_color_second',
                        'type' => 'color', 
                        'transparent' => false,
                        'default' => $default_color['main_color_second'],
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Typography', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'show_typography',
                        'type' => 'switch',
                        'title' => esc_html__('Edit Typography', 'kera'),
                        'default' => false
                    ),
                    array(
                        'title'    => esc_html__('Font Source', 'kera'),
                        'id'       => 'font_source',
                        'type'     => 'radio',
                        'required' => array('show_typography','=', true),
                        'options'  => array(
                            '1' => 'Standard + Google Webfonts',
                            '2' => 'Google Custom',
                            '3' => 'Custom Fonts'
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'font_google_code',
                        'type' => 'text',
                        'title' => esc_html__('Google Link', 'kera'), 
                        'subtitle' => '<em>'.esc_html__('Paste the provided Google Code', 'kera').'</em>',
                        'default' => '',
                        'desc' => esc_html__('e.g.: https://fonts.googleapis.com/css?family=Open+Sans', 'kera'),
                        'required' => array('font_source','=','2')
                    ),

                    array (
                        'id' => 'main_custom_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;">'. sprintf(
                                                                    '%1$s <a href="%2$s">%3$s</a>',
                                                                    esc_html__( 'Video guide custom font in ', 'kera' ),
                                                                    esc_url( 'https://www.youtube.com/watch?v=ljXAxueAQUc' ),
                                                                    esc_html__( 'here', 'kera' )
                                ) .'</h3>',
                        'required' => array('font_source','=','3')
                    ),

                    array (
                        'id' => 'main_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Main Font', 'kera').'</h3>',
                        'required' => array('show_typography','=', true),
                    ),                    

                    // Standard + Google Webfonts
                    array (
                        'title' => esc_html__('Font Face', 'kera'),
                        'id' => 'main_font',
                        'type' => 'typography',
                        'line-height' => false,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'all_styles'=> true,
                        'font-size' => false,
                        'color' => false,
                        'default' => array (
                            'font-family' => '',
                            'subsets' => '',
                        ),
                        'required' => array( 
                            array('font_source','=','1'), 
                            array('show_typography','=', true) 
                        )
                    ),
                    
                    // Google Custom                        
                    array (
                        'title' => esc_html__('Google Font Face', 'kera'),
                        'subtitle' => '<em>'.esc_html__('Enter your Google Font Name for the theme\'s Main Typography', 'kera').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'kera'),
                        'id' => 'main_google_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array( 
                            array('font_source','=','2'), 
                            array('show_typography','=', true) 
                        )
                    ),                    

                    // main Custom fonts                      
                    array (
                        'title' => esc_html__('Main custom Font Face', 'kera'),
                        'subtitle' => '<em>'.esc_html__('Enter your Custom Font Name for the theme\'s Main Typography', 'kera').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'kera'),
                        'id' => 'main_custom_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array( 
                            array('font_source','=','3'), 
                            array('show_typography','=', true) 
                        )
                    ),
                )
            );

            // Style
            $this->sections[] = array(
                'title' => esc_html__('Header Mobile', 'kera'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'header_mobile_bg',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Header Mobile Background', 'kera' ),
                        'transparent' => false,
                    ),
                    array (
                        'title' => esc_html__('Header Color', 'kera'),
                        'id' => 'header_mobile_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),                    
                )
            );


            // WooCommerce
            $this->sections[] = array(
                'icon' => 'el el-shopping-cart',
                'title' => esc_html__('WooCommerce', 'kera'),
                'fields' => array(       
                    array(
                        'title'    => esc_html__('Label Sale Format', 'kera'),
                        'id'       => 'sale_tags',
                        'type'     => 'radio',
                        'options'  => array(
                            'Sale!' => esc_html__('Sale!' ,'kera'),
                            'Save {percent-diff}%' => esc_html__('Save {percent-diff}% (e.g "Save 50%")' ,'kera'),
                            'Save {symbol}{price-diff}' => esc_html__('Save {symbol}{price-diff} (e.g "Save $50")' ,'kera'),
                            'custom' => esc_html__('Custom Format (e.g -50%, -$50)' ,'kera')
                        ),
                        'default' => 'custom'
                    ),
                    array(
                        'id'        => 'sale_tag_custom',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Custom Format', 'kera' ),
                        'desc'      => esc_html__('{price-diff} inserts the dollar amount off.', 'kera'). '</br>'.
                                       esc_html__('{percent-diff} inserts the percent reduction (rounded).', 'kera'). '</br>'.
                                       esc_html__('{symbol} inserts the Default currency symbol.', 'kera'), 
                        'required'  => array('sale_tags','=', 'custom'),
                        'default'   => '-{percent-diff}%'
                    ), 
                    array(
                        'id' => 'enable_label_featured',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Featured" Label', 'kera'),
                        'default' => true
                    ),   
                    array(
                        'id'        => 'custom_label_featured',
                        'type'      => 'text',
                        'title'     => esc_html__( '"Featured Label" Custom Text', 'kera' ),
                        'required'  => array('enable_label_featured','=', true),
                        'default'   => esc_html__('Featured', 'kera')
                    ),
                    
                    array(
                        'id' => 'enable_brand',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Brand Name', 'kera'),
                        'subtitle' => esc_html__('Enable/Disable brand name on HomePage and Shop Page', 'kera'),
                        'default' => false
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),            
                    array(
                        'id' => 'product_display_image_mode',
                        'type' => 'image_select',
                        'title' => esc_html__('Product Image Display Mode', 'kera'),
                        'options' => array(
                            'one' => array(
                                'title' => esc_html__( 'Single Image', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/image_mode/single-image.png'
                            ),                                  
                            'two' => array(
                                'title' => esc_html__( 'Double Images (Hover)', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/image_mode/display-hover.gif'
                            ),                                                                         
                            'slider' => array(
                                'title' => esc_html__( 'Images (carousel)', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/image_mode/display-carousel.gif'
                            ),                                                      
                        ),
                        'default' => 'slider'
                    ),
                    array(
                        'id' => 'enable_quickview',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Quick View', 'kera'),
                        'default' => 1
                    ),                      
                    array(
                        'id' => 'enable_checkout_steps',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Checkout steps', 'kera'),
                        'default' => 1
                    ),                    
                    array(
                        'id' => 'enable_woocommerce_catalog_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Show WooCommerce Catalog Mode', 'kera'),
                        'default' => false
                    ),                     
                    array(
                        'id' => 'ajax_update_quantity',
                        'type' => 'switch',
                        'title' => esc_html__('Quantity Ajax Auto-update', 'kera'),
                        'subtitle' => esc_html__('Enable/Disable quantity ajax auto-update on page Cart', 'kera'),
                        'default' => true
                    ),   
					array(
                        'id' => 'enable_variation_swatch',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Product Variation Swatch', 'kera'),
                        'subtitle' => esc_html__('Enable/Disable Product Variation Swatch on HomePage and Shop page', 'kera'),
                        'default' => true
                    ), 
                    array(
                        'id' => 'variation_swatch',
                        'type' => 'select',
                        'title' => esc_html__('Product Attribute', 'kera'),
                        'options' => kera_tbay_get_variation_swatchs(),
                        'default' => ''
                    ),  					                
                )
            );

            // woocommerce Breadcrumb settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Mini Cart', 'kera'),
                'fields' => array(
                     array(
                        'id' => 'woo_mini_cart_position',
                        'type' => 'select', 
                        'title' => esc_html__('Mini-Cart Position', 'kera'),
                        'options' => array( 
                            'left'       => esc_html__('Left', 'kera'),
                            'right'      => esc_html__('Right', 'kera'),
                            'popup'      => esc_html__('Popup', 'kera'),
                            'no-popup'   => esc_html__('None Popup', 'kera')
                        ),
                        'default' => 'popup'
                    ), 
                )
            ); 

            // woocommerce Breadcrumb settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Breadcrumb', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'show_product_breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Breadcrumb', 'kera'),
                        'default' => true
                    ),
                    array(
                        'id' => 'product_breadcrumb_layout',
                        'type' => 'image_select',
                        'class'     => 'image-two',
                        'compiler' => true,
                        'title' => esc_html__('Breadcrumb Layout', 'kera'),
                        'required' => array('show_product_breadcrumb','=',1),
                        'options' => array(                          
                            'image' => array(
                                'title' => esc_html__( 'Background Image', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                            ),
                            'color' => array(
                                'title' => esc_html__( 'Background color', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                            ),
                            'text'=> array(
                                'title' => esc_html__( 'Text Only', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                            ),
                        ),
                        'default' => 'color'
                    ),
                    array (
                        'title' => esc_html__('Breadcrumb Background Color', 'kera'),
                        'subtitle' => '<em>'.esc_html__('The Breadcrumb background color of the site.', 'kera').'</em>',
                        'id' => 'woo_breadcrumb_color',
                        'required' => array('product_breadcrumb_layout','=',array('default','color')),
                        'type' => 'color',
                        'default' => '#fff',
                        'transparent' => false,
                    ),
                    array( 
                        'id' => 'woo_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumb Background', 'kera'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your Breadcrumb.', 'kera'),
                        'required' => array('product_breadcrumb_layout','=','image'),
                        'default'  => array( 
                            'url'=> KERA_IMAGES .'/breadcrumbs-woo.jpg'
                        ),
                    ),
                )
            ); 

            // WooCommerce Archive settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Shop', 'kera'),
                'fields' => array(       
                    array(
                        'id' => 'product_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Shop Layout', 'kera'),
                        'options' => array(
                            'shop-left' => array(
                                'title' => esc_html__( 'Left Sidebar', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/product_archives/shop_left_sidebar.jpg'
                            ),                                  
                            'shop-right' => array(
                                'title' => esc_html__( 'Right Sidebar', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/product_archives/shop_right_sidebar.jpg'
                            ),                                                                         
                            'full-width' => array(
                                'title' => esc_html__( 'No Sidebar', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/product_archives/shop_no_sidebar.jpg'
                            ),                                                      
                        ),
                        'default' => 'shop-left'
                    ),
                    array(
                        'id' => 'product_archive_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Sidebar', 'kera'),
                        'options' => $sidebars,
                        'default' => 'product-archive'
                    ),
                    array(
                        'id' => 'show_product_top_archive',
                        'type' => 'switch',
                        'title' => esc_html__('Show sidebar Top Archive product', 'kera'),
                        'default' => false
                    ),   
                    array(
                        'id' => 'enable_display_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Products Display Mode', 'kera'),
                        'subtitle' => esc_html__('Enable/Disable Display Mode', 'kera'),
                        'default' => true
                    ),   
                    array(
                        'id' => 'product_display_mode',
                        'type' => 'button_set',
                        'title' => esc_html__('Products Display Mode', 'kera'),
                        'required' => array('enable_display_mode','=',1),
                        'options' => array(
                            'grid' => esc_html__('Grid', 'kera'), 
                            'list' => esc_html__('List', 'kera')
                        ),
                        'default' => 'grid'
                    ),                                
                    array(
                        'id' => 'title_product_archives',
                        'type' => 'switch',
                        'title' => esc_html__('Show Title of Categories', 'kera'),
                        'default' => false 
                    ),                       
                    array(
                        'id' => 'pro_des_image_product_archives',
                        'type' => 'switch',
                        'title' => esc_html__('Show Description, Image of Categories', 'kera'),
                        'default' => true
                    ),
                    array(
                        'id' => 'number_products_per_page',
                        'type' => 'slider',
                        'title' => esc_html__('Number of Products Per Page', 'kera'),
                        'default' => 12,
                        'min' => 1,
                        'step' => 1,
                        'max' => 100,
                    ),
                    array(
                        'id' => 'product_columns',
                        'type' => 'select',
                        'title' => esc_html__('Product Columns', 'kera'),
                        'options' => $columns,
                        'default' => 3
                    ),
                    array(
                        'id' => 'product_type_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Shop by Product Type', 'kera'),
                        'default' => 0
                    ),                     
                    array(
                        'id' => 'product_per_page_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Number of Product', 'kera'),
                        'default' => 0
                    ),                       
                    array(
                        'id' => 'product_category_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Shop by Categories', 'kera'),
                        'default' => 0
                    ),                    
                )
            );
            // Product Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Product', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'product_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Select Single Product Layout', 'kera'),
                        'options' => array(
                            'vertical' => array(
                                'title' => esc_html__('Image Vertical', 'kera'),
                                'img' => KERA_ASSETS_IMAGES . '/product_single/verical_thumbnail.jpg'
                            ),                             
                            'horizontal' => array(
                                'title' => esc_html__('Image Horizontal', 'kera'),
                                'img' => KERA_ASSETS_IMAGES . '/product_single/horizontal_thumbnail.jpg'
                            ),                                                                                  
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'kera'),
                                'img' => KERA_ASSETS_IMAGES . '/product_single/left_main_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'kera'),
                                'img' => KERA_ASSETS_IMAGES . '/product_single/main_right_sidebar.jpg'
                            ),
                        ),
                        'default' => 'horizontal'
                    ),                   
                    array(
                        'id' => 'product_single_sidebar',
                        'type' => 'select',
                        'required' => array('product_single_layout','=',array('left-main','main-right')),
                        'title' => esc_html__('Single Product Sidebar', 'kera'),
                        'options' => $sidebars,
                        'default' => 'product-single'
                    ),
                )
            );


            // Product Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Product Advanced Options', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'enable_total_sales',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Total Sales', 'kera'),
                        'default' => true
                    ),                     
                    array(
                        'id' => 'enable_buy_now',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Buy Now', 'kera'),
                        'default' => false
                    ),      
                    array( 
                        'id' => 'redirect_buy_now',
                        'required' => array('enable_buy_now','=',true),
                        'type' => 'button_set',
                        'title' => esc_html__('Redirect to page after Buy Now', 'kera'),
                        'options' => array( 
                                'cart'          => 'Page Cart',
                                'checkout'      => 'Page CheckOut',
                        ),
                        'default' => 'cart'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),   
                    array(
                        'id' => 'style_single_tabs_style',
                        'type' => 'button_set',
                        'title' => esc_html__('Tab Mode', 'kera'),
                        'options' => array(
                                'fulltext'          => 'Full Text',
                                'tabs'          => 'Tabs',
                                'accordion'        => 'Accordion',
                        ),
                        'default' => 'fulltext'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'enable_size_guide',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Size Guide', 'kera'),
                        'default' => 1
                    ),
                    array(
                        'id'       => 'size_guide_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Size Guide Title', 'kera' ),
                        'required' => array('enable_size_guide','=', true),
                        'default'  => esc_html__( 'Size chart', 'kera' ),
                    ),    
                    array(
                        'id'       => 'size_guide_icon',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Size Guide Icon', 'kera' ),
                        'required' => array('enable_size_guide','=', true),
                        'desc'       => esc_html__( 'Enter icon name of fonts: ', 'kera' ) . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons/" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/material-design-iconic/" target="_blank">Material Design Iconic</a>',
                        'default'  => 'zmdi zmdi-format-align-right',
                    ),                
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                   array(
                        'id' => 'show_product_nav',
                        'type' => 'switch', 
                        'title' => esc_html__('Enable Product Navigator', 'kera'),
                        'default' => true
                    ),        
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),    
                    array(
                        'id' => 'enable_sticky_menu_bar',
                        'type' => 'switch',
                        'title' => esc_html__('Sticky Menu Bar', 'kera'),
                        'subtitle' => esc_html__('Enable/disable Sticky Menu Bar', 'kera'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_zoom_image',
                        'type' => 'switch',
                        'title' => esc_html__('Zoom inner image', 'kera'),
                        'subtitle' => esc_html__('Enable/disable Zoom inner Image', 'kera'),
                        'default' => false
                    ),    
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide', 
                        'type' => 'divide'
                    ),                 
                    array(
                        'id' => 'video_aspect_ratio',
                        'type' => 'select',
                        'title' => esc_html__('Featured Video Aspect Ratio', 'kera'),
                        'subtitle' => esc_html__('Choose the aspect ratio for your video', 'kera'),
                        'options' => $aspect_ratio,
                        'default' => '16_9'
                    ),     
                    array(
                        'id'      => 'video_position',
                        'title'    => esc_html__( 'Featured Video Position', 'kera' ),
                        'type'    => 'select',
                        'default' => 'last',
                        'options' => array(
                            'last' => esc_html__( 'The last product gallery', 'kera' ),
                            'first' => esc_html__( 'The first product gallery', 'kera' ),
                        ),
                    ),  
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),              
                    array(
                        'id' => 'enable_product_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Social Share', 'kera'),
                        'subtitle' => esc_html__('Enable/disable Social Share', 'kera'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_review_tab',
                        'type' => 'switch',
                        'title' => esc_html__('Product Review Tab', 'kera'),
                        'subtitle' => esc_html__('Enable/disable Review Tab', 'kera'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_releated',
                        'type' => 'switch',
                        'title' => esc_html__('Products Releated', 'kera'),
                        'subtitle' => esc_html__('Enable/disable Products Releated', 'kera'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_upsells',
                        'type' => 'switch',
                        'title' => esc_html__('Products upsells', 'kera'),
                        'subtitle' => esc_html__('Enable/disable Products upsells', 'kera'),
                        'default' => true
                    ),                    
                    array(
                        'id' => 'enable_product_countdown',
                        'type' => 'switch',
                        'title' => esc_html__('Products Countdown', 'kera'),
                        'subtitle' => esc_html__('Enable/disable Products Countdown', 'kera'),
                        'default' => true
                    ),
                    array(
                        'id' => 'number_product_thumbnail',
                        'type'  => 'slider',
                        'title' => esc_html__('Number Images Thumbnail to show', 'kera'),
                        'default' => 4,
                        'min'   => 2,
                        'step'  => 1,
                        'max'   => 5,
                    ),  
                    array(
                        'id' => 'number_product_releated',
                        'type' => 'slider',
                        'title' => esc_html__('Number of related products to show', 'kera'),
                        'default' => 8,
                        'min' => 1,
                        'step' => 1,
                        'max' => 20,
                    ),                    
                    array(
                        'id' => 'releated_product_columns',
                        'type' => 'select',
                        'title' => esc_html__('Releated Products Columns', 'kera'),
                        'options' => $columns,
                        'default' => 4
                    ),
                    array(
                        'id'       => 'html_before_add_to_cart_btn',
                        'type'     => 'textarea',
                        'title'    => esc_html__( 'HTML before Add To Cart button (Global)', 'kera' ),
                        'desc'     => esc_html__( 'Enter HTML and shortcodes that will show before Add to cart selections.', 'kera' ),
                    ),
                    array(
                        'id'       => 'html_after_add_to_cart_btn',
                        'type'     => 'textarea',
                        'title'    => esc_html__( 'HTML after Add To Cart button (Global)', 'kera' ),
                        'desc'     => esc_html__( 'Enter HTML and shortcodes that will show after Add to cart button.', 'kera' ),
                    ),
                )

            );
            // woocommerce Menu Account settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Account', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'show_confirm_password',
                        'type' => 'switch',
                        'title' => esc_html__('Show Confirm Password', 'kera'),
                        'default' => true
                    ),  
                    array(
                        'id' => 'show_woocommerce_password_strength',
                        'type' => 'switch',
                        'title' => esc_html__('Show Password Strength Meter', 'kera'),
                        'default' => true
                    ),  
                )
            );


            // woocommerce Multi-vendor settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Multi-vendor', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'show_vendor_name',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Vendor Name', 'kera'),
                        'subtitle' => esc_html__('Enable/Disable Vendor Name on HomePage and Shop page', 'kera'),
                        'default' => true
                    ),  
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'show_info_vendor_tab',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Tab Info Vendor', 'kera'),
                        'subtitle' => esc_html__('Enable/Disable tab Info Vendor on Product Detail', 'kera'),
                        'default' => true
                    ), 
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id'        => 'show_seller_tab',
                        'type'      => 'none',
                        'title'     => esc_html__('Enable/Disable Tab Products Seller', 'kera'),
                        'subtitle'  => sprintf(__('Go to the <a href="%s" target="_blank">Setting</a> of each Seller to Enable/Disable this tab.', 'kera'), home_url('dashboard/settings/store/')),
                    ),
                    array(
                        'id' => 'seller_tab_per_page',
                        'type' => 'slider',
                        'title' => esc_html__('Dokan Number of Products Seller Tab', 'kera'),
                        'default' => 4,
                        'min' => 1,
                        'step' => 1,
                        'max' => 10,
                    ),
                    array(
                        'id' => 'seller_tab_columns',
                        'type' => 'select',
                        'title' => esc_html__('Dokan Product Columns Seller Tab', 'kera'),
                        'options' => $columns,
                        'default' => 4
                    ),
                )
            );

            // Blog settings
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-border-color',
                'title' => esc_html__('Blog', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'show_blog_breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumb', 'kera'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'blog_breadcrumb_layout',
                        'type' => 'image_select',
                        'class'     => 'image-two',
                        'compiler' => true,
                        'title' => esc_html__('Select Breadcrumb Blog Layout', 'kera'),
                        'required' => array('show_blog_breadcrumb','=',1),
                        'options' => array(                        
                            'image' => array(
                                'title' => esc_html__( 'Background Image', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                            ),
                            'color' => array(
                                'title' => esc_html__( 'Background color', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                            ),
                            'text'=> array(
                                'title' => esc_html__( 'Text Only', 'kera' ),
                                'img'   => KERA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                            ),
                        ),
                        'default' => 'color'
                    ),
                    array (
                        'title' => esc_html__('Breadcrumb Background Color', 'kera'),
                        'id' => 'blog_breadcrumb_color',
                        'type' => 'color',
                        'default' => '#fafafa',
                        'transparent' => false,
                        'required' => array('blog_breadcrumb_layout','=',array('default','color')),
                    ),
                    array(
                        'id' => 'blog_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumb Background Image', 'kera'),
                        'subtitle' => esc_html__('Image File (.png or .jpg)', 'kera'),
                        'default'  => array(
                            'url'=> KERA_IMAGES .'/breadcrumbs-blog.jpg'
                        ),
                        'required' => array('blog_breadcrumb_layout','=','image'),
                    ),
                )
            );

            // Archive Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog Article', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'blog_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Blog Layout', 'kera'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__( 'Articles', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/blog_archives/blog_no_sidebar.jpg'
                            ),
                            'left-main' => array(
                                'title' => esc_html__( 'Articles - Left Sidebar', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/blog_archives/blog_left_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__( 'Articles - Right Sidebar', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/blog_archives/blog_right_sidebar.jpg'
                            ),                   
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'blog_archive_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Blog Archive Sidebar', 'kera'),
                        'options' => $sidebars,
                        'default' => 'blog-archive-sidebar',
                        'required' => array('blog_archive_layout','!=','main'),
                    ),
                    array(
                        'id' => 'blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Post Column', 'kera'),
                        'options' => $columns,
                        'default' => '2'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),   
                    array(
                        'id' => 'image_position',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Post Image Position', 'kera'),
                        'options' => array(
                            'top' => array(
                                'title' => esc_html__( 'Top', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/blog_archives/image_top.jpg'
                            ),
                            'left' => array(
                                'title' => esc_html__( 'Left', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/blog_archives/image_left.jpg'
                            ),                  
                        ),
                        'default' => 'top'
                    ),                 
                    array(
                        'id' => 'blog_image_sizes',
                        'type' => 'select',
                        'title' => esc_html__('Post Image Size', 'kera'),
                        'options' => $blog_image_size,
                        'default' => 'full'
                    ),                 
                    array(
                        'id' => 'enable_date',
                        'type' => 'switch',
                        'title' => esc_html__('Date', 'kera'),
                        'default' => true
                    ),                    
                    array(
                        'id' => 'enable_author',
                        'type' => 'switch',
                        'title' => esc_html__('Author', 'kera'),
                        'default' => false
                    ),                        
                    array(
                        'id' => 'enable_categories',
                        'type' => 'switch',
                        'title' => esc_html__('Categories', 'kera'),
                        'default' => true
                    ),                                            
                    array(
                        'id' => 'enable_comment',
                        'type' => 'switch',
                        'title' => esc_html__('Comment', 'kera'),
                        'default' => true
                    ),                    
                    array(
                        'id' => 'enable_comment_text',
                        'type' => 'switch',
                        'title' => esc_html__('Comment Text', 'kera'),
                        'required' => array('enable_comment', '=', true),
                        'default' => false
                    ),                    
                    array(
                        'id' => 'enable_short_descriptions',
                        'type' => 'switch',
                        'title' => esc_html__('Short descriptions', 'kera'),
                        'default' => false
                    ),                    
                    array(
                        'id' => 'enable_readmore',
                        'type' => 'switch',
                        'title' => esc_html__('Read More', 'kera'),
                        'default' => false
                    ),
                    array(
                        'id' => 'text_readmore',
                        'type' => 'text',
                        'title' => esc_html__('Button "Read more" Custom Text', 'kera'),
                        'required' => array('enable_readmore', '=', true),
                        'default' => 'Continue Reading',
                    ),
                )
            );

            // Single Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog Post', 'kera'),
                'fields' => array(
                    
                    array(
                        'id' => 'blog_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Blog Single Layout', 'kera'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__( 'Main Only', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/single _post/main.jpg'
                            ),
                            'left-main' => array(
                                'title' => esc_html__( 'Left - Main Sidebar', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/single _post/left_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__( 'Main - Right Sidebar', 'kera' ),
                                'img' => KERA_ASSETS_IMAGES . '/single _post/right_sidebar.jpg'
                            ),
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'blog_single_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Blog Sidebar', 'kera'),
                        'options'   => $sidebars,
                        'default'   => 'blog-single-sidebar',
                        'required' => array('blog_single_layout','!=','main'),
                    ),
                    array(
                        'id' => 'show_blog_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Share', 'kera'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_blog_releated',
                        'type' => 'switch',
                        'title' => esc_html__('Show Related Posts', 'kera'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'number_blog_releated',
                        'type' => 'slider',
                        'title' => esc_html__('Number of Related Posts', 'kera'),
                        'required' => array('show_blog_releated', '=', '1'),
                        'default' => 4,
                        'min' => 1,
                        'step' => 1,
                        'max' => 20,
                    ),
                    array(
                        'id' => 'releated_blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns of Related Posts', 'kera'),
                        'required' => array('show_blog_releated', '=', '1'),
                        'options' => $columns,
                        'default' => 2
                    ),

                )
            );

            // Social Media
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-share',
                'title' => esc_html__('Social Share', 'kera'),
                'fields' => array(
                    array(
                        'id' => 'enable_code_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Code Share', 'kera'),
                        'default' => true
                    ),
                    array(
                        'id'       => 'select_share_type',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Please select a sharing type', 'kera' ),
                        'required'  => array('enable_code_share','=', true),
                        'options'  => array(
                            'custom' => 'TB Share',
                            'addthis' => 'Add This',
                        ),
                        'default'  => 'custom'
                    ),
                    array(
                        'id'        =>'code_share',
                        'type'      => 'textarea',
                        'required'  => array('select_share_type','=', 'addthis'),
                        'title'     => esc_html__('"Addthis" Your Code', 'kera'), 
                        'desc'      => esc_html__('You get your code share in https://www.addthis.com', 'kera'),
                        'validate'  => 'html_custom',
                        'default'   => '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59f2a47d2f1aaba2"></script>'
                    ),
                    array(
                        'id'       => 'sortable_sharing',
                        'type'     => 'sortable',
                        'mode'     => 'checkbox',
                        'title'    => esc_html__( 'Sortable Sharing', 'kera' ),
                        'required'  => array('select_share_type','=', 'custom'),
                        'options'  => array(
                            'facebook'      => 'Facebook',
                            'twitter'       => 'Twitter',
                            'linkedin'      => 'Linkedin',
                            'vkontakte'     => 'Vkontakte',
                            'pinterest'     => 'Pinterest',
                            'whatsapp'      => 'Whatsapp',
                            'email'         => 'Email',
                        ),
                        'default'   => array(
                            'facebook'  => true,
                            'twitter'   => true,
                            'linkedin'  => true,
                            'vkontakte' => true,
                            'pinterest' => false,
                            'whatsapp'  => false,
                            'email'     => true,
                        )
                    ),
                )
            );

            // Performance
            $this->sections[] = array(
                'icon' => 'el-icon-cog',
                'title' => esc_html__('Performance', 'kera'),
            );   
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Performance', 'kera'),
                'fields' => array(
                    array (
                        'id'       => 'minified_js',
                        'type'     => 'switch',
                        'title'    => esc_html__('Include minified JS', 'kera'),
                        'subtitle' => esc_html__('Minified version of functions.js and device.js file will be loaded', 'kera'),
                        'default' => true
                    ),
                )
            );

            // Custom Code
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-code-setting',
                'title' => esc_html__('Custom CSS/JS', 'kera'),
            );            

            // Css Custom Code
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Custom CSS', 'kera'),
                'fields' => array(
                    array (
                        'title' => esc_html__('Global Custom CSS', 'kera'),
                        'id' => 'custom_css',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for desktop', 'kera'),
                        'id' => 'css_desktop',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for tablet', 'kera'),
                        'id' => 'css_tablet',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for mobile landscape', 'kera'),
                        'id' => 'css_wide_mobile',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for mobile', 'kera'),
                        'id' => 'css_mobile',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                )
            );

            // Js Custom Code
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Custom Js', 'kera'),
                'fields' => array(
                    array (
                        'title' => esc_html__('Header JavaScript Code', 'kera'),
                        'subtitle' => '<em>'.esc_html__('Paste your custom JS code here. The code will be added to the header of your site.', 'kera').'<em>',
                        'id' => 'header_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                    
                    array (
                        'title' => esc_html__('Footer JavaScript Code', 'kera'),
                        'subtitle' => '<em>'.esc_html__('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'kera').'<em>',
                        'id' => 'footer_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                )
            );



            $this->sections[] = array(
                'title' => esc_html__('Import / Export', 'kera'),
                'desc' => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'kera'),
                'icon' => 'zmdi zmdi-download',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => 'Import Export',
                        'subtitle' => 'Save and restore your Redux options',
                        'full_width' => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );
        }
		
		
		
		
        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
		 
		 /**
     * Custom function for the callback validation referenced above
     * */
		
		 
        public function setArguments()
        {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'kera_tbay_theme_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Kera Options', 'kera'),
                'page_title' => esc_html__('Kera Options', 'kera'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => false,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'kera-admin-icon',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => 'kera_options',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
				'forced_dev_mode_off' => false,
                // Show the time the page took to load, etc
                'update_notice' => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => 61,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon' => '',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => false,
                // REMOVE

                // HINTS
                'hints' => array(
                    'icon' => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => '',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave',
                        ),
                    ),
                )
            );
            
            $this->args['intro_text'] = '';

            // Add content after the form.
            $this->args['footer_text'] = '';
            return $this->args;
			
			if ( ! function_exists( 'redux_validate_callback_function' ) ) {
				function redux_validate_callback_function( $field, $value, $existing_value ) {
					$error   = false;
					$warning = false;

					//do your validation
					if ( $value == 1 ) {
						$error = true;
						$value = $existing_value;
					} elseif ( $value == 2 ) {
						$warning = true;
						$value   = $existing_value;
					}

					$return['value'] = $value;

					if ( $error == true ) {
						$field['msg']    = 'your custom error message';
						$return['error'] = $field;
					}

					if ( $warning == true ) {
						$field['msg']      = 'your custom warning message';
						$return['warning'] = $field;
					}

					return $return;
				}
			}
			
        }
    }

    global $reduxConfig;
    $reduxConfig = new Kera_Redux_Framework_Config();
	
}