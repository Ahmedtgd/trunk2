<?php
use App\Http\Controllers\UtilityController as UC;
?>
<div class="none">
  @extends("common.default")
  @section("content")
@include('common.sellermenu')
  
</div>
<link rel="stylesheet" type="text/css" href="{{asset("css/rangeslider.css")}}">
<style type="text/css">
body{
  background:#ddd;
}

#main{
  background:#fff;
  margin: 0 auto;
  -moz-border-radius: 5px;
  border-radius: 5px;
  box-shadow:0 1px 2px hsla(0, 0%, 0%, 0.3);
  margin-top:25px;
  margin-bottom:50px;
  min-width:768px;
  padding-bottom: 20px;
  padding-top: 10px;
  display: inline-block;
}

#main .container{
  padding: 0px;
}
.container1{
  width: 750px;
  text-align: left;
}

#userInput{
  height:35px;
}

#barcode{
  vertical-align: middle;
}

#title{
  display:inline-block;
  margin-left: auto;
  margin-right: auto;
  text-align: left;
  line-height: 90%;
}

#title a:link{
  text-decoration: none;
  color: #000;
}

#title a:visited {
  text-decoration: none;
  color: #000;
}

#title a:hover {
  text-decoration: underline;
  color: #000;
}

#title a:active {
  text-decoration: underline;
  color: #000;
}

#invalid{
  display: none;
  color:#DE0000;
  margin-top:10px;
  font-size:14pt;
  vertical-align: middle;
}

#barcodeType{
  height:35px;
}
.blackhover:hover{
  background-color: #000;
}
.standard-button{
  width: 70px;
  height: 70px;
  border-radius: 5px;
  text-align: center;
  vertical-align: middle;
  font-size: 15px;
  cursor: pointer;
  margin-left: 8px;
  margin-bottom: 5px;
}
.barcode-container{
  height:200px;
  line-height: 200px;
  text-align: center;
  vertical-align: middle;
  margin-left: 25px;
  margin-right: 25px;
  width: 50%;
  float: left;
}

.description-text{
  height:42px;
}

.description-text p{
  position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

.value-text{
  height:42px;
  text-align: right;
}

.value-text p{
  position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
.form-group{
  width: 50%;
  float: left;
}
.center-text{
  text-align: center;
}

.search-bar{
  margin-bottom: 20px;
}

.slider-container{
  margin-top: 17px;
}

.input-container{
  margin-top: 5px;
}

.barcode-select{
  border-color: #ccc;
}

</style>

<div id="main">
  <div class="none">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-10 col-md-offset-1">
          <div id="title">
            <h1>Barcode Generator</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="barcode-container">
    <canvas id="barcode"></canvas>
    <span id="invalid">Not valid data for this barcode type!</span>
  </div>
  <div style="width: 45%;float: left;" class="none">
    <form class="form-horizontal">

      <div style="width: 100%;float: left;" class="container">
        <div class="row">
          <div class="">



            <!-- Text input-->
            <div style="width: 100%;" class="form-group">
              <label class="col-md-2 col-md-offset-2 control-label" for="">Barcode Value</label>  
              <div class="col-md-6">
                <input id="userInput" name="" placeholder="Barcode" class="form-control input-md" required="" type="text" value="{{$product['nproduct_id']}}">
                <span class="help-block">This value will be converted to barcode</span>  
              </div>
            </div>
            <!-- Text input-->
            <div style="width: 100%;" class="form-group">
              <label class="col-md-2 col-md-offset-2 control-label" for="">Description</label>  
              <div class="col-md-6">
                <input id="description" name="" placeholder="Barcode" class="form-control input-md" required="" type="text" value="{{$product['name']}}">
                <span class="help-block">This value will show on top barcode</span>  
              </div>
            </div>
            <div style="width: 100%;" class="form-group">
              <label class="col-md-2 col-md-offset-2 control-label text-left"
			  for="">Price&nbsp;&nbsp;{{$currentCurrency}}</label>  
              <div class="col-md-6">
                <input id="price" placeholder="Price" value="" class="form-control input-md" required="" type="text" >
                <span class="help-block">This value will show below description</span>  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="width: 100%;float: left;" class="none">

      <div style="width: 100%;float: left;" class="container">
        <div class="row">

          <div class="form-group">
            <label class="col-md-2 col-md-offset-2 control-label text-left"
				for="">Bar&nbsp;Width</label>  
            <div class="col-md-6 slider-container">
              <input id="bar-width" type="range" min="1" max="3" step="1" value="2"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-width-display"></span></p>
            </div>
          </div>
          {{-- Height --}}
          <div style="width: 48%;" class="form-group">
            <label class="col-md-2 col-md-offset-2 control-label text-left"
				for="">Bar&nbsp;Height</label>  
            <div class="col-md-6 slider-container">
              <input id="bar-height" type="range" min="15" max="150" step="15" value="100"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-height-display"></span></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 col-md-offset-2 control-label text-left"
				for="">Font&nbsp;Size</label>  
            <div class="col-md-6 slider-container">
              <input id="bar-fontSize" type="range" min="8" max="26" step="1" value="20"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-fontSize-display"></span></p></div>
          </div>
          <div style="width: 48%;" class="form-group">
            <label class="col-md-2 col-md-offset-2 control-label" for="">Text Margin</label>  
            <div class="col-md-6 slider-container">
              <input id="bar-text-margin" type="range" min="-15" max="35" step="1" value="0"/>
            </div>
            <div class="col-md-1 col-xs-1 col-xs-11 value-text"><p><span id="bar-text-margin-display"></span></p></div>
          </div>
          <div class="form-group">
            <label class="col-md-2 col-md-offset-2 control-label text-left"
				for="">Show&nbsp;Text</label>  
            <div class="col-md-6 center-text">
              <div class="btn-group btn-group-md" role="toolbar">
                <button type="button" class="btn btn-default btn-primary display-text" value="true">Show</button>
                <button type="button" class="btn btn-default display-text" value="false">Hide</button>
              </div>
            </div>
          </div>
         {{--  <div class="form-group">
            <label class="col-md-2 col-md-offset-2 control-label" for="">Background</label>  
            <div class="col-md-6 center-text">
              <div class="btn-group btn-group-md">
                <input type="" name="" id="background-color">
              </div>
            </div>
          </div> --}}
          <span id="font-options">
            <div class="form-group">
              <label class="col-md-2 col-md-offset-2 control-label" for="">Text Align</label>  
              <div class="col-md-6 center-text">
                <div class="btn-group btn-group-md" role="toolbar">
                  <button type="button" class="btn btn-default text-align" value="left">Left</button>
                  <button type="button" class="btn btn-default btn-primary text-align" value="center">Center</button>
                  <button type="button" class="btn btn-default text-align" value="right">Right</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 col-md-offset-2 control-label text-left"
			  	for="">Font</label>  
              <div class="col-md-6 center-text">
                <select class="form-control" id="font" style="font-family: monospace">
                  <option value="monospace" style="font-family: monospace" selected="selected">Monospace</option>
                  <option value="sans-serif" style="font-family: sans-serif">Sans-serif</option>
                  <option value="serif" style="font-family: serif">Serif</option>
                  <option value="fantasy" style="font-family: fantasy">Fantasy</option>
                  <option value="cursive" style="font-family: cursive">Cursive</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 col-md-offset-2 control-label" for="">Font Options</label>  
              <div class="col-md-6 center-text">
                <div class="btn-group btn-group-md" role="toolbar">
                  <button type="button" class="btn btn-default font-option" value="bold" style="font-weight: bold">Bold</button>
                  <button type="button" class="btn btn-default font-option" value="italic" style="font-style: italic">Italic</button>
                </div>
              </div>
            </div>

          </span>
          <div style="float: right;" class="form-group">
            
            <div style="float: left; margin-left: 27%;"
				class="col-md-6 center-text">

              <button style="float: right; margin-right: 10%;"   type="button" class="btn standard-button blackhover btn-primary " value="center" id="print">Print</button>
              <a style="padding: 0; padding-top: 24px;  float: right;font-size:13px;
			  	margin-left: 36%;" download="barcode_{{$product['nproduct_id']}}.png" class="btn blackhover standard-button btn-warning" id="download"
              href="#">Download</a>

            </div>

          </div>
        </form>
      </div>
    </div>


    <!-- Bar width -->
        {{--
        <!-- Margin -->
        <div class="row">
          <div class="col-md-2 col-xs-12 col-md-offset-2 description-text"><p>Margin</p></div>
          <div class="col-md-7 col-xs-11 slider-container"><input id="bar-margin" type="range" min="0" max="25" step="1" value="10"/></div>
          <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-margin-display"></span></p></div>
        </div>
        <!-- Background (color) -->
        
        <div class="row">
          <div class="col-md-2 col-xs-12 col-md-offset-2 description-text"><p>Background</p></div>
          <div class="col-md-7 col-xs-11 input-container"><input id="background-color" class="form-control color" value="#FFFFFF"/></div>
          <div class="col-md-1 col-xs-1 value-text"></div>
        </div>
        <!-- Line color -->
        <div class="row">
          <div class="col-md-2 col-xs-12 col-md-offset-2 description-text"><p>Line Color</p></div>
          <div class="col-md-7 col-xs-11 input-container"><input id="line-color" class="form-control color" value="#000000"/></div>
          <div class="col-md-1 col-xs-1 value-text"></div>
        </div>
        --}}


      </div>
    </div>
  </div>
  @stop
  <style type="text/css">
  @media print
  {
    body * { visibility: hidden; overflow-y: hidden; }
    .none{display: none;}
    .barcode-container * { visibility: visible;  }
    .barcode-container { position: absolute; top: 40px; left: 30px; overflow-y: hidden; }
    .ofooter{display: none;}

  }
</style>
@section("scripts")
<script type="text/javascript" src="{{asset('js/rangeslider.js')}}"></script>
<script type="text/javascript" src="{{asset('js/barcode.js')}}"></script>
<script type="text/javascript">
  $('#print').click(function(){
   window.print();

 });
  var defaultValues = {
    CODE128 : "Example 1234",
    CODE128A : "EXAMPLE",
    CODE128B : "Example text",
    CODE128C : "12345678",
    EAN13 : "1234567890128",
    EAN8 : "12345670",
    UPC : "123456789999",
    CODE39 : "EXAMPLE TEXT",
    ITF14 : "10012345000017",
    ITF : "123456",
    MSI : "123456",
    MSI10 : "123456",
    MSI11 : "123456",
    MSI1010 : "123456",
    MSI1110 : "123456",
    pharmacode : "1234"
  };
  /* REGISTER DOWNLOAD HANDLER */
/* Only convert the canvas to Data URL when the user clicks. 
This saves RAM and CPU ressources in case this feature is not required. */
function dlCanvas() {
  var canvas = document.getElementById("barcode");
  var dt = canvas.toDataURL('image/png');
  /* Change MIME type to trick the browser to downlaod the file instead of displaying it */
  dt = dt.replace(/^data:image\/[^;]*/, 'data:application/octet-stream');

  /* In addition to <a>'s "download" attribute, you can define HTTP-style headers */
  dt = dt.replace(/^data:application\/octet-stream/, 'data:application/octet-stream;headers=Content-Disposition%3A%20attachment%3B%20filename=Canvas.png');

  this.href = dt;
};
document.getElementById("download").addEventListener('click', dlCanvas, false);
$(document).ready(function(){
  /*$('#background-color').ColorPicker({flat:true});*/
  $("#userInput").on('input',newBarcode);
  $("#price").on('input',newBarcode);
  $("#description").on('input',newBarcode);
  $("#barcodeType").change(function(){
   $("#userInput").val( defaultValues[$(this).val()] );
   newBarcode();
 });

  $(".text-align").click(function(){
    $(".text-align").removeClass("btn-primary");
    $(this).addClass("btn-primary");
    newBarcode();
  });

  $(".font-option").click(function(){
    if($(this).hasClass("btn-primary")){
      $(this).removeClass("btn-primary");
    } else {
      $(this).addClass("btn-primary");
    }

    newBarcode();
  });

  $(".display-text").click(function(){
    $(".display-text").removeClass("btn-primary");
    $(this).addClass("btn-primary");

    if($(this).val() == "true"){
      $("#font-options").slideDown("fast");
      $("#font-options").css("display","block");
    } else {
      $("#font-options").slideUp("fast");
    }
    newBarcode();
  });

  $("#font").change(function(){
    $(this).css({"font-family": $(this).val()});
    newBarcode();
  });
  $("#background-color").change(function(){
    newBarcode();
  });

  $('input[type="range"]').rangeslider({
    polyfill: false,
    rangeClass: 'rangeslider',
    fillClass: 'rangeslider__fill',
    handleClass: 'rangeslider__handle',
    onSlide: newBarcode,
    onSlideEnd: newBarcode
  });

    //$('.color').colorPicker({renderCallback: newBarcode});

    newBarcode();
  });

var newBarcode = function() {
    //Convert to boolean
    value=$("#userInput").val();
    console.log("Width",parseInt($("#bar-width").val()));
    $("#barcode").JsBarcode(
      $("#userInput").val(), {
			"background":"white", //Transparent bg-> undefined, no quotes
			"lineColor":"black",
			"fontSize": parseInt($("#bar-fontSize").val()),
			"height": parseInt($("#bar-height").val()),
			"width": $("#bar-width").val(),
			"margin":25,
			"textMargin": parseInt($("#bar-text-margin").val()),
			"displayValue": $(".display-text.btn-primary").val() == "true",
			"font": $("#font").val(),
			"fontOptions": $(".font-option.btn-primary").map(function(){return this.value;}).get().join(" "),
			"textAlign": $(".text-align.btn-primary").val(),
			"price":$("#price").val(),
			"description":$("#description").val(),
			"valid": function(valid){
        if(valid){
          $("#barcode").show();
          $("#invalid").hide();
        } else{
          $("#barcode").hide();
          $("#invalid").show();
        }
      }
    });

    $("#bar-width-display").text($("#bar-width").val());
    $("#bar-height-display").text($("#bar-height").val());
    $("#bar-fontSize-display").text($("#bar-fontSize").val());
    $("#bar-margin-display").text($("#bar-margin").val());
    $("#bar-text-margin-display").text($("#bar-text-margin").val());
    
  };


</script>
@stop
