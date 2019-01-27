<?php

function country_list(){
    return $country_list = array(
            "United States",
            "Albania",
            "Algeria",
            "Andorra",
            "Angola",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegovina",
            "Botswana",
            "Brazil",
            "Brunei",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Colombi",
            "Comoros",
            "Congo (Brazzaville)",
            "Congo",
            "Costa Rica",
            "Cote d'Ivoire",
            "Croatia",
            "Cuba",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "East Timor (Timor Timur)",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Fiji",
            "Finland",
            "France",
            "Gabon",
            "Gambia, The",
            "Georgia",
            "Germany",
            "Ghana",
            "Greece",
            "Grenada",
            "Guatemala",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Honduras",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, North",
            "Korea, South",
            "Kuwait",
            "Kyrgyzstan",
            "Laos",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macedonia",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Mauritania",
            "Mauritius",
            "Mexico",
            "Micronesia",
            "Moldova",
            "Monaco",
            "Mongolia",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepa",
            "Netherlands",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Poland",
            "Portugal",
            "Qatar",
            "Romania",
            "Russia",
            "Rwanda",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Vincent",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Serbia and Montenegro",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "Spain",
            "Sri Lanka",
            "Sudan",
            "Suriname",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syria",
            "Taiwan",
            "Tajikistan",
            "Tanzania",
            "Thailand",
            "Togo",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Vatican City",
            "Venezuela",
            "Vietnam",
            "Yemen",
            "Zambia",
            "Zimbabwe"
    );
}

?>
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
                        <li role="presentation" class="floor-navigation"><a href="#retail">Retail</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#wholesale">Wholesale</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#product">Product</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#pspecification">Specification</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#seller">Seller</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#policy">Policy</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#return">Return</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                    <hr>   <div class="col-sm-12 text-right">
                   <ul class="list-inline">
                       <li class="active"><a href="/create_new_product">Product</a></li>
                       <li><a href="/create_new_voucher">Voucher</a></li>
                   </ul>
                        </div>
                    <div class="clearfix"></div>
<hr>

                    <form class="form-horizontal">
                        <div id="pinformation" class="row">
                            <div class="col-sm-12"><h1>Product Information</h1></div>

                            <div class="col-sm-4 thumbnail">
                            <div class="product-photo">
                                <img class="img-responsive"  id="preview-img" src="#" alt="" />
                                <div class="inputBtnSection">
                                    <input id="uploadFile" class="disableInputField text-center" placeholder="Add Photo" disabled="disabled" />
                                    <label class="fileUpload">
                                        <input id="uploadBtn" type="file" class="upload" />
                                        <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
                                    </label>
                                </div>
                            </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Brand</label>
                                    <div class="col-sm-9">
                                        <select class="form-control">
                                            <option>Choose Option</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-control">
                                            <option>Choose Option</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-control">
                                            <option>Choose Option</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">O-Shop</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Short Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 margin-top">
                                        <table class="table noborder">
                                            <tr><th>Amount</th><td>{{$currentCurrency}}</td><td>450.00</td></tr>
                                            <tr><th>Delivery</th><td>{{$currentCurrency}}</td><td>5.00</td></tr>
                                            <tr><td colspan="3"><hr></td></tr>
                                            <tr><th>&nbsp</th><td>{{$currentCurrency}}</td><td>450.00</td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                        </div>
                        <hr>
                        <div id="delivery" class="row">


                            <div class="col-sm-2">
                                <div class="checkbox checkbox-success">
                                    <input id="checkboxD" class="styled" type="checkbox">
                                    <label for="checkboxD">
                                        Free Delivery
                                    </label>
                                </div>
                                <label class="">Delivery Pricing</label>

                            </div>
                            <div class="clearfix"></div>
                            <hr>

                            <div class="col-sm-5 toggleDelivery">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">World Wide</label>
                                    <div class="col-sm-8">
                                        <input type="text"  class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">West Malaysia</label>
                                    <div class="col-sm-8">
                                        <input type="text"  class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Sabah/Labuan</label>
                                    <div class="col-sm-8">
                                        <input type="text"  class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Sarawak</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-4 col-sm-offset-1">
                                <h3>Delivery Coverage</h3>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Country</label>
                                    <div class="col-sm-9">
                                        <select class="selectpicker show-menu-arrow" data-style="btn-green" >
                                            <?php
                                            foreach(country_list() as $k)
                                            {
                                            ?>
                                            <option value="<?php echo $k?>"><?php echo $k?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">State</label>
                                    <div class="col-sm-9">
                                        <select class="selectpicker show-menu-arrow " data-style="btn-green" >
                                            <option> Wilayah Persekutuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">City</label>
                                    <div class="col-sm-9">
                                        <select class="selectpicker show-menu-arrow" data-style="btn-green" >
                                            <option>Kuala Lumpur </option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="clearfix"> </div>
                            </div>
                        <hr>
                        <div id="retail" class="row">
                            <div class="col-sm-12">
                                <h1>Retail</h1>
                            </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Retail Price </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="rPrice" class="retailSave form-control">
                                        </div>
                                        <div class="col-sm-2 text-danger" >
                                            SAVE <span id="resultSave"> 0.0 </span> %
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Original Price</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="oPrice" class="retailSave form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Available</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>


                            <div class="clearfix"> </div>
                        </div>
                        <hr>
                        <div id="wholesale"  class="row">

                            <div class="col-xs-12"><h1>Business to Business</h1></div>
                            <div class="col-sm-4"><h3>Wholesale Price</h3></div>
                            <div class="col-sm-2">
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" class="styled" id="checkbox2">
                                    <label for="checkbox2">Display</label>
                                </div>
                            </div>
                            <div class="clearfix"> </div>
                            <hr>
                            <div class="col-md-8">
                                <label>Resellers</label>
                                <div class="form-group">
                                    <div class="col-sm-11 col-xs-10">
                                        <input type="text" class="form-control" placeholder="Autofix Garage Sdn Bhd (954-783-T)">
                                    </div>
                                    <div class="col-xs-1 row">
                                        <a  href="javascript:void(0);" id="addwholesale" class="btn btn-default text-green">
                                            <i class="fa fa-plus-circle"></i></a>
                                    </div>
                                </div>
                                <div id="wsreseller"></div>

                                <div class="clearfix"> </div>

                                <div class="table-responsive " >
                                    <table class="table table-striped noborder" id="wrpTable">
                                        <tr><th>Unit</th><th colspan="4">Price</th>
                                        </tr>
                                        <tr>
                                            <td width="80" class="saving"><input type="text" class="form-control numeric" size="5"></td>
                                            <td width="250">
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currentCurrency}}</span>
                                                    <input type="text" class="form-control myr-price">
                                                </div>
                                            </td>
                                            <td> <a  href="javascript:void(0);" id="addrsp" class="form-control text-center text-green">
                                                    <i class="fa fa-plus-circle"></i></a>
                                            </td>
                                            <td> <div class="input-group">
                                                    <span class="input-group-addon">SAVE</span>
                                                    <div class="average form-control text-center text-danger">0.0</div>
                                                    <span class="input-group-addon">% from retail</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>


                            </div>


                            <div class="col-md-4">
                                <h3>Delivery Coverage</h3>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Country</label>
                                    <div class="col-sm-9">
                                        <select class="selectpicker show-menu-arrow" data-style="btn-green" >
                                            <?php
                                            foreach(country_list() as $k)
                                            {
                                            ?>
                                            <option value="<?php echo $k?>"><?php echo $k?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">State</label>
                                    <div class="col-sm-9">
                                        <select class="selectpicker show-menu-arrow " data-style="btn-green" >
                                            <option> Wilayah Persekutuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">City</label>
                                    <div class="col-sm-9">
                                        <select class="selectpicker show-menu-arrow" data-style="btn-green" >
                                            <option>Kuala Lumpur </option>
                                        </select>
                                    </div>
                                </div>

                            </div>


                            <div class="clearfix"> </div>
                            <div class="col-sm-4"><h3>Special Price</h3></div>
                            <div class="col-sm-2">
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" class="styled" id="checkbox2">
                                    <label for="checkbox2">Display</label>
                                </div>
                            </div>
                            <div class="clearfix"> </div>
                            <hr>
                            <div class="col-sm-12">
                                <div class="table-responsive " >
                                    <table class="table table-striped noborder" id="sppTable">
                                        <tr><th>Unit</th><th colspan="2">Price</th>
                                            <th colspan="4">Username</th>
                                        </tr>
                                        <tr>
                                            <td width="80" class="saving"><input type="text" class="form-control numeric" size="5"></td>
                                            <td width="250">
                                                <div class="input-group">
                                                    <span class="input-group-addon">{{$currentCurrency}}</span>
                                                    <input type="text" class="form-control myr-price">
                                                </div>
                                            </td>
                                            <td> <a  href="javascript:void(0);" id="addspp" class="form-control text-center text-green">
                                                    <i class="fa fa-plus-circle"></i></a>
                                            </td>
                                            <td class="col-xs-4"><input class="form-control" type="text"></td>
                                            <td> <div class="input-group">
                                                    <span class="input-group-addon">SAVE</span>
                                                    <div class="average form-control text-center text-danger">0.0</div>
                                                    <span class="input-group-addon">% from retail</span>
                                                </div>
                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="clearfix"> </div>


                        </div>
                        <hr>
                        <div id="product" class="row">
                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Product Details</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="info-textarea2" ></textarea>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <hr>
                        <div id="pspecification" class="row">
                            <div class="col-xs-12">
                                <h1>Product Specification</h1>
                            </div>
                            <div class="col-xs-12 col-sm-offset-1">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">SKU</label>
                                    <div class="col-sm-4">
                                        <input type="text"  class="form-control">
                                    </div>
                                    <div class="clearfix"></div>
                                    <label class="col-sm-3 control-label">Color</label>
                                    <div class="col-sm-4">
                                        <input type="text"  class="form-control">
                                    </div>
                                    <div class="clearfix"></div>
                                    <label class="col-sm-3 control-label">Model</label>
                                    <div class="col-sm-4">
                                        <input type="text"  class="form-control">
                                    </div>
                                    <div class="clearfix"></div>
                                    <label class="col-sm-3 control-label">Size(L x W x H)</label>
                                    <div class="col-sm-4">
                                        <input type="text"  class="form-control">
                                    </div>
                                    <div class="clearfix"></div>
                                    <label class="col-sm-3 control-label">Weight</label>
                                    <div class="col-sm-4">
                                        <input type="text"  class="form-control">
                                    </div>
                                    <div class="clearfix"></div>
                                    <label class="col-sm-3 control-label">Warranty Period</label>
                                    <div class="col-sm-4">
                                        <input type="text"  class="form-control">
                                    </div>
                                    <div class="clearfix"></div>
                                    <label class="col-sm-3 control-label">Warranty Type++</label>
                                    <div class="col-sm-4">
                                        <input type="text"  class="form-control">
                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                            </div>

                        </div>
                        <hr>
                        <div id="seller" class="row">
                            <div class="col-xs-12">
                                <h1>Seller Information</h1>
                            </div> <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-offset-1">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Seller Name </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ship form address</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control">
                                    <input type="text" class="form-control">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Return/Exchange Address</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control">
                                    <input type="text" class="form-control">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            </div>

                        </div>
<hr>
                        <div id="policy" class="row">
                            <div class="col-xs-12">
                                <h1>Seller Policy</h1>
                            </div>

                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Return / Exchange Policy</a>
                            </div>
                            <div class="clearfix"></div>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="info-textarea" ></textarea>
                                </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div id="return" class="row">
                            <div class="col-xs-12">

                                <h1>OpenSupermall</h1>
                                <h3>Notice on Return</h3>


                            </div>
                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Return / Exchange Policy</a>

                            </div>
                            <div class="col-xs-12">
                                <div class="thumbnail">
                                    <p>You are only entitled to a refund if you return it within three or four weeks, other wise you can get a repair or replacement. You are only entitled to a refund if you return it within three or four weeks, other wise you can get a repair or replacement. You are only entitled to a refund if you return it within three or four weeks, other wise you can get a repair or replacement</p>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h3 class="page-header">Cancellation</h3>
                                            <ol>
                                                <li>Request for cancellation can be made after payment for the product is completed.</li>
                                                <li>Request for cancellation will only be approved if the product has not been shipped by the Merchant and the Buyer shall be entitled to refund</li>
                                                <li>Request for cancellation will be rejected in the event that the Merchant has shipped the product.</li>
                                            </ol>

                                        </div>
                                        <div class="col-sm-4">
                                            <h3 class="page-header">Return &amp; Exchange</h3>
                                            <ol>
                                                <li>Request for return of the product purchased can be upon the product is delivered.</li>
                                                <li>In the event that the product delivered is flawed, the Buyer shall return the product to the Merchant at the Buyer's own cost.</li>
                                                <li>Upon receiving the Merchant's confirmation on the approvalfor the request for return, payment shall than be refunded to the Buyer.</li>
                                                <li>In the event that wrong product is delivered, the Buyer may return the wrong product to Merchant at the Buyer's own cost and upon receiving the Merchant's confirmation and approval for the request, a new product shall be re-dilivered to the Buyer.</li>
                                            </ol>

                                        </div>
                                        <div class="col-sm-4">
                                            <h3 class="page-header">Terms &amp; Conditions</h3>

                                            <ol>
                                                <li>Request for return and/or refund shall be made within 7 days from the date of the delivery of the product</li>
                                                <li>The Buyer shall not be entitled to refund and/or exchange if:
                                                    <ol>
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

                        <div class="row">
                            <div class="col-sm-12 text-right"> <input type="submit" class="btn btn-green" value="SEND"></div>
                        </div>


                    </form>


                </div>
            </div>
        </div><!--End main cotainer-->
    </section>
@stop