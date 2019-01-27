@extends('common.default')
@section('content')
<script type="text/javascript">
                            $(document).ready(function () {


                                $('.popup_fb_test').click(function () {
                                    newwindow = window.open("{{URL::route('testfbtoken')}}", 'Token Status', 'height=200,width=350');
                                    if (window.focus) {
                                        newwindow.focus()
                                    }
                                    setTimeout(function () {
                                        newwindow
                                                .close();
                                    }, 30000);
                                    return false;
                                });
                                $('.popup_fb_token').click(function () {
                                    newwindow = window.open("{{URL::route('fbtoken')}}", 'Link Token', 'height=400,width=auto');
                                    if (window.focus) {
                                        newwindow.focus()
                                    }
                                    return false;
                                });

                            });
                        </script>
					<div class="row">
					<div class="col-md-1"> </div>
					<div class="col-md-11">
						<div class="row">
				 		<a href="#" id ="smm" class="btn btn-blue col-md-3">Access Management</a>	
				 		<div id="clearfix"></div>
				 		</div>
				 		<div class="row bottom-margin-md">
				 			<h4>Facebook</h4>
				 			<button type="button" class="btn btn-primary  popup_fb_test"><span class="glyphicon glyphicon-thumbs-up"></span> Test</button>
				 				<button type="button" class="btn btn-primary  popup_fb_token"><span class="glyphicon glyphicon-link"></span> Link</button>
				 		</div>
					</div>
				</div>
@stop