<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>Onboarding</title>

      <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<script src="{{asset('/js/jquery.min.js')}}"></script>

  <!-- Latest compiled and minified JavaScript -->
      <script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
<style type="text/css">
    .label_oi{
      margin-top:8px;
    }
    .loadinggif {
    background:url('{{asset("css/ajax-loader.gif")}}') no-repeat right center;
}
</style>
 </head>
 <body>
  
    </div>
   <div class="container">
    <div class="logo-header">
        <div class="container">
            <div class="row">
                <div class="col-md-4  logo-holder pull-left">
                    <a href="{{route('home')}}"><img src="{{asset('images/category/OpenSupermall Official Logo PNG.png')}}" class="img-responsive" alt="Logo"></a>
                </div>
                <div class="col-md-3">&nbsp;</div>
              
    </div>
  <br>
    <div class="col-md-6">    
    <div class="progress">
      <div class="progress-bar active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="background-color:green;"></div>
    </div>
    <div class="step">
        <div class="panel-default panel">
            <div class="panel-heading">Do you have an account?</div>
            <div class="panel-body">
                <a href="#" style="text-decoration: underline;text-align: center;" id="accountExist"><h2>I already have an account! </h2></a>
                <p style=" text-align: center;"> * If you do not have an account , click Next to make one</p>
            </div>
        </div>
    </div>
    <div class="step ">
      <div class="panel panel-default">
        <div class="panel-heading">Tell us about yourself</div>
        <div class="panel-body">
          <label class='label_oi' for="fullName">Full Name</label>
          
          <input type="" name="full_name" id="fullName" class="form-control" @if(!is_null($name)) value="{{$name}}" disabled  @endif>

          <label class='label_oi' for="email">Email</label>
          <input type="email" name="email" id="email_valitation" class="form-control " @if(!is_null($email)) value="{{$email}}" disabled  @else required="required" @endif>
           
          <label class='label_oi error' id="email-error" for="email" style="display:none">Invalid Email</label>
          <label class='label_oi' for="phone">Contact</label>
          <input type="tel" name="phone" id="phone" class="form-control" >
        </div>
      </div>
    </div>
    
    <div class="step">
        <div class="panel panel-default">
        <div class="panel-heading">Set up a password</div>
        <div class="panel-body">
          <label class='label_oi' for="password">Password</label>
          <input type="password" name="password" class="form-control" id="password" required="required">
          <label class='label_oi' for="confirm_password">Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" id="confirm_password" required="required">
        </div>
        </div>
    </div>
    <div class="step">
      <div class="panel panel-default">
          <div class="panel-heading">Where do you live?</div>
          @include('onboarding.address')
      </div>
    </div>
    <div class="step well" id="message_if_any">
      Click on submit to onboard.
    </div>
<button type="button" class="btn btn-default pull-left btn-danger" data-dismiss="modal" data-target="onboardModal" id="cM">Cancel</button>

    <button class="action next btn btn-info pull-right">Next</button>
    <button class="action submit btn btn-success pull-right" id="onboard">Submit</button>
    <button class="action back btn btn-info pull-right" style="margin-right:10px;">Back</button> 

    
   </div> 
   </div>

 </body>
</html>

{{-- Validations --}}
  
{{-- ENDS --}}
<script type="text/javascript">

  function phonenumber(inputtxt)  
    {  
      phone = inputtxt.replace(/[^0-9]/g, '');
    if(phone.length != 10) { 
        contact_error.push("Contact number is not valid");  
    } else {
      // alert("yep, its 10 digits");
      console.log(phone);
    } 
        // var phoneno = /^\d{10}$/;  
        // if(inputtxt.match(phoneno))  
        // {  
        //     return true;  
        // }  
        // else  
        // {  
           
        //    contact_error.push("Contact number is not valid");  
        // }  
    }  
   var errors=[];
   var email_error=[];
   var contact_error=[];
   var password_error=[];
   var s_error=["Please select a state"];
   var c_error=[];
  $(document).ready(function(){
    var current = 1;
    
    widget      = $(".step");
    btnnext     = $(".next");
    btnback     = $(".back"); 
    btnsubmit   = $(".submit");

    // Init buttons and UI
    widget.not(':eq(0)').hide();
    hideButtons(current);
    setProgress(current);

    // Next button click action
    btnnext.click(function(){
      // Hide.
      errors=[];
      var allInputs=$('.step:eq('+(current-1)+')').find("input");  
    
      // if (1==1) {console.log("Lol");}
      allInputs.each(function(index,elem){
        if (current>0) {
          
            if ($(elem).val().length===0) {
                errors.push("Please fill in all inputs");
            }
            if($(elem).attr('id')=="phone"){
              
                contact_error=[];
                phonenumber($(elem).val());
            }
            if ($(elem).attr('id')=="confirm_password") {
                password_error=[];
                if ($('#password').val()!=$('#confirm_password').val()) {
                  password_error.push("Your password do not match");
                }
                if ($('#password').val().length<7) {
                  password_error.push("Your password must have more than 7 characters");
                }
            }
            // alert($(elem).attr('id'));
            
            // if ($(elem).attr('id')=="") {c_error=[];}
        } 
      });
      allInputs=$('.step:eq('+(current-1)+')').find("select");
      allInputs.each(function(index,elem){
        if ($(elem).attr('id')=="city") {c_error=[];
              
              if($(elem).val()==""){
                c_error.push("Please select a city");
              }
            }
      });
      // console.log(confirm_password.length);
      if (errors.length>0 ) {
        // bad validation Block
          alert(errors[0]);
      } 
      else if(email_error.length>0){
        alert(email_error[0]);
      }
      else if (contact_error.length>0){
          alert(contact_error[0]);
      }
      else if(password_error.length>0){
        alert(password_error[0]);
      }
      else if (s_error.length>0 && current==4){
        alert(s_error[0]);
      }
      else if (c_error.length>0 && current==4){
        alert(c_error[0]);
      }
      else {
         if(current < widget.length){
            // console.log($('.next:eq('+current+')'))
            widget.show();
            widget.not(':eq('+(current++)+')').hide();
            setProgress(current);
          }
          hideButtons(current);
      }
     
    })

    // Back button click action
    btnback.click(function(){
      errors=[];
      if(current > 1){
        current = current - 2;
        btnnext.trigger('click');
      }
      hideButtons(current);
    })      
  });

  // Change progress bar action
  setProgress = function(currstep){
    var percent = parseFloat(100 / widget.length) * currstep;
    percent = percent.toFixed();
    $(".progress-bar").css("width",percent+"%").html(percent+"%");    
  }

  // Hide buttons according to the current step
  hideButtons = function(current){
    var limit = parseInt(widget.length); 

    $(".action").hide();

    if(current < limit) btnnext.show();
    if(current > 1) btnback.show();
    if (current == limit) { btnnext.hide(); btnsubmit.show(); }
  }

</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#onboard').click(function(){
      var url="{{url()}}"+"/onboarding/save";
      var type="POST";
      $.ajax({
        url:url,
        type:type,
          data: {
            full_name:$('#fullName').val(),
            email:$('#email_valitation').val(),
            phone:$('#phone').val(),
            password:$('#password').val(),
            password_confirmation:$('#confirm_password').val(),
            city_id:$('#city').val(),
            postcode:$('#postcode').val(),
            address:$('#line1').val(),

          },
          success:function(r){
            if (r.status=="success") {
              $('#message_if_any').text(r.long_message);
              location.reload();
            }
            else{
              console.log(r);
              $('#message_if_any').text(r.long_message );
            }
          }
      }); //ajax
    });//click
  });//document
</script>
<script type="text/javascript">
  function validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
  $("#email_valitation").on("blur",function(){
                email_error=[];
                //Put Spinner
                // $("#overlay_spinner_email").css("display", "block");
                $(this).addClass('loadinggif');
                $("#email-error").css("display", "none");
                $("#email_valitation").removeClass("error");
                $("#submit_button").prop('disabled', false);

                //JS Email Valitation (Required and Well Format)
                var email_v = $("#email_valitation").val();
                if (validateEmail(email_v)) {
                    // $("#email-error").text(email_v + " is valid :)");
                    // $("#email-error").css("color", "green");
                    // $("#email-error").css("display", "block");
                    $.ajax({
                        type: "get",
                        url: JS_BASE_URL + '/validate_email/' + email_v,
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData == "0") {
                                email_error.push("This email is already in use");
                                $("#email-error").text("This email is already in use");
                                $("#email-error").css("color", "red");
                                $("#email_valitation").addClass("error");
                                $("#email-error").css("display", "block");
                                $("confirm").find("input").prop('disabled', 'disabled');
                                $("#submit_button").prop('disabled', 'disabled');
                            }
                            $("#email_valitation").removeClass('loadinggif');
                             // $("#overlay_spinner_email").css("display", "none");
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });

                } else {
                    $("#email-error").text("Invalid format email");
                    $("#email-error").css("color", "red");
                    $("#email_valitation").addClass("error");
                    $("#email-error").css("display", "block");
                    $("#overlay_spinner_email").css("display", "none");
                    $("#submit_button").prop('disabled', 'disabled');
                }
            });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#accountExist').click(function(e){
      e.preventDefault();
      $('#cM').click();
      $('#loginModal').modal('show');
      // $('#onboardModal').modal('hide');
      
    });
  });
</script>