<?php 

namespace Routes\Custom;

use App\Http\Controllers\Website\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
});