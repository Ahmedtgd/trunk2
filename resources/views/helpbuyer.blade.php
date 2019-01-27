@extends("common.default")
@section("content")
<section class="">
    <div class="container">

        <!--Begin main cotainer-->
        <div class="row">
            <div class="custom-container">
                <div class="col-sm-12">
                    {!! Form::open(array('method'=>'POST','url'=>'buyerhelp','class'=>'form-horizontal')) !!}
                    <h1>Help the Buyer</h1>
                    <div class="rcorners2 custom-border-helpbuyer">
                        <div class="form-group">
                            <h2 style="margin-left: 15px;">Contact OpenSupermall support</h2><br>
                            <h4 style="margin-left: 15px;">Need help?Send your request here through online and we will contact you in short while.</h4>
                            <!-- <h3 class="col-xs-12">General Merchant Care Line</h3>-->
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
                        <div class="row">
                            <div class="col-sm-4 ">
                                <img src="images/helpthebuyeriphone.jpg" title="banner" class="img-responsive col-xs-12" >
                                <br><br><br><br><br><br>
                                <!-- <label class="control-label">Need Our Help? Contact Us</label>
                                <label class=" control-label">+6010-272 0667</label> -->
                                <label class="control-label">Need Our Help? Contact Us<br>+603-28569221</label>
                                <label class="control-label">support@opensupermall.com</label>
                                <!-- <p style="margin-left: -2px;"><em>Working hour is 9am to 6pm, Monday to Friday</em></p> -->
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Full Name: </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("name", Input::old("name", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your full name")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Contact&nbsp;Number: </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("phone", Input::old("phone", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your contact number")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Email:</label>
                                    <div class="col-sm-8">
                                        {!! Form::text("email", Input::old("email", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your Email")) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4" >
                                <div class="form-group">
                                    <label class="col-sm-4 control-label form-control-color"> Order ID: </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("order_id", Input::old("order_id", false), array("class"=>"form-control form-control-color border-color-pink","placeholder"=>"Type your order id")) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" >
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Remarks:</label>
                                    <div class="col-sm-8" style="padding:0em;">
                                        <!-- {!! Form::textarea("remarks", Input::old("remarks", false), array("class"=>"form-control form-control-color border-color-pink","    placeholder"=>"Type your order id")) !!}-->
                                        {!! Form::textarea("remarks", Input::old("remarks", false), array("class"=>"form-control form-control-color border-color-pink","    placeholder"=>"")) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="pull-right"> -->
                                <div style="padding-left:1030px;">
                                <!-- <input type="submit" class="btn-round custom-button-pink" value="Send"> -->
                                <button type="submit" class="btn btn-default btn-custom custom-button-pink">Send</button>
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
