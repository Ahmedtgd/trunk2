<script src="{{asset('/js/jquery.min.js')}}"></script>
<script> var JS_BASE_URL = '{{ url('/') }}'; </script>
<script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('/css/toastr.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<style>
.signInBtnnew {
    background: #0BEDC0;
    border-radius: 5px !important;
    color: #fff;
    padding: 8px 25px;
    width: 100%;
    font-size: 25px;
}
</style>
<div class="col-md-12" style="background-color: black;height:100%;padding-top:100px">
	<div class="col-md-4 col-sm-12 col-md-pull-4 col-md-push-4">
		<h1 style="color:#5cd6d6;padding-bottom:10px">
			<center>OPOSsum</center></h1>

		<form  id="oposlogin" class="login_form"  method="post"
			data-bv-message="This value is not valid"
			data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
			data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
			data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" autocomplete="off">
			<div class="col-md-12" class="form-group" >
				<div class="col-md-12">
					<input class="form-control input-md" id="username"
						name="username"
						placeholder="Enter Email *" type="text"
						style="height: 40px;"
						data-bv-trigger="keyup" required
						data-bv-notempty-message="Email is required" readonly 
onfocus="this.removeAttribute('readonly');"/>
				</div>
				<div class="clearfix"></div><br>
				<div class="col-md-12" style="">
					 <input type='password' name="password" id="password"
					 	style="height: 40px;"
						class="form-control input-md"
						placeholder="Enter Password *"
						data-bv-trigger="keyup" required
						data-bv-notempty-message="Password is required" readonly 
onfocus="this.removeAttribute('readonly');"/>
				</div>				
			</div>
			<input type="hidden" id="isfromlocal" name="isfromlocal" value="0">
			<input type="hidden" id="loggedid" name="loggedid" value="">
			<div class="col-md-12 showCompany" class="form-group" style="display:none">
				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<select id="fairmerchant1" name="merchant" class="form-control" style="height: 40px;" required>
						<option value="0">Select Company *</option>
						
					</select>
				</div>
				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<select id="companylocation" name="location" class="form-control" style="height: 40px;" required>
						<option value="0">Select Location *</option>			
					</select>
				</div>
				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<div class="oncemerchantselected">
						<select id="modeselect" name="modeselect" class="form-control" style="height: 40px;" required>
							<option value="0">Select Function *</option>
								<!-- <option value="opossum">OPOSsum</option>
								<option value="warehouse">Warehouse</option> -->
						</select>
					</div>
				</div>

				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<select id="terminal" name="terminal" class="form-control" style="height: 40px;" required>
						<option value="0">Select Terminal *</option>
					</select>
				</div>			
			</div>
			<div class="col-md-12 showLocalData" class="form-group" style="display:none">
				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<input id="merchantid" name="merchantid" type="hidden" value=""/>
					<input class="form-control input-md" id="merchantname" name="merchantname" type="text" style="height: 40px;" value="" readonly />
				</div>

				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<input id="locationid" name="locationid" type="hidden" value=""/>
					<input class="form-control input-md" id="locationname" name="locationname" type="text" style="height: 40px;" value="" readonly/>
				</div>

				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<div class="oncemerchantselected">
						<input id="modeid" name="modeid" type="hidden" value=""/>
						<input class="form-control input-md" id="modename" name="modename" type="text" style="height: 40px;" value="" readonly/>
					</div>
				</div>

				<div class="clearfix"></div><br>
				<div class="col-md-12" >
					<input id="terminalid" name="terminalid" type="hidden" value=""/>
					<input class="form-control input-md" id="terminalname" name="terminalname" type="text" style="height: 40px;" value="" readonly/>
				</div>
			</div>
			<div class="col-md-12" class="form-group" >
				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<button type="submit" class='btn signInBtnnew'>Sign In</button>
					<input type="button" id="validateotherdata" class='btn signInBtnnew' onClick="validateotherdatafun();" style="display: none" value="Sign In">
				</div>
				<div class="clearfix"></div><br>
				<div class="col-md-12">
					<p id="errormsg" class="text-center" style="display:none;color:red">error</p>
				</div>
			</div>
		</form>
	</div>
	<div class="modal fade" id="accessModal" role="dialog">
        <div class="modal-dialog maxwidth60" style="width:50%">
          <div class="modal-content modal-content-sku">
              <div class="modal-header">                      
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3>Unauthorized Access</h3>
              </div>
              <div class="modal-body">
                <div id="listrecipebody"
					style="font-size:17px;padding-left:0;padding-right:0"
					class="modal-body">
                	You are not authorized for this terminal. <br>Would you like to continue with your current authorized terminal?
                </div>
              </div>
              <div class="modal-footer">
              	<button type="button" class="btn btn-primary" onclick="getaccess()">Yes</button>
              	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
              </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reLoginModal" role="dialog">
        <div class="modal-dialog maxwidth60" style="width:50%">
          <div class="modal-content modal-content-sku">
              <div class="modal-header">                      
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3>Secondary Login</h3>
              </div>
              <div class="modal-body">
                <div id="listrecipebody"
					style="font-size:17px;padding-left:0;padding-right:0"
					class="modal-body">
					Do you want to have Number Login Page?                	
                </div>
              </div>
              <div class="modal-footer">
              	<button type="button" class="btn btn-primary" onclick="reLogin()">Yes</button>
              	<button type="button" class="btn btn-default" onclick="dashboard()">No</button>
              </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	
	window.onload = localStorageData;

	function localStorageData() {
		var blank = $('#passowrd');
		 console.log(blank);
		
		var company = localStorage.getItem('opossumlogin_selected_company');
		var location = localStorage.getItem('opossumlogin_selected_location');
		var functionmode  = localStorage.getItem('opossumlogin_selected_functionmode');
		var terminal = localStorage.getItem('opossumlogin_selected_terminal');

		var allcompany = localStorage.getItem('opossumlogin_all_company');
		var allLocation = localStorage.getItem('opossumlogin_all_location');
		var allfunction = localStorage.getItem('opossumlogin_all_function');
		var allterminal = localStorage.getItem('opossumlogin_all_terminal');

		company = (company != '' && company != null)? JSON.parse(company):'';
		location = (location != ''  && location != null)? JSON.parse(location):'';
		functionmode = (functionmode != '' && functionmode != null)? JSON.parse(functionmode):'';
		terminal = (terminal != '' && terminal != null)? JSON.parse(terminal):'';

		allcompany = (allcompany != '' && allcompany != null)? JSON.parse(allcompany):'';
		allLocation = (allLocation != '' && allLocation != null)? JSON.parse(allLocation):'';
		allfunction = (allfunction != '' && allfunction != null)? JSON.parse(allfunction):'';
		allterminal = (allterminal != '' && allterminal != null)? JSON.parse(allterminal):'';

		if(company != '' && location != '' && functionmode != '' && terminal != '')
		{
			createCompanyDropDown(allcompany,company.id);
			createLocationDropDown(allLocation,location.id);
			createFunctionDropDown(allfunction,functionmode.id);
			createTerminalDropDown(allterminal,terminal.id);
			$('.showCompany').show();
			$('#isfromlocal').val(1);
			// $(".signInBtnnew").hide();
			// $('#validateotherdata').show();
			// $("#fairmerchant1").html(companyrow);

		}
		// 	$('.showLocalData').show();
			// $('.showCompany').show();
		// 	if(company){ 
		// 		$('#merchantname').val(company.name); 
		// 		$('#merchantid').val(company.id); 
		// 	}
		// 	if(location){ 
		// 		$('#locationname').val(location.name); 
		// 		$('#locationid').val(location.id);
		// 	}
		// 	if(functionmode){ 
		// 		$('#modename').val(functionmode.name); 
		// 		$('#modeid').val(functionmode.id);
		// 	}
		// 	if(terminal){ 
		// 		$('#terminalname').val(terminal.name);
		// 	 	$('#terminalid').val(terminal.id);
		// 	}
			
		// }
		// else
		// {
		// 	$('.showLocalData').hide();
		// 	$('.showCompany').show();
		// }		
    }

    $(document).delegate( '#modeselect', "change",function (event) {
		if($(this).val() == "warehouse"){
			$("#terminal").hide();
			$('#terminal').removeAttr('required');
		}
		else
		{
			$("#terminal").show();
		}
	});


	$('#oposlogin').submit(function(e){

		e.preventDefault();

		var url =  JS_BASE_URL+"/OpopssumLoginUser";

		if($('#isfromlocal').val() == 1)
		{
			var company = $('#fairmerchant1').val();
			var location = $('#companylocation').val();
			var functionmode = $('#modeselect').val();
			var terminal = $('#terminal').val();

			if(company == 0 || location == 0 || functionmode == 0 || terminal == 0)
			{
				$('#errormsg').show();
				toastr.error("All fields are required");
	            $('#errormsg').html("All fields are required");
				return false;
			}
		}		

		var data = $('#oposlogin').serialize();

        $.ajax({
            type: "POST",
            url: url,
            data:data,
            beforeSend: function(){},
            success: function(response){
            	// console.log(response);
            	if(response.status === "success"){
            		$('#loggedid').val(response.user_id);
            		if(response.isvalid == 1)
            		{
            			toastr.success("Login Successfully");
            			// if($('#isfromlocal').val() == 0)
            			// {
            			// 	localStorage.setItem('opossumlogin_selected_company', JSON.stringify({id:$('#fairmerchant1').val(), name:$('#fairmerchant1 option:selected').text()}));

	            		// 	localStorage.setItem('opossumlogin_selected_location', JSON.stringify({id:$('#companylocation').val(), name:$('#companylocation option:selected').text()}));

	            		// 	localStorage.setItem('opossumlogin_selected_functionmode', JSON.stringify({id:$('#modeselect').val(), name:$('#modeselect option:selected').text()}));

	            		// 	localStorage.setItem('opossumlogin_selected_terminal', JSON.stringify({id:$('#terminal').val(), name:$('#terminal option:selected').text()}));

	            		// 	window.location = JS_BASE_URL+"/opossum/" + $('#terminal').val();
            			// }
            			// else
            			// {
            				// window.location = JS_BASE_URL+"/opossum/" + $('#terminalid').val();
            			// }
            			
            			if($('#isfromlocal').val() == 1)
            			{
            				saveLocalData();
            				$('#reLoginModal').modal('show');
            				// window.location = JS_BASE_URL+"/opossum/" + $('#terminal').val();
            			}
            			else
            			{
            				getCompanyData(response.user_id);            				
            			}
            			$('#errormsg').html("");            			
            		}
            		else {
            			$('#errormsg').show();
            			$('#errormsg').html("Unauthorized Access");
            			$('#accessModal').modal('show');            			
            		}            		
            	} else {
            		$('#errormsg').show();
            		$('#errormsg').html(response.long_message);
            		toastr.error("Incorrect Email or Password");
            	}
            }
        });
	});

	function getCompanyData($user_id) {
		$.ajax({
			url:JS_BASE_URL+"/getCompanyData/"+$user_id,
			type:"GET",
			success:function (r) {
				localStorage.setItem('opossumlogin_all_company', JSON.stringify(r.data.fairmerchant));
				localStorage.setItem('opossumlogin_all_function', JSON.stringify(r.data.functionmode));
				// var htmlrow="<option value=0>Select Company *</option>";
				// var functionraw="<option value=0>Select Function *</option>";
				// var functionraw="";
				if (r.status==="success") {
					createCompanyDropDown(r.data.fairmerchant);
					createFunctionDropDown(r.data.functionmode);

					// for (var i = r.data.fairmerchant.length - 1; i >= 0; i--) {
					// 	row=r.data.fairmerchant[i]
					// 	htmlrow+=`
					// 		<option
					// 		value="`+row.company_id+`"
					// 		>`+row.company_name+`</option>`;
					// }
					// for (var i = r.data.functionmode.length - 1; i >= 0; i--) {
					// 	row=r.data.functionmode[i]
					// 	functionraw+=`
					// 		<option
					// 		value="`+row.id+`"
					// 		>`+row.value+`</option>`;
					// }

					// $("#fairmerchant1").html(htmlrow);
					// $("#modeselect").html(functionraw);
					$('.showCompany').show();
					$(".signInBtnnew").hide();
					$('#validateotherdata').show();
				}
			}
		})
	}

	function createCompanyDropDown(companydata,selectedid=null)
	{	
		var htmlrow='<option value=0>Select Company *</option>';
		for (var i = companydata.length - 1; i >= 0; i--) {
			row=companydata[i]
			if(row.company_id == selectedid)
			{
				htmlrow+=`<option value="`+row.company_id+`" selected>`+row.company_name+`</option>`;
			}
			else
			{
				htmlrow+=`<option value="`+row.company_id+`">`+row.company_name+`</option>`;
			}			
		}
		return $("#fairmerchant1").html(htmlrow); ;
	}

	function createFunctionDropDown(functiondata,selectedid=null)
	{	
		var htmlrow='<option value=0>Select Function *</option>';
		for (var i = functiondata.length - 1; i >= 0; i--) {
			row=functiondata[i]
			if(row.id == selectedid)
			{
				htmlrow+=`<option value="`+row.id+`" selected>`+row.value+`</option>`;
			}
			else
			{
				htmlrow+=`<option value="`+row.id+`">`+row.value+`</option>`;
			}			
		}
		return $("#modeselect").html(htmlrow); ;
	}

	function createLocationDropDown(locationdata,selectedid=null)
	{	
		var htmlrow='<option value=0>Select Location *</option>';
		for (var i = locationdata.length - 1; i >= 0; i--) {
			row=locationdata[i]
			if(row.location_id == selectedid)
			{
				htmlrow+=`<option value="`+row.location_id+`" selected
				>`+row.location+`</option>`;
			}
			else
			{
				htmlrow+=`<option value="`+row.location_id+`">`+row.location+`</option>`;
			}
			
		}
		return $("#companylocation").html(htmlrow); ;
	}

	function createTerminalDropDown(terminaldata,selectedid=null)
	{	
		var htmlrow='<option value=0>Select Terminal *</option>';
		for (var i = terminaldata.length - 1; i >= 0; i--) {
			row=terminaldata[i]
			if(row.id == selectedid)
			{
				htmlrow+=`<option value="`+row.id+`" selected>`+row.name+`</option>`;
			}
			else
			{
				htmlrow+=`<option value="`+row.id+`">`+row.name+`</option>`;
			}			
		}
		return $("#terminal").html(htmlrow); ;
	}

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
				localStorage.setItem('opossumlogin_all_location', JSON.stringify(r.data));
				// var htmlrow="<option value=0>Select Location *</option>";
				if (r.status==="success") {
					createLocationDropDown(r.data);
					// for (var i = r.data.length - 1; i >= 0; i--) {
					// 	row=r.data[i]
					// 	htmlrow+=`
					// 		<option
					// 		value="`+row.location_id+`"
					// 		>`+row.location+`</option>`;
					// }
					// $("#companylocation").html(htmlrow);
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
				localStorage.setItem('opossumlogin_all_terminal', JSON.stringify(r.data));
				createTerminalDropDown(r.data);
				// var htmlrow="<option value=0>Select Terminal *</option>";
				// if (r.status==="success") {
				// 	for (var i = r.data.length - 1; i >= 0; i--) {
				// 		row=r.data[i]
				// 		htmlrow+=`
				// 			<option value="`+row.id+`">`+row.name+`</option>`;
				// 	}
				// 	$("#terminal").html(htmlrow);
				// }
			}
		})
	}

	function getaccess(){
		$('#accessModal').modal('hide');
		$('#isfromlocal').val(0);
		removeLocalData('all');
		window.location = JS_BASE_URL+"/opossumLogin";
		// $('#errormsg').html("");
		// $('.showLocalData').hide();
		// $('.showCompany').show();
	}

	function reLogin()
	{
		$('#reLoginModal').modal('hide');
		 window.location = JS_BASE_URL+"/opossumLogin/verification";
	}

	function removeLocalData(flag='')
	{
		localStorage.removeItem("opossumlogin_selected_company");
		localStorage.removeItem("opossumlogin_selected_functionmode");
		localStorage.removeItem("opossumlogin_selected_location");
		localStorage.removeItem("opossumlogin_selected_terminal");
		if(flag == 'all')
		{
			localStorage.removeItem("opossumlogin_all_company");
			localStorage.removeItem("opossumlogin_all_function");
			localStorage.removeItem("opossumlogin_all_location");
			localStorage.removeItem("opossumlogin_all_terminal");
		}
		
	}

	function saveLocalData()
	{
		removeLocalData();
		localStorage.setItem('opossumlogin_selected_company', JSON.stringify({id:$('#fairmerchant1').val(), name:$('#fairmerchant1 option:selected').text()}));

		localStorage.setItem('opossumlogin_selected_location', JSON.stringify({id:$('#companylocation').val(), name:$('#companylocation option:selected').text()}));

		localStorage.setItem('opossumlogin_selected_functionmode', JSON.stringify({id:$('#modeselect').val(), name:$('#modeselect option:selected').text()}));

		localStorage.setItem('opossumlogin_selected_terminal', JSON.stringify({id:$('#terminal').val(), name:$('#terminal option:selected').text()}));
	}

	function validateotherdatafun()
	{
		var url =  JS_BASE_URL+"/validateOpossumLoginData";

		// if($('#isfromlocal').val() == 0)
		// {
			var company = $('#fairmerchant1').val();
			var location = $('#companylocation').val();
			var functionmode = $('#modeselect').val();
			var terminal = $('#terminal').val();

			if(company == 0 || location == 0 || functionmode == 0 || terminal == 0)
			{
				$('#errormsg').show();
				toastr.error("All fields are required");
	            $('#errormsg').html("All fields are required");
				return false;
			}
		// }		

		var data = $('#oposlogin').serialize();

        $.ajax({
            type: "POST",
            url: url,
            data:data,
            beforeSend: function(){},
            success: function(response){
            	// console.log(response);            
            		if(response.isvalid == 1)
            		{
            			toastr.success("Authenticated Successfully");
            			// if($('#isfromlocal').val() == 0)
            			// {            				
	            			saveLocalData();
	            			$('#reLoginModal').modal('show');
	            			// window.location = JS_BASE_URL+"/opossum/" + $('#terminal').val();
            		}
            		else {
            			$('#errormsg').show();
            			$('#errormsg').html("Unauthorized Access");
            			$('#accessModal').modal('show');
            		}
            }
        });
	}	

	function dashboard()
	{
		window.location = JS_BASE_URL+"/opossum/" + $('#terminal').val();
	}
</script>
