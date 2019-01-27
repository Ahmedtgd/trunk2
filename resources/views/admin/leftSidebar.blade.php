{{--<b>Administrator</b>--}}
{{--<br>--}}
{{--<b>  Merchant Approval</b>--}}
{{--<br>--}}
{{--<b style="cursor:pointer;" data-toggle="collapse" href="#collapseExample"> Table Management</b>--}}
{{--<br>--}}
{{--<ul class="nav bs-sidenav well collapse" id="collapseExample">--}}
{{--<li><a href="{{route('usersMgmt')}}">Users</a></li>--}}
{{--<li><a href="{{route('brandMgmt')}}">Brand</a></li>--}}
{{--<li><a href="{{route('analysisinventory')}}">Inventory Analysis</a></li>--}}
{{--<li><a href="{{route('analysissales')}}">Inventory Analysis</a></li>--}}
{{--<li><a href="{{route('categoryMgmt')}}">Category</a></li>--}}
{{--<li><a href="{{route('newsletterMgmt')}}">News Letter</a></li>--}}
{{--<li><a href="{{route('downloadappsMgmt')}}">Download Apps</a></li>--}}
{{--<li><a href="{{route('directoryMgmt')}}">Directory</a></li>--}}
{{--<li><a href="{{route('buyerhelpMgmt')}}">Buyer Help</a></li>--}}
{{--<li><a href="{{route('sellerhelpMgmt')}}">Seller Help</a></li>--}}
{{--<li><a href="{{route('feedbackMgmt')}}">Feedback</a></li>--}}
{{--<li><a href="{{route('jobMgmt')}}">Job</a></li>--}}
{{--<li><a href="{{route('contactUsMgmt')}}">Contact Us</a></li>--}}
{{--<li><a href="{{route('advertisementMgmt')}}">Advertisement</a></li>--}}
{{--<li><a href="{{route('termsandconditionMgmt')}}">Terms & Condition</a></li>--}}
{{--<li><a href="{{route('privacypolicyMgmt')}}">Privacy Policy</a></li>--}}
{{--<li><a href="{{route('rolesMgmt')}}">Roles</a></li>--}}

<div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

     {{--Start of Administrator Summary Menu--}}
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#front" aria-expanded="false"
                   aria-controls="front">
                    Administrator Summary
                </a>
            </h4>
        </div>
        <div id="front" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                {{--start--}}

                <ul class="nav bs-sidenav well" id="collapseReportMenu">
                    <li><a href="{{route('countrySales')}}">Sales</a></li>
                    <li><a href="{{route('countryActiveBuyer')}}">Active Buyer</a></li>
                    <li><a href="{{route('countryMerchant')}}">Merchants</a></li>
                    <li><a href="{{route('countryMCRecruited')}}">Merchant Consultant Recruited</a></li>
                    <li><a href="{{route('countryBuyerRegistered')}}">Buyer Registered</a></li>
                    <li><a href="{{route('countrySMMRecruited')}}">SMM Recruited</a></li>
                    <li><a href="{{route('countryProductRegistered')}}">Product Registered</a></li>
                    <li><a href="{{route('adminFrontGraph')}}">Sales Chart</a></li>
                </ul>
                {{--end--}}
            </div>
        </div>
    </div>
    {{--End Of Administrator Summary Menu--}} 



    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#admin" aria-expanded="false"
                   aria-controls="admin">
                    Administrator Payment
                </a>
            </h4>
        </div>
        <div id="admin" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
             <div class="panel-body">
                {{--start--}}
                <ul class="nav bs-sidenav well" id="collapseReportMenu">
                    <li><a href="{{route('merchantPayment')}}">Merchant</a></li>
                    <li><a href="{{route('smmPayment')}}">SMM</a></li>
                    <li><a href="{{route('employeePayment')}}">Employee</a></li>
                    <li><a href="{{route('mcPayment')}}">MC</a></li>
                </ul>
               {{--end--}} 

            </div>
        </div>
    </div>

    {{--Start of Administrator Master Menu--}}
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#master" aria-expanded="false"
                   aria-controls="master">
                    Adminstrator Master
                </a>
            </h4>
        </div>
        <div id="master" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                {{--start--}}

                <ul class="nav bs-sidenav well" id="collapseReportMenu">
                    <li><a href="{{route('MasterMerchant')}}">Merchant</a></li>
                    <li><a href="{{route('Station')}}">Station</a></li>
                    <li><a href="/admin/buyer">Buyer</a></li>
                    <li><a href="#">Voucher</a></li>
                    <li><a href="{{route('routeOpenWish')}}">OpenWish</a></li>
                    <li><a href="{{route('Order')}}">Order</a></li>
                    <li><a href="{{route('Product')}}">Product</a></li>
                    <li><a href="{{route('DeliveryOrder')}}">Delivery Order</a></li>
                    <li><a href="/admin/master/autolink">AutoLink</a></li>
                    <li><a href="{{route('masterSMM')}}">SMM</a></li>
                    {{--<li><a href="{{route('routePayment')}}">Payment</a></li>--}}
                    <li>
                        <a class='first-level-menu-li-a' >Shipping</a>
                        <ul class='second-level-sub-menu' style='display: none'>
                            <li id="list-world" data-hash="world">
                                <a href="{{route('shipping:world')}}"
									class="col-xs-12" >Worldwide</a>
                            </li>
                            <li id="list-country" data-hash="country">
                                <a href="{{route('shipping:country')}}"
									class="col-xs-12" >By Country and State</a>
                            </li>
                            <li id="list-merchant" data-hash="merchant">
                                <a  href="{{route('shipping:merchant')}}"
									class="col-xs-12" >By Merchant</a>
                            </li>
                            <li id="list-merchant-consultant" data-hash="merchant_consultant">
                                <a href="{{route('shipping:merchant-consultant')}}"
									class="col-xs-12" >By Merchant Consultant</a>
                            </li>
                            <li id="list-merchant-consultant" data-hash="merchant_consultant">
                                <a href="{{route('shipping:buyer')}}"
								class="col-xs-12">By Buyer</a>
                            </li>
                            <li id="list-merchant-consultant" data-hash="merchant_consultant">
                                <a href="{{route('shipping:courier')}}"
								class="col-xs-12">By Courier</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                {{--end--}}
            </div>
        </div>
    </div>
    {{--End Of Administrator Master Menu--}}

    {{--start of Admin General Menu--}}
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#general" aria-expanded="false"
                   aria-controls="general">
                    Administrator General
                </a>
            </h4>
        </div>
        <div id="general" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                {{--start--}}

                <ul class="nav bs-sidenav well" id="collapseReportMenu">
                    <li><a href="{{route('routeEmployee')}}">Employees</a></li>
                    <li><a href="{{route('routeSalesStaff')}}">Sales Staff</a></li>
                    <li><a href="{{route('routeOccupation')}}">Occupations</a></li>
                    <li><a href="{{route('routeGlobal')}}">Global</a></li>
					<!--
                    <li><a href="/station/administration">Station Administration</a></li>
					-->
<!--
                    <li><a href="{{route('mcReport')}}">MC Report</a></li>
                    <li><a href="{{route('mpReport')}}">MP Report</a></li>
                    <li><a href="{{route('pusherReport')}}">Pusher Report</a></li>
-->
                </ul>
                {{--end--}}
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#adminBuyer" aria-expanded="false"
                   aria-controls="general">
                    Administrator Buyer
                </a>
            </h4>
        </div>
        <div id="adminBuyer" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                {{--start--}}

                <ul class="nav bs-sidenav well" id="collapseReportMenu">
                    <li><a href="buyer">Admin Buyer</a></li>
                    <li><a href="buyersmm">Buyer Smm</a></li>
                    <li><a href="buyerdealer">Buyer Dealer</a></li>
                    <li><a href="buyeropenwish">Buyer OpenWish</a></li>
                </ul>
                {{--end--}}
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#comission" aria-expanded="false"
                   aria-controls="master">
                    Adminstrator Comissions
                </a>
            </h4>
        </div>
		<div id="comission" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                {{--start--}}

                <ul class="nav bs-sidenav well" id="collapseReportMenu">
                    <li><a href="{{route('ComissionSummary')}}">Summary</a></li>
                    <li><a href="{{route('ComissionMerchantConsultant')}}">Merchant Consultant</a></li>
                    <li><a href="{{route('ComissionStationRecruiter')}}">Station Recruiter</a></li>
                    <li><a href="{{route('ComissionMerchantPusher')}}">Pusher</a></li>
                    <li><a href="{{route('ComissionMerchantProfessional')}}">Merchant Professional</a></li>
                    <li><a href="{{route('ComissionMerchant')}}">Merchant</a></li>
                    <li><a href="{{route('ComissionStation')}}">Station</a></li>					
                    <li><a href="#">SMM</a></li>					
                </ul>
                {{--end--}}
            </div>
        </div>
     </div>

    {{--End Of Admin General Menu--}}
        <div class="panel panel-default">
        <div class="panel-heading" role="tab" >
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"
                   aria-expanded="false" aria-controls="collapseThree">
                    Analysis
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                 <ul class="nav bs-sidenav well" id="collapseReportMenu">
                    <li><a href="{{route('analysisinventory')}}">Inventory</a></li>
                    <li><a href="{{route('station-show')}}">Station</a></li>
                    <li>
                        <a class='first-level-menu-li-a' >Sales</a>
                        <ul class='second-level-sub-menu' style='display: none'>
                            <li id="list-world" data-hash="world">
                                <a class="col-xs-12" >Worldwide</a>
                            </li>
                            <li id="list-country" data-hash="country">
                                <a class="col-xs-12" >By Country</a>
                            </li>
<!--                            <li>
                                <a class="col-xs-12">By State</a>
                            </li>-->
                            <li id="list-merchant-consultant" data-hash="merchant_consultant">
                                <a class="col-xs-12" >By Merchant Consultant</a>
                            </li>
                            <li id="list-merchant" data-hash="merchant">
                                <a class="col-xs-12" >By Merchant</a>
                            </li>
                        </ul>
                    </li>
                   
                </ul>
                
            </div>
        </div>
    </div>


	<!--
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                   aria-expanded="false" aria-controls="collapseTwo">
                    Merchant Approval
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                Merchant Approval
            </div>
        </div>
    </div>
	-->

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#tblmgmt"
                   aria-expanded="false" aria-controls="tblmgmt">
                    Table Management
                </a>
            </h4>
        </div>
        <div id="tblmgmt" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <ul class="nav bs-sidenav well" id="collapseExample">
                    {{--<li><a href="{{route('usersMgmt')}}">Users</a></li>--}}
                    <li><a href="{{route('brandMgmt')}}">Brand</a></li>
                    <li><a href="{{route('categoryMgmt')}}">Category</a></li>
                    <li><a href="{{route('newsletterMgmt')}}">News Letter</a></li>
                    <li><a href="{{route('downloadappsMgmt')}}">Download Apps</a></li>
                    <li><a href="{{route('directoryMgmt')}}">Directory</a></li>
                    <li><a href="{{route('buyerhelpMgmt')}}">Buyer Help</a></li>
                    <li><a href="{{route('sellerhelpMgmt')}}">Seller Help</a></li>
                    <li><a href="{{route('feedbackMgmt')}}">Feedback</a></li>
                    <li><a href="{{route('jobMgmt')}}">Job</a></li>
                    <li><a href="{{route('contactUsMgmt')}}">Contact Us</a></li>
                    <li><a href="{{route('advertisementMgmt')}}">Advertisement</a></li>
                    <li><a href="{{route('termsandconditionMgmt')}}">Terms & Condition</a></li>
                    <li><a href="{{route('privacypolicyMgmt')}}">Privacy Policy</a></li>
                    <li><a href="{{route('rolesMgmt')}}">Roles</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<div></div>
@section("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $('#grid').DataTable({
                'scrollX':true,
                 'autoWidth':false
            });

            var url = document.location.href;
            $('.collapse').removeClass('in');

            if (url.indexOf("tblmgmt") > 0)
                if (!$('#tblmgmt').hasClass('in'))
                    $('#tblmgmt').collapse('show');
            if (url.indexOf("front") > 0)
                $('#front').collapse('show');

            if (url.indexOf("general") > 0)
                $('#general').collapse('show');

            if (url.indexOf("analysis") > 0)
                $('#collapseThree').collapse('show');
            
    });
    </script>
@endsection
