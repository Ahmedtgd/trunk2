<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
?>
@extends("common.default")

@section("content")

    <?php $i=1; ?>
@section("content")
    <style>
        #sranalysis th{


        }
    </style>
    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')
        <h2>Station Recruiter Analysis</h2>
        <div class="table-responsive">
            <table class="table table-bordered" cellspacing="0" width="1300px" id="sranalysis">
                <thead style="background-color: #FF4C4C; color: white;">
                <tr>
                    <th style="" class="no-sort text-center bsmall">No</th>
                    <th style="" class="text-center medium">SR&nbsp;ID</th>
                    <th style="" class="text-center blarge">Name</th>
                    <th style="" class="text-center blarge">Status</th>
                    <th style="" class="text-center blarge">Since</th>
                    <th style="" class="text-center blarge">Sales Since</th>
                    <th style="" class="text-center blarge">Sales YTD</th>
                    <th style="" class="text-center blarge">Revenue</th>
                    <th style="" class="text-center blarge">Revenue YTD</th>
                    <th style="" class="text-center blarge">Earned Since</th>
                    <th style="" class="text-center blarge">Earned YTD</th>
                    <th style="background: #800000;color:#fff" class="text-center blarge" >Station</th>
                    <th style="background: #000000;color: #fff;"  class="text-center blarge" >Outstanding</th>
                    <th style="background: #FE0001;color: #fff;"  class="text-center blarge">Country</th>
                </tr>
                </thead>
                @if(isset($ssa) and !is_null($ssa))
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @def $i = 1; $x = 0;
                    @foreach($ssa as $ss)
                        <tr>
                            <td class=''>{!! $i++ !!}</td>
                            <td class=''>{{'['.sprintf('%010d', $ss->sr_id).']'}}</td>
                            <td  class=''>{{$ss->name }}</td>
                            <td class=''>{{$ss->status}}</td>
                            <td>{{$ss->active_date}}</td>
                            <td class=''>{{$currency->code." ".number_format($ss->receivable / 100 , 2)}}</td>
                            <td>{{$currency->code." ".number_format($ss->sales_ytd / 100 , 2)}}</td>
                            <td>{{$currency->code." ".number_format($ss->receivable / 100 , 2)}}</td>
                            <td>{{$currency->code." ".number_format(0)}}</td>
                            <td>{{$currency->code." ".number_format($ss->earn_since / 100 , 2)}}</td>
                            <td>{{$currency->code." ".number_format($ss->earn_ytd / 100 , 2)}}</td>
                            <td>{{$ss->station_name}}</td>
                            <td class=''>{{$currency->code." ".number_format(($ss->outstanding) / 100 , 2)}}</td>
                            <td>{{$ss->country}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
           var table = $('#sranalysis').DataTable({
                "scrollX": true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            });
            $('table th:first').removeClass('sorting_asc');
        });

    </script>
@stop

