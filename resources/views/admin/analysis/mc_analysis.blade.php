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
        <h2>Merchant Consultant Analysis</h2>
        <div class="table-responsive">
            <table class="table table-bordered" cellspacing="0" width="1300px" id="gridmerchant">
                <thead style="background-color: #FF4C4C; color: white;">
                <tr>
                    <th style="background-color:#4553ED;color:#fff" class="no-sort text-center bsmall">No</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center medium">MC&nbsp;ID</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Name</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Status</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Since</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Sales&nbsp;Since</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Sales&nbsp;YTD</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Revenue</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Revenue&nbsp;YTD</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Earned&nbsp;Since</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center blarge">Earned&nbsp;YTD</th>
                    <th style="background-color:#F7AFB6;color:#fff" class="text-center blarge" >Merchant</th>
                    <th style="background-color:#5D4A77;color:#fff" class="text-center blarge">MP</th>
                    <th style="background-color:#000;color:#fff"  class="text-center blarge" >Outstanding</th>
                    <th style="background-color:#ED4454;color:#fff"  class="text-center blarge">Country</th>
                </tr>
                </thead>
                @if(isset($mc_analysis) and !is_null($mc_analysis))
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
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @def $i = 1
                    @foreach($mc_analysis as $key => $mca)
                        <tr>
                            <td class='text-center'>{!! $i++ !!}</td>
                            <td class='text-center'>
                                <a class="update" data-val="">
                                    {!! $mca->mc_id !!}
                                </a>
                            </td>

                            <td  class='text-center'>
                                {!! $mca->name !!}
                            </td>

                            <td class='com text-center'>
                                {!! $mca->status !!}
                            </td>

                            <td>
                                {!! $mca->since !!}
                            </td>

                            <td>
                                {!! $mca->sales_since !!}
                            </td>

                            <td>
                                {!! $mca->sales_ytd !!}
                            </td>

                            <td>
                                {!! $mca->revenue_since !!}
                            </td>

                            <td>
                                {!! $mca->revenue_ytd !!}
                            </td>

                            <td>
                                {!! $mca->earn_since !!}
                            </td>

                            <td>
                                {!! $mca->earn_ytd !!}
                            </td>

                            <td>
                                {!! $mca->merchant !!}
                            </td>

                            <td>
                                {!! $mca->mp !!}
                            </td>

                            <td>
                                {!! $mca->outstanding !!}
                            </td>

                            <td>
                                {!! $mca->country !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#gridmerchant').DataTable({
                "scrollX": true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            });
        })
    </script>
@stop
