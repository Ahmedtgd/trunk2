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
        <h2>Voucher Management
        </h2>
        <table class="table table-bordered" cellspacing="0"
               id="VoucherManagement" style="width:100% !important;">
            <thead style="color:white">
                <tr style="">
                    <td class="text-center bsmall no-sort voucher_list"
                        style="">No.</td>
                    <td style="color:white" class="text-center voucher_list"
                        >Product ID</td>
                    <td class="text-center voucher_list"
                        >Name</td>
                    <td class="text-center voucher_list"
                        >Qty Limit</td>
                    <td class="text-center voucher_list"
                        >Date</td>
                    <td class="text-center voucher_list"
                        >Nature</td>

                </tr>
            </thead>
            <tbody>
                <?php $num = 0; ?>
                @foreach($voucher_list as $voucher)
                <?php $num++; ?>
                <tr>
                    <td style="text-align: center;">{{ $num }}</td>
                    <td style="text-align: center;">
                         @if($voucher->nature != "paper")
                            {{!empty($voucher->product_id)?str_pad($voucher->product_id, 10, '0', STR_PAD_LEFT):"" }}
                         @endif
                     </td>
                    <td
                        style="text-align: center;">
                        @if($voucher->nature != "paper")
                            {{ $voucher->name }}
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <a href="{{url()}}//seller/getvoucherlist/{{$voucher->id}}" target="_blank">
                            @if($voucher->nature != "paper")
                                {{ !empty($voucher->voucher_qty_limit)?$voucher->voucher_qty_limit:"" }}
                            @endif
                        </a></td>
                     <td
                        style="text-align: center;">{{ date('dMy H:i:s',  strtotime($voucher->created_at)) }}</td>
                    @if($voucher->nature == "paper")
                    <td 
                        style="text-align: center;"><a data-toggle="modal" data-target="#vouchermodel<?php echo $voucher->id; ?>" href="#">{{ucfirst($voucher->nature)}}</a></td>
                    @else
                    <td 
                        style="text-align: center;">{{ucfirst($voucher->nature)}}</td>
                    @endif
                </tr>
                <!-- Voucher Model -->
                <div class="modal fade" id="vouchermodel<?php echo $voucher->id; ?>" role="dialog">
    <div class="modal-dialog maxwidth60">
        <!-- Modal content-->
        <div class="modal-content  modal-content-patty">
            <div class="modal-header">
                <h4 style="margin-bottom:0"><strong>Paper Voucher</strong></h4>
                <button type="button"
                style="position:relative;top:-20px"
                class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="pattymodalbody" class=" modal-body">
            <div style="display:grid;" class="pnl-content">               
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                           <p><?php if($voucher->created_at != null) {echo date('dMy H:i:s', strtotime(str_replace('-','/',  $voucher->created_at)));} ?></p>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                           <label>Staff ID</label>  
                        </div>
                        <div class="col-md-8">
                            {{sprintf('%010d',$selluser->id)}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                           <label>Staff Name</label>   
                        </div>
                        <div class="col-md-8">
                            {{$selluser->first_name}} {{$selluser->last_name}}  
                        </div>
                    </div>
                    <div style="margin-bottom: 5px;" class="row">
                        <div class="col-md-4">
                           <label>Doc. No.</label>
                        </div>
                        <div class="col-md-8">
                            {{$voucher->doc_no}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Platform</label>
                        </div>
                        <div class="col-md-8">
                            {{ucfirst($voucher->platform)}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Description</label>
                        </div>
                    </div>
                    <div class="row">
                        <div style="background-color:#f0f0f0;width:100%;height:50px" class="col-md-12">
                           {{$voucher->description}}
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
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
@yield("left_sidebar_scripts")
@stop
