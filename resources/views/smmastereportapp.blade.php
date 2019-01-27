<?php
use App\Classes;
use App\Classes\Approval;
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
            margin-top: 10px;
            width: 100px;
        }
        .small-act-link:hover{
            text-decoration: underline;
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

    <div class="container" style="margin-top:30px; margin-bottom:30px;">
        @include('admin/panelHeading')
                {{-- @if(isset($stations)) --}}
		<div class='row'>		
			<div class='col-xs-6'><h2>Social Media Marketeer Master &nbsp;<small style="font-size:.4em;" class="small-act-link"><a href="javascript:void(0);" class="smm-mode-change" data-id="1" >Refresh</a></small></h2></div>
			<div class='col-xs-6'>
				@foreach($smmastereport as $report)
					<a class="btn btn-default role_status_button pull-right add_remark" role="sales_staff" do_status="add_remark" current_role_id="{{$report['sst_id']}}" style="width: 110px !important;" href="javascript:void(0)"> Add Remark </a>
				@endforeach
			</div>	
		</div>	
                        
<?php $i=1;?><table class="table table-bordered" cellspacing="0" width="100%" id="product_details_table">
                                <thead style="background-color:#558ED5; color:#fff;">
                                {{-- <tr>
                                    <th colspan="4">Social Media Marketeer Master</th>
                                    <th colspan="7">Network Information</th>
                                    <th colspan="3">Geographical</th>
                                    <th colspan="3">Others</th>
                                </tr> --}}
                                <tr>
                                    <th class='no-sort'>No</th>
                                    <th>SMM&nbsp;ID</th>
                                    <th style="width:200px;">Name</th>
                                 <!--    <th>Friends</th>
                                    <th>Share&nbsp;Item</th>
                                    <th>Share&nbsp;Time</th>
                                    <th>Clicked</th>
                                    <th>Item&nbsp;Sold</th>
                                    <th>Bought</th>
                                    <th style="width:120px;">Last&nbsp;Share</th>
                                    <th>Source</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th style="width:120px;">City</th>
                                    <th>Area</th>-->
                                   <th class="xlarge" style="background-color:#008000;color:#fff">Remarks</th> 
                                   <th style="background-color:#008000;color:#fff">Status</th>
                                   <th style="background-color:#008000;color:#fff">Approval</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($smmastereport as $report)
                                @if($report['user_id']==null)
                                <?php continue;?>
                                @endif
                                <tr>

                                    <td style="text-align: center;">
                                        {{$i++}}
                                    </td>
                                    <td>
                                        <?php
                                        $smm_id = str_pad($report['user_id'], 10, '0', STR_PAD_LEFT);
                                        ?>
                                            <a href="javascript:void(0);" class="view-user-modal" data-us-id="{{$report['user_id']}}">
                                            {{$report['trans']->smm_id}}</a>
                                    </td>
                                    <td>
                                        {{$report['first_name']}} {{$report['last_name']}}
                                    </td>
                                 <!--    <td style="text-align: center;">
                                        {{$report['trans']['friends']}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$report['trans']['share_item']}}
                                    </td>
                                    <td style="text-align: center;">
                                       {{$report['share_time']}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$report['trans']['click']}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['trans']['bought']}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['trans']['money']}}
                                    </td>

                                    <td style="text-align: center;">
                                    {{ date('dMy h:m', strtotime($report['trans']['last_share'])) }}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['trans']['sme']}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['geo']['country']}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['geo']['state']}}
                                    </td>
                                     <td style="text-align: center;">
                                        {{$report['geo']['city']}}
                                    </td>
                                    <td style="text-align: center;">
                                      {{$report['geo']['area']}}
                                    </td>-->

                                      <td id="remarks_column" class="text-center">
                                    <?php
                                        $remark = DB::table('remark')
                                        ->select('remark')
                                        ->join('sales_staffremark','sales_staffremark.remark_id','=','remark.id')
                                        ->where('sales_staffremark.sales_staff_id',$report['sst_id'])
                                        ->orderBy('remark.created_at', 'desc')
                                        ->first();
                                    ?>
                                        <a href="javascript:void(0)" id="mcrid_{{$report['sst_id']}}" class="mcrid" rel="{{$report['sst_id']}}">
                                            @if($remark)
                                                {{$remark->remark}}
                                            @endif
                                        </a>
                                    </td> 

                                    <td id="status_column" class="text-center">
                                        <span id="status_column_text">
                                            {{ucfirst($report['status'])}}
                                        </span>
                                    </td>

                                      <td>
                                        <div class="action_buttons">
                                            <?php
                                            $approve = new Approval('sales_staff', $report['sst_id']);
                                            if ($report['status'] == 'active') {
                                                $approve->getSuspendButton();
                                            } else if ($report['status'] == 'suspended' || $report['status'] == 'rejected') {
                                                $approve->getReactivateButton();
                                            }
                                            echo $approve->view;
                                            ?>
                                        </div>
                                    </td> 

                                </tr>
                                @endforeach
                                </tbody>
                            </table>

<script type="text/javascript">
      /*          var table = $('#product_details_table').DataTable({
                "scrollX": true,
                "order": [],
                "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
                    },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
                "fixedColumns":  true
            });

            $('#product_details_table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(tr) ).show();
                    tr.addClass('shown');
                }
            } );*/

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.view-user-modal').click(function () {
            var user_id= $(this).attr('data-us-id');
            url=JS_BASE_URL+"/admin/popup/user/"+user_id;
            var w= window.open(url,"_blank");
            w.focus();
        });
    });
</script>
               {{-- @endif --}}
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

    <script src="{{url('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
        /*    var all_url="{{url('admin/master/smm/slct')}}";
            var slct_url="{{url('admin/master/smm/slct')}}";
            var type='GET';
            $.ajax({
                url:slct_url,
                type:type,
                success:function(resp){
                    $('#smm-content-area').html(resp);
                    
                }

            });
            $('.smm-mode-change').click(function(){
                $('#smm-content-area').empty();
                var data_id=$(this).attr('data-id');

                var $this= $(this);
                if (data_id==1) {
                                $.ajax({
                url:all_url,
                type:type,
                success:function(resp){
                    $('#smm-content-area').html(resp);
                    // $('.smm-mode-change').text("Click to view transactional SMM");
                    $this.attr('data-id','2')

                }

            });
                }
                if (data_id==2) {
                $.ajax({
                url:slct_url,
                type:type,
                success:function(resp){
                    $('#smm-content-area').html(resp);
                    // $('.smm-mode-change').text("Click t");
                    $this.attr('data-id','1');
                }

            });
                }
            });*/
        });
    </script>

    <script>
        $(document).ready(function(){
            function pad (str, max) {
                str = str.toString();
                return str.length < max ? pad("0" + str, max) : str;
            }

            function format ( tr ) {

                var j = tr.attr('data-last');

                var table='<table class="table child_table" cellspacing="0" width="100%">';
                table+='<thead>';
                table+='<tr><th>Id</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Sub Total</th></tr>';
                table+='</thead>';
                table+='<tbody>';

                for (i = 1;i<=j;i++){
                    var id = tr.attr('data-id-'+i);
                    var name = tr.attr('data-name-'+i);
                    var qty = tr.attr('data-qty-'+i);
                    var price = tr.attr('data-price-'+i);
                    var des = tr.attr('data-des-'+i);
                    var total = tr.attr('data-total-'+i);
                    table+='<tr><td>'+id+'</td><td>'+name+'</td><td>'+des+'</td><td>'+qty+'</td><td>'+price+'</td><td>'+total+'</td></tr>';
                }

                table+='</tbody>';
                table+='</table>';

                return table;
            }

            var table = $('#product_details_table').DataTable({
                "scrollX": true,
                "order": [],
                "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
                    },			
					{"targets": "medium", "width": "80px"},
					{"targets": "bmedium", "width": "100px"},
					{"targets": "large",  "width": "120px"},
					{"targets": "bsmall",  "width": "20px"},
					{"targets": "approv", "width": "180px"}, //Approval buttons
					{"targets": "blarge", "width": "200px"}, // *Names
					{"targets": "clarge", "width": "250px"},
					{"targets": "xlarge", "width": "300px"},], //Remarks + Notes ],
					"fixedColumns":  true
				});

            $('#product_details_table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(tr) ).show();
                    tr.addClass('shown');
                }
            } );


            $('#shipping_details_table').DataTable();
            $('#lower_product_detail_table').DataTable();
            $('#payment_detail_products').DataTable();
            $('#voucher_payment_detail').DataTable();
            $('#open_wish_table').DataTable();
            $('#auto_link_table').DataTable();
            $('#auto_link_table_2').DataTable();


            var vtable = $('#voucher_detail_table').DataTable({
                "columnDefs": [ {
                    "targets": 0,
                    "data": null,
                    "className":      'details-control-2',
                    "orderable":      false,
                    "defaultContent": ""
                } ]
            });

            $('td.details-control-2').on('click', function () {
                console.log('clicked');
                var tr = $(this).closest('tr');
                var row = vtable.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(tr) ).show();
                    tr.addClass('shown');
                }
            } );


            $('#datetimepicker , #datetimepickerr').on('change',function(){
                var date1 = $('#datetimepicker').val();
                var date2 = $('#datetimepickerr').val();

                $('#dateSince').html(date1);

                $.ajax({
                    url: '{{url('/merchant/calc-sale')}}',
                    data: {'date1': date1, 'date2' : date2},
                    headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                    error: function() {

                    },
                    success: function(response) {
                        $('#amountSince').html(response.payment);
                        $('#amountBetween').html(response.paymentSince);
                    },
                    type: 'POST'
                });
            });

            $(".mcrid").click(function () {
                _this = $(this);
                var id_smm= _this.attr('rel');

                $('#modal-Tittle2').html("Remarks");

                var url = '/admin/master/sales_staff_remarks/'+ id_smm;
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #558ED5; color: white;'><th>No</th><th>SMM ID</th><th>Status</th><th>Admin User ID</th><th>Remarks</th><th>DateTime</th></tr>";
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
                            html += "<tr>";
                            html += "<td>"+(i+1)+"</td>";
                            html += "<td><a href='../../admin/popup/user/"+id_smm+"' class='update' data-id='"+id_smm+"'>"+pad(id_smm.toString(),10)+"</a></td>";
                            html += "<td>"+obj.status+"</td>";
                            html += "<td><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>"+pad(obj.user_id.toString(),10)+"</td>";
                            html += "<td>"+obj.remark+"</td>";
                            html += "<td>"+obj.created_at+"</td>";
                            html += "</tr>";
                        }
                        html = html + "</table>";
                        $('#myBody2').html(html);
                        $("#myModal2").modal("show");
                    }
                });
            });
        });
    </script>
    @yield("left_sidebar_scripts")
@stop
