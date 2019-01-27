<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')
@include("common.sellermenu")
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
    #time{
		position:relative;
		top:-35px;
        font-size:20px;
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

                        <div class="col-md-4 text-right" style="padding-left:0;padding-right:0">
                            <div class="">
                                <div class="col-md-12" style="">

                                    <button style="padding-top:8px;background-color:skyblue;
					font-size:13px;width:70px;height:70px;margin-bottom:5px;
					color: white; border-radius:10px;margin-right:5px;
					padding-left:5px"
                                            id="submitform" type="button" onclick="genPDF()"
                                            class="btn controlbtn" wfd-id="1618">
                                        Download</button>

                                    <div style="width: 70px; height: 70px; float: right;"
                                         class="qrcode"></div>

                                </div>
                            </div>
                            {{--@if(count($dostatus) > 0 && $dostatus->status != "inprogress")--}}
                                @if(!empty($dostatus) && $dostatus->status != "inprogress")
                            @if($status != "cancelled")
                            <div class="" style="margin-top: 5px;">
                                <div class="col-md-12" style="">
                                    <button style="padding-top:8px;background-color: red;
                                    font-size:13px;width:70px;height:70px;
                                    color: white;border-radius:10px;margin-right:0"
                                    id="cancelbtn"
                                    type="button" class="btn controlbtn"
                                    onclick="showModal()"
                                    wfd-id="1618">
                                    Cancel</button>
                                </div>
                            </div>
                            @endif
                            @endif
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
                            @if(isset($heading))
                                <p style="font-size:25px;margin-bottom:0">
                                    <strong>{{$heading}}</strong></p>
                            @else
                                <p style="font-size:25px;margin-bottom:0">
                                    <strong>Sales Order</strong></p>
                            @endif
                        </div>

                        <div class="col-md-4"
                             style="padding-left:0;padding-right:30px;margin-bottom:6px">
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
                                    <td style=""><Strong>Sales Order No&nbsp;&nbsp;</strong></td>
                                    <td>:
                                        <?php if($merchant) {
                                            echo sprintf('%010d', $merchant->salesorder_no);
                                        } ?>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div  style="align-self:flex-end">

                <table class="table" style="margin-bottom: 0px;">
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
                    @foreach($invoice as $invoice)
                        <?php $price = $invoice->order_price;
                        $p_price = $price/100;
                        $totalc  += $invoice->quantity*$p_price;
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
                            <td style="width: 5%;" class="text-center">{{$invoice->quantity}}</td>
                            <td style="width: 10%;" style="width: 13%;" class="text-right">{{number_format($invoice->order_price/100,2)}}</td>
                            <td style="width: 10%;" class="text-right">{{number_format($invoice->order_price/100*$invoice->quantity,2)}}</td>
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
						style="text-align: right; font-weight: bold; font-size:17px">
                            Total {{$currency}}&nbsp;{{$total}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <div id="content">
            <hr style="margin: 0px;">
            <p class="pull-right"
               style="padding-right:10px;padding-top:2px;font-size:10.5px">
                Goldfish Oranda V1.0</p>

            {{--<div style="text-align: right; padding-right: 8px;">--}}
            {{--Total include 6% GST &nbsp&nbsp {{$currentCurrency}}&nbsp{{$gst}}<br><span>Item Total &nbsp&nbsp {{$currentCurrency}}&nbsp{{$itmtotalprice}}</span>--}}
            {{--</div>--}}
<hr>            @if(!is_null($merchant->invoice_no))
                <p class="pull-left" style=""><Strong>Invoice No&nbsp;&nbsp;</strong>
               :<a href="{{url('merchantinvoice/'.$merchant->pid)}}" target="_blank">{{sprintf('%010d', $merchant->invoice_no)}}</a></p>
        @endif
            </div>
        <!-- Modal -->
        <div id="confirmationModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header"></div>
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

        <p id = "salerOrderId" style="display: none;">{{$id}}</p>
        <p id ="order_status" style="display: none;">{{$status}}</p>
        <script type="text/javascript" src="<?php echo e(asset('js/qr.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.js')); ?>"></script>
        <script type="text/javascript">
            function showModal(){
                  $('#confirmationModal').modal('show');
            }
            function deleteRecord(id) {
                // var url = window.location.href;
                // console.log(url);
                $.ajax({
                    type: "POST",
                    url: JS_BASE_URL+"/gator/deleteRow",
                    data:{"id":id},
                    success: function(data){
                        $('#confirmationModal').modal('hide');
                        $('#cancelstamp').css('display','block');
                        //$('#soModal').modal('hide');
                        $('#downloadbtn').hide();
                        $('#cancelbtn').hide();
                        toastr.success('Order has been Successfully Cancelled');
                    }
                });
            }
            function close_modal(){
                $('#confirmationModal').modal('hide');
            }

            function genPDF() {
                $( "#download" ).css({"margin-top": "30px"});
                var elements = document.getElementById('download');
                $("#submitform").hide();
                html2pdf(elements);
                $("#submitform").show();
                $( "#download" ).css({"margin-top": "0px"});
            }
            function hide(element) {  element.css("display","none"); }
            $(document).ready(function(){


                $('.qrcode').qrcode({height:70,width:70,text: <?php if($merchant) {echo sprintf('%060d', $merchant->salesorder_no);  }else{ echo "00000000000000000";} ?> });

                  var   status =   $('#order_status').html();
               // alert(status);
                if(status == 'cancelled'){
                    $('#cancelstamp').show();
                }else if(status == 'completed'){
                }
            });

        </script>
	</div>
	</div>
	<br>
	<br>
	</div>
	@yield("left_sidebar_scripts")
@stop
