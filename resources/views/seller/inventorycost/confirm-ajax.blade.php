
<script type="text/javascript">
    (function(){
        $('.jquidatepicker').datepicker({
          altField: "#doc_date",
          altFormat: "yy-mm-dd",
          maxDate: "+1D"
        });
      })(jQuery);
    $('#doc_no').on('input', function() {
    });
 function saveinventorycost() {
   var doc_no = $('#doc_no').val();
   var doc_date = $('#doc_date').val();
   var merchant = $('#setbuyer').val();
   var isemerchant = $('#isbuyer').val();
   if(doc_no!="" && doc_date!="")
   {

    $.ajax({
      type: "GET",
      url: JS_BASE_URL+"/seller/saveinventorycost/"+merchant+"/"+isemerchant+"/"+doc_no+"/"+doc_date,
      success: function( data ) {
       if (data==0) {
          toastr.error('Document Number already Exist !');
       } else{
        $('input[name=doc_no]').val(doc_no);
        $('input[name=doc_date]').val(doc_date);
           document.getElementById('submitform').disabled = false;
       }
      }
    });
  }
  else
  {

  }

}
</script>

<form id="docnovalidate" method="post">
<div class="row">
  <div class="col-md-6 col-sm-6 col-xs-6">
    <label class="pull-left">Document No: </label>
<input onblur="saveinventorycost()" type="text" required="required" class="form-control" id="doc_no" name="">
  </div>
  <div style="color:red"
	class="text-left col-md-6 col-sm-6 col-xs-6">
	<br>
	*Qty purchased will be entered into the accounting system, and won't be taken into account as a physical stock, until a physical Stock-In occurs.
  </div>
</div>

<div style="margin-top: 10px;" class="row">
   <div class="col-md-6 col-sm-6 col-xs-6">
    <label class="pull-left">Document Date: </label>
    <input type="text" class="jquidatepicker form-control">
    <input onblur="saveinventorycost()" type="text" required="required" max="{{date('Y-m-d')}}" class="form-control" id="doc_date" name="" style="display: none;">
  </div>
</div>
<!--
<div style="color:red;margin-top: 10px;" class="text-left row">
   <div class="col-md-6 col-sm-6 col-xs-6">
	*Qty purchased will be entered into the accounting system, and won't be taken into account as a physical stock, until a physical Stock-In occurs.
   </div>
</div>
-->
</form>
<br><br>

<table style="width: 100%; " id="einventoryconfirm" class="table ">
  <thead class="bg-inventory">
    <tr >
      <th class="text-center" scope="col">No</th>
      <th class="text-left" scope="col">Product&nbsp;Name</th>
      <th class="text-right" scope="col">Price (MYR)</th>
      <th class="text-center" scope="col">Qty</th>
      <th class="text-right" scope="col">Total (MYR)</th>
    </tr>
  </thead>
  <tbody>
    <?php $index = 0;?>
    @foreach($product as $product)
      <tr style="padding: 8px 18px;">
      <th class="text-center">{{++$index}}</th>
      <td class="text-left">
        <div style="width: 100%;float: left;">
                @if(File::exists(URL::to("images/product/$product[id]/thumb/$product[thumb]")))
                <img width="30" height="30" src="{{URL::to("images/product/$product[id]/thumb/$product[thumb]")}}">
                @else
                <img width="30" height="30" src="{{URL::to("images/product/$product[id]/thumb/$product[thumb]")}}">
                @endif
                &nbsp
                {{$product['name']}}
              </div>



      </td>
      <td class="text-right">{{number_format($product['price'],2)}}</td>
      <td class="text-center">{{$product['quantity']}}</td>
      <td class="text-right">{{number_format($product['price']*$product['quantity'],2)}}</td>
    </tr>
    @endforeach
  </tbody>
</table>


<div id="ioConfirmSIModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm Action</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <span class="text-primary">Would you like to do Stock In?</span>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <select class="form-control" name="location_id" id="location_id">
              @foreach($locations as $location)
              <option value="{{$location->id}}">{{$location->location}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left confirmsubmitform" actiontype="nonstockreport" location_id="null">Confirm Without Stock In</button>
        <button type="button" class="btn btn-primary pull-right confirmsubmitform" actiontype="stockreport" disabled="disabled">Confirm With Stock In</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
 $('#einventoryconfirm').DataTable({
  "order": [],

});

$(document).ready(function(){
  $("#location_id").change(function(){
      $(".confirmsubmitform").attr('location_id',$(this).val())
      $(".confirmsubmitform").prop("disabled",false)
  });
})


</script>
