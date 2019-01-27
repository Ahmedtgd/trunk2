/**
 * Created by Khakan Ali on 11/27/2015.
 */
//this code already moved in custom.js file
$(document).ready(function () {
    var item_id;
    $('#display-product-section').on('click','.p-img-bordered',function(){
        if(splitclass($(this).attr('class'))[1] == 'selected-pro'){
            $(this).removeClass('selected-pro');
        }else {
            $('.selected-pro').each(function(){
                $(this).removeClass('selected-pro');
            });
            $(this).addClass('selected-pro');
        }
    });
 /*   $('#loginForm').on('submit',function(e){
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data:$(this).serialize(),
            cache: false,
            success: function(responseData, textStatus, jqXHR) {
                if(responseData == "false"){
                    $('#error-msg').html('<h5>Invalid user name or password!</h5>')
                }
                else{
                    alert("you are login");
                }
            },
            error: function(responseData, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });*/
});

function splitclass(data){
    return data.split(' ');
}

