<?php

function addMonth(){
    for($i=1;$i<13;$i++)
        print("<option value='".date('F',strtotime('01.'.$i.'.'.date('Y')))."'>".date('F',strtotime('01.'.$i.'.'.date('Y')))."</option>");
}
function addDays(){
    for($i=1;$i<32;$i++)
        print("<option value='".$i."'>".$i."</option>");
}
function addYear(){
    for($i=date('Y');$i<date('Y-m-d', strtotime('+21 years'));$i++)
        print("<option value='".$i."'>".$i."</option>");
}
?>

@extends("common.default")

@section("content")
@if(Session::has('success'))
<div style="cursor: move;" class="box-header ui-sortable-handle">

                    <div class='alert alert-success'>
    {{Session::get('success')}}
    </div>
                </div>


@endif
@if(Session::has('error'))
  <div class='alert alert-danger'>
    {{Session::get('error')}}
    </div>

@endif

 <link rel="stylesheet" type="text/css" href="{{asset('public/css/productbox.css')}}" )>

 <style>
/*SMM*/
    .productbox{
        margin-right: 0px;
    }
    .selected{
        border: 1px green solid;
    }

    thead tr td.special_price_row {
        padding: 0px;
        font-size: 12px;
    }

/*SMM ENDS*/

        hr{
        border-top-color: #5F6879;
        margin-top: 0px;

    }

    .priceTable thead tr th,
    .priceTable tbody tr td {
        padding: 0px;
        border: 0px;
        font-size: 12px;
    }

    .priceTable thead tr th {
        padding-bottom: 5px;
    }

    .list-inline{
        margin-top: 10px;
    }

    .showAlert{
        padding: 2px 5px;
        font-size: 12px;
        border-radius: 20px;
    }

    .product-name{
        font-weight: bold;
        @if(Auth::check())
            border-bottom: 1px solid #ccc;
            padding-bottom: 7px;
            padding-top: 7px;
        @else
            padding-top: 9px;
        @endif
    }

    .qty-area{
        padding-top: 7px;
        padding-bottom: 7px;
        border-bottom: 1px solid #ccc;
    }

    .tier-price {
        padding-top: 4px;
        padding-bottom: 0px;
        height: 100px;
        overflow: hidden;
    }

    .tier-price div p {
        padding-bottom: 0px;
        margin-bottom: 2px;
        font-size: 12px;
        font-weight: bold;
    }

    .productName{
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .product-price {
        font-weight: bold;
        padding-top: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .popover {
        width: 16%;
    }

    @media (max-width: 321px) {
        .popover {
            width: 70%;
        }
    }

    .popover-content {
        padding: 9px 25px;
    }

    .popover-title {
        padding: 9px 10px;
    }

    .cat-img {
        padding: 0px;
        min-height: 220px;
    }

    .cat-img img {
        height: 200px !important;
    }

    .list-inline li {
        width: 30px;
        height: 30px;
        border-radius: 2px;
        text-align: center;
        padding-top: 2px;
    }
    .save {
        background: red;
        color: #fff;
        padding-left: 7px;
        border-radius: 20px;
        padding-right: 7px;
        padding-bottom: 3px;
    }

    .p-box-content {
        padding: 0px 8px 0px 8px;
    }

    button.btn-xs{
        padding: 4px 5px !important;
    }

    {{-- stop --}}
        .col-xs-15,
        .col-sm-15,
        .col-md-15,
        .col-lg-15 {
            position: relative;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }

        .col-xs-15 {
            width: 20%;
            float: left;
        }
        @media (min-width: 768px) {
        .col-sm-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 992px) {
            .col-md-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 1200px) {
            .col-lg-15 {
                width: 20%;
                float: left;
            }
        }
        /* Start by setting display:none to make this hidden.
       Then we position it in relation to the viewport window
       with position:fixed. Width, height, top and left speak
       speak for themselves. Background we set to 80% white with
       our animation centered, and no-repeating */
    .modal_loading {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('http://sampsonresume.com/labs/pIkfp.gif') 
                    50% 50% 
                    no-repeat;
    }

    /* When the body has the loading class, we turn
       the scrollbar off with overflow:hidden */
    body.loading {
        overflow: hidden;   
    }

    /* Anytime the body has the loading class, our
       modal element will be visible */
    body.loading .modal_loading {
        display: block;
    }
    </style>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active floor-navigation"><a href="#pinformation">Information</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#voucher">Voucher</a></li>
                                 </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                   
               
                     <div id="add-product" class="tab-pane fade in active">
                                    <div id="add_tabs" class="panel with-nav-tabs panel-default">
                                        <div class="panel-heading" style="font-size: 18px;">
                                            <ul class="nav nav-tabs">
                                                <li class="active" >
                                                    <a  data-toggle="tab" class='tab-link'
                                                        style="color: #000; font-size:18px;" id='retail'
                                                        href="#content-retail">Retail&nbsp;&nbsp;
                                                    </a>
                                                </li>
                                                <li>
                                                    <a  data-toggle="tab" class='tab-link'
                                                        id='B2B' style="color: #000; font-size:18px;"
                                                        href="#content-b2b">B2B&nbsp;&nbsp;
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a  data-toggle="tab" class='tab-link'
                                                        id='voucher'
                                                        style="color: #000; font-size:18px;"
                                                        href="#content-voucher">Voucher&nbsp;&nbsp;
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a  data-toggle="tab" class='tab-link'
                                                        id='hyper'
                                                        style="color: #000; font-size:18px;"
                                                        href="#content-hyper">Hyper&nbsp;&nbsp;
                                                    </a>
                                                </li>
                                                <li>
                                                    <a  data-toggle="tab" class='tab-link'
                                                        id='oem'
                                                        style="color: #000; font-size:18px;"
                                                        href="#content-oem">OEM&nbsp;&nbsp;
                                                    </a>
                                                </li>
                                                <li>
												{{--
                                                    <a  data-toggle="tab" class='tab-link'
                                                        id='export'
                                                        style="color: #000; font-size:18px;"
                                                        href="#content-export">Exports&nbsp;
                                                    </a>
                                                </li>
												--}}
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                    
                                        <div id="content-retail" class='tab-pane fade in active'>
                                            <div class="col-sm-12" style="margin-bottom:20px">
                                              <div class="row">
            {!!Form::open(array('route'=>'create_new_voucher.post','id'=>'formVoucher','class'=>'form-horizontal form-wrp','files'=>true))!!}
                        <div id="pinformation" class="row">
                            <div class="col-sm-12"><h1>Voucher</h1>
                            <div hidden="" class="col-md-5 alert alert-danger" id="errors_voucher">There are some errors on page</div>
                            <div hidden="" class="col-md-5 alert alert-success" id="success_voucher">Voucher Added Successfully</div>
                            </div>

                            <div class="col-sm-4 thumbnail">
                                <div id="datepicker-in"></div>
                              
                            </div>

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="productName" class="form-control">
                                        <span  class=" text-danger" id="errors_voucher_product"></span>
                                    </div>

                                </div>
                              
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="categoryId" id="categoryId">
                                             <option selected value="" disabled>select one</option>
                                            @foreach($getCategory as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        <span  class=" text-danger" id="errors_voucher_category"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Sub Category</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="subCategoryId"  id="subCategoryId">
                                            <option value=""></option>
                                        </select>
                                        <span  class="text-danger" id="errors_voucher_sub_category"></span>
                                    </div>


                                </div> 
                                  <div class="form-group">
                                    <label class="col-sm-3 control-label">Brand</label>
                                    <div class="col-sm-9">
                                              <select class="form-control" name="Brand" id="Brand">
                                                <option value="" selected disabled>select one</option>
                                            @foreach($getBrand as $Brand)
                                            <option value="{{$Brand->id}}">{{$Brand->name}}</option>
                                            @endforeach
                                        </select>
                                        <span  class="text-danger" id="errors_voucher_brand"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-sm-3 control-label"> Retail Price</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="rPrice" name="retail_price">
                                        <span  class="text-danger" id="errors_voucher_retail_price"></span>
                                    </div>
                            </div>
                                <div class="form-group">   
                                     <h3 class="col-sm-12">Location</h3>
                                
                                    <label class="col-sm-3 control-label">address</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="address" class="form-control">
                                        <input type="text" name="address_lan_2" class="form-control">
                                        <input type="text" name="address_lan_3" class="form-control">
                                        <span  class="text-danger" id="errors_voucher_address"></span>
                                    </div>
                               
                                </div>

                            </div>

                            <div class="clearfix"></div>

                        </div>
                        <hr>
                        <div class="table-sch col-sm-12 table_voucher_timeslot " >
                                <h4>Time Slot</h4>

                                <table id="" class="table noborder table-striped tableTimeSlot" >
                                    <tr>
                                        <th width="10" ><input class='checkTimeSlot' type='checkbox' onclick="selectTimeSlot()"/></th>
                                        <th colspan="" width="20">Date</th>
                                        <th colspan="">From</th>
                                        <th>To</th>
                                        <th class="text-success text-center">Price</th>
                                        <th colspan="" width="10">Qty Left</th>
                                        <th colspan="" width="10">Qty</th>
                                        
                                    </tr>
                                    <tr>
                                        <td width="5" > <input type='checkbox' class='case4'/></td>
                                        <td width="15%" >
                                            <input type="text" id="date_1" name="bookingDate[]" class="form-control datepicker-example1" ></td>
                                        
                                        <td width="30" colspan=""><div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input  name="fromTime[]" class="form-control time_hours">
                                            </div>
                                            </td>
                                        <td width="30">   <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input type="text"  name="toTime[]"  class="form-control time_hours">
                                            </div></td>
                                        <td width="30" class="text-success text-center"><div class="input-group">
                                                <span class="input-group-addon">{{$currentCurrency}}</span>
                                                <input type="text" name="price[]" id="price_1" class="calInput myr-price form-control" >
                                            </div></td>
                                        <td  width="10" ><div class="input-group "><input type="text" id="qty_left_1" name="qtyLeft[]" class="form-control numeric calInput " ></div></td>
                                        <td width="10" ><div class="input-group "><input type="text" id="qty_1" name="qtyOrdered[]" class="form-control numeric calInput " ></div></td>
                                        
                                    </tr>
                                        
                                </table>
                                 <p  class="text-danger" id="errors_voucher_timeslot"></p>
                               
                               <a href="javascript:void(0);" title="Select and remove Timeslot" id="addRem" class="text-success">
                    <i class="fa fa-plus-circle addTimeSlot" title="Add New Timeslot"></i></a>
                    <a href="javascript:void(0);" class="remRem text-danger">
                    <i class="fa fa-minus-circle deleteTimeSlot"></i></a>
               <br>   <br>
                            </div>
<div class="col-sm-6" >
   <table id="" class="table noborder table-striped" >
                                    <tr>
                                        <th width="10" >No</th>
                                        <th colspan="" width="20">Table</th>
                                        <th colspan="" width="20">Pax/Table</th>
                                        <th width="20">Status</th>
                               
                                    </tr>
                                     <tr>
                                        <th width="10" ></th>
                                        <th colspan="" width="20"><input class='form-control' type='text' /></th>
                                        <th colspan="" width="20"><input class='form-control' name="pax_per_table" type='text'/></th>
                                        <th width="20"><select class="form-control">
                                            <option vlaue="Book">Book</option>
                                        </select></th>
                               
                                    </tr>
     
 </table>
    </div>

<div class="col-sm-6" >

 <div id="voucher" class="row">
                            <div class="col-sm-offset-5 col-sm-5">
                                <h4>Applicable To</h4>
                            </div>
                            <div class="col-sm-offset-5 col-sm-5">
                                <div class="">
                                    <input type="radio"  class="" value="wyear" name="validity">
                                    <label for="checkbox2">
                                        Whole Year
                                    </label>
                                </div>
                                <div class="">
                                    <input checked="" type="radio"  class="" value="wmonth" name="validity">
                                    <label for="checkbox2">
                                        Whole Month
                                    </label>
                                </div>
                                <div class="">
                                    <label for="checkbox2">
                                    <input type="radio"  class="" value="wyear" name="validity">

                                        Whole Year
                                    </label>
                                </div>
                                
                                <div class="">
                                    <label for="checkbox2">
                                    <input type="radio"  class="" value="wkdays"  name="validity">

                                        Weekdays Only
                                    </label>
                                </div>
                                <div class="">
                                    <label for="checkbox2">

                                    <input type="radio"  class="" value="wkends" name="validity" >
                                        Weekends Only
                                    </label>
                                </div>
                            </div></div>

                        </div>
                    <div class="clearfix"> </div>
                            <div class="col-sm-11" id="append-schT"></div>
                            <div class="clearfix"> </div>

                     
                       

                        <div class="row">
                            <div class="col-sm-12 text-right"> <input type="submit" class="btn btn-green" value="Order"></div>
                        </div>

                   {!!Form::close()!!}
                                                </div>
                                            </div>
                                        </div>
                                        <div id="content-b2b" class='tab-pane fade'>
                                            <div class="col-sm-12" style="margin-bottom:20px">
                                                <div class="row">
                                                    <h2 style="margin-left:9px">B2B</h2>
                                                </div>
                                            </div>
                                        </div>   
                                            <div id="content-voucher" class='tab-pane fade'>
                                            <div class="col-sm-12" style="margin-bottom:20px">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                    
                                                    
                                                         <p><a style="background:rgb(224,40,120); color:white; margin-top:15px; font-size: 20px;">
                &nbsp;&nbsp;Like&nbsp; &nbsp;</a>&nbsp; &nbsp;<a style="color:#000; font-size: 23px;"
                href="">OFFICIAL SHOP</a>&nbsp; &nbsp;<img style="width:30px; height:20px; margin-top: -4px;"
                src="{{ asset('images/malaysia.png') }}">&nbsp;</p>
       
                        <h2 style="margin-left:8px;margin-bottom:0;margin-top:0">Voucher</h2>
                  <div class="col-sm-12">
                     <?php $value = 4;$av = 12; $text = 25; $o = 3;?>
                   @foreach($product as $product)
                   <div class="col-sm-4 col-md-3 column productbox">
                                
                                           <a style="color:inherit"
                                                    class="dimmer"
                                                    data-toggle="tooltip" data-placement="bottom"
                                                    title="hhh" href="{{URL::to('CreateVoucherDetails')}}/{{$product->voucherId}}">
                                                <table width="212" height="199" border="1">
                                                  <tr>
                                                    <td colspan="2" align="center"><h2 class="title" style="margin-left:8px;margin-top:0;">
                                        {{$product->catName}} </h2> 
                                         @if(strlen($product->name)<$text)
                                            <div class="producttitle">
                                                <a style="color:inherit"
                                                    class="dimmer"
                                                    data-toggle="tooltip" data-placement="bottom"
                                                    title="{{$product->name}}">{{$product->name}}
                                                </a>
                                            </div>
                                        @else
                                            <div class="producttitle">
                                                <a style="color:inherit"
                                                    data-toggle="tooltip" data-placement="bottom"
                                                    title="{{$product->name}}">{{substr($product->name,0,$text)}}
                                                </a>
                                            </div>
                                        @endif</td>
                                                  </tr>
                                            </table>  </a>                                          
                                     
                                        <div class="productprice">
                                            <div class="pricetext" style="font-size:1em"> {{$currentCurrency}}
                                       @if ($product->retail_price == 0)
                                                  
                                                @else
                                                    
                                                    <strong style="color:red;">{{number_format($product->retail_price/100,2)}} </strong>
                                                    <?php
                                                        
                                                        
                                                    ?>
                                                    <div class="pull-right">
                                                        
                                                    </div>
                                                    <br>
                                                @endif
                                               
                                            </div>
                                       
                                      
                                                {!! Form::open(array('url'=>'cart/addtocart',"class"=>"reset-this")) !!}
                                            {!! Form::hidden('quantity', 1) !!}
                                            {!! Form::hidden('id', 2) !!}
                                            {!! Form::hidden('price', 32) !!} 
                                             
                                            <button href="#" class="btn btn-green btn-xsmall cartBtn" role="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                       {!!Form::close()!!}
                                           
                                            <button class="btn-pink btn btn-xsmall ">
                                                <a href="javascript:void(0)" rel="nofollow" class="add-to-wishlist" style="color:white;" data-item-id="2">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </button>
                                      
                                       </div>
                                        </div>
                                        @endforeach
                                    </div>
                         
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="content-hyper" class='tab-pane fade'>
                                            <div class="col-sm-12" style="margin-bottom:20px">
                                                <div class="row">
                                                    <h2 style="margin-left:9px">Hyper</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="content-oem" class='tab-pane fade'>
                                            <div class="col-sm-12" style="margin-bottom:20px">
                                                <div class="row">
                                                    <h2 style="margin-left:9px">OEM</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="content-export" class='tab-pane fade'>
                                            <div class="col-sm-12" style="margin-bottom:20px">
                                                <div class="row">
                                                    <h2 style="margin-left:9px">Export</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                
                                            
                </div>
            </div>
        </div>
    </section>
<div class="modal_loading"></div>
<select id="">
    <option>Test</option>
    <option>Test</option>
</select>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="{{url('')}}/public/css/default.css" type="text/css">
    <script type="text/javascript" src="{{url('')}}/datepicker/public/javascript/zebra_datepicker.js"></script>
    <link rel="stylesheet" href="{{url('')}}/public/css/default.css" type="text/css">
    
    <link type="text/css" href="{{url('')}}/bootstrap-timepicker-gh/css/bootstrap-timepicker.min.css" />
    <script type="text/javascript" src="{{url('')}}/bootstrap-timepicker-gh/js/bootstrap-timepicker.js"></script>
<script type="text/javascript">
$('.datepicker-example1').Zebra_DatePicker({
    format: 'M d, Y',
	direction: [1, 10]
});
$('.time_hours').timepicker();
$(".table_voucher_timeslot").on("mouseenter", ".datepicker-example1", function () {
        $(function () {
            $('.datepicker-example1').Zebra_DatePicker({
    format: 'M d, Y'
        });
    });
});

$(".table_voucher_timeslot").on("mouseenter", ".time_hours", function () {
       $('.time_hours').timepicker(); 
    
});

  

    
    function clearValues(){
        $('input[type="text"]').val('');
    }
   $("#categoryId").on('change', function(e) {
    
            var categoryId = $('select[name=categoryId]').val();
            var loader = $('.loader');
            var batchOption = $('#subCategoryId');
            $.ajax({
                url: 'selectCategoryWiseSubCategory/'+categoryId,
                type: 'GET',
                dataType:'json',
                beforeSend: function() {
                    loader.show();
                },
                success: function(data) {
                   batchOption.empty();
                    batchOption.append('<option value="" selected disabled>Please select</option>');
                    $.each(data, function(index, value) {
                        batchOption.append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                loader.hide();
                },
                error: function(data) {
                    alert('error occurred! Please Check');
                    loader.hide();
                }
            });

        }); 
  //time------Slot-----------------//
   $(".deleteTimeSlot").on('click', function() {
    $('.case4:checkbox:checked').parents("tr").remove();
    $('.checkTimeSlot').prop("checked", false); 
    checkTimeSlot();
  });
  function selectTimeSlot() {
    $('input[class=case4]:checkbox').each(function(){ 
      if($('input[class=checkTimeSlot]:checkbox:checked').length == 0){ 
        $(this).prop("checked", false); 
      } else {
        $(this).prop("checked", true); 
      } 
    });
  }
  
  function checkTimeSlot(){
    obj=$('.tableSchedule tr').find('span');
    $.each( obj, function( key, value ) {
      id=value.id;
      $('#'+id).html(key+1);
    });
  }

  $(".addTimeSlot").on('click',function(){
  var k=$('.tableTimeSlot tr').length;
      var data4="<tr>"+
      "<td width='10'><input type='checkbox' class='case4'/></td>"+
      "<td width='10'><input type='text'id='date_"+k+"' name='bookingDate[]' class='datepicker-example1 form-control' ></td>"+
      "<td width='30'><div class='input-group'><span class='input-group-addon'>From</span>"+
      "<input type='text'  name='fromTime[]' id='timepicker_"+k+"'class='form-control time_hours'></div></td>"+
      "<td width='30'><div class='input-group'><span class='input-group-addon'>To</span>"+
      "<input type='text' name='toTime[]' id='timepicker_"+k+"'class='form-control time_hours'></div></td>"+
      "<td width='30'><div class='input-group'><span class='input-group-addon'>{{$currentCurrency}}</span>"+
      "<input type='text' name='price[]' id='price_"+k+"'class='calInput myr-price form-control' ></div></td>"+
      "<td  width='10'><input type='text' id='qty_left_"+k+"' name='qtyLeft[]' class='form-control' ></td>"+
      "<td width='10'><input type='text' id='qty_"+k+"' name='qtyOrdered[]' class='form-control' ></td>"+
      "</tr>";
    $(".tableTimeSlot").append(data4);
    row = k ;
    
    k++;
  }); 

  $("#formVoucher").submit(function(e){
            
            $("body").addClass("loading");
        
            $("#errors_voucher").hide();
            $("#success_voucher").hide();
            $("#errors_voucher_product").html('');
            $("#errors_voucher_brand").html('');
            $("#errors_voucher_timeslot").html('');
            $("#errors_voucher_category").html('');
            $("#errors_voucher_sub_category").html('');
            $("#errors_voucher_retail_price").html('');
            $("#errors_voucher_address").html('');
            
    
    e.preventDefault();
    var form = $('#formVoucher')[0]; // You need to use standart javascript object here
    var formData = new FormData(form);
    $.ajax({
        url: $( '#formVoucher' ).attr( 'action' ),
        data: formData,
        type: "POST",
        datatype: "JSON",
        // THIS MUST BE DONE FOR FILE UPLOADING
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response);
            $('input[type="text"]').val('');
            $('select').val('');
            $("#success_voucher").show();
            $("#errors_voucher").hide();
            $("body").removeClass("loading");
        },
        error: function(response){
            $("body").removeClass("loading");
             $("#success_voucher").hide();
            $("#errors_voucher").show();
            /*if (response.responseJSON.productName !="") {
                $("#errors_voucher").html('<p>Product name is required</p>');
            }*/
            $("#errors_voucher_product").html(response.responseJSON.productName);
            $("#errors_voucher_brand").html(response.responseJSON.Brand);
            $("#errors_voucher_category").html(response.responseJSON.categoryId);
            $("#errors_voucher_sub_category").html(response.responseJSON.subCategoryId);
            $("#errors_voucher_retail_price").html(response.responseJSON.retail_price);
            $("#errors_voucher_address").html(response.responseJSON.address);
            $("#errors_voucher_timeslot").html(response.responseJSON.timeslot);
            
            
        }

    })
    
  });
</script>
@stop
