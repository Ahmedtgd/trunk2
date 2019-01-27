<style type="text/css">
    .table-nonfluid {
        width: 57% !important;
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
    #cancel11{
        padding-bottom: 0px;
    }
    br {
        display: block; /* makes it have a width */
        content: ""; /* clears default height */
        margin-top: 0; /* change this to whatever height you want it */
    }
    .top-margin{
        margin-top: -30px;
    }
</style>

@extends("common.default")
<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
?>
@section("content")

    <div class="container"><!--Begin main cotainer-->

        <style>
            #voidstamp{
                color: red;
                position: absolute;
                z-index: 2;
                font-size: 70px;
                font-weight: 500;
                margin-top: 40px;
                margin-left: 35%;
                transform: rotate(30deg);
                display:none;
            }
            #time{
                position:relative;
                top:-20px;
                font-size:20px;
                padding-top: 0px;
            }
            #cancel11{
                padding-bottom: 0px;
            }
            br {
                display: block; /* makes it have a width */
                content: ""; /* clears default height */
                margin-top: 0; /* change this to whatever height you want it */
            }
        </style>
        <div class="" id="PDFDownload" style="margin-top:20px">
            <div class="row">
                <div class="col-md-12">

                    <div class="row" style="display:flex;align-items:flex-end">
                        <div class="col-md-4" style="text-align: left;">
                        <!-- {{$InvoiceDisplayData['array_delivery'][0]['user_name']}}<br>
				{{$InvoiceDisplayData['array_delivery'][0]['user_address']}}<br>
				{{$InvoiceDisplayData['array_delivery'][0]['line2']}}
                        {{$InvoiceDisplayData['array_delivery'][0]['line3']}}<br><br>
				{{$InvoiceDisplayData['array_delivery'][0]['orderdate']}}<br> -->

                            <?php
                            Log::debug("***** InvoiceDisplayData['array_delivery'] *****");
                            Log::debug(json_encode($InvoiceDisplayData['array_delivery']));
                            ?>

                            {{--
                            @if($InvoiceDisplayData['array_delivery'][0]['merchant_name'])
                                {{$InvoiceDisplayData['array_delivery'][0]['merchant_name']}}
                                <br>
                            @endif
                            --}}
                            @if($InvoiceDisplayData['array_delivery'][0]['dealer_cname'])
                                {{$InvoiceDisplayData['array_delivery'][0]['dealer_cname']}}
                                <br>
                            @endif
                            @if($InvoiceDisplayData['array_delivery'][0]['dealer_bizregno'])
                                ({{$InvoiceDisplayData['array_delivery'][0]['dealer_bizregno']}})
                                <br>
                            @endif
                            @if($InvoiceDisplayData['array_delivery'][0]['user_address'])
                                {{$InvoiceDisplayData['array_delivery'][0]['user_address']}}
                                <br>
                            @endif
                            @if($InvoiceDisplayData['array_delivery'][0]['line2'])
                                {{$InvoiceDisplayData['array_delivery'][0]['line2']}}
                            @endif
                            @if($InvoiceDisplayData['array_delivery'][0]['line3'])
                                {{$InvoiceDisplayData['array_delivery'][0]['line3']}}
                                <br>
                            @endif
                            @if($InvoiceDisplayData['array_delivery'][0]['orderdate'])
                                <br>
                                {{$InvoiceDisplayData['array_delivery'][0]['orderdate']}}
                                <br>
                            @endif

                        </div>

                        <div class="col-md-8 text-right" style="padding-left:0;">
                            <div class="">
                                <div class="col-md-12" style="padding-right:0" id="buttonshide">

                                    <a style="padding-top:26px;background-color:skyblue;
								color: white; border-radius:10px;margin-right: 10px;
								padding-left:2px;margin-bottom:5px"
                                       href="#" id="downloadBtn" class="btn controlbtn text-center"
                                       onclick="genPDF()">
                                        <span class=""></span>Download</a>

                                    <div style="margin-right:0px;"
                                         class="pull-right qrcode"></div>
                                </div>
                            </div>
                            <div class="" style="margin-top: 5px;">
                                <!--div class="col-md-12" style="padding-right:0">
                                    @if($InvoiceDisplayData['stats'] == 'completed')
                                        <button style="border-radius:10px;
							margin-right:0;padding-left:14px;padding-top:10px;"
                                                href="#" onclick="refundpopup({{$InvoiceDisplayData['receipt_id']}});"
                                                class="btn controlbtn text-center bg-refund"
                                                id="return">
                                            <span class=""></span>Return</button>
                                    @else
                                        <button style="border-radius:10px;
							margin-right:0;padding-left:14px;padding-top:10px;" disabled
                                                href="#" onclick="refundpopup({{$InvoiceDisplayData['receipt_id']}});"
                                                class="btn controlbtn text-center bg-refund"
                                                id="return">
                                            <span class=""></span>Return</button>
                                    @endif
                                    @if($InvoiceDisplayData['stats'] == 'completed')
                                    @else
                                        <button style="padding-top:8px;background-color: red;
							font-size:13px;width:70px;height:70px;
							color: white;border-radius:10px;margin-right:0"
                                                id="cancel_btn"
                                                type="button" class="btn controlbtn"
                                                onclick="showModal()"
                                                wfd-id="1618">
                                            Cancel</button>
                                    @endif
                                </div-->
                            </div>
                        </div>
                    </div>

                    <div class="row"
                         style="padding-top: 10px;padding-bottom:10px;display:flex;text-align: left;">

                        <div class="col-md-5 float-left">
                            <table>
                                <tr>
                                    <td>Date</td>
                                    <td>&nbsp;&nbsp;&nbsp;: {{UtilityController::s_date($InvoiceDisplayData['CreatedDate']->created_at)}}</td>
                                </tr>
                                <tr>
                                    <td>Credit Term</td>
                                    <td>&nbsp;&nbsp;&nbsp;:&nbsp;{{$InvoiceDisplayData['term_durations']}}&nbsp;Days</td>
                                </tr>
                                <tr>
                                    <td>Credit Limit</td>
                                    <td>&nbsp;&nbsp;&nbsp;: <?php
                                        // echo $InvoiceDisplayData['currency']->code;
                                        // echo number_format($InvoiceDisplayData['StationtermData']->credit_limit/100,2);

                                        Log::debug('***** InvoiceDisplayData *****');
                                        Log::debug(json_encode($InvoiceDisplayData['StationtermData']));

                                        if (!empty($InvoiceDisplayData['StationtermData'])) {
                                        $credit_limit =
                                        $InvoiceDisplayData['StationtermData']->credit_limit;
                                        echo $InvoiceDisplayData['currency']->code.'&nbsp;';
                                        echo number_format($credit_limit/100,2);
                                        } else {
                                        echo "MYR 0.00";
                                        };
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Available</td>
                                    <td>&nbsp;&nbsp;&nbsp;: <?php

                                        Log::debug('***** InvoiceDisplayData *****');
                                        Log::debug(json_encode($InvoiceDisplayData));

                                        echo $InvoiceDisplayData['currency']->code.'&nbsp;';
                                        echo number_format($InvoiceDisplayData['availableCredit']/100,2);
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Order ID</td><span id="order_status" style="display:none;">{{$InvoiceDisplayData['status']}}</span>
                                    <td>&nbsp;&nbsp;&nbsp;:
                                    <!-- <?php //printf("%010d",$OrderId);?> -->
                                        {{ $InvoiceDisplayData['nporderid'] }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2 text-center" style="align-self:flex-end">
					<span><b
                                style="font-weight:600;font-size:25px; margin-top:0;">
					Invoice</b></span>
                        </div>

                        <!-- <div class="text-center ">
                            <h2 id="voidstamp">Cancelled<br>
                            <span
                            style="font-size:15px !important;"
                            id="voiddate"
                            >{{UtilityController::s_date($InvoiceDisplayData['CreatedDate']->updated_at)}}</span>
                            </h2>
                        </div> -->
                        <p class="text-center" id="voidstamp">
                            <span id="cancel11">Cancelled</span><br>
                            <span id="time">
				{{UtilityController::s_date($InvoiceDisplayData['CreatedDate']->updated_at)}}</span></p>

                        <div class="col-md-5" style="align-self:flex-end">
                            <table class=" float-right">
                                <tr>
                                    <td>Staff Name</td>
                                    <td>&nbsp;&nbsp;&nbsp;: <?php echo $InvoiceDisplayData['StaffName'];?></td>
                                </tr>
                                <tr>
                                    <td>Staff ID</td>
                                    <td>&nbsp;&nbsp;&nbsp;: <?php echo $InvoiceDisplayData['Staffid']; ?></td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>&nbsp;&nbsp;&nbsp;:
                                        <?php //echo $InvoiceDisplayData['CreatedDate']->created_at;?>
                                        {{UtilityController::s_date($InvoiceDisplayData['CreatedDate']->created_at)}}</td>
                                </tr>
                                <tr>
                                    <td>Invoice No</td>
                                    <td id="invoice_no">&nbsp;&nbsp;&nbsp;:
                                    <?php echo sprintf('%010d',$InvoiceDisplayData['CreatedDate']->invoice_no); ?>
                                    <!-- {{ $InvoiceDisplayData['CreatedDate']->invoice_no }}-->
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" style="">
                                <thead style="background-color:black;color:white ">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Product ID</th>
                                    <th style="width:40%">Description</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Price&nbsp;(MYR)</th>
                                    <th class="text-right">Amount&nbsp;(MYR)</th>
                                </tr>
                                </thead>
                                <tbody style="border-top: 0px solid #ddd;">
                                <?php
                                $counter = 1; $sum_qty = 0;
                                $sum_amount = 0;
                                $totalDeliveryPaid=0;
                                $glob=DB::table('global')->first()->gst_rate;
                                $tproducts = DB::table('orderproduct')
                                ->leftjoin('nproductid','nproductid.product_id','=','orderproduct.product_id')
                                ->where('orderproduct.porder_id',$InvoiceDisplayData['receipt_id'])->get();


                                ?>
                                @if(isset($tproducts))
                                    @foreach($tproducts as $tproduct)

                                        <tr>
                                            <?php
                                            $product_name = DB::table('product')->where('id', $tproduct->product_id)->first();
                                            ?>
                                            <td class="text-center">{{ $counter++ }}</td>

                                            <td class="text-center">{{ $tproduct->nproduct_id }}</td>

                                            <td class="text-left">{{ $product_name->name }}</td>
                                            <?php
                                            if(is_null($tproduct->approved_qty)){
                                            $opc=$tproduct->order_price;
                                            $tempTotal=($opc*$tproduct->quantity);
                                            $revenue = number_format($tempTotal/100,2);
                                            $totalPaid=($tproduct->quantity * $opc);
                                            $amount = number_format($totalPaid/100,2);
                                            $sum_qty += $tproduct->quantity;
                                            $sum_amount += $tempTotal;
                                            }else{
                                            $opc=$tproduct->order_price;
                                            $tempTotal=($opc*$tproduct->approved_qty);
                                            $revenue = number_format($tempTotal/100,2);
                                            $totalPaid=($tproduct->approved_qty * $opc);
                                            $amount = number_format($totalPaid/100,2);
                                            $sum_qty += $tproduct->approved_qty;
                                            $sum_amount += $tempTotal;
                                            }
                                            ?>
                                            @if(is_null($tproduct->approved_qty))
                                                <td class="text-center">{{ $tproduct->quantity or 0 }}</td>
                                            @else

                                                <td class="text-center">{{ $tproduct->approved_qty or 0 }}</td>
                                            @endif
                                            <td class="text-right">{{number_format($opc/100,2)}}</td>
                                            <td class="text-right">{{ $amount }}</td>
                                        </tr>

                                    @endforeach
                                    <tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td></td>
                                        <td class="text-center"></td>
                                        <td class="text-right"></td>
                                        <td class="text-right">
                                            <b>Total&nbsp;{{$InvoiceDisplayData['currency']->code}}&nbsp;{{ number_format($sum_amount/100,2) }}
                                            </b>
                                        </td>
                                    </tr>
                                @endif
                                <!-- <tr style="">
							<td colspan="6" style="">
							<span style="float: right;font-size: 17px;font-weight: 600;padding-right:0;">Total MYR 4.50</span>
							</td>
						</tr> -->
                                <tr>
                                    <td colspan="6"
                                        style="font-size:10px; margin-top:0;padding-top:4px">
                                        <span style="float: right; padding-right:0">Goldfish Ranchu V1.0</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-strips " style="">
                                <thead class="bg-arowana">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Bank</th>
                                    <th class="text-center">Method</th>
                                    <th style="width:30%">Note</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">Amount (MYR)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $NumberCounter = 1;

                                if(!empty($InvoiceDisplayData['PaidAmounts'])){
                                foreach ($InvoiceDisplayData['PaidAmounts'] as $key => $SinglePaidAmount) {
                                ?>
                                <tr>

                                    <td class="text-center">{{$NumberCounter++}}</td>
                                    <td class="text-center">{{UtilityController::s_datenotime($SinglePaidAmount->paidDate)}}</td>
                                    <td class="text-center">{{$SinglePaidAmount->bankname}}</td>
                                    <td class="text-center">{{$SinglePaidAmount->paidmethod}}</td>
                                    <td>{{$SinglePaidAmount->paidnote}}</td>
                                    <td class="text-center">{{$SinglePaidAmount->paidstatus}}</td>
                                    <td class="text-right">{{number_format($SinglePaidAmount->paidamount/100,2)}}</td>
                                </tr>
                                <?php
                                }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="confirmationModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">


                    </div>
                    <div class="modal-body">
                        <h4 class="modal-title">
                            <b>Do you want to cancel this Invoice?</b></h4>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6 pull-left">
                                <button style="padding-top:2px;font-size:13px;width:70px;
					height:40px;margin-bottom:5px;border-radius:10px;
					border:1px solid; margin-right:5px; float:left;
					padding-left:5px"
                                        type="button"
                                        onclick="deleteRecord({{$OrderId}})"
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

        <script type="text/javascript" src="<?php echo (asset('js/qr.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo (asset('js/html2pdf.js')); ?>"></script>
        <script type="text/javascript">

            $(document).ready(function(){


                // $('.qrcode').qrcode({height:70,width:65,text: <?php// if(isset($InvoiceDisplayData)) {echo sprintf('%060d', $InvoiceDisplayData['SalesOrderNo']);  }else{ echo "00000000000000000";} ?> });
                $('.qrcode').qrcode({height:70,width:65,text:"@if($InvoiceDisplayData) {{$InvoiceDisplayData['SalesOrderNo']}} @else 00000000000000000 @endif"});
                var   status =   $('#order_status').html();
                var complete =  $('#disable_com').html();
                // alert(status);
                if(status == 'cancelled'){
                    $('#return').hide();
                    $('#cancel_btn').hide();
                    $('#voidstamp').show();
                }
                if(complete == 1){
                    $('#return').prop('disabled', false);
                    $('#cancel_btn').hide();
                }

            });
            function closerefund(){
                $('#refundDirectal').modal('hide');
            }
            function genPDF() {

                $('#return').hide();
                $('#cancel_btn').hide();
                $('#downloadBtn').hide();
                var element = document.getElementById('PDFDownload');
                var opt = {
                    margin:       8,
                    filename:     'file.pdf',
                    enableLinks:	false
                };
                html2pdf(element,opt);
                //  	$('#return').show();
                // $('#cancel').show();
                $('#downloadBtn').show();
            }

            function showModal(){
                $('#confirmationModal').modal('show');
            }

            function deleteRecord(id) {
                // var url = window.location.href;
                //console.log(url);

                console.log(id);
                $.ajax({
                    type: "POST",
                    url: JS_BASE_URL+"/seller/deleteInvoiceRecord",
                    data:{"id":id},
                    success: function(data){
                        console.log(data);
                        if(data == 2){
                            toastr.success('Unable to perform because the transaction has already been Completed');
                        }else if(data == 3){
                            toastr.success('Unable to perform because the transaction has already been Cancelled');
                        }
                        else{
                            $('#confirmationModal').modal('hide');
                            $('#cancel_btn').hide();
                            $('#return').hide();
                            $('#comp_btn').hide();
                            document.querySelector("#voidstamp").style.display="block";
                            toastr.success('Invoice has been Successfully Cancelled');
                            location.reload();
                        }

                    }
                });
            }
            function close_modal(){
                $('#confirmationModal').modal('hide');
            }

            function refundpopup(id) {
                console.log("Hit");
                $.ajax({
                    type: "GET",
                    url: JS_BASE_URL+"/seller/gator/invrefund/"+id,
                    // data:{"id":id},
                    success: function(data){
                        $('#refundDirectal').modal('show');
                        $('#refundDirect').html(data);
                        console.log('***** refundDirect *****');
                    }
                });
            }
        </script>
        <div class="modal fade" id="refundDirectal"  tabindex="-1" data-focus-on="input:first" style="display: none;" role="dialog">
            <div class="modal-dialog" style="width:100%;padding-left:20px;padding-right:20px">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku" style="width:100% !important">
                    <div class="modal-header"
                         style="border-top-left-radius:5px;
				 	border-top-right-radius:5px;
				 	background-color:black;color:white">
                        <button type="button" class="close" onclick="closerefund();"
                                style="color:#cbcbcb;background:none;position:relative;top:8px">&times;</button>
                        <h3 class="modal-title" style="color:white">Return</h3>
                    </div>
                    <!-- Temporarily disable the modal due to UGLY ERROR -->
                    <div id="refundDirect"
                         style="padding-left:16px;padding-right:16px;
				 background-color: #ff9900;color:#fff;
				 border-bottom-left-radius: 5px;
				 border-bottom-right-radius: 5px"
                         class="modal-body">
                    </div>
                </div>
            </div>
        </div>


    </div>
@stop
