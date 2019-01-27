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

                    {{-- sort by section start :: wahid --}}
<!--                     <div class="row">
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
                    </div> -->
                    {{-- sort by section end :: wahid --}}
					{!! Breadcrumbs::render('category') !!}
                    <hr>
                    <h1>Category</h1>
                    @foreach($allCategories as $cat)
                        <div id="{{$cat['name']}}">
                            <h2 style="cursor: pointer; margin-bottom:0">
                                <img src="{{asset("images/category/logo-green/".$cat['logo_green'])}}" width="50" height="50">
                                &nbsp;&nbsp;&nbsp;&nbsp;{{$cat['description']}}
                            </h2>
                            <div class="col-xs-offset-1">
                                <ul class="list-unstyled" style="font-size:130%">
                                    @foreach($allsubCategories as $subCat)
                                        @if($subCat['id'] == $cat['id'])
                                            <li><a href="{{URL::to('sub-cat-details',array($cat['id'], $subCat['subid'],false))}}">{{$subCat['subdescription']}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <br>
                    @endforeach

                </div>
            </div>
        </div><!--End main cotainer-->
    </section>
@stop
