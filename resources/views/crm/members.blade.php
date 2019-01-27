@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
/* 
$channels = array(
	array('id'=> 1, 'description' => 'Email', 'checked' => true),
	array('id'=> 2, 'description'=> 'SMM Army', 'checked' => true));
*/
?>
@section("content")
<style>
	.storebutton{
		background-color: #FF3333 !important;
	}
</style>
<section class="">
  <div class="container">
  @include('admin/panelHeading')
	<div class="row">
	<div class="col-sm-12">  
	{{-- Tabbed Nav --}}
	<div class="panel with-nav-tabs panel-default ">
		<div class="panel-heading">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#customers" data-toggle="tab">Customer</a></li>
				<li><a href="#employees" data-toggle="tab">Employee</a></li>	
			</ul>
		</div>
	</div>	
	{{--ENDS  --}}
	<div id="dashboard" class="row panel-body " >
		<div class="tab-content top-margin" style="margin-top:-30px">
			<!-- CUSTOMER LIST -->
			<div id="customers" class="tab-pane fade in active">
				<div class="row">
					<div class=" col-sm-6">
						<h2>Customer List</h2>
					</div>
					<div class=" col-sm-6">
						<a class="add_row_c btn btn-info pull-right" style="margin-left: 5px; width: 120px;"
							href="javascript:void(0)">+ Customer</a>&nbsp;
						<a class=" btn btn-danger pull-right" style="margin-left: 5px; width: 120px;"
							href="{{URL::to('/')}}/admin/member/campaign"> Campaign</a>&nbsp;
						<a class="channel_managment btn btn-info pull-right" 
							style="margin-left: 5px; width: 120px; background-color: #948A54 
							!important; border-color: #948A00 !important"
							href="javascript:void(0)">+ Channel</a>&nbsp;
						<a class="segment_managment btn btn-info pull-right"
							style="margin-left: 5px; width: 120px; background-color: #595959 !important; border-color: #696969 !important"
							href="javascript:void(0)">+ Segment</a>&nbsp;

						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>
				<?php $e=1;?>
				<div class="row">
					<div class=" col-sm-12">
						<table class="table table-bordered"
							id="customer-table" width="100%">
							<thead>
							
							<tr class="bg-black">
								<th class="text-center bsmall">No.</th>
								<th class="text-center">Customer&nbsp;ID</th>
								<th class="large text-center" style="width: 130px !important;">Name</th>
								<th class="text-center">Roles</th>
								<th  style="background-color: #31859C;" class="text-center">Info</th>
								<th class="text-center">Campaign</th>
								<th  style="background-color: green;" class="text-center">Status</th>
								<th class="text-center">Email</th>
								<th class="bsmall text-center">
									<input type='checkbox' class='allsender_c' />
								</th>
								<th class="bsmall text-center">&nbsp;</th>
								<th class="bsmall text-center">&nbsp;</th>
							</tr>
							</thead>
							<tfoot>
								<tr>
									<th colspan=7 ></th>
									<th colspan=4 >
										@if($campaignexists)
											<a class="send_email_c btn btn-danger storebutton"
											style="width:100%"
											href="javascript:void(0)">Execute</a>
											<p align="center" class="nocampaign" style="display: none;">Please, create a new campaign</p>
										@else
											<p align="center">Please, create a new campaign</p>
										@endif
									</th>
								</tr>
							</tfoot>					
							<tbody>
							@foreach($customers as $emps)
								<tr>
									<td class="text-center">{{$e}}</td>
									<td class="text-center">
										<?php $formatted_buyer_id =
											IdController::nB($emps->user_id); ?>
										
										@if($emps->user_id > 0)
											{{$formatted_buyer_id}}
										@endif
										
									</td>
									<td class="text-center"> 
									<?php
									/* Processed note */
									$pfullnote = null;
									$pnote = null;
									$elipsis = "...";
									if($emps->name == "" || is_null($emps->name)){
										$pfullnote = $emps->users_first_name ." ".
										$emps->users_last_name;
									} else {
										$pfullnote = $emps->name;
									}
										
									$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

									if (strlen($pfullnote) > MAX_COLUMN_TEXT)
										$pnote = $pnote . $elipsis;
									?> 
									<span title='{{$pfullnote}}' class="customer_name" id="customer_name{{$emps->id}}" rel="{{$emps->id}}">&nbsp;&nbsp;{{$pnote}}&nbsp;&nbsp;</span>	
									<span id="sinputcustomer_name{{$emps->id}}" style="display: none;">
										<input type="text" value="{{$pfullnote}}" rel="{{$emps->id}}" class="customer_name_input" id="inputcustomer_name{{$emps->id}}" />
									</span>	
									</td>
									<?php
									$sysrole = "";
									$pursel = "";
									$memsel = "";
									$ebusel = "";
									$sysquery = DB::table('roles')->
										join('role_users','roles.id','=',
											'role_users.role_id')->
										where('role_users.user_id',$emps->user_id)->
										whereIn('roles.id',[15,18,20])->
										first();

									if(!is_null($sysquery)){
										if($sysquery->name == 'purchaser'){
											$pursel = "selected";
										}
										if($sysquery->name == 'member'){
											$memsel = "selected";
										}
										if($sysquery->name == 'emp_benefit_user'){
											$ebusel = "selected";
										}
										$sysrole = $sysquery->description;
									}
									?>
									<td class="text-center">
										@if($emps->user_id == 0)
										@else
											<a href="javascript:void(0)" class="customer_role" rel="{{$emps->user_id}}">Roles</a>
										@endif
									</td>									
									<td class="text-center" rel="{{$emps->id}}">	
										
										<a href="javascript:void(0)" class="customer_segment" rel="{{$emps->id}}">
											Details
										</a>
									</td>
									<td class="text-center">
										<a href="javascript:void(0)" class="customer_campaign" rel="{{$emps->id}}">{{$emps->countcamp}}</a>
									</td>
									<td class="text-center">
											{{ucfirst($emps->member_status)}}
									</td>
									<td class="text-center">{{$emps->email}}</td>
									<td class="text-center">
										<input type='checkbox' class='sender_c'
										rel='{{$emps->email}}' /></td>
									<td class="text-center">
										<a  href="javascript:void(0);" class="text-danger delete_member_c" rel='{{$emps->email}}'><i class="fa fa-minus-circle fa-2x"></i></a>
									</td>	
									<td class="text-center" id="segmentcontent{{$emps->id}}">{{$emps->segments}}</td>
								</tr>
							<?php $e++;?>
							@endforeach
							</tbody>
						</table>
						<input type="hidden" value="{{$e}}" id="nume_c" /> 
					</div>
				</div> 				
			</div>
			<div id="employees" class="tab-pane fade">
				<div class="row">
					<div class=" col-sm-6">
						<h2>Employee List </h2>
					</div>
					<div class=" col-sm-6">
						<a class="add_row btn btn-info pull-right" style="width: 120px;"
							href="javascript:void(0)">+ Employee</a>

					</div>
				</div>
				<?php $e=1;?>
				<div class="row">
					<div class=" col-sm-12">
						<table class="table table-bordered"
							id="employee-table" width="100%">
							<thead>
							
							<tr class="bg-black">
								<th class="text-center bsmall">No.</th>
								<th class="text-center">Employee&nbsp;ID</th>
								<th class="large text-center" style="width: 130px !important;">Name</th>
								<th class="text-center">Roles</th>
								<th  style="background-color: #31859C;" class="text-center">Info</th>
								<th  style="background-color: #558ED5;" class="text-center">SMM&nbsp;Army</th>
								<th  style="background-color: green;" class="text-center">Status</th>
								<th class="text-center">Email</th>
								<th class="bsmall text-center">
									<input type='checkbox' class='allsender' />
								</th>
								<th class="bsmall text-center">&nbsp;</th>
							</tr>
							</thead>
							<tfoot>
								<tr>
									<th colspan=7 ></th>
									<th colspan=3 >
										<a class="send_email btn btn-danger storebutton"
											style="width:100%"
											href="javascript:void(0)">Execute</a>
									</th>
								</tr>
							</tfoot>					
							<tbody>
							@foreach($members as $emps)
								<tr>
									<td class="text-center">{{$e}}</td>
									<td class="text-center">
										<?php $formatted_buyer_id =
											IdController::nB($emps->user_id); ?>
										@if(Auth::user()->hasRole('adm'))
											<a target="_blank"
											href="{{route('employeeOsmall',
												['id' => $emps->user_id])}}">
												<span id="status_column_text">
													{{$formatted_buyer_id}}
												</span>
											</a>
										@else
											{{$formatted_buyer_id}}
										@endif
										</a> 
									</td>
									<td class=""> 
									<?php
									/* Processed note */
									$pfullnote = null;
									$pnote = null;
									$elipsis = "...";
									if($emps->name == "" || is_null($emps->name)){
										$pfullnote = $emps->users_first_name ." ".
										$emps->users_last_name;
									} else {
										$pfullnote = $emps->name;
									}
										
									$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

									if (strlen($pfullnote) > MAX_COLUMN_TEXT)
										$pnote = $pnote . $elipsis;
									?> 
									<span title='{{$pfullnote}}' class="customer_name" id="customer_name{{$emps->id}}" rel="{{$emps->id}}">&nbsp;&nbsp;{{$pnote}}&nbsp;&nbsp;</span>	
									<span id="sinputcustomer_name{{$emps->id}}" style="display: none;">
										<input type="text" value="{{$pfullnote}}" rel="{{$emps->id}}" class="customer_name_input" id="inputcustomer_name{{$emps->id}}" />
									</span>	
									</td>
									<?php
									$sysrole = "";
									$pursel = "";
									$memsel = "";
									$ebusel = "";
									$sysquery = DB::table('roles')->
										join('role_users','roles.id','=',
											'role_users.role_id')->
										where('role_users.user_id',$emps->user_id)->
										whereIn('roles.id',[15,18,20])->
										first();

									if(!is_null($sysquery)){
										if($sysquery->name == 'purchaser'){
											$pursel = "selected";
										}
										if($sysquery->name == 'member'){
											$memsel = "selected";
										}
										if($sysquery->name == 'emp_benefit_user'){
											$ebusel = "selected";
										}
										$sysrole = $sysquery->description;
									}
									?>
									<td class="text-center">
										@if($emps->status == 'not exists')
										@else
											<a href="javascript:void(0)" class="member_role" rel="{{$emps->user_id}}">Roles</a>
										@endif
									</td>
									<td class="text-center"><a href="javascript:void(0)" class="member_info">Info</a></td>
									<td class="text-center">
										<a href="javascript:void(0)" class="member_smm smmarmy_exposer" rel="{{$emps->user_id}}">{{$emps->connections or '0'}}</a>
									</td>
									<td class="text-center">
										{{ucfirst($emps->status)}}
									</td>
									<td class="text-center">{{$emps->email}}</td>
									<td class="text-center">
										<input type='checkbox' class='sender'
										rel='{{$emps->email}}' /></td>
									<td class="text-center">
										<a  href="javascript:void(0);" class="text-danger delete_member" rel='{{$emps->email}}'><i class="fa fa-minus-circle fa-2x"></i></a>
									</td>	
								</tr>
							<?php $e++;?>
							@endforeach
							</tbody>
						</table>
						<input type="hidden" value="{{$e}}" id="nume" /> 
				</div>
				</div>    
			</div>    
			</div>    
			</div>
	</div>
	</div>
 </div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
					data-dismiss="modal" aria-label="Close"><span
					aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Roles</h4>
            </div>
            <div class="modal-body">
                <div id="myBody">
					@foreach($memberroles as $memberrole)
						<p><input type="checkbox" class="memberchek"
						rel="{{$memberrole->id}}"/>
						{{$memberrole->description}}</p>
					@endforeach
					<a class='btn btn-primary saveroles pull-right'
					href='javascript:void(0)' > Save</a>
					<br>
					<br>
					<input type="hidden" value="0" id="user_idrole" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="myModalSegment" role="dialog"
	aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
					data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Segments</h4>
            </div>
            <div class="modal-body">
                <div id="myBodySegmentCus">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="myModal_c" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
					data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Roles</h4>
            </div>
            <div class="modal-body">
                <div id="myBody">
					@foreach($customerroles as $customerrole)
						<p><input type="checkbox" class="customercheck"
						rel="{{$customerrole->id}}"/>
						{{$customerrole->description}}</p>
					@endforeach
					<a class='btn btn-primary saveroles_c pull-right'
						href='javascript:void(0)' > Save</a>
					<br>
					<br>
					<input type="hidden" value="0" id="user_idrole_c" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<div class="modal fade" id="myModalSegmentChange" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Segments</h4>
            </div>
            <div class="modal-body">
                <div id="myBodySegment">
					
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<div class="modal fade" id="myModalChannel" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Channels</h4>
            </div>
            <div class="modal-body">
                <div id="myBodyChannel">
					@foreach($channels as $channel)
						<?php
							$channelchecked = "";
							if($channel['checked']){
								$channelchecked = "checked";
							}
						?>
						<div class="row" id="channel{{$channel['id']}}">
							<div class="col-sm-12">
								<input type="checkbox"
								class="channel_desc" 
								name="channels"
								value="{{$channel['id']}}"
									{{$channelchecked}} />&nbsp;<b>
								{{$channel['description']}}</b>
							</div>	
							<div class="clearfix"></div>
						</div>	
					@endforeach				
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
				class="btn btn-default save_channel"
				>
				Save</button>
            </div>
            </form>

        </div>
    </div>
</div> 


<div class="modal fade" id="myModalCustCamp" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Customer Campaings</h4>
            </div>
            <div class="modal-body">
                <div id="myBodyCustCamp">
					
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<div class="modal fade" id="myModalTemplate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTemplate">Campaign Template</h4>
            </div>
            <div class="modal-body">
                <div id="myBodyTemplate">
					
                </div>
				<div class="clearfix">
				</div>
				<a class='btn btn-primary send_email_c_def pull-right' href='javascript:void(0)' > Send Campaign </a>
				<div class="clearfix">
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="myModalSMM" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">SMM Army</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" width="100%" id="smm_army_table">
					<thead>				
						<tr style="background-color: #558ed5; color: white;">
							<th class="text-center" style="width: 20px;">No</th>
							<th class="large text-center" style="width: 130px !important;">Name</th>
							<th class="text-center">Exposure</th>
						</tr>
					</thead>
					<tbody id="smmarmy_exposer">
					</tbody>
				</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
</section>
<script type="text/javascript">
	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	
	
    $(document).ready(function(){
		$(document).delegate( '.customer_name', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#sinputcustomer_name" + id).show();
		});		
		
		$(document).delegate( '.customer_name_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			$.ajax({
				type: "POST",
				data: {data: value},
				url: "/seller/osmallmember/name/" + id,
				dataType: 'json',
				success: function (data) {
					$("#sinputcustomer_name" + id).hide();
					$("#customer_name" + id).html(value);
					$("#customer_name" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});			
		
		$(document).delegate( '.delete_segment', "click",function (event) {
			var id = $(this).attr('rel');
			$.ajax({
				type: "POST",
				data: {id: id},
				url: JS_BASE_URL+ "/seller/osmallsegment/delete",
				dataType: 'json',
				success: function (data) {
					if(data.status == "success"){
						toastr.info("Segment successfully deleted");
						$("#segment" + id).remove();
					} else {
						toastr.error("You cannot delete this Segment, one or more members are tagged");
					}
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
		$(document).delegate( '.add_segment', "click",function (event) {
			$("#inputsegmentnew").show();
		});
		$(document).delegate( '#inputsegmentnew', "blur",function (event) {
			var description = $("#inputsegmentnew").val();
			if(description == ""){
				toastr.warning("Segment name cannot be empty");
			} else {
				$.ajax({
					type: "POST",
					data: {description: description},
					url: JS_BASE_URL+ "/seller/osmallsegment/add",
					dataType: 'json',
					success: function (data) {
						if(data.status == 'success'){
							toastr.info("Segment successfully added!");
							console.log(data.html);
							$("#newsegments").append(data.html);
							$("#inputsegmentnew").val("");
							$("#inputsegmentnew").hide();
						} else {
							toastr.warning("Segment name cannot be the same as other segment!");
						}
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});		
			}			
		});

		$(document).delegate( '.segment_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			if(value == ""){
				toastr.warning("Segment name cannot be empty");
			} else {
				$.ajax({
					type: "POST",
					data: {data: value},
					url: JS_BASE_URL+ "/seller/osmallsegment/name/" + id,
					dataType: 'json',
					success: function (data) {
						if(data.status == 'success'){
							$("#inputsegment" + id).hide();
							$("#spansegment" + id).html(value);
							$("#spansegment" + id).show();
						} else {
							toastr.warning("Segment name cannot be the same as other segment!");
						}
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});	
			}			
		});	
		$(document).delegate( '.segment_name', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#inputsegment" + id).show();
		});			
		
		$(document).delegate( '.saveroles_c', "click",function (event) {
			var obj = $(this);
			obj.html('Saving...');
			var userid = $("#user_idrole_c").val();
			/*var isstaff = 0;
			var isadmin = 0;
			if($('#staff').prop('checked')){
				isstaff = 1;
			}
			if($('#adminstaff').prop('checked')){
				isadmin = 1;
			}*/
			var data={};
			var countdata = 0
			$('.customercheck').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
            });
			console.log(data);
			$.ajax({
				type: "POST",
				data: {data: data},
				url: "/admin/member/rolescust/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					toastr.info('Roles successfully changed!');
					obj.html('Save');
					$("#user_idrole_c").val(userid);
					$("#myModal_c").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
		
		$(document).delegate( '.savesegments', "click",function (event) {
			var obj = $(this);
			obj.html('Saving...');
			var userid = $("#user_idrolesegment").val();
			var data={};
			var countdata = 0
			$('.customersegment').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
            });
			console.log(data);
			$.ajax({
				type: "POST",
				data: {data: data},
				url: JS_BASE_URL+ "/seller/osmallmember/segment/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					
					obj.html('Save');
					segmentspan='#segmentcontent'+userid;
					console.log($(segmentspan));
					$(segmentspan).empty();
					$(segmentspan).append(data.description);
					$("#user_idrolesegment").val(userid);
					$("#myModalSegment").modal('toggle');
					toastr.info('Segment successfully changed!');
					// console.log(cust_table);
					cust_table.cell(segmentspan).data(data.description).draw();
					// cust_table.rows().invalidate().draw();
					/*zxcv*/ 
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
		
		/*$(document).delegate( '.customersegment', "click",function (event) {
			console.log("CHECKED");
			$(".customersegment").prop('checked',false);
			$(this).prop('checked',true);
		})*/
		$(document).delegate( '.customer_campaign', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+"/admin/member/campaings/"+ userid,
				success: function (data) {
					$("#myBodyCustCamp").empty();
					$("#myBodyCustCamp").html(data);
					$("#myModalCustCamp").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});				
		});
		
		$(document).delegate( '.customer_segment', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+ "/seller/osmallmember/segment/" + userid,
				success: function (data) {
					$("#myBodySegmentCus").html(data);
					$("#myModalSegment").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});
		
		$(document).delegate( '.customer_role', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+ "/admin/member/rolescust/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data.asroles);
					var roles = data.asroles;
					if (typeof roles != 'undefined'){
						$.each(roles, function(index, value) {
							//console.log(index);
							//console.log(value);
							if(value == 1){
								$(".customercheck[rel="+index+"]").prop('checked',true);
							} else {
								$(".customercheck[rel="+index+"]").prop('checked',false);
							}
						}); 
					}
					$("#user_idrole_c").val(userid);
					$("#myModal_c").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});			
		
		var emp_table = $('#employee-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "180px" },
					{ "width": "80px" },
					{ "width": "80px" },
					{ "width": "180px" },
					{ "width": "180px" },
					{ "width": "180px" },
					{ "width": "20px", "orderable": false },
					{ "width": "20px", "orderable": false },
				]
			});		

		var cust_table = $('#customer-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "180px" },
					{ "width": "80px" },
					{ "width": "80px" },
					{ "width": "180px" },
					{ "width": "180px" },
					{ "width": "180px" },
					{ "width": "20px", "orderable": false },
					{ "width": "20px", "orderable": false },
					{ "width": "0px","visible":false},
				],
			"drawCallback": function( settings ) {
			        // alert( 'DataTables has redrawn the table' );
			    }
			});	
			
		$(document).delegate( '.allsender', "click",function (event) {
			if($(this).prop('checked')){
				$(".sender").prop('checked',true);
			} else {
				$(".sender").prop('checked',false);
			}
		});
		
		$(document).delegate( '.allsender_c', "click",function (event) {
			if($(this).prop('checked')){
				$(".sender_c").prop('checked',true);
			} else {
				$(".sender_c").prop('checked',false);
			}
		});
		
		$(document).delegate( '.saveroles', "click",function (event) {
			var obj = $(this);
			obj.html('Saving...');
			var userid = $("#user_idrole").val();
			/*var isstaff = 0;
			var isadmin = 0;
			if($('#staff').prop('checked')){
				isstaff = 1;
			}
			if($('#adminstaff').prop('checked')){
				isadmin = 1;
			}*/
			var data={};
			var countdata = 0
			$('.memberchek').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
            });
			console.log(data);
			$.ajax({
				type: "POST",
				data: {data: data},
				url: JS_BASE_URL+ "/admin/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					toastr.info('Roles successfully changed!');
					obj.html('Save');
					$("#user_idrole").val(userid);
					$("#myModal").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
	
		$(document).delegate( '.member_role', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+ "/admin/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data.asroles);
					var roles = data.asroles;
					if (typeof roles != 'undefined'){
						$.each(roles, function(index, value) {
							//console.log(index);
							//console.log(value);
							if(value == 1){
								$(".memberchek[rel="+index+"]").prop('checked',true);
							} else {
								$(".memberchek[rel="+index+"]").prop('checked',false);
							}
						}); 
					}
					$("#user_idrole").val(userid);
					$("#myModal").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});	
		
		$(document).delegate( '.delete_member', "click",function (event) {
			var r = confirm("Are you sure you want to delete this member?");
			if (r == true) {
				var obj = $(this);
				var email = $(this).attr('rel');
				$.ajax({
					type: "POST",
					data: {email: email},
					url: JS_BASE_URL+ "/admin/member/delete",
					dataType: 'json',
					success: function (data) {
						emp_table
							.row( obj.parents('tr') )
							.remove()
							.draw();
						toastr.info("Employee successfully deleted!");
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});
			} else {
				//Nothing to do here
			}
		} );	

		$(document).delegate( '.delete_member_c', "click",function (event) {
			console.log("HI");
			var r = confirm("Are you sure you want to delete this customer?");
			if (r == true) {
				var obj = $(this);
				var email = $(this).attr('rel');
				var lpid = $("#lpeid").val();
				$.ajax({
					type: "POST",
					data: {email: email},
					url: JS_BASE_URL+ "/admin/member/delete",
					dataType: 'json',
					success: function (data) {
						cust_table
							.row( obj.parents('tr') )
							.remove()
							.draw();
						toastr.info("Customer successfully deleted!");
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});
			} else {
				//Nothing to do here
			}
		} );		
	
		
		$(document).delegate( '.channel_managment', "click",function (event) {
			$("#myModalChannel").modal('show');
		});
		
		$(document).delegate( '.add_row', "click",function (event) {
			var e = parseInt($("#nume").val());
				var rowNode = emp_table.row.add( [ "<p align='center'>" + e + "</p>", "<p align='center' id='usera"+e+"'></p> ","<p align='center' id='username"+e+"'></p>", "<p align='center' id='userrole"+e+"' rel='"+e+"'></p>", "<p align='center' id='userinfo"+e+"'></p>", "<p align='center' id='usersmm"+e+"'></p>", "<p align='center' id='usertop"+e+"'></p>", "<p align='center' id='useremail"+e+"' style='display: none;'></p><p align='center' id='userkey"+e+"'><input type='text' class='form-control key_employee' placeholder='Enter employee email...' rel='"+e+"' /></p>", "<p align='center' id='usercheck"+e+"'></p>", "<p align='center' id='userdelete"+e+"'></p>"] ).draw();
			$( rowNode )
			.css( 'text-align', 'center');
			e++;
			$("#nume").val(e);			
		});	
		
		$(document).delegate( '.segment_managment', "click",function (event) {
			console.log("HOLA");
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+ "/admin/member/segments",
				success: function (data) {
					$("#myBodySegment").empty();
					$("#myBodySegment").html(data);
					$("#myModalSegmentChange").modal('show');
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				//	obj.html("Execute");
				}

			});				
		});

		$(document).delegate( '.add_row_c', "click",function (event) {
			var e = parseInt($("#nume_c").val());
				var rowNode = cust_table.row.add( [ "<p align='center'>" + e + "</p>", "<p align='center' id='c_usera"+e+"'></p> ","<p align='center' id='c_username"+e+"'></p>", "<p align='center' id='c_userrole"+e+"' rel='"+e+"'></p>", "<p align='center' id='c_usersegment"+e+"' rel='"+e+"'></p>", "<p align='center' id='c_usercamp"+e+"' rel='"+e+"'></p>", "<p align='center' id='c_usertop"+e+"'></p>", "<p align='center' id='c_useremail"+e+"' style='display: none;'></p><p align='center' id='c_userkey"+e+"'><input type='text' class='form-control key_employee_c' placeholder='Enter employee email...' rel='"+e+"' /></p>", "<p align='center' id='c_usercheck"+e+"'></p>", "<p align='center' id='c_userdelete"+e+"'></p>", "<p align='center' id='c_usersegments"+e+"' rel='"+e+"'></p>"] ).draw();
			$( rowNode )
			.css( 'text-align', 'center');
			e++;
			$("#nume_c").val(e);			
		});			
		
		$(document).delegate( '.send_email', "click",function (event) {
			var emails={};
			var obj = $(this);
			obj.html("Sending...");
			var count_emails = 0;
            $('.sender').each(function () {
				var email= $(this).attr('rel');
                if (this.checked) {
                    emails[count_emails]=email;
					count_emails++;
                } 
            });
			var key_employee = $('.key_employee').val();
			console.log(key_employee);
			if (typeof key_employee != 'undefined'){
				if(validateEmail(key_employee)){
					emails[count_emails]=key_employee;
					count_emails++;
				}
			}
			console.log(emails);
			if(count_emails == 0){
				toastr.warning('No email selected. Please select emails you wish to send');
				obj.html("Execute");
			} else {
				$.ajax({
					type: "POST",
					data: {emails: emails},
					url: JS_BASE_URL+ "/admin/member/send_emails",
					dataType: 'json',
					success: function (data) {
						toastr.info("Email(s) successfully sent!");
						obj.html("Execute");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
						obj.html("Execute");
					}

				});				
			}
		});	
		
		$(document).delegate( '.send_email_c', "click",function (event) {
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+ "/admin/member/lasttemplate",
				dataType: 'json',
				success: function (data) {
					$("#myBodyTemplate").html(data.html);
					$("#myModalLabelTemplate").html(data.name);
					$("#myModalTemplate").modal('show');
					//obj.html("Execute");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
					//obj.html("Execute");
				}

			});				
		});
		
		$(document).delegate( '.send_email_c_def', "click",function (event) {
			var emails={};
			var obj = $(this);
			obj.html("Sending...");
			var count_emails = 0;
            $('.sender_c').each(function () {
				var email= $(this).attr('rel');
                if (this.checked) {
                    emails[count_emails]=email;
					count_emails++;
                } 
            });
			var key_employee = $('.key_employee_c').val();
			console.log(key_employee);
			if (typeof key_employee != 'undefined'){
				if(validateEmail(key_employee)){
					emails[count_emails]=key_employee;
					count_emails++;
				}
			}
			var lpid = $("#lpeid").val();
			console.log(emails);
			if(count_emails == 0){
				toastr.warning('No email selected. Please select emails you wish to send');
				obj.html("Execute");
			} else {
				$.ajax({
					type: "POST",
					data: {emails: emails, userid: lpid},
					url: JS_BASE_URL+ "/admin/member/send_emails_c",
					dataType: 'json',
					success: function (data) {
						toastr.info("Email(s) successfully sent!");
						obj.html("Send Campaign");
						$(".send_email_c").hide();
						$(".nocampaign").show();
						$("#myModalTemplate").modal('toggle');
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
						obj.html("Send Campaign");
					}

				});				
			}
		});				
			
		$(document).delegate( '.view-employee-modal', "click",function (event) {
	//	$('.view-employee-modal').click(function(){

		var user_id=$(this).attr('data-id');
		var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+user_id;
		$.ajax({
				url: check_url,
				type:'GET',
				success:function (r) {
				console.log(r);

				if (r.status=="success") {
				var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
						var w=window.open(url,"_blank");
						w.focus();
				}
				if (r.status=="failure") {
				toastr.error(r.long_message);
				var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
				$('#employee-error-messages').html(msg);
				}
				}
				});
		});
		
		$(document).delegate( '.key_employee', "blur",function (event) {
			var keyemployee = $(this);
			var email = $(this).val();
			var rel = $(this).attr('rel');
			$("#mailspin").show();
			if(validateEmail(email)){
				$.ajax({
					type: "POST",
					data: {email: email},
					url: JS_BASE_URL+ "/admin/member/add_employee",
					dataType: 'json',
					success: function (data) {
						console.log(data);
						if(data.status == "warning"){
							toastr.warning(data.long_message);
						}
						if(data.status == "error"){
							toastr.error(data.long_message);
						}
						if(data.status == "success"){
							toastr.info(data.long_message);
							if(parseInt(data.employee['user_id']) > 0){
								$("#usera" + rel).html("<a href='javascript:void(0)' class='view-employee-modal' data-id='"+data.employee['user_id']+"'>"+data.employee['id']+"</a>");
							}
							$("#username" + rel).html(data.employee['name']);	
							if(parseInt(data.employee['user_id']) > 0){	
								$("#userrole" + rel).html('<a href="javascript:void(0)" class="member_role" rel="'+data.employee['user_id']+'">Roles</a>');
							} else {
								$("#userrole" + rel).html("&nbsp;&nbsp;&nbsp;&nbsp;");
							}
							$("#usertop" + rel).html(firstToUpperCase(data.employee['status']));
							$("#useremail" + rel).html(data.employee['email']);
							$("#useremail" + rel).show();
							$("#userkey" + rel).hide();
							$("#userinfo" + rel).html('<a href="javascript:void(0)" class="member_info" rel="'+data.employee['user_id']+'">Info</a>');
							$("#usersmm" + rel).html('<a href="javascript:void(0)" class="member_smm" rel="'+data.employee['user_id']+'">0</a>');
							$("#usercheck" + rel).html("<input type='checkbox' class='sender' rel='"+data.employee['email']+"' />");
							$("#userdelete" + rel).html("<a  href='javascript:void(0);' class='text-danger delete_member' rel='"+data.employee['email']+"'><i class='fa fa-minus-circle fa-2x'></i></a>");
						/*	var e = parseInt($("#nume").val());
							var rowNode = emp_table.row.add( [ "<p align='center'>" + e + "</p>", "<p align='center'><a href='javascript:void(0)' class='view-employee-modal' data-id='"+data.employee['user_id']+"'>"+data.employee['id']+"</a></p> ","<p align='center'>" + data.employee['name'] + "</p>", "<p align='center'>" + firstToUpperCase(data.employee['role']) + "</p>", "<p align='center'>" + "<a href='javascript:void(0)' >" + firstToUpperCase(data.employee['status'])+ '</a>' + "</p>", "<p align='center'>" + data.employee['email'] + "</p>", "<p align='center'>" + "<input type='checkbox' class='sender' rel='"+data.employee['email']+"' />" + "</p>" ] ).draw();
							$( rowNode )
							.css( 'text-align', 'center');
							e++;
							$("#nume").val(e);*/
						}
						$(".key_employee").val("");
						$("#mailspin").hide();
					},
					error: function (error) {
						$("#mailspin").hide();
						toastr.error("An unexpected error ocurred");
					}

				});				
				
			} else {
				$("#mailspin").hide();
				if(email != ""){
					toastr.error("Invalid email! Please, type a valid email.");
				}
			}
				//alert($(this).is(":checked"));
         });	

		$(document).delegate( '.key_employee_c', "blur",function (event) {
			var keyemployee = $(this);
			var email = $(this).val();
			var rel = $(this).attr('rel');
			$("#mailspin").show();
			var lpid = $("#lpeid").val();
			if(validateEmail(email)){
				console.log(lpid);
				$.ajax({
					type: "POST",
					data: {email: email, userid: lpid},
					url: JS_BASE_URL+ "/admin/member/add_employee/customer",
					dataType: 'json',
					success: function (data) {
						console.log(data);
						if(data.status == "warning"){
							toastr.warning(data.long_message);
						}
						if(data.status == "error"){
							toastr.error(data.long_message);
						}
						if(data.status == "success"){
							toastr.info(data.long_message);
							if(parseInt(data.employee['user_id']) > 0){
								$("#c_usera" + rel).html(data.employee['id']);
							}
							$("#c_username" + rel).html(data.employee['name']);
							if(parseInt(data.employee['user_id']) > 0){	
								$("#c_userrole" + rel).html('<a href="javascript:void(0)" class="customer_role" rel="'+data.employee['user_id']+'">Roles</a>');
							} else {
								$("#c_userrole" + rel).html("&nbsp;&nbsp;&nbsp;&nbsp;");
							}
							$("#c_usertop" + rel).html(firstToUpperCase(data.employee['status']));
							$("#c_useremail" + rel).html(data.employee['email']);
							$("#c_useremail" + rel).show();
						//	$("#c_usercamp" + rel).html('<a href="javascript:void(0)" class="customer_campaign" rel="'+data.employee['id']+'">0</a>');
								$("#c_usersegment" + rel).html('<a href="javascript:void(0)" class="customer_segment" rel="'+data.employee['member_id']+'">Details</a>');
							$("#c_userkey" + rel).hide();
							$("#c_usercheck" + rel).html("<input type='checkbox' class='sender' rel='"+data.employee['email']+"' />");
							$("#c_userdelete" + rel).html("<a  href='javascript:void(0);' class='text-danger delete_member_c' rel='"+data.employee['email']+"'><i class='fa fa-minus-circle fa-2x'></i></a>");
						}
						$(".key_employee_c").val("");
						$("#mailspin").hide();
					},
					error: function (error) {
						$("#mailspin").hide();
						toastr.error("An unexpected error ocurred");
					}

				});				
				
			} else {
				$("#mailspin").hide();
				if(email != ""){
					toastr.error("Invalid email! Please, type a valid email.");
				}
			}
				//alert($(this).is(":checked"));
         });
         $('.smmarmy_exposer').click(function(){
         	uid=$(this).attr('rel');
         	url=JS_BASE_URL+"/smmarmy_exposer/"+uid;
         	$.ajax({
         		url: url,
         		type:'GET',
         		success:function(r){
         			$('#smmarmy_exposer').empty();
         			$('#smmarmy_exposer').append(r);
         			$('#myModalSMM').modal('show');
         		},
         		error:function(){
         			toastr.warning('Failed to get resource.');
         		}
         	});
         });

         $('.save_channel').click(function(){
         	$channel_array={};
         	$('.channel_desc').each(function(i,elem){
         		if ($(elem).is(":checked")) {
         			$channel_array[$(elem).val()]="active";
         		}
         		else{
         			$channel_array[$(elem).val()]="suspended";
         		}
         		
         		


         	});
         	url="{{url('campaign/channel/save')}}";
         	data={
         			'channel_array':$channel_array
         		};
			console.log(data);         		
         	$.ajax({
         			url:url,
         			data:data,
         			type:'POST',
         			success:function(r){
         				toastr.info(r.long_message);
         				location.reload();
         			},
         			error:function(){toastr.warning("A server error happened.")}

         		});

         });				 
    });
</script>
@stop
