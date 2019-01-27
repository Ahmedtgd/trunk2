@extends("common.default")


@section("content")
    <script type="text/javascript">
        $(document).ready(function(){
            var $select = $('select').select2();
            $select.each(function(i,item){
                $(item).select2("destroy");
            });


            function toggleIcon(e) {
                $(e.target)
                        .prev('.panel-heading')
                        .find(".more-less")
                        .toggleClass('glyphicon-plus glyphicon-minus');
            }
            $('.panel-group').on('hidden.bs.collapse', toggleIcon);
            $('.panel-group').on('shown.bs.collapse', toggleIcon);
        });
    </script>

    <style type="text/css">
        .container, .navbar{
            padding-bottom:0 !important;
            margin-bottom:0 !important;
        }
        .search-banner{
            background: url(/search-banner-bg.jpg) no-repeat center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            height: 400px;
        }
        .center-block {
            float: none;
            margin-left: auto;
            margin-right: auto;
        }

        .input-group .icon-addon .form-control {
            border-radius: 0;
        }

        .icon-addon {
            position: relative;
            color: #555;
            display: block;
        }

        .icon-addon:after,
        .icon-addon:before {
            display: table;
            content: " ";
        }

        .icon-addon:after {
            clear: both;
        }

        .icon-addon.addon-md .glyphicon,
        .icon-addon .glyphicon,
        .icon-addon.addon-md .fa,
        .icon-addon .fa {
            position: absolute;
            z-index: 2;
            left: 10px;
            font-size: 14px;
            width: 20px;
            margin-left: -2.5px;
            text-align: center;
            padding: 10px 0;
            top: 1px
        }

        .icon-addon.addon-lg .form-control {
            line-height: 1.33;
            height: 46px;
            font-size: 18px;
            padding: 10px 16px 10px 40px;
        }

        .icon-addon.addon-sm .form-control {
            height: 30px;
            padding: 5px 10px 5px 28px;
            font-size: 12px;
            line-height: 1.5;
        }

        .icon-addon.addon-lg .fa,
        .icon-addon.addon-lg .glyphicon {
            font-size: 18px;
            margin-left: 0;
            left: 11px;
            top: 4px;
        }

        .icon-addon.addon-md .form-control,
        .icon-addon .form-control {
            padding-left: 30px;
            float: left;
            font-weight: normal;
        }

        .icon-addon.addon-sm .fa,
        .icon-addon.addon-sm .glyphicon {
            margin-left: 0;
            font-size: 12px;
            left: 5px;
            top: -1px
        }

        .icon-addon .form-control:focus + .glyphicon,
        .icon-addon:hover .glyphicon,
        .icon-addon .form-control:focus + .fa,
        .icon-addon:hover .fa {
            color: #2580db;
        }

        .help-options .jumbotron{
            border-radius: 0;
            -moz-border-radius: 0;
            -webkit-border-radius: 0;
        }
        .help-options .live-chat{
            padding-right: 0;
        }
        .help-options .live-chat .jumbotron{
            background:#F7F8F9
        }
        .help-options .knowledge-based{
            padding-left: 0;
        }
        .help-options .knowledge-based .jumbotron{
            background: #EDF9E5;
        }


        .faqs  .panel-group .panel {
            border-radius: 0;
            box-shadow: none;
            border-color: #EEEEEE;
        }
        .faqs .panel-default > .panel-heading {
            padding: 0;
            border-radius: 0;
            color: #212121;
            background-color: #FAFAFA;
            border-color: #EEEEEE;
        }
        .faqs .panel-title {
            font-size: 14px;
        }
        .faqs  .panel-title > a {
            display: block;
            padding: 15px;
            text-decoration: none;
        }
        .faqs  .more-less {
            float: right;
            color: #212121;
        }
        .faqs .panel-default > .panel-heading + .panel-collapse > .panel-body {
            border-top-color: #EEEEEE;
        }
        .faqs .panel-collapse{
            border: 0;
        }

        .faqs .panel-body{
            border-top: 0;
        }

    </style>


    <div class="jumbotron search-banner">
        <div class="container">
            <div class="row">
                <div id="custom-search-input" style="text-align: center; margin-bottom: 5%;">
                    <div class="input-group col-md-6 col-md-offset-3">
                        <h2 style="color:#fff;">Welcome to OpenSupport</h2>

                        <div class="form-group">
                            <div class="icon-addon addon-lg">
                                <input type="text" placeholder="Search Support" class="form-control" id="q">
                                <label for="q" class="glyphicon glyphicon-search" rel="tooltip" title="Search"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section>
        <div class="container help-options">
            <div class="row">
                <div class="col-md-6 live-chat">
                    <div class="jumbotron">
                        <h3><i class="fa fa-comments" aria-hidden="true" style="color: #539211;"></i> Live Chat</h3>
                        <p class="lead">Chat instantly with our support team.</p>
                        <p><a class="btn btn-lg btn-success" href="#" role="button">Go To Live Chat</a></p>
                    </div>
                </div>
                <div class="col-md-6 knowledge-based">
                    <div class="jumbotron">
                        <h3><i class="fa fa-clipboard" aria-hidden="true"></i> Knowledge Base</h3>
                        <p class="lead">Get help based on our knowledge based.</p>
                        <p><a class="btn btn-lg btn-success" href="#" role="button">Go To HelpDesk</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section style="margin-top: 50px;">
        <div class="container faqs">

            <h2>FAQ - Find answers quickly</h2><br>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                What is OpenSupermall return policy
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          -
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                Where is OpenSupermall Located?
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            -
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                How do become a Merchant
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            -
                        </div>
                    </div>
                </div>

            </div><!-- panel-group -->
        </div>
    </section>


@stop
