<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class OcreditvalidationController extends Controller
{
    public $debug=False;
    public function get_priority_order()
    {
        return ["openwish","hyper","cre","smm"];
    }

    public function get_fundtype($source,$user_id=null)
    {

        $where_on_source="";
        $join_on_source="";
        $select_on_source="";
        if (!Auth::user()->hasRole('adm')) {
            $user_id=Auth::user()->id;
        }
        switch ($source) {
            case 'smm':
                $join_on_source=" JOIN smmout on ocredit.smmout_id= smmout.id
                 JOIN product on smmout.product_id = product.id
                 ";
                $where_on_source=" AND ocredit.source='smm' AND smmout.user_id=".$user_id;
                break;
            
            default:
                # code...
                break;
        }
        $ret=array();
        try {
            $ret=DB::select(DB::raw("
            SELECT ocredit.* 
            FROM ocredit
            LEFT JOIN ocredit_debit_log as odl on odl.debited_from = ocredit.id
            ".$join_on_source."
            WHERE 
            odl.debited_from=null
            AND ocredit.mode='credit'
            AND ocredit.deleted_at=null
            ".$where_on_source));
        } catch (\Exception $e) {
            
        }
        return $ret;
    }

    public function get_matches($ocredit_amount,$user_id=null)
    {
        // if (Auth::check() and Auth::user()->hasRole('adm')) {
            
        // }
        $ocredits=OpenCreditController::get_ocredit($user_id);
        if ($this->debug) {
            // dump($ocredits);
        }
        /*In order of priority.*/ 
        $matches=array();
        $amount_left=$ocredit_amount;
        $priority=$this->get_priority_order();
        $source=$priority[0];
        if ($this->debug) {
            dump($source);
        }
        foreach ($ocredits as $o) {
            if ($o->source==$source and $o->mode=="credit" and $amount_left!=0) {
                 /*Check if the $o record has been tagged i.e can be used or not.*/
                 if ($this->debug) {
                     dump($amount_left);
                 }
                 $tmp_sum=0;
                 $tmp=DB::table('ocredit_debit_log')->where('debited_from',$o->id)->get();
                foreach($tmp as $t){$tmp_sum+=$t->value;}
                 if ($this->debug) {
                     dump($tmp_sum);
                 }
                 $tmp_match=array();
                 if ($tmp_sum < $o->value or empty($tmp_sum)) {
                      /*This record can be tagged , but we need to find by how much*/
                      if($this->debug)  dump("Reached Inner Loop");
                      if (empty($tmp_sum)) {
                           $taggable_amount=$o->value;
                       }
                       else{$taggable_amount=$tmp_sum->value-$o->value;}
                        $amount_left-=$taggable_amount;
                        $tmp_match["ocredit_id"]=$o->id;
                        $tmp_match["value"]=$taggable_amount;
                        $tmp_match["source"]=$o->source;
                        array_push($matches,$tmp_match);
                       
                  } 
            }
        }
        $source=$priority[1];
        if ($this->debug) {
            dump($source);
        }
        foreach ($ocredits as $o) {
            if ($o->source==$source and $o->mode=="credit" and $amount_left!=0) {
                 /*Check if the $o record has been tagged i.e can be used or not.*/
                 if ($this->debug) {
                     dump($amount_left);
                 }
                 $tmp_sum=0;
                 $tmp=DB::table('ocredit_debit_log')->where('debited_from',$o->id)->get();
                foreach($tmp as $t){$tmp_sum+=$t->value;}
                 if ($this->debug) {
                     dump($tmp_sum);
                 }
                 $tmp_match=array();
                 if ($tmp_sum < $o->value or empty($tmp_sum)) {
                      /*This record can be tagged , but we need to find by how much*/
                      if($this->debug)  dump("Reached Inner Loop");
                      if (empty($tmp_sum)) {
                           $taggable_amount=$o->value;
                       }
                       else{$taggable_amount=$tmp_sum->value-$o->value;}
                        $amount_left-=$taggable_amount;
                        $tmp_match["ocredit_id"]=$o->id;
                        $tmp_match["value"]=$taggable_amount;
                        $tmp_match["source"]=$o->source;
                        array_push($matches,$tmp_match);
                       
                  } 
            }
        }

        $source=$priority[2];
        if ($this->debug) {
            dump($source);
        }
        foreach ($ocredits as $o) {
            if ($o->source==$source and $o->mode=="credit" and $amount_left!=0) {
                 /*Check if the $o record has been tagged i.e can be used or not.*/
                 if ($this->debug) {
                     dump($amount_left);
                 }
                 $tmp_sum=0;
                 $tmp=DB::table('ocredit_debit_log')->where('debited_from',$o->id)->get();
                foreach($tmp as $t){$tmp_sum+=$t->value;}
                 if ($this->debug) {
                     dump($tmp_sum);
                 }
                 $tmp_match=array();
                 if ($tmp_sum < $o->value or empty($tmp_sum)) {
                      /*This record can be tagged , but we need to find by how much*/
                      if($this->debug)  dump("Reached Inner Loop");
                      if (empty($tmp_sum)) {
                           $taggable_amount=$o->value;
                       }
                       else{$taggable_amount=$tmp_sum->value-$o->value;}
                        $amount_left-=$taggable_amount;
                        $tmp_match["ocredit_id"]=$o->id;
                        $tmp_match["value"]=$taggable_amount;
                        $tmp_match["source"]=$o->source;
                        array_push($matches,$tmp_match);
                       
                  } 
            }
        }
        
        $source=$priority[0];
        if ($this->debug) {
            dump($source);
        }
        foreach ($ocredits as $o) {
            if ($o->source==$source and $o->mode=="credit" and $amount_left!=0) {
                 /*Check if the $o record has been tagged i.e can be used or not.*/
                 if ($this->debug) {
                     dump($amount_left);
                 }
                 $tmp_sum=0;
                 $tmp=DB::table('ocredit_debit_log')->where('debited_from',$o->id)->get();
                foreach($tmp as $t){$tmp_sum+=$t->value;}
                 if ($this->debug) {
                     dump($tmp_sum);
                 }
                 $tmp_match=array();
                 if ($tmp_sum < $o->value or empty($tmp_sum)) {
                      /*This record can be tagged , but we need to find by how much*/
                      if($this->debug)  dump("Reached Inner Loop");
                      if (empty($tmp_sum)) {
                           $taggable_amount=$o->value;
                       }
                       else{$taggable_amount=$tmp_sum->value-$o->value;}
                        $amount_left-=$taggable_amount;
                        $tmp_match["ocredit_id"]=$o->id;
                        $tmp_match["value"]=$taggable_amount;
                        $tmp_match["source"]=$o->source;
                        array_push($matches,$tmp_match);
                       
                  } 
            }
        }

        return $matches;

    }


}
