<!DOCTYPE html>
<html>
<head>
	<title>Add Ocredit</title>
</head>
<body>
<select id="user_id">
	@foreach($users as $u)
	<option value="{{$u->id}}">{{$u->email}}</option>
</select>
<label> Add amount</label>
<input type="text" name="amount" id="amount">
<button id="confirm">Confirm</button>
</body>
</html>