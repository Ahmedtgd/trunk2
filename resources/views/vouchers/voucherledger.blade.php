  <div style="display:grid;" class="pnl-content">               
                    <div class="table-responsive" style="margin-bottom: 28px;">
                        <!--         <h2>Voucher Management
                                </h2>
                        -->        <table class="table table-bordered" cellspacing="0"
                                          id="Voucher_ledger" style="width:100% !important;">
                            <thead style="color:white">
                                <tr style="">
                                    <td class="text-center bsmall no-sort voucher_list"
                                        style="">No.</td>
                                    <td style="color:white" class="text-center voucher_list"
                                        >Date</td>
                                    <td style="color:white" class="text-center voucher_list"
                                        >Branch</td>
                                    <td class="text-center voucher_list"
                                        >Staff Name</td>
                                    <td class="text-center voucher_list"
                                        >Staff ID</td>                  
                                </tr>
                            </thead>

                            <tbody>
                                 @foreach($voucher_list as $selluser)
                                <tr>
                                    <td 
                                        style="text-align: center;">{{$selluser->id}}</td>
                                    <td 
                                        style="text-align: center;">
                                        <?php 
                                        if($selluser->created_at != "" &&  $selluser->created_at != '0000-00-00 00:00:00'){
                                            echo date('dMy H:i:s',  strtotime($selluser->created_at));
                                            
                                        }
                                        ?>
                                    </td>
                                    <td 
                                        style="text-align: center;">@if(isset($selluser->location)){{$selluser->location}}@endif</td>
                                    <td
                                        style="text-align: center;">{{$selluser->first_name}} {{$selluser->last_name}}</td>
                                    <td 
                                        style="text-align: center;">{{sprintf('%010d',$selluser->buyer_id)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>