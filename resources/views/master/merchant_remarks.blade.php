@extends("common.default")

<?php
use App\Classes;
use App\Http\Controllers\IdController;
?>

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
    table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
</style>
<?php $i=1; ?>
    <div class="container" style="margin-top:30px;">
		@include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">
				<div class='row'>
					<div class='col-xs-6'><h2>Merchant Master: Remarks</h2></div>
					<div class='col-xs-6'>
						&nbsp;
					</div>	
					<div class="clearfix"></div>	
					<div class='col-xs-6'>
					<h3>Merchant ID: 
					<a href="{{URL::to('/')}}/admin/popup/merchant/{{$merchant_id}}"
						target="_blank" >
						{{IdController::nM($merchant_id)}}
					</a>
					</h3>
					</div>
				
					<div class='col-xs-6'>&nbsp;</div>
				</div>	
                <div class="tableData">
					<div class="table-responsive">
						<table class="table table-bordered" cellspacing="0" width="100%" id="product_details_table2">
							<thead>
							<tr style="background-color: #FF4C4C; color: #fff;">
								<th class='text-center' style="width: 120px;">No</th>
								<th class='text-center'>Section</th>
								<th class='text-center xlarge'>Comment</th>
								<th class='text-center'>Approval</th>
							</tr>
							</thead>
							<tbody>

							@if(isset($sections) && !empty($sections))
								@foreach($sections as $section)
									<?php
										$rstyle = "";
										if($section['status'] == 'pending'){
											$rstyle = "background-color: rgba(240, 255, 0, 0.4);";
										}
										if($section['status'] == 'rejected'){
											$rstyle = "background-color: rgba(255, 111, 111, 0.4);";
										}
										if($section['status'] == 'approved'){
											$rstyle = "background-color: rgba(111, 255, 148, 0.4);";
										}
									?>
									<tr >
										<td style='{{$rstyle}}' class="text-center">{{$i}}</td>
										
										<td class="text-center" style='{{$rstyle}}'>
											{{ucfirst($section['description'])}}
										</td>
										
                                        <td id="remarks_column" class="xlarge" style='{{$rstyle}}'>
                                            <a href="javascript:void(0)" rel="{{$section['aprid']}}" class="aprremark">{{$section['comment']}}</a>
                                        </td>
										<td class="text-center" style='{{$rstyle}}'>
											{{ucfirst($section['status'])}}
										</td>										
									</tr>
									<?php $i++; ?>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
                </div>				
<?php $i=1; ?>				
                <div class="tableData">
					<div class="table-responsive">
						<table class="table table-bordered" cellspacing="0" width="100%" id="product_details_table">
							<thead>
							<tr style="background-color: #FF4C4C; color: #fff;">
								<th class='text-center'>No</th>
								<th class='text-center'>Status</th>
								<th class='text-center'>Admin&nbsp;User&nbsp;ID</th>
								<th class='text-center xlarge'>Remarks</th>
								<th class='text-center'>DateTime</th>
							</tr>
							</thead>
							<tbody>

							@if(isset($remarks) && !empty($remarks))
								@foreach($remarks as $remark)
									<tr>
										<td style="text-align: center;">{{$i}}</td>
										
										<td class="text-center">
											{{ucfirst($remark->status)}}
										</td>
										
										<td class="text-center">
											<a href="{{URL::to('/')}}/admin/popup/user/{{$remark->user_id}}" target="_blank">
												{{IdController::nB($remark->user_id)}}
											</a>
										</td>
                                        <td id="remarks_column" class="xlarge">
                                            {{$remark->remark}}
                                        </td>
										<td class="text-center">
											{{$remark->created_at}}
										</td>										
									</tr>
									<?php $i++; ?>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
                </div>
				
				
            </div>
            {{--Model Form End--}}
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
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <script type="text/javascript">
		$(document).ready(function () {
			var table = $('#product_details_table').DataTable({
				"order": [],
				"scrollX":true,
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
				],
				"fixedColumns":   {
					"leftColumns": 2
				}
			});
			
			$(document).delegate( '.aprremark', "click",function (event) {
				_this = $(this);
				var id_apr= _this.attr('rel');

				$('#modal-Tittle2').html("Remarks");

				var url = '/admin/master/apr_remarks/'+ id_apr;
				$.ajax({
					type: "GET",
					url: url,
					dataType: 'json',
					success: function (data) {
						console.log(data);
						var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th class='text-center'>No</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
						for (i=0; i < data.length; i++) {
							var obj = data[i];
							html += "<tr>";
							html += "<td class='text-center'>"+(i+1)+"</td>";
							html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
							if(obj.nbuyer_id == null){
								html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>"+obj.user_id+"</td>";
							} else {
								html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>"+obj.nbuyer_id+"</td>";
							}
							
							html += "<td>"+obj.remark+"</td>";
							html += "<td class='text-center'>"+obj.created_at+"</td>";
							html += "</tr>";
						}
						html = html + "</table>";
						$('#myBody2').html(html);
						$("#myModal2").modal("show");
					}
				});
	});			
			
		/*	var table = $('#product_details_table2').DataTable({
				"order": [],
				"scrollX":true,
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
				],
				"fixedColumns":   {
					"leftColumns": 2
				}
			});		*/	
		});
    </script>
@stop
