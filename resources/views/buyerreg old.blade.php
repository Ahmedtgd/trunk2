<?php $cf = new \App\lib\CommonFunction(); ?>
@extends('common.default')
@section('extra-links')

    <style>
        .imagePreview {
            width: 100%;
            height: 300px;
            background: url("{{asset('images/upload.png')}}");
            background-size: 50% 35%;
            background-position: center center;
            background-repeat: no-repeat;
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            border: 1px solid;
            display: inline-block;
            margin-bottom: 5px;
        }

                .imagePreviewBig {
            width: 100%;
            height: 300px;
            background: url("{{asset('images/upload.png')}}");
            background-size: 75% 25%;
            background-position: center center;
            background-repeat: no-repeat;
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            border: 1px solid;
            display: inline-block;
            margin-bottom: 5px;
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
        }


        /*Important*/

        #drop-zone.mouse-over {
            border: 3px dashed rgba(0, 0, 0, .3);
            color: #7E7E7E;
        }
        /*If you dont want the button*/


        .closeBtn:hover {
            color: red;
            margin-left:8px;
            margin-top:8px;
        }

        .closeBtn {
            margin-left:8px;
            margin-top:8px;
        }





    </style>
@stop
@section('content')
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow"><span class="fa fa-sort"></span></div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active floor-navigation"><a href="#buyer-detail">Buyer Detail</a>
                        </li>
                        {{-- <li role="presentation" class="floor-navigation"><a href="#open-biss">Open Biss</a></li> --}}
                        <li role="presentation" class="floor-navigation"><a href="#smm">SMM</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#confirm">Send</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                    <img src="images/Buyerregistration.png" title="banner" class="img-responsive banner">
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
                    <?php echo Form::open(array('id' => 'form', 'files' => true))?>

                                                {{--End Of col-xs-1--}}
                            <div class="col-xs-12">
                                <div class="col-xs-3 no-padding no-margin">
                                    <div class="imagePreviewBig" id="imagePreview"><span id="closeboton" class="fa fa-times-circle fa-lg closeBtn" title="remove"><input class="uploadimage" type="file" id="photo0" name="photo0"></span></div>
                                </div>
                                <div class="col-xs-3 no-padding no-margin">
                                    <div class="imagePreview" id="imagePreview1" style="height: 150px; margin-bottom: 0px;"><input style="height: 150px;" class="uploadimage" type="file" id="photo1" name="photo1"></div>
                                    <div class="no-padding imagePreview" id="imagePreview2" style="height: 150px; margin-bottom: 5px;"><input style="height: 150px;" class="uploadimage" type="file" id="photo2" name="photo2"></div>
                                </div>
                                <div class="col-xs-3 no-padding no-margin">
                                    <div class="imagePreview" id="imagePreview3" style="height: 150px; margin-bottom: 0px;"><input style="height: 150px;" class="uploadimage" type="file" id="photo3" name="photo3"></div>
                                    <div class="no-padding imagePreview" id="imagePreview4" style="height: 150px; margin-bottom: 5px;"><input style="height: 150px;" class="uploadimage" type="file" id="photo4" name="photo4"></div>
                                </div>
                                <div class="col-xs-3 no-padding no-margin">
                                    <div  class="imagePreview" id="imagePreview5" style="height: 150px; margin-bottom: 0px;"><input style="height: 150px;" class="uploadimage" type="file" id="photo5" name="photo5"></div>
                                    <div class="no-padding imagePreview" id="imagePreview6" style="height: 150px; margin-bottom: 5px;"><input style="height: 150px;" class="uploadimage" type="file" id="photo6" name="photo6"></div>
                                </div>
                            </div>

                    {{--<hr>--}}
                    <div id="buyer-detail">
                        <h6 class="col-xs-12 red-color">{{$special_instruction or ""}}</h6>
                        {{--<h4 class="col-xs-12"><h2>Buyer Information</h2></h4>--}}
                        <div class="row  ">
                            <div class="col-xs-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Username</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Type your email" name="username"
                                               class="form-control col-xs-12" value="{{Input::old("username")}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Password</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="password" placeholder="Type your password" name="password"
                                               class="form-control col-xs-12">
                                    </div>
                                </div>
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Reconfirm</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="password" name="password_confirmation"
                                               placeholder="Retype your password" class="form-control col-xs-12">
                                    </div>
                                </div>
							</div>
                            <div class="col-xs-5">
                                <br><br>
                                <div class="col-xs-12 no-padding ">
									<div class="link-facebook">
									<div class="col-sm-7 text-center" style="margin-bottom:20px;">
									<div class="col-sm-12"></div>
									<a class="popup_fb_token btn btn-block
										btn-facebook col-sm-12" href="#">
										<i class="fa fa-facebook"
											style="margin-left:0px;">
											&nbsp;&nbsp;&nbsp;|&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;
										</i>Sign in with Facebook</a>
									</div>
									<div class="clearfix"></div>
									</div> 
								</div>
							</div>
						</div>

					   <p><hr><p>

                        <div class="row  ">
                            <div class="col-xs-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Name</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-xs-12" name="full_name"
                                               placeholder="*Compulsory" value="{{Input::old("full_name")}}">
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
                                            <input type="radio" checked="" name="salutation" value="Mr"
                                                   id="Mr" class="salt">
                                            <label for="Mr">Mr</label>
                                        </div>
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" checked="" name="salutation" value="Ms"
                                                   id="Ms" class="salt">
                                            <label for="Ms"> Ms</label>
                                        </div>
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" checked="" name="salutation" value="Mrs"
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
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Gender</label>
                                    <div class="col-sm-6 col-xs-12">
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
                                        <select name="language" multiple="multiple" placeholder="Languages" class="form-control col-xs-12">
                                            @if(isset($languages))
                                                @foreach ($languages as $language)
                                                    {{--  {{$language}} --}}
                                                    <option
                                                            value="{{$language->id}}">{{$language->description}}</option>
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
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Annual Income</label>
                                    <div class="col-sm-6 col-xs-12">
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
                                    <label class="col-xs-5 control-label margin-top">Mobile</label>
                                    <div class="col-xs-7">
                                        <input type="text" name="mobile" placeholder="*Required" class="form-control"
                                               value="{{Input::old("mobile")}}">
                                    </div>
                                </div>


                            </div>
                        </div>
                        {{-- 3rd row ends --}}
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Occupation</label>
                                    <div class="col-sm-6 col-xs-12">
                                        {{-- Input One --}}
                                        <select name="occupation" class="form-control col-xs-12 ">
                                            @if(isset($occupations))
                                                @foreach ($occupations as $occupation)
                                                    <option selected="selected"
                                                            value="{{$occupation->id}}">{{$occupation->description}}</option>
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
											<input type="text" id="default1" name="default1" class="form-control">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">&nbsp;</div>
										<div class="col-sm-7">
											<div class="row margin-top">
												<div class="col-sm-2">
													{!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4" >
													<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
														<option value="2">Malaysia</option>
													</select>
												</div>
												<div class="col-sm-2">
													{!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4">
                                                    {!! Form::select('state',[''=>'State']+$cf->getState(), $userModel['city_id'], ['class' => 'form-control validator','id' => 'states']) !!}

												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2">
													{!! Form::label('defaultcity_name', 'City', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4">
													<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="cities" name="defaultcity_name" data-style="btn-green" required>
														<option value="">Choose Option</option>
													</select>
												</div>
												<div class="col-sm-2">
													{!! Form::label('area', 'Area', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4">
                                                    @if(isset($userModel['city_id']))
                                                        {!! Form::select('area', $cf->getArea(), $userModel['city_id'], ['class' => 'form-control']) !!}
                                                    @else
                                                        <select class="form-control validator" id="areas" name="defaultarea_name"
                                                                ></select>
                                                    @endif
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2">
													{!! Form::label('default_postcode', 'Postcode', ['class' => 'control-label','id'=>'default_postcode']) !!}
												</div>
												<div class="col-sm-4">
													<input type="text" name="default_postcode" class="form-control">
												</div>
											</div>
										</div>
									</div>


 									<div class="row margin-top" style="margin-top:-20px">
										<div class="col-sm-2">
											<span><input onclick="FillBilling()" type="checkbox"></span>&nbsp;&nbsp;
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
												<div class="col-sm-2">
													{!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4" >
													<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
														<option value="2">Malaysia</option>
													</select>
												</div>
												<div class="col-sm-2">
													{!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4">
                                                    {!! Form::select('state',[''=>'State']+$cf->getState(), $userModel['city_id'], ['class' => 'form-control validator','id' => 'billing_states']) !!}
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2">
													{!! Form::label('billingcity_name', 'City', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4">
													<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="billing_cities" name="billingcity_name" data-style="btn-green" required>
														<option value="">Choose Option</option>
													</select>
												</div>
												<div class="col-sm-2">

                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}

												</div>
												<div class="col-sm-4">
                                                    @if(isset($userModel['city_id']))

                                                        {!! Form::select('area', $cf->getArea(), $userModel['city_id'], ['class' => 'form-control']) !!}
                                                    @else
                                                        <select class="form-control validator" id="billing_areas" name="billingarea_name"
                                                                ></select>
                                                    @endif
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2">
													{!! Form::label('billing_postcode', 'Postcode', ['class' => 'control-label','id'=>'billing_postcode']) !!}
												</div>
												<div class="col-sm-4">
													<input type="text" name="billing_postcode" class="form-control">
												</div>
											</div>
										</div>
									</div>

 									<div class="row margin-top" style="margin-top:-20px">
										<div class="col-sm-2">
											<span><input onclick="FillDelivery()" type="checkbox"></span>&nbsp;&nbsp;
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
												<div class="col-sm-2">
													{!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4" >
													<select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
														<option value="2">Malaysia</option>
													</select>
												</div>
												<div class="col-sm-2">
													{!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4">
                                                    {!! Form::select('state',[''=>'State']+$cf->getState(), $userModel['city_id'], ['class' => 'form-control validator','id' => 'delivery_states']) !!}
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2">
													{!! Form::label('deliverycity_name', 'City', array('class' => 'control-label')) !!}
												</div>
												<div class="col-sm-4">
													<select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="delivery_cities" name="deliverycity_name" data-style="btn-green" required>
														<option value="">Choose Option</option>
													</select>
												</div>
												<div class="col-sm-2">

                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}

												</div>
												<div class="col-sm-4">
                                                    @if(isset($userModel['city_id']))
                                                        {!! Form::select('area', $cf->getArea(), $userModel['city_id'], ['class' => 'form-control']) !!}
                                                    @else
                                                        <select class="form-control validator" id="delivery_areas" name="deliveryarea_name"
                                                                ></select>
                                                    @endif
												</div>
											</div>
											<div class="row margin-top">
												<div class="col-sm-2">
													{!! Form::label('delivery_postcode', 'Postcode', ['class' => 'control-label','id'=>'delivery_postcode']) !!}
												</div>
												<div class="col-sm-4">
													<input type="text" name="delivery_postcode" class="form-control">
												</div>
											</div>
										</div>

								</div>
							</div>
						</div>

								<hr>
                                <label class="col-sm-12 control-label" style="margin-bottom:20px">
									<i>How Do I Play?</i></label>
								<br>
                                    <div class="col-xs-5 col-md-4">
                                        <a class="btn btn-block btn-blue col-sm-12" href="#"><i
                                                    class="glyphicon glyphicon-tower"></i> Social Media
                                            Marketeer</a>

                                            </br></br></br></br></br></br>

                                        <p class="text-center"><strong>To establish OpenWish and SMM you need to link the
                                                following Social Media</strong></p></br>

                                                </br></br>
                                        <a href="#" class="btn btn-block btn-pink col-sm-12"><i class="fa fa-heart"></i>
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
                                            $('.popup_fb_token').click(function () {
                                                newwindow = window.open("{{URL::route('fbtoken')}}",
													'Link Token', 'height=400,width=auto');
                                                if (window.focus) {
                                                    newwindow.focus()
                                                }
                                                return false;
                                            });

                                        });
                                    </script>
                                    <div class="col-xs-offset-1 col-xs-5 col-md-6">
                                        <label class="col-sm-12 control-label"></label>

                                    <div class="link-facebook">
                                        <label class="col-sm-5 control-label"></label>
                                        <div class="col-sm-7 text-center" style="margin-bottom:20px;">
                                            <div class="col-sm-12"></div>
                                            <a class="popup_fb_token btn btn-block btn-facebook col-sm-12" href="#">
											<i class="fa fa-facebook" style="margin-left:-40px;"></i>
											&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											Sign in with Facebook</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-wechat">
                                        <label class="col-sm-5 control-label"></label>
                                        <div class="col-sm-7 text-center" style="margin-bottom:20px;">
                                            <a class="btn btn-block btn-wechat col-sm-12" href="#">
											<i class="fa fa-weixin" style="margin-left:-52px;"></i>
											&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											Sign in with WeChat</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-twitter">
                                        <label class="col-sm-5 control-label">I wish to link with my:</label>
                                        <div class="col-sm-7 text-center" style="margin-bottom:20px;">
                                            <a class="btn btn-block btn-twitter col-sm-12" href="#">
											<i class="fa fa-twitter" style="margin-left:-52px;"></i>
											&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											Sign in with Twitter</a>
                                        </div>                                                                                           
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-linkedin">
                                        <label class="col-sm-5 control-label"></label>
                                        <div class="col-sm-7 text-center" style="margin-bottom:20px;">
                                            <a class="btn btn-block btn-linkedin col-sm-12" href="#">
											<i class="fa fa-linkedin" style="margin-left:-40px;"></i>
											&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											Sign in with Linked In</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-instagram">
                                        <label class="col-sm-5 control-label"></label>
                                        <div class="col-sm-7 text-center" style="margin-bottom:20px;">
                                            <a class="btn btn-block btn-instagram col-sm-12"
											style="border:0px solid;background-color:#3F729B; color:white;" href="#">
											<i class="fa fa-instagram" style="margin-left:-38px;"></i>
											&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											Sign in with Instagram</a>
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
                {!! Form::label('account_name', 'Account Name', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::text('account_name', null, array('class' => 'validator form-control'))!!}
                </div>
                <div class="clearfix"></div>
                {!! Form::label('account_number', 'Account Number', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::text('account_number', null, array('class' => 'validator form-control'))!!}
                </div>
                <div class="clearfix"></div>
                    {!! Form::label('bank', 'Bank', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::select('bank',[''=>'Bank']+$cf->getBank(), $userModel['city_id'], ['class' => 'form-control validator','id' => 'bank']) !!}
                </div>
               <!-- <div class="clearfix"></div>
                    {!! Form::label('bank_code', 'Bank Code', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::text('bank_code', null, array('class' => 'validator form-control'))!!}
                </div> -->
                <div class="clearfix"></div>
                    {!! Form::label('iban', 'IBAN', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::text('iban', null, array('class' => 'validator form-control'))!!}
                </div>
                <div class="clearfix"></div>
                    {!! Form::label('swift', 'SWIFT', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::text('swift', null, array('class' => 'validator form-control'))!!}
                </div>
            </div>
        </div>
    </div>






                                <div class="pull-right" id="confirm">
                                    <input type="submit" class="btn btn-green btn-lg" value="Send">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div><!--End main cotainer-->


 


                </div>
            </div>
        </div>
		<br>
    </section>
    <script>
        $(document).ready(function () {

            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
                }
            });

            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
            })


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
                format: 'YYYY/MM/DD'
            });
        });
    </script>
    <script type="text/javascript">

        function FillBilling() {
            
            // if (f.fillbill.checked == true) {
           $("#billing1").val($("#default1").val());
           $('select[id="billing_states"]').find('option[value="'+$("#states").val()+'"]').attr("selected",true);
            $( "#billing_states option:selected" ).val($("#states").val());
            $("#select2-billing_states-container option:selected").val($("#states").val());
           
   
        }
        function FillDelivery() {

            // if (f.filldel.checked == true) {
            $("#delivery1").val($("#default1").val());

            // }
            // if (f.billingtoo.checked == #false) {

  val()    // }
        }
        // Salutation

    </script>

    <script type="text/javascript">
        //added by imran
        $(document).ready(function () {
            $('.checkBox').click(function(){
                if($(this).attr("checked")){
                    $(this).removeAttr("checked");
                }else{
                    $(this).attr("checked",true);
                }
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
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Password cannot be left empty"
                            },
                            stringLength: {
                                min: 7,
                                max: 20,
                                message: "The Password must be more than 7 and less than 20 characters"
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
                                message: "The password must be more than 4 and less than 20 characters"
                            }
                        }
                    },

                    mobile: {
                        validators: {
                            notEmpty: {
                                message: "Mobile number is required"
                            },
                            digit: {
                                message: "Mobile number is not valid"
                            }
                        }
                    }
                    ,
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

            });


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
                            }
                            else {
                                $('#cities').empty();
                                $('#select2-cities-container').empty();
                            }
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
                            }
                            else {
                                $('#areas').empty();
                                $('#select2-areas-container').empty();
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

        });

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
                        $("#imagePreview").css({"background-image": "url(" + this.result + ")","background-size":"100% 100%"});
                            $("#imagePreview").find('span').addClass('fa fa-times-circle fa-lg closeBtn');
                                    }
                                    if(id=='photo1'){
                        $("#imagePreview1").css({"background-image": "url(" + this.result + ")","background-size":"100% 100%"});
                                    }
                                    if(id=='photo2'){
                        $("#imagePreview2").css({"background-image": "url(" + this.result + ")","background-size":"100% 100%"});
                                    }
                                    if(id=='photo3'){
                        $("#imagePreview3").css({"background-image": "url(" + this.result + ")","background-size":"100% 100%"});
                                    }
                                    if(id=='photo4'){
                        $("#imagePreview4").css({"background-image": "url(" + this.result + ")","background-size":"100% 100%"});
                                    }
                                    if(id=='photo5'){
                        $("#imagePreview5").css({"background-image": "url(" + this.result + ")","background-size":"100% 100%"});
                                    }
                                    if(id=='photo6'){
                        $("#imagePreview6").css({"background-image": "url(" + this.result + ")","background-size":"100% 100%"});
                                    }
                    }
                }
            });
                        $("#photo1").on("change", function () {
                var files=""
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div
                        $("#imagePreview1").css({"background-image": "url(" + this.result + ")","background-size":"100% 100%"});
                    }
                }
            });
        });
    </script>
@stop
