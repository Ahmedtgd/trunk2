<style>

	.panel-heading {
		padding: 3px 3px;
		border-bottom: 1px solid transparent;
		border-top-left-radius: 3px;
		border-top-right-radius: 3px;
	}

	.well {
		min-heiht: 20px;
		padding: 4px;
		margin-bottom: 0px;
		background-color: #fff;
		border: 1px solid #e3e3e3;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
	}
	.panel-body {
		padding: 0px;
	}

	ul {
		list-style-type: none;
	}

	.category_list ul li a, .category_list ul li a:hover {
		background: transparent;
		text-decoration: none;
/*		color: #41B2EA;*/
	}
	ul#subcat3-nav li a {
		background: transparent;
		text-decoration: none;
		color: #000;
	}
	ul#subcat3-nav li a:hover {
		background: transparent;
		text-decoration: underline;
		color: #000;
		/*border: 1px solid red;*/
	}
	ul#subcat3-nav li.activeis {
		font-weight: bold;
		color: #41B2EA;
		background-color:#1abc9c;
	}	
	ul#subcat-nav li a {
		background: transparent;
		text-decoration: none;
		color: #000;
	}
	ul#subcat-nav li a:hover {
		background: transparent;
		text-decoration: underline;
		color: #000;
		/*border: 1px solid red;*/
	}
	ul#subcat-nav li.activeis {
		font-weight: bold;
		color: #41B2EA;
		background-color:#1abc9c;
	}
	.category-filter{
		color:#000;
		font-weight: bold;
	}
	.subcatlevel-filter{
		color:#000;
		font-weight: bold;
	}	
	.brand-filter{
		color:#000;
		font-weight: normal;
	}	
	.fa-li {
		position: static;
	}
</style>
<div id='cat-retail'  class="panel-group category_tab" role="tablist" aria-multiselectable="true" style="margin-left:5px">
	<h4><a class="all-filter" style="color:#1abc9c; font-weight: bold;" href="javascript:void(0)">
		All Products
	</a><span style="text-align:right;"> ({{ $count_products[0]->counter }}) </span><span class="all-filter-fa" id="all_retail_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></h4>
	<h4><b>Categories</b></h4>
	<?php $w =0; $wp =0; ?>
    @foreach($categories as $c)

		<a class="category-filter" href="javascript:void(0)" rel="{{$c->id}}">
			{{ $c->description }}
		</a>
		<span style="text-align:right;"> ({{ $count_categoriesp[$w] }})</span><span class="category-filter-fa-{{$c->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
		<ul style="margin: 0; padding-left:15px;" id="subcat-nav">

			@foreach($subcategoriesp[$w] as $subc)

				<li>
					<a class="subcat-filter" href="javascript:void(0)" rel="{{$subc->id}}" >
						{{ $subc->description }}</a>
						<span> ({{ $count_subcategoriesp[$wp] }})</span><span class="subcat-filter-fa-{{$subc->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
						<?php $wp++; ?>
					
				</li>

			@endforeach
		</ul>

		<?php $w++; ?>
	@endforeach
	@if(!is_null($subcatlevels))
	<br>

	<h4><b>Product</b></h4>
		@foreach($subcatlevels as $subcatleveldef)
			<a class="subcatlevel-filter"
				href="javascript:void(0)"
				rel="{{$subcatleveldef->id}}">
				{{ $subcatleveldef->name }}
			</a>
			<span style="text-align:right;">
				({{ $subcatleveldef->nprod }})</span>
			<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
			style="display:none;">
			<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>

			<ul style="margin: 0; padding-left:15px;" id="subcat3-nav">
				@if(isset($subcatleves3[$subcatleveldef->id]))
				@foreach($subcatleves3[$subcatleveldef->id] as $subc)
					@if($subc->nprod > 0)
						<li>
							<a class="subcatlevel3-filter"
							href="javascript:void(0)" rel="{{$subc->id}}" >
								{{ $subc->name }}</a>
								<span> ({{ $subc->nprod }})</span>
								<span class="subcatlevel3-filter-fa-{{$subc->id}}"
								style="display:none;">
								<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
								</i></span>							
						</li>
					@endif
				@endforeach
				@endif
			</ul>			
		@endforeach			
	@endif	

	@if(!is_null($brands))
	<br>

	<h4><b>Brands</b></h4>
		@foreach($brands as $branddef)
		<a class="brand-filter" href="javascript:void(0)" rel="{{$branddef->id}}">
			{{ $branddef->name }}
		</a>
		<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
		<br/>
		@endforeach			
	@endif	

	<!--
	@if(!is_null($colors))
	<br>

	<style>
		.wColorPicker-button {
			position: relative;
			border-radius: 5px;
			border: solid #CACACA 1px;
			padding: 1px;
			cursor: pointer;
			width: 35px !important;
			height: 25px !important;
			margin-top: -4px !important;
		}
		.wColorPicker-button-color {
			position: relative;
			border-radius: 5px;
			height: 20px !important;
		}
	</style>	
	<h4 style="margin-bottom:15px"><b>Colours</b>
		<span class="color-filter-fa" style="display:none;color:#707070">
			<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i>
		</span>
	</h4>
		<?php $cic = 0;?>
		@foreach($colors as $colordef)
			<div class="col-sm-3 mt no-padding">
				<div class="wColorPicker-button" style="float: left;">
					<div class="wColorPicker-button-color color-filter"
					title="{{$colordef->description}}"
					href="javascript:void(0)"
					rel="{{$colordef->id}}"
					style="background-color:{{$colordef->hex}};height:4px;">
					</div>
				</div>&nbsp;({{$colordef->nprod}})
			</div>
			<?php $cic++;?>
			@if($cic == 4)
				<?php $cic = 0;?>
				<div class="clearfix"></div>
				<br>
			@endif
		@endforeach			
	@endif
	-->

	</div>

	<div id="cat-B2B" class="category_tab" style="margin-left:5px">
		<h4>
			<a class="all-filter" style="color:#1abc9c; font-weight: bold;" href="javascript:void(0)">
				All Products
			</a><span style="text-align:right;"> ({{ $count_all_products }})</span><span class="all-filter-fa" id="all_b2b_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>		
		</h4>
		<h4><b>Categories</b></h4>
			<?php $w =0; $wp =0; ?>
			@foreach($categoriesb2b as $cb2b)
				<a class="category-filter" href="javascript:void(0)" rel="{{$cb2b->id}}">
					{{ $cb2b->description }}
				</a>
				<span style="text-align:right;"> ({{ $count_categoriespb2b[$w] }})</span><span class="category-filter-fa-{{$cb2b->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
				<ul style="margin: 0; padding-left:15px;" id="subcat-nav">
				    @foreach($subcategoriespb2b[$w] as $scb2b)
						<li>
							<a class="subcat-filter" href="javascript:void(0)" rel="{{$scb2b->id}}" >
								{{ $scb2b->description }}</a>
								<span> ({{ $count_subcategoriespb2b[$wp] }})</span><span class="subcat-filter-fa-{{$scb2b->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
							
						</li>
						<?php $wp++; ?>
					@endforeach
				</ul>
				<?php $w++; ?>

			@endforeach

	@if(!is_null($subcatlevels_b2b))
	<br>

	<h4><b>Product</b></h4>
		@foreach($subcatlevels_b2b as $subcatleveldef)
			<a class="subcatlevel-filter"
				href="javascript:void(0)"
				rel="{{$subcatleveldef->id}}">
				{{ $subcatleveldef->name }}
			</a>
			<span style="text-align:right;">
				({{ $subcatleveldef->nprod }})</span>
			<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
			style="display:none;">
			<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>

			<ul style="margin: 0; padding-left:15px;" id="subcat3-nav">
				@if(isset($subcatleves3[$subcatleveldef->id]))
				@foreach($subcatleves3[$subcatleveldef->id] as $subc)
					@if($subc->nprod > 0)
						<li>
							<a class="subcatlevel3-filter"
							href="javascript:void(0)" rel="{{$subc->id}}" >
								{{ $subc->name }}</a>
								<span> ({{ $subc->nprod }})</span>
								<span class="subcatlevel3-filter-fa-{{$subc->id}}"
								style="display:none;">
								<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
								</i></span>							
						</li>
					@endif
				@endforeach
				@endif
			</ul>			
		@endforeach			
	@endif	
			
		@if(!is_null($brands_b2b))
		<br>

		<h4><b>Brands</b></h4>
			@foreach($brands_b2b as $branddef)
			<a class="brand-filter" href="javascript:void(0)" rel="{{$branddef->id}}">
				{{ $branddef->name }}
			</a>
			<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
			<br/>
			@endforeach			
		@endif				

	</div>
	<div id="cat-smm" class="category_tab" style="margin-left:5px">
		<h4>
			<a class="all-filter" style="color:#1abc9c; font-weight: bold;" href="javascript:void(0)">
				All Products
			</a><span style="text-align:right;"> ({{ $count_all_smm_products }})</span><span class="all-filter-fa" id="all_smm_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>		
		</h4>
		<h4><b>Categories</b></h4>
		<?php $ws =0; $wps =0; ?>
		@foreach($categories_smm as $c)

			<a class="category-filter" href="javascript:void(0)" rel="{{$c->id}}">
				{{ $c->description }}
			</a>
			<span style="text-align:right;"> ({{ $count_categoriesp_smm[$ws] }})</span><span class="category-filter-fa-{{$c->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
			<ul style="margin: 0; padding-left:15px;" id="subcat-nav">

				@foreach($subcategoriesp_smm[$ws] as $subc)

					<li>
						<a class="subcat-filter" href="javascript:void(0)" rel="{{$subc->id}}" >
							{{ $subc->description }}</a>
							<span> ({{ $count_subcategoriesp_smm[$wps] }})</span><span class="subcat-filter-fa-{{$subc->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
							<?php $wps++; ?>
						
					</li>

				@endforeach
			</ul>		


			<?php $ws++; ?>
		@endforeach	

	@if(!is_null($subcatlevels_smm))
	<br>

	<h4><b>Product</b></h4>
		@foreach($subcatlevels_smm as $subcatleveldef)
			<a class="subcatlevel-filter"
				href="javascript:void(0)"
				rel="{{$subcatleveldef->id}}">
				{{ $subcatleveldef->name }}
			</a>
			<span style="text-align:right;">
				({{ $subcatleveldef->nprod }})</span>
			<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
			style="display:none;">
			<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>

			<ul style="margin: 0; padding-left:15px;" id="subcat3-nav">
				@if(isset($subcatleves3_smm[$subcatleveldef->id]))
				@foreach($subcatleves3_smm[$subcatleveldef->id] as $subc)
					@if($subc->nprod > 0)
						<li>
							<a class="subcatlevel3-filter"
							href="javascript:void(0)" rel="{{$subc->id}}" >
								{{ $subc->name }}</a>
								<span> ({{ $subc->nprod }})</span>
								<span class="subcatlevel3-filter-fa-{{$subc->id}}"
								style="display:none;">
								<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
								</i></span>							
						</li>
					@endif
				@endforeach
				@endif
			</ul>			
		@endforeach			
	@endif
	
	@if(!is_null($brands_smm))
	<br>

	<h4><b>Brands</b></h4>
		@foreach($brands_smm as $branddef)
		<a class="brand-filter" href="javascript:void(0)" rel="{{$branddef->id}}">
			{{ $branddef->name }}
		</a>
		<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
		<br/>
		@endforeach			
	@endif		
	</div>
	<div id="cat-hyper" class="category_tab" style="margin-left:5px">
		<h4>
			<a class="all-filter" style="color:#1abc9c; font-weight: bold;" href="javascript:void(0)">
				All Products
			</a><span style="text-align:right;"> ({{ $count_all_hyper }})</span><span class="all-filter-fa" id="all_hyper_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>		
		</h4>	
		<h4><b>Categories</b></h4>
		<?php $wsh =0; $wpsh =0; ?>
		@foreach($categories_hyper as $c)

			<a class="category-filter" href="javascript:void(0)" rel="{{$c->id}}">
				{{ $c->description }}
			</a>
			<span style="text-align:right;"> ({{ $count_categoriesp_hyper[$wsh] }})</span><span class="category-filter-fa-{{$c->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
			<ul style="margin: 0; padding-left:15px;" id="subcat-nav">

				@foreach($subcategoriesp_hyper[$wsh] as $subc)

					<li>
						<a class="subcat-filter" href="javascript:void(0)" rel="{{$subc->id}}" >
							{{ $subc->description }}</a>
							<span> ({{ $count_subcategoriesp_hyper[$wpsh] }})</span><span class="subcat-filter-fa-{{$subc->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
							<?php $wpsh++; ?>
						
					</li>

				@endforeach
			</ul>		

			<?php $wsh++; ?>
		@endforeach	
	@if(!is_null($subcatlevels_hyper))
	<br>	
	<h4><b>Product</b></h4>
		@foreach($subcatlevels_hyper as $subcatleveldef)
			<a class="subcatlevel-filter"
				href="javascript:void(0)"
				rel="{{$subcatleveldef->id}}">
				{{ $subcatleveldef->name }}
			</a>
			<span style="text-align:right;">
				({{ $subcatleveldef->nprod }})</span>
			<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
			style="display:none;">
			<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>

			<ul style="margin: 0; padding-left:15px;" id="subcat3-nav">
				@if(isset($subcatleves3_hyper[$subcatleveldef->id]))
				@foreach($subcatleves3_hyper[$subcatleveldef->id] as $subc)
					@if($subc->nprod > 0)
						<li>
							<a class="subcatlevel3-filter"
							href="javascript:void(0)" rel="{{$subc->id}}" >
								{{ $subc->name }}</a>
								<span> ({{ $subc->nprod }})</span>
								<span class="subcatlevel3-filter-fa-{{$subc->id}}"
								style="display:none;">
								<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
								</i></span>							
						</li>
					@endif
				@endforeach
				@endif
			</ul>			
		@endforeach			
	@endif

	@if(!is_null($brands_hyper))
	<br>

	<h4><b>Brands</b></h4>
		@foreach($brands_hyper as $branddef)
		<a class="brand-filter" href="javascript:void(0)" rel="{{$branddef->id}}">
			{{ $branddef->name }}
		</a>
		<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
		<br/>
		@endforeach			
	@endif	
	</div>
	<div id="cat-voucher" class="category_tab" style="margin-left:5px">
		<h4>
			<a class="all-filter" style="color:#1abc9c; font-weight: bold;" href="javascript:void(0)">
				All Products
			</a><span style="text-align:right;"> ({{ $count_all_voucher_products }})</span><span class="all-filter-fa" id="all_voucher_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>		
		</h4>
		<h4><b>Categories</b></h4>
		<?php $wsv =0; $wpsv =0; ?>
		@foreach($categories_voucher as $c)

			<a class="category-filter" href="javascript:void(0)" rel="{{$c->id}}">
				{{ $c->description }}
			</a>
			<span style="text-align:right;"> ({{ $count_categoriesp_voucher[$wsv] }})</span><span class="category-filter-fa-{{$c->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
			<ul style="margin: 0; padding-left:15px;" id="subcat-nav">

				@foreach($subcategoriesp_voucher[$wsv] as $subc)

					<li>
						<a class="subcat-filter" href="javascript:void(0)" rel="{{$subc->id}}" >
							{{ $subc->description }}</a>
							<span> ({{ $count_subcategoriesp_voucher[$wpsv] }})</span><span class="subcat-filter-fa-{{$subc->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
							<?php $wpsv++; ?>
						
					</li>

				@endforeach
			</ul>		


			<?php $wsv++; ?>
		@endforeach	

	@if(!is_null($subcatlevels_voucher))
	<br>

	<h4><b>Product</b></h4>
		@foreach($subcatlevels_voucher as $subcatleveldef)
			<a class="subcatlevel-filter"
				href="javascript:void(0)"
				rel="{{$subcatleveldef->id}}">
				{{ $subcatleveldef->name }}
			</a>
			<span style="text-align:right;">
				({{ $subcatleveldef->nprod }})</span>
			<span class="subcatlevel-filter-fa-{{$subcatleveldef->id}}"
			style="display:none;">
			<i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>

			<ul style="margin: 0; padding-left:15px;" id="subcat3-nav">
				@if(isset($subcatleves3_voucher[$subcatleveldef->id]))
				@foreach($subcatleves3_voucher[$subcatleveldef->id] as $subc)
					@if($subc->nprod > 0)
						<li>
							<a class="subcatlevel3-filter"
							href="javascript:void(0)" rel="{{$subc->id}}" >
								{{ $subc->name }}</a>
								<span> ({{ $subc->nprod }})</span>
								<span class="subcatlevel3-filter-fa-{{$subc->id}}"
								style="display:none;">
								<i class="fa-li fa fa-spinner fa-spin fa fa-fw">
								</i></span>							
						</li>
					@endif
				@endforeach
				@endif
			</ul>			
		@endforeach			
	@endif
	
	@if(!is_null($brands_voucher))
	<br>

	<h4><b>Brands</b></h4>
		@foreach($brands_voucher as $branddef)
		<a class="brand-filter" href="javascript:void(0)" rel="{{$branddef->id}}">
			{{ $branddef->name }}
		</a>
		<span style="text-align:right;"> ({{ $branddef->nprod }})</span><span class="brand-filter-fa-{{$branddef->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
		<br/>
		@endforeach			
	@endif		
	</div>
