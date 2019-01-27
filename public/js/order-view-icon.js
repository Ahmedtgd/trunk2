/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Added By Chirag Viradiya
 * @param Added for the order view icon page
 */
(function ($) {
    $(document).ready(function () {
        jQuery('.productLink').on('click', function () {
            showOrderLoader();
            var pId = jQuery(this).data('id');
            jQuery.ajax({
                url: JS_BASE_URL + "/station/getproductdetail/" + pId,
                success: function (response) {
                    jQuery('.orderSelectDiv').html(response);
                    if (jQuery('.order_' + pId).length != 0) {
                        var oldVal = jQuery('.confirmOrder .order_' + pId + ' .qtyNumber').val();
                        jQuery('.orderSelectDiv .qtyTr td.value input').val(oldVal);
                    }
                }
            });
        });
    });
})(jQuery);


function showOrderLoader()
{
    var loaderHtml = "<div class='text-center fa-2x'><i class='fa fa-spin fa-spinner'></i><span>Please wait...</span></div>";
    jQuery('.orderSelectDiv').html(loaderHtml);
}

function refreshTable()
{
//    if (jQuery('#confirmOrderForm table tbody .orderTr').length != 0) {
//
//    }
    var srNo = 1;
    var total = 0;
    jQuery('#confirmOrderForm table tbody tr.orderTr').each(function () {
        jQuery(this).find('.srnoSpan').html(srNo);
        total = parseFloat(total) + parseFloat(jQuery(this).find('.totalPriceSpan').html());
        srNo++;
    });
    total = total.toFixed(2);
    jQuery('.totalRs').html(total);
}

function removeProduct(curTr)
{
    if (confirm('are you want to delete this product?')) {
        jQuery(curTr).parents('tr.orderTr').remove();
        refreshTable();
    }
}
/**
 * ENd
 */


