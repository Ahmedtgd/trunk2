<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 15);
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
		@include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">
               <h2>Administration Inventory Report & Analysis</h2>
                <br>
                <table id="test" class="table table-bordered" cellspacing="0" width="1400px">
                <thead style="background-color: #AAA; color: white">
                    <tr>
                        <th colspan="6" style="background-color: #AAA; color: white; text-align: center;">&nbsp;</th>
                        <th colspan="2" style="background-color: #AAA; color: white;">Accumulated Sales</th>
                        <th colspan="2" style="background-color: #ff6666; color: white;">O-Shop Availability</th>
                        <th colspan="2" style="background-color: goldenrod; color: white;">Album Availability</th>
                        <th colspan="2" style="background-color: #4E2E28; color: white;">Station</th>
                    </tr>
                    <tr>
                        <th class="no-sort" style="background-color: #AAA; color: white; text-align: center;">No</th>
                        <th class="large" style="background-color: #AAA; color: white; text-align: center;">Product ID</th>
                        <th class="large" style="background-color: #AAA; color: white; text-align: center;">Name</th>
                        <th class="large" style="background-color: #AAA; color: white; text-align: center;">Status</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">Since</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">Type</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">Qty</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">$</th>
                        <th class="medium" style="background-color: #ff6666; color: white;text-align: center;">Retail</th>
                        <th class="medium" style="background-color: #ff6666; color: white;text-align: center;">B2B</th>
                        <th class="medium" style="background-color: goldenrod; color: white;text-align: center;">Retail</th>
                        <th class="medium" style="background-color: goldenrod; color: white;text-align: center;">B2B</th>
                        <th class="medium" style="background-color: #4E2E28; color: white;text-align: center;">Low</th>
                        <th class="medium" style="background-color: #4E2E28; color: white;text-align: center;">High</th>
                    </tr>
                </thead>
                <tbody>
				</tbody>
            </table>

            </div>
    </div>
 <!-- Modal -->
<div class="modal fade" id="myModalInventory" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Product Inventory</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
    <script type="text/javascript">

  $(document).ready(function () {
 	function pad (str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}

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
		var url = JS_BASE_URL+"/paginate/analysisinventory";
		var product_dtable=$('#test').DataTable({
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
						//console.log(d);
						//console.log(d.qty);
						if(d.qty == null){
							d.qty = 0;
						}
						if(d.retail_oshop == null){
							d.retail_oshop = 0;
						}
						if(d.b2b_oshop == null){
							d.b2b_oshop = 0;
						}
						if(d.album_available == null){
							d.album_available = 0;
						}
						if(d.b2b_available == null){
							d.b2b_available = 0;
						}
						if(d.high_stock == null){
							d.high_stock = 0;
						}
						if(d.low_stock == null){
							d.low_stock = 0;
						}
						
						var n = d.name.length;
						var ell = "";
						if(n > 13){
							ell = "...";
						}
						var show_name = "<span title='"+d.name+"'>"+d.name.substring(0, 13)+ ell +"</span>";
						return_data.push({
							'id': i+1,
							'pid':"<a href='"+JS_BASE_URL+"/productconsumer/"+d.id+"' target='_blank'>"+d.nproduct_id+"</a>",
							'name':show_name,
							'status':ucfirst(d.status),
							'since':d.since,
							'type':d.type,
							'qty':d.qty,
							'curr':'{{$currentCurrency}} ' + js_number_format(parseInt(d.total)/100,2,'.',''),
							'retail':d.retail_oshop,
							'b2b':d.b2b_oshop,
							'retail2':d.album_available,
							'b2b2':d.b2b_available,
							'low':'<a href="javascript:void(0)" rel="'+d.id+'" nrel="'+d.nproduct_id+'" class="inventory_low">'+d.high_stock+'</a></td>',
							'high':'<a href="javascript:void(0)" rel="'+d.id+'" nrel="'+d.nproduct_id+'" class="inventory_high">'+d.low_stock+'</a></td>',

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'id',className:'text-center no-sort'},
				{data:"pid",name:'pid',className:'text-center'},
				{data:"name",name:'name',className:'text-center'},
				{data:"status",name:'status',className:'text-center'},
				{data:"since",name:'since',className:'text-center no-sort'},
				{data:"type",name:'type',className:'text-center'},
				{data:"qty",name:'qty',className:'text-center'},
				{data:"curr",name:'curr',className:'text-center'},
				{data:"retail",name:'retail',className:'text-center'},
				{data:"b2b",name:'b2b',className:'text-center'},
				{data:"retail2",name:'retail2',className:'text-center'},
				{data:"b2b2",name:'b2b2',className:'text-center'},
				{data:"low",name:'low',className:'text-center'},
				{data:"high",name:'high',className:'text-center'},

			]
		});


	var table_modal;
	$(document).delegate( '.inventory_qty', "click",function (event) {
	//$(".inventory_qty").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var product_id= _this.attr('rel');


		var url = '/admin/analysis/inventory/'+product_id;

		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {

				$('#modal-Tittle').append("Product ID: ["+pad(product_id,10) + "]");
				//console.log(data);
				$('#myTable').append('<thead style="background-color: #AAA; color: #fff;"><th>No</th><th>Station/Merchant ID</th><th>Name</th><th>Qty Left</th>');
				$('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					var type = obj.type;
					var route = "";
					if(type=="station"){
						route = urlbase + "/admin/popup/station/" + obj.id;
					} else {
						route = urlbase + "/admin/popup/merchant/" + obj.id;
					}
					$('#myTable').append('<tr><td>'+(i+1)+'</td><td><a target="_blank" href="'+route+'">['+pad(obj.id,10)+']</a></td><td>'+obj.name+'</td><td>'+ obj.qty +'</td></tr>');
				}
				$('#myTable').append('</tbody>');

				table_modal = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "20px", "orderable": false },
						{ "width": "85px" },
						{ "width": "85px" },
						{ "width": "85px" },
					  ]
				});

				$("#myModalInventory").modal("show");
			},
			error: function (error) {
				console.log(error);
			}
		});
	});
	$(document).delegate( '.inventory_high', "click",function (event) {
//	$(".inventory_high").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var product_id= _this.attr('rel');
		var nproduct_id= _this.attr('nrel');


		var url = '/admin/analysis/inventory_high/'+product_id;

		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				$('#modal-Tittle').append("High Station Product ID: "+ nproduct_id);
				//console.log(data);
				$('#myTable').append('<thead style="background-color: #4E2E28; color: #fff;"><th>No</th><th>Station ID</th><th>Name</th><th>Qty Left</th>');
				$('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					var type = obj.type;
					var route = "";
					route = urlbase + "/admin/popup/station/" + obj.id;
					$('#myTable').append('<tr><td class="text-center">'+(i+1)+'</td><td class="text-center"><a target="_blank" href="'+route+'">['+pad(obj.id,10)+']</a></td><td class="text-center">'+obj.name+'</td><td class="text-center">'+ obj.qty +'</td></tr>');
				}
				$('#myTable').append('</tbody>');

				table_modal = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "10%", "orderable": false },
						{ "width": "30%" },
						{ "width": "45%" },
						{ "width": "15%" }
					  ]
				});

				$("#myModalInventory").modal("show");
			},
			error: function (error) {
				console.log(error);
			}
		});
	});

	$(document).delegate( '.inventory_low', "click",function (event) {
	//$(".inventory_low").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var product_id= _this.attr('rel');
		var nproduct_id= _this.attr('nrel');


		var url = '/admin/analysis/inventory_low/'+product_id;

		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				$('#modal-Tittle').append("Low Station Product ID: "+ nproduct_id);
				//console.log(data);
				$('#myTable').append('<thead style="background-color: #4E2E28; color: #fff;"><th>No</th><th>Station ID</th><th>Name</th><th>Qty Left</th>');
				$('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					var type = obj.type;
					var route = "";
					route = urlbase + "/admin/popup/station/" + obj.id;
					$('#myTable').append('<tr><td class="text-center">'+(i+1)+'</td><td class="text-center"><a target="_blank" href="'+route+'">['+pad(obj.id,10)+']</a></td><td class="text-center">'+obj.name+'</td><td class="text-center">'+ obj.qty +'</td></tr>');
				}
				$('#myTable').append('</tbody>');

				table_modal = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "10%", "orderable": false },
						{ "width": "30%" },
						{ "width": "45%" },
						{ "width": "15%" },
					  ]
				});

				$("#myModalInventory").modal("show");
			},
			error: function (error) {
				console.log(error);
			}
		});
	});

 });
        </script>
@stop
