<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
$sp = 0;
?>
 <style>
        .btn-subcat{
            border: none;
            background: #fff;
            padding-left: 0px;
        }
		html {
			overflow: -moz-scrollbars-vertical;
		}
	
        .easy-autocomplete {
            width: 100% !important;
        }
        .easy-autocomplete-container {
            width: 250px !important;
        }

        li.selected {
            outline: 1px solid #27A98A;
        }
        select label {
            display: inline;
        }

		/* This is the magical stanza for the misaligned header
		 * problem which has been affecting datatables! */
        table.dataTable th, td {
            max-width: 180px !important;
            word-wrap: break-word
        }

        .details-control, .details-control-2 {
            cursor: pointer;
        }

        td.details-control:after, td.details-control-2:after {
            font-family: 'FontAwesome';
            content: "\f0da";
            color: #303030;
            font-size: 17px;
            float: right;
            padding-right: 25px;
        }

        tr.shown td.details-control:after, tr.shown td.details-control-2:after {
            content: "\f0d7";
        }

        .child_table {
            margin-left: 78px;
            width: 920px;;
        }

        .panel {
            border: 0;
        }

        table {
			table-layout: auto !important;
            counter-reset: Serial;
        }

        table.counter_table tr td:first-child:before {
            counter-increment: Serial; /* Increment the Serial counter */
            content: counter(Serial); /* Display the counter */
        }

        .badge-checkbox {
            -webkit-appearance: checkbox;
            -moz-appearance: checkbox;
            -ms-appearance: checkbox;
        }

        table.popup-table th{
            text-align: center;
            background: #337AB7;
            color : #fff;
        }

        table.popup-table tbody td {
            text-align: center;
        }

		.old-value:hover {
			text-decoration: underline;
		}

		.edit_pro:hover {
			text-decoration: underline;
		}

        .margin-top {
            margin-left: -15px;
            margin-right: -15px;
        }

        label.err {
            font-size: 12px;
            color : red;
            font-weight: normal;
        }

        input.errorBorder, span.errorBorder {
            border: 1px solid #F00;
        }

        .errorBorder {
            border: 1px solid #F00;
        }

        .errorDoubleBorder {
            border: 2px solid #F00;
        }

        .errorBorderIng {
            border: 1px solid #F00;
            border-radius: 5px 0px 0px 5px;
        }

        .die {
            pointer-events: none;
            cursor: default;
            opacity: 0.6;
        }

        .li_same_size {
            width: 37px;
            height: 37px;
        }

        form input.error, form select.error, form textarea.error {
            background-color: #FFFFC8 !important;
            border: 1px solid #F00 !important;
        }

        .mt {
            margin-top: 10px;
        }

        table#tab-product-detail {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        /* Start by setting display:none to make this hidden.
       Then we position it in relation to the viewport window
       with position:fixed. Width, height, top and left speak
       speak for themselves. Background we set to 80% white with
       our animation centered, and no-repeating */
        .modal_loading {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url('http://sampsonresume.com/labs/pIkfp.gif') 50% 50% no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal_loading {
            display: block;
        }
        #imagePreviewDiscount {
           position: absolute;
            left: 0;
            height: 170px;
        }
        #imagePreviewVoucher {
           position: absolute;
            left: 0;
            height: 304px;
        }      
		#imagePreviewVoucherv1 {
           position: absolute;
            left: 0;
            height: 304px;
        }		
		#imagePreviewVoucherv2 {
           position: absolute;
            left: 0;
            height: 304px;
        }
		
		#imagePreviewVouchercoverv2 {
            left: 0;
            height: 200px;
        }			
 </style>
 @extends("common.default")
 @section("content")
 @include('common.sellermenu')
{!! Form::open(['id'=>'productRegForm', 'style'=>'margin-bottom:0;margin-top:0', 'class'=> 'form-horizontal','files' => true]) !!}
<div class="container">
			<input type="hidden" value="{{ route('routegetdealerst') }}" id='routegetdealers'>
			<input type="hidden" value="{{ $tproduct->id }}" id='tproduct_id'>
			<input type="hidden" value="{{ $merchant_id }}" id='tmerchant_id'>
            <div class="row">
				<h3>Product Name: {{$tproduct->name}}</h3>
				<h4>Product&nbsp;ID: {{IdController::nTp($tproduct->id)}}</h4>
			</div>
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Special User List</h3>
                        <div class="table-responsive">
                            <table class="table table-striped noborder" id="sppTable">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th>User&nbsp;ID</th>
										<th>Name</th>
										<th>Special&nbsp;Price</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								@if(!is_null($specialprod))
									@foreach($specialprod as $specialr)
										<tr class='srow' data='{{$sp}}' id="srow-{{$sp}}">
											<?php $formatted_user_id = IdController::nB($specialr->dealer_id); ?>
											<td class="col-xs-1"><center id="num-{{$sp}}">{{$sp + 1}}</center></td>
											<td class="col-xs-4">
												<span class="dealer_selected_id" id="dealerid-{{$sp}}" rel="{{$sp}}">{{$formatted_user_id}}</span>
												<input type="hidden" id="dealer_id_{{$sp}}" value="{{$specialr->dealer_id}}" />
											</td>								
											<td class="col-xs-3">
												<span class="dealer_selected" id="dealer-{{$sp}}" rel="{{$sp}}">{{ $specialr->first_name }} {{ $specialr->last_name }}</span>
											</td>
											<td class="col-xs-3">
												<a href="javascript:void(0);" class="sp_tpopup" rel="{{$sp}}">Special&nbsp;Price</a>
											</td>
											<td class="col-xs-1">
												<a href="javascript:void(0);" id="remsppn-{{$sp}}" class="remsppn form-control text-center text-danger" rel="{{$sp}}">
													<i class="fa fa-minus-circle"></i>
												</a>
											</td>
										</tr>
										<?php $sp++; ?>
									@endforeach
								@endif
								
								@if($sp>0)
									<tr class='srow' data='{{$sp}}' id="srow-{{$sp}}">
										<td class="col-xs-1"><center id="num-{{$sp}}">{{$sp+1}}</center></td>
										<td class="col-xs-4">
											<span id="userIDs-{{$sp}}">
												<select class="form-control dealer_select" id="userID-{{$sp}}" required="" rel="{{$sp}}" >
													@if(!is_null($dealers))
														<option value="">Choose User</option>									
														@foreach($dealers as $dealer)
															<option value="{{$dealer->id}}">{{ IdController::nB($dealer->id) . " - " . $dealer->first_name . " " . $dealer->last_name }} </option>
														@endforeach
													@else 
														<option value="">No autolinked users found</option>
													@endif 
												</select>
											</span>
											<span class="dealer_selected_id" id="dealerid-{{$sp}}" rel="{{$sp}}" style="display: none;"></span>
											<input type="hidden" id="dealer_id_{{$sp}}" value="0" />
										</td>								
										<td class="col-xs-3">
											<span class="dealer_selected" id="dealer-{{$sp}}" rel="{{$sp}}"></span>
										</td>
										<td class="col-xs-3">
											<a href="javascript:void(0);" class="sp_tpopup" rel="{{$sp}}">Special&nbsp;Price</a>
										</td>
										<td class="col-xs-1">
											<a href="javascript:void(0);" id="addsppn-{{$sp}}" class="die addsppn form-control text-center text-green" rel="{{$sp}}">
												<i class="fa fa-plus-circle"></i>
											</a>
											<a href="javascript:void(0);" id="remsppn-{{$sp}}" title="Warning: you will remove this user special prices" class="remsppn form-control text-center text-danger" rel="{{$sp}}" style="display:none;">
												<i class="fa fa-minus-circle"></i>
											</a>
										</td>
									</tr>
								@else
									<tr class='srow' data='0' id="srow-0">
										<td class="col-xs-1"><center id="num-0">1</center></td>
										<td class="col-xs-4">
											<span id="userIDs-0">
												<select class="form-control dealer_select" id="userID-0" required="" rel="0" >
													@if(!is_null($dealers))
														<option value="">Choose User</option>									
														@foreach($dealers as $dealer)
															<option value="{{$dealer->id}}">{{ IdController::nB($dealer->id)  . " - " . $dealer->first_name . " " . $dealer->last_name }} </option>
														@endforeach
													@else 
														<option value="">No autolinked users found</option>
													@endif 
												</select>
											</span>
											<span class="dealer_selected_id" id="dealerid-0" rel="0" style="display: none;"></span>
											<input type="hidden" id="dealer_id_0" value="0" />
										</td>								
										<td class="col-xs-3">
											<span class="dealer_selected" id="dealer-0" rel="0"></span>
										</td>
										<td class="col-xs-3">
											<a href="javascript:void(0);" class="sp_tpopup" rel="0">Special&nbsp;Price</a>
										</td>
										<td class="col-xs-1">
											<a href="javascript:void(0);" id="addsppn-0" class="addsppn form-control text-center text-green" rel="0">
												<i class="fa fa-plus-circle"></i>
											</a>
											<a href="javascript:void(0);" id="remsppn-0" title="Warning: you will remove this user special prices" class="remsppn form-control text-center text-danger" rel="0" style="display:none;">
												<i class="fa fa-minus-circle"></i>
											</a>
										</td>
									</tr>									
								@endif
								</tbody>
                            </table>
							<input id="currentspp" type="hidden" value="{{$sp}}" />
							<input id="specialprices" name="specialprices" type="hidden" value="{{$sp}}" />
							@for($u = $sp; $u < 50; $u++)
								<input type="hidden" id="special{{$u}}" name="specialpricesa[]" value="0" >
								<input type="hidden" id="userid{{$u}}" name="specialpusers[]" value="0" >
								<input type="hidden" id="spwfunitn{{$u}}" name="specialpfunits[]" value="0" >
								<input type="hidden" id="spwunitn{{$u}}" name="specialpunits[]" value="0" >
							@endfor
                        </div>
                    </div>
                </div>
			<div class="row">
				<div class="col-sm-6">
				</div>
				<div class="col-sm-5">
					<div class="w3-light-grey w3-round-large" id="totalBart" style="display: none;">
						<div class="w3-container w3-blue w3-round-large" style="width:0%" id="myBart">0%</div>
					</div>			
				</div>
				<div class="col-sm-1">
					<p style="float:right;">
						<a href="javascript:void(0)" class="btn btn-info" id="save_tproduct" style="cursor: pointer; font-size: 20px">Save</a>
					</p>
				</div>
			</div>
        </div>
			
</div>
<br/><br/>
{!! Form::close() !!}
<script>
$(document).ready(function () {
    function pad (str, max) {
      str = str.toString();
      return str.length < max ? pad("0" + str, max) : str;
    }
	
	$('body').on('change', '.dealer_select', function() {
		var dealer_rel = $(this).attr("rel");
		if($(this).val() == ""){
			$("#addsppn-" + dealer_rel).addClass('die');
			$("#dealer-" + dealer_rel).text("");
			$("#dealerid-" + dealer_rel).text("");
		} else {
			$("#addsppn-" + dealer_rel).removeClass('die');
			var val = $("#userID-" + dealer_rel + " option:selected").text();
			$("#dealer_id_" + dealer_rel).val($(this).val());
			var splitarr = val.split("-");
			$("#dealer-" + dealer_rel).text(splitarr[1]);
			$("#dealerid-" + dealer_rel).text(splitarr[0]);
		}
	});	

	$('body').on('click', '.sp_tpopup', function() {
		var dealer_rel = $(this).attr("rel");
		console.log(dealer_rel);
		var val = $("#dealer_id_" + dealer_rel).val();
		var productid = $('#tproduct_id').val();
		var merchant_id = $('#tmerchant_id').val();
		if(val == 0 || val == ""){
			toastr.error("Warning: Please, select an user.");
		} else {
			if(productid == 0){
				toastr.error("Warning: Retail product must be fully added before Special Price can be defined.");
			} else {
				$("#userIDs-" + dealer_rel).hide();
				$("#dealerid-" + dealer_rel).show();
				var rid = $("#dealer_id_" + dealer_rel).val();
				
				var url=JS_BASE_URL+"/pd/stprices/"+rid+"/"+productid+"/"+merchant_id;
				var w=window.open(url,"_blank");
				w.focus();	
			}			
		}		
	});	
	
	spp_table = $("#sppTable").DataTable({
		'order': [],
		'responsive': false,
		'autoWidth': false,
		"scrollX":true,
		"columnDefs": [
			{ "targets": "no-sort", "orderable": false },
			{ "targets": "small", "width": "50px" },
			{ "targets": "medium", "width": "80px" },
			{ "targets": "large", "width": "120px" },
			{ "targets": "xlarge", "width": "280px" }
		]
	}	);
	
	$('body').on('click', '.addsppn', function() {
		var dealer_rel = $(this).attr("rel");
		var rowNo = parseInt($(this).attr("rel"));
		rid = rowNo + 1;
		rid2 = rid + 1;
		route = $('#routegetdealers').val();
		var userid = $('#tmerchant_id').val();
		var productid = $('#tproduct_id').val();
		$.ajax({ type: "get", url: route, data: {pid: productid, userid: userid},dataType: "json",success: function(result){
			console.log(result);
			var options = "<option value=''>Choose User</option>";
			for(var i = 0; i < result.length; i++){
				options = options + '<option value="'+result[i].id+'">' + result[i].nbid + ' - ' + result[i].first_name + ' ' + result[i].last_name +  '</option>';
			}
			spp_table
			.row.add( [ '<center id="num-'+rid+'">'+rid2+'</center>', '<span id="userIDs-'+rid+'"><select class="form-control dealer_select" id="userID-'+rid+'" required="" rel="'+rid+'" >'+options+'</select></span><span class="dealer_selected_id" id="dealerid-'+rid+'" rel="'+rid+'" style="display: none;"></span><input type="hidden" id="dealer_id_'+rid+'" value="0" />', '<span class="dealer_selected" id="dealer-'+rid+'" rel="'+rid+'"></span>', '<a href="javascript:void(0);" class="sp_popup" rel="'+rid+'">Special&nbsp;Price</a>','<a href="javascript:void(0);" id="addsppn-'+rid+'" class="die addsppn form-control text-center text-green" rel="'+rid+'"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0);" id="remsppn-'+rid+'" title="Warning: you will remove this user special prices" class="remsppn form-control text-center text-danger" rel="'+rid+'" style="display:none;"><i class="fa fa-minus-circle"></i></a>' ] )
			.draw();
			$("#userID-"+rid).select2();
			$("#addsppn-" + dealer_rel).hide();
			$("#remsppn-" + dealer_rel).show();					
		}});

		
	});	
	
	$('#save_tproduct').click(function (e) {
		//console.log("Valido");
		var obt = $(this);
		obt.html("Saving...");
		var fdata = new FormData($("#productRegForm")[0]);
		var tmerchant_id = $("#tmerchant_id").val();
		var tproduct_id = $("#tproduct_id").val();
		fdata.append("tmerchant_id", tmerchant_id);
		fdata.append("tproduct_id", tproduct_id);
		
		$.ajax({
			url: JS_BASE_URL + '/store_tb2b',
			data:fdata,
			dataType:'json',
			async:false,
			type:'post',
			processData: false,
			contentType: false,
			success:function(response){
				//console.log("LISTO");
				console.log(response);
				if(response == "error"){
					toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
				} else {
					toastr.info("Wholesale Prices Saved!");
				}
				obt.html("Save");
				//$("#next_b2b_spinner").hide();
				//ar pid = response;
				//$('.nav-tabs a[href="#content-hyper"]').tab('show');
				//$('html, body').animate({ scrollTop: 400 }, 'fast');
			},
			  error:function(jqXHR, textStatus, errorThrown ){
				  obt.html("Save");				  
				  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
			  },
		});		
	});
    $("#addrsp").on('click', function () {
		var wholesaleprices = $("#wholesaleprices").val();
		wholesaleprices = parseInt(wholesaleprices) + 1;
		$("#wholesaleprices").val(wholesaleprices);
        rowNo = parseInt($('tr.wrow').last().attr('data'));
		if(rowNo == 0){
			lastRowUnit = parseFloat($('#wunit'+rowNo).val());
			lastRowPrice = parseFloat($('#wprice-'+rowNo).val());
		} else {
			lastRowUnit = parseFloat($('#wunit'+rowNo).val());
			lastRowPrice = parseFloat($('#wprice-'+rowNo).val());
		}
        rid = rowNo + 1;
        
		$('#wfunitn'+rid).val(lastRowUnit+1);


        if (0 < lastRowPrice && lastRowPrice != null && 0 < lastRowUnit && lastRowUnit != null) {
            $('#addRowLabel').addClass('hidden');
            prevval = lastRowUnit + 1;
            route = $('#routeFetchFields').val();
            $.ajax({ type: "POST", url: route, data: {id : rid, pre : prevval}, success: function(result){
                $("#wrpTable > tbody").append(result);
                $('.remrsp').each(function(){
                $(this).addClass('die');
            })

            $('.remrsp').last().removeClass('die');
			$('#wprice-'+rowNo).attr("disabled",true);
            }});
            $('input.myr-price').number(true, 2);
            $("input.numeric").on('keypress', checkValidationNumeric);

        } else {
            $('#addRowLabel').removeClass('hidden');

            if ((0 >= lastRowPrice || lastRowPrice == null || isNaN(lastRowPrice))) {
                $('#wping-'+rowNo).addClass('errorBorderIng');
            } else {
                $('#wping-'+rowNo).removeClass('errorBorderIng');
            }

            if ((lastRowUnit == null || isNaN(lastRowUnit) || lastRowUnit < 0)) {
                $('#wunit-'+rowNo).addClass('errorBorder');
            } else {
                $('#wunit-'+rowNo).removeClass('errorBorder');
            }
        }
    });
	
    $("#wrpTable").on('click', '.remrsp', function () {
        id = parseInt($(this).attr('rel'));
        $('#wrow-'+id).remove();
		currentwp = parseInt($("#wholesaleprices").val());
		$("#wholesaleprices").val(currentwp-1);
		$("#wholesale" + id).val("0");
		$("#wfunitn" + id).val("0");
		$("#wunitn" + id).val("0");
        var i = 0;
        $('.wholesalep').each(function(){
            $(this).attr('rel', i);
            $(this).attr('id', 'wprice-'+i);
            i++;
        })

        var j = 0;
        $('.wunit').each(function(){
            $(this).attr('rel', j);
            $(this).attr('id', 'wunit'+j);
            j++;
        })

        var k = 0;
        $('.wrow').each(function(){
            $(this).attr('data', k);
            $(this).attr('id', 'wrow-'+k);
            k++;
        })

        var l = 0;
        $('.wfunit').each(function(){
            $(this).attr('id', 'wfunit'+l);
            l++;
        })

        var m = 1;
        $('.remrsp').each(function(){
            $(this).attr('rel', m);
            m++;
        })

        $('.remrsp').last().removeClass('die');
        $('.wholesalep').last().attr('disabled',false);
    });

	$('.wholesalep').on('blur',function(){
		//alert("1");
		$('#addRowLabel').addClass('hidden');
		thisUnit = parseInt($(this).attr('rel'));
		console.log("Unit: " + thisUnit);
		if(thisUnit > 0){
			prevUnit = parseInt(thisUnit) - 1;
			price = parseFloat($('#wprice-'+thisUnit).val());
			prevPrice = parseFloat($('#wprice-'+prevUnit).val());
			if(price == null){
				price = parseFloat($('#rPrice_p').text());
			}			
			if (0 < price && price != null && price < prevPrice && price > 0) {
				$('#wping-'+thisUnit).removeClass('errorBorderIng');
				$('#errp-'+thisUnit).addClass('hidden');
				margin = calculateMargin(price);
				//console.log(margin);
				rprice = parseFloat($("#rPrice").val());
				if(rprice == 0){
					$('#mar-'+thisUnit).text("N.A");
				} else {				
					//console.log("HERE I AM");
					$('#mar-'+thisUnit).text(margin);
					//$('#wprice-'+thisUnit).attr("disabled",true);
				}
				$('#addrsp').removeClass('die');
			} else {
				if(price < 1){
					prevPrice = 1;
				}
				$('#wprice-'+thisUnit).delay(1200).val(null);
				$('#wping-'+thisUnit).addClass('errorBorderIng');
				$('#errp-'+thisUnit).removeClass('hidden');
				$('#p-'+thisUnit).text(prevPrice);
			}			
		} else {
			console.log("Again");
			$('#wping-'+thisUnit).removeClass('errorBorderIng');
			$('#errp-'+thisUnit).addClass('hidden');
			//console.log(margin);
			$('#addrsp').removeClass('die');
			$('#mar-'+thisUnit).text("N.A");			
		}
	})	
	
    $('.wunit').on('blur', function(){
        $('#addRowLabel').addClass('hidden');
        thisUnit = parseInt($(this).attr('rel'));
        fromUnit = parseInt($('#wfunit'+thisUnit).val());
        toUnit = parseInt($('#wunit'+thisUnit).val());
		//console.log("in validation");
        executeWunit(thisUnit, fromUnit, toUnit);
    })

    function executeWunit(thisUnit, fromUnit, toUnit) {
        if (fromUnit < toUnit && toUnit != null) {
            $('#wunit'+thisUnit).removeClass('errorBorder');
            $('#wping-'+thisUnit).removeClass('errorBorderIng');
            $('#err-'+thisUnit).addClass('hidden');
            $('#wprice-'+thisUnit).removeAttr('disabled');
        } else {
			if(parseInt(thisUnit)==0){
				
			} else {
				$('#wunit'+thisUnit).val(null);
				$('#wunit'+thisUnit).addClass('errorBorder');
				$('#err-'+thisUnit).removeClass('hidden');
				$('#pu-'+thisUnit).text(fromUnit);
				$('#wping-'+thisUnit).attr('disabled', 'disabled');
			}
        }
    }

    function calculateMargin(price) {
        rprice = parseFloat($("#rPrice").val());
        margin = 0;
		//console.log(price);
		//console.log(rprice);
        if ( price < rprice ) {
            margin = ((rprice - price)/rprice) * 100;
        } else {
            margin = 0;
        }
		//console.log(margin);
        if(margin>99.99){margin=99.99};
        return number_format(margin, 2);
    }

    function number_format(number, decimals, dec_point, thousands_sep)
    {
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + (Math.round(n * k) / k).toFixed(prec);
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }

    function checkValidationNumeric(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    }
	
});
</script>
@stop
