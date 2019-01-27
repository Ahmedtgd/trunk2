@extends("common.default")

@section("content")
    <section class="categorylist">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                        <ul class="nav nav-pills nav-stacked">
                            <li class="floor-navigation" role="presentation"><a href="#ab">A-B</a></li>
                            <li class="floor-navigation" role="presentation"><a href="#ab">C-D</a></li>

                        </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                    <div class="col-sm-12 text-right box-green">
                        <label class="margin-top">Sort By: &nbsp;</label>
                        <select class="selectpicker pull-right"  data-style="btn-green" data-live-search="true">
                            <option > Price Low to High</option>
                            <option > Price High to Low</option>
                            <option > Relevance</option>
                            <option > Discount</option>
                        </select>
                    </div>

                    <h1>{{$brandDetails->name}}</h1>


                    <div class="clearfix"></div>
                    <div class="row cat-items">
                        @foreach($brandDetails->products as $product)
                        <div class="p-box col-md-3 col-sm-4">
                            <div class="cat-img">
								<a href="{{ route('productconsumer', $product->id) }}">
									<img class="img-responsive"
									src="/images/product/{{$product->id}}/{{$product->photo_1}}"/>
								</a>
                            </div>
                            <h5 class="pull-left">{{$product->description}}</h5>
                            <strong class="pull-right margin-top">{{$product->price}}</strong>
                            <div class="clearfix"> </div>
                            <ul class="pull-left list-inline">
                                <li class="btn-green"><i class="fa fa-plus"></i></li>
                                <li class="btn-pink"><i class="fa fa-heart"></i></li>
                            </ul>

                            <div class="clearfix"> </div>
                        </div>
                       
                        @endforeach


                        <div class="clearfix"></div>

                    </div>


                </div>
            </div>
        </div><!--End main cotainer-->
    </section>
@stop


