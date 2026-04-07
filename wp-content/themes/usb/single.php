<?php get_header(); ?>
<div class="container">
     <div class="row">
          <div class="col-sm-12">
			 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>  
			<h2><?php the_title(); ?></h2>

			<?php the_content(); ?>
			<?php endwhile; else: ?>
			<h2><?php _e('Not Found') ?></h2>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
       </div>
    </div>
  </div>
<?php get_footer(); ?>