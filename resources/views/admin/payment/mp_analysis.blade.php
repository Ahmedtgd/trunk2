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
        <h2>Merchant Professional Analysis</h2>
        <div class="table-responsive">
            <table class="table table-bordered" cellspacing="0" width="1300px" id="gridmerchant">
                <thead style="background-color: #FF4C4C; color: white;">
                <tr>
                    <th style="background-color:#4553ED;color:#fff" class="no-sort text-center bsmall">No</th>
                    <th style="background-color:#4553ED;color:#fff" class="text-center medium">MP&nbsp;ID</th>
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
                    <th style="background-color:#000;color:#fff"  class="text-center blarge" >Outstanding</th>
                    <th style="background-color:#ED4454;color:#fff"  class="text-center blarge">Country</th>


                </tr>
                </thead>
                @if(isset($mcp) && is_array($mcp) && count($mcp))
                    <tfoot>
                    <tr>
                    </tr>
                    </tfoot>
                    <tbody>
                    @def $i = 1
                    @foreach($mcp as $key => $mp)
                        <tr>
                            <td class='text-center'>{!! $i++ !!}</td>
                            <td class='text-center'>
                                <a href="javascript:void(0)" class="view-user-modal" data-id="{{ $mp->user_id }}"> [{!! str_pad($mp->user_id, 10, '0', STR_PAD_LEFT) !!}] </a>
                            </td>
                            <td  class='text-center'>
                                {{$mp->name}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->status}}
                            </td>

                            <td class='com text-center'>
                                {{$mp->since}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->sales_since}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->sales_ytd}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->revenue}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->revenue_ytd}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->earn_since}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->earn_ytd}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->merchant}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->outstanding}}
                            </td>
                            <td class='com text-center'>
                                {{$mp->country}}
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

