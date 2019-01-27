@extends("common.default")
<?php
	define('MAX_COLUMN_TEXT', 20);
	use App\Http\Controllers\IdController;
	$totalamt = 0;
	if(empty($payment)) {
		$payment = null;
	}
?>
@section("content")
@include('common.sellermenu')
<section class="">
  <div class="container">
	<div class="row">
	<div style="padding-left:0;padding-right:0;" class="col-sm-12">
	<div id="employees">
		<div class="row">
			@include('seller.ageingTabs')
			@if(!is_null($station))
				<div class = "btn-toolbar" style="float:right;margin-right:0;margin-bottom: 10px;">
					<button class="btn-primary"
						style="width:70px;height:70px;border-radius:5px;
						border-width:0"
						data-toggle="modal"
						data-target="#addDebitNoteModal">Debit Note
					</button>
			{{-- Creating the button for the credit note generator modal --}}
				@include('seller.credit_note_views.creditnote_generator')
			</div>
			@endif
		 	<h2>Debtor Ageing Report Details</h2>

            <div style="padding-left:0;padding-right:0" class=" col-sm-6">
				@if(!is_null($station))
					<h3>Station ID: {{IdController::oSeller($station->user_id)}}</h3>
					<h3>Station Name: {{$station->company_name}}</h3>
				@endif
			</div>
		</div>
		<?php $e=1;?>
		<div class="row">
			<div style="padding-left:0;padding-right:0;" class=" col-sm-12">
			
				<table class="table table-bordered" id="invoices-table" width="100%">
					<thead>
						<tr class="bg-ageing">
							<th class="text-center bsmall">No.</th>
							<th class="text-center">Document&nbsp;No.</th>
							@if(is_null($station))
								<th class="large text-center">Station&nbsp;ID</th>
								<th class="large text-center">Name</th>
							@endif
							<th class="text-center">Receivable</th>
							<th class="text-center">Mode</th>
							<th class="text-center">Payment</th>
							<th  style="background-color: green;" class="text-center">Status</th>
							<th class="text-center" style="background-color: #FF6600">Balance</th>
						</tr>
					</thead>
					<tbody>

						@if(!empty($dtcrediter))
							@foreach($dtcrediter as $dtcredit)
							<tr>
								<td class="text-center">{{$e}}</td>
								<td class="text-center">

								</td>
								@if(is_null($station))
									<td class="">
										{{IdController::nSeller($dtcredit->station_id)}}
									</td>
									<td class="text-center">
										{{$dtcredit->name}}
									</td>
								@endif


								<td class="text-right">
									-MYR <?php echo number_format((($dtcredit->order_price/100)*$dtcredit->quantity),2);  ?>
								</td>
								<td class="text-center">
									Credit Note
								</td>
								<td class="text-center">
									{{ ucfirst($dtcredit->status)}}
								</td>
								<td class="text-center">

								</td>
								<td class="text-right">
									
								</td>
							</tr>
							<?php $e++;?>
							@endforeach
						@endif
						@if(!empty($debit_notes))
						@foreach($debit_notes as $debit_note)
							<tr>
								<td class="text-center">{{$e}}</td>
								<td class="text-center">
								<!--changed by dave-->
									<a href="/view_debit_notes/{{$debit_note->id}}?dealer_id={{Request::segment(4)}}" class="view_debit_notes">{{str_pad($debit_note['debitnote_no'],10,"0",STR_PAD_LEFT)}}
									</a>
								</td>
								@if(is_null($station))
									<td class="">
										{{ $debit_note->station_id }}
									</td>
									<td class="text-center">
										{{$debit_note->name}}
									</td>
								@endif
								<td class="text-right">
									MYR <?php echo number_format($debit_note->total/100,2);  ?>
								</td>
								<td class="text-center">
									Debit Note
								</td>

								<td class="text-center">
									<a href="{{ route('postbalancepayment',[
										'oid' => $debit_note->porder_id,
										'user_id' => $debit_note->user_id]) }}">
										{{ ucfirst($payment) }}
									</a>
								</td>
								<td class="text-center">
								<?php
									Log::debug('***** debit_note *****');
									Log::debug(json_encode($debit_note));
								?>
									<a href="{{ route('selageing',[
										'oid' => $rcvdt,
										'sellid' => $sellids,
										'user_id' => $debit_note->user_id]) }}" target="_blank">
										{{ ucfirst($debit_note->status)}}
									</a>
								</td>
								<td class="text-right">
									<a href="{{ route('sellercageingbalance',[
										 'id' => $debit_note->porder_id,
										 'user_id' => $debit_note->user_id,
									 	 'seller_id' => $debit_note->user_id
										 ]) }}">
										 MYR <?php echo number_format($debit_note->total/100,2);  ?>
									
									</a>
								</td>
							</tr>
							<?php $e++;?>
						@endforeach
						@endif
						@foreach($invoices as $inv)
							<tr style="vertical-align: middle">
								<td class="text-center">{{$e}}</td>
								<td class="text-center">
									<a href="{{ url('/') }}/merchantinvoice/{{$inv['oid']}}" target="_blank">{{str_pad($inv['invoice_no'],10,"0",STR_PAD_LEFT)}}</a>
								</td>
								@if(is_null($station))
									<td class="">
										{{IdController::nSeller($inv['uid'])}}
									</td>
									<td class="text-center">
										{{$inv['dealer_name']}}
									</td>
								@endif
								<td class="text-right">
									{{$currentCurrency}}&nbsp;{{ number_format($inv['total']/100,2) }}
								</td>
								<td class="text-center">
									{{ ucfirst($inv['mode']) }}
								</td>
								<td id="clear{{$inv['oid']}}" class="text-center">
									@if(isset($inv['return']) && (ucfirst($inv['return'])) == 'Return')
										<a onclick="refundpopup({{$inv['oid']}})" ><span id="new_status{{$inv['oid']}}">Return</span></a>
										@else
											@if($inv['invoice_status'] == 'cancelled')
												{{'Offset'}}
											@else
												{{ucfirst($inv['invoice_payment'])}}
											@endif
										@endif
								</td>
								<td class="text-center">
									<?php
										$status = $inv['invoice_status'];
										if($status == 'cancelled'){
											$status = $inv['invoice_status'];
										}else{
											if($inv['invoice_payment'] == 'unpaid' || $inv['invoice_payment'] == 'partial'){
												$status = 'active';
											}
										}
									?>
									<a href="{{ url('/') }}/seller/ageing/{{$inv['oid']}}/{{$inv['uid']}}/{{$selluser->id}}" target="_blank">

										{{--ucfirst($inv['invoice_status'])--}}
										{{ ucfirst($status) }}

									</a>
								</td>
								<td class="text-right">
									<a href="{{ url('/') }}/seller/debtor_balance/{{$inv['oid']}}/{{$inv['uid']}}/{{$selluser->id}}" target="_blank">
										<span id="newtotal{{$inv['oid']}}">
										{{$currentCurrency}}&nbsp;
											{{--@if($status != 'cancelled')--}}
												{{ number_format(($inv['total'] - $inv['paid'])/100,2) }}
											{{--@else 0.00--}}{{--number_format(($inv['total'])/100,2)--}}{{--@endif--}}
										<?php $totalamt += ($inv['total'] - $inv['paid'])/100; ?></span>
									</a>
								</td>
							</tr>
						<?php $e++;?>
						@endforeach
					</tbody>
				</table>
				<br>
				<input type="hidden" value="{{$e}}" id="nume" />
				<input type="hidden" value="{{$selluser->id}}" id="lpeid" />
		</div>
		</div>
	</div>
	</div>
	</div>
 </div>
</section>

<!-- Add Debit Note Modal -->
<div id="addDebitNoteModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header bg-ageing" style="">
				<button type="button" class="close"
					style="color:white;position:relative;top:8px"
					data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Debit Note Generator</h3>
            </div>
            <div class="modal-body" style="padding-top:10px">
             	<div class="btn-group" style="float: right;margin-bottom:10px">
				<button class="debit-note-add-row" type="button"
					style="width:70px;height:70px;border-radius:10px;
					border-width:0;
					background-color: black; color: #fff">+ Row</button>
				<button type="button" id="saveDebitNote"
					style="width:70px;height:70px;border-radius:10px;
					border-width:0;
					background-color: #337ab7; color: #fff">Confirm</button>
            	</div>

            	<form method="post" id="debitNoteForm" action="/save_debit_notes">
	            	<table id="addDebitNoteTable" class="table table-bordered">
	                	<thead>
	                		<tr class="bg-ageing">
	                			<th class="text-center">No.</th>
		                		<th class="text-center">Debit Item No.</th>
		                		<th>Description</th>
		                		<th>Total (MYR)</th>
	                		</tr>
	                	</thead>
	                	<tbody>
	                		<tr>
	                			<td class='text-center debt_note_sr'>1</td>
								
		                		<td class='debit_note_item_no'>
		                			<span>100000001</span>
									<input type="hidden" name="debit_note[1][item_no]" value="100000001">

								</td>
								<td style="display:none" class='debit_note_dealers_id'>	
									<input type="hidden" name="debit_note[1][dealer_id]" value= @if($station){{$station->user_id}}@endif >
								</td>
		                		<td class='debt_note_desc'>
									<input type='text' name='debit_note[1][description]' placeholder='Enter Description' style='width: 100%' required>
								</td>
		                		<td class='debt_note_total numbers_only'>
									<input type='text' name='debit_note[1][total]' placeholder='Enter Amount' style="text-align: left; width: 100%" required>
								</td>
	                		</tr>
	                	</tbody>
	                </table>
	            </form>
            </div>
            <div class="modal-footer">
				<!--
				<button type="button" class="btn btn-default"
				data-dismiss="modal">Close</button>
				-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewDebitNoteModal" role="dialog">
	<div style="width: 80%;"  class="modal-dialog">

		 <!-- Modal content-->
		 <div class="modal-content">
		  <div class="modal-header">
			  <button type="button" class="close" style="position:relative;top:-6px" data-dismiss="modal">&times;</button>
		   </div>
		   <div class="modal-body" style="padding-top:0 !important">
			   <div id="debitnoteview"></div>
		  </div>
		   <div class="modal-footer">
		   </div>
	  </div>
  </div>
</div>



<script type="text/javascript" src="<?php echo e(asset('js/qr.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/html2pdf.js')); ?>"></script>

<script type="text/javascript">

	function refundpopup(id) {
		$.ajax({
			type: "GET",
			url: JS_BASE_URL+"/seller/gator/invreturn/"+id,
			// data:{"id":id},
			success: function(data){
				$('#refundDirectals').modal('show');
				$('#refundDirects').html(data);

			}
		});
	}
	function closerefund(){
		$('#refundDirectals').modal('hide');
	}
	function closenotes(){
		$('#Creditnotes').modal('hide');
	}
	table_sr_no = "{{$e}}";

	$('#saveDebitNote').click(function(e){
		e.preventDefault();

		form = $('#debitNoteForm').serializeArray();
	
		$.post('/save_debit_notes', form, function(response){
			if(response.result == "success"){
				$("#debitnoteview").html(response.view_content);

				table = $('#invoices-table').DataTable();
				var currentPage = table.page();
				data = response.data;
				//?user_id={{Request::segment(4)}}
				rowNode = table.row.add([
					table_sr_no,
					//--------------------changed by dave---------------------//
					'<a href="/view_debit_notes/' + data.id + '?dealer_id='+ data.dealer_id +'" class="view_debit_notes"> 0'+ data.debitnote_no + '</a>',
					'<td class="text-right">MYR ' + data.total + '</td>',
					'Debit Note',
					'<a href="/seller/ageing">Active</a>',
					'<a href="/seller/ageing">Unpaid</a>',
					'<a href="/seller/balance/">MYR ' + data.total + '</a>'
				]).draw();

				var index = 0,
					rowCount = table.data().length - 1,
					insertedRow = table.row(rowCount).data(),
					tempRow;

				for (var i = rowCount; i > index; i--) {
					tempRow = table.row(i - 1).data();
					table.row(i).data(tempRow);
					table.row(i - 1).data(insertedRow);
				}
				$('#invoices-table tr td:first-child').each( function() {
					table.cell(this).data($(this).parent().index()+1);
				});
				table.page(currentPage).draw(false);
				++table_sr_no;
				$( rowNode ).find('td').addClass('text-center');
				$('#invoices-table > tbody:last-child').addClass('text-center');
			//$('#invoices-table tr').addClass('text-right');
			//	$('#invoices-table tr:last td:nth-child(1)').removeClass('text-center');
			//	$('#invoices-table tr:last td:nth-child(3)').addClass('text-right');
	        	$('#addDebitNoteModal').modal('hide');
				$('#viewDebitNoteModal').modal('show');
	        }else{

	        }
	    });
	})

	// $('#debitNoteForm').on()
	$(document).on('click', '.view_debit_notes', function(e){
		e.preventDefault();
		url = $(this).attr('href');
		$.ajax({
			type: "GET",
			url: url,
			success: function( data ) {
				$('#viewDebitNoteModal').modal('show');
				$("#debitnoteview").html(data);
			}
		});
	});

	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	 //allow number only
	$(document).on('keypress', '.numbers_only',function (e) {
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
	        return false;
	    }
	});

	$(document).on('click', '.debit-note-add-row', function(e){
		if($('.debt_note_desc input:last').val() == '') {
			toastr.warning('Please fill all the fields.');
			return false;
		}

		if($('.debt_note_total input:last').val() == '') {
			toastr.warning('Please fill all the fields.');
			return false;
		}

		$(document).on('keyup','.numbers_only input',function(){
			formatCurrency($(this));
		});
		$(document).on('blur','.numbers_only input',function(){
			formatCurrency($(this), "blur");
		});

		function formatNumber(n) {
			return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
		}

		function formatCurrency(input, blur) {
			var input_val = input.val();
			if (input_val === "") { return; }
			var original_len = input_val.length;
			var caret_pos = input.prop("selectionStart");
			if (input_val.indexOf(".") >= 0) {
				var decimal_pos = input_val.indexOf(".");
				var left_side = input_val.substring(0, decimal_pos);
				var right_side = input_val.substring(decimal_pos);

				left_side = formatNumber(left_side);
				right_side = formatNumber(right_side);

				if (blur === "blur") {
					right_side += "00";
				}

				right_side = right_side.substring(0, 2);
				input_val = left_side + "." + right_side;

			} else {
				input_val = formatNumber(input_val);
				if (blur === "blur") {
					input_val += ".00";
				}
			}
			input.val(input_val);
			var updated_len = input_val.length;
			caret_pos = updated_len - original_len + caret_pos;
			input[0].setSelectionRange(caret_pos, caret_pos);
		}

		lastrow = $('#addDebitNoteTable tr:last');
		newRow = lastrow.clone();

		// sr no..
		sr_no = +lastrow.find('.debt_note_sr').text() + 1;
		newRow.find('.debt_note_sr').text(sr_no);

		// debit note id
		item_no = newRow.find('.debit_note_item_no');
		item_no_input = newRow.find('.debit_note_item_no input');
		item_no_input.attr('name', 'debit_note['+sr_no+'][item_no]');

//--------------------------dave--------------------------//
		// Dealers_id input
		desc_input = newRow.find('.debit_note_dealers_id input');
		desc_input.attr('name', 'debit_note['+sr_no+'][dealer_id]');
//--------------------------dave--------------------------//

		// desc input
		desc_input = newRow.find('.debt_note_desc input');
		desc_input.val("");
		desc_input.attr('name', 'debit_note['+sr_no+'][description]');

		// amount input
		amount_input = newRow.find('.debt_note_total input');
		amount_input.val("");
		amount_input.attr('name', 'debit_note['+sr_no+'][total]');

		// append..
		lastrow.after(newRow);
	});

	$("#addDebitNoteModal").on("hidden.bs.modal", function () {
		resetDebitNoteTable();
		$('.debt_note_desc input').val('');
		$('.debt_note_total input').val('');
	});

	function resetDebitNoteTable() {
		uniq_id = new UniqueIDGenerator().generate();

		@if(!empty($station))
			$.ajax({
				url : '/openmall/trunk/public/seller/ntproduct-id/{{$merchant_id}}/{{$station->user_id}}',
				success : function(uniq_id) {
					$('#addDebitNoteTable tbody tr').remove();
				    $("#addDebitNoteTable tbody").append("<tr><td class='debt_note_sr'>1</td><td class='debit_note_item_no'><span>"+uniq_id+"</span><input type='hidden' name='debit_note[1][item_no]' value='100000001'></td><td class='debt_note_desc'><input type='text' name='debit_note[1][description]' placeholder='Enter Description' style='width: 100%' required></td><td class='debt_note_total numbers_only'><input type='text' name='debit_note[1][total]' placeholder='Enter Amount' required></td></tr>");
				}
			});
		@endif
	}

	function UniqueIDGenerator() {

		 this.length = 8;
		 this.timestamp = +new Date;

		 var _getRandomInt = function( min, max ) {
			return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
		 }

		 this.generate = function() {
			 var ts = this.timestamp.toString();
			 var parts = ts.split( "" ).reverse();
			 var id = "";

			 for( var i = 0; i < this.length; ++i ) {
				var index = _getRandomInt( 0, parts.length - 1 );
				id += parts[index];
			 }

			 return id;
		}
	}

    $(document).ready(function(){
    	firstrow = $('#addDebitNoteTable tr:last');
		firstrow_item_no = firstrow.find('.debit_note_item_no span');

		@if(!empty($station))
    	$.ajax({
			url : '/seller/ntproduct-id/{{ $merchant_id }}/{{ $station->user_id }}',
			success : function(uniq_id) {
				firstrow_item_no.text(uniq_id); //first row first time
				firstrow_item_no_input = firstrow.find('.debit_note_item_no input');
				firstrow_item_no_input.val(uniq_id);
			}
		});
		@endif

		@if(is_null($station))
		var emp_table = $('#invoices-table').DataTable({
				"order": [],
				"columns": [
						{ "width": "20px" ,"orderable": false },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
					]
				});
			@else
				var emp_table = $('#invoices-table').DataTable({
				"order": [],
				"columns": [
						{ "width": "20px", "orderable": false },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
						{ "width": "120px" },
					]
				});
		@endif

		$(document).delegate( '.memberchek', "click",function (event) {
			if($(this).prop('checked')){
				$('.memberchek').prop('checked',false);
				$(this).prop('checked',true);
			}
		});

		$(document).delegate( '.view-employee-modal', "click",function (event) {
			//	$('.view-employee-modal').click(function(){

			var user_id=$(this).attr('data-id');
			var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+user_id;
			$.ajax({
				url:check_url,
					type:'GET',
					success:function (r) {
						console.log(r);

						if (r.status=="success") {
							var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
							var w=window.open(url,"_blank");
							w.focus();
						}
						if (r.status=="failure") {
							var msg="<div class=' alert alert-danger'>"+
								r.long_message+"</div>";
							$('#employee-error-messages').html(msg);
						}
					}
			});
		});


		$("#addDebitNoteModal").on('shown.bs.modal', function() {

			$('.debt_note_desc input').val('');
			$('.debt_note_total input').val('');

			$.ajax({
				url : '/seller/ntproduct-id/{{ $merchant_id }}/@if($station){{$station->user_id}}@endif',
				success : function(uniq_id) {
					//second time
					firstrow = $('#addDebitNoteTable tr:last');
					firstrow_item_no_input = firstrow.find('.debit_note_item_no input');
					firstrow_item_no_input.val(uniq_id);
				}
			});

			$(".numbers_only input").on({
				keyup: function() {
					formatCurrency($(this));
				},
				blur: function() {
					formatCurrency($(this), "blur");
				}
			});

		});

		function formatNumber(n) {
			return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
		}

		function formatCurrency(input, blur) {
			var input_val = input.val();
			if (input_val === "") { return; }
			var original_len = input_val.length;
			var caret_pos = input.prop("selectionStart");
			if (input_val.indexOf(".") >= 0) {
				var decimal_pos = input_val.indexOf(".");
				var left_side = input_val.substring(0, decimal_pos);
				var right_side = input_val.substring(decimal_pos);

				left_side = formatNumber(left_side);
				right_side = formatNumber(right_side);

				if (blur === "blur") {
					right_side += "00";
				}

				right_side = right_side.substring(0, 2);
				input_val = left_side + "." + right_side;

			} else {
				input_val = formatNumber(input_val);
				if (blur === "blur") {
					input_val += ".00";
				}
			}
			input.val(input_val);
			var updated_len = input_val.length;
			caret_pos = updated_len - original_len + caret_pos;
			input[0].setSelectionRange(caret_pos, caret_pos);
		}

    });
</script>
<div class="modal fade" id="refundDirectals" role="dialog">
	<div class="modal-dialog" style="min-width:90% !important; ">
		<!-- Modal content-->
		<div class="modal-content modal-content-sku" style="width:90% !important; background-color: rgb(255, 153, 0);">
			<div class="modal-header"
				 style="background-color:black;color:white">
				<button type="button" class="close" onclick="closerefund();"
						style="color:#cbcbcb;background:none;position:relative;top:8px">&times;</button>
				<h3 class="modal-title" style="color:white">Return</h3>
			</div>
			<!-- Temporarily disable the modal due to UGLY ERROR -->
			<div id="refundDirects"
				 style="padding-left:16px;padding-right:16px;background-color: #ff9900;color:#fff;border-bottom-left-radius: 0.25rem;border-bottom-right-radius: 0.25rem"
				 class="modal-body"></div>
		</div>
	</div>
</div>

<div class="modal fade" id="Creditnotes" role="dialog">
	<div style="width: 80%;" id="Somodelwidth"  class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" style="position:relative;top:-6px" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="padding-top:0 !important">
				<div id="creditnote"></div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<div class="modal fade" id="directMerchantInvoice" role="dialog">
	<div style="width: 80%;"  class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button"
						style="position:relative;top:-6px"
						class="close" data-dismiss="modal">&times;</button>
				<!-- <h3>Direct Merchant Invoice</h3> -->
			</div>
			<div class="modal-body">
				<div id="directMerchantInvoiceHtml"> </div>
			</div>
			<div class="modal-footer" style="text-align: left;">
				<div class="col-md-12" id="footerDetailsForInvoice" style="display:none;">
					<table style="margin-top: 5px;">
						<tr>
							<td style="text-align: left"><strong>Delivery Order ID</strong></td>
							<td>: <span id="InvoiceNoDI"></span></td>
						</tr>
						<tr>
							<td style="text-align: left"><strong>DeliveryMan Name</strong></td>
							<td>: <span id="dmanName"></span></td>
						</tr>
						<tr>
							<td style="text-align: left"><strong>DeliveryMans ID </strong></td>
							<td>: <span id="dmanID"></span></td>
						</tr>
					</table>
					<div  id="ImeiWarrant"></div>
						<ul id="Qtydifferent_message" style="margin-left: -10px;"></ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="stack3" style="z-index: 99999;" class="modal fade"  style="display: none;">
    <div style="width: 90%;"  class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" style="position:relative;top:-6px" onclick="close_prod_modal2()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="seller_mini_modal"> </div>
            </div>
            <div class="modal-footer" style="text-align: left;"></div>
        </div>
    </div>
</div>
@stop
