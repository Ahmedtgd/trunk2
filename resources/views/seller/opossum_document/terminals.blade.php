
<br><br>

<table style="width: 100%; " id="oposumterminaltable" class="table ">
    <thead class="bg-inventory">
    <tr >
        <th class="text-center" scope="col">No</th>
        <th class="text-center" scope="col">Branch</th>
        <th class="text-center" scope="col">Terminal ID</th>
    </tr>
    </thead>
    <tbody>
    <?php $index =0; ?>
    @foreach($terminals as $terminals)
        <tr style="padding: 8px 18px;">
            <th class="text-center">{{++$index}}</th>
            <td class="text-center">{{$terminals[0]->code}}</td>
            <td class="text-center"><a onclick="showoposumreceipt({{$terminals[0]->id}})" href="javascript:void(0)" >
                {{sprintf('%06d',$terminals[0]->id)}}</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $('#oposumterminaltable').DataTable({
        "order": [],

    });

      function showoposumreceipt(terminal_id) {
       var url ='{{URL()}}'+'/showreceipt'+'/{{$fromDate}}'+'/{{$toDate}}/'+terminal_id;
        $.ajax({
            type: "GET",
            url: url,
            success: function(response){


                $('#receiptsmodal').modal('toggle');
                $('#invoice-container').html(response);
            }
        });

    }

</script>
