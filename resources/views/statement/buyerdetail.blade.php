<?php use App\Http\Controllers\UtilityController;

$total=0;
$c=1;
?>
<h3>{{$month}} {{$year}}</h3>
<table id="stmntdt" cellspacing="0" class="table table-striped" width="100%">
    <thead>
    
    <tr class="bg-black">
        <th>No.</th>
        <th class="text-center" style="width: 120px !important;">Date</th>
        <th class="text-center" style="width: 120px !important;">Amount ($currentCurrency)</th>     
    </tr>
    </thead>

    <tbody>

        @if(isset($product_orders))
            @foreach($product_orders as $p)
                <tr>
                    <td>{{$c}}</td>

                    <td style="text-align: center;">
                        @if(isset($p['o_exec']))
                            {{UtilityController::s_date($p['o_exec'])}}
                        @endif

                    </td>
                
                    <td style="text-align: right;">
                        <a href="{{route('Receipt', ['id' => $p['oid']])}}"
                            class="uniqporder" id="uniqporder_{{$p['oid']}}" data="{{$p['oid']}}"
                            target="_blank">{{$currentCurrency}}&nbsp;{{number_format($p['total']/100,2)}}</a></td>
                   
            
                    
                </tr>
              <?php $total+=$p['total'];
                    $c+=1;
              ?>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
        <th colspan="3" style="text-align: right;">
            Total&nbsp;{{$currentCurrency}}&nbsp;{{number_format($total/100,2)}}</th>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
  $(document).ready(function(){
    var id="#myModalLabel2";
    $(id).text('Receipt');
    $('#stmntdt').DataTable({
                                 "order": [],
                                 fixedHeader: {
                                 
                                    footer: true
                                },
                                                     /*     "scrollX":true,*/
                               
                            });
  });
</script>


