<form id="vform">
<div class="panel panel-default credit-card-box" id="ccb">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        {{-- <h3 class="panel-title display-td" >Pay using card</h3> --}}
                        <div class="display-td" >                            
                            <img class="img-responsive pull-left" src="{{asset('css/logos/cart_payment_card_cropped.png')}}" style="height:33px;width:100px;">
                        </div>
                    </div>                    
                </div>
                                <div class="panel-body">
                    {{-- <form role="form" id="payment-form" method="POST" action="javascript:void(0);"> --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="cardNumber"><input type="radio" name="payment_id" value="40" class="pid">CLICK TO PAY BY CARD</label>
                                    <div class="input-group">
                                        <input 
                                            type="hidden"
                                            class="form-control"
                                            name="cardNumber"
                                            placeholder="Valid Card Number"
                                            autocomplete="cc-number"
                                            required autofocus 
                                        />
                                        {{-- <span class="input-group-addon"><i class="fa fa-credit-card"></i></span> --}}
                                    </div>
                                </div>                            
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                   <p>&nbsp</p>
                                   &nbsp
                                   &nbsp
                                </div>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12" style="padding:9px;">
                                <div class="form-group">
                                    <i class="fa fa-info-circle text-info bg-info " aria-hidden="true">You must have a valid card  to use this facility</i>

                                </div>
                            </div>                        
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>
                    {{-- </form> --}}
                </div>
                {{-- <div class="panel-body"> --}}
                    {{-- <label for="cc">PAY BY CARD</label> --}}
                    {{-- <input type="radio" id="cc" name="payment_id" class="form-control"> --}}
        {{--             <form role="form" id="payment-form" method="POST" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="cardNumber">CARD NUMBER</label>
                                    <div class="input-group">
                                        <input 
                                            type="tel"
                                            class="form-control"
                                            name="cardNumber"
                                            placeholder="Valid Card Number"
                                            autocomplete="cc-number"
                                            required autofocus 
                                        />
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        name="cardExpiry"
                                        placeholder="MM / YY"
                                        autocomplete="cc-exp"
                                        required 
                                    />
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cardCVC">CV CODE</label>
                                    <input 
                                        type="tel" 
                                        class="form-control"
                                        name="cardCVC"
                                        placeholder="CVC"
                                        autocomplete="cc-csc"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                      {{--   <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="couponCode">COUPON CODE</label>
                                    <input type="text" class="form-control" name="couponCode" />
                                </div>
                            </div>                        
                        </div> --}}
{{--                         <div class="row">
                            <div class="col-xs-12">
                                <label><input type="checkbox" name="save_card">Save Card for later use.</label>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>
                    </form>  --}}
                {{-- </div> --}}
            {{-- </div>             --}}
            <!-- CREDIT CARD FORM ENDS HERE -->
            
            
        </div>            
</form>
{{-- Validations --}}
<script type="text/javascript">
    // $(document).ready(function(){
    //     $('#vform').bootstrapValidator({
    //         framework:'bootstrap',
    //         icon: {
    //                 valid: 'glyphicon glyphicon-ok',
    //                 invalid: 'glyphicon glyphicon-remove',
    //                 validating: 'glyphicon glyphicon-refresh'
    //             },
    //         fields:
    //     });
    // });
</script>