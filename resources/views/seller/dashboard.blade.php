@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
?>
@section("content")
<!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->
<style>

    .tab-pane{
        margin-top: 4em;
    }
/*Butto*/
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
        font-size: 18px;
        font-weight: bold;
        margin: 365px 0 0 610px;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
    }
/*
Search
*/
    .search-bar{
        background-color: #006464;
        font-size: 1.2em;
        color: white;
        padding: 10px;
    }
    .details-control, .details-control-2 {
        cursor: pointer;
    }
    .textCenter{
        text-align: center;
    }
    .textRight{
        text-align: right;
    }
    td{
        min-width: 10%;
    }
    td.streched{
        min-width: 100px;
    }
    td.details-control:after ,td.details-control-2:after {
        font-family: 'FontAwesome';
        content: "\f0da";
        color: #303030;
        font-size: 17px;
        float: right;
        padding-right: 25px;
    }
    tr.shown td.details-control:after, tr.shown td.details-control-2:after {
        content: "\f0d7";
    }
    table td.absorbing-column {
    width: 50%;
}

    .child_table {
        margin-left: 78px;
        width: 920px;;
    }
    .panel {
    border: 0;
}

.top-margin{
    margin-top: -30px;
}
    table
    {
        counter-reset: Serial;
        table-layout: auto;
    }

    table.counter_table tr td:first-child:before
    {
        counter-increment: Serial;      /* Increment the Serial counter */
        content: counter(Serial); /* Display the counter */
    }

    .modal-fullscreen{
      margin: 0;
      margin-right: auto;
      margin-left: auto;
      width: 95% !important;
    }


    @media (min-width: 768px) {
      .modal-fullscreen{
        width: 750px;
      }
    }
    @media (min-width: 992px) {
      .modal-fullscreen{
        width: 970px;
      }
    }
    @media (min-width: 1200px) {
      .modal-fullscreen{
         width: 1170px;}
    }
    table#product_details_table,#payment_detail_products
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
    .bg-yellow
    {
        background:#d7e748;
        color: #fff;
    }
	.nav>li>span {
		position: relative;
		display: block;
		padding: 10px 15px;
		margin-left: -0.87em;
	}
</style>
	@include('common.sellermenu')
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class='cart-info'></strong>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12"><h2>Dashboard (Online)</h2></div>
                    {{-- Tabbed Nav --}}
						<div class="panel with-nav-tabs panel-default ">
							<div class="panel-heading">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#sales-order" data-toggle="tab">Order</a></li>
									<!--<li><a href="#statement" data-toggle="tab">Documents</a></li>-->
									<li>
									<!--<a href="#voucher" data-toggle="tab">Voucher</a>-->
									<span style="margin-left: 0px; margin-right: 0px; padding: 10px; color: #CCC;">Voucher</span>
									</li>
									<li><a href="#open-wish" data-toggle="tab">OpenWish</a></li>
									{{-- <li><a href="#auto-link" data-toggle="tab">AutoLink</a></li> --}}
								</ul>
							</div>
						</div>
                    {{--ENDS  --}}
					<input type="hidden" value="{{$selluser->id}}" id="selluserid" />
					<input type="hidden" value="{{$merchant_id}}" id="mmerchant_id" />
					<input type="hidden" value="{{$station_id}}" id="sstation_id" />
					<div id="dashboard" class="row panel-body " >
						<div class="tab-content top-margin" style="margin-top:-50px">
							<div id="sales-order" class="tab-pane fade in active">
								@include('seller.dashboard.sales-order')
							</div>
							<div class="tab-pane fade" id="voucher">
								@include('seller.dashboard.voucher')
							</div>
							<div class="tab-pane fade" id="open-wish">
								@include('seller.dashboard.openwish')
							</div>
							<div class="tab-pane fade" id="statement">
								@include('seller.dashboard.statement')
							</div>							
							{{-- <div class="tab-pane fade" id="auto-link">
								@if($mautolink)
									@include('seller.dashboard.autolink')
								@else
									@include('seller.dashboard.sautolink')
								@endif
							</div>	 --}}						
						</div>
					</div>

				</div>
            </div>
        </div>
    </section>

<script type="text/javascript">
    $(document).ready(function(){
        $('#asearch').click(function(){
            var query=$('#autolink-search').val();

            var url =JS_BASE_URL+"/autolink/search";
            $.ajax({
                type:'POST',
                url:url,
                data:{'query':query},
                success:function(response){
                    if (response.status=="success") {
                        var searchheader='<b>'+response.count.toString()+'</b> result(s) was found  for <b>"'+response.query+'"</b><hr>';
                        // //alert(searchheader);
                        $('#search-header').html(searchheader);
                        var cont="";
                        for (var i = response.response.length - 1; i >= 0; i--) {
                            // //alert(response.raw_id);
                            cont=cont+'<h3>'+response.response[i].first_name+" "+response.response[i].last_name+'<small>'+response.response[i].user_id+'</small></h3><button type="button" data-button="'+response.response[i].raw_id+'"class="btn btn-success btn-sm mautolink" style="background:rgb(0,99,98);color:#fff;right:0;margin-top:4px;"><span class="glyphicon glyphicon-link"></span>AutoLink</button><hr>';
                        };
                        $('#search-results').html(cont);
                    };
                }
            });
        });
    });

</script>
{{-- Autolink --}}
<script type="text/javascript">
    $(document).ready(function(){
    $('body').on('click','.mautolink',function(){
        var id= $(this).attr('data-button');
        var button= $(this);
        var url=JS_BASE_URL+"/merchant/"+id+"/autolink";
        $.ajax({
            url:url,
            success:function(data){
                if (data.code=="sspr") {

                    button.prop('disabled', true);
                    button.html('Requested');
                };
                if (data.code=="uara") {
                    button.prop('disabled', true);
                    button.html('Requested');
                };
                if (data.code=="unli") {
                    // //alert(data.status);
                    button.html('Login Needed');
                };

            }
        });
    });  //Button Action
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
            $('.role_status_button_link').click(function(){
                $('#stModal').modal('show');
                var autolinkid=$(this).attr('current_role_id');
                var rsbl=$(this);


                $('#initajax').click(function(){
                        $('#stModal').unbind().modal();
                        $('#stModal').modal('hide');
                    remark= $('textarea#long-remark').val();
                    if (rsbl.attr('do_status')=="approve") {
                        url=JS_BASE_URL+"/autolink/accept";
                        $.ajax({
                            url:url,
                            type:'POST',
                            dataType:'json',
                            data:{'id':autolinkid,'remark':remark},
                            success:function(response){
                                if (response.status=="success") {
                                    toastr.info("Your are now AutoLinked with the merchant.Please reload page to update!");
                                };
                            }
                        }); //ajax
                    }
                    else{
                        if (rsbl.attr('do_status')=="reject" || rsbl.attr('do_status')=="suspend") {
                            url=JS_BASE_URL+"/autolink/delete";
                            $.ajax({
                                url:url,
                                type:'POST',
                                dataType:'json',
                                data:{'id':autolinkid,'remark':remark},
                                success:function(response){
                                    if (response.status=="success") {
                                        toastr.info("Your have rejected/unlinked.Please reload page to update!");
                                    };
                                }
                            });//ajax
                        };
                    };
                    $('textarea#long-remark').val('');
                    delete remark;
                });//click
        });//click
    }); //doc
</script>
{{-- <script type="text/javascript" src="{{asset('js/autolink.js')}}"></script> --}}
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>


<script>
    function addToCart(product_id ,amount,ow_id){
        console.log(product_id);
        jQuery.ajax({
            type: "POST",
            url: "{{ url('merchant/help')}}",
            data: { product_id:product_id , amount:amount,ow_id:ow_id},
            beforeSend: function(){},
            success: function(response){
                console.log(response.content);
                $('.cart-link').text('View Cart');
                $('.badge-cart').text(response.total_items);
                $('#alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
                $('.cart-info').text(response.product_name + "  Successfully added to the cart");
            }
        });
    }

    //    $('#auto_link_table').dataTable().fnDestroy();
    $(document).ready(function(){

        function format ( tr ) {

            var j = tr.attr('data-last');

            var table='<table class="table child_table" cellspacing="0" width="100%">';
            table+='<thead>';
            table+='<tr><th>Id</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Sub Total</th></tr>';
            table+='</thead>';
            table+='<tbody>';

            for (i = 1;i<=j;i++){
                var id = tr.attr('data-id-'+i);
                var name = tr.attr('data-name-'+i);
                var qty = tr.attr('data-qty-'+i);
                var price = tr.attr('data-price-'+i);
                var des = tr.attr('data-des-'+i);
                var total = tr.attr('data-total-'+i);
                table+='<tr><td>'+id+'</td><td>'+name+'</td><td>'+des+'</td><td>'+qty+'</td><td>'+price+'</td><td>'+total+'</td></tr>';
            }

            table+='</tbody>';
            table+='</table>';

            return table;
        }

        var table = $('#product_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });
		
		$('#merchant_gst').DataTable({
            "order": [],
        
            "columnDefs": [
				{ "targets" : 0, "orderable": false, "defaultContent": "" },
			]
        });
		
        var table = $('#cre_details_table').DataTable({
            "order": [],
            "scrollX":true,
            "columnDefs": [
                { "targets": "no-sort", "orderable": false },
                { "targets": "large", "width": "150px" },
                { "targets": "smallestest", "width": "55px" },
                { "targets": "medium", "width": "100px" },
                { "targets": "xlarge", "width": "300px" },
                { "targets": "xlarge", "width": "500px" }
            ],
            "fixedColumns":   {
                "leftColumns": 2
            }
        });
        var table = $('#orderb_details_table').DataTable({
            "order": [],
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			]
        });

        var table = $('#shipping_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        var table = $('#shippings_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        $('#lower_product_detail_table').DataTable();
        $('#payment_detail_products').DataTable({
            "order": [],
			"scrollX":true,
            "columnDefs": [
				{ "targets" : 0, "orderable": false, "defaultContent": "" },
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "large",  "width": "120px" },
				{ "targets": "blarge", "width": "200px" },
				{ "targets": "xlarge", "width": "300px" } 
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        $('#voucher_payment_detail').DataTable();

        $('#open_wish_table').DataTable({
            "order": [],
        
            "columnDefs": [
				{ "targets" : 0, "orderable": false, "defaultContent": "" },
			]
        });
        $('#auto_link_tables').DataTable({
			"order": [],
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        var vtable = $('#voucher_detail_table').DataTable({
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "className":      'details-control-2',
                "orderable":      false,
                "defaultContent": ""
            } ]
        });

        $('td.details-control-2').on('click', function () {
            console.log('clicked');
            var tr = $(this).closest('tr');
            var row = vtable.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(tr) ).show();
                tr.addClass('shown');
            }
        } );


        $('#datetimepicker , #datetimepickerr').on('change',function(){
            var date1 = $('#datetimepicker').val();
            var date2 = $('#datetimepickerr').val();

            $('#dateSince').html(date1);

            $.ajax({
               url: '{{url('/merchant/calc-sale')}}',
               data: {'date1': date1, 'date2' : date2},
               headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
               error: function() {

               },
               success: function(response) {
                  $('#amountSince').html(response.payment);
                  $('#amountBetween').html(response.paymentSince);
               },
               type: 'POST'
            });
        });

    // $('.uniqporder').click(function(){
    //     // //alert("lol");
    //     // event.preventDefault();
    //     var porder_id= $(this).attr('data');
    //     var url= JS_BASE_URL+"/order/product/"+porder_id;
    //     newwindow = window.open(url, 'Order Details', 'height=500,width=800');
    //     if (window.focus) {newwindow.focus()}
    //     setTimeout(function () {newwindow.close();}, 30000);
    // });

    $('.order_id').on('click',function(e){
        e.preventDefault();
        $('body').css('padding','0px');
        var route = $(this).attr('data-val');
        $.ajax({
            type : "GET",
            url : route,
            success : function(response){
                $('#Modal').find('.modal-body').html(response);
                $('#Modal').modal('show');
                $('.title').text('Payment');
            }
        })
    });
	
	$(".dataTables_empty").attr("colspan","100%");
	$(window).resize();
});

function  merchantNewDiscount(){


}
$("#discountForm").submit(function (e){
    e.preventDefault();
  $("#msg_error").hide();
  $("#msg_sucess").hide();
    var product=$('select[name="discount_product"]').val();
    var duration=$('input[name="discount_duration"]').val();
    var start_date=$('input[name="discount_start_date"]').val();
    var quantity=$('input[name="discount_quantity"]').val();
    var percentage=$('input[name="discount_percentage"]').val();
    $.ajax({
            type : "POST",
            url : JS_BASE_URL+"/merchant/addNewDiscount",
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success : function(response){
                $("#form_submit_button").val("Submitting");
                    $("#form_submit_button").attr("disabled",true);
                $("#msg_error").hide();
                $("#err_discount_product").html('');
                $("#err_discount_start_date").html('');
                $("#err_discount_duration").html('');
                $("#err_discount_quantity").html('');
                $("#err_discount_percentage").html('');
                $("#err_discount_image").html('');
                if (response=='1') {
                    $("#msg_sucess").show();
					get_discounts();
                    clearValues();
                }else{
                    $("#msg_error").show();
                }
            },
            error:function(response){
                $("#msg_error").show();
                $("#err_discount_product").html('');
                $("#err_discount_start_date").html('');
                $("#err_discount_duration").html('');
                $("#err_discount_quantity").html('');
                $("#err_discount_percentage").html('');
                $("#err_discount_image").html('');
                $("#err_discount_image").html(response.responseJSON.discount_image);
                $("#err_discount_product").html(response.responseJSON);
                $("#err_discount_start_date").html(response.responseJSON.discount_start_date);
                $("#err_discount_duration").html(response.responseJSON.discount_duration);
                $("#err_discount_quantity").html(response.responseJSON.discount_quantity);
            $("#err_discount_percentage").html(response.responseJSON.percentage);

            }
        });
});
function clearValues(){
        $('input[name="discount_duration"]').val('0');
        $('input[name="discount_durationff"]').val('0');
        $('input[name="discount_start_date"]').val('');
        $('input[name="discount_quantityff"]').val('0');
        $('input[name="discount_quantity"]').val('0');
        $('input[name="discount_percentage"]').val('0');
        $('input[name="percentage"]').val('0');
    $("#form_submit_button").val("Submit");
    $("#form_submit_button").attr("disabled",false);
    $("#msg_sucess").hide();
    $("#preview-img").attr("src", "/myimg.jpg");
}
    function discountDetail(id){
    $("#discountDetail").modal("show");
    $.ajax({
        url:JS_BASE_URL+'/merchant/get_discount/'+id,
        type:'GET',
        dataType:'JSON',
        success:function(response){
            $("#discount_id_single").html("Discount# "+response.idf);
            $("#discount_percent_single").html(+response.discount_percentage+"%");
            $('#discount_image_single').css("background-image", "url("+JS_BASE_URL+"/images/discount/"+response.id+ "/" +response.image+ ")");  
            $("#msg_discount_loading").fadeOut("slow");
            
        },
        error:function(response){
            console.log(response);
        }
    });
    
}


function activaTab(tab){
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
};

function increase_val(str, item) {
	var plural = '';
    var curr_val = parseInt($('input[name="'+item+'ff'+'"]').val());
    curr_val = curr_val + 1;
	//plural = (curr_val > 1) ? "s" : "";
    $('input[name="'+item+'ff'+'"]').val(curr_val+' '+str+plural);
    $('input[name="'+item+'"]').val(curr_val);
};


function decrease_val(str, item) {
	var plural = '';
    var curr_val = parseInt($('input[name="'+item+'"]').val());
    if (curr_val > 0) {
        curr_val = curr_val - 1;
		//plural = (curr_val > 1) ? "s" : "";
        $('input[name="'+item+'ff'+'"]').val(curr_val+' '+str+plural);
        $('input[name="'+item+'"]').val(curr_val);
    }
};

function discount_percentage_inc(){
    var curr_val = parseInt($('input[name="discount_percentage"]').val());
    curr_val = curr_val + 1;
    $('input[name="percentage"]').val(curr_val);
    $('input[name="discount_percentage"]').val(curr_val+"%");
};

function discount_percentage_dec(){
    var curr_val = parseInt($('input[name="discount_percentage"]').val());
    if (curr_val > 0) {
        curr_val = curr_val - 1;
        $('input[name="percentage"]').val(curr_val);
        $('input[name="discount_percentage"]').val(curr_val+"%");
    }
};
$('input[name="discount_percentage"]').keyup(function(){
    var curr_val = parseInt($('input[name="discount_percentage"]').val());


        $('input[name="percentage"]').val(curr_val);
        $('input[name="discount_percentage"]').val(curr_val+"%");

});
function getleftDiscounts(id){
    $("#discountLeftModal").modal("show");
    $.ajax({
        url:JS_BASE_URL+'/merchant/get_left_discounts/'+id,
        type:'GET',
        dataType:'JSON',
        success:function(response){
            $('#left_discount_buyer_table').html('');
            $('#left_discount_id').html("Discount Left ");
            var i=1;
            $.each(response, function (index, value) { 
                $('#left_discount_id').html("Discount Left");
              $('#left_discount_buyer_table').append('<tr>'+
                '<td style="text-align: center;">'+ i +'</td>'+
                '<td style="text-align: center;">'+ value.discount_idf +'</td>'+
                '<td style="text-align: center;"><a href="'+JS_BASE_URL+'/admin/popup/user/'+value.user_id+'">'+ value.user_idf +'</a></td>'+
                '<td style="text-align: center;">'+ value.created_at +'</td>'+

                '</tr>');
              i++; 
          });
            $('#left_discount_buyer_details_table').DataTable();
            $("#msg_discount_loading").fadeOut("slow");

            
        },
        error:function(response){
            console.log(response);
        }
    });
    
}
function getBuyerDiscounts(id){
  $("#discountIssueModal").modal("show");
  $.ajax({
    url:JS_BASE_URL+'/merchant/get_buyer_discounts/'+id,
    type:'GET',
    dataType:'JSON',
    success:function(response){
      $('#discount_buyer_table').html('');
      $('#discount_id').html("Discount ID: "+id);
      var i=1;
      $.each(response, function (index, value) {
        if (value.expired) {
          var color_name='red';
        }else{
          var color_name='black';
        }
        $('#discount_buyer_table').append('<tr style="color: '+color_name+';" >'+
          '<td style="text-align: center;">'+ i +'</td>'+
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
</script>
@if(isset($_GET['tab']))

    <script type="text/javascript">
        tagID="{{$_GET['tab']}}";
        activaTab(tagID);
    </script>
@endif
@stop

