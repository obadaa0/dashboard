<?php
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
    Route::get('/police/users',[UserController::class,'getUsers']);
    Route::get('/police/polices',[UserController::class,'getPolice']);
    Route::get('/police/user/block/{user}',[UserController::class,'blockUser']);
    Route::get('/police/user/unblock/{user}',[UserController::class,'UnblockUser']);
    Route::post('/admin/police/create',[UserController::class,'createPolice']);
    Route::post('admin/police/update/{user}',[UserController::class,'updatePolice']);
    Route::delete('admin/police/delete/{user}',[UserController::class,'deletePolice']);

