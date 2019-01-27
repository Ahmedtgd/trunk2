@extends("common.default")
@section("content")
<style type="text/css">
    .owarehouse-box{
        width: 100% !important;
    }
</style>
<script>
</script>
<div class="container">
    <!--Begin main cotainer-->
    <!--    <div class="col-sm-12 text-right margin-top box-green">
           <label class="margin-top">Sort By: &nbsp;</label>
           <select data-live-search="true" data-style="btn-green" class="selectpicker pull-right bs-select-hidden">
               <option> Price Low to High</option>
               <option> Price High to Low</option>
               <option> Relevance</option>
               <option> Discount</option>
           </select>
       </div>
    -->
    <div class="col-sm-12">
        <p>&nbsp;</p>
        <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong class='cart-info'></strong>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h1>Hyper <small class="pull-right">{{count($ow_product)}} results</small></h1>
            </div>
        </div>

        <div id="bueaty">  
            <div class="brandlist">
                <h3>{{!empty($cat_name) ? $cat_name->description : ""}}</h3>
                <div class="row">
                    <div class="panel-body no-padding-top no-padding-bottom shadow-e5">
                       <?php if(!empty($ow_product)){
                         $i = 1; ?> 
                        @foreach($ow_product as $product)
                        <div class="col-sm-6" style="margin-bottom: 30px;">
                            <div class="border-box owarehouse-box">
                                <div class="row no-margin1">
                                    <div class="boxrow4-l col-sm-5 no-padding floor-border">
                                        <a href="javascript::void(0)">
                                            <!-- <img class="img-responsive boxrow2-l" alt="Missing" src="{{asset('/')}}images/img12.jpg"> -->
                                            <img src="{{asset('/')}}images/product/{{$product->id}}/{{$product->photo_1}}" title="product-image" class="img-responsive boxrow2-l">
                                        </a>                                            
                                    </div>
                                    <div class="user_box">
                                    <?php
                                    $qty = explode(',', $product['pledged_qty']);
                                    $v = 0;
                                    ?>
                                    @if (array_filter($qty))
                                    @foreach($qty as $key => $value)
                                    <div class="col-sm-2">
                                        <span class="user_icon fa fa-male"></span>
                                        <br/><i class="item_number">{{$value}}</i>
                                    </div>
                                    <?php
                                    $v = $v + $value;
                                    ?>
                                    @endforeach
                                    @endif
                                     <?php
                                      $left_pledge = ($product->owarehouse_moq - $v) > 0 ? ($product->owarehouse_moq - $v) : 0; 
                                    if($left_pledge) { ?>
                                     <div class="col-sm-2 pledge-icon order_none" style="display:none">
                                        <span class="user_icon fa fa-male"></span>
                                        <br/><i class="item_number pledge-icon-qty">1</i>
                                    </div>
                                    <?php } ?>
                                      <div class="clearfix"></div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <?php
                                $price = ($product->owarehouse_price / 100);
                                $op = $product['original_price'] / 100;
                                $save = $op > 0 ? sprintf('%.2f', ((($op - $product->owarehouse_price) / $op) * 100)) : 0;
                                ?>

                                <div class="row no-margin1">
                                    <div class="col-sm-5 no-padding boxrow4-l">

                                        <p>{{$product['name']}}(1 {{$product->owarehouse_measure}} with {{$product->collection_units}} pieces)</p><b>RM {{number_format($price,2)}}</b>
                                        <p class="dicsount"> {{ $save>0 ? 'SAVE '.$save.'%' : ''}}</p>
                                        <h2>Original Price <span class=" pull-right">RM {{number_format($product['original_price']/100,2)}}</span></h2>
                                    </div>
                                    <div class="col-sm-6 moq_left" style="padding-left: 0px; padding-right: 0px; margin-left: 15px; width: 260px;">
                                        
                                        <h4 class="col-sm-12 no-padding">
                                        <span class="col-sm-3 pull-left">MOQ</span>
                                        <span class="col-sm-3 text-center"><b class="moq">{{$product->owarehouse_moq}}</b></span>
                                        <span class="col-sm-6"> RM {{number_format($price * $product->owarehouse_moq,2)}}</span>
                                        </h4>
                                        <?php
                                         $left = ($product->owarehouse_moq - $v) > 0 ? ($product->owarehouse_moq - $v) : 0; 
                                         // $left == 0  ? $v : $v = $v + 1 ; 
                                        ?>
                                        <h4 class="col-sm-12 no-padding">
                                        <span class="col-sm-3 pull-left">Bought</span>
                                        <span class="col-sm-3 text-center"><b class="pledge" st-pledge={{$v}}>{{$v}}</b></span>
                                        <span class="col-sm-6 pledge-price"> RM {{number_format($v * $price,2)}}</span>
                                        </h4>
                                         <?php  
                                         // $left = $left != 0 ? $left - 1 : 0;
                                        ?>   
                                           <h4 class="col-sm-12 no-padding">
                                        <span class="col-sm-3 pull-left">Left</span>
                                        <span class="col-sm-3 text-center"><b class="left" st-left={{$left}}>{{$left}}</b></span>
                                        <span class="col-sm-6 left-price"> RM {{number_format($left * $price,2)}}</span>
                                        </h4>

                                       <!--  <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>{{$product->owarehouse_moq}}</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RM {{$price * $product->owarehouse_moq}}</h2>
                                            <h4>Bought &nbsp;&nbsp;&nbsp;&nbsp;<b>{{$v}}</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RM {{$v * $price}}</h2>
                                                <?php $left = ($product->owarehouse_moq - $v) > 0 ? ($product->owarehouse_moq - $v) : 0; ?>
                                                <h4>Left &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>{{$left}}</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp; RM {{$left * $price}}</h2> -->
                                    </div>
                                        <div class="clearfix"></div>
                                </div>
                                    <div class="clearfix"></div>
                                <div class="row no-margin1">
                                    <?php
                                    $date = $product->odate;
                                    $date = strtotime($date);
                                    $current_date = strtotime(date('Y-m-d H:i:s'));
                                    $date1 = new DateTime('now');
                                    $date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $product->owarehouse_duration day", $date)));
                                    $dDiff = $date1->diff($date2);
                                    ?>
                                    <h4>Due Date &nbsp;&nbsp;&nbsp;&nbsp;{{ date('d F Y',strtotime("+ $product->owarehouse_duration day",$date))}}</h4>

                                    <h4>Time Left &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $dDiff->format("%r") == '-' ? '<p style="display:inline" class="text-danger">Expired!</p>' : ($dDiff->y >0 ? $dDiff->y ." year ":"").($dDiff->m >0 ? $dDiff->m ." months ":""). $dDiff->d ." days " . $dDiff->h ." hours and ". $dDiff->i ." minutes "; ?></h4>
                                    <div class="clearfix"></div>
                                </div>
                                    <div class="clearfix"></div>
                            <div class="place_order_height">
                                <?php 
                              
                                 if($product->owarehouse_moq - $v > 0) { 
                                      if($dDiff->format("%r") != '-'){?>
                                <div class="row no-margin1 order_none" style="display:none">
                                    <form role="form" class="owarehouseform">
                                        <div class="col-sm-9 place_order">
                                            <h4>Place Order</h4>
                                            <p>Quantity</p>
                                            <div class="form">
                                                <p style="display:none" class = "o_id">{{$product['owarehouse_id']}}</p>
                                                <p style="display:none" class="owarehouse_id">{{$product['id']}}</p>
                                                <p style="display:none" class="owarehouse_price">{{$price}}</p>
                                                <div class="price" style="display:none"><?php echo $price; ?></div> 
                                                <span class="fa fa-male"></span>
                                                <div class="quantity" data-id='-' min="<?php echo $left != 0.00 ? 1 : $left; ?>" max="<?php echo $left; ?>">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                </div>
                                                <input type="text" class="order_value"  name="quant[2]" value="<?php echo $left != 0 ? 1 : 0 ; ?>" min="<?php echo $left != 0 ? 1 : $left; ?>" max="<?php echo $left; ?>">
                                                <div class="quantity" data-id='+' min="<?php echo $left != 0.00 ? 1 : $left; ?>" max="<?php echo $left; ?>">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </div>
                                                <span class="rm-1">RM <span class="price ow-reset-price"><?php echo $left != 0.00 ? number_format($price,2) : 0; ?></span></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="javascript::void(0)" class="submitowerhouseorder btn a1">Confirm</a>
                                            <!-- <button type="submit" class="submitowerhouseorder"> Confirm</button> -->
                                            <button type="reset" class="resetowerhouseorder">Clear</button>
                                        </div>
                                    </form> 
                                        <div class="clearfix"></div>    
                                </div>
                                <?php } }else if($product->owarehouse_moq - $v < 0){ ?>
                                <div class="text-danger pledge_error">
                                Data inconsistent, Bought > MOQ. Please rectifiy or contact administrator
                                </div>
                               <?php } ?>
                            </div>
                                    <div class="clearfix"></div>
                            </div>
                                <div class="clearfix"></div>
                        </div>
                        <?php if ($i % 2 == 0) { ?>
                            <div class'clearfix' style="clear: both;"></div>
                        <?php
                        }
                        $i++;
                        ?>
                        @endforeach
                        <?php } else { ?>
                        <p>No Data Found</p>
                        <?php } ?>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <p>&nbsp;</p>
    <div class="custom-border"></div> 
<script>
$(document).ready(function(){

        $('.static-tab ul li a').on('click', function() {
            $('html,body').animate({scrollTop: $($(this).attr('href')).offset().top}, 1200);
        });
        
        $(".border-box").hover(
                function() {
                    $(this).addClass('order-border-box');
                    $(this).find('.order_none').show();
                }, function() {
            $(this).removeClass('order-border-box');
            $(this).find('.order_none').hide();
        });
 
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll > 100) {
            $('#ahr').show(1000);
        }
        if (scroll <= 100) {
            $('#ahr').hide(1000);
        }

    });

    $(document).off('click','.quantity').on('click','.quantity',function(e){

        var quenty = $(this).siblings('.order_value');
        var value = parseInt(quenty.val());
        var type = $(this).data('id');
        var price = parseFloat($(this).siblings('.price').html());
        var pledge = parseInt($(this).closest('.owarehouse-box').find('.pledge').html());
        var left = parseInt($(this).closest('.owarehouse-box').find('.left').html());
        var st_left = parseInt($(this).closest('.owarehouse-box').find('.left').attr('st-left'));
        var st_pledge = parseInt($(this).closest('.owarehouse-box').find('.pledge').attr('st-pledge'));
        var moq = parseInt($(this).closest('.owarehouse-box').find('.moq').html());
        var current_pledge =  parseInt($(this).closest('.owarehouse-box').find('.pledge-icon-qty').html());
        var qty = value;
        if (type == '+')
        {
            if(value < $(this).attr('max')){
                quenty.val(value + 1);
                qty = value + 1;
                if(parseInt(left) <= parseInt(moq)){
                pledge = st_pledge + qty;
                current_pledge = current_pledge + 1;
                }
                  if(parseInt(left) >= 1){
                 left = st_left - qty;
                }
            }
        }
    
        if(type == '-') {
            if (value > $(this).attr('min'))
            {
                quenty.val(value - 1);
                 qty = value - 1;
             if(parseInt(pledge) >= 1){
                 pledge = pledge -1;
                 current_pledge = current_pledge - 1 ;
             }
             if(parseInt(left) <= parseInt(moq))
                 left = left + 1;
            }
        }
        $(this).closest('.owarehouse-box').find('.pledge').html(pledge);
        $(this).closest('.owarehouse-box').find('.pledge-price').html('RM '+ number_format(pledge * price,2));
         $(this).closest('.owarehouse-box').find('.pledge-icon-qty').html(current_pledge);
        $(this).closest('.owarehouse-box').find('.left').html(left);
        $(this).closest('.owarehouse-box').find('.left-price').html('RM '+ number_format(left * price,2));
        $(this).siblings('.rm-1').html(qty ? 'RM ' + number_format((qty * price),2) : "0");
    });

      $(document).off('click', '.resetowerhouseorder').on('click', '.resetowerhouseorder', function(e) {
          var price = $(this).closest('.owarehouseform').find('.owarehouse_price').text();
          $(this).closest('.owarehouseform').find('.rm-1').html('RM ' + number_format(price,2));
                $(this).closest('.owarehouse-box').find('.pledge-icon-qty').html(1);

        var pledge = $(this).closest('.owarehouse-box').find('.pledge').attr('st-pledge');
        var left = $(this).closest('.owarehouse-box').find('.left').attr('st-left');
        $(this).closest('.owarehouse-box').find('.pledge').html(pledge);
        $(this).closest('.owarehouse-box').find('.pledge-price').html('RM '+ number_format(pledge * price,2));
        $(this).closest('.owarehouse-box').find('.left').html(left);
        $(this).closest('.owarehouse-box').find('.left-price').html('RM '+ number_format(left * price,2));
      });

    $(document).off('click', '.a1').on('click', '.a1', function(e) {
        e.preventDefault();

             

        console.log($(this).closest('.owarehouseform').find('.order_value').val());
        path = window.location.href;
        var url;
        if (path.includes('public')) {
            url = '/OpenSupermall/public/cart/addtocart';
        } else {
            url = '/cart/addtocart';
        }
        var id = $(this).closest('.owarehouseform').find('.owarehouse_id').text();
        var owarehouse_id = $(this).closest('.owarehouseform').find('.o_id').text();
        var price = $(this).closest('.owarehouseform').find('.owarehouse_price').text();
        var quantity = $(this).closest('.owarehouseform').find('.order_value').val();
        var page = 'owarehouse';
		if(quantity > 0){
			$.ajax({
				url: "{{ url('/owarehouse/store') }}",
				type: "post",
				data: {product_id: id, price: price, quantity: quantity,owarehouse_id:owarehouse_id},
				success: function(data) {
					console.log(data);
					if(quantity > 0){
						$.ajax({
							url: url,
							type: "post",
							data: {id: id, price: price, quantity: quantity, page: page},
							success: function(data) {
								console.log(data);
								$('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
								$('.cart-info').text(data[1] + ' {{$currentCurrency}}' +
								price * quantity + ' with quantity '+
								quantity + " Successfully added to the cart");

								if (data[0] < 1) {
									$('.cart-link').text('Cart is empty');
									$('.badge').text('0');
								} else {
									$('.cart-link').text('View Cart');
									$('.badge').text(data[0]);
								}
								window.location.reload();
							}
						});
					}
				}
			});
		}

    });

});
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
    </script>                                                                                                                                                                            
@stop
