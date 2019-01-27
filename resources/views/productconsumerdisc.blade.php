<?php $active_currency = \App\Models\Currency::where('active', 1)->first()->code; ?>
@extends("common.default")
@def $currency = \App\Models\Currency::where('active', 1)->first()->code
@section("content")
<style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 0px solid #ddd;
    }

    .dl-horizontal dd {
        margin-left: 120px;
    }	

    .icons {
        margin-top: 0px !important;
    }

    /*   .panel-heading .nav li a:focus {
            background-color: #1abc9c;
            color: #fff;
       }*/
    .panel-heading ul { background: #e7e7e7; }

    .nav-tabs > li > .autolink_validation:hover {
        background-color: transparent;
    }	

    .li_same_size {
        width: 37px;
        height: 37px;
    }

    .panel-heading {
        padding: 5px 0px;
        border-bottom: 1px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }	

    #oshop {
        margin-left: 0;
        /* display: inline-block; */
    }
    .cartBtn {
    border-radius: 6px;
}	
</style>
<div class="container"><!--Begin main cotainer-->
    <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong class='cart-info'></strong>
    </div>
   	
    <div>
        
        <div class="panel-heading" style="font-size: 18px;">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a style="color: #000; font-size:18px;margin-left: 0px; padding-left: 10px; padding-right: 10px; margin-right: 0px;" id="oshop" href="{{route('oshop.one', ['id' => $merchant_id])}}" aria-controls="profile">O-Shop</a></li>
                <li role="presentation" id="retaila"><a style="color: #000; font-size:18px;margin-left: 0px; padding-left: 15px; padding-right: 15px; margin-right: 0px;" href="#retail" aria-controls="home" role="tab" data-toggle="tab">Retail</a></li>
                <li role="presentation" id="b2ba"><a style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px; padding-left: 20px; padding-right: 20px;" href="#b2b" aria-controls="profile" role="tab" data-toggle="tab">B2B</a></li>
                <li role="presentation" id="vouchera"><a style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;" href="#voucher" aria-controls="messages" role="tab" data-toggle="tab">Voucher</a></li>
                <li role="presentation" id="hypera"><a style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px;" href="#hyper" aria-controls="settings" role="tab" data-toggle="tab">Hyper</a></li>
                <li role="presentation" id="smma"><a style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px;" href="#smm" aria-controls="settings" role="tab" data-toggle="tab">SMM</a></li>
                <li role="presentation" id="oema"><a style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px; padding-left: 5px; padding-right: 5px;" href="#oem" aria-controls="settings" role="tab" data-toggle="tab">OEM/ODM</a></li>
            </ul>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="retail">
                <div class="row">
                    <div class="col-sm-12">


                        <form class="form-horizontal" style="margin-bottom:0;margin-top:0">
                            <div id="pinformation" class="row">
                                <div class="col-sm-12"><h1>Product Information</h1></div>
                                <div class="col-sm-3">
                                    <div class="thumbnail">
                                        <img src="{{asset('/')}}images/product/{{$product['pro']->id}}/{{$product['pro']->photo_1}}" title="product-image" class="img-responsive">
                                    </div>
                                </div>

                                <div class="col-sm-4" style='padding-right:0;padding-left:0'>
                                    <dl class="dl-horizontal text-muted">

                                        <dt>Name</dt>
                                        <dd style='margin-left:160px'>{{ $product['pro']->name ? $product['pro']->name : "-" }}</dd>
                                        <dt>Brand:</dt>
                                        <dd style='margin-left:160px'>{{ $product['pro']->brand ? $product['pro']->brand->name : "-" }}</dd>
                                        <dt>Category:</dt><dd style='margin-left:160px'>{{ $product['pro']->category ? $product['pro']->category->description : "-" }}</dd>
                                        <dt>Sub Category</dt>
                                        <dd style='margin-left:160px'>{{ $product['sub_product'] ? htmlentities($product['sub_product']->description) : "-" }}</dd>
                                        @if(isset($product['merchant'][0])) <dt>O-Shop</dt><dd style='margin-left:160px'>{{ $product['merchant'] ? $product['merchant'][0]->oshop_name : "" }}</dd>@endif
                                        <dt>Short Description</dt>
                                        <dd style='margin-left:160px'>{{ $product['pro']->description ? strip_tags($product['pro']->description) : "-" }}
                                            {{--<dt>Product Likes</dt><dd style='margin-left:160px'>{{ isset($summary['total_count']) ? $summary['total_count'] : 0 }}</dd>--}}
                                        </dd>
                                        <dt>Available<dt>
                                        <dd class="available" avail={{$product['pro']->available}}>
                                            {{$product['pro']->available?$product['pro']->available-1:"0"}}
                                        </dd>
                                    </dl>
                                </div>	
                                <div class="col-sm-3">
                                    <table class="table noborder">
                                        <?php
                                        $amount = $product['pro']->discounted_price ? $product['pro']->discounted_price / 100 : 0;
                                        if ($amount == "0") {
                                            $amount = $product['pro']->retail_price ? $product['pro']->retail_price / 100 : 0;
                                        }
                                        $delivery = $product['pro']->del_west_malaysia ? $product['pro']->del_west_malaysia / 100 : "0.0";
                                        ?>
                                        <input type="hidden" value="{{$product['pro']->free_delivery_with_purchase_qty ? $product['pro']->free_delivery_with_purchase_qty : '0'}}" id="free_delivery_with_purchase_qty" />
                                        <input type="hidden" value="{{ number_format($delivery,2) }}" id="mydelprice" />
                                        <tr><th>Amount</th>
                                            <td>{{ $currency }}</td>
                                            @if(!empty($discount_detail))
                                            <td>
                                                <span class="amt" amount={{$discount_detail['discounted_price_dis']}}>{{$discount_detail['discounted_price_dis']}}</span>


                                            </td>
                                            @else
                                            <td>

                                                <span class="amt" amount={{ $amount }}>{{ number_format($amount,2) }}
                                                </span>
                                            </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Delivery</th>
                                            <td>{{$currentCurrency}}</td>
                                            <td><span class="del_price">{{ number_format($delivery,2) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr><td colspan="3"><hr></td></tr>
                                        <tr>
                                            <th>&nbsp</th>
                                            <td>{{$currentCurrency}}</td>
                                            <td>
                                                @if(!empty($discount_detail))
                                                <span class="total">
                                                    {{ number_format($discount_detail['discounted_price_dis']+$delivery,2) }}
                                                </span>
                                                @else
                                                <span class="total">
                                                    {{ number_format($amount+$delivery,2) }}
                                                </span>
                                                @endif

                                            </td>
                                        </tr>
                                    </table>
                                    <div class="col-sm-8 icons" style="padding-left:0; " >
                                        <div class="input-group" style="width:130px; @if(!empty($discount_detail)) display: none; @endif">
                                            <span class="input-group-btn">
                                                <button @if(!empty($discount_detail)) disabled="" @endif type="button" style="@if(!empty($discount_detail)) background-color:rgb(214, 209, 209)!important; @endif" class="btn btn-green btn-number" data-type="plus" data-field="quant[2]">
                                                         <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                            <input @if(!empty($discount_detail)) readonly="" @endif style="text-align: center; padding-left: 0px; padding-right: 0px;width:100%; "
                                                    type="text" name="quant[2]" class="form-control input-number quantity"
                                                    value="1" min="1" max={{ $product['pro']->available ? $product['pro']->available - 1 : "0"}}>
                                                    <span class="input-group-btn">
                                                <button @if(!empty($discount_detail)) disabled="" @endif type="button" class="btn btn-green btn-number" style="@if(!empty($discount_detail)) background-color:rgb(214, 209, 209)!important; @endif" data-type="minus" data-field="quant[2]">
                                                         <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                        </div>	
                                        <br>
                                        <ul class="list-inline pull-left">
                                            <li class="btn btn-green " id="retail_add_to_cart">
                                                {!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}

                                                {!! Form::hidden('quantity', 1) !!}
                                                {!! Form::hidden('id', $product['pro']->id) !!}
                                                @if(!empty($discount_detail))
                                                {!! Form::hidden('price', $discount_detail["discounted_price_dis"]) !!}
                                                @else
                                                {!! Form::hidden('price', $amount) !!}
                                                @endif
                                                <button  class='cartBtnDisc btn-link' type='submit' style='padding: 0px;font-size: 18px;color: rgb(255, 255, 255);'><i class="fa fa-lg fa-shopping-cart"></i></button>
                                                 
                                                {!! Form::close() !!}
                                                
                                            </li>
                                            <li class="btn btn-lg btn-pink" style="@if(!empty($discount_detail)) display: none; @endif">
                                                <a href="javascript:void(0)" rel="nofollow" class="add-to-wishlist" style="color:white;" data-item-id="{{ $product['pro']->id }}">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </li>
                                            <li class="btn btn-lg " style="background-color:#1598EA;@if(!empty($discount_detail)) display: none; @endif" id="blast"><img src="{{asset('css/blaster.jpg')}}"></li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div> 
                                </div>							
                            </div>
                            <hr>
                            <div class="col-sm-12" id="myretail">
                                <h1>Retail</h1>
                            </div>

                            <div class="col-sm-4">
                                <?php
                                $strikethrough = "";
                                $disvisible = "none;";
                                $save = 0;
                                $retail = ($product['pro']->retail_price) / 100;
                                $original = ($product['pro']->discounted_price) / 100;
                                if ($original < $retail && $original > 0) {
                                    $save = 100 * (($retail - $original ) / $retail);
                                    $disvisible = "visible;";
                                    $strikethrough = "strikethrough";
                                }
                                if (!empty($discount_detail)) {
                                    $save = 100 * (($retail - $original ) / $retail);
                                    $disvisible = "visible;";
                                    $strikethrough = "strikethrough";
                                }
                                ?>
                                <table class=" table" style="border: 0px;">
                                    <!--
                                    <tr><th>Retail Price</th>
                                    <td class ='retail_price' rprice='{{$retail}}'>
                                    <span class="rprice">{{$retail != 0 ? "MYR ".number_format($retail,2) : "" }}</span>
                                    <strong class="pull-right text-danger">{{ $save > 0 ? 'Save '.number_format($save,2).'%' : "" }}</strong> </td></tr>
                                    <tr><th>Original Price</th><td>
                                    <span class="strikethrough">{{$original !=0 ? "MYR ".number_format($original,2) : "" }}</span> </td></tr>
                                    <tr><th>Available</th><td>
                                    <span class="available" avail={{$product['pro']->available}}>{{ $product['pro']->available ? $product['pro']->available - 1 : "0"}}</span></td></tr>
                                    -->
                                    <tr><th>Retail Price</th>
                                        <td class ='retail_price' rprice='{{$amount}}'>
                                            <span class="<?php echo $strikethrough; ?>">
                                                {{$retail !=0 ? $currentCurrency . " ".number_format($retail,2) : "" }}
                                            </span>
                                            @if(!empty($discount_detail))        
                                    <tr id="discounted" style="display: <?php echo $disvisible; ?>"><th>Discounted Price</th><td>
                                            <span>
                                                {{$discount_detail['discount_detail'] != null ? $currentCurrency . " ".$discount_detail['discounted_price_dis'] : "" }}<br>
                                            </span>
                                            <strong class="text-danger">
                                                {{ $discount_detail['discount_percentage_dis'] > 0 ? 'Save '.$discount_detail["discount_percentage_dis"].'%' : "" }}
                                            </strong>
                                        </td>
                                    </tr>
                                    @else
                                    <tr id="discounted" style="display: <?php echo $disvisible; ?>"><th>Discounted Price</th><td>
                                            <span>
                                                {{$original != 0 ? $currentCurrency . " ".number_format($original,2) : "" }}<br>
                                            </span>
                                            <strong class="text-danger">
                                                {{ $save > 0 ? 'Save '.number_format($save,2).'%' : "" }}
                                            </strong>
                                        </td>
                                    </tr>
                                    @endif
                                    </td></tr>
                                </table>

                            </div>	
                            <div class="col-sm-4">
                                <h3>Delivery Coverage</h3>
                                <table class="table dcoverage">
                                    <tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
                                    <tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
                                    <tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
                                    <tr><th>Area</th><td>{{ $product['pro']->area ? $product['pro']->area->name : "-" }}</td></tr>
                                </table>
                            </div>	
                            <div class="col-sm-4"> 
                                <h3>Delivery Pricing</h3>
                                <table class="table dpricing noborder">
                                    <tr class='price' price={{$product['pro']->del_worldwide/100}}><th>World Wide</th><td>{{ $product['pro']->del_worldwide ? $currentCurrency . ' '.number_format($product['pro']->del_worldwide/100,2) : "0.0" }}</td></tr>
                                    <tr class="active price addactive" price={{$delivery}}><th>West Malaysia</th><td>{{ $delivery == 0.0 ? $delivery : $currentCurrency . ' '.number_format($delivery,2) }}</td></tr>
                                    <tr class='price' price={{$product['pro']->del_sabah_labuan/100}}><th>Sabah/Labuan</th><td>{{ $product['pro']->del_sabah_labuan ? $currentCurrency . ' '.number_format($product['pro']->del_sabah_labuan/100,2) : "0.0" }}</td></tr>
                                    <tr class='price' price={{ $product['pro']->del_sarawak /100}}><th>Sarawak</th><td>{{ $product['pro']->del_sarawak ? $currentCurrency . ' '.number_format($product['pro']->del_sarawak/100,2) : "0.0" }}</td></tr>
                                </table>								
                            </div>	

                            <div class="clearfix"></div>
                            <hr>                       

                            <div id="product">
                                <div class="col-xs-12">
                                    <h1> Product Details</h1>
                                </div>
                                <div class="col-xs-12" style="min-height: 20px;">
                                    {{ $product['pro']->product_details ? strip_tags($product['pro']->product_details) : "-" }}
                                    <!--                                <h4 class="text-info"><a> Health, Safety & Environment</a></h4>
                                    <p> Health & Safety </p>
                                                                                            <img src="images/ProductpageConsumer.png" title="banner" class="img-responsive banner">
                                                                                            <p>A merchant consultant helps merchants to get on board our system as quickly as possible, from the aspect of products registration all the way to pricing. Our Knowledgeable merchant consultants will provide friendly and dependable service each step of the way. </p>
                                                                                            <p>A merchant consultant helps merchants to get on board our system as quickly as possible, from the aspect of products registration all the way to pricing. Our Knowledgeable merchant consultants will provide friendly and dependable service each step of the way. </p>-->

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr>

                            @if(isset($product['merchant'][0]))	
                            <div id="seller">
                                <div class="col-xs-12">
                                    <h1>Seller Information</h1>
                                </div>

                                <div class="col-sm-6 col-sm-offset-1 col-xs-12 table-responsive">
                                    <table class="table pseller">
                                        <tr><td>Seller Name</td><td>{{ $product['merchant'][0]->company_name }}</td></tr>
                                        <tr><td>Ship form Address</td><td>
                                                {{ $product['merchant'][0]->address ?
											strip_tags($product['merchant'][0]->address->line_1.'<br>'.
											$product['merchant'][0]->address->line_2.'<br>'.
											$product['merchant'][0]->address->line_3.'<br>'.
											$product['merchant'][0]->address->line_4.'<br>'.
											$product['merchant'][0]->address->city_id.' '.$product['merchant'][0]->address->postcode)  
										:
											"-"  
                                                }}
                                            </td></tr>
                                        <tr><td>Return / Exchange Address:</td><td>
                                                {{ $product['merchant'][0]->address ?
											strip_tags($product['merchant'][0]->address->line_1.'<br>'.
											$product['merchant'][0]->address->line_2.'<br>'.
											$product['merchant'][0]->address->line_3.'<br>'.
											$product['merchant'][0]->address->line_4.'<br>'.
											$product['merchant'][0]->address->city_id.' '.$product['merchant'][0]->address->postcode)  
										:
											"-"  
                                                }}
                                            </td></tr>
                                    </table>
                                </div>

                            </div>
                            @endif	
                            <div class="clearfix"></div>
                            <hr>							
                            <div id="pspecification">
                                <div class="col-xs-12">
                                    <h1>Specifications</h1>
                                    <div class="col-xs-12 col-sm-offset-1">
                                        <div class="form-group">
                                            @foreach($product['specifications'] as $specs)
                                            <label for="product_specification_2" class="col-sm-3 control-label">{{$specs['description']}}</label>
                                            <div class="col-sm-4">
                                                <p>{{$specs['value']}}</p>
                                            </div>
                                            <div class="clearfix"></div>
                                            @endforeach									
                                        </div>
                                    </div>								
                                </div>

                            </div>
                            <div class="clearfix"></div>
                            <hr>	
                            <div class="col-xs-12" id="myreturn"><h1>Cancellation, Return & Exchange</h1>	</div>
                            @if(isset($product['merchant'][0]))		
                            <div id="policy">
                                <div class="col-xs-12">
                                    <h2>Seller Policy</h2>
                                    <p class="thumbnail">{{ $product['merchant'] ? strip_tags($product['merchant'][0]->return_policy) : "" }}</p>
                                </div>
                            </div>
                            @endif	
                            <div id="return">
                                <div class="col-xs-12">
                                    <h2>OpenSupermall Policy</h2>
                                    <div class="thumbnail">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3 class="page-header" style="margin-top:20px">Cancellation</h3>
                                                <ol>
                                                    <li>Request for cancellation can be made after payment for the product is completed.</li>
                                                    <li>Request for cancellation will only be approved if the product has not been shipped by the Merchant and the Buyer shall be entitled to refund</li>
                                                    <li>Request for cancellation will be rejected in the event that the Merchant has shipped the product.</li>
                                                </ol>

                                            </div>
                                            <div class="col-sm-12">
                                                <h3 class="page-header" style="margin-top:20px">Return &amp; Exchange</h3>
                                                <ol>
                                                    <li>Request for return of the product purchased can be upon the product is delivered.</li>
                                                    <li>In the event that the product delivered is flawed, the Buyer shall return the product to the Merchant at the Buyer's own cost.</li>
                                                    <li>Upon receiving the Merchant's confirmation on the approvalfor the request for return, payment shall than be refunded to the Buyer.</li>
                                                    <li>In the event that wrong product is delivered, the Buyer may return the wrong product to Merchant at the Buyer's own cost and upon receiving the Merchant's confirmation and approval for the request, a new product shall be re-dilivered to the Buyer.</li>
                                                </ol>

                                            </div>
                                            <div class="col-sm-12">
                                                <h3 class="page-header" style="margin-top:20px">Terms &amp; Conditions</h3>

                                                <ol>
                                                    <li>Request for return and/or refund shall be made within 7 days from the date of the delivery of the product</li>
                                                    <li>The Buyer shall not be entitled to refund and/or exchange if:
                                                        <ol type="a">
                                                            <li>The product requested for refund and/or exchange is used, destroyed and/or damaged.</li>
                                                            <li>The tag attached to the product is removed and/or tempered with.</li>
                                                            <li>The seal and/or package of the product is removed and/or opened.</li>
                                                            <li>The material(s) of the package product is lost.</li>
                                                            <li>The components of the product including product's accessory and/or free gifts which comes with the products have been  used, destroyed, damaged and/or lost.</li>
                                                            <li>The product value is decreased and/or damaged due to, including but not limited to, any reason stated in (a) to (c) stated above and/or due to the delay by the Buyer in returning the product.</li>
                                                            <li>The product is custom made and/or is customized product.</li>
                                                            <li>The proof of purchase of product is not provided by the Buyer.</li>
                                                            <li>The Buyer failed to follow guidelines, manuals, instructions and/or recommendations provided by the products and/or the Vendor Merchant. </li>
                                                            <li>The product is of e-voucher type of product which is sent to the Buyers email directly and immidiately. It is the buyer own responsibility to ensure the email address inserted and key is correct and accurate. OR</li>
                                                            <li>The product is of credit top-up type of product including but not limited to prepaid mobile air time, prepaid internet services, prepaid online content which is sent to Buyer's account direclty and immidiately. It is Buyer's own responsibility to ensure the account number(such as mobile telephone number, prepaid internet account number) inserted the key in is correct and accurate.</li>
                                                        </ol>
                                                    </li>
                                                    <li>All shipping cost and expenses paid are non-refundable and the Buyer shall bear for all the cost for the return and/or exchange of the product.</li>
                                                    <li>In the event of any refund and/or return is approved it is subject to deduction of shipping costs, taxes and/or any changes impossed by the online payment gateway and/or financial instructions.</li>
                                                </ol>

                                            </div>
                                            <div class="clearfix"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>


                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="b2b">
                <div class="row">
                    <div class="col-sm-12">
                        @if(isset($products))
                        {{-- Form::Open() --}}
                        <div id="pinformation">
                            <h1>Product Information</h1>
                            <div class="col-sm-4 thumbnail">
                                <div class="product-photo">
                                    <img class="img-responsive" alt="Missing" src="{{ asset('images/product') }}/{{ $products->id }}/{{ $products->image }}">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        <p id="name_p">{{ ucfirst($products->pname) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('brand_id', 'Brand', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        <p id="brand_p">{{ ucfirst($products->brand) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('category_id', 'Category', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        <p id="category_p">{{ ucfirst($products->category) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('subcat_id', 'Sub Category', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        <p id="subcat_p">{{ ucfirst($products->subcategory) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('O-Shop', 'O-Shop', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        <p id="oshop_p">{{ ucfirst($products->oshop) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('short_description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        <p id="description_p">
                                            {{ $products->description }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('available', 'Quantity Available', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        <p id="quantity_p">{{ $products->available }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-5 margin-top">
                                    <table class="table noborder">
                                        <tr>
                                            @def $amount = 0
                                            @def $delivery = $products->west_malaysia_price
                                            @if(isset($products->specialprice))
                                            @def $amount = $products->specialprice
                                            @else
                                            @def $amount = \App\Models\Wholesale::where('product_id', $products->id)->first()->price
                                            @endif
                                            <th>Amount</th>
                                            <td>{{ $currency }}</td>
                                            
                                            <td>{{ number_format($amount/100,2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Delivery</th>
                                            <td>{{ $currency }}</td>
                                            <td id='deliveryPrice'>{{ number_format($delivery/100,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><hr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>&nbsp</th>
                                            <td>{{ $currency }}</td>
                                            <td id='hidden-total-price' class='hidden'>
                                                {{ $amount + $delivery }}</td>
                                            <td id='total-price'>{{ number_format(($amount + $delivery)/100,2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-5 margin-top">
                                    <div class="col-sm-7 input-group">
                                        <span class="input-group-btn">
                                            <button type="button" class="up btn btn-info btn-number" data-type="plus" data-field="">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                        <input id='quantity' style="text-align: center; padding-left: 0px; padding-right: 0px;"
                                               type="text" name="" class="ni numberInput form-control"
                                               value="1">
                                        <span class="input-group-btn">
                                            <button type="button" class="down btn btn-info btn-number"  data-type="minus" data-field="">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </span>
                                    </div>       
                                    <br>
                                    <div class=" col-sm-1" style="margin-top:-8px;padding-left:0">
                                        <ul class="list-inline">
                                            <li class="btn btn-green btn-sm">
                                                {!! Form::hidden('quantity', 1) !!}
                                                {!! Form::hidden('id', $product['pro']->id) !!}
                                                
                                                {!! Form::hidden('price', $amount) !!}
                                                
                                                <button class='btn-link cartBtn' type='button' style='padding: 0px;font-size: 14px;color: rgb(255, 255, 255);'><i class="fa fa-lg fa-plus"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <hr>
                        <div id="wholesale">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h1>Business To Business</h1>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <h4>Retail Price</h4>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <h4>
                                                        <span class="text-left">{{ $currency }}</span>&nbsp;
                                                        <span class="text-right">{{ number_format($products->retailprice/100,2) }}</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <h4>Special Price</h4>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <h4>
                                                        <span class="text-left">{{ $currency }}</span>&nbsp;
                                                        <span id='specialPrice' class="text-right">
                                                            {{ number_format($products->specialprice/100,2) }}
                                                        </span>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-sm-offset-6">
                                                <div class="row">
                                                    @def $rp = $products->retailprice
                                                    @def $sp = $products->specialprice
                                                    @if(($rp > 0) && $rp > $sp)
                                                    @def $margin = (($rp - $sp)/$rp) * 100
                                                    @else
                                                    @def $margin = 0
                                                    @endif
                                                    <h4>
                                                        <span class="text-left">Margin</span>&nbsp;
                                                        <span class="text-right">{{ round($margin) }} %</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <h3>Delivery Coverage</h3>
                                    </div>
                                    @if(isset($coverage))
                                    @def $cov_country = $coverage->delivery_country
                                    @def $cov_city = $coverage->delivery_city
                                    @def $cov_state = $coverage->delivery_state
                                    @def $cov_area = $coverage->delivery_area
                                    @else
                                    @def $cov_country = null
                                    @def $cov_city = null                               
                                    @def $cov_state = null                                
                                    @def $cov_area = null                           
                                    @endif
                                    <div class="row margin-top">
                                        <div class="col-sm-3">
                                            {!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
                                        </div>
                                        <div class="col-sm-9" >
                                            <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
                                                <option value="150">{{ $cov_country }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row margin-top">
                                        <div class="col-sm-3">
                                            {!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
                                        </div>
                                        <div class="col-sm-9">
                                            <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="states" name="cov_state_id" data-style="btn-green" disabled>
                                                <option value="2">{{ $cov_state }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row margin-top">
                                        <div class="col-sm-3">
                                            {!! Form::label('cov_city_id', 'City', array('class' => 'control-label')) !!}
                                        </div>
                                        <div class="col-sm-9">
                                            <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="cities" name="cov_city_id" data-style="btn-green" disabled>
                                                <option value="2">{{ $cov_city }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row margin-top">
                                        <div class="col-sm-3">
                                            {!! Form::label('cov_area_id', 'Area', array('class' => 'control-label')) !!}
                                        </div>
                                        <div class="col-sm-9">
                                            <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="cities" name="cov_city_id" data-style="btn-green" disabled>
                                                <option value="2">{{ $cov_area }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-sm-12">
                                        <h3>Delivery Pricing</h3>
                                    </div>  
                                    <div class="toggleDelivery">
                                        <div class="row margin-top">
                                            <div class="col-sm-4">
                                                {!! Form::label('del_worldwide', 'World Wide', array('class' => 'control-label')) !!}
                                            </div>
                                            <div class="col-sm-8">
                                                {!! Form::text('del_worldwide', $products->worldwide_price, array('class' => 'validator1 form-control','id' => 'del_world_v', 'disabled'))!!}
                                            </div>
                                        </div>
                                        <div class="row margin-top">
                                            <div class="col-sm-4">
                                                {!! Form::label('del_west_malaysia', 'West Malaysia', array('class' => 'control-label')) !!}
                                            </div>
                                            <div class="col-sm-8">
                                                {!! Form::text('del_west_malaysia', $products->west_malaysia_price, array('class' => 'validator1 form-control','id' => 'del_malaysia_v', 'disabled'))!!}
                                            </div>
                                        </div>
                                        <div class="row margin-top">
                                            <div class="col-sm-4">
                                                {!! Form::label('del_sabah_labuan', 'Sabah/Labuan', array('class' => 'control-label')) !!}
                                            </div>
                                            <div class="col-sm-8">
                                                {!! Form::text('del_sabah_labuan', $products->sabah_labuan_price, array('class' => 'validator1 form-control','id' => 'del_sabah_v', 'disabled'))!!}
                                            </div>
                                        </div>
                                        <div class="row margin-top">
                                            <div class="col-sm-4">
                                                {!! Form::label('del_sarawak', 'Sarawak', array('class' => 'control-label')) !!}
                                            </div>
                                            <div class="col-sm-8">
                                                {!! Form::text('del_sarawak', $products->sarawak_price, array('class' => 'validator1 form-control','id' => 'del_sarawak_v', 'disabled'))!!}
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="" class="">Free Delivery</label>
                                            </div>
                                            <div class="col-sm-6">
                                                @if($products->free == 1)
                                                {{ $currency }} &nbsp; {{ $products->free }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-8" style="padding-top:6px">
                                                <label for="" class="">Free Delivery with Purchase quantity of</label>
                                            </div>
                                            <div class="col-sm-4">
                                                {!! Form::text('free_delivery_with_purchase_qty', $products->free_qty, array('class' => 'form-control', 'disabled' => 'disabled','id'=>'freeQty'))!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if (!isset($products->specialprice) && empty($products->specialprice))
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <h4>Wholesale Price</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        @def $wholesales = \App\Models\Wholesale::where('product_id', $products->id)->get()
                                        @if(isset($wholesales))
                                        <div class="row">
                                            <div class="table-responsive" style="border:0px">
                                                <table class="priceTable table">
                                                    <thead>
                                                        <tr>
                                                            <th>Tier</th>
                                                            <th>Price/Unit</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($wholesales as $wholesale)
                                                        {{-- start: all data for calculation --}}
                                                    <p  class=' price-info'
                                                        from-unit='{{ $wholesale->funit }}'
                                                        to-unit='{{ $wholesale->unit }}'
                                                        price='{{ $wholesale->price }}'>
                                                    </p>
                                                    {{-- end --}}
                                                    <tr>
                                                        <td class='text-left col-sm-2'>
                                                            <span> {{ $wholesale->funit }} </span> -
                                                            <span> {{ $wholesale->unit }} </span>
                                                        </td>
                                                        <td class='text-left col-sm-2'>
                                                            <span class="text-left"> {{ $currency }} </span>
                                                            <span class="text-right"> {{ number_format($wholesale->price/100,2) }} </span>
                                                        </td>
                                                        <td class='col-sm-2'>
                                                            @def $rp = $products->retailprice
                                                            @def $wp = $wholesale->price
                                                            @if(($rp > 0) && $rp > $wp)
                                                            @def $margin = (($rp - $wp)/$rp) * 100
                                                            @else
                                                            @def $margin = 0
                                                            @endif
                                                            <h4>
                                                                <span class="text-left">Margin</span>&nbsp;
                                                                <span class="text-right">{{ round($margin) }} %</span>
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div id="seller">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>Seller Information</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 row">
                                    <div class="row margin-top">
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">Seller Name</label>
                                        </div>
                                        <div class="col-sm-7">
                                            {{ $products->sellername }}
                                        </div>
                                    </div>
                                    <div class="row margin-top">
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">Ship From Address</label>
                                        </div>
                                        <div class="col-sm-7">
                                            {{ $products->shipping_address }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">&nbsp;</div>
                                        <div class="col-sm-7">
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4" >
                                                    <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
                                                        <option value="150">{{ $products->sellercountry }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="states" name="cov_state_id" data-style="btn-green" disabled>
                                                        <option value="2">{{ $products->sellerstate }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_city_id', 'City', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="cities" name="cov_city_id" data-style="btn-green" disabled>
                                                        <option value="2">{{ $products->sellercity }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" disabled class="form-control" value="{{ $products->sellerarea }}">
                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('postcode', 'Postcode', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" value="{{ $products->sellerpostcode }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Return And Exchange --}}
                                    <div class="row margin-top">
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">Return & Exchange Address</label>
                                        </div>
                                        <div class="col-sm-7">
                                            {{ $products->return_address }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">&nbsp;</div>
                                        <div class="col-sm-7">
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_country_id', 'Country', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4" >
                                                    <select class="selectpicker show-menu-arrow" style="width: 100%;" data-style="btn-green" name="cov_country_id" id="country_id" disabled>
                                                        <option value="150">{{ $products->sellercountry }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_state_id', 'State', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="states" name="cov_state_id" data-style="btn-green" disabled>
                                                        <option value="2">{{ $products->sellerstate }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('cov_city_id', 'City', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <select style="width: 100%;" class="form-control selectpicker show-menu-arrow" id="cities" name="cov_city_id" data-style="btn-green" disabled>
                                                        <option value="2">{{ $products->sellercity }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::label('area', 'Area', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" disabled class="form-control" value="{{ $products->sellerarea }}">
                                                </div>
                                            </div>

                                            <div class="row margin-top">
                                                <div class="col-sm-2">
                                                    {!! Form::label('postcode', 'Postcode', array('class' => 'control-label')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" value="{{ $products->sellerpostcode }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>    

                        <div id="pspecification" class="row">
                            <div class="col-xs-12">
                                <h1>Product Specification</h1>
                            </div>
                            <div class="col-xs-12 margin-top">
                                @if(isset($specsb2b))
                                @foreach($specsb2b as $specb2b)
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="" class="control-label">{{ $specb2b->spec }}</label>
                                    </div>
                                    <div class="col-sm-7">
                                        {{ $specb2b->value }}
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @else
                        <h3>No Description Found For The Product</h3>
                        <br>
                        @endif	
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="voucher">
                <div class="col-sm-12" style="margin-bottom:20px">
                    <div class="row">
                        <h2 style="margin-left:9px">Voucher</h2>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="hyper">
                <div class="col-sm-12" style="margin-bottom:20px">
                    <div class="row">
                        <h2 style="margin-left:9px">Hyper</h2>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="smm">
                <div class="col-sm-12" style="margin-bottom:20px">
                    <div class="row">
                        <h2 style="margin-left:9px">SMM</h2>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="oem">
                <div class="col-sm-12" style="margin-bottom:20px">
                    <div class="row">
                        <h2 style="margin-left:9px">OEM/ODM</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@stop
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {

        var pathname = window.location.pathname;
        var arrpath = pathname.split("/");
        if (arrpath[1] == "productconsumer") {
            $("#retaila").addClass("active");
            $("#retail").addClass("active");
        } else if (arrpath[1] == "productb2b") {
            $("#b2ba").addClass("active");
            $("#b2b").addClass("active");
        }

        $('#blast').click(function () {
            // alert(product_id);
            var product_id = "{{$product['pro']->id}}";
            $.ajax({
                url: JS_BASE_URL + '/smedia/marketer',
                type: 'GET',
                data: {product_id: product_id},
                success: function (response) {
                    if (response == -1) {
                        var newresponse = "You have not registered for SMM services. <br>Would you like to register now? <br><button type='button' id='smmyes' class='btn btn-success'>Yes</button>";
                        toastr.warning(newresponse);

                        $('#smmyes').click(function () {
                            // alert("Yeyy you clocled");
                            newwindow = window.open("{{URL::route('fbtoken')}}", 'Link Token', 'height=400,width=auto');
                            if (window.focus) {
                                newwindow.focus()
                            }
                            return false;
                        });

                    }
                    else {
                        toastr.info(response);
                    }
                    ;

                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-number").click(function () {
            qty = $('.quantity').val();
            fre_qty = $('#free_delivery_with_purchase_qty').val();
            del_price = $('#mydelprice').val();
            fre_qty = parseInt(fre_qty);
            retail_price = parseFloat($('.retail_price').attr('rprice'));
            amount = parseFloat(retail_price * qty).toFixed(2);
            $('.amt').html(accounting.formatMoney(amount, ""));
            if (fre_qty == 0) {
                price = $('.del_price').html();
            } else {
                if (qty < fre_qty) {
                    $('.del_price').html(del_price);
                    price = $('.del_price').html();
                } else {
                    price = "0.0";
                    $('.del_price').html("0.00");
                }
            }
            total = (parseFloat(amount) + parseFloat(price)).toFixed(2);
            $('.total').html(accounting.formatMoney(total, ""));
            // available = parseInt($('.available').attr('avail'));
            // available = available - qty;
            // $('.available').html(available);
        });

        $(".price").on('click', function () {
            amount = ($('.amt').text());
            amount = (accounting.unformat(amount));
            $('.price').removeClass("active");
            $(this).addClass('active');
            price = ($(this).attr('price'));
            price = accounting.unformat(price);
            total = (parseFloat(amount) + parseFloat(price));
            $('.del_price').html(accounting.formatMoney(price, ""));
            $('.total').html(accounting.formatMoney(total, ""));
        });

        /*	$( ".price" ).hover(function() {
         amount = parseFloat($('.amt').text()).toFixed(2);
         $('.addactive').removeClass("active");
         $(this).addClass('active');
         price = parseFloat($(this).attr('price')).toFixed(2);
         total = (parseFloat(amount) + parseFloat(price)).toFixed(2);
         $('.del_price').html(price);
         $('.total').html(total);
         },
         function () {
         $(this).removeClass("active");
         $('.addactive').addClass('active');
         price = parseFloat($('.addactive').attr('price')).toFixed(2);
         total = (parseFloat(amount) + parseFloat(price)).toFixed(2);
         $('.del_price').html(price);
         $('.total').html(total);
         }); */


        currency = $('#currency option:selected').text();
        $('.showCurrency').text(currency);

        $('#currency').on('change', function () {
            currency = $('#currency option:selected').text();
            $('.showCurrency').text(currency);
        })

        function number_format(number, decimals, dec_point, thousands_sep)
        {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + (Math.round(n * k) / k).toFixed(prec);
                    };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '')
                    .length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
        path = window.location.href;
        var url;
        if (path.includes('public'))
        {
            url = '/openSupermall/public/cart/addtocart';
        }
        else {
            url = '/cart/addtocart';
        }
        $('.cartBtn').click(function (e) {
            e.preventDefault();
            var price = $(this).siblings('input[name=price]').val();
            alert(price);
            $.ajax({
                url: url,
                type: "post",
                data: {
                    'quantity': $(this).siblings('input[name=quantity]').val(),
                    'id': $(this).siblings('input[name=id]').val(),
                    'price': price,
                    'page': 'productconsumerdisc'
                },
                success: function (data) {
                    $('#retail_add_to_cart').css('background-color', 'rgb(39,169,138)');
                    $('#retail_add_to_cart').css('cursor', 'default');
                    $('.cartBtnDisc').css('cursor', 'default');
                    $('.cartBtnDisc').attr('disabled', false);
                    $('#discountLimitNotification').hide();
                    $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
                    $('.cart-info').text(data[1] + ' ' + currency+
						number_format(price / 100, 2) +
						" Successfully added to the cart");

                    if (data[0] < 1) {
                        $('.cart-link').text('Cart is empty');
                        $('.badge').text('0');
                    } else {
                        $('.cart-link').text('View Cart');
                        $('.badge').text(data[0]);
                    }
                }
            });
        });
        $('.cartBtnDisc').click(function (e) {
            e.preventDefault();
            var price = $(this).siblings('input[name=price]').val();
            $.ajax({
                url: url,
                type: "post",
                data: {
                    'quantity': $(this).siblings('input[name=quantity]').val(),
                    'id': $(this).siblings('input[name=id]').val(),
                    'price': price,
                    'page': 'productconsumerdisc'
                },
                success: function (data) {
                  /*  $('#retail_add_to_cart').css('background-color', 'grey');
                    $('#retail_add_to_cart').css('cursor', 'no-drop');
                    $('.cartBtnDisc').css('cursor', 'no-drop');
                    $('.cartBtnDisc').attr('disabled', true);
                    $('#discountLimitNotification').show();
                    $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);*/

                    $('.cart-info').text(data[1] + ' ' + currency+
						number_format(price / 100, 2) +
						" Successfully added to the cart");

                    if (data[0] < 1) {
                        $('.cart-link').text('Cart is empty');
                        $('.badge').text('0');
                    } else {
                        $('.cart-link').text('View Cart');
                        $('.badge').text(data[0]);
                    }
                }
            });
        });

    });
    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    }
    ;
</script>

@if(!empty($discount_detail) && $discount_detail['item_in_cart']==true)

<script type="text/javascript">
  /*  $('.cartBtnDisc').attr('disabled', true);
    $('#retail_add_to_cart').css('background-color', 'grey');
    $('#retail_add_to_cart').css('cursor', 'no-drop');
    $('.cartBtnDisc').css('cursor', 'no-drop');
    $('#discountLimitNotification').show();*/
</script>
@endif

@if(isset($_GET['tab']))

<script type="text/javascript">
    tagID = "{{$_GET['tab']}}";
    activaTab(tagID);
</script>
@endif
@stop
