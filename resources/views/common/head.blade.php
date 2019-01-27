<head>
	{{-- @include('common.fb_meta') --}} 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
		content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control"
		content="no-cache, no-store, must-revalidate" />
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">
    <meta name="base_url" content="{{ URL::to('/') }}">
    {{-- For Opengraph [FB] --}}
    <meta property="fb:app_id" content="1679564205590693" />
    <meta property="og:site_name" content="OpenSupermall" />
    @yield('opengraph')

    <title>OpenSupermall.com</title>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <!-- Font Family -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/lato.css')}}">
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"> --}}
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/bootstrapValidator.css')}}"/>
	<link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/jqgrid/ui.jqgrid.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/datatable.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/build.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen"/>
    <link rel="stylesheet" href="{{asset('/datepicker/public/css/default.css')}}" media="screen"/>
    <link rel="stylesheet" href="{{asset('/css/jquery.timepicker.css')}}" media="screen"/>


    <link rel="stylesheet" href="{{asset('/colorpicker/colorpicker.css')}}">
    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/custom.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/owarehouse.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/toastr.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/productdealer.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/w3.css')}}"/>


    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('summernote/summernote.css')}}">

    <!--dialogue box-->
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">

    {{-- added slick slider css by rahul --}}
    <link rel="stylesheet" href="{{asset('/slick/slick.css')}}"/>
    <link rel="stylesheet" href="{{asset('/slick/slick-theme.css')}}"/>

    <!--end of dialogue box-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="{{asset('/js/jquery_debounce.js')}}"></script>

    <script type="text/javascript" src="{{asset('/summernote/summernote.js')}}"></script>

    <!-- Dialogue Box -->
    <script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/bootstrapValidator.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/parsley.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/datetimepicker/moment.js')}}"></script>
    <script type="text/javascript" src="{{asset('/datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery.timepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('/datepicker/public/javascript/zebra_datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('/colorpicker/colorpicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/bootstrap-select.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery.easing.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/jqgrid/grid.locale-en.js')}}"></script>
    <script type="text/javascript" src="{{asset('/jqgrid/jquery.jqGrid.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/highcharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/exporting.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery.number.min.js')}}">

    </script>
    <script type="text/javascript" src="{{asset('js/bdialog.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/custom.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/jsslide.min.js')}}"></script>
	<script src="{{url('js/jquery.ajax-progress.js')}}"></script>
	<script src="{{url('js/progressbar.js')}}"></script>
    <!--end of dialogue box-->
    <link rel="stylesheet" href="{{asset('css/timepicki.css')}}">
    <script type="text/javascript" src="{{asset('/js/timepicki.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/select2.min.js')}}"></script>

	<!--
    <script type="text/javascript" src="{{asset('js/video.js')}}"></script>
	-->
    <script type="text/javascript" src="{{asset('videoplayer/embed.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/scripts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/profilesetting.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/account.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/js/jquery.easy-autocomplete.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/easy-autocomplete.css')}}">
    <link rel="stylesheet" href="{{asset('css/easy-autocomplete.themes.css')}}">

    {{-- Sweet alerts --}}
	{{--
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	--}}
    <script type="text/javascript" src="{{asset('js/sweetalert.min.js')}}"></script>

    {{-- added slick slider js by rahul --}}
    <script type="text/javascript" src="{{asset('slick/slick.min.js')}}"></script>

    {{-- Revenue --}}
    <script> var JS_BASE_URL = '{{ url('/') }}'; </script>

    @yield('extra-links')

    <style>
        .selected {
            outline: 3px solid #27A98A;
        }
        .btn-standard{
          width:70px;height:70px;border-radius:5px;
                margin-bottom:5px;padding-left:10px;padding-top:8px;
        }
        .highlight-product {
            outline: 2px solid #27A98A;
        }
        .clickable { cursor: pointer; }
        .cE{
            background: red;
        }
        .btn-process{
            background: #8EB4E3;
            color: white;
        }
        .btn-calll{
            background: #008000;
            color: white;
        }
        .btn-start{
            background: #FF0000;
            color: white;
        }
        .btn-buy{
            background: #00ff00;
            color: white;
        }
        .btn-return{
            background: #008000;
            color: white;
        }
        .btn-approval{
            background: #286090;
            color: white;
        }
        .btn-openwish{
            background-color:#d7e748 ;
            color: black;
        }
        .btn-approval:hover{
            color:white !important;
        }
        .btn-label{
            background: #8EB4E3;
            color: white;
        }
        .btn-cancel{
            background:#FF0000;
            color: white;
        }
        .btn-feedback{
            background:#948A54;
            color: white;
        }
        .btn-review{
           background: #D8E26D;
           color:white;
           text-decoration: none;
        }
        .spinner {
          display: inline-block;
          opacity: 0;
          max-width: 0;

          -webkit-transition: opacity 0.25s, max-width 0.45s;
          -moz-transition: opacity 0.25s, max-width 0.45s;
          -o-transition: opacity 0.25s, max-width 0.45s;
		  /* Duration fixed since we animate additional hidden width */
          transition: opacity 0.25s, max-width 0.45s;
        }

        .has-spinner.active {
          cursor:progress;
        }

        .has-spinner.active .spinner {
          opacity: 1;
		 /* More than it will ever come, notice that this affects
		  * on animation duration */
          max-width: 50px;
        }

        @yield('css')
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
              });
        });
    </script>

	<!--
	<?php //include_once("analytics/analyticstracking.php") ?>
	<script async
		src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
	</script>
	-->

	<!-- Google AdSense -->
	<!--
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-3437469133741186",
		enable_page_level_ads: true
	  });
	</script>
	-->

	<!-- Piwik/Matomo -->
	{{--
	@include('common.matomo_client')
	--}}

</head>
