<?php use App\Http\Controllers\IdController;?>
@if(!is_null($prefs))
    {{--{{ $sr = 1 }}--}}

    <table class="table table-responsive table-bordered" id='sourceTable'>
        <tbody>

        <tr>
            {{--<th>S.No</th>--}}
            <td>Order Id</td>
        </tr>

        @foreach($prefs as $pref)
            <tr>
                {{--<td>--}}
                    {{--{{ $sr++ }}--}}
                {{--</td>--}}
                <td>
                  <a href="javascript:void(0)" class="view-orderid-modal" data-id="{{$pref->porder_id }}">  {{ IdController::nO($pref->porder_id) }} </a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endif
<script type="text/javascript">
	$(document).ready(function () {
		$('.view-orderid-modal').click(function(){
			var porder_id=$(this).attr('data-id');
			var check_url=JS_BASE_URL+"/admin/popup/lx/check/order/"+porder_id;
			$.ajax({
				url:check_url,
				type:'GET',
				success:function (r) {
				console.log(r);
				
				if (r.status=="success") {
					var url=JS_BASE_URL+"/deliveryorder/"+porder_id;
					
					var w=window.open(url,"_blank");
					w.focus();
				}
				if (r.status=="failure") {
				var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
				$('#orderid-error-messages').html(msg);
				}
				}
				});
		});
	});
</script>