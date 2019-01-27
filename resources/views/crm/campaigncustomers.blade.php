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
<section class="">
  <div class="container"><!--Begin main cotainer-->
		<div class="row">
			<div class=" col-sm-6">
				<h2>Campaign: Customer List</h2>
			</div>
			<div class=" col-sm-6">
			</div>
		</div>
		<div class="row">
			<div class=" col-sm-12">
				<table class="table table-bordered"  id="campaign-table" width="100%">
					<thead>
					
					<tr class="bg-black">
						<th class="bsmall">No</th>
						<th class="text-center">Email</th>
						<th class="text-center"><input type='checkbox' class='allcampaign_c' /></th>
					</tr>
					</thead>	
					<tfoot>
						<tr>
							<th colspan=2 ></th>
							<th>
								<a class="save_campaign btn btn-danger"
									style="width:100%"
									href="javascript:void(0)">Save</a>
							</th>
						</tr>
					</tfoot>					
					<tbody>
					@foreach($customers as $customer)
						@if($customer->incampaign > 0)
						<tr>
							<td class="text-center">{{$ii}}</td>
							<td class="text-center">
								{{$customer->email}}
							</td>
							<td class="text-center">
								<?php 
									$checked = "";
									if($customer->send > 0){
										$checked = "checked";
									}
								?>
								<input type='checkbox' {{$checked}} class='campaign_c' rel='{{$customer->id}}' />					
							</td>
						</tr>
						@endif
						<?php $ii++; ?>
					@endforeach
					</tbody>
				</table>
		</div>
		</div>    
		<input type="hidden" value="{{$ii}}" id="nume" />
		<input type="hidden" value="{{$campaign->id}}" id="campaign_id" />
</div>
</section>	

	
<script type="text/javascript">
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

    $(document).ready(function(){	
		$(document).delegate( '.allcampaign_c', "click",function (event) {
			if($(this).prop('checked')){
				$(".campaign_c").prop('checked',true);
			} else {
				$(".campaign_c").prop('checked',false);
			}
		});	
	
		$(document).delegate( '.save_campaign', "click",function (event) {
			var emails={};
			var obj = $(this);
			obj.html("Saving...");
			var count_emails = 0;
			var campaign_id = $("#campaign_id").val();
            $('.campaign_c').each(function () {
				var id= $(this).attr('rel');
				emails[count_emails] ={};
                emails[count_emails]['id']=id;
                emails[count_emails]['action']=this.checked;
				count_emails++;
            });
			console.log(emails);
			$.ajax({
				type: "POST",
				data: {emails: emails, campaign_id: campaign_id},
				url: JS_BASE_URL+"/admin/member/save_campaign",
				dataType: 'json',
				success: function (data) {
					toastr.info("Email(s) successfully saved!");
					obj.html("Save");
					window.location = JS_BASE_URL + "/admin/member/campaign";
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
					obj.html("Save");
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
				{ "width": "20px", "orderable": false }
			]
		});			

    });
</script>
@stop
