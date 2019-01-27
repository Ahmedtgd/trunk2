@extends("common.default")

@section("content")
<div class="container" id="sales-analysis" style="margin-top:30px;">
   @include('admin/panelHeading')
        
	 <div class="margin-top">
		<div class="col-xs-12" id="label" >
			<div class='col-xs-3'>
				<label>Partners</label>
			</div>
		</div>
		<div class="col-xs-12" id="consumers-main-container" >
			<div class='col-xs-6 partner-admin-select-container'>
				{!! Form::select('partner', array('' => 'Select...','merchant'=>'Merchant','station'=>'Station','mc'=>'MC','sr'=>'SR','mp'=>'MP'), null, ['class' => 'partner-admin-field col-xs-12']) !!}
			</div>		
		</div>	 
	<!--	<div class="col-xs-12" id="label" style="margin-top: 15px;">
			<div class='col-xs-3'>
				<label>Consumer</label>
			</div>
		</div>
		<div class="col-xs-12" id="consumers-main-container" >
			<div class='col-xs-6 consumer-admin-select-container'>
				{!! Form::select('consumer', array('' => 'Select...','merchant'=>'Merchant','station'=>'Station','buyer'=>'Buyer'), null, ['class' => 'consumer-admin-field col-xs-12']) !!}
			</div>		
		</div>	 -->
		<div class="col-xs-12" id="label" style="margin-top: 15px;">
			<div class='col-xs-3'>
				<label>Country</label>
			</div>
			<div class='col-xs-3'>
				<label>State</label>
			</div>
			<div class='col-xs-3'>
				<label>City</label>
			</div>
			<div class='col-xs-3'>
				<label>Area</label>
			</div>
		</div>
		<div class="col-xs-12" id="countries-main-container" >
			<div class='col-xs-3 countries-admin-select-container'>
				{!! Form::select('country', array('' => 'Select...') + $data['countries'], null, ['class' => 'country-merchant-field col-xs-12']) !!}
			</div>
			<div class='col-xs-3 state-admin-select-container'>
				{!! Form::select('state', array(), null, ['class' => 'state-admin-field col-xs-12']) !!}
			</div>
			<div class='col-xs-3 city-admin-select-container'>
				{!! Form::select('city', array(), null, ['class' => 'city-admin-field col-xs-12']) !!}
			</div>
			<div class='col-xs-3 area-admin-select-container'>
				{!! Form::select('area', array(), null, ['class' => 'area-admin-field col-xs-12']) !!}
			</div>			
		</div>
		<div class="col-xs-12" id="label" style="margin-top: 15px;">
			<div class='col-xs-3'>
				<label>Category</label>
			</div>
			<div class='col-xs-3'>
				<label>SubCategory</label>
			</div>		
			<div class='col-xs-3'>
				<label>Brand</label>
			</div>			
			<div class='col-xs-3'>
				<label>Product</label>
			</div>


		</div>

		<div class="col-xs-12" id="field-main-container" >
			<div class='col-xs-3 category-admin-select-container'>
				{!! Form::select('category', array('' => 'Select...') + $data['categories'], null, ['class' => 'category-admin-field col-xs-12']) !!}
			</div>
			<div class='col-xs-3 area-admin-select-container'>
				{!! Form::select('subcategory', array(), null, ['class' => 'subcategory-admin-field col-xs-12']) !!}
			</div>			
			<div class='col-xs-3 brand-admin-select-container'>
				{!! Form::select('brand', array('' => 'Select...') + $data['brands'], null, ['class' => 'brand-admin-field col-xs-12']) !!}
			</div>
			<div class='col-xs-3 product-admin-select-container'>
				{!! Form::select('product', array(), null, ['class' => 'product-admin-field col-xs-12']) !!}
			</div>			
		</div>

		<div class="col-xs-12" id="label" style="margin-top: 15px; ">
			<div class='col-xs-3'>
				<label>Channel</label>
			</div>
		</div>
		<div class="col-xs-12" id="channels-main-container" style="margin-bottom: 15px; ">
			<div class='col-xs-6 channel-admin-select-container'>
				{!! Form::select('channel', array('' => 'Select...','b2c'=>'Retail','b2b'=>'B2B','hyper'=>'Hyper','smm'=>'SMM','openwish'=>'OpenWish'), null, ['class' => 'channel-admin-field col-xs-12']) !!}
			</div>		
		</div>			

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
                $(document).ready(function() {
                chart = new Highcharts.Chart({
                        chart: {
                           renderTo: 'container',
                       //    type: 'bar' // change this to column if want to show the column chart
                        },
                        title: {
                            text: 'Malaysia Sales Report',
                            x: -20 //center
                        },
                        subtitle: {
                            text: '',
                            x: -20
                        },
						xAxis: {
							categories: xaxis_categories,
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
								var monthNames = ["A", "V", "fsad", "April", "May", "June",
									"July", "August", "September", "October", "November", "December"
								  ];
								var d = this.point.x;
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
                               name: '',
                               data: [],
                              //  data:[[0,0],[1,2]],
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
            <div class='col-xs-12' id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			<div class="col-xs-12">
				<div class="col-xs-3">
					&nbsp;
				</div>
				<?php  $date = date("Y-m-d"); ?>
				<?php  $dateytd = date("Y") . "-01-01"; ?>
				<?php  $datemtd = date("Y-m") . "-01"; ?>
				<div class="col-xs-1">
					&nbsp;
				</div>
				<div class="col-xs-1">
					<a href="javascript:void(0)" class="btn btn-info since_ytd" id="graph-since" from="<?php echo $since; ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="since">Since</a>
				</div>
				<div class="col-xs-1">
					<a href="javascript:void(0)" class="btn btn-info ytd_btn" id="graph-ytd" from="<?php echo date("d-M-Y", strtotime($dateytd)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="ytd">YTD</a>
				</div>
				<div class="col-xs-1">
					<a href="javascript:void(0)" class="btn btn-info mtd_btn" id="graph-mtd" from="<?php echo date("d-M-Y", strtotime($datemtd)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="mtd">MTD</a>
				</div>
				<div class="col-xs-3">
					&nbsp;
				</div>
				<div class="col-xs-1">
					&nbsp;
				</div>				
			</div>
            <div class="col-xs-12 sales-analysis-graph-info">
                <table class="table table-bordered col-xs-12">
                    <tr>
                        <td>
                            Custom date range
                        </td>
                        <td>
                            <label>From</label>
                            
                            <input type='text' id="from_date" class='pull-right datepicker' value="<?php echo date("d-M-Y",strtotime('-1 year',  strtotime($date))); ?>"/>
                        </td>
                        <td>
                            <label>To</label>
                            <input type='text' id="to_date" class='pull-right datepicker' value="<?php echo date("d-M-Y", strtotime($date)); ?>"/>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" id="graph-search" style="width: 100% !important">Search</button>
                        </td>
                    </tr>
                </table>
                <div class="col-xs-12">
                    <table class=" table table-condensed table-hover table-responsive table-striped " id="each-month-max-min-table">
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
	<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Sales</h4>
				</div>
				<div class="modal-body">
					<h3 id="modal-Tittle1"></h3>
					<h3 id="modal-Tittle"></h3>
					<div class="table-responsive">
						<table id="myTable" class="table table-bordered myTable"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>
</div>
@stop
