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
            background: url(images/search-banner-bg.jpg) no-repeat center center;
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

        .select2-dropdown.select2-dropdown--below{

        }

        .select2-selection__rendered{
            color: #7c7c7c !important;
            padding-left: 10px !important;
        }

        .select2-container--default .select2-selection--single{
            height: 35px;
            padding-top:2px;
            padding-bottom:4px;
            font-size: 1.2em;
            position: relative;
            border-radius: 0;
            border: 1px solid #ccc;
            color: #ccc;
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
                        <div class="form-group" style="width: 100%;">
                            <label><h3>What is:</h3></label>
                            <select id="what_is" name="what_is" class="form-control">
                                <option value="" selected="selected">Select</option>
                                @if(isset($what_is))
                                    @foreach($what_is as $w)
                                        <option data-text="{{$w->answer}}" value="{{$w->id}}">{{$w->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 knowledge-based">
                    <div class="jumbotron">
                        <div class="form-group" style="width: 100%;">
                            <label><h3>How to:</h3></label>
                            <select id="how_to" name="how_to" class="form-control">
                                <option value="" selected="selected">Select</option>
                                @if(isset($how_to))
                                    @foreach($how_to as $c)
                                        <option data-text="{{$c->answer}}" value="{{$c->id}}">{{$c->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="knowledge" style="display: none;">
                <div class="col-md-12">
                    <div class="panel panel-default" style="border-radius:0; -webkit-border-radius: 0; -moz-border-radius: 0;">
                        <div class="panel-heading" style="font-weight: bold; font-size: 14px; background-color: #fbfcfd;"></div>
                        <div class="panel-body"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container help-options">
            <div class="row" id="iwantto">
                <div class="col-md-12">
                    <div class="panel panel-default" style="border-radius:0; -webkit-border-radius: 0; -moz-border-radius: 0;">
                        <div class="panel-heading" style="font-weight: bold; font-size: 14px; background-color: #fbfcfd;">
                            <div class="form-group" style="margin-bottom: 0;">
                                {{--<label><h3>I want to become</h3></label>--}}
                                <select id="i_want_to" name="i_want_to" class="form-control">
                                    <option value="" selected="selected">I want to become</option>
                                    @if(isset($i_want_to))
                                        @foreach($i_want_to as $i)
                                            <option value="{{$i->id}}">{{$i->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        <div class="panel-body"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section style="margin-bottom: 50px;">
        <div class="container">
            <div class="col-md -12">
                <div class="form-group">
                    <label><h3>Feedback</h3></label>
                    <textarea class="form-control" rows="6">
                    </textarea>
                </div>
            </div>

            <div class="col-md -12">
                <button class="btn btn-lg btn-success pull-right">Submit</button>
            </div>

            {{--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading" role="tab" id="headingOne">--}}
                        {{--<h4 class="panel-title">--}}
                            {{--<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">--}}
                                {{--<i class="more-less glyphicon glyphicon-plus"></i>--}}
                                {{--What is OpenSupermall return policy--}}
                            {{--</a>--}}
                        {{--</h4>--}}
                    {{--</div>--}}
                    {{--<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">--}}
                        {{--<div class="panel-body">--}}
                          {{-----}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading" role="tab" id="headingTwo">--}}
                        {{--<h4 class="panel-title">--}}
                            {{--<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">--}}
                                {{--<i class="more-less glyphicon glyphicon-plus"></i>--}}
                                {{--Where is OpenSupermall Located?--}}
                            {{--</a>--}}
                        {{--</h4>--}}
                    {{--</div>--}}
                    {{--<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">--}}
                        {{--<div class="panel-body">--}}
                            {{-----}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading" role="tab" id="headingThree">--}}
                        {{--<h4 class="panel-title">--}}
                            {{--<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">--}}
                                {{--<i class="more-less glyphicon glyphicon-plus"></i>--}}
                                {{--How do become a Merchant--}}
                            {{--</a>--}}
                        {{--</h4>--}}
                    {{--</div>--}}
                    {{--<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">--}}
                        {{--<div class="panel-body">--}}
                            {{-----}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div><!-- panel-group -->--}}
        </div>
    </section>

    <script>
        $(document).ready(function()
        {
            $('#what_is').change(function(e)
            {
                var selected = $(this).find(':selected');
                var question = selected.html();
                var answer = selected.attr('data-text');

                $('#knowledge').find('.panel-heading').html(question);
                $('#knowledge').find('.panel-body').html(answer);
                $('#knowledge').show();
            });

            $('#how_to').change(function(e)
            {
                var selected = $(this).find(':selected');
                var question = selected.html();
                var answer = selected.attr('data-text');

                $('#knowledge').find('.panel-heading').html(question);
                $('#knowledge').find('.panel-body').html(answer);
                $('#knowledge').show();
            });
        });
    </script>

@stop
