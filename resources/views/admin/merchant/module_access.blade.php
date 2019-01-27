@extends('common.default')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h2>{{$merchant->company_name}}</h2>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<h3>Disable and Hide Management</h3>
		</div>
	</div>
	
		
	@foreach($modules as $m)
		<div class="row">
			
				@if($m->id== $m->parent_id || empty($m->parent_id))
				
				<div class="col-sm-12">	
					<label for="accessrole_{{$m->id}}"
					style="font-size:20px;" 
					>
						<input type="checkbox" name="" class="accessrole"
						ma_id="{{$m->id}}"
						id="accessrole_{{$m->id}}" 
						@if(!empty($m->moduleaccess_id))
						checked="checked"
						@endif 
						>
						{{$m->description}}
					</label>
					
				</div>
					@foreach($modules as $j)
						@if($j->parent_id==$m->id && $j->parent_id!=$j->id)
							<div class="col-sm-12">
							<label for="accessrole_{{$j->id}}"
							
							>
								<input type="checkbox" name="" class="accessrole parent_{{$m->id}}"
								ma_id="{{$j->id}}"
								id="accessrole_{{$j->id}}" 
								@if(!empty($j->moduleaccess_id))
								checked="checked"
								@endif 
								>
								{{$j->description}}
							</label>
								
							</div>
						@endif
					@endforeach
				@endif
			
		</div>
	@endforeach
		
	</div>
	<div class="row">
		<div class="col-sm-11">
			<button type="button" class="btn btn-default bg-confirm btn-standard pull-right"
	
			onclick="save()" 
			>Save</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	var modules=[]
	function save() {
		if (modules.length<1) {
			toastr.warning("Nothing to update")
			return;
		}
		url="{{url('admin/merchant/module/access/update')}}"
		type="POST"

		merchant_id="{{$merchant->id}}";

		data={merchant_id,modules}

		success=function(r){
			/*location.reload()*/
			toastr.success("Module Access Updated")

		}

		console.log({data})
		$.ajax({url,type,data,success})


	}
	$(document).ready(function(){
		$(".accessrole").change(function(){
			temp={}
			ma_id=$(this).attr('ma_id')
			temp['ma_id']=ma_id;
			if($(this). prop("checked") == true){
				temp['status']=1
				//$(".parent_"+ma_id).prop('checked',true)
			}else{
				temp['status']=0
				//$(".parent_"+ma_id).prop('checked',false)
			}

			modules.push(temp)

			
			//$(".parent_"+ma_id).change()

		
		})
	})
</script>
@stop