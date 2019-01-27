<?php
function addMonth(){
    for($i=1;$i<13;$i++)
        print("<option value='".$i."'>".date('F',strtotime('01.'.$i.'.'.date('Y')))."</option>");
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
                        <li role="presentation" class="floor-navigation"><a href="#wholesale">Wholesale</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#product">Product</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#pspecification">Specification</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#seller">Seller</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#policy">Policy</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#return">Return</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                    <hr>   <div class="col-sm-12 text-right">
                        <ul class="list-inline">
                            <li><a href="/create_new_product">Product</a></li>
                            <li class="active"><a href="/create_new_voucher">Voucher</a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    @include('product._forms.addVoucher')
                </div>
            </div>
        </div><!--End main cotainer-->
    </section>
@stop
