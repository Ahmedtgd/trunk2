	@foreach($segments as $segment)
		<div class="row" id="segment{{$segment->id}}">
			<div class=" col-sm-2">
				<a  href="javascript:void(0);" class="text-danger delete_segment" rel='{{$segment->id}}'><i style="margin-top: -3px;" class="fa fa-minus-circle fa-2x"></i></a>
			</div>	
			<div class=" col-sm-10">
				<span class="segment_name" id="spansegment{{$segment->id}}" rel="{{$segment->id}}">{{$segment->description}}</span>
				<span id="inputsegment{{$segment->id}}" style="display: none;">
					<input type="text" value="{{$segment->description}}" rel="{{$segment->id}}" class="segment_input" id="inputsegmentv{{$segment->id}}" />
				</span>	
			</div>
			<div class="clearfix"></div>
		</div>
	@endforeach
	<div id="newsegments">
	</div>
	<div class="row">
		<div class=" col-sm-2">
			<a  href="javascript:void(0);" class="text-green add_segment"><i style="margin-top: -3px;" class="fa fa-plus-circle fa-2x"></i></a>
		</div>	
		<div class=" col-sm-10">
			<input type="text" value="" style="display: none;" id="inputsegmentnew" />
		</div>
		<div class="clearfix"></div>
	</div>
	<input type="hidden" value="{{$company_user_id}}" id="owner_id" /> 
<script type="text/javascript">
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	$(document).ready(function(){	

    });
</script>