<?php

use App\Livewire\Extra\Data as ExtraData;
use App\Livewire\Leader\Data;
use App\Livewire\Student\Data as StudentData;
use App\Livewire\Student\FormEdit;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/leader', Data::class)->name('leader.index');

Route::get('/student', StudentData::class)->name('student.index');
Route::get('/student/{id}/edit', FormEdit::class)->name('student.edit');

Route::get('/extra', ExtraData::class)->name('extra.index');
