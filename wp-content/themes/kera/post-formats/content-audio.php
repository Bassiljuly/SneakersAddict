<?php
/**
 *
 * The default template for displaying content
 * @since 1.0
 * @version 1.2.0
 *
 */

$columns					= kera_tbay_blog_loop_columns('');
$date 						= kera_tbay_get_boolean_query_var('enable_date');
$author 					= kera_tbay_get_boolean_query_var('enable_author');
$categories 				= kera_tbay_get_boolean_query_var('enable_categories');
$comment 					= kera_tbay_get_boolean_query_var('enable_comment');
$comment_text 					= kera_tbay_get_boolean_query_var('enable_comment_text');
$cat_type 					= kera_tbay_categories_blog_type();
$short_descriptions 		= kera_tbay_get_boolean_query_var('enable_short_descriptions');
$read_more 					= kera_tbay_get_boolean_query_var('enable_readmore');

$image_position   			= apply_filters( 'kera_archive_image_position', 10,2 );

$class_main = $class_left = $class_right = '';
if( $image_position == 'left' ) {
	$class_main = 'row';
	$class_left = ' col-md-8';
	$class_right = ' col-md-4';
}

$audiolink =  get_post_meta( get_the_ID(),'tbay_post_audio_link', true );

if( isset($audiolink) && $audiolink ) {

} else {
	$content = apply_filters( 'the_content', get_the_content() );
	$audio = false;
	// Only get audio from the content if a playlist isn't present.
	if ( false === strpos( $content, 'wp-playlist-script' ) ) {
		$audio = get_media_embedded_in_content( $content, array( 'audio' ) );
	}
}

$class_blog = ($columns > 1) ? 'post-grid' : 'post-list';
?>
<!-- /post-standard -->
<?php if ( ! is_single() ) : ?>
<div  class="<?php echo esc_attr( $class_blog ); ?> clearfix position-image-<?php echo esc_attr($class_main); ?>">
<?php endif; ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class($class_main); ?>>
<?php if ( is_single() ) : ?>
	<div class="entry-single">
	<?php echo kera_tbay_post_media( get_the_excerpt() ); ?>
<?php endif; ?>
		<?php
			if ( is_single() ) : ?>
				<div class="entry-header">
					<?php
		                if (get_the_title()) {
		                ?>
		                    <h1 class="entry-title">
		                       <?php the_title(); ?>
		                    </h1>
		                <?php
		            	}
		            ?>
				</div>
				<div class="list-meta-author-wrapper">

					<?php if( $author && $author_img = '1') : ?>
						<?php echo '<span class="author-img">'. get_avatar(kera_tbay_get_id_author_post(), 48) .'</span>'; ?> 
					<?php endif; ?>

					<div class="list-meta-author">
						<?php if ($author): ?>
							<span class="entry-author">
								<?php the_author_posts_link(); ?>
							</span>
						<?php endif; ?>

						<?php kera_post_meta(array(
							'date'     => 1,
							'author'   => 0,
							'comments' => 1,
							'comments_text' => 1,
							'tags'     => 0,
							'cats'     => 1,
							'edit'     => 0,
						)); ?>
					</div>

				</div>
				
				<?php 
					kera_tbay_post_share_box();
				?>
				<?php if( $audiolink ) : ?>
					<div class="audio-wrap audio-responsive"><?php echo wp_oembed_get( $audiolink ); ?></div>
				<?php elseif( has_post_thumbnail() ) : ?>
					<?php kera_tbay_post_thumbnail(); ?>
				<?php endif; ?>
				
				<div class="post-excerpt entry-content">
					 

					<?php the_content( esc_html__( 'Continue reading', 'kera' ) ); ?>

					<?php do_action('kera_tbay_post_bottom') ?>
					
				</div><!-- /entry-content -->

				<?php
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kera' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'kera' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
				?>
		<?php endif; ?>

    <?php if ( ! is_single() ) : ?>

		<?php
		 	if ( has_post_thumbnail() ) {
		  	?>
		  	<figure class="entry-thumb <?php echo esc_attr( $class_left ); ?> <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
				   <?php kera_tbay_post_thumbnail(); 
				 	kera_tbay_icon_post_formats();   
				   ?>
		  	</figure>
		  	<?php
		 	}
		?>
		<div class="entry-content <?php echo esc_attr( $class_right ); ?> <?php echo ( !has_post_thumbnail() ) ? 'no-thumb' : ''; ?>">

			<div class="entry-header">
				<?php // Categories ?>
				<?php if(get_the_category_list( '' ) &&  $categories): ?>
					<div class="entry-category"><?php kera_the_post_category_full() ?></div>
				<?php endif; ?>
				<?php kera_post_archive_the_title(); 
				?>

				<?php kera_post_meta(array(
					'date'     => $date,
					'author'     => $author,
					'tags'     => 0,
					'comments' 		=> $comment,
					'comments_text' 		=> $comment_text,
					'edit'     => 0,
					'cats'    => 0,
				)); ?>

				<?php if( $short_descriptions ) : ?>
					<?php kera_post_archive_the_short_description(); ?>
				<?php endif; ?>

				<?php if( $read_more ) : ?>
					<?php kera_post_archive_the_read_more(); ?>
				<?php endif; ?>

		    </div>

		</div>

    <?php endif; ?>
    <?php if ( is_single() ) : ?>
</div>
<?php endif; ?>
</article>

<?php if ( ! is_single() ) : ?>
</div>
<?php endif; ?>