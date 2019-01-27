@extends("common.default")

@section('css')
    .payment-area div { margin-bottom : 30px }
    .paymentTable{ background : #30849B; color : #fff; }
    .table-bordered > tbody > tr > td,
    table.dataTable tfoot th, table.dataTable tfoot td {
        padding: 10px 8px 6px 9px !important;
    }
    #merchantTable tr th,#merchantTable tr td,#orderTable tr th,#orderTable tr td {
        border : 1px solid #ddd !important;
    }

    .paymentTable th { text-align : center !important }

    .modal-fullscreen{
      margin: 0;
      margin-right: auto;
      margin-left: auto;
      width: 95% !important;
    }
    @media (min-width: 768px) {
      .modal-fullscreen{
        width: 750px;
      }
    }
    @media (min-width: 992px) {
      .modal-fullscreen{
        width: 970px;
      }
    }
    @media (min-width: 1200px) {
      .modal-fullscreen{
         width: 1170px;
    }


@stop

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3">
                @include('admin/leftSidebar')
            </div>
            <div class="col-sm-9">
                <div id="main">
                    <div class="">
                        <div class="main-container">
                            <div class="row payment-area">
                                <div class="col-md-12">
                                    {{-- Merchant View Table --}}
                                    @if(isset($merchants) and !is_null($merchants))
                                    <input type="hidden" class='curr' value="{!! $merchants[0]->currency !!}">
                                    {!! Form::open(array('url'=>'/payuser')) !!}
                                    <table class="table table-responsive" id='merchantTable'>
                                        <thead>
                                            <tr class='paymentTable'>
                                                <th>No</th>
                                                <th>Merchant</th>
                                                <th class='sum'>Commission</th>
                                                <th class='sum'>Payable</th>
                                                <th>Status</th>
                                                <th>Receive Date</th>
                                                <th>Due Date</th>
                                                <th>Source</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th class='com text-right'></th>
                                                <th class='pay text-right'></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th colspan=2 ><button class='btn btn-block btn-danger btn-sm'>Pay</button></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @def $i = 1
                                            @foreach($merchants as $merchant)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    <td>
                                                        <span class='pull-left'>
                                                            <a class='clickable merchant_id' data-val="{!! $merchant->mid !!}">
                                                               [{!! str_pad($merchant->mid, 10, '0', STR_PAD_LEFT) !!}]
                                                            </a>
                                                        </span>
                                                        <span class='pull-right'>{!! $merchant->name !!} </span> &nbsp;
                                                    </td>
                                                    <td class='com text-right'>
                                                        {!! number_format($merchant->commission,2) !!}
                                                    </td>
                                                    <td class='pay text-right'>
                                                        {!! number_format($merchant->payable,2) !!}
                                                    </td>
                                                    <td class='text-center'>
                                                    @if($merchant->status == 1)  Paid 
                                                    @else  Payable 
                                                    @endif
                                                    </td>
                                                    <td class='text-center'>{!! $merchant->rcv !!}</td>
                                                    <td class='text-center'>{!! $merchant->due !!}</td>
                                                    <td class='text-center'>{!! $merchant->source !!}</td>
                                                    <td class='text-center'><input type="checkbox" name='merchant[]' value='{!! $merchant->mid !!}'></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {!! Form::close() !!}

                                    {{-- SMM View Table --}}
                                    @elseif(isset($smms) and !is_null($smms))
                                    <input type="hidden" class='curr' value="{!! $merchants[0]->currency !!}">
                                    {!! Form::open(array('url'=>'/payuser')) !!}
                                    <table class="table table-responsive" id='merchantTable'>
                                        <thead>
                                            <tr class='paymentTable'>
                                                <th>No</th>
                                                <th>SMM ID</th>
                                                <th>Name</th>
                                                <th>Payment Earned Since</th>
                                                <th>Earning YTD</th>
                                                <th>Outstanding</th>
                                                <th>Payment Due Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th colspan=2 ><button class='btn btn-block btn-danger btn-sm'>Pay</button></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @def $i = 1
                                            @foreach($smms as $smm)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    <td>
                                                        <span class='pull-left'>
                                                            <a class='clickable smm_id' data-val="{!! $smm->mid !!}">
                                                               [{!! str_pad($smm->smmid, 10, '0', STR_PAD_LEFT) !!}]
                                                            </a>
                                                        </span>
                                                        <span class='pull-right'>{!! $smm->name !!} </span> &nbsp;
                                                    </td>
                                                    <td class='com text-right'>
                                                        {!! $smm->pes !!}
                                                    </td>
                                                    <td class='pay text-right'>
                                                        {!! $smm->eytd !!}
                                                    </td>
                                                    <td class='pay text-right'>
                                                        {!! $smm->outstanding !!}
                                                    </td>
                                                    <td class='text-center'>{!! $smm->due !!}</td>
                                                    <td class='text-center'><input type="checkbox" name='smm[]' value='{!! $smm->mid !!}'></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {!! Form::close() !!}
                                    @else
                                        <h3 class='text-muted'> no data found for smm in database </h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Modal -->
    <div class="modal fade myModal" id="orderModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Orders</h4>
                </div>
                <div class='modal-body'>
                    
                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal fade myModal" id="productModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='productClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Products / Voucher</h4>
                </div>
                <div class='modal-body'>
                    
                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#merchantTable, #orderTable').DataTable({
        "initComplete": function (settings, json) {
            this.api().columns('.sum').every(function () {
                var column = this;

                var sum = column
                   .data()
                   .reduce(function (a, b) { 
                       return parseFloat(a) + parseFloat(b);
                   });

                $(column.footer()).html(sum.toFixed(2));
            });
        }
    });

    var currency = $('.curr').val();

    $('.com, .pay').append("<span class='pull-left'>"+ currency +"</span>");

    $('.merchant_id').click(function(){
        $('body').css('padding','0px');
        $merchant_id = $(this).attr('data-val');
        $.ajax({
            type : "GET",
            url : 'order/'+$merchant_id,
            success : function(response){
                $('#orderModal').find('.modal-body').html(response);
                $('#orderModal').modal('show');
            }
        })
    })
});
</script>

@yield('left_sidebar_scripts')
@stop