<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SchoolClassesController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\MasterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/hello', function () {
    return response()->json([
        'success' => true,
        'message' => 'Laravel 12 API is working!'
    ]);
});

//
Route::get('/apirunningcheck', [MasterController::class, 'apiRuningCheck']);

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgotpassword', [AuthController::class, 'forgotPassword']);
Route::post('/resetpassword', [AuthController::class, 'resetPassword']);

Route::get('/user-list', [AuthController::class, 'user']);


// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::prefix('school-classes')->group(function () {

//     Route::get('/', [SchoolClasses::class, 'index']);
//     Route::post('/create', [SchoolClasses::class, 'store']);
//     Route::get('/{id}', [SchoolClasses::class, 'show']);
//     Route::put('/{id}', [SchoolClasses::class, 'update']);
//     Route::delete('/{id}', [SchoolClasses::class, 'destroy']);

// });
// Route::post('/classes-create', [SchoolClasses::class, 'store']);



Route::prefix('school')->group(function () {
    Route::post('/create-classes', [SchoolClassesController::class, 'store']);
    Route::post('/get-classes', [SchoolClassesController::class, 'index']);
    Route::get('/get-single-classes/{id}', [SchoolClassesController::class, 'showOneClasses']);
    Route::post('/update-classes/{id}', [SchoolClassesController::class, 'update']);
    Route::post('/delete-classes/{id}', [SchoolClassesController::class, 'deleteClasses']);
});
Route::prefix('school')->group(function () {
    Route::post('/students', [StudentController::class, 'store']);
    Route::post('/students-update/{id}', [StudentController::class, 'update']);
    Route::post('/students-status-update/{id}', [StudentController::class, 'updateStatus']);
    Route::get('/students-list', [StudentController::class, 'index']);
    Route::get('/students-list-single/{id}', [StudentController::class, 'show']);
});

// Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

//     Route::get(
//         '/students',
//         [StudentController::class, 'index']
//     );

//     Route::post('/students',[StudentController::class, 'store']);

//     Route::get(
//         '/students/{id}',
//         [StudentController::class, 'show']
//     );

//     Route::put(
//         '/students/{id}',
//         [StudentController::class, 'update']
//     );

//     Route::delete(
//         '/students/{id}',
//         [StudentController::class, 'destroy']
//     );

//     Route::put(
//         '/students/{id}/status',
//         [StudentController::class, 'updateStatus']
//     );
// });

Route::prefix('school')->group(function () {
    Route::post('/teachers-list', [TeacherController::class, 'index']);
    Route::post('/teachers-create', [TeacherController::class, 'store']);
    Route::get('/teachers-list-single/{id}', [TeacherController::class, 'show']);
    Route::put('/teachers-update/{id}', [TeacherController::class, 'update']);
    Route::put('/teachers-status-update/{id}', [TeacherController::class, 'updateStatus']);
});
// Route::prefix('schoolv')->group(function () {
//     Route::get('/teachers-list', [TeacherController::class, 'index']);
//     Route::post('/teachers', [TeacherController::class, 'store']);
//     Route::get('/teachers/{id}', [TeacherController::class, 'show']);
//     Route::put('/teachers/{id}', [TeacherController::class, 'update']);
//     Route::delete('/teachers/{id}', [TeacherController::class, 'destroy']);

//     Route::put(
//         '/teachers/{id}/status',
//         [TeacherController::class, 'updateStatus']
//     );
// });