@extends('common.default')
<style type="text/css">
	.tblbg > thead>tr>th{
		background-color: grey;
		color: white;
		/*border:2px solid red;*/
		/*text-align: center;*/
	}
	#hContainer h3,
	#hContainer a{
		display: inline;
		vertical-align: top;
		line-height: 2em;
		/*margin-bottom: 10px;*/
	}
	tr{
		border:none;
	}
	
	.borderless td, .borderless th {
    border: none;
}
</style>
@section('content')
	@include('statement.core.merch')
@stop