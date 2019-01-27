<!DOCTYPE html >
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="utf-8" />
</head>
<?php
// dump($data);
$cn=$data[0];
$oid=$data[1];
$type=$data[3];
switch ($type) {
	case 'm2b':
		# code...
	$user=$data[2][0];
	$mer=$data[2][1];
	$mid=$mer->address_id;
	$bid=$user->default_address_id;
	$sname=$mer->company_name;
	$rname=$user->name;
	$sphone=$mer->office_no;
		break;
	case 'b2m':
		# code...
	$mer=$data[2][0];
	$user=$data[2][1];
	$mid=$mer->default_address_id;
	$bid=$user->address_id;
	$sname=$mer->name;
	$rname=$user->company_name;
	$sphone=$user->mobile_no;
		break;
	default:
		# code...
		break;
}
$securityKey=$data[2][2];
$lineLimit=56;

?>
<body style="margin: 0;">

<div id="p2" style="overflow: hidden; position: relative; width: 909px; height: 1286px;">

<!-- Begin shared CSS values -->
<style type="text/css" >
	.t {
		-webkit-transform-origin: top left;
		-moz-transform-origin: top left;
		-o-transform-origin: top left;
		-ms-transform-origin: top left;
		-webkit-transform: scale(0.25);
		-moz-transform: scale(0.25);
		-o-transform: scale(0.25);
		-ms-transform: scale(0.25);
		z-index: 2;
		position: absolute;
		white-space: pre;
		overflow: visible;
	}
</style>
<!-- End shared CSS values -->


<!-- Begin inline CSS -->
<style type="text/css" >
	#t1_1{left:31px;top:230px;}
#t1_2{left:31px;top:355px;}
#t2_2{left:456px;top:355px;}
#t3_2{left:818px;top:873px;}
#t4_2{left:557px;top:325px;}
#t5_2{left:72px;top:304px;}
#t6_2{left:263px;top:304px;}
#t7_2{left:115px;top:327px;}
#t8_2{left:327px;top:327px;}
#t9_2{left:31px;top:376px;}
#ta_2{left:31px;top:393px;}
#tb_2{left:31px;top:417px;}
#tc_2{left:31px;top:515px;}
#td_2{left:31px;top:534px;}
#te_2{left:244px;top:376px;}
#tf_2{left:244px;top:393px;}
#tg_2{left:457px;top:534px;}
#th_2{left:457px;top:435px;}
#ti_2{left:31px;top:476px;}
#tj_2{left:31px;top:494px;}
#tk_2{left:457px;top:515px;}
#tl_2{left:31px;top:575px;}
#tm_2{left:31px;top:555px;}
#tn_2{left:457px;top:555px;}
#to_2{left:457px;top:596px;}
#tp_2{left:457px;top:575px;}
#tq_2{left:31px;top:642px;}
#tr_2{left:31px;top:660px;}
#ts_2{left:244px;top:642px;}
#tt_2{left:244px;top:661px;}
#tu_2{left:31px;top:686px;}
#tv_2{left:31px;top:706px;}
#tw_2{left:244px;top:686px;}
#tx_2{left:244px;top:706px;}
#ty_2{left:457px;top:642px;}
#tz_2{left:457px;top:661px;}
#t10_2{left:671px;top:642px;}
#t11_2{left:671px;top:661px;}
#t12_2{left:457px;top:686px;}
#t13_2{left:457px;top:706px;}
#t14_2{left:671px;top:686px;}
#t15_2{left:670px;top:706px;}
#t16_2{left:31px;top:744px;}
#t17_2{left:244px;top:743px;}
#t18_2{left:457px;top:743px;}
#t19_2{left:671px;top:800px;}
#t1a_2{left:31px;top:799px;}
#t1b_2{left:244px;top:800px;}
#t1c_2{left:457px;top:800px;}
#t1d_2{left:32px;top:781px;}
#t1e_2{left:32px;top:725px;}
#t1f_2{left:244px;top:762px;}
#t1g_2{left:458px;top:966px;}
#t1h_2{left:31px;top:991px;}
#t1i_2{left:31px;top:1009px;}
#t1j_2{left:31px;top:1033px;}
#t1k_2{left:457px;top:991px;}
#t1l_2{left:31px;top:1118px;}
#t1m_2{left:31px;top:1138px;}
#t1n_2{left:244px;top:991px;}
#t1o_2{left:244px;top:1009px;}
#t1p_2{left:457px;top:1138px;}
#t1q_2{left:457px;top:1033px;}
#t1r_2{left:457px;top:1054px;}
#t1s_2{left:31px;top:1078px;}
#t1t_2{left:31px;top:1095px;}
#t1u_2{left:457px;top:1118px;}
#t1v_2{left:31px;top:1182px;}
#t1w_2{left:31px;top:1161px;}
#t1x_2{left:457px;top:1161px;}
#t1y_2{left:457px;top:1201px;}
#t1z_2{left:457px;top:1182px;}
#t20_2{left:31px;top:1243px;}
#t21_2{left:31px;top:1265px;}
#t22_2{left:244px;top:1243px;}
#t23_2{left:244px;top:1265px;}
#t24_2{left:31px;top:1289px;}
#t25_2{left:31px;top:1308px;}
#t26_2{left:244px;top:1289px;}
#t27_2{left:244px;top:1308px;}
#t28_2{left:32px;top:966px;}
#t29_2{left:457px;top:1243px;}
#t2a_2{left:457px;top:1265px;}
#t2b_2{left:670px;top:1243px;}
#t2c_2{left:671px;top:1265px;}
#t2d_2{left:457px;top:1289px;}
#t2e_2{left:457px;top:1308px;}
#t2f_2{left:670px;top:1289px;}
#t2g_2{left:670px;top:1308px;}
#t2h_2{left:31px;top:1347px;}
#t2i_2{left:457px;top:1347px;}
#t2j_2{left:671px;top:1347px;}
#t2k_2{left:32px;top:1327px;}
#t2l_2{left:457px;top:1396px;}
#t2m_2{left:31px;top:1396px;}
#t2n_2{left:557px;top:938px;}
#t2o_2{left:127px;top:417px;}
#t2p_2{left:31px;top:1054px;}
#t2q_2{left:457px;top:376px;}
#t2r_2{left:457px;top:395px;}
#t2s_2{left:457px;top:417px;}
#t2t_2{left:457px;top:477px;}
#t2u_2{left:29px;top:840px;}
#t2v_2{left:457px;top:1079px;}
#t2w_2{left:27px;top:1456px;}
#t2x_2{left:818px;top:891px;}
#t2y_2{left:818px;top:911px;}

	.s7_2{
		FONT-SIZE: 30.8px;
		FONT-FAMILY: Arial_b;
		color: rgb(0,0,0);
	}

	.s5_2{
		FONT-SIZE: 49.1px;
		FONT-FAMILY: Arial_b;
		color: rgb(0,0,0);
	}

	.s6_2{
		FONT-SIZE: 49.1px;
		FONT-FAMILY: Arial-Bold_8;
		color: rgb(0,0,0);
	}

	.s3_2{
		FONT-SIZE: 73.3px;
		FONT-FAMILY: Arial-Bold_8;
		color: rgb(0,0,0);
	}

	.s4_2{
		FONT-SIZE: 60.9px;
		FONT-FAMILY: Arial_b;
		color: rgb(0,0,0);
	}

	.s2_2{
		FONT-SIZE: 85.8px;
		FONT-FAMILY: Arial-Bold_8;
		color: rgb(0,0,0);
	}

	.s1_2{
		FONT-SIZE: 55px;
		FONT-FAMILY: Arial-Bold_8;
		color: rgb(0,0,0);
	}

	</style>
	<!-- End inline CSS -->

	<!-- Begin embedded font definitions -->
	<style id="fonts2" type="text/css" >

	@font-face {
		font-family: Arial_b;
		src: url("{{asset('fonts/Arial_b.woff')}}") format("woff");
	}

	@font-face {
		font-family: Arial-Bold_8;
		src: url("{{asset('fonts/Arial-Bold_8.woff')}}") format("woff");
	}

</style>
<!-- End embedded font definitions -->
<?php
$oS="CRS";



$mAdd=DB::table('address')->where('address.id',$mid)
->join('city','address.city_id','=','city.id')
->join('state','city.state_code','=','state.code')
->select(DB::raw("
	address.*,
	city.name as city,
	state.name as state
	"))
->first();
$bAdd=DB::table('address')->where('address.id',$bid)
->join('city','address.city_id','=','city.id')
->join('state','city.state_code','=','state.code')
->select(DB::raw("
	address.*,
	city.name as city,
	state.name as state
	"))
->first();
?>
<!-- Begin text definitions (Positioned/styled in CSS) -->
<div style="">
<img src="{{asset('images/category/OpenSupermall Official Logo PNG.png')}}"
   style="position: absolute;left:34px;" height=100 width=400>
   {{-- <img style="position: absolute;left: 34px;top:95px;z-index: 999;" id="sk" src="{{asset('citilink/'.$cn.'/barcodeSK.png')}}" height="90" width="250" /> --}}
   <div style="position: absolute;left:34px;top:116px;"><strong>SECURITY KEY</strong></div>
   <div style="position: absolute;left:170px;top:110px;z-index: 999;border: 1px solid black;padding: 5px;"><strong>{{$securityKey}}</strong></div>
  	<div style="position: absolute;left: 710px;border: 1px solid black;z-index: 999;">
  		<img  id="qsk" src="{{asset('citilink/'.$cn.'/qrSK.png')}}" height="160" width="160" />
  	</div>
</div>

<img src="{{asset('citilink/asset/1.png')}}" style="position: absolute;left: 34px;top:200px;z-index: 999;">
<img src="{{asset('citilink/'.$cn.'/ref.png')}}" style="position: absolute;left: 34px;top:435px;z-index: 999;">
<img src="{{asset('citilink/asset/1.png')}}" style="position: absolute;left: 34px;top:860px;z-index: 999;">
<img style="position: absolute;left: 474px;top:200px;z-index: 999;" id="bcl" src="{{asset('citilink/'.$cn.'/barcodeL.png')}}" height="124" width="400" />
<img style="position: absolute;left: 474px;top:860px;z-index: 999;" id="bcl" src="{{asset('citilink/'.$cn.'/barcodeL.png')}}" height="80" width="300" />
<img src="{{asset('citilink/'.$cn.'/qr.png')}}" height="140" width="140" style="position: absolute;left:730px;top:371px;z-index: 999;" />
<div id="t1_2" class="t s1_2">1. FROM (SHIPPER)</div>
<div id="t2_2" class="t s1_2">4. SHIP TO (RECEIVER)</div>
<div id="t3_2" class="t s2_2">P</div>
<div id="t4_2" class="t s3_2">{{$cn}}</div>
<div id="t5_2" class="t s4_2">ORIGIN STATION</div>
<div id="t6_2" class="t s4_2">DESTINATION STATION</div>
<div id="t7_2" class="t s3_2">{{$oS}}</div>
<div id="t8_2" class="t s3_2">BKI</div>
<div id="t9_2" class="t s5_2">SHIPPER'S ACCOUNT NO</div>
<div id="ta_2" class="t s6_2">TESTACCT1</div>
<div id="tb_2" class="t s5_2">SHIPMENT REF</div>
<div id="tc_2" class="t s5_2">SHIPPER'S NAME</div>
<div id="td_2" class="t s6_2">{{strtoupper($sname)}}</div>
<div id="te_2" class="t s5_2">PHONE NUMBER</div>
<div id="tf_2" class="t s6_2">{{$sphone}}</div>
<div id="tg_2" class="t s6_2">{{strtoupper($rname)}}</div>
<div id="th_2" class="t s6_2">{{$user->mobile_no}}</div>
<div id="ti_2" class="t s5_2">COMPANY NAME</div>
<div id="tj_2" class="t s6_2">{{strtoupper($sname)}}</div>
<div id="tk_2" class="t s5_2">RECEIVER'S NAME</div>
<div id="tl_2" class="t s6_2">{{strtoupper(substr($mAdd->line1,0,$lineLimit))}}<br>{{strtoupper(substr($mAdd->line1,$lineLimit,2*$lineLimit))}}<br>{{strtoupper(substr($mAdd->line2,0,$lineLimit))}}<br>{{strtoupper(substr($mAdd->line2,$lineLimit,2*$lineLimit))}},{{strtoupper($mAdd->line3)}}</div>
<div id="tm_2" class="t s5_2">SHIPPER ADDRESS</div>
<div id="tn_2" class="t s5_2">RECEIVER ADDRESS ( WE DO NOT DELIVER TO P.O.BOX)</div>
<div id="to_2" class="t s6_2">{{strtoupper($bAdd->line2)}}, {{strtoupper($bAdd->line3)}}</div>
<div id="tp_2" class="t s6_2">{{strtoupper(substr($bAdd->line1,0,$lineLimit))}}<br>{{strtoupper(substr($bAdd->line1,$lineLimit,2*$lineLimit))}}</div>
<div id="tq_2" class="t s5_2">CITY</div>
<div id="tr_2" class="t s6_2">{{strtoupper($bAdd->city)}}</div>
<div id="ts_2" class="t s5_2">STATE / PROVINCE</div>
<div id="tt_2" class="t s6_2">{{strtoupper($mAdd->state)}}</div>
<div id="tu_2" class="t s5_2">COUNTRY</div>
<div id="tv_2" class="t s6_2">MALAYSIA</div>
<div id="tw_2" class="t s5_2">ZIP / POSTAL CODE</div>
<div id="tx_2" class="t s6_2">{{$mAdd->postcode}}</div>
<div id="ty_2" class="t s5_2">CITY</div>
<div id="tz_2" class="t s6_2">{{strtoupper($bAdd->city)}}</div>
<div id="t10_2" class="t s5_2">STATE / PROVINCE</div>
<div id="t11_2" class="t s6_2">{{strtoupper($bAdd->state)}}</div>
<div id="t12_2" class="t s5_2">COUNTRY</div>
<div id="t13_2" class="t s6_2">MALAYSIA</div>
<div id="t14_2" class="t s5_2">ZIP / POSTAL CODE</div>
<div id="t15_2" class="t s6_2">{{$bAdd->postcode}}</div>
<div id="t16_2" class="t s5_2">SHIPPER'S SIGNATURE</div>
<div id="t17_2" class="t s5_2">DATE (DD/MM/YYYY)</div>
<div id="t18_2" class="t s5_2">TIME (HH/MM)</div>
<div id="t19_2" class="t s5_2">PRODUCT TYPE</div>
<div id="t1a_2" class="t s5_2">NO. OF PIECES</div>
<div id="t1b_2" class="t s5_2">GROSS WEIGHT</div>
<div id="t1c_2" class="t s5_2">CHARGEABLE WEIGHT</div>
<div id="t1d_2" class="t s1_2">3.SHIPMENT INFORMATION</div>
<div id="t1e_2" class="t s1_2">2. SHIPPER'S SIGNATURE &amp; AUTHORIZATION</div>
<div id="t1f_2" class="t s6_2"></div>
<div id="t1g_2" class="t s1_2">3. SHIP TO (RECEIVER)</div>
<div id="t1h_2" class="t s5_2">SHIPPER'S ACCOUNT NO</div>
<div id="t1i_2" class="t s6_2">TESTACCT1</div>
<div id="t1j_2" class="t s5_2">SHIPMENT REF</div>
<div id="t1k_2" class="t s5_2">RECEIVER'S ACCOUNT NO</div>
<div id="t1l_2" class="t s5_2">SHIPPER'S NAME</div>
<div id="t1m_2" class="t s6_2">{{strtoupper($sname)}}</div>
<div id="t1n_2" class="t s5_2">PHONE NUMBER</div>
<div id="t1o_2" class="t s6_2">{{$mer->office_no}}</div>
<div id="t1p_2" class="t s6_2">{{strtoupper($rname)}}</div>
<div id="t1q_2" class="t s5_2">PHONE NUMBER</div>
<div id="t1r_2" class="t s6_2">{{$user->mobile_no}}</div>
<div id="t1s_2" class="t s5_2">COMPANY NAME</div>
<div id="t1t_2" class="t s6_2">{{strtoupper($mer->company_name)}}</div>
<div id="t1u_2" class="t s5_2">RECEIVER'S NAME</div>
<div id="t1v_2" class="t s6_2">{{strtoupper(substr($mAdd->line1,0,$lineLimit))}}<br>{{strtoupper(substr($mAdd->line1,$lineLimit,2*$lineLimit))}}<br>{{strtoupper(substr($mAdd->line2,0,$lineLimit))}}<br>{{strtoupper(substr($mAdd->line2,$lineLimit,2*$lineLimit))}},{{strtoupper($mAdd->line3)}}</div>
<div id="t1w_2" class="t s5_2">SHIPPER ADDRESS</div>
<div id="t1x_2" class="t s5_2">RECEIVER ADDRESS ( WE DO NOT DELIVER TO P.O.BOX)</div>
<div id="t1y_2" class="t s6_2">{{strtoupper($bAdd->line2)}}, {{strtoupper($bAdd->line3)}}</div>
<div id="t1z_2" class="t s6_2">{{strtoupper(substr($bAdd->line1,0,$lineLimit))}}<br>{{strtoupper(substr($bAdd->line1,$lineLimit,2*$lineLimit))}}</div>
<div id="t20_2" class="t s5_2">CITY</div>
<div id="t21_2" class="t s6_2">{{strtoupper($mAdd->city)}}</div>
<div id="t22_2" class="t s5_2">STATE / PROVINCE</div>
<div id="t23_2" class="t s6_2">{{strtoupper($mAdd->state)}}</div>
<div id="t24_2" class="t s5_2">COUNTRY</div>
<div id="t25_2" class="t s6_2">MALAYSIA</div>
<div id="t26_2" class="t s5_2">ZIP / POSTAL CODE</div>
<div id="t27_2" class="t s6_2">{{$mAdd->postcode}}</div>
<div id="t28_2" class="t s1_2">1. FROM (SHIPPER)</div>
<div id="t29_2" class="t s5_2">CITY</div>
<div id="t2a_2" class="t s6_2">{{strtoupper($bAdd->city)}}</div>
<div id="t2b_2" class="t s5_2">STATE / PROVINCE</div>
<div id="t2c_2" class="t s6_2">{{strtoupper($bAdd->state)}}</div>
<div id="t2d_2" class="t s5_2">COUNTRY</div>
<div id="t2e_2" class="t s6_2">MALAYSIA</div>
<div id="t2f_2" class="t s5_2">ZIP / POSTAL CODE</div>
<div id="t2g_2" class="t s6_2">{{$bAdd->postcode}}</div>
<div id="t2h_2" class="t s5_2">RECEIVER'S NAME</div>
<div id="t2i_2" class="t s5_2">DATE (DD/MM/YYYY)</div>
<div id="t2j_2" class="t s5_2">TIME (HH/MM)</div>
<div id="t2k_2" class="t s1_2">2. RECEIVER'S SIGNATURE &amp; AUTHORIZATION</div>
<div id="t2l_2" class="t s5_2">RECEIVER'S I.D. NO</div>
<div id="t2m_2" class="t s5_2">RECEIVER'S SIGNATURE</div>
<div id="t2n_2" class="t s3_2">{{$cn}}</div>
<div id="t2o_2" class="t s6_2">{{$oid}}</div>
<div id="t2p_2" class="t s6_2">{{$oid}}</div>
<div id="t2q_2" class="t s5_2">RECEIVER'S ACCOUNT NO</div>
<div id="t2r_2" class="t s6_2">N/A</div>
<div id="t2s_2" class="t s5_2">PHONE NUMBER</div>
<div id="t2t_2" class="t s5_2">COMPANY NAME</div>
<div id="t2u_2" class="t s7_2">NOTICE:- THIS SHIPMENT IS SUBJECT TO CITY-LINK EXPRESS STANDARD CONDITIONS OF CARRIAGE.</div>
<div id="t2v_2" class="t s5_2">COMPANY NAME</div>
<div id="t2w_2" class="t s7_2">NOTICE:- THIS SHIPMENT IS SUBJECT TO CITY-LINK EXPRESS STANDARD CONDITIONS OF CARRIAGE.</div>
<div id="t2x_2" class="t s2_2">O</div>
<div id="t2y_2" class="t s2_2">D</div>

<!-- End text definitions -->

<!-- Begin page background -->
<div id="pg2Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;top: 200px;" ></div>
<div id="pg2">

<img width="909" height="1286" src="{{asset('citilink/'.$cn.'/1.svg')}}" type="image/svg+xml" id="pdf2" style="position:absolute;width:909px; height:1286px;top:200px; background-color:white; -moz-transform:scale(1); z-index: 0;"></img></div>
<!-- End page background -->

<!--[if lt IE 9]><script type="text/javascript">
(function(divCount, pageNum) {
for (var i = 1; i < divCount; i++) {
    var div = document.getElementById('t' + i.toString(36) + '_' + pageNum);
    if (div !== null) {
        div.style.top = (div.offsetTop * 4) + 'px';
        div.style.left = (div.offsetLeft * 4) + 'px';
        div.style.zoom = '25%';
    }
}
})(107, 2);
</script><![endif]-->

</div>
 {{-- <div style="page-break-before:always;"> --}}

   

{{-- </div> --}}
</body>
</html>