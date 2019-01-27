@extends("common.default")
@section("content")
{{--
<link rel="stylesheet" href="css/custom.css">
--}}
<div class="container">
    <div class="custom-container">
        <div class="col-sm-12">
        <div style="margin-top:1em">
        </div>
          <hr>
             <h2 class="page-title">Contact Us</h2>
             <div class="contact-box col-lg-12">
                <div class="row">
                   <div class="col-lg-12">
                      <h3>Welcome to OpenSupermall.com</h3><br><br>
                   </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                   <div class="col-sm-5">
                      <!-- <h5>General Custom Care Line</h5>-->
                      <p class="contact-info">+6010 - 272 0667<br>qiaohua.intermedius@gmail.com</p>
                      <p>
                         <img src="{{URL::to('/')}}/images/ContactUsIphone.jpg" class="img-responsive" alt=""/>
                      </p>
                      <!--
                      <p class="small">
                         <i>Working hour is 9am to 6pm, Monday to Friday</i>
                      </p>
                      -->
                   </div>
                   <div class="col-sm-6">
                      <!-- <p>For enquiry fill in information below</p>-->
                      <p><b>For enquiry fill in information below</b></p>
                      @if (Session::has('success'))
                      <div class="alert alert-success" style="margin-top:10px;">
                         {!! Session::get('success') !!}
                      </div>
                      @endif
                      @if ($errors->any())
                      <div class="alert alert-danger">
                         @foreach ($errors->all() as $error)
                         {!! $error !!}<br/>
                         @endforeach
                      </div>
                      @endif
                      {!! Form::open(array('method'=>'POST','url'=>'contactus','class'=>'form-custom form-horizontal')) !!}
                      <div class="clearfix">
                          <div class="form-group">
                             <label for="fullname" class="col-sm-4 control-label" style="padding-top: 8px">Full Name</label>
                             <div class="col-sm-8">
                                {!! Form::text('name', Input::old('name',false), array('class'=>'form-control border-color-pink','placeholder'=>'Type your name')) !!}
                             </div>
                          </div>

                          <div class="form-group">
                             <label for="contactnumber" class="col-sm-4 control-label" style="padding-top: 17px">Contact Number</label>
                             <div class="col-sm-8">
                                {!! Form::text('phone', Input::old('phone',false), array('class'=>'form-control border-color-pink-for-contact','placeholder'=>'Type your phone')) !!}
                             </div>
                          </div>

                          <div class="form-group">
                             <label for="email" class="col-sm-4 control-label" style="padding-top: 17px">Email</label>
                             <div class="col-sm-8">
                                {!! Form::text('email', Input::old('email',false), array('class'=>'form-control border-color-pink-for-contact','placeholder'=>'Type your email')) !!}
                             </div>
                          </div>
                          <div class="form-group">
                             <label for="remark" class="col-sm-4 control-label" style="padding-top: 17px">Remark</label>
                             <div class="col-sm-8">
                                <textarea name="remarks" type="text" class="form-control border-color-pink-for-contact" id="remark" placeholder="Remarks" cols="10" rows="10"></textarea>
                               <strong>Email:qiaohua.intermedius@gmail.com</strong>
                             </div>
                          </div>
                          <div class="form-group">
                             <div class="text-right col-sm-12" style="padding-top:10px;">
                                <button type="submit" class="btn btn-default btn-custom custom-button-pink">Send</button>
                             </div>
                          </div>
                        </div>
                      {!! Form::close() !!}
                   </div>
                   <div class="clearfix"></div>
                </div>
             </div>
          </div>
        </div>
   </div>
</div>
@stop