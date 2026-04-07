  // for right click new tab view
     jQuery(document).on('mousedown','.yith_magnifier_zoom_wrap',function(e){ 
    if( e.button == 2 ) { 
      var value = jQuery('.yith_magnifier_zoom').attr("href");
      window.open(value);
    return false; 
    } 
    return true; 
  });
  // for right click new tab view
 
 
  
  jQuery('.banner-slider').owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
       
    });

         
  // jQuery('.owl-carousel').owlCarousel({

  //     loop:true,
  //     margin:10,
  //     responsiveClass:true,
  //     navigation : false,
  //     responsive:{
  //         0:{
  //             items:1,
  //             nav:true
  //         },
  //         600:{
  //             items:1,
  //             nav:true
  //         },
  //         1000:{
  //             items:1,
  //             nav:true,
  //             loop:true
  //         }
  //     }
  // });
    jQuery(document).ready(function() {
      jQuery('.fancybox').fancybox();

      // Disable opening and closing animations, change title type
      jQuery(".fancybox-effects-b").fancybox({
        openEffect  : 'none',
        closeEffect : 'none',

        helpers : {
          title : {
            type : 'over'
          }
        }
      });



    });

jQuery(document).ready(function() {
	if(jQuery(".product").length){
		  jQuery(".product").attr("id");
		  var pro_id=jQuery(".product").attr("id");
		  var explode=pro_id.split('-');
		  var main_id=explode[1];
		  jQuery(".dwnpdf").attr('href','?pdf='+main_id);
	}
  jQuery("#menu-item-1415").addClass("usb_newstab");
  //jquery product page form submit
  jQuery(".form-horizontal").submit(function(e){
        e.preventDefault();
    });
});
console.log(ajaxVars.ajaxurl);
jQuery(document).on('click', '.down_pdf_summary', function(){
  var productsummary = jQuery('.standar_product_summary').html();
  var productID = jQuery(this).data("productid");
  
  console.log('test 04112020 test');
  console.log(productsummary);
  
  jQuery.ajax({
        url: ajaxVars.ajaxurl,
        type:'POST',
        data: {action:'usb_product_summary', summary:productsummary, product_id:productID},
        success: function(res)
          {
            console.log(res);
          }
      });
});

/*04-11-2020*/
jQuery(document).on('click', '.optionclick', function(){
    setTimeout( function(){ 
      var productsummary = jQuery('.standar_product_summary').html();
      var productID = jQuery(".down_pdf_summary").attr("data-productid");
      console.log('test 04112020 test');
      console.log(productsummary);
        
      jQuery.ajax({
            url: ajaxVars.ajaxurl,
            type:'POST',
            data: {action:'usb_product_summary', summary:productsummary, product_id:productID},
            success: function(res)
              {
                console.log(res);
              }
          });
    }  , 1000 );
});





jQuery(document).on('click', 'select.usb-dropdown', function(){
    setTimeout( function(){ 
    //   var productsummary = jQuery('.standar_product_summary').html();
      var productID = jQuery("#cus_product_id").val();
    //   console.log('test 04112020 test');
    
    var oem_tlc = jQuery('.custom-usb-table-oem-tlc .custom-usb-table').html();
    var oem_mlc = jQuery('.custom-usb-table-oem-mlc .custom-usb-table').html();
    var original = jQuery('.custom-usb-table-original .custom-usb-table').html();
          console.log(original);
      jQuery.ajax({
            url: ajaxVars.ajaxurl,
            type:'POST',
            data: {action:'usb_product_summary_v2', oem_tlc:oem_tlc, oem_mlc:oem_mlc, original:original, product_id:productID},
            success: function(res)
              {
                console.log(res);
              }
          });
    }  , 1000 );
});


jQuery(document).ready(function ($) {
	alert("aa");
	$('a[href^="#"]').on('click', function (e) {
	  e.preventDefault();
	  
	  var target = this.hash;
	  var $target = $(target);
  
	  // Dynamically get the height of the fixed header
	  var headerHeight = $('header').outerHeight(); // change selector if needed
  
	  $('html, body').animate({
		scrollTop: $target.offset().top - headerHeight
	  }, 600);
	});
  });