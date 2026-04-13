function usbSaveProductSummary(productID) {
    var productsummary = jQuery('.standar_product_summary').html() || '';

    console.log('pdf summary save start');
    console.log('productID:', productID);
    console.log(productsummary);

    return jQuery.ajax({
        url: ajaxVars.ajaxurl,
        type: 'POST',
        data: {
            action: 'usb_product_summary',
            summary: productsummary,
            product_id: productID
        }
    });
}

// jQuery(document).on('click', '.down_pdf_summary', function (e) {
//     e.preventDefault();

//     var $link = jQuery(this);
//     var productID = $link.data('productid');
//     var pdfUrl = $link.attr('href');
//     var target = $link.attr('target');
//     var newWindow = null;

//     if (target === '_blank') {
//         newWindow = window.open('', '_blank');
//     }

//     usbSaveProductSummary(productID)
//         .done(function (res) {
//             console.log('pdf summary save success:', res);
//             console.log('redirect pdf url:', pdfUrl);

//             if (newWindow) {
//                 newWindow.location = pdfUrl;
//             } else {
//                 window.location.href = pdfUrl;
//             }
//         })
//         .fail(function (xhr, status, error) {
//             console.log('pdf summary save failed:', status, error);
//             console.log(xhr.responseText);

//             if (newWindow) {
//                 newWindow.close();
//             }
//         });
// });

// jQuery(document).on('click', '.down_pdf_summary', function (e) {
//     e.preventDefault();

//     var $link = jQuery(this);
//     var productID = $link.data('productid');
//     var pdfUrl = $link.attr('href');

//     usbSaveProductSummary(productID)
//         .done(function (res) {
//             console.log('pdf summary save success:', res);
//             console.log('redirect pdf url:', pdfUrl);

//             window.location.href = pdfUrl;
//         })
//         .fail(function (xhr, status, error) {
//             console.log('pdf summary save failed:', status, error);
//             console.log(xhr.responseText);
//         });
// });


// jQuery(document).on('click', '.optionclick', function () {
//     setTimeout(function () {
//         var productID = jQuery(".down_pdf_summary").attr("data-productid");
//         usbSaveProductSummary(productID)
//             .done(function (res) {
//                 console.log('option summary save success:', res);
//             })
//             .fail(function (xhr, status, error) {
//                 console.log('option summary save failed:', status, error);
//                 console.log(xhr.responseText);
//             });
//     }, 1000);
// });


   jQuery(document).on('click', '.down_pdf_summary:not(.marginpdf)', function (e) {
            e.preventDefault();

            var $btn = jQuery(this);
            var href = $btn.attr('href');
            var productID = $btn.data('productid');
            var productSummary = jQuery('.standar_product_summary').html() || '';

            var isMarginPdf = href.indexOf('marginpdf=') !== -1;
            var isOfferPdf = href.indexOf('offerpdf=') !== -1;

            var marginQty = jQuery(".summary-last-margin .totalpcs span").text().trim();
            var marginPrice = jQuery(".summary-last-margin .pricemargin span").text().trim();
            var marginTotal = jQuery(".summary-last-margin .totalmargin span").text().trim();
            var marginWooCurrency = jQuery("#woo_currency").val();
            var marginPercentage = jQuery(".cus_margin").val();

            console.log('================ PDF DEBUG START ================');
            console.log('button text:', $btn.text().trim());
            console.log('href:', href);
            console.log('productID:', productID);
            console.log('isOfferPdf:', isOfferPdf);
            console.log('isMarginPdf:', isMarginPdf);

            console.log('summary exists:', !!productSummary);
            console.log('summary length:', productSummary.length);
            console.log('summary html:', productSummary);

            console.log('marginQty:', marginQty);
            console.log('marginPrice:', marginPrice);
            console.log('marginTotal:', marginTotal);
            console.log('marginWooCurrency:', marginWooCurrency);
            console.log('marginPercentage:', marginPercentage);

            console.log('offer request url would be:', href);
            console.log('margin form serialize:', jQuery('.margin_frm').serialize());
            console.log('================ PDF DEBUG END ==================');

            usbSaveProductSummary(productID)
                .done(function (res) {
                    console.log('pdf summary save success:', res);
                    console.log('download pdf url:', href);

                    var iframe = jQuery('#offer_pdf_download_frame');

                    if (!iframe.length) {
                        iframe = jQuery('<iframe>', {
                            id: 'offer_pdf_download_frame',
                            style: 'display:none;'
                        }).appendTo('body');
                    }

                    iframe.attr('src', href);
                })
                .fail(function (xhr, status, error) {
                    console.log('pdf summary save failed:', status, error);
                    console.log(xhr.responseText);
                });
         });
