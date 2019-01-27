@extends("common.default")

@section('extra-links')
    <style>
        table.priceTable thead tr th, table.priceTable tbody tr td {
            padding-right: 0px;
            padding-left: 0px;
            font-size: 16px;
            border: none;
        }

        table.priceTable tbody tr td h4 {
            margin-top: 0px;
        }
    </style>
@stop
@def $currency = \App\Models\Currency::where('active', 1)->first()->code
@section("content")

    <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong class='cart-info'></strong>
    </div>

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
                                        <h4>B2B Price</h4>
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
                                @if(isset($specs))
                                @foreach($specs as $spec)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">{{ $spec->spec }}</label>
                                        </div>
                                        <div class="col-sm-7">
                                            {{ $spec->value }}
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                        <h2>No Description Found For The Product</h2>
                    @endif
                </div>
                <br><br><br>
            </div>
        </div><!--End main cotainer-->
    </section>
@stop
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    var currency = "{{ $currency }}";

    $('.ni').on('change', function(){
        val = parseInt($('.numberInput').val());
        setFreeQuantity(val);
        if(val){
            setPriceOnQtyChange(val);
        }else{
            $('.numberInput').val(1);
        }
    })

    $('.up').click(function(){
        val = parseInt($('.numberInput').val())+1;
        setPriceOnQtyChange(val);
        setFreeQuantity(val);
    })

    $('.down').click(function(){
        val = parseInt($('.numberInput').val())-1;
        if( val == 1){
            $('.numberInput').val(1);
            sp = "{{ isset($products->specialprice) ? $products->specialprice : 0 }}";
            wp = parseInt($('.price-info').first().attr('price'));
            setFreeQuantity(val);
            if (sp > 0 && sp != null && sp < wp) {
                $('#total-price').text(formatPrice(sp));
            } else {
                $('#total-price').text(formatPrice(wp));
            }
        } else {
            setPriceOnQtyChange(val);
            setFreeQuantity(val);
        }
    })

    function setFreeQuantity(val) {
        free_qty = parseInt($('#freeQty').val()); 
        if (free_qty < val) {
            $('#freeQty').val(0);
        } else {
            $('#freeQty').val('{{ isset($products->free_qty) ? $products->free_qty : 0 }}')
        }
    }

    function setPriceOnQtyChange(val){
        var MIN_UNIT = 1; // lowest value of unit available
        var MAX_UNIT = getMaxUnit(); // highest value of unit available
        if(val != null && val >= MIN_UNIT && val <= MAX_UNIT)
        {
            setPrice(val);
        }
        else if(val < MIN_UNIT){
            setMinPrice();
        }
        else if (val > MAX_UNIT) {
            setMaxPrice();
        }
    }

    function setMinPrice(){
        qty = 1
        $('.numberInput').val(qty);
        price = $('.price-info').first().attr('price');
        if(price != 0){
            showPrice = formatPrice(price);
            $('#total-price').text(showPrice);
        }
    }

    function setMaxPrice(){
        qty = $('.price-info').last().attr('to-unit');
        price = $('.price-info').last().attr('price');
        $('.numberInput').val(qty);
        if(price != 0){
            totalPrice = calculateTotalPrice(price, qty);
            $('#hidden-total-price').text(totalPrice);
            $('#total-price').text(formatPrice(totalPrice));
        }
    }

    function setPrice(qty){
        $('.numberInput').val(qty);
        price = getPrice(qty);
        if(price != 0){
            totalPrice = calculateTotalPrice(price, qty);
            $('#hidden-total-price').text(totalPrice);
            $('#total-price').text(formatPrice(totalPrice));
        }
    }


    function getMaxUnit(){
        maxUnit = $('.price-info').last().attr('to-unit');
        return maxUnit;
    }

    function getPrice(qty){
        var price;
        $('.price-info').each(function(){
            var maxUnit = $(this).attr('to-unit');
            var minUnit = $(this).attr('from-unit');
            var wholesaleprice = $(this).attr('price');
            if( minUnit <= qty && qty <= maxUnit){
                price = wholesaleprice;
                return false;
            }else{
                return true;
            }
        })
        return price;
    }

    function formatPrice(price){
        price = number_format((price/100),2);
        return price;
    }

    function calculateTotalPrice(price, qty){
        tp = (price * qty) + parseInt("{{ isset($products->west_malaysia_price) ? $products->west_malaysia_price : 0 }}");
        return tp;
    }

    $('.wprice:first').addClass('active');
    $( ".btn-number" ).click(function() {
        qty = $('.quantity').val();
        retail_price = parseFloat($('.retail_price').attr('rprice'));
        amount = parseFloat(retail_price * qty).toFixed(2);
        $('.amt').html(accounting.formatMoney(amount,""));
            price = $('.del_price').html();
            total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
            $('.total').html(accounting.formatMoney(total,""));
            available = parseInt($('.available').attr('avail'));
            available = available - qty;
            $('.available').html(available);
        });
        
        $( ".spc_btn" ).click(function() {
        qty = $('.spc_quantity').val();
        mvr = parseFloat($('.smvr').html());
        amount = parseFloat(mvr * qty).toFixed(2);
        $('.amt').html(accounting.formatMoney(amount,""));
            price = $('.del_price').html();
            total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
            $('.del_price').html(accounting.formatMoney(price,""));
            $('.total').html(accounting.formatMoney(total,""));
        });
        
        $( ".who_btn" ).click(function() {
        qty = $('.who_quantity').val();
        mvr = parseFloat($('.wmvr').html());
        amount = parseFloat(mvr * qty).toFixed(2);
        $('.amt').html(accounting.formatMoney(amount,""));
            price = $('.del_price').html();
            total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
            $('.del_price').html(accounting.formatMoney(price,""));
            $('.total').html(accounting.formatMoney(total,""));
        });
        
        $('.fprice').click(function(){
        $('.fprice').removeClass('retail');
        $(this).addClass('retail');
        });
        
        $('.wprice').click(function(){
                var ele = $(this);
                $('.wprice').removeClass('active');
                $(this).addClass('active');
                var unit = parseFloat($(this).find('.wprice-unit').html());
                var price = parseFloat($(this).find('.wprice-mvr').attr('wprice_mvr'));
                var final_wprice = !isNaN(price/unit) ? (price/unit).toFixed(2) : 0;
                $('.wmvr').html(accounting.formatMoney(final_wprice,""));
                if(original_price != 0){
                var save_wholesale = (((original_price - final_wprice)/original_price)*100).toFixed(2);
                $('.save_wholesale').html(save_wholesale > 0 ? 'Save ' + save_wholesale + '%' : "");
                }
        });
        
        $('.sprice').click(function(){
                var ele = $(this);
                $('.sprice').removeClass('active');
                $(this).addClass('active');
                var unit = parseFloat($(this).find('.sprice-unit').html());
                var price = parseFloat($(this).find('.sprice-mvr').attr('sprice_mvr'));
                var final_wprice = !isNaN(price/unit) ? (price/unit).toFixed(2) : 0;
                $('.smvr').html(accounting.formatMoney(final_wprice,""));
                if(original_price != 0){
                var save_special = (((original_price - final_wprice)/original_price)*100).toFixed(2);
                $('.save_special').html(save_special >0 ? 'Save '+ save_special + '%' : "");
                }
        });
        
        $( ".price" ).on('click',function() {
            amount = ($('.amt').text());
            amount = (accounting.unformat(amount));
           $('.price').removeClass("active");
            $(this).addClass('active');
            price = ($(this).attr('price'));
            price = accounting.unformat(price);
            total = (parseFloat(amount) + parseFloat(price));
            $('.del_price').html(accounting.formatMoney(price,""));
            $('.total').html(accounting.formatMoney(total,""));
        });

        $('.showCurrency').text(currency);

        function number_format(number, decimals, dec_point, thousands_sep) 
        {
              number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
              var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
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
       // if(path.contains('public'))
       // {
       //      url = '/OpenSupermall/public/cart/addtocart';
       // }
       // else {
       //      url = '/cart/addtocart';
       // }

	$('.cartBtn').click(function(e){
		e.preventDefault();
		url="{{url()}}"+"/cart/addtocart";
        var id = "{{ isset($products->id) ? $products->id : null }}";
        var quantity = $('.numberInput').val();
        var totalPrice = parseInt($('#total-price').text());
        var actualTotalPrice = parseInt($('#hidden-total-price').text());
        var price = (actualTotalPrice/quantity);

        $.ajax({
			url: url,
			type: "post",
			data: {
				'quantity': quantity,
				'id': id,
				'price': price
			},
			success: function(data){
				$('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
				$('.cart-info').text(data[1]+' ' + currency + 
					number_format(totalPrice,2)+
					" Successfully added to the cart");

				if(data[0] < 1) {
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
</script>
@stop
