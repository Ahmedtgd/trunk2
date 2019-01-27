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
		/*color: #000;*/
	}
	ul#subcat3-nav li a:hover {
		background: transparent;
		text-decoration: underline;
		/*color: #000;*/
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
		/*color: #000;*/
	}
	ul#subcat-nav li a:hover {
		background: transparent;
		text-decoration: underline;
		/*color: #000;*/
		/*border: 1px solid red;*/
	}
	ul#subcat-nav li.activeis {
		font-weight: bold;
		color: #41B2EA;
		background-color:#1abc9c;
	}
	.category-filter{
		color:#000;
	/*	font-weight: bold; */
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
	
	.breadcrumb {
		margin-bottom: 0px !important;
	}
</style>
<span style="float: left; cursor: pointer; font-size: 22px;" id="subcat_caret">Subcategory <span class="caret"></span></span>
<div id="floorMansory" class="row">
			<?php 
				$w =0; $wp =0; 
				$totalsubcat = count($subcategories);
				$byfour = $totalsubcat/4;
				
				$isfour = 0;
				$noclose = 1;
				$countfour = 0;
			?>	
	<div class="col-md-12">
		<div class="row masonry-megamenu" style="display: none;">
		<ul style="margin: 0; padding-left:15px;" id="subcat-nav">		
			<div class="col-xs-3">
			<li><a class="all-filter" href="javascript:void(0)">
			All Products
			</a><span style="text-align:right;"> ({{ count($products) }}) </span><span class="all-filter-fa" id="all_retail_fa" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></li>
		
			@foreach($subcategories as $c)
				<li>
				<a class="subcat-filter" href="javascript:void(0)" rel="{{$c->id}}">
					{{ $c->description }}
				</a>
				<span style="text-align:right;"> ({{ $count_subcategoriesp[$w] }})</span><span class="subcat-filter-fa-{{$c->id}}" style="display:none;"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span>
				</li>
				<?php $w++; ?>
				<?php $isfour++; ?>
				@if($isfour >= $byfour)
					</div>
					<?php $isfour=0; ?>
					<?php $countfour++; ?>
					@if($countfour <= 3)
						<div class="col-xs-3">
					@else
						<?php $noclose = 0; ?>
					@endif
				@endif
			@endforeach
			
			@if($noclose == 1)
				</div>
			@endif
		</ul>
		</div>
	</div>
</div>
<input type="hidden" value="{{$floor_id}}" id="real_floor_id" />
<script>
$(document).ready(function() {
	$('#subcat_caret').click(function (e) {
		e.stopPropagation();
		$('.masonry-megamenu').fadeOut('fast');
		$('#floorMansory .masonry-megamenu').fadeIn('fast', function() {
			//console.log($(this));
			$(this).masonry({
				itemSelector: '.col-xs-3',
				columnWidth: '.col-xs-3',
				containerStyle: null
			});
		});
	});
	
	$('.all-filter').click(function(e){
		e.preventDefault();
		$(".all-filter-fa").show();
		var category = $('#real_floor_id').val();
		var url = '/floor/filter';
		$('#content-floor-def').html("<p align='center'>Loading...</p>");
		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':category,
				'filter': 'all',
				'filter_id': 0
			},
			success: function(data){
				//console.log(data);
				$(".all-filter-fa").hide();
				$('#content-floor-def').html(data);
			}
		});
	});

	$('.subcat-filter').click(function(e){
		e.preventDefault();
		var category = $('#real_floor_id').val();
		var sub_category_id = $(this).attr('rel');
		$(".subcat-filter-fa-" + sub_category_id).show();
		var url = '/floor/filter';
		$('#content-floor-def').html("<p align='center'>Loading...</p>");
		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':category,
				'filter': 'subcategory',
				'filter_id': sub_category_id
			},
			success: function(data){
				$(".subcat-filter-fa-" + sub_category_id).hide();
				$('#content-floor-def').html(data);
			}
		});
	});
		
	$('.subcatlevel-filter').click(function(e){
		e.preventDefault();
		var category = $('#real_floor_id').val();
		var subcatlevel_id = $(this).attr('rel');
		$(".subcatlevel-filter-fa-" + subcatlevel_id).show();
		var url = '/floor/filter';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':category,
				'filter': 'subcatlevel',
				'filter_id': subcatlevel_id
			},
			success: function(data){
				//console.log(data);
				$(".subcatlevel-filter-fa-" + subcatlevel_id).hide();
				$('#content-floor').html(data);
			}
		});
	});	
	
	$('.subcatlevel3-filter').click(function(e){
		e.preventDefault();
		var category = $('#real_floor_id').val();
		var subcatlevel_id = $(this).attr('rel');
		$(".subcatlevel3-filter-fa-" + subcatlevel_id).show();
		var url = '/floor/filter';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':category,
				'filter': 'subcatlevel3',
				'filter_id': subcatlevel_id
			},
			success: function(data){
				//console.log(data);
				$(".subcatlevel3-filter-fa-" + subcatlevel_id).hide();
				$('#content-floor').html(data);
			}
		});
	});	
	
	$('.brand-filter').click(function(e){
		e.preventDefault();
		var category = $('#real_floor_id').val();
		var brand_id = $(this).attr('rel');
		$(".brand-filter-fa-" + brand_id).show();
		var url = '/floor/filter';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':category,
				'filter': 'brand',
				'filter_id': brand_id
			},
			success: function(data){
				console.log(data);
				$(".brand-filter-fa-" + brand_id).hide();
				$('#content-floor').html(data);
			}
		});
	});	
});	
</script>