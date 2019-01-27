<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{
    protected $table = 'debitnote';

    public function getDebitnoteNoAttribute($value) 
    {
    	return sprintf("%09s", $value);
    }

    protected function nextDebitNoteNo($merchant_id)
    {
    	$last_debit_note_id = self::join('merchantdebitnote', 'merchantdebitnote.debitnote_id', '=', 'debitnote.id')
    		->where('merchant_id', $merchant_id)
            ->orderBy('debitnote.id', 'desc')
            ->pluck('debitnote_no');

        return sprintf("%09s", ++$last_debit_note_id);
    }
}
