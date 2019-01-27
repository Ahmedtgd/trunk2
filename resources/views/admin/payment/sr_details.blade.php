<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
?>
@extends("common.default")
@section("content")
    <?php $i=1; ?>
@section("content")
    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')
        <h2>Merchant Professional Detail</h2>
        <div class="table-responsive">
            <table class="table table-bordered" cellspacing="0" width="1300px" id="srdetails">
                <thead style="background-color: #1B767C; color: white;">
                <tr>
                    <th style="background-color:#1B767C;color:#fff" colspan="4">Station Recruiter ID: [{!! str_pad($sr_id, 10, '0', STR_PAD_LEFT) !!}]</th>
                    <th colspan="1" style="background-color:#000000;color:#fff" rowspan="2">Outstanding {{$currentCurrency}}</th></tr>
                <tr>
                    <th class="no-sort text-center bsmall">Station</th>
                    <th class="text-center medium">Order&nbsp;ID</th>
                    <th class="text-center blarge">Revenue</th>
                    <th class="text-center blarge" >Rate</th>
                </tr>
                </thead>
                @if(isset($sr_details) and !is_null($sr_details))

                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @def $i = 0
                    @foreach($sr_details as $srd)
                        <?php $srd->currency_code = $currency->code; ?>

                        <tr>
                            <td class='text-center'>{{'['.sprintf('%010d', $srd->station_id).']'}}</td>
                            <td  class='text-center'>{{'['.sprintf('%010d', $srd->porder_id).']' }}</td>
                            <td  class='text-center'>{{$srd->currency_code." ".number_format($srd->receivable / 100 , 2)}}</td>
                            <td class='text-center'>{{$srd->currency_code." ".number_format($srd->ss_commission , 2)}}</td>
                            <td class='com text-center'>{{$srd->currency_code ." ".  number_format($srd->outstanding /100 , 2)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    <script type="text/javascript">
       $(document).ready(function() {
            var table = $('#srdetails').DataTable({
                "scrollX": true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            });
            $('table th:first').removeClass('sorting_asc');
        });

    </script>
    @yield('left_sidebar_scripts')
@stop

