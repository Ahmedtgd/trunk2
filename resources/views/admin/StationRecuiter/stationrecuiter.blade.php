@extends("common.default")
@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 18px;
        font-weight: bold;
        margin: 365px 0 0 610px;
    }
</style>
<div class="overlay" style="display:none;">
    <p>Please Wait...</p>
</div>
<div style="display: none;" class="removeable alert"> 
    <strong id='alert_heading'></strong><span id='alert_text'></span> 
</div>
<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')
    <div style="padding: 25px 0">
        <h2 style="margin-bottom: 10px">Administration Analysis:Station Recruiter</h2>
        <table class="table table-bordered station_recruiter_table">
            <thead>
                <tr>
                    <th class="text-uppercase">No</th>
                    <th class="text-uppercase">sr id</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Since</th>
                    <th>Sales Since</th>
                    <th>Sales YTD</th>
                    <th>Revenue Since</th>
                    <th>Revenue YTD</th>
                    <th>Earned Since</th>
                    <th>Earned YTD</th>
                    <th>Station</th>
                    <th>Outstanding</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: right;">1</td>
                    <td style="text-align: right;">2</td>
                    <td style="text-align: right;">mayur</td>
                    <td style="text-align: right;">active</td>
                    <td style="text-align: right;">2016</td>
                    <td style="text-align: right;">2022</td>
                    <td style="text-align: right;">--</td>
                    <td style="text-align: right;">--</td>
                    <td style="text-align: right;">--</td>
                    <td style="text-align: right;">--</td>
                    <td style="text-align: right;">--</td>
                    <td style="text-align: right;">--</td>
                    <td style="text-align: right;">--</td>
                    <td class="text-capitalize" style="cursor: pointer;" onclick="openpopup('malaysia');">malasiya</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="tableModelSatation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title">Country Malasiya</h3>
            </div>
            <div class="modal-body">
                <table class="table table-hover areatable" id="tblGrid">
                    <thead id="tblHead">
                        <tr>
                            <th>State</th>
                            <th>City</th>
                            <th class="text-right">Area</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Long Island</td>
                            <td class="text-right">NY</td>
                            <td>Long Island, NY, USA</td>
                        </tr>
                        <tr><td>ChicagoUSA</td>
                            <td>Illinois</td>
                            <td class="text-right">USA</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
    $(document).ready(function () {
        $('.station_recruiter_table').DataTable();
        $('.areatable').DataTable();
        jQuery('body').on('click', '.station_recruiter_table tbody tr td:last', function () {
            window.open("http://localhost/supermall/public/admin/analysis/station_recruiter_area", "mywindow", "menubar=0,resizable=1,width=450,height=350");
        });
    });
</script>
@yield("left_sidebar_scripts")
@stop
