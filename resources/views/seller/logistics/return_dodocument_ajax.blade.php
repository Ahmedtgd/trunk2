<table class="table table-bordered" id="dodocumentrender" >
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
    @foreach($doissued as $doissued)
    {{--*/ 

        $created_at = new Carbon\Carbon($doissued->created_at); 
        $carbon = new Carbon();
        $index = 0;

    /*--}}
    <tr>
        <td style="text-align: center;">{{$count}}</td>
        
        @if($doissued->source == "imported")
            <td style="text-align: center;">{{$doissued->nid}}</td>
        @else
           <!--  <td style="text-align: center;"><a target="blank" href="{{route("displaysalesorderdocument",$doissued->p_id)}}">{{$doissued->nid}}</a></td> -->
            <td style="text-align: center;"><a target="blank" href="{{route("displaydeliveryorderdocument",$doissued->p_id)}}">{{$doissued->nid}}</a></td>
        @endif
        <td style="text-align: center;">{{strtoupper($doissued->source)}}</td>
        <td style="text-align: center;">
        {{date('dMy H:i:s', strtotime($doissued->created_at))}}
		</td>
		<?php
		switch ($doissued->status) {
			case 'converted_tr':
				$status = 'Attached TR';
				break;
			case 'inprogress':
				$status = 'In Progress';
				break;
			default:
				$status = ucfirst($doissued->status);
		}
		?>
        <td style="text-align: center;">{{$status}}</td>

        

        
        
        
    </tr>
    <?php  $count++; ?>
    @endforeach
    </tbody>

</table>
<script type="text/javascript">
     $('#dodocumentrender').DataTable({
                "order": [],
                
            }); 
</script>
