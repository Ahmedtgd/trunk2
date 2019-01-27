
<div class="table-responsive">
	<table class="table table-bordered table popup-table" id="wholesale_table">
		<thead>
			<tr>
				<th width="10%">No</th>
				<th width="40%">Description</th>
				<th width="50%">Value</th>
			</tr>
		</thead>
		<?php $kk = 0;	?>
		<tbody id="specification_table_tbody">
			@if(isset($specifications))
				@def $currency = \App\Models\Currency::where('active', 1)->first()->code
				@foreach($specifications as $key => $specification)
					<tr>
						<td>{{ $kk = $kk + 1 }}</td>
						<td>{{ $specification->description }}</td>
						<td class='editColumn'>
							<span id='funit-old-value-{{ $specification->spec_id }}' class='old-value'>{{ $specification->value }}</span>
							<div class='hidden editInputField '  id='funit-{{ $specification->spec_id }}'>
								<div class="col-sm-4 pull-left"style="display:inline">
									<div id="funitloader-{{ $specification->spec_id }}" class="loader hidden col-sm-3 pull-left" style="padding-top:7px; display:inline">
										<div class="row">
											<img class='pull-right' src="{{ asset('images/loader.gif') }}" alt="">
										</div>
									</div>
								</div>
								<div class="col-sm-8 pull-left" style="display:inline">
									<div class="row">
										<input data-product="{{ $specification->product_id }}" data-route="{{ route('editSValue') }}" data-id="{{ $specification->spec_id }}" class='editFUnit form-control input-sm' value='{{ $specification->value }}'>
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


		$('.editFUnit').on('blur', function(){
			element = $(this);
			id = element.attr('data-id');
			updatedValue = element.val();
			route = element.attr('data-route');
			productID = element.attr('data-product');

			result = updateFieldByAjax(id, updatedValue, route, productID);
			if(result) setUpdatedFUnit(id,result);
						
		})

		function updateFieldByAjax(id, updatedValue, route, productID){
			var result;
			$.ajax({
				url: route,
				type: "POST",
				data: {
					id : id,
					productID : productID,
					updatedValue : updatedValue,
					type : 'specification'
				},
				async: false,
				success: function(response)
				{
					result = response;
				}
			});

			return result;
		}

		function setUpdatedFUnit(id, result){
			$('#funitloader-'+ id).removeClass('hidden');
			setTimeout(function () {
		        $('#funit-old-value-'+id).html(result).removeClass('hidden');
				$('#funit-'+id).addClass('hidden');
				$('.loader').addClass('hidden');
				$('.cur').removeClass('hidden');
		    }, 600);
		}

	})
</script>