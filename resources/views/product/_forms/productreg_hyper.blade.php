 <?php 
 	$fdelhyper = null;
	$flatdelhyper = null;
	$free_qtyhyper = 0;
	//dd($current_productb2b);
	if(!is_null($hyper)){
		$fdelhyper = $hyper->free_delivery;
		$flatdelhyper = $hyper->flat_delivery;
		if($hyper->free_delivery_with_purchase_qty > 0){
			$free_qtyhyper = 1;
		}
	}
 ?>   
	<style>
		@media only screen and (max-width: 1200px) {
			.mediaheight{
				height: 110px;
			}
		}
		
		@media only screen and (min-width: 1201px) {
			.mediaheight{
				height: 90px;
			}
		}
	</style>
	<div id="pinformation" class="row">
        <input type="hidden" value="{{ route('routeFetchFields') }}" id='routeFetchFields'>
        <input type="hidden" value="{{ route('routeFetchFieldsForSpecialPrice') }}" id='routeFetchFieldsForSpecialPrice'>
        <div class="col-sm-12 row">
            <h1>Product Registration</h1>
        </div>
        <div class="col-sm-4 thumbnail" id='thumbnail'>
            <div class="product-photo">
				@if(is_null($current_product))
					<img class="img img-responsive"
					style="width:100%;height:98%;object-fit:cover;object-position:center top"
					id="preview-imghyper"/>
				@else
					<img class="img img-responsive"  id="preview-imgb2b"
					style="width:100%;height:98%;object-fit:cover;object-position:center top"
					src="{{asset('/')}}images/product/{{$id}}/{{$current_product->photo_1}}"/>
				@endif
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
                {!! Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
					@if(is_null($current_product))
						<p id="name_p" class="name_p">Not assigned</p>
					@else
						<p id="name_p" class="name_p">{{$current_product->name}}&nbsp;</p>
					@endif
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('brand_id', 'Brand', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
					@if(is_null($current_product))
						<p id="brand_p" class="brand_p">Not assigned</p>
					@else
						<p id="brand_p" class="brand_p">
						@if(isset($prodbrand))
							{{$prodbrand->name}}
						@endif
						&nbsp;</p>
					@endif
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('category_id', 'Category', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
					@if(is_null($current_product))
						<p class="category_p">Not assigned</p>
					@else
						<p class="category_p">
						@if(isset($prodcategory))
							{{$prodcategory->description}}
						@endif
						&nbsp;</p>
					@endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('subcat_id', 'Sub Category', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
					@if(is_null($current_product))
						<p id="subcat_p" class="subcat_p">Not assigned</p>
					@else
						<p id="subcat_p" class="subcat_p">
						@if(isset($prodsubcategory))
							{{$prodsubcategory->description}}
						@endif
						&nbsp;</p>
					@endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('O-Shop', 'O-Shop', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
					 <p id="oshop_p" class="oshop_p">{{(empty($oshop))?"&nbsp;":$oshop}}</p>
				</div>
			</div>
            <div class="form-group">
                {!! Form::label('short_description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
					@if(is_null($current_product))
						<p id="description_p" class="description_p">Not assigned</p>
					@else
						<p id="description_p" class="description_p" style="min-height:20px">{{$current_product->description}}&nbsp;</p>
					@endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-7 col-sm-offset-3">
<!--                     <table class="table noborder">
                        <tr><th>Amount</th><td>{!! $active_currency !!}</td><td><span id="retail_amount">0.00</span></td></tr>
                        <tr><th>Delivery</th><td>{!! $active_currency !!}</td><td><span id="retail_delivery">0.00</span></td></tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-sm btn-number" data-type="plus" id="plus_b2b" data-field="">
                                  <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                </span>
                                <input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
                                type="text" name="" class="form-control input-number quantity" id="cantp_b2b"
                                value="1">
                                <span class="input-group-btn" style="float:left">
                                <button type="button" class="btn btn-info btn-sm btn-number"  data-type="minus" id="minus_b2b" data-field="">
                                  <span class="glyphicon glyphicon-minus"></span>
                                </button>
                                </span>
                                </div>
                            </td>
                            <td>{!! $active_currency !!}</td><td><span id="retail_total">0.00</span></td>
                        </tr>
                    </table> -->
                </div>
            </div>
            <div class="form-group">
                <div class=" col-sm-7 col-sm-offset-3" style="margin-top: 0px;">
<!--                     <li class="btn btn-green btn-sm" style="background-size : 100% 100%; background-image: url('{{ url() }}/images/shopping_cart_button.png')">
                        <button class='btn-link' type='submit'>
                        </button>
                    </li> -->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div id="wholesale" class="row">
            <div class="col-sm-12">

            </div>
        <div class="col-sm-7">
            <div class="row">
                <h2>Hyper</h2>
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
                        <div class="form-group" style="margin:0">
                            <div class="col-sm-2">
                                <div class="row">
                                    {!! Form::label('retail_price11', 'Retail Price', array('class' => 'control-label','style'=>'padding-top:0')) !!}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="row">
									@if(is_null($current_product))
										<p style="margin-bottom:0" id="rPrice_p" class="rPrice_p">Not assigned</p>
									@else		
										<p style="margin-bottom:0" id="rPrice_p" class="rPrice_p">{{number_format($current_product->private_retail_price/100,2,'.',',')}}</p>
									@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>			
            </div>
            <div class="row">
                <div >
					<div class="row no-padding">
						{!! Form::label('available', 'MOQ/Location', array('class' => 'col-sm-4 control-label')) !!}
						{!! Form::label('available', 'MOQ', array('class' => 'col-sm-4 control-label')) !!}	
						{!! Form::label('price', 'Price', array('class' => 'col-sm-4 control-label')) !!}
					</div>	
					<?php 
						$disabled_moq = "";
						$disabled_rest = "";
						$moq_location = 0;
						if(!is_null($hyper)){
							$disabled_moq = "disabled";
						} else {
							$disabled_rest = "disabled";
							$moq_location = 1;
						}
					?>
					<input type="hidden" value="{{$moq_location}}" id="moq_location" />
					<input type="hidden" value="0" id="isreset" />
					<div class="row no-padding">
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm btn-number" {{$disabled_moq}} data-type="plus" id="plusmoqcaf" data-field="">
									  <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
								@if(!is_null($hyper))
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="" class="form-control input-number" id="moqcaf" {{$disabled_moq}}
									value="{{$hyper->owarehouse_moqperpax}}">
								@else
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="" class="form-control input-number" id="moqcaf" {{$disabled_moq}}
									value="1">
								@endif
								<span class="input-group-btn" style="float:left">
									<button type="button" class="btn btn-info btn-sm btn-number" {{$disabled_moq}}  data-type="minus" id="minusmoqcaf" data-field="">
									  <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
								@if(!is_null($hyper))
									<span class="input-group-btn" style="float:left; margin-left: 40px;">
										<button type="button" class="btn btn-warning btn-sm btn-number" id="setcaf" data-field="">
										  <span class="glyphicon glyphicon-transfer" id="setcafgly"></span>
										</button>
									</span>	
									
								@else
									<span class="input-group-btn" style="float:left; margin-left: 40px;">
										<button type="button" class="btn btn-success btn-sm btn-number" id="setcaf" data-field="">
										  <span class="glyphicon glyphicon-check" id="setcafgly"></span>
										</button>
									</span>	
								@endif			
							</div>
						</div>	
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm btn-number" {{$disabled_rest}} data-type="plus" id="plusmoq" data-field="">
									  <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
								@if(!is_null($hyper))
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="" {{$disabled_rest}} class="form-control input-number" id="moq"
									value="{{$hyper->owarehouse_moq}}">
								@else
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="" {{$disabled_rest}} class="form-control input-number" id="moq"
									value="1">
								@endif
								<span class="input-group-btn" style="float:left">
									<button type="button" class="btn btn-info btn-sm btn-number" {{$disabled_rest}} data-type="minus" id="minusmoq" data-field="">
									  <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-group">
								@if(!is_null($hyper))
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:120px;float:left;"
									type="text" name="" class="form-control" id="hyperprice" {{$disabled_rest}}
									placeholder="Enter Price" value="{{$hyper->owarehouse_price/100}}">
									<?php 
										$saveh = number_format((($current_product->private_retail_price - $current_product->owarehouse_price)/$current_product->private_retail_price)*100,2, '.', '');
										if($saveh < 0){
											$saveh = number_format(0,2);
										}
										if($hyper->owarehouse_price == 0){
											$saveh = number_format(0,2);
										}
									?>
									<p class="text-danger">SAVE <span id="resultSaveh">{{$saveh}}</span>%</p>
								@else
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:120px;float:left;"
									type="text" name="" class="form-control" id="hyperprice" value="0.00" {{$disabled_rest}}
									placeholder="Enter Price">
									<br>
									<br>
									<p class="text-danger" id="save_hyper">SAVE <span id="resultSaveh">0.0</span>%</p>
									<p class="text-danger" id="error_hyper" style="display: none;">Hyper price cannot be greater than retail price and cannot be 0</p>
								@endif
								
							</div>	
						</div>
					</div>
					<div class="row no-padding">
						{!! Form::label('available', 'Maximum', array('class' => 'col-sm-4 control-label')) !!}
						<div class="col-sm-4" >
							<div class="input-group">
								<center>
								@if(!is_null($hyper))
									@if($owarehousepledges == 0)
										<button type="button" id="remove_hyper" class="btn btn-danger">Remove</button>&nbsp;&nbsp;&nbsp;
									@else
										<button type="button" id="noremove_hyper" class="btn btn-danger">Remove</button>&nbsp;&nbsp;&nbsp;
									@endif
								@else
									<button type="button" id="nremove_hyper" class="btn btn-danger">Remove</button>&nbsp;&nbsp;&nbsp;
								@endif
								</center>
							</div>
						</div>
						<div class="col-sm-4">
							@if(!is_null($hyper))
								<div style="color: #000;" id="pledges_values">
									<span><strong>P:{{$owarehousepledgers}}&nbsp;Q:{{$owarehousepledges}}</strong></span>
								</div>
								<input type="hidden" id="pledgesqty" value="{{$owarehousepledges}}" />
							@else 
								<input type="hidden" id="pledgesqty" value="0" />
							@endif
						</div>
					</div>
					<div class="row no-padding">
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm btn-number" {{$disabled_rest}} data-type="plus" id="plushqty" data-field="">
									  <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>		
								@if(!is_null($hyper))
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="" {{$disabled_rest}} class="form-control input-number" id="hqty"
									value="{{$hyper->available}}">				
								@else
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="" {{$disabled_rest}} class="form-control input-number" id="hqty"
									value="1">		
								@endif
								<span class="input-group-btn" style="float:left">
									<button type="button" {{$disabled_rest}} class="btn btn-info btn-sm btn-number"  data-type="minus" id="minushqty" data-field="">
									  <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>			
							</div>
						</div>
						<div class="col-sm-4">
							<center><button type="button" id="reset_hyper" style="display:none;" class="btn btn-primary">Reset</button></center>
						</div>
					</div>	
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
			{{--	<label class="radio-inline"><input type="radio" value="system" name="del_option_b2b" {{$disable_sys_b2b}} {{ $checked_system_option_b2b }}>System Delivery</label>--}}
			{{--	<label class="radio-inline"><input type="radio" value="own" class='{{$toastrclass}}' name="del_option_b2b" {{ $disable_own_b2b }} {{ $checked_own_option_b2b }}>Own Delivery</label>--}}
		{{--		<label class="radio-inline"><input type="radio" value="pickup" name="del_option_b2b" {{ $disable_pu_b2b }} {{ $checked_pick_up_only_b2b }}>Pick up Only</label>--}}

			</div>		
			{{-- <div id="own_delivery_b2b" @if($checked_system_option_b2b == 'checked' || $checked_pick_up_only_b2b == 'checked') style="display:none;"@endif>
				<h3>Delivery Coverage</h3>
				@if(!is_null($hyper))
				@else
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
							<select style="width: 100%;" class="form-control valid_select" id="statesb2b" name="cov_state_idb2b" data-style="btn-green" required>
							<option disabled="" selected="" value="">Choose Option</option>
								@foreach($states as $state)
									<option value="{{$state->id}}">{{$state->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row margin-top">
						<div class="col-sm-3">
							{!! Form::label('cov_city_id', 'City', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control valid_select" id="citiesb2b" name="cov_city_idb2b" data-style="btn-green" required>
								<option disabled="" selected="" value="">Choose Option</option>
							</select>
						</div>
					</div>
					 <div class="row margin-top">
						<div class="col-sm-3">
							{!! Form::label('cov_area_id', 'Area', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="areasb2b" name="cov_area_idb2b" data-style="btn-green">
								<option disabled="" selected="" value="" selected>Choose Option</option>
							</select>
						</div>
					</div>
				@endif
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
							{!! Form::text('del_worldwideb2b', '', array('class' => 'valid_text form-control delivery_pricesb2b'))!!}
						</div>
					</div>
					<div class="row margin-top">
						<div class="col-sm-4">
							{!! Form::label('del_west_malaysia', 'Price per Unit', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-8">
							{!! Form::text('del_west_malaysiab2b', '', array('class' => 'valid_text form-control delivery_pricesb2b','id' => 'del_malaysia_v_b2b'))!!}
						</div>
					</div>
					<div class="row margin-top"  style="display: none;">
						<div class="col-sm-4 display: none;">
							{!! Form::label('del_sabah_labuan', 'Sabah/Labuan', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-8">
							{!! Form::text('del_sabah_labuanb2b', '', array('class' => 'valid_text form-control delivery_pricesb2b'))!!}
						</div>
					</div>
					<div class="row margin-top"  style="display: none;">
						<div class="col-sm-4">
							{!! Form::label('del_sarawak', 'Sarawak', array('class' => 'control-label')) !!}
						</div>
						<div class="col-sm-8">
							{!! Form::text('del_sarawakb2b', '', array('class' => 'valid_text form-control delivery_pricesb2b'))!!}
						</div>
					</div>
				</div>
				<div class="checkbox checkbox-success" style="margin-left:0">
						{!! Form::checkbox('flat_deliveryb2b', 1, null, ['class' => 'styled','id'=>'checkboxFb2b']) !!}
						{!! Form::label('checkbox1', 'Flat Delivery Price') !!}
				</div>	
				</div>
				<div class="clearfix"></div>
				<br>
				<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
				<div class="checkbox checkbox-success" style="margin-left:0">
					{!! Form::checkbox('free_deliveryb2b', 1, null, ['class' => 'styled','id'=>'checkboxDb2b']) !!}
					{!! Form::label('checkbox1', 'Free Delivery') !!}
				</div>
				<div class="col-sm-8 checkbox checkbox-success" style="margin-left:0">
					{!! Form::checkbox('free_delivery_qtyb2b', 1, null, ['class' => 'styled','id'=>'checkboxDqb2b']) !!}
					{!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}
				</div>
				<div class="col-sm-2" style="padding-right:0">
					{!! Form::text('free_delivery_with_purchase_qtyb2b', '',
						array('class' => 'form-control delivery_waiver_min_amt_b2b',
						'disabled' => 'disabled','id'=>'checkboxDqnb2b',
						'style'=>'margin-top:-12px;margin-left:30px;text-align:right;width:100px;'))!!}
				</div>				
				</div>				
								
            </div>--}}
                <div id="system_delivery_hyper">
					<h3>Business Coverage</h3>
					<div style="margin-bottom:5px" class="form-group">
						{!! Form::label('cov_country_id', 'Country', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9" >
							<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country" id="country_id" disabled>
								<option value="150">Malaysia</option>
							</select>
						</div>
					</div>
					<input type="hidden" id="cov_country_id" name="biz_country_id" value="150">
					<div style="margin-bottom:5px" class="form-group">
						{!! Form::label('cov_state_id', 'State', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="states_biz_hyper" name="biz_state_id_hyper" data-style="btn-green">
								<option value="0">Choose Option</option>
								@foreach($states as $state)
									<?php
										$selected_state = "";
										if(!is_null($hyper)){	
											//dd($current_productb2b);
											if($state->id == $hyper->cov_state_id){
												$selected_state = "selected";
											}
										}
									?>								
									<option value="{{$state->id}}" {{$selected_state}}>{{$state->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div style="margin-bottom:5px" class="form-group">
						{!! Form::label('cov_city_id', 'City', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="cities_biz_hyper" name="biz_city_id_hyper" data-style="btn-green">
							<option value="0">Choose Option</option>
								@foreach($city_hyper as $cities)
									<?php
										$selected_city = "";
										if(!is_null($hyper)){	
											if($cities->id == $hyper->cov_city_id){
												$selected_city = "selected";
											}
										}
									?>
									<option value="{{$cities->id}}" {{$selected_city}}>{{$cities->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					 <div style="margin-bottom:5px" class="form-group">
						{!! Form::label('cov_area_id', 'Area', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="areas_biz_hyper" name="biz_area_id_hyper" >
							<option value="0">Choose Option</option>
								@foreach($areas_hyper as $area)
									<?php
										$selected_area = "";
										if(!is_null($hyper)){	
											if($area->id == $hyper->cov_area_id){
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
					<div style="border: solid 1px #DDD; padding: 5px;" class="mediaheight">
						<div style="margin-bottom:5px" class="form-group">
							{!! Form::label('del_pricing', 'Pricing', array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">
								@if(is_null($current_product))
									{!! Form::text('del_pricing_hyper', '0.00',
									array('class'=>'form-control delivery_prices',
									'id' => 'del_pricing_hyper','disabled',
									'style'=>'text-align:right'))!!}
								@else
									{!! Form::text('del_pricing_hyper', number_format($delivery_pricec/100,2, '.', ''),
									array('class'=>'form-control delivery_prices',
									'id' => 'del_pricing_hyper','disabled',
									'style'=>'text-align:right'))!!}
									
								@endif
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
					<br>
					<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
						<div class="checkbox checkbox-success" style="margin-left:0">
							@if($fdelhyper == 1)
								{!! Form::checkbox('free_deliveryhyper_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD_hyper', 'checked'=>'checked', 'disabled'=>'disabled']) !!}
							@else
								@if($free_qtyhyper == 1)
								{!! Form::checkbox('free_deliveryhyper_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD_hyper', 'disabled'=>'disabled', 'checked'=>'checked']) !!}
								@else
									{!! Form::checkbox('free_deliveryhyper_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD_hyper', 'disabled'=>'disabled', 'checked'=>'checked']) !!}
								@endif
								
							@endif
							{!! Form::label('checkbox1', 'Free Delivery') !!}
						</div>
						<div class="col-sm-8 checkbox checkbox-success" style="margin-left:0">
							@if($fdelhyper == 1)
								{!! Form::checkbox('free_delivery_qtyhyper_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxDq_hyper', 'disabled'=>'disabled']) !!}
							@else
								@if($free_qtyhyper == 1)
									{!! Form::checkbox('free_delivery_qtyhyper_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxDq_hyper', 'disabled'=>'disabled']) !!}
								@else
									{!! Form::checkbox('free_delivery_qtyhyper_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxDq_hyper', 'disabled'=>'disabled']) !!}
								@endif
							@endif
							
							{!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}
						</div>
						<div class="col-sm-2" style="padding-right:0">
						@if(!is_null($hyper))
							@if($free_qtyhyper == 1)
								{!! Form::text('free_delivery_with_purchase_qtyhyper_ow',
								number_format(($hyper->free_delivery_with_purchase_qty/100),2, '.', ''),
								array('class' => 'form-control delivery_waiver_min_amt_hyper','id'=>'sd_checkboxDqn_hyper',
								'style'=>'margin-top:-12px;margin-left:15px;text-align:right;width:80px;'))!!}
							@else
								{!! Form::text('free_delivery_with_purchase_qtyhyper_ow',
								'0.00',
								array('class' => 'form-control delivery_waiver_min_amt_hyper',
								'disabled' => 'disabled','id'=>'sd_checkboxDqn_hyper',
								'style'=>'margin-top:-12px;margin-left:15px;text-align:right;width:80px;'))!!}
							@endif
						@else
							{!! Form::text('free_delivery_with_purchase_qtyhyper_ow', '',
							array('class' => 'form-control delivery_waiver_min_amt_hyper',
							'disabled'=>'disabled','id'=>'sd_checkboxDqn_hyper','required',
							'style'=>'margin-top:-12px;margin-left:15px;text-align:right;width:80px;'))!!}
						@endif
						</div>
                    </div>
				</div>			
        </div>
        <div class="clearfix"> </div>
    </div>
    <hr>

    <div id="product" class="row">
        <div class="col-xs-12">
            <h2>Terms & Conditions</h2>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-12">
          @if(!is_null($hyper))
				@if($owarehousepledges == 0)
					{!! Form::textarea('hyper_terms', $hyper->return_policy, array('class' => 'form-control hyper_terms','id'=>'hyper_terms'))!!}
				@else
					<div id="return_policy">{!! $hyper->return_policy !!}</div>
					<div id="hyper_terms_summ" style="display:none;">{!! Form::textarea('hyper_terms', $hyper->return_policy, array('class' => 'form-control hyper_terms','id'=>'hyper_terms'))!!}</div>
				@endif
			@else
				{!! Form::textarea('hyper_terms', null, array('class' => 'form-control hyper_terms','id'=>'hyper_terms'))!!}
			@endif
        </div>
        <div class="clearfix"> </div>
    </div>
    
	<div class="clearfix"></div>
  
    <div id="product" class="row">
        <div class="col-xs-12">
            <h2>Product Specifications</h2>
        </div>
        <div class="clearfix"></div>
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Length', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-1 mt">
					@if(is_null($current_product))
						{!! Form::label('prod_lengthhyper', 'Not assigned', array('id' => 'prod_lengthhyper'))!!}
					@else
						{!! Form::label('prod_lengthhyper', $current_product->length, array('id' => 'prod_lengthhyper'))!!}
					@endif
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>	
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Width', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-1 mt">
					@if(is_null($current_product))
						{!! Form::label('prod_widthhyper', 'Not assigned', array('id' => 'prod_widthhyper'))!!}
					@else
						{!! Form::label('prod_widthhyper', $current_product->width, array('id' => 'prod_widthhyper'))!!}
					@endif
					
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>		
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Height', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-1 mt">
					@if(is_null($current_product))
						{!! Form::label('prod_heighthyper', 'Not assigned', array('id' => 'prod_heighthyper'))!!}
					@else
						{!! Form::label('prod_heighthyper', $current_product->height, array('id' => 'prod_heighthyper'))!!}
					@endif
				</div>
				{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>	
			<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
				{!! Form::label('product_specification_2', 'Weight', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="col-sm-1 mt">
					@if(is_null($current_product))
						{!! Form::label('prod_weighthyper', 'Not assigned', array('id' => 'prod_weighthyper'))!!}
					@else
						{!! Form::label('prod_weighthyper', $current_product->weight, array('id' => 'prod_weighthyper'))!!}
					@endif
				</div>
				{!! Form::label('product_specification_2', 'kg', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
				<div class="clearfix"></div>
			</div>
			@if(!is_null($hyper))
				<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
					{!! Form::label('product_specification_2', 'Delivery Time', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
					<div class="col-sm-1 mt">
						{!! Form::text('prod_del_timehyper', '30', array('class' => 'form-control delivery_require2','id' => 'prod_del_timehyper', 'disabled'=>'disabled'))!!}
					</div>
					<div class="col-sm-1 mt">
						<center style="margin-top:10px"><b>To</b></center>
					</div>
					<div class="col-sm-1 mt">
						{!! Form::text('prod_del_time_tohyper', '37', array('class' => 'form-control delivery_require2','id' => 'prod_del_time_tohyper', 'disabled'=>'disabled'))!!}
					</div>
					{!! Form::label('product_specification_2', 'working days', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
					<div class="clearfix"></div>
				</div>				
			@else
				<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
					{!! Form::label('product_specification_2', 'Delivery Time', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
					<div class="col-sm-1 mt">
						{!! Form::text('prod_del_timehyper', '30', array('class' => 'form-control delivery_require2','id' => 'prod_del_timehyper', 'disabled'=>'disabled'))!!}
					</div>
					<div class="col-sm-1 mt">
						<center style="margin-top:10px"><b>To</b></center>
					</div>
					<div class="col-sm-1 mt">
						{!! Form::text('prod_del_time_tohyper',  '37', array('class' => 'form-control delivery_require2','id' => 'prod_del_time_tohyper', 'disabled'=>'disabled'))!!}
					</div>
					{!! Form::label('product_specification_2', 'working days', array('class' => 'col-sm-2 control-label', 'style'=> 'margin-top: 10px;')) !!}
					<div class="clearfix"></div>
				</div>
			@endif
			
    </div>  
	
	<div class="clearfix"></div>

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
			<div class="col-sm-6">
			</div>
            <div class="col-sm-5">
				<div class="w3-light-grey w3-round-large" id="totalBarhyper" style="display: none;">
					<div class="w3-container w3-blue w3-round-large" style="width:0%" id="myBarhyper">0%</div>
				</div>						
			</div>
            <div class="col-sm-1">
				@if(!is_null($hyper))
					@if($current_product->status != 'active')
						<p style="float:right;">
							<a href="javascript:void(0)" class="btn btn-info" id="" title="Only can create Hyper of active products" style="cursor: pointer; font-size: 20px; background-color: #CCC; border-color: #BBB;">Go Hyper!</a>
						</p>
					@else
						<p style="float:right;">
							<?php 
								$disabled_btn = "";
								if($hyper->owarehouse_price == 0){
									$disabled_btn = "disabled";
								}
							?>
							@if($owarehousepledges == 0)
								<a href="javascript:void(0)" class="btn btn-info"  id="next_hyper_product" style="cursor: pointer; font-size: 20px">Go Hyper!</a>
							@else
								<a href="javascript:void(0)" class="btn btn-info" id="next_hyper_product_error" rel="Cannot update an active Hyper Product!"  title="Cannot update an active Hyper Product!" style="cursor: pointer; font-size: 20px">Go Hyper!</a>
							@endif
							<a href="javascript:void(0)" class="btn btn-info" title='To publish this product and be visible to the public, please tick "O" column and click on "Update for Public" button' id="next_hyper_product" style="cursor: pointer; font-size: 20px; display:none;">Go Hyper!</a>
						</p>				
					@endif
				@else
					@if(is_null($current_product))
						 <p style="float:right;">
							<a href="javascript:void(0)" class="btn btn-info" id="" title="Only can create Hyper of active products" style="cursor: pointer; font-size: 20px; background-color: #CCC; border-color: #BBB;">Go Hyper!</a>
						</p>
					@else 
						@if($current_product->status != 'active')
							<p style="float:right;">
								<a href="javascript:void(0)" class="btn btn-info" id="" title="Only can create Hyper of active products" style="cursor: pointer; font-size: 20px; background-color: #CCC; border-color: #BBB;">Go Hyper!</a>
							</p>
						@else
							<p style="float:right;">
								<a href="javascript:void(0)" class="btn btn-info" id="next_hyper_product" style="cursor: pointer; font-size: 20px">Go Hyper!</a>
							</p>
						@endif
					@endif
				@endif			
               
            </div>
     {{--   <div class="row">
            <div class="col-sm-12 text-right">
				<p style="float:right;"><img class="img-responsive"  id="next_b2b_product" style="cursor: pointer; width: 100px;" src="{{asset('/')}}images/next_product.png" alt="" /></p>
            </div>
        </div>
		<div class="row">
			<div class="col-sm-offset-11 col-sm-1">
					<p align="right" style=" float:right; display:none;" id="next_hyper_spinner"><i class="fa-li fa fa-spinner fa-spin fa-2x fa-fw" style=" float:right;"></i></p>
			</div>
		</div> --}}
<br/><br/>
	@if(is_null($current_product))
		<input type="hidden" id="parent_idh" value="0" />
		<input type="hidden" id="retail_priceh" value="0" />
		<input type="hidden"  name="hyper_id" id="hyper_id" value="0" />
		<input type="hidden" name="owarehouse_id" id="owarehouse_id" value="0" />
	@else
		<input type="hidden" id="parent_idh" value="{{$current_product->id}}" />
		<input type="hidden" id="retail_priceh" value="{{$current_product->private_retail_price/100}}" />
		@if(!is_null($hyper))
			<input type="hidden"  name="hyper_id" id="hyper_id" value="{{$hyper->id}}" />
			@if(!is_null($owarehouse))
				<input type="hidden" name="owarehouse_id" id="owarehouse_id" value="{{$owarehouse->id}}" />
			@else
				<input type="hidden" name="owarehouse_id" id="owarehouse_id" value="0" />
			@endif	
		@else
			<input type="hidden" name="hyper_id" id="hyper_id" value="0" />
			<input type="hidden" name="owarehouse_id" id="owarehouse_id" value="0" />
		@endif
	@endif
{!!Form::close()!!}
<script type="text/javascript">
$(document).ready(function(){
	$('#hyperprice').on('keyup', function () {
		var rp = parseInt($('#retail_priceh').val());
		var hp = parseInt($('#hyperprice').val());
		var res = 0;
		if(hp > 0 && rp > 0){
			res = ((rp - hp) / rp) * 100;
		}

		if(res>99.99){
			res=99.99
		}
		if(res < 0){
			res = 0;
		}
		//if(!isNaN(res)) {
		if(hp >= rp || hp == 0){
			$("#error_hyper").show();
			$("#save_hyper").hide();
			$("#update_hyper").prop("disabled",true);
			$("#add_hyper").prop("disabled",true);
			$('#resultSaveh').text(0).number(true, 2);
		} else {
			$("#error_hyper").hide();
			$("#save_hyper").show();
			$("#update_hyper").prop("disabled",false);
			$("#add_hyper").prop("disabled",false);				
			if (res > 0) {
				$('#resultSaveh').text(res).number(true, 2);
			} else {
				$('#resultSaveh').text(0).number(true, 2);
			}				
		}

		//}
	});	

	$("#minusmoq").click(function (e) {
		var val = $("#moq").val();
		var valcaf = $("#moqcaf").val();
		var newval = parseInt(val) - (1*parseInt(valcaf));
		if(newval <= 0){
			$("#moq").val(val);
		} else {
			if((parseInt(newval) % parseInt(valcaf)) != 0){
				var modd = (parseInt(newval) % parseInt(valcaf));
				console.log(modd);
				newval = newval + (parseInt(valcaf) - modd);
			}
			$("#moq").val(newval);
		}
	});

	$("#plusmoq").click(function (e) {
		var val = $("#moq").val();
		var valcaf = $("#moqcaf").val();
		var newval = parseInt(val) + (1*parseInt(valcaf));
		if((parseInt(newval) % parseInt(valcaf)) != 0){
			var modd = (parseInt(newval) % parseInt(valcaf));
			newval = newval + (parseInt(valcaf) - modd);
		}										
		$("#moq").val(newval);
	});		

	$("#minushqty").click(function (e) {
		var val = $("#hqty").val();
		var valcaf = $("#moqcaf").val();
		var newval = parseInt(val) - (1*parseInt(valcaf));
		if(newval == 0){
			$("#hqty").val(val);
		} else {
			if((parseInt(newval) % parseInt(valcaf)) != 0){
				var modd = (parseInt(newval) % parseInt(valcaf));
				newval = newval + modd;
			}											
			$("#hqty").val(newval);
		}
	});


	$("#plushqty").click(function (e) {
		var val = $("#hqty").val();
		var valcaf = $("#moqcaf").val();
		var newval = parseInt(val) + (1*parseInt(valcaf));
		if((parseInt(newval) % parseInt(valcaf)) != 0){
			var modd = (parseInt(newval) % parseInt(valcaf));
			newval = newval + modd;
		}										
		$("#hqty").val(newval);
	});

	$("#minusmoqcaf").click(function (e) {
		var val = $("#moqcaf").val();
		var newval = parseInt(val) - 1;
		if(newval == 0){
			$("#moqcaf").val(val);
			$("#moq").val(val);
			$("#hqty").val(val);
		} else {
			$("#moqcaf").val(newval);
			$("#moq").val(newval);
			$("#hqty").val(newval);											
		}
	});

	$("#plusmoqcaf").click(function (e) {
		var val = $("#moqcaf").val();
		var newval = parseInt(val) + 1;
		$("#moqcaf").val(newval);
		$("#moq").val(newval);
		$("#hqty").val(newval);											
	});

	$("#minusdur").click(function (e) {
		var val = $("#duration").val();
		var newval = parseInt(val) - 1;
		if(newval == 0){
			$("#duration").val(val);
		} else {
			$("#duration").val(newval);
		}
	});

	$("#plusdur").click(function (e) {
		var val = $("#duration").val();
		var newval = parseInt(val) + 1;
		$("#duration").val(newval);
	});		

	$("#setcaf").click(function (e) {
		var moq_location = $("#moq_location").val();
	//	alert("moq_location: " + moq_location);
		if(moq_location ==  "0"){
			$("#setcaf").addClass("btn-success");
			$("#setcaf").removeClass("btn-warning");
			$("#setcafgly").addClass("glyphicon-check");
			$("#setcafgly").removeClass("glyphicon-transfer");
			$("#moqcaf").attr("disabled", false);
			$("#plusmoqcaf").attr("disabled", false);
			$("#minusmoqcaf").attr("disabled", false);
			$("#plusmoq").attr("disabled", true);
			$("#minusmoq").attr("disabled", true);
			$("#moq").attr("disabled", true);
			$("#plushqty").attr("disabled", true);											
			$("#minushqty").attr("disabled", true);											
			$("#hqty").attr("disabled", true);	
			$("#hyperprice").attr("disabled", true);	
			$("#moq_location").val("1");
		} else {
			$("#setcaf").removeClass("btn-success");
			$("#setcaf").addClass("btn-warning");
			$("#setcafgly").removeClass("glyphicon-check");
			$("#setcafgly").addClass("glyphicon-transfer");
			$("#moqcaf").attr("disabled", true);
			$("#plusmoqcaf").attr("disabled", true);
			$("#minusmoqcaf").attr("disabled", true);
			$("#plusmoq").attr("disabled", false);
			$("#minusmoq").attr("disabled", false);
			$("#moq").attr("disabled", false);
			$("#plushqty").attr("disabled", false);											
			$("#minushqty").attr("disabled", false);											
			$("#hqty").attr("disabled", false);
			$("#hyperprice").attr("disabled", false);
			$("#moq_location").val("0");											
		}
	});	
	
	$(document).delegate( '#nremove_hyper', "click",function (event) {
	//$("#nremove_hyper").click(function (e) {
		toastr.error("Hyper have not been created yet.");
	});
	
	$(document).delegate( '#noremove_hyper', "click",function (event) {
	//$("#noremove_hyper").click(function (e) {
		toastr.error("You can't remove this hyper. Already have pledges.");
	});		
	
	$(document).delegate( '#remove_hyper', "click",function (event) {
//	$("#remove_hyper").click(function (e) {
		var isremove = confirm("This will remove product from Hyper Pool and O-Shop Hyper. Do you want to continue?");
		if(isremove){
			$('#remove_hyper').html('Removing...');
			var owarehouse_id = $("#owarehouse_id").val();
			var hyper_id = $("#hyper_id").val();
			$.ajax({
				url: JS_BASE_URL+"/removehyperprice",
				type: "POST",
				data: {
					owarehouse_id : owarehouse_id,
					hyper_id : hyper_id
				},
				async: false,
				success: function(response)
				{
					$("#hyper_id").val(0);
					$("#owarehouse_id").val(0);
					$("#hyperprice").val(0);
					$("#moqcaf").val(1);
					$("#moqcaf").attr('disabled',false);
					$("#plusmoqcaf").attr('disabled',false);
					$("#minusmoqcaf").attr('disabled',false);
					$("#moq").val(1);
					$("#moq").attr('disabled',true);
					$("#plusmoq").attr('disabled',true);
					$("#minusmoq").attr('disabled',true);
					$("#hqty").val(1);
					$("#hqty").attr('disabled',true);
					$("#plushqty").attr('disabled',true);
					$("#minushqty").attr('disabled',true);
					toastr.info("Hyper Product successfully deleted");	
				}
			});										
			$('#myModal').modal('hide');											
		}
	});		
	
	$("#reset_hyper").click(function (e) {
		$("#hyper_div :input").attr("disabled", false);
		$("#reset_hyper").hide();
		$("#setcaf").addClass("btn-success");
		$("#setcaf").removeClass("btn-warning");
		$("#setcafgly").addClass("glyphicon-check");
		$("#setcafgly").removeClass("glyphicon-transfer");
		$("#moqcaf").attr("disabled", false);
		$("#plusmoqcaf").attr("disabled", false);
		$("#minusmoqcaf").attr("disabled", false);
		$("#plusmoq").attr("disabled", true);
		$("#minusmoq").attr("disabled", true);
		$("#moq").attr("disabled", true);
		$("#plushqty").attr("disabled", true);											
		$("#minushqty").attr("disabled", true);											
		$("#hqty").attr("disabled", true);	
		$("#hyperprice").attr("disabled", true);	
		$("#checkboxDqn_hyper").attr("disabled", true);	
		$("#moq_location").val("1");
		$("#pledges_values").hide();
		$("#update_hyper").hide();
		$("#return_policy").hide();
		$("#hypercant").hide();
		$("#add_hyper").show();
		$("#hyper_terms_summ").show();
	});	

	$('#hyperprice').number(true, 2, '.' , '');
	//$('#hqty').number(true, 2);
	//$('#deliveryqty').number(true, 2);	
	
	if(parseInt(pledgesqty)> 0){
		$("#hyper_div :input").attr("disabled", true);
		$("#hypercant").show();
	}
	
	$("#isreset").val(isreset);
	if(isreset == "1"){
		$("#reset_hyper").show();
		$("#reset_hyper").attr("disabled",false);
	}	
})
</script>
