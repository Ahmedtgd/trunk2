@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$c = 1;
?>
@section("content")
<link href="{{url('css/productbox.css')}}" rel="stylesheet" type="text/css">
<style>
.ribbon-wrapper-green {
    width: 84px;
    height: 88px;
    overflow: hidden;
    position: absolute;
    top: -2px;
    right: 0px;
}

.ribbon-green {
  font: 12px Lato;
  text-align: center;
  text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
  -webkit-transform: rotate(45deg);
  -moz-transform:    rotate(45deg);
  -ms-transform:     rotate(45deg);
  -o-transform:      rotate(45deg);
  position: relative;
  padding: 7px 0;
  left: -5px;
  top: 15px;
  width: 120px;
  background-color: #ff0080;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#ff0080), to(#ff0040));
  background-image: -webkit-linear-gradient(top, #ff0080, #ff0040);
  background-image:    -moz-linear-gradient(top, #ff0080, #ff0040);
  background-image:     -ms-linear-gradient(top, #ff0080, #ff0040);
  background-image:      -o-linear-gradient(top, #ff0080, #ff0040);
  color: #eee;
  -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
  -moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
  box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
}

.ribbon-green:before, .ribbon-green:after {
  content: "";
  border-top:   3px solid #6e8900;
  border-left:  3px solid transparent;
  border-right: 3px solid transparent;
  position:absolute;
  bottom: -3px;
}

.ribbon-green:before {
  left: 0;
}
.ribbon-green:after {
  right: 0;
}​
  table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
.btn-pink,.btn-pink:hover{color:#fff; background:#d7e748; }

.closeBtn:hover {
	color: red;
}
.cat-img {
	padding-top: 0;
}
</style>
@include('common.sellermenu')
<div class="container">
<div class="row">
<div class="col-sm-12" >
<h2>Likes</h2>
<div class="col-md-12 col-xs-12" style="padding-left:0;padding-right:0;">
	<div class="cat-items">

            <table class="table-bordered"  id="wishtTable" width="100%">
                <thead style="background-color: #ff0080;color:white">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Product&nbsp;ID</th>
                        <th class="text-center">Name</th>       
                        <th class="text-center">Likes</th>
                    </tr>
                </thead>
                <tbody>   
                    @foreach($product_likes as $wish)
                            <tr>
                                <td class="text-center">{{$c++}}</td>
								<td class="text-center">
									{{IdController::nP($wish->id)}}</td>
                                <td class="text-center">
									{{$wish->name}}</td>
                                <td class="text-center">
									{{$wish->wish}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>


		<div class="clearfix"></div>

	</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

    currency = $('#currency option:selected').text();
    $('.showCurrency').text(currency);

    $('#currency').on('change', function(){
        currency = $('#currency option:selected').text();
        $('.showCurrency').text(currency);
    })

	$('#wishtTable').dataTable().fnDestroy();
	$('#wishtTable').DataTable({
	"order": [],
	"columnDefs": [ {
	"targets" : 0,
	"orderable": false
	}]
   });
	
	path = window.location.href;
   var url;
//   if(path.contains('public'))
   if(path.indexOf('public')>0)
   {
        url = '/OpenSupermall/public/cart/addtocart';
   }
   else {
        url = '/cart/addtocart';
   }
   
   $('.delete-like').click(function(e){
		e.preventDefault(); 
		var product_id = $(this).attr('rel');
		console.log(product_id);
		$.ajax({
			  url: JS_BASE_URL + "/delete_like",
			  type: "post",
			  data: {
				'product_id':product_id
			  },
			  success: function(data){
				  toastr.info("Like successfully deleted");
				  $("#box-" + product_id).hide();
			  }
		});				  
   });
   
  $('.cartBtn').click(function(e){

    e.preventDefault();
    var price = $(this).siblings('input[name=price]').val();

    $.ajax({
      url: url,
      type: "post",
      data: {
        'quantity':$(this).siblings('input[name=quantity]').val(),
        'id': $(this).siblings('input[name=id]').val(),
        'price': price
      },
      success: function(data){

        $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
        $('.cart-info').text(data[1]+' '+ currency +
			number_format(price/100,2)+ " Successfully added to the cart");

        if(data[0] < 1) {
            $('.cart-link').text('Cart is empty');
            $('.badge').text('0');
        } else {
            $('.cart-link').text('View Cart');
            $('.badge').text(data[0]);
        }
      }
    });
  });
});
</script>
@stop
