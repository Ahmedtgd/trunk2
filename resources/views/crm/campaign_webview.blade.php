<?php
$og_desc=strip_tags(substr($campaign->template,0,500));
$og_desc="";
$og_image="images/campaign/".$campaign->image_path;
?>
@extends('common.default')
@section('opengraph')
<meta property="og:title" content="{{$campaign->name}}" />
<meta property="og:image" content="{{asset($og_image)}}" />
<meta property="og:description" content="{{$og_desc}}" />
<meta property="og:url" content="{{url("campaign",$campaign->id)}}" />
<meta property="og:type" content="website" />
@stop
@section('content')	
	{{-- OpenGraph --}}
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				{!! $campaign->template or 'No Content' !!}
			</div>
		</div>
		<div style="height: 300px;"></div>
	</div>
@stop