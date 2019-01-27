
<?php
$date = date("Y-m-d"); ?>
<?php  $dateytd = date("Y") . "-01-01"; ?>
<?php  $datemtd = date("Y-m") . "-01"; ?>

<?php $date1 = date("Y-m-d");
$datewtd =  date('Y-m-d', strtotime('-1 week', strtotime($date1))); ?>
<?php  $datedaily = $datedaily = date("Y-m-d"); ?>
<?php  $datehourly = date('Y-m-d H:i:s', strtotime('-1 hour')); ?>
<style>
    .dataTables_filter input {
        width:300px;
    }

</style>
<!--link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"> -->

<link rel="stylesheet" href="{{asset('/css/style.css')}}"/>

<!-- Bootstrap -->
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/bootstrapValidator.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/jqgrid/ui.jqgrid.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/buttons.dataTables.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/datatable.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">
<script type="text/javascript" src="{{asset('js/html2pdf.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jspdf.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/pdfmake.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/pdfmake-master/build/buttons.html5.min.js')}}"></script>


<div style="padding-left:0;padding-right:0" class="container-fluid" id="stock_level">
    <div style="margin-left:0;margin-right:0;padding-left:0;padding-right:0"
         class="row col-md-12" >
        <div class="col-md-12" style="padding-left:0;padding-right:0">
			<div class="col-md-6" style="padding-left:0">
				<h3 class="modal-title"
					style="margin-bottom:10px;margin-top:15px"
					id="myModalLabel">
					Stock Level Details</h3>
			</div>

			<div id="mybutt" class="col-md-6 text-right"
				style="padding-right:0">
			</div> 
        </div>

        <div class="col-md-12" style="padding-left:0;padding-right:0;">
            <div class="row" style="margin-left:0;margin-right:0">
                <div class="col-md-12"
				style="padding-left:0;padding-right:0;margin-bottom:5px;
				display:flex;align-items:center">
                    <div class="col-md-6"
                         style="padding-left:0">
                        <input href="javascript:void(0)"
						   class="form-control "
						   style="width:200px;"
						   value="<?php echo date("d-M-Y", strtotime($datedaily)); ?>"
						   id="datepicker" placeholder="Select Date"
						   rel-type="daily"/>
                    </div>

                </div>
            </div>
        </div>

        <!-- </div> -->
    </div>
    <div style="padding:0" class="col-md-12">
        <div id="skumodalbody" style="padding:0;
			margin-left: 0 !important;
			margin-right: 0 !important;"
             class="modal-body"></div>
    </div>

</div>


<script type="text/javascript">

    $(function(){
        $('#datepicker').datepicker({
            maxDate: 0,
            dateFormat: 'dd-M-yy',
            onSelect: function (dateText, inst) {
                fetch_products_for_today(dateText);
            }
        });
    });

    $( document ).ready(function() {
        fetch_products_code();
    });

    function fetch_products_for_today(date){
        $.ajax({
            type: "POST",
            url: "{{URL('/stocklevel_today')}}",
            data: {"date" : date},
            success: function( listproducts ) {
                //   console.log(listproducts);
                setskudatatable(listproducts);
            }
        });
    }

    function fetch_products_code(message = null,TimeFilter = null) {
        var id = $(this).attr("merchantrel");
        var filter = $(this).attr("rel");

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
        var today = $('#datepicker').val();
        console.log(today);
        if (message) {
            alert(message);
            return;
        }

        $.ajax({
            type: "GET",
            url: "{{URL('/stocklevel_since')}}",
            data: {
                fromDate: fromDate,
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
                TimeFilter:TimeFilter,
                today:today

            },
            success: function( listproducts ) {
                setskudatatable(listproducts);
                //  console.log(listproducts);
            }
        });
    }


    function setskudatatable(listproducts) {
        jQuery(this).removeData();
        var skutablerow = `
			<table style="width: 100%;" id="skutbl"
			class="table skutable">
		<thead class="bg-inventory">
			<tr>
			<th class="text-left" scope="col"
				style="background-color:#0F71BA;color:#fff">Product</th>
			<th class="text-center" scope="col"
				style="background-color:#0F71BA;color:#fff">Product ID</th>
				<th class="text-center" scope="col"
				style="background-color:#0F71BA;color:#fff">Product Name</th>
			<th class="text-right" scope="col"
				style="background-color:#0F71BA;color:#fff">Quantity</th>
			</tr>
		</thead>
		<tbody id="skutable-body">
		`;

        if (listproducts == 0) {

        } else {
            //    console.log(listproducts );
            var i = 0;
            var k = 0;
            jQuery.each(listproducts, function (key, listproducts) {
                //            if(listproducts.quantity > 0){


                //bar1 = listproducts.quantity;
                //  if(key == 0){

                //  }
                //   if(i == 0 ) {
                k = listproducts.max;
                console.log("k=" + k);
                bar = 89;

                //  } else {
                bar2 = parseInt(listproducts.quantity);
                bar = 89 / k * bar2;
//

                i++;

                if (listproducts.image == '') {
                    skutablerow += `<tr>
					<td class="text-left">
					<img style="object-fit:cover;" width="30"  height="30"
						src="{{url()}}/placecards/dummy.jpg">
						<div class="progress1" style="margin: -3% 0% 1% 5%;">
						<div class="progress-bar" role="progress1"
							aria-valuenow="70" aria-valuemin="0"
							aria-valuemax="50" style="width:` + bar + `%;
						/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b4ddb4+0,83c783+17,52b152+33,008a00+67,005700+83,002400+100;Green+3D+%231 */
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
						</div><span style="color:red;" class="hide_total">
						&nbsp;  ` + listproducts.total + `
						</div><span style="padding-left:5%"> ` + listproducts.name + `</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td></td>
							<td>` + listproducts.npid + `</td>
								<td>` + listproducts.name + `</td>
					<td>` + listproducts.total + `</td>

					</tr>
					`;

                } else {
                    skutablerow += `<tr>
					<td class="text-left"><img style="object-fit:cover;"
						width="30"  height="30"
						src="{{url()}}/images/product/` + listproducts.id +
                            `/thumb/` + listproducts.thumb_photo + `">
					<div class="progress1" style="margin: -3% 0% 1% 5%;">
					<div class="progress-bar" role="progress1"
						aria-valuenow="70" aria-valuemin="0" aria-valuemax="50"
						style="width:` + bar + `%;
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
					</div><span style="color:red;" class="hide_total">
					&nbsp;  ` + listproducts.total + `
					</div><span style="padding-left:5%"> ` + listproducts.name + `</span>
					</td>
					<td>` + listproducts.npid + `</td>
					<td>` + listproducts.name + `</td>
					<td>` + listproducts.total + `</td>
					</tr>
					`;
                }
                //    }
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
				filename: "Stock Level Details",
				customize: function(doc) {
					doc['content'][0] = [{
						text: "Stock Level Details",
						style: "nheader"
					}, {
						text: $('#datepicker').val(),
						style: "header"
					}];  
					doc['styles']['nheader'] = {
						fontSize:18, bold:true, alignment:"left"
					};

                    var tbody = doc['content'][1].table.body;
                    tbody.forEach(function(val, idx, ary) {
                        tbody[idx][2].alignment = 'right';
                    });


					/*
 					// Need to iterate the table body to trim the CRUD
					// in the beginning
					var tbody = doc['content'][1]['table']['body'];

					// First record: tbody[0]
					// First column: tbody[0]0]
					// First column's product name: tbody[0][0]['text']
					 tbody.forEach(function(val, idx, ary) {
					 	var raw = tbody[idx][0]['text'];
						var res = raw.replace(/^\s+ \d+\s+/g, "");
					 	tbody[idx][0]['text'] = res;
					 }); 
					console.log(doc);
					*/
				},
            }],
            "aaSorting": [[3, 'desc']],
            "columnDefs": [
                {"visible": false, "targets": 1},
                {"visible": false, "targets": 2},
                {"visible": false, "targets": 3},
            ],
            language: {
                searchPlaceholder: "Product Name, Product ID, Barcodes, SKU"
            },
			initComplete: function(settings, json) {
				/* Move [Download] button to its final resting place */
				$('#mybutt').empty();
				$('#mybutt').append($('.dt-buttons').children());
				$('.dt-button').attr('style','width:70px;height:70px;border-radius:5px;padding-left:7px;background:skyblue;border-color:skyblue;color:white;margin-right:0;top:35px');
			}
        });
        $("#skumodalbody").css({"margin-left": "0"});
        $("#skumodalbody").css({"margin-right": "0"});

        /* Finish */
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
    .table1 > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        /*border-top: 1px solid #ddd;*/
    }
</style>
