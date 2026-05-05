<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'users::landing-page');
Route::livewire('/recipes', 'users::list-recipes');
Route::livewire('/recipes/{slug}', 'users::detail-recipe');
Route::livewire('/manage', 'admin::manage-recipes');
Route::livewire('/add-recipes', 'admin::add-recipes');
Route::livewire('/edit-recipes/{slug}', 'admin::add-recipes'); 