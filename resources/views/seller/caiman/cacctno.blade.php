<table class="table table-bordered" id="cacctnos_table" style="width:100% !important;">
	<thead class="bg-caiman">
	<tr>
		<td class='text-center no-sort bsmall'>No</td>
		<td class='text-center bmedium'>Consignee Company</td>
		<td class='text-center bmedium'>A/C No.</td>
		{{--  
		<td class='text-center medium'>Action</td>  --}}
	</tr>
	</thead>
	<tbody>
	
	<?php $count = 1; ?>
		@foreach($cacctnos as $c)
		<tr class="td_class_css">
			<td class="text-center">{{$count++}}</td>
			<td class="text-center">{{$c->company}}</td>
			<td class="text-center">
				<a href="javascript:void(0);"
				class="show_all_cacctno"
				rel-company="{{$c->company}}" 
				>
				{{$c->count}}
				</a>
			</td>
			{{-- <td>
				<a href="javascript:void(0);" class="text-danger text-center cacct_delete" 
				style="margin: auto;" 
				rel-cacct={{$c->id}}
				><i class="fa fa-minus-circle fa-2x"></i></a>
				
			</td> --}}
		</tr>
		@endforeach
	</tbody>
</table>
<div class="modal fade" id="cacct_add_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
   
      <div class="modal-body">
		<form class="form-horizontal" id="cacct_add_form">


	

		<!-- Text input-->
		<div class="form-group">
		<label class="col-md-4 control-label" for="acctno">A/C No.</label>  
		<div class="col-md-5">
		<input id="acctno" name="consignment_no" placeholder="eg: AX12345..." class="form-control input-md" type="text">

		</div>
		</div>
		<input type="hidden" name="action" value="save">
		<!-- Text input-->
		<div class="form-group">
		<label class="col-md-4 control-label" for="company">Company</label>  
		<div class="col-md-5">
		<input id="company" name="company" placeholder="eg: Samsung.." class="form-control input-md" required="" type="text">

		</div>
		</div>

		<!-- Button (Double) -->
		<div class="form-group">
		<label class="col-md-4 control-label" for="cacct_save_click"></label>
		<div class="col-md-8">
		<button id="cacct_save_cancel" name="cacct_save_cancel" class="btn btn-danger" type="button">Cancel</button>
		<button id="cacct_save_click" name="cacct_save_click" class="btn btn-primary">Save</button>
		
		</div>
		</div>

		</form>


      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
				
		
		var table = $('#cacctnos_table').DataTable({
               
				"columnDefs": [
					{"targets": 'no-sort', "orderable": false, },
					{"targets": "medium", "width": "50px" },
					{"targets": "bmedium", "width": "10px" },
					{"targets": "large",  "width": "120px" },
					{"targets": "approv", "width": "180px"},
					{"targets": "blarge", "width": "200px"},
					{"targets": "bsmall",  "width": "20px"},
					{"targets": "clarge", "width": "250px"},
					{"targets": "xlarge", "width": "300px" }
				]});
		$("#cacct_add").click(function(){
			$("#cacct_add_modal").modal("show");
		})

		/**/
		$(".show_all_cacctno").click(function(){
			var company=$(this).attr("rel-company");
			$("#active_company").attr("value",company);
			$.ajax({
				url:'{{url("caiman/cacctno/list/company")}}',
				type:"POST",
				data:{
					company:company
				},
				success:function(response){
					var html="";
					r=response.data
					for (var i=0;i <= r.length - 1;i++) {

						row=r[i]
						
						j=i+1;
						html+=`
							<tr>
							<td class='text-center'>`+j+`</td>
							<td class='text-center'>
					
						      `+row.acctno+`
						   
						    </td>
						    <td class='text-center'>
						    <a href="javascript:void(0);"
							class="text-danger text-center cacct_delete" 
							style="margin: auto;" 
							rel-cacct="`+row.id+`" 
							><i class="fa fa-minus-circle fa-2x"></i></a>
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
		/**/

		$("#cacct_save_click").click(function(e){
			e.preventDefault();
			var data=$("#cacct_add_form").serialize();
			$.ajax({
				url:"{{url("caiman/cacctno")}}",
				type:"POST",
				data:data,
				success:function(r){
					location.reload()
				},
				error:function(){
					toastr.warning("Failed to save.")
				}
			});
		});
		$("body").on("click",".cacct_delete",function(e){
			e.preventDefault();
			$this=$(this);
			var cid=$("#cacct_add_form").serialize();
			data={
				action:"delete",
				cacct_id:$this.attr("rel-cacct")
			}
			$.ajax({
				url:"{{url("caiman/cacctno")}}",
				type:"POST",
				data:data,
				success:function(r){
					location.reload()
				},
				error:function(){
					toastr.warning("Failed to save.")
				}
			});
		});

		$("#cacct_save_cancel").click(function(){$("#cacct_add_modal").modal("hide")})

			
	})
</script>
