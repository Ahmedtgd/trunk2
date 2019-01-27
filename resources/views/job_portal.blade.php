@extends("common.default")

@section("content")

<section class="jobportal">
	<div class="container"><!--Begin main cotainer-->
		<div class="row">
			<div class="col-sm-12 jobportal-banner"><br>
				<img src="images/jobportal.png" title="banner" class="img-responsive">
			</div>
			<div class="clearfix"></div>

			<div class="col-sm-6 text-center jp-merchants">
				<h1 class="border-green">Merchant Consultant</h1>
				<p>A merchant consultant helps merchants to get on board our system as quickly as possible,
					from the aspect of products registration all the way to pricing.
				Our Knowledgeable merchant consultants will provide friendly and dependable service each step of the way. </p>
				<a href="#" class="btn btn-green btn-lg m-pos" data-toggle="modal" data-target="#jobportalModalm">APPLY NOW</a>
			</div>
			<div class="col-sm-3 no-padding-right">
				<img src="images/jp1.jpg" alt="" class="img-responsive height400">
			</div>
			<div class="col-sm-3 ">
				<img src="images/jp2.png" alt="" class="img-responsive height400">
			</div>
			<div class="clearfix" style="margin-bottom: 50px"></div>
			<div class="col-sm-6 no-padding-right">
				<img src="images/jp3.png" alt="" class="img-responsive">
			</div>
			<div class="col-sm-6 text-center jp-web">
				<h1 class="border-pink">Web Programmer & Mobile App Developer</h1>
				<p>You will be part of a creative team that is responsible for all aspects of the ongoing software development from the initial specification, through to developing, testing, creation, and modification of our web and mobile applications by converting business requirements into actual code.</p>
				<a href="#" class="btn btn-pink btn-lg w-pos" data-toggle="modal" data-target="#jobportalModalw">APPLY NOW</a>
			</div>
			<div class="clearfix"></div>
			<div class="col-sm-12 jp-web-banner">
				<div class="col-sm-6 img">
					<div class="row">
						<img src="images/jp4.png" alt="" class="img-responsive height400">
					</div>
				</div>
				<div class="col-sm-6 img">
					<div class="row">
						<img src="images/jp5.png" alt="" class="img-responsive height400">
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>

			<div class="col-sm-6 text-center jp-ope">
				<h1 class="border-brown">Operation Executive</h1>
				<p>Responsible for interacting with merchants or buyers to solve problems and issues with our web/mobile platform. This is in addition to maintaining a smooth running operations daily.</p>
				<a href="#" class="btn btn-brown btn-lg o-pos" data-toggle="modal" data-target="#jobportalModalo">APPLY NOW</a>
			</div>
			<div class="col-sm-6">
				<img src="images/jp6.png" alt="" class="img-responsive">
			</div>
			<div class="clearfix"></div>

	</div>
	</div><!--End main cotainer-->
</section>

<!-- Modal -->
<form class="form-horizontal" action="{{ URL::to('JobStore') }}" method="post">

	<div class="jobportalModal modal fade" id="jobportalModalm" tabindex="-1" role="dialog"
		 aria-labelledby="jobportalModalm">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="background-color:rgba(187, 225, 212, .85)">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel">Welcome to Apply Job with us</h2>
				<h5 class="modal-title">For enquiry please fill in information below</h5>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="col-sm-4 control-label">Full Name: </label>
					<div class="col-sm-8">
						<input type="text" name="name" placeholder="Type your name" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Contact Number: </label>
					<div class="col-sm-8">
						<!-- <input type="text" placeholder="6012-510 5696" class="form-control">-->
						<input type="text" name="phone" placeholder="Type your contact number" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Email id: </label>
					<div class="col-sm-8">
						<!-- <input type="text" placeholder="6012-510 5696" class="form-control">-->
						<input type="text" name="email" placeholder="Type your email id" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Position Apply: </label>
					<div class="col-sm-8">
							<!--<input type="text"  placeholder="Merchant Consultant" class="job-position form-control">-->
						<input type="text" name="position_applied" value="Merchant Consultant"
							   class="job-position form-control" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Remarks</label>
					<div class="col-sm-8">
						<!--<textarea class="form-control" placeholder="Graduate from Sunway University"></textarea>-->
						<textarea class="form-control" name="remarks"
								  placeholder="Type your information here"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<label class="col-sm-10 text-left margin-top">Email: qiaohua.intermedius@gmail.com</label>
				<button class="btn btn-self col-sm-2" type="submit" style="background-color: rgb(39,169,138)">send
				</button>
			</div>
		</div>
	</div>
</div>
</form>
<form class="form-horizontal" action="{{ URL::to('JobStore') }}" method="post">

<div class="jobportalModal modal fade" id="jobportalModalw" tabindex="-1" role="dialog" aria-labelledby="jobportalModalw">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  style="background-color:rgba(173, 131, 141, 0.85)">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel">Welcome to Apply Job with us</h2>
				<h5 class="modal-title">For enquiry please fill in information below</h5>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="col-sm-4 control-label">Full Name: </label>
					<div class="col-sm-8">
						<input type="text" name="name" placeholder="Type your name" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Contact Number: </label>
					<div class="col-sm-8">
						<!-- <input type="text" placeholder="6012-510 5696" class="form-control"> -->
						<input type="text" name="phone" placeholder="Type your contact number" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Email id: </label>
					<div class="col-sm-8">
						<!-- <input type="text" placeholder="6012-510 5696" class="form-control">-->
						<input type="text" name="email" placeholder="Type your email id" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Position Apply: </label>
					<div class="col-sm-8">
							<!-- <input type="text"  placeholder="Web Programmer & Mobile App Developer" class="job-position form-control"> -->
						<input type="text" name="position_applied" value="Web Programmer & Mobile App Developer"
							   class="job-position form-control" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Remarks</label>
					<div class="col-sm-8">
						<!-- <textarea class="form-control" placeholder="Graduate from Sunway University"></textarea>-->
						<textarea class="form-control" name="remarks"
								  placeholder="Type your information here"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<label class="col-sm-10 text-left margin-top">Email: qiaohua.intermedius@gmail.com</label>
				<button class="btn btn-self col-sm-2" type="submit" style="background-color:rgb(255,0,128)">send
				</button>
			</div>
		</div>
	</div>
</div>

</form>
<form class="form-horizontal" action="{{ URL::to('JobStore') }}" method="post">

	<div class="jobportalModal modal fade" id="jobportalModalo" tabindex="-1" role="dialog"
		 aria-labelledby="jobportalModalo">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  style="background-color:rgba(162, 111, 92, .85)">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel">Welcome to Apply Job with us</h2>
				<h5 class="modal-title">For enquiry please fill in information below</h5>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="col-sm-4 control-label">Full Name: </label>
					<div class="col-sm-8">
						<input type="text" name="name" placeholder="Type your name" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Contact Number: </label>
					<div class="col-sm-8">
						<!-- <input type="text" placeholder="6012-510 5696" class="form-control">-->
						<input type="text" name="phone" placeholder="Type your contact number" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Email id: </label>
					<div class="col-sm-8">
						<!-- <input type="text" placeholder="6012-510 5696" class="form-control">-->
						<input type="text" name="email" placeholder="Type your email id" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Position Apply: </label>
					<div class="col-sm-8">
							<!-- <input type="text"  placeholder="Operation Executive" class="job-position form-control"> -->
						<input type="text" name="position_applied" value="Operation Executive"
							   class="job-position form-control" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Remarks</label>
					<div class="col-sm-8">
						<!-- <textarea class="form-control" placeholder="Graduate from Sunway University"></textarea> -->
						<textarea class="form-control" name="remarks"
								  placeholder="Type your information here"></textarea>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<label class="col-sm-10 text-left margin-top">Email: qiaohua.intermedius@gmail.com</label>
				<button class="btn btn-self col-sm-2" type="submit" style="background-color:rgb(194, 125, 85)">send
				</button>
			</div>
		</div>
	</div>
</div>
</form>
@stop