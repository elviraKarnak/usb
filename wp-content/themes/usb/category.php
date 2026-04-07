<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>
<div class="body_part">
<?php
include("inner_left.php");
?>
    <div class="body_right_part">
       <div class="body_right_part_top">&nbsp;</div>
       <div class="body_right_part_content">
<div class="cms_content_area">
<h1><?php _e('Archives') ?></h1>
<h3><?php _e('Archives by Month') ?></h3>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
<p>&nbsp;</p>
<h3><?php _e('Archives by Subject') ?></h3>
<ul>
<?php wp_list_cats(); ?>
</ul>
<?php if( function_exists('wp_tag_cloud') ) { ?>
<p>&nbsp;</p>
<h3><?php _e('Tags') ?></h3>
<?php wp_tag_cloud(); ?>
<?php } ?>    
</div>
       </div>
    </div>
  </div>
<?php get_footer(); ?>