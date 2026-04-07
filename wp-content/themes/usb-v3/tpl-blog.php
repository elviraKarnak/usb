<?php
/*Template Name: USB News*/
get_header();
?>

<div class="container">
	<div class="row">
		<div class="product-category-sec-min">
			<?php 
			$myposts = get_posts(); foreach($myposts as $post) : setup_postdata($post);
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' ); $url = $thumb['0'];
			if (empty($url)) {
				$url = 'https://via.placeholder.com/250x150.png?text=www.usb.nu';
			}
			?>			
			<div class="product-category-list col-xs-6 col-sm-6 col-md-3">
		        <div class="product-category-list-min">
		          <div class="product-image">
		              <a href="<?php the_permalink(); ?>">
		              <img class="img-responsive" src="<?php echo $url;?>">
		              </a>
		          </div>
		          <p class="product-category-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
		        </div>
		    </div>		    
		     <?php endforeach; ?>
	     </div>
	</div>
</div>
<?php get_footer();