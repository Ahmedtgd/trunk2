@extends("common.default")

@section("content")

    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active floor-navigation"><a href="#pinformation">Information</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#delivery">Delivery</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#wholesale">WholeSale</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#product">Product</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#pspecification">Specification</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#seller">Seller</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#policy">Policy</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#return">Return</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                    <hr>

                    <form class="form-horizontal">
                        <div id="pinformation" class="row">
                            <div class="col-sm-12"><h1>Product Information</h1></div>
                            <div class="col-sm-3">
                            <div class="thumbnail">
                                <img src="images/product.png" title="product-image" class="img-responsive">
                            </div>
                            </div>

                            <div class="col-sm-9">
                               <dl class="dl-horizontal text-muted">
                                 
                                    <dt>Name</dt><dd>{{ $product['pro']->name ? $product['pro']->name : "-" }}</dd>
                                    <dt>Brand:</dt><dd>{{ $product['pro']->brand ? $product['pro']->brand->name : "-" }}</dd>
                                    <dt>Category:</dt><dd>{{ $product['pro']->category ? $product['pro']->category->name : "-" }}</dd>
                                    <dt>Sub Category</dt><dd>{{ $product['sub_product'] ? $product['sub_product']->name : "-" }}</dd>
                                    <dt>O-Shop</dt><dd>{{ $product['merchant'] ? $product['merchant'][0]->oshop_name : "" }}</dd>
                                    <dt>Short Description</dt><dd>{{ $product['pro']->description ? $product['pro']->description : "-" }}
                                    </dd>
                                </dl>
                                <div class="row">
                                <div class="col-sm-4 margin-top">
                                    <table class="table noborder">
                                        <?php
                                        $original = $product['pro']->original_price ? $product['pro']->original_price : "0.0";
                                        $delivery = $product['pro']->del_west_malaysia ? $product['pro']->del_west_malaysia : "0.0";
                                        ?>
                                        <tr><th>Amount</th><td>{{$currentCurrency}}</td><td>{{ $original }}</td></tr>
                                        <tr><th>Delivery</th><td>{{$currentCurrency}}</td><td>{{ $delivery }}</td></tr>
                                        <tr><td colspan="3"><hr></td></tr>
                                        <tr><th>&nbsp</th><td>{{$currentCurrency}}</td><td>{{ $original+$delivery }}</td></tr>
                                    </table>
                                </div>
                                <div class="col-sm-3 col-sm-offset-5">
                                    <ul class="list-inline pull-right">
                                        <li class="btn btn-lg btn-green"><i class="fa fa-lg fa-plus"></i></li>
                                        <li class="btn btn-lg btn-pink"><i class="fa fa-lg fa-heart"></i></li>
                                        <li class="btn btn-lg btn-darkgreen"><i class="fa fa-lg fa-shopping-cart"></i></li>
                                    </ul>
                                </div>
                            </div>
                            </div>

                            <div class="clearfix"></div>

                        </div>
                        <hr>
                        <div id="delivery">

                            <div class="col-sm-2">
                                <label class="">Delivery Pricing</label>
                            </div>


                            <div class="col-sm-4">

                                <table class="table dpricing noborder">
                                    <tr><th>International</th><td>{{ $product['pro']->del_worldwide ? $currentCurrency . ' ' . $product['pro']->del_worldwide : "0.0" }}</td></tr>
                                    <tr class="active"><th>West Malaysia</th><td>{{ $delivery }}</td></tr>
                                    <tr><th>Sabah/Labuan</th><td>{{ $product['pro']->del_sabah_labuan ?  $currentCurrency . ' ' . $product['pro']->del_sabah_labuan : "0.0" }}</td></tr>
                                    <tr><th>Sarawak</th><td>{{ $product['pro']->del_sarawak ? $currentCurrency . ' ' . $product['pro']->del_sarawak : "0.0" }}</td></tr>
                                </table>

                            </div>
                            <div class="col-sm-3 col-sm-offset-3">
                                <h3>Delivery Coverage</h3>
                                <table class="table dcoverage">
                                    <tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
                                    <tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
                                    <tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
                                </table>

                            </div>
                            <div class="clearfix"> </div>
                            <hr>
                         <div class="col-sm-12">
                                <h1>Retail</h1>
                            </div>

                            <div class="col-sm-5 retail">
                                <?php
                                    $retail = $product['pro']->retail_price ? $product['pro']->retail_price : 0;
                                    $original = $product['pro']->original_price ? $product['pro']->original_price : 0;
                                    $diff = $original - $retail;
                                    $save = (100 * intval($diff != 0 ? $diff : 1 )) / intval($original != 0 ? $original : 1 ); 
                                ?>
                                <table class=" table">
                                    <tr><th>Retail Price</th><td>{{ $currentCurrency . $retail }}<strong class="pull-right text-danger">{{ $save > 0 ? 'Save '.$save.'%' : "" }}</strong> </td></tr>
                                    <tr><th>Original Price</th><td><span class="strikethrough">{{ $currentCurrency . $original }}</span> </td></tr>
                                    <tr><th>Available</th><td>{{ $product['pro']->available ? $product['pro']->available : "0"}}</td></tr>
                                    <tr><th>Quantity</th><td> 
                                          <div class="input-group col-sm-6">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number" data-type="plus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                          </span>
                                          <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number"  data-type="minus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                              </button>
                                          </span>
                                          </div>

                                        </td></tr>
                                </table>

                            </div>

                            <div class="clearfix"> </div>
                        </div>
                        <hr>
                        <div id="wholesale">

                            <div class="col-xs-12">
                                <h1>Business to Business</h1>
                            </div>
                            <div class="col-sm-6">
                                <h3>Wholesale Price</h3>
                            </div>
                            <div class="col-sm-6">
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" checked="" class="styled" id="checkbox2">
                                    <label for="checkbox2">
                                        Display
                                    </label>
                                </div>
                            </div>

                            <div class="clearfix"> </div>
<hr>

                            <div class="col-sm-4">
                                <label>Resellers</label>
                                <p>Autofix Garage Sdn Bhd (954-783-T)</p>

                                <table class="table swholesale noborder">
                                    <tr><th>Unit</th><th>Price</th></tr>
                                    @if($product['pro']->Wholesale)
                                        @foreach($product['pro']->Wholesale as $wholesale )
                                            <tr class="active"><td>{{ $wholesale->unit ? $wholesale->unit : '0' }}</td><td>{{$currentCurrency}} {{ $wholesale->price ? $wholesale->price : '0.0' }}</td></tr>                                        
                                        @endforeach
                                    @endif
                                </table>

                            </div>
                            <div class="col-sm-4">
                                <h3>Average Price</h3>
                                <table class="table dcoverage">
                                    <tr><th>{{$currentCurrency}} {{ count($product['pro']->Wholesale) ? ($product['pro']->Wholesale[0]->price)/($product['pro']->Wholesale[0]->unit) : "0.0" }}</th><td><strong class="text-danger">Save {{ count($product['pro']->Wholesale) ? '28.4%' : "0.0%" }}</strong> </td></tr>
                                    <tr><th>Quantity</th><td>

                                            <div class="input-group  col-sm-7">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number" data-type="plus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                          </span>
                                                <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number"  data-type="minus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                              </button>
                                          </span>
                                            </div>

                                        </td></tr>
                                    <tr><th></th><td>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" checked="" class="styled" id="checkbox2">
                                                <label for="checkbox2">
                                                    Display
                                                </label>
                                            </div></td></tr>
                                </table>

                            </div>
                            <div class="col-sm-4">
                                <h3>Delivery Coverage</h3>
                                <table class="table dcoverage">
                                    <tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
                                    <tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
                                    <tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
                                </table>

                            </div>
                            <div class="clearfix"> </div>

                            <div class="col-sm-6">
                                <h3>Special Price</h3>
                            </div>


                            <div class="clearfix"> </div>
                            <hr>
                            <div class="col-sm-4">

                                <table class="table swholesale noborder">
                                    <tr><th>Unit</th><th>Price</th></tr>
                                    @if($product['pro']->productdealer)
                                        @foreach($product['pro']->productdealer as $productdealer )
                                            <tr class="active"><td>{{ $productdealer->unit ? $productdealer->special_unit : '0' }}</td><td>{{$currentCurrency}} {{ $productdealer->special_price ? $productdealer->special_price : '0.0' }}</td></tr>                                        
                                        @endforeach
                                    @endif
                                </table>

                            </div>
                            <div class="col-sm-4">
                                <h3>Average Price</h3>
                                <table class="table dcoverage">
                                    <tr><th>{{$currentCurrency}} {{ count($product['pro']->productdealer) ? ($product['pro']->productdealer[0]->special_price)/($product['pro']->productdealer[0]->special_unit) : "0.0" }}</th><td><strong class="text-danger">Save {{ count($product['pro']->productdealer) ? '28.7%' : "0.0%" }}</strong> </td></tr>
                                    <tr><th>Quantity</th><td>

                                            <div class="input-group  col-sm-7">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number" data-type="plus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                          </span>
                                                <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number"  data-type="minus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                              </button>
                                          </span>
                                            </div>

                                        </td></tr>
                                    <tr><th></th><td>
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" checked="" class="styled" id="checkbox2">
                                                <label for="checkbox2">
                                                    Display
                                                </label>
                                            </div></td></tr>
                                </table>

                            </div>
                            <div class="col-sm-4">
                                <h3>Delivery Coverage</h3>
                                <table class="table dcoverage">
                                    <tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
                                    <tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
                                    <tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
                                </table>

                            </div>
                            <div class="clearfix"> </div>


                        </div>
                        <hr>
                        <div id="product">
                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Product Details</a>
                            </div>
                            <div class="col-xs-12" style="min-height: 20px;">
                                {{ $product['pro']->product_details ? $product['pro']->product_details : "-" }}
<!--                                <h4 class="text-info"><a> Health, Safety & Environment</a></h4>
<p> Health & Safety </p>
                                <img src="images/ProductpageConsumer.png" title="banner" class="img-responsive banner">
                                <p>A merchant consultant helps merchants to get on board our system as quickly as possible, from the aspect of products registration all the way to pricing. Our Knowledgeable merchant consultants will provide friendly and dependable service each step of the way. </p>
                                <p>A merchant consultant helps merchants to get on board our system as quickly as possible, from the aspect of products registration all the way to pricing. Our Knowledgeable merchant consultants will provide friendly and dependable service each step of the way. </p>-->

                            </div>

                        </div>
                        <div id="pspecification">
                            <div class="col-xs-12">
                                <h1>Product Specification</h1>
                            </div>

                            <div class="col-sm-6 col-sm-offset-1 col-xs-12 table-responsive">
                                <table class="table pspecs">
                                    <tr><td>SKU</td><td>10000021494</td></tr>
                                    <tr><td>Colour</td><td>Yellow</td></tr>
                                    <tr><td>Model</td><td>APISN: ACELA A3/B3</td></tr>
                                    <tr><td>Size(L x W x H)</td><td>30cm x 23.6cm x 12.6 cm</td></tr>
                                    <tr><td>Weight</td><td>4.3kg</td></tr>
                                    <tr><td>Warranty Period</td><td>25 september 2018</td></tr>
                                    <tr><td>Warranty Type ++</td><td></td></tr>
                                </table>
                            </div>

                            </div>
                        <div id="seller">
                            <div class="col-xs-12">
                                <h1>Seller Information</h1>
                            </div>

                            <div class="col-sm-6 col-sm-offset-1 col-xs-12 table-responsive">
                                <table class="table pseller">
                                    <tr><td>Seller Name</td><td>{{ $product['merchant'][0]->company_name }}</td></tr>
                                            <tr><td>Ship form Address</td><td>
                                            {{ $product['merchant'][0]->address ?
                                                $product['merchant'][0]->address->line_1.'<br>'.
                                                $product['merchant'][0]->address->line_2.'<br>'.
                                                $product['merchant'][0]->address->line_3.'<br>'.
                                                $product['merchant'][0]->address->line_4.'<br>'.
                                                $product['merchant'][0]->address->city_id.' '.$product['merchant'][0]->address->postcode  
                                            :
                                                "-"  
                                            }}
                                        </td></tr>
                                    <tr><td>Return / Exchange Address:</td><td>
                                            {{ $product['merchant'][0]->address ?
                                                $product['merchant'][0]->address->line_1.'<br>'.
                                                $product['merchant'][0]->address->line_2.'<br>'.
                                                $product['merchant'][0]->address->line_3.'<br>'.
                                                $product['merchant'][0]->address->line_4.'<br>'.
                                                $product['merchant'][0]->address->city_id.' '.$product['merchant'][0]->address->postcode  
                                            :
                                                "-"  
                                            }}
                                            </td></tr>
                                </table>
                            </div>

                            </div>
                        <div id="policy">
                            <div class="col-xs-12">
                                <h1>Seller Policy</h1>
                            </div>

                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Product Details</a>
                            </div>

                            <div class="col-xs-12">
                                <p>You are only entitled to a refund if you return it within three or four weeks, other wise you can get a repair or replacement</p>
                                <p>Must display on receipt or signs in store and online</p>

                            </div>
                            </div>
                        <div id="return">
                            <div class="col-xs-12">

                                <h1>OpenSupermall</h1>
                                <h3>Notice on Return</h3>


                            </div>
                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Return / Exchange Policy</a>

                            </div>
                            <div class="col-xs-12">
                                <div class="thumbnail">
                                    {{ $product['merchant'] ? $product['merchant'][0]->return_policy : "" }}
                                </div>
                                </div>
                            </div>
                        </div>

                    </form>


                </div>
            </div>
        </div><!--End main cotainer-->
    </section>
@stop