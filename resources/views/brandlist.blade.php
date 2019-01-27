@extends("common.default")

@section("content")
<style>
.brandlist ul {
	list-style:none;
}

.brandlist ul li a{
	color:#000;
}
.brandlist .custom-border {
    margin-top: 20px !important;
    margin-bottom: 20px !important;

    border-top: 1px solid #eeeeee !important;
	clear:both;
}
</style>
<section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">

			<div data-spy="scroll" class="static-tab" style="display: none;">
                        <div class="text-center tab-arrow">
                            <span class="fa fa-sort"></span>
                        </div>
                        <ul class="nav nav-pills nav-stacked">

                            <li role="presentation" class="active"><a href="#AD">A-D</a></li>
							<li role="presentation"><a href="#EH">E-H</a></li>
							<li role="presentation"><a href="#IL">I-L</a></li>
							<li role="presentation"><a href="#MP">M-P</a></li>
							<li role="presentation"><a href="#QT">Q-T</a></li>
							<li role="presentation"><a href="#UX">U-X</a></li>
							<li role="presentation"><a href="#YZ">Y-Z</a></li>
                        </ul>
                </div>

			{{-- sort by section start --}}
<!--             <div class="col-xs-4 pull-right margin-top box-green">
                <div class="col-xs-6">
                    <div class="row text-right" style="margin-top:5px">
                        <label> Sort By: &nbsp;</label>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <select class="selectpicker"  data-style="btn-green" data-live-search="true">
                            <option > Price Low to High</option>
                            <option > Price High to Low</option>
                            <option > Relevance</option>
                            <option > Discount</option>
                        </select>
                    </div>
                </div>
            </div> -->
            {{-- sort by section end --}}
            <div class="col-sm-11 col-sm-offset-1">
			{!! Breadcrumbs::render('brand') !!}
            <div id="all-floors">
				<div class="brandlist">
					<h1>Brands</h1>
					@if(count($allABrands) > 0)
						<div id="AD" class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">A</h3>
							<ul style="font-size:130%">
								@foreach($allABrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allBBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">B</h3>
							<ul style="font-size:130%">
								@foreach($allBBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allCBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">C</h3>
							<ul style="font-size:130%">
								@foreach($allCBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allDBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">D</h3>
							<ul style="font-size:130%">
								@foreach($allDBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allEBrands) > 0)
						<div class="custom-border"></div>
						<div id="EH" class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">E</h3>
							<ul style="font-size:130%">
								@foreach($allEBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allFBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">F</h3>
							<ul style="font-size:130%">
								@foreach($allFBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allGBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">G</h3>
							<ul style="font-size:130%">
								@foreach($allGBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allHBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">H</h3>
							<ul style="font-size:130%">
								@foreach($allHBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allIBrands) > 0)
						<div class="custom-border"></div>
							<div id="IL" class="col-md-12">
								<h3 style="text-align:left;margin-bottom:0">I</h3>
								<ul style="font-size:130%">
									@foreach($allIBrands as $brand)
										<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
									@endforeach()
								</ul>
							</div>
					@endif
					@if(count($allJBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">J</h3>
							<ul style="font-size:130%">
								@foreach($allJBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allKBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">K</h3>
							<ul style="font-size:130%">
								@foreach($allKBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allLBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">L</h3>
							<ul style="font-size:130%">
								@foreach($allLBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allMBrands) > 0)
						<div class="custom-border"></div>
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">M</h3>
							<ul style="font-size:130%">
								@foreach($allMBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allNBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">N</h3>
							<ul style="font-size:130%">
								@foreach($allNBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allOBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">O</h3>
							<ul style="font-size:130%">
								@foreach($allOBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allPBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">P</h3>
							<ul style="font-size:130%">
								@foreach($allPBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allQBrands) > 0)
						<div class="custom-border"></div>
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">Q</h3>
							<ul style="font-size:130%">
								@foreach($allQBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allRBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">R</h3>
							<ul style="font-size:130%">
								@foreach($allRBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allSBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">S</h3>
							<ul style="font-size:130%">
								@foreach($allSBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allTBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">T</h3>
							<ul style="font-size:130%">
								@foreach($allTBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allUBrands) > 0)
						<div class="custom-border"></div>
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">U</h3>
							<ul style="font-size:130%">
								@foreach($allUBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allVBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">V</h3>
							<ul style="font-size:130%">
								@foreach($allVBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allWBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">W</h3>
							<ul style="font-size:130%">
								@foreach($allWBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allXBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">X</h3>
							<ul style="font-size:130%">
								@foreach($allXBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allYBrands) > 0)
						<div class="custom-border"></div>
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">Y</h3>
							<ul style="font-size:130%">
								@foreach($allYBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					@if(count($allZBrands) > 0)
						<div class="col-md-12">
							<h3 style="text-align:left;margin-bottom:0">Z</h3>
							<ul style="font-size:130%">
								@foreach($allZBrands as $brand)
									<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
								@endforeach()
							</ul>
						</div>
					@endif
					<div class="custom-border"></div>
				</div>
			</div>
			</div>
        </div>
    </div>
</section>
@stop
