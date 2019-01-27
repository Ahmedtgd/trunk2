@extends("common.default")
@section("content")
    @include('common.sellermenu')

    <style>
        button.btn.btn-red.btn-mid{
            margin-bottom: 3px;
            font-size: 14px;
            padding: 8px 60px;
            background-color: #f50909b8;
            width: 100%;
            border-radius: 15px;
        }
        .select2-container{width: 25% !important;}
        .select2-container--default .select2-search--dropdown .select2-search__field{display: none;}
    </style>
    <div class="container" style="margin-top:30px;">
        <div class=" ">
        <style>
            #paysliptable{
                border-collapse:collapse;
            }
            #paysliptable td{
                padding: 3px;
                margin: 0;
                text-align: center;
            }
            .inner_table td{
                padding: 1px;
            }
            .Apply{
                background-color: #FF9900;
                color: white;
                border: 1px solid black;
                padding: 5px 18px;
            }
            #weeksModal {
                z-index: 999;
            }
            #weeks_Modal {
                z-index: 4000;
            }
        </style>



         <div class="row" style="margin-bottom: 20px;">
             <div class="col-md-6">
                 <table style="width:100%;">
                     <tr>
                         <td width="25%">
                             <table class="inner_table">
                                 <tr>
                                     <td></td>
                                     <td style="color: red;">start</td>
                                     <td style="color: red;">end</td>

                                 </tr>
                                 @if($shifts)
                                     @foreach($shifts as $shift)
                                 <tr>
                                     <td  id="bg{{$shift->id}}" style="color: white; width: 20%;text-align: center;">{{$shift->name}}</td>
                                     <td><input id="start{{$shift->id}}" onfocus="t_erase({{$shift->id}})" type="text"  name="" value="{{$shift->start}}"></td>
                                     <td><input id="stop{{$shift->id}}" onfocus="t_erase({{$shift->id}})" type="text" name="" onblur="validate({{$shift->id}})" value="{{$shift->end}}"></td>
                                     <span style="color: #ff0000; display: none;" id="warning{{$shift->id}}" >Invalid Time Format</span>
                                 </tr>
                                @endforeach
                                     @else
                                     <tr>
                                     <td style="background-color: #C3D69B; color: white; width: 20%;text-align: center;">Full Day</td>
                                     <td><input id="start1" onfocus="t_erase(1)" type="text" name="" value=""></td>
                                     <td><input id="stop1" onfocus="t_erase(1)" type="text" onblur="store_shift(1)" name=""  value=""></td>
                                         <span style="color: #ff0000; display: none;" id="warning1" > Input is out of Percentage Range</span>
                                     </tr>
                                     <tr>
                                         <td style="background-color: #99CC00;color: white; width: 20%;text-align: center;">First</td>
                                         <td><input id="start2" onfocus="t_erase(2)" type="text" name="" value=""></td>
                                         <td><input id="stop2" onfocus="t_erase(2)" type="text" onblur="store_shift(2)"  name="" value=""></td>
                                         <span style="color: #ff0000; display: none;" id="warning2" > Input is out of Percentage Range</span>
                                     </tr>
                                     <tr>
                                         <td style="background-color: #33CCCC;color: white; width: 20%;text-align: center;">Second</td>
                                         <td><input id="start3" onfocus="t_erase(3)" type="text" name="" value=""></td>
                                         <td><input id="stop3" onfocus="t_erase(3)" type="text" onblur="store_shift(3)" name="" value=""></td>
                                         <span style="color: #ff0000; display: none;" id="warning3" > Input is out of Percentage Range</span>
                                     </tr>
                                     <tr>
                                         <td style="background-color: #215968;color: white; width: 20%;text-align: center;">Third</td>
                                         <td><input id="start4" onfocus="t_erase(4)" type="text" name="" value=""></td>
                                         <td><input id="stop4" onfocus="t_erase(4)" type="text" onblur="store_shift(4)" name="" value=""></td>
                                         <span style="color: #ff0000; display: none;" id="warning4" > Input is out of Percentage Range</span>
                                     @endif
                             </table>
                         </td>
                     </tr>
                 </table>

             </div>
             <div class="col-md-6" style="text-align: right;">
                 <p style="color:#1DFF1D"><a onclick="weekly_routine()">Weekly Routine</a></p>

                 <p>
                     <div class="sellerbutton" style="background-color: #1DFF1D; color:white; float: right;">
                         <span>Apply</span>
                     </div>
                     <div class="sellerbutton" data-toggle="modal" data-target="#myModal" style="background-color: #1DFF1D; color:white; float: right;">
                         <span>Month</span>
                     </div>
                    <!-- <button class="Apply">Apply</button>to other branches-->
                 </p>
             </div>
         </div>
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Select Month</h4>
                        </div>
                        <div class="modal-body">
                           <div class="row ">
                               <div class="col-md-2">
                                 <button type="button" onclick="select_month(1)" style="text-justify: auto; text-align: center;background-color: #00dd00; color: #fff;" class="btn sellerbutton" > January<br> </button>
                               </div>
                               <div class="col-md-2">
                                   <button type="button" onclick="select_month(2)" style=" text-align: center; background-color: #00dd00; color: #fff;" class="btn sellerbutton" > February </button>
                               </div>
                               <div class="col-md-2">
                                   <button type="button" onclick="select_month(3)" style="text-align: center;background-color: #00dd00; color: #fff;" class="btn sellerbutton" > March </button>
                               </div>
                               <div class="col-md-2">
                                   <button type="button" onclick="select_month(4)" style="text-align: center;background-color: #00dd00; color: #fff;" class="btn sellerbutton" > April </button>
                               </div>
                               <div class="col-md-2">
                                   <button type="button" onclick="select_month(5)" style="text-align: center; background-color: #00dd00; color: #fff;" class="btn sellerbutton" > May </button>
                               </div>
                               <div class="col-md-2">
                                   <button type="button" onclick="select_month(6)" style="text-align: center;background-color: #00dd00; color: #fff;" class="btn sellerbutton" > June </button>
                               </div>

                           </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-2">
                                    <button type="button" onclick="select_month(7)" style="text-align: center; background-color: #00dd00; color: #fff;" class="btn sellerbutton" > July </button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="select_month(8)" style="text-align: center; background-color: #00dd00; color: #fff;" class="btn sellerbutton" > August </button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="select_month(9)" style="text-align: center; background-color: #00dd00; color: #fff;" class="btn sellerbutton" > September </button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="select_month(10)" style="text-align: center;background-color: #00dd00; color: #fff;" class="btn sellerbutton" > October </button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="select_month(11)" style="text-align: center; background-color: #00dd00; color: #fff;" class="btn sellerbutton" > November </button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="select_month(12)" style="text-align: center; background-color: #00dd00; color: #fff;" class="btn sellerbutton" > December </button>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
</div>
                </div>

            <div id="weeks_Modal"  class="modal fade" role="dialog">
                <div class="modal-dialog" style="width: 80%;">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Select Weeks</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                            <label class="checkbox-inline"><input type="checkbox" value="">{{$start_of_year}} - {{$weeks[0]}}</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[1]}} - {{$weeks[2]}}</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[3]}} - {{$weeks[4]}}</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[5]}} - {{$weeks[6]}}</label>
                                </div>
                            </div><hr>
                            @for($i = 7; $i < 87; $i++)
                                <div class="row">
                                    <div class="col-md-3">
                                <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[$i]}} - {{$weeks[$i+1]}}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[$i+2]}} - {{$weeks[$i+3]}}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[$i+4]}} - {{$weeks[$i+5]}}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[$i+6]}} - {{$weeks[$i+7]}}</label>
                                    </div>
                                </div>
                                <p style="display: none;">{{$i = $i+7}}</p><hr>

                                @endfor
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[87]}} - {{$weeks[88]}}</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[89]}} - {{$weeks[90]}}</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[91]}} - {{$weeks[88]}}</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline"><input type="checkbox" value="">{{$weeks[89]}} - {{$end_of_year}}</label>
                                </div>

                            </div><hr>
                            <hr>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-12">

                    <h2>Manager Scheduler</h2>
                    <select>
                      @foreach($branches as $branch)
                          <option>
                              {{$branch->location}}
                          </option>

                          @endforeach
                    </select>

                </div>




        <table  style="width:100% !important;" class="table table-bordered text-center"  id="raw-datatable">
            <thead style="color:white">
                <tr>
                    <td style="display: none;"></td>
                    <td width="20%" style="background-color: #3366FF; color:white;"><b>Day</b></td>
                    <td width="20%" style="background-color: #3366FF; color:white;"><b>Date</b></td>
                    <td width="20%" style="background-color: #66FF66; color:white;"><b>Full Force</b></td>
                    <td width="15%" width="30%" style="background-color:#66FF66;color:white"><b>Working</b></td>
                    <td width="15%" width="30%" style="background-color:#66FF66;color:white">Status</td>
                </tr>
            </thead>
            <tbody>
            <?php $count = 0 ?>
            @foreach($days as $day)
                <tr>
                    <td id="count" style="display: none;"><?php echo $count ?> </td>
                    <td><?php  $day_of_week = strtotime($day);
                        echo date('D', $day_of_week);
                        $day_of_week = strtotime($day);
                        ?></td>
                    <td id="date{{$count}}" ><?php  $date = strtotime($day);
                        echo date('d-M-Y', $date);
                        $date = strtotime($day);
                        ?></td>
                    <td id="fullforce{{$count}}"  onclick="change({{$count}})" >@if($fullforce[$count]){{$fullforce[$count]->fullforce}} @else 0 @endif</td>
                    <td id="working{{$count}}" onclick="manager_working({{$count}});"><a>@if($works[$count]){{$works[$count]->working}} @else 0 @endif</a></td>
                    <td>@if($status[$count]){{$status[$count]->status}} @else Not Assigned @endif</td>
                </tr>
                <?php $count++ ?>
            @endforeach
            </tbody>

        </table>

        <div class="modal fade" id="weekly_routineModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="width:40%">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Weekly Routine</h2>
                    </div>
                    <div id="weekly_routineBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="manager_workingModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="width:60%">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Workings</h2>
                    </div>
                    <div id="manager_workingBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>
        </div>
    </div>

@stop
@section('scripts')
    <script>
        function set_schedule(id){
          var  $date = $('#date'+id).text();
          var  $working = $('#working'+id).text();
           var $fullforce = $('#fullforce'+id).text();
            var digits = new RegExp('^\\d{1,10}$');
            if (digits.test($working) && digits.test($fullforce)) {
                console.log("Yes");
                $.ajax({
                    type: "POST",
                    url: JS_BASE_URL+"/manager/mgr_schedule",
                    data:{"date":$date,"working" : $working, "fullforce":$fullforce},
                    success: function( data ) {
                        console.log(data)
                    }
                });
            }else{

              //  show($error);
            }

        }

        function show(element) {  element.css("display","block"); }
        function hide(element) {  element.css("display","none"); }
        function update_shift($id)
        {
            var $start = $("#start"+$id).val();
            var $stop = $("#stop"+$id).val();


            $.ajax({
                type: "POST",
                url: JS_BASE_URL+"/manager/update_shift",
                data:{"start":$start,"stop" : $stop,"id": $id},
                success: function( data ) {
                    console.log(data)
                }
            });
        }
        function store_shift($id)
        {
            var $start = $("#start"+$id).val();
            var $stop = $("#stop"+$id).val();


            $.ajax({
                type: "POST",
                url: JS_BASE_URL+"/manager/store_shift",
                data:{"start":$start,"stop" : $stop,"id": $id},
                success: function( data ) {
                    console.log(data)
                }
            });
        }
        function validate($id) {
                var $start = $("#start"+$id).val();
                var $stop = $("#stop"+$id).val();
                var time = new RegExp('([01]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]$)');
            if (time.test($start) && time.test($stop)) {
                    update_shift($id);
                    store_shift($id);
                }else{
                    var $error = $('#warning'+$id);
                    show($error)
                }

        }
        function t_erase(num){
            var $error = $('#warning'+num);
            hide($error);
        }

        function change(date) {
            var $this = $('#fullforce'+date);
            var $input = $('<input  >', {
                value: $this.text(),
                type: 'text',
                blur: function() {
                    $this.text(this.value);

                    set_schedule(date);
                },
                keyup: function(e) {
                    if (e.which === 13) $input.blur();

                }

            }).appendTo( $this.empty() ).focus();

        };
        $(document).ready(function(){
             $('#raw-datatable').DataTable();
            $('#bg1').css("background-color"," #00FF00");
            $('#bg2').css("background-color"," #99CC00");
            $('#bg3').css("background-color"," #33CCCC");
            $('#bg4').css("background-color"," #cc7a21");
        });
        $(document).delegate( '#weeksModal', "click",function (event) {

            $("#weeks_Modal").modal("show");

        });
        function weekly_routine(){
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/manager/weekly_routine",
                success: function( data ) {
                    $("#weekly_routineBody").html(data);
                    $('#weekly_routineModal').modal('show');
                }
            });
        }
        function manager_working(id){
            $date = $("#date"+id).text();
            ///alert($date);
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/manager/manager_working/",
                success: function( data) {
                    $("#manager_workingBody").html(data);
                    $("#manager_workingBody #date_work").html($date);
                    $("#manager_workingBody #counter").html(id);
                    $('#manager_workingModal').modal('show');

                }
            });
        }
        function select_month(id){
            $('#myModal').modal('hide');
               var url =  JS_BASE_URL+"/manager/schedule/"+id;
               window.location = url;
        }

    </script>
    <script type="text/javascript">
        $(function () {
            $(".clicked").dblclick(function (e) {
                e.stopPropagation();      //<-------stop the bubbling of the event here
                var currentEle = $(this);
                var value = $(this).html();
                updateVal(currentEle, value);
            });
        });

        function updateVal(currentEle, value) {
            $(currentEle).html('<input class="thVal" type="text" value="' + value + '" />');
            $(".thVal").focus();
            $(".thVal").keyup(function (event) {
                if (event.keyCode == 13) {
                    $(currentEle).html($(".thVal").val().trim());
                }
            });

            $(document).click(function () { // you can use $('html')
                $(currentEle).html($(".thVal").val().trim());
            });
        }
    </script>


@stop