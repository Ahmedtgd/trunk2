<?php  $date = date("Y-m-d"); ?>
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

<!-- Bootstrap -->
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/bootstrapValidator.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/jqgrid/ui.jqgrid.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/datatable.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">
<script type="text/javascript" src="{{asset('js/html2pdf.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jspdf.js')}}"></script>
<script type="text/javascript" src="{{asset('js/Chart.bundle.min.js')}}"></script>

<div style="padding-left:0;padding-right:0" class="container-fluid" id="stockout">
    <div style="margin-left:0;margin-right:0;padding-left:0;padding-right:0"
         class="row col-md-12" >
        <div class="col-md-12" style="padding-left:0;padding-right:0">
            <h3 class="modal-title"
                style="margin-bottom:10px;margin-top:15px"
                id="myModalLabel">
                Total Stock Out Values</h3>
        </div>
        <div class="col-md-12" style="padding-left:0;padding-right:0;">

            <div class="row" style="margin-left:0;margin-right:0">
                <div class="col-md-12"
                     style="padding-left:0;padding-right:0;margin-bottom:10px;
					display:flex;align-items:center">
                    <div class="col-md-12"
                         style="padding-left:0">
                        <input href="javascript:void(0)"
                               class="form-control "
                               style="width:200px;display:inline"
                               id="datepicker1" placeholder="Select Start Date"
							   value="<?php echo date("d-M-Y", strtotime($datedaily)); ?>"
                               rel-type="daily"/>&nbsp;To&nbsp;
                        <input href="javascript:void(0)"
                               class="form-control "
                               style="width:200px;display:inline"
                               id="datepicker2" placeholder="Select End Date"
							   value="<?php echo date("d-M-Y", strtotime($datedaily)); ?>"
                               rel-type="daily"/>
                        <select id="modeselect" onchange="send_data_today()"
                                style="display:inline;width:200px;
							height:35px!important;margin-left:3px;
							padding-top:8px;padding-bottom:8px;
							padding-left:10px;padding-right:10px;
							color:#a0a0a0;background-color:white;
							border-color:#c0c0c0;border-radius:5px;
							font-size:13px;margin-left:5px;
							position:relative;top:-2px;
							border-width:1px;vertical-align:middle"
                                placeholder="Select Mode">
                            <option value="" disabled>Select Mode</option>
                            <option value="normal" selected>Normal</option>
                            <option value="error">Error Adjustment</option>
                        </select>
                    </div>


                    <div class="col-md-6"
					style="position:relative;top:-30px;padding-right:0">
 					<button style="padding-top:0;background-color:skyblue;
						float:right;font-size:13px;width:70px;height:70px;
						margin-bottom:5px;color: white; border:0;
						margin-right:0;border-radius:5px;padding-left:7px"
						id="downloadbtn" type="button"
						onclick="genPDF()">Download
                    </button> 

 					<button style="padding-top:3px;background-color:skyblue;
						float:right;font-size:13px;width:70px;height:70px;
						margin-bottom:5px;color: white; border:0;
						padding-left:5px;border-radius:5px;margin-right:5px"
						id="downloadbtn" type="button"
						onclick="open_new_tab()">Stock&nbsp;Out<br>Details
                    </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="stocks" class="container-fluid" style="width: 1000px; height: 100%;">
		<span id="st_title" style=" float: left; display:none; font-weight: bolder; font-size: 20px;"><b>Total Stock Out Value</b></span> <span id="st_date" style="float: right;
			margin-right: 55px;display: none; font-weight: bolder;" ></span>
    <canvas id="stockout_line_graph" width="1000" height="400" style="margin-left: -25px;">


	</canvas>
    </div>
</div>
<br><br>


<script type="text/javascript">

	function open_new_tab(){
		var win = window.open('{{url('/merchant/stockoutdetails')}}', '_blank');
		if (win) {
			//Browser has allowed it to be opened
			win.focus();
		} else {
			//Browser has blocked it
			alert('Please allow popups for this website');
		}
	}
    function genPDF(){
		var from = $('#datepicker1').val();
		var to = $('#datepicker2').val();
		var mode = $('#modeselect').val();
		var text = from + " to " + to +" ("+mode+")";
        var elements = document.getElementById('stocks');
		$('#st_date').html(text);
		$( "#st_date" ).css({"display":"block","font-weight":"bolder"});
		$( "#st_title" ).css({"display":"block","font-weight":"bolder"});

        html2pdf(elements, {
            margin: 1,
            filename: 'Stock Details',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: {scale: 4,logging: true },
            jsPDF: { unit: 'in', format: 'a3', orientation: 'l' }
        });
		$( "#st_date" ).css({"display":"none"});
		$( "#st_title" ).css({"display":"none"});
    }

    $(function(){

        $('#datepicker1').datepicker({
            maxDate: 0,
            dateFormat: 'dd-M-yy',
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
				$("#datepicker2").datepicker("option", "minDate", dtFormatted);
				send_data_today();

			}

        });
    });
    $(function(){
		var date = $('#datepicker1').val();
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
		dd = dd - 1;
		var M = dtMax.getMonth();
		var m = month[M];
		var y = dtMax.getFullYear();
		var dtFormatted = dd + '-'+ m + '-'+ y;
        $('#datepicker2').datepicker({
            dateFormat: 'dd-M-yy',
            maxDate: 0,
			minDate:dtFormatted,
            onSelect: function (dateText, inst) {

				send_data_today();
            }
        });
    });

    function send_data() {
		//console.log("We Called the function");
		$.ajax({
			type: "GET",
			url: "{{URL('merchant/stockout')}}",
			success: function (data) {

				if (data == 0) {
					toastr.warning("No Data Available");
				} else {
				   // console.log("This is data "+ data);
				  construct_graph(data);
				}

			}
		});
    }


    function send_data_today() {
        console.log("We got here first");
        var start_date = $('#datepicker1').val();
        var end_date = $('#datepicker2').val();
        var mode = $('#modeselect').val();

		if ((mode.length > 0) && (start_date.length > 0) &&
			end_date.length > 0) {
         //   console.log("We Called the function");
            $.ajax({
                type: "POST",
                url: "{{URL('merchant/stockouttoday')}}",
				data: {"start_date": start_date, "end_date": end_date,
					"mode": mode},

                success: function (data) {
                    if (data == 0) {
                        toastr.warning("Start Date should not be Greater than end Date");
                    } else {
                      //  console.log("This is data "+ data);
                        construct_graph(data);
                    }

                }
            });
        } else {
            toastr.warning("All Parameters must be Supplied")
        }
    }


	$( document ).ready(function() {
		$('#modeselect').select2('destroy');
		send_data();
	});



    function construct_graph(data){
		var container = document.getElementById('stocks');
		var oldInstance = document.getElementById('stockout_line_graph');
		container.removeChild(oldInstance);
		var newInstance = document.createElement("canvas");
		newInstance.setAttribute("id", "stockout_line_graph");
		container.appendChild(newInstance);
        var dates = [];
        for (var i=0; i < data.length; i++) {
            dates.push({'x': data[i].date, 'y': data[i].quantity});
        }

       // console.log(dates);
        var get_promise = new Promise(
			function (resolve, reject) {
				if (data) {
					resolve(dates); // fulfilled

				} else {
					var reason = new Error('Data Failed to fetch');
					reject(reason); // reject
				}

			}
        );


        // call our promise
        var get_data = function () {
            get_promise
			.then(function (dates) {


				var ctx = document.getElementById("stockout_line_graph").getContext('2d');

				var stockout_line_graph = new Chart(ctx, {
					type: 'line',
					data: {
						datasets: [{
							label: 'Total Stock Out Value',
							backgroundColor: "#e17577",
							borderColor: "#b14547",
							borderWidth: 2,
							data: dates,
							fill: true,
						}]
					},
					options: {
						responsive: true,
						title: {
							display: true,
							text: 'Stock Out Details Line Chart'

						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								type: 'time',
								time: {
									unit: 'day',
								},
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Date'
								},
								//ticks: { beginAtZero: true }
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Total Stock Out Value (MYR)'
								},
								ticks: { beginAtZero: true }
							}]
						}
					}
				});
			})
			.catch(function (error) {
			   //oops, no data
				console.log(error.message);

			});
        };

        get_data();

    }
</script> 

