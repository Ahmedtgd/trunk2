<!DOCTYPE html>
<html>
<?php
$mode=Session::get('mode');
?>
{{--
{{ Counter::count(Request::path(), \Auth::check() ? \Auth::user()->id : null) }}
--}}
@include('common.head')

<body>
	@if(isset($viewtype) && $mode=="onz" && $viewtype=="whiteifonz")
	@include('common.onzheader')
	@else
	@include('common.header')
	@endif
	@yield('content')
	@yield('scripts')
	@if(isset($viewtype) && $mode=="onz"&& $viewtype=="whiteifonz")
	@include('common.onzfooter')
	@else
	@include('common.footer')
	@endif
</body>
</html>
