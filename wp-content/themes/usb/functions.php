<?php
/*****************************************
* elvirainfotech Functions & Definitions *
*****************************************/
$functions_path = get_template_directory().'/functions/';
$post_type_path = get_template_directory().'/inc/post-types/';
$post_meta_path = get_template_directory().'/inc/post-metabox/';
$theme_function_path = get_template_directory().'/inc/theme-functions/';
require_once($theme_function_path.'extra-functions.php');
require_once($theme_function_path.'pdf-functions.php');
require_once($theme_function_path.'usb-pdf-functions.php');
require_once($theme_function_path.'margin-pdf-functions.php');
require_once($theme_function_path.'import-functions.php');
require_once($theme_function_path.'exportcsv-functions.php');
require_once($theme_function_path.'shortcode-tab-functions.php');
require_once($theme_function_path.'cat-video.php');






/*--------------------------------------*/
/* Multipost Thumbnail Functions
/*--------------------------------------*/
//require_once($functions_path.'multipost-thumbnail/multi-post-thumbnails.php');

/*--------------------------------------*/
/* Optional Panel Helper Functions
/*--------------------------------------*/
require_once($functions_path.'admin-functions.php');
require_once($functions_path.'admin-interface.php');
require_once($functions_path.'theme-options.php');
require_once($functions_path.'admin_user.php');
function elvirainfotech_ftn_wp_enqueue_scripts(){
    if(!is_admin()){
        wp_enqueue_script('jquery');
        if(is_singular()and get_site_option('thread_comments')){
            wp_print_scripts('comment-reply');
            }
        }
    }
add_action('wp_enqueue_scripts','elvirainfotech_ftn_wp_enqueue_scripts');
function elvirainfotech_ftn_get_option($name){
    $options = get_option('elvirainfotech_ftn_options');
    if(isset($options[$name]))
        return $options[$name];
    }
function elvirainfotech_ftn_update_option($name, $value){
    $options = get_option('elvirainfotech_ftn_options');
    $options[$name] = $value;
    return update_option('elvirainfotech_ftn_options', $options);
    }
function elvirainfotech_ftn_delete_option($name){
    $options = get_option('elvirainfotech_ftn_options');
    unset($options[$name]);
    return update_option('elvirainfotech_ftn_options', $options);
    }
function get_theme_value($field){
    $field1 = elvirainfotech_ftn_get_option($field);
    if(!empty($field1)){
        $field_val = $field1;
        }
    return  $field_val;
    }

require_once($post_meta_path.'taxonomy-image-meta.php');
require_once($post_type_path.'sliders.php');
require_once($post_meta_path.'product-metabox.php');
require_once($post_meta_path.'check-metabox.php');
//require_once($post_type_path.'product-meta.php');
add_image_size('sliders_image_size',870,350,true);

/*--------------------------------------*/
/* Theme Helper Functions
/*--------------------------------------*/
if(!function_exists('elvirainfotech_theme_setup')):
    function elvirainfotech_theme_setup(){
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        register_nav_menus(array(
            'primary' => __('Primary Menu','elvirainfotech'),
            'secondary'  => __('Secondary Menu','elvirainfotech'),
            ));
        add_theme_support('html5',array('search-form','comment-form','comment-list','gallery','caption'));
        }
    endif;
add_action('after_setup_theme','elvirainfotech_theme_setup');
function elvirainfotech_widgets_init(){
    register_sidebar(array(
        'name'          => __('Widget Area','elvirainfotech'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.','elvirainfotech'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
        ));
    register_sidebar(array(
        'name'          => __('Footer Widget Area','elvirainfotech'),
        'id'            => 'sidebar-2',
        'description'   => __('Add widgets here to appear in your sidebar.','elvirainfotech'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
        ));
    register_sidebar(array(
        'name'          => __('Footer Widget Area','elvirainfotech'),
        'id'            => 'sidebar-3',
        'description'   => __('Add widgets here to appear in your sidebar.','elvirainfotech'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
        ));
    register_sidebar(array(
        'name'          => __('Footer Widget Area','elvirainfotech'),
        'id'            => 'sidebar-4',
        'description'   => __('Add widgets here to appear in your sidebar.','elvirainfotech'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
        ));
    }
    add_action('widgets_init','elvirainfotech_widgets_init');
    function elvirainfotech_scripts(){
    
    wp_enqueue_style('elvirainfotech-bootstrapmin',get_template_directory_uri().'/css/bootstrap.min.css',array());
    wp_enqueue_style('elvirainfotech-owlcarousel',get_template_directory_uri().'/css/owl.carousel.min.css',array());
    wp_enqueue_style('elvirainfotech-fancyboxcss',get_template_directory_uri().'/css/jquery.fancybox.css',array());
    wp_enqueue_style('elvirainfotech-style',get_template_directory_uri().'/css/style.css',array());
    wp_enqueue_style('elvirainfotech-customs_style',get_template_directory_uri().'/css/custom.css',array());

    wp_enqueue_style('elvirainfotech-fontaewsome',get_template_directory_uri().'/css/font-awesome.css',array());
    wp_enqueue_style('elvirainfotech-main-style',get_stylesheet_uri());
    
    // Load the Internet Explorer specific script.
    global $wp_scripts;
    wp_enqueue_script('elvirainfotech-jsbootstrap',get_template_directory_uri().'/js/bootstrap.min.js',array('jquery'),'20170808',true);
    wp_enqueue_script('elvirainfotech-jscarousel',get_template_directory_uri().'/js/owl.carousel.min.js',array('jquery'),'20170810',true);
     wp_enqueue_script('elvirainfotech-fancybox',get_template_directory_uri().'/js/jquery.fancybox.js',array('jquery'),'20170812',true);
    wp_enqueue_script('elvirainfotech-bootstraphoverdropdown',get_template_directory_uri().'/js/bootstrap-hover-dropdown.min.js',array('jquery'),'20170809',true);
    wp_enqueue_script( 'elvirainfotech-select2', get_template_directory_uri() . '/js/select2.js', array( 'jquery' ), '20151817', true );
    
    wp_enqueue_script('elvirainfotech-carouselminjs',get_template_directory_uri().'/js/main.js',array('jquery'),'20170811',true);
    }
   
   add_action('wp_enqueue_scripts','elvirainfotech_scripts');

    add_filter('comments_template','legacy_comments');
    function legacy_comments($file){
    if(!function_exists('wp_list_comments'))    $file = TEMPLATEPATH .'/legacy.comments.php';
    return $file;
    }
// Add Theme Woocommerce
    add_action( 'after_setup_theme', 'woocommerce_support' );
    function woocommerce_support() {
    add_theme_support( 'woocommerce' );
    }

  // Ship to a different address opened by default
  add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );

/// Contents of the builder options product tab.
  function builder_product_tabs($tabs)
{
    
    $tabs['builder'] = array(
        'label' => __('Standrad', 'woocommerce'),
        'target' => 'builder_options'
        
    );
    $tabs['usb_builder'] = array(
        'label' => __('USB', 'woocommerce'),
        'target' => 'usb_builder_options'
        
    );
    return $tabs;
    
}
add_filter('woocommerce_product_data_tabs', 'builder_product_tabs');

add_action('woocommerce_product_write_panels', 'builder_write_panel');
function builder_write_panel()
{
    global $woocommerce, $post;
    $product = get_product($post->ID);
    ?>
    <style type="text/css">
        #woocommerce-product-data .inside {width: 100%;}
        table.hide_if_standard.show_if_usb tbody tr td,.dsbl-chk-bx tbody tr td {
            float: left;
            position: relative;
            padding-right: 15px;
        }
    </style>

   <div id='builder_options' class='panel woocommerce_options_panel'>
        <div id="usb_builder" class="usb_builder show_if_standard hide_if_usb">
            <div class='options_group'>
                <p class="toolbar"></p>
                <table class="dsbl-chk-bx">
                    <tr>
                        <th>Disable For Front-End</th>
                    </tr>
                    <?php
                    $show_stnd_qty = json_decode(get_post_meta($post->ID,'_show_stnd_qty',true));
                    ?>                  
                    <tr>
                        <td>50 <input <?php if(!empty($show_stnd_qty) && in_array('50', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="50"></td>
                        <td>100 <input <input <?php if(!empty($show_stnd_qty) && in_array('100', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="100"></td>
                        <td>250 <input <?php if(!empty($show_stnd_qty) && in_array('250', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="250"></td>
                        <td>500 <input <?php if(!empty($show_stnd_qty) && in_array('500', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="500"></td>
                        <td>1000 <input <?php if(!empty($show_stnd_qty) && in_array('1000', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="1000"></td>
                        <td>2500 <input <?php if(!empty($show_stnd_qty) && in_array('2500', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="2500"></td>
                        <td>5000 <input <?php if(!empty($show_stnd_qty) && in_array('5000', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="5000"></td>
                    </tr>                    
                </table>            
                
            </div>

            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 50 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 50 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_50" value="<?php echo get_post_meta($post->ID, '_price_option_50', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/>
                            <input type="radio" name="_active_qty" value="50" <?php if('50'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 100 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 100 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_100" value="<?php echo get_post_meta($post->ID, '_price_option_100', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="100" <?php if('100'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 250 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 250 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_250" value="<?php echo get_post_meta($post->ID, '_price_option_250', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="250" <?php if('250'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 500 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 500 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_500" value="<?php echo get_post_meta($post->ID, '_price_option_500', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="500" <?php if('500'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 1000 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 1000 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_1000" value="<?php echo get_post_meta($post->ID, '_price_option_1000', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="1000" <?php if('1000'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 2500 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 2500 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_2500" value="<?php echo get_post_meta($post->ID, '_price_option_2500', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/>
                            <input type="radio" name="_active_qty" value="2500" <?php if('2500'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active? 
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 5000 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 5000 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_5000" value="<?php echo get_post_meta($post->ID, '_price_option_5000', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="5000" <?php if('5000'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
       
                <div class='options_group'> 
                    <div class='wc-metaboxes'>  
                        <div class='wc-metabox'>  

                            <?php
                            $get_attribute_vl = get_post_meta($post->ID,'attribute_vl',true);
                            $get_attribute_pr_vl = get_post_meta($post->ID,'attribute_pr_vl',true);
                            $attributes = $product->get_attributes();
                            foreach ( $attributes as $attribute ) {
                                $attribute_name = $attribute['name'];

                                $explode_attribute_name = explode("_",$attribute_name);
                                ?>
                                <div class='options_group'> 
                                    <div class='wc-metaboxes'>  
                                        <div class='wc-metabox'>                    
                                            <p class='form-field'>  
                                                <strong><?php echo $explode_attribute_name[1];?></strong>
                                            </p>
                                        </div>
                                    </div>      
                                </div>
                                <?php
                                $get_attribute = wc_get_product_terms( $product->id,$attribute_name, array( 'fields' => 'all' ) );
                                foreach ( $get_attribute as $get_attribute_key => $get_attribute_value) {

                                        $get_attribute_id = $get_attribute_value->term_id;
                                        $get_attribute_name = $get_attribute_value->name;

                                        $field_name = $get_attribute_name.'_'.$get_attribute_id;
                                        $field_name = str_replace(' ', '', $field_name);
                                        $attribute_vl = (!empty($get_attribute_vl[$field_name])) ? $get_attribute_vl[$field_name] :'';
                                        $attribute_pr_vl = (!empty($get_attribute_pr_vl[$field_name])) ? $get_attribute_pr_vl[$field_name] :'';
                                        $attribute_vl_chk = ($attribute_vl=='yes')?'checked':'';

                                        ?>
                                        <div class='options_group'> 
                                            <div class='wc-metaboxes'>  
                                                <div class='wc-metabox'>                    
                                                    <p class='form-field'>  
                                                        <label><?php echo $get_attribute_name;?></label>
                                                        <input <?php echo $attribute_vl_chk;?> type="checkbox" name="attribute_vl[<?php echo $field_name;?>]"  value="yes"/>

                                                        <input type="text" name="attribute_pr_vl[<?php echo $field_name;?>]"  value="<?php echo $attribute_pr_vl;?>"/>
                                                    </p>
                                                </div>
                                            </div>      
                                        </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            

        </div> 
        <!-- <div class="usb_builder show_if_usb hide_if_standard">dddddddddddddddddddddd</div> -->
    </div>

    <div id='usb_builder_options' class='panel woocommerce_options_panel'>
        <div id="usb_builder_option" class="usb_builder_option hide_if_standard show_if_usb">
            <div class='options_group'>
                <?php 
                $usb_ocm_tlc = array();
                $usb_ocm_tlc = json_decode(get_post_meta($post->ID,'_usb_ocm_tlc',true),true); 
                $c = !empty($usb_ocm_tlc) ? count($usb_ocm_tlc) : 0;
                if (!empty($usb_ocm_tlc)) {
                    $usb_ocm_tlc = array_map('array_filter', $usb_ocm_tlc);
                    $usb_ocm_tlc = array_filter($usb_ocm_tlc);
                }
                
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function( $ ){
                        var count = <?php echo $c; ?>;
                        $( '#add-row' ).on('click', function() {
                            count = count + 1;
                            $( '.empty-row.screen-reader-text td input' ).attr('name','usb_ocm_tlc['+count+'][]');
                            $( '.empty-row.screen-reader-text td select' ).attr('name','usb_ocm_tlc['+count+'][]');
                            var row = $( '.empty-row.screen-reader-text' ).clone(true);
                            row.removeClass( 'empty-row screen-reader-text' );
                            row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
                            return false;
                        });
                    
                        $( '.remove-row' ).on('click', function() {
                            $(this).parents('tr').remove();                
                            return false;
                        });
                    });
                </script>
                <table class="hide_if_standard show_if_usb">
                    <tr>
                        <th>Disable For Front-End</th>
                    </tr>
                    <?php
                    $show_tlc_qty = json_decode(get_post_meta($post->ID,'_show_tlc_qty',true));
                    ?>
                  
                    <tr>
                        <td>50 <input <?php if(!empty($show_tlc_qty) && in_array('50', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="50"></td>
                        <td>100 <input <input <?php if(!empty($show_tlc_qty) && in_array('100', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="100"></td>
                        <td>250 <input <?php if(!empty($show_tlc_qty) && in_array('250', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="250"></td>
                        <td>500 <input <?php if(!empty($show_tlc_qty) && in_array('500', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="500"></td>
                        <td>1000 <input <?php if(!empty($show_tlc_qty) && in_array('1000', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="1000"></td>
                        <td>2500 <input <?php if(!empty($show_tlc_qty) && in_array('2500', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="2500"></td>
                        <td>5000 <input <?php if(!empty($show_tlc_qty) && in_array('5000', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="5000"></td>
                    </tr>
                    
                </table>
                 <p class='form-field'>  
                <?php
                global $post;                
                ?>
                
                <span class="hide_if_standard show_if_usb">
                    
                 <label>Show OEM TLC</label>
                  <?php
                $show_oem_value = get_post_meta($post->ID, '_show_oem', true);
                if ($show_oem_value == "yes") {$show_oem_checked = 'checked="checked"';} else{$show_oem_checked = '';}
                    ?>
                   <input type="checkbox" name="show_oem" value="yes" <?php echo $show_oem_checked; ?> />
                </span> 
                </p>
                <p class='form-field'>
                    <span class="hide_if_standard show_if_usb">
                    <label><strong>Info:</strong></label> <textarea name="_info_oemtlc"><?php echo get_post_meta($post->ID, '_info_oemtlc', true);?></textarea>
                   </span>
                </p>


                <p><strong>OEM TLC</strong></p>
                <table id="repeatable-fieldset-one" >
                    <thead>
                        <tr>
                            <th>GB</th>
                            <th>50</th>
                            <th>100</th>
                            <th>250</th>                           
                            <th>500</th>
                            <th>1000</th>
                            <th>2500</th>
                            <th>5000</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($usb_ocm_tlc) {
                            
                            foreach ($usb_ocm_tlc as $key => $value) {
                                // print_r($value);
                                ?>
                                <tr>
                                    <td>
                                        <!-- <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php //echo $key;?>][]" value="<?php //echo $value[0]; ?>" /> -->
                                        <?php
                                        $usb_quantities = get_terms( array(
                                        'taxonomy' => 'usb_quantity',
                                        'hide_empty' => false,
                                        ) );
                                        ?>
                                        <select name="usb_ocm_tlc[<?php echo $key;?>][]">  
                                          <option value="">Select</option>                                
                                            <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                              <option <?php if($value[0]==$usb_quantity->term_id){echo 'selected';}?> value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                            <?php }?>
                                          </select>
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[1]; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[2]; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[3]; ?>" />
                                    </td>
                                    
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[4]; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[5]; ?>" />                    
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[6]; ?>" />                    
                                    </td>    
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[7]; ?>" />                    
                                    </td> 
                                    <td><a class="button remove-row" href="#">Remove</a></td>
                                </tr>
                                <?php
                            } 
                        } else {
                            ?>
                            <tr>
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php //echo $c;?>][]" value="" /> -->
                                    <?php
                                    $usb_quantities = get_terms( array(
                                    'taxonomy' => 'usb_quantity',
                                    'hide_empty' => false,
                                    ) );
                                    ?>
                                    <select name="usb_ocm_tlc[<?php echo $c;?>][]"> 
                                        <option value="">Select</option>                                  
                                        <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                          <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                        <?php }?>
                                      </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                            <?php
                        }
                        ?>
                    
                    
                        
                        
                        
                        <!-- empty hidden one for jQuery -->
                        <tr class="empty-row screen-reader-text">
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php //echo $c;?>][]" value="" /> -->
                                    <?php
                                    $usb_quantities = get_terms( array(
                                    'taxonomy' => 'usb_quantity',
                                    'hide_empty' => false,
                                    ) );
                                    ?>
                                    <select name="usb_ocm_tlc[<?php echo $c;?>][]"> 
                                        <option value="">Select</option>                                  
                                        <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                          <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                        <?php }?>
                                      </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                    </tbody>
                </table>
                
                <p><a id="add-row" class="button" href="#">Add another</a></p> 

                <?php 
                $usb_oem_mlc = array();
                $usb_oem_mlc = json_decode(get_post_meta($post->ID,'_usb_oem_mlc',true),true); 
                if (!empty($usb_oem_mlc)) {
                    $c = count($usb_oem_mlc);
                    $usb_oem_mlc = array_map('array_filter', $usb_oem_mlc);
                    $usb_oem_mlc = array_filter($usb_oem_mlc);
                } else {
                    $c = 0;
                }
                
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function( $ ){
                        var oem_mlc_count = <?php echo $c; ?>;
                        $( '#add-row-oem-mlc' ).on('click', function() {
                            oem_mlc_count = oem_mlc_count + 1;
                            $( '.empty-row.oem_mlc td input' ).attr('name','usb_oem_mlc['+oem_mlc_count+'][]');
                            $( '.empty-row.oem_mlc td select' ).attr('name','usb_oem_mlc['+oem_mlc_count+'][]');
                            var row = $( '.empty-row.oem_mlc' ).clone(true);
                            row.removeClass( 'empty-row oem_mlc' );
                            row.insertBefore( '#repeatable-fieldset-one-oem-mlc tbody>tr:last' ).show();
                            return false;
                        });
                    
                        $( '.remove-row' ).on('click', function() {
                            $(this).parents('tr').remove();                
                            return false;
                        });
                    });
                </script>
                <table class="hide_if_standard show_if_usb">
                        <tr>
                            <th>Disable For Front-End</th>
                        </tr>
                        <?php
                        $show_mlc_qty = json_decode(get_post_meta($post->ID,'_show_mlc_qty',true));
                        ?>
                        <tr>
                            <td>50 <input <?php if(!empty($show_mlc_qty) && in_array('50', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="50"></td>
                            <td>100 <input <?php if(!empty($show_mlc_qty) && in_array('100', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="100"></td>
                            <td>250 <input <?php if(!empty($show_mlc_qty) && in_array('250', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="250"></td>
                            <td>500 <input <?php if(!empty($show_mlc_qty) && in_array('500', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="500"></td>
                            <td>1000 <input <?php if(!empty($show_mlc_qty) && in_array('1000', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="1000"></td>
                            <td>2500 <input <?php if(!empty($show_mlc_qty) && in_array('2500', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="2500"></td>
                            <td>5000 <input <?php if(!empty($show_mlc_qty) && in_array('5000', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="5000"></td>
                        </tr>
                    </table>
                <p class='form-field'>  
                <?php
                global $post;                
                ?>

                <span class="hide_if_standard show_if_usb">
                    
                 <label>Show OEM MLC</label>
                  <?php
                $show_mlc_value = get_post_meta($post->ID, '_show_mlc', true);
                if ($show_mlc_value == "yes"){$show_mlc_checked = 'checked="checked"';} else {$show_mlc_checked = '';}
                    ?>
                   <input type="checkbox" name="show_mlc" value="yes" <?php echo $show_mlc_checked; ?> />
                </span> 
                </p>
                <p class='form-field'>
                <span class="hide_if_standard show_if_usb">
                    <label><strong>Information:</strong></label> <textarea name="_info_oemmlc"><?php echo get_post_meta($post->ID, '_info_oemmlc', true);?></textarea>
                </span>
                </p>
                <p><strong>OEM MLC</strong></p>
                <table id="repeatable-fieldset-one-oem-mlc" >
                    <thead>
                        <tr>
                            <th>GB</th>
                            <th>50</th>
                            <th>100</th>
                            <th>250</th>                           
                            <th>500</th>
                            <th>1000</th>
                            <th>2500</th>
                            <th>5000</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($usb_oem_mlc){
                                foreach ($usb_oem_mlc as $key => $value) {
                                    // print_r($value);
                                    ?>
                                    <tr>
                                        <td>
                                            <!-- <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php //echo $key;?>][]" value="<?php //echo $value[0]; ?>" /> -->
                                            <?php
                                            $usb_quantities = get_terms( array(
                                            'taxonomy' => 'usb_quantity',
                                            'hide_empty' => false,
                                            ) );
                                            ?>
                                            <select name="usb_oem_mlc[<?php echo $key;?>][]">  
                                              <option value="">Select</option>                                
                                                <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                                  <option <?php if($value[0]==$usb_quantity->term_id){echo 'selected';}?> value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                                <?php }?>
                                              </select>
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[1]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[2]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[3]; ?>" />
                                        </td>
                                        
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[4]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[5]; ?>" />                    
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[6]; ?>" />                    
                                        </td>    
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[7]; ?>" />                    
                                        </td> 
                                        <td><a class="button remove-row" href="#">Remove</a></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php //echo $c;?>][]" value="" /> -->
                                <?php
                                $usb_quantities = get_terms( array(
                                'taxonomy' => 'usb_quantity',
                                'hide_empty' => false,
                                ) );
                                ?>
                                <select name="usb_oem_mlc[<?php echo $c;?>][]"> 
                                    <option value="">Select</option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                    <?php }?>
                                  </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                                <?php
                            }
                        ?>
                    
                    
                        
                        
                        
                        <!-- empty hidden one for jQuery -->
                        <tr class="empty-row oem_mlc" style="display: none;">
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php //echo $c;?>][]" value="" /> -->
                                <?php
                                $usb_quantities = get_terms( array(
                                'taxonomy' => 'usb_quantity',
                                'hide_empty' => false,
                                ) );
                                ?>
                                <select name="usb_oem_mlc[<?php echo $c;?>][]"> 
                                    <option value="">Select</option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                    <?php }?>
                                  </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                    </tbody>
                </table>

                <p><a id="add-row-oem-mlc" class="button" href="#">Add another</a></p>
                  

                <?php 
                $usb_original = array();
                $usb_original = json_decode(get_post_meta($post->ID,'_usb_original',true),true); 
                if (!empty($usb_original)) {
                    $original_cnt = count($usb_original);
                    $usb_original = array_map('array_filter', $usb_original);
                    $usb_original = array_filter($usb_original);
                } else {
                    $original_cnt = 0;
                }
                
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function( $ ){
                        var original_count = <?php echo $original_cnt; ?>;
                        $( '#add-row-original' ).on('click', function() {
                            original_count = original_count + 1;
                            $( '.empty-row.original td input' ).attr('name','usb_original['+original_count+'][]');
                            $( '.empty-row.original td select' ).attr('name','usb_original['+original_count+'][]');
                            var row = $( '.empty-row.original' ).clone(true);
                            row.removeClass( 'empty-row original' );
                            row.insertBefore( '#repeatable-fieldset-one-original tbody>tr:last' ).show();
                            return false;
                        });
                    
                        $( '.remove-row' ).on('click', function() {
                            $(this).parents('tr').remove();                
                            return false;
                        });
                    });
                </script>

                <table class="hide_if_standard show_if_usb">
                        <tr><th>Disable For Front-End</th></tr>
                        <?php
                        $show_original_qty = json_decode(get_post_meta($post->ID,'_show_original_qty',true));
                        ?>
                        <tr>
                            <td>50 <input <?php if(!empty($show_original_qty) && in_array('50', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="50"></td>
                            <td>100 <input <?php if(!empty($show_original_qty) && in_array('100', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="100"></td>
                            <td>250 <input <?php if(!empty($show_original_qty) && in_array('250', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="250"></td>
                            <td>500 <input <?php if(!empty($show_original_qty) && in_array('500', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="500"></td>
                            <td>1000 <input <?php if(!empty($show_original_qty) && in_array('1000', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="1000"></td>
                            <td>2500 <input <?php if(!empty($show_original_qty) && in_array('2500', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="2500"></td>
                            <td>5000 <input <?php if(!empty($show_original_qty) && in_array('5000', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="5000"></td>
                        </tr>
                    </table>
                <p class='form-field'>  
                <?php
                global $post;                
                ?>

                <span class="hide_if_standard show_if_usb">
                    
                 <label>Show Original</label>
                  <?php
                $original_value = get_post_meta($post->ID, '_original', true);
                if ($original_value == "yes") {$original_checked = 'checked="checked"';}else {$original_checked = '';}
                    ?>
                   <input type="checkbox" name="original" value="yes" <?php echo $original_checked; ?> />
                </span> 
                </p>
                <p class='form-field'>
                    <span class="hide_if_standard show_if_usb">
                    <label><strong>Info:</strong></label> <textarea name="_info_original"><?php echo get_post_meta($post->ID, '_info_original', true);?></textarea>
                    </span>
                </p>
                <p><strong>Original</strong></p>
                <table id="repeatable-fieldset-one-original" >
                    <thead>
                        <tr>
                            <th>GB</th>
                            <th>50</th>
                            <th>100</th>
                            <th>250</th>                           
                            <th>500</th>
                            <th>1000</th>
                            <th>2500</th>
                            <th>5000</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($usb_original){
                                foreach ($usb_original as $key => $value) {
                                    // print_r($value);
                                    ?>
                                    <tr>
                                        <td>
                                            <!-- <input type="text" style="width: 100%;" name="usb_original[<?php //echo $key;?>][]" value="<?php //echo $value[0]; ?>" /> -->
                                            <?php
                                            $usb_quantities = get_terms( array(
                                            'taxonomy' => 'usb_quantity',
                                            'hide_empty' => false,
                                            ) );
                                            ?>
                                            <select name="usb_original[<?php echo $key;?>][]">  
                                              <option value="">Select</option>                                
                                                <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                                  <option <?php if($value[0]==$usb_quantity->term_id){echo 'selected';}?> value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                                <?php }?>
                                              </select>
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[1]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[2]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[3]; ?>" />
                                        </td>
                                        
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[4]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[5]; ?>" />                    
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[6]; ?>" />                    
                                        </td>    
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[7]; ?>" />                    
                                        </td> 
                                        <td><a class="button remove-row" href="#">Remove</a></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_original[<?php //echo $original_cnt;?>][]" value="" /> -->
                                <?php
                                $usb_quantities = get_terms( array(
                                'taxonomy' => 'usb_quantity',
                                'hide_empty' => false,
                                ) );
                                ?>
                                <select name="usb_original[<?php echo $original_cnt;?>][]"> 
                                    <option value="">Select</option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                    <?php }?>
                                  </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                                <?php
                            }
                        ?>
                    
                    
                        
                        
                        
                        <!-- empty hidden one for jQuery -->
                        <tr class="empty-row original" style="display: none;">
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_original[<?php //echo $original_cnt;?>][]" value="" /> -->
                                <?php
                                $usb_quantities = get_terms( array(
                                'taxonomy' => 'usb_quantity',
                                'hide_empty' => false,
                                ) );
                                ?>
                                <select name="usb_original[<?php echo $original_cnt;?>][]"> 
                                    <option value="">Select</option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                    <?php }?>
                                  </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                    </tbody>
                </table>

                <p><a id="add-row-original" class="button" href="#">Add another</a></p> 
                               
            </div>
            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>  

                        <?php
                        $get_attribute_vl = get_post_meta($post->ID,'attribute_vl_2',true);
                       // print_r($get_attribute_vl);
                        $get_attribute_pr_vl = get_post_meta($post->ID,'attribute_pr_vl_usb',true);
                        $attributes = $product->get_attributes();
                        foreach ( $attributes as $attribute ) {
                            $attribute_name = $attribute['name'];

                            $explode_attribute_name = explode("_",$attribute_name);
                            ?>
                            <div class='options_group'> 
                                <div class='wc-metaboxes'>  
                                    <div class='wc-metabox'>                    
                                        <p class='form-field'>  
                                            <strong><?php echo $explode_attribute_name[1];?></strong>
                                        </p>
                                    </div>
                                </div>      
                            </div>
                            <?php
                            $get_attribute = wc_get_product_terms( $product->id,$attribute_name, array( 'fields' => 'all' ) );
                            foreach ( $get_attribute as $get_attribute_key => $get_attribute_value) {

                                    $get_attribute_id = $get_attribute_value->term_id;
                                    $get_attribute_name = $get_attribute_value->name;

                                    $field_name = $get_attribute_name.'_'.$get_attribute_id;
                                    $field_name = str_replace(' ', '', $field_name);
                                    $attribute_vl = (!empty($get_attribute_vl[$field_name])) ? $get_attribute_vl[$field_name] :'';
                                    $attribute_pr_vl = (!empty($get_attribute_pr_vl[$field_name])) ? $get_attribute_pr_vl[$field_name] :'';
                                    $attribute_vl_chk = ($attribute_vl=='yes')?'checked':'';
                                    ?>
                                    <div class='options_group'> 
                                        <div class='wc-metaboxes'>  
                                            <div class='wc-metabox'>                    
                                                <p class='form-field'>  
                                                    <label><?php echo $get_attribute_name;?></label>
                                                    <input <?php echo $attribute_vl_chk;?> type="checkbox" name="attribute_vl_2[<?php echo $field_name;?>]"  value="yes"/>



                                                    <input type="text" name="attribute_pr_vl_usb[<?php echo $field_name;?>]"  value="<?php echo $attribute_pr_vl;?>"/>
                                                </p>
                                            </div>
                                        </div>      
                                    </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
}

// Save the custom fields.
function process_builder_meta_standard($post_id)
{


    update_post_meta( $post_id, 'attribute_vl', $_POST['attribute_vl'] );
   
    update_post_meta( $post_id, 'attribute_pr_vl', $_POST['attribute_pr_vl'] );
    

    update_post_meta($post_id, '_price_option_50', $_POST['_price_option_50']);
    update_post_meta($post_id, '_price_option_100', $_POST['_price_option_100']);
    update_post_meta($post_id, '_price_option_250', $_POST['_price_option_250']);
    update_post_meta($post_id, '_price_option_500', $_POST['_price_option_500']);
    update_post_meta($post_id, '_price_option_1000', $_POST['_price_option_1000']);
    update_post_meta($post_id, '_price_option_2500', $_POST['_price_option_2500']);
    update_post_meta($post_id, '_price_option_5000', $_POST['_price_option_5000']);
    if (isset($_POST['_active_qty'])) {
        update_post_meta($post_id, '_active_qty', $_POST['_active_qty']);
    } else {
        update_post_meta($post_id, '_active_qty', '50');
    }
    update_post_meta($post_id, '_show_stnd_qty', json_encode($_POST['_show_stnd_qty']));
    
    // Updating Data For set Own Quantity

}
add_action('woocommerce_process_product_meta_standard', 'process_builder_meta_standard');


function process_builder_meta_usb($post_id)
{
	update_post_meta( $post_id, 'attribute_vl_2', $_POST['attribute_vl_2'] );
	update_post_meta( $post_id, 'attribute_pr_vl_usb', $_POST['attribute_pr_vl_usb'] );

    update_post_meta($post_id, '_info_oemtlc', $_POST['_info_oemtlc']);
    update_post_meta($post_id, '_info_oemmlc', $_POST['_info_oemmlc']);
    update_post_meta($post_id, '_info_original', $_POST['_info_original']);

    update_post_meta($post_id, '_show_tlc_qty', json_encode($_POST['_show_tlc_qty']));
    update_post_meta($post_id, '_show_mlc_qty', json_encode($_POST['_show_mlc_qty']));
    update_post_meta($post_id, '_show_original_qty', json_encode($_POST['_show_original_qty']));

    $usb_ocm_tlc = array_map('array_filter', $_POST['usb_ocm_tlc']);
    $usb_ocm_tlc = array_filter($usb_ocm_tlc);

    $usb_oem_mlc = array_map('array_filter', $_POST['usb_oem_mlc']);
    $usb_oem_mlc = array_filter($usb_oem_mlc);

    $usb_original = array_map('array_filter', $_POST['usb_original']);
    $usb_original = array_filter($usb_original);

    foreach ($usb_ocm_tlc as $key => $value) {
        foreach ($value as $key2 => $value2) {
          if ($key2 == 0) {
            $newkey = $value2;
          }
          $usb_ocm_tlc_arr[$newkey][] = $value2;
        }
    }
    foreach ($usb_oem_mlc as $key => $value) {
        foreach ($value as $key2 => $value2) {
          if ($key2 == 0) {
            $newkey = $value2;
          }
          $usb_oem_mlc_arr[$newkey][] = $value2;
        }
    }
    foreach ($usb_original as $key => $value) {
        foreach ($value as $key2 => $value2) {
          if ($key2 == 0) {
            $newkey = $value2;
          }
          $usb_original_arr[$newkey][] = $value2;
        }
    }    

    update_post_meta($post_id, '_usb_ocm_tlc', json_encode($usb_ocm_tlc_arr));
    update_post_meta($post_id, '_usb_oem_mlc', json_encode($usb_oem_mlc_arr));
    update_post_meta($post_id, '_usb_original', json_encode($usb_original_arr));

    if (isset($_POST['show_oem'])) {
        update_post_meta($post_id, '_show_oem', 'yes');
    }  else {
        update_post_meta($post_id, '_show_oem', 'no');
    }  
    if (isset($_POST['show_mlc'])) {
        update_post_meta($post_id, '_show_mlc', 'yes');
    }  else {
        update_post_meta($post_id, '_show_mlc', 'no');
    }
    if (isset($_POST['original'])) {
        update_post_meta($post_id, '_original', 'yes');
    }  else {
        update_post_meta($post_id, '_original', 'no');
    }
}
add_action('woocommerce_process_product_meta_usb', 'process_builder_meta_usb');


//  Add code for select option
add_filter( 'product_type_selector', 'custom_usb_type' );
function custom_usb_type ( $type ) {
    $type[ 'standard' ] = __( 'Standard' );
    $type[ 'usb' ] = __( 'USB' );
    return $type;
}

/**
 * Register the custom product type after init
 */
function register_standard_product_type() {
    /**
     * This should be in its own separate file.
     */
    class WC_Product_standard extends WC_Product {
      public function __construct( $product ) {
            $this->product_type = 'standard';
            parent::__construct( $product );
      }
}

}
add_action( 'init', 'register_standard_product_type' );

function register_usb_product_type() {
    /**
     * This should be in its own separate file.
     */
    class WC_Product_usb extends WC_Product {
      public function __construct( $product ) {
            $this->product_type = 'usb';
            parent::__construct( $product );
      }
}

}
add_action( 'init', 'register_usb_product_type' );


add_filter( 'woocommerce_product_data_tabs', 'usb_product_data_tabs' );
function usb_product_data_tabs( $tabs ) {
    $tabs[ 'variations' ][ 'class' ][] = 'show_if_standard';
    $tabs[ 'variations' ][ 'class' ][] = 'show_if_usb';

    $tabs[ 'inventory' ][ 'class' ][] = 'show_if_standard';
    $tabs[ 'inventory' ][ 'class' ][] = 'show_if_usb';

    $tabs[ 'usb_builder' ][ 'class' ][] = 'hide_if_standard';
    $tabs[ 'usb_builder' ][ 'class' ][] = 'show_if_usb';

    $tabs[ 'builder' ][ 'class' ][] = 'show_if_standard';
    $tabs[ 'builder' ][ 'class' ][] = 'hide_if_usb';

 

     
    
    return $tabs;
} 


/// Add code for include standard and usb page in woocoomerce
function standard_add_to_cart() {
    wc_get_template( 'woocommerce/single-product/add-to-cart/standard.php' );
  }
add_action('woocommerce_standard_add_to_cart',  'standard_add_to_cart');

function usb_add_to_cart() {
    wc_get_template( 'woocommerce/single-product/add-to-cart/usb.php' );
  }
add_action('woocommerce_usb_add_to_cart',  'usb_add_to_cart');

function variable_add_to_cart() {
    wc_get_template( 'woocommerce/single-product/add-to-cart/variable.php' );
  }
add_action('woocommerce_variable_add_to_cart',  'variable_add_to_cart');


add_action('wp_enqueue_scripts', 'usb_ajx_scripts');
function usb_ajx_scripts() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-form');
  $ajaxurl = admin_url('admin-ajax.php');
  $ajax_nonce = wp_create_nonce('USB');
  wp_localize_script( 'jquery-core', 'ajaxVars', array( 'ajaxurl' => $ajaxurl, 'ajax_nonce' => $ajax_nonce ) );
}




add_action( 'wp_ajax_data_usb_ocm_tlc', 'data_usb_ocm_tlc_fnc' );
add_action( 'wp_ajax_nopriv_data_usb_ocm_tlc', 'data_usb_ocm_tlc_fnc' );

function data_usb_ocm_tlc_fnc() {
    global $woocommerce_wpml;
    $cur_lang       = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    // $crncy = get_woocommerce_currency();
    $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];

    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $show_tlc_qty = json_decode(get_post_meta($cus_product_id,'_show_tlc_qty',true),true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id,'_usb_ocm_tlc',true));

    /*get attribute price for USB product*/
    $usb_quantity = get_terms( 'usb_quantity', array(
        'hide_empty' => 0,
    ) );
    if ( ! empty( $usb_quantity ) && ! is_wp_error( $usb_quantity ) ){
      $usb_quantity_arr = array();
        foreach ( $usb_quantity as $usb_qty ) {
          $usb_quantity_arr[] = $usb_qty->term_id;
        }
    }
    /*get attribute price for USB product*/
    
    foreach ($dataset as $key => $value) {
        // $usb_arr[] = json_decode(get_term_meta($key,'_usb_ocm_tlc',true),true);
        $usb_atr = array();
        $price50   = get_term_meta($key, '_price50', true);
        $price50   = str_replace(",",".",$price50);
        $price50 = (!empty($price50)) ? $price50 : '0.0';

        $price100  = get_term_meta($key, '_price100', true);
        $price100   = str_replace(",",".",$price100);
        $price100 = (!empty($price100)) ? $price100 : '0.0';

        $price250  = get_term_meta($key, '_price250', true);
        $price250   = str_replace(",",".",$price250);
        $price250 = (!empty($price250)) ? $price250 : '0.0';

        $price500  = get_term_meta($key, '_price500', true);
        $price500   = str_replace(",",".",$price500);
        $price500 = (!empty($price500)) ? $price500 : '0.0';

        $price1000 = get_term_meta($key, '_price1000', true);
        $price1000   = str_replace(",",".",$price1000);
        $price1000 = (!empty($price1000)) ? $price1000 : '0.0';

        $price2500 = get_term_meta($key, '_price2500', true);
        $price2500   = str_replace(",",".",$price2500);
        $price2500 = (!empty($price2500)) ? $price2500 : '0.0';

        $price5000 = get_term_meta($key, '_price5000', true);
        $price5000   = str_replace(",",".",$price5000);
        $price5000 = (!empty($price5000)) ? $price5000 : '0.0';
        
        foreach ($usb_quantity_arr as $usb_value) {
          $usb_atr[$usb_value][] = $usb_value;
          $usb_atr[$usb_value][] = $price50;
          $usb_atr[$usb_value][] = $price100;
          $usb_atr[$usb_value][] = $price250;
          $usb_atr[$usb_value][] = $price500;
          $usb_atr[$usb_value][] = $price1000;
          $usb_atr[$usb_value][] = $price2500;
          $usb_atr[$usb_value][] = $price5000;
        }
        $usb_arr[] = $usb_atr;
    }
    
    $usb_arr[] = $usb_ocm_tlc;
    
    $resume = [];

    foreach ($usb_arr as $data) {
            foreach ($data as $key => $value) {
                if (!array_key_exists($key, $resume)) {
                    $resume[$key] = $value;
                } else {
                    foreach ($value as $index => $number) {
                        $resume[$key][$index] += $number;
                    }
                }
            }
    }

    ksort($resume);
    // $resume = json_encode($resume);
    // $resume = json_decode($resume,true);
    // echo $resume[64][2];
    // die();

        foreach ($usb_ocm_tlc as $key => $value) {
        ?>
        <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
        <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
        <?php 
        $category = get_term_by('id', $key,'usb_quantity');
        echo $category->name;
        ?>
        </td>
        <?php 
        $qty1 = $resume[$key][1]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty1 = $qty1*$rate_change;
        $qty1 = number_format((float)$qty1, 2, '.', '');
        }
        ?>
        <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_tlc_qty) && in_array('50', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty1; ?>
        </td>
        <?php 
        $qty2 = $resume[$key][2]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty2 = $qty2*$rate_change;
        $qty2 = number_format((float)$qty2, 2, '.', '');
        }
        ?>
        <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_tlc_qty) && in_array('100', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty2; ?>
        </td>
        <?php 
        $qty3 = $resume[$key][3]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty3 = $qty3*$rate_change;
        $qty3 = number_format((float)$qty3, 2, '.', '');
        }
        ?>
        <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_tlc_qty) && in_array('250', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty3; ?>
        </td>
        <?php 
        $qty4 = $resume[$key][4]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty4 = $qty4*$rate_change;
        $qty4 = number_format((float)$qty4, 2, '.', '');
        }
        ?>
        <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_tlc_qty) && in_array('500', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty4; ?>
        </td>
        <?php 
        $qty5 = $resume[$key][5]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty5 = $qty5*$rate_change;
        $qty5 = number_format((float)$qty5, 2, '.', '');
        }
        ?>
        <td class="customer qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_tlc_qty) && in_array('1000', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty5; ?>               
        </td>
        <?php 
        $qty6 = $resume[$key][6]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty6 = $qty6*$rate_change;
        $qty6 = number_format((float)$qty6, 2, '.', '');
        }
        ?>
        <td class="customer qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_tlc_qty) && in_array('2500', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty6; ?>            
        </td>    
        <?php 
        $qty7 = $resume[$key][7]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty7 = $qty7*$rate_change;
        $qty7 = number_format((float)$qty7, 2, '.', '');
        }
        ?>
        <td class="customer qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_tlc_qty) && in_array('5000', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty7; ?>            
        </td> 
        </tr>
        <?php
        }

    die();
}


add_action( 'wp_ajax_data_usb_oem_mlc', 'data_usb_oem_mlc_fnc' );
add_action( 'wp_ajax_nopriv_data_usb_oem_mlc', 'data_usb_oem_mlc_fnc' );

function data_usb_oem_mlc_fnc() {
    global $woocommerce_wpml;
    $cur_lang       = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];

    $show_mlc_qty = json_decode(get_post_meta($cus_product_id,'_show_mlc_qty',true),true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id,'_usb_oem_mlc',true));
    /*get attribute price for USB product*/
    $usb_quantity = get_terms( 'usb_quantity', array(
        'hide_empty' => 0,
    ) );
    if ( ! empty( $usb_quantity ) && ! is_wp_error( $usb_quantity ) ){
      $usb_quantity_arr = array();
        foreach ( $usb_quantity as $usb_qty ) {
          $usb_quantity_arr[] = $usb_qty->term_id;
        }
    }
    /*get attribute price for USB product*/


    foreach ($dataset as $key => $value) {
        // $usb_arr[] = json_decode(get_term_meta($key,'_usb_oem_mlc',true),true);
        $usb_atr = array();
        $price50   = get_term_meta($key, '_price50', true);
        $price50   = str_replace(",",".",$price50);
        $price50 = (!empty($price50)) ? $price50 : '0.0';

        $price100  = get_term_meta($key, '_price100', true);
        $price100   = str_replace(",",".",$price100);
        $price100 = (!empty($price100)) ? $price100 : '0.0';

        $price250  = get_term_meta($key, '_price250', true);
        $price250   = str_replace(",",".",$price250);
        $price250 = (!empty($price250)) ? $price250 : '0.0';

        $price500  = get_term_meta($key, '_price500', true);
        $price500   = str_replace(",",".",$price500);
        $price500 = (!empty($price500)) ? $price500 : '0.0';

        $price1000 = get_term_meta($key, '_price1000', true);
        $price1000   = str_replace(",",".",$price1000);
        $price1000 = (!empty($price1000)) ? $price1000 : '0.0';

        $price2500 = get_term_meta($key, '_price2500', true);
        $price2500   = str_replace(",",".",$price2500);
        $price2500 = (!empty($price2500)) ? $price2500 : '0.0';

        $price5000 = get_term_meta($key, '_price5000', true);
        $price5000   = str_replace(",",".",$price5000);
        $price5000 = (!empty($price5000)) ? $price5000 : '0.0';
        
        foreach ($usb_quantity_arr as $usb_value) {
          $usb_atr[$usb_value][] = $usb_value;
          $usb_atr[$usb_value][] = $price50;
          $usb_atr[$usb_value][] = $price100;
          $usb_atr[$usb_value][] = $price250;
          $usb_atr[$usb_value][] = $price500;
          $usb_atr[$usb_value][] = $price1000;
          $usb_atr[$usb_value][] = $price2500;
          $usb_atr[$usb_value][] = $price5000;
        }
        $usb_arr[] = $usb_atr;
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
            foreach ($data as $key => $value) {
                if (!array_key_exists($key, $resume)) {
                    $resume[$key] = $value;
                } else {
                    foreach ($value as $index => $number) {
                        $resume[$key][$index] += $number;
                    }
                }
            }
    }

    ksort($resume);

        foreach ($usb_ocm_tlc as $key => $value) {
        ?>
        <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
        <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
        <?php 
        $category = get_term_by('id', $key,'usb_quantity');
        echo $category->name;
        ?>
        </td>
        <?php 
        $qty1 = $resume[$key][1]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty1 = $qty1*$rate_change;
        $qty1 = number_format((float)$qty1, 2, '.', '');
        }
        ?>
        <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_mlc_qty) && in_array('50', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty1; ?>
        </td>
        <?php 
        $qty2 = $resume[$key][2]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty2 = $qty2*$rate_change;
        $qty2 = number_format((float)$qty2, 2, '.', '');
        }
        ?>
        <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_mlc_qty) && in_array('100', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty2; ?>
        </td>
        <?php 
        $qty3 = $resume[$key][3]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty3 = $qty3*$rate_change;
        $qty3 = number_format((float)$qty3, 2, '.', '');
        }
        ?>
        <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_mlc_qty) && in_array('250', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty3; ?>
        </td>
        <?php 
        $qty4 = $resume[$key][4]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty4 = $qty4*$rate_change;
        $qty4 = number_format((float)$qty4, 2, '.', '');
        }
        ?>
        <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_mlc_qty) && in_array('500', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty4; ?>
        </td>
        <?php 
        $qty5 = $resume[$key][5]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty5 = $qty5*$rate_change;
        $qty5 = number_format((float)$qty5, 2, '.', '');
        }
        ?>
        <td class="customer qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_mlc_qty) && in_array('1000', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty5; ?>               
        </td>
        <?php 
        $qty6 = $resume[$key][6]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty6 = $qty6*$rate_change;
        $qty6 = number_format((float)$qty6, 2, '.', '');
        }
        ?>
        <td class="customer qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_mlc_qty) && in_array('2500', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty6; ?>            
        </td>  
        <?php 
        $qty7 = $resume[$key][7]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty7 = $qty7*$rate_change;
        $qty7 = number_format((float)$qty7, 2, '.', '');
        }
        ?>  
        <td class="customer qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_mlc_qty) && in_array('5000', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty7; ?>            
        </td> 
        </tr>
        <?php
        }

    die();
}


add_action( 'wp_ajax_data_usb_original', 'data_usb_original_fnc' );
add_action( 'wp_ajax_nopriv_data_usb_original', 'data_usb_original_fnc' );

function data_usb_original_fnc() {
    global $woocommerce_wpml;
    $cur_lang       = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $show_original_qty = json_decode(get_post_meta($cus_product_id,'_show_original_qty',true),true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id,'_usb_original',true));

    // echo get_post_meta($cus_product_id,'_usb_original',true);
    // die();
    /*get attribute price for USB product*/
    $usb_quantity = get_terms( 'usb_quantity', array(
        'hide_empty' => 0,
    ) );
    if ( ! empty( $usb_quantity ) && ! is_wp_error( $usb_quantity ) ){
      $usb_quantity_arr = array();
        foreach ( $usb_quantity as $usb_qty ) {
          $usb_quantity_arr[] = $usb_qty->term_id;
        }
    }
    /*get attribute price for USB product*/


    foreach ($dataset as $key => $value) {
        // $usb_arr[] = json_decode(get_term_meta($key,'_usb_original_data',true),true);
        $usb_atr = array();
        $price50   = get_term_meta($key, '_price50', true);
        $price50   = str_replace(",",".",$price50);
        $price50 = (!empty($price50)) ? $price50 : '0.0';

        $price100  = get_term_meta($key, '_price100', true);
        $price100   = str_replace(",",".",$price100);
        $price100 = (!empty($price100)) ? $price100 : '0.0';

        $price250  = get_term_meta($key, '_price250', true);
        $price250   = str_replace(",",".",$price250);
        $price250 = (!empty($price250)) ? $price250 : '0.0';

        $price500  = get_term_meta($key, '_price500', true);
        $price500   = str_replace(",",".",$price500);
        $price500 = (!empty($price500)) ? $price500 : '0.0';

        $price1000 = get_term_meta($key, '_price1000', true);
        $price1000   = str_replace(",",".",$price1000);
        $price1000 = (!empty($price1000)) ? $price1000 : '0.0';

        $price2500 = get_term_meta($key, '_price2500', true);
        $price2500   = str_replace(",",".",$price2500);
        $price2500 = (!empty($price2500)) ? $price2500 : '0.0';

        $price5000 = get_term_meta($key, '_price5000', true);
        $price5000   = str_replace(",",".",$price5000);
        $price5000 = (!empty($price5000)) ? $price5000 : '0.0';
        
        foreach ($usb_quantity_arr as $usb_value) {
          $usb_atr[$usb_value][] = $usb_value;
          $usb_atr[$usb_value][] = $price50;
          $usb_atr[$usb_value][] = $price100;
          $usb_atr[$usb_value][] = $price250;
          $usb_atr[$usb_value][] = $price500;
          $usb_atr[$usb_value][] = $price1000;
          $usb_atr[$usb_value][] = $price2500;
          $usb_atr[$usb_value][] = $price5000;
        }
        $usb_arr[] = $usb_atr;
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
            foreach ($data as $key => $value) {
                if (!array_key_exists($key, $resume)) {
                    $resume[$key] = $value;
                } else {
                    foreach ($value as $index => $number) {
                        $resume[$key][$index] += $number;
                    }
                }
            }
    }

    ksort($resume);

        foreach ($usb_ocm_tlc as $key => $value) {
        ?>
        <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
        <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
        <?php 
        $category = get_term_by('id', $key,'usb_quantity');
        echo $category->name;
        ?>
        </td>
        <?php 
        $qty1 = $resume[$key][1]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty1 = $qty1*$rate_change;
        $qty1 = number_format((float)$qty1, 2, '.', '');
        }
        ?> 
        <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_original_qty) && in_array('50', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty1; ?>
        </td>
        <?php 
        $qty2 = $resume[$key][2]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty2 = $qty2*$rate_change;
        $qty2 = number_format((float)$qty2, 2, '.', '');
        }
        ?>
        <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_original_qty) && in_array('100', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty2; ?>
        </td>
        <?php 
        $qty3 = $resume[$key][3]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty3 = $qty3*$rate_change;
        $qty3 = number_format((float)$qty3, 2, '.', '');
        }
        ?>
        <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_original_qty) && in_array('250', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty3; ?>
        </td>
        <?php 
        $qty4 = $resume[$key][4]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty4 = $qty4*$rate_change;
        $qty4 = number_format((float)$qty4, 2, '.', '');
        }
        ?>
        <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_original_qty) && in_array('500', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty4; ?>
        </td>
        <?php 
        $qty5 = $resume[$key][5]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty5 = $qty5*$rate_change;
        $qty5 = number_format((float)$qty5, 2, '.', '');
        }
        ?>
        <td class="customer qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_original_qty) && in_array('1000', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty5; ?>               
        </td>
        <?php 
        $qty6 = $resume[$key][6]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty6 = $qty6*$rate_change;
        $qty6 = number_format((float)$qty6, 2, '.', '');
        }
        ?>
        <td class="customer qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_original_qty) && in_array('2500', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty6; ?>            
        </td> 
        <?php 
        $qty7 = $resume[$key][7]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty7 = $qty7*$rate_change;
        $qty7 = number_format((float)$qty7, 2, '.', '');
        }
        ?>   
        <td class="customer qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_original_qty) && in_array('5000', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php echo $qty7; ?>            
        </td> 
        </tr>
        <?php
        }

    die();
}


// margin
add_action( 'wp_ajax_margin_usb_ocm_tlc', 'margin_usb_ocm_tlc_fnc' );
add_action( 'wp_ajax_nopriv_margin_usb_ocm_tlc', 'margin_usb_ocm_tlc_fnc' );

function margin_usb_ocm_tlc_fnc() {
    global $woocommerce_wpml;
    $cur_lang       = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $cus_margin = $_POST['cus_margin'];
    $show_tlc_qty = json_decode(get_post_meta($cus_product_id,'_show_tlc_qty',true),true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id,'_usb_ocm_tlc',true));


    if($dataset){
        foreach ($dataset as $key => $value) {
            $usb_arr[] = json_decode(get_term_meta($key,'_usb_ocm_tlc',true),true);
        }
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
            foreach ($data as $key => $value) {
                if (!array_key_exists($key, $resume)) {
                    $resume[$key] = $value;
                } else {
                    foreach ($value as $index => $number) {
                        $resume[$key][$index] += $number;
                    }
                }
            }
    }

    ksort($resume);

        foreach ($usb_ocm_tlc as $key => $value) {
        ?>
        <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
        <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
        <?php 
        $category = get_term_by('id', $key,'usb_quantity');
        echo $category->name;
        ?>
        </td>
        <?php 
        $qty1 = $resume[$key][1]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty1 = $qty1*$rate_change;
        $qty1 = number_format((float)$qty1, 2, '.', '');
        }
        ?>
        <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_tlc_qty) && in_array('50', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key1 = $qty1;
        echo $key1 + (($key1*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty2 = $resume[$key][2]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty2 = $qty2*$rate_change;
        $qty2 = number_format((float)$qty2, 2, '.', '');
        }
        ?>
        <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_tlc_qty) && in_array('100', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key2 = $qty2; 
        echo $key2 + (($key2*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty3 = $resume[$key][3]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty3 = $qty3*$rate_change;
        $qty3 = number_format((float)$qty3, 2, '.', '');
        }
        ?>
        <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_tlc_qty) && in_array('250', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key3 = $qty3; 
        echo $key3 + (($key3*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty4 = $resume[$key][4]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty4 = $qty4*$rate_change;
        $qty4 = number_format((float)$qty4, 2, '.', '');
        }
        ?>
        <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_tlc_qty) && in_array('500', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key4 = $qty4; 
        echo $key4 + (($key4*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty5 = $resume[$key][5]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty5 = $qty5*$rate_change;
        $qty5 = number_format((float)$qty5, 2, '.', '');
        }
        ?>
        <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_tlc_qty) && in_array('1000', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key5 = $qty5; 
        echo $key5 + (($key5*$cus_margin)/100);
        ?>               
        </td>
        <?php 
        $qty6 = $resume[$key][6]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty6 = $qty6*$rate_change;
        $qty6 = number_format((float)$qty6, 2, '.', '');
        }
        ?>
        <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_tlc_qty) && in_array('2500', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key6 = $qty6; 
        echo $key6 + (($key6*$cus_margin)/100);
        ?>            
        </td>
        <?php 
        $qty7 = $resume[$key][7]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty7 = $qty7*$rate_change;
        $qty7 = number_format((float)$qty7, 2, '.', '');
        }
        ?>    
        <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_tlc_qty) && in_array('5000', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key7 = $qty7; 
        echo $key7 + (($key7*$cus_margin)/100);
        ?>           
        </td> 
        </tr>
        <?php
        }

    die();
}


/**/
add_action( 'wp_ajax_margin_usb_oem_mlc', 'margin_usb_oem_mlc_fnc' );
add_action( 'wp_ajax_nopriv_margin_usb_oem_mlc', 'margin_usb_oem_mlc_fnc' );

function margin_usb_oem_mlc_fnc() {
    global $woocommerce_wpml;
    $cur_lang       = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $cus_margin = $_POST['cus_margin'];
    $show_mlc_qty = json_decode(get_post_meta($cus_product_id,'_show_mlc_qty',true),true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id,'_usb_oem_mlc',true));



    foreach ($dataset as $key => $value) {
        $usb_arr[] = json_decode(get_term_meta($key,'_usb_oem_mlc',true),true);
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
            foreach ($data as $key => $value) {
                if (!array_key_exists($key, $resume)) {
                    $resume[$key] = $value;
                } else {
                    foreach ($value as $index => $number) {
                        $resume[$key][$index] += $number;
                    }
                }
            }
    }

    ksort($resume);

        foreach ($usb_ocm_tlc as $key => $value) {
        ?>
        <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
        <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
        <?php 
        $category = get_term_by('id', $key,'usb_quantity');
        echo $category->name;
        ?>
        </td>
        <?php 
        $qty1 = $resume[$key][1]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty1 = $qty1*$rate_change;
        $qty1 = number_format((float)$qty1, 2, '.', '');
        }
        ?>
        <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_mlc_qty) && in_array('50', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key1 = $qty1;
        echo $key1 + (($key1*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty2 = $resume[$key][2]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty2 = $qty2*$rate_change;
        $qty2 = number_format((float)$qty2, 2, '.', '');
        }
        ?>
        <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_mlc_qty) && in_array('100', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key2 = $qty2; 
        echo $key2 + (($key2*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty3 = $resume[$key][3]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty3 = $qty3*$rate_change;
        $qty3 = number_format((float)$qty3, 2, '.', '');
        }
        ?>
        <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_mlc_qty) && in_array('250', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key3 = $qty3; 
        echo $key3 + (($key3*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty4 = $resume[$key][4]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty4 = $qty4*$rate_change;
        $qty4 = number_format((float)$qty4, 2, '.', '');
        }
        ?>
        <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_mlc_qty) && in_array('500', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key4 = $qty4; 
        echo $key4 + (($key4*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty5 = $resume[$key][5]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty5 = $qty5*$rate_change;
        $qty5 = number_format((float)$qty5, 2, '.', '');
        }
        ?>
        <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_mlc_qty) && in_array('1000', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key5 = $qty5; 
        echo $key5 + (($key5*$cus_margin)/100);
        ?>               
        </td>
        <?php 
        $qty6 = $resume[$key][6]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty6 = $qty6*$rate_change;
        $qty6 = number_format((float)$qty6, 2, '.', '');
        }
        ?>
        <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_mlc_qty) && in_array('2500', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key6 = $qty6; 
        echo $key6 + (($key6*$cus_margin)/100);
        ?>            
        </td> 
        <?php 
        $qty7 = $resume[$key][7]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty7 = $qty7*$rate_change;
        $qty7 = number_format((float)$qty7, 2, '.', '');
        }
        ?>   
        <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_mlc_qty) && in_array('5000', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key7 = $qty7; 
        echo $key7 + (($key7*$cus_margin)/100);
        ?>           
        </td> 
        </tr>
        <?php
        }

    die();
}


add_action( 'wp_ajax_margin_usb_original', 'margin_usb_original_fnc' );
add_action( 'wp_ajax_nopriv_margin_usb_original', 'margin_usb_original_fnc' );

function margin_usb_original_fnc() {
    global $woocommerce_wpml;
    $cur_lang       = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $cus_margin = $_POST['cus_margin'];
    $show_original_qty = json_decode(get_post_meta($cus_product_id,'_show_original_qty',true),true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id,'_usb_original',true));

    // echo get_post_meta($cus_product_id,'_usb_original',true);
    // die();



    foreach ($dataset as $key => $value) {
        $usb_arr[] = json_decode(get_term_meta($key,'_usb_original_data',true),true);
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
            foreach ($data as $key => $value) {
                if (!array_key_exists($key, $resume)) {
                    $resume[$key] = $value;
                } else {
                    foreach ($value as $index => $number) {
                        $resume[$key][$index] += $number;
                    }
                }
            }
    }

    ksort($resume);

        foreach ($usb_ocm_tlc as $key => $value) {
        ?>
        <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
        <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
        <?php 
        $category = get_term_by('id', $key,'usb_quantity');
        echo $category->name;
        ?>
        </td>
        <?php 
        $qty1 = $resume[$key][1]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty1 = $qty1*$rate_change;
        $qty1 = number_format((float)$qty1, 2, '.', '');
        }
        ?> 
        <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_original_qty) && in_array('50', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key1 = $qty1;
        echo $key1 + (($key1*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty2 = $resume[$key][2]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty2 = $qty2*$rate_change;
        $qty2 = number_format((float)$qty2, 2, '.', '');
        }
        ?>
        <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_original_qty) && in_array('100', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key2 = $qty2; 
        echo $key2 + (($key2*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty3 = $resume[$key][3]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty3 = $qty3*$rate_change;
        $qty3 = number_format((float)$qty3, 2, '.', '');
        }
        ?>
        <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_original_qty) && in_array('250', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key3 = $qty3; 
        echo $key3 + (($key3*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty4 = $resume[$key][4]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty4 = $qty4*$rate_change;
        $qty4 = number_format((float)$qty4, 2, '.', '');
        }
        ?>
        <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_original_qty) && in_array('500', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key4 = $qty4; 
        echo $key4 + (($key4*$cus_margin)/100);
        ?>
        </td>
        <?php 
        $qty5 = $resume[$key][5]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty5 = $qty5*$rate_change;
        $qty5 = number_format((float)$qty5, 2, '.', '');
        }
        ?>
        <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_original_qty) && in_array('1000', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key5 = $qty5; 
        echo $key5 + (($key5*$cus_margin)/100);
        ?>               
        </td>
        <?php 
        $qty6 = $resume[$key][6]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty6 = $qty6*$rate_change;
        $qty6 = number_format((float)$qty6, 2, '.', '');
        }
        ?>
        <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_original_qty) && in_array('2500', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key6 = $qty6; 
        echo $key6 + (($key6*$cus_margin)/100);
        ?>            
        </td>
        <?php 
        $qty7 = $resume[$key][7]; 
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
        $qty7 = $qty7*$rate_change;
        $qty7 = number_format((float)$qty7, 2, '.', '');
        }
        ?>    
        <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_original_qty) && in_array('5000', $show_original_qty)) { echo 'style="display:none;"';} ?>>
        <?php 
        $key7 = $qty7; 
        echo $key7 + (($key7*$cus_margin)/100);
        ?>           
        </td>
        </tr>
        <?php
        }

    die();
}


add_action( 'wp_ajax_usbcomment', 'usbcomment_fnc' );
add_action( 'wp_ajax_nopriv_usbcomment', 'usbcomment_fnc' );

function usbcomment_fnc() {
    global $wpdb;
    if (!empty(trim($_POST['usbcomment'])) && isset($_POST['usbcomment']) && isset($_POST['cus_product_id'])) {
        update_post_meta($_POST['cus_product_id'],'_usbcomment',$_POST['usbcomment']);
    }
    wp_die();
}

// redirect user as per language
add_filter('woocommerce_login_redirect', 'wc_login_redirect');
 
function wc_login_redirect( $redirect_to ) {
    $current_user_id = get_current_user_id();
    $user_meta = get_user_meta(2,'locale',true);
    $lang_arr = explode('_', $user_meta); $lang = $lang_arr[0];
    $languages = icl_get_languages('skip_missing=0');
    if (!empty($lang)) {
        $redirect_to = $languages[$lang]['url'];
        return $redirect_to;
    } else {
        return $redirect_to;
    }     
     
}

function usb_remove_product_editor() {
  remove_post_type_support( 'product', 'editor' );
}
add_action( 'init', 'usb_remove_product_editor' );


/******************************************************** Updated On 25-03-2019 ***********************************/

/* Join posts and postmeta tables
 *
 * @param string   $join
 * @param WP_Query $query
 *
 * @return string
 */
function el_product_search_join( $join, $query ) {
    if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
        return $join;
    }
 
    global $wpdb;
 
    $join .= " LEFT JOIN {$wpdb->postmeta} el_post_meta ON {$wpdb->posts}.ID = el_post_meta.post_id ";
 
    return $join;
}
 
add_filter( 'posts_join', 'el_product_search_join', 10, 2 );
 
/**
 * Modify the search query with posts_where.
 *
 * @param string   $where
 * @param WP_Query $query
 *
 * @return string
 */
function el_product_search_where( $where, $query ) {
    if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
        return $where;
    }
 
    global $wpdb;
 
    $where = preg_replace(
        "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
        "({$wpdb->posts}.post_title LIKE $1) OR (el_post_meta.meta_key = '_sku' AND el_post_meta.meta_value LIKE $1)", $where );
 
    return $where;
}
 
add_filter( 'posts_where', 'el_product_search_where', 10, 2 );

//USB Download PDF shortcode function
if( ! function_exists('usb_pdf_down_fun') ) {
    // Add Shortcode
    function usb_pdf_down_fun( $atts ) {
            $atts   = shortcode_atts(array(
               'pdf_name' => ''
           ), $atts, 'usb_pdf_down_fun');
           $pdf_name = explode(",", $atts['pdf_name']);
        ob_start();
        ?>
        <a class="dwnpdf" href='' target='_blank'><?php if (!empty($pdf_name[0])) echo $pdf_name[0]; ?></a>
        <?php
    }
    add_shortcode( 'usb_pdf', 'usb_pdf_down_fun' );
}

add_filter ( 'woocommerce_account_menu_items', 'usb_remove_my_account_links' );
function usb_remove_my_account_links( $menu_links ){
 
    unset( $menu_links['edit-address'] ); // Addresses
    return $menu_links;
}


// Adding a custom Meta container to admin products pages for custom quantity set
add_action( 'add_meta_boxes', 'create_custom_meta_box_set_quantity' );
if ( ! function_exists( 'create_custom_meta_box_set_quantity' ) )
{
    function create_custom_meta_box_set_quantity()
    {
        add_meta_box(
            'set_own_quantity',
            __( 'Set Price For Own Quantity', 'usb' ),
            'add_custom_content_meta_box',
            'product',
            'normal',
            'default'
        );
    }
}

//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_box' ) ){
    function add_custom_content_meta_box( $post ){
?>

<table>
    <tbody>
        <tr>
            <td>
                <label>Set own price 50 - 99</label><br/>
                <?php $custom_quantity_set99 = get_post_meta($post->ID, '_custom_quantity_set99', true) ? get_post_meta($post->ID, '_custom_quantity_set99', true) : ''; ?>
                <input type="text" name="_custom_quantity_set99" value="<?php echo $custom_quantity_set99;?>">
            </td>
            <td>
                <label>Set own price 100 - 249</label><br/>
                <?php $custom_quantity_set249 = get_post_meta($post->ID, '_custom_quantity_set249', true) ? get_post_meta($post->ID, '_custom_quantity_set249', true) : ''; ?>
                <input type="text" name="_custom_quantity_set249" value="<?php echo $custom_quantity_set249;?>">
            </td>
        
        
            <td>
                <label>Set own price 250 - 499</label><br/>
                <?php $custom_quantity_set499 = get_post_meta($post->ID, '_custom_quantity_set499', true) ? get_post_meta($post->ID, '_custom_quantity_set499', true) : ''; ?>
                <input type="text" name="_custom_quantity_set499" value="<?php echo $custom_quantity_set499;?>"> 
            </td>
            <td>
                <label> Set own price 500 - 999</label><br/>
                <?php $custom_quantity_set999 = get_post_meta($post->ID, '_custom_quantity_set999', true) ? get_post_meta($post->ID, '_custom_quantity_set999', true) : ''; ?>
                <input type="text" name="_custom_quantity_set999" value="<?php echo $custom_quantity_set999;?>">   
            </td>
        </tr>
        <tr>
            <td>
                <label>Set own price 1000 - 2499</label><br/>
                <?php $custom_quantity_set2499 = get_post_meta($post->ID, '_custom_quantity_set2499', true) ? get_post_meta($post->ID, '_custom_quantity_set2499', true) : ''; ?>
                <input type="text" name="_custom_quantity_set2499" value="<?php echo $custom_quantity_set2499;?>">    
            </td>
            <td>
                <label>Set own price 2500 - 4999</label><br/>
                <?php $custom_quantity_set4999 = get_post_meta($post->ID, '_custom_quantity_set4999', true) ? get_post_meta($post->ID, '_custom_quantity_set4999', true) : ''; ?>
                <input type="text" name="_custom_quantity_set4999" value="<?php echo $custom_quantity_set4999;?>">    
            </td>
            <td>
                <label>Set own price 5000 - 9999</label><br/>
                <?php $custom_quantity_set9999 = get_post_meta($post->ID, '_custom_quantity_set9999', true) ? get_post_meta($post->ID, '_custom_quantity_set9999', true) : ''; ?>
                <input type="text" name="_custom_quantity_set9999" value="<?php echo $custom_quantity_set9999;?>">    
            </td>
        </tr>
    </tbody>
</table>

<?php
    }
}

//Save the data of the Meta field
add_action( 'save_post', 'save_custom_content_meta_box', 10, 1 );
if ( ! function_exists( 'save_custom_content_meta_box' ) )
{

    function save_custom_content_meta_box( $post_id ) {

        // Sanitize user input and update the meta field in the database.
        /*update_post_meta( $post_id, '_custom_quantity_set99', wp_kses_post($_POST[ '_custom_quantity_set99' ]) );
        update_post_meta( $post_id, '_custom_quantity_set249', wp_kses_post($_POST[ '_custom_quantity_set249' ]) );
        update_post_meta( $post_id, '_custom_quantity_set499', wp_kses_post($_POST[ '_custom_quantity_set499' ]) );
        update_post_meta( $post_id, '_custom_quantity_set999', wp_kses_post($_POST[ '_custom_quantity_set999' ]) );
        update_post_meta( $post_id, '_custom_quantity_set2499', wp_kses_post($_POST[ '_custom_quantity_set2499' ]) );
        update_post_meta( $post_id, '_custom_quantity_set4999', wp_kses_post($_POST[ '_custom_quantity_set4999' ]) );
        update_post_meta( $post_id, '_custom_quantity_set9999', wp_kses_post($_POST[ '_custom_quantity_set9999' ]) );*/

        // Updating Value for Set Own Quantity
        update_post_meta( $post_id, '_custom_quantity_set99', $_POST[ '_price_option_50' ] );
        update_post_meta( $post_id, '_custom_quantity_set249', $_POST[ '_price_option_100' ] );
        update_post_meta( $post_id, '_custom_quantity_set499', $_POST[ '_price_option_250' ] );
        update_post_meta( $post_id, '_custom_quantity_set999', $_POST[ '_price_option_500' ] );
        update_post_meta( $post_id, '_custom_quantity_set2499', $_POST[ '_price_option_1000' ] );
        update_post_meta( $post_id, '_custom_quantity_set4999', $_POST[ '_price_option_2500' ] );
        update_post_meta( $post_id, '_custom_quantity_set9999', $_POST[ '_price_option_5000' ] );
    }
}

add_action( 'wp_ajax_usbown_quantity', 'usbown_quantity_fnc' );
add_action( 'wp_ajax_nopriv_usbown_quantity', 'usbown_quantity_fnc' );
function usbown_quantity_fnc(){
    global $wpdb;
    global $product;
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;

    $productid =$_POST['productid'];
    $usbquantity =$_POST['qtyval'];
    $crncyval =$_POST['curncyval'];
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncyval]['rate'];

    if((50 <= $usbquantity) && ($usbquantity <= 99)){
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set99', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float)$quantity_price, 2, '.', '');
        }
        else{
          $quantity_price = get_post_meta($productid, '_custom_quantity_set99', true);  
        }
    }
    else if ((100 <= $usbquantity) && ($usbquantity <= 249)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set249', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float)$quantity_price, 2, '.', '');
        }
        else{
            $quantity_price = get_post_meta($productid, '_custom_quantity_set249', true);
        }
    }
    else if ((250 <= $usbquantity) && ($usbquantity <= 499)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set499', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float)$quantity_price, 2, '.', '');
        }
        else{
            $quantity_price = get_post_meta($productid, '_custom_quantity_set499', true);
        }
    }
    else if ((500 <= $usbquantity) && ($usbquantity <= 999)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set999', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float)$quantity_price, 2, '.', '');
        }
        else{
            $quantity_price = get_post_meta($productid, '_custom_quantity_set999', true);
        }
    }
    else if ((1000 <= $usbquantity) && ($usbquantity <= 2499)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set2499', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float)$quantity_price, 2, '.', '');
        }
        else{
            $quantity_price = get_post_meta($productid, '_custom_quantity_set2499', true);
        }
    }
    else if ((2500 <= $usbquantity) && ($usbquantity <= 4999)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set4999', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float)$quantity_price, 2, '.', '');
        }
        else{
           $quantity_price = get_post_meta($productid, '_custom_quantity_set4999', true); 
        }
    }
    else if ((5000 <= $usbquantity) && ($usbquantity <= 9999)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set9999', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float)$quantity_price, 2, '.', '');
        }
        else{
            $quantity_price = get_post_meta($productid, '_custom_quantity_set9999', true);
        }
    }
    else{
        $quantity_price = 0;
    }
    echo $quantity_price;
die();
}

//Standar product Offer pdf for calulation

 add_action( 'wp_ajax_usb_product_summary', 'usb_product_summary_fnc' );
add_action( 'wp_ajax_nopriv_usb_product_summary', 'usb_product_summary_fnc' );

function usb_product_summary_fnc(){
    $offer_id= $_POST['product_id'];
    $summary = $_POST['summary'];
    $user_ID = get_current_user_id();
    $summary_html = get_post_meta($offer_id, '_offer_summary_html'.'_'.$user_ID, true);
    update_post_meta($offer_id, '_offer_summary_html'.'_'.$user_ID, $summary, $summary_html);
}

// usb product pdf akax
 add_action( 'wp_ajax_usb_product_summary_v2', 'usb_product_summary_v2_fnc' );
add_action( 'wp_ajax_nopriv_usb_product_summary_v2', 'usb_product_summary_v2_fnc' );

function usb_product_summary_v2_fnc(){
    $offer_id= $_POST['product_id'];
    
    $oem_tlc = $_POST['oem_tlc'];
    $oem_mlc = $_POST['oem_mlc'];
    $original = $_POST['original'];
    
    $user_ID = get_current_user_id();
    
    update_post_meta($offer_id, '_offer_tlcproductsummary_html'.'_'.$user_ID, $oem_tlc);
    update_post_meta($offer_id, '_offer_mlcproductsummary_html'.'_'.$user_ID, $oem_mlc);
    update_post_meta($offer_id, '_offer_originalproductsummary_html'.'_'.$user_ID, $original);
}


//set product per page
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = '-1';
  return $cols;
}


add_filter( 'woocommerce_account_menu_items', 'usbnu_remove_address_my_account', 999 );
 
function usbnu_remove_address_my_account( $items ) {
unset($items['orders']);
unset($items['downloads']);
return $items;
}

/**
 * Remove password strength check.
 */
function usb_remove_password_strength() {
    wp_dequeue_script( 'wc-password-strength-meter' );
}
add_action( 'wp_print_scripts', 'usb_remove_password_strength', 10 );



function customer_data_hide_function() {
    $user = wp_get_current_user();
    if ( in_array( 'customer', (array) $user->roles ) ) {
        //The user has the "author" role
        ?>
        <style type="text/css">
            .custom-usb-table-sec .customer {display: none;}
        </style>
        <?php
    }
}
add_action( 'wp_footer', 'customer_data_hide_function' );

function my_custom_styles() {
    $popular_color = get_theme_value("product_popular_color_code");
    $novelty_color = get_theme_value("product_novelty_color_code");
    if(!empty($popular_color)){
    echo "<style>.tag-sky1, .tag-sky { background:". $popular_color ." !important }</style>";
    }
    if(!empty($novelty_color)){
    echo "<style>.tag-red1, .tag-red { background:". $novelty_color ." !important }</style>";
    }
}

add_action('wp_head','my_custom_styles');

////////////
//USB Download zip shortcode function
if( ! function_exists('usb_zip_file_down_fun') ) {
    // Add Shortcode
    function usb_zip_file_down_fun( $atts ) {
            $atts   = shortcode_atts(
                array(
                   'zip_file_name' => '',
                   'zip_file_link' =>'',
               ), $atts, 'usb_zip_file_down_fun'
            );
           $zip_file_name = explode(",", $atts['zip_file_name']);
           $zip_file_link = explode(",", $atts['zip_file_link']);
        ob_start();
        ?>
        <p><a class="dwnzip_file" href="<?php if (!empty($zip_file_link[0])) echo $zip_file_link[0]; ?>"><?php if (!empty($zip_file_name[0])) echo $zip_file_name[0]; ?></a></p>
        <?php
    }
    add_shortcode( 'usb_zip_download', 'usb_zip_file_down_fun' );
}


/*10-11-2020*/
/*
 * Add Revision support to WooCommerce Products
 * 
 */

// add_filter( 'woocommerce_register_post_type_product', 'cinch_add_revision_support' );

// function cinch_add_revision_support( $supports ) {
//      $supports['supports'][] = 'revisions';

//      return $supports;
// }