@extends("common.default")
<?php
use App\Classes;
use App\Http\Controllers\IdController;
define('MAX_COLUMN_TEXT', 95);
?>
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

</style><?php $i=1; ?>


<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')
    <div class="equal_to_sidebar_mrgn">

        <h2>Discount Master</h2>

        <!-- <hr/> -->
        <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
        <button type="button" id="btn-add" class="btn btn-primary btn-md hidden" style="float:right;">Add Discount</button>
        <br/>
        <label class="label label-warning" id="msg_discount_loading">Loading Discounts...</label>
        <br/>
        <!-- <hr> -->


        <div class="table-wrapper">
            <table class="table table-striped display cell-border" cellspacing="0" width="100%" id="discount_details_table">
                <thead>
                    <tr>
                        <th class="text-center no-sort" style="background-color: #4F6328; color: white;">No</th>
                        <th class="text-center" style="background-color: #4F6328; color: white;">Discount&nbsp;ID</th>
                        <th class="text-center" style="background-color: #4F6328; color: white;">Product&nbsp;ID</th>
                        <th class="text-center" style="background-color: #4F6328; color: white;">Merchant</th>
                        <th class="text-center tiny" style="background-color: #4F6328; color: white;">%</th>
                        <th class="text-center tiny" style="background-color: #4F6328; color: white;">Issued</th>
                        <th class="text-center tiny" style="background-color: #4F6328; color: white;">Left</th>
                        <th class="text-center tiny" style="background-color: #4F6328; color: white;">Expiry&nbsp;Date</th>
						<th class="text-center tiny" style="background-color: #4F6328; color: white;">Validity</th>
                        <th class="text-center xlarge" style="background-color: #595959; color: white;">Inscription</th>
                        
                    </tr>
                </thead>
                <tbody id="discount_table">

                </tbody>
            </table>
        </div>
	<div id="discountIssueModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="    width: 86%;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="discount_id"></h4>
              </div>
              <div class="modal-body">
                
                <div class="table-responsive">
					<table class="table table-bordered" id="discount_buyer_details_table">
						<thead>
					   {{--  <tr class="bg-black">
							<th colspan="11">Order Details</th>
						</tr> --}}
						
						<tr class="bg-black " style="    background: #4F6328 !important; ">
							<th class="text-center no-sort">No</th>
							<th class="text-center blarge">Buyer ID</th>
							<th class="text-center blarge">Start</th>
							<th class="text-center">Time Left</th>
							<th class="text-center">Due Date</th>
							<th class="text-center">Status</th>
							<th class="text-center xlarge">Inscription</th>
							{{-- <th>SKU</th> --}}

							{{-- <th>Delivery Order</th> --}}
						</tr>
					</thead>
					<tbody id="discount_buyer_table" >

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
							<th class="text-center">User ID</th>
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
							<th class="text-center">User ID</th>
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

    </div>    
</div>
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <script type="text/javascript">
    //Function To handle add button action
    $(document).delegate( '#btn-add', "click",function (event) {
        location.href= "{{url('')}}/merchant/dashboard?tab=discount";

    })

    function get_discounts(){

        $.ajax({
            url:JS_BASE_URL+'/merchant/get_discounts',
            type:'GET',
            dataType:'JSON',
            success:function(response){
                $('#discount_table').html('');
                var i=1;
                // console.log(response);
                $.each(response, function (index, value) { 

                   /* console.log(value.id);
                    console.log(value.due_date);*/
                 
                  $('#discount_table').append('<tr>'+
                    '<td  style="text-align: center;">'+ i +'</td>'+
                    '<td style="text-align: center; cursor:pointer"  ><a onClick="discountDetail('+value.id+')" href="#">'+ value.discount_idf +'</a></td>'+
                    '<td style="text-align: center;"><a href="'+JS_BASE_URL+'/productconsumer/'+value.product_id+'" target="_blank">'+ value.product_idf +'</a></td>'+
                    '<td style="text-align: center;"><a href="'+JS_BASE_URL+'/admin/popup/merchant/'+value.merchant_id+'" title="'+value.merchant_name+'" target="_blank">'+ value.merchant_name.substr(0, 12) +'</a></td>'+
                    '<td style="text-align: center;">'+ value.discount_percentage +'%</td>'+
                    '<td style="text-align: center; " ><a href="#" onClick="getIssuedDiscounts('+ value.id +')">'+ value.quantity +'</a></td>'+
                    '<td style="text-align: center;"><a href="#" onClick="getleftDiscounts('+ value.id +')">'+ value.discount_left +'</a></td>'+
                    '<td style="text-align: center;">'+ value.expiry_date +'</td>'+
                    '<td style="text-align: center;">'+ value.status +'</td>'+
                    '<td>'+ value.remarks +'</td>'+

                    '</tr>');
                  i++; 
              });
                $('#discount_details_table').DataTable({
                    "order": [],
                    "scrollX":true,
                    "columnDefs": [
                        {"targets": 'no-sort',"orderable": false},
                        {"targets": "small",  "width": "20px"},
                        {"targets": "medium", "width": "80px"},
                        {"targets": "large",  "width": "120px"},
                        {"targets": "approv", "width": "180px"},
                        {"targets": "blarge", "width": "200px"},
                        {"targets": "clarge", "width": "250px"},
                        {"targets": "xlarge", "width": "300px"},
                    ],
                    "fixedColumns": {"leftColumns": 2}
                });
                $("#msg_discount_loading").fadeOut("slow");


            },
            error:function(response){
                console.log(response);
            }
        });
    }
    get_discounts();
    function getBuyerDiscounts(id){
    $("#discountIssueModal").modal("show");
    $.ajax({
        url:JS_BASE_URL+'/merchant/get_buyer_discounts/'+id,
        type:'GET',
        dataType:'JSON',
        success:function(response){
            $('#discount_buyer_table').html('');
            
            var i=1;
            $.each(response, function (index, value) { 
				
                $('#discount_id').html("Discount ID: "+idf);
              $('#discount_buyer_table').append('<tr>'+
                '<td style="text-align: center;">'+ i +'</td>'+
                '<td style="text-align: center;">'+ value.buyer_idf +'</td>'+
                '<td style="text-align: center;">'+ value.start_date +'</td>'+
                '<td style="text-align: center;">'+ value.days_left +'</td>'+
                '<td style="text-align: center;">'+ value.due_date +'</td>'+
                '<td style="text-align: center;">'+ value.status +'</td>'+
                '<td style="text-align: center;">Remarks Here</td>'+

                '</tr>');
              i++; 
          });
            $('#discount_buyer_details_table').DataTable();
            $("#msg_discount_loading").fadeOut("slow");

            
        },
        error:function(response){
            console.log(response);
        }
    });
    
}
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
                '<td style="text-align: center;"><a href="'+JS_BASE_URL+'/admin/popup/user/'+value.buyer_id+'" target="_blank">'+ value.buyer_idf +'</a></td>'+
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
                '<td style="text-align: center;"><a href="'+JS_BASE_URL+'/admin/popup/user/'+value.buyer_id+'" target="_blank">'+ value.buyer_idf +'</a></td>'+
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

@section("extra-links")
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/fc-3.2.2/datatables.min.css"/> -->
<style type="text/css">
    .my_class {
        vertical-align: middle;
    }
</style>
<link rel="stylesheet" href="{{asset('/css/bootstrap-switch.min.css')}}"/>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/b-1.2.0/datatables.min.css"/> -->
@stop

@section("scripts")

<script type="text/javascript" src="{{asset('/js/bootstrap-switch.min.js')}}"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/u/bs/fc-3.2.2/datatables.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/u/bs/b-1.2.0/datatables.min.js"></script> -->
@stop
