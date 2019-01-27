<table class="table" id="belugaconfirmapprovaltable"
 style="width:100%" 
>
	
	<thead>
		<tr class="bg-beluga">
			<th class="text-center">No</th>
			<th class="text-center">Email</th>
			<th>Company Name</th>
			<th class="text-center">Status</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
		@def $i=1
		@foreach($merchants as $merchant)
			<tr>
				<td class="text-center">{{$i}}</td>
			
				<td class="text-center">{{$merchant->email}}</td>
				<td>{{$merchant->company_name}}</td>
				<td class="text-center">{{ucfirst($merchant->status)}}</td>
				<td class="text-center">
					@if($merchant->status=="pending")
					<button class="btn btn-sm bg-confirm" 
					style="border-radius:5px; vertical-align:middle;" 
					id="belugaapprove_{{$merchant->id}}" 
					type="button"
					onclick="approve('{{$merchant->email}}',{{$merchant->id}})">
						Approve
					</button>
					@else
					<span style="vertical-align: middle;">
						Approved
					</span>
					
					@endif
				</td>
			</tr>
		@def $i+=1
		@endforeach
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$("#belugaconfirmapprovaltable").DataTable()
	})
	function approve(email,id) {
		// body...
		$("#belugaapprove_"+id).css("display","none");
		url="{{url('onz/confirm/approval')}}"
		type="POST"
		data={
			email
		}
		success=function(r){
			if (r=="ok") {
				
				toastr.success("Confirmation Mail Sent")
			}else{
				$("#belugaapprove_"+id).css("display","none1");
			}
		}
		$.ajax({type,url,success,data})
	}
</script>
