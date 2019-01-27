@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
?>
@section("content")
<style>
#imagePreviewDiscount {
   position: absolute;
	left: 0;
	height: 170px;
}
</style>
@include('common.sellermenu')
<div class="container"><!--Begin main cotainer-->
	<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong class='cart-info'></strong>
	</div>
<div class="row">
<?php
use App\Classes;
use App\Http\Controllers\IdController;
?>
<input type="hidden" value="{{$merchant_id}}" id="merchant_id" />
<label class="label label-warning" id="msg_discount_loading">Loading Discounts...</label>
<h2>Discount List</h2>
<div class="row" onload="">
 <div class="col-md-12">

   <div class="table-responsive">
     <table class="table table-bordered" id="discount_details_table" style="width: 140% !important;">
       <thead>
           <?php $i=1;?>
           <tr class="bg-black" style="background: #4F6328 !important; ">
             <th class="no-sort text-center" style="background-color: #4F6328; color: white; width: 30px !important;">No</th>
             <th class="text-center large"  style="background-color: #4F6328; color: white;">Discount ID</th>
             <th class="text-center large" style="background-color: #4F6328; color: white;">Product ID</th>
             <th class="text-center bsmall" style="background-color: #4F6328; color: white;">%</th>
             <th class="text-center bsmall" style="background-color: #4F6328; color: white;">Issued</th>
             <th class="text-center bsmall" style="background-color: #4F6328; color: white;">Left</th>
			 <th class="text-center bsmall" style="background-color: #4F6328; color: white;">Status</th>
             <th class="xlarge" style="background-color: #595959; color: white;">Inscription</th>
           </tr>
         </thead>
         <tbody id="discount_table" >
         </tbody>
       </table>
     </div>
 </div>
</div>
</form>
<div id="discountLeftModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="    width: 55%;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="left_discount_id"></h4>
              </div>
              <div class="modal-body">
                
                <div class="table-responsive">
                                <table class="table table-bordered" id="left_discount_buyer_details_table">
                                    <thead>
                                   {{--  <tr class="bg-black">
                                        <th colspan="11">Order Details</th>
                                    </tr> --}}
                                    
                                    <tr class="bg-black" style="    background: #4F6328 !important; ">
                                        
                                        <th class="text-center">No</th>
                                        <th class="text-center">Discount ID</th>
                                        <th class="text-center">Date Issued</th>
                                        {{-- <th>SKU</th> --}}

                                        {{-- <th>Delivery Order</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="left_discount_buyer_table" >

                                </tbody>
                            </table>
                        </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

        <div id="discountDiscModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="    width: 55%;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="disc_discount_id"></h4>
              </div>
              <div class="modal-body">
                
                <div class="table-responsive">
					<table class="table table-bordered" id="disc_discount_buyer_details_table">
						<thead>
					   {{--  <tr class="bg-black">
							<th colspan="11">Order Details</th>
						</tr> --}}
						
						<tr class="bg-black" style="background: #4F6328 !important; ">
							
							<th class="text-center">No.</th>
							<th class="text-center">Discount ID</th>
							<th class="text-center">Date Used</th>
							<th class="text-center">Date Issued</th>
							{{-- <th>SKU</th> --}}

							{{-- <th>Delivery Order</th> --}}
						</tr>
					</thead>
					<tbody id="disc_discount_buyer_table" >

					</tbody>
				</table>
			</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>	
		
		<div id="discountDetail" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width: 70%;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="discount_id_single">Discount Detail</h4>
              </div>
              <div class="modal-body-discdetail">             
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
		<br>
		<br>
</div>
</div>
<script>
		$(document).ready(function () {
function get_discounts(){
	$("#msg_discount_loading").fadeIn("fast");
	var table = $('#discount_details_table').DataTable({
			"order": [],
			"scrollx": true,
			"columnDefs": [
				{"targets": 'no-sort',"orderable": false},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "medium", "width": "80px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"},
			],
			"fixedColumns": {"leftColumns": 2}
		});
	var merchant_id = $('#merchant_id').val();  
      table.destroy();
  $.ajax({
    url:JS_BASE_URL+'/merchant/get_discounts/' + merchant_id,
    type:'GET',
    dataType:'JSON',
    success:function(response){
      $('#discount_table').html('');
      var i=1;
      $.each(response, function (index, value) {
			pfullnote = null;
			pnote = null;
			elipsis = "...";
			pfullnote = value.remarks;
			pnote = pfullnote.substring(0, 60);
			if (pfullnote.length > 60){
				pnote = pnote + elipsis;
			}
        //console.log('div' + index + ':' + 'value'+value.product_id);
        $('#discount_table').append('<tr>'+
          '<td style="text-align: center; vertical-align:middle;">'+ i +'</td>'+
          '<td style="text-align: center;"><a onClick="discountDetail('+value.id+')" href="javascript:void(0)">'+ value.discount_idf +'</a></td>'+
          '<td style="text-align: center;"><a href="'+JS_BASE_URL+'/productconsumer/'+ value.product_id +'" target="_blank">'+ value.product_idf +'</a></td>'+
          '<td style="text-align: center;">'+ value.discount_percentage +'%</td>'+
          '<td style="text-align: center; " ><a href="javascript:void(0)" onClick="getIssuedDiscounts('+ value.id +')">'+ value.quantity +'</a></td>'+
          '<td style="text-align: center;"><a href="javascript:void(0)" onClick="getleftDiscounts('+ value.id +')">'+ value.discount_left +'</a></td>'+
		  '<td style="text-align: center;">'+ value.status +'</td>'+
          '<td <span title="'+pfullnote+'">'+ pnote +'</td>'+

                '</tr>');
              i++;
		});

		$('#discount_details_table').DataTable({
			"order": [],
			"scrollx": true,
			"columnDefs": [
				{"targets": 'no-sort',"orderable": false},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "medium", "width": "80px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"},
			],
			"fixedColumns": {"leftColumns": 2}
		});
		
		$(".dataTables_empty").attr("colspan","100%");

		$("#msg_discount_loading").fadeOut("slow");


        },
        error:function(response){
            console.log(response);
        }
    });
}
get_discounts();



       });
var left_table;	   
function getleftDiscounts(id){
    $("#discountLeftModal").modal("show");
    $.ajax({
        url:JS_BASE_URL+'/merchant/get_left_discounts/'+id,
        type:'GET',
        dataType:'JSON',
        success:function(response){
            $('#left_discount_buyer_table').html('');
			if(left_table){
				left_table.destroy();
				$('#left_discount_buyer_table').empty();
			}
            $('#left_discount_id').html("Discount Left ");
            var i=1;
            $.each(response, function (index, value) { 
                $('#left_discount_id').html("Discount Left");
              $('#left_discount_buyer_table').append('<tr>'+
                '<td style="text-align: center;">'+ i +'</td>'+
                '<td style="text-align: center;">'+ value.discount_idf +'</td>'+
                '<td style="text-align: center;">'+ value.created_at +'</td>'+

                '</tr>');
              i++; 
          });
            left_table = $('#left_discount_buyer_details_table').DataTable();
            $("#msg_discount_loading").fadeOut("slow");

            
        },
        error:function(response){
            console.log(response);
        }
    });
    
}	  
var disc_table;
function getIssuedDiscounts(id){
    $("#discountDiscModal").modal("show");
    $.ajax({
        url:JS_BASE_URL+'/merchant/get_disc_discounts/'+id,
        type:'GET',
        dataType:'JSON',
        success:function(response){
            $('#disc_discount_buyer_table').html('');
			if(disc_table){
				disc_table.destroy();
				$('#disc_discount_buyer_table').empty();
			}
            $('#left_discount_id').html("Discount Left ");
            var i=1;
            $.each(response, function (index, value) { 
                $('#disc_discount_id').html("Discount Issued");
              $('#disc_discount_buyer_table').append('<tr>'+
                '<td style="text-align: center;">'+ i +'</td>'+
                '<td style="text-align: center;">'+ value.discount_idf +'</td>'+
                '<td style="text-align: center;">'+ value.date_used +'</td>'+
                '<td style="text-align: center;">'+ value.created_at +'</td>'+

                '</tr>');
              i++; 
          });
            disc_table = $('#disc_discount_buyer_details_table').DataTable();
            $("#msg_discount_loadingd").fadeOut("slow");

            
        },
        error:function(response){
            console.log(response);
        }
    });

} 

function discountDetail(id){
    $("#discountDetail").modal("show");
    $.ajax({
        url:JS_BASE_URL+'/merchant/get_discount/'+id,
        type:'GET',
        success:function(response){
            $(".modal-body-discdetail").html(response);
            
        },
        error:function(response){
            console.log(response);
        }
    });
    
} 
</script>
@stop