@def $currency = \App\Models\Currency::where('active', 1)->first()->code
@if(isset($productb2b->id))
<input type="hidden" id="productidb2b" value="{{$productb2b->id}}" />
<h3>Product: {{$productb2b->name}}</h3>
<h3>Product ID: <a href="{{route('albumtabbed', ['id' => $product->id])}}#content-b2b" target="popup" onclick="window.open('{{route('albumtabbed', ['id' => $product->id])}}#content-b2b','popup', 'scrollbars=1','width=800,height=600'); return false;">{{$nproductid}}</a>, Qty: {{$productb2b->available}}</h3>
<div class="table-responsive">
	<table class="table table-bordered table popup-table" id="wholesale_table">
		<thead>
			<tr>
				<th>No</th>
				<th>Min Unit</th>
				<th>Max Unit</th>
				<th>Price</th>
			</tr>
		</thead>
		<?php $kk = 0;	?>
		<tbody id="wholesale_table_tbody">
			@if(isset($wholesales))

				@foreach($wholesales as $key => $wholesale)
					<tr id="trw-{{ $wholesale->id }}">
						<td>{{ $kk = $kk + 1 }}</td>
						<td><span id='funit-old-value-{{ $wholesale->id }}'>{{ $wholesale->funit }}</span></td>
						<td>
							<span id='unit-old-value-{{ $wholesale->id }}'>{{ $wholesale->unit }}</span>
							<div class='hidden editInputField '  id='unit-{{ $wholesale->id }}'>
								<div class="col-sm-4 pull-left"style="display:inline">
									<div id="unitloader-{{ $wholesale->id }}" class="loader hidden col-sm-2 pull-left" style="padding-top:7px; display:inline">
										<div class="row">
											<img class='pull-right' src="{{ asset('images/loader.gif') }}" alt="">
										</div>
									</div>
								</div>
								<div class="col-sm-8 pull-left" style="display:inline">
									<div class="row">
										<input style="width:70%" data-product="{{ $wholesale->product_id }}" data-route="{{ route('editUnit') }}" data-id="{{ $wholesale->id }}" class='editUnit form-control input-sm' value='{{ $wholesale->unit }}'>
									</div>
								</div>
							</div>
						</td>
						<td>
							<div class='pull-left col-sm-4' style='display:inline'>
								<div class="row cur">
									<span style="text-align:left">{{ $currency }}</span>
								</div>
								<div  id="priceloader-{{ $wholesale->id }}" class="loader hidden pull-left" style="padding-top:7px;display:inline">
									<div class="row">
									 	<img class="pull-right" src="{{ asset('images/loader.gif') }}" alt="">
									</div>
								</div>
							</div>

							<div class='pull-left col-sm-8' style='display:inline'>
								<div class="row">
									<span id='price-old-value-{{ $wholesale->id }}' style="text-align:right">
										{{ number_format($wholesale->price/100,2, '.', '') }}
									</span>
									<div class='hidden editInputField' id='price-{{ $wholesale->id }}'>
										<div class="col-sm-10 pull-left">
											<div class="row">
												<input
												style="margin-right:25px"
												data-product="{{ $wholesale->product_id }}"
												data-route="{{ route('editPrice') }}"
												data-id="{{ $wholesale->id }}"
												class='editPrice form-control input-sm  pull-right'
												value="{{ $wholesale->price }}">
											</div>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>
<input type="hidden" id="new_ws" value="{{$kk}}" />
<input type="hidden" id="type_price" value="wholesale" />
@else
	{{-- <h3>There is no B2B product set. Please, <a href="{{route('albumtabbed', ['id' => $product->id])}}#content-b2b">create a B2B</a> product</h3> --}}

	<table class="table table-bordered table popup-table">
		<thead>
			<tr>
				<th>No</th>
				<th>Min Unit</th>
				<th>Max Unit</th>
				<th>Price</th>
				<th style="width:8%;">Delete</th>
			</tr>
		</thead>
		<tbody>
		<tr>
		<td colspan="100" style='text-align: center; font-style: italic;  color: #999'>No Result Found.</td>
		</tr>
		</tbody>
	</table>
@endif

<script type="text/javascript">
	function removewholesale(id){
		$.ajax({
			url: "/deletewholesaleprice",
			type: "POST",
			data: {
				id : id
			},
			async: false,
			success: function(response)
			{
				var resultdel = response;
				resultdel = JSON.parse(resultdel);
				$("#trw-" + id).hide();
				$('#funit-old-value-'+resultdel.nid).html(resultdel.nvalue);
			}
		});
	}

	$(document).ready(function(){

		function pad (str, max) {
		  str = str.toString();
		  return str.length < max ? pad("0" + str, max) : str;
		}

		var result;

		$('.editColumn').click(function(){
			$(this).find('div.editInputField').removeClass('hidden');
			$(this).find('span.old-value').addClass('hidden');
			$(this).find('div.cur').addClass('hidden');
		});

		$('#add_wholesale').click(function(){
			var id = $("#new_ws").val();
			var result = 0;
			id = parseInt(id) + 1;
			$("#new_ws").val(id);
			var productId = $("#productidb2b").val();
			var productName = $("#productname").val();
			$.ajax({
				url: "/addrowprice",
				type: "POST",
				data: {
					productID : productId,
					type : 'wholesale'
				},
				async: false,
				success: function(response)
				{
					result = response;
					result = JSON.parse(result);
					//alert(result);
					$('#wholesale_table_tbody').append('<tr id="trw-'+result.pid+'"><td>'+id+'</td><td><span id="funit-old-value-'+result.pid+'">'+result.funit+'</span></td><td class="editColumn"><span id="unit-old-value-'+result.pid+'" class="old-value">'+result.unit+'</span><div class="hidden editInputField "  id="unit-'+result.pid+'"><div class="col-sm-4 pull-left"style="display:inline"><div id="unitloader-'+result.pid+'" class="loader hidden col-sm-2 pull-left" style="padding-top:7px; display:inline"><div class="row"><img class=\'pull-right\' src="" alt=""></div></div></div><div class="col-sm-8 pull-left" style="display:inline"><div class="row"><input style="width:70%" data-product="'+productId+'" data-route="/editunit" data-id="'+result.pid+'" class=\'editUnit form-control input-sm\' value=\'0\'></div></div></div></td><td class=\'editColumn\'><div class=\'pull-left col-sm-4\' style=\'display:inline\'><div class="row cur"><span style="text-align:left">{{ $currency }}</span></div><div  id="priceloader-'+result.pid+'" class="loader hidden pull-left" style="padding-top:7px;display:inline"><div class="row"><img class="pull-right" src="" alt=""></div></div></div><div class=\'pull-left col-sm-8\' style=\'display:inline\'><div class="row"><span id=\'price-old-value-'+result.pid+'\' class=\'old-value\' style="text-align:right">'+result.price+'</span><div class=\'hidden editInputField\' id=\'price-'+result.pid+'\'><div class="col-sm-10 pull-left"><div class="row"><input style="margin-right:25px" data-product="'+productId+'" data-route="/editprice" data-id="'+result.pid+'" class=\'editPrice form-control input-sm  pull-right\' value="0"></div></div></div></div></div></td><td><a href="javascript:void(0)" onclick="removewholesale('+result.pid+')" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:red;"></span></a></td></tr>');

					$('.editColumn').click(function(){
						$(this).find('div.editInputField').removeClass('hidden');
						$(this).find('span.old-value').addClass('hidden');
						$(this).find('div.cur').addClass('hidden');
					});

					$('.editUnit').on('blur', function(){
						element = $(this);
						id = element.attr('data-id');
						updatedValue = element.val();
						route = element.attr('data-route');
						productID = element.attr('data-product');

						result = updateFieldByAjax(id, updatedValue, route, productID);
						if(result) setUpdatedUnit(id,result);

					});

					$('.editPrice').on('blur', function(){
						element = $(this);
						id = element.attr('data-id');
						updatedValue = element.val();
						route = element.attr('data-route');
						productID = element.attr('data-product');

						result = updateFieldByAjax(id, updatedValue, route, productID);
						if(result) setUpdatedPrice(id,result);

					});
				}
			});
		});

		$('.editUnit').on('blur', function(){
			element = $(this);
			id = element.attr('data-id');
			updatedValue = element.val();
			route = element.attr('data-route');
			productID = element.attr('data-product');

			result = updateFieldByAjax(id, updatedValue, route, productID);
			if(result) setUpdatedUnit(id,result);

		});

		$('.editPrice').on('blur', function(){
			element = $(this);
			id = element.attr('data-id');
			updatedValue = element.val();
			route = element.attr('data-route');
			productID = element.attr('data-product');

			result = updateFieldByAjax(id, updatedValue, route, productID);
			if(result) setUpdatedPrice(id,result);

		});

		function updateFieldByAjax(id, updatedValue, route, productID){
			var result;
			$.ajax({
				url: route,
				type: "POST",
				data: {
					id : id,
					productID : productID,
					updatedValue : updatedValue,
					type : 'wholesale'
				},
				async: false,
				success: function(response)
				{
					result = response;
				}
			});

			return result;
		}

		function setUpdatedUnit(id, result){
			result = JSON.parse(result);
			$('#unitloader-'+ id).removeClass('hidden');
			setTimeout(function () {
		        $('#unit-old-value-'+id).html(result.value).removeClass('hidden');
		        $('#funit-old-value-'+result.nid).html(result.nvalue);
				$('#unit-'+id).addClass('hidden');
				$('.loader').addClass('hidden');
				$('.cur').removeClass('hidden');
		    }, 600);

		}

		function setUpdatedPrice(id, result){
			$('#priceloader-'+ id).removeClass('hidden');
			setTimeout(function () {
		        $('#price-old-value-'+id).html(result).removeClass('hidden');
				$('#price-'+id).addClass('hidden');
				$('.loader').addClass('hidden');
				$('.cur').removeClass('hidden');
		    }, 600);
		}


	})
</script>
