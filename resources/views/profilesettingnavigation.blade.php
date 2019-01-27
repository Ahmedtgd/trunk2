<div class="oshop-navigation">
	<nav class="navbar navbar-static">
		<div class="row" style="margin-top: 0; margin-bottom: 0;">
			<div  class="navbar-collapse collapse ">
				{{-- <ul  class="nav navbar-nav custom-navbar">
					<li class="pull-left" ><a style="color:white; font-size:25px;" href="/" class="active">About</a></li>
					<li><a style="color:white; font-size:25px;">Certificate</a></li>
					<li><a style="color:white; font-size:25px;">Supplier</a>&nbsp; &nbsp; &nbsp;</li>
				</ul> --}}

				<ul class="nav navbar-nav">
					<li><a style="color: #000; font-size:25px;"
						href="{{route('profilesettingaboutus',
							[$merchant->first()->id])}}">About</a></li>

					<li><a style="color: #000; font-size:25px;"
						href="{{route('profilesettingcertificate',
							[$merchant->first()->id])}}">Certificate</a></li>

					<li><a style="color: #000; font-size:25px;"
						href="#">Dealer</a></li> 

					<li><a style="color: #000; font-size:25px;"
						href="#">O-Warehouse</a></li>

					<li><a style="color: #000; font-size:25px;"
						href="#">OEM</a></li>
				</ul>
				<ul class="nav navbar-nav pull-right">
					<li ><button style="background:rgb(0,99,98);border:none; padding: 10px; margin-top:5px" class="">
						<a style="color:white; text-decoration:none;" href="">
						<strong><i class="fa fa-link fa-lg"></i></strong>
						&nbsp;&nbsp;&nbsp;AutoLink&nbsp;&nbsp;&nbsp;&nbsp;</a></button></li>
					<li><a style="color:#000; font-size: 23px;"
						href="{{route('oshop.one',[$merchant->first()->id])}}">OFFICIAL SHOP</a></li>
					<li style="color:white; margin-top:15px">
						<img style="width:30px; height:20px"
						src="{{ asset('images/malaysia.png') }}">&nbsp;</li>
					<li style="background:rgb(224,40,120); color:white; margin-top:15px">
						&nbsp;&nbsp;&nbsp;Like&nbsp; &nbsp;&nbsp; &nbsp;</li>
				</ul>
			</div>
		</div>
	</nav>
</div>
