<tr class='wrow' data="{{ $id }}" id="wrow-{{ $id }}">
    <td class="col-xs-2">
        <input type="text" class="form-control numeric wfunit" disabled="disabled" name="wfunit[]" id="wfunit{{ $id }}" value="{{ $val }}">
    </td>
    <td class="col-xs-2">
    <input type="text" class="form-control numeric wunit" name="wunit[]" id="wunit{{ $id }}" rel="{{ $id }}">
    <label id='err-{{ $id }}' class='err hidden'>Unit must be greater than <span id='pu-{{ $id }}'></span></label>
    </td>
    <td class="col-xs-3"> 
    <div class="input-group"  id='wping-{{ $id }}'>
    <span class="input-group-addon">{{ isset($curr) ? $curr : '' }}</span>
    <input type="text" name="wprice[]" id="wprice-{{ $id }}"  disabled class="form-control myr-price wholesale wholesalep" rel="{{ $id }}">
    </div>
    <label id='errp-{{ $id }}' class='err hidden'>Price must be smaller than <span id='p-{{ $id }}'></span></label>
    </td>
    <td>  
    <a  href="javascript:void(0);"  class="remrsp form-control text-center text-danger" rel="{{ $id }}">
    <i class="fa fa-minus-circle"></i>
    </a>
    </td>
    <td class="col-xs-4"> 
    <div class="input-group">
    <span class="input-group-addon">Margin</span>
    <div class="average form-control text-center text-danger"><span id="mar-{{ $id }}">0.00</span></div> 
    <span class="input-group-addon">%</span></div></td>
</tr>

<script type="text/javascript">
    $(document).ready(function(){
        $('input.myr-price').number(true, 2);
        $('.wunit').on('blur', function(){
            $('#addRowLabel').addClass('hidden');
            thisUnit = parseInt($(this).attr('rel'));
            fromUnit =parseInt($('#wfunit'+thisUnit).val());
            toUnit = parseInt($('#wunit'+thisUnit).val());
            if (0 < toUnit && fromUnit < toUnit && toUnit != null) {
                $('#wunit'+thisUnit).removeClass('errorBorder');
                $('#err-'+thisUnit).addClass('hidden');
                $('#wprice-'+thisUnit).removeAttr('disabled');
                $('#wping-'+thisUnit).removeClass('errorBorderIng');
            } else {
                $('#wunit'+thisUnit).val(null);
                $('#wunit'+thisUnit).addClass('errorBorder');
                $('#err-'+thisUnit).removeClass('hidden');
                $('#pu-'+thisUnit).text(fromUnit);
                $('#wprice-'+thisUnit).attr('disabled', 'disabled');
            }
        })

        $('.wholesalep').on('blur',function(){
            $('#addRowLabel').addClass('hidden');
            thisUnit = parseInt($(this).attr('rel'));
			if(thisUnit > 0){
				prevUnit = parseInt(thisUnit) - 1;
				price = parseFloat($('#wprice-'+thisUnit).val());
				prevPrice = parseFloat($('#wprice-'+prevUnit).val());
				if (0 < price && price != null && price < prevPrice) {
				$('#wping-'+thisUnit).removeClass('errorBorderIng');
				$('#errp-'+thisUnit).addClass('hidden');
					margin = calculateMargin(price);
					rprice = parseFloat($("#rPrice").val());
					if(rprice == 0){
						$('#mar-'+thisUnit).text("N.A");
					} else {	
						$('#mar-'+thisUnit).text(margin);
						//$('#wprice-'+thisUnit).attr("disabled",true);
					}				
				} else {
					$('#wprice-'+thisUnit).delay(1200).val(null);
					$('#wping-'+thisUnit).addClass('errorBorderIng');
					$('#errp-'+thisUnit).removeClass('hidden');
					$('#p-'+thisUnit).text(prevPrice);
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