<table class="table table-bordered" id="doreceiveddocumentrender" >
    <thead class="aproducts">

    <tr style="background-color:#6d9270; color: #FFF;">
        <th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
        <th class="text-center">DO ID</th>
        <th class="text-center">Source</th>
        <th class="text-center">Date</th>
        <th class="text-center">Status</th>
    </tr>
    </thead>
    <tbody>
<?php  $count=1; ?>
    @foreach($doreceived as $doreceived)
    {{--*/ 

        $created_at = new Carbon\Carbon($doreceived->created_at); 
        $carbon = new Carbon();
        $index = 0;

    /*--}}
    <tr>
        <td style="text-align: center;">{{$count}}</td>
        
        @if($doreceived->source == "imported")
            <td style="text-align: center;">{{$doreceived->nid}}</td>
        @else
           <!--  <td style="text-align: center;"><a target="blank" href="{{route("displaysalesorderdocument",$doreceived->p_id)}}">{{$doreceived->nid}}</a></td> -->
            <td style="text-align: center;"><a target="blank" href="{{route("displaydeliveryorderdocument",$doreceived->p_id)}}">{{$doreceived->nid}}</a></td>
        @endif
        <td style="text-align: center;">{{strtoupper($doreceived->source)}}</td>
        <td style="text-align: center;">
		<?php
		$t = strtotime($created_at);
		$dt = date('dMy H:i', $t);
		?>
		{{$dt}}
		</td>
		<?php
		switch ($doreceived->status) {
			case 'converted_tr':
				$status = 'Attached TR';
				break;
			case 'inprogress':
				$status = 'In Progress';
				break;
			default:
				$status = ucfirst($doreceived->status);
		}
		?>
        <td style="text-align: center;">{{$status}}</td>
    </tr>
    <?php  $count++; ?>
    @endforeach
    </tbody>

</table>
<script type="text/javascript">
     $('#doreceiveddocumentrender').DataTable({
                "order": [],
            }); 
</script>
