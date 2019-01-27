<div class="col-md-12">
	<div class="row masonry-megamenu">
		<?php $io = 0; ?>
		@foreach($category as $cat)
			<?php $io++; ?>
			<div class="col-xs-3">
			    <h4>{{ $cat->cat_name }}</h4>
			    <?php
			        $sub_cat = explode(';',$cat->sub_cat); 
			        $sub_id = explode(';',$cat->sub_id);
					sort($sub_cat);
			    ?>
			    
			    <ul class="nav nav-submenu">
			        @for ($i = 0; $i <  count($sub_cat); $i++)
			             <li><a href="{{ route('owarehouse', [$sub_id[$i]]) }}" target="_blank">{{ $sub_cat[$i] }}</a></li>
			        @endfor
			    </ul>
			</div>
		@endforeach
		@if($io == 0)
			<div class="col-xs-3">
			<h4>No Hyper products found</h4>
			</div>
		@endif
	</div>
</div>
