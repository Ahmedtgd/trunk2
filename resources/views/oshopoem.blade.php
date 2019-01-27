@extends("common.default")

@section("content")

    <section style="background:rgb(41,54,74);" class="">
        <img width="100%" class="width-100 img-responsive" src="images/Ms-one.jpg" alt="the-leather-house" />
        <div class="maincontent-area">
            <div class="container">
                <div class="row" style=" margin-top: 10px; margin-bottom: 10px;">

                    <div  class="navbar-collapse collapse ">

                        <ul  class="nav navbar-nav custom-navbar">

                            <li class="pull-left" ><a style="color:white; font-size:25px;" href="/" class="active">About</a></li>
                            <li><a style="color:white; font-size:25px;">Certificate</a></li>
                            <li><a style="color:white; font-size:25px;">Supplier</a>&nbsp; &nbsp; &nbsp;</li>
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <li ><button style="background:rgb(0,99,98);border:none; padding:8px;" class=""><a style="color:white; text-decoration:none" href=""><strong><i class="fa fa-link fa-lg"></i></strong>&nbsp;&nbsp;&nbsp;Auto Link&nbsp;&nbsp;&nbsp;&nbsp;</a></button></li>
                            <li  style="color:white"><a style="color:white" herf="">OFFICIAL SHOP</a></li>
                            <li  style="color:white"><img style="width:30px; height:20px" src="images/malaysia.png">&nbsp;<p style="background:black">Malaysia</p></li>
                            <li  style="background:rgb(224,40,120);  color:white">&nbsp; &nbsp;Like &nbsp; &nbsp;&nbsp; &nbsp;</li>
                        </ul>
                    </div>

                </div>
                <div class="row" style=" margin-top: 10px; margin-bottom: 10px;">
                    <div class="col-md-12">
                        <div  class="col-md-12">
                            <img class="width-100 img-responsive" src="images/ms-one-bunding.jpg" alt="the-leather-house" />
                        </div>

                        <div class="row">
                            <div class="col-md-10 col-md-offset-2">
                                <div style="color:white; margin-right:0px; margin-top:20px;" class="pull-right">3 results &nbsp; &nbsp; Sort By:&nbsp; &nbsp;<select style="width:150px;color:black"><option>Price:low to high</option><option>Price: High to low</option></select><span class="caret"></span></div>
                                <br>
                                <div style="color:white" class="col-md-12" style="margin-top:90px" class="pull-left">
                                    <p style="font-size:20px; color:white">Manufacturing OEM/ODM </p>

                                    <select style="width:150px;color:black"><option>Custom Product</option><option>Regular Product</option></select>&nbsp; &nbsp; OEM/ODM<br><br>
                                    Minimum Order Quantity &nbsp; &nbsp; 10000<br><br>
                                    <div style="margin-left:-15px" class="col-md-4 pull-left"> Quantity &nbsp;  <input style="color:black" type="text" placeholder="Type the Number"></div>
                                    <div style="margin-left: -65px;" class="col-md-2 pull-left" id="kids"><input  type="file" placeholder="Upload Attachment" name="child_1"></div>
      <span class="col-md-1 kids-image" style="">&nbsp;&nbsp;&nbsp;
      <input style="width:40px; height:30px;" type="image" src='images/plus.png' id="add_kid()" onclick="addKid()" value="">
      </span>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="border:none" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left ">

                    <div class="row">
                        <div class="col-md-2">
                            <ul class="navGreenBar">
                                <li><a href=""><i class="fa fa-sort"></i></a></li>
                                <li class=""><a href="">Belts</a></li>
                                <li class=""><a href="">Car Lubricant Oils
                                    </a></li>
                            </ul>
                        </div>
                        <div class="col-md-10">
                            <div  id="all-floors">
                                <!-- Belts Start-->
                                <div  class=" col-xs-12  col-sm-12 col-lg-12 col-lg-12 floor">
                                    <article id="belt" class="floor-content"><hr class="border-none">
                                        <div  class="row">
                                            <div class="col-md-12 floor-board nopadding">
                                                <div style="color:white; font-size: 20px;" class="floor-level col-xs-12 col-md-4"><strong class="pull-left">Belts</strong> </div>

                                            </div>
                                        </div>
                                        <div class="row">

                                            <div style="border:none">
                                                <div style="width: 100%" class="panel-body no-padding-top no-padding-bottom  padding-right-30  ">
                                                    <div class="row">
                                                        <div class="col-md-12 display-table no-padding">
                                                            <div class="col-md-5 no-padding display-table-cell cat-image" >
                                                            </div>
                                                            <div class="col-md-7 no-padding display-table-cell floor-merchandise">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 nopadding add-padding">
                                                            <div class="cd-slider-wrapper col-md-3 col-xs-6 no-padding ">
                                                                <a href="">
                                                                    <img style="height:250px;width:100%" src="images/automotive-aftermarket-belt.jpg" alt="female" />
                                                                    <p style="color:white; padding-top:10px;">[HUTCHITSON]&nbsp;Accessory Belt</p>
                                                                    <p style="color:white">10 Unit RM 80<br>
                                                                        100 Unit RM 65</p>
                                                                    <br>
                                                                    <p style="color:red">Sold &nbsp; &nbsp; 2560</p>
                                                                </a></div>

                                                            <div   class="col-md-3 col-xs-6 ">
                                                                <a href="">
                                                                    <img  style="width:100%; height:250px;  " src="images/NBH_Micro-V-Belt-copy.jpg" alt="female" />
                                                                </a>
                                                                <p style="color:white; padding-top:10px;font-size:15px;">[NAPA]&nbsp;Micro VAT Belt</p>
                                                                <p style="color:white;font-size:15px;">10 Unit RM 80<br>
                                                                    100 Unit RM 65</p><br>
                                                                <p style="color:red">Sold &nbsp; &nbsp; 2585</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </article>

                                </div>
                                <!-- Belts end-->

                                <!-- Car Lubricant oil start-->
                                <div  class=" col-xs-12 col-sm-12  col-lg-12 col-md-12 col-lg-12 floor">
                                    <article id="oil" class="floor-content"><hr class="border-none">
                                        <div  class="row">
                                            <div class="col-md-12 floor-board nopadding">
                                                <div style="color:white; font-size:20px;" class="floor-level col-xs-12 col-md-4"><strong class="pull-left">Car Lubricant Oils</strong>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">

                                            <div style="border:none">
                                                <div style="width: 100%" class="panel-body no-padding-top no-padding-bottom  padding-right-30  ">
                                                    <div class="row">
                                                        <div class="col-md-12 display-table no-padding">
                                                            <div class="col-md-5 no-padding display-table-cell cat-image" >
                                                            </div>
                                                            <div class="col-md-7 no-padding display-table-cell floor-merchandise">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="cd-slider-wrapper col-md-3 col-xs-6 no-padding ">
                                                                <a href="">
                                                                    <img style="height:250px;" src="images/a7624cbf6a2ecdd5422b7a5a15bab5ad.jpg" alt="female" />
                                                                </a>
                                                                <p style="color:white; font-size:15px;padding-top:10px;">Shell Helix HX5 15W-40</p>
                                                                <p style="color:white; font-size:15px;">10 Unit RM 350<br>
                                                                    100 Unit RM 400</p><br>
                                                                <p style="color:red; font-size:15px;">Sold &nbsp; &nbsp; 280</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </article>
                                </div>


                                <!-- Car Lubricant oil end-->


                            </div>
                        </div>
                    </div>

                </div>
                <img style=" width:100%;height:450px;" src="images/hd-wallpapers-gray-car-parts-wallpaper-car-part-hd-wallpapers-p-love-white-music-nature-android-gray-parts.jpg">

            </div>
        </div>

        </div>

        <a href="#" class="to-top-button"><i class="fa fa-angle-double-up"></i></a>

        </div>
        <br>
        <br>

    </section>
    <script type="text/javascript">
        var i = 1;
        function addKid(){
            if (i <= 100) {
                i++;
                var div = document.createElement('div');
                div.setAttribute("style", "width:230px; height:25px; margin-top:8px; margin-bottom:8px");
                div.innerHTML = '<input style="float:left; width:208px"  type="file" placeholder="Upload Attachment" name="child_'+i+'"><input style="width:20px;height:20px;margin-top:4px" type="image" src="images/cross.png" onclick="removeKid(this)" value="">';
                document.getElementById('kids').appendChild(div);
            };
        };

        function removeKid(div){
            document.getElementById('kids').removeChild(div.parentNode);
            i--;
        };
    </script>

@stop