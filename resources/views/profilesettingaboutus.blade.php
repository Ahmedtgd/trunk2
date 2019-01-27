@extends("common.default")

@section("content")

    <section class="profile-setting-header">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">

                <div class="col-sm-12 text-center">
                    <img alt="Profile Logo" src="/images/halabi-logo.png">
                </div>
                <div class="clearfix"></div>
            </div>
        </div><!--End main cotainer-->
    </section>
    <section class="profile-setting-body">

        @include('profilesettingnavigation')

        <div class="container">
            <div class="row">
        <div class="margin-top">
            <img alt="Profile Banner" class="img-responsive" src="/images/ProfileSettingAboutUs.png">
        </div>
        </div>
        </div>
        <div class="profile-setting-content"><!--Begin main cotainer-->
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4">
                    <h1 class="text-center" style="border-bottom: 2px solid #CA1F53">About Us</h1>
                    </div>
                <form class="form-horizontal">
                    <div class="col-xs-12 editorarea">

                        <p>Please Enter Information About O-Shop</p>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control" id="info-textarea" ></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 fieldarean">
                        <p>Please Enter Information About Team</p>
                        <div class="profile-field">
                            <div class="col-sm-2 profile-photo">
                                <img class="img-responsive"  id="preview-img" src="#" alt="Add Photo" />
                                <div class="inputBtnSection">
                                    <input id="uploadFile" class="disableInputField" placeholder="" disabled="disabled" />
                                    <label class="fileUpload">
                                        <input id="uploadBtn" type="file" class="upload" />
                                        <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" >
                            </div>

                                </div>
                                <div class="form-group">
                            <label class="col-sm-2 control-label">Position</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" >
                            </div>
                                </div>
                                <div class="form-group mbot0">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" ></textarea>
                            </div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <a class="text-green pull-right" id="addABlayer" href="javascript:void(0);"><i class="fa fa-plus-circle"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="append-about-field"> </div>


                </div>
                </form>
  <div class="clearfix"></div>
            </div>
            </div>
        </div><!--End main cotainer-->
    </section>

@stop