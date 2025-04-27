<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\RegisterEventController;
use App\Http\Controllers\ParticipantEventController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Group Route to enforce JSON Response
Route::group(['middleware' => ['json']], function () {
    
    // Unauthenticated Routes
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    // Authenticated Routes users
    Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'verified']], function () {});

    // Authenticated Routes for companies
    Route::group(['prefix' => 'companies', 'middleware' => ['auth:sanctum', 'verified', 'company']], function () {

        Route::prefix('/events-categories')->group(function () {
            Route::get('/', [EventCategoryController::class, 'index']);
            Route::post('/', [EventCategoryController::class, 'store']);
            Route::prefix('/{$category}')->group(function () {
                Route::get('/', [EventCategoryController::class, 'show']);
                Route::post('/', [EventCategoryController::class, 'update']);
                Route::delete('/', [EventCategoryController::class, 'destroy']);
            });
        });

        Route::prefix('/events')->group(function () {
            Route::get('/', [EventController::class, 'index']);
            Route::post('/', [EventController::class, 'store']);
            Route::prefix('/{event}')->group(function () {
                Route::get('/', [EventController::class, 'show']);
                Route::put('/', [EventController::class, 'update']);
                Route::delete('/', [EventController::class, 'destroy']);
            });
        });
    });

    // Authenticated Routes for participants
    Route::group(['prefix' => 'participants', 'middleware' => ['auth:sanctum', 'verified']], function () {
        Route::prefix('/events')->group(function () {
            Route::get('/', [ParticipantEventController::class, 'index']);
            Route::post('/register', [RegisterEventController::class, 'store']);
            Route::prefix('/{event}')->group(function () {
                Route::get('/', [ParticipantEventController::class, 'show']);
            });
        });
        Route::prefix('/events-registered')->group(function () {
            Route::get('/', [RegisterEventController::class, 'index']);
            Route::prefix('/{event}')->group(function () {
                Route::get('/', [RegisterEventController::class, 'show']);
                Route::delete('/', [RegisterEventController::class, 'destroy']);
            });
        });
        
    });
});