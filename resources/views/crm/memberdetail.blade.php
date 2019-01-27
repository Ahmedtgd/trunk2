<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
?>
@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
?>
@section("content")
<style type="text/css">
    .action_buttons{
        display: flex;
    }
    .role_status_button_member{
        margin: 10px 0 0 10px;
        width: 85px;
    }
</style>
<section class="">
  <div class="container"><!--Begin main cotainer-->
		<div class="row">
			<div class=" col-sm-11">
				<h3>Member Detail: {{IdController::nB($member->user_id)}} {{$member->member_first_name}} {{$member->member_last_name}}</h3>
			</div>
			<div class=" col-sm-1">
				&nbsp;
			</div>
		</div>
		<div class="row">
			<div class=" col-sm-12">
				<table class="table table-bordered"  id="employee-table" width="100%">
					<thead>
					
					<tr class="bg-black">
						<th class="bsmall">Top </th>
						<th class="text-center">Recruiter</th>
						<th  style="background-color: green;" class="text-center">Remarks</th>
						<th  style="background-color: green;" class="text-center">Approval</th>
					</tr>
					</thead>				
					<tbody>
					@if(!is_null($member))
						<tr>
							<td class="text-center"><input type='checkbox' class='top' rel='{{$member->user_id}}' /></td>
							<td class="text-center">
								<p id="recruiter" class="recruiter">&nbsp;&nbsp;{{$member->recruiter_first_name}}&nbsp;{{$member->recruiter_last_name}}&nbsp;&nbsp;</p>
								<p id='recruitersel' style='display: none;'>
									<select id='recruiterselect' class='recruiterselect' urel='{{$member->user_id }}'>
										<option value="">Choose Option</option>
										@foreach($recruiters as $recruiter)
											<option value="{{$recruiter->user_id}}">{{$recruiter->first_name}} {{$recruiter->last_name}}</option>
										@endforeach
									</select>
								</p>
							</td>
							<td class="text-center" id="remarks_column">											
								<?php
									$remark = DB::table('remark')
									->select('remark')
									->join('osmallmemberremark','osmallmemberremark.remark_id','=','remark.id')
									->where('osmallmemberremark.member_id',$member->id)
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
								<a href="javascript:void(0)" id="mcrid_{{$member->id}}"
									class="memid" rel="{{$member->id}}">
									<span title='{{$pfullremark}}'>{{$premark}}</span>
								</a>								
							</td>
							<td class="text-center">
								<div class="action_buttons">
									<?php
										echo Classes\Approval::osmallmember($member->status, 'osmallmember',$member->id);
									?>
								</div>							
							</td>
						</tr>
					@endif
					</tbody>
				</table>
		</div>
		</div>    
</div>
    </section>	
	
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

<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 75%">
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
							<input type="button" id="save_remarks_member" class="btn btn-primary" value="Save Remarks">
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
<script type="text/javascript">
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
    $(document).ready(function(){
		var emp_table = $('#employee-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "300px" },
					{ "width": "300px" },
				]
			});		
			
		$(document).delegate( '.recruiter', "click",function (event) {
			//var rel = $(this).attr('rel');
			$(this).hide();
			$("#recruitersel").show();
		});			
		
		$(document).delegate( '.recruiterselect', "change",function (event) {
			var val = $(this).val();
			var user = $(this).attr('urel');
			//var rel = $(this).attr('rel');
			if(val == ""){
				toastr.error("You must select a recruiter!");
			} else {
				$.ajax({
					type: "POST",
					data: {val: val, user_id: user},
					url: "/admin/member/add_recruiter",
					dataType: 'json',
					success: function (data) {
						console.log(data);
						$("#recruiter").html(data.response);
						$("#recruiter").show();
						$("#recruitersel").hide();
						toastr.info("Recruiter successfully assigned!");
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});				
					
			}
		});
		
    $(document).delegate( '.memid', "click",function (event) {
		_this = $(this);
		var id_member= _this.attr('rel');

		$('#modal-Tittle2').html("Remarks");

		var url = '/admin/member_remarks/'+ id_member;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th class='text-center'>No</th><th class='text-center'>Member&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					html += "<tr>";
					html += "<td class='text-center'>"+(i+1)+"</td>";
					html += "<td class='text-center'>"+obj.nbuyer_id+"</td>";
					html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
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
	
            var signal = 'red';
            var intervalId = 1;
            var currentElement;
            var url;
            $(document).on("click", ".role_status_button_member", function () {
                currentElement = $(this);
                var doStatus = $(currentElement).attr('do_status');
                var role = $(currentElement).attr('role');

                if (role == 'osmallmember') {
                    url = JS_BASE_URL + '/admin/approveMember';
                }

                var role_id = $(currentElement).attr('current_role_id');

                $('#current_role_roleId').val(role_id);
                $('#current_status').val(doStatus);
                $('#current_role_roleId').attr('remarks_role', role);

                $("#myModalRemarks").modal('toggle');

            });	
	
            function approveMember(role_id, doStatus, role, url, currentElement) {
					
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {id: role_id, doStatus: doStatus, role: role},
                            success: function (response) {
                                if (response.success == 'TRUE') {
                                    var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
                                    $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                                        $(currentElement).parent('.action_buttons').html(response.view);
                                        $(statusColumn).fadeOut('fast');
										console.log("Test");
                                        doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                            return letter.toUpperCase();
                                        });
                                        $(statusColumn).text(doStatus);
                                        $(statusColumn).fadeIn(2000);
                                        $('#overlay_spinner_'+role_id).hide();
                                        $('#alert_heading').text('Success!');
                                        $('#alert_text').text('Status Changed Successfully');
                                        $('.removeable').removeClass('alert-danger');
                                        $('.removeable').addClass('alert-success');
                                    });
                                    $(currentElement).parent('.action_buttons').fadeIn(2000);
                                } else if (response.success == 'False') {
                                    $('#alert_heading').text('Error!');
                                    $('#alert_text').text('Unable to change stauts');
                                    $('.removeable').removeClass('alert-success');
                                    $('.removeable').addClass('alert-danger');
                                }

                            }, complete: function () {
                                $('.removeable').show();
                                setTimeout(removeMessage, 5000);
                            }
                        });
                    //}
                //}, 500);
            }

            function suspendOrRejectMember(role_id, doStatus, role, url, currentElement) {
                //dialog.dialog("open");
                //intervalId = setInterval(function () {
                    //console.log("pas2s");
                    checkSignalMember(role_id, doStatus, role, url, currentElement)
                //}, 500);
            }

            function checkSignalMember(role_id, doStatus, role, url, currentElement) {
                //if (signal == 'green') {
                    //clearInterval(id);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {id: role_id, doStatus: doStatus, role: role},
                        error: function(response){
                            console.log(response);
                        },
                        success: function (response) {

                            if (response.success == 'TRUE') {
                                var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
								console.log("Test2");
                                var remarksColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#remarks_column').children('#remarks_text');
                                $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                                    $(currentElement).parent('.action_buttons').html(response.view);
                                    $(statusColumn).fadeOut('fast');
                                    $(remarksColumn).fadeOut('fast');
                                    doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                        return letter.toUpperCase();
                                    });
                                    $(statusColumn).text(doStatus);
                                    $(remarksColumn).text(response.roleData.remarks);
                                    $(statusColumn).fadeIn(2000);
                                    $(remarksColumn).fadeIn(2000);
                                    $('#overlay_spinner_'+role_id).hide();
                                    $('#alert_heading').text('Success!');
                                    $('#alert_text').text('Staus Changed Successfully');
                                    $('.removeable').removeClass('alert-danger');
                                    $('.removeable').addClass('alert-success');
                                });
                                $(currentElement).parent('.action_buttons').fadeIn(2000);
                            } else if (response.success == 'False') {
                                $('#alert_heading').text('Error!');
                                $('#alert_text').text('Unable to change stauts');
                                $('.removeable').removeClass('alert-success');
                                $('.removeable').addClass('alert-danger');
                            }

                        }, complete: function () {
                            $('.removeable').show();
                            setTimeout(removeMessage, 5000);
                            //signal = 'red';
                        }
                    });
                //}
            }

            function removeMessage() {
                $('.removeable').hide();
            }

            $('#save_remarks_member').click(function () {
                if (!$.trim($('#status_remarks').val())) {
                    alert('Enter Remarks Please');
                    return false;
                } else {
                    var roleId = $('#current_role_roleId').val();
                    var dostatus = $('#current_status').val();
                    var role = $('#current_role_roleId').attr('remarks_role');
                    var remarks = $('#status_remarks').val();
                    var url2;
                    if (role == 'osmallmember') {
                        url2 = JS_BASE_URL + '/admin/saveMemberRemarks';
                    }
					console.log(remarks);
					console.log(role);
					console.log(dostatus);
                    $.ajax({
                        url: url2,
                        type: 'POST',
                        dataType: 'json',
                        data: {id: roleId, remarks: remarks, role: role, status: dostatus},
                        success: function (response) {
							console.log("TestRemakrs");
                            $("#myModalRemarks").modal('toggle');
                            $('#overlay_spinner_'+roleId).show();
                            //signal = 'green';
                            $('#mcrid_'+roleId).html(remarks);
                            $('#remarks-form')[0].reset();
                        }
                    });
                    if (dostatus == 'suspended') {
                        suspendOrRejectMember(roleId, dostatus, role, url, currentElement);
                    } else {
                        approveMember(roleId, dostatus, role, url, currentElement);
                    }

                }
            });

            $(document).on('click', '.ui-dialog-titlebar-close', function () {
                $('#overlay_spinner').hide();
                $('#remarks-form')[0].reset();
            });	
    });
</script>
@stop
