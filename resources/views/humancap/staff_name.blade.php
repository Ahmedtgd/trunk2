<style>
    .head_p{
        background-color: #0066ff;
        color: white;
        width: 100%;
        padding: 4px;
        margin:0;
        display:inline;
    }
    .inside{
        display:inline;
    }
</style>
<style type="text/css">
    .table-sections{padding-top: 20px;padding-bottom: 20px}
    .sellerbutton{
        min-width: 70px;
        min-height: 70px;
        padding-top: 26px;
        text-align: center;
        vertical-align: middle;
        float: left;
        font-size: 13px;
        cursor: pointer;
        margin-right: 5px;
        margin-bottom: 5px;
        border-radius: 5px;
        border: none;
    }
    .bg-primaryii{
        background-color: #02d4f9;
        color: #f6f6f6;
    }
    .bg-primarypurple{
        background-color: #2a75ed;
        color: #f6f6f6;
    }
    .bg-black{
        background-color: rgb(0,0,0);
        color: #f6f6f6;
    }

    .sellerbuttons{
        min-width: 70px;
        min-height: 70px;
        padding-top: 4px;
        text-align: center;
        vertical-align: middle;
        float: left;
        font-size: 13px;
        cursor: pointer;
        margin-right: 5px;
        margin-bottom: 5px;
        border-radius: 5px;
        box-shadow: none;
        /*background-color: #6d9370;*/
        border: 0;
        /*color: #dadada;*/
    }
    .select2-container{
        width: 45px !important;
    }
    .pl-0{padding-left:0px;padding-top: 3px;}
    .pb-20{padding-bottom: 20px !important;}
    .pt-10{padding-top: 10px;}

</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<form id="frmsubmit">
<div class="col-md-12 col-sm-6" style="margin-bottom:10px">
    <p class="head_p" style="margin-left: -12px; padding-right: 255px;">Over Time Rate</p>
</div>
<div class="row col-md-9" style="padding: 4px;">
    <div class="col-md-8">
        <div class="col-md-2 pl-0"><span class="inside">MYR</span></div>
        <div class="col-md-6">
            <input type="text" onfocus="close_ot_error()" value="<?php if($ot_rate) {echo $ot_rate->rate_hr; } ?>" id="myr_ov" name="myr" class="savemyr changeover"> 
        </div>
        <div class="col-md-3">
            <span class="inside" style="text-align: left"><strong>Per Hour</strong> </span>
        </div>
    </div>
</div>
<input type="hidden" id="overtm" name="overtm" value="0">
<input type="hidden" id="parttm" name="parttm" value="0">
<input type="hidden" id="persale" name="persale" value="0">



<div class="row col-md-9 pb-20" style="padding: 4px;">
    <div class="col-md-8">
        <div class="col-md-2 pl-0"><span class="inside">Block</span></div>
        <div class="col-md-6">
            <input type="number" name="myr" onfocus="close_ot_error()"  value="<?php if($ot_rate) {echo $ot_rate->block; } ?>"  id="total_min" class="changeover" max="60" min="0">
        </div>
        <div class="col-md-3">
            <span class="inside" style="text-align: left"><strong>minutes</strong> </span>
        </div>
    </div>
</div>


<!-- <div class="row" style="margin-top: 5px;">
    <div class="col-md-1"><span class="inside">Block</span></div>
    <input type="text" name="myr" onfocus="close_ot_error()"  value="<?php if($ot_rate) {echo $ot_rate->block; } ?>" onblur="validOverTime()"  id="total_min" class="col-md-2 ">
    <div class="col-md-1">
        <span class="inside" style="text-align: left"><strong>minutes</strong> </span>
    </div>
</div> -->
<strong><p style="color: #ff0000; display: none;" id="ot_warning"> Only Numereic Values Accepted</p></strong>
<br><br>

<div class="col-md-12 col-sm-6" style="margin-bottom:10px">
    <p class="head_p" style="margin-left: -12px; padding-right: 261px;">Part Time Rate</p>
</div>
<div class="row col-md-9" style="padding: 4px;">
    <div class="col-md-8">
        <div class="col-md-2 pl-0"><span class="inside">MYR</span></div>
        <div class="col-md-6">
            <input type="text" onfocus="close_pt_error()"  id="myr_pv" value="<?php if($pt_rate) {echo $pt_rate->rate_hr; } ?>"  name="myr" class="savemyr changepart">
        </div>
        <div class="col-md-3">
            <span class="inside" style="text-align: left"><strong>Per Hour</strong> </span>
        </div>
    </div>
</div>
<div class="row col-md-12 pb-20" style="padding: 4px;">
    <div class="col-md-6">
        <div class="col-md-2 pl-0"><span class="inside">Block</span></div>
        <div class="col-md-6">
            <input type="number" onfocus="close_pt_error()"  name="myr" value="<?php if($pt_rate) {echo $pt_rate->block; } ?>" id="total_max" class="changepart" max="60" min="0">
        </div>
        <div class="col-md-3">
            <span class="inside" style="text-align: left"><strong>minutes</strong> </span>
        </div>
    </div>
</div>


<!-- <div class="row" style="padding: 4px;">
    <div class="col-md-1"><span class="inside">MYR</span></div>

    <input type="text" onfocus="close_pt_error()"  id="myr_pv" value="<?php if($pt_rate) {echo $pt_rate->rate_hr; } ?>"  name="myr" class="col-md-2 "> <div class="col-md-2">
        <span class="inside" style="text-align: left"><strong>Per Hour</strong> </span>
    </div>
</div>


<div class="row" style="margin-top: 20px;">
    <div class="col-md-1"><span class="inside">Block</span></div>
    <input type="text" onfocus="close_pt_error()"  name="myr" value="<?php if($pt_rate) {echo $pt_rate->block; } ?>" onblur="validPartTime()" id="total_max" class="col-md-2 "> <div class="col-md-1">
        <span class="inside" style="text-align: left"><strong>minutes</strong> </span>
    </div>

</div> -->
<strong><p style="color: #ff0000; display: none;" id="pt_warning"> Only Numereic Values Accepted</p></strong>

<div class="row col-md-12 ">
    <div class="col-md-12 col-sm-6" style="margin-bottom:10px">
        <p class="head_p" style="margin-left: -12px; padding-right: 195px;">Commission base on Sales</p>
    </div>
    <div class="row col-md-12">
       <!--  <p class="head_p" style="margin-left: -12px; padding-right: 200px;">Commission base on Sales</p> -->
       <div class="col-md-6" style="padding-left:3px">
        <p class="pt-10 ">Personal Commision base on Sales</p>
        </div>
    </div>
    <div class="row col-md-9" style="padding: 4px;">
        <div class="col-md-9" style="padding-bottom: 5px;">
            <div class="col-md-5 pl-0"><span class="inside"> Personal Sales Amount  </span></div>
            <div class="col-md-3">
                <input  onfocus="erase()"  id="personal_sales" type="number" name="" class="personal_sales" style="width:100px" max="100" min="0" value="<?php if(count($commbranches) > 0) {echo $commbranches[0]->commission_pct; } ?>">
            </div>
            <div class="col-md-1" style="padding-left: 25px;">
                <span class="inside" style="text-align: left"><strong>&nbsp;%</strong> </span>
            </div>
        </div>
    </div>
   <!--  <div class="col-md-12">
        Personal Sales Amount
        X
        <input onblur="valid_percent()" onfocus="erase()"  id="personal_sales" type="text" name="" style="width: 25%;">%
    </div> -->
    <strong><p style="color: #ff0000; display: none;" id="t_warning"> Input is out of Range</p></strong>

    <div class="row col-md-12">
        <div class="col-md-6" style="padding-left:3px">
            <p><span id="branch-row" style="background-color: #399a08e8;width: 30%;text-align: center;color: white; border-radius: 5px;display:inline;padding-top: 5px;padding-bottom: 5px;" align="right">&nbsp;&nbsp;&#43;&nbsp;&nbsp;</span> Branch Commision base on Sales 
            </p>
        </div>
    </div>
    <div class="manager_comison" align="left">
        @if(count($commbranches) > 0)
        @foreach($commbranches as $key => $branch)
        @if($key > 0)
        <div class="row col-md-12" style="padding: 4px;" id="branch_{{$branch->location_id}}">
            <div class="col-md-10">
                <div class="col-md-1" style="padding-left: 0px;padding-right: 0px;width: 4.33%;line-height: 25px;">
                    <p onclick="removeBranchRow('{{$branch->location_id}}');" style=" display:inline; background-color: #ff100e;width:10%;text-align: center;color: white; border-radius: 5px;padding-top: 5px;padding-bottom: 5px;" align="right">&nbsp;&nbsp;&times;&nbsp;&nbsp;</p>
                </div>
                <div class="col-md-4 pl-0" style="padding-right: 0px;">
                    <input id="name{{$branch->location_id}}" required type="text" name="commtext"  placeholder="Manager commission" class="commenttext" value="{{$branch->commtext}}">&nbsp; = 
                    <input type="hidden" value="{{$branch->location_id}}" name="location_id" style="width: 25%;"  class="locations" placeholder="Branch">
                </div>
                <div class="col-md-2" style="line-height: 25px;">
                    <p style=" display:inline;">{{$branch->location}}</p>
                </div>
                <div class="col-md-5">
                     x &nbsp;<input type="number" onfocus="b_erase('{{$branch->location_id}}')" required id="percent{{$branch->location_id}}"  name="commission_pct" style="width:100px" class="distext" max="100" min="0" value="{{$branch->commission_pct}}"> &nbsp;
                    <span class="inside" style="text-align: left"><strong>%</strong> </span>
                    <strong><span style="color: #ff0000; display: none;" id="b_warning{{$branch->location_id}}"> Input is out of Percentage Range</span></strong>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @endif

        {{--<div class="col-md-10" id="branch_comm">--}}
        {{--<input type="text" name="commtext" style="width: 25%;" placeholder="Manager commission"> =--}}
        {{--<input type="text" name="location_id" style="width: 25%;" placeholder="Branch">--}}
        {{--X--}}
        {{--<input type="text" id="percent"   name="commission_pct" style="width: 25%;">%--}}
        {{--</div>--}}
    </div>

</div>


<div class="row">
    <div class="col-md-12" style="margin-bottom:10px;padding-bottom: 10px;padding-top:10px">
        <p class="head_p" style="padding-right: 160px;">Commission base on Product Rate</p>&nbsp;
		<br><br><span id="new-row"
        onclick="addRow({{$member_id}});"
        style="background-color: #399a08e8;width: 30%;text-align:center;
            color: white; border-radius: 5px;display:inline;padding-top: 5px;padding-bottom: 5px;"
        align="right">&nbsp;&nbsp;&#43;&nbsp;&nbsp;</span>&nbsp; Personal
        <!-- <button type="button" onclick="save();">saveCommission</button> -->
    </div>

    {{--<div class="comm_product" id="rowNum0" style="float: left;">--}}

    @if(count($commproducts) > 0)
    <?php $key = 0;?>
    @foreach($commproducts as $product)
    <?php $key++ ;?>
    <div class="col-md-12" id="rowNum{{$key}}" style="float: padding-bottom: 10px;width: 100%;line-height: 25px;padding-bottom: 10px;">
        <div class="col-md-2" style="padding-left:0px;padding-right:0px;line-height: 25px;vertical-align: middle;">
            <p onclick="removeRow({{$key}});" style=" display:inline; background-color: #FF0000;width:10%;text-align: center;color: white; border-radius: 5px;padding-top: 5px;padding-bottom: 5px;" align="right">&nbsp;&nbsp;&times;&nbsp;&nbsp;</p>
            <img style="width:30px;height:30px;padding-left: 5px;"  id="productImg" src="{{ asset('images/product/'.$product->product_id.'/thumb/'.$product->thumb_photo.'') }}" >
        </div>
        <div class="col-md-10">
            MYR &nbsp;&nbsp;
            <input type="hidden" name="product_id" id="productId" value="{{$product->product_id}}">
            <input type="hidden" name="member_id" value="{{$product->sales_member_id}}" id="memberId">
            <input type="text" onfocus="t_erase({{$key}})"   name="commission" id="prodComm" style="width: 30%;line-height: 20px;"  placeholder="commission" value="{{number_format($product->commission_amt/100,2)}}">
            &nbsp;&nbsp;<strong><span style="color: #ff0000; display: none;" id="t_warning{{$key}}"> Input is out of Range</span></strong>
            <p id="productName" style="margin: 0px;">{{$product->name}}</p> 
        </div>
    </div>
    @endforeach
    @endif
    <input type="hidden" value="{{count($commproducts)}}" id="pcount">
    <input type="hidden" id="deletedproduct">
    <input type="hidden" id="staffmemberid" value="{{$member_id}}">
    <div class="col-md-3" id="rowNum0" style="float: left;">
        <input type="hidden" id="personal" name="personal" style="width: 100%;">
    </div>

   <div class="row">
    <div class="col-md-12" style="text-align: center">
        <button type="submit" class="btn" style="font-size: 17px;background-color: #0cc0e8;border-color: #0cc0e8;color: #fff; width: 75px;height: 75px;border-radius: 6px;">Save</button>
    </div>
</div>
</form>
<script type="text/javascript" >
    function close_modal(){
       $('#show_products_modal').modal('hide');
    }
</script>

    <script>
        $(document).ready(function() {
            $('input[name=commission]').number(true, 2, '.', '' );
            $('.savemyr').number(true, 2, '.', '' );
            $('.block60').number(true, 0);
            $('#branchmemberid').val($('#staffmemberid').val());

            $('#selectedbranch').val('');
            var data = [];
            $('.commenttext').each(function( index ) {
                var id = $(this).attr('id');
                var location_id = id.slice("4");
                data.push(location_id);
                $('#selectedbranch').val(data);
            });
        });


        $('.changepart').on("change",function(){
            $('#parttm').val(1);

        })
        $('.changeover').on("change",function(){
            $('#overtm').val(1);
            // $('.block60').number(true,0);
        })
        $('.personal_sales').on("change",function(){
            $('#persale').val(1);
        })
        
        /*----------------- add row function start --------------*/
        var serial = 0;
        var pcount= $('#pcount').val();
        var rowNum = pcount;
        function addRow($member_id){
            rowNum ++;
            var row ='<div class="col-md-12" id="rowNum'+rowNum+'" style="float: padding-bottom: 10px;width: 100%;line-height: 25px;padding-bottom: 10px;">' +
                '<div class="col-md-2" style="padding-left:0px;padding-right:0px;line-height: 25px;vertical-align: middle;">'+
                    '<p onclick="removeRow('+rowNum+');" style=" display:inline; background-color: #FF0000;width: ' +
                    '10%;text-align: center;color: white; border-radius: 5px;padding-top: 5px;padding-bottom: 5px;" align="right">&nbsp;&nbsp;&times;&nbsp;&nbsp;</p>'+
                    '<img style="width:30px;height:30px;padding-left: 5px;"  id="productImg" src="" >' +
                    '</div>'+
                    '<div class="col-md-10">'+
                        'MYR &nbsp;&nbsp;' +
                        '<input type="hidden" name="product_id" id="productId">'+
                        '<input type="hidden" name="member_id" value="'+$member_id+'" id="memberId">'+
                        '<input type="text" onfocus="t_erase(rowNum)"   name="commission" id="prodComm" style="width: 30%;line-height: 20px;"  placeholder="commission">' +
                    '&nbsp;&nbsp;<strong><span style="color: #ff0000; display: none;" id="t_warning'+rowNum+'"> Input is out of Range</span></strong><p id="productName" style="margin: 0px;"></p> ' +
                    '</div>'+
                    '</div>';
    
   

            var prev = (rowNum-1);
            jQuery('#rowNum'+prev).after(row);
            $('input[name=commission]').number(true, 2, '.', '' );
            $('#pcount').val(rowNum);
        }
        // var fordelete = [];

        function removeRow(rnum){

            $('#pcount').val(rowNum);
            var prodId = $("#rowNum"+rnum+" #productId").val();
            var member_id = $("#memberId").val();
            console.log(prodId);

            var num_plus = rnum+1;
            jQuery('#trow-'+num_plus).remove();
            jQuery('#rowNum'+rnum).remove();
            rowNum--;
            serial--;
            $('#pcount').val(rowNum);
            $.ajax({
                type: "POST",
                url: JS_BASE_URL+"/staff/delete_product_comm",
                data:{"product_id":prodId,"sales_member_id":member_id},
                success: function( data ) {
                    // console.log(data)
                }
            });
        }
        // function save()
        // {
        //     var $prodId =     $("#rowNum"+rowNum+" #productId").val();
        //     var $commission =    $("#rowNum"+rowNum+" #prodComm").val().replace(/\./g, "");
        //     var $member_id = $("#rowNum"+rowNum+" #memberId").val();
        //     $($commission).css("background","#FFF url({{asset('icons/loader.gif')}}) no-repeat right");
        //     $.ajax({
        //         type: "POST",
        //         url: JS_BASE_URL+"/staff/product_comm",
        //         data:{"product_id":$prodId,"commission" : $commission,"member_id":$member_id},
        //         success: function( data ) {
        //             console.log(data)
        //         }
        //     });
        // }

        function save()
        {
           var alldata = [];
           rowNum = $('#pcount').val();
           // console.log(rowNum);
            for (var i = rowNum; i >= 1; i--) {
                prodId = $("#rowNum"+i+" #productId").val();
                // commission =    $("#rowNum"+i+" #prodComm").val().replace(/\./g, "");
                 commission = $("#rowNum"+i+" #prodComm").val();
                member_id = $("#rowNum"+i+" #memberId").val();
                alldata.push({
                    product_id: prodId,
                    commission: commission,
                    member_id: member_id
                });
                // $($commission).css("background","#FFF url({{asset('icons/loader.gif')}}) no-repeat right");
            }
            console.log(alldata);
            $.ajax({
                type: "POST",
                url: JS_BASE_URL+"/staff/product_comm",
                data:{"alldata":alldata},
                success: function( data ) {
                    console.log(data)
                }, error: function( data ) {
                    console.log('error');
                    
                    console.log(data)
                }
            });
        }
        
        function show(element) {  element.css("display","block"); }
        function hide(element) {  element.css("display","none"); }

        

        function valid(num) {
        
            // console.log(num);
            // var cents = new RegExp('^\\d+\\.\\d{2}$');
            // if (cents.test($("#rowNum"+rowNum+" #prodComm").val())) {
                save();
            // }else{
            //     var $error = $('#t_warning'+num);
            //     show($error)
            // }
        }
        function t_erase(num){
            var $error = $('#t_warning'+num);
            hide($error);
        }
        function erase(){
            
            // $('input#personal_sales').number(true, 0, '.', '' );
            var $error = $('#t_warning');
            hide($error);
        }
        function valid_percent() {
            var member_id = $('#staffmemberid').val();
            var $myId = $('#personal_sales').val();
            var $error = $('#t_warning');

            // var percents = new RegExp('^\\d+\\.\\d{1,2}$');
            // if (percents.test($myId)) {
                //Should not be more than hundred
                if (parseFloat($myId) > 100) {
                    show($error);
                }else{
                    var data = {
                        0:{
                            commtext: "NULL",
                            location_id:"NULL",
                            commission_pct:$myId
                            }
                         };
                    saveComm(data,member_id);
                }
            // }else{
            //    show($error);
            // }
        }      

        <!--Part Time Functions -->
        function validPartTime() {
            var $min = $('#total_max').val();
            var $ovr = $('#myr_pv').val();
            var $error = $('#pt_warning');

            var $member_id = $('#staffmemberid').val();
            var digits = new RegExp('^\\d{1,10}$');
            if (digits.test($min) && digits.test($ovr)) {
                savePartTime($min,$ovr,$member_id);
            }else{
                show($error);
            }
        }

        function savePartTime($min,$ovr,$member_id)
        {

            $.ajax({
                type: "POST",
                url: JS_BASE_URL+"/staff/part_time",
                data:{"rate_hr":$ovr,"block" : $min,"member_id": $member_id},
                success: function( data ) {
                    console.log(data)
                }
            });
        }
        function close_pt_error(){
            // $('input.savemyr').number(true, 2, '.', '' );
            var $error = $('#pt_warning');
            hide($error);
        }
        <!--Over Time Functions -->
        function validOverTime() {
            var $min = $('#total_min').val();
            var $ovr = $('#myr_ov').val();
            var $error = $('#ot_warning');
            var $member_id = $('#staffmemberid').val();

            var digits = new RegExp('^\\d{1,10}$');
            if (digits.test($min) && digits.test($ovr)) {
                saveOverTime($min,$ovr,$member_id);
            }else{

                show($error);
            }
        }
        function close_ot_error(){
            // $('input.savemyr').number(true, 2, '.', '' );
            var $error = $('#ot_warning');
            hide($error);
        }

        function saveOverTime($min,$ovr,$member_id)
        {

            $.ajax({
                type: "POST",
                url: JS_BASE_URL+"/staff/over_time",
                data:{"rate_hr":$ovr,"block" : $min,"member_id": $member_id},
                success: function( data ) {
                    console.log(data)
                }
            });
        }

    </script>
    <style>
        .modal-open {
            overflow: scroll;
        }
    </style>
    <script>
        $(document).delegate( '#new-row', "click",function (event) {
            

            $("#show_products_modal").modal("show");

        });
        // $('#show_products_modal').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
        //          $('#product_table').DataTable({
        //             "paging":   true,
        //             "ordering": true,
        //             "info":     false
        //         });
        //     });

        function displayTextDisappearModal(pname, pid, pcomm, img_path) {
            // alert(pname);
            $("#rowNum"+rowNum+" #productName").text(pname);
            $("#rowNum"+rowNum+" #productImg").attr('src',img_path);
            $("#rowNum"+rowNum+" #productId").val(pid);
            $("#rowNum"+rowNum+" #prodComm").val(pcomm);
            $("#show_products_modal").modal("hide");
        }


    </script>
    <script>

        // $('#product_table').DataTable();
       
    </script>
    <script type="text/javascript">
        $('#frmsubmit').submit(function(e){
            e.preventDefault();
            if($('#parttm').val() == 1)
            {
                validPartTime();
            }
            if($('#overtm').val() == 1)
            {
                validOverTime();
            }
            if(rowNum > 0)
            {
                save();
            }
            if($('#persale').val() == 1)
            {
                valid_percent();
            }
            valid_percents(); 
            $('#parttimerModal').modal('hide');   
        });
        $('input.overtmrate').change( function() {
            var myr_ov=$(this).attr('id');

            if(myr_ov=='myr_ov'){
                var myLength = $("#myr_ov").val().length;
                if(myLength<=6){
                    var myr1=$("#myr_ov").val();
                }else{
                    alert("6 digits are allow");
                }
            }
            if(myr_ov=='myr_dy'){
                var myLength = $("#myr_dy").val().length;
                if(myLength<=2){
                    var myr2=$("#myr_dy").val();
                }else{
                    alert("2 digits are allow");
                }
            }

            if(myr_ov=='myr_ovrate'){
                var myLength = $("#myr_ovrate").val().length;
                if(myLength<=2){
                    var myr3=$("#myr_ovrate").val();
                }else{
                    alert("2 digits are allow");
                }
            }


            if(myr_ov=='myr_rst'){
                var myLength = $("#myr_rst").val().length;
                if(myLength<=6){
                    var myr1=$("#myr_ov").val();
                    var myr2=$("#myr_dy").val();
                    var myr3=$("#myr_ovrate").val();
                    var myr4=$("#myr_rst").val();
                    if(myr1 != '' && myr2 != '' && myr3 !='' && myr4 != '') {
                        alert(myr1);
                        alert(myr2);
                        alert(myr3);
                        alert(myr4);
                        var final_total = parseInt(myr1) / parseInt(myr2) / parseInt(myr3);
                        var final_total_ans =final_total * myr4;

                        $("#total_min").val('');
                        $("#total_min").val(final_total_ans);
                    }
                }else{
                    alert("6 digits are allow");
                }
            }

            // $($output).text(this.value);
        });



        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
                }
            });

            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
            })
        });

    </script>
@section('scripts')

    @endsection
