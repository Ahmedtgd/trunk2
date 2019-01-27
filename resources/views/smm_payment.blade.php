@extends("common.default")

@section('css')
    .payment-area div { margin-bottom : 30px }
    .paymentTable{ background : #30849B; color : #fff; }
    table.dataTable tfoot th, table.dataTable tfoot td {
        padding: 10px 8px 6px 9px !important;
        border:none;
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

    table#smmTable
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }


@stop

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-12">
                @include('admin/panelHeading')
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="main">
                    <div class="">
                        <div class="main-container">
                            <div class="row payment-area">
                                <div class="col-md-12">
                                    @if(Session::has('error_msg'))
                                    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                                    @elseif(Session::has('success_msg'))
                                    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                                    @endif
                                    {{-- SMM View Table --}}
                                    {!! Form::open(array('url'=>'/paysmm')) !!}
                                    <h2>Payment: SMM</h2>
                                    <br>
                                    <div class="tableData">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" cellspacing="0" width="100%" id='smmTable'>
                                        <thead>
                                            <tr class='paymentTable'>
                                                <th>No</th>
                                                <th class='nosort'>SMM</th>
                                                <th>Name</th>
                                                <th class='nosort'>Payment&nbsp;Earned&nbsp;Since</th>
                                                <th class='nosort'>Earning&nbsp;YTD</th>
                                                <th class='nosort'>Outstanding</th>
                                                <th>Payment&nbsp;Due&nbsp;Date</th>
                                                <th class='nosort'></th>
                                            </tr>
                                        </thead>
                                        @if(isset($smms) and !is_null($smms))
                                        <input type="hidden" class='curr' value="{!! $smms[0]->currency !!}">
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
                                            @def $j = 0
                                            @foreach($smms as $key => $smm)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    <td class='text-center'>
                                                        <a class='clickable smm_id' data-val="{!! $smm->smmid !!}">
                                                           [{!! str_pad($smm->smmid, 10, '0', STR_PAD_LEFT) !!}]
                                                        </a>
                                                    </td>
                                                    <td  class='text-center'>
                                                        {!! $smm->name !!}
                                                    </td>
                                                    <td class='com text-right'>
                                                        {!! number_format($smm->pes,2) !!}
                                                    </td>
                                                    <td class='pay text-right'>
                                                        {!! number_format($ytd[$key][0]->eytd,2) !!}
                                                    </td>
                                                    <td class='text-center'>
                                                        {!! $smm->outstanding !!}
                                                    </td>
                                                    <td class='text-center'>{!! $smm->due !!}</td>
                                                    <td class='text-center'>
                                                        <input type="checkbox" name='smm[]' value='{!! $smm->smmid !!}'>
                                                    </td>
                                                </tr>
                                                <?php $j++; ?>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                    </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>

    <!-- Order Modal -->
    <div class="modal fade myModal" id="smmModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">SMM Details</h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#smmTable, #smmDetailsTable').DataTable({
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            });

            var currency = $('.curr').val();

            $('.com, .pay').append("<span class='pull-left'>"+ currency +"</span>");

            $('.smm_id').click(function(){
                $('body').css('padding','0px');
                $smm_id = $(this).attr('data-val');
                $.ajax({
                    type : "GET",
                    url : 'smm/smmdetail/'+$smm_id,
                    success : function(response){
                        $('#smmModal').find('.modal-body').html(response);
                        $('#smmModal').modal('show');
                    }
                })
            })
            $('table th:first').removeClass('sorting_asc');
        })
    </script>

    @yield('left_sidebar_scripts')
@stop


