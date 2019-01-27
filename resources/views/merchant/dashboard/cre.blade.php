 <?php use App\Http\Controllers\UtilityController; ?>
 <style type="text/css">
.sort{color: black;} 
.table td.fit,
.table th.fit{
     white-space: nowrap;
width: 1%;
}             
</style>
<div>               

 <table class="table table-bordered"  id="cre_details_table" width="2300px">
                <thead>
      <tr style="background-color:#D8E26D; color: black;width:100%;" >
                        <th class="no-sort text-center no-sort">NO.</th>
                        <th class="large">CRE&nbsp;ID</th>
                        <th class="large">Order&nbsp;ID</th>
                        <th class="large">Product&nbsp;ID</th>
                        <th class="large">Buyer&nbsp;ID</th>
                        <th class="xlarge">Name</th>
                        <th class="large">Contact</th>
                        <th class="fit large">Email</th>
                        <th class="medium">Status</th>
                        <th class="large">I&nbsp;wish&nbsp;to</th>
                        <th class="large">Reason</th>
                        <th class="medium">Photo</th>
                        <th class="xxlarge">Action</th>
                    </tr>
                <thead>
                <tbody>
           <?php $i=1;?>
                    @foreach($cre as $record)
                    <tr style="border:1px solid black;" class="fit">
                        <td style="text-align: center;">
                            {{$i++}}
                        </td>
                        <td style="text-align:center;">{{ $record->cre_id }}</td>
                        <td style="text-align:center;" class="large">{{ UtilityController::s_id($record->porder_id)}}</td>
                        <td style="text-align:center;" class="large">{{ UtilityController::s_id($record->product_id)}}</td>
                        <td style="text-align:center;" class="large">{{ UtilityController::s_id($record->user_id)}}</td>
                        <td style="text-align:center;" class="large">{{ $record->first_name." ".$record->last_name }}</td>
                        <td style="text-align:center;" class="medium">{{ $record->contact }}</td>
                        <td class="large">{{ $record->email }}</td>
                        <td style="text-align:center;" class="medium">
                            @if(is_null($record->status))
                                In Process
                            @elseif($record->status=='cancelreq')
                                Cancel Requested
                            @elseif($record->status=='returnreq')
                                Return Requested
                            @elseif($record->status=="returnrjctd")
                                Return Rejected
                            @elseif($record->status=="returnaccptd")
                                Return Accepted
                            @else
                                {{ucfirst($record->status)}}
                            @endif
                        {{-- Ends --}}
                        
                        <td style="text-align:center;" class="large">{{ ucfirst($record->iwishto)}}</td>
                        <td style="text-align:center;" class="large">{{ ucfirst($record->reason)}}</td>
                        <td style="text-align:center;" class="medium">
                          <a href="javascript:void(0);" class="view-cre-gallery-modal" data-cre-id="{{$record->cre_id}}">Photo</a>
                        </td>
                        <td class="xxlarge">
                            @if(strpos($record->status,'req')==true)
                            <div style="display: inline-block;"><button class="btn btn-success approve" style="width:100px;" data-cre-id="{{$record->cre_id}}" data-op-id="{{$record->op_id}}" data-type="{{$record->iwishto}}">Approve</button>
                            <button style="width:100px;" class="btn btn-warning reject" data-cre-id="{{$record->cre_id}}" data-op-id="{{$record->op_id}}" data-type="{{$record->iwishto}}">Reject&nbsp;</button></div>
                            @else
                                Processed
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
</div>
<script type="text/javascript">
            $(document).ready(function(){
                $('.view-cre-gallery-modal').click(function () {
                    var cre_id=$(this).attr('data-cre-id');
                    var url=JS_BASE_URL+"/cre/images/"+cre_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                });
            });
        </script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.approve').click(function () {
            var cre_id=$(this).attr('data-cre-id');
            var type=$(this).attr('data-type');

            var orderproduct_id=$(this).attr('data-op-id');
            var url = JS_BASE_URL+"/merchant/approve/cre";
            data={
                cre_id:cre_id,
                type:type,
                order_id:orderproduct_id,

            };
            $.ajax({
                url:url,
                data:data,
                type:'POST',
                success:function(r){
                    if (r.status=="success") {

                        toastr.info(r.long_message)
                    }
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                    }
                },
                error:function(){
                    toastr.warning("Your action could not be completed. Please try again later.");
                }
            });
        });
        $('.reject').click(function(){
            var cre_id=$(this).attr('data-cre-id');
            var type=$(this).attr('data-type');
            var orderproduct_id=$(this).attr('data-op-id');
           
            data={
                cre_id:cre_id,
                type:type,
                order_id:orderproduct_id,

            };

            var url = JS_BASE_URL+"/merchant/reject/cre";
            $.ajax({
                url:url,
                type:'POST',
                data:data,
                success:function(r){
                    if (r.status=="success") {

                        toastr.info(r.long_message)
                    }
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                    }
                },
                error:function(){
                    toastr.warning("Your action could not be completed. Please try again later.");
                }
            });
        });
    });

</script>