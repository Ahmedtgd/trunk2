@extends("common.default")


@section("content")
@include("common.sellermenu")


<style>
.dataTables_filter input {
	width:300px;
}
#head{
    padding-top: 50px;

    color:grey;
}

</style>


<div class="container">
    <div class="row">
        <h1 id="head">Commission:Based on Product</h1>
    </div>
</table>

<table style="width:100%; text-align: center;" id="raw-datatable" class="table table-bordered prd_datatable">
    <thead style="color:white">
        <tr>
            <td width="20%"
                class="text-center"
                style="background-color: #0F67E2; color:white;  height:15px;">
                <b>NO.</b></td>
            <td width="15%" width="30%"
                class="text-center"
                style="background-color:#0F67E2;color:white;  height:15px;">
                <b>Product Id</b></td>
            <td width="15%" width="30%"
                class="text-center"
                style="background-color:#0F67E2;color:white;  height:15px;">
                Poduct Name</td>
            <td width="20%" width="30%"
                class="text-center"
                style="background-color:#0F67E2;color:white;  height:15px;"
                id="modelstaff">
              <b>Staff</b>
        
            </td>
            {{-- <button type="button" class="btn-danger" data-toggle="modal" data-target="#create"> --}}
        </tr>
    </thead>
    <tbody>
            {{-- @if($attendance!=null) --}}
        <tr>
            <td>8</td>
            <td>109</td>
            <td>oppo</td>
            <td> <a href="" class="btn" type="button" data-toggle="modal" data-target="#create"> ming ming tan</a></td>
            

        </tr>
        <tr>
                <td>9</td>
                <td>119</td>
                <td>oppo</td>
                <td>////</td>
                
    
            </tr>
        {{-- @endif --}}
    </tbody>

</table>

   <!-- create-post -->
 

<div id="create" class="modal fade" role="dialog">
<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Commission:Based on Entitled Staff</h4>
             
           <div class="modal-body">
            </table>

            <table style="width:100%; text-align: center;" class="table table-bordered prd_datatable" id="prds_tbl" style="margin-bottom: 15px;margin-top: 15px; height:25px;">
                <thead style="color:white">
                    <tr>
                        <td width="20%"
                            class="text-center"
                            style="background-color: #0F67E2; color:white;  height:15px;">
                            <b>NO.</b></td>
                        <td width="15%" width="30%"
                            class="text-center"
                            style="background-color:#0F67E2;color:white;  height:15px;">
                            <b>Staff_Id</b></td>
                        <td width="15%" width="30%"
                            class="text-center"
                            style="background-color:#0F67E2;color:white;  height:15px;">
                            Staff_Name
                        </td>
                        <td width="20%" width="30%"
                            class="text-center"
                            style="background-color:#0F67E2;color:white;  height:15px;">
                            <b>Rate</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                        {{-- @if($attendance!=null) --}}
                    <tr>
                        <td>9</td>
                        <td>//</td>
                        <td>//</td>
                        <td>//</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>//</td>
                        <td>//</td>
                        <td>//</td>
                    </tr>
                    {{-- @endif --}}
                </tbody>
            </table>
           </div>
      </div>
   </div>
</div>
</div> 



</div>

<script type="text/javascript">
 $(document).ready(function() {
    $('.prd_datatable').DataTable({});
 });
</script>
 
@stop
