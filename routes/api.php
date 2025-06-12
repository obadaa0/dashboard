<?php

use App\Http\Controllers\reportPostController;
use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;

    Route::get('/police/users',[UserController::class,'getUsers']);
    Route::get('/police/polices',[UserController::class,'getPolice']);
    Route::get('/police/user/block/{user}',[UserController::class,'blockUser']);
    Route::get('/police/user/unblock/{user}',[UserController::class,'UnblockUser']);
    Route::post('/admin/police/create',[UserController::class,'createPolice']);
    Route::post('admin/police/update/{user}',[UserController::class,'updatePolice']);
    Route::delete('admin/police/delete/{user}',[UserController::class,'deletePolice']);
    Route::get('/admin/report/post',[reportPostController::class,'show'])->middleware('isAdmin');
    Route::post('/admin/report/post/reviewed/{report_post}',[reportPostController::class,'makeReviewed']);
    Route::post('/admin/report/post/rejected/{report_post}',[reportPostController::class,'makeRejected']);
    Route::post('/admin/post/report/warn',[reportPostController::class,'warnUser']);
