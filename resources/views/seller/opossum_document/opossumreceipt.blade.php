
<br><br>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title" id="myModalLabel2">OPOSsum Receipt</h2>
</div>
<table style="width: 100%; " id="oposumreceipttable" class="table ">
    <thead class="bg-inventory">
    <tr >
        <th class="text-center" scope="col">No</th>
        <th class="text-center" scope="col">Receipt No</th>
        <th class="text-center" scope="col">Date</th>
    </tr>
    </thead>
    <tbody>
    <?php $index =0; ?>
    @foreach($receipts as $receipts)
        <tr style="padding: 8px 18px;">
            <th class="text-center">{{++$index}}</th>
            <td class="text-center"><a target="_blank" href="{{URL('showreceiptproduct',$receipts->id)}}" >
                    {{sprintf('%06d',$receipts->receipt_id)}}</a></td>
            <td class="text-center">{{date('dMy H:i', strtotime($receipts->created_at))}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $('#oporeceipttable').DataTable({
        "order": [],

    });



</script>
