	<?php
use App\Http\Controllers\UtilityController;
?>
@extends('common.default')
@section('content')

<style>
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
    	.bg-primarypurple{
    		background-color: #5a319ce8;
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
        .btn-black{
            background:black;
        }
        .key-button{
            display:inline-block !important;
             width:55px;
             padding:0px;color:white;margin-bottom:5px;border-radius:5px !important;height:28px !important;
        }
        .sldetail  tr td{
            padding:5px;
        }

    </style>
<div class="container">
    <div class="row">
        <div class="col-sm-6"><h3>Sales</h3></div>
        <div class="col-sm-6">

           <div class="row"> <h4 class="pull-right"> Start:{{UtilityController::s_date($start)}}</h4></div>
           <div class="row">
             <h4 class="pull-right"> EOD:{{UtilityController::s_date($eod)}}
            </h4></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="sldetail">
                <tr>
                    <td>Cash</td>
                    <td>&nbsp;</td>
                    <td>{{$currency}}&nbsp;{{number_format($cash/100,2)}}</td>
                </tr>
                
                <tr>
                    <td>Credit Card</td>
                    <td>&nbsp;</td>
                    <td>{{$currency}} <?php echo number_format($creditcard/100,2)?></td>
                </tr>
                <tr>
                    <td>Other&nbsp;Points </td>
                    <td>&nbsp;</td>
                    <td>{{$otherpoints->otherpoints}} Pts</td>
                </tr>
                <tr>
                    <td>Voucher:</td>
                    <td>&nbsp;</td>
                    <td>0</td>
                </tr>
               {{--  <tr>
                    <td>Start</td>
                    <td>&nbsp;</td>
                    <td></td>
                </tr> --}}
            </table>
        </div>
        <div class="col-sm-6 pull-right">
            <table class="sldetail">
                <tr>
                    <td style="padding-right:55px">Branch</td>
                    <td>{{$branch}}
                    </td>
                </tr>
                <tr>
                    <td>Terminal ID</td>
                    <td>{{sprintf('%05d',$terminal->id)}}</td>
                </tr>
                <tr>
                    <td>Staff ID:</td>
                    <td>{{$staffid or '0000'}}</td>
                </tr>
                <tr>
                    <td>Staff Name:</td>
                    <td>{{$staffname or '--'}}</td>
                </tr>
             
                </table> 
        </div>
    </div>
     <div class="row">
    &nbsp;
    </div>
    <div class="row">
    <div class="col-sm-12">
        <table id="raw-datatable" class="table table-bordered" cellspacing="0">
                <thead>
                    <tr>
                        <td style="width:15px"
                        class="text-center bg-primarypurple">No</td>
                        <td style="width:35%"
                        class="text-center bg-primarypurple">Description</td>
                        <td class="text-center bg-primarypurple">Price</td>
                        <td class="text-center bg-primarypurple">Key</td>
                        
                        <td class="text-center bg-primarypurple">Room</td>
                        <td class="text-center"
                            style="background-color:#0580FE">Masseur</td>
                        <td class="text-center"
                            style="background-color:#0580FE">Start</td>
                        <td class="text-center"
                            style="background-color:#0580FE">End</td>
                     
                        <td class="text-center"
                            style="background-color:green;">Status</td>
                    </tr>
                </thead>
                <tbody id="new-terminal">
                    <?php $index = 0;?>
                    @if(count($products) > 0)
                        @foreach($products as $product)
                           {{--  @for ($i = 0; $i < $product->quantity; $i++) --}}
                            <tr>
                                
                                <td class="text-center" style="vertical-align: middle">{{++$index}}</td>
                                <input type="hidden" value="{{$product->saleslog_id}}" id="saleslog_{{$index}}">
                                <td class="text-left" style="vertical-align: middle">
                                    <input type="hidden" name="hiddenproductid" id="hiddenproductid_{{$index}}" value="{{ $product->id}}">
                                    <input type="hidden" name="productquantity" id="productquantity_{{$index}}" value="1">
                                    <img src="{{url()}}/images/product/{{$product->id}}/thumb/{{$product->thumb_photo}}" width="30" height="30">
                                    {{$product->name}}</td>
                                <td class="text-center" style="vertical-align: middle">{{number_format($product->price/100,2)}}</td>
                                <td class="text-center" style="vertical-align: middle" id="keybutton_{{$product->saleslog_id}}">
                                   
                                    
                                       @if(!empty($product->fnumber) and empty($product->txn_checkout))
                                       
                                           {{$product->fnumber}}
                                      
                                        @else
                                        --
                                        @endif
                                    
                 
                               
                                </td>
                                
                                 <td class="text-center" style="vertical-align: middle" id="spabutton_{{$product->saleslog_id}}">
                   
                                        
                                       @if(!empty($product->sparoom_ftype_id))
                                       
                                           {{$product->snumber}}
                                      @else
                                       --
                                        @endif
                        
                                </td>
                                <td class="text-center" style="vertical-align: middle" id="sl_masseur_{{$product->saleslog_id}}">
                               
                                    @if(!empty($product->masseur_id))
                                       
                                            {{$product->first_name}}
                                        
                                    @else
                                    --
                                    @endif
                               
                              
                                </td>
                                <td class="text-center" style="vertical-align: middle" id="td_sl_start_{{$product->saleslog_id}}">
                                    @if(isset($product->start) and !empty($product->start))
                                {{UtilityController::s_date($product->start)}}
                                    @else
                                    --
                                    @endif

                                </td>
                                <td class="text-center" style="vertical-align: middle" id="td_sl_end_{{$product->saleslog_id}}">
                                    @if(isset($product->end) and !empty($product->end))
                                   {{UtilityController::s_date($product->end)}}
                                    @else
                                    --
                                    @endif
                                </td>
                                 
                                
                                
                                <td class="text-center" style="vertical-align: middle">
                                    @if($product->status=="completed")
                                    Paid
                                    @elseif($product->status=="active" and $is_eod==true)
                                    Unpaid
                                    @else
                                    Pending
                                    @endif

                                </td>
                            </tr>
                            {{-- @endfor --}}
                            
                        @endforeach

                    @endif
                </tbody>
            </table>

    </div>
    </div>
   


        	

</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#raw-datatable").DataTable();
	})
</script>
@stop
