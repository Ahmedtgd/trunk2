@foreach($allCategories as $cat)
	<h4 style="color:  #73D2C6 !important;" id="mobilecat{{$cat['id']}}" rel="{{$cat['id']}}"><a style="color: #73D2C6 !important;" href="{{URL::to('floor',array($cat['floor']))}}">{{$cat['description']}}</a><span class="pull-right mobilecat" onclick="" rel="{{$cat['id']}}" id="mobilecatplus{{$cat['id']}}"><img src="{{asset('images/category/mobileplus.png')}}" width="20px"/></span></h4>
	<div class="mobilecat-submenu" style="display: none;" id="mobilesubcatmenu{{$cat['id']}}">
		@foreach($allsubCategories as $subCat)
			@if($subCat['id'] == $cat['id'])
				<h4 style="color: #73D2C6 !important; margin-left: 10px;"><a style="color: #73D2C6 !important;" href="{{URL::to('sub-cat-details',array($cat['id'], $subCat['subid'],false))}}">{{$subCat['subdescription']}}</a></h5>
			@endif
		@endforeach
	</div>
@endforeach	


