@extends("common.default")<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
define('MAX_COLUMN_TEXT', 20);
$today = date('d');
$month = date('m');
$year = date('Y');
if($month == "02"){
    if($today < 16){
        $due_pay = "15-" . $month . "-" . $year . " 00:00:00";
    } else {
        $due_pay = "28-" . $month . "-" . $year . " 00:00:00";
    }
} else {
    if($today < 16){
        $due_pay = "15-" . $month . "-" . $year. " 00:00:00";
    } else {
        $due_pay = "30-" . $month . "-" . $year . " 00:00:00";
    }
}

if($month == "01"){
    if($today > 15){
        $paid_pay = "15-" . $month . "-" . $year. " 00:00:00";
    } else {
        $paid_pay = "30-" . "12". "-" . ($year-1) . " 00:00:00";
    }
} else if($today > 15){
    if($today > 15){
        $paid_pay = "15-" . $month . "-" . $year . " 00:00:00";
    } else {
        $paid_pay = "25-" . "02" . "-" . $year . " 00:00:00";
    }
} else {
    if($today > 15){
        $paid_pay = "15-" . $month . "-" . $year . " 00:00:00";
    } else {
        $paid_pay = "25-" . str_pad(($month - 1), 2, '0', STR_PAD_LEFT) . "-" . $year . " 00:00:00";
    }
}
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
        .com, .pay, .ocom, .opay, .osales {
            width: 170px ;
        }

        table#merchantTable, table#giro-detail
        {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        .text-center{
            text-align: center !important;
        }
    </style>
    <?php $i=1; ?>

    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')

        <h2>OCBC Giro Reader</h2><span  id="user-error-messages">
    </span>
        <div>
            @include('partials.alert')
            <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id='merchantTable'>

                <input type="hidden" value="mcp" name="ss_type" />

                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-sm-12">
                        <form id="giroUploadForm" action="{{route('uploadGiroReader')}}" enctype="multipart/form-data"
                              method="post" name="giroUploadForm">
                            <label type="button" id="giroUploadBtn" class="btn btn-success btn-file">
                                <span id="giroFileLabel">Upload</span>
                                <input id="giroFile" name="giroFile" type="file" style="display: none;">
                            </label>
                        </form>
                    </div>
                </div>

                <thead id="giro-header" style="display:none">
                    <tr style="background-color: #808080; color:#fff;">
                        <td>OCBC Giro Header</td><td></td>
                    </tr>
                    <tr>
                        <td style="width:30%">Company name: </td><td style="width:70%" id="company_name"></td>
                    </tr>
                    <tr>
                        <td style="width:30%">Company A/C No: </td><td style="width:70%" id="company_ac_no"></td>
                    </tr>
                    <tr>
                        <td style="width:30%">Company CIF #</td><td style="width:70%" id="company_cif"></td>
                    </tr>
                    <tr>
                        <td style="width:30%">Bank Branch ID:</td><td style="width:70%" id="branch"></td>
                    </tr>
                    <tr>
                        <td style="width:30%">Transaction Date</td><td style="width:70%" id="crediting_debiting_date"></td>
                    </tr>
                    <tr>
                        <td style="width:30%">Customer Ref. No:</td><td style="width:70%" id="customer_ref_no"></td>
                    </tr>
                </thead>
            </table>

            <br>

            <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id="giro-trailer" style="display:none;">
                <tfoot>
                <tr style="background-color: #808080; color:#fff;">
                    <td>OCBC Giro Trailer</td><td></td>
                </tr>
                <tr>
                    <td style="width:30%">Total Count: </td><td style="width:70%" id="total_count"></td>
                </tr>
                <tr>
                    <td style="width:30%">Total Amount</td><td style="width:70%" id="total_amount"></td>
                </tr>
                </tfoot>
            </table>

            <br>

            <table class="table table-bordered table-responsive" cellspacing="0" width="840px"
                   id="giro-detail" style="display:none;">
                <thead style="">
                <tr style="background-color: #808080; color:#ffffff;">
                    <th class="no-sort text-center bsmall">No</th>
                    <th class="text-center bmedium">Account&nbsp;No.</th>
                    <th class="text-center bmedium">Amount</th>
                    <th class="text-center bmedium">New&nbsp;IC&nbsp;No.</th>

                    <th class="text-center bmedium">Business&nbsp;Reg&nbsp;No</th>
                    <th class="text-center bmedium">Ref No</th>
                    <th class="text-center bmedium">R.FI&nbsp;ID</th>

                    <th class="text-center blarge">Name</th>
                    <th class="text-center bsmall">Invoices</th>
                </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

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
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>
	<?php 
		$giro_txt_file = "";
		if(isset($giro_txt)){
			$giro_txt_file = $giro_txt;
		}
	?>
	<input type="hidden" value="{{$giro_txt_file}}" id="giro_txt" />
	<!--
	<a href="javascript:void(0)" id="text_a">TEST</a>
	-->
    <script type="text/javascript">
        $(document).ready(function()
        {
//            $('#giro-detail').hide(); //still empty so hide

            var giro_txt = $("#giro_txt").val();
			if(giro_txt != ""){
				var url= JS_BASE_URL + "/admin/general/giro-reader/uploaded"; 
				var fd = new FormData();
				fd.append('giro', giro_txt);
				var uploadButtonLabel = $("#giroFileLabel");
				$.ajax({
					url: url,
					type: 'POST',
					data: fd,
					success:function(response) {
						if(response.status) {
							toastr.info('File retrieved successfully');
							uploadButtonLabel.html('Currently displayed: ' +giro_txt);

							var giro = response.data;
							console.log(giro);
							//giro header
							//---------------------------------------------
							var header = giro.header;
							var headers = ['company_name', 'company_ac_no',
								'company_cif', 'branch',
								'crediting_debiting_date', 'customer_ref_no'
							];

							for(var i=0; i < headers.length; i++) {
								$('#'+headers[i]).html(header[headers[i]]);
							}

							$('#giro-header').show();

							//giro trailer
							//--------------------------------------------------------------------------------------
							var trailer = giro.trailer;
							if(trailer['total_count'] != 'undefined')
								$('#total_count').html(trailer['total_count']);

							if(trailer['total_amount'] != 'undefined')
								$('#total_amount').html(trailer['total_amount']);

							$('#giro-trailer').show();

							//giro detail
							//--------------------------------------------------------------------------------------
							var details = giro.details;

							if(typeof details == 'object') {
								var detail_data = [];

								//save in localStorage for feature use
								localStorage.setItem('giroDetails', JSON.stringify(details));

								$.each(details, function(key, detail) {
									var inv = detail.invoice;

									detail_data.push({
										id                  : key,
										account_no          : inv.account_no,
										amount              : inv.amount,
										new_ic_no           : inv.new_ic_no,
										business_reg_no     : inv.business_reg_no,
										ref_no              : inv.ref_no,
										receiving_fi_id     : inv.receiving_fi_id,
										beneficiary_name    : inv.beneficiary_name,
										details             : '<a class="invoice-detail" target="_blank" href="'+inv.url+'">Details</a>'
									});
								});


								///show before sending data
								$('#giro-detail').show();

								var table = $('#giro-detail').dataTable({
									"data": detail_data,
									"columns": [
										{ "data": "id", className: "text-center"},
										{ "data": "account_no" , className: "text-center"},
										{ "data": "amount", className: "text-right"},
										{ "data": "new_ic_no", className: "text-center"},
										{ "data": "business_reg_no", className: "text-center"},
										{ "data": "ref_no", className: "text-center"},
										{ "data": "receiving_fi_id", className: "text-center"},
										{ "data": "beneficiary_name", className: "text-left"},
										{ "data": "details", className: "text-center"}
									],
									"scrollX": true,
									"columnDefs": [
										{"targets": [0], "width": "15px"}, //No
										{"targets": [1], "width": "100px"}, // Account no
										{"targets": [2], "width": "100px"}, // Amount
										{"targets": [3], "width": "100px"}, // New IC No
										{"targets": [4], "width": "100px"}, // Buisness Reg
										{"targets": [5], "width": "100px"}, // Ref No
										{"targets": [6], "width": "80px"}, // R.FIID
										{"targets": [7], "width": "200px"}, //Name
										{"targets": [8], "width": "30px"}, //Invoices
									],
									destroy: true
								});

								//open popup
								$('.invoice-detail').on('click', function(e)
								{
									e.preventDefault();
									window.open($(this).prop('href'));
								});
							};
						}else{
							toastr.error(response.message);
							$('#giro-header').hide();
							$('#giro-trailer').hide();
						}
					},
					error: function(jqXHR, textStatus, errorMessage){
						toastr.error('An Internal server error occurred');
					},
					cache: false,
					contentType: false,
					processData: false
				});				
			}
			
			$('#giroFile').on('change', function(e)
            {
                var form = $("#giroUploadForm");
                var uploadButtonLabel = $("#giroFileLabel");
                var url = form.attr('action');

                var file = $(this).val();
                var filename = file.split("\\");

                filename = filename[filename.length-1];

                if(filename.length < 5){
                    toastr.error('Please select a file');
                }else if(filename.substr(-4,4) != '.txt'){
                    toastr.error('Please select a valid text file');
                }else{
                    var fd = new FormData();
                    fd.append('giro', $(this)[0].files[0]);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: fd,
                        success:function(response)
                        {
                            if(response.status)
                            {
                                toastr.info('File uploaded successfully');
                                uploadButtonLabel.html('Currently displayed: ' +filename);

                                var giro = response.data;

                                //giro header
                                //--------------------------------------------------------------------------------------
                                var header = giro.header;
                                var headers = ['company_name', 'company_ac_no', 'company_cif', 'branch',
                                    'crediting_debiting_date', 'customer_ref_no'
                                ];

                                for(var i=0; i < headers.length; i++)
                                {
                                    $('#'+headers[i]).html(header[headers[i]]);
                                }

                                $('#giro-header').show();

                                //giro trailer
                                //--------------------------------------------------------------------------------------
                                var trailer = giro.trailer;
                                if(trailer['total_count'] != 'undefined') $('#total_count').html(trailer['total_count']);
                                if(trailer['total_amount'] != 'undefined') $('#total_amount').html(trailer['total_amount']);
                                $('#giro-trailer').show();

                                //giro detail
                                //--------------------------------------------------------------------------------------
                                var details = giro.details;

                                if(typeof details == 'object')
                                {
                                    var detail_data = [];

                                    //save in localStorage for feature use
                                    localStorage.setItem('giroDetails', JSON.stringify(details));

                                    $.each(details, function(key, detail)
                                    {
                                        var inv = detail.invoice;

                                        detail_data.push({
                                            id                  : key,
                                            account_no          : inv.account_no,
                                            amount              : inv.amount,
                                            new_ic_no           : inv.new_ic_no,
                                            business_reg_no     : inv.business_reg_no,
                                            ref_no              : inv.ref_no,
                                            receiving_fi_id     : inv.receiving_fi_id,
                                            beneficiary_name    : inv.beneficiary_name,
                                            details             : '<a class="invoice-detail" target="_blank" href="'+inv.url+'">Details</a>'
                                        });
                                    });


                                    ///show before sending data
                                    $('#giro-detail').show();

                                    var table = $('#giro-detail').dataTable({
                                        "data": detail_data,
                                        "columns": [
                                            { "data": "id", className: "text-center"},
                                            { "data": "account_no" , className: "text-center"},
                                            { "data": "amount", className: "text-right"},
                                            { "data": "new_ic_no", className: "text-center"},
                                            { "data": "business_reg_no", className: "text-center"},
                                            { "data": "ref_no", className: "text-center"},
                                            { "data": "receiving_fi_id", className: "text-center"},
                                            { "data": "beneficiary_name", className: "text-left"},
                                            { "data": "details", className: "text-center"}
                                        ],
                                        "scrollX": true,
                                        "columnDefs": [
                                            {"targets": [0], "width": "15px"}, //No
                                            {"targets": [1], "width": "100px"}, // Account no
                                            {"targets": [2], "width": "100px"}, // Amount
                                            {"targets": [3], "width": "100px"}, // New IC No
                                            {"targets": [4], "width": "100px"}, // Buisness Reg
                                            {"targets": [5], "width": "100px"}, // Ref No
                                            {"targets": [6], "width": "80px"}, // R.FIID
                                            {"targets": [7], "width": "200px"}, //Name
                                            {"targets": [8], "width": "30px"}, //Invoices
                                        ],
                                        destroy: true
                                    });

                                    //open popup
                                    $('.invoice-detail').on('click', function(e)
                                    {
                                        e.preventDefault();
                                        window.open($(this).prop('href'));
                                    });
                                };
                            }else{
                                toastr.error(response.message);
                                $('#giro-header').hide();
                                $('#giro-trailer').hide();
                            }
                        },
                        error: function(jqXHR, textStatus, errorMessage){
                            toastr.error('An Internal server error occurred');
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }

                e.preventDefault();
            });
        });
    </script>
@stop
