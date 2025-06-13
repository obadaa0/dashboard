<?php

use App\Http\Controllers\reportPostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
    Route::get('/police/users',[UserController::class,'getUsers'])->middleware('isPolice');
    Route::get('/police/polices',[UserController::class,'getPolice'])->middleware('isPolice');
    Route::get('/police/user/block/{user}',[UserController::class,'blockUser'])->middleware('isPolice');
    Route::get('/police/user/unblock/{user}',[UserController::class,'UnblockUser'])->middleware('isPolice');
    Route::post('/admin/police/create',[UserController::class,'createPolice'])->middleware('isAdmin');
    Route::post('admin/police/update/{user}',[UserController::class,'updatePolice'])->middleware('isAdmin');
    Route::delete('admin/police/delete/{user}',[UserController::class,'deletePolice'])->middleware('isAdmin');
    Route::get('/admin/report/post',[reportPostController::class,'show']);
    Route::get('/admin/report/post/reviewed/{report_post}',[reportPostController::class,'makeReviewed']);
    Route::get('/admin/report/post/rejected/{report_post}',[reportPostController::class,'makeRejected']);
    Route::get('/admin/report/post/warn/{report_post}',[reportPostController::class,'warnUser']);
     Route::get('/report/show',[ReportController::class,'show']);//->middleware('isPolice')
    Route::post('/report/create',[ReportController::class,'create']);
    Route::get('report/progress/{report}',[ReportController::class,'setProgress']);
    Route::get('report/resolved/{report}',[ReportController::class,'setResolved']);
    //news
    Route::get('/news/show',[PostController::class,'summarizeNews']);
    //search
    Route::post('/search',[SearchController::class,'search']);
