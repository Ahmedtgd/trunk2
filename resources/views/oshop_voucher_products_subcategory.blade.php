<div class="col-sm-12" style="margin-bottom:10px">
    <div class="row">
        <h2 style="margin-left:8px;margin-bottom:0;margin-top:0">SMM</h2>
    </div>
</div>
<div class="col-sm-12" style="margin-bottom:10px">
    <div class="row">
		<h2 class="title" style="margin-left:8px;margin-top:0;">{{$category->description}}</h2>
		<h3 class="title" style="margin-left:8px;margin-top:0;">{{$subcategory->description}}</h3>
    </div>
</div>
	<div class="row" >
		<div class="col-sm-12">
		@foreach($merchantvouchers as $i)
			<a style="color: #000;" href="{{url('')."/buy-voucher/".$i["voucher"]->id}}" >
			<div class="row" style="margin-bottom: 10px">
			
				
					@if($i['voucher_product']->photo_2 == '')
						<div class="col-md-7 col-sm-3" style="background-color: #D7E748;min-height: 164px">
					@else
						<div class="col-md-7 col-sm-3" style="min-height: 164px;">
						<div style="min-height: 164px;background-size:cover;
									position: absolute;
										top: 0;
										left: 0;
										width: 100%;
										height: 100%;
										opacity : 0.4;
										z-index: -1;						
										background-position: center top;
										background-image: url('{{asset('/')}}images/product/{{$i['voucher_product']->id}}/{{$i['voucher_product']->photo_2}}');"></div>
					@endif
					@if(!is_null($i['voucher_timeslot']))
					<p>
						<span class="col-md-3" >Retail Price</span>
						<span class="col-md-3" >{{$currency->code or 'MYR'}} {{number_format(($i['voucher_timeslot']->price)/100,2)}} /pax</span>
						<span class="col-md-5" >Voucher ID: [{{str_pad($i['voucher']->id, 10, '0', STR_PAD_LEFT)}}]</span>
					</p>
					@else
					<p>
						<span class="col-md-3" >Retail Price</span>
						<span class="col-md-3" >{{$currency->code or 'MYR'}} {{number_format(($i['voucher_product']->retail_price)/100,2)}} /pax</span>
						<span class="col-md-5" >Voucher ID: [{{str_pad($i['voucher']->id, 10, '0', STR_PAD_LEFT)}}]</span>
					</p>						
					@endif					

					@if(!is_null($i['voucher_timeslot']))
						<p>
							<span class="col-md-3" ></span>
							<span class="col-md-3" >Date:</span>
							<span class="col-md-5" >{{$i['voucher_timeslot']? date('dMy', strtotime($i['voucher_timeslot']->booking)): ""}}</span>
						</p>
					@endif
					@if(!is_null($i['voucher_timeslot']))
					<p>
						<span class="col-md-3"  ></span>
						<span class="col-md-3"  >Period:</span>
						<span class="col-md-5" >{{$i['voucher_timeslot']?date('H:i', strtotime($i['voucher_timeslot']->from)): ""}} - {{$i['voucher_timeslot']?  date('H:i', strtotime($i['voucher_timeslot']->to)) : ""}}</span>
					</p>
					@endif
					@if(!is_null($i['voucher_timeslot']))
					<p>
						<span class="col-md-3" ></span>
						<span class="col-md-3" >Quantity:</span>
						<span class="col-md-5" >{{$i['voucher_timeslot']?$i['voucher_timeslot']->qty_ordered: ""}}person</span>
					</p>
					@else
					<p>
						<span class="col-md-3" ></span>
						<span class="col-md-3" >Quantity:</span>
						<span class="col-md-5" >{{$i['voucher']?$i['voucher']->unit: ""}}person</span>
					</p>						
					@endif
				</div>
				<div class="col-md-2" >
					<button class="btn btn-success" style="width: 100%">View Voucher</button>
					<label class="label label-info">Status: {{$i['voucher']->status}}</label>
				</div>
			</div>
			</a>
		@endforeach
		</div>
	</div>