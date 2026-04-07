<?php
   // Template Name: Parent Category Template
   get_header(); ?>
<section class="full top-five-section">
   <div class="container">
      <div class="row">
         <div class="col-sm-12 col-xs-12">
            <?php if(have_posts()): while(have_posts()): the_post(); ?>  
            <h1><?php the_title(); ?></h1>
            <?php endwhile; endif; ?>
         </div>
         <!-- Category List --->
         <div class="category_wraper" id="loadmorecontent">
            <?php
               $pageID = get_the_ID();
               if($pageID == 1198 || $pageID == 43)
               {
                 $selected_cat ="sound,chargers,cases,accessories";  
               }
               if($pageID == 1196 || $pageID == 45)
               {
                 $selected_cat ="ipad-accessories,laptop-products,mouse-pads";  
               }
               if($pageID == 1204 || $pageID == 41)
               {
                 $selected_cat ="usb-memory,safexs";  
               }
               if($pageID == 1200 || $pageID == 47)
               {
                 $selected_cat ="security,hygiene,accessories-2,own-design";  
               }
                           $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
               
               $args = array( 'post_type' => 'product', 'posts_per_page' => -1, 'paged' => $paged, 'product_cat' => $selected_cat, 'orderby' => 'rand' );
                           $loop = new WP_Query( $args );
               
               if($loop->have_posts()){
                $kk = 1;
                  while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
                   
                 if (has_post_thumbnail( $loop->post->ID )) {
                 
                   $url = wp_get_attachment_url(get_post_thumbnail_id($loop->post->ID));
                   
                 }else{
                   $url = "";
                 }
               ?>
            <div class="col-sm-2 col-xs-12 loadmoreContentPreview no-padding <?php echo ($kk==1)?'elm1':'';?> <?php echo ($kk==2)?'elm2':'';?> <?php echo ($kk==3)?'elm3':'';?> <?php echo ($kk==4)?'elm4':'';?> <?php echo ($kk==5)?'elm5':'';?> ">
               <div class="top-five-box asn">
                  <div class="popular_new">
                     <?php 
                        $field_id_value_popular = get_post_meta(get_the_ID(), 'field_id_popular', true);
                        if(!empty($field_id_value_popular)){ ?>
                     <span class="tag-sky1">
                     <?php _e( 'Popular', 'usb' );?>
                     </span>
                     <?php } ?>
                     <?php $field_id_value_new = get_post_meta(get_the_ID(), 'field_id_new', true);
                        if(!empty($field_id_value_new)){ ?>
                     <span class="tag-red1">
                     <?php _e( 'New', 'usb' );?>
                     </span>
                     <?php } ?>
                  </div>
                  <a href="<?php echo get_permalink($loop->post->ID);?>">
                     <div class="top-five-img">
                        <img src="<?php echo $url;?>"><!-- <span class="tag-sky">Populär</span> -->
                     </div>
                     <!-- <h3>Nyheter</h3> -->
                     <div class="cei-cat-pro-title">
                        <h4><?php the_title(); ?></h4>
                     </div>
                  </a>
               </div>
            </div>
            <?php $kk++; if($kk > 5) {$kk = 1;} endwhile; ?>  
            <?php
               }else{
                            ?>
            <p><?php _e( 'No Product Were Found', 'usb' );?></p>
            <?php
               }
               wp_reset_query();
               ?>
         </div>
         
      </div>
      <div class="row">
        <div class="col-sm-12 text-center"><a href="#" id="loadMore">Load More</a></div>
      </div>
   </div>
</section>
<style type="text/css">
  .category_wraper .loadmoreContentPreview {display: none;}
  #loadMore {
    display: inline-block;
    margin: 30px 0;
    padding: 10px;
    text-align: center;
    background-color: #33739E;
    color: #fff;
    border-width: 0 1px 1px 0;
    border-style: solid;
    border-color: #fff;
    box-shadow: 0 1px 1px #ccc;
    transition: all 600ms ease-in-out;
    -webkit-transition: all 600ms ease-in-out;
    -moz-transition: all 600ms ease-in-out;
    -o-transition: all 600ms ease-in-out;
}
#loadMore:hover {
    background-color: #fff;
    color: #33739E;
}
.popular_new{
position: absolute;
    box-sizing: border-box;
    overflow: hidden;
    height: 180px;
    width: 180px;
    top: 1px;
    left: 0;
    right: inherit !important;
}
.tag-sky1, .tag-sky{
background: #1a9dd8 !important;
    width: 175px !important;
    left: -50px !important;
    top: 16px !important;
}
</style>
<script type="text/javascript">
  /*
  Load more content with jQuery - May 21, 2013
  (c) 2013 @ElmahdiMahmoud
*/   

jQuery(function ($) {
    $(".category_wraper .loadmoreContentPreview").slice(0, 20).show();
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $(".category_wraper .loadmoreContentPreview:hidden").slice(0, 10).slideDown();
        if ($(".category_wraper .loadmoreContentPreview:hidden").length == 0) {
            $("#loadMore").fadeOut('slow');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
});
</script>
<?php get_footer(); ?>