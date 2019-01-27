<style>
.wColorPicker-button{
	width: 75px !important;
	height: 25px !important;
	margin-top: -4px !important;
}

.wColorPicker-button-color{
	height: 20px !important;
}

.wColorPicker-palettes-holder{
	width: 230px !important;
}

.form-controln {
    width: 70%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
</style>
<link rel="Stylesheet" type="text/css" href="{{url('css/palette-color-picker.css')}}" />
<script type="text/javascript" src="{{url('js/palette-color-picker.js')}}"></script>
<link rel="Stylesheet" type="text/css" href="{{url('css/wColorPicker.css')}}" />
<script type="text/javascript" src="{{url('js/rgbHex.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/wColorPicker.js')}}"></script>
{!! Form::open(['id'=>'productRegForm', 'style'=>'margin-bottom:0;margin-top:0', 'class'=> 'form-horizontal','files' => true]) !!}
        <div id="pinformation" class="row">
            <div class="col-sm-12 row">
                <h1>Product Registration</h1>
            </div>
            <input type="hidden" value="0" id="myproduct_id" name="myproduct_id" />
            <input type="hidden" value="" name='pimage' id="ximage" />
            <div class="col-sm-4 thumbnail" id='thumbnail'>
                <div class="product-photo">
                    <img class="img simg img-responsive"
						id="preview-img"
						style="width:100%;height:98%;object-fit:cover;
							object-position:center top"/>
                    <div class="inputBtnSection">
                        {!! Form::text('photo',null,['class'=>'disableInputField text-center','id'=>'uploadFile','placeholder'=>'375 x 300','disabled'=>'disabled']) !!}
                        <label class="fileUpload">
                            {!! Form::file('product_photo',['class'=>'upload','id'=>'uploadBtn', 'required']) !!}
                            <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div style="margin-bottom:5px" class="form-group">
                    
                    {!! Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9" style="padding-left:0">
                        <span class="pex text-danger"></span>
                        {!! Form::text('name', '', array('class' => 'form-control album_product_name_validation1', 'id' => 'name_v', 'required'))!!}
                
                        <input type="hidden" id="productnamevalid" value="true">
                    </div>
                </div>
                <div style="margin-bottom:5px" class="form-group">
                    {!! Form::label('brand_id', 'Brand', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9" style="padding-left:0">
                        <select name="brand_id" class ="form-control" id="brand_v" required>
                            <option value=""  disabled="" selected="">Choose Option</option>
                            @foreach($brand as $Brand)
                                <option value="{{ $Brand->id }}">{{ $Brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div style="margin-bottom:5px" class="form-group">
                    {!! Form::label('category_id', 'Category', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9" style="padding-left:0">

                        <select name="category_id" class ="form-control" required id="Category_id_product">
                            <option value=""  disabled="" selected="">Choose Option</option>
                            @foreach($category as $Category)
                                <option value="{{ $Category->id }}">{{ $Category->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:5px" class="form-group">
                    {!! Form::label('subcat_id', 'Sub Category', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9" style="padding-left:0">
                        <select name="subcat_id" class ="form-control" required id="subcat">
                            <option value=""  disabled="" selected="" >Choose Option</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:5px" class="form-group">
                    {!! Form::label('oshop_id', 'O-Shop', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9" style="padding-left:0">
                        <select name="oshop_id" class ="form-control" id="oshop_v" required>
                            <option value=""  disabled="" selected="">Choose Option</option>
                            <option value="0">Not Display</option>
                            @foreach($oshops as $Oshop)
                                <option value="{{ $Oshop->id }}">{{ $Oshop->oshop_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div style="margin-bottom:5px" class="form-group">
                    {!! Form::label('short_description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9" style="padding-left:0">
                        {!! Form::textarea('short_description', null, array('class' => 'form-control', 'rows' => '4','id'=>'short_description', 'required'))!!}
                    </div>
                </div>
                <div style="margin-bottom:5px" class="form-group">
                    {!! Form::label('available', 'Qty Allocated for Online', array('class' => 'col-sm-3 control-label','style'=>'color:red;font-weight:normal')) !!}
                    <div class="col-sm-4" style="padding-left:0">
                        {!! Form::text('available', null, array('class' => 'form-control', 'style'=>'width:100px','id' => 'quantity_v', 'required'))!!}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr>
	<div id="regbody">
        <div id="delivery" class="row">
            <div class="col-sm-6" style="padding-left:0">
                <div class="col-sm-12" style="padding-left:0">
                    <h2>Retail</h2>
                </div>
                <div class="col-xs-12">
                    <div style="margin-bottom:5px" class="form-group row">
                        {!! Form::label('retail_price11',
							'Retail Price ('.$active_currency.')',
							array('style' => 'padding-top:0;padding-left:0',
								  'class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-5">
                            {!! Form::text('retail_price', null,
								(['class' => 'retailSave form-control',
								'id'=>'rPrice', 'required']))!!}
                        </div>
                    </div>
                    <div style="margin-bottom:5px" class="form-group row">
                        {!! Form::label('discounted_price',
							'Selling Price ('.$active_currency.')',
							array('style' => 'padding-top:0;padding-left:0',
								  'class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-5">
                            {!! Form::text('discounted_price', null,
								array('class' => 'retailSave form-control',
								'id'=>'oPrice'))!!}
                        </div>
                        <div class="col-sm-4 text-danger" style="margin-top:7px" >
                            SAVE <span id="resultSave">0.0</span>%
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div style="padding-left:0;margin-bottom:15px"
					class="col-sm-12">
                    <h2>Delivery</h2>

					{{--Paul on 15 May 2017 at 10 40 pm--}}
					{{--<label class="radio-inline"><input type="radio" value="system" name="del_option" {{$disable_del_option}} {{ $checked_system_option }}>System Delivery</label>--}}
					{{--<label class="radio-inline"><input type="radio" value="own" name="del_option" {{$disable_del_option}} {{ $checked_own_option }}>Own Delivery</label>--}}
					{{--<label class="radio-inline"><input type="radio" value="pickup" name="del_option" {{$disable_del_option}}>Pick up Only</label>--}}
					<?php 
						$toastrclass = "";
						$canown = 1;
						if(is_null($logistic_id)){
							$toastrclass = "all_own_toastr";
							$canown = 0;
						}
					?>
					<input type="hidden" id="canown" value="{{$canown}}" />
                    <label class="radio-inline">
					<input type="radio" value="system" name="del_option"
					{{$disable_sys}} {{ $checked_system_option }}>
					System Delivery</label>

                    <label class="radio-inline">
					<input type="radio" value="own" class='{{$toastrclass}}'
					name="del_option" {{ $disable_own }}
					{{ $checked_own_option }}>Own Delivery</label>

                    <label class="radio-inline">
					<input type="radio" value="pickup" name="del_option"
					{{ $disable_pu }} {{ $checked_pick_up_only }}>
					Pick up Only</label>

					<br>
                    <label style="margin-top:-10px" class="radio-inline">
					<input type="radio" value="voucher" name="del_option" >
					Voucher
					<div style="color:red;display:inline">
					(no inventory count needed)</div>
					</label>
					<br>
                    <label style="margin-top:-10px" class="radio-inline">
					<input type="radio" value="service" name="del_option" >
					Restaurants & Services
					<div style="color:red;display:inline">
					(no inventory count needed)</div>
					</label>
                    <!-- <br>
                    <label style="margin-top:-10px" class="radio-inline">
                    <input type="radio" value="warranty" name="del_option" >
                    Warranty No.
                    </label> -->
                </div>

                {{--<div id="own_delivery" @if($checked_system_option == 'checked') style="display:none;" @endif>--}}
                <div id="own_delivery" @if($checked_system_option == 'checked' ||$checked_pick_up_only == 'checked') style="display:none;"@endif>
                    <h3>Delivery Coverage</h3>
                    <div style="margin-bottom:5px" class="form-group">
                        {!! Form::label('cov_country_id', 'Country', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-9" >
                            <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country" id="country_id" disabled>
                                <option value="150">Malaysia</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="cov_country_id" name="cov_country_id" value="150">
                    <div style="margin-bottom:5px" class="form-group">
                        {!! Form::label('cov_state_id', 'State', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-9">
                            <select style="width: 100%;" class="form-control" id="states" name="cov_state_id" data-style="btn-green">
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
                            <select style="width: 100%;" class="form-control" id="cities" name="cov_city_id" data-style="btn-green">
                                <option value="0" disabled="" selected="">Choose Option</option>
                            </select>
                        </div>
                    </div>
                     <div style="margin-bottom:5px" class="form-group">
                        {!! Form::label('cov_area_id', 'Area', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-9">
                            <select style="width: 100%;" class="form-control" id="areas" name="cov_area_id" >
                                <option value="0" selected  disabled="" selected="">Choose Option</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <h3>Delivery Pricing</h3>
					<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
                    <div class="toggleDelivery">
					
                        <div style="margin-bottom:5px; display: none;" class="form-group">
                            {!! Form::label('del_worldwide', 'World Wide', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('del_worldwide', '0', array('class' => 'form-control delivery_prices','id' => 'del_world_v'))!!}
                            </div>
                        </div>
                        <div style="margin-bottom:5px" class="form-group">
                            {!! Form::label('del_west_malaysia', 'Price per Unit', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('del_west_malaysia', '', array('class' => 'form-control delivery_prices','id' => 'del_malaysia_v'))!!}
                            </div>
                        </div>
                        <div style="margin-bottom:5px; display: none;" class="form-group">
                            {!! Form::label('del_sabah_labuan', 'Sabah/Labuan', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('del_sabah_labuan', '0', array('class' => 'form-control delivery_prices','id' => 'del_sabah_v'))!!}
                            </div>
                        </div>
                        <div style="margin-bottom:5px; display: none;" class="form-group">
                            {!! Form::label('del_sarawak', 'Sarawak', array('class' => 'col-sm-4 control-label')) !!}
                            <div class="col-sm-8">
                                {!! Form::text('del_sarawak', '0', array('class' => 'form-control delivery_prices','id' => 'del_sarawak_v'))!!}
                            </div>
                        </div>
                    </div>
					<div class="checkbox checkbox-success" style="margin-left:0">
						{!! Form::checkbox('flat_delivery', 1, null, ['class' => 'styled','id'=>'checkboxF']) !!}
						{!! Form::label('checkbox1', 'Flat Delivery Price') !!}
					</div>				
					</div>			
					<br>
					<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
						<div class="checkbox checkbox-success" style="margin-left:0">
							{!! Form::checkbox('free_delivery', 1, null, ['class' => 'styled','id'=>'checkboxD']) !!}
							{!! Form::label('checkbox1', 'Free Delivery') !!}
						</div>
						<div class="col-sm-8 checkbox checkbox-success" style="margin-left:0">
							{!! Form::checkbox('free_delivery_qty', 1, null, ['class' => 'styled','id'=>'checkboxDq']) !!}
							{!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}
						</div>
						<div class="col-sm-2" style="padding-right:0">
							{!! Form::text('free_delivery_with_purchase_amt', '',
								array('class' => 'form-control delivery_waiver_min_amt',
								'disabled' => 'disabled','id'=>'checkboxDqn',
								'style'=>'margin-top:0;margin-left:0;text-align:right;width:100px;float:right'))!!}
						</div>
                    </div>
                </div>

                {{-- VOUCHER --}}
                 <div id="pvoucher" style="display:none;">
                   
                    <h3>Voucher Specifications</h3>
                    <div style="margin-bottom:5px;" class="form-group">
                        <div class="col-sm-4">
                            <label>Package Qty</label>
                        </div>  
                        <div class="col-sm-8">
                            <input type="number" name="voucher_package_qty">
                        </div>
                    </div>
                     <div style="margin-bottom:5px;" class="form-group">
                        <div class="col-sm-4">
                            <label>Qty Limit</label>
                        </div>  
                        <div class="col-sm-8">
                            <input type="number" name="voucher_qty_limit">
                        </div>
                    </div> 
                    <div style="margin-bottom:5px;" class="form-group">
                        <div class="col-sm-4">
                            <label>Expiry</label>
                        </div>  
                        <div class="col-sm-8">
                            <input id="voucher_expiry" name="expiry_date">
                        </div>
                    </div>
                   
                </div>

                {{-- VOUCHER ENDS --}}

                {{--<div id="system_delivery" @if($checked_own_option == 'checked') style="display:none;" @endif>--}}
                <div id="system_delivery" @if($checked_own_option == 'checked' || $checked_pick_up_only == 'checked') style="display:none;" @endif>
                {{--
                    <input type="hidden" id="cms_pricing" value="{{ $global_system_vars->cms_pricing }}" />
                    <input type="hidden" id="grs_pricing" value="{{ $global_system_vars->grs_pricing }}" />
                    <input type="hidden" id="mts_pricing" value="{{ $global_system_vars->mts_pricing }}" />
                    <h3>Delivery Requirements</h3>
                    <div class="delivery_requirements">
                        <div style="margin-bottom:5px" class="form-group">
                            {!! Form::label('del_width', 'Width', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('del_width', '', array('class' => 'form-control delivery_require','id' => 'del_width'))!!}
                            </div>
                            <div class="col-sm-1">
                            cm
                            </div>
                        </div>
                        <div style="margin-bottom:5px" class="form-group">
                            {!! Form::label('del_lenght', 'Lenght', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('del_lenght', '', array('class' => 'form-control delivery_require','id' => 'del_lenght'))!!}
                            </div>
                            <div class="col-sm-1">
                            cm
                            </div>
                        </div>
                        <div style="margin-bottom:5px" class="form-group">
                            {!! Form::label('del_height', 'Height', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('del_height', '', array('class' => 'form-control delivery_require','id' => 'del_height'))!!}
                            </div>
                            <div class="col-sm-1">
                            cm
                            </div>
                        </div>
                        <div style="margin-bottom:5px" class="form-group">
                            {!! Form::label('del_weight', 'Weight', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('del_weight', '', array('class' => 'form-control delivery_require','id' => 'del_weight'))!!}
                            </div>
                            <div class="col-sm-1">
                            grs
                            </div>
                        </div>
                    </div>
                    <br>
                    --}}
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
							<select style="width: 100%;" class="form-control" id="states_biz" name="biz_state_id" data-style="btn-green">
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
							<select style="width: 100%;" class="form-control" id="cities_biz" name="biz_city_id" data-style="btn-green">
								<option value="0" disabled="" selected="">Choose Option</option>
							</select>
						</div>
					</div>
					 <div style="margin-bottom:5px" class="form-group">
						{!! Form::label('cov_area_id', 'Area', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="areas_biz" name="biz_area_id" >
								<option value="0" selected  disabled="" selected="">Choose Option</option>
							</select>
						</div>
					</div>
					<br>
					<div style="border: solid 1px #DDD; padding: 5px;">
						<div style="margin-bottom:5px" class="form-group">
							{!! Form::label('del_pricing', 'Pricing', array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">
								{!! Form::text('del_pricing', '0.00',
								array('class' => 'form-control delivery_prices',
								'id' => 'del_pricing','disabled'=>'disabled',
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
							{!! Form::checkbox('free_delivery_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD']) !!}
							{!! Form::label('checkbox1', 'Free Delivery') !!}
						</div>
						<div class="col-sm-8 checkbox checkbox-success" style="margin-left:0">
							{!! Form::checkbox('free_delivery_qty_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxDq']) !!}
							{!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}
						</div>
						<div class="col-sm-2" style="padding-right:0">
						{!! Form::text('free_delivery_with_purchase_amt_ow', '',
						array('class' => 'form-control delivery_waiver_min_amt',
						'disabled' => 'disabled','id'=>'sd_checkboxDqn',
						'style'=>'margin-top:0px;float:right;text-align:right;width:100px;'))!!}
						</div>
                    </div>
				</div>

            </div>
            <div class="clearfix"> </div>
        </div>
        <hr>
        <div id="retail" class="row">


        <div id="product" class="row">
            <div class="col-xs-12" style="padding-left:0">
                <h2>Product Details</h2>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12" style="padding-left:0">
                {!! Form::textarea('product_details', null, array('class' => 'form-control','id'=>'info-details'))!!}
            </div>
            <div class="clearfix"> </div>
        </div>
        <hr>

        <div id="pspecification" class="row">
            <div class="col-xs-12" style="padding-left:0">
                <h2>Specifications</h2>
            </div>
            <div class="col-xs-12">
                <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                    {!! Form::label('product_specification_2', 'Product', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="col-sm-4 mt" style="margin-top:0">
						<select name="subcat_id_2" disabled class ="form-control specs" id="subcat2">
							<option value="0"  disabled="" selected="" >Choose Option</option>
						</select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div style="margin-bottom:5px" class="form-group" id="product_specification_3" style="display:none;">
                    {!! Form::label('product_specification_3', 'SubProduct&nbsp;', array('class' => 'col-sm-2 control-label', 'style' => 'padding-left:0')) !!}
                    <div class="col-sm-4 mt" style="margin-top:0">
						<select name="subcat_id_3" disabled class ="form-control specs" id="subcat3">
							<option value="0"  disabled="" selected="" >Choose Option</option>
						</select>
                    </div>
                    <div class="clearfix"></div>
                </div>		
                <div style="margin-bottom:5px" class="form-group" id="product_specification_color">
                    {!! Form::label('product_specification_color', 'Colour', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="col-sm-3 mt" style="margin-top:0">
						<?php 
							$colorst = DB::table('color')->get();
							$colors = '[';
							$wwww = 0;
							foreach($colorst as $color){
								if($wwww > 0){
									$colors .= ',';
								}
								$colors .= '{"' . $color->description . '": "' . $color->hex . '"}';
								$wwww++;
							}
							$colors .= ']';
						?>
						<input type="text" name="unique-name-1" class="form-controln colorpick" id="color1" data-palette='{{$colors}}' value="" style="margin-left: 35px;">
                    </div>
					 <div class="col-sm-1 mt" style="padding-left:0">
						&nbsp;
						<!-- <a  href="javascript:void(0);" id="addcolor" class="text-green"><i class="fa fa-plus-circle"></i></a> -->
					 </div>
                    <div class="clearfix"></div>
					<input type="hidden" id="colors_id" value="1" />
					<input type="hidden" id="colorst" value="{{$colors}}" />
					<div id="colors"></div>
                </div>	
                <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                    {!! Form::label('product_specification_2', 'Length', array('class' => 'col-sm-2 control-label','style'=>'padding-left:0')) !!}
                    <div class="col-sm-3 mt" style="margin-top:0">
						{!! Form::text('prod_length', '', array('class' => 'form-control delivery_require','id' => 'prod_length'))!!}
                    </div>
					{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-1 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="clearfix"></div>
                </div>	
                <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                    {!! Form::label('product_specification_2', 'Width', array('class' => 'col-sm-2 control-label','style'=>'padding-left:0')) !!}
                    <div class="col-sm-3 mt" style="margin-top:0">
						{!! Form::text('prod_width', '', array('class' => 'form-control delivery_require','id' => 'prod_width'))!!}
                    </div>
					{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-1 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="clearfix"></div>
                </div>		
                <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                    {!! Form::label('product_specification_2', 'Height', array('class' => 'col-sm-2 control-label', 'style' => 'padding-left:0')) !!}
                    <div class="col-sm-3 mt" style="margin-top:0">
						{!! Form::text('prod_height', '', array('class' => 'form-control delivery_require','id' => 'prod_height'))!!}
                    </div>
					{!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-1 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="clearfix"></div>
                </div>	
                <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                    {!! Form::label('product_specification_2', 'Weight', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="col-sm-3 mt" style="margin-top:0">
						{!! Form::text('prod_weight', '', array('class' => 'form-control delivery_require','id' => 'prod_weight'))!!}
                    </div>
					{!! Form::label('product_specification_2', 'kg', array('class' => 'col-sm-1 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="clearfix"></div>
                </div>	
				<div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                    {!! Form::label('product_specification_2', 'Delivery Time', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="col-sm-1 mt" style="margin-top:0">
						{!! Form::text('prod_del_time', '', array('class' => 'form-control delivery_require2','id' => 'prod_del_time'))!!}
                    </div>
					<div class="col-sm-1 mt" style="margin-top:0">
						<center style="margin-top:10px"><b>To</b></center>
                    </div>
					<div class="col-sm-1 mt" style="margin-top:0">
						{!! Form::text('prod_del_time_to', '', array('class' => 'form-control delivery_require2','id' => 'prod_del_time_to'))!!}
                    </div>
					{!! Form::label('product_specification_2', 'working days', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="clearfix"></div>
                </div>
                <!-- <div style="margin-bottom:5px" class="form-group" id="product_specification_sno">
                    {!! Form::label('serial_no', 'Serial No./IMEI', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                    <div class="col-sm-3 mt" style="margin-top:0">
                        <input  name="has_serialno" type="checkbox"
                       value="1" 
                        
                       >
                    </div>
                 
                    <div class="clearfix"></div>
                </div> -->
            </div>
        </div>

        <div class="clearfix"></div>
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
        <div class="row">
			<div class="col-sm-6">
			</div>
            <div class="col-sm-5">
				<div class="w3-light-grey w3-round-large" id="totalBar" style="display: none;">
					<div class="w3-container w3-blue w3-round-large" style="width:0%" id="myBar">0%</div>
				</div>			
			</div>
            <div class="col-sm-1">
                <p style="float:right;">
					<a href="javascript:void(0)"
					class="btn btn-info" id="next_retail"
					style="width:70px;height:70px;border-radius:5px;cursor:pointer;font-size:20px;padding-top:22px">
					Save</a>
                </p>
            </div>
        </div>
	</div>

	<div id="regbodycustom" style="display:none;">
	</div>
	<!-- Product Registration B2B NEXT/ DONT Close Form in this View! -->
    <br/><br/>
<script>
    $(document).ready(function () {	
		$(document).delegate( '.all_own_toastr', "click",function (event) {
			toastr.warning("In order to use own delivery you need to create new Logistic Provider Account!");
		});	
		
		$('#color1').paletteColorPicker();
		$('#addcolor').on('click', function () {
			var colors_id = parseInt($("#colors_id").val());
			colors_id++;
			$("#colors_id").val(colors_id);
			//console.log($("#colorst"));
			$("#colors").append('<div id="colord'+colors_id+'"><div class="col-sm-2 control-label">&nbsp;</div><div class="col-sm-3 mt" style="margin-top:0"><input type="text" class="form-controln colorpick" name="unique-name-'+colors_id+'" id="color'+colors_id+'" data-palette=\''+$("#colorst").val()+'\' value="" style="margin-left: 35px;"></div><div class="col-sm-1 mt" style="padding-left:0"><a  href="javascript:void(0);" id="deletecolor'+colors_id+'" rel="'+colors_id+'" class="text-danger"><i class="fa fa-minus-circle deletecolor"></i></a></div><div class="clearfix"></div></div>');
			$('#color'+colors_id).paletteColorPicker();
			$('body').on('click', '#deletecolor' + colors_id, function () {
				$("#colord" + colors_id).remove();
			});	
		});	
		function enableInput() {
		    $('#pinformation :input').attr('disabled',false);
		    // $(':select').attr('disabled',false);
		}
		function disableInput() {
		    $('#pinformation :input').attr('disabled',true);
		    // $(':select').attr('disabled',true);
		}
		$('#Category_id_product').on('change', function () {
			$(this).removeClass('error');
			$(this).siblings('label.error').remove();
			var val = $(this).val();
			if (val != "") {
				var text = $('#Category_id_product option:selected').text();
				$('.category_p').html(text);	
				$.ajax({
					type: "post",
					url:  JS_BASE_URL + '/subcategoryp',
					data: {id: val},
					success: function (responseData, textStatus, jqXHR) {
						enableInput();
						$('#subcat').html(responseData);
						$('#Category_id_product-error').remove();
						if(val == "2"){
							$("#product_specification_3").show();
						} else {
							$("#product_specification_3").hide();
						}						
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
				disableInput();
			}
		});

		$('#subcat').on('change', function () {
			var subcat = $(this).val();
			//alert(subcat);
			
			if (subcat != "") {
				var text = $('#subcat option:selected').text();
				$('#color').html(text);
				var cat = $("#Category_id_product").val();
				$.ajax({
					type: "post",
					url:  JS_BASE_URL + '/subcategoryp2',
					data: {id: subcat, cat: cat},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						enableInput();
						if(responseData != '<option value="0" selected>Choose Option</option>'){
							//$('#product_specification_2').show();
							$('#subcat2').attr("disabled", false);
						} else {
							//$('#product_specification_2').hide();
							$('#subcat2').attr("disabled", true);
						}
						$('#subcat2').html(responseData);
						$('#subcat2').change();
						
						$('#subcat2-error').remove();
					},
					error: function (responseData, textStatus, errorThrown) {
						enableInput();
						alert(errorThrown);
					}
				});
				disableInput();
			}			
		/*	var url = "/checktemplate";
            $.ajax({
                url: JS_BASE_URL + url,
                data: {subcat: subcat},
                dataType:'json',
                type:'post',
                cache: false,
                success:function(response){
					console.log(response);
                    if(response == "0"){
						$("#regbody").show();
						$("#regbodycustom").hide();
					} else {
						$("#regbody").hide();
						$("#regbodycustom").show();
						$("#regbodycustom").load('custom/' + response.productreg_file + '.blade.php');
					}
                },
            });*/
		});
		
		$('#subcat2').on('change', function () {
			var subcat = $(this).val();
			if (subcat != "") {
				var text = $('#subcat2 option:selected').text();
				//$('#color').html(text);
				var cat = $("#Category_id_product").val();
				var subcat1 = $("#subcat").val();
				$.ajax({
					type: "post",
					url:  JS_BASE_URL + '/subcategoryp3',
					data: {id: subcat, cat: cat, subcat1: subcat1},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						enableInput();
						if(responseData != '<option value="0" selected>Choose Option</option>'){
							//$('#product_specification_3').show();
							$('#subcat3').attr("disabled", false);
						} else {
							//$('#product_specification_3').hide();
							$('#subcat3').attr("disabled", true);
						}
						$('#subcat3').html(responseData);
						$('#subcat3').change();
						$('#subcat3-error').remove();
					},
					error: function (responseData, textStatus, errorThrown) {
						disableInput();
						alert(errorThrown);
					}
				});
				disableInput();
			}			
		});	

        $('#plusb').on('click', function () {
            var rp = $('#rPrice').val();
            var op = $('#oPrice').val();
            var fq = $('#checkboxDqn').val();
            if(fq == ""){
                fq = "0";
            }
            if(op == "" || op == 0){
                op = rp;
            }
            var amount = parseFloat(op);
            var del = $('#del_malaysia_v').val();
            if(del == ""){
                del = 0;
            }
            del = parseFloat(del);
            var cant =  parseInt($("#cantp").val());
            cant++;
            $("#cantp").val(cant);
            if(cant>=parseInt(fq) && parseInt(fq) > 0){
                del = 0;
                $('#retail_delivery').text(0).number(true, 2);
            }
            var total =  amount;

            $("#retail_amount").text((amount*cant)+del).number(true, 2);
            $("#retail_total").text((total*cant)+del).number(true, 2);
        });
        $('#minusb').on('click', function () {
            var rp = $('#rPrice').val();
            var op = $('#oPrice').val();
            if(op == "" || op == 0){
                op = rp;
            }
            var fq = $('#checkboxDqn').val();
            if(fq == ""){
                fq = "0";
            }
            var amount = parseFloat(op);
            var del = $('#del_malaysia_v').val();
            if(del == ""){
                del = 0;
            }
            del = parseFloat(del);
            var cant =  parseInt($("#cantp").val());
            cant--;
            if (cant > 0) {
                if(cant<parseInt(fq) && parseInt(fq) > 0){
                    del = $('#del_malaysia_v').val();
                    $('#retail_delivery').text(del).number(true, 2);
                    del = parseFloat(del);
                } else {
                    if(parseInt(fq) > 0){
                        del = 0;
                    }
                }
                $("#cantp").val(cant);
                var total =  amount + del;
                $("#retail_amount").text((amount*cant)+del).number(true, 2);
                $("#retail_total").text((total*cant)+del).number(true, 2);
            }
        });

   

    
    });
</script>

	<script>
	/* Code for validation of name in merchant album page.
	* This same code is also used in edit/add new*/
	var data;
	function get_inventory() {
        $.ajax({
            type:"GET",
            url:"{{url('product/list/json')}}",
            success:function(r){
                if (r.status=="success") {
                    data=r.data;

                    $("#name_v").val("");
                    $("#name_v").prop("disabled",false);
                    $( "#name_v" ).autocomplete({
                        source:data
					});                                

					$(".album_product_name_validation1").change(function(){
						console.log("A keyup:>",$(this).val(),"<");
						a = $(this).val().trim();
						$(this).val(a);
						//alert('>'+$(this).val()+'<');
						console.log("B keyup:>",$(this).val(),"<");
						if ($.inArray($(this).val(),data)!==-1) {
							console.log("keyup2",$(this).val())
							$(".pex").text("Product name already being used..");
							$("#productnamevalid").val('false');
						}else{
							$(".pex").empty();
							$("#productnamevalid").val('true');
                            $("#name_p").text(a)
						}
					});
                }
            },
            error:function(){

            }
        })
	}

	$( function() {
		get_inventory();
	});

    </script>
