<table class="table table-borderd">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Price</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
	
		<tr>
			<td>{{$product->id}}</td>
			<td>{{$product->name}}</td>
			<td>{{$product->retail_price}}</td>
			<td>{{$product->description}}</td>
		</tr>
		
	</tbody>
</table>
