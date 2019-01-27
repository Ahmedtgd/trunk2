<h3>Branch</h3>
<table class="table table-bordered" id="branchtable" style="width:100% !important">
	<thead style="background: #6666ff; color: white;width: 100% !important;">
	<tr>
		<td class='text-center no-sort'>No</td>
		<td class='text-center'>Branch</td>
		<td class='text-center '>Staff</td>
		<td class='text-center '>Product</td>
		{{-- <td class='text-center '>Location</td> --}}
		<td class='text-center '>Report</td>
		<td class='text-center ' style="background-color: #02d4f9;">Terminal </td>
		<td class='text-center ' style="background-color: #02d4f9;">Sales</td>
	</tr>
	</thead>
	<tbody id="branchtbody">
	<tr>
		<td style="text-align:center;">
			<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
		</td>
	</tr>

	</tbody>
</table>
<script type="text/javascript">
	//var branchtable=$("#branchtable").DataTable({});
	function populate_branch_table() {
		url="{{url('branch/list',$selluser->id)}}";
		url2="{{url()}}"
		uid="{{$selluser->id}}";
		$.ajax({
			url:url,
			type:"GET",
			success:function(r){
				if (r.status=="success") {
					data=r.data
					var tmp="";
					for (var i =0;i<data.length; i++) {
						d=data[i];
						x=i+1;
						tmp+=`
							<tr>
							<td class='text-center'>`+x+`</td>
							<td class='text-center'>`+d.branch_name+`</td>
							<td class='text-center'>
							<a class="show_staffs" rel-branch="`+d.id+`">
								`+d.staffcount+`
								</a>
							</td>
							<td class='text-center'>
								<a class="show_products" rel-branch="`+d.id+`">
								`+d.productcount+`
								</a>

							</td>
							
							<td class='text-center'>
							<a href="javascript:void(0)" rel="`+d.id+`" id="`+d.id+`" class="getstockid"
							>`+d.count+`</a>
							</td>
							<td class="text-center">
								<a href="${url2}/open-terminal/`+d.id+`/${uid}" target="_blank">
									  `+d.terminalcount+`
								</a>
							</td>
							<td class="text-right">
								<a href="${url2}/open-sales/user/${uid}" target="_blank">`+(d.salecount/100).toFixed(2)+`</a>
							</td>
`;
					}
					$("#branchtbody").text("");
					$("#branchtbody").append(tmp);
					$("#branchtable").DataTable({});
				}
			}
		})
	}
	$(document).ready(function(){
		populate_branch_table();
	})
</script>
