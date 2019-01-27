          <div class="accordion-group">
            <div class="accordion-heading">
                <button type="button" id="btn_status" class="accordion-toggle btn btn-info" data-toggle="collapse" href="#collapseOne">
                    <i class="glyphicon glyphicon-chevron-right" style="float:left"></i> Global
                </button>
            </div>
            <div id="collapseOne" class="accordion-body collapse in">
                <div class="accordion-inner" style="overflow:auto">
                    <table class="table">
                          <thead class="thead-default">
                            <tr>
                              <th style="background-color:#ffffff">#</th>
                              <th>Year</th>
                              <th>Month</th>
                              <th>Day</th>
                              <th>Hour</th>
                              <th>Minute</th>
                              <th>Second</th>
                            </tr>
                          </thead>
                          <tbody id="updateSection">
                            <tr>
                              <th scope="row">Login</th>

                              @foreach($yrLogins as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($mnLogins as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($dayLogins as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($hrLogins as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($minLogins as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach                              
                              @foreach($secLogins as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach

                            </tr>
                            <tr>
                              <th scope="row">New User Registration</th>

                              @foreach($yrUserReg as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($mnUserReg as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($dayUserReg as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($hrUserReg as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($minUserReg as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach                              
                              @foreach($secUserReg as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach


                            </tr>
                            <tr>
                              <th scope="row">Account Termination</th>
                              
                                @foreach($yrAccTermination as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnAccTermination as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayAccTermination as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrAccTermination as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minAccTermination as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secAccTermination as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach

                            </tr>
                            <tr>
                              <th scope="row">Transactions</th>

                                @foreach($yrTransaction as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnTransaction as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayTransaction as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrTransaction as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minTransaction as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secTransaction as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach

                            </tr>
                            <tr>
                              <th scope="row">Clicks</th>
                                @foreach($yrPageView as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnPageView as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayPageView as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrPageView as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minPageView as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secPageView as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach
                            </tr>
                          </tbody>
                    </table>                  
                </div>
            </div>
        </div>
          
        <div class="accordion-group">
            <div class="accordion-heading">
                <button type="button" id="btn_status2" class="accordion-toggle btn btn-info" data-toggle="collapse" href="#collapseTwo">
                    <i class="glyphicon glyphicon-chevron-right" style="float:left"></i> Malaysia
                </button> 
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner" style="overflow:auto">
                    <table class="table">
                          <thead class="thead-default">
                            <tr>
                              <th style="background-color:#ffffff">#</th>
                              <th>Year</th>
                              <th>Month</th>
                              <th>Day</th>
                              <th>Hour</th>
                              <th>Minute</th>
                              <th>Second</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">Login</th>

                              @foreach($yrLoginsMalay as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($mnLoginsMalay as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($dayLoginsMalay as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($hrLoginsMalay as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($minLoginsMalay as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach                              
                              @foreach($secLoginsMalay as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach

                            </tr>
                            <tr>
                              <th scope="row">New User Registration</th>

                              @foreach($yrUserRegMalay as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($mnUserRegMalay as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($dayUserRegMalay as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($hrUserRegMalay as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($minUserRegMalay as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach                              
                              @foreach($secUserRegMalay as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach

                            </tr>
                            <tr>
                              <th scope="row">Account Termination</th>

                                @foreach($yrAccTerminationMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnAccTerminationMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayAccTerminationMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrAccTerminationMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minAccTerminationMalay as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secAccTerminationMalay as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach

                            </tr>
                            <tr>
                              <th scope="row">Transactions</th>

                                @foreach($yrTransactionMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnTransactionMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayTransactionMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrTransactionMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minTransactionMalay as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secTransactionMalay as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach

                            </tr>
                            <tr>
                              <th scope="row">Clicks</th>
                                @foreach($yrPageViewMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnPageViewMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayPageViewMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrPageViewMalay as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minPageViewMalay as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secPageViewMalay as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach
                            </tr>
                          </tbody>
                    </table>                    
                </div>
            </div>
        </div>
          
        <div class="accordion-group">
            <div class="accordion-heading">
                <button type="button" id="btn_status3" class="accordion-toggle btn btn-info" data-toggle="collapse" href="#collapsetwo">
                    <i class="glyphicon glyphicon-chevron-right" style="float:left"></i> Hong Kong
                </button> 
            </div>
            <div id="collapsetwo" class="accordion-body collapse">
                <div class="accordion-inner" style="overflow:auto">
                    <table class="table">
                          <thead class="thead-default">
                            <tr>
                              <th style="background-color:#ffffff">#</th>
                              <th>Year</th>
                              <th>Month</th>
                              <th>Day</th>
                              <th>Hour</th>
                              <th>Minute</th>
                              <th>Second</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">Login</th>

                              @foreach($yrLoginsHongKong as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($mnLoginsHongKong as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($dayLoginsHongKong as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($hrLoginsHongKong as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($minLoginsHongKong as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach                              
                              @foreach($secLoginsHongKong as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach

                            </tr>
                            <tr>
                              <th scope="row">New User Registration</th>

                              @foreach($yrUserRegHongKong as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($mnUserRegHongKong as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($dayUserRegHongKong as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($hrUserRegHongKong as $value)
                              <td>{{ round($value->avg) }}</td>
                              @endforeach                              
                              @foreach($minUserRegHongKong as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach                              
                              @foreach($secUserRegHongKong as $value)
                              <td>{{ round($value->total) }}</td>
                              @endforeach

                            </tr>
                            <tr>
                              <th scope="row">Account Termination</th>

                                @foreach($yrAccTerminationHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnAccTerminationHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayAccTerminationHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrAccTerminationHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minAccTerminationHongKong as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secAccTerminationHongKong as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach

                            </tr>
                            <tr>
                              <th scope="row">Transactions</th>

                                @foreach($yrTransactionHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnTransactionHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayTransactionHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrTransactionHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minTransactionHongKong as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secTransactionHongKong as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach

                            </tr>
                            <tr>
                              <th scope="row">Clicks</th>
                                @foreach($yrPageViewHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($mnPageViewHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($dayPageViewHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($hrPageViewHongKong as $value)
                                <td>{{ round($value->avg) }}</td>
                                @endforeach                              
                                @foreach($minPageViewHongKong as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach                              
                                @foreach($secPageViewHongKong as $value)
                                <td>{{ round($value->total) }}</td>
                                @endforeach
                            </tr>
                          </tbody>
                    </table>                    
                </div>
            </div>
        </div>                      

       