<?php
/* OpenSupermall DebiNote Routes */
Route::get('debitnote','DebitNoteController@debitNote');
Route::get('/view_debit_notes/{debt_note_id}','DebitNoteController@viewDebitNote');
Route::post('/save_debit_notes','DebitNoteController@saveDebitNotes');
Route::post('debitnotestatement/merchantdetail','StatementController@merchantdebitnotedetail');
Route::post('debitnotestatement/debitnotereceived','StatementController@debitnotereceived');
?>
