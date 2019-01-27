@extends('common.default')

@section('content')
    @include('common.sellermenu')
    <style>
		.table-sections{padding-top: 20px;padding-bottom: 20px}
		.sellerbutton{
    		min-width: 70px;
    		min-height: 70px;
    		padding-top: 26px;
    		text-align: center;
    		vertical-align: middle;
    		float: left;
    		font-size: 13px;
    		cursor: pointer;
    		margin-right: 5px;
    		margin-bottom: 5px;
    		border-radius: 5px;
    		border: none;
    	}
    	.bg-primaryii{
    		background-color: #02d4f9;
    		color: #f6f6f6;
    	}
    	.bg-primaryorange{
    		background-color: #ea6c06;
    		color: #f6f6f6;
    	}

    	.sellerbuttons{
    		min-width: 70px;
    		min-height: 70px;
    		padding-top: 4px;
    		text-align: center;
    		vertical-align: middle;
    		float: left;
    		font-size: 13px;
    		cursor: pointer;
    		margin-right: 5px;
    		margin-bottom: 5px;
    		border-radius: 5px;
    		box-shadow: none;
    		background-color: #6d9370;
    		border: 0;
    		color: #dadada;
    	}
    </style>

    <section class="">
        <div class="container table-sections">
            <h2>@if(count($subCategory) > 0 ) {{$subCategory->name}} @endif</h2>
            <table id="product-datatable" class="table table-bordered" style="width:100% !important">
                <thead>
                <td class="text-center bg-primaryii">No.</td>
                <td class="text-center bg-primaryii">Product ID</td>
                <td class="text-center bg-primaryii">Name</td>
                <td class="text-center bg-primaryorange">Recipe</td>
                </thead>
                <tbody id="new-terminal"> 
                    <?php $index = 0;?>
                    @if(count($products) > 0)
                        @foreach($products as $data)
                        <tr>
                            <td class="text-center" style="vertical-align: middle">{{++$index}}</td>
                            <td class="text-center" style="vertical-align: middle">{{$data->nproduct_id}}</td> 
                            <td class="text-left" style="vertical-align: middle"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/images/product/{{$data->id}}/thumb/{{$data->thumb_photo}}">&nbsp;{{$data->name}}</td>                
                            <td class="text-center" style="vertical-align: middle"><a id="recipecount_{{$data->id}}" href="#" data-toggle="modal" data-target="" onclick="listrecipe('{{$data->id}}')">{{$data->rw_count}}</a></td>
                        </tr>
                    @endforeach
                    @endif               
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="listrecipeModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="width:60%">
                <!-- Modal content-->
              <div class="modal-content modal-content-sku">
                  <div class="modal-header">                      
					  <button type="button" class="close"
					  	data-dismiss="modal">&times;</button>
                      <h2>Recipe</h2>
                  </div>
                    <div id="listrecipebody"
						style="padding-left:0;padding-right:0"
						class="modal-body"></div>
                  </div>
            </div>
        </div>
        
        <div class="modal fade" id="skumodel" role="dialog">
            <div class="modal-dialog maxwidth60" style="width:80%">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close"
							data-dismiss="modal">&times;</button>
                        <h2>Raw Material</h2>
                    </div>
                    <div id="skumodalbody" class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="recipeq1Modal" role="dialog">
            <div class="modal-dialog maxwidth60" style="width:70%">
                <!-- Modal content-->
              <div class="modal-content modal-content-sku">
                  <div class="modal-header">                      
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h2>Quantity of 1 Definition Table</h2>
                  </div>
                  <!-- Temporarily disable the modal due to UGLY ERROR -->
                  <div id="recipeq1body"
                      style="padding-left:0;padding-right:0"
                      class="modal-body"></div>
                  </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#product-datatable').DataTable();
        });       

        function listrecipe(product_id)
        {
            var url =  JS_BASE_URL+"/branch/product/listrecipe/"+product_id;
            $.ajax({
                type: "GET",
                url: url,
                beforeSend: function(){},
                success: function(response){
                    $('#listrecipebody').html(response);
                    $('#listrecipeModal').modal('show');
                }
            });          
        }

        function recipeq1(){
            var url =  JS_BASE_URL+"/recipe/q1";
            $.ajax({
                type: "GET",
                url: url,
                success: function( response ) {
                    $('#recipeq1body').html(response);
                    // $('#listrecipeModal').modal('hide');
                    $('#recipeq1Modal').modal('show');
                }
            });  
        }

        function showrecipematerial() {
            var url =  JS_BASE_URL+"/branch/product/showrecipematerial";
            $.ajax({
                type: "GET",
                url: url,
                success: function( listproducts ) {
                    setskudatatable(listproducts);
                }
            });
        }      

        function setskudatatable(listproducts) {
            var skutablerow =` <table style="width: 100%; " id="skutbl" class="table skutable">
              <thead class="bg-primaryorange">
                <tr >
                  <th class="text-center" scope="col">No</th>
                  <th class="text-center" scope="col">Product ID</th>
                  <th class="text-center" scope="col">Product Name</th>
                  <th class="text-center" scope="col">Barcode</th>
                  <th class="text-right" scope="col">Sku</th>
                  
                </tr>
              </thead>
              <tbody id="skutable-body">
               `;

            jQuery.each( listproducts, function( key, listproduct ) {
                var keys = key + 1;
                skutablerow+=     `<tr class='highlite1' onclick="getproduct(`+listproduct.id+`,'`+listproduct.thumb_photo+`',`+listproduct.price+`,'`+listproduct.name+`','`+listproduct.npid+`')">
                        <td class="text-center">`+keys+`</td>
                        <td class="text-center">`+listproduct.npid+`</td>
                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/images/product/`+listproduct.id+`/thumb/`+listproduct.thumb_photo+`">
                        `+listproduct.name+`</td>
                        <td>`+listproduct.barcode+`</td>
                        <td>`+listproduct.sku+`</td>                       
                    </tr>
                  `;
            });
            skutablerow += ` </tbody>
                        </table>`;
            $('#skumodalbody').html(skutablerow);
            $('#skutbl').DataTable({
                "columnDefs": [
                    { "visible": true, "targets": 1 },
                    { "visible": true, "targets": 2 },
                    { "visible": false, "targets": 3 },
                    { "visible": false, "targets": 4 }
                ],
                    language: {
                       
                        //searchPlaceholder: "SProduct Name, Product ID, Barcode or SKU"
                }

            });
            $('#listrecipeModal').modal('hide');
            $('#skumodel').modal('show');
            $(".highlite1").hover(
              function () {
                $(this).css("background","yellow");
                $(this).css("cursor","pointer");
              }, 
              function () {
                $(this).css("background","");
              }
            );
        }

        function getproduct (product_id,thumb_photo,price,name,npid,quantity=1,online=true){
            var url =  JS_BASE_URL+"/getunit/"+product_id;
            $.ajax({
                type: "GET",
                url: url,
                beforeSend: function(){},
                success: function(response){

                    var table = $('#raw-datatable').DataTable();

                    var unit = '<span id="rawmaterialunit_'+product_id+'">'+response+'</span>';
                    var image = '<img src="{{url()}}/images/product/'+product_id+'/thumb/'+ thumb_photo+'" width="30" height="30" > &nbsp;'
                    var measuredata = '<input class="form-control qtyfield width100 text-center" id="qty'+product_id+'" name="measuredata[]" type="number" value="'+quantity+'"><input type="hidden" name="raw_product_id[]" value='+product_id+'>';

                    if(typeof $("#rawmaterial_"+product_id).html() !== "undefined"){
                        return true;
                    }
                    table.row.add([ 1, npid, image + name, measuredata,unit ]).node().id = "rawmaterial_"+product_id;

                    table.draw();
                    $(".raw-datatable_td table tbody tr td").addClass("text-center");
                    $(".raw-datatable_td table tbody tr td:nth-child(3)").removeClass("text-center");

                    $('#listrecipeModal').modal('show');
                    $('#skumodel').modal('hide');
                }
            });            
        }

        function saverawmaterial(){
            var url =  JS_BASE_URL+"/saverawmaterial";
            var formdata = $('#rawmaterialform').serialize();
                $.ajax({
                type: "POST",
                url: url,
                data:formdata,
                success: function(data) {
                    toastr.info("Recipe Saved successfully!");
                    $('#recipecount_'+data.data.item_product_id+'').html(data.data.rcount);
                    $('#listrecipeModal').modal('hide');
                },
                error:function(){
                    toastr.warning("An unexpected error ocurred!");
                }
            });
        }

        function unitChanged(product_id, unit){
            $('#rawmaterialform').find('#rawmaterialunit_'+product_id+'').html(unit);
        }
    </script> 
@stop
