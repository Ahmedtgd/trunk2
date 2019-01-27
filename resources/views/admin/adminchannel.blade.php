<?php
use App\Classes;
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

	<h2>OpenChannel Administration</h2>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="1600px" id="gridmerchant">
			<thead style="background-color: #fd1919; color: white;">
				<tr>
					<th class="medium no-sort text-center">No</th>
					<th class="large text-center">Merchant&nbsp;ID</th>
					<th class="xlarge text-center">Name</th>
					<th class="large text-center">Station</th>
					<th class="large text-center">Since</th>
					<th class="large text-center">YTD</th>
                    <th class="large text-center">MTD</th>
                    <th class="large text-center">Active</th>
                    <th class="large text-center">Passive</th>
				</tr>
			</thead>
			<tbody>
				<?php $m = 0;
					  $users = array();
				?>
				@foreach($merchants as $merchant)
				<?php $m++;
					$users[$m] = $merchant->userid;
				?>
				<tr>
					<td class="text-center" style="width: 20px;">
						{{ $m }}
					</td>
					<td class="text-center large">
						<a target="_blank" href="{{route('merchantPopup', ['id' => $merchant->merchantid])}}" class="update" data-id="{{ $merchant->merchantid }}">{{IdController::nM($merchant->merchantid) }}</a>
					</td>

					<td class="text-center">
                        {{ $merchant->name }}	
					</td>
					
					<td class="text-center">
						<?php 
							$countauto = DB::table('autolink')->where('responder',$merchant->merchantid)->where('autolink.status','linked')->join('station','station.user_id','=','initiator')->count();
						?>
                        <a href="{{route('ochannelAll', ['id' => $merchant->userid])}}" target="_blank" class="prid" id="{{$merchant->userid}}">{{$countauto}}</a>
					</td>

					<td class="text-center">
						{{$currentCurrency}} {{number_format($merchant->since_sum/100,2)}}

					</td>
					
					<td class="text-center">
						{{$currentCurrency}} {{number_format($merchant->YTD/100,2)}}

					</td>
                    <td class="text-center">
                       {{$currentCurrency}} {{number_format($merchant->MTD/100,2)}} 

                    </td>                    
					<td class="text-center">
                       <?php 
							$countactive = DB::table('autolink')->where('responder',$merchant->merchantid)->where('autolink.status','linked')->join('station','station.user_id','=','initiator')->join('merchant','autolink.responder','=','merchant.id')->join('merchantproduct','merchant.id','=','merchantproduct.merchant_id')->join('sproduct','merchantproduct.product_id','=','sproduct.product_id')->join('stationsproduct','sproduct.id','=','stationsproduct.sproduct_id')->where('stationsproduct.station_id','=','station.id')->select('station.*')->distinct()->count();
						?>
						<a href="{{route('ochannelActive', ['id' => $merchant->userid])}}" target="_blank" class="prid" id="{{$merchant->userid}}">{{$countactive}}</a>
                    </td>
                    <td class="text-center">
						<a href="{{route('ochannelPasive', ['id' => $merchant->userid])}}" target="_blank" class="prid" id="{{$merchant->userid}}">{{$countauto - $countactive}} </a>                  

                    </td>
				</tr>
				@endforeach			
			</tbody>
		</table>
	</div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="myBody"></div>
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
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
	/**** ****/
    $('#gridmerchant').DataTable({
        "order": [],
        "scrollX": true,
        "scrollY": false,
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
        "fixedColumns":  true
    });
	
    function removeMessage() {
        $('.removeable').fadeOut(7000);
//            $('.removeable').remove();
    }
    setTimeout(removeMessage, 2000);


            var table_modal;


  /*  $(".prid").click(function () {


        $('#modal-Tittle').html("");

        if(table_modal){
            table_modal.destroy();
            $('#myTable').empty();
        }

        _this = $(this);

        var id_merchant= _this.attr('id');
        var pname= $('#pname' + id_merchant).val();
        var url = '/admin/master/getstationchannel/'+id_merchant;

        $.ajax({
            type: "GET",
            url: url,
            async:false,
            success: function (data) {

              console.log(data);

            $('#myBody').html(data);
            $("#myModal").modal("show");
               


            },
            error: function (error) {
                console.log(error);
            }
        });

    });*/


    $(".selectstationchannel").change(function()
    {
        document.location.href = window.location.protocol + "//" + window.location.host + "/"+$(this).val();
    });

});
</script>
@yield("left_sidebar_scripts")
@stop
