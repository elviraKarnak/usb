<?php 
add_action( 'add_meta_boxes', 'business_facts_metabox' );              
function business_facts_metabox() 
    {   
         add_meta_box('business_facts', 
            'Product Summary', 
            'business_facts_output', 
            'product', 
            'normal', 
            'high'
        );

         add_meta_box(
            'custom_image_upload', // Unique ID
            'Custom Attribute Upload', // Box title
            'custom_image_upload_callback', // Callback function
            'product', // Post type
            'normal', // Context
            'high' // Priority
        );


    }

function custom_image_upload_callback($post) {
    // Use nonce for verification
    wp_nonce_field(basename(__FILE__), 'custom_image_upload_nonce');

   // echo $post->ID;

    $_product = wc_get_product( $post->ID ); // Get the WC_Product Object      

    //print_r( $_product);                           
    $product_attributes = $_product->get_attributes(); // Get the product attributes
    if(isset($product_attributes['pa_color'])):
        $color_options=$product_attributes['pa_color']['options'];
        if($color_options):?>
            <style type="text/css">
                .small_image{width: 150px;}
                .hide_text{display: none;}
                .user-img-box {
                  position: relative;
                  width: 100px;
                  height: 250px;
                  transition: all .5s;
                }

                .user-img {
                  width: 100px;
                  height: 200px;
                  border-radius: 100px;
                }

                .cross-btn {
                  position: absolute;
                  right: 0;
                  top: 0;
                  background-color: red;
                  border: 1px solid #4a4a4a78;
                  border-radius: 100px;
                  width: 25px;
                  height: 25px;
                  color: #fff;
                  font-weight: bold;
                  opacity: 0;
                  transition: all .5s;
                  cursor: pointer;
                  outline: none;
                }

                .user-img-box:hover .cross-btn  {
                  opacity: 1;
                }
            </style>
            <?php
             $placeholder_src= WC()->plugin_url() . '/assets/images/placeholder.png';
             foreach($color_options as $col_opt):
                $col_opt_term=get_term( $col_opt);
                $image_url = get_post_meta($post->ID, 'custom_image_upload_field_'.$col_opt_term->slug, true);
                ?>

                <table>

                <tr class="product_attribute_images">

                    <td>
                        <label for="custom_image_upload_field"><strong>Upload Image for <?php  echo $col_opt_term->name;?>:</strong></label>
                    </td>
                    <?php if($image_url):?>
                         <td>
                            <div class="user-img-box">               
                                <img src="<?php echo wp_get_attachment_url($image_url);?>" class="small_image" id="image_btn_custom_image_upload_<?php  echo $col_opt_term->slug;?>" src2="<?php echo $placeholder_src;?>"> 
                                <button class="cross-btn" id="image_upload_<?php  echo $col_opt_term->slug;?>"><span>&#935;</span></button>
                            </div>
                        </td>       
                    <?php else:

                        
                        ?>
                        <td>
                        <img src="<?php echo $placeholder_src;?>" class="small_image" id="image_btn_custom_image_upload_<?php  echo $col_opt_term->slug;?>"> 
                        </td>    
                    <?php endif;?>
                    <td>
                        <input type="text" id="custom2_image_upload_<?php  echo $col_opt_term->slug;?>" class="custom_image_upload_field hide_text" name="custom_image_upload_field_<?php  echo $col_opt_term->slug;?>" value="<?php echo $image_url; ?>" />
                        <input type="button" class="button upload_image_button_<?php  echo $col_opt_term->slug;?>" id="btn_custom_image_upload_<?php  echo $col_opt_term->slug;?>" value="Upload Image" />
                    </td>
                </tr>

                <tr class="product_sku">

                     <td>
                        <label for="custom_image_upload_field"><strong>Add Sku For <?php  echo $col_opt_term->name;?> Color:</strong></label>
                    </td>

                        <?php
                         $get_value=0;
                         $get_value=get_post_meta($post->ID,'custom_sku_'.$col_opt_term->slug,true);?>

                        <td>
                            <div class="input-box">               
                                <input type="text" name="custom_sku_<?php  echo $col_opt_term->slug;?>" value="<?php echo $get_value;?>">
                            </div>
                        </td>

                    </tr>
                </table>

            <script>
                jQuery(document).ready(function ($) {
                    // Media uploader

                     $('body').on('click', '.cross-btn', function(e){  
                        e.preventDefault();
                        var this_id=$(this).attr('id');
                        var text_id='custom2_'+this_id;
                        console.log(text_id);
                        $('#'+text_id).attr('value','');
                        var place_img=$(this).prev('img').attr('src2');
                        $(this).prev('img').attr('src', place_img);
                    });
                    var mediaUploader;
                    $('body').on('click', '.upload_image_button_<?php  echo $col_opt_term->slug;?>', function(e){      
                        e.preventDefault();
                        $(this).addClass('this_one');
                        var button=$(this).prev('input');  
                        var this_id=$(this).attr('id');
                        var image_id='image_'+this_id;
                        if (mediaUploader) {
                            mediaUploader.open();
                            return;
                        }
                        mediaUploader = wp.media.frames.file_frame = wp.media({
                            title: 'Choose Image',
                            button: {
                                text: 'Choose Image'
                            },
                            multiple: false
                        });
                        mediaUploader.on('select', function () {
                            var attachment = mediaUploader.state().get('selection').first().toJSON(); 
                            $(button).val(attachment.id);
                            $('#'+image_id).attr('src',attachment.url);
                        });
                        mediaUploader.open();
                    });
                });
            </script>

            <?php endforeach;
        endif;
    endif;


    // Get saved value
    

    // Output HTML for the form
    ?>
    
    
    <?php
}

function save_custom_image_upload_meta($post_id) {
    // Verify nonce
    if (!isset($_POST['custom_image_upload_nonce']) || !wp_verify_nonce($_POST['custom_image_upload_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check post type
    if ('product' !== $_POST['post_type']) {
        return $post_id;
    }


    $product = wc_get_product( $post_id ); // Get the WC_Product Object                                 
    $product_attributes = $product->get_attributes(); // Get the product attributes
    //echo "<pre>";

    //print_r($_POST);

   // print_r($product_attributes);
//
   // die;

    if(isset($product_attributes['pa_color'])):
        $color_options=$product_attributes['pa_color']['options'];
        if($color_options):
            foreach($color_options as $col_opt):
                $col_opt_term=get_term( $col_opt);
                $image_meta_id = 'custom_image_upload_field_'.$col_opt_term->slug;
              //  die;
                $custom_sku= 'custom_sku_'.$col_opt_term->slug;
                // Save data
                if (isset($_POST[$image_meta_id])):
                    update_post_meta($post_id, $image_meta_id, $_POST[$image_meta_id]);
                endif;

                if (isset($_POST[$custom_sku])):
                    update_post_meta($post_id, $custom_sku, $_POST[$custom_sku]);
                endif;
            endforeach;
        endif;
    endif;

}
add_action('save_post', 'save_custom_image_upload_meta');

function business_facts_output( $post ) 
    {
    //so, dont ned to use esc_attr in front of get_post_meta
    $business_facts_value=  get_post_meta($_GET['post'], 'business_facts' , true ) ;
    wp_editor( htmlspecialchars_decode($business_facts_value), 'business-facts', $settings = array('textarea_name'=>'business-facts') );
    }


function save_business_facts( $post_id ) 
{                   
    if (!empty($_POST['business-facts']))
        {
            $data=htmlspecialchars($_POST['business-facts']);
            update_post_meta($post_id, 'business_facts', $data );
        }
}
add_action( 'save_post', 'save_business_facts' ); 


/*Product Comment*/
add_action( 'add_meta_boxes', 'usbcomment_metabox' );              
function usbcomment_metabox() {   
    add_meta_box('usbcommentsection', 'Product Comment', 'usbcomment_output', 'product');
}

function usbcomment_output( $post ) {

    $post_id = $post->ID;
    $content = get_post_meta($post_id,'_usbcomment',true);
    $editor_id = 'usbcomment';
    wp_editor( $content, $editor_id );

}


function save_usbcomment( $post_id ) {                   
    $data=htmlspecialchars($_POST['usbcomment']);
    //update_post_meta($post_id, '_usbcomment', $data );
    if (isset($data) && !empty(trim($data))) {
        update_post_meta($post_id, '_usbcomment', $data );
    }
}
add_action( 'save_post', 'save_usbcomment' ); 