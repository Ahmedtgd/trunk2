<label for="fullName">Full Name</label>
<input type="" name="full_name" id="fullName" class="form-control" @if(!is_null($name)) value="{{$name}}" disabled @else required @endif>
<label for="email">Email</label>
<input type="email" name="email" id="email" class="form-control" @if(!is_null($email)) value="{{$email}}" disabled @else required @endif>
<label for="phone">Contact</label>
<input type="tel" name="phone" id="phone" class="form-control" required>

{{$name}}