<?php

use App\Classes;
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
        font-size: 18px;
        font-weight: bold;
        margin: 365px 0 0 610px;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
        width: 85px;
    }
    /*dialoguebox*/
  /*  label, input { display:block; } commented due to search label error */
    textArea {height: 200px;margin-bottom: 28px;width: 100%;}
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .ui-dialog{z-index: 10001}
    .ui-widget-overlay{z-index: 1000}
</style>
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
    <p>Please Wait...</p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="container" style="margin-top:30px;  margin-bottom:30px;">
	@include('admin/panelHeading')
	@if(isset($merchants))
	<h2>Merchant MasterXXX</h2>
    <div class="tableData">
        <div class="table-responsive">
                <table class="table table-bordered" cellspacing="0" id="master_merchant_table" style="width: 100%;">
                    <thead style="background-color: #FF4C4C; color: white;">
                        <tr>
                            <th class="no-sort text-center">No</th>
                            <th class="text-center">Merchant&nbsp;ID</th>
                            <th class="text-center blarge">Company&nbsp;Name</th>
                            <th class="text-center">Domicile</th>
                            <th class="text-center">Business&nbsp;Type</th>
                            <th class="text-center">GST</th>
                            <th class="large no-sort">O-Shop</th>
                            <th class="no-sort">Notes</th>
                            <th class="no-sort"> Manager</th>
                            <th class="no-sort">StatementXXXXXXX</th>
                            <th class="">Status</th>
                            <th class="no-sort">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $m = 0; ?>
                        @foreach($merchants as $merchant)
                        <?php $m++; ?>
                        <tr>
                            <td class="text-center">
                                {{ $m }}
                            </td>
                            <td>
                                <a target="_blank" href="{{route('merchantPopup', ['id' => $merchant->id])}}" class="update" data-id="{{ $merchant->id }}">[{{ str_pad($merchant->id, 10, '0', STR_PAD_LEFT) }}]</a>
                            </td>

                            <td>
                                {{$merchant->company_name}}
								<input type="hidden" value="{{$merchant->company_name}}" id="mname{{ $merchant->id }}" />
                            </td>

                            <td >
                                @foreach($merchant->address($merchant->country_id)->get() as $address)
                                {{$address->name}}
                                @endforeach
                            </td>

                            <td >
                                {{ucfirst(str_replace('_', ' ', $merchant->business_type))}}
                            </td>

                            <td >
                                {{$merchant->gst}}
                            </td>

                            <td >
                                {{$merchant->oshop_name}}
                            </td>

                            <td id="remarks_column" >
                                <span id="remarks_text">
                                    
                                </span>

                            </td>

                            <td>
                                <a href="javascript:void(0)" class="mcid" id="{{$merchant->id}}">Details</a>

                                @foreach($merchant->mc_id()->get() as $mc_id)
                                    <input type="hidden" value="{{$merchant->mc_sales_staff_id}}" id="mc{{$merchant->id}}">
                                    <input type="hidden" value="{{$mc_id->user_id}}" id="mcu{{$merchant->id}}">
                                @endforeach
                                @foreach($merchant->mc_id_referal()->get() as $mcr_id)
                                    <input type="hidden" value="{{$merchant->referral_sales_staff_id}}" id="mcref{{$merchant->id}}">
                                    <input type="hidden" value="{{$mcr_id->user_id}}" id="mcrefu{{$merchant->id}}">
                                @endforeach

                                @foreach($merchant->mcp1_id()->get() as $mcp1_id)
                                            <input type="hidden" value="{{$merchant->mcp1_sales_staff_id}}" id="mcp1{{$merchant->id}}">
                                    <input type="hidden" value="{{$mcp1_id->user_id}}" id="mcp1u{{$merchant->id}}">
                                @endforeach
                                @foreach($merchant->mcp2_id()->get() as $mcp2_id)
                                    <input type="hidden" value="{{$merchant->mcp2_sales_staff_id}}" id="mcp2{{$merchant->id}}">
                                    <input type="hidden" value="{{$mcp2_id->user_id}}" id="mcp2u{{$merchant->id}}">
                                @endforeach

                            </td>

                            <td>
                                <select>
                                    <option value="volvo">Delivery Order</option>
                                    <option value="saab">Receipt</option>
                                    <option value="mercedes">Overall Statement</option>
                                </select>
                            </td>

                            <td id="status_column" >
                                <span id="status_column_text">
                                    {{ucfirst($merchant->status)}}
                                </span>
                            </td>
                            <td>
                                <div class="action_buttons">
                                    <?php
                                    $approve = new Classes\Approval('merchant', $merchant->id);
                                    if ($merchant->status == 'active') {
                                        $approve->getSuspendButton();
                                    } else if ($merchant->status == 'suspended' || $merchant->status == 'rejected') {
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
            </div>
            </div>
            @endif


            @if(isset($stations))
            <h2>Stations</h2>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="1">Account Information</th>
                            <th colspan="6" class="text-center">Company Details</th>
                            <th>Shop Details</th>
                            <th>Brand Details</th>
                            <th>Remarks</th>
                        </tr>
                        <tr>
                            <th>Noxxxxxxxxxxxxxxxx</th>
                            <th>company name</th>
                            <th>Domicile</th>
                            <th>GST</th>
                            <th>Business Type</th>
                            <th>Websites</th>
                            <th>Social Media</th>
                            <th>O-Shop Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stations as $station)
                        <tr>
                            <td>
                                {{$station->id}}
                            </td>

                            <td>
                                {{$station->company_name}}
                            </td>

                            <td>
                                @foreach($station->address()->get() as $address)
                                {{$address->id}}
                                @endforeach
                            </td>


                            <td>
                                {{$station->gst}}
                            </td>

                            <td>
                                {{$station->business_type}}
                            </td>

                            <td>
                                @foreach($station->websites()->get() as $website)
                                {{$website->url}}
                                @endforeach
                            </td>
                            <td>
                                @foreach($station->socialmedia()->get() as $socialmedia)
                                {{$socialmedia->url}}
                                @endforeach
                            </td>

                            <td>
                                {{$station->oshop_name}}
                            </td>

                            <td>
                                @foreach($station->brand()->get() as $brand)
                                {{$brand->name}}
                                @endforeach
                            </td>

                            <td>
                                {{$station->remarks}}
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Account Manager</h4>
            </div>
            <div class="modal-body">
				<h3 id="modal-Tittle1"></h3>
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable"></table>
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
<script type="text/javascript">
$(document).ready(function () {

    function pad (str, max) {
		if (!str) {
			str = str.toString();
			ret = str.length < max ? pad("0" + str, max) : str;
			alert(ret);
		} else {
			ret = "";
		}
		return ret;
    }

    $('#master_merchant_table').DataTable({
        "order": [],
        "scrollX": true,
        "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
        "fixedColumns":   {
            "leftColumns": 2
        }
    });

    function removeMessage() {
        $('.removeable').fadeOut(7000);
//            $('.removeable').remove();
    }
    setTimeout(removeMessage, 2000);

    $(".mcid").click(function () {

        $('#modal-Tittle').html("");
        $('#modal-Tittle1').html("");
        $('#myTable').empty();
        _this = $(this);

        var id_merchant= _this.attr('id');
        var mname= $('#mname' + id_merchant).val();
        var urlbase = $('meta[name="base_url"]').attr('content');

        if(typeof($('#mcu'+id_merchant).val())==="undefined"){
            var mcu='';
        }else{
            var mcu='/admin/popup/user/'+ $('#mcu'+id_merchant).val();
        }
        if(typeof($('#mc'+id_merchant).val())==="undefined"){
            var mc='';
        }else{
            var mc='['+pad($('#mc'+id_merchant).val(),10)+']';
        }
        if(typeof($('#mcrefu'+id_merchant).val())==="undefined"){
            var mcrefu='';
        }else{
            var mcrefu='/admin/popup/user/'+ $('#mcrefu'+id_merchant).val();
        }
        if(typeof($('#mcref'+id_merchant).val())==="undefined"){
            var mcref='';
        }else{
            var mcref='['+pad($('#mcref'+id_merchant).val(),10)+']';
        }
        if(typeof($('#mcp1u'+id_merchant).val())==="undefined"){
            var mcp1u='';
        }else{
            var mcp1u='/admin/popup/user/'+ $('#mcp1u'+id_merchant).val();
        }
        if(typeof($('#mcp1'+id_merchant).val())==="undefined"){
            var mcp1='';
        }else{
            var mcp1='['+pad($('#mcp1'+id_merchant).val(),10)+']';
        }
        if(typeof($('#mcp2u'+id_merchant).val())==="undefined"){
            var mcp2u='';
        }else{
            var mcp2u='/admin/popup/user/'+ $('#mcp2u'+id_merchant).val();
        }
        if(typeof($('#mcp2'+id_merchant).val())==="undefined"){
            var mcp2='';
        }else{
            var mcp2='['+pad($('#mcp2'+id_merchant).val(),10)+']';
        }

        $('#modal-Tittle').append("Merchant ID: "+id_merchant);
        $('#modal-Tittle1').append("Merchant Name: "+mname);
        $('#myTable').append('<thead style="background-color: #FF4C4C; color: #fff;"><th>MC ID</th><th>MC ID (Referal)</th><th>MP1 ID</th><th>MP2 ID</th></thead>');
        $('#myTable').append('<tbody><tr><td><a href="'+urlbase+mcu+'">'+mc+'</a></td><td><a href="'+urlbase+mcrefu+'">'+mcref+'</a></td><td><a href="'+urlbase+mcp1u+'">'+mcp1+'</a></td><td><a href="'+urlbase+mcp2u+'">'+mcp2+'</a></td></tr></body>');

        $("#myModal").modal("show");
    });
});


</script>

@stop
