@if(Session::has($key))
  {!!Session::get($key)!!}
@endif