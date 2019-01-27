<div class="table-responsive col-sm-12">
  <h2>Voucher</h2>
	<h3 hidden="">{{$merchant_id}}</h3>

	<div class="row" style="margin-bottom: 10px">
	<div class="col-md-10">
	  <div class="pull-right">
		<label>
		  Search
		</label>
		<input type="text"  />
	  </div>
	</div>

  </div>
  @foreach($voucher_data as $i)
  <div class="row" style="margin-bottom: 10px">
	<div class="col-md-7 col-sm-3" style="background-color: #D7E748;min-height: 164px">
<p>
<span class="col-md-3" >Retail Price</span>
@if(isset($i['voucher_product']))
<span class="col-md-3" >{{$currentCurrency}} {{number_format(($i['voucher_product']->retail_price)/100,2)}} /pax</span>
@else
<span class="col-md-3">NA</span>
@endif
<span class="col-md-5" >Voucher ID: [{{str_pad($i['voucher']->id, 10, '0', STR_PAD_LEFT)}}]</span>
</p>
<p>
<span class="col-md-3" ></span>
<span class="col-md-3" >Date:</span>
<span class="col-md-5" >{{$i['voucher_timeslot']? date('dMy', strtotime($i['voucher_timeslot']->booking)): "&nbsp;"}}</span>
</p>
<p>
<span class="col-md-3"  ></span>
<span class="col-md-3"  >Period:</span>
<span class="col-md-5" >
	{{$i['voucher_timeslot']?date('H:i', strtotime($i['voucher_timeslot']->from)): "&nbsp;"}}
	- {{$i['voucher_timeslot']?  date('H:i', strtotime($i['voucher_timeslot']->to)) : "&nbsp;"}}</span>
</p>
<p>
<span class="col-md-3" ></span>
<span class="col-md-3" >Quantity:</span>
<span class="col-md-5" >{{$i['voucher_timeslot']?$i['voucher_timeslot']->qty_ordered: "&nbsp;"}}person</span>
</p>

<span style="margin-left: 280px;"><a href="#"><i>Term & Condition</i></a></span>
</div>
<div class="col-md-3 col-sm-2" style="background-color: #808080; color:white; min-height: 164px">

<span style="display: flex;">Discounted Price</span>
<p style="width: 100%;">
<span class="pull-right" style="font-size:40px; padding-top: 37px" >
	<span id="percentage">
		
	</span>
</span>
</p>


</p>
<p style="width: 40%">
Total
</p>
<p style="width: 40%;line-height: 9px;/">

</span>
</p>
	  <span style=" display: flex; color:black !important">Reference No </span>

	  <input  style=" color:black !important;" value="{{$i['voucher']->reference_no}}"  type="text" id="merchant_voucher_reference" />
		<label onclick="saveReference()" id="save_ref_button" style="cursor: pointer; display: none" class="btn btn-success">Save</label>
	</div>

	<div class="col-md-2" >
	  <button class="btn btn-success" style="width: 100%">Approve</button>
	  <button class="btn btn-warning" style="width: 100%">Reject</button>
	  <label class="label label-info">Status: {{$i['voucher']->status}}</label>
	</div>
  </div>
  @endforeach
</div>
