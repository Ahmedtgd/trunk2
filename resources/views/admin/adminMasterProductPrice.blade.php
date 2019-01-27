@extends("common.default")

{{--
@section('breadcrumbs', Breadcrumbs::render('SalesStaff'))
--}}
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
		<div class="equal_to_sidebar_mrgn">
			<h2>Product Master: Prices</h2>
			<h3>Retail Product ID: 
				<a href="{{ URL::to('/') }}/productconsumer/{{ $product_id }}"
					target="_blank" >
					{{IdController::nP($product_id)}}
				</a>
			</h3>
			<?php 
				$b2bp = DB::table('product')->where('parent_id',$product_id)->where('segment','b2b')->first();
				if(!is_null($b2bp)){
			?>
			<h3>B2B Product ID: 
				<a href="{{ URL::to('/') }}/productconsumer/{{ $product_id }}"
					target="_blank" >
					{{IdController::nP($b2bp->id)}}
				</a>
			</h3>
			<?php } ?>
			<span  id="product-error-messages"></span>
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                <!-- <button type="button" id="btn-add" class="btn btn-primary btn-lg">Add Product</button> -->
                <!-- <hr> -->
				<input type="hidden" value="{{$currency}}" id="currencyval" />
                <div class="tableData">
					<div class="table-responsive">
						<table class="table table-bordered" cellspacing="0" width="100%" id="product_details_table">
							<thead>
							<tr style="background-color: #444; color: #fff;">
								<th class="text-center no-sort bsmall">No.</th>
								<th class="text-center blarge">Name</th>
								<!-- <th class="text-center medium">Category</th>
								<th class="text-center medium">Subcategory</th>
								<th class="text-center medium">Brand</th>
								<th class="text-center medium">Product&nbsp;ID</th>
								<th class="text-center medium">Segment</th>
								<th class="text-center medium">Qty</th>-->
								<th class="text-center medium" style="background-color: #4A452A;">Retail</th>
								<th class="text-center medium" style="background-color: #4A452A;">Selling</th>
								<th class="text-center medium" style="background-color: #4A452A;">Qty</th>
								<th class="text-center medium" style="background-color: #7F7F7F;">Special</th>
								<th class="text-center medium" style="background-color: #7F7F7F;">B2B</th>
								<th class="text-center medium" style="background-color: #7F7F7F;">Qty</th>
								<th class="text-center medium" style="background-color: #004080;">Hyper</th>
							<!--	<th class="text-center ">Likes&nbsp;</th> -->
							</tr>
							</thead>
							<tbody>

							@if(isset($product) && !empty($product))
								@foreach($product as $key => $productList)
									<tr>
										<td style="text-align: center;">{{$key+1}}</td>
										<?php 
											$pname = $productList->name;
											if(strlen($pname) > 30){
												$pname = substr($pname, 0 , 27);
												$pname .= "...";
											}
										?>
										<td><img src="{{asset('/')}}/images/product/{{$productList->id}}/{{$productList->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:4px"><span style="vertical-align: middle;">{{$pname}}</span></td>
										<td style="text-align: right;">
										<?php
											$retail_price = number_format(($productList->retail_price/100),2);
										?>
										{{$currency}} {{$retail_price}}</td>
										<td style="text-align: right;">
										<?php
											$discounted_price = number_format(($productList->discounted_price/100),2);
										?>
										{{$currency}} {{$discounted_price}}</td>
										<?php
											$display = "none";
											$displayna = "visible";
											$availableb2b = "";
											$b2b = DB::table('product')->where('parent_id',$productList->id)->where('segment','b2b')->first();
											if(!is_null($b2b)){
												$display = "visible";
												$displayna = "none";
												$availableb2b = $b2b->available;
											}
										?>
										<td class="text-center">
											{{$productList->available}}
										</td>
										<td class="text-center">
											<a rel="{{ $productList->id }}" style="display: {{$display}};" class="sp_info" href="javascript:void(0)">Special</a>
											<p style="display: {{$displayna}};">N.A.</p>
										</td>
										<td class="text-center">
											<a rel="{{ $productList->id }}" style="display: {{$display}};" class="wp_info" href="javascript:void(0)">B2B</a>
											<p style="display: {{$displayna}};">N.A.</p>
										</td>
										<td class="text-center">
											{{$availableb2b}}
										</td>
										<td class="text-center">
                                        <a rel="{{ $productList->id}}" class="hyper_info" href="javascript:void(0)">Hyper</a>
                                        </td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
                </div>
                {{--Model Form Start--}}
				<!-- Button trigger modal -->

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add Sales Staff</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="#" id="addSalesStaff">

                                    <div class="form-group">
                                        <label for="emp-user-id" class="col-sm-2 control-label">User Id</label>
                                        <div class="col-sm-4">
                                            <select class="bootstrap-select" id="staff-user-id">

                                            </select>
                                        </div>

                                        <label for="emp-position" class="col-sm-2 control-label">Type</label>
                                        <div class="col-sm-4">
                                            {{--<input type="text" class="form-control" id="staff-type"--}}
                                            {{--placeholder="Enter type">--}}

                                            <select class="bootstrap-select" id="staff-type">
                                                <option value="SMM">SMM</option>
                                                <option value="MCT">MCT</option>
                                                <option value="MCP">MCP</option>
                                                <option value="PSH">PSH</option>
                                                <option value="STR">STR</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="emp-visa-no" class="col-sm-2 control-label">Target Merchant</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="staff-target-merchant"
                                            placeholder="Enter target merchant">
                                        </div>

                                        <label for="emp-socso-no" class="col-sm-2 control-label">Target Revenue</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" class="form-control" id="staff-target-revenue"
                                                   placeholder="Enter target revenue">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="emp-epf-no" class="col-sm-2 control-label">Commission</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" step="any" class="form-control" id="staff-commission"
                                                   placeholder="Enter commission">
                                        </div>

                                        <label for="emp-pcb" class="col-sm-2 control-label">Bonus</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" step="any" class="form-control" id="staff-bonus"
                                                   placeholder="Enter bonus">
                                        </div>

                                    </div>

                                    {{--<button type="submit" class="btn btn-default">Save</button>--}}
                                    <input type="hidden" id="staff-staff-id" value="">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-title">Save</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            {{--Model Form End--}}
    </div>
	<!-- Modal WHOLESALE -->
	<div class="modal fade" id="WholeSaleModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">B2B Price/Unit</h4>
				</div>
				<div class="modal-body">
					<div id="title_winfo_modal"></div>
					<div id="title_winfo_modal2"></div>
					<div id="content_winfo_modal">
						<table id="wholetable" class="table table-bordered wholetable"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>

	<!-- Modal SPECIAL -->
	<div class="modal fade" id="SpecialModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Special User/Price/Unit</h4>
				</div>
				<div class="modal-body">
					<div id="title_sinfo_modal"></div>
					<div id="content_winfo_modal">
						<table id="sepcialtable" class="table table-bordered sepcialtable"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>
    {{--</div>--}}

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

	<!-- Modal LIKE -->
	<div class="modal fade" id="LikeModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Likes</h4>
				</div>
				<div class="modal-body">
					<div id="title_like_modal"></div>
					<div id="content_like_modal">
						<table id="likes_info" class="table table-bordered"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>

    <!-- Modal HYPER -->
    <div class="modal fade" id="HyperModal" role="dialog" aria-labelledby="WholeSaleModal">
        <div class="modal-dialog" role="document" style="width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-titlelike" id="myModalLabel">Hyper</h4>
                </div>
                <div class="modal-body">
                    <div id="title_hyper_modal"></div>
                    <div id="content_hyper_modal">
                        <table id="hyper_info" class="table table-bordered">
                            <tr>
                                <td width="150px" style="background-color: #444; color: #fff;">MOQ</td>
                                <td><span id="moq"></span></td>
                            </tr>
                            <tr>
                                <td style="background-color: #444; color: #fff;">MOQ/pax</td>
                                <td><span id="pax"></span></td>
                            </tr>
                            <tr>
                                <td style="background-color: #444; color: #fff;">Price</td>
                                <td><span id="price"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="SpecModal" role="dialog" aria-labelledby="WholeSaleModal">
        <div class="modal-dialog" role="document" style="width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-titlespec" id="myModalLabel">Specifications</h4>
                </div>
                <div class="modal-body">
                    <div id="title_spec_modal"></div>
                    <div id="content_spec_modal">
                        <table id="spec_info" class="table table-bordered">

                        </table>
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
            function pad (str, max) {
                str = str.toString();
                return str.length < max ? pad("0" + str, max) : str;
            }
			
			$(document).delegate( '.availability_p', "click",function (event) {
				var rel = $(this).attr("rel");
				$(this).hide();
				$("#availability_" + rel).show();
			});
	
			$(document).delegate( '.availability_value', "blur",function (event) {
				var rel = $(this).attr("rel");
				var value = $(this).val();
				var url = '/admin/product/update_availability/'+rel;

                $.ajax({
                    type: "POST",
                    url: url,
					data: {available: value},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
						toastr.info("Availability successfully saved!");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });		
				$("#availability_" + rel).hide();
				$("#availability_p" + rel).text(value);
				$("#availability_p" + rel).show();
			});
	
			$(document).delegate( '.subcategory_p', "click",function (event) {
				var rel = $(this).attr("rel");
				$(this).hide();
				$("#subcategory_" + rel).show();
			});
	
			$(document).delegate( '.subcategory_value', "change",function (event) {
				var rel = $(this).attr("rel");
				var value = $(this).val();
				var url = '/admin/product/update_subcategory/'+rel;

                $.ajax({
                    type: "POST",
                    url: url,
					data: {subcategory: value},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
						toastr.info("Subcategory successfully saved!");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });
				var texti = $("#subcategory_select"+rel+" option:selected").text();				
				$("#subcategory_" + rel).hide();
				$("#subcategory_p" + rel).text(texti);
				$("#subcategory_p" + rel).show();
			});	
	
			$(document).delegate( '.category_p', "click",function (event) {
				var rel = $(this).attr("rel");
				$(this).hide();
				$("#category_" + rel).show();
			});
	
			$(document).delegate( '.category_value', "change",function (event) {
				var rel = $(this).attr("rel");
				var value = $(this).val();
				var url = '/admin/product/update_category/'+rel;

                $.ajax({
                    type: "POST",
                    url: url,
					data: {category: value},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
						toastr.info("Category successfully saved!");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });
				var texti = $("#category_select"+rel+" option:selected").text();				
				$("#category_" + rel).hide();
				$("#category_p" + rel).text(texti);
				$("#category_p" + rel).show();
			});				
			
			$(document).delegate( '.brand_p', "click",function (event) {
				var rel = $(this).attr("rel");
				$(this).hide();
				$("#brand_" + rel).show();
			});
	
			$(document).delegate( '.brand_value', "change",function (event) {
				var rel = $(this).attr("rel");
				var value = $(this).val();
				var url = '/admin/product/update_brand/'+rel;

                $.ajax({
                    type: "POST",
                    url: url,
					data: {brand: value},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
						toastr.info("Brand successfully saved!");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });
				var texti = $("#brand_select"+rel+" option:selected").text();				
				$("#brand_" + rel).hide();
				$("#brand_p" + rel).text(texti);
				$("#brand_p" + rel).show();
			});			
	
            var formSubmitType = null;

            //Function To handle add button action
            $("#btn-add").click(function () {
                formSubmitType = "add";
                $(".modal-title").text("Add Staff");
                $("#addSalesStaff").trigger("reset");
                $("#myModal").modal("show");

            });

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

			var likes_info;
			$(document).delegate( '.likes_infoa', "click",function (event) {
            //$(".likes_infoa").click(function () {

                $('#title_like_modal').html("");
                var currency = $('#currencyval').val();

                if(likes_info){
                    likes_info.destroy();
                    $('#likes_info').empty();
                }

                _this = $(this);

                var id_product= _this.attr('rel');

                var url = '/admin/product/likes/'+id_product;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#likes_info').append('<thead style="background-color: #444; color: #fff;"><th>No</th><th>Buyer ID</th><th>Since</th></thead>');
                        $('#likes_info').append('<tbody>');
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
							if(i==0){
								$('#title_like_modal').append("<h2> Product: "+ obj.name + "</h2>");
							}
                            $('#likes_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;"><a href="' + JS_BASE_URL + '/admin/popup/user/'+obj.user_id+'">['+ pad(obj.user_id,10) +']</a></td><td style="text-align: center;">' + obj.since + ' </td></tr>');
                        }
                        $('#likes_info').append('</tbody>');

                        likes_info = $('#likes_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "40px" }
                              ]
                        });

                        $("#LikeModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });
			
			$(document).delegate( '.hyper_info', "click",function (event) {

                $('#title_like_modal').html("");

                _this = $(this);

                var id_product= _this.attr('rel');

                var url = '/admin/product/hyper/'+id_product;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

                       if (data) {
                        $("#moq").text(data.owarehouse_moq);
                        $("#pax").text(data.owarehouse_moqperpax);
                        $("#price").text(data.owarehouse_price);
                       }else {
                        $("#moq").text("");
                        $("#pax").text("");
                        $("#price").text("");
                       }
                       $("#HyperModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });

			var spec_info;			
			$(document).delegate( '.spec_info', "click",function (event) {
            //$(".spec_info").click(function () {

                $('#title_spec_modal').html("");

                if(spec_info){
                    spec_info.destroy();
                    $('#spec_info').empty();
                }				
				
                _this = $(this);

                var id_product= _this.attr('rel');

                var url = '/admin/product/spec/'+id_product;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $('#spec_info').append('<thead style="background-color: #444; color: #fff;"><th class="text-center">No</th><th class="text-center">Description</th><th class="text-center">Value</th></thead>');
                        $('#spec_info').append('<tbody>');
                       for (i=0; i < data.length; i++) {
                            var obj = data[i];
                            // if(i==0){
                            //     $('#title_spec_modal').append("<h2> Description: "+ obj.description + "</h2>");
                            // }
                            $('#spec_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;">'+obj.description+'</td><td style="text-align: center;">' + obj.name + ' </td></tr>');
                        }
                        $('#spec_info').append('</tbody>');

                        spec_info = $('#spec_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "40px" }
                              ]
                        });

                       $("#SpecModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });

            //Function To Handle Edit Button action
			$(document).delegate( '.btn-edit', "click",function (event) {
           // $(".btn-edit").click(function () {
                $("#addSalesStaff").trigger("reset");
                $("#myModal").modal("hide");

                var val = $(this).attr('value');
                console.log(val);
                var url = "/admin/general/salesstaff/" + val + "/edit";
                formSubmitType = "edit";
                $(".modal-title").text("Edit Sale Staff");

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $("#staff-user-id").val(data["user_id"]);
                        $("#staff-type").val(data["type"]);
                        $("#staff-bonus").val(data["bonus"]);
                        $("#staff-commission").val(data["commission"]);
                        $("#staff-target-merchant").val(data["target_merchant"]);
                        $("#staff-target-revenue").val(data["target_revenue"]);
                        $("#staff-staff-id").val(data["id"]);

                        $("#myModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            })

            //Delete Recored
			$(document).delegate( '.btn-delete', "click",function (event) {
           // $(".btn-delete").click(function () {
                if (confirm('Are you sure you want to remove Staff Record?')) {
                    var id = $(this).attr("value");
                    var my_url = '/admin/general/salesstaff/' + id;
                    var method = "DELETE";

                    $.ajax({
                        type: method,
                        url: my_url,
                        dataType: 'json',
                        success: function (data) {
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("Sale Staff successfully removed.");
                            $(".success-msg").fadeOut(4000);
                        },
                        error: function (error) {
                            console.log(error);
                        }

                    });

                }


            })

            //Handle Form Submit For Bothh Add and Edit
            $("#addSalesStaff").on('submit', function (event) {

                var method = null;
                var my_url = null;
                var id = null;


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                event.preventDefault();


                if (formSubmitType == null) {
                    return false;
                }

                if (formSubmitType == "edit") {
                    id = $("#staff-staff-id").val();
                    method = 'PUT';
                    my_url = '/admin/general/salesstaff/' + id;
                }

                if (formSubmitType == "add") {
                    method = 'POST';
                    my_url = '/admin/general/salesstaff';
                }

                var formData = {
                    user_id: $("#staff-user-id").val(),
                    type: $("#staff-type").val(),
                    commission: $("#staff-commission").val(),
                    bonus: $("#staff-bonus").val(),
                    target_merchant: $("#staff-target-merchant").val(),
                    target_revenue: $("#staff-target-revenue").val(),
                }
                console.log(formData);
                $.ajax({
                    type: method,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
//                        console.log(data);

                        $('#myModal').modal('hide');
                        $(".success-msg").fadeIn();
                        if (formSubmitType == 'edit') {
                            $(".success-msg").text("Sales Staff successfully updated.");
                        } else {
                            $(".success-msg").text("Sales Staff successfully added.");
                        }
                        $(".success-msg").fadeOut(4000);
                        formSubmitType = null;
                    },
                    error: function (error) {
                        console.log( error);
                    }

                });

            })

			var wtable_modal;
			$(document).delegate( '.wp_info', "click",function (event) {
            //$(".wp_info").click(function () {

                $('#title_winfo_modal').html("");
                $('#title_winfo_modal2').html("");
                var currency = $('#currencyval').val();

                if(wtable_modal){
                    wtable_modal.destroy();
                    $('#wholetable').empty();
                }

                _this = $(this);

                var id_product= _this.attr('rel');
				if(id_product=="0"){
					//alert("Wholesale unavailable for this product");
				} else {

					var url = '/admin/product/wholesale/'+id_product;
					$.ajax({
						type: "GET",
						url: url,
						dataType: 'json',
						success: function (data) {
							$('#title_winfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
							console.log(data);
							$('#wholetable').append('<thead style="background-color: #444; color: #fff;"><th>No</th><th>Price</th><th>MinUnit</th><th>MaxUnit</th></thead>');
							$('#wholetable').append('<tbody>');
							for (i=0; i < data[0].wholesale.length; i++) {
								var obj = data[0].wholesale[i];
								var myprice = (obj.price/100).toFixed(2);
								$('#wholetable').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: right;">' + currency + ' '+myprice + '</td><td style="text-align: center;">'+obj.funit+'</td><td style="text-align: center;">'+obj.unit+'</td></tr>');
							}
							$('#wholetable').append('</tbody>');

							wtable_modal = $('#wholetable').DataTable({
								'autoWidth':false,
								 "order": [],
								 "iDisplayLength": 10,
								 "columns": [
									{ "width": "20px", "orderable": false },
									{ "width": "85px" },
									{ "width": "40px" },
									{ "width": "40px" }
								  ]
							});

							$("#WholeSaleModal").modal("show");
						},
						error: function (error) {
							console.log(error);
						}

					});
				}

            });

			var stable_modal;
			$(document).delegate( '.sp_info', "click",function (event) {
            //$(".sp_info").click(function () {

                $('#title_sinfo_modal').html("");
                var currency = $('#currencyval').val();

                if(stable_modal){
                    stable_modal.destroy();
                    $('#sepcialtable').empty();
                }

                _this = $(this);

                var id_product= _this.attr('rel');

                var url = '/admin/product/specialsale/'+id_product;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#sepcialtable').append('<thead style="background-color: #444; color: #fff;"><th>No</th><th>Username</th><th>Price</th><th>MinUnit</th><th>MaxUnit</th></thead>');
                        $('#sepcialtable').append('<tbody>');
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
							if(i==0){
								$('#title_sinfo_modal').append("<h2> Product: "+obj.name + "</h2>");
							}
							var myprice = (obj.special_price/100).toFixed(2);
							var usernames = obj.username;
							if(usernames == "null"){
								usernames = "";
							}
                            $('#sepcialtable').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td>'+ obj.username +'</td><td style="text-align: right;">' + currency + ' '+myprice + ' </td><td style="text-align: center;">'+obj.funit+'</td><td style="text-align: center;">'+obj.unit+'</td></tr>');
                        }
                        $('#sepcialtable').append('</tbody>');

                        stable_modal = $('#sepcialtable').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "40px" },
                                { "width": "40px" },
                                { "width": "40px" }
                              ]
                        });

                        $("#SpecialModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });
			$(document).delegate( '.toggle_shipping', "click",function (event) {
			//$(".toggle_shipping").click(function () {
				_this = $(this);
                var id_product= _this.attr('rel');
				$("#other_shipping" + id_product).toggle( "slow", function() {
					// ...
				 });
			});

            // $(".mcrid").click(function () {
            $(document).delegate( '.mcrid', "click",function (event) {
                _this = $(this);
                var id_product= _this.attr('rel');

                $('#modal-Tittle2').html("Remarks");

                var url = '/admin/master/product_remarks/'+ id_product;
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #444; color: white;'><th style='text-center'>No</th><th style='text-center'>Product ID</th><th style='text-center'>Status</th><th style='text-center'>Admin User ID</th><th>Remarks</th><th style='text-center'>DateTime</th></tr>";
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
                            html += "<tr>";
                            html += "<td>"+(i+1)+"</td>";
                            html += "<td><a href='../../productconsumer/"+id_product+"' class='update' data-id='"+id_product+"'>"+pad(id_product.toString(),10)+"</a></td>";
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

$('.view-product-modal').click(function(){

            var id=$(this).attr('data-id');
            var check_url=JS_BASE_URL+"/admin/popup/lx/check/product/"+id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/album/"+id;
                    var w=window.open(url,"_blank");
                    w.focus();
                    }
                    if (r.status=="failure") {
                        var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                        $('#product-error-messages').html(msg);
                    }
                }
            });


        });
window.setInterval(function(){
              $('#product-error-messages').empty();
            }, 10000);



    </script>
@stop
