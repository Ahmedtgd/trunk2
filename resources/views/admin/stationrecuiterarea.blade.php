<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Country</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            .table-wrapper{width: 100%;margin: auto 0;margin-top: 35px;}
            table{margin: auto 0;width: 100%}
            thead {
                float: left;   
                border: 1px solid #000;
                width: 20%;
            }
            thead tr{width: 100%;float: left;}
            thead th {
                display: block;   
                border:none;
                float: left;
                width: 100%;
            }
            .table > thead > tr > th {
                border-bottom: 1px solid #000;
                border-top:none;
                padding: 14px;
                width: 100%;
                float: left;
            }
            tbody {
                float: left;
                border-right:  1px solid #000; 
                border-top:  1px solid #000; 
                border-bottom:  1px solid #000;
                width: 80%;
            }
           tbody tr{width: 100%;float: left;border-bottom: 1px solid #000;
                border-top:none;}
            tbody td{display: block;padding: 13.5px!important;}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="table-wrapper">
                        <table class="table table-hover">
                            <thead class="pull-left">
                                <tr>
                                    <th>Country</th>

                                </tr>
                                <tr>
                                    <th>State</th>

                                </tr>
                                <tr>
                                    <th>City</th>
                                </tr>
                                <tr>
                                    <th>Area</th>
                                </tr>
                            </thead>
                            <tbody class="pull-left">
                                <tr>
                                    <td class="text-capitalize">malasiya</td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize">malasiya</td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize">malasiya</td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize">malasiya</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary close-btn">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            jQuery('.close-btn').click(function (){
                window.close();
            });
        </script>    
    </body>
</html>