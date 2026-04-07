<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

the_title( '<h1 class="product_title entry-title notranslate">', '</h1>' );
global $product;
?>
<div class="d-flex item-no-sc">
	<div>
	<span class="itemNo_label notranslate">Article No.</span>
	<span  class="itemNo "><?php echo $product->get_sku(); ?></span>
	</div>
	<div>
	
	<?php 
	$attributes = $product->get_attributes();
	if (isset($attributes['pa_color'])) {
		$color_terms = wc_get_product_terms( $product->get_id(), 'pa_color', array( 'fields' => 'names' ) );
		if ( ! empty( $color_terms ) ) {
			echo '<span class="color_label">Color:</span><span class="product-color">' . implode( ', ', $color_terms ) . '</span>';
		}
	}
	?>
	</div>
</div>


<?php 
if ( get_post_type( $post ) === 'product' && ! is_a($product, 'WC_Product') ) {
    $product = wc_get_product( get_the_id() ); // Get the WC_Product Object
}

$product_attributes = $product->get_attributes(); // Get the product attributes

if(isset($product_attributes['pa_color'])){
	$color_options=$product_attributes['pa_color']['options'];
	if($color_options){
		echo "<h2>".__('Available colors').'</h2>';
		echo '<ul class="list-inline color_swatch">';
		$product_url=get_the_permalink(get_the_ID());
		if(!empty($_GET['color_att'])){
			$selected_color=$_GET['color_att'];
		}else{
			$selected_color='';
		}


		
		foreach($color_options as $col_opt):
			 if($col_opt){
			 	 $col_opt_name = get_field('color_value',get_term( $col_opt ));
			 	 $col_opt_term=get_term( $col_opt);
				 $color_url='';
				 $vars = ['color_att' => $col_opt_term->slug];
				 if (strpos($product_url,'?') == false) { 
				 	$color_url=$product_url.'?'.http_build_query($vars);
				 }else{
				 	$color_url=$product_url.'&'.http_build_query($vars);
				 }

				 if($selected_color==$col_opt_term->slug){
				 	$select_class='active_item';
				 }else{
				 	$select_class='';
				 }
			 	 echo'<li class="list-inline-item '.$select_class.'"><a class="color-icon text-xs-center" href="'.$color_url.'"><div class="circle_col" style="background:'.$col_opt_name.'">&nbsp;</div></a></li>';
			 }			 
		endforeach;
		echo "</ul>";
	}
}


?>

<?php
