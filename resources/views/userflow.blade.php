@extends("common.default")
<?php

use App\Classes;
?>
@section("content")

<!--//////////////////////////////////////////-->
<!--////  User Flow Analysis Inline Styling //-->
<!--//////////////////////////////////////////-->   
<style>
    .container .btn-info{
        width: 265px;
    }

    .container{
        margin-bottom: 40px;
    }
    .container .btn-primary{
        border-radius: 5px;
        margin-left: 50px;
        margin-bottom: 15px;
    }
    tr th:first-child {
        width: 265px;
    }
    .btn span{

    }
    thead tr th{
        background-color: #cc9900;
        color:#ffffff;
        font-size: 12px; 
    }
    tr th, tr td{
        font-size: 15px;
    }
    #btn_status, #btn_status2, #btn_status3{
        background-color:#663300;
        border:none;
        clear:both;

    }
    tbody tr td{
        text-align: center;
    }
    .thead-default tr th{
        text-align: center;
        font-size: 15px;
    }
</style>
<div class="container">
    @include('admin/panelHeading')
    <h2 style="display:inline-block">User Flow Analysis</h2>
    <button type="button" id= "refresh" class="btn btn-primary">
        Refresh</button>
    <i id="loading_message" class="fa fa-spinner fa-spin fa-2x"></i>
    <h1 hidden="">page hits: {{ Counter::allHits() }}</h1>
    <div class="row">
    </div>
    <div class="accordion" id="accordion3">     
        <div class="accordion-group">
            <div class="accordion-heading">
                <button type="button" id="btn_status"
                        class="accordion-toggle btn btn-info"
                        data-toggle="collapse" href="#collapseOne">
                    <i class="glyphicon glyphicon-chevron-right" style="float:left"></i> Global
                </button>
            </div>
            <div id="collapseOne" class="accordion-body collapse in">
                <div class="accordion-inner" style="overflow:auto">
                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <th style="background-color:#ffffff">#</th>
                                <th>/Year</th>
                                <th>/Month</th>
                                <th>/Day</th>
                                <th>/Hour</th>
                                <th>/Minute</th>
                                <th>/Second</th>
                            </tr>
                        </thead>
                        <tbody id="updateSection">
                            <tr id="global_logins"></tr>
                            <tr id="global_new_registration"></tr>
                            <tr id="global_account_termination"></tr>
                            <tr id="global_transactions"></tr>
                            <tr id="global_clicks"></tr>
                        </tbody>
                    </table>                  
                </div>
            </div>
        </div>

        <div class="accordion-group">
            <div class="accordion-heading">
                <button type="button" id="btn_status2"
                        class="accordion-toggle btn btn-info"
                        data-toggle="collapse" href="#collapseTwo">
                    <i class="glyphicon glyphicon-chevron-right"
                       style="float:left"></i> Malaysia
                </button> 
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner" style="overflow:auto">
                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <th style="background-color:#ffffff">#</th>
                                <th>/Year</th>
                                <th>/Month</th>
                                <th>/Day</th>
                                <th>/Hour</th>
                                <th>/Minute</th>
                                <th>/Second</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr id="mys_logins"></tr>
                            <tr id="mys_new_registration"></tr>
                            <tr id="mys_account_termination"></tr>
                            <tr id="mys_transactions"></tr>
                            <tr id="mys_clicks"></tr>
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>

        <div class="accordion-group">
            <div class="accordion-heading">
                <button type="button" id="btn_status3" class="accordion-toggle btn btn-info" data-toggle="collapse" href="#collapsetwo">
                    <i class="glyphicon glyphicon-chevron-right" style="float:left"></i> Hong Kong
                </button> 
            </div>
            <div id="collapsetwo" class="accordion-body collapse">
                <div class="accordion-inner" style="overflow:auto">
                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <th style="background-color:#ffffff">#</th>
                                <th>/Year</th>
                                <th>/Month</th>
                                <th>/Day</th>
                                <th>/Hour</th>
                                <th>/Minute</th>
                                <th>/Second</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="hkg_logins"></tr>
                            <tr id="hkg_new_registration"></tr>
                            <tr id="hkg_account_termination"></tr>
                            <tr id="hkg_transactions"></tr>
                            <tr id="hkg_clicks"></tr>
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>    
        <?php ?>

                <!-- Full response: <pre id="details"></pre> -->


    </div>              
</div>

<!--//////////////////////////////////////////-->
<!--////    Script to Change Glyph-icons    //-->
<!--//////////////////////////////////////////--> 
<script type="text/javascript">
    $('#btn_status').click(function () {
        $(this).find('i').toggleClass('glyphicon glyphicon-chevron-right').toggleClass('glyphicon glyphicon-chevron-down');
    });

    $('#btn_status2').click(function () {
        $(this).find('i').toggleClass('glyphicon glyphicon-chevron-right').toggleClass('glyphicon glyphicon-chevron-down');
    });

    $('#btn_status3').click(function () {
        $(this).find('i').toggleClass('glyphicon glyphicon-chevron-right').toggleClass('glyphicon glyphicon-chevron-down');
    });
</script>
<script>
    //for refreshing data without reload

    $('#refresh').click(function () {
        $("#loading_message").show();
        /*var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         $("#accordion3").html(xmlhttp.responseText);
         }
         }
         xmlhttp.open("GET", "refresh", true);
         xmlhttp.send();*/
        get_counts();
    });
    get_counts();
    function  get_counts() {
        $.ajax({
            url: './user_flow',
            type: 'POST',
            data: {"_token": '{{csrf_token()}}'},
        })
                .done(function (response) {
//                    console.log(response);
                    var d_p = 0;
                    /*Logins*/
                    $('#global_logins').html("<th scope=row>Logins</th><td>" +
                            Math.round(parseInt(response.logins.global_year_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.global_month_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.global_day30_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.global_hours24_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.global_minutes60_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.global_seconds60_count)/2) + "</td>" +
                            "");
                    $('#hkg_logins').html("<th scope=row>Logins</th><td>" +
                            Math.round(parseInt(response.logins.hkg_year_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.hkg_month_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.hkg_day30_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.hkg_hours24_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.hkg_minutes60_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.hkg_seconds60_count)/2) + "</td>" +
                            "");
                    $('#mys_logins').html("<th scope=row>Logins</th><td>" +
                            Math.round(parseInt(response.logins.my_year_count)/2)  + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.my_month_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.my_day30_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.my_hours24_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.my_minutes60_count)/2) + "</td>" +
                            "<td>" + Math.round(parseInt(response.logins.my_seconds60_count)/2) + "</td>" +
                            "");
                    /*End Logins*/

                    /*Transactions*/
                    $('#global_transactions').html("<th scope=row>Transactions</th><td>" +
                            response.transactions.global_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.global_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.global_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.global_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.global_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.global_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    $('#hkg_transactions').html("<th scope=row>Transactions</th><td>" +
                            response.transactions.hkg_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.hkg_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.hkg_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.hkg_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.hkg_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.hkg_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    $('#mys_transactions').html("<th scope=row>Transactions</th><td>" +
                            response.transactions.my_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.my_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.my_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.my_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.my_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.transactions.my_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    /*End Transactions*/

                    /*Account Terminations*/
                    $('#global_account_termination').html("<th scope=row>Account Suspension</th><td>" +
                            response.terminations.global_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.global_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.global_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.global_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.global_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.global_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    $('#hkg_account_termination').html("<th scope=row>Account Suspension</th><td>" +
                            response.terminations.hkg_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.hkg_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.hkg_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.hkg_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.hkg_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.hkg_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    $('#mys_account_termination').html("<th scope=row>Account Suspension</th><td>" +
                            response.terminations.my_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.my_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.my_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.my_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.my_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.terminations.my_seconds60_count.toFixed(d_p) + "</td>" +
                            "");

                    /********New Registered Accounts************/
                    $('#global_new_registration').html("<th scope=row>New User Registration</th><td>" +
                            response.new_registration.global_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.global_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.global_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.global_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.global_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.global_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    $('#mys_new_registration').html("<th scope=row>New User Registration</th><td>" +
                            response.new_registration.my_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.my_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.my_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.my_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.my_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.my_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    $('#hkg_new_registration').html("<th scope=row>New User Registration</th><td>" +
                            response.new_registration.hkg_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.hkg_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.hkg_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.hkg_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.hkg_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.new_registration.hkg_seconds60_count.toFixed(d_p) + "</td>" +
                            "");

                    /*Global site hits*/
                    $('#global_clicks').html("<th scope=row>Clicks</th><td>" +
                            response.site_hits.global_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.global_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.global_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.global_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.global_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.global_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    $('#mys_clicks').html("<th scope=row>Clicks</th><td>" +
                            response.site_hits.my_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.my_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.my_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.my_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.my_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.my_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                    $('#hkg_clicks').html("<th scope=row>Clicks</th><td>" +
                            response.site_hits.hkg_year_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.hkg_month_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.hkg_day30_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.hkg_hours24_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.hkg_minutes60_count.toFixed(d_p) + "</td>" +
                            "<td>" + response.site_hits.hkg_seconds60_count.toFixed(d_p) + "</td>" +
                            "");
                })
                .fail(function () {
                    console.log("error");
                })
                .always(function () {
                    $("#loading_message").hide();
                });

    }
</script>
<!--
<script type="text/javascript">
  $.get("http://ipinfo.io", function (response) {
$("#ip").html("IP: " + response.ip);
$("#address").html("Location: " + response.city + ", " + response.region);
$("#details").html(JSON.stringify(response, null, 4));
}, "jsonp");
</script>
-->  
@stop
