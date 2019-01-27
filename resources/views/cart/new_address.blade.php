<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>Onboarding</title>

      <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<script src="{{asset('/js/jquery.min.js')}}"></script>

  <!-- Latest compiled and minified JavaScript -->
      <script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
<style type="text/css">
    
</style>
 </head>
 <body>
   
   <div class="container">
  <br><br>
    <div class="col-md-6">    

    <!-- Copy -->
              <div class="panel-body">
            <label for="line1">Address</label>
            <input type="text" name="line1" id="line1" class="form-control" >
            <!-- Country -->
            <label for="country">Country</label>
            <select id="country" class="form-control" disabled>
              <option selected> Malaysia</option>
            </select>
            <!-- State -->
            <label for="state">State</label>
            <select class="form-control" id="state" name="state">
                @if(isset($states))
                  <option>Select a state</option>
                  @foreach($states as $s)
                    <option value="{{$s->id}}">{{ucfirst($s->name)}}</option>
                  @endforeach
                @endif
            </select>
            {{-- City --}}
            <label for="city">City</label>
              <select class="form-control" id="city" disabled>
                
            </select>
            <label for="postcode">PostCode</label>
            <input type="text" name="postcode" id="postcode" class="form-control">
          </div>

          <script type="text/javascript">
          JS_BASE_URL="{{url()}}"
                        $('#state').on('change', function () {
                       
                var val = $(this).val();
                if (val != "") {
                    // var text = $('#state option:selected').text();
                    // $('#states_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/city',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#city').html(responseData);
                            }
                            else {
                                $('#city').empty();

                                $('#select2-city-container').empty();
                            }
              if ($('#deliverycheck').is(':checked')){
                //Nothing
              } else {
                document.getElementById('city').disabled = false;
              }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-city-container').empty();
                    $('#city').html('<option value="" selected>Choose Option</option>');
                }
            });
          </script>
    <!--  -->
<button type="button" class="btn btn-default pull-left btn-danger" data-dismiss="modal" data-target="onboardModal">Cancel</button>

    <button class="action submit btn btn-success pull-right" id="onboard">Update</button>


    
   </div> 
   </div>

 </body>

 <script type="text/javascript">
   $(document).ready(function(){
      $('#onboard').click(function(){
        var url="{{url()}}"+"/cart/new/address";
        var type="POST";
        $.ajax({
          url:url,
          type:type,
          data:{
          city_id:$('#city').val(),
          postcode:$('#postcode').val(),
          line1:$('#line1').val(),
          },
          success:function(r){
            if (r.status=="success") {
              $('#address_id').attr('value',r.short_message);
              location.reload();
            }
          }
        });
      });
   });
 </script>
</html>
