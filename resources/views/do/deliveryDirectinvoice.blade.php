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
            @include('seller.gator.directinvoice')

            <div class="" style="text-align: left;">
                <div class="col-md-12" id="footerDetailsForInvoice"
				style="display:none;padding-left: 0px;margin-bottom:20px">
                     <table style="margin-top: 5px;">
                        <tr id="salesorderView" style="display: none;">
                            <td style="text-align: left">
                                <strong>Sales Order No.</strong>
                            </td>
                            <td>: <span id="salesorderid"></span></td>
                        </tr>
                        <tr>
                            <td style="text-align: left"><strong>Delivery Order ID</strong></td>
                            <td>: <span id="InvoiceNoDI"></span></td>
                        </tr>
                        <tr>
                            <td style="text-align: left"><strong>DeliveryMan Name</strong></td>
                            <td>: <span id="dmanName"></span></td>
                        </tr>
                        <tr>
                            <td style="text-align: left"><strong>DeliveryMan ID </strong></td>
                            <td>: <span id="dmanID"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12" id="ImeiWarranty"style="padding-left:0px;">
                </div>
                <ul id="Qtydifferent_message" style="margin-left: -25px;">
                </ul>
            </div>
        
        </div>

        <div id="stack2" style="z-index: 99999;" class="modal fade"  style="display: none;">
            <div style="width: 90%;"  class="modal-dialog">
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
                            <button style="float: right; border-color: #09c6e7;border-radius: 7px;
                            width: 70px; height: 70px;
                             color: white; margin-right: 0px !important; " type="button" id="previewso" class=" skyblue sellerbutton" >Purchase</button>
                            <!--div style="background-color:green;float: right;color: white;padding-top: 17px;" type="button" id="newbuyerbtn" class="sellerbutton" data-toggle="newbuyer" data-target="#newbuyer">New<br>Merchant</div>

                            <div style="float: right;color: white;padding-top:28px"
                                 type="button"
                                 id="stationbtn" class="bg-black sellerbutton"
                                 onclick="gatorBuyer()">Merchant</div-->

                            <h2 style=" width: 40%;float: left; padding-top: 5px;">
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
        </div></div>

    <script type="text/javascript">

        $(document).ready(function(){
            getfooterdetails('<?php echo $OrderId; ?>',"di");
        });

        function getfooterdetails(id,type=null) {
            // alert('in');
            $('#Qtydifferent_message').html('');
            $('#salesorderid').html('');
            $("#salesorderView").attr("style", "display: none;");
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/seller/Sofooterdetails/"+id,
                success: function( data ) {
                    console.log('====SoFooter====');
                    console.log(data);
                    console.log('====SoFooter====');
                    console.log(data.ProductData);


                    if(data.deliveryId != ""){

                        if(type="di")
                        {
                            $('#footerDetailsForInvoice').show();

                            if(data.direct == 0){
                                $('#salesorderView').removeAttr('style');
                                $('#salesorderid').html(data.salesorder_no);
                            }
                            $('#dmanName').html(data.dman_name);
                            $('#dmanID').html(data.dman_id);
                            var url = JS_BASE_URL+"/DO/displaydeliveryorderdocument/"+id;
                            $('#InvoiceNoDI').html('<a href="'+url+'" target="_blank">'+data.deliveryId+'</a>');
                        }

                        $('#footerDetails').show();
                        //$('#InvoiceNo').html(': '+data.doid);
                        $('#InvoiceNo').html(data.invoiceNo);

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

                                // console.log('========ProductData========');
                                // if((data.ProductData[key].imeiNo != "" && data.ProductData[key].imeiNo != null )&&( data.ProductData[key].warrantyNo != "" && data.ProductData[key].warrantyNo != null)){
                                var mainQty = datavalue.quantity;

                                if(datavalue.approved_qty > 0){
                                    $('#doid').html('<a href="#" onclick="deliveryorder('+id+')">'+data.deliveryId+'</a>');

                                    mainQty = datavalue.approved_qty;


                                    var ul_list = $('#Qtydifferent_message');

                                    var dif = datavalue.quantity - datavalue.approved_qty;

                                    var units = ' unit';
                                    if((dif > 0) && (datavalue.approved_qty != null)){

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

                            console.log("Got Here");
                            $('#ImeiWarranty').html(HtmlTableImei);
                            $('#ImeiWarrant').html(HtmlTableImei);
                        }

                        $('#dmanid_'+data.dman_id).prop("checked",true);
                    }

                }
            });
        }

    </script>


@stop

