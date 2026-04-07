<?php
/***
* sliders Post Type
***/

if(! class_exists('usb_sliders_Post_Type')):
class usb_sliders_Post_Type{

	function __construct(){
		// Adds the sliders post type and taxonomies
		add_action('init',array(&$this,'sliders_init'),0);
		// Thumbnail support for sliders posts
		add_theme_support('post-thumbnails',array('sliders'));
	}

	function sliders_init(){
		/**
		 * Enable the sliders_init custom post type
		 * http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		$labels = array(
			'name'					=> __('Sliders','usb'),
			'singular_name'		=> __('Slider Name','usb'),
			'add_new'				=> __('Add New','usb'),
			'add_new_item'			=> __('Add New Slider','usb'),
			'edit_item'			=> __('Edit Slider','usb'),
			'new_item'				=> __('Add New Slider','usb'),
			'view_item'			=> __('View Slider','usb'),
			'search_items'			=> __('Search sliders','usb'),
			'not_found'			=> __('No sliders items found','usb'),
			'not_found_in_trash'	=> __('No sliders found in trash','usb')
		);
		
		$args = array(
		    'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-images-alt2',
			'rewrite' => true,			
			'map_meta_cap' => true,
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array('title','thumbnail','editor','page-attributes')
		); 
		



		$args = apply_filters('usb_sliders_args',$args);
		register_post_type('sliders',$args);
			}
}
new usb_sliders_Post_Type;
endif;
add_action("admin_init", "admin_init");
 function admin_init()
{
  add_meta_box("scheduling_option", "Slider Button Section", "scheduling_option", "sliders", "normal", "low");
}

function scheduling_option() 
{ global $wpdb,$post;?>
  
  <table>
  <tr>
  <td><?php _e( 'Slider Button Text :', 'usb' ); ?> </td>
 <td><input type="text" id="sider_text"  name="sider_text" value="<?php echo get_post_meta($post->ID,'sider_text',true); ?>" style="width:700px;" /></td>
 </tr>
 <tr>
  <td><?php _e( 'Slider Button Link :', 'usb' ); ?> </td>
 <td><input type="text" id="slider_button"  name="slider_button" value="<?php echo get_post_meta($post->ID,'slider_button',true); ?>" style="width:700px;" /></td>
 </tr>
 
  </table>

<?php } 

add_action('transition_post_status', 'save_details');
function save_details()
{
global $wpdb,$post;	
update_post_meta($post->ID, 'sider_text', $_POST["sider_text"]);
update_post_meta($post->ID, 'slider_button', $_POST["slider_button"]);		
}