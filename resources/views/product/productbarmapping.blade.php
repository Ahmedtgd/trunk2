<style>
	.orange_text {
		color: darkorange;
	}
	.dashed{
		border-right: dotted 1px grey;
	}
</style>

<div class="modal-header" style="background-color:black;">
	<button type="button" class="close" data-dismiss="modal"
	style="position:relative:top:5px"
	aria-label="Close">
	<span aria-hidden="true"
	style="position:relative;top:10px;color:white !important;">&times;</span>
</button>
<h3 class="modal-title" id="myModalLabel"
	style="color: white">Barcode Management</h3>
</div>
<div class="modal-body">
<div class="row">
	<div class="col-sm-9"></div>
	<div class="col-sm-3">
	<button 
		style="width:70px;height:70px;border-radius:5px;color: white;
			background-color: black;margin-top:-10px !important;
			margin-bottom:-13px !important;
			text-align:center;padding-left:3px"
		type="button"
		class="btn pull-right"
		onclick="show_bc_modal()">+Barcode</button>
 	<button
		style="width:70px;height:70px;border-radius:5px;
			margin-top:-10px !important;color:white;
			margin-bottom:-13px !important;
			padding-left:8px;margin-right:5px;padding-right:8px;
			text-align:center;padding-left:6px" data-toggle="modal"
		data-target="#myModal"
		type="button"
		class="btn pull-right bg-groupbarcode"
		onclick="show_track_modal()">Group<br>Barcode</button>
	</div>
</div>
<br>
<div class="row">
<div class="col-sm-12">
<table class="table" id="productbarcodetable" style="width:100%">
	<thead>
		<tr>
			<th class="no-sort"></th>
			<th class="no-sort"></th>
			<th class="no-sort"></th>
			{{-- <th></th> --}}
			<th class="no-sort"></th>
		</tr>
	</thead>
	@def $i=1
	<tbody>
		<tr>
			<td><span style="display:none;">{{$i}}</span></td>
			<td>Default Barcode</td>
			<td>
				<a href="{{url("barcode/generate",$product->id)}}" target="_blank">
				<span class="pmd_message">
				<canvas id="barcode1"
				style="width:265px;height:120px;padding-left:10px;padding-right:10px">
				</canvas>

				<br>
					<span style="font-weight:bold;font-size:0.8em;"
					class="text-center">Default Barcode
					</span>
				</span>
				</a>
			</td>
			{{-- <td></td> --}}
			<td></td>
		</tr>
		@if(!empty($barcodes))
		<?php $i=1;?>
		@foreach($barcodes as $barcode)
		<tr id="trbc_{{$barcode->bc_management_id}}">
			<td><span style="display:none;">{{$i}}</span></td>
			<td >
				<span class=""><b>Barcode {{$i}}:</b> {{$product->name}}</span>
				@if(!is_null($barcode->invoice_no) &&(($barcode->serial_used == 1) || ($barcode->warranty_used == 1)))<p style="padding-top: 70px;">
					<a href="{{ url('/') }}/merchantinvoice/{{$barcode->pid}}" target="_blank">{{str_pad($barcode->invoice_no,10,"0",STR_PAD_LEFT)}}</a>
					<br><span>Serial/IMEI</span>
				</p>
					@elseif(!is_null($barcode->inv) &&(($barcode->s_used == 1) || ($barcode->w_used == 1)))<p style="padding-top: 70px;">
					<a href="{{ url('/') }}/merchantinvoice/{{$barcode->pidd}}" target="_blank">{{str_pad($barcode->inv,10,"0",STR_PAD_LEFT)}}</a>
					<br><span>Warranty</span>
				</p>
				@endif
			</td>
			<td>
				<a href="{{url("barcode/generate",
				[$product->id,$barcode->bcode])}}"
				target="_blank" style="height:50px;width:100px;">
				<span class="pmd_message">
				<svg class="pbarcode"
				  jsbarcode-format="upc"
				  jsbarcode-value="{{$barcode->bcode}}"
				  jsbarcode-textmargin="0"
				  id="pbc_{{$barcode->bc_management_id}}"
				  rel_pbc="{{$barcode->bc_management_id}}"
				  jsbarcode-fontoptions="bold">
				</svg>
				</span>
				</a>

				<br>
				@if($barcode->source=="web")
					<input type="text" name="ipbc" class="ipbc"
					pbc="{{$barcode->bc_management_id}}"
					value="{{$barcode->bcode}}">
					<span style="display:none;"
						id="batchstart_{{$barcode->bc_management_id}}" 
								class="text-center">
					{{$barcode->bcode." (".$barcode->bcode_type.")"}}
					</span>
				@else
					<span style="font-weight:bold;font-size:0.8em;"
								class="text-center">
					{{$barcode->bcode." (".$barcode->bcode_type.")"}}
					</span>
				@endif
				</td>
			{{-- <td>
				
			</td> --}}
			<td>
				@if($barcode->source=="web" && ((is_null($barcode->s_used)|| $barcode->s_used == 0) && (is_null($barcode->w_used) || $barcode->w_used == 0)
				        && (is_null($barcode->warranty_used) || $barcode->warranty_used == 0) && (is_null($barcode->serial_used))|| $barcode->serial_used == 0))
					<a href="javascript:void(0)"
						class='btn btn-danger'
						onclick="delete_barcode('{{$barcode->bc_management_id}}')" 
						style="border-radius:5px;">
						<i class="fa fa-times" aria-hidden="true"></i>
					</a>
				@endif
			</td>
		</tr>
	<?php $i++;?>
	@endforeach
	@else
	<tr>
	<td colspan="2">
	<span class="text-warning">Product has not been mapped.</span>
	</td>
	</tr>
	@endif
	</tbody>
</table>
</div>
</div>
</div>

<div id="batchModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Batch Size</h4>
      </div>
      <div class="modal-body">
        <p class="text-warning">Please enter batch size</p>
        <input type="text" name="batch" id="batch" value="1" class="form-control" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
        <p class="text-warning">Please enter starting value</p>
        <input type="text" name="batchstart" id="batchstart"  class="form-control" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="addbarcode" class="btn btn-primary pull-right" onclick="add_barcodes()" disabled="disabled">Confirm</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	var dt;
	var active_update=false;
	$(document).ready(function(){
		@foreach($barcodes as $b)
			@if($b->bcode!="")
				$(".pbarcode").JsBarcode("{{$b->bcode}}",{
					displayValue:"false",
				});
			@endif
		@endforeach
		dt=$("#productbarcodetable").DataTable({
			"pageLength":2,
			columnDefs: [
				{ orderable: false, targets: '_all' }
			],
			"drawCallback": function(settings, json) {
			    $(".pbarcode").each(function(){
			    	v=$(this).attr("jsbarcode-value");
			    /*	alert(v)*/
			    	$(this).JsBarcode(v,{displayValue:"false"})
			    })
			  }
		});

		$("body").on("blur",".ipbc",function(){
			console.log("Changing")
			id=$(this).attr('pbc')
			value=$(this).val()
			console.log({id,value})
			$("#pbc_"+id).JsBarcode(value,{
				displayValue:false
			})
			$("#batchstart_"+id).text(value)

			update_barcode(id,value)
		})
		$("#batchstart").blur(function(){
			v=$(this).val()
			if (v) {
				/*if (v>0) {
					$("#addbarcode").prop("disabled",false)
				}else{*/
					$("#addbarcode").prop("disabled",false)
				/*}
*/			}else{
				$("#addbarcode").prop("disabled",true)
			}
		})

	})

	function delete_barcode(bcmanagement_id) {
		//alert(bcmanagement_id);
		console.log(bcmanagement_id);

		if (active_update==true) {
			return
		}else{
			active_update=true;
		}
		url="{{url('web/product/barcode/delete')}}",
		type="POST",
		data={bcmanagement_id},
		success=function(r){
			if (r==0) {
				console.log(r);
				toastr.success("Barcode deleted");
				active_update=false;
				dt.row("#trbc_"+bcmanagement_id).remove().draw(true);
			}
		}
		error=function(){
			active_update=false;
		}
		console.log(data);
		console.log({data});
		$.ajax({url,type,data,success,error})
	}

	function show_track_modal(){
		console.log("clicked")
		//$("#myModalMapping").modal("hide");
	//	$("#trackModal").modal("show");
	}
	function close_modal(){
		$("#myModal").modal("hide");
		//$("#myModalMapping").modal("show");
	}

	function update_barcode(bcmanagement_id,barcode) {
		// body...
		if (active_update==false) {
			active_update=true
		}else{
			console.log("active_update in progress")
			return
		}
		url="{{url('web/product/barcode/update')}}"
		type="POST"
		data={bcmanagement_id,barcode}
		console.log({data})
		if (!bcmanagement_id) {
			console.log("Invalid bcmanagement_id")
			return
		}
		success=function(){
			console.log("Updated")
			active_update=false
			tr=$("#trbc_"+bcmanagement_id)
			dt
		    .rows( tr )
		    .invalidate()
		    .draw();
		}
		$.ajax({url,type,data,success})
	}

	function show_bc_modal() {
		// body...
		$("#batchModal").modal("show")
	}
	function add_barcodes() {
		$("#batchModal").modal("hide")
		// body...
		url="{{url('web/product/barcode/create')}}"
		product_id="{{$product->id}}"
		batch=$("#batch").val()
		batchstart=parseInt($("#batchstart").val());
		data={product_id,batch,batchstart}
		type="POST";
		if (batch<1) {
			toastr.warning("Please enter a valid batch size")
			return
		}
		success=function(ids){
			if (ids.length>0) {
				/*Add*/
				x=2
				for (var i = ids.length - 1; i >= 0; i--) {
					id=ids[i]

					x+=2
					row=[
					`<span style="display:none;">${x}</span>`,
					``,
					`
						<span class="pmd_message">
						<svg class="pbarcode"
						jsbarcode-format="upc"
						jsbarcode-value="${batchstart}"
						id="pbc_${id}"
						rel_pbc="${id}"
						jsbarcode-textmargin="0"
						jsbarcode-fontoptions="bold">
						</svg>

						<br>
						<span style="font-weight:bold;font-size:0.8em;"
								class="text-center">

						</span>
						</span>
						<br>
						<input type="text" pbc="${id}" value="${batchstart}" class="ipbc"/>
						<span style="display:none;" id="batchstart_${id}"
								class="text-center">${batchstart}</span>
					`,
					
					`<a href="javascript:void(0)"
						class='btn btn-danger'
						onclick="delete_barcode('${id}')" 
						style="border-radius:20px;">
						<i class="fa fa-times" aria-hidden="true"></i>
					</a>`

					];
					dt.row.add(row)
					
					batchstart+=1;
				}
				dt.page.len(2).draw(true)
				for (var i = ids.length - 1; i >= 0; i--) {
					id=ids[i]
					v=$("#pbc_"+id).attr("jsbarcode-value");
					$("#pbc_"+id).JsBarcode(v,{
						displayValue:false
					})
				}
			}
		}

		$.ajax({url,type,data,
			success: function(r) {
				var message = "";
				console.log('***** Success Handler *****');
				console.log(JSON.stringify(r));

				pname = r.pname;
				fresh = r.fresh;
				stale = r.stale;

				for (var key in stale) {
					console.log('***** key='+key+' *****');
					console.log(stale[key]);
					message+=`Barcode `+stale[key].barcode+` is already mapped with `+stale[key].name+`<br>`;
				}
				toastr.warning(message, {timeOut:8000}).
					css("width","600px");
 
			},
			error: function(r) {
				console.log('***** Error Handler *****');
				console.log(JSON.stringify(r));
			},
		})

	}

	function parse_input(){
		console.log("***** parse_input() *****");

		var barcodes = $('#barcodevals').val();
		barcodes = $.trim(barcodes);
		var p_id = {{$product->id}};

		if(barcodes.length > 0){
			console.log('***** barcodes *****');
			console.log(JSON.stringify(barcodes));
			
			$.ajax({
				type: "POST",
				url: "{{URL('merchant/groupbarcodes')}}",
				data: {"barcodes" : barcodes, "product_id" : p_id},
				success: function(r) {
					console.log('***** Success Handler *****');
					console.log(JSON.stringify(r));

					if (r.status=="success" && r.data.length==0){
						toastr.success("Barcodes successfully entered");
					} else {
						data=r.data;
						message='';
						for (var i = data.length - 1; i >= 0; i--) {
							x=data[i]
							message+=`Barcode ${x.barcode} is already mapped with ${x.name}<br>`;
						}
						toastr.warning(message, {timeOut:6000}).
							css("width","600px");
					}
					close_modal();
				},
				error: function(r) {
					console.log('***** error Handler *****');
					console.log(JSON.stringify(r));
					close_modal();
				}
			});

		} else {
           toastr.warning("Please enter or scan barcode")
		}
	}
</script>

<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg" style="width:420px">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header bg-groupbarcode"
			style="color:white">
			<button type="button" class="close"
				style="color:white;position:relative;top:8px;
				padding-top:2px;
				border-top-left-radius:10px; border-top-right-radius:10px"
				data-dismiss="modal">&times;</button>
			<h3 class="modal-title" style="color:white">Group Barcode</h3>
		</div>
		<div class="modal-body">
		<div class="row">
		<div class="col-md-4" >
			<b>Note:</b><br>
			Enter or scan barcodes.<br>
			Separate with semicolon (;) or Enter
		</div>
		<div class="col-md-8">
			<textarea class="col-lg-12 form-control"
				style="height: 240px;width:250px;resize:vertical;
					margin-bottom: 15px;" id="barcodevals"
				placeholder="Please enter/scan barcode"></textarea>
			<div style="border-radius:5px;
				width:70px;height:70px;float:right" onclick="parse_input()"
				class="btn-group btn-group-justified bg-confirm">
				<a href="#" style="color:white" class="btn">Submit</a>
			</div>
		</div>
		</div>
		</div>
		<div class="modal-footer">
		<!--
			<button type="button" class="btn btn-default"
			onclick="close_modal()">Close</button>
		-->
		</div>
	</div>
</div>
</div>
