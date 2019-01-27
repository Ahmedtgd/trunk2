@extends("common.default")

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
            <div class="col-md-9 equal_to_sidebar_mrgn">
                <h3>Active Buyers:</h3>
                <br><br>
                <div>
                    <table id="grid" class="table">
                        <thead>
                        <tr>
                            <th>Country</th>
                            <th>Day Head</th>
                            <th>Day</th>
                            <th>WTD Head</th>
                            <th>WTD</th>
                            <th>MTD Head</th>
                            <th>MTD</th>
                            <th>YTD Head</th>
                            <th>YTD</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($activeBuyer) && !empty($activeBuyer))
                            @foreach($activeBuyer as $m)
                                <tr>
                                    <td>{{$m->country}}</td>
                                    <td>{{$m->DAY_Head}}</td>
                                    <td>{{$m->DAYY}}</td>
                                    <td>{{$m->WTD_Head}}</td>
                                    <td>{{$m->WTD}}</td>
                                    <td>{{$m->MTD_Head}}</td>
                                    <td>{{$m->MTD}}</td>
                                    <td>{{$m->YTD_Head}}</td>
                                    <td>{{$m->YTD}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

{{--@section('scripts')--}}
    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--$("#grid").jqGrid(--}}
                    {{--{--}}
                        {{--url: '/admin/reports/data/activebuyer',--}}
                        {{--datatype: "json",--}}
                        {{--colNames: ['Country', 'Head', 'DAY$', 'Head', 'WTD$', 'Head', 'MTD$', 'Head', 'YTD$'],--}}
                        {{--colModel: [--}}
                            {{--{name: 'country', index: 'country', width: 55, align: "center"},--}}
                            {{--{name: 'DAY_Head', index: 'DAY_Head', width: 90, align: "center"},--}}
                            {{--{name: 'DAYY', index: 'DAYY', width: 100, align: "center"},--}}
                            {{--{name: 'WTD_Head', index: 'WTD_Head', width: 80, align: "center"},--}}
                            {{--{name: 'WTD', index: 'WTD', width: 80, align: "center"},--}}
                            {{--{name: 'MTD_Head', index: 'MTD_Head', width: 80, align: "center"},--}}
                            {{--{name: 'MTD', index: 'MTD', width: 150, sortable: false, align: "center"},--}}
                            {{--{name: 'YTD_Head', index: 'YTD_Head', width: 150, align: "center"},--}}
                            {{--{name: 'YTD', index: 'YTD', width: 150, align: "center"}--}}
                        {{--],--}}
                        {{--rowNum: 10,--}}
                        {{--rowList: [10, 20, 30],--}}
                        {{--pager: '#pager',--}}
                        {{--sortname: 'country',--}}
                        {{--viewrecords: true,--}}
                        {{--sortorder: "desc",--}}
                        {{--//caption:"Merchants"--}}
                    {{--}--}}
            {{--);--}}
            {{--$("#grid").jqGrid('navGrid', '#pager2', {edit: false, add: false, del: false});--}}
        {{--});--}}
    {{--</script>--}}
{{--@endsection--}}