<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 40);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 72px;
        font-weight: bold;
        margin: 300px 0 0 55%;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
        width: 85px;
    }

</style>
<script type="text/javascript">
	$(document).ready(function(){
		var d = new Date();

	    m = d.getMonth()+1;

	    y = d.getFullYear();

	});
</script>
<?php $i=1; ?>
<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="remarks-form">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_remarks" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_remarks" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_role_roleId" remarks_role="" >
							<input type="hidden" id="current_status" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>
<div class="overlay" style="display:none;">
    <p><span style="position: relative;" class="all-filter-fa"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')

	<h2>Merchant Master</h2>
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="1200px" id="gridmerchant">
			<thead style="background-color: #FF4C4C; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Merchant&nbsp;ID</th>
					<th class="text-center blarge">Company&nbsp;Name</th>
					{{-- <th class="text-center">Domicile</th> --}}
					{{-- <th class="text-center large">Business&nbsp;Type</th> --}}
					{{-- <th class="text-center">GST</th> --}}
					<th class="text-center medium">O-Shop</th>
				<!--	<th class="text-center no-sort medium">Manager</th>
					<th class="text-center medium no-sort">Statement</th>-->
					{{--<th class="text-center medium">PWD</th>--}}
					<th class="text-center medium" style="background-color:#444;color:#fff">Product</th>
					<th class="text-center medium" style="background-color:#4E2E28;color:#fff">Station</th>
				<!--	 <th class="xlarge text-center"
						style="background-color:#008000;color:#fff">Remarks</th>
					<th class="text-center medium"
						style="background-color:#008000;color:#fff">Status</th>
					<th class="text-center no-sort approv"
						style="background-color:#008000;color:#fff">Approval</th> -->
					<th class="medium text-center"
						style="background-color:#008000;color:#fff">Status</th>	
				</tr>
			</thead>
			<tbody>
				<?php $m = 0; ?>
				@foreach($merchants as $merchant)
				<?php $m++; ?>
				<tr>
					<td class="text-center">
						{{ $m }}
					</td>
					<td class="text-center">
						<!--<a target="_blank" href="{{route('merchantPopup', ['id' => $merchant->id])}}" class="update" data-id="{{ $merchant->id }}">[{{ str_pad($merchant->id, 10, '0', STR_PAD_LEFT) }}]</a>-->
					<a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$merchant->id }}"> 
						{{IdController::nM($merchant->id)}} </a> 
					</td>
					<td class="">
						<?php
							/* Processed note */
							$pfullnote = null;
							$pnote = null;
							$elipsis = "...";
							$pfullnote = $merchant->company_name;
							$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

							if (strlen($pfullnote) > MAX_COLUMN_TEXT)
								$pnote = $pnote . $elipsis;
						?> 
						<span title='{{$pfullnote}}'>{{$pnote}}</span>						
						<input type="hidden" value="{{$merchant->company_name}}" id="mname{{ $merchant->id }}" />
					</td>
					{{-- <td class="text-center">
						@foreach($merchant->address($merchant->country_id)->get() as $address)
						{{$address->name}}
						@endforeach
					</td> --}}
					{{-- <td class="text-center">
						{{ucwords(str_replace('_', ' ', $merchant->business_type))}}
					</td> --}}
					{{-- <td class="text-center">
						{{$merchant->gst}}
					</td> --}}
					<td class="text-center">
						<?php
							$oshop_c = DB::table('oshop')->select('oshop.*')->join('merchantoshop','oshop.id','=','merchantoshop.oshop_id')->where('merchantoshop.merchant_id',$merchant->id)->count();
						?>
						<a rel="{{ $merchant->id }}" target="_blank" class="merchant_oshops" href="{{route('merchantOshops', ['id' => $merchant->id])}}">{{$oshop_c}}</a>
					</td>
				<!--		<td class="text-center">
						<a href="javascript:void(0)" class="mcid" rel="{{IdController::nM($merchant->id)}}" id="{{$merchant->id}}">Details</a>

						@foreach($merchant->mc_id()->get() as $mc_id)
							<input type="hidden" value="{{$merchant->mc_sales_staff_id}}" id="mc{{$merchant->id}}">
						<input type="hidden" value="{{$mc_id->user_id}}" id="mcu{{$merchant->id}}">
						@endforeach
						@foreach($merchant->mc_id_referal()->get() as $mcr_id)
							<input type="hidden" value="{{$merchant->referral_sales_staff_id}}" id="mcref{{$merchant->id}}">
							<input type="hidden" value="{{$mcr_id->user_id}}" id="mcrefu{{$merchant->id}}">
						@endforeach

						@foreach($merchant->mcp1_id()->get() as $mcp1_id)
									<input type="hidden" value="{{$merchant->mcp1_sales_staff_id}}" id="mcp1{{$merchant->id}}">
							<input type="hidden" value="{{$mcp1_id->user_id}}" id="mcp1u{{$merchant->id}}">
						@endforeach
						@foreach($merchant->mcp2_id()->get() as $mcp2_id)
							<input type="hidden" value="{{$merchant->mcp2_sales_staff_id}}" id="mcp2{{$merchant->id}}">
							<input type="hidden" value="{{$mcp2_id->user_id}}" id="mcp2u{{$merchant->id}}">
						@endforeach

					</td>
					<td class="text-center">
						<select class="selectstationchannel" rel="{{$merchant->user_id}}">
							<option value="">Select</option>
							<option value="statement/delivery-order/{{$merchant->user_id}}">Delivery Order</option>
							<option value="statement/receipt/{{$merchant->user_id}}">Receipt</option>
							<option value="{{url()}}/m/" rel="{{$merchant->id}}">Overall Statement</option>
						</select>
					</td>
					 <td style="text-align: center;">
						<?php
						$merchantemail = "";
						try
						{
							$merchantemail=DB::table('users')->where('id',$merchant->user_id)->first()->email;
						}catch(\Exception $e){
							// dd($merchant);
						}
						// if(!is_null($merchant->user()->first())){
						// 	$merchantemail = $merchant->user()->first()->email;
						// }
						$products_m=DB::table('product')->join('merchantproduct','product.parent_id','=','merchantproduct.product_id')->where('merchantproduct.merchant_id',$merchant->id)->whereNull('product.deleted_at')->where('product.segment','b2c')->select('product.*')->orderBy('product.created_at','desc')->count();
						
						$stations_c = DB::table('station')->leftJoin('address','station.station_address_id','=','address.id')->leftJoin('city','address.city_id','=','city.id')->leftJoin('area','address.area_id','=','area.id')->leftJoin('state','state.code','=','city.state_code')->leftJoin('country','country.code','=','state.country_code')->join('users','users.id','=','station.user_id')->join('autolink','autolink.initiator','=','users.id')->where('autolink.responder',$merchant->id)->where('autolink.status','linked')->select('station.*','city.name as cityname','area.name as areaname','state.name as statename','country.name as countryname')->distinct()->count();
						?>
						<a rel="{{ $merchantemail }}" class="pwd_reset" href="javascript:void(0)">Reset</a>
					</td> -->
					<td style="text-align: center;">
						<a rel="{{ $merchant->id }}" target="_blank" class="product_network" href="{{route('ProductM', ['id' => $merchant->id])}}">{{$products_m}}</a>
					</td>
					<td style="text-align: center;">
						<a rel="{{ $merchant->id }}" target="_blank" class="station_network" href="{{route('merchantNetwork', ['id' => $merchant->id])}}">{{$stations_c}}</a>
					</td>
<!--
					<td id="remarks_column" class="">
						<?php
							$remark = DB::table('remark')
							->select('remark')
							->join('merchantremark','merchantremark.remark_id','=','remark.id')
							->where('merchantremark.merchant_id',$merchant->id)
							->orderBy('remark.created_at', 'desc')
							->first();

 							/* Processed remark */
							$pfullremark = null;
							$premark = null;

							if ($remark) {
								$elipsis = "...";
								$pfullremark = $remark->remark;
								$premark = substr($pfullremark,0, MAX_COLUMN_TEXT);

								if (strlen($pfullremark) > MAX_COLUMN_TEXT)
									$premark = $premark . $elipsis;
							}
						?>
						<a href="javascript:void(0)" id="mcrid_{{$merchant->id}}"
							class="mcrid" rel="{{$merchant->id}}">
							<span title='{{$pfullremark}}'>{{$premark}}</span>
						</a>
					</td>
					<td id="status_column" class="text-center">
						<span id="status_column_text">
							{{ucfirst($merchant->status)}}
						</span>
					</td>
					<td>
						<div class="action_buttons">
							<?php
							$approve = new Classes\Approval('merchant', $merchant->id);
							if ($merchant->status == 'active') {
								$approve->getSuspendButton();
							} else if ($merchant->status == 'suspended' || $merchant->status == 'rejected') {
								$approve->getReactivateButton();
							}
							echo $approve->view;
							?>
						</div>
					</td> -->
					<td class="text-center">
						<a class="approval_details" rel="{{ $merchant->id }}" target="_blank"  href="{{route('merchantApproval', ['id' => $merchant->id])}}">{{ucfirst($merchant->status)}}</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<br>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Account Manager</h4>
            </div>
            <div class="modal-body">
				<h3 id="modal-Tittle1"></h3>
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div id="admindialog" title="Reset Password" style="display:none">
	<p>Enter new password</p>
	<input type="password" id="user_pass" size="25" />
	<input type="hidden" id="useraid" value="0" />
	<p>Confirm new password</p>
	<input type="password" id="user_passc" size="25" />
	<input type="button" id="change_password" class="btn btn-primary" value="Reset" style="margin-top: 10px;">
	<p style="color: red; display: none;" id="wrong_pass" style="margin-top: 10px;">Passwords don't match.</p>
	<p style="color: green; display: none;" id="sucess_pass" style="margin-top: 10px;">Password successfully changed!</p>
</div>
{{-- Modal --}}
<div id="srconfirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Attention!</h4>
      </div>
      <div class="modal-body">
        <p>Suspension of an account means a merchant will NOT be able to conduct business online anymore. Do you still want to suspend?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      	<button type="button" class="btn btn-warning" id="srconfirm">Yes</button>
      </div>
    </div>

  </div>
</div>
{{--  --}}
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
	 $('.hover-long-text').tooltip();
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

			$('.pwd_reset').click(function () {
				var userid = $(this).attr("rel");
				
				var formData = {
					email: userid
				}	;	

				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/forgot_password",
					data:formData,
					success: function (data) {
						toastr.info(data);
						toastr.info("Password successfully sent!");
					},
					error: function (error) {
						toastr.warning("Password could not be changed!");
						console.log(error);
					}

				});				
			});

			$(document).delegate( '#sendmail', "click",function (event) {
				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/sendmail",
					dataType: 'json',
					success: function (data) {
						console.log(data);
					},
					error: function (error) {
						console.log(error);
					}

				});
			});



			 $(document).delegate( '#change_password', "click",function (event) {
				//console.log("passs");
				var userid = $("#useraid").val();
				var password = $("#user_pass").val();
				var cpassword = $("#user_passc").val();
			 if(password == cpassword){
					var formData = {
						userid: userid,
						password: password
					}
					$.ajax({
						type: "POST",
						url: JS_BASE_URL + "/changepassword",
						data: formData,
						dataType: 'json',
						success: function (data) {
							$("#sucess_pass").show();
							setTimeout(function(){
								$("#user_pass").val("");
								$("#sucess_pass").hide();
								$("#admindialog").dialog("close");
							}, 3000);
						},
						error: function (error) {
							console.log(error);
						}

					});
				} else {
					$("#wrong_pass").show();
					setTimeout(function(){
						$("#wrong_pass").hide();
					}, 4000);
				}
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
 
		var page=$('#product_pagination_page').val();
		var product_dtable=$('#product_details_table').DataTable({
			"serverSide":true,
			"processing":true,
			"paging":true,
			"searching":{"regex":true},
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/delivery",
				dataSrc:function(json){
				
					var return_data=new Array();
					subcat_pids=[];
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						return_data.push({
							'id': i+1,
							'date':d.date,
							'did':d.delivery_id,
							'deliveryorder':"<a href='"+JS_BASE_URL+"/deliveryorder/"+d.id+"' target='_blank'>"+d.porder_id+"</a>",
							'sid':d.seller_id,
							'consignment':d.cn,
							'nfee':js_number_format(parseInt(d.nfee)/100,2,".",""),
							'info':'<a href="javascript:void(0)" class="apopup" rel="'+d.cn+'" rel-type="all">Info</a>',
							'status':ucfirst(d.status)

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'delivery.created_at',className:'text-center no-sort'},
				{data:"date",name:'date',className:'text-center'},
				{data:"did",name:'did',className:'text-center'},
				{data:"deliveryorder",name:'deliveryorder',className:'text-center no-sort'},
				{data:"sid",name:'sid',className:'text-center'},
				{data:"consignment",name:'consignment',className:'text-center'},
				{data:"nfee",name:'nfee',className:'text-center'},
				{data:"info",name:'info',className:'text-center'},
				{data:"status",name:'status',className:'text-center'}

			]
		});

            $('#product_details_table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(tr) ).show();
                    tr.addClass('shown');
                }
            } );

    function removeMessage() {
        $('.removeable').fadeOut(7000);
//            $('.removeable').remove();
    }
    setTimeout(removeMessage, 2000);

    // $(".mcrid").click(function () {
    $(document).delegate( '.mcrid', "click",function (event) {
		_this = $(this);
		var id_merchant= _this.attr('rel');

		$('#modal-Tittle2').html("Remarks");

		var url = '/admin/master/merchant_remarks/'+ id_merchant;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th class='text-center'>No</th><th class='text-center'>Merchant&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					html += "<tr>";
					html += "<td class='text-center'>"+(i+1)+"</td>";
					html += "<td class='text-center'><a href='../../admin/popup/merchant/"+id_merchant+"' class='update' data-id='"+id_merchant+"'>["+pad(id_merchant.toString(),10)+"]</a></td>";
					html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
					html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
					html += "<td>"+obj.remark+"</td>";
					html += "<td class='text-center'>"+obj.created_at+"</td>";
					html += "</tr>";
				}
				html = html + "</table>";
				$('#myBody2').html(html);
				$("#myModal2").modal("show");
			}
		});
	});

    $(document).delegate( '.mcrid', "click",function (event) {
		_this = $(this);
		var id_merchant= _this.attr('rel');

		$('#modal-Tittle2').html("Remarks");

		var url = '/admin/master/merchant_remarks/'+ id_merchant;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th class='text-center'>No</th><th class='text-center'>Merchant&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					html += "<tr>";
					html += "<td class='text-center'>"+(i+1)+"</td>";
					html += "<td class='text-center'><a href='../../admin/popup/merchant/"+id_merchant+"' class='update' data-id='"+id_merchant+"'>["+pad(id_merchant.toString(),10)+"]</a></td>";
					html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
					html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
					html += "<td>"+obj.remark+"</td>";
					html += "<td class='text-center'>"+obj.created_at+"</td>";
					html += "</tr>";
				}
				html = html + "</table>";
				$('#myBody2').html(html);
				$("#myModal2").modal("show");
			}
		});
	});

		$(document).delegate( '.mcid', "click",function (event) {

        $('#modal-Tittle').html("");
        $('#modal-Tittle1').html("");
        $('#myTable').empty();
        _this = $(this);

        var id_merchant= _this.attr('id');
        var id_merchant_n= _this.attr('rel');
        var mname= $('#mname' + id_merchant).val();
		var url = '/admin/master/getmerchantmngrs/'+id_merchant;

		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
			//	console.log(data);
				var mc = "";
				var mcref = "";
				var mp1 = "";
				var mp2 = "";

				var mcselect = '<select style="display:none;" class="mymerselect" id="mcsel"><option value="0">None Selected</option>';
				var mcrefselect = '<select style="display:none;" class="mymerselect" id="mcrefsel"><option value="0">None Selected</option>';
				mcsobj = data.mcs;
				for(i=0;i<mcsobj.length;i++){
					var selected = "";
					var selectedref = "";
					if(mcsobj[i].id == data.mc){
						selected = "SELECTED"
					}
					if(mcsobj[i].id == data.mcref){
						selectedref = "SELECTED"
					}
					mcselect = mcselect + '<option value="' + mcsobj[i].id + '" '+selected+'>'+mcsobj[i].first_name+ ' ' + mcsobj[i].last_name +'</option>';
					mcrefselect = mcrefselect + '<option value="' + mcsobj[i].id + '" '+selectedref+'>'+mcsobj[i].first_name+ ' ' + mcsobj[i].last_name +'</option>';
				}
				mcselect = mcselect + '</select>';
				mcrefselect = mcrefselect + '</select>';

				var mp1select = '<select style="display:none;" class="mymerselect" id="mp1sel"><option value="0">None Selected</option>';
				var mp2select = '<select style="display:none;" class="mymerselect" id="mp2sel"><option value="0">None Selected</option>';
				mpsobj = data.mps;
				for(i=0;i<mpsobj.length;i++){
					var selected = "";
					var selected2 = "";
					if(mpsobj[i].id == data.mp1){
						selected = "SELECTED"
					}
					if(mpsobj[i].id == data.mp2){
						selected2 = "SELECTED"
					}
					mp1select = mp1select + '<option value="' + mpsobj[i].id + '" '+selected+'>'+mpsobj[i].first_name+ ' ' + mpsobj[i].last_name +'</option>';
					mp2select = mp2select + '<option value="' + mpsobj[i].id + '" '+selected2+'>'+mpsobj[i].first_name+ ' ' + mpsobj[i].last_name +'</option>';
				}
				mp1select = mp1select + '</select>';
				mp2select = mp2select + '</select>';

				$('#myTable').append('<tbody><tr><td class="text-center">'+mcselect+'</td><td class="text-center">'+mcrefselect+'</td><td class="text-center">'+mp1select+'</td><td class="text-center">'+mp2select+'</td><td class="text-center"><a class="btn btn-primary mymerselect btn-save" href="javascript:void(0)" rel="'+ id_merchant +'" > Save</a></td></tr></tbody>');

				
				$("#mcsel").select2();
				$("#mcrefsel").select2();
				$("#mp1sel").select2();
				$("#mp2sel").select2();
				$("#mcsel").hide();
				$("#mcrefsel").hide();
				$("#mp1sel").hide();
				$("#mp2sel").hide();				
				$(".mer_edit").click(function(){
					_this = $(this);
					var mer_id= _this.attr('rel');
					_this.hide();
					$(".mymerlink").hide();
					$(".mymerselect").show();
				});

				$(".btn-save").click(function(){
					$(".btn-save").text("Saving...");
					_this = $(this);
					var mer_id= _this.attr('rel');
					if($("#mcsel").val() != data.mc){
						var url = '/admin/master/setmerchantmngrs/'+ mer_id;
							$.ajax({
							  url: url,
							  type: "post",
							  data: {'ssid': $("#mcsel").val(), 'column': 'mc_sales_staff_id'},
							  success: function(data){
								  console.log(data);
							}
						});
					}
					if($("#mcrefsel").val() != data.mcref){
						var url = '/admin/master/setmerchantmngrs/'+ mer_id;
							$.ajax({
							  url: url,
							  type: "post",
							  data: {'ssid': $("#mcrefsel").val(), 'column': 'referral_sales_staff_id'},
							  success: function(data){
								  console.log(data);
							}
						});
					}
					if($("#mp1sel").val() != data.mp1){
						var url = '/admin/master/setmerchantmngrs/'+ mer_id;
							$.ajax({
							  url: url,
							  type: "post",
							  data: {'ssid': $("#mp1sel").val(), 'column': 'mcp1_sales_staff_id'},
							  success: function(data){
								  console.log(data);
							}
						});
					}
					if($("#mp2sel").val() != data.mp2){
						var url = '/admin/master/setmerchantmngrs/'+ mer_id;
							$.ajax({
							  url: url,
							  type: "post",
							  data: {'ssid': $("#mp2sel").val(), 'column': 'mcp2_sales_staff_id'},
							  success: function(data){
								  console.log(data);
							}
						});
					}
					$(".btn-save").text("Save");
					$("#myModal").modal("hide");
					//location.reload();
				});
			},
			error: function (error) {
				console.log(error);
			}
		});
	
        $('#modal-Tittle1').append("Merchant Name: "+mname);
        $('#modal-Tittle').append("Merchant ID: "+id_merchant_n);
        $('#myTable').append("<thead style='background-color: #FF4C4C; color: #fff;'><th class='text-center'>MC ID</th><th class='text-center'>MC ID (Referal)</th><th class='text-center'>MP1&nbsp;ID</th><th class='text-center'>MP2&nbsp;ID</th><th class='text-center'>Edit</th></thead>");


        $("#myModal").modal("show");
    });

    $(".selectstationchannel").change(function()
    {	
    	var mid=$(this).attr("rel");
        var url = $(this).val()+m+"/"+y+"/"+mid;
        window.open(url);
    });
	$(window).resize();
});

$('.view-merchant-modal').click(function(){

var id=$(this).attr('data-id');
var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+id;
$.ajax({
	url:check_url,
	type:'GET',
	success:function (r) {
	console.log(r);
	
	if (r.status=="success") {
	var url=JS_BASE_URL+"/admin/popup/merchant/"+id;
		var w=window.open(url,"_blank");
		w.focus();
	}
	if (r.status=="failure") {
	var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
	$('#merchant-error-messages').html(msg);
	}
	}
	});
});

window.setInterval(function(){
              $('#merchant-error-messages').empty();
            }, 10000);


</script>
@yield("left_sidebar_scripts")
@stop
