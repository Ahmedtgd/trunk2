@extends('common.default')
@section('content')
	
	<section>
		<div class="container"><!--Begin main cotainer-->
			<div class="row">
				<h2>
					Add Brands
					<hr />
				</h2>
				<div class="col-sm-6">
					@if ($errors->any())
						<div class="alert alert-danger">
							@foreach ($errors->all() as $error)
								{!! $error !!}<br/>
							@endforeach
						</div>
					@elseif(Session::has('success'))
						<div class="alert alert-success">
							Value Successfull Inserted.
						</div>
					@endif
					{!! Form::open(array('method'=>'POST','url'=>'brand','class'=>'form-horizontal')) !!}
						<div class="form-group">
							{!! Form::label("brand_name", "Brand Name:") !!}
							{!! Form::text("name", Input::old('name',false), array('class'=>' col-sm-6 form-control')) !!}
						</div><!-- form-group end -->
					
						<div class="form-group">
							{!! Form::label("brand_description", "Brand Description:") !!}
							{!! Form::text("description", Input::old('description',false), array('class'=>'form-control')) !!}
						</div><!-- form-group end -->
						
						<div class="form-group">
							{!! Form::submit("Save", array('class'=>'btn btn-primary')) !!}
						</div><!-- form-group end -->
					{!! Form::close() !!}
				</div>
			</div><!-- row end -->
		</div><!-- container end -->
	</section><!-- section end -->


@stop