<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')
@include("common.sellermenu")


<script type="text/javascript" src="{{asset('js/html2pdf.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/pdfmake.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/buttons.html5.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('/css/datatable.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">



<style type="text/css">
    #cancelstamp{
        color: red;
        position: absolute;
        z-index: 2;
        font-size: 70px;
        font-weight: 500;
        margin-top: 130px;
        margin-left: 35%;
        transform: rotate(30deg);
        display:none;
    }
    #completed{
        color: red;
        position: absolute;
        z-index: 2;
        font-size: 70px;
        font-weight: 500;
        margin-top: 200px;
        margin-left: 35%;
        transform: rotate(30deg);
        display:none;
    }

    #time,#completed_time{
		position:relative;
		top:-35px;
        font-size:22px;
        padding-top: 0px;
    }
    #cancel{
        padding-bottom: 0px;
    }
    br {
        display: block; /* makes it have a width */
        content: ""; /* clears default height */
        margin-top: 0; /* change this to whatever height you want it */
    }
    .hide {display:none}

    #cancel11{
        padding-bottom: 0px;
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
.float-right{
    float: right;
}
</style>

<div class="modal-content">
	<div style="padding-left:15px;padding-bottom:10px;margin-bottom:20px;
		margin-top:10px"
		class="modal-body">
	<div id="sodisp">
        <div style="padding: 15px;padding-top:0" id="download">
            <br>
            <div >
                <p class="text-center" id="cancelstamp">
				<span id="cancel">Cancelled</span><br>
				<span id="time">{{date('dMy H:i', strtotime($time))}}</span></p>
                <div class="row" style="padding-left:0;padding-right:0;margin-bottom:10px">
                    <div class="col-md-12"
                         style="display:flex;align-items:flex-end;padding-left:0;padding-right:0;margin-bottom:10px">
                        <div class="col-md-4" style="position:relative;top:70px;padding-right:0">
                            <p style="margin: 0px">
                                <?php if($buyeraddress) echo $buyeraddress->company_name ?></p>
                            <p style="margin: 0px">
                                <?php if($buyeraddress) echo $buyeraddress->business_reg_no ?></p>
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
                                <strong>Date:&nbsp;</strong>
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
                                <?php if($merchant) {echo $merchant->business_reg_no; } ?></p>
                            <p style="margin: 0px">
                                <?php if($merchant) {echo $merchant->line1; } ?></p>
                            <p style="margin: 0px">
                                <?php if($merchant) {echo $merchant->line2; } ?></p>
                            <p style="margin: 0px">
                                <?php if($merchant) {echo $merchant->line3; } ?></p>
                            <p style="margin: 0px">
                                <?php if($merchant) {echo $merchant->line4; } ?></p>

                        </div>
                        <p class="text-center" style="display: none;" id="completed">
                            <span id="completed_">Completed</span><br>
                            <span id="completed_time">{{date('dMy H:i', strtotime($merchant->comp_time))}}</span></p>
                        <div class="col-md-4 text-right" style="padding-left:0;padding-right:0">
                            <div class="">
                                <div class="col-md-12" style="">

                                    {{--<button style="padding-top:8px;background-color:skyblue;--}}
					{{--font-size:13px;width:70px;height:70px;margin-bottom:5px;--}}
					{{--color: white; border-radius:10px;margin-right:5px;--}}
					{{--padding-left:5px"--}}
                                            {{--id="submitform" type="button" onclick="genPDF()"--}}
                                            {{--class="btn controlbtn" wfd-id="1618">--}}
                                        {{--Download</button>--}}
                                    <div id="mybutt" class="col-md-2 text-right pull-right"
                                         style="padding:0;">
                                    </div>

                                    <div style="width: 70px; height: 70px; float: right;"
                                         class="qrcodec"></div>

                                </div>
                                <div class="" style="margin-top: 5px;">
                                    <div class="col-md-12" style="">
                                    @if($stat == 'cancelled')
                                        @else
                                        <button style="padding-top:8px;background-color:skyblue;
					font-size:13px;width:70px;height:70px;margin-bottom:5px;
					color: white; border-radius:10px;margin-right:5px;
					padding-left:5px"
                                                id="comp_btn" type="button" onclick="complete_btn({{$merchant->p_id}})"
                                                class="btn controlbtn" wfd-id="1618">
                                            Complete</button>
                                            @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12" style="display:flex;align-items:flex-end">
                        <div class="col-md-4" style="padding-left:0;padding-right:0">
                            @if(isset($merchant->nid))
                                <h5><strong>DO ID: </strong>{{$merchant->nid}}</h5>
                            @else
                                <h5><strong>Order ID: </strong>{{$nporder_id}}</h5>
                            @endif

                        </div>


                        <div class="col-md-4 text-center"
                             style="padding-left:0;padding-right:0;margin-bottom:1px">
                            @if(isset($heading))
                                <p style="font-size:25px;margin-bottom:0">
                                    <strong>{{$heading}}</strong></p>
                            @else
                                <p style="font-size:25px;margin-bottom:0">
                                    <strong>Delivery Order</strong></p>
                            @endif
                        </div>

                        <div class="col-md-4"
                             style="padding-left:0;padding-right:30px;margin-bottom:6px">
                            <table class="pull-right">
                                <tr>
                                    <td><strong>Staff Name&nbsp;&nbsp;</strong></td>
                                    <td>:
                                        <?php if($selluser) {
                                            echo $selluser->first_name . " ". $selluser->last_name;
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=""><strong>Staff&nbsp;ID</strong></td>
                                    <td>:
                                        <?php if($merchant) {
                                            printf('%06d',$merchant->staff_id);
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
                                    <td style=""><Strong>Delivery Order No&nbsp;&nbsp;</strong></td>
                                    <td>:
                                        <?php if($merchant) {
                                            echo sprintf('%010d', $doid);
                                        } ?>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div  style="align-self:flex-end">

                <table id="do_table" class="table" style="margin-bottom: 0px;">
                    <thead>
                    <tr style="border-bottom:1pxsolid#ddd;background:black;color:white;">
                        <th class="text-center">No</th>
                        <th class="text-center">Product&nbsp;ID</th>
                        <th class="text-left">Description</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Price&nbsp;({{$currentCurrency}})</th>
                        <th class="text-right">Amount&nbsp;({{$currentCurrency}})</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php   $index = 1;$totalc=0; ?>
                    @foreach($invoice as $invoices)
                        <?php $price = $invoices->order_price;
                        $p_price = $price/100;
                        $totalc  += $invoices->approved_qty*$p_price;
                        ?>
                        @if(!is_null($invoices->approved_qty))
                            <tr>
                                <td style="width: 5%;" class="text-center">{{$index++}}</td>
                                <td style="width: 15%;" class="text-center">{{$invoices->nproduct_id}}</td>
                                <td style="width: 50%;" class="text-left">
                                    @if(File::exists(URL::to("images/product/$invoices->prid/thumb/$invoices->thumb_photo")))
                                        <img width="30" height="30" src="{{URL::to("images/product/$invoice->prid/thumb/$invoices->thumb_photo")}}">
                                    @elseif(File::exists(URL::to("images/product/$invoices->parent_id/thumb/$invoices->thumb_photo")))
                                        <img width="30" height="30" src="{{URL::to("images/product/$invoice->parent_id/thumb/$invoices->thumb_photo")}}">

                                    @endif

                                    {{($invoices->name)}}

                                </td>

                                <td style="width: 5%;" class="text-center">{{$invoices->approved_qty}}</td>
                                <td style="width: 10%;" style="width: 13%;" class="text-right">{{number_format($invoices->order_price/100,2)}}</td>
                                <td style="width: 10%;" class="text-right">{{number_format($invoices->order_price/100*$invoices->approved_qty,2)}}</td>

                            </tr>
                            @else
                        <?php $price = $invoices->order_price;
                        $p_price = $price/100;
                        $totalc  += $invoices->quantity*$p_price;
                        ?>
                        <tr>
                            <td style="width: 5%;" class="text-center">{{$index++}}</td>
                            <td style="width: 15%;" class="text-center">{{$invoices->nproduct_id}}</td>
                            <td style="width: 50%;" class="text-left">
                                @if(File::exists(URL::to("images/product/$invoices->prid/thumb/$invoices->thumb_photo")))
                                    <img width="30" height="30" src="{{URL::to("images/product/$invoice->prid/thumb/$invoices->thumb_photo")}}">
                                @elseif(File::exists(URL::to("images/product/$invoices->parent_id/thumb/$invoices->thumb_photo")))
                                    <img width="30" height="30" src="{{URL::to("images/product/$invoice->parent_id/thumb/$invoices->thumb_photo")}}">

                                @endif

                                {{($invoices->name)}}

                            </td>

                            <td style="width: 5%;" class="text-center">{{$invoices->quantity}}</td>
                            <td style="width: 10%;" style="width: 13%;" class="text-right">{{number_format($invoices->order_price/100,2)}}</td>
                            <td style="width: 10%;" class="text-right">{{number_format($invoices->order_price/100*$invoices->quantity,2)}}</td>

                        </tr>
                        @endif
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
                        <td></td>
                        <td> Total {{$currency}}</td>
                        <td
						style="text-align: right; font-weight: bold; font-size:17px">
                           &nbsp;{{$total}}</td>
                    </tr>
                    </tbody>
                </table>
                <hr style="margin-bottom: 7px;">
                @if($merchant->status == 'completed' && $merchant->discard == 'pickup')
                    <p class="pull-left text-danger"
                       style="padding-right:10px;padding-top:2px;font-size:16px">

                            Customer Pickup.
                       {{--  @elseif($merchant->status == 'cancelled' && $merchant->discard == 'cancelled')
                            Cancelled Order
                        @elseif($merchant->status == 'cancelled' && $merchant->discard == 'error')
                            Error Adjustment --}}

                    </p>
                    @endif

                    <p class="pull-right"
                       style="padding-right:10px;padding-top:2px;font-size:10.5px">
                        Goldfish Shukin V1.0
                    </p>
               {{--@if($merchant->status == 'inprogress')--}}
               <?php
                    // $invoice_no = '';
                    // $deliverymanId ='';
                    // if($merchant->invoice_no != ''){
                        // $invoice_no = sprintf('%010d',$merchant->invoice_no);
                    // }
                    // if($merchant->deliverymanId != '')
                    // {
                    //     $deliverymanId = sprintf('%06d',$merchant->deliverymanId);
                    // }
               ?>
                    <table style="margin-left: 26px;margin-top: 5px;">
                    @if($merchant->direct == 0 && $merchant->status != 'cancelled')

                     <tr>
                        <td style="text-align: left">
                            <strong >Sales Order No.  </strong>
                        </td>
                        <td>
                            : <span id=""><a href="#"
                                onclick="deliveryOrderSO({{$merchant->p_id}})">{{--sprintf('%010d', $merchant->salesorder_no )--}} {{$salesorder_no}}</a></span>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="text-align: left">
                            <strong >Invoice No.  </strong>
                        </td>
                        <td>
                            : <span id=""><a href="#" onclick="deliveryOrderDirectInvoice({{$merchant->p_id}})">{{-- $invoice_no --}} {{$invoiceNo}}</a></span>
                        </td>
                    </tr>
                   {{-- @if($merchant->memberfirst != '' && $merchant->memberlast != '') --}}
                   @if($merchant->status == 'inprogress')
                    <tr>
                        <td style="text-align: left">
                            <strong >DeliveryMan Name</strong>
                        </td>
                        <td>
                            : <span id="">{{--$merchant->memberfirst--}} {{--$merchant->memberlast --}} {{$dman_name}}</span>
                        </td>
                    </tr>
                   {{-- @endif --}}
                    {{--@if($merchant->deliverymanId != '')--}}
                    <tr>
                        <td style="text-align: left">
                            <strong >DeliveryMan ID  </strong>
                        </td>
                        <td>
                            : <span id="">{{-- $deliverymanId --}} {{$dman_id}}</span>
                        </td>
                    </tr>
                    @endif
                    {{--@endif--}}
                    </table>
                <div style="padding-left: 25px; "id="ImeiWarrant">
                    <br><br>
                </div>
                    @if($merchant->status == 'inprogress' ||'completed ' )
                    <ul class="diff_message">
                         @foreach($invoice as $singleinvoice)
                            <?php
                            $dif = $singleinvoice['quantity'] - $singleinvoice['approved_qty'];
                            if(!is_null($singleinvoice['approved_qty']) && ($dif > 0)){
                                $units = ' unit';
                                if($dif > 1){
                                    $units = ' units';
                                }
                            ?>
                                <li class="text-left">{{ $singleinvoice['name']}} has been approved with a difference of {{$dif}} {{$units}}</li>
                            <?php
                            } 
                            ?>
                      
                        @endforeach
                    </ul> 
                    @endif

            </div>

            <div id="content">

            {{--<div style="text-align: right; padding-right: 8px;">--}}
            {{--Total include 6% GST &nbsp&nbsp {{$currentCurrency}}&nbsp{{$gst}}<br><span>Item Total &nbsp&nbsp {{$currentCurrency}}&nbsp{{$itmtotalprice}}</span>--}}
            {{--</div>--}}

        </div>
        <p id = "salerOrderId" style="display: none;">{{$id}}</p>
        <p id ="order_status" style="display: none;">{{$status}}</p>
            <p id ="do_status" style="display: none;" >{{$stat}}</p>
        <script type="text/javascript" src="<?php echo e(asset('js/qr.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.js')); ?>"></script>
        <script type="text/javascript">
            $('#do_table').DataTable({
                dom: 'Blfrtip',		// We want length too!!!
                buttons: [{
                    extend: 'pdfHtml5',
                    text: 'Download',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    },
                    filename: "Product Sales by Quantity",
                    customize: function(doc) {
                        console.log(doc);

                        /* Report Text header */
                        doc['content'][0] = [

                            {text: "Delivery Order",
                                style: "nheader"
                            }];


                        doc['styles']['nheader'] = {
                            fontSize:18, bold:true, alignment:"left"
                        };

                        /* Define column widths */
                      //  doc.content[1].table.widths = [150, '*', 70]

                        /* Sales column right aligned */
                        var tbody = doc['content'][1].table.body;
                        tbody.forEach(function(val, idx, ary) {
                            tbody[idx][2].alignment = 'left';
                            tbody[idx][4].alignment = 'right';
                            tbody[idx][5].alignment = 'right';
                        });

                        /* Datatable Header, "Sales" Qty */
                       // doc['content'][1].table.body[0][2].text = 'Qty  ';
                      //  doc['content'][1].table.body[0][2].alignment = 'center';

                      //  doc['footer'] = "";
                    }
                }],

                language: {
                    searchPlaceholder: "Product Name, Product ID"
                },
                initComplete: function(settings, json) {
                    /* Move [Download] button to its final resting place */
                    $('#mybutt').empty();
                    $('#mybutt').append($('.dt-buttons').children());
                    $('.dt-button').attr('style','width:70px;height:70px;border-radius:5px;padding-left:4px;background:skyblue;border-color:skyblue;color:white;margin-right:0;border-width:0');
                }
            });
            function genPDF() {
                $( "#download" ).css({"margin-top": "30px"});
                var elements = document.getElementById('download');
                $("#submitform").hide();
                $('#comp_btn').hide();
                html2pdf(elements);
                $("#submitform").show();
                $('#comp_btn').show();
                $( "#download" ).css({"margin-top": "0px"});
            }
            function hide(element) {  element.css("display","none"); }
            $(document).ready(function(){

                getfooterdetails({{$merchant->p_id}});
                $('.qrcodec').qrcode({height:70,width:70,text: <?php if($merchant) {echo sprintf('%060d', $merchant->salesorder_no);  }else{ echo "00000000000000000";} ?> });

                  var   status =   $('#order_status').html();
               // alert(status);
                if(status == 'cancelled'){
                    $('#cancelstamp').show();
                    $('#comp_btn').css('display','none');
                }else if(status == 'completed'){
                }

                var   stat =   $('#do_status').html();
                // alert(status);
                if(stat == 1){
                    $('#completed').css('display','block');
                    $('#comp_btn').css('display','none');
                }
                //else if(status == 'completed'){
               // }
            });

            function deliveryOrderDirectInvoice(id) {
                $.ajax({
                    type: "GET",
                    url: JS_BASE_URL+"/seller/directinvoice/"+id,
                    success: function( data ) {
                        console.log("Opening Invoice Modal");
                        getfooterdetails(id,"di");
                        $('#directInvoiceDelivery').modal('show');
                        $('#directInvoiceDeliveryHtml').html(data);
                    }
                });
            }

            function deliveryOrderSO(id) {
                $.ajax({
                    type: "GET",
                    url: JS_BASE_URL+"/seller/gator/saleorder/"+id,
                    success: function( data ) {
                        console.log("Opening SO Modal");
                        getfooterdetails(id,"so");
                        $('#SoDelivery').modal('show');
                        $('#SoDeliveryHtml').html(data);
                    }
                });
            }

            function getfooterdetails(id,type=null) {
                console.log("Okay");
                $('#Qtydifferent_messages').html('');
                $.ajax({
                    type: "GET",
                    url: JS_BASE_URL+"/seller/Sofooterdetails/"+id,
                    success: function( data ) {
                        console.log("Data?");
                        console.log(data);
                        if(data.deliveryId != ""){
                            if(type="di")
                            {
                                $('#footerDetailsForDelivery').show();
                                $('#salesorderdeliveryid').html(data.salesorder_no);
                                $('#dmandeliveryName').html(data.dman_name);
                                $('#dmandeliveryID').html(data.dman_id);
                                var url = JS_BASE_URL+"/DO/displaydeliveryorderdocument/"+id;
                                $('#InvoiceNoDI').html(data.deliveryId);
                            }
                            if(type="so")
                            {
                                console.log("Data ID"+data.deliveryId);
                                $('#footerDetailsForSoDelivery').show();
                                $('#InvoiceNo').html(data.invoiceNo);
                                $('#doid').html(data.deliveryId);
                            }
                            if(data.ProductData != "" ){


                                var HtmlTableImei = '';
                                HtmlTableImei += '<table>';
                                // console.log(data.ProductData[0].imeiNo);
                                // console.log('======================');
                                // console.log(data.ExistingDataInArray);
                                // $.each(data.ProductData,function(key,value){
                                console.log("Data existing in Array");
                                console.log(data.ExistingDataInArray);
                                $.each(data.ExistingDataInArray,function(key,datavalue){
                                    // var imeiNo = datavalue.imeiNo;
                                    // var warrantyNo = datavalue.warrantyNo;
                                    // console.log(datavalue.imeiNo);


                                    // if((data.ProductData[key].imeiNo != "" && data.ProductData[key].imeiNo != null )&&( data.ProductData[key].warrantyNo != "" && data.ProductData[key].warrantyNo != null)){
                                    var mainQty = datavalue.quantity;


                                    if(datavalue.approved_qty >= 0){
                                        $('#doid').html('<a href="#" onclick="deliveryorder('+id+')">'+data.deliveryId+'</a>');

                                        mainQty = datavalue.approved_qty;


                                        var ul_list = $('#Qtydifferent_messages');

                                        var dif = datavalue.quantity - datavalue.approved_qty;

                                        var units = ' unit';
                                        if((dif > 0) && (datavalue.approved_qty != null)){
                                            console.log('========ProductData!========');
                                            var msg = '<li class="text-left">' +datavalue.pname + ' has been approved with a difference of '+ dif + units+' less than original quantity.</li>';
                                            ul_list.append(msg);
                                        }
                                    }
                                    HtmlTableImei += 	'<tr>';

                                    for (var i = 0; i < datavalue.imeiDetail.length; i++) {

                                        if(datavalue.imeiDetail[i].imeiNo != '' || datavalue.imeiDetail[i].warrantyNo != ''){
                                            if(i==0){

                                                HtmlTableImei += 		'<td style="text-align: left">';
                                                //HtmlTableImei += 			'<strong >'+datavalue.pname+'</strong> ( '+mainQty+' )';
                                                HtmlTableImei += 			'<strong >'+datavalue.pname+'</strong>';
                                                HtmlTableImei += 		'</td>';
                                            }
                                        }

                                        HtmlTableImei += 		'<tr>';
                                        if(datavalue.imeiDetail[i].imeiNo != ''){
                                            HtmlTableImei += 			'<td>';
                                            HtmlTableImei += 				'Serial/IMEI No. : <span>'+datavalue.imeiDetail[i].imeiNo+'</span>';
                                            HtmlTableImei += 			'</td>';
                                        }
                                        if(datavalue.imeiDetail[i].warrantyNo != ''){
                                            HtmlTableImei += 			'<td>';
                                            HtmlTableImei += 				'Warranty No. : <span>'+datavalue.imeiDetail[i].warrantyNo+'</span>';
                                            HtmlTableImei += 			'</td>';
                                        }
                                        HtmlTableImei += 		'</tr>';

                                    }
                                    HtmlTableImei += 	'</tr>';


                                });
                                var condition = '';
                                $.each(data.ProductData,function(key,returns) {

                                    if(returns.status == 'approved'){
                                        HtmlTableImei += '<tr> ';
                                        if (returns.return_option == 'd') {
                                            condition = 'Exchange of Stocks';
                                        }else if(returns.return_option == 'dx') {
                                            condition = 'Exchange of Stocks (Damaged)';
                                        }
                                        else if(returns.return_option == 'rx'){
                                            condition = 'Return Only (Damaged)';
                                        }
                                        else if(returns.return_option == 'r'){
                                            condition = 'Return Only';
                                        }
                                        HtmlTableImei += '<td>';
                                        HtmlTableImei += returns.pname + ' has been returned with 1 quantity (' + condition + ')' ;
                                        HtmlTableImei += '</td>';

                                        HtmlTableImei += 		'</tr>';
                                    }

                                });
                                HtmlTableImei += '</table>';

                                console.log("els fin");
                                $('#ImeiWarranty').html(HtmlTableImei);
                                $('#ImeiWarrant').html(HtmlTableImei);
                                $('#ImeiWarrantforso').html(HtmlTableImei);

                            }
                        // $('#footerDetails').show();
                        // $('#InvoiceNo').html(data.doid);
                       
                        // $('#doid').html('<a href="#" onclick="deliveryorder('+id+')">'+data.deliveryId+'</a>');
                        // $('#dmanid_'+data.dman_id).prop("checked",true);
                            }
                                    
                        }
                });
            }
            function complete_btn(id){

                $('#disable_com').html(1);
                $.ajax({
                    type: "GET",
                    url: JS_BASE_URL + "/seller/complete_do/" + id,
                    success: function (data) {
                        if(data == 1){
                            $('#completed').css('display','block');
                            location.reload();
                            toastr.success('Order Has been Completed');
                        }else{
                            toastr.success('An Error Occurred');
                        }

                    }
                });

            }
            function close_inv_modal(){
                $('#directInvoiceDelivery').modal('hide');
            }
        </script>
	</div>
	</div>
	<br>
	<br>
	</div>

    <div class="modal fade" style="z-index: 999999;" id="directMerchantInvoice" role="dialog">
        <div style="width: 80%" class="modal-dialog" id="modelWidth">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header" id="headerCss"
                     style="padding-top:10px;padding-bottom:10px" >
                    <button type="button" id="close_button"
                            style="position:relative;top:0px;color:black;
					border-top-left-radius:5px;border-top-right-radius:5px"
                            class="close" data-dismiss="modal">&times;</button>
                    <h3 id="model_header"></h3>

                </div>
                <div class="modal-body ">
                    <div class="text-center" id="directMerchantInvoiceHtml"> </div>

                </div>
                <div class="modal-footer">
                </div>
            </div>

        </div>
    </div>
    <!-- START INVOICE MODEL-->
    <div class="modal fade" id="directInvoiceDelivery" tabindex="-1" data-focus-on="input:first" style="display: none;" role="dialog">
        <div style="width: 80%;"  class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button"
                        style="position:relative;top:-6px"
                        onclick="close_inv_modal()" data-dismiss="modal">&times;</button>
                      <!-- <h3>Direct Merchant Invoice</h3> -->
                </div>
                <div class="modal-body">
                    <div id="disable_com" style="display: none;">{{$stat}}</div>
                  <div id="directInvoiceDeliveryHtml"> </div>
                </div>
                <div class="modal-footer" style="text-align: left;">
                    <div class="col-md-12" id="footerDetailsForDelivery" style="display:none;">
                         <table style="margin-left: 26px;margin-top: 5px;">
                             <tr>
                                    @if($direct != 1)
                                <td style="text-align: left"><strong>Sales Order No. :</strong></td>
                                 @endif
                                <td> <span id="salesorderdeliveryid"></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: left"><strong>Delivery Order ID</strong></td>
                                <td>: <span id="InvoiceNoDI"></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: left"><strong>DeliveryMan Name</strong></td>
                                <td>: <span id="dmandeliveryName"></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: left"><strong>DeliveryMan ID </strong></td>
                                <td>: <span id="dmandeliveryID"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12" id="ImeiWarranty">
                    </div>
                    <ul id="Qtydifferent_messages" style="margin-left: -10px;">
                    </ul>
                </div>
                </div>
            </div>
        </div>

  <!-- END INVOICE MODEL-->
  <!-- START SO MODEL-->
    <div class="modal fade" id="SoDelivery" role="dialog">
        <div style="width: 80%;"  class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button"
                        style="position:relative;top:-6px"
                        class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <div id="SoDeliveryHtml"> </div>
                </div>
                <div class="modal-footer" style="text-align: left;">
                    <div class="col-md-12" id="footerDetailsForSoDelivery" style="display:none;">
                         <table style="margin-left: 26px;margin-top: 5px;">
                            <tr>
                                <td style="text-align: left">
                                    <strong >Invoice No.  </strong>
                                </td>
                                <td> : <span id="InvoiceNo"></span></td>
                            </tr>
                            <tr>
                                <td style="text-align: left">
                                    <strong >Delivery Order ID  </strong>
                                </td>
                                <td> : <span id="doid"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12" id=ImeiWarrantforso">

                    </div>
                    <ul id="Qtydifferent_messages" style="margin-left: -10px;">

                    </ul>

                </div>
                </div>
            </div>
        </div>


</div>
  <!-- END SO MODEL-->
	@yield("left_sidebar_scripts")


@stop
