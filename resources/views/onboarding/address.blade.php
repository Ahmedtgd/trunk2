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
                  <option value="">Select a state</option>
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
                            s_error=[];
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