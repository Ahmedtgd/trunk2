@extends("common.default")

@section("content")

<section class="">
	<div class="container"><!--Begin main cotainer-->
		<div class="row">

			<div class="col-sm-12">
				<img src="images/Buyerregistration.png" title="banner" class="img-responsive">
			<h1 class="page-title">News</h1>
			<div class="thumbnail newsletter">
				<div class="col-sm-5 col-sm-offset-1">
					<h1>Subscribe to our newsletter to get our latest news.</h1>
					<a class="btn btn-green btn-round" data-toggle="modal" data-target="#newsletterModal"> Subscribe </a>
				</div>
				<div class="col-sm-4 col-sm-offset-1">
					<img alt="" src="images/newsipadair.jpg" class="img-responsive">
				</div>
				<div class="clearfix"></div>
			</div>
			</div>
	</div>
	</div><!--End main cotainer-->
</section>

<!-- Modal -->
{!! Form::open(array('url'=> route('newsletter.store') , 'method'=>'post' , 'class'=> 'form-horizontal')) !!}

<div class="modal fade" id="newsletterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel">Welcome to OpenSupermall.com</h2>
				<h5 class="modal-title">For enquiry please fill in information below</h5>
			</div>
			<div class="modal-body">
				<div class="form-group">
					{!! Form::label('full_name', 'Full Name', array('class' => 'col-sm-4 control-label')) !!}
					<div class="col-sm-8">
						{!! Form::text('full_name', null, array('placeholder'=>'Type your name', 'class' => 'form-control'))!!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('contact_number', 'Contact Number', array('class' => 'col-sm-4 control-label')) !!}
					<div class="col-sm-8">
						{!! Form::text('contact_number', null, array('placeholder'=>'Type your contact number', 'class' => 'numeric form-control'))!!}
					</div>
				</div>
				<div class="form-group">
					{!! Form::label('email', 'Email', array('class' => 'col-sm-4 control-label')) !!}
					<div class="col-sm-8">
						{!! Form::email('email', null, array('placeholder'=>'Type your Email', 'class' => 'form-control'))!!}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				{!! Form::submit('Cancel', array('data-dismiss'=>'modal' , 'class' => 'btn btn-green btn-round')) !!}
				{!! Form::submit('Submit', array('class' => 'btn btn-green btn-round')) !!}
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@stop