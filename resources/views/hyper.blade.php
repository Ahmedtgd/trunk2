<?php
use App\Http\Controllers\IdController;
$canhyper = true;
if(is_null($hyper)){
	if($product->status != 'active'){
		$canhyper = false;
	}
}
?>
@if($canhyper)
@def $currency = \App\Models\Currency::where('active', 1)->first()->code
<h3>Product: {{$product->name}}</h3>
@if(!is_null($hyper))
	<h3>Product ID: {{ IdController::nP($hyper->id) }}</h3>
@endif
<h5><b>Retail Price</b>: {{$currentCurrency}} {{number_format($product->private_retail_price/100,2, '.', '')}}</h5>
<p id="hypercant" style="color: red; display: none;">Product has active pledges, unable to modify Hyper parameters</p>
<br>
<div class="row" id="hyper_div">
	<input type="hidden" id="hyper_duration" value="{{ $global_system_vars->owarehouse_duration }}" />
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
					type="text" name="" class="form-control input-number" id="hyperprice" {{$disabled_rest}}
					placeholder="Enter Price" value="{{$hyper->owarehouse_price/100}}">
					<?php 
						$saveh = number_format((($product->private_retail_price - $hyper->owarehouse_price)/$product->private_retail_price)*100,2, '.', '');
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
					type="text" name="" class="form-control input-number" id="hyperprice" value="0.00" {{$disabled_rest}}
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

	<div class="clearfix"></div>
	<hr>
	<div class="col-sm-12">
	@if(!is_null($hyper))
			<div class="clearfix"></div>
				<h3>Delivery Coverage</h3>
					<div class="form-group">
						{!! Form::label('cov_country_id', 'Country', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9" >
							<select style="width: 100%;" data-style="btn-green" class="form-control" name="cov_country" id="country_id" disabled>
								<option value="150">Malaysia</option>
							</select>
						</div>
					</div>
				<input type="hidden" id="cov_country_id" name="cov_country_id" value="150">
				<div class="form-group">
					{!! Form::label('cov_state_id', 'State', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-9">
						<select style="width: 100%;" class="form-control" id="states_hyper" name="cov_state_id" data-style="btn-green" required>
						<option value="0">Choose Option</option>
							@foreach($states as $state)
								<?php
									$selected_state = "";
									if($state->id == $hyper->cov_state_id){
										$selected_state = "selected";
									}
								?>
								<option value="{{$state->id}}" {{$selected_state}}>{{$state->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('cov_city_id', 'City', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-9">
						<select style="width: 100%;" class="form-control" id="cities_hyper" name="cov_city_id" data-style="btn-green" required>
							<option value="0">Choose Option</option>
							@foreach($city as $cities)
								<?php
									$selected_city = "";
									if($cities->id == $hyper->cov_city_id){
										$selected_city = "selected";
									}
								?>
								<option value="{{$cities->id}}" {{$selected_city}}>{{$cities->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				 <div class="form-group">
					{!! Form::label('cov_area_id', 'Area', array('class' => 'col-sm-3 control-label')) !!}
					<div class="col-sm-9">
						<select style="width: 100%;" class="form-control" id="areas_hyper" name="cov_area_id" data-style="btn-green">
							<option value="0" selected>Choose Option</option>
							@foreach($areas as $area)
								<?php
									$selected_area = "";
									if($area->id == $hyper->cov_area_id){
										$selected_area = "selected";
									}
								?>
								<option value="{{$area->id}}" {{$selected_area}}>{{$area->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				
					<div class="clearfix"></div>
					<br>
				<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
					<div style='margin-bottom:5px' class="form-group">
						{!! Form::label('del_pricing','Pricing',
						array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-4">
						{!! Form::text('del_pricing',
						number_format($delivery_pricec/100,2, '.', ''),
						array('class' => 'form-control delivery_prices',
						'id' => 'del_pricing','disabled',
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
					<div class="clearfix"></div>
					<br>
					<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
						<div class="checkbox checkbox-success" style="margin-left:0;margin-top:10px">
						<?php
							$free_qty = 0;
							if($hyper->free_delivery_with_purchase_qty > 0){
								$free_qty = 1;
							}
							$isfree = 0;
							if($hyper->free_delivery > 0){
								$isfree = 1;
							}
						?>
							@if($isfree == 1)
								{!! Form::checkbox('free_delivery', 1, null, ['class' => 'styled','checked'=>'checked','id'=>'checkboxD_hyper']) !!}
							@else
								{!! Form::checkbox('free_delivery', 1, null, ['class' => 'styled','id'=>'checkboxD_hyper']) !!}
							@endif
							{!! Form::label('checkbox1', 'Free Delivery') !!}
						</div>				

						<div class="col-sm-7 checkbox checkbox-success" style="margin-left:0">
							@if($free_qty == 1)
								{!! Form::checkbox('free_delivery_qty', 1, null, ['class' => 'styled','checked'=>'checked','id'=>'checkboxDq_hyper']) !!}
							@else
								{!! Form::checkbox('free_delivery_qty', 1, null, ['class' => 'styled','id'=>'checkboxDq_hyper']) !!}
							@endif
							{!! Form::label('checkbox1', 'Free Delivery with purchase quantity of per location more than') !!}

						</div>
						<div class="col-sm-4" style="padding-right:0">
							{!! Form::text('free_delivery_with_purchase_qty', number_format(($hyper->free_delivery_with_purchase_qty/100),2, '.', ''),
								array('class' => 'form-control', 'disabled' => 'disabled','id'=>'checkboxDqn_hyper',
								'style'=>'margin-top:-10px;margin-left:-40px;width:60px;'))!!}
						</div>
					</div>	
	@else	
				<div id="own_delivery_hyper">
					<h3>Delivery Coverage</h3>
					<input type="hidden" id="cov_country_id" name="cov_country_id" value="150">
					<div class="form-group">
						{!! Form::label('cov_country_id', 'Country', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9" >
							<select style="width: 100%;" data-style="btn-green" class="form-control" name="cov_country" id="country_id" disabled>
								<option value="150">Malaysia</option>
							</select>
						</div>
					</div>
					<input type="hidden" id="cov_country_id" name="cov_country_id" value="150">
					<div class="form-group">
						{!! Form::label('cov_state_id', 'State', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="states_hyper" name="cov_state_id" data-style="btn-green">
							<option value="0" disabled="" selected="">Choose Option</option>
								@foreach($states as $state)
									<option value="{{$state->id}}">{{$state->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('cov_city_id', 'City', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="cities_hyper" name="cov_city_id" data-style="btn-green">
								<option value="0" disabled="" selected="">Choose Option</option>
							</select>
						</div>
					</div>
					 <div class="form-group">
						{!! Form::label('cov_area_id', 'Area', array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-9">
							<select style="width: 100%;" class="form-control" id="areas_hyper" name="cov_area_id" >
								<option value="0" selected  disabled="" selected="">Choose Option</option>
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
					<br>
				<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
					<div style='margin-bottom:5px' class="form-group">
						{!! Form::label('del_pricing','Pricing',
						array('class' => 'col-sm-3 control-label')) !!}
						<div class="col-sm-4">
						{!! Form::text('del_pricing',
						number_format($delivery_pricec/100,2, '.', ''),
						array('class' => 'form-control delivery_prices',
						'id' => 'del_pricing','disabled',
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
						<div class="clearfix"></div>
						<br>
						<div style="border: solid 1px #DDD; padding: 5px; height: 90px;">
					<div class="checkbox checkbox-success" style="margin-left:0;margin-top:10px">
						{!! Form::checkbox('free_delivery', 1, null, ['class' => 'styled','id'=>'checkboxD_hyper']) !!}
						{!! Form::label('checkbox1', 'Free Delivery') !!}
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-7 checkbox checkbox-success" style="margin-left:0">
						{!! Form::checkbox('free_delivery_qty', 1, null, ['class' => 'styled','id'=>'checkboxDq_hyper']) !!}
						{!! Form::label('checkbox1', 'Free Delivery with purchase quantity of per location more than') !!}

					</div>
					<div class="col-sm-2" style="padding-right:0">
						{!! Form::text('free_delivery_with_purchase_qty', '0',
							array('class' => 'form-control',
							'disabled' => 'disabled','id'=>'checkboxDqn_hyper', 'required',
							'style'=>'margin-top:2px;margin-left:0;width:60px;'))!!}
					</div>		
					</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
	@endif
	</div>
	<br>
	{!! Form::label('terms', 'Terms & Conditions', array('class' => 'col-sm-12 control-label', 'style' => 'margin-top:15px;')) !!}
	<div class="col-sm-12">
		<div class="input-group">
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
	</div>

	<div class="col-sm-12">
		<p align="center">
		<button type="button" id="close_hyper" class="btn btn-primary">Cancel</button>&nbsp;&nbsp;&nbsp
		@if(!is_null($hyper))
		<?php 
			$disabled_btn = "";
			if($hyper->owarehouse_price == 0){
				$disabled_btn = "disabled";
			}
		?>
		<button type="button" id="update_hyper" class="btn btn-primary {{$disabled_btn}}">Go Hyper!</button>
		<button type="button" id="add_hyper" style="display:none;" title='To publish this product and be visible to the public, please tick "O" column and click on "Update for Public" button' class="btn btn-primary">Go Hyper!</button>		
		@else
		<button type="button" id="add_hyper" title='To publish this product and be visible to the public, please tick "O" column and click on "Update for Public" button' class="btn btn-primary">Go Hyper!</button>
		@endif
		</p>
	</div>
	<input type="hidden" id="parent_id" value="{{$product->id}}" />
	<input type="hidden" id="retail_priceh" value="{{$product->private_retail_price/100}}" />
	@if(!is_null($hyper))
		<input type="hidden" id="hyper_id" value="{{$hyper->id}}" />
		@if(!is_null($owarehouse))
			<input type="hidden" id="owarehouse_id" value="{{$owarehouse->id}}" />
		@else
			<input type="hidden" id="owarehouse_id" value="0" />
		@endif	
	@else
		<input type="hidden" id="hyper_id" value="0" />
		<input type="hidden" id="owarehouse_id" value="0" />
	@endif
</div>
@else 
	<h3 align="center">You cannot create Hyper to an Inactive Product.</h3>
@endif
<script type="text/javascript">
/*$(document).ready(function(){

});*/
</script>
