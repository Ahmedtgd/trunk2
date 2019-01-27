<style type="text/css">
/*   .panel-heading .nav li a:focus {
        background-color: #1abc9c;
        color: #fff;
   }*/
   #adminpanelheading .dropdown-menu li a{ font-size: 16px; }
   #adminpanelheading .nav-tabs li a{
        color: #555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    .dropdown-toggle{ color: #000; }
    #adminpanelheading .nav .current_nav a{background: #fff; color:#000; font-weight: bold;}
    #adminpanelheading .nav .current_nav a:focus{background: #fff; color:#000; font-weight: bold; cursor: pointer;}
    #adminpanelheading .nav .current_nav a:hover{background: #fff; color:#000; font-weight: bold; cursor: pointer;}
    #adminpanelheading .nav li a{background: #e7e7e7; color:#000;}
    #adminpanelheading .nav li a:focus{background: #e7e7e7; cursor: pointer;}
    #adminpanelheading .nav li a:hover{background: #1abc9c; cursor: pointer; color: #fff;}
    #adminpanelheading .nav li .dropdown-menu li a{background: #fff; color:#000; font-weight: normal;}
    #adminpanelheading .nav li .dropdown-menu li a:hover{background: #1abc9c; color:#fff; font-weight: normal;}

	#adminpanel li a {
		border: 1px solid #ddd;
		border-bottom-color: transparent;
	}

	#advertpanel li a {
		border: 1px solid #ddd;
		border-bottom-color: transparent;
	}
</style>
<div class="panel-heading" id="adminpanelheading" style="font-size: 18px;">
    <ul class="nav navbar-nav" id="adminpanel" style="margin-left:-15px">
        <li class="dropdown" id="general">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                General
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('admin/generalAdminPanel')
            </ul>
        </li>
        <li class="dropdown" id="master">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                Master
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('admin/masterAdminPanel')
            </ul>
        </li>
        <li class="dropdown" id="analysis">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                Analysis
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('admin/analysisAdminPanel')
            </ul>
        </li>
        <li class="dropdown" id="payment">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                Payment
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('admin/paymentAdminPanel')
            </ul>
        </li>
        <li class="dropdown" id="commission">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                Commissions
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('admin/commissionAdminPanel')
            </ul>
        </li>
        <li class="dropdown" id="logistics">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                Logistics
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('logistics/logisticsAdminPanel')
            </ul>
        </li>
		{{--
        <li class="dropdown" id="advertisement">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                Advertisement
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('advertisement/advertisementAdminPanel')
            </ul>
        </li>
		--}}
        <li class="dropdown" id="crm">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                CRM
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('crm/crmAdminPanel')
            </ul>
        </li>
        <li class="dropdown" id="analytics">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
			   Analytics
               <b class="caret"></b>&nbsp;&nbsp;
			</a>
            <ul class="dropdown-menu">
                @include('analytics/analyticsAdminPanel')
            </ul>
        </li>
        <li class="dropdown" id="mlmcomm">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
			   MLM Commissions
               <b class="caret"></b>&nbsp;&nbsp;
			</a>
            <ul class="dropdown-menu">
          			@include('mlmCommissions/mlmCommssionsPanel')
            </ul>
        </li>



		{{--
        <li class="dropdown" id="smm">
            <a class="dropdown-toggle" style="margin-left:0;padding-right:0"
               data-toggle="dropdown">
                SMM
                <b class="caret"></b>&nbsp;&nbsp;
              </a>
            <ul class="dropdown-menu">
                @include('admin/smmAdminPanel')
            </ul>
        </li>
		--}}
    </ul>
</div>
<br><br><br>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#grid').DataTable({
                'scrollX':true,
                 'autoWidth':false
            });

            var url = document.location.href;
            $('.collapse').removeClass('in');
            var path = document.location.pathname;
            var res = path.split("/");
            res = res[2];

            $("#"+res).addClass("current_nav");

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
