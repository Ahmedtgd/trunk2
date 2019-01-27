@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$cStatus=["completed","reviewed","commented"];
define('MAX_COLUMN_TEXTvk', 20);
$ii = 0;
?>
@section("content")
@include("common.sellermenu")
<style>
	.naddTproduct:hover {
		background-color: #CCC !important;
		border-color: #CCC !important;
	}
	
	.naddTproduct {
		background-color: #CCC !important;
		border-color: #CCC !important;
	}
</style>

<!-- This is NOT working??? -->


<section class="">
<div class="container" >
<div class="row" style="margin-top: 15px;"> <!-- col-sm-12 -->

<h2>Consignment Account Number
<!--
	<small>
		<button class="btn "></button>
	</small>
-->
</h2>


	<input type="hidden" value="{{$id}}" id="active_location" />
	<input type="hidden" value="" id="active_company"/>
	<div id="thetable">
		<table class="table table-bordered" width="100%" id="location_details_table">
			<thead>

			<tr class="bg-caiman">
				<th class="text-center no-sort bsmall" width="20px" style="width: 20px !important;">No</th>
				<th class="text-center" >Company</th>
				<th class="text-center" >Consignment&nbsp;A/C&nbsp;No</th>
				
			</tr>
			</thead>
			<tbody>
			
			@if(isset($locations))
				@foreach($locations as $location)
				<?php $ii++; ?>
					<tr>
						 <td style="text-align: center;">{{$ii}}</td>
						  <td style="text-align: center;">{{$location->company}}</td>
						 <td style="text-align: center;">
						 	<a class="show_all_cacctno" rel-company="{{$location->company}}" href="javascript:void(0)">
								{{$location->count}}
							</a>
						</td>
						 
					</tr>
					
				@endforeach
			@endif
			</tbody>

		</table>
	</div>
</div>
</div>
</section>
<div class="modal fade" id="cacct_show_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
   
      <div class="modal-body">
			<table class="table table-bordered" style="width:100% !important;">
				<tbody id="cacctno_content">
					
				</tbody>
			</table>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	
    $(document).ready(function(){
		$('#location_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "width": "120px", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "bsmall", "width": "20px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
		});			
		$(".show_all_cacctno").click(function(){
			var company=$(this).attr("rel-company");
			$("#active_company").attr("value",company);
			$.ajax({
				url:'{{url("caiman/cacctno/list/location")}}',
				type:"POST",
				data:{
					company:company
				},
				success:function(response){
					var html="";
					r=response.data
					for (var i=0;i <= r.length - 1;i++) {

						row=r[i]
						checked=""
						if (row.status=="checked") {
							checked="checked=`checked`";
						}
						j=i+1;
						html+=`
							<tr>
							<td>`+j+`</td>
							<td>
						    <label for="checkboxes-`+j+`">
						      <input name="checkboxes" 
						      	`+checked+`
						      	id="checkboxes-`+j+`" value="`+row.acctno+`" type="checkbox" class="cacctmodified">
						      `+row.acctno+`
						    </label>
						    </td>
						    </tr>
								
						`
					}
					$("#cacctno_content").empty();
					$("#cacctno_content").append(html);
					$("#cacct_show_modal").modal("show");
				},
				error:function(){toastr.warning("Failed to fetch A/C list. Try again later.")}
			});
			
		})

		$('body').on("change",".cacctmodified",function(){
			$("#cacctno_content :input").prop("disabled", true);
			var action="unassign";
			var company=$("#active_company").val();
			var location_id=$("#active_location").val();
			if ($(this).is(":checked")) {
				action="assign";
			}
			$.ajax({
				url:"{{url('caiman/cacctno/assign/location')}}",
				type:"POST",
				data:{
					company:company,
					action:action,
					location_id:location_id
				},
				success:function(r){
					if (r.status=="success") {toastr.success("Action successful")}
					else{
						toastr.warning("Action failed.")
					}
					$("#cacctno_content :input").prop("disabled", false);
				},
				error:function(){toastr.warning("Action failed.");
				$("#cacctno_content :input").prop("disabled", false);

			}
			})
			
		});
					
		
				
		
    });
</script>
@stop
