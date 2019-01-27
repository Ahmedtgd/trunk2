

<script type="text/javascript">

    $(document).ready(function(){
        $("#gatortable").keypress(function (evt) {
            var charCode = evt.charCode || evt.keyCode;
            if (charCode  >=48 && charCode <=57 || charCode==13 ) {

            } else{
                evt.preventDefault();
            }
        });
    });

</script>

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

    /* Popup arrow */

</style>
<meta name="_token" content="{{ csrf_token() }}" />
            <div class="tab-content">
                <div id="maingatortable" >
                        <h2 style=" width: 40%;float: left; padding-top: 5px;">
                            Exchange and Purchase Product</h2>
                        <table id="gatortable" class="table table-bordered">
                            <thead class="bg-gator" style="width:100%;font-weight:bold">
                            <tr>
                                <td style="visibility: hidden;">Test</td>
                                <td class='text-center bsmall'>No</td>
                                <td class='text-center bmedium'>Product ID</td>
                                <td class='text-left bmedium'>Product Name</td>
                                <td class='text-center bmedium'>Price&nbsp;({{$currency}})</td>
                                <td style="width: 20% !important;"
                                    class='text-center bmedium'>Qty</td>
                                <td style="width: 15%;"
                                    class='text-center bmedium'>
                                    Total ({{$currency}})</td>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $index = 0;
                           ?>
                            @foreach($products as $product)


                                <tr style="vertical-align: middle;" >
                                    <td style="visibility: hidden;">Test</td>
                                    <td class='text-center bmedium'>{{++$index}}</td>
                                    <td class='text-center bmedium'>
                                        <a target="_blank"
                                           href="{{URL::to("productconsumer/$product->parent_id")}}">{{$product->nproductid}}</a></td>

                                    <td style="text-align: left;" class=' bmedium'>
                                        <div style="width: 100%;float: left;display: flex;justify-content: space-between;align-items: center;">
                                            @if(File::exists(URL::to("images/product/$product->prid/thumb/$product->thumb_photo")))
                                                <img width="30" height="30" src="{{URL::to("images/product/$product->prid/thumb/$product->thumb_photo")}}">
                                            @else
                                                <img width="30" height="30" src="{{URL::to("images/product/$product->parent_id/thumb/$product->thumb_photo")}}">
                                            @endif
                                            <div style="width: 90%;float: right;">{{$product->name}}</div>
                                        </div>
                                    </td>

                                    <td style="cursor:pointer;text-align: right;"  class='bmedium'>

                                        {{number_format($product->order_price/100,2)}}

                                    </td>
                                    <td>
                                      {{$product->quantity}}
                                    </td>
                                    <td>
                                        {{number_format(($product->order_price * $product->quantity)/100,2)}}
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <br><br>





