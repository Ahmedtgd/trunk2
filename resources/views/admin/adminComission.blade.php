@extends("common.default")

@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 18px;
        font-weight: bold;
        margin: 365px 0 0 610px;
    }
</style>
<?php $i=1; ?>
<div class="overlay" style="display:none;">
    <p>Please Wait...</p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')

	@if(isset($summary))
		@include('commissions/summary')
	@endif

	@if(isset($merchants))
		@include('commissions/merchants')
	@endif

	@if(isset($merchantsconsultant))
		@include('commissions/consultant')
	@endif

	@if(isset($merchantpusher))
		@include('commissions/pusher')
	@endif

	@if(isset($merchantsprofessional))
		@include('commissions/professional')
	@endif

	@if(isset($stations))
		@include('commissions/stations')
	@endif

	@if(isset($stationrecruiter))
		@include('commissions/recruiter')
	@endif

	@if(isset($smm))
		@include('commissions/smm')
	@endif
	
	@if(isset($logistic))
		@include('commissions/logistic')
	@endif	

</div>
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
	//
});
</script>
@yield("left_sidebar_scripts")
@stop
