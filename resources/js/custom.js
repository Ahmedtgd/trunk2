var currentCurrency = "MYR";
function ucfirst (str) {
	//  discuss at: http://locutus.io/php/ucfirst/
	// original by: Kevin van Zonneveld (http://kvz.io)
	// bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
	// improved by: Brett Zamir (http://brett-zamir.me)
	//   example 1: ucfirst('kevin van zonneveld')
	//   returns 1: 'Kevin van zonneveld'

	str += ''
	var f = str.charAt(0)
	.toUpperCase()
	return f + str.substr(1)
}

var idle_time_in_sec= 5; //time to reset everything
function reset(){
    toastr.clear();
    $('.btn-subcat').each(function(){
        $(this).children('i').addClass('hidden');
    });

}
setTimeout(reset,idle_time_in_sec*1000);

(function ($) {

    $(document).ready(function () {
        /*Duplicate*/
		/*$.ajax({
			url: JS_BASE_URL + '/getcurrentcurrency',
			type: 'GET',
			success: function (response) {
				//console.log(response);
				currentCurrency = response;
				//console.log(currentCurrency);
			}
		});	*/	
		
        $(".product_like").click(function () {
			//alert("aaaaaaa");

            var itemId = $(this).data('item-id');
            console.log("Item ID "+itemId);

            $.ajax({
                url: JS_BASE_URL + '/product_like',
                type: 'GET',
                data: {itemId: itemId},
                success: function (response) {
                    console.log(response);
                    if(response.ok){
						if(response.incremented){
							toastr.success('<div><p>Liked products are listed in your Buyer Dashboard for your convenience!</p></div>');
							$('.btn-like').css( "color", "rgb(255,0,128)" );
							$('.btn-like').css( "border-color", "rgb(255,0,128)" );
							$('.product_like').css( "color", "rgb(255,0,128)" );
							$('.btn-like').css( "background", "rgb(255,255,255)" );
						} else {
							$('.btn-like').css( "background", "rgb(255,0,128)" );
							$('.btn-like').css( "color", "rgb(255,255,255)" );
							$('.btn-like').css( "border-color", "transparent" );
							$('.product_like').css( "color", "rgb(255,255,255)" );
							toastr.warning('<div><p>You have disliked this product!</p></div>');
						}						
						$('.likes_number').html(response.likes);
                    }else{
                        toastr.warning('<div><p>You need to be registered to Like this product</p></div>');
                    }
                }
            });
        });		
		// Reshare
        $(".reshare-owish-uniq").click(function () {
            // alert("aaaaaaa");

            // $(this).children('i').removeClass('hidden');
            var dt=$('#bspinner');
            dt.removeClass('hidden');
            var itemId = $('#owish_product_id').val();
            var message=$("#custom_message").val();
            
            $.ajax({
                url:JS_BASE_URL+'/check/login',
                type:'GET',
                success:function (response) {
                    if (response.status=="success") {

                    $.ajax({
                    url: JS_BASE_URL + '/owish/reshare',
                    type: 'GET',
                    data: {itemId: itemId,message:message},
                    success: function (response) {
                        console.log(response.message);
                        if(response.ok){
                            toastr.info(response.message);
                        }
                        if(response==-1){
                            rs = response.url;
                            toastr.info('<div><p>You are not registered for OpenWish. Would you like to register now?</p></div><div><button type="button" id="okBtn"  class="btn btn-primary">Yes</button><button type="button" id="surpriseBtn" class="btn" style="margin: 0 8px 0 8px">No</button></div>');
                            $('#surpriseBtn').click(function(){
                                toastr.clear();
                                dt.children('i').addClass('hidden');
                            });
                            $('#okBtn').click(function(){
                                toastr.clear();
                                newwindow = window.open(JS_BASE_URL+"/fb/login", 'Register', 'height=400,width=auto');
                                if (window.focus) {
                                            newwindow.focus()
                                        }
                                dt.children('i').addClass('hidden');
                                return false;
                            });

                        }
                        if (response.short_message=="Token Failure") {
                            rs = response.url;
                            toastr.info('<div><p>Your access token for the social media account has expired. Would you like to register again?</p></div><div><button type="button" id="okBtn"  class="btn btn-primary">Yes</button><button type="button" id="surpriseBtn" class="btn" style="margin: 0 8px 0 8px">No</button></div>');
                            $('#surpriseBtn').click(function(){
                                toastr.clear();
                                dt.children('i').addClass('hidden');
                            });
                            $('#okBtn').click(function(){
                                toastr.clear();
                                newwindow = window.open(JS_BASE_URL+"/fb/login", 'Register', 'height=400,width=auto');
                                if (window.focus) {
                                            newwindow.focus()
                                        }
                                dt.children('i').addClass('hidden');
                                return false;
                            });
                        }
                        if (response.status=="success") {
                            toastr.info(response.long_message);
                            dt.children('i').addClass('hidden');
                        }
                    }
                    });
                    }
                    // Success ends
                    if (response.status=="failure") {
                        dt.children('i').addClass('hidden');
                        toastr.info(response.long_message);
                    }     
                }
            });

        });
        // Reshare Ends


    });
})(jQuery);
function connect(rs){
    window.location.replace (rs);
    //toastr.info("Your facebook account connected successfully ");
}
/**
 * Select product for smm
 * Ajax call
 */
// (function ($) {
//     var output = [], smm_quota_max;
//     $(document).ready(function () {
//         smm_quota_max = $('input[name="smm_quota_max"]').val();
//         var confirmButton = $('#save-selProduct'),
//                 smm_mx = parseInt(smm_quota_max),
//                 span_smm_mx = $('#mx_quota');

//         span_smm_mx.html(smm_mx);
//         $(".on-hover-product").on('mouseover', function () {
//             $(this).toggleClass("highlight-product");
//             //$(this).toggleClass('class-border-product');
//         })
//                 .on('mouseout', function () {
//                     $(this).toggleClass("highlight-product");
//                     //$(this).toggleClass('class-border-product');
//                 })
//                 .on('click', function (e) {
//                     e.preventDefault();
//                     if (typeof smm_quota_max === 'undefined') {
//                         $(this).toggleClass("selected");
//                     }
//                     var product_id = $(this).data('product-id');
//                     var idx = $.inArray(product_id, output);

//                     if (typeof smm_quota_max !== 'undefined') {
//                         if (output.length < smm_quota_max || $(this).hasClass('selected')) {
//                             if (idx == -1) {
//                                 output.push(product_id);
//                                 smm_mx--;
//                             } else {
//                                 if (smm_mx <= smm_quota_max) {
//                                     smm_mx++; //safe commit
//                                 }
//                                 removeFromArray(product_id, output);
//                             }
//                             $(this).toggleClass("selected");
//                             confirmButton.html('Save Selected');
//                         }
//                     } else {
//                         if (idx == -1) {
//                             output.push(product_id);
//                             smm_mx--;
//                         } else {
//                             if (smm_mx <= smm_quota_max) {
//                                 smm_mx++; //safe commit
//                             }
//                             removeFromArray(product_id, output);
//                         }
//                     }

//                     console.log(output);

//                     if (smm_mx == 0) {
//                         confirmButton.html('Done');
//                     }

//                     if (confirmButton.hasClass('saveSectionName')) {
//                         confirmButton.removeClass('saveSectionName');
//                         confirmButton.addClass('save-selected-product');
//                     }
//                     span_smm_mx.html(smm_mx);
//                 });

//         $('.product-selected').on('click', function (e) {
//             var $this = $(this);
//             //console.log(output); return;

//             if (confirm('Are you sure?')) {
//                 $.ajax({
//                     url: JS_BASE_URL + '/SMM/save-products',
//                     type: "POST",
//                     data: {selectedProducts: output},
//                     success: function (res) {
//                         if (res.status == 'success') {
//                             toastr.info(res.message);
//                             $this.remove();
//                         } else {
//                             toastr.error(res.message);
//                         }
//                     }
//                 })
//             }
//         });
//     });

    /**
     * Remove from array selected product
     * @param string
     * @param array
     * @returns {*}
     */
    // function removeFromArray(string, array) {
    //     while ($.inArray(string, array) != -1) {
    //         array.splice($.inArray(string, array), 1);
    //     }
    //     return array;
    // }

    // function pushOrRemoveProducts() {
    //     if (idx == -1) {
    //         output.push(product_id);
    //         smm_mx--;
    //     } else {
    //         if (smm_mx <= smm_quota_max) {
    //             smm_mx++; //safe commit
    //         }
    //         removeFromArray(product_id, output);
    //     }
    // }

    /**
     * After finish selecting append submit selected
     * products in order to create smmout
     */
//     $(document).on('click', '.save-selected-product', function (e) {
//         if (confirm('Are you sure?')) {
//             $.ajax({
//                 url: JS_BASE_URL + '/profilesetting/save-products',
//                 type: "POST",
//                 data: {selectedProducts: output},
//                 success: function (res) {
//                     if (res.status == 'success') {
//                         toastr.info(res.message);
//                     } else {
//                         toastr.error(res.message);
//                     }
//                     $('#save-selProduct').addClass('saveSectionName');
//                     $('#save-selProduct').html('Confirm');
//                     $(this).remove();
//                 }
//             })
//         }
//     });
// })(jQuery);

// (function ($) {

//     $(document).ready(function () {

//         $(".smedia-marketer").click(function () {

//             var product_id = $("input[name='product_id']").val();

//             $.ajax({
//                 url: JS_BASE_URL + '/smedia/marketer',
//                 type: 'GET',
//                 data: {product_id: product_id},
//                 success: function (response) {
//                     toastr.info(response);
//                 }
//             });
//         });

//     });

// })(jQuery);

/**
 * Created by Khakan Ali on 11/27/2015.
 */

$(document).ready(function () {
    var dataarray = [];
    var delarray = [];
    var item_id;
    $('#display-product-section').on('click', '.p-img-bordered', function () {
        if (splitclass($(this).attr('class'))[1] == 'selected-pro') {
            $(this).removeClass('selected-pro');
            if ($('.select-SMM-group')[0]) {
                $('.select-SMM-group').addClass('hidden');
            }
        } else {
            $('.selected-pro').each(function () {
                $(this).removeClass('selected-pro');
            });
            $(this).addClass('selected-pro');
            if ($('.select-SMM-group')[0]) {
                $(".select-SMM").html("Select SMM");
                $("#product_quota_max").html("5");
                $('.select-SMM-group').removeClass('hidden');
            }
        }
    });
    $('.mobile_login_form').on('submit', function (e) {
		e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            cache: false,
            success: function (responseData, textStatus, jqXHR) {
				console.log(responseData);
                if (responseData == "false") {
                    $('.error-msg').html('<h5><b>Invalid user name or password!</b></h5>');

                } else if (responseData == "merchant_status_error") {
                    $('.error-msg').html('<h5><b>Your Merchant account has been successfully registered, awaiting for approval!</b></h5>');
                } else if(responseData == "merchant_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                } else if(responseData == "station_status_error"){
                    $('.error-msg').html('<h5><b>Your Station account has been successfully registered, awaiting for approval!</b></h5>');
                } else if(responseData == "station_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                } else if(responseData == "buyer_status_error"){
                    $('.error-msg').html('<h5><b>Your Buyer account has been successfully created. Please acknowledge the confirmation email!</b></h5>');
                } else if(responseData == "buyer_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                }  else {
                    console.log(responseData);
                    window.location.reload();
                }
            },
            error: function (responseData, textStatus, errorThrown) {
                console.log(responseData);
            }
        });
    });
	
    $('.login_form').on('submit', function (e) {
		e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            cache: false,
            success: function (responseData, textStatus, jqXHR) {
				console.log(responseData);
                if (responseData.status=="failure") {
                    $('.error-msg').html('<h5><b>'+responseData.long_message+'</b></h5>');
                }else if(responseData.status=="success"){
                    location.reload()
                }
              /*  if (responseData == "false") {
                    $('.error-msg').html('<h5><b>Invalid user name or password!</b></h5>');

                } else if (responseData == "merchant_status_error") {
                    $('.error-msg').html('<h5><b>Your Merchant account has been successfully registered, awaiting for approval!</b></h5>');
                } else if(responseData == "merchant_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                } else if(responseData == "station_status_error"){
                    $('.error-msg').html('<h5><b>Your Station account has been successfully registered, awaiting for approval!</b></h5>');
                } else if(responseData == "station_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                } else if(responseData == "buyer_status_error"){
                    $('.error-msg').html('<h5><b>Your Buyer account has been successfully registered, awaiting confirmation email!</b></h5>');
                } else if(responseData == "buyer_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                }  else {
                    console.log(responseData);
                    //window.location.reload();
                }*/
            },
            error: function (responseData, textStatus, errorThrown) {
                console.log(responseData);
            }
        });
    });	
	
    $('.mobile_reg_form').on('submit', function (e) {
		e.preventDefault();
		$('.error-msg-reg').html('');
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            cache: false,
            success: function (responseData, textStatus, jqXHR) {
				console.log(responseData);
                if (responseData == "false") {
                    $('.error-msg').html('<h5><b>Invalid user name or password!</b></h5>');

                } else if (responseData == "email_error") {
                    $('.error-msg-reg').html('<h5><b>This email already exists in our system! Please, log in or restore your password with your email!</b></h5>');
                } else if(responseData == "password_error"){
                    $('.error-msg-reg').html("<h5><b>Password don't match.</b></h5>");
                } else if(responseData == "station_status_error"){
                    $('.error-msg').html('<h5><b>Your Station account has been successfully registered, awaiting for approval!</b></h5>');
                } else if(responseData == "station_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                } else if(responseData == "buyer_status_error"){
                    $('.error-msg').html('<h5><b>Your Station account has been successfully registered, awaiting for approval!</b></h5>');
                } else if(responseData == "buyer_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                }  else {
                    console.log(responseData);
					$('.success-msg-reg').html("<h5><b>You were successfully registered. Please, check your email for the confirmation link.</b></h5>");
					setTimeout(function(){ 
						$(".success-msg-reg").hide("slow"); 
						$('.dropdown-content-login').hide();
					}, 3000);
                }
            },
            error: function (responseData, textStatus, errorThrown) {
                console.log(responseData);
            }
        });
    });		
	
    $('.reg_form').on('submit', function (e) {
		e.preventDefault();
		console.log($(this).serialize());
		$('.error-msg-reg').html('');
		$('.signInBtnnew').html('Registering...');
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            cache: false,
            success: function (responseData, textStatus, jqXHR) {
				console.log(responseData);
                if (responseData == "false") {
                    $('.error-msg').html('<h5><b>Invalid user name or password!</b></h5>');

                } else if (responseData == "email_error") {
                    $('.error-msg-reg').html('<h5><b>This email already exists in our system! Please, log in or restore your password with your email!</b></h5>');
                } else if(responseData == "password_error"){
                    $('.error-msg-reg').html("<h5><b>Password don't match.</b></h5>");
                } else if(responseData == "station_status_error"){
                    $('.error-msg').html('<h5><b>Your Station account has been successfully registered, awaiting for approval!</b></h5>');
                } else if(responseData == "station_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                } else if(responseData == "buyer_status_error"){
                    $('.error-msg').html('<h5><b>Your Buyer account has been successfully registered, awaiting confirmation email!</b></h5>');
                } else if(responseData == "buyer_status_error_suspended"){
                    $('.error-msg').html('<h5><b>Your account has been suspended with immediate effect. Please contact OpenSupport for further details.</b></h5>');
                } else {
                    console.log(responseData);
					$('.success-msg-reg').html("<h5><b>You were successfully registered. Please, check your email for the confirmation link.</b></h5>");
					$('.signInBtnnew').html('Registered!');
					setTimeout(function(){ 
						$(".success-msg-reg").hide("slow"); 
						$('.signInBtnnew').html('Register');
						$('#loginModal').modal('toggle');
					}, 3000);
                }
            },
            error: function (responseData, textStatus, errorThrown) {
                console.log(responseData);
            }
        });
    });		
	
    $('#facebooklogin').on('click', function () {
        $.ajax({
            type: "get",
            url: JS_BASE_URL + '/auth/facebook/login?=' + 1,
            cache: false,
            success: function (responseData, textStatus, jqXHR) {
                
                /*if(responseData == "false"){
                 $('#error-msg').html('<h5>Invalid user name or password!</h5>')
                 }
                 else{
                 window.location.reload();
                 }*/
            },
            error: function (responseData, textStatus, errorThrown) {
                // alert(errorThrown);
            }
        });
    });
    /*
     Update product info from album view js
     */
    $('#update-pro').on('click', function () {
        common_ajax(dataarray, 'update-pro');
    });
    $('.category_list').on('click', function () {
        $(this).find('.subcat_list').collapse('toggle');
    });
    $('#tab-product-detail').on('click', '.edit_pro', function () {
        var obj = $(this);
        updatepro(obj);
    });
    $('#p-pricingT').on('click', '.edit_pro', function () {
        var obj = $(this);
        updatepro(obj);
    });
    $('#p-specsT').on('click', '.edit_pro', function () {
        var obj = $(this);
        updatepro(obj);
    });
    /* update vbanner from album view */
    $('#append-v-or-b').on('click', '.upload-vbanner', function () {
        var rowid = $(this).data('rowid');
        if (rowid != '') {
            VbannerPopup('update', rowid);
        } else
        {
            VbannerPopup('add', rowid);
        }
    });
    /* album vbanner */
    $("#upld-v-or-b").click(function () {
        rowNum = parseInt($('#video-counter').data('row-count'));
        rowNum++;
        if ($('.upld-bvideo').length >= 1) {
            $('#upld-v-or-b').addClass('hidden');
        }
        $('#video-counter').attr('data-row-count', function (i, val) {
            return val * 1 + 1
        });
        $("#append-v-or-b").append('<div  id="video" class="col-xs-12 margin-top video-banner upld-bvideo">' +
            '<div class="placeholder main-parent">' +
            '   <a class="badge badge-close rem-v-or-b" data-id="">X</a>' +
            //'<input type="radio"'+
            //'class="badge-checkbox"'+
            //'name="video-banner" data-id="{{$vbanner->id}}"'+
            // 'value="{{$vbanner->id}}"/>'+
            '<div id="block2"> ' +
            '<span style="display: none"></span> ' +
            '</div>' +
            '<a class="badge badge-upload upload-vbanner" data-rowid="">' +
            '<i class="fa fa-lg fa-upload"></i>' +
            '</a>' +
            '</div>' +
            '</div>' +
            '</div>');
    });

	Number.prototype.formatMoney = function(c, d, t){
	var n = this,
		c = isNaN(c = Math.abs(c)) ? 2 : c,
		d = d == undefined ? "." : d,
		t = t == undefined ? "," : t,
		s = n < 0 ? "-" : "",
		i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
		j = (j = i.length) > 3 ? j % 3 : 0;
	   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	 };

    $('#editModel').on('hidden.bs.modal', function () {
        var column = $('#editbody').find('.columnval').val();
		var newval = $('#editbody').find('.newdata').val();

        var action = $('.newvalue').data('action');
        var table_name = $('.newvalue').data('tablename');
        var col_name = $('.newvalue').data('columnname');
        var row_id = $('.newvalue').data('rowid');
        var spec = $('.newvalue').data('spec');
		if(column.indexOf("price") > -1){
			var val = parseInt(newval);
			val = (val).formatMoney(2, '.', ',');
			val = currentCurrency + " " + val;
		} else {
			if (newval.split('%d%')[1])
			{
				var val = newval.split('%d%')[1];
				$('.newvalue').attr('data-value', val);
			} else {
				var val = newval.split('%d%')[0];
			}
		}
        //maintain user effected rows record
        dataarray[dataarray.length] = {action: action, table_name: table_name, col_name: col_name, row_id: row_id, value: val, spec: spec};

        $('.newvalue').html(newval.split('%d%')[0]);
        $('.newvalue').removeClass('newvalue');
        //alert(dataarray.length);

    });

    /*
     Delete product info from album view js
     */
    $('#tab-product-detail').on('click', '.del-val', function () {

        if ($(this).is(':checked')) {
            var pro_id = $(this).data('pro-id');
            var mer_id = $(this).data('merchant-id');
            delarray[delarray.length] = pro_id;
        } else
        {
            var pro_id = $(this).data('pro-id');
            delarray = jQuery.grep(delarray, function (val) {
                return val != pro_id;
            });
            console.log("lenght is " + delarray.length);
        }
        if (delarray.length > 0)
        {
            $('#del-pro').fadeIn();
        } else
        {
            $('#del-pro').fadeOut();
        }
    });
    $('#del-pro').on('click', function () {
        $('#AlertModel').modal('show');
    });
    $('#yes-del').on('click', function () {
        common_ajax(delarray, 'delete-pro');
        $.each(delarray, function (i, val) {
            var count_class = $('.' + val).data('subcategoryid');
            var curr = parseInt($('.count' + count_class).html());
            $('.' + val).remove();
            $('.count' + count_class).html(curr - 1);
            var pro_count = parseInt($('#pro-counter').html());
            $('#pro-counter').html(pro_count - 1);
            console.log('del id ' + val);
        });
    });
});
function updatepro(obj)
{
	var html = "";
    var column = obj.data('columnname');
	var id = obj.data('rowid');
	var value="";
    if (column == 'category_id')
    {
        var cat_id = obj.attr('data-value');
        Category(obj, 'cat', id, cat_id, column);
    } else if (column == 'brand_id')
    {
        Category(obj, 'brand', id, '',column);
    } else if (column == 'subcat_id')
    {
        var cat_id = obj.parent().find('.main-cat').attr('data-value');
        //var id = obj.parents('tr').find('.main-cat').data('value');
        Category(obj, '', id, cat_id, column);
    } else {
        var val = obj.html();
		if(column.indexOf("price") > -1){
			val = val.substr(4);
		}
        obj.addClass('newvalue');
        $('#editModel').modal('show');
        $('#editbody').html('\
                <div class="form-group">\
                    <textarea class="form-control newdata" rows="3" id="dataval">' + val + '</textarea>\
                    <input class="columnval" type="hidden" value="'+ column +'">\
                </div>\
                <div class="form-group">\
                    <div class="col-sm-2">\
                        <button type="button" class="btn btn-primary" id="'+ column +'" data-dismiss="modal" aria-label="Close" style="width: 100%">Save</button>\
                    </div>\
                    <div class="col-sm-2">\
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary" style="width: 100%">close</button>\
                    </div>\
                    <div style="clear: both"></div>\
                </div>');
    }
	$('#' + column).on('click', function () {
		value = $("#dataval").val();
		if(column.indexOf("price") > -1){
			value = value.replace('.','');
		}
		$.ajax({
			url: JS_BASE_URL+'/products/product_upadte/' + id,
			type: 'POST',
			dataType: "json",
			data: {'value': value, 'column': column},
			success: function (data) {

			},
			cache: false
		});
		if(column == "available"){
			if(parseInt(value)>0){
				$("#available_td").css( "color", "#777" );
				$("#available_td").css( "background-color", "#FFF" );
				$("#available_td").css( "border-color", "#ddd" );
			} else {
				$("#available_td").css( "color", "#fff" );
				$("#available_td").css( "background-color", "#FF5151" );
				$("#available_td").css( "border-color", "#C70D0D" );
			}
		}
	});
}

function Category(obj, type, id, cat_id, column)
{
    $.ajax({
        type: "post",
        url: JS_BASE_URL + '/CategoryAndBrand',
        data: {table: type, id: id, cat_id: cat_id},
        cache: false,
        success: function (responseData, textStatus, jqXHR) {
            obj.addClass('newvalue');
            $('#editModel').modal('show');
            $('#editbody').html('\
                <div class="form-group" >\
                    <select class="newdata form-control" id="dataval">\
                       ' + responseData + '\
                    </select>\
                </div>\
                <input class="columnval" type="hidden" value="'+ column +'">\
                <div class="form-group">\
                    <div class="col-sm-2">\
                        <button type="button" class="btn btn-primary" id="'+ column +'" data-dismiss="modal" aria-label="Close" style="width: 100%">Save</button>\
                    </div>\
                    <div class="col-sm-2">\
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary" style="width: 100%">close</button>\
                    </div>\
                    <div style="clear: both"></div>\
                </div>');

				$('#' + column).on('click', function () {
					value = $("#dataval").val();
					value = value.split("%d%");
					value = value[1];
					$.ajax({
						url:JS_BASE_URL+'/products/product_upadte/' + id,
						type: 'POST',
						dataType: "json",
						data: {'value': value, 'column': column},
						success: function (data) {
							console.log(data);
						},
						cache: false
					});
				});

            $("#editModel").on("hidden.bs.modal", function () {
                $("#editbody").html("");
            });
        },
        error: function (responseData, textStatus, errorThrown) {
            // alert(errorThrown);
        }
    });
}

function VbannerPopup(action, rowid)
{
    $('#MessageModel').modal('show');
    $('#Messagebody').html('<div class="modal-header">\
                                <h4 class="modal-title"><strong>Video URL</strong></h4>\
                            </div>\
                            <div class="modal-body">\
                                <input type="url" required id="vbanner-url" class="form-control" placeholder="http://www.youtube.com/embed/1I6l6OYx8Jg">\
                                <div class="pull-right" style="padding-top: 15px;">\
                                     <button type="button" class="btn btn-primary" id="yes-Url">Yes</button>\
                                     <button type="button" class="btn btn-danger" id="no-del" data-dismiss="modal">No</button>\
                                 </div>\
                                <div class="clearfix"></div>\
                            <hr>\
                            <div id="show_message_video"></div>\
                            <div class="progress" id="progressbar" style="display: none">\
                                <div class="progress-bar progress-bar-striped active" style="width:0%">\
                                    0%\
                                </div>\
                            </div>\
                            <div class="pull-left col-sm-6">\
                                <input type="file" id="upload-image" style="display: none">\
                                <button class="btn btn-primary" id="imgbtn"><i class="fa fa-lg fa-upload"></i> Upload image</button>\
                            </div>\
                            <div class="pull-left col-sm-6">\
                                <input type="file" id="upload-video" style="display: none">\
                                <button class="btn btn-primary" id="videobtn"><i class="fa fa-lg fa-upload"></i> Upload Video</button>\
                            </div>\
                            <div class="clearfix"></div>\
                            </div>');
    $('#imgbtn').on('click', function () {
        $("#progressbar").fadeOut();
        $("#show_message_video").fadeOut();
        $('#upload-image').trigger('click');
    });
    $('#videobtn').on('click', function () {
        $("#progressbar").fadeOut();
        $("#show_message_video").fadeOut();
        $('#upload-video').trigger('click');
    });
    $('#upload-image').on('change', function () {
        var obj = $(this);
        if (obj.val() != '') {
            var fileTypes = {'image/jpg': 'jpg', 'image/jpeg': 'jpeg', 'image/png': 'png'};  //acceptable file types
            var extension = obj[0].files[0].type;  //file extension from input file
            var isSuccess = fileTypes[extension];  //is extension in acceptable types
            if (isSuccess) {
                var file_data = obj.prop('files')[0];
                var filedata = new FormData();
                filedata.append('action', action);
                filedata.append('rowid', rowid);
                filedata.append('file', file_data);
                $("#progressbar").show();
                uploadVbanner(filedata, 'vbanner_image');
            } else
            {
                alert('Error!Please select a valid image');
            }
        }
    });
    $('#upload-video').on('change', function () {
        var obj = $(this);
        if (obj.val() != '') {
            var fileTypes = {'video/mp4': 'mp4'};  //acceptable file types
            var extension = obj[0].files[0].type;  //file extension from input file
            var isSuccess = fileTypes[extension];  //is extension in acceptable types
            if (isSuccess) {
                var file_data = obj.prop('files')[0];
                var filedata = new FormData();
                filedata.append('action', action);
                filedata.append('rowid', rowid);
                filedata.append('file', file_data);
                $("#progressbar").show();
                uploadVbanner(filedata, 'vbanner_image');
            } else
            {
                alert('Error!Please select a valid video');
            }
        }
    });
    $('#yes-Url').on('click', function () {
        var val = $('#vbanner-url').val();
        if (val != '') {
            var array = [action, rowid, val];
            common_ajax(array, 'update-vbanner');
        }
    });
}
function uploadVbanner(datainfo, route) {
    $.ajax({
        xhr: function () {
            var ajax = new window.XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler);
            return ajax;
        },
        type: "post",
        url: JS_BASE_URL + '/' + route,
        data: datainfo,
        cache: false,
        contentType: false,
        processData: false,
        success: function (responseData, textStatus, jqXHR) {
            if (responseData == 'false') {
                $('#show_message_video').fadeIn();
                $('#show_message_video').html('<div class="alert alert-danger" role="alert">Error! Video size too large</div>');
            } else {
                window.location.reload();
            }
        },
        error: function (responseData, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}
function progressHandler(event) {
    var percent = (event.loaded / event.total) * 100;
    percent = Math.round(percent);
    $("#progressbar").find('div').width(percent + '%');
    $("#progressbar").find('div').html(percent + ' %');
}
function common_ajax(datainfo, route)
{
    if (datainfo.length != 0) {
        $.ajax({
            type: "post",
            url: JS_BASE_URL + '/' + route,
            data: {info: datainfo},
            cache: false,
            success: function (responseData, textStatus, jqXHR) {
                $('#show_message').html('<div class="alert alert-success" role="alert">' + responseData + '</div>');
                if (route == 'update-vbanner') {
                    window.location.reload();
                }
            },
            error: function (responseData, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }
}

function splitclass(data)
{
    return data.split(' ');
}

$(document).ready(function () {
    $('.datepicker').Zebra_DatePicker({
        format: "d-M-Y"
    });

    $('.first-level-menu-li-a').click(function () {
        var parent = $(this).parents('li').first();
        $(parent).find('.second-level-sub-menu').slideToggle();
    });

    $('.second-level-sub-menu li').click(function () {
        if ($("#sales-analysis").length == 0) {
            var hash = $(this).attr('data-hash');
            window.location.href = '/admin/analysis/sales#' + hash;
        } else
        {
            var menu = $(this).attr('id');

            if (menu == 'list-world')
            {
                chart.series[0].setData([]);
                localStorage.setItem("label", "world");
                localStorage.setItem("id", 0);
                $('#merchant-select-container').hide();
                $('#countries-main-container').hide();
                $('#merchant-consultant-select-container').hide();
                $('#sales-report-name').text('Sales Report - Worldwide');
                getWorldDetails1();
            } else if (menu == 'list-country')
            {
                chart.series[0].setData([]);
                localStorage.setItem("label", "country");
                $('#merchant-select-container').hide();
                $('#merchant-consultant-select-container').hide();
                $('#countries-main-container').show();
                $('#sales-report-name').text('Sales Report - By country');
            } else if (menu == 'list-merchant-consultant')
            {
                chart.series[0].setData([]);
                localStorage.setItem("label", "merchant_consultant");
                $('#countries-main-container').hide();
                $('#merchant-select-container').hide();
                $('#merchant-consultant-select-container').show();
                $('#sales-report-name').text('Sales Report - By Merchant Consultant');
            } else if (menu == 'list-merchant')
            {
                chart.series[0].setData([]);
                localStorage.setItem("label", "merchant");
                $('#countries-main-container').hide();
                $('#merchant-consultant-select-container').hide();
                $('#merchant-select-container').show();
                $('#sales-report-name').text('Sales Report - By Merchant');
            }
        }
    });
});

function getWorldDetails1(type="ytd")
{
    var fromDate = $('#from_date').val();
    var toDate = $('#to_date').val();
    if (fromDate == '' || toDate == '')
    {
        alert("Please enter from date and to date");
        return;
    }
    $.ajax({
        url: JS_BASE_URL+'/sales/getWorldWideSalesData',
        type: 'POST',
        dataType: "json",
        data: {'from_date': fromDate, 'to_date': toDate,'type':type},
        success: function (data) {
            chart.series[0].setData(data[0].data);
            html = '';

            var currentYear = '';
            var count = 1;
            var style = '';
            var max = '';
            var min = '';
            var currentMonth = 0;
            var c = 0;
            var yearCount = 0;

            $.each(data[0].view, function (index, value) {
                var monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                if (max == '')
                {
                    max = value.total_payment / 100;
                } else
                {
                    if (max < value.total_payment / 100)
                    {
                        max = value.total_payment / 100;
                    }
                }

                if (min == '')
                {
                    min = value.total_payment / 100;
                } else
                {
                    if (min > value.total_payment / 100)
                    {
                        min = value.total_payment / 100;
                    }
                }
                d = new Date(value.consignment);
                style = 'display:none';
                if (currentYear != d.getFullYear())
                {
                    if (count != 1)
                    {
                        if (currentMonth < 12)
                        {
                            for (c = ++currentMonth; currentMonth < 12; currentMonth++)
                            {
                                html += "<tr class='year-sub-" + d1.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                            }
                        }
                    }
                    html += "<tr class='year-main' data-year='" + d.getFullYear() + "'><th colspan='2'>Year - " + d.getFullYear() + "</th></tr>";
                    currentYear = d.getFullYear();
                    if (d.getMonth() > 0)
                    {
                        for (e = 0; e < d.getMonth(); e++)
                        {
                            html += "<tr class='year-sub-" + currentYear + "' style='" + style + "'><td>" + monthNames[e] + "</td><td style='text-align:center'> --- </td></tr>";
                        }
                    }
                } else
                {
                    yearCount++;
                    if (count != 1)
                    {
                        currentMonth++;
                        while (currentMonth != d.getMonth() && currentMonth != 13)
                        {
                            html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                            if (currentMonth > 12)
                            {
                                currentMonth = 0;
                            } else
                            {
                                currentMonth++;
                            }

                        }
                    }
                }
                d1 = d;
                newDate = monthNames[d.getMonth()] + " - " + d.getFullYear();
                count++;

                currentMonth = d.getMonth();
                html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[d.getMonth()] + "</td><td style='text-align:right'>MYR " + value.total_payment / 100 + "</td></tr>";

            });
            $('#each-month-table').html(html);
            var max_min = "<tr><td>Max</td><td style='text-align:right'>" + currentCurrency + " " + max + "</td></tr>";
            max_min += "<tr><td>Min</td><td style='text-align:right'>" + currentCurrency + " " + min + "</td></tr>";
            max_min += "<tr><td>Average/Day</td><td style='text-align:right'>" + currentCurrency + " " + data[0].averagePerDay + "</td></tr>";
            max_min += "<tr><td>Average/Deal</td><td style='text-align:right'>" + currentCurrency + " " + data[0].averagePerDeal + "</td></tr>";
            $('#each-month-max-min-table').html(max_min);
        },
        cache: false
    });
}

$(document).ready(function () {
	//console.log(window.location.pathname);
    if (window.location.pathname == '/admin/analysis/sales')
    {
       // alert("fsdafs");
		getWorldDetails("ytd");
    }else if (window.location.pathname.includes('/merchant/salesreport')) {
		//console.log("Hola");

        getMerchantDetails($("#merchant_id").val(),"ytd");

    }else if (window.location.pathname.includes('/station/salesreport')) {
         getStationDetails($("#station_id").val(),"ytd");
    }
    // hash found
    localStorage.setItem("label", "world");
    localStorage.setItem("id", 0);
    $('.country-admin-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url: JS_BASE_URL+'/state/list/' + $('.country-admin-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						console.log(data[0].data);
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.state-admin-select-container').find('.select2-selection__rendered').text('Select...');
						$('.state-admin-field').html(html);
					}
				},
				cache: false
			});
			getWorldDetails();
        }
    });

    $('.state-admin-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url:JS_BASE_URL+'/city/list/' + $('.state-admin-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.city-admin-select-container').find('.select2-selection__rendered').text('Select...');
						$('.city-admin-field').html(html);
					}
				},
				cache: false
			});
			getWorldDetails();
        }
    });
	
    $('.city-admin-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url:JS_BASE_URL+'/area/list/' + $('.city-admin-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.area-admin-select-container').find('.select2-selection__rendered').text('Select...');
						$('.area-admin-field').html(html);
					}
				},
				cache: false
			});
			getWorldDetails();
        }
    });		
	
	 $('.product-admin-field').change(function () {
		 getWorldDetails();
	 });
	 
	 $('.brand-admin-field').change(function () {
		 getWorldDetails();
		 var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/brandproducts',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('.product-admin-field').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }		 
	 });	 
	 
	 $('.category-admin-field').change(function () {
		var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/subcategory',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('.subcategory-admin-field').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }	
		getWorldDetails();
		 
	 });	

	 $('.subcategory-admin-field').change(function () {
		var val = $(this).val();
		 if (val != "") {
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/subcatproducts',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('.product-admin-field').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });	
		 }			
		 getWorldDetails();
	 });

	 $('.consumer-admin-field').change(function () {
		 getWorldDetails();
	 });

	 $('.channel-admin-field').change(function () {
		 getWorldDetails();
	 });	
	/******* ************/
    $('.country-station-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url:JS_BASE_URL+'/state/list/' + $('.country-station-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						console.log(data[0].data);
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.state-station-select-container').find('.select2-selection__rendered').text('Select...');
						$('.state-station-field').html(html);
					}
				},
				cache: false
			});
			getStationDetails($("#station_id").val());
        }
    });

    $('.state-station-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url:JS_BASE_URL+'/city/list/' + $('.state-station-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.city-station-select-container').find('.select2-selection__rendered').text('Select...');
						$('.city-station-field').html(html);
					}
				},
				cache: false
			});
			getStationDetails($("#station_id").val());
        }
    });
	
    $('.city-station-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url:JS_BASE_URL+'/area/list/' + $('.city-station-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.area-station-select-container').find('.select2-selection__rendered').text('Select...');
						$('.area-station-field').html(html);
					}
				},
				cache: false
			});
			getStationDetails($("#station_id").val());
        }
    });		
	
	 $('.product-station-field').change(function () {
		 getStationDetails($("#station_id").val());
	 });
	 
	 $('.brand-station-field').change(function () {
		 var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/sbrandproducts/' + $("#station_id").val(),
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('.product-station-field').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
		 getStationDetails($("#station_id").val());
	 });	 
	 
	 $('.category-station-field').change(function () {
		var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/subcategorys/' + $("#station_id").val(),
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('.subcategory-station-field').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }	
		getStationDetails($("#station_id").val());
		 
	 });	

	 $('.subcategory-station-field').change(function () {
		 getStationDetails($("#station_id").val());
	 });

	 $('.consumer-station-field').change(function () {
		 getStationDetails($("#station_id").val());
	 });

	 $('.channel-station-field').change(function () {
		 getStationDetails($("#station_id").val());
	 });	
	/******* ************/
	 $('.product-merchant-field').change(function () {
		 getMerchantDetails($("#merchant_id").val());
	 });
	 
	 $('.brand-merchant-field').change(function () {
		 var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/brandproducts/' + $("#merchant_id").val(),
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('.product-merchant-field').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }		 
		 getMerchantDetails($("#merchant_id").val());
	 });	 
	 
	 $('.category-merchant-field').change(function () {
		var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/subcategory/' + $("#merchant_id").val(),
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('.subcategory-merchant-field').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }	
		getMerchantDetails($("#merchant_id").val());
		 
	 });	

	 $('.subcategory-merchant-field').change(function () {
		 getMerchantDetails($("#merchant_id").val());
	 });

	 $('.consumer-merchant-field').change(function () {
		 getMerchantDetails($("#merchant_id").val());
	 });

	 $('.channel-merchant-field').change(function () {
		 getMerchantDetails($("#merchant_id").val());
	 });	 
	
    $('.country-merchant-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url:JS_BASE_URL+'/state/list/' + $('.country-merchant-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						console.log(data[0].data);
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.state-merchant-select-container').find('.select2-selection__rendered').text('Select...');
						$('.state-merchant-field').html(html);
					}
				},
				cache: false
			});
			getMerchantDetails($("#merchant_id").val());
        }
    });

    $('.state-merchant-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url:JS_BASE_URL+'/city/list/' + $('.state-merchant-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.city-merchant-select-container').find('.select2-selection__rendered').text('Select...');
						$('.city-merchant-field').html(html);
					}
				},
				cache: false
			});
			getMerchantDetails($("#merchant_id").val());
        }
    });
	
    $('.city-merchant-field').change(function () {
        if ($(this).val() != '')
        {
            $.ajax({
				url:JS_BASE_URL+'/area/list/' + $('.city-merchant-field').val(),
				type: 'GET',
				dataType: "json",
				success: function (data) {
					if (data[0].success == true)
					{
						var html = '';
						html += "<option value=''>Select...</option>"

						$.each(data[0].data, function (index, value) {
							html += "<option value='" + index + "'>" + value + "</option>"
						});
						$('.area-merchant-select-container').find('.select2-selection__rendered').text('Select...');
						$('.area-merchant-field').html(html);
					}
				},
				cache: false
			});
			getMerchantDetails($("#merchant_id").val());
        }
    });	

    $('.merchant-field').change(function () {
        if ($(this).val() != '')
        {
            getMerchantDetails($(this).val())
        }
    });

    $('.merchant-consultant-field').change(function () {
        if ($(this).val() != '')
        {
            getMerchantConsultantDetails($(this).val());
        }
    });

	$('#graph-search-station').click(function () {
		getStationDetails($('#station_id').val());
	});
	
    $('#graph-station-since').click(function () {
        var label = localStorage.getItem("label");
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
         getStationDetails($('#station_id').val(),"since");
    });	
	
    $('#graph-station-ytd').click(function () {
        var label = localStorage.getItem("label");
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
        getStationDetails($('#station_id').val(),"ytd");
    });		
	
    $('#graph-station-mtd').click(function () {
        var label = localStorage.getItem("label");
		console.log(label);
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
        getStationDetails($('#station_id').val(),"mtd");
    });		
	
	$('#graph-search-merchant').click(function () {
		getMerchantDetails($('#merchant_id').val());
	});
	
    $('#graph-merchant-since').click(function () {
        var label = localStorage.getItem("label");
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
        var type = $(this).attr('rel-type');
         getMerchantDetails($('#merchant_id').val(),type);
    });
    $('#graph-merchant-ytd').click(function () {
        var label = localStorage.getItem("label");
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
        var type = $(this).attr('rel-type');
        getMerchantDetails($('#merchant_id').val(),type);
        
    });
    $('#graph-merchant-mtd').click(function () {
        var label = localStorage.getItem("label");
		console.log(label);
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
        var type = $(this).attr('rel-type');
        getMerchantDetails($('#merchant_id').val(),type);
    });
    $('#graph-merchant-wtd').click(function () {
        //alert("test");
        var label = localStorage.getItem("label");
        console.log(label);
        var from = $('#from_date').val($(this).attr('from'));
        var to = $('#to_date').val($(this).attr('to'));
        var type = $(this).attr('rel-type');
        getMerchantDetails($('#merchant_id').val(),type);
    });
    $('#graph-merchant-daily').click(function () {
        //alert("test");
        var label = localStorage.getItem("label");
        console.log(label);
        var from = $('#from_date').val($(this).attr('from'));
        var to = $('#to_date').val($(this).attr('to'));
        var type = $(this).attr('rel-type');
        getMerchantDetails($('#merchant_id').val(),type);

    });
    /*$('#graph-merchant-hourly').click(function () {
        
        var label = localStorage.getItem("label");
        console.log(label);
        var from = $('#from_date').val($(this).attr('from'));
        var to = $('#to_date').val($(this).attr('to'));
        var type = $(this).attr('rel-type');
        alert(type);
        getMerchantDetails($('#merchant_id').val(),type);
    });*/
	
    $('#graph-search').click(function () {
            getWorldDetails();
    });
	
    $('#graph-since').click(function () {
        var label = localStorage.getItem("label");
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
            getWorldDetails("since");
    });	
	
    $('#graph-ytd').click(function () {
        var label = localStorage.getItem("label");
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
            getWorldDetails();
    });		
	
    $('#graph-mtd').click(function () {
        var label = localStorage.getItem("label");
		console.log(label);
		$('#from_date').val($(this).attr('from'));
		$('#to_date').val($(this).attr('to'));
        getWorldDetails("mtd");
    });		

	
	var payment_table;
	$(document).delegate( '.paymentFigure', "click",function (event) {
		var filter = $(this).attr("rel");
		var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
		var country = $('.country-admin-field').val();
		var state = $('.state-admin-field').val();
		var city = $('.city-admin-field').val();
		var marea = $('.area-admin-field').val();
		var product = $('.product-admin-field').val();
		var brand = $('.brand-admin-field').val();
		var category = $('.category-admin-field').val();
		var subcategory = $('.subcategory-admin-field').val();
		var consumer = $('.consumer-admin-field').val();
		var channel = $('.channel-admin-field').val();
		var partner = $('.partner-admin-field').val();
		if(payment_table){
            payment_table.destroy();
            $('#myTable').empty();
        }
		$.ajax({
            url:JS_BASE_URL+'/sales/getWorldWideSalesData/' + filter,
            type: 'POST',
            dataType: "json",
            data: {'from_date': fromDate, 'to_date': toDate, 'country': country, 'state': state, 'city': city, 'marea': marea, 'product': product, 'brand': brand, 'category': category, 'subcategory': subcategory, 'channel': channel, 'consumer': consumer, 'partner': partner},
            success: function (data) {
				console.log(data);

				$('#myTable').append('<thead style="background-color: #31b0d5; color: #fff;"><th style="text-align: center;">No</th><th style="text-align: center;">DO ID</th><th style="text-align: center;">Sales</th><th style="text-align: center;">Date</th></thead>');
                $('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					$('#myTable').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;"><a target="_blank" href="' + JS_BASE_URL + '/deliveryorder/'+obj.id+'">'+ obj.nporder_id +'</a></td><td style="text-align: right;">' + currentCurrency + ' ' + js_number_format(parseFloat(obj.sales/100),2,'.','') + ' </td><td style="text-align: center;">' + obj.date + ' </td></tr>');
				}
				$('#myTable').append('</tbody>');

				payment_table = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "20px", "orderable": false },
						{ "width": "85px" },
						{ "width": "40px" },
						{ "width": "40px" }
					  ]
				});

				$("#myModal").modal("show");
			}
		});	
	});	

    function getWorldDetails()
    {
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
		var country = $('.country-admin-field').val();
		var state = $('.state-admin-field').val();
		var city = $('.city-admin-field').val();
		var marea = $('.area-admin-field').val();
		var product = $('.product-admin-field').val();
		var brand = $('.brand-admin-field').val();
		var category = $('.category-admin-field').val();
		var subcategory = $('.subcategory-admin-field').val();
		var consumer = $('.consumer-admin-field').val();
		var channel = $('.channel-admin-field').val();
		var partner = $('.partner-admin-field').val();
		console.log("Hola");
        if (fromDate == '' || toDate == '')
        {
            alert("Please enter from date and to date");
            return;
        }
        localStorage.setItem("label", "admin");
        $.ajax({
            url:JS_BASE_URL+'/sales/getWorldWideSalesData',
            type: 'POST',
            dataType: "json",
            data: {'from_date': fromDate, 'to_date': toDate, 'country': country, 'state': state, 'city': city, 'marea': marea, 'product': product, 'brand': brand, 'category': category, 'subcategory': subcategory, 'channel': channel, 'consumer': consumer, 'partner': partner},
            success: function (data1) {
            
                chart.series[0].setData(data1[0].data);
				chart.xAxis[0].setCategories(data1[0].xaxis_categories);
                html = '';

                var currentYear = '';
                var count = 1;
                var style = '';
                var max = '';
                var min = '';
                var currentMonth = 0;
                var c = 0;
                var yearCount = 0;

                $.each(data1[0].view, function (index, value) {
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    if (max == '')
                    {
                        max = value.payable / 100;
                    } else
                    {
                        if (max < value.payable)
                        {
                            max = value.payable;
                        }
                    }

                    if (min == '')
                    {
                        min = value.payable;
                    } else
                    {
                        if (min > value.payable)
                        {
                            min = value.payable;
                        }
                    }

                    d = new Date(value.consignment);
                    style = 'display:none';
					//console.log(d);
                    if (currentYear != d.getFullYear())
                    {
                        if (count != 1)
                        {
                            if (currentMonth < 12)
                            {
                                for (c = ++currentMonth; currentMonth < 12; currentMonth++)
                                {
                                    html += "<tr class='year-sub-" + d1.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                }
                            }
                        }

                        html += "<tr class='year-main' data-year='" + d.getFullYear() + "'><th colspan='2'>Year - " + d.getFullYear() + "</th></tr>";
                        currentYear = d.getFullYear();
                        if (d.getMonth() > 0)
                        {
                            for (e = 0; e < d.getMonth(); e++)
                            {
                                html += "<tr class='year-sub-" + currentYear + "' style='" + style + "'><td>" + monthNames[e] + "</td><td style='text-align:center'> --- </td></tr>";
                            }
                        }
                    } else
                    {
                        yearCount++;
                        if (count != 1)
                        {
                            currentMonth++;
                            while (currentMonth != d.getMonth() && currentMonth != 13)
                            {
                                html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                if (currentMonth > 12)
                                {
                                    currentMonth = 0;
                                } else
                                {
                                    currentMonth++;
                                }

                            }
                        }
                    }
                    d1 = d;
                    newDate = monthNames[d.getMonth()] + " - " + d.getFullYear();
                    count++;

                    currentMonth = d.getMonth();
                    html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[d.getMonth()] + "</td><td style='text-align:right'>" + currentCurrency + " " + value.payable + "</td></tr>";
                });
                //$('#each-month-table').html(html);
                alert("test");

                
                var max_min = "<tr><td>&nbsp;</td><td>&nbsp;</td><td style='text-align:center'>Today</td><td style='text-align:center'>WTD</td><td style='text-align:center'>MTD</td><td style='text-align:center'>YTD</td><td style='text-align:center'>Since</td></tr>";
                max_min += "<tr><td>Total Deals</td><td>&nbsp;</td><td style='text-align:center'>" + data1[0].totalDealstoday + "</td><td style='text-align:center'>" +data1[0].totalDealWeek + "</td><td style='text-align:center'>" +data1[0].totalDealswtd + "</td><td style='text-align:center'>" + data1[0].totalDealsmtd + "</td><td style='text-align:center'>" + data1[0].totalDealsytd + "</td><td style='text-align:center'>" + data1[0].totalDeals + "</td></tr>";
                max_min += "<tr><td>Total Sales</td><td>&nbsp;</td><td style='text-align:right'><a href='javascript:void(0);' rel='today' class='paymentFigure'>" + currentCurrency + " " +data1[0].totalPaymenttoday + "</a></td><td style='text-align:right'><a href='javascript:void(0);' rel='week' class='paymentFigure'>" + currentCurrency + " " + data1[0].totalPaymentwtd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' rel='month' class='paymentFigure'>" + currentCurrency + " " + data1[0].totalPaymentmtd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' rel='year' class='paymentFigure'>"+ currentCurrency +" " + data1[0].totalPaymentytd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' rel='since' class='paymentFigure'>"+ currentCurrency +" " + data1[0].totalSales + "</a></td></tr>";
                max_min += "<tr><td>Average/Deal</td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:right'>"+ currentCurrency +" " + js_number_format(parseFloat(data1[0].totalSales)/parseFloat(data1[0].totalDeals),2,'.','') + "</td></tr>";
				max_min += "<tr><th  colspan=7 style='background-color: #A9A9A9; text-align:center;'>PERFORMANCE</th></tr>";
				max_min += "<tr><td colspan='4' style='background-color: #91CDDD; color: #FFF;text-align:center;'>Best Performer</td><td colspan='3' style='background-color: #000; color: #FFF;text-align:center;'>Worst Performer</td></tr>";
				max_min += "<tr><td>Product</td><td>" + data1[0].maxproddesc.substr(0, 20) + "</td><td>" + data1[0].prodmaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxprod + "</td><td>" + data1[0].minproddesc.substr(0, 20) + "</td><td>" + data1[0].prodminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minprod + "</td></tr>";
				max_min += "<tr><td>Brand</td><td>" + data1[0].maxbranddesc.substr(0, 20) + "</td><td>" + data1[0].brandmaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxbrand + "</td><td>" + data1[0].minbranddesc.substr(0, 20) + "</td><td>" + data1[0].brandminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minbrand + "</td></tr>";
				max_min += "<tr><td>Category</td><td>" + data1[0].maxcategorydesc.substr(0, 20) + "</td><td>" + data1[0].categorymaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxcategory + "</td><td>" + data1[0].mincategorydesc.substr(0, 20) + "</td><td>" + data1[0].categoryminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].mincategory + "</td></tr>";
				max_min += "<tr><td>SubCategory</td><td>" + data1[0].maxsubcategorydesc.substr(0, 20) + "</td><td>" + data1[0].subcategorymaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxsubcategory + "</td><td>" + data1[0].minsubcategorydesc.substr(0, 20) + "</td><td>" + data1[0].subcategoryminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minsubcategory + "</td></tr>";
                $('#each-month-max-min-table').html(max_min);
            },
            cache: false
        });
    }

    function getCountryDetails(id)
    {
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        if (fromDate == '' || toDate == '')
        {
            alert("Please enter from date and to date");
            return;
        }
        localStorage.setItem("label", "country");
        localStorage.setItem("id", id);
        $.ajax({
            url:JS_BASE_URL+'/sales/getcountrySalesData',
            type: 'POST',
            dataType: "json",
            data: {'country_id': id, 'from_date': fromDate, 'to_date': toDate},
            success: function (data) {
                chart.series[0].setData(data[0].data);
                html = '';

                var currentYear = '';
                var count = 1;
                var style = '';
                var max = '';
                var min = '';
                var currentMonth = 0;
                var c = 0;
                var yearCount = 0;

                $.each(data[0].view, function (index, value) {
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    if (max == '')
                    {
                        max = value.total_payment / 100;
                    } else
                    {
                        if (max < value.total_payment / 100)
                        {
                            max = value.total_payment / 100;
                        }
                    }

                    if (min == '')
                    {
                        min = value.total_payment / 100;
                    } else
                    {
                        if (min > value.total_payment / 100)
                        {
                            min = value.total_payment / 100;
                        }
                    }

                    d = new Date(value.consignment);
                    style = 'display:none';

                    if (currentYear != d.getFullYear())
                    {
                        if (count != 1)
                        {
                            if (currentMonth < 12)
                            {
                                for (c = ++currentMonth; currentMonth < 12; currentMonth++)
                                {
                                    html += "<tr class='year-sub-" + d1.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td> --- </td></tr>";
                                }
                            }
                        }

                        html += "<tr class='year-main' data-year='" + d.getFullYear() + "'><th colspan='2'>Year - " + d.getFullYear() + "</th></tr>";
                        currentYear = d.getFullYear();
                        if (d.getMonth() > 0)
                        {
                            for (e = 0; e < d.getMonth(); e++)
                            {
                                html += "<tr class='year-sub-" + currentYear + "' style='" + style + "'><td>" + monthNames[e] + "</td><td style='text-align:center'> --- </td></tr>";
                            }
                        }
                    } else
                    {
                        yearCount++;
                        if (count != 1)
                        {
                            currentMonth++;
                            while (currentMonth != d.getMonth() && currentMonth != 13)
                            {
                                html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                if (currentMonth > 12)
                                {
                                    currentMonth = 0;
                                } else
                                {
                                    currentMonth++;
                                }
                            }
                        }
                    }
                    d1 = d;
                    newDate = monthNames[d.getMonth()] + " - " + d.getFullYear();
                    count++;

                    currentMonth = d.getMonth();
                    html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[d.getMonth()] + "</td><td style='text-align:right'>"+ currentCurrency +" " + value.total_payment / 100 + "</td></tr>";
                });
                $('#each-month-table').html(html);
                var max_min = "<tr><td>Max</td><td style='text-align:right'>"+ currentCurrency +" " + max + "</td></tr>";
                max_min += "<tr><td>Min</td><td style='text-align:right'>"+ currentCurrency +" " + min + "</td></tr>";
                max_min += "<tr><td>Average/Day</td><td style='text-align:right'>"+ currentCurrency +" " + data[0].averagePerDay + "</td></tr>";
                max_min += "<tr><td>Average/Deal</td><td style='text-align:right'>"+ currentCurrency +" " + data[0].averagePerDeal + "</td></tr>";

                $('#each-month-max-min-table').html(max_min);
            },
            cache: false
        });

    }

    function getStateDetails(id)
    {
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        if (fromDate == '' || toDate == '')
        {
            alert("Please enter from date and to date");
            return;
        }
        localStorage.setItem("label", "state");
        localStorage.setItem("id", id);
        $.ajax({
            url:JS_BASE_URL+'/sales/getstateSalesData',
            type: 'POST',
            dataType: "json",
            data: {'state_id': id, 'from_date': fromDate, 'to_date': toDate},
            success: function (data) {
                chart.series[0].setData(data[0].data);
                html = '';

                var currentYear = '';
                var count = 1;
                var style = '';
                var max = '';
                var min = '';
                var currentMonth = 0;
                var c = 0;
                var yearCount = 0;

                $.each(data[0].view, function (index, value) {
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    if (max == '')
                    {
                        max = value.total_payment / 100;
                    } else
                    {
                        if (max < value.total_payment / 100)
                        {
                            max = value.total_payment / 100;
                        }
                    }

                    if (min == '')
                    {
                        min = value.total_payment / 100;
                    } else
                    {
                        if (min > value.total_payment / 100)
                        {
                            min = value.total_payment / 100;
                        }
                    }
                    d = new Date(value.consignment);
                    style = 'display:none';

                    if (currentYear != d.getFullYear())
                    {
                        if (count != 1)
                        {
                            if (currentMonth < 12)
                            {
                                for (c = ++currentMonth; currentMonth < 12; currentMonth++)
                                {
                                    html += "<tr class='year-sub-" + d1.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                }
                            }
                        }

                        html += "<tr class='year-main' data-year='" + d.getFullYear() + "'><th colspan='2'>Year - " + d.getFullYear() + "</th></tr>";
                        currentYear = d.getFullYear();
                        if (d.getMonth() > 0)
                        {
                            for (e = 0; e < d.getMonth(); e++)
                            {
                                html += "<tr class='year-sub-" + currentYear + "' style='" + style + "'><td>" + monthNames[e] + "</td><td style='text-align:center'> --- </td></tr>";
                            }
                        }
                    } else {
                        yearCount++;
                        if (count != 1)
                        {
                            currentMonth++;
                            while (currentMonth != d.getMonth() && currentMonth != 13)
                            {
                                html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                if (currentMonth > 12)
                                {
                                    currentMonth = 0;
                                } else
                                {
                                    currentMonth++;
                                }

                            }
                        }
                    }
                    d1 = d;
                    newDate = monthNames[d.getMonth()] + " - " + d.getFullYear();
                    count++;

                    currentMonth = d.getMonth();
                    html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[d.getMonth()] + "</td><td style='text-align:right'>"+ currentCurrency +" " + value.total_payment / 100 + "</td></tr>";
                });
                $('#each-month-table').html(html);
                var max_min = "<tr><td>Max</td><td style='text-align:right'>"+ currentCurrency +" " + max + "</td></tr>";
                max_min += "<tr><td>Min</td><td style='text-align:right'>"+ currentCurrency +" " + min + "</td></tr>";
                max_min += "<tr><td>Average/Day</td><td style='text-align:right'>"+ currentCurrency +" " + data[0].averagePerDay + "</td></tr>";
                max_min += "<tr><td>Average/Deal</td><td style='text-align:right'>"+ currentCurrency +" " + data[0].averagePerDeal + "</td></tr>";
                $('#each-month-max-min-table').html(max_min);
            },
            cache: false
        });
    }

	
	var payment_tablem;
	$(document).delegate( '.paymentFigureMerchant', "click",function (event) {
		var id = $(this).attr("merchantrel");
        
		var filter = $(this).attr("rel");
        
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
		var country = $('.country-merchant-field').val();
		var state = $('.state-merchant-field').val();
		var city = $('.city-merchant-field').val();
		var marea = $('.area-merchant-field').val();
		var product = $('.product-merchant-field').val();
		var brand = $('.brand-merchant-field').val();
		var category = $('.category-merchant-field').val();
		var subcategory = $('.subcategory-merchant-field').val();
		var consumer = $('.consumer-merchant-field').val();
		var channel = $('.channel-merchant-field').val();


		if(payment_tablem){
            payment_tablem.destroy();
            $('#myTable').empty();
        }
		$.ajax({
            url:JS_BASE_URL+'/sales/getmerchantSalesData/' + filter,
            type: 'POST',
            dataType: "json",
            data: {'merchant_id': id,'type':'all','from_date': fromDate, 'to_date': toDate, 'country': country, 'state': state, 'city': city, 'marea': marea, 'product': product, 'brand': brand, 'category': category, 'subcategory': subcategory, 'channel': channel},
            success: function (data) {
				console.log(data);
                alert("test");
				$('#myTable').append('<thead style="background-color: #31b0d5; color: #fff;"><th style="text-align: center;">No</th><th style="text-align: center;">DO ID</th><th style="text-align: center;">Sales</th><th style="text-align: center;">Date</th></thead>');
                $('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					$('#myTable').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;"><a target="_blank" href="' + JS_BASE_URL + '/deliveryorder/'+obj.id+'">'+ obj.nporder_id +'</a></td><td style="text-align: right;">'+ currentCurrency +' ' + js_number_format(parseFloat(obj.sales/100),2,'.','') + ' </td><td style="text-align: center;">' + obj.date + ' </td></tr>');
				}
				$('#myTable').append('</tbody>');

				payment_tablem = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "20px", "orderable": false },
						{ "width": "85px" },
						{ "width": "40px" },
						{ "width": "40px" }
					  ]
				});

				$("#myModal").modal("show");
			}
		});	
	});		
	
    function getMerchantDetails(id,type="ytd")
    {
        
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
		var country = $('.country-merchant-field').val();
		var state = $('.state-merchant-field').val();
		var city = $('.city-merchant-field').val();
		var marea = $('.area-merchant-field').val();
		var product = $('.product-merchant-field').val();
		var brand = $('.brand-merchant-field').val();
		var category = $('.category-merchant-field').val();
		var subcategory = $('.subcategory-merchant-field').val();
		//var consumer = $('.consumer-merchant-field').val();
		var channel = $('.channel-merchant-field').val();


        if (fromDate == '' || toDate == '')
        {
            alert("Please enter from date and to date");
            return;
        }
		console.log(id);
        localStorage.setItem("label", "merchant");
        localStorage.setItem("id", id);

        $.ajax({

            url:JS_BASE_URL+'/sales/getmerchantSalesData',
            type: 'POST',
            dataType: "json",
            data: {'merchant_id': id,'type':type,'from_date': fromDate, 'to_date': toDate, 'country': country, 'state': state, 'city': city, 'marea': marea, 'product': product, 'brand': brand,'channel' : channel, 'category': category, 'subcategory': subcategory},            
            success: function (data1) {
                var formattedData=[];
                for (var i =0; i <  data1[0].data.length ; i++) {
                    newValue=data1[0].data[i]/100;
                    formattedData.push(newValue);

                }
                chart.series[0].setData(formattedData);
                chart.xAxis[0].setCategories(data1[0].xaxis_categories);
                html = '';

                var currentYear = '';
                var count = 1;
                var style = '';
                var max = '';
                var min = '';
                var currentMonth = 0;
                var c = 0;
                var yearCount = 0;

                $.each(data1[0].view, function (index, value) {
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    if (max == '')
                    {
                        max = value.payable / 100;
                    } else
                    {
                        if (max < value.payable)
                        {
                            max = value.payable;
                        }
                    }

                    if (min == '')
                    {
                        min = value.payable;
                    } else
                    {
                        if (min > value.payable)
                        {
                            min = value.payable;
                        }
                    }

                    d = new Date(value.consignment);
                    style = 'display:none';
					//console.log(d);
                    if (currentYear != d.getFullYear())
                    {
                        if (count != 1)
                        {
                            if (currentMonth < 12)
                            {
                                for (c = ++currentMonth; currentMonth < 12; currentMonth++)
                                {
                                    html += "<tr class='year-sub-" + d1.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                }
                            }
                        }

                        html += "<tr class='year-main' data-year='" + d.getFullYear() + "'><th colspan='2'>Year - " + d.getFullYear() + "</th></tr>";
                        currentYear = d.getFullYear();
                        if (d.getMonth() > 0)
                        {
                            for (e = 0; e < d.getMonth(); e++)
                            {
                                html += "<tr class='year-sub-" + currentYear + "' style='" + style + "'><td>" + monthNames[e] + "</td><td style='text-align:center'> --- </td></tr>";
                            }
                        }
                    } else
                    {
                        yearCount++;
                        if (count != 1)
                        {
                            currentMonth++;
                            while (currentMonth != d.getMonth() && currentMonth != 13)
                            {
                                html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                if (currentMonth > 12)
                                {
                                    currentMonth = 0;
                                } else
                                {
                                    currentMonth++;
                                }

                            }
                        }
                    }
                    d1 = d;
                    newDate = monthNames[d.getMonth()] + " - " + d.getFullYear();
                    count++;

                    currentMonth = d.getMonth();
                    html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[d.getMonth()] + "</td><td style='text-align:right'>"+ currentCurrency +" " + value.payable + "</td></tr>";
                });
                //$('#each-month-table').html(html);
                var max_min = "<tr><td>&nbsp;</td><td>&nbsp;</td><td style='text-align:center'>Today</td><td style='text-align:center'>WTD</td><td style='text-align:center'>MTD</td><td style='text-align:center'>YTD</td><td style='text-align:center'>Since</td></tr>";
                
                max_min += "<tr><td>Total Deals</td><td>&nbsp;</td><td style='text-align:center'>" + data1[0].totalDealstoday + "</td><td style='text-align:center'>" + data1[0].totalDealswtd + "</td><td style='text-align:center'>" + data1[0].totalDealsmtd + "</td><td style='text-align:center'>" + data1[0].totalDealsytd + "</td><td style='text-align:center'>" + data1[0].totalDeals + "</td></tr>";
                max_min += "<tr><td>Total Sales</td><td>&nbsp;</td><td style='text-align:right'><a href='javascript:void(0);' rel='today' merchantrel='"+ id +"' class='paymentFigureMerchant'>"+ currentCurrency +" " +data1[0].totalPaymenttoday + "</a></td><td style='text-align:right'><a href='javascript:void(0);' rel='week' merchantrel='"+ id +"' class='paymentFigureMerchant'>"+ currentCurrency +" " + data1[0].totalPaymentwtd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' merchantrel='"+ id +"' rel='month' class='paymentFigureMerchant'>"+ currentCurrency +" " + data1[0].totalPaymentmtd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' merchantrel='"+ id +"' rel='year' class='paymentFigureMerchant'>"+ currentCurrency +" " + data1[0].totalPaymentytd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' merchantrel='"+ id +"' rel='since' class='paymentFigureMerchant'>"+ currentCurrency +" " + data1[0].totalSales + "</a></td></tr>";                max_min += "<tr><td>Average/Deal</td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'>"+ currentCurrency +" " + js_number_format(parseFloat(data1[0].totalSales)/parseFloat(data1[0].totalDeals),2,'.','') + "</td></tr>";
				max_min += "<tr><th colspan=7 style='background-color: #A9A9A9; text-align:center;'>PERFORMANCE</th></tr>";
				max_min += "<tr><td colspan='4' style='background-color: #91CDDD; color: #FFF; text-align:center;'>Best Performer</td><td colspan='3' style='background-color: #000; color: #FFF;text-align:center;'>Worst Performer</td></tr>";
				max_min += "<tr><td>Product</td><td>" + data1[0].maxproddesc.substr(0, 20) + "</td><td>" + data1[0].prodmaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxprod + "</td><td>" + data1[0].minproddesc.substr(0, 20) + "</td><td>" + data1[0].prodminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minprod + "</td></tr>";
				max_min += "<tr><td>Brand</td><td>" + data1[0].maxbranddesc.substr(0, 20) + "</td><td>" + data1[0].brandmaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxbrand + "</td><td>" + data1[0].minbranddesc.substr(0, 20) + "</td><td>" + data1[0].brandminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minbrand + "</td></tr>";
				max_min += "<tr><td>Category</td><td>" + data1[0].maxcategorydesc.substr(0, 20) + "</td><td>" + data1[0].categorymaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxcategory + "</td><td>" + data1[0].mincategorydesc.substr(0, 20) + "</td><td>" + data1[0].categoryminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].mincategory + "</td></tr>";
				max_min += "<tr><td>SubCategory</td><td>" + data1[0].maxsubcategorydesc.substr(0, 20) + "</td><td>" + data1[0].subcategorymaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxsubcategory + "</td><td>" + data1[0].minsubcategorydesc.substr(0, 20) + "</td><td>" + data1[0].subcategoryminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minsubcategory + "</td></tr>";
                $('#each-month-max-min-table').html(max_min);
            },
            cache: false
        });
    }

	var payment_tables;
	$(document).delegate( '.paymentFigureStation', "click",function (event) {
		var id = $(this).attr("stationrel");
		var filter = $(this).attr("rel");
        
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
		var country = $('.country-station-field').val();
		var state = $('.state-station-field').val();
		var city = $('.city-station-field').val();
		var marea = $('.area-station-field').val();
		var product = $('.product-station-field').val();
		var brand = $('.brand-station-field').val();
		var category = $('.category-station-field').val();
		var subcategory = $('.subcategory-station-field').val();
		var consumer = $('.consumer-station-field').val();	
		if(payment_tables){
            payment_tables.destroy();
            $('#myTable').empty();
        }
		$.ajax({
            url:JS_BASE_URL+'/sales/getstationSalesData/' + filter,
            type: 'POST',
            dataType: "json",
			data: {'station_id': id,'type':'all', 'from_date': fromDate, 'to_date': toDate, 'country': country, 'state': state, 'city': city, 'marea': marea, 'product': product, 'brand': brand, 'category': category, 'subcategory': subcategory, 'consumer': consumer},
            success: function (data) {
				console.log(data);

				$('#myTable').append('<thead style="background-color: #31b0d5; color: #fff;"><th style="text-align: center;">No</th><th style="text-align: center;">DO ID</th><th style="text-align: center;">Sales</th><th style="text-align: center;">Date</th></thead>');
                $('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					$('#myTable').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;"><a target="_blank" href="' + JS_BASE_URL + '/deliveryorder/'+obj.id+'">'+ obj.nporder_id +'</a></td><td style="text-align: right;">'+ currentCurrency +' ' + js_number_format(parseFloat(obj.sales/100),2,'.','') + ' </td><td style="text-align: center;">' + obj.date + ' </td></tr>');
				}
				$('#myTable').append('</tbody>');

				payment_tables = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "20px", "orderable": false },
						{ "width": "85px" },
						{ "width": "40px" },
						{ "width": "40px" }
					  ]
				});

				$("#myModal").modal("show");
			}
		});	
	});		
	
    function getStationDetails(id,type="ytd")
    {
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
		var country = $('.country-station-field').val();
		var state = $('.state-station-field').val();
		var city = $('.city-station-field').val();
		var marea = $('.area-station-field').val();
		var product = $('.product-station-field').val();
		var brand = $('.brand-station-field').val();
		var category = $('.category-station-field').val();
		var subcategory = $('.subcategory-station-field').val();
		var consumer = $('.consumer-station-field').val();		
        if (fromDate == '' || toDate == '')
        {
            alert("Please enter from date and to date");
            return;
        }
        localStorage.setItem("label", "station");
        localStorage.setItem("id", id);
        $.ajax({
            url:JS_BASE_URL+'/sales/getstationSalesData',
            type: 'POST',
            dataType: "json",
            data: {'station_id': id,'type':type, 'from_date': fromDate, 'to_date': toDate, 'country': country, 'state': state, 'city': city, 'marea': marea, 'product': product, 'brand': brand, 'category': category, 'subcategory': subcategory, 'consumer': consumer},
            success: function (data1) {
                // console.log(data1);
                var formattedData=[];
                for (var i =0; i <  data1[0].data.length ; i++) {
                    newValue=data1[0].data[i]/100;
                    formattedData.push(newValue);

                }
                chart.series[0].setData(formattedData);
				chart.xAxis[0].setCategories(data1[0].xaxis_categories);

                html = '';

                var currentYear = '';
                var count = 1;
                var style = '';
                var max = '';
                var min = '';
                var currentMonth = 0;
                var c = 0;
                var yearCount = 0;

                $.each(data1[0].view, function (index, value) {
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    if (max == '')
                    {
                        max = value.payable / 100;
                    } else
                    {
                        if (max < value.payable)
                        {
                            max = value.payable;
                        }
                    }

                    if (min == '')
                    {
                        min = value.payable;
                    } else
                    {
                        if (min > value.payable)
                        {
                            min = value.payable;
                        }
                    }

                    d = new Date(value.consignment);
                    style = 'display:none';
					//console.log(d);
                    if (currentYear != d.getFullYear())
                    {
                        if (count != 1)
                        {
                            if (currentMonth < 12)
                            {
                                for (c = ++currentMonth; currentMonth < 12; currentMonth++)
                                {
                                    html += "<tr class='year-sub-" + d1.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                }
                            }
                        }

                        html += "<tr class='year-main' data-year='" + d.getFullYear() + "'><th colspan='2'>Year - " + d.getFullYear() + "</th></tr>";
                        currentYear = d.getFullYear();
                        if (d.getMonth() > 0)
                        {
                            for (e = 0; e < d.getMonth(); e++)
                            {
                                html += "<tr class='year-sub-" + currentYear + "' style='" + style + "'><td>" + monthNames[e] + "</td><td style='text-align:center'> --- </td></tr>";
                            }
                        }
                    } else
                    {
                        yearCount++;
                        if (count != 1)
                        {
                            currentMonth++;
                            while (currentMonth != d.getMonth() && currentMonth != 13)
                            {
                                html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                if (currentMonth > 12)
                                {
                                    currentMonth = 0;
                                } else
                                {
                                    currentMonth++;
                                }

                            }
                        }
                    }
                    d1 = d;
                    newDate = monthNames[d.getMonth()] + " - " + d.getFullYear();
                    count++;

                    currentMonth = d.getMonth();
                    html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[d.getMonth()] + "</td><td style='text-align:right'>"+ currentCurrency +" " + value.payable + "</td></tr>";
                });
                //$('#each-month-table').html(html);
                var max_min = "<tr><td>&nbsp;</td><td>&nbsp;</td><td style='text-align:center'>Today</td><td style='text-align:center'>WTD</td><td style='text-align:center'>MTD</td><td style='text-align:center'>YTD</td><td style='text-align:center'>Since</td></tr>";
                max_min += "<tr><td>Total Deals</td><td>&nbsp;</td><td style='text-align:center'>" + data1[0].totalDealstoday + "</td><td style='text-align:center'>" + data1[0].totalDealswtd + "</td><td style='text-align:center'>" + data1[0].totalDealsmtd + "</td><td style='text-align:center'>" + data1[0].totalDealsytd+ "</td><td style='text-align:center'>" + data1[0].totalDeals + "</td></tr>";
				max_min += "<tr><td>Total Sales</td><td>&nbsp;</td><td style='text-align:right'><a href='javascript:void(0);' rel='today' stationrel='"+ id +"' class='paymentFigureStation'>"+ currentCurrency +" " +data1[0].totalPaymenttoday + "</a></td><td style='text-align:right'><a href='javascript:void(0);' rel='week' stationrel='"+ id +"' class='paymentFigureStation'>"+ currentCurrency +" " + data1[0].totalPaymentwtd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' stationrel='"+ id +"' rel='month' class='paymentFigureStation'>"+ currentCurrency +" " + data1[0].totalPaymentmtd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' stationrel='"+ id +"' rel='year' class='paymentFigureStation'>"+ currentCurrency +" " + data1[0].totalPaymentytd + "</a></td><td style='text-align:center'><a href='javascript:void(0);' stationrel='"+ id +"' rel='since' class='paymentFigureStation'>"+ currentCurrency +" " + data1[0].totalSales + "</a></td></tr>";  
                max_min += "<tr><td>Average/Deal</td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'></td><td style='text-align:center'>"+ currentCurrency +" " + js_number_format(parseFloat(data1[0].totalSales)/parseFloat(data1[0].totalDeals),2,'.','') + "</td></tr>";
				max_min += "<tr><th  colspan=7 style='background-color: #A9A9A9; text-align:center;'>PERFORMANCE</th></tr>";
				max_min += "<tr><td colspan='4' style='background-color: #91CDDD; color: #FFF;text-align:center;'>Best Performer</td><td colspan='3' style='background-color: #000; color: #FFF;text-align:center;'>Worst Performer</td></tr>";
				max_min += "<tr><td>Product</td><td>" + data1[0].maxproddesc.substr(0, 20) + "</td><td>" + data1[0].prodmaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxprod + "</td><td>" + data1[0].minproddesc.substr(0, 20) + "</td><td>" + data1[0].prodminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minprod + "</td></tr>";
				max_min += "<tr><td>Brand</td><td>" + data1[0].maxbranddesc.substr(0, 20) + "</td><td>" + data1[0].brandmaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxbrand + "</td><td>" + data1[0].minbranddesc.substr(0, 20) + "</td><td>" + data1[0].brandminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minbrand + "</td></tr>";
				max_min += "<tr><td>Category</td><td>" + data1[0].maxcategorydesc.substr(0, 20) + "</td><td>" + data1[0].categorymaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxcategory + "</td><td>" + data1[0].mincategorydesc.substr(0, 20) + "</td><td>" + data1[0].categoryminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].mincategory + "</td></tr>";
				max_min += "<tr><td>SubCategory</td><td>" + data1[0].maxsubcategorydesc.substr(0, 20) + "</td><td>" + data1[0].subcategorymaxqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].maxsubcategory + "</td><td>" + data1[0].minsubcategorydesc.substr(0, 20) + "</td><td>" + data1[0].subcategoryminqty + "</td><td style='text-align:right'>"+ currentCurrency +" " + data1[0].minsubcategory + "</td></tr>";
                $('#each-month-max-min-table').html(max_min);
            },
            cache: false
        });
    }

    function getMerchantConsultantDetails(id)
    {
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        if (fromDate == '' || toDate == '')
        {
            alert("Please enter from date and to date");
            return;
        }
        localStorage.setItem("label", "merchant_consultant");
        localStorage.setItem("id", id);
        $.ajax({
            url:JS_BASE_URL+'/sales/getmerchantConsultantSalesData',
            type: 'POST',
            dataType: "json",
            data: {'merchant_id': id, 'from_date': fromDate, 'to_date': toDate},
            success: function (data) {
                chart.series[0].setData(data[0].data);
                html = '';

                var currentYear = '';
                var count = 1;
                var style = '';
                var max = '';
                var min = '';
                var currentMonth = 0;
                var c = 0;
                var yearCount = 0;

                $.each(data[0].view, function (index, value) {
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    if (max == '')
                    {
                        max = value.total_payment / 100;
                    } else
                    {
                        if (max < value.total_payment / 100)
                        {
                            max = value.total_payment / 100;
                        }
                    }

                    if (min == '')
                    {
                        min = value.total_payment / 100;
                    } else
                    {
                        if (min > value.total_payment / 100)
                        {
                            min = value.total_payment / 100;
                        }
                    }

                    d = new Date(value.consignment);
                    style = 'display:none';

                    if (currentYear != d.getFullYear())
                    {
                        if (count != 1)
                        {
                            if (currentMonth < 12)
                            {
                                for (c = ++currentMonth; currentMonth < 12; currentMonth++)
                                {
                                    html += "<tr class='year-sub-" + d1.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                }
                            }
                        }

                        html += "<tr class='year-main' data-year='" + d.getFullYear() + "'><th colspan='2'>Year - " + d.getFullYear() + "</th></tr>";
                        currentYear = d.getFullYear();
                        if (d.getMonth() > 0)
                        {
                            for (e = 0; e < d.getMonth(); e++)
                            {
                                html += "<tr class='year-sub-" + currentYear + "' style='" + style + "'><td>" + monthNames[e] + "</td><td style='text-align:center'> --- </td></tr>";
                            }
                        }
                    } else
                    {
                        yearCount++;
                        if (count != 1)
                        {
                            currentMonth++;
                            while (currentMonth != d.getMonth() && currentMonth != 13)
                            {
                                html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[currentMonth] + "</td><td style='text-align:center'> --- </td></tr>";
                                if (currentMonth > 12)
                                {
                                    currentMonth = 0;
                                } else
                                {
                                    currentMonth++;
                                }
                                console.log(currentMonth);
                                console.log(currentYear);
                                console.log(monthNames[currentMonth]);
                            }
                        }
                    }
                    d1 = d;
                    newDate = monthNames[d.getMonth()] + " - " + d.getFullYear();
                    count++;

                    currentMonth = d.getMonth();
                    html += "<tr class='year-sub-" + d.getFullYear() + "' style='" + style + "'><td>" + monthNames[d.getMonth()] + "</td><td style='text-align:right'>"+ currentCurrency +" " + value.total_payment / 100 + "</td></tr>";
                });
                $('#each-month-table').html(html);
                var max_min = "<tr><td>Max</td><td style='text-align:right'>"+ currentCurrency +" " + max + "</td></tr>";
                max_min += "<tr><td>Min</td><td style='text-align:right'>"+ currentCurrency +" " + min + "</td></tr>";
                max_min += "<tr><td>Average/Day</td><td style='text-align:right'>"+ currentCurrency +" " + data[0].averagePerDay + "</td></tr>";
                max_min += "<tr><td>Average/Deal</td><td style='text-align:right'>"+ currentCurrency +" " + data[0].averagePerDeal + "</td></tr>";
                $('#each-month-max-min-table').html(max_min);
            },
            cache: false
        });
    }
    $(document).on('click', '.year-main', function (res) {
        var year = $(this).attr('data-year');
        $('.year-sub-' + year).slideToggle();
    });
    $('#collapseThree').collapse();
    $('.second-level-sub-menu').slideDown();
});


$(document).ready(function () {
    var signal = 'red';
    var intervalId = 1;
    var currentElement;
    var url;
    $(document).on("click", ".role_status_button", function () {
		console.log("CLICK");
        currentElement = $(this);
        var doStatus = $(currentElement).attr('do_status');
        var role = $(currentElement).attr('role');

        if (role == 'merchant') {
            url = JS_BASE_URL + '/admin/master/approveMerchant';
        } else if (role == 'station') {
            url = JS_BASE_URL + '/admin/master/approveStation';
        } else if (role == 'humancap') {
            url = JS_BASE_URL + '/admin/master/approveHumanCap';
        } else if (role == 'sales_staff') {
            url = JS_BASE_URL + '/admin/master/approveSalesStaff';
        } else if (role == 'buyer') {
            url = JS_BASE_URL + '/admin/master/approveBuyer';
        } else if (role == 'employee') {
            url = JS_BASE_URL + '/admin/master/approveEmployee';
        } else if (role == 'product') {
            url = JS_BASE_URL + '/admin/master/approveProduct';
        } else if (role == 'oshop') {
            url = JS_BASE_URL + '/admin/master/approveOshop';
        } else if (role == 'companycampaign') {
            url = JS_BASE_URL + '/admin/master/approveCompanycampaign';
        }
		
        var role_id = $(currentElement).attr('current_role_id');
		//console.log(role_id);
        $('#current_role_roleId').val(role_id);
        $('#current_status').val(doStatus);
        $('#current_role_roleId').attr('remarks_role', role);
		$("#myModalRemarks").modal('toggle');
       // dialog.dialog("open");

    });
	
	var secsignal = 'red';
    var secintervalId = 1;
    var seccurrentElement;
    var securl;
    var secsection;
	$(document).on("click", ".secrole_status_button", function () {
		console.log("passss");
        currentElement = $(this);
        var doStatus = $(currentElement).attr('do_status');
        var role = $(currentElement).attr('role');
        var section = $(currentElement).attr('section');

        if (role == 'merchant') {
            url = JS_BASE_URL + '/admin/master/approveMerchantSection';
        } else if (role == 'station') {
            url = JS_BASE_URL + '/admin/master/approveStation';
        } else if (role == 'sales_staff') {
            url = JS_BASE_URL + '/admin/master/approveSalesStaff';
        } else if (role == 'buyer') {
            url = JS_BASE_URL + '/admin/master/approveBuyer';
        } else if (role == 'employee') {
            url = JS_BASE_URL + '/admin/master/approveEmployee';
        } else if (role == 'product') {
            url = JS_BASE_URL + '/admin/master/approveProductSection';
        } else if (role == 'oshop') {
            url = JS_BASE_URL + '/admin/master/approveOshop';
        } else if (role == 'companycampaign') {
            url = JS_BASE_URL + '/admin/master/approveCompanycampaign';
        }
		
        var role_id = $(currentElement).attr('current_role_id');
		//console.log(role_id);
        $('#current_secrole_roleId').val(role_id);
        $('#current_secstatus').val(doStatus);
        $('#current_section').val(section);
        $('#current_secrole_roleId').attr('remarks_role', role);
		$("#myModalSecRemarks").modal('toggle');
       // dialog.dialog("open");

    });	
	
	$(document).on("click", ".secrole_status_buttonb2b", function () {
		console.log("passssb2b");
        currentElement = $(this);
        var doStatus = $(currentElement).attr('do_status');
        var role = $(currentElement).attr('role');
        var section = $(currentElement).attr('section');

        if (role == 'merchant') {
            url = JS_BASE_URL + '/admin/master/approveMerchantSection';
        } else if (role == 'station') {
            url = JS_BASE_URL + '/admin/master/approveStation';
        } else if (role == 'sales_staff') {
            url = JS_BASE_URL + '/admin/master/approveSalesStaff';
        } else if (role == 'buyer') {
            url = JS_BASE_URL + '/admin/master/approveBuyer';
        } else if (role == 'employee') {
            url = JS_BASE_URL + '/admin/master/approveEmployee';
        } else if (role == 'product') {
            url = JS_BASE_URL + '/admin/master/approveProductSectionB2b';
        } else if (role == 'oshop') {
            url = JS_BASE_URL + '/admin/master/approveOshop';
        } else if (role == 'companycampaign') {
            url = JS_BASE_URL + '/admin/master/approveCompanycampaign';
        }
		
        var role_id = $(currentElement).attr('current_role_id');
		//console.log(role_id);
        $('#current_secrole_roleIdb2b').val(role_id);
        $('#current_secstatusb2b').val(doStatus);
        $('#current_sectionb2b').val(section);
        $('#current_secrole_roleIdb2b').attr('remarks_role', role);
		$("#myModalSecRemarksb2b").modal('toggle');
       // dialog.dialog("open");

    });		
	
    $('#save_secremarks').click(function () {
		//console.log("pass");
        if (!$.trim($('#status_secremarks').val())) {
            alert('Enter Remarks Please');
            return false;
        } else {
			console.log("pass2333");
            var roleId = $('#current_secrole_roleId').val();
            var dostatus = $('#current_secstatus').val();
            var section = $('#current_section').val();
            var role = $('#current_secrole_roleId').attr('remarks_role');
            var remarks = $('#status_secremarks').val();
            var url2;
            if (role == 'merchant') {
                url2 = JS_BASE_URL + '/admin/master/saveMerchantSecRemarks';
            } else if (role == 'product') {
                url2 = JS_BASE_URL + '/admin/master/saveProductSecRemarks';
            }
			console.log(url2);
            $.ajax({
                url: url2,
                type: 'POST',
                dataType: 'json',
				async: false,
                data: {id: roleId, section: section, remarks: remarks, role: role, status: dostatus},
                success: function (response) {
					console.log("pass2222");
                    $("#myModalSecRemarks").modal('toggle');
                    // $('#srconfirmModal').modal('')
				//	$('#overlay_spinner_'+roleId).show();
                    //signal = 'green';
                   // $('#mcrid_'+roleId).html(remarks);
                    $('#secremarks-form')[0].reset();
                }
            });
			console.log("URL: " + url);
            secStatus(roleId, section, dostatus, role, url, currentElement);

        }
    });	
	
    $('#save_secremarksb2b').click(function () {
		console.log("passfonal");
        if (!$.trim($('#status_secremarksb2b').val())) {
            alert('Enter Remarks Please');
            return false;
        } else {
            var roleId = $('#current_secrole_roleIdb2b').val();
            var dostatus = $('#current_secstatusb2b').val();
            var section = $('#current_sectionb2b').val();
            var role = $('#current_secrole_roleIdb2b').attr('remarks_role');
            var remarks = $('#status_secremarksb2b').val();
            var url2;
            if (role == 'merchant') {
                url2 = JS_BASE_URL + '/admin/master/saveMerchantSecRemarks';
            } else if (role == 'product') {
                url2 = JS_BASE_URL + '/admin/master/saveProductSecRemarks';
            }
			console.log(url2);
            $.ajax({
                url: url2,
                type: 'POST',
                dataType: 'json',
				async: false,
                data: {id: roleId, section: section, remarks: remarks, role: role, status: dostatus},
                success: function (response) {
					console.log("pass2222");
                    $("#myModalSecRemarksb2b").modal('toggle');
                    // $('#srconfirmModal').modal('')
				//	$('#overlay_spinner_'+roleId).show();
                    //signal = 'green';
                   // $('#mcrid_'+roleId).html(remarks);
                    $('#secremarks-formb2b')[0].reset();
                }
            });
			console.log("URL: " + url);
            secStatus(roleId, section, dostatus, role, url, currentElement);

        }
    });		
	
    function secStatus(role_id, section, doStatus, role, url, currentElement) {
        //dialog.dialog("open");
        //intervalId = setInterval(function () {
            //if (signal == 'green') {
                //clearInterval(intervalId);
                // if (role=="merchant" && doStatus=="suspended") {

                // }
				console.log("passss");
				$('#overlay_spinner_'+section+'_'+role_id).hide();
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {id: role_id, section: section,doStatus: doStatus, role: role},
                    success: function (response) {
						console.log(response);
                        if (response.success == 'TRUE') {
							toastr.info('Status Successfully Changed!');
                         //   var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
                           console.log(currentElement);
						   $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                                $(currentElement).parent('.action_buttons').html(response.view);
                             //   $(statusColumn).fadeOut('fast');
                                doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                    return letter.toUpperCase();
                                });
                             //  $(statusColumn).text(doStatus);
                             //   $(statusColumn).fadeIn(2000);
                                $('#overlay_spinner_'+section+'_'+role_id).hide();
                               // $('#alert_heading').text('Success! ');
                              //  $('#alert_text').text('Status Changed Successfully');
                              //  $('.removeable').removeClass('alert-danger');
                              //  $('.removeable').addClass('alert-success');
								
                            });
                            $(currentElement).parent('.action_buttons').fadeIn(2000);
                        } else if (response.success == 'False') {
                           // $('#alert_heading').text('Error!');
                          //  $('#alert_text').text('Unable to change stauts');
                            toastr.info('Unable to change stauts!');
                        }

                    }, complete: function () {
                        $('.removeable').show();
                        setTimeout(removeMessage, 5000);
                    }
                });
            //}
        //}, 500);
    }
	

    function approveStatus(role_id, doStatus, role, url, currentElement) {
        //dialog.dialog("open");
        //intervalId = setInterval(function () {
            //if (signal == 'green') {
                //clearInterval(intervalId);
                // if (role=="merchant" && doStatus=="suspended") {

                // }
				console.log(role_id);
				$('#overlay_spinner_'+role_id).hide();
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {id: role_id, doStatus: doStatus, role: role},
                    success: function (response) {
						console.log(response);
                        if (response.success == 'TRUE') {							
							$(".add_remark").attr('do_status',doStatus);
                            var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
                            $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                                $(currentElement).parent('.action_buttons').html(response.view);
                                $(statusColumn).fadeOut('fast');
                                doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                    return letter.toUpperCase();
                                });
                                $(statusColumn).text(doStatus);
                                $(statusColumn).fadeIn(2000);
                                $('#overlay_spinner_'+role_id).hide();
                                $('#alert_heading').text('Success! ');
                                $('#alert_text').text('Status Changed Successfully');
                                $('.removeable').removeClass('alert-danger');
                                $('.removeable').addClass('alert-success');
								$("#trstyle").css('background-color', 'white');
                            });
                            $(currentElement).parent('.action_buttons').fadeIn(2000);
                        } else if (response.success == 'False') {
                            $('#alert_heading').text('Error!');
                            $('#alert_text').text('Unable to change stauts');
                            $('.removeable').removeClass('alert-success');
                            $('.removeable').addClass('alert-danger');
                        }

                    }, complete: function () {
                        $('.removeable').show();
                        setTimeout(removeMessage, 5000);
                    }
                });
            //}
        //}, 500);
    }

    function suspendOrRejectStatus(role_id, doStatus, role, url, currentElement) {
        //dialog.dialog("open");
        //intervalId = setInterval(function () {
            console.log("pas2s");
            checkSignal(role_id, doStatus, role, url, currentElement)
        //}, 500);
    }

    function checkSignal(role_id, doStatus, role, url, currentElement) {
        //if (signal == 'green') {
            //clearInterval(id);
			$('#overlay_spinner_'+role_id).hide();
			console.log("Here");
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {id: role_id, doStatus: doStatus, role: role},
                error: function(response){
                    console.log(response);
                },
                success: function (response) {
					console.log("Here2");
                    if (response.success == 'TRUE') {
						console.log("Here3");
						$(".add_remark").attr('do_status',doStatus);
                        var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
                        var remarksColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#remarks_column').children('#remarks_text');
                        $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                            $(currentElement).parent('.action_buttons').html(response.view);
                            $(statusColumn).fadeOut('fast');
                            $(remarksColumn).fadeOut('fast');
                            doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                return letter.toUpperCase();
                            });
                            $(statusColumn).text(doStatus);
                            $(remarksColumn).text(response.roleData.remarks);
                            $(statusColumn).fadeIn(2000);
                            $(remarksColumn).fadeIn(2000);
                            $('#overlay_spinner_'+role_id).hide();
                            $('#alert_heading').text('Success!');
                            $('#alert_text').text('Status Changed Successfully');
                            $('.removeable').removeClass('alert-danger');
                            $('.removeable').addClass('alert-success');
                        });
                        $(currentElement).parent('.action_buttons').fadeIn(2000);
                    } else if (response.success == 'False') {
                        $('#alert_heading').text('Error!');
                        $('#alert_text').text('Unable to change status');
						$('#overlay_spinner_'+role_id).hide();
                        $('.removeable').removeClass('alert-success');
                        $('.removeable').addClass('alert-danger');
                    }

                }, complete: function () {
                    $('.removeable').show();
                    setTimeout(removeMessage, 5000);
                    //signal = 'red';
                }
            });
        //}
    }

    function removeMessage() {
        $('.removeable').hide();
    }

    $('#save_remarks').click(function () {
		console.log("pass");
        if (!$.trim($('#status_remarks').val())) {
            alert('Enter Remarks Please');
            return false;
        } else {
			console.log("pass2");
            var roleId = $('#current_role_roleId').val();
            var dostatus = $('#current_status').val();
            var role = $('#current_role_roleId').attr('remarks_role');
            var remarks = $('#status_remarks').val();
            var url2;
			$("#save_remarks").removeClass('send_email');
			console.log(role);
            if (role == 'merchant') {
                url2 = JS_BASE_URL + '/admin/master/saveMerchantRemarks';
            } else if (role == 'station') {
                url2 = JS_BASE_URL + '/admin/master/saveStationRemarks';
            } else if (role == 'humancap') {
                url2 = JS_BASE_URL + '/admin/master/saveHumanCapRemarks';
            }else if (role == 'sales_staff') {
                url2 = JS_BASE_URL + '/admin/master/saveSalesStaffRemarks';
            } else if (role == 'buyer') {
                url2 = JS_BASE_URL + '/admin/master/saveBuyerRemarks';
            } else if (role == 'employee') {
                url2 = JS_BASE_URL + '/admin/master/saveEmployeeRemarks';
            } else if (role == 'product') {
                url2 = JS_BASE_URL + '/admin/master/saveProductRemarks';
            } else if (role == 'oshop') {
                url2 = JS_BASE_URL + '/admin/master/saveOshopRemarks';
			} else if (role == 'companycampaign') {
				url2 = JS_BASE_URL + '/admin/master/saveCompanycampaignRemarks';
			}
			console.log("pass3");
            $.ajax({
                url: url2,
                type: 'POST',
                dataType: 'json',
				async: false,
                data: {id: roleId, remarks: remarks, role: role, status: dostatus},
                success: function (response) {
					//console.log("pass");
                    $("#myModalRemarks").modal('toggle');
                    // $('#srconfirmModal').modal('')
				//	$('#overlay_spinner_'+roleId).show();
                    //signal = 'green';
                    $('#mcrid_'+roleId).html(remarks);
                    $('#remarks-form')[0].reset();
                }
            });
			console.log("URL: " + url);
            if (dostatus == 'suspended' || dostatus == 'rejected') {
				console.log("There");
                suspendOrRejectStatus(roleId, dostatus, role, url, currentElement);
                
            } else if(dostatus == 'active'){
                approveStatus(roleId, dostatus, role, url, currentElement);
            }

        }
    });

    var dialog = $("#dialog-form").dialog({
        autoOpen: false,
        height: 400,
        width: 650,
        modal: true,
        close: function () {
            dialog.dialog("close");
            $('#remarks-form')[0].reset();
        }
    });

    $(document).on('click', '.ui-dialog-titlebar-close', function () {
        $('#overlay_spinner').hide();
        $('#remarks-form')[0].reset();
    });


});


                       

