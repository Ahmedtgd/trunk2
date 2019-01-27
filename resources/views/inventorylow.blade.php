<?php
use App\Classes;
use App\Http\Controllers\IdController;
$num = 1;
?>
@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
    <div class="table-responsive" style="margin-bottom: 28px;">
    <h2>Inventory Low</h2>
            <table class="table table-bordered" cellspacing="0" id="station-open-channel" style="width:100% !important;">
                <thead style="background-color: #444; color: white;">
                <tr style="background-color: #444; color: white;">
                    <td class="no-sort bsmall">No</td>
                    <td class="">Product&nbsp;ID</td>
                    <td class="">Name</td>
                    <td class="bsmall">Qty&nbsp;Left</td>
                    <td class="bsmall">Qty&nbsp;Ordered</td>
                </tr>
                </thead>
                <tbody>

				@foreach($sproducts as $sproduct)
						<tr>
							<td align="center">{{ $num }}</td>
							<td>
								 <a href="{{url('productconsumer',$sproduct->parent_id)}}" target="_blank" class="view-product-modal" data-id="{{ $sproduct->productid }}">{{IdController::nP($sproduct->productid)}} </a>
							</td>
							<td align="left"><img src="{{asset('/')}}images/product/{{$sproduct->parent_id}}/{{$sproduct->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:4px"><span style="vertical-align: middle;">{{ $sproduct->productname }}</td>
							<td align="center">{{ $sproduct->qtyleft }}</td>
							<td align="center">{{ $sproduct->qtystock }}</td>
						</tr>
						<?php $num++; ?>
				@endforeach
                </tbody>
            </table>
     </div>
</div>

    <script>
        $(document).ready(function(){

        $('.view-station-modal').click(function(){

            var station_id=$(this).attr('data-id');
            var check_url=JS_BASE_URL+"/admin/popup/lx/check/station/"+station_id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/admin/popup/station/"+station_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                    }
                    if (r.status=="failure") {
                        var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                        $('#station-error-messages').html(msg);
                    }
                }
            });


        });

                var table = $('#station-open-channel').DataTable({
              
				'bScrollCollapse': true,
                'scrollX':true,
                'autoWidth':false,
                "order": [],
				"columnDefs": [
					{"targets": 'no-sort', "orderable": false, },
					{"targets": "medium", "width": "80px" },
					{"targets": "large",  "width": "120px" },
					{"targets": "approv", "width": "180px"},
					{"targets": "blarge", "width": "200px"},
					{"targets": "bsmall",  "width": "20px"},
					{"targets": "clarge", "width": "250px"},
					{"targets": "xlarge", "width": "300px" }
				],
                "fixedColumns":  false
            });

                

    });
 
    </script>
@stop