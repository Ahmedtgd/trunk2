@extends('common.default')
@section('content')
<style>
   .has-error .form-control {
   border-color: #a94442;
   -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
   box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
   }
   p{
    font-family:'Lato', sans-serif !important;
    font-weight:300;
    font-size:14px;
    line-height:1.4;
    text-align: justify;
   }
   h4,h5{
    font-weight: 600;
   }
   h5{
    font-size: 16px;
   }
</style>
<div class="container" style="margin-bottom: 30px;">
	<div class="row">
	  <div class="col-xs-12">
		<h1 align="center" style="margin-top: 30px;">We Accept</h1>
		<h3 align="center" style="margin-top: 30px;">
			<img width="80" src="{{asset('/')}}images/banks/fpx.png">
			&nbsp;&nbsp;FPX Participating Banks</h3>
		<hr width="450px">
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/affin.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/affin-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/alliance.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/alliance-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/bank-islam.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/muamalat.png">
		</div>
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/cimb.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/cimb-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/hongleong.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/hongleong-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/hsbc.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/hsbc-amanah.png">
		</div>		
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/maybank.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/maybank-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/ocbc.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/ocbc-alamin.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/publicbank.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/publicbank-islamic.png">
		</div>	
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/rhb.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/rhb-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/standardchartered.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/standardchartered-saadiq.png">
		</div>
		<div class="clearfix"></div>
		<br>
		<!--
		<h3 align="center" style="margin-top: 30px;">
			<img width="40"
				src="{{asset('/')}}images/banks/jompay.png">
				&nbsp;&nbsp;JomPAY Participating Banks</h3>
		<hr width="450px">
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/affin.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/affin-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/agrobank.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/alliance.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/alliance-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/al-rajhi.png">
		</div>
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/ambank.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/ambank-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/bank-islam.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/bank-of-america.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/muamalat.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/bank-rakyat.png">
		</div>
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/bnp.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/bsn.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/mufg.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/cimb.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/cimb-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/citibank.png">
		</div>
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/deutsche.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/hongleong.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/hongleong-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/hsbc.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/hsbc-amanah.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/icbc.png">
		</div>
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/jp-morgan.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/kfh.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/maybank.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/maybank-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/mizuho.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/ocbc.png">
		</div>
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/ocbc-alamin.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/publicbank.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/publicbank-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/rhb.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/rhb-islamic.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/smbc.png">
		</div>
		
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/standardchartered.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/standardchartered-saadiq.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/UOB.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/bank-of-china-jp.png">
		</div>
		-->
		<br>
		<!--
		<div class="clearfix"></div>
		<h3 align="center" style="margin-top: 30px;">Credit Card</h3>
		<hr width="450px">
		<div class="col-sm-2">
			<img class="img-responsive"src="{{asset('/')}}images/banks/visa.png">
		</div>
		<div class="col-sm-2">
			<img class="img-responsive"
				src="{{asset('/')}}images/banks/mastercard.png">
		</div>
		-->
		<div class="clearfix"></div>
	  </div>
	</div>
 </div>


@stop
