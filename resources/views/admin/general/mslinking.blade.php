<?php
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
        .com, .pay, .ocom, .opay, .osales {
            width: 170px ;
        }

        table#merchantTable
        {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        .select2-dropdown.select2-dropdown--below{

        }

        .select2-selection__rendered{
            color: #7c7c7c !important;
            padding-left: 10px !important;
        }

        .select2-container--default .select2-selection--single{
            height: 35px;
            padding-top:2px;
            padding-bottom:4px;
            font-size: 1.2em;
            position: relative;
            border-radius: 0;
            border: 1px solid #ccc;
            color: #ccc;
        }

        .maxl{
            margin:25px ;
        }
        .inline{
            display: inline-block;
        }
        .inline + .inline{
            margin-left:10px;
        }
        .radio{
            color:#999;
            font-size:15px;
            position:relative;
        }
        .radio span{
            position:relative;
            padding-left:20px;
        }
        .radio span:after{
            content:'';
            width:15px;
            height:15px;
            border:3px solid;
            position:absolute;
            left:0;
            top:1px;
            border-radius:100%;
            -ms-border-radius:100%;
            -moz-border-radius:100%;
            -webkit-border-radius:100%;
            box-sizing:border-box;
            -ms-box-sizing:border-box;
            -moz-box-sizing:border-box;
            -webkit-box-sizing:border-box;
        }
        .radio input[type="radio"]{
            cursor: pointer;
            position:absolute;
            width:100%;
            height:100%;
            z-index: 1;
            opacity: 0;
            filter: alpha(opacity=0);
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"
        }
        .radio input[type="radio"]:checked + span{
            color:#0B8;
        }
        .radio input[type="radio"]:checked + span:before{
            content:'';
            width:5px;
            height:5px;
            position:absolute;
            background:#0B8;
            left:5px;
            top:6px;
            border-radius:100%;
            -ms-border-radius:100%;
            -moz-border-radius:100%;
            -webkit-border-radius:100%;
        }

        /*.accordion h3 {*/
            /*background: #f5f5f5;*/
            /*color: #4c4c4c;*/
            /*border: 0;*/
        /*}*/

        /*.accordion h3:hover {*/
            /*background: #f5f5f5;*/
            /*color: #4c4c4c;*/
            /*border: 0;*/
        /*}*/

        /*td.details-control {*/
            /*background: url('details_open.png') no-repeat center center;*/
            /*cursor: pointer;*/
        /*}*/
        /*tr.shown td.details-control {*/
            /*background: url('details_close.png') no-repeat center center;*/
        /*}*/

        .detail-row{
            display: none;
        }
    </style>
    <?php $i=1; ?>

    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')

        <h2>
            <span>General: Merchant-Station Linking</span>
            {{--<span class="pull-right" id="msLinkingDate">16/11/2016</span>--}}
        </h2>

        <div class="row">
            <form class="form-horizontal">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="emperor">Merchant</label>
                        <div class="col-sm-9">
                            <select id="emperor" name="emperor" placeholder="Merchant ID" class="form-control">
                                <option value="">Select</option>
                                @if(isset($merchants) && is_array($merchants))
                                    @foreach($merchants as $merchant)
                                        <option data-text="{{$merchant->company_name}}" value="{{$merchant->id}}"> {!! $merchant->nmerchant_id !!} - {{mb_strimwidth($merchant->company_name, 0, 30, "...")}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="station_type">Station Type</label>
                        <div class="col-sm-9">
                            <select id="station_type" name="station_type" class="form-control">
                                @if(isset($station_types) && is_array($station_types))
                                    @foreach($station_types as $station_type)
                                        <option value="{{$station_type->id}}">{{$station_type->description}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
					 <div class="form-group">
                        <label class="col-sm-3 control-label" for="station_type">Brand</label>
                        <div class="col-sm-9">
                            <select id="brands" name="brands" class="form-control">
                                <option value="">Select</option>
                                @if(isset($brands) && is_array($brands))
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="station_type">Product</label>
                        <div class="col-sm-9">
                            <select id="products" name="products" class="form-control">
                                <option value="">Select</option>
                                @if(isset($products) && is_array($products))
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->description}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <input disabled id="name" name="name" class="form-control" type="text" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="emperor">Station</label>
                        <div class="col-sm-10">
                            <select id="statione" name="statione" class="form-control">
                                <option value="">Select</option>
                                @if(isset($stations) && is_array($stations))
                                    @foreach($stations as $station)
                                        <option data-text="{{$station->name}}" value="{{$station->id}}"> {!! $station->nstation_id !!} - {{mb_strimwidth($station->name, 0, 30, "...")}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>	
					<div class="form-group">
                        <label class="col-sm-2 control-label" for="emperor">O-Shop</label>
                        <div class="col-sm-10">
                            <select id="oshop" name="oshop" class="form-control">
                                <option value="">Select</option>
                                @if(isset($oshops) && is_array($oshops))
                                    @foreach($oshops as $oshop)
                                        <option data-text="{{$oshop->oshop_name}}" value="{{$oshop->id}}"> {!! IdController::nOshop($oshop->id) !!} - {{mb_strimwidth($oshop->oshop_name, 0, 30, "...")}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>						
                </div>
            </form>
        </div>


        <div>
            <form id="msLinkingForm" action="{{route('PostMass_autolinkFilter')}}" method="POST">
				<input type="hidden" name="mmerchant_id" value="" id="mmerchant_id">
                @include('partials.alert')

                @inject('msLinking', 'App\Classes\MsLinking')

                <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id='merchantTable'>

                    <thead style="background-color: #FF4C4C; color: white;"> <br>
                    <tr>
                        <th class="no-sort text-center bsmall" style="background-color:#4c4c4c;color:#fff;">No</th>

                        <th style="background-color:#4c4c4c;color:#fff" class="text-center">
                            Link&nbsp;<input name="link-all" id="link-all" type="checkbox">
                        </th>
                        <th style="background-color:#4c4c4c;color:#fff" class="text-center">
                            Enable&nbsp;<!--<input name="enable-all" id="enable-all" type="checkbox">-->
                        </th>
						<th style="background-color:#4c4c4c;color:#fff" class="text-center">
                            Visibility&nbsp;<!--<input name="enable-all" id="enable-all" type="checkbox">-->
                        </th>

                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center bmedium">Station&nbsp;ID</th>
                    <!--    <th style="background-color:#4c4c4c;color:#fff"  class="text-center bmedium">Outlet&nbsp;ID</th> -->
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center">Type</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-left blarge">Name</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-left blarge">Country</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-left bsmall">State</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-left bsmall">City</th>
                        <th style="background-color:#4c4c4c;color:#fff" class="text-left bsmall">Area</th>
                    </tr>
                    </thead>

                    @if(isset($stations) && is_array($stations) && count($stations))
                        <tfoot>
                        <tr></tr>
                        </tfoot>
                        <tbody>
                        @def $i = 1
                        @foreach($stations as $key => $station)

                            <?php $outlets = $msLinking->station_outlets($station->id, 0); ?>

                            <tr id="station-{{$station->id}}">
                                <td class='text-center'>{!! $i++ !!}</td>
                                <td class='text-center'><?php //print_r($station); ?>
                                    <input class="link-checkbox" disabled data-id="{{$station->user_id}}" type="checkbox">
                                </td>
								<td class='text-center'>
                                    
                                </td>
                                <td class='text-center'>
                                    <input class="enable-checkbox" disabled data-id="{{$station->id}}"
                                       type="checkbox">
                                </td>
                                <td class='text-center'>
                                    <a href="/admin/popup/station/{{$station->id}}" target="_blank" onclick="window.open('/admin/popup/station/{{$station->id}}'); return false;">
                                        {!! $station->nstation_id !!}
                                    </a>
                                </td>
                           <!--     <td class='text-center'>
                                    @if(count($outlets))
                                        <?php //print_r($outlets);
                                        $json = json_encode($outlets);
                                        ?>
                                        <a id="detail-btn-{{$station->id}}"
                                           data-id="{{$station->id}}"
                                           data-number="{{$i}}"
                                           data-type="{{$station->station_type}}"
                                           data-name="[{{str_pad($station->id, 10, '0', STR_PAD_LEFT)}}]"
                                           data-text="{{$json}}"
                                           class="detail-btn">{{count($outlets)}}</a>

                                    @elseif(count($outlets) > 1)
                                        -
                                    @endif
                                </td> -->
                                <td class='text-center'>
                                    {{$station->station_type}}
                                </td>
                                <td class='text-left'>
                                    @if(count($outlets))
                                        <?php //print_r($outlets);
                                        $json = json_encode($outlets);
                                        ?>
                                        <a id="detail-btn-{{$station->id}}"
                                           data-id="{{$station->id}}"
                                           data-number="{{$i}}"
                                           data-type="{{$station->station_type}}"
                                           data-name="{{$station->nstation_id}}"
                                           data-text="{{$json}}"
                                           class="detail-btn">{{$station->name}}</a>
                                    @else
                                        {{$station->name}}
                                    @endif
                                </td>
                                <td class='text-left'>
                                    {{$station->country_name}}
                                </td>
                                <td class='text-left'>
                                    {{$station->state_name}}
                                </td>
                                <td class='text-left'>
                                    {{$station->city_name}}
                                </td>
                                <td class='text-left'>
                                    {{$station->area_name}}
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    @endif
                </table>

                <div class="row" style="margin-bottom: 50px;margin-top: 20px;">
                    <div class="col-sm-12">
                       <button data-url="{{route('PostMass_autolink')}}" data-type="link" id="link-btn" type="button" class="btn btn-success pull-right" style="margin-right:15px;" disabled> Save </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Modal -->
    <div class="modal fade myModal" id="empModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='empClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>User Information</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
            </div>
        </div>
    </div>

    <!-- Payment Gateway Delete Confirmation -->
    <div class="modal fade myModal" id="confirm-payment-gateway-delete-modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='productClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Delete Confirmation</h3>
                    </h4>
                </div>
                <div class='modal-body'>
                    <p>
                        Are you sure you want to delete this payment gateway.<br>
                        It may have been linked to some payments in the system.
                    </p>
                </div>
                <div class="modal-footer" style='border:none'>
                    <button id="confirm-delete-btn" class='btn btn-danger'
                            style="float:right;">Yes I am sure</button>
                    <button type="button" class="btn btn-success " data-dismiss="modal"
                            style="float:left;">No</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Payment Gateway Delete Confirmation -->
    <div class="modal fade myModal" id="add-payment-gateway-modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='productClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Add New Payment Gateway</h3>
                    </h4>
                </div>
                <div class='modal-body'>
                    <form>
                        <div class="form-group">
                            <input type="text" placeholder="Name" class="form-control" id="add-pg-name" name="name">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Description" class="form-control" id="add-pg-description" name="description">
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style='border:none'>
                    <button id="save-payment-gateway-btn" class='btn btn-success'
                            style="float:right;">Save</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            style="float:left;">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            var table = $('#merchantTable').DataTable({
                "scrollX": true,
                "columnDefs": [
                    {"targets": [0], "width": "30px", "orderable": false}, //no
                    {"targets": [1], "width": "50px", "orderable": false}, //link
                    {"targets": [2], "width": "60px", "orderable": false}, //enable
                    {"targets": [3], "width": "100px"}, //type
                    {"targets": [4], "width": "50px"}, //station id
                   // {"targets": [4], "width": "100px"}, //outlet id
                    {"targets": [5], "width": "200px"}, //name
                    {"targets": [6], "width": "auto"}, //country
                    {"targets": [7], "width": "100px"}, //state
                    {"targets": [8], "width": "100px"}, //city
                    {"targets": [9], "width": "auto"}//area
                ],
                destroy: true
            }).on('page', function()
            { //on next page event
                showDetail();
                setTimeout(function(){
                    showDetail();
                }, 1000);
            });

            var pad = function(width, string, padding)
            {
                return (width <= string.length) ? string : pad(width, padding + string, padding);
            };

            var isBool =  function(val)
            {
                return !!JSON.parse(String(val).toLowerCase());
            };

            var outletsBuilder = function(outlets, identifier, station_id, station_id_padded, record_no, station_type)
            {
                var rows = '';
                var outlet = '';
                var outletCheckbox ='';
                var id ='';
                var no = 0;
                var name ='';
				console.log(outlets);
                //taking care of base64Encoded json
                if(outlets.indexOf('[{') == -1)
                {
                    outlets = JSON.parse(atob(outlets));
                }else{
                    outlets = JSON.parse(outlets);
                }


                for(var i=0; i<outlets.length; i++)
                {
                    outlet = outlets[i];
                    id = outlet.id;
                    var outlet_id_pad = outlet.nbranch_id;
                    no = (record_no-1) + '.' + (i + 1);
                    name = outlet.name;
					console.log("HOLAAAAA");
                    var enabled = '';
                    var disabled = 'disabled';
					if(outlet.isEnabled == 1){
						enabled = 'checked="checked"';
					}
                    var linked = '';
					if(outlet.isLinked == 1){
						linked = 'checked="checked"';
						disabled = '';
					}

                    var linkCheckbox = '<input class="linksp-checkbox" data-id="' + id + '" '+ linked +' '+ disabled +' type="checkbox">';

                    var enableCheckbox = '<input class="enablesp-checkbox" data-id="' + id + '" '+ enabled +' type="checkbox">';

                    rows +=
                    '<tr class="'+identifier+'" style="background-color: rgba(227, 227, 227, 0.59);">'+
                        '<td colspan="0" class="text-center" width="20px">'+no+'</td>'+
                        '<td colspan="0" class="text-center" width="20px"><a href="javascript:void(0)" class="linkenable" data-id="' + id + '">Enable</a></td>'+
                        '<td colspan="0" class="text-center" width="20px">'+linkCheckbox+'</td>'+
                        '<td colspan="0" class="text-center" width="20px">'+enableCheckbox+'</td>'+
                        '<td colspan="0" class="text-center">'+outlet_id_pad+'</td>'+
                        '<td colspan="0" class="text-center">'+station_type+'</td>'+
                        '<td colspan="0" class="text-left">'+name+'</td>'+
                        '<td colspan="0" class="text-left">'+outlet.country_name+'</td>'+
                        '<td colspan="0" class="text-left">'+outlet.state_name+'</td>'+
                        '<td colspan="0" class="text-left">'+outlet.city_name+'</td>'+
                        '<td colspan="0" class="text-left">'+outlet.area_name+'</td>'+
                    '</tr>';
                }

                return rows;
            }
			$(document).delegate( '.linkenable', "click",function (event) {
				var user_id = $(this).attr('data-id');
				var merchant_id = $('#emperor').val();
				window.open(JS_BASE_URL + '/admin/general/mass_autolink/' + user_id + '/' + merchant_id,'_blank');
			});
			
			$("#emperor").on('change', function(e){
                var option = $("option:selected", this);
               $('#name').val(option.attr('data-text'));
            });
			
			$("#station_type").on('change', function(e){
				var stationtype = $(this).val();
               $.ajax({
                    url:JS_BASE_URL + '/getstationsbytype/' + stationtype,
                    type:'GET',
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						$('#statione').html(responseData);
						//$('#statione').val("");
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
            });
			
            var showDetail = function()
            {
                $('.detail-btn').on('click', function (e)
                {
                    e.preventDefault();
                    var outlets = $(this).attr('data-text');
                    var tr = $(this).closest('tr');
                    var station_id = $(this).attr('data-id');
                    var station_id_padded = $(this).attr('data-name');
                    var record_no = $(this).attr('data-number');
                    var station_type = $(this).attr('data-type');

                    var identifier = 'shown-'+station_id;
                    var child_identifier = "station-outlets-"+station_id;

                    //toggle
                    if(tr.hasClass(identifier)){
                        //its already open lets hide it
                        tr.removeClass(identifier);
                        $('.'+child_identifier).hide();
                    }else{
                        //its closed lets open it
                        tr.addClass(identifier);

                        if(!$('.'+child_identifier).length){
                        //add if not already exist.
                            tr.after(outletsBuilder(outlets, child_identifier, station_id, station_id_padded, record_no, station_type));
                        }
                        $('.'+child_identifier).show();
                    }
                });
            }
            showDetail();

            //
          /* $("#emperor").on('change', function(e){
                var option = $("option:selected", this);
               $('#name').val(option.attr('data-text'));
            });*/

            //check all
			$(document).delegate( '.link-checkbox', "click",function (event) {
          //  $('.linksp-checkbox').on('click', function(e){
				var dataid = $(this).attr('data-id');
				console.log(dataid);
				if(!$(this).prop('checked')){
					$(".enable-checkbox[data-id='" + dataid + "']").prop('checked', false);
					$(".enable-checkbox[data-id='" + dataid + "']").attr('disabled', true);
					$(".enablesp-checkbox[data-id='" + dataid + "']").prop('checked', false);
					$(".enablesp-checkbox[data-id='" + dataid + "']").attr('disabled', true);
				} else {
					$(".enable-checkbox[data-id='" + dataid + "']").attr('disabled', false);
					$(".enablesp-checkbox[data-id='" + dataid + "']").attr('disabled', false);
				}
			});
			
			$('#link-all').on('click', function(e){
                $('.link-checkbox').prop('checked', this.checked);
                $('.linksp-checkbox').prop('checked', this.checked);
            });
            $('#enable-all').on('click', function(e){
                $('.enable-checkbox').prop('checked', this.checked);
                $('.enablesp-checkbox').prop('checked', this.checked);
            });

            //auto linking
            $('#link-btn, #enable-btn').on('click', function(e)
            {
                var url = $(this).attr('data-url');
                var action = $(this).attr('data-type');
                var m_id = $('#emperor').val();

				var but = $(this);
				but.html("Saving...");
				but.attr('disabled',true);

                var data = [];
                var dataenable = [];
                var datasp = [];
                var dataspenable = [];

                if(action == 'link')
                {
                    if(!m_id){
                        toastr.error('Select an Emperor');
                        return false;
                    }

                    //$('.link-checkbox:checked')
                    //lets select all checkbox both checked and unchecked
                    $('.link-checkbox').each(function()
                    {
                        data.push({
//                            station_id: $(this).attr('data-id'),
                            user_id: $(this).attr('data-id'), //station->user_id
                            merchant_id: m_id,
                            status: $(this).is(':checked'),
                            action: 'link'
                        });
                    });
					
                    $('.linksp-checkbox').each(function()
                    {
                        datasp.push({
//                            station_id: $(this).attr('data-id'),
                            station_id: $(this).attr('data-id'), //station->user_id
                            merchant_id: m_id,
                            status: $(this).is(':checked'),
                            action: 'link'
                        });
                    });		

                    //$('.enable-checkbox:checked')
                    $('.enable-checkbox').each(function()
                    {
                        dataenable.push({
                            user_id: $(this).attr('data-id'), //station->user_id
							merchant_id: m_id,
                            status: $(this).is(':checked'),
                            action: 'link'
                        });
                    });
					
                    $('.enablesp-checkbox').each(function()
                    {
                        dataspenable.push({
                            station_id: $(this).attr('data-id'),
							merchant_id: m_id,
                            status: $(this).is(':checked'),
                            action: 'link'
                        });
                    });						
                }else{
                    //$('.enable-checkbox:checked')
                    $('.enable-checkbox').each(function()
                    {
                        data.push({
                            station_id: $(this).attr('data-id'),
                            status: $(this).is(':checked'),
                            action: 'enable'
                        });
                    });
					
                    $('.enablesp-checkbox').each(function()
                    {
                        datasp.push({
                            station_id: $(this).attr('data-id'),
                            status: $(this).is(':checked'),
                            action: 'enable'
                        });
                    });					
                }

                if(!data.length){
                    toastr.error('Select an at least one station');
                    return false;
                }

//alert(JSON.stringify(data));
				var m_id = $('#emperor').val();
				//console.log(datasp);
				//console.log(data);
                $.ajax({
                    url:url,
                    type:'POST',
                    data: {stations: JSON.stringify(data), spoutlets: JSON.stringify(datasp), stationsenable: JSON.stringify(dataenable), spoutletsenable: JSON.stringify(dataspenable), action: action, merchant_id: m_id},
                    dataType: 'json',
                    success:function (r)
                    {
                        if (r.status==true)
                        {
						//	console.log(r.data);
                            if(action == 'link'){
                                toastr.info('Stations were successfully linked/unlinked');
                            }else{
                                toastr.info('Stations were successfully enabled/unabled');
                            }
							but.html("Save");
							but.attr('disabled',false);
                            var table = $('#merchantTable').dataTable({
                                "data": formatData(r.data),
                                "columns": [
                                    { "data": "no", className: "text-center"},
                                    { "data": "link" , className: "text-center"},
                                    { "data": "enable", className: "text-center"},
                                    { "data": "visibility", className: "text-center"},
                                    { "data": "station_id", className: "text-center"},
//                                    { "data": "outlet_id", className: "text-center"},
                                    { "data": "type", className: "text-center"},
                                    { "data": "name", className: "text-left"},
                                    { "data": "country", className: "text-center"},
                                    { "data": "state", className: "text-left"},
                                    { "data": "city", className: "text-left"},
                                    { "data": "area", className: "text-center"}
                                ],
                                "scrollX": true,
                                "columnDefs": [
                                    {"targets": [0], "width": "30px", "orderable": false}, //no
                                    {"targets": [1], "width": "50px", "orderable": false}, //link
                                    {"targets": [2], "width": "60px", "orderable": false}, //enable
                                    {"targets": [3], "width": "60px", "orderable": false}, //enable
                                    {"targets": [4], "width": "100px"}, //type
                                    {"targets": [5], "width": "50px"}, //station id
                                  //  {"targets": [4], "width": "100px"}, //outlet id
                                    {"targets": [6], "width": "200px"}, //name
                                    {"targets": [7], "width": "auto"}, //country
                                    {"targets": [8], "width": "100px"}, //state
                                    {"targets": [9], "width": "100px"}, //city
                                    {"targets": [10], "width": "auto"}//area
                                ],
                                destroy: true,
                                "initComplete": function( settings, json ) {
                                    showDetail();
                                }
                            }).on('page', function()
                            { //on next page event
                                setTimeout(function(){
                                    showDetail();
                                }, 1000);
                            });

                        }else{
                            toastr.error("We have some errors");
                        }
                    },
                    error: function(r){
                        toastr.error("Ops! Internal server error occurred");
                    }
                });
            });


            var formatData = function(server_data)
            {
                 var data = [];
                 var station;

                 for(var i=0; i<server_data.length; i++)
                 {
					station = server_data[i];
//                     alert();
					var no = i+1;
					//not linked by merchant_id 
//                     var isLinked = station.isLinked;
                     var station_name = station.outlets.length
                         ?
                             '<a id="detail-btn-'+station.id+'" data-id="'+station.id+'" data-number="'+(no+1)+'" ' +
                             'data-type="'+station.station_type+'" data-name="'+'' + station.nstation_id + ''+'" ' +
                             'data-text="'+btoa(JSON.stringify(station.outlets))+'" ' + 'class="detail-btn">'+station.name+'</a>'
                         : station.name;


                     var enabled = isBool(station.isEnabled) ? 'checked="checked"' : '';
                     var linked = isBool(station.isLinked) ? 'checked="checked"' : '';
					 var disabled = !isBool(station.isLinked) ? 'disabled' : '';
					console.log(linked);
                     data.push({
                         no: no,
                         link: '<input '+linked+' class="link-checkbox" data-id="'+station.user_id+'" type="checkbox">',
						 
						 enable: '<a href="javascript:void(0)" class="linkenable" data-id="' + station.user_id + '">Enable</a>',

                         visibility: '<input '+enabled+' '+disabled+' class="enable-checkbox" data-id="'+station.user_id+'" type="checkbox">',
                         
                         station_id: '<a href="/admin/popup/station/'+station.id+'">'+'' + station.nstation_id + '' +'</a>',

                         outlet_id: '', //JSON.stringify(station),

                         type: station.station_type,

                         name: station_name,


                         country: station.country_name,
                         state: station.state_name,
                         city: station.city_name,
                         area: station.area_name
                     });
                 }

                return data;
            };

            //fire off a post to build autolink
            $('#emperor, #station_type, input[name="station_character"], #name, #brands, #products, #oshop, #statione').on('change', function(e)
            {
				console.log("Hola!");
                var m_id = $('#emperor').val();
				$('#mmerchant_id').val(m_id);
                var s_type = $('#station_type').val();
                var brands = $('#brands').val();
                var products = $('#products').val();
                var oshops = $('#oshop').val();
                var s_type = $('#station_type').val();
                var station_id = $('#statione').val();
                var s_character = "snetwork";

                var name = $('#name').val();
                var url = $('#msLinkingForm').attr('action');
				console.log(s_character);
                //if all the filters have values fire off a post to server
                    var data = {
                        merchant: m_id,
                        brands: brands,
                        products: products,
                        oshops: oshops,
                        station_type: s_type,
                        station_id: station_id,
                        station_character: s_character,
                        name: name
                    }

                    $.ajax({
                        url:url,
                        type:'POST',
                        data: data,
                        success:function (r)
                        {
							console.log(r);
                            if (r.status==true)
                            {
//                                toastr.info("We are back again");
								//console.log(r.data);
                                var table = $('#merchantTable').dataTable({
                                    "data": formatData(r.data),
                                    "columns": [
                                        { "data": "no", className: "text-center"},
                                        { "data": "link" , className: "text-center"},
                                        { "data": "enable" , className: "text-center"},
                                        { "data": "visibility" , className: "text-center"},
                                        { "data": "station_id", className: "text-center"},
                                        { "data": "type", className: "text-center"},
                                        { "data": "name", className: "text-left"},
                                        { "data": "country", className: "text-center"},
                                        { "data": "state", className: "text-left"},
                                        { "data": "city", className: "text-left"},
                                        { "data": "area", className: "text-center"}
                                    ],
                                    "scrollX": true,
                                    "columnDefs": [
                                        {"targets": [0], "width": "30px", "orderable": false}, //no
                                        {"targets": [1], "width": "60px", "orderable": false}, //link
                                        {"targets": [2], "width": "80px", "orderable": false}, //enable
                                        {"targets": [3], "width": "80px", "orderable": false}, //enable
                                        {"targets": [4], "width": "100px"}, //station_id
                                     //   {"targets": [2], "width": "30px"}, //outlet id
                                        {"targets": [5], "width": "5px"}, //type
                                        {"targets": [6], "width": "200px"}, //name
                                        {"targets": [7], "width": "auto"}, //country
                                        {"targets": [8], "width": "100px"}, //state
                                        {"targets": [9], "width": "100px"}, //city
                                        {"targets": [10], "width": "auto"}//area
                                    ],
                                    destroy: true,
                                    "initComplete": function( settings, json ) {
                                        showDetail();
                                    }
                                }).on('page', function()
                                { //on next page event
                                    setTimeout(function(){
                                        showDetail();
                                    }, 1000);
                                });

                            }else{
                                toastr.error("We have some errors");
                            }
                        },
                        error: function(r){
                            toastr.error("Ops! Internal server error occurred");
                        }
                    });
                if(m_id !='')
                {
					$("#link-btn").attr("disabled", false);					
                } else {
					$("#link-btn").attr("disabled", true);
				}
            });
        });


//        $('#example')
//                .on( 'order.dt',  function () { console.log('Order' ); } )
//                .on( 'search.dt', function () {console.log('Search' ); } )
//                .on( 'page.dt',   function () { console.log('Page' ); } )
//                .dataTable();

        window.setInterval(function(){
            $('#user-error-messages').empty();
        }, 10000);
    </script>
@stop
