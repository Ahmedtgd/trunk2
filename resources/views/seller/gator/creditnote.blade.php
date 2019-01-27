<style type="text/css">
#voidstamp{
    color: red;
    position: absolute;
    z-index: 1000 !important;
    font-size: 71px;
    font-weight: 500;
    margin-top: -9%;
    margin-left: 5%;
    transform: rotate(30deg);
    /*display:none;*/
}
</style>
<div style="padding: 15px;padding-top:0" id="download">
<br>
<div >
	<?php
		Log::debug('***** buyeraddress *****');
		Log::debug($buyeraddress);
	?>

	<div class="row" style="padding-left:0;padding-right:0;margin-bottom:10px">
	<div class="col-md-12"
		style="display:flex;align-items:flex-end;padding-left:0;padding-right:0;margin-bottom:10px">
		<div class="col-md-4" style="position:relative;top:70px;padding-right:0">
			<!--
			<p style="margin: 0px">
				<?php
				if($buyeraddress) {
					$uname =$buyeraddress->first_name.' '.
						$buyeraddress->last_name ;
					echo $uname;
				}
				?></p>
			-->
			<p style="margin: 0px">
				<?php if($buyeraddress) echo $buyeraddress->company_name ?></p>
			<p style="margin: 0px">
				<?php if($buyeraddress) echo "(".$buyeraddress->business_reg_no .")"?></p>
			<p style="margin: 0px">
				<?php if($buyeraddress) echo $buyeraddress->line1 ?> </p>
			<p style="margin: 0px">
				<?php if($buyeraddress) echo $buyeraddress->line2 ?></p>
			<p style="margin: 0px">
				<?php if($buyeraddress) echo $buyeraddress->line3 ?></p>
			<p style="margin: 0px">
				<?php if($buyeraddress) if(isset($buyeraddress->line4)){
					echo $buyeraddress->line4;
			  } ?>
			</p>
			<p style="margin: 0px">
				<strong>Date: &nbsp;</strong>
				<?php if($merchant) {
					echo date('dMy H:i', strtotime($merchant->created_at));
				} ?>
			</p>
		</div>

		<div class="col-md-4 text-center"
			style="padding-left:0;padding-right:0">
			<p style="margin: 0;font-size:16px"><strong>
			<?php
				if($merchant) {echo $merchant->company_name; }
			?></strong></p>
			<p style="margin: 0px">
				<?php if($merchant) {echo "(".$merchant->business_reg_no.")"; } ?></p>
			<p style="margin: 0px">
				<?php if($merchant) {echo $merchant->line1; } ?></p>
			<p style="margin: 0px">
				<?php if($merchant) {echo $merchant->line2; } ?></p>
			<p style="margin: 0px">
				<?php if($merchant) {echo $merchant->line3; } ?></p>
			<p style="margin: 0px">
				<?php if($merchant) {echo $merchant->line4; } ?></p>

		</div>

		<div class="col-md-4 text-right" style="padding-left:0;padding-right:0">
			<div class="">
				<div class="col-md-12" style="margin-top:10px">

					<button style="padding-top:4px;background-color:skyblue;
					font-size:13px;width:70px;height:70px;margin-bottom:5px;
					color: white; border:0;border-radius:10px;margin-right:5px;
					border:0;padding-left:5px"
					id="downloadbtn" type="button" onclick="genPDF()">

					Download</button>

					<div style="width: 70px; height: 70px; float: right;margin-bottom:5px"
						class="qrcode"></div>

				</div>
			</div>
			<div class="" style="margin-top: 5px;">
				<div class="col-md-12" style="">
					
					<!--button style="padding-top:8px;background-color: red;
					font-size:13px;width:70px;height:70px;
					color: white;border-radius:10px;margin-right:0"
					id="cancelbtn"
					type="button" class="btn controlbtn"
					onclick="showModal()"
					wfd-id="1618">
					Cancel</button-->
				</div>
			</div>
			<div class="" style="margin-top: 5px;">
				<div class="col-md-12" style="">
					<div class="col-md-12 row" style="float:right">
						<span>
						@if($do->status != 'cancelled')
						<button style="padding-top:8px;
						font-size:13px;width:70px;height:70px;display: none ;
						color: white;border-radius:10px;margin-right:0;"
								id="dobtn"
								type="button" class="btn controlbtn btn-success"
								onclick="issueModal('{{$do->ndid}}','{{$do->do_id}}','{{$do->porder_id}}')"
								wfd-id="1618">
							DO/<br>Invoice</button>
						@endif
						</span>
						<span>

							@if($do->status != 'cancelled')
							@if($do->status != 'inprogress')
									@if($do->status = 'pending')
										<button style="padding-top:8px;
							font-size:13px;width:70px;height:70px;display: none;
							color: white;border-radius:10px;margin-right:0"
												id="discardbtn"
												type="button" disabled class="btn controlbtn btn-danger"
												onclick="discardDoModal('{{$do->ndid}}','{{$do->do_id}}','{{$do->porder_id}}')"
												wfd-id="1618">
								Discard</button>@else
							<button style="padding-top:8px;
							font-size:13px;width:70px;height:70px;display: none;
							color: white;border-radius:10px;margin-right:0"
									id="discardbtn"
									type="button" class="btn controlbtn btn-danger"
									onclick="discardDoModal('{{$do->ndid}}','{{$do->do_id}}','{{$do->porder_id}}')"
									wfd-id="1618">
								Discard</button>
							@endif
							@endif
								@endif
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
 

	<div class="row">
	<div class="col-md-12" style="display:flex;align-items:flex-end">
		<div class="col-md-4" style="padding-left:0;padding-right:0">
		@if(isset($nid))
			<h5><strong>DO ID: </strong>{{$nid}}</h5>
		@else
			<h5><strong>Order ID: </strong>{{$nporder_id}}</h5>
		@endif

		</div>


		<div class="col-md-4 text-center"
			style="padding-left:0;padding-right:0;margin-bottom:1px">

			<p class="text-center ">
				<h2 id="voidstamp" style="@if($do->status == 'cancelled') display:block; @else display:none; @endif">Cancelled<br>
			        <span style="font-size:22px !important;" id="voiddate">
			        	
			        	<?php 
			        	if($merchant) {
							echo date('dMy H:i', strtotime($merchant->updated_at));
						} 
						?>
			    	</span>
		        </h2>
	    	</p>

		@if(isset($heading))
			<p style="font-size:25px;margin-bottom:0">
				<strong>{{$heading}}</strong></p>
		@else
			<p style="font-size:25px;margin-bottom:0">
				<strong>Credit Note</strong></p>
		@endif 
		</div>

		<div class="col-md-4"
			style="padding-left:0;margin-bottom:6px;padding-right:30px">
			<table class="pull-right">
			<tr>
				<td><strong>Staff Name&nbsp;&nbsp;</strong></td>
				<td>:
				<?php if($merchant) {
					echo $merchant->first_name . " ". $merchant->last_name;
				}?>
				</td>
			</tr>
			<tr>
				<td style=""><strong>Staff ID</strong></td>
				<td>:
				<?php if($merchant) {
					printf('%06d',$merchant->staff_id);
					Log::debug('***** saleorder.blade.php *****');
					Log::debug($merchant);
				}?>
				</td>
			</tr>
			<tr>
				<td style=""><strong>Date</strong></td>
				<td>:
				<?php if($merchant) {
					echo date('dMy H:i', strtotime($merchant->created_at));
				} ?>
				</td>
			</tr>
			<tr>
				<td style=""><Strong>Credit Note No&nbsp;&nbsp;</strong></td>
				<td>:
				<?php if($merchant) {
					echo sprintf('%010d', $invoice[0]->creditnote_no);
				} ?>
				</td>
			</tr>

			</table>
		</div>
    </div>
    </div>
	</div>

	<div style="align-self:flex-end">
        <table class="table" style="margin-bottom: 0px;">
            <thead>
            <tr style="border-bottom:1pxsolid#ddd;background:black;color:white;">
                <th class="text-center">No</th>
                <th class="text-center">Product&nbsp;ID</th>
                <th class="text-left">Description</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Price&nbsp;({{$currentCurrency}})</th>
            </tr>
            </thead>
            <tbody>
            <?php   $index = 1;$totalc=0; ?>
            @foreach($invoice as $invoice)
                <?php $price = $invoice->order_price;
                $p_price = $price/100;
                $totalc  += $p_price;
                ?>
                <tr>
                    <td style="width: 5%;" class="text-center">{{$index++}}</td>
                    <td style="width: 15%;" class="text-center">{{$invoice->nproduct_id}}</td>
                    <td style="width: 50%;" class="text-left">
						@if(File::exists(URL::to("images/product/$invoice->prid/thumb/$invoice->thumb_photo")))
							<img width="30" height="30" src="{{URL::to("images/product/$invoice->prid/thumb/$invoice->thumb_photo")}}">
						@elseif(File::exists(URL::to("images/product/$invoice->parent_id/thumb/$invoice->thumb_photo")))
							<img width="30" height="30" src="{{URL::to("images/product/$invoice->parent_id/thumb/$invoice->thumb_photo")}}">
						@endif
						{{($invoice->name)}}

                    </td>
                    <td style="width: 5%;" class="text-center">1</td>
                    <td style="width: 10%;" style="width: 13%;" class="text-right">{{number_format($invoice->order_price/100,2)}}</td>

                </tr>
            @endforeach

            <?php
            $total  = number_format($totalc,2);
            $gst   = $totalc*6/100;
            $itmtotalprice = $totalc-$gst;
            $gst   = number_format($gst,2);
            $itmtotalprice   = number_format($itmtotalprice,2);
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3"
					style="text-align:right;font-weight:bold;font-size:17px">
                    Total&nbsp;{{$currency}}&nbsp;{{$total}}</td>
            </tr>
            </tbody>
        </table>
</div>
<hr style="margin: 0px;">
	<p class="pull-left">Invoice No:<a href="{{url('merchantinvoice/'.$invoice->id)}}" target="_blank">{{sprintf('%010d', $inv_no)}}</a></p>
<p class="pull-right"
	style="padding-right:10px;padding-top:2px;font-size:10.5px">
	Goldfish LionChu V1.0</p>
	<!-- <div class="col-md-12" id="footerDetail" style="padding-top:5px;"> -->
		<!-- <table>
		<tr>
			<td style="text-align: left">
				<strong >Delivery Order ID  </strong>
			</td>
			<td>
				: {{$do->do_id}}
			</td>
		</tr>
		</table> -->
	<!-- </div> -->
{{--<div style="text-align: right; padding-right: 8px;">--}}
  {{--Total include 6% GST &nbsp&nbsp {{$currentCurrency}}&nbsp{{$gst}}<br><span>Item Total &nbsp&nbsp {{$currentCurrency}}&nbsp{{$itmtotalprice}}</span>--}}
{{--</div>--}}

</div>
<p id = "salerOrderId" style="display: none;">{{$id}}</p>
<script type="text/javascript" src="<?php echo e(asset('js/qr.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/html2pdf.js')); ?>"></script>
<script type="text/javascript">
  function genPDF() {
	  $( "#download" ).css({"margin-top": "20px"});
	  $( "#cancelbtn" ).css({"display":"none"});
	  $( "#downloadbtn" ).css({"display":"none"});
	  var elements = document.getElementById('download');
	  html2pdf(elements);
	  $( "#cancelbtn" ).css({"display":"inline"});
	  $( "#downloadbtn" ).css({"display":"inline"});
	  $( "#download" ).css({"margin-top": "0px"});
  }

  function hide(element) {  element.css("display","none"); }
  $(document).ready(function(){
        $('.qrcode').qrcode({height:70,width:70,text: <?php if($merchant) {echo sprintf('%060d', $merchant->salesorder_no);  }else{ echo "00000000000000000";} ?> });

	  if($('#logistic_check').html() == 1){
		  $( "#cancelbtn" ).css({"display":"none"});
		  $( "#dobtn" ).css({"display":"inline"});
		  $( "#discardbtn" ).css({"display":"inline"});
	  }

  });
  function showModal(){
      $('#confirmationModal').modal('show');
  }
  function issueModal(do_id_no,do_id,p_id) {
	  console.log("Issue Modal Hit");
	  console.log(p_id);
	  $.ajax({
		  type: "GET",
		  url: JS_BASE_URL+"/seller/gator/price_list/"+p_id,
		  success: function( data ) {
			  console.log("Opening Modal");
			  $("#price_list").html(data);
			  $('#issue_do_id_no').html(do_id_no);
			  $('input[name=issue_do_id]').val(do_id);
			  $('#issueDoPopUp').modal('show');
		  }
	  });

  }
  function discardDoModal(do_id_no,do_id,po_id) {
	  $('#porder_do_id').html(po_id);
	  $('#discard_do_id_no').html(do_id_no);
	  $('input[name=discard_do_id]').val(do_id);
	  $('#discardDoPopUp').modal('show');
  }
  function close_modal(){
	  $('#confirmationModal').modal('hide');
  }
  function deleteRecord(id) {
	 var url = window.location.href;
	  console.log(url);

		  $.ajax({
			  type: "POST",
			  url: JS_BASE_URL+"/gator/deleteRow",
			  data:{"id":id},
			  success: function(data){
				  $('#confirmationModal').modal('hide');
				  $('#voidstamp').css('display','block');
				  //$('#soModal').modal('hide');
				  $('#downloadbtn').hide();
				  $('#cancelbtn').hide();
				  toastr.success('Order has been Successfully Cancelled');
			  }
		  });


  }
</script>

<!-- Modal -->
<div id="confirmationModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">


			</div>
			<div class="modal-body">
                <h4 class="modal-title">
				<b>Do you want to cancel this Sales Order?</b></h4>
			</div>
			<div class="modal-footer">
                <div class="row">
                    <div class="col-md-6 pull-left">
					<button style="padding-top:2px;font-size:13px;width:70px;
					height:40px;margin-bottom:5px;border-radius:10px;
					border:1px solid; margin-right:5px; float:left;
					padding-left:5px"
					type="button"
					onclick="deleteRecord({{$id}})"
					class="bg-confirm btn-primary">Yes</button>
                    </div>

                    <div class="col-md-6 pull-right">
					<button  style="padding-top:8px;background-color:red;
					font-size:13px;width:70px;height:40px;margin-bottom:5px;
					color: white; border-radius:10px;margin-right:0;
					float:right; padding-left:6px"
					type="button" class="btn btn-danger"
					onclick="close_modal()">No</button>
                    </div>
                </div>
			</div>
		</div>

	</div>
</div>
