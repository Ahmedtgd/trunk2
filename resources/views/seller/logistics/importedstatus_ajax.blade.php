<table style="width: 100%;" class="table table-bordered" id="table-sr" >
    <thead class="aproducts">

        <tr class="bg-logistics">
            <th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
            <th class="text-center">Date</th>
            <th class="text-center">Report No</th>
            <th class="text-center">Recipient</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php  $count=1; ?>
        @foreach($delivery_order_stock_report as $sr)
        {{--*/ $created_at = new Carbon\Carbon($sr->created_at); /*--}}


        <tr>
            <td style="text-align: center;">{{$count}}</td>
            <td style="text-align: center;">{{$created_at->day}}{{$created_at->format('M')}}{{$created_at->format('y')}} </td>
            <td style="text-align: center;">
                <a href="{{route('Stockreport', ['id' => $sr->id])}}"
                    class="uniqporder" id="uniqreport_{{$sr->id}}" data="{{$sr->id}}"
                    target="_blank">
                    {{str_pad($sr->report_no,10,'0',STR_PAD_LEFT)}}
                </a>
                </td>
                    <td style="text-align: center;">{{$sr->name}}</td>
            <td style="text-align: center;">{{ucfirst($sr->status)}}</td>


                </tr>
                <?php  $count++; ?>
                @endforeach
            </tbody>

        </table>
        <script type="text/javascript">
           $('#table-sr').DataTable({
            "order": [],

        }); 
    </script>
