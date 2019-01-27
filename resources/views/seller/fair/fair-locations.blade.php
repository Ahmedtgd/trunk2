<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$cStatus=["completed","reviewed","commented"];
define('MAX_COLUMN_TEXTvk', 20);
$ii = 1;
?>
<style>
.naddTproduct:hover {
  background-color: #CCC !important;
  border-color: #CCC !important;
}

.location_design{
    width: 70px;
    height: 70px;
    padding-top: 26px;
    padding-left: 5px;
    text-align: center;
    vertical-align: middle;
    float: left;
    font-size: 13px;
    cursor: pointer;
    margin-right: 5px;
    margin-bottom: 5px;
    border-radius: 5px;
	border-width:0;
}

.naddTproduct {
  background-color: #CCC !important;
  border-color: #CCC !important;
}
</style>
<div style="padding-top:10px" > <!-- col-sm-12 -->
    <div style="padding-left:0" class=" col-sm-6">
        <h2>Location Definition</h2>
    </div>
    <div style="padding-right:0;margin-bottom:10px" class=" col-sm-6">
      <button
      style="float:right;padding:0;margin-right:0;margin-left:0;padding-top:3px"
      type="button" class="btn btn-info location_design"
      data-toggle="modal" data-target="#fairlocationmodel">
      Default<br>Initial<br>Location</button>

      <a href="javascript:void(0)" style="padding-top: 17px;"
	  class="btn btn-primary btn-primary pull-right location_design addLocation">
	  &nbsp;&nbsp;Add<br> &nbsp;&nbsp;Location&nbsp;</a>

      <a href="javascript:void(0)" style="padding-left:3px;padding-top:17px;"
	  class="btn btn-primary btn-primary pull-right bg-warehouse location_design addWarehouse">
	  &nbsp;&nbsp;Add<br>Warehouse</a>


     <!-- Modal -->
     <div id="fairlocationmodel" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="display: flex; justify-content: space-between">

             <h4 class="modal-title">Default Initial Location</h4>
              <div style="display: flex;">
                  <h5 style="margin: 0;padding-top:7px">{{$dil}}</h5>&nbsp;&nbsp;
                  <button type="button" class="close"
				  	style="padding-top:5px"
				  	data-dismiss="modal"> &times;</button>
              </div>
          </div>
        <div class="modal-body">
            <select class="form-control" id="fairlocationid"
			name="all_location">

                @foreach($all_locations as $location)
                <option value="{{$location->id}}"
				@if($location->default_initial_location == true) selected
				@endif
				>{{$location->location}}</option>
                @endforeach  
            </select>
        </div>
        <div class="modal-footer">
            <button id="savelocation" type="button" data-dismiss="modal" class="btn btn-primary" >Save</button> 
        </div>
    </div>
          <script>
              $('select2').select2().enable(true);
          </script>
</div>
</div>

</div>
<br>
<div id="thetable">
  <table class="table table-bordered" width="100%" id="location_details_table">
     <thead>
         <tr class="bg-location">
            <th class="text-center no-sort bsmall" width="20px"
				style="width: 20px !important;">No</th>
            <th class="text-center" >Company&nbsp;Name</th>
{{--             <th class="text-center" >Branch</th>
 --}}            <th class="text-center">Address</th>
            <th class="text-center">Branch</th>
            <th style="width: 15%;" class="text-center">Location Code</th>
            <th class="text-center">Consignment A/C No</th>
            <th class="text-center bsmall">&nbsp;</th>
        </tr>
    </thead>
    <tbody>

     @if(isset($locations))
     @foreach($locations as $location)
     <tr>
         <td style="text-align: center;">{{$ii}}</td>
         <td style="text-align: left;">
            
             <input type="text" value="{{$location->company_name}}" class="location_company_input" style="display: none;" id="location_company{{$location->id}}" rel="{{$location->id}}" />
             <span rel="{{$location->id}}" class="location_company text-left"
			 id="location_company_span{{$location->id}}" rel-type="{{$location->type}}">
			 &nbsp;{{$location->company_name}}&nbsp;</span>
            
         </td>
       {{--   <td style="text-align: center;">

            <input type="text" value="{{$location->branch_name}}" class="location_branch_input" style="display: none;" id="location_branch{{$location->id}}" rel="{{$location->id}}" />
             <span rel="{{$location->id}}" class="location_branch text-left"
             id="location_branch_span{{$location->id}}">
             &nbsp;{{$location->branch_name}}&nbsp;</span>
         </td> --}}
         <td style="text-align: center;"><a href="javascript:void(0)" class="locationaddress" rel="{{$location->address_id}}" idrel="{{$location->id}}">Address</a></td>
         <td style="text-align: center;">
             
             <input type="text" value="{{$location->location}}" class="location_loc_input" style="display: none;" id="location_loc{{$location->id}}" rel="{{$location->id}}" /><span rel="{{$location->id}}" class="location_loc" id="location_loc_span{{$location->id}}">&nbsp;{{$location->location}}&nbsp;</span>
             
         </td>
         <td><input id="locationcode{{$location->id}}"  type="text" class="form-control" value="{{$location->code or ''}}" onblur="fairlocationcode({{$location->id}})" name=""></td>
         <td style="text-align: center;">
             <a  href="{{URL::to('/')}}/seller/fairmode/accno/{{$location->id}}" rel='{{$location->id}}'>Account No</a>
         </td>
         <td style="text-align: center;">
             
			 <a  href="javascript:void(0);"
				 class="btn btn-danger show_delete_modal"
				 style="border-radius:5px"
				 rel='{{$location->id}}'>
				 <i class="fa fa-times" aria-hidden="true"></i>
			 </a>
             
         </td>
     </tr>
     <?php $ii++; ?>
     @endforeach
     @endif
 </tbody>

</table>
</div>
</div>
<script type="text/javascript">
    function fairlocationcode(id) {
        var locationcode = $('#locationcode'+id).val();
        var check_url=JS_BASE_URL+"/locationcode/save/"+locationcode+"/"+id;

        $.ajax({
            url:check_url,
            type:'GET',
            success:function (r) {
               toastr.success("Code Saved");
            }
        });
        
    }
    $(document).ready(function(){

        $('.aapprove').click(function(){
            var oid=$(this).attr('rel-oid');
            url="{{url('merchant/approval')}}"+"/"+oid;
            $('#myModal').find('.modal-body').empty();
            $('#myModal').find('modal-title').text('Approval Form');
            $('#zxcv').addClass('pull-left');
            $('#myModal').find('.modal-body').load(url);
            $('#myModal').modal('show');
        });
        $('.apreturn').click(function(){
            var oid=$(this).attr('rel-oid');
            url="{{url('merchant/cre')}}"+"/"+oid;
            // $('#myModal2').removeData('bs.modal');
            $('#myModal2').find('.modal-body').load(url);
            $('#myModal2').modal('show');
        });
        $('input[type=radio]').change(function(){
            $c=0;
            $('.rejected').each(function(){
                if ($(this).is(":checked")) {

                }else{
                    c++;
                }
                if (c == 0) {
            // All rejected
            $('')
        }
    });
        });
    });
</script>
<script type="text/javascript">

    $(document).ready(function(){

       $('.confCL').click(function(){
        var url="{{url('call/logistic')}}";
        var oid= $('#confOID').val();
        var count=$('#tP').val();
        var isotime=$('#timestamp').attr('ts');
        var data=[];
        $('.Input').each(function(i,elem){
            temp={};
            $(elem).find(".form-control").each(function(x,obj){
                {
                    key=$(obj).attr('name');
                    value=$(obj).val();
                    temp[key]=value;
                }
            });
            console.log(temp);
            data.push(temp);
        });
        console.log(JSON.stringify(data));
        $.ajax({
            type:'POST',
            url: url,
            data:{"pd":data,
            "ts":isotime,
            "count":count,
            "oid":oid
        },
        success:function(r){
            if (r.status=="success") {
                            // toastr.info(r.long_message);
                            $('#clB').empty();
                            $('#clB').text(r.long_message);
                            location.reload(true);
                        }
                        if (r.status=="failure") {
                            toastr.warning(r.long_message);
                        }
                    },
                    error:function(){
                        toastr.warning("Please try again later");
                    }
                });
    });
       $('.date').datetimepicker({
          inline: true,
          sideBySide: true,
          format:'YYYY-MM-DD HH:mm'

                // Sorry for bad naming above
            });
       $('.cll').click(function(){

        var oid=$(this).attr('data-oid');


        var cllurl="{{url('call/logistic')}}/"+oid;
        $('#cllModal').find('.modal-body').empty();
        $('#cllModal').modal('show');
        $('#cllModal').find('.modal-body').load(cllurl);
        $('#clNxt').prop('disabled',false);
            // $('.confCL').prop('disabled',true);
            data={
                "oid":oid,
                "pdate":$('#date').val(),
                "pck":$('#pck').val()
            }


        });
   });
</script>
<script type="text/javascript">
    $(function () {
        $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
        $button = $widget.find('button'),
        $checkbox = $widget.find('input:checkbox'),
        color = $button.data('color'),
        settings = {
            on: {
                icon: 'glyphicon glyphicon-check'
            },
            off: {
                icon: 'glyphicon glyphicon-unchecked'
            }
        };

        // Event Handlersconf
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
            .removeClass()
            .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                .removeClass('btn-default')
                .addClass('btn-' + color + ' active');
            }
            else {
                $button
                .removeClass('btn-' + color + ' active')
                .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){

    // Ends

    $('.confret').click(function(){

        var url="{{url('merchant/confirms/cre')}}";
        var aopids=[];
        var ropids=[];
        var charge=1;
        var goods=0;
        var oid= $('#oidcre').val(); 
        var type=$(this).attr('rel-type');
        if ($('#noCharge').is(':checked')) {
            charge=0;
        }
        if ($('#goods').is(':checked') && type !="smooth") {
                // Merchant wants the good back.
                goods=1;
            }
            $('.retchoiceradio').each(function(i,elem){
                $elem=$(this);
                if($elem.is(':checked')){
                    var opid=$elem.attr('rel-opid');
                    var type=$elem.attr('rel-type');
                    if (type == "acpt") {
                        aopids.push(opid);
                    }
                    else if (type == "rjct"){
                        ropids.push(opid);
                    }
                }
            });
            data={"accepted":aopids
            ,"rejected":ropids
            ,"charge":charge
            ,"oid":oid
            ,"goods":goods};
            $.ajax({
                type:'POST',
                url:url,
                data:data,
                success:function(r){
                    if (r.status=="success") {
                        $('#myBody2').text(r.long_message);
                        $('.confret').remove();
                        location.reload();
                    }
                },
                error:function(){
                    toastr.warning('Some error happened. Please contact OpenSupport');

                }
            });
        });
});
</script>
<script src= {{asset("js/jquery.countdown.min.js")}}></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#savelocation').click(function () {

            var fairlocationid = $('#fairlocationid').val();
            var url = JS_BASE_URL+'/fairlocation/savedil/'+ fairlocationid;

            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function (data) {

                    toastr.success("Location Saved");
                    


                }
            });
        });

    });
</script>
<script type="text/javascript">
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
    $(document).ready(function(){

        $('[data-countdown]').each(function(){
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%H:%M:%S')); //$this.html(event.strftime('%D days %H:%M:%S'));
            });
        });
        
        $('body').delegate( ".process_order", "click",function (event) {
            var obj = $(this);
            var rel = $(this).attr("rel");
            var url = JS_BASE_URL+'/admin/merchant/order_process/'+ rel;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function (data) {
                    if (data=="OK") {
                        toastr.info("Order successfully updated!");
                        obj.hide();
                        $("#p" + rel).show();
                        $("#countdowntimer" + rel).hide();
                        $("#s" + rel).text("Processing");
                        location.reload();

                    } else {
                        toastr.warning(data.long_message);
                    }


                }
            });
        });
    });
    $('#remarks_column').delegate( ".mcridso", "click",function (event) {
        _this = $(this);
        var id_merchant = _this.attr('rel');
        //console.log('Merchant Id  '+id_merchant);
        $('#modal-Tittle2').html("Remarks");

        var url = JS_BASE_URL+'/admin/master/merchant_remarks/'+ id_merchant;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data) {
                var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th>No</th><th>Merchant ID</th><th>Status</th><th>Admin User ID</th><th>Remarks</th><th>DateTime</th></tr>";
                for (i=0; i < data.length; i++) {
                    var obj = data[i];
                    html += "<tr>";
                    html += "<td>"+(i+1)+"</td>";
                    html += "<td><a href='../../admin/popup/merchant/"+id_merchant+"' class='update' data-id='"+id_merchant+"'>["+pad(id_merchant.toString(),10)+"]</a></td>";
                    html += "<td>"+obj.status+"</td>";
                    html += "<td><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
                    html += "<td>"+obj.remark+"</td>";
                    html += "<td>"+obj.created_at+"</td>";
                    html += "</tr>";
                }
                html = html + "</table>";
                $('#myBody2').html(html);
                $("#myModal2").modal("show");
            }
        });
    });
</script>
{{--Cancellation Script--}}
<script type="text/javascript">
    $(".cancellation").click(function (event) {
        // var c=$(this).data('array');
        
        var cre_id=($this).attr('data-cre');
        var r=$('#crereasonshidden').data('array');
        var cre=$.grep(r,function(e){return e.id==cre_id})[0];

        // var crereason=r[index].reason_text;
        // alert(cre[0].reason_text);
        $('#confirmcre').attr('data-status',$(this).data('status'));
        $('.cre-id').attr('cre_id',cre_id);
        $('.dd-action').text(ucfirst(c.type));
        if (c.type=="return") {
            var html_content="";
            var prod_array=$('custom').data('creop');
            for (var i = 0; i < prod_array.length; i++) {
              html_content="<label style=' display: block;padding-left: 15px;text-indent: -15px;'><input type='checkbox' class='product_accepted_for_return' name=pafr[] style='width: 13px;height: 13px;padding: 0;  margin:0; vertical-align:bottom;  position: relative;  top: -1px;  *overflow: hidden;'> Product ID: "+prod_array[i].product_id+ "</label>"; 
          }
          $('#add_further').html(
            html_content


            );
      }
      $('.dd-oid').text(ucfirst(c.porder_id));
      $('.dd-status').text(ucfirst(c.status));
      $('.dd-reason').text(ucfirst(cre.reason_text));
      $('#crereason').modal('show');
      $this_a = $(this);
  });
    $('#confirmcre').click(function(){
        var action=$(this).data('status');
        var cre_id=$('.cre-id').attr('cre_id');
        var url=JS_BASE_URL+"/merchant/"+action+"/"+cre_id;
        $.ajax({
            type:'GET',
            url:url,
            success:function(r){
                if (r.status=="success") {
                    toastr.info(r.long_message);
                }
            },
            error:function(){toastr.warning("Something went wrong");}
        });
    });
    $('#crereason').on('click','.save' ,function (e) {
        e.preventDefault();
        var reason_id = $("select#reason option:selected").val();
        var id = $this_a.data('id');
        var status = $this_a.data('status');
        var siblings = $this_a.siblings();
        if(status == 'approve'){
            status = 'approve';
        }else if(status == 'reject'){
            status = 'reject';
        }
        var my_url = JS_BASE_URL+'/merchant/'+ status + '/' + cre_id;
        var method = "POST";
        $.ajax({
            type: method,
            url: my_url,
            dataType: 'json',
            success: function (data) {
                $this_a.prop('disabled', true);
                siblings.prop('disabled', true);
                $('#crereason').modal('hide');
                //console.log(data);
            },
            error: function (error) {
                //console.log(error);
            }
        });
    });
    $('.md-so-data-countdown').each(function(){
        var $this = $(this);
        var finalDate = $(this).data('countdown');
        var from=finalDate.split("-");
        var year,month,day;
        year=from[0];month=from[1];day=from[2].split(" ")[0];
        // var finalDate=new Date(year,month,day);
        finalDate=year+"/"+month+"/"+day;

//         $(this).countdown('2020/10/10', function(event) {
//   $(this).html(event.strftime('%D days %H:%M:%S'));
// });

var status = $this.parent('td').siblings('[data-status]').data('status');
        //console.log(status);
        var ex = $this.data('expired');
        if(status == "cancelled"){
            $this.siblings('.reject').prop('disabled', true);
            $this.siblings('.approve').prop('disabled', true);
        }else if(ex == 'no'){
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%D:%M:%S'));
                $this.siblings('.reject');
                $this.siblings('.approve');
            }).on('finish.countdown', function(event) {
                $this.siblings('.reject').hide();
                $this.siblings('.approve').hide();
            });
        }else if((status == 'cancelreq' || status == 'b-returning1')){
            $this.siblings('.reject').hide();
            $this.siblings('.approve').hide();
        }
        //console.log(ex);
    });


    $(document).ready(function(){
        $('.preventDefault').click(function(e){e.preventDefault();});
        $('[data-toggle="popover"]').popover();   
    });
</script>
