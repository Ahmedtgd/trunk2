<table id="raw-datatable" class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <td class="text-center bg-primaryii">No</td>
            <td class="text-center bg-primaryii">Sub Category/Menu</td>
            <td class="text-center bg-primaryii">Product</td>
        </tr>
    </thead>
    <tbody id="new-terminal">
    <?php $index = 0;?>
    @if(count($subcatdata) > 0)
        @foreach($subcatdata as $data)
        <tr>
            <td class="text-center" style="vertical-align: middle">{{++$index}}</td>
            <td class="text-left">{{$data->name}}</td>                 
            <td class="text-center">
                <a target="_blank" href="/branch/product/{{$location_id}}/{{ $data->level1_id }}">{{$data->productcount}}</a>
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#raw-datatable').DataTable();
    });
</script>
