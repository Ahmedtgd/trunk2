 <?php 
	use App\Classes;
	$fdelb2b = null;
	$flatdelb2b = null;
	$free_qtyb2b = 0;
	//dd($current_productb2b);
	if(!is_null($current_productb2b)){
		$fdelb2b = $current_productb2b->free_delivery;
		$flatdelb2b = $current_productb2b->flat_delivery;
		if($current_productb2b->free_delivery_with_purchase_qty > 0){
			$free_qtyb2b = 1;
		}
	}
	//dd($free_qtyb2b);
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
        <div class="col-sm-4">
            <h1>Product Information</h1>
        </div>
		<div class="col-sm-8">
			@if(Auth::check())
				@if(Auth::user()->hasRole('adm'))
					@if(isset($productapp['approval']['informationb2b']) && !is_null($current_productb2b) && count($wholesaleprod) > 0)
						<div class="action_buttons">
							<?php
							$approvesec = new Classes\SectionApproval('product', 'informationb2b', $id);
							if ($productapp['approval']['informationb2b'] == 'approved') {
								$approvesec->getRejectButtonb2b();
							} else if ($productapp['approval']['informationb2b'] == 'rejected') {
								$approvesec->getApproveButtonb2b();
							} else if ($productapp['approval']['informationb2b'] == '') {
								$approvesec->getAllButtonb2b();
							}
							echo $approvesec->view;
							?>
						</div>
					@endif
				@endif
			@endif
			&nbsp;
		</div>
		<div class="clearfix"></div>
        <div class="col-sm-4 thumbnail">
            <div class="product-photo">
                <img class="img img-responsive"  id="preview-imgb2b"
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
                {!! Form::label('available', 'Qty Allocated for Procurement.', array('class' => 'col-sm-3 control-label','style'=>'color:red;font-weight:normal')) !!}
                <div style="padding-left:0" class="col-sm-9">
					@if(!is_null($current_productb2b))
						<div class="col-sm-4">
							{!! Form::text('available_b2b', $current_productb2b->available, array('class' => 'form-control', 'style'=>'width:100px','id' => 'quantity_vb2b'))!!}
						</div>
					@else
						<div class="col-sm-4">
							{!! Form::text('available_b2b', '0', array('class' => 'form-control', 'style'=>'width:100px','id' => 'quantity_vb2b'))!!}
						</div>
					@endif
                </div>
            </div>
            <div class="form-group">
				<div style="color:red" class="col-sm-12">
				(This element will not affect Merchant Inventory overall quantity movement. It acts independently for procurement purposes. e.g. Even though the warehouse has zero quantity this feature is used for back-to-back purchase of procurement transactions)
				</div>
			</div> 
        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div id="wholesale" class="row">
        <div class="col-sm-7">
            <div class="row">
				<div class="col-sm-6" style="padding-left:0">
					 <h2>Business To Business</h2>
				</div>
				<div class="col-sm-6">
					@if(Auth::check())
						@if(Auth::user()->hasRole('adm'))
							@if(isset($productapp['approval']['b2b']) && !is_null($current_productb2b) && count($wholesaleprod) > 0)
								<div class="action_buttons">
									<?php
									$approvesec = new Classes\SectionApproval('product', 'b2b', $id);
									if ($productapp['approval']['b2b'] == 'approved') {
										$approvesec->getRejectButtonb2b();
									} else if ($productapp['approval']['b2b'] == 'rejected') {
										$approvesec->getApproveButtonb2b();
									} else if ($productapp['approval']['b2b'] == '') {
										$approvesec->getAllButtonb2b();
									}
									echo $approvesec->view;
									?>							
								</div>
							@endif
						@endif
					@endif
				</div>	
				<div class="clearfix"></div>				
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
								<div class="col-sm-3">
									<div class="row">
										<p id="rPrice_p">
										{{$active_currency}}
										{{number_format(($current_product->retail_price/100),2)}}</p>
									</div>
								</div>
							</div>
						</div>
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
                <div class="col-sm-5">
                    <div class="row">
                        <h3>Wholesale Price</h3>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="row margin-top">
                        <span><input type="checkbox" id="checkboxD" class="styled"></span>
                        <span class="">Display wholesale price to public</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive " >
                    <table class="table table-striped noborder" id="wrpTable">
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th colspan="10">Price</th>
                        </tr>
						<?php $wsize = sizeof($wholesaleprod);?>
						
						@if(!is_null($wholesaleprod))
							@foreach($wholesaleprod as $wholesaler)
								<tr class='wrow' data='{{$wp}}' id="wrow-{{$wp}}">
									<td class="col-xs-2">
										<input type="text" class="form-control numeric wfunit" disabled="disabled" value="{{$wholesaler->funit}}" name="wfunit[]" id="wfunit{{$wp}}" rel="{{$wp}}">
										<label id='ferr-{{$wp}}' class='err hidden'>Unit must be greater than 0</label>
									</td>
									<td class="col-xs-2">
										<input type="text" class="form-control numeric wunit" value="{{$wholesaler->unit}}" name="wunit[]" id="wunit{{$wp}}" rel="{{$wp}}">
										<label id='err-{{$wp}}' class='err hidden'>Unit must be greater than <span id='pu-{{$wp}}'></span></label>
									</td>
									<td class="col-xs-3">
										<div class="input-group"  id='wping-{{$wp}}'>
											<span class="input-group-addon">{!! $active_currency !!}</span>
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
										if($wholesaler->price > 0 && $current_product->retail_price > 0){
											$mysaveswr = (($current_product->retail_price - $wholesaler->price)/$current_product->retail_price)*100;
										}
										if($mysaveswr < 0){
											$mysaveswr = 0;
										}
									?>
									<td class='col-xs-4'>
										<div class="input-group">
											<span class="input-group-addon">Margin</span>
											@if($current_product->retail_price > 0)
												<div class="average form-control text-center text-danger"><span id="mar-{{ $wp }}">{{number_format(($mysaveswr),2, '.', '')}}</span></div>
											@else	
												<div class="average form-control text-center text-danger"><span id="mar-{{ $wp }}">N.A</span></div>
											@endif
											<span class="input-group-addon">%</span>
										</div>
									</td>
								</tr>
								<input type="hidden" id="wholesale{{$wp}}" name="wholesalepricesa[]" value="{{number_format(($wholesaler->price/100),2, '.', '')}}" >
								<input type="hidden" id="wfunitn{{$wp}}" name="wholesalefunits[]" value="{{$wholesaler->funit}}" >
								<input type="hidden" id="wunitn{{$wp}}" name="wholesaleunits[]" value="{{$wholesaler->unit}}" >
								<?php $wp++; ?>
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
										<span class="input-group-addon">{!! $active_currency !!}</span>
										<input id='wprice-0' type="text" disabled class="form-control myr-price wholesale wholesalep" rel="0" name="wprice[]">
									</div>
									<label id='errp-0' class='err hidden'>Price must be smaller than <span id='p-0'></span> and grater than 1</label>
									<label id='errx' class='err hidden'>Retail Price must be assigned in Retail segment</span></label>
								</td>
								<td class='col-xs-1'>
									<a  href="javascript:void(0);" id="addrsp"  class="form-control die text-center text-green"><i class="fa fa-plus-circle"></i></a>
								</td>
								<td class='col-xs-4'>
									<div class="input-group">
										<span class="input-group-addon">Margin</span>
										<div class="average form-control text-center text-danger">
										<span id="mar-0">0.00</span></div>
										<span class="input-group-addon">%</span>
									</div>
								</td>
							</tr>
						@endif
                    </table>
 					<div style="color:red">
					Price for qty more than the highest number will follow the price of the last tier.
					</div> 
					<input id="wholesaleprices" name="wholesaleprices" type="hidden" value="{{$wp}}" />
					@for($w = $wp; $w < 20; $w++)
						<input type="hidden" id="wholesale{{$w}}" name="wholesalepricesa[]" value="0" >
						<input type="hidden" id="wfunitn{{$w}}" name="wholesalefunits[]" value="0" >
						<input type="hidden" id="wunitn{{$w}}" name="wholesaleunits[]" value="0" >
					@endfor
					
                </div>
            </div>
        </div>
        <div class="col-sm-5">
			<div style="padding-left:0;margin-bottom:15px"
				class="col-sm-12">
				<h2>Delivery</h2>

				{{--Paul on 15 May 2017 at 10 40 pm--}}
				{{--<label class="radio-inline"><input type="radio" value="system" name="del_option" {{$disable_del_option_b2b}} {{ $checked_system_option_b2b }}>System Delivery</label>--}}
				{{--<label class="radio-inline"><input type="radio" value="own" name="del_option" {{$disable_del_option_b2b}} {{ $checked_own_option_b2b }}>Own Delivery</label>--}}
				{{--<label class="radio-inline"><input type="radio" value="pickup" name="del_option" {{$disable_del_option_b2b}}>Pick up Only</label>--}}
				<?php 
					$toastrclass = "";
					$canown = 1;
					if(is_null($logistic_id)){
						$toastrclass = "all_own_toastr";
						$canown = 0;
					}
				?>				
				<label class="radio-inline"><input type="radio" value="system" name="del_option_b2b" {{$disable_sys_b2b}} {{ $checked_system_option_b2b }}>System Delivery</label>
				<label class="radio-inline"><input type="radio" value="own" class='{{$toastrclass}}' name="del_option_b2b" {{ $disable_own_b2b }} {{ $checked_own_option_b2b }}>Own Delivery</label>
				<label class="radio-inline"><input type="radio" value="pickup" name="del_option_b2b" {{ $disable_pu_b2b }} {{ $checked_pick_up_only_b2b }}>Pick up Only</label>
				<br>
				<label class="radio-inline"><input type="radio" value="warranty" name="del_option_b2b" {{$checked_warranty_option_b2b}}>Warranty</label>

			</div>	
			<div id="own_delivery_b2b" @if($checked_system_option_b2b == 'checked' ||$checked_pick_up_only_b2b == 'checked') style="display:none;"@endif>
				<h3>Delivery Coverage</h3>
				<div class="row margin-top">
					<div class="col-sm-3">
						{!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
					</div>
					<div class="col-sm-9" >
						<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_countryb2b" id="country_idb2b" disabled>
							<option value="150">Malaysia</option>
						</select>
					</div>
				</div>
				<input type="hidden" id="cov_country_idb2b" name="cov_country_idb2b" value="150">
				<div class="row margin-top">
					<div class="col-sm-3">
						{!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
					</div>
					<div class="col-sm-9">
						<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="statesb2b" name="cov_state_idb2b" data-style="btn-green" required>
						<option value="">Choose Option</option>
							@foreach($states as $state)
								<?php
									$selected_state = "";
									if(!is_null($current_productb2b)){
										if($state->id == $current_productb2b->cov_state_id){
											$selected_state = "selected";
										}
									}
								?>
								<option value="{{$state->id}}" {{$selected_state}}>{{$state->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row margin-top">
					<div class="col-sm-3">
						{!! Form::label('cov_city_id', 'City', array('class' => 'control-label')) !!}
					</div>
					<div class="col-sm-9">
						<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="citiesb2b" name="cov_city_idb2b" data-style="btn-green" required>
							<option value="">Choose Option</option>
							@foreach($city as $cities)
								<?php
									$selected_city = "";
									if(!is_null($current_productb2b)){
										if($cities->id == $current_productb2b->cov_city_id){
											$selected_city = "selected";
										}
									}
								?>
								<option value="{{$cities->id}}" {{$selected_city}}>{{$cities->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				 <div class="row margin-top">
					<div class="col-sm-3">
						{!! Form::label('cov_area_id', 'Area', array('class' => 'control-label')) !!}
					</div>
					<div class="col-sm-9">
						<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="areasb2b" name="cov_area_idb2b" data-style="btn-green">
							<option value="0" selected>Choose Option</option>
							@foreach($areas as $area)
								<?php
									$selected_area = "";
									if(!is_null($current_productb2b)){
										if($area->id == $current_productb2b->cov_area_id){
											$selected_area = "selected";
										}
									}
								?>
								<option value="{{$area->id}}" {{$selected_area}}>{{$area->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>

				<h3>Delivery Pricing</h3>
				<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
				<div class="toggleDeliveryb2b2">
					<div class="row margin-top" style="display: none;">
						<div class="col-sm-4">
							{!! Form::label('del_worldwide', 'World Wide', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-8">
							@if(isset($current_productb2b))
								{!! Form::text('del_worldwideb2b', number_format(($current_productb2b->b2b_del_worldwide/100),2, '.', ''), array('class' => 'form-control delivery_pricesb2b'))!!}
							@else
								{!! Form::text('del_worldwideb2b', null, array('class' => 'form-control delivery_pricesb2b'))!!}
							@endif
						</div>
					</div>
					<div class="row margin-top">
						<div class="col-sm-4">
							{!! Form::label('del_west_malaysia', 'Price Per Unit', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-8">
							@if(isset($current_productb2b))
								{!! Form::text('del_west_malaysiab2b', number_format(($current_productb2b->b2b_del_west_malaysia/100),2, '.', ''), array('class' => 'form-control delivery_pricesb2b'))!!}
							@else
								{!! Form::text('del_west_malaysiab2b', null, array('class' => 'form-control delivery_pricesb2b'))!!}
							@endif
						</div>
					</div>
					<div class="row margin-top" style="display: none;">
						<div class="col-sm-4">
							{!! Form::label('del_sabah_labuan', 'Sabah/Labuan', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-8">
							@if(isset($current_productb2b))
								{!! Form::text('del_sabah_labuanb2b', number_format(($current_productb2b->b2b_del_sabah_labuan/100),2, '.', ''), array('class' => 'form-control delivery_pricesb2b'))!!}
							@else
								{!! Form::text('del_sabah_labuanb2b', null, array('class' => 'form-control delivery_pricesb2b'))!!}
							@endif
						</div>
					</div>
					
					<div class="row margin-top" style="display: none;">
						<div class="col-sm-4">
							{!! Form::label('del_sarawak', 'Sarawak', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-8">
							@if(isset($current_productb2b))
								{!! Form::text('del_sarawakb2b', number_format(($current_productb2b->b2b_del_sarawak/100),2, '.', ''), array('class' => 'form-control delivery_pricesb2b'))!!}
							@else
								{!! Form::text('del_sarawakb2b', null, array('class' => 'form-control delivery_pricesb2b'))!!}
							@endif
						</div>
					</div>
				</div>
				<div class="checkbox checkbox-success" style="margin-left:0">
					@if($flatdelb2b == 1)
						{!! Form::checkbox('flat_deliveryb2b', 1, null, ['class' => 'styled','id'=>'checkboxFb2b', 'checked'=>'checked']) !!}
					@else
						{!! Form::checkbox('flat_deliveryb2b', 1, null, ['class' => 'styled','id'=>'checkboxFb2b']) !!}
					@endif
						{!! Form::label('checkbox1', 'Flat Delivery Price') !!}
					
				</div>	
				</div>
				<div class="clearfix"></div>
				<div class="checkbox checkbox-success">
					@if($fdelb2b == 1)
						{!! Form::checkbox('free_deliveryb2b_ow', 1, null, ['class' => 'styled','id'=>'checkboxDb2b', 'checked'=>'checked']) !!}
					@else
						@if($free_qtyb2b == 1)
							{!! Form::checkbox('free_deliveryb2b_ow', 1, null, ['class' => 'styled','id'=>'checkboxDb2b', 'disabled'=>'disabled']) !!}
						@else
							{!! Form::checkbox('free_deliveryb2b_ow', 1, null, ['class' => 'styled','id'=>'checkboxDb2b']) !!}
						@endif
						
					@endif
					{!! Form::label('checkbox1', 'Free Delivery') !!}
				</div>

				<div class="col-sm-10 checkbox checkbox-success">
					@if($fdelb2b == 1)
						{!! Form::checkbox('free_delivery_qtyb2b_ow', 1, null, ['class' => 'styled','id'=>'checkboxDqb2b', 'disabled'=>'disabled']) !!}
					@else
						@if($free_qtyb2b == 1)
							{!! Form::checkbox('free_delivery_qtyb2b_ow', 1, null, ['class' => 'styled','id'=>'checkboxDqb2b', 'checked'=>'checked']) !!}
						@else
							{!! Form::checkbox('free_delivery_qtyb2b_ow', 1, null, ['class' => 'styled','id'=>'checkboxDqb2b']) !!}
						@endif
					@endif
					{!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}

				</div>
				<div class="col-sm-2" style="padding-right:0">
					@if($free_qtyb2b == 1)
						{!! Form::text('free_delivery_with_purchase_qtyb2b',
						number_format(($current_productb2b->free_delivery_with_purchase_qty/100),2, '.', ''),
						array('class' => 'form-control delivery_waiver_min_amt_b2b','id'=>'checkboxDqnb2b',
						'style'=>'margin-top:-12px;margin-left:0px;width:100px;text-align:right;float:right;'))!!}
					@else
						{!! Form::text('free_delivery_with_purchase_qtyb2b',
						'0.00',
						array('class' => 'form-control delivery_waiver_min_amt_b2b',
						'disabled' => 'disabled','id'=>'checkboxDqnb2b',
						'style'=>'margin-top:-12px;margin-left:0px;width:100px;text-align:right;float:right;'))!!}
					@endif
				</div>
            </div>
            <div id="system_delivery_b2b" @if($checked_own_option_b2b == 'checked' || $checked_pick_up_only_b2b == 'checked') style="display:none;" @endif>
				{{--
					<input type="hidden" id="cms_pricing_b2b" value="{{ $global_system_vars->cms_pricing }}" />
					<input type="hidden" id="grs_pricing_b2b" value="{{ $global_system_vars->grs_pricing }}" />
					<input type="hidden" id="mts_pricing_b2b" value="{{ $global_system_vars->mts_pricing }}" />
					<h3>Delivery Requirements</h3>
					<div class="delivery_requirements">
						<div style='margin-bottom:5px' class="form-group">
							{!! Form::label('del_width', 'Width', array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">
								{!! Form::text('del_width_b2b', number_format($current_product->del_width,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'del_width_b2b'))!!}
							</div>
							<div class="col-sm-1">
							cm
							</div>
						</div>
						<div style='margin-bottom:5px' class="form-group">
							{!! Form::label('del_lenght', 'Lenght', array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">
								{!! Form::text('del_lenght_b2b', number_format($current_product->del_lenght,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'del_lenght_b2b'))!!}
							</div>
							<div class="col-sm-1">
							cm
							</div>							
						</div>
						<div style='margin-bottom:5px' class="form-group">
							{!! Form::label('del_height', 'Height', array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">
								{!! Form::text('del_height_b2b', number_format($current_product->del_height,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'del_height_b2b'))!!}
							</div>
							<div class="col-sm-1">
							cm
							</div>							
						</div>
						<div style='margin-bottom:5px' class="form-group">
							{!! Form::label('del_weight', 'Weight', array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">
								{!! Form::text('del_weight_b2b', number_format($current_product->del_weight,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'del_weight_b2b'))!!}
							</div>
							<div class="col-sm-1">
							grs
							</div>							
						</div>
					</div>					
					<br>
					--}}
					<h3>Business Coverage</h3>
					<div style='margin-bottom:5px' class="form-group">
						{!! Form::label('cov_country_id', 'Country', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9" >
							<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country" id="country_id" disabled>
								<option value="150">Malaysia</option>
							</select>
						</div>
					</div>
					<input type="hidden" id="cov_country_id" name="biz_country_id" value="150">
					<div style='margin-bottom:5px' class="form-group">
						{!! Form::label('cov_state_id', 'State', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="states_biz_b2b" name="biz_state_id_b2b" data-style="btn-green">
							<option value="0" disabled="" selected="">Choose Option</option>
								@foreach($states as $state)
									<?php
										$selected_state = "";
										if(!is_null($current_productb2b)){	
											//dd($current_productb2b);
											if($state->id == $current_productb2b->cov_state_id){
												$selected_state = "selected";
											}
										}
									?>								
									<option value="{{$state->id}}" {{$selected_state}}>{{$state->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div style='margin-bottom:5px' class="form-group">
						{!! Form::label('cov_city_id', 'City', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="cities_biz_b2b" name="biz_city_id_b2b" data-style="btn-green">
								<option value="0">Choose Option</option>
								@foreach($city as $cities)
									<?php
										$selected_city = "";
										if(!is_null($current_productb2b)){	
											if($cities->id == $current_productb2b->cov_city_id){
												$selected_city = "selected";
											}
										}
									?>
									<option value="{{$cities->id}}" {{$selected_city}}>{{$cities->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					 <div style='margin-bottom:5px' class="form-group">
						{!! Form::label('cov_area_id', 'Area', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="areas_biz_b2b" name="biz_area_id_b2b" >
								<option value="0" selected>Choose Option</option>
								@foreach($areas as $area)
									<?php
										$selected_area = "";
										if(!is_null($current_productb2b)){	
											if($area->id == $current_productb2b->cov_area_id){
												$selected_area = "selected";
											}
										}
									?>
									<option value="{{$area->id}}" {{$selected_area}}>{{$area->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="clearfix"> </div>
					<br>	
					<?php 
						//$calc_pricing = ($current_product->del_width * $current_product->del_lenght * $current_product->del_height * $global_system_vars->cms_pricing) + ($current_product->del_weight * $global_system_vars->grs_pricing);
					?>
					<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
					<div style='margin-bottom:5px' class="form-group">
						{!! Form::label('del_pricing', 'Pricing', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-4">
							{!! Form::text('del_pricing_b2b', number_format($delivery_pricec/100,2, '.', ''), array('class' => 'form-control delivery_prices','id' => 'del_pricing_b2b','disabled'))!!}
						</div>
						<div class="clearfix"> </div>
						<div class="col-sm-3">
						&nbsp;
						</div>
						<div class="col-sm-9">
							<p style="color: red;">The price calculated here is an estimate. Actual price depends on the logistic provider.</p>
						</div>						
					</div>
					</div>
					<div class="clearfix"> </div>
					<br>
					<div class="checkbox checkbox-success" style="margin-left:0">
						@if($fdelb2b == 1)
							{!! Form::checkbox('free_deliveryb2b_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD_b2b', 'checked'=>'checked']) !!}
						@else
							@if($free_qtyb2b == 1)
								{!! Form::checkbox('free_deliveryb2b_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD_b2b', 'disabled'=>'disabled']) !!}
							@else
								{!! Form::checkbox('free_deliveryb2b_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD_b2b']) !!}
							@endif
						@endif
						
						{!! Form::label('checkbox1', 'Free Delivery') !!}
					</div>

					<div class="col-sm-8 checkbox checkbox-success" style="margin-left:0">
						@if($fdelb2b == 1)
							{!! Form::checkbox('free_delivery_qtyb2b_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxDq_b2b','disabled'=>'disabled']) !!}
						@else
							@if($free_qtyb2b == 1)
								{!! Form::checkbox('free_delivery_qtyb2b_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxDq_b2b', 'checked'=>'checked']) !!}
							@else
								{!! Form::checkbox('free_delivery_qtyb2b_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxDq_b2b']) !!}
							@endif
						@endif
						{!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}

					</div>
					<div class="col-sm-4" style="padding-right:0">
						@if($free_qtyb2b == 1)
							{!! Form::text('free_delivery_with_purchase_qtyb2b_ow',
							number_format(($current_productb2b->delivery_waiver_min_amt/100),2, '.', ''),
							array('class'=>'form-control delivery_waiver_min_amt_b2b','id'=>'sd_checkboxDqn_b2b',
							'style'=>'margin-top:-12px;margin-right:15px;width:100px;text-align:right;float:right;'))!!}
						@else
							{!! Form::text('free_delivery_with_purchase_qtyb2b_ow',
							'0.00',
							array('class'=>'form-control delivery_waiver_min_amt_b2b',
							'disabled' => 'disabled','id'=>'sd_checkboxDqn_b2b',
							'style'=>'margin-top:-12px;margin-right:15px;width:100px;text-align:right;float:right;'))!!}
						@endif
					</div>
				</div>
			
        </div>
        <div class="clearfix"> </div>
    </div>
    <hr>

    <div id="product" class="row">
        <div class="col-sm-12">
			<div class="col-sm-4" style="padding-left:0">
				<h2>Product Details</h2>
			</div>
			<div class="col-sm-8">
				@if(Auth::check())
					@if(Auth::user()->hasRole('adm'))
						@if(isset($productapp['approval']['detailb2b']) && !is_null($current_productb2b) && count($wholesaleprod) > 0)
							<div class="action_buttons">
								<?php
								$approvesec = new Classes\SectionApproval('product', 'detailb2b', $id);
								if ($productapp['approval']['detailb2b'] == 'approved') {
									$approvesec->getRejectButtonb2b();
								} else if ($productapp['approval']['detailb2b'] == 'rejected') {
									$approvesec->getApproveButtonb2b();
								} else if ($productapp['approval']['detailb2b'] == '') {
									$approvesec->getAllButtonb2b();
								}
								echo $approvesec->view;
								?>							
							</div>
						@endif
					@endif
				@endif
			</div>	
			<div class="clearfix"></div>
			@if(!is_null($current_productb2b))	
				{!! Form::textarea('product_detailsb2b', $current_productb2b->product_details, array('class' => 'form-control','id'=>'info-detailsb2b'))!!}
			@else
				{!! Form::textarea('product_detailsb2b', null, array('class' => 'form-control','id'=>'info-detailsb2b'))!!}
			@endif
        </div>		
        <div class="clearfix"> </div>
    </div>

    <div id="product" class="row">
        <div class="col-xs-4" style="padding-left:0">
            <h2>Specifications</h2>
        </div>
		<div class="col-xs-8">
			@if(Auth::check())
				@if(Auth::user()->hasRole('adm'))
					@if(isset($productapp['approval']['specificationb2b']) && !is_null($current_productb2b) && count($wholesaleprod) > 0)
						<div class="action_buttons">
							<?php
							$approvesec = new Classes\SectionApproval('product', 'specificationb2b', $id);
							if ($productapp['approval']['specificationb2b'] == 'approved') {
								$approvesec->getRejectButtonb2b();
							} else if ($productapp['approval']['specificationb2b'] == 'rejected') {
								$approvesec->getApproveButtonb2b();
							} else if ($productapp['approval']['specificationb2b'] == '') {
								$approvesec->getAllButtonb2b();
							}
							echo $approvesec->view;
							?>							
						</div>
					@endif
				@endif
			@endif
		</div>	
        <div class="clearfix"></div>
		@if(!is_null($current_productb2b))
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Length', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-3 mt">
					{!! Form::text('prod_lengthb2b', $current_productb2b->length, array('class' => 'form-control delivery_require','id' => 'prod_lengthb2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>	
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Width', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-3 mt">
					{!! Form::text('prod_widthb2b', $current_productb2b->width, array('class' => 'form-control delivery_require','id' => 'prod_widthb2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>		
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Height', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-3 mt">
					{!! Form::text('prod_heightb2b', $current_productb2b->height, array('class' => 'form-control delivery_require','id' => 'prod_heightb2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>	
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Weight', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-3 mt">
					{!! Form::text('prod_weightb2b', $current_productb2b->weight, array('class' => 'form-control delivery_require','id' => 'prod_weightb2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'kg', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Delivery Time', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-1 mt">
					{!! Form::text('prod_del_timeb2b', $current_productb2b->delivery_time, array('class' => 'form-control delivery_require2','id' => 'prod_del_timeb2b'))!!}
				</div>
				<div class="col-sm-1 mt">
					<center style="margin-top:10px"><b>To</b></center>
				</div>
				<div class="col-sm-1 mt">
					{!! Form::text('prod_del_time_tob2b',  number_format($current_productb2b->delivery_time_to,2, '.', ''), array('class' => 'form-control delivery_require2','id' => 'prod_del_time_tob2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'working days', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                {!! Form::label('serial_no', 'Serial No./IMEI', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                <div class="col-sm-3 mt" style="margin-top:0">
                    <input  name="has_serialno" type="checkbox"
                   value="1" 
                    @if($current_productb2b->has_serialno==1)
                   checked="checked"
                   @endif 
                    
                   >
                </div>
             
                <div class="clearfix"></div>
            </div>			
		@else
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Length', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-3 mt">
					{!! Form::text('prod_lengthb2b', '', array('class' => 'form-control delivery_require','id' => 'prod_lengthb2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>	
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Width', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-3 mt">
					{!! Form::text('prod_widthb2b', '', array('class' => 'form-control delivery_require','id' => 'prod_widthb2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>		
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Height', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-3 mt">
					{!! Form::text('prod_heightb2b', '', array('class' => 'form-control delivery_require','id' => 'prod_heightb2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>	
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Weight', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-3 mt">
					{!! Form::text('prod_weightb2b', '', array('class' => 'form-control delivery_require','id' => 'prod_weightb2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'kg', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>	
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Delivery Time', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-1 mt">
					{!! Form::text('prod_del_timeb2b', '', array('class' => 'form-control delivery_require2','id' => 'prod_del_timeb2b'))!!}
				</div>
				<div class="col-sm-1 mt">
					<center style="margin-top:10px"><b>To</b></center>
				</div>
				<div class="col-sm-1 mt">
					{!! Form::text('prod_del_time_tob2b',  '', array('class' => 'form-control delivery_require2','id' => 'prod_del_time_tob2b'))!!}
				</div>
				{!! Form::label('product_specification_2', 'working days', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                {!! Form::label('serial_no', 'Serial No./IMEI', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                <div class="col-sm-3 mt" style="margin-top:0">
                    <input  name="has_serialno" type="checkbox"
                   value="1"
                   >
                </div>
             
                <div class="clearfix"></div>
            </div>			
		@endif	
    </div>  	

    <div class="row">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
		{{--
        <div class="row">
            <div class="col-sm-12 text-right">
				<p style="float:right;"><img class="img-responsive"  id="next_b2b" style="cursor: pointer; width: 100px;" src="{{asset('/')}}images/next_page.png" alt="" /></p>
            </div>
        </div>
		--}}
			<div class="col-sm-6">
			</div>
            <div class="col-sm-5">
				<div class="w3-light-grey w3-round-large" id="totalBarb2b" style="display: none;">
					<div class="w3-container w3-blue w3-round-large" style="width:0%" id="myBarb2b">0%</div>
				</div>					
			</div>
            <div class="col-sm-1">
                <p style="float:right;">
					<a href="javascript:void(0)" class="btn btn-info" id="next_b2b_product" style="cursor: pointer; font-size: 20px">Save</a>
                </p>
            </div>		
   {{--     <div class="row">
            <div class="col-sm-12 text-right">
				<p style="float:right;"><img class="img-responsive"  id="next_b2b_product" style="cursor: pointer; width: 100px;" src="{{asset('/')}}images/next_product.png" alt="" /></p>
            </div>
        </div>
		<div class="row">
			<div class="col-sm-offset-11 col-sm-1">
					<p align="right" style=" float:right; display:none;" id="next_b2b_spinner"><i class="fa-li fa fa-spinner fa-spin fa-2x fa-fw" style=" float:right;"></i></p>
			</div>
		</div> --}}
<br/><br/>
{!! Form::close() !!}
<div class="modal fade" id="myModalSecRemarksb2b" role="dialog" aria-labelledby="myModalRemarksb2b">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="secremarks-formb2b">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_secremarksb2b" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_secremarksb2b" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_secrole_roleIdb2b" remarks_role="" >
							<input type="hidden" id="current_secstatusb2b" value="" >
							<input type="hidden" id="current_sectionb2b" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>
<script>
$(document).ready(function () {
	var url = document.location.toString();
	if (url.match('#')) {
		$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
		$('html, body').animate({ scrollTop: 670 }, 'fast');
	}
});
</script>
