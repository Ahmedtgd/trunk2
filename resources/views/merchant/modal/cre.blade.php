<?php 
$i=1;
use App\Http\Controllers\IdController;

?>
<table class="table" width="100%" style="table-layout: fixed;">
    <thead>
        <tr style="background-color: black;color: white;">
            <th style="width:50px;" class="text-center">No.</th>
            <th class="text-center" style="width:150px;">Product&nbsp;ID</th>
            <th class="text-center" style="width:350px;">Product&nbsp;Name</th>
            <th class="text-center">CRE&nbsp;Reason</th>
            <th class="text-center">Return&nbsp;Goods</th>
            {{-- <th class="text-center">Delivery&nbsp;Cost</th> --}}
            <th class="text-center" style="width:70px;">Approve</th>
            <th class="text-center" style="width:70px;">Reject</th>
        </tr>
    </thead>
    <tbody>
        <input type="hidden" name="oidcre" id="oidcre" value="{{$oid}}">
        @foreach($cre as $c)
            <tr class="cre_approval" rel-opid="{{$c->opid}}">
                <td>{{$i}}</td>
                <td class="text-left"><a href="{{url('productconsumer',$c->pid)}}" target="_blank">{{IdController::nP($c->pid)}}</a></td>
                <td class="text-center"><a class="truncate" title="{{$c->product_name}}">{{$c->product_name}}
                </a></td>
                <td class="text-center">{{ucfirst($c->reason)}}</td>
                <td><input type="radio" name="status_{{$c->opid}}" class="form-control retchoice group1" value="requested_goods"></td>
                {{-- <td><input type="checkbox" name="delivery_cost" class="form-control" value="1">

                </td> --}}
                <td>
                <input type="hidden" class="{{$c->opid}} result" value="accepted">
                <input type="radio" name="status_{{$c->opid}}" class="form-control retchoice group2" rel-opid="{{$c->opid}}" value="accepted"  checked="checked"></td>
                <td><input type="radio" name="status_{{$c->opid}}" class="form-control retchoice group2" rel-opid="{{$c->opid}}" value="rejected"></td>
            </tr>
            <?php $i++;?>
        @endforeach
    </tbody>
    <tfoot style="background-color:#F5F5DC;">
        {{-- <tr> --}}
            

            {{-- <td></td>
            <td></td> --}}
            {{-- <td colspan="6" style="font-size: 0.9em;"><label class="pull-left checkbox-inline">I would like to give good service to customer by bearing the delivery cost <input type="checkbox" name="noCharge" class="noCharge " value="1" id="noCharge" style="margin-left: 15px;"></label></td> --}}
           

            
      {{--   </tr> --}}
{{--         <tr>
            <td colspan="6" style="font-size: 0.9em;">
                <label class="pull-left checkbox-inline ">
                I would like the buyer to return back the goods.
                <input type="checkbox"  id="goods"  value="1" class="" style="margin-left: 15px;" />
                </label>
            </td>
        </tr> --}}

        <tr>

            <td colspan="7">
                            
                <a href="javascript:void(0);" class="view-cre-gallery-modal pull-right" data-cre-id="{{$creid}}">View Images</a>
                
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#note" class="view-cre-buyers-note pull-left" data-cre-id="{{$creid}}">Buyer's Note</a><br>
                <div id="note" class="collapse">
                    {{$crenote}}
                </div>
                  
            </td>
        </tr>
    </tfoot>
</table>


<script type="text/javascript">
$(document).ready(function(){
    $('.view-cre-gallery-modal').click(function () {
        var cre_id=$(this).attr('data-cre-id');
        var url=JS_BASE_URL+"/cre/images/"+cre_id;
        var w=window.open(url,"_blank");
        w.focus();
    });
    $('.truncate').each(function(i,elem){
    var text=$(this).text();

    text=text.substring(0,28)+"...";
    $(elem).text(text);
    });

    $('.retchoice').change(function(){
        var opid=$(this).attr('rel-opid');
        var value=$(this).val();
        $('.'+opid).attr('value',value);
    });

    // $('.group1').hover(function(){
    //     if($(this).is(":checked")){

    //         $('.group1').prop('disabled',true);
    //         $('.group2').prop('disabled',false);
    //     }else{
    //         $('.group2').prop("checked",false);
    //         $('.group2').prop('disabled',true);
    //         $('.group1').prop('disabled',false);
    //     }
    // });
    // $('.group2').hover(function(){
    //     if($(this).is(":checked")){
    //         $('.group1').prop("checked",false);
    //         $('.group2').prop('disabled',true);
    //         $('.group1').prop('disabled',false);
    //     }else{
    //         $('.group1').prop('disabled',true);
    //         $('.group2').prop('disabled',false);
    //     }
    // });
            // $('#goods').change(function(){
        
            //     if ($(this).is(":checked")) {
            //         // Merchant wants good. No approve button
            //         $('#abutton').prop('disabled',true);
            //         $('#gbutton').prop('disabled',false);
            //         $('#gbutton').removeClass('disabled');
            //         $('#abutton').addClass('disabled');
            //         // $()
            //     }else{
            //         $('#gbutton').prop('disabled',true);
            //         $('#abutton').prop('disabled',false);
            //         $('#abutton').removeClass('disabled');
            //         $('#gbutton').addClass('disabled');
            //         $('#noCharge').prop("checked",false);
            //     }
            // });
            // $('#noCharge').change(function(){
        
            //     if ($(this).is(":checked")) {
            //         // Merchant wants good. No approve button
            //         $('#goods').prop('checked',true);
            //         $('#abutton').prop('disabled',true);
            //         $('#gbutton').prop('disabled',false);
            //         $('#gbutton').removeClass('disabled');
            //         $('#abutton').addClass('disabled');
            //         // $()
            //     }else{
            //         // $('#goods').prop('checked',false);
            //         $('#gbutton').prop('disabled',false);
            //         $('#abutton').prop('disabled',true);
            //         $('#gbutton').removeClass('disabled');
            //         $('#abutton').addClass('disabled');
            //     }
            // });

            // $('input[type=radio]').change(function(){
            //     $c=0;
            //     $('.rejected').each(function(){
            //         if ($(this).is(":checked")) {}
            //         else{$c++;}
            //     });
            //     // console.log($c);
            //     if ($c == 0) {
            //          $('#gbutton').prop('disabled',true);
            //         $('#abutton').prop('disabled',false);
            //         $('#abutton').removeClass('disabled');
            //         $('#abutton').removeClass('btn-approval');
            //         $('#abutton').addClass('btn-warning');
            //         $('#abutton').text('Confirm');
            //         $('#gbutton').addClass('disabled');
            //         $('#goods').prop('disabled',true);
            //         $('#noCharge').prop('disabled',true);
            //         }
            //     else{
            //          $('#gbutton').prop('disabled',true);
            //         $('#abutton').prop('disabled',true);
            //         $('#abutton').removeClass('disabled');
            //         $('#abutton').removeClass('btn-warning');
            //         // $('#abutton').addClass('btn-approval');
            //         $('#abutton').text('Confirm');
            //         $('#gbutton').addClass('disabled');
            //         $('#goods').prop('disabled',false);
            //         $('#goods').prop('checked',false);
            //         $('#noCharge').prop('disabled',false);
            //         $('#noCharge').prop('checked',false);

            //     }
            // });
    
});
</script>