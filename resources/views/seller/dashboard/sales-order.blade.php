<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
 $cStatus=["completed","reviewed","commented"];
define('MAX_COLUMN_TEXTvw', 20);
?>
<style>
    .row-centered{text-align:center;margin: 0 auto;margin-top:15px;}
    dl {
  width: 100%;
  overflow: hidden;
  /*background: #ff0;*/
  padding: 0;
  margin: 0
}
dt {
  float: left;
  width: 50%;
  /* adjust the width; make sure the total of both is 100% */
  /*background: #cc0;*/
  padding: 0;
  margin: 0
}
dd {
  float: left;
  width: 50%;
  /* adjust the width; make sure the total of both is 100% */
  /*background: #dd0*/
  padding: 0;
  margin: 0
}

.clock{
    padding:0px;margin-left:-6px;margin-top: 2px;color: #d9534f;
}
.modal-custom {
  width: 90%;
 /* height: 100%;*/
  margin: 0;
  padding: 0;
}

/*.modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}*/
</style>
<div class=" " > <!-- col-sm-12 -->
<h2>Order (Online)</h2>
<br>
    <table class="table table-bordered" id="product_details_table">
        <thead>
        <tr class="bg-beige" >
            <th class="text-center no-sort">No</th>
            <th class="text-center" width="100px">Order&nbsp;ID</th>
            <th class="text-center" width="100px">Received</th>
            <th class="text-center" width="100px">Completed</th>
            {{-- <th>SKU</th> --}}
            <th class="text-center" width="80px">Mode</th>
            <th class="text-center" width="100px">Total</th>
            {{-- <th class="text-center" width="150px" style="background:green;">Remarks</th> --}}
            <th class="text-center" width="100px" style="background:green;">Status</th>
            <th class="text-center no-sort" width="135px" style="background:green;">Approval</th>
        </tr>
        </thead>
        <tfoot>
            {{-- <a class="btn btn-success pull-right" style="margin-bottom:10px; background:rgb(140,199,63);" disabled=>Approve</a> --}}
        </tfoot>
        <tbody>
        {{--  --}}
            <?php $i=1;
            //dd($ordersb);
            // dump($ordersb);
            ?>
        
        @if(isset($ordersb))
            @foreach($ordersb as $p)
                <tr>
                    {{-- <td><input type="checkbox" name="process[]" class="process" data-oid="{{$p['oid']}}"></td> --}}
                     <td style="text-align: center;">{{$i}}</td>
                     {{-- Route change--}}
					@if($p['mode']=="cash")
						<td style="text-align: center;"><a href="{{route('deliverorder', ['id' => $p['oid']])}}" class="uniqporder" id="uniqporder" data="{{$p['oid']}}" target="_blank">{{IdController::nO($p['oid'])}}</a>
                    @endif
					@if($p['mode']=="term")
						<td style="text-align: center;"><a href="{{route('deliverinvoice', ['id' => $p['oid']])}}" class="uniqporder" id="uniqporder" data="{{$p['oid']}}" target="_blank">{{IdController::nO($p['oid'])}}</a>
                    @endif
					</td>
                    <td style="text-align: center;">{{UtilityController::s_date($p['rcv_date'])}}</td>
                    <td style="text-align: center;">
                    @if(isset($p['o_exec']))
                            @if($p['o_exec'] !="0000-00-00 00:00:00"
                             and in_array($p['status'],$cStatus))
                                
                            {{UtilityController::s_date($p['o_exec'])}}
                            @else --
                            @endif
                        {{-- @endif --}}
                    {{-- @endif --}}
                    {{-- {{UtilityController::s_date($p['o_exec'])}} --}}
                    @endif
                    </td>
                    <td style="text-align: center;">
						{{ucfirst($p['mode'])}}
                    </td>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            // $('.process :checked' ).
                        });
                    </script>
                    <?php $cE="nC";
                        $cTest=UtilityController::cE($p['oid']);
                        // dump($cTest);
                        if ($cTest[0]==1) {
                            $cE='cE';
                        }
                     ?>
                    <?php $total = number_format($p['total']/100,2); ?>
                        <td style="text-align: center;">
                                {{$currency or 'MYR' }}&nbsp;{{$total}}
                        </td>


                    <td style="text-align: center;" data-status="{{$p['status']}}" class="{{$cE}}" >
                        {{-- Paul on 1 May 2017 at 11 40 pm removed href='#' --}}
                     <a href="javascript:void(0)" role_id="{{$p['oid']}}" class="preventDefault approval" <?php

                    if ($cE=="cE") {
                        $ceid=$cTest[1]->complaint_reason_id;
                
                        // $ceid=1;
                        $reason="#ComplaintID: ".$cTest[1]->id." ". DB::table('buyercomplaintreason')->where('id',$ceid)->first()->description ."";
                        // dump($reason);
                        echo "title='Complaint Filed' data-toggle='popover' data-placement='bottom' data-content='".$reason."'";
                    }
                    ?>
                    >
                        @if(is_null($p['status']))
                                In Process
                    
                            @else
                                <span id="s{{$p['oid']}}">{{ucfirst($p['status'])}}<span>
                            @endif
                    </a>
                    </td>
                     <td style="text-align: center;">
                     <?php 
                        $date = $p['o_exec'];
                        $date = strtotime($date);
                        $date1 = new DateTime('now');
                        $date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $globals->merchant_process_salesorder_window hours", $date)));
                        $dDiff = $date1->diff($date2);
					/*	dump($dDiff->format("%r"));
						dump($date1);
						dump($date2);*/
                        if ($dDiff->format("%r") != '-' && $p['status']=='pending') {
                   
                     ?>
                        <a href="#" class="btn btn-danger pull-left cancel_order" rel-oid="{{$p['oid']}}">Cancel</a>
                         <a class="btn btn-process pull-right process_order" rel="{{$p['oid']}}"> <span class="spinner"><i class="fa fa-refresh fa-spin"></i></span>Process</a>
						<span style="text-align:center;margin-right:5px;font-size: 0.8em;"
						class="col-md-5 clock pull-right"
						data-cancel="{{UtilityController::cancelTime($p['o_exec'])}}" 
						data-countdown="{{UtilityController::calculateProcessTime($p['o_exec'])}}"
                        id="countdowntimer{{$p['oid']}}"></span>
                    <?php } ?>   
                    @if($p['status']=='m-processing1')
                    {{-- <a href="{{url('label/download',$p['oid'])}}" class="btn btn-label pull-left" title="Print Label" alt="Print Label"><span class="glyphicon glyphicon-print"></span></a> --}}
                    <a  class="btn  btn-label cll" data-oid="{{$p['oid']}}"><span class="glyphicon glyphicon-earphone"></span> Logistic</a>
                    @elseif($p['status'] == "l-processing")
                    <a href="{{url('label/download',$p['oid'])}}" class="btn btn-label pull-left" title="Print Label" alt="Print Label"><span class="glyphicon glyphicon-print"></span></a>
                    @elseif($p['status']=='m-processing2')
                    <a href="{{url('label/download',$p['oid'])}}" class="btn btn-label pull-left" title="Print Label" alt="Print Label"><span class="glyphicon glyphicon-print"></span></a>
                    @elseif ($p['status']=='b-returning')
                    <a rel-oid="{{$p['oid']}}" class="btn btn-return pull-right apreturn">Return</a>
					<span style="text-align:center;margin-right:5px;margin-top:7px"
						class="col-md-5 clock pull-right"
						data-countdown="{{UtilityController::calculateReturnProcessTime($p['o_exec'])}}"
                        id="countdowntimer{{$p['oid']}}"></span>
                    @elseif($p['status'] == "m-collected")
                     <a rel-oid="{{$p['oid']}}"
					 	style="background-color: #00cc00"
					 	class="btn btn-approval pull-right aapprove">
						Return Approval</a>
                    @endif
                    </td>
                </tr>
                <?php $i++; ?>
            @endforeach
        @endif
        </tbody>

    </table>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        /*  Paul on 1 May 2017 at 11 40 pm to enable MRT  */
        $(document).delegate( '.approval', "click",function (event) {
            //  Paul on 1st May 2017 at 11 55 pm
            //window.open(JS_BASE_URL + "/admin/master/orderapp/" + $(this).attr("role_id"), '_blank');
            window.open(JS_BASE_URL + "/orderapp/" + $(this).attr("role_id"), '_blank');
        });
        $('.cancel_order').click(function(){
            var oid=$(this).attr('rel-oid');
            url=JS_BASE_URL+"/merchant/cancelorder/"+oid;
            $.ajax({
                url:url,
                type:'GET',
                success:function(r){
                    if (r.status=="success") {
                        toastr.info(r.long_message);
                        // location.reload();
                        $("#countdowntimer" + oid).hide();
                        $("#s" + oid).text("Processing");
                        location.reload();
                    }
                    else{
                        toastr.warning(r.long_message);
                    }
                },
                error:function(){
                    toastr.warning("Please try again later.");
                }
            });
        });
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
         $('.confCL').click($.debounce(1000,function(){
             $('.btn-calll').hide();
             $('#cllModal').modal('hide');
                var url="{{url('call/logistic')}}";
                var oid= $('#confOID').val();
                var count=$('#tP').val();
                var isotime=$('#pD').val();
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
                          // console.log(temp);
                          data.push(temp);
                });
                // console.log(JSON.stringify(data));
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
            }));
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
                "pdate":$('#pd').val(),
                "pck":$('#pck').val()
            }


        });
    });
</script>

<div class="modal fade" id="cllModal" role="dialog" aria-labelledby="cllLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <a type="a" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></a>
               
            </div>
            <div class="modal-body" id="clB">
               
                
            </div>
            <div class="modal-footer">
               {{--  <a class="btn btn-primary btn-info" id="clNxt">Next <span class="glyphicon glyphicon-arrow-right"></span></a> --}}
                <a type="a" class="btn btn-approval pull-right confCL">Confirm</a>
                <a type="a" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
            </div>
            </form>

        </div>
    </div>
</div>
{{--Remark Modal--}}
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <a type="a" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></a>
                <h4 class="modal-title" id="myModalLabel">Approval Form</h4>
            </div>
            <div class="modal-body">
              
              
            </div>
            <div class="modal-footer">
                <a type="a btn-warning" id="zxcv" class="btn btn-default " data-dismiss="modal">Close</a>
                <a href="javascript:void(0);" id="confaprv" class="btn btn-approval">Confirm</a>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg modal-custom" role="document">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <a type="a" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                
                    {{-- <a href="javascript:void(0);" rel-type="goods" class="btn btn-return confret disabled" data-color="primary" disabled="disabled" id="gbutton">Return Goods</a> --}}
                    
                </span>
               {{--  <a href="javascript:void(0);" class="btn btn-approval positive-btn pull-right confret"><span class="glyphicon glyphicon-check"></span> Goods</a> --}}


                <a href="javascript:void(0);" rel-type="smooth" class="btn btn-return positive-btn pull-right " id="confirm_return"> Confirm</a>
            </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
    $('#confirm_return').click(function(){
        /*
            Format POST DATA
        */ 
        var data =[];
        var url="{{url('merchant/confirms/cre')}}";
       
        
        $('.cre_approval').each(function(i,elem){
            var temp={};
            var opid=$(elem).attr('rel-opid');

            
            var result=$('input[name=status_'+opid+']:checked').val();
            console.log(result);
            temp['result']=result;
            temp["opid"]=opid;
            data.push(JSON.stringify(temp));

        });

        
         $.ajax({
                type:'POST',
                url:url,
                data:{"data":data},
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

{{-- <input type="hidden" id="crereasonshidden" data-array="{{$cre_r_arr}}"> --}}
 <!--CRE_Reason Modal -->
    <div class="modal fade" id="crereason" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <a type="a" class="close" data-dismiss="modal">&times;</a>
                    <h4 class="modal-title">CRE </h4>
                </div>
                <div class="modal-body">
                    <dl style="display:inline;">
                        <dt>Action</dt> <dd class="dd-action"></dd>
                        <dt>Order Id</dt><dd class="dd-oid"></dd>
                        <dt>Status</dt><dd class="dd-status"></dd>
                        {{-- <dt>Product Id</dt><dd class="dd-pid"></dd> --}}
                        <dt>Reason</dt> <dd class="dd-reason"></dd>
                        {{-- Area to add further info if return --}}
                        <span id="add_further"></span>
                        <input type="hidden" class="cre-id">
                    </dl>
                </div>
              {{--   <div class="modal-body">
                    <select id="reason" class="">
                        <option value="" disabled selected>Select reason</option>
                        @if(isset($crereasons))
                            @foreach($crereasons as $reason)
                            <option value="{{$reason->id}}">{{ucwords($reason->reason_text)}}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="row">
                        <div class="col-md-12 row-centered" style="">
                            <a type="a" style="width:70px;background:#c9302c;color:white" data-dismiss="modal" class="btn-close btn btn-md">Cancel</a>
                            <a type="submit" style="width:70px;background:#337ab7;color:white" class="btn-add btn btn-md save">Save</a>
                        </div>
                    </div>
                </div> --}}
                <div class="modal-footer">
                    <a type="a" class="btn btn-approval" data-status='' id="confirmcre">Confirm</a>
                    <a type="a" class="btn btn-default" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
    {{--END CRE_Reason Modal--}}
{{-- <div class="clearfix"> </div> --}}
<script src= {{asset("js/jquery.countdown.min.js")}}></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Download Label

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
                $this.html(event.strftime('%-d:%H:%M:%S'));
              }).on('finish.countdown', function(event) {
                // 
                $this.hide();
            }).on('elapsed.countdown',function(){
                $this.hide();
            });;
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
        }else if((status == 'cancelreq' || status == 'b-returning')){
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
