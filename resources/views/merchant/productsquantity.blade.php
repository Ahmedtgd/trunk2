

<?php  $date = date("Y-m-d"); ?>
<?php  $dateytd = date("Y") . "-01-01"; ?>
<?php  $datemtd = date("Y-m") . "-01"; ?>

<?php $date1 = date("Y-m-d");
$datewtd =  date('Y-m-d', strtotime('-1 week', strtotime($date1))); ?>
<?php  $datedaily  = date("Y-m-d"); ?>
<?php  $datehourly = date('Y-m-d H:i:s', strtotime('-1 hour')); ?>
<style>
    .dataTables_filter input {
        width:300px;
    }

</style>
<!-- Bootstrap -->
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/bootstrapValidator.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/jqgrid/ui.jqgrid.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/datatable.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('/css/toastr.css')}}"/>


<script src="{{asset('/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>

<!-- Include all compiled plugins (below),
	 or include individual files as needed -->
<script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrapValidator.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
<script type="text/javascript" src="{{asset('js/html2pdf.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/pdfmake.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/buttons.html5.min.js')}}"></script>
<div class="container " >
    <div class="row col-md-12"
         style="margin-left:0;margin-right:0;padding-left:0;padding-right:0"
         id="product_sales">

        <div class="col-md-12" style="padding:0" >
            <div class="col-md-12" style="padding-top:20px">
                <div class="row">
                    <div style="padding-left:0"  class="col-md-12">
                        <h2 class="modal-title"
                            style="margin-bottom:0"
                            id="myModalLabel">
                            Product Sales by Quantity</h2>
                    </div>
                </div>
            </div>

            <div class="row" style="">
                <div class="col-md-6" style="B;vertical-align:middle;display:inline">
                    <a href="#"class="btn btn-info since_ytd sellerbutton1"
                       onclick="fetch_products_code(null,'Since');"
                       style="margin-top:20px;padding-top:6px !important"
                       id="graph-merchant-since"
                       from="<?php echo $since; ?>"
                       to="<?php echo date("d-M-Y", strtotime($date)); ?>"
                       rel-type="since">Since</a>

                    <a href="javascript:void(0)"
                       class="btn btn-info ytd_btn sellerbutton1"
                       style="margin-top:20px;padding-top:6px !important"
                       onclick="fetch_products_code(null,'YTD')"
                       id="graph-merchant-ytd"
                       rel-type="ytd">YTD</a>

                    <a href="javascript:void(0)"
                       class="btn btn-info mtd_btn sellerbutton1"
                       style="margin-top:20px;padding-top:6px !important"
                       onclick="fetch_products_code(null,'MTD')"
                       id="graph-merchant-mtd"
                       rel-type="mtd">MTD</a>

                    <a href="javascript:void(0)"
                       class="btn btn-info wtd_btn sellerbutton1"
                       style="margin-top:20px;padding-top:6px !important"
                       onclick="fetch_products_code(null,'WTD')"
                       id="graph-merchant-wtd"
                       from="<?php echo date("d-M-Y", strtotime($datewtd)); ?>"
                       to="<?php echo date("d-M-Y", strtotime($date)); ?>"
                       rel-type="wtd">WTD</a>
                </div>

                <div class="col-md-6"
                     style="C:display:inline;padding-left:0;margin-bottom:0">
                    <div class="col-md-3"
                         style="right:190px;display:inline;padding-left:0;
							 margin-bottom:20px;padding-right:0">
                        <input
						class="form-control"
						style="display:inline;margin-top:21px;
							padding-top:6px !important;width:110px"
						value="<?php echo
							date("d-M-Y", strtotime($datedaily)); ?>"
						id="datepicker" placeholder="From"/>&nbsp;&nbsp;&nbsp;To
                    </div>

                    <div class="col-md-3"
                         style="right:180px;display:inline;padding-left:0;
							margin-bottom:20px">
                        <input
						class="form-control"
						style="margin-top:21px;padding-top:6px !important;
							width:110px"
						value="<?php echo
							date("d-M-Y", strtotime($datedaily)); ?>"
						id="datepick" placeholder="To"/>
                    </div>

                    <div id="mybutt" class="col-md-2 text-right pull-right"
                         style="padding:0;">
                    </div>
                </div>

                <!-- B -->
            </div>

            <!-- A -->
        </div>

        <div class="col-md-12" style="padding-left:0;padding-right:0">
            <div id="skumodalbody"
                 style="padding:0"
                 class="modal-body"></div>
        </div>

    </div>


    <script type="text/javascript">


        $(function(){
            $('#datepicker').datepicker({
                dateFormat: 'dd-M-yy',
                maxDate: 0,
                onSelect: function (selected) {
                    var month = new Array();
                    month[0] = "Jan";
                    month[1] = "Feb";
                    month[2] = "Mar";
                    month[3] = "Apr";
                    month[4] = "May";
                    month[5] = "Jun";
                    month[6] = "Jul";
                    month[7] = "Aug";
                    month[8] = "Sep";
                    month[9] = "Oct";
                    month[10] = "Nov";
                    month[11] = "Dec";
                    var dtMax = new Date(selected);
                    dtMax.setDate(dtMax.getDate());
                    var dd = dtMax.getDate();
                    var M = dtMax.getMonth();
                    var m = month[M];
                    var y = dtMax.getFullYear();
                    var dtFormatted = dd + '-'+ m + '-'+ y;
                    console.log(dtFormatted );
                    $("#datepick").datepicker("option", "minDate", dtFormatted);
                    var to =  $("#datepick").val();
                    fetch_products_for_today(to);
                }

            });
        });
        $(function(){
            var date = $('#datepicker').val();
            var month = new Array();
            month[0] = "Jan";
            month[1] = "Feb";
            month[2] = "Mar";
            month[3] = "Apr";
            month[4] = "May";
            month[5] = "Jun";
            month[6] = "Jul";
            month[7] = "Aug";
            month[8] = "Sep";
            month[9] = "Oct";
            month[10] = "Nov";
            month[11] = "Dec";
            var dtMax = new Date(date);
            dtMax.setDate(dtMax.getDate());
            var dd = dtMax.getDate();
            var M = dtMax.getMonth();
            var m = month[M];
            var y = dtMax.getFullYear();
            var dtFormatted = dd + '-'+ m + '-'+ y;
            $('#datepick').datepicker({

                dateFormat: 'dd-M-yy',
                maxDate:0,
                minDate: dtFormatted,
                onSelect: function (dateText, inst) {
                    fetch_products_for_today(dateText);
                }
            });
        });
        $( document ).ready(function() {
            // event.preventDefault();
            fetch_products_code();

        });


        function fetch_products_code(message = null,TimeFilter = null) {
            var id = $(this).attr("merchantrel");
            var filter = $(this).attr("rel");
           //        $('#datepick').val("Select Date");
            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var country = $('.country-merchant-field').val();
            var state = $('.state-merchant-field').val();
            var city = $('.city-merchant-field').val();
            var marea = $('.area-merchant-field').val();
            var product = $('.product-merchant-field').val();
            var brand = $('.brand-merchant-field').val();
            var category = $('.category-merchant-field').val();
            var subcategory = $('.subcategory-merchant-field').val();
            var consumer = $('.consumer-merchant-field').val();
            var channel = $('.channel-merchant-field').val();

            if (TimeFilter) {
                $('#datepick').val("Select Date");
                $('#datepicker').val("Select Date");
                //return;
            }

            $.ajax({
                type: "GET",
                url: "{{URL('merchant/productqty_since')}}",
                data: {
                    fromDate: fromDate,
                    toDate: toDate,
                    toDate: toDate,
                    country:country,
                    state:state,
                    city:city,
                    marea:marea,
                    product:product,
                    brand:brand,
                    category:category,
                    subcategory:subcategory,
                    consumer:consumer,
                    channel: channel,
                    TimeFilter:TimeFilter
                },
                success: function( listproducts ) {
                    console.log(listproducts);
                    setskudatatable(listproducts);
                }
            });
        }


        function setskudatatable(listproducts) {
            jQuery(this).removeData();
            var skutablerow =`
			<table style="width: 100%;" id="skutbl"
			class="table skutable">
		<thead class="bg-inventory">
			<tr>
			<th class="text-left" scope="col"
				style="background-color:#0F71BA;color:#fff">Quantity</th>
			<th class="text-center" scope="col"
				style="background-color:#0F71BA;color:#fff">Product ID</th>
			<th class="text-right" scope="col"
				style="background-color:#0F71BA;color:#fff">Name</th>
			<th class="text-right" scope="col"
				style="background-color:#0F71BA;color:#fff">Quantity</th>
			</tr>
		</thead>
		<tbody id="skutable-body">
		`;

            if(listproducts == 0){

            } else {

                var i = 0;
                var k = parseInt(listproducts['0'].max);

                jQuery.each( listproducts, function( key, listproducts ) {
                    //  if(i == 0 ) {
                    if(listproducts.qtyall == 0){
                        bar = 0;
                    }else{
                        bar = 80;
                    }


                    //   } else {
                    bar2 = parseInt(listproducts.sales_quantity);
                    bar = 80/k*bar2;
                    //  }

                    i++;
                    console.log(bar);
                    //	console.log(listproducts.proId);

                    if(listproducts.image == '') {
                        skutablerow+= `<tr>
					<td class="text-left">
					<img style="object-fit:cover;" width="30"  height="30"
						src="{{url()}}/placecards/dummy.jpg">
						<div class="progress1" style="margin: -3% 0% 1% 5%;">
						<div class="progress-bar" role="progress1"
							aria-valuenow="70" aria-valuemin="0"
							aria-valuemax="50" style="width:`+bar+`%;
							background: #b4ddb4; /* Old browsers */
							background: -moz-linear-gradient(-45deg,#b4ddb4 0%,
								#83c783 17%, #52b152 33%, #008a00 67%,
								##005700 83%, #002400 100%); /* FF3.6-15 */
							background: -webkit-linear-gradient(-45deg,
								#b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,
								##005700 83%,#002400 100%); /* Chrome10-25,Safari5.1-6 */
							background: linear-gradient(135deg, #b4ddb4 0%,
								#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,
								##002400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
							filter: progid:DXImageTransform.Microsoft.gradient(
								startColorstr='#b4ddb4', endColorstr='#002400',
								GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
						</div><span style="color:red;">
						&nbsp;  `+listproducts.quantity+`
						</div><span style="padding-left:5%"> `+listproducts.name+`</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td></td>
						<td>`+listproducts.proId+`</td>
						<td>`+listproducts.name+`</td>
						<td style="text-align:right">`+listproducts.quantity+`</td>
					</tr>
					`;

                    } else {
                        skutablerow+= `<tr>
					<td class="text-left">
					<div>
						<img style="object-fit:cover;"
						width="30"  height="30"
						src="{{url()}}/images/product/`+listproducts.proId+
                                `/thumb/`+listproducts.image+`">
					</div>

					<div>
						<div class="progress1" style="margin: -3% 0% 1% 5%;">
						<div class="progress-bar" role="progress1"
							aria-valuenow="70" aria-valuemin="0" aria-valuemax="50"
							style="width:`+bar+`%;
						/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b4ddb4+0,83c783+17,52b152+33,008a00+67,005700+83,002400+100;Green+3D+%231 */
							background: #b4ddb4; /* Old browsers */
							background: -moz-linear-gradient(-45deg, #b4ddb4 0%,
								#83c783 17%, #52b152 33%, #008a00 67%, #005700 83%,
								##002400 100%); /* FF3.6-15 */
							background: -webkit-linear-gradient(-45deg, #b4ddb4 0%,
								#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,
								##002400 100%); /* Chrome10-25,Safari5.1-6 */
							background: linear-gradient(135deg, #b4ddb4 0%,
								#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
							filter: progid:DXImageTransform.Microsoft.gradient(
								startColorstr='#b4ddb4', endColorstr='#002400',
								GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
						</div><span style="color:red;">
						&nbsp; `+listproducts.quantity+`
						</div><span style="padding-left:5%"> `+listproducts.name+`</span>
					</div>
					</td>
					<td>`+listproducts.npid+`</td>
					<td>`+listproducts.name+`</td>
					<td>`+listproducts.quantity+`</td>
					</tr>
					`;
                    }
                });
            }

            skutablerow += ` </tbody>
		</table>`;
            $('#skumodalbody').html(skutablerow);
            $('#skutbl').DataTable({
                dom: 'Blfrtip',		// We want length too!!!
                buttons: [{
                    extend: 'pdfHtml5',
                    text: 'Download',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [1,2,3]
                    },
                    filename: "Product Sales by Quantity",
                    customize: function(doc) {
                        console.log(doc);

                        /* Report Text header */
                        doc['content'][0] = [
                            {text: listproducts[0].date,fontSize: 15, bold: true,alignment:'right'},
                            {text: "Product Sales Bt Quantity",
                                style: "nheader"
                            }];

                        doc['content'][2] = [{
                            text: ["Product Sales by Quantity           ",
                                {text: $('#datepicker').val()+'  to  '+
                                $('#datepick').val(), fontSize:12}],
                            style: "nheader"
                        }];


                        doc['styles']['nheader'] = {
                            fontSize:18, bold:true, alignment:"left"
                        };

                        /* Define column widths */
                        doc.content[1].table.widths = [150, '*', 70]

                        /* Sales column right aligned */
                        var tbody = doc['content'][1].table.body;
                        tbody.forEach(function(val, idx, ary) {
                            tbody[idx][2].alignment = 'center';
                        });

                        /* Datatable Header, "Sales" Qty */
						doc['content'][1].table.body[0][2].text = 'Qty  ';
						doc['content'][1].table.body[0][2].alignment = 'center';

						doc['footer'] = "";
                    }
                }],
                "aaSorting": [[ 3, 'desc' ]],
                "columnDefs": [
                    { "visible": false, "targets": 1 },
                    { "visible": false, "targets": 2 },
                    { "visible": false, "targets": 3 },


                ],
                language: {
                    searchPlaceholder: "Product Name, Product ID"
                },
                initComplete: function(settings, json) {
                    /* Move [Download] button to its final resting place */
                    $('#mybutt').empty();
                    $('#mybutt').append($('.dt-buttons').children());
                    $('.dt-button').attr('style','width:70px;height:70px;border-radius:5px;padding-left:4px;background:skyblue;border-color:skyblue;color:white;margin-right:0;border-width:0');
                }
            });

            /*Finish*/
        }

        function fetch_products_for_today(date){
            var from = $('#datepicker').val();
            if ((from.length < 1) || (from == "Select Date")) {
                toastr.warning("You need to select a from date first");

            }else{
                $.ajax({
                    type: "POST",
                    url: "{{URL('merchant/productqty_today')}}",
                    data: {"date": date, "from": from},
                    success: function (listproducts) {
                        if (listproducts == 5) {
                            toastr.warning("Start Date should not be Greater than end Date");
                        } else {
                            setskudatatable(listproducts);
                        }
                    }
                });
            }
        }

    </script>

    <style type="text/css">
        .sellerbutton1 {
            width: 90px;
            height: 35px;
            padding-top: 8px !important;
            text-align: center !important;
            vertical-align: middle !important;
            float: left;
            font-size: 13px !important;
            cursor: pointer !important;
            margin-right: 5px !important;
            margin-bottom: 20px !important;
            border-radius: 5px !important;
        }
        .sellerbutton2 {
            width: 70px !important;
            height: 70px !important;
            padding-top: 16px !important;
            text-align: center;
            vertical-align: middle;
            float: left;
            font-size: 13px !important;
            cursor: pointer;
            margin-right: 5px !important;
            margin-bottom: 5px !important;
            border-radius: 5px !important;
        }
        .progress1 {
            height: 20px;
            width:100%;
            margin-bottom: 20px;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .ui-datepicker{
            z-index: 9999 !important;
        }
        .table1 > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            /*border-top: 1px solid #ddd;*/
        }
    </style>
