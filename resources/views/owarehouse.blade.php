@extends("common.default")
@section("content")
<script>
    $(document).ready(function () {
        $('.static-tab ul li a').on('click', function () {
            $('html,body').animate({scrollTop: $($(this).attr('href')).offset().top}, 1200);
        });
        $(".quantity").click(function () {
            var quenty = $(this).siblings('.order_value');
            var value = parseInt(quenty.val());
            var type = $(this).data('id');
            if (type == '+')
            {
                quenty.val(value + 1);
            }
            else {
                if (value != 0)
                {
                    quenty.val(value - 1);
                }
            }

        });
        $('.order_none').hide();
        $(".border-box").hover(
                function () {
                    $(this).addClass('order-border-box');
                    $(this).find('.order_none').show();
                }, function () {
            $(this).removeClass('order-border-box');
            $(this).find('.order_none').hide();
        }
        );
    });
    $(window).scroll(function () {
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
    <div class="col-sm-12 text-right margin-top box-green">
        <label class="margin-top">Sort By: &nbsp;</label>
        <select data-live-search="true" data-style="btn-green" class="selectpicker pull-right bs-select-hidden">
            <option> Price Low to High</option>
            <option> Price High to Low</option>
            <option> Relevance</option>
            <option> Discount</option>
        </select>
    </div>
    <div style="display: block;" class="static-tab" data-spy="scroll">
        <div class="text-center tab-arrow">
            <span class="fa fa-sort"></span>
        </div>
        <ul class="nav nav-pills nav-stacked">

            <li class="active" role="presentation"><a href="#Electronics">Electronics</a></li>
            <li role="presentation" class=""><a href="#bueaty">Beauty,Health<br/> and Cosmetic</a></li>
            <li role="presentation" class=""><a href="#Furniture">Home and<br/> Living</a></li>
        </ul>
    </div>

    <div class="col-sm-11 col-sm-offset-1">
        <p>&nbsp;</p>
        <div id="Electronics">  
            <div class="brandlist">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>O-Warehouse <small class="pull-right">10 results</small></h1>
                    </div>
                </div>
                <h3>Electronics</h3>
                <div class="row">
                    <div class="panel-body no-padding-top no-padding-bottom shadow-e5">
                        <div class="col-sm-6 border-box">
                            <div class="row no-margin1">
                                <div class="boxrow4-l col-sm-5 no-padding floor-border">
                                    <a href="/12">
                                        <img class="img-responsive boxrow2-l" alt="Missing" src="images/img12.jpg">
                                    </a>                                            
                                </div>
                                <div class="col-sm-4">
                                    <span class="user_icon fa fa-male"></span>
                                    <br/><i class="item_number ">1</i>
                                </div>
                            </div>
                            <div class="row no-margin1">
                                <div class="col-sm-5 no-padding boxrow4-l">
                                    <p>Lusso Power Bank(1 box with 10 pieces)</p><b>RM 600</b>
                                    <p class="dicsount">SAVE 40%</p>
                                    <h2>Original Price <span class=" pull-right">RM 12</span></h2>
                                </div>
                                <div class="col-sm-6 moq_left" style="padding-left: 0px; padding-right: 0px; margin-left: 15px; width: 260px;">
                                    <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp4&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                        <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                            <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                                </div>
                                                </div>
                                                <div class="row no-margin1">
                                                    <h4>Due Date &nbsp;&nbsp;&nbsp;&nbsp;20 November 2015</h4>
                                                    <h4>Time Left &nbsp;&nbsp;&nbsp;&nbsp;10 days 10 hours and 20 minutes</h4>
                                                </div>
                                                <div class="row no-margin1 order_none">
                                                    <form action="">
                                                        <div class="col-sm-9 place_order">
                                                            <h4>Place Order</h4>
                                                            <p>Quantity</p>

                                                            <div class="form">
                                                                <span class="fa fa-male"></span>
                                                                <div class="quantity" data-id='-'>
                                                                    <span class="glyphicon glyphicon-minus"></span>
                                                                </div>
                                                                <input type="text" class="order_value" value="0">
                                                                <div class="quantity" data-id='+'>
                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                </div>
                                                                <span class="rm-1">RM 168.00</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <button type="submit" class="submitowerhouseorder">Confirm</button>
                                                            <button type="reset" class="resetowerhouseorder">Clear</button>
                                                        </div>
                                                    </form>     
                                                </div>
                                                </div>                                    
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                                <div id="bueaty">  
                                                    <div class="brandlist">
                                                        <h3>Beauty, Health and Cosmetic</h3>
                                                        <div class="row">
                                                            <div class="panel-body no-padding-top no-padding-bottom shadow-e5">
                                                                <div class="col-sm-6 border-box">
                                                                    <div class="row no-margin1">
                                                                        <div class="boxrow4-l col-sm-5 no-padding floor-border">
                                                                            <a href="/12">
                                                                                <img class="img-responsive boxrow2-l" alt="Missing" src="images/img12.jpg">
                                                                            </a>                                            
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <span class="user_icon fa fa-male"></span>
                                                                            <br/><i class="item_number ">1</i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row no-margin1">
                                                                        <div class="col-sm-5 no-padding boxrow4-l">
                                                                            <p>Lusso Power Bank(1 box with 10 pieces)</p><b>RM 600</b>
                                                                            <p class="dicsount">SAVE 40%</p>
                                                                            <h2>Original Price <span class=" pull-right">RM 12</span></h2>
                                                                        </div>
                                                                        <div class="col-sm-6 moq_left" style="padding-left: 0px; padding-right: 0px; margin-left: 15px; width: 260px;">
                                                                            <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp4&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                                                                <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                                                                    <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                                                                        </div>
                                                                                        </div>
                                                                                        <div class="row no-margin1">
                                                                                            <h4>Due Date &nbsp;&nbsp;&nbsp;&nbsp;20 November 2015</h4>
                                                                                            <h4>Time Left &nbsp;&nbsp;&nbsp;&nbsp;10 days 10 hours and 20 minutes</h4>
                                                                                        </div>
                                                                                        <div class="row no-margin1 order_none">
                                                                                            <form action="">
                                                                                                <div class="col-sm-9 place_order">
                                                                                                    <h4>Place Order</h4>
                                                                                                    <p>Quantity</p>

                                                                                                    <div class="form">
                                                                                                        <span class="fa fa-male"></span>
                                                                                                        <div class="quantity" data-id='-'>
                                                                                                            <span class="glyphicon glyphicon-minus"></span>
                                                                                                        </div>
                                                                                                        <input type="text" class="order_value" value="0">
                                                                                                        <div class="quantity" data-id='+'>
                                                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                                                                        </div>
                                                                                                        <span class="rm-1">RM 168.00</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-sm-3">
                                                                                                    <button type="submit" class="submitowerhouseorder">Confirm</button>
                                                                                                    <button type="reset" class="resetowerhouseorder">Clear</button>
                                                                                                </div>
                                                                                            </form>     
                                                                                        </div>
                                                                                        </div>  
                                                                                        <div class="col-sm-6 border-box">
                                                                                            <div class="row no-margin1">
                                                                                                <div class="boxrow4-l col-sm-5 no-padding floor-border">
                                                                                                    <a href="/12">
                                                                                                        <img class="img-responsive boxrow2-l" alt="Missing" src="images/img12.jpg">
                                                                                                    </a>                                            
                                                                                                </div>
                                                                                                <div class="col-sm-4">
                                                                                                    <span class="user_icon fa fa-male"></span>
                                                                                                    <br/><i class="item_number ">1</i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row no-margin1">
                                                                                                <div class="col-sm-5 no-padding boxrow4-l">
                                                                                                    <p>Lusso Power Bank(1 box with 10 pieces)</p><b>RM 600</b>
                                                                                                    <p class="dicsount">SAVE 40%</p>
                                                                                                    <h2>Original Price <span class=" pull-right">RM 12</span></h2>
                                                                                                </div>
                                                                                                <div class="col-sm-6 moq_left" style="padding-left: 0px; padding-right: 0px; margin-left: 15px; width: 260px;">
                                                                                                    <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp4&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RM 1050</h2>
                                                                                                        <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RM 577.50</h2>
                                                                                                            <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp; RM 472.50</h2>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                <div class="row no-margin1">
                                                                                                                    <h4>Due Date &nbsp;&nbsp;&nbsp;&nbsp;20 November 2015</h4>
                                                                                                                    <h4>Time Left &nbsp;&nbsp;&nbsp;&nbsp;10 days 10 hours and 20 minutes</h4>
                                                                                                                </div>
                                                                                                                <div class="row no-margin1 order_none">
                                                                                                                    <form action="">
                                                                                                                        <div class="col-sm-9 place_order">
                                                                                                                            <h4>Place Order</h4>
                                                                                                                            <p>Quantity</p>

                                                                                                                            <div class="form">
                                                                                                                                <span class="fa fa-male"></span>
                                                                                                                                <div class="quantity" data-id='-'>
                                                                                                                                    <span class="glyphicon glyphicon-minus"></span>
                                                                                                                                </div>
                                                                                                                                <input type="text" class="order_value" value="0">
                                                                                                                                <div class="quantity" data-id='+'>
                                                                                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                                                                                </div>
                                                                                                                                <span class="rm-1">RM 168.00</span>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-3">
                                                                                                                            <button type="submit" class="submitowerhouseorder">Confirm</button>
                                                                                                                            <button type="reset" class="resetowerhouseorder">Clear</button>
                                                                                                                        </div>
                                                                                                                    </form>     
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                <div id="Furniture">  
                                                                                                                    <div class="brandlist">
                                                                                                                        <h3>Home and Furniture</h3>
                                                                                                                        <div class="row">
                                                                                                                            <div class="panel-body no-padding-top no-padding-bottom shadow-e5">
                                                                                                                                <div class="col-sm-6 border-box">
                                                                                                                                    <div class="row no-margin1">
                                                                                                                                        <div class="boxrow4-l col-sm-5 no-padding floor-border">
                                                                                                                                            <a href="/12">
                                                                                                                                                <img class="img-responsive boxrow2-l" alt="Missing" src="images/img12.jpg">
                                                                                                                                            </a>                                            
                                                                                                                                        </div>
                                                                                                                                        <div class="col-sm-4">
                                                                                                                                            <span class="user_icon fa fa-male"></span>
                                                                                                                                            <br/><i class="item_number">1</i>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <div class="row no-margin1">
                                                                                                                                        <div class="col-sm-5 no-padding boxrow4-l">
                                                                                                                                            <p>Lusso Power Bank(1 box with 10 pieces)</p><b>RM 600</b>
                                                                                                                                            <p class="dicsount">SAVE 40%</p>
                                                                                                                                            <h2>Original Price <span class=" pull-right">RM 12</span></h2>
                                                                                                                                        </div>
                                                                                                                                        <div class="col-sm-6 moq_left" style="padding-left: 0px; padding-right: 0px; margin-left: 15px; width: 260px;">
                                                                                                                                            <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp4&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                                                                                                                                <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                                                                                                                                    <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 600</h2>
                                                                                                                                                        </div>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="row no-margin1">
                                                                                                                                                            <h4>Due Date &nbsp;&nbsp;&nbsp;&nbsp;20 November 2015</h4>
                                                                                                                                                            <h4>Time Left &nbsp;&nbsp;&nbsp;&nbsp;10 days 10 hours and 20 minutes</h4>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="row no-margin1 order_none">
                                                                                                                                                            <form action="">
                                                                                                                                                                <div class="col-sm-9 place_order">
                                                                                                                                                                    <h4>Place Order</h4>
                                                                                                                                                                    <p>Quantity</p>

                                                                                                                                                                    <div class="form">
                                                                                                                                                                        <span class="fa fa-male"></span>
                                                                                                                                                                        <div class="quantity" data-id='-'>
                                                                                                                                                                            <span class="glyphicon glyphicon-minus"></span>
                                                                                                                                                                        </div>
                                                                                                                                                                        <input type="text" class="order_value" value="0">
                                                                                                                                                                        <div class="quantity" data-id='+'>
                                                                                                                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                                                                                                                                        </div>
                                                                                                                                                                        <span class="rm-1">RM 168.00</span>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-sm-3">
                                                                                                                                                                    <button type="submit" class="submitowerhouseorder">Confirm</button>
                                                                                                                                                                    <button type="reset" class="resetowerhouseorder">Clear</button>
                                                                                                                                                                </div>
                                                                                                                                                            </form>     
                                                                                                                                                        </div>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="col-sm-6 border-box">
                                                                                                                                                            <div class="row no-margin1">
                                                                                                                                                                <div class="boxrow4-l col-sm-5 no-padding floor-border">
                                                                                                                                                                    <a href="/12">
                                                                                                                                                                        <img class="img-responsive boxrow2-l" alt="Missing" src="images/img12.jpg">
                                                                                                                                                                    </a>                                            
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-sm-4">
                                                                                                                                                                    <span class="user_icon fa fa-male"></span>
                                                                                                                                                                    <br/><i class="item_number">1</i>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class="row no-margin1">
                                                                                                                                                                <div class="col-sm-5 no-padding boxrow4-l">
                                                                                                                                                                    <p>Lusso Power Bank(1 box with 10 pieces)</p><b>RM 600</b>
                                                                                                                                                                    <p class="dicsount">SAVE 40%</p>
                                                                                                                                                                    <h2>Original Price <span class=" pull-right">RM 12</span></h2>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-sm-6 moq_left" style="padding-left: 0px; padding-right: 0px; margin-left: 15px; width: 260px;">
                                                                                                                                                                    <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp4&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp RM 1584</h2>
                                                                                                                                                                        <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp; RM 871.20</h2>
                                                                                                                                                                            <h4>MOQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp<b>4</b>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp; RM 712.80</h2>
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                <div class="row no-margin1">
                                                                                                                                                                                    <h4>Due Date &nbsp;&nbsp;&nbsp;&nbsp;20 November 2015</h4>
                                                                                                                                                                                    <h4>Time Left &nbsp;&nbsp;&nbsp;&nbsp;10 days 10 hours and 20 minutes</h4>
                                                                                                                                                                                </div>  
                                                                                                                                                                                <div class="row no-margin1 order_none">
                                                                                                                                                                                    <form action="">
                                                                                                                                                                                        <div class="col-sm-9 place_order">
                                                                                                                                                                                            <h4>Place Order</h4>
                                                                                                                                                                                            <p>Quantity</p>

                                                                                                                                                                                            <div class="form">
                                                                                                                                                                                                <span class="fa fa-male"></span>
                                                                                                                                                                                                <div class="quantity" data-id='-'>
                                                                                                                                                                                                    <span class="glyphicon glyphicon-minus"></span>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                <input type="text" class="order_value" value="0">
                                                                                                                                                                                                <div class="quantity" data-id='+'>
                                                                                                                                                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                <span class="rm-1">RM 168.00</span>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="col-sm-3">
                                                                                                                                                                                            <button type="submit" class="submitowerhouseorder">Confirm</button>
                                                                                                                                                                                            <button type="reset" class="resetowerhouseorder">Clear</button>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    </form>     
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>                                      
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>
                                                                                                                                                                                <p>&nbsp;</p>
                                                                                                                                                                                <div class="custom-border"></div>                                                                                                                                                                            
                                                                                                                                                                                @stop
