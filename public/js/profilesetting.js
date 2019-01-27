/*
 * Created by Khakan Ali on 11/27/2015.
 */
$(document).ready(function () {
    $('#saved-pro').on('click',function(){
        var product_array=[];
        $('.selected-value').each(function(){
            if($(this).prop('checked')){
                product_array[product_array.length] = $(this).val();
            }
        });
        if(product_array.length > 0) {
            commonAjax(product_array, 'saved_profile_product');

        }
    });
    $("#display-product-section").on('click','.remPbox',function(){
        var obj = $(this);
        var id = $(this).attr('data-rowid');
        var route = 'delete_profile_product';
        DeleteAlert(obj,id,route);
    });
});
/*-- Confirmation popup --*/
function DeleteAlert(obj,rowid,route){
    var html = '<div class="modal-header">\
                    <h4 class="modal-title"><strong>Alert!</strong></h4>\
                </div>\
                <div class="modal-body">\
                    <p>Are you sure?</p>\
                </div>\
                <div class="modal-footer">\
                    <button type="button" class="btn btn-danger" id="del" data-dismiss="modal">Yes</button>\
                    <button type="button" class="btn btn-primary" id="no-del" data-dismiss="modal">No</button>\
                </div>';
    Popup(html);
    $('#del').on('click',function(){
        commonAjax(rowid, route);
        obj.parents('.placeholder').remove();
    });
}
/*-- popup*/
function Popup(html){
    $('#MessageModel').modal('show');
    $('#Messagebody').html(html);
}
/*-- Ajax function for profile setting*/
function commonAjax(data,route){
    $.ajax({
        type: "post",
        url: JS_BASE_URL + '/' + route,
        data:{id:data},
        cache: false,
        success: function(responseData, textStatus, jqXHR) {
            if(route == 'saved_profile_product') {
                $("#display-product-section").append(addproDiv(responseData, data));
                RemoveAppendDiv(data);
                window.location.reload();
            }
            else
            {
                window.location.reload();
            }
        },
        error: function(responseData, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}

function addproDiv(data,selected_id){
    var html='';
    for(i=0;i < data.Product.length;i++) {
        for (j = 0; j < selected_id.length; j++) {
            if (data.Product[i]['id'] == selected_id[j]) {
                html += '<div class="p-box placeholder col-sm-4 col-xs-12">' +
                    '<div class="p-img-bordered">' +
                    '<div class="p-img">' +
                    '<a class="badge badge-close remPbox" data-rowid="'+ data.Product[i]['id']+'" >X</a>' +
                    '<img src="' + JS_BASE_URL + '/images/product/' + data.Product[i]['id'] + '/' + data.Product[i]['photo_1'] + '" class="img-responsive">' +
                    '</div>' +
                    '</div>' +
                    '<table class="table table-bordered p-specs">' +
                    '<tr>' +
                    '<td colspan="2" rowspan="2" style="padding:4px;vertical-align:middle">' + data.Product[i]['name'] + '</td>';
                if (data.Product[i]['retail_price'] == 0) {
                    if (data.Product[i]['original_price'] != 0) {
                        html += '<td style="padding:0;text-align:center;font-weight:bold">' + data.Product[i]['original_price'] / 100 + '</td>';
                    }
                } else {
                    html += '<td style="padding:0;text-align:center;font-weight:bold">' + data.Product[i]['original_price'] / 100 + '</td>';
                }
                html += '</tr>' +
                    '<tr>';
                if (data.Product[i]['retail_price'] == 0) {
                    html += '<td class="text-danger">&nbsp;</td>';
                }
                else {
                    html += '<td class="text-danger" style="padding:0;text-align:center;font-size:120%;font-weight:bold">' + data.Product[i]['original_price'] / 100 + '</td>';
                }
                html += '</tr>' +
                    '</table>'+
                    '<div class="clearfix"> </div></div>';
            }
        }
    }
    return html;
}

function RemoveAppendDiv(data){
    for(i=0;i<data.length;i++){
        $('.'+data[i]).remove();
    }
}




