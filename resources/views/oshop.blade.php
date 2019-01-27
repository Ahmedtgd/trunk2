<?php
	use App\Http\Controllers\UtilityController;
	use App\Http\Controllers\PriceController;
	use App\Http\Controllers\IdController;
?>
<?php 
	$qr = DB::table('oshopqr')->join('qr_management','qr_management.id','=','oshopqr.qr_management_id')
	->where('oshop_id',$oshop_id)->orderBy('oshopqr.id','DESC')->first();
?>
<?php $w =0; $wp =0; ?>
@extends('common.default')
@section('extra-links')
    <link rel="stylesheet" type="text/css" href="{{asset('css/productbox.css')}}" )>
    <script type="text/javascript" src="{{asset('js/autolink.js')}}"></script>
	<style>
/*SMM*/
    .productbox{
        margin-right: 0px;
    }
    .selected{
        border: 1px green solid;
    }

	thead tr td.special_price_row {
		padding: 0px;
		font-size: 12px;
	}

/*SMM ENDS*/

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

    .cat-img {
        padding: 0px;
        min-height: 220px;
    }

    .cat-img img {
        height: 200px !important;
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
		.btn-subcat{
            border: none;
            background: #fff;
            padding-left: 0px;
        }
		
		@media only screen and (max-width: 500px) {
			.signboard{
				display: none;
			}
			.leftnavbar{
				display: none;
			}
			.formattedid{
				font-size: 14px;
				display: none;
			}
			.calid{
				font-size: 16px !important;
			}
			.onlytab{
				display: none !important;
			}
			#tab-list{
				height: 100px !important;
			}
		}		
		@media only screen and (max-width: 400px) {
			.breadcrumb{
				display: none;
			}
			.mqr{
				float: right!important;
			}
		}
		.dropdown-content-omenu {
			display: none;
			position: absolute;
			background-color: rgba(0,0,0,0.8);
			width: 99%;
			margin-top: -2px;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			z-index: 6;
		}		
	</style>
@stop

@def $currency = \App\Models\Currency::where('active',1)->first()->code;
<?php $oshop = \App\Models\Oshop::find($oshop_id); ?>

@section('content')

	<input type="hidden" value="{{$id}}" id="oshop_id" >
	<input type="hidden" value="{{$oshop_id}}" id="real_oshop_id" >
	<div class="container-fluid" style="min-height: 500px;">
        <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
				aria-hidden="true">&times;</span></button>
            <strong class='cart-info'></strong>
        </div>
        {{-- ^ No need maybe? --}}
     <div class="row">
		<div class="col-xs-12 mobile"style="background-color: black; margin-top: -2px;">
			<p style="color: #73D2C6; float: left; font-size: 22px;">OFFICIAL SHOP</p><span style="color: #73D2C6; font-size: 22px;" class="glyphicon glyphicon-triangle-bottom pull-right omobilemenu" onclick=""></span>
		</div>
		<div class="clearfix"></div>
		<div class="dropdown-content-omenu">
			<div class="col-xs-12 no-padding" style="padding: 2px !important; text-center">
				<p style="color: #73D2C6 !important; font-size: 18px;">O-Shop&nbsp;ID <b style="color: #FFF !important;">{{IdController::nOshop($oshop_id)}}</b></p>				
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" style="padding: 2px !important; text-center">
				@if(!is_null($qr))
					<img src="{{URL::to('/')}}/images/qr/oshop/{{$oshop_id}}/{{$qr->image_path}}.png" width="100px" />
				@endif
			</div>
			<div class="col-xs-2 no-padding" style="padding: 2px !important; text-center">
				<img style="width:30px; height:20px; margin-top: -4px;"
				src="{{ asset('images/malaysia.png') }}">
			</div>
			<div class="col-xs-6 no-padding" style="padding: 2px !important; text-center">
				
				<p  style="color: #73D2C6 !important; font-size: 16px; font-weight: bold;">				
					@if (isset($oshop->oshop_name) &&
						$oshop->oshop_name == "Single")
						SINGLE
					@else
						OFFICIAL SHOP
				@endif
				</p>
			</div>
			<div class="clearfix"></div>
			<div class="mobilebotmenu2" style="padding: 5px 5px 0px 5px;">
				<hr class="mobilemenuhr">
			</div>
			<div class="col-xs-12 no-padding" style="padding: 2px !important; text-center">
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: bold;" rel="retail" class="chooseretail choose" href="javascript:void(0)">
						<a style="color: #73D2C6 !important;"  href="javascript:void(0)">Retail</a>
				</h3>		
				@if(count($categoriesb2b) > 0)
					<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" class="choose chooseb2b" rel="b2b" href="javascript:void(0)">
						<a style="color: #73D2C6 !important;"  href="javascript:void(0)">B2B</a>
					</h3>
				@else
					<h3 style="color: #2F4F4F !important; margin-top: 0px !important;" class=""   href="javascript:void(0)">
						<a style="color: #2F4F4F !important;"  href="javascript:void(0)">B2B</a>
					</h3>
				@endif
				@if(count($ow_product) > 0)
					<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" class="choosehyper choose" rel="hyper"  href="javascript:void(0)">
						<a style="color: #73D2C6 !important;"  href="javascript:void(0)">Hyper</a>
					</h3>
				@else
					<h3 style="color: #2F4F4F !important; margin-top: 0px !important;" class=""  href="javascript:void(0)">
						<a style="color: #2F4F4F !important;"  href="javascript:void(0)">Hyper</a>
					</h3>
				@endif
				@if(count($smmProducts) > 0)
					<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" class="choosesmm choose" rel="smm"  href="javascript:void(0)">
						<a style="color: #73D2C6 !important;"  href="javascript:void(0)">SMM</a>
					</h3>
				@else
					<h3 style="color: #2F4F4F !important; margin-top: 0px !important;" class="" href="javascript:void(0)">
						<a style="color: #2F4F4F !important;"  href="javascript:void(0)">SMM</a>
					</h3>
				@endif
			</div>	
			<div class="clearfix"></div>			
			<div class="mobilebotmenu2" style="padding: 5px 5px 0px 5px;">
				<hr class="mobilemenuhr">
			</div>
			<div class="mobilecategories oshopretail" style="padding: 0px 5px 5px 5px;">
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" class="all-filter" href="javascript:void(0)">
						All Products
					<span style="text-align:right;"> ({{ $count_products[0]->counter }})</span><span class="all-filter-fa" id="all_voucher_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>		
				</h3>			
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="categorytitle">Categories</span><span class="pull-right categoryoshop" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
				<div class="categoriesoshop" style="display: none;">
					@foreach($categories as $c)
						<div class="col-xs-10 no-padding">
							<h4 class="category-filter" href="javascript:void(0)" onclick="" rel="{{$c->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important;margin-left: 5px;">
								{{ $c->description }}
								<span style="text-align:right;color: #73D2C6 !important;"> ({{ $count_categoriesp[$w] }})</span><span class="category-filter-fa-{{$c->id}}" style="display:none; color: #73D2C6 !important;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
								
							</h4>
						</div>
						<div class="col-xs-2 no-padding">
							<span class="pull-right categoryoshopsing" rel="{{$c->id}}" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span>
						</div>
						<div id="categoryoshopsing{{$c->id}}" style="display: none;">
							@foreach($subcategoriesp[$w] as $subc)
									<h4 class="subcat-filter" style="color: #73D2C6 !important; margin-left: 10px;"  onclick="" href="javascript:void(0)" rel="{{$subc->id}}" >
										{{ $subc->description }} <span> ({{ $count_subcategoriesp[$wp] }})</span><span class="subcat-filter-fa-{{$subc->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></h4>
										
										<?php $wp++; ?>
							@endforeach
						</div>
						<?php $w++; ?>
					@endforeach
				</div>
				@if(!is_null($subcatlevels))
					<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="productstitle">Products</span><span class="pull-right productoshop" onclick="" ><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
					<div class="productsoshop" style="display: none;">
					@foreach($subcatlevels as $subcatleveldef)
						<h4 class="subcatlevel-filter"
							href="javascript:void(0)" onclick=""
							rel="{{$subcatleveldef->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 5px;">
							{{ $subcatleveldef->name }}
							<span style="text-align:right;">
							({{ $subcatleveldef->nprod }})</span>
							<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
							style="display:none;">
							<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
							@if(isset($subcatleves3[$subcatleveldef->id]))
							@foreach($subcatleves3[$subcatleveldef->id] as $subc)
								@if($subc->nprod > 0)
										<h4 class="subcatlevel3-filter"
										href="javascript:void(0)" onclick="" rel="{{$subc->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 10px;">
											{{ $subc->name }}
											<span> ({{ $subc->nprod }})
										<span class="subcatlevel3-filter-fa-{{$subc->id}}"
											style="display:none;">
											<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
											</i></span>		
										</h4>
																	
								@endif
							@endforeach
							@endif		
					@endforeach
					</div>
				@endif	
				@if(!is_null($brands))
					<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="brandtitle">Brands</span><span class="pull-right brandoshop" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
					<div class="brandsoshop" style="display: none;">
						@foreach($brands as $branddef)
						<h4 class="brand-filter" href="javascript:void(0)" onclick="" rel="{{$branddef->id}}"  style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 5px;">
							{{ $branddef->name }}
							<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
						
						@endforeach						
					</div>
				@endif	
			</div>
			<div class="mobilecategories oshopb2b" style="padding: 0px 5px 5px 5px; display: none;">
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" class="all-filter" href="javascript:void(0)">
						All Products
						<span style="text-align:right;"> ({{ $count_all_products }})</span><span class="all-filter-fa" id="all_b2b_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>		
				</h3>
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="categorytitleb2b">Categories</span><span class="pull-right categoryoshopb2b" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
				<?php $w =0; $wp =0; ?>
				<div class="categoriesoshopb2b" style="display: none;">
				@foreach($categoriesb2b as $cb2b)
					<div class="col-xs-10 no-padding">
						<h4 class="category-filter" href="javascript:void(0)" onclick="" rel="{{$cb2b->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important;margin-left: 5px;">
							{{ $cb2b->description }}
							<span style="text-align:right;"> ({{ $count_categoriespb2b[$w] }})</span><span class="category-filter-fa-{{$cb2b->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
					</div>
					<div class="col-xs-2 no-padding">
						<span class="pull-right categoryoshopsingb2b" rel="{{$cb2b->id}}" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span>
					</div>
					<div id="categoryoshopsingb2b{{$c->id}}" style="display: none;">
						@foreach($subcategoriespb2b[$w] as $scb2b)
							<h4 class="subcat-filter" style="color: #73D2C6 !important; margin-left: 10px;"  onclick="" href="javascript:void(0)" rel="{{$scb2b->id}}" >
									{{ $scb2b->description }}</a>
									<span> ({{ $count_subcategoriespb2b[$wp] }})</span><span class="subcat-filter-fa-{{$scb2b->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
								
							</h4>
							<?php $wp++; ?>
						@endforeach
					</div>
					<?php $w++; ?>

				@endforeach
				</div>

				@if(!is_null($subcatlevels_b2b))
					<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="productstitleb2b">Products</span><span class="pull-right productoshopb2b" onclick="" ><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
					<div class="productsoshopb2b" style="display: none;">
					@foreach($subcatlevels_b2b as $subcatleveldef)
						<h4 class="subcatlevel-filter"
							href="javascript:void(0)" onclick=""
							rel="{{$subcatleveldef->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 5px;">
							{{ $subcatleveldef->name }}
						
							<span style="text-align:right;">
								({{ $subcatleveldef->nprod }})</span>
							<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
							style="display:none;">
							<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
							@if(isset($subcatleves3[$subcatleveldef->id]))
							@foreach($subcatleves3[$subcatleveldef->id] as $subc)
								@if($subc->nprod > 0)
									<h4 class="subcatlevel3-filter"
										href="javascript:void(0)" onclick="" rel="{{$subc->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 10px;">
											{{ $subc->name }}</a>
											<span> ({{ $subc->nprod }})</span>
											<span class="subcatlevel3-filter-fa-{{$subc->id}}"
											style="display:none;">
											<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
											</i></span>							
									</h4>
								@endif
							@endforeach
							@endif		
					@endforeach	
					</div>
				@endif	
			
				@if(!is_null($brands_b2b))
					<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="brandtitleb2b">Brands</span><span class="pull-right brandoshopb2b" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
					<div class="brandsoshopb2b" style="display: none;">
						@foreach($brands_b2b as $branddef)
						<h4 class="brand-filter" href="javascript:void(0)" onclick="" rel="{{$branddef->id}}"  style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 5px;">
							{{ $branddef->name }}
							<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
						@endforeach	
					</div>
				@endif				
			</div>
			<div class="mobilecategories oshophyper" style="padding: 0px 5px 5px 5px; display: none;">
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" class="all-filter" href="javascript:void(0)">
						All Products
					</a><span style="text-align:right;"> ({{ $count_all_hyper }})</span><span class="all-filter-fa" id="all_hyper_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>		
				</h3>	
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="categorytitlehyper">Categories</span><span class="pull-right categoryoshophyper" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
				<?php $wsh =0; $wpsh =0; ?>
				<div class="categoriesoshophyper" style="display: none;">
				@foreach($categories_hyper as $c)
					<div class="col-xs-10 no-padding">
						<h4 class="category-filter" href="javascript:void(0)" onclick="" rel="{{$c->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important;margin-left: 5px;">
							{{ $c->description }}
						
						<span style="text-align:right;"> ({{ $count_categoriesp_hyper[$wsh] }})</span><span class="category-filter-fa-{{$c->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
					</div>
					<div class="col-xs-2 no-padding">
						<span class="pull-right categoryoshopsinghyper" rel="{{$c->id}}" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span>
					</div>					
					<div id="categoryoshopsinghyper{{$c->id}}" style="display: none;">
						@foreach($subcategoriesp_hyper[$wsh] as $subc)

							<h4 class="subcat-filter" style="color: #73D2C6 !important; margin-left: 10px;"  onclick="" href="javascript:void(0)" rel="{{$subc->id}}" >
									{{ $subc->description }}</a>
									<span> ({{ $count_subcategoriesp_hyper[$wpsh] }})</span><span class="subcat-filter-fa-{{$subc->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
									<?php $wpsh++; ?>
								
							</h4>

						@endforeach
					</div>		

					<?php $wsh++; ?>
				@endforeach	
				</div>
			@if(!is_null($subcatlevels_hyper))
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="productstitlehyper">Products</span><span class="pull-right productoshophyper" onclick="" ><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
				<div class="productsoshophyper" style="display: none;">
					@foreach($subcatlevels_hyper as $subcatleveldef)
						<h4 class="subcatlevel-filter"
							href="javascript:void(0)" onclick=""
							rel="{{$subcatleveldef->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 5px;">					
							{{ $subcatleveldef->name }}
						
							<span style="text-align:right;">
								({{ $subcatleveldef->nprod }})</span>
							<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
							style="display:none;">
							<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
							@if(isset($subcatleves3_hyper[$subcatleveldef->id]))
							@foreach($subcatleves3_hyper[$subcatleveldef->id] as $subc)
								@if($subc->nprod > 0)
									<h4 class="subcatlevel3-filter"
										href="javascript:void(0)" onclick="" rel="{{$subc->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 10px;">
											
											{{ $subc->name }}</a>
											<span> ({{ $subc->nprod }})</span>
											<span class="subcatlevel3-filter-fa-{{$subc->id}}"
											style="display:none;">
											<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
											</i></span>							
									</h4>
								@endif
							@endforeach
							@endif	
					@endforeach	
				</div>
			@endif

			@if(!is_null($brands_hyper))
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="brandtitlehyper">Brands</span><span class="pull-right brandoshophyper" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
				<div class="brandsoshophyper" style="display: none;">
					@foreach($brands_hyper as $branddef)
						<h4 class="brand-filter" href="javascript:void(0)" onclick="" rel="{{$branddef->id}}"  style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 5px;">
							{{ $branddef->name }}
						
							<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
					@endforeach	
				</div>
			@endif				
			</div>
			<div class="mobilecategories oshopsmm" style="padding: 0px 5px 5px 5px; display: none;">
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" class="all-filter" href="javascript:void(0)">
						All Products
					</a><span style="text-align:right;"> ({{ $count_all_smm_products }})</span><span class="all-filter-fa" id="all_smm_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>		
				</h3>
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="categorytitlesmm">Categories</span><span class="pull-right categoryoshopsmm" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
				<div class="categoriesoshopsmm" style="display: none;">
				<?php $ws =0; $wps =0; ?>
				@foreach($categories_smm as $c)
					<div class="col-xs-10 no-padding">
						<h4 class="category-filter" href="javascript:void(0)" onclick="" rel="{{$c->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important;margin-left: 5px;">
							{{ $c->description }}
						
						<span style="text-align:right;"> ({{ $count_categoriesp_smm[$ws] }})</span><span class="category-filter-fa-{{$c->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
					</div>
					<div class="col-xs-2 no-padding">
						<span class="pull-right categoryoshopsingsmm" rel="{{$c->id}}" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span>
					</div>	
					<div id="categoryoshopsingsmm{{$c->id}}" style="display: none;">
						@foreach($subcategoriesp_smm[$ws] as $subc)
							<h4 class="subcat-filter" style="color: #73D2C6 !important; margin-left: 10px;"  onclick="" href="javascript:void(0)" rel="{{$subc->id}}" >
									{{ $subc->description }}</a>
									<span> ({{ $count_subcategoriesp_smm[$wps] }})</span><span class="subcat-filter-fa-{{$subc->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
									<?php $wps++; ?>
								
							</h4>

						@endforeach
					</div>		


					<?php $ws++; ?>
				@endforeach	
				</div>
			@if(!is_null($subcatlevels_smm))
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="productstitlesmm">Products</span><span class="pull-right productoshopsmm" onclick="" ><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
				<div class="productsoshopsmm" style="display: none;">
					@foreach($subcatlevels_smm as $subcatleveldef)
						<h4 class="subcatlevel-filter"
							href="javascript:void(0)" onclick=""
							rel="{{$subcatleveldef->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 5px;">					
							{{ $subcatleveldef->name }}
						
							<span style="text-align:right;">
								({{ $subcatleveldef->nprod }})</span>
							<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
							style="display:none;">
							<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						</h4>
							@if(isset($subcatleves3_smm[$subcatleveldef->id]))
							@foreach($subcatleves3_smm[$subcatleveldef->id] as $subc)
								@if($subc->nprod > 0)
									<h4 class="subcatlevel3-filter"
										href="javascript:void(0)" onclick="" rel="{{$subc->id}}" style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 10px;">
											
											{{ $subc->name }}</a>
											<span> ({{ $subc->nprod }})</span>
											<span class="subcatlevel3-filter-fa-{{$subc->id}}"
											style="display:none;">
											<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
											</i></span>							
									</h4>
								@endif
							@endforeach
							@endif			
					@endforeach		
				</div>
			@endif
			
			@if(!is_null($brands_smm))
				<h3 style="color: #73D2C6 !important; margin-top: 0px !important;"><span class="brandtitlesmm">Brands</span><span class="pull-right brandoshopsmm" onclick=""><img src="{{asset('images/category/mobileplus.png')}}" width="25px"/></span></h3>
				<div class="brandsoshopsmm" style="display: none;">
				@foreach($brands_smm as $branddef)
					<h4 class="brand-filter" href="javascript:void(0)" onclick="" rel="{{$branddef->id}}"  style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: normal !important; margin-left: 5px;">
						{{ $branddef->name }}
					
						<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
					</h4>
				@endforeach	
				</div>
			@endif				
			</div>
		</div>		
		<div class="signboardmobile mobile">
			@if( isset($signboard->id))
				<img style="margin-top:-1px;object-fit:cover;height:100px;width:100%"
					class="width-100 img-responsive"
					src="{{ asset('images/signboard/'.
						$signboard->id .'/' .$signboard->image) }}"
					alt="
						@if (isset($oshop->oshop_name))
						{{ $oshop->oshop_name }}
						@endif
					Signboard"/>
			@endif
        </div>
        <div class="col-md-12">
                <div class="row signboard">
                    @if( isset($signboard->id))
						<img style="margin-top:-1px;object-fit:none;height:200px;width:100%"
							class="width-100 img-responsive"
							src="{{ asset('images/signboard/'.
								$signboard->id .'/' .$signboard->image) }}"
							alt="
								@if (isset($oshop->oshop_name))
								{{ $oshop->oshop_name }}
								@endif
							Signboard"/>
                    @endif
                </div>
				
                <div style="margin-top:0;" class="margin-top nomobile">@include('oshopnavigation')</div>
				@if( isset( $profile->vbanner->id ) )
					<div id="video" class="col-xs-12 margin-top video-banner nomobile">
						<div class="placeholder">
							<div id="block">
								<?php
								$path = explode(':', $profile->vbanner->image)[0];
								?>
								<span style="display: none"
									  class="videobanner">
									  @if($path == 'http' || $path == 'https')
										  {{$profile->vbanner->image}}
									  @else{{ asset('/images/vbanner/'.$profile->vbanner->id.'/'.
									  	$profile->vbanner->image)}}@endif
								</span>
							</div>
						</div>
					</div>
				@endif
                <?php $value = 4;$av = 12; $text = 25; $o = 3;?>
				<p style="float:left;" class="nomobile"><a style="color:#000; font-size: 23px;"
				href="{{route('oshop.one',[$oshop_url])}}" class="calid">
				@if (isset($oshop->oshop_name) &&
					$oshop->oshop_name == "Single")
					SINGLE
				@else
					OFFICIAL SHOP
				@endif
				</a>&nbsp; &nbsp;
				<img style="width:30px; height:20px; margin-top: -4px;"
				src="{{ asset('images/malaysia.png') }}">&nbsp; {!! Breadcrumbs::renderIfExists() !!}

				</p>
		@if(!is_null($qr))
			<img src="{{URL::to('/')}}/images/qr/oshop/{{$oshop_id}}/{{$qr->image_path}}.png" class="nomobile" style="margin-top: -10px;" class="mqr"  width="120px" />
		@endif				
		</div>
		<div class="clearfix"></div>
		<div class="col-md-15 col-md-3 leftnavbar" style="margin-left:5px">
			@include('leftNavbar')
		</div>
                {{-- Put products  under their section --}}
		<?php $issub = false;
			if(!is_null($subid)){
				$issub = true;
			}
		?>
        <div id="retail_product_content" class="col-md-9">
        	<div id="content-retail" class='content-tab'>
		        <div class="col-sm-12" style="margin-bottom:10px">
		            <div class="row">
		                <h2 class="nomobile" style="margin-left:8px;margin-bottom:0;margin-top:0">
						O-Shop 
						@if (isset($oshop->oshop_name) &&
							$oshop->oshop_name == "Single")
						   (Single)
						@endif 
						</h2>
		            </div>
					@include('product.oshop.retail')
		        </div>
			</div>

		    <div id="content-B2B" class='content-tab hidden'>
				@include('product.oshop.b2b')
		    </div>
			<div id="content-special" class='content-tab hidden'>
				@include('product.oshop.special')
			</div>			
			<div id="content-voucher" class='content-tab hidden'>
				@include('product.oshop.voucher')
			</div>
			<div id="content-hyper" class='content-tab hidden'>
		        <div class="col-sm-12" style="margin-bottom:20px">
		            <div class="row">
						@include('product.oshop.hyper')
		            </div>
		        </div>
			</div>			
			<div id="content-smm" class='content-tab hidden'>
				@include('product.oshop.smm')
			</div>			
			<div id="content-oem" class='content-tab hidden'>
		        <div class="col-sm-12" style="margin-bottom:20px">
		            <div class="row">
		                <h2 style="margin-left:9px">OEM/ODM</h2>
		            </div>
		        </div>
			</div>
		<br style="margin-bottom:20px"/>
        </div>
            {{-- V --}}
        {{-- col-md-11 --}}

    </div>
    </div>
	<div class="clearfix"></div>

<script type="text/javascript">
    $(document).ready(function(){
		$(document).delegate( '.choose', "click",function (event) {
			var rel = $(this).attr("rel");
			$(".content-tab").addClass("hidden");
			$(".tablist").removeClass("active");
			$(".choose").css("font-weight","normal");
			$(this).css("font-weight","bold");
			$(".mobilecategories").hide();
			if(rel == "retail"){
				$(".tablistretail").addClass("active");
				$(".oshopretail").show();
				$("#content-retail").removeClass("hidden");
				$(".choose").css("font-weight","normal");
				$(this).css("font-weight","bold");
			} else if(rel == "b2b"){
				$(".tablistb2b").addClass("active");
				$(".oshopb2b").show();
				$("#content-B2B").removeClass("hidden");
			} else if(rel == "hyper"){
				$(".tablisthyper").addClass("active");
				$(".oshophyper").show();
				$("#content-hyper").removeClass("hidden");
			} else if(rel == "smm"){
				$(".tablistsmm").addClass("active");
				$(".oshopsmm").show();
				$("#content-smm").removeClass("hidden");
			}
		});
		
		$(document).delegate( '.categoryoshopsing', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".category-filter").css("font-weight","bold");
			var id = $(this).attr("rel");
			$("#categoryoshopsing" + id).show();
			$(this).removeClass('categoryoshopsing');
			$(this).addClass('categoryoshopsinghide');
		});
		
		$(document).delegate( '.categoryoshopsinghide', "click",function (event) {
			var id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".category-filter").css("font-weight","normal");
			$("#categoryoshopsing" + id).hide();
			$(this).addClass('categoryoshopsing');
			$(this).removeClass('categoryoshopsinghide');
		});			
		
		$(document).delegate( '.categoryoshop', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".categorytitle").css("font-weight","bold");
			$(".categoriesoshop").show();
			$(this).removeClass('categoryoshop');
			$(this).addClass('categoryoshophide');
		});
		
		$(document).delegate( '.categoryoshophide', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".categorytitle").css("font-weight","normal");
			$(".categoriesoshop").hide();
			$(this).addClass('categoryoshop');
			$(this).removeClass('categoryoshophide');
		});	

		$(document).delegate( '.brandoshop', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".brandtitle").css("font-weight","bold");
			$(".brandsoshop").show();
			$(this).removeClass('brandoshop');
			$(this).addClass('brandoshophide');
		});
		
		$(document).delegate( '.brandoshophide', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".brandtitle").css("font-weight","normal");
			$(".brandsoshop").hide();
			$(this).addClass('brandoshop');
			$(this).removeClass('brandoshophide');
		});		

		$(document).delegate( '.productoshop', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".productstitle").css("font-weight","bold");
			$(".productsoshop").show();
			$(this).removeClass('productoshop');
			$(this).addClass('productoshophide');
		});
		
		$(document).delegate( '.productoshophide', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".productstitle").css("font-weight","normal");
			$(".productsoshop").hide();
			$(this).addClass('productoshop');
			$(this).removeClass('productoshophide');
		});		
		
		/************************ B2B *******************************************/
		$(document).delegate( '.categoryoshopsingb2b', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".category-filter").css("font-weight","bold");
			var id = $(this).attr("rel");
			$("#categoryoshopsingb2b" + id).show();
			$(this).removeClass('categoryoshopsingb2b');
			$(this).addClass('categoryoshopsinghideb2b');
		});
		
		$(document).delegate( '.categoryoshopsinghideb2b', "click",function (event) {
			var id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".category-filter").css("font-weight","normal");
			$("#categoryoshopsingb2b" + id).hide();
			$(this).addClass('categoryoshopsingb2b');
			$(this).removeClass('categoryoshopsinghideb2b');
		});			
		
		$(document).delegate( '.categoryoshopb2b', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".categorytitle").css("font-weight","bold");
			$(".categoriesoshopb2b").show();
			$(this).removeClass('categoryoshopb2b');
			$(this).addClass('categoryoshophideb2b');
		});
		
		$(document).delegate( '.categoryoshophideb2b', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".categorytitleb2b").css("font-weight","normal");
			$(".categoriesoshopb2b").hide();
			$(this).addClass('categoryoshopb2b');
			$(this).removeClass('categoryoshophideb2b');
		});	

		$(document).delegate( '.brandoshopb2b', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".brandtitleb2b").css("font-weight","bold");
			$(".brandsoshopb2b").show();
			$(this).removeClass('brandoshopb2b');
			$(this).addClass('brandoshophideb2b');
		});
		
		$(document).delegate( '.brandoshophideb2b', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".brandtitleb2b").css("font-weight","normal");
			$(".brandsoshopb2b").hide();
			$(this).addClass('brandoshopb2b');
			$(this).removeClass('brandoshophideb2b');
		});		

		$(document).delegate( '.productoshopb2b', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".productstitleb2b").css("font-weight","bold");
			$(".productsoshopb2b").show();
			$(this).removeClass('productoshopb2b');
			$(this).addClass('productoshophideb2b');
		});
		
		$(document).delegate( '.productoshophideb2b', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".productstitleb2b").css("font-weight","normal");
			$(".productsoshopb2b").hide();
			$(this).addClass('productoshopb2b');
			$(this).removeClass('productoshophideb2b');
		});			
		/************************ B2B *******************************************/
		/************************ HYPER *******************************************/
		$(document).delegate( '.categoryoshopsinghyper', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".category-filter").css("font-weight","bold");
			var id = $(this).attr("rel");
			$("#categoryoshopsinghyper" + id).show();
			$(this).removeClass('categoryoshopsinghyper');
			$(this).addClass('categoryoshopsinghidehyper');
		});
		
		$(document).delegate( '.categoryoshopsinghidehyper', "click",function (event) {
			var id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".category-filter").css("font-weight","normal");
			$("#categoryoshopsinghyper" + id).hide();
			$(this).addClass('categoryoshopsinghyper');
			$(this).removeClass('categoryoshopsinghidehyper');
		});			
		
		$(document).delegate( '.categoryoshophyper', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".categorytitlehyper").css("font-weight","bold");
			$(".categoriesoshophyper").show();
			$(this).removeClass('categoryoshophyper');
			$(this).addClass('categoryoshophidehyper');
		});
		
		$(document).delegate( '.categoryoshophidehyper', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".categorytitlehyper").css("font-weight","normal");
			$(".categoriesoshophyper").hide();
			$(this).addClass('categoryoshophyper');
			$(this).removeClass('categoryoshophidehyper');
		});	

		$(document).delegate( '.brandoshophyper', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".brandtitlehyper").css("font-weight","bold");
			$(".brandsoshophyper").show();
			$(this).removeClass('brandoshophyper');
			$(this).addClass('brandoshophidehyper');
		});
		
		$(document).delegate( '.brandoshophidehyper', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".brandtitlehyper").css("font-weight","normal");
			$(".brandsoshophyper").hide();
			$(this).addClass('brandoshophyper');
			$(this).removeClass('brandoshophidehyper');
		});		

		$(document).delegate( '.productoshophyper', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".productstitlehyper").css("font-weight","bold");
			$(".productsoshophyper").show();
			$(this).removeClass('productoshophyper');
			$(this).addClass('productoshophidehyper');
		});
		
		$(document).delegate( '.productoshophidehyper', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".productstitlehyper").css("font-weight","normal");
			$(".productsoshophyper").hide();
			$(this).addClass('productoshophyper');
			$(this).removeClass('productoshophidehyper');
		});			
		/************************ HYPER *******************************************/
		/************************ SMM *******************************************/
		$(document).delegate( '.categoryoshopsingsmm', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".category-filter").css("font-weight","bold");
			var id = $(this).attr("rel");
			$("#categoryoshopsingsmm" + id).show();
			$(this).removeClass('categoryoshopsingsmm');
			$(this).addClass('categoryoshopsinghidesmm');
		});
		
		$(document).delegate( '.categoryoshopsinghidesmm', "click",function (event) {
			var id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".category-filtersmm").css("font-weight","normal");
			$("#categoryoshopsingsmm" + id).hide();
			$(this).addClass('categoryoshopsingsmm');
			$(this).removeClass('categoryoshopsinghidesmm');
		});			
		
		$(document).delegate( '.categoryoshopsmm', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".categorytitlesmm").css("font-weight","bold");
			$(".categoriesoshopsmm").show();
			$(this).removeClass('categoryoshopsmm');
			$(this).addClass('categoryoshophidesmm');
		});
		
		$(document).delegate( '.categoryoshophidesmm', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".categorytitlesmm").css("font-weight","normal");
			$(".categoriesoshopsmm").hide();
			$(this).addClass('categoryoshopsmm');
			$(this).removeClass('categoryoshophidesmm');
		});	

		$(document).delegate( '.brandoshopsmm', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".brandtitlesmm").css("font-weight","bold");
			$(".brandsoshopsmm").show();
			$(this).removeClass('brandoshopsmm');
			$(this).addClass('brandoshophidesmm');
		});
		
		$(document).delegate( '.brandoshophidesmm', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".brandtitlesmm").css("font-weight","normal");
			$(".brandsoshopsmm").hide();
			$(this).addClass('brandoshopsmm');
			$(this).removeClass('brandoshophidesmm');
		});		

		$(document).delegate( '.productoshopsmm', "click",function (event) {
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileminus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","#73D2C6");
			$(".productstitlesmm").css("font-weight","bold");
			$(".productsoshopsmm").show();
			$(this).removeClass('productoshopsmm');
			$(this).addClass('productoshophidesmm');
		});
		
		$(document).delegate( '.productoshophidesmm', "click",function (event) {
			var cat_id = $(this).attr("rel");
			$(this).html("<img src='"+JS_BASE_URL+"/images/category/mobileplus.png' width='25px'/>");
			//$("#mobilecatplus" + cat_id).css("background-color","transparent");
			$(".productstitlesmm").css("font-weight","normal");
			$(".productsoshopsmm").hide();
			$(this).addClass('productoshopsmm');
			$(this).removeClass('productoshophidesmm');
			$(this).removeClass('productoshophidesmm');
			$(this).removeClass('productoshophidesmm');
		});			
		/************************ SMM *******************************************/
		
		
		
		$(document).delegate( '.omobilemenu', "click",function (event) {
			// console.log("CLOSE");
			$(".dropdown-content-omenu").show();
			$(this).removeClass('glyphicon-triangle-bottom');
			$(this).addClass('glyphicon-triangle-top');
			$(this).removeClass('omobilemenu');
			$(this).addClass('cmobilemenu');
		});
		$(document).delegate( '.cmobilemenu', "click",function (event) {
			// console.log("CLOSE");
			$(".dropdown-content-omenu").hide();
			$(this).addClass('glyphicon-triangle-bottom');
			$(this).removeClass('glyphicon-triangle-top');
			$(this).addClass('omobilemenu');
			$(this).removeClass('cmobilemenu');
		});

		
        var product_id=-1;
        $('body').click(function(evt){
            if ($(evt.target).hasClass('added')) {
                $('.productbox').removeClass('selected');

                var pid= $(evt.target).attr('data-pid');
                window.product_id=pid;
                var cls=".productbox_"+pid;
                $(cls).toggleClass('selected');
                $('#blast').prop('disabled',false);
                // if ($(evt.target).hasClass('selected')) {
                //     var product_id= $('.productbox').attr('data-pid');
                //     alert(product_id);
                // };

            }
            else{
                $('.productbox').removeClass('selected');
                 $('#blast').prop('disabled',true);
            }
        });

    });
</script>
{{-- AJAC CALL FOR SMM SAVE --}}
 <script type="text/javascript">
 $(document).ready(function(){
    $('#blast').click(function(){
        // alert(product_id);
        $.ajax({
                url: JS_BASE_URL + '/smedia/marketer',
                type: 'GET',
                data: {product_id: product_id},
                success:function(response){
                    toastr.info(response);
                }
        });
    });

 /*   $('.b2b_validation').click(function(){
        // alert(product_id);
		$("#modal_autolink_message").show();
		setTimeout(function () {
			$('#modal_autolink_message').hide();
		}, 10000);
    });	*/

    $('.autolink_validation').click(function(){
		$("#modal_autolink_message").show();
		setTimeout(function () {
			$('#modal_autolink_message').hide();
		}, 20000);
    });
 });
</script>
@if($autolink_status==0 && $isadmin == 0)
<script type="text/javascript">
	$(document).ready(function(){
		$('#b2bref').click(function(){
			// alert('u');
			toastr.info("Please click on the Autolink button to get linked with the merchant and receive special prices");
		});
	});
</script>
@endif
	{{--
    <script>
        var x = new EmbedJS({
            element: document.getElementById('block'),
            googleAuthKey : 'AIzaSyCqFouT8h5DKAbxlrTZmjXEmNBjC69f0ts',
            videoDetails       : false,
        });
        x.render();
    </script>
	--}}
	

    {{-- B2B section :: wahid --}}
    <script type="text/javascript">
	    $(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
			$("[data-toggle=popover]").popover({
				html: true,
				content: function() {
					id = $(this).attr('id');
					return $('#price-'+id).html();
				}
			});

	        $('.showAlert').click(function(){
	            $("#alert").removeClass('hidden');
	        })


	        currency = "{{ $currency }}";

	        var url = "{{ route('postAddToCart') }}";

	        $('#content-B2B .b2bcartBtn').click(function(e){
	        e.preventDefault();
	        var id = $(this).attr('data');
	        var quantity = $('.numberInput-'+id).val();
	        var totalPrice = parseInt($('#total-price-'+id).text());
	        var actualTotalPrice = parseInt($('#hidden-total-price-'+id).text());
	        var price = (actualTotalPrice/quantity);
	        $.ajax({
	          url: url,
	          type: "post",
	          data: {
	            'quantity': quantity,
	            'id': id,
	            'price': price
	          },
	          success: function(data){
	            $('.alert').removeClass('hidden').fadeIn(2000).delay(7000).fadeOut(2000);
	            $('.cart-info').text(data[1]+
				' '+ currency + formatPrice(actualTotalPrice)+
				" Successfully added to the cart");

	            if(data[0] < 1) {
	                $('.cart-link').text('Cart is empty');
	                $('.badge').text('0');
	            } else {
	                $('.cart-link').text('View Cart');
	                $('.badge').text(data[0]);
	            }
	          }
	        });
	        });

	        $('.wholesale-price').each(function(){
	            id = $(this).attr('data');
	            var PRICE;
	            specialMinUnit = parseInt($('.price-info-'+id).first().attr('special-funit'));
	            minUnit = parseInt($('.price-info-'+id).first().attr('from-unit'));

	            specialPrice = parseInt($('.price-info-'+id).first().attr('special-price'));
	            wholesalePrice = parseInt($('.price-info-'+id).first().attr('price'));

	            if( specialMinUnit > 0){
	                if( specialMinUnit <= minUnit ){
	                    PRICE = specialMinUnit * specialPrice;
	                }else {
	                    PRICE = minUnit * wholesalePrice;
	                }
	            }  else{
	                PRICE = minUnit * wholesalePrice;
	            }

	            showPrice = formatPrice(PRICE);
	            $('#hidden-total-price-'+id).text(PRICE);
	            $('#total-price-'+id).text(showPrice);
	        })

	        $('.ni').on('change', function(){
	            id = $(this).attr('data-dir');
	            val = parseInt($('.numberInput-'+id).val());
	            if(val){
	                setPriceOnQtyChange(id, val);
	            }else{
	                $('.numberInput-'+id).val(1);
	            }
	        })

	        $('.up').click(function(){
	            id = $(this).attr('data-dir');
	            val = parseInt($('.numberInput-'+id).val())+1;
	            setPriceOnQtyChange(id, val);
	        })

	        $('.down').click(function(){
	            id = $(this).attr('data-dir');
	            val = parseInt($('.numberInput-'+id).val())-1;
	            setPriceOnQtyChange(id, val);
	        })

	        function setPriceOnQtyChange(id, val){
	            var MIN_UNIT = 1; // lowest value of unit available
	            var MAX_UNIT = getMaxUnit(id); // highest value of unit available
	            if(val != null && val >= MIN_UNIT && val <= MAX_UNIT)
	            {
	                setPrice(id, val);
	            }
	            else if(val < MIN_UNIT){
	                setMinPrice(id);
	            }
	            else if (val > MAX_UNIT) {
	                setMaxPrice(id);
	            }
	        }

	        function setMinPrice(id){
	            qty = 1
	            $('.numberInput-'+id).val(qty);
	            price = $('.price-info-'+id).first().attr('price');
	            if(price != 0){
	                showPrice = formatPrice(price);
	                $('#total-price-'+id).text(showPrice);
	            }
	        }

	        function setMaxPrice(id){
	            qty = $('.price-info-'+id).last().attr('to-unit');
	            price = $('.price-info-'+id).last().attr('price');
	            $('.numberInput-'+id).val(qty);
	            if(price != 0){
	                totalPrice = calculateTotalPrice(price, qty);
	                $('#hidden-total-price-'+id).text(totalPrice);
	                $('#total-price-'+id).text(formatPrice(totalPrice));
	            }
	        }

	        function setPrice(id,qty){
	            $('.numberInput-'+id).val(qty);
	            price = getPrice(id, qty);
	            if(price != 0){
	                totalPrice = calculateTotalPrice(price, qty);
	                $('#hidden-total-price-'+id).text(totalPrice);
	                $('#total-price-'+id).text(formatPrice(totalPrice));
	            }
	        }


	        function getMaxUnit(id){
	            maxUnit = $('.price-info-'+id).last().attr('to-unit');
	            return maxUnit;
	        }

	        function getPrice(id, qty){
	            var price;
	            var specialMaxUnit = $('.price-info-'+id).attr('special-unit');
	            var specialMinUnit = $('.price-info-'+id).attr('special-funit');
	            var specialPrice = $('.price-info-'+id).attr('special-price');
	            if( specialMinUnit <= qty && qty <= specialMaxUnit ){
	                price = specialPrice;
	            }else{
	                $('.price-info-'+id).each(function(){
	                    var maxUnit = $(this).attr('to-unit');
	                    var minUnit = $(this).attr('from-unit');
	                    var wholesaleprice = $(this).attr('price');
	                    if( minUnit <= qty && qty <= maxUnit){
	                        price = wholesaleprice;
	                        return false;
	                    }else{
	                        return true;
	                    }
	                })
	            }

	            return price;
	        }

	        function formatPrice(price){
	            price = number_format((price/100),2);
	            return price;
	        }

	        function calculateTotalPrice(price, qty){
	            tp = price * qty;
	            return tp;
	        }

	        function number_format(number, decimals, dec_point, thousands_sep) {
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
	    });
    </script>

<script type="text/javascript">
$(document).ready(function() {
		$('.btn-number2').click(function (e) {
			e.preventDefault();
			console.log("pass");
			fieldName = $(this).attr('data-field');
			type = $(this).attr('data-type');
			pid = $(this).attr('data-dir');
			var input = $("#numberInput-"+pid);
			var currentVal = parseInt(input.val());
			
			if (!isNaN(currentVal)) {
				if (type == 'minus') {
					if (currentVal > input.attr('min')) {
						input.val(currentVal - 1).change();
					}
					if (parseInt(input.val()) == input.attr('min')) {

						$(this).attr('disabled', true);
					}

				} else if (type == 'plus') {

					if (currentVal < input.attr('max')) {
						input.val(currentVal + 1).change();
					}
					if (parseInt(input.val()) == input.attr('max')) {
						$(this).attr('disabled', true);
					}

				}
			} else {
				input.val(0);
			}
			
			/*qty = $('.quantity2').val();
			fre_qty = $('#free_delivery_with_purchase_qty').val();
			del_price = $('#mydelprice2').val();
			fre_qty = parseInt(fre_qty);
			var amount = 0;
			/*retail_price = parseFloat($('.retail_price').attr('rprice'));
			var counter = $("#counter").val();
			
			for (var i = 1; i <= parseInt(counter); i++) {
				var funit = $("#funit" + i).val();
				var unit = $("#unit" + i).val();
				var price = $("#wprice" + i).val();
				if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
					//console.log(amount);
					amount = parseFloat(price * qty).toFixed(2);
				}	
			}		 
			$('.amt2').html(accounting.formatMoney(amount,""));
				if(fre_qty==0){
					price = $('.del_price').html();
				} else {
					if(qty < fre_qty){
						$('.delprice2').html(del_price);
						price = $('.delprice2').html();
					} else {
						price = "0.0";
						$('.delprice2').html("0.00");
					}
				}
				total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
				//console.log(total);
				$('.total2').html(accounting.formatMoney(total,""));	*/		
		});	

    $( ".price" ).on('click',function() {
		amount = ($('.amt').text());
		amount = (accounting.unformat(amount));
		$('.price').removeClass("active");
		$(this).addClass('active');
		price  = ($(this).attr('price'));
		price  = accounting.unformat(price);
		total  = (parseFloat(amount) + parseFloat(price));
		$('.del_price').html(accounting.formatMoney(price,""));
		$('.total').html(accounting.formatMoney(total,""));
    });

    currency = "{{ $currency }}";

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
	path = window.location.href;
	var url;
	if(path.includes('public'))
	{
	    url = '/OpenSupermall/public/cart/addtocart';
	}
	else {
	    url = '/cart/addtocart';
	}

  $('.cartBtn').click(function(e){
    e.preventDefault();
    var price = $(this).siblings('input[name=price]').val();
    $.ajax({
      url: url,
      type: "post",
      data: {
        'quantity':$(this).siblings('input[name=quantity]').val(),
        'id': $(this).siblings('input[name=id]').val(),
        'price': price
      },
      success: function(data){
        $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
        $('.cart-info').text(data[1]+' '+currency+
			number_format(price/100,2)+ " Successfully added to the cart");

        if(data[0] < 1) {
            $('.cart-link').text('Cart is empty');
            $('.badge').text('0');
        } else { 
            $('.cart-link').text('View Cart');
            $('.badge').text(data[0]);
        }
      }
    });
  });	
	
	$('.cartBtn2').click(function(e){
		e.preventDefault();
		var price = 0;
		var amount = 0;
		var pid = $(this).siblings('input[name=id]').val();
		/*retail_price = parseFloat($('.retail_price').attr('rprice'));*/
		var counter = $("#counter-" + pid).val();
		var qty = $(".numberInput-"+pid).val();
		for (var i = 1; i <= parseInt(counter); i++) {
			var funit = $("#funit" + i + "-" + pid).val();
			var unit = $("#unit" + i + "-" + pid).val();
			//var price = $("#wprice" + i).val();
			if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
				//console.log(amount);
				price = $("#wprice" + i + "-" + pid).val();
			}	
		}				
		//var price = $(this).siblings('input[name=price]').val();
		if(price == 0){
			price = $("#rprice" + pid).val();
		}		
		/*console.log(price);
		console.log($(this).siblings('input[name=id]').val());
		console.log(qty);*/
		$.ajax({
			url: url,
			type: "post",
			data: {
				'quantity':$(".numberInput-"+pid).val(),
				'id': $(this).siblings('input[name=id]').val(),
				'price': price
			},
			success: function(data){
				$('.alert').removeClass('hidden').fadeIn(2000).delay(7000).fadeOut(2000);
				$('.cart-info').text(data[1]+' ('+ currency + ' ' + number_format(price/100,2)+ ') '+" Successfully added to the cart");
				if(data[0] < 1)
				{
				    $('.cart-link').text('Cart is empty');
				    $('.badge').text('0');
				}
				else {
				    $('.cart-link').text('View Cart');
				    $('.badge').text(data[0]);
				}
			}
		});
	});

	$('.all-filter').click(function(e){
		e.preventDefault();
		$(".all-filter-fa").show();
		var oshop_id = $('#real_oshop_id').val();
		var mid = $('#oshop_id').val();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/all_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'mid':mid,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".all-filter-fa").hide();
				$('#content-'+tab_product).html(data);
				$(".dropdown-content-omenu").hide();
				$(".cmobilemenu").addClass('glyphicon-triangle-bottom');
				$(".cmobilemenu").removeClass('glyphicon-triangle-top');
				$(".cmobilemenu").addClass('omobilemenu');
				$(".cmobilemenu").removeClass('cmobilemenu');
				
				
			}
		});
	});

	$('.category-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var category_id = $(this).attr('rel');
		$(".category-filter-fa-" + category_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/category_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'category_id':category_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".category-filter-fa-" + category_id).hide();
				$('#content-'+tab_product).html(data);
				$(".dropdown-content-omenu").hide();
				$(".cmobilemenu").addClass('glyphicon-triangle-bottom');
				$(".cmobilemenu").removeClass('glyphicon-triangle-top');
				$(".cmobilemenu").addClass('omobilemenu');
				$(".cmobilemenu").removeClass('cmobilemenu');
			}
		});
	});

	$('.subcat-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var sub_category_id = $(this).attr('rel');
		$(".subcat-filter-fa-" + sub_category_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/sub_category_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'sub_category_id':sub_category_id,
				'tab_product': tab_product
			},
			success: function(data){
				$(".subcat-filter-fa-" + sub_category_id).hide();
				$('#content-'+tab_product).html(data);
				$(".dropdown-content-omenu").hide();
				$(".cmobilemenu").addClass('glyphicon-triangle-bottom');
				$(".cmobilemenu").removeClass('glyphicon-triangle-top');
				$(".cmobilemenu").addClass('omobilemenu');
				$(".cmobilemenu").removeClass('cmobilemenu');
			}
		});
	});
		
	$('.subcatlevel-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var subcatlevel_id = $(this).attr('rel');
		$(".subcatlevel-filter-fa-" + subcatlevel_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/subcatlevel2_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'subcatlevel_id':subcatlevel_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".subcatlevel-filter-fa-" + subcatlevel_id).hide();
				$('#content-'+tab_product).html(data);
				$(".dropdown-content-omenu").hide();
				$(".cmobilemenu").addClass('glyphicon-triangle-bottom');
				$(".cmobilemenu").removeClass('glyphicon-triangle-top');
				$(".cmobilemenu").addClass('omobilemenu');
				$(".cmobilemenu").removeClass('cmobilemenu');
			}
		});
	});	
	
	$('.subcatlevel3-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var subcatlevel_id = $(this).attr('rel');
		$(".subcatlevel3-filter-fa-" + subcatlevel_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/subcatlevel3_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'subcatlevel_id':subcatlevel_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".subcatlevel3-filter-fa-" + subcatlevel_id).hide();
				$('#content-'+tab_product).html(data);
				$(".dropdown-content-omenu").hide();
				$(".cmobilemenu").addClass('glyphicon-triangle-bottom');
				$(".cmobilemenu").removeClass('glyphicon-triangle-top');
				$(".cmobilemenu").addClass('omobilemenu');
				$(".cmobilemenu").removeClass('cmobilemenu');
			}
		});
	});	
	
	$('.brand-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var brand_id = $(this).attr('rel');
		$(".brand-filter-fa-" + brand_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/brand_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'brand_id':brand_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".brand-filter-fa-" + brand_id).hide();
				$('#content-'+tab_product).html(data);
				$(".dropdown-content-omenu").hide();
				$(".cmobilemenu").addClass('glyphicon-triangle-bottom');
				$(".cmobilemenu").removeClass('glyphicon-triangle-top');
				$(".cmobilemenu").addClass('omobilemenu');
				$(".cmobilemenu").removeClass('cmobilemenu');
			}
		});
	});	
	
	$('.color-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var color_id = $(this).attr('rel');
		$(".color-filter-fa").show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/color_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'color_id':color_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".color-filter-fa").hide();
				$('#content-'+tab_product).html(data);
				$(".dropdown-content-omenu").hide();
				$(".cmobilemenu").addClass('glyphicon-triangle-bottom');
				$(".cmobilemenu").removeClass('glyphicon-triangle-top');
				$(".cmobilemenu").addClass('omobilemenu');
				$(".cmobilemenu").removeClass('cmobilemenu');
			}
		});
	});	
})
</script>
@stop
