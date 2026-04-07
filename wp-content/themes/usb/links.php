<?php
/*
Template Name: Links
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
<h1><?php _e( 'Links', 'usb' );?></h1>
<?php 
wp_list_bookmarks('
title_li=
&title_before=<h3>
&title_after=</h3>
&category_before=
&category_after=
&orderby=rating
&order=DESC
&show_description=1
&between= — 
');
?>
</div>
       </div>
    </div>
  </div>
<?php get_footer(); ?>