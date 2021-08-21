<?php 

$text_domain               = esc_html__(' comments','kera');    
if( get_comments_number() == 1) {
    $text_domain = esc_html__(' comment','kera');
}

?>
<div class="post item-post single-reladted">   
    <figure class="entry-thumb <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
        <a href="<?php the_permalink(); ?>"  class="entry-image">
            <?php kera_tbay_post_thumbnail(); ?>
            
        </a> 
    </figure>
    <div class="entry-header">

        <?php if ( get_the_title() ) : ?>
            <h3 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        <?php endif; ?>
        <ul class="entry-meta-list">
            <li class="entry-date"><?php echo kera_time_link(); ?></li>
            <li class="comments-link">
                <?php echo comments_popup_link( 'No comments','1 comment', '% comments', 'comments-link', 'Comments are off for this post' ); ?>
            </li>
        </ul>

    </div>
</div>
