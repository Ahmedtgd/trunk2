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
                <img class="img img-responsive"
				style="width:100%;height:98%;object-fit:cover;object-position:center top"
				id="preview-imgb2b"/>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
                {!! Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="name_p" class="name_p">Not assigned</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('brand_id', 'Brand', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="brand_p" class="brand_p">Not assigned</p>
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('category_id', 'Category', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="category_p" class="category_p">Not assigned</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('subcat_id', 'Sub Category', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="subcat_p" class="subcat_p">Not assigned</p>
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
                    <p id="description_p" class="description_p">Not assigned</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('available', 'Qty Allocated for Procurement.', array('class' => 'col-sm-3 control-label','style'=>'color:red;font-weight:normal')) !!}
                   <div class="col-sm-4">
                        {!! Form::text('available_b2b', '0', array('class' => 'form-control', 'style'=>'width:100px','id' => 'quantity_vb2b'))!!}
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
            <div class="col-sm-12">

            </div>
        <div class="col-sm-7">
            <div class="row">
                <h2>Business To Business</h2>
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
                                    <p style="margin-bottom:0" id="rPrice_p" class="rPrice_p">Not assigned</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>			
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
                            <th>Price</th>
                            <td colspan="10" style='text-align: left'><label id="addRowLabel" class="err hidden">Fill the required fields</label></td>
                        </tr>
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
                                <label id='errp-{{ $id }}' class='err hidden'>Price must be smaller than <span id='p-0'></span></label>
                                <label id='errx' class='err hidden'>Retail Price must be assigned in Retail segment</span></label>
                            </td>
                            <td class='col-xs-1'>
                                <a  href="javascript:void(0);" id="addrsp"  class="form-control die text-center text-green"><i class="fa fa-plus-circle"></i></a>
                            </td>
                            <td class='col-xs-4'>
                                <div class="input-group">
                                    <span class="input-group-addon">Margin</span>
                                    <div class="average form-control text-center text-danger">
                                    <span id="mar-{{ $id }}">0.00</span></div>
                                    <span class="input-group-addon">%</span>
                                </div>
                            </td>
                        </tr>
                    </table>
					<div style="color:red">
					Price for qty more than the highest number will follow the price of the last tier
					</div>
                    <input id="wholesaleprices" name="wholesaleprices" type="hidden" value="0" />
                    @for($w = 0; $w < 20; $w++)
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
				</br>
				<label style="margin-top:0" class="radio-inline">
                <input type="radio" value="warranty" name="del_option_b2b" >
                Warranty
                </label>

			</div>		
			 <div id="own_delivery_b2b" @if($checked_system_option_b2b == 'checked' || $checked_pick_up_only_b2b == 'checked') style="display:none;"@endif>
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
								
            </div>
                <div id="system_delivery_b2b" @if($checked_own_option_b2b == 'checked' || $checked_pick_up_only_b2b == 'checked') style="display:none;" @endif>
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
							<select style="width: 100%;" class="form-control" id="states_biz_b2b" name="biz_state_id_b2b" data-style="btn-green">
							<option value="0" disabled="" selected="">Choose Option</option>
								@foreach($states as $state)
									<option value="{{$state->id}}">{{$state->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div style="margin-bottom:5px" class="form-group">
						{!! Form::label('cov_city_id', 'City', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="cities_biz_b2b" name="biz_city_id_b2b" data-style="btn-green">
								<option value="0" disabled="" selected="">Choose Option</option>
							</select>
						</div>
					</div>
					 <div style="margin-bottom:5px" class="form-group">
						{!! Form::label('cov_area_id', 'Area', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="areas_biz_b2b" name="biz_area_id_b2b" >
								<option value="0" selected  disabled="" selected="">Choose Option</option>
							</select>
						</div>
					</div>
					<div class="clearfix"> </div>
					<br>
					<div style="border: solid 1px #DDD; padding: 5px;" class="mediaheight">
						<div style="margin-bottom:5px" class="form-group">
							{!! Form::label('del_pricing', 'Pricing', array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">
								{!! Form::text('del_pricing_b2b', '0.00',
								array('class'=>'form-control delivery_prices',
								'id' => 'del_pricing_b2b','disabled',
								'style'=>'text-align:right'))!!}
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
							{!! Form::checkbox('free_deliveryb2b_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD_b2b']) !!}
							{!! Form::label('checkbox1', 'Free Delivery') !!}
						</div>
						<div class="col-sm-8 checkbox checkbox-success" style="margin-left:0">
							{!! Form::checkbox('free_delivery_qtyb2b_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxDq_b2b']) !!}
							{!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}
						</div>
						<div class="col-sm-2" style="padding-right:0">
						{!! Form::text('free_delivery_with_purchase_qtyb2b_ow', '',
						array('class' => 'form-control delivery_waiver_min_amt_b2b',
						'disabled'=>'disabled','id'=>'sd_checkboxDqn_b2b','required',
						'style'=>'margin-top:-12px;margin-left:15px;text-align:right;width:100px;'))!!}
						</div>
                    </div>
				</div>			
        </div>
        <div class="clearfix"> </div>
    </div>
    <hr>

    <div id="product" class="row">
        <div class="col-xs-12">
            <h2>Product Details</h2>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-12">
            {!! Form::textarea('product_detailsb2b', null, array('class' => 'form-control','id'=>'info-detailsb2b'))!!}
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
			<div style="margin-bottom:5px;margin-top:10px"
				class="form-group" id="product_specification_2">
                {!! Form::label('serial_no', 'Serial No./IMEI', array('class' => 'col-sm-2 control-label', 'style'=>'')) !!}
                <div class="col-sm-3 mt" style="margin-top:0">
                    <input  name="has_serialno" type="checkbox"
                   value="1" 
                    
                   >
                </div>
             
                <div class="clearfix"></div>
            </div>
			
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
     {{--   <div class="row">
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
<script type="text/javascript">
$(document).ready(function(){

})
</script>
