<?php
/*
Template Name: Blog
*/
?>
<?php get_header(); ?>
<div class="body_inr" style="width:890px; margin:20px;">
<div class="blg_left_col">
<?php
$myposts = get_posts();
foreach($myposts as $post) : setup_postdata($post);
?>
<div class="blg_post">
    <h3><?php the_title(); ?></h3>
    <?php the_excerpt(); ?>
    <div class="blg_link"><a href="<?php the_permalink(); ?>"><?php _e( 'Continue Reading', 'usb' );?></a></div>
</div>
<?php endforeach; ?>

</div>

<div class="blg_right_col">
<?php include("blog_sidebar.php"); ?>
</div>

</div>


</div>
</div>
</div>
</div>
<?php get_footer(); ?>