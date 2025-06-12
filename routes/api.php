<?php

use App\Http\Controllers\reportPostController;
use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Route;
    Route::get('/police/users',[UserController::class,'getUsers'])->middleware('isPolice');
    Route::get('/police/polices',[UserController::class,'getPolice'])->middleware('isPolice');
    Route::get('/police/user/block/{user}',[UserController::class,'blockUser'])->middleware('isPolice');
    Route::get('/police/user/unblock/{user}',[UserController::class,'UnblockUser'])->middleware('isPolice');
    Route::post('/admin/police/create',[UserController::class,'createPolice']);
    Route::post('admin/police/update/{user}',[UserController::class,'updatePolice']);
    Route::delete('admin/police/delete/{user}',[UserController::class,'deletePolice']);
    Route::get('/admin/report/post',[reportPostController::class,'show']);
    Route::get('/admin/report/post/reviewed/{report_post}',[reportPostController::class,'makeReviewed']);
    Route::get('/admin/report/post/rejected/{report_post}',[reportPostController::class,'makeRejected']);
    Route::get('/admin/report/post/warn/{report_post}',[reportPostController::class,'warnUser']);
