<?php get_header(); ?>
<section class="full top-five-section">
   <div class="container">
      <div class="row">
      	<div class="col-sm-12 col-xs-12">
			<?php if(have_posts()): while(have_posts()): the_post(); ?>  
			<h1><?php the_title(); ?></h1>
		</div>
			<?php the_content(); ?>
			<?php endwhile; else: ?>
			<h1><?php _e('Not Found')?></h1>
			<p><?php _e('Sorry,no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		
     </div>
  </div>
</section>
<?php get_footer(); ?>