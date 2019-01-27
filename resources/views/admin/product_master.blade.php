@extends('common.default')
@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 72px;
        font-weight: bold;
        margin: 300px 0 0 55%;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
        width: 85px;
    }
    .highlight{
    	background-color: red;
    	/*background: yellow;*/
    }
    table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
    .displaynone{
            display:none;
        }
</style>
{{-- Hidden --}}
<input type="hidden" value="{{$currency}}" id="currencyval" />
{{-- Modals --}}
{{--Modal Ends  --}}
<div class="container">
	@include('admin/panelHeading')
	<div class="row">
		<div class="col-sm-12">
			<h2>Product Master (Active: {{$total_active->counting}})</h2>
			<span  id="product-error-messages"></span>
			<p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
		<div class="tableData">
			<div class="table-responsive">
				<table class="table table-bordered" cellspacing="0" width="2000px" id="product_details_table">
					<thead>
					<tr style="background-color: #000; color: #fff;">
						<th style="vertical-align:middle"
							class="no-sort bsmall">No</th>
						<th style="vertical-align:middle"
							class="no-sort text-center medium">O-Shop</th>
						<th style="vertical-align:middle" class="text-center" style="background-color: #4A452A;">Product&nbsp;ID</th>					
						<th  style="vertical-align:middle" class="text-center ">Category</th>
						<th style="vertical-align:middle" class="text-center ">Subcategory</th>
						<th style="vertical-align:middle" class="text-center ">Brand</th>
						<th style="vertical-align:middle" class="text-center ">Created</th>
						<th style="vertical-align:middle" class="bsmall text-center ">Mapped</th>
						<th style="vertical-align:middle" class="text-center medium">Price</th>
						<th style="vertical-align:middle" class="text-center "style="text-center;background-color: #008000; color: #fff;">O.Status</th>
						<th style="vertical-align:middle;text-center;background-color: #008000; color: #fff;" class="text-center">P.Status</th>
						<th style="vertical-align:middle;text-center;background-color: #bf0159; color: #fff;" class="text-center">Commission</th>
						<th style="vertical-align:middle;text-center;background-color: #bf0159; color: #fff;" class="bsmall text-center">Merchant Cashback</th>
						<th style="text-center;background-color: #bf0159; color: #fff;" class="text-center">Platform Cashback</th>
					</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

		</div>
	</div>
</div>
@if(!is_null($merchant_id))
	<input type="hidden" id="pmerchant_id" value="{{$merchant_id}}" />
@else
	<input type="hidden" id="pmerchant_id" value="0" />
@endif
<div class="modal fade" id="myModalMapping" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Product Mapping</h4>
            </div>
            <div class="modal-body-mapping">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<?php $globalcommission = DB::table('global')->first();
				      $globalcommission = $globalcommission->commission_type;
				     
				    ?>
<script type="text/javascript">
	var subcat_pids=[];
	function ucfirst(str) {
	if (str == "" || str == null) { return "NA";}
    var firstLetter = str.substr(0, 1);
    return firstLetter.toUpperCase() + str.substr(1);
	}
	
	$(document).ready(function(){
		$(document).delegate( '.mapping', "click",function (event) {
			console.log("Product Mapping: 'Y/N' is pressed!");
			var id = $(this).attr('rel');
			/*$("#b2bspan").html($(this).attr('rel-b2b'));
			$("#termspan").html($(this).attr('rel-term'));
			$("#totalspan").html($(this).attr('rel-total'));*/
			$.ajax({
				url: JS_BASE_URL + '/productmapping/' + id,
				cache: false,
				method: 'GET',
				success: function(result, textStatus, errorThrown) {
					$(".modal-body-mapping").html(result);
					$("#myModalMapping").modal('show');
				}
			});				
			
		});			
		
		//
	// Pipelining function for DataTables. To be used to the `ajax` option of DataTables
	//
	$.fn.dataTable.pipeline = function ( opts ) {
	    // Configuration options
	    var conf = $.extend( {
	        pages: 5,     // number of pages to cache
	        url: '',      // script url
	        data: null,   // function or object with parameters to send to the server
	                      // matching how `ajax.data` works in DataTables
	        method: 'GET' // Ajax HTTP method
	    }, opts );
	 
	    // Private variables for storing the cache
	    var cacheLower = -1;
	    var cacheUpper = null;
	    var cacheLastRequest = null;
	    var cacheLastJson = null;
 
    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
         
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
         
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );
 
        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));
 
                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
             
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);
 
            request.start = requestStart;
            request.length = requestLength*conf.pages;
 
            // Provide the same `data` options as DataTables.
            if ( $.isFunction ( conf.data ) ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }
 
            settings.jqXHR = $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);
 
                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    if ( requestLength >= -1 ) {
                        json.data.splice( requestLength, json.data.length );
                    }
                     
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );
 
            drawCallback(json);
        }
    }
};
 
		// Register an API method that will empty the pipelined data, forcing an Ajax
		// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
		$.fn.dataTable.Api.register( 'clearPipeline()', function () {
		    return this.iterator( 'table', function ( settings ) {
		        settings.clearCache = true;
		    } );
		} );
 
		var page=$('#product_pagination_page').val();
		var merchant_id = $('#pmerchant_id').val();
		var url = JS_BASE_URL+"/paginate/product";
		if(merchant_id != "0"){
			url += "/" + merchant_id;
		}
		var product_dtable=$('#product_details_table').DataTable({
			"serverSide":false,
			"processing":true,
			"paging":true,
			"scrollX": true,
			"searching":{"regex":true},
			"ajax":{
				type:"GET",
				pages:5,
				url:url,
				dataSrc:function(json){
					
					var return_data=new Array();
					subcat_pids=[];
					
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						var subcatdesc = '';
						
						if(d.subcat_level == '1'){
							subcatdesc = d.slevel1;
						}
						if(d.subcat_level == '2'){
							subcatdesc = d.slevel2;
						}
						if(d.subcat_level == '3'){
							subcatdesc = d.slevel3;
						}
						//console.log(d.bc_management_id);
						var mapped = "N";
						if(d.bc_management_id != null){
							mapped = "Y";
						}
						
						if(d.commission_type == '')
						{
						    var commission = "{{$globalcommission}}";
						}else if(d.commission_type == 'std'){
							var commission = d.osmall_commission;
						}else if(d.commission_type == 'var'){
							var commission = d.pocommission ;
						}
						//console.log(d.osmall_commission);
						return_data.push({
							'id': i+1,
							'o_shop':ucfirst(d.o_shop),
							'product_id':"<a href='"+JS_BASE_URL+"/productconsumer/"+d.pid+"' target='_blank'><img src='"+JS_BASE_URL+"/images/product/"+d.pid+"/"+d.photo_1+"' width='30' height='30' style='padding-top:0;margin-top:4px'><span style='vertical-align: middle;'>&nbsp;"+d.product_id+"</span></a>",							
							'category':ucfirst(d.description),
							'subcategory':"<span class='subcat_"+d.pid+"'>"+subcatdesc+"</span>",
							'brand':ucfirst(d.brand),
							'created_at':d.created_at,
							'mapped':'<a href="javascript:void(0);" class="mapping" rel="'+d.pid+'">' + mapped + '</a>',
							'retail_price':"<a href='"+JS_BASE_URL+"/admin/master/product/price/"+d.pid+"' target='_blank'>Details</a>",
							'oshop_status':ucfirst(d.oshop_status),
							'status':"<span class='product_status' style='display: none;' rel='"+d.pid+"' srel='"+d.status+"'></span><a href='"+JS_BASE_URL+"/admin/master/product/approval/"+d.pid+"' target='_blank' >"+ucfirst(d.status)+"</a>",
							'commission':commission,
							'merchantcashback':d.cashback,
							'platformcashback':'<input type="text" class="pcashbackval" value="'+d.pcashback+'" data-proid="'+d.pid+'" style="border-width:1;border-color:#e0e0e0;width:50px;">%<img src="'+JS_BASE_URL+'/images/loader.gif'+'" class="displaynone" width="30" height="30" style="padding-top:0;margin-top:4px">'

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'product.id',className:'text-center no-sort'},
				{data:"o_shop",name:'oshop.oshop_name',className:'text-center'},
				{data:"product_id",name:'nproductid.nproduct_id',className:''},			
				{data:"category",name:'category.description',className:'text-center'},
				{data:"subcategory",name:'product.name',className:'text-center'},
				{data:"brand",name:'brand.name',className:'text-center'},
				{data:"created_at",name:'product.created_at',className:'text-center'},
				{data:"mapped",name:'product.created_at',className:'text-center'},
				{data:"retail_price",name:'product.retail_price',className:'text-center no-sort'},
				{data:"oshop_status",name:'oshop.status',className:'text-center'},
				{data:"status",name:'product.status',className:'text-center'},
				{data:"commission",name:'product.cashback',className:'text-center'},
				{data:"merchantcashback",name:'product.cashback',className:'text-center'},
				{data:"platformcashback",name:'product.pcashback',className:'text-center'}

			]
		});

			$('#product_details_table').on('draw.dt', function () {
				console.log("Color");
					$(".product_status").each(function() {
						if ($(this).attr('srel')=="pending") {
							$(this).closest('tr').css("background-color","rgba(240, 255, 0, 0.4)");
						}
						if ($(this).attr('srel')=="transferred") {
							$(this).closest('tr').css("background-color","#FCA8FF");
						}
					});
			/*	$.ajax({
					'type':'POST',
					'url':JS_BASE_URL+"/subcats/by/pid",
					'data':{'pids':subcat_pids},
					'success':function(r) {
							if (r.status=="success") {
							
								data=r.data;
								for (var i = data.length - 1; i >= 0; i--) {
									$('.subcat_'+data[i].id).text(data[i].subcat_name);
									if (data[i].pstatus=="pending") {
										$('.subcat_'+data[i].id).closest('tr').css("background-color","rgba(240, 255, 0, 0.4)");
									}
								}
							}
					}

				});*/

		} );

	});
	$( document ).ready(function() {
		
		$(document).on('change', ".pcashbackval",function (event) {
			$(this).next(".displaynone").css("display","block");
			var value = $(this).val();
			
			var proid = $(this).attr('data-proid');
			$.ajax({
				type: "post",
				url: JS_BASE_URL + '/product/pcashback',
				data: {id: proid,value:value},
				cache: false,
				success: function (responseData) {
					console.log(responseData);
					$(".displaynone").css("display","none");
					if(responseData == 1){
						$('#glyphiconcheck').show();
					}
					
				},
				
			});
		});	 
	});
</script>
@stop
