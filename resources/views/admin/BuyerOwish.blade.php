<?php
$cf = new \App\lib\CommonFunction();
?>
@extends("common.default")

@section("content")
<style type="text/css">
    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
</style>

    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
            <div class="col-md-9 equal_to_sidebar_mrgn">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif 
                <script>
                window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
                </script>
               <b>Buyer OpenWish</b>
                <br><br>
              
                    <table id="test" class="display nowrap table table-bordered" cellspacing="0" width="100%" >
                <thead>
                    <tr>
                        <th>Social Media Id</th>
                        <th>Social Media Account</th>
                        <th>Source IP</th>
                        
                    </tr>
                </thead>
                <tbody>              
      @foreach ($openwish as $key=>$value)           
            <tr>
                <td>{{(!empty($value->smedia_id)) ? $value->smedia_id : null}}</td><!--  -->
                <td>{{(!empty($value->smedia_account)) ? $value->smedia_account : null}}</td>
                <td>{{(!empty($value->source_ip)) ? $value->source_ip : null}}</td>        
            </tr>
          @endforeach
        </tbody>
        </table>
<br><br>
                
            </div>
        </div>
    </div>          </div>
                    </div>
    </div>                 
    <script type="text/javascript">
      
        $(document).ready(function () {
             var oTable = $('#test').DataTable( {
        
        "scrollX":        true,
        "info":           true,
        "paging":         true,


    } );    

    /* Add event listener to the dropdown input */
    $('#search_value').keyup( function() { 

if($('select#filtername').val()=='all'){
           oTable.column(0).search( this.value ).draw();
      }else if($('select#filtername').val()=='country'){ //alert('dd');
           oTable.column(4).search( this.value ).draw();

      }else if($('select#filtername').val()=='city'){ //alert('dd');
           oTable.column(5).search( this.value ).draw();

      }else if($('select#filtername').val()=='openwish'){ //alert('dd');
           oTable.column(0).search( this.value ).draw();

      }else if($('select#filtername').val()=='smm'){ //alert('dd');
           oTable.column(0).search( this.value ).draw();

      } else if($('select#filtername').val()=='buyerself'){ //alert('dd');
           oTable.column(0).search( this.value ).draw();

      } else if($('select#filtername').val()=='dealer'){ //alert('dd');
           oTable.column(0).search( this.value ).draw();

      }

         } );

        });
    </script>
@stop
