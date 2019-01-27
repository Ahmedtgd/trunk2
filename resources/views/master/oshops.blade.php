<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 72px;
        font-weight: bold;
        margin: 300px 0 0 55%;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
        width: 85px;
    }
</style>
<?php $i=1; ?>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')

	<h2>Merchant Master: O-Shops</h2>
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="1720px" id="gridnetwork">
			<thead style="background-color: #FF4C4C; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">O-Shop&nbsp;ID</th>
					<th class="text-center blarge">Name</th>
				<!--	<th class="text-center medium">Size</th> -->
					<th class="text-center blarge">Contact&nbsp;Name</th>
					<th class="text-center blarge">Contact&nbsp;No.</th>
					<th class="text-center blarge">Country</th>
					<th class="text-center blarge">State</th>
					<th class="text-center blarge">City</th>
					<th class="text-center blarge">Area</th>
					<th class="text-center blarge">Merchant</th>
				</tr>
			</thead>
			<tbody>
				<?php $m = 0; ?>
				@foreach($oshops as $oshop)
				<?php $m++; ?>
				<tr>
					<td class="text-center">
						{{ $m }}
					</td>
					<td class="text-center">
						@if($oshop->single == 1)
							{{IdController::nOshop($oshop->id)}}
						@else
							<a href="{{route('oshop.one',['url'=>$oshop->url])}}" target="_blank" >{{IdController::nOshop($oshop->id)}}</a>
						@endif
						
					</td>
					<td class="">
						<?php
							/* Processed note */
							$pfullnote = null;
							$pnote = null;
							$elipsis = "...";
							$pfullnote = $oshop->oshop_name;
							$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

							if (strlen($pfullnote) > MAX_COLUMN_TEXT)
								$pnote = $pnote . $elipsis;
						?> 
						<span title='{{$pfullnote}}'>{{$pnote}}</span>						
					</td>
			
					<!--<td class="text-center">{{$oshop->shop_size}}</td>	-->				
					<td class="text-center">{{$oshop->contact_first_name}} {{$oshop->contact_last_name}}</td>					
					<td class="text-center">{{$oshop->contact_mobile_no}}</td>					
					<td class="text-center">{{$oshop->countryname}}</td>					
					<td class="text-center">{{$oshop->statename}}</td>					
					<td class="text-center">{{$oshop->cityname}}</td>					
					<td class="text-center">{{$oshop->areaname}}</td>
					<td class="text-center">
						<select class="form-control transferMerchant" rel-oshop="{{$oshop->id}}">
							<option selected="selected" value="0">Select Merchant to transfer to</option>
						</select>
					</td>													
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<div id="transferModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">O-Shop Transfer</h4>
      </div>
      <div class="modal-body">
      	{{-- Inputs --}}
      	<input type="hidden" id="origMerchant" value="{{$merchant_id}}">
      	<input type="hidden" id="transferToMerchant" value="">
      	<input type="hidden" id="oshop" value="">
        <p>Do you wish to transfer this O-Shop?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning" id="processTransfer">Yes</button>
      </div>
    </div>

  </div>
</div>
{{--  --}}
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
    $('#gridnetwork').DataTable({
        "order": [],
        "scrollX": true,
        "scrollY": false,
        "columnDefs": [
			{"targets": 'no-sort', "orderable": false, },
			{"targets": "medium", "width": "100px" },
			{"targets": "large",  "width": "120px" },
		//	{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px" }
		],
        "fixedColumns":  true
    });
    // Get transfer eligible merchants
    $.ajax({
    	type:'GET',
    	url:'{{url('admin/merchant/sbrand',$merchant_id)}}',
    	success:function(r){
    		if (r.status == "success") {
    			console.log(r.data);
    			var ht="";
    			for (var i = r.data.length - 1; i >= 0; i--) {
    				ht+="<option value='"+r.data[i].id+"'>"+r.data[i].company_name+"</option>";
    			}
    			$('.transferMerchant').append(ht);
    		}
    	}
    });
    $('.transferMerchant').change(function(){
    	if ($(this).val() != 0) {
    		$('#transferToMerchant').attr('value',$(this).val());
    		$('#oshop').attr('value',$(this).attr('rel-oshop'));
    		$('#transferModal').modal('show');
    	}
    	
    });
    $('#processTransfer').click(function(){
    	var oshop=$('#oshop').val();
    	var origMerchant=$('#origMerchant').val();
    	var transferToMerchant=$('#transferToMerchant').val();
    	var url="{{url('admin/oshop/transfer')}}";
    	data={
    		'oshop':oshop,
    		'origMerchant':origMerchant,
    		'transferToMerchant':transferToMerchant
    	};
    	$.ajax({
    		type:'POST',
    		url:url,
    		data:data,
    		success:function(r){
    			if (r.status == "success") {
    				toastr.info("O-Shop transfer successful");
    			}else{
    				toastr.warning("Some error happened. Please contact OpenSupport. #001")
    			}
    		},
    		error:function(){
    			toastr.warning("Some error happened. Please contact OpenSupport. #002");
    		}
    	});

    });
 });
</script>
@yield("left_sidebar_scripts")
@stop
