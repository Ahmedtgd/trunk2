/**
 * Created by sadia on 9/16/2015.
 */
 var currentCurrency = "MYR";
 function formatDateJs(date) {

  var day = date.getDate();
  var pad = "00";
  var monthIndex = String(date.getMonth() + 1);
  var month = pad.substring(0, pad.length - monthIndex.length) + monthIndex;
  var year = date.getFullYear();
  var hours = String(date.getHours());
  var hoursd = pad.substring(0, pad.length - hours.length) + hours;
  var minutes = String(date.getMinutes());
  var minutesd = pad.substring(0, pad.length - minutes.length) + minutes;
  var secs = String(date.getSeconds());
  var secsd = pad.substring(0, pad.length - secs.length) + secs;

  return year + '-' + month +  '-' + day + ' ' + hoursd + ":" + minutesd +  ":" + secsd;
}


function js_number_format (number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : /*Math.abs(*/decimals/*)*/,
					sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
							dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
									s = '',
									toFixedFix = function (n, prec) {
								var k = Math.pow(10, prec);
								return '' + Math.round(n * k) / k;
							};
							// Fix for IE parseFloat(0.55).toFixed(0) = 0;
							s = (prec < 0 ? ('' + n) : (prec ? toFixedFix(n, prec) : '' + Math.round(n))).split('.');
							if (s[0].length > 3) {
								s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
							}
							if ((s[1] || '').length < prec) {
								s[1] = s[1] || '';
								s[1] += new Array(prec - s[1].length + 1).join('0');
							}
							return s.join(dec);
} 
 
function checka_b2b(pagnum){
	var page_count = $("#page_count_b2b").val();
	//console.log("TEST2");
	if(parseInt(page_count) > 5){
		//console.log("TEST");
		//console.log(pagnum);		
		//console.log(page_count);
		if(parseInt(page_count) == parseInt(pagnum)){
			$(".apage_b2b").hide();
			var pagprev = parseInt(pagnum) - 1;
			var pagprev2 = parseInt(pagnum) - 2;
			$("#apage" + pagnum).show();
			//$("#apage" + pagprev).show();
			//$("#apage" + pagprev2).show();
			for(var ww = pagprev - 2; ww <= parseInt(pagnum); ww++){
				$("#apage_b2b" + ww).show();
			}
			$(".ellipsis_b2b").hide();
			$(".last_ellipsis_b2b").show();
		}
		if(parseInt(pagnum) == 0){
			$(".apage_b2b").hide();
			var pagpnext = parseInt(pagnum) + 1;
			var pagnext2 = parseInt(pagnum) + 2;
			$("#apage_b2b" + pagnum).show();
			//$("#apage" + pagpnext).show();
			//$("#apage" + pagnext2).show();
			for(var ww = 0; ww <= 4; ww++){
				$("#apage_b2b" + ww).show();
			}
			$(".ellipsis_b2b").show();
			$(".last_ellipsis_b2b").hide();
		}		
		if((parseInt(pagnum) > 0) && (parseInt(page_count) > parseInt(pagnum)) && parseInt(page_count) != parseInt(pagnum)){
			$(".apage_b2b").hide();
			console.log(pagnum);
		//	var pagpnext = parseInt(pagnum) + 1;
			var pagprev = parseInt(pagnum) - 1;
			$("#apage_b2b" + pagnum).show();
			//$("#apage" + pagpnext).show();
			$("#apage_b2b" + pagprev).show();
			for(var ww = pagprev + 2; ww <= pagprev + 4; ww++){
				$("#apage_b2b" + ww).show();
			}
			if((parseInt(page_count) - 5) < parseInt(pagnum)){
				$(".ellipsis_b2b").hide();
				$(".last_ellipsis_b2b").show();	
			} else {
				$(".ellipsis_b2b").show();
				$(".last_ellipsis_b2b").hide();	
			}
		}
	}
	
	$('html, body').animate({ scrollTop: 400 }, 'fast');
}  
 
function checka(pagnum){
	var page_count = $("#page_count").val();
	console.log("TEST2");
	if(parseInt(page_count) > 5){
		//console.log("TEST");
		//console.log(pagnum);		
		//console.log(page_count);
		if(parseInt(page_count) == parseInt(pagnum)){
			$(".apage").hide();
			var pagprev = parseInt(pagnum) - 1;
			var pagprev2 = parseInt(pagnum) - 2;
			$("#apage" + pagnum).show();
			//$("#apage" + pagprev).show();
			//$("#apage" + pagprev2).show();
			for(var ww = pagprev - 2; ww <= parseInt(pagnum); ww++){
				$("#apage" + ww).show();
			}
			$(".ellipsis").hide();
			$(".last_ellipsis").show();
		}
		if(parseInt(pagnum) == 0){
			$(".apage").hide();
			var pagpnext = parseInt(pagnum) + 1;
			var pagnext2 = parseInt(pagnum) + 2;
			$("#apage" + pagnum).show();
			//$("#apage" + pagpnext).show();
			//$("#apage" + pagnext2).show();
			for(var ww = 0; ww <= 4; ww++){
				$("#apage" + ww).show();
			}
			$(".ellipsis").show();
			$(".last_ellipsis").hide();
		}		
		if((parseInt(pagnum) > 0) && (parseInt(page_count) > parseInt(pagnum)) && parseInt(page_count) != parseInt(pagnum)){
			$(".apage").hide();
			console.log(pagnum);
		//	var pagpnext = parseInt(pagnum) + 1;
			var pagprev = parseInt(pagnum) - 1;
			$("#apage" + pagnum).show();
			//$("#apage" + pagpnext).show();
			$("#apage" + pagprev).show();
			for(var ww = pagprev + 2; ww <= pagprev + 4; ww++){
				$("#apage" + ww).show();
			}
			if((parseInt(page_count) - 5) < parseInt(pagnum)){
				$(".ellipsis").hide();
				$(".last_ellipsis").show();	
			} else {
				$(".ellipsis").show();
				$(".last_ellipsis").hide();	
			}
		}
	}
	
	$('html, body').animate({ scrollTop: 400 }, 'fast');
} 
 
$ = jQuery;

$().ready(function () {
	$.ajax({
		url: JS_BASE_URL + '/getcurrentcurrency',
		type: 'GET',
		success: function (response) {
			console.log("CURR: " + response);
			currentCurrency = response;
			console.log(currentCurrency);
		}
	});		
	
	$(document).delegate( '.prev_page', "click",function (event) {
	//$('.prev_page').on('click',function(){
		var current = $("#current_page").val();
		if(parseInt(current) == 0){
			//
		} else {
			var pagnum = parseInt(current) - 1;
			$(".pages").hide();
			$(".apage").removeClass("selecteda");
			$("#page" + pagnum).show();
			$("#apage" + pagnum).addClass("selecteda");
			$("#current_page").val(pagnum);
			checka(pagnum);
		}		
	});		
	$(document).delegate( '.next_page', "click",function (event) {
	//$('.next_page').on('click',function(){
		var current = $("#current_page").val();
		var last = $("#page_count").val();
		if(parseInt(current) == parseInt( last )){
			//
		} else {
			var pagnum = parseInt(current) + 1;
			$(".pages").hide();
			$(".apage").removeClass("selecteda");
			$("#page" + pagnum).show();
			$("#apage" + pagnum).addClass("selecteda");
			$("#current_page").val(pagnum);
			checka(pagnum);
		}		
	});
	$(document).delegate( '.first_page', "click",function (event) {
//	$('.first_page').on('click',function(){
		$(".pages").hide();
		$(".apage").removeClass("selecteda");
		$("#page0").show();
		$("#apage0").addClass("selecteda");
		$("#current_page").val(0);
		checka(0);
	});
	$(document).delegate( '.last_page', "click",function (event) {
	//$('.last_page').on('click',function(){
		$(".pages").hide();
		$(".apage").removeClass("selecteda");
		var pagnum = $("#page_count").val();
		$("#page" + pagnum).show();
		$("#apage" + pagnum).addClass("selecteda");
		$("#current_page").val(pagnum);
		checka(pagnum);
	});
	$(document).delegate( '.apage', "click",function (event) {
	//$('.apage').on('click',function(){
		console.log("HI");
		$(".pages").hide();
		$(".apage").removeClass("selecteda");
		var pagnum = $(this).attr("rel");
		$("#page" + pagnum).show();
		$("#apage" + pagnum).addClass("selecteda");
		$("#current_page").val(pagnum);
		checka(pagnum);
	});	
	
	$(document).delegate( '.prev_page_b2b', "click",function (event) {
	//$('.prev_page').on('click',function(){
		var current = $("#current_page_b2b").val();
		if(parseInt(current) == 0){
			//
		} else {
			var pagnum = parseInt(current) - 1;
			$(".pages_b2b").hide();
			$(".apage_b2b").removeClass("selecteda");
			$("#page_b2b" + pagnum).show();
			$("#apage_b2b" + pagnum).addClass("selecteda");
			$("#current_page_b2b").val(pagnum);
			checka(pagnum);
		}		
	});		
	$(document).delegate( '.next_page_b2b', "click",function (event) {
	//$('.next_page').on('click',function(){
		var current = $("#current_page_b2b").val();
		var last = $("#page_count_b2b").val();
		if(parseInt(current) == parseInt( last )){
			//
		} else {
			var pagnum = parseInt(current) + 1;
			$(".pages_b2b").hide();
			$(".apage_b2b").removeClass("selecteda");
			$("#page_b2b" + pagnum).show();
			$("#apage_b2b" + pagnum).addClass("selecteda");
			$("#current_page_b2b").val(pagnum);
			checka(pagnum);
		}		
	});
	$(document).delegate( '.first_page_b2b', "click",function (event) {
//	$('.first_page').on('click',function(){
		$(".pages_b2b").hide();
		$(".apage_b2b").removeClass("selecteda");
		$("#page_b2b0").show();
		$("#apage_b2b0").addClass("selecteda");
		$("#current_page_b2b").val(0);
		checka(0);
	});
	$(document).delegate( '.last_page_b2b', "click",function (event) {
	//$('.last_page').on('click',function(){
		$(".pages_b2b").hide();
		$(".apage_b2b").removeClass("selecteda");
		var pagnum = $("#page_count_b2b").val();
		$("#page_b2b" + pagnum).show();
		$("#apage_b2b" + pagnum).addClass("selecteda");
		$("#current_page_b2b").val(pagnum);
		checka(pagnum);
	});
	$(document).delegate( '.apage_b2b', "click",function (event) {
	//$('.apage').on('click',function(){
		$(".pages_b2b").hide();
		$(".apage_b2b").removeClass("selecteda");
		var pagnum = $(this).attr("rel");
		$("#page_b2b" + pagnum).show();
		$("#apage_b2b" + pagnum).addClass("selecteda");
		$("#current_page_b2b").val(pagnum);
		checka_b2b(pagnum);
	});		
	
    var text_max = 255;
    var getcurrpath = window.location.pathname.split('/');
    var curr_page = getcurrpath[getcurrpath.length - 1];
    if (curr_page == 'profilesetting') {
        $('.select2-container').css('width', '100%');
        //userCustomTheme();
    }

    $('#textarea_feedback').html(text_max);

    $('#prod_del_time_to').blur(function () {
		var prod_del_time = $("#prod_del_time").val();
		var int_del_time = 0;
		if(prod_del_time != ""){
			int_del_time = parseInt(prod_del_time);
		}
		var prod_del_time_to = $("#prod_del_time_to").val();
		var int_del_time_to = 0;
		if(prod_del_time_to != ""){
			int_del_time_to = parseInt(prod_del_time_to);
			if(int_del_time_to <= int_del_time){
				toastr.warning('Invalid value!');
				$("#prod_del_time_to").val("");
			}
		} else {
			toastr.warning('This field is required!');
		}
	});
	
    $('#prod_del_time_tob2b').blur(function () {
		var prod_del_time = $("#prod_del_timeb2b").val();
		var int_del_time = 0;
		if(prod_del_time != ""){
			int_del_time = parseInt(prod_del_time);
		}
		var prod_del_time_to = $("#prod_del_time_tob2b").val();
		var int_del_time_to = 0;
		if(prod_del_time_to != ""){
			int_del_time_to = parseInt(prod_del_time_to);
			if(int_del_time_to <= int_del_time){
				toastr.warning('Invalid value!');
				$("#prod_del_time_tob2b").val("");
			}
		} else {
			toastr.warning('This field is required!');
		}
	});	
	
    $('#textarea').keyup(function () {
        var text_length = $('#textarea').val().length;
        var text_remaining = text_max - text_length;

        $('#textarea_feedback').html(text_remaining);
    });
    /*
     section created by khakan ali on 11/22/2015
     */
    $('#wareplusbtn').on('click', function () {
        var curr_val = parseInt($('#moq').val());
        curr_val = curr_val + 1;
        $('#moq').val(curr_val);
    });


    $('#wareminusbtn').on('click', function (e) {
        var curr_val = parseInt($('#moq').val());
        if (curr_val > 0) {
            curr_val = curr_val - 1;
            $('#moq').val(curr_val);
        } else {
            e.preventDefault();
        }
    });

    $('#Category_id_p').on('change', function () {
        $(this).removeClass('error');
        $(this).siblings('label.error').remove();
        var val = $(this).val();
		console.log(val);
        if (val != "") {
            var text = $('#Category_id_p option:selected').text();
            $('.category_p').html(text);
            $('.category_hp').html(text);
            $('.category_p').text(text);
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/subcategory',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('#subcat').html(responseData);
                    $('#Category_id_p-error').remove();
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    });


    $('#Category_id_b2b').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/subcategory',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    $('#subcat_b2b').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    });

    $('#country_id').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/state',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#states').html(responseData);
                    }
                    else {
                        $('#cities').empty();
                        $('#states').empty();
                        $('#select2-states-container').empty();
                        $('#select2-cities-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#cities').html('<option value="" selected>Choose Option</option>');
            $('#states').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#states').on('change', function () {
        $(this).removeClass('error');
        $(this).siblings('label.error').remove();
        var val = $(this).val();
        if (val != "") {
            var text = $('#states option:selected').text();
            $('#states_p').html(text);
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/city',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
						//console.log(responseData);
                        $('#cities').html(responseData);
						document.getElementById('cities').disabled = false;
                    }
                    else {
                        $('#cities').empty();
                        $('#select2-cities-container').empty();
						document.getElementById('cities').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-cities-container').empty();
            $('#cities').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#cities').on('change', function () {
        $(this).removeClass('error');
        $(this).siblings('label.error').remove();
        var val = $(this).val();
        if (val != "") {
            var text = $('#cities option:selected').text();
            $('#cities_p').html(text);
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/area',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#areas').html(responseData);
						document.getElementById('areas').disabled = false;
                    }
                    else {
                        $('#areas').empty();
                        $('#select2-areas-container').empty();
						document.getElementById('areas').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-areas-container').empty();
            $('#areas').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#areas').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#areas option:selected').text();
            $('#areas_p').html(text);
        }
    });

    $('#statesb2b').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#statesb2b option:selected').text();
            $(this).siblings('span.select2').removeClass('errorBorder');
            $(this).siblings('label.errorT').remove();
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/city',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#citiesb2b').html(responseData);
                    }
                    else {
                        $('#citiesb2b').empty();
                        $('#select2-citiesb2b-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-citiesb2b-container').empty();
            $('#citiesb2b').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#citiesb2b').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#citiesb2b option:selected').text();
            $(this).siblings('span.select2').removeClass('errorBorder');
            $(this).siblings('label.errorT').remove();
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/area',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#areasb2b').html(responseData);
                    }
                    else {
                        $('#areasb2b').empty();
                        $('#select2-areasb2b-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-areasb2b-container').empty();
            $('#areasb2b').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#checkboxDq').on('change', function () {
            var boo = $(this).is(":checked");
            if(boo){
                $("#sd_checkboxDq").prop('checked', true);
                $("#checkboxDqn").prop('disabled', false);
                $("#sd_checkboxDqn").prop('disabled', false);
                $("#checkboxD").prop('disabled', true);
                $("#sd_checkboxD").prop('disabled', true);
            } else {
				$("#sd_checkboxDq").prop('checked', false);
                $("#checkboxDqn").prop('disabled', true);
                $("#sd_checkboxDqn").prop('disabled', true);
				$("#checkboxD").prop('disabled', false);
				$("#sd_checkboxD").prop('disabled', false);
                $("#checkboxDqn").val('');
                $("#sd_checkboxDqn").val('');
            }
    });

    $('#sd_checkboxDq').on('change', function () {
        var boo = $(this).is(":checked");
		
        if(boo){
			$("#checkboxDq").prop('checked', true);
            $("#checkboxDqn").prop('disabled', false);
            $("#sd_checkboxDqn").prop('disabled', false);
            $("#sd_checkboxD").prop('disabled', true);
            $("#checkboxD").prop('disabled', true);
        } else {
			console.log(boo);
			$("#checkboxDq").prop('checked', false);
            $("#sd_checkboxDqn").prop('disabled', true);
            $("#checkboxDqn").prop('disabled', true);
            $("#sd_checkboxD").prop('disabled', false);
            $("#checkboxD").prop('disabled', false);
            $("#sd_checkboxDqn").val('');
            $("#checkboxDqn").val('');
        }
    });
	
	$('#sd_checkboxDq_b2b').on('change', function () {
        var boo = $(this).is(":checked");
        if(boo){
            $("#sd_checkboxDqn_b2b").prop('disabled', false);
            $("#sd_checkboxD_b2b").prop('disabled', true);
        } else {
            $("#sd_checkboxDqn_b2b").prop('disabled', true);
            $("#sd_checkboxD_b2b").prop('disabled', false);
            $("#sd_checkboxDqn_b2b").val('');
        }
    });
	
	$('#sd_checkboxDq_hyper').on('change', function () {
        var boo = $(this).is(":checked");
        if(boo){
            $("#sd_checkboxDqn_hyper").prop('disabled', false);
            $("#sd_checkboxD_hyper").prop('disabled', true);
        } else {
            $("#sd_checkboxDqn_hyper").prop('disabled', true);
            $("#sd_checkboxD_hyper").prop('disabled', false);
            $("#sd_checkboxDqn_hyper").val('');
        }
    });

    $('#checkboxDqb2b').on('change', function () {
        var boo = $(this).is(":checked");
		
        if(boo){
			$("#checkboxDqb2b").prop('checked', true);
            $("#checkboxDqnb2b").prop('disabled', false);
            $("#sd_checkboxDqn_b2b").prop('disabled', false);
            $("#sd_checkboxD_b2b").prop('disabled', true);
            $("#checkboxDb2b").prop('disabled', true);
        } else {
			console.log(boo);
			$("#checkboxDqb2b").prop('checked', false);
            $("#sd_checkboxDqn_b2b").prop('disabled', true);
            $("#checkboxDqnb2b").prop('disabled', true);
            $("#sd_checkboxD_b2b").prop('disabled', false);
            $("#checkboxDb2b").prop('disabled', false);
            $("#sd_checkboxDqn_b2b").val('');
            $("#checkboxDqnb2b").val('');
        }
    });

    $('#Bcountry_id').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/state',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#Bstates').html(responseData);
                    }
                    else {
                        $('#Bcities').empty();
                        $('#Bstates').empty();
                        $('select2-Bstates-container').empty();
                        $('#select2-Bcities-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#Bcities').html('<option value="" selected>Choose Option</option>');
            $('#Bstates').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#Bstates').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/city',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#Bcities').html(responseData);
                    }
                    else {
                        $('#Bcities').empty();
                        $('#select2-Bcities-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-cities-container').empty();
            $('#cities').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#Bcountry_id_b2b').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/state',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#Bstates_b2b').html(responseData);
                    }
                    else {
                        $('#Bcities_b2b').empty();
                        $('#Bstates_b2b').empty();
                        $('select2-Bstates-b2b-container').empty();
                        $('#select2-Bcities-b2b-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#Bcities').html('<option value="" selected>Choose Option</option>');
            $('#Bstates').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#station_country_id').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/state',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#station_states').html(responseData);
                    }
                    else {
                        $('#station_cities').empty();
                        $('#station_states').empty();
                        $('#select2-station_states-container').empty();
                        $('#select2-station_cities-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#station_cities').html('<option value="" selected>Choose Option</option>');
            $('#station_states').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#station_states').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/city',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#station_cities').html(responseData);
                    }
                    else {
                        $('#station_cities').empty();
                        $('#select2-station_cities-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-station_cities-container').empty();
            $('#station_cities').html('<option value="" selected>Choose Option</option>');
        }
    });

    // $('#send').on('click', function (e) {
    //     var total = $('.validator').length;
    //     var counter = 0;
    //     var total1 = $('.validator1').length;
    //     var productid = $('#myproduct_id').val();
    //     var counter1 = 0;
    //     var hasimage = true;
    //     var hascheckbox = true;
    //     if ($('#uploadBtn').val() == "" && parseInt(productid) == 0) {
    //         hasimage = false;
    //     }
    //     else {
    //         hasimage = true;
    //     }
    //     if ($('#checkboxD').is(':checked')) {
    //         //ok every thing
    //     } else {
    //         $('.validator1').each(function () {
    //             if ($(this).val() == "") {
    //                 $(this).addClass('fields_error');
    //                 $('html, body').animate({
    //                     scrollTop: $(this).offset().top
    //                 }, 1000);
    //                 return false;
    //             } else {
    //                 counter1 = counter1 + 1;
    //             }
    //         });
    //         if (total1 != counter1) {
    //             hascheckbox = false;
    //         } else {
    //             hascheckbox = true;
    //         }
    //     }
    //     $('.validator').each(function () {
    //         if ($(this).val() == "") {
    //             $(this).addClass('fields_error');
    //             $('html, body').animate({
    //                 scrollTop: $(this).offset().top
    //             }, 1000);
    //             return false;
    //         } else {
    //             counter = counter + 1;
    //         }
    //     });
    //     if (total == counter && hasimage && hascheckbox) {
    //         //allow form to saved
    //     } else {
    //         if (!hasimage) {
    //             alert('select a valid image');
    //         } else {
    //             alert('There are some errors');
    //         }
    //         e.preventDefault();
    //     }
    // });


    $('#addwholesaledealer').on('click', function () {
        $.ajax({
            type: "get",
            url: JS_BASE_URL + '/newdealer',
            cache: false,
            success: function (responseData, textStatus, jqXHR) {
                $("#wsreseller").append(responseData);
            },
            error: function (responseData, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
    //voucher
    $('.whole').click(function () {
        $('.whole').each(function () {
            $(this).prop('checked', false);
            // $(this).next('label').toggle('click');
        });
        $(this).prop('checked', true);
    });

    $('.wholeweek').click(function () {
        $('.wholeweek').each(function () {
            $(this).prop('checked', false);
            // $(this).next('label').toggle('click');
        });
        $(this).prop('checked', true);
    });

    $('#sendv').on('click', function (e) {
        var total = $('.validator').length;
        var counter = 0;
        var totalWhole = $('.whole').length;
        var counterWhole = 0;

        var totalWholeweek = $('.wholeweek').length;
        var counterWholeweek = 0;

        //check any whole checkbox is checked?
        $('.whole').each(function () {
            if ($(this).is(':checked')) {
                counterWhole = counterWhole + 1;
            }
        });
        $('.wholeweek').each(function () {
            if ($(this).is(':checked')) {
                counterWholeweek = counterWholeweek + 1;
            }
        });
        if (counterWhole < 1) {
            $('.whole').next('label').addClass('fields_error');
        }
        if (counterWholeweek < 1) {
            $('.wholeweek').next('label').addClass('fields_error');
        }
        $('.validator').each(function () {
            if ($(this).val() == "") {
                $(this).addClass('fields_error');
            } else {
                counter = counter + 1;
            }
        });
        if (total == counter && hasimage && totalWhole == counterWhole && totalWholeweek == counterWholeweek) {
            //allow form to saved
        } else {
            if (!hasimage) {
                alert('select a valid image');
            } else {
                alert('There are some errors');
            }
            e.preventDefault();
        }
    });
    /*
     Register new merchant validation
     */
  /*  $('#reg_merchant').on('click', function (e) {
        var total = $('.validator').length;
        var counter = 0;
        $('.validator').each(function () {
            if ($(this).val() == "") {
                $(this).addClass('fields_error');
                $('html, body').animate({
                    scrollTop: $(this).offset().top
                }, 1000);
                return false;
            } else {
                counter = counter + 1;
            }
        });
        if (total == counter) {
            if ($('#pass').val() != $('#compass').val()) {
                $('#pass').addClass('fields_error');
                $('html, body').animate({
                    scrollTop: $('#pass').offset().top
                }, 1000);
                e.preventDefault();
                return false;
            }
            //allow form to saved
        } else {
            e.preventDefault();
        }
    });*/

    /* Validation */
    $('#loginForm, #loginForm2, #forgotForm').bootstrapValidator();

    $('#registerForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
            country: {
                validators: {
                    notEmpty: {
                        message: 'The country is required and can\'t be empty'
                    }
                }
            },
            contact: {
                validators: {
                    digits: {
                        message: 'The value can contain only digits'
                    }
                }
            },
            office: {
                validators: {
                    digits: {
                        message: 'The value can contain only digits'
                    }
                }
            },
            mobile: {
                validators: {
                    digits: {
                        message: 'The value can contain only digits'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
        }
    });

    //select2
   $('select:not(.no_select2)').select2();
   $('select:not(.noselect2)').select2();

    /* color picker */
    $("input[id^='colorPicker']").focusin(function () {
        if ($("#colorPicker").length > 0)
        {
            var clrpickrID = $(this).attr("id").substring($(this).attr("id").indexOf('colorPicker') + 11);
            $('#colorPicker' + clrpickrID).ColorPicker({
                color: $(this).val(),
                    onSubmit: function (hsb, hex, rgb, el) {
                    $(el).val(hex);
                    $(el).ColorPickerHide();
                },
                onChange: function (hsb, hex, rgb) {
                    $('#colorPicker' + clrpickrID).val('#' + hex);
                    $('#colorPicker' + clrpickrID).css('background', '#' + hex);
                    $('#colorPicker' + clrpickrID).css('color', '#eee');

                },
                onBeforeShow: function () {
                    $(this).ColorPickerSetColor(this.value);
                }
            })
                .bind('keyup', function () {
                    $(this).ColorPickerSetColor(this.value);
                });
        }
    });

    if (($(window).height() + 100) < $(document).height()) {
        $('#top-link-block').removeClass('hidden').affix({
            // how far to scroll down before link "slides" into view
            offset: {top: 100}
        });
    }
    // Bootstrap ScrollPSY
    $('body').scrollspy({
        target: '.static-tab',
        offset: 395
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.static-tab').fadeIn();
        } else {
            $('.static-tab').fadeOut();
        }
    });
    // simple smooth scrolling for bootstrap scroll spy nav
    $(".static-tab li a[href^='#']").on('click', function (e) {
        // prevent default anchor click behavior
        e.preventDefault();
        // store hash
        var hash = this.hash;
        // animate
        $('html, body').animate({
            scrollTop: $(this.hash).offset().top
        }, 1000, function () {
            // when done, add hash to url
            // (default click behaviour)
            window.location.hash = hash;
        });

    });
    /* date picker */
    $('#datetimepicker, #datetimepickerr').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    /* time picker */
    $('#timepicker, #timepickerr').timepicki();

	function componentToHex(c) {
		var hex = c.toString(16);
		return hex.length == 1 ? "0" + hex : hex;
	}		
	
	function rgbToHex(r, g, b) {
		 return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
	}	

    $('#next_retail').click(function (e) {
		var productid = $('#myproduct_id').val();
		var canown = $('#canown').val();
		//console.log("inproductreg");
		var del_option = $('input[name="del_option"]:checked').val();

		console.log(del_option);
		productnamevalid=$("#productnamevalid").val();
		if (productnamevalid=="false") {
            $(".album_product_name_validation").addClass('errorBorder');
           /* $(this).siblings('label.errorT').remove();*/
            $(".album_product_name_validation").after("<label class='errorT error'>Product name is already in use.</label>");
            valid=0;
        } else {
            $(this).removeClass('errorBorder');
            $(this).siblings('label.errorT').remove();
            	if(parseInt(canown) == 0 && del_option == 'own'){
				toastr.warning("In order to use own delivery you need to create new Logistic Provider Account!");
			} else {
			if(parseInt(productid) == 0){
				var hasimage = true;
				if ($('#uploadBtn').val() == "" && parseInt(productid) == 0) {
					hasimage = false;
				}
				else {
					hasimage = true;
				}
				$('#productRegForm').validate(function(){
	                ignore : []
	            });
				if ($('#productRegForm').valid() && hasimage) {
					$("#next_retail_spinner").show().delay(1000).hide();
					var fdata = new FormData($("#productRegForm")[0]);
					var $free_delivery_with_purchase_amt=$('.delivery_waiver_min_amt').val();
					fdata.append("free_delivery_with_purchase_amt",$free_delivery_with_purchase_amt);
					// alert($free_delivery_with_purchase_amt);
					var merchant_policy = $("#info-merchantpolicy").val();
					var userid = $("#useridsell").val();
					console.log(userid);
					fdata.append("merchant_policy", merchant_policy);
					fdata.append("userid", userid);
				//	console.log(merchant_policy);
					var colorsrgb = new Array();
					var colorshex = new Array();
					var numn = 0;
					var repeat = false;
					for(var jj = 1; jj <= parseInt($("#colors_id").val()); jj++){
						var css = $("[data-target=unique-name-" + jj + "]").attr('style');
						if(css != null){
							var norgb = css.split("rgb");
							var nopar = norgb[1].split("(");
							var commas = nopar[1].split(",");
							var last = commas[2].split(")");
							if(colorsrgb.indexOf(css) == -1){
								colorsrgb[numn] = css;
								colorshex[numn] = rgbToHex(parseInt(commas[0].replace(/ /g,'')),parseInt(commas[1].replace(/ /g,'')),parseInt(last[0].replace(/ /g,'')));
								numn++;
							} else {
								repeat = true;
							}						
							
						}				
					}
					if(!repeat){
						fdata.append("colorsrgb", JSON.stringify(colorsrgb));
						fdata.append("colorshex", JSON.stringify(colorshex));	
						$("#totalBar").show();
						var elem = document.getElementById("myBar");
						elem.style.width = "10" + '%'; 
						elem.innerHTML = 10 + '%';
						$("#next_retail").html("Saving...");
				//		console.log(fdata.get('product_details'));
					$.ajax({
							xhr: function () {
								var xhr = new window.XMLHttpRequest();
								xhr.upload.addEventListener("progress", function (evt) {
									console.log("Loaded: " + evt.loaded);
									console.log("Total: " + evt.total);
									if (evt.lengthComputable) {
										var percentComplete = evt.loaded / evt.total;
										//console.log("P " + percentComplete);
										var width = Math.round(percentComplete * 100 * 0.8);
										elem.style.width = width + '%'; 
										elem.innerHTML = width * 1  + '%';
									/*	$('.progress').css({
											width: percentComplete * 100 + '%'
										});
										if (percentComplete === 1) {
											$('.progress').addClass('hide');
										}*/
									}
								}, false);
								xhr.addEventListener("progress", function (evt) {
									console.log("LoadedQ: " + evt.loaded);
									console.log("TotalQ: " + evt.total);
									if (evt.lengthComputable) {
										var percentComplete = evt.loaded / evt.total;
										//console.log("Q " + percentComplete);
										var width = 80 + (Math.round(percentComplete * 100 * 0.18));
										elem.style.width = width + '%'; 
										elem.innerHTML = width * 1  + '%';
										/*$('.progress').css({
											width: percentComplete * 100 + '%'
										});*/
									}
								}, false);
								return xhr;
							},

						  url: JS_BASE_URL + '/store_retail/'+user_id,
						  data: fdata,
						  dataType:'json',
						//  async:false,
						  type:'post',
						  processData: false,
						  contentType: false,
						  success:function(response){
							if(response.status == 'success'){
								toastr.info("The '" + fdata.get('name') + "' is added to product list");
								console.log(response);
								var pid = response.pid;
								$("#myproduct_id").val(pid);
								$("#parent_idh").val(pid);
							} else {
								toastr.warning(response.long_message);
							} 
							elem.style.width = 100 + '%'; 
							elem.innerHTML = 100  + '%';
							$("#totalBar").hide("slow", function() {

							  });
							$("#next_retail").html("Save");

						  },
						  error:function( jqXHR, textStatus, errorThrown ){
							 // bar.animate(0.0);
							 $("#next_retail").html("Save");
							 elem.style.width = 0 + '%'; 
							 elem.innerHTML = 0  + '%';
							  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
						  }/*,
							progress: function(e) {
								if(e.lengthComputable) {
									var pct = (e.loaded / e.total) * 100;

									$('#progresscontain')
										.progressbar('option', 'value', pct)
										.children('.ui-progressbar-value')
										.html(pct.toPrecision(3) + '%')
										.css('display', 'block');
								} else {
									console.warn('Content Length not reported!');
								}
							}*/
						});
					} else {
						toastr.error("Colors cannot repeat");
					}

				} else {
					if (!hasimage) {
						$('#thumbnail').addClass('errorDoubleBorder');
					} else {
						$('#thumbnail').removeClass('errorDoubleBorder');
					}
					e.preventDefault();
				}
			} else {
				$("#next_retail_spinner").show();
				var fdata = new FormData($("#productRegForm")[0]);
				var userid = $("#useridsell").val();
				fdata.append("merchant_policy", merchant_policy);
				var $free_delivery_with_purchase_amt=$('.delivery_waiver_min_amt').val();
				fdata.append("free_delivery_with_purchase_amt",$free_delivery_with_purchase_amt);
				fdata.append("userid", userid);
				var colorsrgb = new Array();
				var colorshex = new Array();
				var numn = 0;
				var repeat = false;
				for(var jj = 1; jj <= parseInt($("#colors_id").val()); jj++){
					var css = $("[data-target=unique-name-" + jj + "]").attr('style');
					if(css != null){
						var norgb = css.split("rgb");
						var nopar = norgb[1].split("(");
						var commas = nopar[1].split(",");
						var last = commas[2].split(")");
						if(colorsrgb.indexOf(css) == -1){
							colorsrgb[numn] = css;
							colorshex[numn] = rgbToHex(parseInt(commas[0].replace(/ /g,'')),parseInt(commas[1].replace(/ /g,'')),parseInt(last[0].replace(/ /g,'')));
							numn++;
						} else {
							repeat = true;
						}						
						
					}				
				}
				if(!repeat){
					fdata.append("colorsrgb", JSON.stringify(colorsrgb));
					fdata.append("colorshex", JSON.stringify(colorshex));	
					$("#next_retail").html("Saving...");		
					$("#totalBar").show();
					var elem = document.getElementById("myBar");
					elem.style.width = "10" + '%'; 
					elem.innerHTML = 10 + '%';	
					$.ajax({
					xhr: function () {
						var xhr = new window.XMLHttpRequest();
						xhr.upload.addEventListener("progress", function (evt) {
							console.log("Loaded: " + evt.loaded);
							console.log("Total: " + evt.total);
							if (evt.lengthComputable) {
								var percentComplete = evt.loaded / evt.total;
								//console.log("P " + percentComplete);
								var width = Math.round(percentComplete * 100 * 0.8);
								elem.style.width = width + '%'; 
								elem.innerHTML = width * 1  + '%';
							/*	$('.progress').css({
									width: percentComplete * 100 + '%'
								});
								if (percentComplete === 1) {
									$('.progress').addClass('hide');
								}*/
							}
						}, false);
						xhr.addEventListener("progress", function (evt) {
							console.log("LoadedQ: " + evt.loaded);
							console.log("TotalQ: " + evt.total);
							if (evt.lengthComputable) {
								var percentComplete = evt.loaded / evt.total;
								//console.log("Q " + percentComplete);
								var width = 80 + (Math.round(percentComplete * 100 * 0.18));
								elem.style.width = width + '%'; 
								elem.innerHTML = width * 1  + '%';
								/*$('.progress').css({
									width: percentComplete * 100 + '%'
								});*/
							}
						}, false);
						return xhr;
					},						
					  url: JS_BASE_URL + '/store_retailedit/'+user_id,
					  data:fdata,
					  dataType:'json',
					 // async:false,
					  type:'post',
					  processData: false,
					  contentType: false,
					  success:function(response){
						if(response.status == 'success'){
							toastr.info("The '" + fdata.get('name') + "' product edited!");
						} else {
							toastr.warning("Please register as a logistic provider to initiate own delivery");
						}
						
						//var pid = response;
						//$("#myproduct_id").val(pid);
						elem.style.width = 100 + '%'; 
						elem.innerHTML = 100  + '%';
						$("#totalBar").hide("slow", function() {

						  });
						$("#next_retail").html("Save");
					  },
					  error:function( jqXHR, textStatus, errorThrown ){
						  $("#next_retail").html("Save");
						  $("#next_retail_spinner").hide();
						  elem.style.width = 0 + '%'; 
						  elem.innerHTML = 0  + '%';
						  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
					  }
					});
				} else {
					toastr.error("Colors cannot repeat");
				}
			}
        }
		
		
		}
    });

    $('#next_retail_product').click(function () {
		var productid = $('#myproduct_id').val();
		var canown = $('#canown').val();
		var del_option = $('input[name="del_option"]:checked').val();
		console.log(del_option);
		if(parseInt(canown) == 0 && del_option == 'own'){
			toastr.warning("In order to use own delivery you need to create new Logistic Provider Account!");
		} else {
		if(parseInt(productid) == 0){
			var hasimage = true;
			if ($('#uploadBtn').val() == "" && parseInt(productid) == 0) {
				hasimage = false;
			}
			else {
				hasimage = true;
			}
			$('#productRegForm').validate(function(){
                ignore : []
            });
			if ($('#productRegForm').valid() && hasimage) {
				$("#next_retail_spinner").show();
				var fdata = new FormData($("#productRegForm")[0]);
				var merchant_policy = $("#info-merchantpolicy").val();
				var userid = $("#useridsell").val();
				fdata.append("merchant_policy", merchant_policy);
				fdata.append("userid", userid);
				var colorsrgb = new Array();
				var colorshex = new Array();
				var numn = 0;
				var repeat = false;
				for(var jj = 1; jj <= parseInt($("#colors_id").val()); jj++){
					var css = $("[data-target=unique-name-" + jj + "]").attr('style');
					if(css != null){
						var norgb = css.split("rgb");
						var nopar = norgb[1].split("(");
						var commas = nopar[1].split(",");
						var last = commas[2].split(")");
						if(colorsrgb.indexOf(css) == -1){
							colorsrgb[numn] = css;
							colorshex[numn] = rgbToHex(parseInt(commas[0].replace(/ /g,'')),parseInt(commas[1].replace(/ /g,'')),parseInt(last[0].replace(/ /g,'')));
							numn++;
						} else {
							repeat = true;
						}						
						
					}				
				}
				if(!repeat){
					fdata.append("colorsrgb", JSON.stringify(colorsrgb));
					fdata.append("colorshex", JSON.stringify(colorshex));				
				//	console.log(merchant_policy);
					$.ajax({
					  url: JS_BASE_URL + '/store_retail',
					  data: fdata,
					  dataType:'json',
					  async:false,
					  type:'post',
					  processData: false,
					  contentType: false,
					  success:function(response){
						toastr.info("The '" + fdata.get('name') + "' is added to product list");
						$("#next_retail_spinner").hide();
						var pid = response;
						$("#myproduct_id").val(pid);
						$("#parent_idh").val(pid);
						$('.nav-tabs a[href="#content-b2b"]').tab('show');
						$('html, body').animate({ scrollTop: 400 }, 'fast');
					  },
					  error:function( jqXHR, textStatus, errorThrown ){
						  $("#next_retail_spinner").hide();
						  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
					  }
					});
				} else {
					toastr.error("Colors cannot repeat");
				}

			} else {
				if (!hasimage) {
					$('#thumbnail').addClass('errorDoubleBorder');
				} else {
					$('#thumbnail').removeClass('errorDoubleBorder');
				}
				e.preventDefault();
			}
		} else {
			$("#next_retail_spinner").show();
			var fdata = new FormData($("#productRegForm")[0]);
			var merchant_policy = $("#info-merchantpolicy").val();
			var userid = $("#useridsell").val();
			fdata.append("merchant_policy", merchant_policy);
			fdata.append("userid", userid);
			var colorsrgb = new Array();
			var colorshex = new Array();
			var numn = 0;
			var repeat = false;
			for(var jj = 1; jj <= parseInt($("#colors_id").val()); jj++){
				var css = $("[data-target=unique-name-" + jj + "]").attr('style');
				if(css != null){
					var norgb = css.split("rgb");
					var nopar = norgb[1].split("(");
					var commas = nopar[1].split(",");
					var last = commas[2].split(")");
					if(colorsrgb.indexOf(css) == -1){
						colorsrgb[numn] = css;
						colorshex[numn] = rgbToHex(parseInt(commas[0].replace(/ /g,'')),parseInt(commas[1].replace(/ /g,'')),parseInt(last[0].replace(/ /g,'')));
						numn++;
					} else {
						repeat = true;
					}						
					
				}				
			}
			if(!repeat){
				fdata.append("colorsrgb", JSON.stringify(colorsrgb));
				fdata.append("colorshex", JSON.stringify(colorshex));			
			//	fdata.append("merchant_policy", merchant_policy);			
				$.ajax({
				  url: JS_BASE_URL + '/store_retailedit',
				  data:fdata,
				  dataType:'json',
				  async:false,
				  type:'post',
				  processData: false,
				  contentType: false,
				  success:function(response){
					$("#next_retail_spinner").hide();
					var pid = response;
					$("#myproduct_id").val(pid);
					// $("#name_v").val("");
					// $("#preview-img").attr("src", "#");
					$('.nav-tabs a[href="#content-retail"]').tab('show');
					$('html, body').animate({ scrollTop: 400 }, 'fast');
				  },
				  error:function(jqXHR, textStatus, errorThrown ){
					  $("#next_retail_spinner").hide();
					  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
				  }
				});
			} else {
				toastr.error("Colors cannot repeat");
			}
		}
		}
    });

    $('.valid_text').on('keyup', function(){
        $(this).removeClass('errorBorder');
        $(this).siblings('label.errorT').remove();
    })

    $('.valid_text').on('blur', function(){
        if (parseInt($(this).val()) <= 0 ) {
            $(this).addClass('errorBorder');
            $(this).siblings('label.errorT').remove();
            $(this).after("<label class='errorT error'>This value should be greater than 0.</label>");
        } else {
            $(this).removeClass('errorBorder');
            $(this).siblings('label.errorT').remove();
        }
    })

    $('#next_b2b').click(function () {
		var canown = $('#canown').val();
		valid = 1;
		//console.log("inproductreg");
		var del_option = $('input[name="del_option_b2b"]:checked').val();
		productnamevalid=$("#productnamevalid").val();
		if (productnamevalid=="false") {
            $("#productnamevalid").addClass('errorBorder');
           /* $(this).siblings('label.errorT').remove();*/
            $(".pex").after("<label class='errorT error'>Product name is already in use.</label>");
            valid=0;
        } else {
            $(this).removeClass('errorBorder');
            $(this).siblings('label.errorT').remove();
        }
		console.log(del_option);
		if(parseInt(canown) == 0 && del_option == 'own'){
			toastr.warning("In order to use own delivery you need to create new Logistic Provider Account!");
		} else {
			console.log("pass");
			
			$('.valid_select').each(function(){
				if($(this).val() == null || $(this).val() == '') {
					valid = 0;
					$(this).siblings('span.select2').addClass('errorBorder');
					$(this).siblings('span.select2').after("<label class='errorT  error'>This field is required.</label>");
				}
			})
			$('.valid_text').each(function(){
				if($(this).val() <= 0 && $(this).attr('disabled') != 'disabled') {
					valid = 0;
					$(this).addClass('errorBorder');
					$(this).after("<label class='errorT error'>This field is required.</label>");
				}
			});

			var x = parseInt($("#sprice-0").val());
			var y = $("#userID-0").val();

			var p = parseInt($("#wunit0").val());
			var q = parseInt($("#wprice-0").val());

			if((isNaN(x) || (y == null || y == '')) && (isNaN(p) || isNaN(q))) {
				valid = 0;
				if (isNaN(x)) {
					$('#sping-0').addClass('errorBorderIng');
					$('#sping-0').after("<label class='errorT error'>This field is required.</label>");
				} else {
					$('#sping-0').removeClass('errorBorderIng');
					$('#sping-0').siblings('.errorT').remove();
				}

				if ((y == null || y == '')) {
					$('#userID-0').addClass('errorBorder');
					$('#userID-0').after("<label class='errorT error'>This field is required.</label>");
				} else {
					$('#userID-0').removeClass('errorBorder');
					$('#userID-0').siblings('.errorT').remove();
				}

				if (isNaN(p)) {
					$('#wunit0').addClass('errorBorder');
					$('#wunit0').after("<label class='errorT error'>This field is required.</label>");
				} else {
					$('#wunit0').removeClass('errorBorder');
					$('#wunit0').siblings('.errorT').remove();
				}

				if (isNaN(q)) {
					$('#wping-0').addClass('errorBorderIng');
					$('#wping-0').after("<label class='errorT error'>This field is required.</label>");
				} else {
					$('#wping-0').removeClass('errorBorderIng');
					$('#wping-0').siblings('.errorT').remove();
				}
			}
			if (valid == 1){
				//console.log("Valido");
				$("#next_b2b_spinner").show();
				var fdata = new FormData($("#productRegForm")[0]);
				var merchant_policy = $("#info-merchantpolicy").val();
				var userid = $("#useridsell").val();
				fdata.append("merchant_policy", merchant_policy);
				fdata.append("userid", userid);
				console.log(fdata);
				$.ajax({
					url: JS_BASE_URL + '/store_b2b',
					data:fdata,
					dataType:'json',
					async:false,
					type:'post',
					processData: false,
					contentType: false,
					success:function(response){
						//console.log("LISTO");
						console.log("pass2");
						$("#next_b2b_spinner").hide();
						var pid = response;
						$('.nav-tabs a[href="#content-hyper"]').tab('show');
						$('html, body').animate({ scrollTop: 400 }, 'fast');
					},
				});
			}
        }
    });

    $('#next_hyper_product_error').click(function () {
		var message = $(this).attr('rel');
		toastr.warning(message);
	});
    $('#next_hyper_product').click(function () {
	/*	var canown = $('#canown').val();
		//console.log("inproductreg");
		var del_option = $('input[name="del_option_b2b"]:checked').val();
		console.log(del_option);*/	
		var hyperprice = $("#hyperprice").val();
		if(parseFloat(hyperprice) == 0){
			toastr.warning("Hyper product price cannot be 0!");
		} else {	
			$("#next_hyper_spinner").show();
			var fdata = new FormData($("#productRegForm")[0]);
			var userid = $("#useridsell").val();
			var merchant_policy = $("#info-merchantpolicy").val();
			fdata.append("merchant_policy", merchant_policy);
			fdata.append("userid", userid);	
			var moq = $("#moq").val();
			var moqcaf = $("#moqcaf").val();
			
			var hyper_duration = $("#hyper_duration").val();
			var owarehouse_id = $("#owarehouse_id").val();
			var hyper_terms = $("#hyper_terms").val();
			var hyper_id = $("#hyper_id").val();
			var parent_id = $("#myproduct_id").val();
			var hqty = $("#hqty").val();
			var prod_del_timehyper = $("#prod_del_timehyper").val();
			var prod_del_time_tohyper = $("#prod_del_time_tohyper").val();
			var hyper_terms = $("#hyper_terms").val();
			var free_delivery_with_purchase_qtyhyper_ow = $("#free_delivery_with_purchase_qtyhyper_ow").val();
			var free_delivery = 0;
			if ($('#sd_checkboxD_hyper').is(':checked')) {
				free_delivery = 1;
			}
			var areas_biz_hyper = $("#areas_biz_hyper").val();
			var cities_biz_hyper = $("#cities_biz_hyper").val();
			var states_biz_hyper = $("#states_biz_hyper").val();
			fdata.append("moq", moq);	
			fdata.append("moqcaf", moqcaf);	
			fdata.append("hyperprice", hyperprice);	
			fdata.append("hyper_duration", hyper_duration);	
			fdata.append("owarehouse_id", owarehouse_id);	
			fdata.append("hyper_terms", hyper_terms);	
			fdata.append("hyper_id", hyper_id);	
			fdata.append("parent_id", parent_id);	
			fdata.append("hqty", hqty);				
			fdata.append("prod_del_timehyper", prod_del_timehyper);				
			fdata.append("prod_del_time_tohyper", prod_del_time_tohyper);				
			fdata.append("hyper_terms", hyper_terms);				
			fdata.append("free_delivery_with_purchase_qty", free_delivery_with_purchase_qtyhyper_ow);				
			fdata.append("free_delivery", free_delivery);				
			fdata.append("areas_hyper", areas_biz_hyper);				
			fdata.append("cities_hyper", cities_biz_hyper);				
			fdata.append("states_hyper", states_biz_hyper);				
			$('#next_hyper_product').html("Saving...");
			console.log(sd_checkboxD_hyper);
			$("#totalBarhyper").show();
			var elem = document.getElementById("myBarhyper");
			elem.style.width = "10" + '%'; 
			elem.innerHTML = 10 + '%';
		//	console.log(fdata);
			$.ajax({
					xhr: function () {
						var xhr = new window.XMLHttpRequest();
						xhr.upload.addEventListener("progress", function (evt) {
							console.log("Loaded: " + evt.loaded);
							console.log("Total: " + evt.total);
							if (evt.lengthComputable) {
								var percentComplete = evt.loaded / evt.total;
								//console.log("P " + percentComplete);
								var width = Math.round(percentComplete * 100 * 0.8);
								elem.style.width = width + '%'; 
								elem.innerHTML = width * 1  + '%';
							/*	$('.progress').css({
									width: percentComplete * 100 + '%'
								});
								if (percentComplete === 1) {
									$('.progress').addClass('hide');
								}*/
							}
						}, false);
						xhr.addEventListener("progress", function (evt) {
							console.log("LoadedQ: " + evt.loaded);
							console.log("TotalQ: " + evt.total);
							if (evt.lengthComputable) {
								var percentComplete = evt.loaded / evt.total;
								//console.log("Q " + percentComplete);
								var width = 80 + (Math.round(percentComplete * 100 * 0.18));
								elem.style.width = width + '%'; 
								elem.innerHTML = width * 1  + '%';
								/*$('.progress').css({
									width: percentComplete * 100 + '%'
								});*/
							}
						}, false);
						return xhr;
					},			
			  url: JS_BASE_URL + '/store_hyper',
			  data:fdata,
			 // async:false,
			  type:'post',
			  processData: false,
			  contentType: false,
			  success:function(response){
				console.log(response+":"+fdata);
				if(response == "error"){
					toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport!!");
				} else {	
					var responsearr = response.split('-');
					toastr.info("Hyper values successfully saved!");
					$("#next_hyper_spinner").hide();
					$('#next_hyper_product').html("Go Hyper!");
					elem.style.width = "100" + '%'; 
					elem.innerHTML = 100 + '%';	
					$("#hyper_id").val(responsearr[0]);
					$("#owarehouse_id").val(responsearr[1]);
					$("#nremove_hyper").attr('id',"remove_hyper");
				//	$('.nav-tabs a[href="#content-sp"]').tab('show');
				//	$('html, body').animate({ scrollTop: 400 }, 'fast');
					$("#totalBarhyper").hide("slow", function() {
					//	alert( "Animation complete." );
					});			
				}
			  },
			  error:function(jqXHR, textStatus, errorThrown ){
				  console.log(jqXHR+":"+fdata);
				  $('#next_hyper_product').html("Go Hyper!");
				  $("#next_hyper_spinner").hide();
					elem.style.width = "0" + '%'; 
					elem.innerHTML = 0 + '%';				  
				  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport!!!!");
			  }
			});
		}		
	});
    $('#next_b2b_product').click(function () {
		var canown = $('#canown').val();
		//console.log("inproductreg");
		var del_option = $('input[name="del_option_b2b"]:checked').val();
		console.log(del_option);
		if(parseInt(canown) == 0 && del_option == 'own'){
			toastr.warning("In order to use own delivery you need to create new Logistic Provider Account!");
		} else {		
			$("#next_b2b_spinner").show();
			var fdata = new FormData($("#productRegForm")[0]);
			var userid = $("#useridsell").val();
			var merchant_policy = $("#info-merchantpolicy").val();
			fdata.append("merchant_policy", merchant_policy);
			fdata.append("userid", userid);	
			$('#next_b2b_product').html("Saving...");
			$("#totalBarb2b").show();
			var elem = document.getElementById("myBarb2b");
			elem.style.width = "10" + '%'; 
			elem.innerHTML = 10 + '%';
		//	console.log(fdata);
			$.ajax({
					xhr: function () {
						var xhr = new window.XMLHttpRequest();
						xhr.upload.addEventListener("progress", function (evt) {
							console.log("Loaded: " + evt.loaded);
							console.log("Total: " + evt.total);
							if (evt.lengthComputable) {
								var percentComplete = evt.loaded / evt.total;
								//console.log("P " + percentComplete);
								var width = Math.round(percentComplete * 100 * 0.8);
								elem.style.width = width + '%'; 
								elem.innerHTML = width * 1  + '%';
							/*	$('.progress').css({
									width: percentComplete * 100 + '%'
								});
								if (percentComplete === 1) {
									$('.progress').addClass('hide');
								}*/
							}
						}, false);
						xhr.addEventListener("progress", function (evt) {
							console.log("LoadedQ: " + evt.loaded);
							console.log("TotalQ: " + evt.total);
							if (evt.lengthComputable) {
								var percentComplete = evt.loaded / evt.total;
								//console.log("Q " + percentComplete);
								var width = 80 + (Math.round(percentComplete * 100 * 0.18));
								elem.style.width = width + '%'; 
								elem.innerHTML = width * 1  + '%';
								/*$('.progress').css({
									width: percentComplete * 100 + '%'
								});*/
							}
						}, false);
						return xhr;
					},			
			  url: JS_BASE_URL + '/store_b2b',
			  data:fdata,
			  dataType:'json',
			 // async:false,
			  type:'post',
			  processData: false,
			  contentType: false,
			  success:function(response){
				console.log(response+":"+fdata);
				if(response == "error"){
					toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
				} else {			  
					toastr.info("B2B values successfully saved!");
					$("#next_b2b_spinner").hide();
					$('#next_b2b_product').html("Save");
					elem.style.width = "100" + '%'; 
					elem.innerHTML = 100 + '%';	
				//	$('.nav-tabs a[href="#content-sp"]').tab('show');
				//	$('html, body').animate({ scrollTop: 400 }, 'fast');
					$("#totalBarb2b").hide("slow", function() {
					//	alert( "Animation complete." );
					});			
				}
			  },
			  error:function(jqXHR, textStatus, errorThrown ){
				  console.log(jqXHR+":"+fdata);
				  $('#next_b2b_product').html("Save");
				  $("#next_b2b_spinner").hide();
					elem.style.width = "0" + '%'; 
					elem.innerHTML = 0 + '%';				  
				  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
			  }
			});
		}
    });
	
    $('#next_sp_product').click(function () {
		toastr.info("SP values successfully saved!");
		$("#next_sp_spinner").hide();
		$("#myproduct_id").val(0);
		$("#name_v").val("");
		$("#preview-img").attr("src", "#");
		$('.nav-tabs a[href="#content-retail"]').tab('show');
		$('html, body').animate({ scrollTop: 400 }, 'fast');
    });	

    $('#prev_b2b').click(function () {
        $('.nav-tabs a[href="#content-retail"]').tab('show');
        $('html, body').animate({ scrollTop: 400 }, 'fast');
    });

    $('#checkboxD').click(function () {
        $('.toggleDelivery').find('input').attr('disabled', this.checked);
        $('.toggleDelivery').find('input').val('');
	//	console.log(this.checked);
        if(this.checked){
			$('#sd_checkboxD').prop('checked', true);
            $('#checkboxDq').prop('checked', false);
            $('#checkboxF').prop('checked', false);
            $('#sd_checkboxDq').prop('checked', false);
            $('#checkboxDq').prop('disabled', true);
            $('#checkboxF').prop('disabled', true);
            $('#sd_checkboxDq').prop('disabled', true);
            $("#checkboxDqn").prop('disabled', true);
            $("#sd_checkboxDqn").prop('disabled', true);
            $("#checkboxDqn").val('');
            $("#sd_checkboxDqn").val('');
            $('#retail_delivery').text(0).number(true, 2, '.', '');
            var rp = $('#rPrice').val();
            var op = $('#oPrice').val();
            if(op != "" && parseInt(op) != 0){
                $('#retail_amount').text(op).number(true, 2, '.', '' );
                $('#retail_total').text(parseInt(op)).number(true, 2, '.', '' );
            } else {
                $('#retail_amount').text(rp).number(true, 2, '.', '' );
                $('#retail_total').text(parseInt(rp)).number(true, 2, '.', '' );
            }
        } else {
			$('#checkboxF').prop('disabled', false);
			$('#sd_checkboxD').prop('checked', false);
			$('#checkboxDq').prop('disabled', false);
			$('#sd_checkboxDq').prop('disabled', false);
		}
    });

    $('#sd_checkboxD').click(function () {
        if(this.checked){
			$('#checkboxD').prop('checked', true);
            $('#sd_checkboxDq').prop('checked', false);
            $('#checkboxDq').prop('checked', false);
            $('#sd_checkboxDq').prop('disabled', true);
            $('#checkboxDq').prop('disabled', true);
            $("#sd_checkboxDqn").prop('disabled', true);
            $("#checkboxDqn").prop('disabled', true);
            $("#sd_checkboxDqn").val('');
            $("#checkboxDqn").val('');

            /*  Check me please  */
            // $('#retail_delivery').text(0).number(true, 2, '.', '');
            // var rp = $('#rPrice').val();
            // var op = $('#oPrice').val();
            // if(op != "" && parseInt(op) != 0){
            //     $('#retail_amount').text(op).number(true, 2, '.', '' );
            //     $('#retail_total').text(parseInt(op)).number(true, 2, '.', '' );
            // } else {
            //     $('#retail_amount').text(rp).number(true, 2, '.', '' );
            //     $('#retail_total').text(parseInt(rp)).number(true, 2, '.', '' );
            // }
        } else {
			$('#checkboxD').prop('checked', false);
            $('#sd_checkboxDq').prop('disabled', false);
            $('#checkboxDq').prop('disabled', false);
        }
    });
	
    $('#sd_checkboxD_b2b').click(function () {
        if(this.checked){
            $('#sd_checkboxDq_b2b').attr('checked', false);
            $('#sd_checkboxDq_b2b').attr('disabled', true);
            $("#sd_checkboxDqn_b2b").prop('disabled', true);
            $("#sd_checkboxDqn_b2b").val('');

            /*  Check me please  */
            // $('#retail_delivery').text(0).number(true, 2, '.', '');
            // var rp = $('#rPrice').val();
            // var op = $('#oPrice').val();
            // if(op != "" && parseInt(op) != 0){
            //     $('#retail_amount').text(op).number(true, 2, '.', '' );
            //     $('#retail_total').text(parseInt(op)).number(true, 2, '.', '' );
            // } else {
            //     $('#retail_amount').text(rp).number(true, 2, '.', '' );
            //     $('#retail_total').text(parseInt(rp)).number(true, 2, '.', '' );
            // }
        } else {
            $('#sd_checkboxDq_b2b').attr('disabled', false);
        }
    });	
	
	$('#sd_checkboxD_hyper').click(function () {
        if(this.checked){
            $('#sd_checkboxDq_hyper').attr('checked', false);
            $('#sd_checkboxDq_hyper').attr('disabled', true);
            $("#sd_checkboxDqn_hyper").prop('disabled', true);
            $("#sd_checkboxDqn_hyper").val('');

            /*  Check me please  */
            // $('#retail_delivery').text(0).number(true, 2, '.', '');
            // var rp = $('#rPrice').val();
            // var op = $('#oPrice').val();
            // if(op != "" && parseInt(op) != 0){
            //     $('#retail_amount').text(op).number(true, 2, '.', '' );
            //     $('#retail_total').text(parseInt(op)).number(true, 2, '.', '' );
            // } else {
            //     $('#retail_amount').text(rp).number(true, 2, '.', '' );
            //     $('#retail_total').text(parseInt(rp)).number(true, 2, '.', '' );
            // }
        } else {
            $('#sd_checkboxDq_hyper').attr('disabled', false);
        }
    });

    $('#checkboxDb2b').click(function () {
        $('.toggleDeliveryb2b').find('input').attr('disabled', this.checked);
        $('.toggleDeliveryb2b').find('input').val('');
	//	console.log(this.checked);
        if(this.checked){
			$('#sd_checkboxD_b2b').prop('checked', true);
            $('#checkboxDqb2b').prop('checked', false);
            $('#checkboxFb2b').prop('checked', false);
            $('#sd_checkboxDq_b2b').prop('checked', false);
            $('#checkboxDqb2b').prop('disabled', true);
            $('#checkboxFb2b').prop('disabled', true);
            $('#sd_checkboxDq_b2b').prop('disabled', true);
            $("#checkboxDqnb2b").prop('disabled', true);
            $("#sd_checkboxDqn_b2b").prop('disabled', true);
            $("#checkboxDqnb2b").val('');
            $("#sd_checkboxDqn_b2b").val('');
        } else {
			$('#checkboxFb2b').prop('disabled', false);
			$('#sd_checkboxD_b2b').prop('checked', false);
			$('#checkboxDqb2b').prop('disabled', false);
			$('#sd_checkboxDq_b2b').prop('disabled', false);
		}
    });
    //==== Add More Scripts***
    $('.custom-themes').on('click', function () {
        var val = $(this).attr("data-theme").split(',');
        if (val != "") {
            var id = val[0];
            var identifier = val[1];
            AlertPopup(id, identifier, $(this), '', '');
        }
    });

    /* signBoard thumbs*/
    $(".sbimgID").click(function () {
        var val = $(this).parent('li').attr("data-theme").split(',');
        if (val != "") {
            var id = val[0];
            var identifier = val[1];
            AlertPopup(id, identifier, $(this), '', '');
        }
    });
    /* Bunting thumbs*/
    $(".bimgID").click(function () {
        var val = $(this).parent('li').attr("data-theme").split(',');
        if (val != "") {
            var id = val[0];
            var identifier = val[1];
            AlertPopup(id, identifier, $(this), '', '');
        }
    });
    /*youtube video thumbs*/
    $('ul#extractThumb li img').each(function () {
        var iframe = $(this).attr('data-src').split('.');
        console.log(iframe);
        if (iframe[1] == "youtube") {
            var iframe_YT = $(this).attr('data-src');
            var youtube_video_id = iframe_YT.match(/www\.youtube\.com.*(\?v=|\/embed\/)(.{11})/).pop();
            if (youtube_video_id.length == 11) {
                $(this).attr('src', "http://img.youtube.com/vi/" + youtube_video_id + "/0.jpg");
            }
        }
        else if (iframe[1] == "dailymotion") {
            var dailymotion_video_id = $(this).attr('data-src').split('/');
            var dailymotion = "http://www.dailymotion.com/thumbnail/video/" + dailymotion_video_id[dailymotion_video_id.length - 1];
            $(this).attr('src', dailymotion);
        }
        else {
            var vemo_video_id = $(this).attr('data-src').split('/');
            var obj = $(this);
            $.getJSON('http://www.vimeo.com/api/v2/video/' + vemo_video_id[vemo_video_id.length - 1] + '.json?callback=?', {format: "json"}, function (data) {
                obj.attr('src', data[0].thumbnail_medium);
            });
        }
        $(this).click(function () {
            $('#tvideoID').attr('src', iframe);
        });
    });
    $("#remVBcontent").click(function () {
        $('#tvideoID').attr('src', '');
        $('.placeholdertext').removeClass('hidden');
    });
    /* Bunting*/
    $("#remBunting").click(function () {
        $('#display-bunting').addClass('hidden');
        $('.p-product').removeClass('col-sm-9').addClass('col-sm-12')
        $('.p-box').removeClass('col-lg-4 col-md-6 col-sm-6').addClass('col-lg-3 col-md-3 col-sm-4')
        $('#addBunting').removeClass('hidden');
    });

    $("#addBunting").click(function () {
        $('.p-product').removeClass('col-sm-12').addClass('col-sm-9')
        $('.p-box').removeClass('col-lg-3 col-md-3 col-sm-4').addClass('col-lg-4 col-md-6 col-sm-6')
        $('#display-bunting').removeClass('hidden');
        $('#addBunting').addClass('hidden');
    });

    $('.addProductToSection').on('click', function () {
        var secId = $(this).attr('data-sid');
        var s_name = $('#section_name_text_' + secId).val();
        var token = $('input[name="_token"]').val();
        $.ajax({
            url: JS_BASE_URL + '/profile/section-session',
            data: {'id': secId, 'name': s_name, _token: token},
            error: function () {

            },
            success: function (response) {
                if (response.status == 'true') {
                    window.location.href = JS_BASE_URL + '/album';
                }
            },
            type: 'POST'
        });
    });

    $("#display-product-section").on('click', '.remPsec', function () {
        var obj = $(this);
        var id = $(this).attr('data-remID');
        var route = 'delete_profile_product';


        $("#count" + $(this).attr("data-remID")).parent().remove();
        $(this).closest('#psection' + id).remove();
        //pSecCount--;
    });
    /* for first static display */
	var _URL = window.URL || window.webkitURL;
    $("#uploadBtn").change(function () {
	   var uploadbtn = this;
	   var file = this.files[0];
	   var img = new Image();
	   var sizeKB = file.size / 1024;
	   img.onload = function() {
			var img_width = img.width;
			var img_height = img.height;
			//if(parseFloat(img_width) == 345 && parseFloat(img_height) == 300){
				x = $("#uploadBtn").val();
			//	console.log(x);
				$('#ximage').val(x);
				readURLSingle(uploadbtn, 'preview-img');
				readURLSingle(uploadbtn, 'preview-imgb2b');
				readURLSingle(uploadbtn, 'preview-imghyper');
				readURLSingle(uploadbtn, 'preview-imgsp');
				$('#thumbnail').removeClass('errorDoubleBorder');				
			/*} else {
				toastr.error("Incorrect image dimensions, please, select a valid image");
			}*/
	   }
	   img.src = _URL.createObjectURL(file);		
    });
    /* upload default signboard*/
    $(".signboardupload").change(function () {
        var curr = $(this).data('imgid');
        uploadSBV('update-signboard', 'preview-img-sb' + curr, $(this), 'signboar-counter');
        /*url,preview id,obj,counter id*/
    });
    /* upload default bunting*/
    $("#bntuploadBtn").change(function () {
        var curr = $(this).data('imgid');
        uploadSBV('update-bunting', 'preview-img-bnt' + curr, $(this), 'bunting-counter');
        /*url,preview id,obj,counter id*/
    });
    /* upload default video banner*/
    $("#vbnruploadBtn").change(function () {
        readURLSingle(this, 'preview-img-vbnr');
    });
    /* for subcat display */
    var listgrp = 0;
    $("#mainCat").on('change', function () {

        listgrp++;
        if ($(this).val() != "") {
            if ($("#mainCat option:selected").is(':enabled')) {
                var URL = $(this).attr('data-url');
                var val = $(this).val().split('%id%')[0];
                var id = $(this).val().split('%id%')[1];
                $('#append-subCate').append('<div data-listgroup="' + $(this).val() + '" id="listgroups' + listgrp + '" class="listgroupsbox col-sm-3"><a class="badge badge-close remLGB" >X</a><ul class="list-group list-unstyled"> <li class="btn list-group-item active">' + val + ' </li><li> <ul class="list-unstyled inner-lvl"></ul></li><li  class="list-group-item"><button type="button" class="btn btn-primary create-product" data-rowid="'+id+'">Create New Product</button> </li>   </div></div>');

                $("#mainCat option:selected").attr('disabled', 'disabled');
            }
        }
    });

    $('#append-subCate').on('click', '.remLGB', function () {
        var relval = $(this).parent().attr('data-listgroup');
        $('#mainCat option[value="' + relval + '"]').removeAttr('disabled');
        $(this).parent().remove();
    });
    /*
     Asif changing
     */
    $('#append-subCate ul.inner-lvl li').click(function () {
        var detail;
        var pricing;
        var specsT;
        var isfind = false;
        var isfirst = true;
        var sku;
        var row = 0;
        var index = 0;
        var Names = $(this).attr('data-catnames').split('%d%');
        var count = parseInt($(this).find('span').html());
        if (count > 0) {
            $("someTableSelector").find("tr:gt(0)").remove();
            $('#p-detailT').find("tr:gt(1)").remove();
            $('#p-pricingT').find("tr:gt(1)").remove();
            $('#p-specsT').find("tr:gt(1)").remove();

            var Ids = $(this).attr('data-categoriesId').split(",");
            if (Ids != "") {
                $.ajax({
                    type: "post",
                    url: JS_BASE_URL + '/showsubDetails',
                    data: {subcategoryid: Ids[0], categoryid: Ids[1]},
                    cache: false,
                    success: function (responseData) {
                        console.log(responseData);
                        for (i = 0; i < count; i++) {
                            row++;
                            isfind = false;
                            detail += '<tr class="' + responseData['Product'][i]['id'] + '" data-subcategoryid="' + Ids[0] + '">' + '<td><input type="checkbox" class="del-val" data-pro-id="' + responseData['Product'][i]['id'] + '"' + '></td>';
                            detail += '<td>' + i + '</td>';

                            detail += '<td>' + responseData['Product'][i]['id'] + '</td>'

                            detail += '<td class="edit_pro">' + responseData['Product'][i]['name'] + '</td>' +
                                '<td class="edit_pro main-cat" data-action="update" data-rowid="' + responseData['Product'][i]['id'] + '" data-columnname="category_id" data-tablename="Product" data-value=' + Ids[1] + '>' + Names[1] + '</td>' +
                                '<td class="edit_pro" data-action="update" data-rowid="' + responseData['Product'][i]['id'] + '" data-columnname="brand_id" data-tablename="Product">' + responseData['Brand'][i]['name'] + '</td>' +
                                '<td class="edit_pro" data-action="update" data-rowid="' + responseData['Product'][i]['id'] + '" data-columnname="subcat_id" data-tablename="Product">' + Names[0] + '</td>' +
                                '<td class="edit_pro" data-action="update" data-rowid="' + responseData['Product'][i]['id'] + '" data-columnname="product_details" data-tablename="Product">' + responseData['Product'][i]['product_details'] + '</td>' +
                                '<td class="edit_pro" data-action="update" data-rowid="' + responseData['Product'][i]['id'] + '" data-columnname="available" data-tablename="Product">' + responseData['Product'][i]['available'] + '</td> ' +
                                '</tr>';
                            //pricing table view
                            pricing += '<tr class="' + responseData['Product'][i]['id'] + '">' + '<td>' + index + '</td>';
                            pricing += '<td>' + responseData['Product'][i]['id'] + '</td>';
                            pricing += '<td class="edit_pro">' + responseData['Product'][i]['retail_price'] + '</td>';
                            pricing += '<td class="edit_pro">' + responseData['Product'][i]['original_price'] + '</td>';
                            if (responseData['Wholesale'][i].length > 0) {
                                isfirst = true;
                                for (j = 0; j < responseData['Wholesale'][i].length; j++) {
                                    var wholesalePrice = responseData['Wholesale'][i][j] ? responseData['Wholesale'][i][j]['price'] : 0;
                                    if (wholesalePrice != 0) {
                                        var wholesale = responseData['Wholesale'][i][j]['id'];
                                    }
                                    if (isfirst) {
                                        pricing += '<td><span class="edit_pro" data-action="update" data-rowid="' + wholesale + '" data-columnname="price" data-tablename="Wholesale">' + wholesalePrice + '</span><span class="pull-right" data-toggle="collapse" href="#pricecollapse' + row + '" aria-expanded="false" aria-controls="pricecollapse' + row + '"><i class="fa fa-caret-down"></i></span><ul class="list-group collapse" id="pricecollapse' + row + '">';
                                        isfirst = false;
                                    } else {
                                        pricing += '<li class="list-group-item edit_pro" data-action="update" data-rowid="' + wholesale + '" data-columnname="price" data-tablename="Wholesale">' + wholesalePrice + '</li>'
                                    }
                                }
                                pricing += '</ul></td>';
                                isfirst = true;
                                for (j = 0; j < responseData['Wholesale'][i].length; j++) {
                                    var wholesaleUnit = responseData['Wholesale'][i][j] ? responseData['Wholesale'][i][j]['unit'] : 0;
                                    if (wholesaleUnit != 0) {
                                        var wholesale = responseData['Wholesale'][i][j]['id'];
                                    }
                                    if (isfirst) {
                                        pricing += '<td><span class="edit_pro" data-action="update" data-rowid="' + wholesale + '" data-columnname="unit" data-tablename="Wholesale">' + wholesaleUnit + '</span><span class="pull-right" data-toggle="collapse" href="#unitcollapse' + row + '" aria-expanded="false" aria-controls="unitcollapse' + row + '"><i class="fa fa-caret-down"></i></span><ul class="list-group collapse" id="unitcollapse' + row + '">';
                                        isfirst = false;
                                    } else {
                                        pricing += '<li class="list-group-item edit_pro" data-action="update" data-rowid="' + wholesale + '" data-columnname="unit" data-tablename="Wholesale">' + wholesaleUnit + '</li>'
                                    }
                                }
                                pricing += '</ul></td>';
                            } else {
                                pricing += '<td>--</td>';
                                pricing += '<td>--</td>';
                            }
                            if (responseData['Productdealer'].length > 0) {
                                isfirst = true;
                                for (j = 0; j < responseData['Productdealer'].length; j++) {
                                    var productdealerPrice = responseData['Productdealer'][i] ? responseData['Productdealer'][i]['special_price'] : 0;

                                    if (productdealerPrice != 0) {
                                        var productdealer = responseData['Productdealer'][i]['id'];
                                    }
                                    if (isfirst) {
                                        pricing += '<td><span class="edit_pro" data-action="update" data-rowid="' + productdealer + '" data-columnname="special_price" data-tablename="Productdealer">' + productdealerPrice + '</span><span class="pull-right" data-toggle="collapse" href="#Spricecollapse' + row + '" aria-expanded="false" aria-controls="Spricecollapse' + row + '"><i class="fa fa-caret-down"></i></span><ul class="list-group collapse" id="Spricecollapse' + row + '">';
                                        isfirst = false;
                                    } else {
                                        pricing += '<li class="list-group-item edit_pro" data-action="update" data-rowid="' + productdealer + '" data-columnname="special_price" data-tablename="Productdealer">' + productdealerPrice + '</li>'
                                    }
                                }
                                pricing += '</ul></td>';
                                isfirst = true;
                                for (j = 0; j < responseData['Productdealer'].length; j++) {
                                    var productdealerUnit = responseData['Productdealer'][i] ? responseData['Productdealer'][i]['special_unit'] : 0;
                                    if (productdealerUnit != 0) {
                                        var productdealer = responseData['Productdealer'][i]['id'];
                                    }
                                    if (isfirst) {
                                        pricing += '<td><span class="edit_pro" data-action="update" data-rowid="' + productdealer + '" data-columnname="special_unit" data-tablename="Productdealer">' + productdealerUnit + '</span><span class="pull-right" data-toggle="collapse" href="#Suintcollapse' + row + '" aria-expanded="false" aria-controls="Suintcollapse' + row + '"><i class="fa fa-caret-down"></i></span><ul class="list-group collapse" id="Suintcollapse' + row + '">';
                                        isfirst = false;
                                    } else {
                                        pricing += '<li class="list-group-item edit_pro" data-action="update" data-rowid="' + productdealer + '" data-columnname="special_unit" data-tablename="Productdealer">' + productdealerUnit + '</li>'
                                    }
                                }
                                pricing += '</ul></td>';
                            } else {
                                pricing += '<td>--</td>';
                                pricing += '<td>--</td>';
                            }
                            /*Specification table*/
                            for (k = 0; k < responseData['Users'].length; k++) {
                                if (responseData['Users'][k]['id'] == responseData['Productdealer'][j]['user_id']) {
                                    pricing += '<td>' + responseData['Users'][k]['first_name'] + '</td>';
                                    isfind = true;
                                    break;
                                }
                            }
                            if (!isfind) {
                                pricing += '<td>' + '--' + '</td>';

                            }
                            pricing += '<td>--</td></tr>';
                            index = index + 1;
                            isfind = false;

                            specsT += '<tr class="' + responseData['Product'][i]['id'] + '">' + '<td>' + i + '</td>';
                            specsT += '<td>' + responseData['Product'][i]['id'] + '</td>';
                            for (kk = 0; kk < 8; kk++) {
                                if (kk == 2) {
                                    var org_price = responseData['Product'][i]['original_price'] ? responseData['Product'][i]['original_price'] : 0;
                                    specsT += '<td class="edit_pro">' + org_price + '</td>';
                                } else {
                                    var proSpec = responseData['Productspecs'][i][kk] ? responseData['Productspecs'][i][kk]["value"] : '--';
                                    if (proSpec != '--') {
                                        for (sp = 0; sp < responseData['Specifications'].length; sp++) {
                                            if (responseData['Specifications'][sp]["id"] == responseData['Productspecs'][i][kk]["spec_id"]) {
                                                switch (responseData['Specifications'][sp]["name"]) {
                                                    case "color":
                                                        specsT += '<td class="edit_pro" id="color" data-action="update" data-rowid="' + responseData['Productspecs'][i][kk]['id'] + '" data-columnname="value" data-tablename="productspec">';
                                                        break;
                                                    case "model":
                                                        specsT += '<td class="edit_pro" id="model" data-action="update" data-rowid="' + responseData['Productspecs'][i][kk]['id'] + '" data-columnname="value" data-tablename="productspec">';
                                                        break;
                                                    case "size":
                                                        specsT += '<td class="edit_pro" id="size" data-action="update" data-rowid="' + responseData['Productspecs'][i][kk]['id'] + '" data-columnname="value" data-tablename="productspec">';
                                                        break;
                                                    case "weight":
                                                        specsT += '<td class="edit_pro" id="weight" data-action="update" data-rowid="' + responseData['Productspecs'][i][kk]['id'] + '" data-columnname="value" data-tablename="productspec">';
                                                        break;
                                                    case "warranty":
                                                        specsT += '<td class="edit_pro" id="warranty" data-action="update" data-rowid="' + responseData['Productspecs'][i][kk]['id'] + '" data-columnname="value" data-tablename="productspec">';
                                                        break;
                                                    case "warranty_type":
                                                        specsT += '<td class="edit_pro" id="warranty_type" data-action="update" data-rowid="' + responseData['Productspecs'][i][kk]['id'] + '" data-columnname="value" data-tablename="productspec">';
                                                        break;
                                                }
                                            }
                                        }
                                        specsT += proSpec;
                                        specsT += '</td>';
                                    }
                                    else {
                                        switch (kk) {
                                            case 1:
                                                specsT += '<td class="edit_pro" data-action="add" data-spec="color" data-tablename="Specification" data-rowid="' + responseData['Product'][i]['id'] + '"' + '>';
                                                break;
                                            case 3:
                                                specsT += '<td class="edit_pro" data-action="add" data-spec="model" data-tablename="Specification" data-rowid="' + responseData['Product'][i]['id'] + '"' + '>';
                                                break;
                                            case 4:
                                                specsT += '<td class="edit_pro" data-action="add" data-spec="size" data-tablename="Specification" data-rowid="' + responseData['Product'][i]['id'] + '"' + '>';
                                                break;
                                            case 5:
                                                specsT += '<td class="edit_pro" data-action="add" data-spec="weight" data-tablename="Specification" data-rowid="' + responseData['Product'][i]['id'] + '"' + '>';
                                                break;
                                            case 6:
                                                specsT += '<td class="edit_pro" data-action="add" data-spec="warranty" data-tablename="Specification" data-rowid="' + responseData['Product'][i]['id'] + '"' + '>';
                                                break;
                                            case 7:
                                                specsT += '<td class="edit_pro" data-action="add" data-spec="warranty_type" data-tablename="Specification" data-rowid="' + responseData['Product'][i]['id'] + '"' + '>';
                                                break;
                                        }
                                        specsT += proSpec;
                                        specsT += '</td>';
                                    }
                                }

                            }
                            specsT += '</tr>';
                        }
                        $('#p-detailT').append(detail);
                        $('#p-pricingT').append(pricing);
                        $('#p-specsT').append(specsT);
                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                    }
                });
            }
        }
        $("td").bind("click", function (element) {
            newInput(this);
        });
    });

    /* album products */

    $("#pbox td, #discountval").bind("click", function (element) {
        newInput(this);

    });
    $("#pbox .simgID").bind("click", function (element) {
        var src = $(this).attr('src');
        $(this).closest(".p-img").find('#timgID').attr('src', src);
    });
    /* $("#upldpro").click(function(){
     rowNum++;
     $('#pro-counter').html(function(i, val) { return val*1+1 });

     $("#append-pro").append('<div id="pbox'+rowNum+'" class="p-box placeholder  col-sm-3 col-xs-12"><div class="p-img" id="'+rowNum+'" ><a class="badge badge-close remProbox" >X</a>        <img id="timgID'+rowNum+'" src="images/placeholder.png" class="img-responsive">        <a class="badge badge-upload " id="uploadImg'+rowNum+'"  data-toggle="collapse" data-target="#imgThumbs'+rowNum+'" aria-expanded="false" aria-controls="imgThumbs'+rowNum+'" ><i class="fa fa-lg fa-upload"></i></a> <div class="collapse imgThumbs"     data-thumbId="'+rowNum+'"   id="imgThumbs'+rowNum+'"> <ul > <li> <img class="simgID" alt="item" src="images/p1.png" class="img-responsive"></li>        <li>  <img class="simgID" alt="item" src="images/p2.png" class="img-responsive"></li>  <li> <img class="simgID" alt="item" src="images/p3.png" class="img-responsive"></li> <li> <img class="simgID" alt="item" src="images/p4.png" class="img-responsive"></li>        <li><img class="simgID" alt="item" src="images/p5.png" class="img-responsive"></li> <li> <img class="simgID" alt="item" src="images/p6.png" class="img-responsive"></li>    </ul></div>       </div>        <table class="table table-bordered p-specs">        <tr>        <td colspan="2"  id="pname_'+rowNum+'">&nbsp;</td><td id="pval1_'+rowNum+'">&nbsp;</td></tr><tr> <td class="text-danger" id="padd_'+rowNum+'">&nbsp;</td>  <td id="pqty_'+rowNum+'">&nbsp;</td><td class="text-danger" id="pval2_'+rowNum+'">&nbsp;</td></tr></table><div class="clearfix"> </div>        <div class=" col-xs-8">        <ul class="list-inline">        <li class="btn-green"><i class="fa fa-plus"></i></li>        <li class="btn-pink"><i class="fa fa-heart"></i></li>        <li class="btn-darkgreen"><i class="fa fa-shopping-cart"></i></li>        </ul>        </div>        <div class=" col-xs-4 text-right">        <strong class="text-muted" id="discountval_'+rowNum+'">0%</strong>        </div>        <div class="clearfix"> </div>        </div>        ');

     $( "#discountval_"+rowNum ).bind( "click", function(element) {
     newInput(this);
     });
     $( "#pname_"+rowNum ).bind( "click", function(element) {
     newInput(this);
     });  $( "#padd_"+rowNum ).bind( "click", function(element) {
     newInput(this);
     });
     $( "#pqty_"+rowNum ).bind( "click", function(element) {
     newInput(this);
     });
     $( "#pval1_"+rowNum ).bind( "click", function(element) {
     newInput(this);
     });
     $( "#pval2_"+rowNum ).bind( "click", function(element) {
     newInput(this);
     });

     var src = null;
     $(".simgID").bind( "click", function(element) { src=$(this).attr('src');});//it runs multiple times

     $("#imgThumbs"+rowNum).bind( "click", function(element) {

     var sr= src //$(this).attr('src');
     var id = $(this).closest(".imgThumbs").attr("data-thumbid");

     $(this).closest(".p-img").find('#timgID'+id).attr('src', sr);
     $(this).closest(".p-box").removeClass('placeholder');
     src = '';
     });
     });*/
    $("#append-pro").on('click', '.remProbox', function () {
        var pro_id = [$(this).data('pro-id')];
        var sub_id = $(this).data('subid');
        AlertPopup('delete-pro', pro_id, $(this), 'pro-counter', sub_id);
    });

    /* album signboard */
    $("#upldsb").click(function () {
        rowNum = $('.current-signboard').length;
        rowNum++;
     /*   if ($('.upld-signboard').length > 3) {
            $('#upldsb').addClass('hidden');
        }*/
        $('#signboar-counter').attr('data-row-count', function (i, val) {
            return val * 1 + 1
        });
        $("#append-sb-img").append('<div class="main-parentn"><div style="width: 10% !important; float: left; vertical-align: middle; display:block;" class="select-all"><b>Select O-Shop:</b></div><div style="width: 40% !important; float: left; display:block;" class="select-all"><select name="oshop_idd" class="badge-select" id="select_o' + rowNum + '" data-id="0">' + $('#select_o').html() + '</select></div><div style="width: 37% !important; display: block; float: left;" class="select-all"><b class="pull-right">Enable</b></div><input type="checkbox" style="display:block; float: right; margin-top: 2px; margin-right: 10%;" class="badge-checkbox" data-id="0" data-oshopid="0" value=""/> <div class="col-sm-11 upld-signboard main-parent"><p align="right" style=" float:right; display: none;" class="sign-spinner" data-id="0"> <i class="fa-li fa fa-spinner fa-spin fa-2x fa-fw pull-right newspinner" style="float:right;"></i></p><a class="badge badge-close remupldsb" data-id="">X</a><img class="img-responsive current-signboard"  id="preview-img-sb' + rowNum + '"  src="#" alt="" />    <center><input class="disableInputField text-center" style="margin-top:90px; color: black;" id="uploadFileSign" placeholder="2200 x 200" disabled="disabled" name="photo" type="text">	 </center>    <div class="inputBtnSection">     <label class="fileUpload">        <input data-imgID="' + rowNum + '"   id="uploadBtn' + rowNum + '"  type="file" class="upload" data-rowid="" style="width:25px"/><span class="uploadBtn badge pull-right" style="width:24px"><i class="fa fa-lg fa-upload"></i> </span>        </label>        </div>        </div>');
		$('#select_o' + rowNum).val("");
		$('.badge-select').select2();
        $("#uploadBtn" + rowNum).change(function (ele) {
            var id = $(this).attr("data-imgID");
            uploadSBV('update-signboard', 'preview-img-sb' + id, $(this), 'signboar-counter');
        });
    });
    $("#append-sb-img").on('click', '.remupldsb', function () {
        var signboard_id = $(this).data('id');
        if (signboard_id != '') {
            AlertPopup('delete-signboard', signboard_id, $(this), 'signboar-counter', '');
        }
        else {
            $(this).parents('.main-parentn').remove();
            $('#upldsb').removeClass('hidden');
            $('#signboar-counter').attr('data-row-count', function (i, val) {
                return val * 1 - 1
            });
        }
    });
    /*remove upload signboard */
    $(".remupldsignboard").on('click', function () {
		console.log("Remove");
        var signboard_id = $(this).data('id');
        if (signboard_id != '') {
            AlertPopup('delete-signboard', signboard_id, $(this), 'signboar-counter', '');
        }
        else
        {
            $(this).parents(".main-parentn").remove();
            $('#upldsb').removeClass('hidden');
            $('#signboar-counter').attr('data-row-count', function (i, val) {
                return val * 1 - 1
            });
        }
    });
    /* album bunting */
    $("#upldbb").click(function () {
        rowNum = $('.current-bunting').length;
        rowNum++;
        if ($('.upld-bunting').length > 3) {
            $('#upldbb').addClass('hidden');
        }
        $('#bunting-counter').attr('data-row-count', function (i, val) {
            return val * 1 + 1
        });
        $("#append-bb-img").append(' <div class="col-sm-2 upld-bunting main-parent"><a class="badge badge-close remupldbb" data-id="">X</a>        <img class="img-responsive current-bunting"  id="preview-img-bnt' + rowNum + '"  src="#" alt="" />        <div class="inputBtnSection">     <input disabled="disabled" class="disableInputField">   <label class="fileUpload">        <input data-imgID="' + rowNum + '"   id="uploadBtn' + rowNum + '"  type="file" class="upload" data-rowid=""/>        <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>        </label>        </div>        </div>');

        $("#uploadBtn" + rowNum).change(function (ele) {
            var id = $(this).attr("data-imgID");
            uploadSBV('update-bunting', 'preview-img-bnt' + id, $(this), 'bunting-counter');
        });
    });
    $("#append-bb-img").on('click', '.remupldbb', function () {
        var bunting_id = $(this).data('id');
        if (bunting_id != '') {
            AlertPopup('delete-bunting', bunting_id, $(this), 'bunting-counter', '');
        }
        else {
            $(this).parent().remove();
            $('#upldbb').removeClass('hidden');
            $('#bunting-counter').attr('data-row-count', function (i, val) {
                return val * 1 - 1
            });
        }
    });
    /*remove upload bunting */
    $(".remupldbunting").on('click', function () {
        var bunting_id = $(this).data('id');
        if (bunting_id != '') {
            AlertPopup('delete-bunting', bunting_id, $(this), 'bunting-counter', '');
        }
        else {
            $(this).parent().remove();
            $('#upldbb').removeClass('hidden');
            $('#bunting-counter').attr('data-row-count', function (i, val) {
                return val * 1 - 1
            });
        }
    });
    /* album video banner */

    $("#append-v-or-b").on('click', '.rem-v-or-b', function () {
        var banner_id = $(this).data('id');
        if (banner_id != '') {
            AlertPopup('delete-banner', banner_id, $(this), 'video-counter', '');
        } else {
            $(this).parent().parent().remove();
            $('#upld-v-or-b').removeClass('hidden');
            $('#video-counter').attr('data-row-count', function (i, val) {
                return val * 1 - 1
            });
        }
    });

    /* profile about us */
    $("#addABlayer").click(function () {
        rowNum++;
        $("#append-about-field").append('<div class="profile-field"> <div class="col-sm-2 profile-photo"   > <img  id="preview-img' + rowNum + '" class="preview-img img-responsive"  src="#" alt="Add Photo" /> <div class="inputBtnSection">  <input id="uploadFile' + rowNum + '" class="disableInputField" placeholder="Upload Passport Photo" disabled="disabled" /> <label class="fileUpload"><input data-imgID="' + rowNum + '"   id="uploadBtn' + rowNum + '" type="file" class="upload" /><span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span></label>    </div></div>        <div class="col-sm-9">        <div class="form-group">        <label class="col-sm-2 control-label">Name</label>        <div class="col-sm-8">        <input type="text" class="form-control" >        </div>              </div>        <div class="form-group">        <label class="col-sm-2 control-label">Position</label>    <div class="col-sm-8">          <input type="text" class="form-control" >          </div>     </div>        <div class="form-group mbot0">        <label class="col-sm-2 control-label">Description</label>        <div class="col-sm-10">        <textarea class="form-control" ></textarea>        </div>        </div>        </div>    <div class="col-sm-1">        <a class="text-danger pull-right remABlayer" href="javascript:void(0);"><i class="fa fa-minus-circle"></i></a>        </div>      <div class="clearfix"></div>        </div>        ');

        $("#uploadBtn" + rowNum).change(function () {
            var id = $(this).attr("data-imgID");
            readURLSingle(this, 'preview-img' + id);
        });

    });
    $("#append-about-field").on('click', '.remABlayer', function () {
        $(this).parent().parent().remove();
    });
    /* profile certificate */
    $("#addPFlayer").click(function () {
        rowNum++;
        $("#append-profile-field").append('    <div class="profile-field">        <div class="col-sm-2 profile-photo"> <img  id="preview-img' + rowNum + '" class="preview-img img-responsive"  src="#" alt="Add Photo" /><div class="inputBtnSection">  <input id="uploadFile' + rowNum + '" class="disableInputField" placeholder="Upload Passport Photo" disabled="disabled" /> <label class="fileUpload"><input data-imgID="' + rowNum + '" id="uploadBtn' + rowNum + '"  type="file" class="upload" /><span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span></label>    </div></div>        <div class="col-sm-9">        <div class="form-group">        <label class="col-sm-2 control-label">Name</label>        <div class="col-sm-8">        <input type="text" class="form-control" >        </div>              </div>        <div class="form-group">        <label class="col-sm-2 control-label">Date Awarded</label>    <div class="col-sm-4">        <div class="input-group date" id="datetimepicker' + rowNum + '">        <input type="text" class="form-control" data-date-format="YYYY/MM/DD"/>        <span class="input-group-addon">        <span class="glyphicon glyphicon-calendar"></span>        </span>        </div>        </div>     </div>        <div class="form-group mbot0">        <label class="col-sm-2 control-label">Description</label>        <div class="col-sm-10">        <textarea class="form-control" ></textarea>        </div>        </div>        </div>    <div class="col-sm-1">        <a class="text-danger pull-right remPFlayer" href="javascript:void(0);"><i class="fa fa-minus-circle"></i></a>        </div>      <div class="clearfix"></div>        </div>        ');

        $("#uploadBtn" + rowNum).change(function () {
            var id = $(this).attr("data-imgID");
            readURLSingle(this, 'preview-img' + id);
        });

        $('#datetimepicker' + rowNum).datetimepicker({format: 'YYYY-MM-DD'});

    });
    $("#append-profile-field").on('click', '.remPFlayer', function () {
        $(this).parent().parent().remove();
    });
    /* clone of voucher sch*/
    $("#copySchT").click(function () {
        rowNum++;

        var schHeader = '';
        schHeader = ('<div class="append-schT margin-top"><a class="badge badge-close remthisSch">X</a><div class="schPlace"><div class="col-xs-12">Month <strong style="padding-left:20px">' + $("#m").val() + '</strong><strong class="pull-right">' + $("#y").val() + '</strong></div><label class="col-xs-12 control-label">Date</label><div class="clearfix"></div><div class="margin-top"><div class="col-xs-1">From</div> <input type="text" value="1" size="3" class="text-center"> &nbsp; to &nbsp; <input type="text" value="15" size="3" class="text-center"></div></div><div class="clearfix"></div><div class="table-responsive" id="report' + rowNum + '"></div></div>');
        $("#append-schT").append(schHeader);
        $("#schT").clone().appendTo("#append-schT #report" + rowNum).removeAttr('id').find('input').prop('disabled', true).css('border', 'none').css('background', 'transparent').removeAttr('id');
        $("#report" + rowNum).find('td > #addnewSch').parent().remove();
        $("#report" + rowNum).find('td > .remnewSch').parent().remove();
        $("#report" + rowNum).find('td > .subtotal').parent().remove();
        $("#report" + rowNum + " tr:last").remove();

    });

    $("#append-schT").on('click', '.remthisSch', function () {
        $(this).parent().remove();
    });

    $('input.myr-price, input.retailSave, input.delivery_prices, input.delivery_require, input.delivery_pricesb2b, input#rPrice, input#oPrice').number(true, 2, '.', '' );
    $('input.delivery_require2').number(true, 0, '.', '' );

	// Quantity is integer instead of float!
    $('input#quantity_v').number(true, 0, '.', '');
    $('input#quantity_vb2b').number(true, 0, '.', '');

	$('.delivery_require').on('keyup', function () {
		var del_width = $("#del_width").val();
		var del_lenght = $("#del_lenght").val();
		var del_height = $("#del_height").val();
		var del_weight = $("#del_weight").val();
		if(del_weight != "" && del_height != "" && del_lenght != "" && del_width != ""){
			del_width = parseFloat(del_width);		
			del_lenght = parseFloat(del_lenght);		
			del_height = parseFloat(del_height);		
			del_weight = parseFloat(del_weight);
			var cms_pricing = parseFloat($("#cms_pricing").val());
			var grs_pricing = parseFloat($("#grs_pricing").val());
			var mts_pricing = parseFloat($("#mts_pricing").val());	
			var total_pricing = (del_width * del_height * del_lenght * cms_pricing) + (del_weight * grs_pricing);
			$("#del_pricing").val(total_pricing).number(true, 2, '.', '' );
		} else {
			$("#del_pricing").val("0.00");
		}
	});
	
	$('.delivery_require_b2b').on('keyup', function () {
		var del_width = $("#del_width_b2b").val();
		var del_lenght = $("#del_lenght_b2b").val();
		var del_height = $("#del_height_b2b").val();
		var del_weight = $("#del_weight_b2b").val();
		if(del_weight != "" && del_height != "" && del_lenght != "" && del_width != ""){
			del_width = parseFloat(del_width);		
			del_lenght = parseFloat(del_lenght);		
			del_height = parseFloat(del_height);		
			del_weight = parseFloat(del_weight);
			var cms_pricing = parseFloat($("#cms_pricing_b2b").val());
			var grs_pricing = parseFloat($("#grs_pricing_b2b").val());
			var mts_pricing = parseFloat($("#mts_pricing_b2b").val());	
			var total_pricing = (del_width * del_height * del_lenght * cms_pricing) + (del_weight * grs_pricing);
			$("#del_pricing_b2b").val(total_pricing).number(true, 2, '.', '' );
		} else {
			$("#del_pricing_b2b").val("0.00");
		}
	});	
	
    $('#oPrice,#rPrice').on('keyup', function () {
        var rp = parseFloat($('#rPrice').val());
        var op = parseFloat($('#oPrice').val());
		//console.log(op);
		if(rp == 0){
			$('#alert_rprice').show();
		} else {
			$('#alert_rprice').hide();
		}
        var del = $('#del_malaysia_v').val();
        if(del == ""){
            del = 0;
        }
        if(op == ""){
            op = rp;
        }
		var res = 0;
        if(op > 0 && op <rp){
			res = ((rp - op) / rp) * 100;
		}
        if (parseFloat(op) == 0) {
             $('#oPrice').val(rp);
        }
        if(op != "" && parseFloat(op) != 0){
            $('#retail_amount').text(op).number(true, 2, '.', '' );
            $('#retail_total').text(parseFloat(op)+parseFloat(del)).number(true, 2, '.', '' );
        } else {
            $('#retail_amount').text(rp).number(true, 2, '.', '' );
            $('#retail_total').text(parseFloat(rp)+parseFloat(del)).number(true, 2, '.', '' );
        }
        if(res>99.99){res=99.99;}
        //if(!isNaN(res)) {
		if(op >= rp){
			res = 0;
			op = $('#oPrice').val(rp);
		}
        if (res > 0) {
			if(parseFloat(rp) == 0){
				$('#resultSave').text("N.A");
			} else {			
				$('#resultSave').text(res).number(true, 2, '.', '' );
			}
        } else {
			if(parseFloat(rp) == 0){
				$('#resultSave').text("N.A");
			} else {
				$('#resultSave').text(0).number(true, 2, '.', '' );
			}
        }
        //}
    });

     $('body').on('keyup', '.specialp', function() {
		 console.log("test");
        var rp = $('#rPrice').val();
        var sp = $(this).val();
        var res = ((rp - sp) / rp) * 100;
        var rel = $(this).attr("rel");
        //if(!isNaN(res)) {
        if (res > 0) {
            $('#savespecial' + rel).text(res).number(true, 2, '.', '' );
        } else {
            $('#savespecial' + rel).text(0).number(true, 2, '.', '' );
        }
        //}
    });

     $('body').on('keyup', '.wholesalep', function() {
        var rp = $('#rPrice').val();
        var sp = $(this).val();
        var rel = $(this).attr("rel");
        var res = 0;
        if(sp == ""){
            res = 0;
        } else {
            res = ((rp - sp) / rp) * 100;

        }
        //if(!isNaN(res)) {
        if (res > 0) {
            $('#savewholesale' + rel).text(res).number(true, 2, '.', '' );
        } else {
            $('#savewholesale' + rel).text(0).number(true, 2, '.', '' );
        }
        //}
    });

    $('#short_description').on('keyup', function () {
        var val = $(this).val();
        $('.description_p').html(val);
    });

    $('.specs').on('keyup', function () {
        var val = $(this).val();
        var rel = $(this).attr("rel");
        $('#'+rel+'_p').html(val);
    });

    $('#rPrice').on('keyup', function () {
        var val = $('#rPrice').val();
        $('.rPrice_p').text(val).number(true, 2, '.', '' );
		$('#retail_priceh').val(val);
        var op = $('#oPrice').val();
        if(op == ""){
            op = 0;
        }
        if(op == 0){
            $('#retail_amount').text(val).number(true, 2, '.', '' );
            var del = $('#del_malaysia_v').val();
            if(del == ""){
                del = 0;
            }
            $('#retail_total').text(parseInt(val)+parseInt(del)).number(true, 2, '.', '' );
        }
    });
    /* Commented out by zurez*/
  /*  $('#name_v').on('keyup', function () {
        var val = $('#name_v').val();
        $('.name_p').html(val);
    });*/

    $('#brand_v').on('change', function () {
        var val = $('#brand_v option:selected').text();
        $('.brand_p').html(val);
        $(this).removeClass('error');
        $(this).siblings('label.error').remove();
    });

    $('#subcat').on('change', function () {
        var val = $('#subcat option:selected').text();
        $('.subcat_p').html(val);
        $(this).siblings('label').remove();
        $(this).removeClass('error');
        $(this).siblings('label.error').remove();
    });

    $('#oPrice').on('keyup', function () {
        var val = $('#rPrice').val();
        var foo = $('#rPriceb2b').text(val).number(true, 2, '.', '' );
        foo = currentCurrency + ' ' + foo.text();
        $('#rPriceb2b').text(foo);

    });


    $('#del_malaysia_v').on('keyup', function () {
        var val = $('#del_malaysia_v').val();
        var rp = $('#rPrice').val();
        var op = $('#oPrice').val();
        if(val == ""){
            val = 0;
            $('#retail_delivery').text(0).number(true, 2, '.', '' );
        } else {
            $('#retail_delivery').text(val).number(true, 2, '.', '' );
        }
        if(op != "" && parseInt(op) != 0){
            $('#retail_amount').text(op).number(true, 2, '.', '' );
            $('#retail_total').text(parseInt(op)+parseInt(val)).number(true, 2, '.', '' );
        } else {
            $('#retail_amount').text(rp).number(true, 2, '.', '' );
            $('#retail_total').text(parseInt(rp)+parseInt(val)).number(true, 2, '.', '' );
        }
        $('#del_malaysia_p').html(val);
    });

  /*  $('#name_v').on('keyup', function () {
        var val = $('#name_v').val();
        $('#name_p').html(val);
    });*/

    $('#quantity_v').on('keyup', function () {
        var val = $('#quantity_v').val();

		// Quantity is only a integer
        $('.quantity_p').text(val).number(true, 0);
    });
	
	$('#quantity_vb2b').on('keyup', function () {
        var val = $('#quantity_vb2b').val();

		// Quantity is only a integer
        $('.quantity_ps').text(val).number(true, 0);
    });

    $('input.myr-price, #rPrice, #oPrice').on('keydown', checkValidationInteger);
    $("input.numeric").on('keypress', checkValidationNumeric);

    $("#addnewSch").click(function () {
        rowNum++;
        $('<tr><td class="saving"> <div class="input-group"><span class="input-group-addon">From</span><input type="text" id="timepicker' + rowNum + '"  class="form-control"></div></td><td><div class="input-group"><span class="input-group-addon">To</span><input type="text" id="timepickerr' + rowNum + '"  class="form-control"></div></div></td><td><div class="input-group"><span class="input-group-addon">'+currentCurrency+' </span><input type="text" class="form-control calInput myr-price"></div></td><td class="text-danger text-center"><span>0</span> %</td><td><input type="text" class="form-control numeric calInput" ></td><td>'+currentCurrency+' <span class="hide"></span> <span class="subtotal pull-right">100</span></td><td><a  href="javascript:void(0);" class="remnewSch text-danger"><i class="fa fa-minus-circle"></i></a></td></tr>').insertAfter("#schT tr:first");
        $('input.myr-price').number(true, 2, '.', '' );
        $('#timepicker' + rowNum + ', #timepickerr' + rowNum).timepicki();
        $("input.numeric").on('keypress', checkValidationNumeric);

    });
    $('#schT')
        .on('keyup', 'input.calInput', calCulations);

    $("#schT").on('click', '.remnewSch', function () {
        $(this).parent().parent().remove();
    });

    $("#addsubC").click(function () {

        $("#appendsubC").append('<div class="form-group"> <div class="col-sm-4 col-sm-offset-3"><input type="text" class="form-control" ></div><div class="col-xs-1">    <a  href="javascript:void(0);"  class="remsubC text-danger"><i class="fa fa-minus-circle"></i></a></div></div>');
    });

    $("#appendsubC").on('click', '.remsubC', function () {
        $(this).parent().parent().remove();
    });

    $("#addwholesale").click(function () {
        $("#wsreseller").append(' <div class="form-group">    <div class="col-sm-11 col-xs-10">      <input type="text" name="resellers" class="form-control" >    </div>   <div class="col-xs-1 row">   <a  href="javascript:void(0);"  class="btn btn-default remwholesale text-danger"><i class="fa fa-minus-circle"></i></a>   </div>  </div>');
    });
    $("#wsreseller").on('click', '.remwholesale', function () {
        $(this).parent().parent().remove();
    });
    $('#wrpTable, #sppTable')
        .on('keyup', 'input', calc);

    $("#wfunit0").val(1);
    $("#spwfunit0").val(1);
    $("#wfunitn0").val(1);
    $("#spwfunitn0").val(1);

    $('body').on('keyup', '.wunit', function() {
    // do something
        var current = $(this).attr("rel");
        var next = parseFloat(current) + 1;
        var val = $(this).val();
        var nextval = parseFloat(val) + 1;
        $("#wfunit" + next).val(nextval);
        $("#wfunitn" + next).val(nextval);
        $("#wunitn" + current).val(val);
    });

    $('body').on('keyup', '.spwunit', function() {
    // do something
        var current = $(this).attr("rel");
        var next = parseFloat(current) + 1;
        var val = $(this).val();
        var nextval = parseFloat(val) + 1;
        $("#spwfunit" + next).val(nextval);
        $("#spwfunitn" + next).val(nextval);
        $("#spwunitn" + current).val(val);
    });	
	
    $('body').on('keyup', '.wholesale', function() {
    // do something
        var current = $(this).attr("rel");
        var varprice = $(this).val();
        $("#wholesale" + current).val(varprice);
    });

    var optionsnew = {

      url: "/jsonusersid",

      getValue: "name",

      list: {
        match: {
          enabled: true
        },
        onSelectItemEvent: function() {
            var current = $('#currentspp').val();
            var userid = $("#username" + current).getSelectedItemData().id;
            var username = $("#username" + current).getSelectedItemData().username;
            //alert(username);
            $("#usernameval" + current).val(username);
            $("#userid" + current).val(userid);
        }

      }
    };


    $('body').on('keyup', '.usernamett', function() {
    // do something
        var current = $(this).attr("rel");
        $("#currentspp").val(current);
    });

    $('body').on('keyup', '.specialprice', function() {
    // do something
        var current = $(this).attr("rel");
        var varprice = $(this).val();
        $("#special" + current).val(varprice);
    });

   /* $('#sprice0').on('keyup', function() {
    // do something
        var varprice = $(this).val();
        $("#special0").val(varprice);
    }); */

    $("#username0").easyAutocomplete(optionsnew);
    $(".easy-autocomplete").attr( "style", "width: 100%" );
    $(".easy-autocomplete-container").attr( "style", "right: auto; z-index: 10" );

    $("#addspp").click(function () {
        var spps = $("#specialprices").val();
        spps = parseInt(spps) + 1;
        $("#specialprices").val(spps);
        $("#sppTable > tbody").append('');
        $('input.myr-price').number(true, 2, '.', '' );
        $("input.numeric").on('keypress', checkValidationNumeric);
        $("#username" + spps).easyAutocomplete(optionsnew);
    });
    $("#sppTable").on('click', '.remspp', function () {
        id=$(this).attr('rel');
		$(this).parent().parent().remove();
		$("#special" + id).val("0");
		$("#userid" + id).val("0");	
		$("#spwfunitn" + id).val("0");
		$("#spwunitn" + id).val("0");		
    });

    $("#uploadBtnDD").change(function () {
        $("#uploadFileDD").val($("#uploadBtnDD").val());
    });
    $("#uploadBtnBrand").change(function () {
        $("#uploadFileBrand").val($("#uploadBtnBrand").val());
    });	
    $("#uploadBtnBR").change(function () {
        $("#uploadFileBR").val($("#uploadBtnBR").val());
    });
	$(document).delegate( '.ourl', "blur",function (event) {
		var thisval = $(this);
		var rel = $(this).attr('rel');
		var oid = $(this).attr('oid');
		if(thisval.val() == ""){
			toastr.warning("URL cannot be empty");
		} else {
			var counter = 0;
			$(".ourl").each(function() {
				console.log($(this).val());
				console.log(thisval.val());
				var orel = $(this).attr('rel');
				if(orel == rel){
				} else {
					if($(this).val() == thisval.val()){
						counter++;
					}
				}
			});
			if(counter == 0){
				$.ajax({
					type: "get",
					url: JS_BASE_URL + '/validate_url/' + thisval.val() + '/' + oid,
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData == "0") {
							toastr.warning("This URL is already in use");
							thisval.addClass("error");
						} else {
							$("#hourl" + rel).val(thisval.val());
							thisval.removeClass("error");
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});					
			} else {
				toastr.warning("This URL is already in use");
				thisval.addClass("error");
			}
			
		}

	});
	$(document).delegate( '.ourl', "keyup",function (event) {
//	$(".ourl").keyup(function () {
		//console.log("HILA");
		$(this).removeClass("error");
		var mtext = $(this).val();
		var rel = $(this).attr('rel');
		if(mtext == ""){
			$("#urlresult" + rel).hide();
		//	$("#hourl" + rel).val("");
		} else {
			realurl = mtext.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'');
			realurl = realurl.replace(/\s/g,'-');
		//	$("#hourl" + rel).val(realurl);
			//$("#urlresult" + rel).html("URL:https://opensupermall.com/o/" + realurl);
			$(this).val(realurl);
		}
	});
	$("#addOS").click(function () {
		var brand_count = 0;
		$( ".brandNames" ).each(function() {
			brand_count++;
		});
		
		var oshop_count = 0;
		$( ".oshop_brand" ).each(function() {
			oshop_count++;
		});
		
		if(oshop_count >= brand_count){
			toastr.warning("You must add a new brand to create another O-Shop");
		} else {
			var rowNum = parseInt($("#current_oshop").val());
			rowNum++;
			$("#current_oshop").val(rowNum);
			$("#oshopsdetail").append('<div id="oshop'+rowNum+'"><input type="hidden" value="0" name="oshop_ids[]" id="oshop_ids'+rowNum+'" /><div class="col-sm-2"><select class="oshop_brand" rel="'+rowNum+'" name="oshop_brand_name[]" id="oshop_brands'+rowNum+'" class="form-control" necessary="necessary" ></select></div><input type="hidden" value="" name="oshop_name[]" id="oname'+rowNum+'" rel="'+rowNum+'" /><div class="col-sm-2"><p align="center">Pending</p></div><div class="col-sm-3"><p align="center">N.A</p></div><div class="col-sm-4"><input type="hidden" name="hoshop_url[]" id="hourl'+rowNum+'" value="" /><span class="urlresult" id="urlresult'+rowNum+'"></span></div><div class="col-sm-1"><a href="javascript:void(0);" class="remOS text-danger" rel="'+rowNum+'"><i class="fa fa-minus-circle fa-2x"></i></a></div><div class="clearfix"></div>');
			$("#oshop_brands0").clone().appendTo('#oshop_brands'+rowNum);
			$('#oshop_brands'+rowNum).html('<select class="form-control validator" name="oshop_brand_name[]" id="oshop_brands'+rowNum+'">' + $('#oshop_brands0').html() + '</select>');
			$('#oshop_brands'+rowNum).select2();
		}
	});
	
	$("#shop").on('click', '.remOS', function () {
        var rel = $(this).attr('rel');
		$("#oshop" + rel).remove();
    });
	
	$("#shop").on('change', '.oshop_brand', function () {
		var rel = $(this).attr('rel');
		var oorel = $("#oshop_brands" + rel + " option:selected").text();
		$("#oname" + rel).val($("#oshop_brands" + rel + " option:selected").text());
		realurl = oorel.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'');
		realurl = realurl.replace(/\s/g,'-');
		$("#hourl" + rel).val(realurl);
		$.ajax({
			type: "get",
			url: JS_BASE_URL + '/validate_url2/' + $("#hourl" + rel).val(),
			cache: false,
			success: function (responseData, textStatus, jqXHR) {
					$("#urlresult" + rel).html("URL:https://opensupermall.com/o/" + responseData);
					$("#urlresult" + rel).show();
					$("#hourl" + rel).val(responseData);
			},
			error: function (responseData, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});	

		
	});
	
    $(".addCI").click(function () {
		var rowNum = parseInt($("#valaddCI").val());
        rowNum++;
		$("#valaddCI").val(rowNum)
		$("#emailenable").show();
		 $("#ciDetail").append('  <div class="form-group" id="ci'+rowNum+'">     ' +
            '<label class="col-sm-1"><p align="center"><input type="checkbox" checked name="checkemail[]" style="width: 20px;  height: 20px;" value="'+rowNum+'" class="check_email" rel="'+rowNum+'"  /></p></label>    ' +
            '<div class="col-sm-3"><input type="text" class="form-control validator" name="contactname[]" placeholder="eg: John Doe"></div>  <div class="col-sm-3">      ' +
            '<input type="email" class="form-control validator" name="contactemail[]" placeholder="eg: test@opensupermall.com">    </div>    <div class="col-sm-1">      ' +
            '<a href="javascript:void(0);" class="remCI text-danger" rel="'+rowNum+'"><i class="fa fa-minus-circle fa-2x"></i></a>    </div><div class="clearfix"></div> </div>');
	});
	 $(document).delegate( '.remCI', "click",function (event) {
	//$(".remCI").on('click', '.remDD', function () {
        $(this).parent().parent().remove();
    });	
	
    $("#addDD").click(function () {
        var rowNum = parseInt($("#valaddDD").val());
        rowNum++;
		$("#valaddDD").val(rowNum);

        $("#dirDetail").append('  <div class="form-group">     ' +
            '<label class="col-sm-1 control-label">&nbsp;</label>    ' +
            '<div class="col-sm-2">      ' +
            '<input type="text" class="form-control validator" name="directors[]" placeholder="Type the Name">    </div>    <div class="col-sm-3">      ' +
            '<input type="text" class="form-control validator" name="nric[]" placeholder="Type the NRIC or Passport Number"></div><div id="dcountryAppend" class="col-sm-2"></div><div class="col-sm-4">        <div class="inputBtnSection">   ' +
            '<input id="uploadFileDD' + rowNum + '" class="disableInputField validator" placeholder="Upload Passport Photo" disabled="disabled" />  <label class="fileUpload">      ' +
            '<input id="uploadBtnDD' + rowNum + '" id-attr="' + rowNum + '"  name="directorImages[]"  type="file" class="upload validator" required/>       <span class="uploadBtn">Upload </span>  </label>        </div> ' +
            '<a href="javascript:void(0);" class="remDD text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>    </div>  </div> <input name="uploadFileid[]" value="0" type="hidden"  /> </div>');
        //$("#dcountry").clone().appendTo('#dcountryAppend');
        $("#dcountryAppend").html('<select class="form-control validator" name="dcountry[]" id="dcountry'+rowNum+'">' + $('#dcountry').html() + '</select>');
        $('#dcountryAppend').removeAttr('id');
        $('#dcountry'+rowNum).select2();

        $("#uploadBtnDD" + rowNum).change(function () {
            var id = $(this).attr('id-attr');
            $("#uploadFileDD" + id).val($(this).val());
        });
    });
	
    $("#addDDs").click(function () {
        var rowNum = parseInt($("#valaddDD").val());
        rowNum++;
		$("#valaddDD").val(rowNum);

        $("#dirDetail").append('  <div class="form-group">     ' +
            '<label class="col-sm-3 control-label">&nbsp;</label>    ' +
            '<div class="col-sm-3">      ' +
            '<input type="text" class="form-control validator" name="directors[]" placeholder="Type the Name"></div><div class="col-sm-6" ;">' +
            '<a href="javascript:void(0);" class="remDD text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>    </div>  </div> <input name="uploadFileid[]" value="0" type="hidden"  /> </div>');
        //$("#dcountry").clone().appendTo('#dcountryAppend');
       /* $("#dcountryAppend").html('<select class="form-control validator" name="dcountry[]" id="dcountry'+rowNum+'">' + $('#dcountry').html() + '</select>');*/
       // $('#dcountryAppend').removeAttr('id');
      //  $('#dcountry'+rowNum).select2();

       /* $("#uploadBtnDD" + rowNum).change(function () {
            var id = $(this).attr('id-attr');
            $("#uploadFileDD" + id).val($(this).val());
        });*/
    });	

    $("#dirDetail").on('click', '.remDD', function () {
        $(this).parent().parent().remove();
    });

    $("#addBS").click(function () {
        var rowNum = parseInt($("#valaddBS").val());
        rowNum++;
		$("#valaddBS").val(rowNum);
        //$("#businessReg").append('<div class="form-group">  <div class="col-sm-4 col-sm-offset-8">     <div class="inputBtnSection">  '+
        $("#businessReg").append(' <div class="col-sm-12"> <div class="inputBtnSection">  ' +
            '<input id="uploadFileBR' + rowNum + '" class="disableInputField validator" placeholder="Upload Document" disabled="disabled" />    <label class="fileUpload">' +
            '<input name="uploadFileDoc[]" value="0" type="hidden"  />' +
            '       <input id="uploadBtnBR' + rowNum + '" id-attr="' + rowNum + '" name="Regupload_attachment[]"  type="file" class="upload validator" />       <span class="uploadBtn">Upload </span>  </label>      ' +
            '  </div>  <a  href="javascript:void(0);"  class="remBS text-danger"><i class="fa fa-minus-circle fa-2x"></i></a> </div>  </div>  ');

        $("#uploadBtnBR" + rowNum).change(function () {
            var id = $(this).attr('id-attr');
            $("#uploadFileBR" + id).val($(this).val());
        });
    });

    $("#businessReg").on('click', '.remBS', function () {
        $(this).parent().remove();
    });

	$("#addWSlog").click(function () {

        $("#website").append(' <div class="form-group"> <label class="col-sm-3 control-label">&nbsp; </label>    <div class="col-sm-4 col-xs-10">      <input type="text" class="form-control" name="website[]" placeholder="http://www.abc.com.my">    </div>   <div class="col-xs-1" style="padding-left:0">   <a  href="javascript:void(0);"  class="remWS text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>   </div>  </div>');
    });
	
    $("#addWS").click(function () {

        $("#website").append(' <div class="form-group"> <label class="col-sm-2 control-label">&nbsp; </label>    <div class="col-sm-4 col-xs-10">      <input type="text" class="form-control" name="website[]" placeholder="http://www.abc.com.my">    </div>   <div class="col-xs-1" style="padding-left:0">   <a  href="javascript:void(0);"  class="remWS text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>   </div>  </div>');
    });

    $('body').on('click', '.remWS', function () {
        $(this).parent().parent().remove();
    });
	
	$("#addSMlog").click(function () {

        $("#socialMedia").append(' <div class="form-group">  <label class="col-sm-3 control-label">&nbsp; </label> <div class="col-sm-4 col-xs-10">      <input type="text" class="form-control" name="social[]" placeholder="http://www.abc.com.my">    </div> <div class="col-xs-1" style="padding-left:0">   <a  href="javascript:void(0);"  class="remSM text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>    </div>  </div>');
    });
	
    $("#addSM").click(function () {

        $("#socialMedia").append(' <div class="form-group">  <label class="col-sm-2 control-label">&nbsp; </label> <div class="col-sm-4 col-xs-10">      <input type="text" class="form-control" name="social[]" placeholder="http://www.abc.com.my">    </div> <div class="col-xs-1" style="padding-left:0">   <a  href="javascript:void(0);"  class="remSM text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>    </div>  </div>');
    });

    $('body').on('click', '.remSM', function () {
        $(this).parent().parent().remove();
    });

	$("#addEcomlog").click(function () {

        $("#currEcom").append(' <div class="form-group"> <label class="col-sm-3 control-label">&nbsp; </label>  <div class="col-sm-4 col-xs-10">      <input type="text" class="form-control" name="ecom_site[]" placeholder="http://www.abc.com.my">    </div>  <div class="col-xs-1" style="padding-left:0">   <a  href="javascript:void(0);"  class="remEcom text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>    </div>  </div>');
    });
	
	
    $("#addEcom").click(function () {

        $("#currEcom").append(' <div class="form-group"> <label class="col-sm-2 control-label">&nbsp; </label>  <div class="col-sm-4 col-xs-10">      <input type="text" class="form-control" name="ecom_site[]" placeholder="http://www.abc.com.my">    </div>  <div class="col-xs-1" style="padding-left:0">   <a  href="javascript:void(0);"  class="remEcom text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>    </div>  </div>');
    });
	
	$("#addCap").click(function () {
		var currentCap = parseInt($("#currentCap").val());
		var beforeCap = currentCap - 1;
		console.log(beforeCap);
		$("#currCap").append(' <div class="form-group"> <label class="col-sm-2 control-label">&nbsp; </label>  <div class="col-sm-4 col-xs-10">     <select name="capabilities[]" id="capabilities'+currentCap+'" class="capabilities">' + $("#capabilities" + beforeCap).html() + ' </select>   </div>  <div class="col-xs-1" style="padding-left:0">   <a  href="javascript:void(0);"  class="remCap text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>    </div>  </div>');
		$("#capabilities"+currentCap).select2();
		$("#currentCap").val(currentCap + 1);
	   
    });

    $('body').on('click', '.remEcom', function () {
        $(this).parent().parent().remove();
    });

	$('body').on('click', '.remCap', function () {
        $(this).parent().parent().remove();
    });
	
    $("#addBD").click(function () {
		var rowNum = parseInt($("#valaddBD").val());
		var showcheck = parseInt($("#showcheck").val());
        rowNum++;		
		$("#valaddBD").val(rowNum);
		if(showcheck == 1){
			$("#brandDetail").append(' <div class="form-group"><div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;"><select class="form-control brandselect brandNames" name="brand_name[]">' + $('#brandNames').html() + '</select></div><div class="col-sm-2 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;"><select class="form-control brandselect" name="brand_relationship[]">' + $('#brandRelationship').html() + '</select></div><div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;"><select class="form-control brandselect" name="subcat_name[]">' + $('#subcatNames').html() + '</select></div><div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;"><div class="inputBtnSection"> <input id="uploadFileBrand'+rowNum+'" class="disableInputField  " value="" placeholder="Upload Document" size="15"  /><input type="hidden" name="brand_ids[]" value="0" /><label class="fileUpload"><input id="uploadBtnBrand'+rowNum+'" id-attr="' + rowNum + '" name="Brandsupload_attachment[]"  type="file" class="upload" /><span class="uploadBtn">Upload </span></label> </div></div><div class="col-xs-1" style="padding-left:0">    <a  href="javascript:void(0);"  class="remBD text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" style="width: 20px;  height: 20px;" value="1" class="check_brand" rel="0"  /><input type="hidden" value="0" id="checkbrand0" name="official_distributorship[]" />   </div>  </div>');			
		} else {
			$("#brandDetail").append(' <div class="form-group"><div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;"><select class="form-control brandselect brandNames" name="brand_name[]">' + $('#brandNames').html() + '</select></div><div class="col-sm-2 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;"><select class="form-control brandselect" name="brand_relationship[]">' + $('#brandRelationship').html() + '</select></div><div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;"><select class="form-control brandselect" name="subcat_name[]">' + $('#subcatNames').html() + '</select></div><div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;"><div class="inputBtnSection"> <input id="uploadFileBrand'+rowNum+'" class="disableInputField  " value="" placeholder="Upload Document" size="15"  /><input type="hidden" name="brand_ids[]" value="0" /><label class="fileUpload"><input id="uploadBtnBrand'+rowNum+'" id-attr="' + rowNum + '" name="Brandsupload_attachment[]"  type="file" class="upload" /><span class="uploadBtn">Upload </span></label> </div></div><div class="col-xs-1" style="padding-left:0">    <a  href="javascript:void(0);"  class="remBD text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>    </div>  </div>');			
		}

		$(".brandselect").select2();
        $("#uploadBtnBrand" + rowNum).change(function () {
            var id = $(this).attr('id-attr');
            $("#uploadFileBrand" + id).val($(this).val());
        });		

    });

   $(document).delegate( '.remBD', "click",function (event) {
  // $("body").on('click', '.remBD', function () {
	//	alert("fsdafsdaf");
		_Parent = $(this).parent().parent();
		var brand = _Parent.find('.brandNames').find('option:selected').text();
		console.log(brand);
		var canremove = true;
		$( ".oshop_brand" ).each(function() {
		//   console.log("More");
			if($(this).find('option:selected').text() == brand){
				canremove = false;
			}
		});
		if(canremove){
			$(this).parent().parent().remove();
			var html = "<option value=''>Please Select</option>";
			$( ".brandNames" ).each(function() {
			//   console.log("More");
			   html += "<option value='" + $(this).val() +"'>" + $(this).find('option:selected').text() + "</option>";
			});
			console.log(html);
			$(".oshop_brand").html(html);
		} else {
			toastr.error("You can't remove this brand because there is an existing O-Shop");
		}
    });


    $("#uploadBtnRem").change(function () {
        $("#uploadFileRem").val($("#uploadBtnRem").val());
    });
    $("#addRem").click(function () {
        var rowNum = parseInt($("#remfiles").val());
		console.log($("#remfiles").val());
        rowNum++;
        $("#remarksattach").append(' ' +
            '<div class="form-group">' +
            '<div class="col-sm-9  col-sm-offset-3  col-xs-12">    ' +
            '<div class="inputBtnSection">' +
            '<input id="uploadFileRem' + rowNum + '" class="disableInputField validator" name="uploadFileRem[]"  placeholder="Add New Attachment" /> ' +
            '<label class="fileUpload">' +
            '<input id="uploadBtnRem' + rowNum + '" id-attr="' + rowNum + '" type="file" name="Remarksupload_attachment[]" class="upload validator" />  ' +
            '<span class="uploadBtn">Upload </span> ' +
            '</label>     ' +
            '</div> ' +
            '<a  href="javascript:void(0);"  class="remRem text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>  ' +
            '</div>  ' +
            '</div>'
        );
		$("#remfiles").val(rowNum);
        $("#uploadBtnRem" + rowNum).change(function () {
            var id = $(this).attr('id-attr');
            $("#uploadFileRem" + id).val($(this).val());
        });

    });
	
	$(document).delegate( '.remRemn', "click",function (event) {
   // $("#remarksattach").on('click', '.remRem', function () {
        $(this).parent().remove();
    });
	
	$(document).delegate( '.remRem', "click",function (event) {
   // $("#remarksattach").on('click', '.remRem', function () {
        $(this).parent().parent().remove();
    });

    //plugin bootstrap minus and plus
    $('.btn-number').click(function (e) {
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());

        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {

                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });


    $('.input-number').focusin(function () {
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function () {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            // alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
            $(this).parents('.input-group').after("<label class='error'> The minimum value is 1 </label>");
            $('.xer').delay(500).fadeOut("slow");
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            // alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
            $(this).parents('.input-group').after("<label class='error xer'> The maximum value has reached </label>");
            $('.xer').delay(500).fadeOut("slow");
        }


    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    function calCulations() {
        $('#schT tr:has(.saving)').each(function (i, v) {
            var $cel = $(v.cells);
            var $quantity = $cel.eq(4).find('input').val();
            var $price = $cel.eq(2).find('input').val();
            var $opr = $('#oPrice').val()
            var $ssavings = ($opr - $price) / $opr * 100;
            if ($ssavings > 0) {
                $cel.eq(3).find('span').text($ssavings).number(true, 2, '.', '' );
            } else {
                $cel.eq(3).find('span').text(0).number(true, 2, '.', '' );
            }
            //   alert($ssavings)
            var $total = $price * $quantity;
            if (!isNaN($total)) {
                $cel.eq(-2).find('span.hide').text($total);
                $cel.eq(-2).find('span.subtotal').text($total).number(true, 2, '.', '' );
                var sum = 0.0;
                $('span.hide').each(function () {
                    sum += parseFloat($(this).text());
                });
                $('#nettotal').text(sum).number(true, 2, '.', '' );
            } else {
                //alert('Ops Error! Please only numbers');
            }
        });
    }

    function calc() {
        $('#wrpTable tr:has(.saving), #sppTable tr:has(.saving)').each(function (i, v) {

            var $cel = $(v.cells);
            var $unit = $cel.eq(0).find('input').val();
            var $price = $cel.eq(1).find('input').val();
            var $op = $('#oPrice').val();
            var $avg = $price / $unit;
            var $per = (($op - $avg) / $op) * 100;
            if (!isNaN($per)) {
                if ($per > 0) {
                    $cel.eq(-1).find('div.average').text($per).number(true, 2, '.', '' );
                } else {
                    $cel.eq(-1).find('div.average').text(0).number(true, 2, '.', '' );
                }
            } else {
                //alert('Ops Error! Please only numbers');
            }
        });
    }

    function checkValidationInteger(e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }

    function checkValidationNumeric(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    }

    function readURLSingle(input, id) {
        var fileTypes = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls'];  //acceptable file types

        if (input.files && input.files[0]) {
            var extension = input.files[0].name.split('.').pop().toLowerCase(), //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
            if (isSuccess) { //yes
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            else { //no
                alert('Warning: Type mismatch')
            }
                }
            }

    function closeInput(elm) {
        var value = $(elm).find('input').val();
        //   alert(value)
        $(elm).empty().text(value);

        $(elm).bind("dblclick", function () {
            newInput(elm);
        });
    }

    function newInput(elm) {
        $(elm).unbind('dblclick');

        var value = $(elm).text();
        $(elm).empty();

        $("<input>")
            .attr('type', 'text')
            .attr('class', 'form-control')
            .val(value)
            .blur(function () {
                closeInput(elm);
            })
            .appendTo($(elm))
            .focus();
    }

});

$(document).ready(function () {

	$("body").on("click", ".badge-checkbox", function () {
		var id = $(this).attr("data-id");
		console.log(id);
		
		if(parseInt(id) == 0){
			toastr.warning("Please, upload your signboard image first");
			$(this).attr("data-id");
			$(this).prop('checked', false);
		} else {
			var oshop_id  = $(".badge-select[data-id='" + id + "']").val();
			console.log(oshop_id);
			if(parseInt(oshop_id) == 0 || oshop_id == null){
				toastr.warning("Please, select signboard oshop first");
				$(this).prop('checked', false);
			} else {		
				var enabled = 0;
				if($(this).prop('checked')){
					$(".badge-checkbox[data-oshopid='" + oshop_id + "']").prop('checked', false);
					$(this).prop('checked', true);
					enabled = 1;
				}
				var spinner = $(this).parents('.main-parent').find('p');
				var userid = $("#useridsell").val();
				spinner.show();
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/update_current_signboard/'+id+'/'+userid + '/' + enabled,
					data: {id: id, userid: userid},
					contentType: false,
					cache: false,
					processData: false,
					success: function (responseData, textStatus, errorThrown) {
						console.log(responseData);
					   /* $('#MessageModel').modal('show');
						$('#Messagebody').html('<div class="alert alert-success" role="alert">' + responseData['message'] + '</div>');*/
						spinner.hide();
						$("#sign_success").show("slow");
						setTimeout(function(){ $("#sign_success").hide("slow"); }, 3000);
					   // $('#' + counterid).html(result + 1);
					  //  $('#' + counterid).attr('data-row-count', result + 1);
					  //  location.reload();
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
		}
	});
	
	$("body").on("change", ".badge-select", function () {
		var id = $(this).attr("data-id");
		if(parseInt(id) == 0){
			toastr.warning("Please, upload your signboard image first");
		} else {
			var oshop_id = $(this).val();
			if(oshop_id == "" || oshop_id == null){
				toastr.warning("Invalid Oshop!");
			} else {
				$(".badge-checkbox[data-id='" + id + "']").attr("data-oshopid",oshop_id);
				var userid = $("#useridsell").val();
				var spinner = $(this).parents('.main-parent').find('p');
				console.log(oshop_id);
				console.log(userid);
				spinner.show();
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/update_current_signboard_oshop/'+id+'/'+oshop_id+'/'+userid,
					data: {id: id, oshop_id: oshop_id, userid: userid},
					contentType: false,
					cache: false,
					processData: false,
					success: function (responseData, textStatus, errorThrown) {
						console.log(responseData);
					   /* $('#MessageModel').modal('show');
						$('#Messagebody').html('<div class="alert alert-success" role="alert">' + responseData['message'] + '</div>');*/
						spinner.hide();
						$("#sign_success").show("slow");
						setTimeout(function(){ $("#sign_success").hide("slow"); }, 3000);
					   // $('#' + counterid).html(result + 1);
					  //  $('#' + counterid).attr('data-row-count', result + 1);
					  //  location.reload();
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
		}
	});	


    //userCustomTheme();
    if ($('#end-line').length > 0) {
        var alias_end = document.getElementById('end-line');
        var object_end = alias_end.getContext("2d");
        object_end.beginPath();
        object_end.strokeStyle = "#FFFFFF";
        object_end.setLineDash([3]);
        object_end.moveTo(20, 8);
        object_end.lineTo(100, 8);
        object_end.stroke();

        object_end.beginPath();
        object_end.fillStyle = "#FFFFFF";
        object_end.arc(10, 8, 4, 0, Math.PI * 2, false);
        object_end.closePath();
        object_end.fill();

        object_end.beginPath();
        object_end.fillStyle = "#FFFFFF";
        object_end.arc(100, 8, 4, 0, Math.PI * 2, false);
        object_end.closePath();
        object_end.fill();

        var alias_end_1 = document.getElementById('end-line-1');
        var object_end_1 = alias_end_1.getContext("2d");
        object_end_1.beginPath();
        object_end_1.strokeStyle = "#FFFFFF";
        object_end_1.setLineDash([3]);
        object_end_1.moveTo(20, 8);
        object_end_1.lineTo(100, 8);
        object_end_1.stroke();

        object_end_1.beginPath();
        object_end_1.fillStyle = "#FFFFFF";
        object_end_1.arc(10, 8, 4, 0, Math.PI * 2, false);
        object_end_1.closePath();
        object_end_1.fill();

        object_end_1.beginPath();
        object_end_1.fillStyle = "#FFFFFF";
        object_end_1.arc(100, 8, 4, 0, Math.PI * 2, false);
        object_end_1.closePath();
        object_end_1.fill();

        var alias_end_2 = document.getElementById('end-line-2');
        var object_end_2 = alias_end_2.getContext("2d");
        object_end_2.beginPath();
        object_end_2.strokeStyle = "#FFFFFF";
        object_end_2.setLineDash([3]);
        object_end_2.moveTo(20, 8);
        object_end_2.lineTo(100, 8);
        object_end_2.stroke();

        object_end_2.beginPath();
        object_end_2.fillStyle = "#FFFFFF";
        object_end_2.arc(10, 8, 4, 0, Math.PI * 2, false);
        object_end_2.closePath();
        object_end_2.fill();

        object_end_2.beginPath();
        object_end_2.fillStyle = "#FFFFFF";
        object_end_2.arc(100, 8, 4, 0, Math.PI * 2, false);
        object_end_2.closePath();
        object_end_2.fill();

        var alias_end_3 = document.getElementById('end-line-3');
        var object_end_3 = alias_end_3.getContext("2d");
        object_end_3.beginPath();
        object_end_3.strokeStyle = "#FFFFFF";
        object_end_3.setLineDash([3]);
        object_end_3.moveTo(20, 8);
        object_end_3.lineTo(100, 8);
        object_end_3.stroke();

        object_end_3.beginPath();
        object_end_3.fillStyle = "#FFFFFF";
        object_end_3.arc(10, 8, 4, 0, Math.PI * 2, false);
        object_end_3.closePath();
        object_end_3.fill();

        object_end_3.beginPath();
        object_end_3.fillStyle = "#FFFFFF";
        object_end_3.arc(100, 8, 4, 0, Math.PI * 2, false);
        object_end_3.closePath();
        object_end_3.fill();

        var alias_end_4 = document.getElementById('end-line-4');
        var object_end_4 = alias_end_4.getContext("2d");
        object_end_4.beginPath();
        object_end_4.strokeStyle = "#FFFFFF";
        object_end_4.setLineDash([3]);
        object_end_4.moveTo(20, 8);
        object_end_4.lineTo(100, 8);
        object_end_4.stroke();

        object_end_4.beginPath();
        object_end_4.fillStyle = "#FFFFFF";
        object_end_4.arc(10, 8, 4, 0, Math.PI * 2, false);
        object_end_4.closePath();
        object_end_4.fill();

        object_end_4.beginPath();
        object_end_4.fillStyle = "#FFFFFF";
        object_end_4.arc(100, 8, 4, 0, Math.PI * 2, false);
        object_end_4.closePath();
        object_end_4.fill();

        var alias_end_5 = document.getElementById('end-line-5');
        var object_end_5 = alias_end_5.getContext("2d");
        object_end_5.beginPath();
        object_end_5.strokeStyle = "#FFFFFF";
        object_end_5.setLineDash([3]);
        object_end_5.moveTo(20, 8);
        object_end_5.lineTo(100, 8);
        object_end_5.stroke();

        object_end_5.beginPath();
        object_end_5.fillStyle = "#FFFFFF";
        object_end_5.arc(10, 8, 4, 0, Math.PI * 2, false);
        object_end_5.closePath();
        object_end_5.fill();

        object_end_5.beginPath();
        object_end_5.fillStyle = "#FFFFFF";
        object_end_5.arc(100, 8, 4, 0, Math.PI * 2, false);
        object_end_5.closePath();
        object_end_5.fill();

        var alias = document.getElementById('part-one');
        var object = alias.getContext("2d");
        object.beginPath();
        object.strokeStyle = "#FFFFFF";
        object.setLineDash([3]);
        object.moveTo(10, 10);
        object.lineTo(20, 10);
        object.stroke();

        object.beginPath();
        object.fillStyle = "#FFFFFF";
        object.arc(24, 10, 4, 0, Math.PI * 2, false);
        object.closePath();
        object.fill();

        object.beginPath();
        object.fillStyle = "#FFFFFF";
        object.arc(10, 155, 4, 0, Math.PI * 2, false);
        object.closePath();
        object.fill();

        object.beginPath();
        object.strokeStyle = "#FFFFFF";
        object.setLineDash([3]);
        object.moveTo(10, 10);
        object.lineTo(10, 150);
        object.stroke();


        var alias_second = document.getElementById('part-three');
        var object_second = alias_second.getContext("2d");
        object_second.beginPath();
        object_second.strokeStyle = "#FFFFFF";
        object_second.setLineDash([3]);
        object_second.moveTo(20, 20);
        object_second.lineTo(20, 30);
        object_second.stroke();

        object_second.beginPath();
        object_second.strokeStyle = "#FFFFFF";
        object_second.setLineDash([3]);
        object_second.moveTo(20, 30);
        object_second.lineTo(75, 30);
        object_second.stroke();

        object_second.beginPath();
        object_second.strokeStyle = "#FFFFFF";
        object_second.setLineDash([3]);
        object_second.moveTo(75, 30);
        object_second.lineTo(75, 100);
        object_second.stroke();

        object_second.beginPath();
        object_second.fillStyle = "#FFFFFF";
        object_second.arc(76, 100, 4, 0, Math.PI * 2, false);
        object_second.closePath();
        object_second.fill();

        var alias_four = document.getElementById('part-four');
        var object_four = alias_four.getContext("2d");
        object_four.beginPath();
        object_four.strokeStyle = "#FFFFFF";
        object_four.setLineDash([3]);
        object_four.moveTo(28, 10);
        object_four.lineTo(28, 35);
        object_four.stroke();

        object_four.beginPath();
        object_four.strokeStyle = "#FFFFFF";
        object_four.setLineDash([3]);
        object_four.moveTo(28, 35);
        object_four.lineTo(180, 35);
        object_four.stroke();

        object_four.beginPath();
        object_four.strokeStyle = "#FFFFFF";
        object_four.setLineDash([3]);
        object_four.moveTo(180, 35);
        object_four.lineTo(180, 120);
        object_four.stroke();

        object_four.beginPath();
        object_four.fillStyle = "#FFFFFF";
        object_four.arc(180, 120, 4, 0, Math.PI * 2, false);
        object_four.closePath();
        object_four.fill();

        var alias_six = document.getElementById('part-six');
        var object_six = alias_six.getContext("2d");
        object_six.beginPath();
        object_six.strokeStyle = "#FFFFFF";
        object_six.setLineDash([3]);
        object_six.moveTo(28, 20);
        object_six.lineTo(28, 35);
        object_six.stroke();

        object_six.beginPath();
        object_six.strokeStyle = "#FFFFFF";
        object_six.setLineDash([3]);
        object_six.moveTo(28, 35);
        object_six.lineTo(120, 35);
        object_six.stroke();

        object_six.beginPath();
        object_six.strokeStyle = "#FFFFFF";
        object_six.setLineDash([3]);
        object_six.moveTo(120, 35);
        object_six.lineTo(120, 100);
        object_six.stroke();

        object_six.beginPath();
        object_six.strokeStyle = "#FFFFFF";
        object_six.setLineDash([3]);
        object_six.moveTo(120, 100);
        object_six.lineTo(50, 100);
        object_six.stroke();

        object_six.beginPath();
        object_six.fillStyle = "#FFFFFF";
        object_six.arc(45, 100, 4, 0, Math.PI * 2, false);
        object_six.closePath();
        object_six.fill();

        var alias_eight = document.getElementById('part-eight');
        var object_eight = alias_eight.getContext("2d");
        object_eight.beginPath();
        object_eight.strokeStyle = "#FFFFFF";
        object_eight.setLineDash([3]);
        object_eight.moveTo(88, 20);
        object_eight.lineTo(88, 130);
        object_eight.stroke();

        object_eight.beginPath();
        object_eight.strokeStyle = "#FFFFFF";
        object_eight.setLineDash([3]);
        object_eight.moveTo(88, 130);
        object_eight.lineTo(30, 130);
        object_eight.stroke();

        object_eight.beginPath();
        object_eight.fillStyle = "#FFFFFF";
        object_eight.arc(30, 130, 4, 0, Math.PI * 2, false);
        object_eight.closePath();
        object_eight.fill();
    }
});
//for profile setting
function userCustomTheme()
{
    var a;
    $.ajax({
        type: "post",
        url: JS_BASE_URL + '/customTheme',
        cache: false,
        success: function (responseData, textStatus, jqXHR) {
            //console.log(responseData);
            $('.signboard-text').remove();
            $('#bunting_text').remove();
            ImplementSetting(responseData);
        },
        error: function (responseData, textStatus, errorThrown) {
            return errorThrown;
        }
    });
}
function ProfileSetting(id, identifier)
{
    $.ajax({
        type: "post",
        url: JS_BASE_URL + '/UpdateProfileSettings',
        data: {Id: id, Identifier: identifier},
        cache: false,
        success: function (responseData, textStatus, jqXHR) {
            if (identifier == 'vbanner_id') {
                window.location.reload();
            }
            ImplementSetting(responseData);
        },
        error: function (responseData, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}
//implement setting
function ImplementSetting(settings)
{
    if (settings['theme']) {
        $('body').css('background-color', settings['theme']['bg_color']);
        //$('body').css('font-family', settings['theme']['font_family']);
        $('body').css('color', settings['theme']['font_color']);
        //$('body').css('font-style', settings['theme']['font_style']);
        //$('body').css('font-size', settings['theme']['font_size']);
        $('body').css('background-image', 'url("' + JS_BASE_URL + '/' + settings['theme']['image'] + '")');
    }
    if (settings['theme_data']) {
        $('.signboard').css('background', 'url("' + JS_BASE_URL + '/images/signboard/' + settings['theme_data']['SignboardId'] + '/' + settings['theme_data']['Signboard'] + '")no-repeat scroll 0 0 / 100% 100%');
        $('#display-bunting').css('background', 'url("' + JS_BASE_URL + '/images/bunting/' + settings['theme_data']['BuntingId'] + '/' + settings['theme_data']['Bunting'] + '")no-repeat scroll 0 0 / 100% 100%');
        //$('#vthumbs').css('background-image','url("'+ JS_BASE_URL + '/images/vbanner/'+ settings['theme_data']['vBannerId'] +'/'+ settings['theme_data']['vBanner'] +'")');
    }

}

function addCustomTheme()
{
    var bg_color = $("#bg_color").val();
    var font_family = $("#font_family").val();
    var font_style = $("#font_style").val();
    var font_color = $("#font_color").val();
    var font_size = $("#font_size").val();

    $.ajax({
        type: "get",
        url: JS_BASE_URL + '/addCustomTheme',
        data: {
            bg_color: bg_color,
            font_family: font_family,
            font_style: font_style,
            font_color: font_color,
            font_size: font_size
        },
        cache: false,
        success: function (responseData, textStatus, errorThrown) {
            if (responseData != 0) {
            //    console.log(responseData);
                ImplementSetting(responseData);
            }
            else {

            }
        },
        error: function (responseData, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });

}
//upload signboard,bunting,vbanner
function uploadSBV(Url, type, obj, counterid)
{
    $(obj.val())
    {
        var file_data = obj.prop('files')[0];
        var filedata = new FormData();
        var rowid = obj.attr('data-rowid');
        filedata.append('file', file_data);
        filedata.append('rowid', rowid);
        if (rowid != '') {
            filedata.append('action', 'update');
        }
        else
        {
            filedata.append('action', 'add');
        }
		var userid = $("#useridsell").val();
		filedata.append('userid', userid);
		var spinner = obj.parents('.main-parent').find('p');
		spinner.show();
        $.ajax({
            type: "post",
            url: JS_BASE_URL + '/' + Url,
            data: filedata,
            contentType: false,
            cache: false,
            processData: false,
            success: function (responseData, textStatus, errorThrown) {
                customreadURLSingle(obj, type);
             //   console.log(responseData);
               /* $('#MessageModel').modal('show');
                $('#Messagebody').html('<div class="alert alert-success" role="alert">' + responseData['message'] + '</div>');*/
				$("#sign_success").show("slow");
				setTimeout(function(){ $("#sign_success").hide("slow"); }, 3000);
				spinner.hide();
				obj.parents('.main-parent').find('p').attr('data-id', responseData['id']);
                obj.parents('.main-parent').find('a').attr('data-id', responseData['id']);
                obj.parents('.main-parentn').find('input').attr('data-rowid', responseData['id']);
                obj.parents('.main-parentn').find('input').attr('data-id', responseData['id']);
				obj.parents('.main-parentn').find('input').show();
				obj.parents('.main-parentn').find('.badge-select').attr('data-rowid', responseData['id']);
                obj.parents('.main-parentn').find('.badge-select').attr('data-id', responseData['id']);
				obj.parents('.main-parentn').find('.select-all').show();
               // var result = parseInt($('#' + counterid).html());
               // $('#' + counterid).html(result + 1);
              //  $('#' + counterid).attr('data-row-count', result + 1);
              //  location.reload();
            },
            error: function (responseData, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }
}


function customreadURLSingle(input, id) {
    var fileTypes = {'image/jpg': 'jpg', 'image/jpeg': 'jpeg', 'image/png': 'png'};  //acceptable file types

    var extension = input[0].files[0].type;  //file extension from input file
    var isSuccess = fileTypes[extension];  //is extension in acceptable types
    if (isSuccess) { //yes
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input[0].files[0]);
    }
    else { //no
        alert('Warning: Type mismatch')
    }
}

function AlertPopup(Url, val, obj, id, subcat) {
    $('#MessageModel').modal('show');
    $('#Messagebody').html('<div class="modal-header">\
	<h4 class="modal-title"><strong>Alert!</strong></h4>\
	</div>\
	<div class="modal-body">\
		<p>Are you sure?</p>\
	</div>\
	<div class="modal-footer">\
		<button type="button" class="btn btn-danger" id="yes-delete" data-dismiss="modal">Yes</button>\
		<button type="button" class="btn btn-primary" id="no-del" data-dismiss="modal">No</button>\
	</div>');
    $('#yes-delete').on('click', function () {
        if (val == 'signboard_id') {
			console.log("TEST");
            ProfileSetting(Url, val);
            var sr = obj.attr('src');
            $('.signboard').css('background', 'url(' + sr + ') no-repeat scroll 0 0 / 100% 100%');
            $('.signboard-text').remove();
        }
        else if (val == 'bunting_id') {
            ProfileSetting(Url, val);
            var sr = obj.attr('src');
            $('.bunting').css('background', 'url(' + sr + ') no-repeat scroll 0 0 / 100% 100%');
            $('#bunting_text').remove();
        }
        else if (val == 'vbanner_id') {
            ProfileSetting(Url, val);
        }
        else {
            DeletePSBV(Url, val);
            if (Url == 'delete-pro') {
                var curr = parseInt($('.count' + subcat).html());
                $('.' + val[0]).remove();
                $('.count' + subcat).html(curr - 1);
                obj.parent().parent().remove();

                $('.' + val).remove();
            }
            if (Url == 'delete-banner') {
                obj.parent().parent().remove();

            } else {			
                obj.parents(".main-parentn").remove();
                obj.parent().remove();
            }
            $('#' + id).html(function (i, val) {
                return val * 1 - 1
            });
            $('#' + id).attr('data-row-id', function (i, val) {
                return val * 1 - 1
            });
        }
    });
}
function DeletePSBV(Url, val)
{
    $.ajax({
        type: "post",
        url: JS_BASE_URL + '/' + Url,
        data: {info: val},
        cache: false,
        success: function (responseData, textStatus, errorThrown) {
			$("#sign_del_success").show("slow");
			setTimeout(function(){ $("#sign_del_success").hide("slow"); }, 3000);
        },
        error: function (responseData, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}

function zeropad(num, size) {
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}

// New way to do summernote
document.addEventListener('DOMContentLoaded', function(){   
	var max_img_size = parseInt($("#max_img_size").val()) * 1048576;

	/* editor */
    $('#hyper_terms').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        maximumImageFileSize: max_img_size,     // Max Image Size
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				console.log(files);
				var error = validateImg(files);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "text","info-textarea");
				}
			}
        }
    });	
	
	/* editor */
    $('#info-textarea').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        maximumImageFileSize: max_img_size,     // Max Image Size
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				console.log(files);
				var error = validateImg(files);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "text","info-textarea");
				}
			}
        }
    });

    $('#info-textarea2').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
		maximumImageFileSize: max_img_size,     // Max Image Size
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				var error = validateImg(files);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "text2","info-textarea2");
				}
			}
        }
    });
	
    $('#info-textarea3').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
		maximumImageFileSize: max_img_size,     // Max Image Size
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				var error = validateImg(files);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "text3","info-textarea3");
				}
			}
        }
    });	
	
		$('#info-template').summernote({
			toolbar: [
			// [groupName, [list of button]]
				['insert', ['picture','video','table','hr']],
				['style', ['fontname','fontsize','color','bold','italic',
					'underline','strikethrough','superscript','subscript','clear']],
				['para', ['style','ul','ol','paragraph','height']],
				['misc', ['fullscreen','codeview','undo','redo','help']],
				],
			height: 300,     // set editor height
			minHeight: null, // set minimum height of editor
			maximumImageFileSize: max_img_size,     // Max Image Size
			maxHeight: null, // set maximum height of editor
			focus: true,     // set focus to editable area after initializing summernote
			airMode: false
		});		

    $('#info-details').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
		maximumImageFileSize: max_img_size,     // Max Image Size
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				var error = validateImg(files);
				console.log(editor);
				console.log(welEditable);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "details","info-details");
				}
			}
		}
    });

    $('#info-detailsb2b').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
		maximumImageFileSize: max_img_size,     // Max Image Size
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				var error = validateImg(files);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "detailsb2b","info-detailsb2b");
				}
			}
        }
    });
    
    $('#info-merchantpolicy').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
		maximumImageFileSize: max_img_size,     // Max Image Size
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				var error = validateImg(files);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "policy","info-merchantpolicy");
				}
			}
		}
    });

    
    $('#info-merchantpolicyvoucher').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
		maximumImageFileSize: max_img_size,     // Max Image Size
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				var error = validateImg(files);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "voucherpolicy","info-merchantpolicyvoucher");
				}
			}
        }
    }); 

    $('#info-merchantpolicyb2b').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','video','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
		maximumImageFileSize: max_img_size,     // Max Image Size
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				console.log(welEditable);
				if(error){
					toastr.error("WARNING: Current image being uploaded has EXCEEDED the maximum size, <xx>MB. Please use smaller images.");
				} else {
					uploadImg(files, editor, welEditable, "b2bpolicy","info-merchantpolicyb2b");
				}
			}
        }
    });
	
	function validateImg(files) {
		//console.log("validate");
		var max_img_size = parseInt($("#max_img_size").val()) * 1048576;
		error = false;
		for(var fs = 0; fs < files.length; fs++){
			if(files[fs].size > max_img_size){
				error = true;
			}
		}
		return error;
    }
	
	function uploadImg(files, editor, welEditable, directory, summer) {
		console.log("upld");
		
        for(var fs = 0; fs < files.length; fs++){
			data = new FormData();
            data.append("file", files[fs]);
            data.append("directory", directory);
            $.ajax({
                data: data,
                type: "POST",
                url: JS_BASE_URL + "/uploadsummernoteimg",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    $('#' + summer).summernote('insertImage', url);
                }
            });		   
	   }    
    }	
	
	/* Squidster: Add margin-left & margin-right to class:modal-body */
	$('.modal-body').each(function(){           
		$(this).css({"margin-left":"15px","margin-right":"15px"});
	});
	
	$('#prod_length').blur(function () {
		var length = $(this).val();
		$('#prod_lengthhyper').html(length);
	});
	
	$('#prod_width').blur(function () {
		var width = $(this).val();
		$('#prod_widthhyper').html(width);
	});
	
	$('#prod_height').blur(function () {
		var height = $(this).val();
		$('#prod_heighthyper').html(height);
	});
	
	$('#prod_weight').blur(function () {
        //alert("Hola");
		var weight = $(this).val();
		$('#prod_weighthyper').html(weight);
		var length = $("#prod_length").val();
		var width = $("#prod_width").val();
		var height = $("#prod_height").val();
		$.ajax({
			type: "get",
			url:  JS_BASE_URL + '/product/get_delprice',
			data: {weight: weight, length: length, width: width, height: height},
			cache: false,
			success: function (responseData, textStatus, jqXHR) {
				$('#del_pricing').val(responseData);
				$('#del_pricing_hyper').val(responseData);
			},
			error: function (responseData, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});		
    });
	
	$('#prod_weightb2b').blur(function () {
        //alert("Hola");
		var weight = $(this).val();
		var length = $("#prod_lengthb2b").val();
		var width = $("#prod_widthb2b").val();
		var height = $("#prod_heightb2b").val();
		$.ajax({
			type: "get",
			url:  JS_BASE_URL + '/product/get_delprice',
			data: {weight: weight, length: length, width: width, height: height},
			cache: false,
			success: function (responseData, textStatus, jqXHR) {
				$('#del_pricingb2b').val(responseData);
			},
			error: function (responseData, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});		
    });	
 });
