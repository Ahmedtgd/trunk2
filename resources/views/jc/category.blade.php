@extends('common.default')
@section('content')
    <style>
		.cat-img {
			padding: 0px;
			min-height: 220px;
		}

		.cat-img img {
			height: 200px !important;
		}
    </style>
	<div class="container"><!--Begin main container-->
        <div class="row" style="margin-bottom: 20px;">	
			<center><h2>Telco Mobile Top Up</h2></center>
			@foreach($telcos as $telco)
				<div class="col-sm-4 col-md-4 column productbox">
					<div class="cat-img">
							<img src="{{ URL::to('/') }}/images/product/{{$telco->parent_id}}/{{$telco->photo_1}}" class="img simg img-responsive full-width">
					</div>
					<div data-tooltip="{{ucfirst($telco->description)}}"  class="producttitle">
						<div class="gradientEllipsis inside" style="margin-bottom: 2px; border-bottom:1px solid #dadada;" >
							 {{ucfirst($telco->description)}}
							<div class="dimmer"></div>
						</div>
                    </div>
					<div>
						<select class="telco_select" rel="{{$telco->id}}">
							<option value=""></option>
							@for($kk = 0; $kk < count($telco->product_id); $kk++)
								<option value="{{$telco->product_id[$kk]}}">{{$currentCurrency}} {{number_format($telco->product_price[$kk]/100,2)}}</option>
							@endfor
						</select>
					</div>
				</div>
			@endforeach
			
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width: 350px;">
	
			<div class="modal-content">
			    <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
				</div>	
				<div class="modal-body">
					<div id="myBody">
						<center>
							<p>Please, Enter Mobile Number to Top Up:</p>
							<input type="text" id="mobile_number" size="30" />
						</center>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success pull-right buy">Buy</button>
				</div>
				</form>

			</div>
		</div>
	</div>		
	<script>
		$(document).ready(function () {
			$(".telco_select").change(function () {
				$("#myModal").modal("show");
			});
		});
	</script>
@stop
