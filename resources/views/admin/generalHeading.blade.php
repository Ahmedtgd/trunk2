<?php
use App\Classes;
?>

@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px; margin-bottom:30px;">
        @include('admin/panelHeading')
</div>

<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>

@yield("left_sidebar_scripts")
@stop
