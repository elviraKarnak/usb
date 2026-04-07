<?php get_header(); ?>
<div class="body_part">
    <div class="body_right_part">
       <div class="body_right_part_top">&nbsp;</div>
       <div class="body_right_part_content">
<div class="cms_content_area">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>  
<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
<?php endwhile; else: ?>
<h1><?php _e('Not Found') ?></h1>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div>
       </div>
    </div>
  </div>
<?php get_footer(); ?>