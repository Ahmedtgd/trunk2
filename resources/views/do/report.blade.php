<style type="text/css" media="screen">
.table > tbody > tr > td,th{
    border-top:none !important;
}
.tracking_info{
    font-weight: bold;
}    
</style>
@extends("common.default")
<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;

?>
@section("content")
@if(Auth::user()->hasRole('adm') || Auth::user()->hasRole('mer'))
@include('common.sellermenu')
@endif

    <div class="container"><!--Begin main cotainer-->
        <div class="row">
			<div class="col-sm-12">
			<br>
			{{-- Tracking Information section --}}
			<table
				style="margin-bottom:0"
				class="table tracking_info">    
			<tr> 
				<td style="padding:4px">Date Created</td>  
				<td style="padding:4px;font-weight:normal;">   
					@if($report_data->created_at!="-0001-11-30 00:00:00" && $report_data->created_at!="" && $report_data->created_at!="0000-00-00 00:00:00")
					{{UtilityController::s_date($report_data->created_at,true)}} 
					@endif
				</td>
				<td style="padding:4px" width="20%">&nbsp;</td>
				<td style="padding:4px">Date Checked</td>
				<td style="padding:4px;font-weight:normal;">
					@if($report_data->checked_on!="-0001-11-30 00:00:00" && $report_data->checked_on!="" && $report_data->checked_on!="0000-00-00 00:00:00")
					{{UtilityController::s_date($report_data->checked_on,true)}} 
					@endif
				</td>
			</tr>
			<tr>
				<td style="padding:4px;font-weight:bold">From Creator</td> 
				<td style="padding:4px;font-weight:normal">
					{{ $report_data->creator->first_name or '' }} {{ $report_data->creator->last_name or '' }}  {{ $report_data->creator->mobile_no or '' }}
				</td>
				<td style="padding:4px" width="20%">&nbsp;</td>
				<td style="padding:4px">To Checker</td> 
				<td style="padding:4px;font-weight:normal">
				{{ $report_data->checker->first_name or '' }} {{ $report_data->checker->last_name or '' }} {{ $report_data->checker->mobile_no or '' }} 
			</td>
			
			</tr>
			{{-- <tr>
				<td>{{ $report_data->creator->first_name or '' }} {{ $report_data->creator->mobile_no or '' }}</td>
				<td>{{ $report_data->checker->first_name or '' }} {{ $report_data->checker->mobile_no or '' }}</td>
			</tr> --}}
			<tr>
				<td style="padding:4px">Sender&nbsp;Company</td> 
				<td style="padding:4px;font-weight:normal">
				{{ $report_data->creator_company->company_name or '' }} </td>
				<td style="padding:4px" width="20%">&nbsp;</td>
				<td style="padding:4px">Recipient&nbsp;Company</td>
				<td style="padding:4px;font-weight:normal">
					{{ $report_data->checker_company->company_name or '' }} </td>
			</tr>

			<tr>
				<td style="padding:4px">Location</td>
				<td style="padding:4px;font-weight:normal">
				{{ $report_data->creator_location->location or '' }} </td>
				<td width="20%">&nbsp;</td>
				<td style="padding:4px">Location</td> 
				<td style="padding:4px;font-weight:normal">
				{{ $report_data->checker_location->location or '' }} </td>
			</tr>
			<tr>
				<td style="padding:4px">@if($report_data->ttype=="tout")
				Mode
				@endif
				</td>
				<td style="padding:0px;font-weight:normal">
					@if($report_data->ttype=="tout")
						{{ucfirst($report_data->mode)}}
					@endif
				</td>
				<td width="20%" style="padding:0">&nbsp;</td>
				<td style="padding:0;padding-left:4px">Remarks</td> 
				<td style="padding:0px;font-weight:normal"></td>
			</tr>
			<tr>
				<td style="padding:4px"></td>
				<td style="padding:4px;font-weight:normal"></td>
				<td width="20%">&nbsp;</td>
				<td style="padding:4px;font-weight:normal" colspan="2">
				<div class="col-md-12" style="padding-left:0;padding-right:0">

				<textarea class="" id="originalRemark"
					style="cursor:pointer;resize:none;width:77%;
						overflow:hidden;border-color:#e0e0e0;
						border-radius:5px"
					onclick="display_remarks();" row='2'i
						readonly>{{trim($report_data->remark)}}</textarea>
					<input type="hidden" name="remarkText" value=""
						id="remarkText">
				@if(!empty($report_data->image))

				<span style="vertical-align: middle;cursor:pointer;
					padding:20px;margin-left:10px;">
					<img src="{{asset('images/siso/'.$report_data->image)}}"
					class="pull-right"
					style="width:50px;height:50px;object-fit:cover;
					border-radius:5px; vertical-align: middle;"
					onclick="display_img()"
					id="imageresource">
				</span>
				@endif
				</div>
				</td>
			</tr>
			</table>
			{{-- Tracking Information section --}}
			</div>

			<?php
				$title="Tracking Report";
				$column="Creator";
				$column2="Lost";

				switch ($report_data->ttype) {
					case 'tin':
						$title="Stock In Report";
						break;
					case 'tout':
						# code...
						$title="Stock Out Report";
						break;
					case 'stocktake':
						$title="Stock Take Report";
						$column="O/B";
						$column2="Lost";
						break;
					case 'wastage':
						$title="Wastage Report";
						$column="O/B";
						$column2="Lost";
						break;
						break;
					default:
						// $title=ucfirst($report_data->ttype);
						break;
				}
			?>

			<div class="col-sm-12">
				<table class="table tracking_report">
					<tr>
						<th colspan="2" style="font-size:25px">
							{{$title}}</th>
						<th colspan="4" class="text-right"
							style="font-size:18px;vertical-align:middle">
							<div style="font-weight:normal;display:inline">
							Report ID.</div>
							{{UtilityController::nsid($report_data->id,10,"0")}}</th>
					</tr>    
					<tr style="border-bottom: 1px solid #ddd;">
						<th class="text-center" style="background-color: #948A54; color: white;">No</th>
						<th class="text-center" style="background-color: #948A54; color: white;">Product&nbsp;ID</th>
						<th class="" style="background-color: #948A54; color: white;">Name</th>
						<th class="text-center" style="background-color: #31859c; color: white;">{{$column}}</th>
						<th class="text-center" style="background-color: #984807; color: white;">Checker</th>
						<th class="text-center" style="background-color: #F79646; color: white;">{{$column2}}</th>
					</tr>
					@if(isset($report_data->report_products) && !empty($report_data->report_products))

						@foreach($report_data->report_products as $key => $products)
						<?php
						$quantity=$products->quantity;
						$received=$products->received;
						$opening_balance=$products->opening_balance;
						$lost=$quantity-$received;
						switch ($report_data->ttype) {
							case 'stocktake':
								
								if ($opening_balance>$quantity) {

									$lost=$opening_balance-$quantity;
									$quantity=$opening_balance;
								}
								break;
							case 'wastage':
								
								if ($opening_balance>$quantity) {

									$lost=$opening_balance-$quantity;
									$quantity=$opening_balance;
								}
								break;
							default:
								# code...
								break;
						}
						?>
						<tr style="border:1px solid #a0a0a0">
							<td style="vertical-align:middle" class="text-center">{{ $key+1 }}</td>
							<td style="vertical-align:middle" class="text-center">
							<a target="_blank" href="{{url('productconsumer',$products->product->id)}}">
							{{ IdController::nP($products->product->id) }}
							</a>
							</td>
							<td class="" style="vertical-align:middle;">
							<img src="{{asset('/')}}images/product/{{$products->product->parent_id}}/{{$products->product->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:0">&nbsp;&nbsp;{{ $products->product->name }}</td>
							<td style="vertical-align:middle" class="text-center">{{ $quantity or '' }}</td>
							<td style="vertical-align:middle" class="text-center">{{ $received or '' }}</td>
							<td style="vertical-align:middle" class="text-center">{{ $lost }}</th>
						</tr>
						@endforeach
					@endif
				</table>
			</div>
        </div>
    </div>
<br>
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Image Preview</h4>
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="width:400px;height:400px;object-fit:cover" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="RemarkModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 600px;height:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button"  class="close" data-dismiss="modal">
		<span aria-hidden="true">&times;</span>
		<!-- <span class="sr-only">Close</span> -->
			</button>
        <h4 class="modal-title" id="myModalLabel">Remarks</h4>
      </div>
      <div class="modal-body" style="margin-right: 15px;padding-bottom: 10px;
    padding-right: 0px;padding-left: 0px;">
        <textarea style="width:100%; height:200px;"
			id="productremark">{{trim($report_data->remark)}}</textarea>
        
        <input type="hidden" id="remarkproductid">
       
      </div>	  
      <div class="modal-footer" style="padding-top: 0px;border-top: none">
        <!-- <button type="button" class="btn btn-default"
			data-dismiss="modal">Close</button> -->
		<button type="button" class="btn bg-save"
			onclick="saveremark({{$report_data->id}});"
			style="border-radius:5px;">Save</button>
      </div>
	  
	  <br>
    </div>
  </div>
</div>

<script type="text/javascript">
	function display_img() {
		// Asign the image to the modal when the user click the enlarge link 
		$('#imagepreview').attr('src', $('#imageresource').attr('src'));
   		$('#imagemodal').modal('show'); // 
	}

	function display_remarks() {
		// var remarkText = '<?php //echo $report_data->remark; ?>';
		var remarkText = $('#remarkText').val();
		if(remarkText != ''){
			$('#productremark').val(remarkText);
		}
   		$('#RemarkModal').modal('show'); // 
	}

	// $("#productremark").blur(function(){

	// 	remark=$(this).val();
	// 	 if(remark !=''){

	// 	 }
	// 	console.log('==========')
	// 	console.log(remark);
	// });

	function saveremark(no)
	{
		console.log(no);
		var remark = $('#productremark').val();

		console.log(remark);
		if(remark != '') {
			var SubRemark = remark.substring(0,100);
            $('#originalRemark').val(SubRemark+'...');

			$.ajax({
				url: "{{URL('/stockreportremark/savestockremark')}}",
				type: 'POST',
				data: {remark:remark,srId:no},
				success: function(r) {
						
					if(r.status == "success")
					{
						$('#remarkText').val(remark);
						$("#RemarkModal").modal("hide");
						toastr.success("Remark save Successfully");
					
					}else{
						toastr.error("Some error occurred!");
					}					
				}
			});	
		}	
 	}
</script>
@stop
