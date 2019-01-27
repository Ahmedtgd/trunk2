@extends('common.default')
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$i = 1;
?>
@section('content')
@include('common.sellermenu')
    <style>
		.table-sections{padding-top: 20px;padding-bottom: 20px}
		.sellerbutton{
    		min-width: 70px;
    		min-height: 70px;
    		padding-top: 26px;
    		text-align: center;
    		vertical-align: middle;
    		float: left;
    		font-size: 13px;
    		cursor: pointer;
    		margin-right: 5px;
    		margin-bottom: 5px;
    		border-radius: 5px;
    		border: none;
    	}
    	.bg-primaryii{
    		background-color: #02d4f9;
    		color: #f6f6f6;
    	}
    	.bg-primaryorange{
    		background-color: #ea6c06;
    		color: #f6f6f6;
    	}

    	.sellerbuttons{
    		min-width: 70px;
    		min-height: 70px;
    		padding-top: 4px;
    		text-align: center;
    		vertical-align: middle;
    		float: left;
    		font-size: 13px;
    		cursor: pointer;
    		margin-right: 5px;
    		margin-bottom: 5px;
    		border-radius: 5px;
    		box-shadow: none;
    		background-color: #6d9370;
    		border: 0;
    		color: #dadada;
    	}
    </style>

    <section class="">
        <div class="container table-sections">
            <h2>Consumed Raw Material Ledger</h2>
            <table id="editable-datatable" class="table table-bordered" style="width:100% !important">
                <thead>
                <td class="text-center bg-primaryii">No.</td>
                <td class="text-center bg-primaryii">Date</td>
                <td class="text-center bg-primaryii">Staff Name</td>
                <td class="text-center bg-primaryii">Receipt No</td>
                <td class="text-center bg-primaryii">Qty</td>
                <td class="text-center bg-primaryii">Product Name</td>
                <td class="text-center bg-primaryorange">Used Raw</td>
                </thead>
                <tbody id="new-terminal">
                <?php $index = 0;?>
                @if(count($sellerData) > 0)
                    @foreach($sellerData as $seller)
                    <tr>
                        <td class="text-center" style="vertical-align: middle">{{++$index}}</td>
                        <td class="text-center " style="vertical-align: middle">
                            {{(!empty($seller->created_at)) ? date('dMy H:i:s', strtotime($seller->created_at)) : null}}
                        </td>
                        <td class="text-center" style="vertical-align: middle">{{$seller->staffname}}</td>
                        <td class="text-center" style="vertical-align: middle">
                            <a href="javascript:void(0);" onclick="showopossumreceipt('{{ url("showreceiptproduct",$seller->id) }}')" class="uniqopossum" id="uniqreport_{{$seller->id}}">
                                {{sprintf('%06d',$seller->receipt_no)}}
                            </a>
                        </td>
                        <td class="text-center" style="vertical-align: middle">{{$seller->quantity}}</td>
                        <td class="text-left" style="vertical-align: middle"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/images/product/{{$seller->pid}}/thumb/{{$seller->thumb_photo}}">&nbsp;{{$seller->pname}}</td>
                        <td class="text-center">
                            <a onclick="showRawMaterial({{ $seller->product_id }})" href="#">{{$seller->raw_count}}</a>
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="exampleModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="width:50%">
                <!-- Modal content-->
              <div class="modal-content modal-content-sku">
                  <div class="modal-header">                      
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h2>Used Raw Material</h2>
                  </div>
                    <div id="sodisp" style="padding-left:0;padding-right:0" class="modal-body"></div>
                  </div>
            </div>
        </div>
        <div class="modal fade oreceipt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width:400px;height: 100%;">
            <div class="modal-content">
                <iframe src="" frameborder="0" style="width: 400px;height:1200px !important;" scrolling="no" id="myframe"></iframe>
              </div>
          </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#editable-datatable').DataTable();
            $('.editable-datatable2').DataTable();
        });
        var number = 2;

       function showRawMaterial(product_id) {
        $.ajax({
            type: "GET",
            url: JS_BASE_URL+"/open-sales/"+product_id,
            success: function( data ) {
                $("#sodisp").html(data);
                $('#exampleModal').modal('show');
            }
        });
       }
       
       function showopossumreceipt($url) {
            console.log($url);
            $('.oreceipt').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
                $(this).find('iframe').attr('src',$url)
            });
            $(".oreceipt").modal("show")
        }

        $('#appendTerminal').on('click',function () {
            $('#new-terminal').append("<tr><td class='text-center' style='vertical-align: middle'>"+number+"</td><td class='text-center'style='vertical-align: middle'>12365</td><td class='text-center'><input type='text' class='form-control' value='dhiraj'></td><td class='text-center'><input type='text' class='form-control' value='45687'></td><td class='text-center'><a href='#' style='vertical-align: middle'>"+number+"</a></td></tr>");
            ++ number;
        });
	</script>
@stop
