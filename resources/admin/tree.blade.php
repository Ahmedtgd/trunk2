<!DOCTYPE html>
<html>
<head>
  <title>Tree View</title>
{{--     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> --}}
         <link rel="stylesheet" href="{{URL::asset('adminStyle/css/bootstrap.css')}}">
   
  
</head>

<body>
<div class="container" style="margin-top:30px;">
    <div class="row">


       <div class="col-sm-3 ">
        <b>Administrator</b> <br>
         <b>  Merchent Approval</b><br>
          <b> Table Management</b><br>

           <ul class="nav bs-sidenav well">        
                <li>
                  <a href="#panels">Panels</a>
                  <ul class="nav ar_side_bar">
                    <li><a href="#panels-basic">Basic example</a></li>
                    <li><a href="#panels-heading">Panel with heading</a></li>
                    <li><a href="#panels-alternatives">Contextual alternatives</a></li>
                    <li><a href="#panels-tables">With tables</a>
                    </li><li><a href="#panels-list-group">With list groups</a>
                  </li></ul>
                </li>
                <li><a href="#wells">Wells</a></li>                          
             </ul>
        </div>

      
        <div class="col-md-9 equal_to_sidebar_mrgn">
            <b>Category Management</b> <br>
            <ul id="tree3" class="ar_border">
                <li class="row"><div class="li_hover_ar set_pos_ar">TECH  <span class="show_on_hover pull-right"><i href="#cat-modal" class="glyphicon glyphicon-plus" data-toggle="modal"></i> <i href="#cat-modal" class="glyphicon glyphicon-pencil" data-toggle="modal"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>


                 <li class="row"><div class="li_hover_ar set_pos_ar">TECH  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>

                <li class="row"><div class="li_hover_ar set_pos_ar">Royal  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>





                <li class="row"><div class="li_hover_ar set_pos_ar">Phelebotomist  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>





                <li class="row"><div class="li_hover_ar set_pos_ar">Lab Technician  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>




        <li class="row"><div class="li_hover_ar set_pos_ar">Requistion Form  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>



        <li class="row"><div class="li_hover_ar set_pos_ar">Multiple address  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>




        <li class="row"><div class="li_hover_ar set_pos_ar">Insurance Policy <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>




        <li class="row"><div class="li_hover_ar set_pos_ar">Physian Form  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>



                 <li class="row"><div class="li_hover_ar set_pos_ar">Uet  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>



                 <li class="row"><div class="li_hover_ar set_pos_ar">Science  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>


                 <li class="row"><div class="li_hover_ar set_pos_ar">Abdul  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>

                    <ul>
                        <li class="row li_hover_ar">Company Maintenance  <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                        <li class="row"> <div class="li_hover_ar set_pos_ar">Employees    <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                            <ul>
                                <li class="row "><div class="li_hover_ar set_pos_ar">Reports <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></div>
                                    <ul>
                                        <li class="row li_hover_ar">Report1 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report2 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                        <li class="row li_hover_ar">Report3 <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                                    </ul>
                                </li>
                                <li class="row li_hover_ar">Employee Maint.<span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                            </ul>
                        </li>
                        <li class="row li_hover_ar">Human Resources <span class="show_on_hover pull-right"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-pencil"></i> <i class="glyphicon glyphicon-remove"></i></span></li>
                    </ul>
                </li>
               
            </ul>
        </div>
    </div>
</div>
<div class="modal fade" id="cat-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>



<script src="{{ URL::asset('adminStyle/js/bootstrap.js')}}"></script>

