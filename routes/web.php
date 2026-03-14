<?php

use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => to_route('tasks.index'))->name('home');
Route::resource('tasks', TasksController::class);
Route::patch('tasks/{task}/toggle', [TasksController::class, 'toggle'])->name('tasks.toggle');
