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
        font-size: 18px;
        font-weight: bold;
        margin: 365px 0 0 610px;
    }
</style>
<?php $i=1; ?>
<div class="overlay" style="display:none;">
    <p>Please Wait...</p>
</div>
<div style="display: none;" class="removeable alert"> 
    <strong id='alert_heading'></strong><span id='alert_text'></span> 
</div>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div>
            <h2>Administration Analysis: Summary</h2>
           
            <div class="table-responsive">
				<h3>Sales</h3>
                <table class="table datat">
                    <thead>
                   <tr style="background-color: #B9B9B9; color: #fff;">
                        <th></th>
                        <th colspan="2">Today</th>
                        <th colspan="2">Week To Date</th>
                        <th colspan="2">Month To Date</th>
                        <th colspan="2">Year To Date</th>
                    </tr>					
                    <tr style="background-color: #B9B9B9; color: #fff;">
                        <th>Country</th>
                        <th>Local</th>
                        <th>USD</th>
                        <th>Local</th>
                        <th>USD</th>
                        <th>Local</th>
                        <th>USD</th>
                        <th>Local</th>
                        <th>USD</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($sales) && !empty($sales))
                        @foreach($sales as $s)
                            <tr>
                                <td>{{$s->country}}</td>
                                <td style="text-align: right;">{{number_format($s->DAYY,2)}}</td>
                                <td style="text-align: right;">{{number_format(($s->DAYY)/4,2)}}</td>
                                <td style="text-align: right;">{{number_format($s->WTD,2)}}</td>
                                <td style="text-align: right;">{{number_format(($s->WTD)/4,2)}}</td>
                                <td style="text-align: right;">{{number_format($s->MTD,2)}}</td>
                                <td style="text-align: right;">{{number_format(($s->MTD)/4,2)}}</td>
                                <td style="text-align: right;">{{number_format($s->YTD,2)}}</td>
                                <td style="text-align: right;">{{number_format(($s->YTD)/4,2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
			
			<hr>
			
            <div class="table-responsive">
				<h3>Merchants/Account</h3>
                <table class="table datat">
                    <thead>
                    <tr style="background-color: #ff6666; color: #fff;">
                        <th></th>
                        <th>Today</th>
                        <th colspan="2">Fee</th>
                        <th colspan="3">Week To Date</th>
                        <th colspan="3">Month To Date</th>
                        <th colspan="3">Year To Date</th>
                    </tr>					
                    <tr style="background-color: #ff6666; color: #fff;">
                        <th>Country</th>
                        <th>Head</th>
                        <th>Local</th>
                        <th>USD</th>
                        <th>Head</th>
                        <th>Local</th>
                        <th>USD</th>
                        <th>Head</th>
                        <th>Local</th>
                        <th>USD</th>
                        <th>Head</th>
                        <th>Local</th>
                        <th>USD</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($merchants) && !empty($merchants))
                        @foreach($merchants as $m)
                        <tr>
                            <td>{{$m->country}}</td>
                            <td style="text-align: right;">{{number_format($m->DAY_Head,2)}}</td>
                            <td style="text-align: right;">{{number_format($m->DAYY,2)}}</td>
                            <td style="text-align: right;">{{number_format(($m->DAYY)/4,2)}}</td>
                            <td style="text-align: right;">{{number_format($m->WTD_Head,2)}}</td>
                            <td style="text-align: right;">{{number_format($m->WTD,2)}}</td>
                            <td style="text-align: right;">{{number_format(($m->WTD)/4,2)}}</td>
                            <td style="text-align: right;">{{number_format($m->MTD_Head,2)}}</td>
                            <td style="text-align: right;">{{number_format($m->MTD,2)}}</td>
                            <td style="text-align: right;">{{number_format(($m->MTD)/4,2)}}</td>
                            <td style="text-align: right;">{{number_format($m->YTD_Head,2)}}</td>
                            <td style="text-align: right;">{{number_format($m->YTD,2)}}</td>
                            <td style="text-align: right;">{{number_format(($m->YTD)/4,2)}}</td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

			<hr>
			
            <div class="table-responsive">
				<h3>Stations</h3>
                <table class="table datat">
                    <thead>
                    <tr style="background-color: #800000; color: #fff;">
                        <th></th>
                        <th>Today</th>
                        <th>Week To Date</th>
                        <th>Month To Date</th>
                        <th>Year To Date</th>
                    </tr>					
                    <tr style="background-color: #800000; color: #fff;">
                        <th>Country</th>
                        <th>Head</th>
                        <th>Head</th>
                        <th>Head</th>
                        <th>Head</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($stations) && !empty($stations))
                        @foreach($stations as $st)
                        <tr>
                            <td>{{$st->country}}</td>
                            <td style="text-align: right;">{{number_format($st->DAY_Head,2)}}</td>
                            <td style="text-align: right;">{{number_format($st->WTD_Head,2)}}</td>
                            <td style="text-align: right;">{{number_format($st->MTD_Head,2)}}</td>
                            <td style="text-align: right;">{{number_format($st->YTD_Head,2)}}</td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
			
			<hr>
			
            <div class="table-responsive">
				<h3>Buyer Registered</h3>
				<table class="table datat">
					<thead>
					<tr style="background-color: #FF24C9; color: #fff;">
						<th>Country</th>
						<th>Today</th>
						<th>Week To Date</th>
						<th>Month To Date</th>
						<th>Year To Date</th>
					</tr>					
					<tr style="background-color: #FF24C9; color: #fff;">
						<th>Country</th>
						<th>Head</th>
						<th>Head</th>
						<th>Head</th>
						<th>Head</th>
					</tr>
					</thead>
					<tbody>
					@if(isset($buyer_registered) && !empty($buyer_registered))
						@foreach($buyer_registered as $by)
							<tr>
								<td>{{$by->country}}</td>
								<td style="text-align: right;">{{number_format($by->DAYY,2)}}</td>
								<td style="text-align: right;">{{number_format($by->WTD,2)}}</td>
								<td style="text-align: right;">{{number_format($by->MTD,2)}}</td>
								<td style="text-align: right;">{{number_format($by->YTD,2)}}</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>
			
			<hr>
			
            <div class="table-responsive">
				<h3>Active Buyers</h3>
				<table class="table datat">
					<thead>
					<tr style="background-color: #FF24C9; color: #fff;">
						<th></th>
						<th colspan="2">Today</th>
						<th colspan="2">Per Head</th>
						<th colspan="4">Week To Date</th>
						<th colspan="4">Month To Date</th>
						<th colspan="4">Year To Date</th>
					</tr>					
					<tr style="background-color: #FF24C9; color: #fff;">
						<th>Country</th>
						<th>%</th>
						<th>Head</th>
						<th>Local</th>
						<th>USD</th>
						<th>%</th>
						<th>Head</th>
						<th>Local</th>
						<th>USD</th>
						<th>%</th>
						<th>Head</th>
						<th>Local</th>
						<th>USD</th>
						<th>%</th>
						<th>Head</th>
						<th>Local</th>
						<th>USD</th>
					</tr>
					</thead>
					<tbody>
					@if(isset($activebuyer) && !empty($activebuyer))
						@foreach($activebuyer as $ab)
							<tr>
								<td>{{$ab->country}}</td>
								<td></td>
								<td style="text-align: right;">{{number_format($ab->DAY_Head,2)}}</td>
								<td style="text-align: right;">{{number_format($ab->DAYY,2)}}</td>
								<td style="text-align: right;">{{number_format(($ab->DAYY)/4,2)}}</td>
								<td></td>
								<td style="text-align: right;">{{number_format($ab->WTD_Head,2)}}</td>
								<td style="text-align: right;">{{number_format($ab->WTD,2)}}</td>
								<td style="text-align: right;">{{number_format(($ab->WTD)/4,2)}}</td>
								<td></td>
								<td style="text-align: right;">{{number_format($ab->MTD_Head,2)}}</td>
								<td style="text-align: right;">{{number_format($ab->MTD,2)}}</td>
								<td style="text-align: right;">{{number_format(($ab->MTD)/4,2)}}</td>
								<td></td>
								<td style="text-align: right;">{{number_format($ab->YTD_Head,2)}}</td>
								<td style="text-align: right;">{{number_format($ab->YTD,2)}}</td>
								<td style="text-align: right;">{{number_format(($ab->YTD)/4,2)}}</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>	

			<hr>	

            <div class="table-responsive">
				<h3>SMM Recruited</h3>
				<table class="table datat">
                    <thead>
                    <tr style="background-color: #558ed5; color: #fff;">
                        <th></th>
                        <th>Today</th>
                        <th>Week To Date</th>
                        <th>Month To Date</th>
                        <th>Year To Date</th>
                    </tr>					
                    <tr style="background-color: #558ed5; color: #fff;">
                        <th>Country</th>
                        <th>Head</th>
                        <th>Head</th>
                        <th>Head</th>
                        <th>Head</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($smmRecruited) && !empty($smmRecruited))
                        @foreach($smmRecruited as $smm)
                            <tr>
                                <td>{{$smm->country}}</td>
                                <td style="text-align: right;">{{number_format($smm->DAYY,2)}}</td>
                                <td style="text-align: right;">{{number_format($smm->WTD,2)}}</td>
                                <td style="text-align: right;">{{number_format($smm->MTD,2)}}</td>
                                <td style="text-align: right;">{{number_format($smm->YTD,2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
				</table>
			</div>	

			<hr>	

            <div class="table-responsive">
				<h3>Merchant Consultant Recruited</h3>
				<table class="table datat">
                    <thead>
                    <tr style="background-color: #ff6600; color: #fff;">
                        <th></th>
                        <th>Today</th>
                        <th>Week To Date</th>
                        <th>Month To Date</th>
                        <th>Year To Date</th>
                    </tr>					
                    <tr style="background-color: #ff6600; color: #fff;">
                        <th>Country</th>
                        <th>Head</th>
                        <th>Head</th>
                        <th>Head</th>
                        <th>Head</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($mc_recruited) && !empty($mc_recruited))
                        @foreach($mc_recruited as $mc)
                            <tr>
                                <td>{{$mc->country}}</td>
                                <td style="text-align: right;">{{number_format($mc->DAYY,2)}}</td>
                                <td style="text-align: right;">{{number_format($mc->WTD,2)}}</td>
                                <td style="text-align: right;">{{number_format($mc->MTD,2)}}</td>
                                <td style="text-align: right;">{{number_format($mc->YTD,2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
				</table>
			</div>	

			<hr>	

            <div class="table-responsive">
				<h3>Product Registered</h3>
				<table class="table datat">
					<thead>
					<tr style="background-color: #ffff00; color: #000;">
						<th></th>
						<th>Today</th>
						<th>Week To Date</th>
						<th>Month To Date</th>
						<th>Year To Date</th>
						</tr>						
					<tr style="background-color: #ffff00; color: #000;">
						<th>Country</th>
						<th>Head</th>
						<th>Head</th>
						<th>Head</th>
						<th>Head</th>
					</tr>
					</thead>
					<tbody>
					@if(isset($product_registered) && !empty($product_registered))
						@foreach($product_registered as $pr)
							<tr>
								<td>{{$pr->country}}</td>
								<td style="text-align: right;">{{number_format($pr->DAYY,2)}}</td>
								<td style="text-align: right;">{{number_format($pr->WTD,2)}}</td>
								<td style="text-align: right;">{{number_format($pr->MTD,2)}}</td>
								<td style="text-align: right;">{{number_format($pr->YTD,2)}}</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>	

			<hr>	

            <div class="table-responsive">
				<h3>Active Product</h3>
				<table class="table datat">
					<thead>
					<tr style="background-color: #ffff00; color: #000;">
						<th></th>
						<th colspan="3">Year to Date</th>
						</tr>						
					<tr style="background-color: #ffff00; color: #000;">
						<th>Country</th>
						<th>Item</th>
						<th>%</th>
						<th>Active</th>
					</tr>
					</thead>
					<tbody>
					@if(isset($active_product) && !empty($active_product))
						@foreach($active_product as $ap)
							<tr>
								<td>{{$ap->country}}</td>
								<td style="text-align: right;">{{number_format($ap->item,2)}}</td>
								<td style="text-align: right;">{{number_format(($ap->active*100)/$ap->item,2)}}%</td>
								<td style="text-align: right;">{{number_format($ap->active,2)}}</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>	

			<hr>	

            <div class="table-responsive">
				<h3>Cancellation, Return & Exchange</h3>
				<table class="table datat">
					<thead>
					<tr style="background-color: #403152; color: #fff;">
						<th></th>
						<th>Today</th>
						<th>Week to Date</th>
						<th>Month to Date</th>
						<th>Year to Date</th>
					</tr>							
					<tr style="background-color: #403152; color: #fff;">
						<th>Country</th>
						<th>Head</th>
						<th>Head</th>
						<th>Head</th>
						<th>Head</th>
					</tr>
					</thead>
					<tbody>
					@if(isset($returns) && !empty($returns))
						@foreach($returns as $m)
							<tr>
								<td>{{$m->country}}</td>
								<td style="text-align: right;">{{number_format($m->DAYY,2)}}</td>
								<td style="text-align: right;">{{number_format($m->WEEK,2)}}</td>
								<td style="text-align: right;">{{number_format($m->MONTH,2)}}</td>
								<td style="text-align: right;">{{number_format($m->YEARS,2)}}</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>				
        </div>
</div>

<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
        $(document).ready(function () {
		
            $('.datat').DataTable({
                'scrollX':true,
                 'autoWidth':false
            });
			
        });
    </script>
@yield("left_sidebar_scripts")
@stop
