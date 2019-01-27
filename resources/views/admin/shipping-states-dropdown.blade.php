<option value="none">--select--</option>
@foreach($states as $state)
    <option value="{{ $state['code'] }}">{{ $state['name'] }}</option>
@endforeach