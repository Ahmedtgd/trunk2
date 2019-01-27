<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	 <head>
	  <title>OpenSupermall.com</title>
		<style type="text/css">
			#terms {      
			 
			  height: 400px;
			  overflow-y: scroll;
			}
		</style>
	 </head>
    <!-- <div class="panel panel-default"> -->
    <!-- <div class="panel-heading" style="text-align:center;font-weight:bold;font-size:1.3em;">Terms & Conditions</div> -->
    <!-- <div class="panel-body" style="text-align:justify;"> -->
    <div id="terms">{!! $content !!}<br><br>
		@if($role == "buy")
			<button type="button" class="btn btn-default pull-right btn-danger" data-dismiss="modal" data-target="tcModal">Close</button>
		@else
			<button type="button" class="btn btn-default pull-left btn-danger" data-dismiss="modal" data-target="tcModal">Cancel</button>

		<!-- <button class="action next btn btn-info pull-right">Next</button> -->
			<button class="action submit btn btn-success pull-right" id="accept">Accept</button>
		@endif
	</div>
    <!-- <button class="action back btn btn-info pull-right" style="margin-right:10px;">Back</button>  -->
    <!-- </div> -->
    <!-- </div> -->
    
 <script type="text/javascript">
   $(document).ready(function(){
    $('#terms').scroll(function () {
      // alert("lol");
    if ($(this).scrollTop() == $(this)[0].scrollHeight - $(this).height()) {
        $('#accept').attr('disabled',false);
    }
});
    $('#accept').click(function(){

      $('.very-unique-button').attr('disabled',false);
      $('#tcModal').toggle('modal');
      // alert("lol");
      $('#form').submit();
      $('#registe_rForm').submit();
    });
   });
 </script>
</html>


