<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
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
 <input type="hidden" value="{{ route('routeFetchFieldsT') }}" id='routeFetchFields'>
 <input type="hidden" value="{{ $tproduct->id }}" id='tproduct_id'>
 <input type="hidden" value="{{ $merchant_id }}" id='tmerchant_id'>
 <div class="row">
    <h3>Product Name: {{$tproduct->name}}</h3>
    <h4>Product&nbsp;ID: {{IdController::nTp($tproduct->id)}}</h4>
</div>
<div class="row">
    <div class="table-responsive " >
        <table class="table table-striped noborder" id="wrpTable">
            <tr>
                <th>From</th>
                <th>To</th>
                <th colspan="10">Price</th>
            </tr>
            <?php $wsize = sizeof($twholesale);
            $wp = 0;
            $previous=0;
            ?>

            @if(!is_null($twholesale))
            @foreach($twholesale as $wholesaler)

            <tr class='wrow' data='{{$wp}}' id="wrow-{{$wp}}">
               <td class="col-xs-2">
                  <input type="text" class="form-control numeric wfunit" disabled="disabled" @if($wp>0) value="{{$previous}}" @else  value="{{$wholesaler->funit}}"  @endif name="wfunit[]" id="wfunit{{$wp}}" rel="{{$wp}}">
                  <label id='ferr-{{$wp}}' class='err hidden'>Unit must be greater than 0</label>
              </td>
              <td class="col-xs-2">
                  <input type="text" class="form-control numeric wunit" value="{{$wholesaler->unit}}" name="wunit[]" id="wunit{{$wp}}" rel="{{$wp}}">
                 
                  @if($wholesaler->unit<$previous)
                  <label id='err-{{$wp}}' class='err '>Unit must be greater than <span id='pu-{{$wp}}'>{{$previous}}</span></label>
                    <input type="hidden" id='protect-{{$wp}}' value="1" name="protect[]">
                  @else
                  <label id='err-{{$wp}}' class='err hidden'>Unit must be greater than <span id='pu-{{$wp}}'></span></label>
                    <input type="hidden" id='protect-{{$wp}}' value="0" name="protect[]">

                  @endif
                  
              </td>
              <td class="col-xs-3">
                  <div class="input-group"  id='wping-{{$wp}}'>
                     <span class="input-group-addon">MYR</span>
                     <input type="text" id='wprice-{{$wp}}' class="form-control myr-price wholesale wholesalep" value="{{number_format(($wholesaler->price/100),2, '.', '')}}" rel="{{$wp}}" name="wprice[]">								
                 </div>	
                 <label id='errp-{{$wp}}' class='err hidden'>Price must be smaller than <span id='p-{{$wp}}'></span></label>
                 <label id='errx' class='err hidden'>Retail Price must be assigned in Retail segment</span></label>										
             </td>
             @if($wp == 0)
             <td class='col-xs-1'>
                 <a  href="javascript:void(0);" id="addrsp" class="form-control text-center text-green"><i class="fa fa-plus-circle"></i></a>
             </td>
             @else
             <td>
                 @if($wp == ($wsize-1))
                 <a  href="javascript:void(0);"  class="remrsp form-control text-center text-danger"><i class="fa fa-minus-circle"></i></a>
                 @else
                 <a  href="javascript:void(0);"  class="die remrsp form-control text-center text-danger"><i class="fa fa-minus-circle"></i></a>
                 @endif
             </td>
             @endif
             <?php
             $mysaveswr = 0;
             ?>
         </tr>
         <input type="hidden" id="wholesale{{$wp}}" name="wholesalepricesa[]" value="{{number_format(($wholesaler->price/100),2, '.', '')}}" >
         <input type="hidden" id="wfunitn{{$wp}}" name="wholesalefunits[]" @if($wp>0) value="{{$previous}}" @else value="{{$wholesaler->funit}}" @endif >
         <input type="hidden" id="wunitn{{$wp}}" name="wholesaleunits[]" value="{{$wholesaler->unit}}" >
         <?php $wp++; $previous = $wholesaler->unit+1; ?>
         @endforeach
         @endif
         @if($wp==0)
         <tr class='wrow' data='0' id="wrow-0">
            <td class="col-xs-2">
               <input type="text" class="form-control numeric wfunit" name="wfunit[]" id="wfunit0"  rel="0">
               <label id='ferr-0' class='err hidden'>Unit must be greater than 0</label>
           </td>
           <td class="col-xs-2">
               <input type="text" class="form-control numeric wunit" name="wunit[]" id="wunit0" rel="0">
               <label id='err-0' class='err hidden'>Unit must be greater than <span id='pu-0'></span></label>
           </td>
           <td class='col-xs-3'>
               <div class="input-group"  id='wping-0'>
                  <span class="input-group-addon">{{$currentCurrency}}</span>
                  <input id='wprice-0' type="text" disabled class="form-control myr-price wholesale wholesalep" rel="0" name="wprice[]">
              </div>
              <label id='errp-0' class='err hidden'>Price must be smaller than <span id='p-0'></span> and grater than 1</label>
              <label id='errx' class='err hidden'>Retail Price must be assigned in Retail segment</span></label>
          </td>
          <td class='col-xs-1'>
           <a  href="javascript:void(0);" id="addrsp"  class="form-control die text-center text-green"><i class="fa fa-plus-circle"></i></a>
       </td>
   </tr>
   @endif
</table>
<input id="wholesaleprices" name="wholesaleprices" type="hidden" value="{{$wp}}" />
@for($w = $wp; $w < 20; $w++)
<input type="hidden" id="wholesale{{$w}}" name="wholesalepricesa[]" value="0" >
<input type="hidden" id="wfunitn{{$w}}" name="wholesalefunits[]" value="0" >
<input type="hidden" id="wunitn{{$w}}" name="wholesaleunits[]" value="0" >
@endfor

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
				}
                else if (response == "overlaped"){
                    toastr.error("Please remove overlaped tier");
                } 
                else {
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
        fromUnit = parseInt($('#wfunit'+thisUnit).val());
        toUnit = parseInt($('#wunit'+thisUnit).val());

        if (fromUnit < toUnit && toUnit != null) {
            $('#protect-'+thisUnit).attr('value','0');

            $('#wunit'+thisUnit).removeClass('errorBorder');
            $('#wping-'+thisUnit).removeClass('errorBorderIng');
            $('#err-'+thisUnit).addClass('hidden');
            $('#wprice-'+thisUnit).removeAttr('disabled');
            if (thisUnit<={{$wp}}) {
                thisUnit=thisUnit+1;
                executeWunit(thisUnit, fromUnit, toUnit);
            }

        } else {
         if(parseInt(thisUnit)==0){

         } else {
            $('#wunit'+thisUnit).val(null);
            $('#protect-'+thisUnit).attr('value','1');
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
