<?php 
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
$total=0;
$c=1;
?>
<table id="productlocation" cellspacing="0" class="table"
	style="width: 100%">
    <thead>
    
    <tr style="" class="bg-location">
        <th class="text-center">No.</th>
        <th class="text-center" >Location</th>  
        <th class="text-center">Qty</th>     
    </tr>
    </thead>

    <tbody>

        @if(!is_null($data))
        @foreach($data as $key=>$location)
		<tr>
			<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

			<td style="text-align: center; vertical-align: middle;">
			   {{$key}}
			</td>
			
			<td style="text-align: center; vertical-align: middle;">
				{{$location}}
			</td>
		
		</tr>
		<?php $c++;?>
        @endforeach
        @endif
    </tbody>
</table>

<script type="text/javascript">
  $(document).ready(function(){
	  
		$(document).delegate( '.product_sku', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#sinputproduct_sku" + id).show();
		});		
		
		$(document).delegate( '.product_sku_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			$.ajax({
				type: "POST",
				data: {data: value},
				url: JS_BASE_URL + "/product/sku/" + id,
				dataType: 'json',
				success: function (data) {
					$("#sinputproduct_sku" + id).hide();
					$("#product_sku" + id).html(value);
					$("#product_sku" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});		  
	var table = $('#productlocation').DataTable({
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
	$(".dataTables_empty").attr("colspan","100%");

    $('.product_map_delete').click(function(){
        url="{{url('product/map/delete')}}";
        pid=$(this).attr('rel-pid');
        $this=$(this);
        $.ajax({
            url:url,
            type:'POST',
            data:{'pid':pid},
            success:function(r){
                if (r.status=="success") {
                    $this.prop('disabled',true);
                    toastr.info(r.long_message);
                    $('.pmd_message').html('<span class="text-warning">Product has not been mapped.</span>');
                    $this.hide();
                }else{

                    toastr.warning(r.long_message);
                }
            },
            error:function(){toastr.warning("Could not connect to server.")}

        });

    });
  });

</script>
