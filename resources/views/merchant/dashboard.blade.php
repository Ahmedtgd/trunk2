@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
?>
@section("content")
<!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->
<style>

    .tab-pane{
        margin-top: 4em;
    }
/*Butto*/
  .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 18px;
        font-weight: bold;
        margin: 365px 0 0 610px;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
    }
/*
Search
*/
    .search-bar{
        background-color: #006464;
        font-size: 1.2em;
        color: white;
        padding: 10px;
    }
    .details-control, .details-control-2 {
        cursor: pointer;
    }
    .textCenter{
        text-align: center;
    }
    .textRight{
        text-align: right;
    }
    td{
        min-width: 10%;
    }
    td.streched{
        min-width: 100px;
    }
    td.details-control:after ,td.details-control-2:after {
        font-family: 'FontAwesome';
        content: "\f0da";
        color: #303030;
        font-size: 17px;
        float: right;
        padding-right: 25px;
    }
    tr.shown td.details-control:after, tr.shown td.details-control-2:after {
        content: "\f0d7";
    }
    table td.absorbing-column {
    width: 50%;
}

    .child_table {
        margin-left: 78px;
        width: 920px;;
    }
    .panel {
    border: 0;
}

.top-margin{
    margin-top: -30px;
}
    table
    {
        counter-reset: Serial;
        table-layout: auto;
    }

    table.counter_table tr td:first-child:before
    {
        counter-increment: Serial;      /* Increment the Serial counter */
        content: counter(Serial); /* Display the counter */
    }

    .modal-fullscreen{
      margin: 0;
      margin-right: auto;
      margin-left: auto;
      width: 95% !important;
    }


    @media (min-width: 768px) {
      .modal-fullscreen{
        width: 750px;
      }
    }
    @media (min-width: 992px) {
      .modal-fullscreen{
        width: 970px;
      }
    }
    @media (min-width: 1200px) {
      .modal-fullscreen{
         width: 1170px;}
    }
    table#product_details_table,#payment_detail_products
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
    .bg-yellow
    {
        background:#d7e748;
        color: #fff;
    }
</style>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class='cart-info'></strong>
            </div>
            <div class="row">
                <div class="col-sm-11 col-sm-offset-1">
					{!! Breadcrumbs::render('merchant.dashboard') !!}
                    <div class="col-sm-12"><h2>Merchant Dashboard</h2></div>
                    {{-- Tabbed Nav --}}
						<div class="panel with-nav-tabs panel-default ">
							<div class="panel-heading">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#sales-order" data-toggle="tab">SalesOrder</a></li>
									{{-- <li><a href="#delivery-sales" data-toggle="tab">SalesDelivery</a></li>--}}
									<li><a href="#voucher" data-toggle="tab">Voucher</a></li>
									{{--<li><a href="#payment" data-toggle="tab">Payment</a></li>--}}
									<li><a href="#buying-order" data-toggle="tab">BuyingOrder</a></li>
									{{-- <li><a href="#delivery-buying" data-toggle="tab">BuyingDelivery</a></li>--}}
									{{-- <li><a href="#cre" data-toggle="tab">CRE</a></li>--}}
									<li><a href="#open-wish" data-toggle="tab">OpenWish</a></li>
									<li><a href="#auto-link" data-toggle="tab">AutoLink</a></li>
									<li><a href="#hyper" data-toggle="tab">Hyper</a></li>
									<li><a href="#discount" data-toggle="tab">Discount</a></li>
									<li><a href="#likes" data-toggle="tab">Likes</a></li>
									{{-- <li><a href="#loyalty" data-toggle="tab">Loyalty </a></li> --}}
									{{-- <li><a href="#auction" data-toggle="tab">Auction</a></li> --}}
								</ul>
							</div>
						</div>
                    {{--ENDS  --}}

                        <div id="dashboard" class="row panel-body " >
                        <div class="tab-content top-margin" style="margin-top:-50px">
                        <div id="sales-order" class="tab-pane fade in active">
							@include('merchant.dashboard.sales-order')
                        </div>

                        <div id="buying-order" class="tab-pane fade">
							@include('merchant.dashboard.buying-order')
                        </div>

						<div id="delivery-buying" class="tab-pane fade ">
							@include('merchant.dashboard.delivery-buying')
						</div>

						<div id="delivery-sales" class="tab-pane fade ">
							@include('merchant.dashboard.sales-delivery')
						</div>

						{{-- Payment --}}
						<div class="tab-pane fade " id="payment">
							@include('merchant.dashboard.payment')
						</div>
                            {{-- payment ends --}}
                            {{-- Product Ends --}}
                            <div class="tab-pane fade" id="shipping">
                            <div class="table-responsive-removed col-sm-12">
                                <table class="table text-muted counter_table" id="shipping_details_table">
                                <h2>Delivery Details</h2>
								<br>
                                    <thead>
                                    <tr class="bg-move">
                                        <th colspan="10">Delivery Details</th>
                                    </tr>
                                    <tr class="bg-move">
                                        <th>No</th>
                                        <th>Order ID</th>
                                        <th>Merchant ID</th>
                                        <th>External&nbsp;Delivery&nbsp;ID</th>
                                        <th>Company</th>
                                        <th>Status</th>
                                        <th>Days&nbsp; since&nbsp;order</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(! empty($shipping))

                                    @foreach($shipping as $courier )
                                        <tr>
                                            <td></td>
                                            <td>{{$courier->porder_id}}</td>
                                            <td>Merchant ID</td>
                                            <td>S{{UtilityController::s_id($courier->shipping_id)}}</td>
                                            <td>{{ucfirst($courier->name)}}</td>
                                            <td>Status</td>
                                            <td>
                                            <?php
                                                    $now = time(); // or your date as well
                                                     $your_date = strtotime($courier->created_at);
                                                     $datediff = $now - $your_date;
                                                     $days=floor($datediff/(60*60*24));
                                            ?>
                                            {{$days}} days</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>

                                            </div>
                                          </div>
                                          {{--  --}}
                                          {{-- Voucher --}}
                                          <div class="tab-pane fade" id="voucher">
												@include('merchant.dashboard.voucher')
                                          </div>
                                          {{-- Voucher Ends --}}

                            <div class="tab-pane fade" id="open-wish">
								@include('merchant.dashboard.openwish')
                            </div>
                            {{-- Openwish ends --}}

							<!---- Start AutoLink ----->
                            <div class="tab-pane fade" id="auto-link">
								@include('merchant.dashboard.autolink')
                        </div>
                        <!-------- End AutoLink -------->

                        <!-------- Start CRE -------->
						<div class="tab-pane fade" id="cre">
							@include('merchant.dashboard.cre')
						</div>
                        <!-------- End Hyper -------->



                        <!-------- Start Hyper -------->
						<div class="tab-pane fade" id="hyper">
							@include('merchant.dashboard.hyper')
						</div>
                        <!-------- End Hyper -------->


                        <!-------- Start Discount -------->
						<div class="tab-pane fade " id="discount">
							@include('merchant.dashboard.discount')
                        </div>
						
						<div class="tab-pane fade " id="likes">
							@include('merchant.dashboard.likes')
                        </div>						
                        <div id="discountIssueModal" class="modal fade" role="dialog">
                          <div class="modal-dialog" style="    width: 86%;">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" id="discount_id"></h4>
                              </div>
                              <div class="modal-body">

                                <div class="table-responsive">
                                  <table class="table table-bordered" id="discount_buyer_details_table">
                                    <thead>
                                   {{--  <tr class="bg-black">
                                        <th colspan="11">Order Details</th>
                                      </tr> --}}

                                      <tr class="bg-black" style="    background: #4F6328 !important; ">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Start</th>
                                        <th class="text-center">Time Left</th>
                                        <th class="text-center">Due Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Remarks</th>

                                        {{-- <th>SKU</th> --}}

                                        {{-- <th>Delivery Order</th> --}}
                                      </tr>
                                    </thead>
                                    <tbody id="discount_buyer_table" >

                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>

                          </div>
                        </div>
						<!-------- End Discount -------->

                        <div id="dauctions" class="tab-pane fade">
                        <div class="col-sm-12">
                                <div id="auctions" class="row">
                                    <div class="col-xs-12">
									<!--
                                        <a href="#" class="btn btn-success col-sm-2"><i class="fa fa-legal"></i> Auctions</a>
									-->
									<h2>Auction</h2>
									<br>
                                    </div>
                                    <div class="col-sm-4 auction-item">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
                                                    <h4 class="big-text pull-left"> RM</h4>
                                                    <div class="clearfix"> </div>
                                                </div>
                                                <h1 class="large-text">100</h1>
                                                <h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>


                                            </div>
                                            <div class="col-sm-7">
                                                <a href="#"><img alt="auction" src="/images/auction.png" class="auction img-responsive"></a>
                                                <a href="#"><img class="img-responsive" src="/images/radio.jpg" alt="auction-item"></a>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <label class="col-sm-2 control-label">BID: </label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker form-control">
                                                    <option>@if(! empty($currency)){{$currency->code}}@endif</option>
                                                </select>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <div class="col-sm-12">
                                                <ul class="list-inline">
                                                    <li><i class="fa fa-male big-text"></i> </li>
                                                    <li>120 <br><small class="text-muted">Bidders</small></li>
                                                    <li>Time Left<br><small class="text-muted">abcd Lorem Ipsum</small></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 auction-item">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
                                                    <h4 class="big-text pull-left"> RM</h4> <div class="clearfix"> </div></div>
                                                <h1 class="large-text">200</h1>
                                                <h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>


                                            </div>
                                            <div class="col-sm-7">
                                                <a href="#"><img alt="auction" src="/images/auction.png" class="auction img-responsive"></a>
                                                <a href="#"><img style="width: 75%;" class="img-responsive" src="/images/iphone6-gold-select-2014.jpg" alt="auction-item"></a>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <label class="col-sm-2 control-label">BID: </label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker form-control">
                                                    <option>@if(! empty($currency)){{$currency->code}}@endif</option>
                                                </select>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <div class="col-sm-12">
                                                <ul class="list-inline">
                                                    <li><i class="fa fa-male big-text"></i> </li>
                                                    <li>120 <br><small class="text-muted">Bidders</small></li>
                                                    <li>Time Left<br><small class="text-muted">abcd Lorem Ipsum</small></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 auction-item">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
                                                    <h4 class="big-text pull-left"> RM</h4> <div class="clearfix"> </div></div>
                                                <h1 class="large-text">10</h1>
                                                <h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>

                                            </div>
                                            <div class="col-sm-7">
                                                <a href="#"><img alt="auction" src="/images/auction.png" class="auction img-responsive"></a>
                                                <a href="#"><img class="img-responsive" src="/images/watchCblack.jpg" alt="auction-item"></a>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <label class="col-sm-2 control-label">BID: </label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker form-control">
                                                    <option>@if(! empty($currency)){{$currency->code}}@endif</option>
                                                </select>
                                            </div>
                                            <div class="clearfix margin-top"> </div>
                                            <div class="col-sm-12">
                                                <ul class="list-inline">
                                                    <li><i class="fa fa-male big-text"></i> </li>
                                                    <li>120 <br><small class="text-muted">Bidders</small></li>
                                                    <li>Time Left<br><small class="text-muted">abcd Lorem Ipsum</small></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                            </div>
                        {{-- Auction Ends --}}

                        <div id="loyalty" class="row tab-pane fade">
                        <div class="col-sm-12">
                            <h2>Loyalty Program</h2>
                            <br>
                              {{--   <div class="col-xs-12">
                                    <a class="btn btn-orange col-sm-3" href="#"><i class="fa fa-volume-up"></i> Loyalty Programme</a>
                                </div>  <div class="clearfix"></div>
 --}}

                                <div class="col-sm-5">
                                    <div class="form-group">


                                        <label class="col-sm-12 control-label">Let your customers know you are Care with them!</label>
                                        <div class="col-sm-12">

                                            <select data-style="btn-darkgreen" class="selectpicker form-control show-menu-arrow">
                                                <option>Standared Promotion Sentences</option>
                                                <option>50% Store Wide Discount!</option>
                                                <option>Something you can't miss it!</option>
                                                <option>10% DM discount on products only!</option>
                                                <option>Our chef are prepared Something Special!</option>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 text-right margin-top">
                                            <input type="submit" value="Send" class="btn btn-green btn-sm">
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-sm-offset-1">

                                    <label class="control-label">Tell Customers about your promotion!</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" placeholder="...">
                                              <span class="input-group-btn">
                                                <button class="btn btn-green" type="button">Send</button>
                                              </span>
                                    </div>
                                    <span class="help-block">Tell Customers about your promotion!</span>
                                </div>

                                <div class="clearfix"></div>
                                </div>

                        </div>

                        <div id="sales" class="row tab-pane fade">
                            <div class="col-xs-12 margin-top">
								<!--
                                <a class="btn btn-sale col-sm-3" href="#"><i class="fa fa-line-chart"></i> Sales Report</a>
								-->
								<h2>Sales Report</h2>
								<br>
                            </div>  <div class="clearfix"></div>

                            <div class="col-xs-12 margin-top">
                                <script>

                                    $(function () {
                                        $('#containersales').highcharts({
                                            title: {
                                                text: 'Monthly Sales Report',
                                                x: -20 //center
                                            },
                                            subtitle: {
                                                text: '2015',
                                                x: -20
                                            },
                                            xAxis: {
                                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'Sales'
                                                },
                                                plotLines: [{
                                                    value: 0,
                                                    width: 1,
                                                    color: '#718DA3'
                                                }]
                                            },
                                            tooltip: {
                                                valueSuffix: ''
                                            },
                                            legend: {
                                                layout: 'vertical',
                                                align: 'right',
                                                verticalAlign: 'middle',
                                                borderWidth: 0
                                            },
                                            series: [{
                                                name: '',
                                                data: [
                                                    @if(! empty($all))
                                                        @foreach(amountCountMonthly(2015,$all) as $key => $val)
                                                            {!! $val !!},
                                                        @endforeach
                                                    @endif
                                                    ]
                                            }]
                                        });
                                    });

                                </script>
                                <div id="containersales" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                            <div class="col-sm-7">
                                <div class="table-responsive-removed">
                                    <table class="table table-striped ">
                                        <tr>
                                            <th nowrap>Custom Date Range</th>
                                            <th>From</th>
                                            <th><input type="text" placeholder="yy/mm/dd" id="datetimepicker" class="date form-control bg-sale"></th>
                                            <th>To</th>
                                            <th><input type="text" placeholder="yy/mm/dd" id="datetimepickerr" class="date form-control bg-sale"></th>
                                        </tr>
                                        <tr>
                                            <td>Since</td>
                                            <td><span id="dateSince"></span></td>
                                            @if(! empty($currency))
                                            <td colspan="3">{{$currency->code}} <span id="amountSince"></span></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Year to Date</td>
                                            <td></td>
                                            @if(! empty($currency))
                                            <td colspan="3">{{$currency->code}} <span id="amountBetween"></span></td>
                                            @endif
                                        </tr>

                                    </table>


                                </div>

                                <div class="faqs col-sm-8 row">
                                    <h4>Years</h4>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2015</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2015,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs1" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>

                                    </div>
                                    <div id="faqs1" class="collapse in" style="" aria-expanded="true">

                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2015,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>

                                    <div class="faqs-head">
                                        <span class="col-xs-3">2016</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2016,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs2" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>

                                    </div>
                                    <div class="collapse" id="faqs2" aria-expanded="false" style="height: 0px;">

                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2016,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2017</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2017,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs3" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="collapse" id="faqs3" aria-expanded="false" style="height: 0px;">
                                        <table class="table">
                                            @if(! empty($all))@foreach(amountCountMonthly(2017,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2018</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2018,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs4" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="collapse" id="faqs4" aria-expanded="false" style="height: 0px;">
                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2018,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>



                                </div>
                            </div>
                            <div class="col-sm-4 col-sm-offset-1" >

                                <div style="border:1px solid #718DA3">
                                    <div class="col-xs-6" >
                                        <p>Max</p>
                                        <p>Min</p>
                                        <p>Average/Day</p>
                                        <p>Average/Deal</p>
                                        <p>Viewed</p>
                                    </div>
                             {{--        <div class="col-xs-6 bg-sale " style="text-align: right;">
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getMaxVal(amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getMinVal(amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getAvgDaySale(2015, amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all_pro)){{Helper::getAvgDeal($all_pro)}}@endif</p>
                                        <p>@if(! empty($all_pro)){{Helper::getTotalView($all_pro)}}@endif</p>

                                    </div>
                                    <div class="clearfix"></div>
 --}}
                                </div>
                            </div>
                        </div>

						<!--
                        <div id="inventory" class="row tabe-pane fade">

                            <div class="col-xs-12 margin-top">
                                <a class="btn btn-gold col-sm-3" href="#"><i class="fa fa-line-chart"></i>Inventory Report & Analysis</a>
							<h2>Inventory Report & Analysis</h2>
							<br>
                            </div>  <div class="clearfix"></div>

                            <div class="table-responsive-removed col-sm-12">
                                <table class="table text-muted counter_table" id="lower_product_detail_table">
                                    <thead>
                                    <tr class="bg-gold">
                                        <th colspan="10">Products Details</th>
                                        <th class="bg-lightgold" colspan="2">Wholesale</th>
                                        <th class="bg-lightgold" colspan="5">&nbsp;</th>
                                    </tr>

                                    <tr class="bg-gold">
                                        <th style="vertical-align:middle">No</th>
                                        {{-- <th style="vertical-align:middle">SKU</th> --}}
                                        <th style="vertical-align:middle">Name</th>
                                        <th style="vertical-align:middle">Category</th>
                                        <th style="vertical-align:middle">SubCategory</th>
                                        <th style="vertical-align:middle">Description</th>
                                        <th style="vertical-align:middle">Quantity</th>
                                        <th style="vertical-align:middle">Retail Price&nbsp;(RM)</th>
                                        <th style="vertical-align:middle">Original Price&nbsp;(RM)</th>
                                        <th style="vertical-align:middle">Discount%</th>

                                        <th class="bg-lightgold">Price</th>
                                        <th class="bg-lightgold">Unit</th>

                                        <th class="bg-lightgold">Viewed</th>
                                        <th class="bg-lightgold">Bought</th>
                                        <th class="bg-lightgold">Type</th>
                                        <th class="bg-lightgold">Source</th>
                                        <th class="bg-lightgold">Dealers</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(! empty($all_pro))
                                        @foreach($all_pro as $product)
                                            <tr>
                                                <?php
                                                    $discount=($product->original_price-$product->retail_price)/100;
                                                ?>
                                                <td></td>
                                                <td>{{$product->name}}</td>
                                                <td>{{ucfirst($product->category)}}</td>
                                                <td>{{ucfirst($product->subcat)}}</td>
                                                <td>{{ucfirst($product->description)}}</td>
                                                <td>{{$product->available}}</td>
                                                <td>{{$product->retail_price}}</td>
                                                <td>{{$product->original_price}}</td>
                                                <td>{{$discount}}</td>
                                                <td>What Here?</td>
                                                <td>What Here?</td>
                                                <td>What Here?</td>
                                                <td>What Here?</td>
                                            </tr>
                                        @endforeach
                                    @endif


                                    </tbody>
                                </table>
                            </div>
                        </div>
						-->
					 </div>
                        </div>

				</div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="stModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:96%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title" id="myModalLabel2">Remarks</h2>
                </div>
                <div class="modal-body" id="stmodalbody">
                <textarea class="form-control" id="long-remark"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="initajax" style="min-width: 60px;">Close</button>
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade myModal" id="Modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Payment</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" id="merchant_id" value="{{$merchant_id}}" />
<script type="text/javascript">
    $(document).ready(function(){
        $('#asearch').click(function(){
            var query=$('#autolink-search').val();

            var url =JS_BASE_URL+"/autolink/search";
            $.ajax({
                type:'POST',
                url:url,
                data:{'query':query},
                success:function(response){
                    if (response.status=="success") {
                        var searchheader='<b>'+response.count.toString()+'</b> result(s) was found  for <b>"'+response.query+'"</b><hr>';
                        // //alert(searchheader);
                        $('#search-header').html(searchheader);
                        var cont="";
                        for (var i = response.response.length - 1; i >= 0; i--) {
                            // //alert(response.raw_id);
                            cont=cont+'<h3>'+response.response[i].first_name+" "+response.response[i].last_name+'<small>'+response.response[i].user_id+'</small></h3><button type="button" data-button="'+response.response[i].raw_id+'"class="btn btn-success btn-sm mautolink" style="background:rgb(0,99,98);color:#fff;right:0;margin-top:4px;"><span class="glyphicon glyphicon-link"></span>AutoLink</button><hr>';


                        };
                        $('#search-results').html(cont);
                    };
                }
            });
        });
    });

</script>
{{-- Autolink --}}
<script type="text/javascript">
    $(document).ready(function(){
    $('body').on('click','.mautolink',function(){
        var id= $(this).attr('data-button');
        var button= $(this);
        var url=JS_BASE_URL+"/merchant/"+id+"/autolink";
        $.ajax({
            url:url,
            success:function(data){
                if (data.code=="sspr") {

                    button.prop('disabled', true);
                    button.html('Requested');
                };
                if (data.code=="uara") {
                    button.prop('disabled', true);
                    button.html('Requested');
                };
                if (data.code=="unli") {
                    // //alert(data.status);
                    button.html('Login Needed');
                };

            }
        });
    });  //Button Action
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
            $('.role_status_button_link').click(function(){
                $('#stModal').modal('show');
                var autolinkid=$(this).attr('current_role_id');
                var rsbl=$(this);


                $('#initajax').click(function(){
                        $('#stModal').unbind().modal();
                        $('#stModal').modal('hide');
                    remark= $('textarea#long-remark').val();
                    if (rsbl.attr('do_status')=="approve") {
                        url=JS_BASE_URL+"/autolink/accept";
                        $.ajax({
                            url:url,
                            type:'POST',
                            dataType:'json',
                            data:{'id':autolinkid,'remark':remark},
                            success:function(response){
                                if (response.status=="success") {
                                    toastr.info("Your are now AutoLinked with the merchant.Please reload page to update!");
                                };
                            }
                        }); //ajax
                    }
                    else{
                        if (rsbl.attr('do_status')=="reject" || rsbl.attr('do_status')=="suspend") {
                            url=JS_BASE_URL+"/autolink/delete";
                            $.ajax({
                                url:url,
                                type:'POST',
                                dataType:'json',
                                data:{'id':autolinkid,'remark':remark},
                                success:function(response){
                                    if (response.status=="success") {
                                        toastr.info("Your have rejected/unlinked.Please reload page to update!");
                                    };
                                }
                            });//ajax
                        };
                    };
                    $('textarea#long-remark').val('');
                    delete remark;
                });//click
        });//click
    }); //doc
</script>
{{-- <script type="text/javascript" src="{{asset('js/autolink.js')}}"></script> --}}
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>


<script>
    function addToCart(product_id ,amount,ow_id){
        console.log(product_id);
        jQuery.ajax({
            type: "POST",
            url: "{{ url('merchant/help')}}",
            data: { product_id:product_id , amount:amount,ow_id:ow_id},
            beforeSend: function(){},
            success: function(response){
                console.log(response.content);
                $('.cart-link').text('View Cart');
                $('.badge-cart').text(response.total_items);
                $('#alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
                $('.cart-info').text(response.product_name + "  Successfully added to the cart");
            }
        });
    }

    //    $('#auto_link_table').dataTable().fnDestroy();
    $(document).ready(function(){

        function format ( tr ) {

            var j = tr.attr('data-last');

            var table='<table class="table child_table" cellspacing="0" width="100%">';
            table+='<thead>';
            table+='<tr><th>Id</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Sub Total</th></tr>';
            table+='</thead>';
            table+='<tbody>';

            for (i = 1;i<=j;i++){
                var id = tr.attr('data-id-'+i);
                var name = tr.attr('data-name-'+i);
                var qty = tr.attr('data-qty-'+i);
                var price = tr.attr('data-price-'+i);
                var des = tr.attr('data-des-'+i);
                var total = tr.attr('data-total-'+i);
                table+='<tr><td>'+id+'</td><td>'+name+'</td><td>'+des+'</td><td>'+qty+'</td><td>'+price+'</td><td>'+total+'</td></tr>';
            }

            table+='</tbody>';
            table+='</table>';

            return table;
        }

        var table = $('#product_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });
        var table = $('#cre_details_table').DataTable({
            "order": [],
            "scrollX":true,
            "columnDefs": [
                { "targets": "no-sort", "orderable": false },
                { "targets": "large", "width": "150px" },
                { "targets": "smallestest", "width": "55px" },
                { "targets": "medium", "width": "100px" },
                { "targets": "xlarge", "width": "300px" },
                { "targets": "xlarge", "width": "500px" }
            ],
            "fixedColumns":   {
                "leftColumns": 2
            }
        });
        var table = $('#orderb_details_table').DataTable({
            "order": [],
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			]
        });

        var table = $('#shipping_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        var table = $('#shippings_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        $('#lower_product_detail_table').DataTable();
        $('#payment_detail_products').DataTable({
            "order": [],
			"scrollX":true,
            "columnDefs": [
				{ "targets" : 0, "orderable": false, "defaultContent": "" },
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "large",  "width": "120px" },
				{ "targets": "blarge", "width": "200px" },
				{ "targets": "xlarge", "width": "300px" } 
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        $('#voucher_payment_detail').DataTable();

        $('#open_wish_table').DataTable({
            "order": [],
            "scrollX": true,
            "columnDefs": [
				{ "targets" : 0, "orderable": false, "defaultContent": "" },
			]
        });
        $('#auto_link_tables').DataTable({
			"order": [],
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        var vtable = $('#voucher_detail_table').DataTable({
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "className":      'details-control-2',
                "orderable":      false,
                "defaultContent": ""
            } ]
        });

        $('td.details-control-2').on('click', function () {
            console.log('clicked');
            var tr = $(this).closest('tr');
            var row = vtable.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(tr) ).show();
                tr.addClass('shown');
            }
        } );


        $('#datetimepicker , #datetimepickerr').on('change',function(){
            var date1 = $('#datetimepicker').val();
            var date2 = $('#datetimepickerr').val();

            $('#dateSince').html(date1);

            $.ajax({
               url: '{{url('/merchant/calc-sale')}}',
               data: {'date1': date1, 'date2' : date2},
               headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
               error: function() {

               },
               success: function(response) {
                  $('#amountSince').html(response.payment);
                  $('#amountBetween').html(response.paymentSince);
               },
               type: 'POST'
            });
        });

    // $('.uniqporder').click(function(){
    //     // //alert("lol");
    //     // event.preventDefault();
    //     var porder_id= $(this).attr('data');
    //     var url= JS_BASE_URL+"/order/product/"+porder_id;
    //     newwindow = window.open(url, 'Order Details', 'height=500,width=800');
    //     if (window.focus) {newwindow.focus()}
    //     setTimeout(function () {newwindow.close();}, 30000);
    // });

    $('.order_id').on('click',function(e){
        e.preventDefault();
        $('body').css('padding','0px');
        var route = $(this).attr('data-val');
        $.ajax({
            type : "GET",
            url : route,
            success : function(response){
                $('#Modal').find('.modal-body').html(response);
                $('#Modal').modal('show');
                $('.title').text('Payment');
            }
        })
    });
	
	$(".dataTables_empty").attr("colspan","100%");
	$(window).resize();
});

function  merchantNewDiscount(){


}
$("#discountForm").submit(function (e){
    e.preventDefault();
  $("#msg_error").hide();
  $("#msg_sucess").hide();
    var product=$('select[name="discount_product"]').val();
    var duration=$('input[name="discount_duration"]').val();
    var start_date=$('input[name="discount_start_date"]').val();
    var quantity=$('input[name="discount_quantity"]').val();
    var percentage=$('input[name="discount_percentage"]').val();
    $.ajax({
            type : "POST",
            url : JS_BASE_URL+"/merchant/addNewDiscount",
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success : function(response){
                $("#form_submit_button").val("Submitting");
                    $("#form_submit_button").attr("disabled",true);
                $("#msg_error").hide();
                $("#err_discount_product").html('');
                $("#err_discount_start_date").html('');
                $("#err_discount_duration").html('');
                $("#err_discount_quantity").html('');
                $("#err_discount_percentage").html('');
                $("#err_discount_image").html('');
                if (response=='1') {
                    $("#msg_sucess").show();
					get_discounts();
                    clearValues();
                }else{
                    $("#msg_error").show();
                }
            },
            error:function(response){
                $("#msg_error").show();
                $("#err_discount_product").html('');
                $("#err_discount_start_date").html('');
                $("#err_discount_duration").html('');
                $("#err_discount_quantity").html('');
                $("#err_discount_percentage").html('');
                $("#err_discount_image").html('');
                $("#err_discount_image").html(response.responseJSON.discount_image);
                $("#err_discount_product").html(response.responseJSON);
                $("#err_discount_start_date").html(response.responseJSON.discount_start_date);
                $("#err_discount_duration").html(response.responseJSON.discount_duration);
                $("#err_discount_quantity").html(response.responseJSON.discount_quantity);
            $("#err_discount_percentage").html(response.responseJSON.percentage);

            }
        });
});
function clearValues(){
        $('input[name="discount_duration"]').val('0');
        $('input[name="discount_durationff"]').val('0');
        $('input[name="discount_start_date"]').val('');
        $('input[name="discount_quantityff"]').val('0');
        $('input[name="discount_quantity"]').val('0');
        $('input[name="discount_percentage"]').val('0');
        $('input[name="percentage"]').val('0');
    $("#form_submit_button").val("Submit");
    $("#form_submit_button").attr("disabled",false);
    $("#msg_sucess").hide();
    $("#preview-img").attr("src", "/myimg.jpg");
}
function get_discounts(){
	$("#msg_discount_loading").fadeIn("fast");
	var table = $('#discount_details_table').DataTable({
			"order": [],
			"scrollx": true,
			"columnDefs": [
				{"targets": 'no-sort',"orderable": false},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "medium", "width": "80px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"},
			],
			"fixedColumns": {"leftColumns": 2}
		});
	var merchant_id = $('#merchant_id').val();  
      table.destroy();
  $.ajax({
    url:JS_BASE_URL+'/merchant/get_discounts/' + merchant_id,
    type:'GET',
    dataType:'JSON',
    success:function(response){
      $('#discount_table').html('');
      var i=1;
      $.each(response, function (index, value) {
			pfullnote = null;
			pnote = null;
			elipsis = "...";
			pfullnote = value.remarks;
			pnote = pfullnote.substring(0, 60);
			if (pfullnote.length > 60){
				pnote = pnote + elipsis;
			}
        //console.log('div' + index + ':' + 'value'+value.product_id);
        $('#discount_table').append('<tr>'+
          '<td style="text-align: center; vertical-align:middle;">'+ i +'</td>'+
          '<td style="text-align: center;"><a onClick="discountDetail('+value.id+')" href="#">'+ value.idf +'</a></td>'+
          '<td style="text-align: center;"><a href="'+JS_BASE_URL+'/productconsumer/'+ value.product_id +'" target="_blank">'+ value.product_idf +'</a></td>'+
          '<td style="text-align: center;">'+ value.discount_percentage +'%</td>'+
          '<td style="text-align: center; ">'+ value.quantity +'</td>'+
          '<td style="text-align: center;">'+ value.discount_left +'</td>'+
		  '<td style="text-align: center;">'+ value.status +'</td>'+
          '<td <span title="'+pfullnote+'">'+ pnote +'</td>'+

                '</tr>');
              i++;
		});

		$('#discount_details_table').DataTable({
			"order": [],
			"scrollx": true,
			"columnDefs": [
				{"targets": 'no-sort',"orderable": false},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "medium", "width": "80px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"},
			],
			"fixedColumns": {"leftColumns": 2}
		});
		
		$(".dataTables_empty").attr("colspan","100%");

		$("#msg_discount_loading").fadeOut("slow");


        },
        error:function(response){
            console.log(response);
        }
    });
}
get_discounts();


    function discountDetail(id){
    $("#discountDetail").modal("show");
    $.ajax({
        url:JS_BASE_URL+'/merchant/get_discount/'+id,
        type:'GET',
        dataType:'JSON',
        success:function(response){
            $("#discount_id_single").html("Discount# "+response.idf);
            $("#discount_percent_single").html(+response.discount_percentage+"%");
            $('#discount_image_single').css("background-image", "url("+JS_BASE_URL+"/images/discount/"+response.id+ "/" +response.image+ ")");  
            $("#msg_discount_loading").fadeOut("slow");
            
        },
        error:function(response){
            console.log(response);
        }
    });
    
}


function activaTab(tab){
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
};

function increase_val(str, item) {
	var plural = 'xxxxx';
    var curr_val = parseInt($('input[name="'+item+'ff'+'"]').val());
	alert(curr_val);
    curr_val = curr_val + 1;
	/* plural = (curr_val > 1) ? "s" : ""; */
	plural = "xxxxx";
    $('input[name="'+item+'ff'+'"]').val(curr_val+' '+str+plural);
    $('input[name="'+item+'"]').val(curr_val);
};


function decrease_val(str, item) {
	var plural =  'yyyyy';
    var curr_val = parseInt($('input[name="'+item+'"]').val());
    if (curr_val > 0) {
        curr_val = curr_val - 1;
		/* plural = (curr_val > 1) ? "s" : ""; */
		plural = "yyyyy";
        $('input[name="'+item+'ff'+'"]').val(curr_val+' '+str+plural);
        $('input[name="'+item+'"]').val(curr_val);
    }
};

function discount_percentage_inc(){
    var curr_val = parseInt($('input[name="discount_percentage"]').val());
    curr_val = curr_val + 1;
    $('input[name="percentage"]').val(curr_val);
    $('input[name="discount_percentage"]').val(curr_val+"%");
};

function discount_percentage_dec(){
    var curr_val = parseInt($('input[name="discount_percentage"]').val());
    if (curr_val > 0) {
        curr_val = curr_val - 1;
        $('input[name="percentage"]').val(curr_val);
        $('input[name="discount_percentage"]').val(curr_val+"%");
    }
};
$('input[name="discount_percentage"]').keyup(function(){
    var curr_val = parseInt($('input[name="discount_percentage"]').val());


        $('input[name="percentage"]').val(curr_val);
        $('input[name="discount_percentage"]').val(curr_val+"%");

});
function getleftDiscounts(id){
    $("#discountLeftModal").modal("show");
    $.ajax({
        url:JS_BASE_URL+'/merchant/get_left_discounts/'+id,
        type:'GET',
        dataType:'JSON',
        success:function(response){
            $('#left_discount_buyer_table').html('');
            $('#left_discount_id').html("Discount Left ");
            var i=1;
            $.each(response, function (index, value) { 
                $('#left_discount_id').html("Discount Left");
              $('#left_discount_buyer_table').append('<tr>'+
                '<td style="text-align: center;">'+ i +'</td>'+
                '<td style="text-align: center;">'+ value.discount_idf +'</td>'+
                '<td style="text-align: center;"><a href="'+JS_BASE_URL+'/admin/popup/user/'+value.user_id+'">'+ value.user_idf +'</a></td>'+
                '<td style="text-align: center;">'+ value.created_at +'</td>'+

                '</tr>');
              i++; 
          });
            $('#left_discount_buyer_details_table').DataTable();
            $("#msg_discount_loading").fadeOut("slow");

            
        },
        error:function(response){
            console.log(response);
        }
    });
    
}
function getBuyerDiscounts(id){
  $("#discountIssueModal").modal("show");
  $.ajax({
    url:JS_BASE_URL+'/merchant/get_buyer_discounts/'+id,
    type:'GET',
    dataType:'JSON',
    success:function(response){
      $('#discount_buyer_table').html('');
      $('#discount_id').html("Discount ID: "+id);
      var i=1;
      $.each(response, function (index, value) {
        if (value.expired) {
          var color_name='red';
        }else{
          var color_name='black';
        }
        $('#discount_buyer_table').append('<tr style="color: '+color_name+';" >'+
          '<td style="text-align: center;">'+ i +'</td>'+
          '<td style="text-align: center;">'+ value.start_date +'</td>'+
          '<td style="text-align: center;">'+ value.days_left +'</td>'+
          '<td style="text-align: center;">'+ value.due_date +'</td>'+
          '<td style="text-align: center;">'+ value.status +'</td>'+
          '<td style="text-align: center;">Remarks Here</td>'+

                '</tr>');
              i++;
          });
            $('#discount_buyer_details_table').DataTable();
            $("#msg_discount_loading").fadeOut("slow");


        },
        error:function(response){
            console.log(response);
        }
    });

}
</script>
@if(isset($_GET['tab']))

    <script type="text/javascript">
        tagID="{{$_GET['tab']}}";
        activaTab(tagID);
    </script>
@endif
@stop

