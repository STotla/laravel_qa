<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        
    ]);
});
Route::get('/about-us', function () {
    return Inertia::render('Aboutus', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
     
    ]);
})->name('aboutus');

Route::middleware('auth')->group(function () {
    Route::get('/notifications',[NotificationsController::class,'index'])->name('notifications.index');
    Route::get('/notifications/mark-all-read',[NotificationsController::class,'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/mark-as-read/{id}',[NotificationsController::class,'markAsRead'])->name('notifications.markAsRead');
    Route::resource('/questions', QuestionsController::class, ['except' => ['index','show']]);
    Route::patch('/questions/{question}/best-answer', [QuestionsController::class, 'updateBestAnswer'])->name('questions.updateBestAnswer');
    // Route::resource('/questions',QuestionsController::class);
    Route::patch('/questions/{question}/updatefavorite', [QuestionsController::class,'updateFavoriteStatusofQuestion'])->name('questions.updateFavoriteStatusofQuestion');
    Route::resource('/answer',AnswerController::class);
    Route::patch('/answer/{answer}',[AnswerController::class,'update'])->name('answer.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/questions/{question}/vote',[App\Http\Controllers\VoteQuestionController::class,'__invoke'])->name('questions.vote');
    Route::post('/answer/{answer}/vote',[App\Http\Controllers\VoteAnswerController::class,'__invoke'])->name('answer.vote');
});

Route::get('/questions/search',[QuestionsController::class,'search']);
Route::get('/questions/{question:slug}',[QuestionsController::class,'show'])->name('questions.show'); 


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::get('/questions', [QuestionsController::class, 'index'])->name('questions.index');
// Route::resource('/questions', QuestionsController::class);

require __DIR__.'/auth.php';
