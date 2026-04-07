<?php
add_action("admin_init", "admin_init");
 function admin_init()
{
  add_meta_box("scheduling_option", "Product Summary", "scheduling_option", "product", "normal", "low");
}

function scheduling_option() 
{ global $wpdb,$post;?>
  
  <table>
  
 <tr>
  <td><?php _e( 'USB Option', 'usb' ); ?><?php _e( 'Product Summary', 'usb' ); ?></td>
 <td><input type="text" id="product_summary"  name="product_summary" value="<?php echo get_post_meta($post->ID,'product_summary',true); ?>" style="width:700px;" /></td>
 </tr>
 
  </table>

<?php } 

add_action('transition_post_status', 'save_details');
function save_details()
{
global $wpdb,$post;	
update_post_meta($post->ID, 'product_summary', $_POST["product_summary"]);

}