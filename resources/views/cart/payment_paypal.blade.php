<div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h2  class="panel-title display-td" style="color:#00b0de;text-align:center;padding:9px;"><i class="fa fa-paypal" aria-hidden="true">Pay using Paypal</i>
</h3>
                 
                    </div>                    
                </div>
                <div class="panel-body">
                    {{-- <form role="form" id="payment-form" method="POST" action="javascript:void(0);"> --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="cardNumber"><input type="radio" name="payment_id" value="48" class="pid">CLICK TO PAY BY PAYPAL</label>
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
                                    <i class="fa fa-info-circle text-info bg-info " aria-hidden="true">You must have a valid Paypal account to use this facility</i>

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
            </div>            
            <!-- CREDIT CARD FORM ENDS HERE -->
            
            
        </div>            