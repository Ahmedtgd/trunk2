<?php
use App\Http\Controllers\IdController;
$cf = new \App\lib\CommonFunction();
$active_currency = \App\Models\Currency::where('active', 1)->first()->code;
define('MAX_COLUMN_TEXT',50);
?>
@extends("common.default")
@if((\Illuminate\Support\Facades\Session::has('album')))
    <div class="alert alert-success">
        <strong>Success!</strong> Product Registered successfully.
    </div>
@endif
@if((\Illuminate\Support\Facades\Session::has('albumupdated')))
    <div class="alert alert-success">
        <strong>Success!</strong> Product Updated successfully.
    </div>
@endif
@section("content")
	{!! Html::style('css/editor.dataTables.min.css') !!}
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<style>
		.nav>li>span {
			position: relative;
			display: block;
			padding: 10px 15px;
		}	
		.btn-number{
			height: 30px;
		}
	</style>
    <style>
		.ret_price{
			cursor: text;
		}
		
		.disc_price{
			cursor: text;
		}
		
		.ret_qty{
			cursor: text;
		}
		.newspinner {
			position: static !important;
			left: -2.14285714em;
			width: 2.14285714em;
			top: .14285714em;
			text-align: center;
		}
	
		html {
			overflow: -moz-scrollbars-vertical;
		}
	
        .easy-autocomplete {
            width: 100% !important;
        }
        .easy-autocomplete-container {
            width: 250px !important;
        }

        li.selected {
            outline: 1px solid #27A98A;
        }
        select label {
            display: inline;
        }

		/* This is the magical stanza for the misaligned header
		 * problem which has been affecting datatables! */
        table.dataTable th, td {
            max-width: 180px !important;
            word-wrap: break-word
        }

        .details-control, .details-control-2 {
            cursor: pointer;
        }

        td.details-control:after, td.details-control-2:after {
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

        .child_table {
            margin-left: 78px;
            width: 920px;;
        }

        .panel {
            border: 0;
        }

        table {
			table-layout: auto !important;
            counter-reset: Serial;
        }

        table.counter_table tr td:first-child:before {
            counter-increment: Serial; /* Increment the Serial counter */
            content: counter(Serial); /* Display the counter */
        }

        .badge-checkbox {
            -webkit-appearance: checkbox;
            -moz-appearance: checkbox;
            -ms-appearance: checkbox;
        }

        table.popup-table th{
            text-align: center;
            background: #337AB7;
            color : #fff;
        }

        table.popup-table tbody td {
            text-align: center;
        }

		.old-value:hover {
			text-decoration: underline;
		}

		.edit_pro:hover {
			text-decoration: underline;
		}

        .margin-top {
            margin-left: -15px;
            margin-right: -15px;
        }

        label.err {
            font-size: 12px;
            color : red;
            font-weight: normal;
        }

        input.errorBorder, span.errorBorder {
            border: 1px solid #F00;
        }

        .errorBorder {
            border: 1px solid #F00;
        }

        .errorDoubleBorder {
            border: 2px solid #F00;
        }

        .errorBorderIng {
            border: 1px solid #F00;
            border-radius: 5px 0px 0px 5px;
        }

        .die {
            pointer-events: none;
            cursor: default;
            opacity: 0.6;
        }

        .li_same_size {
            width: 37px;
            height: 37px;
        }

        form input.error, form select.error, form textarea.error {
            background-color: #FFFFC8 !important;
            border: 1px solid #F00 !important;
        }

        .mt {
            margin-top: 10px;
        }

        table#tab-product-detail {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        /* Start by setting display:none to make this hidden.
       Then we position it in relation to the viewport window
       with position:fixed. Width, height, top and left speak
       speak for themselves. Background we set to 80% white with
       our animation centered, and no-repeating */
        .modal_loading {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url('http://sampsonresume.com/labs/pIkfp.gif') 50% 50% no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal_loading {
            display: block;
        }
        #imagePreviewDiscount {
           position: absolute;
            left: 0;
            height: 170px;
        }
        #imagePreviewVoucher {
           position: absolute;
            left: 0;
            height: 304px;
        }      
		#imagePreviewVoucherv1 {
           position: absolute;
            left: 0;
            height: 304px;
        }		
		#imagePreviewVoucherv2 {
           position: absolute;
            left: 0;
            height: 304px;
        }
		
		#imagePreviewVouchercoverv2 {
            left: 0;
            height: 200px;
        }
        .displaynone{
            display:none;
        }		
    </style>
    <section class="">
        {{--Model Start--}}
        <div class="modal fade" tabindex="-1" role="dialog" id="myModalB2B">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
						<table id="myTable" class="table table-bordered myTable">
							<tr>
								<td style="background-color: #7F7F7F; color: white; text-align: center;" >
									B2B
								</td>
								<td style="background-color: #7F7F7F; color: white; text-align: center;" >
									Special
								</td>
								<td style="background-color: #7F7F7F; color: white; text-align: center;">
									Qty
								</td>
							</tr>
							<tr>
								<td style="text-align: center;">
									<span id="b2bspan"  style="text-align: right;"></span>
								</td>
								<td style="text-align: center;">
									<span id="specialspan" style="text-align: right;"></span>
								</td>
								<td style="text-align: right;">
									<span id="qtyspan"  style="text-align: right;"></span>
								</td>
								<!--<td style="text-align: right;">
									<span id="totalspan" ></span>
								</td> -->
							</tr>
						</table>						
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Model End--}}	
        {{--Model Start--}}
        <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <p>...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Model End--}}
        {{--Model Start--}}
        <div class="modal fade" tabindex="-1" role="dialog" id="myModalProduct">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Choose Subcategory:</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="subcategory" class="col-sm-3 control-label">Sub Category:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="subcategory">
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="goToLink">Go</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Model End--}}
		
		@include("common.sellermenu")		
		
        <input type="hidden" id="merchant_id" value="{{ $merchant_id }}">
        <input type="hidden" id="useridsell" value="{{ $selluser->id }}">
		
        <div class="container" style="display: none;" id="album_content">
		<!--Begin main container-->
            <div class="row">
                <div class="col-sm-12">
					{!! Breadcrumbs::render('album') !!}
                    <div class="col-sm-12">
                        <h2>Album</h2> 
                    </div>
                    {{-- Tabbed Nav --}}
                </div> {{--End Of Div col-sm-11--}}
            </div> {{--End of Div Row--}}
        </div><!--End main container-->
        <div class="container">
        	
                  @if(count($file_data) > 0)
                  <div class="tab-pane" id="product-detail">
									<h2>Uploding File</h2>
									<a href="{{url('/product/import_public?merchant_id='.$merchant_id)}}"<button class="btn btn-info pull-right"
												style="margin-top:-20px;margin-bottom:10px;margin-right:0"
												type="button" id="import_public" title=""> New file Import
										</button></a>
									<div class="col-md-12" style="padding-right:0">
									</div>
									<p align="center" style="display: none;" id="myspinner">
										<i class="fa-li fa fa-spinner fa-spin fa-2x fa-fw"
										style="margin-left:50px;position: static">
										</i>
									</p>
									<div id="thetable">
										<table id="tab-product-detail" class="table-bordered"
											cellpadding="0" cellspacing="0" border="0">
											<thead>
												<tr class="bg-black" id="table_row">
													<th class="text-center no-sort" style="background-color: black;">No</th>
													<th class="text-center no-sort" style="background-color: black;">Product Name</th>
													<th class="text-center no-sort" style="background-color:#558ED5;">Brand Name</th>
													<th class="text-center xxlarge" style="background-color: black;">Category</th>
													<th class="text-center" style="background-color: #4A452A;">Description</th>
													<th class="text-center blarge" style="background-color: #4A452A;">Retail Price</th>
													<th class="text-center blarge" style="background-color: #4A452A;">Selling Price</th>
													<th class="text-center" style="background-color: #4A452A;">Online Stock Balance</th>
													<th class="text-center" style="background-color: #7F7F7F;">Online Stock Balance</th>
												</tr>
											</thead>
											<tbody>
											<?php $count=1; ?>
											@foreach($file_data as $report)
												<tr>
													<td>{{$count++}}</td>
													<td>{{$report->name}}</td>
													<td>{{$report->brand}}</td>
													<td>{{$report->category}}</td>
													<td>{{$report->description}}</td>
													<td>{{$report->retail_price}}</td>
													<td>{{$report->discounted_price}}</td>
													<td>{{$report->available}}</td>
													<td>{{$report->consignment}}</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
									<br>
								</div>
					@else
					<form method="POST" action="{{url('product/import_file_post')}}" accept-charset="utf-8" class="email" id="product_info_form" enctype="multipart/form-data"><input name="_token" type="hidden" value="b6d4Ecp6hYF6hLsKRBXVv0AaVBOP40WTnXl3nbSC">
                           <input type="hidden"  name="merchant_id" value="{{ $merchant_id }}">
                           <div class="row set_btn">
                            <div class="width_col">
                                <div class="widget widget-4 row">
                                    <div class="widget-head"><h4 class="heading">Upload Product</h4></div>
                                    <div class="separator"></div>			
                                    <div class="fileupload fileupload-new margin-none" data-provides="fileupload">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file"><span class="fileupload-new">Browse</span><span class="fileupload-exists">Change</span>
                                                    <input type="file" name="upload_signature" id="upload_signature" class="margin-none"></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div></div>
                        <div class="row form-actions set_btn marg-top">
                                                                <button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" id="save_upload_signature"><i></i>Save</button>  
                                                                <button type="reset" class="btn btn-icon btn-default glyphicons circle_ok" id="clear_signature"><i></i>Cancel</button>


                        </div>		
                      </form>
                  @endif
        </div>
		<br>
    </section>
	@if(Auth::user()->hasRole('adm'))
		<input type="hidden" value="1" id="albumadmin"/>
	@else
		<input type="hidden" value="0" id="albumadmin"/>
	@endif
@stop

@section('scripts')
    <script src="{{url('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('js/dataTables.editor.min.js')}}"></script>
    <script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>
    <script src="{{url('js/editablegrid/editablegrid-2.1.0.js')}}"></script>
    <script src="{{url('js/editablegrid/editablegrid-custom.js')}}"></script>
    <script src="{{url('js/editor-custom.js')}}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#B2B').click(function(e){
        e.preventDefault();
 $(this).tab('show');
    });
    var product_table = $("#tab-product-detail").DataTable({
		'order': [],
        'responsive': false,
        'autoWidth': false,
		"scrollX":true,
		"aoColumnDefs": [
			{"bSortable":false, "aTargets": [0,1,2]},
		],
		"columnDefs": [
			{ "targets": "no-sort", "orderable": false },
			{ "targets": "small", "width": "50px" },
			{ "targets": "medium", "width": "80px" },
			{ "targets": "large", "width": "120px" },
			{ "targets": "blarge", "width": "200px" },
			{ "targets": "xlarge", "width": "280px" }
		]
    });		
    $("#save_upload_signature").click(function () {
        $(".error").remove();
        var formData = new FormData($("form#product_info_form")[0]);
        console.log(formData);
        var status = 0;
        //alert(formData);
        //return false;
        $("#loader").css("display", "block");
        $('#signature_form > button[type=submit]').attr({'disabled': true});
        $.ajax({
			type: "post",
			url: JS_BASE_URL + '/product/cashback',
			data: {id: proid,value:value},
			cache: false,
			success: function (responseData) {
				console.log(responseData);
				$(".displaynone").css("display","none");
				if(responseData == 1){
					$('#glyphiconcheck').show();
				}
				
			},
			
		});
    });
    
});                                    
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.delivery_waiver_min_amt').on("change paste keyup",function(){
            
            var value=$(this).val();
            $('.delivery_waiver_min_amt').val(value);
           
            
        });
		
		$('.delivery_waiver_min_amt_b2b').on("change paste keyup",function(){
            
            var value=$(this).val();
            $('.delivery_waiver_min_amt_b2b').val(value);
           
            
        });
    });
</script>
@stop

