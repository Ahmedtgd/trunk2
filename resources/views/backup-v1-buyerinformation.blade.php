@extends("common.default")
@section('extra-links')
	<style type="text/css">
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
			    color: #FF0000;
	}
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
				margin-right: -15px; 
			    margin-left: -15px;
			   
		 		width: 100%;
				min-width: 60%;
				height: auto;
				max-height:60%;
				overflow: hidden;
		}
	.no-margin {
				margin-right: -15px; 
			    margin-left: -15px;
		}
	.dl-horizontal
		{

		}
		li {
			margin-left:20px;
		}
		</style>
	
<script type="text/javascript" src="{{asset('js/autolink_action.js')}}"></script>

@stop
@section("content")


<section class="">
	<div class="container"><!--Begin main cotainer-->
	{{-- ROW1 --}}
		<div class="row">
					
			<div data-spy="scroll" style="display: none;" class="static-tab">
				<div class="text-center tab-arrow">
					<span class="fa fa-sort"></span>
				</div>

				<ul class="nav nav-pills nav-stacked ">
					<li role="presentation" class="floor-navigation" style="display:none"><a href="#information">Information</a></li>
					<li role="presentation" class="floor-navigation"><a href="#information">Information</a></li>
					<li role="presentation" class="floor-navigation"><a href="#open-wish">Open Wish</a></li>
					{{-- <li role="presentation" class="floor-navigation"><a href="#auctions">Auctions</a></li> --}}
								{{-- <li role="presentation" class="floor-navigation" style="display:none"><a href="#smm">SMM</a></li> --}}
					<li role="presentation" class="floor-navigation"><a href="#smm">SMM</a></li>

					{{-- <li role="presentation" class="floor-navigation"><a href="#autolink">AutoLink</a></li> --}}
					<li role="presentation" class="floor-navigation"><a href="#open-biss">Open Biz.</a></li>
					{{-- <li role="presentation" class="floor-navigation"><a href="#new">New</a></li> --}}
				</ul>
			</div>
			<div class="col-md-11 col-md-offset-1">
			<img src="images/banner.png" title="banner" class="img-responsive banner">
			{{-- <hr> --}}
			
			<form class="form-horizontal">
			{{--My code below  --}}
			<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-4 col-xs-12" id="information">	<a href="{{url('buyerinformation/edit')}}" class="btn btn-success pull-right no-margin"><span class="glyphicon glyphicon-edit"></span> Edit Personal Details</a> </div>
			<div class="col-md-5 col-xs-12"><h3 style="text-align:center;"> My Favorite O-Shop <span class="glyphicon glyphicon-heart"></span></h3></div>
				{{-- <div class="row"><a href="{{url('buyerinformation/edit')}}" class="pull-right btn btn-primary ">Edit</a></div> --}}
			</div>
			<div class="row">
				{{-- Profile and My Fav. OShop and Image Information in this row --}}
				<div class="col-md-3">
				<div class="wrapper"><img src="{{$image}}" title="profile-image" class=" bg img-responsive"> </div>
					<h3 style="text-align:left;" class="display-4 no-margin"><span class="text-muted">{{$user->salutation}}</span> {{$name}}</h3>
				<h5 class="no-margin"><span class="text-muted">User ID: </span> {{$user_id}}</h5>
				<h5 class="no-margin"><span class="text-muted">Member Since:</span> {{$member_since}}</h5>
				 </div>
				<div class="col-md-4">
					
					<div class="row">
				
						<div class="panel">

							<div class="panel-heading1 panel-title bottom-margin-xs">Personal Details</div>
						
							<div class="panel-body border-con">

								<dl class="dl-horizontal text-muted">
									<dt>Age</dt>
									<dd>{{$age or 'NaN'}}</dd>
									<dt>Occupation:</dt>
									<dd>{{$occupation or 'NaN'}}</dd>
									{{-- <dt>User ID:</dt>
									<dd>{{$user->id}}</dd>
									<dt></dt> --}}
									<dt>Default Address</dt>
									<dd>
										{{$da->line1 or $da}} <br>
										{{$da->line2 or $da}}
										<be>
											{{$da->line3 or $da}} , {{$da->line4 or $da}}
									</dd>
									<dt>Billing Address</dt>
									<dd>
										{{$ba->line1 or "---"}} <br>
										{{$ba->line2 or $ba}}
										<be>
											{{$ba->line3 or $ba}} , {{$ba->line4 or $ba}}
									</dd>
									<dt>Language</dt>
									<dd>{{$language}}</dd>
									<dt>Annual</dt>
									<dd>{{$user->annual_income}}</dd>
									<dt>Potential Industry</dt>
									<dd>{{$buyerinfo->potential_industry or "--"}}</dd>
									<dt>Products</dt>
									<dd>{{$buyerinfo->products or "--"}}</dd>
									<dt>Amount</dt>
									<dd>{{$buyerinfo->amount or "--"}}</dd>
								</dl>
							</div>
							<div class="afin"><span>&nbsp</span></div>
							<div class="panel-heading1"> Interests</div>
						<div class="panel-body border-con text-muted">
							<p class="text-muted"><!-- Electronics, Fashion, Beauty, Health & Cosmatics --> {{$interests}}</p>
						</div>
						</div>

					</div>
				</div>
				<div class="col-md-5 col-xs-12">
					<div class="row">

						<div class="input-group input-group-sm pull-right col-md-6">
						  <input type="text" class="form-control" placeholder="Search">
						  <span class="input-group-btn">
							<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
						  </span>
						  </div>
					</div>
					<div class="row">
							<div class="clearfix"></div>
							<div id="oshop-favo">
								<ul class="list-unstyled">
									<li><img src="images/favo1.png" class="img-responsive"></li>
									<li><img src="images/favo2.png" class="img-responsive"></li>
									<li><img src="images/favo3.png" class="img-responsive"></li>
									<li><img src="images/favo4.png" class="img-responsive"></li>
									<li><img src="images/favo5.png" class="img-responsive"></li>
									<li><img src="images/favo1.png" class="img-responsive"></li>
									<li><img src="images/favo2.png" class="img-responsive"></li>
									<li><img src="images/favo3.png" class="img-responsive"></li>
									<li><img src="images/favo4.png" class="img-responsive"></li>
									<li><img src="images/favo5.png" class="img-responsive"></li>
								</ul>
							</div>
					</div>
						<div class="panel-heading1" style="margin-left:10px;">My Favourite O-Shop</div>
					   		<ul>
					   		
						   		<li class="fvshop no-margin">Pandora</li>
						   		<li class="fvshop no-margin">Pasificia</li>
						   		<li class="fvshop no-margin">Kaiser Restaurent </li>
						   		<li class="fvshop no-margin"> ZARA City </li>
						   		<li class="fvshop no-margin">574 workwear</li>
				
							</ul>
				  		</div>
				</div>
			</div>
			  <div class="row">
			  		 <div class="col-md-1"></div>
					  <div class="table-responsive col-md-11  col-xs-12">
					<table class="table text-muted ">
					<tr class="bg-black no-margin">
					  <th class="no-margin" colspan="10">Product Details</th>
					</tr>
					<tr class="bg-black">
					  <th>Order ID</th>
					  <th>Product ID</th>
					  <th>Order Recieved</th>
					  <th>Order Executed</th>
					  <th>SKU</th>
					  <th>Description</th>
					  <th>Quantity</th>
					  <th>Price</th>
					  <th>User ID(Buyer)</th>
					  <th>Source</th>
					</tr>
					
						@foreach($products as $p)
							<tr>
								<td>{{$p['oid']}}</td>
								<td>{{$p['sku']}}</td>
								<td>{{$p['o_rcv']}}</td>
								<td>{{$p['o_exec']}}</td>
								<td>{{$p['sku']}}</td>
								<td>{{$p['pname']}}</td>
								<td>{{$p['quantity']}}</td>
								<td>{{$p['retail_price']}}</td>
								<td>{{$p['uid']}}</td>
								<td>{{$p['source']}}</td>
							</tr>
						@endforeach
						{{-- <tr>
						<td>ORDER0156</td>
						<td>P00514</td>
						<td>30 June 2015, 14.35</td>
						<td>30 June 2015, 15.00</td>
						<td>5</td>
						<td>MAX Sofa Bed-Blue with 10% Coupon</td>
						<td>1</td>
						<td>RM 790.00</td>
						<td>B096</td>
						<td>Furniture</td>
					</tr>
					<tr>
						<td>ORDER0156</td>
						<td>P00514</td>
						<td>30 June 2015, 14.35</td>
						<td>30 June 2015, 15.00</td>
						<td>5</td>
						<td>MAX Sofa Bed-Blue with 10% Coupon</td>
						<td>1</td>
						<td>RM 790.00</td>
						<td>B096</td>
						<td>Furniture</td>
					</tr> --}}

					</table>

					 </div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					 <div class="table-responsive col-md-11 col-xs-12">
					<table class="table text-muted ">
					<tr class="bg-purple">
					  <th colspan="10">Shipping Details</th>
					</tr>
					<tr class="bg-purple">
					  <th>Shipping ID</th>
					  <th>Company</th>
					  <th>Status</th>
					  <th>Days since ordered</th>
					</tr>
					@foreach($couriers as $c)
						<tr>
							<td> {{$c->shipping_id}}</td>
							<td> {{$c->name}}</td>
							<td> {{$c->description}}</td>
							
							<td> {{$c->created_at}}</td>
							
						</tr>
					@endforeach
			
					</table>

					 </div>
				</div>
				<div class="row">
					<div class="col-md-1"> </div>
					  <div class="table-responsive col-md-11 ">
					<table class="table text-muted ">
					<tr class="bg-parrot">
					  <th colspan="10">Coupon Details</th>
					</tr>
					<tr class="bg-parrot">
					  <th>Order ID</th>
					  <th>Product ID</th>
					  <th>Order Recieved</th>
					  <th>Order Executed</th>
					  <th>SKU</th>
					  <th>Description</th>
					  <th>Quantity</th>
					  <th>Price</th>
					  <th>User ID(Buyer)</th>
					  <th>Source</th>
					</tr>
					{{-- <tr>
						<td>ORDER0156</td>
						<td>P00514</td>
						<td>30 June 2015, 14.35</td>
						<td>30 June 2015, 15.00</td>
						<td>5</td>
						<td>MAX Sofa Bed-Blue with 10% Coupon</td>
						<td>1</td>
						<td>RM 790.00</td>
						<td>B096</td>
						<td>Furniture</td>
					</tr> --}}
					</table>
					 </div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					 <div class="table-responsive col-md-11">
					<table class="table text-muted ">
					<tr class="bg-darkgreen">
					  <th colspan="3">AutoLink Database</th>
					  <th colspan="4">Interior</th>
					  <th colspan="4">Responder</th>
					</tr>
					<tr class="bg-darkgreen">
					  <th>NO</th>
					  <th>AutoLink ID</th>
					  <th>Mode</th>
					  <th>ID</th>
					  <th>Name</th>
					  <th>Bought</th>
					  <th>Sold</th>
					  <th>ID</th>
					  <th>Name</th>
					  <th>Bought</th>
					  <th>Sold</th>
					</tr>
					<?php $j=1;?>
					@foreach($autolinks as $link)
						<tr>
							<td>{{$j}}</td>
							<td>{{$link['id']}}</td>
							<td>{{$link['mode']}}</td>
							<td>{{$link['iid']}}</td>
							<td>{{$link['iname']}}</td>
							<td>MYR {{$link['ibought']}}</td>
							<td>MYR {{$link['isold']}}</td>
							<td>{{$link['rid']}}</td>
							<td>{{$link['rname']}}</td>
							<td>MYR {{$link['rbought']}}</td>
							<td>MYR {{$link['rsold']}}</td>
				
						</tr>

						<?php $j++; ?>
					@endforeach
				

					</table>
					 </div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					 <div class="table-responsive col-md-11 ">
					<table class="table text-muted ">
					<tr class="bg-darkgreen">
					  <th colspan="11">AutoLink Database</th>
					</tr>
					<tr class="bg-darkgreen">
					  <th>No</th>
					  <th>AutoLink ID</th>
					  <th>ID</th>
					  <th>Category</th>
					  <th>SubCategory</th>
					  <th>Target</th>
					  <th>Linked Since</th>
					  <th>Status</th>
					  <th>Type</th>
					  <th>Action</th>
					  <th>Merchant Remarks</th>
					</tr>
					<?php $i=1;?>
					@foreach($autolinks as $link)
						<tr><td>{{$i}}</td>
							<td id="autolink" val="{{$link['id']}}">{{$link['id']}}</td>
							<td>{{$link['iid']}}</td>
							<td>{{$link['cat']}}</td>
							<td>{{$link['subcat']}}</td>
							<td>Target</td>
							<td>{{$link['l_s']}}</td>
							<td>{{$link['status']}}</td>
							<td>{{$link['itype']}}</td>

							<td>
							{{-- Add a logic to check if iid == userid --}}
							<span id= "action_area">
								@if($link['status']=='request') 
								<button type="button" class="btn btn-primary btn-success" id="accept" data-value="{{$link['id']}}"><span class="glyphicon glyphicon-ok"></span> </button>
								<button type="button" class="btn btn-primary btn-warning" id="req_delete" data-value=
								"{{$link['id']}}"><span class="glyphicon glyphicon-trash"></span> </button>
								@else
								<button type= "button" class="btn btn-primary btn-danger" id="link_delete" data-value="{{$link['id']}}"><span class="glyphicon glyphicon-remove"></span> </button>
								@endif
							</td>
							</span>
								<td> 
								
									
								</td>
								{{-- <td><button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-check"></span> Approve</button></td> --}}
							
							<td>{{$link['remarks']}}</td>

						<?php $i++; ?>
					@endforeach
					<tr>
						<td>1</td>
						<td>P00514</td>
						<td>OS453</td>
						<td>Lorem</td>
						<td>5</td>
						<td>-N/A</td>
						<td>1</td>
						<td>RM 790.00</td>
						<td>Buyer </td>
						<td><a class="btn-darkgreen">Unlink</a> <i onclick="$(this).parent().parent().remove();" class="glyphicon glyphicon-remove text-danger"></i></td>
						<td></td>
					</tr>
					<tr>
						<td>2</td>
						<td>P00514</td>
						<td>OS453</td>
						<td>Lorem</td>
						<td>5</td>
						<td>-N/A</td>
						<td>1</td>
						<td>RM 790.00</td>
						<td>Dealer </td>
						<td><a class="btn-darkgreen">Unlink</a> <i onclick="$(this).parent().parent().remove();" class="glyphicon glyphicon-remove text-danger"></i></td>
						<td></td>
					</tr>
					<tr>
						<td>3</td>
						<td>P00514</td>
						<td>OS453</td>
						<td>Lorem</td>
						<td>5</td>
						<td>Architect</td>
						<td>1</td>
						<td>RM 790.00</td>
						<td>Buyer </td>
						<td><a class="btn-darkgreen">Approve </a> &nbsp; <a class="btn-darkgreen">Deny </a>
							<i onclick="$(this).parent().parent().remove();" class="glyphicon glyphicon-remove text-danger"></i></td>
						<td></td>
					</tr>

					</table>
					  </div>

				 </div>
			 </div>
				{{-- <hr> --}}
				{{-- OpenWish --}}
				<div class="row">
					<div class="col-md-1"> </div>
					<div  id ="open-wish" class="col-md-11">
						<div class="row">
							<a class="btn btn-pink col-md-2" href="#"> OpenWish</a>	
						</div>
						
						<div class="row">
							<div class="col-md-8">
								<div class="row">
									<label><em>New Wishes:</em></label>
								</div>
								<div class="row">
									<div class="col-md-3 item-box">
										<a href="#"> <img class="img-responsive" src="images/item1.png" alt="item" ></a>
										 <div class="pull-left">Lorem Ipsum 574</div><div class="pull-right">FM380</div>  
							 			<div class="clearfix"></div> 
							 			<div class="pull-left">PAM TTD <span class="bordered">RM300</span></div>
										 <div class="pull-right"><a class="btn-darkgreen">Ask for Help</a></div>
										   <div class="clearfix"> </div>

									     <div class="pull-left">Balance <span class="bordered">BM54</span></div>
										 <div class="pull-right"><a class="btn-darkgreen">Buy Now</a></div>
							
								  		<div class="clearfix"> </div>
									</div>
									<div class="col-md-3 item-box">
									    <a href="#">
									    <img class="img-responsive" src="images/item2.png" alt="item" >
									    </a>
									    <div class="pull-left">Lorem Ipsum 574</div>
									    <div class="pull-right">FM380</div>
									    <div class="clearfix"></div>
									    <div class="pull-left">PAM TTD 
									        <span class="bordered">RM300</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Ask for Help</a>
									    </div>
									    <div class="clearfix"></div>
									    <div class="pull-left">Balance 
									        <span class="bordered">BM54</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Buy Now</a>
									    </div>
									    <div class="clearfix"></div>
									</div>
									<div class="col-md-3 item-box">
									 
								   		<a href="#">
									    <img class="img-responsive" src="images/item3.png" alt="item" >
									    </a>
									    <div class="pull-left">Lorem Ipsum 574</div>
									    <div class="pull-right">FM380</div>
									    <div class="clearfix"></div>
									    <div class="pull-left">PAM TTD 
									        <span class="bordered">RM300</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Ask for Help</a>
									    </div>
									    <div class="clearfix"></div>
									    <div class="pull-left">Balance 
									        <span class="bordered">BM54</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Buy Now</a>
									    </div>
									    <div class="clearfix"></div>
									</div>
									<div class="col-md-3 item-box">
										 
										<a href="#">
										    <img class="img-responsive" src="images/item4.png" alt="item" >
										    </a>
										    <div class="pull-left">Lorem Ipsum 574</div>
										    <div class="pull-right">FM380</div>
										    <div class="clearfix"></div>
										    <div class="pull-left">PAM TTD 
										        <span class="bordered">RM300</span>
										    </div>
										    <div class="pull-right">
										        <a class="btn-darkgreen">Ask for Help</a>
										    </div>
										    <div class="clearfix"></div>
										    <div class="pull-left">Balance 
										        <span class="bordered">BM54</span>
										    </div>
										    <div class="pull-right">
										        <a class="btn-darkgreen">Buy Now</a>
										    </div>
										    <div class="clearfix"></div>
									</div>
							</div>
							{{-- Row Ends --}}
							<div class="row"><label><em>History:</em></label></div>
							{{-- Row --}}
							<div class="row">
								<div class="col-md-3 item-box">
										<a href="#"> <img class="img-responsive" src="images/item1.png" alt="item" ></a>
										 <div class="pull-left">Lorem Ipsum 574</div><div class="pull-right">FM380</div>  
							 			<div class="clearfix"></div> 
							 			<div class="pull-left">PAM TTD <span class="bordered">RM300</span></div>
										 <div class="pull-right"><a class="btn-darkgreen">Ask for Help</a></div>
										   <div class="clearfix"> </div>

									     <div class="pull-left">Balance <span class="bordered">BM54</span></div>
										 <div class="pull-right"><a class="btn-darkgreen">Buy Now</a></div>
							
								  		<div class="clearfix"> </div>
								</div>
								<div class="col-md-3 item-box">
									    <a href="#">
									    <img class="img-responsive" src="images/item2.png" alt="item" >
									    </a>
									    <div class="pull-left">Lorem Ipsum 574</div>
									    <div class="pull-right">FM380</div>
									    <div class="clearfix"></div>
									    <div class="pull-left">PAM TTD 
									        <span class="bordered">RM300</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Ask for Help</a>
									    </div>
									    <div class="clearfix"></div>
									    <div class="pull-left">Balance 
									        <span class="bordered">BM54</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Buy Now</a>
									    </div>
									    <div class="clearfix"></div>
								</div>
								<div class="col-md-3 item-box">
									 
								    <a href="#">
								    <img class="img-responsive" src="images/item3.png" alt="item" >
								    </a>
								    <div class="pull-left">Lorem Ipsum 574</div>
								    <div class="pull-right">FM380</div>
								    <div class="clearfix"></div>
								    <div class="pull-left">PAM TTD 
								        <span class="bordered">RM300</span>
								    </div>
								    <div class="pull-right">
								        <a class="btn-darkgreen">Ask for Help</a>
								    </div>
								    <div class="clearfix"></div>
								    <div class="pull-left">Balance 
								        <span class="bordered">BM54</span>
								    </div>
								    <div class="pull-right">
								        <a class="btn-darkgreen">Buy Now</a>
								    </div>
								    <div class="clearfix"></div>
								</div>
								<div class="col-md-3 item-box">
									 
									<a href="#">
									    <img class="img-responsive" src="images/item4.png" alt="item" >
									    </a>
									    <div class="pull-left">Lorem Ipsum 574</div>
									    <div class="pull-right">FM380</div>
									    <div class="clearfix"></div>
									    <div class="pull-left">PAM TTD 
									        <span class="bordered">RM300</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Ask for Help</a>
									    </div>
									    <div class="clearfix"></div>
									    <div class="pull-left">Balance 
									        <span class="bordered">BM54</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Buy Now</a>
									    </div>
									    <div class="clearfix"></div>
								</div>
							</div>
							{{-- Row --}}
							</div> 
							{{-- col --}}
							<div class="col-md-4">
								<h1>You may also like</h1>
									<div id="itembrands">
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p1.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p2.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p3.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p4.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p5.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p6.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p7.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p8.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p9.png" alt="item" ></a>
									</div>
								  </div>
							</div>
							{{-- Col --}}
						</div>	
						</div>

					</div>
						
				{{-- </div> --}}
				{{-- Access Token Management --}}
	              <script type="text/javascript">
                            $(document).ready(function () {


                                $('.popup_fb_test').click(function () {
                                    newwindow = window.open("{{URL::route('testfbtoken')}}", 'Token Status', 'height=200,width=350');
                                    if (window.focus) {
                                        newwindow.focus()
                                    }
                                    setTimeout(function () {
                                        newwindow
                                                .close();
                                    }, 30000);
                                    return false;
                                });
                                $('.popup_fb_token').click(function () {
                                    newwindow = window.open("{{URL::route('fbtoken')}}", 'Link Token', 'height=400,width=auto');
                                    if (window.focus) {
                                        newwindow.focus()
                                    }
                                    return false;
                                });

                            });
                        </script>
					<div class="row">
					<div class="col-md-1"> </div>
					<div class="col-md-11">
						<div class="row">
				 		<a href="#" id ="smm" class="btn btn-blue col-md-3">Access Management</a>	
				 		<div id="clearfix"></div>
				 		</div>
				 		<div class="row bottom-margin-md">
				 			<h4>Facebook</h4>
				 			<button type="button" class="btn btn-primary  popup_fb_test"><span class="glyphicon glyphicon-thumbs-up"></span> Test</button>
				 				<button type="button" class="btn btn-primary  popup_fb_token"><span class="glyphicon glyphicon-link"></span> Link</button>
				 		</div>
					</div>
				</div>
				{{-- Access Token Management Portion Ends --}}

				{{-- OpenWish Ends --}}
							{{-- Auction Starts --}}
		
					{{-- Main col ends --}}
				
							{{-- Auction Ends --}}

						{{-- 	<div id="auctions" class="row" >
							<div class="col-md-1"> </div>
							<div class="col-md-11"> 
									<a href="#" class="btn btn-success col-md-2"><i class="fa fa-legal"></i> Auctions</a>			 
							</div>
							<div class="row">
							<div class="col-md-1"> </div>
								<div class="col-md-4 auction-item">
									<div class="row">
										<div class="col-md-5">
											<div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
												<h4 class="big-text pull-left"> RM</h4>
												<div class="clearfix"> </div>
											</div>
											<h1 class="large-text">100</h1>
											<h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>


										</div>
										<div class="col-md-7">
											<a href="#"><img alt="auction" src="images/auction.png" class="auction img-responsive"></a>
											<a href="#"><img class="img-responsive" src="images/radio.jpg" alt="auction-item"></a>
										</div>
										<div class="clearfix margin-top"> </div>
										<label class="col-md-2 control-label">BID: </label>
										<div class="col-md-10">
											<select class="selectpicker form-control">
												<option>MYR</option>
											</select>
										</div>
										<div class="clearfix margin-top"> </div>
										<div class="col-md-12">
											<ul class="list-inline">
												<li><i class="fa fa-male big-text"></i> </li>
												<li>120 <br><small class="text-muted">Bidders</small></li>
												<li>Time Left<br><small class="text-muted">abcd Lorem Ipsum</small></li>
											</ul>
										</div>
									</div>
								</div>

								<div class="col-md-4 auction-item">
									<div class="row">
										<div class="col-md-5">
											<div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
												<h4 class="big-text pull-left"> RM</h4> <div class="clearfix"> </div></div>
											<h1 class="large-text">200</h1>
											<h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>


										</div>
										<div class="col-md-7">
											<a href="#"><img alt="auction" src="images/auction.png" class="auction img-responsive"></a>
											<a href="#"><img style="width:75%;" class="img-responsive" src="images/iphone6-gold-select-2014.jpg" alt="auction-item"></a>
										</div>
										<div class="clearfix margin-top"> </div>
										<label class="col-md-2 control-label">BID: </label>
										<div class="col-md-10">
											<select class="selectpicker form-control">
												<option>MYR</option>
											</select>
										</div>
										<div class="clearfix margin-top"> </div>
										<div class="col-md-12">
											<ul class="list-inline">
												<li><i class="fa fa-male big-text"></i> </li>
												<li>120 <br><small class="text-muted">Bidders</small></li>
												<li>Time Left<br><small class="text-muted">abcd Lorem Ipsum</small></li>
											</ul>
										</div>
									</div>
								</div>

								<div class="col-md-4 auction-item">
									<div class="row">
										<div class="col-md-5">
											<div class="media-heading"><h6 class="pull-left" style="padding-top: 5px">Start <br>From </h6>
												<h4 class="big-text pull-left"> RM</h4> <div class="clearfix"> </div></div>
											<h1 class="large-text">10</h1>
											<h5><small>Latest Pledge</small> <strong class="text-success pull-right">RM500</strong></h5>

										</div>
										<div class="col-md-7">
											<a href="#"><img alt="auction" src="images/auction.png" class="auction img-responsive"></a>
											<a href="#"><img class="img-responsive" src="images/watchCblack.jpg" alt="auction-item"></a>
										</div>
										<div class="clearfix margin-top"> </div>
										<label class="col-md-2 control-label">BID: </label>
										<div class="col-md-10">
											<select class="selectpicker form-control">
												<option>MYR</option>
											</select>
										</div>
										<div class="clearfix margin-top"> </div>
										<div class="col-md-12">
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
			<hr>
			 --}}
			 {{-- SMM --}}
			 <div  class="row">
			 	<div class="col-md-1"></div>
			 	<div class="col-md-11"> 
				 	<div class="row bottom-margin-md">
				 		<a href="#" id ="smm" class="btn btn-blue col-md-3"><i class="glyphicon glyphicon-tower"></i> Social Media Marketeer</a>	
				 		<div id="clearfix"></div>
				 	</div>
				 	<div class="row"> 
				 	<div class="col-md-4"> 
			 		   	 <table class="table noborder no-margin">
		                    <tr><th colspan="2">Overall</th></tr>
		                    <tr><td>Shared</td><td>30</td></tr>
		                    <tr><td>Viewed Click</td><td>20000</td></tr>
		                    <tr><td>Bought</td><td>MYR 41,000,00</td></tr>
		                    <tr><td></td><td>400</td></tr>
                 		</table>
				 	</div>
			 	 	<div class="col-md-4"> 
			 	 	<table class="table noborder no-margin">
						<tr><th colspan="2">Commision</th></tr>	
						<tr><td>Earned Since</td><td>MYR 20,000,00</td></tr>	
						<tr><td>Earned YTD</td><td>MYR 10,000,00</td></tr>	
						<tr><td>Pending</td><td>MYR 205,00</td></tr>	
						<tr><td>&nbsp</td></tr>
						</table>
			 	 	</div>
		 	 	 	<div class="col-md-4"> 
		 	 	 						<select class="margin-top selectpicker show-menu-arrow form-control" data-style="btn-darkgreen" >
			<option>Great Sales</option></select>
			  <div class="margin-top ">
			  <div class="col-md-5 btn-facebook">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1">
			<label class=""> Facebook</label>
			</div>
			</div>
			
			<div class="col-md-5 col-md-offset-2 btn-twitter">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1">
			<label class="btn-twitter"> Twitter</label>
			</div>
			</div>
			 <div class="clearfix"> </div>
			 </div>
			 
			  <div class="margin-top ">
			  
			<div class="col-md-5 btn-linkedin">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1">
			<label class=""> Linked In</label>
			</div>
			 
			</div>
			
			<div class="col-md-5 col-md-offset-2 btn-gplus">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1">
			<label class=""> Google+</label>
			</div>
			</div>
			 <div class="clearfix"> </div>
			  
			  </div>
			 
			    <div class="margin-top ">
				<div class="col-md-5 btn-instagram">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1">
			<label class=""> Instagram</label>
			</div>
			</div>
			<div class="col-md-5 col-md-offset-2 btn-wechat">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1">
			<label class=""> WeChat</label>
			</div>
			</div>
			 <div class="clearfix"> </div>
			 </div>
			  <div class="margin-top">
			  <div class="col-md-5 btn-weibo">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1">
			<label class=""> Weibo</label>
		 	 	 	</div>
				 	</div>
			 	</div>
			 </div>
			 {{--  --}}
			
			 
			  <div class="clearfix"> </div>

                    <?php $block = 0; ?>
                    @if(!empty($smmProducts))
                        @foreach($smmProducts as $product)
                            <?php $block++; ?>
                            <div class="margin-top">
                                <div class="col-md-2 thumbnail">
                                    <img src="{{ asset('/images/product/'.$product->product_id.'/'.$product->photo_1) }}" class="img-responsive">
                                    <h5>{{ $product->product_name }} <strong class="pull-right">{{ $product->original_price }}</strong></h5>
                                </div>
                                <div class="col-md-3">
                                    <table class="table noborder">
                                        <tr><th colspan="2">Overall</th></tr>
                                        <tr><td>Shared</td><td>30</td></tr>
                                        <tr><td>Viewed Click</td><td>{{ $product->view_clicks }}</td></tr>
                                        <tr><td>Bought</td><td>MYR {{ $product->buy_clicks * $product->original_priice }}</td></tr>
                                        <tr><td>Unit</td><td>400</td></tr>
                                    </table>
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}"/>
                                    @if($product->number_shared <= globalSettings('smm_max_post'))
                                        <a class="btn btn-darkgreen pull-right btn-lg smedia-marketer">Send</a>
                                    @else
                                        <span>You have completed the number of shares</span>
                                    @endif
                                </div>
                            </div>
                            @if($block % 2 == 0)
                                <div class="clearfix"></div>
                            @endif
                        @endforeach
                    @endif

			  </div>
			 {{-- <hr> --}}
				{{-- <div id="autolink" class="row">
					<div class="col-xs-12">
						<a class="btn btn-darkgreen col-md-2" href="#">
							<i class="bt glyphicon glyphicon-link" style="padding: 6px 0"></i> AutoLink</a>
						<div class="input-group input-group-sm col-md-3 btn btn-darkgreen">
							<input type="text" placeholder="Tech_" class="form-control">
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-darkgreen"><span class="glyphicon glyphicon-triangle-right"></span></button>
                                      </span>
						</div>
					</div>
					<div class="clearfix margin-top"> </div>
					<div class="col-md-3">
						<label><em>Target:</em></label>
						<select multiple class="select-darkgreen form-control">
							<option>Architect</option>
							<option>Developer</option>
							<option class="active">Interior Designer</option>
						</select>
					</div>
					<div class="col-md-3">
						<label>Others:</label>
						<div class="col-md-12 bg-darkgreen">

							<div class="input-group input-group-sm margin-top">
								<input type="text" placeholder="fill in the blank" class="form-control">
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-darkgreen"><span class="glyphicon glyphicon-triangle-right"></span></button>
                                      </span>
							</div>

						</div>
						<div class="clearfix margin-top"></div>
						<select multiple class="select-darkgreen  form-control" style="font-family: FontAwesome">
							<option class="active" onclick="$(this).remove();">&#xf00d; Architect</option>
							<option onclick="$(this).remove();">&#xf00d; Interior Designer</option>
						</select>
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-12 margin-top">
						<label>Target O-Shop:</label>
					</div>
					<div class="col-md-3">
						<label>Category</label>
						<select multiple class="select-darkgreen  form-control">
							<option class="active">Architect</option>
							<option>Developer</option>
							<option>Interior Designer</option>
						</select>
					</div>
					<div class="col-md-3">
						<label>Sub Category</label>
						<select multiple class="select-darkgreen form-control">
							<option>Architect</option>
							<option class="active">Developer</option>
							<option>Interior Designer</option>
						</select>
					</div>
					<div class="col-md-4">
						<label>&nbsp;</label>
						<select multiple class="select-darkgreen form-control"  style="font-family: FontAwesome">
							<option onclick="$(this).remove();">&#xf00d; Architect</option>
							<option onclick="$(this).remove();">&#xf00d; Developer</option>
						</select>
					</div>

					<div class="clearfix"></div>

				</div> --}}
			  {{-- <hr> --}}
			  {{-- OPEN BUSINESS --}}
			  </div>	
			  </div>
			  <div id="open-biss" class="row">
			  	<div class="col-md-1"></div>
			  	<div class="col-md-11">
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
								  <label class="col-md-4 control-label">Account Name </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control">
								    </div>
								   
								   <label class="col-md-4 control-label">Account Number </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control">
								    </div>
								  
								  <label class="col-md-4 control-label">Bank Name</label>
								    <div class="col-md-8">
								      <input type="text" class="form-control">
								    </div>
								   
								   <label class="col-md-4 control-label">Bank Code </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control">
								    </div>
								   
								   <label class="col-md-4 control-label">IBAN </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control">
								    </div>
								    
									<label class="col-md-4 control-label bottom-margin-md">SWIFT </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control">
								    </div>
									
								    </div>
						</div>
					 	<div class="col-md-6"></div>
					 </div>
			  	</div>
			  		
			  	</div>
			  	<div class="row">
			  	<div class="col-md-8"></div>
			  	<div class="col-md-1"></div>
			  	<div class="col-md-2 bottom-margin-md"><input type="submit" class="form-control btn btn-primary pull-right" value="Add Details"><p></p> </div>
			  </div>
			  {{--  --}}
		{{-- 	 <div id="open-biss" class="row">
			
			<div class="col-xs-12"> 		
				<a class="btn btn-orange col-md-2" href="#"><i class="fa fa-suitcase"></i> Open Business</a>		 
			 </div>  <div class="clearfix"></div>
			
			
			   <div class="col-md-5">
			  <div class="form-group">
			 
					<label class="col-md-12 control-label">&nbsp;</label>
					
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
			  
			  <div class="col-md-6 col-md-offset-1">
				
			 
 <h1>Bank Details</h1>
  <div class="form-group">  
  <label class="col-md-4 control-label">Account Name </label>
    <div class="col-md-8">
      <input type="text" class="form-control">
    </div>
   
   <label class="col-md-4 control-label">Account Number </label>
    <div class="col-md-8">
      <input type="text" class="form-control">
    </div>
  
  <label class="col-md-4 control-label">Bank Name</label>
    <div class="col-md-8">
      <input type="text" class="form-control">
    </div>
   
   <label class="col-md-4 control-label">Bank Code </label>
    <div class="col-md-8">
      <input type="text" class="form-control">
    </div>
   
   <label class="col-md-4 control-label">IBAN </label>
    <div class="col-md-8">
      <input type="text" class="form-control">
    </div>
    
	<label class="col-md-4 control-label">SWIFT </label>
    <div class="col-md-8">
      <input type="text" class="form-control">
    </div>
	
    </div>
			  </div>
			  
			  <div class="clearfix"></div>
			 			 
			 </div> --}}
			 {{-- <hr> --}}
			 {{--  --}}
			{{--  <div id="new" class="row">
			 
			<div class="col-xs-12"> 		
				<a class="btn btn-darkgreen col-md-3" href="#"><i class="fa fa-gift"></i> New OpenSupermall</a>		 
			 </div>  <div class="clearfix"></div>
			<div class="margin-top"> 
			<div class="col-md-3"> 
			<img src="images/item1.png" class="img-responsive">
			<h5>Designer Watch <strong class="pull-right strikethrough">RM 700</strong></h5>
			<ul class="list-inline pull-left">
			<li class="btn-darkgreen"><i class="fa fa-plus"></i></li>
			<li class="btn-pink"><i class="fa fa-heart"></i></li>
			<li class="btn-orange"><i class="fa fa-shopping-cart"></i></li>
			</ul>
			<strong class="discounted-price pull-right text-danger">RM 580<br> -20%</strong>
			 <div class="clearfix"> </div>
			</div>
			<div class="col-md-3"> 
			<img src="images/item1.png" class="img-responsive">
			<h5>Designer Watch <strong class="pull-right">RM 700</strong></h5>
			<ul class="list-inline pull-left">
			<li class="btn-darkgreen"><i class="fa fa-plus"></i></li>
			<li class="btn-pink"><i class="fa fa-heart"></i></li>
			<li class="btn-orange"><i class="fa fa-shopping-cart"></i></li>
			</ul>
			 <div class="clearfix"> </div>
			</div>
			<div class="col-md-3"> 
			<img src="images/item1.png" class="img-responsive">
			<h5>Designer Watch <strong class="pull-right strikethrough">RM 700</strong></h5>
			<ul class="list-inline pull-left">
			<li class="btn-darkgreen"><i class="fa fa-plus"></i></li>
			<li class="btn-pink"><i class="fa fa-heart"></i></li>
			<li class="btn-orange"><i class="fa fa-shopping-cart"></i></li>
			</ul>
			<strong class="discounted-price pull-right text-danger">RM 580<br> -20%</strong>
			 <div class="clearfix"> </div>
			</div>
			
			<div class="col-md-3"> 
			<img src="images/item1.png" class="img-responsive">
			<h5>Designer Watch <strong class="pull-right">RM 700</strong></h5>
			<ul class="list-inline pull-left">
			<li class="btn-darkgreen"><i class="fa fa-plus"></i></li>
			<li class="btn-pink"><i class="fa fa-heart"></i></li>
			<li class="btn-orange"><i class="fa fa-shopping-cart"></i></li>
			</ul>
			 <div class="clearfix"> </div>
			</div>
			 <div class="clearfix"></div>
			 			 
			 </div>
		
			
			<div class="margin-top"> 
			<div class="col-md-3"> 
			<img src="images/item1.png" class="img-responsive">
			<h5>Designer Watch <strong class="pull-right strikethrough">RM 700</strong></h5>
			<ul class="list-inline pull-left">
			<li class="btn-darkgreen"><i class="fa fa-plus"></i></li>
			<li class="btn-pink"><i class="fa fa-heart"></i></li>
			<li class="btn-orange"><i class="fa fa-shopping-cart"></i></li>
			</ul> 
			<strong class="discounted-price pull-right text-danger">RM 580<br> -20%</strong>
			<div class="clearfix"> </div>
			</div>
			<div class="col-md-3"> 
			<img src="images/item1.png" class="img-responsive">
			<h5>Designer Watch <strong class="pull-right">RM 700</strong></h5>
			<ul class="list-inline pull-left">
			<li class="btn-darkgreen"><i class="fa fa-plus"></i></li>
			<li class="btn-pink"><i class="fa fa-heart"></i></li>
			<li class="btn-orange"><i class="fa fa-shopping-cart"></i></li>
			</ul>
			 <div class="clearfix"> </div>
			</div>
			<div class="col-md-3"> 
			<img src="images/item1.png" class="img-responsive">
			<h5>Designer Watch <strong class="pull-right strikethrough">RM 700</strong></h5>
			<ul class="list-inline pull-left">
			<li class="btn-darkgreen"><i class="fa fa-plus"></i></li>
			<li class="btn-pink"><i class="fa fa-heart"></i></li>
			<li class="btn-orange"><i class="fa fa-shopping-cart"></i></li>
			</ul>
			<strong class="discounted-price pull-right text-danger">RM 580<br> -20%</strong>
			 <div class="clearfix"> </div>
			 </div>
			
			<div class="col-md-3"> 
			<img src="images/item1.png" class="img-responsive">
			<h5>Designer Watch <strong class="pull-right">RM 700</strong></h5>
			<ul class="list-inline pull-left">
			<li class="btn-darkgreen"><i class="fa fa-plus"></i></li>
			<li class="btn-pink"><i class="fa fa-heart"></i></li>
			<li class="btn-orange"><i class="fa fa-shopping-cart"></i></li>
			</ul>
			 <div class="clearfix"> </div>
			</div>
			 <div class="clearfix"></div>
			 			 
			 </div>
			 </div> --}}
	 
	 
</form>


			</div>
		</div>		
	</div><!--End main cotainer-->
</section>
@stop
