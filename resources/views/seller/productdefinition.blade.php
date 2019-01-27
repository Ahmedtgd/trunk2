@extends('common.default')
@section('content')
    <style>
        .table-sections{padding-top: 100px;padding-bottom: 100px}
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

        .bg-gray{
            background-color: #606060;
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
    @include('common.sellermenu')
    <section class="">
        <div class="container table-sections">
            <h3>Product Defination</h3>
            <table id="editable-datatable" class="table table-bordered" style="width:100% !important">
                <thead>
                <td class="text-center bg-primaryii">No.</td>
                <td class="text-center bg-primaryii">Product Id</td>
                <td class="text-center bg-primaryii">Product Name</td>
                <td class="text-center bg-primaryorange">Recipee</td>
                </thead>
                <tbody id="new-terminal">
                <tr>
                    <td class="text-center" style="vertical-align: middle">1</td>
                    <td class="text-center " style="vertical-align: middle">1236548
                    </td>
                    <td class="text-center">Fish</td>
                    <td class="text-center"><a href="#" data-toggle="modal" data-target="#exampleModalCenter">0</a>
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button class="sellerbutton bg-primaryorange pull-right" id="adding-product"><i class="fa fa-plus"></i>&nbsp; Add Product</button>
                                        <h4>Recipe</h4>
                                    </div>
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col" class="bg-primaryorange">No</th>
                                            <th scope="col" class="bg-primaryorange">Raw Material Id</th>
                                            <th scope="col" class="bg-primaryorange">Raw Material</th>
                                            <th scope="col" class="bg-primaryorange">Qty</th>
                                        </tr>
                                        </thead>
                                        <tbody class="addressing">
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>1236548</td>
                                            <td>Fish</td>
                                            <td>45</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#editable-datatable').DataTable();
        });
        var number = 2;
        $('#adding-product').on('click',function () {
        $('.addressing').append("<tr><th scope='row'>"+number+"</th><td class='text-center'>12365</td><td class='text-center'>fish</td><td class='text-center'>65</td></tr>");
        number ++;
        })
    </script>
@stop