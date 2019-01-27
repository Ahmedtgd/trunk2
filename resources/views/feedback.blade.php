@section('content')
<div class="container">
  <div class="custom-container">
    <div class="col-sm-12">
      <div style="margin-top:1em;">
      </div>
        <hr>
        <div class="col-lg-12">
           <h2>Feedback</h2>
           <div class="contact-box-blue col-lg-12">
              @if ($errors->any())
              <div class="alert alert-danger">
                 @foreach ($errors->all() as $error)
                 {!! $error !!}<br/>
                 @endforeach
              </div>
              @endif
              @if (Session::has("success"))
              <div class="alert alert-success">
                 {!! Session::get("success") !!}<br/>
              </div>
              @endif
              <div class="row custom-blue-box">
                 <div class="col-lg-12">
                    <h3>Welcome to OpenSupermall.com</h3>
                <!--
                 </div>
                 <p class="small"> <i>Drop down your message, we will serve you better and improve more. Please fill in information below.</i></p>
                 -->
                 <p>Drop down your message, we will serve you better and improve more. Please fill in information below.</p><br>
                 </div>
                 {!! Form::open(array('method'=>'POST','url'=>'feedback','class'=>'form-horizontal')) !!}
                 <div class="col-lg-5">
                    <div class="form-group">
                       <!-- <label for="fullname" class="col-sm-2 control-label">Full Name</label> -->
                       <label for="fullname" class="col-sm-2 control-label">Full&nbsp;Name</label>
                       <div class="col-sm-10">
                          {!! Form::text("name", Input::old("name", false), array("class"=>"form-control form-control-color border-color-blue","placeholder"=>"Type your full name")) !!}
                       </div>
                    </div>
                    <div class="form-group">
                       <label for="Contact" class="col-sm-2 control-label">Contact Number</label>
                       <div class="col-sm-10">
                          {!! Form::text("phone", Input::old("phone", false), array("class"=>"form-control form-control-color border-color-blue","placeholder"=>"Type your contact number")) !!}
                       </div>
                    </div>
                    <div class="form-group">
                       <label for="email" class="col-sm-2 control-label">Email</label>
                       <div class="col-sm-10">
                          {!! Form::text("email", Input::old("email", false), array("class"=>"form-control form-control-color border-color-blue","placeholder"=>"Type your email")) !!}
                       </div>
                    </div>
                    <div class="form-group">
                       <label for="position" class="col-sm-2 control-label">Position</label>
                       <div class="col-sm-10">
                          {!! Form::select("role_id", array(''=>'select position')+$position, null,array("class"=>'form-control border-color-blue')) !!}
                       </div>
                    </div>

                    <div class="form-group">
                      <label for="remark" class="col-sm-2 control-label">Remarks</label>
                      <div class="col-sm-10">
                            <textarea name="remarks" type="text" class="form-control border-color-blue" id="remarks" placeholder="" rows="10" cols="10"> </textarea>
                      </div>
                    </div>
                    <div class="form-group">

                      <label class="col-sm-10">
                          Email: qiaohua.intermedius@gmail.com.
                      </label>
                    </div>


<!--
                    <div class="form-group">
                       <label for="Contact" class="col-sm-2 control-label">Contact Number</label>
                       <div class="col-sm-10">
                          {!! Form::text("phone", Input::old("phone", false), array("class"=>"form-control form-control-color border-color-blue","placeholder"=>"Type your phone")) !!}
                       </div>
                    </div>
-->
                 </div>
                 <div class="col-lg-7">
                    <div class="form-group">
                       <label for="companyname" class="col-sm-5 control-label">Company Name</label>
                       <div class="col-sm-7">
                          {!! Form::text("company_name", Input::old("company_name", false), array("class"=>"form-control form-control-color border-color-blue","placeholder"=>"Type your company_name")) !!}
                       </div>
                    </div>
                    <div class="form-group">
                       <label for="corporatenumber" class="col-sm-5 control-label">Corporate Number</label>
                       <div class="col-sm-7">
                          {!! Form::text("company_phone", Input::old("company_phone", false), array("class"=>"form-control form-control-color  border-color-blue","placeholder"=>"Type your company_phone")) !!}
                       </div>
                    </div>
                    <div class="form-group">
                       <label for="email" class="col-sm-5 control-label">Corporate Email</label>
                       <div class="col-sm-7">
                          {!! Form::text("company_email", Input::old("company_email", false), array("class"=>"form-control form-control-color border-color-blue","placeholder"=>"Type your company_email")) !!}
                       </div>
                    </div>
                    <div class="form-group">
                       <label for="Contact" class="col-sm-5 control-label">Corporate Billing Address</label>
                       <div class="col-sm-7">
                          <textarea name="company_address" type="text" class="form-control border-color-blue" id="Contact" placeholder="" rows="3" cols="10"> </textarea>
                       </div>
                    </div>
                     <div class="form-group">
                         <div class="col-sm-12 text-right">
                             <button type="submit" class="btn btn-default btn-custom-white custom-button-blue floatright">Send</button>
                         </div>
                     </div>
                 </div>
                  <div class="clearfix"> </div> </div>

                 {!! Form::close()  !!}
              </div>
           </div>
        </div>
    </div>
  </div>
</div>
@endsection