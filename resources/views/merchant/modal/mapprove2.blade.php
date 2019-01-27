<table class="table table-bordered" width="100%"
 style="table-layout: fixed;" 
>
<thead>
	<tr>
		<th style="width: 40px;" class="text-center" >No.</th>
		{{-- <th style="width: 70px;" class="text-center">Image</th> --}}
		<th>Name</th>
		<th style="width:70px;" class="text-center">Approve</th>
		<th style="width:70px;" class="text-center">Reject</th>
	</tr>
</thead>
<tbody>
<input type="hidden" value="{{$oid}}" id="oidret">
	<?php $i=1;?>
	@if(isset($ops))
		@foreach($ops as $op)
			<tr style="vertical-align: middle;">
			<td class="text-center" style="vertical-align: middle;">{{$i}}</td>
			 <td class="" style="vertical-align: middle;">
            <?php 
            $img="images/product/".$op->product_id."/".$op->image;
            ?>
            <img src="{{asset($img)}}" height="40;" width="40" style="vertical-align: middle;">
      <strong>{{$op->pname}}</strong></td>
        <td class="text-center" style="vertical-align: middle;">
            <input type="radio" class="apprvoid2" rel-oid="{{$op->id}}" class="form-control" name="status_{{$op->id}}" checked="checked">
        </td>
        <td class="text-center" style="vertical-align: middle;">
            <input type="radio" class="rjctoid2" rel-oid="{{$op->id}}" class="form-control" name="status_{{$op->id}}">
        </td>
			</tr>
			<?php $i++ ;?>
		@endforeach
	@endif
	</tbody>
	{{-- <tfoot>
		<tr>
		<td colspan="3">
		Approve All <input type="checkbox" name="" id="aprvAll">
		</td>
		</tr>
	</tfoot> --}}

</table>
<script type="text/javascript">
	$(document).ready(function(){

		// $('#aprvAll').change(function(){
		// 	if ($(this).is(":checked")) {
				
		// 		$('[type=checkbox]').prop('checked',true);
		// 	}
		// 	else{
		// 		$('[type=checkbox]').prop('checked',false);
		// 	}
			
		// });
		$('#confaprv').click(function(){
			 $('#myModal').modal('hide');
			oids=[];
			$(this).prop('disabled',true);
			$('.apprvoid2').each(function(i,elem){
				if ($(elem).is(":checked")) {
					oids.push($(elem).attr('rel-oid'));
				}
			});
			
			// Validation
			
				var url="{{url("merchant/approval")}}";
				$.ajax({
					url:url,
					type:"POST",
					data:{"oids":oids,"oid":$('#oidret').val(),"merchant_id":$('#mmerchant_id').val()},
					success:function(r){
						if (r.status=="success") {
							toastr.info(r.long_message);
							location.reload();
						}
						else{
							toastr.warning(r.long_message);
						}
					},
					error:function(){
						toastr.warning("Server error happened.Contact OpenSupport");
					}
				});
			
		});

		
		
	});
</script>