<?php

if ( ! function_exists( 'kera_tbay_category' ) ) {
	function kera_tbay_category( $post ) {
		// format
		$post_format = get_post_format();
		$header_class = $post_format ? '' : 'border-left';
		echo '<span class="category "> ';
		$cat = wp_get_post_categories( $post->ID );
		$k   = count( $cat );
		foreach ( $cat as $c ) {
			$categories = get_category( $c );
			$k -= 1;
			if ( $k == 0 ) {
				echo '<a href="' . esc_url( get_category_link( $categories->term_id ) ) . '" class="categories-name">' . esc_html($categories->name) . '</a>';
			} else {
				echo '<a href="' . esc_url( get_category_link( $categories->term_id ) ) . '" class="categories-name">' . esc_html($categories->name) . ', </a>';
			}
		}
		echo '</span>';
	}
}

if ( ! function_exists( 'kera_tbay_center_meta' ) ) {
	function kera_tbay_center_meta( $post ) { 
		// format
		$post_format = get_post_format();
		$id = get_the_author_meta( 'ID' );
		echo '<div class="entry-meta">';
			the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
		
			echo "<div class='entry-create'>";
			echo "<span class='entry-date'>". get_the_date( 'M d, Y' ).'</span>';
			"<span class='author'>". esc_html_e('/ By ', 'kera'); the_author_posts_link() .'</span>';
			echo '</div>';
		echo '</div>';
	}
}



if ( ! function_exists( 'kera_tbay_full_top_meta' ) ) {
	function kera_tbay_full_top_meta( $post ) {
		// format
		$post_format = get_post_format();
		$header_class = $post_format ? '' : 'border-left';
		echo '<header class="entry-header-top ' . esc_attr($header_class) . '">';
		if(!is_single()){
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		// details
		$id = get_the_author_meta( 'ID' );
		echo '<span class="entry-profile"><span class="col"><span class="entry-author-link"><strong>' . esc_html__( 'By:', 'kera' ) . '</strong><span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url( $id )) . '" rel="author">' . get_the_author() . '</a></span></span><span class="entry-date"><strong>'. esc_html__('Posted: ', 'kera') .'</strong>' . esc_html( get_the_date( 'M jS, Y' ) ) . '</span></span></span>';
		// comments
		echo '<span class="entry-categories"><strong>'. esc_html__('In:', 'kera') .'</strong> ';
		$cat = wp_get_post_categories( $post->ID );
		$k   = count( $cat );
		foreach ( $cat as $c ) {
			$categories = get_category( $c );
			$k -= 1;
			if ( $k == 0 ) {
				echo '<a href="' . esc_url( get_category_link( $categories->term_id ) ) . '" class="categories-name">' . esc_html($categories->name) . '</a>';
			} else {
				echo '<a href="' . esc_url( get_category_link( $categories->term_id ) ) . '" class="categories-name">' . esc_html($categories->name) . ', </a>';
			}
		}
		echo '</span>';
		if ( ! is_search() ) {
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="entry-comments-link">';
				comments_popup_link( 'No comments','1 comment', '% comments', 'comments-link', 'Comments are off for this post' );
				echo '</span>';
			}
		}
		echo '</header>';
	}
}

if ( ! function_exists( 'kera_tbay_post_tags' ) ) {
	function kera_tbay_post_tags() {
		$posttags = get_the_tags();
		if ( $posttags ) {
			echo '<div class="tagcloud"><span class="meta-title">'.esc_html__('Tags: ', 'kera').'</span>';
			
			$size = count( $posttags );
			$space = '';
			$i = 0;
			foreach ( $posttags as $tag ) {
				
				echo '<a href="' . get_tag_link( $tag->term_id ) . '">';
				if(++$i === $size ) $space ='';
				echo trim($tag->name).$space;
				echo '</a>';
			}
			echo '</div>';
		}
	}
	add_action('kera_tbay_post_bottom','kera_tbay_post_tags', 10);
}
if ( ! function_exists( 'kera_tbay_post_info_author' ) ) {
	function kera_tbay_post_info_author() { 
		$author_id = kera_tbay_get_id_author_post();

		if( defined('TBAY_ELEMENTOR_ACTIVED') && TBAY_ELEMENTOR_ACTIVED ) {
		?>
		<div class="author-info">
			<div class="avarta">
				<?php echo get_avatar($author_id, 64); ?>
			</div>
			<div class="content">
				<h4 class="name"><?php echo get_the_author(); ?></h4>
				<p><?php the_author_meta( 'description', $author_id ) ?></p>
				<a href="<?php echo get_author_posts_url($author_id); ?>" class="all-post"><?php esc_html_e('See all posts ', 'kera'); ?></a>
			</div>
		</div>
		<?php } 
	}
	add_action('kera_tbay_post_bottom','kera_tbay_post_info_author', 20);
}

if ( ! function_exists( 'kera_tbay_post_share_box' ) ) {
  function kera_tbay_post_share_box() {
		if( !kera_tbay_get_config('enable_code_share',false) ) return;

		if( kera_tbay_get_config('select_share_type') == 'custom' ) {
		$image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		kera_custom_share_code( get_the_title(), get_permalink(), $image );
		} else {
			?>
			<div class="tbay-post-share">
				<div class="addthis_inline_share_toolbox"></div>
		</div>
			<?php
		}
  }
}

if ( ! function_exists( 'kera_get_social_html' ) ) {
	function kera_get_social_html($key, $value, $title, $link, $media) {
		if( !$value ) return;

		switch ($key) {
			case 'facebook':
				$output = sprintf(
					'<a class="share-facebook kera-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank"><i class="fab fa-facebook-f"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
				break;			
			case 'twitter':
				$output = sprintf(
					'<a class="share-twitter kera-twitter" href="http://twitter.com/share?text=%s&url=%s" title="%s" target="_blank"><i class="fab fa-twitter"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
				break;			
			case 'linkedin':
				$output = sprintf(
					'<a class="share-linkedin kera-linkedin" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" title="%s" target="_blank"><i class="fab fa-linkedin-in"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
				break;		

			case 'vkontakte':
				$output = sprintf( 
					'<a class="share-vkontakte kera-vkontakte" href="http://vk.com/share.php?url=%s&title=%s&image=%s" title="%s" target="_blank"><i class="fab fa-vk"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $media ),
					urlencode( $title )
				);
				break;			

			case 'pinterest':
				$output = sprintf(
					'<a class="share-pinterest kera-pinterest" href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" title="%s" target="_blank"><i class="fab fa-pinterest"></i></a>',
					urlencode( $media ),
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
				break;			

			case 'whatsapp':
				$output = sprintf(
					'<a class="share-whatsapp kera-whatsapp" href="https://api.whatsapp.com/send?text=%s" title="%s" target="_blank"><i class="fab fa-whatsapp"></i></a>',
					urlencode( $link ),
					esc_attr( $title )
				);
				break;

			case 'email':
				$output = sprintf(
					'<a class="share-email kera-email" href="mailto:?subject=%s&body=%s" title="%s" target="_blank"><i class="far fa-envelope"></i></a>',
					esc_html( $title ),
					urlencode( $link ),
					esc_attr( $title )
				);
				break;
			
			default:
				# code...
				break;
		}

		return $output;
	}
}

if ( ! function_exists( 'kera_custom_share_code' ) ) {
	function kera_custom_share_code( $title, $link, $media ) {
		if( !kera_tbay_get_config('enable_code_share', true) ) return;

		if( !is_singular( 'post') && !is_singular( 'product' ) ) return;

		$socials = kera_tbay_get_config('sortable_sharing');

		$socials_html = '';
		foreach ($socials as $key => $value) {
			$socials_html .= kera_get_social_html($key, $value, $title, $link, $media);
		}


		if ( $socials_html ) {
			$socials_html = apply_filters('kera_addons_share_link_socials', $socials_html);
			printf( '<div class="kera-social-links">%s</div>', $socials_html );
		}

	}
}

if ( ! function_exists( 'kera_tbay_post_format_link_helper' ) ) {
	function kera_tbay_post_format_link_helper( $content = null, $title = null, $post = null ) {
		if ( ! $content ) {
			$post = get_post( $post );
			$title = $post->post_title;
			$content = $post->post_content;
		}
		$link = kera_tbay_get_first_url_from_string( $content );
		if ( ! empty( $link ) ) {
			$title = '<a href="' . esc_url( $link ) . '" rel="bookmark">' . $title . '</a>';
			$content = str_replace( $link, '', $content );
		} else {
			$pattern = '/^\<a[^>](.*?)>(.*?)<\/a>/i';
			preg_match( $pattern, $content, $link );
			if ( ! empty( $link[0] ) && ! empty( $link[2] ) ) {
				$title = $link[0];
				$content = str_replace( $link[0], '', $content );
			} elseif ( ! empty( $link[0] ) && ! empty( $link[1] ) ) {
				$atts = shortcode_parse_atts( $link[1] );
				$target = ( ! empty( $atts['target'] ) ) ? $atts['target'] : '_self';
				$title = ( ! empty( $atts['title'] ) ) ? $atts['title'] : $title;
				$title = '<a href="' . esc_url( $atts['href'] ) . '" rel="bookmark" target="' . $target . '">' . $title . '</a>';
				$content = str_replace( $link[0], '', $content );
			} else {
				$title = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>';
			}
		}
		$out['title'] = '<h2 class="entry-title">' . $title . '</h2>';
		$out['content'] = $content;

		return $out;
	}
}


if ( ! function_exists( 'kera_tbay_breadcrumbs' ) ) {
	function kera_tbay_breadcrumbs() {

		$delimiter = ' / ';
		$home = esc_html__('Home', 'kera');
		$before = '<li class="active">';
		$after = '</li>';
		if (!is_home() && !is_front_page() || is_paged()) {

			echo '<ol class="breadcrumb">';

			global $post;
			$homeLink = esc_url( home_url() );
			echo '<li><a href="' . esc_url($homeLink) . '" class="active">' . '<i class="icon-home"></i>' .esc_html($home) . '</a> ' . esc_html($delimiter) . '</li> ';

			if (is_category()) {
				echo single_cat_title( '', false );
				echo trim($before) . esc_html__('blog', 'kera') . $after;

			} elseif (is_day()) {

				echo '<li><a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . ' ';
				echo '<li><a href="' . esc_url( get_month_link(get_the_time('Y'),get_the_time('m')) ) . '">' . get_the_time('F') . '</a></li> ' . esc_html($delimiter) . ' ';
				echo trim($before) . get_the_time('d') . $after;

			} elseif (is_month()) {

				echo '<li><a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . ' ';
				echo trim($before) . get_the_time('F') . $after;

			} elseif (is_year()) {

				echo trim($before) . get_the_time('Y') . $after;

			} elseif ( is_single()  && !is_attachment()) {
				if ( get_post_type() != 'post' ) {
					$delimiter = '';
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					echo '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . esc_html($post_type->labels->singular_name) . '</a></li> ' . esc_html($delimiter) . ' ';
				} else {
					$delimiter = '';
					$cat = get_the_category(); $cat = $cat[0];
					echo '<li>'.get_category_parents($cat, TRUE, ' ' . $delimiter . ' ').'</li>';
				}

			} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {

				$post_type = get_post_type_object(get_post_type());
				if (is_object($post_type)) {
					echo trim($before) . esc_html($post_type->labels->singular_name) . $after;
				}

			}  elseif (is_attachment()) {

				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID); 
				if( isset($cat) && !empty($cat) ) {
				 $cat = $cat[0];
				 echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				}
				echo '<li><a href="' . esc_url( get_permalink($parent->ID) ) . '">' . esc_html($parent->post_title) . '</a></li> ' . esc_html($delimiter) . ' ';
				echo trim($before) . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {

				echo trim($before) . esc_html__('Page','kera') . $after;

			} elseif ( is_page() && $post->post_parent ) {

				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_post($parent_id);
					$breadcrumbs[] = '<li><a href="' . esc_url( get_permalink($page->ID) ) . '">' . get_the_title($page->ID) . '</a></li>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				foreach ($breadcrumbs as $crumb) echo trim($crumb) . ' ' . $delimiter . ' ';
				echo trim($before) . esc_html__('Page','kera') . $after;

			} elseif ( is_search() ) {

				echo trim($before) . esc_html__('Search','kera') . $after;

			} elseif ( is_tag() ) {

				echo trim($before) . esc_html__('Tags', 'kera') . $after;

			} elseif ( is_author() ) {

				global $author;
				$userdata = get_userdata($author);
				echo trim($before) . esc_html__('Author', 'kera'). $after;

			} elseif ( is_404() ) {

				echo trim($before) . esc_html__('Error 404', 'kera') . $after;

			}

			echo '</ol>';
		}
	}
}

if ( ! function_exists( 'kera_tbay_render_breadcrumbs' ) ) {
	function kera_tbay_render_breadcrumbs() {
		global $post;
		$show = true;
		$img = '';
		$style = array();

		if(  is_attachment() || kera_tbay_is_home_page() ) return;


    $sidebar_configs = kera_tbay_get_blog_layout_configs();


    $breadcrumbs_layout = kera_tbay_get_config('blog_breadcrumb_layout', 'color');

    if(isset($post->ID) && !empty(get_post_meta( $post->ID, 'tbay_page_breadcrumbs_layout', 'color' )) ) {
    	$breadcrumbs_layout = get_post_meta( $post->ID, 'tbay_page_breadcrumbs_layout', 'color' );
    }

    if( isset($_GET['breadcrumbs_layout']) ) {
         $breadcrumbs_layout = $_GET['breadcrumbs_layout'];
    }

    switch ($breadcrumbs_layout) {
        case 'image':
            $breadcrumbs_class = ' breadcrumbs-image';
            break;
        case 'color':
            $breadcrumbs_class = ' breadcrumbs-color';
            break;
        case 'text':
            $breadcrumbs_class = ' breadcrumbs-text';
            break;
        default:
            $breadcrumbs_class  = ' breadcrumbs-image';
    }

    if(isset($sidebar_configs['breadscrumb_class'])) {
        $breadcrumbs_class .= ' '.$sidebar_configs['breadscrumb_class'];
    }
	if ( is_page() && is_object($post) ) { 

		$show = get_post_meta( $post->ID, 'tbay_page_show_breadcrumb', 'no' );
		
		if ( isset($show) && $show != 'yes' ) {
			return ''; 
		}

		$bgimage = get_post_meta( $post->ID, 'tbay_page_breadcrumb_image', true );
		$bgcolor = get_post_meta( $post->ID, 'tbay_page_breadcrumb_color', true );
		$style = array();
		if( $bgcolor && $breadcrumbs_layout !=='image' && $breadcrumbs_layout !=='text' ){
			$style[] = 'background-color:'.$bgcolor;
		}
		if( $bgimage  && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text'  ){ 
			$img = ' <img src="'.esc_url($bgimage).'">  ';
		}

	} elseif (is_singular('post') || is_category() || is_home() || is_tag() || is_author() || is_day() || is_month() || is_year()  || is_search()) {

		$show = kera_tbay_get_config('show_blog_breadcrumb', false);

		if ( !$show  ) {
			return '';  
		}
		$breadcrumb_img = kera_tbay_get_config('blog_breadcrumb_image');

    	$breadcrumb_color = kera_tbay_get_config('blog_breadcrumb_color');

	     $style = array();
	     if( $breadcrumb_color && $breadcrumbs_layout !=='image' && $breadcrumbs_layout !=='text'   ){
	        $style[] = 'background-color:'.$breadcrumb_color;
	     }
		if ( isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text' ) {
          $img = ' <img src="'.$breadcrumb_img['url'].'">  ';
      	}
	}

	$title = $nav = $title_bottom = $title_cat = '';

	if( is_single() ) {
		if( !empty(get_the_category()) ) {
			$cat = get_the_category(); 
			$cat = $cat[0];	
		}

		if( !empty($cat) ) {
			$title_bottom = '<h1 class="page-title-main">'. get_category_parents($cat, TRUE, '') .'</h1>';
		} 
	} else if( is_category() ) {
		$title_bottom = '<h1 class="page-title">'. esc_html__('blog', 'kera') .'</h1>';
		$name_cat = single_cat_title('', false);
		$title_cat = '<h3 class="page-title-main">'. trim($name_cat) .'</h3>';
    } else if ( is_tag() ) {
		$title_bottom = '<h1 class="page-title">'. esc_html__('tags', 'kera'). '</h1>';
		$name_tag = single_tag_title('', false);
		$title_cat = '<h3 class="page-title-tag">'. trim($name_tag) .'</h3>';

    } else if ( is_day() ) {

    	$title_bottom = '<h1 class="page-title-main">'. get_the_time('d') . '</h1>';

    } else if ( is_month() ) {

    	$title_bottom = '<h1 class="page-title-main">'. get_the_time('F') . '</h1>';

    } else if ( is_year() ) {

    	$title_bottom = '<h1 class="page-title-main">'. get_the_time('Y') . '</h1>';

    } else if ( is_search() ) {
	
		$title_bottom = '<h1 class="page-title-main">'. esc_html__('Search results for "','kera')  . get_search_query() . '"</h1>';

	} else if ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		$title_bottom = '<h1 class="page-title-main">'. esc_html__('Articles posted by "', 'kera') . esc_html($userdata->display_name) . '"</h1>';

	} else if ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {

		$post_type = get_post_type_object(get_post_type());
		if (is_object($post_type)) {
			$title_bottom = '<h1 class="page-title-main">'. $post_type->labels->singular_name . '</h1>';
		}

	} else if ( ( is_page() && $post->post_parent ) || ( is_page() && !$post->post_parent ) || is_attachment() ) {
	
		$title 			= '<h1 class="page-title-main">'. get_the_title() . '</h1>';
		$title_bottom 	= '';
		
	}

	if ($breadcrumbs_layout !== 'image') {

		if(!kera_tbay_is_home_page() && isset($post->ID) && !empty(get_the_title($post->ID) && is_page() ) ) {
			$title_bottom 		= '<h1 class="page-title-main">'. get_the_title($post->ID) .'</h1>';
			$title 				= '';
			$breadcrumbs_class .= ' show-title';
		}
		if( is_category() || is_author() ) {
			$breadcrumbs_class .= ' show-title';
		}
		if ( is_archive() ) {
			$breadcrumbs_class .= ' blog';
		}
	}

	$estyle = !empty($style)? ' style="'.implode(";", $style).'"':"";


	echo '<section id="tbay-breadscrumb" '. trim($estyle).' class="tbay-breadscrumb '. esc_attr($breadcrumbs_class) .'">'. trim($img) .'<div class="container"><div class="breadscrumb-inner" >' . trim($title);
		kera_tbay_breadcrumbs();  
	echo ''. trim($nav) .'</div>'. trim($title_bottom) . trim($title_cat) . '</div></section>';
		
	}
}

if ( ! function_exists( 'kera_tbay_render_title' ) ) {
	function kera_tbay_render_title() {
		global $post;
		 
		if ( is_page() && is_object($post) ) { 

			$show = get_post_meta( $post->ID, 'tbay_page_show_breadcrumb', 'no' );

			if ( !$show  ) {
				echo '<header class="entry-header"><h1 class="entry-title">'. get_the_title($post->ID) .'</h1></header>';
			} 
		}
		
	}
}

if ( ! function_exists( 'kera_tbay_paging_nav' ) ) {
	function kera_tbay_paging_nav() {
		global $wp_query, $wp_rewrite;

		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $wp_query->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => '<i class="icon-arrow-left"></i>',
			'next_text' => '<i class="icon-arrow-right"></i>'
		) );

		if ( $links ) :

		?>
		<nav class="navigation paging-navigation">
			<h1 class="screen-reader-text hidden"><?php esc_html_e( 'Posts navigation', 'kera' ); ?></h1>
			<div class="tbay-pagination">
				<?php echo trim($links); ?>
			</div><!-- .pagination -->
		</nav><!-- .navigation -->
		<?php
		endif;

	}
}


if ( ! function_exists( 'kera_tbay_post_nav' ) ) {
	function kera_tbay_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}

		$prevPost = get_previous_post();
		$nextPost  = get_next_post();
		if (is_object($prevPost) ) {
			$prevthumbnail = get_the_post_thumbnail($prevPost->ID, 'kera_avatar_post_carousel' );
		}
		if (is_object($nextPost) ) {
			$nextthumbnail = get_the_post_thumbnail($nextPost->ID, 'kera_avatar_post_carousel');
		}
		?>
		<nav class="navigation post-navigation">
			<h3 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'kera' ); ?></h3>
			<div class="nav-links clearfix">
				<?php
				if ( is_attachment() ) :
					previous_post_link( '%link','<div class="col-lg-6"><span class="meta-nav">'. esc_html__('Published In', 'kera').'</span></div>');
				else :
					if(isset($prevthumbnail) )
					previous_post_link( '%link','<div class="media">'. $prevthumbnail .'<div class="wrapper-title-meta media-body">'.'<span class="meta-nav">'. esc_html__('Previous', 'kera').'</span><span class="post-title">%title</span></div></div>' );
					if(isset($nextthumbnail) )
					next_post_link( '%link', '<div class="media">'. $nextthumbnail .'<div class="wrapper-title-meta media-body">'.'<span class="meta-nav">' . esc_html__('Next', 'kera').'</span><span></span><span class="post-title">%title</span></div></div>');
				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}

if ( !function_exists('kera_tbay_get_post_galleries') ) {
	function kera_tbay_get_post_galleries( $size='full' ){
	    
	    $ids = get_post_meta( get_the_ID(),'tbay_post_gallery_files' );

	    $output = array();

	    if( !empty($ids) ) {
		    $id = $ids[0];

		    if (is_array($id) || is_object($id)) {
			    foreach( $id as $id_img => $link_img ){
			    	$image = wp_get_attachment_image_src($id_img, $size);
			        $output[] = $image[0];
			    }
		    }
	    }
	  	
	  	return $output; 

	}
}

if ( !function_exists('kera_tbay_comment_form') ) {
	function kera_tbay_comment_form($arg, $class = 'btn-primary btn-outline ') {
		global $post;
		if ('open' == $post->comment_status) {
			ob_start();
	      	comment_form($arg);
	      	$form = ob_get_clean();
	      	?>
	      	<div class="commentform reset-button-default">
		    	<?php
		      	echo str_replace('id="submit"','id="submit"', $form);
		      	?>
	      	</div>
	      	<?php
	      }
	}
}

if (!function_exists('kera_tbay_list_comment') ) {
	function kera_tbay_list_comment($comment, $args, $depth) {
		if ( is_file(get_template_directory().'/list_comments.php') ) {
	        require get_template_directory().'/list_comments.php';
      	}
	}
}

if (!function_exists('kera_get_elementor_css_print_method') ) {
	function kera_get_elementor_css_print_method() {
		if( 'internal' !== get_option( 'elementor_css_print_method' ) ) {
			return false;
		} else {
			return true;
		}
	}
}


if (!function_exists('kera_tbay_display_header_builder') ) {
	function kera_tbay_display_header_builder() {
		echo kera_get_display_header_builder();
	}
}

if (!function_exists('kera_get_display_header_builder') ) {
	function kera_get_display_header_builder() {
		$header 	= apply_filters( 'kera_tbay_get_header_layout', 'default' );

		$args = array(
			'name'		 => $header,
			'post_type'   => 'tbay_header',
			'post_status' => 'publish',
			'numberposts' => 1
		);

		$posts = get_posts($args);  
		foreach ( $posts as $post ) {
			if( kera_is_elementor_activated() && Elementor\Plugin::instance()->documents->get( $post->ID )->is_built_with_elementor() ) {
				return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post->ID, kera_get_elementor_css_print_method() );
			} else {
				return do_shortcode( $post->post_content );
			} 
		}
	}
}

if (!function_exists('kera_tbay_display_footer_builder') ) {
	function kera_get_display_footer_builder($footer) {
		global $footer_builder;
		$footer_builder = true;
		$args = array(
			'name'        => $footer,
			'post_type'   => 'tbay_footer',
			'post_status' => 'publish',
			'numberposts' => 1
		);

		$posts = get_posts($args); 
		foreach ( $posts as $post ) {
			if( kera_is_elementor_activated() && Elementor\Plugin::instance()->documents->get( $post->ID )->is_built_with_elementor() ) {
				return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post->ID, kera_get_elementor_css_print_method() );
			} else {
				return do_shortcode( $post->post_content );
			} 
		}
		$footer_builder = false; 
	}
}

if (!function_exists('kera_tbay_display_footer_builder') ) {
	function kera_tbay_display_footer_builder($footer) {
		echo kera_get_display_footer_builder($footer);
	}
}


if (!function_exists('kera_tbay_get_random_blog_cat') ) {
	function kera_tbay_get_random_blog_cat() {
		$post_category = "";
		$categories = get_the_category();

		$number = rand(0, count($categories) - 1);

		if($categories){

			$post_category .= '<a href="'.esc_url( get_category_link( $categories[$number]->term_id ) ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s", 'kera' ), $categories[$number]->name ) ) . '">'.$categories[$number]->cat_name.'</a>';
		}  

		echo trim($post_category);
	}
}

if (!function_exists('kera_tbay_get_id_author_post') ) {
	function kera_tbay_get_id_author_post() {
		global $post;

		$author_id = $post->post_author;

		if( isset($author_id) ) {
			return $author_id;
		}
	}
}


if ( ! function_exists( 'kera_body_class_mobile_footer' ) ) {
	function kera_body_class_mobile_footer( $classes ) {
  
  		$mobile_footer = kera_tbay_get_config('mobile_footer',true);

		if( isset($mobile_footer) && !$mobile_footer ) {
			$classes[] = 'mobile-hidden-footer';
		}
		return $classes;

	}
	add_filter( 'body_class', 'kera_body_class_mobile_footer',99 );
}

if ( ! function_exists( 'kera_body_class_header_mobile' ) ) {
	function kera_body_class_header_mobile( $classes ) {
  
  		$layout = kera_tbay_get_config('header_mobile', 'center');

		if( isset($layout) ) {
			$classes[] = 'header-mobile-'.$layout;
		}
		return $classes;

	}
	add_filter( 'body_class', 'kera_body_class_header_mobile',99 );
}

//Add div wrapper author and name in comment form
if ( !function_exists('kera_tbay_comment_form_fields_open') ) {
	function kera_tbay_comment_form_fields_open() {
		echo '<div class="comment-form-fields-wrapper">';
	}
}
if ( !function_exists('kera_tbay_comment_form_fields_close') ) {
	function kera_tbay_comment_form_fields_close() {
		echo '</div>';
	}
}
add_action('comment_form_before_fields' , 'kera_tbay_comment_form_fields_open');
add_action('comment_form_after_fields' , 'kera_tbay_comment_form_fields_close');

if ( !function_exists('kera_the_post_category_full') ) {
	function kera_the_post_category_full ($has_separator = true) {
		  $post_category = "";
		  $categories = get_the_category();
		  $separator = ($has_separator) ?  ', ' : '';  
		  $output = '';
	  if($categories){
	    foreach($categories as $category) {
	      $output .= '<a href="'.esc_url( get_category_link( $category->term_id ) ).'" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'kera' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	    }
	  	$post_category = trim($output, $separator);
	  }      

		echo trim($post_category);
	}
}

//Check active WPML
if ( !function_exists('kera_tbay_wpml') ) {
	function kera_tbay_wpml() {
		if(is_active_sidebar('wpml-sidebar')) {
			dynamic_sidebar('wpml-sidebar'); 
		}
	}

	add_action('kera_tbay_header_custom_language','kera_tbay_wpml', 10);
}

//Config Layout Blog
if ( !function_exists('kera_tbay_get_blog_layout_configs') ) {
	function kera_tbay_get_blog_layout_configs() {

        if( !is_singular( 'post' ) ){
            $page = 'blog_archive_sidebar';
        } else {
            $page = 'blog_single_sidebar';
        }

        $sidebar = kera_tbay_get_config($page);



		if ( !is_singular( 'post' ) ) {

			$blog_archive_layout =  ( isset($_GET['blog_archive_layout']) )  ? $_GET['blog_archive_layout'] : kera_tbay_get_config('blog_archive_layout', 'main-right');

			if( isset($blog_archive_layout) ) {

        		switch ( $blog_archive_layout ) {
					case 'left-main':
				 		$configs['sidebar'] = array( 'id' => $sidebar, 'class' => 'col-12 col-xl-3'  );
				 		$configs['main'] = array( 'class' => 'col-xl-9' );
				 		break;
				 	case 'main-right':
				 		$configs['sidebar'] = array( 'id' => $sidebar,  'class' => 'col-12 col-xl-3' ); 
				 		$configs['main'] = array( 'class' => 'col-xl-9' );
				 		break;
			 		case 'main':
			 			$configs['main'] = array( 'class' => 'col-12' );
			 			break;								 		
				 	default:
			 			$configs['main'] = array( 'class' => '' );
				 		break;
       			}

                if( !is_active_sidebar($sidebar) ) {
                    $configs['main'] = array( 'class' => '' );
                }

      		} 

		}
		else {
				$blog_single_layout =	( isset($_GET['blog_single_layout']) ) ? $_GET['blog_single_layout']  :  kera_tbay_get_config('blog_single_layout', 'left-main');

				if( isset($blog_single_layout) ) {

					switch ( $blog_single_layout ) {
					 	case 'left-main':
					 		$configs['sidebar'] = array( 'id' => $sidebar, 'class' => 'col-12 col-xl-3'  );
					 		$configs['main'] = array( 'class' => 'col-xl-9' );
					 		break;
					 	case 'main-right':
					 		$configs['sidebar'] = array( 'id' => $sidebar,  'class' => 'col-12 col-xl-3' ); 
					 		$configs['main'] = array( 'class' => 'col-xl-9' );
					 		break;
				 		case 'main':
				 			$configs['main'] = array( 'class' => 'single-full' );
				 			break;
					 	default:
					 		$configs['main'] = array( 'class' => 'single-full' );
					 		break;
					 }

	                if( ( $blog_single_layout === 'left-main' ||  $blog_single_layout === 'main-right' ) && empty($configs['sidebar']['id'])) {
	                    $configs['main'] = array( 'class' => '' );
	                }

				}
		}


		return $configs; 
	}
}

if ( ! function_exists( 'kera_tbay_nav_description' ) ) {
	/**
	 * Display descriptions in main navigation.
	 *
	 * @since Kera 1.0
	 *
	 * @param string  $item_output The menu item output.
	 * @param WP_Post $item        Menu item object.
	 * @param int     $depth       Depth of the menu.
	 * @param array   $args        wp_nav_menu() arguments.
	 * @return string Menu item with possible description.
	 */
	function kera_tbay_nav_description( $item_output, $item, $depth, $args ) {
		if ( 'primary' == $args->theme_location && $item->description ) {
			$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
		}

		return $item_output;
	}
	add_filter( 'walker_nav_menu_start_el', 'kera_tbay_nav_description', 10, 4 );
}

if ( ! function_exists( 'kera_tbay_woocs_redraw_cart' ) ) {
    function kera_tbay_woocs_redraw_cart() {
        return 0;
    }
    add_filter( 'woocs_redraw_cart', 'kera_tbay_woocs_redraw_cart', 10 ,1 );
}

if( ! function_exists( 'kera_get_html_custom_post' ) ) {
	function kera_get_html_custom_post($id) {
        if( is_null($id) ) return;
        
        $post = get_post( $id );

        if ( kera_is_elementor_activated() && Elementor\Plugin::instance()->documents->get( $id )->is_built_with_elementor() ) {
            return Elementor\Plugin::instance()->frontend->get_builder_content_for_display($id, kera_get_elementor_css_print_method());
        } else {
            return do_shortcode($post->post_content);
        }

	}

}

if( ! function_exists('kera_load_html_dropdowns_action') ) {
	function kera_load_html_dropdowns_action() {
		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);


		if( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
			$ids = kera_clean( $_POST['ids'] );
			foreach ($ids as $id) {
				$id = (int) $id;
				$content = kera_get_html_custom_post($id);
				if( ! $content ) continue;

				$response['status'] = 'success';
				$response['message'] = 'At least one HTML block loaded';
				$response['data'][$id] = $content;
			}
		}

		echo json_encode($response);

		die();
	}
	add_action( 'wp_ajax_kera_load_html_dropdowns', 'kera_load_html_dropdowns_action' );
	add_action( 'wp_ajax_nopriv_kera_load_html_dropdowns', 'kera_load_html_dropdowns_action' );
}

if( ! function_exists('kera_load_html_click_action') ) {
	function kera_load_html_click_action() {
		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);
   

		if( ! empty( $_POST['slug'] ) ) {
			$slug 			= kera_clean( $_POST['slug'] );
			$layout 		= kera_clean( $_POST['layout'] );

            $args = [
                'echo'        => false,
                'menu'        => $slug, 
                'container_class' => 'collapse navbar-collapse',
                'menu_id'     => 'menu-' . $slug,
                'walker'      => new kera_Tbay_Nav_Menu(),
                'fallback_cb' => '__return_empty_string',
                'container'   => '', 
            ];   

			$args['menu_class'] = kera_nav_menu_get_menu_class($layout);


            $content = wp_nav_menu($args);     

            $response['status']     = 'success';
            $response['message']    = 'At least one HTML Menu Canvas loaded';
            $response['data']       = $content;
		}

		echo json_encode($response); 

		die();
	}
	add_action( 'wp_ajax_kera_load_html_click', 'kera_load_html_click_action' );
	add_action( 'wp_ajax_nopriv_kera_load_html_click', 'kera_load_html_click_action' );
}

if( ! function_exists('kera_load_html_canvas_template') ) {
	function kera_load_html_canvas_template() {
		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);
     

		if( !empty( $_POST['id'] ) ) {
			$template_id = (int) kera_clean( $_POST['id'] );
			$content = kera_get_html_custom_post($template_id);

            $response['status']     = 'success';
            $response['message']    = 'At least one HTML Menu Canvas loaded';
            $response['data']       = $content;
		}  

		echo json_encode($response); 

		die();
	}
	add_action( 'wp_ajax_kera_load_html_canvas_template_click', 'kera_load_html_canvas_template' );
	add_action( 'wp_ajax_nopriv_kera_load_html_canvas_template_click', 'kera_load_html_canvas_template' );
}