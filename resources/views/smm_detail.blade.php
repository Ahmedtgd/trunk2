<div class='col-md-12'>
	@if(isset($smmdetails) and !is_null($smmdetails))
	<table class="table table-bordered  table-responsive" id="smmdetailTable">
	    <thead>
	        <tr class='paymentTable'>
	            <th>No</th>
	            <th class='nosort'>SMM ID</th>
	            <th>Name</th>
	            <th class='nosort'>Viewers</th>
	            <th class='nosort'>Shared Item</th>
	            <th class='nosort'>Shared Time</th>
	            <th class='nosort'>Clicked</th>
	            <th class='nosort'>Item Sold</th>
	            <th class='nosort'>Bought</th>
	            <th>Last Share</th>
	            <th>Source</th>
	            <th>Country</th>
	            <th>State</th>
	            <th>Area</th>
	            <th>Status</th>
	        </tr>
	    </thead>
	    <tbody>
	        @def $i = 1
	        @foreach($smmdetails as $key => $smmdetail)
	            <tr>
	                <td class="text-center">{!! $i++ !!}</td>
	                <td class="text-center">{!! $smmdetail->smmid !!}</td>
	                <td class="text-center">{!! $smmdetail->name !!}</td>
	                <td class="text-center">
	                @if(isset($smm_viewers) and !is_null($smm_viewers))
	                {!! $smm_viewers[$key]->viewers !!}
	                @endif
	                </td>
	                <td class="text-center">{!! $smmdetail->shared_item !!}</td>
	                <td class="text-center">{!! $smmdetail->shared_times !!}</td>
	                <td class="text-center">{!! $smmdetail->clicked !!}</td>
	                <td class="text-center">
	                @if(isset($smm_item_sold) and !is_null($smm_item_sold))
	                {!! $smm_item_sold[$key]->item_sold !!}
	                @endif
	                </td>
	                <td class="text-center">
	                @if(isset($smm_bought) and !is_null($smm_bought))
	                {!! $smm_bought[$key]->bought !!}
	                @endif
	                </td>
	                <td class="text-center">{!! $smm_last_share[$key]->last_share !!}</td>
	                <td class="text-center">{!! $smmdetail->source !!}</td>
	                <td class="text-center">{!! $smmdetail->country !!}</td>
	                <td class="text-center">{!! $smmdetail->state !!}</td>
	                <td class="text-center">{!! $smmdetail->area !!}</td>
	                <td class="text-center"></td>
	            </tr>
	        @endforeach
	    </tbody>
	</table>
	@else
	    <h3 class='text-muted'> No data found for smm detail in database </h3>
	@endif
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#smmdetailTable').DataTable({
    	"scrollX": true,               
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['nosort']
        }]
    });
})
</script>
