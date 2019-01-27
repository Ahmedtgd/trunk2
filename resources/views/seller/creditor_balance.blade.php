@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
?>
@section("content")
@include('common.sellermenu')
<section class="">
  <div class="container">
	<div class="row">
	<div class="col-sm-12">  
	<div id="employees">
		<div class="row">
			<div class=" col-sm-12">
				@include('seller.ageingTabs')
				<h2>Creditor Ageing Report: Balance</h2>
			</div>
			<div class=" col-sm-6">
				&nbsp;
			</div>
		</div>
		<?php $e=1;?>
		<div class="row">
			<div class=" col-sm-12">
			<!--	<a href="javascript:void(0)" class="btn btn-primary btn-primary pull-right" id="addPayment">
                  <span class="glyphicon glyphicon-plus "></span>
                   Add Payment</a>
				   <br>
				   <br> -->
				<table class="table table-bordered"
					id="invoices-table" width="100%">
					<thead>
						<tr style="background-color: #FF6600; color: #FFF;">
							<th class="text-center bsmall">No.</th>
							<th class="text-center">Date&nbsp;Paid</th>
							<th class="large text-center">Bank</th>
							<th class="large text-center">Method</th>
							<th class="text-center">Note</th>
							<th class="text-center">Amount Paid</th>
						<!--	<th class="text-center bsmall">&nbsp;</th> -->
						</tr>
					</thead>	
					<tbody>		
					@if(count($invoices) > 0)
						@foreach($invoices as $inv)
							<tr>
								<td class="text-center">{{$e}}</td>
								<td class="text-center">
									{{UtilityController::s_datenotime($inv->date_paid)}}
								</td>
								<td class="text-center"> 
									{{$inv->bname}}
								</td>
								<td class="text-center">
									{{ucfirst($inv->method)}}
								</td>
								<td class="text-left">
									{{$inv->note}}
								</td>
								<td class="text-right">
									{{$currentCurrency}} {{number_format($inv->amount/100,2)}}
								</td>
								<!--<td class="text-center">
									<a href="javascript:void(0);" class="text-danger delete_payment" rel="{{$inv->id}}"><i class="fa fa-minus-circle fa-2x"></i></a>
								</td> -->
							</tr>
						<?php $e++;?>
						@endforeach
					@endif
					</tbody>	
				</table>
		</div>
		</div>    
	</div>
	</div>
	</div>
 </div>
</section>
<input type="hidden" value="{{$e}}" id="evalue" />
 	<div class="modal fade" id="myModalBalance" role="dialog" aria-labelledby="myModalToken">
		<div class="modal-dialog" role="remarks" style="width: 50%">
			<div class="modal-content">
				<div class="row" style="padding: 15px;">
					<div class="col-md-12" style="">
						<form id="remarks-form">
							<fieldset>
								<h2>Payment</h2>
								<div class='col-sm-3'><label><b>Date Paid</b></label></div>
								<div class='col-sm-9'><input type="text" id='date_paid' placeholder="dd/mm/year" class="date form-control"></div>
								<div class="clearfix"></div>
								<div class='col-sm-3'><label><b>Bank</b></label></div>
								<div class='col-sm-9'>
									<?php $banks = DB::table('bank')->get(); ?>
									<select id="payment_bank">
										@foreach($banks as $bank)
											<option value="{{$bank->id}}">{{$bank->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="clearfix"></div>
								<div class='col-sm-3'><label><b>Method</b></label></div>
								<div class='col-sm-9'>
									<select id="method">
										<option value="IBG">IBG</option>
										<option value="cash">Cash</option>
										<option value="cheque">Cheque</option>
									</select>
								</div>
								<div class="clearfix"></div>
								<div class='col-sm-3'><label><b>Note</b></label></div>
								<div class='col-sm-9'><textarea rows="4" id="payment_note" class="form-control"></textarea></div>
								<div class="clearfix"></div>
								<div class='col-sm-3'><label><b>Amount Paid</b></label></div>
								<div class='col-sm-9'><input type="text" id='amount_paid' placeholder="Amount Paid" class="form-control"></div>
								<div class="clearfix"></div>
								<br>
								<div class='col-sm-12'>
									<a href="javascript:void(0)" class="btn btn-info pull-right register_payment">Save</a>
								</div>
								<input type="hidden" id="porder_id" value="{{$porder_id}}" >
							</fieldset>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button style="width: 60px !important;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>				
			</div>			
		</div>	
	</div>	
<script type="text/javascript">
	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
    function number_format(number, decimals, dec_point, thousands_sep)
    {
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + (Math.round(n * k) / k).toFixed(prec);
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }	
	function getmonth(month) {
		if(parseInt(month) == 1){
			return "Jan";
		} else if(parseInt(month) == 2){
			return "Feb";
		} else if(parseInt(month) == 3){
			return "Mar";
		} else if(parseInt(month) == 4){
			return "Apr";
		}else if(parseInt(month) == 5){
			return "May";
		}else if(parseInt(month) == 6){
			return "Jun";
		}else if(parseInt(month) == 7){
			return "Jul";
		}else if(parseInt(month) == 8){
			return "Aug";
		}else if(parseInt(month) == 9){
			return "Sep";
		}else if(parseInt(month) == 10){
			return "Oct";
		}else if(parseInt(month) == 11){
			return "Nov";
		}else if(parseInt(month) == 12){
			return "Dec";
		} else {
			return "Na";
		}
	}
	
	
    $(document).ready(function(){
		$("#amount_paid").number(true,2,'.','');
		var emp_table = $('#invoices-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
				//	{ "width": "20px" },
				]
			});		

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
				var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
				$('#employee-error-messages').html(msg);
				}
			}
		});	
		});	
	 $("#addPayment").on("click",function(){
		 $("#myModalBalance").modal('show');
	 });
	 
	 $(document).delegate( '.delete_payment', "click",function (event) {
	// $(".delete_payment").on("click",function(){
			var obj=$(this);
			var id=$(this).attr("rel");
		 	$.ajax({
				type: "post",
				url: JS_BASE_URL + '/seller/balance/deletepayment',
				data: {
					id: id
				},
				cache: false,
				success: function (responseData, textStatus, jqXHR) {
					toastr.info('Payment successfully deleted!');
					emp_table
						.row( obj.parents('tr') )
						.remove()
						.draw();
				},
				error: function (responseData, textStatus, errorThrown) {
					toastr.error('An unexpected error occurred!');
				}
			});	
	 });

	 $(".register_payment").on("click",function(){
		 $(this).html("Saving...");
		 var btnthis = $(this);
		 var date_paid = $("#date_paid").val();
		 var amount_paid = $("#amount_paid").val();
		 var method = $("#method").val();
		 var method_name = $("#method option:selected").text();
		 var payment_bank = $("#payment_bank").val();
		 var payment_bank_name = $("#payment_bank option:selected").text();
		 var payment_note = $("#payment_note").val();
		 var porder_id = $("#porder_id").val();
		 var valid = true;
		 var err_text = "";
		 if(date_paid == ""){
			valid = false;
		    err_text = "You must select a payment date"; 
		 }
		 if(amount_paid == "" || parseFloat(amount_paid) <= 0){
			valid = false;
		    err_text = "You must select a valid payment amount"; 
		 }
		 console.log(amount_paid);
		 console.log(date_paid);
		 console.log(method);
		 console.log(payment_bank);
		 console.log(payment_note);
		 console.log(porder_id);
		 console.log(valid);
		 var datesplit = date_paid.split('/');
		 var realdate = "";
		 var month = getmonth(datesplit[1]);
		 
		 realdate =  datesplit[2] + month + datesplit[0].substr(2);
		 if(valid){
			$.ajax({
				type: "post",
				url: JS_BASE_URL + '/seller/balance/payment',
				data: {
					porder_id: porder_id,
					date_paid: date_paid,
					amount_paid: amount_paid,
					method: method,
					payment_bank: payment_bank,
					payment_note: payment_note,
					note: "Buyer: "
				},
				cache: false,
				success: function (responseData, textStatus, jqXHR) {
					if(responseData == "error"){
						toastr.warning('You cannot pay more than the due amount!');
					} else {
						toastr.info('Payment successfully added!');
						var e = parseInt($("#evalue").val());
						var rowNode = emp_table.row.add( [ "<p align='center'>" + e + "</p>", "<p align='center'>"+realdate+"</p> ","<p align='center'>"+payment_bank_name+"</p>", "<p align='center'>"+method_name+"</p>", "<p align='left'>Buyer: "+payment_note+"</p>", "<p align='right'>{{$currentCurrency}} "+number_format(amount_paid,2,'.','')+"</p>", "<p align='center'><a href='javascript:void(0);' class='text-danger delete_payment' rel='"+responseData+"'><i class='fa fa-minus-circle fa-2x'></i></a></p>"] ).draw();
						$( rowNode )
						.css( 'text-align', 'center');
						e++;
						$("#evalue").val(e);
						
						$("#myModalBalance").modal('toggle');
					}
					btnthis.html('Save');
				},
				error: function (responseData, textStatus, errorThrown) {
					toastr.error('An unexpected error occurred!');
					btnthis.html('Save');
				}
			});
		 } else {
			 toastr.error(err_text);
		 }
		});		
		$('.date').datetimepicker({
			viewMode: 'days',
			format: 'YYYY/MM/DD'
			// Sorry for bad naming above
		 });
    });
</script>
@stop