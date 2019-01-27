<div class="col-md-12">
	<div class="row masonry-megamenu" style="display: none">
		@foreach($allCategories as $cat)
			<div class="col-xs-3">
		        <h4><a href="{{URL::to('floor',array($cat['floor']))}}" target="_blank" style="color: black;">{{$cat['description']}}</a></h4>
		        <ul class="nav nav-submenu">
		            @foreach($allsubCategories as $subCat)
		                @if($subCat['id'] == $cat['id'])
		                    <li><a href="{{URL::to('sub-cat-details',array($cat['id'], $subCat['subid'],false))}}" target="_blank">{{$subCat['subdescription']}}</a></li>
		                @endif
		            @endforeach
		        </ul>
		   </div>
		@endforeach	
	</div>
</div>

