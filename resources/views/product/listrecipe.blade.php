<!-- <form id="form1"> -->
    <a href="#" style="background-color: #02d4f9;color:white;padding-top:27px" class=" sellerbuttons pull-right" onclick="saverawmaterial();">Save</a>
    <a href="#" data-toggle="modal" style="background-color: #ea6c06;color:white;padding-top:27px" data-target="" class="sellerbuttons pull-right" onclick="showrecipematerial()">
    + Material</a>
    <a href="#" data-toggle="modal" style="background-color: #ea6c06;color:white;padding-top:27px" data-target="" class="sellerbuttons pull-right" onclick="recipeq1()">Q1</a>
    <form id="rawmaterialform">
        <input type="hidden" name="item_product_id" value="{{$product_id}}">
    <div class='raw-datatable_td'>
    <table id="raw-datatable" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <td class="text-center bg-primaryorange">No</td>
                <td class="text-center bg-primaryorange">Product ID</td>
                <td class="text-center bg-primaryorange">Raw Material</td>
                <td class="text-center bg-primaryorange">Measurement</td>
                <td class="text-center bg-primaryorange">Unit</td>
            </tr>
        </thead>
        <tbody id="new-material">
            <?php $index = 0;?>
            @if(count($recipes) > 0)
                @foreach($recipes as $recipe)
                <tr id="rawmaterial_{{$recipe->raw_id}}">
                    <td class="text-center" style="vertical-align: middle">{{++$index}}</td>
                    <td class="text-center" style="vertical-align: middle">{{$recipe->npid}}</td>
                    <td class="text-left"
						style="vertical-align: middle;padding-left:0;padding-right:4px;padding-top:4px;padding-bottom:4px">
						<div class="col-md-2" style="padding-left:0;padding-right:0">
							<img width="30"  height="30"
							src="{{url()}}/images/product/{{$recipe->raw_id}}/thumb/{{$recipe->thumb_photo}}"></img>
						</div>
						<div class="col-md-10"
							style="vertical-align:middle;padding-left:10px;
							padding-top:6px;padding-right:0">
							{{$recipe->name}}
						</div>
					</td>
                    <td class="text-center" style="vertical-align: middle;width:50px">
                        <input class="form-control qtyfield  text-center" id="qty{{$recipe->raw_id}}" name="measuredata[]" type="number" value="{{$recipe->raw_qty}}"><input type="hidden" name="raw_product_id[]" value="{{$recipe->raw_id}}">
                    </td>
                    <td class="text-center" style="vertical-align: middle">
                        <span id="rawmaterialunit_{{$recipe->raw_id}}">{{$recipe->symbol}}</span>
                    </td>
                </tr>    
                @endforeach
            @endif
        </tbody>
    </table>
    </div>
    </form>

<script>
    $(document).ready(function() {
        $('#raw-datatable').DataTable();
    });
</script>
