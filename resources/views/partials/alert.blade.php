@if(Session::has('error_msg'))
    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
@elseif(Session::has('success_msg'))
    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
@endif