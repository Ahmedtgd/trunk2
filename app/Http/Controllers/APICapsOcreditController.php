<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Ocredit;
class APICapsOcreditController extends Controller
{
    /**
     * Display a listing of the all the posiible combination of number which would lead to the desired sum.
     Updated: Using recursion to reduce solution time.
     *
     * @return \Illuminate\Http\Response
     */

    public $comboArray=[];

    public function lookupOC($user_id=0)
    {
        if ($user_id==0) {
                // When a buyer access its
                $user_id=Auth::user()->id;
            }    
        
        $oc_rows_1=Ocredit::leftJoin('porder','ocredit.porder_id','=','porder.id')
                ->leftJoin('openwish','ocredit.openwish_id','=','openwish.id')
                ->leftJoin('owarehouse','ocredit.owarehouse_id','=','owarehouse.id')
                ->leftJoin('smmout','ocredit.smmout_id','=','smmout.id')
                ->leftJoin('cre','ocredit.cre_id','=','cre.id')
                
                ->where('cre.user_id','=',$user_id)
            
                ->orWhere('openwish.user_id','=',$user_id)
                ->orWhere('smmout.user_id','=',$user_id)
                ->orWhere('porder.user_id','=',$user_id)
                ->where('ocredit.mode','debit')
                ->select('ocredit.*'
                    )

                ;
        $oc_rows_2=Ocredit::join('porderrefno as prr','ocredit.ref_no','=','prr.ref_no')
                            ->join('porder','prr.porder_id','=','porder.id')

                            ->where('porder.user_id','=',$user_id)
                            ->where('ocredit.mode','debit')
                            ->groupBy('prr.ref_no')

                            ->select('ocredit.*'
                    )
                            ;
        $oc_rows= $oc_rows_1->union($oc_rows_2)->get();

        $lookup=array();
        foreach ($oc_rows as $value) {
            $lookup[$value->id]=[$value->value,$value->source];
        }
        return $lookup;
    }

    public function sumCombos($numberArray,$desiredSum,$errorMargin,$partialArray=array())
    {
        

        $sum= array_sum($partialArray);
        $Error= ($errorMargin * $desiredSum);
        $Error=$Error/100;
        $minErrorDesiredSum=$desiredSum-$Error;
        $maxErrorDesiredSum=$desiredSum+$Error;
        // return [gettype($minErrorDesiredSum),gettype($sum),gettype($maxErrorDesiredSum)];

        if ($minErrorDesiredSum<=$sum and  $maxErrorDesiredSum>=$sum) {
            # code...
           $this->comboArray[]=$partialArray;
            // array_push($this->comboArray,$partialArray);
         
        }
      if ($sum>=$maxErrorDesiredSum) {
          return;
      }
      
        for ($i=0; $i <sizeof($numberArray) ; $i++) { 
            $n = $numberArray[$i];
            $remaining= $numberArray;
            array_shift($remaining);  
            // $partialArray[]=$n; This line was the problem
            $temp= $partialArray;
            if (!in_array($n, $partialArray)) {
                # code...
                $temp[]=$n;
                 // array_push($temp,$n);
                 $this->sumCombos($remaining,$desiredSum,$errorMargin,$temp);
            }
           

            
         
        }

   }


   public function subset()
   {
    $result=array();
       foreach ($this->comboArray as $ca) {
            sort($ca);
           if (!in_array($ca,$result)) {
               array_push($result, $ca);
           }
       }
       return $result;
   }

    
}
