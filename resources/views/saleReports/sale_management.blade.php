<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')

@if (Session::has('error'))
<div class="alert alert-danger">
  <strong>Danger!</strong> Please Select a Station.
</div>
@endif

    <style>
    .float-right{
      float: right;
    }
    .round{
      width: 34px;
      border-radius: 20px;
      padding: 6px;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
      padding: 8px;
      line-height: 1.42857143;
      vertical-align: middle;
      border-top: 1px solid #ddd;
    }
    .red{
      background-color:#d9534f;
    }
    .red:hover{

      background-color: #bf1510;
      color: white;
    }
    .skyblue:hover{
      background-color: #377482;
      color: white;
    }
    .blue:hover{

      background-color: #0b34ff;
      color: white;
    }
    .form-group5{
      margin-bottom: 5px;
    }
    .controlbtn{
      width: 70px;
      height: 70px;
      padding-top: 15px;
      text-align: center;
      vertical-align: middle;
      font-size: 13px;
      cursor: pointer;
      margin-right: 5px;
      margin-bottom: 5px;
      border-radius: 5px
    }
    .blue{
      background-color:#0725B9;
    }
    .skyblue{
      background-color: #0CC0E8;
      color:white;
  }
  .redblue{
     background-color:#C9302C ;
 }

 .hide{
     display: none;
 }
 .pointer:hover{
     cursor: pointer;
 }
 .redBox{
    background-color: #D73942;
    color:white;
  }
 @-webkit-keyframes spin {
     0% { -webkit-transform: rotate(0deg); }
     100% { -webkit-transform: rotate(360deg); }
 }

 @keyframes spin {
     0% { transform: rotate(0deg); }
     100% { transform: rotate(360deg); }
 }
</style>
@include("common.sellermenu")
<meta name="_token" content="{{ csrf_token() }}" />

    <div class="blur">
      <form method="POST"  id="gatorform"  >
        <input hidden="" id="" type="text" value="" name="user_id">
        <input hidden="" id="setbuyer" type="text" value="" name="setbuyer">
        <input hidden="" id="isbuyer" type="text" value="" name="isbuyer">
        <div class="table-responsive" style="margin-bottom: 28px;">

        </div>

        {{-- TABS --}}

        <div  class="container">
          <div class="start-loader-main "></div>
          <div style="float: right;padding-top:15px;margin-right: 20px !important;font-size:15px;" >
		  {{$location}}<br>Terminal: 
		  {{str_pad($terminal->id,4,'0',STR_PAD_LEFT)}}</div>


          <h2 style=" width: 40%;float: left; padding-top: 5px;">Sales Report</h2>
          <div><h4 class="text-center"
            style="color:#3c24ff;width:30%;height:60px;float:left;padding-top: 15px;"
            id="showselectedbuyer"></h4></div>
            <!-- Modal -->


          </div>
          <div class="tab-content">
            <div id="maingatortable" >
              <div class="container">
                <table id="srtable" class="table table-bordered">
                  <thead class="bg-gator" style="font-weight:bold">
                    <tr>
                      <td class="text-center" style="background-color: #32CD32; color:white;">No</td>
                      <td class="text-center" style="background-color: #32CD32; color:white;">START</td>
                      <td class="text-center" style="background-color: #32CD32; color:white;">EOD</td>
                      
                      {{-- <td class="text-center" style="background-color: #32CD32; color:white;">Cash</td>
                      <td class="text-center" style="background-color: #32CD32; color:white;">Credit Card</td>
                      <td class="text-center" style="background-color: #32CD32; color:white;">Other Point</td>
                      <td class="text-center" style="background-color: #32CD32; color:white;">Wallet</td>
                      <td class="text-center" style="background-color: #32CD32; color:white;">Branch</td>
                      <td class="text-center" style="background-color: #32CD32; color:white;">Company</td> --}}
                  </tr>
                </thead>
                <tbody>
                @def $i=1
                @foreach($records as $record)
                  <tr>
                    <td style="text-align: center;">{{$i}}</td>
                    <td class="text-center" style="vertical-align: middle">
                    @if($terminal->bfunction=="spa")
                    <a target="_blank" href="{{url('saleslog/range/view',$record->id)}}">{{UtilityController::s_date($record->start_work)}}</a>
                    @else
                    {{UtilityController::s_date($record->start_work)}}
                    @endif
                    </td>
                    <td class="text-center" style="vertical-align: middle">
                    <a href="javascript:void(0)" onclick="show_eod_summary('{{$record->id}}')">{{UtilityController::s_date($record->eod)}}</a></td>
                  
                   {{--  <td class="text-right" style="vertical-align: middle">
                      
                      {{number_format($record->cash/100,2)}}
                     
                    </td>
                    <td class="text-right" style="vertical-align: middle">
                    
                      {{number_format($record->creditcard/102,2)}}
                     
                    </td>
                    <td class="text-center" style="vertical-align: middle">
                      {{number_format($record->otherpoints,2)}}
                    </td>
                    <td class="text-center" style="vertical-align: middle">-</td>
                    <td class="text-right" style="vertical-align: middle">0.00</td>
                    <td class="text-right" style="vertical-align: middle">0.00</td> --}}
                  </tr>
                  <?php $i++;?>
                  
                @endforeach
				</tbody>
				</table>
			<br>
			</div>
		</div>
		<?php $count = 1; ?>
	</div>
</form>
<div class="modal fade oreceipt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;height: 100%;">
    <div class="modal-content">
       
        <iframe src="" frameborder="0" style="width: 400px;height:750px !important;" scrolling="yes" id="myframe"></iframe>
      </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#srtable").DataTable();
  })
  function show_eod_summary($log_id) {
    url=JS_BASE_URL+"/eod/summary/"+$log_id;
     $('.oreceipt').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
                $(this).find('iframe').attr('src',url);
                // $('#getrefund').bind("click",function()
                // {
                //   alert("in refund");
                // });
                // $('#getrefund').click(function()
                // {
                //   alert("click in refund");
                // });
            });
            $(".oreceipt").modal("show");
  }
</script>


@yield("left_sidebar_scripts")
@stop
