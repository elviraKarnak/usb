<?php 
add_action( 'add_meta_boxes', 'business_facts_metabox' );              
function business_facts_metabox() 
    {   
        add_meta_box('business_facts', 'Product Summary', 'business_facts_output', 'product', 'normal', 'high');
    }

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





