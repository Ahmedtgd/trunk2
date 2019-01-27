<style type="text/css">
  .vm{
    vertical-align:middle !important ;
  }
  .hide{
    display: none;
  }
  #addRows td{
    padding-top: 5px;
  }
</style>

<div class="row">
    <br>
    <div class="col-md-12" style="display:flex;align-items:flex-end">
        <div class="col-md-6" style="padding-left:0;padding-right:0; font-size: small">
            <h5><strong>Order ID: </strong>{{$nporder_id}}</h5>
        </div>

        <div class="col-md-6 text-right"
             style="padding-left:0;margin-bottom:6px;padding-right:0px">
                    <span class="text-right" style=""><Strong>Sales Order No&nbsp;&nbsp;</strong>
                    :
                        <?php if($merchant) {
                            echo sprintf('%010d', $sales_order->salesorder_no);
                        } ?>
                    </span>
                </tr>

            </table>
        </div>
    </div>
</div>
<input type="hidden" name="selectedDmember" id="selectedDmember" value="{{$DmanID}}">     
<table class="table" id="addRows" style="margin-bottom: 0px;">
    <thead>
    <tr style="border-bottom:1px solid #ddd;background:black;color:white;">
        <th class="text-center">No</th>
        <th class="text-center">Product&nbsp;ID</th>
        <th class="text-left">Description</th>
        <th class="text-right">Price&nbsp;({{$currentCurrency}})</th>
        <th class="text-center">Qty</th>
        <th class="text-center"></th>
        <th class="text-center">Warranty</th>
    </tr>
    </thead>
    <tbody>
    <?php $t = 1;  $index = 1;$totalc=0;?>
    @foreach($invoice as $key => $invoice)
        <?php $price = $invoice->order_price;
        $p_price = $price/100;
        $totalc  += $invoice->quantity*$p_price;
        ?>
        <input type="hidden" name="products[]" value="{{$invoice->prid}}">
        <input type="hidden" name="orderproductId[]" value="{{$invoice->orderproductId}}">

        <tr style="vertical-align:middle" >
            <td style="width: 5%;" class="text-center vm">{{$index++}}</td>
            <td style="width: 15%;" class="text-center vm">{{$invoice->nproduct_id}}</td>
            <td id="name{{$invoice->prid}}" style="width: 60%;" class="text-left vm">
                @if(File::exists(URL::to("images/product/$invoice->prid/thumb/$invoice->thumb_photo")))
                    <img width="30" height="30" src="{{URL::to("images/product/$invoice->prid/thumb/$invoice->thumb_photo")}}">
                @elseif(File::exists(URL::to("images/product/$invoice->parent_id/thumb/$invoice->thumb_photo")))
                    <img width="30" height="30" src="{{URL::to("images/product/$invoice->parent_id/thumb/$invoice->thumb_photo")}}">
                @endif
                {{($invoice->name)}}
            </td>
            <?php

            // if(is_null($invoice->approved_qty))
             $disabled = "";
            if(is_null($invoice->approved_qty)){
                $qty = $invoice->quantity;
                
              }else{
                $qty = $invoice->approved_qty;
                $disabled = 'disabled';
               
            }
            ?>
            <td id="price{{$invoice->prid}}" style="width: 5%;" class="text-right vm">{{number_format($invoice->order_price/100,2)}}</td>

            <td style="width: 7%;" class="text-right vm">

                <input disabled id="qty{{$invoice->prid}}"
                       onchange="qtychange('{{$invoice->prid}}');"onblur="approve('{{$invoice->prid}}', '{{$id}}',
                        '{{$invoice->parent_id}}','{{$qty}}')"
                       class="form-control" style="width: 70px; text-align: center" value="{{$qty}}"/>

            </td>

            <?php

              // $disabled = "";
              // $class = "";
              // if($invoice->approved_qty !=  0){
              //   $disabled = 'disabled';
              //   $class = 'display:none';
              // }
            ?>
             <td  style="width: 10%;" class="vm text-center" >
                 @if(is_null($direct))
                 <label style="{{--$class--}}" class="text-center"><input id="checked{{$invoice->prid}}" onchange="check({{$invoice->prid}})"
                                                                          width="60px;" type="checkbox" value=""></label></td>

            @else

            @endif
           
            @if($invoice->has_serialno !=0 || $invoice->ptype == 'warranty')

            <td class="text-center">
			         <span class="vm" onclick="hide_show('<?php echo $invoice->prid; ?>')" type="button" {{$disabled}} name="openTextbox"> 

             <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTcuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDIxMy41NjMgMjEzLjU2MyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjEzLjU2MyAyMTMuNTYzOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CjxwYXRoIGQ9Ik0xMDYuNzgyLDIxMy41NjNjLTAuNzc0LDAtMS41NDktMC4xOC0yLjI1OS0wLjUzOWMtMS43NjctMC44OTYtNDMuNTIxLTIyLjMzNC02NS4yNzgtNTguNTk1ICBjLTIxLjU4My0zNS45NzEtMjUuNjA0LTcxLjQyOC0yNS43NjUtNzIuOTJjLTAuMjQ1LTIuMjcxLDEuMDgyLTQuNDIxLDMuMjIzLTUuMjJjMC4xMzQtMC4wNTEsMTUuMDE0LTUuODY5LDE1LjAxNC0xOC40ODkgIGMwLTEuOTM1LTAuMjk0LTQuNDQzLTEuNjkzLTUuNDA2Yy0xLjk5Ny0xLjM3NS02LjQxNy0wLjQwMy04LjEyNywwLjI1M2MtMS41MzcsMC41ODgtMy4yNzYsMC4zODYtNC42MzItMC41NDYgIGMtMS4zNTYtMC45MzQtMi4xNzctMi40Ny0yLjE3Ny00LjExNVYxNy43MjRjMC0xLjY5MywwLjg1Ny0zLjI3MSwyLjI3Ny00LjE5M2MxLjQyMS0wLjkyNCwzLjIxLTEuMDYzLDQuNzU3LTAuMzc0ICBjMS44OTEsMC44MjIsNi42MjIsMi4wNDgsOS4wMzksMC41MjVjMi4yNS0xLjQxMiwyLjQ3Ni02LjAzNywyLjIzMi04LjA1NmMtMC4xNzEtMS40MiwwLjI3Mi0yLjg1OSwxLjIyMS0zLjkzICBDMzUuNTYyLDAuNjI2LDM2LjkyMiwwLDM4LjM1MiwwaDEzNi44NThjMS40NCwwLDIuODEsMC42MjEsMy43NTksMS43MDNjMC45NDksMS4wODIsMS4zODYsMi41MjEsMS4xOTgsMy45NDkgIGMtMC4yNCwxLjk5Mi0wLjAxNSw2LjYxNywyLjIzNCw4LjAyOWMyLjQyLDEuNTIsNy4xNDgsMC4yOTYsOS4wNi0wLjUzNGMxLjU0Ni0wLjY3MiwzLjMzNi0wLjUyNSw0Ljc0NSwwLjQgIGMxLjQwOSwwLjkyNCwyLjI2OSwyLjQ5LDIuMjY5LDQuMTc2djMwLjI2MmMwLDEuNjU0LTAuODE4LDMuMjAxLTIuMTg1LDQuMTMzYy0xLjM2NiwwLjkzMS0zLjEwNSwxLjEyNy00LjY0NiwwLjUyICBjLTEuNjg5LTAuNjQ2LTYuMTEtMS42MTgtOC4xMDYtMC4yNDVjLTEuMzk5LDAuOTYzLTEuNjkzLDMuNDczLTEuNjkzLDUuNDA3YzAsMTIuNjIsMTQuODc5LDE4LjQzOCwxNS4wMywxOC40OTUgIGMyLjEyMywwLjgxLDMuNDUsMi45NTUsMy4yMDcsNS4yMTRjLTAuMTYxLDEuNDkyLTQuMTgyLDM2Ljk0OS0yNS43NjUsNzIuOTJjLTIxLjc1NiwzNi4yNjEtNjMuNTExLDU3LjY5OS02NS4yNzcsNTguNTk1ICBDMTA4LjMzMSwyMTMuMzgzLDEwNy41NTYsMjEzLjU2MywxMDYuNzgyLDIxMy41NjN6IE0yMy45MjYsODMuOTI3YzEuNTY0LDkuNjIxLDcuMjcxLDM3LjY1MywyMy44OTQsNjUuMzU3ICBjMTcuNDgsMjkuMTMzLDUwLjExMSw0OC42Nyw1OC45NjIsNTMuNTk4YzguODUtNC45MjcsNDEuNDgxLTI0LjQ2NSw1OC45NjEtNTMuNTk4YzE2LjY2Ni0yNy43NzYsMjIuMzQ0LTU1Ljc0NiwyMy44OTctNjUuMzU1ICBjLTYuMTczLTMuMjg0LTE3Ljc5My0xMS40Mi0xNy43OTMtMjYuMTI5YzAtNy44ODYsMy4zMDMtMTEuNzkxLDYuMDc0LTEzLjY3OWMzLjMzNy0yLjI3Myw3LjI2OC0yLjYyOSwxMC41NTYtMi4zNDNWMjQuMjE3ICBjLTMuNDgsMC40NTMtNy43LDAuMjUyLTExLjM5Mi0yLjA2NmMtNC44MTEtMy4wMjEtNi4zODktOC4xNTEtNi44MzctMTIuMTVINDMuMzE1Yy0wLjQ0OCwzLjk5OS0yLjAyNiw5LjEzLTYuODM3LDEyLjE1ICBjLTMuNjkxLDIuMzE4LTcuOTEyLDIuNTIzLTExLjM5MiwyLjA2NnYxNy41NjJjMy4yODgtMC4yODYsNy4yMTksMC4wNjksMTAuNTU3LDIuMzQzYzIuNzcxLDEuODg4LDYuMDc0LDUuNzkzLDYuMDc0LDEzLjY3OSAgQzQxLjcxNyw3Mi41MDcsMzAuMSw4MC42NDIsMjMuOTI2LDgzLjkyN3ogTTU3LjYxOCwxNDUuMDY0Yy0zLjMzOSwwLTYuNDc4LTEuMy04LjgzOS0zLjY2MWMtMi4zNjEtMi4zNi0zLjY2MS01LjQ5OS0zLjY2MS04LjgzOCAgYzAtMy4zNCwxLjMtNi40NzksMy42NjItOC44NGwxNy4wMjktMTcuMDI4bC02LjcxNS02LjcxNmMtMS45NTMtMS45NTItMS45NTMtNS4xMTgsMC03LjA3YzEuOTUzLTEuOTUzLDUuMTE4LTEuOTUzLDcuMDcxLDAgIGw1LjU2Niw1LjU2NWwxNS4wNTEtMTUuMDUxTDcwLjgwOCw2Ny40NTJjLTguNDc1LTguNDc2LTE1LjIyMi0xOC4zMzQtMjAuMDU0LTI5LjNsLTMuMjYtNy4zOThjLTAuODMyLTEuODg4LTAuNDE4LTQuMDkzLDEuMDQtNS41NTEgIGMxLjQ1OC0xLjQ2LDMuNjYxLTEuODc0LDUuNTUyLTEuMDRsNy4zOTgsMy4yNmMxMC45NjcsNC44MzIsMjAuODI1LDExLjU3OSwyOS4yOTksMjAuMDU0bDE1Ljk3NCwxNS45NzRsMTUuOTc0LTE1Ljk3NCAgYzguNDc0LTguNDc1LDE4LjMzMi0xNS4yMjIsMjkuMjk5LTIwLjA1NGwwLDBsNy4zOTgtMy4yNmMxLjg4OS0wLjgzMiw0LjA5My0wLjQxOSw1LjU1MiwxLjA0YzEuNDU4LDEuNDU4LDEuODcyLDMuNjYzLDEuMDQsNS41NTEgIGwtMy4yNiw3LjM5OGMtNC44MzMsMTAuOTY5LTExLjU4LDIwLjgyNi0yMC4wNTQsMjkuM2wtMTUuOTczLDE1Ljk3NEwxNDEuOTA2LDk4LjZsNS42ODgtNS42ODhjMS45NTMtMS45NTMsNS4xMTgtMS45NTMsNy4wNzEsMCAgYzEuOTUzLDEuOTUyLDEuOTUzLDUuMTE4LDAsNy4wN2wtNi43MTUsNi43MTZsMTcuMDMsMTcuMDI5YzIuMzYxLDIuMzYsMy42NjEsNS40OTksMy42NjEsOC44MzljMCwzLjMzOS0xLjMsNi40NzgtMy42NjIsOC44MzkgIGMtNC44NzQsNC44NzMtMTIuODAzLDQuODczLTE3LjY3NywwbC0xNy4wMy0xNy4wM2wtNi43MTUsNi43MTVjLTEuOTUzLDEuOTUzLTUuMTE4LDEuOTUzLTcuMDcxLDBjLTEuOTUzLTEuOTUyLTEuOTUzLTUuMTE4LDAtNy4wNyAgbDUuNDQzLTUuNDQzbC0xNS4xNzMtMTUuMTc0bC0xNS4wNTEsMTUuMDUxbDUuNTY2LDUuNTY2YzEuOTUzLDEuOTUyLDEuOTUzLDUuMTE4LDAsNy4wN2MtMS45NTMsMS45NTMtNS4xMTgsMS45NTMtNy4wNzEsMCAgbC02LjcxNS02LjcxNWwtMTcuMDMsMTcuMDI5QzY0LjA5NiwxNDMuNzY1LDYwLjk1NywxNDUuMDY0LDU3LjYxOCwxNDUuMDY0eiBNNzIuODgsMTEzLjc2OWwtMTcuMDI5LDE3LjAyOCAgYy0wLjYzNywwLjYzOC0wLjczMiwxLjM4Mi0wLjczMiwxLjc2OWMwLDAuMzg2LDAuMDk1LDEuMTMsMC43MzIsMS43NjdjMC45NzYsMC45NzcsMi41NjEsMC45NzYsMy41MzYsMC4wMDFsMCwwbDE3LjAyOS0xNy4wMjkgIEw3Mi44OCwxMTMuNzY5eiBNMTM3LjM0NSwxMTcuMzA0bDE3LjAyOSwxNy4wMjljMC45NzUsMC45NzUsMi41NjEsMC45NzUsMy41MzUsMGMwLjYzNy0wLjYzOCwwLjczMi0xLjM4MiwwLjczMi0xLjc2OCAgYzAtMC4zODctMC4wOTUtMS4xMzEtMC43MzItMS43NjhjMCwwLDAsMCwwLTAuMDAxbC0xNy4wMjktMTcuMDI4TDEzNy4zNDUsMTE3LjMwNHogTTgyLjY5NSwxMDkuNDQxbDEuOTQsMS45MzlMOTkuNjg2LDk2LjMzICBsLTUuODM0LTUuODMzbC0xNS4wNSwxNS4wNTFMODIuNjk1LDEwOS40NDF6IE0xMTEuMjE1LDkzLjcxOGwxNy42NjQsMTcuNjYzbDUuODMzLTUuODMzbC01MS01MS4wMDEgIGMtNi4zNjgtNi4zNjgtMTMuNjA3LTExLjY0Ny0yMS41NzQtMTUuNzRjNC4wOTIsNy45NjYsOS4zNzMsMTUuMjA2LDE1Ljc0MSwyMS41NzVsMTguNTgzLDE4LjU4MyAgYzAuMzc1LDAuMjE1LDAuNzI4LDAuNDgzLDEuMDQ4LDAuODA0bDEyLjkwNSwxMi45MDRDMTEwLjczLDkyLjk4NiwxMTAuOTk4LDkzLjMzOSwxMTEuMjE1LDkzLjcxOHogTTExMy45NTEsNzAuMzk4bDUuODM0LDUuODM0ICBsMTUuODUxLTE1Ljg1MmM2LjM2OC02LjM2OCwxMS42NDgtMTMuNjA2LDE1Ljc0MS0yMS41NzRjLTcuOTY3LDQuMDkzLTE1LjIwNiw5LjM3Mi0yMS41NzQsMTUuNzRMMTEzLjk1MSw3MC4zOTh6IiBmaWxsPSIjMDAwMDAwIi8+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" /></span>
             <!--  <input class="btn btn-success" onclick="$('#tableTextbox_'+'<?php echo $invoice->nproduct_id ;?>').toggleClass('hide');" type="button" {{$disabled}} name="openTextbox" value="button"> -->
            </td>

            
        </tr>
        <?php
                 $disabled = "";
                 $disable = "";
                if($invoice->has_serialno == 0){
                    $disable = "disabled";
                 }else if($invoice->ptype != 'warranty'){
                    $disabled = "disabled";
                 }
                // $qty = $invoice->quantity;
                // echo $invoice->approved_qty."_Approved ";
                // echo $invoice->quantity."_Qty ";
                // if($invoice->approved_qty != 0){
                   // $disabled = 'disabled';
                  // $qty = $invoice->approved_qty;
                   // echo $invoice->quantity."_Approved_Qty ";
                //}
            ?>
          <tr class="tableTextbox_<?php echo $invoice->prid;?>">
          <td colspan="7">
            <table id="newadd">

        <?php
         $imeidetail = $ImeiWArranty[$invoice->prid];
          for ($i=0; $i < $qty; $i++) {
           if($i < $qty){
               $t++;
                }
                // foreach ($ImeiWArranty as $ImeiWArrantykey => $ImeiWArrantyvalue) {
                  $imei = '';
                  $warrantyNo = '';
                  if(count($imeidetail) > 0 ){                 
                    $imei = isset($imeidetail['imeiDetail'][$i]['imeiNo']) ? $imeidetail['imeiDetail'][$i]['imeiNo'] : '';
                    $warrantyNo = isset($imeidetail['imeiDetail'][$i]['warrantyNo'])?$imeidetail['imeiDetail'][$i]['warrantyNo'] : '';
                  }
        ?>
        
          <tr id="existingRow_<?php echo $i; ?>" style="margin-bottom: 10px;">
           <input type="hidden" class="OriginalQty_{{$invoice->prid}}"   name="OriginalQty_{{$invoice->prid}}" value="<?php echo $qty;?>">
            <td colspan="2" style="width:270px !important;padding-right:10px;">
                <p style="display: none;" id="serial_check{{$t}}"> 0</p>
               <input type="textbox" {{$disable}} onblur="check_serial_no('{{$t}}','{{$invoice->parent_id}}')"  tabindex={{$t}}  id="imei_{{$invoice->prid."_".$i}}_{{$index}}" class="form-control" name="imeinumber_{{$invoice->prid}}[]" placeholder="Serial/IMEI Number" value="{{$imei}}">
            </td>
               <?php $t++; ?>
            <td>
                <p style="display: none;" id="serial_check{{$t}}"> 0</p>
               <input tabindex={{$t}} {{$disabled}} type="textbox" onblur="check_warranty_no('{{$t}}','{{$invoice->parent_id}}')" id="warr_{{$invoice->prid."_".$i}}" style="width: 260px !important;" class="form-control" name="warranty_{{$invoice->prid}}[]" placeholder="Warranty Number" value="{{$warrantyNo}}">
            </td>

          </tr> 
        <?php
          
          }
        ?>    
            </table>
          </td>
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
    <!--tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"
            style="text-align:right;font-weight:bold;font-size:17px">
            Total&nbsp;</td>
    </tr-->
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('input').on("keypress", function(e) {
            if (e.which == 13) {
                console.log("clicked" + parseInt($(this).attr("tabindex")));
                         var t = parseInt($(this).attr("tabindex"));
                        var tab = t + 1;
                        console.log("Go to input no" + tab);
            //    if($("#yes_btn_href").is(":disabled")){
              //      toastr.error('Update Used Barcode to proceed');
              //  }else{
                    $('input[tabindex="' + tab + '"]').focus();
                    e.preventDefault();
              //  }

            }
        });

    });

    function check_serial_no(t,p_id){
        var serial_box = $('input[tabindex="' + t + '"]');
        var serial_no = serial_box.val();
        if(serial_no.length > 0){
            var confirm_button = $('#yes_btn_href');
            console.log("Serial No "+serial_no + "Product ID "+p_id);
            if($("#yes_btn_href").is(":disabled") && serial_box.css('background-color')=="rgb(255,255,255)"){
                toastr.error('Update Used Barcode to proceed');
            }else{
                $.ajax({
                    type: "POST",
                    url: JS_BASE_URL + "/serial_no_check",
                    data: {"product_id": p_id, "serial_no": serial_no},
                    success: function (data) {
                        var red = false;
                        var red_value = '';
                        if(data == 1){
                            toastr.error('This Barcode does not exist in the System');
                            serial_box.css({"background-color":"red"});
                            $('#serial_check'+t).text('1');
                            confirm_button.prop("disabled", true);
                        }else if(data == 2){
                            toastr.error('This Barcode has been Used');
                            serial_box.css({"background-color":"red"});
                            $('#serial_check'+t).text('1');
                            confirm_button.prop("disabled", true);
                            }else{
                            console.log("Start for loop");
                            for (var i = (t -1); i > 0;) {

                                console.log("i" +i);
                                console.log("T" +t);
                                console.log("Solution" + (t - 1));
                                console.log("Serial Val"+ $('#serial_check'+i).text());
                                if (($('#serial_check'+i).text()!= 0))   {
                                    red = true;
                                    red_value = $('input[tabindex="' + i + '"]').val();
                                    console.log("Red" +red + " T" + t);
                                }else if(serial_no == $('input[tabindex="' + i + '"]').val() ){
                                    red = true;
                                    red_value = $('input[tabindex="' + i + '"]').val();
                                    serial_box.css({"background-color":"red"});
                                    $('#serial_check'+t).text('1');
                                    console.log("Red" +red + " T" + t);
                                }
                                i--;
                            }
                            if (red == false) {
                                serial_box.css({"background-color": "white"});
                                confirm_button.prop("disabled", false);
                                $('#serial_check'+t).text('0');
                            } else {
                                confirm_button.prop("disabled", true);
                                toastr.error('Update Used Barcode to proceed');
                            }
                        }
                    }
                });
            }
        }


    }
    function check_warranty_no(t,p_id) {
        var warranty_box = $('input[tabindex="' + t + '"]');
        var warranty = warranty_box.val();
        if(warranty.length > 0){
            var confirm_button = $('#yes_btn_href');
            if ($("#yes_btn_href").is(":disabled") && warranty_box.css('background-color') == "rgb(255,255,255)") {
                toastr.error('Update Used Barcode to proceed');
            } else {
                $.ajax({
                    type: "POST",
                    url: JS_BASE_URL + "/warranty_check",
                    data: {"product_id": p_id, "warranty": warranty},
                    success: function (data) {
                        var red = false;
                        var red_value;
                        if(data == 1){
                            toastr.error('This Barcode does not exist in the System');
                            warranty_box.css({"background-color":"red"});
                            $('#serial_check'+t).text('1');
                            confirm_button.prop("disabled", true);
                        }else if(data == 2){
                            toastr.error('This Barcode has been Used');
                            warranty_box.css({"background-color":"red"});
                            $('#serial_check'+t).text('1');
                            confirm_button.prop("disabled", true);
                        }else{
                            console.log("Start for loop");
                            for (var i = t -1; i > 0;) {
                                console.log("i" +i);
                                console.log("T" +t);
                                console.log("Solution" + (t - 1));
                                console.log("Serial Val"+ $('#serial_check'+i).text());
                                if(($('#serial_check'+i).text() != 0)){
                                    red = true;
                                    red_value = $('input[tabindex="' + i + '"]').val();
                                    console.log("Red" +red_value + " T" + t);
                                }else if(warranty == $('input[tabindex="' + i + '"]').val() ){
                                    red = true;
                                    red_value = $('input[tabindex="' + i + '"]').val();
                                    console.log("Red" +red + " T" + t);
                                    warranty_box.css({"background-color":"red"});
                                    $('#serial_check'+t).text('1');
                                }
                                i--;
                            }
                            if(red == false){
                                warranty_box.css({"background-color":"white"});
                                $('#serial_check'+t).text('0');
                                confirm_button.prop("disabled", false);
                            }else{
                                confirm_button.prop("disabled", true);
                                toastr.error('Update Error Barcode to proceed');
                            }
                        }
                    }
                });
            }
        }

    }
    function check(id) {
       //If check box is clicked, make sure you make qty active
       var checkbox = $('#checked'+id);
       var qtybox = $('#qty'+id);
        console.log("Checked "+qtybox);
        if (checkbox.is(":checked")) {
            qtybox.prop("disabled", false);
            qtybox.css({"background-color":"white"});
        }else{
            qtybox.prop("disabled", true);
        }

    }


    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function approve(p_id, id, p_parent_id, i_qty) {
      //console.log(i_qty);
        var qtybox = $('#qty'+p_id);
        var qty = qtybox.val();
        var checkbox = $('#checked'+p_id);
        $.ajax({
            type: "POST",
            url: JS_BASE_URL+"/seller/gator/price_check",
            data:{"prod_id" : p_id, "id" : id, "qty" : qty},
            success: function( data ) {
                console.log(data);
                var ul_list = $('.diff_msg');
               if(data.response == "Zero"){
                   toastr.error('There was an error, Contact Admin');
               }else if(data.response == "One") {
                   //if response if one, the new qty is larger than the SO qty
                   console.log(data);
                   qtybox.prop("disabled", true);
                   qtybox.css({"background-color": "red"});
                   qtybox.val(i_qty);
                   checkbox.prop('checked', false);
                   toastr.error('Number is Larger than initial Order');
//               }else if(i_qty == data.quantity ){
//
//                   var prod_name = $('#name'+p_id).html();
//                   var msg = '<li class="text-left">No change in quantity for ' +prod_name + '</li>';
                  // ul_list.append(msg);
               }else if(data.response == "Two"){
                  //if the response is two then there is a change is qty that's lower
                   if(i_qty != data.quantity){
                       console.log("Invoice");
                       if(data.invoiceNo == undefined){
                           data.invoiceNo = '';
                       }
                    $('#footerDetails').show();
                    $('#InvoiceNo').html(data.invoiceNo);
                    $('#doid').html(data.deliveryId);
                    
                     //We check and add message to ul
                     //  var ul_list = $('.diff_msg');

                       var dif = i_qty - data.quantity;
                       console.log("The difference is" + dif);
                       var units = ' unit';
                       if(dif > 1){
                        units = ' units';
                       }
                       var prod_name = $('#name'+p_id).html();
                        var msg = '<li class="text-left">' +prod_name + ' has been approved with a difference of '+ dif + units+'</li>';
                       ul_list.append(msg);
                       console.log('===============QTY');
                       console.log(data.quantity);
                       console.log('QTY===============');
                       qtybox.val(data.quantity);
                       qtybox.prop("disabled", true);
                       checkbox.prop('checked', false);
                       toastr.success('Quantity Successfully Updated');

                   }
                   $.ajax({
                       type:"POST",
                       url: JS_BASE_URL+"/seller/gator/qty_check",
                       data:{ "id" : p_parent_id, "qty" : qty},
                       success: function (data){
                           console.log("Data");
                           console.log(data);
                           $('#price'+p_id).text((data.price/100).toFixed(2))

                       }
                   });
               }

            }
        });

    }

	function hide_show(id) {
		$(".tableTextbox_"+id).toggle();
		console.log('***** hide_show('+id+') *****');
    } 

    function qtychange(id) {
      var Updated_Qty = parseInt($('#qty'+id).val());
      var Existing_qty = parseInt($('.OriginalQty_'+id).val());
      console.log('Updated_Qty ='+Updated_Qty);
      console.log('Existing_qty='+Existing_qty);

      var tableHtml = '';
      var RealQty = '';

      // if(Updated_Qty > Existing_qty){
		var sel  = '.tableTextbox_'+id+' > td > table#newadd';
		var sel2 = '.tableTextbox_'+id+' > td > table#newadd > tbody';

		/* Clear off old rows first! */
		//$(sel2).remove();

		// RealQty = Updated_Qty - Existing_qty;
    RealQty = Updated_Qty;
		console.log('RealQty='+RealQty);

		// $('.OriginalQty_'+id).val(Updated_Qty);
		console.log('============if');
if(Existing_qty >= Updated_Qty)
{
    $(sel2).remove();
		for (var i=0; i < Updated_Qty; i++) { 
          tableHtml += '<tr id="existingRow_'+i+'" style="margin-bottom: 10px">';

          // tableHtml += ' <input type="hidden" class="OriginalQty_'+id+'" name="OriginalQty_'+id+'" value="'+Updated_Qty+'">';
          tableHtml += ' <input type="hidden" class="OriginalQty_'+id+'" name="OriginalQty_'+id+'" value="'+Existing_qty+'">';

          tableHtml += '<td colspan="2" style="Width:270px !important;padding-right:10px;">';

          tableHtml += '<input type="textbox" class="form-control addrrow_'+id+'" name="imeinumber_'+id+'[]" placeholder="Serial/IMEI Number">';

          //tableHtml += '<input type="textbox" class="form-control addrrow_'+id+'" name="" placeholder="IMEI No.">';
          tableHtml += '</td>';
          tableHtml += '<td>';
          tableHtml += '<input type="textbox" style="width: 260px !important;" class="form-control" name="warranty_'+id+'[]" placeholder="Warranty Number">';
          // tableHtml += '<input type="textbox" style="width: 260px !important;" class="form-control" name="" placeholder="Warranty No.">';
          tableHtml += '</td>';
          tableHtml += '</tr>';
        }
        $(sel).append(tableHtml);

      }
       // else {
        // RealQty = Existing_qty - Updated_Qty;
         // RealQty = Updated_Qty;
        // $('.OriginalQty_'+id).val(Updated_Qty);

        //alert('RealQty_else_'+RealQty);
        // console.log('RealQty='+RealQty);
        // console.log('============Else');
        // console.log('id='+id);

   //      for (var i=0; i < RealQty; i++) {
			// var sel = '.tableTextbox_'+id+' > td > table#newadd > tbody > tr#existingRow_'+i;
   //        console.log(sel);
   //         $(sel).remove();
   //      }
   //    }
	//$('#addRows tbody').append('<tr class="child"><td>blahblah</td></tr>');
      console.log(tableHtml);
    }
</script>
