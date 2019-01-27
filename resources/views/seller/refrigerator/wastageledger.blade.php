@extends("common.default")
@section("content")

@include('common.sellermenu')
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<style>
    .tab-pane{
        margin-top: 4em;
    }

    .top-margin{
        margin-top: -30px;
    }

    table#notproduct_details_table
    {
        /*  table-layout: fixed;*/
        max-width: none;
        width: auto;
        min-width: 100%;
    }

    table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
    .aproducts{
        width: 100% !important;
    }
    .no-sort{
        width: 20px !important;
    }

    #upload-form{
        /*position: absolute;*/
        /*top: 50%;*/
        /*left: 50%;*/
        /*margin-top: -100px;*/
        /*margin-left: -250px;*/
        width: 500px;
        height: 200px;
        border: 4px dashed #333333;
    }
    .select2{display: none;}
    #upload-form .p-sty{
        width: 100%;
        height: 100%;
        text-align: center;
        line-height: 170px;
        color: #333333;
    }
    #upload-form .input-sty{
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 200px;
        outline: none;
        opacity: 0;
    }
    #upload-form .button-sty{
        margin: 0;
        color: #fff;
        background: #16a085;
        border: none;
        width: 508px;
        height: 35px;
        margin-top: -20px;
        margin-left: -4px;
        border-radius: 4px;
        border-bottom: 4px solid #117A60;
        transition: all .2s ease;
        outline: none;
    }
    #upload-form .button-sty:hover{
        background: #149174;
        color: #0C5645;
    }
    #upload-form .button-sty:active{
        border:0;
    }
    .logo-header {
        padding-left:0;
        padding-right:0;
    }
    body {
        font-family: Lato;
    }
    .navbar-inverse .navbar-nav>li>a {
        color:white;
    }

</style>

<section class="">
    <div class="container"><!--Begin main cotainer-->
        <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong class='cart-info'></strong>
        </div>
        <input type="hidden" value="" id="selluserid" />

        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="row">
                        @if(Session::has('success'))
                        <script type="text/javascript">
                            toastr.success("{{Session::get('success')}}");
                        </script>
                        @endif

                        @if(Session::has('error_message'))
                        <script type="text/javascript">
                            toastr.error("{{Session::get('error_message')}}");
                        </script>
                        @endif

                    </div>
                   
                    <input type="hidden" value="" id="mmerchant_id" />
                    <input type="hidden" value="" id="msell_id" />
                    <div id="dashboard" class="row panel-body " style="padding: 0px 15px 15px 15px" >

                        <div class="tab-content top-margin" style="margin-top:-50px">

                            <div class="tab-pane fade in active" id="deliveryorder">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Wastage Ledger </h3>
                                    </div>

                                </div>
                                <div class="row" style="padding: 0px 10px 0px 10px;">
                                     <table class="table table-bordered table-responsive" id="delivery-order-table" >
                                        <thead class="aproducts">
                                            <tr style="background-color: #6d9270; color: #FFF;">
                                               <th style='color:white; background:#008000;'  class="text-center">No </th>
                                                <th style='color:white; background:#008000;'  class="text-center">Date </th>
                                                <th style='color:white; background:#008000;'  class="text-center">Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody id="quantityDetails">
                                           
                                                <?php $i=1; ?>
                                                @foreach($wastageLedgers as $ledger)
                                            <tr>
                                                <td class="text-center">{{$i++}}</td>
                                            <td class="text-center">{{date("dMY",strtotime($ledger->date_created))}}</td>
                                            <td class="text-center">{{$ledger->qty}}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                            
                                </div>
                            </div>

</div>
			</div>
		</div>
	</div>
</div>
    </div>
</section>
                            <script>
  
    
    
    
    function showAjaxModal(ajaxSettings,modal_id){   
        $(modal_id).modal("show");
        $.ajax(ajaxSettings)    
    }
    
    function fStorageMainAjaxFunction(data){
        alert(data);
    }
                                                $(document).ready(function() {
                                           
        
        $('link[rel=stylesheet][href~="{{asset(' / css / select2.min.css')}}"]').remove();
                                                    $('form .input-sty').change(function() {
                                                        $('form .p-sty').text(this.files.length + " file(s) selected");
                                                    });
                                                });
                                                $('#delivery-order-table').DataTable();
                                                function importedstatus(do_id) {
                                                    $.ajax({
                                                        url: JS_BASE_URL + "/importedstatus/" + do_id,
                                                        type: 'GET',
                                                        success: function(r) {
                                                            //console.log(r);
                                                            $('.modal-body-importedstatus').html(r);
                                                            $('#importedstatus').modal('show');
                                                        }
                                                    });
                                                }
                                                function issueDoModal(do_id_no, do_id) {

                                                    $('#issue_do_id_no').html(do_id_no);
                                                    $('input[name=issue_do_id]').val(do_id);
                                                    $('#issueDoPopUp').modal('show');
                                                }

                                                function trDoModal(do_id_no, do_id, inl_id, f_loc) {

                                                    $('#tr_do_id_no').html(do_id_no);
                                                    $('#initial_location').html($('#ini_loc' + inl_id + ' :selected').text());
                                                    $('#final_location').html(f_loc);
                                                    $('input[name=initial_location_id]').val($('#ini_loc' + inl_id).val());

                                                    $('input[name=tr_do_id]').val(do_id);
                                                    $('#trDoPopUp').modal('show');
                                                }

                                                function discardDoModal(do_id_no, do_id) {
                                                    $('#discard_do_id_no').html(do_id_no);
                                                    $('input[name=discard_do_id]').val(do_id);
                                                    $('#discardDoPopUp').modal('show');
                                                }

                                                function exportForm() {
                                                    var from_date = document.getElementById('from_date').value;
                                                    var to_date = document.getElementById('to_date').value;


                                                    if (from_date == "" || to_date == "") {
                                                        toastr.error("Please Select Both Date");
                                                    } else if (new Date(from_date) > new Date(to_date)) {
                                                        toastr.error("From Date must be earlier than To Date");
                                                    } else {
                                                        document.getElementById("export_form").submit();
                                                    }
                                                }




                            </script>
                            @stop