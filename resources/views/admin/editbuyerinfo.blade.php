<?php
$cf = new \App\lib\CommonFunction();
?>
<style>
#imagePreview {
    width: 80%;
    height: 220px;
    background-position: center center;
    background-size: cover;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    display: inline-block;
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
   <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Buyer</h4>
                              </div>
                <div class="modal-body">

                         <div class="row">
                        @if (count($errors) > 0)

                
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                            {{ $error }} </div>
                        @endforeach
                      @endif

                    {{-- <form action="admin/buyer/updatebuyer" method="Post" class="form-horizontal"> --}}
                                    <?php echo Form::open(array('id' => 'form','files'=>true))?>

                     <input type="hidden" name="buyer_id" value="{{$buyer_id}}"
                                       class="form-control col-xs-12">
                    <div id="buyer-detail">
                        <h6 class="col-xs-12 red-color">Edit your personal details here</h6>
                        <h4 class="col-xs-12"><b><i>Buyer Detail</i></b></h4>
                        {{-- BEGIN --}}
                         <div class="row  bottom-margin-md" >
            <div class="col-xs-7">
           {{--      <div class="col-xs-12 no-padding bottom-margin-sm">
                        <label class="col-sm-2 col-xs-12 control-label">Username</label>
                        <div class="col-sm-6 col-xs-12">
                             <input type="text" name="username" value="{{$user->username}}"
                                       class="form-control col-xs-12">
                        </div>
                    </div> --}}
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
                           <input type="text" class="form-control col-xs-12" id="fnamep" name="full_name"
                                       value="{{$user->name}}">
                        </div>
                    </div>
            </div>
            <div class="col-xs-4">

                <div class="col-xs-12 no-padding bottom-margin-sm">
                    <div id="imagePreview">
                      <img src="{{asset($image)}}" style="width: 200px; height: 220px;" title="buyer profile pic">
                    </div>
                    <span class="btn btn-default btn-file">
                        Upload Photo <input type="file" id="photo" name="photo">
                    </span>
            </div>
        </div></div>
                        {{-- END --}}
                        {{-- PART2 --}}
                        <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Salutation</label>
                    <div class="col-sm-6 col-xs-12">
                    <div class="radio radio-green radio-inline">
                                    <input type="radio" <?php if ($user->salutation == "Mr") {
                                        echo 'checked="checked"';
                                    } ;?> name="salutation" value="Mr" id="inlineRadio1">
                                    <label for="inlineRadio1">Mr</label>
                                </div>
                                <div class="radio radio-green radio-inline">
                                    <input type="radio" <?php if ($user->salutation == "Ms") {
                                        echo 'checked="checked"';
                                    } ;?> name="salutation" value="Ms" id="inlineRadio1">
                                    <label for="inlineRadio1"> Ms</label>
                                </div>
                                <div class="radio radio-green radio-inline">
                                    <input type="radio" <?php if ($user->salutation == "Mrs") {
                                        echo 'checked="checked"';
                                    } ?> name="salutation" value="Mrs" id="inlineRadio1">
                                    <label for="inlineRadio1">Mrs</label>
                                </div>
                                <div class="radio radio-green radio-inline">
                                    <input type="radio" <?php if ($user->salutation != "Mr" and $user->salutation != 'Ms' and $user->salutation != 'Mrs') {
                                        echo 'checked="checked"';
                                    } ?> name="salutation" value="option1" id="inlineRadio1">
                                    <label for="inlineRadio1"> Other</label>
                                </div>
                                <div class="radio radio-green radio-inline">
                                    <input type="text" name="otherinput"  class="form-control" value=<?php if ($user->salutation != "Mr" and $user->salutation != 'Ms' and $user->salutation != 'Mrs') {
                                        echo $user->salutation;
                                    } ?>>
                                </div>
                        {{-- </div> --}}
                    </div>

             {{--    </div> --}}
         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Date Of Birth:</label>
                       <div class="col-xs-7">
                       
                                <input type="text" name="dob" id='dobp' value="{{$dob}}"
                                       class="date form-control">
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
                        {{-- Part2 END--}}
                        {{-- Part 3 --}}
                     <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Gender</label>
                    <div class="col-sm-6 col-xs-12">
                       <select name="gender" class="form-control   ">
                                    <option value="male" <?php if ($user->gender == "male") {
                                        echo 'selected';
                                    } ?> >Male
                                    </option>
                                    <option value="female" <?php if ($user->gender == "female") {
                                        echo 'selected';
                                    } ?>>Female
                                    </option>
                                    <option value="other" <?php if ($user->gender == "other") {
                                        echo 'selected';
                                    } ?>>Other
                                    </option>
                            </select>
                    </div>

             {{--    </div> --}}
         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Language</label>
                       <div class="col-xs-7">
                            <select name="language" class="form-control col-xs-12">

                                @foreach ($languages as $language)
                                    {{--  {{$language}} --}}
                                         <option value="{{$language->code}}"
                                        <?php if ($user->language_id == $language->id) {
                                            echo 'selected';
                                        } ?>
                                        >{{$language->description}}</option>                                @endforeach
                            </select>
                    </div>
                </div>

           
            </div>
        </div> 
                        {{-- Part 3 end --}}
                        
                    {{-- Part4 --}}
                    <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Annual Income</label>
                    <div class="col-sm-6 col-xs-12">
                         <select name="income" class="form-control col-xs-12 " >
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
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Mobile</label>
                       <div class="col-xs-7">
                            <input type="text" name="mobile" value="{{$user->mobile_no}}" id="mobilep" class="form-control">
                    </div>
                </div>

           
            </div>
        </div>
                    {{-- Part4 ends --}}
                    {{-- Part5  --}}
                    <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Occupation</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                         <select name="occupation" class="form-control col-xs-12 ">
                                @foreach ($occupations as $occupation)
                                      <option value="{{$occupation->id}}" <?php if ($user->occupation_id == $occupation->id) {
                                            echo 'selected';
                                        } ?>>{{$occupation->description}}</option>
                                @endforeach
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

                    {{-- Part 5 ends --}}

                     
                        <div class="row">

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
                                        <input type="radio" checked="" name="radioInline" value="0;1" id="electronics">
                                        <label for="electronics">Electronics</label>
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
                                        <input type="radio" checked="" name="radioInline" value="0;10"
                                               id="inlineRadio1">
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
                                </div>
                                <
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="radioInline" value="0;6" id="inlineRadio1">
                                        <label for="inlineRadio1">Souvenirs</label>
                                    </div>
                                </div>

                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="radioInline" value="3;?" id="inlineRadio1">
                                        <label for="inlineRadio1">Restaurant & Cafe</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="radioInline" value="option1"
                                               id="inlineRadio1">
                                        <label for="inlineRadio1">Pets</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                    <div id="shipping-detail" class="bottom-margin-md col-xs-12">

                        <h4>
                            <b>
                                <i>
                                    Shipping Detail
                                </i>
                            </b>
                        </h4>
                        <div class="col-lg-12 col-xs-12 no-padding bottom-margin-md">

                            <label class="col-xs-2 control-label">Default Address</label>
                            <div class="col-xs-4">
                                <input type="text" name="default1" placeholder="Address Line 1" value="{{$def->line1 or $em}}
                                        " class="form-control">
                                <input type="text" name="default2" value="{{$def->line2 or $em}}" class="form-control">
                                <input type="text" name="default3" value="{{$def->line3 or $em}}" class="form-control">
                                <input type="text" name="default4" value="{{$def->line4 or $em}}" class="form-control">
                            </div>


                            <label class="col-xs-2 control-label">Billing Address</label>

                            <div class="col-xs-4">
                                <input type="text" name="billing1" placeholder="Address Line 1" value="{{$bill->line1 or $em}}"
                                       class="form-control">
                                <input type="text" name="billing2" value="{{$bill->line2 or $em}}" class="form-control">
                                <input type="text" name="billing3" value="{{$bill->line3 or $em}}" class="form-control">
                                <input type="text" name="billing4" value="{{$bill->line4 or $em}}" class="form-control">
                            </div>
                            <div class="col-sm-3">click here to make your default address as billing address<input
                                        type="radio" class="d2b" onclick="FillBilling(this.form)" name="fillbill"></div>
                            <div class="col-sm-3">click here to make your default address as delivery address<input
                                        type="radio" class="d2d" onclick="FillDelivery(this.form)" name="filldel"></div>

                        </div>
                        <div class="col-xs-12 no-padding">
                            <label class="col-xs-2 control-label">Delivery Address</label>
                            <div class="col-xs-4">
                                <input type="text" name="delivery1" placeholder="Address Line 1" class="form-control">
                                <input type="text" name="delivery2" placeholder="Address Line 2" class="form-control">
                                <input type="text" name="delivery3" placeholder="Address Line 3" class="form-control">
                                <input type="text" name="delivery4" placeholder="Address Line 4" class="form-control">
                            </div>
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
                    <div class="row">

                        <div class="col-sm-10">
                            <div class="radio radio-warning radio-inline">
                                <input type="radio" id="debit_r" value="debit" class="pm" name="method"
                                       checked="checked">
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
                                <input type="text" name="card_number" value="{{$card->number or $em}}"
                                       class="form-control col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Name on Card</label>
                            <div class="col-sm-3 col-xs-12">
                                <input type="text" name="name_on_card" value="{{$card->name or $em}}"
                                       class="form-control col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Expiry Date</label>
                            <div class="col-sm-3 col-xs-12">
                                <input type="text" name="expiry_date" value="{{$card->expiry or $em}}"
                                       class="date form-control col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1 col-xs-12">
                                <input type="text" name="cvv" value="{{$card->cvv or $em}}" class="form-control col-xs-12">
                            </div>
                            <label class="col-sm-4 control-label">cvv/cv2</label>
                        </div>


                    </div>

                    <div id="paypal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Payee Email</label>
                            <div class="col-sm-3 col-xs-12">
                                <input name="paypal_payee_email" value="{{$paypal or $em}}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div id="banking">
                        <label class="col-sm-12 control-label">Bank</label>
                        <div class="col-sm-3 col-xs-6">
                            <select name="online_banking_bank" class="form-control col-xs-12 ">
                                @foreach($banks as $bank)
                                    <option value="{{$bank->id}}" <?php
                                    if (isset($banka->bank_id)) {
                                         if ($banka->bank_id == $bank->id) {echo 'selected';
                                    } 
                                    }?>;
                                    >{{$bank->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-12 control-label">Account No.</label>
                        <div class="col-sm-3 col-xs-6">
                            <input class="form-control" value="{{$banka->account_number1 or $em}}" name="account1">
                        </div>


                    </div>
</div>
                    <hr>


                    <div id="buyer-detail">
                        <h6 class="col-xs-12 red-color"><i>for potential dealer, social media marketeer and Merchant
                                Consultant</i></h6>

                        <div class="col-xs-12 bottom-margin-md">
                            <a href="#" class="btn btn-orange col-sm-2"><i class="fa fa-suitcase"></i> Open Business</a>
                        </div>


                        <div class="col-xs-12 no-padding bottom-margin-md">
                            <label class="col-sm-2 col-xs-12 control-label">Name</label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control col-xs-12" id="fnamec"name="full_namep" disabled
                                       value="{{$user->name}}">
                            </div>
                        </div>
                 <div class="col-xs-12 no-padding bottom-margin-md">
                            <label class="col-sm-2 col-xs-12 control-label">Salutation</label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="radio radio-green radio-inline">
                                    <input type="radio" <?php if ($user->salutation == "Mr") {
                                        echo 'checked="checked"';
                                    } ;?> name="salutation" value="Mr" id="inlineRadio1">
                                    <label for="inlineRadio1">Mr</label>
                                </div>
                                <div class="radio radio-green radio-inline">
                                    <input type="radio" <?php if ($user->salutation == "Ms") {
                                        echo 'checked="checked"';
                                    } ;?> name="salutation" value="Ms" id="inlineRadio1">
                                    <label for="inlineRadio1"> Ms</label>
                                </div>
                                <div class="radio radio-green radio-inline">
                                    <input type="radio" <?php if ($user->salutation == "Mrs") {
                                        echo 'checked="checked"';
                                    } ?> name="salutation" value="Mrs" id="inlineRadio1">
                                    <label for="inlineRadio1">Mrs</label>
                                </div>
                                <div class="radio radio-green radio-inline">
                                    <input type="radio" <?php if ($user->salutation == "option1") {
                                        echo 'checked="checked"';
                                    } ?> name="salutation" value="option1" id="inlineRadio1">
                                    <label for="inlineRadio1"> Other</label>
                                </div>
                                <div class="radio radio-green radio-inline">
                                    <input type="text" name="otherinput2" 
                              class="form-control" value="?">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 no-padding">
                            <label class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-3">
                                     <select name="gender" disabled>
                                                <option value="male" <?php if ($user->gender == "male") {
                                                    echo 'selected';
                                                } ?> >Male
                                                </option>
                                                <option value="female" <?php if ($user->gender == "female") {
                                                    echo 'selected';
                                                } ?>>Female
                                                </option>
                                                <option value="other" <?php if ($user->gender == "other") {
                                                    echo 'selected';
                                                } ?>>Other
                                                </option>
                                            </select>
                                        </div>
                            <div class="col-xs-2"></div>
                            <label class="col-sm-2 control-label">Date of Birth:</label>
                            <div class="col-sm-3">
                                <input type="text" name="dobc" id='dobc' value="{{$dob}}" disabled 
                                       class="date form-control">
                        </div>
                        <div class="col-xs-12 no-padding">
                            <label class="col-sm-2 control-label">Language</label>
                            <div class="col-sm-3">
                                <select disabled name="languagep" class="form-control col-xs-12">

                                    @foreach ($languages as $language)
                                        {{--  {{$language}} --}}
                                       <option value="{{$language->code}}"
                                        <?php if ($user->language_id == $language->id) {
                                            echo 'selected';
                                        } ?>
                                        >{{$language->description}}</option>
                                        }
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-2"></div>
                            <label class="col-sm-2 control-label">Annual:</label>
                            <div class="col-sm-3"><select name="incomep" disabled class="form-control col-xs-12 btn-success">
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
                        </div>
                        <div class="col-xs-12 no-padding ">
                            <label class="col-sm-2 control-label">Mobile Number</label>
                            <div class="col-sm-3">
                               <input type="text" id="mobilec" value="
                    {{$user->mobile_no}}" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 no-padding bottom-margin-md">
                            <label class="col-sm-2 control-label">Occupation</label>
                            <div class="col-sm-3">
                                <select name="occupation1" class="form-control col-xs-12 btn-success" disabled>
                                    @foreach ($occupations as $occupation)
                                        <option value="{{$occupation->id}}" <?php if ($user->occupation_id == $occupation->id) {
                                            echo 'selected';
                                        } ?>>{{$occupation->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding ">
                            <label class="col-sm-2 control-label">Company Name</label>
                            <div class="col-sm-3">
                                <input name="company_name" type="text" class="form-control col-xs-12"
                                      value="{{$company_name}}">
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding ">
                            <label class="col-sm-2 control-label">Company Reg No</label>
                            <div class="col-sm-3">
                                <input type="text" name="company_reg_no" class="form-control col-xs-12"
                                      value="{{$company_reg_no}}">
                            </div>
                        </div>
<div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Industry</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                         <input name="potential_industry"type="text" class="form-control col-xs-12" placeholder="Potential Industry">
                    </div>

         
                    
                 
                </div>
               </div>
            <div class="col-sm-5">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-xs-5 control-label">Products</label>
                       <div class="col-xs-7">
                            {{-- Input Two --}}
                            <input type="text" name="products"class="form-control col-xs-12" placeholder="Products">
                    </div>
                </div>

           
            </div>
        </div>
         <div class="row">
            <div class="col-sm-7">
                <div class="col-xs-12 no-padding bottom-margin-md">
                    <label class="col-sm-2 col-xs-12 control-label">Amount</label>
                    <div class="col-sm-6 col-xs-12">
                         {{-- Input One --}}
                         <input name="amount"type="text" class="form-control col-xs-12" placeholder="Amount">
                    </div>

         
                    
                 
                </div>
               </div>
            
        </div>

                        <div class="col-xs-12 no-padding ">
                            <label class="col-sm-2 control-label">Type</label>
                            <div class="col-sm-3">
                                <select class="form-control btn-warning" name="type">
                                    <option value="dealers">Dealers</option>
                                    <option value="merchant_consult">Merchant Consultant</option>
                                    <option value="smm">SMM</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-xs-12 no-padding">
                            <label class="col-sm-12 control-label">Interest</label>
                            <div class="col-xs-12 bottom-margin-md buy-registration-radio">
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="0;1" id="inlineRadio1">
                                        <label for="electronics">Electronics</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="1;?" id="inlineRadio1">
                                        <label for="inlineRadio1"> Travel</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="0;10" id="inlineRadio1">
                                        <label for="inlineRadio1">Industrial</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="0;3" id="inlineRadio1">
                                        <label for="inlineRadio1"> Food & Beverage</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="?,?" id="inlineRadio1">
                                        <label for="inlineRadio1">Books & Stationery</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="0;4" id="inlineRadio1">
                                        <label for="inlineRadio1">Fashion</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="?;?" id="inlineRadio1">
                                        <label for="inlineRadio1">Sports & Outdoor</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="1;?" id="inlineRadio1">
                                        <label for="inlineRadio1"> Home Decoration</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="0;6" id="inlineRadio1">
                                        <label for="inlineRadio1">Present</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="2;0" id="inlineRadio1">
                                        <label for="inlineRadio1">Weddings</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="0;5" id="inlineRadio1">
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
                                        <input type="radio" checked="" name="ci" value="0;7" id="inlineRadio1">
                                        <label for="inlineRadio1">Automotive</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="0;9" id="inlineRadio1">
                                        <label for="inlineRadio1">Construction</label>
                                    </div>
                                </div>
                                <
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="0;6" id="inlineRadio1">
                                        <label for="inlineRadio1">Souvenirs</label>
                                    </div>
                                </div>

                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="3;?" id="inlineRadio1">
                                        <label for="inlineRadio1">Restaurant & Cafe</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 reg-radio-container">
                                    <div class="radio radio-green radio-inline">
                                        <input type="radio" checked="" name="ci" value="option1" id="inlineRadio1">
                                        <label for="inlineRadio1">Pets</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-12 bottom-margin-md">
                            <h4 class="col-xs-12"><b><i>Banking Details</i></b></h4>
                            <div class="col-xs-12 no-padding">
                                <label class="col-sm-2 col-xs-12 control-label">Account Name </label>
                                <div class="col-sm-3 col-xs-12">
                                    <input type="text" value="{{$banka->account_name2 or $em}}" name="account_name"
                                           class="form-control col-xs-12">
                                </div>
                            </div>
                            <div class="col-xs-12 no-padding">
                                <label class="col-sm-2 col-xs-12 control-label">Account Number </label>
                                <div class="col-sm-3 col-xs-12">
                                    <input type="text" name="account_number" class="form-control col-xs-12"
                                           value="{{$banka->account_number2 or $em}}">
                                </div>
                            </div>
                            <div class="col-xs-12 no-padding">
                                <label class="col-sm-2 col-xs-12 control-label">Bank</label>
                                <div class="col-sm-3 col-xs-12">
                                    <select type="text" class="form-control col-xs-12" name="account_bank">
                                        @foreach($banks as $bank)
                                            <option value="$bank->id" 
                                            <?php  if (isset($banka->banka_id)){if ($banka->bank_id == $bank->id) {
                                                echo 'selected';
                                            } }?> >{{$bank->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 no-padding">
                                <label class="col-sm-2 col-xs-12 control-label">Bank Code</label>
                                <div class="col-sm-3 col-xs-12">
                                    <input type="text" class="form-control col-xs-12" name="account_bank_code"
                                           value="{{$bank_all->code or $em}}">
                                </div>
                            </div>
                            <div class="col-xs-12 no-padding">
                                <label class="col-sm-2 col-xs-12 control-label">IBAN</label>
                                <div class="col-sm-3 col-xs-12">
                                    <input type="text" class="form-control col-xs-12" value="{{$banka->iban or $em}}"
                                           name="account_iban">
                                </div>
                            </div>
                            <div class="col-xs-12 no-padding">
                                <label class="col-sm-2 col-xs-12 control-label">SWIFT</label>
                                <div class="col-sm-3 col-xs-12">
                                    <input type="text" name="account_swift" class="form-control col-xs-12"
                                           value="{{$banka->swift or $em}}">
                                </div>
                            </div>

                        </div>
                    </div>

<div class="clearfix"> </div> 

               
                              <div class="modal-footer">
                                
                        <input type="submit" class="btn btn-green btn-lg" value="Update">

                              </div>
        </form>
</div>
</div>

    <script>
        $(document).ready(function () {
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
        function fill (parent,child) {

            var p= "#"+parent;
            var c= "#" +child;
            $(p).change(function() {
                    $(c).val($(this).val());
                });
            $(c).prop( "disabled", true );
        }
        fill("fnamep","fnamec");
        fill("mobilep","mobilec");
        fill("dobp","dobc");

        function FillBilling(f) {

            if (f.fillbill.checked == true) {
                f.billing1.value = f.default1.value;
                f.billing2.value = f.default2.value;
                f.billing3.value = f.default3.value;
                f.billing4.value = f.default4.value;
            }
            if (f.billingtoo.checked == false) {
                f.billingname.value = '';
                f.billingcity.value = '';
            }
        }
        function FillDelivery(f) {

            if (f.filldel.checked == true) {
                f.delivery1.value = f.default1.value;
                f.delivery2.value = f.default2.value;
                f.delivery3.value = f.default3.value;
                f.delivery4.value = f.default4.value;
            }
            if (f.billingtoo.checked == false) {

            }
        }

    </script>

     <script type="text/javascript">
    //     $(document).ready(function () {

    //         $('#form').bootstrapValidator({
    //             framework: 'bootstrap',
    //             // Feedback icons
    //             icon: {
    //                 valid: 'glyphicon glyphicon-ok',
    //                 invalid: 'glyphicon glyphicon-remove',
    //                 validating: 'glyphicon glyphicon-refresh'
    //             },
    //             // fields
    //             fields: {
    //                 username: {
    //                     validators: {
    //                         notEmpty: {
    //                             message: "Username cannot be left empty"
    //                         },
    //                         stringLength: {
    //                             min: 7,
    //                             max: 20,
    //                             message: "The username must be more than 7 and less than 20 characters"
    //                         }
    //                     }
    //                 }
    //                 ,
    //                 password: {
    //                     validators: {
    //                         notEmpty: {
    //                             message: "Password cannot be left empty"
    //                         },
    //                         stringLength: {
    //                             min: 7,
    //                             max: 20,
    //                             message: "The Password must be more than 7 and less than 20 characters"
    //                         }
    //                     }
    //                 }
    //                 ,
    //                 password_confirmation: {
    //                     validators: {
    //                         notEmpty: {
    //                             message: "This field cannot be left empty"
    //                         },
    //                         stringLength: {
    //                             min: 7,
    //                             max: 20,
    //                             message: "The password must be more than 4 and less than 20 characters"
    //                         }
    //                     }
    //                 },

    //                 mobile: {
    //                     validators: {
    //                         notEmpty: {
    //                             message: "Mobile number is required"
    //                         },
    //                         digit: {
    //                             message: "Mobile number is not valid"
    //                         }
    //                     }
    //                 }
    //                 ,
    //                 default1: {
    //                     notEmpty: {
    //                         message: "Required"
    //                     },
    //                 }
    //                 ,
    //                 default2: {
    //                     notEmpty: {
    //                         message: "Required"
    //                     },
    //                 }
    //                 ,
    //                 billing1: {
    //                     notEmpty: {
    //                         message: "Required"
    //                     },
    //                 }
    //                 ,
    //                 billing2: {
    //                     notEmpty: {
    //                         message: "Required"
    //                     },
    //                 }
    //                 ,
    //                 delivery1: {
    //                     notEmpty: {
    //                         message: "Required"
    //                     },
    //                 }
    //                 ,
    //                 delivery2: {
    //                     notEmpty: {
    //                         message: "Required"
    //                     },
    //                 }
    //                 ,
    //                 card_number: {
    //                     validators: {
    //                         creditCard: {
    //                             message: "The card number is not valid"
    //                         }
    //                     }
    //                 },
    //                 name_on_card: {
    //                     validators: {
    //                         notEmpty: {
    //                             message: "Required"
    //                         }
    //                     },
    //                     cvv: {
    //                         validators: {
    //                             creditCardField: 'card_number',
    //                             message: 'The cvv is not valid'
    //                         }
    //                     },
    //                     paypal_payee_email: {
    //                         validators: {
    //                             emailAddress: {
    //                                 message: "Not a valid email"
    //                             }
    //                         }
    //                     }
    //                     ,

    //                 }
    //             }//fields

    //         });
    //     });

    </script>
    <script type="text/javascript">
        (document).ready(function(){
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
});
    </script>
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
