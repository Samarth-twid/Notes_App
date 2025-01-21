<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::post('/notes', [NoteController::class, 'createNote']);
Route::get('/notes', [NoteController::class,'getAllNotes']);
Route::get('/notes/{id}', [NoteController::class,'getNoteById']);
Route::put('/notes/{id}', [NoteController::class,'updateNoteById']);
Route::delete('/notes/{id}', [NoteController::class,'deleteNoteById']);