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
            font-size: 18px;
            font-weight: bold;
            margin: 365px 0 0 610px;
        }
        .role_status_button{
            margin-top: 10px;
            width: 100px;
        }
    </style>
    <?php $i=1; ?>
    <div class="overlay" style="display:none;">
        <p>Please Wait...</p>
    </div>
    <div style="display: none;" class="removeable alert">
        <strong id='alert_heading'></strong><span id='alert_text'></span>
    </div>

    <div class="container" style="margin-top:30px; margin-bottom:30px;">
        @include('admin/panelHeading')
        {{-- @if(isset($stations)) --}}
        <div class="table-responsive">
            <h2>Social Media Marketeer Product Analysis</h2>
            <div class="table-responsive">
<!--             <div class="row">
                <div class="col-xs-2 col-sm-2">
                <label class="control-label">ID:</label>
                 <select id="dropdown1">
                 <option value="">Choose Option</option>
                 @foreach($smmasteranalysis as $analysis)
                    <?php
                    $smm_id = str_pad($analysis->id, 10, '0', STR_PAD_LEFT);
                    ?>
                    @if(isset($analysis->id))
                  <option value="[{{$smm_id}}]">[{{$smm_id}}]</option>
                    @endif
                  @endforeach
                </select>
                </div>
                <div class="col-xs-2 col-sm-2">
                <label class="control-label">Products:</label>
                <select id="dropdown2">
                    <option value="">Choose Option</option>
                   @foreach($smmasteranalysis as $analysis)
                        <?php
                            $product_id = str_pad($analysis->product_id, 10, '0', STR_PAD_LEFT);
                        ?>
                       @if(isset($analysis->product_id))
                          <option value="[{{$product_id}}]">[{{$product_id}}]</option>
                        @endif
                    @endforeach
                </select>
                </div>
                <div class="col-xs-2 col-sm-2">
                <label class="control-label">Last Share:</label>
                <select id="dropdown3">
                    <option value="">Choose Option</option>
                   @foreach($smmasteranalysis as $analysis)
                          <option value="{{date('dMy h:i', strtotime($analysis->created_at))}}">{{date('dMy h:i', strtotime($analysis->created_at))}}</option>
                    @endforeach
                </select>
                </div>
                <div class="col-xs-2 col-sm-2">
                <label class="control-label">Last Share:</label>
                <select id="dropdown4">
                    <option value="">Choose Option</option>
                   @foreach($smmasteranalysis as $analysis)
                        @if($analysis->duration == null)
                                    <?php
                                    $smm_min = $global->smm_min_duration;
                                    $smm_time = $analysis->created_at;
                                    $currentDate = strtotime($smm_time);
                                    $futureDate = $currentDate+(60*$smm_min);
                                    $formatDate = date("dMy h:i", $futureDate);
                                    ?>
                                    <option value="{{ $formatDate}}">{{ $formatDate}}</option>
                                    @else
                                    <?php
                                    $smm_min = $analysis->duration;
                                    $smm_time = $analysis->created_at;
                                    $currentDate = strtotime($smm_time);
                                    $futureDate = $currentDate+(60*$smm_min);
                                    $formatDate = date("dMy h:i", $futureDate);
                                    ?>
                                    <option value="{{ $formatDate}}">{{ $formatDate}}</option>
                                @endif
                    @endforeach
                </select>
                </div>
                <div class="col-xs-2 col-sm-2">
                <label class="control-label">Country:</label>
                <?php $i=0;?>
                <select id="dropdown5">
                    <option value="">Choose Option</option>
                   @foreach($smmasteranalysis as $analysis)
                        @if(isset($analysis->country))
                        <?php $exclude[$i] = $analysis->country;
                              $i++; 
                              if(!in_array($analysis->country, $exclude)){
                        ?>
                            <option value="{{$analysis->country}}">{{$analysis->country}}</option>
                        <?php } ?>
                        @endif
                    @endforeach
                </select>
                </div>
                <div class="col-xs-2 col-sm-2">
                <label class="control-label">State:</label>
                <?php $i=0;?>
                <select id="dropdown6">
                    <option value="">Choose Option</option>
                   @foreach($smmasteranalysis as $analysis)
                        @if(isset($analysis->state))
                        <?php $exclude2[$i] = $analysis->state;
                              $i++; 
                              if(!in_array($analysis->state, $exclude2)){
                        ?>
                            <option value="{{$analysis->state}}">{{$analysis->state}}</option>
                        <?php } ?>    
                        @endif
                    @endforeach
                </select>
                </div>
                <div class="col-xs-2 col-sm-2">
                <label class="control-label">Area:</label>
                <?php $i=0;?>
                <select id="dropdown7">
                    <option value="">Choose Option</option>
                   @foreach($smmasteranalysis as $analysis)
                        @if(isset($analysis->area))
                        <?php $exclude3[$i] = $analysis->area;
                              $i++; 
                              if(!in_array($analysis->area, $exclude3)){
                        ?>
                            <option value="{{$analysis->area}}">{{$analysis->area}}</option>
                            <?php } ?> 
                        @endif
                    @endforeach
                </select>
                </div>
            </div> -->
                </br>
                <table class="table table-bordered" cellspacing="0" width="100%" id="product_details_table">
                    <thead style="background-color:#558ED5; color:#FFF;">

                    <tr>
                        <th>No</th>
                        <th>SMM&nbsp;ID</th>
                        <th>Friends</th>
                        <th>Product</th>
                        <th>Shared</th>
                        <th>Clicked</th>
                        <th>Bought</th>
                        <th>Last&nbsp;Share</th>
                        <th>Next&nbsp;Share</th>
                        <th>Country/State</th>
                        <th>City</th>
                        <th>Area</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($smmasteranalysis as $analysis)
                    @if($analysis->id==null)
                                <?php continue;?>
                                @endif
                        <tr>

                            <td style="text-align: center;">
                                {{$i++}}
                            </td>
                            <td>
                                <?php
                                $smm_id = str_pad($analysis->id, 10, '0', STR_PAD_LEFT);
                                ?>
                                [<a href="/admin/popup/user/{{$analysis->id}}" target="_blank">{{$smm_id}}</a>]
                                {{-- [{{$smm_id}}] --}}
                            </td>

                            <td>
                                {{$analysis->view}}
                            </td>

                            <td>
                                <?php
                                $product_id = IdController::nP($analysis->product_id);
                                ?>
                                  <a href="/productconsumer/{{$analysis->product_id}}" target="_blank">{{$product_id}}</a> {{$analysis->product_name}}
                                {{-- [{{$product_id}}] {{$analysis->product_name}} --}}
                            </td>

                            <td>
                                {{$analysis->share}}
                            </td>

                            <td>
                                {{$analysis->click}}
                            </td>

                            <td>
                                {{$analysis->bought}}
                            </td>

                            <td>
                                {{ date('dMy h:i', strtotime($analysis->created_at)) }}
                            </td>

                            <td>
                                @if($analysis->duration == null)
                                    <?php
                                    $smm_min = $global->smm_min_duration;
                                    $smm_time = $analysis->created_at;
                                    $currentDate = strtotime($smm_time);
                                    $futureDate = $currentDate+(60*$smm_min);
                                    $formatDate = date("dMy h:i", $futureDate);
                                    ?>
                                    @else
                                    <?php
                                    $smm_min = $analysis->duration;
                                    $smm_time = $analysis->created_at;
                                    $currentDate = strtotime($smm_time);
                                    $futureDate = $currentDate+(60*$smm_min);
                                    $formatDate = date("dMy h:i", $futureDate);
                                    ?>
                                @endif
                                {{ $formatDate}}
                            </td>

                            <td>
                                {{$analysis->country}} / {{$analysis->state}}
                            </td>

                            <td>
                                {{$analysis->area}}
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- @endif --}}
    </div>


    {{-- <script src="{{url('js/jquery.dataTables.min.js')}}"></script> --}}
    <script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>


    <script>
        $(document).ready(function(){


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
                'scrollX':true,
                'autoWidth':false,
                "order": [],
                "columns": [
                    { "width": "20px", "orderable": false },
                    { "width": "85px" },
                    { "width": "130px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "85px" },
                    { "width": "85px" },
                    { "width": "85px" },
                    { "width": "85px" }
                ]
            });


                $('#dropdown1').on('change', function () {
                    table.columns(1).search( this.value ).draw();
                } );

                $('#dropdown2').on('change', function () {
                    table.columns(3).search( this.value ).draw();
                } );
                $('#dropdown3').on('change', function () {
                    table.columns(7).search( this.value ).draw();
                } );
                $('#dropdown4').on('change', function () {
                    table.columns(8).search( this.value ).draw();
                } );
                $('#dropdown5').on('change', function () {
                    table.columns(9).search( this.value ).draw();
                } );
                $('#dropdown6').on('change', function () {
                    table.columns(10).search( this.value ).draw();
                } );
                $('#dropdown7').on('change', function () {
                    table.columns(11).search( this.value ).draw();
                } );

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
        });

    </script>
    @yield("left_sidebar_scripts")
@stop
