<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')

@if (Session::has('error'))
<div class="alert alert-danger">
	<strong>Danger!</strong> Please Select a Station.
</div>
@endif
<script type="text/javascript">

	var quantitiy=0;
	$(document).ready(function(){
		$("#einventorytable").keypress(function (evt) {
			var charCode = evt.charCode || evt.keyCode;
			if (charCode  >=48 && charCode <=57 || charCode==13 ) {
				
			}
			else{
				evt.preventDefault();
			}
		});
	});
	function qtyupdate(index,pid) {
        if ($('#price'+index).val()<0) {

            $('#price'+index).val( ($('#price'+index).val() * -1));
        }
		var quantity = $('#d'+index).val();
		quantity = quantity.replace(/^0+/, '');
		var qtyfield = '<input  onchange="qtyupdate('+index+','+pid+');"  type="number" id="d'+index+'" name="quantity'+pid+'" class="form-control text-center input-number" value="'+quantity+'" min="0" max="1000000">';
		$('#qtyfield'+index).html(qtyfield);
		$('#is'+index).attr("value", quantity);
		$('#price'+index).attr('required',true);

		var price = $('#price'+index).val();

		if (price=="") {
			var html = '<input type="text" required="" id="price'+index+'" onchange="qtyupdate('+index+','+pid+');"  class="form-control text-center myr-price wholesale wholesalep"  name="setprice'+pid+'" value="0" min="0" max="1000000000">'
			$('#resetto0'+index).html(html);
		}
            //total = parseInt(total)+parseInt(price);
            //$('.totalget').html(total);
            // $('.total').html(total.toFixed(2));
            finalPrice = price*quantity;
            $('#pricetotal'+index).html(finalPrice.toFixed(2));

            // Increment

        }


        function plus(index,id) {

            // Stop acting like a button

            // Get the field name
            var quantity = $('#d'+index).val();

            var qtyfield = '<input  onchange="qtyupdate('+index+','+id+');"  type="number" id="d'+index+'" name="quantity'+id+'" class="form-control text-center input-number" value="0" min="0" max="1000000">';
            $('#qtyfield'+index).html(qtyfield);
            // If is not undefined
            $('#d'+index).attr("value", ++quantity);
            // $('#i'+index).attr("value", quantity);
            $('#is'+index).attr("value", quantity);

            // var total = $('.totalget').html();
            var price = $('#price'+index).val();

            //total = parseInt(total)+parseInt(price);
            //$('.totalget').html(total);
            // $('.total').html(total.toFixed(2));
            finalPrice = price*quantity;
            $('#pricetotal'+index).html(finalPrice.toFixed(2));

            // Increment

        }

        function minus(index,id) {
            // Stop acting like a button

            // Get the field name
            var quantity = $('#d'+index).val();
            var qtyfield = '<input  onchange="qtyupdate('+index+','+id+');"  type="number" id="d'+index+'" name="quantity'+id+'" class="form-control text-center input-number" value="0" min="0" max="1000000">';
            $('#qtyfield'+index).html(qtyfield);
            // If is not undefined

            // Increment
            if(quantity>0){

            	$('#d'+index).attr("value", --quantity);
                //$('#i'+index).attr("value", quantity);
                $('#is'+index).attr("value", quantity);
                //var total = $('.totalget').html();
                var price = $('#price'+index).val();
                //total = parseInt(total)-parseInt(price);
                //$('.totalget').html(total);
                //$('.total').html(total.toFixed(2));
                finalPrice = price*quantity;

                $('#pricetotal'+index).html(finalPrice.toFixed(2));
            }
        }


    </script>
    <style>
    .float-right{
    	float: right;
    }
    .round{
    	width: 34px;
    	border-radius: 20px;
    	padding: 6px;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    	padding: 8px;
    	line-height: 1.42857143;
    	vertical-align: middle;
    	border-top: 1px solid #ddd;
    }
    .red{
    	background-color:#d9534f;
    }
    .red:hover{

    	background-color: #bf1510;
    	color: white;
    }
    .skyblue:hover{
    	background-color: #377482;
    	color: white;
    }
    .blue:hover{

    	background-color: #0b34ff;
    	color: white;
    }
    .error{
    	display: none !important;
    }
    .xer{
    	display: none !important;
    }
    .form-group5{
    	margin-bottom: 5px;
    }
    .controlbtn{

    	width: 70px;
    	height: 70px;
    	padding-top: 15px;
    	text-align: center;
    	vertical-align: middle;
    	font-size: 13px;
    	cursor: pointer;
    	margin-right: 5px;
    	margin-bottom: 5px;
    	border-radius: 5px
    }
    .blue{
    	background-color:#0725B9;
    }
    .skyblue{
    	background-color: #0CC0E8;
    	color:white;
    }
    .redblue{
    	background-color:#C9302C ;
    }

    .hide{
    	display: none;
    }
    .pointer:hover{
    	cursor: pointer;
    }
    @-webkit-keyframes spin {
    	0% { -webkit-transform: rotate(0deg); }
    	100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
    	0% { transform: rotate(0deg); }
    	100% { transform: rotate(360deg); }
    }
</style>
@include("common.sellermenu")
<meta name="_token" content="{{ csrf_token() }}" />
<script type="text/javascript">



	function selectedstation(id,isemerchant,name,company_name) {

		$('#myModal').modal('toggle');

		$('input[name=setbuyer]').val(id);
		$('input[name=isbuyer]').val(isemerchant);




		$("#showselectedbuyer").html(company_name).html();


	}



</script>

<div class="blur">
	<form method="POST"  id="einventoryform"  >
		<input hidden="" id="setbuyer" type="text" value="{{$user_id}}" name="user_id">
		<input hidden="" id="setbuyer" type="text" value="" name="setbuyer">
		<input hidden="" id="isbuyer" type="text" value="" name="isbuyer">
		<input hidden="" id="indoc_no" type="text" value="" name="doc_no">
		<input hidden="" id="indoc_date" type="date" value="" name="doc_date">
		<input type="hidden" name="location_id" >
		<input type="hidden" name="stockreport" value="0">
		<div class="table-responsive" style="margin-bottom: 28px;">

		</div>

		{{-- TABS --}}

		<div  class="container">
			<div class="start-loader-main "></div>
			<div style="float: right;color: white;padding-top:28px"
			type="button" id="previewso" class="skyblue sellerbutton">
		Preview</div>

		<div style="background-color:green;color:white;float: right;padding-top: 17px;" type="button"
		id="newbuyerbtn" class="sellerbutton"
		data-toggle="newbuyer" data-target="#newbuyer">
		New<br>Merchant</div>

		<div style="float: right;color: white;padding-top:28px"
		type="button"
		id="stationbtn" class="bg-black sellerbutton "
		onclick="einventoryBuyer()">Merchant</div>

		<h2 style=" width: 30%;float: left;padding-top: 5px;">Inventory Cost</h2>

		<div><h4 class="text-center" style="  color: #3c24ff;padding-top: 15px;   width: 40%;height: 60px; float: left;" id="showselectedbuyer"></h4></div>
		<!-- Modal -->


	</div>
	<div class="tab-content">
		<div id="maineinventorytable" >
			<div class="container">
				<table id="einventorytable" class="table table-bordered">
					<thead class="bg-inventory" style="font-weight:bold">
						<tr>
						<td class='text-center no-sort bsmall'>No</td>
						<td class='text-center bmedium'>Product ID</td>
						<td class='text-left bmedium'>Product Name</td>
						<td class='text-center bmedium' style="width:13%">
							Price&nbsp;({{$currentCurrency}})</td>
						<td style="width: 20% !important;"
						class='text-center bmedium'>Qty</td>
						<td style="width: 12%;"
						class='text-center bmedium'>
						Total ({{$currentCurrency}})</td>
					</tr>
				</thead>
				<tbody>
					<?php $index = 0; $save = $products ;?>
					@foreach($products as $product)
					<?php //echo "<pre>"; print_r($product->retail_price); exit; ?>
					<tr style="vertical-align: middle;">
						<td class='text-center bmedium'>{{++$index}}</td>
						<td class='text-center bmedium'><a target="_blank" href="{{URL::to("productconsumer/$product->parent_id")}}">{{$product->nproductid}}</a></td>
						<td style="text-align: left;" class=' bmedium'>
							<div style="width: 100%;float: left;">
								@if(File::exists(URL::to("images/product/$product->prid/thumb/$product->thumb_photo")))
								<img width="30" height="30" src="{{URL::to("images/product/$product->prid/thumb/$product->thumb_photo")}}">
								@else
								<img width="30" height="30" src="{{URL::to("images/product/$product->parent_id/thumb/$product->thumb_photo")}}">
								@endif
								&nbsp
								{{$product->name}}
							</div>
						</td>
						<td style="text-align: right;"  class='  bmedium'>

							<div class="input-group"  id='wping-{{$index}}'>
								<span id="resetto0{{$index}}">
									<input type="text" required="" id="price{{$index}}" onblur="qtyupdate({{$index}},{{$product->id}});"  class="form-control text-center myr-price wholesale wholesalep"  name="setprice{{$product->id}}" value="0" min="0" max="1000000000">
								</span>					
							</div>	
						</td>
						{{--	<span style="display: none;" id="priceget{{$index}}">{{$product->retail_price/100}}</span> --}}


						<td>
							<div style="margin-left: 10%;" class="col-lg-10">
								<div class="input-group">
									<span class="input-group-btn">
										<button onclick="plus({{$index}},{{$product->id}})" type="button" class="quantity-right-plus btn btn-css btn-primary btn-number" data-type="plus" data-field="">
											<span class="glyphicon glyphicon-plus"></span>
										</button>
									</span>
									<span id="qtyfield{{$index}}">
										<input onchange="qtyupdate({{$index}},{{$product->id}});"  type="number" id="d{{$index}}" name="quantity{{$product->id}}" class="form-control text-center input-number" value="0" min="0" max="1000000">
									</span>
									<span class="input-group-btn">
										<button onclick="minus({{$index}},{{$product->id}})" type="button" class="quantity-left-minus btn-css btn btn-primary btn-number"  data-type="minus" data-field="">
											<span class="glyphicon glyphicon-minus"></span>
										</button>
									</span>
								</div>
							</div>
						</td>
						<td style="text-align: right;" class=' bmedium'><span  id="pricetotal{{$index}}" >{{number_format(0/100,2)}}</span></td>

					</tr>


					@endforeach

				</tbody>
			</table>
		</div>
	</div>
	<?php $count = 1; ?>
			<!-- <div id="consignment" class="tab-pane fade">
		<h3>einventory</h3>
		<p>Content goes here</p>
	</div> -->
</div>
<?php $index=0;  $products = $save  ;?>
@foreach($products as $product)
<input  type="hidden" id="is{{++$index}}" name="product[{{$product->id}}]" class="form-control input-number" value="0" min="1" max="100000">

@endforeach

</form>


<style>
.myform {
	display: flex;
	align-items: center;
}

.myform label {
	order: 1;
	width: 12em;
	padding-right: 0.5em;
}

.myform input {
	order: 2;
	flex: 1 1 auto;
	margin-bottom: 0.2em;
}
</style>
@include('seller.gator.newbuyer')
<div class="modal fade" id="confirmmodel" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content text-center"
		style="width:100%;height:100%;vertical-align:middle">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3 class="text-left">Preview</h3>
		</div>
		<div style="padding:10px;" class="modal-footer-confirm">

		</div>
		<div class="modal-footer">
			<button style="padding-top: 12px;" id="submitform"
			style="color:white"
			type="button" class="btn skyblue controlbtn">
		Confirm</button>
	</div>
</div>

</div>
</div>
</div>


<div class="modal fade" id="myModal" role="dialog">
	<div style="width: 80%;"  class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">


			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Select Existing Merchant</h3>
			</div>
			<div class="modal-body">
				<div id="einventory-buyer"></div>

			</div>
			<div class="modal-footer">
				<br>
				<br>
				<br>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="emerchantdetailModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">


			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Merchant Details</h3>
			</div>

			<div class="modal-footer">
				<div id="emerchantdt">

				</div>
			</div>
			<div style="height: 77px;" class="modal-footer">

			</div>
		</div>

	</div>
</div>
<div class="modal fade" id="soModal" role="dialog">
	<div style="width: 80%;"  class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">


			<div class="modal-header">
				<button type="button" class="close"
					data-dismiss="modal">&times;</button>
				<h3>Sales Order</h3>
			</div>
			<div class="modal-body">
				<div id="sodisp"></div>

			</div>
			<div class="modal-footer">
				<br>
				<br>
				<br>
			</div>
		</div>

	</div>
</div>


<script>


	function einventoryBuyer() {
		$.ajax({
			type: "GET",
			url: JS_BASE_URL+"/seller/gatorbuyer/modal",
			success: function( data ) {
				$("#einventory-buyer").html(data);

				$('#myModal').modal('show');
			}
		});
	}


	function displayso(id) {

		$.ajax({
			type: "GET",
			url: JS_BASE_URL+"/seller/einventory/saleorder/"+id,
			success: function( data ) {

				$("#sodisp").html(data);
				$('#soModal').modal('show');
			}
		});
	}


	$("#btnsavebuyer").click(function(){
		
		formdata = $('#savebuyer').serialize();
		console.log(formdata);
		$.ajaxSetup({
			header:$('meta[name="_token"]').attr('content')
		})
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/seller/gatornewbuyer",
			data:formdata,
			success: function( data ) {
				$('#newbuyer').modal('hide');
				if (data == 0) {
		          toastr.error('New Merchant successfully Not Created');
		        } else {
		          toastr.success('New Merchant successfully Created');
				$("#showselectedbuyer").html(data.company_name);
				$('input[name=setbuyer]').val(data.id);
				$('input[name=isbuyer]').val(1);
				console.log(data);
			}
		}
		});

	});
	$('#previewso').click(function(){


		formdata = $('#einventoryform').serialize();
		console.log(formdata);
		$.ajaxSetup({
			header:$('meta[name="_token"]').attr('content')
		})
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/seller/einventoryconfirm",
			data:formdata,
			success: function( data ) {

				if (data == 0) {
					toastr.error('Please Select Merchant');

				}
				else if (data == 1) {
					toastr.error('Please add quantity');

				} else if (data == 2) {
                    toastr.error('Please add price');
                } else
				{
					$('#confirmmodel').modal('toggle');

					$('.modal-footer-confirm').html(data);

				}


				console.log(data);

			}
		});


	});
	$("#submitform").click(function(){
		$("#ioConfirmSIModal").modal("show");
	})
	//$('.confirmsubmitform').click(function(){
	$("body").on("click",".confirmsubmitform",function(){
		stockreport=0;
		if ($(this).attr('actiontype')=="stockreport") {
			stockreport=1
		}
		location_id=$(this).attr('location_id')
		var dncheck = $('#doc_no').val();
		var dtcheck = $('#doc_date').val();
		if (dncheck=="") {
			toastr.error('Please enter Document Number');

		}
		if (dtcheck=="") {
			toastr.error('Please enter Document date');
			$('#docnovalidate').submitform();
		}
		else
		{
			var doc_no = $('#doc_no').val();
			var doc_date = $('#doc_date').val();
			$('input[name=doc_no]').val(doc_no);
			$('input[name=doc_date]').val(doc_date);
			$('input[name=stockreport]').val(stockreport);
			$('input[name=location_id]').val(location_id);
			formdata = $('#einventoryform').serialize();
			console.log(formdata);
			$.ajaxSetup({
				header:$('meta[name="_token"]').attr('content')
			})
			$.ajax({
				type: "POST",
				url: JS_BASE_URL+"/seller/checkouteinventory",
				data:formdata,
				success: function( data ) {

					if (data == 0) {
						toastr.error('Please Select Station');
					}
					else if (data==1) {
						toastr.error('Please enter unique Document Number');

					} else if(data==2) {
						toastr.error('Please enter a valid Date');
					}  else if(data==3) {
						toastr.error('Document Number Already Taken');
					} else if(data==4) {
						toastr.success('Inventory Cost updated');
						$('#confirmmodel').modal('toggle');
						$("#showselectedbuyer").html("");
						$('input[type=text]').attr('value','0');
						$('input[type=hidden]').attr('value','');

						$('input[name=setbuyer]').attr('value','');
						$('input[name=isbuyer]').attr('value','');
						$('#gatorform').trigger("reset");
						 $(".modal").modal("hide");
                        //displayso(data);
                    } else{
                    	toastr.error('Something went wrong');
                    }

                    console.log(data);
                }
            });
		}
	});

	$('#newbuyerbtn').click(function(){
		$('#newbuyer').modal('toggle');
	});
//        $('#stationbtn').click(function(){
//            $('#myModal').modal('toggle');
//        });

var types = {treport:"Tracking Report", tin:"Stock In", tout:"Stock Out", tou:"Stock Out", smemo:"Sales Memo", stocktake:"Stock Take"};

$(document).ready(function(){
	var c_table = $('#consignment-open-channel').DataTable({
		'autoWidth':false,
		"columnDefs": [
		{"targets": 'no-sort', "orderable": false, },
		{"targets": "medium", "width": "80px" },
		{"targets": "bmedium", "width": "10px" },
		{"targets": "large",  "width": "120px" },
		{"targets": "approv", "width": "180px"},
		{"targets": "blarge", "width": "200px"},
		{"targets": "bsmall",  "width": "20px"},
		{"targets": "clarge", "width": "250px"},
		{"targets": "xlarge", "width": "300px" }
		]
	});
	$('#einventorytable').DataTable({
		"order": [],

	});

	var table = $('#supplier-open-channel').DataTable({
		'scrollX':true,
		'bScrollCollapse': true,
		'scrollX':true,
		'autoWidth':false,
		"columnDefs": [
		{"targets": 'no-sort', "orderable": false, },
		{"targets": "medium", "width": "80px" },
		{"targets": "bmedium", "width": "10px" },
		{"targets": "large",  "width": "120px" },
		{"targets": "approv", "width": "180px"},
		{"targets": "blarge", "width": "200px"},
		{"targets": "bsmall",  "width": "20px"},
		{"targets": "clarge", "width": "250px"},
		{"targets": "xlarge", "width": "300px" }
		]
	});
	$(".dataTables_empty").attr("colspan","100%");



});
$('link[href="{{asset('/css/select2.min.css')}}"]').remove();

</script>
@yield("left_sidebar_scripts")
@stop
