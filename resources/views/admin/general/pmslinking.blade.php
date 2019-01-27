<?php 
	$globals = DB::table('global')->first(); 
	use App\Http\Controllers\IdController;
?>
@extends("common.default")

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
        .com, .pay, .ocom, .opay, .osales {
            width: 170px ;
        }

        table#merchantTable
        {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        .select2-dropdown.select2-dropdown--below{

        }

        .select2-selection__rendered{
            color: #7c7c7c !important;
            padding-left: 10px !important;
        }

        .select2-container--default .select2-selection--single{
            height: 35px;
            padding-top:2px;
            padding-bottom:4px;
            font-size: 1.2em;
            position: relative;
            border-radius: 0;
            border: 1px solid #ccc;
            color: #ccc;
        }

        .maxl{
            margin:25px ;
        }
        .inline{
            display: inline-block;
        }
        .inline + .inline{
            margin-left:10px;
        }
        .radio{
            color:#999;
            font-size:15px;
            position:relative;
        }
        .radio span{
            position:relative;
            padding-left:20px;
        }
        .radio span:after{
            content:'';
            width:15px;
            height:15px;
            border:3px solid;
            position:absolute;
            left:0;
            top:1px;
            border-radius:100%;
            -ms-border-radius:100%;
            -moz-border-radius:100%;
            -webkit-border-radius:100%;
            box-sizing:border-box;
            -ms-box-sizing:border-box;
            -moz-box-sizing:border-box;
            -webkit-box-sizing:border-box;
        }
        .radio input[type="radio"]{
            cursor: pointer;
            position:absolute;
            width:100%;
            height:100%;
            z-index: 1;
            opacity: 0;
            filter: alpha(opacity=0);
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"
        }
        .radio input[type="radio"]:checked + span{
            color:#0B8;
        }
        .radio input[type="radio"]:checked + span:before{
            content:'';
            width:5px;
            height:5px;
            position:absolute;
            background:#0B8;
            left:5px;
            top:6px;
            border-radius:100%;
            -ms-border-radius:100%;
            -moz-border-radius:100%;
            -webkit-border-radius:100%;
        }

        /*.accordion h3 {*/
            /*background: #f5f5f5;*/
            /*color: #4c4c4c;*/
            /*border: 0;*/
        /*}*/

        /*.accordion h3:hover {*/
            /*background: #f5f5f5;*/
            /*color: #4c4c4c;*/
            /*border: 0;*/
        /*}*/

        /*td.details-control {*/
            /*background: url('details_open.png') no-repeat center center;*/
            /*cursor: pointer;*/
        /*}*/
        /*tr.shown td.details-control {*/
            /*background: url('details_close.png') no-repeat center center;*/
        /*}*/

        .detail-row{
            display: none;
        }
    </style>
    <?php $i=1; ?>

    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')

        <h2>
            <span>General: Product Enable Linking</span>
            {{--<span class="pull-right" id="msLinkingDate">16/11/2016</span>--}}
        </h2>

        <div>
            <form id="msLinkingForm" action="{{route('PostMass_autolinkFilter')}}" method="POST">
				<input type="hidden" name="mmerchant_id" value="" id="mmerchant_id">
				<input type="hidden" name="uid" value="{{$uid}}" id="uid">
                @include('partials.alert')

                @inject('msLinking', 'App\Classes\MsLinking')

                <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id='merchantTable'>

                    <thead style="background-color: #FF4C4C; color: white;"> <br>
                    <tr>
                        <th class="no-sort text-center bsmall" style="background-color:#4c4c4c;color:#fff;">No</th>
                        <th class="no-sort text-center" style="background-color:#4c4c4c;color:#fff;">Product&nbsp;ID</th>
                        <th class="no-sort text-center" style="background-color:#4c4c4c;color:#fff;">Name</th>
                        <th class="no-sort text-center" style="background-color:#4c4c4c;color:#fff;">Commission</th>
                        <th class="no-sort text-center" style="background-color:#4c4c4c;color:#fff;">B2B&nbsp;Price</th>
                        <th class="no-sort text-center" style="background-color:#4c4c4c;color:#fff;">Quantity</th>
                        <th class="no-sort text-center" style="background-color:#4c4c4c;color:#fff;">Status</th>
                        <th class="no-sort text-center bsmall" style="background-color:#4c4c4c;color:#fff;">Enable&nbsp;<input name="check-all" id="check-all" type="checkbox"></th>
                    </tr>
                    </thead>

                    @if(isset($products) && is_array($products) && count($products))
                        <tfoot>
							<tr colspan="5"></tr>
                        </tfoot>
                        <tbody>
                        @def $i = 1
                        @foreach($products as $product)

                            <tr id="product-{{$product->product_id}}">
                                <td class='text-center'>{!! $i++ !!}</td>
                                
								<td class='text-center'>
                                   <a href="{{URL::to('/')}}/productconsumer/{{$product->parent_id}}" target="_blank" data-id="{{$product->parent_id }}">{{IdController::nP($product->product_id)}}</a> 
                                </td>
								<?php 
									$pname = $product->name;
									if(strlen($pname) > 20){
										$pname = substr($pname, 0 , 17);
										$pname .= "...";
									}
								?>
								<td class='text-center'>
                                    <img src="{{asset('/')}}images/product/{{$product->parent_id}}/{{$product->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:4px"><span style="vertical-align: middle;" title="{{$product->name}}">{{$pname}}</span>
                                </td>
								<td class='text-center'>
									@if($product->osmall_commission  > 0)
										{{$product->osmall_commission}} %
									@else
										@if($product->merchant_osmall_commission  > 0)
											{{$product->merchant_osmall_commission}} %
										@else
											{{$global->osmall_commission}} %
										@endif
									@endif
									
                                </td>
								<td class='text-center'>
									<?php 
										$counter = 1;
										$all_wholesalescounter = count($product->wholesales);
									?>
									<div class="hide" id="price-{{ $product->product_id }}">
											<div class="row">
												<div class="table-responsive" style="border:0px">
													<table class="priceTable table">
														<thead>
															<tr>
																<th class='text-left'>Tier</th>
																<th class='text-right'>Price/Unit</th>
															</tr>
														</thead>
														<tbody>
														@foreach($product->wholesales as $wholesale)
															<tr>
																<td class='text-left'>
																	@if($all_wholesalescounter == $counter)
																		<span> > {{ $wholesale['funit'] }} </span>												
																	@else
																		<span> {{ $wholesale['funit'] }} </span> -
																		<span> {{ $wholesale['unit'] }} </span>
																	
																	@endif
																</td>
																<td class='text-right'>
																	<span> {{$currentCurrency}} </span>
																	<span> {{ number_format($wholesale['price']/100,2) }} </span>
																</td>
															</tr>
															
															<?php $counter++; ?>
															@endforeach
															<input type="hidden" id="counter" value="{{ $counter }}" />
														</tbody>
													</table>
												</div>
											</div>
									</div>
									@if(count($product->wholesales) > 0)
										{{$currentCurrency}} <span tabindex="0"  data-toggle="popover" data-trigger="hover" data-container="body" data-placement="top" type="button" data-html="true"  id="{{ $product->product_id }}" class="mprice{{$product->product_id}}">{{number_format($product->wholesales[0]['price']/100,2, '.', '')}}</span>
									@endif
								</td>
								<td class='text-center'>
									{{ ucfirst($product->available) }}
								</td>
								<td class='text-center'>
									{{ ucfirst($product->status) }}
								</td>
                                <td class='text-center'>
									<?php 
										$enabled = "";
										if(is_null($product->blacklist_id)){
											$enabled = "checked";
										}
									?>
                                    <input class="check-checkbox" data-id="{{$product->product_id}}" {{$enabled}}
                                       type="checkbox">
                                </td>
                              
                            </tr>

                        @endforeach
                        </tbody>
                    @endif
                </table>

                <div class="row" style="margin-bottom: 50px;margin-top: 20px;">
                    <div class="col-sm-12">
                       <button data-url="{{route('PostMass_autolink_product')}}" data-type="link" id="link-btn" type="button" class="btn btn-success pull-right" style="margin-right:15px;"> Save </button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script type="text/javascript">
        $(document).ready(function()
        {
			$("[data-toggle=popover]").popover({
				html: true,
				content: function() {
					id = $(this).attr('id');
					return $('#price-'+id).html();
				}
			});	
			
            var table = $('#merchantTable').DataTable({
                "scrollX": true,
                "columnDefs": [
                    {"targets": [0], "width": "30px", "orderable": false}, //no
                    {"targets": [1], "width": "150px",}, //link
                    {"targets": [2], "width": "160px"}, //enable
                    {"targets": [3], "width": "100px"}, //enable
                    {"targets": [4], "width": "100px"}, //enable
                    {"targets": [5], "width": "100px"}, //enable
                    {"targets": [6], "width": "80px"}, //type
                    {"targets": [7], "width": "50px", "orderable": false}, //station id
                ],
                destroy: true
            });
			
			$('#check-all').on('click', function(e){
                $('.check-checkbox').prop('checked', this.checked);
            });
			
			$('#link-btn').on('click', function(e){
				var rbtn = $(this);
				$("#link-btn").html("Saving...");
				var url = $(this).attr('data-url');
				var uid = $("#uid").val();
				var dataenable = [];
				$('.check-checkbox').each(function()
                    {
					dataenable.push({
						s_id: $(this).attr('data-id'),
						status: $(this).is(':checked'),
						u_id: uid
					});
				});
				
				$.ajax({
                    url:url,
                    type:'POST',
                    data: { dataenable: JSON.stringify(dataenable)},
                    dataType: 'json',
                    success:function (r)
                    {
						toastr.info("Enabling successfully updated!");
						$("#link-btn").html("Save");
					},
                    error: function(r){
                        toastr.error("Ops! Internal server error occurred");
						$("#link-btn").html("Save");
                    }
                });
				
			});
        });
    </script>
@stop
