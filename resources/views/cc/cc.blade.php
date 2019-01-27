<?php 
echo "<pre>";
 var_dump($data);
echo "</pre>";
?>
<form action="{{action('TestController@test_cc_payment')}}" method="post">
	<table>
		<tr>
			<td>Card Number</td>
			<td> <input type="text" name="card_number" /></td>
		</tr>
		<tr>
			<td>expiry Date</td>
			<td>
				<select name="expiry_year">
					<?php for($i = date('Y', time()); $i < 2030; $i++)	{
						?>
						<option value="{{$i}}">{{$i}}</option>
						<?php
					}
					?>
				</select>
				<select name="expiry_month">
					<?php for($i = 1; $i <= 12; $i++)	{
						?>
						<option value="{{$i}}">{{$i}}</option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>CSV no.</td>
			<td> <input type="text" name="csv" /></td>
		</tr>
		<tr>
			<td colspan="2"> <input type="submit" name="submit" value="Submit"></td>
		</tr>
	</table>
</form>
