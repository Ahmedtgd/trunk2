@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
?>
@section("content")
@include('common.sellermenu')
<style>
    a, a:focus, a:active, a:hover {
      text-decoration : none !important;
    }
    label {
  display: block;
  padding-left: 15px;
  text-indent: -15px;
}
/*input {
  width: 13px;
  height: 13px;
  padding: 0;
  margin:0;
  vertical-align: bottom;
  position: relative;
  top: -1px;
  *overflow: hidden;
}*/
    .ocpName {
      white-space: nowrap; 
      overflow: hidden; 
      text-overflow: ellipsis; 
      width: 100%;
    }

    #ocredit .panel-title {
      display: inline;
    }

    .label-style {
        position: relative;
        top: -1px;
    }
    #ocredit .panel-body {
    padding: 0px;
}

#ocredit .panel {
    border-radius: 0px;
    box-shadow: none;
    border-bottom: 1px solid #ddd;
}

.src-row {
    border: 1px solid #ddd;
    height: 35px;
    border-bottom: 0px;
}

.ocDateCol {
    height: 35px;
    padding: 8px;
}

.ocPriceCol {
    border-left: 1px solid #ddd;
    height: 35px;
    padding: 8px;
}

.bg-standard {
    background: #F5F5F5;
}

.sourceTotal {
    cursor: pointer;
    color: #3292DF;
    text-decoration: underline;
}
        {{-- start --}}
        hr{
            border-top-color: #5F6879;
            margin-top: 0px;

        }

        .priceTable thead tr th,
        .priceTable tbody tr td {
            padding: 0px;
            border: 0px;
            font-size: 12px;
        }

        .priceTable thead tr th {
            padding-bottom: 5px;
        }

        .list-inline{
            margin-top: 10px;
        }

		.showAlert{
            padding: 2px 5px;
            font-size: 12px;
            border-radius: 20px;
        }

        .product-name{
            font-weight: bold;
            @if(Auth::check())
                border-bottom: 1px solid #ccc;
            padding-bottom: 7px;
            padding-top: 7px;
            @else
                padding-top: 9px;
        @endif
    }

        .qty-area{
            padding-top: 7px;
            padding-bottom: 7px;
            border-bottom: 1px solid #ccc;
        }

        .tier-price {
            padding-top: 4px;
            padding-bottom: 0px;
            height: 100px;
            overflow: hidden;
        }

        .tier-price div p {
            padding-bottom: 0px;
            margin-bottom: 2px;
            font-size: 12px;
            font-weight: bold;
        }

        .productName{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .product-price {
            font-weight: bold;
            padding-top: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .popover {
            width: 16%;
        }

        @media (max-width: 321px) {
            .popover {
                width: 70%;
            }
        }

        .popover-content {
            padding: 9px 25px;
        }

        .popover-title {
            padding: 9px 10px;
        }


        .list-inline li {
            width: 30px;
            height: 30px;
            border-radius: 2px;
            text-align: center;
            padding-top: 2px;
        }
        .save {
            background: red;
            color: #fff;
            padding-left: 7px;
            border-radius: 20px;
            padding-right: 7px;
            padding-bottom: 3px;
        }

        .p-box-content {
            padding: 0px 8px 0px 8px;
        }

        button.btn-xs{
            padding: 4px 5px !important;
        }

	{{-- stop --}}
		.col-xs-15,
        .col-sm-15,
        .col-md-15,
        .col-lg-15 {
            position: relative;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }

        .col-xs-15 {
            width: 20%;
            float: left;
        }
        @media (min-width: 768px) {
            .col-sm-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 992px) {
            .col-md-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 1200px) {
            .col-lg-15 {
                width: 20%;
                float: left;
            }
        }


#paysliptable td{
	padding: 5px;
	border-right:1px solid black;
}

.overlay{
	background-color: rgba(1, 1, 1, 0.7);
	bottom: 0;
	left: 0;
	position: fixed;
	right: 0;
	top: 0;
	z-index: 1001;
}
.overlay p{
	color: white;
	font-size: 18px;
	font-weight: bold;
	margin: 365px 0 0 610px;
}
.action_buttons{
	display: flex;
}
.role_status_button{
	margin: 10px 0 0 10px;
}
.easeAni {	-webkit-transition: all 0.3s ease-in; -moz-transition: all 0.3s ease-in; -o-transition: all 0.3s ease-in; transition: all 0.3s ease-in;}

.boxTile {   height: 33%;  padding-bottom: 45%;  position: relative;  width: 100%;}
.boxTile .square { margin:10px; position: absolute; bottom: 0;  left: 0;  right: 0;  top: 0;}
.boxTile .square img {  display: block;  height: 100%;  width: 50%;}
.boxTile .info { opacity:0.8; bottom: 0;  left: 20%;  overflow: hidden;  padding: 15px;  position: absolute;  right: 0;  top: 100px;}
.boxTile:hover .info { background: #FF0080;opacity:1}
.boxTile .text {  color: #FFFFFF;  max-height: 100%;  overflow: hidden;  width: 100%;}
.boxTile .text h2 {  color: #FFF;  display: inline-block;  font-size: 130%;  margin: 8px 0; padding-right:1em;}
.boxTile .text p {  color: #FFF;  text-transform: uppercase;  white-space: nowrap; font-size: 80%; padding-right:1em;}

.producttitle {
    margin-top: 5px;margin-left: -11px;  margin-right: -1px;margin-bottom:5px;
    font-weight:bold;
    padding:5px;
    border: 1px solid grey;
    font-size:8px;
}
.button {
    background-color:#D7E748; /* green */
    border: none;
    color: white;
    text-align: center;
    display: inline-block;
    font-size: 18px;
    height: 35px;
    width: 150px;
}


@media (max-width: 768px) {

	.boxTile .square img { display: block;  width: 80% !important;  }
    .src-row {
        border: 0px;
    }

    .ocPriceCol {
        border: 1px solid #ddd;
    }

    .ocDateCol {
        border: 1px solid #ddd;
    }

}

@media (min-width: 768px) {

	.boxTile .square img {  display: block;  width: 100% !important;  }

}


@media (min-width: 1200px) {

	.boxTile {  padding-bottom: 100%;  }
.boxTile .square img {  display: block;  width: 100% !important;}
	.boxTile .info {  top: 45%;  background: #FF0080; filter: alpha(opacity=60);}

}
.image{
	width:80%;height:70%;margin: 0 auto;position:relative;overflow:hidden;border: 1px solid grey;
}
.image img{
	/*border: 1px solid grey;*/
	/*-webkit-filter: drop-shadow(5px 5px 10px black);*/
}
.shadow{
	/*webkit-filter: drop-shadow(16px 16px 20px black );*/
	-webkit-filter: drop-shadow(2px 2px 5px black);
}

.productbox {

	background-color:#ffffff;
	-webkit-box-shadow: 0 8px 6px -6px  #999;
	-moz-box-shadow: 0 8px 6px -6px  #999;
	box-shadow: 0 8px 6px -6px #999;
}

.owInfo{
	width: 150px;height: 70px; background-color: #FF0080;position:absolute;
	float:right;right:22px; bottom:10px;z-index: 1000; color: #ffffff;opacity: 0.9;
}
li>a{
	margin-left: 21px;

}
/*SMM Summarry box*/
table{
	font-size: 1em;
}

.imgsmm{
	min-width: 100px;
	min-height: 100px;
}
.selected{
        border: 1px green solid;
    }
.box {
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    padding: 10px 25px;
    /*text-align: right;*/
    display: block;
    /*margin-top: 60px;*/
    margin:10px;
}

.infosmm{
    font-size: 1.3em;
    letter-spacing: 2px;
    /*text-transform: uppercase;*/
}
    .selected{
        border: 1px green solid;
    }
    .added{}

/*CSS ENDS*/
.edit-personal-info-buyer{
	width:50%!important;
}

.bg {
  width: 80%;
  height: 40%;
  /*background-color: #f0f0f0;*/
  object-fit: contain; /* cover works perfectly on Safari */
}

.wrapper {
	/*margin-right: -15px;
	margin-left: -15px;
   */
	width: 100%;
	min-width: 60%;
	height: auto;
	max-height:60%;
	overflow: hidden;
}
.fvshop{
	display: block;
}
.afin{
	height: 10px;
}
.fvshop:before {
	/*Using a Bootstrap glyphicon as the bullet point*/
	content: "\e014";
	font-family: 'Glyphicons Halflings';
	font-size: 10px;
	float: left;
	margin-top: 4px;
	margin-left: -17px;
}
.details-control, .details-control-2 {
	cursor: pointer;
}

td.details-control:after ,td.details-control-2:after {
	font-family: 'FontAwesome';
	content: "\f0da";
	color: #303030;
	font-size: 17px;
	float: right;
	padding-right: 25px;
}
tr.shown td.details-control:after, tr.shown td.details-control-2:after {
	content: "\f0d7";
}

.child_table {
	margin-left: 78px;
	width: 920px;;
}
.panel {
	border: 0;
}

table
{
	counter-reset: Serial;
}

table.counter_table tr td:first-child:before
{
	counter-increment: Serial;      /* Increment the Serial counter */
	content: counter(Serial); /* Display the counter */
}
.grayout {
    opacity: 0.6; /* Real browsers */
    filter: alpha(opacity = 60); /* MSIE */
}

.purchase{
	background: #e6e6e6;
	width: 100%;
	padding: 10px;
	margin: 0 auto;
	border: 2px solid #e6e6e6;
	border-radius: 25px;
}

.statement{
	background: #e6e6e6;
	width: 100%;
	padding: 10px;
	margin: 0 auto;
	border: 2px solid #e6e6e6;
	border-radius: 25px;
}
.ym{background: #c6c6c6;width: 100%;margin: 0 auto;padding: 5px;border-radius: 25px;}
/*button{font-family: sans-serif;border: none;width: 45px;}*/
.btn-enable{background: lightblue;}
.btn-disable{background: #4d4d4d;color:white;}

.imagePreview {
  width: 100%;
  height: 300px;
  background-position: center top;
  background-repeat: no-repeat;
  -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
  background-color: #e7e7e7;
  border: 1px solid;
  display: inline-block;
  margin-bottom: 5px;
  border-color: #d0d0d0;
}

.imagePreviewBig {
  width: 100%;
  height: 300px;
  background-position: center top;
  background-repeat: no-repeat;
  -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
  background-color: #e7e7e7;
  border: 1px solid;
  display: inline-block;
  margin-bottom: 5px;
  border-color: #d0d0d0;
}


.imagePreview input,.imagePreviewBig input {
  filter: alpha(opacity=0);
  opacity: 0;
  width: 100%;
  height: 300px;
  background-position: center top;
  background-size: cover;
  display: inline-block;
  cursor: pointer;
  background-color: #e7e7e7;
  border-color: #d0d0d0;
}

.easy-autocomplete-container {
    position: absolute;
    margin-right: 15px;
    width: 90%;
    z-index: 2;
}

.cat-img {
    border: 1px solid #ccc;
    padding: 10%;
}

.ribbon-wrapper-green {
    width: 84px;
    height: 88px;
    overflow: hidden;
    position: absolute;
    top: -2px;
    right: 0px;
}

.ribbon-green {
  font: 12px Lato;
  text-align: center;
  text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
  -webkit-transform: rotate(45deg);
  -moz-transform:    rotate(45deg);
  -ms-transform:     rotate(45deg);
  -o-transform:      rotate(45deg);
  position: relative;
  padding: 7px 0;
  left: -5px;
  top: 15px;
  width: 120px;
  background-color: #ff0080;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#ff0080), to(#ff0040));
  background-image: -webkit-linear-gradient(top, #ff0080, #ff0040);
  background-image:    -moz-linear-gradient(top, #ff0080, #ff0040);
  background-image:     -ms-linear-gradient(top, #ff0080, #ff0040);
  background-image:      -o-linear-gradient(top, #ff0080, #ff0040);
  color: #eee;
  -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
  -moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
  box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
}

.ribbon-green:before, .ribbon-green:after {
  content: "";
  border-top:   3px solid #6e8900;
  border-left:  3px solid transparent;
  border-right: 3px solid transparent;
  position:absolute;
  bottom: -3px;
}

.ribbon-green:before {
  left: 0;
}
.ribbon-green:after {
  right: 0;
}​
  table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
.btn-pink,.btn-pink:hover{color:#fff; background:#d7e748; }
</style>
<div class=" " > <!-- col-sm-12 -->

<?php $e=1;?>
<div class="container">
<div class="row">
	<div class="col-sm-12">
	<h2>Station Documents</h2>
	<div class="purchase" style="">
		<h3 style="font-family: sans-serif">Merchant Monthly Purchase Orders</h3>
		<span class="row">{{$name or ''}}</span>
		<div class="ym">
			{{--*/ $y = 1; $index = 0;/*--}}

			<?php if((is_null($myreturn)) || ($current_year == 0)){ $carbon = new Carbon();?>
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">
						{{date('Y')}}{{':'}}</span>
					@for($i = 0,$carbon->month = 1; $i < 12; $i++,
						$carbon->addMonth())
						<button class="btn-disable btn btn-sm primary-btn" disabled>
							{{$carbon->format('M')}}
						</button>
					@endfor
				</div>
			<?php } ?>
			 
			@foreach($myreturn as $returned)
				{{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
				$m = $years[$created_at->year]; sort($m);
				$month = $m[0]; $index = 0;/*--}}

				@if($y != $created_at->year)
					<div style="margin: 5px;">
						<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
						@for($i = 0,$carbon->month = 1; $i < 12; $i++,$carbon->addMonth())
							@if(in_array($carbon->month, $m) )
								<button class="btn-enable btn btn-sm primary-btn" 
										onclick="invoicepurchase({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
									<span id="hp{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
									<span style="display: none;" id="ip{{$created_at->year}}-{{$carbon->month}}">...</span>
									</i>
								</button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
							@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
							@endif
						@endfor
					</div>
				@endif
				{{--*/ $y = $created_at->year; /*--}}
				<?php $i++;?>
			@endforeach
		</div>
	</div>	
	<br>
	<br>	
	<div class="statement" style="">
		<h3 style="font-family: sans-serif">Station Monthly Invoices</h3>
		<span class="row">{{$name or ''}}</span>
		<div class="ym">
			{{--*/ $y = 1; $index = 0;/*--}}

			<?php if((is_null($myreturn)) || ($current_year == 0)){ $carbon = new Carbon();?>
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">
						{{date('Y')}}{{':'}}</span>
					@for($i = 0,$carbon->month = 1; $i < 12; $i++,
						$carbon->addMonth())
						<button class="btn-disable btn btn-sm primary-btn" disabled>
							{{$carbon->format('M')}}
						</button>
					@endfor
				</div>
			<?php } ?>
			@foreach($myreturn as $returned)
				{{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
				$m = $years[$created_at->year]; sort($m);
				$month = $m[0]; $index = 0;/*--}}

				@if($y != $created_at->year)
					<div style="margin: 5px;">
						<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
						@for($i = 0,$carbon->month = 1; $i < 12; $i++,$carbon->addMonth())
							@if(in_array($carbon->month, $m) )
								<button class="btn-enable btn btn-sm primary-btn" 
										onclick="invoicestatement({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
									<span id="h{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
									<span style="display: none;" id="i{{$created_at->year}}-{{$carbon->month}}">...</span>
									</i>
								</button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
							@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
							@endif
						@endfor
					</div>
				@endif
				{{--*/ $y = $created_at->year; /*--}}
				<?php $i++;?>
			@endforeach
		</div>
	</div>	
	<br>
	<input type="hidden" value="{{$selluser->id}}" id="selluserid" />
	<input type="hidden" value="{{$selluser->id}}" id="lpeid" />  
        <div class="modal fade" id="invmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="width:950px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="myModalLabel2">Invoice Statement</h2>
                    </div>
                    <div class="modal-body" id="invmodalbody">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
                    </div>
                </div>
            </div>
        </div>	
		<div class="modal fade" id="purchmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="width:950px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="myModalLabel2">Purchase Orders</h2>
                    </div>
                    <div class="modal-body" id="purchmodalbody">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
                    </div>
                </div>
            </div>
        </div>	
	</div>
</div>
</div>
<script type="text/javascript">
	function invoicepurchase(id,year,month) {
		//get the merchant data from the backend and render on the modal
		console.log(month);
		$("#hp" + year + "-" + month).hide();
		$("#ip" + year + "-" + month).show();
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/invoicepurchase/stationdetail",
			data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
			beforeSend: function(){},
			success: function(response){
				$('#purchmodalbody').html(response);
				$('#purchmodal').modal('toggle');
				$("#hp" + year + "-" + month).show();
				$("#ip" + year + "-" + month).hide();
			}
		});
	}

	function invoicestatement(id,year,month) {
		//get the merchant data from the backend and render on the modal
		console.log(month);
		$("#h" + year + "-" + month).hide();
		$("#i" + year + "-" + month).show();
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/invoicestatement/stationdetail",
			data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
			beforeSend: function(){},
			success: function(response){
				$('#invmodalbody').html(response);
				$('#invmodal').modal('toggle');
				$("#h" + year + "-" + month).show();
				$("#i" + year + "-" + month).hide();
			}
		});
	}
</script>
@stop