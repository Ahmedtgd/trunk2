@extends("common.default")

@section("content")

<div class="row">

    <div class="col-sm-12 text-center">
        <img alt="Profile Logo" src="{{ asset('images/Al-halabi.jpg') }}" width="100%">
    </div>
    <div class="clearfix"></div>
</div>

<section class="oshop-aboutus-body">

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

    <div class="row" style="padding: 30px 0 40px 0;">
        <div class="col-md-12 nopadding">
            <img src="{{ asset('images/al-halabi-advertisement.jpg') }}" width="1186;" style="margin:0 auto; padding:0; display: block;">
        </div>
    </div>

    <div class="oshop-aboutus-content"><!--Begin main cotainer-->
        <div class="container padding-20">
            <div class="row">

                <div class="page-header">
                    <h3>About Us</h3>
                </div>
            </div>
            <br/>
            <div class="row nomargin">
                <div class="col-md-12 padding-inner">
                    <p>
                        <span class="paragraph-header">Our History</span><br/>
                        Arabic &#38; Lebanese Cuisine to Satisfy All Your Sense
                    </p>
                    <br/>
                    <p>
                        The success story was unfolded in 1998. Ever since then, Tarbush has made a name of its own to be first and leading Middle Eastern Restaurant in Malaysia. On top of that, Tarbush has also Established good report with various organizations and sectors in the country.
                    </p>
                    <br/>
                    <p>
                        Tarbush has opened thus far four branchus that are stragically located; Jalan Bintang , Starhill Gallery, Sunway Pyramid and most recently. Tarbush has set its eye on Batu Ferringghi, Penang, where on oasis of Tarbush's celebrated dining experience is standing proudly by the water of Pearl of the Orients.
                    </p>
                    <br/>
                    <p>
                        The meticulous interior design, exotic and decoration and extensive list of menu, ranging from soups, appetizers, right down to the main course and desserts to sample and choose from will undoubtedly make your meal an awesome experience and an unforgettable one.
                    </p>

                </div>
            </div>
            <div class="row nopadding">
                <hr />
            </div>

            <div class="row nomargin">
                <div class="col-md-12 padding-inner">
                    <p>
                        <span class="paragraph-header">Description</span><br/>
                        Al Halabi lounge brings you on a magic carpet ride where oriental dreams come true, tantalizing aromas of faraway land linger and enchanting melodies of a thousand and on enights fill the air.
                    </p>
                    <br/>
                    <p>
                        Al Halabi is a name of a city in Syria, also know as Aleppo. Al Halabi lounge has a very personal ring to it because it is also the family name of its owner, Mr Molyiddin Al Hakabi.
                    </p>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-md-12 nopadding">
                    <div class="col-md-3 nopadding"><img src="images/01.jpg" width="100%"></div>
                    <div class="col-md-3 nopadding"><img src="images/03.jpg" width="100%"></div>
                    <div class="col-md-3 nopadding"><img src="images/03.jpg" width="100%"></div>
                    <div class="col-md-3 nopadding"><img src="images/04.jpg" width="100%"></div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 nopadding"><img src="images/05.jpg" width="100%"></div>
                    <div class="col-md-3 nopadding"><img src="images/06.jpg" width="100%"></div>
                    <div class="col-md-3 nopadding"><img src="images/07.jpg" width="100%"></div>
                    <div class="col-md-3 nopadding"><img src="images/08.jpg" width="100%"></div>
                </div>
            </div>

            <div class="row nopadding">
                <hr />
            </div>
            <div class="row nopadding padding-inner">
                <div class="col-md-12">
                    <p><span class="paragraph-header">Our Team</span></p>
                </div>

                <div class="col-md-2">
                    <img src="images/wilkeshr.jpg" alt="Mr Muhamet Ibrahim" width="100%"/>
                </div>
                <div class="col-md-10 nopadding">
                    <h4>Mr Muhamet Ibrahim </h4><br/>
                    <span class="fontStyle">Director</span>
                    <p class="padding-top-10">
                        *Guest will also have a change to enjoy Arabic Tea, Turkish Tea and many more type middle east teas that will definetely uplift their sense
                    </p>
                </div>
                <div class="clearfix"></div>

                <br>
                <div class="col-md-2">
                    <img src="images/454137919.jpg" alt="Mr Sina Ibrahim" width="100%"/>
                </div>
                <div class="col-md-10 nopadding">
                    <h4>Mr Sina Ibrahim </h4><br/>
                    <span class="fontStyle">Marketing Manager</span>
                    <p class="padding-top-10">
                        *Guest will also have a chance to enjoy Arabic culture definetely uplift their sense
                    </p>
                </div>

                <div class="clearfix"></div>
                <br>

                <div class="col-md-2">
                    <img src="images/chef_thomas.jpg" alt="Mr William Gift" width="100%"/>
                </div>
                <div class="col-md-10 nopadding">
                    <h4>Mr William Gift </h4><br/>
                    <span class="fontStyle">Chef</span>
                    <p class="padding-top-10">
                        *Guest will also have a chance to enjoy Arabic food and the atmosphere of wonderful Arabic culture.
                    </p>
                </div>

                <div class="clearfix"></div>
                <br>

            </div>

        </div>

    </div><!--End main cotainer-->
    <br/><br/>
</section>

@stop