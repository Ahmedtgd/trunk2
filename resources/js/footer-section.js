 $( ".save-form" ).submit(function( e )  {

      e.preventDefault();  

    var $form = $(this);
    var $alerts =  $(this).find(".mainAlert");
    

        
        $form.find('.sk-circle').show();


       var data = { content: $form.find('.summernote').summernote('code') , type: $form.attr('id') };

     $.ajax({
        url: $form.attr('action'),
        type:'POST',
        data: data,
        dataType: "json",
        success: function(data){
        $form.find('.sk-circle').hide();
          
          if(data.response && data.type){
                 $alerts.attr("class" ,"mainAlert alert alert-" + data.type); 
                 $alerts.find(".alert-content").html(data.response);
                 $alerts.fadeIn("slow");
                  if(data.type == 'danger'){
                         $form.find(".actions").fadeIn("slow");
                  }
             }

            if(data.code){
                 $("body").append("<script>" + data.code + "</script>"); 
            }
        }
      });
 
});