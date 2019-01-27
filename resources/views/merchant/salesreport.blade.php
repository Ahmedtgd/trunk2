@extends("common.default")

@section("content")
@include("common.sellermenu")


<style>
.dataTables_filter input {
	width:300px;
}

</style>

<div class="container" id="sales-analysis" style="margin-top:0;">   
	<input type="hidden" id="merchant_id" value="{{$merchant_id}}" />    


    <div class="row">
        <div class="col-sm-12">
			<div
				style="margin-bottom:0"
				class="panel with-nav-tabs panel-default" id="TabId">
				<div class="panel-heading">
					<h2 style="margin-top:10px">Sales Analytics</h2>
                    <ul class="nav nav-tabs">
                        <li class="active" id="tb-online-product">
						<a href="#online-detail" data-toggle="tab"
							style="margin-left: -15px; margin-right: 0px;">
							Online</a></li>
                        <li id="tb-opossum-detail"><a href="#opossum-detail"
							style="margin-left:0;margin-right:0;padding-left:10px;
								padding-right: 10px;"
							data-toggle="tab">Cash Sales</a></li>
						<li id="tb-credit-detail"><a href="#credit-detail"
							style="margin-left:0;margin-right:0;padding-left:10px;
								padding-right: 10px;"
							data-toggle="tab">Credit Sales</a></li>
 						<li id="tb-stock-detail"><a href="#stock-detail"
							style="margin-left:0;margin-right:0;padding-left:10px;
								padding-right: 10px;"
							data-toggle="tab">Stock Level</a></li> 
 						<li id="tb-qty-detail"><a href="#qty-detail"
							style="margin-left:0;margin-right:0;padding-left:10px;
								padding-right: 10px;"
							data-toggle="tab">Stock Out</a></li> 
					</ul>
					</ul>
				</div>
			</div>
        </div>
    </div>
	<div class="margin-top">
	 	<div class="tab-content">

  	 		<div id="stock-detail" class="tab-pane fade">
				<div class="col-md-12"
					style="padding-left:0;padding-right:0;margin-bottom:15px;">
                    @include("merchant.stocklevel")
				</div>
			</div> 

 	 		<div id="credit-detail" class="tab-pane fade">
	 			<div class="col-md-12" style="padding-left:0;margin-bottom:15px;">
				@include("merchant.creditsales")
				</div>
			</div> 

  	 		<div id="qty-detail" class="tab-pane fade">
	 			<div class="col-md-12"
					style="padding-right:0;padding-left:0;margin-bottom:15px;">
				@include("merchant.stockout")
				</div>
			</div> 
 
	 		<div id="opossum-detail" class="tab-pane fade">
	 			<div class="col-md-12" style="padding-left:0;margin-bottom:25px;">
					<h3>Cash Sales Details</h3>
					<div class="col-md-6"
						style="margin-top:10px;padding-left:0;padding-right:0">
						<a target="_blank" type="button"
						class="btn btn-info sellerbutton2" id="psales"
						href="/merchant/productsales">Product</br>Sales
						</a>

						<a target="_blank" type="button"
						class="btn btn-info sellerbutton2 staffSales"
						href="/merchant/cashsales">Cashier</br>Sales</a>

						<a target="_blank" type="button"
						class="btn btn-info sellerbutton2 commsales"
						href="/merchant/staffsales">Staff</br>Sales</a>
					</div>
				</div>
			</div>
			<div id="online-detail" class='tab-pane fade in active'>
				<!--<div class="col-md-12" id="label" >
						<div class='col-md-3'>
							<label>Consumer</label>
						</div>
					</div>
					<div class="col-md-12" id="consumers-main-container" >
						<div class='col-md-6 consumer-merchant-select-container'>
							{!! Form::select('consumer', array('' => 'Select...','merchant'=>'Merchant','station'=>'Station','buyer'=>'Buyer'), null, ['class' => 'consumer-merchant-field col-md-12']) !!}
						</div>		
					</div>	 -->


				<div class="col-md-12" id="label"
					style="margin-top:0;padding-left:0;margin-bottom:0">
					<h3>Online Sales Details</h3>

					<div class='col-md-3' style="padding-left:0">
						<label>Country</label>
					</div>
					<div class='col-md-3'>
						<label>State</label>
					</div>
					<div class='col-md-3'>
						<label>City</label>
					</div>
					<div class='col-md-3'>
						<label>Area</label>
					</div>
				</div>
				<div style="padding-left:0" class="col-md-12" id="countries-main-container" >
					<div style="padding-left:0" class='col-md-3 countries-merchant-select-container'>
						{!! Form::select('country', array('' => 'Select...') + $data['countries'], null, ['class' => 'country-merchant-field col-md-12']) !!}
					</div>
					<div class='col-md-3 state-merchant-select-container'>
						{!! Form::select('state', array(), null, ['class' => 'state-merchant-field col-md-12']) !!}
					</div>
					<div class='col-md-3 city-merchant-select-container'>
						{!! Form::select('city', array(), null, ['class' => 'city-merchant-field col-md-12']) !!}
					</div>
					<div class='col-md-3 area-merchant-select-container'>
						{!! Form::select('area', array(), null, ['class' => 'area-merchant-field col-md-12']) !!}
					</div>			
				</div>
				<div class="col-md-12" id="label" style="margin-top: 15px;padding-left:0">
					<div style="padding-left:0" class='col-md-3'>
						<label>Category</label>
					</div>
					<div class='col-md-3'>
						<label>SubCategory</label>
					</div>
					<div class='col-md-3'>
						<label>Brand</label>
					</div>

					<div class='col-md-3'>
						<label>Product</label>
					</div>
				</div>

				<div style="padding-left:0" class="col-md-12" id="field-main-container" >

					<div style="padding-left:0" class='col-md-3 category-merchant-select-container'>
						{!! Form::select('category', array('' => 'Select...') + $data['categories'], null, ['class' => 'category-merchant-field col-md-12']) !!}
					</div>
					<div class='col-md-3 area-merchant-select-container'>
						{!! Form::select('subcategory', array(), null, ['class' => 'subcategory-merchant-field col-md-12']) !!}
					</div>	
					<div class='col-md-3 brand-merchant-select-container'>
						{!! Form::select('brand', array('' => 'Select...') + $data['brands'], null, ['class' => 'brand-merchant-field col-md-12']) !!}
					</div>			
					<div class='col-md-3 product-merchant-select-container'>
						{!! Form::select('product', array(), null, ['class' => 'product-merchant-field col-md-12']) !!}
					</div>			
				</div>

				<div style="padding-left:0;margin-top:15px" class="col-md-12" id="label" style="margin-top: 15px;">
					<div style="padding-left:0" class='col-md-3'>		  
						<label>Channel</label>
					</div>
				</div>

				<div style="padding-left:0" class="col-md-12" id="channels-main-container" >
				
					<div style="padding-left:0" class='col-md-3 channel-merchant-select-container'>
						<select name="Statuses" class = "channel-merchant-field col-md-12">
						<option value="">Select</option>
						<option value="all2loc">All Locations</option>
						<option value="overall2sales">Overall Sales</option>
						<option value="b2c">Online Retail</option>
						<option value="b2b">Online B2B</option>
						<option value="hyper">Online Hyper</option>
						<option value="smm">Online SMM</option>
						<option value="openwish">Online OpenWish</option>
						@foreach ($channel as $value)
						<option value="{{ $value->id }}">{{ $value->location }}</option>
						@endforeach
						</select>
					</div>
					<!--<div class='col-md-6 channel-merchant-select-container'>
						{!! Form::select('channel', array('' => 'Select...','b2c'=>'Retail','b2b'=>'B2B','hyper'=>'Hyper','smm'=>'SMM','openwish'=>'OpenWish'), null, ['class' => 'channel-merchant-field col-md-12']) !!}
					</div>-->
				</div>	
					<!--<div class='col-md-6 channel-merchant-select-container'>
						{!! Form::select('channel', array(
						'' => 'Select...',
						'b2c'=>'Online Retail',
						'b2b'=>'Online B2B',
						'hyper'=>'Online Hyper',
						'smm'=>'Online SMM',
						'openwish'=>'Online OpenWish'), null,
						['class' => 'channel-merchant-field col-md-12'])
						!!}
					</div>-->		
				<!-- <div  class='col-md-6'>
					<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Product Sales</button>
					<button type="button" class="btn btn-info btn-lg">Staff Sales</button>
				</div>	 -->		
			
	
				<script>
					var chart;
					var xaxis_categories = new Array();
					var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
					var index = 0;
					for(var k = 10; k < 30;k++){
						for(var aa = 0; aa < 12; aa++){
							xaxis_categories[index] = months[aa] + " " + k;
							index++;
						}
					}
					
					//console.log(xaxis_categories);
					$(document).ready(function() {


					chart = new Highcharts.Chart({
							chart: {
							   renderTo: 'container',
							 // type: 'bar' // change this to column if want to show the column chart
							},
							title: {
								text: 'Merchant Sales Report',
								x: -20 //center
							},
							subtitle: {
								text: '',
								x: -20
							},
							xAxis: {
								
								categories: xaxis_categories,

							/*	labels: {
									formatter: function () {
										return 
											this.value;
									}
								}*/
							},
							yAxis: {
								title: {
									text: 'Revenue'
								},
								min:0,
								plotLines: [{
									value: 0,
									width: 1,
									color: '#718DA3'
								}]
							},
							tooltip: {
								valueSuffix: '',
								formatter: function() {
									return "{{$currentCurrency}} " + this.point.y;
								}
							},
							legend: {
								layout: 'vertical',
								align: 'right',
								verticalAlign: 'middle',
								borderWidth: 0
							},
							series:[{
								//showInLegend: false,
								   name: 'Sales',
								   data: [],
								   dataLabels: {
									enabled: true,
									}
								}],
							exporting: {
								enabled: false
							}

						});
					});
				</script>
				<div class='col-md-12' id="container"
				style="padding-left:0;min-width: 310px; height: 400px;
				margin: 0 auto"></div>
				<div style="margin-top:15px" class="col-md-12">
				
					<?php  $date = date("Y-m-d"); ?>
					<?php  $dateytd = date("Y") . "-01-01"; ?>
					<?php  $datemtd = date("Y-m") . "-01"; ?>

					<?php $date1 = date("Y-m-d"); 
					$datewtd =  date('Y-m-d', strtotime('-1 week', strtotime($date1))); ?>
					<?php  $datedaily = $datedaily = date("Y-m-d"); ?>
					<?php  $datehourly = date('Y-m-d H:i:s', strtotime('-1 hour')); ?>
					
					<div class="col-md-1">
						<a href="javascript:void(0)" class="btn btn-info since_ytd sellerbutton1" id="graph-merchant-since" from="<?php echo $since; ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="since">Since</a>
					</div>
					<div class="col-md-1">
						<a href="javascript:void(0)" class="btn btn-info ytd_btn sellerbutton1" id="graph-merchant-ytd" from="<?php echo date("d-M-Y", strtotime($dateytd)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="ytd">YTD</a>
					</div>
					<div class="col-md-1">
						<a href="javascript:void(0)" class="btn btn-info mtd_btn sellerbutton1" id="graph-merchant-mtd" from="<?php echo date("d-M-Y", strtotime($datemtd)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="mtd">MTD</a>
					</div>
					<div class="col-md-1">
						<a href="javascript:void(0)" class="btn btn-info wtd_btn sellerbutton1" id="graph-merchant-wtd" from="<?php echo date("d-M-Y", strtotime($datewtd)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="wtd">WTD</a>
					</div>
					<div class="col-md-1">
						<a href="javascript:void(0)" class="btn btn-info daily_btn sellerbutton1" id="graph-merchant-daily" from="<?php echo date("d-M-Y", strtotime($datedaily)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="daily">Today</a>
					</div>
					
					<div class="col-md-3">
						&nbsp;
					</div>
					<!-- <div class="col-md-1" style="">
						<a type="button" class="btn btn-info sellerbutton2"
						style=""
						data-toggle="modal" id="psales"
						data-target="#skumodel">Product</br>Sales</a>
				   </div>	
					<div class="col-md-1" style="">
						<a type="button" class="btn btn-info sellerbutton2 staffSales"
						style=""
						data-toggle="modal"
						data-target="#staffSales1">Staff</br>Sales</a>
					</div>	 -->		
				</div>	
				<div class="col-md-12 sales-analysis-graph-info">
					<table class="table table-bordered col-md-12">
						<tr>
							<td>Custom Date Range</td>
							<td>
								<label>From</label>
								<?php  $date = date("Y-m-d"); ?>
								<input type='text' id="from_date" class='pull-right datepicker' value="<?php echo date("d-M-Y",strtotime('-1 year',  strtotime($date))); ?>"/>
							</td>
							<td>
								<label>To</label>
								<input type='text' id="to_date" class='pull-right datepicker' value="<?php echo date("d-M-Y", strtotime($date)); ?>"/>
							</td>
							<td>
								<button type="button" style="width: 100% !important;" class="btn btn-success" id="graph-search-merchant">Search</button>
							</td>
						</tr>
					</table>
					<div class="col-md-2">

					</div>
					<div class="col-md-12">
						<table class="table table-condensed table-hover table-responsive table-striped " id="each-month-max-min-table">
							<tbody>

							</tbody>
						</table>
					</div>
				</div>		

			</div>
		</div>
	</div>
	<div class="modal fade" id="skumodel" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog modal-lg " role="document">

			<div class="modal-content modal-content-sku">
	            <div class="modal-header" style="margin-bottom:25px;padding-bottom:10px">
	                <button type="button" class="close" data-dismiss="modal">
						&times;</button>
					<h3 class="modal-title"
						style="margin-bottom:0"
						id="myModalLabel">
						Product Sales</h3>
					<a href="javascript:void(0)"
						class="btn btn-info since_ytd sellerbutton1" 
						onclick="fetch_products_code()"
						style="margin-top:20px;"
						id="graph-merchant-since"
						from="<?php echo $since; ?>"
						to="<?php echo date("d-M-Y", strtotime($date)); ?>"
						rel-type="since">Since</a>

	     			<a href="javascript:void(0)"
						class="btn btn-info ytd_btn sellerbutton1"
						style="margin-top:20px;"
						onclick="fetch_products_ytd()"
						id="graph-merchant-ytd"
						rel-type="ytd">YTD</a>

		    		<a href="javascript:void(0)"
						class="btn btn-info mtd_btn sellerbutton1"
						style="margin-top:20px;"
						onclick="fetch_products_code_mtd()"
						id="graph-merchant-mtd"
						rel-type="mtd">MTD</a>

			    	<a href="javascript:void(0)"
						class="btn btn-info wtd_btn sellerbutton1"
						style="margin-top:20px;"
						onclick="fetch_products_code_wtd()"
						id="graph-merchant-wtd"
						from="<?php echo date("d-M-Y", strtotime($datewtd)); ?>"
						to="<?php echo date("d-M-Y", strtotime($date)); ?>"
						rel-type="wtd">WTD</a>

					<a href="javascript:void(0)"
						class="btn btn-info daily_btn sellerbutton1"
						style="margin-top:20px;"
						onclick="fetch_products_code_daily()"
						id="graph-sales-daily"
						from="<?php echo date("d-M-Y", strtotime($datedaily)); ?>"
						to="<?php echo date("d-M-Y", strtotime($date)); ?>"
						rel-type="daily">Today</a>

					
	            </div>
				
				<div id="skumodalbody" class="modal-body">
				</div>
			</div>
		</div>
	</div>
</div>



<style type="text/css">
.sellerbutton1 {
    width: 90px;
    height: 35px;
    padding-top: 8px !important;
    text-align: center !important;
    vertical-align: middle !important;
    float: left;
    font-size: 13px !important;
    cursor: pointer !important;
    margin-right: 5px !important;
    margin-bottom: 20px !important;
    border-radius: 5px !important;
}
.sellerbutton2 {
    width: 70px !important;
    height: 70px !important;
    padding-top: 16px !important;
    text-align: center;
    vertical-align: middle;
    float: left;
    font-size: 13px !important;
    cursor: pointer;
    margin-right: 5px !important;
    margin-bottom: 5px !important;
    border-radius: 5px !important;
}
.progress1 {
    height: 20px;
    width:100%;
    margin-bottom: 20px;
    border-radius: 4px;
    box-sizing: border-box;
}
.table1 > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
}
</style>

@stop


<!-- kjhk-->
