@extends("common.default")

@section("content")

<div class="row">

    <div class="col-sm-12 text-center">
        <img alt="Profile Logo" src="images/Al-halabi.jpg" width="100%">
    </div>
    <div class="clearfix"></div>
</div>

<section class="oshop-certificate-body">

    <div class="profile-setting-navigation">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#profile-setting-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hidden" href="#"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="profile-setting-navbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/profilesettingaboutus">About</a></li>
                        <li><a href="/profilesettingcertificate">Certificate</a></li>
                        <li><a href="#">Supplier</a></li>

                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="btn btn-green"><i class="fa fa-lg fa-link"></i> AutoLink</a></li>
                        <li><a href="#"><strong><em>OFFICIAL SHOP</em></strong></a></li>
                        <li><a href="#"><img src="images/flag.png" width="100%" alt="flag"></a></li>
                        <li><a href="#" class="btn btn-pink">Like</a></li>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

    </div>


    <div class="oshop-certificate-content"><!--Begin main cotainer-->
        <div class="container">

            <div class="row nopadding padding-inner">
                <div class="col-md-2">
                    <img src="images/halal-1.png" alt="Lorem Ipsum" width="100%"/>
                </div>
                <div class="col-md-10 nopadding">
                    <div class="padding-top-30">
                        <h4 class="padding-top-10">Health Certificate Services Certified </h4><br/>
                        <span class="fontStyle">23 November 2015</span>
                        <p class="padding-top-10">
                            *Received this award on November 2013 and change all the menu to halal.
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="col-md-12"><hr/></div>
                <div class="clearfix"></div>
                <br>
                <div class="col-md-2">
                    <img src="images/chinese_kitchen.jpg" alt="Lorem Ipsum" width="100%"/>
                </div>
                <div class="col-md-10 nopadding">
                    <div class="padding-top-30">
                        <h4 class="padding-top-10">Malaysia Government Halal Certificate Services Certified </h4><br/>
                        <span class="fontStyle">5 March 2015</span>
                        <p class="padding-top-10">
                            *Received this certification on March 2015 and change all the restaurants in Malaysia to become Halal Restaurant
                        </p>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div><!--End main cotainer-->
</section>

@stop