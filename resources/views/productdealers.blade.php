@def $currency = \App\Models\Currency::where('active', 1)->first()->code
<?php use App\Http\Controllers\IdController;?>
<input type="hidden" id="productid" value="{{$product->id}}" />
<input type="hidden" id="rPricee" value="{{$product->retail_price/100}}" />
<style>
	#eac-container-usersjson {
		right: 0;
		position: absolute;
		margin-right: 15px;
		width: 35%;
		z-index: 5000;
	}
</style>
<h3>Product: {{$product->name}}</h3>
<h3>Product ID:  <a href="{{route('albumtabbed', ['id' => $product->id])}}#content-sp" target="popup" onclick="window.open('{{route('albumtabbed', ['id' => $product->id])}}#content-sp','popup', 'scrollbars=1','width=800,height=600'); return false;">{{ IdController::nP($productb2b->id) }}</a>, Qty: {{$product->available}}</h3>
<div class="table-responsive">
	<table class="table table-striped noborder" id="sppTablee">
		<thead>
			<tr>
				<th class="text-center">No</th>
				<th>Buyer&nbsp;ID</th>
				<th>Name</th>
				<th>Special&nbsp;Price</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php $sp = 0; ?>
		@if(!is_null($productdealers))
			@foreach($productdealers as $specialr)
				<tr class='srow' data='{{$sp}}' id="srowe-{{$sp}}">
					<?php $formatted_user_id = IdController::nB($specialr->dealer_id); ?>
					<td class="col-xs-1"><center id="nume-{{$sp}}">{{$sp + 1}}</center></td>
					<td class="col-xs-4">
						<span class="dealer_selected_ide" id="dealeride-{{$sp}}" rel="{{$sp}}">{{$formatted_user_id}}</span>
						<input type="hidden" id="dealer_id_e{{$sp}}" value="{{$specialr->dealer_id}}" />
					</td>								
					<td class="col-xs-3">
						<span class="dealer_selectede" id="dealere-{{$sp}}" rel="{{$sp}}">{{ $specialr->first_name }} {{ $specialr->last_name }}</span>
					</td>
					<td class="col-xs-3">
						<a href="javascript:void(0);" class="sp_popupe" rel="{{$sp}}">Special&nbsp;Price</a>
					</td>
					<td class="col-xs-1">
						<a href="javascript:void(0);" id="remsppne-{{$sp}}" class="remsppne form-control text-center text-danger" rel="{{$sp}}">
							<i class="fa fa-minus-circle"></i>
						</a>
					</td>
				</tr>
				<?php $sp++; ?>
			@endforeach
		@endif
		
		@if($sp>0)
			<tr class='srow' data='{{$sp}}' id="srowe-{{$sp}}">
				<td class="col-xs-1"><center id="nume-{{$sp}}">{{$sp+1}}</center></td>
				<td class="col-xs-4">
					<span id="userIDse-{{$sp}}">
						<select class="form-control dealer_selecte" id="userIDe-{{$sp}}" required="" rel="{{$sp}}" >
							@if(!is_null($dealers))
								<option value="">Choose User</option>									
								@foreach($dealers as $dealer)
									<?php $formatted_user_id = IdController::nB($dealer->id); ?>
									<option value="{{$dealer->id}}">{{ $formatted_user_id . " - " . $dealer->first_name . " " . $dealer->last_name }} </option>
								@endforeach
							@else 
								<option value="">No autolinked users found</option>
							@endif 
						</select>
					</span>
					<span class="dealer_selected_ide" id="dealeride-{{$sp}}" rel="{{$sp}}" style="display: none;"></span>
					<input type="hidden" id="dealer_id_e{{$sp}}" value="0" />
				</td>								
				<td class="col-xs-3">
					<span class="dealer_selectede" id="dealere-{{$sp}}" rel="{{$sp}}"></span>
				</td>
				<td class="col-xs-3">
					<a href="javascript:void(0);" class="sp_popupe" rel="{{$sp}}">Special&nbsp;Price</a>
				</td>
				<td class="col-xs-1">
					<a href="javascript:void(0);" id="addsppne-{{$sp}}" class="die addsppne form-control text-center text-green" rel="{{$sp}}">
						<i class="fa fa-plus-circle"></i>
					</a>
					<a href="javascript:void(0);" id="remsppne-{{$sp}}" title="Warning: you will remove this user special prices" class="remsppne form-control text-center text-danger" rel="{{$sp}}" style="display:none;">
						<i class="fa fa-minus-circle"></i>
					</a>
				</td>
			</tr>
		@else
			<tr class='srow' data='0' id="srowe-0">
				<td class="col-xs-1"><center id="nume-0">1</center></td>
				<td class="col-xs-4">
					<span id="userIDse-0">
						<select class="form-control dealer_selecte" id="userIDe-0" required="" rel="0" >
							@if(!is_null($dealers))
								<option value="">Choose User</option>									
								@foreach($dealers as $dealer)
									<?php $formatted_user_id = IdController::nB($dealer->id); ?>
									<option value="{{$dealer->id}}">{{ $formatted_user_id . " - " . $dealer->first_name . " " . $dealer->last_name }} </option>
								@endforeach
							@else 
								<option value="">No autolinked users found</option>
							@endif 
						</select>
					</span>
					<span class="dealer_selected_ide" id="dealeride-0" rel="0" style="display: none;"></span>
					<input type="hidden" id="dealer_id_e0" value="0" />
				</td>								
				<td class="col-xs-3">
					<span class="dealer_selectede" id="dealere-0" rel="0"></span>
				</td>
				<td class="col-xs-3">
					<a href="javascript:void(0);" class="sp_popupe" rel="0">Special&nbsp;Price</a>
				</td>
				<td class="col-xs-1">
					<a href="javascript:void(0);" id="addsppne-0" class="addsppne form-control text-center text-green" rel="0">
						<i class="fa fa-plus-circle"></i>
					</a>
					<a href="javascript:void(0);" id="remsppne-0" title="Warning: you will remove this user special prices" class="remsppne form-control text-center text-danger" rel="0" style="display:none;">
						<i class="fa fa-minus-circle"></i>
					</a>
				</td>
			</tr>									
		@endif
		</tbody>
	</table>
</div>
<input type="hidden" value="{{ route('routegetdealers') }}" id='routegetdealers'>
<input type="hidden" value="{{ route('routedeletepdealer') }}" id='routedeletepdealer'>
<input type="hidden" value="{{ route('routedeletepdealer') }}" id='routedeletepdealer'>
<script type="text/javascript">
function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}
	
$(document).ready(function () {
	$('body').on('change', '.dealer_selecte', function() {
		var dealer_rel = $(this).attr("rel");
		if($(this).val() == ""){
			$("#addsppne-" + dealer_rel).addClass('die');
			$("#dealere-" + dealer_rel).text("");
			$("#dealeride-" + dealer_rel).text("");
		} else {
			$("#addsppne-" + dealer_rel).removeClass('die');
			var val = $("#userIDe-" + dealer_rel + " option:selected").text();
			$("#dealer_id_e" + dealer_rel).val($(this).val());
			var splitarr = val.split("-");
			$("#dealere-" + dealer_rel).text(splitarr[1]);
			$("#dealeride-" + dealer_rel).text(splitarr[0]);
		}
	});

	spp_table = $("#sppTablee").DataTable({
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

	
	$('body').on('click', '.addsppne', function() {
		var dealer_rel = $(this).attr("rel");
		var rowNo = parseInt($(this).attr("rel"));
		rid = rowNo + 1;
		rid2 = rid + 1;
		route = $('#routegetdealers').val();
		$.ajax({ type: "get", url: route, dataType: "json",success: function(result){
			console.log(result);
			var options = "<option value=''>Choose User</option>";
			for(var i = 0; i < result.length; i++){
				options = options + '<option value="'+result[i].id+'">' + result[i].first_name + ' ' + result[i].last_name +  '</option>';
			}
			spp_table
			.row.add( [ '<center id="nume-'+rid+'">'+rid2+'</center>', '<span id="userIDse-'+rid+'"><select class="form-control dealer_selecte" id="userIDe-'+rid+'" required="" rel="'+rid+'" >'+options+'</select></span><span class="dealer_selected_ide" id="dealeride-'+rid+'" rel="'+rid+'" style="display: none;"></span><input type="hidden" id="dealer_id_e'+rid+'" value="0" />', '<span class="dealer_selectede" id="dealere-'+rid+'" rel="'+rid+'"></span>', '<a href="javascript:void(0);" class="sp_popupe" rel="'+rid+'">Special&nbsp;Price</a>','<a href="javascript:void(0);" id="addsppne-'+rid+'" class="die addsppne form-control text-center text-green" rel="'+rid+'"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0);" id="remsppne-'+rid+'" title="Warning: you will remove this user special prices" class="remsppne form-control text-center text-danger" rel="'+rid+'" style="display:none;"><i class="fa fa-minus-circle"></i></a>' ] )
			.draw();
			$("#userIDe-"+rid).select2();
			$("#addsppne-" + dealer_rel).hide();
			$("#remsppne-" + dealer_rel).show();					
		}});

		
	});
	
	$('body').on('click', '.remsppne', function() {
		selec=confirm("Are you sure you want to remove this user special prices?"); 
		if (selec){
			var dealer_rel = $(this).attr("rel");
			var rid = $("#dealer_id_e" + dealer_rel).val();
			var productid = $('#productid').val();
			route = $('#routedeletepdealer').val();
			$.ajax({ type: "POST", url: route, data: {id : rid, pid: productid}, success: function(result){
				
			}});	
			
			$(this).parent().parent().remove();
		} 				
	});			
	
	$('body').on('click', '.sp_popupe', function() {
		var dealer_rel = $(this).attr("rel");
		var val = $("#dealer_id_e" + dealer_rel).val();
		var rprice = $("#rPricee").val();
		if(val == ""){
			toastr.error("Warning: Please, select an user");
		} else {
			if(rprice == "" || parseFloat(rprice) == 0){
				toastr.error("Warning: Retail product must be defined first in order to activate Special Pricing");
			} else {
				
				$("#userIDse-" + dealer_rel).hide();
				$("#dealeride-" + dealer_rel).show();
				var rid = $("#dealer_id_e" + dealer_rel).val();
				var productid = $('#productid').val();
				var url=JS_BASE_URL+"/pd/sprices/"+rid+"/"+productid;
				var w=window.open(url,"_blank");
				w.focus();							
			}				
		}		
	});
});

</script>
