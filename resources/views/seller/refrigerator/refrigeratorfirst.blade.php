@extends("common.default")
@section("content")
@include('common.sellermenu')

<link href="{{url('jqgrid/ui.jqgrid.min.css')}}" rel="stylesheet"
	type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<style>
    .tab-pane{
        margin-top: 4em;
    }

    .top-margin{
        margin-top: -30px;
    }

    table#notproduct_details_table
    {
        /*  table-layout: fixed;*/
        max-width: none;
        width: auto;
        min-width: 100%;
    }

    table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
    .aproducts{
        width: 100% !important;
    }
    .no-sort{
        width: 20px !important;
    }

    #upload-form{
        /*position: absolute;*/
        /*top: 50%;*/
        /*left: 50%;*/
        /*margin-top: -100px;*/
        /*margin-left: -250px;*/
        width: 500px;
        height: 200px;
        border: 4px dashed #333333;
    }
    .select2{display: none;}
    #upload-form .p-sty{
        width: 100%;
        height: 100%;
        text-align: center;
        line-height: 170px;
        color: #333333;
    }
    #upload-form .input-sty{
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 200px;
        outline: none;
        opacity: 0;
    }
    #upload-form .button-sty{
        margin: 0;
        color: #fff;
        background: #16a085;
        border: none;
        width: 508px;
        height: 35px;
        margin-top: -20px;
        margin-left: -4px;
        border-radius: 4px;
        border-bottom: 4px solid #117A60;
        transition: all .2s ease;
        outline: none;
    }
    #upload-form .button-sty:hover{
        background: #149174;
        color: #0C5645;
    }
    #upload-form .button-sty:active{
        border:0;
    }
    .logo-header {
        padding-left:0;
        padding-right:0;
    }
    body {
        font-family: Lato;
    }
    .navbar-inverse .navbar-nav>li>a {
        color:white;
    }

</style>

<section class="">
<div class="container"><!--Begin main cotainer-->
	<div class="alert alert-success alert-dismissible hidden cart-notification" 
		role="alert" id="alert">
		<button type="button" class="close" data-dismiss="alert"
			aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong class='cart-info'></strong>
	</div>
	<input type="hidden" value="" id="selluserid" />

	<div class="row">
		<div class="col-sm-12">
			<div class="row">
			<div class="row">
			@if(Session::has('success'))
			<script type="text/javascript">
				toastr.success("{{Session::get('success')}}");
			</script>
			@endif

			@if(Session::has('error_message'))
			<script type="text/javascript">
				toastr.error("{{Session::get('error_message')}}");
			</script>
			@endif
			</div>
		 
			<input type="hidden" value="" id="mmerchant_id" />
			<input type="hidden" value="" id="msell_id" />
			<div id="dashboard" class="row panel-body "
				style="padding: 0px 15px 15px 15px" >

				<div class="tab-content top-margin"
					style="margin-top:-50px">

				<div class="tab-pane fade in active" id="deliveryorder">
					<div class="row">
						<div class="col-md-6">
							<h2 style="margin-top:10px">
								Refrigerator and Storage
							</h2>
						</div>
					</div>
					<div class="row" style="padding: 0px 10px 0px 10px;">
					<table class="table table-bordered table-responsive"
						id="delivery-order-table" >
					<thead class="aproducts">
					<tr style="background-color: #6d9270; color: #FFF;">
						<th class="text-center no-sort"
							style='color:white; background:#e46c0a;'
							width="20px"
							style="width: 20px !important;">No</th>
						<th style='color:white; background:#e46c0a;'
							class="text-center">Name</th>
						<th style='color:white; background:#e46c0a;'
							class="text-center">Qty Used</th>
						<th style='color:white; background:#e46c0a;'
							class="text-center">Optimum(Average)</th>
						<th style='color:white; background:#e46c0a;'
							class="text-center">Estimated</th>
						<th style='color:white; background:#e46c0a;'
							class="text-center">Qty Left</th>
						<th style='color:white; background:#008000;'
							class="text-center">Status</th>
					</tr>
					</thead>
					<tbody>
					<?php $i=1; ?>
                                            
					@foreach($fStorages as $fStorage)
					<tr>
					<td style="vertical-align:middle"
						class="text-center no-sort" width="20px" >
						{{$i++}}
					</td>
					<td style="vertical-align:middle;text-align:left;">
					<img style="object-fit:cover;"
						width="30" height="30"
						src="{{url()}}/images/product/{{$fStorage->id}}/thumb/{{$fStorage->thumb_photo}}">
						&nbsp;{{$fStorage->product_name}}
					</td>
					<td style="vertical-align:middle" class="text-center">
					<a onclick="showAjaxModal({
						data:{product_id:<?php echo $fStorage->id; ?>},
						url:'/seller/get-quantity-detail',
						success:function(response){
							fStorageMainAjaxFunction(response,
								'#discardDoPopUp') }},
						'#discardDoPopUp')" href="javascript:;">
						{{$quantity_used=floor((!empty($fStorage->quantity_sold)?$fStorage->quantity_sold:0)+(!empty($fStorage->wastage_quantity)?$fStorage->wastage_quantity:0))}}
                                                <!--+$fStorage->raw_quantity-->
					</a>
					</td>
					<?php 
					$qtyLeft = $fStorage->total_quantity;
					?>
					<td style="Vertical-align:middle" class="text-center">
					{{number_format(!empty($fStorage->days)?$qtyLeft/$fStorage->days:"0",2)}}
					</td>
					<td class="text-center"
						style='vertical-align:middle;border-radius:5px;cursor:text;border:1px solid rgb(228, 10, 127);'
						contenteditable='true'
						fstorage_id='{{$fStorage->fstorage_id}}'
						id='saveEstimatedValue'>
						{{$fStorage->estimated}}
					</td>
					<td style="vertical-align:middle"
						class="text-center">{{$qtyLeft}}</td>
					<td style="vertical-align:middle"
						class="text-center">
						{{(floor(($qtyLeft-$fStorage->estimated)/($fStorage->estimated!=0?$fStorage->estimated:1)))}}%
						{{$fStorage->status}}
					</td>
					</tr>
					@endforeach
					</tbody>
					</table>
					</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<div id="discardDoPopUp" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"
					data-dismiss="modal">&times;
				</button>
				<h3 class="modal-title" id="product_name"></h3>
			</div>
			<div class="modal-body" >
			<table class="table table-bordered table-responsive"
				id="delivery-order-table" >
			<thead class="aproducts">
			<tr style="background-color: #6d9270; color: #FFF;">
				<th style='color:white; background:#e46c0a;'
					class="text-center">Quantity Used</th>
				<th style='color:white; background:#993366;'
					class="text-center">Production Decimal </th>
				<th style='color:white; background:#008000;'
					class="text-center">Wastage Decimal</th>
			</tr>
			</thead>
			<tbody id="quantityDetails">
			<tr>    
				<td class="text-center">
					<a onclick="showAjaxModal({
						data:22,
						url:'seller/get-quantity-detail',
						success:function(response){
							fStorageMainAjaxFunction(response)}},
								'#quantityUsedDistribution')"
							href="javascript:;">22
					</a>
				</td>
				<td class="text-center">0.2</td>
				<td class="text-center">0.2</td>
			</tr>
			</tbody>
			</table>
			</div>
			<div class="modal-footer">
				<button type="button"
					class="btn btn-default"
					data-dismiss="modal">
					Close
				</button>
			</div>
		</div>
	</div>
</div>


<div id="quantityUsedDistribution" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h2>Quantity Usage Distribution</h2>
				<button type="button" 
                                        style="margin-top: -40px;
                                               margin-right: 10px;"
                                        class="close" data-dismiss="modal">
				&times;</button>
			</div>
			<div class="modal-body">
			<table class="table table-bordered table-responsive"
				id="delivery-order-table" >
			<thead class="aproducts">
				<tr style="background-color: #6d9270; color: #FFF;">
					<th style='color:white; background:#e46c0a;'
						class="text-center">Production </th>
					<th style='color:white; background:#008000;'
						class="text-center">Wastage</th>
				</tr>
			</thead>
			<tbody id="quantityDetails">
				
			</tbody>
			</table>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"
					data-dismiss="modal">Close
				</button>
			</div>
		</div>

	</div>
</div>


<div id="quantityUsedWastage" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"
					data-dismiss="modal">&times;</button>
					Wastage Ledger 
			</div>
			<div class="modal-body" >
			<table class="table table-bordered table-responsive"
				id="delivery-order-table" >
			<thead class="aproducts">
				<tr style="background-color: #6d9270; color: #FFF;">
				   <th class="text-center">No </th>
					<th class="text-center">Date </th>
					<th class="text-center">Qty</th>
				</tr>
			</thead>
			<tbody id="quantityDetails">
				<tr>
				<td class="text-center">1</td>
				<td class="text-center">2</td>
				<td class="text-center">4</td>
				</tr>
			</tbody>
			</table>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"
					data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div id="quantityUsedProduction" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"
					data-dismiss="modal">&times;</button>
					Production Ledger 
			</div>
			<div class="modal-body" >
			<table class="table table-bordered table-responsive"
				id="delivery-order-table" >
			<thead class="aproducts">
				<tr style="background-color: #6d9270; color: #FFF;">
				   <th class="text-center">No.</th>
					<th class="text-center">Date </th>
					<th class="text-center">Qty</th>
				</tr>
			</thead>
			<tbody id="quantityDetails">
				<tr>
				<td class="text-center">1</td>
				<td class="text-center">2</td>
				<td class="text-center">4</td>
				</tr>
			</tbody>
			</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"
					data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
function showAjaxModal(ajaxSettings,modal_id){   
	$(modal_id).modal("show");
	$(modal_id).find("table tbody").html(
		"<tr><td colspan='4'>....loading</td></tr>");
	$.ajax(ajaxSettings)    
}

function fStorageMainAjaxFunction(data,pointer){
	$(pointer).find("tbody").html("");
	var product_name="";
	var product_id="";
	var thumb_photo="";
	var nproduct_id="";

	$.each(data.data,function(index,value){
		product_name=value.product_name;
		product_id=value.id;
		thumb_photo=value.thumb_photo;
		nproduct_id=value.nproduct_id;
		$(pointer).find("tbody").append(`<tr><td class="text-center">
		<a onclick="showAjaxModal({data:{product_id:${value.id}},
			url:'/seller/get-quantity-distribution-detail',
			success:function(response){
				quantityDistributionAjaxFunction(response,
					'#quantityUsedDistribution')}},
					'#quantityUsedDistribution')" href="javascript:;">
			${parseInt(Math.floor((+value.production)+(+value.wastage_quantity)))}</a></td>
			<td class="text-center">${(value.production%1).toFixed(4)}</td>
			<td class="text-center">${(value.wastage_quantity%1).toFixed(4)}</td></tr>`);
	})
//        +(+value.raw_quantity

	$("#product_name").html(`
		${product_name}<br>
		<img style="object-fit:cover;"
			height="50" width="50"
			src="/images/product/${product_id}/thumb/${thumb_photo}">
		<a style="font-size:16px"
			href='/productconsumer/${product_id}'>&nbsp;
			${nproduct_id}</a>
	`);
}
    
    
function quantityDistributionAjaxFunction(data,pointer){
        $(pointer).find("tbody").html("");
        var no=1;
 $.each(data.data,function(index,value){
     $(pointer).find("tbody").append(`<tr><td>${no++}</td>
<td class="text-center">
<a target="_blank" href='/production-ledger/${value.id}'>
    ${Math.floor(value.production)}
</a>
</td>
<td class="text-center">
<a target="_blank" href='/wastage-ledger/${value.id}'>
    ${Math.floor(value.raw_quantity!=undefined?value.raw_quantity:0)}
</a>
</td>
    <td></td>
</tr>`)
 });
    } 
$(document).ready(function() {
	$("#saveEstimatedValue").focusout(function(){
		$.ajax({
		url:"/seller/save-fstorage-estimate",
			data:{
			estimate:$(this).text(),
				fstorage_id:$(this).attr("fstorage_id")},
				success:function(data){
					toastr.info(data.message);
				}
		})
    });

	$('link[rel=stylesheet][href~="{{asset(' /css/select2.min.css')}}"]').remove();
	$('form .input-sty').change(function() {
		$('form .p-sty').text(this.files.length + " file(s) selected");
	});
});

$('#delivery-order-table').DataTable();

</script>
@stop

