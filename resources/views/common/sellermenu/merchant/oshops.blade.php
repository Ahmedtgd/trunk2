<li class="dropdown">
	<a href="#" class="dropdown-toggle"
	style="margin-left:0;padding-left:10px;padding-right:10px"
	   data-toggle="dropdown" role="button"
	   aria-haspopup="true" aria-expanded="false">
		O-Shop<span class="caret"></span></a>

	<ul class="dropdown-menu">
		@foreach($oshops as $oshop)
			<li class="{{$cf->set_active('/o/' .$oshop->url)}}">
				<a href="{{route('oshop.one',['url'=>$oshop->url])}}" target="_blank">
					{{$oshop->oshop_name}}</a>
			</li>
		@endforeach
	</ul>
</li>