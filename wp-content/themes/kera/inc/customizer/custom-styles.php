<?php

//convert hex to rgb
if ( !function_exists ('kera_tbay_getbowtied_hex2rgb') ) {
	function kera_tbay_getbowtied_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb); // returns the rgb values separated by commas
		//return $rgb; // returns an array with the rgb values
	}
}


if ( !function_exists ('kera_tbay_color_lightens_darkens') ) {
	/**
	 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
	 * @param str $hex Colour as hexadecimal (with or without hash);
	 * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
	 * @return str Lightened/Darkend colour as hexadecimal (with hash);
	 */
	function kera_tbay_color_lightens_darkens( $hex, $percent ) {
		
		// validate hex string
		if( empty($hex) ) return $hex;
		
		$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
		$new_hex = '#';
		
		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}
		
		// convert to decimal and change luminosity
		for ($i = 0; $i < 3; $i++) {
			$dec = hexdec( substr( $hex, $i*2, 2 ) );
			$dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
			$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
		}		
		
		return $new_hex;
	}
}

if ( !function_exists ('kera_tbay_default_theme_primary_color') ) {
	function kera_tbay_default_theme_primary_color() {

		$theme_color = array();

		$theme_color['main_color'] 			= 'rgba(0, 0, 0, 0.85)';

		$theme_color['main_color_second'] 	= '#dd2831';

		$theme_color['header_mobile_bg'] 	= '#fff';

		$theme_color['header_mobile_color'] 	= 'rgba(0, 0, 0, 0.85)';

		return apply_filters( 'kera_get_default_theme_color', $theme_color);
	}
}

if ( !function_exists ('kera_tbay_default_theme_primary_fonts') ) {
	function kera_tbay_default_theme_primary_fonts() {

		$theme_variable = array();

		$theme_variable['main_font'] 		= 'Work Sans, sans-serif';

		return apply_filters( 'kera_get_default_theme_fonts', $theme_variable);
	}
}

if (!function_exists('kera_tbay_check_empty_customize')) {
    function kera_check_empty_customize($option, $default){
		if( !is_array( $option ) ) {
            if( !empty($option) && $option !== 'Array' ) {
                echo trim( $option );
            } else {
                echo trim( $default );
            }
        } else {
            if( !empty($option['background-color']) ) {
                echo trim( $option['background-color'] );
            } else {
                echo trim( $default );
            }
        }  
	}
}

if (!function_exists('kera_tbay_theme_primary_color')) {
    function kera_tbay_theme_primary_color()
    {
		$default 					= kera_tbay_default_theme_primary_color();

        $main_color   				= kera_tbay_get_config(('main_color'),$default['main_color']);
        $main_color_second   		= kera_tbay_get_config(('main_color_second'),$default['main_color_second']);
        $header_mobile_bg  	 		= kera_tbay_get_config( ('header_mobile_bg'),$default['header_mobile_bg']);
        $header_mobile_color  	 	= kera_tbay_get_config( ('header_mobile_color'),$default['header_mobile_color']);

		/*Theme Color*/
		?>
		:root {
			--tb-theme-color: <?php kera_check_empty_customize( $main_color, $default['main_color'] ); ?>;
			--tb-color-second: <?php kera_check_empty_customize( $main_color_second, $default['main_color_second'] ); ?>;
			--tb-header_mobile_bg: <?php kera_check_empty_customize( $header_mobile_bg, $default['header_mobile_bg'] ) ?>;
			--tb-header-mobile-color: <?php kera_check_empty_customize(  $header_mobile_color, $default['header_mobile_color'] ) ?>;
		} 
		<?php
    }
}

if ( !function_exists ('kera_tbay_custom_styles') ) {
	function kera_tbay_custom_styles() {
		ob_start();

		kera_tbay_theme_primary_color();

		$default_fonts 		= kera_tbay_default_theme_primary_fonts();	

		$logo_img_width        		= kera_tbay_get_config( 'logo_img_width' );
		$logo_padding        		= kera_tbay_get_config( 'logo_padding' );	

		$logo_img_width_mobile 		= kera_tbay_get_config( 'logo_img_width_mobile' );
		$logo_mobile_padding 		= kera_tbay_get_config( 'logo_mobile_padding' );

		?>
		:root { 
			--tb-text-primary-font: <?php echo trim($default_fonts['main_font']); ?>;
		}
		<?php

		if (defined('TBAY_ELEMENTOR_ACTIVED')) {

			$logo_img_width        		= kera_tbay_get_config('logo_img_width');
			$logo_padding        		= kera_tbay_get_config('logo_padding');

			$logo_img_width_mobile 		= kera_tbay_get_config('logo_img_width_mobile');
			$logo_mobile_padding 		= kera_tbay_get_config('logo_mobile_padding');

			$custom_css 			= kera_tbay_get_config('custom_css');
			$css_desktop 			= kera_tbay_get_config('css_desktop');
			$css_tablet 			= kera_tbay_get_config('css_tablet');
			$css_wide_mobile 		= kera_tbay_get_config('css_wide_mobile');
			$css_mobile         	= kera_tbay_get_config('css_mobile');

			$show_typography        = (bool) kera_tbay_get_config('show_typography', false);

	        if ($show_typography) {
					$font_source 			= kera_tbay_get_config('font_source');
					$primary_font 			= kera_tbay_get_config('main_font')['font-family'];
					$main_google_font_face = kera_tbay_get_config('main_google_font_face');
					$main_custom_font_face = kera_tbay_get_config('main_custom_font_face');

					if ($font_source  == "2" && $main_google_font_face) {
						$primary_font = $main_google_font_face;
					} elseif ($font_source  == "3" && $main_custom_font_face) {
						$primary_font = $main_custom_font_face;
					} ?>
					:root {
						--tb-text-primary-font: <?php kera_check_empty_customize( $primary_font, $default_fonts['main_font'] ); ?>;
					}  
					<?php
				} else {
					?>
					:root { 
						--tb-text-primary-font: <?php echo trim($default_fonts['main_font']); ?>;
					}
					<?php
				}

			?>
			/* Theme Options Styles */
			

				<?php if ($logo_img_width != "") : ?>
				.site-header .logo img {
					max-width: <?php echo esc_html($logo_img_width); ?>px;
				} 
				<?php endif; ?>

				<?php if ($logo_padding != "") : ?>
				.site-header .logo img {

					<?php if ( !empty($logo_padding['padding-top']) ) : ?>
						padding-top: <?php echo esc_html($logo_padding['padding-top']); ?>;
					<?php endif; ?>

					<?php if ( !empty($logo_padding['padding-right']) ) : ?>
						padding-right: <?php echo esc_html($logo_padding['padding-right']); ?>;
					<?php endif; ?>
					
					<?php if ( !empty($logo_padding['padding-bottom']) ) : ?>
						padding-bottom: <?php echo esc_html($logo_padding['padding-bottom']); ?>;
					<?php endif; ?>

					<?php if ( !empty($logo_padding['padding-left']) ) : ?>
						padding-left: <?php echo esc_html($logo_padding['padding-left']); ?>;
					<?php endif; ?>

				}
				<?php endif; ?> 


				@media (max-width: 1199px) {

					<?php if ( $logo_img_width_mobile != "" ) : ?>
					/* Limit logo image height for mobile according to mobile header height */
					.mobile-logo a img {
						width: <?php echo esc_html($logo_img_width_mobile); ?>px;
					}     
					<?php endif; ?>       

					<?php if ( $logo_mobile_padding['padding-top'] != "" || $logo_mobile_padding['padding-right'] || $logo_mobile_padding['padding-bottom'] || $logo_mobile_padding['padding-left'] ) : ?>
					.mobile-logo a img {

						<?php if ( !empty($logo_mobile_padding['padding-top']) ) : ?>
							padding-top: <?php echo esc_html($logo_mobile_padding['padding-top']); ?>;
						<?php endif; ?>

						<?php if ( !empty($logo_mobile_padding['padding-right']) ) : ?>
							padding-right: <?php echo esc_html($logo_mobile_padding['padding-right']); ?>;
						<?php endif; ?>

						<?php if ( !empty($logo_mobile_padding['padding-bottom']) ) : ?>
							padding-bottom: <?php echo esc_html($logo_mobile_padding['padding-bottom']); ?>;
						<?php endif; ?>

						<?php if ( !empty($logo_mobile_padding['padding-left']) ) : ?>
							padding-left: <?php echo esc_html($logo_mobile_padding['padding-left']); ?>;
						<?php endif; ?>
					
					}
					<?php endif; ?>
				}

				@media screen and (max-width: 782px) {
					html body.admin-bar{
						top: -46px !important;
						position: relative;
					}
				}

				/* Custom CSS */
				<?php
				if ($custom_css != '') {
					echo trim($custom_css);
				}
			if ($css_desktop != '') {
				echo '@media (min-width: 1024px) { ' . ($css_desktop) . ' }';
			}
			if ($css_tablet != '') {
				echo '@media (min-width: 768px) and (max-width: 1023px) {' . ($css_tablet) . ' }';
			}
			if ($css_wide_mobile != '') {
				echo '@media (min-width: 481px) and (max-width: 767px) { ' . ($css_wide_mobile) . ' }';
			}
			if ($css_mobile != '') {
				echo '@media (max-width: 480px) { ' . ($css_mobile) . ' }';
			}
		} ?>


	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			} 
		}

		$custom_css = implode($new_lines);

		wp_enqueue_style( 'kera-style', KERA_THEME_DIR . '/style.css', array(), '1.0' );

		wp_add_inline_style( 'kera-style', $custom_css );
	}
}

add_action( 'wp_enqueue_scripts', 'kera_tbay_custom_styles', 200 ); 