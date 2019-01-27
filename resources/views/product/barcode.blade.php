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
.standerd-button{
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
  width: 49%;
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
    <form class="form-horizontal" id="myForm">
      <input type="hidden" id="sid" name="sid" value="<?php echo session_id(); ?>" />
      <div style="width: 100%;float: left;" class="container">
        <div class="row">
          <div class="">



            <!-- Text input-->
            <div style="width: 100%;" class="form-group">
              <label style="float: left" class="col-md-2 col-md-offset-2 control-label" for="">Barcode Value</label>
              <div class="col-md-6">
                <input id="userInput" name="" placeholder="Barcode" class="form-control input-md" required="" type="text" value="{{$barcode}}">
                <span class="help-block">This value will be converted to barcode</span>  
              </div>
            </div>
            <!-- Text input-->
            <div style="width: 100%;" class="form-group">
              <label style="float: left" class="col-md-2 col-md-offset-2 control-label" for="">Description</label>
              <div class="col-md-6">
                <input id="description" name="" placeholder="Barcode" class="form-control input-md" required="" type="text" value="{{$product->name}}">
                <span class="help-block">This value will show on top barcode</span>  
              </div>
            </div>
            <div style="width: 100%;" class="form-group">
              <label style="float: left;" class="col-md-2 col-md-offset-2 control-label" for="">Price    {{$currency->code}}</label>
              <div class="col-md-6">
               
                
                <input id="price" placeholder="Price" value="{{ltrim(number_format(UC::realPrice($product->id)/100,2), '0')}}" class="form-control input-md" required="" type="text" >
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
            <label style="    margin-top: 10px;" class="col-md-2 col-md-offset-2 control-label" for="">Bar Width</label>  
            <div class="col-md-6 slider-container">
              <input id="bar-width" type="range" min="1" max="3" step="1" value="2"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-width-display"></span></p>
            </div>
          </div>
          {{-- Height --}}
          <div style="    width: 48%;" class="form-group">
            <label  style="    margin-top: 10px;" class="col-md-2 col-md-offset-2 control-label" for="">Bar Height</label>  
            <div class="col-md-6 slider-container">
              <input id="bar-height" type="range" min="15" max="150" step="15" value="100"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-height-display"></span></p>
            </div>
          </div>
          <div class="form-group">
            <label  style="margin-top: 10px;" class="col-md-2 col-md-offset-2 control-label" for="">Font Size</label>
            <div class="col-md-6 slider-container">
              <input id="bar-fontSize" type="range" min="8" max="26" step="1" value="20"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-fontSize-display"></span></p></div>
          </div>
          <div style="width: 48%; " class="form-group">
            <label style="float: left; padding-top: 10px;" class="col-md-2 col-md-offset-2 control-label" for="">Text Margin</label>
            <div class="col-md-6 slider-container">
              <input id="bar-text-margin" type="range" min="-15" max="35" step="1" value="0"/>
            </div>
            <div class="col-md-1 col-xs-1 col-xs-11 value-text"><p><span id="bar-text-margin-display"></span></p></div>
          </div>
          <div class="form-group">
            <label  style=" margin-top: 6px; " class="col-md-2 col-md-offset-2 control-label" for="">Show Text</label>  
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
              <label style="margin-top:5px;margin-bottom: 10px;padding-left: 10px;" class="col-md-2 col-md-offset-2 control-label" for="">Text Align</label>  
              <div class="col-md-6 center-text">
                <div class="btn-group btn-group-md" role="toolbar">
                  <button type="button" class="btn btn-default text-align" value="left">Left</button>
                  <button type="button" class="btn btn-default btn-primary text-align" value="center">Center</button>
                  <button type="button" class="btn btn-default text-align" value="right">Right</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 col-md-offset-2 control-label" for="">Font</label>  
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
              <label style="margin-top: 5px;margin-bottom: 10px;padding-left: 10px;" class="col-md-2 col-md-offset-2 control-label" for="">Font Options</label>  
              <div class="col-md-6 center-text">
                <div class="btn-group btn-group-md" role="toolbar">
                  <button type="button" class="btn btn-default font-option" value="bold" style="font-weight: bold">Bold</button>
                  <button type="button" class="btn btn-default font-option" value="italic" style="font-style: italic">Italic</button>
                </div>
              </div>
            </div>

          </span>
          <div style="float: right;" class="form-group">
            <div style="float:left;margin-left: 26%;" class="col-md-6 center-text">
              <button style="float: right; margin-right: 10%;"   type="button" class="btn standerd-button blackhover btn-primary " value="center" id="print">Print</button>
              <a style="padding: 0;font-size:13px;padding-top: 25px;float: right;margin-left: 36%;"download="barcode_{{$product->nproduct_id}}.png" class="btn blackhover standerd-button btn-warning" id="download" href="#">Download</a>
            </div>
          </div>

          <?php if(isset( $_GET["print"]) &&  $_GET["print"]==1){?>
          <div class="form-group">
              <label style="margin-top: 5px;margin-bottom: 10px;padding-left: 10px;" class="col-md-2 col-md-offset-2 control-label" for="">Printer Options</label>  
              <div class="col-md-6 center-text">
                <div class="" role="toolbar">
                  <select id="pid" name="pid">
                  <option selected="selected" value="0">Use Default Printer</option>
                  <option value="1">Display a Printer dialog</option>
                  <option value="2">Use an installed Printer</option>
                  <option value="3">Use an IP/Etherner Printer</option>
                  <option value="4">Use a LPT port</option>
                  <option value="5">Use a RS232 (COM) port</option>
              </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label style="margin-top:5px;margin-bottom:10px;padding-left:10px;" class="col-md-2 col-md-offset-2 control-label" for="">Installed printers</label>  
              <div class="col-md-6 center-text">
                <div class="btn-group btn-group-md" role="toolbar">
                  <div id="installedPrinter">
                    <div id="loadPrinters" name="loadPrinters">
                      installed printers in your machine. <a onclick="javascript:jsWebClientPrint.getPrinters();" class="btn btn-success">Load installed printers...</a>
                      <br /><br />
                    </div>
                    <label for="installedPrinterName">Select an installed Printer:</label>
                    <select name="installedPrinterName" id="installedPrinterName"></select>
                    <a href="#" onclick="javascript:doClientPrint();" class="btn btn-lg btn-success">Print</a>
                    <script type="text/javascript">
                    //var wcppGetPrintersDelay_ms = 0;
                    var wcppGetPrintersTimeout_ms = 10000; //10 sec
                    var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec
                    function wcpGetPrintersOnSuccess() {
                        // Display client installed printers
                        if (arguments[0].length > 0) {
                            var p = arguments[0].split("|");
                            var options = '';
                            for (var i = 0; i < p.length; i++) {
                                options += '<option>' + p[i] + '</option>';
                            }
                            $('#installedPrinterName').html(options);
                            $('#installedPrinterName').focus();
                            $('#loadPrinters').hide();
                        } else {
                            alert("----No printers are installed in your system.");
                        }
                    }

                    function wcpGetPrintersOnFailure() {
                        // Do something if printers cannot be got from the client 
                        alert("++++No printers are installed in your system.");
                    }
                </script>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
          </form>
        </div>
      </div>
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
<?php if(isset( $_GET["print"]) &&  $_GET["print"]==1){?>
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
{!! 
 
// Register the WCPP Detection script code
// The $wcpScript was generated by HomeController@index
 
$wcppScript;
 
!!}



<script type="text/javascript">
  // $(document).ready(function(){

  //   jsWebClientPrint.getPrinters();

  // });
 var wcppPingTimeout_ms = 10000; //10 sec
    var wcppPingTimeoutStep_ms = 500; //0.5 sec       
                  
    function wcppDetectOnSuccess(){
        // WCPP utility is installed at the client side
        // redirect to WebClientPrint sample page
                 
        // get WCPP version
        var wcppVer = parseInt(arguments[0]);
        if(wcppVer == "4"){
          }
        else{ //force to install WCPP v4.0
            wcppDetectOnFailure();
            // alert("please install latest version of WebClientPrint");
          }
    }
    function wcppDetectOnFailure() {
        // It seems WCPP is not installed at the client side
        // ask the user to install it
        $('#msgInProgress').hide();
        $('#msgInstallWCPP').show();
    }
    
 
    
 
</script>

<script type="text/javascript">
    var wcppGetPrintersTimeout_ms = 10000; //10 sec
    var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec
 
    function wcpGetPrintersOnSuccess(){
        // Display client installed printers
        if(arguments[0].length > 0){
            var p=arguments[0].split("|");
            var options = '';
            for (var i = 0; i < p.length; i++) {
                options += '<option>' + p[i] + '</option>';
            }
            $('#installedPrinters').css('visibility','visible');
            $('#installedPrinterName').html(options);
            $('#installedPrinterName').focus();
            $('#loadPrinters').hide();                                                        
        }else{
            alert("No printers are installed in your system.");
        }
    }
 
    function wcpGetPrintersOnFailure() {
        // Do something if printers cannot be got from the client
        alert("No printers are installed in your system.");
    }

    function doClientPrint() {

                    //collect printer settings and raw commands
                    var printJobInfo = $("#myForm").serialize();

                    var data = "^XA"
                              +"^BY5,2,270"
                              +"^FO220,50^ADN,36,20^FD"+ $('#description').val()+"^FS"
                              +"^FO50,130^BC^FD"+$('#userInput').val()+"^FS"
                              +"^FO380,470^ADN,36,20^FDMYR "+ $('#price').val()+"^FS"
                              +"^XZ";

                    // Launch WCPP at the client side for printing...
                    jsWebClientPrint.print(printJobInfo);

                }
</script>
 
 {!! 
 
// Register the WCPP Detection script code
// The $wcpScript was generated by HomeController@index
 
$wcpScript;
 
!!}
<?php } ?>

<script type="text/javascript" src="{{asset('js/rangeslider.js')}}"></script>
<script type="text/javascript" src="{{asset('js/barcode.js')}}"></script>
<script type="text/javascript">
  
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
      "price":"{{$currency->code}} "+$("#price").val(),
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