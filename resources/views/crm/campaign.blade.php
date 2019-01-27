<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
?>
@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
$ii = 1;
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
<br>
<section class="">
  <div class="container"><!--Begin main container-->
		<div class="row">
			<div class=" col-sm-6">
				<h2>Campaign List</h2>
			</div>
			<div class=" col-sm-6">
				<a class="btn btn-danger pull-right" style="margin-top: 10px;margin-left: 5px;  width: 120px;"
							href="{{URL::to('/')}}/admin/member/staff">Back</a>&nbsp;
				<a class="add_row_camp btn btn-danger pull-right" style="margin-top: 10px; margin-left: 5px; width: 120px;"
							href="javascript:void(0)">+ Campaign</a>&nbsp;
			</div>
		</div>
		<div class="row">
			<div class=" col-sm-12">
				<table class="table table-bordered"
					id="campaign-table" width="100%">
					<thead>
					
					<tr class="bg-black">
						<th class="bsmall">No</th>
						<th class="text-center">Date</th>
						<th class="text-center">Name</th>
						<th class="text-center">Template</th>
						<th class="text-center">Customers</th>
						<th class="text-center"><input type='checkbox' class='allcampaign_c' /></th>
						<th class="bsmall text-center">&nbsp;</th>
					</tr>
					</thead>	
					<tfoot>
						<tr>
							<th colspan=5 ></th>
							<th colspan=2>
								<a class="send_campaign btn btn-danger"
									style="width:100%"
									href="javascript:void(0)">Send</a>
								<a class="save_campaign btn btn-info"
									style="width:100%; display: none;"
									href="{{URL::to('/')}}/admin/member/staff">Select Customer</a>
							</th>
						</tr>
					</tfoot>						
					<tbody>
					@foreach($campaigns as $campaign)
						<tr>
							<td class="text-center">{{$ii}}</td>
							<td class="text-center">
								{{UtilityController::s_date($campaign->created_at)}}
							</td>
							<td class="text-center">											
								<span class="campaign_name" id="spancampaign{{$campaign->id}}" rel="{{$campaign->id}}">{{$campaign->name}}</span>
								<span id="inputcampaign{{$campaign->id}}" style="display: none;">
									<input type="text" value="{{$campaign->name}}" rel="{{$campaign->id}}" class="campaign_input" id="inputcampaignv{{$campaign->id}}" />
								</span>		
							</td>
							<td class="text-center">
								<a href="javascript:void(0)" class="template" rel="{{$campaign->id}}" relid="{{STR_PAD($campaign->id,10,'0',STR_PAD_LEFT)}}" id="template{{$campaign->id}}">{{$campaign->template_name}}</a>							
							</td>
							<td class="text-center">
								<a href="{{URL::to('/')}}/admin/member/campaign/{{$campaign->id}}" class="customers" rel="{{$campaign->id}}">{{$campaign->customers}}</a>					
							</td>
							<td class="text-center">
								@if($campaign->customers > 0)
									<input type='checkbox' class='campaign_c' rel='{{$campaign->id}}' />	
								@endif
							</td>
							<td class="text-center">
								<a  href="javascript:void(0);" class="text-danger delete_campaign" rel='{{$campaign->id}}'><i class="fa fa-minus-circle fa-2x"></i></a>
							</td>
						</tr>
						<?php $ii++; ?>
					@endforeach
					</tbody>
				</table>
		</div>
		</div>    
		<input type="hidden" value="{{$ii}}" id="nume" />
</div>
</section>	

<!-- Modal -->
<div class="modal fade" id="myModalTemplate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="h4tname"></span> <span class="pull-right" id="h4id"></span></h4>
            </div>
            <div class="modal-body">
                <div id="myBody">
					<p><b>Template Name</b></p>
					<input type="text" value="" class="form-control" id="template_name" />
					<br>
					<p><b>Template Body</b></p>
					<textarea class="form-control" id="info-template">
						
					</textarea>
					
					<a class='btn btn-primary save_template pull-right' href='javascript:void(0)' > Save</a>
					<br>
					<br>
					<input type="hidden" value="0" id="campaign_id" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
					class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div> 
<br>
	
<script type="text/javascript">
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	
    $(document).ready(function(){
//
		$(document).delegate( '.send_campaign', "click",function (event) {
			var campaings={};
			var obj = $(this);
			obj.html("Sending...");
			var count_campaign = 0;
            $('.campaign_c').each(function () {
				var id= $(this).attr('rel');
				if($(this).prop('checked')){
					campaings[count_campaign]=id;
					count_campaign++;
				}
            });
			console.log(campaings);
			if(count_campaign == 0){
				toastr.warning("Please, select at least one campaign to send");
				obj.html("Send");
			} else {			
				$.ajax({
					type: "POST",
					data: {campaings: campaings},
					url: "/admin/member/send_campaign",
					dataType: 'json',
					success: function (data) {
						toastr.info("Email(s) successfully saved!");
						obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
						obj.html("Send");
					}

				});	
			}			
		});			
		
		$(document).delegate( '.allcampaign_c', "click",function (event) {
			if($(this).prop('checked')){
				$(".campaign_c").prop('checked',true);
				$('.campaign_c').each(function () {
					//console.log($(this).prop('disabled'));
					if($(this).prop('disabled')){
						$(this).prop('checked',false);
					}
				});				
			} else {
				$(".campaign_c").prop('checked',false);
			}
		});			
		
		$(document).delegate( '.campaign_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			$.ajax({
				type: "POST",
				data: {data: value},
				url: "/seller/osmallcampaign/name/" + id,
				dataType: 'json',
				success: function (data) {
					$("#inputcampaign" + id).hide();
					$("#spancampaign" + id).html(value);
					$("#spancampaign" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});			
		
		$(document).delegate( '.save_template', "click",function (event) {
			var id = $("#campaign_id").val();
			var value = $("#info-template").summernote("code");
			var name = $("#template_name").val();
			$.ajax({
				type: "POST",
				data: {data: value, name: name},
				url: "/seller/osmallcampaign/template/" + id,
				dataType: 'json',
				success: function (data) {
					$("#template" + id).html(name);
					toastr.info('Template Successfully saved');
					$("#myModalTemplate").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});				
		});
		
		$(document).delegate( '.template', "click",function (event) {
			var id = $(this).attr('rel');
			var nid = $(this).attr('relid');
			$("#campaign_id").val(id);
			$.ajax({
				type: "GET",
				url: "/seller/osmallcampaign/template/" + id,
				dataType: 'json',
				success: function (data) {
					$("#info-template").summernote("code", data.template);
					$("#template_name").val(data.template_name);
					$("#h4tname").html(data.template_name);
					$("#h4id").html("[" + nid + "]");
					
					$("#myModalTemplate").modal('show');
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
			
		});
		$(document).delegate( '.campaign_name', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#inputcampaign" + id).show();
		});
		
		$(document).delegate( '.delete_campaign', "click",function (event) {
			console.log("HI");
			var r = confirm("Are you sure you want to delete this campaign? It will be permanently removed");
			if (r == true) {
				var obj = $(this);
				var id = $(this).attr('rel');
				$.ajax({
					type: "POST",
					data: {id: id},
					url: "/admin/campaign/delete",
					dataType: 'json',
					success: function (data) {
						camp_table
							.row( obj.parents('tr') )
							.remove()
							.draw();
						toastr.info("Campaign successfully deleted!");
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});				
			} else {
				
			}	
		});
		
		var camp_table = $('#campaign-table').DataTable({
		"order": [],
		 "columns": [
				{ "width": "20px", "orderable": false },
				{ "width": "300px" },
				{ "width": "300px" },
				{ "width": "300px" },
				{ "width": "300px" },
				{ "width": "150px" },
				{ "width": "150px" }
			]
		});		
		
		$(document).delegate( '.add_row_camp', "click",function (event) {
			var e = parseInt($("#nume").val());
			$.ajax({
				type: "POST",
				data: {},
				url: "/seller/osmallcampaign/add",
				dataType: 'json',
				success: function (data) {
					$(".send_campaign").hide();
					$(".save_campaign").show();
					if(data.status == 'success'){
						var rowNode = camp_table.row.add( ["<p align='center'>"+ e + "</p>","<p align='center'>"+ data.date+"</p>", "<p align='center'>"+ '<span class="campaign_name" id="spancampaign'+data.id+'" rel="'+data.id+'">Campaign Name</span><span id="inputcampaign'+data.id+'" style="display: none;"><input type="text" value="Campaign Name" rel="'+data.id+'" class="campaign_input" id="inputcampaignv'+data.id+'" /></span> '+"</p>","<p align='center'>"+'<a href="javascript:void(0)" class="template" rel="'+data.id+'">Template</a>	' + "</p>","<p align='center'>"+ '<a href="javascript:void(0)" class="customers" rel="'+data.id+'">0</a>' + "</p>","",'<p align="center"><a  href="javascript:void(0);" class="text-danger delete_campaign" rel='+data.id+'><i class="fa fa-minus-circle fa-2x"></i></a></p>'] ).draw();
						$( rowNode )
						.css( 'text-align', 'center');
						e++;
						$("#nume").val(e);		
					} else {
						toastr.error("You can't create a new campaign without sending the current one!");
					}
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
	
		});		

    });
</script>
@stop
