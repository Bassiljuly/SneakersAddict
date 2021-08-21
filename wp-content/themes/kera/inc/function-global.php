<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Kera 1.0
 */
define( 'KERA_THEME_VERSION', '1.0' );

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define( 'KERA_THEME_DIR', 		get_template_directory_uri() );
define( 'KERA_THEMEROOT', 		get_template_directory() );
define( 'KERA_IMAGES', 			KERA_THEME_DIR . '/images' );
define( 'KERA_SCRIPTS', 		KERA_THEME_DIR . '/js' );

define( 'KERA_SCRIPTS_SKINS', 	KERA_SCRIPTS . '/skins' );
define( 'KERA_STYLES', 			KERA_THEME_DIR . '/css' );
define( 'KERA_STYLES_SKINS', 	KERA_STYLES . '/skins' );

define( 'KERA_INC', 				     'inc' );
define( 'KERA_MERLIN', 				    KERA_INC . '/merlin' );
define( 'KERA_CLASSES', 			     KERA_INC . '/classes' );
define( 'KERA_VENDORS', 			     KERA_INC . '/vendors' );
define( 'KERA_ELEMENTOR', 		         KERA_THEMEROOT . '/inc/vendors/elementor' );
define( 'KERA_ELEMENTOR_TEMPLATES',     KERA_THEMEROOT . '/elementor_templates' );
define( 'KERA_PAGE_TEMPLATES',          KERA_THEMEROOT . '/page-templates' );
define( 'KERA_WIDGETS', 			     KERA_INC . '/widgets' );

define( 'KERA_ASSETS', 			         KERA_THEME_DIR . '/inc/assets' );
define( 'KERA_ASSETS_IMAGES', 	         KERA_ASSETS    . '/images' );

define( 'KERA_MIN_JS', 	'' );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

function kera_tbay_get_config($name, $default = '') {
	global $kera_options;
    if ( isset($kera_options[$name]) ) {
        return $kera_options[$name];
    }
    return $default;
}

function kera_tbay_get_global_config($name, $default = '') {
	$options = get_option( 'kera_tbay_theme_options', array() );
	if ( isset($options[$name]) ) {
        return $options[$name];
    }
    return $default;
}
