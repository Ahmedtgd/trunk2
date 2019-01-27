<?php 
function notEmpty($dat){

return !empty($dat)?$dat:0;
}
function convertToEpos($date,$start_time="",$end_time="",$start=true){
    $converted=explode(":",$date);
    //0 for hours, 1 for minutes , 2 for seconds
    $time= $converted[0].$converted[1].$converted[2];
    $day=date("j");
    $months=date("n");    
    $year=date("Y");
    if(!empty($start_time) && !empty($end_time)){
    if(strtotime($start_time)>strtotime($end_time)){
       if($start){
       $day=date("j",strtotime("-1 day"));
       }
    }
  }
   return mktime(notEmpty($converted[0]),notEmpty($converted[1]),notEmpty($converted[2]),$months,$day,$year);
}
 $start_time = convertToEpos($terminal->start_work,$terminal->start_work,$terminal->end_work);
 $end_time = convertToEpos($terminal->end_work);
 $current_time=convertToEpos(date("H:i:s"));
