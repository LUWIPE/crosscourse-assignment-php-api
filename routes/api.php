<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'name' => config('app.name'),
        'status' => 'ok',
        'message' => 'API is running',
    ]);
});

Route::get('/schema', function () {
    return response()->json([
        'name' => config('app.name'),
        'status' => 'ok',
        'message' => 'Schema overview',
        'schema' => [
            'tables' => [
                'types' => ['id', 'name', 'description', 'created_at', 'updated_at'],
                'grades' => ['id', 'name', 'description', 'created_at', 'updated_at'],
                'digitals' => ['id', 'name', 'created_at', 'updated_at'],
                'products' => [
                    'id',
                    'name',
                    'price',
                    'release',
                    'description',
                    'stock',
                    'img_url',
                    'type_id',
                    'grade_id',
                    'digital_id',
                    'created_at',
                    'updated_at',
                ],
            ],
            'relations' => [
                'products.type_id -> types.id',
                'products.grade_id -> grades.id',
                'products.digital_id -> digitals.id',
                'Product belongsTo Type',
                'Product belongsTo Grade',
                'Product belongsTo Digital',
                'Type hasMany Product',
                'Grade hasMany Product',
                'Digital hasMany Product',
            ],
        ],
    ]);
});

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    });

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

// Public routes
Route::apiResource('events', EventController::class)
    ->only(['index', 'show']);

// Protected routes
Route::apiResource('events', EventController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware(['auth:sanctum', 'throttle:api']);

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::apiResource('events.attendees', AttendeeController::class)
        ->scoped()
        ->only(['store', 'destroy']);
});

Route::apiResource('events.attendees', AttendeeController::class)
    ->scoped()
    ->only(['index', 'show']);
