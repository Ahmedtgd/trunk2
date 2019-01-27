
<div class="row">
  <div class="col-sm-4">
    {{-- For Image --}}
    <img src="{{asset('images/product/'.$product->id.'/thumb/'.$product->image)}}"
    style="width:150px !important;" 
    >



 </div>
  <div class="col-sm-8">
      <table class="table" style="border:none">
        <tr >
          
            <td class="pull-left" style="border: none !important;">Quantity Left </td>
            <td style="border: none !important;">{{$qtyleft}}</td>
          
        </tr>
        <tr style="border: none !important;">
          <td class="pull-left" style="border: none !important;">Average Cost (Based on Qty Purchased)</td>
          <td style="border: none !important;">{{$currentCurrency}} {{number_format($avg/100,2)}}</td>
        </tr>
        <tr>
          <td colspan="2">
            <span class="text-danger pull-left"  >
              *Qty purchased will be entered into the accounting system, and won't be taken into account as a physical stock until a physical Stock-In occurs.
            </span>
          </td>
        </tr>
      </table>
  </div>
</div>
<div class="row" >
  <div class="col-sm-12">
    <p class="text-danger pull-left" style="text-align:left !important;">
      

    </p>
  </div>
</div>
<table style="width: 100%; " id="einventorydetails" class="table ">
  <thead class="bg-inventory">
    <tr >
      <th class="text-center" scope="col">No</th>
      <th class="text-left" scope="col">Last Purchased</th>
      <th class="text-right" scope="col">Cost ({{$currentCurrency}})</th>
      <th class="text-center" scope="col">Qty Purchased</th>
    </tr>
  </thead>
  <tbody>
    <?php $index =0; ?>
    @foreach($inventorydetails as $inventorydetails)
    <tr style="padding: 8px 18px;">
      <th class="text-center">{{++$index}}</th>
      <td class="text-left">{{date('dMy H:i', strtotime($inventorydetails->created_at))}}</td>
      <td class="text-right">{{number_format($inventorydetails->cost/100,2)}}</td>
      <td class="text-center">{{$inventorydetails->purchaseqty}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<script type="text/javascript">
 $('#einventorydetails').DataTable({
  "order": [],

}); 

</script>
