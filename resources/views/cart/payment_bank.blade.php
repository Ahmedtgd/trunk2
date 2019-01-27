<style type="text/css">
.popular_banks{
    list-style: none;
}
.select2-search__field{
    height: 3em;
}
</style>
 



<div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h2 class="panel-title display-td" style="color:#00b0de;text-align:center;padding:0px;" >INTERNET BANKING (FPX)
                        <img height="32em;" width="0.1em;" src="{{asset('fpxlogo/Color/Standard_color-01.png' )}}" style="visibility: hidden;"></h2>

                    </div>                    
                </div>
                <div class="panel-body">
                    {{-- <form role="form" id="payment-form" method="POST" action="javascript:void(0);"> --}}
                        <div class="row">
                            {{-- <div class="col-xs-12">
                                <div >
                                    <label for="cardNumber">SELECT FROM POPULAR BANKS</label>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label><input type="radio" name="payment_id" class="pid" value="6"><img src="{{asset('css/logos/may.png')}}" style="max-height:18px;"></label>
                                        </div>
                                        <div class="col-xs-4"><label><input type="radio" name="payment_id" class="pid"><img src="{{asset('css/logos/cimb.png')}}" style="max-height:18px;"></label></div>
                                        <div class="col-xs-4"><label><input type="radio" name="payment_id" class="pid"><img src="{{asset('css/logos/hlb.png')}}" style="max-height:18px;"></label></div>
                                    </div>
                                    <div class="row">
                                    </div>
                                </div>                            
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                            <label>PAY USING</label>
                            <select id="other_banks" class="pid">
                                <option selected value="" class="none">Select Bank</option>
                              {{--   @foreach($banks as $b)
                                    <option value="{{$b->code}}" name="payment_id" class="pid">{{$b->name}}</option>
                                @endforeach --}}
                             {{--    <option>BANK of ISLAM</option>
                                <option>INDIAN BANK</option> --}}
                            </select>
                            </div>
                        </div>
                        <div class="row">
                        &nbsp
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                
                                   Click <a href="https://uat.mepsfpx.com.my/FPXMain/termsAndConditions.jsp" target="_blank">here </a> for FPX term & conditions.&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                   <p> &nbsp;</p>
                                   <p> &nbsp;</p>
                                   {{-- &nbsp; --}}
                                </div>
                            </div>                        
                        </div>

                        <div class="row payment-errors" style="display:none;">
                            <div class="col-xs-12">
                                <p class="text-danger" id="bank_error_fpx"></p>
                            </div>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>            

            
            
        </div>            