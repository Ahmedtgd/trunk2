<?php 
define('MAX_COLUMN_TEXT', 20); 
$ow_product_count = 0;
$row_count = 0;
use App\Http\Controllers\PriceController;
?>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

<style type="text/css">
	.user_icon{
		max-width: 0.1em;
		max-height: 0.15em;
	}
	.line_2{
		font-size: 1em;
	}
	.price{}
	.old-price{
		font-size: 0.9em;
		color: #888;
		text-decoration:line-through;
	}
	.new-price {
		font-size: 1.1em;
		font-weight: 400;
	}
  .quantity{
    border: 1px solid color:#27a98a;
    cursor: hand;
    cursor: pointer;
    height: 2em;
    widows: 2em;
  }
  .placebo{
    height: 2em;
  }
    .well{
    font-family: 'Lato', sans-serif !important;
  }
  
 .btn-info2 {
    color: #fff;
    background-color: #51D300;
    border-color: #00FF11;
}

.btn-info2 {
    color: #fff;
    background-color: #51D300;
    border-color: #00FF11;
}

.btn-info2:hover {
    color: #fff;
    background-color: #55DC00;
    border-color: #00FF11;
}

.btn-info2.focus {
  color: #fff;
  background-color: #51D300;
  border-color: #00FF11;
}

.btn-info2:active, {
  color: #fff;
  background-color: #55DC00;
  border-color: #00FF11;
} 
</style>

<div class="col-sm-12"> <h2>Hyper</h2>

			<div class="row">
				  <div class="col-sm-12">
				    <div class="row">
				    	{{-- foreach --}}
				    	@foreach($ow_product as $product)
				    	{{-- Calculations --}}
				    		<?php
                                $qty = explode(',', $product['pledged_qty']);
                             	$v=0;
                             	if (array_filter($qty)) {
                             		foreach ($qty as $key => $value) {
                             			# code...
                             			$v = $v + $value;
                             		}
                             	}
                             	$left_pledge = ($product->owarehouse_moq - $v) > 0 ? ($product->owarehouse_moq - $v) : 0; 
				    		 ?>
				          	{{-- Calculations --}}
						          	<?php
                                    $date = $product->odate;
                                    $date = strtotime($date);
                                    $current_date = strtotime(date('Y-m-d H:i:s'));
                                    $date1 = new DateTime('now');
                                    $date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $globals->hyper_duration day", $date)));
                                    $dDiff = $date1->diff($date2);
                                    $price = ($product->owarehouse_price / 100);
                                	$op = $product['retail_price'] / 100;
                                	// $save = $op > 0 ? sprintf('%.2f', ((($op - $product->owarehouse_price) / $op) * 100)) : 0;
                                	$save= $op>0 ? (($op-$price)/$op)*100 :0;
                                	$status=1;
                                	if ($dDiff->format("%r") == '-') {
                                		# code...
                                		$status='<span class="label label-danger pull-right">Expired</span>';
                                		$status=0;
                                	}
                                   $left = ($product->owarehouse_moq - $v) > 0 ? ($product->owarehouse_moq - $v) : 0; 
								   if ($dDiff->format("%r") != '-') {
								    $p= new PriceController;
									$gst=$p->init($product['product_id'],'gst')/100;
									$x= new PriceController;
									$delivery=$x->init($product['product_id'],'delivery')/100+$gst;									   
                                    ?>
						          	{{-- Ends --}}
				    	{{-- Ends --}}
							<?php
							if($row_count == 3){
							$row_count = 0;
							?>
							<div class="clearfix"> </div>
							<?php
							}
							?>						
						     <div class="col-md-4">
						        <div class="well owarehouseform">
						        	{{-- image --}}
						        	<span class="text-center"><center><mark>
									<?php
									echo $dDiff->format("%r") == '-' ? 'Expired' :'Time Left: '.($dDiff->y >0 ? $dDiff->y ." y ":"").($dDiff->m >0 ? $dDiff->m ." mo ":""). $dDiff->d ." days" . $dDiff->h ." hrs and ". $dDiff->i ." mins "; ?></mark></center></span>
									<div class="no-padding imagePreview" id="imagePreview2"
										style="height: 260px; margin-top: -2px;
										background-size:contain;
										background-position: center top;
										object-fit:contain;
										background-repeat: no-repeat;
										background-image: url('{{asset('/')}}images/product/{{$product->product_id}}/{{$product->photo_1}}');">
									</div>
									<div class="clearfix"> </div>
									<hr>
						          	<div>
									<div>
						          	<div class="text-primary">
										@def $ii = 0
										@def $sumii = 0
										@if (array_filter($qty))
											@foreach($qty as $key => $value)
												@if ($ii <= 5)
													<i class="fa fa-user fa-1x" style="float: left; padding:3px;" aria-hidden="true">{{$value}}</i>
												@endif
												@def $sumii = $sumii + $value
												<?php $ii++; ?>
											@endforeach
												<span class="pull-right"><span style="color: #000;"><strong >P&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;{{$ii}}&nbsp;</span></strong></span>&nbsp;<span style="color: #000;"><strong>Q&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;{{$sumii}}&nbsp;</span></strong></span></span>
										@else
											<span class="pull-right"><span style="color: #000;"><strong >P&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;{{$ii}}&nbsp;</span></strong></span>&nbsp;<span style="color: #000;"><strong>Q&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;{{$sumii}}&nbsp;</span></strong></span></span>
										@endif
									</div>						          	
						          	</div>
									<div class="clearfix"> </div>	
									<span class="badge pull-left" style="background:red; font-size: 12px; margin-top: 10px; vertical-align: middle;">Save {{number_format($save,0)}}%</span>									
									<div class="clearfix"> </div>	
									<br>
									<hr>
									<?php
										/* Processed note */
										$pfullnote = null;
										$pnote = null;
										$elipsis = "...";
										$pfullnote = $product['name'];
										$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

										if (strlen($pfullnote) > MAX_COLUMN_TEXT)
											$pnote = $pnote . $elipsis;
									?> 									
						          	<h4><span title='{{$pfullnote}}'>{{$pnote}}</span>	</h4>

						          	<!-- <span class="line line_2">
						          	<b>Due Date </b> <span class="due_date label label-info">{{ date('d F Y',strtotime("+ $product->owarehouse_duration day",$date))}} </span>

						          	</span> -->
						          	<div class="line line_3">
						          		Price :<span class="new-price price">{{$currentCurrency}}&nbsp;{{number_format($price,2)}} </span> <span class="old-price price">{{$currentCurrency}}&nbsp;{{number_format($product['retail_price']/100,2)}} </span>
						          		{{-- Retail Price: <b>{{$currentCurrency}} 10</b> Discounted Price: <b> MYR 9 </b> --}}
						          	</div>									
						          	<div class="line ">
  						          	<table class="table striped replacable_1">
  						          		<tr>
  						          			<td width="40%">MOQ</td>
  						          			<td width="5%">{{$product->owarehouse_moq}}</td>
                              <td width="55%"> <span class="pull-right">{{$currentCurrency}}&nbsp;{{number_format($price * $product->owarehouse_moq,2)}}</span></td>
  						          		</tr>
                            <tr>
                              <td>MOQ/location</td>
                              <td>{{$product->owarehouse_moqperpax}}</td>
                              <td><span class="pull-right">{{$currentCurrency}}&nbsp;{{number_format($price * $product->owarehouse_moqperpax,2)}}</span></td>
                            </tr>

  						          		<tr>
  						          			<td>Left</td>
  						          			<td>{{$left}}</td>
                              <td><span class="pull-right">{{$currentCurrency}}&nbsp;{{number_format($left * $price,2)}}</span></td>
  						          		</tr>
  						          		<tr>
											<?php 
											$pl = 0;
											if($product->owarehouse_moq > 0 && $v > 0){
												$pl = ($v * 100)/$product->owarehouse_moq;
											}												
											?>
  						          			<td>Bought&nbsp;{{number_format($pl,0)}}%</td>
  						          			<td>{{$v}}</td>
                              <td><span class="pull-right">{{$currentCurrency}}&nbsp;{{number_format($v * $price,2)}}</span></td>
  						          		</tr>										
  						          	</table>
                          <table >
                           
                          </table>
						          	</div>
                        {{-- <div class="line line_4"> --}}
                        {{--  @if($status==0) disabled @endif --}}
{{--                           <table>
                            <tr>
                              <td><button type="button" class="btn btn-info submitoword a1" id="pledge_{{$product->id}}" @if($status==0 or $product->owarehouse_moq - $v <= 0) disabled @endif >Pledge</button></td>
                              <td> &nbsp</td>
                            <td><button type="button" class="btn btn-danger resetoword" @if($status==0 or $product->owarehouse_moq - $v <= 0) disabled @endif >Reset</button></td>
                            </tr>
                          </table> --}}
                          <script type="text/javascript"></script>
                        {{-- </div> --}}
							<center><a href="javascript:void(0)" class="hyperterms" rel="{{$product['id']}}"> Terms & Conditions</a></center>
						        </div>

                    {{-- well ends --}}
				      		</div> 
                  {{-- col ends --}}
							</div>
							<?php $row_count++; ?>
							<?php }  ?>
				    	@endforeach		
				    <!--/row-->    
            {{-- Hyper products found --}}
				    	{{-- foreach --}}
				    	@foreach($ow_product_ple as $product_ple)
				    	{{-- Calculations --}}
				    		<?php
                                $qty = explode(',', $product_ple['pledged_qty']);
                             	$v=0;
                             	if (array_filter($qty)) {
                             		foreach ($qty as $key => $value) {
                             			# code...
                             			$v = $v + $value;
                             		}
                             	}
                             	$left_pledge = ($product_ple->owarehouse_moq - $v) > 0 ? ($product_ple->owarehouse_moq - $v) : 0; 
				    		 ?>
				          	{{-- Calculations --}}
						          	<?php
                                    $date = $product_ple->odate;
                                    $date = strtotime($date);
                                    $current_date = strtotime(date('Y-m-d H:i:s'));
                                    $date1 = new DateTime('now');
                                    $date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $globals->hyper_duration day", $date)));
                                    $dDiff = $date1->diff($date2);
                                    $price = ($product_ple->owarehouse_price / 100);
                                	$op = $product_ple['retail_price'] / 100;
                                	// $save = $op > 0 ? sprintf('%.2f', ((($op - $product->owarehouse_price) / $op) * 100)) : 0;
                                	$save= $op>0 ? (($op-$price)/$op)*100 :0;
                                	$status=1;
                                	if ($dDiff->format("%r") == '-') {
                                		# code...
                                		$status='<span class="label label-danger pull-right">Expired</span>';
                                		$status=0;
                                	}
                                   $left = ($product_ple->owarehouse_moq - $v) > 0 ? ($product_ple->owarehouse_moq - $v) : 0;
								   if($left < 0){
									   $left = 0;
								   }	
									if ($dDiff->format("%r") != '-') {
								    $p= new PriceController;
									$gst=$p->init($product['product_id'],'gst')/100;
									$x= new PriceController;
									$delivery=$x->init($product['product_id'],'delivery')/100+$gst;										
                                    ?>
						          	{{-- Ends --}}
				    	{{-- Ends --}}
							<?php
							if($row_count == 3){
							$row_count = 0;
							?>
							<div class="clearfix"> </div>
							<?php
							}
							?>
						     <div class="col-md-4">
						        <div class="well owarehouseform">
						        	{{-- image --}}
						        	<span class="text-center"><center><mark><?php echo $dDiff->format("%r") == '-' ? '<div></div>' :'Time Left: '.($dDiff->y >0 ? $dDiff->y ." y ":"").($dDiff->m >0 ? $dDiff->m ." mo ":""). $dDiff->d ." days" . $dDiff->h ." hrs and ". $dDiff->i ." mins "; ?></mark></center></span>
									<div class="no-padding imagePreview" id="imagePreview2"
										style="height: 260px; margin-top: -2px;
										background-size:contain;
										background-position: center top;
										object-fit:contain;
										background-repeat: no-repeat;
										background-image: url('{{asset('/')}}images/product/{{$product_ple->product_id}}/{{$product_ple->photo_1}}');">
									</div>
									<div class="clearfix"> </div>
									<hr>
						          	<div>
						          	<div class="text-primary">
										@def $ii = 0
										@def $sumii = 0
										@if (array_filter($qty))
											@foreach($qty as $key => $value)
												@if ($ii <= 5)
													<i class="fa fa-user fa-1x" style="float: left; padding:3px;" aria-hidden="true">{{$value}}</i>
												@endif
												@def $sumii = $sumii + $value
												<?php $ii++; ?>
											@endforeach
												<span class="pull-right"><span style="color: #000;"><strong >P&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;{{$ii}}&nbsp;</span></strong></span>&nbsp;<span style="color: #000;"><strong>Q&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;{{$sumii}}&nbsp;</span></strong></span></span>
										@else
											<span class="pull-right"><span style="color: #000;"><strong >P&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;{{$ii}}&nbsp;</span></strong></span>&nbsp;<span style="color: #000;"><strong>Q&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;{{$sumii}}&nbsp;</span></strong></span></span>
										@endif
									</div>										
									@if($status==0)
						          		<span class="label label-danger pull-right">Expired</span>
						          	@else
									<div class="clearfix"> </div>	
									<span class="badge pull-left" style="background:red; font-size: 12px; margin-top: 10px; vertical-align: middle;">Save {{number_format($save,0)}}%</span>
									{!! Form::open(array('role'=>'role','class'=>'owarehouseformd', 'style'=>'margin-top: 7px;')) !!}
										<p style="display:none" class = "o_id">{{$product_ple['owarehouse_id']}}</p>
										<input type="hidden" value="{{$product_ple->owarehouse_moqperpax}}" id="moqpax_{{$product['product_id']}}">
										<p style="display:none" class="owarehouse_id">{{$product_ple['id']}}</p>
										<p style="display:none" class="parent_id">{{$product_ple['product_id']}}</p>
										<p style="display:none" class="delivery">{{$delivery}}</p>
										<p style="display:none" class="owarehouse_price">{{$price}}</p>
										<div class="price" style="display:none"><?php echo $price; ?></div> 
										<p class="pull-right" style="vertical-align: middle;">
											<button type="button" class="btn btn-green btn-number quantity" style="vertical-align: middle; width:28px; height: 28px; padding: 4px;" data-id='+' min="{{$product_ple->owarehouse_moqperpax}}" max="1000000">
												<span class="glyphicon glyphicon-plus"></span>
											</button>												

										   <input type="text" class="order_value text-center" size="4" align="center" style="vertical-align: middle; height: 28px;"  name="quant[2]" value="{{$product_ple->owarehouse_moqperpax}}" min="{{$product_ple->owarehouse_moqperpax}}" max="1000000" >
											<button type="button" class="btn btn-green btn-number quantity" style="vertical-align: middle; width:28px; height: 28px; padding: 4px;" data-id='-' min="{{$product_ple->owarehouse_moqperpax}}" max="1000000">
													 <span class="glyphicon glyphicon-minus"></span>
											</button>										   	
											<button type="button" class="btn btn-info2 submitoword a1" id="pledge_{{$product_ple->id}}">Pledge</button>
										</p>
										<input type="hidden" value="{{$product_ple->available}}" id="available_{{$product_ple['product_id']}}" />
											<input type="hidden" value="1" id="canpledge" />
									{!! Form::close() !!}									
						          	@endif
						          	</div>
									<div class="clearfix"> </div>
									<hr>
									<?php
										/* Processed note */
										$pfullnote = null;
										$pnote = null;
										$elipsis = "...";
										$pfullnote = $product_ple['name'];
										$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

										if (strlen($pfullnote) > MAX_COLUMN_TEXT)
											$pnote = $pnote . $elipsis;
									?> 									
						          	<h4><span title='{{$pfullnote}}'>{{$pnote}}</span>	</h4>

						          	<!-- <span class="line line_2">
						          	<b>Due Date </b> <span class="due_date label label-info">{{ date('d F Y',strtotime("+ $product_ple->owarehouse_duration day",$date))}} </span>

						          	</span> -->
						          	<div class="line line_3">
						          		Price :<span class="new-price price">{{$currentCurrency}} {{number_format($price,2)}} </span> <span class="old-price price">{{$currentCurrency}}{{number_format($product_ple['retail_price']/100,2)}} </span>
						          		{{-- Retail Price: <b>MYR 10</b> Discounted Pricce: <b> MYR 9 </b> --}}
						          	</div>
						          	<div class="line ">
  						          	<table class="table striped replacable_1">
  						          		<tr>
  						          			<td>MOQ</td>
  						          			<td class="text-center">{{$product_ple->owarehouse_moq}}</td>
                              <td class="text-right">{{$currentCurrency}}&nbsp;{{number_format($price * $product_ple->owarehouse_moq,2)}}</td>
  						          		</tr>
                            <tr>
                              <td>MOQ/location</td>
                              <td class="text-center">{{$product_ple->owarehouse_moqperpax}}</td>
							  <input type="hidden" value="{{$product_ple->owarehouse_moqperpax}}" id="moqperpax" />
                              <td class="text-right">{{$currentCurrency}}&nbsp;{{number_format($price * $product_ple->owarehouse_moqperpax,2)}}</td>
                            </tr>

  						          		<tr>
  						          			<td>Left</td>
  						          			<td class="text-center">{{$left}}</td>
                              <td class="text-right">{{$currentCurrency}}&nbsp;{{number_format($left * $price,2)}}</td>
  						          		</tr>
  						          		<tr>
											<?php 
											$pl = 0;
											if($product_ple->owarehouse_moq > 0 && $v > 0){
												$pl = ($v * 100)/$product_ple->owarehouse_moq;
											}	
											?>
  						          			<td>Bought&nbsp;{{number_format($pl,0)}}%</td>
  						          			<td class="text-center">{{$v}}</td>
                              <td class="text-right">{{$currentCurrency}} {{number_format($v * $price,2)}}</td>
  						          		</tr>										
  						          	</table>
						          	</div>
                        {{-- <div class="line line_4"> --}}
                        {{--  @if($status==0) disabled @endif --}}
                          <script type="text/javascript"></script>
                        {{-- </div> --}}
							<center><a href="javascript:void(0)" class="hyperterms" rel="{{$product['id']}}"> Terms & Conditions</a></center>
						        </div>

                    {{-- well ends --}}
				      		</div> 
							<?php $row_count++; ?>
							<?php }  ?>
                  {{-- col ends --}}
				    	@endforeach		
				    </div><!--/row-->    
				  </div><!--/col-12-->

			</div><!--/row-->			

</div>

	<div class="modal fade" id="myModalHyperterms" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
				</div>
				<div class="modal-body">
					<div id="hypert"></div>			
				</div>
			</div>
		</div>
	</div>

<script>
$(document).ready(function(){
	
		 $(document).delegate( '.hyperterms', "click",function (event) {
		//$('.hyperterms').on('click', function() {
		//	alert("aaaa");
			var hyperid = $(this).attr('rel');
			$.ajax({
				url: "/hyperterms/" + hyperid,
				type: "get",
				success: function(data) {
					$("#hypert").html(data);
					$("#myModalHyperterms").modal("show");
				}
			});							
        });	

        $('.static-tab ul li a').on('click', function() {
            $('html,body').animate({scrollTop: $($(this).attr('href')).offset().top}, 1200);
        });
        
        $(".border-box").hover(
                function() {
                    $(this).addClass('order-border-box');
                    $(this).find('.order_none').show();
                }, function() {
            $(this).removeClass('order-border-box');
            $(this).find('.order_none').hide();
        });
 
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll > 100) {
            $('#ahr').show(1000);
        }
        if (scroll <= 100) {
            $('#ahr').hide(1000);
        }

    });

    $(document).off('click','.quantity').on('click','.quantity',function(e){

        var quenty = $(this).siblings('.order_value');
        var value = parseInt(quenty.val());
        var type = $(this).data('id');
        var price = parseFloat($(this).siblings('.price').html());
        var pledge = parseInt($(this).closest('.owarehouse-box').find('.pledge').html());
        var left = parseInt($(this).closest('.owarehouse-box').find('.left').html());
        var st_left = parseInt($(this).closest('.owarehouse-box').find('.left').attr('st-left'));
        var st_pledge = parseInt($(this).closest('.owarehouse-box').find('.pledge').attr('st-pledge'));
        var moq = parseInt($(this).closest('.owarehouse-box').find('.moq').html());
		var parent_id = $(this).closest('.owarehouseform').find('.parent_id').text();
		//var moqpax = parseInt($(this).closest('.moqpax').find('.pledge').html());
        var moqpax = parseInt($('#moqpax_' + parent_id).val());
        var current_pledge =  parseInt($(this).closest('.owarehouse-box').find('.pledge-icon-qty').html());
        var qty = value;
        if (type == '+')
        {
            if(value < $(this).attr('max')){
                qty = value + (1*moqpax);
				if((qty % moqpax) != 0){
					var modd = (qty % moqpax);				
					qty = qty + (moqpax - modd);				
				}
				quenty.val(qty);
                
                if(parseInt(left) <= parseInt(moq)){
					pledge = st_pledge + qty;
					current_pledge = current_pledge + (1*moqpax);
                }
                if(parseInt(left) >= 1){
					left = st_left - qty;
                }
            }
        }
    
        if(type == '-') {
            if (value > $(this).attr('min'))
            {
                qty = value - (1*moqpax);
				if((qty % moqpax) != 0){
					var modd = (qty % moqpax);				
					qty = qty + (moqpax - modd);				
				}
				quenty.val(qty);
                				
             if(parseInt(pledge) >= 1){
                 pledge = pledge -(1*moqpax);
                 current_pledge = current_pledge - (1*moqpax) ;
             }
             if(parseInt(left) <= parseInt(moq))
                 left = left + (1*moqpax);
            }
        }
        $(this).closest('.owarehouse-box').find('.pledge').html(pledge);
        $(this).closest('.owarehouse-box').find('.pledge-price').html(number_format(pledge * price,2));
         $(this).closest('.owarehouse-box').find('.pledge-icon-qty').html(current_pledge);
        $(this).closest('.owarehouse-box').find('.left').html(left);
        $(this).closest('.owarehouse-box').find('.left-price').html(number_format(left * price,2));
        $(this).siblings('.rm-1').html(qty ?  number_format((qty * price),2) : "0");
    });

      $(document).off('click', '.resetoword').on('click', '.resetoword', function(e) {
          alert($(this).closest('.owarehouseform').find('input.order_value').val());
          var price = $(this).closest('.owarehouseform').find('.owarehouse_price').text();
          $(this).closest('.owarehouseform').find('.rm-1').html(number_format(price,2));
          $(this).closest('.owarehouseform').find('input.order_value').attr('value',1);
          $(this).closest('.owarehouseform').find('input.order_value').val(1);

        var pledge = $(this).closest('.owarehouse-box').find('.pledge').attr('st-pledge');
        var left = $(this).closest('.owarehouse-box').find('.left').attr('st-left');
        $(this).closest('.owarehouse-box').find('.pledge').html(pledge);
        $(this).closest('.owarehouse-box').find('.pledge-price').html( number_format(pledge * price,2));
        $(this).closest('.owarehouse-box').find('.left').html(left);
        $(this).closest('.owarehouse-box').find('.left-price').html(number_format(left * price,2));
      });

    $(document).off('click', '.a1').on('click', '.a1', function(e) {
        e.preventDefault();

		var parent_id = $(this).closest('.owarehouseform').find('.parent_id').text();
		var delivery = $(this).closest('.owarehouseform').find('.delivery').text();
		var availabletotal = $("#available_" + parent_id).val();		
		var quantity = $(this).closest('.owarehouseform').find('.order_value').val();
		var moqpax = parseInt($('#moqpax_' + parent_id).val());
		var canpledge = $("#canpledge").val();
        var page = 'owarehouse';
		if(parseInt(availabletotal) > 0 && parseInt(availabletotal) >= parseInt(quantity)){
			if(parseInt(quantity) >= parseInt(moqpax)){
				if((parseInt(quantity) % parseInt(moqpax)) == 0){
					if(canpledge == "1"){		
						if(quantity > 0){
							console.log($(this).closest('.owarehouseform').find('.order_value').val());
							path = window.location.href;
							var url=JS_BASE_URL+"/cart/addtocart";
							// if (path.includes('public'))
							// {
							//     url = '/OpenSupermall/public/cart/addtocart';
							// }
							// else {
							//     url = '/cart/addtocart';
							// }
							var id = $(this).closest('.owarehouseform').find('.owarehouse_id').text();
							var owarehouse_id = $(this).closest('.owarehouseform').find('.o_id').text();
							var price = $(this).closest('.owarehouseform').find('.owarehouse_price').text();
							console.log(parent_id);
							var page = 'owarehouse';						
							 $.ajax({
									url: url,
									type: "post",
									data: {id: id, price: price, quantity: quantity,owarehouse_id:owarehouse_id,parent_id: parent_id,page:page,delivery_price:delivery},
									success:function(data){
										setTimeout(function () { window.location.reload(1); }, 50);
										toastr.info("Your pledge was successful. Product has been added to the Cart. Reloading page.");
									}
										});
									}
						} else {
							toastr.error("Please login in order to pledge");
						}
					} else {
						toastr.error("Quantity must be multuple of " + moqpax);
					}					
				} else {
					toastr.error("A minimum order of " + moqpax + " must be bought in order to be valid");
				}
			} else {
				toastr.error("Product not available");
			}								

    });

});
 function number_format(number, decimals, dec_point, thousands_sep) 
    {
          number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
          var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
              var k = Math.pow(10, prec);
              return '' + (Math.round(n * k) / k).toFixed(prec);
            };
          // Fix for IE parseFloat(0.55).toFixed(0) = 0;
          s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
          if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
          }
          if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
          }
          return s.join(dec);
    }
    </script>               
{{-- JS ends --}}
