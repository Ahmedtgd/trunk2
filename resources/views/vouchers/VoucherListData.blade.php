@extends("common.default")
@section("content")
@include('common.sellermenu')
<style type="text/css">
    .voucher_list {
        background:#2a75ed;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field{
        display: none !important;
    }
    .voucher_list {
        background:#2a75ed;
    }
    label{
        display: inline-flex !important;

    }
    .select2-container{
        margin: 0px 5px !important;}

</style>
<div class="container" style="margin-top:30px;">
    <div class="table-responsive" style="margin-bottom: 28px;">
        <h2>Voucher List
        </h2><table class="table table-bordered" cellspacing="0"
        id="Voucher_lists" style="width:100% !important;">
            <thead style="color:white">
                <tr style="">
                    <td class="text-center bsmall no-sort voucher_list"
                    style="">No.</td>
                    <td style="color:white" class="text-center voucher_list"
                    >Voucher ID</td>
                    <td style="color:white" class="text-center voucher_list"
                    >Buyer ID</td>
                    <td class="text-center voucher_list"
                    >Issued</td>
                    <td class="text-center voucher_list"
                    >Left</td>
                    <td class="text-center voucher_list"
                    >Used</td>
                    <td class="text-center voucher_list"
                    >Status</td>
                    <td class="text-center voucher_list"
                    >Expiry</td>                    
                </tr>
            </thead>

            <tbody>
                @foreach($voucher_list as $voucher)
                    <tr>
                        <td 
                        style="text-align: center;">1</td>
                        <td 
                        style="text-align: center;">{{str_pad($voucher->id, 10, '0', STR_PAD_LEFT)}}</td>
                        <td
                        style="text-align: center;">{{$voucher->nbuyer_id}}</td>
                        <td 
                        style="text-align: center;">{{$voucher->voucher_package_qty}}</td>
                        <td 
                        style="text-align: center;">{{$voucher->qty_left}}</td>                      
                        <td style="text-align: center;">
                            <a onclick="openvoucherledgerlistmodal('{{$voucher->id}}')" >{{$voucher->voucher_package_qty - $voucher->qty_left}}
                            </a>
                        </td>                       
                        <td 
                        style="text-align: center;">{{ucfirst($voucher->status)}}</td>
                        <td
                        style="text-align: center;">{{ date('dMy H:i:s',  strtotime($voucher->expiry)) }}</td>
                    </tr>
                     @endforeach

            </tbody>
        </table>
    </div>
</div>

<div  class="modal fade" id="voucherlist" role="dialog">
    <div class="modal-dialog" style="width: auto;">
        <!-- Modal content-->
        <div class="modal-content  modal-content-patty">
            <div class="modal-header">
                <h4 style="margin-bottom:0"><strong>Voucher List</strong></h4>
                <button type="button"
                        style="position:relative;top:-20px"
                        class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="voucherlistbody" class=" modal-body">

            </div>
        </div>
    </div>
</div>

<script>
    var table = $('#Voucher_lists').DataTable({
    });
    var table1 = $('#VoucherManagement').DataTable({
    });
    var table2 = $('#Voucher_ledger').DataTable({
    });
    $('[name=VoucherManagement_length]').removeClass('select2');
    $('.selection').empty();
    
    function openvoucherlistmodal(voucherid) {
        var JS_BASE_URL = "{{url()}}"
        $.ajax({
            type: "GET",
            url: JS_BASE_URL + "/seller/getvoucherlist/" + voucherid,
            beforeSend: function() {
            },
            success: function(response) {
                $('#voucherlistbody').html(response);
                $('#voucherlist').modal('show');
            }
        });

    }
</script>
<div class="modal fade" id="voucherlistledgerbodymodel" role="dialog">
    <div class="modal-dialog maxwidth60">
        <!-- Modal content-->
        <div class="modal-content  modal-content-patty">
            <div class="modal-header">
                <h4 style="margin-bottom:0"><strong>Voucher Ledger</strong></h4>
                <button type="button"
                        style="position:relative;top:-20px"
                        class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="voucherlistledgerbody" class=" modal-body">
                
            </div>
        </div>
    </div>
</div>

<script>
function openvoucherledgerlistmodal(voucherid) {
        var JS_BASE_URL = "{{url()}}"
        $.ajax({
            type: "GET",
            url: JS_BASE_URL + "/seller/getvoucherledgerlist/" + voucherid,
            beforeSend: function() {
            },
            success: function(response) {
                $('#voucherlistledgerbody').html(response);
                $('#voucherlistledgerbodymodel').modal('show');
            }
        });

    }
</script>
@yield("left_sidebar_scripts")
@stop
