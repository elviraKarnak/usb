<?php get_header(); ?>
<div class="body_part">
    <div class="body_right_part">
       <div class="body_right_part_top">&nbsp;</div>
       <div class="body_right_part_content">
<div class="cms_content_area">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>  
<h2><?php the_title(); ?></h2>
<?php //the_content(); ?>
<?php the_excerpt(); ?>
<div class="blg_link"><a href="<?php the_permalink(); ?>"><?php _e( 'Continue Reading', 'usb' );?></a></div><br /><br />
<?php endwhile; else: ?>
<h2><?php _e('Not Found') ?></h2>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div>
       </div>
    </div>
  </div>
<?php get_footer(); ?>