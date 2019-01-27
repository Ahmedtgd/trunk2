@extends("common.default")

@section("content")

    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                    <div data-spy="scroll" class="static-tab" style="display: none;">
                        <div class="text-center tab-arrow">
                            <span class="fa fa-sort"></span>
                        </div>
                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="active"><a href="#account">Account</a></li>
                            <li role="presentation"><a href="#company">Company</a></li>
                            <li role="presentation"><a href="#contact">Contact</a></li>
                            <li role="presentation"><a href="#shop">Shop</a></li>
                            <li role="presentation"><a href="#bank">Bank</a></li>
                            <li role="presentation"><a href="#remark">Remarks</a></li>
                        </ul>
                </div>
                    <div class="col-sm-11 col-sm-offset-1">
                        <hr>

                    <form class="form-horizontal">
                        <div id="account">
                            <h1>Account Information</h1>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Confirm Password</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control"  placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="company">
                            <h1>Company Details</h1>
                            <div class="form-group col-xs-12">
                                <label>Company Name</label>
                                <input type="text" class="form-control"  placeholder="Company Name">
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">Domicile</label>
                                <div class="col-sm-3">
                                    <select class="form-control"><option>Company</option></select>
                                </div>
                                <label class="col-sm-2 control-label">GST/VAT</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" placeholder="Input Your GST/VAT Number">
                                </div>
                            </div>
                            <div id="dirDetail" >
                                <div class="form-group" >
                                    <label class="col-sm-1 control-label">Directors</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" placeholder="Type the Name">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Type the NRIC or Passport Number">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control"><option>Company</option></select>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="inputBtnSection">
                                            <input id="uploadFile" class="disableInputField" placeholder="Upload Passport Photo" disabled="disabled" />
                                            <label class="fileUpload">
                                                <input id="uploadBtn" type="file" class="upload" />
                                                <span class="uploadBtn">Upload </span>
                                            </label>
                                        </div>

                                        <a  href="javascript:void(0);" id="addDD" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                    </div>
                                </div>
                            </div>  <hr>


                            <div class="form-group">
                                <label class="col-sm-3 control-label">Business Registration Number: </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder="Type Business Number">
                                </div>

                                <label class="col-sm-2 control-label">Business Registration Form</label>
                                <div class="col-sm-4">
                                    <div class="inputBtnSection">
                                        <input id="uploadFile" class="disableInputField" placeholder="Upload Document" disabled="disabled" />
                                        <label class="fileUpload">
                                            <input id="uploadBtn" type="file" class="upload" />
                                            <span class="uploadBtn">Upload </span>
                                        </label>
                                    </div>

                                    <a  href="javascript:void(0);" id="addBS" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                </div>
                            </div>
                            <div id="businessReg" > </div>

                        </div>
                        <hr>

                        <div id="contact">
                            <h1>Contact Details</h1>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contact Person: </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" >
                                </div>
                                <label class="col-sm-1 control-label">Office: </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" >
                                </div>
                                <label class="col-sm-1 control-label">Mobie: </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Website: </label>
                                <div class="col-sm-4 col-xs-10">
                                    <input type="text" class="form-control" placeholder="http://www.abc.com.my">
                                </div>
                                <div class="col-xs-1">
                                    <a  href="javascript:void(0);" id="addWS" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                </div>
                            </div>
                            <div id="website"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Social Media: </label>
                                <div class="col-sm-4 col-xs-10">
                                    <input type="text" class="form-control" placeholder="http://www.facebook.com/my">
                                </div>
                                <div class="col-xs-1">
                                    <a  href="javascript:void(0);" id="addSM" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                </div>
                            </div>
                            <div id="socialMedia">  </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Current eCommerce Site: </label>
                                <div class="col-sm-4 col-xs-10">
                                    <input type="text" class="form-control" placeholder="http://www.abc.com">
                                </div>
                                <div class="col-xs-1">
                                    <a  href="javascript:void(0);" id="addEcom" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                </div>
                            </div>
                            <div id="currEcom"> </div>

                            <div class="form-group">
                                <div class="col-sm-8">
                                    <label>Address</label>
                                    <input type="text" class="form-control" ><br>
                                    <input type="text" class="form-control" ><br>
                                    <input type="text" class="form-control" >
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <label class="col-sm-4 control-label">Zip Code: </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control"><br>
                                        </div>
                                        <label class="col-sm-4 control-label">City: </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control"><br>
                                        </div>
                                        <label class="col-sm-4 control-label">State: </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control"><br>
                                        </div>
                                        <label class="col-sm-4 control-label">Country: </label>
                                        <div class="col-sm-8">
                                            <select class="form-control"><option></option></select>
                                        </div>
                                    </div>
                                </div>
                            </div>  <hr>

                        </div>

                        <div id="shop">
                            <h1>Shop Details</h1>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Shop Name: </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Input your Shop/Display Name" >
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <label class="col-sm-3 control-label">Short Description: </label>
                                <div class="col-sm-6">
                                    <p class="text-muted">Provide us with a brief description of your business to help us</p>
                                    <textarea id="textarea" class="form-control"></textarea>
                                    <p class="text-muted">Number of Characters must not exceed 255</p>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <label class="col-sm-6 control-label">Do you have a license to sell/ or distribute the products/ services? </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="No" >
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <label class="col-sm-6 control-label">How do you supply Geographically? </label>
                                <div class="col-sm-6">
                                    <select class="form-control"><option>Locally</option></select>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <label class="col-sm-6 control-label">Do you own the brands for the products/services you are selling? </label>
                                <div class="col-sm-6">
                                    <select class="form-control"><option>Yes</option></select>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <label class="col-sm-6 control-label">What is the category of the products you are selling? </label>
                                <div class="col-sm-6">
                                    <select class="form-control"><option>Electronics</option></select>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <label class="col-sm-6 control-label">How many products you plan to sell? </label>
                                <div class="col-sm-6">
                                    <select class="form-control"><option>Less than 50</option></select>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                            </div>
                        </div>


                        <hr>

                        <h1>Brand Details</h1>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">What brand do you sell? </label>
                            <div class="col-sm-6 col-xs-10">
                                <input type="text" class="form-control" value="Sony">
                            </div>
                            <div class="col-xs-1">
                                <a  href="javascript:void(0);" id="addBD" class="text-green"><i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>
                        <div id="brandDetail"> </div> <hr>

                        <div class="bankdetail" id="bank">
                            <h1>Bank Details</h1>
                            <div class="form-group">  <label class="col-sm-2 control-label">Account Name </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Account Number </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Bank </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Bank Code </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">IBAN </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">SWIFT </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" >
                                </div>

                            </div>
                        </div>
                        <hr>


                        <div id="remark">
                            <h1>Remarks</h1>

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">Remarks </label>
                                        <div class="col-sm-10">
                                            <textarea id="textarea" class="form-control"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="remarks" class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Attachment </label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class="inputBtnSection">
                                            <input id="uploadFile" class="disableInputField" placeholder="Add New Attachment" disabled="disabled" />
                                            <label class="fileUpload">
                                                <input id="uploadBtn" type="file" class="upload" />
                                                <span class="uploadBtn">Upload </span>
                                            </label>
                                        </div>
                                        <a  href="javascript:void(0);" id="addRem" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                        <div class="pull-right">
                            <input type="submit" class="btn btn-green" value="Save">
                            <input type="submit" class="btn btn-green" value="Submit Registration Form">
                        </div>
                    </form>


                </div>
            </div>
        </div><!--End main cotainer-->
    </section>
	<script>
	document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};
	</script>
@stop