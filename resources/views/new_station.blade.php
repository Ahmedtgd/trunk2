@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
?>
@section("content")
<!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->

<style>

    #errmsg{
        color: red;
    }
    td{
        padding: 2px !important;
    }
    .tab-pane{
        margin-top: 4em;
    }
/*Butto*/
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
    }
/*
Search
*/
    .search-bar{
        background-color: #006464;
        font-size: 1.2em;
        color: white;
        padding: 10px;
    }
    .details-control, .details-control-2 {
        cursor: pointer;
    }
    .textCenter{
        text-align: center;
    }
    .textRight{
        text-align: right;
    }
    td{
        min-width: 10%;
    }
    td.streched{
        min-width: 100px;
    }
    td.details-control:after ,td.details-control-2:after {
        font-family: 'FontAwesome';
        content: "\f0da";
        color: #303030;
        font-size: 17px;
        float: right;
        padding-right: 25px;
    }
    tr.shown td.details-control:after, tr.shown td.details-control-2:after {
        content: "\f0d7";
    }
    table td.absorbing-column {
    width: 50%;
}

    .child_table {
        margin-left: 78px;
        width: 920px;;
    }
    .panel {
    border: 0;
}

.top-margin{
    margin-top: -30px;
}
    table
    {
        counter-reset: Serial;
        table-layout: auto;
    }

    table.counter_table tr td:first-child:before
    {
        counter-increment: Serial;      /* Increment the Serial counter */
        content: counter(Serial); /* Display the counter */
    }

    .modal-fullscreen{
      margin: 0;
      margin-right: auto;
      margin-left: auto;
      width: 95% !important;
    }


    @media (min-width: 768px) {
      .modal-fullscreen{
        width: 750px;
      }
    }
    @media (min-width: 992px) {
      .modal-fullscreen{
        width: 970px;
      }
    }
    @media (min-width: 1200px) {
      .modal-fullscreen{
         width: 1170px;}
    }
    table#product_details_table,#payment_detail_products
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
    .bg-yellow
    {
        background:#d7e748;
        color: #fff;
    }
    .bg-black
    {
        background:#000;
        color: #fff;
    }
    .bg-light-green
    {
        background:#6d9370;
        color: #fff;
    }
    .start_col{
        background: red;
        color: white;
    }
    .address_lines{
        margin-bottom: 6px !important;
    }
</style>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class='cart-info'></strong>
            </div>
            <div class="row">
                <div class="col-sm-11 col-sm-offset-1">
					{!! Breadcrumbs::render('station.dashboard') !!}
                    <div class="col-sm-12"><h2>Station Dashboard</h2></div>
                    {{-- Tabbed Nav --}}
						<div class="panel with-nav-tabs panel-default ">
							<div class="panel-heading">
								<ul class="nav nav-tabs">
                                    <li class="active"><a href="#sales-order" data-toggle="tab">Order</a></li>
                                    <li class=""><a href="#pricing-table" data-toggle="tab">Table</a></li>
									<li class=""><a href="#sales-order" data-toggle="tab">Payment</a></li>
									
								</ul>
							</div>
						</div>
                    {{--ENDS  --}}

                        <div id="dashboard" class="row panel-body " >
                        <div class="tab-content top-margin" style="margin-top:-50px">
                            <div id="sales-order" class="tab-pane fade in active">
                                <h2>Sales Order</h2>
                                <hr>
                                <div class="row">
                                    <div class=" col-sm-12">
                                        <table class="table table-bordered"  id="sales-order-table">
                                            <thead>
                                            
                                            <tr class="bg-black">
                                                <th>No </th>
                                                <th>Width</th>
                                                <th>Length</th>
                                                <th>Height</th>
                                                <th>Weight</th>
                                                <th>Sender</th>
                                                <th>Recepient</th>
                                                <th>Start</th>
                                                <th>Due Date</th>
                                                <th>Recevied Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><a href="javascript:void" onclick="open_sender_popup()">Subang Jaya</a></td>
                                                    <td><a href="#">Puchong</a></td>
                                                    <td class="text-center start_col" ><strong>Start</strong></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>
                                </div>
                                </div>    
                            </div>

                            <div id="pricing-table" class="tab-pane fade in">
                                <h2>Pricing Table </h2>
                                <hr>
                                <div class="row">
                                    <div class=" col-sm-12">
                                <form id="pricing_form">
                                        <table width="100%" class="table table-bordered"  id="pricing-table-table">
                                            <thead>
                                            
                                            <tr class="bg-light-green">
                                                <th class="text-center">No </th>
                                                <th class="text-center">Width</th>
                                                <th class="text-center">Length</th>
                                                <th class="text-center">Height</th>
                                                <th class="text-center">Weight</th>
                                                <th class="text-center">Location</th>
                                                <th  class="text-center smallestest">Price</th>
                                            </tr>
                                            </thead>

                                                <tbody id="pricing-table-body">
                                            
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td><input type="text" class="numOnly" name="row_1_width"></td>
                                                        <td><input type="text" class="numOnly" name="row_1_length"></td>
                                                        <td><input type="text" class="numOnly" name="row_1_height"></td>
                                                        <td><input type="text" class="numOnly" name="row_1_weight"></td>
                                                        <td><select class="form-control" name="row_1_location"><option value="">--select--</option></select></td>
                                                        <td><input type="text" class="numOnly" name="row_1_price"></td>
                                                    </tr>
                                                
                                                </tbody>
                                           
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td id="pricing_add_row" style="cursor: pointer; background: #00ff00; color: white" class="text-center "><span class="fa fa-plus"></span></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        </form>
                                </div> 
                                <div class=" col-sm-12">
                                    <p id="errmsg"></p>
                                    <button id="save_pricing_table" class="btn btn-green">Save</button>
                                </div> 
                                </div> 
                            </div>
                            <div id="payment" class="tab-pane fade in">
    							<div class="well">payment tab body</div>
                            </div>
                        </div>
                        

				</div>
            </div>
        </div>
    </section>
    
        <div class="modal fade myModal" id="Modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Payment</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>
<!-- start Popups -->    
    <div id="modal-sender" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2>Sender Details</h2>
                        </div>
                        <div class="modal-body" style="padding: 0 20px 20px 20px;">
                          <div class="row">
                              <div class="col-md-12">
                                 <form class="form-horizontal">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                          <strong class="col-sm-3">Name:</strong>
                                          <div class="col-sm-9">
                                            <span>Hamza </span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <strong class="col-sm-3">Contact:</strong>
                                          <div class="col-sm-9">
                                            <span>034255514 </span>
                                          </div>
                                        </div>
                                        <div class="form-group address_lines">
                                          <strong class="col-sm-3">Address:</strong>
                                          <div class="col-sm-9">
                                            <span>line 1 </span>
                                          </div>
                                        </div>
                                         <div class="form-group address_lines">
                                          <div class="col-sm-9 col-sm-offset-3">
                                            <span>line 2 </span>
                                          </div>
                                        </div>
                                        <div class="form-group address_lines">
                                          <div class="col-sm-9 col-sm-offset-3">
                                            <span>line 3 </span>
                                          </div>
                                        </div>
                                        <div class="form-group address_lines">
                                          <div class="col-sm-9 col-sm-offset-3">
                                            <span>line 4 </span>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                          <strong class="col-sm-4">Country:</strong>
                                          <div class="col-sm-8">
                                            <span>pakistan </span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <strong class="col-sm-4">State:</strong>
                                          <div class="col-sm-8">
                                            <span>Punjab </span>
                                          </div>
                                        </div>
                                        <div class="form-group" style="">
                                          <strong class="col-sm-4">City:</strong>
                                          <div class="col-sm-8">
                                            <span>lahore </span>
                                          </div>
                                        </div>
                                    </div>
                                  </form>
                          </div>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
<!-- end Popups -->    



{{-- <script type="text/javascript" src="{{asset('js/autolink.js')}}"></script> --}}
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>


<script>
 
    
    $('#sales-order-table').DataTable({
            "order": [],
            "columnDefs": [
                { "targets": "no-sort", "orderable": false },
                { "targets": "large", "width": "120px" },
                { "targets": "smallestest", "width": "55px" },
                { "targets": "medium", "width": "95px" },
                { "targets": "xlarge", "width": "280px" }
            ]
        });
    $('#pricing-table-table-test').DataTable({
            "order": [],
            "columnDefs": [
                { "targets": "no-sort", "orderable": false },
                { "targets": "large", "width": "120px" },
                { "targets": "smallestest", "width": "55px" },
                { "targets": "medium", "width": "95px" },
                { "targets": "xlarge", "width": "280px" }
            ]
        });
    function open_sender_popup() {
        $("#modal-sender").modal('show');
    }
    count_pricing_row=1;
    function add_row_pricing_table() {
        
        
    }
    $("#pricing-table-table").on('click', '#pricing_add_row', function(event) {
        count_pricing_row++;
        $("#pricing-table-body").append('<tr><td>'+count_pricing_row+'</td>'+
                            '<td><input class="numOnly" type="text" name="row_'+count_pricing_row+'_width"></td>'+
                            '<td><input  class="numOnly" type="text" name="row_'+count_pricing_row+'_length"></td>'+
                            '<td><input class="numOnly"  type="text" name="row_'+count_pricing_row+'_height"></td>'+
                            '<td><input class="numOnly"  type="text" name="row_'+count_pricing_row+'_weight"></td>'+
                            '<td><select name="row_'+count_pricing_row+'_location"><option value="">--select--</option></select></td>'+
                            '<td><input class="numOnly"  type="text" name="row_'+count_pricing_row+'_price"></td></tr>'
        );
        $('select').select2();

    });
    $(document).on('click','#save_pricing_table', function(event) {
        var jsonObj=  [];   
            for(var i=1; i<=count_pricing_row; i++)
            {
                item = {};
                item ['row_'+i+'_width'] = $('input[name=row_'+i+'_width]').val();
                item ['row_'+i+'_length'] = $('input[name=row_'+i+'_length]').val();
                item ['row_'+i+'_height'] = $('input[name=row_'+i+'_height]').val();
                item ['row_'+i+'_weight'] = $('input[name=row_'+i+'_weight]').val();
                item ['row_'+i+'_location'] = $('input[name=row_'+i+'_location]').val();
                item ['row_'+i+'_price'] = $('input[name=row_'+i+'_price]').val();
                jsonObj.push(item);  
            }
            console.log(JSON.stringify(jsonObj));
        console.log(jsonObj);
    });
    
    $(document).on('keypress', '.numOnly', function(e) {
        var character = String.fromCharCode(e.keyCode)
        var newValue = this.value + character;
        if (isNaN(newValue) || hasDecimalPlace(newValue, 3)) {
            e.preventDefault();
            return false;
        }
    });
    function hasDecimalPlace(value, x) {
        var pointIndex = value.indexOf('.');
        return  pointIndex >= 0 && pointIndex < value.length - x;
    }

</script>


@stop

