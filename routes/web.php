<?php

use App\Http\Controllers\ResumesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ResumesController::class, 'show'])->name('show');
Route::get('/add', [ResumesController::class, 'add'])->name('add');
Route::post('/add/create', [ResumesController::class, 'store'])->name('add.create');
Route::delete('/delete/{id}', [ResumesController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [ResumesController::class, 'edit'])->name('edit');
Route::put('/edit/update/{id}', [ResumesController::class, 'update'])->name('update.cv');
Route::get('/preview/{id}', [ResumesController::class, 'preview'])->name('preview');
