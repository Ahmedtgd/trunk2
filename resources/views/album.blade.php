@extends("common.default")

@section("content")
    <style>
        .badge-checkbox {
            -webkit-appearance: checkbox;
            -moz-appearance: checkbox;
            -ms-appearance: checkbox;
        }

    </style>

    <script type="text/javascript">

        $(function () {
            $('#button').click(function () {
                $('#table_row').toggle();
            });
        });</script>

    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="floor-navigation"><a href="#categories">Categories</a></li>
                        <li role="presentation" class="active floor-navigation"><a href="#information">Information</a>
                        </li>
                        <li role="presentation" class="floor-navigation"><a href="#signboards">Signboard</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#buntings">Bunting</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#merchandise">Merchandise</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#video-banners">Banners</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">


                    <form class="form-horizontal">

                        <h1>Album</h1>
                        <hr>

                        <div id="categories" class="">
                            <h2>Add CATEGORIES </h2>
                            <div class="margin-top">
                                <div class="row col-sm-3">
                                    <select class="form-control" id="mainCat"
                                            data-url="{{  URL::to("create_new_product/" ) }}"
                                            {{$param == 'profilesetting' ? 'disabled':null}}>
                                        <option value="">Choose Option</option>
                                        @foreach($allcategory as $cat)
                                            <?php $flag = false; ?>
                                            @foreach($cat_name as $CN)
                                                @if($CN['cat_id'] == $cat->id)
                                                    <?php $flag = true; ?>
                                                @endif
                                            @endforeach
                                            <option value="{{ $cat->description}}%id%{{$cat->id}}"
                                                    @if($flag) disabled @endif>{{ $cat->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                            <div id="append-subCate" class="row">
                                @foreach($cat_name as $CN)
                                    <div class="listgroupsbox col-sm-3" id="listgroups"
                                         data-listgroup="{{ $CN['cat_description'] }}">
                                        <ul class="list-group list-unstyled" >
                                            <li class="btn list-group-item active">{{ $CN['cat_description'] }}</li>
                                            <li>
                                                <ul class="list-unstyled inner-lvl">
                                                    @foreach($subcat as $SC)
                                                        @if($SC['cat_id'] == $CN['cat_id'])
                                                            @if($SC['product_count'] > 0)
                                                                <li class="list-group-item {{$param == 'profilesetting' ? 'disabled':null}}"
                                                                    item-count="{{ $SC['product_count'] }}"
                                                                    data-catnames="{{$SC['sub_description']}}%d%{{$CN['cat_description']}}"
                                                                    data-categoriesId="{{$SC['sub_id']}},{{$SC['cat_id']}}">{{ $SC['sub_description'] }}
                                                                    (<span class="count{{$SC['sub_id']}}">{{ $SC['product_count'] }}</span>)
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li class="list-group-item"><a class="btn btn-primary form-control {{$param == 'profilesetting' ? 'disabled':null}}"
                                                                           href="{{ URL::to("create_new_product/".$CN['cat_id']) }}">
                                                    <i class="fa fa-plus-circle"></i>
                                                    Create New Products</a></li>
                                        </ul>
                                    </div>
                                @endforeach
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <div id="information" class="border-bottom-dotted">
                            <h2>Product MASTER </h2>
                            <div class=" row">
                                <div id="show_message">

                                </div>
                                <div class="table-responsive col-sm-12 ">
                                    <table class="table table-bordered text-muted" id="p-detailT">
                                        <tr class="bg-black">
                                            <th colspan="10">Product Details
                                                <button type="button" class="btn btn-primary col-xs-offset-1"
                                                        id="update-pro">Update
                                                </button>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-danger"
                                                        id="del-pro" style="display: none;">Delete
                                                </button>
                                                <button type="button" class="btn btn-primary col-xs-offset-2"
                                                        id="dropdown">Click Me
                                                </button>
                                            </th>
                                        </tr>
                                        <tr class="bg-black" id="table_row">
                                            <th></th>
                                            <th>No</th>
                                            <th>PID</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>SubCategory</th>
                                            <th>Short Description</th>
                                            <th>Quantity</th>
                                        </tr>
                                        @foreach($profile_products as $profile_product)

                                            @if(!is_null($profile_product->product))

                                                <tr class="{{$profile_product->product->id or ''}}"
                                                    data-subcategoryid="{{$profile_product->product->subcat_id or ''}}">
                                                    <td><input type="checkbox" class="del-val"
                                                               data-pro-id="{{$profile_product->product->id or ''}}">
                                                    </td>
                                                    <td>{{$profile_product->id or ''}}</td>
                                                    <td>{{$profile_product->product->id or ''}}</td>
                                                    <td class="edit_pro">{{$profile_product->product->name or ''}}</td>
                                                    <td class="edit_pro main-cat" data-action="update"
                                                        data-rowid="{{$profile_product->product->id or ''}}"
                                                        data-columnname="category_id" data-tablename="Product"
                                                        data-value="{{$profile_product->product->category_id}}">{{$profile_product->product->category->description or ''}}</td>
                                                    <td class="edit_pro" data-action="update"
                                                        data-rowid="{{$profile_product->product->id or ''}}"
                                                        data-columnname="brand_id"
                                                        data-tablename="Product">{{$profile_product->product->brand->name or ''}}</td>
                                                    <td class="edit_pro" data-action="update"
                                                        data-rowid="{{$profile_product->product->id or ''}}"
                                                        data-columnname="subcat_id"
                                                        data-product-id="{{$profile_product->product->id}}"
                                                        data-tablename="Product">{{$profile_product->product->subCat->description or ''}}</td>
                                                    <td class="edit_pro" data-action="update"
                                                        data-rowid="{{$profile_product->product->id or ''}}"
                                                        data-columnname="product_details"
                                                        data-tablename="Product">{{$profile_product->product->description or ''}}</td>
                                                    <td class="edit_pro" data-action="update"
                                                        data-rowid="{{$profile_product->product->id or ''}}"
                                                        data-columnname="available"
                                                        data-tablename="Product">{{$profile_product->product->available or ''}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                                <div class="table-responsive col-sm-12">
                                    <table class="table table-bordered text-muted " id="p-pricingT">
                                        <tr class="bg-gray">
                                            <th colspan="10">Pricing</th>
                                        </tr>
                                        <tr class="bg-gray">
                                            <th>No</th>
                                            <th>PID</th>
                                            <th>Retail Price</th>
                                            <th>Original Price</th>
                                            <th>WholesaleXXXX Price</th>
                                            <th>Unit</th>
                                            <th>Special Price</th>
                                            <th>Unit</th>
                                            <th>Username</th>
                                            <th>Shipping Cost</th>
                                        </tr>
                                        @foreach($profile_products as $profile_product)
                                            @if(!is_null($profile_product->product))
                                                <tr class="{{$profile_product->product->id}}">
                                                    <td>{{$profile_product->id}}</td>
                                                    <td>{{$profile_product->product->id}}</td>
                                                    <td class="edit_pro">{{$profile_product->product->retail_price or ''}}</td>
                                                    <td class="edit_pro">{{$profile_product->product->original_price or ''}}</td>
                                                    <td><span class="edit_pro" data-action="update" data-rowid="19"
                                                              data-columnname="price"
                                                              data-tablename="Wholesale">{{$profile_product->product->wholesale()->first()->price or ''}}</span><span
                                                                class="pull-right" data-toggle="collapse"
                                                                href="#pricecollapse1" aria-expanded="false"
                                                                aria-controls="pricecollapse1"><i
                                                                    class="fa fa-caret-down"></i></span>
                                                        <ul class="list-group collapse" id="pricecollapse1"></ul>
                                                    </td>
                                                    <td><span class="edit_pro" data-action="update" data-rowid="19"
                                                              data-columnname="unit"
                                                              data-tablename="Wholesale">{{$profile_product->product->wholesale()->first()->unit or ''}}</span><span
                                                                class="pull-right" data-toggle="collapse"
                                                                href="#unitcollapse1" aria-expanded="false"
                                                                aria-controls="unitcollapse1"><i
                                                                    class="fa fa-caret-down"></i></span>
                                                        <ul class="list-group collapse" id="unitcollapse1"></ul>
                                                    </td>
                                                    <td><span class="edit_pro" data-action="update" data-rowid="30"
                                                              data-columnname="special_price"
                                                              data-tablename="Productdealer">---</span><span
                                                                class="pull-right" data-toggle="collapse"
                                                                href="#Spricecollapse1" aria-expanded="false"
                                                                aria-controls="Spricecollapse1"><i
                                                                    class="fa fa-caret-down"></i></span>
                                                        <ul class="list-group collapse" id="Spricecollapse1"></ul>
                                                    </td>
                                                    <td><span class="edit_pro" data-action="update" data-rowid="30"
                                                              data-columnname="special_unit"
                                                              data-tablename="Productdealer">---</span><span
                                                                class="pull-right" data-toggle="collapse"
                                                                href="#Suintcollapse1" aria-expanded="false"
                                                                aria-controls="Suintcollapse1"><i
                                                                    class="fa fa-caret-down"></i></span>
                                                        <ul class="list-group collapse" id="Suintcollapse1"></ul>
                                                    </td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>

                                </div>

                                <div class="table-responsive col-sm-12">
                                    <table class="table table-bordered text-muted " id="p-specsT">
                                        <tr class="bg-lightgray">
                                            <th colspan="10">Product Specifications</th>
                                        </tr>
                                        <tr class="bg-lightgray">
                                            <th>No</th>
                                            <th>PID</th>
                                            <th>Color</th>
                                            <th>Original Price</th>
                                            <th>Model</th>
                                            <th>Size (LxWxH)</th>
                                            <th>Weight</th>
                                            <th>Warranty Period</th>
                                            <th>Warranty Type</th>
                                        </tr>
                                        @foreach($profile_products as $profile_product)
                                            @if(!is_null($profile_product->product))
                                                <tr class="{{$profile_product->product->id}}">
                                                    <td>{{$profile_product->id}}</td>
                                                    <td>{{$profile_product->product->id}}</td>
                                                    <td class="edit_pro">{{$profile_product->product->specification()->whereName('color')->first()->description or ''}}</td>
                                                    <td class="edit_pro" id="model" data-action="update"
                                                        data-rowid="144" data-columnname="value"
                                                        data-tablename="productspec">{{$profile_product->product->original_price}}</td>
                                                    <td class="edit_pro" id="size" data-action="update" data-rowid="145"
                                                        data-columnname="value"
                                                        data-tablename="productspec">{{$profile_product->product->specification()->whereName('model')->first()->description or ''}}</td>
                                                    <td class="edit_pro" id="weight" data-action="update"
                                                        data-rowid="146" data-columnname="value"
                                                        data-tablename="productspec">{{$profile_product->product->specification()->whereName('size')->first()->description or ''}}</td>
                                                    <td class="edit_pro" id="warranty" data-action="update"
                                                        data-rowid="147" data-columnname="value"
                                                        data-tablename="productspec">{{$profile_product->product->specification()->whereName('weight')->first()->description or ''}}</td>
                                                    <td class="edit_pro" data-action="add" data-spec="warranty_type"
                                                        data-tablename="Specification"
                                                        data-rowid="126">{{$profile_product->product->specification()->whereName('warranty_period')->first()->description or ''}}</td>
                                                    <td>{{$profile_product->product->specification()->whereName('warranty_type')->first()->description or ''}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div id="signboards" class="border-bottom-dotted">
                            <h2>SIGNBOARD
                                <small>
                                    <span id="signboar-counter"
                                          data-row-count="{{count($signboards)}}">{{count($signboards)}}</span> results
                                </small>
                                @if($param !== 'profilesetting')
                                    <a class="text-green pull-right" id="upldsb"><i class="fa fa-lg fa-plus-circle"></i></a>
                                @endif
                            </h2>
                            <?php $index = 1; ?>
                            @if(count($signboards)>0)
                                <div id="append-sb-img" class="col-sm-offset-0">
                                    @foreach($signboards as $signboard)

                                        <div class="col-sm-11 upld-signboard main-parent">
                                            <?php // echo $updateSignboard.'fghdf';?>
                                            @if($updateSignboard == 'null' && $param == 'profilesetting')
                                            <input type="radio"
                                                   class="badge-checkbox"
                                                   name="sign-board" data-id="{{$signboard->id}}"
                                                   value="{{$signboard->id}}"/>
                                            @endif
                                            @if($param !== 'profilesetting')
                                            <a class="badge badge-close remupldsignboard"
                                               data-id="{{$signboard->id}}">X</a>
                                            @endif
                                            <img alt=""
                                                 src="{{asset('images/signboard/'.$signboard->id.'/'.$signboard->image)}}"
                                                 id="preview-img-sb{{$index}}" class="img-responsive current-signboard">
                                            @if($param !== 'profilesetting')
                                            <div class="inputBtnSection">
                                                <label class="fileUpload">
                                                    <input type="file" class="upload signboardupload"
                                                           id="signboarduploadBtn"
                                                           data-imgid="{{$index}}" name="file"
                                                           data-rowid="{{$signboard->id}}">
                                                    <span class="uploadBtn badge"><i
                                                                class="fa fa-lg fa-upload"></i></span>
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                        <?php $index = $index + 1; ?>
                                    @endforeach
                                </div>
                                <div class="clearfix"></div>
                            @else
                                <div id="append-sb-img" class="col-sm-offset-0">
                                    <div class="col-sm-11 upld-signboard main-parent">
                                        <a class="badge badge-close remupldsignboard" data-id="">X</a>
                                        <img alt="" src="" id="preview-img-sb{{$index}}"
                                             class="img-responsive current-signboard">
                                        <div class="inputBtnSection">
                                            <label class="fileUpload">
                                                <input type="file" class="upload signboardupload"
                                                       id="signboarduploadBtn" data-imgid="1" name="file" data-rowid="">
                                                <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            @endif
                        </div>

                        <div id="buntings" class="border-bottom-dotted">
                            <h2>BUNTING
                                <small><span id="bunting-counter"
                                             data-row-count="{{count($buntings)}}">{{count($buntings)}}</span> results
                                </small>
                                @if($param !== 'profilesetting')
                                    <a class="text-green pull-right" id="upldbb"> <i
                                                class="fa fa-lg fa-plus-circle"></i></a>
                                @endif
                            </h2>
                            <?php $index = 1; ?>
                            @if(count($buntings)>0)
                                <div id="append-bb-img" class="col-sm-offset-0">
                                    @foreach($buntings as $bunting)
                                        <div class="col-sm-2 upld-bunting main-parent">
                                            @if( $updateBunting == 'null' && $param == 'profilesetting')
                                                <input type="radio"
                                                       class="badge-checkbox"
                                                       name="bunting" data-id="{{$bunting->id}}"
                                                       value="{{$bunting->id}}"/>
                                            @endif
                                            @if($param !== 'profilesetting')
                                                <a class="badge badge-close remupldbunting"
                                                   data-id="{{$bunting->id}}">X</a>
                                            @endif
                                            <img alt=""
                                                 src="{{asset('images/bunting/'.$bunting->id.'/'.$bunting->image)}}"
                                                 id="preview-img-bnt{{$index}}" class="img-responsive current-bunting">
                                            <div class="inputBtnSection">
                                                <input disabled="disabled" class="disableInputField">
                                                <label class="fileUpload">
                                                    <input type="file" class="upload" id="bntuploadBtn"
                                                           data-imgid="{{$index}}" data-rowid="{{$bunting->id}}">
                                                    @if($param !== 'profilesetting')
                                                        <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                        <?php $index = $index + 1; ?>
                                    @endforeach
                                </div>
                                <div class="clearfix"></div>
                            @else
                                <div id="append-bb-img" class="col-sm-offset-0">
                                    <div class="col-sm-2 upld-bunting main-parent">
                                        <a class="badge badge-close remupldbunting" data-id="">X</a>
                                        <img alt="" src="" id="preview-img-bnt{{$index}}"
                                             class="img-responsive current-bunting">
                                        <div class="inputBtnSection">
                                            <input disabled="disabled" class="disableInputField">
                                            <label class="fileUpload">
                                                <input type="file" class="upload" id="bntuploadBtn"
                                                       data-imgid="{{$index}}" data-rowid="">
                                                <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            @endif
                        </div>
                        <div id="merchandise" class="border-bottom-dotted">
                            <h2>PRODUCTS
                                <small><span id="pro-counter">{{count($merchant_pro)}}</span> results</small>
                                <!--<a class="text-green pull-right" id="upldpro"> <i class="fa fa-lg fa-plus-circle"></i></a>-->
                            </h2>
                            <div id="append-pro">
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <div class="category col-md-12" style="padding-left:0">
                                            <?php $sub_cats = $category->subCatLevel1; ?>
                                            @if(count($sub_cats) && Helper::countProducts($category, $merchant_pro))
                                                <h2>{{$category->description}}</h2>
                                            @endif
                                            @foreach($sub_cats as $sub_cat)
                                                <div class="sub-cat col-md-12" style="padding-left:0">
                                                    <?php $products = $sub_cat->product()->whereIn('id', $merchant_pro->lists('id', 'id'))->get(); ?>
                                                    @if(count($products))
                                                        <h3 style="margin-bottom:0;">
                                                            @if(!is_null($section_id))
                                                                <input type="checkbox"
                                                                       class="sub_section sub_section_{{$sub_cat->id}}"
                                                                       name="section" data-id="{{$sub_cat->id}}"
                                                                       value="accepted"/>
                                                            @endif {{$sub_cat->description}}</h3>
                                                    @endif
                                                    @foreach($products as $product)
                                                        @if(false == array_search($product['id'],$selected_products))
                                                            <div class="p-box  col-sm-3 col-xs-12"
                                                                 id="pid{{$product['id']}}" style="padding-left:0">

                                                                @if(!is_null($section_id))
                                                                    <input type="checkbox"
                                                                           class="product_section product_section_{{$sub_cat->id}}"
                                                                           data-cat="{{$sub_cat->id}}"
                                                                           data-p="{{$product['id']}}"
                                                                           name="section"
                                                                           id="product_section_{{$sub_cat->id}}"
                                                                           value="accepted">
                                                                @endif
                                                                <div class="p-img">
                                                                    @if($param !== 'profilesetting')
                                                                        <a class="badge badge-close remProbox "
                                                                           data-pro-id="{{$product['id']}}"
                                                                           data-subid="{{$product['subcat_id']}}">X</a>
                                                                    @endif
                                                                    <a href="{{ route('productconsumer', $product['id']) }}">
                                                                        <img class="img-responsive"
                                                                             src="{{ asset('images/product/'.$product['id'].'/'.$product['photo_1']) }}">
                                                                    </a>
                                                                </div>
                                                                <table style="padding:0" class="table table-bordered">
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
                                                                        style="padding:0;width:100%">
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
                                                                        <li class="btn-pink"><i class="fa fa-heart"></i>
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
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif

                                @if(!is_null($section_id) || $updateBunting == 'null'|| $updateSignboard == 'null'|| $updateVideoBanner == 'null')
                                    <div class="col-md-12">
                                        <button class="btn btn-info pull-right" style="margin-bottom: 20px;"
                                                type="button" id="transfer_products">Copy
                                        </button>

                                    </div>
                                @endif

                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="video-banners" class="border-bottom-dotted">
                            <h2>VIDEOS/BANNERS
                                <small><span id="video-counter" data-row-count="1">{{count($vbanners)}}</span> results
                                </small>
                                @if($param !== 'profilesetting')
                                    <a class="text-green pull-right" id="upld-v-or-b"> <i
                                                class="fa fa-lg fa-plus-circle"></i></a>
                                @endif
                            </h2>
                            <?php $index = 1; ?>
                            @if(count($vbanners)>0)
                                <div id="append-v-or-b" class="col-sm-offset-0">
                                    @foreach($vbanners as $vbanner)
                                        <div id="video" class="col-xs-12 margin-top video-banner upld-bvideo">
                                            @if($updateVideoBanner == 'null' && $param == 'profilesetting')
                                                <input type="radio"
                                                       class="badge-checkbox"
                                                       name="video-banner" data-id="{{$vbanner->id}}"
                                                       value="{{$vbanner->id}}"/>
                                            @endif
                                            <div class="placeholder main-parent">
                                                @if($param !== 'profilesetting')
                                                    <a class="badge badge-close rem-v-or-b"
                                                       data-id="{{$vbanner->id}}">X</a>
                                                @endif
                                                <div id="block{{$index}}">
                                                    <?php
                                                    $path = explode(':', $vbanner->image)[0];
                                                    ?>
                                                    <span style="display: none" class="videobanner{{$index}}">
                                            @if($path == 'http' || $path == 'https')
                                                            {{$vbanner->image}}
                                                        @else
                                                            {{ asset('/images/vbanner/'.$vbanner->id.'/'.$vbanner->image)}}
                                                        @endif
                                        </span>
                                                </div>
                                                @if($param !== 'profilesetting')
                                                    <a class="badge badge-upload upload-vbanner"
                                                       data-rowid="{{$vbanner->id}}">
                                                        <i class="fa fa-lg fa-upload"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <?php $index = $index + 1; ?>
                                    @endforeach
                                </div>
                            @else
                                <div id="append-v-or-b" class="col-sm-offset-0">
                                    <div id="video" class="col-xs-12 margin-top video-banner upld-bvideo">
                                        <div class="placeholder main-parent">
                                            <a class="badge badge-close rem-v-or-b" data-id="">X</a>
                                            <div id="block{{$index}}">
                                                <span style="display: none" class="videobanner1"></span>
                                            </div>
                                            <a class="badge badge-upload upload-vbanner" data-rowid="">
                                                <i class="fa fa-lg fa-upload"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div><!--End main container-->
    </section>
@stop

@section('scripts')
	{{--
    <script type="text/javascript">
        var x = new EmbedJS({
            element: document.getElementById('block1'),
            googleAuthKey: 'AIzaSyCqFouT8h5DKAbxlrTZmjXEmNBjC69f0ts',
            videoDetails: false,
        });
        x.render();
        var y = new EmbedJS({
            element: document.getElementById('block2'),
            googleAuthKey: 'AIzaSyCqFouT8h5DKAbxlrTZmjXEmNBjC69f0ts',
            videoDetails: false,
        });
        y.render();
    </script>
	--}}

    <script type="text/javascript">
        $(document).ready(function () {

            path = window.location.href;
            var url;
//   if(path.contains('public')) {
//        url = '/OpenSupermall/public/cart/addtocart';
//   } else {
//        url = '/cart/addtocart';
//   }
            url = '{{url('/cart/addtocart')}}';
            $('.cartBtn').click(function (e) {
                e.preventDefault();
                var price = $(this).siblings('input[name=price]').val();
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        'quantity': $(this).siblings('input[name=quantity]').val(),
                        'id': $(this).siblings('input[name=id]').val(),
                        'price': price
                    },
                    success: function (data) {
                        $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
                        $('.cart-info').text(data[1] + ' {{$currentCurrency}}' + price + ' ' + " Successfully added to the cart");
                        if (data[0] < 1) {
                            $('.cart-link').text('Cart is empty');
                            $('.badge-cart').text('0');
                        }
                        else {

                            $('.cart-link').text('View Cart');
                            $('.badge-cart').text(data[0]);
                        }
                    }
                });
            });
            $('.sub_section').on('change', function () {
                cbox = $(this);
                var id = cbox.data('id');
                if (cbox.is(':checked')) {
                    $('.product_section_' + id).prop('checked', true);
                } else {
                    $('.product_section_' + id).prop('checked', false);
                }
            });
            $('#transfer_products').on('click', function () {
                        @if (!is_null($section_id))
                var data = [];
                var pro = "";
                var cate = [];
                $('.product_section').each(function () {
                    ckbox = $(this);
                    if (ckbox.is(':checked')) {
                        cat = ckbox.data('cat');
                        pro = ckbox.data('p');
                        newData = data[cat];
                        if (newData == undefined) {
                            data[cat] = [pro]
                        } else {
                            newData.push(pro);
                        }
                    }
                });
                $.ajax({
                    url: '{{url('/profile/add-section-product')}}',
                    data: {'data': data},
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function () {
                        console.log("error in transfering product");
                    },
                    success: function (response) {

                        if (response.status == 'true') {

                            window.location.href = JS_BASE_URL + '/profilesetting';
                        }
                    },
                    type: 'POST'
                });
                        @endif

                        @if ($updateBunting == 'null')
                var bunting_id = 0;
                $('.badge-checkbox').each(function () {
                    if ($(this).is(':checked')) {
                        bunting_id = $(this).val();
                    }
                });
                if (bunting_id != 0) {
                    $.ajax({
                        url: '{{url('/profile/badge-update')}}',
                        data: {'id': bunting_id, 'badge': 'bunting'},
                        headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                        error: function () {

                        },
                        success: function (response) {
                            if (response.status == 'true') {
                                window.location.href = '{{url('profilesetting')}}';
                            }
                        },
                        type: 'POST'
                    });
                }
                        @endif


                        @if ($updateVideoBanner == 'null')
                var videoBanner_id = 0;
                $('.badge-checkbox').each(function () {
                    if ($(this).is(':checked')) {
                        videoBanner_id = $(this).val();
                    }
                });
                if (videoBanner_id != 0) {
                    $.ajax({
                        url: '{{url('/profile/badge-update')}}',
                        data: {'id': videoBanner_id, 'badge': 'video-banner'},
                        headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                        error: function () {

                        },
                        success: function (response) {
                            if (response.status == 'true') {
                                window.location.href = '{{url('profilesetting')}}';
                            }
                        },
                        type: 'POST'
                    });
                }
                        @endif
                        @if ($updateSignboard == 'null')
                var signboard_id = 0;
                $('.badge-checkbox').each(function () {
                    if ($(this).is(':checked')) {
                        signboard_id = $(this).val();
                    }
                });
                if (signboard_id != 0) {
                    $.ajax({
                        url: '{{url('/profile/badge-update')}}',
                        data: {'id': signboard_id, 'badge': 'signboard'},
                        headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                        error: function () {

                        },
                        success: function (response) {
                            if (response.status == 'true') {
                                window.location.href = '{{url('profilesetting')}}';
                            }
                        },
                        type: 'POST'
                    });
                }
                @endif


            });
            $('.product_section').on('change', function () {
                var cat_id = $(this).data('cat');
                var status = $(this).is(':checked');
                if (status) {
                    var newstat = true;
                    $('.product_section_' + cat_id).each(function () {
                        if ($(this).is(':checked') != true) {
                            $('.sub_section_' + cat_id).prop('checked', false);
                            newstat = false;
                        }
                    });
                    if (newstat) {
                        $('.sub_section_' + cat_id).prop('checked', true);
                    }
                } else {
                    $('.sub_section_' + cat_id).prop('checked', false);
                }
            });
            //ends
        });
    </script>
@stop
