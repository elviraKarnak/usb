

// Webpack Imports
//import * as bootstrap from 'bootstrap';

(function () {
  "use strict";

  // // Focus input if Searchform is empty
  // [].forEach.call(document.querySelectorAll(".search-form"), (el) => {
  //   el.addEventListener("submit", function (e) {
  //     var search = el.querySelector("input");
  //     if (search.value.length < 1) {
  //       e.preventDefault();
  //       search.focus();
  //     }
  //   });
  // });

  // Initialize Popovers: https://getbootstrap.com/docs/5.0/components/popovers
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl, {
      trigger: "focus",
    });
  });
})();

// Header-filter

// jQuery(document).ready(function ($) {
//   $(".fliter-t-active").click(function () {
//     $(".color-list").toggleClass("dropdown-show");
//   });

//   $('.cyberpunk-checkbox').on('change', function () {
//     // alert('test');
//     $('.search-bar').submit();
//   });


// });

/*6/8/2024*/
jQuery(document).ready(function ($) {
  jQuery('.accordion-header').click(function () {
    var $content = $(this).next('.accordion-content');
    jQuery(this).toggleClass('active');
    $content.slideToggle();
  });
});

jQuery(document).ready(function () {
  jQuery('.banner-slider').slick({
    dots: true,
    arrows: true,
    autoSlide: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true
  });
  jQuery(document).ready(function () {
    jQuery('.filter-toggle').on('click', function () {
      const parent = jQuery(this).closest('.custom-accordion');
      parent.toggleClass('active');

      // Add cross button after .category-wrap if it doesn't exist
      if (!parent.find('.cross-btn').length) {
        jQuery('<button class="cross-btn">×</button>').insertAfter(parent.find('.category-wrap'));
      }
    });

    // Handle cross button click
    jQuery(document).on('click', '.cross-btn', function () {
      const parent = jQuery(this).closest('.custom-accordion');
      parent.removeClass('active');
      jQuery(this).remove(); // Remove the cross button
    });
  });
 
  

  jQuery('.price-calcualtion-btn').click(function () {
    jQuery(this).toggleClass('active-btn');
    jQuery('.single-product .price_calculator_form').slideToggle();
  });
  

    // const $productData = jQuery('.single-product #productdata');
  
    // // Remove extra whitespace and check for any visible text
    // const hasContent = jQuery.trim($productData.text()).length > 0;
  
    // // Also check if there's any <img> or other visible content
    // const hasVisibleElements = $productData.find('img, video, iframe, object').length > 0;
  
    // if (!hasContent && !hasVisibleElements) {
    //   $productData.hide();
    // }
 
  
jQuery(document).ready(function ($) {

    var siteUrl = $(".shop_link").val();

   $(".main_search_form").on('submit', function(e){
    e.preventDefault();
    var searchText = $(".search_text").val();
    //console.log(siteUrl);
     let baseUrl = siteUrl;
      let separator = baseUrl.includes('?') ? '&' : '?';
      let finalUrl = baseUrl + separator + "sq=" + encodeURIComponent(searchText);

      //console.log(finalUrl);

       window.open(finalUrl, '_self');
     
   })


  });




  
});

jQuery(document).ready(function ($) {

    $('.accordion-item').each(function () {

        var $item = $(this);
        var $collapse = $item.find('.accordion-collapse');
        var $body = $item.find('.accordion-body');

        // Check if body content is empty (trim removes spaces & &nbsp;)
        if ($.trim($body.text()).length === 0) {
            $item.hide();
        } else {
            // Show and keep open
            $collapse.addClass('show');
            $item.find('.accordion-button')
                 .removeClass('collapsed')
                 .attr('aria-expanded', 'true');
        }

    });

});


