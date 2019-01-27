@extends("common.default")
@section("content")
	<section class="categorylist">
		<div class="container"><!--Begin main cotainer-->
			<div class="row">
				<div data-spy="scroll" style="display: none;" class="static-tab">
					<div class="text-center tab-arrow">
						<span class="fa fa-sort"></span>
					</div>
					<div class="floor-directory">
						<ul class="nav nav-pills nav-stacked">
							@foreach($allCategories as $cat)
								<li class="floor-navigation" role="presentation"><a href="#{{$cat['name']}}">
                                <span class="btn-elevator">
                                    <img src="{{asset("images/category/logo-green/".$cat['logo_green'])}}" alt="">
                                </span>
								<span class="back">{{$cat['description']}}</span>
								<br>
								</a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="catlist col-sm-11 col-sm-offset-1">
					<img src="{{asset('images/Buyerregistration.png')}}" title="banner" class="img-responsive banner nomobile">

					{{-- sort by section start --}}
					<div class="row nomobile">
			            <div class="col-xs-4 pull-right margin-top box-green">
			                <div class="col-xs-6">
			                    &nbsp;
			                </div>
			                <div class="col-xs-6">
			                    &nbsp;
			                </div>
			            </div>
		            </div>
		            {{-- sort by section end --}}

					<hr>
					<h1>Floors</h1>
					@foreach($allCategories as $cat)
						<div id="{{$cat['name']}}">
							<a href="{{URL::to('floor',array($cat['floor']))}}" style="color: black;">
							<h3 style="cursor: pointer; margin-bottom:0">
							<img src="{{asset("images/category/logo-green/".$cat['logo_green'])}}"
								width="50" height="50">&nbsp;&nbsp;{{$cat['description']}}</h3></a>
						</div>
						<br>
					@endforeach

				</div>
			</div>
		</div>
	</section>
@stop
