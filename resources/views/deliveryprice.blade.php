<div class="table-responsive">
	<table class="table table-bordered table popup-table" id="wholesale_table">
		<thead>
			<tr>
				<th>Delivery</th>
				<th style="width:25%;">Price</th>
			</tr>
		</thead>
		@def $currency = \App\Models\Currency::where('active', 1)->first()->code
		<tbody id="delivery_table_tbody">
			<tr>
				<td>World</td>
				<td class='editColumn'>
					<div class='pull-left col-sm-4' style='display:inline'>
						<div class="row cur">
							<span style="text-align:left">{{ $currency }}</span>
						</div>
						<div  id="worldloader-{{ $deliveryprice->id }}" class="loader hidden pull-left" style="padding-top:7px;display:inline">
							<div class="row">
								<img class="pull-right" src="{{ asset('images/loader.gif') }}" alt="">
							</div>
						</div>
					</div>	
											
					<div class='pull-left col-sm-8' style='display:inline'>
						<div class="row">
							<span id='world-old-value-{{ $deliveryprice->id }}' class='old-value' style="text-align:right">
								{{ number_format($deliveryprice->del_worldwide/100,2) }}
							</span>
							<div class='hidden editInputField' id='world-{{ $deliveryprice->id }}'>
								<div class="col-sm-10 pull-left">
									<div class="row">
										<input
										style="margin-right:25px"
										data-product="{{ $deliveryprice->id }}" 
										data-route="{{ route('editdeliveryprice') }}" 
										data-id="del_worldwide" 
										class='editWorld form-control input-sm  pull-right' 
										value="{{ $deliveryprice->del_worldwide }}">
									</div>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>West Malaysia</td>
				<td class='editColumn'>
					<div class='pull-left col-sm-4' style='display:inline'>
						<div class="row cur">
							<span style="text-align:left">{{ $currency }}</span>
						</div>
						<div  id="malaysialoader-{{ $deliveryprice->id }}" class="loader hidden pull-left" style="padding-top:7px;display:inline">
							<div class="row">
								<img class="pull-right" src="{{ asset('images/loader.gif') }}" alt="">
							</div>
						</div>
					</div>	
											
					<div class='pull-left col-sm-8' style='display:inline'>
						<div class="row">
							<span id='malaysia-old-value-{{ $deliveryprice->id }}' class='old-value' style="text-align:right">
								{{ number_format($deliveryprice->del_west_malaysia/100,2) }}
							</span>
							<div class='hidden editInputField' id='malaysia-{{ $deliveryprice->id }}'>
								<div class="col-sm-10 pull-left">
									<div class="row">
										<input
										style="margin-right:25px"
										data-product="{{ $deliveryprice->id }}" 
										data-route="{{ route('editdeliveryprice') }}" 
										data-id="del_west_malaysia" 
										class='editMalaysia form-control input-sm  pull-right' 
										value="{{ $deliveryprice->del_west_malaysia }}">
									</div>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>	
			<tr>
				<td>Sabah Labuan</td>
				<td class='editColumn'>
					<div class='pull-left col-sm-4' style='display:inline'>
						<div class="row cur">
							<span style="text-align:left">{{ $currency }}</span>
						</div>
						<div  id="sabahloader-{{ $deliveryprice->id }}" class="loader hidden pull-left" style="padding-top:7px;display:inline">
							<div class="row">
								<img class="pull-right" src="{{ asset('images/loader.gif') }}" alt="">
							</div>
						</div>
					</div>	
											
					<div class='pull-left col-sm-8' style='display:inline'>
						<div class="row">
							<span id='sabah-old-value-{{ $deliveryprice->id }}' class='old-value' style="text-align:right">
								{{ number_format($deliveryprice->del_sabah_labuan/100,2) }}
							</span>
							<div class='hidden editInputField' id='sabah-{{ $deliveryprice->id }}'>
								<div class="col-sm-10 pull-left">
									<div class="row">
										<input
										style="margin-right:25px"
										data-product="{{ $deliveryprice->id }}" 
										data-route="{{ route('editdeliveryprice') }}" 
										data-id="del_sabah_labuan" 
										class='editSabah form-control input-sm  pull-right' 
										value="{{ $deliveryprice->del_sabah_labuan }}">
									</div>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Sarawak</td>
				<td class='editColumn'>
					<div class='pull-left col-sm-4' style='display:inline'>
						<div class="row cur">
							<span style="text-align:left">{{ $currency }}</span>
						</div>
						<div  id="sarawakloader-{{ $deliveryprice->id }}" class="loader hidden pull-left" style="padding-top:7px;display:inline">
							<div class="row">
								<img class="pull-right" src="{{ asset('images/loader.gif') }}" alt="">
							</div>
						</div>
					</div>	
											
					<div class='pull-left col-sm-8' style='display:inline'>
						<div class="row">
							<span id='sarawak-old-value-{{ $deliveryprice->id }}' class='old-value' style="text-align:right">
								{{ number_format($deliveryprice->del_sarawak/100,2) }}
							</span>
							<div class='hidden editInputField' id='sarawak-{{ $deliveryprice->id }}'>
								<div class="col-sm-10 pull-left">
									<div class="row">
										<input
										style="margin-right:25px"
										data-product="{{ $deliveryprice->id }}" 
										data-route="{{ route('editdeliveryprice') }}" 
										data-id="del_sarawak" 
										class='editSarawak form-control input-sm  pull-right' 
										value="{{ $deliveryprice->del_sarawak }}">
									</div>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>			
		</tbody>
	</table>
</div>


<script type="text/javascript">
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

		$('.editWorld').on('blur', function(){
			element = $(this);
			id = element.attr('data-id');
			updatedValue = element.val();
			route = element.attr('data-route');
			productID = element.attr('data-product');

			result = updateFieldByAjax(id, updatedValue, route, productID);
			if(result) setUpdatedWorld(productID,result);
						
		})
		
		$('.editMalaysia').on('blur', function(){
			element = $(this);
			id = element.attr('data-id');
			updatedValue = element.val();
			route = element.attr('data-route');
			productID = element.attr('data-product');

			result = updateFieldByAjax(id, updatedValue, route, productID);
			if(result) setUpdatedMalaysia(productID,result);

		});
		
		$('.editSabah').on('blur', function(){
			element = $(this);
			id = element.attr('data-id');
			updatedValue = element.val();
			route = element.attr('data-route');
			productID = element.attr('data-product');

			result = updateFieldByAjax(id, updatedValue, route, productID);
			if(result) setUpdatedSabah(productID,result);

		});

		$('.editSarawak').on('blur', function(){
			element = $(this);
			id = element.attr('data-id');
			updatedValue = element.val();
			route = element.attr('data-route');
			productID = element.attr('data-product');

			result = updateFieldByAjax(id, updatedValue, route, productID);
			if(result) setUpdatedSarawak(productID,result);

		});		
		
		function updateFieldByAjax(id, updatedValue, route, productID){
			var result;
			//alert(id);
			$.ajax({
				url: route,
				type: "POST",
				data: {
					id : id,
					productID : productID,
					updatedValue : updatedValue
				},
				async: false,
				success: function(response)
				{
					result=response;
				}
			});

			return result;
		}

		function setUpdatedWorld(id, result){
			$('#worldloader-'+ id).removeClass('hidden');
			setTimeout(function () {
		        $('#world-old-value-'+id).html(result).removeClass('hidden');
				$('#world-'+id).addClass('hidden');
				$('.loader').addClass('hidden');
				$('.cur').removeClass('hidden');
		    }, 600);
		}

		function setUpdatedMalaysia(id, result){
			$('#malaysialoader-'+ id).removeClass('hidden');
			setTimeout(function () {
		        $('#malaysia-old-value-'+id).html(result).removeClass('hidden');
				$('#malaysia-'+id).addClass('hidden');
				$('.loader').addClass('hidden');
				$('.cur').removeClass('hidden');
		    }, 600);
			
		}

		function setUpdatedSabah(id, result){
			$('#sabahloader-'+ id).removeClass('hidden');
			setTimeout(function () {
		        $('#sabah-old-value-'+id).html(result).removeClass('hidden');
				$('#sabah-'+id).addClass('hidden');
				$('.loader').addClass('hidden');
				$('.cur').removeClass('hidden');
		    }, 600);
		}
		
		function setUpdatedSarawak(id, result){
			$('#sarawakloader-'+ id).removeClass('hidden');
			setTimeout(function () {
		        $('#sarawak-old-value-'+id).html(result).removeClass('hidden');
				$('#sarawak-'+id).addClass('hidden');
				$('.loader').addClass('hidden');
				$('.cur').removeClass('hidden');
		    }, 600);
		}		


	})
</script>