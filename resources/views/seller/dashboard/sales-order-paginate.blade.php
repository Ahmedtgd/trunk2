<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$globals = DB::table('global')->first();
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
        </tbody>

    </table>
</div>

<input type="hidden" value="{{$globals->merchant_process_salesorder_window}}" id="dateglobal" />
<input type="hidden" value="{{$globals->buyer_cancellation_window}}" id="buyerwindow" />
<input type="hidden" value="{{$globals->merchant_process_salesorder_window}}" id="merchantwindow" />
<script type="text/javascript">
    $(document).ready(function(){

        /*  Paul on 1 May 2017 at 11 40 pm to enable MRT  */
        $(document).delegate( '.approval', "click",function (event) {
            //  Paul on 1st May 2017 at 11 55 pm
            //window.open(JS_BASE_URL + "/admin/master/orderapp/" + $(this).attr("role_id"), '_blank');
            window.open(JS_BASE_URL + "/orderapp/" + $(this).attr("role_id"), '_blank');
        });
		$(document).delegate( '.aapprove', "click",function (event) {
      //  $('.aapprove').click(function(){
            var oid=$(this).attr('rel-oid');
            url="{{url('merchant/approval')}}"+"/"+oid;
            $('#myModal').find('.modal-body').empty();
            $('#myModal').find('modal-title').text('Approval Form');
            $('#zxcv').addClass('pull-left');
            $('#myModal').find('.modal-body').load(url);
            $('#myModal').modal('show');
        });
		$(document).delegate( '.apreturn', "click",function (event) {
   //     $('.apreturn').click(function(){
            var oid=$(this).attr('rel-oid');
            url="{{url('merchant/cre')}}"+"/"+oid;
            // $('#myModal2').removeData('bs.modal');
            $('#myModal2').find('.modal-body').load(url);
            $('#myModal2').modal('show');
        });
		$(document).delegate( 'input[type=radio]', "change",function (event) {
      //  $('input[type=radio]').change(function(){
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
	
		$.fn.dataTable.pipeline = function ( opts ) {
	    // Configuration options
	    var conf = $.extend( {
	        pages: 5,     // number of pages to cache
	        url: '',      // script url
	        data: null,   // function or object with parameters to send to the server
	                      // matching how `ajax.data` works in DataTables
	        method: 'GET' // Ajax HTTP method
	    }, opts );
	 
	    // Private variables for storing the cache
	    var cacheLower = -1;
	    var cacheUpper = null;
	    var cacheLastRequest = null;
	    var cacheLastJson = null;
 
    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
         
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
         
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );
 
        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));
 
                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
             
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);
 
            request.start = requestStart;
            request.length = requestLength*conf.pages;
 
            // Provide the same `data` options as DataTables.
            if ( $.isFunction ( conf.data ) ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }
 
            settings.jqXHR = $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);
 
                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    if ( requestLength >= -1 ) {
                        json.data.splice( requestLength, json.data.length );
                    }
                     
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );
 
            drawCallback(json);
        }
    }
};
 
		// Register an API method that will empty the pipelined data, forcing an Ajax
		// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
		$.fn.dataTable.Api.register( 'clearPipeline()', function () {
		    return this.iterator( 'table', function ( settings ) {
		        settings.clearCache = true;
		    } );
		} );
 
		var page=$('#gridmerchant_page').val();
		var product_dtable=$('#product_details_table').DataTable({
			"serverSide":true,
			"processing":true,
			"paging":true,
			"searching":{"regex":true},
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/salesorder/" + $("#selluserid").val(),
				dataSrc:function(json){
				
					var return_data=new Array();
					subcat_pids=[];
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						var completed = "--";
						if(d.status == "completed" || d.status == "reviewed" || d.status == "commented" ){
							var completed = d.completed;
						}
						var date1 = new Date(d.created_at);
						var datetoc = new Date(d.created_at);
						var datetocomp = new Date(d.created_at);
						var datetest = formatDateJs(datetocomp);
						//console.log(datetest);
						var date2 = new Date(dateglobal);
						var datenow = new Date();
						var timeDiff = date2.getTime() - date1.getTime();
						var h = parseInt($("#merchantwindow").val());
						var approval = "";
						var cancel = "no";
						if (timeDiff >= 0 && d.status=='pending') {
							datetoc.setMinutes(twentyMinutesLater.getMinutes() + parseInt($("#buyerwindow").val()));
							datetocomp.setTime(datetocomp.getTime() + (h*60*60*1000));
							if(datetoc.getTime()> datenow.getTime()){
								cancel = "yes";
							}
							var defdate = formatDateJs(datetocomp);
							approval = '<a class="btn btn-process pull-right process_order" rel="'+d.id+'"> <span class="spinner"><i class="fa fa-refresh fa-spin"></i></span>Process</a>';
							approval +='<span style="text-align:center ;" class="col-md-5 clock" data-cancel="'+cancel+'" data-countdown="'+defdate+'" id="countdowntimer'+d.id+'"></span>'
						}
						if(d.status=='m-processing1'){
							approval = '<a href="'+JS_BASE_URL+'/label/download'+d.id+'" class="btn btn-label pull-left" title="Print Label" alt="Print Label"><span class="glyphicon glyphicon-print"></span></a>';
							approval += '<a  class="btn  btn-calll cll" data-oid="'+d.id+'"><span class="glyphicon glyphicon-earphone"></span> Logistic</a>';
						}else if(d.status == "l-processing"){
							approval = '<a href="'+JS_BASE_URL+'/label/download'+d.id+'" class="btn btn-label pull-left" title="Print Label" alt="Print Label"><span class="glyphicon glyphicon-print"></span></a>';
						}else if(d.status=='m-processing2'){
							approval = '<a href="'+JS_BASE_URL+'/label/download'+d.id+'" class="btn btn-label pull-left" title="Print Label" alt="Print Label"><span class="glyphicon glyphicon-print"></span></a>';
						}else if (d.status=='b-returning1'){
							approval = '<a rel-oid="'+d.id+'" class="btn btn-return pull-right apreturn">Return</a>';
						}else if(d.status == "m-collected"){
							approval = '<a rel-oid="'+d.id+'" class="btn btn-approval pull-right aapprove">Approve</a>';
						}
						return_data.push({
							'id': i+1,
							'order_id':'<a href="javascript:void(0)" class="view-orderid-modal" data-id="'+d.id+'">'+d.order_id+'</a>',
							'received':d.received,
							'completed': completed,
							'mode':d.mode.toUpperCase(),
							'total':"{{$currentCurrency}} "+js_number_format(parseInt(d.total)/100,2,".",""),
							'status':'<a href="javascript:void(0)" role_id="'+d.id+'" class="preventDefault approval">'+ucfirst(d.status)+'</a>',
							'approval':approval

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'created_at',className:'text-center no-sort'},
				{data:"order_id",name:'order_id',className:'text-center'},
				{data:"received",name:'received',className:'text-center'},
				{data:"completed",name:'completed',className:'text-center no-sort'},
				{data:"mode",name:'mode',className:'text-center'},
				{data:"total",name:'total',className:'text-center'},
				
				{data:"status",name:'status',className:'text-center'},
				{data:"approval",name:'approval',className:'text-center'}

			]
		});
    });
</script>
<script type="text/javascript">

    $(document).ready(function(){
			$(document).delegate( '.confCL', "click",function (event) {
     //    $('.confCL').click(function(){
             $('.btn-calll').hide();

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
			$(document).delegate( '.cll', "click",function (event) {
   //     $('.cll').click(function(){

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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <a type="a" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
                
                    <a href="javascript:void(0);" rel-type="goods" class="btn btn-return confret disabled" data-color="primary" disabled="disabled" id="gbutton">Goods</a>
                    
                </span>
               {{--  <a href="javascript:void(0);" class="btn btn-approval positive-btn pull-right confret"><span class="glyphicon glyphicon-check"></span> Goods</a> --}}


                <a href="javascript:void(0);" rel-type="smooth" class="btn btn-return positive-btn pull-right confret" id="abutton"> Approve</a>
            </div>
            </form>

        </div>
    </div>
</div>
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
