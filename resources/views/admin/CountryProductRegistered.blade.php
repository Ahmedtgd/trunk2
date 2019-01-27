@extends("common.default")

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
            <div class="col-md-9 equal_to_sidebar_mrgn">
                <h2>Product Registered:</h2>

                <div>
                    <table id="grid" class="table">
                        <thead>
                        <tr>
                            <th>Country</th>
                            <th>Day</th>
                            <th>WTD</th>
                            <th>MTD</th>
                            <th>YTD</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($productRegistered) && !empty($productRegistered))
                            @foreach($productRegistered as $m)
                                <tr>
                                    <td>{{$m->country}}</td>
                                    <td>{{$m->DAYY}}</td>
                                    <td>{{$m->WTD}}</td>
                                    <td>{{$m->MTD}}</td>
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
                        {{--url: '/admin/reports/data/productregistered',--}}
                        {{--datatype: "json",--}}
                        {{--colNames: ['Country', 'DAY', 'WTD', 'MTD', 'YTD'],--}}
                        {{--colModel: [--}}
                            {{--{name: 'country', index: 'country', width: 55, align: "center"},--}}
                            {{--{name: 'DAYY', index: 'DAYY', width: 100, align: "center"},--}}
                            {{--{name: 'WTD', index: 'WTD', width: 80, align: "center"},--}}
                            {{--{name: 'MTD', index: 'MTD', width: 150, sortable: false, align: "center"},--}}
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