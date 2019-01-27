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
    table#station_details_table
    {
        table-layout: auto;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
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
<?php $i = 1; ?>
<div class="overlay" style="display:none;">
    <p>Please Wait...</p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>

<div class="container" style="margin-top:30px; margin-bottom:30px;">
    @include('admin/panelHeading')

    <h2>Station Property Master</h2>
    <div class="tableData">
        <div class="table-responsive">
            <table class="table table-bordered" cellspacing="0" width="100%" id="station_details_table">
                <thead style="background-color:#4E2E28; color: #fff;">
                    <tr>
                        <th class="no-sort">No</th>
                        <th class="xlarge">Station&nbsp;ID</th>
                        <th class="xlarge">Station&nbsp;Name</th>
                        <th class="xlarge">Bussiness&nbsp;Owner</th>
                        <th class="xlarge">Station&nbsp;Outlets</th>
                    </tr>
                <thead>
                <tbody>

                    @foreach($property as $prolist)
                    <tr>
                        <td style="text-align: center;">
                            {{$i++}}
                        </td>
                        <td style="text-align: center;">
                           <?php
                              $station_id = str_pad($prolist->id, 10, '0', STR_PAD_LEFT);
                           ?>
                           <a href="{{route('stationPopup', ['id' =>$prolist->id])}}" class="update" data-id="{{ $prolist->id }}"> [{{$station_id}}] </a>
                        </td>

                        <td style="text-align: center;">
							{{ $prolist->company_name }}
                        </td>

                        <td style="text-align: center;">
                            {{ $prolist->first_name }} {{ $prolist->last_name }}
                        </td>

                        <td style="text-align: center;">
                            <a href="javascript:void(0)" id="outlet_{{$prolist->id}}" class="outlets" rel="{{$prolist->id}}">Outlets</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 90%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">
					<table id="table_outlets" class="table table-bordered" cellspacing="0" width="100%"></table>
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
<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>


<script>
$(document).ready(function () {
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
	
	var table_modal;

	$(".outlets").click(function () {

		$('#modal-Tittle2').html("");

		if(table_modal){
			table_modal.destroy();
			$('#table_outlets').empty();
		}

		_this = $(this);

		var station_id= _this.attr('rel');
		
		var url = '/admin/master/sproperty/'+ station_id;
		
		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);	
				$('#modal-Tittle2').append("Station ID: ["+pad(station_id,10) + "]");
				//console.log(data);
				$('#table_outlets').append('<thead style="background-color: #4E2E28; color: #fff;"><th class="text-center no-sort">No</th><th class="text-center">Country</th><th class="text-center">State</th><th class="text-center">City</th><th class="text-center">Area</th><th class="text-center">Shop&nbsp;Size</th><th class="text-center">Property&nbsp;Owner</th><th class="text-center">Contact</th><th class="text-center">Business&nbsp;Outlet</th><th class="text-center">Outlet&nbsp;Name</th><th class="text-center">Business&nbsp;Delivery</th></thead>');
				$('#table_outlets').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					$('#table_outlets').append('<tr><td class="text-center">'+(i+1)+'</td><td class="text-center">'+obj.country+'</td> <td class="text-center">'+obj.state+'</td><td class="text-center">'+ obj.city +'</td><td class="text-center">'+ obj.area +'</td><td class="text-center">'+ obj.shop_size+'</td><td class="text-center">'+ obj.prop_owner_first_name+' '+ obj.prop_owner_last_name +'</td><td class="text-center">'+ obj.biz_owner_contact+'</td><td class="text-center">'+ obj.outlet+'</td><td class="text-center">'+ obj.outlet_name+'</td><td class="text-center">'+ obj.delivery+'</td></tr>');
				}
				$('#table_outlets').append('</tbody>');

				table_modal = $('#table_outlets').DataTable({
					"order": [],
					"columnDefs": [
						{"targets": "no-sort", "orderable": false, "width": "20px"},
						{"targets": "large", "width": "180px"},
						{"targets": "medium", "width": "80px"},
						{"targets": "xlarge", "width": "300px"},
						{"targets": "blarge", "width": "190px"}
					],
					"fixedColumns": {
						"leftColumns": 2
					}
				});

				$("#myModal2").modal("show");					
			},
			error: function (error) {
				console.log(error);
			}

		});
	});		

    function format(tr) {

        var j = tr.attr('data-last');

        var table = '<table class="table child_table" cellspacing="0" width="100%">';
        table += '<thead>';
        table += '<tr><th>Id</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Sub Total</th></tr>';
        table += '</thead>';
        table += '<tbody>';

        for (i = 1; i <= j; i++) {
            var id = tr.attr('data-id-' + i);
            var name = tr.attr('data-name-' + i);
            var qty = tr.attr('data-qty-' + i);
            var price = tr.attr('data-price-' + i);
            var des = tr.attr('data-des-' + i);
            var total = tr.attr('data-total-' + i);
            table += '<tr><td>' + id + '</td><td>' + name + '</td><td>' + des + '</td><td>' + qty + '</td><td>' + price + '</td><td>' + total + '</td></tr>';
        }

        table += '</tbody>';
        table += '</table>';

        return table;
    }

    var table = $('#station_details_table').DataTable({
        "order": [],
        "scrollX": true,
        "columnDefs": [
            {"targets": "no-sort", "orderable": false},
            {"targets": "large", "width": "120px"},
            {"targets": "medium", "width": "80px"},
            {"targets": "xlarge", "width": "300px"},
            {"targets": "blarge", "width": "190px"}
        ],
        "fixedColumns": {
            "leftColumns": 2
        }
    });




    $('#shipping_details_table').DataTable();
    $('#lower_product_detail_table').DataTable();
    $('#payment_detail_products').DataTable();
    $('#voucher_payment_detail').DataTable();
    $('#open_wish_table').DataTable();
    $('#auto_link_table').DataTable();
    $('#auto_link_table_2').DataTable();


    var vtable = $('#voucher_detail_table').DataTable({
        "columnDefs": [{
                "targets": 0,
                "data": null,
                "className": 'details-control-2',
                "orderable": false,
                "defaultContent": ""
            }]
    });

    $('td.details-control-2').on('click', function () {
        console.log('clicked');
        var tr = $(this).closest('tr');
        var row = vtable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(tr)).show();
            tr.addClass('shown');
        }
    });


    $('#datetimepicker , #datetimepickerr').on('change', function () {
        var date1 = $('#datetimepicker').val();
        var date2 = $('#datetimepickerr').val();

        $('#dateSince').html(date1);

        $.ajax({
            url: '{{url(' / merchant / calc - sale')}}',
            data: {'date1': date1, 'date2': date2},
            headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
            error: function () {

            },
            success: function (response) {
                $('#amountSince').html(response.payment);
                $('#amountBetween').html(response.paymentSince);
            },
            type: 'POST'
        });
    });

   $(".mcrid").click(function () {
        _this = $(this);
        var id_station= _this.attr('rel');

        $('#modal-Tittle2').html("Remarks");

        var url = '/admin/master/station_remarks/'+ id_station;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th>No</th><th>Station ID</th><th>Status</th><th>Admin User ID</th><th>Remarks</th><th>DateTime</th></tr>";
                for (i=0; i < data.length; i++) {
                    var obj = data[i];
                    html += "<tr>";
                    html += "<td>"+(i+1)+"</td>";
                    html += "<td><a href='admin/popup/station/"+id_station+"' class='update' data-id='"+id_station+"'>"+pad(id_station.toString(),10)+"</a></td>";
                    html += "<td></td>";
                    html += "<td><a href='admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>"+pad(obj.user_id.toString(),10)+"</td>";
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
</script>
{{-- @yield("left_sidebar_scripts") --}}
@stop
