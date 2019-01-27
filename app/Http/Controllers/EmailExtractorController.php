<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmailExtractorController extends Controller
{
  
   public $uname="talhat.haim@gmail.com";
   public $password="qasersaturdayii";
   public $imapurl="{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
   public $client="gmail";
   public $emailCat='SUBJECT "lol" FROM "zurez4u@gmail.com"';
   public $from="zurez4u@gmail.com";
   public function connect()
   {

       try {
           $inbox = imap_open($this->imapurl,$this->uname,$this->password);
       } catch (\Exception $e) {
           dump($e);
           $inbox=array();
       }
        return $inbox;
   }

   public function extractUsefulEmail($inbox)
   {
        $emails = imap_search($inbox,$this->emailCat);
 
$output = '';
 
foreach($emails as $mail) {
    
    $headerInfo = imap_headerinfo($inbox,$mail);
    
    // $output .= $headerInfo->subject.'<br/>';
    // $output .= $headerInfo->toaddress.'<br/>';
    // $output .= $headerInfo->date.'<br/>';
    $output .= $headerInfo->fromaddress.'<br/>';
    // $output .= $headerInfo->reply_toaddress.'<br/>';
    
    // $emailStructure = imap_fetchstructure($inbox,$mail);
    
    if(!isset($emailStructure->parts )) {
         $output .= imap_body($inbox, $mail, FT_PEEK);
    } else {
        //    
    }
   echo $output;
   $output = '';
}
 
// colse the connection
imap_expunge($inbox);
imap_close($inbox);
   }

   public function bootStrap()
   {
       $inbox= $this->connect();
       $this->extractUsefulEmail($inbox);
   }
}
