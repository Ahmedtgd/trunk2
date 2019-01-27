<table style="width: 100%; " id="stationlist" class="table ">
    <thead class="bg-gator">
        <tr >
            <th scope="col">No</th>
            <th scope="col">Merchant ID</th>
            <th scope="col">Business Reg No</th>

            <th scope="col">Company Name</th>
            <!--  <th scope="col">Name</th> -->
            <th class="text-center" scope="col">Action</th>

        </tr>
    </thead>
    <tbody style="text-align: center;">
        <?php $count =1; ?>
        @foreach($stations as $station)
        <tr style="text-align: left">
            <td>{{$count++}}</td>
            <td>{{$station->nseller_id}}</td>
            <td>
                @if($station->status == "linked")
                {{$station->business_reg_no}}
                @else
                <a onclick="showemerchantdetail({{$station->merchant_id}})"
					href="javascript:void(0)">{{$station->business_reg_no}}</a>
                @endif
            </td>
            <td>{{$station->company_name}}</td>

            {{--   <td>{{$station->name}}</td> --}}
            <td class="text-center"><button class="btn btn-primary" style="border-radius: 5px;" 
                @if($station->status == "linked")
                onclick="selectedstation('{{$station->merchant_id}}',0,'{{$station->name}}','{{$station->company_name}}','{{$station->nseller_id}}')"
                @else
                onclick="selectedstation('{{$station->merchant_id}}',1,'{{$station->name}}','{{$station->company_name}}','{{$station->nseller_id}}')"
                @endif
                >Select</button>

                <button data-toggle="modal" data-target="#deleteModal{{$count}}"
                @if($station->status == "linked")
                
                class="btn" style="background-color: #f0ad4e; color: white; border-radius: 5px;" >
				Unlink</button>
                @else
                class="btn btn-danger" style="border-radius: 5px;">Delete</button>
                @endif

            </td>

        </tr>
            <div id="deleteModal{{$count}}" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    @if($station->status == "linked")
                    <p class="text-danger">Are you sure to Unlink the Merchant?</p>

                    @else
                    <p class="text-danger">Are you sure to permanently delete the Merchant?</p>

                    @endif
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" @if($station->status == "linked")
                onclick="unlink({{$station->merchant_id}},{{$count}})"  @else
                onclick="delteemerchant({{$station->merchant_id}},{{$count}})" @endif class="btn btn-primary delete_location" >Yes</button>
                    <input type="hidden" id="activelocationid">
                </div>
            </div>

        </div>
    </div>
    @endforeach
</tbody>
</table>


<script type="text/javascript">
    $('#stationlist').DataTable({
        "order": [],
    });

    function showemerchantdetail(id) {
        $.ajax({
            type: "GET",
            url: JS_BASE_URL+"/seller/emerchantdetail/"+id,
            success: function( data ) {
                $("#emerchantdt").html(data);
				$('#emerchantdetailModal').modal('show');
			}
		});
    }

    function delteemerchant(id,index) {
		$.ajax({
			type: "GET",
			url: JS_BASE_URL+"/seller/deletegatorbuyer/"+id,
			success: function( data ) {
				$("#gator-buyer").html(data);
				toastr.success('Merchant Deleted');

				$('#deleteModal'+index).modal('hide');
				$('#myModal').modal('hide');
                $(".modal-backdrop").remove();
                $("#showselectedbuyer").html(" ");
                $('.total_of_goods').html('0.00');
                $('input[type=text]').attr('value','0');
                $('input[type=hidden]').attr('value','');
                $('input[name=user_id]').attr('value','');
                $('input[name=setbuyer]').attr('value','');
                $('input[name=isbuyer]').attr('value','');
                $('#gatorform').trigger("reset");
			}
		});
    }

    
    function unlink(id,index) {
		$.ajax({
			type: "GET",
			url: JS_BASE_URL+"/seller/unlinkgatorbuyer/"+id+"/{{$user_id}}",
			success: function( data ) {
				$("#gator-buyer").html(data);

				toastr.success('Merchant Unlinked');
				
				$('#deleteModal'+index).modal('hide');
				$('#myModal').modal('hide');
				
			}
		});
    }
</script>
