@extends("common.default")

@section("content")
    <style>
        .brandlist ul {
            list-style:none;
        }
        .brandlist ul li {

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
        .cat_image{display: block;overflow: hidden;margin-top: 28px}
        /*.cat_image img{background-color: rgb(39,169,138)}*/
        .cat_desc{text-transform: capitalize;}
        .cat_desc h3{margin:0px;}

        /*     .static-tab{
                 top:10%;
                 overflow: auto;
             }*/
    </style>
    <section class="">
    
        <div class="container"><!--Begin main cotainer-->
            <div class="row">

                <div data-spy="scroll" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <!--         <div class="food-category">
                       <ul class="nav nav-pills nav-stacked">
                          <?php $no = 1; ?>
                          @foreach($category as $cat)
                        <li role="presentation"><a href="#cat<?php echo $no ?>"><img src="{{asset('/')}}images/category/logo-green/{{$cat->logo}}" style="width:50px;height:50px"></a></li>
                         <?php $no++; ?>
                          @endforeach
                        </ul>
                    </div> -->

                    <div class="floor-directory">
                        <ul class="nav nav-pills nav-stacked">
                            <?php $no = 1; ?>
                            @foreach($category as $cat)
                                <li class="floor-navigation" role="presentation">
                                    <a href="#{{preg_replace('/[^A-Za-z0-9-]+/', '-', $cat->cat_name)}}">
                                <span class="btn-elevator">
                                   <img src="{{asset('/')}}images/category/logo-green/{{$cat->logo}}">
                                </span>
                                        <span class="back">{{$cat->cat_name}}</span>
                                        <br>
                                    </a></li>
                                <?php $no++; ?>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
					{!! Breadcrumbs::render('owarehouselist') !!}
                    <p>&nbsp;</p>
                    <div id="all-floors">
                        <div class="brandlist">
                            <h1>Hyper</h1>
                            <?php $count = 0; ?>

                            @foreach($category as $cat)
                                <?php $count++ ?>
                                <div id="{{preg_replace('/[^A-Za-z0-9-]+/', '-', $cat->cat_name)}}">
                                    <h2 style="cursor: pointer; margin-bottom:0">
                                        <img src="{{asset('/')}}images/category/logo-green/{{$cat->logo}}"
                                             style="width:50px;height:50px">
                                        &nbsp;&nbsp;&nbsp;{{ $cat->cat_name }}
                                    </h2>
                                    <?php
										$sub_cat = explode(',',$cat->sub_cat); 
										$sub_id = explode(',',$cat->sub_id);
                                    ?>
                                    <div class="col-xs-offset-1">
                                        <ul class="list-unstyled" style="font-size:130%">
                                            @for ($i = 0; $i <  count($sub_cat); $i++)
												 <li><a href='{{ route('owarehouse', [$sub_id[$i]]) }}'>{{ $sub_cat[$i] }}</a></li>
											@endfor
                                        </ul>
									</div>
                                </div>
                                <br>
                            @endforeach
                        </div>
                            <div class="clearfix"></div>
                            <div class="custom-border"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
@stop
