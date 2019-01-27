<?php 
use App\Http\Controllers\IdController;
?>
    <div id="pinformation" class="row">
        <input type="hidden" value="{{ route('routeFetchFields') }}" id='routeFetchFields'>
        <input type="hidden" value="{{ route('routeFetchFieldsForSpecialPrice') }}" id='routeFetchFieldsForSpecialPrice'>
        <input type="hidden" value="{{ route('routeFetchFieldsForSpecialPricen') }}" id='routeFetchFieldsForSpecialPricen'>
		<input type="hidden" value="{{ route('routedeletepdealer') }}" id='routedeletepdealer'>
        <input type="hidden" value="{{ route('routegetdealers') }}" id='routegetdealers'>
        <div class="col-sm-12 row">
            <h1>Product Registration</h1>
        </div>
        <div class="col-sm-4 thumbnail" id='thumbnail'>
            <div class="product-photo">
                <img class="" style="width:100%;height:98%;object-fit:cover;object-position:center top" id="preview-imgsp"/>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
                {!! Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="name_p" class="name_p">Not assigned</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('brand_id', 'Brand', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="brand_p" class="brand_p">Not assigned</p>
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('category_id', 'Category', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="category_p" class="category_p">Not assigned</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('subcat_id', 'Sub Category', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="subcat_p" class="subcat_p">Not assigned</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('O-Shop', 'O-Shop', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                   <p id="oshop_p" class="oshop_p">{{(empty($oshop))?"&nbsp;":$oshop}}</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('short_description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    <p id="description_p" class="description_p">Not assigned</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('available', 'Quantity Available', array('class' => 'col-sm-3 control-label')) !!}
                <div class="form-group col-sm-9">
                   <p id="quantity_p" class="quantity_ps">Not assigned</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-7 col-sm-offset-3">
<!--                     <table class="table noborder">
                        <tr><th>Amount</th><td>{!! $active_currency !!}</td><td><span id="retail_amount">0.00</span></td></tr>
                        <tr><th>Delivery</th><td>{!! $active_currency !!}</td><td><span id="retail_delivery">0.00</span></td></tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-sm btn-number" data-type="plus" id="plus_b2b" data-field="">
                                  <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                </span>
                                <input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
                                type="text" name="" class="form-control input-number quantity" id="cantp_b2b"
                                value="1">
                                <span class="input-group-btn" style="float:left">
                                <button type="button" class="btn btn-info btn-sm btn-number"  data-type="minus" id="minus_b2b" data-field="">
                                  <span class="glyphicon glyphicon-minus"></span>
                                </button>
                                </span>
                                </div>
                            </td>
                            <td>{!! $active_currency !!}</td><td><span id="retail_total">0.00</span></td>
                        </tr>
                    </table> -->
                </div>
            </div>
            <div class="form-group">
                <div class=" col-sm-7 col-sm-offset-3" style="margin-top: 0px;">
<!--                     <li class="btn btn-green btn-sm" style="background-size : 100% 100%; background-image: url('{{ url() }}/images/shopping_cart_button.png')">
                        <button class='btn-link' type='submit'>
                        </button>
                    </li> -->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div id="wholesale" class="row">
        <div class="row">
            <div class="col-sm-12">
                <h2>Special Price</h2>
			    <div id='alert_rprice' style="display: none;" class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
			        <strong><h4><a href="#">
						<b style="color: red;">
							This product is NOT available in RETAIL
						</b></a></h4>
					</strong>
			    </div>				
				
                <br>
                <div class="row margin-top">
                    <div class="col-xs-12">
                        <div class="form-group" style="margin:0">
                            <div class="col-sm-2">
                                <div class="row">
                                    {!! Form::label('retail_price11', 'Retail Price', array('class' => 'control-label','style'=>'padding-top:0')) !!}
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="row">
                                    <p style="margin-bottom:0" id="rPrice_p" class="rPrice_p">Not assigned</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Special User List</h3>
                        <div class="table-responsive">
                            <table class="table table-striped noborder" id="sppTable">
								<thead>
									<tr>
										<th>No</th>
										<th>User&nbsp;ID</th>
										<th>Name</th>
										<th>Special&nbsp;Price</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                                <tr class='srow' data='0' id="srow-0">
									<td class="col-xs-1"><center id="num-0">1</center></td>
									<td class="col-xs-4">
										<span id="userIDs-0">
											<select class="form-control dealer_select" id="userID-0" required="" rel="0" >
												@if(!is_null($dealers))
													<option value="">Choose User</option>									
													@foreach($dealers as $dealer)
														<option value="{{$dealer->id}}">{{IdController::nB($dealer->id) . " - " . $dealer->first_name . " " . $dealer->last_name }} </option>
													@endforeach
												@else 
													<option value="">No autolinked users found</option>
												@endif 
											</select>
										</span>
										<span class="dealer_selected_id" id="dealerid-0" rel="0" style="display: none;"></span>
										<input type="hidden" id="dealer_id_0" value="0" />
									</td>								
									<td class="col-xs-3">
										<span class="dealer_selected" id="dealer-0" rel="0"></span>
									</td>
									<td class="col-xs-3">
										<a href="javascript:void(0);" class="sp_popup" rel="0">Special&nbsp;Price</a>
									</td>
									<td class="col-xs-1">
										<a href="javascript:void(0);" id="addsppn-0" class="die addsppn form-control text-center text-green" rel="0">
											<i class="fa fa-plus-circle"></i>
										</a>
										<a href="javascript:void(0);" id="remsppn-0" title="Warning: you will remove this user special prices" class="remsppn form-control text-center text-danger" rel="0" style="display:none;">
											<i class="fa fa-minus-circle"></i>
										</a>
									</td>
								</tr>
								</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
	<div class="col-sm-6">
	</div>
	<div class="col-sm-5">
		<div id="progresscontainsp"></div>
	</div>
	<br>
	<div class="row">
		<p style="float:right;">
			<a href="javascript:void(0)" class="btn btn-info" id="next_sp_product" style="cursor: pointer; font-size: 20px">Save</a>
		</p>
	</div>
<br/>
<script type="text/javascript">
$(document).ready(function(){

})
</script>
