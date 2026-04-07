<?php    
function usb_quantity_taxonomy() {
    $labels = array(
        'name'              => _x( 'Usb Quantity', 'taxonomy general name' ),
        'singular_name'     => _x( 'Usb Quantity', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Usb Quantity' ),
        'all_items'         => __( 'All Usb Quantity' ),
        'parent_item'       => __( 'Parent Usb Quantity' ),
        'parent_item_colon' => __( 'Parent Usb Quantity' ),
        'edit_item'         => __( 'Edit Usb Quantity' ), 
        'update_item'       => __( 'Update Usb Quantity' ),
        'add_new_item'      => __( 'Add New Usb Quantity' ),
        'new_item_name'     => __( 'New Usb Quantity' ),
        'menu_name'         => __( 'Usb Quantity' ),
    );

$args = array(
    'labels' => $labels,
    'hierarchical' => true,
    'query_var' => true,
    'rewrite' => true,
    'show_admin_column' => true
);

register_taxonomy( 'usb_quantity', 'product', $args );
        
}
add_action( 'init', 'usb_quantity_taxonomy', 0 );