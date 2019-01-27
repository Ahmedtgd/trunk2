<?php 
use App\Http\Controllers\IdController;
?>
 <style>
        .btn-subcat{
            border: none;
            background: #fff;
            padding-left: 0px;
        }
 </style>
    <div id="pinformation" class="row">
        <input type="hidden" value="{{ route('routeFetchFields') }}" id='routeFetchFields'>
        <input type="hidden" value="{{ route('routeFetchFieldsForSpecialPrice') }}" id='routeFetchFieldsForSpecialPrice'>	
		<input type="hidden" value="{{ route('routeFetchFieldsForSpecialPricen') }}" id='routeFetchFieldsForSpecialPricen'>
		<input type="hidden" value="{{ route('routedeletepdealer') }}" id='routedeletepdealer'>
		<input type="hidden" value="{{ route('routegetdealers') }}" id='routegetdealers'>
        <div class="col-sm-12 row">
            <h1>Product Information</h1>
        </div>
        <div class="col-sm-4 thumbnail">
            <div class="product-photo">
                <img class=""  id="preview-imgb2b"
					style="width:100%;height:98%;object-fit:cover;object-position:center top"
					src="{{asset('/')}}images/product/{{$id}}/{{$current_product->photo_1}}"/>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
                {!! Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="name_p">{{$current_product->name}}&nbsp;</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('brand_id', 'Brand', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="brand_p">
					@if(isset($prodbrand))
						{{$prodbrand->name}}
					@endif
					&nbsp;</p>
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('category_id', 'Category', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
					<p id="category_p">
					@if(isset($prodcategory))
						{{$prodcategory->description}}
					@endif
					&nbsp;</p>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('subcat_id', 'Sub Category', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">

                    <p id="subcat_p">
					@if(isset($prodsubcategory))
						{{$prodsubcategory->description}}
					@endif
					&nbsp;</p>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('O-Shop', 'O-Shop', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                   <p id="oshop_p"> {{$oshop}}&nbsp;</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('short_description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="description_p" style="min-height:20px">{{$current_product->description}}&nbsp;</p>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('available', 'Quantity Available', array('class' => 'col-sm-3 control-label')) !!}
				@if(!is_null($current_productb2b))
						<div class="col-sm-9">
							<p id="quantity_ps">{{$current_productb2b->available}}&nbsp;</p>
						</div>
					@else
						<div class="col-sm-9">
							 <p id="quantity_p" class="quantity_ps">Not assigned</p>
						</div>
					@endif
            </div>
        </div>
		
        <div class="clearfix"></div>
    </div>
    <hr>
    <div id="wholesale" class="row">
        <div class="row">
            <div class="col-sm-12">
                <h2>Special Price</h2>
				@if($current_product->retail_price>0)
					<div id='alert_rprice' style="display: none;" class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
						<strong><h4><a href="#">
							<b style="color: red;">
								This product is NOT available in RETAIL
							</b></a></h4>
						</strong>
					</div>	
					<br>
					<div class="row margin-top">
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-sm-2">
									<div class="row">
										{!! Form::label('retail_price11', 'Retail Price', array('class' => 'control-label')) !!}
									</div>
								</div>
								<div class="col-sm-1">
									<div class="row">
										<p id="rPrice_p">{{number_format(($current_product->retail_price/100),2, '.', '')}}</p>
									</div>
								</div>
							</div>
						</div>
						
						<!-- <div class="col-xs-12" style="margin-top:15px">
							<div class="form-group">
								<div class="col-sm-3">
									<div class="row">
										{!! Form::label('discounted_price', 'Discounted Price', array('class' => 'control-label')) !!}
									</div>
								</div>
								<div class="col-sm-5">
									<div class="row">
										{!! Form::text('discounted_price', null, array('class' => 'validator retailSave form-control','id'=>'oPrice' ))!!}
									</div>
								</div>
								<div class="col-sm-4 text-danger" >
									SAVE <span id="resultSave"> 0.0 </span> %
								</div>
							</div>
						</div> -->
					</div>				
				@else
					<div id='alert_rprice' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
						<strong><h4><a href="#">
							<b style="color: red;">
								This product is NOT available in RETAIL
							</b></a></h4>
						</strong>
					</div>					
				@endif
                <br>

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
												<a href="javascript:void(0);" class="sp_popup" rel="{{$sp}}">Special&nbsp;Price</a>
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
															<option value="{{$dealer->id}}">{{IdController::nB($dealer->id) . " - " . $dealer->first_name . " " . $dealer->last_name }} </option>
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
											<a href="javascript:void(0);" class="sp_popup" rel="{{$sp}}">Special&nbsp;Price</a>
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
															<option value="{{$dealer->id}}">{{IdController::nB($dealer->id) . " - "  . $dealer->first_name . " " . $dealer->last_name }} </option>
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
											<a href="javascript:void(0);" class="sp_popup" rel="0">Special&nbsp;Price</a>
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
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
	<div class="col-sm-6">
	</div>
	<div class="col-sm-5">
		<div id="progresscontainsp"></div>
	</div>
	<br>
	<div class="row">
		<p style="float:right;">
			<a href="javascript:void(0)" class="btn btn-info" id="next_sp_product" style="cursor: pointer; font-size: 20px">Save</a>
		</p>
	</div>	
<br/>
<script>
$(document).ready(function () {
	var url = document.location.toString();
	if (url.match('#')) {
		$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
		$('html, body').animate({ scrollTop: 670 }, 'fast');
	}
});
</script>
