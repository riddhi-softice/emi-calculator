<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::post('create_loan', [ApiController::class, 'create_loan']);
Route::post('complete_loan', [ApiController::class, 'complete_loan']);

Route::post('test_cron', [ApiController::class, 'test_cron']);
