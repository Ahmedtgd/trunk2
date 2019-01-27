<input type="hidden" name="SelectedProductTotalprice" id="SelectedProductTotalprice" value="{{ $SelectedProductTotalprice }}">
<table style="width: 100%; " id="gatorconfirm" class="table ">
  <thead class="bg-gator">
    <tr >
      <th class="text-center" scope="col">No</th>
      <th class="text-left" scope="col">Product&nbsp;Name</th>
      <th class="text-right" scope="col">Price (MYR)</th>
      <th class="text-center" scope="col">Qty</th>
      <th class="text-right" scope="col">Total (MYR)</th>
    </tr>
	</thead>
	<tbody>
	<?php
		$index =0;
		Log::debug('***** confirm-ajax.blade.php *****');
		Log::debug(json_encode($product));
	?>

	@foreach($product as $product)

    <tr style="padding: 8px 18px;">
      <th class="text-center">{{++$index}}</th>
      <td class="text-left">
        @if(File::exists(URL::to("images/product/".$product['id']."/thumb/".$product["thumb_photo"])))
          <img width="30" height="30" src="{{URL::to("images/product/".$product['id']."/thumb/".$product["thumb_photo"])}}">
        @else
          <img width="30" height="30" src="{{URL::to("images/product/".$product['parent_id']."/thumb/".$product["thumb_photo"])}}">

        @endif
        {{$product['name']}}</td>
      <td class="text-right">{{number_format($product['price']/100,2)}}</td>
      <td class="text-center">{{$product['quantity']}}</td>
      <td class="text-right">{{number_format($product['price']*$product['quantity']/100,2)}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<script type="text/javascript">
 $('#gatorconfirm').DataTable({
  "order": [],

}); 
</script>
