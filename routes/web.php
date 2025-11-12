<?php

use App\Livewire\People\PersonForm;
use App\Livewire\People\Index as PeopleIndex;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/pessoas');
// Route::get('/', function () {
//     return view('index');
// })->name('home');


Route::get('/pessoas', PeopleIndex::class)->name('people.index');
Route::get('/pessoas/criar', PersonForm::class)->name('people.create');

// Route::get('/pessoas/criar', function () {
//     return view('livewire.people.form'); 
// });


Route::get('/pessoas/{personId}/editar', PersonForm::class)->name('people.edit');
