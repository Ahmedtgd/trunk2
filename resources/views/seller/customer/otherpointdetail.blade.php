<style type="text/css">
    .pad-control{
        width:70px;
        height:70px;
        border-radius: 10px;
    }
    .red{
        background-color: #FF0402;
        color: white
    }
    .textblack{
        color:black;
    }
    .numaric{
        background-color: #0580FE;
    color: white;
    }
</style>
<label id="pettycashInOutLabel" style="color:red;"></label>
@if($log->type=="in")
	<button
	style="position:relative;top:-8px"
	class="btn pad-control textblack margin-left0 numaric">In</button>
@else
	<button
	style="postition:relative;top:8px"
	class="btn pad-control textblack red">Out</button>
@endif
	<br>
	<table class="table" style="width: 100%">
		<tr>
			<td class="text-left">Mode</td>
			<td class="otherpointtype">{{ucfirst($log->type)}}</td>
		</tr>
		<tr>
			<td class="text-left">Staff&nbsp;ID</td>
			<td class=""> <?php printf('%06d',(int)$log->user_id); ?></td>
		</tr>
		<tr >
			<td class="text-left">Staff&nbsp;Name</td>
			<td class="">
				{{$log->first_name." ".$log->last_name}}
			</td>
		</tr>
		<tr>
			<td class="text-left">Pts</td>
			<td >
				<input type="text" class="form-control"
				value="{{$log->points}}"
				style=" background-color: black;color: white;vertical-align: middle;"
				disabled="disabled">
			</td>
		</tr>
	</table>
