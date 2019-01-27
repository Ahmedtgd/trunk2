@extends("common.default")

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
            <div class="col-md-9 equal_to_sidebar_mrgn">
                <h3>Graphs:</h3>
                <div id="sales" class="row">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 margin-top">
                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                    <script>

                        $(document).ready(function () {
                            var today = new Date();
                            var yyyy = today.getFullYear();

                            var options = {
                                chart: {
                                    'renderTo': 'container'
                                },
                                title: {
                                    text: 'Monthly Sales Report',
                                    x: -20 //center
                                },
                                subtitle: {
                                    text: yyyy,
                                    x: -20
                                },
                                xAxis: {
                                    categories: []
                                },
                                yAxis: {
                                    title: {
                                        text: 'Sales'
                                    },
//                                            plotLines: [{
//                                                value: 0,
//                                                width: 1,
//                                                color: '#718DA3'
//                                            }]
                                },
                                tooltip: {
                                    valueSuffix: ''
                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle',
                                    borderWidth: 0
                                },
                                series: [{
                                    name: 'Sale',
                                    data: []
                                }]
                            };
                            $.getJSON('/admin/reports/getsale/'+yyyy, function (data) {
                                console.log(data);
                                options.xAxis.categories = data[0];
                                options.series[0].data = data[1];
                                var chart = new Highcharts.Chart(options);
                            });
                        })
                    </script>

                    <div class="col-sm-7">
                        {{--<div class="table-responsive">--}}
                        {{--<table class="table table-striped ">--}}
                        {{--<tr>--}}
                        {{--<th nowrap>Custom Date Range</th>--}}
                        {{--<th>From</th>--}}
                        {{--<th><input type="text" placeholder="yy/mm/dd" id="datetimepicker"--}}
                        {{--class="date form-control bg-sale"></th>--}}
                        {{--<th>To</th>--}}
                        {{--<th><input type="text" placeholder="yy/mm/dd" id="datetimepickerr"--}}
                        {{--class="date form-control bg-sale"></th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>Since</td>--}}
                        {{--<td>19August2015</td>--}}
                        {{--<td colspan="3">MYR 200,000.00</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>Year to Date</td>--}}
                        {{--<td></td>--}}
                        {{--<td colspan="3">MYR 140,000.00</td>--}}
                        {{--</tr>--}}

                        {{--</table>--}}


                        {{--</div>--}}

                        <div class="faqs col-sm-8 row">
                            <h4>Years</h4>
                            {{--*/$i=1/*--}}
                            @if(!empty($sale))
                                @foreach($sale as $y)
                                    <div class="faqs-head">
                                        <span class="col-xs-3">{{$y->year}}</span>
                                        <span class="col-xs-6">{{$currency}} {{number_format($y->revenu,2)}}</span>
                                        <span class="col-xs-3"> <a data-target="#faqs{{$i}}" data-toggle="collapse"
                                                                   class="btn btn-search pull-right collapsed"
                                                                   aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>

                                    </div>

                                    <div id="faqs{{$i}}" class="collapse in" style=""
                                         aria-expanded="{{$i==1 ? "true" : "false"}}">
                                        <table class="table">
                                            @foreach($y->month as $m)
                                                <tr>
                                                    <td>{{$m->month}}</td>
                                                    <td>{{$currency}} {{number_format($m->revenu,2)}}</td>
                                                </tr>

                                            @endforeach
                                        </table>
                                    </div>

                                    {{--*/ $i=$i+1; /*--}}
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4 col-sm-offset-1">

                        <div style="border:1px solid #718DA3">
                            <div class="col-xs-6">
                                <p>Max</p>
                                <p>Min</p>
                                <p>Average/Day</p>
                                <p>Average/Deal</p>
                                <p>Viewed</p>
                            </div>
                            <div class="col-xs-6 bg-sale">
                                @if(!empty($aggSale))
                                    @foreach($aggSale as $sale)
                                        <p>{{$currency}} {{number_format($sale->max,2)}}</p>
                                        <p>{{$currency}} {{number_format($sale->min,2)}}</p>
                                        <p>{{$currency}} {{number_format($sale->Average_day,2)}}</p>
                                        <p>{{$currency}} {{number_format($sale->Average_Deal,2)}}</p>
                                        <p>{{$view->views}}</p>
                                    @endforeach
                                @endif
                            </div>
                            <div class="clearfix"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
