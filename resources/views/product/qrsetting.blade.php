<?php
use App\Http\Controllers\UtilityController as UC;
?>
<div class="none">
  @extends("common.default")
  @section("content")

@include('common.sellermenu')
</div>
<link rel="stylesheet" type="text/css" href="{{asset("css/rangeslider.css")}}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>
<style type="text/css">








#userInput{
  height:35px;
}

#qrcode{
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

#qrcodeType{
  height:35px;
}

.qrcode-container{

  /* line-height: 200px; */
  text-align: center;
  vertical-align: middle;
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

.center-text{
  text-align: center;
}
.nonebtn{
  display: none !important;
}

.container70{
  width: 70%;
  float: right;
}
.slider-container{
  margin-top: 17px;
}

.blackhover:hover{
  background-color: #000;
}
.print_qr{
  width: 70px;
  height: 70px;
  border-radius: 5px;
  text-align: center;
  vertical-align: middle;
  float: right;
  font-size: 15px;
  cursor: pointer;
  margin-left: 5px;
  margin-bottom: 5px;
}

.input-container{
  margin-top: 5px;
}

.qrcode-select{
  border-color: #ccc;
}
.productname {

  overflow:hidden; 
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical; 
  margin: auto;

}

.control-bar{
  width: 100%;
  float: left;
}

.productexpiry{
  height: 60px;
  overflow:hidden; 
  line-height: 1.5;
  padding-left:5px;

  margin: auto;
}

</style>

<div id="main">
   <div class="none">
    <div style="width: 100%;text-align: center;padding: 21px;">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div id="title">
            <h1>QR Code Generator</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div style="width: 50%;float: left;height: auto;" class="leftside">
    
  
 

  <?php  $savedata = $products;  ?>
  <?php $index = 1; ?>
  <div id="qrcode-container-download" >
   @foreach($products as $product)

   {{--*/ $created_at = new Carbon\Carbon($product['content']); /*--}}

   <div style="background-color: #fff" id="qrcode-container" class="qrcode-container">
    <div style="word-wrap: break-word;" class="productname">{{$product['name']}}</div>
    <div id="qrcode{{$index}}"></div>
    @if($product['content'])
    <div class="productexpiry">Exp:{{$created_at->day}}{{$created_at->format('M')}}{{$created_at->format('y')}}<br><span>{{$currency->code}} </span><span class="qrprice">{{ltrim(number_format(UC::realPrice($product['id'])/100,2), '0')}}</span></div>
    @else
    <div class="productexpiry"><br><span>{{$currency->code}} </span><span class="qrprice"> {{number_format(UC::realPrice($product['id'])/100,2)}}</span></div>
    @endif
    <span id="invalid">Not valid data for this QRcode type!</span>
  </div>
  <?php $index = ++$index; ?>
  @endforeach
</div>
<input type="number" value="{{$index}}" id="totalqr" hidden="hidden" name=""> 
</div>


<div class="none">

        <form style="margin:0px;" class="form-horizontal">
<div style="width: 50%;float: right;height: auto; padding-left: 6%;    padding-top: 5px;" class="rightside">
  


          <!-- Text input-->
          <div class="form-group">
            <label style="float: left;" class=" control-label" for="">QR Code Value</label>  
            <div style="    width: 60%;" class="col-md-6">
              <input disabled="disabled" id="userInput" name="" placeholder="qrcode" class="form-control input-md" required="" type="text" value="{{$product['nproduct_id']}};{{$product['content']}}">
              <span class="help-block">This value will be converted to QRcode</span>  
            </div>
          </div>
          <!-- Text input-->
          <div class="form-group">
            <label style="float: left;" class=" control-label" for="">Description</label>  
            <div style="margin-left: 4%;    width: 60%;" class="col-md-6">
              <input id="description" name="" placeholder="qrcode" class="form-control input-md" required="" type="text" value="{{$product['name']}}">
              <span class="help-block">This value will show on top QRcode</span>  
            </div>
          </div>
          <div class="form-group">
            <label style="float: left;" class=" control-label" for="">Price&nbsp;{{$currentCurrency}}</label>  
            <div style="    margin-left: 4%;    width: 60%;" class="col-md-6">
              <input id="price" placeholder="Price" value="{{number_format(UC::realPrice($product['id'])/100,2)}}" class="form-control input-md" required="" type="text" >
              <span class="help-block">This value will show below description</span>  
            </div>
          </div>
        
      
</div>
<div style="width: 100%;float: left;">
  <div style="width: 50%;float: left;height: auto;    margin-top: 4px;" class="leftside">
    
          <div class="form-group control-bar">
            <label style="padding-top: 11px;" class="col-md-2 col-md-offset-2 control-label" for="">Bar Width</label>
            <div class="col-md-6 slider-container">
              <input id="bar-width" type="range" min="1" max="150" step="1" value="100"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-width-display"></span></p>
            </div>
          </div>
          {{-- Height --}}
          
          <div class="form-group control-bar">
            <label style="padding-top: 11px;" class="col-md-2 col-md-offset-2 control-label" for="">Font Size</label>
            <div class="col-md-6 slider-container">
              <input id="bar-fontSize" type="range" min="8" max="20" step="1" value="13"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-fontSize-display"></span></p></div>
          </div>
          
          <div class="form-group  control-bar">
            <label class="col-md-2 col-md-offset-2 control-label" for="">Show Text</label>  
            <div class="col-md-6 center-text">
              <div class="btn-group btn-group-md" role="toolbar">
                <button type="button" class="btn btn-default btn-primary display-text" value="true">Show</button>
                <button type="button" class="btn btn-default display-text" value="false">Hide</button>
              </div>
            </div>
          </div>
          <div class="form-group control-bar">
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
        </div>
         {{--  <div class="form-group">
            <label class="col-md-2 col-md-offset-2 control-label" for="">Background</label>  
            <div class="col-md-6 center-text">
              <div class="btn-group btn-group-md">
                <input type="" name="" id="background-color">
              </div>
            </div>
          </div> --}}
<div style="width: 50%;float: right;height: auto; padding-left: 6%;    padding-top: 5px;" class="rightside">
          <div class="form-group control-bar">
            <label style="float: left;    padding-top: 11px;" class="control-label" for="">Bar Height</label>
            <div style="padding-left: 7%;width: 67%;" class="col-md-6 slider-container">
              <input id="bar-height" type="range" min="10" max="150" step="1" value="100"/>
            </div>
            <div class="col-md-1 col-xs-1 value-text"><p><span id="bar-height-display"></span></p>
            </div>
          </div>
          <div  class="form-group control-bar">
            <label style="float: left;padding-top: 11px;" class="control-label" for="">Text Margin</label>
            <div style="    padding-left: 5%; width: 66%;" class="col-md-6 slider-container">
              <input id="bar-text-margin" type="range" min="-15" max="40" step="1" value="0"/>
            </div>
            <div class="col-md-1 col-xs-1 col-xs-11 value-text"><p><span id="bar-text-margin-display"></span></p></div>
          </div>
          <span id="font-options">
            <div  class="form-group control-bar">
              <label style="float: left; " class="control-label" for="">Text Align</label>  
              <div style=" margin-left: 11%;" class="col-md-6 center-text">
                <div class="btn-group btn-group-md" role="toolbar">
                  <button type="button" class="btn btn-default text-align" value="left">Left</button>
                  <button type="button" class="btn btn-default btn-primary text-align" value="center">Center</button>
                  <button type="button" class="btn btn-default text-align" value="right">Right</button>
                </div>
              </div>
            </div>
            
            <div class="form-group control-bar">
              <label style="    float: left; padding-top: 6px   " class="" for="">Font Options</label>
              <div style=" margin-left: 8%;" class="col-md-6 center-text">
                <div class="btn-group btn-group-md" role="toolbar">
                  <button type="button" class="btn btn-default font-option" value="bold" style="font-weight: bold">Bold</button>
                  <button type="button" class="btn btn-default font-option italic" value="italic" style="font-style: italic">Italic</button>
                </div>
              </div>
            </div>

          </span>
          <div class="form-group">
            
            <div style="    width: 58%;"  class="col-md-10 center-text">

              <button style=" color: #fff;" type="button" class="btn btn-default blackhover print_qr btn-primary " value="center" id="print">Print</button>
             {{-- <a hidden="hidden"  download="qrcode_{{$product->nproduct_id}}.png" class="btn btn-warning" id="download"
               href="#">Download</a> --}}
               <input style="   
               text-align: center;
               
               padding: 4px;
               padding-top: 23px; color: #fff;    padding-top: 2px;" id="btn-Preview-Image" class="btn print_qr btn-warning" type="button" value="Convert"/>
               <a style="    padding-top: 21px;
               padding-left: 3px;" class="btn print_qr btn-danger blackhover nonebtn"  id="btn-Convert-Html2Image" href="#">Download</a>
             </div>

           </div>
         </div>
       </div>
         </form>
       </div>
     </div>





     <div id="previewImage">
     </div>


     <script>
      $(document).ready(function(){


var element = $("#qrcode-container-download"); // global variable
var getCanvas; // global variable

$("#btn-Preview-Image").on('click', function () {
      //toastr.info('Please Wait Converting');
      html2canvas(element, {
       onrendered: function (canvas) {
                //$("#previewImage").append(canvas);
                getCanvas = canvas;
                $('#btn-Convert-Html2Image').removeClass("nonebtn");

                toastr.success('Convertd Ready for download');

              }
            });
    });

$("#btn-Convert-Html2Image").on('click', function () {

  var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "{{$product['id']}}.png").attr("href", newData);
  });

});

</script>

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
    .qrcode-container * { visibility: visible;  }

    .qrcode-container-download * { visibility: visible;  }
    .qrcode-container { top: 40px; left: 30px;  }
    .ofooter{display: none;}

  }
</style>
@section("scripts")
<script type="text/javascript" src="{{asset('js/rangeslider.js')}}"></script>
<script type="text/javascript" src="{{asset('js/canvas.js')}}"></script>

<script type="text/javascript" src="{{asset('js/qr.js')}}"></script>

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
/*function dlCanvas() {


  var element = $("#qrcode-container").html(); // global variable
  var getCanvas; // global variable
 

         html2canvas(element, {
         onrendered: function (canvas) {
                
                getCanvas = canvas;
             }
         });


  //var canvas = document.getElementById("qrcode");
  var dt = getCanvas.toDataURL('image/png');
   //Change MIME type to trick the browser to downlaod the file instead of displaying it 
  dt = dt.replace(/^data:image\/[^;]*///, 'data:application/octet-stream');

  /* In addition to <a>'s "download" attribute, you can define HTTP-style headers */
 // dt = dt.replace(/^data:application\/octet-stream/, 'data:application/octet-stream;headers=Content-Disposition%3A%20attachment%3B%20filename=Canvas.png');

  //this.href = dt;
//};*/
//document.getElementById("download").addEventListener('click', dlCanvas, false);
$(document).ready(function(){


 $("#description").change(function(){
  $('.productname').html($('#description').val());
});
 /*$('#background-color').ColorPicker({flat:true});*/
 $("#userInput").on('input',newqrcode);
 $("#price").on('input',function(){

  $('.qrprice').html($("#price").val());
});
 $("#description").on('input',function(){

 });
 $("#qrcodeType").change(function(){
   $("#userInput").val( defaultValues[$(this).val()] );
   newqrcode();
 });

 $(".text-align").click(function(){
  $(".text-align").removeClass("btn-primary");
  $(this).addClass("btn-primary");
  $('.productname').css("text-align", $(this).val());
  $('.productexpiry').css("text-align", $(this).val());

});

 $(".font-option").click(function(){
  if($(this).hasClass("btn-primary")){
    $(this).removeClass("btn-primary");
    $('.productname').css("font-weight","");
    $('.productexpiry').css("font-weight","");
  } else {
    $(this).addClass("btn-primary");
    $('.productname').css("font-weight", $(this).val());
    $('.productexpiry').css("font-weight", $(this).val());
  }


});

 $(".italic").click(function(){
  if(!$('.italic').hasClass("btn-primary")){
    $('.italic').removeClass("btn-primary");
    $('.productname').css("font-style","");
    $('.productexpiry').css("font-style","");
  } else {
    $('.italic').addClass("btn-primary");
    $('.productname').css("font-style", $(this).val());
    $('.productexpiry').css("font-style", $(this).val());
  }


});

 $(".display-text").click(function(){
  $(".display-text").removeClass("btn-primary");
  $(this).addClass("btn-primary");

  if($(this).val() == "true"){
    $("#font-options").slideDown("fast");

    $("#font-options").css("display", 'block');
  } else {
    $("#font-options").slideUp("fast");
  }
  newqrcode();
});

 $("#font").change(function(){
  $(this).css({"font-family": $(this).val()});
  $('.productname').css("font-family", $(this).val());
  $('.productexpiry').css("font-family", $(this).val());
});
 $("#background-color").change(function(){
  newqrcode();
});

 $('input[type="range"]').rangeslider({
  polyfill: false,
  rangeClass: 'rangeslider',
  fillClass: 'rangeslider__fill',
  handleClass: 'rangeslider__handle',
  onSlide: newqrcode,
  onSlideEnd: newqrcode
});

    //$('.color').colorPicker({renderCallback: newqrcode});

    newqrcode();
  });

var newqrcode = function() {

    /*value=$("#userInput").val();
    console.log("Width",parseInt($("#bar-width").val()));
    $("#qrcode").Jsqrcode(
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
                $("#qrcode").show();
                $("#invalid").hide();
              } else{
                $("#qrcode").hide();
                $("#invalid").show();
              }
            }
          });*/
          var margin =   $("#bar-text-margin").val()
          $('.productname').css("margin-bottom", margin);
          $('.productexpiry').css("margin-top", margin);
          var value=$("#userInput").val();
          var maxqr = $('#totalqr').val();
          for (var i = 1;  i < maxqr; i++) {
            $(`#qrcode`+i).html('');


            $(`#qrcode`+i).qrcode({height:parseInt($("#bar-height").val()),width:parseInt($("#bar-width").val()),text:value});

          }
          $('.productname').css("width", $("#bar-width").val()*2);
          $('.productexpiry').css("width", $("#bar-width").val());

          $('.productname').css("font-size", $("#bar-fontSize").val());
          $('.productexpiry').css("font-size", $("#bar-fontSize").val());



          $("#bar-width-display").text($("#bar-width").val());
          $("#bar-height-display").text($("#bar-height").val());
          $("#bar-fontSize-display").text($("#bar-fontSize").val());
          $("#bar-margin-display").text($("#bar-margin").val());
          $("#bar-text-margin-display").text($("#bar-text-margin").val());

        };


      </script>
      @stop
