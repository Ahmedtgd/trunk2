<div>
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

.delete-rack{
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
  font-size: 15px;
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
  width: 288px;
  font-size: 15px;

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
    
  
 

  <div id="qrcode-container-download" >



   <div style="background-color: #fff" id="qrcode-container" class="qrcode-container">
    <div style="word-wrap: break-word;" class="productname"></div>
    <div id="qrcode"></div>
   
    <div class="productexpiry"></span><span class="qrprice"> </span></div>

    <span id="invalid">Not valid data for this QR Code type!</span>
  </div>

</div>
<input type="number" value="" id="totalqr" hidden="hidden" name=""> 


</div>


<div class="none">

        <form style="margin:0px;" class="form-horizontal">
<div style="width: 50%;float: right;height: auto; padding-left: 6%;    padding-top: 5px;" class="rightside">
  
          <input type="text" id="row_id" name="row_id" hidden>

          <!-- Text input-->
          <div class="form-group">
            <label style="float: left;" class=" control-label" for="">QR Code Value</label>

            <div style="width: 60%;" class="col-md-6">
              <input disabled="disabled" id="userInput" name="" placeholder="qrcode" class="form-control input-md" required="" type="text" value="">
              <span class="help-block">This value will be converted to QR Code</span>  
            </div>
          </div>
          <!-- Text input-->
          <div class="form-group">
            <label style="float: left;width:75px" class=" control-label" for="">Rack No.</label>  
            <div style="margin-left: 4%;    width: 60%;" class="col-md-6">
              <input id="description" readonly name="description"  placeholder="Rack No." class="form-control input-md" required="" type="text" value="">
              <span class="help-block">This value will show on top QR Code</span>  
            </div>
          </div>
          <div class="form-group">
            <label style="float: left;width:75px" class=" control-label" for="">Description</label>  
            <div style="margin-left:4%;width: 60%;" class="col-md-6">
              <input id="price" placeholder="Description of the rack" value="" class="form-control input-md" required="" type="text" >

              <span class="help-block">This value will show below the QR Code</span>  
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
<div style="width: 50%;float: right;height: auto; padding-left: 6%;    padding-top: 5px;" class="rightside">
          <div class="form-group control-bar">
            <label style="float: left;    padding-top: 11px;" class="control-label" for="">Bar Height</label>
            <div style="padding-left: 7%;width: 67%;" class="col-md-6 slider-container">
              <input id="bar-height" type="range" min="10" max="150" step="1" value="110"/>
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
            
            <div style="    width: 58%;"  class="">
              {{-- <button style=" color: #fff;" type="button"  class="btn btn-danger blackhover delete-rack btn-primary " value="center" id="delete">Delete</button> --}}

              <button style=" color: #fff;" type="button" class="btn btn-default blackhover print_qr btn-primary " value="center" id="print">Print</button>
             
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



</div>



<script>

  $("body").on("click",".delete-rack",function(){
    //alert("hi");
			$rack_no=$(this).attr("rel-rackno");
      //$row=$(row_id;
			$row=$("input[name=row_id]").val();
      $("input[name=rack_row_number]").val($row);
      
			//alert($rack_no);
		//	$("#racknomodalpro").text(pad($rack_no));
			//$warehouse_id=$(this).attr("rel-warehouseid");
			//get_rack_product_data($rack_no,$warehouse_id);
			$("#deleteModal").modal("show");

		});

  		
</script>


