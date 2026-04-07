<?php
/**
* Template Name: Test Page
**/
get_header();
?>
<p>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

Why do we use it?
It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
</p>
<div style="margin:250px auto;">
<?php 

global $product;
   global $woocommerce_wpml;
   $cur_lang       = ICL_LANGUAGE_CODE;
   $crncy = get_woocommerce_currency();
   $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];
   if ($crncy == 'SEK') {
     $crncy = ' Kr';
   }

   $user = wp_get_current_user();
   $product_id = '13743';


   $price_option_500_net = get_post_meta($product_id, '_price_option_500', true);

echo $price_option_500_net;
$amount = $price_option_500_net;
echo "<br>";

$user_level= "level_1";
$price_fractor=get_field('price_fractor','option');

$get_discount=get_field($user_level,'option');

echo $get_discount;
echo "<br>";

$final_amt=($amount*$price_fractor)-((($amount*$price_fractor)*$get_discount)/100);

echo $final_amt;

echo "<br>";

if ( $rate_change > 0 ) {
   $price_option_500 = $rate_change * $final_amt;
}

echo $price_option_500;

   $price_option_500=modify_price_customer_tier_wise($price_option_500_net);
   if ( $rate_change > 0 ) {
   $price_option_500 = $rate_change * $price_option_500;
   }
   $price_option_500 = number_format((float)$price_option_500, 2, '.', '');


   //echo $price_option_500


   
   $price_fractor=get_field('price_fractor','option');
   if($user_level){
       $get_discount=get_field($user_level,'option');
      
       return $final_amt;
   }

  















?><div style="margin:50px auto">"  "</div>

<!-- choose product price  start -->
 <?php 
$product = wc_get_product($product_id);
?>
 <div class="col-xs-12 col-sm-7 summary">
           <h4><?php _e( 'SUMMARY', 'usb' );?></h4>
           <div class="standar_product_summary">
              <table class="table summary">
                 <thead>
                    <tr>
                       <th><?php _e( 'Art no', 'usb' );?></th>
                       <th><?php _e( 'Product', 'usb' );?></th>
                       <th><?php _e( 'Options', 'usb' );?></th>
                       <th><?php _e( 'Qty', 'usb' );?></th>
                       <th><?php _e( 'Price/pcs', 'usb' );?></th>
                       <th><?php _e( 'Total cost', 'usb' );?></th>
                    </tr>
                 </thead>
                 <tbody>
                    <tr>
                       <td><?php echo $product->get_sku();?></td>
                       <td>
                          <?php
                             echo get_the_title($product->ID);
                             ?>
                       </td>
                       <td></td>
                       <td class="show_qty" data-qty="0">0</td>
                       <td class="show_price_option a1" data-price="0">0 <?php echo $crncy;?></td>
                       <td class="total_price" data-price="0">0 <?php echo $crncy;?></td>
                    </tr>
                    <?php
                       foreach ($attributes as $attribute) {
                       ?>
                    <tr class="<?php
                       echo $attribute['name'];
                       ?>">
                       <td></td>
                       <td><?php
                          echo wc_attribute_label($attribute['name']);
                          ?></td>
                       <td></td>
                       <td class="show_qty" data-qty="0">0</td>
                       <td class="show_price_option attrprice" data-price="0">0 <?php echo $crncy;?></td>
                       <td class="total_price" data-price="0">0 <?php echo $crncy;?></td>
                    </tr>
                    <?php
                       }
                       ?>
                    <tr class="cus-your-price">
                       <td><?php //_e( 'Your Price', 'usb' );?></td>
                    </tr>
                    <tr class="summary-last">
                       <td></td>
                       <td><?php _e( 'Total amount', 'usb' );?></td>
                       <td></td>
                       <td class="totalpcs"><?php _e( 'Qty', 'usb' );?><input type="hidden" class="pcs" name="pcs" id="pcs"> <span>0</span></td>
                       <td class="totalprice"><?php _e( 'Price/pcs', 'usb' );?><input type="hidden" class="price" name="price" id="price"> <span>0 <?php echo $crncy;?></span></td>
                       <td class="totalamount"><?php _e( 'Total order', 'usb' );?><input type="hidden" class="totalamount" name="totalamount" id="totalamount"> <span>0 <?php echo $crncy;?></span></td>
                    </tr>
                    <tr class="cus-sales-price">
                       <td><?php //_e( 'Sales price', 'usb' );?></td>
                    </tr>
                    <!-- <tr class="summary-last" style="display: none;">
                       <td></td>
                       <td><?php //_e( 'Margin', 'usb' );?></td>
                       <td></td>
                       <td class="totalpcs"><span>0</span></td>
                       <td class="pricemargin"><input type="hidden" class="margin_price" name="margin_price" id="margin_price"> <span>0 <?php //echo $crncy;?></span></td>
                       <td class="totalmargin"><input type="hidden" class="margin_amount" name="margin_amount" id="margin_amount"> <span>0 <?php //echo $crncy;?></span></td>
                    </tr> -->
                    <tr class="summary-last summary-last-margin">
                       <td></td>
                       <td><?php _e( 'Margin', 'usb' );?></td>
                       <td></td>
                       <td class="totalpcs"><?php _e( 'Qty', 'usb' );?> <span>0</span></td>
                       <td class="pricemargin"><input type="hidden" class="margin_price" name="margin_price" id="margin_price"><?php _e( 'Price/pcs', 'usb' );?> <span>0 <?php echo $crncy;?></span></td>
                       <td class="totalmargin"><input type="hidden" class="margin_amount" name="margin_amount" id="margin_amount"><?php _e( 'Total order', 'usb' );?> <span>0 <?php echo $crncy;?></span></td>
                    </tr>
                 </tbody>
              </table>
           </div>
           <?php
              global $product;
              $id = $product->id;
              ?>
        </div>

<!-- choose product price  end -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js" ></script> -->



                     </div>

<script>
jQuery(document).ready(function($){
init_qty_price();
});

         function init_qty_price() {
      var crncy = ' <?php echo $crncy;?>';
      var qty = '500';
      var price = '75.00  Kr';
      if(jQuery("#woo_currency").val() == ' Kr') {
            var output = price.split('.')[1];
            var rnd = price.split('.')[0];
            if(output <= 25){
                price = (Math.round(price)+'.00');
            }else if(output > 25 && output <= 75){
                price = (rnd + '.50');
            }else if(output > 75){
                price = (Math.round(price)+'.00');
            }else{
                // return ('This is not a number!');
                price;
            }
        } else {
            var floatVal = formatter.format(parseFloat(price));
          price = (Math.round(floatVal * 100) / 100).toFixed(2);
          
        }
      console.log(price+'anissssss');
     
      var get_cus_qty = jQuery('input.custom_quantity').val();
      if(get_cus_qty){
        jQuery(".show_qty").text(get_cus_qty).attr('data-qty',qty);
        qty=parseInt(get_cus_qty);
      } else {
        jQuery(".show_qty").text(qty).attr('data-qty',qty);
      }
      
      jQuery("#pcs").val(qty);
      jQuery(".totalpcs span").html(qty);
      jQuery("table.table tbody tr:first-child td.show_price_option").attr('data-price',price).text(price+crncy);
      var total_price = parseFloat(parseFloat(qty)*parseFloat(price));
      total_price = total_price.toFixed(2);
      console.log(total_price+'anit');
      jQuery("table.table tbody tr:first-child td.total_price").attr('data-price',total_price).text(total_price+crncy);
      // jQuery("#totalamount").val(total_price);
      // jQuery(".totalamount span").text(total_price+ crncy);
      jQuery(".attr_optn:selected").each(function() {
        var tax = jQuery(this).attr('data-tax');
        var cus_qty = jQuery('input.custom_quantity').val();
        if(cus_qty){
          var qty2 = cus_qty;
        }
        else{
          var qty2 = jQuery(".optionclick:checked").val();
        }
        var qty = jQuery(".optionclick:checked").val();
        var price = jQuery(this).attr('data-price'+qty);
     
     
        if (price) {
          jQuery("."+tax+" .show_price_option").attr('data-price',price).text(price+crncy);
          var total_price = parseFloat(parseFloat(qty2)*parseFloat(price));
          total_price = total_price.toFixed(2);
          jQuery("."+tax+" .total_price").attr('data-price',total_price).text(total_price+crncy);
          var all_total = 0;
          var all_price = 0;
          jQuery(".total_price").each(function(){
            all_total = all_total + parseFloat(jQuery(this).attr('data-price'));
          });
          jQuery(".show_price_option").each(function(){
            all_price = all_price + parseFloat(jQuery(this).attr('data-price'));
          });
          all_total = all_total.toFixed(2);
          all_price = all_price.toFixed(2);
          jQuery("#totalamount").val(all_total);
          jQuery(".totalamount span").text(all_total+ crncy);
     
          jQuery(".totalprice #price").val(all_price);
          jQuery(".totalprice span").text(all_price+ crncy);
        }          
      });
     
      var all_total = 0;
      jQuery(".total_price").each(function(){
        all_total = all_total + parseFloat(jQuery(this).attr('data-price'));
      });
      all_total = all_total.toFixed(2);
      jQuery("#totalamount").val(all_total);
      jQuery(".totalamount span").text(all_total+ crncy);
     
      var all_price = 0;
      jQuery(".show_price_option").each(function(){
        all_price = all_price + parseFloat(jQuery(this).attr('data-price'));
      });
      all_price = all_price.toFixed(2);
      jQuery(".totalprice #price").val(all_price);
      jQuery(".totalprice span").text(all_price+ crncy);
     
     }
     function attr_optn_calc() {
      var crncy = ' <?php echo $crncy;?>';
      jQuery(".attr_optn").click(function() {
        var tax = jQuery(this).attr('data-tax');
        var qty = jQuery(".optionclick:checked").val();
        var price = jQuery(this).attr('data-price'+qty);
        if (price) {
          jQuery("."+tax+" .show_price_option").attr('data-price',price).text(price+crncy);
          var total_price = parseFloat(parseFloat(qty)*parseFloat(price));
          total_price = total_price.toFixed(2);
          jQuery("."+tax+" .total_price").attr('data-price',total_price).text(total_price+crncy);
          var all_total = 0;
          jQuery(".total_price").each(function(){
            all_total = all_total + parseFloat(jQuery(this).attr('data-price'));
          });
          jQuery("#totalamount").val(all_total);
          jQuery(".totalamount span").text(all_total+ crncy);
     
          var all_price = 0;
          jQuery(".show_price_option").each(function(){
            all_price = all_price + parseFloat(jQuery(this).attr('data-price'));
          });
          all_price = all_price.toFixed(2);
          jQuery(".totalprice #price").val(all_price);
          jQuery(".totalprice span").text(all_price+ crncy);
        }          
      });
     }


     const formatter = new Intl.NumberFormat('en-US', {
       minimumFractionDigits: 1,      
       maximumFractionDigits: 1,
    });    
   function calPrice($amount){
     
            var value = $amount.toFixed(2);
            var output = value.split('.')[1];
            var rnd = value.split('.')[0];
            if(output <= 25){
                return (Math.round($amount)+'.00');
            }else if(output > 25 && output <= 75){
                return (rnd + '.50');
            }else if(output > 75){
                return (Math.round($amount)+'.00');
            }else{
                // return ('This is not a number!');
                return null;
            }
       
    }
  </script>


<?php get_footer(); ?> 