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
<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong class='cart-info'></strong>
</div>
<div class="col-sm-12" style="padding-left:0;">
<h2>Likes</h2>
<div class="col-md-12 col-xs-12" style="padding-left:0;padding-right:0;">
	<div class="cat-items">

		@foreach($product_likes as $row)
			<div class="p-box col-md-3 col-sm-4"
				style="padding-right:2px;margin-bottom:20px;" id="box-{{$row->id}}">
				<div class="cat-img">
					<div class="ribbon-wrapper-green">
					<div class="ribbon-green">
						Liked {{$row->since}}
					</div></div>
					<div class="Xphoto closeBtn delete-like" rel="{{$row->id}}" style="cursor:pointer;
						display:block;
						width:20px;margin-top:2px">
						<span id="closeboton"
							class="fa fa-times-circle fa-lg "
							title="remove">
						</span>
					</div>						
					<a href="{{route('productconsumer', $row->id)}}">
						<img class="img-responsive object-fit:contain" src="/images/product/{{$row->id}}/{{$row->photo_1}}">
					</a>
				</div>
				<div data-tooltip="{{$row->name}}"  class="mouseover">
				<div class="gradientEllipsis inside" style="margin-bottom: -18px; border-bottom:1px solid #dadada;" >
					{{$row->name}}
					<div class="dimmer"></div>
					</div>
					</div>

				@if (($row->discounted_price == $row->retail_price) || ($row->discounted_price == 0))
					@if ($row->retail_price > 0)

						<br/><strong style="font-size:1em;">
							{{$currentCurrency}} {{number_format($row->retail_price/100,2)}}</strong>
					@endif
				@else

					<br/><strong style="color:black; font-size:1em;">{{$currentCurrency}}</strong><strike style="color:red"><span style="color:#333;">
						<strong style="color:black; font-size:1em;">
							{{number_format($row->retail_price/100,2)}}</strong></span>
					</strike>
					<strong style="color:red; font-size:1em;">
						{{number_format($row->discounted_price/100,2)}}</strong>
					@if ($row->retail_price > 0 && $row->retail_price > $row->discounted_price)	
							<strong style="color:white;background:red; font-size:1em;"
							class="pull-right badgenew">
							
							Save {{number_format((($row->retail_price - $row->discounted_price)/$row->retail_price)*100,2)}}%
							</strong><br/>
					@endif

				@endif
			</div>
		@endforeach


		<div class="clearfix"></div>

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
        $('.cart-info').text(data[1]+' '+currency+
			number_format(price/100,2)+" Successfully added to the cart");

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
