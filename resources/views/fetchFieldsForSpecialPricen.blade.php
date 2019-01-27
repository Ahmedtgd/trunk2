<tr class='srow' data="{{ $id }}" id="srow-{{ $id }}">
	<td class="col-xs-1"><center id="num-{{$id}}">1</center></td>
	<td class="col-xs-4">
		<span id="userIDs-{{ $id }}">
			<select class="form-control dealer_select" id="userID-{{ $id }}" required="" rel="{{ $id }}" >
				@if(!is_null($dealers))
					<option value="">Choose User</option>									
					@foreach($dealers as $dealer)
						<option value="{{$dealer->id}}">{{"[" . str_pad($dealer->id, 10, '0', STR_PAD_LEFT) . "] - " . $dealer->first_name . " " . $dealer->last_name }} </option>
					@endforeach
				@else 
					<option value="">No autolinked users found</option>
				@endif 
			</select>
		</span>
		<span class="dealer_selected_id" id="dealerid-{{ $id }}" rel="{{ $id }}" style="display: none;"></span>
		<input type="hidden" id="dealer_id_{{ $id }}" value="0" />
	</td>								
	<td class="col-xs-3">
		<span class="dealer_selected" id="dealer-{{ $id }}" rel="{{ $id }}"></span>
	</td>
	<td class="col-xs-3">
		<a href="javascript:void(0);" class="sp_popup" rel="{{ $id }}">Special&nbsp;Price</a>
	</td>
	<td class="col-xs-1">
		<a href="javascript:void(0);" id="addsppn-{{ $id }}" class="die addsppn form-control text-center text-green" rel="{{ $id }}">
			<i class="fa fa-plus-circle"></i>
		</a>
		<a href="javascript:void(0);" id="remsppn-{{ $id }}" class="remsppn form-control text-center text-danger" rel="{{ $id }}" style="display:none;">
			<i class="fa fa-minus-circle"></i>
		</a>
	</td>
</tr>
<script>
$(document).ready(function(){
	$("#userID-{{ $id }}").select2();
});
</script>