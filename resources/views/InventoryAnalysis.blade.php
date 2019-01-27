@extends("common.default")

@section("content")
 <div class="container" style="margin-top:30px;">
	<div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
		<div class="table-responsive col-sm-9 ">
                    <h3>Inventory</h3>
		    <table  id="grid">
		    	<thead>
<!--                            <tr class='thead' style="background-color: #948A54">
                                <th colspan="100" class='text-center' style='font-weight: 900; font-size: 20px; color: #fff' >
                                    Product Details
                                </th>
                            </tr>-->
                            <tr>
                                    <th class=''>No</th>
                                    <th class=''>Product ID</th>
                                    <th class=''>Name</th>
                                    <th class=''>Category</th>
                                    <th class=''>Sub Category</th>
                                    <th class=''>Brand</th>
                                    <th class=''>Description</th>
                                    <th class=''>Quantity</th>
                                    <th class=''>Retail Price</th>
                                    <th class=''>Original Price</th>
                                    <th class=''>Discount %</th>
                                    <th class=''>Wholesale Price</th>
                                    <th class=''>Unit</th>
                                </tr>
                        </thead>
                        <tbody class='text-center sub'>
                             <?php $i = 1;?>
                            @foreach($products as $product)
                            <?php $x = $product->id - 1;?>
                            <tr>
                                <td> 
                                    {{$i++}}
                                </td>
                                <td>
                                    @if(isset($product->id) && !empty($product->id))
                                        {{ $product->id }}
                                    @else
                                        {{"Product ID"}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($product->name) && !empty($product->name))
                                        {{$product->name}}
                                    @else
                                        {{"Name"}}
                                    @endif
                                </td>
                                <td>
                                     @if(isset($product->cat_description) && !empty($product->cat_description))
                                        {{$product->cat_description}}
                                    @else
                                        {{"Description"}}
                                    @endif
                                </td>
                                <td>
                                    {{$description[$x]}}
                                </td>
                                <td>
                                   @if(isset($product->name) && !empty($product->name))
                                        {{$product->brand_name}}
                                    @else
                                        {{"Brand"}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($product->description) && !empty($product->description))
                                        {{$product->description}}
                                    @else
                                        {{"Details"}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($product->available) && !empty($product->available))
                                        {{$product->available}}
                                    @else
                                        {{"Available"}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($product->retail_price) && !empty($product->retail_price))
                                        <?php 
                                        $retail_price = number_format($product->retail_price,2,'.',','); 
                                        ?>  
                                        {{$currency->code}}
                                        {{$retail_price}}
                                    @else
                                        {{"RetailPrice"}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($product->original_price) && !empty($product->original_price))
                                        <?php 
                                        $orginal_price = number_format($product->original_price,2,'.',','); 
                                        ?>
                                        {{$currency->code}}
                                        {{$orginal_price}}
                                    @else
                                        {{"OriginalPrice"}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($product->original_price) && !empty($product->original_price))
                                        <?php 
                                            $discount = (($product->original_price - $product->retail_price)/$product->retail_price)*100;
                                            $dis = number_format($discount , 2 , '.',',');    
                                        ?>
                                        {{ $dis }}
                                    @else
                                        {{"Discount"}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($product->price) && !empty($product->price))
                                        <?php 
                                           $wholesale_price = number_format($product->price,2,'.',','); 
                                        ?>
                                        {{$currency->code}}
                                        {{$wholesale_price}}
                                    @else
                                        {{"WholesalePrice"}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($product->unit) && !empty($product->unit))
                                        {{$product->unit}}
                                    @else
                                        {{"Unit"}}
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
		    </table>
		</div>
	</div>

 </div>
@stop