@extends("common.default")
@section("content")
<section class="">
    <div class="container">
    <!--Begin main cotainer-->
    <div class="row">
        <div class="custom-container">
            <div class="col-sm-12">
                <div style="margin-top:1em;">
                </div>
                {!! Form::open(array('method'=>'POST','url'=>'sellerhelp','class'=>'form-horizontal')) !!}
                <h1>Help the Seller</h1>
                <div class="rcorners2 custom-border-helpseller">
                    <div class="form-group" >
                        <h2 style="margin-left: 15px;">Contact OpenSupermall Support</h2>
                        <h4 style="margin-left: 15px;">Need help? Send your request here through online and we will contact you in short while.</h4>
                        <h3 class="col-xs-12">General Merchant Care Line</h3>
                        <label class="col-sm-2 control-label">+6010-272 0667</label>
                    </div>
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
                    <div class="form-group">
                        <div class="col-sm-3 ">
                            <img src="images/help.jpg" title="banner" class="img-responsive col-xs-12" >
                            <br><br><br><br><br><br>
                            <label class="control-label ">Need Our Help? Contact Us</label>
                            <label class="control-label">+6010-272 0667</label>
                            <label class="control-label">sample@yahoo.com</label>
                            <p style="margin-left:-2px;" ><em>Working hour is 9am to 6pm, Monday to Friday</em></p>
                        </div>
                        <div class="col-sm-8">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" style="margin-top:-9px;">Full Name: </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("name", Input::old("name", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your full name")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" style="margin-top:-9px;">Contact Number: </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("phone", Input::old("phone", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your contact number")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" style="margin-top:-9px;">Email:</label>
                                    <div class="col-sm-8">
                                        {!! Form::text("email", Input::old("email", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your contact number")) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" >
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" style="margin-top:-9px; ">Company Name: </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("company_name", Input::old("company_name", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your company name")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" style="margin-top:-9px;">Reg Number: </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("business_reg_no", Input::old("business_reg_no", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your Reg number")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label " style="margin-top:-9px;">Order ID: </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("order_id", Input::old("order_id", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your Order id")) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Remarks:</label>
                                    <div class="col-sm-9" style="margin-left:1.5em;">
                                        <textarea  class="form-control form-control-color border-color-pink " rows="7" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div style="margin-top:9em;margin-left:1em; ">
                                    <input type="submit"  class="btn-round custom-button-pink" value="Send">
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!--End main cotainer-->
</section>
@stop