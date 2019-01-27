@extends('common.default')
@section('content')

<section>
	<div class="container"><!--Begin main cotainer-->
		<div class="row">
			<legend><h2>MLM Commissions</h2></legend>
			<div class="col-md-8">
				@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
							{!! $error !!}<br/>
						@endforeach
					</div>
				@elseif(Session::has('success'))
					<div class="alert alert-success">
						Value Successfully Inserted.
					</div>
				@endif

<!--Foem start-->
				{!! Form::open(array('method'=>'POST','url'=>'/mlmCommissions/save','class'=>'form-horizontal')) !!}

				<!-- hidden field to hold mlmcomm.id for edit purpose -->
					{!! Form::text("mlmcomm_id", Input::old('mlmcomm_id',false), array('id'=>"mlmcomm_id")) !!}

<!--A. Commissions Structure -->

				<h3>A. Commissions Structure</h3>
				<div class="row">
					<div class="form-group">
						<div class="col-md-3" style="text-align:right">
							{!! Form::label("sales_amount", "Sales Amount:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("sales_amount", Input::old('sales_amount',false), array('class'=>' col-sm-6 form-control', 'id'=>'sales_amount', 'onChange'=>'blur_triger(this)')) !!}
						</div>
					</div><!-- form-group end-->
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-md-3" style="text-align:right">
							{!! Form::label("clan_def", "Clan Definition:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("clan_def", Input::old('clan_def',false), array('class'=>'form-control', 'id'=>'clan_def', 'onChange'=>'blur_triger(this)')) !!}
						</div>
						<span class="col-md-1">
							members
						</span>
					</div><!-- form-group end -->
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-md-3" style="text-align:right">
							{!! Form::label("family_def", "Family Definition:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("family_def", Input::old('family_def',false), array('class'=>' col-sm-6 form-control', 'id'=>'family_def', 'onChange'=>'blur_triger(this)')) !!}
						</div>
						<span class="col-md-1">
							members
						</span>
					</div><!-- form-group end -->
				</div>


 <!--B. G1 Super Clan Bonus -->
			 <h3>B. G1 Super Clan Bonus</h3>
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
								{!! Form::label("scBonus_sales", "Super Clan Bonus:") !!}
							</div>
							<div class="col-md-2">
							 {!! Form::text("scBonus_sales", Input::old('scBonus_sales',false), array('class'=>'form-control', 'id'=>'scBonus_sales', 'onChange'=>'blur_triger(this)')) !!}
						  </div>
					    <span class="col-md-1">
							 /sales,
						  </span>
						  <div class="col-md-1" style="text-align:right">
							 {!! Form::label("scBonus_amount", " MYR:") !!}
						  </div>
						  <div class="col-md-2">
							 {!! Form::text("scBonus_amount", Input::old('scBonus_amount',false), array('class'=>'form-control', 'id'=>'scBonus_amount', 'onChange'=>'blur_triger(this)')) !!}
						 </div>
					 </div>
					</div><!-- form-group end -->

<!--G1: Personal Terget -->
					<h4 style="text-align:left"><b>Personal Terget</b></h4>
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("pers_comm_1", "Personal Commission	MYR:") !!}
						  </div>
							<div class="col-md-2">
							 {!! Form::text("pers_comm_1", Input::old('pers_comm_1',false), array('class'=>'form-control', 'id'=>'pers_comm_1', 'onChange'=>'blur_triger(this)')) !!}
						  </div>
						  <span class="col-md-1">
							 /sales,
						  </span>
							<div class="col-md-1">
							 {!! Form::label("pers_comm_perce_1", "	MYR:") !!}
						  </div>
						  <div class="col-md-2">
								<!-- pers_comm_perce_1 -->
							 {!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'pers_comm_perce_1', 'readonly')) !!}
						  </div>
						</div>
					</div><!-- form-group end -->

<!-- G1: Clan Achived -->
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("cachv_1", "Clan Achieved	MYR:") !!}
						  </div>
						  <div class="col-md-2">
							 {!! Form::text("cachv_1", Input::old('cachv_1',false), array('class'=>'form-control', 'id'=>'cachv_1', 'onChange'=>'blur_triger(this)')) !!}
						  </div>
					 </div>
					</div><!-- form-group end -->

<!-- G1: Clan Achived -> Group Bonus -->
					<div class="row">
						<div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("cachv_gbonus_1", "Group Bonus:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("cachv_gbonus_1", Input::old('cachv_gbonus_1',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_1', 'onChange'=>'blur_triger(this)')) !!}
						 </div>
						 <span class="col-md-1">
							/sales,
						 </span>
						 <div class="col-md-1">
							{!! Form::label("cachv_gbonus_amount_1", "	MYR:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_amount_1', 'readonly')) !!}
						 </div>
						 <span class="col-md-1">
							,
						 </span>
						 <div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_perce_1', 'readonly')) !!}
						 </div>
						</div>
					</div><!-- form-group end -->

<!-- G1: Clan Not Achived -->
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("cnot_achv_1", "Clan Not Achieved	MYR:") !!}
						  </div>
						  <div class="col-md-2">
							{!! Form::text("cnot_achv_1", Input::old('cnot_achv_1',false), array('class'=>'form-control', 'id'=>'cnot_achv_1', 'onChange'=>'blur_triger(this)')) !!}
						</div>
					 </div>
					</div><!-- form-group end -->

<!-- G1: Clan Not Achived -> Group Bonus -->
					<div class="row">
					 <div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("cnot_achv_gbonus_1", "Group Bonus:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("cnot_achv_gbonus_1", Input::old('cnot_achv_gbonus_1',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_1', 'onChange'=>'blur_triger(this)')) !!}
						</div>
						<span class="col-md-1">
							/sales,
						</span>
						<div class="col-md-1">
							{!! Form::label("cnot_achv_gbonus_amount_1", "	MYR:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_amount_1', 'readonly')) !!}
						</div>
						<span class="col-md-1">
							,
						</span>
						<div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_perce_1', 'readonly')) !!}
						</div>
					 </div>
					</div><!-- form-group end -->

<!--G1: Recent Downline Family -->
					<h4 style="text-align:left"><b>Recent Downline Family</b></h4>
					<div class="row">
						<div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("recruit_ovr_1", "Overriding	MYR:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("recruit_ovr_1", Input::old('recruit_ovr_1',false), array('class'=>'form-control', 'id'=>'recruit_ovr_1', 'onChange'=>'blur_triger(this)')) !!}
						 </div>
						 <span class="col-md-2">
							/Member, /sale,
						 </span>
						 <div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'recruit_ovr_perce_1', 'readonly')) !!}
						</div>
					</div>
				</div>

	<!-- G1: New Family			 -->
					<h4 style="text-align:left"><b>New Family Bonus</b></h4>
					<div class="row">
						<div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("newfamily_ovr_1", "Overriding	MYR:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("newfamily_ovr_1", Input::old('newfamily_ovr_1',false), array('class'=>'form-control', 'id'=>'newfamily_ovr_1', 'onChange'=>'blur_triger(this)')) !!}
						</div>
						<span class="col-md-2">
							,
						</span>
						<div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'newfamily_ovr_perce_1', 'readonly')) !!}
						</div>
					</div>
				 </div>

<!--G2 start-->

			 <h3>C. G2</h3>
<!--G1: Personal Terget -->
					<h4 style="text-align:left"><b>Personal Terget</b></h4>
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("pers_comm_2", "Personal Commission	MYR:") !!}
						  </div>
							<div class="col-md-2">
							 {!! Form::text("pers_comm_2", Input::old('pers_comm_2',false), array('class'=>'form-control', 'id'=>'pers_comm_2', 'onChange'=>'blur_triger(this)')) !!}
						  </div>
						  <span class="col-md-1">
							 /sales,
						  </span>
							<div class="col-md-1">
							 {!! Form::label("pers_comm_perce_2", "	MYR:") !!}
						  </div>
						  <div class="col-md-2">
							 {!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'pers_comm_perce_2', 'readonly')) !!}
						  </div>
						</div>
					</div><!-- form-group end -->

<!-- G2: Clan Achived -->
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("cachv_2", "Clan Achieved	MYR:") !!}
						  </div>
						  <div class="col-md-2">
							 {!! Form::text("cachv_2", Input::old('cachv_2',false), array('class'=>'form-control', 'id'=>'cachv_2', 'onChange'=>'blur_triger(this)')) !!}
						  </div>
					 </div>
					</div><!-- form-group end -->

<!-- G2: Clan Achived -> Group Bonus -->
					<div class="row">
						<div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("cachv_gbonus_2", "Group Bonus:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("cachv_gbonus_2", Input::old('cachv_gbonus_2',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_2', 'onChange'=>'blur_triger(this)')) !!}
						 </div>
						 <span class="col-md-1">
							/sales,
						 </span>
						 <div class="col-md-1">
							{!! Form::label("cachv_gbonus_amount_2", "	MYR:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_amount_2', 'readonly')) !!}
						 </div>
						 <span class="col-md-1">
							,
						 </span>
						 <div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_perce_2', 'readonly')) !!}
						 </div>
						</div>
					</div><!-- form-group end -->

<!-- G2: Clan Not Achived -->
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("cnot_achv_2", "Clan Not Achieved	MYR:") !!}
						  </div>
						  <div class="col-md-2">
							{!! Form::text("cnot_achv_2", Input::old('cnot_achv_2',false), array('class'=>'form-control', 'id'=>'cnot_achv_2', 'onChange'=>'blur_triger(this)')) !!}
						</div>
					 </div>
					</div><!-- form-group end -->

<!-- G2: Clan Not Achived -> Group Bonus -->
					<div class="row">
					 <div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("cnot_achv__gbonus_2", "Group Bonus:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("cnot_achv_gbonus_2", Input::old('cnot_achv_gbonus_2',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_2', 'onChange'=>'blur_triger(this)')) !!}
						</div>
						<span class="col-md-1">
							/sales,
						</span>
						<div class="col-md-1">
							{!! Form::label("cnot_achv_gbonus_amount_2", "	MYR:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_amount_2', 'readonly')) !!}
						</div>
						<span class="col-md-1">
							,
						</span>
						<div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_perce_2', 'readonly')) !!}
						</div>
					 </div>
					</div><!-- form-group end -->

<!--G2: Recent Downline Family -->
					<h4 style="text-align:left"><b>Recent Downline Family</b></h4>
					<div class="row">
						<div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("recruit_ovr_2", "Overriding	MYR:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("recruit_ovr_2", Input::old('recruit_ovr_2',false), array('class'=>'form-control', 'id'=>'recruit_ovr_2', 'onChange'=>'blur_triger(this)')) !!}
						 </div>
						 <span class="col-md-2">
							/Member, /sale,
						 </span>
						 <div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'recruit_ovr_perce_2', 'readonly')) !!}
						</div>
					</div>
				</div>

	<!-- G2: New Family			 -->
					<h4 style="text-align:left"><b>New Family Bonus</b></h4>
					<div class="row">
						<div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("newfamily_ovr_2", "Overriding	MYR:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("newfamily_ovr_2", Input::old('newfamily_ovr_2',false), array('class'=>'form-control', 'id'=>'newfamily_ovr_2', 'onChange'=>'blur_triger(this)')) !!}
						</div>
						<span class="col-md-2">
							,
						</span>
						<div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'newfamily_ovr_perce_2', 'readonly')) !!}
						</div>
					</div>
				 </div>

<!--D. G3 start-->
					<h3>D. G3</h3>
<!--G3: Personal Terget -->
					<h4 style="text-align:left"><b>Personal Terget</b></h4>
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("pers_comm_3", "Personal Commission	MYR:") !!}
						  </div>
							<div class="col-md-2">
							 {!! Form::text("pers_comm_3", Input::old('pers_comm_3',false), array('class'=>'form-control', 'id'=>'pers_comm_3', 'onChange'=>'blur_triger(this)')) !!}
						  </div>
						  <span class="col-md-1">
							 /sales,
						  </span>
							<div class="col-md-1">
							 {!! Form::label("pers_comm_perce_3", "	MYR:") !!}
						  </div>
						  <div class="col-md-2">
							 {!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'pers_comm_perce_3', 'readonly')) !!}
						  </div>
						</div>
					</div><!-- form-group end -->

<!-- G3: Clan Achived -->
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("cachv_3", "Clan Achieved	MYR:") !!}
						  </div>
						  <div class="col-md-2">
							 {!! Form::text("cachv_3", Input::old('cachv_3',false), array('class'=>'form-control', 'id'=>'cachv_3', 'onChange'=>'blur_triger(this)')) !!}
						  </div>
					 </div>
					</div><!-- form-group end -->

<!-- G3: Clan Achived -> Group Bonus -->
					<div class="row">
						<div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("cachv_gbonus_3", "Group Bonus:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("cachv_gbonus_3", Input::old('cachv_gbonus_3',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_3', 'onChange'=>'blur_triger(this)')) !!}
						 </div>
						 <span class="col-md-1">
							/sales,
						 </span>
						 <div class="col-md-1">
							{!! Form::label("cachv_gbonus_amount_3", "	MYR:") !!}
						 </div>
						 <div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_amount_3', 'readonly')) !!}
						 </div>
						 <span class="col-md-1">
							,
						 </span>
						 <div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cachv_gbonus_perce_3', 'readonly')) !!}
						 </div>
						</div>
					</div><!-- form-group end -->

<!-- G3: Clan Not Achived  -->
					<div class="row">
						<div class="form-group">
							<div class="col-md-3" style="text-align:right">
							 {!! Form::label("cnot_achv_3", "Clan Not Achieved	MYR:") !!}
						  </div>
						  <div class="col-md-2">
							{!! Form::text("cnot_achv_3", Input::old('cnot_achv_3',false), array('class'=>'form-control', 'id'=>'cnot_achv_3', 'onChange'=>'blur_triger(this)')) !!}
						</div>
					 </div>
					</div><!-- form-group end -->

<!-- G3: Clan Not Achived -> Group Bonus -->
					<div class="row">
					 <div class="form-group">
						 <div class="col-md-3" style="text-align:right">
							{!! Form::label("cnot_achv__gbonus_3", "Group Bonus:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("cnot_achv_gbonus_3", Input::old('cnot_achv_gbonus_3',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_3', 'onChange'=>'blur_triger(this)')) !!}
						</div>
						<span class="col-md-1">
							/sales,
						</span>
						<div class="col-md-1">
							{!! Form::label("cnot_achv_gbonus_amount_3", "	MYR:") !!}
						</div>
						<div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_amount_3', 'readonly')) !!}
						</div>
						<span class="col-md-1">
							,
						</span>
						<div class="col-md-2">
							{!! Form::text("", Input::old('',false), array('class'=>'form-control', 'id'=>'cnot_achv_gbonus_perce_3', 'readonly')) !!}
						</div>
					 </div>
					</div><!-- form-group end -->
					<hr />
					<div class="form-group" style="float:right">
						{!! Form::submit("Save", array('class'=>'btn btn-primary')) !!}
					</div><!-- form-group end -->
				{!! Form::close() !!}
			</div><!--Col-6-->
		</div><!--row-->
	</div><!-- container end -->


<!-- temp test var. delete after testing -zaki -->
<?php print'<pre>'; if(isset($tmp)){print_r($tmp);} print"</pre>"; ?>

</section><!-- section end -->

<script>

// This function trigers two events on Blur
	function blur_triger($value){

	 	ajax_save_data($value.id, $value.value);
		calculate();
	}


// This function sends data via ajax
	function ajax_save_data($field, $field_value){

						let myUrl = "/mlmCommissions/ajax/save";
						let lmlcomm_id = $("input[name=mlmcomm_id]").val();

						if($field_value  == null || $field_value ==""){
							$field_value = 'null';
						}

						if(lmlcomm_id == null || lmlcomm_id == ""){
							lmlcomm_id = 'null';
						}

						$.ajax({
								url :JS_BASE_URL + myUrl,
								type : "post",
								contentType: "application/json",
								dataType : 'json',
								data: {'mlmcomm_id':lmlcomm_id,
											 'field':$field,
											 'field_value':$field_value
											 // "_token": "{{ csrf_token() }}"
										 	},
								cache: false,
								success: function(data){
											console.log("AJAX success request: " + JSON.stringify(data));
										},
								error: function(data){
											console.log("AJAX error in request: " + JSON.stringify(data, null, 2));

										}
						});
	}



//This function calcultes the form data and display them
	function calculate(){
// Calculate G1
			// Personal Commission Percentage
			let calculate1 = ($('#pers_comm_1').val())/($('#sales_amount').val())*100;
			$('#pers_comm_perce_1').val(calculate1.toPrecision(4) +"%");
			// Clan Achived Group Bonus Amount
			let calculate2 = ($('#cachv_1').val())*($('#cachv_gbonus_1').val());
			$('#cachv_gbonus_amount_1').val(calculate2);
			// Clan Achived Group Bonus Percentage
			let calculate3 = $('#cachv_gbonus_amount_1').val()/(($('#cachv_gbonus_1').val())*($('#sales_amount').val()))*100;
			$('#cachv_gbonus_perce_1').val(calculate3.toPrecision(4) +"%");
			// Clan Not Achived Group Bonus Amount
			let calculate4 = ($('#cnot_achv_1').val())*($('#cnot_achv_gbonus_1').val());
			$('#cnot_achv_gbonus_amount_1').val(calculate4);
			// Clan Not Achived Group Bonus Percentage
			let calculate5 = $('#cnot_achv_gbonus_amount_1').val()/(($('#cnot_achv_gbonus_1').val())*($('#sales_amount').val()))*100;
			$('#cnot_achv_gbonus_perce_1').val(calculate5.toPrecision(4) +"%");
			// Downline Family Overriding Percentage
			let calculate6 = ($('#recruit_ovr_1').val())/($('#sales_amount').val())*100;
			$('#recruit_ovr_perce_1').val(calculate6.toPrecision(4) +"%");
			// New Family Overriding Percentage
			let calculate7 = ($('#newfamily_ovr_1').val())/($('#sales_amount').val())*100;
			$('#newfamily_ovr_perce_1').val(calculate7.toPrecision(4) +"%");

	// Calculate G2
			// Personal Commission Percentage
			let calculate8 = ($('#pers_comm_2').val())/($('#sales_amount').val())*100;
			$('#pers_comm_perce_2').val(calculate8.toPrecision(4) +"%");
			// Clan Achived Group Bonus Amount
			let calculate9 = ($('#cachv_2').val())*($('#cachv_gbonus_2').val());
			$('#cachv_gbonus_amount_2').val(calculate9);
			// Clan Achived Group Bonus Percentage
			let calculate10 = $('#cachv_gbonus_amount_2').val()/(($('#cachv_gbonus_2').val())*($('#sales_amount').val()))*100;
			$('#cachv_gbonus_perce_2').val(calculate10.toPrecision(4) +"%");
			// Clan Not Achived Group Bonus Amount
			let calculate11 = ($('#cnot_achv_2').val())*($('#cnot_achv_gbonus_2').val());
			$('#cnot_achv_gbonus_amount_2').val(calculate11);
			// Clan Not Achived Group Bonus Percentage
			let calculate12 = $('#cnot_achv_gbonus_amount_2').val()/(($('#cnot_achv_gbonus_2').val())*($('#sales_amount').val()))*100;
			$('#cnot_achv_gbonus_perce_2').val(calculate12.toPrecision(4) +"%");
			// Downline Family Overriding Percentage
			let calculate13 = ($('#recruit_ovr_2').val())/($('#sales_amount').val())*100;
			$('#recruit_ovr_perce_2').val(calculate13.toPrecision(4) +"%");
			// New Family Overriding Percentage
			let calculate14 = ($('#newfamily_ovr_2').val())/($('#sales_amount').val())*100;
			$('#newfamily_ovr_perce_2').val(calculate14.toPrecision(4) +"%");

	// Calculate G3
			// Personal Commission Percentage
			let calculate15 = ($('#pers_comm_3').val())/($('#sales_amount').val())*100;
			$('#pers_comm_perce_3').val(calculate15.toPrecision(4) +"%");
			// Clan Achived Group Bonus Amount
			let calculate16 = ($('#cachv_3').val())*($('#cachv_gbonus_3').val());
			$('#cachv_gbonus_amount_3').val(calculate16);
			// Clan Achived Group Bonus Percentage
			let calculate17 = $('#cachv_gbonus_amount_3').val()/(($('#cachv_gbonus_3').val())*($('#sales_amount').val()))*100;
			$('#cachv_gbonus_perce_3').val(calculate17.toPrecision(4) +"%");
			// Clan Not Achived Group Bonus Amount
			let calculate18 = ($('#cnot_achv_3').val())*($('#cnot_achv_gbonus_3').val());
			$('#cnot_achv_gbonus_amount_3').val(calculate18);
			// Clan Not Achived Group Bonus Percentage
			let calculate19 = $('#cnot_achv_gbonus_amount_3').val()/(($('#cnot_achv_gbonus_3').val())*($('#sales_amount').val()))*100;
			$('#cnot_achv_gbonus_perce_3').val(calculate19.toPrecision(4) +"%");
	}

</script>

@stop
