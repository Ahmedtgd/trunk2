<?php 
use App\Http\Controllers\IdController;
?>
<style type="text/css">
	td{
	
		padding: 10px;
	}
	th{
		padding: 10px;
	}
</style>
<input type="hidden" name="orderproductid" value="{{$oid}}" id="crereviewoid">
<table  width="100%" class="table table-striped">
	<thead>
		<tr>
			<th></th>
			<th>ID</th>
			<th>Name</th>
			<th>Contact No.</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>Seller</strong></td>
			<td>{{IdController::nM($seller->id)}}</td>
			<td>{{$seller->name}}</td>
			<td>{{$seller->phone}}</td>
		</tr>
		<tr>
			<td><strong>Buyer</strong></td>
			<td>{{IdController::nB($buyer->id)}}</td>
			<td>{{$buyer->name}}</td>
			<td>{{$buyer->phone}}</td>
		</tr>
		<tr>
			<td><strong>Order</strong></td>
			<td colspan="3">{{IdController::nO($ops->porder_id)}}</td>
		</tr>
		<tr>
			<td><strong>Product ID</strong></td>
			<td>{{IdController::nP($ops->product_id)}}</td>
		</tr>
	</tbody>
</table>

<table>
	<tr>
		<td>
			<strong>After investigation of</strong><br>
			<label><input style="vertical-align: center; margin-top: 8px !important;" type="checkbox" name="" id="boef">&nbsp;Based on existing facts</label><br>
			<label><input style="vertical-align: center; margin-top: 8px !important;" type="checkbox" name="" id="cm">&nbsp;Call merchant </label><br>
			<label><input style="vertical-align: center; margin-top: 8px !important;" type="checkbox" name="" id="cb">&nbsp;Call buyer</label>
		</td>
		<td>
			
		</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td><strong>Conclusive Notes</strong></td>
	</tr>
	<tr>
		<td>
			<textarea class="form-control" id="conclusion"></textarea>
		</td>
	</tr>
</table>
<table  width="60%">
	<tr>
		<td><strong>Review Officer Name</strong></td>
		<td>{{Auth::user()->name}}</td>
	</tr>
	<tr>
		<td><strong>Identification Number</strong></td>
		<td>{{IdController::nB(Auth::user()->id)}}</td>
	</tr>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$('.review').click(function(){
			// $('.review').prop('disabled',true);
			$('input[type=checkbox]').prop("disabled",true);
			var reward=$(this).attr('rel-type');
			var cb=0;
			var cm=0;
			var boef=0;
			var oid=$('#crereviewoid').val();
			if ($('#cb').is(":checked")) {
				cb=1;
			}
			if ($('#cm').is(":checked")) {
				cm=1;
			}
			if ($('#boef').is(":checked")) {
				boef=1;
			}
			var conclusion=$('#conclusion').val();

			var url="{{url('admin/master/cre/review')}}";
			$.ajax({
				type:"POST",
				url:url,
				data:{
					"cb":cb,
					"cm":cm,
					"boef":boef,
					"reward":reward,
					"conclusion":conclusion,
					"oid":oid
				},
				success:function(r){
					if (r.status == "success") {
						toastr.info(r.long_message)
						location.reload();
					}
					else{
						toastr.warning(r.long_message);
					}
				},
				error:function(){
					toastr.warning("Some error happened. Please contact OpenSupport");
				}
			});
		});
	});
</script>