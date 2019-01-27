@extends("common.default")
<?php use App\Http\Controllers\IdController;?>
@section('css')
    .paymentTable{ background : #fe6600; color : #fff; }

    #sourceTable tbody th {
        background : #eee;
    }

    table.dataTable tfoot th, table.dataTable tfoot td {
        padding: 10px 8px 6px 9px !important;
        border:none;
    }

    .paymentTable th { text-align : center !important }

    {{-- .modal-fullscreen{
      margin: 0;
      margin-right: auto;
      margin-left: auto;
      width: 95% !important;
    } --}}

   
    {{-- @media (min-width: 768px) {
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
    } --}}

    .com, .pay, .ocom, .opay, .osales {
        width: 170px ;
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
                        <div>
                            <div class="row payment-area">
                                <div class="col-md-12">
                                    @if(Session::has('error_msg'))
                                    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                                    @elseif(Session::has('success_msg'))
                                    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                                    @endif
                                    {{-- OpenCredit View Table --}}
                                    <h2>OpenCredit <span id="table_heading">Master</span></h2>
                                    <br>
                                    {!! Form::open(array('url'=>'/paymerchant')) !!}
                                    <table class="table table-responsive" id='opencreditTable' width="100%">
                                        <thead>
                                            <tr class='paymentTable'>
                                                <th class="nosort">No</th>
                                                <th>OpenCredit&nbsp;ID</th>
                                                <th>User&nbsp;ID</th>
                                                {{--Paul--}}
                                                {{--<th>Product&nbsp;ID</th>--}}
                                                <th>Source&nbsp;Details</th>
                                                <th>Source&nbsp;ID</th>
                                                <th class='nosort'>Mode</th>
                                                <th class='nosort'>Value</th>
                                                <th class='nosort'>Datetime</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th colspan="8" style="text-align:right">Total OpenCredit Used: Points&nbsp;<span id="opencredit_used">{{number_format($debit/100,2) }}</span></th>
                                            </tr>
                                            <tr>
                                                <th colspan="8" style="text-align:right">Total OpenCredit Issued: Points&nbsp;<span id="opencredit_issued">{{ number_format($credit/100,2) }}</span></th>
                                            </tr>
                                            <tr>
                                                <th colspan="8" style="text-align:right">Total OpenCredit Balance: Points<span id="opencredit_balance">{{number_format($balance/100,2) }}</span></th>
                                            </tr>
                                        </tfoot>
                                        @if(isset($opencredits) and !is_null($opencredits))
                                        <tbody>
                                            @def $i = 1
                                            @foreach($opencredits as $opencredit)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    <td  class='text-center'>                                                   
                                                           {!! IdController::nOc($opencredit->ocid) !!}
                                                    </td>													
                                                    <td  class='text-center'>
                                                        @if(isset($opencredit->uid))
                                                            <a target="_blank" href="{{ route('userPopup', ['id' => $opencredit->uid]) }}" class='clickable product_id'>
                                                               {!! IdController::nB($opencredit->uid) !!}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    {{--Paul--}}
                                                    {{--<td  class='text-center'>--}}
                                                        {{--<a target="_blank" href="{{ route('productconsumer', $opencredit->pid) }}" class="clickable product_id">--}}
                                                        {{--{{ IdController::nP($opencredit->pid) }}--}}
                                                        {{--</a>--}}
                                                    {{--</td>--}}
                                                    <td class='text-center'>

                                                        @if($opencredit->source == 'purchase')
                                                            <a class='clickable source_id' data-id='{{ $opencredit->source_id }}'>
                                                                {{ strtoupper($opencredit->source) }}
                                                            </a>
                                                        @else
                                                            <a class='clickable source'
                                                                data-source = "{{ $opencredit->source }}"
                                                                data-userID = "{{ $opencredit->uid }}"
                                                                data-productID = "{{ $opencredit->pid }}"
                                                                data-value = "{{ $opencredit->value }}"
                                                                data-id = "{{ $opencredit->source=='purchase'?:$opencredit->id }}"
                                                                data-smmcomm = "{{ isset($opencredit->smmcomm) ? $opencredit->smmcomm : null  }}"
                                                                data-ocomm = "{{ isset($opencredit->ocomm) ? $opencredit->ocomm : null }}"
                                                                data-prev = "{{ isset($opencredit->prev) ? $opencredit->prev : null }}"
                                                            >
                                                            {{ strtoupper($opencredit->source) }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class='text-center'>
                                                        @if($opencredit->source=='purchase')
                                                            <a class='clickable source_id' data-id='{{ $opencredit->source_id }}'>

                                                                {{ $opencredit->source_id }}
                                                            </a>
                                                        @elseif($opencredit->source=="cre")
															<a class='clickable source'
                                                                data-source = "{{ $opencredit->source }}"
                                                                data-userID = "{{ $opencredit->uid }}"
                                                                data-productID = "{{ $opencredit->pid }}"
                                                                data-value = "{{ $opencredit->value }}"
                                                                data-id = "{{ $opencredit->source=='purchase'?:$opencredit->id }}"
                                                                data-smmcomm = "{{ isset($opencredit->smmcomm) ? $opencredit->smmcomm : null  }}"
                                                                data-ocomm = "{{ isset($opencredit->ocomm) ? $opencredit->ocomm : null }}"
                                                                data-prev = "{{ isset($opencredit->prev) ? $opencredit->prev : null }}"
                                                            >
                                                            {{ IdController::nCre($opencredit->id) }}
															</a>
                                                        @elseif($opencredit->source=="openwish")
															<a class='clickable source'
                                                                data-source = "{{ $opencredit->source }}"
                                                                data-userID = "{{ $opencredit->uid }}"
                                                                data-productID = "{{ $opencredit->pid }}"
                                                                data-value = "{{ $opencredit->value }}"
                                                                data-id = "{{ $opencredit->source=='purchase'?:$opencredit->id }}"
                                                                data-smmcomm = "{{ isset($opencredit->smmcomm) ? $opencredit->smmcomm : null  }}"
                                                                data-ocomm = "{{ isset($opencredit->ocomm) ? $opencredit->ocomm : null }}"
                                                                data-prev = "{{ isset($opencredit->prev) ? $opencredit->prev : null }}"
                                                            >
															 {{ IdController::nOw($opencredit->id) }}
															</a>
                                                        @else
                                                            {{ $opencredit->id }}
                                                        @endif
                                                    </td>
                                                    <td class='text-center'>
													<?php
														if (isset($opencredit->mode)) {
															// Only if Mode is NOT NULL 
															echo ucfirst($opencredit->mode);
														}
													?>
                                                    </td>
                                                    <td class='text-right'>
                                                        {!! $currency !!} &nbsp;
                                                        {!! number_format($opencredit->value/100,2) !!}
                                                    </td>
                                                    <td class='text-center'>{!! $opencredit->cdate !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
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

    <!-- Source Modal -->
    <div class="modal fade myModal" id="sourceModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Source Details</h3>
                    </h4>
                </div>
                <div class='modal-body'>
                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>

    <!-- Source Id Modal -->
    {{--Paul on 10 May--}}
    <div class="modal fade myModal" id="source_id_modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='close' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Order Details</h3>
                    </h4>
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
            var opencreditTable=$('#opencreditTable').DataTable({
                'aoColumnDefs': [ { "bSortable": false, "aTargets": [0,1,2,4] } ]
            });
            var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : sParameterName[1];
                    }
                }
            };
          
            passed_nbuyerid=getUrlParameter('buyer');
          
            if (passed_nbuyerid!="" && passed_nbuyerid != undefined && passed_nbuyerid!=null) {
                $('#table_heading').text("Summary");
                opencreditTable.columns(2).search(passed_nbuyerid, true, false, true).draw();
                //Update the footer values.
                var inf_url="{{url('opencredit')}}"+"/"+passed_nbuyerid;
                $.ajax({

                    url:inf_url,
                    type:'GET',
                    success:function(r){
                        if (r.status=="success") {
                            debit=r.debit;
                            credit=r.credit;
                            bal=r.balance;
                            $('#opencredit_used').text(debit);
                            $('#opencredit_issued').text(credit);
                            $('#opencredit_balance').text(bal);
                        }else{
                            toastr.error(r.long_message);
                        }
                    }
                }); 
              
            }
            
            $(document).delegate( '.source', "click",function (event) {
			//$('.source_id').click(function(){
                $('body').css('padding','0px');
                var source = $(this).attr('data-source');
                var userID = $(this).attr('data-userID');
                var productID = $(this).attr('data-productID');
                var id = $(this).attr('data-id');
                var value = $(this).attr('data-value');
                var prev = $(this).attr('data-prev');
                var smmcomm = $(this).attr('data-smmcomm');
                var ocomm = $(this).attr('data-ocomm');
                var route = "{{ route('ocreditSourceDetail') }}";
				console.log(userID);
                $.ajax({
                    type : "POST",
                    url : route,
                    data : { 
                        source : source, 
                        productID : productID, 
                        userID : userID, 
                        id : id,
                        value : value,
                        smmcomm : smmcomm,
                        ocomm : ocomm,
                        prev : prev
                    },
                    success : function(response){
                        $('#sourceModal').find('.modal-body').html(response);
                        $('#sourceModal').modal('show');
                    }
                })
            })


            $(document).delegate( '.source_id', "click",function (event) {
                $('body').css('padding','0px');
                var ref_no = $(this).attr('data-id');

                var route = "{{ route('ocreditSourceIdDetail') }}";

                $.ajax({
                    type : "POST",
                    url : route,
                    data : {
                        ref_no : ref_no
                    },
                    success : function(response){
                        $('#source_id_modal').find('.modal-body').html(response);
                        $('#source_id_modal').modal('show');
                    }
                })
            })
        })
    </script>

@stop


