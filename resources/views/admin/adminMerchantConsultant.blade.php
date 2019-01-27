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
<?php $i = 1; ?>
<div class="overlay" style="display:none;">
    <p>Please Wait...</p>
</div>
<div style="display: none;" class="removeable alert"> 
    <strong id='alert_heading'></strong><span id='alert_text'></span> 
</div>


<div class="container" style="margin-top:30px;">

</div>
<div style="display: none;" class="removeable alert"> 
    <strong id='alert_heading'></strong><span id='alert_text'></span> 
</div>
<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')
    <div>
        <h2>Administration Analysis: Merchant Consultant</h2>

        <div class="table-responsive">
            <table class="table datat">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>MC ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Since</th>
                        <th>Sales Since</th>
                        <th>Sales YTD</th>
                        <th>Revenue</th>
                        <th>Revenue YTD</th>
                        <th>Earned Since</th>
                        <th>Earned YTD</th>
                        <th>Mearchant</th>
                        <th>MP</th>
                        <th>Outstanding</th>
                        <th>Contry</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>name</td>
                        <td>Status</td>
                        <td>Status</td>
                        <td>Sales Since</td>
                        <td>Sales YTD</td>
                        <td>Revenue YTD</td>
                        <td>Earned Since</td>
                        <td>Earned YTD</td>
                        <td>Mearchant</td>
                        <td>100</td>
                        <td>10</td>
                        <td>Status</td>
                        <td onclick="openpopup('malaysia');" style="cursor: pointer;">Malaysia</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
    $(document).ready(function () {

        $('.datat').DataTable({
            'scrollX': true,
            'autoWidth': false
        });
        
        
        
        
    });
    function openpopup(country){
        window.open ("http://dev.supermall.com/admin/analysis/merchant_consultant_area","mywindow","menubar=0,resizable=1,width=450,height=350");
    }
</script>
@stop