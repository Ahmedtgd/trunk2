<?php 
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
$total=0;
$c=1;
?>
<script type="text/javascript">
	function showqrmodel(id) {
		var pid = $("#getpid").val();
		$('input[name=product_id]').val(pid);
		$("#myModalMapping").modal("hide");
		$("#qrModal").modal("show");

	}
</script>
<style type="text/css">

#chk{
	width: 20%;
	margin-top: 17px !important;
	height: 21px !important;
}
</style>
<input id="getpid" type="number" name="product_id" hidden="hidden" value="{{$product->id}}">
<div class="overwrite">
<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel">Product Mapping</h4>
		</div>
<table id="productmapping" cellspacing="0" class="table"
style="width: 100% !important;padding:10px !important;">
<thead>

	<tr style="background-color: rgb(74, 69, 42); color: white;">
		<th>No.</th>
		<th class="text-center" >Product ID</th>
		<th class="text-center" colspan="2">BarCode</th>     

		<th class="text-center" style="width:40px;">&nbsp;</th>     
		<th class="text-center">QR</th>     
		<th class="text-center">SKU</th>     
	</tr>
</thead>

<tbody>
	
@if(!is_null($product))
<tr>
	<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

	<td style="text-align: center; vertical-align: middle;">
		{{$product->product_id}}
		<input type="hidden" value="{{$product->product_id}}" id="np_id">
	</td>

	<td style="text-align: center; vertical-align: middle;">
	</td>

	<td id="modalbarcode" style="text-align: center; vertical-align: middle;">

		@if(!empty($product->bcode))
		<span class="pmd_message">
			 <canvas style="cursor:pointer" id="barcode"></canvas>
			{{--<img src="{{asset('images/barcode/'.$product->id.'/'.$product->bcpath)}}"--}}
			{{--class="imgpid" mode="bc" rel-pid="{{$product->id}}"--}}
			{{--style="height:50px;width:150px;vertical-align: middle;">--}}
			<br>
			<span style="font-weight:bold;font-size:0.8em;"
			class="text-center">{{$product->bcode." (".$product->bcode_type.")"}}
		</span>
	</span>
	@else
	<span class="text-warning">Product has not been mapped.</span><br>
	<a target="_blank" style="color: red !important;" href="{{url("barcode/generate",$product->id)}}"><span style="color: red !important;" class="text-warning">Generate Barcode.</span></a>
	@endif

</td>

<td style="text-align: center; vertical-align: middle;width:50px;">
	@if(!empty($product->bcpath))
	<a href="javascript:void(0)"
	class='btn btn-danger product_map_delete'
	rel-pid="{{$product->id}}"
	style="border-radius:20px;">
	<i class="fa fa-times" aria-hidden="true"></i>
</a>
@endif
</td>

<td style="text-align: center; vertical-align: middle;">
	<div id="qr_img" style="cursor:pointer"
		onclick="showqrmodel({{$product->id}})"></div>
	{{--<img src="{{URL::to('/')}}/images/qr/product/{{$product->id}}/{{$product->qrpath}}.png"--}}
	{{--onclick="showqrmodel({{$product->id}})" class="show_qrbc" width="120px" mode="qr"--}}
	{{--rel-pid="{{$product->id}}"/>--}}
</td>
<td style="text-align: center; vertical-align: middle;
width:100px">
<span id="sinputproduct_sku{{$product->id}}">
	<input type="text" value="{{$product->sku}}"
	style="border-color:#e0e0e0;border-width:0.1px"
	rel="{{$product->id}}" class="product_sku_input"
	id="inputproduct_sku{{$product->id}}"/>
</span>	
</td>
</tr>
@endif
</tbody>
</table>
<div id="qrprintable">
	
</div>


<input type="hidden" id="selluser" value="{{$selluser}}" />
</div>
<script type="text/javascript" src="{{asset('js/qr.js')}}"></script>
<script type="text/javascript" src="{{asset('js/html2pdf.js')}}"></script>

<script type="text/javascript">

	$(document).ready(function(){

		$('.pmd_message').click(function(){
			var id = $(".imgpid").attr('rel');
			var selluser = $("#selluser").val();

			$.ajax({
				url: JS_BASE_URL + '/productbarmapping/' + selluser + '/' +{{$product->id}},
				cache: false,
				method: 'GET',
				success: function(result) {
					/*$("#myModalMapping").modal('hide');
					$("#barcodemodal").modal('show');*/
					var npro_id = $("#np_id").val();
					$(".overwrite").html(result);
                    newBarcode(npro_id);
                    newBarcode1(npro_id);
			}
			});			

			
		});
		/*$(".print_qr").click(function(){
			$("#qrprintable").text("");
			$(".qrcheckbox").each(function(i,elem){

				var printqr="";
				if ($(elem).prop("checked")==true) {
					console.log($(elem).attr("rel-content"));
					printqr+=`
					<div class='qrp' style='padding:10' rel-content='`+$(elem).attr("rel-content")+`'>
					</div>
					`;

				}
				$("#qrprintable").append(printqr);
				$(".qrp").text("");
				$(".qrp").each(function(i,elem){
					c=$(elem).attr("rel-content");
					$(elem).qrcode({width:200,height:200,text:c});
				})
			});
			var element = document.getElementById('qrprintable');
			html2pdf(element);
		});*/
		var pid=$("#defaultqr").attr("rel-pid");
		$("#defaultqr").text("");
		$("#defaultqr").qrcode({width:50,height:50,text:{{$product->id}} });
		$(".show_qrbc").click(function(){

			$("#myModalMapping").modal("hide");
			$("#qrModal").modal("show");
			/*url=JS_BASE_URL+"/qrbccontent";
			mode=$(this).attr("mode");
			product_id=$(this).attr("rel-pid");
			$("#active_product").val(product_id);
			action="fetch_data";
			type="";
			if (mode=="qr") {
				type="expiry";
			}
			data={
				mode:mode,
				product_id:product_id,
				action:action,
				type:type
			}
			$.ajax({
				url:url,
				type:"POST",
				data:data,
				success:function(r){
					html="";
					$("#oldqrcontent").text("");

					if (r==undefined||r.data==undefined||r.data.length<1) {
						return ;
					}
					console.log(r);
					console.log(r.data[0]);
					for (var i = 0; i < r.data.length; i++) {
						html+=`<tr id=tr_qrbc_`+r.data[i].id+`><td style='width:50px !important;height:50px !important;' >
						<div class='qr' id=qrbc_id_`+r.data[i].id+` rel-content='`+r.data[i].content+`'>
						</td>
						<td style='width:100px !important;height:50px !important;vertical-align:middle !important;'><input type='date'  disabled='disabled' value='`+r.data[i].content+`'></td>
						<td style='width:100px !important;'><input class="form-control" type='checkbox' id="chk" value=`+r.data[i].id+` name='qr[]' class=' qrcheckbox' style='vertical-align:middle;' rel-content='`+r.data[i].content+`'></td>
						<td style='width:50px !important;'>
						</td>
						</tr>`;
					}
					$("#oldqrcontent").append(html);
					$(".qr").text("");
					$(".qr").each(function(i,elem){
						c=$(elem).attr("rel-content");
						$(elem).qrcode({width:50,height:50,text:c});
					})
					$(".qr")
					$( ".datepickerqrbc" ).datepicker({changeMonth:true});

				},
				error:function(){
					toastr.warning("Failed to connect to server");
				}
			})
*/

		});	

		$(document).delegate( '.product_sku', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#sinputproduct_sku" + id).show();
		});		

		$(document).delegate( '.product_sku_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			if (value === null || typeof(value) == 'undefined') {
			} else {
				$.ajax({
					type: "POST",
					data: {data: value},
					url: JS_BASE_URL + "/product/sku/" + id,
					dataType: 'json',
					success: function (data) {
						$("#sinputproduct_sku" + id).hide();
						$("#product_sku" + id).html(value);
						$("#product_sku" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}
			});			
			}
		});		  

/*	var table = $('#productmapping').DataTable({
			'bScrollCollapse': true,
			'scrollX':true,
			'autoWidth':false,
			"order": [],
			"columnDefs": [
				{"targets": 'no-sort', "orderable": false, },
				{"targets": "medium", "width": "80px" },
				{"targets": "large",  "width": "120px" },
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px" }
			],
			"fixedColumns":  false
		});
		$(".dataTables_empty").attr("colspan","100%");*/

		$('.product_map_delete').click(function(){
			url="{{url('product/map/delete')}}";
			pid=$(this).attr('rel-pid');
			var selluser = $("#selluser").val();
			$this=$(this);
			$.ajax({
				url:url,
				type:'POST',
				data:{'pid':pid, 'selluser': selluser},
				success:function(r){
					if (r.status=="success") {
						$this.prop('disabled',true);
						toastr.info(r.long_message);
						$('.pmd_message').html('<span class="text-warning">Product has not been mapped.</span>');
						$this.hide();
					}else{

						toastr.warning(r.long_message);
					}
				},
				error:function(){toastr.warning("Could not connect to server.")}
			});
		});
	});


    function newBarcode1(valx) {
        //Convert to boolean

        $("#barcode1").JsBarcode(
            valx, {
                "background":"white", //Transparent bg-> undefined, no quotes
                "lineColor":"black",
                "fontSize": 10,
                "height":70,
                "width": 1,
                "margin":0,
                "textMargin": 5,
                "font": 5,
                "textAlign":5,
                "valid": function(valid){
                    if(valid){
                        $("#barcode").show();
                    } else{
                        $("#barcode").hide();
                    }
                }
            });
    };
</script>


