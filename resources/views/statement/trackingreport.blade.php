<?php use App\Http\Controllers\UtilityController;

$total=0;
$c=1;
?>
<h3>{{$month}} {{$year}}</h3>
<table id="trdt" cellspacing="0" class="table table-striped" width="100%">
    <thead> 
    
    <tr style="background-color: #799240; color: white;">
        <th class="text-center">Date</th>
        <th class="text-center">Report ID</th>
        <th class="text-center">Recipient</th>     
    </tr>
    </thead>

    <tbody>

        @if(isset($reports))
            @foreach($reports as $p)
                <tr>
                    <td class="text-center">
                        @if(isset($p->created_at))
                            {{UtilityController::s_date($p->created_at,true)}}
                        @endif
                    </td>

                    <td class="text-center" style="background-color: yellow;"><a href="{{route('Stockreport', ['id' => $p->id])}}"
                            class="uniqporder" id="uniqreport_{{$p->id}}" data="{{$p->id}}"
                            target="_blank">{{UtilityController::nsid($p->id,10,"0")}}</a></td>
                
                    <td style="text-align: center;">{{$p->first_name or ''}} {{$p->last_name or ''}} </td>
                    
                </tr>
              <?php 
                    $c+=1;
              ?>
            @endforeach
        @endif
    </tbody>
</table>

<script type="text/javascript">
  $(document).ready(function(){
    var id="#trModalLabel2";
    $(id).text('Tracking Report List');
    $('#trdt').DataTable({
		 "order": [],
		 fixedHeader: {
			footer: true
		},
		/* "scrollX":true,*/
		});
  });
</script>


