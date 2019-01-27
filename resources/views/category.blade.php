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
                    {{-- sort by section start :: wahid --}}
                    <div class="col-xs-4 pull-right margin-top box-green">
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
                    </div>
                    {{-- sort by section end :: wahid --}}

                    <h1>{{$catDetails->description}}</h1>
                    <h2>{{$subCatDesc}}</h2>

                    <div class="clearfix"></div>
                    <div class="row cat-items">

                        @foreach($catDetails->products as $product)
                            <div class="p-box col-md-3 col-sm-4">
                                <div class="cat-img">
								<a href="{{route('productconsumer', $product->id)}}">
                                    <img class="img-responsive"
                                         src="/images/product/{{$product->id}}/{{$product->photo_1}}">
								</a>
								</div>
                                <h5 class="pull-left" style="width:200px">
                                    {{$product->name}}</h5>
                                @if (($product->retail_price == $product->original_price) || ($product->retail_price == 0))
									@if ($product->original_price > 0)
                                    <strong class="pull-right margin-top">
                                        {{$currentCurrency}} {{$product->original_price/100}}</strong>
									@endif
                                @else
                                    <strike style="color:red" class="pull-right margin-top">
                                        <strong style="color:black" class="margin-top">
                                            {{$currentCurrency}} {{$product->original_price/100}}</strong>
                                    </strike>
                                    <strong style="color:red;font-size:130%;
								position:absolute;margin-top:25px;right:15px"
                                            class="pull-right;">
                                        {{$currentCurrency}} {{$product->retail_price/100}}</strong>
                                    <strong style="color:red;font-size:130%;
								position:absolute;margin-top:45px;right:15px"
                                            class="pull-right;">
                                        -{{number_format((($product->original_price - $product->retail_price)/$product->original_price)*100)}}%</strong>

                                @endif
                                <div class="clearfix"> </div>
                                <ul class="pull-left list-inline">
                                    <li class="btn-green"><i class="fa fa-plus"></i></li>
                                    <li class="btn-pink">
                                        <a href="javascript:void(0)" rel="nofollow" class="add-to-wishlist" style="color:white;" data-item-id="{{ $product->id }}">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </li>
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


