<?php
set_time_limit(0);
//use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;

/* Initialization & definition */
$globals = DB::table('global')->first();
$dtype = $status = null;
$dtype_rtr = null;
$m2b_status  ="B-Collected";
$b2m_status  ="M-Collected";

// $dstatus and $dstatus_rtr passed down from OrderApprovalController
if (!isset($dstatus) || empty($dstatus)) {
	$dstatus = null;
}
if (!isset($dstatus_rtr) || empty($dstatus_rtr)) {
	$dstatus_rtr = null;
}

if (isset($order) && !empty($order)) {
	$status      = $order->status;
}
if (isset($delivery) && !empty($delivery)) {
	$dtype       = $delivery->type;
}
if (isset($delivery_rtr) && !empty($delivery_rtr)) {
	$dtype_rtr   = $delivery_rtr->type;
}

/* SQUID DEBUG */
/*
$status      = "commented";
$dstatus     = "dfailed3";
$dtype       = "m2b";
$dstatus_rtr = "dfailed3";
$dtype_rtr   = "b2m"; 

dump('V:dtype_rtr='.$dtype_rtr);
dump('V:dstatus='.$dstatus);
dump('V:dstatus_rtr='.$dstatus_rtr);
*/

$m2b_status_array=[
	"pending","m-cancelled","b-cancelled","m-processing1",
	"m-processing2","l-processing","l-collected","b-collected"
];

$b2m_status_array=[
	"b-returning","request-goods","call-logistic1","l-processing1",
	"l-collected1","m-collected"
];

/* Array of statuses FROM L-Collected1 for B2M */
$post_b2m_status = ['l-collected1','m-collected','rejected2','reviewed2',
	'completed','commented','m-approved','rejected1','reviewed1'];

/* Array of statuses FROM L-Collected for M2B */
$post_m2b_status = array_merge(['l-collected','b-collected','b-returning',
	'request-goods','call-logistic1','l-processing1'],
	$post_b2m_status);

if (isset($order) && !empty($order)) {
	if (in_array($status,$m2b_status_array)) {
        $m2b_status=ucfirst($status);
    }

    if (in_array($status,$b2m_status_array)) {
        $b2m_status=ucfirst($status);
    } else {
        if (isset($delivery_rtr) and !empty($delivery_rtr)) {
            $b2m_status="M-Collected";
        } else {
            $b2m_status="";
        }
    }
}

$drec = [];
/* Capturing any M2B Delivery failures records.
   For M2B Delivery: record is in $delivery */
$drec['m2b'] = [];
if (isset($delivery) && !empty($delivery)) {
	/* M2B Delivery: Load up the dfailure records if available */
	try {
		/* Reading delivery failure recoreds for M2B Delivery process */
		$drec['m2b'] = DB::table('dfailure')->
			where('delivery_id',$delivery->id)->
			where('type',$dtype)->get();

	} catch (\Exception $e) {
		dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
	}
}

/* Capturing any B2M Return failures records.
   For B2M Return:   record is in $delivery_rtr */
$drec['b2m'] = [];
if (isset($delivery_rtr) && !empty($delivery_rtr)) {
	/* B2M Return: Load up the dfailure records if available */
	try {
		/* Reading delivery failure recoreds for M2B Delivery process */
		$drec['b2m'] = DB::table('dfailure')->
			where('delivery_id',$delivery_rtr->id)->
			where('type',$dtype_rtr)->get();

	} catch (\Exception $e) {
		dump($e->getFile().":".$e->getLine()."\n".$e->getMessage());
	}
} 

/*
dump($order);
dump($drec['m2b']);
dump($drec['b2m']);
dump(json_encode($drec['m2b']));
*/
?>

<style>
	/* If deal is completed, then it was not cancelled */
	.cancelled-completed {
        position: absolute;
        top: 300px;
        left: 0px; 
        padding-right: 20px;
        padding-left:  20px;
        padding-bottom: 5px;
        padding-top:    5px;
        background: #FFFFFF;
        border: 10px solid #FF3333;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }

    .cancelled-gray {
        position: absolute;
        top: 300px;
        left: 0px; 
        padding-right: 20px;
        padding-left:  20px;
        padding-bottom: 5px;
        padding-top:    5px;
        background: #FFFFFF;
        border: 10px solid #909090;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }

 	.mcancelled-completed {
        position: absolute;
        top: 170px;
        left: 70px; 
        padding-right: 20px;
        padding-left:  20px;
        padding-bottom: 5px;
        padding-top:    5px;
        background: #FFFFFF;
        border: 10px solid #FF3333;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }

    .mcancelled-gray {
        position: absolute;
        top: 170px;
        left: 70px; 
        padding-right: 20px;
        padding-left:  20px;
        padding-bottom: 5px;
        padding-top:    5px;
        background: #FFFFFF;
        border: 10px solid #909090;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }

 	.commented-completed {
        position: absolute;
        top:  220px;
        left:1230px; 
        padding-right:  5px;
        padding-left:   5px;
        padding-bottom:20px;
        padding-top:   20px;
        background: #FFFFFF;
        border: 10px solid #6666FF; 
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }

    .commented-gray {
        position: absolute;
        top:  220px;
        left:1230px; 
        padding-right:  5px;
        padding-left:   5px;
        padding-bottom:20px;
        padding-top:   20px;
        background: #FFFFFF;
        border: 10px solid #909090;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }

     .commented-white {
        position: absolute;
        top:  218px;
        left:1230px; 
        padding-right:  5px;
        padding-left:   5px;
        padding-bottom:25px;
        padding-top:   25px;
        background: #FFFFFF;
        border: 10px solid white;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }
 

     .commented-yellow {
        position: absolute;
        top:  220px;
        left:1230px; 
        padding-right:  5px;
        padding-left:   5px;
        padding-bottom:20px;
        padding-top:   20px;
        background: #FFFFFF;
        border: 10px solid yellow;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }
 
    .oval-completed {
        position: absolute;
        top: 210px;
        left: 1118px; 
        padding-right: 10px;
        padding-left: 10px;
        padding-bottom: 30px;
        padding-top: 30px;
        background: #FFFFFF;
        border: 10px solid #27A98A;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }

    .oval-gray {
        position: absolute;
        top: 210px;
        left: 1118px; 
        padding-right: 10px;
        padding-left: 10px;
        padding-bottom: 30px;
        padding-top: 30px;
        background: #FFFFFF;
        border: 10px solid #909090;
        border-top-right-radius: 50px;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
    }

	.retappr-gray {
		position: absolute;
		top:232px;
		left:605px;
		height:25px;
		width:25px;
		border: 5px solid #909090;
		background: #FFFFFF;
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
	}

 	.retappr-completed {
 		position: absolute;
		height:25px;
		width:25px;
		top:232px;
		left:605px;
		background: #FFFFFF;
		border: 5px solid #00CCFF;
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px; 
	}

 	.merappr-gray {
		position: absolute;
		height:25px;
		width:25px;
		top:232px;
		left:974px;
		background: #FFFFFF;
		border: 5px solid #909090;
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
	}

 	.merappr-completed {
		position: absolute;
		height:25px;
		width:25px;
		top:232px;
		left:974px;
		background: #FFFFFF;
		border: 5px solid #00CCFF;
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
	}

    .span3 {
        float: left;
        width: 18%;
        margin-left: 60px;
    }

    .well {
        min-height: 3.076923076923077% !important;
        border-color: black !important;
        border: solid;
        border-radius: 0 !important;
		height: 180px;
		display: flex;
		align-items: center;
    }

	dl {
	  width: 100%;
	  overflow: hidden;
	  background: #ff0;
	  padding: 0;
	  margin: 0
	}

	dt {
	  float: left;
	  width: 50%;
	  /* adjust the width; make sure the total of both is 100% */
	  background: #cc0;
	  padding: 0;
	  margin: 0
	}

	dd {
	  float: left;
	  width: 50%;
	  /* adjust the width; make sure the total of both is 100% */
	  background: #dd0
	  padding: 0;
	  margin: 0
	}
</style>

@include('common.head')
@section('extra-links')
@endsection

<div id="safariAlert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <b id="safari">Safari Detected</b>
                <b id="resoloution">Screen Resoloution</b>
                <button type="button" class="close"
					data-dismiss="modal">&times;</button>
            </div>
            <div id="sign-modal-body" style="text-align: center">
                <p id="safariMsg">Please switch to supported browser for Graphical Status View</p>
                <p id="resoloutionMsg">Please switch to appropriate screen resoloution for Graphical Status View</p>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-default reload"
                   data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<div id="signaturePopup" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <b>Delivery to Buyer: </b>Signature
                <button type="button" class="close"
					data-dismiss="modal">&times;</button>
            </div>
            <div id="sign-modal-body">
                @if(isset($order) && isset($nv_image))
                <img src="{{url('images/pod/'.$nv_image)}}"
                     width="100%" height="auto" alt="signatures" />
                @endif
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-default reload"
                   data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>
{{-- Signature PopUp for the 2nd box B2M --}}
<div id="signaturePopup_rtr" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <b>Delivery to Merchant: </b>Signature
                <button type="button" class="close"
					data-dismiss="modal">&times;</button>
            </div>
            <div id="sign-modal-body">
                @if(isset($order) and isset($nv_image_rtr))
                <img src="{{url('images/pod/'.$nv_image_rtr)}}"
                     width="100%" height="auto" alt="signatures" />
                @endif
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-default reload"
                   data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="margin-top:30px;">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>Graphical Status View</h2>
            <canvas width="1700" height="450" id="mrtCanvas"></canvas>

            <div class="row-fluid" id="securities">
                <div class="span12">
                    <div class="row-fluid">
                        <hr/>
                        <div class="span3">
							<b>Delivery to Buyer:</b> Signature</div>
                        <div class="span3">
							<b>Return to Seller:</b> Signature</div>
                        <div class="span3">Fourth Security:</div>
                        <div class="span3">Fifth Security:</div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3" id="signature">
                            <div class="well">
								@if(isset($order))
									<?php 
									/* Need to figure out if we are using NinjaVan */
									if (isset($nv_image) && !empty($nv_image)) {
										// We are using NinjaVan, using
										// POD from their Webhook
										$file = url('images/pod/'.$nv_image);

									} else {
										// We are NOT using NinjaVan 
										$file = url('images/pod/'.$order->id.
											'-'.$order->do_password.'.png');
									}
									$file_headers = @get_headers($file);
									?>

									@if($file_headers &&
										$file_headers[0] == 'HTTP/1.1 200 OK') 
										<img src="{{$file}}"
                                         alt="signatures" width="100%"
										 	height="auto"/>
									@else
										<h4><b>No Signature</b></h4>
									@endif
								@else
									<h4><b>No Signature</b></h4>
								@endif
                            </div>
							@if(isset($order))
									
                            <table style="font-size: 14px;">
                                <tr>
                                    <td><b>Name:</b></td>
                                    <td>
                                        @if(!is_null($delivery))
                                        @if($delivery->pickup_name != "" &&
										!is_null($delivery->pickup_name ))
                                             {{$delivery->pickup_name}}
                                        @endif
                                    
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>NRIC:</b></td>
                                    <td>
									@if(!is_null($delivery))
                                        @if($delivery->pickup_nric != "" &&
										!is_null($delivery->pickup_nric ))
                                             {{$delivery->pickup_nric}}
                                        @endif
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Acquired:</b></td><td>
                                    {{UtilityController::s_date($acquired_time)}}</td>
                                </tr>
                                <tr>
                                    <td><b>Tracking&nbsp;ID:&nbsp;&nbsp;</b></td>
									<td>
									@if(!is_null($delivery))
									@if($delivery->consignment_number != "" &&
									!is_null($delivery->consignment_number ))
										 {{$delivery->consignment_number}}
									@endif
                                    @endif
									</td>
                                </tr>
                                <tr>
                                    <td><b>Status:</b></td>
									<td>{{$m2b_status}}</td>
                                </tr>
                            </table>
                            @endif
                        </div>
                        <div class="span3" id="signature_rtr">
                             <div class="well">
                                @if(isset($order))
                                    <?php 
                                    /* Need to figure out if we are
									   using NinjaVan */
                                    if (isset($nv_image_rtr) &&
										!empty($nv_image_rtr)) {
                                        // We are using NinjaVan, using
										// POD from their Webhook
                                        $file = url('images/pod/'.
											$nv_image_rtr);

                                    } else {
                                        // We are NOT using NinjaVan 
                                        $file = url('images/pod/'.$order->id.
											'-'.$order->do_password.'.png');
                                    }
                                    $file_headers = @get_headers($file);
                                    ?>

                                    @if($file_headers &&
                                        $file_headers[0] == 'HTTP/1.1 200 OK') 
                                        <img src="{{$file}}"
                                         alt="signatures" width="100%" height="auto"/>
                                    @else
                                        <h4><b>No Signature</b></h4>
                                    @endif
                                @else
                                    <h4><b>No Signature</b></h4>
                                @endif
                            </div>
                            @if(isset($order))
                            <table style="font-size: 14px;">
                                <tr>
                                    <td><b>Name:</b></td>
                                    <td>
                                        @if(!is_null($delivery_rtr))
                                        @if($delivery_rtr->pickup_name != "" &&
                                        !is_null($delivery_rtr->pickup_name ))
                                             {{$delivery_rtr->pickup_name}}
                                        @endif
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>NRIC:</b></td>
                                
                                    <td>
                                    @if(!is_null($delivery_rtr))
                                        @if($delivery_rtr->pickup_nric != "" &&
                                        !is_null($delivery_rtr->pickup_nric ))
                                             {{$delivery_rtr->pickup_nric}}
                                        @endif
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Acquired:</b></td><td>
                                    {{UtilityController::s_date($acquired_time_rtr)}}</td>
                                </tr>
                                <tr>
                                    <td><b>Tracking&nbsp;ID:&nbsp;&nbsp;</b></td>
                                    <td>
                                    @if(!is_null($delivery_rtr))
                                    @if($delivery_rtr->consignment_number != "" &&
                                    !is_null($delivery_rtr->consignment_number ))
                                         {{$delivery_rtr->consignment_number}}
                                    @endif
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Status:</b></td>
                                    <td>{{$b2m_status}}</td>
                                </tr>
                            </table>
                            @endif
                        </div>
                        <div class="span3">
                            <div class="well"></div>
                        </div>
                        <div class="span3">
                            <div class="well"></div>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($role) && $role == 'adm')
                <p class="text-center" style="clear:both">
                    <br>
                    @if(!empty($status) &&
                            (   $status === 'commented' ||
                                $status === 'completed' ||
                                $status === 'reviewed1' ||
                                $status === 'reviewed2'))
						<a class='btn btn-info' do_status='rejected'
							disabled="disable"
							href='javascript:void(0)'>Manual </a>
                    @else
                        <a class='btn btn-info manual_button'
							do_status='rejected'
							current_id='{{ isset($oid) ? $oid : "" }}'
							href='javascript:void(0)'>Manual </a>
                    @endif
                </p>
            @endif
        </div>
    </div>
</div>

<meta name="_token" content="{!! csrf_token() !!}"/>

<script type="text/javascript">
    $(document).ready(function () {
        $('.preventDefault').click(function (e) {
            e.preventDefault();
        });
        $('[data-toggle="popover"]').popover();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        var role = "{{ isset($role) ? $role : '' }}";

        $('#safari').hide();
        $('#safariMsg').hide();
        $('#resoloution').hide();
        $('#resoloutionMsg').hide();

        var req_width = 300;
        var req_height = 300;
        //screen.width,screen.height;

        if(screen.width < req_width || screen.height <  req_height)
            invalid();

        // Safari 3.0+ "[object HTMLElementConstructor]"
        var isSafari = /constructor/i.test(window.HTMLElement) || (function (p)
		{
			if(p != null)
				return p.toString() === "[object SafariRemoteNotification]";
			else
				return false;
		}) (!window['safari'] || safari.pushNotification);

        if(isSafari)
            invalid();

        function invalid()
        {
            if(isSafari){
                $('#safari').show();
                $('#safariMsg').show();
            }else{
                $('#resoloution').show();
                $('#resoloutionMsg').show();
            }

            $('#securities').hide();

            if (role == "adm")
                $('.manual_button').hide();

            $('#safariAlert').modal('show').fadeIn("slow");
            return;
        }

        var formSubmitType = null;
        $(document).delegate('.manual_button', "click", function (event) {
            $.ajax({
                type: "POST",
                url: JS_BASE_URL + "/admin/master/order/manual/" +
					$(this).attr("current_id"),
                success: function (data) {
                    //toastr.info(data);
                    toastr.info("Status successfully changed!");
                },
                error: function (error) {
                    toastr.warning("An unexpected error ocurred!");
                    //console.log(error);
                }

            });
        });
        
		$("#signature").click(function () {
			$('#signaturePopup').modal('show').fadeIn("slow");
		});
		$("#signature_rtr").click(function () {
			$('#signaturePopup_rtr').modal('show').fadeIn("slow");
		})
       
    });		// THIS LINE IS REQUIRED!
</script>

<script>
    $(function () {
        var starting = 30;
        var centerLine = 500 / 2;
        var vRectWidth = 15;
        var vRectHeight = 60;

        var hRectWidth = 60;
        var hRectHeight = 20;
        //        var centerX = 1000 / 2;
        var vRectStart = centerLine - (vRectHeight / 2);
        var vRectEnd = centerLine + (vRectHeight / 2);
        var lineLen = 70;
        var circleSize = 11;
        var squareSize = (3*circleSize);
        var vline = 90;
        var text = 25;
        var DGRAY  = '#909090';
        var LGRAY  = '#CCCCCC';
        var WHITE  = '#FFFFFF';
		var BLUE   = "#00CCFF";
		var GREEN  = "#00CC00";
		var RED    = "#FF3333";
		var GOLD   = "#EFC11C";
		var OSGRN  = "#27A98A"; 
		var PURPLE = "#6666FF"; 

		/* Pull porder.status from DB */
        var status      = "{{$status}}";
        var dstatus     = "{{$dstatus}}";
        var dtype       = "{{$dtype}}";
        var dstatus_rtr = "{{$dstatus_rtr}}";
        var dtype_rtr   = "{{$dtype_rtr}}";

 		// Array of comments 
		@if (isset($comment))
			var comment = <?php echo json_encode($comment); ?>;
		@endif

 		// Array of statuses AFTER L-Collected1 for B2M
		var post_b2m_status = <?php echo json_encode($post_b2m_status); ?>;

 		// Array of statuses AFTER L-Collected for M2B
		var post_m2b_status = <?php echo json_encode($post_m2b_status); ?>;

		var dts1 = []; var dts2 = []; var dts3 = [];
		var dcm1 = []; var dcm2 = []; var dcm3 = [];

		/* Pull delivery failures for both M2B and B2M */
		var jm2b = <?php echo json_encode($drec['m2b']); ?>;
		var jb2m = <?php echo json_encode($drec['b2m']); ?>;

		/* M2B Delivery Failures:
		   Initialize structures for both timestamps and comments for M2B */
		dts1['m2b'] = null; dcm1['m2b'] = null;
		dts2['m2b'] = null; dcm2['m2b'] = null;
		dts3['m2b'] = null; dcm3['m2b'] = null;

 		/* B2M Return Failures:
		   Initialize structures for both timestamps and comments for B2M */
		dts1['b2m'] = null; dcm1['b2m'] = null;
		dts2['b2m'] = null; dcm2['b2m'] = null;
		dts3['b2m'] = null; dcm3['b2m'] = null;
 
		/* M2B Delivery Failures: Transferring M2B data from PHP array */
		if (jm2b[0] && jm2b[0]['failure_timestamp']) {
			dts1['m2b'] = jm2b[0]['failure_timestamp'];
		}
		if (jm2b[1] && jm2b[1]['failure_timestamp']) {
			dts2['m2b'] = jm2b[1]['failure_timestamp'];
		}
		if (jm2b[2] && jm2b[2]['failure_timestamp']) {
			dts3['m2b'] = jm2b[2]['failure_timestamp'];
		}
 		if (jm2b[0] && jm2b[0]['failure_comment']) {
			dcm1['m2b'] = jm2b[0]['failure_comment'];
		}
		if (jm2b[1] && jm2b[1]['failure_comment']) {
			dcm2['m2b'] = jm2b[1]['failure_comment'];
		}
		if (jm2b[2] && jm2b[2]['failure_comment']) {
			dcm3['m2b'] = jm2b[2]['failure_comment'];
		}


		/* B2M Delivery Failures: Transferring B2M data from PHP array */
		if (jb2m[0] && jb2m[0]['failure_timestamp']) {
			dts1['b2m'] = jb2m[0]['failure_timestamp'];
		}
		if (jb2m[1] && jb2m[1] && jb2m[1]['failure_timestamp']) {
			dts2['b2m'] = jb2m[1]['failure_timestamp'];
		} 
		if (jb2m[2] && jb2m[2]['failure_timestamp']) {
			dts3['b2m'] = jb2m[2]['failure_timestamp'];
		}
 		if (jb2m[0] && jb2m[0]['failure_comment']) {
			dcm1['b2m'] = jb2m[0]['failure_comment'];
		}
		if (jb2m[1] && jb2m[1]['failure_comment']) {
			dcm2['b2m'] = jb2m[1]['failure_comment'];
		}
		if (jb2m[2] && jb2m[2]['failure_comment']) {
			dcm3['b2m'] = jb2m[2]['failure_comment'];
		}
 
		/* This stores the previous node prior to M-Approved; this has 2
		 * possibilites: B-Returning, M-Collected */
		var prev_m_approved = "{{isset($order) ? $order->prev_m_approved: ""}}";

		/* This stores the previous node prior to Completed; this has 3
		 * possibilities: Reviewed, M-Approved, Reviewed1 */
		var	prev_completed = "{{isset($order) ? $order->prev_completed : ""}}";

        var Pending, Cancelled, M_Cancelled, M_Processing1, M_Processing2,
			L_Processing, L_Collected, L_Collected1, B_Collected, B_Returning1, 
			Rejected, Rejected2, L_Accepted, B_Returning2, M_Collected,
			circle_request_goods, circle_call_logistic1,
			circle_l_processing1, circle_l_collected1, circle_m_collected;
        var Reviewed2, Reviewed, MApprovedToCompleted, BCollectedToCompleted;
		var BCollectedToReturning, BReturningToMApproved,
			BReturningToRequestGoods, CallLogistic1ToLProcessing1,
			LProcessing1ToLCollected1, LCollected1ToMCollected,
			RejectedToReviewed1, MCollectedToRejected2, MCollectedToMApproved,
			Rejected2ToReviewed2, BReturningToRejected1, Rejected1ToReviewed1,
			Reviewed1ToCompleted;

		var Reviewed2ToCompleted, ReviewedToCompleted, CompletedToCommented;
        var Circle_B_Collected, Circle_Rejected2, Circle_Reviewed1,
			Circle_Reviewed2, Circle_Rejected1;

        var circle_pending, circle_m_processing1, circle_m_processing2,
			circle_l_processing, circle_l_collected;

        circle_pending = circle_m_processing1 = circle_m_processing2 =
			circle_l_processing = circle_l_collected = circle_request_goods =
			circle_call_logistic1 = DGRAY;

        var BuyerWinR1 = DGRAY, SellerWinR1 = DGRAY, BuyerWinR2 = DGRAY,
			SellerWinR2 = DGRAY;
        var completed_cancelled = '.cancelled-gray';
        var completed_mcancelled = '.mcancelled-gray';
        var completed_commented = '.commented-gray';
        var completed_retappr	= '.retappr-gray';
        var completed_merappr	= '.merappr-gray';
        var completed_shape 	= '.oval-gray';


        Reviewed2ToCompleted = ReviewedToCompleted = LGRAY;
        Pending = Cancelled = M_Cancelled = M_Processing1 = M_Processing2 =
			L_Processing = L_Collected = L_Collected1 = B_Collected =
			B_Returning1 = CompletedToCommented = B_Returning2 =
			L_Processing1 = L_Accepted = M_Collected = DGRAY;

        circle_l_processing1 = circle_l_collected1 = circle_m_collected =
			Circle_B_Collected = DGRAY;

        BCollectedToReturning = BReturningToMApproved =
			BReturningToRequestGoods = CallLogistic1ToLProcessing1 = 
			LProcessing1ToLCollected1 = LCollected1ToMCollected = 
			RequestGoodsToCallLogistic1 = MApprovedToCompleted =
			MCollectedToMApproved = DGRAY;

		Circle_Reviewed1 = Circle_Reviewed2 = Circle_Rejected2 =
			Circle_Rejected1 = LGRAY;
		MCollectedToRejected2 = RejectedToReviewed1 = Rejected2ToReviewed2 =
			BReturningToRejected1 = Rejected1ToReviewed1 =
			Reviewed1ToCompleted = LGRAY;
        Reviewed1 = Reviewed2 = Rejected2 = Rejected = LGRAY;

        /* Path processing and DGRAY setting */
		// Squidster: DEBUG START

		/*
		prev_m_approved  = 'm-collected';
		prev_completed   = 'reviewed1';
		status      = 'l-collected';
		dstatus     = 'dfailed3';
		dstatus_rtr = 'dfailed3';
		*/

		/* Start bypass processing: Note that this is just a visual bypass
		 * as the status still remains */
		switch (status) {
			case "rejected1":
				status = "reviewed1";
				break;
			case "rejected2":
				status = "reviewed2";
				break;
			default:
		}
	
		/* Primary switch statement */
        switch (status) {
            case 'b-cancelled':
                Cancelled = RED;
				completed_cancelled = ".cancelled-completed";
                break; 
             case 'pending':
                Pending = BLUE;
                circle_pending = BLUE;
                break; 
             case 'm-cancelled':
                M_Cancelled = RED;
				Pending = RED;
				circle_pending = RED;
				completed_mcancelled = ".mcancelled-completed";
                break;  
            case 'm-processing1':
                Pending = M_Processing1 = BLUE;
                circle_pending = circle_m_processing1 = BLUE;
                break;
            case "m-processing2":
                Pending = M_Processing1 = M_Processing2 = BLUE;
                circle_pending = circle_m_processing1 =
					circle_m_processing2 = BLUE;
                break;
            case "l-processing":
                Pending = M_Processing1 = M_Processing2 =
					L_Processing = BLUE;
                circle_pending = circle_m_processing1 =
					circle_m_processing2 = circle_l_processing = BLUE;
                break;
            case "l-collected":
                Pending = M_Processing1 = M_Processing2 =
					L_Processing = L_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
                        circle_l_processing = circle_l_collected = BLUE;
                break;
            case "b-collected":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 =
					circle_m_processing2 = circle_l_processing =
					circle_l_collected = Circle_B_Collected = BLUE;
                break;
            case "b-returning":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				completed_retappr = ".retappr-completed";
				prev_m_approved = "b-returning";
                break;
             case "request-goods":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				BReturningToRequestGoods = GREEN;
				circle_request_goods = GREEN;
				completed_retappr = ".retappr-completed";
                break; 
             case "m-approved":
			 	/* Now there are 2 possibilities of arriving at M-Approved;
				 * from the east, B-Returning and from the north M-Collected.
				 * Depending on which path, the path is colored differently */
				if (prev_m_approved == 'b-returning') {
					Pending = M_Processing1 = M_Processing2 = L_Processing =
						L_Collected = B_Collected =
						BLUE;
					circle_pending = circle_m_processing1 =
						circle_m_processing2 = circle_l_processing =
						circle_l_collected = BCollectedToReturning =
						Circle_B_Collected = BReturningToMApproved =
						BLUE;
					completed_retappr = ".retappr-completed";
					completed_merappr = ".merappr-completed";
				} else {
					/* m-collected */
					Pending = M_Processing1 = M_Processing2 =
						L_Processing = L_Collected = B_Collected =
						BLUE;
					circle_pending = circle_m_processing1 =
						circle_m_processing2 = circle_l_processing =
						circle_l_collected = BCollectedToReturning =
						Circle_B_Collected =
						BLUE;
					L_Collected1 = M_Collected =
						GREEN;
					circle_request_goods = circle_call_logistic1 =
						circle_l_processing1 = circle_l_collected1 =
						circle_m_collected =
						GREEN;
					BReturningToRequestGoods = RequestGoodsToCallLogistic1 =
						CallLogistic1ToLProcessing1 =
						LProcessing1ToLCollected1 =
						LCollected1ToMCollected = 
						MCollectedToMApproved = 
						GREEN;
					completed_retappr = ".retappr-completed";
					completed_merappr = ".merappr-completed";
					prev_m_approved = 'm-collected'; 
				}
                break; 
            case "call-logistic1":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				BReturningToRequestGoods = RequestGoodsToCallLogistic1 = GREEN;
				circle_request_goods = circle_call_logistic1 = GREEN;
				completed_retappr = ".retappr-completed";
                break;

            case "l-processing1":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				circle_request_goods = circle_call_logistic1 =
					circle_l_processing1 = GREEN;
				BReturningToRequestGoods = RequestGoodsToCallLogistic1 =
					CallLogistic1ToLProcessing1 = GREEN;
				completed_retappr = ".retappr-completed";
                break;

             case "l-collected1":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				L_Collected1 = GREEN;
				circle_request_goods = circle_call_logistic1 =
					circle_l_processing1 = circle_l_collected1 = GREEN;
				BReturningToRequestGoods = RequestGoodsToCallLogistic1 =
					CallLogistic1ToLProcessing1 = LProcessing1ToLCollected1 =
					GREEN;
				completed_retappr = ".retappr-completed";
                break;

             case "m-collected":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				L_Collected1 = M_Collected = GREEN;
				circle_request_goods = circle_call_logistic1 =
					circle_l_processing1 = circle_l_collected1 =
					circle_m_collected = GREEN;
				BReturningToRequestGoods = RequestGoodsToCallLogistic1 =
					CallLogistic1ToLProcessing1 = LProcessing1ToLCollected1 =
					LCollected1ToMCollected = 
					GREEN;
				completed_retappr = ".retappr-completed";
				prev_m_approved = 'm-collected';
                break;
 
            case "rejected1":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				BReturningToRejected1 = RED;
				Circle_Rejected1 = RED;
				completed_retappr = ".retappr-completed";
                break;

            case "completed":
				completed_shape = ".oval-completed";
				switch(prev_completed) {
					case "reviewed2":
						Reviewed2ToCompleted = GOLD;
					    Pending = M_Processing1 = M_Processing2 =
						 	L_Processing = L_Collected = B_Collected = BLUE;
						circle_pending = circle_m_processing1 =
							circle_m_processing2 = circle_l_processing =
							circle_l_collected = BCollectedToReturning =
							Circle_B_Collected = BLUE;
						L_Collected1 = M_Collected = GREEN;
						circle_request_goods = circle_call_logistic1 =
							circle_l_processing1 = circle_l_collected1 =
							circle_m_collected = GREEN;
						BReturningToRequestGoods = RequestGoodsToCallLogistic1=
							CallLogistic1ToLProcessing1 =
							LProcessing1ToLCollected1 =
							LCollected1ToMCollected = GREEN;
						MCollectedToRejected2 = Rejected2ToReviewed2 =
							Circle_Rejected2 = RED;
						Circle_Reviewed2 = GOLD;
						completed_retappr = ".retappr-completed";
						break;

					case "m-approved":
						MApprovedToCompleted = BLUE;
						completed_merappr = ".merappr-completed";
						switch(prev_m_approved) {
							case "m-collected":
								MCollectedToMApproved = GREEN;
								Pending = M_Processing1 = M_Processing2 =
									L_Processing = L_Collected = B_Collected =
									BLUE;
								circle_pending = circle_m_processing1 =
									circle_m_processing2 = circle_l_processing=
									circle_l_collected = BCollectedToReturning=
									Circle_B_Collected = BLUE;
								L_Collected1 = M_Collected = GREEN;
								circle_request_goods = circle_call_logistic1 =
									circle_l_processing1 = circle_l_collected1=
									circle_m_collected = GREEN;
								BReturningToRequestGoods =
									RequestGoodsToCallLogistic1 =
									CallLogistic1ToLProcessing1 =
									LProcessing1ToLCollected1 =
									LCollected1ToMCollected = GREEN; 
								completed_retappr = ".retappr-completed";
								break;

							case "b-returning":
								BReturningToMApproved = BLUE;
								Pending = M_Processing1 = M_Processing2 =
									L_Processing = L_Collected =
									B_Collected = BLUE;
								circle_pending = circle_m_processing1 =
									circle_m_processing2 = circle_l_processing=
									circle_l_collected = BCollectedToReturning=
									Circle_B_Collected = BLUE;
								completed_retappr = ".retappr-completed";
								break;
							default:
						}
						break;

					case "reviewed1":
						Reviewed1ToCompleted = GOLD;
						Pending = M_Processing1 = M_Processing2 =
							L_Processing = L_Collected = B_Collected = BLUE;
						circle_pending = circle_m_processing1 =
							circle_m_processing2 = circle_l_processing =
							circle_l_collected = BCollectedToReturning =
							Circle_B_Collected = BLUE;
						BReturningToRejected1 = Rejected1ToReviewed1 = RED;
						Circle_Rejected1 = RED;
						Circle_Reviewed1 = GOLD;
						completed_retappr = ".retappr-completed"; 
						break; 

				   default:
				}
				break;

            case "commented":
				completed_commented = ".commented-yellow";
				CompletedToCommented = PURPLE;
 				completed_shape = ".oval-completed";
				switch(prev_completed) {
					case "reviewed2":
						Reviewed2ToCompleted = GOLD;
					    Pending = M_Processing1 = M_Processing2 =
						 	L_Processing = L_Collected = B_Collected = BLUE;
						circle_pending = circle_m_processing1 =
							circle_m_processing2 = circle_l_processing =
							circle_l_collected = BCollectedToReturning =
							Circle_B_Collected = BLUE;
						L_Collected1 = M_Collected = GREEN;
						circle_request_goods = circle_call_logistic1 =
							circle_l_processing1 = circle_l_collected1 =
							circle_m_collected = GREEN;
						BReturningToRequestGoods = RequestGoodsToCallLogistic1=
							CallLogistic1ToLProcessing1 =
							LProcessing1ToLCollected1 =
							LCollected1ToMCollected = GREEN;
						MCollectedToRejected2 = Rejected2ToReviewed2 =
							Circle_Rejected2 = RED;
						Circle_Reviewed2 = GOLD;
						completed_retappr = ".retappr-completed";
						break;

					case "m-approved":
						MApprovedToCompleted = BLUE;
						completed_merappr = ".merappr-completed";
						switch(prev_m_approved) {
							case "m-collected":
								MCollectedToMApproved = GREEN;
								Pending = M_Processing1 = M_Processing2 =
									L_Processing = L_Collected = B_Collected =
									BLUE;
								circle_pending = circle_m_processing1 =
									circle_m_processing2 = circle_l_processing=
									circle_l_collected = BCollectedToReturning=
									Circle_B_Collected = BLUE;
								L_Collected1 = M_Collected = GREEN;
								circle_request_goods = circle_call_logistic1 =
									circle_l_processing1 = circle_l_collected1=
									circle_m_collected = GREEN;
								BReturningToRequestGoods =
									RequestGoodsToCallLogistic1 =
									CallLogistic1ToLProcessing1 =
									LProcessing1ToLCollected1 =
									LCollected1ToMCollected = GREEN; 
								completed_retappr = ".retappr-completed";
								break;

							case "b-returning":
								BReturningToMApproved = BLUE;
								Pending = M_Processing1 = M_Processing2 =
									L_Processing = L_Collected =
									B_Collected = BLUE;
								circle_pending = circle_m_processing1 =
									circle_m_processing2 = circle_l_processing=
									circle_l_collected = BCollectedToReturning=
									Circle_B_Collected = BLUE;
								completed_retappr = ".retappr-completed";
								break;
							default:
						}
						break;

					case "reviewed1":
						Reviewed1ToCompleted = GOLD;
						Pending = M_Processing1 = M_Processing2 =
							L_Processing = L_Collected = B_Collected = BLUE;
						circle_pending = circle_m_processing1 =
							circle_m_processing2 = circle_l_processing =
							circle_l_collected = BCollectedToReturning =
							Circle_B_Collected = BLUE;
						BReturningToRejected1 = Rejected1ToReviewed1 = RED;
						Circle_Rejected1 = RED;
						Circle_Reviewed1 = GOLD;
						completed_retappr = ".retappr-completed"; 
						break; 

				   default:
				}
				break; 

            case "rejected2":
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				L_Collected1 = M_Collected = GREEN;
				circle_request_goods = circle_call_logistic1 =
					circle_l_processing1 = circle_l_collected1 =
					circle_m_collected = GREEN;
				BReturningToRequestGoods = RequestGoodsToCallLogistic1 =
					CallLogistic1ToLProcessing1 = LProcessing1ToLCollected1 =
					LCollected1ToMCollected = GREEN;
				MCollectedToRejected2 = RED;
				Circle_Rejected2 = RED;
				completed_retappr = ".retappr-completed";
				prev_m_approved = 'm-collected';
                break;

            case 'reviewed1':
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				BReturningToRejected1 = Rejected1ToReviewed1 = RED;
				Circle_Rejected1 = RED;
				Circle_Reviewed1 = GOLD;
				completed_retappr = ".retappr-completed"; 
                break;

            case 'reviewed2':
                Pending = M_Processing1 = M_Processing2 = L_Processing =
					L_Collected = B_Collected = BLUE;
                circle_pending = circle_m_processing1 = circle_m_processing2 =
					circle_l_processing = circle_l_collected =
					BCollectedToReturning = Circle_B_Collected = BLUE;
				L_Collected1 = M_Collected = GREEN;
				circle_request_goods = circle_call_logistic1 =
					circle_l_processing1 = circle_l_collected1 =
					circle_m_collected = GREEN;
				BReturningToRequestGoods = RequestGoodsToCallLogistic1 =
					CallLogistic1ToLProcessing1 = LProcessing1ToLCollected1 =
					LCollected1ToMCollected = GREEN;
				MCollectedToRejected2 = Rejected2ToReviewed2 =
					Circle_Rejected2 = RED;
				Circle_Reviewed2 = GOLD;
				completed_retappr = ".retappr-completed";
				prev_m_approved = 'm-collected';
        }


        /* Start drawing MRT diagram */
        writeText("Start", starting, centerLine - text);
        
        // Pending
        drawLine(starting, centerLine, starting + lineLen,
                centerLine, Pending);

        nextElement = starting;
 		drawLine(nextElement, centerLine + circleSize, nextElement,
                centerLine + 50, Cancelled);		
        drawCircle(starting, centerLine, circleSize, 1, PURPLE);
		origami("#mrtCanvas").styles(completed_cancelled).
			shape(completed_cancelled).draw();
        writeText('Buyer', nextElement, centerLine+text+65);
        writeText('Cancelled',nextElement,centerLine+text+65+circleSize);
        writeText('(B-Cancelled)',nextElement,centerLine+text+65+(2*circleSize));
        nextElement = starting + lineLen;
				
        // 1. Pending circle
        writeText('Pending', nextElement, centerLine + text);
        writeText('(M-Cancelled)', nextElement, centerLine-90);
        writeText('Cancelled', nextElement, centerLine-90-circleSize);
        writeText('Merchant', nextElement, centerLine-90-(2*circleSize));
 		drawLine(nextElement, centerLine + circleSize, nextElement,
                centerLine - 50, M_Cancelled);		
		origami("#mrtCanvas").styles(completed_mcancelled).
			shape(completed_mcancelled).draw();


        // M_Processing1
        drawLine(nextElement + circleSize, centerLine, nextElement + lineLen,
                centerLine, M_Processing1);
        drawCircle(nextElement, centerLine, circleSize, 1, circle_pending);
        nextElement += lineLen;

        // 2. circle
        drawCircle(nextElement,centerLine,circleSize,1,circle_m_processing1);
        writeText('Merchant',nextElement,centerLine+text);
        writeText('Accepted',nextElement,centerLine+text+circleSize);
        writeText('(M-Processing1)',nextElement,centerLine+text+(2*circleSize));

        // M_Processing2
        drawLine(nextElement + circleSize, centerLine, nextElement + lineLen,
                centerLine, M_Processing2);
        nextElement += lineLen;

        // 3. circle
		drawCircle(nextElement,centerLine,circleSize,1,circle_m_processing2);
        writeText('(M-Processing2)',nextElement,centerLine-text);
        writeText('Logistic',nextElement,centerLine-text-circleSize);
        writeText('Call',nextElement,centerLine-text-(2*circleSize));
        writeText('Merchant',nextElement,centerLine-text-(3*circleSize));

        // L_Processing
        drawLine(nextElement + circleSize, centerLine, nextElement + lineLen,
                centerLine, L_Processing);
        nextElement += lineLen;

        // 4. circle
        drawCircle(nextElement,centerLine,circleSize,1,circle_l_processing);
        writeText('Logistic',nextElement,centerLine+text);
        writeText('Accepted',nextElement,centerLine+text+circleSize);
        writeText('(L-Processing)',nextElement,centerLine+text+(2*circleSize));

        // L_Collected
        drawLine(nextElement + circleSize, centerLine, nextElement + lineLen,
			centerLine, L_Collected);

		// Pickup Failure Attempts: #1,2,3
        nextElement += (lineLen/2);
        drawFilledCircle(nextElement, centerLine, circleSize, 1,
			circle_l_collected);
        writeBoldText("1", nextElement, centerLine, WHITE);
        nextElement += (2*circleSize);
        drawFilledCircle(nextElement, centerLine, circleSize, 1,
			circle_l_collected);
        writeBoldText("2", nextElement, centerLine, WHITE);
        nextElement += (2*circleSize);
        drawFilledCircle(nextElement, centerLine, circleSize, 1,
			circle_l_collected);
        writeBoldText("3", nextElement, centerLine, WHITE);
        drawLine(nextElement + circleSize, centerLine, nextElement +
			(lineLen/2), centerLine, L_Collected);
        nextElement += (lineLen/2);

        // 5. circle
        drawCircle(nextElement, centerLine, circleSize, 1, circle_l_collected);
        writeText('(L-Collected)', nextElement, centerLine-text);
        writeText('Collected', nextElement, centerLine-text-circleSize);
        writeText('Logistic', nextElement, centerLine-text-(2*circleSize));

 		// M2B Delivery Failure Attempts: #1,2,3
//		if (status == "l-collected") {
		if (post_m2b_status.includes(status)) {
			switch(dstatus) {
				case "dfailed1":
					drawLine(nextElement + circleSize, centerLine,
						nextElement + (lineLen/2), centerLine, L_Collected);
 					nextElement += (lineLen/2);
					nextElement += (2*circleSize);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						Circle_B_Collected);
					writeBoldText("2", nextElement, centerLine, WHITE);

					nextElement -= (2*circleSize);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						"yellow");
					writeBoldText("1", nextElement, centerLine, RED);
					nextElement += (2*circleSize);

					nextElement += (2*circleSize);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						Circle_B_Collected);
					writeBoldText("3", nextElement, centerLine, WHITE);
					drawLine(nextElement + circleSize, centerLine, nextElement +
						lineLen/2, centerLine, Circle_B_Collected);
					nextElement += (lineLen/2); 
					break;

				case "dfailed2":
 					drawLine(nextElement + circleSize, centerLine,
						nextElement + (lineLen/2), centerLine, L_Collected);
 					nextElement += (lineLen/2);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						"yellow");
					writeBoldText("1", nextElement, centerLine, RED);
					nextElement += (4*circleSize);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						Circle_B_Collected);
					nextElement -= (2*circleSize);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						"yellow");
					writeBoldText("2", nextElement, centerLine, RED);
					nextElement += (2*circleSize);
					writeBoldText("3", nextElement, centerLine, WHITE);
					drawLine(nextElement + circleSize, centerLine, nextElement +
						lineLen/2, centerLine, Circle_B_Collected);
					nextElement += (lineLen/2);  
					break;

				case "dfailed3":
  					drawLine(nextElement + circleSize, centerLine,
						nextElement + (lineLen/2), centerLine, L_Collected);
 					nextElement += (lineLen/2);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						"yellow");
					writeBoldText("1", nextElement, centerLine, RED);
					nextElement += (2*circleSize);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						"yellow");
					writeBoldText("2", nextElement, centerLine, RED);
					nextElement += (2*circleSize);
					drawLine(nextElement + circleSize, centerLine, nextElement +
						lineLen/2, centerLine, Circle_B_Collected);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						"yellow");
					writeBoldText("3", nextElement, centerLine, RED);
					nextElement += (lineLen/2);   
					break;

				default:
					drawLine(nextElement + circleSize, centerLine,
						nextElement + (lineLen/2), centerLine, B_Collected);
					nextElement += (lineLen/2);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						Circle_B_Collected);
					writeBoldText("1", nextElement, centerLine, WHITE);
					nextElement += (2*circleSize);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						Circle_B_Collected);
					writeBoldText("2", nextElement, centerLine, WHITE);
					nextElement += (2*circleSize);
					drawFilledCircle(nextElement, centerLine, circleSize, 1,
						Circle_B_Collected);
					writeBoldText("3", nextElement, centerLine, WHITE);
					drawLine(nextElement + circleSize, centerLine, nextElement +
						lineLen/2, centerLine, Circle_B_Collected);
					nextElement += (lineLen/2);
			}

		} else {
			/* If it is NOT L-Collected */
			drawLine(nextElement + circleSize, centerLine,
				nextElement + (lineLen/2), centerLine, B_Collected);
			nextElement += (lineLen/2);
			drawFilledCircle(nextElement, centerLine, circleSize, 1,
				Circle_B_Collected);
			writeBoldText("1", nextElement, centerLine, WHITE);
			nextElement += (2*circleSize);
			drawFilledCircle(nextElement, centerLine, circleSize, 1,
				Circle_B_Collected);
			writeBoldText("2", nextElement, centerLine, WHITE);
			nextElement += (2*circleSize);
			drawFilledCircle(nextElement, centerLine, circleSize, 1,
				Circle_B_Collected);
			writeBoldText("3", nextElement, centerLine, WHITE);
			drawLine(nextElement + circleSize, centerLine, nextElement +
				lineLen/2, centerLine, Circle_B_Collected);
			nextElement += (lineLen/2); 
		}

        // B_Collected
        writeText('Buyer', nextElement, centerLine + text);
        writeText('Collected', nextElement, centerLine + text + circleSize);
        writeText('(B-Collected)', nextElement,centerLine+text+(2*circleSize));

        /* B-Collected connects to B-Returning */
        drawLine(nextElement - circleSize , centerLine, nextElement + lineLen,
                centerLine, BCollectedToReturning);
        /* B-Collected Circle */
        drawCircle(nextElement, centerLine, circleSize, 1, Circle_B_Collected);
        nextElement += lineLen - (squareSize/2);

		/* Return Approval Square */
        writeText('Return',nextElement+lineLen+5,centerLine+text);
        writeText('Approval',nextElement+lineLen+5,centerLine+text+circleSize);
        writeText('(B-Returning)',nextElement+lineLen+5,
			centerLine+text+(2*circleSize));
        origami("#mrtCanvas").styles(completed_retappr).
			shape(completed_retappr).draw();
		console.log(completed_retappr);

		/* Merchant Approval Square */
        writeText('Merchant', 990, centerLine + text);
        writeText('Approved', 990, centerLine + text + circleSize);
        writeText('(M-Approved)', 990, centerLine + text + (2*circleSize));
        origami("#mrtCanvas").styles(completed_merappr).
			shape(completed_merappr).draw();
		console.log(completed_merappr);
        /**
         * End
         */

        // B_Returning
        var height = lineLen + 25;
        var upElement = nextElement + squareSize - 2;

        writeText('(Request Goods)', upElement, centerLine-height-text);
        writeText('Goods', upElement, centerLine-height-text-circleSize);
        writeText('Return', upElement, centerLine-height-text-(2*circleSize));
        writeText('Request', upElement, centerLine-height-text-(3*circleSize));

        var downElement = upElement;

		/* B-Returning connects to Request-Goods */
        drawLine(downElement, centerLine - height + circleSize, downElement,
			centerLine - height + circleSize + 70, BReturningToRequestGoods);

		/* B-Returning connects to Rejected1 */
        drawLine(downElement, centerLine + height + circleSize, downElement,
			centerLine + circleSize + 3, BReturningToRejected1);

        // 9. Return Rejected
        writeText('Return', downElement, centerLine + height + text);
        writeText('Rejected', downElement,
			centerLine + height + text + circleSize);
        writeText('(Rejected1)', downElement,
			centerLine + height + text + (2*circleSize));

        drawLine(downElement + circleSize, centerLine + height,
                downElement + 516, centerLine + height, Rejected1ToReviewed1);

        drawCircle(downElement, centerLine + height, circleSize, 1,
			Circle_Rejected1);

        downElement += 516;

        writeText('Review', downElement, centerLine + height + text);
        writeText('(Review1)', downElement,
			centerLine + height + text + circleSize);

        /* Reviewed1 to Completed */
        drawLine(downElement, centerLine, downElement,
			centerLine + lineLen + 13, Reviewed1ToCompleted);

        drawCircle(downElement, centerLine + height, circleSize, 1,
			Circle_Reviewed1);

        //  Line for Status Commented
        drawLine(downElement, centerLine, downElement + lineLen + 30,
                centerLine, CompletedToCommented);

        //  Shape for Status Commented
        origami("#mrtCanvas").styles(completed_commented).
			shape(completed_commented).draw();
        writeText('Commented', downElement + 105,
			centerLine - 40);

        /* Return Approval connects to Merchant Approval */
        drawLine(nextElement + lineLen - squareSize + 7, centerLine,
			nextElement + 400, centerLine, BReturningToMApproved);

		nextElement += 400;
		/* M-Approved to Completed */
        drawLine(nextElement, centerLine,
			nextElement + 2*lineLen, centerLine, MApprovedToCompleted);

        /* End here */

		/* RequestGoods connects to Call_Logistic1 */
        drawLine(upElement + circleSize, centerLine - height,
			upElement + lineLen, centerLine - height,
			RequestGoodsToCallLogistic1);

        // RequestGoods Circle
        drawCircle(upElement, centerLine - height, circleSize, 1,
			circle_request_goods);
        upElement += lineLen;

        // 9. Call Logistic1 Circle
        drawCircle(upElement, centerLine - height, circleSize, 1,
			circle_call_logistic1);

        writeText('Buyer', upElement, centerLine - height + text);
        writeText('Call', upElement, centerLine - height + text + circleSize);
        writeText('Logistic', upElement,
			centerLine - height + text + (2*circleSize));
        writeText('(Call Logistic 1)', upElement,
			centerLine - height + text + (3*circleSize));

        // Call_Logistic1 connects to L_Processing1
        drawLine(upElement + circleSize, centerLine - height,
			upElement + lineLen, centerLine - height,
			CallLogistic1ToLProcessing1);
        upElement += lineLen;

        // 10. L-Processing1
        drawCircle(upElement, centerLine - height, circleSize,
			1, circle_l_processing1);

		writeText('Logistic', upElement, centerLine - height + text);
        writeText('Accepted', upElement,
			centerLine - height + text + circleSize);
        writeText('(L-Processing1)', upElement,
			centerLine - height + text + (2*circleSize)); 

		drawLine(upElement + circleSize, centerLine - height,
                upElement + lineLen, centerLine - height, L_Collected1);

  		// Pickup Failure Attempts: #1,2,3
        upElement += (lineLen/2);
        drawFilledCircle(upElement, centerLine - height, circleSize, 1,
			L_Collected1);
        writeBoldText("1", upElement, centerLine - height, WHITE);
        upElement += (2*circleSize);
        drawFilledCircle(upElement, centerLine - height, circleSize, 1,
			L_Collected1);
        writeBoldText("2", upElement, centerLine - height, WHITE);
        upElement += (2*circleSize);
        drawFilledCircle(upElement, centerLine - height, circleSize, 1,
			L_Collected1);
        writeBoldText("3", upElement, centerLine - height , WHITE);

        // L-Processing1 connects to L-Collected1
        drawLine(upElement + circleSize, centerLine - height,
			upElement + lineLen, centerLine - height,
			LProcessing1ToLCollected1);
        upElement += (lineLen/2);

        // 11. L-Collected1 Circle
        drawCircle(upElement, centerLine - height, circleSize, 1,
			circle_l_collected1);
        writeText('Logistic', upElement, centerLine - height + text);
        writeText('Collected', upElement,
			centerLine - height + text + circleSize);
        writeText('(L-Collected1)', upElement,
			centerLine - height + text + (2*circleSize));

  		// B2M Delivery Failure Attempts: #1,2,3
//		if (status == "l-collected1") {
		if (post_b2m_status.includes(status)) {
			switch(dstatus_rtr) {
				case "dfailed1":
					drawLine(upElement + circleSize, centerLine - height,
						upElement + (lineLen/2), centerLine - height, L_Collected1);
					upElement += (lineLen/2);
					upElement += (2*circleSize);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						M_Collected);
					writeBoldText("2", upElement, centerLine - height, WHITE);

					upElement -= (2*circleSize);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						"yellow");
					writeBoldText("1", upElement, centerLine - height, RED);
					upElement += (2*circleSize);

					upElement += (2*circleSize);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						M_Collected);
					writeBoldText("3", upElement, centerLine - height , WHITE);
					drawLine(upElement + circleSize, centerLine - height,
						upElement + 3*circleSize, centerLine - height, M_Collected); 
					break;

				case "dfailed2":
 					drawLine(upElement + circleSize, centerLine - height,
						upElement + (lineLen/2), centerLine - height, L_Collected1);
 					upElement += (lineLen/2);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						"yellow");
					writeBoldText("1", upElement, centerLine - height, RED);
					upElement += (4*circleSize);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						M_Collected);
					upElement -= (2*circleSize);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						"yellow");
					writeBoldText("2", upElement, centerLine - height, RED);
					upElement += (2*circleSize);
					writeBoldText("3", upElement, centerLine - height, WHITE);
					drawLine(upElement + circleSize, centerLine - height, upElement +
						lineLen/2, centerLine - height, M_Collected);
					break;

				case "dfailed3":
  					drawLine(upElement + circleSize, centerLine - height,
						upElement + (lineLen/2), centerLine - height, L_Collected1);
 					upElement += (lineLen/2);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						"yellow");
					writeBoldText("1", upElement, centerLine - height, RED);
					upElement += (2*circleSize);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						"yellow");
					writeBoldText("2", upElement, centerLine - height, RED);
					upElement += (2*circleSize);
					drawLine(upElement + circleSize, centerLine - height, upElement +
						lineLen/2, centerLine - height, M_Collected);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						"yellow");
					writeBoldText("3", upElement, centerLine - height, RED);
					break;

				default:
					/* If dstatus is NOT dfailed1/dfailed2/dfailed3 */
					drawLine(upElement + circleSize, centerLine - height,
						upElement + (lineLen/2), centerLine - height, M_Collected);
					upElement += (lineLen/2);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						M_Collected);
					writeBoldText("1", upElement, centerLine - height, WHITE);
					upElement += (2*circleSize);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						M_Collected);
					writeBoldText("2", upElement, centerLine - height, WHITE);
					upElement += (2*circleSize);
					drawFilledCircle(upElement, centerLine - height, circleSize, 1,
						M_Collected);
					writeBoldText("3", upElement, centerLine - height, WHITE);
					drawLine(upElement + circleSize, centerLine - height, upElement +
						lineLen/2, centerLine - height, M_Collected);
			}

		} else {
			/* If it is NOT L-Collected1 */
			drawLine(upElement + circleSize, centerLine - height,
				upElement + (lineLen/2), centerLine - height, M_Collected);
			upElement += (lineLen/2);
			drawFilledCircle(upElement, centerLine - height, circleSize, 1,
				M_Collected);
			writeBoldText("1", upElement, centerLine - height, WHITE);
			upElement += (2*circleSize);
			drawFilledCircle(upElement, centerLine - height, circleSize, 1,
				M_Collected);
			writeBoldText("2", upElement, centerLine - height, WHITE);
			upElement += (2*circleSize);
			drawFilledCircle(upElement, centerLine - height, circleSize, 1,
				M_Collected);
			writeBoldText("3", upElement, centerLine - height, WHITE);
			drawLine(upElement + circleSize, centerLine - height, upElement +
				lineLen/2, centerLine - height, M_Collected);
		}            
 
        // 11. circle
        upElement += (lineLen/2);

        // 12. M-Collected Circle
		/* M-Collected to Rejected2 */
        drawLine(upElement, centerLine - height -12, upElement,
                centerLine - height - lineLen, MCollectedToRejected2);

		/* M-Collected to Merchant Approval */
        drawLine(upElement, centerLine - height + 12, upElement,
                centerLine, MCollectedToMApproved);

        drawCircle(upElement, centerLine - height, circleSize, 1, M_Collected);
        writeText('Merchant', upElement + squareSize + circleSize,
			centerLine - height + (1*circleSize));
        writeText('Collected', upElement + squareSize + circleSize,
			centerLine - height + (2*circleSize));
        writeText('(M-Collected)', upElement + squareSize + circleSize,
			centerLine - height + (3*circleSize));
		var m_approved = upElement + squareSize;
		console.log('m_approved='+m_approved);
 
        // 12. Merchant Rejected
        writeText('Merchant', upElement + squareSize + circleSize,
			centerLine - height - (5*circleSize));
        writeText('Rejected', upElement + squareSize + circleSize,
			centerLine - height - (4*circleSize));
        writeText('(Rejected2)', upElement + squareSize + circleSize,
			centerLine - height - (3*circleSize));

        drawLine(upElement + circleSize, centerLine - height - lineLen,
			upElement + lineLen + lineLen + 8,
			centerLine - height - lineLen, Rejected2ToReviewed2);

        drawCircle(upElement, centerLine - height - lineLen,
			circleSize, 1, Circle_Rejected2);
        upElement += lineLen + lineLen + 8;

		/* Reviewed2 */
        writeText('Review', upElement + (lineLen/2) + 8,
			centerLine - height - lineLen);
        writeText('(Review2)', upElement + (lineLen/2) + 8,
			centerLine - height - lineLen + circleSize);
        drawLine(upElement, centerLine - height - lineLen + circleSize,
			upElement, centerLine - height - lineLen + lineLen + lineLen,
			Reviewed2ToCompleted);

        drawCircle(upElement, centerLine - height - lineLen,
                circleSize, 1, Circle_Reviewed2);
        upElement += lineLen + lineLen;

		console.log(completed_shape);
        origami("#mrtCanvas").styles(completed_shape).
			shape(completed_shape).draw();
        writeText('Completed', downElement + 50,
			centerLine + 20);
        //console.log(downElement);

		/* Bounding region:
		Pending:   (089,237), W:26,H:26
		Cancelled: (070,300), W:62,H:22
		M2B DFailed1: (447,237)
		M2B DFailed2: (471,237)
		M2B DFailed3: (492,237)
		B2M DFailed1: (900,142)
		B2M DFailed2: (922,142)
		B2M DFailed3: (945,142)
		*/

		/* Squidster: Sun Jul 16 15:08:58 MYT 2017
		 * Proof-of-Concept: Interactive HTML5 Canvas */
		var canvas = $(mrtCanvas)[0];
		var c = canvas.getContext('2d');

		// Define & initialize toggles
		var df1_tog=false, df2_tog=false, df3_tog=false;
		var df4_tog=false, df5_tog=false, df6_tog=false;
		var cmt_tog=false;

 		canvas.addEventListener('click', function(e) {
			e.preventDefault(); // IMPORTANT!!

			// Width & height for the delivery failed boxes
			var dfailw = 120,  dfailh = 60;

			// M2B: Merchant-to-Buyer DELIVERY circle placement
			var dfail1x = 459, dfail1y = 250;
			var dfail2x = 481, dfail2y = 250;
			var dfail3x = 503, dfail3y = 250;

			// B2M: Buyer-to-Merchant RETURN circle placement
			var dfail4x = 912, dfail4y = 155;
			var dfail5x = 934, dfail5y = 155;
			var dfail6x = 956, dfail6y = 155;

			var diam = 24;
			// Canvas-based relative coordinates
			var cx = e.offsetX, cy = e.offsetY;

			c.clearRect(30,50-5,150,15);	// Clear coordinates
			c.clearRect(30,60-5,150,15); 	// Clear text
			//writeTextLeft("("+cx+","+cy+")", 30,50, '#000000');

			// "Cancelled" region
			if (cx>70 && cx<132 && cy>300 && cy<322) {
				//writeTextLeft("Cancelled!", 30,60, '#ff0000');

			// "Pending" region
			} else if (cx>89 && cx<89+diam && cy>237 && cy<237+diam) {
				//writeTextLeft("Pending!", 30,60, '#005500');

			@if (!empty($comment) && !empty($status))
				@if ($status == "commented")
				} else if (cx>1230 && cx<1230+32 && cy>220 && cy<237+60) {
					//writeTextLeft("Commented!", 30,60, PURPLE);
					@include('admin/mrt_comment_display');
				@endif
			@endif

			// M2B Delivery Failures: Protect against null $delivery
			@if (!empty($dtype) && !empty($dstatus) && !empty($status))
				@if ($dtype == 'm2b' &&  //$status == 'l-collected' && 
					 in_array($status, $post_m2b_status) && 
					($dstatus == 'dfailed1' ||
					 $dstatus == 'dfailed2' ||
					 $dstatus == 'dfailed3'))
				// M2B "dfailed1" region
				} else if (cx>447 && cx<447+diam && cy>237 && cy<237+diam) {
					if(df1_tog == false) {
						//writeTextLeft("M2B DFailed1 ON!", 30,60, '#405500');
						df1_tog = true;
						drawFilledCircle(dfail1x,dfail1y,circleSize,1,"yellow");
						writeBoldText("1",dfail1x,dfail1y,BLUE);
						drawDFail(1,dts1['m2b'],356,318,dfailw,dfailh,'#805050');
					} else {
						//writeTextLeft("M2B DFailed1 OFF!", 30,60, '#405500');
						df1_tog = false;
						eraseDFail(1,356,318,dfailw,dfailh);
						drawFilledCircle(dfail1x,dfail1y,circleSize,1,"yellow");
						writeBoldText("1",dfail1x,dfail1y,RED);
					}
				@endif

				@if ($dtype == 'm2b' && //$status == 'l-collected' &&
					 in_array($status, $post_m2b_status) && 
					($dstatus == 'dfailed2' ||
					 $dstatus == 'dfailed3'))
				// M2B "dfailed2" region
				} else if (cx>471 && cx<471+diam && cy>237 && cy<237+diam) {
 					if(df2_tog == false) {
						//writeTextLeft("M2B DFailed2 ON!", 30,60, '#405500');
						df2_tog = true;
						drawFilledCircle(dfail2x,dfail2y,circleSize,2,"yellow");
						writeBoldText("2",dfail2x,dfail2y,BLUE);
						drawDFail(2,dts2['m2b'],280,100,dfailw,dfailh,'#805050');
					} else {
						//writeTextLeft("M2B DFailed2 OFF!", 30,60, '#405500');
						df2_tog = false;
						eraseDFail(2,280,100,dfailw,dfailh);
						drawFilledCircle(dfail2x,dfail2y,circleSize,2,"yellow");
						writeBoldText("2",dfail2x,dfail2y,RED);
					} 
				@endif

				@if ($dtype == 'm2b' && //$status == 'l-collected' &&
					 in_array($status, $post_m2b_status) && 
					 $dstatus == 'dfailed3')
				// M2B "dfailed3" region
				} else if (cx>492 && cx<492+diam && cy>237 && cy<237+diam) {
  					if(df3_tog == false) {
						//writeTextLeft("M2B DFailed3 ON!", 30,60, '#405500');
						df3_tog = true;
						drawFilledCircle(dfail3x,dfail3y,circleSize,3,"yellow");
						writeBoldText("3",dfail3x,dfail3y,BLUE);
						drawDFail(3,dts3['m2b'],430,100,dfailw,dfailh,'#805050');
					} else {
						//writeTextLeft("M2B DFailed3 OFF!", 30,60, '#405500');
						df3_tog = false;
						eraseDFail(3,430,100,dfailw,dfailh);
						drawFilledCircle(dfail3x,dfail3y,circleSize,3,"yellow");
						writeBoldText("3",dfail3x,dfail3y,RED);
					}  
				@endif
			@endif

			// B2M Return Failures: Protect against null $delivery_rtr
			@if (!empty($dtype_rtr) && !empty($dstatus_rtr) && !empty($status))
				@if ($dtype_rtr == 'b2m' && //$status == 'l-collected1' &&
					 in_array($status, $post_b2m_status) && 
					($dstatus_rtr == 'dfailed1' ||
					 $dstatus_rtr == 'dfailed2' ||
					 $dstatus_rtr == 'dfailed3'))
				// B2M "dfailed1" region
				} else if (cx>900 && cx<900+diam && cy>142 && cy<142+diam) {
					if(df4_tog == false) {
						//writeTextLeft("B2M DFailed1 ON!", 30,60, '#405500');
						df4_tog = true;
						drawFilledCircle(dfail4x,dfail4y,circleSize,1,"yellow");
						writeBoldText("1",dfail4x,dfail4y,GREEN);
						drawDFail(4,dts1['b2m'],665,30,dfailw,dfailh,'#805050');
					} else {
						//writeTextLeft("B2M DFailed1 OFF!", 30,60, '#405500');
						df4_tog = false;
						eraseDFail(4,665,30,dfailw,dfailh);
						drawFilledCircle(dfail4x,dfail4y,circleSize,1,"yellow");
						writeBoldText("1",dfail4x,dfail4y,RED);
					}
				@endif

				@if ($dtype_rtr == 'b2m' && //$status == 'l-collected1' &&
					 in_array($status, $post_b2m_status) && 
					($dstatus_rtr == 'dfailed2' ||
					 $dstatus_rtr == 'dfailed3'))
				// B2M "dfailed2" region
				} else if (cx>922 && cx<922+diam && cy>142 && cy<142+diam) {
 					if(df5_tog == false) {
						//writeTextLeft("B2M DFailed2 ON!", 30,60, '#405500');
						df5_tog = true;
						drawFilledCircle(dfail5x,dfail5y,circleSize,2,"yellow");
						writeBoldText("2",dfail5x,dfail5y,GREEN);
						drawDFail(5,dts2['b2m'],810,30,dfailw,dfailh,'#805050');
					} else {
						//writeTextLeft("B2M DFailed2 OFF!", 30,60, '#405500');
						df5_tog = false;
						eraseDFail(5,810,30,dfailw,dfailh);
						drawFilledCircle(dfail5x,dfail5y,circleSize,2,"yellow");
						writeBoldText("2",dfail5x,dfail5y,RED);
					} 
				@endif

				@if ($dtype_rtr == 'b2m' && //$status == 'l-collected1' &&
					 in_array($status, $post_b2m_status) && 
					 $dstatus_rtr == 'dfailed3')
				// B2M "dfailed3" region
				} else if (cx>945 && cx<945+diam && cy>142 && cy<142+diam) {
  					if(df6_tog == false) {
						//writeTextLeft("B2M DFailed3 ON!", 30,60, '#405500');
						df6_tog = true;
						drawFilledCircle(dfail6x,dfail6y,circleSize,3,"yellow");
						writeBoldText("3",dfail6x,dfail6y,GREEN);
						drawDFail(6,dts3['b2m'],1030,0,dfailw,dfailh,'#805050');
					} else {
						//writeTextLeft("B2M DFailed3 OFF!", 30,60, '#405500');
						df6_tog = false;
						eraseDFail(6,1030,0,dfailw,dfailh);
						drawFilledCircle(dfail6x,dfail6y,circleSize,3,"yellow");
						writeBoldText("3",dfail6x,dfail6y,RED);
					}  
				@endif
			@endif 
			}  
		}); 
    });
</script>

<script type="text/javascript" src="{{asset('js/origami.js') }}"></script>
<script type="text/javascript" src="{{asset('js/canvasJs.js') }}"></script>
