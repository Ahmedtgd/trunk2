@extends("common.default")

@section("content")

    <style>
        .marginTop50 {
            margin-top: 50px;
        }
    </style>

    <section class="profilesetting">
        <div class="container"><!--Begin main container-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked" id="elevator-btn">
                        <li role="presentation" class="active floor-navigation"><a href="#themes">Themes</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#services">Services</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#video">Video</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">

                    <input type="hidden" value="{{ $smm_quota_max }}" name="smm_quota_max">
                    <form class="form-horizontal">
                        <div class="row">
                            <div id="services" class="margin-top">
                                <h1>O-Shop Appearance</h1>
                                <div class="col-xs-12 margin-top signboard_background"
                                     style="background-image: url({{(!is_null($signboardupdate))? asset('images/signboard/'.$signboardupdate->id.'/'.$signboardupdate->image) : '' }});">
                                    <div class="signboard">
                                        <p class="signboard-text">SignBoard</p>
                                        <a class="text-green badge badge-upload"
                                           badge_name="sign-board"
                                           href="{!! url('/profile/badge-update/sign-board') !!}">
                                            <i class="fa fa-plus-circle"
                                               style="font-size:25px"></i>
                                        </a>
                                        <div class="collapse" id="signboard">
                                            <ul id="signboardUl">
                                                @foreach($signboards as $signboard)
                                                    <li class="custom-thems"
                                                        data-theme="{!! $signboard['id'] !!},signboard_id"><img
                                                                src="images/signboard/{!! $signboard['id'] !!}/{!! $signboard['image'] !!}"
                                                                alt="item" class="sbimgID"></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="margin-top">@include('profilesettingnavigation')</div>

                                <div class="col-xs-12 margin-top" style="padding-left:0">
                                </div>
                            </div>
                            <div class="margin-top">
                                <div class="col-sm-3">
                                    <a class="btn btn-green btn-lg hidden" id="addBunting">Add Bunting</a>
                                </div>
                                <div class="col-sm-9 text-right margin-top box-green">
                                    <label>3 results &nbsp;&nbsp;&nbsp; &nbsp;</label>
                                    <label>Sort By: &nbsp;</label>
                                    <select class="selectpicker pull-right" data-style="btn-green"
                                            data-live-search="true">
                                        <option> Price Low to High</option>
                                        <option> Price High to Low</option>
                                        <option> Relevance</option>
                                        <option> Discount</option>
                                    </select>
                                </div>
                            </div>

                            <div class="margin-top">
                                <div class="col-sm-2" style="padding-left:0">

                                    <div id="display-buntings" class="bunting signboard_background"
                                         style="background-image: url({{(!is_null($bunty))? asset('images/bunting/'.$bunty->id.'/'.$bunty->image) : '' }}) ">
                                        <p style="padding-top:55%; text-align: center;"
                                           id="bunting_text">Bunting</p>
                                        <a class="text-green badge badge-upload"
                                           badge_name="bunting" href="{!! url('/profile/badge-update/bunting') !!}">
                                            <i class="fa fa-plus-circle"
                                               style="font-size:25px"></i>
                                        </a>
                                        <div class="collapse" id="buntingImg">
                                            <ul id="bountingId">
                                                @foreach($buntings as $bunting)
                                                    <li class="custom-thems"
                                                        data-theme="{!! $bunting['id'] !!},bunting_id">
                                                        <img src="images/bunting/{!! $bunting['id'] !!}/{!! $bunting['image'] !!}"
                                                             alt="item" class="bimgID">
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-10 p-product">
                                    <div id="display-product-section">
                                        {{--@if(!is_null($sections))--}}
                                        {{--@foreach($sections as $section)--}}
                                        {{--@foreach($section->products as $section_product)--}}
                                        {{--<div class="p-box  col-sm-3 col-xs-12"--}}
                                        {{--id="product-item-profile-setting-{{$section_product['id']}}"--}}
                                        {{--style="padding-left:0">--}}
                                        {{--<div class="p-img">--}}
                                        {{--<a class="badge badge-close removeproductbox "--}}
                                        {{--data-pro-id="{{$section_product['id']}}"--}}
                                        {{--data-subid="{{$section_product['subcat_id']}}">X</a>--}}
                                        {{--<a href="{{ route('productconsumer', $section_product['id']) }}">--}}
                                        {{--<img class="img-responsive"--}}
                                        {{--src="{{ asset('images/product/'.$section_product['id'].'/'.$section_product['photo_1']) }}">--}}
                                        {{--</a>--}}
                                        {{--</div>--}}
                                        {{--<table style="padding:0" class="table table-bordered">--}}
                                        {{--<tbody>--}}
                                        {{--<tr>--}}
                                        {{--<td colspan="2" rowspan="2"--}}
                                        {{--style="padding:4px;vertical-align:middle">--}}
                                        {{--{{$section_product['name']}}</td>--}}
                                        {{--@if ($section_product['retail_price'] == 0)--}}
                                        {{--@if ($section_product['original_price'] != 0)--}}
                                        {{--<td style="padding:0;text-align:center;font-weight:bold">--}}
                                        {{--RM{{number_format($section_product['original_price']/100,2)}}</td>--}}
                                        {{--@endif--}}
                                        {{--@else--}}
                                        {{--<td style="padding:0;text-align:center;font-weight:bold">--}}
                                        {{--RM{{number_format($section_product['original_price']/100,2)}}</td>--}}
                                        {{--@endif--}}
                                        {{--</tr>--}}
                                        {{--<tr>--}}
                                        {{--@if ($section_product['retail_price'] == 0)--}}
                                        {{--<td class="text-danger">&nbsp;</td>--}}
                                        {{--@else--}}
                                        {{--<td class="text-danger"--}}
                                        {{--style="padding:0;text-align:center;font-size:120%;font-weight:bold">--}}
                                        {{--RM{{number_format($section_product['retail_price']/100,2)}}</td>--}}
                                        {{--@endif--}}
                                        {{--</tr>--}}
                                        {{--</tbody>--}}
                                        {{--</table>--}}
                                        {{--<div class="clearfix"></div>--}}
                                        {{--<div class=" col-xs-8"--}}
                                        {{--style="padding-left:0;padding-right:0;width:40%;top:-20px">--}}
                                        {{--<ul class="list-inline" style="padding:0;width:100px">--}}
                                        {{--<li class="btn-green">--}}
                                        {{--{!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}--}}
                                        {{--{!! Form::hidden('quantity', 1) !!}--}}
                                        {{--{!! Form::hidden('id', $section_product['id']) !!}--}}
                                        {{--{!! Form::hidden('price', $section_product['retail_price']) !!}--}}
                                        {{--<button class='cartBtn btn-link' type='submit'--}}
                                        {{--style='padding: 0px;font-size: 15px;color: rgb(255, 255, 255);'>--}}
                                        {{--<i class="fa fa-plus"></i>--}}
                                        {{--</button>--}}
                                        {{--{!! Form::close() !!}--}}
                                        {{--</li>--}}
                                        {{--<li class="btn-pink"><i class="fa fa-heart"></i></li>--}}
                                        {{--<li class="btn-darkgreen"><i--}}
                                        {{--class="fa fa-shopping-cart"></i></li>--}}
                                        {{--</ul>--}}
                                        {{--</div>--}}
                                        {{--<div class=" col-xs-4 text-right text-danger"--}}
                                        {{--style="padding-right:0;padding-left:0;width:50%;float:right;top:-20px">--}}
                                        {{--@if ($section_product['retail_price'] == 0)--}}
                                        {{--<strong id="discountval" class="text-muted"></strong>--}}
                                        {{--@else--}}
                                        {{--<strong class=""--}}
                                        {{--style="font-weight:bold;font-size:150%;width:100%">Save--}}
                                        {{--{{number_format((($section_product['original_price'] ---}}
                                        {{--$section_product['retail_price'])/$section_product['original_price'])*100,0)}}--}}
                                        {{--%</strong>--}}
                                        {{--@endif--}}
                                        {{--</div>--}}
                                        {{--<div class="clearfix"></div>--}}
                                        {{--</div>--}}
                                        {{--@endforeach--}}
                                        {{--@endforeach--}}
                                        {{--@else--}}
                                        {{--{{'No Section Product Availble'}}--}}
                                        {{--@endif--}}
                                        {{--@foreach($profile_products as $product)--}}
                                        {{--<div class="p-box  col-sm-3 col-xs-12 hide"--}}
                                        {{--id="product-item-profile-setting-{{$product['id']}}"--}}
                                        {{--style="padding-left:0">--}}
                                        {{--<div class="p-img">--}}
                                        {{--<a class="badge badge-close removeproductbox "--}}
                                        {{--data-pro-id="{{$product['id']}}"--}}
                                        {{--data-subid="{{$product['subcat_id']}}">X</a>--}}
                                        {{--<a href="{{ route('productconsumer', $product['id']) }}">--}}
                                        {{--<img class="img-responsive"--}}
                                        {{--src="{{ asset('images/product/'.$product['id'].'/'.$product['photo_1']) }}">--}}
                                        {{--</a>--}}
                                        {{--</div>--}}
                                        {{--<table style="padding:0" class="table table-bordered">--}}
                                        {{--<tbody>--}}
                                        {{--<tr>--}}
                                        {{--<td colspan="2" rowspan="2"--}}
                                        {{--style="padding:4px;vertical-align:middle">--}}
                                        {{--{{$product['name']}}</td>--}}
                                        {{--@if ($product['retail_price'] == 0)--}}
                                        {{--@if ($product['original_price'] != 0)--}}
                                        {{--<td style="padding:0;text-align:center;font-weight:bold">--}}
                                        {{--RM{{number_format($product['original_price']/100,2)}}</td>--}}
                                        {{--@endif--}}
                                        {{--@else--}}
                                        {{--<td style="padding:0;text-align:center;font-weight:bold">--}}
                                        {{--RM{{number_format($product['original_price']/100,2)}}</td>--}}
                                        {{--@endif--}}
                                        {{--</tr>--}}
                                        {{--<tr>--}}
                                        {{--@if ($product['retail_price'] == 0)--}}
                                        {{--<td class="text-danger">&nbsp;</td>--}}
                                        {{--@else--}}
                                        {{--<td class="text-danger"--}}
                                        {{--style="padding:0;text-align:center;font-size:120%;font-weight:bold">--}}
                                        {{--RM{{number_format($product['retail_price']/100,2)}}</td>--}}
                                        {{--@endif--}}
                                        {{--</tr>--}}
                                        {{--</tbody>--}}
                                        {{--</table>--}}
                                        {{--<div class="clearfix"></div>--}}
                                        {{--<div class=" col-xs-8"--}}
                                        {{--style="padding-left:0;padding-right:0;width:40%;top:-20px">--}}
                                        {{--<ul class="list-inline" style="padding:0;width:100px">--}}
                                        {{--<li class="btn-green">--}}
                                        {{--{!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}--}}

                                        {{--{!! Form::hidden('quantity', 1) !!}--}}
                                        {{--{!! Form::hidden('id', $product->id) !!}--}}
                                        {{--{!! Form::hidden('price', $product->retail_price) !!}--}}
                                        {{--<button class='cartBtn btn-link' type='submit'--}}
                                        {{--style='padding: 0px;font-size: 15px;color: rgb(255, 255, 255);'>--}}
                                        {{--<i class="fa fa-plus"></i></button>--}}
                                        {{--{!! Form::close() !!}--}}
                                        {{--</li>--}}
                                        {{--<li class="btn-pink"><i class="fa fa-heart"></i></li>--}}
                                        {{--<li class="btn-darkgreen"><i class="fa fa-shopping-cart"></i>--}}
                                        {{--</li>--}}
                                        {{--</ul>--}}
                                        {{--</div>--}}
                                        {{--<div class=" col-xs-4 text-right text-danger"--}}
                                        {{--style="padding-right:0;padding-left:0;width:50%;float:right;top:-20px">--}}
                                        {{--@if ($product['retail_price'] == 0)--}}
                                        {{--<strong id="discountval" class="text-muted"></strong>--}}
                                        {{--@else--}}
                                        {{--<strong class=""--}}
                                        {{--style="font-weight:bold;font-size:150%;width:100%">Save--}}
                                        {{--{{number_format((($product['original_price'] ---}}
                                        {{--$product['retail_price'])/$product['original_price'])*100,0)}}--}}
                                        {{--%</strong>--}}
                                        {{--@endif--}}
                                        {{--</div>--}}
                                        {{--<div class="clearfix"></div>--}}
                                        {{--</div>--}}
                                        {{--@endforeach--}}

                                        @if(!is_null($sections))

                                            @foreach($sections as $section)
                                                <div id="psection{{$section['id']}}" class="marginTop50">
                                                    <div class="col-sm-12 section-name " style="padding-left:0">
                                                        <input type="text"
                                                               class="btn btn-default btn-lg col-md-3 db_section_names_save"
                                                               value="{{$section['name']}}"
                                                               db_section_id="{!! $section['id'] !!}"
                                                               id="section_name_text_{{$section['id']}}"
                                                               placeholder="Section Name"/>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div id="display-product{{$section['id']}}">
                                                        @if(!is_null($section->products) && isset($section->products))
                                                            @foreach($section->products as $product)
                                                                {{--{{dd($section->prodcuts)}}--}}
                                                                {{--{{($product = $product->product)? '': ''}}--}}
                                                                <div data-product-id="{{ $product['id'] }}"
                                                                     class="on-hover-product p-box  col-sm-3 col-xs-12"
                                                                     id="product-item-profile-setting-{{$product['id']}}"
                                                                     style="padding-left:0">
                                                                    <div class="p-img">
                                                                        <a class="badge badge-close removeproductfromSection "
                                                                           data-pro-id="{{$product['id']}}"
                                                                           data-section-id="{{$section['id']}}"
                                                                           data-subid="{{$product['subcat_id']}}">X</a>
                                                                        <a href="{{ route('productconsumer', $product['id']) }}">
                                                                            <img class="img-responsive"
                                                                                 src="{{ asset('images/product/'.$product['id'].'/'.$product['photo_1']) }}">
                                                                        </a>
                                                                    </div>
                                                                    <table style="padding:0"
                                                                           class="table table-bordered">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td colspan="2" rowspan="2"
                                                                                style="padding:4px;vertical-align:middle">
                                                                                {{$product['name']}}</td>
                                                                            @if ($product['retail_price'] == 0)
                                                                                @if ($product['original_price'] != 0)
                                                                                    <td style="padding:0;text-align:center;font-weight:bold">
                                                                                        RM{{number_format($product['original_price']/100,2)}}</td>
                                                                                @endif
                                                                            @else
                                                                                <td style="padding:0;text-align:center;font-weight:bold">
                                                                                    RM{{number_format($product['original_price']/100,2)}}</td>
                                                                            @endif
                                                                        </tr>
                                                                        <tr>
                                                                            @if ($product['retail_price'] == 0)
                                                                                <td class="text-danger">&nbsp;</td>
                                                                            @else
                                                                                <td class="text-danger"
                                                                                    style="padding:0;text-align:center;font-size:120%;font-weight:bold">
                                                                                    RM{{number_format($product['retail_price']/100,2)}}</td>
                                                                            @endif
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="clearfix"></div>
                                                                    <div class=" col-xs-8"
                                                                         style="padding-left:0;padding-right:0;width:40%;top:-20px">
                                                                        <ul class="list-inline"
                                                                            style="padding:0;width:100px">
                                                                            <li class="btn-green">
                                                                                {!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}

                                                                                {!! Form::hidden('quantity', 1) !!}
                                                                                {!! Form::hidden('id', $product['id']) !!}
                                                                                {!! Form::hidden('price', $product['retail_price']) !!}
                                                                                <button class='cartBtn btn-link'
                                                                                        type='submit'
                                                                                        style='padding: 0px;font-size: 15px;color: rgb(255, 255, 255);'>
                                                                                    <i class="fa fa-plus"></i></button>
                                                                                {!! Form::close() !!}
                                                                            </li>
                                                                            <li class="btn-pink"><i
                                                                                        class="fa fa-heart"></i>
                                                                            </li>
                                                                            <li class="btn-darkgreen"><i
                                                                                        class="fa fa-shopping-cart"></i>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class=" col-xs-4 text-right text-danger"
                                                                         style="padding-right:0;padding-left:0;width:50%;float:right;top:-20px">
                                                                        @if ($product['retail_price'] == 0)
                                                                            <strong id="discountval"
                                                                                    class="text-muted"></strong>
                                                                        @else
                                                                            <strong class=""
                                                                                    style="font-weight:bold;font-size:150%;width:100%">Save
                                                                                {{number_format((($product['original_price'] -
                                                                                $product['retail_price'])/$product['original_price'])*100,0)}}
                                                                                %</strong>
                                                                        @endif
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-sm-12" style="border-bottom: 2px dotted">
                                                        <div class="col-sm-11"
                                                             style="text-align:right;padding-right:0;">
                                                            <a class="text-green addProductToSection"
                                                               id="addPbox{{$section->id}}"
                                                               data-pbID="{{$section->id}}"
                                                               data-sID="{{$section->id}}"
                                                               href="javascript:void(0)"  >
                                                                <i class="fa fa-plus-circle"
                                                                   style="font-size:25px;">

                                                                </i>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-1" style="padding-right:0">
                                                            <a data-remid="{{$section->id}}"
                                                               data-secid="{{$section->id}}"
                                                               class="pull-right red remPsec"
                                                               href="javascript:void(0);">

                                                                <i class="fa fa-minus-circle"
                                                                   style='font-size:25px;color:red;margin-right:-15px'></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if(!is_null($sec_id))
                                            @foreach($sec_id as $key=>$val)

                                                <div id="psection{{$sec_id[$key]}}" class="marginTop50">
                                                    <div class="col-sm-12 section-name">

                                                        <input type="text"
                                                               class="btn btn-default btn-lg col-md-3 section_names_save"
                                                               new="{{$sec_id[$key]}}" ;
                                                               data-id="{{$sec_id[$key]}}"
                                                               value="{{$sec_name[$sec_id[$key]] or ''}}"
                                                               id="section_name_text_{{$sec_id[$key]}}"

                                                               placeholder="Section Name">
                                                    </div>
                                                    <div class="clearfix"></div>

                                                    <div id="display-product{{$sec_id[$key]}}">

                                                        @if(!empty($secs_data[$key]))
                                                            @foreach($secs_data[$key] as $product)


                                                                <div data-product-id="{{ $product['id'] }}"
                                                                     class="p-box  col-sm-3 col-xs-12 on-hover-product"

                                                                     id="product-item-profile-setting-{{$product['id']}}"
                                                                     style="padding-left:0">
                                                                    <div class="p-img">
                                                                        <a class="badge badge-close removeproductfromSection "
                                                                           data-pro-id="{{$product['id']}}"
                                                                           data-section-id="{{$sec_id[$key]}}"
                                                                           data-subid="{{$product['subcat_id']}}">X</a>
                                                                        <a href="{{ route('productconsumer', $product['id']) }}">
                                                                            <img class="img-responsive"
                                                                                 src="{{ asset('images/product/'.$product['id'].'/'.$product['photo_1']) }}">
                                                                        </a>
                                                                    </div>
                                                                    <table style="padding:0"
                                                                           class="table table-bordered">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td colspan="2" rowspan="2"
                                                                                style="padding:4px;vertical-align:middle">

                                                                                {{$product['name']}}</td>
                                                                            @if ($product['retail_price'] == 0)
                                                                                @if ($product['original_price'] != 0)
                                                                                    <td style="padding:0;text-align:center;font-weight:bold">
                                                                                        RM{{number_format($product['original_price']/100,2)}}</td>
                                                                                @endif
                                                                            @else
                                                                                <td style="padding:0;text-align:center;font-weight:bold">
                                                                                    RM{{number_format($product['original_price']/100,2)}}</td>
                                                                            @endif
                                                                        </tr>
                                                                        <tr>
                                                                            @if ($product['retail_price'] == 0)
                                                                                <td class="text-danger">&nbsp;</td>
                                                                            @else
                                                                                <td class="text-danger"
                                                                                    style="padding:0;text-align:center;font-size:120%;font-weight:bold">
                                                                                    RM{{number_format($product['retail_price']/100,2)}}</td>
                                                                            @endif

                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="clearfix"></div>
                                                                    <div class=" col-xs-8"
                                                                         style="padding-left:0;padding-right:0;width:40%;top:-20px">
                                                                        <ul class="list-inline"
                                                                            style="padding:0;width:100px">
                                                                            <li class="btn-green">
                                                                                {!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}

                                                                                {!! Form::hidden('quantity', 1) !!}
                                                                                {!! Form::hidden('id', $product->id) !!}
                                                                                {!! Form::hidden('price', $product->retail_price) !!}
                                                                                <button class='cartBtn btn-link'
                                                                                        type='submit'
                                                                                        style='padding: 0px;font-size: 15px;color: rgb(255, 255, 255);'>
                                                                                    <i class="fa fa-plus"></i></button>
                                                                                {!! Form::close() !!}
                                                                            </li>
                                                                            <li class="btn-pink"><i
                                                                                        class="fa fa-heart"></i></li>
                                                                            <li class="btn-darkgreen"><i
                                                                                        class="fa fa-shopping-cart"></i>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class=" col-xs-4 text-right text-danger"
                                                                         style="padding-right:0;padding-left:0;width:50%;float:right;top:-20px">
                                                                        @if ($product['retail_price'] == 0)
                                                                            <strong id="discountval"
                                                                                    class="text-muted"></strong>
                                                                        @else
                                                                            <strong class=""
                                                                                    style="font-weight:bold;font-size:150%;width:100%">Save
                                                                                {{number_format((($product['original_price'] -
                                                                                $product['retail_price'])/$product['original_price'])*100,0)}}
                                                                                %</strong>
                                                                        @endif
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                    <div class="selected-button"></div>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="col-sm-12" style="border-bottom: 2px dotted">
                                                    <div class="col-sm-11"
                                                         style="text-align:right;padding-right:0;">
                                                        <a class="text-green addProductToSection"
                                                           id="addPbox{{$sec_id[$key]}}"
                                                           data-pbid="{{$sec_id[$key]}}"
                                                           data-sid="{{$sec_id[$key]}}"
                                                           href="javascript:void(0);">
                                                            <i class="fa fa-plus-circle" style="font-size:25px"></i></a>
                                                    </div>

                                                    <a data-remid="{{$sec_id[$key]}}"
                                                       class="pull-right text-red remPsec"
                                                       href="javascript:void(0);">
                                                        <i class="fa fa-minus-circle"
                                                           style="font-size:25px;color:red;margin-right:-15px"></i></a>

                                                </div>

                                    </div>

                                    @endforeach
                                    @endif

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-4 col-sm-offset-8 text-right" style="margin-top:20px">
                                <button class="btn btn-green btn-round text-green">SMM max quota: <span
                                            id="mx_quota"></span></button>
                                <div class="btn-group-lg">
                                    <button type="button" id="save-selProduct"
                                            class="btn btn-green btn-round text-green saveSectionName">Confirm
                                    </button>
                                    <a class="btn btn-green btn-round text-green " id="addPsec"
                                       href="javascript:void(0);">Add Section</a>
                                </div>
                            </div>


                            <div id="video" class="col-xs-12 margin-top video-banner" style="left-padding:0 ">

                                <div class="placeholder">
                                    <!--<a class="badge badge-close" id="remVBcontent">X</a>-->
                                    <div id="blocks">
                                        <div class="ejs-image ejs-embed">
                                            <div class="ne-image-wrapper">

                                                <!--<img src="{{(!is_null($videoBannerUpdate))? asset('/images/vbanner/'.$videoBannerUpdate->id.'/'.$videoBannerUpdate->image):''}}">-->

                                            </div>
                                        </div>

                                    </div>

                                    <a class="text-green badge badge-upload"
                                       badge_name="sign-board"
                                       href="{!! url('/profile/badge-update/video-banner') !!}">
                                        <i class="fa fa-plus-circle"
                                           style="font-size:25px"></i>
                                    </a>
                                    <div class="collapse" id="vthumbs">

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
        </div><!--End main container-->


    </section>
@section('scripts')
    <script>

        var rowNum = {{(empty($sec_id))? 0 : last($sec_id)}};
        var pSecCount = {{(empty($sec_id))? 0 : last($sec_id)}};


        /* display product section boxes*/
        $("#addPsec").click(function () {
            console.log(rowNum);
            console.log(pSecCount);
            rowNum++;
            pSecCount++;
            $("#elevator-btn").find(' > li:nth-last-child(1)').before(' <li role="presentation" class="floor-navigation"><a href="#psection' + pSecCount + '" id="count' + pSecCount + '"></a></li>');
            $('#count' + pSecCount).text('Product ' + pSecCount)

            $("#display-product-section").append(
                    '<div class="marginTop50" id="psection' + pSecCount + '"> ' +
                    '<div class="col-sm-12 section-name">' +
                    '<div> <input type="text" class="btn btn-default btn-lg col-md-3 newSection " data-sid="' + pSecCount + '"  id="section_name_text_' + pSecCount + '" placeholder="Section Name">' +
                    '</div>   ' +
                    '</div>     ' +
                    '<div class="clearfix"></div>        ' +
                    '<div id="display-product' + rowNum + '"> </div>        ' +
                    '<div class="clearfix"></div>      ' +
                    '<div class="col-sm-12" style="border-bottom: 2px dotted">' +
                    '<div class="col-sm-11" style="text-align:right;padding-right:0;right:-50px">' +
                    '<a class="text-green addProductToSection" id="addPbox' + rowNum + '" data-pbID="' + rowNum + '" data-sID="' + pSecCount + '" href="javascript:void(0);">' +
                    '<i class="fa fa-plus-circle" style="font-size:25px" ></i>' +
                    '</a> ' +
                    '</div>       ' +
                    '<a data-remID="' + pSecCount + '" class="pull-right text-green remPsec" href="javascript:void(0);">' +
                    '<i class="fa fa-minus-circle" style="font-size:25px;color:red;margin-right:-15px">' +
                    '</i>' +
                    '</a>' +
                    '</div> ' +
                    '</div>'
            );


            $("#addPbox" + rowNum).click(function () {
                var pbid = $(this).attr("data-pbID");
                rowNum++;
                var clas = "";
                if ($(".p-product").hasClass("col-sm-12") == true) {
                    clas = "col-lg-3 col-md-3 col-sm-4";
                } else {
                    clas = "col-lg-4 col-md-6 col-sm-6";
                }
                $("#display-product" + pbid).append(
                        '<div id="pbox' + rowNum + '" class="p-box placeholder ' + clas + 'col-xs-12">' +
                        '<div class="p-img-bordered">' +
                        '<div class="p-img" id="' + rowNum + '" >' +
                        '<a class="badge badge-close remPbox" >X</a>' +
                        '<img id="timgID' + rowNum + '" src="images/placeholder.png" class="img-responsive">' +
                        '<a class="badge badge-upload sectionModel" id="uploadImg' + rowNum + '"  data-toggle="collapse" data-target="#imgThumbs' + rowNum + '" aria-expanded="false" aria-controls="imgThumbs' + rowNum + '" >' +
                        '<i class="fa fa-lg fa-upload"></i>' +
                        '</a>' +
                        '<div class="collapse imgThumbs" data-thumbId="' + rowNum + '" id="imgThumbs' + rowNum + '"> ' +
                        '<ul >' +
                        '<li><img class="simgID" alt="item" src="images/p1.png" class="img-responsive"></li>' +
                        '<li><img class="simgID" alt="item" src="images/p2.png" class="img-responsive"></li>' +
                        '<li><img class="simgID" alt="item" src="images/p3.png" class="img-responsive"></li>' +
                        '<li> <img class="simgID" alt="item" src="images/p4.png" class="img-responsive"></li>' +
                        '<li><img class="simgID" alt="item" src="images/p5.png" class="img-responsive"></li>' +
                        '<li> <img class="simgID" alt="item" src="images/p6.png" class="img-responsive"></li>' +
                        '</ul>' +
                        '</div>' +
                        '</div>' +
                        '<table class="table table-bordered p-specs">' +
                        '<tr>' +
                        '<td rowspan="2"  id="pname_' + rowNum + '">&nbsp;</td>' +
                        '<td id="pval1_' + rowNum + '">&nbsp;</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td class="text-danger" id="pval2_' + rowNum + '">&nbsp;</td>' +
                        '</tr>' +
                        '</table>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '<div class=" col-xs-8">' +
                        '<ul class="list-inline">' +
                        '<li class="btn-green"><i class="fa fa-plus"></i></li>' +
                        '<li class="btn-pink"><i class="fa fa-heart"></i></li>' +
                        '<li class="btn-darkgreen"><i class="fa fa-shopping-cart"></i></li>' +
                        '</ul>' +
                        '</div>' +
                        '<div class=" col-xs-4 text-right">' +
                        '<strong class="text-muted" id="discountval_' + rowNum + '">0%</strong>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                        '</div>'
                );


                $("#discountval_" + rowNum).bind("click", function (element) {
                    newInput(this);
                });
                $("#pname_" + rowNum).bind("click", function (element) {
                    newInput(this);
                });
                $("#pval1_" + rowNum).bind("click", function (element) {
                    newInput(this);
                });
                $("#pval2_" + rowNum).bind("click", function (element) {
                    newInput(this);
                });

                var src = null;

                $(".simgID").bind("click", function (element) {
                    src = $(this).attr('src');
                });//it runs multiple times

                $("#imgThumbs" + rowNum).bind("click", function (element) {

                    var sr = src //$(this).attr('src');
                    var id = $(this).closest(".imgThumbs").attr("data-thumbid");

                    $(this).closest(".p-img").find('#timgID' + id).attr('src', sr);
                    $(this).closest(".p-box").removeClass('placeholder');
                    src = '';
                });
            });


            $("#display-product" + rowNum).on('click', '.remPbox', function () {
                $('#pbox' + rowNum).remove();
                rowNum = rowNum - 1;
                //$(this).parent().parent().remove();
            });

            $('.addProductToSection').on('click', function () {
                //console.log("add Product Button clicked");
                var secId = $(this).attr('data-sid');
                var s_name = $('#section_name_text_' + secId).val();
                var token = $('input[name="_token"]').val();
                $.ajax({
                    url: JS_BASE_URL + '/profile/section-session',
                    data: {'id': secId, 'name': s_name, _token: token},
                    error: function () {

                    },
                    success: function (response) {
                        if (response.status == 'true') {
                            console.log(response.status);
                            window.location.href = JS_BASE_URL + '/album/profilesetting';
                        }
                    },
                    type: 'POST'
                });
            });

            //ends
        });


        var x = new EmbedJS({
            element: document.getElementById('blocks'),
            googleAuthKey: 'AIzaSyCqFouT8h5DKAbxlrTZmjXEmNBjC69f0ts',
            videoDetails: false
        });
        x.render();

        (function () {

            $('.modal_profile_product_modal_product').on('click', function () {
                content = $(this);
                var id = content.attr('new');
                var profile_id = {{ ($profile_setting->first()) ? $profile_setting->first()->id : null }}
                    $.ajax({
                    url: '{{url('/profile/oshop-transfer')}}',
                    data: {'id': id, 'profile_id': profile_id},
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function () {

                    },
                    success: function (response) {
                        $('#product-item-profile-setting-' + id).removeClass('hide');
                        content.addClass('hide');
                    },
                    type: 'POST'
                });
            });

            $('.removeproductbox').on('click', function () {
                content = $(this);
                var id = content.attr('data-pro-id');
                var profile_id = {{($profile_setting->first()) ? $profile_setting->first()->id : null}}
                    $.ajax({
                    url: '{{url('/profile/oshop-transfer-back')}}',
                    data: {'id': id, 'profile_id': profile_id},
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function () {

                    },
                    success: function (response) {
                        $('#modal_profile_product_modal_' + id).removeClass('hide');
                        content.parent().parent().addClass('hide');
                    },
                    type: 'POST'
                });
            });

            $('select[name="subcategory"]').on('change', function () {
                var subCat = $(this).val();
                $('.modal_profile_product_modal_product_cat_' + subCat).trigger('click');
            });

            $('.removeproductfromSection').on('click', function () {
                content = $(this);
                p_id = content.attr('data-pro-id');
                s_id = content.attr('data-section-id');
                $.ajax({
                    url: '{{url('/profile/return')}}',
                    data: {'p_id': p_id, 's_id': s_id},
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function () {

                    },
                    success: function (response) {
                        if (response.status == 'true') {
                            content.parent().parent().addClass('hide');
                        }
                    },
                    type: 'POST'
                });
            });

            $('.saveSectionName').on('click', function () {
                console.log('[Confirm] pressed! saveSectionName');
                btn = $(this);
                var newVals = [];
                var newsecs = [];
                var secId = $(this).attr('data-sid');
                var s_name = $('#section_name_text_' + secId).val();

                $('.section_names_save').each(function () {

                    newVal = {
                        'id': $(this).attr('data-id'),
                        'val': $(this).val()
                    };
                    newVals.push(newVal);


                });
                $('.newSection').each(function () {

                    newVal = {
                        'id': $(this).attr('data-sid'),
                        'val': $(this).val()
                    };
                    newsecs.push(newVal);


                });


                $.ajax({
                    url: '{{url('/profile/name')}}',
                    data: {'data': newVals, 'secs': newsecs},
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function () {

                    },
                    success: function (response) {
                        console.log(response);
                        btn.html('Saved');

                    },
                    type: 'POST'
                });

                var dbVals = [];
                $('.db_section_names_save').each(function () {
                    dbVal = {
                        'id': $(this).attr('db_section_id'),
                        'val': $(this).val()
                    };
                    dbVals.push(dbVal);
//                        console.log(dbVals);
                });
                btn = $(this);

                $.ajax({
                    url: '{{url('/profile/dbname')}}',
                    data: {'data': dbVals},
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function () {

                    },
                    success: function (response) {
                        btn.html('Saved');

                    },
                    type: 'POST'
                });
            });


            $('.remPsec').on('click', function () {

                var sec_id = $(this).attr('data-remid');
                var db_sec_id = $(this).attr('data-secid');

                $.ajax({
                    url: '/profile/remove',
                    data: {'sec_id': sec_id, db_sec: db_sec_id},
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function () {

                    },
                    success: function (response) {
                        console.log(response);
                    },
                    type: 'POST'
                });


            });
//                $('.badge-upload').on('click',function(){
//                    var badge_name = $(this).attr('badge_name');
//
//                    var token=$('input[name="_token"]').val();
//                    $.ajax({
//                        url: JS_BASE_URL+'/profile/badge-update/ba',
//                        data: {'name' : badge_name, _token: token},
//                        error: function() {
//
//                        },
//                        success: function(response) {
////                            if(response.status == 'true'){
////                                window.location.href = JS_BASE_URL+'/album';
////                            }
//                        },
//                        type: 'POST'
//                    });
//                });


        })();

    </script>


@stop
@stop
