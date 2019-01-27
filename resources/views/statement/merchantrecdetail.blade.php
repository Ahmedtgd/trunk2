@extends("common.default")
@section("content")
    <style>
        .statement{
            background: #e6e6e6;
            width: 60%;
            padding: 10px;
            margin: 0 auto;
            border: 2px solid #e6e6e6;
            border-radius: 25px;
        }
        .ym{background: #c6c6c6;width: 100%;margin: 0 auto;padding: 5px;border-radius: 25px;}
        button{font-family: sans-serif;border: none;width: 45px;}
        .btn-enable{background: lightblue;}
        .btn-disable{background: #4d4d4d;color:white;}

    </style>
    <div class="container" style="margin-top: 30px;margin-bottom: 30px;">
        <div class="statement" id="statement1"style="">
            <h2 style="font-family: sans-serif">Receipts</h2>
            <span>{{$name or ''}}</span><br>
            {{$merchant->company_name or ''}}<br>
            {{ $s->line1 or '' }}<br>
            {{ $s->line2 or '' }}<br>
            <?php
                if (!isset($id)) {
                    # code...
                    $id=1;
                }
            ?>
            {{ $s->line3 or '' }}<span id="did" style="float: right;">{{$mer or ''}} {{ $id }}</span><br>
            {{ $s->line4  or '' }}<br>
            <div class="ym">
                {{--*/ $y = 1; $index = 0;/*--}}
				<?php
						if (!isset($receipts)) {
						# code...
						$receipts=array();
					}
				?>

                <?php if((is_null($myreturn)) || ($current_year == 0)){ $carbon = new Carbon();?>
                    <div style="margin: 5px;">
						<span style="font-family:sans-serif;font-size:large;">
							{{date('Y')}}{{':'}}</span>
                            @for($i = 0,$carbon->month = 1; $i < 12;
									$i++,$carbon->addMonth())
							<button class="btn-disable btn btn-sm primary-btn"
								disabled>
								{{$carbon->format('M')}}
							</button>
                            @endfor
                    </div>
                <?php } ?>
                @foreach($receipts as $recp)
                    {{--*/ $created_at = new Carbon\Carbon($recp->created_at); $carbon = new Carbon();
                    $m = $years[$created_at->year]; sort($m);$month = $m[0]; $index = 0;/*--}}
                    @if($y != $created_at->year)
                        <div style="margin: 5px;">
                            <span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
                            @for($i = 0,$carbon->month = 1; $i < 12; $i++,$carbon->addMonth())
                                @if($carbon->month === $month )
                                    <button class="btn-enable btn btn-sm primary-btn"
                                            onclick="statement({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
                                        {{$carbon->format('M')}}
                                    </button>
                                    {{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
                                @else
                                    <button class="btn-disable btn btn-sm primary-btn" disabled>
                                        {{$carbon->format('M')}}
                                    </button>
                                @endif
                            @endfor
                        </div>
                    @endif
                    {{--*/ $y = $created_at->year; /*--}}
                @endforeach
            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="myModalLabel1">Merchant Statement</h2>
                    </div>
                    <div class="modal-body" id="modalbody" style="background:#F2F2F2;">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="stModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="width:96%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="myModalLabel2">Receipts</h2>
                    </div>
                    <div class="modal-body" id="stmodalbody">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{url('js/jquery.dataTables.min.js')}}"></script>
    <script>

        function statement(id,year,month) {
            //get the merchant data from the backend and render on the modal
            console.log(month);
            jQuery.ajax({
                type: "POST",
                url: "{{ url('statement/recdetail')}}",
                data: { id:id,year:year,month:month },
                beforeSend: function(){},
                success: function(response){
                    $('#stmodalbody').html(response);
                    //    $('#myModal').removeClass("fade").modal('toggle');
                    $('#stModal').modal('toggle');

                }
            });
        }
    </script>
@stop
