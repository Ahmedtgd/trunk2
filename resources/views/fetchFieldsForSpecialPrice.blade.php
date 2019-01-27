<tr class='srow' data="{{ $id }}" id="srow-{{ $id }}">
      <td class="col-xs-4">
			<select class="form-control" id="userID-{{ $id }}" rel="{{ $id }}" required="">
				@if(!is_null($dealers))
					<option value="">Choose User</option>									
					@foreach($dealers as $dealer)
						<option value="{{$dealer->id}}">[{{ str_pad($dealer->id, 10, '0', STR_PAD_LEFT) }} ] - {{ $dealer->first_name }} {{ $dealer->last_name }} </option>
					@endforeach
				@else 
					<option value="">No autolinked users found</option>
				@endif 
			</select>	  
      </td>
      <td class="col-xs-3">
            <div class="input-group" id="sping-{{ $id }}">
                  <span class="input-group-addon">{{ isset($curr) ? $curr : '' }}</span>
                  <input id="sprice-{{ $id }}" type="text"  class="form-control myr-price specialp specialprice" rel="{{ $id }}" name="special[]">
            </div>
            <label id='errsp-{{ $id }}' class='err hidden'>
                Price must be smaller than retail price 
                <span id='spp-{{ $id }}'></span>
            </label>

      </td>
		<td class="col-xs-1">
			<input type="text" class="form-control numeric spwfunit" disabled="disabled" name="spwfunit[]" id="spwfunit{{ $id }}"  rel="{{ $id }}" value="{{ $val }}">
		</td>
		<td class="col-xs-1">
			<input type="text" class="form-control numeric spwunit" name="spwunit[]" id="spwunit{{ $id }}" rel="{{ $id }}">
			<label id='sperr-{{ $id }}' class='err hidden'>Unit must be greater than <span id='sppu-{{ $id }}'></span></label>
		</td>	  
      <td class="col-xs-1">  
            <a  href="javascript:void(0);"  class="remspp form-control text-center text-danger" rel="{{$id}}">
                  <i class="fa fa-minus-circle"></i>
            </a>
      </td>
      <td class="col-xs-3"> 
            <div class="input-group"> 
                  <span class="input-group-addon">Margin</span>
                  <div class="average form-control text-center text-danger" id="smar-{{ $id }}">0.0</div>
                  <span class="input-group-addon">% from retail</span>
            </div>
      </td>
	  <input type="hidden" id="lastid" value="{{$lastid}}" />
</tr>
<script type="text/javascript">
$(document).ready(function(){

    $('input').on('keypress', function(){
        if ($(this).hasClass('errorBorder')) {
            $(this).removeClass('errorBorder');
        } 

        if ($(this).parents('.input-group').hasClass('errorBorderIng')) {
            $(this).parents('.input-group').removeClass('errorBorderIng');
        }
    })

    $('input.myr-price').number(true, 2);

	var lastid = $("#lastid").val();
	$('.spwunit').on('blur', function(){
		$('#addRowLabel').addClass('hidden');
		thisUnit = parseInt($(this).attr('rel'));
		fromUnit =parseInt($('#spwfunit'+thisUnit).val());
		toUnit = parseInt($('#spwunit'+thisUnit).val());
		if (0 < toUnit && fromUnit < toUnit && toUnit != null) {
			$('#spwunit'+thisUnit).removeClass('errorBorder');
			$('#sperr-'+thisUnit).addClass('hidden');
			$('#spwunit'+thisUnit).removeAttr('disabled');
		} else {
			$('#spwunit'+thisUnit).val(null);
			$('#spwunit'+thisUnit).addClass('errorBorder');
			$('#sperr-'+thisUnit).removeClass('hidden');
			$('#sppu-'+thisUnit).text(fromUnit);
			$('#spwunit'+thisUnit).attr('disabled', 'disabled');
		}
	});	
	
    $("input.numeric").on('keypress', checkValidationNumeric);

    var rowNo = "{{ $id }}";
    var count = parseInt(rowNo) - 1;
    var i = 0;
    var exceptUser = [];
    $('.userid').each(function(){
        exceptUser[i] = $(this).attr('user');
        i++;
        if (count < i) return false;
    });
    
    var route = "{{ route('jsonusers') }}";

    var options = {
        url: route,
        getValue: "name",
        template: {
            type: "custom",
            method: function(value, item) {
                return "<span class='ulist' rel='"+ item.id + "' />"+ item.name +"</span>";
            }
        },
        list: {   
            match: {
              enabled: true
            },
            onLoadEvent : function () {
                $('.ulist').each(function(){
                    data = $(this).attr('rel');
                    if(jQuery.inArray(data, exceptUser) != -1) {
                        $(this).parents('li').remove();
                    }
                })
            },
            onClickEvent: function() {
                var id = $("#userID-"+rowNo).getSelectedItemData().id;
                var username = $("#userID-"+rowNo).getSelectedItemData().username;
				var justid = $("#userID-"+rowNo).getSelectedItemData().justid;
                $("#userID-"+rowNo).attr('user', id);
                $("#userID-"+rowNo).val(id);
                $("#userName-"+rowNo).val(username);
                $("#userID-"+rowNo).removeClass('errorBorder');
                $('#userName-'+rowNo).removeClass('errorBorder');
				$("#userid" + rowNo).val(justid);
            }
        }
    };

  //  $("#userID-"+{{ $id }}).easyAutocomplete(options);

    $("#userID-{{ $id }}").select2();
  
 	$("#userID-{{ $id }}").on('change', function () {
		$("#userid{{ $id }}").val($(this).val());
		thisUnit = parseInt($(this).attr('rel'));
		if($(this).val() == lastid){
			
		} else {
			$('#spwfunitn'+thisUnit).val("1");
			$('#spwfunit'+thisUnit).val("1");
		}
	}); 
  
    $('#sprice-'+rowNo).on('blur',function(){
        $('#addRowLabelSpecial').addClass('hidden');
        var price = parseFloat($('#sprice-'+rowNo).val());
        var rprice = parseFloat($("#rPrice").val());
		var thisUnit = parseInt($(this).attr('rel'));
        var prevUnit = parseInt(thisUnit) - 1;
		var prevPrice = parseFloat($('#sprice-'+prevUnit).val());
		var thisid=$("#userID-" + thisUnit).val();
		if(thisid == lastid){
			if (0 < price && price != null && (price < prevPrice || prevPrice == 0)) {
				$('#sping-'+rowNo).removeClass('errorBorderIng');
				$('#errsp-'+rowNo).addClass('hidden');
				$('#addssp').removeClass('die');
				margin = calculateMargin(price);
				if(prevPrice == 0){
					$('#smar-'+rowNo).text("N.A");
				} else {				
					$('#smar-'+rowNo).text(margin);
				}
				$('#userID-'+rowNo).removeAttr('disabled');
			} else {
				if ($('#errsx').hasClass('hidden') == 1) {
					$('#sprice-'+rowNo).val(null);
					$('#sping-'+rowNo).addClass('errorBorderIng');
					$('#errsp-'+rowNo).removeClass('hidden');
					$('#addssp').addClass('die');
					$('#spp-'+rowNo).text(prevPrice);
					$('#userID-'+rowNo).attr('disabled');
				}
			}			
		} else {
			if (0 < price && price != null && (price < rprice || rprice == 0)) {
				$('#sping-'+rowNo).removeClass('errorBorderIng');
				$('#errsp-'+rowNo).addClass('hidden');
				$('#addssp').removeClass('die');
				margin = calculateMargin(price);
				if(rprice == 0){
					$('#smar-'+rowNo).text("N.A");
				} else {				
					$('#smar-'+rowNo).text(margin);
				}
				$('#userID-'+rowNo).removeAttr('disabled');
			} else {
				if ($('#errsx').hasClass('hidden') == 1) {
					$('#sprice-'+rowNo).val(null);
					$('#sping-'+rowNo).addClass('errorBorderIng');
					$('#errsp-'+rowNo).removeClass('hidden');
					$('#addssp').addClass('die');
					$('#spp-'+rowNo).text(rprice);
					$('#userID-'+rowNo).attr('disabled');
				}
			}
		}

    })

    function calculateMargin(price) {
        rprice = parseFloat($("#rPrice").val());
        margin = 0;
        if ( price < rprice ) {
            margin = ((rprice - price)/rprice) * 100;
        } else {
            margin = 0;
        }

        return number_format(margin, 2);
    }

    function checkValidationNumeric(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
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
})
</script>