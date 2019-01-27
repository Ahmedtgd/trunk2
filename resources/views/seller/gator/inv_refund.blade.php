<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
?>

<script type="text/javascript" src="{{asset('jquery-json/src/jquery.json.js')}}"></script>
<style>
.pr-10{
    padding-right:10px;
}
.pr-7{
    padding-right:3px;
}

.ver-mid{ vertical-align: middle; }

ul.ui-autocomplete{
    z-index: 99 !important;
}
ul.ui-autocomplete li{
color: black;
}
ul.ui-menu{
    display: grid;
}
.table2>tbody>tr>td{
	border-top: none;
    padding-bottom: 2px;
}
    .modal-backdrop{
        visibility: hidden; !important;
    }
    .modal.in{
        background-color: rgba(0,0,0,0.5);
    }
</style>
<p id="status_of_return" style="display:none;">{{$status}}</p>
<div class="" style="padding: 0px;">
    <div class="row">      
        <div class="col-md-12" style="margin-bottom:10px">
            <div class="">
            <div  class="col-md-4">
			<table id="opdt" cellspacing="0" class="table2"
			width="100%!important" style="margin-top: 2px;color:#fff;">
			<tr >
				<td class="bt text-left"><span class="pr-10" style="color:black">
				<b>R</b></span> Return Only</td>
			</tr>
			<tr>
				<td class="bt text-left"><span class="pr-7"
				style="color:black;padding-right: 7px;">
				<b>Rx</b></span>Return Only (Damaged)</td>
			</tr>
			 <tr>
				<td class="bt text-left"><span class="pr-10" style="color:black">
				<b>D</b></span> Exchange of Stocks</td>
			</tr>
			<tr>
				<td class="bt text-left"><span class="pr-7" style="color:black">
				<b>Dx</b></span> Exchange of Stocks (Damaged)</td>
			</tr>
			</table>
            </div>

			<div style="color:white;" class="col-md-4">
			<table>
				<tr>
					<td style="color:white;" class="text-left">Receipt No:&nbsp;</td>
					<td style="color:white;"><?php echo sprintf('%010d',$invoice->id); ?> </td>
				</tr>
				<tr style="color:white;">
					<td  class="text-left">Staff Name:&nbsp;</td>
					<td >{{$staff_name}}</td>
				</tr>
				<tr style="color:white;">
					<td class="text-left">Staff ID:</td>
					<td>{{$staff_id}}</td>
				</tr>
				<tr style="color:white;">
					<td class="text-left">Date:</td>
					<td>{{UtilityController::s_date($invoice->created_at)}}</td>
				</tr>
			</table>
			</div>
			<div class="col-md-2"  style="padding-right:0">
			</div>
        @if($return_completed == 0)
			<div class="col-md-2"   style="padding-right:0; ">
			@if($status == 1)
                    <?php $locked = ''; if(($invoice->payment == 'offset') || ($invoice->payment == 'full')){
                        $locked = 'disabled';
                    } ?>
                    <div style="float:right;padding-right:0; border-width:0px;">
                        <button class="btn btn-danger" {{$locked}} id="reject_btn"
                                style="border-radius: 7px; border-width:0px;
					width: 70px; height: 70px; color: #fff;
					padding: 0px !important;"
                                class="bg-refund invoice-control-btn center crossbtn btn"
                                onclick="onReject({{$porder_data->id}})">Reject</button>
                    </div>
			<div  style="float:right;padding-right:5px; border-width:0px;">
				<button class="bg-confirm" {{$locked}} id="approve_btn"
				style="background-color: #09c6e7; border-width:0px;
				border-color: #09c6e7;border-radius: 7px;
				width: 70px; height: 70px; color: #fff;
				padding-right: 5px; !important;"
				class="bg-refund invoice-control-btn center crossbtn btn"
				onclick="onApprove({{$porder_data->id}})">Approve</button>
			</div>
			@else
			<div  style="float:right;padding-right:0">
				<button  disabled id="confirm_btn"
					style="border-color: #09c6e7;border-radius: 7px;
					width: 70px; height: 70px; color: #fff;
					border-width:0;
					padding: 0px !important;"
					class="bg-confirm invoice-control-btn center crossbtn btn"
					onclick="onConfirm()">Confirm</button>
			</div>
                    <div   style="float:right;padding-right:5px;">

                        <button class="btn btn-danger" disabled id="product_btn"
                                style="border-color: #09c6e7;border-radius: 7px;
					width: 70px; height: 70px; color: #fff; background-color: #ff0000;
					border-width:0;
					padding: 0px !important;"
                                class="bg-refund invoice-control-btn center crossbtn btn"
                                onclick="prod_modal({{$porder_data->id}})">D/Dx</button>

                    </div>
			@endif
            </div>
            @endif
        </div>
    </div>
        @if(($exchanged != 0) && ($exchanged != ''))
            <button class="btn btn-danger" id="product_btn"
                    style="border-color: #09c6e7;border-radius: 7px;
					width: 70px; height: 70px; color: #fff; background-color: #ff0000;
					border-width:0; float: right; margin-right: 15px;
					padding: 0px !important;"
                    class="bg-refund invoice-control-btn center crossbtn btn"
                    onclick="mini_seller_gator({{$exchanged}})">D/Dx</button>
        @endif
        <div class="col-sm-12">
			<table id="raw-pdatatable" cellspacing="0"
			class="table table-striped" style="margin-top: 10px;width:100%">
                <thead>                
				<tr style="color: #fff; background:#000;">
					<th style="vertical-align:middle"
						class="text-center">No</th>
					<th style="vertical-align:middle"
						class="text-center">Product&nbsp;ID</th>
					<th style="vertical-align:middle;width:40%!important"
						class="text-center" >Description</th>
					<th style="vertical-align:middle"
						class="text-center">Amount</th>
					<th style="vertical-align:middle;color:#fff;
						background:#0a9669;" class="text-center">
						Status</th>
					<th style="vertical-align:middle"
						class="text-center">R</th>
					<th style="vertical-align:middle"
						class="text-center">Rx</th>
					<th style="background-color:#ff0000;color:#fff;
						vertical-align:middle" class="text-center">D</th> 
					<th style="vertical-align:middle;background-color:
						#ff0000;color:#fff"
						class="text-center">Dx</th>
					 <!--th class="text-center"
						style="background-color:#ff0000;color:#fff">
						Product Search</th-->
				</tr>
                </thead>
                <tbody>
				<?php
				$count = 1; $sum_qty = 0;
				$sum_amount = 0;
				?>

				@if(isset($products))
					@foreach($products as $product)
					<?php
                    $disabled = '';
					if(($status == 1) ||($product->status == 'approved') || ($product->status == 'rejected') ){
						$disabled = 'disabled';
					}
					?>

					<tr style="background:#fff;color:black; vertical-align:middle;" class="ver-mid" >
						<input type="hidden" id="rpid_" value="">
						<td style="vertical-align:middle"
							class="text-center">{{$count}}</td>
						<td style="vertical-align:middle;display: none">
							{{$product->opqid}}</td>
						<td style="Vertical-align:middle"
							class="text-center">{{ $product->nproduct_id}}
						</td>
						<td style="Vertical-align:middle"
							class="text-left">
							@if(file_exists(public_path()."/images/product/$product->pid/thumb/$product->thumb_photo"))
								<img width="30" height="30" src="{{URL::to("images/product/$product->pid/thumb/$product->thumb_photo")}}">
							@elseif(file_exists(public_path()."/images/product/$product->parent_id/thumb/$product->thumb_photo"))
								<img width="30" height="30" src="{{URL::to("images/product/$product->parent_id/thumb/$product->thumb_photo")}}">
							@endif

						   <span> {{ $product->pname }}</span>
							@if($product->imeiNo ||$product->warrantyNo )
								<p style="padding-left: 40px; padding-right: 40px;">
								Serial/Imei No:
								<span id="serial_no{{$count}}">
								{{$product->imeiNo}}
								</span>
								<span style="float: right;">
								Warranty: {{$product->warrantyNo}}
								</span>
								</p>
							@endif
						</td>
						<?php
						if(is_null($product->approved_qty) || $product->approved_qty == 0){
							$opc=$product->order_price;
							$tempTotal=($opc*$product->quantity);
							$revenue = number_format($tempTotal/100,2);
							$totalPaid=($product->quantity * $opc);
							$amount = number_format($totalPaid/100,2);
							$sum_qty += $product->quantity;
							$sum_amount += $tempTotal;
						}else{
							$opc=$product->order_price;
							$tempTotal=($opc*$product->approved_qty);
							$revenue = number_format($tempTotal/100,2);
							$totalPaid=($product->approved_qty * $opc);
							$amount = number_format($totalPaid/100,2);
							$sum_qty += $product->approved_qty;
							$sum_amount += $tempTotal;
						}
						?>
						<td style="vertical-align: middle;" class="text-right
							ver-mid">
							{{number_format($opc/100,2)}}
						</td>
						<td style="vertical-align: middle;" class="text-center
							ver-mid">
							<?php if(($product->status == '')){
								$product->status =  'Active';

							} ?>
							{{ucfirst($product->status)}}
						</td>
						<td style="vertical-align: middle;" class="text-center
							ver-mid">
							<label class="radio-inline" >
							<input {{$disabled}} id="R{{$count}}"
							<?php echo ($product->return_option =='r')? 'checked':''  ?>
							style="margin-top: -8px;"
							onchange="activate({{$count}})"
							type="radio" name="optradio{{$count}}" >
							</label>
						</td>
						<td style="vertical-align: middle;" class="text-center  
							ver-mid">
							<label class="radio-inline" >
							<input {{$disabled}} id="Rx{{$count}}"
							<?php echo ($product->return_option =='rx')? 'checked':''  ?>
							style="margin-top: -8px;"
							onchange="activate({{$count}})"
							type="radio" name="optradio{{$count}}" >
							</label>
						</td>
						<td style="vertical-align: middle;" class="text-center
							ver-mid">
							<label class="radio-inline D_Dx" >
							<input {{$disabled}}   id="D{{$count}}"
							<?php echo ($product->return_option =='d')? 'checked':''  ?>
							style="margin-top: -8px;"
							onchange="activate({{$count}})"
							type="radio" name="optradio{{$count}}">
							</label>
						</td>
						<td style="vertical-align: middle;" class="text-center
							ver-mid">
							<label class="radio-inline D_Dx" >
							<input {{$disabled}}  id="Dx{{$count}}"
							<?php echo ($product->return_option =='dx')? 'checked':''  ?>
							style="margin-top: -8px;"
							onchange="activate({{$count}})" type="radio"
							name="optradio{{$count}}" >
							</label>
						</td>
						<td style="display: none">{{$product->opid}}</td>
					</tr>
					<?php $count++; ?>
					@endforeach
				@endif
                     
                </tbody>
            </table>
            <p id="dordx" style="display: none;" >0</p>
        </div>
        <div class="col-sm-12" style="padding-top:10px;color:black">
			<textarea placeholder="Enter notes here" id="remark" <?php echo ($status == 1)? 'disabled':''  ?>
			style="padding-top:10px;padding-bottom:10px;white-space:nowrap"
			class="col-md-12" rows="4">
			<?php if(!empty($note)){
				echo $note;
			}?>  </textarea>
        </div>
        <div class="col-sm-12">
            <label>*Condition apply</label>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){

    });

    function onReject(id){
        console.log("Try here");
        var notes = $('#remark');
        var date = new Date();
        var month = new Array();
        month[0] = "Jan";
        month[1] = "Feb";
        month[2] = "Mar";
        month[3] = "Apr";
        month[4] = "May";
        month[5] = "Jun";
        month[6] = "Jul";
        month[7] = "Aug";
        month[8] = "Sep";
        month[9] = "Oct";
        month[10] = "Nov";
        month[11] = "Dec";
        var dtMax = new Date(date);
        dtMax.setDate(dtMax.getDate());
        var dd = dtMax.getDate();
        var M = dtMax.getMonth();
        var m = month[M];
        var y = dtMax.getFullYear();
        var dtFormatted = dd + '-'+ m + '-'+ y;
		notes.text("Request Rejected on "+dtFormatted);
        $('#refundDirectals').modal('hide');

		var note = notes.text();
        var TableData = new Array();
        $('#raw-pdatatable tr').each(function(row, tr){

            // console.log("Checked " + $(tr).find('td input:radio').prop('checked'));
            TableData[row]={
                "taskNo" : $(tr).find('td:eq(0)').text().trim()
                , "prodID" :$(tr).find('td:eq(2)').text().trim()
                , "opid" : $(tr).find('td:eq(1)').text().trim()
                , "status" : $(tr).find('td:eq(5)').text().trim()

            };
        });

        TableData.shift();
		console.log("Hit here");
        var data = $.toJSON(TableData);
        console.log(TableData);
        $.ajax({
            type: "POST",
            url: JS_BASE_URL+"/seller/gator/reject_return",
            data: {"pTableData" : data, "notes" : note},
            success: function(msg){
                if(msg == 1){
                    toastr.success('Return has been rejected');
                    $('#new_status' + id).html('Unpaid');
                }else{
                    toastr.success('An error occurred');
                }

            }
        });
    }

    function activate(count){
        console.log("clicked");
        var box = $('#product_btn');
        $('#confirm_btn').prop('disabled', false);

        var count = 0;
        $('.D_Dx').each(function() {
            var checked = $(this).find('input:radio:checked');
          //  console.log(checked);
            if (checked.length > 0) {
                count = 1;
         }

            if (count == 1){
                box.prop('disabled', false);
            }else{
                box.prop('disabled', true);
            }
        });

    }

    function deactivate(count){
        console.log("deactivate row "+count);
        var box = $('#box'+count);
        box.prop('disabled', true);
    }

    function onApprove(id){

        var TableData = new Array();
        var option = "";
        var count = 0;

        $('#raw-pdatatable tr').each(function(row, tr){
            option = "";
            if ($('#Rx'+count).prop('checked') == true){
                option = "rx";
            }else  if ($('#R'+count).prop('checked') == true){
                option = "r";
            }else  if ($('#D'+count).prop('checked') == true){
                option = "d";
            }else  if ($('#Dx'+count).prop('checked') == true){
                option = "dx";
            }else{

            }
            // console.log("Checked " + $(tr).find('td input:radio').prop('checked'));
            TableData[row]={
                "taskNo" : $(tr).find('td:eq(0)').text().trim()
                , "prodID" :$(tr).find('td:eq(2)').text().trim()
                , "status" : $(tr).find('td:eq(5)').text().trim()
                , "opid" : $(tr).find('td:eq(1)').text().trim()
                ,"option" : option

            };
            option = "";
            count++;
            console.log("Option at "+count + " is "+option);
        });

        TableData.shift();

        var data = $.toJSON(TableData);
        //TableData = (JSON.stringify(TableData));

        var notes = $('#remark').val();
        console.log(data);
        $('#refundDirectals').modal('hide');
        $.ajax({
            type: "POST",
            url: JS_BASE_URL+"/seller/gator/sub_dar_return",
            data: {"pTableData" : data, "id" : id, "notes" : notes},
            success: function(msg) {
                $('#newtotal' + id).text(msg.balance);
                console.log("Message "+msg.status);
                if(msg.status == 'Offset') {
                    $('#clear' + id).html(msg.status);
                }else if(msg.status == 'Partial'){
                    $('#clear' + id).html(msg.status);
                }else{
                    $('#new_status' + id).text(msg.status);
                }
                var cid = msg.credit_note;
                toastr.success('Return has been made');
                $.ajax({
                    type: "GET",
                    url: JS_BASE_URL + "/seller/gator/credit_note/"+id+"/"+cid,
                    success: function (msg) {
                        $('#Creditnotes').modal('show');
                        $('#creditnote').html(msg);
                    }
                });
            }
        });
    }

    function onConfirm(){

        var TableData = new Array();

		var count = 0;
        var option = "";

        $('#raw-pdatatable tr').each(function(row, tr){
            console.log("option=" +option);
            option = "";
            if ($('#Rx'+count).prop('checked') == true){
                option = "rx";
            }else  if ($('#R'+count).prop('checked') == true){
                option = "r";
            }else  if ($('#D'+count).prop('checked') == true){
                option = "d";
            }else  if ($('#Dx'+count).prop('checked') == true){
                option = "dx";
            }else{

            }
           // console.log("Checked " + $(tr).find('td input:radio').prop('checked'));
            TableData[row]={
                "taskNo" : $(tr).find('td:eq(0)').text().trim()
                , "prodID" :$(tr).find('td:eq(2)').text().trim()
                , "description" : $(tr).find('td:eq(3)').text().trim()
                , "status" : $(tr).find('td:eq(5)').text().trim()
                , "opid" : $(tr).find('td:eq(1)').text().trim()
                ,"option" : option
                ,"serial_no" : ($('#serial_no'+(count))).text().trim()
            };
            if((option == "dx") || (option == "d")){
                if($('#dordx').html() != 1){
                    $('#dordx').html('2');
                }

            }
            count++;
        });
        TableData.shift();
        var notes = $('#remark').val().trim();
        console.log("notes=" +notes);

        var data = $.toJSON(TableData);

        $('#refundDirectal').modal('hide');
        if( $('#dordx').html() == 2){
            toastr.success('Unable to perform, you must choose at least one product from D/Dx');
        }else{
            console.log(data);
            $.ajax({
                type: "POST",
                url: JS_BASE_URL+"/seller/gator/return_prod",
                data: {"pTableData" : data, "notes" : notes},
                success: function(msg){
                    if(msg == 1){
                        toastr.success('Return request has been sent');
                    }else{
                        toastr.success('All products Have Been returned already');
                    }
                }
            });
        }

    }
    function prod_modal(id){
        //console.log("triggered");

        $.ajax({
            type: "GET",
            url: JS_BASE_URL+"/seller/gator/return_prod_modal/"+id,
            success: function(html){
                console.log(html.data);
                var products = html.data;
                var mini_modal =``;
                var index = 1;
                var new_index = 0;
                jQuery.each( products, function( key, product) {
                    if(product.consignment_total>0 && product.retail_price>0){
                        ++new_index;
                    }
                });
                var disable;
                var disabled;
                var price;
                var count = new_index;

                jQuery.each( products, function( key, product) {
                     price = product.retail_price;
                    if (product.consignment_total > 0 && product.wid != "NULL") {
                        disable="";
                    }
                    if (product.consignment_total < 1 && product.retail_price > 0) {
                        /*Product has b2b price but no quantity*/
                        disable="disable_input";
                        price = 0;
                    }
                    if(product.consignment_total >0 && product.retail_price >0)
                    {
                        mini_modal += `<tr style="vertical-align: middle;">
                <td>` + index + `</td><td>`+product.nproductid +`</td><td>`+product.name+`</td>
                <td style="cursor:pointer;text-align: right;"  class='bmedium'><span id="price`+index+`">`+price+`</span>
                 <span style="display: none;" id="priceget`+index+`">`+
                                price/100+`</span></td>
                <td><div style="margin-left: 10%;" class="col-lg-10">
                                  <div class="input-group">
                                   <span class="input-group-btn">
                                 <button `;
                        if(product.consignment_total == 0 || product.segment!='b2b'){
                            disabled="disabled"; }
                            mini_modal +=`onclick="plus(`+index+`,`+product.id+`,`+product.consignment_total+`)" type="button" class="quantity-right-plus btn-css btn btn-primary btn-number"
                            data-type="plus" data-field=""><span class="glyphicon glyphicon-plus"></span>
                                 </button>
                             </span>
                             <span id="qtyfield`+index+`">
                                 <input`;
                            if(product.consignment_total == 0 || product.segment!='b2b'){disabled="disabled";}
                            mini_modal+=` onchange="qtyupdate(`+index+`,`+product.id+`,`+product.consignment_total+`)"  type="text" id="d`+index+`"
                            name="quantity`+product.id+`" class="form-control text-center input-number" value="0" min="0" max="1000000">
                             </span>
                             <span class="input-group-btn">
                                <button `;
                        if(product.consignment_total == 0 || product.segment!='b2b'){ disabled="disabled";}
                        mini_modal +=` onclick="minus(`+index+`,`+product.id+`,`+product.consignment_total+`)" type="button"
                                class="quantity-left-minus btn-css btn btn-primary btn-number"  data-type="minus" data-field="">
                                 <span class="glyphicon glyphicon-minus"></span>
                             </button>
                         </span>
                     </div>
                 </div>
                </td> <td style="text-align: right;" class=' bmedium '><span class="total_of_goods" id="pricetotal`+index+`" >0.00</span></td></tr>`;
                        index++;
                    }
                    else{
                        mini_modal += `<tr style="vertical-align: middle; background-color:lightgray;" class="`+disable+`">
                            <td class='text-center bmedium' >`+count+`</td><td>`+product.nproductid +`</td><td>`+product.name+`</td>
                            <td style="cursor:pointer;text-align: right;"  class='bmedium'><span id="price`+index+`">`+0.00+`</span>
                 <span style="display: none;" id="priceget`+count+`">`+
                                0.00+`</span></td>
                <td><div style="margin-left: 10%;" class="col-lg-10">
                                  <div class="input-group">
                                   <span class="input-group-btn">
                                 <button `;
                        if(product.consignment_total == 0 || product.segment!='b2b'){
                            disabled="disabled"; }
                        mini_modal +=`onclick="plus(`+index+`,`+product.id+`,`+product.consignment_total+`)" type="button" class="quantity-right-plus btn-css btn btn-primary btn-number"
                            data-type="plus" disabled data-field=""><span class="glyphicon glyphicon-plus"></span>
                                 </button>
                             </span>
                             <span id="qtyfield`+count+`">
                                 <input`;
                        if(product.consignment_total == 0 || product.segment!='b2b'){disabled="disabled";}
                        mini_modal+=` onchange="qtyupdate(`+index+`,`+product.id+`,`+product.consignment_total+`)"  type="text" id="d`+index+`"
                            name="quantity`+product.id+`" disabled class="form-control text-center input-number" value="0" min="0" max="1000000">
                             </span>
                             <span class="input-group-btn">
                                <button `;
                        if(product.consignment_total == 0 || product.segment!='b2b'){ disabled="disabled";}
                        mini_modal +=` onclick="minus(`+index+`,`+product.id+`,`+product.consignment_total+`)" type="button"
                                class="quantity-left-minus btn-css btn btn-primary btn-number" disabled  data-type="minus" data-field="">
                                 <span class="glyphicon glyphicon-minus"></span>
                             </button>
                         </span>
                     </div>
                 </div>
                </td> <td style="text-align: right;" class=' bmedium '><span class="total_of_goods" id="pricetotal`+index+`" >0.00</span></td></tr>`;
                        count++;
                    }
                });
                mini_modal += ``;
                $('#stack2').modal('show');
                $('#mini_modal').html(mini_modal);
                var table = $('#gatortable').DataTable();
                table.destroy();
                $('#gatortable').DataTable({
                    //"order": [[ 4, 'desc' ]],
                    "order": [[ 0, 'asc' ]],
                });
            }
        });
    }
    function close_prod_modal(){
        $('#stack2').modal('hide');
    }
    function close_prod_modal2(){
        $('#stack3').modal('hide');
    }

    function mini_seller_gator(id){

        $.ajax({
            type: "GET",
            url: JS_BASE_URL+"/seller/gator/seller_mini_gator/"+id,
            success: function(html){
                $('#stack3').modal('show');
                $('#seller_mini_modal').html(html);
            }
        });

    }

</script>

<div id="stack2" style="z-index: 99999;" class="modal fade"  style="display: none;">
    <div style="width: 120%;"  class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        style="position:relative;top:-6px"
                        onclick="close_prod_modal()">&times;</button>
            </div>
            <div class="modal-body">
                <div  class="container">
                    <div class="start-loader-main "></div>
                    <div style="float: right;color: white; padding-top: 28px; margin-right: 0px !important; " type="button" id="previewso" class=" skyblue sellerbutton" >Purchase</div>

                    <h2 style=" width: 40%;float: left; color:black; padding-top: 5px;">
                        Exchange and Purchase Product</h2>
                    <div>
                        <!-- Modal -->
                    </div>
                    <div id="prod_modal">
                        @include('seller.gator.mini_gator')
                    </div>
                </div>
                <div class="modal-footer" style="text-align: left;">

                </div>
            </div>
        </div>
    </div>
</div>
