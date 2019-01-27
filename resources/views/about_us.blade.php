@include("common.head")
<style>
.rain {
	position: relative;
	top: 250px;
	left: 120px;
	font-family: LatoLatin;
	font-size:100px;
	color:white;
}
.ver {
	position: relative;
	top: 302px;
	left: -50px;
	font-family: LatoLatin;
	font-size:50px;
	color:white;
} 
.env {
	text-align: center;
	position: relative;
	top: 240px;
	font-family: Arial;
	font-size:25px;
	color:white;
}
.cover {
	width:1000px;
	height:815px;
	padding:0;
	background-size:cover;
	background-image:url('/images/cprofile/cover_100x815.jpg');
}
.enter {
	text-align: center;
	position: relative;
	top: 340px;
	width:300px;
	padding-top: 20px;
	padding-bottom: 20px;
	padding-left: 60px;
	padding-right: 60px;
	font-family: Arial;
	font-size:25px;
	border: 3px solid white;
	color:white;
}
.logo {
	position: relative;
	top: 420px;
	right:40px;
	position: relative;
	width:300px;
}
</style>
<body>
<div class="cover">
<div class="row" style="margin-left:0;margin-right:0">
	<div class="col-sm-10 rain">RAIN FOREST</div>
	<div class="col-sm-2 ver">1.0</div>
</div>
<div class="col-sm-12 env">Environment</div>
<div class="row text-center" style="margin-left:0;margin-right:0">
<!--
	<button type="button"
		onclick="window.location='/content'"
		class="btn btn-primary btn-lg enter">Enter</button>
-->
	<a class="enter" href="/content"> Enter </a>
</div>
<div class="row pull-right" style="margin-left:0;margin-right:0">
<img class="logo" src="/images/logo-white.png"/>
</div>

</div>
{{--
{!! $about_us !!}
--}}
</body>
