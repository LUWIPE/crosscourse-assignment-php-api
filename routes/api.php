<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return response()->json([
        'name' => config('app.name'),
        'status' => 'ok',
        'message' => 'API is running',
    ]);
});

Route::get('/schema', function () {
    try {
        $sample_data = [
            'types' => DB::table('types')->limit(3)->get(),
            'grades' => DB::table('grades')->limit(3)->get(),
            'digitals' => DB::table('digitals')->get(),
            'products' => DB::table('products')
                ->select(['id', 'name', 'price', 'release', 'description', 'stock', 'type_id', 'grade_id', 'digital_id'])
                ->limit(5)
                ->get(),
        ];
        $counts = [
            'types' => DB::table('types')->count(),
            'grades' => DB::table('grades')->count(),
            'digitals' => DB::table('digitals')->count(),
            'products' => DB::table('products')->count(),
        ];
        $db_status = 'connected';
    } catch (\Throwable $e) {
        $sample_data = null;
        $counts = null;
        $db_status = 'error (' . get_class($e) . '): ' . $e->getMessage();
    }

    return response()->json([
        'name' => config('app.name'),
        'status' => 'ok',
        'message' => 'Schema overview',
        'database' => $db_status,
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
        'sample_data' => $sample_data,
        'counts' => $counts,
        'migrate_url' => '/api/migrate',
        'migrate_instruction' => 'If database error above, visit /api/migrate to run migrations',
    ]);
});

Route::get('/migrate', function () {
    $has_database_url = filled(env('DATABASE_URL'));
    $has_db_connection = filled(env('DB_CONNECTION'))
        && filled(env('DB_HOST'))
        && filled(env('DB_PORT'))
        && filled(env('DB_DATABASE'))
        && filled(env('DB_USERNAME'));

    if (!$has_database_url && !$has_db_connection) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database environment variables are missing',
            'instructions' => 'Set DATABASE_URL or DB_CONNECTION/DB_HOST/DB_PORT/DB_DATABASE/DB_USERNAME/DB_PASSWORD in Render environment variables',
        ], 400);
    }

    try {
        DB::connection()->getPdo();

        $migrate_exit_code = \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrate_output = \Illuminate\Support\Facades\Artisan::output();

        $seed_exit_code = \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $seed_output = \Illuminate\Support\Facades\Artisan::output();

        return response()->json([
            'status' => 'success',
            'message' => 'Migrations and seeders completed',
            'migrate_exit_code' => $migrate_exit_code,
            'seed_exit_code' => $seed_exit_code,
            'migrate_output' => trim($migrate_output),
            'seed_output' => trim($seed_output),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'error_type' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
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
