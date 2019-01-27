<?php

Route::post('creditnote/stationdetail','CreditNoteController@creditnote');
Route::post('creditnote/stationdetaildealer','CreditNoteController@credit_note_dealer');
Route::get('creditnotedocument/{id}/{cid}','CreditNoteController@creditnotedocument')->name('creditnotedocument');