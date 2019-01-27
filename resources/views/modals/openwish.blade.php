<style type="text/css">
    @media only screen and (max-width: 299px) {
        .modal_responsive{
            width: 100% !important;
        }
        #custom_message{
            width: 100% !important;
        }
        .btn-bl{
            max-width: 80% !important;
        }

    }
    @media only screen and (min-width: 300px) and (max-width: 350px) {
        .modal_responsive{
            width: 100% !important;
        }
        #custom_message{
            width: 130% !important;
        }
        .btn-bl{
            max-width: 80% !important;
            }

    }
     @media only screen and (min-width: 351px) and (max-width: 450px) {
        .modal_responsive{
            width: 100% !important;
        }
        #custom_message{
            width: 170% !important;
        }
        .btn-bl{
            max-width: 80% !important;
            }

    }
     @media only screen and (min-width: 451px) and (max-width: 600px) {
        .modal_responsive{
            width: 100% !important;
        }
        #custom_message{
            width: 200% !important;
        }
        .btn-bl{
            max-width: 80% !important;
            }

    }
    #custom_message{
        width: 540px;
    }
    .btn-social{
        max-width: 100% !important; 
    }
</style>

<div id="socialModal_openwish" class="modal fade" role="dialog">
  <div class="modal-dialog modal_responsive">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">OpenWish</h4>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col-xs-12 col-sm-12" style="margin:5px;">
        <label>Please enter a custom message.
        <textarea class="form-control custom_message" id="custom_message"></textarea>
        </label><br>
        <a class="btn  btn-social btn-facebook add-to-wishlist" id="add-to-wishlist">
        <i class="fa fa-facebook"></i> Share on Facebook
      </a>
      </div>
      </div>
      </div>
      <input type="hidden" id="owish_product_id" value="">
     <input type="hidden" id="owish_type" value="">
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

{{-- AJAC CALL FOR SMM SAVE --}}
 <script type="text/javascript">
 $(document).ready(function(){
    $('.show_openwish_modal').click(function(){
        $('#socialModal_openwish').modal('show');
        $('#owish_product_id').val($(this).data('item-id'));
        $('#owish_type').val($(this).data('item-type'));
    });
        $(".add-to-wishlist").click(function () {
            // alert("aaaaaaa");

            // $(this).children('i').removeClass('hidden');
             
            var dt=$('#bspinner');
            dt.removeClass('hidden');
            var itemId = $('#owish_product_id').val();
            var type = $('#owish_type').val();
            var custom_message=$('.custom_message').val();
            // alert(custom_message);
            $('#socialModal_openwish').modal('hide');
            console.log("Item ID "+itemId+type);
            $.ajax({
                url:JS_BASE_URL+'/check/login',
                type:'GET',
                success:function (response) {
                    if (response.status=="success") {

                    $.ajax({
                    url: JS_BASE_URL + '/add_to_wish_list_new',
                    type: 'GET',
                    data: {itemId: itemId,type:type,custom_message:custom_message},
                    success: function (response) {
                        console.log(response.message);
                        if(response.ok){
                            toastr.info(response.message);
                        }
                        if(response==-1){
                            rs = response.url;
                            toastr.info('<div><p>You are not registered for OpenWish. Would you like to register now?</p></div><div><button type="button" id="okBtn"  class="btn btn-primary">Yes</button><button type="button" id="surpriseBtn" class="btn" style="margin: 0 8px 0 8px">No</button></div>');
                            $('#surpriseBtn').click(function(){
                                toastr.clear();
                                dt.children('i').addClass('hidden');
                            });
                            $('#okBtn').click(function(){
                                toastr.clear();
                                newwindow = window.open(JS_BASE_URL+"/fb/login", 'Register', 'height=400,width=auto');
                                if (window.focus) {
                                            newwindow.focus()
                                        }
                                dt.children('i').addClass('hidden');
                                return false;
                            });

                        }
                        if (response.short_message=="Token Failure") {
                            rs = response.url;
                            toastr.info('<div><p>Your access token for the social media account has expired. Would you like to register again?</p></div><div><button type="button" id="okBtn"  class="btn btn-primary">Yes</button><button type="button" id="surpriseBtn" class="btn" style="margin: 0 8px 0 8px">No</button></div>');
                            $('#surpriseBtn').click(function(){
                                toastr.clear();
                                dt.children('i').addClass('hidden');
                            });
                            $('#okBtn').click(function(){
                                toastr.clear();
                                newwindow = window.open(JS_BASE_URL+"/fb/login", 'Register', 'height=400,width=auto');
                                if (window.focus) {
                                            newwindow.focus()
                                        }
                                dt.children('i').addClass('hidden');
                                return false;
                            });
                        }
                        if (response.status=="success") {
                            toastr.info(response.long_message);
                            dt.children('i').addClass('hidden');
                        }
                    }
                    });
                    }
                    // Success ends
                    if (response.status=="failure") {
                        dt.children('i').addClass('hidden');
                        toastr.info(response.long_message);
                    }     
                }
            });

        });
 });
</script>