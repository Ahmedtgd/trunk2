<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 95);
define('MAX_COLUMN_TEXT2', 60);
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
    table#grid4c
	{
	    table-layout: fixed;
	    max-width: none;
	    width: auto;
	    min-width: 100%;
	}
</style>
<?php $i=1; ?>
<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="remarks-form">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_remarks" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_remarks" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_role_roleId" remarks_role="" >
							<input type="hidden" id="current_status" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>
<div class="overlay" style="display:none;">
    <p><span style="position: relative;" class="all-filter-fa"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
	<h2>Merchant Campaign Master</h2>
	<span  id="recruiter-error-messages">
    </span>
<span  id="merchant-error-messages">
    </span>
	<div class="">
		<table class="table table-bordered" cellspacing="0" width="100%" id="grid4c">
			<thead style="background-color: #D94C54; color: #fff;">
				<tr>
					<th class="text-center no-sort bsmall">No</th>
					<th class="text-center bmedium">Campaign</th>
					<th class="text-center blarge">Merchant</th>
					<th class="text-center bmedium">Frecuency</th>
					<th class="text-center medium" style="background-color: #008000; color: #fff;">Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach($campaigns as $campaign)
				<tr>
					<td class="text-center">
						{{$i++}}
					</td>

					<td class="text-center">
						<a href="javascript:void(0)" class="template" rel="{{$campaign->id}}" relid="{{STR_PAD($campaign->id,10,'0',STR_PAD_LEFT)}}">{{ $campaign->name }}</a>
					</td>

					<td>
					<?php
                        /* Processed remark */
                        $pfullremark = null;
                        $premark = null;
						$elipsis = "...";
						$pfullremark = $campaign->company_name;
						$premark = substr($pfullremark,0, MAX_COLUMN_TEXT2);

						if (strlen($pfullremark) > MAX_COLUMN_TEXT2)
							$premark = $premark . $elipsis;
					?>					
						<span title='{{$pfullremark}}'>{{$premark}}</span>
					</td>
					<td class="text-center">
						<a href="javascript:void(0)" class="frecuency" rel="{{$campaign->id}}">{{ $campaign->logcount }}</a>
					</td>
					<td id="status_column" class="text-center">
						<span id="status_column_text">
							<a class="approval_details" rel="{{ $campaign->id }}" target="_blank"  href="{{route('campaignApproval', ['id' => $campaign->id])}}"> 
								@if($campaign->status == 'sendpending')
									Send Pending
								@else
								 {{ucfirst($campaign->status)}}
								@endif 
							</a>
						</span>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalcommission" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Commission Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div id="myBody">
					<table id="myTableMC" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModalTemplate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="h4tname"></span> <span class="pull-right" id="h4id"></span></h4>
            </div>
            <div class="modal-body">
                <div id="myBody">
					<p><b>Template Name</b></p>
					<input type="text" value="" class="form-control" id="template_name" />
					<br>
					<p><b>Template Body</b></p>
					<textarea class="form-control" id="info-template">
						
					</textarea>
					
					<a class='btn btn-primary save_template pull-right' href='javascript:void(0)' > Save</a>
					<br>
					<br>
					<input type="hidden" value="0" id="campaign_id" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
					class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div> 
<!-- Modal -->
<div class="modal fade" id="myModalTemplate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="h4tname"></span> <span class="pull-right" id="h4id"></span></h4>
            </div>
            <div class="modal-body">
                <div id="myBody">
					<p><b>Template Name</b></p>
					<input type="text" value="" class="form-control" id="template_name" />
					<br>
					<p><b>Template Body</b></p>
					<textarea class="form-control" id="info-template">
						
					</textarea>
					
					<a class='btn btn-primary save_template pull-right' href='javascript:void(0)' > Save</a>
					<br>
					<br>
					<input type="hidden" value="0" id="campaign_id" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
					class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="myModalFrecuency" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="h4tname"></span> <span class="pull-right" id="h4id"></span></h4>
            </div>
            <div class="modal-body">
                <div id="frecuencybody">
			
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
					class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div> 
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

		$(document).delegate( '.frecuency', "click",function (event) {
			var id = $(this).attr('rel');
			console.log("EPA");
			$.ajax({
				type: "GET",
				url: JS_BASE_URL + "/seller/companycampaign/frecuency/" + id,
				success: function (data) {
					console.log("EPA2");
					$("#frecuencybody").html(data);
					//toastr.info('Template Successfully saved');
					$("#myModalFrecuency").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});				
		});	
		
		$(document).delegate( '.save_template', "click",function (event) {
			var id = $("#campaign_id").val();
			var value = $("#info-template").summernote("code");
			var name = $("#template_name").val();
			$.ajax({
				type: "POST",
				data: {data: value, name: name},
				url: "/seller/companycampaign/template/" + id,
				dataType: 'json',
				success: function (data) {
					$("#template" + id).html(name);
					toastr.info('Template Successfully saved');
					$("#myModalTemplate").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});				
		});
		
		$(document).delegate( '.template', "click",function (event) {
			var id = $(this).attr('rel');
			var nid = $(this).attr('relid');
			$("#campaign_id").val(id);
			$.ajax({
				type: "GET",
				url: "/seller/companycampaign/template/" + id,
				dataType: 'json',
				success: function (data) {
					$("#info-template").summernote("code", data.template);
					$("#template_name").val(data.template_name);
					$("#h4tname").html(data.template_name);
					$("#h4id").html("[" + nid + "]");
					
					$("#myModalTemplate").modal('show');
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
			
		});	
	
	$('#grid4c').DataTable({
		//'scrollX':true,
		 'autoWidth':true,
		 "order": [],
		 "columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{"targets": "medium", "width": "80px"},
				{"targets": "bmedium", "width": "100px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "approv", "width": "180px"}, //Approval buttons
				{"targets": "blarge", "width": "200px"}, // *Names
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
			]
	});

});
</script>
@stop
