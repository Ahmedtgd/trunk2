<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
?>
<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
$ii = 1;
?>
<style type="text/css">
    .action_buttons{
        display: flex;
    }
    .role_status_button_member{
        margin: 10px 0 0 10px;
        width: 85px;
    }
</style>
				<table class="table table-bordered"
					id="campaign-table" width="100%">
					<thead style="background-color: #D94C54; color: #fff;">
					
					<tr>
						<th class="bsmall">No</th>
						<th class="text-center">Name</th>
						<th class="text-center">Date</th>
						<th class="text-center">Sent</th>
					</tr>
					</thead>						
					<tbody>
					@foreach($frecuencies as $campaign)
						<tr>
							<td class="text-center">{{$ii}}</td>
							<td class="text-center">											
								<span class="campaign_name" id="spancampaign{{$campaign->id}}" rel="{{$campaign->id}}">{{$campaign->name}}</span>	
							</td>							
							<td class="text-center">
								{{UtilityController::s_date($campaign->created_at)}}
							</td>
							<td class="text-center">
								@if($campaign->approved == 1)
									Y
								@else
									N
								@endif
							</td>
						</tr>
						<?php $ii++; ?>
					@endforeach
					</tbody>
				</table>
	
<script type="text/javascript">
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	
    $(document).ready(function(){
		$(document).delegate( '.delete_campaign', "click",function (event) {
			console.log("HI");
			var r = confirm("Are you sure you want to delete this campaign? It will be permanently removed");
			if (r == true) {
				var obj = $(this);
				var id = $(this).attr('rel');
				$.ajax({
					type: "POST",
					data: {id: id},
					url: "/seller/campaign/delete",
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
					url: "/seller/member/send_campaign",
					dataType: 'json',
					success: function (data) {
						toastr.info("Campign(s) sent saved!");
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
				url: "/seller/companycampaign/name/" + id,
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
				url: "/seller/companycampaign/template/" + id,
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
				url: "/seller/companycampaign/template/" + id,
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
		
		var camp_table = $('#campaign-table').DataTable({
		"order": [],
		 "columns": [
				{ "width": "20px", "orderable": false },
				
				{ "width": "300px" },
				{ "width": "300px" },
				{ "width": "40px" },
			]
		});		
		
		$(document).delegate( '.add_row_camp', "click",function (event) {
			var e = parseInt($("#nume").val());
			var owner_id = $("#selluser").val();
			$.ajax({
				type: "POST",
				data: {owner_id: owner_id},
				url: "/seller/companycampaign/add",
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
