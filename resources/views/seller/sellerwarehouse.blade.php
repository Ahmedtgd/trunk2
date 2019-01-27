@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Models\Currency;

$total_smm_army=0;
$channels = array(
	array('id'=> 1, 'description' => 'Email', 'checked' => true),
	array('id'=> 2, 'description'=> 'SMM Army', 'checked' => true));
$currency =   $currency = Currency::where('active', 1)->first();
$currencyCode = $currency->code;
?>
@section("content")
@include('common.sellermenu')

<script type="text/javascript" src="{{asset('js/canvas.js')}}"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
	  integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{asset("css/rangeslider.css")}}">

<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>

<script type="text/javascript" src="<?php echo e(asset('js/qr.js')); ?>"></script>
<style>
.form-group{
	padding: 10px !important
	;
}
.dataTables_empty 
{ text-align: center !important; }
	/*.storebutton{
		background-color: #FF3333 !important;
		}*/
	/*.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover, .nav-tabs>li>a:hover{
		color: white;
		background-color: #ffcc00;
		}*/
.breakword {
	white-space:nowrap;
	width: 100%;
	display: block;
	overflow: hidden;
	text-overflow: ellipsis;
}

#add_rack:hover{
	color:#808080;
	background-color:darkorange;	
}	

#add_rack{
	background-color:#ffcc00;
	width:70px;
	height:70px;
	margin-bottom:10px;
	margin-top:-16px !important;
	
	border-radius: 5px;
	border-color: #ffcc00;
}	

	</style>


	<style type="text/css">
	/*.nav li a:focus, .nav li a:hover {
   		background-color: transparent !important;
    	color: #fff;
    	}*/
    </style>

    <section class="">
    	<div class="container">
    		<div class="row">
    			<div class="col-sm-12">  
    				{{-- Tabbed Nav --}}

    				<div class="panel with-nav-tabs panel-default ">
    					<div class="panel-heading">
    						<h2>Warehouse & Rack Management</h2>
    						@if(count($warehouses) > 0 )
    						<ul class="nav nav-tabs">
    							<?php $e=1; ?>
    							@foreach($warehouses as $warehouse)
    							<?php $class = "active"; if($e > 1){ $class =  ''; } ?>

    							<li class='{{ $class }}'><a href="#w_{{$warehouse->warehouse_id}}"  onclick="getwarehouse({{$warehouse->warehouse_id}})" data-toggle="tab">{{$warehouse->branch_name}}</a></li>
    							<?php $e++;?>
    							@endforeach
    						</ul>
    						@endif
    						@if((count($warehouses) <= 0) or empty($warehouse))
    						<div>{{' No warehouse found '}}</div>
    						@endif
    					</div>
    				</div>
    				{{--ENDS  --}}
    				<div id="dashboard" class="row panel-body " >
    					<div class="tab-content top-margin" style="margin-top:-30px">
    						@if((count($warehouses) > 0) and (!empty($warehouses)) )
    						<?php
								$e=1;
								Log::debug('****** $warehouses ******');
								Log::debug($warehouses);
							?>
    						@foreach($warehouses as $w)
    						<?php $class = "active"; if($e > 1	){ $class =  ""; } ?>
    						<div id="w_{{$w->warehouse_id}}" class="tab-pane fade in {{$class}}">
    							<!-- <div id="warehouse" class="tab-pane fade in active"> -->
    								<div class="row">
    									<div class=" col-sm-12">
    										<h3 style="margin-top:20px !important;">{{$w->branch_name}}
    											<small>
												{{-- <div class="sellerbutton pull-right" id='' style="background-color:#ffcc00">
													<span
													style="
													margin-top:15px;
													"
													> --}}
													{{-- <a 
													href="javascript:void(0)" 
													style="color:white;
													font-size:15px;
													" 
													class="saverack" rel-warehouseid={{$w->warehouse_id}}>
													+ Rack
												</a> --}}
												<button type="submit" id="add_rack"
												class="btn btn-warning pull-right saverack"
												rel-warehouseid={{$w->warehouse_id}} >+ Rack</button>
												<input type="text" name="warehouse"
												value="{{$w->warehouse_id}}" id="warehouse" hidden></input>
											{{-- </span>
										</div> --}}
    									</small>
    								</h3>
    							</div>
    						</div>
    						<table id="table_{{$w->warehouse_id}}" class="warehousedatatable" cellspacing="0" class="table table-bordered" width="100%">
    							<thead>
    								<tr class="bg-warehouse">
    									<th class="text-center" >No.</th>
    									<th class="text-center" >Rack No.</th>
										<th class="text-center"> Description</th>
    									<th class="text-center" >Allocated Products</th>
    									<!-- <th class="text-center" >Barcode/QR</th> -->
    									<th class="text-center" >Next Expiry</th>
    									<th class="text-center" >Remarks</th>
										

    								</tr>
    							</thead>
    							<tbody id="tbody_{{$w->warehouse_id}}">

    							</tbody>
    						</table>
    					</div>
    					<?php $e++;?>
    					@endforeach
    					@endif
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

</section>
<!-- Modal -->


<div id="remarksModal" class="modal fade" role="dialog" data-backdrop="false">
	<div style="width: 43% !important" class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Remarks</h4>
				<input type="text" id="remarks_rack_number" name="remarks_rack_number" value="" hidden>
				<input type="text" id="warehouse_field_id" name="warehouse_field_id" value="" hidden>				
								
				
			</div>
			<div class="modal-body">
				<div>
			   

				<textarea id="rack_remarks" name="rack_remarks" rows="4" style="width:100%;" onblur="saverackremarks()"></textarea>

				</div>
			</div>
      {{-- 
        <form id="rackform">
        	<input type="hidden" name="warehouse_id" value="" id="warehouse_id">
        	<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="rack_no">Rack No</label>  
			  <div class="col-md-5">
			  <input id="rack_no" name="rack_no" placeholder="eg:0001" class="form-control input-md" required="" type="number">
			    
			  </div>
			</div>
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="description">Description</label>  
			  <div class="col-md-5">
			  <input id="description" name="description" placeholder="eg:left rack by the end" class="form-control input-md" type="text">
			    
			  </div>
			</div>
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="name">Name</label>  
			  <div class="col-md-5">
			  <input id="name" name="name" placeholder="eg:WhiteRack" class="form-control input-md"  type="text">
			    
			  </div>
			</div>
			<!-- Text input-->
			<!-- Button (Double) -->
			<div class="form-group" style="margin-top:30px !important;">
			  <label class="col-md-4 control-label" for="button1id"></label>
			  <div class="col-md-8">
			    <button  type="button" id="saverack" name="button1id" class="btn btn-success">Save</button>
			    <button id="cancelrack" name="cancelrack" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			  </div>
			</div>
			
		</form> --}}
	</div>
	<div class="modal-footer">

	</div>
</div>

</div>

<!-- Delete message modal -->


<div id="deleteModal" class="modal fade" role="dialog" data-backdrop="false">
		<div style="width: 30% !important;" class="modal-dialog">
	
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					{{-- <input type="text" id="remarks_rack_number" name="remarks_rack_number" value="" hidden> --}}
					<input type="text" id="rack_row_number" name="rack_row_number" value="" hidden>				
									
					
				</div>
				<div class="modal-body" style="height:100px !important">
					<div>
					<h4 class="modal-title">Are you sure to delete the rack?</h4>
				   
					<button class="btn btn-danger pull-right delete_the_rack" style="margin-left:2px;border-radius:5px">Yes</button>
					<button class="btn btn-danger pull-right " data-dismiss="modal" style="border-radius:5px">Cancel</button>
					
					
					{{-- <textarea id="rack_remarks" name="rack_remarks" rows="4" style="width:100%;" onblur="saverackremarks()"></textarea> --}}
					</div>
				</div>
	
		</div>
		<div class="modal-footer">
			
		</div>
	</div>
	
	</div>


<!-- Modal -->
<div id="productModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:80% !important">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Allocated Products</h3>
				<h4 class="modal-title" style="float:right;margin-right:40px!important;margin-top:-25px!important;">Rack No: <span id="racknomodalpro" name="racknomodalpro"></span></h4>
			</div>
			<div class="modal-body">

				<table class="table" id="rackproducts"
				style="width:100% !important;" >
				<thead>
					<tr class="bg-warehouse">
						<th class="text-center">No.</th>
						<th style="width:40% !important"
							class="text-left">Product Name</th>
						<th class="text-center">Qty</th>
						<th class="text-center">Expiry Date</th>
						<th class="text-center">Remove</button></th>
					</tr>
				</thead>
				<tbody id="tbody_rp">

				</tbody>
			</table>
      {{-- 
        <form id="rackform">
        	<input type="hidden" name="warehouse_id" value="" id="warehouse_id">
        	<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="rack_no">Rack No</label>  
			  <div class="col-md-5">
			  <input id="rack_no" name="rack_no" placeholder="eg:0001" class="form-control input-md" required="" type="number">
			    
			  </div>
			</div>
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="description">Description</label>  
			  <div class="col-md-5">
			  <input id="description" name="description" placeholder="eg:left rack by the end" class="form-control input-md" type="text">
			    
			  </div>
			</div>
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="name">Name</label>  
			  <div class="col-md-5">
			  <input id="name" name="name" placeholder="eg:WhiteRack" class="form-control input-md"  type="text">
			    
			  </div>
			</div>
			<!-- Text input-->
			<!-- Button (Double) -->
			<div class="form-group" style="margin-top:30px !important;">
			  <label class="col-md-4 control-label" for="button1id"></label>
			  <div class="col-md-8">
			    <button  type="button" id="saverack" name="button1id" class="btn btn-success">Save</button>
			    <button id="cancelrack" name="cancelrack" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			  </div>
			</div>
			
		</form> --}}
	</div>
	<div class="modal-footer">

	</div>
</div>




</div>
</div>
<div id="rackModal" class="modal fade" role="dialog" data-backdrop="false">
	<div style="width: 90% !important" class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Rack No <span id="racknomodal" name="racknomodal"></span></h4>
				<input type="text" id="rack_number" name="rack_number" value="" hidden>

			</div>
			<div class="rack_modal-body">

				@include('seller.qrsetting_rack_ajax')
			</div>

		</div>
		<div class="modal-footer">

		</div>
	</div>

</div>
</div>
<script>



</script>
@stop

@section("scripts")


<script type="text/javascript">
	$("#rackModal").modal("show");
	$("#rackModal").css('display','none');
	$(document).ready(function(){
		$("#rackModal").modal("hide");
		$("#rackModal").css('display','block');


var element = $("#qrcode-container-download"); // global variable
var getCanvas; // global variable



$("#btn-Preview-Image").on('click', function () {
      //toastr.info('Please Wait Converting');
      html2canvas(element, {
      	onrendered: function (canvas) {
                //$("#previewImage").append(canvas);
                getCanvas = canvas;
                $('#btn-Convert-Html2Image').removeClass("nonebtn");

                toastr.success('Convertd Ready for download');

            }
        });
  });

$("#btn-Convert-Html2Image").on('click', function () {

	var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "12.png").attr("href", newData);
});

});


	$('#print').click(function(){
		window.print();

	});

	$(document).ready(function(){
		var newqrcode = function() {

			$('.productname').css("width", $("#bar-width").val()*2);
			$('.productexpiry').css("width", $("#bar-width").val());
			$('.productname').css("font-size", $("#bar-fontSize").val()+"px");
			$('.productexpiry').css("font-size", $("#bar-fontSize").val()+"px");



			$("#bar-width-display").text($("#bar-width").val());
			$("#bar-height-display").text($("#bar-height").val());
			$("#bar-fontSize-display").text($("#bar-fontSize").val());
			$("#bar-margin-display").text($("#bar-margin").val());
			$("#bar-text-margin-display").text($("#bar-text-margin").val());


			var margin =   $("#bar-text-margin").val();
			$('.productname').css("margin-bottom", margin+"px");
			$('.productexpiry').css("margin-top", margin+"px");
			var value=$("#userInput").val();
			$('#qrcode').html('');


			$('#qrcode').qrcode({height:parseInt($("#bar-height").val()),width:parseInt($("#bar-width").val()),text:value});

		};




		$("#description").change(function(){
			$('.productname').html($('#description').val());
		});
		$("#userInput").on('input',newqrcode);
		$("#price").on('input',function(){

			$('.qrprice').html($("#price").val());
		});
		$("#description").on('input',function(){

		});


		$(".text-align").click(function(){
			$(".text-align").removeClass("btn-primary");
			$(this).addClass("btn-primary");
			$('.productname').css("text-align", $(this).val());
			$('.productexpiry').css("text-align", $(this).val());

		});

		$(".font-option").click(function(){
			if($(this).hasClass("btn-primary")){
				$(this).removeClass("btn-primary");
				$('.productname').css("font-weight","");
				$('.productexpiry').css("font-weight","");
			} else {
				$(this).addClass("btn-primary");
				$('.productname').css("font-weight", $(this).val());
				$('.productexpiry').css("font-weight", $(this).val());
			}


		});

		$(".italic").click(function(){
			if(!$('.italic').hasClass("btn-primary")){
				$('.italic').removeClass("btn-primary");
				$('.productname').css("font-style","");
				$('.productexpiry').css("font-style","");
			} else {
				$('.italic').addClass("btn-primary");
				$('.productname').css("font-style", $(this).val());
				$('.productexpiry').css("font-style", $(this).val());
			}


		});

		$(".display-text").click(function(){
			$(".display-text").removeClass("btn-primary");
			$(this).addClass("btn-primary");

			if($(this).val() == "true"){
				$("#font-options").slideDown("fast");

				$("#font-options").css("display", 'block');
			} else {
				$("#font-options").slideUp("fast");
			}
			newqrcode();
		});

		$("#font").change(function(){
			$(this).css({"font-family": $(this).val()});
			$('.productname').css("font-family", $(this).val());
			$('.productexpiry').css("font-family", $(this).val());
		});
		$("#background-color").change(function(){
			newqrcode();
		});

		$('input[type="range"]').rangeslider({
			polyfill: false,
			rangeClass: 'rangeslider',
			fillClass: 'rangeslider__fill',
			handleClass: 'rangeslider__handle',
			onSlide: newqrcode,
			onSlideEnd: newqrcode
		});
		newqrcode();
	});

	var dts={}
	var productdatatable=$("#rackproducts").DataTable({});
	function pad($n) {
		var str = "" + $n
		var pad = "00000"
		var ans = pad.substring(0, pad.length - str.length) + str
		return ans
	}

	function get_rack_product_data($rack_no,$warehouse_id) {
		var url="{{url("warehouse/rack/products",$selluser->id)}}";

		productdatatable.destroy();
		data={warehouse_id:$warehouse_id,rack_no:$rack_no};
		//alert("here");
		$.ajax({
			url:url,
			type:"POST",
			data:data,
			success:function(r){

				if (r.status=="success") {

					data=r.data;

					var html="";
					var serial_number=0;
					for (var i =0;i<data.length;i++) {
						d=data[i];
						serial_number=i+1;
						if (d.name!=null) {
							html+=`
							<tr>
							<td class="text-center" style="vertical-align:middle">`+serial_number+`</td>
							<td class="text-left" style="width:50%;vertical-align:middle">

							<img 
							style='height:30px;width:30px;object-fit:"contain"'
							src="`+JS_BASE_URL+`/images/product/`+d.id+`/thumb/`+d.thumb_photo+`"/>
							<a class="" rel-data="`+d.id+`"
							href="`+JS_BASE_URL+`/productconsumer/`+d.id+`"
							target="_blank"
							>`+d.name+`</a></td>

							<td class="text-center" style="vertical-align:middle"><a href="`+JS_BASE_URL+`/productledger/`+$rack_no+`/`+d.id+`" target="_blank">`+d.quantity+`</a></td>
							<td class="text-center" style="vertical-align:middle">`+d.expiry_date+`</td>
							<td class="text-center" style="vertical-align:middle"><button style="border-radius:5px" class="btn btn-danger" type="button" onClick="deleteRow(this,`+d.id+`,`+d.quantity+`)"><i class="fa fa-times"></i></button></td>	

							</tr>
							`;
						}
					}
					
					$("#tbody_rp").text("");
					$("#tbody_rp").append(html);
					productdatatable=$("#rackproducts").DataTable({});
					
				}
			}
		})
	}
	function get_rack_data($warehouse_id) {
		var post="{{$selluser->id}}";
		var url="{{url("warehouse/rack")}}"+"/"+$warehouse_id;
		url+="/"+post;
		$.ajax({
			url:url,
			type:"GET",
			success:function(r){
				if (r.status=="success") {
					data=r.data;

					var html="";
					var serial_number=0;
					for (var i =0;i<data.length;i++) {
						d=data[i];

						serial_number+=1;
						if(d.remarks==null){d.remarks=""}
						html+=`

						<tr>
						<td class="text-center">`+serial_number+`</td>
						<td id ="rack`+d.rack_no+`_`+$warehouse_id+`" class="text-center"><a class="showqrrackmodal" rel-rack-data="`+d.rack_no+`" onclick="add_rowid(`+serial_number+`)">`+pad(d.rack_no)+`</a></td>
						<td title="" id ="desc`+d.rack_no+`_`+$warehouse_id+`"  style="vertical-align:middle;">`+d.description+`</td>
						<td class="text-center"><a class='show_product_names'
						rel-warehouseid="`+$warehouse_id+`"
						rel-rackno="`+d.rack_no+`"
						href="javascript:void(0)">`+d.product_count+`</a></td>

						<td class="text-center">`+d.expiry_date+` <span style="display:none" >`+d.remarks+`</span></td>
						<td class="text-center"><input type="text" id="rem`+d.rack_no+`_`+$warehouse_id+`" name="remarks_`+d.rack_no+`_`+$warehouse_id+`" rel_rack_remarks=`+d.rack_no+` value="`+d.remarks+`"  style="margin-right:-20px" class="remarkPopUp"></td>
						
						</tr>
						`;

											}
					if (serial_number==0) {
						html=`<tr>
						<td></td>
						<td class="" style="width:43%;text-align:right !important">No records found...</td>
						<td></td>
						<td></td>


						</tr>;
						`
					}
					$("#tbody_"+$warehouse_id).append(html);
					tmp=$("#table_"+$warehouse_id).DataTable({
						autoWidth:false
					});
				
					dts[$warehouse_id]=tmp;
					//$('.warehousedatatable').DataTable({});
				}
			}
		})
	}



	$(document).ready(function(){
		@foreach($warehouses as $warehouse)
		get_rack_data({{$warehouse->warehouse_id}})
		@endforeach



		$("body").on("click",".remarkPopUp",function(){
			//alert("hi");
			$rack_no=$(this).attr("rel_rack_remarks");
			//$rack_no = $("input[name=remarks_rack_number]").val();
		var warehouse_id = $("input[name=warehouse_field_id]").val();
		var warehouse_i = $("input[name=warehouse]").val();
		
			//$w=$("input[name=warehouse]").val();
			//alert($rack_no);
			//alert(warehouse_id);
			$("input[name=remarks_rack_number]").val($rack_no);
			//rem=$("input[name=remarks_"+$rack_no+"_"+warehouse_id+"]").val();
			//rem=$("input[name=remarks_"+$rack_no+"_"+warehouse_id+"]").val();
			//alert($rem);
			//$("#rack_remarks").val($rem);
			//alert($rem);
			
			//alert($rack_no);			
			$("#remarksModal").modal("show");
			

		});
		$("body").on("click",".showqrrackmodal",function(){

			var rack_no=$(this).attr("rel-rack-data");
            var ware_id = $("input[name=warehouse]").val();
			//alert(ware_id);


			$('#userInput').attr('value',pad(rack_no));
			$('#description').attr('value','Rack No. ' + pad(rack_no));
            $('.productname').html(('Rack No. ' + pad(rack_no)).bold());
			$("#racknomodal").text(pad(rack_no));

			$("#rackModal").modal("show");
			$("input[name=rack_number]").val(rack_no);

            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/seller/warehouse/get_description",
                data: {"ware_id":  ware_id, "rack_no": rack_no},
                success: function( data ) {
                    $('#price').val(data.description);
                    $("#rackModal").modal("show");
                    $("input[name=rack_number]").val(rack_no);
//				 $('.rack_modal-body').html(data);
//				 $("#rackModal").modal("show");
                }
            });



			/*$('#qrcode').qrcode(
				{width:110,height:110,text:$rack_no}
			);

			canvas=document.querySelector('canvas');

			var ctx=canvas.getContext("2d");

 			ctx.font="18px Arial";
 			ctx.fillText("Rack No. 123",0,130);


			$("#racknomodal").text($rack_no);
			$("#rackModal").modal("show");*/

		});
		$("body").on("click",".show_product_names",function(){
			$rack_no=$(this).attr("rel-rackno");
			//alert($rack_no);
			$("#racknomodalpro").text(pad($rack_no));
			$warehouse_id=$(this).attr("rel-warehouseid");
			get_rack_product_data($rack_no,$warehouse_id);
			$("#productModal").modal("show");

		});

		$(".delete_the_rack").click(function(){
        // alert("hi");
        var warehouse_id = $("input[name=warehouse]").val();
        var row = $("input[name=rack_row_number]").val();
		
        // alert(warehouse_id);
		var rack = $("#racknomodal").text();

		$.ajax({
			url:url,
			type:"POST",
			data:{'warehouse_id':warehouse_id,'rack_id':rack},
			success:function(r){
				if (r.status=="success") {
					/*				$("#rackModal").modal("hide");*/
					toastr.info("Rack Deleted!");
					$("#tbody_"+data.warehouse_id).text("");

					dts[data.warehouse_id].clear().destroy();
					get_rack_data(data.warehouse_id);
					

				}else{
					toastr.warning(r.long_message);
				}
			},
			error:function(){
				toastr.warning("Could not connect to server!");
			}
		});

			$("#deleteModal").modal("hide");
			$("#rackModal").modal("hide");			
            
      
		});


		

		$(".saverack").click(function(){
			var url ="{{url("seller/rack",$selluser->id)}}";
			/*var rack_no=$("#rack_no").val();
			if (!rack_no) {
				alert("Rack Number is required");
				return;
			}*/
			var data={
				warehouse_id:$(this).attr("rel-warehouseid")
			};

			$.ajax({
				url:url,
				type:"POST",
				data:data,
				success:function(r){
					if (r.status=="success") {
						/*				$("#rackModal").modal("hide");*/
						toastr.info("Rack added!");
						$("#tbody_"+data.warehouse_id).text("");

						dts[data.warehouse_id].clear().destroy();
						get_rack_data(data.warehouse_id);

					}else{
						toastr.warning(r.long_message);
					}
				},
				error:function(){
					toastr.warning("Could not connect to server!");
				}
			});
		});
		/*$('.warehousedatatable').DataTable({});*/
	});
	function saverackremarks(){
		var url ="{{url("seller/rack/remarks",$selluser->id)}}";
		var r = $("#rack_remarks").val();
		//$(this).attr("rel_rack_remarks");
		$rack_no = $("input[name=remarks_rack_number]").val();
		var warehouse_id = $("input[name=warehouse_field_id]").val();
		var warehouse_i = $("input[name=warehouse]").val();
		//alert(warehouse_i);
		if(warehouse_id==""){
			warehouse_id=warehouse_i;
		}
		//alert(warehouse_id);
		
		//alert($rack_no);
		$.ajax({
				url:url,
				type:"POST",
				data:{'warehouse_id':warehouse_id,'remarks':r,'rack_id':$rack_no},
				success:function(r){
					if (r.status=="success") {
						/*				$("#rackModal").modal("hide");*/
						toastr.info("Remarks successfully saved!");
						$("#tbody_"+data.warehouse_id).text("");

						dts[data.warehouse_id].clear().destroy();
						get_rack_data(data.warehouse_id);

					}else{
						toastr.warning(r.long_message);
					}
				},
				error:function(){
					toastr.warning("Could not connect to server!");
				}
			});
			//alert("remarks"+$rack_no);
			
			$("input[name=remarks_"+$rack_no+"_"+warehouse_id+"]").val(r);
			$("#rack_remarks").val("");
			$("#remarksModal").modal("hide");

			//alert("Hi Remarks");
		}	

		



	function deleteRow(r,id,q) {
	//alert(r);
	if(q==0){
		var i = r.parentNode.parentNode.rowIndex;
		document.getElementById("rackproducts").deleteRow(i);
	}
    var rack = $("#racknomodal").text();
	var rack_no=$(this).attr("rel-rackno");
	var r = $("input[name=rack_number]").val();
	
	//alert(r);
	var warehouse_id = $("input[name=warehouse]").val();
	var url ="{{url("warehouse/rack/remove_product",$selluser->id)}}";	
	

				$.ajax({
				url:url,
				type:"POST",
				data:{'warehouse_id':warehouse_id,'product_id':id,'rack_id':rack},
				success:function(r){
					if (r.status=="success") {
						/*				$("#rackModal").modal("hide");*/
						toastr.info("Product Deleted!");
						$("#tbody_"+data.warehouse_id).text("");

						dts[data.warehouse_id].clear().destroy();
						get_rack_data(data.warehouse_id);

					}else{
						toastr.warning(r.long_message);
					}
				},
				error:function(){
					toastr.warning("Could not connect to server!");
				}
			});

	


}
function add_rowid(r){




}

	var price = $("#price");
	price.on('blur', function(){
		var id = $("input[name=warehouse]").val();
		var r = $("input[name=rack_number]").val();
		var desc = price.val();

		save_to_rack(r,id,desc)
        save_to_rack(r,id,desc);
        $('#desc'+r+'_'+id).html(desc);
	});
	function save_to_rack(r,id,desc){
		//alert("hit");
		var rack_no =  r;
		var remarks = $('#rem'+r+'_'+id).val();

		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/seller/store_racks",
			data:{"rack_no":rack_no,"description" : desc,"warehouse_id": id,"remarks" : remarks},
			success: function( data ) {
				toastr.info("Successfully saved!");

			}
		});
	}

function getwarehouse(w){
//alert(w);
 $("input[name=warehouse]").val(w);
 $("input[name=warehouse_field_id]").val(w);

}

</script>
<script type="text/javascript" src="{{asset('js/rangeslider.js')}}"></script>

@stop
