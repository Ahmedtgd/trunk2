@extends("common.default")
@section("content")
<script>
    $(document).ready(function() {
        $('.static-tab ul li a').on('click', function() {
            $('html,body').animate({scrollTop: $($(this).attr('href')).offset().top}, 1200);
        });
        
        // $('.order_none').hide();
        $(".border-box").hover(
                function() {
                    $(this).addClass('order-border-box');
                    $(this).find('.order_none').show();
                }, function() {
            $(this).removeClass('order-border-box');
            $(this).find('.order_none').hide();
        }
        );
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
</script>
<div class="container"><!--Begin main cotainer-->
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
    <div class="col-sm-11 col-sm-offset-1">
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
                <h3>{{$cat_name}}</h3>
                <div class="row">
                    <div class="panel-body no-padding-top no-padding-bottom shadow-e5">
                        <?php $i = 1;?>
                        @foreach($ow_product as $product)
                        <div class="col-md-6 col-sm-6 border-box">
                            <div class="row no-margin1">
                                <div class="boxrow4-l col-sm-5 no-padding floor-border">
                                    <a href="javascript::void(0)">
                                        <!-- <img class="img-responsive boxrow2-l" alt="Missing" src="{{asset('/')}}images/img12.jpg"> -->
                                    <img src="{{asset('/')}}images/product/{{$product->id}}/{{$product->photo_1}}" title="product-image" class="img-responsive boxrow2-l">
                                    </a>                                            
                                </div>
                            <?php
                                $qty = explode(',', $product['pledged_qty']);
                                $v = 0;
                            ?>

                                 @foreach($qty as $key => $value)
                                <div class="col-sm-2">
                                    <span class="user_icon fa fa-male"></span>
                                    <br/><i class="item_number ">{{$value}}</i>
                                </div>
                                <?php 
                              
                                $v = $v + $value;
                                ?>
                                @endforeach
                            </div>
                            <?php
                            $price = $product->collection_price/100;
                            $op = $product['original_price']/100;
                            $save = $product->collection_units > 0 ? sprintf('%.2f',(($op - ($price/$product->collection_units))/$op) * 100): 0;
                            ?>
                      
                            <div class="row no-margin1">
                                <div class="col-sm-5 no-padding boxrow4-l">
                                   
                                    <p>{{$product['name']}}(1 {{$product->owarehouse_measure}} with {{$product->collection_units}} pieces)</p><b>RM {{$price}}</b>
                                    <p class="dicsount"> {{ $save>0 ? 'SAVE '.$save.'%' : ''}}</p>
                                    <h2>Original Price <span class=" pull-right">RM {{$product['original_price']/100}}</span></h2>
                                </div>
                                <div class="col-sm-6 moq_left" style="padding-left: 0px; padding-right: 0px; margin-left: 15px; width: 260px;">
                                    <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>{{$product->owarehouse_moq}}</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RM {{$price * $product->owarehouse_moq}}</h2>
                                        <h4>Bought &nbsp;&nbsp;&nbsp;&nbsp;<b>{{$v}}</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RM {{$v * $price}}</h2>
                                            <?php $left = ($product->owarehouse_moq - $v) > 0 ? ($product->owarehouse_moq - $v) : 0 ;?>
                                            <h4>Left &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>{{$left}}</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp; RM {{$left * $price}}</h2>
                                                </div>
                                                </div>
                                                <div class="row no-margin1">
                                                <?php 

                                                    $date = $product->odate;
                                                    $date = strtotime($date);

                                               
                                                    $current_date = strtotime(date('Y-m-d H:i:s'));
                                                    $date1 = new DateTime('now');

                                                    $date2 = new DateTime(date('Y-m-d H:i:s',strtotime("+ $product->owarehouse_duration day",$date)));
                                                     $dDiff = $date1->diff($date2);
                                                ?>
                                                    <h4>Due Date &nbsp;&nbsp;&nbsp;&nbsp;{{ date('d F Y',strtotime("+ $product->owarehouse_duration day",$date))}}</h4>

                                                    <h4>Time Left &nbsp;&nbsp;&nbsp;&nbsp;{{$dDiff->d}} days {{$dDiff->h}} hours and {{$dDiff->i}} minutes</h4>
                                                </div>
                                                <div class="row no-margin1">
                                                    <form role="form" class="owarehouseform">
                                                        <div class="col-sm-9 place_order">
                                                            <h4>Place Order</h4>
                                                            <p>Quantity</p>
                                                       
                                          
                                                            <div class="form">
                                                              <p style="display:none" class="owarehouse_id">{{$product['id']}}</p>
                                                                 <p style="display:none" class="owarehouse_price">{{$price}}</p>
                                                                <div class="price" style="display:none"><?php echo $price ;?></div> 
                                                                <span class="fa fa-male"></span>
                                                                <div class="quantity" data-id='-'>
                                                                    <span class="glyphicon glyphicon-minus"></span>
                                                                </div>
                                                                <input type="text" class="order_value" value="0">
                                                                <div class="quantity" data-id='+'>
                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                </div>
                                                                <span class="rm-1">RM <span class="price">{{$price}}</span></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                        <a href="javascript::void(0)" class="submitowerhouseorder btn a1">Confirm</a>
                                                            <!-- <button type="submit" class="submitowerhouseorder"> Confirm</button> -->
                                                            <button type="reset" class="resetowerhouseorder">Clear</button>
                                                        </div>
                                                    </form>     
                                                </div>
                                                </div>
                            <?php
                            if($i % 2 == 0){ ?>
                            <div class'clearfix'>
                    </div>
                    <?php }
                    $i++;
                    ?>
                                                @endforeach
                                                </div>
                                                </div>
                                                </div>
                                                </div>

                                                </div>
                                                </div>
                                                <p>&nbsp;</p>
<div class="custom-border"></div>
             
                                  <script>
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
                                  $(".quantity").click(function() {
                                            var quenty = $(this).siblings('.order_value');
                                            var value = parseInt(quenty.val());
                                            var type = $(this).data('id');
                                          var price= parseFloat($(this).siblings('.price').html());
                                            if (type == '+')
                                            {
                                               quenty.val(value + 1);
                                                var qty = value + 1;
                                              
                                            }
                                            else {
                                                if (value != 0)
                                                {
                                                    quenty.val(value - 1);
                                                     var qty = value - 1;
                                                }
                                            }
                                             $(this).siblings('.rm-1').html('RM '+ (qty * price));


                                        });
                                    $(document).off('click','.a1').on('click','.a1',function(e){
                                              e.preventDefault();

                                              console.log($(this).closest('.owarehouseform').find('.order_value').val());
                                        path = window.location.href;
                                               var url;
                                               if(path.includes('public'))
                                               {
                                                    url = '/OpenSupermall/public/cart/addtocart';
                                               }
                                               else {
                                                    url = '/cart/addtocart';
                                               }
                                  
                                                console.log();
                                                var id = $(this).closest('.owarehouseform').find('.owarehouse_id').text()
                                                var price = $(this).closest('.owarehouseform').find('.owarehouse_price').text();
                                                var quantity = $(this).closest('.owarehouseform').find('.order_value').val();
                                                $.ajax({
                                                  url: url,
                                                  type: "post",
                                                  data: {id:id ,price : price ,quantity : quantity},
                                                  success: function(data){
                                                    console.log(data);
                                                    $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
                                                    $('.cart-info').text(data[1]+' {{$currentCurrency}}'+ price + " Successfully added to the cart");
                                                    if(data[0] < 1)
                                                    {
                                                        $('.cart-link').text('Cart is empty');
                                                        $('.badge').text('0');
                                                    }
                                                    else {

                                                        $('.cart-link').text('View Cart');
                                                        $('.badge').text(data[0]);
                                                    }
                                                  }
                                                });      
                                           
                                                                                });
                                  </script>                                                                                                                                                                            
  @stop
