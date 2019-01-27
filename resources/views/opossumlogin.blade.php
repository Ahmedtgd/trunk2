
<form  id="oposlogin" class="login_form"  method="post"
                              data-bv-message="This value is not valid"
                              data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                              data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                              data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">

		<div class="col-md-12" style="">
			<div class="col-md-12" style="">
				<input class="form-control input-sm" id="username"
					name="username" placeholder="abc@yourmail.com" type="text"
					style="height: 40px;" data-bv-trigger="keyup" required
					data-bv-notempty-message="Email is required"/>
			</div>
			<div class="clearfix"></div><br>
			<div class="col-md-12" style="">
				 <input type="password" name="password" id="password"
				 	autocomplete="off" readonly
					onfocus="this.removeAttribute('readonly');"
				 	style="height: 40px;"
					class="form-control input-sm"
					placeholder="Type your Password"
					data-bv-trigger="keyup" required
					data-bv-notempty-message="Password is required"/>
			</div>
			<div class="clearfix"></div><br>
			<div class="col-md-8" style="">
				<select id="fairmerchant1" name="merchant" class="form-control">
					<option value="0">Choose Merchant</option>
					@foreach($fairmerchant as $merchant)
						<option value="{{$merchant->user_id}}">{{$merchant->company_name}}</option>
					@endforeach
				</select>
			</div>
			<div class="clearfix"></div><br>
			<div class="col-md-8" style="">
				<select id="companylocation" name="location" class="form-control">
					<option value="0">Choose Location</option>
				</select>
			</div>

			<div class="clearfix"></div><br>
			<div class="col-md-8" style="">
				<select id="terminal" name="terminal" class="form-control">
					<option value="0">Choose Terminals</option>
				</select>
			</div>

			<div class="clearfix"></div><br>

			<button type="submit" class='btn signInBtnnew'>Sign In</button>

		</div>

</form>

<script type="text/javascript">
	 $(document).delegate( '#fairmerchant1', "change",function (event) {
			if($(this).val() == "0"){
				$("#mode_html").html("");
				$("#modeselect").val('0').trigger('change');
				$(".oncemerchantselected").hide();
			} else {
				var userid = $("#fairmerchant1").val();
				get_location1(userid);
				var fairrecruiter = $("#fairrecruiter").val();
				$(".oncemerchantselected").show();

				//$("#modeselect").select2();
				//window.open(JS_BASE_URL + '/fairmode/' + userid + '/' + fairrecruiter, '_blank');
			}
		});
		function get_location1($merchant_user_id) {
			$.ajax({
				url:JS_BASE_URL+"/companylocation",
				type:"POST",
				data:{user_id:$merchant_user_id,type:"user_id"},
				success:function (r) {
					var htmlrow="";
					if (r.status==="success") {
						for (var i = r.data.length - 1; i >= 0; i--) {
							row=r.data[i]
							htmlrow+=`
								<option
								value="`+row.id+`"
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
				// $(".oncemerchantselected").hide();
			} else {
				var locationid = $("#companylocation").val();
				get_terminal(locationid);
				// var fairrecruiter = $("#fairrecruiter").val();
				// $(".oncemerchantselected").show();
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
								value="`+row.terminal_id+`"
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

		$('#oposlogin').submit(function(e){
			e.preventDefault();
			var url =  JS_BASE_URL+"/LoginUser";
            var username = $('#username').val();
            var password = $('#password').val();
            $.ajax({
                type: "POST",
                url: url,
                data:{username:username,password:password},
                beforeSend: function(){},
                success: function(response){
                	if(response.status === "success"){
                		checkData();
                	}
                    // $('#opossumLoginBody').html(response);
                    // $('#opossumLoginModal').modal('show');
                }
            });
		});

		function checkData()
		{
			var url =  JS_BASE_URL+"/checkData";
			var merchantuserid = $("#fairmerchant1").val();
			var locationid = $('#companylocation').val();
			var terminalid = $('#terminal').val();

			$.ajax({
                type: "POST",
                url: url,
                data:{merchantuserid:merchantuserid,locationid:locationid,terminalid:terminalid},
                beforeSend: function(){},
                success: function(response){
                	if(response.status === "success"){
                		showterminal(terminalid);
                	}
                }
            });
		}
		function showterminal($terminalid)
		{
			var url =  JS_BASE_URL+"/open-terminal/"+terminalid;
			$.ajax({
                type: "POST",
                url: url,
                beforeSend: function(){},
                success: function(response){
                	// if(response.status === "success"){
                		// showterminal(terminalid);
                	// }
                }
            });
		}
</script>
