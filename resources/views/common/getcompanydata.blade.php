 <script src="{{asset('/js/jquery.min.js')}}"></script>
<script> var JS_BASE_URL = '{{ url('/') }}'; </script>
<script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
<link rel="stylesheet" href="{{asset('/css/toastr.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<style>
.submitBtnnew {
    background: #0BEDC0;
    border-radius: 5px !important;
    color: #fff;
    padding: 8px 25px;
    width: 100%;
    font-size: 25px;
}
</style>

<div class="clearfix"></div><br>
<div class="col-md-12">
	<select id="fairmerchant1" name="merchant" class="form-control" style="height: 40px;">
		<option value="0">Select Company</option>
		@foreach($fairmerchant as $merchant)
			<option value="{{$merchant->company_id}}">{{$merchant->company_name}}</option>
		@endforeach
	</select>
</div>
<div class="clearfix"></div><br>
<div class="col-md-12">
	<select id="companylocation" name="location" class="form-control" style="height: 40px;">
		<option value="0">Select Location</option>			
	</select>
</div>

<div class="clearfix"></div><br>
<div class="col-md-12" >
	<select id="terminal" name="terminal" class="form-control" style="height: 40px;">
		<option value="0">Select Terminal</option>
	</select>
</div>
<div class="clearfix"></div><br>
<div class="col-md-12">
	<button class='btn submitBtnnew' onclick="redirectopossum()">Sign In</button>
</div>
<div class="clearfix"></div><br>


<script type="text/javascript">	

	 $(document).delegate( '#fairmerchant1', "change",function (event) {
			if($(this).val() == "0"){
				$("#mode_html").html("");
				$("#modeselect").val('0').trigger('change');
				$(".oncemerchantselected").hide();
			} else {
				var companyid = $("#fairmerchant1").val();
				get_location1(companyid);
				var fairrecruiter = $("#fairrecruiter").val();
				$(".oncemerchantselected").show();				
			}
		});	 

		function get_location1($companyid) {
			$.ajax({
				url:JS_BASE_URL+"/companylocation",
				type:"POST",
				data:{companyid:$companyid},
				success:function (r) {
					var htmlrow="";
					if (r.status==="success") {
						for (var i = r.data.length - 1; i >= 0; i--) {
							row=r.data[i]
							htmlrow+=`
								<option
								value="`+row.location_id+`"
								>
								`+row.location+`
								</option>

							`;
						}
						$("#companylocation").html(htmlrow);
					}
				}
			})
		}
		$(document).delegate( '#companylocation', "change",function (event) {
			if($(this).val() == "0"){
				$("#mode_html").html("");
				$("#modeselect").val('0').trigger('change');
			} else {
				var locationid = $("#companylocation").val();
				get_terminal(locationid);
			}
		});

		function get_terminal($locationid) {
			$.ajax({
				url:JS_BASE_URL+"/locationterminal",
				type:"POST",
				data:{locationid:$locationid},
				success:function (r) {
					var htmlrow="";
					if (r.status==="success") {
						for (var i = r.data.length - 1; i >= 0; i--) {
							row=r.data[i]
							htmlrow+=`
								<option
								value="`+row.id+`"
								>
								`+row.name+`
								</option>

							`;
						}
						$("#terminal").html(htmlrow);
					}
				}
			})
		}
		
		function redirectopossum()
		{
			var terminalid = $('#terminal').val();
			var companylocation = $('#companylocation').val();
			var fairmerchant1 = $('#fairmerchant1').val();

			if(terminalid > 0 && companylocation > 0 && fairmerchant1 > 0) {
				window.location = JS_BASE_URL+"/opossum/"+terminalid;
			} else {
				if(fairmerchant1 == 0){
					$('#fairmerchant1').focus();
					toastr.error("Select Company");

				} else if(companylocation == 0){
					$('#companylocation').focus();
					toastr.error("Select Location");

				} else if(terminalid == 0){
					$('#terminal').focus();
					toastr.error("Select Terminal");
				}			
			}			
		}
</script>
