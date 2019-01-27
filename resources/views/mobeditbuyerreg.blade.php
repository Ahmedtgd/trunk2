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
    background-color: #e7e7e7;
    border: 1px solid;
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
    border: 1px solid;
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

.btn-mid {
    padding: 5px 12px;
    font-size: 14px;
    line-height: 1.3333333;
    border-radius: 0px;
    margin-right: 15px;
}

</style>
@stop
@section('content')
    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 99%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        
                        <div class="form-group">
                            
                                <label class="col-md-4 control-label">Old password:</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" id="user_oldpass" size="25" />
                                    <span class="text-danger" id="user_oldpass_err"></span> 
                                </div>
                            
                        </div>
                        <input type="hidden" id="useraid" value="{{$userid}}" />
                        <div class="form-group">
                                            
                                <label class="col-md-4 control-label">Enter new password:</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" id="user_pass" size="25" />
                                    <span class="text-danger" id="user_pass_err"></span>
                               </div>     
                            
                        </div>          
                        <div class="form-group">
                                                   
                                <label class="col-md-4 control-label">Reconfirm new password:</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" id="user_passc" size="25" /> 
                                    <span class="text-danger" id="user_passc_err"></span>       
                                </div>    
                            
                        </div>  
                        <div class="form-group">
                            <div class="col-md-12">                     
                                <input type="button" id="change_password" class="btn btn-primary pull-right" value="Save" style="margin-top: 10px;">
                                
                                <p style="color: red; display: none;" id="wrong_pass" style="margin-top: 10px;">Passwords don't match.</p>
                                
                            </div>
                        </div>   
                    </form>                   
                </div>
            </div>
        </div>
    </div>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div id="passworddialog" title="Reset Password" style="display:none">

            </div>          
            <div class="row">
                <div class="col-sm-11 col-sm-offset-1">
                    <h1>Buyer</h1>
                    <hr/>
                     {{--End Of col-xs-7--}}

                    <h2 style="margin-left:15px">Buyer Information</h2>
                    <p style=" display: none;" id="sucess_pass" class="alert alert-success col-md-5">Password successfully changed!</p>
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
                                <div class="col-xs-12 no-padding no-margin">
                                    <div class="imagePreviewBig" id="imagePreview"
                                    <?php if($image[0]!=""){ ?>
                                        style="background-image: url('{{asset($image[0])}}');
                                        background-size:cover; background-position:center top;"
                                    <?php } ?>>
                                        <div class="Xphoto closeBtn"
                                            id="Xphoto0" style="cursor:pointer; margin-left:92%;
                                            <?php if($image[0]!=""){ ?>
                                                display:block;
                                            <?php }else{ ?>
                                                display:none;
                                            <?php } ?>
                                            width:20px;margin-top:2px">
                                            <span id="closeboton"
                                                class="fa fa-times-circle fa-lg "
                                                title="remove">
                                            </span>
                                        </div>
                                        <input class="uploadimage" type="file" id="photo0" name="photo0">
                                        <?php if($image[0]!=""){ ?>
                                        <input type="hidden" id="photo0_old" value="1" name="photo0_old">
                                        <?php }else{ ?>
                                            <input type="hidden" id="photo0_old" value="0" name="photo0_old">
                                            <?php } ?>
                                    </div>
                                </div>
                            </div>

                    {{--<hr>--}}
                    <div id="buyer-detail">
                        <h6 class="col-xs-12 red-color">{{$special_instruction or ""}}</h6>
                        {{--<h4 class="col-xs-12"><h2>Buyer Information</h2></h4>--}}
                        {{--<h6 class="col-xs-12 red-color">Edit your personal details here</h6>--}}
                        <div class="row  ">
                            <div class="col-xs-12">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Email</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" name="email" id="email_valitation"
                                               class="form-control col-xs-12" value="{{$user->email}}">
                                        <span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold;" class="all-filter-fa" id="overlay_spinner_email" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>
                                        <label id="email-error" class="error" for="email" style="display:none">Invalid Email</label>
                                    {{--  --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-xs-12">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Username</label>
                                    <div class="col-sm-6 col-xs-12">

                                        <input type="text" placeholder="Enter your Username" name="username"
                                               class="form-control col-xs-12" value="{{$user->username}}">
                                    </div>
                                </div>
                            </div>
                        </div>
						<br>
						<div class="row">
							<div class="col-xs-12">
                                <div class="col-xs-12 no-padding ">
									<a href="javascript:void(0)" class="btn btn-green btn-mid pull-right" id="change_pass">Change Password</a>
								</div>
                            </div>
                        </div>
                       <p><hr><p>

                        <div class="row  ">
                            <div class="col-xs-12">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Name</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-xs-12" name="full_name"
                                               placeholder="*Compulsory" value="{{$user->name}}">
                                    </div>
                                </div>
                            </div>

                            {{--End Of col-xs-7--}}
                        </div>
                        {{--End Of row --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label">Salutation</label>
                                    <div class="col-sm-6 col-xs-12">


                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" <?php if ($user->salutation == "Mr") {
                                                echo 'checked="checked"';
                                            } ;?> name="salutation" value="Mr"
                                                   id="Mr" class="salt">
                                            <label for="Mr">Mr</label>
                                        </div>
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio"  <?php if ($user->salutation == "Ms") {
                                                echo 'checked="checked"';
                                            } ;?> name="salutation" value="Ms"
                                                   id="Ms" class="salt">
                                            <label for="Ms"> Ms</label>
                                        </div>
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" <?php if ($user->salutation == "Mrs") {
                                                echo 'checked="checked"';
                                            } ?> name="salutation" value="Mrs"
                                                   id="Mrs" class="salt">
                                            <label for="Mrs">Mrs</label>
                                        </div>
                                        <div class="radio radio-green radio-inline">
                                            <input type="radio" <?php if ($user->salutation != "Mr" and $user->salutation != 'Ms' and $user->salutation != 'Mrs') {
                                                echo 'checked="checked"';
                                            } ?> name="salutation" value="option1" id="Other"
                                                   class="salt">
                                            <label for="Other"> Other</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="radio radio-green radio-inline">
                                            <input type="text" id="otherinput" name="otherinput" class="form-control" value=<?php if ($user->salutation != "Mr" and $user->salutation != 'Ms' and $user->salutation != 'Mrs') {
                                                echo $user->salutation;
                                            } ?>>
                                        </div>
                                    </div>
                                    {{--    </div> --}}
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-xs-12 control-label margin-top">Date Of Birth:</label>
                                    <div class="col-xs-12">
                                        <input type="text" name="dob" id='dob' placeholder="dd/mm/year"
                                               class="date form-control" value="{{$dob}}" disabled>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-sm-3 col-xs-12 control-label margin-top">Gender</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <select name="gender" class="form-control" disabled>
                                            <option value="male" <?php if ($user->gender == "male") {
                                                echo 'selected';
                                            } ?>>Male</option>
                                            <option value="female" <?php if ($user->gender == "female") {
                                                echo 'selected';
                                            } ?>>Female</option>
                                            <option value="other" <?php if ($user->gender == "other") {
                                                echo 'selected';
                                            } ?>>Other</option>
                                        </select>
                                    </div>

                                    {{--    </div> --}}


                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="col-xs-12 no-padding ">
                                    <label class="col-xs-12 control-label margin-top">Language</label>
                                    <div class="col-xs-12">
                                        <select MULTIPLE name="language[]" class="form-control col-xs-12">
                                            @if(isset($languages))
                                                @foreach ($languages as $language)
                                                    {{--  {{$language}} --}}
                                                    <option value="{{$language->id}}"
                                                    @foreach ($selectlang as $selectlan)
                                                    <?php if ($selectlan->language_id == $language->id) {
                                                        echo 'selected';
                                                    } ?>
                                                    @endforeach
                                                    >{{$language->description}}</option>@endforeach
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
                                            <option value="<30k" <?php if ($user->annual_income == "<30k") {
                                                echo 'selected';
                                            } ?> > < 30,000
                                            </option>
                                            <option value="30-49k" <?php if ($user->annual_income == "30-49k") {
                                                echo 'selected';
                                            } ?>>30,000 - 49,999
                                            </option>
                                            <option value="50-59k" <?php if ($user->annual_income == "50-59k") {
                                                echo 'selected';
                                            } ?>>50,000 - 59,999
                                            </option>
                                            <option value="60-75k" <?php if ($user->annual_income == "60-75k") {
                                                echo 'selected';
                                            } ?>>60,000 - 74,999
                                            </option>
                                            <option value="75-99k" <?php if ($user->annual_income == "75-99k") {
                                                echo 'selected';
                                            } ?>>75,000 - 99,999
                                            </option>
                                            <option value="100-119k" <?php if ($user->annual_income == "100-119k") {
                                                echo 'selected';
                                            } ?>>100,000 - 119,999
                                            </option>
                                            <option value="120-149k" <?php if ($user->annual_income == "120-149k") {
                                                echo 'selected';
                                            } ?>>120,000 - 149,999
                                            </option>
                                            <option value="150-299k" <?php if ($user->annual_income == "150-299k") {
                                                echo 'selected';
                                            } ?>>150,000 - 299,999
                                            </option>
                                            <option value=">300k" <?php if ($user->annual_income == ">300k") {
                                                echo 'selected';
                                            } ?>> 300,000
                                            </option>
                                        </select>
                                    </div>

                                    {{--    </div> --}}

                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="col-xs-12 ">
                                    <label class="col-12-5 control-label margin-top">Mobile</label>
                                    <div class="col-12-7">
                                        <input type="text" name="mobile" placeholder="*Required" class="form-control"
                                               value="{{$user->mobile_no}}">
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
                                                    <option value="{{$occupation->id}}" <?php if ($user->occupation_id == $occupation->id) {
                                                        echo 'selected';
                                                    } ?>>{{$occupation->description}}</option>
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
                                <div class="col-xs-12">
                                        <div class="col-sm-2">
                                            <label for="" class="control-label">Default Address</label>
                                        </div>
                                        <div class="col-xs-12">
                                            <input type="text" id="default1" name="default1" value="{{$def->line1 or $em}}" class="form-control">
                                        </div>
     

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4" >
                                                    <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
                                                        <option value="150">Malaysia</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                @if($defstate != "")
                                                    <select name="state" placeholder="State" id="states" class="form-control col-xs-12 validator">
                                                        <option value="">Choose Option</option>
                                                            @foreach ($defstateall as $state)
                                                                <option value="{{$state->id}}" <?php if ($defstate->id == $state->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$state->name}}</option>
                                                            @endforeach
                                                    </select>
                                                @else
                                                    {!! Form::select('state',[''=>'State']+$cf->getState(),'', ['class' => 'form-control validator','id' => 'states']) !!}

                                                @endif

                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('defaultcity_name', 'City', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="cities" name="defaultcity_name" data-style="btn-green" required>
                                                        <option value="">Choose Option</option>
                                                            @if(isset($defcity))
                                                            @if ($defcityall!="")
                                                                @foreach ($defcityall as $city)
                                                                    <option value="{{$city->id}}" <?php if ($defcity == $city->id) {
                                                                        echo 'selected';
                                                                    } ?>>{{$city->name}}</option>
                                                                @endforeach
                                                            @endif
                                                            @else
                                                            <option value="">Choose Option</option>
                                                            @endif
                                                    </select>


                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                        <select class="form-control validator" id="areas" name="defaultarea_name">
                                                            <option value="">Choose Option</option>
                                                            @if(isset($defarea))
                                                            @if ($defareall!="")
                                                                @foreach ($defareall as $area)
                                                                    <option value="{{$area->id}}" <?php if ($defarea == $area->id) {
                                                                        echo 'selected';
                                                                    } ?>>{{$area->name}}</option>
                                                                @endforeach
                                                            @endif
                                                            @else
                                                                <option value="">Choose Option</option>
                                                            @endif
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('default_postcode', 'Postcode', ['class' => 'control-label','id'=>'default_postcode']) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" name="default_postcode" id="default_postcode_1" value="{{$def->postcode or $em}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                        $billsame =  0;
                                        $billchecked =  "";
                                        if($def != "" && $bill != ""){
                                            if($def->id == $bill->id){
                                                $billsame =  1;
                                                $billchecked =  "checked";
                                            }                                           
                                        }
                                    ?>
                                    <input type="hidden" id="billsame" value="{{$billsame}}" />
                                    
                                    <div class="row" >
                                        <div class="col-sm-2">
                                            <span><input onclick="FillBilling()" id="billingcheck" name="billingcheck" type="checkbox" {{$billchecked}}></span>&nbsp;&nbsp;
                                            <span><b>Billing Same as default</b></span>
                                        </div>
                                    </div>

                                        <div class="col-sm-3">
                                            <label for="" class="control-label"
                                            >Billing Address</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" id="billing1" name="billing1" value="{{$bill->line1 or $em}}" class="form-control">
                                        </div>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4" >
                                                    <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
                                                        <option value="150">Malaysia</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                 @if ($billstate!="")
                                                    <select name="state" placeholder="State" id="billing_states" class="form-control col-xs-12 validator">
                                                        <option value="">Choose Option</option>
                                                        @if(isset($billstateall) and !empty($billstateall))
                                                            @foreach ($billstateall as $state)
                                                                <option value="{{$state->id}}" <?php if ($billstate->id == $state->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$state->name}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Choose Option</option>
                                                        @endif
                                                    </select>
                                                @else
                                                    {!! Form::select('state',[''=>'State']+$cf->getState(),'', ['class' => 'form-control validator','id' => 'billing_states']) !!}
                                                @endif
                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('billingcity_name', 'City', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="billing_cities" name="billingcity_name" data-style="btn-green" required>
                                                        <option value="">Choose Option</option>
                                                        @if(isset($billcityall) and !empty($billcityall))
                                                            @foreach ($billcityall as $city)
                                                                <option value="{{$city->id}}" <?php if ($billcity == $city->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$city->name}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Choose Option</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">

                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}

                                                </div>
                                                <div class="col-sm-4">
                                                    <select class="form-control validator" id="billing_areas" name="billingarea_name">
                                                        <option value="">Choose Option</option>
                                                        @if(isset($billareall) and !empty($billareall))
                                                            @foreach ($billareall as $area)
                                                                <option value="{{$area->id}}" <?php if ($billarea == $area->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$area->name}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Choose Option</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('billing_postcode', 'Postcode', ['class' => 'control-label','id'=>'billing_postcode']) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" name="billing_postcode" id="billing_postcode_1" value="{{$bill->postcode or $em}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                        $shipsame =  0;
                                        $shipchecked =  "";
                                        if($def != "" && $ship != ""){                                                          
                                            if($def->id == $ship->id){
                                                $shipsame =  1;
                                                $shipchecked =  "checked";
                                            }
                                        } 
                                    ?>
                                    <input type="hidden" id="shipsame" value="{{$shipsame}}" />
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <span><input onclick="FillDelivery()" id="deliverycheck" name="deliverycheck" type="checkbox" {{$shipchecked}}></span>&nbsp;&nbsp;
                                            <span><b>Delivery Same as default</b></span>
                                        </div>
                                    </div>

                                        <div class="col-sm-3">
                                            <label for="" class="control-label"
                                            >Delivery Address</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" id="delivery1" name="delivery1" value="{{$ship->line1 or $em}}" class="form-control">
                                        </div>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4" >
                                                    <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
                                                        <option value="150">Malaysia</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    @if($delstate!="")
                                                    <select name="state" placeholder="State" id="delivery_states" class="form-control col-xs-12 validator">
                                                        <option value="">Choose Option</option>
                                                        @if(isset($delstateall) and !empty($delstateall))
                                                            @foreach ($delstateall as $state)
                                                                <option value="{{$state->id}}" <?php if ($delstate->id == $state->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$state->name}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Choose Option</option>
                                                        @endif
                                                    </select>
                                                    @else
                                                    {!! Form::select('state',[''=>'State']+$cf->getState(),'', ['class' => 'form-control validator','id' => 'delivery_states'])  !!}
                                                @endif

                                                    {{-- Form::select('state',[''=>'State']+$cf->getState(),'', ['class' => 'form-control validator','id' => 'delivery_states']) --}}
                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('deliverycity_name', 'City', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="delivery_cities" name="deliverycity_name" data-style="btn-green" required>
                                                        <option value="">Choose Option</option>
                                                        @if(isset($delcityall) and !empty($delcityall))
                                                            @foreach ($delcityall as $city)
                                                                <option value="{{$city->id}}" <?php if ($delcity == $city->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$city->name}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Choose Option</option>
                                                        @endif
                                                    </select>

                                                </div>
                                                <div class="col-sm-2">

                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}

                                                </div>
                                                <div class="col-sm-4">
                                                    <select class="form-control validator" id="delivery_areas" name="deliveryarea_name">
                                                        <option value="">Choose Option</option>
                                                        @if(isset($delareall) and !empty($delareall))
                                                            @foreach ($delareall as $area)
                                                                <option value="{{$area->id}}" <?php if ($delarea == $area->id) {
                                                                    echo 'selected';
                                                                } ?>>{{$area->name}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Choose Option</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('delivery_postcode', 'Postcode', ['class' => 'control-label','id'=>'delivery_postcode']) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" name="delivery_postcode" id="delivery_postcode_1" value="{{$ship->postcode or $em}}" class="form-control">
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
                                    <div class="col-sm-5 col-md-4">
                                        <a class="btn btn-block btn-blue col-sm-12" href="#"><i
                                                    class=""></i> Social Media
                                            Marketeer</a>

                                                </br>
                                        <a href="#" class="btn btn-block btn-pink  col-sm-12" style="background-color:#D8E26D;"><i class=""></i>
                                            OpenWish</a>

                                    <br>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var billsame = $("#billsame").val();
                                            var shipsame = $("#shipsame").val();
                                            if(billsame == "1"){
                                                FillBilling();
                                            }

                                            if(shipsame == "1"){
                                                FillDelivery();
                                            }                                           
                                            
                                            $('.popup_fb_test').click(function () {
                                                newwindow =
                                                 window.open("{{URL::route('testfbtoken')}}",
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
                                                    toastr.success("Thank you for linking.");
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
                                    <div class="col-sm-offset-1 col-sm-5 col-md-6">
                                        <label class="col-sm-12 control-label"></label>

                                    <div class="link-facebook">
                                        <label class="col-xs-5 no-padding control-label">
                                             @if(isset($buyer_social_url) and !empty($buyer_social_url))
                                      
                                       <input type="text"   value="{{$buyer_social_url}}" class="form-control pull-right" disabled="disabled" style="color: blue;cursor: pointer; width: 100%; margin-top: 1px;">
                                        <div style="position:absolute; left:0; right:0; top:0; bottom:0;" class="buyer_social_url" rel-url="{{$buyer_social_url}}"></div>
                                        
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $('.buyer_social_url').click(function(){
                                                    var url=$(this).attr('rel-url');
                                                    
                                                    win=window.open(url);
                                                    if(win){
                                                        win.focus();
                                                    }
                                                    else{
                                                        toastr.warning("Please allow popups.");
                                                    }
                                                });
                                            });
                                        </script>
                                        
                                        @endif
                                        </label>
                                        <div class="col-xs-7 no-padding " style="margin-bottom:5px;">
                                            <div class="col-sm-12"></div>
                                            <a class="popup_fb_token btn btn-block btn-facebook col-sm-12" href="#">
                                            <i class="fa fa-facebook" style="margin-left:-30px;"></i>
                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Facebook</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-wechat">
                                        <label class="col-sm-5 no-padding control-label"></label>
                                        <div class="col-sm-5 no-padding text-center" style="margin-bottom:5px;">
                                            <a style="border:0px solid;background-color:#CCC; color:white;" class="btn btn-block btn-wechat col-sm-12" href="#" disabled>
                                            <i class="fa fa-weixin" style="margin-left:-40px;"></i>
                                            &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            WeChat</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-twitter">
                                        <label class="col-sm-5 no-padding control-label"></label>
                                        <div class="col-sm-5 no-padding text-center" style="margin-bottom:5px;">
                                            <a style="border:0px solid;background-color:#CCC; color:white;" class="btn btn-block btn-twitter col-sm-12" href="#" disabled>
                                            <i class="fa fa-twitter" style="margin-left:-40px;"></i>
                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Twitter</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-linkedin">
                                        <label class="col-sm-5 no-padding control-label"></label>
                                        <div class="col-sm-5 no-padding text-center" style="margin-bottom:5px;">
                                            <a style="border:0px solid;background-color:#CCC; color:white;" class="btn btn-block btn-linkedin col-sm-12" href="#" disabled>
                                            <i class="fa fa-linkedin" style="margin-left:-30px;"></i>
                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            LinkedIn</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="link-instagram">
                                        <label class="col-sm-5 no-padding control-label"></label>
                                        <div class="col-sm-5 no-padding text-center" style="margin-bottom:5px;">
                                            <a class="btn btn-block btn-instagram col-sm-12"
                                            style="border:0px solid;background-color:#CCC; color:white;" href="#" disabled>
                                            <i class="fa fa-instagram" style="margin-left:-20px;"></i>
                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                {!! Form::label('account_name', 'Account Name', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    @if(isset($banka->account_name1))
                        {!! Form::text('account_name', $banka->account_name1, array('class' => 'validator form-control'))!!}
                    @else
                        {!! Form::text('account_name','', array('class' => 'validator form-control'))!!}
                    @endif
                </div>
                <div class="clearfix"></div>
                {!! Form::label('account_number', 'Account Number', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    @if(isset($banka->account_number1))
                        {!! Form::text('account_number', $banka->account_number1, array('class' => 'validator form-control'))!!}
                    @else
                        {!! Form::text('account_number', '', array('class' => 'validator form-control'))!!}
                    @endif
                </div>
                <div class="clearfix"></div>
                    {!! Form::label('bank', 'Bank', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    @if(isset($banka->bank_id))
                        {!! Form::select('bank',[''=>'Bank']+$cf->getBank(), $banka->bank_id, ['class' => 'form-control validator','id' => 'bank']) !!}
                    @else
                        {!! Form::select('bank',[''=>'Bank']+$cf->getBank(), '', ['class' => 'form-control validator','id' => 'bank']) !!}
                    @endif
                </div>
               <!-- <div class="clearfix"></div>
                    {!! Form::label('bank_code', 'Bank Code', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::text('bank_code', null, array('class' => 'validator form-control'))!!}
                </div> -->
                <div class="clearfix"></div>
                    {!! Form::label('iban', 'IBAN', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    @if(isset($banka->iban))
                        {!! Form::text('iban', $banka->iban, array('class' => 'validator form-control'))!!}
                    @else
                        {!! Form::text('iban', '', array('class' => 'validator form-control'))!!}
                    @endif
                </div>
                <div class="clearfix"></div>
                    {!! Form::label('swift', 'SWIFT', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-4">
                    @if(isset($banka->swift))
                        {!! Form::text('swift', $banka->swift, array('class' => 'validator form-control'))!!}
                    @else
                        {!! Form::text('swift', '', array('class' => 'validator form-control'))!!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br><br>
            {{--<div class="row">--}}
                {{--<div class="col-xs-12">--}}
                    {{--<h3>Close Account</h3>--}}
                {{--</div>--}}
                {{--<div class="col-xs-12" style="margin-left:15px">--}}
                    {{--<span><input id="checkdelete" name="checkdelete" type="checkbox" onclick="deleteaccount()"></span>&nbsp;&nbsp;--}}
                    {{--<span>I wish to close my OpenSupermall account</span>--}}
                    {{--<input type="hidden" id="user_account" value="{{$user->id}}"  />--}}
                {{--</div>      --}}
            {{--</div>  --}}
            <div class="pull-right" id="update">
                <input type="submit" class="btn btn-green btn-lg" value="Update">
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
        function deleteaccount(){
            if($("#checkdelete").is(':checked')){
                toastr.info("Are you sure? All data & information will be irrevocably lost!");
            } 
        }        
        
        $(document).ready(function () {
            $(document).delegate( '#change_pass', "click",function (event) {
                $("#myModal").modal("show");            
            });         
            
             $(document).delegate( '#change_password', "click",function (event) {
                //console.log("passs");
                var userid = $("#useraid").val();
                var oldpassword = $("#user_oldpass").val();
                var password = $("#user_pass").val();
                var cpassword = $("#user_passc").val();
                $("#user_passc_err").html(""); 
                $("#user_pass_err").html(""); 
                $("#user_oldpass_err").html("");
                        var formData = {
                            userid: userid,
                            password: password,
                            password_confirmation : cpassword,
                            old_password: oldpassword
                        }
                        $.ajax({
                            type: "POST",
                            url: JS_BASE_URL + "/changepassword",
                            data: formData,
                            
                            success: function (data) {
                                $("#sucess_pass").show();
                                $('#myModal').modal('toggle');
                                $("#user_oldpass").val("");
                                $("#user_pass").val("");
                                $("#user_passc").val("");                       
                                setTimeout(function(){
                                    
                                    $("#sucess_pass").hide();
                                }, 3000);   
                                                    
                            },
                            error: function (response) {
                                console.log(response.responseJSON.password);
                                $("#user_pass_err").html(response.responseJSON.password);
                                $("#user_oldpass_err").html(response.responseJSON.old_password);
                                $("#user_passc_err").html(response.responseJSON.password_confirmation);
                            }

                        });
                                    
                });                
            
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
            if ($('#billingcheck').is(':checked')){

                $("#billing1").val($("#default1").val());
                $("#billing_states").val($("#states").val());

                var cloneCity = $("#cities > option").clone();
                $("#billing_cities").html(cloneCity);
                $("#billing_cities").val($("#cities").val());

                var cloneArea = $("#areas > option").clone();
                $("#billing_areas").html(cloneArea);
                $("#billing_areas").val($("#areas").val());

                // alert($("#default_postcode_1").val());

                $("#billing_postcode_1").val($("#default_postcode_1").val());
                $("#billing_states").change();
                $("#billing_cities").change();
                $("#billing_areas").change();

                document.getElementById('billing1').disabled = true;
                document.getElementById('billing_states').disabled = true;
                document.getElementById('billing_cities').disabled = true;
                document.getElementById('billing_areas').disabled = true;
                document.getElementById('billing_postcode_1').disabled = true;
            }else{
                document.getElementById('billing1').disabled = false;
                document.getElementById('billing_states').disabled = false;
                document.getElementById('billing_cities').disabled = false;
                document.getElementById('billing_areas').disabled = false;
                document.getElementById('billing_postcode_1').disabled = false;
            }


        }
        function FillDelivery() {

            // if (f.filldel.checked == true) {
            if ($('#deliverycheck').is(':checked')) {

                $("#delivery1").val($("#default1").val());
                $("#delivery_states").val($("#states").val());

                var cloneCity = $("#cities > option").clone();
                $("#delivery_cities").html(cloneCity);
                $("#delivery_cities").val($("#cities").val());

                var cloneArea = $("#areas > option").clone();
                $("#delivery_areas").html(cloneArea);
                $("#delivery_areas").val($("#areas").val());

                $("#delivery_postcode_1").val($("#default_postcode_1").val());
                $("#delivery_states").change();
                $("#delivery_cities").change();
                $("#delivery_areas").change();

                document.getElementById('delivery1').disabled = true;
                document.getElementById('delivery_states').disabled = true;
                document.getElementById('delivery_cities').disabled = true;
                document.getElementById('delivery_areas').disabled = true;
                document.getElementById('delivery_postcode_1').disabled = true;
            }else{
                document.getElementById('delivery1').disabled = false;
                document.getElementById('delivery_states').disabled = false;
                document.getElementById('delivery_cities').disabled = false;
                document.getElementById('delivery_areas').disabled = false;
                document.getElementById('delivery_postcode_1').disabled = false;
            }
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
                                $('#cities').empty();
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
                if (!$('#billingcheck').is(':checked')) {
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
                                    $('#billing_cities').empty();
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
                    }else {
                        $('#select2-billing_cities-container').empty();
                        $('#billing_cities').html('<option value="" selected>Choose Option</option>');
                    }
                }
            });
            $('#delivery_states').on('change', function () {
                if (!$('#deliverycheck').is(':checked')) {
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
                                $('#delivery_cities').empty();
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
                                $('#areas').empty();
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
                                $('#billing_areas').empty();
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
                                $('#delivery_areas').empty();
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

            /* Photo [x] delete button */
            $('.Xphoto').on("click", function () {
                id=$(this).attr('id');
                if(id=='Xphoto0'){
                    $("#imagePreview").css({"background-image":
                        "url('../images/upload.png')",
                        "background-position":"center center",
                        "background-size" :"75% 25%"});
                    $("#photo0").val('');
                    $("#photo0_old").val('2');
                    $("#Xphoto0").css({"display":"none"});
                }
                if(id=='Xphoto1'){
                    $("#imagePreview1").css({"background-image":
                        "url('../images/upload.png')",
                        "background-position":"center center",
                        "background-size":"50% 35%"});
                    $("#photo1").val('');
                    $("#photo1_old").val('2');
                    $("#Xphoto1").css({"display":"none"});
                }
                if(id=='Xphoto2'){
                    $("#imagePreview2").css({"background-image":
                        "url('../images/upload.png')",
                        "background-position":"center center",
                        "background-size":"50% 35%"});
                    $("#photo2").val('');
                    $("#photo2_old").val('2');
                    $("#Xphoto2").css({"display":"none"});
                }
                if(id=='Xphoto3'){
                    $("#imagePreview3").css({"background-image":
                        "url('../images/upload.png')",
                        "background-position":"center center",
                        "background-size":"50% 35%"});
                    $("#photo3").val('');
                    $("#photo3_old").val('2');
                    $("#Xphoto3").css({"display":"none"});
                }
                if(id=='Xphoto4'){
                    $("#imagePreview4").css({"background-image":
                        "url('../images/upload.png')",
                        "background-position":"center center",
                        "background-size":"50% 35%"});
                    $("#photo4").val('');
                    $("#photo4_old").val('2');
                    $("#Xphoto4").css({"display":"none"});
                }
                if(id=='Xphoto5'){
                    $("#imagePreview5").css({"background-image":
                        "url('../images/upload.png')",
                        "background-position":"center center",
                        "background-size":"50% 35%"});
                    $("#photo5").val('');
                    $("#photo5_old").val('2');
                    $("#Xphoto5").css({"display":"none"});
                }
                if(id=='Xphoto6'){
                    $("#imagePreview6").css({"background-image":
                        "url('../images/upload.png')",
                        "background-position":"center center",
                        "background-size":"50% 35%"});
                    $("#photo6").val('');
                    $("#photo6_old").val('2');
                    $("#Xphoto6").css({"display":"none"});
                }
            });

            /* Image upload via FileReader */
            $('.uploadimage').on("change", function () {
                var id=$(this).attr('id');
                var files="";
                var files = !!this.files ? this.files : [];

                // No file selected, or no FileReader support
                if (!files.length || !window.FileReader) return;

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader();  // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () {// set image data as background of div

                        if(id=='photo0'){
                            $("#imagePreview").css({"background-image": "url(" +
                                this.result + ")","background-size":"cover",
                                "background-position":"center top"});
                            $("#Xphoto0").css({"display":"block"});
                        }
                        if(id=='photo1'){
                            $("#imagePreview1").css({"background-image": "url(" +
                                this.result + ")","background-size":"cover",
                                "background-position":"center top"});
                            $("#Xphoto1").css({"display":"block"});
                        }
                        if(id=='photo2'){
                            $("#imagePreview2").css({"background-image": "url(" +
                                this.result + ")","background-size":"cover",
                                "background-position":"center top"});
                            $("#Xphoto2").css({"display":"block"});
                        }
                        if(id=='photo3'){
                            $("#imagePreview3").css({"background-image": "url(" +
                                this.result + ")","background-size":"cover",
                                "background-position":"center top"});
                            $("#Xphoto3").css({"display":"block"});
                        }
                        if(id=='photo4'){
                            $("#imagePreview4").css({"background-image": "url(" +
                                this.result + ")","background-size":"cover",
                                "background-position":"center top"});
                            $("#Xphoto4").css({"display":"block"});
                        }
                        if(id=='photo5'){
                            $("#imagePreview5").css({"background-image": "url(" +
                                this.result + ")","background-size":"cover",
                                "background-position":"center top"});
                            $("#Xphoto5").css({"display":"block"});
                        }
                        if(id=='photo6'){
                            $("#imagePreview6").css({"background-image": "url(" +
                                this.result + ")","background-size":"cover",
                                "background-position":"center top"});
                            $("#Xphoto6").css({"display":"block"});
                        }
                    }
                }
            });

        });
    </script>
<script type="text/javascript">
    $(document).ready(function () {
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
    });
</script>
@stop
