@extends("common.default")

@section("content")
    <!--O-Shop-->
    @if($type == "oshop")
        <section class="categorylist">

        @if( isset($profile->signboard->id))
            <img width="100%" class="width-100 img-responsive" src="{{ asset('images/signboard/'.$profile->signboard->id .'/' .$profile->signboard->image) }}" alt="{{ $merchant->oshop_name }} Signboard" />
        @endif

        <div class="container">
            <div class="row" style=" margin-top: 10px; margin-bottom: 10px;">
                <div  class="navbar-collapse collapse ">
                    {{-- <ul  class="nav navbar-nav custom-navbar">
                        <li class="pull-left" ><a style="color:white; font-size:25px;" href="/" class="active">About</a></li>
                        <li><a style="color:white; font-size:25px;">Certificate</a></li>
                        <li><a style="color:white; font-size:25px;">Supplier</a>&nbsp; &nbsp; &nbsp;</li>
                    </ul> --}}
                    <ul class="nav navbar-nav">
                        <li><a style="color: #000; font-size:25px;" href="{{route('oshopaboutus',[$merchant->id])}}">About</a></li>
                        <li><a style="color: #000; font-size:25px;" href="{{route('oshopcertificate',[$merchant->id])}}">Certificate</a></li>
                        <li><a style="color: #000; font-size:25px;" href="#">Dealer</a></li> 
                        <li><a style="color: #000; font-size:25px;" href="{{route('owarehouse',[$merchant->id])}}">Hyper</a></li>
                        <li><a style="color: #000; font-size:25px;" href="{{route('oshopoem',[$merchant->id])}}">OEM</a></li>
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <li ><button style="background:rgb(0,99,98);border:none; padding: 10px; margin-top:5px" class="">
                            <a style="color:white; text-decoration:none;" href=""><strong><i class="fa fa-link fa-lg"></i></strong>
                            &nbsp;&nbsp;&nbsp;Auto Link&nbsp;&nbsp;&nbsp;&nbsp;</a></button></li>
                        <li><a style="color:#000; font-size: 23px;" herf="">OFFICIAL SHOP</a></li>
                        <li style="color:white; margin-top:15px"><img style="width:30px; height:20px" src="{{ asset('images/malaysia.png') }}">&nbsp;</li>
                        <li  style="background:rgb(224,40,120); color:white; margin-top:15px">&nbsp;&nbsp; &nbsp;Like &nbsp; &nbsp;&nbsp; &nbsp;</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div style="color:white; margin-right:0px; margin-top:20px;" class="pull-right">
                        3 results &nbsp; &nbsp; Sort By:&nbsp; &nbsp;
                        <select style="width:150px;color:black">
                            <option>Price:low to high</option>
                            <option>Price: High to low</option>
                        </select><span class="caret"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                {{--<ul class="navGreenBar">--}}
                {{--<li><a href=""><i class="fa fa-sort"></i></a></li>--}}
                {{--<li class=""><a href="">Lubricant Oil</a></li>--}}
                {{--<li class=""><a href="">Belts</a></li>--}}
                {{--<li class=""><a href="">Lights</a></li>--}}
                {{--<li class=""><a href="">Exhaust Pipe</a></li>--}}
                {{--<li class=""><a href="">Inner Spare Parts</a></li>--}}
                {{--</ul>--}}
                <div data-spy="scroll" class="static-tab" style="display: none;">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        @foreach($merchant_cat as $category)
                            @foreach($merchant->categories as $cat)
                                @if($category == $cat->id)
                                    <li class=""><a href="">{{ $cat->description }}</a></li>
                                    <!--  <?php break; ?> -->
                                @endif
                            @endforeach
                        @endforeach
                    </ul>

                </div>
                <div class="col-md-2">
                    @if( isset( $profile->bunting->id ) )
                        <img width="100%" class="img-responsive" src="{{ asset('images/bunting/'.$profile->bunting->id . '/' .$profile->bunting->image) }}" alt="{{ $merchant->oshop_name }} Bunting" />
                    @endif
                </div>

                <div class="col-sm-10">

                    <div class="row cat-items">

                        @foreach($merchant_cat as $category)
                            @foreach($merchant->categories as $cat)
                                @if($category == $cat->id)
                                    <div class="col-md-12 floor-board nopadding">
                                        <div class="col-xs-12 col-md-4">
                                            <h3>{{ $cat->description }}</h3>
                                        </div>
                                    </div>
                                    <?php break; ?>
                                @endif
                            @endforeach
                            @foreach($merchant_pro->products as $product)
                                @if($category == $product->category_id)
                                        <div class="p-box col-md-3 col-sm-4" style="padding-right: 2px;">
                                    <div class="cat-img">
                                        <a href="{{ route('productconsumer', $product['id']) }}">
                                           <img class="img-responsive" alt="Missing" src="{{ asset('images/product/'.$product['id']. '/'.$product['photo_1']) }}">
                                        </a>
                                    </div>
                                    <h5 class="pull-left">{{$product['name']}}</h5>
                                    @if ($product['retail_price'] == 0)
                                        @if ($product['original_price'] != 0)
                                            <strong class="pull-right margin-top">
                                                RM{{$product['original_price']/100}}</strong>
                                        @endif
                                    @else
                                        <strike style="color:red" class="pull-right margin-top">
                                            <strong style="color:black" class="margin-top">
                                                RM{{$product['original_price']/100}}</strong>
                                        </strike>
                                        <strong style="color:red;font-size:130%;
                                            position:absolute;margin-top:25px;right:15px"
                                                class="pull-right;">
                                            RM{{$product['retail_price']/100}}</strong>
                                        <strong style="color:red;font-size:130%;
                                            position:absolute;margin-top:45px;right:15px"
                                                class="pull-right;">
                                            -{{number_format((($product['original_price'] - $product['retail_price'])/$product['original_price'])*100)}}%</strong>

                                    @endif
                                    <div class="clearfix"> </div>
                                    <ul class="pull-left list-inline">
                                        <li class="btn-green"><i class="fa fa-plus"></i></li>
                                        <li class="btn-pink">
                                            <a href="javascript:void(0)" rel="nofollow" class="add-to-wishlist" style="color:white;" data-item-id="{{ $product['id'] }}">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="clearfix"> </div>
                                </div>
                                @endif
                            @endforeach
                        @endforeach
                        @if( isset( $profile->vbanner->id ) )
                            <img style=" width:100%;height:450px;"
                                 src="{{ asset('images/vbanner/'.$profile->vbanner->id . '/'. $profile->vbanner->image) }}">
                        @endif
                        <br/>
                        <br/>
                    </div>

                </div>

            </div>



        </div><!-- End Container -->

    </section>
    @elseif($type == "brand")
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
                        <img src="/images/Buyerregistration.png" title="advertisement" class="img-responsive banner">


                        <h1>{{$brandDetails->name}}</h1>

                        <div class="clearfix"></div>
                        <div class="row cat-items">
                            @foreach($brandDetails->products as $product)
                                <div class="p-box col-md-3 col-sm-4">
                                    <div class="cat-img">
                                        <a href="{{ route('productconsumer', $product->id) }}">
                                            <img class="img-responsive" src="/images/product/{{$product->id}}/{{$product->photo_1}}"/>
                                        </a>
                                    </div>
                                    <h5 class="pull-left">
                                        {{$product->name}}</h5>
                                    @if (($product->retail_price == $product->original_price) || ($product->retail_price == 0))
                                        @if ($product->original_price > 0)
                                            <strong class="pull-right margin-top">
                                                RM{{$product->original_price/100}}</strong>
                                        @endif
                                    @else
                                        <strike style="color:red" class="pull-right margin-top">
                                            <strong style="color:black" class="margin-top">
                                                RM{{$product->original_price/100}}</strong>
                                        </strike>
                                        <strong style="color:red;font-size:130%;
                                position:absolute;margin-top:25px;right:15px"
                                                class="pull-right;">
                                            RM{{$product->retail_price/100}}</strong>
                                        <strong style="color:red;font-size:130%;
                                position:absolute;margin-top:45px;right:15px"
                                                class="pull-right;">
                                            -{{number_format((($product->original_price - $product->retail_price)/$product->original_price)*100)}}%</strong>
                                    @endif
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
    @else
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
                                <option>Price Low to High</option>
                                <option>Price High to Low</option>
                                <option>Relevance</option>
                                <option>Discount</option>
                            </select>
                        </div>
                        <img src="/images/Buyerregistration.png" title="banner" class="img-responsive banner">

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
                                    <h5 class="pull-left">
                                        {{$product->name}}</h5>
                                    @if (($product->retail_price == $product->original_price) || ($product->retail_price == 0))
                                        @if ($product->original_price > 0)
                                            <strong class="pull-right margin-top">
                                                RM{{$product->original_price/100}}</strong>
                                        @endif
                                    @else
                                        <strike style="color:red" class="pull-right margin-top">
                                            <strong style="color:black" class="margin-top">
                                                RM{{$product->original_price/100}}</strong>
                                        </strike>
                                        <strong style="color:red;font-size:130%;
                                position:absolute;margin-top:25px;right:15px"
                                                class="pull-right;">
                                            RM{{$product->retail_price/100}}</strong>
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
    @endif
    <!--O-Shop-->
@stop
