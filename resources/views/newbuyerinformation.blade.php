@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$canComplain=1;
?>
@section("content")
    <link href="{{url('css/productbox.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('css/smmproductbox.css')}}" rel="stylesheet" type="text/css">
    <!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->
    <style>
        @media (max-width: @screen-xs-min) {
        .modal-xs { width: @modal-sm; }
        }

        .sellerab{
            color: white;
        }

        .sellerab:hover{
            color: white;
        }

        .sellerab:active{
            color: white;
        }

        .sellerab:link{
            color: white;
        }

        .sellerab:visited{
            color: white;
        }

        .sellerbutton{
            position:relative;
            top:-37px;
            width: 70px;
            height: 70px;
            padding-top: 27px;
            text-align: center;
            vertical-align: middle;
            float: right;
            font-size: 13px;
            cursor: pointer;
            margin-right: 0;
            margin-bottom: 5px;
            border-radius: 5px;
        }


        a, a:focus, a:active, a:hover {
            text-decoration : none !important;
        }
        label {
            display: block;
            padding-left: 15px;
            text-indent: -15px;
        }
        /*input {
          width: 13px;
          height: 13px;
          padding: 0;
          margin:0;
          vertical-align: bottom;
          position: relative;
          top: -1px;
          *overflow: hidden;
        }*/
        .ocpName {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }

        #ocredit .panel-title {
            display: inline;
        }

        .label-style {
            position: relative;
            top: -1px;
        }
        #ocredit .panel-body {
            padding: 0px;
        }

        #ocredit .panel {
            border-radius: 0px;
            box-shadow: none;
            border-bottom: 1px solid #ddd;
        }

        .src-row {
            border: 1px solid #ddd;
            height: 35px;
            border-bottom: 0px;
        }

        .ocDateCol {
            height: 35px;
            padding: 8px;
        }

        .ocPriceCol {
            border-left: 1px solid #ddd;
            height: 35px;
            padding: 8px;
        }

        .bg-standard {
            background: #F5F5F5;
        }

        .sourceTotal {
            cursor: pointer;
            color: #3292DF;
            text-decoration: underline;
        }
        {{-- start --}}
        hr{
            border-top-color: #5F6879;
            margin-top: 0px;

        }

        .priceTable thead tr th,
        .priceTable tbody tr td {
            padding: 0px;
            border: 0px;
            font-size: 12px;
        }

        .priceTable thead tr th {
            padding-bottom: 5px;
        }

        .list-inline{
            margin-top: 10px;
        }

        .showAlert{
            padding: 2px 5px;
            font-size: 12px;
            border-radius: 20px;
        }

        .product-name{
            font-weight: bold;
            @if(Auth::check())
                border-bottom: 1px solid #ccc;
            padding-bottom: 7px;
            padding-top: 7px;
            @else
                padding-top: 9px;
        @endif
    }

        .qty-area{
            padding-top: 7px;
            padding-bottom: 7px;
            border-bottom: 1px solid #ccc;
        }

        .tier-price {
            padding-top: 4px;
            padding-bottom: 0px;
            height: 100px;
            overflow: hidden;
        }

        .tier-price div p {
            padding-bottom: 0px;
            margin-bottom: 2px;
            font-size: 12px;
            font-weight: bold;
        }

        .productName{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .product-price {
            font-weight: bold;
            padding-top: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .popover {
            width: 16%;
        }

        @media (max-width: 321px) {
            .popover {
                width: 70%;
            }
        }

        .popover-content {
            padding: 9px 25px;
        }

        .popover-title {
            padding: 9px 10px;
        }


        .list-inline li {
            width: 30px;
            height: 30px;
            border-radius: 2px;
            text-align: center;
            padding-top: 2px;
        }
        .save {
            background: red;
            color: #fff;
            padding-left: 7px;
            border-radius: 20px;
            padding-right: 7px;
            padding-bottom: 3px;
        }

        .p-box-content {
            padding: 0px 8px 0px 8px;
        }

        button.btn-xs{
            padding: 4px 5px !important;
        }

        {{-- stop --}}
		.col-xs-15,
        .col-sm-15,
        .col-md-15,
        .col-lg-15 {
            position: relative;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }

        .col-xs-15 {
            width: 20%;
            float: left;
        }
        @media (min-width: 768px) {
            .col-sm-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 992px) {
            .col-md-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 1200px) {
            .col-lg-15 {
                width: 20%;
                float: left;
            }
        }


        #paysliptable td{
            padding: 5px;
            border-right:1px solid black;
        }

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
        .easeAni {	-webkit-transition: all 0.3s ease-in; -moz-transition: all 0.3s ease-in; -o-transition: all 0.3s ease-in; transition: all 0.3s ease-in;}

        .boxTile {   height: 33%;  padding-bottom: 45%;  position: relative;  width: 100%;}
        .boxTile .square { margin:10px; position: absolute; bottom: 0;  left: 0;  right: 0;  top: 0;}
        .boxTile .square img {  display: block;  height: 100%;  width: 50%;}
        .boxTile .info { opacity:0.8; bottom: 0;  left: 20%;  overflow: hidden;  padding: 15px;  position: absolute;  right: 0;}
        .boxTile:hover .info { background: #FF0080;opacity:1}
        .boxTile .text {  color: #FFFFFF;  max-height: 100%;  overflow: hidden;  width: 100%;}
        .boxTile .text h2 {  color: #FFF;  display: inline-block;  font-size: 130%;  margin: 8px 0; padding-right:1em;}
        .boxTile .text p {  color: #FFF;  text-transform: uppercase;  white-space: nowrap; font-size: 80%; padding-right:1em;}

        .producttitle {
            margin-top: 5px;margin-left: -11px;  margin-right: -1px;margin-bottom:5px;
            font-weight:bold;
            padding:5px;
            border: 1px solid grey;
            font-size:8px;
        }
        .button {
            background-color:#D7E748; /* green */
            border: none;
            color: white;
            text-align: center;
            display: inline-block;
            font-size: 18px;
            height: 35px;
            width: 150px;
        }









        .boxTile {  padding-bottom: 100%;  }
        .boxTile .square img {  display: block;  width: 100% !important;}
        .boxTile .info {  top: 45%;  background: #FF0080; filter: alpha(opacity=60);}

        }
        .image{
            width:80%;height:70%;margin: 0 auto;position:relative;overflow:hidden;border: 1px solid grey;
        }
        .image img{
            /*border: 1px solid grey;*/
            /*-webkit-filter: drop-shadow(5px 5px 10px black);*/
        }
        .shadow{
            /*webkit-filter: drop-shadow(16px 16px 20px black );*/
            -webkit-filter: drop-shadow(2px 2px 5px black);
        }

        .productbox {

            background-color:#ffffff;
            -webkit-box-shadow: 0 8px 6px -6px  #999;
            -moz-box-shadow: 0 8px 6px -6px  #999;
            box-shadow: 0 8px 6px -6px #999;
        }

        .owInfo{
            width: 150px;height: 70px; background-color: #FF0080;position:absolute;
            float:right;right:22px; bottom:10px;z-index: 1000; color: #ffffff;opacity: 0.9;
        }
        li>a{
            margin-left: 21px;

        }
        /*SMM Summarry box*/
        table{
            font-size: 1em;
        }

        .imgsmm{
            min-width: 100px;
            min-height: 100px;
        }
        .selected{
            border: 1px green solid;
        }
        .box {
            border-radius: 3px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            padding: 10px 25px;
            /*text-align: right;*/
            display: block;
            /*margin-top: 60px;*/
            margin:10px;
        }

        .infosmm{
            font-size: 1.3em;
            letter-spacing: 2px;
            /*text-transform: uppercase;*/
        }
        .selected{
            border: 1px green solid;
        }
        .added{}

        /*CSS ENDS*/
        .edit-personal-info-buyer{
            width:50%!important;
        }

        .bg {
            width: 80%;
            height: 40%;
            /*background-color: #f0f0f0;*/
            object-fit: contain; /* cover works perfectly on Safari */
        }

        .wrapper {
            /*margin-right: -15px;
            margin-left: -15px;
           */
            width: 100%;
            min-width: 60%;
            height: auto;
            max-height:60%;
            overflow: hidden;
        }
        .fvshop{
            display: block;
        }
        .afin{
            height: 10px;
        }
        .fvshop:before {
            /*Using a Bootstrap glyphicon as the bullet point*/
            content: "\e014";
            font-family: 'Glyphicons Halflings';
            font-size: 10px;
            float: left;
            margin-top: 4px;
            margin-left: -17px;
        }
        .details-control, .details-control-2 {
            cursor: pointer;
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

        .child_table {
            margin-left: 78px;
            width: 920px;;
        }
        .panel {
            border: 0;
        }

        table
        {
            counter-reset: Serial;
        }

        table.counter_table tr td:first-child:before
        {
            counter-increment: Serial;      /* Increment the Serial counter */
            content: counter(Serial); /* Display the counter */
        }
        .grayout {
            opacity: 0.6; /* Real browsers */
            filter: alpha(opacity = 60); /* MSIE */
        }

        .statement{
            background: #e6e6e6;
            width: 80%;
            padding: 10px;
            margin: 0 auto;
            border: 2px solid #e6e6e6;
            border-radius: 25px;
        }

        .statementmemo{
            background: #e6e6e6;
            width: 80%;
            padding: 10px;
            margin: 0 auto;
            border: 2px solid #e6e6e6;
            border-radius: 25px;
        }

        .ym{background: #c6c6c6;width: 100%;margin: 0 auto;padding: 5px;border-radius: 25px;}
        /*button{font-family: sans-serif;border: none;width: 45px;}*/
        .btn-enable{background: lightblue;}
        .btn-disable{background: #4d4d4d;color:white;}

        .imagePreview {
            width: 100%;
            height: 300px;
            background-position: center top;
            background-repeat: no-repeat;
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            background-color: #e7e7e7;
            border: 1px solid;
            display: inline-block;
            margin-bottom: 5px;
            border-color: #d0d0d0;
        }

        .imagePreviewBig {
            width: 100%;
            height: 300px;
            background-position: center top;
            background-repeat: no-repeat;
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            background-color: #e7e7e7;
            border: 1px solid;
            display: inline-block;
            margin-bottom: 5px;
            border-color: #d0d0d0;
        }


        .imagePreview input,.imagePreviewBig input {
            filter: alpha(opacity=0);
            opacity: 0;
            width: 100%;
            height: 300px;
            background-position: center top;
            background-size: cover;
            display: inline-block;
            cursor: pointer;
            background-color: #e7e7e7;
            border-color: #d0d0d0;
        }

        .easy-autocomplete-container {
            position: absolute;
            margin-right: 15px;
            width: 90%;
            z-index: 2;
        }

        .cat-img {
            border: 1px solid #ccc;
            padding: 10%;
        }

        .ribbon-wrapper-green {
            width: 84px;
            height: 88px;
            overflow: hidden;
            position: absolute;
            top: -2px;
            right: 0px;
        }

        .ribbon-green {
            font: 12px Lato;
            text-align: center;
            text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
            -webkit-transform: rotate(45deg);
            -moz-transform:    rotate(45deg);
            -ms-transform:     rotate(45deg);
            -o-transform:      rotate(45deg);
            position: relative;
            padding: 7px 0;
            left: -5px;
            top: 15px;
            width: 120px;
            background-color: #ff0080;
            background-image: -webkit-gradient(linear, left top, left bottom, from(#ff0080), to(#ff0040));
            background-image: -webkit-linear-gradient(top, #ff0080, #ff0040);
            background-image:    -moz-linear-gradient(top, #ff0080, #ff0040);
            background-image:     -ms-linear-gradient(top, #ff0080, #ff0040);
            background-image:      -o-linear-gradient(top, #ff0080, #ff0040);
            color: #eee;
            -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
            -moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
            box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
        }

        .ribbon-green:before, .ribbon-green:after {
            content: "";
            border-top:   3px solid #6e8900;
            border-left:  3px solid transparent;
            border-right: 3px solid transparent;
            position:absolute;
            bottom: -3px;
        }

        .ribbon-green:before {
            left: 0;
        }
        .ribbon-green:after {
            right: 0;
        }​
         .btn-pink,.btn-pink:hover{color:#fff; background:#d7e748; }

        .nav>li>span {
            position: relative;
            display: block;
            padding: 10px 15px;
            margin-left: -0.87em;
        }
    </style>

    <script type="text/javascript" src="{{asset('js/autolink_action.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }
        });
    </script>
    <section class="">
		<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong class='cart-info'></strong>
		</div>

        <div class="container"><!--Begin main cotainer-->

			{{-- MQODEL --}}
	{{--    <div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog">

		  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Modal Header</h4>
					</div>
					<div class="modal-body">
					  <p>Some text in the modal.</p>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>

				</div>
			</div> --}}
			<input type="hidden" value="{{$userjust_id}}" id="userjust_id" />
			{{-- ENDS --}}
			<div class="row">
				<div class="col-sm-12 ">
					<span class="hidden-xs">{!! Breadcrumbs::renderIfExists() !!}</span>
					<div class="col-sm-12 hidden-xs">
						<h2>Buyer Dashboard</h2>
					</div>
					{{-- Tabbed Nav --}}
					<div class="panel with-nav-tabs panel-default hidden-xs">
						 <div class="panel-heading" style="padding-right:0">
							<ul class="nav nav-tabs" style="border:0;height:80px">
								<li class="active">
								<a href="#information" data-toggle="tab">
								Information</a></li>
								@if(Auth::user()->id == $userjust_id || Auth::user()->hasRole('adm'))
									<li ><a href="#orders" data-toggle="tab">Orders</a></li>
									{{--<li><a href="#shipping" data-toggle="tab">Delivery</a></li>--}}
									{{--<li><a href="#cre" data-toggle="tab">CRE&nbsp;</a></li>--}}
									<li><a href="#dautolink" data-toggle="tab">AutoLink</a></li>
									{{-- NEW --}}
									<li><a href="#history" data-toggle="tab">Documents</a></li>
									<li><a href="#performance" data-toggle="tab">Performance</a></li>
									<li><a href="#likes" data-toggle="tab">Likes</a></li>
									<li><a href="#discount" data-toggle="tab">Discount</a></li>
									<!--
									#voucher
									#dopenwish
									#smm
									#hyper
									#ocredit
									-->
									<li>
									<a href="#voucher" data-toggle="tab">Voucher</a>
									
									</li>
									<li><a href="#dopenwish"  data-toggle="tab">OpenWish</a></li>
									<li><a href="#smm"  data-toggle="tab">SMM </a></li>
									<li>
										<a href="#hyper" data-toggle="tab">Hyper</a>
								<!--	<span style="margin-left: 0px; margin-right: 0px; padding: 10px; color: #CCC;">Hyper</span> -->
									</li>
									<li><a href="#ocredit" data-toggle="tab">OpenCredit</a></li>
									
									<li>
										@if(Auth::user()->hasRole('mbr'))
											<a href="#fair" data-toggle="tab">Staff</a>
										@else
											<span style="margin-left: 0px; margin-right: 0px; padding: 10px; color: #CCC;">Staff</span>
										@endif
									</li>

									<!-- Only display OPOSsum button if user
										 has the required roles -->
									{{--
									@if(Auth::user()->hasRole('opu') or
										Auth::user()->hasRole('opm'))
									<a href="{{route('opposum.trunk.index')}}"
										id="OPOSsumbuttona" class="sellerab">
										<div class="sellerbutton bg-opossum pull-right"
											id="OPOSsumbutton">
											OPOSsum
										</div>
									</a>
									@endif
									--}}

									<!--
									<li><a href="#auction" data-toggle="tab" class="grayout">Auction</a></li>
									<li><a href="#open-que" data-toggle="tab" class="grayout">OpenQue</a></li>
									<li><a href="#drive-pick" data-toggle="tab" class="grayout">Drive & Pick</a></li>
									<li><a href="#car-park" data-toggle="tab" class="grayout">CarPark</a></li>
									<li><a href="#human-cap" data-toggle="tab" class="grayout">HumanCap</a></li>
									<li><a href="#dating" data-toggle="tab" class="grayout">Dating</a></li> 
									<li><a href="#obiz" data-toggle="tab">Open Business</a></li>
									<li><a href="#loyalty" data-toggle="tab">Loyalty </a></li>
									<li><a href="#coupon" data-toggle="tab" class="grayout">Coupon</a></li>
									-->
								@endif
							</ul>
						</div>
					</div>
					{{--ENDS  --}}
					<div id="dashboard" class="panel-body" style="padding-left:0;padding-top:0;padding-right:0">
						<div class="tab-content top-margin">
							{{-- Buyer Info --}}
							<div id="information" class="tab-pane fade in active">
								@include('buyer.newbuyerinformation.information')
							</div>
							{{--  --}}
							{{-- Obiz --}}
							<div id="obiz" class="tab-pane fade">
								<div class="col-md-12">
									<div class="row "><a class="btn btn-orange col-md-2 bottom-margin-md" id ="open-biss" href="#"><i class="fa fa-suitcase"></i> Open Business</a>
									</div>  <div class="clearfix"></div>
									 <div class="row">
										<div class="col-md-6">
											 <h3>Company Details</h3>
											 <div class="form-group">
												{{--
												<label class="col-md-12 control-label">&nbsp;</label> --}}
												<label class="col-md-4 control-label">Company Name</label>
												<div class="col-md-8">
												  <input type="text" placeholder="if using company account" class="form-control">
												</div>
												<label class="col-md-4 control-label"> Reg No</label>
												<div class="col-md-8">
												  <input type="text" placeholder="if using company account" class="form-control">
												</div>
												<label class="col-md-4 control-label">Type</label>
												<div class="col-md-8">

												 <select data-style="btn-orange" class="selectpicker show-menu-arrow form-control">
												  <option>Dealers</option>
												  <option>Merchant Consultant</option>
												  <option>SMM</option>
												  </select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<h3>Bank Details</h3>
											<div class="form-group">
												<label style="margin-top:4px"
													class="col-md-4 control-label">Account Name </label>
												<div class="col-md-8">
												  <input type="text" class="form-control">
												</div>

											    <label style="margin-top:4px"
													class="col-md-4 control-label">Account Number </label>
												<div class="col-md-8">
												  <input type="text" class="form-control">
												</div>

											    <label style="margin-top:4px"
													class="col-md-4 control-label">Bank Name</label>
												<div class="col-md-8">
												  <input type="text" class="form-control">
												</div>

												<label style="margin-top:4px"
													class="col-md-4 control-label">Bank Code </label>
												<div class="col-md-8">
												  <input type="text" class="form-control">
												</div>

											    <label style="margin-top:4px"
													class="col-md-4 control-label">IBAN </label>
												<div class="col-md-8">
												  <input type="text" class="form-control">
												</div>

												<label style="margin-top:4px"
													class="col-md-4 control-label bottom-margin-md">SWIFT </label>
												<div class="col-md-8">
												  <input type="text" class="form-control">
												</div>

											</div>

										</div>
										<div class="col-md-6"></div>
									 </div>

								</div>

								<div class="col-md-2 bottom-margin-md"><input type="submit" class="form-control btn btn-primary pull-right" value="Add Details"><p></p> </div>


							</div>
							<div id="history" class="tab-pane fade">
								@include('buyer.newbuyerinformation.history')
							</div>
							{{-- OBIZends --}}
							<div id="orders" class="tab-pane fade">
								@include('buyer.newbuyerinformation.orders')
							</div>
								{{-- Extras --}}
							<div id="hyper" class="tab-pane fade  ">
								@include('buyer.newbuyerinformation.hyper')
							</div>
							{{--
							<div id="pusher" class="tab-pane fade"><div class="col-sm-12"> <h2>Pusher</h2></div> </div>
							--}}
							<div id="performance" class="tab-pane fade">
								@include('buyer.newbuyerinformation.performance')
							</div>

							<!-- Start "Likes" Tab -->
							<div id="likes" class="tab-pane fade">
								@include('buyer.newbuyerinformation.likes')
							</div>
							<!-- Start "Discount" Tab -->
							<div id="discount" class="tab-pane fade">
								@include('buyer.newbuyerinformation.discount')
							</div>
							<!-- End "Discount" Tab -->

							<!-- Start "ocredit" Tab -->
							<div id="ocredit" class="tab-pane fade">
								@include('buyer.newbuyerinformation.ocredit')
							</div>
							<!-- End "ocredit" Tab -->

							<div id="merchant-consultant" class="tab-pane fade"><div class="col-sm-12"> <h2>Merchant Consultation</h2></div> </div>
							<div id="station-recruiter" class="tab-pane fade"><div class="col-sm-12"> <h2>Station Recruiter</h2></div> </div>
							<div id="merchant-professional" class="tab-pane fade"><div class="col-sm-12"> <h2>Merchant Professional</h2></div> </div>
							{{-- Ends --}}
							{{-- Product Ends --}}
							<div class="tab-pane fade" id="shipping">
								@include('buyer.newbuyerinformation.shipping')
							</div>
							{{-- Voucher Starts --}}
							<div class="tab-pane fade" id="voucher">
								@include('buyer.newbuyerinformation.voucher')
							</div>
							{{-- Voucher Ends --}}

							<div class="tab-pane fade" id="dopenwish">
								@include('buyer.newbuyerinformation.dopenwish')
							</div>

							{{--  --}}
							{{-- Openwish ends --}}
							{{-- AutoLink starts --}}
							<div id="dautolink" class="tab-pane fade">
								@include('buyer.newbuyerinformation.dautolink')
							</div>
							{{-- Autolink ENDS --}}
							{{-- SMM  --}}
							<div id="smm" class="tab-pane fade">
								@include('buyer.newbuyerinformation.newsmm')
							</div>
							<div id="fair" class="tab-pane fade">
								@include('buyer.newbuyerinformation.fairmode')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--End main cotainer-->
</div><!--End main cotainer-->
</section>

<div class="modal fade" id="stModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:70%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel2">Remarks</h2>
			</div>
			<div class="modal-body" id="stmodalbody" style="margin-left: 0px !important;">
			<textarea class="form-control" id="long-remark"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="initajax" style="min-width: 60px;">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="salesmemoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:70%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel2">Sales Memo</h2>
			</div>
			<div class="modal-body" id="salesmemomodalbody" style="margin-left: 0px !important;">
			<textarea class="form-control" id="long-remark"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="initajax" style="min-width: 60px;">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalpayslip" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document" style="width: 65%">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Payslip</h4>
		</div>
		<div class="modal-body modalpay" style="margin-top: 0px !important; margin-right: 0px !important; margin-bottom: 0px !important; margin-left: 0px !important;">
			<div class="row">
				<div class="col-sm-9">
					Name: @if(isset($payslip['username'])){{$payslip['username']}}@endif
				</div>
				<div class="col-sm-3">
					<p>{{date('d-m-Y')}}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-9">
					Staff No.: @if(isset($payslip['employeeid']))[{{str_pad($payslip['employeeid'], 10, '0', STR_PAD_LEFT)}}]@endif
				</div>
				<div class="col-sm-3">
					<p>Payslip for @if(date('m') == date('m', strtotime('+1 week'))){{date('F', strtotime('+4 week'))}} @else {{date('F')}} @endif, {{date('Y')}}</p>
				</div>
			</div>
			<table width="97%" id="paysliptable">
				<tr style="border:1px solid black;">
					<td width="30%" ><b>Income</b></td>
					<td width="10%" ><b>Current</b></td>
					<td width="10%" ><b style="float:right;">Y-T-D</b></td>
					<td width="30%" ><b>Deduction</b></td>
					<td width="10%" ><b>Current</b></td>
					<td width="10%" ><b style="float:right;">Y-T-D</b></td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td >Basic Pay</td>
					<td > @if(isset($payslip['basic_pay']))<span style="float: right;">{{$payslip['basic_pay']}}</span>@endif</td>
					<td >@if(isset($payslip['basic_pay_ytd']))<span style="float: right;">{{$payslip['basic_pay_ytd']}}</span>@endif</td>
					<td >Advance</td>
					<td ></td>
					<td ></td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td >Bonus</td>
					<td >@if(isset($payslip['bonus']))<span style="float: right;">{{$payslip['bonus']}}</span>@endif</td>
					<td ></td>
					<td >EPF</td>
					<td >@if(isset($payslip['epf']))<span style="float: right;">{{$payslip['epf']}}</span>@endif</td>
					<td >@if(isset($payslip['epf_ytd']))<span style="float: right;">{{$payslip['epf_ytd']}}</span>@endif</td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td ></td>
					<td ></td>
					<td >SOCSO</td>
					<td >@if(isset($payslip['socso']))<span style="float: right;">{{$payslip['socso']}}</span>@endif</td>
					<td >@if(isset($payslip['socso_ytd']))<span style="float: right;">{{$payslip['socso_ytd']}}</span>@endif</td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td ></td>
					<td ></td>
					<td >PCB</td>
					<td >@if(isset($payslip['pcb']))<span style="float: right;">{{$payslip['pcb']}}</span>@endif</td>
					<td >@if(isset($payslip['pcb_ytd']))<span style="float: right;">{{$payslip['pcb_ytd']}}</span>@endif</td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td ></td>
					<td ></td>
					<td >CP38</td>
					<td ></td>
					<td ></td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td >&nbsp;</td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td >&nbsp;</td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td >&nbsp;</td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td ></td>
					<td ></td>
					<td >Employer EPF</td>
					<td ></td>
					<td >@if(isset($payslip['eepf']))<span style="float: right;">{{$payslip['eepf']}}</span>@endif</td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td ></td>
					<td ></td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;">Employer SOCSO</td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;">@if(isset($payslip['esocso']))<span style="float: right;">{{$payslip['esocso']}}</span>@endif</td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td ></td>
					<td ></td>
					<td ></td>
					<td >Gross Income</td>
					<td ><p align="right">@if(isset($payslip['gross']))<span style="float: right;">{{$payslip['gross']}}</span>@endif</p></td>
					<td ><p align="right">@if(isset($payslip['basic_pay_ytd']))<span style="float: right;">{{$payslip['basic_pay_ytd']}}</span>@endif</p></td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black;">
					<td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;">Net Income</td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;">@if(isset($payslip['net']))<span style="float: right;">{{$payslip['net']}}</span>@endif</td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;">@if(isset($payslip['net_ytd']))<span style="float: right;">{{$payslip['net_ytd']}}</span>@endif</td>
				</tr>
				<tr style="border-left:1px solid black;border-right:1px solid black; border-bottom:1px solid black;">
					<td >Gross Total</td>
					<td ><p align="right">@if(isset($payslip['gross']))<span style="float: right;">{{$payslip['gross']}}</span>@endif</p></td>
					<td ><p align="right">@if(isset($payslip['basic_pay_ytd']))<span style="float: right;">{{$payslip['basic_pay_ytd']}}</span>@endif</p></td>
					<td >End Month Pay</td>
					<td >@if(isset($payslip['net']))<span style="float: right;"><b>{{$payslip['net']}}</b></span>@endif</td>
					<td ></td>
				</tr>
			</table>
			<br>
			<p><a href="{{route('payslipdf')}}" target="_blank" style="float: right;">Download PDF</a></p>
		</div>
	</div>
</div>
</div>
@include('modals.smm')
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">	function deleteaccount(){
	var r = confirm("Are you sure? All data & information will be irrevocably lost!");
	if (r == true) {
		if($("#checkdelete").is(':checked')){
			var uid = $("#user_account").val();
			url=JS_BASE_URL+"/deleteaccount";
				$.ajax({
				url:url,
				type:'POST',
				dataType:'json',
				data:{'uid':uid},
				success:function(response){
					//console.log(response);
					document.location.href="/";
				}
			}); //ajax			JS_BASE_URL
		} //ajax			JS_BASE_URL
	} else {

	}

}
function deleteaccount(){
	var r = confirm("Are you sure? All data & information will be irrevocably lost!");
	if (r == true) {
		if($("#checkdelete").is(':checked')){
			var uid = $("#user_account").val();
			url=JS_BASE_URL+"/deleteaccount";
				$.ajax({
				url:url,
				type:'POST',
				dataType:'json',
				data:{'uid':uid},
				success:function(response){
					//console.log(response);
					document.location.href="/";
				}
			}); //ajax			JS_BASE_URL
		} //ajax			JS_BASE_URL
	} else {

	}

}
$(document).ready(function(){
	var product_id=-1;
	$('body').click(function(evt){

		if ($(evt.target).hasClass('added')) {
			$('.pimage').removeClass('selected');

			var pid= $(evt.target).attr('data-pid');

			window.prodid=pid;
			var cls=".productbox_"+pid;
			$(cls).toggleClass('selected');
			// $('#blast').attr('disabled');
			// if ($(evt.target).hasClass('selected')) {
			//     var product_id= $('.productbox').attr('data-pid');
			//     //alert(product_id);
			// };

		}
		else{
			$('.pimage').removeClass('selected');
			 // $('#blast').removeAttr('disabled');
		}

	});

});
</script>
{{-- Autolink --}}
<script type="text/javascript">
$(document).ready(function(){

    var sum = 0;
        $('.tvalue').each(function(){
            sum = sum + parseInt($(this).text());
        });

        tvalueTotal = number_format(sum, 2);

        $('#tvalueTotal').text(tvalueTotal);

        function number_format(number, decimals, dec_point, thousands_sep)
        {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
              var k = Math.pow(10, prec);
              return '' + (Math.round(n * k) / k).toFixed(prec);
            };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
	$('.modalpay').attr("style","margin-top: 0px !important; margin-right: 0px !important; margin-bottom: 0px !important; margin-left: 0px !important;")
	$('.payslip').click(function(){
		$("#modalpayslip").modal("show");
	});

	/*$('#deleteaccount').click(function(){
		alert("cad");
		if($("#checkdelete").is(':checked')){
			alert("cad");
		}
	});	*/

	function pad(str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}

	var optionsbuyer = {
	  url: "/jsonbuyersid",
	  getValue: "name",

	  list: {
		match: {
		  enabled: true
		},
		onSelectItemEvent: function() {
			var id = $("#mp1json").getSelectedItemData().id;
			var userid = $("#mp1json").getSelectedItemData().uid;
			$("#mp1_link").val(id);
			$("#mp1u_link").val(userid);
		}

	  }
	};

	$("#mp1json").easyAutocomplete(optionsbuyer);

	var optionsbuyer2 = {
	  url: "/jsonbuyersid",
	  getValue: "name",

	  list: {
		match: {
		  enabled: true
		},
		onSelectItemEvent: function() {
			var id = $("#mp2json").getSelectedItemData().id;
			var userid = $("#mp2json").getSelectedItemData().uid;
			$("#mp2_link").val(id);
			$("#mp2u_link").val(userid);
		}

	  }
	};

	$("#mp2json").easyAutocomplete(optionsbuyer2);

	var mc_user_id = $("#userid_link").val();
	var optionsmerchantmc = {
	  url: "/jsonmerchantid/" + mc_user_id,
	  getValue: "name",

	  list: {
		match: {
		  enabled: true
		},
		onSelectItemEvent: function() {
			var userid = $("#merchantjson").getSelectedItemData().id;
			$("#merchant_link").val(userid);
		}

	  }
	};
	$("#merchantjson").easyAutocomplete(optionsmerchantmc);

	var table_mcmp = $('#tablemcmp').DataTable({
		"order": [],
		//"scrollX": true,
		"columnDefs": [
			{ "targets": "no-sort", "orderable": false },
			{ "targets": "foo", "width": "10px" },
			{ "targets": "smallestest", "width": "55px" },
			{ "targets": "medium", "width": "95px" },
			{ "targets": "large", "width": "120px" },
			{ "targets": "xlarge", "width": "280px" }
		],
		"fixedColumns": true
	});	
	
	$('#send_link').click(function(){
			var merchant_link = $('#merchant_link').val();
			var mp1_link = $('#mp1_link').val();
			var mp1u_link = $('#mp1_link').val();
			var mp2_link = $('#mp2_link').val();
			var mp2u_link = $('#mp2_link').val();
			if(merchant_link == "0"){
				$("#merchantjson").addClass('fields_error');
				$('#link_error').show();
				setTimeout(function(){$('#link_error').hide();$("#merchantjson").removeClass('fields_error');}, 5000);
			} else {
				if(mp1_link == "0"){
					$("#mp1json").addClass('fields_error');
					$('#link_error').show();
					setTimeout(function(){$('#link_error').hide();$("#mp1json").removeClass('fields_error');}, 5000);
				} else {
						$("#send_link").html("Sending...");
						url=JS_BASE_URL+"/sendmp";
						$.ajax({
						url:url,
						type:'POST',
						dataType:'json',
						data:{'merchant_link':merchant_link,'mp1_link':mp1u_link,'mp2_link':mp2u_link},
						success:function(response){
							//console.log(response);
							$("#send_link").html("Send");
							var t = $("#t").val();
							var tt = parseInt(t) + 1;
							$("#t").val(tt);
							table_mcmp.row.add([tt,"<a href='"+JS_BASE_URL+"/admin/popup/merchant/"+merchant_link+"'> [" + pad(merchant_link,10) + "]</a>","<a href='"+JS_BASE_URL+"/admin/popup/user/"+mp1u_link+"'>[" + pad(mp1_link,10) + "]</a>","<a href='"+JS_BASE_URL+"/admin/popup/user/"+mp2u_link+"'>[" + pad(mp2_link,10) + "]</a>","Completed"]).draw();
							//$("#tablemcmp").append("<tr><td>" + tt + "</td><td></td><td></td><td></td><td></td></tr>");
						}
					}); //ajax
				}
			}
	});//click


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
{{-- AJAC CALL FOR SMM SAVE --}}
{{-- <script type="text/javascript">
$(document).ready(function(){
	$('#blast').click(function(){
		// //alert(product_id);
		$.ajax({
				url: JS_BASE_URL + '/smedia/marketer',
				type: 'GET',
				data: {product_id: prodid},
				success:function(response){
					toastr.info(response);
				}
		});
	});
	
	$('#portfolio').click(function(){
		$('#myModalPortfolio').modal('toggle');
	});	
	
	//$('.CRM').click(function(){

});
</script> --}}


<script>
// $(function() {
// 	$( document ).tooltip();
// });
function show_name(name){
	console.log(name);
	$('.showname').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
	$('.fullname').text(name);
}
$('#open_wish_table').DataTable();
$('#auto_link_table').DataTable({
	"order": [],
	"scrollX": true,
	"columnDefs": [
		{ "targets" : 0, "data": null, "orderable": false, "defaultContent": "" },
		{ "targets" : 11, "data": null, "orderable": false, "defaultContent": "" }
	]
});





function statement(id,year,month) {
	//get the merchant data from the backend and render on the modal
	console.log(month);
	$("#h" + year + "-" + month).hide();
	$("#i" + year + "-" + month).show();
	$.ajax({
		type: "POST",
		url: JS_BASE_URL+"/statement/buyerdetail",
		data: { id:id,year:year,month:month },
		beforeSend: function(){},
		success: function(response){
			$('#stmodalbody').html(response);
			$('#stModal').modal('toggle');
			$("#h" + year + "-" + month).show();
			$("#i" + year + "-" + month).hide();
		}
	});
}


function statementmemo(id,year,month) {
	//get the merchant data from the backend and render on the modal
	console.log(month);
	$("#hsa" + year + "-" + month).hide();
	$("#isa" + year + "-" + month).show();
	$.ajax({
		type: "POST",
		url: JS_BASE_URL+"/salesmemo/buyerdetailweb/" + $("#fairrecruiter").val(),
		data: { id:id,year:year,month:month },
		beforeSend: function(){},
		success: function(response){
			$('#salesmemomodalbody').html(response);
			$('#salesmemoModal').modal('toggle');
			$("#hsa" + year + "-" + month).show();
			$("#isa" + year + "-" + month).hide();
		}
	});
}

$(document).ready(function(){

	$(document).delegate( '.crm_management', "click",function (event) {
		var userid = $("#userjust_id").val();
		$.ajax({
			type: "GET",
			url: "/buyer/crm/customers/" + userid,
			success: function (data) {
				$("#myBodyCRM").empty();
				$("#myBodyCRM").html(data);
				$("#myModalCRM").modal('show');
				//obj.html("Send");
			},
			error: function (error) {
				toastr.error("An unexpected error ocurred");
			}

		});
	});	

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

 var table = $('#shipping_details_table').DataTable({
		"order": [],
		//"scrollX": true,
		"columnDefs": [
			{ "targets": "no-sort", "orderable": false },
			{ "targets": "large", "width": "120px" },
			{ "targets": "smallestest", "width": "55px" },
			{ "targets": "medium", "width": "95px" },
			{ "targets": "xlarge", "width": "280px" }
		],
		"fixedColumns": true
	});

/* var table = $('#auto_link_tables').DataTable({
		"order": [],
		//"scrollX": true,
		"columnDefs": [
			{ "targets": "no-sort", "orderable": false },
			{ "targets": "large", "width": "120px" },
			{ "targets": "smallestest", "width": "55px" },
			{ "targets": "medium", "width": "95px" },
			{ "targets": "xlarge", "width": "280px" }
		],
		"fixedColumns": true
	});*/

 var table = $('#performance_table').DataTable({
		"order": [],
		//"scrollX": true,
		"columnDefs": [
			{ "targets": "no-sort", "orderable": false },
			{ "targets": "large", "width": "120px" },
			{ "targets": "smallestest", "width": "55px" },
			{ "targets": "medium", "width": "95px" },
			{ "targets": "xlarge", "width": "280px" }
		],
		"fixedColumns": true
	});
	
 var table = $('#tableportfolio').DataTable({
		"order": [],
		//"scrollX": true,
		"columnDefs": [
			{ "targets": "no-sort", "orderable": false },
			{ "targets": "large", "width": "120px" },
			{ "targets": "smallestest", "width": "55px" },
			{ "targets": "medium", "width": "95px" },
			{ "targets": "xlarge", "width": "280px" }
		],
		"fixedColumns": true
	});	

   // $('#shipping_details_table').DataTable();
	$('#lower_product_detail_table').DataTable();
	$('#payment_detail_products').DataTable();
	// $('#voucher').DataTable();



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

	$(".dataTables_empty").attr("colspan","100%");
});
function addToCart(product_id ,price){
	code = "<?php echo $currency->code?>";
	console.log(code);
	jQuery.ajax({
		type: "POST",
		url: "{{ url('buyer/openwishProduct')}}",
		data: { product_id:product_id , price:price},
		beforeSend: function(){
			$('.'+product_id).text(code+' '+ price);
		},
		success: function(response){
			console.log(response.content);
			$('.cart-link').text('View Cart');
			$('.badge-cart').text(response.total_items);
			$('#alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
			$('.cart-info').text(response.product_name + "  Successfully added to the cart");
		}
	});
}

function addToCartow(product_id ,price,pledged,owid){
	var code = "<?php echo $currency->code?>";
	console.log(product_id);
	var nprice = price;
	var npledged = pledged;
	jQuery.ajax({
		type: "POST",
		url: "{{ url('buyer/openwishProduct')}}",
		data: { product_id:product_id , owid:owid},
		beforeSend: function(){
			$('.'+product_id).text(code+' '+ price);
		},
		success: function(response){
			console.log(response);
			var nnprice = (parseFloat(nprice) - parseFloat(npledged));
			
			if(nnprice < 0){
				nnprice = 0;
			}
			
			
			$('.cart-link').text('View Cart');
			$('.badges').text(response.total_items);
			$('.badges').show();
			$('.badgesmobile').text(response.total_items);
			$('.badgesmobile').show();
			$('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
			$('.cart-info').text(response.product_name + ' (' + number_format(response.price , 2) + ' ' + code + ') ' + "  Successfully added to the cart");
		}
	});
}
function addToWishList(product_id){
	console.log(product_id);
	jQuery.ajax({
		type: "GET",
		url: "{{ url('add_to_wish_list_new')}}",
		data: {itemId:product_id },
		beforeSend: function(){},
		success: function(response){
			if(response.search("OpenWish") != -1)
			{
				toastr.info(response);
			}
			else {
				window.location.replace('http://beta.opensupermall.com/fb/login');
			}
		}
	});
}
</script>
<script type="text/javascript">
$(document).ready(function() {
  longString="This is has been bypassed";
var contentDiv = $(".longname");
contentDiv.html(longString.substr(0,12) + "...");
contentDiv.mouseover(function(){
	 this.html(longString);
});

contentDiv.mouseout(function(){
	 this.html(longString.substr(0,12) + "...");
});
	$(".dataTables_empty").attr("colspan","100%");
});
                            function activaTab(tab){
                            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
                            };</script>

@if(isset($_GET['tab']))

<script type="text/javascript">
                            tagID = "{{$_GET['tab']}}";
                            activaTab(tagID);
</script>
@endif
{{-- ENDS --}}
@stop
{{-- {{1/0}} --}}
