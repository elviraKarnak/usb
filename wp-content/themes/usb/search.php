<?php get_header(); 
 $s = $_GET['s'];
?>
<section class="custom_full">
  <div class="container">
    <div class="row">
      <div class="main-search-wrap full">
          <?php 
           

          $args = array( 'post_type' => 'product', 
                          'order' => 'ASC',
                          'meta_key' => '_sku', 
                          'meta_value' => $s,
                          'posts_per_page' => -1,
        ); 
          $the_query = new WP_Query( $args);
          ?>



      <?php if($the_query->have_posts()): while($the_query->have_posts()): $the_query->the_post(); 
        ?>  
          <div class="col-md-3 col-sm-6 col-xs-12 clearfix">
            <div class="search_content_wrap">
              <a href="<?php the_permalink(); ?>" class="search_title">
                <h2><?php the_title(); ?></h2>
              </a>
              <p class="search_description">
                <?php 
                $excerpt = get_the_excerpt();
                $excerpt = substr( $excerpt , 0, 60); 
                echo $excerpt;
                 ?>
              </p>
            </div>
          </div>
        <?php endwhile; else: ?>
      </div>
    </div>
  </div>
</section>

<section class="full">
  <div class="container">
    <div class="row">
      <div class="main-search-wrap full">
        <div class="col-md-12 col-sm-6 col-xs-12 clearfix">
        <h2 style="text-align: center;"><?php _e('Sorry,no posts matched your criteria.','usb'); ?></h2>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>

