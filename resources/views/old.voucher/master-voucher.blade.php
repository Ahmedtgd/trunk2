@extends("common.default")
<?php
    use App\Classes;
    define('MAX_COLUMN_TEXT', 95);
    use App\Http\Controllers\UtilityController;
    use App\Http\Controllers\IdController;
?>
@section("content")
<style type="text/css">
    .action_buttons{
        display: flex;
    }
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

</style><?php ?>


<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')
    <div class="equal_to_sidebar_mrgn">

        <h2>Voucher Master</h2>
	<span  id="merchant-error-messages">
    	</span>

        <!-- <hr/> -->
        <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
        <button type="button" id="btn-add" class="btn btn-primary btn-md hidden" style="float:right;">Add Discount</button>
        <br/>

        <!-- <hr> -->


        <div class="table-wrapper">
            <table class="table table-striped display cell-border" cellspacing="0" width="1380px" id="voucher_details_table">
                <thead>
                    <tr>
                        <th class="text-center bsmall" style="background-color: #4F6328; color: white;">No</th>
                        <th class="text-center bmedium" style="background-color: #4F6328; color: white;">Voucher&nbsp;ID</th>
                        <th class="text-center bmedium" style="background-color: #4F6328; color: white;">Merchant&nbsp;ID</th>
                        <th class="text-center bmedium" style="background-color: #4F6328; color: white;">Order&nbsp;Received</th>
                        <th class="text-center bmedium" style="background-color: #4F6328; color: white;">Executed</th>
                        <th class="text-center bmedium" style="background-color: #4F6328; color: white;">Left</th>
                        <th class="text-center bmedium" style="background-color: #4F6328; color: white;">Due</th>
                        <th class="text-center bmedium" style="background-color: #4F6328; color: white;">Source</th>
                        <th class="text-center bmedium" style="background-color: #4F6328; color: white;">Validity</th>
                        <th class="text-center xlarge" style="background-color: #595959; color: white;">Remarks</th>
                        <th class="text-center medium" style="background-color: #595959; color: white;">Status</th>
                        <th class="text-center approv" style="background-color: #595959; color: white;">Approval</th>

                    </tr>
                </thead>
                <tbody id="">
                    <?php $count = 1; ?>
                    @foreach($vouchers as $i)
                    <?php
                    $date_left = date_diff(date_create($i['voucher_timeslot']->booking), date_create(date("d-M-Y H:i:s")));
                    $temp['days_left'] = $date_left->format('%a days, %h hours and %i minutes');
                    ?>
                    <tr >
                        <td class="text-center">{{$count}}</td>

                        <td class="text-center" style="cursor: pointer;" onclick="getSingleVoucher({{$i['voucher']->id}})">
			<a target="_blank" href="javascript:void(0)" >[{{str_pad($i['voucher']->id, 10, '0', STR_PAD_LEFT)}}]</a>
			</td>
                       
			<td class="text-center">
			<!--<a target="_blank" href="{{route('merchantPopup', ['id' => $i['merchant_id']?$i['merchant_id']->id:0])}}" class="update" data-id="{{ $i['merchant_id']?$i['merchant_id']->id:0 }}">[{{str_pad($i['merchant_id']?$i['merchant_id']->id:0, 10, '0', STR_PAD_LEFT)}}]</a>-->
			<a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$i['merchant_id']?$i['merchant_id']->id:0}}">{{IdController::nM($i['merchant_id']?$i['merchant_id']->id:0)}}</a>
			 

			</td>
                        <td class="text-center">{{ Date("dMy H:i",strtotime($i['voucher']->created_at))}}</td>
                        <td class="text-center">{{Date("dMy H:i",strtotime($i['voucher_timeslot']->booking))}} </td>
                        <td class="text-center">{{$date_left->format('%ad %hh %im')}}</td>
                        <td class="text-center">{{Date("dMy H:i",strtotime($i['voucher_timeslot']->booking)) }}</td>
                        <td class="text-center">{{$i['voucher']->source or ""}}</td>
                        <td class="text-center">{{$i['voucher']->status or ""}}</td>
                        <td id="remarks_column" class="">
						@if(!is_null($i['merchant_id']))
                            <?php
                            $remark = DB::table('remark')
                            ->select('remark')
                            ->join('merchantremark','merchantremark.remark_id','=','remark.id')
                            ->where('merchantremark.merchant_id',$i['merchant_id']->merchant_id)
                            ->orderBy('remark.created_at', 'desc')
                            ->first();

                            /* Processed remark */
                            $pfullremark = null;
                            $premark = null;

                            if ($remark) {
                            $elipsis = "...";
                            $pfullremark = $remark->remark;
                            $premark = substr($pfullremark,0, MAX_COLUMN_TEXT);

                            if (strlen($pfullremark) > MAX_COLUMN_TEXT)
                            $premark = $premark . $elipsis;
                            }
                            ?>
                            <a href="javascript:void(0)" id="mcrid_{{$i['merchant_id']->merchant_id}}"
                               class="mcrid" rel="{{$i['merchant_id']->merchant_id}}">
                                <span title='{{$pfullremark}}'>{{$premark}}</span>
                            </a>
						@endif	
                        </td>
                        <td class="text-center">
							@if(!is_null($i['merchant_status']))
								{{ucfirst($i['merchant_status']->status)}}
							@endif
                        </td>
                        <td class="text-center action_buttons">
							@if(!is_null($i['merchant_status']))
								<?php
								$approve = new Classes\Approval('merchant', $i['merchant_id']->merchant_id);
								if ($i['merchant_status']->status == 'active') {
								$approve->getSuspendButton();
								} else if ($i['merchant_status']->status == 'suspended' || $i['merchant_status']->status == 'rejected') {
								$approve->getReactivateButton();
								}
								echo $approve->view;
								?>
							@endif
                        </td>
                        {{-- <th>SKU</th> --}}

                        {{-- <th>Delivery Order</th> --}}
                    </tr>
                    <?php $count++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="discountIssueModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="    width: 70%;">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="discount_id">Voucher Details</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-10" style="    width: 100%">
                                <label class="label label-warning" id="msg_discount_loading">Loading Voucher...</label>
                                <br/>
                                <div class="col-md-8" style="background-color: #D7E748; ;min-height: 178px">
                                    <p>
                                        <span class="col-md-3" >Retail Price</span>
                                        <span class="col-md-3" >{{$currency->code or 'MYR'}} <span id="retail_price"></span> /pax</span>
                                        <span class="col-md-5" >Voucher ID: <span id="voucher_id"></span></span>
                                    </p>
                                    <p>
                                        <span class="col-md-3" ></span>
                                        <span class="col-md-3" >Date:</span>
                                        <span class="col-md-5" id="date"></span>
                                    </p>
                                    <p>
                                        <span class="col-md-3"  ></span>
                                        <span class="col-md-3"  >Period:</span>
                                        <span class="col-md-5" id="period"></span>
                                    </p>
                                    <p>
                                        <span class="col-md-3" ></span>
                                        <span class="col-md-3" >Quantity:</span>
                                        <span class="col-md-5" id="quantity"></span>
                                    </p>
                                    <p>
                                        <span class="col-md-3" >Location:</span>
                                        <span class="col-md-9" style="word-wrap: break-word; font-size: smaller;">
                                            <span id="location1"></span><br>
                                            <span id="location2"></span><br>
                                            <span id="location3"></span><br>
                                            <span id="location4"></span>

                                        </span>
                                    </p>

                                    <span style="margin-left: 280px;"><a href="#"><i>Term & Condition</i></a></span>

                                </div>
                                <div class="col-md-4" style="background-color: #808080; color:white;min-height: 178px">
                                    <span style="display: flex;">Discounted Price</span>
                                    <p style="width: 100%; padding-top: 16px"><span class="pull-right" style="font-size:40px; padding-top: 37px" > <span id="percentage">%</span></span></p>   
                                    <p style="width: 40%" >MYR<span id="discounted_price" class="pull-right"></span></p>
                                    <p style="width: 40%">Qty<span class="pull-right" id="quantity_m"></span></p>   
                                    <span style="display: flex;">Total</span>
                                    <p style="width: 40%">{{$currency->code or "MYR"}} <span class="pull-right" id="total"></span></p>            

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
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

        <meta name="_token" content="{!! csrf_token() !!}"/>
        <script type="text/javascript">
                    //Function To handle add button action
            $(document).delegate('#btn-add', "click", function (event) {
				location.href = "{{url('')}}/merchant/dashboard?tab=discount";
            })
			$(document).ready(function () {
                    $('#voucher_details_table').DataTable({
						'scrollX':true,
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
                    function getSingleVoucher(id){
                    $("#msg_discount_loading").show();
                            $("#discountIssueModal").modal("show");
                            var currency = '{{$currency->code or "MYR"}}';
                            $.ajax({
                            url:JS_BASE_URL + '/get_voucher/' + id,
                                    type:'GET',
                                    dataType:'JSON',
                                    success:function(response){
                                    $('#single_voucher_table').html('');
                                            var i = 1;
                                            var discount = parseInt(response['voucher_product'].retail_price) - parseInt(
                                                response['voucher_discounted_price']);
                                            var discount_percent = (discount / parseInt(response['voucher_product'].retail_price)) * 100;
                                            console.log(response);
                                            $("#retail_price").html(response['voucher_retail_price']);
                                            $("#voucher_id").html(response['voucher_id']);
                                            $("#date").html(response['voucher_timeslot_booking']);
                                            $("#period").html(response['voucher_timeslot_from']+ " - " +response['voucher_timeslot_to']);
                                            $("#quantity").html(response['voucher_timeslot'].qty_ordered + " Person");
                                            $("#location1").html(response['voucher_address'].line1);
                                            $("#location2").html(response['voucher_address'].line2);
                                            $("#location3").html(response['voucher_address'].line3);
                                            $("#location4").html(response['voucher_address'].line4);
                                            $("#discounted_price").html(response['voucher_discounted_price']);
                                            $("#quantity_m").html(response['voucher_timeslot'].qty_ordered );
                                            $("#status").html(response['voucher'].status);
                                            $("#total").html(response['voucher_total_price']);
                                            $("#percentage").html(response['voucher_percentage']+ "%");
                                            $("#msg_discount_loading").fadeOut("slow");
                                            $('#single_voucher_table').DataTable();
                                    },
                                    error:function(response){
                                    console.log(response);
                                    }
                            });
                    }
				});	
        </script>
<script type="text/javascript">
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
    $(document).delegate( '.mcrid', "click",function (event) {
        _this = $(this);
        var id_merchant= _this.attr('rel');

        $('#modal-Tittle2').html("Remarks");

        var url = '/admin/master/merchant_remarks/'+ id_merchant;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th class='text-center'>No</th><th class='text-center'>Merchant&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
                for (i=0; i < data.length; i++) {
                    var obj = data[i];
                    html += "<tr>";
                    html += "<td class='text-center'>"+(i+1)+"</td>";
                    html += "<td class='text-center'><a href='../../admin/popup/merchant/"+id_merchant+"' class='update' data-id='"+id_merchant+"'>["+pad(id_merchant.toString(),10)+"]</a></td>";
                    html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
                    html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
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

$('.view-merchant-modal').click(function(){

            var id=$(this).attr('data-id');
            var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/admin/popup/merchant/"+id;
                    var w=window.open(url,"_blank");
                    w.focus();
                    }
                    if (r.status=="failure") {
                        var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                        $('#merchant-error-messages').html(msg);
                    }
                }
            });


        });


window.setInterval(function(){
              $('#merchant-error-messages').empty();
            }, 10000);

</script>
        @stop

        @section("extra-links")
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/fc-3.2.2/datatables.min.css"/> -->
        <style type="text/css">
            .my_class {
                vertical-align: middle;
            }
        </style>
        <link rel="stylesheet" href="{{asset('/css/bootstrap-switch.min.css')}}"/>
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/b-1.2.0/datatables.min.css"/> -->
        @stop

        @section("scripts")

        <script type="text/javascript" src="{{asset('/js/bootstrap-switch.min.js')}}"></script>
        <!-- <script type="text/javascript" src="https://cdn.datatables.net/u/bs/fc-3.2.2/datatables.min.js"></script> -->
        <!-- <script type="text/javascript" src="https://cdn.datatables.net/u/bs/b-1.2.0/datatables.min.js"></script> -->
        @stop
