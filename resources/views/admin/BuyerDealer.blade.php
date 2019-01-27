<?php
$cf = new \App\lib\CommonFunction();
?>
@extends("common.default")

@section("content")
<style type="text/css">
    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
</style>

    <div class="container" style="margin-top:30px;">
		@include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif 
                <script>
                window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
                </script>
               <b>Buyer Dealer</b>
                <br><br>
                
              <table border="0" cellspacing="5" cellpadding="5">
             <tbody><tr>
            <td>Search By: </td>
            <td><select id="filtername" name="search_name">
                    <option value="">Select Option</option>

                    <option value="dealer">Dealer</option>
                 
             </select></td>
             
            <td><strong style="font-weight: bold;">&nbsp;=&nbsp;</strong></td>
            <td><input type="text" id="search_value" class="form-control" name="search_value"></td>
             </tr>
           </tbody></table>
            <br><br>
              
                    <table id="test" class="display nowrap table table-bordered" cellspacing="0" width="100%" >
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>Occupation id</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Birthdate</th>
                        <th>Mobile no</th>
                        <th>Gender</th>
                        <th>mode</th>
                        <th>Initiator type</th>
                        <th>Initiator bought</th>
                        <th>Initiator sold</th>

                        <th>Responder bought</th>
                        <th>Responder sold</th>
                        <th>Responder type</th>
                        <th>Remarks</th>
                        <th>Gst</th>
                        <th>Company</th>
                        <th>Business reg no</th>
                        <th>Country id</th>
                        <th>Business type</th>
                        <th>Office no</th>
                        <th>O-Shop name</th>
                        <th>Description</th>
                        <th>Return  policy</th>
                        <th>Merchant id</th>
                        <th>Product id</th>


                        
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
               
      @foreach ($buyers as $key=>$value)
             
            <tr>
                <td>{{(!empty($value->user_id)) ? $value->user_id : null}}</td>
                <td>{{(!empty($value->occupation_id)) ? $value->occupation_id : null}}</td>
                <td>{{(!empty($value->first_name)) ? $value->first_name : null}}</td>
                <td>{{(!empty($value->last_name)) ? $value->last_name : null}}</td>
                <td>{{(!empty($value->username)) ? $value->username : null}}</td>
                
                <td>{{(!empty($value->email)) ? $value->email : null}}</td>
                <td>{{(!empty($value->birthdate)) ? $value->birthdate : null}}</td>
                <td>{{(!empty($value->mobile_no)) ? $value->mobile_no : null}}</td>
                <td>{{(!empty($value->gender)) ? $value->gender : null}}</td>
                <td>{{(!empty($value->mode)) ? $value->mode : null}}</td>
                <td>{{(!empty($value->initiator_type)) ? $value->initiator_type : null}}</td>
                <td>{{(!empty($value->initiator_bought)) ? $value->initiator_bought : null}}</td>
                <td>{{(!empty($value->initiator_sold)) ? $value->initiator_sold : null}}</td>

                <td>{{(!empty($value->responder_bought)) ? $value->responder_bought : null}}</td>
                <td>{{(!empty($value->responder_sold)) ? $value->responder_sold : null}}</td>
                <td>{{(!empty($value->responder_type)) ? $value->responder_type : null}}</td>
                <td>{{(!empty($value->remarks)) ? $value->remarks : null}}</td>
                <td>{{(!empty($value->gst)) ? $value->gst : null}}</td>
                <td>{{(!empty($value->company_name)) ? $value->company_name : null}}</td>
                <td>{{(!empty($value->business_reg_no)) ? $value->business_reg_no : null}}</td>
                <td>{{(!empty($value->country_id)) ? $value->country_id : null}}</td>
                <td>{{(!empty($value->business_type)) ? $value->business_type : null}}</td>

                <td>{{(!empty($value->office_no)) ? $value->office_no : null}}</td>
                <td>{{(!empty($value->oshop_name)) ? $value->oshop_name : null}}</td>
                <td>{{(!empty($value->description)) ? $value->description : null}}</td>
                <td>{{(!empty($value->return_policy)) ? $value->return_policy : null}}</td>
                <td>{{(!empty($value->merchant_id)) ? $value->merchant_id : null}}</td>
                <td>{{(!empty($value->product_id)) ? $value->product_id : null}}</td>
                
            </tr>
          @endforeach
        </tbody>
        </table>
<br><br>
                
            </div>
    </div><style>
#imagePreview {
    width: 80%;
    height: 220px;
    background: url("{{asset('images/placecards/dummy.jpg')}}");
    background-position: center center;
    background-size: cover;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    border: 1px solid;
    display: inline-block;
    margin-bottom: 5px;
}
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
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

</style>

     <div class="modal fade" id="buyerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                          <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add Buyer</h4>
                              </div>
                <div class="modal-body">
                         <div class="row" style="margin-left:0;margin-right:0 ">
                        @if (count($errors) > 0)

                
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                            {{ $error }} </div>
                        @endforeach
            @endif


         <form action="{{ url('admin/buyer/addbuyer') }}" style="margin: 0" enctype="multipart/form-data" method="POST" class="form-horizontal" id="addBuyer">
          <div id="buyer-detail">

            <h6 class="col-xs-12 red-color">Alternatively buyer could login using this way. Check out and express check out will come here.</h6>
      <h4 class="col-xs-12"><b><i>Buyer Detail</i></b></h4>
        <div class="row " >
            <div class="col-xs-7">
                <div class="col-xs-12 no-padding bottom-margin-sm">
                        <label class="col-sm-2 col-xs-12 control-label bottom-margin-md">Username</label>
                        <div class="col-sm-6 col-xs-12">
                            <input type="text" placeholder="Type your email" id="username" name="username" class="form-control col-xs-12">
                        </div>
                    </div>
                    <div class="col-xs-12 no-padding bottom-margin-sm">
                        <label class="col-sm-2 col-xs-12 control-label">Password</label>
                        <div class="col-sm-6 col-xs-12">
                            <input type="password" placeholder="Type your password" name="password" class="form-control col-xs-12">
                        </div>
                    </div>
                    <div class="col-xs-12 no-padding bottom-margin-sm">
                        <label class="col-sm-2 col-xs-12 control-label">Reconfirm</label>
                        <div class="col-sm-6 col-xs-12">
                            <input type="password" name="password_confirmation" placeholder="Retype your password" class="form-control col-xs-12">
                        </div>
                            </div>
                    <div class="col-xs-12 no-padding bottom-margin-sm">
                        <label class="col-sm-2 col-xs-12 control-label">Name</label>
                        <div class="col-sm-6 col-xs-12">
                            <input type="text" class="form-control col-xs-12" id="bname" name="full_name"placeholder="*Compulsory">
                        </div>
                    </div>

            </div>
            <div class="col-xs-1"></div>
            <div class="col-xs-4">

                <div class="col-xs-12 no-padding bottom-margin-sm">
                    <div id="imagePreview" class="pull-right">
                        
                    </div>
                    <span class="btn btn-primary btn-file pull-right">
                        Upload Photo <input type="file" id="photo" name="photo">
                    </span>
            </div>
        </div></div>
        <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Salutation</label>
                    <div class="col-sm-6 col-xs-12">
                        <div class="radio radio-green radio-inline">
                            <input type="radio" checked="" name="salutation" value="Mr" id="inlineRadio1 " class="salt">
                            <label for="inlineRadio1">Mr</label>
                        </div>
                        <div class="radio radio-green radio-inline">
                            <input type="radio" checked="" name="salutation" value="Ms" id="inlineRadio1" class="salt">
                            <label for="inlineRadio1"> Ms</label>
                        </div>
                          <div class="radio radio-green radio-inline">
                              <input type="radio" checked="" name="salutation" value="Mrs" id="inlineRadio1" class="salt">
                            <label for="inlineRadio1">Mrs</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-green radio-inline">
                            <input type="radio"  name="salutation" value="option1" id="inlineRadio1" class="salt">
                            <label for="inlineRadio1"> Other</label>
                        </div>
                        <br>
                       {{--  <div class="radio radio-green radio-inline"> --}}
                            <input type="text" id="otherinput" name="otherinput" class="form-control">
                        {{-- </div> --}}
                    </div>

             {{--    </div> --}}
          
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Date Of Birth:</label>
                       <div class="col-xs-7">
                        <input type="text" name="dob" id='dob' placeholder="dd/mm/year" class="date form-control">
                    </div>
                </div>

           
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">First name</label>
                    <div class="col-sm-6 col-xs-12">
                    <input type="text" name="first_name" id='first_name' placeholder="First Name" class="form-control" required>

                    </div>
         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Last name</label>
                       <div class="col-xs-7">
                          <input type="text" name="last_name" id='last_name' placeholder="Last Name" class="form-control" required>  
                    </div>
                </div>

           
            </div>
        </div> 
          <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Gender</label>
                    <div class="col-sm-6 col-xs-12">
                       <select name="gender" id="gender" class="form-control   ">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                    </div>

             {{--    </div> --}}
         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Language</label>
                       <div class="col-xs-7">
                            <select name="language" id="language" class="form-control col-xs-12">
                                @if(isset($languages))
                                @foreach ($languages as $language)
                                    {{--  {{$language}} --}}
                                    <option selected="selected" value="{{$language->id}}">{{$language->description}}</option>
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
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Annual Income</label>
                    <div class="col-sm-6 col-xs-12">
                         <select name="income" id="income" class="form-control col-xs-12 " >
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
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Mobile</label>
                       <div class="col-xs-7">
                            <input type="text" id="mobile" name="mobile" placeholder="*Required" class="form-control">
                    </div>
                </div>

           
            </div>
        </div>
        {{-- 3rd row ends --}}
           <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Occupation</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                         <select name="occupation" id="occupation" class="form-control col-xs-12 ">
                                @if(isset($occupations))
                                @foreach ($occupations as $occupation)
                                    <option selected="selected" value="{{$occupation->id}}">{{$occupation->description}}</option>
                                @endforeach
                                @endif
                        </select>

                    </div>                  
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label"></label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                    </div>
                </div>

           
            </div>
        </div>
         <div class="row">
        <div class="col-sm-12">
                <div class="col-sm-4">

                            <div class="form-group">
                                <label class="col-sm-5 control-label">Country: </label>
                                <div class="col-sm-7">
                                     {!! Form::select('country', [''=>'Country of Origin']+$cf->getCountry(),0, ['class' => 'form-control validator','id' => 'country_id']) !!}
                                </div>
                            </div>
                            </div>
                <div class="col-sm-4">

                            <div class="form-group">
                                <label class="col-sm-5 control-label">State: </label>
                                <div class="col-sm-7">
                             <select class="form-control validator" id="states" required></select> 
                                        
                            </div>
                            </div>
                    </div>
            <div class="col-sm-4">
        
                            <div class="form-group">
                                <label class="col-sm-5 control-label">City: </label>
                                <div class="col-sm-7">
                              <select class="form-control validator" id="cities" name="city_name" required></select>
                                    
                                </div>
                            </div>
                            </div>
                            </div>
        </div>

        {{-- 4th row ends --}}
        {{-- 5th row ends --}}
        
        <div class="col-xs-12 no-padding">
            <label class="col-sm-12 control-label">Interest</label>
            <div class="col-xs-12 bottom-margin-md buy-registration-radio">
                {{--  @foreach($interests as $interest)
                     <div class="col-sm-2 reg-radio-container">
                     <div class="radio radio-green radio-inline">
                         <input type="radio" checked="" name="radioInline" value="{{$interest->name}}" id="inlineRadio1">
                         <label for="inlineRadio1"> {{$interest->description}}</label>
                     </div>
                 </div>
                 @endforeach --}}
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                         <label for="electronics">
                        <input type="radio" checked="" name="radioInline" value="0;1" id="electronics">
                       Electronics</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="1;?" id="inlineRadio1">
                        <label for="inlineRadio1"> Travel</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;10" id="inlineRadio1">
                    <label for="inlineRadio1">Industrial</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;3" id="inlineRadio1">
                        <label for="inlineRadio1"> Food & Beverage</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="?,?" id="inlineRadio1">
                        <label for="inlineRadio1">Books & Stationery</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;4" id="inlineRadio1">
                        <label for="inlineRadio1">Fashion</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="?;?" id="inlineRadio1">
                        <label for="inlineRadio1">Sports & Outdoor</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="1;?" id="inlineRadio1">
                        <label for="inlineRadio1"> Home Decoration</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;6" id="inlineRadio1">
                        <label for="inlineRadio1">Present</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="2;0" id="inlineRadio1">
                        <label for="inlineRadio1">Weddings</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;5" id="inlineRadio1">
                        <label for="inlineRadio1">Furniture</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;2" id="inlineRadio1">
                        <label for="inlineRadio1">Health & Beauty</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;7" id="inlineRadio1">
                        <label for="inlineRadio1">Automotive</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;9" id="inlineRadio1">
                        <label for="inlineRadio1">Construction</label>
                    </div>
                </div><
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;6" id="inlineRadio1">
                        <label for="inlineRadio1">Souvenirs</label>
                    </div>
                </div>

                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;6" id="inlineRadio1">
                        <label for="inlineRadio1">Restaurant & Cafe</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="radioInline" value="0;6" id="inlineRadio1">
                        <label for="inlineRadio1">Pets</label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <hr>
    <div id="shipping-detail" class="col-xs-12">

        <h4>
            <b>
                <i>
                    Shipping Detail
                </i>
            </b>
        </h4>
        <div class="col-md=12 col-sm-12 no-padding ">
            <div class="col-md-2">
                <label class=" control-label ">Default Address</label>

            </div>
            <div class="col-sm-4">
                <input type="text" name="default1" id="default1" placeholder="Address Line 1" class="form-control">
                <input type="text" name="default2" id="default2" placeholder="Address Line 2" class="form-control">
                <input type="text" name="default3" id="default3" placeholder="Address Line 3" class="form-control">
                <input type="text" name="default4" id="default4" placeholder="Address Line 4" class="form-control">
                </div>

            <div class="col-sm-2">
                <label class="control-label">Billing Address</label>
                <button class="btn btn-sm btn-info" style="padding: 5px 0px;" name="fillbill" id="fillbill"><span class="glyphicon glyphicon-book"></span> Copy Default Address</button>
           </div> 
            <div class="col-sm-4">
                <input type="text" name="billing1" id="billing1" placeholder="Address Line 1" class="form-control">
                <input type="text" name="billing2" id="billing2" placeholder="Address Line 2" class="form-control">
                <input type="text" name="billing3" id="billing3" placeholder="Address Line 3" class="form-control">
                <input type="text" name="billing4" id="billing4" placeholder="Address Line 4" class="form-control">
            </div>
            <p>&nbsp</p>
            {{-- ROW --}}
    
  
            {{-- ENDS --}}
            
        <div class="col-xs-12 no-padding">
             <div class="col-sm-2">
                <label class="control-label">Delivery Address</label>
                <button class="btn btn-sm btn-info" style="padding: 5px 0px;" name="filldel" id="filldel"><span class="glyphicon glyphicon-book"></span> Copy Default Address</button>
           </div> 
            <div class="col-sm-4">
                <input type="text" name="delivery1" id="delivery1" placeholder="Address Line 1" class="form-control">
                <input type="text" name="delivery2" id="delivery2" placeholder="Address Line 2" class="form-control">
                <input type="text" name="delivery3" id="delivery3" placeholder="Address Line 3" class="form-control">
                <input type="text" name="delivery4" id="delivery4" placeholder="Address Line 4" class="form-control">
            </div>
          
   
    </div>
    <hr> 
    <div id="payment-method">
        <h4>
            <b>
                <i>
                    Payment Method
                </i>
            </b>
        </h4>
        <div class="col-sm-10">
            <div class="radio radio-warning radio-inline">
                <input type="radio" id="debit_r" value="debit" class="pm" name="method" checked="checked">
                <label>Visa/Master</label>
            </div>
            <div class="radio radio-warning radio-inline">
                <input type="radio" id="banking_r" value="online_banking" class="pm" name="method">
                <label> Online Banking</label>
            </div>
            <div class="radio radio-warning radio-inline">
                <input type="radio" id="paypal_r" value="paypal" name="method" class="pm">
                <label>Paypal</label>
            </div>
        </div>
    </div>
                <div id="debit">
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Card Number</label>
                        <div class="col-sm-3 col-xs-12">
                            <input type="text" name="card_number" id="card_number" placeholder="" class="form-control col-xs-12">
                        </div>
            </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Name on Card</label>
                        <div class="col-sm-3 col-xs-12">
                            <input type="text" name="name_on_card" id="name_on_card" placeholder="" class="form-control col-xs-12">
                        </div>
            </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Expiry Date</label>
                        <div class="col-sm-3 col-xs-12">
                            <input type="text" name="expiry_date" id="expiry_date" placeholder="" class="date form-control col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1 col-xs-12">
                            <input type="text" name="cvv" id="cvv" placeholder="" class="form-control col-xs-12">
                        </div>
                        <label class="col-sm-4 control-label">cvv/cv2</label>
                    </div>


                </div>

                <div id="paypal">
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Payee Email</label>
            <div class="col-sm-3 col-xs-12">
                <input name="paypal_payee_email" class="form-control">
            </div>
        </div>
                </div>
                <div id="banking">
                    <label class="col-sm-12 control-label">Bank</label>
                    <div class="col-sm-3 col-xs-6">
                        <select name="online_banking_bank" id="online_banking_bank" class="form-control col-xs-12 ">
                            @if(isset($banks))
                            @foreach($banks as $bank)
                                <option value="{{$bank->id}}">{{$bank->name}}</option>
                            @endforeach
                            @endif
                        </select>
        </div>
                    <label class="col-sm-12 control-label">Account No.</label>
                    <div class="col-sm-3 col-xs-6">
                        <input class="form-control" id="account2" name="account2">
                    </div>


                </div>

                <hr>


                <div id="buyer-detail">
    <h6 class="col-xs-12 red-color"><i>for potential dealer, social media marketeer and Merchant Consultant</i></h6>

                    <div class="col-xs-12 bottom-margin-md">
                        <a href="#" class="btn btn-orange col-sm-3"><i class="fa fa-suitcase"></i> Open Business</a>
                    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="checkbox">
                <h4> Do you want to register for OpenWish? </h4> 
                        <input type="checkbox" value="yes" name="opm" id="opm" class="form-control checkbox-primary" >
                
          
            </div> 
        </div>
    </div>
    <span class="openwish">
    {{-- Row1 --}}
       <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Name</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                          <input type="text" disabled class="form-control col-xs-12" placeholder="*Compulsory">
                    </div>                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Salutation</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                             <div class="radio radio-green radio-inline">
                            <input type="radio" checked="" name="sp" disabled value="Mr" id="inlineRadio4 " class="salt">
                            <label for="inlineRadio4">Mr</label>
                        </div>
                        <div class="radio radio-green radio-inline">
                            <input type="radio" checked="" name="sp"  disabled value="Ms" id="inlineRadio4" class="salt">
                            <label for="inlineRadio4"> Ms</label>
                        </div>
                          <div class="radio radio-green radio-inline">
                              <input type="radio" disabled  checked="" name="sp" value="Mrs" id="inlineRadio4" class="salt">
                            <label for="inlineRadio4">Mrs</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-green radio-inline">
                            <input  disabled type="radio" name="sp"  value="option1" id="inlineRadio4" class="salt">
                            <label for="inlineRadio4"> Other</label>
                        </div>
                        <br>
                       {{--  <div class="radio radio-green radio-inline"> --}}
                            <input type="text" id="otherinput" disabled class="form-control">
                        {{-- </div> --}}

                    </div>
                </div>

           
            </div>
        </div>
    {{-- row1 --}}
      {{-- row 2 --}}
           <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Gender</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                        <select disabled  id="genderc" name="" class="form-control   ">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                    </select>
                    </div>

         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Date of Birth</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                     <input type="text" name="" disabled id='dobc' placeholder="dd/mm/year" class="date form-control">
                    </div>
                </div>

           
            </div>
        </div>

      {{-- row2 --}}
      {{-- row3 --}}
         <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Language</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                          <select name="" disabled class="form-control col-xs-12">
                            @if(isset($languages))
                                @foreach ($languages as $language)
                                    {{--  {{$language}} --}}
                                    <option  value="{{$language->code}}">{{$language->description}}</option>
                                    }
                                @endforeach
                             @endif   
                            </select>
                    </div>

         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Annual Income</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                             <select name="income" disabled class="form-control col-xs-12 " >
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
                </div>

           
            </div>
        </div>
      {{-- row3 --}}
        
      {{-- row4 --}}
         <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Mobile Number</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                          <input type="text" name="" disabled placeholder="*Required" class="form-control">
                    </div>

         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Occupation</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                              <select name="" disabled class="form-control col-xs-12 ">
                                @if(isset($occupations))
                                @foreach ($occupations as $occupation)
                                    <option value="{{$occupation->id}}">{{$occupation->description}}</option>
                                @endforeach
                                @endif
                        </select>

                    </div>
                </div>

           
            </div>
        </div>
      {{-- row4 --}}
      {{-- row5 --}}
         <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Company Name</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                         <input name="company_name" id="company_name" type="text" class="form-control col-xs-12" placeholder="if using company account">
                    </div>

         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Company Registration No.</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                            <input type="text" id="company_reg_no" name="company_reg_no"class="form-control col-xs-12" placeholder="if using company account">
                    </div>
                </div>

           
            </div>
        </div>
      {{-- row5 --}}
         {{--row6  --}}
            <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Type</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                    <select class="form-control" id="type" name="type">
                    <option value="dlr">Dealers</option>
                    <option value="mct">Merchant Consultant</option>
                    <option value="smm">SMM</option>
                    <option value="byr">Buyer</option>

                </select>
                    </div>
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Potential Industry</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                            <input type="text" class="form-control" id="potential_industry" name="potential_industry">
                    </div>
                </div>

           
            </div>
        </div>
        <div class="row" id="buyer" style="display: none;">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md" >
                    <label class="col-sm-2 col-xs-12 control-label">Courier</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                    <select class="form-control" name="courier">
                      @if(isset($courier))
                                @foreach ($courier as $cour)
                                    <option value="{{$cour->id}}">{{$cour->name}}</option>
                                @endforeach
                                @endif
                     </select>
                    </div>

         
                    
                 
                </div>
               </div>
             <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md" >
                    <label class="col-sm-2 col-xs-12 control-label">Payment</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                    <select class="form-control" name="payment">
                      @if(isset($payments))
                                @foreach ($payments as $payment)
                                    <option value="{{$payment->id}}">{{$payment->note}}</option>
                                @endforeach
                                @endif
                     </select>
                    </div>

         
                    
                 
                </div>
               </div>
        </div>
        <script>
            $('#type').on('change',function(){
                if($(this).val()=='byr'){
                    $('#buyer').show();
                } else {
                    $('#buyer').hide();
                }
            });
        </script>
         {{-- row6 --}}
              
        {{-- row7 --}}
                   <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Products</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                        <input type="text" class="form-control" id="products" name="products">
                    </div>

         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Amount</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                            <input type="text" class="form-control" id="amount" name="amount">
                    </div>
                </div>

           
            </div>
        </div>
        {{-- row7 ends --}}

       <div class="col-xs-12 no-padding">
            <label class="col-sm-12 control-label">Interest</label>
            <div class="col-xs-12 bottom-margin-md buy-registration-radio">
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;1" id="electronics">
                        <label for="electronics">Electronics</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled name="ci" value="1;?" id="inlineRadio1">
                        <label for="inlineRadio1"> Travel</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;10" id="inlineRadio1">
                    <label for="inlineRadio1">Industrial</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;3" id="inlineRadio1">
                        <label for="inlineRadio1"> Food & Beverage</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="?,?" id="inlineRadio1">
                        <label for="inlineRadio1">Books & Stationery</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;4" id="inlineRadio1">
                        <label for="inlineRadio1">Fashion</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="?;?" id="inlineRadio1">
                        <label for="inlineRadio1">Sports & Outdoor</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="1;?" id="inlineRadio1">
                        <label for="inlineRadio1"> Home Decoration</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;6" id="inlineRadio1">
                        <label for="inlineRadio1">Present</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="2;0" id="inlineRadio1">
                        <label for="inlineRadio1">Weddings</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;5" id="inlineRadio1">
                        <label for="inlineRadio1">Furniture</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" checked="" name="ci" value="0;2" id="inlineRadio1">
                        <label for="inlineRadio1">Health & Beauty</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;7" id="inlineRadio1">
                        <label for="inlineRadio1">Automotive</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;9" id="inlineRadio1">
                        <label for="inlineRadio1">Construction</label>
                    </div>
                </div><
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled checked="" name="ci" value="0;6" id="inlineRadio1">
                        <label for="inlineRadio1">Souvenirs</label>
                    </div>
                </div>

                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio" disabled  checked="" name="ci" value="3;?" id="inlineRadio1">
                        <label for="inlineRadio1">Restaurant & Cafe</label>
                    </div>
                </div>
                <div class="col-sm-2 reg-radio-container">
                    <div class="radio radio-green radio-inline">
                        <input type="radio"  disabled checked="" name="ci" value="option1" id="inlineRadio1">
                        <label for="inlineRadio1">Pets</label>
                    </div>
                </div>
            </div>

       </div>

        <div class="col-xs-12 bottom-margin-md">
            <h4 class="col-xs-12"><b><i>Banking Details</i></b></h4>
        </div>
    </span>
   
      {{-- test --}}
      
      {{-- test --}}
        {{-- row6 --}}
           <div class="row bank openwish">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Account Name</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                          <input type="text" name="account_name" id="account_name"  class="form-control col-xs-12">
                    </div>

         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Account Number</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                             <input type="text" name="account_number" id="account_number" class="form-control col-xs-12">
                    </div>
                </div>

           
            </div>
        </div>
        {{-- row6 --}}
        {{-- row7 --}}
           <div class="row openwish">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Bank</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                         <select type="text" name="account_bank" class="form-control col-xs-12" name="account_bank">
                        @if(isset($banks))
                        @foreach($banks as $bank)
                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                        @endforeach
                        @endif
                    </select>
                    </div>

         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Bank Code</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                             <input type="text" class="form-control col-xs-12" id="account_bank_code" name="account_bank_code">
                    </div>
                </div>

           
            </div>
        </div>
        {{-- row7 --}}
           
        {{-- row8 --}}
           <div class="row openwish">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">IBAN</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                         <input type="text" class="form-control col-xs-12" id="account_iban" name="account_iban">
                    </div>

         
                    
                 
                </div>
               </div>

            <div class="col-sm-5">
                <div class="col-xs-12 no-padding ">
                    <label class="col-xs-5 control-label">SWIFT</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                             <input type="text" name="account_swift" id="account_swift" class="form-control col-xs-12">
                    </div>
                </div>

           
            </div>
        </div>
        
               
          <div class="modal-footer">
            
         <input type="submit" name="Send"  value="Send" class='btn btn-green btn-lg'>

          </div>
</div>
</div>
</div>

</form>
                            
                            </div>
                          </div>
                      </div>
                    </div>
                    </div>
    </div>                 
    <script type="text/javascript">
      
        $(document).ready(function () {
             var oTable = $('#test').DataTable( {
        
        "scrollX":        true,
        "info":           true,
        "paging":         true,


    } );    

    /* Add event listener to the dropdown input */
    $('#search_value').keyup( function() { 

if($('select#filtername').val()=='all'){
           oTable.column(0).search( this.value ).draw();
      }else if($('select#filtername').val()=='country'){ //alert('dd');
           oTable.column(4).search( this.value ).draw();

      }else if($('select#filtername').val()=='city'){ //alert('dd');
           oTable.column(5).search( this.value ).draw();

      }else if($('select#filtername').val()=='openwish'){ //alert('dd');
           oTable.column(0).search( this.value ).draw();

      }else if($('select#filtername').val()=='smm'){ //alert('dd');
           oTable.column(0).search( this.value ).draw();

      } else if($('select#filtername').val()=='buyerself'){ //alert('dd');
           oTable.column(0).search( this.value ).draw();

      } else if($('select#filtername').val()=='dealer'){ //alert('dd');
           oTable.column(0).search( this.value ).draw();

      }

         } );

        });
    </script>
<script>
    $(document).ready(function () {
        $('.openwish').show();
        // $('#opm').change(function(){
        //     if (this.value=='yes') {
        //         $('#openwish').show();

        //     }
        //     else {
        //         $('#openwish').hide();
        //     };
        // });
        // $("#opm").click(function() {
        // if($(this).is(":checked")) {
        // $(".openwish").show(300);
        //     } else {
        // $(".openwish").hide(200);
        //     }
        // });
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
   $('#fillbill').click(function(e)
    {
         $('#billing1').val($('#default1').val());
         $('#billing2').val($('#default2').val());

         $('#billing3').val($('#default3').val());

         $('#billing4').val($('#default4').val());
         e.preventDefault()

    });
   $('#filldel').click(function()
    {
         $('#delivery1').val($('#default1').val());
         $('#delivery2').val($('#default2').val());

         $('#delivery3').val($('#default3').val());

         $('#delivery4').val($('#default4').val()); 
         e.preventDefault()
            });
   
// Salutation 
   
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#addBuyer').bootstrapValidator({
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
                            max: 20,
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
             /*   name_on_card: {
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

                }*/
            }//fields

        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#otherinput').hide();
        $('.salt').change(function(){
           
            if (this.value=='option1') {
                $('#otherinput').show();}
           else {
            
            $('#otherinput').hide();};
        });
    });
   
</script>
{{-- Bank Account --}}


<script type="text/javascript">
$(function() {
  
    $("#photo").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
        }
    });
});
</script>
<script type="text/javascript">
        $(document).ready(function () {
            var formSubmitType = null;

            //Function To handle add button action
            $("#btn-add").click(function () {
                formSubmitType = "add";
                $(".modal-title").text("Add Buyer");
                $("#addBuyer").trigger("reset");
                $("#buyerModal").modal("show");
                $('#addBuyer').attr('action', 'buyer/addbuyer');
                $("#buyer_id").remove();
                $("#alt_image").remove();
                $("#imagePreview").removeAttr('style');

            })

            //Function To Handle Edit Button action
            $(".btn-edit").click(function () {
                $("#addBuyer").trigger("reset");
                $("#buyerModal").modal("hide");
                $("#buyer_id").remove();
                $("#alt_image").remove();
                $("#imagePreview").removeAttr('style');

                var val = $(this).attr('title');
                console.log(val);
                var url = "buyer/editbuyer/" + val;
                formSubmitType = "edit";
                $(".modal-title").text("Edit Buyer");

                $.ajax({
                    type: "GET",
                    url: url,
                   //dataType: 'json',
                    success: function (data) {
                        //alert(data['user']["nationality_country_id"]);
                    $("#buyerModal").modal("show");
                       $('#addBuyer').attr('action', 'buyer/updatebuyer');

                       $("#username").val(data['user']["email"]);
                       $("#first_name").val(data['user']["first_name"]);
                       $("#last_name").val(data['user']["last_name"]);
                       $("#bname").val(data['user']["name"]);
                       $('#buyer-detail').append('<input type="hidden" name="buyer_id" id="buyer_id" value='+data['buyer_info']["id"]+' />');

                       $("#dob").val(data["dob"]);
                      // $("#imagePreview").val(data["image"]);
                      var asset_url = "<?php echo asset('/') ; ?>";
                      $("#imagePreview").append("<img name='alt_image' id='alt_image' style='width: 100%; height: 220px;' src="+asset_url+data["image"]+">");

                       $("#mobile").val(data['user']["mobile_no"]);
                       $("#language").val(data['user']["language_id"]);
                       $("#occupation").val(data['user']["occupation_id"]);
                       $("#country_id").val(data['user']["nationality_country_id"]);
                       $("#gender").val(data['user']["gender"]);
                       $("#income").val(data['user']["annual_income"]);


                       $("#paypal").val(data['buyer_info']["paypal"]);
                       //$("#banka").val(data["banka"]);
                      $("#card_number").val(data["cardinfo"]['number']);
                      $("#name_on_card").val(data["cardinfo"]['name']);
                      $("#expiry_date").val(data["cardinfo"]['expiry']);
                      $("#cvv").val(data["cardinfo"]['cvv']);
                      $("#default1").val(data["default_address"]['line1']);
                      $("#default2").val(data["default_address"]['line2']);
                      $("#default3").val(data["default_address"]['line3']);
                      $("#default4").val(data["default_address"]['line4']);

                      $("#billing1").val(data["billing_address"]['line1']);
                      $("#billing2").val(data["billing_address"]['line2']);
                      $("#billing3").val(data["billing_address"]['line3']);
                      $("#billing4").val(data["billing_address"]['line4']);

                     $("#potential_industry").val(data["buyer_info"]['potential_industry']);
                     $("#products").val(data["buyer_info"]['products']);
                     $("#amount").val(data["buyer_info"]['amount']);
                     $("#company_name").val(data['buyer_info']["company_name"]);
                     $("#company_reg_no").val(data['buyer_info']["company_reg_no"]);

                     $("#account_name").val(data["bankaccount"]['account_name1']);
                     $("#account_number").val(data["bankaccount"]['account_number1']);
                    // $("#account_bank_code").val(data["bankaccount"]['amount']);
                     $("#account_iban").val(data['bankaccount']["iban"]);
                     $("#account_swift").val(data['bankaccount']["swift"]);

                    //  $("#user").val(data["user"]);
                    //  $("#languages").val(data["languages"]);
                    //  $("#occupations").val(data["occupations"]);
                    //  $("#interests").val(data["interests"]);
                    //  $("#banks").val(data["banks"]);

                    },
                    error: function (error) {
                        console.log("Error :" + error);
                    }

                });

            })


        });
    </script>
@stop
