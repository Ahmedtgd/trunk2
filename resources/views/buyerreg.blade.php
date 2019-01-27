<?php $cf = new \App\lib\CommonFunction(); 
use App\Http\Controllers\UtilityController;
?>
@extends('common.default')
@section('extra-links')

<style>
.help-block{
	color: red;
}
.imagePreview {
	width: 100%;
	height: 300px;
	background: url("{{asset('images/upload.png')}}");
	background-size: 50% 35%;
	background-position: center center;
	background-repeat: no-repeat;
	-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
	background-color: #e7e7e7;
	border: 1px solid #d0d0d0 ;
	display: inline-block;
	margin-bottom: 5px;
	border-color: #d0d0d0;
}

.imagePreviewBig {
	width: 100%;
	height: 300px;
	background: url("{{asset('images/upload.png')}}");
	background-size: 75% 25%;
	background-position: center center;
	background-repeat: no-repeat;
	-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
	background-color: #e7e7e7;
	border: 1px solid #d0d0d0 ;
	display: inline-block;
	margin-bottom: 5px;
	border-color: #d0d0d0;
}

.btn-file {
	position: relative;
	overflow: hidden;
}

.btn-file input[type=text] {
	position: absolute;
	top: 0;
	right: 0;
	min-width: 100%;
	min-height: 100%;
	font-size: 100px;
	text-align: right;
	filter: alpha(opacity=0);
	opacity: 0;
	outline: none;
	background: white;
	cursor: inherit;
	display: block;
}

.imagePreview input,.imagePreviewBig input {
   filter: alpha(opacity=0);
   opacity: 0;
	width: 100%;
	height: 300px;
	background-position: center center;
	background-size: cover;
	display: inline-block;
	cursor: pointer;
	background-color: #e7e7e7;
	border-color: #d0d0d0;
}

.closeBtn:hover {
	color: red;
}
@media only screen and (max-width: 400px) {
	#tabbing{
		display: none !important;
	}
	.margin-top{
		margin: 0px !important;
	}
	.btn-blue{
		font-size: 0.8em !important;
	}
	.btn-blue, .btn-pink{
		font-size: 0.8em !important;
	}
	.nomarginbot{
		margin-bottom: 0px !important;
	}
}
</style>
@stop
@section('content')
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" id="tabbing" class="static-tab">
                    <div class="text-center tab-arrow"><span class="fa fa-sort"></span></div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active floor-navigation"><a href="#buyer-detail">Buyer Detail</a>
                        </li>
                        {{-- <li role="presentation" class="floor-navigation"><a href="#open-biss">Open Biss</a></li> --}}
                        <li role="presentation" class="floor-navigation"><a href="#smm">SMM</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#confirm">Send</a></li>
                    </ul>
                </div>
                <div class="col-sm-12">
                    <h1>Buyer</h1>
                    <hr/>
                     {{--End Of col-xs-7--}}

                    <h2>Buyer Information</h2>
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }} </div>
                        @endforeach
                    @endif

                    {{-- <form action="/buyerreg" method="Post" class="form-horizontal"> --}}
                    <?php echo Form::open(array('id' => 'form', 'files' => true));?>

                                                {{--End Of col-xs-1--}}
                            <div class="col-sm-12">
                                <div class="col-sm-3 no-padding no-margin">
                                    <div class="imagePreviewBig" id="imagePreview">
                                        <div class="Xphoto closeBtn" id="Xphoto0" style="cursor:pointer; display:none; width:20px; margin-left:92%;">
                                            <span id="closeboton" class="fa fa-times-circle fa-lg " title="remove"></span>
                                        </div>
                                        <input class="uploadimage" type="file" id="photo0" name="photo0">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12 no-padding no-margin">
									<div class="col-sm-12 col-xs-6 no-padding">
										<div class="imagePreview" id="imagePreview1" style="height: 150px; margin-bottom: 0px; ">
											<div class="Xphoto closeBtn" id="Xphoto1" style="cursor:pointer; display:none; width:20px; margin-left:92%;">
												<span id="closeboton" class="fa fa-times-circle fa-lg " title="remove"></span>
											</div>
											<input style="height: 150px;" class="uploadimage" type="file" id="photo1" name="photo1">
										</div>
                                    </div>
									<div class="col-sm-12 col-xs-6 no-padding">
										<div class="no-padding imagePreview" id="imagePreview2" style="height: 150px; margin-bottom: 5px;">
											<div class="Xphoto closeBtn" id="Xphoto2" style="cursor:pointer; display:none; width:20px; margin-left:92%;">
												<span id="closeboton" class="fa fa-times-circle fa-lg " title="remove"></span>
											</div>
											<input style="height: 150px;" class="uploadimage" type="file" id="photo2" name="photo2">
										</div>
									</div>
                                </div>
                                <div class="col-sm-3 col-xs-12 no-padding no-margin">
									<div class="col-sm-12 col-xs-6 no-padding">
										<div class="imagePreview" id="imagePreview3" style="height: 150px; margin-bottom: 0px;">
											<div class="Xphoto closeBtn" id="Xphoto3" style="cursor:pointer; display:none; width:20px; margin-left:92%;">
												<span id="closeboton" class="fa fa-times-circle fa-lg " title="remove"></span>
											</div>
											<input style="height: 150px;" class="uploadimage" type="file" id="photo3" name="photo3">
										</div>
									</div>
									<div class="col-sm-12 col-xs-6 no-padding">
										<div class="no-padding imagePreview" id="imagePreview4" style="height: 150px; margin-bottom: 5px;">
											<div class="Xphoto closeBtn" id="Xphoto4" style="cursor:pointer; display:none; width:20px; margin-left:92%;">
												<span id="closeboton" class="fa fa-times-circle fa-lg " title="remove"></span>
											</div>
											<input style="height: 150px;" class="uploadimage" type="file" id="photo4" name="photo4">
										</div>
									</div>
                                </div>
                                <div class="col-sm-3 col-xs-12 no-padding no-margin">
									<div class="col-sm-12 col-xs-6 no-padding">
										<div  class="imagePreview" id="imagePreview5" style="height: 150px; margin-bottom: 0px;">
											<div class="Xphoto closeBtn" id="Xphoto5" style="cursor:pointer; display:none; width:20px; margin-left:92%;">
												<span id="closeboton" class="fa fa-times-circle fa-lg " title="remove"></span>
											</div>
											<input style="height: 150px;" class="uploadimage" type="file" id="photo5" name="photo5">
										</div>
									</div>
									<div class="col-sm-12 col-xs-6 no-padding">
										<div class="no-padding imagePreview" id="imagePreview6" style="height: 150px; margin-bottom: 5px;">
											<div class="Xphoto closeBtn" id="Xphoto6" style="cursor:pointer; display:none; width:20px; margin-left:92%;">
												<span id="closeboton" class="fa fa-times-circle fa-lg " title="remove"></span>
											</div>
											<input style="height: 150px;" class="uploadimage" type="file" id="photo6" name="photo6">
										</div>
									</div>

                                </div>
                            </div>

                    {{--<hr>--}}
                    <div id="buyer-detail">
                        <h6 class="col-xs-12 red-color">{{$special_instruction or ""}}</h6>
                        {{--<h4 class="col-xs-12"><h2>Buyer Information</h2></h4>--}}
                        <div class="row  ">
                            <div class="col-sm-7">
                                <div class="col-xs-12 no-padding">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top"><span style="color: red; font-weight: normal">*</span>Username</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" required name="username"
                                               class="form-control col-xs-12" value="{{Input::old('username')}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top"><span style="color: red; font-weight: normal">*</span>Email</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" name="email" id="email_valitation"
                                               class="form-control col-xs-12" value="{{Input::old('email')}}">
                                        <span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold;" class="all-filter-fa" id="overlay_spinner_email" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>
                                        <label id="email-error" class="error" for="email" style="display:none">Invalid Email</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top"><span style="color: red; font-weight: normal">*</span>Password</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="password" placeholder="Type your password" required="" name="password"
                                               class="form-control col-xs-12">
                                    </div>
								{{-- 	<div class="col-sm-3 text-right"
										style="margin-top: 8px; margin-left: px; padding-right: 0px;">
									<b>OR</b> Sign In with
									</div> --}}
                                </div>
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top"><span style="color: red; font-weight: normal">*</span>Reconfirm</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="password" name="password_confirmation" required=""
                                               placeholder="Retype your password" class="form-control col-xs-12">
                                    </div>
                                </div>
							</div>
							{{--
                            <div class="col-xs-5">
                                <br><br>
                                <div class="col-xs-12 no-padding ">
									<div class="link-facebook">
									<div class="col-sm-5 text-center" style="margin-bottom:20px;">
									<div class="col-sm-12"></div>
									<a class=" btn btn-block
										btn-facebook col-sm-12"  href="javascript:void(0);" title="In future users can login through social media accounts" 

                                        >
										<i class="fa fa-facebook"
											style="margin-left:-10px;">
											&nbsp;&nbsp;&nbsp;|&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;
										</i>Facebook</a>
									</div>
									<div class="clearfix"></div>
									</div>
								</div>
							</div>
							--}}
						</div>

					   <p><hr><p>

                        <div class="row  ">
                            <div class="col-sm-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top"><span style="color: red; font-weight: normal">*</span>Name</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-xs-12" name="full_name"
                                               required value="{{Input::old('full_name')}}">
                                    </div>
                                </div>
                            </div>

                            {{--End Of col-xs-7--}}
                        </div>
                        {{--End Of row --}}
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label">Salutation</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" checked="checked" name="salutation" value="Mr"
                                                   id="Mr" class="salt">
                                            <label for="Mr">Mr</label>
                                        </div>
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" name="salutation" value="Ms"
                                                   id="Ms" class="salt">
                                            <label for="Ms"> Ms</label>
                                        </div>
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" name="salutation" value="Mrs"
                                                   id="Mrs" class="salt">
                                            <label for="Mrs">Mrs</label>
                                        </div>
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" name="salutation" value="option1" id="Other"
                                                   class="salt">
                                            <label for="Other"> Other</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="radio radio-green radio-inline">
                                            <input type="text" id="otherinput" name="otherinput" class="form-control">
                                        </div>
                                    </div>
                                    {{--    </div> --}}
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-xs-5 control-label margin-top">Date Of Birth:</label>
                                    <div class="col-xs-7">
                                        <input type="text" name="dob" id='dob' placeholder="dd/mm/year"
                                               class="date form-control" value="{{Input::old("dob")}}">
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-5 control-label margin-top">Gender</label>
                                    <div class="col-sm-6 col-xs-7">
                                        <select name="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    {{--    </div> --}}


                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-xs-5 control-label margin-top">Language</label>
                                    <div class="col-xs-7">
                                        <select MULTIPLE name="language[]" required="" placeholder="*Required" class="form-control col-xs-12">
                                            @if(isset($languages))

                                                @foreach ($languages as $language)
                                                    {{--  {{$language}} --}}

                                                    @if (Input::old('language[]') == $language->id)
                                                  <option value="{{ $language->id }}" selected>{{ $language->description }}</option>
                                                    @else
                                                          <option value="{{ $language->id }}">{{ $language->description }}</option>
                                                    @endif
                                                    }
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>
                        {{-- 2nd row ends --}}
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-5 control-label margin-top">Annual Income</label>
                                    <div class="col-sm-6 col-xs-7">
                                        <select name="income" class="form-control col-xs-12 ">
                                            <option value="<30k"> < 30,000</option>
                                            <option value="30-49k">30,000 - 49,999</option>
                                            <option value="50-59k">50,000 - 59,999</option>
                                            <option value="60-75k">60,000 - 74,999</option>
                                            <option value="75-99k">75,000 - 99,999</option>
                                            <option value="100-119k">100,000 - 119,999</option>
                                            <option value="120-149k">120,000 - 149,999</option>
                                            <option value="150-299k">150,000 - 299,999</option>
                                            <option value=">300k"> 300,000</option>
                                        </select>
                                    </div>

                                    {{--    </div> --}}

                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-xs-5 control-label margin-top"><span style="color: red; font-weight: normal">*</span>Mobile</label>
                                    <div class="col-xs-7">
                                        <input type="text" name="mobile" placeholder="Eg: 0121234567" required="" class="form-control"
                                               value="{{Input::old('mobile')}}">
                                    </div>
                                </div>


                            </div>
                        </div>
                        {{-- 3rd row ends --}}
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-5 control-label margin-top">Occupation</label>
                                    <div class="col-sm-6 col-xs-7">
                                        {{-- Input One --}}
                                        <select name="occupation" required="" class="form-control col-xs-12 ">
                                            @if(isset($occupations))
                                                @foreach ($occupations as $occupation)

                                                @if (Input::old('occupation') == $occupation->id)
                                                  <option value="{{ $occupation->id }}" selected>{{ $occupation->description }}</option>
                                                    @else
                                                          <option value="{{ $occupation->id }}">{{ $occupation->description }}</option>
                                                    @endif

                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-xs-5 control-label"></label>
                                    <div class="col-xs-7">
                                        {{-- Input Two --}}
                                    </div>
                                </div>


                            </div>
                        </div>
                        {{-- 4th row ends --}}
                        {{-- 5th row ends --}}

					<br>
                    <div id="shipping-detail" class="col-xs-12">
                        <h2>Delivery</h2>

						 <div id="seller" class="row">
							<div class="row">
								<div class="col-sm-12">
									<div class="row margin-top">
										<div class="col-sm-3">
											<label for="" class="control-label">Default Address</label>
										</div>
										<div class="col-sm-7">
											<input type="text" id="default1" name="default1" class="form-control" required="" value="{{Input::old("default1")}}">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">&nbsp;</div>
										<div class="col-sm-7">
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7" >
													<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
														<option value="150">Malaysia</option>
													</select>
												</div>
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
                                                    {!! Form::select('state',[''=>'State']+$cf->getStateM(), $userModel['city_id'], ['class' => 'form-control', 'required', 'id' => 'states']) !!}

												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('defaultcity_name', 'City', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
													<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="cities" name="defaultcity_name" data-style="btn-green" required disabled>
														<option value="">Choose Option</option>
													</select>
												</div>
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('area', 'Area', array('class' => 'control-label')) !!}
												</div> 
												<div class="col-sm-4 col-xs-7">
                                                    @if(isset($userModel['city_id']))
                                                        {!! Form::select('area', $cf->getArea(), $userModel['city_id'], ['class' => 'form-control', 'required']) !!}
                                                    @else
                                                        <select class="form-control" id="areas" name="defaultarea_name" disabled>
															<option value="">Choose Option</option>
														</select>
                                                    @endif
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('default_postcode', 'Postcode', ['class' => 'control-label','id'=>'default_postcode']) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
													<input required type="text" name="default_postcode" id="default_postcodei" class="form-control" value="{{Input::old("default_postcode")}}">
												</div>
											</div>
										</div>
									</div>


 									<div class="row margin-top" style="margin-top:-20px">
										<div class="col-sm-2">
											<span><input onclick="FillBilling()" id="billingcheck" name="billingcheck" type="checkbox"></span>&nbsp;&nbsp;
											<span>Same as default</span>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">
											<label for="" class="control-label"
											style="padding-left:15px">Billing Address</label>
										</div>
										<div class="col-sm-7">
											<input type="text" id="billing1" name="billing1" class="form-control">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">&nbsp;</div>
										<div class="col-sm-7">
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7" >
													<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
														<option value="150">Malaysia</option>
													</select>
												</div>
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
                                                    {!! Form::select('state',['0'=>'State']+$cf->getStateM(), $userModel['city_id'], ['class' => 'form-control validator','id' => 'billing_states']) !!}
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('billingcity_name', 'City', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
													<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="billing_cities" name="billingcity_name" data-style="btn-green" required disabled>

														<option value="">Choose Option</option>
													</select>
												</div>
												<div class="col-sm-2 col-xs-5">

                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}

												</div>
												<div class="col-sm-4 col-xs-7">
                                                    @if(isset($userModel['city_id']))

                                                        {!! Form::select('area', $cf->getArea(), $userModel['city_id'], ['class' => 'form-control']) !!}
                                                    @else
                                                        <select class="form-control validator" id="billing_areas" name="billingarea_name"
                                                                disabled>
															<option value="">Choose Option</option>
														</select>
                                                    @endif
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('billing_postcode', 'Postcode', ['class' => 'control-label','id'=>'billing_postcode']) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
													<input type="text" name="billing_postcode" id="billing_postcodei" class="form-control" value="{{Input::old("billing_postcode")}}">
												</div>
											</div>
										</div>
									</div>

 									<div class="row margin-top" style="margin-top:-20px">
										<div class="col-sm-2">
											<span><input onclick="FillDelivery()" id="deliverycheck" name="deliverycheck" type="checkbox"></span>&nbsp;&nbsp;
											<span>Same as default</span>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">
											<label for="" class="control-label"
											style="padding-left:15px">Delivery Address</label>
										</div>
										<div class="col-sm-7">
											<input type="text" id="delivery1" name="delivery1" class="form-control">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">&nbsp;</div>
										<div class="col-sm-7">
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7" >
													<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
														<option value="150">Malaysia</option>
													</select>
												</div>
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
                                                    {!! Form::select('state',['0'=>'State']+$cf->getStateM(), $userModel['city_id'], ['class' => 'form-control validator','id' => 'delivery_states']) !!}
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('deliverycity_name', 'City', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
													<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="delivery_cities" name="deliverycity_name" data-style="btn-green" required disabled>
														<option value="">Choose Option</option>
													</select>
												</div>
												<div class="col-sm-2 col-xs-5">

                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}

												</div>
												<div class="col-sm-4 col-xs-7">
                                                    @if(isset($userModel['city_id']))
                                                        {!! Form::select('area', $cf->getArea(), $userModel['city_id'], ['class' => 'form-control']) !!}
                                                    @else
                                                        <select class="form-control validator" id="delivery_areas" name="deliveryarea_name"
                                                                disabled>
															<option value="">Choose Option</option>
														</select>
                                                    @endif
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2 col-xs-5">
													{!! Form::label('delivery_postcode', 'Postcode', ['class' => 'control-label','id'=>'delivery_postcode']) !!}
												</div>
												<div class="col-sm-4 col-xs-7">
													<input type="text" name="delivery_postcode" id="delivery_postcodei" class="form-control" value="{{Input::old('delivery_postcode')}}">
												</div>
											</div>
										</div>

								</div>
							</div>
						</div>

								<hr>
                                <label class="col-xs-12 control-label" style="margin-bottom:20px">
									<i>How Do I Play?</i></label>
										<br class="nomobile">
                                    <div class="col-xs-6 col-md-4">
                                        <a class="btn btn-block btn-blue col-sm-12"><i class=""></i> Social Media
                                            Marketeer</a>

                                            <br class="nomobile"><br class="nomobile"><br class="nomobile"><br class="nomobile"><br class="nomobile"><br class="nomobile">

                                        <p class="text-center nomobile"><strong>To establish OpenWish and SMM you need to link the
                                                following Social Media</strong></p></br>

                                                </br></br>
                                        <a class="btn btn-block btn-pink col-xs-6" style="background-color:#D8E26D;"><i class=""></i>
                                            OpenWish</a>

                                    <br>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function () {


                                            $('.popup_fb_test').click(function () {
                                                newwindow = window.open("{{URL::route('testfbtoken')}}",
													'Token Status', 'height=200,width=350');
                                                if (window.focus) {
                                                    newwindow.focus()
                                                }
                                                setTimeout(function () {
                                                    newwindow
                                                            .close();
                                                }, 30000);
                                                return false;
                                            });
                                          var newwindow;
                                            $('.popup_fb_token').click(function () {
                                                var pc=0;
                                                 newwindow = window.open("{{URL::route('fbtoken')}}",
                                                    'Link Token', 'height=400,width=auto');
                                                if (window.focus) {
                                                    newwindow.focus()
                                                }
                                               var timer = setInterval(function() {   
                                                if(newwindow.closed) {                             
                                                    clearInterval(timer);  
                                                    //do your process here
                                                    toastr.success("Thank you for linking.Please complete rest of the registration process.");
                                                    pc=pc+1;

                                                }  
                                            }, 1000); 
                                               if (pc==1) {
                                                clearInterval(timer);
                                               }
                                                return false;
                                            }); 

                                        });
                                    </script>

                                    <div class="col-sm-offset-1 col-xs-6 col-md-6">
                                        <label class="col-sm-12 control-label nomobile"></label>

                                    <div class="link-facebook">
                                        <label class="col-sm-5 nomobile control-label"></label>
                                        <div class="col-sm-5 text-center nomarginbot" style="margin-bottom:20px;">
                                            <div class="col-sm-12"></div>
                                           <a class="popup_fb_token btn btn-block btn-facebook col-sm-12" href="#">
                                            <i class="fa fa-facebook" style="margin-left:-30px;"></i>
                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Facebook</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-wechat">
                                        <label class="col-sm-5 control-label nomobile"></label>
                                        <div class="col-sm-5 text-center nomarginbot" style="margin-bottom:20px;">
                                            <a style="border:0px solid;background-color:#CCC; color:white;" class="btn btn-block btn-wechat col-sm-12" href="#" disabled>
											<i class="fa fa-weixin" style="margin-left:-40px;"></i>
											<span class="nomobile">&nbsp;&nbsp;</span>&nbsp;|&nbsp;<span class="nomobile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											WeChat</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-twitter">
                                        <label class="col-sm-5 control-label nomobile">I wish to link with my</label>
                                        <div class="col-sm-5 text-center nomarginbot" style="margin-bottom:20px;">
                                            <a style="border:0px solid;background-color:#CCC; color:white;" class="btn btn-block btn-twitter col-sm-12" href="#" disabled>
											<i class="fa fa-twitter" style="margin-left:-40px;"></i>
											<span class="nomobile">&nbsp;&nbsp;</span>&nbsp;|&nbsp;<span class="nomobile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											Twitter</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-linkedin">
                                        <label class="col-sm-5 control-label nomobile"></label>
                                        <div class="col-sm-5 text-center nomarginbot" style="margin-bottom:20px;">
                                            <a style="border:0px solid;background-color:#CCC; color:white;" class="btn btn-block btn-linkedin col-sm-12" href="#" disabled>
											<i class="fa fa-linkedin" style="margin-left:-30px;"></i>
											<span class="nomobile">&nbsp;&nbsp;</span>&nbsp;|&nbsp;<span class="nomobile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											LinkedIn</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-instagram">
                                        <label class="col-sm-5 control-label nomobile"></label>
                                        <div class="col-sm-5 text-center nomarginbot" style="margin-bottom:20px;">
                                            <a class="btn btn-block btn-instagram col-sm-12"
											style="border:0px solid;background-color:#CCC; color:white;" href="#" disabled>
											<i class="fa fa-instagram" style="margin-left:-20px;"></i>
											<span class="nomobile">&nbsp;&nbsp;</span>&nbsp;|&nbsp;<span class="nomobile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											Instagram</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
								<br><hr>

      <div id="receive_method" class="row">
        <div class="col-xs-12">
            <h2>Receive Method</h2>
			<label class="col-sm-12 control-label" style="margin-bottom:20px">
				<i>How Do I Get Paid?</i></label>
        </div>
		<br>
        <div class="col-xs-12">
            <div class="form-group">
                {!! Form::label('account_name', 'Account&nbsp;Name', array('class' => 'col-sm-3 col-xs-5 control-label','style'=>'margin-top:5px')) !!}
                <div class="col-sm-4 col-xs-7">
                    {!! Form::text('account_name', Input::old("account_name"), array('class' => ' form-control'))!!}
                </div>
                <div class="clearfix"></div>
                {!! Form::label('account_number', 'Account&nbsp;Number', array('class' => 'col-sm-3 col-xs-5 control-label','style'=>'margin-top:5px')) !!}
                <div class="col-sm-4 col-xs-7">
                    {!! Form::text('account_number', Input::old("account_number"), array('class' => ' form-control'))!!}
                </div>
                <div class="clearfix"></div>
                    {!! Form::label('bank', 'Bank', array('class' => 'col-sm-3 col-xs-5 control-label','style'=>'margin-top:5px')) !!}
                <div class="col-sm-4 col-xs-7">
                    {!! Form::select('bank',[''=>'Bank']+$cf->getBank(), $userModel['city_id'], ['class' => 'form-control ','id' => 'bank']) !!}
                </div>
               <!-- <div class="clearfix"></div>
                    {!! Form::label('bank_code', 'Bank Code', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::text('bank_code', null, array('class' => ' form-control', 'required'))!!}
                </div> -->
                <div class="clearfix"></div>
                    {!! Form::label('iban', 'IBAN', array('class' => 'col-sm-3 col-xs-5 control-label','style'=>'margin-top:5px')) !!}
                <div class="col-sm-4 col-xs-7">
                    {!! Form::text('iban', Input::old("iban"), array('class' => ' form-control'))!!}
                </div>
                <div class="clearfix"></div>
                    {!! Form::label('swift', 'SWIFT', array('class' => 'col-sm-3 col-xs-5 control-label','style'=>'margin-top:5px')) !!}
                <div class="col-sm-4 col-xs-7">
                    {!! Form::text('swift', Input::old("swift"), array('class' => ' form-control'))!!}
                </div>
            </div>
        </div>
    </div>
		<div class="g-recaptcha pull-right" data-sitekey="6LcXgyMUAAAAAJe2Qb08ADwEyxK1Dbh35aQbl5U6"></div>
		<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
		<div class="clearfix"></div>
		<div class="pull-right" id="captchaMessage">
			
        </div>
		<div class="clearfix"></div>
		<div class="pull-right" id="confirm">
			<input type="submit" class="btn btn-green btn-lg" id="submit_button" value="Submit" > 
		</div>
		</form>
	</div>
</div>
</div><!--End main cotainer-->





                </div>
            </div>
        </div>
		<br>

<!-- Modal -->
<div id="tcModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
 
      <div class="modal-body">
       {{--  --}}
      </div>
    </div>

  </div>
</div>
    </section>
    <script type="text/javascript" src="{{ url() }}/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        $(document).ready(function () {
            $('.openwish').show();

            // *********
            $('#banking').hide();
            $('#paypal').hide();
            $('#debit').show();
            $('.pm').change(function () {
                if (this.value == "paypal") {
                    $('#paypal').show();
                    $('#debit').hide();
                    $('#banking').hide();

                }
                else if (this.value == "online_banking") {
                    $('#banking').show();
                    $('#debit').hide();
                    $('#paypal').hide();
                }
                else if (this.value == "debit") {
                    $('#debit').show();
                    $('#paypal').hide();
                    $('#banking').hide();

                }
                ;
                ;
            });

            $('.date').datetimepicker({
                viewMode: 'days',
                format: 'YYYY/MM/DD',
                maxDate:"{{UtilityController::minDate()}}",
                minDate:"{{UtilityController::maxDate()}}" 
                // Sorry for bad naming above
            });
        });
    </script>
    <script type="text/javascript">

        function FillBilling() {

            // if (f.fillbill.checked == true) {
            if ($('#billingcheck').is(':checked')){
                $("#billing1").val($("#default1").val());
                $("#billing_states").val($("#states").val());

                var cloneCity = $("#cities > option").clone();
                $("#billing_cities").html(cloneCity);
                $("#billing_cities").val($("#cities").val());

                var cloneArea = $("#areas > option").clone();
                $("#billing_areas").html(cloneArea);
                $("#billing_areas").val($("#areas").val());

                $("#billing_postcodei").val($("#default_postcodei").val());
                $("#billing_states").change();
                $("#billing_cities").change();
                $("#billing_areas").change();
                document.getElementById('billing1').disabled = true;
                document.getElementById('billing_states').disabled = true;
				document.getElementById('billing_cities').disabled = true;
                document.getElementById('billing_areas').disabled = true;
                document.getElementById('billing_postcodei').disabled = true;
            }else{
                document.getElementById('billing1').disabled = false;
                document.getElementById('billing_states').disabled = false;
                document.getElementById('billing_cities').disabled =  false;
                document.getElementById('billing_areas').disabled = false;
                document.getElementById('billing_postcodei').disabled = false;
            }
        }
        function FillDelivery() {

            if ($('#deliverycheck').is(':checked')) {
                $("#delivery1").val($("#default1").val());
                $("#delivery_states").val($("#states").val());

                var cloneCity = $("#cities > option").clone();
                $("#delivery_cities").html(cloneCity);
                $("#delivery_cities").val($("#cities").val());

                var cloneArea = $("#areas > option").clone();
                $("#delivery_areas").html(cloneArea);
                $("#delivery_areas").val($("#areas").val());

                $("#delivery_postcodei").val($("#default_postcodei").val());
                $("#delivery_states").change();
                $("#delivery_cities").change();
                $("#delivery_areas").change();

                document.getElementById('delivery1').disabled = true;
                document.getElementById('delivery_states').disabled = true;
                document.getElementById('delivery_cities').disabled = true;
                document.getElementById('delivery_areas').disabled = true;
                document.getElementById('delivery_postcodei').disabled = true;
            }else{
                document.getElementById('delivery1').disabled = false;
                document.getElementById('delivery_states').disabled = false;
                document.getElementById('delivery_cities').disabled = false;
                document.getElementById('delivery_areas').disabled = false;
                document.getElementById('delivery_postcodei').disabled = false;
                }

            // }
            // if (f.billingtoo.checked == #false) {

              // }
        }
        // Salutation

    </script>

    <script type="text/javascript">
        //added by imran
        $(document).ready(function () {

            /* Paul on 12 April 2017 at 11 pm */
            $.ajaxSetup({
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}'
                }
            });
            /* Ends Here */

            $('.checkBox').click(function(){
                if($(this).attr("checked")){
                    $(this).removeAttr("checked");
                }else{
                    $(this).attr("checked",true);
                }
            });

            $("#form").validate(function(){
                ignore: []
            });
       //end function
            $('#form').bootstrapValidator({
                framework: 'bootstrap',
                // Feedback icons
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                onSuccess:function(){
					
                    $("#form").submit(function(e){
                        e.preventDefault();
//						if(grecaptcha.getResponse() == ''){
//							$("#captchaMessage").html("<p style='color: red;'>Invalid Captcha!</p>");
//							setTimeout(function(){ 
//								$("#captchaMessage").html(""); 
//								$("#submit_button").attr('disabled',false);
//							}, 2000);
//						} else {
							var tcModal_url=JS_BASE_URL+"/tc/modal/buy";
							$('#tcModal').modal('show').find('.modal-body').load(tcModal_url);
//						}
                    });
     
                }
                ,
                // fields
                fields: {
                    username: {
                        validators: {
                            notEmpty: {
                                message: "Username cannot be left empty"
                            },
                            stringLength: {
                                min: 7,
                                max: 50,
                                message: "The username must be more than 7 and less than 20 characters"
                            }
                        }
                    }
                    ,
					'g-recaptcha-response': {
						err: '#captchaMessage'
					},
                    language:{
                        validators:{
                            notEmpty:{
                                message:"Language cannot be left empty"
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Password cannot be left empty"
                            },
                            stringLength: {
                                min: 7,
                                max: 20,
                                message: "The Password must be more than 7 and less than 20 characters"
                            },
                            identical: {
                                    field: 'password_confirmation',
                                    message: 'The password and its confirm are not the same'
                                }
                        }
                    }
                    ,
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: "This field cannot be left empty"
                            },
                            stringLength: {
                                min: 7,
                                max: 20,
                                message: "The password must be more than 7 and less than 20 characters"
                            },
                            identical: {
                                    field: 'password',
                                    message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                    dob:{
                        validators:{
                            notEmpty:{
                                message:"Birthdate is compulsory"
                            },

                        }
                    },

                    mobile: {
                        validators: {
                            notEmpty: {
                                message: "Mobile number is required"
                            },
                            digits: {
                                message: "Mobile number is not valid"
                            }
                         }
                     }
                     ,
                     state:{
                        validators:{
                            notEmpty:{
                                message:"State is required"
                            }
                        }
                     },
                     defaultcity_name:{
                        notEmpty:{
                            message:"City is required"
                        }
                     },
                     default1: {
                         notEmpty: {
                             message: "Required"
                         },
                     }
                     ,
                     default2: {
                         notEmpty: {
                             message: "Required"
                         },
                     }
                     ,
                     billing1: {
                         notEmpty: {
                             message: "Required"
                         },
                     }
                     ,
                     billing2: {
                         notEmpty: {
                             message: "Required"
                         },
                     }
                     ,
                     delivery1: {
                         notEmpty: {
                             message: "Required"
                         },
                     }
                     ,
                     delivery2: {
                         notEmpty: {
                             message: "Required"
                         },
                     }
                     ,
                     card_number: {
                         validators: {
                             creditCard: {
                                 message: "The card number is not valid"
                             }
                         }
                     },
                     name_on_card: {
                         validators: {
                             notEmpty: {
                                 message: "Required"
                             }
                         },
                         cvv: {
                             validators: {
                                 creditCardField: 'card_number',
                                 message: 'The cvv is not valid'
                             }
                         },
                         paypal_payee_email: {
                             validators: {
                                 emailAddress: {
                                     message: "Not a valid email"
                                 }
                             }
                         }
                         ,

                     }
                }//fields
                ,
 

             });
        // T
            function validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }

            $("#email_valitation").on("blur",function(){
                //Put Spinner
                $("#overlay_spinner_email").css("display", "block");
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
                                $("#email-error").text("This email is already in use");
                                $("#email-error").css("color", "red");
                                $("#email_valitation").addClass("error");
                                $("#email-error").css("display", "block");
                                $("confirm").find("input").prop('disabled', 'disabled');
                                $("#submit_button").prop('disabled', 'disabled');
                            }
                             $("#overlay_spinner_email").css("display", "none");
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
            // $('#submit_button').click(function(e){
            //     e.preventDefault();


            // });

            $('#states').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#states option:selected').text();
                    $('#states_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/city',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#cities').html(responseData);
                                console.log(responseData);
                            }
                            else {
                                $('#cities').empty();
                                $('#select2-cities-container').empty();
                            }
							document.getElementById('cities').disabled = false;
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-cities-container').empty();
                    $('#cities').html('<option value="" selected>Choose Option</option>');
                }
            });
            $('#billing_states').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#billing_states option:selected').text();
                    $('#states_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/city',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#billing_cities').html(responseData);
                            }
                            else {
                                $('#billing_cities').empty();
                                $('#select2-billing_cities-container').empty();
                            }
							if ($('#billingcheck').is(':checked')){

							} else {
								document.getElementById('billing_cities').disabled = false;
							}
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-billing_cities-container').empty();
                    $('#billing_cities').html('<option value="" selected>Choose Option</option>');
                }
            });
            $('#delivery_states').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#delivery_states option:selected').text();
                    $('#states_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/city',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#delivery_cities').html(responseData);
                            }
                            else {
                                $('#delivery_cities').empty();

                                $('#select2-delivery_cities-container').empty();
                            }
							if ($('#deliverycheck').is(':checked')){
								//Nothing
							} else {
								document.getElementById('delivery_cities').disabled = false;
							}
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-delivery_cities-container').empty();
                    $('#delivery_cities').html('<option value="" selected>Choose Option</option>');
                }
            });

            $('#cities').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#cities option:selected').text();
                    $('#cities_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/area',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#areas').html(responseData);
								document.getElementById('areas').disabled = false;
                            }
                            else {
                                $('#areas').empty();
                                $('#select2-areas-container').empty();
								document.getElementById('areas').disabled = false;
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-areas-container').empty();
                    $('#areas').html('<option value="" selected>Choose Option</option>');
                }
            });

            $('#billing_cities').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#billing_cities option:selected').text();
                    $('#cities_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/area',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#billing_areas').html(responseData);
                            }
                            else {
                                $('#billing_areas').empty();
                                $('#select2-billing_areas-container').empty();
                            }
							if ($('#billingcheck').is(':checked')){

							} else {
								document.getElementById('billing_areas').disabled = false;
							}
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-billing_areas-container').empty();
                    $('#billing_areas').html('<option value="" selected>Choose Option</option>');
                }
            });
            $('#delivery_cities').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#delivery_cities option:selected').text();
                    $('#cities_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/area',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#delivery_areas').html(responseData);
                            }
                            else {
                                $('#delivery_areas').empty();
                                $('#select2-delivery_areas-container').empty();
                            }
							if ($('#deliverycheck').is(':checked')){

							} else {
								document.getElementById('delivery_areas').disabled = false;
							}
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-delivery_areas-container').empty();
                    $('#delivery_areas').html('<option value="" selected>Choose Option</option>');
                }
            });
            /* Paul on 12 April 2017 at 10 50 pm */
        }).ajaxSetup({
            headers: {
                'x-csrf-token': '{{ csrf_token() }}'
            }
        }).ajaxStart(function () {
            //alert("Ajax Started");
            $(".container :input").prop("disabled", true);
        }).ajaxStop(function () {
            $(".container :input").removeAttr('disabled');
            //alert("Ajax Completed");
        });
        /* Ends Here */

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#otherinput').hide();
            $('.salt').change(function () {

                if (this.value == 'option1') {
                    $('#otherinput').show();
                }
                else {

                    $('#otherinput').hide();
                }
                ;
            });
        });

    </script>
    {{-- Bank Account --}}


    <script type="text/javascript">
        $(function () {
            $('.Xphoto').on("click", function () {
                id=$(this).attr('id');
                    if(id=='Xphoto0'){
                        $("#imagePreview").css({"background-image": "url('images/upload.png')","background-size":"75% 25%"});
                        $("#photo0").val('');
                        $("#Xphoto0").css({"display":"none"});
                    }
                    if(id=='Xphoto1'){
                        $("#imagePreview1").css({"background-image": "url('images/upload.png')","background-size":"50% 35%"});
                        $("#photo1").val('');
                        $("#Xphoto1").css({"display":"none"});
                    }
                    if(id=='Xphoto2'){
                        $("#imagePreview2").css({"background-image": "url('images/upload.png')","background-size":"50% 35%"});
                        $("#photo2").val('');
                        $("#Xphoto2").css({"display":"none"});
                    }
                    if(id=='Xphoto3'){
                        $("#imagePreview3").css({"background-image": "url('images/upload.png')","background-size":"50% 35%"});
                        $("#photo3").val('');
                        $("#Xphoto3").css({"display":"none"});
                    }
                    if(id=='Xphoto4'){
                        $("#imagePreview4").css({"background-image": "url('images/upload.png')","background-size":"50% 35%"});
                        $("#photo4").val('');
                        $("#Xphoto4").css({"display":"none"});
                    }
                    if(id=='Xphoto5'){
                        $("#imagePreview5").css({"background-image": "url('images/upload.png')","background-size":"50% 35%"});
                        $("#photo5").val('');
                        $("#Xphoto5").css({"display":"none"});
                    }
                    if(id=='Xphoto6'){
                        $("#imagePreview6").css({"background-image": "url('images/upload.png')","background-size":"50% 35%"});
                        $("#photo6").val('');
                        $("#Xphoto6").css({"display":"none"});
                    }
            });

            $('.uploadimage').on("change", function () {
                id=$(this).attr('id');
                var files=""
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div

                        if(id=='photo0'){
                            $("#imagePreview").css({"background-image": "url(" + this.result + ")","background-size":"cover"});
                            $("#Xphoto0").css({"display":"block"});
                        }
                        if(id=='photo1'){
                            $("#imagePreview1").css({"background-image": "url(" + this.result + ")","background-size":"cover"});
                            $("#Xphoto1").css({"display":"block"});
                        }
                        if(id=='photo2'){
                            $("#imagePreview2").css({"background-image": "url(" + this.result + ")","background-size":"cover"});
                            $("#Xphoto2").css({"display":"block"});
                        }
                        if(id=='photo3'){
                            $("#imagePreview3").css({"background-image": "url(" + this.result + ")","background-size":"cover"});
                            $("#Xphoto3").css({"display":"block"});
                        }
                        if(id=='photo4'){
                            $("#imagePreview4").css({"background-image": "url(" + this.result + ")","background-size":"cover"});
                            $("#Xphoto4").css({"display":"block"});
                        }
                        if(id=='photo5'){
                            $("#imagePreview5").css({"background-image": "url(" + this.result + ")","background-size":"cover"});
                            $("#Xphoto5").css({"display":"block"});
                        }
                        if(id=='photo6'){
                            $("#imagePreview6").css({"background-image": "url(" + this.result + ")","background-size":"cover"});
                            $("#Xphoto6").css({"display":"block"});
                        }
                    }
                }
            });

        });
    </script>
@stop
