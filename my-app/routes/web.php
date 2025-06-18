<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use  App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts',PostController::class);


Route::post('posts/{post}/comments',[CommentController::class,'store'])->name('comments.store');


//いいね機能

Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
});

Route::get('/contact',[ContactController::class,'index'])->name('contact.index');
Route::post('/contact/confirm',[ContactController::class,'confirm'])->name('contact.confirm');
Route::post('/contact/send',[ContactController::class,'send'])->name('contact.send');
Route::get('/contact/complete',[ContactController::class,'complete'])->name('contact.complete');



require __DIR__.'/auth.php';

