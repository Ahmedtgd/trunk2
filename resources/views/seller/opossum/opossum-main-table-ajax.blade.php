<table class="table table-bordered" id="table-main">
						<thead style="background: #6666ff; color: white;">
							<tr>
								<td class='text-center no-sort bsmall'>No</td>
								<td class='text-center bmedium'>Name</td>
								<td class='text-center bmedium'>Descriprion</td>
								<td class='text-center bmedium'>Price</td>
								<td class='text-center bmedium'>Total</td>
								<td style="width: 17%;" class='text-center bmedium'>Quantity</td>
								<td class='text-center bmedium'>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php $index = 0;?>
							@foreach($products as $product)
							<tr>
								<td class='text-center bmedium'>{{++$index}}</td>
								<td class='text-center bmedium'>{{$product->name}}</td>
								<td class='text-center bmedium'>{{$product->description}}</td>
								<td id="price{{$index}}" class='text-center bmedium'>{{$product->retail_price}}</td>

								<td id="pricetotal{{$index}}" class='text-center bmedium'>{{$product->retail_price}}</td>
								<td>  
									<div class="col-lg-10">
										<div class="input-group">
											<span class="input-group-btn">
												<button onclick="minus({{$index}})" type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
													<span class="glyphicon glyphicon-minus"></span>
												</button>
											</span>
											<input disabled="true"  type="text" id="{{$index}}" name="quantity{{$product->id}}" class="form-control input-number" value="1" min="1" max="100">
											<input  type="hidden" id="i{{$index}}" name="quantity{{$product->id}}" class="form-control input-number" value="1" min="1" max="100">
											<span class="input-group-btn">
												<button onclick="plus({{$index}})" type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
													<span class="glyphicon glyphicon-plus"></span>
												</button>
											</span>
										</div>
									</div>
								</td>
								<td class='text-center bmedium'><button type="button" onclick="removefromsession({{$product->id}})" value="{{$product->id}}" class="btn removefromsession btn-danger">Del</button></td>
							</tr>

							
							@endforeach
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><h3>Grand Total</h3></td>
							<h3><td class="h4"><span class="total">{{$total}}</span></td></h3>
						</tbody>
					</table>
					<button type="Submit" class="btn float-right btn-lg btn-success">Submit</button>
					<script type="text/javascript">
     $('#table-main').DataTable({
                "order": [],
                
            }); 
</script>