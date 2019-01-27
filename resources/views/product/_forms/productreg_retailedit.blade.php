<?php 
	use App\Classes;
	$fdel = $current_product->free_delivery;

?>
    <style>
        .wColorPicker-button {
            width: 75px !important;
            height: 25px !important;
            margin-top: -4px !important;
        }
        
        .wColorPicker-button-color {
            height: 20px !important;
        }
        
        .wColorPicker-palettes-holder {
            width: 230px !important;
        }
        
        #progresscontain {
            margin: 20px;
            width: 400px;
            height: 8px;
            position: relative;
        }
    </style>
    <link rel="Stylesheet" type="text/css" href="{{url('css/palette-color-picker.css')}}" />
    <script type="text/javascript" src="{{url('js/palette-color-picker.js')}}"></script>
    <link rel="Stylesheet" type="text/css" href="{{url('css/wColorPicker.css')}}" />
    <script type="text/javascript" src="{{url('js/rgbHex.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/wColorPicker.js')}}"></script>
    <style>
        .btn-subcat {
            border: none;
            background: #fff;
            padding-left: 0px;
        }
    </style>
    <div class="modal fade" id="myModalSecRemarks" role="dialog" aria-labelledby="myModalRemarks">
        <div class="modal-dialog" role="remarks" style="width: 50%">
            <div class="modal-content">
                <div class="row" style="padding: 15px;">
                    <div class="col-md-12" style="">
                        <form id="secremarks-form">
                            <fieldset>
                                <h2>Remarks</h2>
                                <br>
                                <textarea style="width:100%; height: 250px;" name="name" id="status_secremarks" class="text-area ui-widget-content ui-corner-all">
                                </textarea>
                                <br>
                                <input type="button" id="save_secremarks" class="btn btn-primary" value="Save Remarks">
                                <input type="hidden" id="current_secrole_roleId" remarks_role="">
                                <input type="hidden" id="current_secstatus" value="">
                                <input type="hidden" id="current_section" value="">
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
    {!! Form::open(['class'=> 'form-horizontal','files' => true,'id'=>'productRegForm', 'style'=>'margin-top:0']) !!}
    <form id="prod_retail_form">
        <div id="pinformation" class="row">
            <div class="col-sm-4">
                <h1>Product Information</h1>
            </div>
            <div class="col-sm-8">
                @if(Auth::check()) @if(Auth::user()->hasRole('adm')) @if(isset($productapp['approval']['information']))
                <div class="action_buttons">
                    <?php
							$approvesec = new Classes\SectionApproval('product', 'information', $id);
							if ($productapp['approval']['information'] == 'approved') {
								$approvesec->getRejectButton();
							} else if ($productapp['approval']['information'] == 'rejected') {
								$approvesec->getApproveButton();
							} else if ($productapp['approval']['information'] == '') {
								$approvesec->getAllButton();
							}
							echo $approvesec->view;
							?>
                </div>
                @endif @endif @endif &nbsp;
            </div>
            <div class="clearfix"></div>
            <input type="hidden" value="{{$id}}" id="myproduct_id" name="myproduct_id" />
            <div class="col-sm-4 thumbnail">
                <div class="product-photo">
                    <img class="img img-responsive" id="preview-img" style="width:100%;height:98%;object-fit:cover;object-position:center top" src="{{asset('/')}}images/product/{{$id}}/{{$current_product->photo_1}}" />
                    <div class="inputBtnSection">
                        {!! Form::text('photo',null,['class'=>'disableInputField text-center','id'=>'uploadFile','placeholder'=>'375 x 300','disabled'=>'disabled']) !!}
                        <label class="fileUpload">
                            {!! Form::file('product_photo',['class'=>'upload','id'=>'uploadBtn']) !!}
                            <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div style='margin-bottom:5px' class="form-group">
                    {!! Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9">
                        {!! Form::text('name', $current_product->name, array('class' => 'validator form-control album_product_name_validation', 'id' => 'name_v'))!!}
                        <br>
                        <span class="pex"></span>
                        <input type="hidden" id="productnamevalid" value="true">
                    </div>
                </div>

                <div style='margin-bottom:5px' class="form-group">
                    {!! Form::label('brand_id', 'Brand', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9">
                        <select name="brand_id" class="form-control validator noselect2" id="brand_v">
                            <option value="" selected>Choose Option</option>
                            @foreach($brand as $Brand)
                            <?php
								$selected_brand = "";
								if($Brand->id == $current_product->brand_id){
									$selected_brand = "selected";
								}
							?>
                                <option value="{{ $Brand->id }}" {{$selected_brand}}>{{ $Brand->name }}</option>

                                @endforeach
                        </select>
                    </div>

                </div>
                <div style='margin-bottom:5px' class="form-group">
                    {!! Form::label('category_id', 'Category', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9">

                        <select name="category_id" class="form-control validator" id="Category_id_product">
                            <option value="">Choose Option</option>
                            @foreach($category as $Category)
                            <?php
								$selected_category = "";
								if($Category->id == $current_product->category_id){
									$selected_category = "selected";
								}
							?>
                                <option value="{{ $Category->id }}" {{$selected_category}}>{{ $Category->description }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div style='margin-bottom:5px' class="form-group">
                    {!! Form::label('subcat_id', 'Sub Category', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9">
                        <select name="subcat_id" class="form-control validator" id="subcat">
                            <option value="">Choose Option</option>
                            @if(!is_null($subcat_level1)) @foreach($subcat_level1 as $subCategory)
                            <?php
								$selected_subcategory = "";
								if($subCategory->id == $subcat_level_1_id){
									$selected_subcategory = "selected";
								}
							?>
                                <option value="{{ $subCategory->id }}-1" {{$selected_subcategory}}>{{ $subCategory->description }}</option>
                                @endforeach @endif
                        </select>
                    </div>
                </div>
                <div style='margin-bottom:5px' class="form-group">
                    {!! Form::label('brand_id', 'O-Shop', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9">
                        <select name="oshop_id" class="form-control validator" id="oshop_v">
                            <option value="" selected>Choose Option</option>
                            <option value="0">Not Display</option>
                            @foreach($oshops as $Oshop)
                            <?php
								$oshoid = 0;
								$myoshop = DB::table('oshopproduct')->where('product_id',$id)->first();
								if(!is_null($myoshop)){
									$oshoid = $myoshop->oshop_id;
								} 								
								$selected_oshop = "";
								if($Oshop->id == $oshoid){
									$selected_oshop = "selected";
								}
							?>
                                <option value="{{ $Oshop->id }}" {{$selected_oshop}}>{{ $Oshop->oshop_name }}</option>

                                @endforeach
                        </select>
                    </div>

                </div>
                <div style='margin-bottom:5px' class="form-group">
                    {!! Form::label('short_description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                    <div class="col-sm-9">
                        {!! Form::textarea('short_description', addslashes($current_product->description), array('class' => 'form-control', 'rows' => '4','id'=>'short_description'))!!}
                    </div>
                </div>
                <div style='margin-bottom:5px' class="form-group">
                    {!! Form::label('available', 'Qty Allocated for Online', array('class' => 'col-sm-3 control-label','style'=>'color:red;font-weight:normal')) !!}
                    <div class="col-sm-4">
                        {!! Form::text('available', number_format($current_product->available,2, '.', ''), array('class' => 'validator form-control', 'style'=>'width:100px','id' => 'quantity_v'))!!}
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr> @if(is_null($template))
        <div id="regbody">
            <div id="delivery" class="row">

                <div class="col-sm-6" style="padding-left:0">
                    <div class="col-sm-3" style="padding-left:0">
                        <h2>Retail</h2>
                    </div>
                    <div class="col-sm-9">
                        @if(Auth::check()) @if(Auth::user()->hasRole('adm')) @if(isset($productapp['approval']['retail']))
                        <div class="action_buttons">
                            <?php
								$approvesec = new Classes\SectionApproval('product', 'retail', $id);
								if ($productapp['approval']['retail'] == 'approved') {
									$approvesec->getRejectButton();
								} else if ($productapp['approval']['retail'] == 'rejected') {
									$approvesec->getApproveButton();
								} else if ($productapp['approval']['retail'] == '') {
									$approvesec->getAllButton();
								}
								echo $approvesec->view;
								?>
                        </div>
                        @endif @endif @endif
                    </div>
                    <div class="col-xs-12">
                        <div style='margin-bottom:5px' class="form-group row">
                            {!! Form::label('retail_price11', 'Retail Price ('.$active_currency.')', array('style' => 'padding-top:0;padding-left:0', 'class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-5">

                                {!! Form::text('retail_price', number_format(($current_product->retail_price/100),2), (['class' => 'validator retailSave form-control', 'id'=>'rPrice']))!!}
                            </div>
                        </div>
                        <div style='margin-bottom:5px' class="form-group row">
                            {!! Form::label('discounted_price', 'Selling Price ('.$active_currency.')', array('style' => 'padding-top:0;padding-left:0', 'class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-5">
                                {!! Form::text('discounted_price', number_format(($current_product->discounted_price/100),2), array('class' => 'retailSave form-control', 'id'=>'oPrice' ))!!}
                            </div>
                            <div class="col-sm-4 text-danger">
                                <?php
						$mysave = 0;
						if($current_product->discounted_price > 0 &&
							$current_product->retail_price > 0){
							$mysave = (($current_product->retail_price -
								$current_product->discounted_price)/$current_product->retail_price)*100;
						}
					?>
                                    SAVE <span id="resultSave">{{number_format(($mysave),2, '.', '')}}</span>%
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php 
						$toastrclass = "";
						$canown = 1;
						if(is_null($logistic_id)){
							$toastrclass = "all_own_toastr";
							$canown = 0;
						}

						 $hidevoucher = "";
						$hidenvoucher = "none";
						$checked_voucher = "";
						$dm=$current_product->delivery_mode;
						if (in_array($current_product->type,["voucher","service","platypos"])) {
							# code...
							$dm="--";
						}
							if($current_product->type == 'voucher'){
							$hidevoucher = "none";
							$hidenvoucher = "block";
							$checked_voucher = "checked";
							$checked_system_option = "";
							$checked_own_option = "";
							$checked_pick_up_only = "";
						} 
					?>

					<input type="hidden" id="canown" value="{{$canown}}" />
					<div style="padding-left:0;margin-bottom:15px" class="col-sm-12">.

					<h2>Delivery</h2>
					<label class="radio-inline">
						<input type="radio" value="system" name="del_option" {{ $dm=="system" ? 'checked' : 'unchecked' }}
						> System Delivery</label>
					<label class="radio-inline" >
						<input type="radio" value="own" class='{{$toastrclass}}' name="del_option" {{ $dm=="own" ? 'checked' : 'unchecked' }}> Own Delivery</label>
					<label class="radio-inline" >
						<input type="radio" value="pickup" name="del_option" {{ $dm=="pickup" ? 'checked' : 'unchecked' }} > Pick up Only</label>

					<br>
					<label style="margin-top:-10px" class="radio-inline">
					<input type="radio" value="voucher" name="del_option"
					{{($current_product->type=="voucher"?"checked":"unchecked")}}\>Voucher
					<div style="color:red;display:inline">
					(no inventory count needed)</div>
					</label>
					<br>
					<label style="margin-top:-10px" class="radio-inline">
					<input type="radio" value="service" name="del_option"
					{{in_array($current_product->type,["service","platypos"])?"checked":"unchecked"}}>
					Restaurants & Services
					<div style="color:red;display:inline">
					(no inventory count needed)</div>
					</label>
                    <!-- <br>
                    <label style="margin-top:-10px" class="radio-inline">
                    <input type="radio" value="warranty" name="del_option"
                    {{($current_product->type=="warranty"?"checked":"unchecked")}} >
                    Warranty No.
                    </label> -->

				    {{--  </label> --}}

					</div>
					{{--Paul on 15 May 2017--}}

                        <div id="own_delivery" @if($checked_system_option=='checked' ||$checked_pick_up_only=='checked' ) style="display:none;" @else style="display: {{$hidevoucher}}" @endif>
                            <h3>Delivery Coverage</h3>
                            <div style='margin-bottom:5px' class="form-group">
                                {!! Form::label('cov_country_id', 'Country', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-9">
                                    <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country" id="country_id" disabled>
                                        <option value="150">Malaysia</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="cov_country_id" name="cov_country_id" value="150">
                            <div style='margin-bottom:5px' class="form-group">
                                {!! Form::label('cov_state_id', 'State', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-9">
                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="states" name="cov_state_id" data-style="btn-green" required>
                                        <option value="0">Choose Option</option>
                                        @foreach($states as $state)
                                        <?php
									$selected_state = "";
									if($state->id ==
										$current_product->cov_state_id){
										$selected_state = "selected";
									}
								?>
                                            <option value="{{$state->id}}" {{$selected_state}}>
                                                {{$state->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div style='margin-bottom:5px' class="form-group">
                                {!! Form::label('cov_city_id', 'City', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-9">
                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="cities" name="cov_city_id" data-style="btn-green" required>
                                        <option value="0">Choose Option</option>
                                        @foreach($city as $cities)
                                        <?php
									$selected_city = "";
									if($cities->id == $current_product->cov_city_id){
										$selected_city = "selected";
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
                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="areas" name="cov_area_id" data-style="btn-green">
                                        <option value="0" selected>Choose Option</option>
                                        @foreach($areas as $area)
                                        <?php
									$selected_area = "";
									if($area->id == $current_product->cov_area_id){
										$selected_area = "selected";
									}
								?>
                                            <option value="{{$area->id}}" {{$selected_area}}>{{$area->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <?php
					$free_flat = 0;
					if($current_product->flat_delivery > 0){
						$free_flat = 1;
					}
					$free_qty = 0;
					if($current_product->free_delivery_with_purchase_amt > 0){
						$free_qty = 1;
					}
				?>
                                <h3>Delivery Pricing</h3>
                                <div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
                                    <div class="toggleDelivery">
                                        <div style='margin-bottom:5px; display: none;' class="form-group">
                                            {!! Form::label('del_worldwide', 'World Wide', array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                {!! Form::text('del_worldwide', number_format(($current_product->del_worldwide/100),2, '.', ''), array('class' => 'validator1 form-control delivery_prices','id' => 'del_world_v'))!!}
                                            </div>
                                        </div>
                                        <div style='margin-bottom:5px' class="form-group">
                                            {!! Form::label('del_west_malaysia', 'Price per Unit', array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                {!! Form::text('del_west_malaysia', number_format(($current_product->del_west_malaysia/100),2, '.', ''), array('class' => 'validator1 form-control delivery_prices','id' => 'del_malaysia_v'))!!}
                                            </div>
                                        </div>
                                        <div style='margin-bottom:5px; display: none;' class="form-group">
                                            {!! Form::label('del_sabah_labuan', 'Sabah/Labuan', array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                {!! Form::text('del_sabah_labuan', number_format(($current_product->del_sabah_labuan/100),2, '.', ''), array('class' => 'validator1 form-control delivery_prices','id' => 'del_sabah_v'))!!}
                                            </div>
                                        </div>
                                        <div style='margin-bottom:5px; display: none;' class="form-group">
                                            {!! Form::label('del_sarawak', 'Sarawak', array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                {!! Form::text('del_sarawak', number_format(($current_product->del_sarawak/100),2, '.', ''), array('class' => 'validator1 form-control delivery_prices','id' => 'del_sarawak_v'))!!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox checkbox-success" style="margin-left:0">
                                        @if($free_flat == 1) {!! Form::checkbox('flat_delivery', 1, null, ['class' => 'styled','id'=>'checkboxF', 'checked'=>'checked']) !!} @else {!! Form::checkbox('flat_delivery', 1, null, ['class' => 'styled','id'=>'checkboxF']) !!} @endif {!! Form::label('checkbox1', 'Flat Delivery Price') !!}
                                    </div>
                                </div>
                                <br>
                                <div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
                                    <div class="checkbox checkbox-success" style="margin-left:0">
                                        @if($fdel == 1) {!! Form::checkbox('free_delivery', 1, null, ['class' => 'styled','id'=>'checkboxD', 'checked'=>'checked']) !!} @else @if($free_qty == 1) {!! Form::checkbox('free_delivery', 1, null, ['class' => 'styled','id'=>'checkboxD','disabled' => 'disabled']) !!} @else {!! Form::checkbox('free_delivery', 1, null, ['class' => 'styled','id'=>'checkboxD']) !!} @endif @endif {!! Form::label('checkbox1', 'Free Delivery') !!}
                                    </div>

                                    <div class="col-sm-8 checkbox checkbox-success" style="margin-left:0">
                                        @if($fdel == 1) {!! Form::checkbox('free_delivery_qty', 1, $free_qty, ['class' => 'styled','id'=>'checkboxDq', 'disabled' => 'disabled']) !!} @else @if($free_qty == 1) {!! Form::checkbox('free_delivery_qty', 1, $free_qty, ['class' => 'styled','id'=>'checkboxDq', 'checked'=>'checked']) !!} @else {!! Form::checkbox('free_delivery_qty', 1, $free_qty, ['class' => 'styled','id'=>'checkboxDq']) !!} @endif @endif {!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}
                                    </div>
                                    <div class="col-sm-4" style="padding-right:0">
                                        @if($free_qty == 1) {!! Form::text('free_delivery_with_purchase_amt_ow', number_format(($current_product->free_delivery_with_purchase_amt/100),2, '.', ''), array('class' => 'form-control delivery_waiver_min_amt','id'=>'checkboxDqn', 'style'=>'margin-top:-6px;margin-left:-40px;width:100px;text-align:right;float: right;'))!!} @else {!! Form::text('free_delivery_with_purchase_amt_ow', number_format(($current_product->free_delivery_with_purchase_amt/100),2, '.', ''), array('class' => 'form-control delivery_waiver_min_amt', 'disabled' => 'disabled','id'=>'checkboxDqn', 'style'=>'margin-top:-6px;margin-left:-40px;width:100px;text-align:right;float: right;'))!!} @endif
                                    </div>
                                </div>
                        </div>
                         {{-- VOUCHER --}}
	                <div id="pvoucher" style="display:{{

	                	$current_product->type=="voucher"?"all":"none"
	                	}};">

	                    <h3>Voucher Specifications</h3>
	                    <div style="margin-bottom:5px;" class="form-group">
	                        <div class="col-sm-4">
	                            <label>Package Qty</label>
	                        </div>
	                        <div class="col-sm-8">
	                            <input type="number" name="voucher_package_qty"
                                value="{{$current_product->voucher_package_qty}}" 
                                >
	                        </div>
	                    </div>
	                    <div style="margin-bottom:5px;" class="form-group">
	                        <div class="col-sm-4">
	                            <label>Qty Limit</label>
	                        </div>
	                        <div class="col-sm-8">
	                            <input type="number" name="otc_qty_limit"
                                value="{{$current_product->voucher_qty_limit}}" 
                                >
	                        </div>
	                    </div>
	                    <div style="margin-bottom:5px;" class="form-group">
	                        <div class="col-sm-4">
	                            <label>Expiry</label>
	                        </div>
                            <?php
                                //dump($current_product->expiry_date);
                            ?>
	                        <div class="col-sm-8">
	                            <input id="voucher_expiry" name="expiry_date"
                                value="{{date("m/d/Y",strtotime($current_product->expiry_date))}}" 
                                >
	                        </div>
	                    </div>

	                </div>

	                {{-- VOUCHER ENDS --}}
                        <div id="system_delivery" @if($checked_own_option=='checked' || $checked_pick_up_only=='checked' ) style="display:none;" @else style="display: {{$hidevoucher}}" @endif>
                            {{--
                            <input type="hidden" id="cms_pricing" value="{{ $global_system_vars->cms_pricing }}" />
                            <input type="hidden" id="grs_pricing" value="{{ $global_system_vars->grs_pricing }}" />
                            <input type="hidden" id="mts_pricing" value="{{ $global_system_vars->mts_pricing }}" />
                            <h3>Delivery Requirements</h3>
                            <div class="delivery_requirements">
                                <div style='margin-bottom:5px' class="form-group">
                                    {!! Form::label('del_width', 'Width', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-4">
                                        {!! Form::text('del_width', number_format($current_product->del_width,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'del_width'))!!}
                                    </div>
                                    <div class="col-sm-1">
                                        cm
                                    </div>
                                </div>
                                <div style='margin-bottom:5px' class="form-group">
                                    {!! Form::label('del_lenght', 'Lenght', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-4">
                                        {!! Form::text('del_lenght', number_format($current_product->del_lenght,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'del_lenght'))!!}
                                    </div>
                                    <div class="col-sm-1">
                                        cm
                                    </div>
                                </div>
                                <div style='margin-bottom:5px' class="form-group">
                                    {!! Form::label('del_height', 'Height', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-4">
                                        {!! Form::text('del_height', number_format($current_product->del_height,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'del_height'))!!}
                                    </div>
                                    <div class="col-sm-1">
                                        cm
                                    </div>
                                </div>
                                <div style='margin-bottom:5px' class="form-group">
                                    {!! Form::label('del_weight', 'Weight', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-4">
                                        {!! Form::text('del_weight', number_format($current_product->del_weight,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'del_weight'))!!}
                                    </div>
                                    <div class="col-sm-1">
                                        grs
                                    </div>
                                </div>
                            </div>
                            <br> --}}
                            <h3>Business Coverage</h3>
                            <div style='margin-bottom:5px' class="form-group">
                                {!! Form::label('cov_country_id', 'Country', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-9">
                                    <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country" id="country_id" disabled>
                                        <option value="150">Malaysia</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="cov_country_id" name="biz_country_id" value="150">
                            <div style='margin-bottom:5px' class="form-group">
                                {!! Form::label('cov_state_id', 'State', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-9">
                                    <select style="width: 100%;" class="form-control" id="states_biz" name="biz_state_id" data-style="btn-green">
                                        <option value="0" disabled="" selected="">Choose Option</option>
                                        @foreach($states as $state)
                                        <?php
										$selected_state = "";
										if($state->id == $current_product->cov_state_id){
											$selected_state = "selected";
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
                                    <select style="width: 100%;" class="form-control" id="cities_biz" name="biz_city_id" data-style="btn-green">
                                        <option value="0">Choose Option</option>
                                        @foreach($city as $cities)
                                        <?php
										$selected_city = "";
										if($cities->id == $current_product->cov_city_id){
											$selected_city = "selected";
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
                                    <select style="width: 100%;" class="form-control" id="areas_biz" name="biz_area_id">
                                        <option value="0" selected>Choose Option</option>
                                        @foreach($areas as $area)
                                        <?php
										$selected_area = "";
										if($area->id == $current_product->cov_area_id){
											$selected_area = "selected";
										}
									?>
                                            <option value="{{$area->id}}" {{$selected_area}}>{{$area->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <?php 
						//$calc_pricing = ($current_product->del_width * $current_product->del_lenght * $current_product->del_height * $global_system_vars->cms_pricing) + ($current_product->del_weight * $global_system_vars->grs_pricing);
					?>
                                <div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
                                    <div style='margin-bottom:5px' class="form-group">
                                        {!! Form::label('del_pricing','Pricing', array('class' => 'col-sm-3 control-label')) !!}
                                        <div class="col-sm-4">
                                            {!! Form::text('del_pricing', number_format($delivery_pricec/100,2, '.', ''), array('class' => 'form-control delivery_prices', 'id' => 'del_pricing','disabled', 'style'=>'text-align:right'))!!}
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
                                <?php
                        $free_qty = 0;
					    if($current_product->free_delivery_with_purchase_amt > 0){
                            $free_qty = 1;
                        }
					?>
                                    <div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
                                        <div class="checkbox checkbox-success" style="margin-left:0">
                                            @if($fdel == 1) {!! Form::checkbox('free_delivery_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD', 'checked'=>'checked']) !!} @else @if($free_qty == 1) {!! Form::checkbox('free_delivery_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD','disabled' => 'disabled']) !!} @else {!! Form::checkbox('free_delivery_ow', 1, null, ['class' => 'styled','id'=>'sd_checkboxD']) !!} @endif @endif {!! Form::label('checkbox1', 'Free Delivery') !!}
                                        </div>

                                        <div class="col-sm-8 checkbox checkbox-success" style="margin-left:0">
                                            @if($fdel == 1) {!! Form::checkbox('free_delivery_qty_ow', 1, $free_qty, ['class' => 'styled','id'=>'sd_checkboxDq', 'disabled' => 'disabled']) !!} @else @if($free_qty == 1) {!! Form::checkbox('free_delivery_qty_ow', 1, $free_qty, ['class' => 'styled','id'=>'sd_checkboxDq', 'checked'=>'checked']) !!} @else {!! Form::checkbox('free_delivery_qty_ow', 1, $free_qty, ['class' => 'styled','id'=>'sd_checkboxDq']) !!} @endif @endif {!! Form::label('checkbox1', 'Free Delivery with purchase amount of') !!}

                                        </div>
                                        <div class="col-sm-4" style="padding-right:0">
                                            @if($free_qty == 1) {!! Form::text('free_delivery_with_purchase_amt', number_format(($current_product->free_delivery_with_purchase_amt/100),2, '.', ''), array('class' => 'form-control delivery_waiver_min_amt','id'=>'sd_checkboxDqn', 'style'=>'margin-top:-6px;margin-left:0px;width:100px;text-align:right;float: right;'))!!} @else {!! Form::text('free_delivery_with_purchase_amt', number_format(($current_product->free_delivery_with_purchase_amt/100),2, '.', ''), array('class' => 'form-control delivery_waiver_min_amt','id'=>'sd_checkboxDqn', 'disabled' => 'disabled', 'style'=>'margin-top:-6px;margin-left:0px;width:100px;text-align:right;float: right;'))!!} @endif
                                        </div>
                                    </div>
                        </div>

                </div>
                <div class="clearfix"> </div>
            </div>
            <hr>
            <div id="retail" class="row">

                <div id="details" class="row">
                    <div class="col-sm-4" style="padding-left:0">
                        <h2>Product Details</h2>
                    </div>
                    <div class="col-sm-8">
                        @if(Auth::check()) @if(Auth::user()->hasRole('adm')) @if(isset($productapp['approval']['details']))
                        <div class="action_buttons">
                            <?php
								$approvesec = new Classes\SectionApproval('product', 'details', $id);
								if ($productapp['approval']['details'] == 'approved') {
									$approvesec->getRejectButton();
								} else if ($productapp['approval']['details'] == 'rejected') {
									$approvesec->getApproveButton();
								} else if ($productapp['approval']['details'] == '') {
									$approvesec->getAllButton();
								}
								echo $approvesec->view;
								?>
                        </div>
                        @endif @endif @endif
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12" style="padding-left:0">
                        {!! Form::textarea('product_details', $current_product->product_details, array('class' => 'form-control','id'=>'info-details'))!!}
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <hr>

                <div id="specification" class="row" style="display: {{$hidevoucher}}">
                    <div class="col-xs-4" style="padding-left:0">
                        <h2>Specifications</h2>
                    </div>
                    <div class="col-xs-8">
                        @if(Auth::check()) @if(Auth::user()->hasRole('adm')) @if(isset($productapp['approval']['specification']))
                        <div class="action_buttons">
                            <?php
							$approvesec = new Classes\SectionApproval('product', 'specification', $id);
							if ($productapp['approval']['specification'] == 'approved') {
								$approvesec->getRejectButton();
							} else if ($productapp['approval']['specification'] == 'rejected') {
								$approvesec->getApproveButton();
							} else if ($productapp['approval']['specification'] == '') {
								$approvesec->getAllButton();
							}
							echo $approvesec->view;
							?>
                        </div>
                        @endif @endif @endif
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12">
                        @if(!is_null($subcat_level2))
                        <div style="margin-bottom:5px" class="form-group">
                            {!! Form::label('product_specification_2', 'Product', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                            <div class="col-sm-4">
                                <select name="subcat_id_2" class="form-control validator" id="subcat2">
                                    <option value="">Choose Option</option>
                                    @foreach($subcat_level2 as $subCategory)
                                    <?php
									$selected_subcategory2 = "";
									if($subCategory->id == $subcat_level_2_id){
										$selected_subcategory2 = "selected";
									}
								?>
                                        <option value="{{ $subCategory->id }}-2" {{$selected_subcategory2}}>{{ $subCategory->description }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @else
                        <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                            {!! Form::label('product_specification_2', 'Product', array('class' => 'col-sm-2 control-label','style'=>'padding-left:0')) !!}
                            <div class="col-sm-4 mt" style="margin-top:0">
                                <select name="subcat_id_2" disabled class="form-control specs" id="subcat2">
                                    <option value="0" disabled="" selected="">Choose Option</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @endif @if(!is_null($subcat_level3))
                        <div style="margin-bottom:5px" class="form-group">
                            {!! Form::label('product_specification_3', 'SubProduct', array('class' => 'col-sm-2 control-label','style'=>'padding-left:0')) !!}
                            <div class="col-sm-4">
                                <select name="subcat_id_3" class="form-control validator" id="subcat3">
                                    <option value="">Choose Option</option>
                                    @foreach($subcat_level3 as $subCategory)
                                    <?php
									$selected_subcategory3 = "";
									if($subCategory->id == $subcat_level_3_id){
										$selected_subcategory3 = "selected";
									}
								?>
                                        <option value="{{ $subCategory->id }}-3" {{$selected_subcategory3}}>{{ $subCategory->description }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @else @if($subcat_level_1_id == 2)
                        <div style="margin-bottom:5px" class="form-group" id="product_specification_3">
                            @else
                            <div style="margin-bottom:5px" class="form-group" id="product_specification_3" style="display: none;">
                                @endif {!! Form::label('product_specification_3', 'SubProduct', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                                <div class="col-sm-4 mt" style="margin-top:0">
                                    <select name="subcat_id_3" disabled class="form-control specs" id="subcat3">
                                        <option value="0" disabled="" selected="">Choose Option</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            @endif
                            <?php 
				$colorst = DB::table('color')->get();
				$colorsnn = '[';
				$wwww = 0;
				foreach($colorst as $color){
					if($wwww > 0){
						$colorsnn .= ',';
					}
					$colorsnn .= '{"' . $color->description . '": "' . $color->hex . '"}';
					$wwww++;
				}
				$colorsnn .= ']';
				/*$colors = '[{"primary": "#E91E63"},{"primary_dark": "#C2185B"},{"primary_light": "#F8BBD0"},{"accent": "#CDDC39"},{"primary_text": "#212121"},{"secondary_text": "#727272"},{"divider": "#B6B6B6"}]';
				$colors = '[{"test1": "#00fffff"}",{"test2": "#3366cc"}",{"3": "#66cc66"}",{"test4": "#33cc99"}",{"5": "#ff33cc"}",{"6": "#ff0000"}",{"test7": "#ffcccc"}",{"test8": "#ff9966"}",{"test9": "#66ffcc"}",{"test10": "#ffffff"}",{"test11": "#ccff99"}",{"test12": "#009900"}",{"test13": "#0066cc"}",{"test14": "#003300"}",{"test15": "#339900"}",{"test16": "#6633ff"}"]'*/
			?>
                                @if(!is_null($colors))
                                <div style="margin-bottom:5px" class="form-group" id="product_specification_color">
                                    <?php $ci = 1; ?>

                                        @foreach($colors as $colordef)
                                        <div id="colord{{$ci}}">
                                            @if($ci == 1) {!! Form::label('product_specification_color', 'Colour', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!} @else
                                            <div class="col-sm-2">
                                                &nbsp;
                                            </div>
                                            @endif
                                            <div class="col-sm-3 mt">
                                                <input width="50px" type="text" name="unique-name-{{$ci}}" class="form-controln colorpick" id="color{{$ci}}" data-palette='{{$colorsnn}}' value="{{$colordef->description}}" style="margin-left: 35px;">
                                            </div>
                                            <div class="col-sm-1 mt" style="padding-left:0">
                                                @if($ci == 1) &nbsp;
                                                <!-- <a  href="javascript:void(0);" id="addcolor" class="text-green"><i class="fa fa-plus-circle"></i></a> -->
                                                @else
                                                <a href="javascript:void(0);" id="deletecolor{{$ci}}" rel="{{$ci}}" class="text-danger"><i class="fa fa-minus-circle deletecolor"></i></a> @endif
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#color{{$ci}}').paletteColorPicker();
                                                        $('body').on('click', '#deletecolor{{$ci}}', function() {
                                                            $("#color{{$ci}}").remove();
                                                        });
                                                    });
                                                </script>
                                                <?php $ci++; ?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        @endforeach @if($ci == 1) {!! Form::label('product_specification_color', 'Colour', array('class' => 'col-sm-2 control-label','style'=>'padding-left:0')) !!}
                                        <div class="col-sm-3 mt">
                                            <input type="text" name="unique-name-1" class="form-controln colorpick" id="color1" data-palette='{{$colorsnn}}' value="" style="margin-left: 35px;">
                                        </div>
                                        <div class="col-sm-1 mt">
                                            &nbsp;
                                            <!--<a  href="javascript:void(0);" id="addcolor" class="text-green"><i class="fa fa-plus-circle"></i></a>-->
                                        </div>
                                        <div class="clearfix"></div>
                                        @endif
                                        <input type="hidden" id="colors_id" value="{{$ci}}" />

                                        <div id="colors"></div>
                                </div>
                                @else
                                <div style="margin-bottom:5px" class="form-group" id="product_specification_color">
                                    {!! Form::label('product_specification_color', 'Colour', array('class' => 'col-sm-2 control-label','style'=>'padding-left:0')) !!}
                                    <div class="col-sm-3 mt">
                                        <input type="text" name="unique-name-1" class="form-controln colorpick" id="color1" data-palette='{{$colorsnn}}' value="" style="margin-left: 35px;">
                                    </div>
                                    <div class="col-sm-1 mt">
                                        &nbsp;
                                        <!--<a  href="javascript:void(0);" id="addcolor" class="text-green"><i class="fa fa-plus-circle"></i></a>-->
                                    </div>
                                    <div class="clearfix"></div>
                                    <input type="hidden" id="colors_id" value="1" />
                                    <div id="colors"></div>
                                </div>
                                @endif
                                <input type="hidden" id="colorst" value="{{$colorsnn}}" />
                        </div>
                        <div class="clearfix"></div>
                        <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                            {!! Form::label('product_specification_2', 'Length', array('class' => 'col-sm-2 control-label','style'=>'padding-left:15')) !!}
                            <div class="col-sm-3 mt" style="margin-top:0;padding-left:25px">
                                {!! Form::text('prod_length', number_format($current_product->length,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'prod_length'))!!}
                            </div>
                            {!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-1 control-label','style'=>'padding-left:0')) !!}
                            <div class="clearfix"></div>
                        </div>
                        <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                            {!! Form::label('product_specification_2', 'Width', array('class' => 'col-sm-2 control-label','style'=>'padding-left:15')) !!}
                            <div class="col-sm-3 mt" style="margin-top:0;padding-left:25px">
                                {!! Form::text('prod_width', number_format($current_product->width,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'prod_width'))!!}
                            </div>
                            {!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-1 control-label','style'=>'padding-left:0')) !!}
                            <div class="clearfix"></div>
                        </div>
                        <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                            {!! Form::label('product_specification_2', 'Height', array('class' => 'col-sm-2 control-label','style'=>'padding-left:15')) !!}
                            <div class="col-sm-3 mt" style="margin-top:0;padding-left:25px">
                                {!! Form::text('prod_height', number_format($current_product->height,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'prod_height'))!!}
                            </div>
                            {!! Form::label('product_specification_2', 'cm', array('class' => 'col-sm-1 control-label','style'=>'padding-left:0')) !!}
                            <div class="clearfix"></div>
                        </div>
                        <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                            {!! Form::label('product_specification_2', 'Weight', array('class' => 'col-sm-2 control-label','style'=>'padding-left:15')) !!}
                            <div class="col-sm-3 mt" style="margin-top:0;padding-left:25px">
                                {!! Form::text('prod_weight', number_format($current_product->weight,2, '.', ''), array('class' => 'form-control delivery_require','id' => 'prod_weight'))!!}
                            </div>
                            {!! Form::label('product_specification_2', 'kg', array('class' => 'col-sm-1 control-label','style'=>'padding-left:0')) !!}
                            <div class="clearfix"></div>
                        </div>
                        <div style="margin-bottom:5px" class="form-group" id="product_specification_2">
                            {!! Form::label('product_specification_2', 'Delivery Time', array('class' => 'col-sm-2 control-label','style'=>'padding-left:15')) !!}
                            <div class="col-sm-1 mt" style="margin-top:0;padding-left:25px">
                                {!! Form::text('prod_del_time', number_format($current_product->delivery_time,2, '.', ''), array('class' => 'form-control delivery_require2','id' => 'prod_del_time'))!!}
                            </div>
                            <div class="col-sm-1 mt" style="margin-top:0">
                                <center style="margin-top:10px"><b>To</b></center>
                            </div>
                            <div class="col-sm-1 mt" style="margin-top:0">
                                {!! Form::text('prod_del_time_to', number_format($current_product->delivery_time_to,2, '.', ''), array('class' => 'form-control delivery_require2','id' => 'prod_del_time_to'))!!}
                            </div>
                            {!! Form::label('product_specification_2', 'working days', array('class' => 'col-sm-2 control-label','style'=>'padding-left:0')) !!}
                            <div class="clearfix"></div>
                        </div>
                       <!--  <div style="margin-bottom:5px" class="form-group" id="product_specification_sno">
                            {!! Form::label('serial_no', 'Serial No./IMEI', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left:0')) !!}
                            <div class="col-sm-3 mt" style="margin-top:0">

                               <input checked="checked" name="has_serialno" type="checkbox"
                               value="1" 
                               @if($current_product->has_serialno==1)
                               checked="checked"
                               @endif 
                               >
                            </div>
                         
                            <div class="clearfix"></div>
                        </div> -->
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
                <div class="col-sm-6">
                </div>
                <div class="col-sm-5">
                    <div class="w3-light-grey w3-round-large" id="totalBar" style="display: none;">
                        <div class="w3-container w3-blue w3-round-large" style="width:0%" id="myBar">0%</div>
                    </div>
                </div>
                <div class="col-sm-1">
                    <p style="float:right;">
                        <a href="javascript:void(0)" class="btn btn-info" id="next_retail" style="cursor: pointer; font-size: 20px">Save</a>
                    </p>
                </div>
            </div>
            @else
            <div id="regbodycustom">

            </div>
            <script>
                $(document).ready(function() {
                    $("#regbodycustom").load(JS_BASE_URL + '/custom/{{$template->productregedit_file}}.blade.php');
                });
            </script>
            @endif
            <br/>
            <br/>
            <script>
                $(document).ready(function() {

                    $(document).delegate('.all_own_toastr', "click", function(event) {
                        toastr.warning("In order to use own delivery you need to create new Logistic Provider Account!");
                    });

                    function enableInput() {
                        $('#pinformation :input').attr('disabled', false);
                        // $(':select').attr('disabled',false);
                    }

                    function disableInput() {
                        $('#pinformation :input').attr('disabled', true);
                        // $(':select').attr('disabled',true);
                    }
                    $('#color1').paletteColorPicker();
                    $('#addcolor').on('click', function() {
                        var colors_id = parseInt($("#colors_id").val());
                        colors_id++;
                        $("#colors_id").val(colors_id);
                        //console.log($("#colorst"));
                        $("#colors").append('<div id="colord' + colors_id + '"><div class="col-sm-2 control-label">&nbsp;</div><div class="col-sm-3 mt" style="margin-top:0"><input type="text" class="form-controln colorpick" name="unique-name-' + colors_id + '" id="color' + colors_id + '" data-palette=\'' + $("#colorst").val() + '\' value="" style="margin-left: 35px;"></div><div class="col-sm-1 mt" style="padding-left:0"><a  href="javascript:void(0);" id="deletecolor' + colors_id + '" rel="' + colors_id + '" class="text-danger"><i class="fa fa-minus-circle deletecolor"></i></a></div><div class="clearfix"></div></div>');
                        $('#color' + colors_id).paletteColorPicker();
                        $('body').on('click', '#deletecolor' + colors_id, function() {
                            $("#colord" + colors_id).remove();
                        });
                    });
                    $('#Category_id_product').on('change', function() {
                        $(this).removeClass('error');
                        $(this).siblings('label.error').remove();
                        var val = $(this).val();
                        if (val != "") {
                            var text = $('#Category_id_product option:selected').text();
                            $('.category_p').html(text);
                            $.ajax({
                                type: "post",
                                url: JS_BASE_URL + '/subcategoryp',
                                data: {
                                    id: val
                                },
                                cache: false,
                                success: function(responseData, textStatus, jqXHR) {
                                    enableInput();
                                    $('#subcat').html(responseData);
                                    $('#Category_id_product-error').remove();
                                    if (val == "2") {
                                        $("#product_specification_3").show();
                                    } else {
                                        $("#product_specification_3").hide();
                                    }
                                },
                                error: function(responseData, textStatus, errorThrown) {
                                    enableInput();
                                    alert(errorThrown);
                                }
                            });
                            disableInput();
                        }
                    });

                    $('#subcat').on('change', function() {
                        var subcat = $(this).val();
                        //alert(subcat);

                        if (subcat != "") {
                            var text = $('#subcat option:selected').text();
                            $('#color').html(text);
                            var cat = $("#Category_id_product").val();
                            $.ajax({
                                type: "post",
                                url: JS_BASE_URL + '/subcategoryp2',
                                data: {
                                    id: subcat,
                                    cat: cat
                                },
                                cache: false,
                                success: function(responseData, textStatus, jqXHR) {
                                    enableInput();
                                    if (responseData != '<option value="0" selected>Choose Option</option>') {
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
                                error: function(responseData, textStatus, errorThrown) {
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

                    $('#subcat2').on('change', function() {
                        var subcat = $(this).val();
                        if (subcat != "") {
                            var text = $('#subcat2 option:selected').text();
                            //$('#color').html(text);
                            var cat = $("#Category_id_product").val();
                            var subcat1 = $("#subcat").val();
                            $.ajax({
                                type: "post",
                                url: JS_BASE_URL + '/subcategoryp3',
                                data: {
                                    id: subcat,
                                    cat: cat,
                                    subcat1: subcat1
                                },
                                cache: false,
                                success: function(responseData, textStatus, jqXHR) {
                                    enableInput();
                                    if (responseData != '<option value="0" selected>Choose Option</option>') {
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
                                error: function(responseData, textStatus, errorThrown) {
                                    enableInput();
                                    alert(errorThrown);
                                }
                            });
                            disableInput();
                        }
                    });

                    $('#plusb').on('click', function() {
                        var rp = $('#rPrice').val();
                        var op = $('#oPrice').val();
                        var fq = $('#checkboxDqn').val();
                        if (fq == "") {
                            fq = "0";
                        }
                        if (op == "" || op == 0) {
                            op = rp;
                        }
                        var amount = parseFloat(op);
                        var del = $('#del_malaysia_v').val();
                        if (del == "") {
                            del = 0;
                        }
                        del = parseFloat(del);
                        var cant = parseInt($("#cantp").val());
                        cant++;
                        $("#cantp").val(cant);
                        if (cant >= parseInt(fq) && parseInt(fq) > 0) {
                            del = 0;
                            $('#retail_delivery').text(0).number(true, 2);
                        }
                        var total = amount;

                        $("#retail_amount").text((amount * cant) + del).number(true, 2);
                        $("#retail_total").text((total * cant) + del).number(true, 2);
                    });
                    $('#minusb').on('click', function() {
                        var rp = $('#rPrice').val();
                        var op = $('#oPrice').val();
                        if (op == "" || op == 0) {
                            op = rp;
                        }
                        var fq = $('#checkboxDqn').val();
                        if (fq == "") {
                            fq = "0";
                        }
                        var amount = parseFloat(op);
                        var del = $('#del_malaysia_v').val();
                        if (del == "") {
                            del = 0;
                        }
                        del = parseFloat(del);
                        var cant = parseInt($("#cantp").val());
                        cant--;
                        if (cant > 0) {
                            if (cant < parseInt(fq) && parseInt(fq) > 0) {
                                del = $('#del_malaysia_v').val();
                                $('#retail_delivery').text(del).number(true, 2);
                                del = parseFloat(del);
                            } else {
                                if (parseInt(fq) > 0) {
                                    del = 0;
                                }
                            }
                            $("#cantp").val(cant);
                            var total = amount + del;
                            $("#retail_amount").text((amount * cant) + del).number(true, 2);
                            $("#retail_total").text((total * cant) + del).number(true, 2);
                        }
                    });
                });
            </script>
